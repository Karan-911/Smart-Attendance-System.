<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit;
}

include "db.php";

// Fetch all attendance records with student names
$sql = "SELECT a.date, a.time, s.name, s.roll_no 
        FROM attendance a 
        JOIN students s ON a.student_id = s.id 
        ORDER BY a.date DESC, a.time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: center;
        }
        h2 {
            text-align: center;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Attendance Report</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Student Name</th>
        <th>Roll No</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['date'] ?></td>
        <td><?= $row['time'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['roll_no'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>