<?php
require './db.php';
$id = $_GET['id'];
$get_enroll = $conn->query("SELECT * FROM enroll2024 WHERE id ='$id'");
$row = $get_enroll->fetch_object();
$sections = [
    'BSIT' => [
        'North',
        'East',
        'West',
        'South',
        'North East'
    ],
    'BSBA' => [

    ],
    'BSED' => [

    ],
    'BEED' => [

    ],
    'BSHM' => [
        
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Enrollment List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
    <style>
        body {
            background-color: #e0f7fa;
            /* padding: 20px; */
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
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
    <div class="container">
        <div class="form-container">
            <h2>COLLEGE APPLICATION FORM <br>2024-2025</h2>
            <form method="post">

                <div class="row g-2">
                    <input type="hidden" name="id" value="<?= $row->id ?>">

                    <div class="col-12">
                        <h4>Name: <?= $row->stu_name ?></h5>
                        <h5>Course: <?= $row->course ?> - <?= $row->section ?></h5>
                    </div>

                    <hr>

                    <div class="col-12">
                        <label for="">Student ID:</label>
                        <input type="text" class="form-control my-2" name="stu_id" placeholder="Student ID" value="<?= $row->stu_id ?>" required>
                    </div>

                    <div class="col-6">
                        <label for="">Last Name:</label>
                        <input type="text" class="form-control my-2" name="lname" placeholder="Last Name" required>
                    </div>

                    <div class="col-6">
                        <label for="">First Name:</label>
                        <input type="text" class="form-control my-2" name="fname" placeholder="First Name" required>
                    </div>

                    <div class="col-12">
                        <label for="">Middle Name:</label>
                        <input type="text" class="form-control my-2" name="mname" placeholder="Middle Name">
                    </div>

                    <div class="col-12">
                        <label for="">Email:</label>
                        <input type="email" class="form-control my-2" name="email" placeholder="Email" required>
                    </div>

                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12">Year Level:</div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="year_level" value="1st" <?= $row->section == '1st' ? 'checked' : '' ?>>
                                1st
                            </div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="year_level" value="2nd" <?= $row->section == '2nd' ? 'checked' : '' ?>>
                                2nd
                            </div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="year_level" value="3rd" <?= $row->section == '3rd' ? 'checked' : '' ?>>
                                3rd
                            </div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="year_level" value="4th" <?= $row->section == '4th' ? 'checked' : '' ?>>
                                4th
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="">Section</label>
                        <select name="section" class="form-select my-2" required>
                            <?php 
                                foreach ($sections[$row->course] as $key => $value) {
                                    ?>
                                    <option value="<?= $value ?>"><?= $value ?></option>
                                    <?php 
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12">Semester:</div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="semester" value="1st" <?= $row->semester == '1st' ? 'checked' : '' ?>>
                                1st
                            </div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="semester" value="2nd" <?= $row->semester == '2nd' ? 'checked' : '' ?>>
                                2nd
                            </div>
                            <div class="col-lg-3 col-6">
                                <input type="radio" name="semester" value="Summer" <?= $row->semester == 'Summer' ? 'checked' : '' ?>>
                                Summer
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <label for="">Academic</label>
                        <select name="academic" class="form-select my-2" required>
                            <?php 
                            $academic_query = $conn->query("SELECT * FROM academic WHERE status = 1");
                                foreach ($academic_query as $key => $value) {
                                    ?>
                                    <option value="<?= $value['year'] ?> | <?= $value['semester'] ?> Semester"><?= $value['year'] ?> | <?= $value['semester'] ?> Semester</option>
                                    <?php 
                                }
                            ?>
                        </select>
                    </div>


                    <div class="col-12 mt-3">
                        <button type="submit" name="submit" class="btn btn-submit">Submit</button>
                        <a href="./recordenroll.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $stu_id = $_POST['stu_id'];
        $fullname = strtoupper($_POST['lname'] . ' '. $_POST['fname'] . ' ' . $_POST['mname']);
        $email = $_POST['email'];
        $year_level = $_POST['year_level'];
        $section = $_POST['section'];
        $semester = $_POST['semester'];
        $academic = $_POST['academic'];
        $school_year = date('Y') . '-' . date('Y', strtotime('+1year'));

        $stmt = $conn->prepare("UPDATE enroll2024 SET year_level = ?, semester =?, curr =?, stu_name=?,email=?,academic=?,stu_id=?,section=? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $year_level, $semester, $school_year, $fullname, $email, $academic, $stu_id, $section,$id);
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Student enrollment updated successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'edit-enrollment.php?id=$id';
                    }
                });
            };
          </script>";
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>