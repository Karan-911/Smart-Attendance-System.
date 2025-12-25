<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $role = $_POST["role"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    $check = $conn->prepare("SELECT * FROM users WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists.";
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $insert = $conn->prepare("INSERT INTO users (name, email, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssss", $name, $email, $username, $hash, $role);

    if ($insert->execute()) {
        $_SESSION['admin'] = $username;
        $_SESSION['role'] = $role;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Signup failed!";
    }
}
?>