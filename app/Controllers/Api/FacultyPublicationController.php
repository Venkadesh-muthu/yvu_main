<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyWorksModel;

class FacultyPublicationController extends BaseController
{
    protected $facultyWorksModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->facultyWorksModel = new FacultyWorksModel();
    }

    // ✅ Fetch all publications for a user
    public function getFacultyPublicationByUser($user_id)
    {
        $records = $this->facultyWorksModel
            ->where('faculty_id', $user_id)
            ->where('category', 'publication')  // Only publication type
            ->orderBy('id', 'DESC')
            ->findAll();

        if (!$records) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No publications found for this user.'
            ]);
        }

        $records = array_map(function ($record) {
            return [
                'user_id'    => $record['faculty_id'],
                'title'      => $record['title'],
                'role'       => $record['role'],
                'journal'    => $record['journal'],
                'type'       => $record['type'],
                'month_year' => $record['month_year'],
                'isbn_issn'  => $record['isbn_issn'],
                'url'        => $record['url'],
                'pdf_path'   => $record['pdf_path'],
                'visibility' => $record['visibility'],
                'created_at' => $record['created_at'],
                'updated_at' => $record['updated_at'],
            ];
        }, $records);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $records
        ]);
    }

    // ✅ Fetch single/latest publication
    public function getSingleFacultyPublicationByUser($user_id)
    {
        $record = $this->facultyWorksModel
            ->where('faculty_id', $user_id)
            ->where('category', 'publication') // Only publication type
            ->orderBy('id', 'DESC')
            ->first();

        if (!$record) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No publication found for this user.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user_id'    => $record['faculty_id'],
                'title'      => $record['title'],
                'role'       => $record['role'],
                'journal'    => $record['journal'],
                'type'       => $record['type'],
                'month_year' => $record['month_year'],
                'isbn_issn'  => $record['isbn_issn'],
                'url'        => $record['url'],
                'pdf_path'   => $record['pdf_path'],
                'visibility' => $record['visibility'],
                'created_at' => $record['created_at'],
                'updated_at' => $record['updated_at'],
            ]
        ]);
    }
}
