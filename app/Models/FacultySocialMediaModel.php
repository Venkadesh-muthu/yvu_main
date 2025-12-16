<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultySocialMediaModel extends Model
{
    protected $table      = 'faculty_social_media';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',       // Faculty reference
        'instagram_link',   // Instagram profile URL
        'whatsapp_link',    // WhatsApp chat link
        'facebook_link',    // Facebook profile/page URL
        'twitter_link',     // Twitter/X profile URL
        'visibility',       // view / hide
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
