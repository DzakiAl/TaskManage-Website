<?php 
include("database.php");
session_start();

// Check if the user is already logged in
if(isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    header("Location: home.php");
    exit;
}

if(isset($_POST["login"])) {
    //sanitize input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    //selecting email in database
    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["pass"];
        
        //check if password is match with hassed password
        if(password_verify($password, $hashedPassword)) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: home.php");
            exit;
        } else {
            echo "<script> alert('Password is incorrect'); </script>";
        }
    } else {
        echo "<script> alert('User is not registered yet'); </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
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
            <h1>Login</h1>
            <input type="email" name="email" placeholder="Enter your email" class="input"><br>
            <input type="password" name="password" placeholder="Enter your password" class="input"><br>
            <input type="submit" name="login" value="Login" class="button"><br>
            <a href="signup.php">Sign up if you dont have account</a>
        </form>
    </center>
</body>
</html>