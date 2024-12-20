<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
   
    public function register()
    {
        $data = [
            'title' => 'Home Page'
        ];
        return view('auth/register',$data);
    }
    public function registerAction()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();

        if (!$this->validate([
            'username' => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'matches[password]',
        ])) {
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];

        $userModel->save($data);

        return redirect()->to('/login');
    }

    
    public function login()
    {
        return view('auth/login');
    }

    public function loginAction()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();

        if (!$this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return view('auth/login', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->getUserByEmailOrUsername($email);

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user_id', $user['id']);
            session()->set('username', $user['username']);
            return redirect()->to('/');
        } else {
            return view('auth/login', ['error' => 'Invalid login credentials.']);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
