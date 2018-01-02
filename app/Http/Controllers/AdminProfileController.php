<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
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
        return view('errors.404');
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
        $user = User::findOrFail($id);

        if($user->id != Auth::user()->id){
            return view('errors.404');
        }

        $roles = Role::pluck('name', 'id')->all();


        return view('admin.profile.edit', compact('user', 'roles'));

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
        if(Auth::user()->id == 1){

            if(User::findOrFail($id)->name == trim($request->name) && User::findOrFail($id)->surname == trim($request->surname)){
                Session::flash('nothing', 'Δεν πραγματοποιήθηκε κάποια αλλαγή.');
                return redirect('admin/profile');
            }

            $this->validate($request, [
                'name'      => 'required:max:255',
                'surname'   => 'required:max:255'
            ]);


            User::findOrFail($id)->update(['name' => trim($request->name), 'surname' => trim($request->surname)]);

            Session::flash('update', 'Το προφίλ σας έχει ανανεωθεί.');
            return redirect('admin/profile');

        }else{

            if(User::findOrFail($id)->role_id == $request->role_id && User::findOrFail($id)->is_active == $request->is_active &&
                User::findOrFail($id)->name == trim($request->name) &&User::findOrFail($id)->surname == trim($request->surname)){
                Session::flash('nothing', 'Δεν πραγματοποιήθηκε κάποια αλλαγή.');
                return redirect('admin/profile');
            }

            $this->validate($request, [
                'name'      => 'required:max:255',
                'surname'   => 'required:max:255'
            ]);


            User::findOrFail($id)->update(['role_id' => $request->role_id, 'is_active' => $request->is_active, 'name' => trim($request->name), 'surname' => trim($request->surname)]);

            if($request->is_active == 0){
                Session::flash('Deactivate', 'Ο λογαριασμός σας έχει απενεργοποιηθεί. Παρακαλώ επικοινωνήστε με τους διαχειριστές του συστήματος.');
                Auth::logout();
                return redirect('/login');

            }else if($request->role_id == 2){

                return redirect('/');

            }else{

                Session::flash('update', 'Το προφίλ σας έχει ανανεωθεί.');
                return redirect('admin/profile');
            }
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

        Session::flash('Deleted', 'Ο λογαριασμός σας έχει διαγραφεί.');
        User::findOrFail($id)->delete();
        return redirect('/');
    }


    public function edit_password($id)
    {

        $user = User::findOrFail($id);

        if($user->id != Auth::user()->id){
            return view('errors.404');
        }


        return view('admin.profile.edit_password', compact('user'));
    }



    public function update_password(Request $request, $id)
    {
        $user = User::findOrFail($id);


        $this->validate($request, [
            'password'       => 'required|min:6|max:255',
            'new_password'   => 'required|min:6|max:255|confirmed',

        ]);

        if (Hash::check($request->password , $user->password))
        {

            //*******  same old password with the hashed one in base  *************//


            $hash = bcrypt($request->new_password);

            $user->update(['password' => $hash]);

            Session::flash('update_password', 'Ο κωδικός πρόσβασης έχει ανανεωθεί.');
            return redirect('admin/profile');

        }else{

            //*******  the passwords don't match -> error  *************//


            Session::flash('no_update_password', 'Ο κωδικός πρόσβασης που έχετε εισάγει δεν είναι σωστός.');
            return redirect()->back();
        }




    }


}
