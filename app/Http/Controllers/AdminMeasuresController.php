<?php

namespace App\Http\Controllers;

use App\Measure;
use App\Station;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class AdminMeasuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collect_stations = array();

        $stations = Station::all();


        foreach ($stations as $station) {
            if (count($station->measures) > 0) {
                $collect_stations[] = $station->id;
            }
        }

        $collection =  Station::find($collect_stations)->pluck('name', 'id')->all();


        return view('admin.measures.index', compact('collection'));


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

        return redirect()->route('admin.measures.show', ['id' => $id]);
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

        if(count($station->measures) > 0){

             $collection_series = $station->measures()->max('collection');

             $station_last_coll_of_measures =  $station->measures()->where('collection', $collection_series)->get();


              $collect_stations = array();

              $stations = Station::where('id', '!=', $station->id)->get();

                foreach ($stations as $station) {
                    if (count($station->measures) > 0) {
                        $collect_stations[] = $station->id;
                    }
                }

              $collection =  Station::find($collect_stations)->pluck('name', 'id')->all();


              return view('admin.measures.show', compact('st', 'station_last_coll_of_measures', 'collection'));

        }else{

            $station_last_coll_of_measures = array();
            $collection = array();
            return view('admin.measures.show', compact('st', 'station_last_coll_of_measures', 'collection'));
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
