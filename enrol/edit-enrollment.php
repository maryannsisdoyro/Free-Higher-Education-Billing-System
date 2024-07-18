<?php 
    require './db.php';
    $id = $_GET['id'];
    $get_enroll = $conn->query("SELECT * FROM enroll2024 WHERE id ='$id'");
    $row = $get_enroll->fetch_object();
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
            padding: 20px;
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
<div class="container">
        <div class="form-container">
            <h2>COLLEGE APPLICATION FORM <br>2024-2025</h2>
            <form method="post">
                
              <div class="row g-2">
                <input type="hidden" name="id" value="<?= $row->id ?>">
                <div class="col-lg-12">
                    <p>Name: <span class="fw-bold"><?= $row->stu_name ?></span></p>
                </div>

                <div class="col-lg-6">
                    <p>Status: <span class="fw-bold"><?= $row->stu_sta ?></span></p>
                </div>

                <div class="col-lg-6">
                    <p>Course: <span class="fw-bold"><?= $row->course ?></span></p>
                </div>

                <div class="col-lg-6">
                    <p>Major: <span class="fw-bold"><?= $row->major ?></span></p>
                </div>

                <div class="col-lg-6">
                    <p>S.Y.: <span class="fw-bold"><?= $row->curr ?></span></p>
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
                            <input type="radio" name="semester" value="2nd" <?= $row->semester == 'Summer' ? 'checked' : '' ?>>
                            Summer 
                        </div>
                      
                    </div>
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
        $year_level = $_POST['year_level'];
        $semester = $_POST['semester'];
        $school_year = date('Y') . '-' . date('Y', strtotime('+1year'));

        $stmt = $conn->prepare("UPDATE enroll2024 SET section = ?, semester =?, curr =? WHERE id = ?");
        $stmt->bind_param("sssi", $year_level, $semester, $school_year,$id);
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