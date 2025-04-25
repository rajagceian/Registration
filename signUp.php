<?php
$mysqli = new mysqli("localhost", "root", "", "std_registration");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$name     = $_POST['name'] ?? '';
$username = $_POST['username'] ?? '';
$email    = $_POST['email'] ?? '';
$pass     = $_POST['pass'] ?? '';

// Password validation
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass)) {
    echo "password_error";
    exit;
}

// Check for unique username
$checkUser = $mysqli->prepare("SELECT id FROM signup WHERE username = ? LIMIT 1");
$checkUser->bind_param("s", $username);
$checkUser->execute();
$checkUser->store_result();

if ($checkUser->num_rows > 0) {
    echo "username_error";
    exit;
}

// Check for unique email
$checkEmail = $mysqli->prepare("SELECT id FROM signup WHERE email = ? LIMIT 1");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$checkEmail->store_result();

if ($checkEmail->num_rows > 0) {
    echo "email_error";
    exit;
}

// Insert new user
$stmt = $mysqli->prepare("INSERT INTO signup (name, username, email, pass) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $username, $email, $pass);

if ($stmt->execute()) {
    echo "1";
} else {
    echo "Something went wrong. Try again!";
}
?>
