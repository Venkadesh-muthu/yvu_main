<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyEducationVisibilityModel extends Model
{
    protected $table = 'faculty_education_visibility';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_education_id',
        'category',
        'year_of_class',
        'institute',
        'town',
        'district',
        'state',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
