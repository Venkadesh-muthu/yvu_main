<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FacultyProfileModel;
use App\Models\FacultyEducationModel;
use App\Models\FacultyProfileVisibilityModel;
use App\Models\FacultyExperienceModel;
use App\Models\FacultyAchievementModel;
use App\Models\FacultySkillModel;
use App\Models\FacultyWorksModel;
use App\Models\FacultyActivitiesModel;
use App\Models\FacultyResearchStudentsModel;
use App\Models\FacultyProjectsModel;
use App\Models\FacultyInformationModel;
use App\Models\FacultyNewsModel;
use App\Models\FacultySocialMediaModel;
use App\Models\FacultyMembershipsModel;

class FacultyController extends BaseController
{
    protected $profileModel;
    protected $eduModel;
    protected $ProfileVisibilityModel;
    protected $experienceModel;
    protected $achievementModel;
    protected $skillModel;
    protected $worksModel;
    protected $activitiesModel;
    protected $researchStudentsModel;
    protected $projectsModel;
    protected $informationModel;
    protected $newsModel;
    protected $socialMediaModel;
    protected $membershipsModel;




    public function __construct()
    {
        helper(['form']);
        $this->profileModel = new FacultyProfileModel();
        $this->eduModel = new FacultyEducationModel();
        $this->ProfileVisibilityModel = new FacultyProfileVisibilityModel();
        $this->experienceModel = new FacultyExperienceModel();
        $this->achievementModel = new FacultyAchievementModel();
        $this->skillModel = new FacultySkillModel();
        $this->worksModel = new FacultyWorksModel();
        $this->activitiesModel = new FacultyActivitiesModel();
        $this->researchStudentsModel = new FacultyResearchStudentsModel();
        $this->projectsModel = new FacultyProjectsModel();
        $this->informationModel = new FacultyInformationModel();
        $this->newsModel = new FacultyNewsModel();
        $this->socialMediaModel = new FacultySocialMediaModel();
        $this->membershipsModel = new FacultyMembershipsModel();



        $this->updateProfileExistsSession();
    }

    private function checkFacultyLogin()
    {
        if (!session()->get('isFacultyLoggedIn')) {
            return redirect()->to('/');
        }
    }

