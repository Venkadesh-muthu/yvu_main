<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyAchievementModel;

class FacultyAchievementController extends BaseController
{
    protected $achievementModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->achievementModel = new FacultyAchievementModel();
    }

    // ✅ Fetch all Awards for a given user
    public function getAwardsByUser($user_id)
    {
        $records = $this->achievementModel
            ->where('faculty_id', $user_id)
            ->where('section', 'Awards / Honors') // only Awards section
            ->where('visibility', '1') // only visible records
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No awards found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'     => $record['faculty_id'],
                'title'       => $record['title'],
                'description' => $record['description'],
                'month_year'  => $record['month_year'],
                'visibility' => $record['visibility'],
                'created_at'  => $record['created_at'],
                'updated_at'  => $record['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }
}
