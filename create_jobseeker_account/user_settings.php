<?php
// Start the session
session_start();

// Check if the user is not logged in (check for the existence of session variables)
if (!isset($_SESSION['id_user'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Include your database configuration file
include '../config.php';

// Access information from the session variables
$id_user = $_SESSION['id_user'];

// Fetch additional information from the database using the id_user
$sql = "SELECT * FROM users WHERE id_user = '$id_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the details of the logged-in user
    $userDetails = $result->fetch_assoc();
}

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Change Password logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["changePassword"])) {
    $newPassword = sanitizeInput($_POST["newPassword"]);
    $confirmPassword = sanitizeInput($_POST["confirmPassword"]);

    // Validate if the passwords match
    if ($newPassword == $confirmPassword) {
        // Hash the new password before updating in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updatePasswordSql = "UPDATE users SET password = ? WHERE id_user = ?";
        $updatePasswordStmt = $conn->prepare($updatePasswordSql);
        $updatePasswordStmt->bind_param("si", $hashedPassword, $id_user);

        if ($updatePasswordStmt->execute()) {
            echo '<script>alert("Password changed successfully!");</script>';
        } else {
            echo '<script>alert("Error changing password: ' . $updatePasswordStmt->error . '");</script>';
        }

        $updatePasswordStmt->close();
    } else {
        echo '<script>alert("Passwords do not match!");</script>';
    }
}

// Deactivate Account logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deactivateAccount"])) {
    // Check if the checkbox is checked
    if (isset($_POST["confirmDeactivate"]) && $_POST["confirmDeactivate"] == "on") {
        // Delete the user account from the database
        $deleteAccountSql = "DELETE FROM users WHERE id_user = ?";
        $deleteAccountStmt = $conn->prepare($deleteAccountSql);
        $deleteAccountStmt->bind_param("i", $id_user);

        if ($deleteAccountStmt->execute()) {
            // Logout the user and redirect to login page
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            echo '<script>alert("Error deactivating account: ' . $deleteAccountStmt->error . '");</script>';
        }

        $deleteAccountStmt->close();
    } else {
        echo '<script>alert("Please confirm deactivation by checking the checkbox.");</script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #aba6a6;
        }

        nav {
            width: 20%;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        nav h1 {
            color: #fff;
            margin-bottom: 20px;
        }

        nav p {
            color: #ddd;
            margin-bottom: 30px;
        }

        nav a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 10px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #555;
        }

        .content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            margin-left: 20%; /* Adjusted margin to align content to the right */
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }
        body {
    margin: 0;
    font-family: 'Arial', sans-serif;
}

.blue-text {
    width: 100%;
    background-color: tan;
}

.header {
    width: 100%;
    background-color: skyblue;
    padding: 20px;
    text-align: center;
}

.content2 {
    display: flex;
}

.side-panel, .main-content {
    width: 50%;
    padding: 20px;
}

.side-panel {
    background-color: #f0f0f0; /* Light gray background */
}

.main-content {
    background-color: #fff; /* White background */
}



.row-container {
    display: flex;
    flex-wrap: wrap; /* Allow containers to wrap to the next line */
    margin: -10px; /* Adjust for the padding on the containers */
}

.container {
    display: flex;
    align-items: center;
    padding: 20px;
    margin: 10px; /* Adjust the margin between containers as needed */
    flex-basis: 0; /* Distribute available space equally */
    flex-grow: 1; /* Allow the container to grow */
    box-sizing: border-box; /* Include padding in the total width */
}

.container img {
    width: 80px;
    height: 40px; /* Ensure the image doesn't exceed the container width */
    margin-right: 10px; /* Adjust the margin between the image and text as needed */
}

.container p {
    margin: 0; /* Remove any default margin on the paragraph */
}
/* Additional styles for the forms in the content div */
form {
    margin-top: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form h2 {
    color: #333;
    margin-bottom: 15px;
}

form label {
    display: block;
    margin-bottom: 8px;
}

form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    background-color: #555;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form button:hover {
    background-color: #333;
}


    </style>
</head>
<body>



<nav>
    <h1>Job Portal</h1>
    <p>Welcome <?php echo $userDetails['firstname']; ?></p>
    <a href="editprofile.php">Edit Profile</a>
    <a href="myapplications.php">My Applications</a>
    <a href="jobs.php">Jobs</a>
   
    <a href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="content">
<h1>User Settings</h1>

<!-- Change Password Form -->
<form action="" method="post">
    <h2>Change Password</h2>
    <label for="newPassword">New Password:</label>
    <input type="password" name="newPassword" required>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" name="confirmPassword" required>

    <button type="submit" name="changePassword">Change Password</button>
</form>

<!-- Deactivate Account Form -->
<form action="" method="post">
    <h2>Deactivate Account</h2>
    <label>
        <input type="checkbox" name="confirmDeactivate" required>
        Confirm Deactivation
    </label>

    <button type="submit" name="deactivateAccount">Deactivate My Account</button>
</form>
</div>


<?php
$conn->close();
?>

</body>
</html>
