<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyNewsModel extends Model
{
    protected $table      = 'faculty_news';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'title',
        'type',        // Intl / National / Local
        'month_year',
        'upload_path',
        'visibility'   // view / hide
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
