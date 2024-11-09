<?php
include 'db.php';
session_start();
if(!isset($_SESSION['login_id'])){
    header("location: login.php");
    }

$sql = "SELECT `id`,`application_no`,`stu_id`, `year_level`, `stu_name`, `stu_sta`, `course`, `major`, `section`, `curr`, `reli`, `con_no`, `home_ad`, `civil`, `d_birth`, `p_birth`, `ele`, `ele_year`, `high`, `high_year`, `last_sc`, `last_year`, `tot_units`, `un_enrol`, `rate_per`, `total`, `lib`, `com`, `lab1`, `lab2`, `lab3`, `sch_id`, `ath`, `adm`, `dev`, `guid`, `hand`, `entr`, `reg_fe`, `med_den`, `cul`, `t_misfe`, `g_tot`, `image` FROM `enroll2024` ";

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
    <title>Official Enrollment List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
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

    <div class="container">

        <div class="d-flex align-items-center justify-content-between">
        <h2 >Enrollment Database</h2>
        <a href="index.php" class="btn btn-danger"> Add New +</a>
        </div>
        
        <div class="my-4">
            <button type="button" class="btn btn-info" onclick="RestartoPrint()">0</button>
            <button type="button" class="btn btn-danger" onclick="RestartoUnprint()">1</button>
            <a href="?export=csv" class="btn btn-success">Export to CSV</a>
            <a href="javascript:void(0);" onclick="printTable()" class="btn btn-primary">Print</a> 
            <button class="btn btn-primary" type="button" onclick="location.href='subject.php'">Subject</button>
            <!-- <button class="btn btn-primary" type="button" onclick="location.href='students.php'">Students</button> -->
            <!--
            <button class="btn btn-primary" type="button" onclick="location.href='college-applications.php'">College of application Form </button> -->
        </div>
        <div class="table-responsive">
           <table id="example1" class="table table-bordered table-striped">
    <thead>
      
        <tr>
            <th>Select</th>
            <th>Application No.</th>
            <th>Student_ID</th>
            <th>Student Name</th>
            <th>Status</th>
            <th>Course</th>
            <th>Major</th>
            <th>Year</th>
            <th>Section</th>
            <th>Curriculum Year</th>
            <th>Religious</th>
            <th>Contact No.</th>
            <th>Home Address</th>
            <th>Civil</th>
            <th>Date of Birth</th>
            <th>Place of Birth</th>
            <th>Elementary School</th>
            <th>S.Y.</th>
            <th>High School</th>
            <th>S.Y.</th>
            <th>Last School</th>
            <th>S.Y.</th>
            <th>Totalunits</th>
            <th>UnitsEnrolled</th>
            <th>RatePerUnit</th>
            <th>Total</th>
            <th>LibraryFees</th>
            <th>ComputerFees</th>
            <th>LaboratoryFees</th>
            <th>Lab_Fees</th>
            <th>Lab_Fees</th>
            <th>School_ID</th>
            <th>AtheleticFees</th>
            <th>AdmissionFees</th>
            <th>DevelopmentFees</th>
            <th>GuidanceFees</th>
            <th>HandbookFees</th>
            <th>EntranceFees</th>
            <th>RegistrationFees</th>
            <th>Medical&DentalFees</th>
            <th>CulturalFees</th>
            <th>TotalMisce_Fees</th>
            <th>GrandTotal</th>
            
        </tr>
    </thead>
    <tbody>
        

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $year = $row["year_level"] ?? '0';
                echo "<tr>
                        <td class='text-center'><input type='checkbox' class='row_checkbox' name='selected_application[]' value='".$row["id"]."'></td> <!-- Checkbox -->
                        <td>".$row["application_no"]."</td>
                        <td>".$row["stu_id"]."</td>
                        <td>".$row["stu_name"]."</td>
                        <td>".$row["stu_sta"]."</td>
                        <td>".$row["course"]."</td>
                        <td>".$row["major"]."</td>
                        <td>".$year."</td>
                        <td>".$row["section"]."</td>
                        <td>".$row["curr"]."</td>
                        <td>".$row["reli"]."</td>
                        <td>".$row["con_no"]."</td>
                        <td>".$row["home_ad"]."</td>
                        <td>".$row["civil"]."</td>
                        <td>".$row["d_birth"]."</td>
                        <td>".$row["p_birth"]."</td>
                        <td>".$row["ele"]."</td>
                        <td>".$row["ele_year"]."</td>
                        <td>".$row["high"]."</td>
                        <td>".$row["high_year"]."</td>
                        <td>".$row["last_sc"]."</td>
                        <td>".$row["last_year"]."</td>
                        <td>".$row["tot_units"]."</td>
                        <td>".$row["un_enrol"]."</td>
                        <td>".$row["rate_per"]."</td>
                        <td>".$row["total"]."</td>
                        <td>".$row["lib"]."</td>
                        <td>".$row["com"]."</td>
                        <td>".$row["lab1"]."</td>
                        <td>".$row["lab2"]."</td>
                        <td>".$row["lab3"]."</td>
                        <td>".$row["sch_id"]."</td>
                        <td>".$row["ath"]."</td>
                        <td>".$row["adm"]."</td>
                        <td>".$row["dev"]."</td>
                        <td>".$row["guid"]."</td>
                        <td>".$row["hand"]."</td>
                        <td>".$row["entr"]."</td>
                        <td>".$row["reg_fe"]."</td>
                        <td>".$row["med_den"]."</td>
                        <td>".$row["cul"]."</td>
                        <td>".$row["t_misfe"]."</td>
                        <td>".$row["g_tot"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='23'>No Subject yet</td></tr>";
        }
        ?>
    </tbody>
</table>

        </div>
        
    </div>
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
                title: 'STUDENTS ENROLLMENT',
                text: 'Records Information',
                icon: 'info',
                showCancelButton: true,
                showDenyButton: true, // Add showDenyButton option to show the "Edit" button
                confirmButtonText: 'Enroll',
                denyButtonText: 'Delete', // Text for the "Edit" button
                cancelButtonText: 'Cancel',
                didRender: function() {
                            // Create custom "Select" button
                            const selectButton = Swal.getConfirmButton().cloneNode();
                            selectButton.style.backgroundColor = 'green'; 
                            selectButton.innerText = 'COR';
                            selectButton.classList.add('swal2-confirm', 'swal2-styled');
                            selectButton.addEventListener('click', function() {
                                Swal.close();
                                // Handle the select button click
                                console.log("Select button clicked");
                                window.location.href = "student-cor.php?application_no=" + application_no;
                            });
                            Swal.getActions().prepend(selectButton);
                        }
            }).then((result) => {
                if (result.isConfirmed) {
                     // Redirect to the edit page
                    window.location.href = "recordenroll.php?search=" + application_no;
                } else if (result.isDenied) {
                    // Redirect to the edit page
                    window.location.href = "delete-subject.php?id=" + application_no;
                }
            });
        });
    });
</script>




<script>
    // "buttons": ["copy", "excel"]
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      

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
