<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyWorksModel extends Model
{
    protected $table      = 'faculty_works';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',   // Reference to faculty
        'category',     // publication, book, editorial
        'title',        // Title of the work
        'role',         // Only for books/book chapters
        'journal',      // Journal or Publisher
        'type',         // International / National / Local
        'month_year',   // Month and Year
        'isbn_issn',    // ISBN or ISSN
        'url',        // URL column
        'pdf_path',   // PDF file column
        'visibility',   // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
