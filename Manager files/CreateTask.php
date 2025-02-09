<?php
// Connecting to the database
$con = mysqli_connect('localhost', 'root', '', 'taskmanager');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["AssignTask"])) {
    // Escape and sanitize input data
    $TaskID = mysqli_real_escape_string($con, $_POST["taskID"]);
    $empID = mysqli_real_escape_string($con, $_POST["empID"]);
    $taskDetails = mysqli_real_escape_string($con, $_POST["taskDetails"]);
    $StartDate = mysqli_real_escape_string($con, $_POST["startDate"]);
    $SubmissionDate = mysqli_real_escape_string($con, $_POST["submitDate"]);

    // Handle file upload
    $taskFile = $_FILES['taskFile']['name'];
    $taskFileTmpName = $_FILES['taskFile']['tmp_name'];
    $uploadDir = __DIR__ . "/taskFiles/"; // Use absolute path to store the file
    $fileDestination = $uploadDir . basename($taskFile);

    // Ensure the directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    // Get file type
    $file_type = pathinfo($fileDestination, PATHINFO_EXTENSION);
    $allowed_types = array("png", "jpeg", "jpg", "pdf", "docx", "txt");

    // Check if the file is of the allowed type
    if (!empty($taskFile) && in_array($file_type, $allowed_types)) {
        // Move the uploaded file to the specified destination
        if (move_uploaded_file($taskFileTmpName, $fileDestination)) {
            // File uploaded successfully
        } else {
            die("Error uploading file.");
        }
    } else {
        if (!empty($taskFile)) {
            echo "<script>alert('File type not allowed. Please upload a JPG, JPEG, PNG, PDF, DOCX, or TXT file.');</script>";
            exit;
        }
        $taskFile = null; // Handle cases where no file is uploaded
    }

    // Insert task data into the database
    $Query = "INSERT INTO taskinfo (taskID, empID, taskFile, taskDetails, startDate, submitDate) 
              VALUES ('$TaskID', '$empID', '$taskFile', '$taskDetails', '$StartDate', '$SubmissionDate')";  
    $Result = mysqli_query($con, $Query);

    if ($Result) {
        echo "<script>alert('Task assigned successfully!...');
            window.location.href = 'managerWorkspace.php';
        </script>";
        //echo "Task assigned successfully!..";
        //header("Location: managerWorkspace.php");
        exit();
    } else {
        echo "<script>alert('Error assigning task: " . mysqli_error($con) . "');</script>";
    }
}

mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="../css files/Createtask.css?php echo time(); ?>">
</head>
<body>
    <div class="task-form-container">
        <h2>Create Task</h2>
        <form action="CreateTask.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="taskID">Enter Task ID</label>
                <input type="text" id="taskID" name="taskID" required>
            </div>

            <div class="form-group">
                <label for="assignTo">Assign to</label>
                <select id="assignTo" name="empID" required>
                    <option disabled selected>Select Employee</option>
                    <?php
                        // Connecting to the database
                        $con = mysqli_connect('localhost', 'root', '', 'taskmanager');
                        if (!$con) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        
                        // Fetch employees who are not yet assigned a task or have completed their tasks
                        $sql = "SELECT u.empID, u.empName 
                                FROM employeeinfo u 
                                LEFT JOIN taskinfo t ON u.empID = t.empID 
                                WHERE t.empID IS NULL OR t.TaskStatus = 'Completed'";
                        $sqlresult = mysqli_query($con, $sql);

                        if (mysqli_num_rows($sqlresult) > 0) {
                            while($row = mysqli_fetch_assoc($sqlresult)) {
                                echo '<option value="' . $row['empID'] . '">' . $row['empName'] . '</option>';
                            }
                        } else {
                            echo '<option disabled>No employees available</option>';
                        }

                        mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="form-group file-group">
                <label for="taskFile">Task File</label><br>
                <input type="file" id="taskFile" name="taskFile">
            </div>

            <div class="form-group">
                <label for="taskDetails">Enter Task Details</label>
                <textarea id="taskDetails" name="taskDetails" rows="4" required></textarea>
            </div>

            <div class="form-group date-group">
                <div>
                    <label for="startDate">Start Date</label>
                    <input type="date" id="startDate" name="startDate" required>
                </div>
                <div>
                    <label for="submitDate">Submit Date</label>
                    <input type="date" id="submitDate" name="submitDate" required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="AssignTask" class="assign-btn">Assign</button>
            </div>
        </form>
    </div>
</body>
</html>
