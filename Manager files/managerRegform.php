<?php
// Connecting to the database
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'taskmanager';
$connection = mysqli_connect($server, $user, $pass, $db);

if(!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

if(isset($_POST['submit'])) {

    // Sanitize inputs to prevent SQL injection
    $ManagerId = mysqli_real_escape_string($connection, $_POST['ManagerId']);
    $ManagerName = mysqli_real_escape_string($connection, $_POST['ManagerName']);
    $ManagerPhone = mysqli_real_escape_string($connection, $_POST['ManagerPhone']);
    $ManagerEmail = mysqli_real_escape_string($connection, $_POST['ManagerEmail']);
    $ManagerPass = mysqli_real_escape_string($connection, $_POST['ManagerPass']);

    // Inserting sanitized data into the database
    $query = "INSERT INTO managerinfo (ManagerID, ManagerName, ManagerPhone, ManagerEmail, ManagerPass) 
              VALUES ('$ManagerId', '$ManagerName', '$ManagerPhone', '$ManagerEmail', '$ManagerPass')";

    $queryRun = mysqli_query($connection, $query);

    // Handling success and failure messages
    if ($queryRun) {
        echo "<script type='text/javascript'>
                alert('Manager registered successfully! Redirecting to Admin login.');
                
              </script>";
              header("Location: ../homepage.php");
        exit();  // Prevent further script execution after success
    } else {
        // Display error message in case of failure
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Registration</title>
    <link rel="stylesheet" href="../css files/style.css?v=<?php echo time() ?>">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="../media files/logo.png" alt="Taskmanager-logo" class="logo">
            <div class="title">Task Manager</div>
        </div>
    </header>
    
    <div class="container">
        <div class="content">
            <center>
                <div class="forms">
                    <div class="emp-login" id="emp-login">
                        <h2>Register as Manager</h2>
    
                        <form action="" method="post">
                            <input type="text" name="ManagerId" placeholder="Enter Manager ID" required><br>
                            <input type="text" name="ManagerName" placeholder="Enter your name" required><br>
                            <input type="tel" name="ManagerPhone" placeholder="Enter phone number" required><br>
                            <input type="email" name="ManagerEmail" placeholder="Enter your email" required><br>
                            <input type="password" name="ManagerPass" placeholder="Enter your password" required><br>
                            <button type="submit" name="submit" class="submit" class="submit">Register</button>
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
</body>
</html>
