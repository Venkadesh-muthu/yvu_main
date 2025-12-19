<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
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
use Dompdf\Dompdf;
use Dompdf\Options;

class AdminController extends BaseController
{
    protected $userModel;
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
        helper(['form', 'url']);
        $this->userModel = new UserModel();
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
    }

    // ---------- Login / Logout ----------
    public function index()
    {
        return view('admin/login');
    }

    public function login()
    {
        helper(['form']);
        $session = session();

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {

            // ---------- CHECK ADMIN ----------
            if ($user['user_type'] === 'admin') {
                $session->set([
                    'isAdminLoggedIn' => true,
                    'admin_id'        => $user['id'],
                    'admin_name'      => $user['username'],
                    'admin_email'     => $user['email'],
                ]);
                return redirect()->to('/admin/dashboard');
            }

            // ---------- CHECK FACULTY ----------
            if ($user['user_type'] === 'faculty') {
                $session->set([
                    'isFacultyLoggedIn' => true,
                    'faculty_id'        => $user['id'],
                    'faculty_name'      => $user['username'],
                    'faculty_email'     => $user['email'],
                ]);
                return redirect()->to('/faculty/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Invalid login credentials or Invalid user.');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    private function checkLogin()
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/')->send();
        }
    }

    // ---------- Dashboard ----------
    public function dashboard()
    {
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $data = [
            'title'   => 'Dashboard',
            'content' => 'admin/dashboard',
        ];

        return view('admin/layout/templates', $data);
    }

    // ---------- Users CRUD ----------

    // List users
    public function users()
    {
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $perPage = 10;
        $search = $this->request->getGet('q');

        // Start with model query
        $query = $this->userModel;

        // Apply search filter BEFORE paginate
        if (!empty($search)) {
            $query = $query->groupStart()
                           ->like('username', $search)
                           ->orLike('email', $search)
                           ->orLike('department', $search)
                           ->groupEnd();
        }

        // Paginate the filtered results
        $users = $query->orderBy('created_at', 'DESC')
                       ->paginate($perPage, 'default');

        $pager = $query->pager;

        $data = [
            'title'   => 'Users',
            'users'   => $users,
            'pager'   => $pager,
            'search'  => $search,
            'content' => 'admin/users'
        ];

        return view('admin/layout/templates', $data);
    }

    // Add user
    public function addUser()
    {
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username'  => 'required|min_length[3]',
                'email'     => 'required|valid_email|is_unique[users.email]',
                'password'  => 'required|min_length[6]',
                'user_type' => 'required'
            ];

            if (!$this->validate($rules)) {
                return view('admin/layout/templates', [
                    'title'      => 'Add User',
                    'content'    => 'admin/add_user',
                    'validation' => $this->validator
                ]);
            }

            $this->userModel->insert([
                'username'   => $this->request->getPost('username'),
                'email'      => $this->request->getPost('email'),
                'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'department' => $this->request->getPost('department'),
                'user_type'  => $this->request->getPost('user_type'),
                'phone'      => $this->request->getPost('phone'),
            ]);

            return redirect()->to('/admin/users')->with('success', 'User added successfully.');
        }

        return view('admin/layout/templates', [
            'title'   => 'Add User',
            'content' => 'admin/add_user'
        ]);
    }

    // Edit user
    public function editUser($id)
    {
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username'  => 'required|min_length[3]',
                'email'     => "required|valid_email|is_unique[users.email,id,$id]",
                'user_type' => 'required'
            ];

            if (!$this->validate($rules)) {
                return view('admin/layout/templates', [
                    'title'      => 'Edit User',
                    'user'       => $user,
                    'content'    => 'admin/edit_user',
                    'validation' => $this->validator
                ]);
            }

            $updateData = [
                'username'   => $this->request->getPost('username'),
                'email'      => $this->request->getPost('email'),
                'department' => $this->request->getPost('department'),
                'user_type'  => $this->request->getPost('user_type'),
                'phone'      => $this->request->getPost('phone'),
            ];

            // Update password if provided
            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->userModel->update($id, $updateData);

            return redirect()->to('/admin/users')->with('success', 'User updated successfully.');
        }

        return view('admin/layout/templates', [
            'title'   => 'Edit User',
            'user'    => $user,
            'content' => 'admin/edit_user'
        ]);
    }

    // Delete user
    public function deleteUser($id)
    {
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
    }
    public function uploadExcel()
    {
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $file = $this->request->getFile('excel');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file uploaded.');
        }

        $ext = $file->getExtension();

        if ($ext === 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } elseif ($ext === 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } elseif ($ext === 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            return redirect()->back()->with('error', 'Only Excel or CSV files are allowed.');
        }

        // Load the file
        $spreadsheet = $reader->load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        // Skip header row
        unset($sheet[0]);

        $imported = 0;
        $skipped = 0;

        foreach ($sheet as $row) {

            // If row empty → skip
            if (empty($row[0]) || empty($row[1])) {
                $skipped++;
                continue;
            }

            $username   = trim($row[0]);
            $email      = trim($row[1]);
            $department = trim($row[2]);
            $user_type  = trim($row[3]);
            $phone      = trim($row[4]);
            $password      = trim($row[5]);

            // Check duplicate email
            if ($this->userModel->where('email', $email)->first()) {
                $skipped++;
                continue;
            }

            // Insert user
            $this->userModel->insert([
                'username'   => $username,
                'email'      => $email,
                'department' => $department,
                'user_type'  => strtolower($user_type),
                'phone'      => $phone,
                'password'   => password_hash($password, PASSWORD_DEFAULT),
            ]);

            $imported++;
        }

        return redirect()->to('/admin/users')->with(
            'success',
            "Excel Import Completed. Imported: $imported, Skipped: $skipped"
        );
    }
    public function downloadFacultyPdf($facultyId)
    {
        // ===============================
        // 1. FETCH ALL DATA
        // ===============================
        $profile = $this->profileModel->where('user_id', $facultyId)->first();

        if (!$profile) {
            return redirect()->back()->with('error', 'Faculty not found');
        }

        $education = $this->eduModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $experience = $this->experienceModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $achievements = $this->achievementModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $skills = $this->skillModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $works = $this->worksModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $activities = $this->activitiesModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $projects = $this->projectsModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $researchStudents = $this->researchStudentsModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $memberships = $this->membershipsModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->findAll();

        $social = $this->socialMediaModel
            ->where('faculty_id', $facultyId)
            ->where('visibility', 'view')
            ->first();

        $information = $this->informationModel
        ->where('faculty_id', $facultyId)
        ->where('visibility', 'view')
        ->findAll();

        $news = $this->newsModel
        ->where('faculty_id', $facultyId)
        ->where('visibility', 'view')
        ->findAll();

        // ===============================
        // 2. BUILD HTML (INLINE)
        // ===============================
        $html = '
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        h2, h3 { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table, th, td { border: 1px solid #000; }
        td { padding: 5px; }
        ul, ol { margin-top: 0; }
    </style>

    <h2 style="text-align:center;">' . esc($profile['name']) . '</h2>
    <p style="text-align:center;">
        ' . esc($profile['designation']) . '<br>
        ' . esc($profile['department']) . '
    </p>
    <hr>

    <h3>Personal Information</h3>
    <table>
        <tr><td>Employee ID</td><td>' . esc($profile['employee_id']) . '</td></tr>
        <tr><td>Date of Birth</td><td>' . esc($profile['dob']) . '</td></tr>
        <tr><td>Gender</td><td>' . esc($profile['gender']) . '</td></tr>
        <tr><td>Religion</td><td>' . esc($profile['religion']) . '</td></tr>
        <tr><td>Caste</td><td>' . esc($profile['caste']) . '</td></tr>
        <tr><td>Reservation</td><td>' . esc($profile['reservation']) . '</td></tr>
        <tr><td>Blood Group</td><td>' . esc($profile['blood_group']) . '</td></tr>
        <tr><td>Place of Birth</td><td>' . esc($profile['place_of_birth']) . '</td></tr>
    </table>

    <h3>Contact Information</h3>
    <table>
        <tr><td>Residential Address</td><td>' . esc($profile['address_residential']) . '</td></tr>
        <tr><td>Office Address</td><td>' . esc($profile['address_office']) . '</td></tr>
        <tr><td>Phone</td><td>' . esc($profile['phone_no']) . '</td></tr>
        <tr><td>Email</td><td>' . esc($profile['email_official']) . '</td></tr>
    </table>

    <h3>Biography</h3>
    <p>' . nl2br(esc($profile['about_me'])) . '</p>

    <h3>Profiles / Links</h3>
    <ul>
        <li>VIDWAN: ' . esc($profile['vidwan_url']) . '</li>
        <li>ORCID: ' . esc($profile['orcid_url']) . '</li>
        <li>Scopus: ' . esc($profile['scopus_url']) . '</li>
        <li>Google Scholar: ' . esc($profile['google_scholar_url']) . '</li>
    </ul>
    ';

        // ===============================
        // EDUCATION
        // ===============================
        if ($education) {
            $html .= '<h3>Education</h3><ul>';
            foreach ($education as $edu) {
                $html .= '<li>' . esc($edu['course_subject']) . ' - ' .
                         esc($edu['institute']) . ' (' .
                         esc($edu['year_of_class']) . ')</li>';
            }
            $html .= '</ul>';
        }

        // ===============================
        // EXPERIENCE
        // ===============================
        if ($experience) {
            $html .= '<h3>Experience</h3><ul>';
            foreach ($experience as $exp) {
                $html .= '<li>' . esc($exp['title_value']) . ' - ' .
                         esc($exp['workplace']) . '</li>';
            }
            $html .= '</ul>';
        }

        // ===============================
        // SKILLS / RESEARCH AREAS
        // ===============================
        if ($skills) {
            $html .= '<h3>Skills / Research Areas</h3><ul>';
            foreach ($skills as $skill) {
                $html .= '<li>' . esc($skill['skill_value']) . '</li>';
            }
            $html .= '</ul>';
        }

        // ===============================
        // PUBLICATIONS
        // ===============================
        if ($works) {
            $html .= '<h3>Publications</h3><ol>';
            foreach ($works as $work) {
                $html .= '<li>' . esc($work['title']) . ' - ' .
                         esc($work['journal']) . '</li>';
            }
            $html .= '</ol>';
        }

        // ===============================
        // AWARDS
        // ===============================
        if ($achievements) {
            $html .= '<h3>Awards / Achievements</h3><ul>';
            foreach ($achievements as $ach) {
                $html .= '<li>' . esc($ach['title']) . '</li>';
            }
            $html .= '</ul>';
        }

        // ===============================
        // RESEARCH STUDENTS
        // ===============================
        if ($researchStudents) {
            $html .= '<h3>Research Students</h3><ul>';
            foreach ($researchStudents as $rs) {
                $html .= '<li>' . esc($rs['student_name']) .
                         ' (' . esc($rs['status']) . ')</li>';
            }
            $html .= '</ul>';
        }

        // ===============================
        // MEMBERSHIPS
        // ===============================
        if ($memberships) {
            $html .= '<h3>Memberships</h3><ul>';
            foreach ($memberships as $mem) {
                $html .= '<li>' . esc($mem['title']) . '</li>';
            }
            $html .= '</ul>';
        }
        // ===============================
        // SOCIAL MEDIA
        // ===============================
        if ($social) {
            $html .= '<h3>Social Media</h3><ul>';

            if (!empty($social['instagram_link'])) {
                $html .= '<li>Instagram: ' . esc($social['instagram_link']) . '</li>';
            }

            if (!empty($social['facebook_link'])) {
                $html .= '<li>Facebook: ' . esc($social['facebook_link']) . '</li>';
            }

            if (!empty($social['twitter_link'])) {
                $html .= '<li>Twitter/X: ' . esc($social['twitter_link']) . '</li>';
            }

            if (!empty($social['whatsapp_link'])) {
                $html .= '<li>WhatsApp: ' . esc($social['whatsapp_link']) . '</li>';
            }

            $html .= '</ul>';
        }
        // ===============================
        // PROJECTS
        // ===============================
        if ($projects) {
            $html .= '<h3>Projects</h3><ul>';
            foreach ($projects as $project) {
                $html .= '<li>
            <strong>' . esc($project['title']) . '</strong><br>
            Agency: ' . esc($project['agency']) . '<br>
            Duration: ' . esc($project['from_year']) . ' - ' . esc($project['to_year']) . '<br>
            Status: ' . esc($project['status']) . '
        </li>';
            }
            $html .= '</ul>';
        }
        // ===============================
        // ACTIVITIES / WORKSHOPS
        // ===============================
        if ($activities) {
            $html .= '<h3>Workshops / Activities</h3><ul>';
            foreach ($activities as $act) {
                $html .= '<li>
            <strong>' . esc($act['title']) . '</strong><br>
            Category: ' . esc($act['category']) . '<br>
            Type: ' . esc($act['type']) . '<br>
            Role: ' . esc($act['attended_or_role']) . '<br>
            Location: ' . esc($act['location']) . '<br>
            Month / Year: ' . esc($act['month_year']) . '
        </li>';
            }
            $html .= '</ul>';
        }

        if ($information) {
            $html .= '<h3>Additional Information</h3><ul>';
            foreach ($information as $info) {
                $html .= '<li>
            <strong>' . esc($info['title']) . '</strong><br>
            Type: ' . esc($info['type']) . '<br>
            Agency: ' . esc($info['agency']) . '<br>
            Duration: ' . esc($info['from_year']) . ' - ' . esc($info['to_year']) . '<br>
            Status: ' . esc($info['status']) . '
        </li>';
            }
            $html .= '</ul>';
        }

        if ($news) {
            $html .= '<h3>News / Media</h3><ul>';
            foreach ($news as $n) {
                $html .= '<li>
            <strong>' . esc($n['title']) . '</strong>
            (' . esc($n['type']) . ' - ' . esc($n['month_year']) . ')
        </li>';
            }
            $html .= '</ul>';
        }
        // ===============================
        // 3. GENERATE PDF
        // ===============================
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream(
            $profile['name'] . $profile['employee_id'] . '.pdf',
            ['Attachment' => true]
        );
    }
}
