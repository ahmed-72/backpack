<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckIfUser
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
        if ($request->isMethod('post') && $request->path() == 'admin/login') {
            $user = User::where('email', $request->email)->first();
            if ($user && $user->type == 'super-admin') {
                return $next($request);
            }
        }
        return redirect()->back()->withErrors("Sorry ,This page is not for users ,you can just use the app.")->withInput();;
    }
}
