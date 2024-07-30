<?php
session_start();
include('db.php'); // Assuming config.php contains database connection settings
// Redirect to login page if user is not logged in
if (empty($_SESSION['alogin'])) {
    // header('location:index.php');
    // exit(); // Stop further execution
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form data into session variables
    $_SESSION['from'] = $_POST['startpoint'];
    $_SESSION['to'] = $_POST['endpoint'];
    $_SESSION['receiptrange'] = $_POST['receiptrange'];
}

// Step 1: Retrieve the latest student ID from the database
$query36 = mysqli_query($conn, "SELECT MAX(id) AS lateststudentid FROM enroll2024");
$row36 = mysqli_fetch_assoc($query36);
$lateststudentid = $row36['lateststudentid'];

// Step 2: Increment the latest student ID by 1 to get the new student ID
$newstudentid = $lateststudentid + 1;

// Step 3: Format the student ID as "2024-000X"
$formatted_studentid = "2024-" . sprintf('%04d', $newstudentid);


// Ensure the $unitsenrolled variable is defined and set to zero if not selected
$tot_units = isset($tot_units) ? $tot_units : 0;
$un_enrol = isset($un_enrol) ? $un_enrol : 0;
$rate_per = isset($rate_per) ? $rate_per : 0;
$total = isset($total) ? $total : 0;
$lib = isset($lib) ? $lib : 0;
$com = isset($com) ? $com : 0;
$lab1 = isset($lab1) ? $lab1 : 0;
$lab2 = isset($lab2) ? $lab2 : 0;
$lab3 = isset($lab3) ? $lab3 : 0;
$sch_id = isset($sch_id) ? $sch_id : 0;
$ath = isset($ath) ? $ath : 0;
$adm = isset($adm) ? $adm : 0;
$dev = isset($dev) ? $dev : 0;
$guid = isset($guid) ? $guid : 0;
$hand = isset($hand) ? $hand : 0;
$entr = isset($entr) ? $entr : 0;
$reg_fe = isset($reg_fe) ? $reg_fe : 0;
$med_den = isset($med_den) ? $med_den : 0;
$cul = isset($cul) ? $cul : 0;
$t_misfe = isset($t_misfe) ? $t_misfe : 0;
$g_tot = isset($g_tot) ? $g_tot : 0;



