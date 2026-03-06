
<?php
//delete protocol

require 'config.php';

    header("Location: index.php?msg=error");
    exit;

//get the id
$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM team_members WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: index.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    die("Delete failed: " . $e->getMessage());
}
?>
<?php
//update feature
require "includes/config.php";

if (!isset($_GET['id'])) {
  die("No id was provided.");
}

$firstname = $_GET['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  
  $firstName = trim($_POST['firstname'] ?? '');
  $lastName  = trim($_POST['lastname'] ?? '');
  $phone     = trim($_POST['phone'] ?? '');
  $email     = trim($_POST['email'] ?? '');

  if($firstname === '' || $lastName ===  ''|| $email === ''){ 
    $error = "hey you we need these chuckles";
  }
  else{
     $sql = "UPDATE registrations
            SET first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email,
              
            WHERE firstname = :firstname";
             $stmt = $pdo->prepare($sql);

    
    $stmt->bindParam(':firstname', $firstName);
    $stmt->bindParam(':lastname', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);

    $stmt->bindParam(':firstname', $firstName);

    $stmt->execute();

    
    header("Location: registrations.sql");
    exit;
  }
}

$sql = "select * from registration where firstname =:firstname";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':firstname', $firstName);
$stmt->execute();


$firstName = $stmt->fetch();
  