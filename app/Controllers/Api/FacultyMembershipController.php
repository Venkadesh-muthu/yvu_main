<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyActivitiesModel;

class FacultyMembershipController extends BaseController
{
    protected $facultyActivitiesModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultyActivitiesModel = new FacultyActivitiesModel();
    }

    // Fetch all memberships for a user
    public function getMembershipsByUser($user_id)
    {
        $records = $this->facultyActivitiesModel
            ->where('faculty_id', $user_id)
            ->where('category', 'membership')
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No memberships found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'         => $record['faculty_id'],
                'title'           => $record['title'],
                'type'            => $record['type'],
                'month_year'      => $record['month_year'],
                'attended_or_role' => $record['attended_or_role'],
                'location'        => $record['location'],
                // Only return filename, not full URL
                'certificate_url' => $record['certificate_path'],
                'visibility'      => $record['visibility'],
                'created_at'      => $record['created_at'],
                'updated_at'      => $record['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }

    // Fetch latest membership for a user
    public function getLatestMembershipByUser($user_id)
    {
        $record = $this->facultyActivitiesModel
            ->where('faculty_id', $user_id)
            ->where('category', 'membership')
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
                'user_id'         => $record['faculty_id'],
                'title'           => $record['title'],
                'type'            => $record['type'],
                'month_year'      => $record['month_year'],
                'attended_or_role' => $record['attended_or_role'],
                'location'        => $record['location'],
                // Only filename
                'certificate_url' => $record['certificate_path'],
                'visibility'      => $record['visibility'],
                'created_at'      => $record['created_at'],
                'updated_at'      => $record['updated_at'],
            ]
        ]);
    }
}
