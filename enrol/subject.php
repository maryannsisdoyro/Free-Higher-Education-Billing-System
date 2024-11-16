<?php
session_start();
include 'db.php';
$get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
$res_academic = $get_academic->fetch_array();
$academic_year = $res_academic['year'];
$semester_academic = $res_academic['semester'];
$sql = "SELECT `id`, `sem`,`year`, `course`,  `tbl_time`, `tbl_day`, `subjectcode`, `prerequi`, `subdes`, `units`, `room`, `inst` FROM `subject` ORDER BY course,sem,year ASC";

$result = $conn->query($sql);

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ",") {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    $f = fopen('php://output', 'w');

    fputcsv($f, array_keys($array[0]), $delimiter);

    
    foreach ($array as $row) {
        fputcsv($f, $row, $delimiter);
    }
    fclose($f);
    exit();
}

if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    array_to_csv_download($data, 'student_list.csv');
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
        th, td {
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

    <main class="container p-3" id="view-panel">

        <h2 class="mb-4">Subject Load</h2>
        <div class="my-4">
             <a href="addsub.php" class="btn btn-success">Add</a>
            <a href="../index.php?page=college-application" class="btn btn-secondary">Cancel</a>
        </div>
        <div class="table-responsive">
           <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Select</th>
            <th>Course</th>
            <th>Year</th>
            <th>Semester</th>
            
            <th>Time</th>
            <th>Day</th>
            <th>Subject Code</th>
            <th>Subject Description</th>
            <th>Pre-Prequites</th>
            <th>Units</th>
            <th>Room</th>
            <th>Instructor</th>
        </tr>
    </thead>
    <tbody>
       <!--  SELECT `id`, `sem`, `year`, `course`, `time`, `day`, `subjectcode`, `subdes`, `prerequi`, `units`, `room`, `strand` FROM `subject` WHERE 1 -->
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                if($semester_academic  == $row['sem']):
                echo "<tr>
                        <td class='text-center'><input type='checkbox' class='row_checkbox' name='selected_application[]' value='".$row["id"]."'></td> <!-- Checkbox -->
                        <td>".$row["course"]."</td>
                        <td>".$row["year"]."</td>
                        <td>".$row["sem"]."</td>
                        <td>".$row["tbl_time"]."</td>
                        <td>".$row["tbl_day"]."</td>
                        <td>".$row["subjectcode"]."</td>
                        <td>".$row["subdes"]."</td>
                        <td>".$row["prerequi"]."</td>
                        <td>".$row["units"]."</td>
                        <td>".$row["room"]."</td>
                        <td>".$row["inst"]."</td>
                      </tr>";
                endif;
            }
        } else {
            echo "<tr><td colspan='23'>No Subject yet</td></tr>";
        }
        ?>
    </tbody>
</table>

        </div>
        <?php include '../footer.php' ?>
    </main>
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-1BmE4k2HxZbAUot0H8VW4+nH6HiQoTCtVhjx2Ks11P+3pFb6PI8qzWJ5KqL5vmHH" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+EW0PA/Nk5O2AWK3xFPrDh4Ta1gYhT3Y2vo" crossorigin="anonymous"></script>

    <script>
        function printTable() {
            var table = document.getElementById("student-table");
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><head><title>Print</title></head><body>');
            newWin.document.write(table.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.print();
        }
    </script>


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
<script src="dist/js/adminlte.min.js"></script>
<script>
    $(document).ready(function() {
        $(".row_checkbox").on("click", function() {
            var application_no = $(this).val(); // Get the value of the checkbox, which is the application number

            // Display confirmation dialog
            Swal.fire({
                title: 'SUBJECT DATA',
                text: 'Records Information',
                icon: 'info',
                showCancelButton: true,
                showDenyButton: true, // Add showDenyButton option to show the "Edit" button
                confirmButtonText: 'Edit',
                denyButtonText: 'Delete', // Text for the "Edit" button
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                     // Redirect to the edit page
                    window.location.href = "home.php?page=edit-subject&id=" + application_no;
                } else if (result.isDenied) {
                    // Redirect to the edit page
                    window.location.href = "deleteSub.php?id=" + application_no;
                }
            });
        });
    });
</script>




<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
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
<script>
  $(document).ready(function(){
    $('#list').dataTable()
  
 
  })
 
</script>
</body>
</html>
