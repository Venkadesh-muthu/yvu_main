<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyExperienceVisibilityModel extends Model
{
    protected $table      = 'faculty_experience_visibility';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_experience_id',
        'section',
        'title_type',
        'title_value',
        'workplace',
        'from_date',
        'to_date',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
