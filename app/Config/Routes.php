<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Api\StudentController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group("api",["namespace" => "App\Controller\Api"], function($routes){

    $routes->post("create-student",[StudentController::class,"addStudent"]);

    $routes->get("students",[StudentController::class,"listStudents"]);

    $routes->get("student/(:num)",[StudentController::class,"getSingleStudentData"]);

    $routes->put("student/(:num)",[StudentController::class,"updateStudent"]);

    $routes->delete("student/(:num)",[StudentController::class,"deleteStudent"]);

});
