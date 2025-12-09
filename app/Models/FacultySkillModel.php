<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultySkillModel extends Model
{
    protected $table      = 'faculty_skills';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'category',        // ⭐ NEW FIELD (skill / specialisation / research)
        'skill_value',     // VALUE OF THE SKILL OR SPECIALISATION
        'visibility',      // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
