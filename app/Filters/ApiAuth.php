<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;
use Config\Services;

class ApiAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            return Services::response()
                ->setJSON(['error' => 'Authorization header missing'])
                ->setStatusCode(401);
        }
        $token = str_replace('Bearer ', '', $authHeader->getValue());
        $userModel = new UserModel();
        $user = $userModel->getUserByToken($token);

        if (!$user) {
            return Services::response()
                ->setJSON(['error' => 'Invalid token'])
                ->setStatusCode(401);
        }

        // Save the user info in the request for use in controllers
        $request->user = $user;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
