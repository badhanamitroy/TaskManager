<?php
session_start();
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taskmanager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data and escape special characters
    $subject = mysqli_real_escape_string($conn, $_POST['AppTopic']);
    $body = mysqli_real_escape_string($conn, $_POST['AppBody']);
    $applyDate = date("d-m-Y");
    $empID = $_SESSION['empID'] ?? ''; // Check if session variable is set
    $LeaveDays = isset($_POST['Days']) ? (int)$_POST['Days'] : 0;  // Cast to int for safety

    // Validate that empID is not empty
    if (!empty($empID)) {

        // Prepare SQL statement
        $sql = "INSERT INTO leaveapps (empID, empName, ApplyDate, AppTopic, AppBody, `Days`) 
                VALUES ('$empID', '{$_SESSION['empName']}', CURDATE(), '$subject', '$body', '$LeaveDays')";
        
        // Print the SQL statement for debugging
        // Uncomment the next line to see the query output
        // echo $sql; die;

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            header("Location: empWorkspace.php");
            exit(); // Use exit after header redirect
        } else {
            echo "<script type='text/javascript'>alert('Error: " . mysqli_error($conn) . "');</script>";
        }

    } else {
        echo "Error: empID is missing. Please log in.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
    <style>

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 100%;
            margin: auto;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #1e3d7b;
            margin-bottom: 20px;
            font-weight: bold;
        }
        hr{
            width:60%;
            margin: auto;
            margin-bottom: 15px;

        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: bold;
            color: #1e3d7b;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid black;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            color: #333;
        }

        textarea {
            resize: none;
            text-align: justify;
        }

        .submit {
            background-color: #1e3d7b;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .submit:hover {
            background-color: #3a67c9;
        }

        .container p {
            color: #555;
            font-size: 14px;
            margin-top: 15px;
        }

        /* For responsiveness */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Leave Application</h2>
        <hr>
        <form action="LeaveApply.php" method="POST" id="leaveForm">
            <label for="AppTopic">Subject for Leave</label>
            <input type="text" id="AppTopic" name="AppTopic" placeholder="Enter your subject" required>

            <label for="AppBody">Application Body</label>
            <textarea id="AppBody" name="AppBody" rows="5" placeholder="Write your application..." required></textarea>

            <label for="Days">Number of Leave Days</label>
            <input type="text" id="Days" name="Days" placeholder="Enter number of leave days" required>

            <button type="submit" class="submit">Send Application</button>
        </form>
    </div>
</body>
</html>
