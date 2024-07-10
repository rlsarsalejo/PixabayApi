<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
       return 'Hello world';
    }
    public function login(){
        return view('auth/login');
    }
}
