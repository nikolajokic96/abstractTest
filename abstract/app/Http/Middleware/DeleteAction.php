<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;
use Illuminate\Http\Request;

class DeleteAction
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasFile('fileName')) {
            return view(LoginController::ERROR_VIEW, ['message' => __('labels.noFile')]);
        }

        return $next($request);
    }
}
