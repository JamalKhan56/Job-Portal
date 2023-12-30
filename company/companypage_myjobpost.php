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

// Fetch all job posts created by the company
$jobPostsSql = "SELECT * FROM job_post WHERE id_company = '$id_company'";
$jobPostsResult = $conn->query($jobPostsSql);
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


        .job-posts {
            margin-top: 20px;
        }

        .job-posts table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .job-posts th, .job-posts td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .job-posts th {
            background-color: #333;
            color: #fff;
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
  
    <div class="job-posts">
        <h2>My Job Posts</h2>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $jobPostsResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['jobtitle']}</td>";
                    echo "<td><a href='#'>View</a></td>"; // Add the link as needed
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<?php
$conn->close();
?>

</body>
</html>
