<?php 
include("database.php");
session_start();

if (!empty($_SESSION["id"])) {
    $user_id = $_SESSION["id"];
} else {
    header("Location: signup.php");
}

// Use prepared statement
$sql = "SELECT tasklist.id_task, tasklist.task, tasklist.date, tasklist.time
        FROM tasklist
        WHERE tasklist.id = ?";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "i", $user_id);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <nav class="navbar">
        <h1>TaskManage</h1>
        <div class="menu">
            <a href="logout.php">Logout</a>
            <a href="profile.php">Profile</a>
            <a href="addtask.php">Add task</a>
        </div>
    </nav>
    <div class="content">
        <?php 
        // Fetch and display results
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="container">
            <h1><?php echo $row['task'];?></h1>
            <div class="deadline">
                <p>Due at</p>
                <p><?php echo date('H:i', strtotime($row['time'])); ?>,</p>
                <p><?php echo $row['date'];?></p>
            </div>
            <a href="?delete=<?php echo $row['id_task']; ?>" onclick="return confirmDelete()">Mark as complete</a>
        </div>
        <?php 
        }

        // Handle task deletion
        if (isset($_GET['delete'])) {
            $delete_id = $_GET['delete'];

            // Use prepared statement to delete the task
            $delete_sql = "DELETE FROM tasklist WHERE id_task = ? AND id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);
            mysqli_stmt_bind_param($delete_stmt, "ii", $delete_id, $user_id);
            mysqli_stmt_execute($delete_stmt);

            // Close the statement
            mysqli_stmt_close($delete_stmt);

            // Redirect back to home.php
            header("Location: home.php");
            exit;
        }
        ?>
    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to mark this task as complete, it will delete the task?");
        }
    </script>
</body>
</html>