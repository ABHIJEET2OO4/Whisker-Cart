<?php
namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Session;
use Core\View;
use Core\Database;
use Core\Validator;

class AuthController
{
    public function showLogin(Request $request, array $params = []): void
    {
        if (Session::isAdmin()) {
            Response::redirect(View::url('admin'));
            return;
        }
        View::render('admin/login', [], null);
    }

    public function login(Request $request, array $params = []): void
    {
        // Rate limit: max 5 attempts per 15 minutes per IP
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $key = 'login_attempts_' . md5($ip);
        $attempts = Session::get($key, ['count' => 0, 'first_at' => time()]);

        if ($attempts['count'] >= 5 && (time() - $attempts['first_at']) < 900) {
            $wait = ceil((900 - (time() - $attempts['first_at'])) / 60);
            Session::flash('error', "Too many login attempts. Try again in {$wait} minutes.");
            Response::redirect(View::url('admin/login'));
            return;
        }

        // Reset counter if window expired
        if ((time() - $attempts['first_at']) >= 900) {
            $attempts = ['count' => 0, 'first_at' => time()];
        }

        $v = new Validator($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($v->fails()) {
            Session::flash('error', $v->firstError());
            Response::redirect(View::url('admin/login'));
            return;
        }

        if (!Session::verifyCsrf($request->input('wk_csrf'))) {
            Session::flash('error', 'Session expired. Please try again.');
            Response::redirect(View::url('admin/login'));
            return;
        }

        $username = $request->clean('username');
        $password = $request->input('password');

        $admin = Database::fetch(
            "SELECT id, username, password_hash, is_active FROM wk_admins WHERE (username = ? OR email = ?) LIMIT 1",
            [$username, $username]
        );

        if (!$admin || !$admin['is_active'] || !password_verify($password, $admin['password_hash'])) {
            $attempts['count']++;
            Session::set($key, $attempts);
            Session::flash('error', 'Invalid username or password.');
            Response::redirect(View::url('admin/login'));
            return;
        }

        // Reset attempts on success
        Session::remove($key);
        Session::setAdmin($admin['id']);
        Database::update('wk_admins', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$admin['id']]);

        Response::redirect(View::url('admin'));
    }

    public function logout(Request $request, array $params = []): void
    {
        Session::destroy();
        Response::redirect(View::url('admin/login'));
    }
}
