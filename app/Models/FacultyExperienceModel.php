<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyExperienceModel extends Model
{
    protected $table      = 'faculty_experience';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
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
    protected $updatedField  = 'updated_at'; // if you want to track updates
}
