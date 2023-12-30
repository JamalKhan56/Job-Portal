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
        .content{
        background-color: gray;

        }
        .section2{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            
        }

        .candidate-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            margin-right: 20px;
            padding: 15px;
            width: 45%; /* Adjust based on your preference */
            box-sizing: border-box;
        }

        .candidate-item h3 {
            color: #333;
        }

        .candidate-item p {
            margin: 8px 0;
            color: #666;
        }

        .status-activated {
            color: #28a745;
        }

        .status-rejected {
            color: #dc3545;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 9999;
        }

        .modal-content {
            text-align: center;
        }

        .modal-close {
            cursor: pointer;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <h1>Job Portal</h1>
</header>


<section class="section2">
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
        <h2>Applicants</h2>
        <section>
        <?php
            // Include the database configuration file
            include('../config.php');

            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the delete button is clicked
                if (isset($_POST['delete_candidate'])) {
                    $candidateId = $_POST['id_user'];

                    // Perform the deletion in the database
                    $deleteSql = "DELETE FROM users WHERE id_user = '$candidateId'";
                    $deleteResult = mysqli_query($conn, $deleteSql);

                    // Display the modal based on the deletion result
                    echo "<div id='myModal' class='modal' style='display: block;'>";
                    echo "<div class='modal-content'>";

                    if ($deleteResult) {
                        echo "<p class='success-message'>Candidate deleted successfully!</p>";
                    } else {
                        echo "<p class='error-message'>Error deleting the candidate. Please try again later.</p>";
                    }

                    echo "<span class='modal-close' onclick='closeModal()'>&times;</span>";
                    echo "</div></div>";
                }
            }

            // Query to fetch data from the candidates table
            $sql = "SELECT id_user, CONCAT(firstname, ' ', lastname) AS candidate, qualification, stream, contactno, city, resume, active 
                    FROM users";

            $result = mysqli_query($conn, $sql);

            // Check if the query was successful
            if ($result) {
                // Loop through the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display each candidate item
                    echo "<div class='candidate-item'>";
                    echo "<h3>{$row['candidate']}</h3>";
                    echo "<p>Highest Qualification: {$row['qualification']}</p>";
                    echo "<p>Skills: {$row['stream']}</p>";
                    echo "<p>Phone: {$row['contactno']}</p>";
                    echo "<p>City: {$row['city']}</p>";

                    // Display download resume link
                    echo "<p>Download Resume: <a href='{$row['resume']}' target='_blank'>Download</a></p>";

                    // Determine and display the status
                    if ($row['active'] == 1) {
                        echo "<p>Status: <span class='status-activated'>Activated</span></p>";
                    } else {
                        echo "<p>Status: <span class='status-rejected'>Rejected</span></p>";
                    }

                    // Add a form around the delete button
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id_user' value='{$row['id_user']}'>";
                    echo "<button type='submit' name='delete_candidate' class='delete-button'>Delete</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                // Handle the error, if any
                echo "Error: " . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
</section>

    </div>
</section>







<script>
    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }
</script>

</body>
</html>
