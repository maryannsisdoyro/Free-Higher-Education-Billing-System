<?php 
    session_start();
    include 'db.php';

    $id = $_GET['id'];
    $stmt = $conn->query("SELECT * FROM enroll2024 WHERE id = '$id'");
    $row = $stmt->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment</title>
	<link rel="icon" type="image/x-icon" href="../assets/logo.png">
    <!-- Bootstrap CSS -->
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

    <main class="container p-3" id="view-panel" >
        <div class="form-container">
            <h2>COLLEGE APPLICATION FORM <br>2024-2025</h2>
            <form id="enrollment-form" action="update-enroll.php" method="post">

                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="lname" required oninput="updateCompleteName(); capitalizeInput(this);" value="<?= $row['lname'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="fname" required oninput="updateCompleteName(); capitalizeInput(this);" value="<?= $row['fname'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" class="form-control" id="middle_name" name="mname" oninput="updateCompleteName(); capitalizeInput(this);" value="<?= $row['mname'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="home_address">Home Address:**(Example: Brgy.Bunakan,Madridejos,Cebu)</label>
                    <input type="text" class="form-control" id="home_ad" name="home_ad" oninput="capitalizeInput(this);" value="<?= $row['home_ad'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" class="form-control" id="con_no" name="con_no" pattern="[0-9]{11}" minlength="11" maxlength="11" title="Please enter a valid 11-digit contact number" required value="<?= $row['con_no'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="sex">Sex:</label>
                    <select class="form-control" id="sex" name="gender" required>
                        <option value="">Select Sex</option>
                        <option value="Male" <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="d_birth">Date of Birth: (Date/Month/Year)  </label>
                    <input type="date" class="form-control" id="date_of_birth" name="d_birth" value="<?= date('Y-m-d', strtotime($row['d_birth'])) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $row['email'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="place_of_birth">Place of Birth:</label>
                    <input type="text" class="form-control" id="place_of_birth" name="p_birth" oninput="capitalizeInput(this);" value="<?= $row['p_birth'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="civil_status">Civil Status:</label>
                    <select class="form-control" id="civil_status" name="civil">
                        <option value="">Select Civil Status</option>
                        <option value="Single" <?= $row['civil'] == 'Single' ? 'selected' : '' ?>>Single</option>
                        <option value="Married" <?= $row['civil'] == 'Married' ? 'selected' : '' ?>>Married</option>
                        <option value="Separated" <?= $row['civil'] == 'Separated' ? 'selected' : '' ?>>Separated</option>
                        <option value="Divorced" <?= $row['civil'] == 'Divorced' ? 'selected' : '' ?>>Divorced</option>
                        <option value="Widowed" <?= $row['civil'] == 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="elementary">Elementary School:</label>
                    <input type="text" class="form-control" id="elementary" name="ele" oninput="capitalizeInput(this);" value="<?= $row['ele'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="elementary_year_graduated">Year Graduated (Elementary):</label>
                    <input type="number" class="form-control" id="elementary_year_graduated" name="ele_year" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year" value="<?= $row['ele_year'] ?>">
                </div>

                <div class="form-group">
                    <label for="high_school">High School:</label>
                    <input type="text" class="form-control" id="high_school" name="high" oninput="capitalizeInput(this);" value="<?= $row['high'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="high_school_year_graduated">Year Graduated (High School):</label>
                    <input type="number" class="form-control" id="high_school_year_graduated" name="high_year" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year" value="<?= $row['high_year'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="shs">Senior High School (SHS):</label>
                    <input type="text" class="form-control" id="shs" name="last_sc" oninput="capitalizeInput(this);" value="<?= $row['last_sc'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="shs_year_graduated">Year Graduated (SHS):</label>
                    <input type="number" class="form-control" id="shs_year_graduated" name="last_year" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year" value="<?= $row['last_year'] ?>">
                </div>
                
                <div class="form-group">
                    <label for="date_signed">Date Signed:</label>
                    <input type="date" class="form-control" id="date_signed" name="date_signed" value="<?= date('Y-m-d', strtotime($row['date_signed'])) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="course_to_be_enrolled">Course to be Enrolled:</label>
		   <select class="form-control" id="course_to_be_enrolled" name="course"  <?php $row['stud_status'] != 'shiftee' ? 'disabled' : '' ?> required>
                         <option value="">Select Course to be Enrolled</option>
                        <option value="BEED" <?= $row['course'] == 'BEED' ? 'selected' : '' ?>>BEED (Bachelor of Elementary Education)</option>
                        <option value="BSED" <?= $row['course'] == 'BSED' ? 'selected' : '' ?>>BSED (Bachelor of Secondary Education Major in Filipino)</option>
                        <option value="BSIT" <?= $row['course'] == 'BSIT' ? 'selected' : '' ?>>BSIT (Bachelor of Science in Information Technology)</option>
                        <option value="BSHM" <?= $row['course'] == 'BSHM' ? 'selected' : '' ?>>BSHM (Bachelor of Science in Hotel Management)</option>
                        <option value="BSBA" <?= $row['course'] == 'BSBA' ? 'selected' : '' ?>>BSBA (Bachelor of Science in Business Administration Major in Financial Management)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-submit">Submit</button>
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
            text: "Are you sure you want to submit the form?",
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
