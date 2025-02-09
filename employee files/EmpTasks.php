<?php
session_start(); 

// Connect to the database
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'taskmanager';
$connection = mysqli_connect($server, $user, $pass, $db);

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (!isset($_SESSION['empID'])) {
    die('Session variable empID is not set.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tasks</title>
    <link rel="stylesheet" href="../css files/empTasks.css?v=<?php echo time()?>"> <!-- Link to your custom CSS file -->
</head>
<body>
    <center>
        <h1>Your tasks</h1>
        <hr>
        <table>
            <tr>
                <th>Sl</th>
                <th>Task ID</th>
                <th>Task Details</th>
                <th>Task File</th>
                <th>Deadline</th>
                <th>Submit File & Update Status</th>
            </tr>
            <?php 
                // Fetch tasks assigned to the logged-in employee
                $taskQuery = "SELECT * FROM taskinfo WHERE empID = '$_SESSION[empID]' ";
                $taskResult = mysqli_query($connection, $taskQuery);

                if (!$taskResult) {
                    die('Query failed: ' . mysqli_error($connection));
                }

                $sl = 1;
                if (mysqli_num_rows($taskResult) > 0) {
                    while ($taskRow = mysqli_fetch_assoc($taskResult)) {
                        // Define the download file path
                        $filePath = '../Manager files/taskFiles/' . $taskRow['taskFile'];
            ?>
            <tr>
                <td><?php echo $sl++; ?></td>
                <td><?php echo $taskRow['taskID']; ?></td>
                <td><?php echo $taskRow['taskDetails']; ?></td>
                <td>
                    <?php if (!empty($taskRow['taskFile'])) { ?>
                        <a href="<?php echo $filePath; ?>" download="<?php echo $taskRow['taskFile']; ?>">
                            <button type="button">Download</button>
                        </a>
                    <?php } else { ?>
                        No file
                    <?php } ?>
                </td>
                <td><?php echo $taskRow['SubmitDate']; ?></td>
                <td>
                    <!-- Form to upload file and update status -->
                    <form method="post" action="EmpTasks.php" enctype="multipart/form-data">
                        <!-- File Upload -->
                        <input type="file" name="uploadedFile" accept=".jpg,.jpeg,.png,.pdf,.docx,.pptx" style="width:80%;"> <!-- File is optional unless status is Completed -->

                        <!-- Status Update -->
                        <select id="StatusUpdate_<?php echo $taskRow['taskID'];?>" name="StatusUpdate" required style="width:80%">
                            <option disabled selected><?php echo $taskRow['TaskStatus']; ?></option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>                       
                        </select>

                        <!-- Hidden Task ID -->
                        <input type="hidden" name="TaskID" value="<?php echo $taskRow['taskID']; ?>">

                        <!-- Submit Button -->
                        <button type="submit" name="Update" style="margin-top:10px;width:80%;" id="Update">Update</button>
                    </form>
                </td>
            </tr>
            <?php 
                    }
                } else {
                    echo "<tr><td colspan='6'>No tasks found.</td></tr>";
                }
            ?>
        </table>
    </center>   
</body>
</html>

<?php
// Handle file upload and status update
if (isset($_POST['Update'])) {
    // Get Task ID and Status
    $taskID = $_POST['TaskID'];
    $taskStatus = $_POST['StatusUpdate'];

    // File upload handling (only for Completed status)
    if ($taskStatus == 'Completed') {
        if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
            // File upload logic for Completed tasks
            $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'pptx'];
            $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
            $fileName = $_FILES['uploadedFile']['name'];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $uploadDir = 'CompletedTasks/'; // Set the upload directory

            // Check if the file type is allowed
            if (in_array($fileType, $allowedTypes)) {
                // Create a unique file name to avoid conflicts
                $newFileName = $taskID . '_' . time() . '.' . $fileType; 
                $destPath = $uploadDir . $newFileName;

                // Move the file to the "CompletedTasks" directory
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Update the database with the new file name and status
                    $updateQuery = "UPDATE taskinfo SET TaskStatus = '$taskStatus', CompletedFile = '$newFileName' WHERE taskID = '$taskID'";
                    if (mysqli_query($connection, $updateQuery)) {
                        echo "<script>alert('Task updated successfully with file upload!'); window.location.href='empWorkspace.php';</script>";
                    } else {
                        echo "<p>Error updating task: " . mysqli_error($connection) . "</p>";
                    }
                } else {
                    echo "<p>Error moving the file.</p>";
                }
            } else {
                echo "<p>Invalid file type. Allowed types are: .jpg, .jpeg, .png, .pdf, .docx, .pptx</p>";
            }
        } else {
            echo "<script>alert('Please upload a file before marking the task as Completed.'); window.location.href='EmployeeTaskList.php';</script>";
        }
    } else {
        // Update status without file upload (e.g., for Ongoing)
        $updateQuery = "UPDATE taskinfo SET TaskStatus = '$taskStatus' WHERE taskID = '$taskID'";
        if (mysqli_query($connection, $updateQuery)) {
            echo "<script>alert('Task status updated successfully!'); window.location.href='empWorkspace.php';</script>";
        } else {
            echo "<p>Error updating task: " . mysqli_error($connection) . "</p>";
        }
    }
}

// Close the connection
mysqli_close($connection);
?>