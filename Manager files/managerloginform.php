<?php
// Connect to the database
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'taskmanager';
$connection = mysqli_connect($server, $user, $pass, $db);

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Check if the form has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // Ensure 'ManagerID' and 'ManagerPass' are set before trying to use them
    if (!empty($_POST['ManagerID']) && !empty($_POST['ManagerPass'])) {

        // Sanitize inputs to prevent SQL injection
        $ManagerID = mysqli_real_escape_string($connection, $_POST['ManagerID']);
        $ManagerPass = mysqli_real_escape_string($connection, $_POST['ManagerPass']);

        // Prepare SQL query to fetch manager data
        $sql = "SELECT * FROM managerinfo WHERE ManagerID = '$ManagerID' AND ManagerPass = '$ManagerPass'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Redirect to a dashboard or main page after successful login
            header("Location: managerWorkspace.php");
            exit();  // Prevent further script execution
        } else {
            // Display error if login fails
            echo "<p style='color:red;'>Invalid Manager ID or Password.</p>";
        }

    } else {
        // If the form fields are empty, display an error message
        echo "<p style='color:red;'>Please fill in both Manager ID and Password.</p>";
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
    <link rel="stylesheet" href="../css files/style.css?v=<?php echo time()?>">

</head>
<body>
    <header>
        <div class="header-container">
         <img src="../media files/logo.png" alt="Taskmanager-logo" class="logo">
            <div class="title">
                Task Manager
            </div>
        </div>
    </header>
    <div>
        <center>
            <br>
            <br>
            <br>
            <h1>Dear sir, Log in to your account...</h1>
            <img src="../media files/Manager.png" alt="" width="10%">
            
            <form action="" method="post">
                <input type="text" name="ManagerID" placeholder="Enter Manager ID" required><br>
                <input type="password" name="ManagerPass" placeholder="Enter your password" required><br>
                <button type="submit" name="submit" class="submit">Login</button>
            </form>
         </center>
    </div>
                <!-- </div> -->
</body>
</html>