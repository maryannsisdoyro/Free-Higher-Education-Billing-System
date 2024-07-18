<?php
// Include database connection
include 'db.php';

// Check if form is submitted with GET method
if (isset($_GET['application_no'])) {
    // Sanitize the application_no
    $application_no = mysqli_real_escape_string($conn, $_GET['application_no']);
       
    $updateQuery = "UPDATE students SET status = 'Read' WHERE application_no = '$application_no'";

    // Execute the update query
    if (mysqli_query($conn, $updateQuery)) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }

    // Close database connection
    $conn->close();
} else {
    echo "No application number provided.";
}
?>
