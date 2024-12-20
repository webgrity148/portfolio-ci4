<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        //
    }

    public function login()
    {
        // Check if the user is already logged in
        if (session()->get('user')) {
            return redirect()->to('admin/dashboard');
        }

        // Check if remember me cookie is set and valid
        if (isset($_COOKIE['remember_me'])) {
            $userModel = new UserModel();
            $user = $userModel->where('remember_token', $_COOKIE['remember_me'])->first();
            if ($user) {
                session()->set('user', $user['email']);
                return redirect()->to('admin/dashboard');
            }
        }

        return view('admin/login');
    }

    public function loginAction()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Validate the inputs
        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Email and Password are required.');
        }

        // Load the user model
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Set session or cookie if remember me is checked
            if ($remember) {
                // Generate a remember token
                $rememberToken = bin2hex(random_bytes(16));
                // Save the remember token in the database
                $userModel->update($user['id'], ['remember_token' => $rememberToken]);
                // Set a cookie for remember me
                setcookie('remember_me', $rememberToken, time() + (86400 * 30), "/"); // 30 days
            } else {
                // Set session
                session()->set('user', $email);
            }
            return redirect()->to('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid Email or Password.');
        }
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();
        // Clear the remember me cookie
        setcookie('remember_me', '', time() - 3600, "/");
        return redirect()->to('admin/login');
    }
    public function dashboard()
    {

        return view('admin/dashboard');
    }
    public function manageCv()
    {

        return view('admin/manage-cv');
    }
}
