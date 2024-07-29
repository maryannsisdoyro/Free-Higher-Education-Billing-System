<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <!-- AdminLTE App -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
            <h2>Add Subject</h2>
            <form id="Subjectform" action="savesub.php" method="post">
                
                <div class="form-group">
                    <label for="Semester">Semester</label>
                    <select class="form-control" id="Semester" name="Semester" required>
                        <option value="">Select Semester</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="Summer">Summer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="year">Subject Year</label>
                    <select class="form-control" id="Year" name="Year" required>
                        <option value="">Select Year</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                </div>
               
                <div class="form-group">
                     <label for="Course">Course</label>
                    <select class="form-control" id="Course" name="Course" required>
                        <option value="">Select Course</option>
                        <option value="BEED">BEED</option>
                        <option value="BSED">BSED</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BS-HM">BSHM</option>
                        <option value="BSBA">BSBA</option>
                    </select>
                </div>
                
              <div class="form-group">
               <div class="form-group">
                  <label for="Time">Time Range (Format: 1:00-2:00)</label>
                  <input type="text" class="form-control" id="Time" name="Time" 
                    pattern="^\d{1,2}:\d{2}-\d{1,2}:\d{2}$" 
                    title="Please enter time range in example format '1:00-2:00'" 
                    placeholder="Enter time range (e.g., 1:00-2:00)" required>
              </div>
                   
               </div>
                <div class="form-group">
                    <label for="Day">Day</label>
                     <select class="form-control" id="Day" name="Day" required>
                        <option value="">Select Day</option>
                        <option value="MWF">MWF</option>
                        <option value="TTH">TTH</option>
                        <option value="MW">MW</option>
                        <option value="WED">WED</option>
                        <option value="THU">THU</option>
                        <option value="FRI">FRI</option>
                        <option value="SAT">SAT</option>
                       
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="Subjectcode">Subject Code</label>
                    <input type="text" class="form-control" id="Subjectcode" name="Subjectcode"required  oninput="updatesubjectUPPER(this);">
                </div>
                
                <div class="form-group">
                    <label for="Subjectdes">Subject Description</label>
                    <input type="text" class="form-control" id="Subjectdes" name="Subjectdes"required  oninput="updatesubjectUPPER(this);">
                </div>
                
                <div class="form-group">
                    <label for="Prerequi">Pre-Requisites/s</label>
                    <input type="text" class="form-control" id="Prerequi" name="Prerequi"required oninput="updatesubjectUPPER(this);">
                </div>
                 <!--  SELECT `id`, `sem`, `year`, `course`, `time`, `day`, `subjectcode`, `subdes`, `prerequi`, `units`, `room`, `strand` FROM `subject` WHERE 1 -->
                <div class="form-group">
                    <label for="Units">Units</label>
                    <input type="text" class="form-control" id="Units" name="Units" required>
                </div>
                
                <div class="form-group">
                    <label for="Room">Room</label>
                    <input type="text" class="form-control" id="Room" name="Room" required oninput="updatesubjectUPPER(this);">
                </div>      
                   <div class="form-group">
                    <label for="Instructor">Instructor</label>
                    <input type="text" class="form-control" id="Instructor" name="Instructor" required oninput="updatesubjectUPPER(this);">
                </div>     
                 <button type="submit" class="btn btn-primary">Save</button>
                <a href="home.php?page=subjects" class="btn btn-secondary">Cancel</a>
                
            </form>
        </div>

        <?php include '../footer.php' ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-1BmE4k2HxZbAUot0H8VW4+nH6HiQoTCtVhjx2Ks11P+3pFb6PI8qzWJ5KqL5vmHH" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+EW0PA/Nk5O2AWK3xFPrDh4Ta1gYhT3Y2vo" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.all.min.js"></script>
    <script>
    function updatesubjectUPPER(input) {
        input.value = input.value.toUpperCase();
    }
   </script>

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
     
    // Function to capitalize input fields
    function capitalizeInput(element) {
        const words = element.value.split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
        }
        element.value = words.join(' ');
    }

    // Event listener for form submission
    document.getElementById('Subjectform').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Capitalize input fields before submission (if needed)
        // capitalizeInput(document.getElementById('your_input_field_id'));

        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Confirm Submission',
            text: "Are you sure you want to saved this record?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, saved it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                this.submit(); // 'this' refers to the form element
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
