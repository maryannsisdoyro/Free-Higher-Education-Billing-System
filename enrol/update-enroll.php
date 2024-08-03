<script src="sweetalerts/sweetalert2@11.js"></script>
<?php
include 'db.php';
date_default_timezone_set('Asia/Manila'); // Change according to your timezone

function sanitize_input($data) {
    $data = strip_tags(trim($data));
    $data = htmlspecialchars($data);
    return $data;
}

$get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
    $res_academic = $get_academic->fetch_array();
    $curr = $res_academic['year'];
    $semester = $res_academic['semester'];
$id = $_POST['id'];
// Assuming POST variables are properly sanitized
$fname = sanitize_input($_POST['fname']);
$mname = sanitize_input($_POST['mname']);
$lname = sanitize_input($_POST['lname']);
$stu_name = $lname . ' ' . $fname . ' '. $mname;
$course = sanitize_input($_POST['course']);
$con_no = sanitize_input($_POST['con_no']);
$home_ad = sanitize_input($_POST['home_ad']);
$civil = sanitize_input($_POST['civil']);
$d_birth = sanitize_input($_POST['d_birth']);
$p_birth = sanitize_input($_POST['p_birth']);
$ele = sanitize_input($_POST['ele']);
$ele_year = sanitize_input($_POST['ele_year']);
$high = sanitize_input($_POST['high']);
$high_year = sanitize_input($_POST['high_year']);
$last_sc = sanitize_input($_POST['last_sc']);
$last_year = sanitize_input($_POST['last_year']);
$email = sanitize_input($_POST['email']);
$gender = sanitize_input($_POST['gender']);

// Check if the record already exists
// $check_query = "SELECT * FROM enroll2024 WHERE stu_id = '$stu_id' AND stu_name = '$stu_name' AND course = '$course'";
// $check_result = mysqli_query($conn, $check_query);

$insert_query = "UPDATE enroll2024 SET fname = '$fname', lname = '$lname', mname = '$mname', email = '$email', con_no = '$con_no', home_ad = '$home_ad', gender = '$gender', p_birth = '$p_birth', d_birth = '$d_birth', ele = '$ele', ele_year ='$ele_year', high = '$high',high_year = '$high_year',last_sc = '$last_sc',last_year = '$last_year' WHERE id = '$id'";
$insert_result = mysqli_query($conn, $insert_query);

if ($insert_result) {
    // If insertion is successful, return JSON response with success message
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: 'success!',
            text: 'Enrollment updated successfully',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'edit-enroll.php?id=$id';
            }
        });
    };
  </script>";
} 
?>
