<?php
session_start();
include 'db.php';

if (isset($_POST['search'])) {
    header('location: home.php?page=enrol&search='. $_POST['search']);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Enrollment List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        .container {
            max-width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

<?php include './topbar.php' ?>
	<?php include './navbar.php' ?>

    <main id="view-panel" class="container p-3 position-relative overflow-hidden" style="min-height: 70vh;">

        <h2 class="my-4 text-center">Enrol Student</h2>

        <?php
        $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1");
        $academic = $get_academic->fetch_assoc();
        ?>

        <div class=" text-center">
            <h5>A . Y <?= $academic['year'] ?></h5>
            <p class="fs-5"><?= $academic['semester'] ?> Semester</p>
        </div>
        <div class="mt-3 mb-5 ">
            <!-- <a href="?export=csv" class="btn btn-success">Export to CSV</a> -->
            <!-- <a href="college-applications.php" class="btn btn-primary">Back</a> -->
            <form method="post" action="home.php?page=enrol" class="d-flex align-items-center mx-auto" style="gap: 10px; width: 500px;">
                <input type="search" class="form-control my-2" name="search" placeholder="Student ID">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

        </div>
        <div>
          
        <?php require 're-enroll.php' ?>

        </div>

        <div class="position-absolute bottom-0 my-auto w-100 overflow-hidden">
        <?php include '../footer.php' ?>
        </div>

    </main>
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <?php
    if (isset($_POST['submit'])) {
        $stu_id = $_POST['stu_id'];
        $year_level = $_POST['year_level'];
        $section = $_POST['section'];
        $semester = $_POST['semester'];
        $academic = $_POST['academic'];

        $stmt = $conn->prepare("UPDATE enroll2024 SET year_level = ?, section=?, semester=?, academic=? WHERE stu_id = ?");
        $stmt->bind_param("sssss", $year_level, $section, $semester, $academic, $stu_id);

        if ($stmt->execute()) {
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Student enrolled successfully !!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'recordenroll.php';
                        }
                    });
                };
              </script>";
        }
    }
    ?>

</body>

</html>
