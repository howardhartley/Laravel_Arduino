<?php

namespace App\Http\Controllers;

use App\Measure;
use App\Station;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class AdminHistoryController extends Controller
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


        return view('admin.history.index', compact('collection'));
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

        return redirect()->route('admin.history.show', ['id' => $id]);
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

            $num_of_collections = new Collection();


              $collection_series_min = $station->measures()->min('collection');
              $collection_series_max = $station->measures()->max('collection');

              for($i = $collection_series_min; $i <= $collection_series_max; $i++){
                  if(count($station->measures()->where('collection', $i)->get())){
                      $num_of_collections[] = $i;
                  }
              }

            $pag_num_of_collections = ($num_of_collections)->reverse()->paginate(5);


            $collect_stations = array();

            $stations = Station::where('id', '!=', $station->id)->get();

            foreach ($stations as $station) {
                if (count($station->measures) > 0) {
                    $collect_stations[] = $station->id;
                }
            }

            $collection =  Station::find($collect_stations)->pluck('name', 'id')->all();


            return view('admin.history.show', compact('st', 'pag_num_of_collections', 'collection'));

        }else{

            $pag_num_of_collections = array();
            $collection = array();
            return view('admin.history.show', compact('st', 'pag_num_of_collections', 'collection'));
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
    public function destroy($measure)
    {
        $station = Measure::where('collection', $measure)->first()->station_id;
        Measure::where('collection', $measure)->delete();
        Session::flash('delete', 'Η συλλογή μετρήσεων έχει διαγραφεί.');
        return redirect()->route('admin.history.show', ['id' => $station]);
    }



    public function show_measures($collection){
        $measures = Measure::where('collection', $collection)->get();
        if(count($measures)){

            $station_name = Station::findOrFail($measures->first()->station_id)->name;

            return view('admin.history.show_measures', compact('collection', 'measures', 'station_name'));
        }else{
            return view('errors.404');
        }
    }


}
