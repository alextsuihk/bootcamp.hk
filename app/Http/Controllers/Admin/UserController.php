<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->prefix = config('cache.prefix');
        $key = $this->prefix.'AllUsers';
        Cache::forget($key);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::getAllUsers()->sortByDesc('created_at');

        if ($request->filled('keywords')) {          // query-string has "keywords"
            // convert keywords from string to array. delimiter either " " or ","
            $keywords = $request->keywords;
            $search = preg_split( '/[,\s]+/', $request->keywords);

            $users = $users->filter(function ($value, $key) use ($search) {
                $matched = false;
                foreach ($search as $keyword) 
                {
                    if (stripos($value->name, $keyword) !== FALSE || stripos($value->nickname, $keyword) !==false 
                        || stripos($value->email, $keyword) !== false)
                    {   
                        $matched = true;
                        break;
                    }
                }
                return $matched;
            });
        } else {
            $keywords = 'Search... ';                  // index & search use the same view
        }


        return view('admin.users.index', compact(['users', 'keywords']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with(['lessons', 'questions', 'comments', 'follow_courses'])->find($id);
        return view('admin.users.edit', compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nickname' => 'sometimes|max:20',
            'name'     => 'required|max:20',
            'email'    => 'required|email',
            'mobile'   => 'nullable|digits:8',
            'disabled' => 'sometimes',
        ]);

        $count = User::where('mobile', $validatedData['mobile'])->where('id', '!=', $id)->count();
        if ($count > 0)
        {
            return redirect()->back()
                        ->withErrors(['mobile' => 'The mobile phone is using used by another person'])
                        ->withInput();
        }

        $user = User::getAllUsers()->find($id);

        $user->nickname = $validatedData['nickname'];
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->mobile = $validatedData['mobile'];
        $user->disabled = ($request->disabled ? true : false );
        $user->save();


        $key = $this->prefix.'AllUsers';
        Cache::forget($key);        // flush 'courses' cache (no need to wait to expire)

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','User detail is updated');
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        Auth::user()->setImpersonating($id);
        return redirect()->route('courses.index');
    }

    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','<center><strong>Exited Impersonation Mode, return to normal</strong></center>');

        return redirect()->back();
    }

}
