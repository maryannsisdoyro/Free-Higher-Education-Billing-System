<?php
// Include database connection
include 'db.php';

// Update all student statuses to 'Unread'
$updateQuery = "UPDATE students SET status = 'Read'";

// Execute the update query
if (mysqli_query($conn, $updateQuery)) {
    echo "Status updated successfully.";
} else {
    echo "Error updating status: " . mysqli_error($conn);
}

// Close database connection
$conn->close();
?>
