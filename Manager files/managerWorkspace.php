<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Workspace</title>
    <link rel="stylesheet" href="../css files/ManagerWorkspace.css?v=<?php echo time()?>">

</head>
<body>
    <header>
        <div class="header-container">
            <img src="../media files/logo.png" alt="Taskmanager-logo" class="logo">
            <div class="title">Task Manager</div>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <div class="workspace">
        <div class="leftside">
            <nav>
                <ul>
                    <li><a href="managerWorkspace.php">Guidelines</a></li>
                    <li id="CRT">Create Task</li>
                    <li id="MT">Manage Task</li>
                    <li id="LvApps">Leave Applications</li>
                </ul>
            </nav>
            <a href="../logout.php"><button class="logout">Log out</button></a>
        </div>

        <!-- Main Content Section -->
        <div class="rightside">
                <!-- Main content will be loaded here -->
                <center>
                    <div class="Rs">
                    <h3 style="margin-left :20px;">Welcome back Sir.</h3>
                    </div>
                </center>
     
        </div>
    </div>

    <!-- jQuery Script Load and Sliding Functionality -->


    <script src="../jquery.js"></script>
    <script type="text/javascript">
    // Create Task
        $(document).ready(function() {
            $("#CRT").click(function() {
                $(".Rs").load("CreateTask.php");
            });
        });

    // Manage Task
        $(document).ready(function() {
            $("#MT").click(function() {
                $(".Rs").load("ManageTasks.php");
            });
        });
    // Leave Applications
        $(document).ready(function() {
            $("#LvApps").click(function() {
                $(".Rs").load("LeaveApplications.php");
            });
        });
    
    </script>
</body>
</html>
