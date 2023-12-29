<?php 
include("database.php");
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
} else {
    header("Location: signup.php");
}

// Add task
if(isset($_POST["add"])) {
    $user_id = $_SESSION["id"]; // Use the session user ID
    $task = filter_var($_POST["task"], FILTER_SANITIZE_SPECIAL_CHARS);
    $date = $_POST["date"];
    $time = $_POST["time"];

    // Validate that none of the fields are empty
    if (empty($task) || empty($date) || empty($time)) {
        echo "<script>alert('All fields must be filled.'); window.location.href='addtask.php';</script>";
        exit;
    }

    // Insert the task into the "task" table using prepared statement
    $sql = "INSERT INTO tasklist (id, task, date, time) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $task, $date, $time);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Check if the query was successful
    if ($success) {
        // Redirect to home.php after the task is added
        header("Location: home.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task</title>
    <link rel="stylesheet" href="css/addtask.css">
</head>
<body>
    <nav class="navbar">
        <h1>TaskManage</h1>
        <div class="menu">
            <a href="home.php">Back</a>
        </div>
    </nav>
    <center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Add task</h1>
            <input type="text" name="task" placeholder="Write your task" class="input"><br>
            <p class="deadline">Deadline:</p>
            <input type="time" name="time" class="input"><br>
            <input type="date" name="date" class="input"><br>
            <input type="submit" name="add" value="Add" class="button">
        </form>
    </center>
</body>
</html>