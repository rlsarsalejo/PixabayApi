<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{   
    public function __construct()
    {
        helper(['url', 'form', 'date']);
    }

    public function index()
    {
        if (session()->get('id')) {
            return redirect()->to('dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $validation = $this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username or Email is required',
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password is required',
                ],
            ],
        ]);

        if (!$validation) {
            return view('auth/login', ['validation' => $this->validator]);
        } else {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // Check if user exists with username or email
            $userModel = new UserModel();
            $user = $userModel->where('username', $username)
                              ->orWhere('email', $username)
                              ->first();

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Password matches
                    // Store user data in session or perform any other action
                    // Example: storing user data in session
                    $userData = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        // Add other relevant data to store in session
                    ];
                    session()->set($userData);

                    return redirect()->to('/dashboard'); // Redirect to dashboard or any other page
                } else {
                    // Invalid password
                    $data['validation'] = $this->validator;
                    $data['validation']->setError('password', 'Password does not match');
                    return view('auth/login', $data);
                }
            } else {
                // User not found
                $data['validation'] = $this->validator;
                $data['validation']->setError('username', 'User does not exist');
                return view('auth/login', $data);
            }
        }
    }
}
