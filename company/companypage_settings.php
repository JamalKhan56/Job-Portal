<?php
// Start the session
session_start();

// Check if the user is logged in (check for the existence of session variables)
if (!isset($_SESSION['id_company'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../company_signin.php"); // Adjust the login page filename accordingly
    exit();
}

// Include your database configuration file
include '../config.php';

// Access information from the session variables
$id_company = $_SESSION['id_company'];

// Fetch additional information from the database using the company_id
$sql = "SELECT * FROM company WHERE id_company = '$id_company'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the details of the logged-in company
    $companyDetails = $result->fetch_assoc();

    // Now you can use $companyDetails to access information from the database
}

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($new_password === $confirm_password) {
        // Hash the new password (you should use a more secure method in a real-world scenario)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $updatePasswordSQL = "UPDATE company SET password = '$hashed_password' WHERE id_company = '$id_company'";
        if ($conn->query($updatePasswordSQL) === TRUE) {
            echo "Password changed successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Passwords do not match!";
    }
}

// Handle account deactivation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deactivate_account'])) {
    // Delete the row from the database
    $deleteAccountSQL = "DELETE FROM company WHERE id_company = '$id_company'";
    if ($conn->query($deleteAccountSQL) === TRUE) {
        // Redirect to the login page after deactivation
        header("Location: ../company_signin.php");
        exit();
    } else {
        echo "Error deactivating account: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal Dashboard</title>
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



.content {
    flex: 1;
    padding: 20px;
    box-sizing: border-box;
    margin-left: 20%; /* Adjusted margin to align content to the right */
}

h1 {
    color: #333;
}

h2 {
    color: #555;
    margin-bottom: 15px;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 50%;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Additional styling for the deactivate account checkbox */
input[type="checkbox"] {
    margin-right: 5px;
}

/* Add more styles as needed */


    </style>
</head>
<body>

<nav>
    <h1>Job Portal</h1>
    <p>Welcome <?php echo $companyDetails['name']; ?></p>
    <a href="companypage.php">Dashboard</a>
    <a href="companypage_mycompany.php">My Company</a>
    <a href="companypage_createjobpost.php">Create Job Post</a>
    <a href="companypage_myjobpost.php">My Job Posts</a>
    <a href="companypage_jobapplication.php">Job Application</a>
    <a href="companypage_settings.php">Settings</a>
    <a href="companypage_resumedatabase.php">Resume Database</a>
    <a href="companypage_logout.php">Logout</a>

</nav>

<div class="content">
    <h1>Job Applications</h1>
    
    
    <h2>Change Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <input type="submit" name="change_password" value="Change Password">
    </form>

    <h2>Deactivate Account</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="checkbox" id="confirm_deactivation" name="confirm_deactivation" required>
        <label for="confirm_deactivation">I confirm that I want to deactivate my account.</label><br>

        <input type="submit" name="deactivate_account" value="Deactivate Account">
    </form>
</div>
    

<?php


?>

</body>
</html>