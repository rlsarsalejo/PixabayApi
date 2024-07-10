<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'full_name', 'password', 'profile_pic', 'created_at', 'updated_at'];

    // protected $useTimestamps = true; // Enable automatic timestamps
    // protected $createdField = 'created_at'; // Set the created_at field

    // protected $skipValidation = false; // Ensure validation is applied by default
}