// Fetch and sanitize GET parameter stu_sta
$section_year = "1st";
$stu_sta = "REGULAR";
$curr = "2024-2025";
$application_no = intval($_GET['application_no']);
$query = mysqli_query($conn, "select * from students where application_no='$application_no'");
$row = mysqli_fetch_assoc($query);
$numb = mysqli_num_rows($query);
// Check if record exists
if ($row) {
    // Retrieve data from the fetched row
    $application_no  = $row["application_no"];
    $last_name  = $row["last_name"];
    $first_name  = $row["first_name"];
    $middle_name  = $row["middle_name"];
    $home_address  = $row["home_address"];
    $present_address  = $row["present_address"];
    $contact  = $row["contact"];
    $sex  = $row["sex"];
    // $date_of_birth  = $row["date_of_birth"];
    $date_of_birth = date('F j, Y', strtotime($row['date_of_birth']));
    $email  = $row["email"];
    $place_of_birth  = $row["place_of_birth"];
    $civil_status  = $row["civil_status"];
    $elementary  = $row["elementary"];
    $elementary_year_graduated  = $row["elementary_year_graduated"];
    $high_school  = $row["high_school"];
    $high_school_year_graduated  = $row["high_school_year_graduated"];
    $shs  = $row["shs"];
    $shs_year_graduated  = $row["shs_year_graduated"];
    $track_and_strand  = $row["track_and_strand"];
    $complete_name  = $row["complete_name"];
    $date_signed  = $row["date_signed"];
    $course_to_be_enrolled  = $row["course_to_be_enrolled"];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Of Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>

    <style>
        .callout {
            border: 1px solid #007bff;
            padding: 20px;
            border-radius: 5px;
        }

        .callout legend {
            width: auto;
            padding: 0 10px;
            font-size: 1.2em;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container" style="font-size: smaller;">
        <div class="callout border-primary col-md-15 ">
            <video id="videoElement" autoplay class="hidden"></video>
            <canvas id="canvas" class="hidden"></canvas>
            <br>
            <button class="btn btn-warning" id="startButton">Take Photo</button>
            <br>
            <button class="btn btn-danger hidden" id="captureButton">Capture</button>


        </div>
    </div>
    <div class="container" style="font-size: smaller;">
        <div class="callout border-primary mt-5">
            <fieldset>
                <legend>Filter</legend>
                <form id="Subjectform" action="saveenroll.php" method="post" enctype="multipart/form-data">
                    <div class="row align-items-end">
                        <div class="form-group col-md-5">
                            <label for="courseenrolled" class="control-label">Program Enrolled</label>
                            <select class="custom-select form-control-sm rounded-0" name="courseenrolled" id="courseenrolled" onselect="filterResults()" oninput="updateFilters()" onchange="updateCourseAndMajor()" required>
                                <!-- <option value="">Select Course to be Enrolled</option> -->
                                <!-- <option value="BEED">Bachelor of Elementary Education</option>
                                <option value="BSED">Bachelor of Secondary Education</option>
                                <option value="BSIT">Bachelor of Science in Information Technology</option>
                                <option value="BSHM">Bachelor of Science in Hotel Management</option>
                                <option value="BSBA">Bachelor of Science in Business Administration</option> -->
                                <?php
                                $get_course = $conn->query("SELECT * FROM courses");
                                // $fetch_course = $get_course->fetch_assoc();

                                // $cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
                                // $ftotal = 0;
                                while ($row = $get_course->fetch_assoc()) {
                                    // $ftotal += $row['amount'];
                                ?>
                                    <option value="<?= $row['department'] ?>"><?= $row['course'] .' '. $row['level']  ?></option>
                                <?php } ?>
                            </select>


                        </div>

                        <div class="form-group col-md-3">
                            <label for="Religious" class="control-label">Religious</label>
                            <select class="custom-select form-control-sm rounded-0" name="religiousInput" id="religiousInput" required>
                                <!-- <option value="">Select</option> -->
                                <option value="Roman Catholic">Roman Catholic</option>
                                <option value="Iglesia Ni Cristo">Iglesia Ni Cristo</option>
                                <option value="Seventh-day Adventist">Seventh-day Adventist</option>
                                <option value="Christians">Christians</option>
                                <option value="Baptist">Baptist</option>
                                <option value="Jehovah's Witnesses">Jehovah's Witnesses</option>
                                <option value="Islam">Islam</option>
                                <option value="Others">Others</option>
                            </select>

                        </div>
                        <div class="form-group col-md-3">
                            <?php 
                                 $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
                                 $res_academic = $get_academic->fetch_array();
                            ?>
                            <label for="semester" class="control-label">Semester</label>
                            <select class="custom-select form-control-sm rounded-0" name="semester" id="semester" oninput="updateFilters()" oninput="filterResults()" readonly autocomplete="off" >
                                <!-- <option value="">Select Semester</option> -->
                                <option value="<?= $res_academic['semester'] ?>"><?= $res_academic['semester'] ?></option>
                               
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="statustudent" class="control-label">Status</label>
                            <select class="custom-select form-control-sm rounded-0" name="statustudent" id="statustudent" required>
                                <option value="REGULAR">REGULAR</option>
                                <option value="IRREGULAR">IRREGULAR</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="Section" class="control-label">Section</label>
                            <?php require 'get-sections.php'; ?>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="Tuition Fees" class="control-label">Tuition Fees</label>
                            <select class="custom-select form-control-sm rounded-0" name="TuitionFees" id="TuitionFees" required>
                                <!-- <option value="" disabled selected>Select</option> -->
                                <!-- <option value="BEED">BEED</option>
                                <option value="BSED">BSED</option>
                                <option value="BSIT-STEM">BSIT-STEM</option>
                                <option value="BSIT-NONE">BSIT-NONE</option>
                                <option value="BSHM-ABM">BSHM-ABM</option>
                                <option value="BSHM-NONE">BSHM-NONE</option>
                                <option value="BSBA-ABM">BSBA-ABM</option>
                                <option value="BSBA-NONE">BSBA-NONE</option> -->
                                <?php
                                $get_course = $conn->query("SELECT * FROM courses");
                                // $fetch_course = $get_course->fetch_assoc();

                                // $cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
                                // $ftotal = 0;
                                while ($row = $get_course->fetch_assoc()) {
                                    // $ftotal += $row['amount'];
                                ?>
                                    <option value="<?= $row['total_amount'] ?>" data="<?= $row['department'] ?>"><?= $row['department'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="collegeprog" class="control-label">Pre-College Program</label>
                            <input type="text-center" class="form-control" autocomplete="off" name="collegeprog" id="collegeprog" class="span8 tip" autocomplete="off" placeholder="Strack and Strand" readonly value="<?php echo $track_and_strand; ?>" style="text-transform: uppercase;">

                            <input type="hidden" class="form-control" autocomplete="off" name="collegeprog2" id="collegeprog2" class="span8 tip" autocomplete="off" placeholder="Strack and Strand" readonly value="<?php echo $track_and_strand; ?>" style="text-transform: uppercase;">
                        </div>
                        <input type="hidden" class="form-control" name="application_no" id="application_no" value="<?php echo $application_no; ?>" readonly>
                        <input type="hidden" class="form-control" name="stu_name" id="stu_name" value="<?php echo strtoupper($complete_name); ?>" readonly>
                        <input type="hidden" class="form-control" name="stu_id" id="stu_id" value="<?php echo $formatted_studentid; ?>" readonly>
                        <input type="hidden" class="form-control" name="stu_sta" id="stu_sta" value="<?php echo $stu_sta; ?>" readonly>
                        <!-- <input type="hidden" class="form-control" name="course" id="course" readonly> -->
                        <input type="hidden" class="form-control" name="majorOutput1" id="majorOutput1" readonly>
                        <input type="hidden" class="form-control" name="selectedSection1" id="selectedSection1" value="<?php echo $section_year; ?>" readonly>
                        <input type="hidden" class="form-control" name="curr" id="curr" value="<?php echo $curr; ?>" readonly>
                        <input type="hidden" class="form-control" name="religiousOutput1" id="religiousOutput1" readonly>
                        <input type="hidden" class="form-control" name="con_no" id="con_no" value="<?php echo $contact; ?>" readonly>
                        <input type="hidden" class="form-control" name="home_ad" id="home_ad" value="<?php echo strtoupper($home_address); ?>" readonly>
                        <input type="hidden" class="form-control" name="civil" id="civil" value="<?php echo strtoupper($civil_status); ?>" readonly>
                        <input type="hidden" class="form-control" name="d_birth" id="d_birth" value="<?php echo strtoupper($date_of_birth); ?>" readonly>
                        <input type="hidden" class="form-control" name="p_birth" id="p_birth" value="<?php echo strtoupper($place_of_birth); ?>" readonly>
                        <input type="hidden" class="form-control" name="email" id="email" value="<?php echo $email; ?>" readonly>
                        <?php
                        // Assuming $high_school_year_graduated contains the year as a string or null
                        $academic_year = '';
                        if ($elementary_year_graduated && preg_match('/^\d{4}$/', $elementary_year_graduated)) {
                            // Extract the year from the variable
                            $year = intval($elementary_year_graduated);

                            // Generate the academic year range
                            $academic_year = ($year - 1) . '-' . $elementary_year_graduated;
                        } else {
                            $academic_year = $elementary_year_graduated; // Output the variable as-is if it doesn't match the formats
                        }
                        ?>
                        <input type="hidden" class="form-control" name="ele" id="ele" value="<?php echo strtoupper($elementary); ?>" readonly>
                        <input type="hidden" class="form-control" name="ele_year" id="ele_year" value="<?php echo htmlspecialchars($academic_year); ?>" readonly>
                        <?php
                        // Assuming $high_school_year_graduated contains the year as a string or null
                        $academic_year2 = '';
                        if ($high_school_year_graduated && preg_match('/^\d{4}$/', $high_school_year_graduated)) {
                            // Extract the year from the variable
                            $year = intval($high_school_year_graduated);

                            // Generate the academic year range
                            $academic_year2 = ($year - 1) . '-' . $high_school_year_graduated;
                        } else {
                            $academic_year2 = $high_school_year_graduated; // Output the variable as-is if it doesn't match the formats
                        }
                        ?>
                        <input type="hidden" class="form-control" name="high" id="high" value="<?php echo strtoupper($high_school); ?>" readonly>
                        <input type="hidden" class="form-control" name="high_year" id="high_year" value="<?php echo htmlspecialchars($academic_year2); ?>" readonly>
                        <?php
                        // Assuming $high_school_year_graduated contains the year as a string or null
                        $academic_year3 = '';
                        if ($shs_year_graduated && preg_match('/^\d{4}$/', $shs_year_graduated)) {
                            // Extract the year from the variable
                            $year = intval($shs_year_graduated);

                            // Generate the academic year range
                            $academic_year3 = ($year - 1) . '-' . $shs_year_graduated;
                        } else {
                            $academic_year3 = $shs_year_graduated; // Output the variable as-is if it doesn't match the formats
                        }
                        ?>
                        <input type="hidden" class="form-control" name="last_sc" id="last_sc" value="<?php echo strtoupper($shs); ?>" readonly>
                        <input type="hidden" class="form-control" name="last_year" id="last_year" value="<?php echo htmlspecialchars($academic_year3); ?>" readonly>

                        <input type="hidden" class="form-control" name="tot_units" id="tot_units" value="<?php echo $tot_units; ?>" readonly>
                        <input type="hidden" class="form-control" name="un_enrol" id="un_enrol" value="<?php echo $un_enrol; ?>" readonly>
                        <input type="hidden" class="form-control" name="rate_per" id="rate_per" value="<?php echo $rate_per; ?>" readonly>
                        <input type="hidden" class="form-control" name="total" id="total" value="<?php echo $total; ?>" readonly>
                        <input type="hidden" class="form-control" name="lib" id="lib" value="<?php echo $lib; ?>" readonly>
                        <input type="hidden" class="form-control" name="com" id="com" value="<?php echo $com; ?>" readonly>
                        <input type="hidden" class="form-control" name="lab1" id="lab1" value="<?php echo $lab1; ?>" readonly>
                        <input type="hidden" class="form-control" name="lab2" id="lab2" value="<?php echo $lab2; ?>" readonly>
                        <input type="hidden" class="form-control" name="lab3" id="lab3" value="<?php echo $lab3; ?>" readonly>
                        <input type="hidden" class="form-control" name="sch_id" id="sch_id" value="<?php echo $sch_id; ?>" readonly>
                        <input type="hidden" class="form-control" name="ath" id="ath" value="<?php echo $ath; ?>" readonly>
                        <input type="hidden" class="form-control" name="adm" id="adm" value="<?php echo $adm; ?>" readonly>
                        <input type="hidden" class="form-control" name="dev" id="dev" value="<?php echo $dev; ?>" readonly>
                        <input type="hidden" class="form-control" name="guid" id="guid" value="<?php echo $guid; ?>" readonly>
                        <input type="hidden" class="form-control" name="hand" id="hand" value="<?php echo $hand; ?>" readonly>
                        <input type="hidden" class="form-control" name="entr" id="entr" value="<?php echo $entr; ?>" readonly>
                        <input type="hidden" class="form-control" name="reg_fe" id="reg_fe" value="<?php echo $reg_fe; ?>" readonly>
                        <input type="hidden" class="form-control" name="med_den" id="med_den" value="<?php echo $med_den; ?>" readonly>
                        <input type="hidden" class="form-control" name="cul" id="cul" value="<?php echo $cul; ?>" readonly>
                        <input type="hidden" class="form-control" name="t_misfe" id="t_misfe" value="<?php echo $t_misfe; ?>" readonly>
                        <input type="hidden" class="form-control" name="fname" id="fname" value="<?php echo $first_name; ?>" readonly>
                        <input type="hidden" class="form-control" name="mname" id="mname" value="<?php echo $middle_name; ?>" readonly>
                        <input type="hidden" class="form-control" name="lname" id="lname" value="<?php echo $last_name; ?>" readonly>
                        <input type="hidden" class="form-control" name="gender" id="gender" value="<?php echo $sex; ?>" readonly>
                        <input type="hidden" class="form-control" name="g_tot" id="g_tot" value="<?php echo $g_tot; ?>" readonly>
                        <input type="file" id="fileInput" name="fileInput" class="hidden" />
                    </div>

                    <!-- <button class="btn btn-primary" type="submit" id="submit"><i class="fa fa-print"></i> Save</button> -->
                    <button class="btn btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                    <a href="home.php?page=students" class="btn btn-secondary">Cancel</a>


                </form>
            </fieldset>
        </div>
    </div>


    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 for feedback -->




    <script>
        document.getElementById('print').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('Subjectform')); // Replace 'Subjectform' with your form ID

            fetch('saveenroll.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'students.php'; // Redirect to recordenroll.php after printing
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred while saving data.',
                        icon: 'error'
                    });
                });
        });
    </script>


    <script>
        document.getElementById('TuitionFees').addEventListener('change', function() {
            var selectedValue = this.value;
            var totalUnits = document.getElementById('tot_units');
            var tun_enrol = document.getElementById('un_enrol');
            var trate_per = document.getElementById('rate_per');
            var ttotal = document.getElementById('total');
            var tlib = document.getElementById('lib');
            var tcom = document.getElementById('com');
            var tlab1 = document.getElementById('lab1');
            var tlab2 = document.getElementById('lab2');
            var tlab3 = document.getElementById('lab3');
            var tsch_id = document.getElementById('sch_id');
            var tath = document.getElementById('ath');
            var tadm = document.getElementById('adm');
            var tdev = document.getElementById('dev');
            var tguid = document.getElementById('guid');
            var thand = document.getElementById('hand');
            var tentr = document.getElementById('entr');
            var treg_fe = document.getElementById('reg_fe');
            var tmed_den = document.getElementById('med_den');
            var tcul = document.getElementById('cul');
            var tt_misfe = document.getElementById('t_misfe');
            var tg_tot = document.getElementById('g_tot');

            if (selectedValue === 'BSIT-STEM') {
                totalUnits.value = 26;
                tun_enrol.value = 26;
                trate_per.value = 229.17;
                ttotal.value = 5958.42;
                tlib.value = 150;
                tcom.value = 100;
                tlab1.value = 6;
                tlab2.value = 150;
                tlab3.value = 900;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 3150;
                tg_tot.value = 9108.42;
            } else if (selectedValue === "BSIT-NONE") {
                totalUnits.value = 32;
                tun_enrol.value = 32;
                trate_per.value = 229.17;
                ttotal.value = 7333.44;
                tlib.value = 150;
                tcom.value = 100;
                tlab1.value = 6;
                tlab2.value = 150;
                tlab3.value = 900;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 3150;
                tg_tot.value = 10483.44;
            } else if (selectedValue === "BSBA-ABM") {
                totalUnits.value = 23;
                tun_enrol.value = 23;
                trate_per.value = 229.17;
                ttotal.value = 5270.91;
                tlib.value = 150;
                tcom.value = 0;
                tlab1.value = 0;
                tlab2.value = 150;
                tlab3.value = 0;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 2150;
                tg_tot.value = 7420.91;
            } else if (selectedValue === "BSBA-NONE") {
                totalUnits.value = 29;
                tun_enrol.value = 29;
                trate_per.value = 229.17;
                ttotal.value = 6645.93;
                tlib.value = 150;
                tcom.value = 0;
                tlab1.value = 0;
                tlab2.value = 150;
                tlab3.value = 0;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 2150;
                tg_tot.value = 8795.93;
            } else if (selectedValue === "BSHM-ABM") {
                totalUnits.value = 23;
                tun_enrol.value = 23;
                trate_per.value = 229.17;
                ttotal.value = 5270.91;
                tlib.value = 150;
                tcom.value = 0;
                tlab1.value = 3;
                tlab2.value = 150;
                tlab3.value = 450;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 2600;
                tg_tot.value = 7870.91;
            } else if (selectedValue === "BSHM-NONE") {
                totalUnits.value = 32;
                tun_enrol.value = 32;
                trate_per.value = 229.17;
                ttotal.value = 7333.44;
                tlib.value = 150;
                tcom.value = 0;
                tlab1.value = 3;
                tlab2.value = 150;
                tlab3.value = 450;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 2600;
                tg_tot.value = 9933.44;
            } else if (selectedValue === "BEED") {
                totalUnits.value = 26;
                tun_enrol.value = 26;
                trate_per.value = 229.17;
                ttotal.value = 5958.42;
                tlib.value = 150;
                tcom.value = 0;
                tlab1.value = 3;
                tlab2.value = 150;
                tlab3.value = 0;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 2150;
                tg_tot.value = 8108.42;
            } else if (selectedValue === "BSED") {
                totalUnits.value = 26;
                tun_enrol.value = 26;
                trate_per.value = 229.17;
                ttotal.value = 5958.42;
                tlib.value = 150;
                tcom.value = 0;
                tlab1.value = 3;
                tlab2.value = 150;
                tlab3.value = 0;
                tsch_id.value = 200;
                tath.value = 150;
                tadm.value = 100;
                tdev.value = 250;
                tguid.value = 100;
                thand.value = 200;
                tentr.value = 200;
                treg_fe.value = 300;
                tmed_den.value = 300;
                tcul.value = 200;
                tt_misfe.value = 2150;
                tg_tot.value = 8108.42;
            } else {
                totalUnits.value = 0;
                tun_enrol.value = 0;
                trate_per.value = 0;
                ttotal.value = 0;
                tlib.value = 0;
                tcom.value = 0;
                tlab1.value = 0;
                tlab2.value = 0;
                tlab3.value = 0;
                tsch_id.value = 0;
                tath.value = 0;
                tadm.value = 0;
                tdev.value = 0;
                tguid.value = 0;
                thand.value = 0;
                tentr.value = 0;
                treg_fe.value = 0;
                tmed_den.value = 0;
                tcul.value = 0;
                tt_misfe.value = 0;
                tg_tot.value = 0;
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var collegeprogInput = document.getElementById("collegeprog");
            var collegeprogInput2 = document.getElementById("collegeprog2");

            function checkCollegeProg() {
                var value = collegeprogInput.value.trim().toUpperCase();
                if (value === "STEM") {
                    collegeprogInput2.value = "STEM";
                } else if (value === "ABM") {
                    collegeprogInput2.value = "ABM";
                } else {
                    collegeprogInput2.value = "NONE";
                }
            }

            // Initial check
            checkCollegeProg();

            // Listen for changes
            collegeprogInput.addEventListener("change", checkCollegeProg);
        });
    </script>
    <script>
        document.getElementById('Section').addEventListener('input', function() {
            // Get the value from the input field
            var inputValue = this.value;
            // Set the value in the <span> inside the <td>
            document.getElementById('section').textContent = inputValue;
        });
    </script>

    <script>
        function updateSection() {
            var sectionDropdown = document.getElementById("Section");
            var selectedSection = sectionDropdown.options[sectionDropdown.selectedIndex].text;
            document.getElementById("selectedSection").textContent = selectedSection;
        }

        function updateSemesterText() {
            var selectedSemester = document.getElementById("semester").value;
            var semesterTextElement = document.getElementById("selectedSemester");

            if (selectedSemester === "") {
                semesterTextElement.textContent = "1st"; // Default value or initial state
            } else {
                semesterTextElement.textContent = selectedSemester + " semester";
            }
        }

        async function filterResults() {
            var semester = document.getElementById("semester").value;
            var courseenrolled = document.getElementById("course").value;
            var collegeprog = document.getElementById("collegeprog2").value;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'filter.php?semester=' + semester + '&courseenrolled=' + courseenrolled + '&collegeprog=' + collegeprog, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("example2").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        document.getElementById("semester").onchange = function() {
            updateSemesterText();
            filterResults();
        };

        document.getElementById("course").onchange = filterResults;
        document.getElementById("collegeprog2").onchange = filterResults;

        window.onload = function() {
            document.getElementById("semester").onchange = function() {
                updateSemesterText();
                filterResults();
            };
            document.getElementById("course").onchange = filterResults;
            document.getElementById("collegeprog2").onchange = filterResults;
        };
    </script>
    <script>
        function updateFilters() {
            var semester = document.getElementById("semester").value;
            var courseenrolled = document.getElementById("course").value;
            var collegeprog = document.getElementById("collegeprog2").value;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'filter.php?semester=' + semester + '&courseenrolled=' + courseenrolled + '&collegeprog=' + collegeprog, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("example2").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        document.getElementById("semester").onchange = updateFilters;
        document.getElementById("course").onchange = updateFilters;
        document.getElementById("collegeprog2").onchange = updateFilters;
    </script>

    <script>
        document.getElementById("religiousInput").addEventListener("change", function() {
            var selectedValue = this.value;
            document.getElementById("religiousOutput").textContent = selectedValue; // Use textContent or innerHTML
            document.getElementById("religiousOutput1").value = selectedValue; // Update value property instead of textContent
        });
    </script>

    <script>
        function updateCourseAndMajor() {
            var select = document.getElementById("courseenrolled");
            var selectedValue = select.value;
            var selectedText = select.options[select.selectedIndex].text;

            var course = "";
            var major = "";
            var major1 = ""; // You don't need to redeclare 'major1' here
            var courseAbbreviation = "";
            var sections = [];

            switch (selectedValue) {
                case "Bachelor of Elementary Education":
                    course = "BEED";
                    courseAbbreviation = "BEED";
                    major = "General";
                    major1 = "General";
                    sections = ["1A", "1B", "1C", "1D", "1E"];
                    break;
                case "Bachelor of Secondary Education":
                    course = "BSED";
                    courseAbbreviation = "BSED";
                    major = "Filipino";
                    major1 = "Filipino";
                    sections = ["1A", "1B", "1C", "1D", "1E"];
                    break;
                case "Bachelor of Science in Information Technology":
                    course = "BSIT";
                    courseAbbreviation = "BSIT";
                    major = "General";
                    major1 = "General";
                    sections = ["1-N", "1-S", "1-W", "1-E", "1-NE", "1-SW"];
                    break;
                case "Bachelor of Science in Hotel Management":
                    course = "BSHM";
                    courseAbbreviation = "BS-HM";
                    major = "General";
                    major1 = "General";
                    sections = ["1A", "1B", "1C", "1D", "1E"];
                    break;
                case "Bachelor of Science in Business Administration":
                    course = "BSBA";
                    courseAbbreviation = "BSBA";
                    major = "Financial Management";
                    major1 = "Financial Management";
                    sections = ["1A", "1B", "1C", "1D", "1E"];
                    break;
                default:
                    course = "";
                    courseAbbreviation = "";
                    major = "";
                    major1 = "";
                    sections = [];
                    break;
            }

            document.getElementById("courseOutput").innerText = selectedText;
            document.getElementById("majorOutput").innerText = major;
            document.getElementById("majorOutput1").value = major1; // Use value instead of innerText
            document.getElementById("course").value = courseAbbreviation;

            var sectionSelect = document.getElementById("Section");
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
            sections.forEach(function(section) {
                var option = document.createElement("option");
                option.value = section;
                option.text = section;
                sectionSelect.add(option);
            });

            // Update selected section input field
            updateSelectedSection();
        }

        function updateSelectedSection() {
            var sectionSelect = document.getElementById("Section");
            var selectedSection = document.getElementById("selectedSection1");

            selectedSection.value = sectionSelect.value;
        }

        // Event listener for Section dropdown change
        document.getElementById("Section").addEventListener("change", function() {
            updateSelectedSection();
        });
    </script>


    <style>
        #videoElement {
            width: 50%;
            height: 50%;
        }

        .hidden {
            display: none;

        }
    </style>

    <div id="outprint" style="font-size: smaller;">

        <style>
            img {
                vertical-align: middle;
            }

            /* Container for main content and small box */
            .container3 {
                position: relative;
                /* Make the container a positioning context */
            }

            /* Define styles for the main content */
            .main-content {
                width: calc(100% - 340px);
                /* Adjust width as needed */
                float: left;
                /* Keep the main content on the left */
            }

            /* Define styles for the small box on the right side */


            .small-box {
                position: absolute;
                right: calc(100% - 800px);
                /* Adjust the left position */
                width: 30%;
                border: 1px solid #000;
                height: 30px;
                margin-top: 0px;
                padding: 0px;
                background-color: #ccc;
                /* Grey background color */
                display: flex;
                /* or use display: grid; */
                justify-content: center;
                /* Center horizontally */
                align-items: center;
                /* Center vertically */
            }

            .centered-content {
                text-align: center;
                /* Center text within the box */
                width: 100%;
                /* Ensure content takes full width */
            }

            .small-box2 {
                position: absolute;
                /* Position the small box absolutely */
                right: calc(100% - 400px);
                /* Adjust the left position */
                width: 30%;
                /* Adjust width as needed */
                border: 0px solid #000;
                height: 65px;
                /* Adjust height as needed */
                margin-top: 1px;
                /* Adjust margin as needed */
                padding: 5px;
                /* Adjust padding as needed */
            }

            .college-application2 {
                display: flex;
                /* or display: grid; */
                align-items: center;
                /* for vertical alignment */
                text-align: center;
            }

            .college-application2 h4 {
                margin-left: 180px;
                /* Adjust as needed for spacing */

            }

            .college-application2 .small-box {
                padding: 0;
                text-align: center;
            }

            .small-box2 {
                position: absolute;
                /* Position the small box absolutely */
                right: calc(100% - 400px);
                /* Adjust the left position */
                width: 30%;
                /* Adjust width as needed */
                border: 0px solid #000;
                height: 65px;
                /* Adjust height as needed */
                margin-top: 1px;
                /* Adjust margin as needed */
                padding: 5px;
                /* Adjust padding as needed */
            }

            .container4 {
                width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #000;
            }

            .highlight {
                background-color: #d3d3d3;


            }
        </style>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 10px;
            }

            .college-application {
                width: 100%;
                max-width: 900px;
                margin: 0 auto;
                border: 1px solid #000;
                padding: 20px;
                box-sizing: border-box;
            }

            .header,
            .section-title {
                text-align: center;
                margin: 20px 0;
            }

            .header img {
                height: 100px;
            }

            .form-section {
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid #000;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
            }

            .note {
                margin-top: 20px;
                font-style: italic;
            }

            @media print {
                body {
                    margin: 0;
                }

                .college-application {
                    border: none;
                    padding: 0;
                }
            }
        </style>
        <style>
            @media print {
                .center-images {
                    text-align: center;
                }

                .center-images img {
                    display: inline-block;
                    margin: 0 auto;
                }
            }

            .center-images {
                text-align: center;
            }

            .center-images img {
                display: inline-block;
                margin: 0 auto;
            }

            #preview {
                width: 120px;
                height: 120px;
                object-fit: cover;
            }

            }
        </style>

        <div class="center-images">
            <img src="logo.jpg" alt="MCC Logo" style="height: 210px; width: 690px;">
            <img id="preview" src="default.jpg" alt="Preview Image">
        </div>
        <br>

        <div class="college-application">

            <div class="form-section">
                <table class="table table-bordered table-hover" style="font-size: small;">
                    <tr>
                        <td colspan="2"><strong>Name:</strong></td>
                        <td colspan="3" style="text-transform: uppercase;">
                            <?php echo strtoupper($first_name); ?>
                            <?php echo strtoupper($middle_name); ?>
                            <?php echo strtoupper($last_name); ?>
                        </td>

                        <td colspan="5" style="text-align: right;"><strong>ID Number:</strong></td>
                        <td colspan="5"><u><?php echo $formatted_studentid; ?></u></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Course:</strong></td>
                        <td colspan="2" style="text-transform: uppercase; font-size: smaller;" id="courseOutput"></td>
                        <td colspan="3" style="text-align: left;"><strong>Major:</strong> </td>
                        <td colspan="4" style="text-transform: uppercase;font-size: smaller;" id="majorOutput"></td>
                        <td colspan="5"><strong>Section:</strong> <span id="section"></span></td>

                    </tr>
                    <tr>
                        <td colspan="1"><strong>Curriculum Year:</strong></td>
                        <td colspan="2">
                            <center>2024-2025</center>
                        </td>
                        <td colspan="2" style="text-align: left;font-size: smaller;"><strong>Religious Affliliation:</strong> </td>
                        <td colspan="3" style="text-transform: uppercase;font-size: smaller;" id="religiousOutput"></td>
                        <td colspan="4" style="font-size: smaller;"><strong>Contact Number</strong> </td>
                        <td colspan="4"><?php echo $contact; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Home Address:</strong></td>
                        <td colspan="3" style="text-transform: uppercase;">
                            <center><?php echo $home_address; ?></center>
                        </td>
                        <td colspan="5" style="text-align: left;font-size: smaller;"><strong>Civil Status</strong></td>
                        <td colspan="5" style="text-transform: uppercase;"><?php echo $civil_status; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Date of Birth:</strong></td>
                        <td colspan="2" style="text-transform: uppercase;">
                            <center><?php echo $date_of_birth; ?></center>
                        </td>
                        <td colspan="5" style="text-align: left;font-size: smaller;"><strong>Place of Birth:</strong> </td>
                        <td colspan="5" style="text-transform: uppercase;font-size: smaller;"> <?php echo $place_of_birth; ?></td>

                    </tr>
                    <tr>
                        <td colspan="2"><strong>Elementary Course Completed:</strong></td>
                        <td colspan="3" style="text-transform: uppercase;">
                            <center><?php echo $elementary; ?></center>
                        </td>
                        <td colspan="5" style="text-align: center;"><strong>S.Y.</strong></td>
                        <td colspan="5" style="text-align: center;">
                            <?php
                            if ($elementary_year_graduated && preg_match('/^\d{4}$/', $elementary_year_graduated)) {
                                // Extract the year from the variable
                                $year = intval($elementary_year_graduated);

                                // Generate the academic year range
                                $academic_year = ($year - 1) . '-' . $elementary_year_graduated;

                                echo $academic_year;
                            } else {
                                echo $elementary_year_graduated; // Output the variable as-is if it doesn't match the format
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>High School Course Completed:</strong></td>
                        <td colspan="3" style="text-transform: uppercase;">
                            <center><?php echo $high_school; ?></center>
                        </td>
                        <td colspan="5" style="text-align: center;"><strong>S.Y.</strong></td>
                        <td colspan="5" style="text-align: center;">
                            <?php
                            if ($high_school_year_graduated && preg_match('/^\d{4}$/', $high_school_year_graduated)) {
                                // Extract the year from the variable
                                $year = intval($high_school_year_graduated);

                                // Generate the academic year range
                                $academic_year = ($year - 1) . '-' . $high_school_year_graduated;

                                echo $academic_year;
                            } else {
                                echo $high_school_year_graduated; // Output the variable as-is if it doesn't match the format
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Last School Attended:</strong></td>
                        <td colspan="3" style="text-transform: uppercase;">
                            <center><?php echo $shs; ?></center>
                        </td>
                        <td colspan="5" style="text-align: center;"><strong>S.Y.</strong></td>
                        <td colspan="5" style="text-align: center;">
                            <?php
                            if ($shs_year_graduated && preg_match('/^\d{4}$/', $shs_year_graduated)) {
                                // Extract the year from the variable
                                $year = intval($shs_year_graduated);

                                // Generate the academic year range
                                $academic_year = ($year - 1) . '-' . $shs_year_graduated;

                                echo $academic_year;
                            } else {
                                echo $shs_year_graduated; // Output the variable as-is if it doesn't match the format
                            }
                            ?>
                        </td>


                    </tr>
                </table>


                <p style="margin-top: 20px;">I hereby enroll the following for <u><strong><span id="selectedSemester">1st semester,</span></strong></u> A.Y. <u>2024-2025.</u></p>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }

                    .table-responsive {
                        width: 100%;
                        overflow-x: auto;
                    }

                    .table-bordered th,
                    .table-bordered td {
                        border: 1px solid #000;
                        padding: 1px;

                    }

                    .table-bordered th {
                        text-align: left;
                    }

                    .no-border {
                        border: none;
                    }

                    .total,
                    .grand-total {
                        font-weight: bold;
                    }
                </style>
                <div class="table-responsive table-responsive-data2">
                    <?php
                    require 'get-subjects.php';
                    ?>
                    <!--   <div class="center-images">
       <img src="r2.jpg" alt="MCC Logo" style="height: 90px; width: 800px;">
    </div> -->

                    <p style="margin-left: 120px; margin-top: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong><u style="text-transform: uppercase;">&nbsp;&nbsp; <?php echo strtoupper($first_name); ?> <?php echo strtoupper(substr($middle_name, 0, 1)); ?>. <?php echo strtoupper($last_name); ?>&nbsp;&nbsp;</u></strong><br>
                        <span>Student's Signature Above Printed Name</span>
                        <img src="n3.jpg" alt="MCC Logo" style="height: 80px; width: 400px; float: right;">
                    </p>



                </div>
            </div>

            <!-- Include jQuery and DataTables JS files -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

            <!-- JavaScript code for updating fee details and initializing DataTable -->
            <script>
                // JavaScript code for updating fee details based on selected option
                const tuitionFees = {
                    "BSIT-STEM": {
                        "unitsenrolled": 26,
                        "rateunit": 229.17,
                        "total": 5958.42,
                        "libr": 150,
                        "compu": 100,
                        "lab1": 6,
                        "lab2": 150,
                        "lab3": 900,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 3150,
                        "grandtotal": 9108.42
                    },
                    "BSIT-NONE": {
                        "unitsenrolled": 32,
                        "rateunit": 229.17,
                        "total": 7333.44,
                        "libr": 150,
                        "compu": 100,
                        "lab1": 6,
                        "lab2": 150,
                        "lab3": 900,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 3150,
                        "grandtotal": 10483.44
                    },
                    "BSBA-ABM": {
                        "unitsenrolled": 23,
                        "rateunit": 229.17,
                        "total": 5270.91,
                        "libr": 150,
                        "compu": 0,
                        "lab1": 0,
                        "lab2": 150,
                        "lab3": 0,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 2150,
                        "grandtotal": 7420.91
                    },
                    "BSBA-NONE": {
                        "unitsenrolled": 29,
                        "rateunit": 229.17,
                        "total": 6645.93,
                        "libr": 150,
                        "compu": 0,
                        "lab1": 0,
                        "lab2": 150,
                        "lab3": 0,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 2150,
                        "grandtotal": 8795.93
                    },
                    "BSHM-ABM": {
                        "unitsenrolled": 23,
                        "rateunit": 229.17,
                        "total": 5270.91,
                        "libr": 150,
                        "compu": 0,
                        "lab1": 3,
                        "lab2": 150,
                        "lab3": 450,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 2600,
                        "grandtotal": 7870.91
                    },
                    "BSHM-NONE": {
                        "unitsenrolled": 32,
                        "rateunit": 229.17,
                        "total": 7333.44,
                        "libr": 150,
                        "compu": 0,
                        "lab1": 3,
                        "lab2": 150,
                        "lab3": 450,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 2600,
                        "grandtotal": 9933.44
                    },
                    "BEED": {
                        "unitsenrolled": 26,
                        "rateunit": 229.17,
                        "total": 5958.42,
                        "libr": 150,
                        "compu": 0,
                        "lab1": 3,
                        "lab2": 150,
                        "lab3": 0,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 2150,
                        "grandtotal": 8108.42
                    },
                    "BSED": {
                        "unitsenrolled": 26,
                        "rateunit": 229.17,
                        "total": 5958.42,
                        "libr": 150,
                        "compu": 0,
                        "lab1": 3,
                        "lab2": 150,
                        "lab3": 0,
                        "school": 200,
                        "ath": 150,
                        "adm": 100,
                        "dev": 250,
                        "guid": 100,
                        "hand": 200,
                        "entre": 200,
                        "reg": 300,
                        "med": 300,
                        "cul": 200,
                        "totalmis": 2150,
                        "grandtotal": 8108.42
                    },
                };

                $(document).ready(function() {
                    $('#TuitionFees').change(function() {
                        const selectedOption = $(this).val();
                        const details = tuitionFees[selectedOption];

                        if (details) {
                            // Clear existing rows in tbody
                            $('#feeDetails').empty();

                            // Populate fee details dynamically
                            $('#feeDetails').append(`
                          <tr>
            <td colspan="4" class="no-border"></td>
            <td class="no-border" style="text-align: center;">Units Enrolled</td>
            <td class="no-border" style="text-align: center;">Rate per Unit</td>
            <td style="text-align: center;">Total</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border"><strong>Tuition Fee Due for the Semester</strong></td>
            <td class="no-border" style="text-align: center;">${details.unitsenrolled}</td>
            <td style="text-align: right;"><strong>${details.rateunit}</strong></td>
            <td style="text-align: right;"><strong>${details.total}</strong></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4" class="no-border"><strong>Miscellaneous Fees Applicable:</strong></td>
            <td class="no-border"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Library Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.libr.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Computer Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.compu.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Laboratory Fees</td>
            <td style="text-align: center;">${details.lab1}</td>
            <td style="text-align: right;">${details.lab2.toFixed(2)}</td>
            <td style="text-align: right;">${details.lab3.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">School ID Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.school.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Athletic Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.ath.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Admission Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.adm.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Development Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.ath.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Guidance Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.guid.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Handbook Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.hand.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Entrance Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.entre.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Registration Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.reg.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Medical and Dental Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.med.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="no-border">Cultural Fees</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${details.cul.toFixed(2)}</td>
        </tr>
        <tr>
            <td colspan="4" class="total"><strong>Total Miscellaneous Fees</strong></td>
            <td></td>
            <td></td>
            <td class="total" style="text-align: right;">${details.totalmis.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        </tr>
        <tr>
            <td colspan="4" class="grand-total"><strong>Grand Total</strong></td>
            <td></td>
            <td></td>
           <td class="grand-total" style="text-align: right;">${details.grandtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>

        </tr>
                    `);

                            // Initialize DataTable
                            $('#feeTable').DataTable({
                                destroy: true, // Destroy existing DataTable if re-initialized
                                paging: false, // Disable paging for simplicity
                                searching: false, // Disable searching for simplicity
                                info: false // Disable info for simplicity
                                // Add other DataTable options as needed
                            });
                        } else {
                            console.log('No details found for selected option');
                        }
                    });
                });
            </script>
</body>

</html>


<?php require 'get-fees.php' ?>
<img src="n2.jpg" alt="MCC Logo" style="height: 90px; width: 800px;">

</div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrbootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bdataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsidataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsiresponsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttodataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttobuttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttobuttons.html5.min.js"></script>
<script src="plugins/datatables-buttobuttons.print.min.js"></script>
<script src="plugins/datatables-buttobuttons.colVis.min.js"></script>
<!-- AdminLTE App -->


<script src="plugins2/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins2/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins2/datatables/jquery.dataTables.min.js"></script>
<script src="plugins2/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins2/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins2/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins2/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins2/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins2/jszip/jszip.min.js"></script>
<script src="plugins2/pdfmake/pdfmake.min.js"></script>
<script src="plugins2/pdfmake/vfs_fonts.js"></script>
<script src="plugins2/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins2/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins2/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filter').submit(function(e) {
            e.preventDefault();
            location.href = 'student-student.php?' + $(this).serialize();
        });

        $('#print').click(function() {
            start_loader();
            var _p = $('#outprint').clone();
            var _h = $('head').clone();
            var _el = $('<div>');
            var course = $('#course').val(); // Get the course abbreviation
            _h.find("title").text(
                "<?php echo strtoupper($last_name); ?>," +
                "<?php echo strtoupper($first_name); ?> " +
                "<?php echo strtoupper($middle_name); ?>-<?php echo $formatted_studentid; ?>-" +
                course
            );
            _p.find('tr.text-light').removeClass('text-light bg-gradient-purple');
            _el.append(_h);
            _el.append(_p);
            var nw = window.open("", "_blank", "width=1000,height=900,left=300,top=50");
            nw.document.write(_el.html());
            nw.document.close();
            setTimeout(() => {
                setPrintStyle(nw.document);
                nw.print();
                setTimeout(() => {
                    nw.close();
                    end_loader();
                }, 300);
            }, 750);
        });
    });

    function start_loader() {
        // Add your loader start code here
        console.log("Loader started");
    }

    function end_loader() {
        // Add your loader end code here
        console.log("Loader ended");
    }

    function setPrintStyle(doc) {
        var style = document.createElement('style');
        style.innerHTML = '@page { size: portrait; }' +
            'th, td { width: auto; }' +
            '#searching { display: none; }';
        doc.head.appendChild(style);
    }
