<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class AdminController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
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
}
