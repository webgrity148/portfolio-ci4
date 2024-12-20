<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is not logged in
        if (!session()->get('user')) {
            if (isset($_COOKIE['remember_me'])) {
                // Verify the remember token from the database
                $userModel = new UserModel();
                $user = $userModel->where('remember_token', $_COOKIE['remember_me'])->first();
                if ($user) {
                    // Set session from cookie
                    session()->set('user', $user['email']);
                } else {
                    // Redirect to login page if token is invalid
                    return redirect()->to('/admin/login');
                }
            } else {
                // Redirect to login page if no session or cookie
                return redirect()->to('/admin/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
