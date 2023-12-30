<?php
// Start the session
session_start();
function sanitizeInput($input) {
    // Remove leading and trailing whitespaces
    $input = trim($input);
    
    // Remove backslashes
    $input = stripslashes($input);
    
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);

    return $input;
}

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

    // Now you can use $userDetails to access information from the database
}

// Update user profile logic
// Update user profile logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = sanitizeInput($_POST["firstname"]);
    $lastname = sanitizeInput($_POST["lastname"]);
    $email = sanitizeInput($_POST["email"]);
    $address = sanitizeInput($_POST["address"]);
    $city = sanitizeInput($_POST["city"]);
    $state = sanitizeInput($_POST["state"]);
    $contactno = sanitizeInput($_POST["contactno"]);
    $qualification = sanitizeInput($_POST["qualification"]);
    $stream = sanitizeInput($_POST["stream"]);
    $skills = sanitizeInput($_POST["skills"]);
    $aboutme = sanitizeInput($_POST["aboutme"]);
    
    // Update user profile in the database
    $updateSql = "UPDATE users SET 
                  firstname = ?, 
                  lastname = ?, 
                  email = ?, 
                  address = ?, 
                  city = ?, 
                  state = ?, 
                  contactno = ?, 
                  qualification = ?, 
                  stream = ?, 
                  skills = ?, 
                  aboutme = ?
                  WHERE id_user = ?";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssssissssi", 
        $firstname, $lastname, $email, $address, $city, $state, $contactno, 
        $qualification, $stream, $skills, $aboutme, $id_user);

    if ($updateStmt->execute()) {
        echo '<script>alert("Profile updated successfully!");</script>';

    } else {
        echo "Error updating profile: " . $updateStmt->error;
    }

    $updateStmt->close();
}


$conn->close();
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



.edit-profile-form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .edit-profile-form label {
            display: block;
            margin-bottom: 10px;
        }

        .edit-profile-form input,
        .edit-profile-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .edit-profile-form button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
    <a href="user_settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="content">
    <h1>dashboard</h1>
    <div class="content">
        <div class="edit-profile-form">
            <h1>Edit Profile</h1>
            <form action="" method="post">
            <label for="firstname">First Name:</label>
                <input type="text" name="firstname" value="<?php echo $userDetails['firstname']; ?>" required>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" value="<?php echo $userDetails['lastname']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $userDetails['email']; ?>" required>

                <label for="address">Address:</label>
                <textarea name="address" required><?php echo $userDetails['address']; ?></textarea>

                <label for="city">City:</label>
                <input type="text" name="city" value="<?php echo $userDetails['city']; ?>" required>

                <label for="state">State:</label>
                <input type="text" name="state" value="<?php echo $userDetails['state']; ?>" required>

                <label for="contactno">Contact Number:</label>
                <input type="text" name="contactno" value="<?php echo $userDetails['contactno']; ?>" required>

                <label for="qualification">Highest Qualification:</label>
                <input type="text" name="qualification" value="<?php echo $userDetails['qualification']; ?>" required>

                <label for="stream">Stream:</label>
                <input type="text" name="stream" value="<?php echo $userDetails['stream']; ?>" required>

                <label for="skills">Skills:</label>
                <input type="text" name="skills" value="<?php echo $userDetails['skills']; ?>" required>

                <label for="aboutme">About Me:</label>
                <textarea name="aboutme" required><?php echo $userDetails['aboutme']; ?></textarea>

                <label for="resume">Choose File (Resume):</label>
                <input type="file" name="resume">

                <button type="submit">Update Profile</button>






                
            </form>
        </div>
    </div>
</div>


<?php

?>

</body>
</html>
