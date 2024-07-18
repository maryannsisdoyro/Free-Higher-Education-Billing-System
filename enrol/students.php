<?php
include 'db.php';

$sql = "SELECT application_no, last_name, first_name, middle_name, home_address, present_address, contact, sex, date_of_birth, email, place_of_birth, civil_status, elementary, elementary_year_graduated, high_school, high_school_year_graduated, shs, shs_year_graduated, track_and_strand, complete_name, date_signed, course_to_be_enrolled FROM students WHERE status = 'Unread'";

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
    <title>Student List</title>
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
        <a href="../index.php?page=home" class="btn btn-secondary"> Back</a>
        <a href="index.php" class="btn btn-danger"> Add New +</a>

        <h2 class="my-4">COLLEGE APPLICATION FORM 2024-2025</h2>
        <div class="my-4">
            <button type="button" class="btn btn-info" onclick="RestartoPrint()">0</button>
            <button type="button" class="btn btn-danger" onclick="RestartoUnprint()">1</button>
            <a href="?export=csv" class="btn btn-success">Export to CSV</a>
            <a href="javascript:void(0);" onclick="printTable()" class="btn btn-primary">Print</a> 
            <button class="btn btn-primary" type="button" onclick="location.href='subject.php'">Subject</button>
            <button class="btn btn-primary" type="button" onclick="location.href='recordenroll.php'">Enrollment</button>
        </div>
        <div class="table-responsive">
           <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Select</th>
            <th>Application Number</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Home Address</th>
            <th>Present Address</th>
            <th>Contact</th>
            <th>Sex</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Place of Birth</th>
            <th>Civil Status</th>
            <th>Elementary</th>
            <th>Year Graduated (Elementary)</th>
            <th>High School</th>
            <th>Year Graduated (High School)</th>
            <th>SHS</th>
            <th>Year Graduated (SHS)</th>
            <th>Track and Strand</th>
            <th>Complete Name</th>
            <th>Date Signed</th>
            <th>Course to be Enrolled</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td class='text-center'><input type='checkbox' class='row_checkbox' name='selected_application[]' value='".$row["application_no"]."'></td> <!-- Checkbox -->
                        <td>".$row["application_no"]."</td>
                        <td>".$row["last_name"]."</td>
                        <td>".$row["first_name"]."</td>
                        <td>".$row["middle_name"]."</td>
                        <td>".$row["home_address"]."</td>
                        <td>".$row["present_address"]."</td>
                        <td>".$row["contact"]."</td>
                        <td>".$row["sex"]."</td>
                        <td>".$row["date_of_birth"]."</td>
                        <td>".$row["email"]."</td>
                        <td>".$row["place_of_birth"]."</td>
                        <td>".$row["civil_status"]."</td>
                        <td>".$row["elementary"]."</td>
                        <td>".$row["elementary_year_graduated"]."</td>
                        <td>".$row["high_school"]."</td>
                        <td>".$row["high_school_year_graduated"]."</td>
                        <td>".$row["shs"]."</td>
                        <td>".$row["shs_year_graduated"]."</td>
                        <td>".$row["track_and_strand"]."</td>
                        <td>".$row["complete_name"]."</td>
                        <td>".$row["date_signed"]."</td>
                        <td>".$row["course_to_be_enrolled"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='23'>No students enrolled yet</td></tr>";
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
<!-- <script>
    $(document).ready(function() {
        $(".row_checkbox").on("click", function() {
            var application_no = $(this).val(); // Get the value of the checkbox, which is the application number

            // Update status to 'Read'
            $.ajax({
                url: "resetstatus.php?application_no=" + application_no, // Corrected the URL
                type: "POST",
                data: {}, // No need to send any data in this request
                success: function() {
                    // Display confirmation dialog
                    Swal.fire({
                        title: 'COLLEGE APPLICATION FORM',
                        text: 'Print Students Reference',
                        icon: 'info',
                        showCancelButton: true,
                        showDenyButton: true, // Add showDenyButton option to show the "Edit" button
                        selectButtonText: 'Select', // Text for the "Edit" button
                        confirmButtonText: 'Print',
                        denyButtonText: 'Edit', // Text for the "Edit" button
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Open a new tab for printing
                            var printWindow = window.open("print-college.php?application_no=" + application_no, "_blank");

                            // Wait for 2 seconds before redirecting to students.php
                            setTimeout(function() {
                                // Redirect to students.php after printing
                                window.location.href = "students.php";
                            }, 2000); // 2000 milliseconds = 2 seconds
                        } else if (result.isDenied) {
                            // Redirect to the edit page
                            window.location.href = "edit-student.php?application_no=" + application_no;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred: " + error);
                }
            });
        });
    });
</script> -->
<script>
    $(document).ready(function() {
        $(".row_checkbox").on("click", function() {
            var application_no = $(this).val(); // Get the value of the checkbox, which is the application number

            // Update status to 'Read'
            $.ajax({
                url: "resetstatus.php?application_no=" + application_no, // Corrected the URL
                type: "POST",
                data: {}, // No need to send any data in this request
                success: function() {
                    // Display confirmation dialog
                    Swal.fire({
                        title: 'COLLEGE APPLICATION FORM',
                        text: 'Print Students Reference',
                        icon: 'info',
                        showCancelButton: true,
                        showDenyButton: true, // Add showDenyButton option to show the "Edit" button
                        showConfirmButton: true, // To show the confirm button
                        confirmButtonText: 'Print',
                        denyButtonText: 'Edit', // Text for the "Edit" button
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
                                window.location.href = "select-student.php?application_no=" + application_no;
                            });
                            Swal.getActions().prepend(selectButton);
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Open a new tab for printing
                            var printWindow = window.open("print-college.php?application_no=" + application_no, "_blank");

                            // Wait for 2 seconds before redirecting to students.php
                            setTimeout(function() {
                                // Redirect to students.php after printing
                                window.location.href = "students.php";
                            }, 2000); // 2000 milliseconds = 2 seconds
                        } else if (result.isDenied) {
                            // Redirect to the edit page
                            window.location.href = "edit-student.php?application_no=" + application_no;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred: " + error);
                }
            });
        });
    });
</script>

<script>
function RestartoPrint() {
    Swal.fire({
        title: 'Are you sure you want to reset all statuses to 0?',
        text: 'Confirm the reset',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the reset action via an AJAX request
            $.ajax({
                url: 'resettozero.php', // Your reset script URL
                type: 'POST', // Using POST for making changes
                success: function(response) {
                    // Show success message after successful reset
                    Swal.fire({
                        title: 'Reset!',
                        text: 'All statuses have been reset to 0.',
                        icon: 'success'
                    }).then(() => {
                        // Optional: Reload the page or redirect after confirmation
                        location.reload(); // Reloads the current page
                    });
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue resetting the statuses.',
                        icon: 'error'
                    });
                }
            });
        } else {
            // Handle cancel action
            Swal.fire({
                title: 'Cancelled',
                text: 'Your data is safe.',
                icon: 'info'
            });
        }
    });
}
</script>

<script>
function RestartoUnprint() {
    Swal.fire({
        title: 'Are you sure you want to reset all statuses to 1?',
        text: 'Confirm the reset',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the reset action via an AJAX request
            $.ajax({
                url: 'resettoone.php', // Your reset script URL
                type: 'POST', // Using POST for making changes
                success: function(response) {
                    // Show success message after successful reset
                    Swal.fire({
                        title: 'Reset!',
                        text: 'All statuses have been reset to 1.',
                        icon: 'success'
                    }).then(() => {
                        // Optional: Reload the page or redirect after confirmation
                        location.reload(); // Reloads the current page
                    });
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue resetting the statuses.',
                        icon: 'error'
                    });
                }
            });
        } else {
            // Handle cancel action
            Swal.fire({
                title: 'Cancelled',
                text: 'Your data is safe.',
                icon: 'info'
            });
        }
    });
}
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
