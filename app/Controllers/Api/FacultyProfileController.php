<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FacultyProfileModel;
use App\Models\FacultyProfileVisibilityModel;

class FacultyProfileController extends BaseController
{
    protected $profileModel;
    protected $visibilityModel;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->profileModel     = new FacultyProfileModel();
        $this->visibilityModel = new FacultyProfileVisibilityModel();
    }

    /* ==========================================================
       ✅ FETCH ALL FACULTY PROFILES (WITH VISIBILITY)
    ========================================================== */
    public function getFacultyProfiles()
    {
        $profiles = $this->profileModel
            ->orderBy('id', 'DESC')
            ->findAll();

        $finalData = [];

        foreach ($profiles as $profile) {

            $visibility = $this->visibilityModel
                ->where('faculty_profiles_id', $profile['id'])
                ->first();

            // Base safe fields (always allowed)
            $filteredProfile = [
                'id'         => $profile['id'],
                'user_id'    => $profile['user_id'],
                'created_at' => $profile['created_at'],
                'updated_at' => $profile['updated_at'],
            ];

            /* ---------- PHOTO VISIBILITY ---------- */
            if (
                !empty($profile['photo']) &&
                (
                    empty($visibility) ||
                    (isset($visibility['photo']) && $visibility['photo'] === 'view')
                )
            ) {
                $filteredProfile['photo'] = base_url(
                    'uploads/faculty/' . $profile['photo']
                );
            }

            /* ---------- OTHER FIELDS ---------- */
            foreach ($profile as $field => $value) {

                if (in_array($field, [
                    'id',
                    'user_id',
                    'photo',
                    'created_at',
                    'updated_at'
                ])) {
                    continue;
                }

                // No visibility row → show everything
                if (empty($visibility)) {
                    $filteredProfile[$field] = $value;
                }
                // Visibility exists → show only allowed fields
                elseif (isset($visibility[$field]) && $visibility[$field] === 'view') {
                    $filteredProfile[$field] = $value;
                }
            }

            $finalData[] = $filteredProfile;
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $finalData
        ]);
    }

    /* ==========================================================
       ✅ FETCH SINGLE FACULTY PROFILE (WITH VISIBILITY)
    ========================================================== */
    public function getFacultyProfile($user_id)
    {
        $profile = $this->profileModel
            ->where('user_id', $user_id)
            ->first();

        if (!$profile) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Faculty profile not found'
            ]);
        }

        $visibility = $this->visibilityModel
            ->where('faculty_profiles_id', $profile['id'])
            ->first();

        // Base safe fields
        $filteredProfile = [
            'id'         => $profile['id'],
            'user_id'    => $profile['user_id'],
            'created_at' => $profile['created_at'],
            'updated_at' => $profile['updated_at'],
        ];

        /* ---------- PHOTO VISIBILITY ---------- */
        if (
            !empty($profile['photo']) &&
            (
                empty($visibility) ||
                (isset($visibility['photo']) && $visibility['photo'] === 'view')
            )
        ) {
            $filteredProfile['photo'] = base_url(
                'uploads/faculty/' . $profile['photo']
            );
        }

        /* ---------- OTHER FIELDS ---------- */
        foreach ($profile as $field => $value) {

            if (in_array($field, [
                'id',
                'user_id',
                'photo',
                'created_at',
                'updated_at'
            ])) {
                continue;
            }

            if (empty($visibility)) {
                $filteredProfile[$field] = $value;
            } elseif (isset($visibility[$field]) && $visibility[$field] === 'view') {
                $filteredProfile[$field] = $value;
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $filteredProfile
        ]);
    }
}
