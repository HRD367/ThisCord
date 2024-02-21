<?php

//Kollar om login uppgifter godkänns 
if (empty($_POST["name"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Vaild email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be > 8 characters");
}

if ( ! preg_match("/[a-z]/i" , $_POST["password"])) {
    die("Password must contain ≥ 1 letter");
}

if ( ! preg_match("/[0-9]/" , $_POST["password"])) {
    die("Password must contain ≥ 1 numeber");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}



//"incrypter" lösnmord 
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);





$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);

if ($stmt->execute()) {    //ser till at du inte kan regestera konto med samma mail

    header("Location: signup-success.html");
    exit;

    } else {
                    
        if ($mysqli->errno === 1062) {
            die("email already taken");
    } else {
            die($mysqli->error . " " . $mysqli->errno);
    }
}