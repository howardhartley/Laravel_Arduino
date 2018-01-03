<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Category;
use App\Measure;
use App\Station;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;





Route::get('/', function () {
    return view('welcome');
});




//**********  Account verification area **************//

Route::get('account/verify/{code}', function ($code) {

    $user = User::where('confirmation', $code)->firstOrFail();

    if($user){

        if($user->confirmation == ''){
            return view('errors.404');
        }

        $user->confirmed = 1;
        $user->is_active = 1;
        $user->confirmation = '';
        $user->save();
        Session::flash('Activated', 'Συγχαρητήρια! Ο λογαριασμός σας έχει ενεργοποιηθεί.');
        return redirect('/');

    }else{
        return view('errors.404');
    }

});




//********** Collection Measures checkpoint area **************//


Route::get('measures/input', function(Request $request){

     if($station = Station::where('unique', $request->unique)->first()){
        if($station->is_active){
            if(count($station->categories) > 0){
              $input = $request->all();
              $col = Measure::max('collection') + 1;
               foreach ($station->categories as $category){
                   if(array_key_exists($category->name, $input)){
                       if(!empty($input[$category->name])){
                            Measure::create(['category_id' => $category->id, 'station_id' => $station->id, 'collection' => $col, 'value' => $input[$category->name]]);
                       }
                   }
               }
            }
        }
     }
});







//**********  Authenticate  **************//

Route::auth();




Route::get('/home', 'HomeController@index');




    //**********  Middleware checkpoint (Admin - User)  **************//


Route::group(['middleware' => 'isAdmin'], function(){


    //**********  User area  **************//
















    //**********  Admin area  **************//


    //*****  Main page  *********//

    Route::get('admin', ['as' => 'admin.index', function(){

        $users_stations_sum=  0;
        $admin_stations_sum=  0;
        $sum = 0;
        $name = Auth::user()->name;
        $stations = Station::all();
        $users = User::all();
        $categories = Category::all();
        $measures = Measure::all();
        $min_col = Measure::min('collection');
        $max_col = Measure::max('collection');

        for($i = $min_col; $i <= $max_col; $i++){
            if(count(Measure::where('collection', $i)->get())){$sum++;}
        }

        foreach($stations as $station){
            if($station->user->role_id == 1){$admin_stations_sum++;}else{$users_stations_sum++;}
        }

        return view('admin.index', compact('name', 'stations', 'users', 'categories', 'measures', 'sum', 'admin_stations_sum', 'users_stations_sum'));
    }]);



    //*****  All controllers *********//

    Route::resource('admin/users', 'AdminUsersController');
    Route::resource('admin/stations', 'AdminStationsController');
    Route::resource('admin/categories', 'AdminCategoriesController');
    Route::resource('admin/profile', 'AdminProfileController');
    Route::get('admin/profile/{id}/edit_password', ['as' => 'admin.profile.edit.password', 'uses' => 'AdminProfileController@edit_password']);
    Route::patch('admin/profile/{id}/update_password', ['as' => 'admin.profile.update.password', 'uses' => 'AdminProfileController@update_password']);
    Route::resource('admin/measures', 'AdminMeasuresController');
    Route::resource('admin/history', 'AdminHistoryController');
    Route::get('admin/history/{collection}/measures', ['as' => 'admin.history.show.measures', 'uses' => 'AdminHistoryController@show_measures']);


});











//******* Για να στειλουμε email σε καποιον και να περασει θα πρεπει πρωτα να κανουμε authorise
//******* το email του στο mailgun αλλιως το κανει drop

//Route::get('/mail', function () {
//
//
//    $data = [
//
//        'title' => 'Hello i am the title',
//        'content' => 'Hello again i am the content'
//
//    ];
//
//    Mail::send('auth.emails.verify', $data, function($message){
//
//        $message->to('st0493@icte.uowm.gr', 'Vasileios')->subject('Hello i am the subject');
//
//    });
//
//
//
//});
