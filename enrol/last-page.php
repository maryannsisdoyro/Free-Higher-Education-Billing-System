<?php
session_start();
error_reporting(2);
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
    $row['course'] = $row['course'] == 'BS-HM' ? 'BSHM' : $row['course'];
    $course_to_be_enrolled  = $all_course[$row["course"]];
    $y_level = $row['year_level'];
    $semester = $row['semester'];
    
   
}
$row['course'] = $row['course'] == 'BS-HM' ? 'BSHM' : $row['course'];

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

        function filterResults() {
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




<div style="margin-top: 20px;" class="container" id="assessment_table">
<div style="margin-top: 20px;" class="">

<table id="example2" class="table table-bordered table-hover">
    <thead>
        <th colspan="11" style="text-align: center;">Assessment</th>
    </thead>
    <tr>
        <td colspan="5"></td>
        <td colspan="2">Units Enrolled</td>
        <td colspan="2">Rate per Unit</td>
        <td colspan="3">Total</td>
    </tr>
    <?php
    // Assuming $conn is your database connection
    $totalUnits = 0;
    $cou = $row['course'] == 'BSHM' ? 'BS-HM' : $row['course'];
    $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = '".$cou."' AND sem = '".$row['semester']."' AND year = '". $row['year_level'] ."'");

    foreach ($query as $row) :
        $totalUnits += $row['units'];
    endforeach;


    $row['course'] = $row['course'] == 'BS-HM' ? 'BSHM' : $row['course'];
    $get_course = $conn->query("SELECT * FROM courses WHERE department = '".$row["course"]."' AND semester = '". $semester ."' ");
    
//   echo $totalUnits;
    
    if ($get_course->num_rows > 0) {
        $fetch_course = $get_course->fetch_assoc();
        $fetch_course['department'] = $fetch_course['department'] == 'BSHM' ? 'BS-HM' : $fetch_course['department'];
        $total_units = $fetch_course['laboratory'] + $fetch_course['computer'] + $fetch_course['academic'] + $fetch_course['academic_nstp'];
        $cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
        $ftotal = 0;

        // $query_subjects = $conn->query("SELECT * FROM subject WHERE course = '" . $fetch_course['department'] . "' AND sem = '" . $fetch_course['semester'] . "' AND  ");

        $query_subjects = mysqli_query($conn, "SELECT * FROM subject WHERE course = '".$fetch_course['department']."' AND sem = '".$semester."' AND year = '". $fetch_course['level'] ."'");
        

        $subjects = $query_subjects->fetch_all(); // Fetch as associative array
        $total_units = 0;


        // Calculate total units
        // foreach ($subjects as $subject) {
        //     $total_units += $subject['units'];
        // }

        $tuition_based = 'Tuition Fee based on enrolled academic units (credit and non-credit courses)';
        $tuition_based2 = 'Tuition Fee based on enrolled academic units (credits non-credit courses)';
        $rate = 229.17;    
        // $subject_count = count($subjects);

        $subject_total = $totalUnits * $rate;

        echo $subject_total;

        

        while ($row = $cfees->fetch_assoc()) {
            $ftotal += $row['amount'];
            
        ?>


        <tr>
            <td colspan="2"><?= $row['description'] ?></td>
            <td colspan="5" style="text-align: center;">
                <?php
                    if ($row['description'] == $tuition_based || $row['description'] == $tuition_based2) {
                       echo number_format($totalUnits);
                    }else{
                        echo '-';
                    }
                ?>
            </td>
            <td colspan="2" style="text-align: center;">
            <?php
                    if ($row['description'] == $tuition_based || $row['description'] == $tuition_based2) {
                       echo $rate;
                    }else{
                        echo '-';
                    }
                ?>
            </td>
            <td colspan="3" style="text-align: center;">
            <?php
                    if ($row['description'] == $tuition_based && $total_units != null) {
                       echo $subject_total;
                    }else{
                        echo $row['amount'];
                    }
                ?>
            </td>
        </tr>

        <?php
        }
        ?>
        <tr>
            <td colspan="2">Grand Total</td>
            <td colspan="5" style="text-align: center;"></td>
            <td colspan="2" style="text-align: center;"></td>
            <td colspan="3" class="text-right"><b><?php echo number_format($subject_total +
$ftotal  , 2) ?></b></td>
        </tr>
        <?php
    }
    ?>
    
    
</table>
</div>
</div>

</div>
<input type="hidden" id="application_no" name="appli_no" value="<?= $id ?>">

<?= $ftotal ?>

<div class="w-100 d-flex align-items-center my-3 justify-content-end container" style="column-gap: 20px; padding-right: ;">
    <a href="student-cor.php?application_no=<?= $id ?>" class="btn btn-secondary" style="width: 100px;">Previous</a>
<a href="#" id="submit_btn" class="btn btn-danger d-block" style="width: 100px;">Submit</a>
</div>

<script>
    document.getElementById("submit_btn").addEventListener("click", function(){
        Swal.fire({
        position: "middle",
        icon: "success",
        title: "Student officially enrolled",
        showConfirmButton: false,
        timer: 3000
        }).then(() => {
            window.location.href = "final-cor.php?application_no=<?= $id ?>"
        });
    })
  
  
</script>

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
