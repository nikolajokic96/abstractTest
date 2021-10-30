<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    public const WELCOME_VIEW = 'welcome';
    public const DASHBOARD = 'dashboard';
    public const ERROR_VIEW = 'error';
    public const CURRENT_USER = 'username';

    /**
     * @var LoginService
     */
    private LoginService $loginService;

    /**
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Opens login page
     */
    public function index()
    {
        return view(self::WELCOME_VIEW);
    }

    /**
     * Logins user
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function login(Request $request)
    {
        try {
            $user = $this->loginService->login($request->get('username'), $request->get('password'));
            session([self::CURRENT_USER => $user->username]);
            return $this->loginService->loadDashboardPage($user);
        } catch (\Exception $e) {
            return view(self::ERROR_VIEW, ['message' => $e->getMessage()]);
        }
    }

}
