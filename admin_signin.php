<?php
include './config.php';

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px; /* Adjusted margin for better alignment */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data when the form is submitted

    $entered_username = sanitizeInput($_POST["username"]);
    $entered_password = sanitizeInput($_POST["password"]);

    // Validate the input (you may add more validation)

    // Hash the password (you should use a more secure method in a real-world scenario)
    $hashed_password = $entered_password;

    // Check the database for the username and hashed password
    $sql = "SELECT * FROM admin WHERE username='$entered_username' AND password='$hashed_password'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Login successful
        echo "Login successful!";
        
        // Redirect to adminpage.php or perform other actions as needed
        header("Location: admin/adminpage.php");
        exit();
    } else {
        // Login failed
        echo "Invalid username or password";
    }
}
?>

<h2>Admin Login</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Login">
</form>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
