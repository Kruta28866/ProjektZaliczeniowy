<?php
include 'db.php';
session_start();

$mail = $_POST['mail'];
$password = $_POST['password'];

if(!empty($mail) && !empty($password)){

    $stmt = mysqli->prepare("SELECT * FROM `users` WHERE `mail` = ? AND `password` = ?");
    $stmt->bind_param("ss", $mail, $password);
    $stmt -> execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $_SESSION['mail'] = $row['mail'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['role'] = $row['role'];

    if ($result->num_rows > 0) {
        if ($_SESSION['mail'] === $mail && $_SESSION['password'] === $password) {
            header('Location: ../index.php');
        }

    }
    else{
        echo "podany użytkownik nie istnieje";
    }

}



//header('location: ../index.php');
?>
