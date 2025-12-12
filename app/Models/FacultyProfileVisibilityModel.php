<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultyProfileVisibilityModel extends Model
{
    protected $table = 'faculty_profile_visibility';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_profiles_id',
        'name',
        'about_me',
        'photo',
        'designation',
        'department',
        'employee_id',
        'cfms_no',
        'dob',
        'gender',
        'religion',
        'caste',
        'reservation',
        'address_residential',
        'address_office',
        'phone_no',
        'email_official',
        'aadhaar_no',
        'blood_group',
        'place_of_birth',
        'vidwan_url',
        'orcid_url',
        'scopus_url',
        'google_scholar_url',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
