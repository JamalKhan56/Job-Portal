<?php
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Fetch the resume file path from the database based on the id_user
    // Assuming your resume file path is stored in a column named 'resume_path'
    include '../config.php';
    $sqlResumePath = "SELECT resume_path FROM users WHERE id_user = '$id_user'";
    $resultResumePath = $conn->query($sqlResumePath);

    if ($resultResumePath && $resultResumePath->num_rows > 0) {
        $resumePath = $resultResumePath->fetch_assoc()['resume_path'];

        // Set appropriate headers for a download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="resume.pdf"'); // You may adjust the filename extension

        // Read and output the file content
        readfile($resumePath);
    } else {
        // Handle error (resume not found)
        echo 'Resume not found.';
    }

    $conn->close();
} else {
    // Handle error (id_user not provided)
    echo 'Invalid request.';
}
?>
