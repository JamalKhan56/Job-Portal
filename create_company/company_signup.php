<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data when the form is submitted

    $fullName = mysqli_real_escape_string($conn, $_POST["fullName"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirmPassword"]);
    $companyName = mysqli_real_escape_string($conn, $_POST["companyName"]);
    $website = mysqli_real_escape_string($conn, $_POST["website"]);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST["phoneNumber"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
    $aboutCompany = mysqli_real_escape_string($conn, $_POST["aboutCompany"]);

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Password and Confirm Password do not match');</script>";
    } else {
        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // File upload handling
        $targetDirectory = "./"; // Updated target directory
        $targetFile = $targetDirectory . basename($_FILES["logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is an actual image or fake image
        if (isset($_POST["register"])) {
            $check = getimagesize($_FILES["logo"]["tmp_name"]);
            if ($check === false) {
                echo "<script>alert('File is not an image.');</script>";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "<script>alert('Sorry, file already exists.');</script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["logo"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('Sorry, your file was not uploaded.');</script>";
        } else {
            // If everything is OK, try to upload file
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFile)) {
                // Insert data into the database
                $sql = "INSERT INTO company (name, password, companyname, website, contactno, email, country, aboutme, logo) 
                VALUES ('$fullName', '$hashedPassword', '$companyName', '$website', '$phoneNumber', '$email', '$country', '$aboutCompany', '$targetFile')";
        
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Company profile created successfully.');</script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Company Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            margin: 20px;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            color: #555;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        input[type="file"] {
            width: calc(100% - 22px);
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1>Create Company Profile</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <label for="fullName">Full Name:</label>
    <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>

    <label for="companyName">Company Name:</label>
    <input type="text" id="companyName" name="companyName" placeholder="Enter your company name" required>

    <label for="website">Website:</label>
    <input type="text" id="website" name="website" placeholder="Enter your website" required>

    <label for="phoneNumber">Phone Number:</label>
    <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country" placeholder="Enter your country" required>

    <label for="aboutCompany">Brief Info about Your Company:</label>
    <textarea id="aboutCompany" name="aboutCompany" placeholder="Write a brief description about your company" required></textarea>

    <label for="logo">Attach Company Logo:</label>
    <input type="file" id="logo" name="logo" accept="image/*" required>

    <button type="submit" name="register">Register</button>
</form>

</body>
</html>
