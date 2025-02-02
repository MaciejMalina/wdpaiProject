<?php
session_start(); 
require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'SecurityController');
Router::get('login', 'SecurityController');
Router::get('logout', 'SecurityController');
Router::get('dashboard', 'DashboardController');
Router::get('profile', 'ProfileController');
Router::get('project', 'ProjectController');
Router::get('addProject', 'ProjectController');


Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('updateProfile', 'ProfileController');
Router::post('updateProject', 'ProjectController');
Router::post('createProject', 'ProjectController');
Router::post('addTeamMember', 'ProjectController');
Router::post('addTask', 'ProjectController');

Router::run($path);