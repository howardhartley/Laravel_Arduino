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
use App\Log;
use App\Measure;
use App\Station;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;




//**********  Authentication check and redirect area **************//


Route::get('/', function () {

    if(Auth::check()){
        if(Auth::user()->isAdmin()){
            return redirect('admin');
        }else{
            return redirect('user');
        }
    }
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

              $category_sum_check = false;
              $input_sum_check = false;
              $errors_check = false;
              $success = false;

              $input = $request->all();

              $col = Measure::max('collection') + 1;
               foreach ($station->categories as $category){
                       if(array_key_exists($category->name, $input)){
                           if(!empty($input[$category->name])){
                                Measure::create(['category_id' => $category->id, 'station_id' => $station->id, 'collection' => $col, 'value' => $input[$category->name]]);
                               //success
                                $success = true;
                           }else{
                               //null variable or missing
                               $errors_check = true;
                           }
                       }else{
                           //existing category doesn't exist in url;
                           $category_sum_check = true;
                       }
               }

               if(count($station->categories) < (count($input) - 1)){
                   //more url variables than categories
                   $input_sum_check = true;
               }


               if($success){
                  if($errors_check && $category_sum_check && $input_sum_check){
                      Log::create(['goodtobad' => '2',
                                   'note'      => 'Επιτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Υπενθύμιση: * Έχουν σταλλεί μηδενικές τιμές * Υπάρχουν λανθασμένα κομμάτια στο URL αποστολής',
                                   'user_id'   => $station->user_id]);

                  }elseif($category_sum_check || $input_sum_check){
                      Log::create(['goodtobad' => '2',
                                   'note'      => 'Επιτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Υπενθύμιση: * Υπάρχουν λανθασμένα κομμάτια στο URL αποστολής',
                                   'user_id'   => $station->user_id]);

                  }elseif($errors_check){
                      Log::create(['goodtobad' => '2',
                                   'note'      => 'Επιτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Υπενθύμιση: * Έχουν σταλλεί μηδενικές τιμές',
                                   'user_id'   => $station->user_id]);

                  }else{
                      Log::create(['goodtobad' => '1',
                                   'note'      => 'Επιτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'',
                                   'user_id'   => $station->user_id]);

                  }
               }else{
                   if($errors_check && $category_sum_check && $input_sum_check){
                       Log::create(['goodtobad' => '3',
                                    'note'      => 'Αποτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Αιτία: * Έχουν σταλλεί μηδενικές τιμές * Υπάρχουν λανθασμένα κομμάτια στο URL αποστολής',
                                    'user_id'   => $station->user_id]);

                   }elseif($category_sum_check || $input_sum_check){
                       Log::create(['goodtobad' => '3',
                                    'note'      => 'Αποτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Αιτία: * Υπάρχουν λανθασμένα κομμάτια στο URL αποστολής',
                                    'user_id'   => $station->user_id]);

                   }elseif($errors_check){
                       Log::create(['goodtobad' => '3',
                                    'note'      => 'Αποτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Αιτία: * Έχουν σταλλεί μηδενικές τιμές',
                                    'user_id'   => $station->user_id]);
                   }
               }
            }else{
                //no categories
                Log::create(['goodtobad' => '3',
                             'note'      => 'Αποτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Αιτία: Δεν υπάρχουν επιλεγμένες κατηγορίες για τον σταθμό',
                             'user_id'   => $station->user_id]);
            }
        }else{
            //station inactive
            Log::create(['goodtobad' => '3',
                         'note'      => 'Αποτυχία συλλογής μετρήσεων. * Σταθμός: '.$station->name.'   * Ημερομηνία: '.Carbon::now().'   * Αιτία: Ο σταθμός είναι ανενεργός',
                         'user_id'   => $station->user_id]);
        }
     }
});







//**********  Authenticate  **************//

Route::auth();





//**********  Middleware checkpoint User area  **************//





Route::group(['middleware' => 'isUser'], function(){





    //*****  Main page  *********//



    Route::get('user', ['as' => 'user.index', function(){

        $last_user_log = Log::where('user_id', Auth::user()->id)->get()->last();
        $user_stations = Station::where('user_id', Auth::user()->id)->get();

        return view('user.index', compact('last_user_log', 'user_stations'));
    }]);





    //*****  All controllers *********//


    Route::resource('user/stations', 'UserStationsController');
    Route::resource('user/categories', 'UserCategoriesController');
    Route::resource('user/measures', 'UserMeasuresController');
    Route::resource('user/history', 'UserHistoryController');
    Route::get('user/history/{collection}/measures', ['as' => 'user.history.show.measures', 'uses' => 'UserHistoryController@show_measures']);
    Route::get('user/updates/user', ['as' => 'user.updates.user', 'uses' => 'UserUpdatesController@user']);
    Route::delete('user/updates/{id}', ['as' => 'user.updates.destroy', 'uses' => 'UserUpdatesController@destroy']);
    Route::resource('user/profile', 'UserProfileController');
    Route::get('user/profile/{id}/edit_password', ['as' => 'user.profile.edit.password', 'uses' => 'UserProfileController@edit_password']);
    Route::patch('user/profile/{id}/update_password', ['as' => 'user.profile.update.password', 'uses' => 'UserProfileController@update_password']);

});










//**********  Middleware checkpoint Admin area  **************//






Route::group(['middleware' => 'isAdmin'], function(){





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

         $last_all_log = Log::all()->last();
         $last_user_log = Log::where('user_id', Auth::user()->id)->get()->last();



       return view('admin.index', compact('name', 'stations', 'users', 'categories', 'measures', 'sum', 'admin_stations_sum', 'users_stations_sum', 'last_user_log', 'last_all_log'));
    }]);



    //*****  All controllers *********//

    Route::resource('admin/users', 'AdminUsersController');
    Route::resource('admin/stations', 'AdminStationsController');
    Route::get('admin/stations/user/show', ['as' => 'admin.stations.user.show', 'uses' => 'AdminStationsController@show_all']);
    Route::resource('admin/categories', 'AdminCategoriesController');
    Route::resource('admin/profile', 'AdminProfileController');
    Route::get('admin/profile/{id}/edit_password', ['as' => 'admin.profile.edit.password', 'uses' => 'AdminProfileController@edit_password']);
    Route::patch('admin/profile/{id}/update_password', ['as' => 'admin.profile.update.password', 'uses' => 'AdminProfileController@update_password']);
    Route::resource('admin/measures', 'AdminMeasuresController');
    Route::resource('admin/history', 'AdminHistoryController');
    Route::get('admin/history/{collection}/measures', ['as' => 'admin.history.show.measures', 'uses' => 'AdminHistoryController@show_measures']);
    Route::get('admin/updates/all', ['as' => 'admin.updates.all', 'uses' => 'AdminUpdatesController@all']);
    Route::get('admin/updates/user', ['as' => 'admin.updates.user', 'uses' => 'AdminUpdatesController@user']);
    Route::delete('admin/updates/{id}', ['as' => 'admin.updates.destroy', 'uses' => 'AdminUpdatesController@destroy']);


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
