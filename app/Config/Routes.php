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

    /* ---------------------------------------------------
     |  ACHIEVEMENTS CRUD (AWARDS / HONORS + PATENTS)
     ----------------------------------------------------*/
    $routes->get('achievements', 'FacultyController::achievements');
    $routes->get('add-achievement', 'FacultyController::add_achievement');
    $routes->post('save-achievement', 'FacultyController::save_achievement');
    $routes->get('edit-achievement/(:num)', 'FacultyController::edit_achievement/$1');
    $routes->post('update-achievement', 'FacultyController::update_achievement');
    $routes->get('delete-achievement/(:num)', 'FacultyController::delete_achievement/$1');
    $routes->post('update-achievement-visibility', 'FacultyController::updateAchievementVisibility');

    $routes->get('skills', 'FacultyController::skills');
    $routes->get('add-skill', 'FacultyController::add_skill');
    $routes->post('save-skill', 'FacultyController::save_skill');

    $routes->get('edit-skill/(:num)', 'FacultyController::edit_skill/$1');
    $routes->post('update-skill', 'FacultyController::update_skill');

    $routes->get('delete-skill/(:num)', 'FacultyController::delete_skill/$1');
    $routes->post('update-skill-visibility', 'FacultyController::updateSkillVisibility');

    $routes->get('works', 'FacultyController::works');
    $routes->get('add-work', 'FacultyController::add_work');
    $routes->post('save-work', 'FacultyController::save_work');

    $routes->get('edit-work/(:num)', 'FacultyController::edit_work/$1');
    $routes->post('update-work', 'FacultyController::update_work');

    $routes->get('delete-work/(:num)', 'FacultyController::delete_work/$1');
    $routes->post('update-work-visibility', 'FacultyController::updateWorkVisibility');

    // ================== FACULTY ACTIVITIES ROUTES ==================

    $routes->get('activities', 'FacultyController::activities');
    $routes->get('add-activity', 'FacultyController::add_activity');
    $routes->post('save-activity', 'FacultyController::save_activity');

    $routes->get('edit-activity/(:num)', 'FacultyController::edit_activity/$1');
    $routes->post('update-activity', 'FacultyController::update_activity');

    $routes->get('delete-activity/(:num)', 'FacultyController::delete_activity/$1');
    $routes->post('update-activity-visibility', 'FacultyController::updateActivityVisibility');

    $routes->get('students', 'FacultyController::research_students');

    $routes->get('add-research-student', 'FacultyController::add_research_student');
    $routes->post('save-research-student', 'FacultyController::save_research_student');

    $routes->get('edit-research-student/(:num)', 'FacultyController::edit_research_student/$1');
    $routes->post('update-research-student', 'FacultyController::update_research_student');

    $routes->get('delete-research-student/(:num)', 'FacultyController::delete_research_student/$1');
    $routes->post('update-research-student-visibility', 'FacultyController::updateResearchStudentVisibility');

    // Projects Routes
    $routes->get('projects', 'FacultyController::projects');
    $routes->get('add-project', 'FacultyController::add_project');
    $routes->post('save-project', 'FacultyController::save_project');

    $routes->get('edit-project/(:num)', 'FacultyController::edit_project/$1');
    $routes->post('update-project', 'FacultyController::update_project');

    $routes->get('delete-project/(:num)', 'FacultyController::delete_project/$1');
    $routes->post('update-project-visibility', 'FacultyController::updateProjectVisibility');

    $routes->get('information', 'FacultyController::information');

    $routes->get('add-information', 'FacultyController::add_information');
    $routes->post('save-information', 'FacultyController::save_information');

    $routes->get('edit-information/(:num)', 'FacultyController::edit_information/$1');
    $routes->post('update-information', 'FacultyController::update_information');

    $routes->get('delete-information/(:num)', 'FacultyController::delete_information/$1');
    $routes->post('update-information-visibility', 'FacultyController::updateInformationVisibility');

    $routes->get('news', 'FacultyController::news');
    $routes->get('add-news', 'FacultyController::add_news');
    $routes->post('save-news', 'FacultyController::save_news');
    $routes->get('edit-news/(:num)', 'FacultyController::edit_news/$1');
    $routes->post('update-news', 'FacultyController::update_news');
    $routes->get('delete-news/(:num)', 'FacultyController::delete_news/$1');
    $routes->post('update-news-visibility', 'FacultyController::updateNewsVisibility');

});
$routes->group('api', function ($routes) {
    // User APIs
    $routes->get('users', 'Api\UserController::getUsers');
    $routes->get('users/(:num)', 'Api\UserController::getUser/$1');

    // Faculty Profile APIs
    $routes->get('faculty-profiles', 'Api\FacultyProfileController::getFacultyProfiles');
    $routes->get('faculty-profiles/(:num)', 'Api\FacultyProfileController::getFacultyProfile/$1');

    // Faculty Education APIs
    $routes->get('faculty-educations/(:num)', 'Api\FacultyEducationController::getFacultyEducationsByUser/$1'); // all records for user_id
    $routes->get('faculty-education/(:num)', 'Api\FacultyEducationController::getFacultyEducationByUser/$1'); // single/latest record for user_id

    $routes->get('faculty-skills/(:num)', 'Api\FacultySkillController::getFacultySkillsByUser/$1'); // all skills
    $routes->get('faculty-skill/(:num)', 'Api\FacultySkillController::getFacultySkillByUser/$1');    // single/latest skill

    // Faculty Administrative APIs
    $routes->get('faculty-administrative/(:num)', 'Api\FacultyAdministrativeController::getAdministrativeByUser/$1'); // all
    $routes->get('faculty-administrative-single/(:num)', 'Api\FacultyAdministrativeController::getSingleAdministrativeByUser/$1'); // single/latest

    $routes->get('faculty-awards/(:num)', 'Api\FacultyAchievementController::getAwardsByUser/$1');

    // Teaching Experience APIs
    $routes->get('faculty-teaching/(:num)', 'Api\FacultyTeachingController::getTeachingByUser/$1');
    $routes->get('faculty-teaching/single/(:num)', 'Api\FacultyTeachingController::getSingleTeachingByUser/$1');

    // Research Areas API
    $routes->get('faculty-research/(:num)', 'Api\FacultyResearchController::getFacultyResearchByUser/$1');
    $routes->get('faculty-research-single/(:num)', 'Api\FacultyResearchController::getSingleFacultyResearchByUser/$1');

    // Faculty Publications API routes
    $routes->get('faculty-publication/(:num)', 'Api\FacultyPublicationController::getFacultyPublicationByUser/$1');
    $routes->get('faculty-publication-single/(:num)', 'Api\FacultyPublicationController::getSingleFacultyPublicationByUser/$1');

    $routes->get('faculty-workshops/(:num)', 'Api\FacultyWorkshopController::getWorkshopsByUser/$1');
    $routes->get('faculty-workshop-single/(:num)', 'Api\FacultyWorkshopController::getSingleWorkshopByUser/$1');

    $routes->get('faculty-memberships/(:num)', 'Api\FacultyMembershipController::getMembershipsByUser/$1');
    $routes->get('faculty-membership-latest/(:num)', 'Api\FacultyMembershipController::getLatestMembershipByUser/$1');

    $routes->get('faculty-students/(:num)', 'Api\FacultyResearchStudentsController::getResearchStudentsByUser/$1');
    $routes->get('faculty-research-student-latest/(:num)', 'Api\FacultyResearchStudentsController::getLatestResearchStudentByUser/$1');

});
