<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyResearchStudentsModel;

class FacultyResearchStudentsController extends BaseController
{
    protected $researchStudentsModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->researchStudentsModel = new FacultyResearchStudentsModel();
    }

    // Fetch all research students for a faculty
    public function getResearchStudentsByUser($user_id)
    {
        $records = $this->researchStudentsModel
            ->where('faculty_id', $user_id)
            ->where('visibility', 'view')  // Only visible entries
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No research students found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'      => $record['faculty_id'],
                'student_name' => $record['student_name'],
                'topic_title'  => $record['topic_title'],
                'type'         => $record['type'],
                'from_year'    => $record['from_year'],
                'to_year'      => $record['to_year'],
                'status'       => $record['status'],
                'visibility'   => $record['visibility'],
                'created_at'   => $record['created_at'],
                'updated_at'   => $record['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }

    // Fetch latest research student for a faculty
    public function getLatestResearchStudentByUser($user_id)
    {
        $record = $this->researchStudentsModel
            ->where('faculty_id', $user_id)
            ->where('visibility', 'view')
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No research student found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'      => $record['faculty_id'],
                'student_name' => $record['student_name'],
                'topic_title'  => $record['topic_title'],
                'type'         => $record['type'],
                'from_year'    => $record['from_year'],
                'to_year'      => $record['to_year'],
                'status'       => $record['status'],
                'visibility'   => $record['visibility'],
                'created_at'   => $record['created_at'],
                'updated_at'   => $record['updated_at'],
            ]
        ]);
    }
}
