<?php
date_default_timezone_set('asia/kolkata');
$conn = new mysqli("localhost", "root", "", "smart_attendance",3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>