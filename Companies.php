<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
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

        p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .candidate-container {
            display: inline-block; /* Display containers inline */
            vertical-align: top; /* Align containers at the top */
            background-color: #fff;
            border: 1px solid #ddd;
            margin-top: 20px;
            padding: 20px;
            width: 30%; /* Set a specific width for each container */
            box-sizing: border-box; /* Include padding and border in the width calculation */
        }

        .candidate-image {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px;
        }

        .browse-text {
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container" id="section2">
    <h1>Companies</h1>
    <p>This is some introductory text about candidates.</p>

    <div class="candidate-container">
        <img src="./images/logoimg.jpg" alt="Candidate Image" class="candidate-image">
        <p class="browse-text">Post A Job</p>
    </div>

    <div class="candidate-container">
        <img src="./images/logoimg.jpg" alt="Candidate Image" class="candidate-image">
        <p class="browse-text">Manage And Track</p>
    </div>

    <div class="candidate-container">
        <img src="./images/logoimg.jpg" alt="Candidate Image" class="candidate-image">
        <p class="browse-text">Hire</p>
    </div>
</div>

</body>
</html>
