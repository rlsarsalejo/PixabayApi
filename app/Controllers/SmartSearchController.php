<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use GuzzleHttp\Client;
use App\Models\UserModel;

class SmartSearchController extends BaseController
{   
    private $pixabayApiKey;
    private $pixabayApiUrl;
    private $userModel;

    public function __construct(){
        helper(['url', 'form', 'date']);
        $this->pixabayApiKey = '44862301-46cfb4d4ebd2a038eb7d92cd7';
        $this->pixabayApiUrl = 'https://pixabay.com/api/';
        $this->userModel = new UserModel();
    }

    public function checkAuth(){
        if (!session()->get('id')) {
            return redirect()->to('auth/login')->with('error', 'Please login to access Smart Search.');
        }
        return false;
    }

    public function getUserData(){
        $userId = session()->get('id');
        $userData = $this->userModel->find($userId);

        if (!$userData) {
            session()->destroy();
            return redirect()->to('auth/login')->with('error', 'User not found. Please login again.');
        }

        return [
            'username' => $userData['username'],
            'full_name' => $userData['full_name'],
            'email' => $userData['email'],
            'profile_pic' => $userData['profile_pic'],
        ];
    }

    public function index()
    {   
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $authCheck;
        }
        
        $userData = $this->getUserData();
        return view('smart-search', $userData);
    }

    public function search(){
        $authCheck = $this->checkAuth();
        if ($authCheck) {
            return $authCheck;
        }

        $query = $this->request->getGet('query');
        $type = $this->request->getGet('type');

        if(!$query){
            return redirect()->back()->with('error', 'Please do not leave the search field blank.');
        }

        $client = new Client();
        try{
            $params = [
                'key' => $this->pixabayApiKey,
                'q' => $query,
                'page' => 1,
                'per_page' => 20,
            ];

            if ($type === 'image') {
                $params['image_type'] = 'photo';
            } elseif ($type === 'video') {
                $this->pixabayApiUrl = 'https://pixabay.com/api/videos/';
            }

            $response = $client->request('GET', $this->pixabayApiUrl, [
                'query' => $params
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['hits']) || empty($data['hits'])) {
                return redirect()->back()->with('error', 'No results found.');
            }

            $userData = $this->getUserData();
            return view('smart-search', array_merge(
                $userData,
                ['results' => $data['hits'], 'query' => $query, 'type' => $type]
            ));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch data from Pixabay. ' . $e->getMessage());
        }
    }
}