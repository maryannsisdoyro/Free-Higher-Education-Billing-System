<?php
include 'db_connect.php';
$fees = $conn->query("SELECT 
	ef.*,
	s.name as sname, 
	s.lname, 
	s.mname, 
	s.fname, 
	s.email, 
	s.gender,
	s.contact,
	s.id_no,
	s.sequence_no,
	concat(c.course,' - ',c.level) as `class`, 
	c.course, c.level, 
	c.laboratory, 
	c.computer, 
	c.academic, 
	c.academic_nstp 
	FROM 
		student_ef_list ef 
	inner join 
		student s on s.id = ef.student_id 
	inner join 
		courses c on c.id = ef.course_id  
	where 
		ef.id = {$_GET['ef_id']}");
foreach ($fees->fetch_array() as $k => $v) {
	$$k = $v;
}
$payments = $conn->query("SELECT * FROM payments where ef_id = $id ");
$pay_arr = array();
while ($row = $payments->fetch_array()) {
	$pay_arr[$row['id']] = $row;
}
?>

<style>
	.flex {
		display: inline-flex;
		width: 100%;
	}

	.w-50 {
		width: 50%;
	}

	.text-center {
		text-align: center;
	}

	.text-right {
		text-align: right;
	}

	table.wborder {
		width: 100%;
		border-collapse: collapse;
	}

	table.wborder>tbody>tr,
	table.wborder>tbody>tr>td {
		border: 1px solid;
	}

	p {
		margin: unset;
	}

	tr td{
		text-align: right;
	}

	@media print {
    table, thead, th, tr, td {
        border: 1px solid #000 !important;
        border-collapse: collapse !important;
		text-align: right;
    }
}

</style>
<div class="container-fluid">

	<div class="table-responsive">
		<table class="wborder" style="border: 1px solid #000; border-collapse: collapse;">
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
							<th style="min-width: 200px !important;">Sequence Number</th>
							<th style="min-width: 200px !important;">Student Number</th>
							<!-- <th style="min-width: 200px !important;">Learner's Reference Number</th> -->
							<th style="min-width: 200px !important;">Last Name</th>
							<th style="min-width: 200px !important;">Given's Name</th>
							<th style="min-width: 200px !important;">Middle Name</th>
							<th>Gender</th>
							<th style="min-width: 200px !important;">Degree Program</th>
							<th>Year Level</th>
							<th style="min-width: 200px !important;">E-mail Address</th>
							<th style="min-width: 200px !important;">Phone Number</th>
							<th style="min-width: 200px !important;">Laboratory Units/subject</th>
							<th style="min-width: 200px !important;">Computer Lab Units/subject</th>
							<th style="min-width: 200px !important;">Academic Units Enrolled(credit and non-credit courses)</th>
							<th style="min-width: 200px !important;">Academic Units of NSTP Enrolled(credit and non-credit courses)</th>
							<?php
							$cfees = $conn->query("SELECT * FROM fees where course_id = $course_id");
							$ftotal = 0;
							while ($row = $cfees->fetch_assoc()) {
								$ftotal += $row['amount'];
							?>

								<th style="min-width: 200px !important;"><b><?php echo $row['description'] ?></b></th>
								

							<?php
							}
							?>
							<th>Total</th>
						</thead>

						<tr>
							<td><?= $sequence_no ?></td>
							<td><?= $ef_no ?></td>
							<!-- <td></td> -->
							<td><?= ucfirst($lname) ?></td>
							<td><?= ucfirst($fname) ?></td>
							<td><?= ucfirst($mname) ?></td>
							<td><?= $gender ?></td>
							<td><?= $course ?></td>
							<td><?= $level ?></td>
							<td><?= $email ?></td>
							<td><?= $contact ?></td>
							<td><?= $laboratory ?></td>
							<td><?= $computer ?></td>
							<td><?= $academic ?></td>
							<td><?= $academic_nstp ?></td>
							<?php
							$cfees = $conn->query("SELECT * FROM fees where course_id = $course_id");
							$ftotal = 0;
							while ($row = $cfees->fetch_assoc()) {
								$ftotal += $row['amount'];
							?>

								
								<td class='text-right'><b><?php echo number_format($row['amount'], 2) ?></b></td>

							<?php
							}
							?>
							<th class="text-right"><b><?php echo number_format($ftotal, 2) ?></b></th>
						</tr>
						
					</table>
				</td>
			
			</tr>
		</table>
	</div>
</div>