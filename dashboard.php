<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit;
}

include "db.php";

// Fetch all students
$sql = "SELECT * FROM students ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: center;
        }
        h2 {
            text-align: center;
        }
        img {
            height: 100px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            width: 90%;
            margin: 10px auto;
        }
        a {
            text-decoration: none;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>Welcome Admin</h2>

<div class="top-bar">
    <a href="generate.php">+ Add New Student</a>
    <a href="scanner.html">QR Scanner</a>
    <a href="logout.php">Logout</a>
    <a href="report.php">View Attendance Report</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Roll No</th>
        <th>QR Code</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
        <td>
            <img src="qrcodes/<?php echo $row['qr_code']; ?>.png" alt="QR">
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>