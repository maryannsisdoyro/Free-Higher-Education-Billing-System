<!-- update-student.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
<script src="sweetalerts/sweetalert2@11.js"></script>

<?php
// Include database connection
include 'db.php';

// Check if form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data (you should add more validation as per your application's requirements)
    $application_no = $_POST['application_no'];
        $sex = $_POST['sex'];
    // Add more fields as needed

    // Prepare SQL update statement
    $sql = "UPDATE enroll2024 SET 
     gender= '$sex' WHERE application_no = '$application_no'";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: "College Application Form Successfully Updated!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "../index.php?page=college-application";
                            }
                        });
                    };
                  </script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close database connection
?>
