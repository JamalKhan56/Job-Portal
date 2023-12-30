<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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
    <script>
        // JavaScript for smooth scrolling
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</head>
<body>

<div class="navbar">
    <div>
    <a href="index.php"> Job Portal</a>
    </div>
    
    <a href="#section1">Jobs</a>
    <a href="#section3">Candidates</a>
    <a href="#section2">Company</a>
    <a href="Aboutus.php">About Us</a>
    <a href="login.php">Login</a>
    <a href="signup.php">Signup</a>
</div>



</body>
</html>
