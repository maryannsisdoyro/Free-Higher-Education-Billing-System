<?php
include 'db.php';
date_default_timezone_set('Asia/Manila'); // Change according to your timezone

function sanitize_input($data) {
    $data = strip_tags(trim($data));
    $data = htmlspecialchars($data);
    return $data;
}

// Assuming POST variables are properly sanitized
$application_no = sanitize_input($_POST['application_no']);
$stu_name = sanitize_input($_POST['stu_name']);
$stu_id = sanitize_input($_POST['stu_id']);
$stu_sta = sanitize_input($_POST['stu_sta']);
$course = sanitize_input($_POST['courseenrolled']);
$majorOutput1 = sanitize_input($_POST['majorOutput1']);
$selectedSection1 = sanitize_input($_POST['selectedSection1']);
$curr = sanitize_input($_POST['curr']);
$religiousOutput1 = sanitize_input($_POST['religiousOutput1']);
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
$tot_units = sanitize_input($_POST['tot_units']);
$un_enrol = sanitize_input($_POST['un_enrol']);
$rate_per = sanitize_input($_POST['rate_per']);
$total = sanitize_input($_POST['total']);
$lib = sanitize_input($_POST['lib']);
$com = sanitize_input($_POST['com']);
$lab1 = sanitize_input($_POST['lab1']);
$lab2 = sanitize_input($_POST['lab2']);
$lab3 = sanitize_input($_POST['lab3']);
$sch_id = sanitize_input($_POST['sch_id']);
$ath = sanitize_input($_POST['ath']);
$adm = sanitize_input($_POST['adm']);
$dev = sanitize_input($_POST['dev']);
$guid = sanitize_input($_POST['guid']);
$hand = sanitize_input($_POST['hand']);
$entr = sanitize_input($_POST['entr']);
$reg_fe = sanitize_input($_POST['reg_fe']);
$med_den = sanitize_input($_POST['med_den']);
$cul = sanitize_input($_POST['cul']);
$t_misfe = sanitize_input($_POST['t_misfe']);
$g_tot = sanitize_input($_POST['TuitionFees']);
$section = sanitize_input($_POST['section']);
$email = sanitize_input($_POST['email']);
$year_level = '1st';

// Check if the record already exists
$check_query = "SELECT * FROM enroll2024 WHERE stu_id = '$stu_id' AND stu_name = '$stu_name' AND course = '$course'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // If the record exists, return JSON response with error message
    $response = array(
        'success' => false,
        'message' => 'Student Records already exist.'
    );
    echo json_encode($response);
} else {

    if ($_FILES['fileInput']['error'] > 0) {
        $insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot, section,email)
        VALUES ('$application_no','$stu_id', '$stu_name', '$stu_sta', '$course', '$majorOutput1', '$year_level', '$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$section', '$email')";
    }else{
        $filename = $_FILES['fileInput']['name'];
        $tmp_name = $_FILES['fileInput']['tmp_name'];
        $folder = "./upload/" . $filename;

        $insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, section, email)
        VALUES ('$application_no','$stu_id', '$stu_name', '$stu_sta', '$course', '$majorOutput1', '$year_level', '$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$section', '$email')";
    }

    // Insert new record into the database
   

    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        // If insertion is successful, return JSON response with success message
        $response = array(
            'success' => true,
            'message' => 'Enrollment Data Successfully Created !!'
        );

        if ($_FILES['fileInput']['error'] > 0) {

        }else{
            move_uploaded_file($tmp_name, $folder);
        }

        echo json_encode($response);
    } else {
        // If insertion fails, return JSON response with error message
        $response = array(
            'success' => false,
            'message' => 'Error occurred while creating the enrollment records.'
        );
        echo json_encode($response);
    }
}

?>
