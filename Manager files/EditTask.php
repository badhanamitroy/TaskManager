<?php
// Connecting to the database
$connection = mysqli_connect('localhost', 'root', '', 'taskmanager');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Check if the form was submitted to update the task
if (isset($_POST['updateTask'])) {
    $taskID = $_POST['taskID'];
    $empID = $_POST['empID'];
    $taskDetails = $_POST['taskDetails'];
    $startDate = $_POST['StartDate'];
    $submitDate = $_POST['SubmitDate'];
    $taskStatus = $_POST['TaskStatus'];

    // Handle file upload
    $file = $_FILES['taskFile'];
    $fileName = $_FILES['taskFile']['name'];
    $fileTmpName = $_FILES['taskFile']['tmp_name'];
    $fileError = $_FILES['taskFile']['error'];
    $fileDestination = '';

    if ($fileError === 0) {
        // Move file to a directory (for example, 'uploads' folder)
        $fileDestination = 'uploads/' . $fileName;
        move_uploaded_file($fileTmpName, $fileDestination);
    }

    // Prepare the update query
    $updateQuery = "UPDATE taskinfo SET 
        empID = '$empID', 
        taskDetails = '$taskDetails', 
        StartDate = '$startDate', 
        SubmitDate = '$submitDate', 
        TaskStatus = '$taskStatus'";

    if ($fileDestination !== '') {
        $updateQuery .= ", file_path = '$fileDestination'";
    }

    $updateQuery .= " WHERE taskID = '$taskID'";

    if (mysqli_query($connection, $updateQuery)) {
        echo "Task updated successfully!";
        header("Location: ManageTasks.php");
        exit(); // Important to exit after a redirect
    } else {
        echo "Error updating task: " . mysqli_error($connection);
    }
}

// Fetch the task details to pre-populate the form
$task = null; // Initialize $task to null
if (isset($_GET['taskID'])) {
    $taskID = $_GET['taskID'];
    $taskQuery = "SELECT * FROM taskinfo WHERE taskID = '$taskID'";
    $taskResult = mysqli_query($connection, $taskQuery);

    // Check if the query returned a result
    if ($taskResult && mysqli_num_rows($taskResult) > 0) {
        $task = mysqli_fetch_assoc($taskResult);
    } else {
        // TaskID not found in the database
        echo "Task not found.";
    }
} 

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../css files/EditTaskdesign.css?v=<?php echo time();?>">
</head>
<style>
    body{
        font-family: Arial, sans-serif;
        background-color: #a0c1e8;
    }
    header{
    height: 20vh;
    background-color: rgb(1, 1, 67);
    border-bottom: 5px solid white;
}
.header-container{
    height: 20vh;
    /* border: 2px solid red; */
    align-content: center;
    /* justify-content: center; */
    width: 90vw;
    margin: auto;
    display: flex;
}
.logo{
    width: 110px;
    height: 120px;
    /* border: 2px solid yellow; */
    padding: 7px 0;
}
.title{
    /* border: 2px solid yellow; */
    width: 50vw;
    color: aliceblue;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    font-size: 55px;
    align-content: center;
    padding-left: 15px;;
}
</style>
<body>
<header>
    <div class="header-container">
        <img src="../media files/logo.png" alt="Taskmanager-logo" class="logo">
        <div class="title">Task Manager</div>
    </div>
</header>
<div class="edit-task-form-container">
    <h2>Edit Task</h2>

    <form method="POST" action="EditTask.php" enctype="multipart/form-data">
        <input type="hidden" name="taskID" value="<?php echo $task ? $task['taskID'] : ''; ?>">
        
        <label>Employee ID:</label>
        <input type="text" name="empID" value="<?php echo $task ? $task['empID'] : ''; ?>"><br>

        <label>Task Details:</label>
        <textarea name="taskDetails"><?php echo $task ? $task['taskDetails'] : ''; ?></textarea><br>

        <label>Start Date:</label>
        <input type="date" name="StartDate" value="<?php echo $task ? $task['StartDate'] : ''; ?>"><br>

        <label>Submit Date:</label>
        <input type="date" name="SubmitDate" value="<?php echo $task ? $task['SubmitDate'] : ''; ?>"><br>

        <label>Upload File:</label>
        <input type="file" name="taskFile"><br>

        <input type="submit" name="updateTask" value="Update Task" class="update-btn">
    </form>
</div>

</body>
</html>
