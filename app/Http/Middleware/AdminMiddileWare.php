<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddileWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->role == 'admin'){
                return $next($request);
            }
        }
        return redirect()->route('getLogin')->with('error','ທ່ານບໍ່ສາມາດເຂົ້າໄດ້ ກະລຸນາເຂົ້າສູ່ລະບົບກ່ອນ');
    }
}
