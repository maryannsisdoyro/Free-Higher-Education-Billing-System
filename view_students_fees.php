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
    $id = $_GET['id'];
    $students = $conn->query("SELECT 
        c.course,
        c.department,
        c.description,
        c.level,
        c.laboratory,
        c.computer,
        c.academic,
        c.academic_nstp,
        c.total_amount,
        l.ef_no,
        l.total_fee,
        s.sequence_no,
        s.id_no,
        s.name,
        s.fname,
        s.lname,
        s.mname,
        s.gender,
        s.contact,
        s.address,
        s.email
    FROM
         courses c
    INNER JOIN
        student_ef_list l ON c.id = l.course_id
    INNER JOIN
        student s ON l.student_id = s.id
    WHERE 
        c.id = '$id'
    ");
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
                    <div class="card print">
                        <div class="card-header dont-print d-flex justify-content-between">
                            <a href="index.php?page=courses" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>

                        </div>
                        <div class="card-body table-responsive" id="student-table">
                            <table class="wborder">
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
                                                <th>Last Name</th>
                                                <th>Given's Name</th>
                                                <th>Middle Name</th>
                                                <th>Gender</th>
                                                <th>Degree Program</th>
                                                <th>Year Level</th>
                                                <th>E-mail Address</th>
                                                <th>Phone Number</th>
                                                <th>Laboratory Units/subject</th>
                                                <th>Computer Lab Units/subject</th>
                                                <th>Academic Units Enrolled(credit and non-credit courses)</th>
                                                <th>Academic Units of NSTP Enrolled(credit and non-credit courses)</th>
                                                <?php
                                                $cfees = $conn->query("SELECT * FROM fees where course_id = $id");
                                                $ftotal = 0;
                                                while ($row1 = $cfees->fetch_assoc()) {
                                                    $ftotal += $row1['amount'];
                                                ?>
                                                    <th><b><?php echo $row1['description'] ?></b></th>
                                                <?php
                                                }
                                                ?>
                                                <th>Total</th>
                                            </thead>
                                            <?php
                                            if ($students->num_rows > 0) {
                                                foreach ($students as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $row['sequence_no'] ?></td>
                                                        <td><?= $row['ef_no'] ?></td>
                                                        <td><?= ucfirst($row['lname']) ?></td>
                                                        <td><?= ucfirst($row['fname']) ?></td>
                                                        <td><?= ucfirst($row['mname']) ?></td>
                                                        <td><?= $row['gender'] ?></td>
                                                        <td><?= $row['course'] ?></td>
                                                        <td><?= $row['level'] ?></td>
                                                        <td><?= $row['email'] ?></td>
                                                        <td><?= $row['contact'] ?></td>
                                                        <td><?= $row['laboratory'] ?></td>
                                                        <td><?= $row['computer'] ?></td>
                                                        <td><?= $row['academic'] ?></td>
                                                        <td><?= $row['academic_nstp'] ?></td>
                                                        <?php
                                                        $cfees2 = $conn->query("SELECT * FROM fees where course_id = $id");
                                                        $ftotal2 = 0;
                                                        while ($row2 = $cfees2->fetch_assoc()) {
                                                            $ftotal2 += $row2['amount'];
                                                        ?>
                                                            <td class='text-right'><b><?php echo number_format($row2['amount'], 2) ?></b></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td><?= $row['total_fee'] ?></td>
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