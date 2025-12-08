<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->userModel = new UserModel();
    }

    // ✅ Fetch all users
    public function getUsers()
    {
        $users = $this->userModel
            ->orderBy('id', 'DESC')
            ->findAll();

        // ✅ Format response (hide password)
        $users = array_map(function ($user) {
            return [
                'id'         => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'department' => $user['department'],
                'user_type'  => $user['user_type'],
                'phone'      => $user['phone'],
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at'],
            ];
        }, $users);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $users
        ]);
    }

    // ✅ Fetch single user by ID
    public function getUser($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'User not found.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'id'         => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'department' => $user['department'],
                'user_type'  => $user['user_type'],
                'phone'      => $user['phone'],
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at'],
            ]
        ]);
    }
}
