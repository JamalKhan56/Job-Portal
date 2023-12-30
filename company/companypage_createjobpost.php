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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data when the form is submitted

    $jobTitle = mysqli_real_escape_string($conn, $_POST["jobTitle"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $minSalary = mysqli_real_escape_string($conn, $_POST["minSalary"]);
    $maxSalary = mysqli_real_escape_string($conn, $_POST["maxSalary"]);
    $experience = mysqli_real_escape_string($conn, $_POST["experience"]);
    $qualification = mysqli_real_escape_string($conn, $_POST["qualification"]);

    // Insert data into the database
    $sql = "INSERT INTO job_post (jobtitle, description, minimumsalary, maximumsalary, experience, qualification, id_company) 
            VALUES ('$jobTitle', '$description', '$minSalary', '$maxSalary', '$experience', '$qualification', '$id_company')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Job post created successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Close the database connection
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
.my-company {
            margin-top: 20px;
        }

        .my-company-heading {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .my-company-text {
            color: #555;
            margin-bottom: 20px;
        }

        .my-company-form {
            margin-top: 20px;
        }

        .my-company-form label {
            display: block;
            margin-top: 10px;
        }

        .my-company-form input,
        .my-company-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .my-company-form input[type="file"] {
            margin-bottom: 20px;
        }

        .my-company-logo {
            margin-top: 20px;
        }

        .my-company-logo img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }

        .update-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .update-button:hover {
            background-color: #45a049;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
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
    <a href="companypage_logout.php">Logout</a></nav>

<div class="content">
    <h1>Create Job Post </h1>

    <!-- Job Post Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="jobTitle">Job Title:</label>
        <input type="text" id="jobTitle" name="jobTitle" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="minSalary">Minimum Salary:</label>
        <input type="text" id="minSalary" name="minSalary" required>

        <label for="maxSalary">Maximum Salary:</label>
        <input type="text" id="maxSalary" name="maxSalary" required>

        <label for="experience">Experience (in years):</label>
        <input type="text" id="experience" name="experience" required>

        <label for="qualification">Qualification:</label>
        <input type="text" id="qualification" name="qualification" required>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
