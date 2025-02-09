<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="./css files/style.css?v=<?php echo time()?>">
</head>
<body>
    <header>
        <div class="header-container">
         <img src="./media files/logo.png" alt="Taskmanager-logo" class="logo">
            <div class="title">
                Task Manager
            </div>
        </div>
    </header>
    <div class="container">
        <div class="content">
        <center>
            <h1>Log in as, </h1>
            <div class="btns">
                <button onclick="empshow()">Employee</button>
                <button onclick="mangshow()">Manager</button>
            </div>

            <div class="emp-login" id="emp-login">
                <h2>Login as Employee</h2>
                <hr>
                <a href="./employee files/emploginform.php">
                    <img src="./media files/employee.png" alt="" width="50%">
                </a>
                <!-- <img src="./media files/employee.png" alt="" width="50%"> -->
            </div>

            <div class="emp-login" id="mang-login">
                <h2>Login as Manager</h2>
                <hr>
                <a href="./manager files/managerloginform.php">
                    <img src="./media files/Manager.png" alt="" width="50%">
                </a>
            </div>
        </center>
        </div>
    </div>
    <script>
            document.getElementById("emp-login").style.display = "none";
            document.getElementById("mang-login").style.display = "none";

        function empshow() {
            document.getElementById("emp-login").style.display = "block";
            document.getElementById("mang-login").style.display = "none";
        }
        function mangshow() {
            document.getElementById("emp-login").style.display = "none";
            document.getElementById("mang-login").style.display = "block";
        }
    </script>

</body>
</html>