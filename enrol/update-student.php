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
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $home_address = $_POST['home_address'];
        $present_address = $_POST['present_address'];
        $contact = $_POST['contact'];
        $sex = $_POST['sex'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];
        $place_of_birth = $_POST['place_of_birth'];
        $civil_status = $_POST['civil_status'];
        $elementary = $_POST['elementary'];
        $elementary_year_graduated = $_POST['elementary_year_graduated'];
        $high_school = $_POST['high_school'];
        $high_school_year_graduated = $_POST['high_school_year_graduated'];
        $shs = $_POST['shs'];
        $shs_year_graduated = $_POST['shs_year_graduated'];
        $track_and_strand = $_POST['track_and_strand'];
        $complete_name = $_POST['complete_name'];
        $date_signed = $_POST['date_signed'];
        $course_to_be_enrolled = $_POST['course_to_be_enrolled'];
    // Add more fields as needed

    // Prepare SQL update statement
    $sql = "UPDATE students SET 
            last_name = '$last_name', 
            first_name = '$first_name', 
            middle_name = '$middle_name',

            
     home_address = '$home_address', 
     present_address= '$present_address', 
     contact= '$contact', 
     sex= '$sex', 
     date_of_birth= '$date_of_birth', 
     email= '$email', 
     place_of_birth= '$place_of_birth', 
     civil_status= '$civil_status', 
     elementary= '$elementary', 
    elementary_year_graduated= '$elementary_year_graduated', 
    high_school= '$high_school', 
    high_school_year_graduated= '$high_school_year_graduated', 
    shs= '$shs', 
    shs_year_graduated= '$shs_year_graduated', 
    track_and_strand= '$track_and_strand', 
    complete_name= '$complete_name', 
    date_signed= '$date_signed', 
    course_to_be_enrolled= '$course_to_be_enrolled'
            -- Add more fields here
            WHERE application_no = '$application_no'";

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
                                window.location.href = "students.php";
                            }
                        });
                    };
                  </script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
