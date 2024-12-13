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
$query36 = mysqli_query($conn, "SELECT * FROM enroll2024");
$row36 = mysqli_fetch_assoc($query36);
$lateststudentid = $_GET['application_no'];

// Step 2: Increment the latest student ID by 1 to get the new student ID
$newstudentid = $lateststudentid + 1;

// Step 3: Format the student ID as "2024-000X"
$formatted_studentid = $row36['stu_id'];


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

$id = $_GET['application_no'];
$get_student_enroll = $conn->query("SELECT * FROM enroll2024 WHERE id = '$id'");
$get_enroll = $get_student_enroll->fetch_object();

$all_course = [
    'BEED' => 'Bachelor of Elementary Education',
    'BSED' => 'Bachelor of Secondary Education',
    'BSIT' => 'Bachelor of Science in Information Technology',
    'BSHM' => 'Bachelor of Science in Hotel Management',
    'BSBA' => 'Bachelor of Science in Business Administration'
];

// Fetch and sanitize GET parameter stu_sta
$section_year = $get_enroll->section;
$stu_sta = $get_enroll->stu_sta;
$curr = $get_enroll->curr;
$application_no = intval($_GET['application_no']);
$query = mysqli_query($conn, "select * from enroll2024 where id='$application_no'");
$row = mysqli_fetch_assoc($query);
$numb = mysqli_num_rows($query);
// Check if record exists
if ($row) {
   
    // Retrieve data from the fetched row
    $application_no  = $row["application_no"];
    //    $last_name  = $row["last_name"];
    //    $first_name  = $row["first_name"];
    //    $middle_name  = $row["middle_name"];
    $fullname = $row['stu_name'];
    $home_address  = $row["home_ad"];
    $present_address  = "";
    $contact  = $row["con_no"];
    $sex  = "";
    // $date_of_birth  = $row["date_of_birth"];
    $date_of_birth = $row['d_birth'];
    $email  = "";
    $place_of_birth  = $row["p_birth"];
    $civil_status  = $row["civil"];
    $elementary  = $row["ele"];
    $elementary_year_graduated  = $row["ele_year"];
    $high_school  = $row["high"];
    $high_school_year_graduated  = $row["high_year"];
    $shs  = $row["last_sc"];
    $shs_year_graduated  = $row["last_year"];
    $track_and_strand  = "";
    $complete_name  = $row["stu_name"];
    
    $date_signed  = date('Y-m-d', strtotime($row["date_signed"]));
    $course_to_be_enrolled  = $all_course[$row["course"]];
    $y_level = $row['year_level'];
    $semester = $row['semester'];
    
   
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Of Registration</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">	
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

        @media print {
            .dont-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="container dont-print" style="font-size: smaller;">
        <div class="callout border-primary col-md-15 ">
            <video id="videoElement" autoplay class="hidden"></video>
            <canvas id="canvas" class="hidden"></canvas>
            <br>
            <!-- <button class="btn btn-warning" id="startButton">Take Photo</button>
            <button class="btn btn-danger hidden" id="captureButton">Capture</button> -->
          
            <a href="../index.php?page=college-application" class="btn btn-secondary">Cancel</a>


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
        document.getElementById("religiousInput").addEventListener("change", function() {
            var selectedValue = this.value;
            document.getElementById("religiousOutput").textContent = selectedValue; // Use textContent or innerHTML
            document.getElementById("religiousOutput1").value = selectedValue; // Update value property instead of textContent
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

        <div class="college-application mt-5">
            <br>
            <br>
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
                <div class="table-responsive table-responsive-data2" id="subjects_table">
                <form method="POST" class="d-flex gap-2 g-2 mb-3" style="gap: 10px; flex-wrap: wrap;">
                    <input type="text" name="time" class="form-control" style="width: 49%;" placeholder="Time">
                    <input type="text" name="day" class="form-control" style="width: 49%;" placeholder="Day">
                    <input type="text" name="subjectcode" class="form-control" style="width: 49%;" placeholder="Subject Code">
                    <input type="text" name="subdes" class="form-control" style="width: 49%;" placeholder="Sucject Description">
                    <input type="text" name="units" class="form-control" style="width: 49%;" placeholder="Units">
                    <input type="text" name="room" class="form-control" style="width: 49%;" placeholder="Room">
                    <input type="text" name="inst" class="form-control" style="width: 49%;" placeholder="Instructor">
                    <button type="submit" class="btn btn-danger">Add</button>
                </form>

               

                <table id="example2" class="table table-bordered table-hover" style="font-size: small;">
        <thead>
            <tr>
                <th class="text-center">Time</th>
                <th class="text-center">Day</th>
                <th class="text-center">Subject Code</th>
                <th class="text-center">Subject Description</th>
                <th class="text-center">Units</th>
                <th class="text-center">Room</th>
                <th class="text-center">Instructor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                //   unset($_SESSION['STUDENT_SUBJECT']);
            foreach ($_SESSION['STUDENT_SUBJECT'] as $key => $value) {
                if (isset($_GET['remove'])) {
                    if ($value['id'] == $_GET['remove']) {
                        unset($_SESSION['STUDENT_SUBJECT'][$key]);
                    }
                }
            }

            // Assuming $conn is your database connection
            $totalUnits = 0;
            $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = '".$row['course']."' AND sem = '".$row['semester']."' AND year = '". $row['year_level'] ."'");
            $subject_count = 1;
            if (!isset($_SESSION['STUDENT_SUBJECT'])) {
                $_SESSION['STUDENT_SUBJECT'] = [];
                foreach ($query as $row) :
                    $_SESSION['STUDENT_SUBJECT'][] = [
                        'id' => $subject_count++,
                        'time' => $row['tbl_time'],
                        'day' => $row['tbl_day'],
                        'subjectcode' => $row['subjectcode'],
                        'subdes' => $row['subdes'],
                        'units' => $row['units'],
                        'room' => $row['room'],
                        'inst' => $row['inst']
                    ];
                endforeach;
            }

            if (isset($_POST['time'])) {
                $last = end($_SESSION['STUDENT_SUBJECT']);
                $next_id = isset($last['id']) ? (int)$last['id'] + 1 : 1;

                var_dump($_POST);
                echo $next_id;
                $_SESSION['STUDENT_SUBJECT'][] = [
                    'id' => $next_id,
                    'time' => $value['time'],
                    'day' => $value['day'],
                    'subjectcode' => $value['subjectcode'],
                    'subdes' => $value['subdes'],
                    'units' => $value['units'],
                    'room' => $value['room'],
                    'inst' => $value['inst']
                ];
                    ?>
                    <script>
                        window.location.href = "second-page.php?application_no=<?= $_GET['application_no'] ?>
                    </script>
                    <?php 
            }

            foreach($_SESSION['STUDENT_SUBJECT'] as $stud_sub):
                $totalUnits += $stud_sub['units'];
            ?>
                <tr>
                    <td class="text-center"><?php echo htmlentities($stud_sub['time']); ?></td>
                    <td class="text-center"><?php echo htmlentities($stud_sub['day']); ?></td>
                    <td class="text-center sub-column"><?php echo htmlentities($stud_sub['subjectcode']); ?></td>
                    <td class="text-center des-column"><?php echo htmlentities($stud_sub['subdes']); ?></td>
                    <td class="text-center units-column"><?php echo htmlentities($stud_sub['units']); ?></td>
                    <td class="text-center"><?php echo htmlentities($stud_sub['room']); ?></td>
                    <td class="text-center ins-column"><?php echo htmlentities($stud_sub['inst']); ?></td>
                    <td class="text-center"><a href="?application_no=<?= $_GET['application_no'] ?>&remove=<?= htmlentities($stud_sub['id']) ?>">x</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Numbers of Units Applied: </strong></td>
                  <td class="units-column" style="text-align: center;"><strong> <?php echo number_format($totalUnits); ?></strong></td>
              
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Dispproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
</table>
                    <!--   <div class="center-images">
       <img src="r2.jpg" alt="MCC Logo" style="height: 90px; width: 800px;">
    </div> -->

                    <p style="margin-left: 120px; margin-top: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong><u style="text-transform: uppercase;">&nbsp;&nbsp; <?= strtoupper($fullname) ?>&nbsp;&nbsp;</u></strong><br>
                        <span>Student's Signature Above Printed Name</span>
                        <img src="n3.JPG" alt="MCC Logo" style="height: 80px; width: 400px; float: right;">
                    </p>



                </div>
            </div>

            <div class="w-100 d-flex align-items-center my-3 justify-content-end container" style="column-gap: 20px; padding-right: 120px;">
                <a href="student-cor.php?application_no=<?= $id ?>" class="btn btn-secondary" style="width: 100px;">Previous</a>
                <a href="last-page.php?application_no=<?= $id ?>" class="btn btn-danger d-block" style="width: 100px;" onclick="document.getElementById('final_process').classList.remove('d-none'); this.classList.add('d-none')" id="to_assessment">Next</a>
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
                    $('#TuitionFees').(function() {
                        const selectedOption = $(this).val();
                        const details = tuitionFees[<?= $row['course'] ?>];

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
  const sectionSelect = document.querySelector("select[name='section']");
  const applicationNo = document.getElementById("application_no");

if (sectionSelect) {
  sectionSelect.addEventListener('change', async function() {
    try {
      // Sending the selected value as a query parameter to the server
      const resp = await fetch(`../ajax.php?section=${this.value}&action=update_section&application_no=${applicationNo.value}`);
      
      // Checking if the response is okay
      if (!resp.ok) {
        throw new Error('Network response was not ok');
      }

      // Parsing the response as JSON (adjust depending on your response type)
      const data = await resp.json();

      // Log or handle the fetched data here
      console.log(data);
    } catch (error) {
      console.error("There was an error fetching the data:", error);
    }
  });
} else {
  console.error("Section select element not found");
}

</script>

<script>
    
    const startButton = document.getElementById('startButton');
    const captureButton = document.getElementById('captureButton');
    const video = document.getElementById('videoElement');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');

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
        document.getElementById("to_subjects").classList.remove("d-none")

         // Send the image data to the server
        try {
            const response = await fetch('../ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `image=${encodeURIComponent(dataUrl)}`
            });

            if (!response.ok) {
                throw new Error('Failed to update the image in the database.');
            }

            console.log('Image updated in the database.');
        } catch (error) {
            console.error(error);
        }
    });

  
</script>

</body>

</html> 