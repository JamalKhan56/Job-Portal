<?php
// Start the session
session_start();

// Include your database configuration file
include '../config.php';

// Function to sanitize input data
function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Retrieve job details and id_user from the session
$jobDetails = isset($_SESSION['job_details']) ? $_SESSION['job_details'] : null;
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

// Retrieve values from URL parameters
$id_jobpost = isset($_GET['id_jobpost']) ? sanitizeInput($_GET['id_jobpost']) : null;
$id_company = isset($_GET['id_company']) ? sanitizeInput($_GET['id_company']) : null;

// Handle Apply button click
if ($jobDetails !== null && $id_user !== null && $id_jobpost !== null && $id_company !== null && isset($_POST['apply'])) {
    // Insert data into apply_job_post table
    $applyQuery = "INSERT INTO apply_job_post (id_user, id_jobpost, id_company) VALUES ('$id_user', '$id_jobpost', '$id_company')";
    $applyResult = mysqli_query($conn, $applyQuery);

    if ($applyResult) {
        echo '<p class="success-message">Application submitted successfully!</p>';
    } else {
        echo '<p class="error-message">Error submitting application</p>';
    }
}

// Display job details
if ($jobDetails !== null && $id_user !== null && $id_jobpost !== null && $id_company !== null) {
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Single Job</title>';
    echo '<style>';
    echo 'body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        width: 80%;
        margin: 0 auto;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 10px 0;
    }

    .job-title {
        color: #333;
    }

    .job-details-container {
        margin-top: 20px;
    }

    .job-details p {
        margin: 0;
        font-size: 16px;
        color: #555;
    }

    .company-logo {
        width: 300px;
        height: 200px;
        margin-right: 10px;
    }

    .job-info-container {
        background-color: #fff;
        padding: 20px;
        margin-top: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .job-info h2 {
        color: #333;
        font-size: 24px;
    }

    .job-info p {
        margin: 10px 0;
        font-size: 16px;
        color: #555;
    }

    .apply-form {
        margin-top: 20px;
    }

    .apply-button {
        background-color: #007bff;
        color: #fff;
        padding: 12px 24px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .apply-button:hover {
        background-color: #0056b3;
    }

    .success-message {
        color: #28a745;
    }

    .error-message {
        color: #dc3545;
    }
    
.navbar {
    background-color: #2a712a;
    overflow: hidden;
    color: white;
}

.navbar a {
    float: right;
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.navbar a:hover {
    background-color: #ddd;
    color: black;
}

.navbar div {
    margin: 0;
    
    display: inline-block;
}
    ';
    echo '</style>';
    echo '</head>';
    echo '<body>';

    // Include navigation bar
    echo'<div class="navbar">
    <div>
    <a href> Job Portal</a>
    </div>
    <a href="logout.php">logout</a>
</div>';

    // Retrieve job details from the job_post table
    $jobQuery = "SELECT jobtitle, city, createdat FROM job_post WHERE id_jobpost = '$id_jobpost'";
    $jobResult = mysqli_query($conn, $jobQuery);

    if ($jobResult && mysqli_num_rows($jobResult) > 0) {
        $jobDetails = mysqli_fetch_assoc($jobResult);

        // Output job details
        echo '<h1 class="job-title">' . $jobDetails['jobtitle'] . '</h1>';
        echo '<div class="job-details-container">';
        echo '<p>City: ' . $jobDetails['city'] . '</p>';
        echo '<p>Date: ' . $jobDetails['createdat'] . '</p>';
        echo '</div>';
    }

    // Retrieve company information from the company table
    $companyQuery = "SELECT companyname FROM company WHERE id_company = '$id_company'";
    $companyResult = mysqli_query($conn, $companyQuery);

    if ($companyResult && mysqli_num_rows($companyResult) > 0) {
        $companyDetails = mysqli_fetch_assoc($companyResult);

        // Output company information
        echo '<img src="../images/logoimg.jpg" alt="' . $companyDetails['companyname'] . '" class="company-logo">';
        echo '<p>Company: ' . $companyDetails['companyname'] . '</p>';
    }

    // Add Apply button
    echo '<div class="apply-form">';
    echo '<form method="post">';
    echo '<input type="submit" name="apply" value="Apply" class="apply-button">';
    echo '</form>';
    echo '</div>';

    // Other content for single job page can go here

    echo '</body>';
    echo '</html>';
} else {
    echo '<p class="error-message">Job details or user ID not found</p>';
}

// Close the database connection
mysqli_close($conn);
?>
