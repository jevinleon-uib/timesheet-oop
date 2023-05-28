<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


/* Auth Routes */
$routes->get('/login', 'Login::index', ['filter' => 'guest']);
$routes->post('/login', 'Login::login', ['filter' => 'guest']);
$routes->get('/logout', 'Login::logout');


/* Home Route */
$routes->get('/', 'Home::index', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/user_profile/(:any)', 'Employee::userProfile/$1', ['filter' => 'auth']);
$routes->post('/user_profile/update/(:num)', 'Employee::userProfileUpdate/$1', ['filter' => 'auth']);


/* Timesheet Route */
$routes->get('/attendance', 'Timesheet::index', ['filter' => 'auth']);
$routes->post('/clock_in', 'Timesheet::clockIn', ['filter' => 'auth']);
$routes->post('/clock_out', 'Timesheet::clockOut', ['filter' => 'auth']);
$routes->get('/timesheets_employee', 'Timesheet::showByEmployee', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/timesheets_date', 'Timesheet::showByDate', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/user_timesheets', 'Timesheet::showByUser', ['filter' => 'auth']);
$routes->get('/export-pdf-by-employee/(:num)', 'Timesheet::exportPDFByEmployee/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/export-excel-by-employee/(:num)', 'Timesheet::exportExcelByEmployee/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/export-pdf-by-user', 'Timesheet::exportPDFByUser', ['filter' => 'auth']);
$routes->get('/export-excel-by-user', 'Timesheet::exportExcelByUser', ['filter' => 'auth']);
$routes->get('/export-pdf-by-date/(:any)/(:any)/(:any)', 'Timesheet::exportPDFByDate/$1/$2/$3', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/export-excel-by-date/(:any)/(:any)/(:any)', 'Timesheet::exportExcelByDate/$1/$2/$3', ['filter' => 'auth', 'filter' => 'notadmin']);


/* Employees Routes */
$routes->get('/employees', 'Employee::index', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/employees/create', 'Employee::create', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->post('/employees/store', 'Employee::store', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->post('/employees/update/(:num)', 'Employee::update/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->delete('/employees/(:num)', 'Employee::delete/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/employees/(:any)', 'Employee::detail/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->post('/employees/changePassword/(:num)', 'Employee::changePassword/$1', ['filter' => 'auth']);
$routes->post('/employees/makeadmin/(:num)', 'Employee::makeAdmin/$1', ['filter' => 'auth', 'filter' => 'notadmin']);

/* Departments Routes  */
$routes->get('/departments', 'Department::index', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/departments/create', 'Department::create', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->post('/departments/store', 'Department::store', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->post('/departments/update/(:num)', 'Department::update/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->delete('/departments/(:num)', 'Department::delete/$1', ['filter' => 'auth', 'filter' => 'notadmin']);
$routes->get('/departments/(:segment)', 'Department::detail/$1', ['filter' => 'auth', 'filter' => 'notadmin']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
