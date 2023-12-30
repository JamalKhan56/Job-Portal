<?php
// companypage_mycompany.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['id_company'])) {
    header("Location: ../company_signin.php");
    exit();
}

// Include your database configuration file
include '../config.php';

// Access information from the session variables
$id_company = $_SESSION['id_company'];

// Fetch company details from the database
$sql = "SELECT * FROM company WHERE id_company = '$id_company'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the details of the logged-in company
    $companyDetails = $result->fetch_assoc();
} else {
    // Handle the case where company details are not found
    echo "Company details not found.";
    exit();
}

// Close the database connection


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $companyName = $_POST['companyName'];
    $contactNumber = $_POST['contactNumber'];
    $website = $_POST['website'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $state = $_POST['state'];
    $aboutMe = $_POST['aboutMe'];

    // Handle logo upload
    $logoPath = $_POST['../create_company/']; // Default logo path

    if ($_FILES['logo']['name']) {
        $uploadDir = '../create_company/';
        $uploadFile = $uploadDir . basename($_FILES['logo']['name']);
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
            $logoPath = $_FILES['logo']['name'];
        }
    }

    // Update company profile in the database
    $sql = "UPDATE company SET 
            companyname = '$companyName', 
            contactno = '$contactNumber',
            website = '$website',
            city = '$city',
            email = '$email',
            state = '$state',
            aboutme = '$aboutMe',
            logo = '$logoPath'
            WHERE id_company = '$id_company'";
    
    // Debugging: Print the SQL query
    echo "SQL Query: $sql<br>";

    // Execute the update query
    // ... (Previous code)

// Execute the update query
if ($conn->query($sql) === TRUE) {
    // Debugging: Print a success message
    echo "Record updated successfully<br>";

    // Redirect to the dashboard or any other page after successful update
    header("Location: companypage.php");
    exit();
} else {
    // Handle the case where the update fails
    echo "Error updating record: " . $conn->error;
    // Add additional debugging information
    echo "<br>SQL Query: $sql";
}
$conn->close();

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
<div class="my-company">
        <h2 class="my-company-heading">My Company</h2>
        <p class="my-company-text">In this section, you can change your company details.</p>

        <form class="my-company-form" action="" method="post" enctype="multipart/form-data">
            <!-- Add input fields for contact number, website, city, email, state, and about me -->
            <label for="companyName">Company Name:</label>
            <input type="text" id="companyName" name="companyName" value="<?php echo $companyDetails['companyname']; ?>" required>

            <label for="contactNumber">Contact Number:</label>
            <input type="text" id="contactNumber" name="contactNumber" value="<?php echo $companyDetails['contactno']; ?>" required>

            <label for="website">Website:</label>
            <input type="text" id="website" name="website" value="<?php echo $companyDetails['website']; ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $companyDetails['city']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $companyDetails['email']; ?>" required>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo $companyDetails['state']; ?>" required>

            <label for="aboutMe">About Me:</label>
            <textarea id="aboutMe" name="aboutMe" rows="4" required><?php echo $companyDetails['aboutme']; ?></textarea>

            <label for="logo">Change Company Logo:</label>
            <input type="file" id="logo" name="logo">
            <div class="my-company-logo">
                <img src="../create_company/<?php echo $companyDetails['logo']; ?>" alt="Company Logo">
            </div>

            <button type="submit" class="update-button">Update Company Profile</button>
        </form>
    </div>
    
</div>


</body>
</html>
