<?php

namespace App\Http\Middleware;

use App\Enums\CmnEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Gate::before(function ($user, $ability) {
            if ($user->isAdministrator()) {
                return true;
            }
        });

        $user = Auth::user(); 

        foreach ($user->roles as $role) { 
            foreach ($role->permissions as $permission) {  
                Gate::define( 
                    $permission->title,
                    function (User $user) {
                        return true;
                    }
                );
            } 
        }

        return $next($request);
    }
}
