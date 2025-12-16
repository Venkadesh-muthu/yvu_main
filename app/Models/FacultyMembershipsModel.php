<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyMembershipsModel extends Model
{
    protected $table      = 'faculty_memberships';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'category',
        'title',
        'visibility',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
