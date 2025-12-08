<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyActivitiesModel extends Model
{
    protected $table      = 'faculty_activities';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',        // Faculty reference
        'category',          // workshop, talk, membership, training
        'title',             // Title
        'type',              // International / National / Local
        'month_year',        // Month & Year
        'attended_or_role',  // Attended / Organised / Completed
        'location',          // Location
        'certificate_path', // Upload file
        'visibility',        // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
