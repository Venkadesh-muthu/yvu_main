<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyAchievementModel extends Model
{
    protected $table      = 'faculty_achievements';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'section',        // Awards / Honors OR Patents / Intellectual Property
        'title',          // Award or Patent Title
        'description',
        'month_year',     // Month / Year
        'visibility',     // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
