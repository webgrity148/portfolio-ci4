<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\MetaData;
use Google\Client;
use Google\Service\Oauth2;

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
        $gClient = new Client();
        $gClient->setApplicationName('Login to Test Project');
        $gClient->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $gClient->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $gClient->setRedirectUri(getenv('GOOGLE_REDIRECT_URL'));
        $gClient->addScope("email");
        $gClient->addScope("profile");

        $data['google_login_url'] = $gClient->createAuthUrl();
        return view('admin/login', $data);
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
                session()->set('user', $user);
            }
            return redirect()->to('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid Email or Password.');
        }
    }

    public function loginWithGoogle()
    {
        $gClient = new Client();
        $gClient->setApplicationName('Login to Test Project');
        $gClient->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $gClient->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $gClient->setRedirectUri(getenv('GOOGLE_REDIRECT_URL'));
        $gClient->addScope("email");
        $gClient->addScope("profile");

        if ($this->request->getVar('code')) {
            $token = $gClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            if (!isset($token['error'])) {
                $gClient->setAccessToken($token['access_token']);
                $googleService = new Oauth2($gClient);
                $googleUserInfo = $googleService->userinfo->get();

                $email = $googleUserInfo->email;
                $profile_picture = $googleUserInfo->picture;
                $userModel = new UserModel();
                $user = $userModel->where('email', $email)->first();
                if ($user) {
                    // Update the profile picture
                    $userModel->update($user['id'], ['profile_img' => $profile_picture]);
                }

                if ($user) {
                    session()->set('user', $user);
                    return redirect()->to('admin/dashboard');
                } else {
                    // Optionally, you can create a new user account here
                    return redirect()->to('admin/login')->with('error', 'No account associated with this email.');
                }
            } else {
                return redirect()->to('admin/login')->with('error', 'Failed to authenticate with Google.');
            }
        } else {
            return redirect()->to('admin/login')->with('error', 'No authentication code provided.');
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

    public function uploadCv()
    {
        $file = $this->request->getFile('file');
        if (!$file->isValid()) {
            return $this->fail($file->getErrorString());
        }
        $file->move(ROOTPATH . 'public/uploads/documents');

        $name = $file->getName();
        $key = 'cv'; // You can change this key as needed
        $metaDataModel = new MetaData();
        $metaDataModel->setData($key, $name);
        return redirect('admin/manage-cv')->with('success', 'Successfully updated!');
    }
}
