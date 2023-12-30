<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-top: 20px;
            padding: 10px;
            height: 80px;
        }

        .job-image {
            width: 80px;
            height: 80px;
            margin-right: 10px;
        }

        .job-details {
            flex: 1;
            text-align: left;
        }

        .job-details p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .salary {
            color: #27ae60;
            font-weight: bold;
        }
        /* Add this CSS to your stylesheet or within a <style> tag in your HTML */

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

    </style>
</head>
<body>
<div class="container" id="section1">
    <h1>Latest Jobs</h1>

    <?php
        include 'config.php';

        // Define the number of jobs per page
        $jobsPerPage = 5;

        // Get the current page number from the query string, default to 1
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate the offset for the SQL query
        $offset = ($currentPage - 1) * $jobsPerPage;

        // Fetch data from the "job post" table with pagination
        $query = "SELECT jobtitle, description,city,createdat,experience, minimumsalary FROM job_post LIMIT $jobsPerPage OFFSET $offset";
        $result = mysqli_query($conn, $query);

        // Check if there are any rows in the result
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row in the result
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="job-container">';
                echo '<img src="./images/logoimg.jpg" alt="Job Image" class="job-image">';
                echo '<div class="job-details">';
                echo '<p>' . $row['jobtitle'] . ', ' . $row['description'] . '</p>';
                echo '<p>' . $row['createdat'] . ' | '.$row['city'].' | Experience '.$row['experience'] .' years</p>';
                echo '</div>';
                echo '<div class="salary">RS. ' . $row['minimumsalary'] . '/month</div>';
                echo '</div>';
            }

            // Add pagination links
            $totalJobsQuery = "SELECT COUNT(*) as total FROM job_post";
            $totalJobsResult = mysqli_query($conn, $totalJobsQuery);
            $totalJobs = mysqli_fetch_assoc($totalJobsResult)['total'];
            $totalPages = ceil($totalJobs / $jobsPerPage);

            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
        } else {
            echo '<p>No jobs found</p>';
        }

        // Close the database connection
        mysqli_close($conn);
    ?>

</div>

</body>
</html>
