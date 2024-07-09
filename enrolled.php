<?php
include 'db_connect.php';

$sql = "SELECT application_no, last_name, first_name, middle_name, home_address, present_address, contact, sex, date_of_birth, email, place_of_birth, civil_status, elementary, elementary_year_graduated, high_school, high_school_year_graduated, shs, shs_year_graduated, track_and_strand, complete_name, date_signed, course_to_be_enrolled FROM student_enroll";
$result = $conn->query($sql);

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ",")
{
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
        <h2 class="my-4">COLLEGE APPLICATION REFERENCE 2024-2025</h2>
        <div class="my-4">
            <a href="?export=csv" class="btn btn-success">Export to CSV</a>
            <a href="javascript:void(0);" onclick="printTable()" class="btn btn-primary ml-2">Print</a> <!-- JavaScript print -->
            <span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_enroll">
                    <i class="fa fa-plus"></i> New
                </a></span>
        </div>
        <div class="table-responsive">
            <table id="student-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
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
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["application_no"] . "</td>
                                    <td>" . $row["last_name"] . "</td>
                                    <td>" . $row["first_name"] . "</td>
                                    <td>" . $row["middle_name"] . "</td>
                                    <td>" . $row["home_address"] . "</td>
                                    <td>" . $row["present_address"] . "</td>
                                    <td>" . $row["contact"] . "</td>
                                    <td>" . $row["sex"] . "</td>
                                    <td>" . $row["date_of_birth"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["place_of_birth"] . "</td>
                                    <td>" . $row["civil_status"] . "</td>
                                    <td>" . $row["elementary"] . "</td>
                                    <td>" . $row["elementary_year_graduated"] . "</td>
                                    <td>" . $row["high_school"] . "</td>
                                    <td>" . $row["high_school_year_graduated"] . "</td>
                                    <td>" . $row["shs"] . "</td>
                                    <td>" . $row["shs_year_graduated"] . "</td>
                                    <td>" . $row["track_and_strand"] . "</td>
                                    <td>" . $row["complete_name"] . "</td>
                                    <td>" . $row["date_signed"] . "</td>
                                    <td>" . $row["course_to_be_enrolled"] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='22'>No students enrolled yet</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-1BmE4k2HxZbAUot0H8VW4+nH6HiQoTCtVhjx2Ks11P+3pFb6PI8qzWJ5KqL5vmHH" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+EW0PA/Nk5O2AWK3xFPrDh4Ta1gYhT3Y2vo" crossorigin="anonymous"></script>



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

    <script>
        $('#new_enroll').click(function() {
            uni_modal("New Enroll ", "enrollment.php", "mid-large")

        })
        $(document).ready(function(){
		$('table').dataTable()
	})
    </script>
</body>

</html>