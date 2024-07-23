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

        <h2 class="my-4">Enrollment List 2024-2025</h2>
        <div class="my-4 ">
             <!-- <a href="?export=csv" class="btn btn-success">Export to CSV</a> -->
            <!-- <a href="college-applications.php" class="btn btn-primary">Back</a> -->
            <form method="get" class="d-flex align-items-center ms-auto" style="gap: 10px; width: 500px;">
                <input type="search" class="form-control my-2" name="search" placeholder="Student ID">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

        </div>
        <div >
        <?php
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM enroll2024 WHERE stu_id = '$search' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                 <form action="" method="post">
                    <input type="hidden" name="stu_id" value="<?= $row['stu_id'] ?>">
                    <h5>Add Student</h5>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="fs-5"><?= $row['curr'] ?></p>
                            <h3><?= $row['stu_name'] ?></h3>
                            <p><?= $row['email'] ?></p>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Select Year Level</label>
                            <select name="year_level" class="form-select my-3" required>
                                <option value="" selected disabled>Select Year Level</option>
                                <option value="1st">1st Year</option>
                                <option value="2nd">2nd Year</option>
                                <option value="3rd">3rd Year</option>
                                <option value="4th">4th Year</option>
                            </select>
                            <label for="">Select Section</label>
                            <select name="section" class="form-select my-3" required>
                                <option value="" selected disabled>Select Section</option>
                                <option value="North">North</option>
                                <option value="North East">North East</option>
                                <option value="East">East</option>
                                <option value="West">West</option>
                                <option value="South">South</option>
                                <option value="South East">South East</option>
                            </select>
                            <label for="">First Semester</label>
                            <select name="semester" class="form-select my-3" required>
                                <option value="" selected disabled>Select Semester</option>
                                <option value="1st">1st Semester</option>
                                <option value="2nd">2nd Semester</option>
                                <option value="Summer">Summer Semester</option>
                            </select>
                            <label for="">Academic</label>
                            <select name="academic" class="form-select my-3" required>
                                <option value="" selected disabled>Select Academic</option>
                                <?php 
                                    $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1");
                                    if ($get_academic->num_rows > 0) {
                                        foreach ($get_academic as $academic) {
                                            ?>
                                                <option value="<?= $academic['id'] ?>"><?= $academic['year'] ?> | <?= $academic['semester'] ?></option>
                                            <?php 
                                        }
                                    }
                                ?>
                            </select>

                            <button type="submit" name="submit" class="btn btn-primary px-5">Enroll</button>
                        </div>
                    </div>
                 </form>
                <?php 

             } else {
                 echo "No record found";
             }

             $conn->close();
        }
        ?>

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
