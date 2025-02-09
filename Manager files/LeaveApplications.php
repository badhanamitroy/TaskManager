<?php 
// Connect to the database
$connection = mysqli_connect('localhost', 'root', '', 'taskmanager');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Review</title>
    <link rel="stylesheet" href="../css files/LeaveApplications.css?v=<?php echo time();?>">
</head>
<body>
<h2>Review Leave Application</h2>
<hr>
<?php
    // Handle allow (approve) action
    if (isset($_POST['allow'])) {
        $empID = $_POST['empID']; // Fetch employee ID from form

        // Update leave status to 'Allowed'
        $updateStatus = "UPDATE employeeinfo SET leaveStatus = 'Allowed' WHERE empID = '$empID'";
        $updateResult = mysqli_query($connection, $updateStatus);

        // Check if the update was successful
        if ($updateResult) {
            // Now delete the leave application record from the leaveapps table
            $DelQuery = "DELETE FROM leaveapps WHERE empID = '$empID'";
            $deleteResult = mysqli_query($connection, $DelQuery);

            if ($deleteResult) {
                echo "<script>alert('Leave application approved and record deleted');
                window.location.href = 'managerWorkspace.php';
                </script>";
                exit();
            } else {
                echo "<script>alert('Failed to delete leave application')</script>";
            }
        } else {
            echo "<script>alert('Failed to approve leave application')</script>";
        }
    }

    // Handle deny action
    if (isset($_POST['deny'])) {
        $empID = $_POST['empID']; // Fetch employee ID from form

        // Update leave status to 'Denied'
        $updateStatus = "UPDATE employeeinfo SET leaveStatus = 'Denied' WHERE empID = '$empID'";
        $updateResult = mysqli_query($connection, $updateStatus);

        // Check if the update was successful
        if ($updateResult) {
            // Now delete the leave application record from the leaveapps table
            $DelQuery = "DELETE FROM leaveapps WHERE empID = '$empID'";
            $deleteResult = mysqli_query($connection, $DelQuery);

            if ($deleteResult) {
                echo "<script>alert('Leave application denied and record deleted');
                window.location.href = 'managerWorkspace.php';
                </script>";
                exit();
            } else {
                echo "<script>alert('Failed to delete leave application')</script>";
            }
        } else {
            echo "<script>alert('Failed to deny leave application')</script>";
        }
    }

    // Fetch leave applications
    $fetchQuery = "SELECT * FROM leaveapps";
    $fetchResult = mysqli_query($connection, $fetchQuery);
    if (mysqli_num_rows($fetchResult) > 0) {
        while ($row = mysqli_fetch_assoc($fetchResult)){ 
?>
    <div class="review-container">
        <div class="leave-details">
            <p><strong><?php echo $row['ApplyDate']; ?></strong> <span id="apply-date"></span></p>
            <p><strong>Subject: <u><?php echo $row['AppTopic']; ?></u></strong> <span id="app-topic"></span></p>
            <p><strong>Leave days: <?php echo $row['Days']; ?></strong> <span id="app-topic"></span></p>
            <textarea id="app-body" readonly><?php echo $row['AppBody']; ?></textarea>

            <div class="employee-info">
                <p>I remain,</p>
                <p><strong><?php echo $row['empName']; ?></strong> <span id="emp-name"></span></p>
                <p><b>Employee ID: <?php echo $row['empID']; ?></b> <span id="emp-id"></span></p>
            </div>

            <div class="button-group">
                <form action="LeaveApplications.php" method="POST">
                    <input type="hidden" name="empID" value="<?php echo $row['empID']; ?>">
                    <button type="submit" name="allow" id="allow" value="allow" class="allow-button">Allow</button>
                    <button type="submit" name="deny" id="deny" value="deny" class="deny-button">Deny</button>
                </form>
            </div>
        </div>
    </div>
<?php
        }
    } else {
        echo "<p>No leave applications found.</p>";
    }
?>   
</body>
</html>