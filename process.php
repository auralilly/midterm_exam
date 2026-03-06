<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? '';

$first_name  = trim(filter_input(INPUT_POST, 'first_name',  FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$last_name   = trim(filter_input(INPUT_POST, 'last_name',   FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$phone       = trim(filter_input(INPUT_POST, 'phone',       FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$email       = trim(filter_input(INPUT_POST, 'email',       FILTER_SANITIZE_EMAIL) ?? '');

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?? 0;

$errors = [];
if ($first_name === ''){
     $errors[] = "First Name is required.";
}
elseif(strlen($first_name) < 2){
    $errors[] = "First name needs to be at least two characters";
}

if ($last_name === ''){
     $errors[] = "Last Name is required.";
}
elseif(strlen($last_name) < 2){
    $errors[] = "Last name needs to be at least two characters";
}

if ($email === ''){
     $errors[] = "Email is required.";
}
elseif(!filter_var($email, filter_validate_email)){
    $errors[] = "Pleaseprovide a valid email";
}

if ($phone === null || $phone === '') {
    $errors[] = "Phone number is required.";
} elseif (!filter_var($phone, FILTER_VALIDATE_REGEXP, [
    'options' => ['regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']
])) {
    $errors[] = "Phone number format is invalid.";
}