</script>


<script>
    const startButton = document.getElementById('startButton');
    const captureButton = document.getElementById('captureButton');
    const video = document.getElementById('videoElement');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');
    const fileInput = document.getElementById('fileInput');

    startButton.addEventListener('click', () => {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                video: true
            }).then(stream => {
                video.srcObject = stream;
                video.classList.remove('hidden');
                captureButton.classList.remove('hidden');
                startButton.classList.add('hidden');

                // Reset canvas and preview
                canvas.classList.add('hidden');
                preview.classList.remove('hidden');
                preview.src = 'default.jpg'; // Reset preview image
            });
        }
    });

    captureButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/png');
        preview.src = dataUrl;
        video.classList.add('hidden');
        captureButton.classList.add('hidden');
        startButton.classList.remove('hidden');
        canvas.classList.remove('hidden');

        // Stop the video stream
        video.srcObject.getTracks().forEach(track => track.stop());

        // Convert data URL to Blob
        fetch(dataUrl)
            .then(res => res.blob())
            .then(blob => {
                // Create a file object
                const file = new File([blob], `<?php echo date('mdGis'); ?>.png`, {
                    type: 'image/png'
                });

                // Create a DataTransfer object
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                // Assign the file to the file input
                fileInput.files = dataTransfer.files;
            });
    });
