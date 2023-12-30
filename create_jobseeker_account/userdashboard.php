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

    // Now you can use $userDetails to access information from the database
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
.content p{
    line-height:30px;
}

.container p {
    margin: 0; /* Remove any default margin on the paragraph */
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
    <h1>Dashboard</h1>
    <p>Welcome to the User Dashboard of our Job Portal! This centralized hub provides users with seamless access to key features, enhancing their overall experience. The dashboard is designed for simplicity and efficiency, featuring five primary links for effortless navigation. "Edit Profile" allows users to update their personal information and refine their profiles for optimal visibility. The "Logout" link ensures a secure logout process, enhancing account security. Explore exciting job opportunities through the "Jobs" link, where users can browse and apply for positions relevant to their expertise. The user-friendly interface promotes a smooth and intuitive experience, ensuring that users can effortlessly navigate between sections. Each link corresponds to a dedicated section on the page, providing a structured layout for efficient interaction. As users hover over each link, the interface responds with subtle visual cues, enhancing the overall user experience. This dashboard is a testament to our commitment to user-centric design, making the job-seeking journey both streamlined and enjoyable.</p>
</div>


<?php
$conn->close();
?>

</body>
</html>
