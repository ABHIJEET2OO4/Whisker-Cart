<?php
namespace App\Middleware;

use Core\Request;
use Core\Response;
use Core\Session;
use Core\View;

/**
 * Redirects to admin dashboard if already logged in.
 * Used on login page to prevent re-login.
 */
class GuestMiddleware
{
    public function handle(Request $request): bool
    {
        if (Session::isAdmin()) {
            Response::redirect(View::url('admin'));
            return false;
        }
        return true;
    }
}
