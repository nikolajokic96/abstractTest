<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;
use Exception;
use Illuminate\Http\Request;

class LoginCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('username') && !$request->has('password')) {
            return view(LoginController::ERROR_VIEW, ['message' => __('labels.loginError')]);
        }

        return $next($request);
    }
}
