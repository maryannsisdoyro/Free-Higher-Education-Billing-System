<?php 
       $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
       $res_academic = $get_academic->fetch_array();
       $semester = $res_academic['semester'];

       

if(session_status() != 2){
    session_start();
    }
    
    if(!isset($_SESSION['login_id'])){
        header("location: login.php");
        }
?>

<div class="BSIT d-none">
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
            // Assuming $conn is your database connection
            $totalUnits = 0;
            $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = 'BSIT' AND sem = '$semester'  AND year = '1st'");

            foreach ($query as $row) :
                $totalUnits += $row['units'];
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
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Numbers of Units Applied: </strong></td>
                  <td class="units-column" style="text-align: center;"><strong> <?php echo number_format($totalUnits); ?></strong></td>
              
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Dispproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
</table>
</div>

<div class="BSBA d-none">
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
            // Assuming $conn is your database connection
            $totalUnits = 0;
            $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = 'BSBA' AND sem = '$semester'  AND year = '1st' AND year = '1st'");

            foreach ($query as $row) :
                $totalUnits += $row['units'];
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
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Numbers of Units Applied: </strong></td>
                  <td class="units-column" style="text-align: center;"><strong> <?php echo number_format($totalUnits); ?></strong></td>
              
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Dispproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
</table>
</div>

<div class="BEED" >
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
            // Assuming $conn is your database connection
            $totalUnits = 0;
            $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = 'BEED' AND sem = '$semester'  AND year = '1st'");

            foreach ($query as $row) :
                $totalUnits += $row['units'];
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
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Numbers of Units Applied: </strong></td>
                  <td class="units-column" style="text-align: center;"><strong> <?php echo number_format($totalUnits); ?></strong></td>
              
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Dispproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
</table>
</div>

<div class="BSED d-none">
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
            // Assuming $conn is your database connection
            $totalUnits = 0;
            $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = 'BSED' AND sem = '$semester'  AND year = '1st'");

            foreach ($query as $row) :
                $totalUnits += $row['units'];
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
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Numbers of Units Applied: </strong></td>
                  <td class="units-column" style="text-align: center;"><strong> <?php echo number_format($totalUnits); ?></strong></td>
              
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Dispproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
</table>
</div>

<div class="BSHM d-none">
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
            // Assuming $conn is your database connection
            $totalUnits = 0;
            $query = mysqli_query($conn, "SELECT * FROM subject WHERE course = 'BSHM' AND sem = '$semester'  AND year = '1st'");

            foreach ($query as $row) :
                $totalUnits += $row['units'];
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
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                
                <td class="sub-column" colspan="2" style="text-align: right;"><strong>Numbers of Units Applied: </strong></td>
                  <td class="units-column" style="text-align: center;"><strong> <?php echo number_format($totalUnits); ?></strong></td>
              
                <td class="des-column" style="text-align: right;"><strong>Approved Units: </strong></td>
                <td class="units-column" style="text-align: center;"><strong><?php echo number_format($totalUnits); ?></strong></td>
                <td class="des-column" style="text-align: right;"><strong>Dispproved Units: </strong></td>
                <td class="ins-column" style="text-align: center;"><strong></strong></td>
            </tr>
        </tfoot>
</table>
</div>