<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyExperienceModel;

class FacultyTeachingController extends BaseController
{
    protected $facultyExperienceModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultyExperienceModel = new FacultyExperienceModel();
    }

    // ✅ Fetch all teaching experiences for a user
    public function getTeachingByUser($user_id)
    {
        $records = $this->facultyExperienceModel
            ->where('faculty_id', $user_id)
            ->where('section', 'teaching')
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No teaching experience found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'     => $record['faculty_id'],
                'title_type'  => $record['title_type'],
                'title_value' => $record['title_value'],
                'workplace'   => $record['workplace'],
                'from_date'   => $record['from_date'],
                'to_date'     => $record['to_date'],
                'visibility'  => $record['visibility'],
                'created_at'  => $record['created_at'],
                'updated_at'  => $record['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }

    // ✅ Fetch single/latest teaching experience
    public function getSingleTeachingByUser($user_id)
    {
        $record = $this->facultyExperienceModel
            ->where('faculty_id', $user_id)
            ->where('section', 'teaching')
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No teaching experience found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'     => $record['faculty_id'],
                'title_type'  => $record['title_type'],
                'title_value' => $record['title_value'],
                'workplace'   => $record['workplace'],
                'from_date'   => $record['from_date'],
                'to_date'     => $record['to_date'],
                'visibility'  => $record['visibility'],
                'created_at'  => $record['created_at'],
                'updated_at'  => $record['updated_at'],
            ]
        ]);
    }
}
