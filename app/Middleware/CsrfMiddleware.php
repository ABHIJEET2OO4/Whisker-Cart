<?php
namespace App\Middleware;

use Core\Request;
use Core\Response;
use Core\Session;

/**
 * Verifies CSRF token on all POST requests.
 * Token can come from:
 *   - Form field: wk_csrf
 *   - HTTP header: X-CSRF-Token (for AJAX)
 */
class CsrfMiddleware
{
    public function handle(Request $request): bool
    {
        if (!$request->isPost()) return true;

        // Get token from form field or header
        $token = $request->input('wk_csrf')
              ?? $request->server('HTTP_X_CSRF_TOKEN');

        if (!$token || !Session::verifyCsrf($token)) {
            // Detect AJAX/fetch
            $isAjax = $request->isAjax()
                || str_contains($request->server('HTTP_ACCEPT', ''), 'application/json')
                || str_contains($request->server('CONTENT_TYPE', ''), 'multipart/form-data')
                || str_contains($request->server('CONTENT_TYPE', ''), 'application/json');

            if ($isAjax) {
                Response::json(['success' => false, 'error' => 'CSRF token invalid or expired. Reload the page.'], 403);
                return false;
            }

            Session::flash('error', 'Your session expired. Please try again.');
            $referer = $request->server('HTTP_REFERER');
            Response::redirect($referer ?: '/');
            return false;
        }

        return true;
    }
}