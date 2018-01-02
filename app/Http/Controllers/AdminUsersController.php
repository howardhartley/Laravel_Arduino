<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeUserRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MakeUserRequest $request)
    {
        $input = $request->all();
        $input['name'] = trim($input['name']);
        $input['surname'] = trim($input['surname']);
        $input['email'] = trim($input['email']);
        $input['is_active'] = 1;
        $input['confirmed'] = 1;
        $input['confirmation'] = '';
        $input['password'] = bcrypt($input['password']);
        User::create($input);
        Session::flash('complete', 'Ο χρήστης έχει δημιουργηθεί.');
        return redirect('admin/users');

    }

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
        if($user->id == 1 || $user->id == Auth::user()->id){
            return view('errors.404');
        }
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit', compact('user','roles'));
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
        if(User::findOrFail($id)->role_id == $request->role_id && User::findOrFail($id)->is_active == $request->is_active){
            Session::flash('nothing', 'Δεν πραγματοποιήθηκε κάποια αλλαγή.');
            return redirect('admin/users');
        }

        $this->validate($request, [
            'role_id'   => 'required',
            'is_active' => 'required'
        ]);

        User::findOrFail($id)->update(['role_id' => $request->role_id, 'is_active' => $request->is_active]);
        Session::flash('update', 'Ο χρήστης έχει ανανεωθεί.');
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->id == 1 || $user->id == Auth::user()->id){
            return view('errors.404');
        }
        $user->delete();
        Session::flash('delete', 'O χρήστης έχει διαγραφεί.');
        return redirect()->back();
    }
}
