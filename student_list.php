<?php 
    include 'db_connect.php';
    $sql = "SELECT application_no, last_name, first_name, middle_name, home_address, present_address, contact, sex, date_of_birth, email, place_of_birth, civil_status, elementary, elementary_year_graduated, high_school, high_school_year_graduated, shs, shs_year_graduated, track_and_strand, complete_name, date_signed, course_to_be_enrolled FROM students WHERE status = 'Unread'";

    $result = $conn->query($sql);
?>
<div class="container">
        <!-- <a href="" class="btn btn-secondary"> Back</a> -->
        <!-- <a href="index.php" class="btn btn-danger"> Add New +</a> -->
        <-- <a href="#" id="delete-all-btn" class="btn btn-danger mt-2 delete-all-btn">Delete All</a> -->

        <div class="d-flex align-items-center justify-content-between">
        <h2 >COLLEGE APPLICATION FORM</h2>
        <a href="javascript:void(0);" id="new-enroll" class="btn btn-danger"> Add New +</a>
        </div>
       
        <div class="table-responsive">
           <table id="table" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Select</th>
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
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td class='text-center'><input type='checkbox' class='row_checkbox' name='selected_application[]' value='".$row["application_no"]."'></td> <!-- Checkbox -->
                        <td>".$row["application_no"]."</td>
                        <td>".$row["last_name"]."</td>
                        <td>".$row["first_name"]."</td>
                        <td>".$row["middle_name"]."</td>
                        <td>".$row["home_address"]."</td>
                        <td>".$row["present_address"]."</td>
                        <td>".$row["contact"]."</td>
                        <td>".$row["sex"]."</td>
                        <td>".$row["date_of_birth"]."</td>
                        <td>".$row["email"]."</td>
                        <td>".$row["place_of_birth"]."</td>
                        <td>".$row["civil_status"]."</td>
                        <td>".$row["elementary"]."</td>
                        <td>".$row["elementary_year_graduated"]."</td>
                        <td>".$row["high_school"]."</td>
                        <td>".$row["high_school_year_graduated"]."</td>
                        <td>".$row["shs"]."</td>
                        <td>".$row["shs_year_graduated"]."</td>
                        <td>".$row["track_and_strand"]."</td>
                        <td>".$row["complete_name"]."</td>
                        <td>".$row["date_signed"]."</td>
                        <td>".$row["course_to_be_enrolled"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='23'>No students enrolled yet</td></tr>";
        }
        ?>
    </tbody>
</table>

        </div>
        
    </div>
<script>
          function printTable() {
            var table = document.getElementById("table");
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><head><title>Print</title></head><body>');
            newWin.document.write(table.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.print();
        }
    </script>

    <script>
        $('#new-enroll').click(function(){
		uni_modal("COLLEGE APPLICATION FORM","new-enroll.php",'large')
		
	})
        $(document).ready(function(){
		$('table').dataTable()
	})
    </script>