</script>

<script>
    let courseenrolled = document.getElementById("courseenrolled")
    courseenrolled.onchange = () => {
        const courseVal = courseenrolled.value;
        let BSITS = document.querySelectorAll(".BSIT");
        let BSEDS = document.querySelectorAll(".BSED");
        let BEEDS = document.querySelectorAll(".BEED");
        let BSBAS = document.querySelectorAll(".BSBA");
        let BSHMS = document.querySelectorAll(".BSHM");

        if (courseVal == 'BSIT' || courseVal == 'BSIT-NONE' || courseVal == 'BSIT-STEM') {
            BSITS.forEach(BSIT => {
                if (BSIT.classList.contains("d-none")) {
                    BSIT.classList.remove("d-none")
                } else {
                    BSIT.classList.remove("d-none")
                }
            })

            BEEDS.forEach(BEED => { BEED.classList.add("d-none") });
            BSHMS.forEach(BSHM => { BSHM.classList.add("d-none") });
            BSBAS.forEach(BSBA => { BSBA.classList.add("d-none") });
            BSEDS.forEach(BSED => { BSED.classList.add("d-none") });

            // BSBA.classList.add("d-none")
            // BSED.classList.add("d-none")
            // BEED.classList.add("d-none")
            // BSHM.classList.add("d-none")

        } else if (courseVal == 'BSBA' || courseVal == 'BSBA-NONE' || courseVal == 'BSBA-ABM') {
            BSBAS.forEach(BSBA => {
                if (BSBA.classList.contains("d-none")) {
                    BSBA.classList.remove("d-none")
                } else {
                    BSBA.classList.remove("d-none")
                }
            })

            // BSIT.classList.add("d-none")
            // BSED.classList.add("d-none")
            // BEED.classList.add("d-none")
            // BSHM.classList.add("d-none")

            BEEDS.forEach(BEED => { BEED.classList.add("d-none") });
            BSHMS.forEach(BSHM => { BSHM.classList.add("d-none") });
            BSITS.forEach(BSIT => { BSIT.classList.add("d-none") });
            BSEDS.forEach(BSED => { BSED.classList.add("d-none") });


        } else if (courseVal == 'BEED') {
            BEEDS.forEach(BEED => {
                if (BEED.classList.contains("d-none")) {
                    BEED.classList.remove("d-none")
                } else {
                    BEED.classList.remove("d-none")
                }
            })

            // BSIT.classList.add("d-none")
            // BSED.classList.add("d-none")
            // BSBA.classList.add("d-none")
            // BSHM.classList.add("d-none")
            BSBAS.forEach(BSBA => { BSBA.classList.add("d-none") });
            BSHMS.forEach(BSHM => { BSHM.classList.add("d-none") });
            BSITS.forEach(BSIT => { BSIT.classList.add("d-none") });
            BSEDS.forEach(BSED => { BSED.classList.add("d-none") });

        } else if (courseVal == 'BSED') {
            BSEDS.forEach(BSED => {
                if (BSED.classList.contains("d-none")) {
                    BSED.classList.remove("d-none")
                } else {
                    BSED.classList.remove("d-none")
                }
            })

            BSBAS.forEach(BSBA => { BSBA.classList.add("d-none") });
            BSHMS.forEach(BSHM => { BSHM.classList.add("d-none") });
            BSITS.forEach(BSIT => { BSIT.classList.add("d-none") });
            BEEDS.forEach(BEED => { BEED.classList.add("d-none") });

        } else if (courseVal == 'BSHM' || courseVal == 'BSHM-NONE') {
            BSHMS.forEach(BSHM => {
                if (BSHM.classList.contains("d-none")) {
                    BSHM.classList.remove("d-none")
                } else {
                    BSHM.classList.remove("d-none")
                }
            })

            // BSIT.classList.add("d-none")
            // BSBA.classList.add("d-none")
            // BEED.classList.add("d-none")
            // BSED.classList.add("d-none")

            BSBAS.forEach(BSBA => { BSBA.classList.add("d-none") });
            BEED.forEach(BEED => { BEED.classList.add("d-none") });
            BSITS.forEach(BSIT => { BSIT.classList.add("d-none") });
            BSEDS.forEach(BSED => { BSED.classList.add("d-none") });

        }


    }


    
</script>

</body>

</html>