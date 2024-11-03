<?php
include('db.php'); // Include your database connection file

$semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$courseenrolled = isset($_GET['courseenrolled']) ? $_GET['courseenrolled'] : '';
$collegeprog = isset($_GET['collegeprog']) ? $_GET['collegeprog'] : '';

if ($semester === '1st' && $courseenrolled === 'BSIT' && $collegeprog === 'NONE') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BSIT' && $collegeprog === 'STEM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester' AND prerequi='NONE'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BSIT' && $collegeprog === 'ABM') {
     $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester' AND year='1st'";

} elseif ($semester === '1st' && $courseenrolled === 'BSBA' && $collegeprog === 'NONE') {
     $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BSBA' && $collegeprog === 'STEM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BSBA' && $collegeprog === 'ABM') {
       $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND prerequi='NONE'AND year='1st'";

} elseif ($semester === '1st' && $courseenrolled === 'BS-HM' && $collegeprog === 'NONE') {
     $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BS-HM' && $collegeprog === 'STEM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BS-HM' && $collegeprog === 'ABM') {
       $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND prerequi='NONE'AND year='1st'";


} elseif ($semester === '1st' && $courseenrolled === 'BEED' && $collegeprog === 'NONE') {
     $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BEED' && $collegeprog === 'STEM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BEED' && $collegeprog === 'ABM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";

} elseif ($semester === '1st' && $courseenrolled === 'BSED' && $collegeprog === 'NONE') {
     $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BSED' && $collegeprog === 'STEM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '1st' && $courseenrolled === 'BSED' && $collegeprog === 'ABM') {
    $query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";

} elseif ($semester === '2nd' && $courseenrolled === 'BSIT') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '2nd' && $courseenrolled === 'BS-HM') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '2nd' && $courseenrolled === 'BSBA') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '2nd' && $courseenrolled === 'BEED') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === '2nd' && $courseenrolled === 'BSED') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";

} elseif ($semester === 'Summer' && $courseenrolled === 'BSIT') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === 'Summer' && $courseenrolled === 'BS-HM') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === 'Summer' && $courseenrolled === 'BSBA') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === 'Summer' && $courseenrolled === 'BEED') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";
} elseif ($semester === 'Summer' && $courseenrolled === 'BSED') {
$query = "SELECT * FROM subject WHERE course='$courseenrolled' AND sem='$semester'AND year='1st'";

} else {
    $query = "SELECT * FROM subject";
}

$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Calculate total approved units
$totalUnits = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $totalUnits += $row['units'];
}
?>

<div class="table-responsive table-responsive-data2">
    <table id="example2" class="table table-bordered table-hover" style="font-size: small;">
        <thead>
            <tr>     
                <th class="text-center">Time</th>
                <th class="text-center">Day</th>
                <th class="text-center">Subject Code</th>
                <th class="text-center">Subject Description</th>
                <th class="text-center">Units</th>
                <th class="text-center">Room</th>
                <th class="text-center">Instructor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Reset pointer in $result back to start
            mysqli_data_seek($result, 0);

            while ($row = mysqli_fetch_assoc($result)) :
            ?>
                <tr>
                    <td class="text-center"><?php echo htmlentities($row['tbl_time']); ?></td>
                    <td class="text-center"><?php echo htmlentities($row['tbl_day']); ?></td>
                    <td class="text-center sub-column"><?php echo htmlentities($row['subjectcode']); ?></td>
                    <td class="text-center des-column"><?php echo htmlentities($row['subdes']); ?></td>
                    <td class="text-center units-column"><?php echo htmlentities($row['units']); ?></td>
                    <td class="text-center"><?php echo htmlentities($row['room']); ?></td>
                    <td class="text-center ins-column"><?php echo htmlentities($row['inst']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Number of Units Applied: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Disapproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
    </table>
</div>
