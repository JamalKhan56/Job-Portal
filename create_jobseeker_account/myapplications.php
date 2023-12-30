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
<?php
    // Fetch job information from apply_job_post and jobpost tables
    $sqlJobInfo = "SELECT job_post.jobtitle
                   FROM apply_job_post
                   JOIN job_post ON apply_job_post.id_jobpost = job_post.id_jobpost
                   WHERE apply_job_post.id_user = '$id_user'";

    $resultJobInfo = $conn->query($sqlJobInfo);

    if ($resultJobInfo->num_rows > 0) {
        echo'You have applied for the given below jobs';
        echo '<div class="job-info">';
        echo '<h2>Job Information</h2>';

        while ($rowJobInfo = $resultJobInfo->fetch_assoc()) {
            echo '<p>' . $rowJobInfo['jobtitle'] . '</p>';
        }

        echo '</div>';
    } else {
        echo '<p>No job information available.</p>';
    }
    ?>


</div>


<?php
$conn->close();
?>

</body>
</html>
