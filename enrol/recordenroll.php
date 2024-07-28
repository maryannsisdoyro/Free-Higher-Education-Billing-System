<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Enrollment List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <div class="container">

        <h2 class="my-4 text-center">Enrollment List</h2>

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
            <form method="get" class="d-flex align-items-center mx-auto" style="gap: 10px; width: 500px;">
                <input type="search" class="form-control my-2" name="search" placeholder="Student ID">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

        </div>
        <div>
          
        <?php require 're-enroll.php' ?>

        </div>

    </div>
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
