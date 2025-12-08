<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultySkillModel;

class FacultySkillController extends BaseController
{
    protected $facultySkillModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultySkillModel = new FacultySkillModel();
    }

    // ✅ Fetch all skills for a user
    public function getFacultySkillsByUser($user_id)
    {
        $records = $this->facultySkillModel
            ->where('faculty_id', $user_id)
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No skills found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'     => $record['faculty_id'],
                'skill_value' => $record['skill_value'],
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

    // ✅ Fetch single/latest skill for a user
    public function getFacultySkillByUser($user_id)
    {
        $record = $this->facultySkillModel
            ->where('faculty_id', $user_id)
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No skill found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'     => $record['faculty_id'],
                'skill_value' => $record['skill_value'],
                'visibility'  => $record['visibility'],
                'created_at'  => $record['created_at'],
                'updated_at'  => $record['updated_at'],
            ]
        ]);
    }
}
