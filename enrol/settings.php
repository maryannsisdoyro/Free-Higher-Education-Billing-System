<?php 
    require './db.php';
    $academic_query = $conn->query("SELECT * FROM academic");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
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
    <h2>Settings</h2>
    <a href="college-applications.php" class="btn btn-secondary">Back</a>
    <a href="add-new-academics.php" class="btn btn-primary my-3">Add New +</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="example1">
            <thead>
                <th>Academics</th>
                <th>Semester</th>
                <th>Action</th>
            </thead>
            <tbody>

                <?php 
                    foreach($academic_query as $academic){
                        ?>
                        <tr>
                            <td><?= $academic['year'] ?></td>
                            <td><?= $academic['semester'] ?></td>
                            <td style="width: 100px;">
                               <?php 
                                if ($academic['status'] == 1) {
                                    ?>
                                    <a href="#" onclick="showMessage('Are you sure you want to turn off this academic?', 'question','?off&id=<?= $academic['id'] ?>')" class="btn btn-danger w-100">Off</a>
                                    <?php
                                }else{
                                    ?>
                                    <a href="#" onclick="showMessage('Are you sure you want to turn on this academic?', 'question','?on&id=<?= $academic['id'] ?>')" class="btn btn-primary w-100">On</a>
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

<?php 
 if (isset($_GET['off'])) {
    $id = $_GET['id'];
    $status = 2;
    $stmt = $conn->prepare("UPDATE academic SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status,$id);
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Year and Semester turned off successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'settings.php';
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
    $stmt->bind_param("ii", $status,$id);
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Year and Semester turned on successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'settings.php';
                    }
                });
            };
          </script>";
        }
    

}
?>
</body>
</html> 