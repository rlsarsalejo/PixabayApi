<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
class UserController extends BaseController
{
    public function index()
    {
        //
    }

    public function updateProfile()
    {
        helper(['form']);
        $data = [];
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new User();
        $user = $model->find($session->get('user_id'));

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'full_name' => 'required',
                'email' => 'required|valid_email',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'full_name' => $this->request->getVar('full_name'),
                    'email' => $this->request->getVar('email'),
                ];

                $file = $this->request->getFile('profile_pic');
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(ROOTPATH . 'public/uploads', $newName);
                    $data['profile_pic'] = $newName;
                }

                $model->update($user['id'], $data);
                $session->setFlashdata('success', 'Profile updated successfully.');
                return redirect()->to('/profile');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $data['user'] = $user;
        return view('auth/update_profile', $data);
    }

}
