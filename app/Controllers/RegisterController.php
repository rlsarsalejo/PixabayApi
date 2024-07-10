<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{   
    public function __construct()
    {
        helper(['url', 'form', 'date']);
    }

    public function index()
    {
        return view('auth/register');
    }

    public function register_user()
    {
        $validation = $this->validate([
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username is required',
                    'is_unique' => 'Username already exists',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'Email already exists',
                ],
            ],
            'full_name' => 'required',
            'password' => 'required|min_length[5]',
            'cpassword' => 'required|matches[password]',
            'profile_pic' => [
                'rules' => 'uploaded[profile_pic]|max_size[profile_pic,1024]|mime_in[profile_pic,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Please choose a profile picture to upload',
                    'max_size' => 'Maximum file size allowed is 1MB',
                    'mime_in' => 'Only JPG, JPEG, and PNG images are allowed',
                ],
            ],
        ]);

        if (!$validation) {
            return view('auth/register', ['validation' => $this->validator]);
        } else {
            $profilePic = $this->request->getFile('profile_pic');
            $newName = $profilePic->getRandomName();
            $profilePic->move(ROOTPATH . 'public/uploads/profile_pics', $newName);

            $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $userModel = new UserModel();
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name'),
                'password' => $hashedPassword,
                'profile_pic' => 'uploads/profile_pics/' . $newName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($userModel->insert($data)) {
                return redirect()->to('/')->with('success', 'Account successfully created');
            } else {
                return redirect()->back()->with('fail', 'Something went wrong. Please try again.');
            }
        }
    }
}
