<?php

namespace Config;

use Myth\Auth\Config\Auth as MythAuth;

class Auth extends MythAuth
{
    /**
     * --------------------------------------------------------------------
     * Default User Group
     * --------------------------------------------------------------------
     */
    public $defaultUserGroup = 'user';

    /**
     * --------------------------------------------------------------------
     * Landing Route
     * --------------------------------------------------------------------
     */
    public $landingRoute = '/';

    /**
     * --------------------------------------------------------------------
     * Views used by Auth Controllers
     * --------------------------------------------------------------------
     */
    public $views = [
        'login'           => 'auth/login',
        'register'        => 'auth/register',
        'forgot'          => 'auth/forgot',
        'reset'           => 'auth/reset',
        'emailForgot'     => 'Myth\Auth\Views\emails\forgot',
        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];

    /**
     * --------------------------------------------------------------------
     * Layout for the views to extend
     * --------------------------------------------------------------------
     */
    public $viewLayout = 'auth/layout';

    /**
     * --------------------------------------------------------------------
     * Require Confirmation Registration via Email
     * --------------------------------------------------------------------
     * Set to null to activate accounts automatically upon registration.
     */
    public $requireActivation = null;

    /**
     * --------------------------------------------------------------------
     * Allow Persistent Login Cookies (Remember me)
     * --------------------------------------------------------------------
     */
    public $allowRemembering = true;
}
