<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .signup-container {
            margin:0 auto;
            width: 60%;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
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
    <a href="index.php"> Job Portal</a>
</div>
 <a href="">Sign up </a>
</div>

<h1>Sign Up</h1>

<div class="signup-container">
    <a href="create_jobseeker_account/jobseeker_signup.php">
    <div class="container">
        <h2>User Registration</h2>
        <button>Register</button>
    </div>
    </a>
       <a href="create_company/company_signup.php">
    <div class="container">
        <h2>Company Registration</h2>
        <button>Register</button>
    </div>
    </a>
</div>

</body>
</html>
