<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyActivitiesModel;

class FacultyWorkshopController extends BaseController
{
    protected $facultyActivitiesModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultyActivitiesModel = new FacultyActivitiesModel();
    }

    // ✅ Fetch all workshops for a user
    public function getWorkshopsByUser($user_id)
    {
        $records = $this->facultyActivitiesModel
            ->where('faculty_id', $user_id)
            ->where('category', 'workshop') // only workshops
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No workshops found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            // Build certificate URL if exists
            $certificateUrl = '';
            if (!empty($record['certificate_path'])) {
                $certificateUrl = $record['certificate_path'];
                // Avoid duplicate "uploads/works/" in URL
                if (!str_contains($certificateUrl, 'uploads/activities/')) {
                    $certificateUrl = base_url('uploads/activities/' . $certificateUrl);
                }
            }

            return [
                'user_id'          => $record['faculty_id'],
                'title'            => $record['title'],
                'type'             => $record['type'],
                'month_year'       => $record['month_year'],
                'attended_or_role' => $record['attended_or_role'],
                'location'         => $record['location'],
                'certificate_url'  => $certificateUrl,
                'visibility'       => $record['visibility'],
                'created_at'       => $record['created_at'],
                'updated_at'       => $record['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }

    // ✅ Fetch single/latest workshop
    public function getSingleWorkshopByUser($user_id)
    {
        $record = $this->facultyActivitiesModel
            ->where('faculty_id', $user_id)
            ->where('category', 'workshop')
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No workshops found for this user.'
            ]);
        }

        $certificateUrl = '';
        if (!empty($record['certificate_path'])) {
            $certificateUrl = $record['certificate_path'];
            if (!str_contains($certificateUrl, 'uploads/activities/')) {
                $certificateUrl = base_url('uploads/activities/' . $certificateUrl);
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'          => $record['faculty_id'],
                'title'            => $record['title'],
                'type'             => $record['type'],
                'month_year'       => $record['month_year'],
                'attended_or_role' => $record['attended_or_role'],
                'location'         => $record['location'],
                'certificate_url'  => $certificateUrl,
                'visibility'       => $record['visibility'],
                'created_at'       => $record['created_at'],
                'updated_at'       => $record['updated_at'],
            ]
        ]);
    }
}
