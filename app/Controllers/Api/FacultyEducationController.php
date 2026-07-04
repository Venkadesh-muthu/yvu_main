<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyEducationModel;

class FacultyEducationController extends BaseController
{
    protected $facultyEducationModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultyEducationModel = new FacultyEducationModel();
    }

    // ✅ Fetch all faculty education records by faculty_id
    public function getFacultyEducationsByUser($user_id)
    {
        $records = $this->facultyEducationModel
            ->where('faculty_id', $user_id)
            ->orderBy('year', 'ASC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No education records found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                // User reference
                'user_id'       => $record['faculty_id'],  // faculty_id shown as user_id

                // Academic details
                'category'      => $record['category'],
                'course_subject' => $record['course_subject'],
                'marks_division' => $record['marks_division'],
                'year'          => $record['year'],
                'class'         => $record['class'],

                // Institution details
                'university'    => $record['university'],
                'institute'     => $record['institute'],

                // Location details
                'country'       => $record['country'],
                'town'          => $record['town'],
                'district'      => $record['district'],
                'state'         => $record['state'],

                // Additional info (LAST)
                'highlights_comments_merits' => $record['highlights_comments_merits'],

                // System fields
                'visibility'    => $record['visibility'],
                'created_at'    => $record['created_at'],
                'updated_at'    => $record['updated_at'],
            ];
        }, $records);


        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }

    // ✅ Fetch single faculty education record by faculty_id
    public function getFacultyEducationByUser($user_id)
    {
        $record = $this->facultyEducationModel
            ->where('faculty_id', $user_id)
            ->orderBy('year', 'ASC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No education record found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'       => $record['faculty_id'], // show faculty_id as user_id
                'category'      => $record['category'],
                'year_of_class' => $record['year_of_class'],
                'institute'     => $record['institute'],
                'town'          => $record['town'],
                'district'      => $record['district'],
                'state'         => $record['state'],
                'visibility'    => $record['visibility'],
                'created_at'    => $record['created_at'],
                'updated_at'    => $record['updated_at'],
            ]
        ]);
    }
}
