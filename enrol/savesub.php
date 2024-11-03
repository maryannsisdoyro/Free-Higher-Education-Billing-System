<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
<script src="sweetalerts/sweetalert2@11.js"></script>
<?php

include 'db.php';
date_default_timezone_set('Asia/Manila'); // change according timezone

function sanitize_input($data) {
   
    $data = strip_tags(trim($data));
 
    $data = htmlspecialchars($data);
    return $data;
}
    $Semester = mysqli_real_escape_string($conn, $_POST['Semester']);
    $Year = mysqli_real_escape_string($conn, $_POST['Year']);
    $Course = mysqli_real_escape_string($conn, $_POST['Course']);
    $Time = mysqli_real_escape_string($conn, $_POST['Time']);
    $Day = mysqli_real_escape_string($conn, $_POST['Day']);
    $Subjectcode = mysqli_real_escape_string($conn, $_POST['Subjectcode']);
    $Subjectdes = mysqli_real_escape_string($conn, $_POST['Subjectdes']);
    $Prerequi = mysqli_real_escape_string($conn, $_POST['Prerequi']);
    $Units = mysqli_real_escape_string($conn, $_POST['Units']);
    $Room = mysqli_real_escape_string($conn, $_POST['Room']);
    $Instructor = mysqli_real_escape_string($conn, $_POST['Instructor']);
    // Check if the SUBJECT with the same time, day, subjectcode already exists

    $check_query = "SELECT * FROM subject WHERE tbl_time = '$Time' AND tbl_day = '$Day' AND course = '$Course' AND subjectcode = '$Subjectcode'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // If the subject exists, display an error message using SweetAlert
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Error!",
                    text: "A Time, Day and Subjectcode already exists.",
                    icon: "error"
                 }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "subject.php";
                        }
                });
            };
          </script>';
    } else {
        // Insert new subject data into the database
        $insert_query = "INSERT INTO `subject`(`sem`, `year`, `course`, `tbl_time`, `tbl_day`, `subjectcode`, `subdes`, `prerequi`, `units`, `room`, `inst`)
                         VALUES ('$Semester', '$Year', '$Course', '$Time', '$Day', '$Subjectcode', '$Subjectdes', '$Prerequi', '$Units', '$Room', '$Instructor')";
        
        $insert_result = mysqli_query($conn, $insert_query);
        
        if ($insert_result) {
            // If insertion is successful, show success message using SweetAlert and redirect
            echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Subject Data Successfully Created !!",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "subject.php";
                        }
                    });
                };
              </script>';
        } else {
            // If insertion fails, show error message using SweetAlert and display SQL error
            echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error occurred while creating subject.",
                        icon: "error"
                    });
                };
              </script>';
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    }

?>