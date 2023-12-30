<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: green;
            color: #fff;
            padding: 5px;
            text-align: center;
            height: 70px;
        }

       
     

       

        section {
            display: flex;
            flex-wrap: wrap;
        }

        .sidebar {
            width: 30%;
            background-color: #333;
            color: #fff;
           text-align:center;
            box-sizing: border-box;
            height:auto;
        }

        .content {
            width: 70%;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #fff;
            display: block; /* Make links display as block to stack vertically */
        }

        a:hover {
            
        }
        .content {
    background-color: gray;
}

.row-container {
    display: flex;
    flex-wrap: wrap; /* Allow containers to wrap to the next line */
    margin: -10px; /* Adjust for the padding on the containers */
}

.container {
    display: flex;
    align-items: center;
    padding: 10px;
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
<?php

include('../config.php');


$sqlCompany = "SELECT COUNT(*) AS companyCount FROM company";
$resultCompany = mysqli_query($conn, $sqlCompany);


$sqlUsers = "SELECT COUNT(*) AS userCount FROM users";
$resultUsers = mysqli_query($conn, $sqlUsers);

$sqlJobs = "SELECT COUNT(*) AS jobCount FROM job_post";
$resultJobs = mysqli_query($conn, $sqlJobs);

if ($resultCompany && $resultUsers) {
    $rowCompany = mysqli_fetch_assoc($resultCompany);
    $rowUsers = mysqli_fetch_assoc($resultUsers);
    $rowJobs= mysqli_fetch_assoc($resultJobs);

    $companyCount = $rowCompany['companyCount'];
    $userCount = $rowUsers['userCount'];
    $jobCount = $rowJobs['jobCount'];

} else {
   
    $companyCount = 0;
    $userCount = 0;
    $jobCount =0;
}


mysqli_close($conn);
?>



<header>
    <h1>Job Portal</h1>
</header>


<section>
    <div class="sidebar">
        <p>Welcome Admin</p>
        <ul>
            <li><a href="adminpage.php">Dashboard</a></li>
            <li><a href="adminpage_activejob.php">Active Jobs</a></li>
            <li><a href="adminpage_applicants.php">Applicants</a></li>
            <li><a href="adminpage_companies.php">Companies</a></li>
            <li><a href="adminpage_logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
    <!-- Content for the selected section will go here -->
    <h2>Dashboard</h2>
    <div class="row-container">
        <div class="container">
            <img src="../images/logoimg.jpg"> <p>ACTIVE JOBS REGISTERED <br> <span><?php echo $companyCount; ?></span></p>
        </div>
        <div class="container">
            <img src="../images/logoimg.jpg"> <p>PENDING COMPANY APPROVAL <br> <span>1</span></p>
        </div>
    </div>
    <div class="row-container">
        <div class="container">
            <img src="../images/logoimg.jpg"> <p>REGISTERED CANDIDATES <br> <span><?php echo $userCount; ?></span></p>
        </div>
        <div class="container">
            <img src="../images/logoimg.jpg"> <p>REGISTERED CANDIDATES CONFIRMATION<br> <span>1</span></p>
        </div>
    </div>
    <div class="row-container">
        <div class="container">
            <img src="../images/logoimg.jpg"> <p>TOTAL JOB POSTS <br> <span><?php echo $jobCount; ?></span></p>
        </div>
        <div class="container">
            <img src="../images/logoimg.jpg"> <p>TOTAL APPLICATIONS <br> <span>1</span></p>
        </div>
    </div>
</div>

</section>











</body>
</html>
