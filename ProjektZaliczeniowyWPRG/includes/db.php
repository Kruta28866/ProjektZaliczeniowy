<?php

$host = "localhost:3342";
$user = "admin";
$password = "admin";
$database = "blog";


define('mysqli', new mysqli($host,$user,$password,$database));





if (mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: ". mysqli -> connect_errno;
    mysqli -> close();
    exit();
}

?>