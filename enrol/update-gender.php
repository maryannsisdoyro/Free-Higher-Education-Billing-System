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
    $sql = "SELECT * FROM enroll2024 WHERE application_no = '$application_no'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Extract student details
        $last_name = $row['lname'];
        $first_name = $row['fname'];
        $middle_name = $row['mname'];
        $sex = $row['gender'];
        $email = $row['email'];
    } 

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
           <form action="update-student-gender.php?application_no=<?= $_GET['application_no'] ?>" method="POST">
            <input type="hidden" name="application_no" value="<?php echo $application_no; ?>">
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" readonly name="last_name" required oninput="updateCompleteName(); capitalizeInput(this); "value="<?php echo $last_name; ?>">
                </div>
                
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" readonly name="first_name" required oninput="updateCompleteName(); capitalizeInput(this);"value="<?php echo $first_name; ?>">
                </div>
                
                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" class="form-control" id="middle_name" readonly name="middle_name" oninput="updateCompleteName(); capitalizeInput(this);"value="<?php echo $middle_name; ?>">
                </div>
                
                <div class="form-group">
                    <label for="sex">Sex: <?php echo $sex;?></label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
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
