<?php 
    include 'db_connect.php';
   
?>

<div class="container">

        <div class="d-flex align-items-center justify-content-between">
        <h2 >Enrollment Database</h2>
        <a href="javascript:void(0);" class="btn btn-danger" id="import"> Import CSV</a>
        </div>
        
        <div class="my-4">
            <button type="button" class="btn btn-info" onclick="RestartoPrint()">0</button>
            <button type="button" class="btn btn-danger" onclick="RestartoUnprint()">1</button>
            <a href="index.php?page=college-application&export=csv" class="btn btn-success">Export to CSV</a>
            <a href="javascript:void(0);" onclick="printTable()" class="btn btn-primary">Print</a> 
            <button class="btn btn-primary" type="button" onclick="location.href='enrol/home.php?page=subjects'">Subject</button>
            <!-- <button class="btn btn-primary" type="button" onclick="location.href='students.php'">Students</button> -->
            <!--
            <button class="btn btn-primary" type="button" onclick="location.href='college-applications.php'">College of application Form </button> -->
        </div>
        <div class="table-responsive">
           <table id="table" class="">
    <thead>
      
        <tr>
            <th>Select</th>
            <th>Application No.</th>
            <th>Student_ID</th>
            <th>Student Name</th>
            <th>Status</th>
            <th>Course</th>
            <th>Major</th>
            <th>Year</th>
            <th>Section</th>
            <th>Curriculum Year</th>
            <th>Religious</th>
            <th>Contact No.</th>
            <th>Home Address</th>
            <th>Civil</th>
            <th>Date of Birth</th>
            <th>Place of Birth</th>
            <th>Elementary School</th>
            <th>S.Y.</th>
            <th>High School</th>
            <th>S.Y.</th>
            <th>Last School</th>
            <th>S.Y.</th>
            <th>Totalunits</th>
            <th>UnitsEnrolled</th>
            <th>RatePerUnit</th>
            <th>Total</th>
            <th>LibraryFees</th>
            <th>ComputerFees</th>
            <th>LaboratoryFees</th>
            <th>Lab_Fees</th>
            <th>Lab_Fees</th>
            <th>School_ID</th>
            <th>AtheleticFees</th>
            <th>AdmissionFees</th>
            <th>DevelopmentFees</th>
            <th>GuidanceFees</th>
            <th>HandbookFees</th>
            <th>EntranceFees</th>
            <th>RegistrationFees</th>
            <th>Medical&DentalFees</th>
            <th>CulturalFees</th>
            <th>TotalMisce_Fees</th>
            <th>GrandTotal</th>
            
        </tr>
    </thead>
    <tbody>
        

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $year = $row["year_level"] ?? '0';
                echo "<tr>
                        <td class='text-center'><input type='checkbox' class='row_checkbox' name='selected_application[]' value='".$row["id"]."' data='".$row["stu_id"]."'></td> <!-- Checkbox -->
                        <td>".$row["application_no"]."</td>
                        <td>".$row["stu_id"]."</td>
                        <td>".$row["stu_name"]."</td>
                        <td>".$row["stu_sta"]."</td>
                        <td>".$row["course"]."</td>
                        <td>".$row["major"]."</td>
                        <td>".$year."</td>
                        <td>".$row["section"]."</td>
                        <td>".$row["curr"]."</td>
                        <td>".$row["reli"]."</td>
                        <td>".$row["con_no"]."</td>
                        <td>".$row["home_ad"]."</td>
                        <td>".$row["civil"]."</td>
                        <td>".$row["d_birth"]."</td>
                        <td>".$row["p_birth"]."</td>
                        <td>".$row["ele"]."</td>
                        <td>".$row["ele_year"]."</td>
                        <td>".$row["high"]."</td>
                        <td>".$row["high_year"]."</td>
                        <td>".$row["last_sc"]."</td>
                        <td>".$row["last_year"]."</td>
                        <td>".$row["tot_units"]."</td>
                        <td>".$row["un_enrol"]."</td>
                        <td>".$row["rate_per"]."</td>
                        <td>".$row["total"]."</td>
                        <td>".$row["lib"]."</td>
                        <td>".$row["com"]."</td>
                        <td>".$row["lab1"]."</td>
                        <td>".$row["lab2"]."</td>
                        <td>".$row["lab3"]."</td>
                        <td>".$row["sch_id"]."</td>
                        <td>".$row["ath"]."</td>
                        <td>".$row["adm"]."</td>
                        <td>".$row["dev"]."</td>
                        <td>".$row["guid"]."</td>
                        <td>".$row["hand"]."</td>
                        <td>".$row["entr"]."</td>
                        <td>".$row["reg_fe"]."</td>
                        <td>".$row["med_den"]."</td>
                        <td>".$row["cul"]."</td>
                        <td>".$row["t_misfe"]."</td>
                        <td>".$row["g_tot"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='23'>No Subject yet</td></tr>";
        }
        ?>
    </tbody>
</table>

        </div>

        
        
    </div>
    <link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
    <script src="sweetalerts/sweetalert2@11.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-1BmE4k2HxZbAUot0H8VW4+nH6HiQoTCtVhjx2Ks11P+3pFb6PI8qzWJ5KqL5vmHH" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+EW0PA/Nk5O2AWK3xFPrDh4Ta1gYhT3Y2vo" crossorigin="anonymous"></script> -->

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
        $('#import').click(function(){
		uni_modal("Import CSV","import-csv-enrollment.php",'small')
		
	})
        $(document).ready(function(){
		$('table').dataTable()
	})
    </script>

<script>
    $(document).ready(function() {
        $(".row_checkbox").on("click", function() {
            var application_no = $(this).val();
            var stu_id = $(this).attr('data'); // Get the value of the checkbox, which is the application number

            // Display confirmation dialog
            Swal.fire({
                title: 'STUDENTS ENROLLMENT',
                text: 'Records Information',
                icon: 'info',
                showCancelButton: true,
                // showDenyButton: true, // Add showDenyButton option to show the "Edit" button
                // confirmButtonText: 'Enroll',
                // denyButtonText: 'Delete', // Text for the "Edit" button
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Print',
                didRender: function() {
                            // Create custom "Select" button
                            const selectButton = Swal.getConfirmButton().cloneNode();
                            selectButton.style.backgroundColor = 'green'; 
                            selectButton.innerText = 'COR';
                            selectButton.classList.add('swal2-confirm', 'swal2-styled');
                            selectButton.addEventListener('click', function() {
                                Swal.close();
                                // Handle the select button click
                                console.log("Select button clicked");
                                window.location.href = "enrol/student-cor.php?application_no=" + application_no;
                            });
                            Swal.getActions().prepend(selectButton);
                        }
            }).then((result) => {
                if (result.isConfirmed) {
                    var printWindow = window.open("enrol/print-college-enrol.php?application_no=" + application_no, "_blank");
                } else if (result.isDenied) {
                    // Redirect to the edit page
                    window.location.href = "delete-subject.php?id=" + application_no;
                }
            });
        });
    });
</script>