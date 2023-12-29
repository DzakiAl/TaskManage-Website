<?php
include("database.php");
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];

    $user_query = mysqli_query($conn, "SELECT * FROM user WHERE id = id");
    $user_data = mysqli_fetch_assoc($user_query);
} else {
    header("Location: signup.php");
}

$user_id = $_SESSION['id'];

// Fetch the user's current information from the database
$query = "SELECT * FROM user WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST["change"])) {
    // Handle changes to name, email, and password
    $new_name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $new_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $new_password = $_POST["password"]; // Do not hash the password here

    // Build the SQL query dynamically based on which fields are not empty
    $update_query = "UPDATE user SET ";
    $updates = array();

    if (!empty($new_name)) {
        $updates[] = "name = '$new_name'";
    }

    if (!empty($new_email)) {
        $updates[] = "email = '$new_email'";
    }

    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $updates[] = "password = '$new_password'";
    }

    if (empty($updates)) {
        echo "<script>alert('No fields provided for update.');</script>";
    } else {
        $update_query .= implode(', ', $updates);
        $update_query .= " WHERE id = $user_id";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('User information updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating user information.');</script>";
        }
    }

    // Update the user's session with the new information
    $_SESSION['name'] = $new_name;
    $_SESSION['email'] = $new_email;

    // Redirect to the user's profile page or any other desired page
    header("Location: profile.php");
}

if(isset($_POST["cancel"])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <script>
        //change navbar color while scrolling
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            const content = document.querySelector('.content');
            const scrollPos = window.scrollY;

            if (scrollPos > content.offsetTop - navbar.clientHeight) {
                navbar.style.backgroundColor = '#000000'; // Change to your desired color
            } else {
                navbar.style.backgroundColor = 'transparent';
            }
        });
    </script>
    <nav class="navbar">
        <h1>TaskManage</h1>
        <div class="menu">
            <a href="home.php">Back</a>
        </div>
    </nav>
    <div class="content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Your Profile</h1>
            <div class="section">
                <p>Your name:</p>
                <input type="text" name="name" placeholder="<?php echo $user_data['name']; ?>" class="input">
            </div>
            <div class="section">
                <p>Your email:</p>
                <input type="email" name="email" placeholder="<?php echo $user_data['email']; ?>" class="input">
            </div>
            <div class="section">
                <p>Your password:</p>
                <input type="password" name="password" placeholder="***************************" class="input">
            </div>
            <center>
                <input type="submit" name="change" value="Change" class="button">
                <input type="submit" name="cancel" value="Cancel" class="button">
            </center>
        </form>
    </div>
</body>
</html>