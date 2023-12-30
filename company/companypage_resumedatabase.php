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
    
<?php
// Start the session


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

// Fetch all id_user from apply_job_post where id_company is the current company
$sqlApplyJobPost = "SELECT id_user FROM apply_job_post WHERE id_company = '$id_company'";
$resultApplyJobPost = $conn->query($sqlApplyJobPost);

if (!$resultApplyJobPost) {
    die("Query failed: " . $conn->error);
}

// Check if there are any applicants
if ($resultApplyJobPost->num_rows > 0) {
    // Display user details for each id_user
    while ($rowApplyJobPost = $resultApplyJobPost->fetch_assoc()) {
        $id_user = $rowApplyJobPost['id_user'];

        $sqlUserDetails = "SELECT * FROM users WHERE id_user = '$id_user'";
        $resultUserDetails = $conn->query($sqlUserDetails);

        if (!$resultUserDetails) {
            die("Query failed: " . $conn->error);
        }

        if ($resultUserDetails->num_rows > 0) {
            $userDetails = $resultUserDetails->fetch_assoc();

            // Output user details in the content div
            echo '<div class="content2">';
            echo '<div class="side-panel">';
            echo '<h2>' . $userDetails['firstname'] . ' ' . $userDetails['lastname'] . '</h2>';
            echo '<p>Qualification: ' . $userDetails['qualification'] . '</p>';
            echo '<p>Skills: ' . $userDetails['skills'] . '</p>';
            echo '<p>City: ' . $userDetails['city'] . '</p>';
            echo '<p>State: ' . $userDetails['state'] . '</p>';
            echo '</div>';
            echo '<div class="main-content">';
            echo '<h2>Resume</h2>';
            echo '<a href="download_resume.php?id_user=' . $id_user . '" target="_blank">Download Resume</a>';
            echo '</div>';
            echo '</div>';
        }
    }
} else {
    // Display a message if no one has applied
    echo '<div class="content">';
    echo '<p>No one has applied for the job yet.</p>';
    echo '</div>';
}

$conn->close();
?>


    
</div>


</body>
</html>
