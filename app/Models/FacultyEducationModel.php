<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyEducationModel extends Model
{
    protected $table      = 'faculty_education';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'category',
        'course_subject',
        'year_of_class',
        'institute',
        'town',
        'district',
        'state',
        'visibility',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
