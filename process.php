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
