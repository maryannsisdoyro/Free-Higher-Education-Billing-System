<!DOCTYPE html>
<html lang="en">

<?php session_start(); ?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : '' ?></title>

    <?php
    if (!isset($_SESSION['login_id']))
        header('location:login.php');
    include('./header.php');
    // include('./auth.php'); 
    ?>
    <style>
        body {
            background: #80808045;
        }

        .modal-dialog.large {
            width: 80% !important;
            max-width: unset;
        }

        .modal-dialog.mid-large {
            width: 50% !important;
            max-width: unset;
        }

        #viewer_modal .btn-close {
            position: absolute;
            z-index: 999999;
            background: unset;
            color: white;
            border: unset;
            font-size: 27px;
            top: 0;
        }

        #viewer_modal .modal-dialog {
            width: 80%;
            max-width: unset;
            height: calc(90%);
            max-height: unset;
        }

        #viewer_modal .modal-content {
            background: black;
            border: unset;
            height: calc(100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #viewer_modal img,
        #viewer_modal video {
            max-height: calc(100%);
            max-width: calc(100%);
        }

        input[type=checkbox] {
            -ms-transform: scale(1.3);
            -moz-transform: scale(1.3);
            -webkit-transform: scale(1.3);
            -o-transform: scale(1.3);
            transform: scale(1.3);
            padding: 10px;
            cursor: pointer;
        }

        @media print {
            * {
                margin: 0 !important;
                padding: 0 !important;
            }

            #controls,
            .footer,
            .footerarea {
                display: none;
            }

            html,
            body {
                height: 100%;
                overflow: hidden;
                background: #FFF;
                font-size: 9.5pt;
            }

            .dont-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }

            .card-body {
                transform: scale(0.7);
                /* Adjust this value to fit your content */
                transform-origin: top left;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <?php
    include('db_connect.php');
    $month = $_GET['month'];
    $year = $_GET['year'];
    $i = 1;
    $data = [];
                      $total = 0;
                      $payments = $conn->query("SELECT 
                      e.*,
                      e.stu_name, 
                      e.id AS stud_id,
                      e.stu_id, 
                      e.course,
                      e.year_level,
                      e.g_tot,
                      e.email,
                      e.con_no,
                      e.fname,
                      e.mname,
                      e.lname,
                      e.gender,
                      c.laboratory,
                      c.computer,
                      c.academic,
                      c.academic_nstp,
                      c.id AS course_id,
                      c.total_amount    
                      FROM 
                        enroll2024 e
                    INNER JOIN 
                        courses c ON e.course = c.department
                    ORDER BY e.lname ASC ");
                      if($payments->num_rows > 0):
			          while($row = $payments->fetch_array()):
                        // $total += $row['amount'];

                        // $get_total = $conn->query("SELECT SUM(amount) AS TOTAL FROM payments WHERE ef_id = '". $row['stud_id'] ."'");
                        // $total_payment = $get_total->fetch_assoc();
                        // $balance = $row['g_tot'] - $total_payment['TOTAL'];

                        $data[] = $row;
                      endwhile;
                    endif;

                    $courses = [
                        'BSIT' => 'Bachelor of Science in Information Technology',
                        'BSBA' => 'Bachelor of Science in Business Administration',
                        'BSHM' => 'Bachelor of Science in Hotel Management',
                        'BSED' => 'Bachelor of Secondary Education',
                        'BEED' => 'Bachelor of Elementary Education'
                   ];
    ?>

    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row mb-4 mt-4">
                <div class="col-md-12"></div>
            </div>
            <div class="row">
                <!-- FORM Panel -->

                <!-- Table Panel -->
                <div class="col-md-12">
                    <div class="mb-3">
                            <button type="button" onclick="printTable()" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                        </div>
                    <div class="card print">
                        
                        <div class="card-header dont-print d-flex justify-content-between">
                            <a href="index.php?page=payments_report" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>

                        </div>
                        <div class="card-body table-responsive" id="student-table">
                            <table id="example2" class="table table-bordered table-hover">
                                <tr>
                                    <td colspan="29" class="text-center">
                                        <p class="mt-3">Republic of the Philippines</p>
                                        <p><i>Madridejos Community College</i></p>
                                        <p><i>Bunakan, Madridejos, Cebu</i></p>
                                        <h6 class="my-4"><b>FREE HIGHER EDUCATION BILLING DETAILS</b></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <p><b>TUITION AND OTHER SCHOOL FEES(Based on Section 7, Rule II of the RA 10931)</b></p>
                                        <hr>
                                        <table class="table table-bordered" width="100%">
                                            <thead>
                                                <th>Sequence Number</th>
                                                <th>Student Number</th>
                                                <th>Learner's Number</th>
                                                <th>Last Name</th>
                                                <th>Given's Name</th>
                                                <th>Middle Name</th>
                                                
                                                <th>Degree Program</th>
                                                <th>Year Level</th>
                                                <th>Sex at birth</th>
                                                <th>E-mail Address</th>
                                                <th>Phone Number</th>
                                                <th>Laboratory Units/subject</th>
                                                <th>Computer Lab Units/subject</th>
                                                <th>Academic Units Enrolled(credit and non-credit courses)</th>
                                                <th>Academic Units of NSTP Enrolled(credit and non-credit courses)</th>
                                                <?php
                                                  $get_course = $conn->query("SELECT * FROM courses WHERE department = 'BSIT'");
                                                  $course = $get_course->fetch_assoc();
                                                // foreach ($data as $value) {
                                                  

                                                    $cfees = $conn->query("SELECT * FROM fees where course_id = '". $course['id'] ."'");
                                                    $ftotal = 0;
                                                    while ($row1 = $cfees->fetch_assoc()) {
                                                        $ftotal += $row1['amount'];
                                                    ?>
                                                        <th><b><?php echo $row1['description'] ?></b></th>
                                                    <?php
                                                    }
                                                // }
                                                ?>
                                                <th>Total TOSF</th>
                                            </thead>
                                            <?php
                                            if (count($data) > 0) {
                                                $count = 1;
                                                foreach ($data as $row) {
                                                   
                                            ?>
                                                    <tr>
                                                       <td>000<?= $row['id'] ?></td>
                                                       
                                                        <td><?= $row['stu_id'] ?></td>
                                                        <td></td>
                                                        <td><?= strtoupper($row['lname']) ?></td>
                                                        <td><?= strtoupper($row['fname']) ?></td>
                                                        <td><?= strtoupper($row['mname']) ?></td>
                                                       
                                                        <td><?= $courses[$row['course']] ?></td>
                                                        <td><?= $row['year_level'] ?></td>
                                                        <td><?= $row['gender'] ?></td>
                                                        <td><?= $row['email'] ?></td>
                                                        <td><?= $row['con_no'] ?></td>
                                                        <td><?= $row['laboratory'] ?></td>
                                                        <td><?= $row['computer'] ?></td>
                                                        <td><?= $row['academic'] ?></td>
                                                        <td><?= $row['academic_nstp'] ?></td>
                                                        <?php
                                                     
                                                     $cfees2 = $conn->query("SELECT * FROM fees f INNER JOIN courses c ON f.course_id = c.id where course_id = '". $row['course_id'] ."' AND c.level = '".$row['year_level']."' ");
                                                     $ftotal = 0;
                                                         while ($row2 = $cfees2->fetch_assoc()) {
                                                             $ftotal += $row2['amount'];
                                                             ?>
                                                                 <td class='text-right'><b><?php echo number_format($row2['amount'] ?? 0, 2) ?></b></td>
                                                             <?php
                                                         }
                                                     ?>
                                                      
                                                      
                                                        <td style="text-align: right;" colspan="<?= $count == 1 ? $cfees->num_rows + 1 : '' ?>"><?= $row['total_amount'] ?? 0 ?></td>
                                                        <?php  $count++; ?>
                                                       
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="card-footer">
                            <button type="button" onclick="printTable()" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
                <!-- Table Panel -->
            </div>
        </div>
    </div>

    <script>
        function printTable() {
            var table = document.getElementById("student-table");
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><head><title>Print</title><style>');
            newWin.document.write('table { width: 100%; border-collapse: collapse; }');
            newWin.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
            newWin.document.write('tr td { text-align: center; }');
            newWin.document.write('</style></head><body>');
            newWin.document.write(table.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.print();

        }
    </script>
</body>

</html>
