<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->prefix = config('cache.prefix');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
