<!-- PHP Part -->
<?php
    // Connecting to the database
    $connection = mysqli_connect('localhost', 'root', '', 'taskmanager');

    if (!$connection) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Handle delete action
    if (isset($_GET['Del'])) {
        $taskID = $_GET['TaskID']; // Get the TaskID from the query string
        $DelQuery = "DELETE FROM taskinfo WHERE TaskID = '$taskID'";
        $result = mysqli_query($connection, $DelQuery);
        header("Location: ManageTasks.php"); // Redirect back to the task manager
        exit();
    }

    // Fetch tasks from database
    $query = "SELECT * FROM taskinfo";
    $result = mysqli_query($connection, $query);
    $sl = 1;
?>

<!-- HTML Part -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Tasks</title>
    <link rel="stylesheet" href="../css files/ManageTask.css?v=<?php echo time();?>">
    <script src="./js files/jquery.js"></script>
</head>
<body>
    
    <h1 style="text-align:center">Assigned Tasks</h1>
    <table border="1">
        <tr>
            <th id="Sl">Sl</th>
            <th id="Tid">Task ID</th>
            <th id="Emp">Assigned to</th>
            <th id="TF">Task File</th>
            <th id="TDtl">Task Details</th>
            <th id="Tstd">Start date</th>
            <th id="Tsbd">Submission date</th>
            <th id="ComFile">Completed File</th>
            <th id="Tst">Status</th>
            <th id="Tact">Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $sl++; ?></td>
                <td><?php echo $row['taskID']; ?></td>
                <td><?php echo $row['empID']; ?></td>
                <td>
                    <?php if (!empty($row['taskFile'])): ?>
                        <a href="taskFiles/<?php echo $row['taskFile']; ?>" download>
                            <button>Download</button>
                        </a>
                    <?php else: ?>
                        No file uploaded
                    <?php endif; ?>
                </td>
                <td><?php echo $row['taskDetails']; ?></td>
                <td><?php echo $row['StartDate']; ?></td>
                <td><?php echo $row['SubmitDate']; ?></td>
                <td>
                    <?php if (!empty($row['taskFile'])): ?>
                        <a href="../employee files/CompletedTasks/<?php echo $row['CompletedFile']; ?>" download>
                            <button>Download</button>
                        </a>
                    <?php else: ?>
                        No file uploaded
                    <?php endif; ?>
                </td>
                <td id="Tst"><?php echo $row['TaskStatus']; ?></td>
                <td>
                    <center>
                        <a href="EditTask.php?TaskID=<?php echo $row['taskID'];?>"><button id="Edit">Edit</button></a>
                        <a href="?Del=true&TaskID=<?php echo $row['taskID']; ?>" onclick="return confirm('Are you sure you want to delete this task?');"><button id="Del">Delete</button></a>
                    </center>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="editorial"></div>
    <?php
        // Close the database connection
        mysqli_close($connection);   
    ?>
</body>
</html>