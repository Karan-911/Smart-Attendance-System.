<?php
include "db.php";             // Step 1: Database connection
include "qr_lib/qrlib.php";   // Step 2: QR library include

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll = $_POST['roll_no'];
    $qr_text = $roll . "_" . uniqid();  // QR ke liye unique text

    // Step 3: QR code image save karna
    $path = 'qrcodes/';
    if (!file_exists($path)) mkdir($path);
    $file = $path . $qr_text . ".png";
    QRcode::png($qr_text, $file, 'H', 4, 4);  // yaha image banti hai

    // Step 4: Student data DB me daalna
    $stmt = $conn->prepare("INSERT INTO students (name, roll_no, qr_code) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $roll, $qr_text);
    $stmt->execute();

    echo "QR Generated Successfully!<br>";
    echo "<img src='$file'><br>";
    echo "<a href='dashboard.php'>Back to Dashboard</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Generate QR</title></head>
<body>
    <h2>Generate QR for Student</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required><br>
        <input type="text" name="roll_no" placeholder="Roll No." required><br>
        <button type="submit">Generate</button>
    </form>
</body>
</html>