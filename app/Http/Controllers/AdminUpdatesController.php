<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminUpdatesController extends Controller
{


    public function all()
    {
        $logs = Log::all()->reverse()->paginate(5);
        return view('admin.updates.all', compact('logs'));
    }


    public function user()
    {
        $logs = Log::where('user_id', Auth::user()->id)->get()->reverse()->paginate(5);
        return view('admin.updates.user', compact('logs'));
    }



    public function destroy($id)
    {
        Log::findOrFail($id)->delete();
        Session::flash('delete', 'Η ενημέρωση έχει διαγραφεί.');
        return redirect()->back();

    }

}
