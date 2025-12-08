<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyInformationModel extends Model
{
    protected $table      = 'faculty_information';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'type',         // 'extra_curricular', 'extension_community', 'relevant_information'
        'title',
        'agency',
        'from_year',
        'to_year',
        'status',       // completed / ongoing
        'upload_path',
        'visibility',   // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
