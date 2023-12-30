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
<html>
<head>
    <title>Latest Jobs</title>
    <style>
       body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
    width: 80%;
    margin: 0 auto;
    text-align: center;
}

h1 {
    color: #333;
    margin-top: 20px;
}

.job-container {
    background-color: #fff;
    border: 1px solid #ddd;
    margin-top: 20px;
    padding: 10px;
    display: flex;
    align-items: center;
}

.job-image {
    width: 80px;
    height: 80px;
    margin-right: 10px;
}

.job-details {
    flex: 1;
}

.job-details p {
    margin: 0;
    font-size: 14px;
    color: #555;
}

.salary {
    color: #27ae60;
    font-weight: bold;
    margin-left: auto;
}

.pagination {
    margin-top: 20px;
}

.pagination a {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 4px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #555;
    border-radius: 5px;
}

.pagination a:hover {
    background-color: #ddd;
}

.pagination .active {
    background-color: #4CAF50;
    color: white;
}

.search-container {
    margin-top: 20px;
    text-align: center;
}

.search-form {
    display: flex;
    justify-content: center;
    align-items: center;
}

.search-input {
    width: 300px;
    padding: 8px;
    margin-right: 10px;
}

.search-checkboxes {
    margin-right: 10px;
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

    </style>
</head>
<body>

<div class="navbar">
    <div>
    <a href> Job Portal</a>
    </div>
    <a href="logout.php">logout</a>
</div>

<div class="container">
    <h1>Latest Jobs</h1>

    <!-- Search form -->
    <div class="search-container">
        <form class="search-form" action="" method="GET">
            <input type="text" name="query" class="search-input" placeholder="Search...">
            <input type="text" name="city" class="search-input" placeholder="Enter City...">
            <div class="search-checkboxes">
                <label><input type="checkbox" name="experience[]" value="1"> 1 Year</label>
                <label><input type="checkbox" name="experience[]" value="2"> 2 Years</label>
                <label><input type="checkbox" name="experience[]" value="3"> 3 Years</label>
                <label><input type="checkbox" name="experience[]" value="4"> 4 Years</label>
                <label><input type="checkbox" name="experience[]" value="5"> 5 Years</label>
            </div>
            <button type="submit">Search</button>
        </form>
    </div>


    <!-- Display jobs based on search criteria -->
    <?php
    include '../config.php';

    // Process search and filter parameters
    $searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
    $cityFilter = isset($_GET['city']) ? $_GET['city'] : '';
    $experienceFilter = isset($_GET['experience']) ? $_GET['experience'] : array();

    // Define the number of jobs per page
    $jobsPerPage = 5;

    // Get the current page number from the query string, default to 1
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Calculate the offset for the SQL query
    $offset = ($currentPage - 1) * $jobsPerPage;

    // Build SQL query based on search and filter parameters
    $sql = "SELECT jobtitle, id_jobpost, id_company, description, city, createdat, experience, minimumsalary FROM job_post";

    // Build the WHERE clause based on filters
    $whereClause = [];

    // Add WHERE clause for search query
    if (!empty($searchQuery)) {
        $whereClause[] = "jobtitle LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
    }

    // Add WHERE clause for city filter
    if (!empty($cityFilter)) {
        $whereClause[] = "city LIKE '%$cityFilter%'";
    }

    // Add WHERE clause for experience filter
    if (!empty($experienceFilter)) {
        $experienceFilter = implode("','", $experienceFilter);
        $whereClause[] = "experience IN ('$experienceFilter')";
    }

    // Append WHERE clause to the SQL query if filters are present
    if (!empty($whereClause)) {
        $sql .= " WHERE " . implode(" AND ", $whereClause);
    }

    // Add LIMIT and OFFSET for pagination
    $sql .= " LIMIT $jobsPerPage OFFSET $offset";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Display job results
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Display job containers as before
                echo '<a href="single_job.php?id_jobpost=' . $row['id_jobpost'] . '&id_company=' . $row['id_company'] . '">';
                echo '<div class="job-container">';

                // Add a link to single_job.php with job details in the session
                $_SESSION['job_details'] = $row;

                echo '<img src="../images/logoimg.jpg" alt="Job Image" class="job-image">';
                echo '<div class="job-details">';
                echo '<p>' . $row['jobtitle'] . ', ' . $row['description'] . '</p>';
                echo '<p>' . $row['createdat'] . ' | ' . $row['city'] . ' | Experience ' . $row['experience'] . ' years</p>';
                echo '</div>';
                echo '<div class="salary">RS. ' . $row['minimumsalary'] . '/month</div>';

                // Close the link
                echo '</div>';
                echo '</a>';
            }
            $totalJobsQuery = "SELECT COUNT(*) as total FROM job_post";
            $totalJobsResult = mysqli_query($conn, $totalJobsQuery);
            $totalJobs = mysqli_fetch_assoc($totalJobsResult)['total'];
            $totalPages = ceil($totalJobs / $jobsPerPage);

            echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            // Include search parameters in pagination links
            $queryString = '?page=' . $i;
            if (!empty($searchQuery)) {
                $queryString .= '&query=' . urlencode($searchQuery);
            }
            if (!empty($cityFilter)) {
                $queryString .= '&city=' . urlencode($cityFilter);
            }
            if (!empty($experienceFilter)) {
                $queryString .= '&experience[]=' . implode('&experience[]=', (array)$experienceFilter);
            }

            echo '<a href="' . $queryString . '">' . $i . '</a>';
        }
        echo '</div>';
        } else {
            echo '<p>No jobs found</p>';
        }
    } else {
        // Handle query execution error
        echo 'Error executing the query: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

</div>

</body>
</html>
