<?php

use CodeIgniter\Router\RouteCollection;
use Config\Auth as AuthConfig;

/**
 * @var RouteCollection $routes
 */
$routes->get('/candidates', 'Vote::index', ['filter' => 'role:voter,admin']);
$routes->get('/voting', 'Vote::voting', ['filter' => 'role:voter,admin']);
$routes->post('vote/save', 'Vote::saveVote', ['filter' => 'role:admin,voter']);



// Change password
$routes->get('change-password', 'AuthController::changePassword');
$routes->post('update-password', 'AuthController::updatePassword');



// Home
$routes->group('', ['filter' => 'role:admin,voter, candidate'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/result', 'Home::result');
});

// profile
$routes->group('', [], function ($routes) {
    $routes->get('voter/profile', 'Voter::editProfile', ['filter' => 'role:voter']);
    $routes->post('voter/profile/update/(:num)', 'Voter::update/$1',  ['filter' => 'role:voter']);

    $routes->get('candidate/profile', 'Candidate::editProfile', ['filter' => 'role:candidate']);
    $routes->post('candidate/profile/update/(:num)', 'Candidate::update/$1');

    $routes->get('admin/profile', 'Admin::editProfile', ['filter' => 'role:admin']);
});

// Dashboard & Reports
$routes->group('', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('report', 'Report::index');
    $routes->get('dashboard/getStatisticsByGrade/(:any)', 'Dashboard::getStatisticsByGrade/$1');
    $routes->get('dashboard/getDataCandidatesByGrade/(:any)', 'Dashboard::getDataCandidatesByGrade/$1');
});

// Config/Routes.php
$routes->group('configuration', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'Configuration::index');
    $routes->post('update', 'Configuration::update');
});

// kelola data kandidat 
$routes->group('candidate', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'Candidate::index');
    $routes->get('create', 'Candidate::create');
    $routes->post('save', 'Candidate::save');
    $routes->get('edit/(:num)', 'Candidate::edit/$1');
    $routes->post('update/(:num)', 'Candidate::update/$1');
    $routes->delete('delete/(:num)', 'Candidate::delete/$1');
    $routes->post('updatePassword/(:num)', 'Candidate::updatePassword/$1');
    $routes->get('export_excel', 'Candidate::export_excel');
    $routes->post('import_excel', 'Candidate::import_excel');
    $routes->get('template', 'Candidate::template');
});

// permilih 
$routes->group('voter', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'voter::index');
    $routes->get('create', 'voter::create');
    $routes->post('save', 'voter::save');
    $routes->get('edit/(:num)', 'voter::edit/$1');
    $routes->post('update/(:num)', 'voter::update/$1');
    $routes->delete('delete/(:num)', 'voter::delete/$1');
    $routes->post('updatePassword/(:num)', 'voter::updatePassword/$1');
    $routes->get('export_excel', 'voter::export_excel');
    $routes->post('import_excel', 'Voter::import_excel');
    $routes->get('template', 'Voter::template');
});

// Admin 
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'Admin::index');
    $routes->get('create', 'Admin::create');
    $routes->post('save', 'Admin::save');
    $routes->get('edit/(:num)', 'Admin::edit/$1');
    $routes->post('update/(:num)', 'Admin::update/$1');
    $routes->delete('delete/(:num)', 'Admin::delete/$1');
    $routes->post('updatePassword/(:num)', 'Admin::updatePassword/$1');
    $routes->get('export_excel', 'Admin::export_excel');
    $routes->post('import_excel', 'Admin::import_excel');
    $routes->get('template', 'Admin::template');
});

// Period 
$routes->group('period', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'Period::index');
    $routes->get('create', 'Period::create');
    $routes->post('save', 'Period::save');
    $routes->get('edit/(:num)', 'Period::edit/$1');
    $routes->post('update/(:num)', 'Period::update/$1');
    $routes->delete('delete/(:num)', 'Period::delete/$1');
});

// kelas 
$routes->group('grade', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'Grade::index');
    $routes->get('create', 'Grade::create');
    $routes->post('save', 'Grade::save');
    $routes->get('edit/(:num)', 'Grade::edit/$1');
    $routes->post('update/(:num)', 'Grade::update/$1');
    $routes->delete('delete/(:num)', 'Grade::delete/$1');
    $routes->post('import_excel', 'Grade::import_excel');
    $routes->get('template', 'Grade::template');
});

// jurusan
$routes->group('program', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'Program::index');
    $routes->get('create', 'Program::create');
    $routes->post('save', 'Program::save');
    $routes->get('edit/(:num)', 'Program::edit/$1');
    $routes->post('update/(:num)', 'Program::update/$1');
    $routes->delete('delete/(:num)', 'Program::delete/$1');
});

// API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->post('login', 'ApiUser::login');

    $routes->group('', ['filter' => 'jwt'], function ($routes) {
        $routes->get('user/details', 'ApiUser::details');
        $routes->post('logout', 'ApiUser::logout');
        $routes->get('voting/candidates', 'ApiVoting::getCandidates');
        $routes->post('voting/submit', 'ApiVoting::submitVote');
        $routes->get('voting/status/(:num)', 'ApiVoting::checkVoteStatus/$1');
    });
});

// OVERRIDE AUTH ROUTES
$routes->group('', ['namespace' => 'App\Controllers'], static function ($routes) {
    // Load the reserved routes from Auth.php
    $config         = config(AuthConfig::class);
    $reservedRoutes = $config->reservedRoutes;

    // Login/out
    $routes->get($reservedRoutes['login'], 'AuthController::login', ['as' => $reservedRoutes['login']]);
    $routes->post($reservedRoutes['login'], 'AuthController::attemptLogin');
    $routes->get($reservedRoutes['logout'], 'AuthController::logout');

    // Registration
    $routes->get($reservedRoutes['register'], 'AuthController::register', ['as' => $reservedRoutes['register']]);
    $routes->post($reservedRoutes['register'], 'AuthController::attemptRegister');

    // Activation
    $routes->get($reservedRoutes['activate-account'], 'AuthController::activateAccount', ['as' => $reservedRoutes['activate-account']]);
    $routes->get($reservedRoutes['resend-activate-account'], 'AuthController::resendActivateAccount', ['as' => $reservedRoutes['resend-activate-account']]);

    // Forgot/Resets
    $routes->get($reservedRoutes['forgot'], 'AuthController::forgotPassword', ['as' => $reservedRoutes['forgot']]);
    $routes->post($reservedRoutes['forgot'], 'AuthController::attemptForgot');
    $routes->get($reservedRoutes['reset-password'], 'AuthController::resetPassword', ['as' => $reservedRoutes['reset-password']]);
    $routes->post($reservedRoutes['reset-password'], 'AuthController::attemptReset');
});
