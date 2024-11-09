<?php 
    require './db.php';

    session_start();
if(!isset($_SESSION['login_id'])){
    header("location: login.php");
    }
    $id = $_GET['id'];
    $academic_query = $conn->query("SELECT * FROM academic WHERE id = $id");
    $academic = $academic_query->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Enrollment List</title>
<link rel="icon" type="image/x-icon" href="assets/logo.png">
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
            <h2>Create new Year and Semester</h2>
            <form method="post">
                <input type="hidden" name="id" value="<?= $academic['id'] ?>">
                
              <div class="row g-2">

                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12">Academic Year:</div>
                        <div class="col-12">
                        <input type="text" class="form-control" name="year" placeholder="0000-0000" value="<?= $academic['year'] ?>">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12">Semester:</div>
                        <div class="col-lg-3 col-6">
                            <input type="radio" name="semester" value="1st" <?= $academic['semester'] == '1st' ? 'checked' : '' ?>>
                            1st 
                        </div>
                        <div class="col-lg-3 col-6">
                            <input type="radio" name="semester" value="2nd" <?= $academic['semester'] == '2nd' ? 'checked' : '' ?>>
                            2nd 
                        </div>
                        <div class="col-lg-3 col-6">
                            <input type="radio" name="semester" value="Summer" <?= $academic['semester'] == 'Summer' ? 'checked' : '' ?>>
                            Summer 
                        </div>
                      
                    </div>
                </div>


                <div class="col-12 mt-3">
                    <button type="submit" name="submit" class="btn btn-submit">Update</button>
                    <a href="./settings.php" class="btn btn-secondary">Cancel</a>
                </div>
              </div>
               
            </form>
        </div>
    </div>

<?php 
 if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];

    $stmt = $conn->prepare("UPDATE academic SET year = ?,semester=? WHERE id = ?");
    $stmt->bind_param("ssi", $year, $semester, $id);
        if ($stmt->execute()) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Year and Semester updated successfully !!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'edit-academic.php?id=$id';
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
