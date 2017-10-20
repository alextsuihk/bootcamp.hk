<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workshop;
use App\Level;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUpdateWorkshop;

class WorkshopController extends Controller
{
    public function __construct()
    {
        // AT-Pending: enable admin middleware
//        $this->middleware('admin')->except(['index', 'show']);   // except index & show, other methods need auth()
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
/*        $workshops = Cache::remember('WorkshopAllSortByNumber', 5, function() {
            return Workshop::all()->sortBy('number');             
        });*/
                                            // only caching for read-only (index & show)
        $workshops = Cache::remember('WorkshopWithLevelSortByNumber', 5, function() {
            return Workshop::with('level')->get()->sortBy('number');
        });                     // turn on eager loading

        return view('workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::getAllLevel();
        $edit = null;                   // because the same form is shared for "create" & "edit" 
                                        // we also add a custom helper in \app\Helpers\Helper.php 
        return view('workshops.create', compact(['levels', 'edit']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(StoreUpdateWorkshop $request) // use type-hints Requests & do rule validatio
    {
        //Workshop::create(request(['number', 'title', 'abstract', 'level_id', 'is_active']) );
        // stupid bootstrap returns "on" for checkbox, cannot use mass assignment

        $workshop = Workshop::create([ 
            'number' => request('number'),
            'title' => request('title'),
            'abstract' => request('abstract'),
            'level_id' => request('level_id'),
            'is_active' => ($request->is_active ? true : false ),
        ]);

        session()->flash('message','A new workshop is added');
        
        //return redirect('/workshops/'.$workshop->id);     // let do it is Laravel way
        return redirect()->route('workshops.show', [$workshop->number]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_old($id)
    {
        // AT-Pending: pending refactoring
        // only cache & eager loading Workshop & Lession
        // user enrollment will be using lazy loading
        $key = 'Workshop_'.$id;         
        $workshop = Cache::remember($key, 5, function() use ($id) {
            return Workshop::with(['level','lessons'])->find($id);
        });                                 // turn on eager loading
        dd($workshop);
        return view('workshops.show', compact('workshop'));
    }

    public function show($number)           
                                // we fool the system, we are search by number (workshop number)
    {

        // AT-Pending: pending refactoring
        // only cache & eager loading Workshop & Lession
        // user enrollment will be using lazy loading
        
        $key = 'Workshop_'.$number;         
        $workshop = Cache::remember($key, 5, function() use ($number) {
            return Workshop::with(['level','lessons'])->where('number', '=', $number)->first();
        });                                 // turn on eager loading
        return view('workshops.show', compact('workshop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Workshop::find($id);        // pull original data
        $levels = Level::getAllLevel();
        
        return view('workshops.edit', compact(['edit', 'levels']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(StoreUpdateWorkshop $request, $id)   // type-hinted & do rule validation
    {
        $workshop = Workshop::find($id);    // pull original data

        $workshop->number = $request->number;
        $workshop->title = $request->title;
        $workshop->abstract = $request->abstract;
        $workshop->level_id = $request->level_id;
        $workshop->is_active = ($request->is_active ? true : false );

        $workshop->save();

        session()->flash('message','Workshop detail is updated');
        // flush cache 'Workshop_'.$id

        return redirect()->route('workshops.show', $workshop->number);
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
