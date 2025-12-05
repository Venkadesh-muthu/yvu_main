<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultySkillModel extends Model
{
    protected $table      = 'faculty_skills';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'skill_value',     // ✅ SINGLE COLUMN
        'visibility',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
