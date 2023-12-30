<?php
include '../config.php';

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = sanitizeInput($_POST["firstname"]);
    $lastname = sanitizeInput($_POST["lastname"]);
    $email = sanitizeInput($_POST["email"]);
    $aboutme = sanitizeInput($_POST["aboutme"]);
    $dob = sanitizeInput($_POST["dob"]);
    $age = sanitizeInput($_POST["age"]);
    $passingyear = sanitizeInput($_POST["passingyear"]);
    $qualification = sanitizeInput($_POST["qualification"]);

    // Base64 encode the password
    $base64EncodedPassword = base64_encode($_POST["password"]);
    $password = password_hash($base64EncodedPassword, PASSWORD_DEFAULT);

    $contactno = sanitizeInput($_POST["contactno"]);
    $address = sanitizeInput($_POST["address"]);
    $city = sanitizeInput($_POST["city"]);
    $state = sanitizeInput($_POST["state"]);
    $skills = sanitizeInput($_POST["skills"]);
    $designation = sanitizeInput($_POST["designation"]);

    // Upload Resume
    $resumeFileName = $_FILES["resume"]["name"];
    $resumeTmpName = $_FILES["resume"]["tmp_name"];
    $resumeDestination = "resume_uploads/" . $resumeFileName;
    move_uploaded_file($resumeTmpName, $resumeDestination);

    $sql = "INSERT INTO users (firstname, lastname, email, aboutme, dob, age, passingyear, qualification, password, contactno, address, city, state, skills, designation, resume) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssisssssssss", $firstname, $lastname, $email, $aboutme, $dob, $age, $passingyear, $qualification, $password, $contactno, $address, $city, $state, $skills, $designation, $resumeDestination);

    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: calc(50% - 10px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .form-group input[type="file"],
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .form-group textarea {
            width: calc(100% - 20px);
            margin-right: 0;
        }

        .form-group input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Your Profile</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
            <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
        </div>

        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <textarea id="aboutme" name="aboutme" placeholder="Brief Intro About Yourself"></textarea>
        </div>

        <div class="form-group">
            <input type="date" id="dob" name="dob" required>
            <input type="number" id="age" name="age" placeholder="Age" required>
        </div>

        <div class="form-group">
            <input type="number" id="passingyear" name="passingyear" placeholder="Passing Year" required>
            <input type="text" id="qualification" name="qualification" placeholder="Highest Qualification" required>
        </div>

        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
        </div>

        <div class="form-group">
            <input type="tel" id="contactno" name="contactno" placeholder="Phone Number" required>
        </div>

        <div class="form-group">
            <textarea id="address" name="address" placeholder="Address"></textarea>
        </div>

        <div class="form-group">
            <input type="text" id="city" name="city" placeholder="City" required>
            <input type="text" id="state" name="state" placeholder="State" required>
        </div>

        <div class="form-group">
            <textarea id="skills" name="skills" placeholder="Enter Skills"></textarea>
        </div>

        <div class="form-group">
            <input type="text" id="designation" name="designation" placeholder="Designation">
        </div>

        <div class="form-group">
            <input type="file" id="resume" name="resume" accept=".pdf" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>

</body>
</html>