    // ---------------------------------------------------------
    // FACULTY DASHBOARD
    // ---------------------------------------------------------
    public function dashboard()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Faculty Dashboard',
            'content' => 'faculty/dashboard',
        ];
        return view('faculty/layout/template', $data);
    }

    // ---------------------------------------------------------
    // VIEW PROFILE
    // ---------------------------------------------------------
    public function profile()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // Fetch profile
        $profile = $this->profileModel->where('user_id', $facultyId)->first();

        // Fetch visibility values
        $visibility = [];
        if ($profile) {
            // Get the visibility row for this profile
            $visRow = $this->ProfileVisibilityModel
                           ->where('faculty_profiles_id', $profile['id'])
                           ->first();

            if ($visRow) {
                // Loop through all columns except id, faculty_profiles_id, created_at, updated_at
                foreach ($visRow as $field => $status) {
                    if (!in_array($field, ['id', 'faculty_profiles_id', 'created_at', 'updated_at'])) {
                        $visibility[$field] = $status; // 'view' or 'hide'
                    }
                }
            }
        }

        $data = [
            'title'      => 'Faculty Profile',
            'content'    => 'faculty/profile',
            'profile'    => $profile,
            'visibility' => $visibility
        ];

        return view('faculty/layout/template', $data);
    }

    // ---------------------------------------------------------
    // ADD PROFILE (FORM)
    // ---------------------------------------------------------
    public function add_profile()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }
        $data = [
            'title'   => 'Faculty Profile',
            'content' => 'faculty/add_profile',
        ];

        return view('faculty/layout/template', $data);
    }

    // ---------------------------------------------------------
    // SAVE PROFILE
    // ---------------------------------------------------------
    public function save_profile()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $photo = $this->request->getFile('photo');
        $photoName = null;

        if ($photo && $photo->isValid()) {
            $photoName = $photo->getRandomName();
            $photo->move('uploads/faculty', $photoName);
        }

        $data = [
            'user_id'             => $facultyId,
            'name'                => $this->request->getPost('name'),
            'about_me'                => $this->request->getPost('about_me'),
            'photo'               => $photoName,
            'designation'         => $this->request->getPost('designation'),
            'department'          => $this->request->getPost('department'),
            'employee_id'         => $this->request->getPost('employee_id'),
            'cfms_no'             => $this->request->getPost('cfms_no'),
            'dob'                 => $this->request->getPost('dob'),
            'gender'              => $this->request->getPost('gender'),
            'religion'            => $this->request->getPost('religion'),
            'caste'               => $this->request->getPost('caste'),
            'reservation'         => $this->request->getPost('reservation'),
            'address_residential' => $this->request->getPost('address_residential'),
            'address_office'      => $this->request->getPost('address_office'),
            'phone_no'            => $this->request->getPost('phone_no'),
            'email_official'      => $this->request->getPost('email_official'),
            'aadhaar_no'          => $this->request->getPost('aadhaar_no'),
            'blood_group'         => $this->request->getPost('blood_group'),
            'place_of_birth'      => $this->request->getPost('place_of_birth'),
            'vidwan_url'          => $this->request->getPost('vidwan_url'),
            'orcid_url'           => $this->request->getPost('orcid_url'),
            'scopus_url'          => $this->request->getPost('scopus_url'),
            'google_scholar_url'  => $this->request->getPost('google_scholar_url'),
        ];

        $this->profileModel->save($data);

        return redirect()->to('/faculty/profile')->with('success', 'Profile created successfully.');
    }

    // ---------------------------------------------------------
    // EDIT PROFILE
    // ---------------------------------------------------------
    public function edit_profile($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // security: allow editing only own profile
        $profile = $this->profileModel->where('id', $id)->where('user_id', $facultyId)->first();

        if (!$profile) {
            return redirect()->to('/faculty/profile')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'   => 'Faculty Profile',
            'content' => 'faculty/edit_profile',
            'profile' => $profile,
        ];

        return view('faculty/layout/template', $data);
    }

    // ---------------------------------------------------------
    // UPDATE PROFILE
    // ---------------------------------------------------------
    public function update_profile($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');
        $profile = $this->profileModel->where('id', $id)->where('user_id', $facultyId)->first();

        if (!$profile) {
            return redirect()->to('/faculty/profile')->with('error', 'Unauthorized access.');
        }

        // Photo update
        $photo = $this->request->getFile('photo');
        $photoName = $profile['photo'];

        if ($photo && $photo->isValid()) {
            $photoName = $photo->getRandomName();
            $photo->move('uploads/faculty', $photoName);
        }

        $data = [
            'name'                => $this->request->getPost('name'),
            'about_me'            => $this->request->getPost('about_me'),
            'photo'               => $photoName,
            'designation'         => $this->request->getPost('designation'),
            'department'          => $this->request->getPost('department'),
            'employee_id'         => $this->request->getPost('employee_id'),
            'cfms_no'             => $this->request->getPost('cfms_no'),
            'dob'                 => $this->request->getPost('dob'),
            'gender'              => $this->request->getPost('gender'),
            'religion'            => $this->request->getPost('religion'),
            'caste'               => $this->request->getPost('caste'),
            'reservation'         => $this->request->getPost('reservation'),
            'address_residential' => $this->request->getPost('address_residential'),
            'address_office'      => $this->request->getPost('address_office'),
            'phone_no'            => $this->request->getPost('phone_no'),
            'email_official'      => $this->request->getPost('email_official'),
            'aadhaar_no'          => $this->request->getPost('aadhaar_no'),
            'blood_group'         => $this->request->getPost('blood_group'),
            'place_of_birth'      => $this->request->getPost('place_of_birth'),
            'vidwan_url'          => $this->request->getPost('vidwan_url'),
            'orcid_url'           => $this->request->getPost('orcid_url'),
            'scopus_url'          => $this->request->getPost('scopus_url'),
            'google_scholar_url'  => $this->request->getPost('google_scholar_url'),
        ];

        $this->profileModel->update($id, $data);

        return redirect()->to('/faculty/profile')->with('success', 'Profile updated successfully.');
    }

    // ---------------------------------------------------------
    // DELETE PROFILE
    // ---------------------------------------------------------
    public function delete_profile($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // ✅ Verify profile belongs to this faculty
        $profile = $this->profileModel
            ->where('id', $id)
            ->where('user_id', $facultyId)
            ->first();

        if (!$profile) {
            return redirect()->to('/faculty/profile')->with('error', 'Unauthorized access.');
        }

        // ✅ DELETE PROFILE VISIBILITY FIRST
        $this->ProfileVisibilityModel
            ->where('faculty_profiles_id', $id)
            ->delete();

        // ✅ DELETE PROFILE
        $this->profileModel->delete($id);

        return redirect()->to('/faculty/profile')->with('success', 'Profile deleted successfully.');
    }

    public function updateProfileDetailsVisibility()
    {
        $request = service('request');

        // Only allow POST requests
        if ($request->getMethod(true) !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }

        // Get POST data
        $faculty_profiles_id = $request->getPost('faculty_profiles_id');
        $field     = $request->getPost('field');   // e.g., 'vidwan_url'
        $status    = $request->getPost('status');  // 'view' or 'hide'

        if (empty($faculty_profiles_id) || empty($field) || empty($status)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Missing required data'
            ]);
        }

        // Load your visibility model
        $visibilityModel = new \App\Models\FacultyProfileVisibilityModel();

        // Check if a row already exists for this faculty
        $row = $visibilityModel->where('faculty_profiles_id', $faculty_profiles_id)->first();

        if ($row) {
            // Update the specific column (dynamic field)
            $visibilityModel->update($row['id'], [
                $field => $status
            ]);
        } else {
            // Insert new row with default 'hide' for other fields
            $data = [
                'faculty_profiles_id' => $faculty_profiles_id,
                $field       => $status
            ];
            $visibilityModel->insert($data);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Visibility updated'
        ]);
    }
    protected function updateProfileExistsSession()
    {
        $facultyId = session()->get('faculty_id');

        $db = \Config\Database::connect();

        $exists = $db->table('faculty_profiles')
                     ->where('user_id', $facultyId)
                     ->countAllResults() > 0;

        session()->set('profileExists', $exists);
    }

    public function educations()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $education = $this->eduModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();
        $data = [
            'title'      => 'Educational Background',
            'content'    => 'faculty/educations',
            'education'  => $education
        ];

        return view('faculty/layout/template', $data);
    }

    public function add_education()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Educational Background',
            'content' => 'faculty/add_education'
        ];

        return view('faculty/layout/template', $data);
    }
    public function save_education()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // Get arrays from POST
        $categories = $this->request->getPost('category');
        $years      = $this->request->getPost('year_class');
        $institutes = $this->request->getPost('institute');
        $towns      = $this->request->getPost('town');
        $districts  = $this->request->getPost('district');
        $states     = $this->request->getPost('state');

        // Loop through all entries
        foreach ($categories as $index => $category) {
            $data = [
                'faculty_id'    => $facultyId,
                'category'      => $category,
                'year_of_class' => $years[$index] ?? '',
                'institute'     => $institutes[$index] ?? '',
                'town'          => $towns[$index] ?? '',
                'district'      => $districts[$index] ?? '',
                'state'         => $states[$index] ?? '',
            ];

            $this->eduModel->save($data);
        }

        return redirect()->to('/faculty/educations')->with('success', 'Education added successfully.');
    }

    public function edit_education($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->eduModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/educations')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'      => 'Educational Background',
            'content'    => 'faculty/edit_education',
            'education'  => $row
        ];

        return view('faculty/layout/template', $data);
    }
    public function update_education()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // Get all form inputs
        $ids         = $this->request->getPost('id'); // may contain empty values for new rows
        $categories  = $this->request->getPost('category');
        $years       = $this->request->getPost('year_class');
        $institutes  = $this->request->getPost('institute');
        $towns       = $this->request->getPost('town');
        $districts   = $this->request->getPost('district');
        $states      = $this->request->getPost('state');

        foreach ($categories as $key => $category) {
            $data = [
                'faculty_id'    => $facultyId,
                'category'      => $category,
                'year_of_class' => $years[$key],
                'institute'     => $institutes[$key],
                'town'          => $towns[$key],
                'district'      => $districts[$key],
                'state'         => $states[$key],
            ];

            if (!empty($ids[$key])) {
                // Update existing row
                $this->eduModel->update($ids[$key], $data);
            } else {
                // Insert new row
                $this->eduModel->insert($data);
            }
        }

        return redirect()->to('/faculty/educations')->with('success', 'Education updated successfully.');
    }

    public function delete_education($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // ✅ Verify ownership
        $row = $this->eduModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/educations')->with('error', 'Unauthorized access.');
        }

        // ✅ DELETE EDUCATION DATA
        $this->eduModel->delete($id);

        return redirect()->to('/faculty/educations')->with('success', 'Education deleted successfully.');
    }

    public function updateEducationVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $eduId  = $this->request->getPost('faculty_education_id');

        $edu = $this->eduModel->find($eduId);
        if (!$edu) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Education not found']);
        }

        // Toggle visibility
        $newStatus = ($edu['visibility'] === 'view') ? 'hide' : 'view';

        $this->eduModel->update($eduId, ['visibility' => $newStatus]);

        return $this->response->setJSON(['status' => 'success', 'newVisibility' => $newStatus]);
    }


    // ---------------------- EXPERIENCE FUNCTIONS ----------------------

    public function experiences()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $experience = $this->experienceModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Experience',
            'content'     => 'faculty/experiences',
            'experience'  => $experience
        ];

        return view('faculty/layout/template', $data);
    }

    public function add_experience()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Experience',
            'content' => 'faculty/add_experience'
        ];

        return view('faculty/layout/template', $data);
    }

    public function save_experience()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // Get arrays from POST
        $sections    = $this->request->getPost('section');
        $titleTypes  = $this->request->getPost('title_type');
        $titleValues = $this->request->getPost('title_value');
        $workplaces  = $this->request->getPost('workplace');
        $fromDates   = $this->request->getPost('from_date');
        $toDates     = $this->request->getPost('to_date');

        foreach ($sections as $index => $section) {
            $data = [
                'faculty_id'  => $facultyId,
                'section'     => $section,
                'title_type'  => $titleTypes[$index] ?? '',
                'title_value' => $titleValues[$index] ?? '',
                'workplace'   => $workplaces[$index] ?? '',
                'from_date'   => $fromDates[$index] ?? null,
                'to_date'     => $toDates[$index] ?? null
            ];

            $this->experienceModel->save($data);
        }

        return redirect()->to('/faculty/experiences')->with('success', 'Experience added successfully.');
    }

    public function edit_experience($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->experienceModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/experiences')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'      => 'Experience',
            'content'    => 'faculty/edit_experience',
            'experience' => $row
        ];

        return view('faculty/layout/template', $data);
    }

    public function update_experience()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids          = $this->request->getPost('id'); // may contain empty values for new rows
        $sections     = $this->request->getPost('section');
        $titleTypes   = $this->request->getPost('title_type');
        $titleValues  = $this->request->getPost('title_value');
        $workplaces   = $this->request->getPost('workplace');
        $fromDates    = $this->request->getPost('from_date');
        $toDates      = $this->request->getPost('to_date');

        foreach ($sections as $key => $section) {
            $data = [
                'faculty_id'  => $facultyId,
                'section'     => $section,
                'title_type'  => $titleTypes[$key],
                'title_value' => $titleValues[$key],
                'workplace'   => $workplaces[$key],
                'from_date'   => $fromDates[$key],
                'to_date'     => $toDates[$key],
            ];

            if (!empty($ids[$key])) {
                $this->experienceModel->update($ids[$key], $data);
            } else {
                $this->experienceModel->insert($data);
            }
        }

        return redirect()->to('/faculty/experiences')->with('success', 'Experience updated successfully.');
    }

    public function delete_experience($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->experienceModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/experiences')->with('error', 'Unauthorized access.');
        }
        // Delete experience row
        $this->experienceModel->delete($id);

        return redirect()->to('/faculty/experiences')->with('success', 'Experience deleted successfully.');
    }

    public function updateExperienceVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $expId = $this->request->getPost('faculty_experience_id');

        $exp = $this->experienceModel->find($expId);
        if (!$exp) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Experience not found']);
        }

        // Toggle visibility
        $newStatus = ($exp['visibility'] === 'view') ? 'hide' : 'view';

        $this->experienceModel->update($expId, ['visibility' => $newStatus]);

        return $this->response->setJSON(['status' => 'success', 'newVisibility' => $newStatus]);
    }
    public function achievements()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $achievements = $this->achievementModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'        => 'Achievements',
            'content'      => 'faculty/achievements',
            'achievements' => $achievements
        ];

        return view('faculty/layout/template', $data);
    }
    public function add_achievement()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Achievements',
            'content' => 'faculty/add_achievement'
        ];

        return view('faculty/layout/template', $data);
    }
    public function save_achievement()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $sections     = $this->request->getPost('section');
        $titles       = $this->request->getPost('title');
        $descriptions = $this->request->getPost('description');
        $monthYears   = $this->request->getPost('month_year');

        foreach ($sections as $index => $section) {
            $data = [
                'faculty_id'  => $facultyId,
                'section'     => $section,
                'title'       => $titles[$index] ?? '',
                'description' => $descriptions[$index] ?? '',
                'month_year'  => $monthYears[$index] ?? '',
                'visibility'  => 0
            ];

            $this->achievementModel->save($data);
        }

        return redirect()->to('/faculty/achievements')->with('success', 'Achievement added successfully.');
    }
    public function edit_achievement($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->achievementModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/achievements')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'       => 'Achievements',
            'content'     => 'faculty/edit_achievement',
            'achievement' => $row
        ];

        return view('faculty/layout/template', $data);
    }
    public function update_achievement()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids          = $this->request->getPost('id');
        $sections     = $this->request->getPost('section');
        $titles       = $this->request->getPost('title');
        $descriptions = $this->request->getPost('description');
        $monthYears   = $this->request->getPost('month_year');

        foreach ($sections as $key => $section) {
            $data = [
                'faculty_id'  => $facultyId,
                'section'     => $section,
                'title'       => $titles[$key],
                'description' => $descriptions[$key],
                'month_year'  => $monthYears[$key],
            ];

            if (!empty($ids[$key])) {
                $this->achievementModel->update($ids[$key], $data);
            } else {
                $this->achievementModel->insert($data);
            }
        }

        return redirect()->to('/faculty/achievements')->with('success', 'Achievement updated successfully.');
    }
    public function delete_achievement($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->achievementModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/achievements')->with('error', 'Unauthorized access.');
        }

        $this->achievementModel->delete($id);

        return redirect()->to('/faculty/achievements')->with('success', 'Achievement deleted successfully.');
    }
    public function updateAchievementVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $achId = $this->request->getPost('achievement_id');

        $ach = $this->achievementModel->find($achId);
        if (!$ach) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($ach['visibility'] == 1) ? 0 : 1;

        $this->achievementModel->update($achId, ['visibility' => $newStatus]);

        return $this->response->setJSON([
            'status' => 'success',
            'newVisibility' => $newStatus
        ]);
    }
    /* ---------------------------------------------------
 |  SKILLS / SPECIALISATION / RESEARCH AREA CRUD
 ----------------------------------------------------*/

    public function skills()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $skills = $this->skillModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Skills',
            'content'  => 'faculty/skills',
            'skills'   => $skills
        ];

        return view('faculty/layout/template', $data);
    }


    /* ---------------- ADD FORM ---------------- */

    public function add_skill()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Skills',
            'content' => 'faculty/add_skill'
        ];

        return view('faculty/layout/template', $data);
    }


    /* ---------------- SAVE ---------------- */

    public function save_skill()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // Get arrays
        $skills     = $this->request->getPost('skill_value');
        $categories = $this->request->getPost('category');  // NEW

        // Ensure arrays
        if (!is_array($skills)) {
            $skills = [];
        }

        if (!is_array($categories)) {
            $categories = [];
        }

        foreach ($skills as $index => $skill) {

            if (!empty($skill)) {

                // Set category or default to 'skill'
                $category = $categories[$index] ?? 'skill';

                $this->skillModel->insert([
                    'faculty_id'  => $facultyId,
                    'skill_value' => $skill,
                    'category'    => $category, // NEW
                ]);
            }
        }

        return redirect()->to('/faculty/skills')->with('success', 'Skills added successfully.');
    }


    /* ---------------- EDIT FORM ---------------- */

    public function edit_skill($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $skill = $this->skillModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$skill) {
            return redirect()->to('/faculty/skills')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'   => 'Skills',
            'content' => 'faculty/edit_skill', // your view file
            'skill'   => $skill // only the selected skill
        ];

        return view('faculty/layout/template', $data);
    }


    /* ---------------- UPDATE ---------------- */

    public function update_skill()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids        = $this->request->getPost('id');          // existing IDs
        $skills     = $this->request->getPost('skill_value'); // skill names
        $categories = $this->request->getPost('category');    // categories (NEW)

        if (!empty($skills) && is_array($skills)) {

            foreach ($skills as $key => $skillValue) {

                if (!empty($skillValue)) {

                    // Prepare data
                    $data = [
                        'faculty_id'  => $facultyId,
                        'skill_value' => $skillValue,
                        'category'    => $categories[$key] ?? 'skill' // NEW
                    ];

                    if (!empty($ids[$key])) {
                        // ⭐ Update existing row
                        $this->skillModel->update($ids[$key], $data);
                    } else {
                        // ⭐ Insert new row
                        $this->skillModel->insert($data);
                    }
                }
            }
        }

        return redirect()->to('/faculty/skills')->with('success', 'Skills updated successfully.');
    }


    /* ---------------- DELETE ---------------- */

    public function delete_skill($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->skillModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/skills')->with('error', 'Unauthorized access.');
        }

        $this->skillModel->delete($id);

        return redirect()->to('/faculty/skills')->with('success', 'Skill deleted successfully.');
    }


    /* ---------------- VISIBILITY TOGGLE (AJAX) ---------------- */

    public function updateSkillVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $skillId = $this->request->getPost('faculty_skill_id');

        $skill = $this->skillModel->find($skillId);

        if (!$skill) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Skill not found'
            ]);
        }

        $newStatus = ($skill['visibility'] === 'view') ? 'hide' : 'view';

        $this->skillModel->update($skillId, [
            'visibility' => $newStatus
        ]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }

    public function works()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $works = $this->worksModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'   => 'Works',
            'content' => 'faculty/works',
            'works'   => $works
        ];

        return view('faculty/layout/template', $data);
    }

    // ================== Add Work ==================
    public function add_work()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Works',
            'content' => 'faculty/add_work'
        ];

        return view('faculty/layout/template', $data);
    }

    // ================== Save Work ==================
    public function save_work()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId  = session()->get('faculty_id');

        $categories = $this->request->getPost('category');
        $titles     = $this->request->getPost('title');
        $roles      = $this->request->getPost('role');
        $journals   = $this->request->getPost('journal');
        $types      = $this->request->getPost('type');
        $monthYears = $this->request->getPost('month_year');
        $isbnIssn   = $this->request->getPost('isbn_issn');
        $urls       = $this->request->getPost('url'); // matches form input name

        // ✅ Get multiple files correctly for input name "pdf_file[]"
        $pdfFiles = $this->request->getFileMultiple('pdf_file');

        foreach ($categories as $key => $category) {

            // Correct title logic for Book category
            if (strtolower($category) === 'book') {
                $titleToSave = $roles[$key] ?? '';
            } else {
                $titleToSave = $titles[$key] ?? '';
            }

            // Skip row if all important fields are empty
            if (empty($titleToSave) && empty($journals[$key]) && empty($types[$key])) {
                continue;
            }

            // Handle PDF upload
            $pdfPath = '';
            if (isset($pdfFiles[$key]) && $pdfFiles[$key]->isValid() && !$pdfFiles[$key]->hasMoved()) {

                $file = $pdfFiles[$key];

                // Optional: validate extension
                if (strtolower($file->getExtension()) === 'pdf') {
                    $newName = $file->getRandomName();

                    // Save to public/uploads so it is accessible via browser
                    $file->move(FCPATH . 'uploads/works', $newName);

                    $pdfPath = 'uploads/works/' . $newName;
                }
            }

            // Insert row
            $this->worksModel->insert([
                'faculty_id' => $facultyId,
                'category'   => $category,
                'title'      => $titleToSave,
                'role'       => $roles[$key] ?? '',
                'journal'    => $journals[$key] ?? '',
                'type'       => $types[$key] ?? '',
                'month_year' => $monthYears[$key] ?? '',
                'isbn_issn'  => $isbnIssn[$key] ?? '',
                'url'        => $urls[$key] ?? '',
                'pdf_path'   => $pdfPath,
                'visibility' => 'hide'
            ]);
        }

        return redirect()->to('/faculty/works')->with('success', 'Works added successfully.');
    }



    // ================== Edit Work ==================
    public function edit_work($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->worksModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/works')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'   => 'Works',
            'content' => 'faculty/edit_work',
            'works'   => [$row] // wrap in an array for the form loop
        ];

        return view('faculty/layout/template', $data);
    }


    // ================== Update Work ==================
    public function update_work()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids        = $this->request->getPost('id');
        $categories = $this->request->getPost('category');
        $titles     = $this->request->getPost('title');
        $roles      = $this->request->getPost('role');
        $journals   = $this->request->getPost('journal');
        $types      = $this->request->getPost('type');
        $monthYears = $this->request->getPost('month_year');
        $isbnIssns  = $this->request->getPost('isbn_issn');
        $urls       = $this->request->getPost('url');

        // ✅ Correctly handle multiple files
        $pdfFiles = $this->request->getFileMultiple('pdf_file');

        if (!is_array($categories)) {
            return redirect()->back()->with('error', 'No work data received.');
        }

        foreach ($categories as $key => $category) {

            // ✅ Book category title logic
            $titleToSave = (strtolower($category) === 'book') ? ($roles[$key] ?? '') : ($titles[$key] ?? '');

            if (empty($category) || empty($titleToSave)) {
                continue;
            }

            // ✅ Keep old PDF if no new file uploaded
            $pdfPath = null;
            if (!empty($ids[$key])) {
                $oldWork = $this->worksModel->find($ids[$key]);
                $pdfPath = $oldWork['pdf_path'] ?? null;
            }

            // ✅ Upload new PDF if exists
            if (isset($pdfFiles[$key]) && $pdfFiles[$key]->isValid() && !$pdfFiles[$key]->hasMoved()) {
                $file = $pdfFiles[$key];

                // Optional: validate extension
                if (strtolower($file->getExtension()) === 'pdf') {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/works', $newName); // ✅ save in public folder
                    $pdfPath = 'uploads/works/' . $newName;
                }
            }

            $data = [
                'faculty_id' => $facultyId,
                'category'   => $category,
                'title'      => $titleToSave,
                'role'       => $roles[$key] ?? null,
                'journal'    => $journals[$key] ?? null,
                'type'       => $types[$key] ?? null,
                'month_year' => $monthYears[$key] ?? null,
                'isbn_issn'  => $isbnIssns[$key] ?? null,
                'url'        => $urls[$key] ?? null,
                'pdf_path'   => $pdfPath,
            ];

            if (!empty($ids[$key])) {
                $this->worksModel->update($ids[$key], $data);
            } else {
                $this->worksModel->insert($data);
            }
        }

        return redirect()->to('/faculty/works')->with('success', 'Works updated successfully.');
    }


    // ================== Delete Work ==================
    public function delete_work($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->worksModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/works')->with('error', 'Unauthorized access.');
        }

        $this->worksModel->delete($id);

        return redirect()->to('/faculty/works')->with('success', 'Work deleted successfully.');
    }

    // ================== Toggle Visibility ==================
    public function updateWorkVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $workId = $this->request->getPost('faculty_work_id');

        $work = $this->worksModel->find($workId);
        if (!$work) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Work not found']);
        }

        $newStatus = ($work['visibility'] === 'view') ? 'hide' : 'view';
        $this->worksModel->update($workId, ['visibility' => $newStatus]);

        return $this->response->setJSON(['status' => 'success', 'newVisibility' => $newStatus]);
    }
    public function activities()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $activities = $this->activitiesModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'      => 'Activities',
            'content'    => 'faculty/activities',
            'activities' => $activities
        ];

        return view('faculty/layout/template', $data);
    }
    public function add_activity()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Activities',
            'content' => 'faculty/add_activity'
        ];

        return view('faculty/layout/template', $data);
    }
    public function save_activity()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $categories  = $this->request->getPost('category');
        $titles      = $this->request->getPost('title');
        $types       = $this->request->getPost('type');
        $monthYears  = $this->request->getPost('month_year');
        $roles       = $this->request->getPost('attended_or_role');
        $locations   = $this->request->getPost('location');

        $files = $this->request->getFileMultiple('certificate');

        foreach ($categories as $key => $category) {

            if (empty($titles[$key])) {
                continue;
            }

            $filePath = '';
            if (isset($files[$key]) && $files[$key]->isValid() && !$files[$key]->hasMoved()) {
                $newName = $files[$key]->getRandomName();
                $files[$key]->move(FCPATH . 'uploads/activities', $newName);
                $filePath = 'uploads/activities/' . $newName;
            }

            $this->activitiesModel->insert([
                'faculty_id'       => $facultyId,
                'category'         => $category,
                'title'            => $titles[$key],
                'type'             => $types[$key],
                'month_year'       => $monthYears[$key],
                'attended_or_role' => $roles[$key],
                'location'         => $locations[$key],
                'certificate_path' => $filePath,
                'visibility'       => 'hide'
            ]);
        }

        return redirect()->to('/faculty/activities')->with('success', 'Activities added successfully.');
    }
    public function edit_activity($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->activitiesModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/activities')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'      => 'Activities',
            'content'    => 'faculty/edit_activity',
            'activities' => [$row]
        ];

        return view('faculty/layout/template', $data);
    }
    public function update_activity()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids        = $this->request->getPost('id');
        $categories = $this->request->getPost('category');
        $titles     = $this->request->getPost('title');
        $types      = $this->request->getPost('type');
        $monthYears = $this->request->getPost('month_year');
        $roles      = $this->request->getPost('attended_or_role');
        $locations  = $this->request->getPost('location');

        $files = $this->request->getFileMultiple('certificate');

        foreach ($categories as $key => $category) {

            $filePath = null;

            // ✅ IF RECORD EXISTS → KEEP OLD FILE
            if (!empty($ids[$key])) {
                $old = $this->activitiesModel->find($ids[$key]);
                $filePath = $old['certificate_path'] ?? null;
            }

            // ✅ IF NEW FILE UPLOADED → REPLACE
            if (isset($files[$key]) && $files[$key]->isValid() && !$files[$key]->hasMoved()) {
                $newName = $files[$key]->getRandomName();
                $files[$key]->move(FCPATH . 'uploads/activities', $newName);
                $filePath = 'uploads/activities/' . $newName;
            }

            $data = [
                'faculty_id'       => $facultyId,
                'category'         => $category,
                'title'            => $titles[$key],
                'type'             => $types[$key] ?? null,
                'month_year'       => $monthYears[$key] ?? null,
                'attended_or_role' => $roles[$key] ?? null,
                'location'         => $locations[$key] ?? null,
                'certificate_path' => $filePath,
            ];

            // ✅ ✅ KEY FIX:
            if (!empty($ids[$key])) {
                // ✅ UPDATE EXISTING
                $this->activitiesModel->update($ids[$key], $data);
            } else {
                // ✅ INSERT NEW ROW
                $this->activitiesModel->insert($data);
            }
        }

        return redirect()->to('/faculty/activities')
            ->with('success', 'Activities updated successfully.');
    }

    public function delete_activity($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->activitiesModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/activities')->with('error', 'Unauthorized access.');
        }

        $this->activitiesModel->delete($id);

        return redirect()->to('/faculty/activities')->with('success', 'Activity deleted successfully.');
    }
    public function updateActivityVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $activityId = $this->request->getPost('activity_id');

        $activity = $this->activitiesModel->find($activityId);

        if (!$activity) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($activity['visibility'] === 'view') ? 'hide' : 'view';

        $this->activitiesModel->update($activityId, [
            'visibility' => $newStatus
        ]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }
    // ======================= LIST RESEARCH STUDENTS =======================
    public function research_students()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $researchStudents = $this->researchStudentsModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Research Students',
            'content'  => 'faculty/research_students',
            'researchStudents' => $researchStudents
        ];

        return view('faculty/layout/template', $data);
    }


    // ======================= ADD RESEARCH STUDENT =======================
    public function add_research_student()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Research Students',
            'content' => 'faculty/add_research_student'
        ];

        return view('faculty/layout/template', $data);
    }


    // ======================= SAVE RESEARCH STUDENT =======================
    public function save_research_student()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $studentTypes = $this->request->getPost('student_type');
        $names        = $this->request->getPost('student_name');
        $topics       = $this->request->getPost('topic_title');
        $types        = $this->request->getPost('type');
        $froms        = $this->request->getPost('from_year');
        $tos          = $this->request->getPost('to_year');
        $statuses     = $this->request->getPost('status');

        foreach ($names as $key => $name) {

            if (empty($name)) {
                continue;
            }

            $this->researchStudentsModel->insert([
                'faculty_id'    => $facultyId,
                'student_name'  => $name,
                'student_type'  => $studentTypes[$key] ?? null, // ✅ ADDED
                'topic_title'   => $topics[$key] ?? null,
                'type'          => $types[$key] ?? null,
                'from_year'     => $froms[$key] ?? null,
                'to_year'       => $tos[$key] ?? null,
                'status'        => $statuses[$key] ?? null,
                'visibility'    => 'hide'
            ]);
        }

        return redirect()->to('/faculty/students')
            ->with('success', 'Research Students added successfully.');
    }

    // ======================= EDIT RESEARCH STUDENT =======================
    public function edit_research_student($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->researchStudentsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/students')
                ->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'    => 'Research Students',
            'content'  => 'faculty/edit_research_student',
            'research' => [$row]
        ];

        return view('faculty/layout/template', $data);
    }


    // ======================= UPDATE RESEARCH STUDENT =======================
    public function update_research_student()
    {
        // Check faculty login
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // Get all POST data
        $ids          = $this->request->getPost('id') ?? [];
        $studentTypes = $this->request->getPost('student_type') ?? []; // ✅ ADDED
        $names        = $this->request->getPost('student_name') ?? [];
        $topics       = $this->request->getPost('topic_title') ?? [];
        $types        = $this->request->getPost('type') ?? [];
        $froms        = $this->request->getPost('from_year') ?? [];
        $tos          = $this->request->getPost('to_year') ?? [];
        $statuses     = $this->request->getPost('status') ?? [];

        foreach ($names as $key => $name) {

            // Skip empty names
            if (empty($name)) {
                continue;
            }

            $data = [
                'faculty_id'    => $facultyId,
                'student_name'  => $name,
                'student_type'  => $studentTypes[$key] ?? null, // ✅ ADDED
                'topic_title'   => $topics[$key] ?? null,
                'type'          => $types[$key] ?? null,
                'from_year'     => $froms[$key] ?? null,
                'to_year'       => $tos[$key] ?? null,
                'status'        => $statuses[$key] ?? null,
                'visibility'    => 'hide'
            ];

            // Update if ID exists, otherwise insert new
            if (!empty($ids[$key])) {
                $this->researchStudentsModel->update($ids[$key], $data);
            } else {
                $this->researchStudentsModel->insert($data);
            }
        }

        return redirect()->to('/faculty/students')
                         ->with('success', 'Research Students updated successfully.');
    }


    // ======================= DELETE RESEARCH STUDENT =======================
    public function delete_research_student($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->researchStudentsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/students')
                ->with('error', 'Unauthorized access.');
        }

        $this->researchStudentsModel->delete($id);

        return redirect()->to('/faculty/students')
            ->with('success', 'Research Student deleted successfully.');
    }


    // ======================= TOGGLE VISIBILITY =======================
    public function updateResearchStudentVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $studentId = $this->request->getPost('student_id');

        $student = $this->researchStudentsModel->find($studentId);

        if (!$student) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($student['visibility'] === 'view') ? 'hide' : 'view';

        $this->researchStudentsModel->update($studentId, [
            'visibility' => $newStatus
        ]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }
    public function projects()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $projects = $this->projectsModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Projects',
            'content'  => 'faculty/projects',
            'projects' => $projects
        ];

        return view('faculty/layout/template', $data);
    }

    // ✅ ADD PROJECT FORM
    public function add_project()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Add Project',
            'content' => 'faculty/add_project'
        ];

        return view('faculty/layout/template', $data);
    }

    // ✅ SAVE NEW PROJECT
    public function save_project()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $titles    = $this->request->getPost('title');
        $agencies  = $this->request->getPost('agency');
        $fromYears = $this->request->getPost('from_year');
        $toYears   = $this->request->getPost('to_year');
        $statuses  = $this->request->getPost('status');

        // Get all uploaded files safely
        $files = $this->request->getFiles(); // Returns all $_FILES

        foreach ($titles as $key => $title) {

            if (empty($title)) {
                continue;
            }

            $filePath = '';
            if (isset($files['file'][$key]) && $files['file'][$key]->isValid() && !$files['file'][$key]->hasMoved()) {
                $newName = $files['file'][$key]->getRandomName();
                $files['file'][$key]->move(FCPATH . 'uploads/projects', $newName);
                $filePath = 'uploads/projects/' . $newName;
            }

            $this->projectsModel->insert([
                'faculty_id'  => $facultyId,
                'title'       => $title,
                'agency'      => $agencies[$key] ?? null,
                'from_year'   => $fromYears[$key] ?? null,
                'to_year'     => $toYears[$key] ?? null,
                'status'      => $statuses[$key] ?? 'ongoing',
                'upload_path' => $filePath,
                'visibility'  => 'hide'
            ]);
        }

        return redirect()->to('/faculty/projects')
            ->with('success', 'Projects added successfully.');
    }


    // ✅ EDIT PROJECT FORM
    public function edit_project($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $project = $this->projectsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$project) {
            return redirect()->to('/faculty/projects')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'    => 'Edit Project',
            'content'  => 'faculty/edit_project',
            'projects' => [$project]
        ];

        return view('faculty/layout/template', $data);
    }

    // ✅ UPDATE PROJECT
    public function update_project()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids       = $this->request->getPost('id');
        $titles    = $this->request->getPost('title');
        $agencies  = $this->request->getPost('agency');
        $fromYears = $this->request->getPost('from_year');
        $toYears   = $this->request->getPost('to_year');
        $statuses  = $this->request->getPost('status');

        // ✅ Get all uploaded files at once
        $allFiles = $this->request->getFiles();

        foreach ($titles as $key => $title) {

            // Keep old file if exists
            $filePath = null;
            if (!empty($ids[$key])) {
                $old = $this->projectsModel->find($ids[$key]);
                $filePath = $old['upload_path'] ?? null;
            }

            // Check if a new file was uploaded for this row
            if (isset($allFiles['file'][$key]) && $allFiles['file'][$key]->isValid() && !$allFiles['file'][$key]->hasMoved()) {
                $newName = $allFiles['file'][$key]->getRandomName();
                $allFiles['file'][$key]->move(FCPATH . 'uploads/projects', $newName);
                $filePath = 'uploads/projects/' . $newName;
            }

            $data = [
                'faculty_id'  => $facultyId,
                'title'       => $title,
                'agency'      => $agencies[$key] ?? null,
                'from_year'   => $fromYears[$key] ?? null,
                'to_year'     => $toYears[$key] ?? null,
                'status'      => $statuses[$key] ?? 'ongoing',
                'upload_path' => $filePath,
            ];

            // Update existing or insert new row
            if (!empty($ids[$key])) {
                $this->projectsModel->update($ids[$key], $data);
            } else {
                $this->projectsModel->insert($data);
            }
        }

        return redirect()->to('/faculty/projects')
            ->with('success', 'Projects updated successfully.');
    }

    // ✅ DELETE PROJECT
    public function delete_project($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $project = $this->projectsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$project) {
            return redirect()->to('/faculty/projects')->with('error', 'Unauthorized access.');
        }

        $this->projectsModel->delete($id);

        return redirect()->to('/faculty/projects')->with('success', 'Project deleted successfully.');
    }

    // ✅ TOGGLE VISIBILITY
    public function updateProjectVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $projectId = $this->request->getPost('project_id');

        $project = $this->projectsModel->find($projectId);
        if (!$project) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($project['visibility'] === 'view') ? 'hide' : 'view';

        $this->projectsModel->update($projectId, ['visibility' => $newStatus]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }

    public function information()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $information = $this->informationModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Information',
            'content'     => 'faculty/information',
            'information' => $information
        ];

        return view('faculty/layout/template', $data);
    }

    public function add_information()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Information',
            'content' => 'faculty/add_information'
        ];

        return view('faculty/layout/template', $data);
    }
    public function save_information()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        // ✅ TYPE ADDED BACK
        $types     = $this->request->getPost('type');
        $titles    = $this->request->getPost('title');
        $agencies  = $this->request->getPost('agency');
        $fromYears = $this->request->getPost('from_year');
        $toYears   = $this->request->getPost('to_year');
        $statuses  = $this->request->getPost('status');

        $files = $this->request->getFiles();

        foreach ($titles as $key => $title) {

            if (empty($title)) {
                continue;
            }

            $filePath = '';
            if (isset($files['file'][$key]) && $files['file'][$key]->isValid() && !$files['file'][$key]->hasMoved()) {
                $newName = $files['file'][$key]->getRandomName();
                $files['file'][$key]->move(FCPATH . 'uploads/information', $newName);
                $filePath = 'uploads/information/' . $newName;
            }

            $this->informationModel->insert([
                'faculty_id'  => $facultyId,

                // ✅ TYPE STORED HERE
                'type'        => $types[$key] ?? null,

                'title'       => $title,
                'agency'      => $agencies[$key] ?? null,
                'from_year'   => $fromYears[$key] ?? null,
                'to_year'     => $toYears[$key] ?? null,
                'status'      => $statuses[$key] ?? 'ongoing',
                'upload_path' => $filePath,
                'visibility'  => 'hide'
            ]);
        }

        return redirect()->to("/faculty/information")
            ->with('success', 'Information added successfully.');
    }

    public function edit_information($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $info = $this->informationModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$info) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'       => 'Information',
            'content'     => 'faculty/edit_information',
            'information' => [$info],
            'type'        => $info['type']
        ];

        return view('faculty/layout/template', $data);
    }
    public function update_information()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids       = $this->request->getPost('id');
        $types     = $this->request->getPost('type');
        $titles    = $this->request->getPost('title');
        $agencies  = $this->request->getPost('agency');
        $fromYears = $this->request->getPost('from_year');
        $toYears   = $this->request->getPost('to_year');
        $statuses  = $this->request->getPost('status');

        $allFiles = $this->request->getFiles();

        foreach ($titles as $key => $title) {

            if (empty($title)) {
                continue;
            }

            // ✅ Keep Old File If New File Not Uploaded
            $filePath = null;
            if (!empty($ids[$key])) {
                $old = $this->informationModel->find($ids[$key]);
                $filePath = $old['upload_path'] ?? null;
            }

            // ✅ New File Upload
            if (isset($allFiles['file'][$key]) && $allFiles['file'][$key]->isValid() && !$allFiles['file'][$key]->hasMoved()) {
                $newName = $allFiles['file'][$key]->getRandomName();
                $allFiles['file'][$key]->move(FCPATH . 'uploads/information', $newName);
                $filePath = 'uploads/information/' . $newName;
            }

            $data = [
                'faculty_id'  => $facultyId,
                'type'        => $types[$key] ?? null,
                'title'       => $title,
                'agency'      => $agencies[$key] ?? null,
                'from_year'   => $fromYears[$key] ?? null,
                'to_year'     => $toYears[$key] ?? null,
                'status'      => $statuses[$key] ?? 'ongoing',
                'upload_path' => $filePath,
            ];

            // ✅ Update OR Insert
            if (!empty($ids[$key])) {
                $this->informationModel->update($ids[$key], $data);
            } else {
                $this->informationModel->insert($data);
            }
        }

        return redirect()->to("/faculty/information")
            ->with('success', 'Information updated successfully.');
    }

    public function delete_information($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $info = $this->informationModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$info) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $this->informationModel->delete($id);

        return redirect()->back()->with('success', 'Information deleted successfully.');
    }
    public function updateInformationVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $infoId = $this->request->getPost('information_id');

        $info = $this->informationModel->find($infoId);
        if (!$info) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($info['visibility'] === 'view') ? 'hide' : 'view';

        $this->informationModel->update($infoId, ['visibility' => $newStatus]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }

    // List all news
    public function news()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $news = $this->newsModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title' => 'News / Press / Pictures',
            'content' => 'faculty/news',
            'news' => $news
        ];

        return view('faculty/layout/template', $data);
    }

    // Add News Form
    public function add_news()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title' => 'Add News / Press / Pictures',
            'content' => 'faculty/add_new'
        ];

        return view('faculty/layout/template', $data);
    }

    // Save News
    public function save_news()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $titles      = $this->request->getPost('title');
        $types       = $this->request->getPost('type'); // Intl / National / Local
        $monthYears  = $this->request->getPost('month_year');

        $files = $this->request->getFiles();

        foreach ($titles as $key => $title) {
            if (empty($title)) {
                continue;
            }

            $filePath = '';
            if (isset($files['file'][$key]) && $files['file'][$key]->isValid() && !$files['file'][$key]->hasMoved()) {
                $newName = $files['file'][$key]->getRandomName();
                $files['file'][$key]->move(FCPATH . 'uploads/news', $newName);
                $filePath = 'uploads/news/' . $newName;
            }

            $this->newsModel->insert([
                'faculty_id'  => $facultyId,
                'title'       => $title,
                'type'        => $types[$key] ?? 'Local',
                'month_year'  => $monthYears[$key] ?? null,
                'upload_path' => $filePath,
                'visibility'  => 'hide'
            ]);
        }

        return redirect()->to("/faculty/news")
            ->with('success', 'News added successfully.');
    }

    // Edit News Form
    public function edit_news($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $news = $this->newsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$news) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $data = [
            'title' => 'Edit News / Press / Pictures',
            'content' => 'faculty/edit_new',
            'news' => [$news]
        ];

        return view('faculty/layout/template', $data);
    }

    // Update News
    public function update_news()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids         = $this->request->getPost('id');
        $titles      = $this->request->getPost('title');
        $types       = $this->request->getPost('type');
        $monthYears  = $this->request->getPost('month_year');

        $allFiles = $this->request->getFiles();

        foreach ($titles as $key => $title) {
            if (empty($title)) {
                continue;
            }

            $filePath = null;
            if (!empty($ids[$key])) {
                $old = $this->newsModel->find($ids[$key]);
                $filePath = $old['upload_path'] ?? null;
            }

            if (isset($allFiles['file'][$key]) && $allFiles['file'][$key]->isValid() && !$allFiles['file'][$key]->hasMoved()) {
                $newName = $allFiles['file'][$key]->getRandomName();
                $allFiles['file'][$key]->move(FCPATH . 'uploads/news', $newName);
                $filePath = 'uploads/news/' . $newName;
            }

            $data = [
                'faculty_id'  => $facultyId,
                'title'       => $title,
                'type'        => $types[$key] ?? 'Local',
                'month_year'  => $monthYears[$key] ?? null,
                'upload_path' => $filePath
            ];

            if (!empty($ids[$key])) {
                $this->newsModel->update($ids[$key], $data);
            } else {
                $this->newsModel->insert($data);
            }
        }

        return redirect()->to("/faculty/news")
            ->with('success', 'News updated successfully.');
    }

    // Delete News
    public function delete_news($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $news = $this->newsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$news) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $this->newsModel->delete($id);

        return redirect()->back()->with('success', 'News deleted successfully.');
    }

    // Toggle News Visibility
    public function updateNewsVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $newsId = $this->request->getPost('news_id');

        $news = $this->newsModel->find($newsId);
        if (!$news) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($news['visibility'] === 'view') ? 'hide' : 'view';

        $this->newsModel->update($newsId, ['visibility' => $newStatus]);

        return $this->response->setJSON([
            'status' => 'success',
            'newVisibility' => $newStatus
        ]);
    }
    public function social_media()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $socialMedia = $this->socialMediaModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'        => 'Social Media',
            'content'      => 'faculty/social_media',
            'socialMedia'  => $socialMedia
        ];

        return view('faculty/layout/template', $data);
    }
    public function add_social_media()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Social Media',
            'content' => 'faculty/add_social_media'
        ];

        return view('faculty/layout/template', $data);
    }
    public function save_social_media()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $instagram = $this->request->getPost('instagram_link');
        $whatsapp  = $this->request->getPost('whatsapp_link');
        $facebook  = $this->request->getPost('facebook_link');
        $twitter   = $this->request->getPost('twitter_link');

        if (is_array($instagram)) {
            foreach ($instagram as $key => $value) {

                // Skip empty rows
                if (
                    empty($instagram[$key]) &&
                    empty($whatsapp[$key]) &&
                    empty($facebook[$key]) &&
                    empty($twitter[$key])
                ) {
                    continue;
                }

                $this->socialMediaModel->insert([
                    'faculty_id'     => $facultyId,
                    'instagram_link' => $instagram[$key] ?? null,
                    'whatsapp_link'  => $whatsapp[$key] ?? null,
                    'facebook_link'  => $facebook[$key] ?? null,
                    'twitter_link'   => $twitter[$key] ?? null,
                    'visibility'     => 'hide'
                ]);
            }
        }

        return redirect()->to('/faculty/social-media')
            ->with('success', 'Social media links added successfully.');
    }

    public function edit_social_media($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $social = $this->socialMediaModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$social) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'        => 'Edit Social Media',
            'content'      => 'faculty/edit_social_media',
            'socialMedia'  => [$social] // ✅ array (same as news)
        ];

        return view('faculty/layout/template', $data);
    }

    public function update_social_media()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids        = $this->request->getPost('id') ?? [];
        $instagram = $this->request->getPost('instagram_link') ?? [];
        $whatsapp  = $this->request->getPost('whatsapp_link') ?? [];
        $facebook  = $this->request->getPost('facebook_link') ?? [];
        $twitter   = $this->request->getPost('twitter_link') ?? [];

        foreach ($instagram as $key => $value) {

            // ⛔ Skip empty rows
            if (
                empty($instagram[$key]) &&
                empty($whatsapp[$key]) &&
                empty($facebook[$key]) &&
                empty($twitter[$key])
            ) {
                continue;
            }

            $data = [
                'faculty_id'     => $facultyId,
                'instagram_link' => $instagram[$key] ?? null,
                'whatsapp_link'  => $whatsapp[$key] ?? null,
                'facebook_link'  => $facebook[$key] ?? null,
                'twitter_link'   => $twitter[$key] ?? null,
            ];

            if (!empty($ids[$key])) {
                // ✅ UPDATE
                $this->socialMediaModel
                    ->where('id', $ids[$key])
                    ->where('faculty_id', $facultyId)
                    ->update(null, $data);
            } else {
                // ✅ INSERT
                $this->socialMediaModel->insert($data);
            }
        }

        return redirect()->to('/faculty/social-media')
            ->with('success', 'Social media updated successfully.');
    }


    public function delete_social_media($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->socialMediaModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/social-media')
                ->with('error', 'Unauthorized access.');
        }

        $this->socialMediaModel->delete($id);

        return redirect()->to('/faculty/social-media')
            ->with('success', 'Social media link deleted successfully.');
    }
    public function updateSocialMediaVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $id = $this->request->getPost('faculty_social_media_id');

        $social = $this->socialMediaModel->find($id);

        if (!$social) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Record not found'
            ]);
        }

        $newStatus = ($social['visibility'] === 'view') ? 'hide' : 'view';

        $this->socialMediaModel->update($id, [
            'visibility' => $newStatus
        ]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }
    public function memberships()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $memberships = $this->membershipsModel
            ->where('faculty_id', $facultyId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Memberships',
            'content'     => 'faculty/memberships',
            'memberships' => $memberships
        ];

        return view('faculty/layout/template', $data);
    }
    public function add_membership()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Memberships',
            'content' => 'faculty/add_membership'
        ];

        return view('faculty/layout/template', $data);
    }
    public function save_membership()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $categories = $this->request->getPost('category');
        $titles     = $this->request->getPost('title');

        foreach ($categories as $key => $category) {

            if (empty($titles[$key])) {
                continue;
            }

            $this->membershipsModel->insert([
                'faculty_id' => $facultyId,
                'category'   => $category,
                'title'      => $titles[$key],
                'visibility' => 'hide'
            ]);
        }

        return redirect()->to('/faculty/memberships')
            ->with('success', 'Memberships added successfully.');
    }
    public function edit_membership($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->membershipsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/memberships')
                ->with('error', 'Unauthorized access.');
        }

        $data = [
            'title'       => 'Memberships',
            'content'     => 'faculty/edit_membership',
            'memberships' => [$row]
        ];

        return view('faculty/layout/template', $data);
    }
    public function update_membership()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $ids        = $this->request->getPost('id');
        $categories = $this->request->getPost('category');
        $titles     = $this->request->getPost('title');

        foreach ($categories as $key => $category) {

            $data = [
                'faculty_id' => $facultyId,
                'category'   => $category,
                'title'      => $titles[$key],
            ];

            if (!empty($ids[$key])) {
                $this->membershipsModel->update($ids[$key], $data);
            } else {
                $data['visibility'] = 'hide';
                $this->membershipsModel->insert($data);
            }
        }

        return redirect()->to('/faculty/memberships')
            ->with('success', 'Memberships updated successfully.');
    }
    public function delete_membership($id)
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $facultyId = session()->get('faculty_id');

        $row = $this->membershipsModel
            ->where('id', $id)
            ->where('faculty_id', $facultyId)
            ->first();

        if (!$row) {
            return redirect()->to('/faculty/memberships')
                ->with('error', 'Unauthorized access.');
        }

        $this->membershipsModel->delete($id);

        return redirect()->to('/faculty/memberships')
            ->with('success', 'Membership deleted successfully.');
    }
    public function updateMembershipVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $membershipId = $this->request->getPost('membership_id');

        $membership = $this->membershipsModel->find($membershipId);

        if (!$membership) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $newStatus = ($membership['visibility'] === 'view') ? 'hide' : 'view';

        $this->membershipsModel->update($membershipId, [
            'visibility' => $newStatus
        ]);

        return $this->response->setJSON([
            'status'        => 'success',
            'newVisibility' => $newStatus
        ]);
    }

    // ---------------------------------------------------------
    // LOGOUT
    // ---------------------------------------------------------
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
