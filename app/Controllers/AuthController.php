<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Validation\ValidationInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;
    public function __construct()
    {
        helper(['url', 'form', 'date']);
        $this->user = new UserModel();
    }

    public function index()
    {
        // Checking if the user is Authenticated or Not
        if (!session()->get('id')) {
            return redirect()->to('auth/login')->with('error', 'Oops, you cannot do that login your account first');
        }
        $userId = session()->get('id');
        $userData = $this->user->find($userId);

        if (!$userData) {
            session()->destroy();
            return redirect()->to('auth/login')->with('error', 'User not found. Please login again.');
        }

        $data = [
            'username' => $userData['username'],
            'full_name' => $userData['full_name'],
            'email' => $userData['email'],
            'profile_pic' => $userData['profile_pic'],
        ];

        return view('dashboard', $data);
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to login page with a success message
        return redirect()->to('/')->with('success', 'You have been successfully logged out.');
    }

    public function updateProfile()
    {
        if (!session()->get('id')) {
            return redirect()->to('auth/login')->with('error', 'Please login to update your account.');
        }

        $userId = session()->get('id');
        $currentUser = $this->user->find($userId);

        $rules = [
            'username' => [
                'rules' => 'required|is_unique[users.username,id,' . $userId . ']',
                'errors' => [
                    'required' => 'Username is required',
                    'is_unique' => 'Username already exists',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'Email already exists',
                ],
            ],
            'full_name' => 'required',
        ];

        // Only validate profile_pic if a file was uploaded
        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
            $rules['profile_pic'] = [
                'rules' => 'uploaded[profile_pic]|max_size[profile_pic,1024]|mime_in[profile_pic,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Please choose a profile picture to upload',
                    'max_size' => 'Maximum file size allowed is 1MB',
                    'mime_in' => 'Only JPG, JPEG, and PNG images are allowed',
                ],
            ];
        }

       

        $validation = $this->validate($rules);

        if (!$validation) {
            return view('update-profile', [
                'validation' => $this->validator,
                'user' => $currentUser
            ]);
        } else {
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Only update fields that have changed
            foreach ($data as $key => $value) {
                if ($value == $currentUser[$key]) {
                    unset($data[$key]);
                }
            }
            

            //Profile Pic 
            if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
                $newName = $profilePic->getRandomName();
                $profilePic->move(ROOTPATH . 'public/uploads/profile_pics', $newName);
                $data['profile_pic'] = 'uploads/profile_pics/' . $newName;
            }

         
            if (!empty($data)) {
                if ($this->user->update($userId, $data)) {
                    return redirect()->to('dashboard')->with('success', 'Account successfully updated');
                } else {
                    return redirect()->back()->with('fail', 'Something went wrong. Please try again.');
                }
            } else {
                return redirect()->to('dashboard')->with('info', 'No changes were made to your account');
            }
        }
    }
    
    public function updatePassword()
{
    if (!session()->get('id')) {
        return redirect()->to('auth/login')->with('error', 'Please login to update your password.');
    }

    $userId = session()->get('id');
    $currentUser = $this->user->find($userId);

    $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min_length[8]',
        'confirm_password' => 'required|matches[new_password]',
    ];

    $messages = [
        'confirm_password.matches' => 'The new password and confirm password must match.'
    ];

    if (!$this->validate($rules, $messages)) {
        return redirect()->back()->withInput()->with('validation', $this->validator);
    } else {
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Verify current password
        if (!password_verify($currentPassword, $currentUser['password'])) {
            $this->validator->setError('current_password', 'The current password is incorrect.');
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update user's password
        $data = [
            'password' => $hashedPassword,
        ];

        if ($this->user->update($userId, $data)) {
            return redirect()->to('dashboard')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('fail', 'Failed to update password. Please try again.');
        }
    }
}

}
