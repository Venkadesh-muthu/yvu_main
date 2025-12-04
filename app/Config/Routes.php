<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// ---------- Public routes ----------
$routes->get('/', 'AdminController::index');
$routes->post('login', 'AdminController::login');
$routes->get('logout', 'AdminController::logout');
$routes->group('admin', function ($routes) {
    // ---------- Dashboard ----------
    $routes->get('dashboard', 'AdminController::dashboard');

    // ---------- Users CRUD ----------
    $routes->get('users', 'AdminController::users');
    $routes->get('addUser', 'AdminController::addUser');
    $routes->post('addUser', 'AdminController::addUser');
    $routes->post('uploadExcel', 'AdminController::uploadExcel');
    $routes->get('editUser/(:num)', 'AdminController::editUser/$1');
    $routes->post('editUser/(:num)', 'AdminController::editUser/$1');
    $routes->get('deleteUser/(:num)', 'AdminController::deleteUser/$1');
});

$routes->group('faculty', function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'FacultyController::dashboard');

    // Logout
    $routes->get('logout', 'FacultyController::logout');

    // Profile List
    $routes->get('profile', 'FacultyController::profile');

    // Add Profile
    $routes->get('add-profile', 'FacultyController::add_profile');
    $routes->post('save-profile', 'FacultyController::save_profile');

    // Edit Profile
    $routes->get('edit-profile/(:num)', 'FacultyController::edit_profile/$1');
    $routes->post('update-profile/(:num)', 'FacultyController::update_profile/$1');

    // Delete Profile
    $routes->get('delete-profile/(:num)', 'FacultyController::delete_profile/$1');

    // View Single Profile (optional)
    $routes->get('view-profile/(:num)', 'FacultyController::viewProfile/$1');

    // Toggle visibility of fields
    $routes->post('update-profile-visibility', 'FacultyController::updateProfileDetailsVisibility');

    /* ---------------------------------------------------
     |  EDUCATIONAL BACKGROUND CRUD (INSIDE SAME CONTROLLER)
     ----------------------------------------------------*/

    $routes->get('educations', 'FacultyController::educations');               // List
    $routes->get('add-education', 'FacultyController::add_education');          // Add form
    $routes->post('save-education', 'FacultyController::save_education');       // Save new
    $routes->get('edit-education/(:num)', 'FacultyController::edit_education/$1'); // Edit form
    $routes->post('update-education', 'FacultyController::update_education'); // Update
    $routes->get('delete-education/(:num)', 'FacultyController::delete_education/$1'); // Delete
    $routes->post('update-education-visibility', 'FacultyController::updateEducationVisibility');

    /* ---------------------------------------------------
 |  EXPERIENCE CRUD (INSIDE SAME CONTROLLER)
 ----------------------------------------------------*/

    $routes->get('experiences', 'FacultyController::experiences');                     // List experiences
    $routes->get('add-experience', 'FacultyController::add_experience');               // Add experience form
    $routes->post('save-experience', 'FacultyController::save_experience');            // Save new experience
    $routes->get('edit-experience/(:num)', 'FacultyController::edit_experience/$1');   // Edit experience form
    $routes->post('update-experience', 'FacultyController::update_experience');        // Update experience
    $routes->get('delete-experience/(:num)', 'FacultyController::delete_experience/$1'); // Delete experience
    $routes->post('update-experience-visibility', 'FacultyController::updateExperienceVisibility'); // AJAX toggle visibility


});
