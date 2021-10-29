<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;
use Illuminate\Http\Request;

class HasFile
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
        if (!$request->hasFile('file')) {
            return view(LoginController::ERROR_VIEW, ['message' => __('labels.noFile')]);
        }

        if (!$request->file('file')->isValid()) {
            return view(LoginController::ERROR_VIEW, ['message' => __('labels.validFile')]);
        }

        return $next($request);
    }
}
