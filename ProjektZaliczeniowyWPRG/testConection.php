<?php

include 'includes/db.php';


$login = 'test1';
$password = 'test1232';
$mail = 'test@test.com';

$stmt = mysqli -> prepare("INSERT INTO users (login, password, mail) VALUES (?, ?, ?)");
$stmt -> bind_param("sss", $login, $password, $mail);

if($stmt->execute()){
    echo "new record has been added";
}
else{
    echo "error while adding record". $stmt->error;
}
$stmt->close();
//$stmt -> execute();
//$stmt = DBH ->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
//$stmt->execute([$login, $password, $mail]);

?>