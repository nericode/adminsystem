<?php

namespace App\Http\Middleware;

use Closure;
use App\Users;

class AccessMiddleware
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
        $user  = Users::exists($request->user, $request->password);

        if(!$user)
        {
            return redirect('login');
        }
        else
        {
            return redirect('/');
        }

        return $next($request);
    }
}
