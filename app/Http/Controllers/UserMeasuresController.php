<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserMeasuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collect_stations = array();

        $user_stations = Station::where('user_id', Auth::user()->id)->get();
        $all_stations = Station::where('user_id', '!=' , Auth::user()->id)->where('is_private', 0)->get();

        $stations = $user_stations->merge($all_stations);


        foreach ($stations as $station) {
            if (count($station->measures) > 0) {
                $collect_stations[] = $station->id;
            }
        }

        $collection =  Station::find($collect_stations)->pluck('name', 'id')->all();


        return view('user.measures.index', compact('collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'station_id' => 'required'
        ]);

        $id = $request->station_id;

        return redirect()->route('user.measures.show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $st = $station = Station::findOrFail($id);

        if($station->user_id != Auth::user()->id && $station->is_private == 1){
            return view('errors.404');
        }

        if(count($station->measures) > 0){

            $collection_series = $station->measures()->max('collection');

            $station_last_coll_of_measures =  $station->measures()->where('collection', $collection_series)->get();


            $collect_stations = array();


            $user_stations = Station::where('user_id', Auth::user()->id)->where('id', '!=', $station->id)->get();
            $all_stations = Station::where('user_id', '!=' , Auth::user()->id)->where('is_private', 0)->get();

            $stations = $user_stations->merge($all_stations);

            foreach ($stations as $station) {
                if (count($station->measures) > 0) {
                    $collect_stations[] = $station->id;
                }
            }

            $collection =  Station::find($collect_stations)->pluck('name', 'id')->all();


            return view('user.measures.show', compact('st', 'station_last_coll_of_measures', 'collection'));

        }else{

            $station_last_coll_of_measures = array();
            $collection = array();
            return view('user.measures.show', compact('st', 'station_last_coll_of_measures', 'collection'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.404');
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
        return view('errors.404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('errors.404');
    }
}
