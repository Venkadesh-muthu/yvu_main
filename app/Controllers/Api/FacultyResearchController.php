<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultySkillModel;

class FacultyResearchController extends BaseController
{
    protected $facultySkillModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultySkillModel = new FacultySkillModel();
    }

    // ✅ Fetch ALL Research Areas for a user
    public function getFacultyResearchByUser($user_id)
    {
        $records = $this->facultySkillModel
            ->where('faculty_id', $user_id)
            ->where('category', 'research')   // ⭐ ONLY research
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No research areas found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'     => $record['faculty_id'],
                'category'    => $record['category'],
                'research_value' => $record['skill_value'],  // alias for clarity
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

    // ✅ Fetch SINGLE latest Research Area
    public function getSingleFacultyResearchByUser($user_id)
    {
        $record = $this->facultySkillModel
            ->where('faculty_id', $user_id)
            ->where('category', 'research')   // ⭐ ONLY research
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No research area found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'        => $record['faculty_id'],
                'category'       => $record['category'],
                'research_value' => $record['skill_value'],
                'visibility'     => $record['visibility'],
                'created_at'     => $record['created_at'],
                'updated_at'     => $record['updated_at'],
            ]
        ]);
    }
}
