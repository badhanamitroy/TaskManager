<?php
session_start();  // Start the session

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

    // Ensure 'empId' and 'empPass' are set before trying to use them
    if (!empty($_POST['empId']) && !empty($_POST['empPass'])) {
        
        // Sanitize inputs to prevent SQL injection
        $empId = mysqli_real_escape_string($connection, $_POST['empId']);
        $empPass = mysqli_real_escape_string($connection, $_POST['empPass']);

        // Prepare SQL query to fetch employee data
        $sql = "SELECT * FROM employeeinfo WHERE empId = '$empId' AND empPass = '$empPass'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Fetch user data and start session
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['empID'] = $row['empID'];
                $_SESSION['empPass'] = $row['empPass'];
                $_SESSION['empName'] = $row['empName'];
            }

            // Redirect to a dashboard or main page after successful login
                  header("Location: empWorkspace.php");
            exit();  // Prevent further script execution

        } else {
            // Display error if login fails
            echo "<script type='text/javascript'>
                    alert('Invalid Employee ID or Password.');
                  </script>";
        }

    } else {
        // If the form fields are empty, display an error message
        echo "<script type='text/javascript'>
                alert('Please fill in both Employee ID and Password.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee login</title>
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

    <div class="forms">
    <center>
            <br>
            <br>
            <br>
        <div>
            <h2>Login as Employee</h2>
            <img src="../media files/employee.png" alt="" width="10%">
            <h4>Don't have an account? <a href="../employee files/empRegform.php">Register here</a></h4>

            <form action="" method="post">  <!-- Keep action empty for self-submission -->
            <input type="text" name="empId" placeholder="Enter Employee ID" required><br> 
                <input type="password" name="empPass" placeholder="Enter your password" required><br>
                <button type="submit" name="submit" class="submit">Login</button>
            </form>
        </div>
    </center>
    </div>
</body>
</html>