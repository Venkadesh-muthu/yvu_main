<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyMembershipsModel;

class FacultyMembershipController extends BaseController
{
    protected $membershipModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->membershipModel = new FacultyMembershipsModel();
    }

    /**
     * Fetch all memberships for a faculty user
     */
    public function getMembershipsByUser($user_id)
    {
        $records = $this->membershipModel
            ->where('faculty_id', $user_id)
            ->where('visibility', 'view') // optional: only public
            ->orderBy('id', 'DESC')
            ->findAll();

        if (empty($records)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No memberships found for this user.'
            ]);
        }

        $data = array_map(function ($row) {
            return [
                'user_id'    => $row['faculty_id'],
                'category'   => $row['category'],
                'title'      => $row['title'],
                'visibility' => $row['visibility'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    /**
     * Fetch latest membership for a faculty user
     */
    public function getLatestMembershipByUser($user_id)
    {
        $record = $this->membershipModel
            ->where('faculty_id', $user_id)
            ->where('visibility', 'view') // optional
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No membership found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'    => $record['faculty_id'],
                'category'   => $record['category'],
                'title'      => $record['title'],
                'visibility' => $record['visibility'],
                'created_at' => $record['created_at'],
                'updated_at' => $record['updated_at'],
            ]
        ]);
    }
}
