<?php

namespace App\Http\Controllers;

use App\Category;
use App\Station;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserStationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = Station::where('user_id', Auth::user()->id)->get()->paginate(5);
        return view('user.stations.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        return view('user.stations.create', compact('categories'));
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
            'unique'        => 'required|unique:stations|max:255',
            'name'          => 'required|unique:stations|max:255',
            'is_active'     => 'required',
            'is_private'    => 'required',
            'description'   => 'max:255',
            'location'      => 'required|max:255'
        ]);


        $input['unique'] = trim($request->unique);
        $input['name'] = trim($request->name);
        $input['user_id'] = Auth::user()->id;
        $input['is_active'] = $request->is_active;
        $input['is_private'] = $request->is_private;
        if(trim($request->description) == ''){
            $input['description'] = 'Δεν έχει δοθεί περιγραφή';
        }else{
            $input['description'] = trim($request->description);
        }
        $input['location'] = trim($request->location);

        $station = Station::create($input);

        if(isset($request->checkbox_array)){

            foreach($request->checkbox_array as $value){
                $station->categories()->attach($value);
            }

        }
        Session::flash('complete', 'Ο σταθμός έχει δημιουργηθεί.');
        return redirect('user/stations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $station = Station::findOrFail($id);

        if($station->user_id != Auth::user()->id){
            return view('errors.404');
        }

        $user = Auth::user();
        $categories = Category::all();

        return view('user.stations.edit', compact('station', 'user', 'categories'));
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
        $station = Station::findOrFail($id);

        if($station->unique == trim($request->unique) && $station->name == trim($request->name) && $station->is_active == $request->is_active && $station->is_private == $request->is_private && $station->description == trim($request->description)
            && $station->location == trim($request->location) && count($station->categories()->get()) == count($request->checkbox_array)){

            if(count($request->checkbox_array) == 0){
                $result = false;
                //hasn't changed
            }else {
                $temp = true;
                foreach($station->categories as $category){
                    if (!in_array($category->id, $request->checkbox_array)) {
                        $temp = false;
                    }
                }
                if ($temp == false){
                    $result = true;
                    //has changed
                }else{
                    $result = false;
                    //hasn't changed
                }
            }

        }else{
            $result = true;
            //has changed
        }


        if($result){

            if($station->unique == trim($request->unique) && $station->name == trim($request->name)){

                $this->validate($request, [
                    'is_active'     => 'required',
                    'is_private'    => 'required',
                    'description'   => 'max:255',
                    'location'      => 'required|max:255'
                ]);

            }elseif($station->unique == trim($request->unique) && $station->name != trim($request->name)){

                $this->validate($request, [
                    'name'          => 'required|unique:stations|max:255',
                    'is_active'     => 'required',
                    'is_private'    => 'required',
                    'description'   => 'max:255',
                    'location'      => 'required|max:255'
                ]);

            }elseif($station->unique != trim($request->unique) && $station->name == trim($request->name)){

                $this->validate($request, [
                    'unique'        => 'required|unique:stations|max:255',
                    'is_active'     => 'required',
                    'is_private'    => 'required',
                    'description'   => 'max:255',
                    'location'      => 'required|max:255'
                ]);

            }else{

                $this->validate($request, [
                    'unique'        => 'required|unique:stations|max:255',
                    'name'          => 'required|unique:stations|max:255',
                    'is_active'     => 'required',
                    'is_private'    => 'required',
                    'description'   => 'max:255',
                    'location'      => 'required|max:255'
                ]);
            }


            $input['unique'] = trim($request->unique);
            $input['name'] = trim($request->name);
            $input['is_active'] = $request->is_active;
            $input['is_private'] = $request->is_private;
            if(trim($request->description) == ''){
                $input['description'] = 'Δεν έχει δοθεί περιγραφή';
            }else{
                $input['description'] = trim($request->description);
            }
            $input['location'] = trim($request->location);

            $station->update($input);

            if(isset($request->checkbox_array)){

                if(count($station->categories()->get()) > 0){

                    foreach($station->categories as $category){
                        $collect[] = $category->id;
                        if (!in_array($category->id, $request->checkbox_array)){
                            $station->categories()->detach($category->id);
                        }
                    }


                    foreach($request->checkbox_array as $value){
                        if(!in_array($value, $collect)){
                            $station->categories()->attach($value);
                        }
                    }


                }else{

                    foreach($request->checkbox_array as $value){
                        $station->categories()->attach($value);
                    }

                }



            }else{
                if(count($station->categories()->get()) > 0){
                    $station->categories()->detach();
                }

            }


            Session::flash('update', 'Ο σταθμός έχει ανανεωθεί.');
            return redirect('user/stations');




        }else{
            Session::flash('nothing', 'Δεν πραγματοποιήθηκε κάποια αλλαγή.');
            return redirect('user/stations');
        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Station::findOrFail($id)->delete();
        Session::flash('delete', 'Ο σταθμός έχει διαγραφεί.');
        return redirect()->back();
    }
}
