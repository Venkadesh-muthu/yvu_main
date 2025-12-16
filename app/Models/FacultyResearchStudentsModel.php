<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyResearchStudentsModel extends Model
{
    protected $table      = 'faculty_research_students';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',      // Faculty reference
        'student_type',
        'student_name',    // Student Name
        'topic_title',     // Research Topic / Title
        'type',            // PhD / MPhil / PG / UG / Other
        'from_year',       // Start Year
        'to_year',         // End Year
        'status',          // Completed / Ongoing
        'visibility',     // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
