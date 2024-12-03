<?php
    include 'db_connect.php';

    if (str_contains($_SERVER['REQUEST_URI'], "page=college-application")) {
        include 'db_connect.php';
        $sql = "SELECT `id`,`application_no`,`stu_id`, `year_level`, `stu_name`, `stu_sta`, `course`, `major`, `section`, `curr`, `reli`, `con_no`, `home_ad`, `civil`, `d_birth`, `p_birth`, `ele`, `ele_year`, `high`, `high_year`, `last_sc`, `last_year`, `tot_units`, `un_enrol`, `rate_per`, `total`, `lib`, `com`, `lab1`, `lab2`, `lab3`, `sch_id`, `ath`, `adm`, `dev`, `guid`, `hand`, `entr`, `reg_fe`, `med_den`, `cul`, `t_misfe`, `g_tot`, `image`, `semester`, curr FROM `enroll2024` WHERE delete_status = 1 ORDER BY course, lname ASC ";
    
        $result = $conn->query($sql);
        
        function array_to_csv_download($array, $filename = "export.csv", $delimiter = ",") {
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
      }

    $month = isset($_GET['month']) ? date('m', strtotime($_GET['month'])) : date('m');
    $year = isset($_GET['month']) ? date('Y', strtotime($_GET['month'])) : date('Y');

    $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
    $res_academic = $get_academic->fetch_array();
    $academic_year = $res_academic['year'];
    $semester_academic = $res_academic['semester'];

    $i = 1;
    $data = [];
    $active_stat = 1;
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
                        e.semester,
                        e.gender,
                        e.delete_status as DELETE_STAT,
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
                        WHERE e.curr = '$academic_year' AND e.semester = '$semester_academic' AND e.delete_status = $active_stat
                     GROUP BY e.id ORDER BY e.course,e.lname ASC ");

                     
                   
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
<style>
    table th{
     text-align: center !important;
     vertical-align: middle !important;
    }

</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
            <!-- <div class="row justify-content-center pt-4">
                <label for="" class="mt-2">Month</label>
                <div class="col-sm-3">
                    <input type="month" name="month" id="month" value="<?php #echo $month ?>" class="form-control">
                </div>
            </div>
            <hr> -->
            <div class="col-md-12 mb-4 py-3">
                    <center>
                        <!-- <a href="print-payment.php?month=<?= $month ?>&year=<?= $year ?>" class="btn btn-success btn-sm col-sm-3" type="button" ><i class="fa fa-print"></i> Print</a> -->
                        <button class="btn btn-success print" type="button" ><i class="fa fa-print"></i> Print</button>
                    <a href="#" class="btn btn-success" onclick="tableToCSV()">Download Form 2</a>
                        
                    </center>
                    <hr>
                </div>
            <div class="col-md-12">
            <div class="table-responsive" id="student-table">
            <table class="wborder" id="report-list">
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
                                                  foreach ($data as $row1) {
                                             
                                                    $cfees = $conn->query("SELECT * FROM student_individual_fees where enroll_id = '". $row1['id'] ."' ORDER BY id DESC");
                                                    $ftotal = 0;
                                                    while ($row2 = $cfees->fetch_assoc()) {
                                                    ?>
                                                        <th><b><?php echo $row2['type'] ?></b></th>
                                                    <?php
                                                    }
                                                    
                                                }
                                                ?>
                                                <th>Total TOSF</th>
                                            </thead>
                                            <?php
                                             $count_i = 0; // Initialize without leading zeros
                                             // Increment the count
                                             
                                             // Format the number to always have six digits
                                            
                                             
                                             
                                            // echo count($data);
                                            if (count($data) > 0) {
                                                $count = 1;
                                                foreach ($data as $row) {
                                                    if ($row['DELETE_STAT'] == 1) {
                                                        # code...
                                                   
                                                    $count_i++;
                                                    $formatted_count_i = str_pad($count_i, 6, '0', STR_PAD_LEFT);
                                                    $row['course'] = $row['course'] == 'BS-HM' ? 'BSHM' : $row['course'];
                                            ?>
                                                    <tr>
                                                       <td>000<?= $formatted_count_i; ?></td>
                                                       
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
                                                     
                                                        $cfees2 = $conn->query("SELECT * FROM student_individual_fees WHERE enroll_id = '".$row['id']."'");
                                                        $ftotal = 0;
                                                            while ($row2 = $cfees2->fetch_assoc()) {
                                                                $ftotal += $row2['amount'];
                                                                ?>
                                                                    <td class='text-right'><b><?php echo number_format($row2['amount'] ?? 0, 2) ?></b></td>
                                                                <?php
                                                            }
                                                        ?>
                                                      
                                                      
                                                        <td style="text-align: right;" colspan="<?= $count == 1 ? $cfees->num_rows + 1 : '' ?>"><?= $row['total_amount'] ?? 0 ?></td>
                                                       
                                                       
                                                    </tr>
                                            <?php
                                             }
                                                }
                                            }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                <hr>
                <div class="col-md-12 mb-4">
                    <center>
                    <a href="#" class="btn btn-success" onclick="tableToCSV()">Download Form 2</a>
                    </center>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<noscript>
	<style>
		table#report-list{
			width:100%;
			border-collapse:collapse
		}
		table#report-list td,table#report-list th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
        }
	</style>
