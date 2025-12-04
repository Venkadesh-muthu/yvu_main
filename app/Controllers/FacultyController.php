<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FacultyProfileModel;
use App\Models\FacultyEducationModel;
use App\Models\FacultyProfileVisibilityModel;
use App\Models\FacultyEducationVisibilityModel;
use App\Models\FacultyExperienceModel;
use App\Models\FacultyExperienceVisibilityModel;

class FacultyController extends BaseController
{
    protected $profileModel;
    protected $eduModel;
    protected $ProfileVisibilityModel;
    protected $educationVisibilityModel;
    protected $experienceModel;
    protected $experienceVisibilityModel;

    public function __construct()
    {
        helper(['form']);
        $this->profileModel = new FacultyProfileModel();
        $this->eduModel = new FacultyEducationModel();
        $this->ProfileVisibilityModel = new FacultyProfileVisibilityModel();
        $this->educationVisibilityModel = new FacultyEducationVisibilityModel();
        $this->experienceModel = new FacultyExperienceModel();
        $this->experienceVisibilityModel = new FacultyExperienceVisibilityModel();

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

        // ✅ FETCH VISIBILITY FOR EACH EDUCATION
        $visibility = [];

        foreach ($education as $edu) {
            $row = $this->educationVisibilityModel
                ->where('faculty_education_id', $edu['id'])
                ->first();

            if ($row) {
                $visibility[$edu['id']] = $row;
            }
        }

        $data = [
            'title'      => 'Educational Background',
            'content'    => 'faculty/educations',
            'education'  => $education,
            'visibility' => $visibility
        ];

        return view('faculty/layout/template', $data);
    }

    public function add_education()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Add Education',
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
            'title'      => 'Edit Education',
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

        // ✅ DELETE VISIBILITY DATA FIRST
        $this->educationVisibilityModel
            ->where('faculty_education_id', $id)
            ->delete();

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
        $field  = $this->request->getPost('field');
        $status = $this->request->getPost('status');

        $model = $this->educationVisibilityModel;

        $row = $model->where('faculty_education_id', $eduId)->first();

        if ($row) {
            $model->update($row['id'], [
                $field => $status
            ]);
        } else {
            $insertData = [
                'faculty_education_id' => $eduId,
                'category' => 'hide',
                'year_of_class' => 'hide',
                'institute' => 'hide',
                'town' => 'hide',
                'district' => 'hide',
                'state' => 'hide',
                $field => $status
            ];

            $model->insert($insertData);
        }

        return $this->response->setJSON(['status' => 'success']);
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

        // Fetch visibility for each experience
        $visibility = [];
        foreach ($experience as $exp) {
            $row = $this->experienceVisibilityModel
                        ->where('faculty_experience_id', $exp['id'])
                        ->first();
            if ($row) {
                $visibility[$exp['id']] = $row;
            }
        }

        $data = [
            'title'       => 'Faculty Experience',
            'content'     => 'faculty/experiences',
            'experience'  => $experience,
            'visibility'  => $visibility
        ];

        return view('faculty/layout/template', $data);
    }

    public function add_experience()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Add Experience',
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
            'title'      => 'Edit Experience',
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

        // Delete visibility first
        $this->experienceVisibilityModel
            ->where('faculty_experience_id', $id)
            ->delete();

        // Delete experience row
        $this->experienceModel->delete($id);

        return redirect()->to('/faculty/experiences')->with('success', 'Experience deleted successfully.');
    }

    public function updateExperienceVisibility()
    {
        if ($redirect = $this->checkFacultyLogin()) {
            return $redirect;
        }

        $expId  = $this->request->getPost('faculty_experience_id');
        $field  = $this->request->getPost('field');
        $status = $this->request->getPost('status');

        $model = $this->experienceVisibilityModel;

        $row = $model->where('faculty_experience_id', $expId)->first();

        if ($row) {
            $model->update($row['id'], [$field => $status]);
        } else {
            $insertData = [
                'faculty_experience_id' => $expId,
                'section' => 'hide',
                'title_type' => 'hide',
                'title_value' => 'hide',
                'workplace' => 'hide',
                'from_date' => 'hide',
                'to_date' => 'hide',
                $field => $status
            ];

            $model->insert($insertData);
        }

        return $this->response->setJSON(['status' => 'success']);
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
