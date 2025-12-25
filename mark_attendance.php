<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qr = $_POST['qr'];

    // Get student by QR code
    $stmt = $conn->prepare("SELECT * FROM students WHERE qr_code = ?");
    $stmt->bind_param("s", $qr);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();
        $student_id = $student['id'];
        $date = date("Y-m-d");
        $time = date("H:i:s");

        // Check if already marked
        $check = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? AND date = ?");
        $check->bind_param("is", $student_id, $date);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            echo "Attendance already marked.";
        } else {
            // Mark attendance
            $time = date('H:i:s');
            $insert = $conn->prepare("INSERT INTO attendance (student_id, date, time) VALUES (?, ?, ?)");
            $insert->bind_param("iss", $student_id, $date, $time);
            if ($insert->execute()) {
                echo "Attendance marked successfully.";
            } else {
                echo "Failed to mark attendance.";
            }
        }
    } else {
        echo "Invalid QR code.";
    }
}
?>