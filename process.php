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


if (!empty($errors)) {
    require "includes/index.php";
    echo "<div class='alert alert-danger mt-4'>";
    echo "<h2>Please fix the following errors:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "</div>";
    require "includes/index.php";
    exit;
}


if ($action === 'create') {
    $sql = "
        INSERT INTO team_members 
        (first_name, last_name, phone, email)
        VALUES (:first_name, :last_name, :phone, :email)
    ";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':first_name',  $first_name);
    $stmt->bindParam(':last_name',   $last_name);
    $stmt->bindParam(':phone',       $phone);
    $stmt->bindParam(':email',       $email);

    $stmt->execute();

    header("Location: index.php?msg=added");
    exit;
}