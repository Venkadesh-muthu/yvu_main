<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyProjectsModel extends Model
{
    protected $table      = 'faculty_projects';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',     // Reference to faculty
        'title',          // Project title
        'agency',         // Funding Agency / Organization
        'from_year',      // Start year
        'to_year',        // End year
        'status',         // completed / ongoing
        'upload_path',    // Uploaded document path
        'visibility',     // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
