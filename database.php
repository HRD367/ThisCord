<?php

$host = "localhost";
$dbname = "login_tcdb"; //namet finns i phpadmin
$username = "root";
$password = "";

$mysqli = new mysqli(hostname: $host, 
                      username: $username, 
                      password: $password, 
                      database: $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error); //conntion check till databas
}

return $mysqli;