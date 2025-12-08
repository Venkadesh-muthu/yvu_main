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

    // ✅ FETCH ALL FACULTY PROFILES WITH SAFE VISIBILITY
    public function getFacultyProfiles()
    {
        $profiles = $this->profileModel
            ->orderBy('id', 'DESC')
            ->findAll();

        $finalData = [];

        foreach ($profiles as $profile) {

            // ✅ Fetch visibility (may be null)
            $visibility = $this->visibilityModel
                ->where('faculty_profiles_id', $profile['id'])
                ->first();

            // ✅ Always return base fields
            $filteredProfile = [
                'id'      => $profile['id'],
                'user_id' => $profile['user_id'],
                'photo'   => !empty($profile['photo'])
                    ? base_url('uploads/faculty/' . $profile['photo'])
                    : null
            ];

            // ✅ IF VISIBILITY EXISTS → APPLY FILTER
            if (!empty($visibility)) {
                foreach ($profile as $field => $value) {
                    if (
                        isset($visibility[$field]) &&
                        $visibility[$field] === 'view'
                    ) {
                        $filteredProfile[$field] = $value;
                    }
                }
            }
            // ✅ IF VISIBILITY DOES NOT EXIST → SHOW EVERYTHING
            else {
                foreach ($profile as $field => $value) {
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

    // ✅ FETCH SINGLE FACULTY PROFILE WITH SAFE VISIBILITY
    public function getFacultyProfile($user_id)
    {
        // ✅ Fetch profile by user_id instead of primary ID
        $profile = $this->profileModel->where('user_id', $user_id)->first();

        if (!$profile) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Faculty profile not found'
            ]);
        }

        // ✅ Fetch visibility using the actual profile ID
        $visibility = $this->visibilityModel
            ->where('faculty_profiles_id', $profile['id'])
            ->first();

        // ✅ Base response
        $filteredProfile = [
            'id'      => $profile['id'],
            'user_id' => $profile['user_id'],
            'photo'   => !empty($profile['photo'])
                ? base_url('uploads/faculty/' . $profile['photo'])
                : null
        ];

        // ✅ If visibility exists → show only fields with "view"
        if (!empty($visibility)) {
            foreach ($profile as $field => $value) {
                if (isset($visibility[$field]) && $visibility[$field] === 'view') {
                    $filteredProfile[$field] = $value;
                }
            }
        }
        // ✅ If visibility does not exist → show everything
        else {
            foreach ($profile as $field => $value) {
                $filteredProfile[$field] = $value;
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $filteredProfile
        ]);
    }

}
