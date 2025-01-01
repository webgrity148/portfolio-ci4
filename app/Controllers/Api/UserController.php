<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class UserController extends ResourceController
{
    
    public function index()
    {
        //
    }

    public function profile()
    {
        $user = $this->request->user; // Retrieved from the ApiAuth filter
        return $this->respond($user);
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        try {
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Generate a token or session
                    $token = bin2hex(random_bytes(64));
                    // For simplicity, we'll just return the user data
                    $userModel->update($user['id'], ['login_token' => $token]);
                    return $this->respond(['message' => 'Login successful', 'token' => $token]);
                } else {
                    return $this->failNotFound('Invalid email or password');
                }
            } else {
                return $this->failNotFound('Invalid email or password');
            }
        } catch (\Throwable $th) {
            return $this->failServerError($th->getMessage());
        }
    }

    public function register()
    {

      return  $this->respond([
            'status' => 1,
            'message' => 'User registered successfully'
        ]);
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        // Check if the email already exists
        if ($userModel->where('email', $email)->first()) {
            return $this->fail('Email already exists', 409);
        }

        // Create the user
        $data=[
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ];
      $userModel->insert($data);

        return $this->respondCreated(['status'=>'1','message' => 'User registered successfully']);
    }
}
