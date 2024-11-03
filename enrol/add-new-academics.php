<?php 
    require './db.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Enrollment List</title>
	<link rel="icon" type="image/x-icon" href="assets/logo.png">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
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
            /* padding: 10px 20px; */
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
            <h2>Create new Year and Semester</h2>
            <form method="post">
                
              <div class="row g-2">

                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12">Academic Year:</div>
                        <div class="col-12">
                        <input type="text" class="form-control" name="year" placeholder="0000-0000">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12">Semester:</div>
                        <div class="col-lg-3 col-6">
                            <input type="radio" name="semester" value="1st" checked>
                            1st 
                        </div>
                        <div class="col-lg-3 col-6">
                            <input type="radio" name="semester" value="2nd">
                            2nd 
                        </div>
                        <div class="col-lg-3 col-6">
                            <input type="radio" name="semester" value="Summer">
                            Summer 
                        </div>
                      
                    </div>
                </div>


                <div class="col-12 mt-3">
                    <button type="submit" name="submit" class="btn btn-submit">Submit</button>
                    <a href="./settings.php" class="btn btn-secondary">Cancel</a>
                </div>
              </div>
               
            </form>
        </div>

        <?php include '../footer.php' ?>
    </main>

<?php 
 if (isset($_POST['submit'])) {
    $year = $_POST['year'];
    $semester = $_POST['semester'];

    $stmt = $conn->prepare("INSERT INTO academic(year,semester) VALUES(?,?)");
    $stmt->bind_param("ss", $year, $semester);

    $check = $conn->query("SELECT * FROM academic WHERE year = '$year' AND semester = '$semester'");

    if ($check->num_rows > 0) {
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: 'Error!',
                text: 'Year and Semester already exist !!',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'home.php?page=new-academic';
                }
            });
        };
      </script>";
    }else{
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Year and Semester added successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'home.php?page=new-academic';
                    }
                });
            };
          </script>";
        }
    }
    

}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
