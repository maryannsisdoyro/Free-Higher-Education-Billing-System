<?php
require './db.php';
session_start();
$academic_query = $conn->query("SELECT * FROM academic");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }


        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>


    <?php include './topbar.php' ?>
	<?php include './navbar.php' ?>
    <main class="container p-3" id="view-panel">
    <?php 
        $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
        $res_academic = $get_academic->fetch_array();
    ?>

        <h3>Academic School Year  <?= $res_academic['year'] ?? '0000-0000' ?>  |  <?= $res_academic['semester'] ?? '0' ?> Semester</h3>
        
        <p class="my-3">Add New</p>
        <!-- <a href="college-applications.php" class="btn btn-secondary">Back</a> -->
        <h5>Create New Year & Semester</h5>
        <a href="add-new-academics.php" class="btn btn-primary my-3">Create</a>

       <div class="row">
        <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="example1">
                <thead>
                    <th>Academics</th>
                    <th>Semester</th>
                    <th>Action</th>
                </thead>
                <tbody>

                    <?php
                    foreach ($academic_query as $academic) {
                    ?>
                        <tr>
                            <td><?= $academic['year'] ?></td>
                            <td><?= $academic['semester'] ?></td>
                            <td style="width: 100px;">

                                <?php
                                if ($academic['status'] == 1) {
                                ?>
                                    <a href="#" onclick="showMessage('Are you sure you want to turn off this academic?', 'question','home.php?page=settings&off&id=<?= $academic['id'] ?>')">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </a>
                                <?php
                                } else {
                                ?>
                                    <a href="#" onclick="showMessage('Are you sure you want to turn on this academic?', 'question','home.php?page=settings&on&id=<?= $academic['id'] ?>')">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
        </div>

        <div class="col-lg-6 mt-5">
        <div>
            <h5>Change Password</h5>
            <form method="post">
                <label for="">New Password</label>
                <input type="text" name="new" class="form-control my-2">
                <label for="">Confirm Password</label>
                <input type="text" name="confirm" class="form-control my-2">
                <button type="submit" name="change" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
        </div>

       </div>

       <?php include '../footer.php' ?>

    </main>
    

    <!-- <script src="plugins2/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap 4 -->
    <!-- <script src="plugins2/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- DataTables  & Plugins -->
    <!-- <script src="plugins2/datatables/jquery.dataTables.min.js"></script> -->
    <!-- <script src="plugins2/datatables-bs4/js/dataTables.bootstrap4.min.js"></script> -->
    <!-- <script src="plugins2/datatables-responsive/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="plugins2/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
    <!-- <script src="plugins2/datatables-buttons/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="plugins2/datatables-buttons/js/buttons.bootstrap4.min.js"></script> -->
    <!-- <script src="plugins2/jszip/jszip.min.js"></script> -->
    <!-- <script src="plugins2/pdfmake/pdfmake.min.js"></script> -->
    <!-- <script src="plugins2/pdfmake/vfs_fonts.js"></script> -->
    <!-- <script src="plugins2/datatables-buttons/js/buttons.html5.min.js"></script> -->
    <!-- <script src="plugins2/datatables-buttons/js/buttons.print.min.js"></script> -->
    <!-- <script src="plugins2/datatables-buttons/js/buttons.colVis.min.js"></script> -->
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        function showMessage(x, y, z) {
            Swal.fire({
                title: `<strong> ${x} </strong>`,
                icon: y,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: `Yes`,
                confirmButtonColor: "#0d6efd",
                cancelButtonText: `No`,
                iconColor: '#0d6efd',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = z
                } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = "home.php?page=settings";
        }
            });
        }
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                /*  "buttons": ["copy", "excel", "pdf"]*/

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <?php
    if (isset($_GET['off'])) {
        $id = $_GET['id'];
        $status = 2;
        $stmt = $conn->prepare("UPDATE academic SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Year and Semester turned off successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'home.php?page=settings';
                    }
                });
            };
          </script>";
        }
    }

    if (isset($_GET['on'])) {
        $id = $_GET['id'];
        $status = 1;
        $stmt = $conn->prepare("UPDATE academic SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Year and Semester turned on successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'home.php?page=settings';
                    }
                });
            };
          </script>";
        }
    }

    if (isset($_POST['change'])) {
        $new = $_POST['new'];
        $confirm = $_POST['confirm'];

        if (strlen($new) < 8) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Password must not be less than 8 characters !!',
                    icon: 'error'
                });
            };
          </script>";
        }else if ($new != $confirm) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Password don\'t match!!',
                    icon: 'error'
                });
            };
          </script>";
        }else{
            $hashed = md5($new);
            $userId = $_SESSION['login_id'];

            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param('si', $hashed, $userId);

            if ($stmt->execute()) {
                echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Password changed successfully!!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'home.php?page=settings';
                        }
                    });
                };
              </script>";
            }

        }

    }
    ?>
</body>

</html>
