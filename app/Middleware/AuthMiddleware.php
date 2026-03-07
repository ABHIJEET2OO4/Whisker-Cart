<?php
namespace App\Middleware;

use Core\Request;
use Core\Response;
use Core\Session;
use Core\View;

/**
 * Ensures the user is logged in as an admin.
 * Redirects to login page if not authenticated.
 */
class AuthMiddleware
{
    public function handle(Request $request): bool
    {
        if (!Session::isAdmin()) {
            // Detect AJAX/fetch requests more broadly
            $isAjax = $request->isAjax()
                || str_contains($request->server('HTTP_ACCEPT', ''), 'application/json')
                || str_contains($request->server('CONTENT_TYPE', ''), 'multipart/form-data');

            if ($isAjax) {
                Response::json(['success' => false, 'error' => 'Unauthorized'], 401);
                return false;
            }
            Response::redirect(View::url('admin/login'));
            return false;
        }
        return true;
    }
}