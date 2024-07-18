<?php
include 'db.php';

$application_no = '1'; // Example application number

// Fetch student data
$sql = "SELECT application_no, last_name, first_name, middle_name, home_address, present_address, contact, sex, date_of_birth, email, place_of_birth, civil_status, elementary, elementary_year_graduated, high_school, high_school_year_graduated, shs, shs_year_graduated, track_and_strand, complete_name, date_signed, course_to_be_enrolled FROM students WHERE application_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $application_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    $student = null;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Application Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2, h3 {
            color: #ffffff;
        }
        .table {
            background-color: #1a1a1a;
            border: 1px solid #ffffff;
        }
        .table th {
            border: 1px solid #ffffff;
            background-color: #333333;
            color: #00ccff;
        }
        .table td {
            border: 1px solid #ffffff;
            background-color: #1a1a1a;
            color: #ffffff;
        }
        .declaration p, .program p, .interview p {
            background-color: #1a1a1a;
            padding: 10px;
            border: 1px solid #ffffff;
        }
        .declaration p strong, .program p strong, .interview p strong {
            color: #00ccff;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center">College Application Form</h2>

        <?php if ($student): ?>
            <p><strong>Application No.: </strong><?php echo htmlspecialchars($student['application_no']); ?></p>

            <div class="header">
                <h3>I. Personal Record</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                        <th>First Name</th>
                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                        <th>Middle Name</th>
                        <td><?php echo htmlspecialchars($student['middle_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Home Address</th>
                        <td colspan="3"><?php echo htmlspecialchars($student['home_address']); ?></td>
                        <th>Contact Number</th>
                        <td><?php echo htmlspecialchars($student['contact']); ?></td>
                    </tr>
                    <tr>
                        <th>Present Address</th>
                        <td colspan="3"><?php echo htmlspecialchars($student['present_address']); ?></td>
                        <th>Sex</th>
                        <td><?php echo htmlspecialchars($student['sex']); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?php echo htmlspecialchars($student['date_of_birth']); ?></td>
                        <th>Email</th>
                        <td colspan="3"><?php echo htmlspecialchars($student['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Place of Birth</th>
                        <td colspan="3"><?php echo htmlspecialchars($student['place_of_birth']); ?></td>
                        <th>Civil Status</th>
                        <td><?php echo htmlspecialchars($student['civil_status']); ?></td>
                    </tr>
                </table>
            </div>

            <div class="education">
                <h3>II. Educational Background</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>School</th>
                        <th>Year</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($student['elementary']); ?></td>
                        <td><?php echo htmlspecialchars($student['elementary_year_graduated']); ?></td>
                        <td>Graduated</td>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($student['high_school']); ?></td>
                        <td><?php echo htmlspecialchars($student['high_school_year_graduated']); ?></td>
                        <td>Graduated</td>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($student['shs']); ?></td>
                        <td><?php echo htmlspecialchars($student['shs_year_graduated']); ?></td>
                        <td>Graduated</td>
                    </tr>
                    <tr>
                        <th>SHS Track and Strand taken</th>
                        <td colspan="2"><?php echo htmlspecialchars($student['track_and_strand']); ?></td>
                    </tr>
                </table>
            </div>

            <div class="declaration">
                <h3>Declaration</h3>
                <p>I hereby certify that all the above information are complete and accurate.</p>
                <p><strong>Signature: </strong><?php echo htmlspecialchars($student['complete_name']); ?></p>
                <p><strong>Date Signed: </strong><?php echo htmlspecialchars($student['date_signed']); ?></p>
            </div>

            <div class="program">
                <h3>III. Program Application Details</h3>
                <p>I would like to enroll in <strong><?php echo htmlspecialchars($student['course_to_be_enrolled']); ?></strong></p>
            </div>

            <div class="interview">
                <h3>IV. Interview and Assessment Result</h3>
                <p><strong>Interviewer: </strong>DR. LIZA GARCIA</p>
                <p><strong>Date Signed: </strong>6/13/2024</p>
            </div>
        <?php else: ?>
            <p class="text-center text-danger">No student found with the given application number.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
