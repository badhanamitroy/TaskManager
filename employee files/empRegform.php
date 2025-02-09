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
    $empId = mysqli_real_escape_string($connection, $_POST['empId']);
    $empName = mysqli_real_escape_string($connection, $_POST['empName']);
    $empPhone = mysqli_real_escape_string($connection, $_POST['empPhone']);
    $empEmail = mysqli_real_escape_string($connection, $_POST['empEmail']);
    $empPass = mysqli_real_escape_string($connection, $_POST['empPass']);

    // Inserting sanitized data into the database
    $query = "INSERT INTO employeeinfo (empID, empName, empPhone, empEmail, empPass) 
              VALUES ('$empId', '$empName', '$empPhone', '$empEmail', '$empPass')";

    $queryRun = mysqli_query($connection, $query);

    // Handling success and failure messages
    if ($queryRun) {
        echo "<script type='text/javascript'>
                alert('Registration Successfull!...');
                 window.location.href = '../homepage.php';
              </script>";
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
                        <h2>Register as Employee</h2>
    
                        <form action="" method="post">
                            <input type="text" name="empId" placeholder="Enter Employee ID" required><br>
                            <input type="text" name="empName" placeholder="Enter your name" required><br>
                            <input type="tel" name="empPhone" placeholder="Enter phone number" required><br>
                            <input type="email" name="empEmail" placeholder="Enter your email" required><br>
                            <input type="password" name="empPass" placeholder="Enter your password" required><br>
                            <button type="submit" name="submit" class="submit" class="submit">Register</button>
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
</body>
</html>
