<?php
    include 'db_connect.php';
    $month = isset($_GET['month']) ? date('m', strtotime($_GET['month'])) : date('m');
    $year = isset($_GET['month']) ? date('Y', strtotime($_GET['month'])) : date('Y');

    $i = 1;
    $data = [];
                      $total = 0;
                      $payments = $conn->query("SELECT 
                      p.*, 
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
                        payments p 
                      INNER JOIN 
                        enroll2024 e ON p.ef_id = e.id 
                    LEFT JOIN 
                        courses c ON e.course = c.department
                    WHERE MONTH(p.date_created) = '$month' AND YEAR(p.date_created) = '$year' ORDER BY e.lname ASC ");
                   
                      if($payments->num_rows > 0):
			          while($row = $payments->fetch_array()):
                        $total += $row['amount'];

                        $get_total = $conn->query("SELECT SUM(amount) AS TOTAL FROM payments WHERE ef_id = '". $row['stud_id'] ."'");
                        $total_payment = $get_total->fetch_assoc();
                        $balance = $row['g_tot'] - $total_payment['TOTAL'];

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
            <div class="row justify-content-center pt-4">
                <label for="" class="mt-2">Month</label>
                <div class="col-sm-3">
                    <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
                </div>
            </div>
            <hr>
            <div class="col-md-12">
            <div class="table-responsive" id="student-table">
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
                                            if ($payments->num_rows > 0) {
                                                $count = 1;
                                                foreach ($payments as $row) {
                                                    echo "hello ";
                                                   
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
                <hr>
                <div class="col-md-12 mb-4">
                    <center>
                        <a href="print-payment.php?month=<?= $month ?>&year=<?= $year ?>" class="btn btn-success btn-sm col-sm-3" type="button" ><i class="fa fa-print"></i> Print</a>
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
$('#month').change(function(){
    location.replace('index.php?page=payments_report&month='+$(this).val())
})
$('#print').click(function(){
		var _c = $('#report-list').clone();
		var ns = $('noscript').clone();
            ns.append(_c)
		var nw = window.open('','_blank','width=900,height=600')
		nw.document.write('<p class="text-center"><b>Payment Report as of <?php echo date("F, Y",strtotime($month)) ?></b></p>')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
		}, 500);
	})
</script>