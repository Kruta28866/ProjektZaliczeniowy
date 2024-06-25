<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['registerPassword']) && isset($_POST['registerRepeatPassword']) && $_POST['registerPassword'] === $_POST['registerRepeatPassword']) {
        $login = $_POST['login'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['registerPassword'], PASSWORD_DEFAULT); // Hash password for security

        $stmt = mysqli->prepare("SELECT COUNT(*) FROM `users` WHERE `login` = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->bind_result($usernameCount);
        $stmt->fetch();
        $stmt->close();

        if ($usernameCount > 0) {
            echo "Username already exists. Please choose a different one.";
        } else {

            $stmt = mysqli->prepare("SELECT COUNT(*) FROM `users` WHERE `mail` = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $stmt->bind_result($emailCount);
            $stmt->fetch();
            $stmt->close();

            if ($emailCount > 0) {
                echo "Email already exists. Please use a different email address.";
            } else {
                $stmt = mysqli->prepare("INSERT INTO `users` (`login`, `mail`, `password`) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $login, $mail, $password);
                $stmt->execute();

                if ($stmt->affected_rows === 1) {
                    echo "Registration successful! Please login.";
                } else {
                    echo "Registration failed. Please try again.";
                }
            }
        }
    } else {
        echo "Passwords do not match.";
    }
}

?>
