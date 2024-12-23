<?php
// Include database connection
include 'db.php';
session_start();
if(!isset($_SESSION['login_id'])){
    header("location: login.php");
    }

// Check if application_no is provided in the URL
if (isset($_GET['application_no'])) {
    $application_no = $_GET['application_no'];

    // Fetch student details from database based on application_no
    $sql = "SELECT * FROM students WHERE application_no = '$application_no'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Extract student details
        $last_name = $row['last_name'];
        $first_name = $row['first_name'];
        $middle_name = $row['middle_name'];
        $home_address = $row['home_address'];
        $present_address = $row['present_address'];
        $contact = $row['contact'];
        $sex = $row['sex'];
         $date_of_birth = date('F j, Y', strtotime($row['date_of_birth']));
        $email = $row['email'];
        $place_of_birth = $row['place_of_birth'];
        $civil_status = $row['civil_status'];
        $elementary = $row['elementary'];
        $elementary_year_graduated = $row['elementary_year_graduated'];
        $high_school = $row['high_school'];
        $high_school_year_graduated = $row['high_school_year_graduated'];
        $shs = $row['shs'];
        $shs_year_graduated = $row['shs_year_graduated'];
        $track_and_strand = $row['track_and_strand'];
        $complete_name = $row['complete_name'];
        $date_signed = $row['date_signed'];
        $course_to_be_enrolled = $row['course_to_be_enrolled'];
    } else {
        // If no student found, redirect back to students.php or handle error as needed
        header('Location: students.php');
        exit();
    }
} else {
    // If application_no is not provided in URL, redirect back to students.php or handle error as needed
    header('Location: students.php');
    exit();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment</title>
    <!-- Bootstrap CSS -->
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="../assets/DataTables/datatables.min.css" rel="stylesheet">
  <link href="../assets/css/jquery.datetimepicker.min.css" rel="stylesheet">
  <link href="../assets/css/select2.min.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="../assets/css/jquery-te-1.4.0.css">
  
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/DataTables/datatables.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/venobox/venobox.min.js"></script>
  <script src="../assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="../assets/vendor/counterup/counterup.min.js"></script>
  <script src="../assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../assets/js/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="../assets/font-awesome/js/all.min.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <style>
        body {
            background-color: #dcdcdc;
            /* padding: 20px; */
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: 600;
        }
        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include './topbar.php' ?>
	<?php include './navbar.php' ?>
    <main class="container p-3" id="view-panel">
        <div class="form-container">
            <h2>EDIT INFORMATION<br>COLLEGE APPLICATION FORM <br>2024-2025</h2>
           <form action="update-student.php" method="POST">
            <input type="hidden" name="application_no" value="<?php echo $application_no; ?>">
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required oninput="updateCompleteName(); capitalizeInput(this); "value="<?php echo $last_name; ?>">
                </div>
                
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required oninput="updateCompleteName(); capitalizeInput(this);"value="<?php echo $first_name; ?>">
                </div>
                
                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" oninput="updateCompleteName(); capitalizeInput(this);"value="<?php echo $middle_name; ?>">
                </div>
                
                <div class="form-group">
                    <label for="home_address">Home Address:</label>
                    <input type="text" class="form-control" id="home_address" name="home_address" oninput="capitalizeInput(this);"value="<?php echo $home_address; ?>"value="<?php echo $present_address;?>">
                </div>
                
                <div class="form-group">
                    <label for="present_address">Present Address:</label>
                    <input type="text" class="form-control" id="present_address" name="present_address" oninput="capitalizeInput(this);"value="<?php echo $present_address;?>">
                </div>
                
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="number" class="form-control" id="contact" name="contact" pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number" required value="<?php echo $contact;?>">
                </div>
                
                <div class="form-group">
                    <label for="sex">Sex: <?php echo $sex;?></label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth: (Date/Month/Year)  <?php echo $date_of_birth;?> </label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email;?>">
                </div>
                
                <div class="form-group">
                    <label for="place_of_birth">Place of Birth:</label>
                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" oninput="capitalizeInput(this);" value="<?php echo $place_of_birth;?>">
                </div>
                
                <div class="form-group">
                    <label for="civil_status">Civil Status: <?php echo $civil_status;?> </label>
                    <select class="form-control" id="civil_status" name="civil_status">
                        <option value="">Select Civil Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Separated">Separated</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="elementary">Elementary School:</label>
                    <input type="text" class="form-control" id="elementary" name="elementary" oninput="capitalizeInput(this);"value="<?php echo $elementary;?>">
                </div>
                
                <div class="form-group">
                    <label for="elementary_year_graduated">Year Graduated (Elementary):</label>
                    <input type="number" class="form-control" value="<?php echo $elementary_year_graduated;?>"   id="elementary_year_graduated" name="elementary_year_graduated" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year">
                </div>

                <div class="form-group">
                    <label for="high_school">High School:</label>
                    <input type="text" class="form-control" id="high_school" name="high_school" oninput="capitalizeInput(this);"value="<?php echo $high_school;?>">
                </div>
                
                <div class="form-group">
                    <label for="high_school_year_graduated">Year Graduated (High School):</label>
                    <input type="number" class="form-control" value="<?php echo $high_school_year_graduated;?>"id="high_school_year_graduated" name="high_school_year_graduated" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year">
                </div>
                
                <div class="form-group">
                    <label for="shs">Senior High School (SHS):</label>
                    <input type="text" class="form-control" id="shs" name="shs" oninput="capitalizeInput(this);"value="<?php echo $shs;?>">
                </div>
                
                <div class="form-group">
                    <label for="shs_year_graduated">Year Graduated (SHS):</label>
                    <input type="number" class="form-control" value="<?php echo $shs_year_graduated;?>" id="shs_year_graduated" name="shs_year_graduated" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year">
                </div>
                
                <div class="form-group">
                    <label for="track_and_strand">Track and Strand: <?php echo $track_and_strand;?></label>
                    <select class="form-control" id="track_and_strand" name="track_and_strand" onchange="showInput()">
                        <option value="">Select Track and Strand</option>
                        <option value="ABM">ABM (Accountancy, Business, and Management)</option>
                        <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                        <option value="TVL">TVL (Technical-Vocational-Livelihood)</option>
                        <option value="STEM">STEM (Science, Technology, Engineering, and Mathematics)</option>
                        <option value="Others">Others</option>
                    </select>
                    <br>
                    <div id="otherInput" style="display: none;">
                     <input type="text" class="form-control" id="otherTrackStrand" name="otherTrackStrand" placeholder="Please specify">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="complete_name">Complete Name:</label>
                    <input type="text" class="form-control" id="complete_name" name="complete_name" value="<?php echo $complete_name;?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="date_signed">Date Signed:</label>
                    <input type="date" class="form-control" id="date_signed" name="date_signed" required>
                </div>
                
                <div class="form-group">
                    <label for="course_to_be_enrolled">Course to be Enrolled:</label>
                    <select class="form-control" id="course_to_be_enrolled" name="course_to_be_enrolled" required>
                        <option value="">Select Course to be Enrolled</option>
                        <option value="Bachelor of Elementary Education">BEED (Bachelor of Elementary Education)</option>
                        <option value="Bachelor of Secondary Education">BSED (Bachelor of Secondary Education Major in Filipino)</option>
                        <option value="Bachelor of Science in Information Technology">BSIT (Bachelor of Science in Information Technology)</option>
                        <option value="Bachelor of Science in Hotel Management">BSHM (Bachelor of Science in Hotel Management)</option>
                        <option value="Bachelor of Science in Business Administration">BSBA (Bachelor of Science in Business Administration Major in Financial Management)</option>
                    </select>
                </div>
                
                 <button type="submit" class="btn btn-primary">Update</button>
            <a href="students.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>

        <?php include '../footer.php' ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-1BmE4k2HxZbAUot0H8VW4+nH6HiQoTCtVhjx2Ks11P+3pFb6PI8qzWJ5KqL5vmHH" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+EW0PA/Nk5O2AWK3xFPrDh4Ta1gYhT3Y2vo" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.all.min.js"></script>
   
    <script>
    // Get current date in yyyy-mm-dd format
    function getCurrentDate() {
        const now = new Date();
        const year = now.getFullYear();
        let month = now.getMonth() + 1;
        let day = now.getDate();

        // Ensure month and day are two digits
        if (month < 10) {
            month = '0' + month;
        }
        if (day < 10) {
            day = '0' + day;
        }

        return `${year}-${month}-${day}`;
    }

    // Set today's date as the default value for the input
    document.getElementById('date_signed').  value = getCurrentDate();
</script>
    <script>
    function updateCompleteName() {
        const firstName = document.getElementById('first_name').value.trim().toUpperCase();
        const middleName = document.getElementById('middle_name').value.trim().toUpperCase();
        const lastName = document.getElementById('last_name').value.trim().toUpperCase();
        const completeName = `${lastName} ${firstName} ${middleName}`.trim().replace(/\s+/g, ' ');
        document.getElementById('complete_name').value = completeName;
    }

    function capitalizeInput(element) {
        const words = element.value.split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
        }
        element.value = words.join(' ');
    }

    function uppercaseFieldsBeforeSubmit() {
        const firstName = document.getElementById('first_name');
        const middleName = document.getElementById('middle_name');
        const lastName = document.getElementById('last_name');

        firstName.value = firstName.value.toUpperCase();
        middleName.value = middleName.value.toUpperCase();
        lastName.value = lastName.value.toUpperCase();
    }

    function setMaxDate() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date_of_birth').setAttribute('max', today);
        document.getElementById('date_signed').setAttribute('max', today);
    }

    document.addEventListener('DOMContentLoaded', setMaxDate);

    document.getElementById('enrollment-form').addEventListener('submit', function(event) {
        event.preventDefault();

        uppercaseFieldsBeforeSubmit();

        Swal.fire({
            title: 'Confirm Submission',
            text: "Are you sure you want to update the form?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
   
    <script>
    function showInput() {
        var selectBox = document.getElementById("track_and_strand");
        var userInput = document.getElementById("otherInput");
        if (selectBox.value === "Others") {
            userInput.style.display = "block";
        } else {
            userInput.style.display = "none";
        }
    }
</script>

</body>
</html>
