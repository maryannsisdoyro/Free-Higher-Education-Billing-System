<?php include 'db_connect.php' ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<?php

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

function sanitize_input($data) {
   
    $data = strip_tags(trim($data));
 
    $data = htmlspecialchars($data);
    return $data;
}

$last_name = strtoupper(sanitize_input($_POST['last_name']));
$first_name = strtoupper(sanitize_input($_POST['first_name']));
$middle_name = strtoupper(sanitize_input($_POST['middle_name']));
$home_address = sanitize_input($_POST['home_address']);
$present_address = sanitize_input($_POST['present_address']);
$contact = sanitize_input($_POST['contact']);
$sex = sanitize_input($_POST['sex']);
$date_of_birth = sanitize_input($_POST['date_of_birth']);
$email = sanitize_input($_POST['email']);
$place_of_birth = sanitize_input($_POST['place_of_birth']);
$civil_status = sanitize_input($_POST['civil_status']);
$elementary = sanitize_input($_POST['elementary']);
$elementary_year_graduated = sanitize_input($_POST['elementary_year_graduated']);
$high_school = sanitize_input($_POST['high_school']);
$high_school_year_graduated = sanitize_input($_POST['high_school_year_graduated']);
$shs = sanitize_input($_POST['shs']);
$shs_year_graduated = sanitize_input($_POST['shs_year_graduated']);
$track_and_strand = sanitize_input($_POST['track_and_strand']);
$complete_name = sanitize_input($_POST['complete_name']);
$date_signed = sanitize_input($_POST['date_signed']);
$course_to_be_enrolled = sanitize_input($_POST['course_to_be_enrolled']);

$duplicate_check_query = "SELECT * FROM student_enroll WHERE last_name = ? AND first_name = ?";
$params = array($last_name, $first_name);
$types = "ss";

if (!empty($middle_name)) {
    $duplicate_check_query .= " AND middle_name = ?";
    $params[] = $middle_name;
    $types .= "s";
}


$stmt = $conn->prepare($duplicate_check_query);
if (!$stmt) {
    die("Error preparing duplicate check statement: " . $conn->error);
}

$stmt->bind_param($types, ...$params);

$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo '<div style="background-color: #ffcccc; padding: 10px; border: 1px solid #ff0000; border-radius: 5px;">';
    echo '<p style="color: #ff0000; font-weight: bold;">Error: Student with the same last name and first name already exists with a different middle name.</p>';
    echo '<button style="padding: 5px 10px; background-color: #ff0000; color: #f2f2f2; border: none; border-radius: 3px; cursor: pointer;" ><a style="color: #f2f2f2;" href="enrolled.php">Go Back </a></button>'; 
    echo '</div>';
    exit;
}

// Assuming $conn is already established
$track_and_strand = $_POST['track_and_strand'];
if ($track_and_strand === "Others") {
    $otherTrackStrand = $_POST['otherTrackStrand'];

    $insert_query = "INSERT INTO student_enroll (
        last_name, first_name, middle_name, home_address, present_address, contact, sex, date_of_birth, email, place_of_birth, civil_status, elementary, elementary_year_graduated, high_school, high_school_year_graduated, shs, shs_year_graduated, track_and_strand, complete_name, date_signed, course_to_be_enrolled
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $insert_stmt = $conn->prepare($insert_query);
    if (!$insert_stmt) {
        die("Error preparing insertion statement: " . $conn->error);
    }

    $insert_stmt->bind_param("sssssssssssssssssssss", 
        $last_name, $first_name, $middle_name, $home_address, $present_address, 
        $contact, $sex, $date_of_birth, $email, $place_of_birth, $civil_status, 
        $elementary, $elementary_year_graduated, $high_school, $high_school_year_graduated, 
        $shs, $shs_year_graduated, $otherTrackStrand, $complete_name, $date_signed, 
        $course_to_be_enrolled
    );

} else {
    $insert_query = "INSERT INTO student_enroll (
        last_name, first_name, middle_name, home_address, present_address, contact, sex, date_of_birth, email, place_of_birth, civil_status, elementary, elementary_year_graduated, high_school, high_school_year_graduated, shs, shs_year_graduated, track_and_strand, complete_name, date_signed, course_to_be_enrolled
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $insert_stmt = $conn->prepare($insert_query);
    if (!$insert_stmt) {
        die("Error preparing insertion statement: " . $conn->error);
    }

    $insert_stmt->bind_param("sssssssssssssssssssss", 
        $last_name, $first_name, $middle_name, $home_address, $present_address, 
        $contact, $sex, $date_of_birth, $email, $place_of_birth, $civil_status, 
        $elementary, $elementary_year_graduated, $high_school, $high_school_year_graduated, 
        $shs, $shs_year_graduated, $track_and_strand, $complete_name, $date_signed, 
        $course_to_be_enrolled
    );
}

if ($insert_stmt->execute()) {
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Please proceed to the IT-FACULTY for the signature of your College Application Form.",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
<<<<<<< HEAD
                                window.location.href = "index.php?page=enrolled";
=======
                                window.location.href = "enrolled.php";
>>>>>>> origin/main
                            }
                        });
                    };
                  </script>';
} else {
    echo "Error: " . $insert_stmt->error;
    echo '<br><br><button class="go-back-btn" onclick="goBack()">Go Back</button>'; 
}

$insert_stmt->close();

// Do not close the connection here, as you may need it for subsequent operations

?>

<script>
    function goBack() {
        window.location.href = "enrolled.php"; 
    }

    function goHome() {
        window.location.href = "enrolled.php"; 
    }
</script>

