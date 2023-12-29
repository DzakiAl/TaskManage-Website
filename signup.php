<?php
include("database.php");

if (isset($_POST["submit"])) {
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if (empty($password)) {
        echo "<script>alert('Password is empty'); window.location.href = 'signup.php';</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if email is already in the database
        $duplicateStmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $duplicateStmt->bind_param("s", $email); // Bind email
        $duplicateStmt->execute();
        $duplicateResult = $duplicateStmt->get_result();

        if ($duplicateResult->num_rows > 0) {
            echo "<script>alert('Email already taken!'); window.location.href = 'signup.php';</script>";
        } else {
            //send data to database
            $query = "INSERT INTO user (name, email, pass) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($query);
            $insertStmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($insertStmt->execute()) {
                header("Location: login.php");
            } else {
                echo "Error inserting user data: " . $insertStmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <nav class="navbar">
        <h1>TaskManage</h1>
        <div class="menu">
            <a href="index.html">Home</a>
        </div>
    </nav>
    <center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Sign Up</h1>
            <input type="text" name="name" placeholder="Enter your name" class="input"><br>
            <input type="email" name="email" placeholder="Enter your email" class="input"><br>
            <input type="password" name="password" placeholder="Enter your password" class="input"><br>
            <input type="submit" name="submit" value="Sign Up" class="button"><br>
            <a href="login.php">login if you have account</a>
        </form>
    </center>
</body>
</html>