<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){

            if(Auth::user()->is_active == 0){

                Session::flash('Deactivate', 'Ο λογαριασμός σας έχει απενεργοποιηθεί. Παρακαλώ επικοινωνήστε με τους διαχειριστές του συστήματος.');
                Auth::logout();
                return redirect('/login');

            }

                if(Auth::user()->isAdmin()){

                    return $next($request);

                }else{

                    return redirect('/');

                }

        }

        return redirect('/login');

    }
}
