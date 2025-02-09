<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Workspace</title>
    <link rel = "stylesheet" href="../css files/EmployeeWorkspace.css?v=<?php echo time()?>">
</head>
<body>
    <header>
        <div class ="header-container" style="align-items :center">
         <img src="../media files/logo.png" alt="Taskmanager-logo" class="logo">
            <div class="title" style="width:70%">
                Task Manager
            </div>
            <div style="color:aliceblue; font-size: 25px;">
                <?php echo $_SESSION['empName']?>
            </div>
        </div>    
    </header>

     <!-- Sidebar Navigation -->
      <div class="Employee-workspace">
      
     <aside>
            <nav>
                <ul>
                    <li><a href="empWorkspace.php">Guidlines</a></li>
                    <li id="YT">Your Task</li>
                    <li id="Apply">Apply for leave</li>
                    <li id="LvStat">Leave Status</li>
                </ul>
                
            </nav>
            <a href="../logout.php"><button class="logout">Log out</button></a>
        </aside>

        <!-- Main Content Section -->
        <main>
            <div class="Workspace-content">
                <!-- Main content will be loaded here -->
                <h4 style=" color:black; ">Welcome back Dear <span><?php echo  $_SESSION['empName'] ?></span>.</h3>
            </div>
        </main>
        </div>


<!-- jQuery Script Load and Sliding Functionality -->
    <script src="../jquery.js"></script>
    <script type="text/javascript">
        //Employee Tasks List
        $(document).ready(function() {
            $("#YT").click(function() {
                $(".Workspace-content").load("EmpTasks.php");
            });
        });
        // Apply for leave
        $(document).ready(function() {
            $("#Apply").click(function() {
                $(".Workspace-content").load("LeaveApply.php");
            });
        });
        // leave status
        $(document).ready(function() {
            $("#LvStat").click(function() {
                $(".Workspace-content").load("LeaveStatus.php");
            });
        });
    </script>
</body>
</html>