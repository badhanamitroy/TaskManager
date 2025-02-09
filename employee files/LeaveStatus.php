<?php
session_start();

// Check if session is active and empID exists
if (!isset($_SESSION['empID'])) {
    // Redirect to login or another appropriate page if session is not set
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taskmanager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch leave status for the logged-in user
$sql = "SELECT LeaveStatus FROM employeeinfo WHERE empID = '$_SESSION[empID]'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $leave_status = $row['LeaveStatus'];
} else {
    $leave_status = "No record found"; // If no record exists
}

// Handle "OK" button click to remove the message and redirect
if (isset($_POST['ok'])) {
    // Remove the message by updating LeaveStatus to an empty string
    $sql = "UPDATE employeeinfo SET LeaveStatus='' WHERE empID = '$_SESSION[empID]'";
    $conn->query($sql);
    
    // Redirect to empWorkspace.php
    header("Location: empWorkspace.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Status</title>
    <link rel="stylesheet" href="../css files/LeaveStatus.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="notification-container">
        <?php if ($leave_status && $leave_status != ''): ?>
            <div class="notification">
                <p>Your Leave Application has been <?php echo $leave_status; ?></p>
            </div>
        <?php else: ?>
            <div class="notification">
                <p>You have no new notifications.</p>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <button type="submit" name="ok" class="ok">OK</button>
        </form>
    </div>
</body>
</html>