</noscript>
<script>

function tableToCSV() {

// Variable to store the final csv data
let csv_data = [];

// Get each row data
let rows = document.getElementsByTagName('tr');
for (let i = 0; i < rows.length; i++) {

    // Get each column data
    let cols = rows[i].querySelectorAll('td,th');

    // Stores each csv row data
    let csvrow = [];
    for (let j = 0; j < cols.length; j++) {

        // Get the text data of each cell
        // of a row and push it to csvrow
        csvrow.push(cols[j].innerHTML);
    }

    // Combine each column value with comma
    csv_data.push(csvrow.join(","));
}

// Combine each row data with new line character
csv_data = csv_data.join('\n');

// Call this function to download csv file  
downloadCSVFile(csv_data);

}

function downloadCSVFile(csv_data) {

// Create CSV file object and feed
// our csv_data into it
CSVFile = new Blob([csv_data], {
    type: "text/csv"
});

// Create to temporary link to initiate
// download process
let temp_link = document.createElement('a');

// Download csv file
temp_link.download = "GfG.csv";
let url = window.URL.createObjectURL(CSVFile);
temp_link.href = url;

// This link should not be displayed
temp_link.style.display = "none";
document.body.appendChild(temp_link);

// Automatically click the link to
// trigger download
temp_link.click();
document.body.removeChild(temp_link);
}

    // $('#table').DataTable();
// $('#month').change(function(){
//     location.replace('index.php?page=payments_report&month='+$(this).val())
// })
$('.print').click(function(){
    var _c = $('#report-list').clone();
    var ns = $('noscript').clone();
    ns.append(_c);

    // Create a new window
    var nw = window.open('', '_blank', 'width=900,height=600');

    // Add CSS styles for print
    nw.document.write(`
        <style>
            table {
                width: 100%;
                border-collapse: collapse !important;
            }
            table, th, td {
                border: 1px solid black;
                padding: 10px;
                border-collapse: collapse !important;
            }
            @page {size: A4 landscape !important;max-height:100% !important; max-width:100% !important;}
            .text-center {
                text-align: center;
            }
        </style>
    `);

    // Add content to the new window
    nw.document.write('<p class="text-center"><b>Payment Report as of <?php echo date("F, Y",strtotime($month)) ?></b></p>');
    nw.document.write(ns.html());
    nw.document.close();

    // Print the content
    nw.print();

    // Close the window after printing
    setTimeout(() => {
        nw.close();
    }, 500);
});


function printData()
{
   var divToPrint=document.getElementById("table");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('.print').on('click',function(){
printData();
})
</script>