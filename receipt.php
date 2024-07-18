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
	s.address,
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
	/* .flex {
		display: inline-flex;
		width: 100%;
	} */
	/* .text-center {
		text-align: center;
	}

	.text-right {
		text-align: right;
	} */

	table.wborder {
		width: 100%;
		border-collapse: collapse;
	}

	table.wborder>tbody>tr,
	table.wborder>tbody>tr>td {
		border: 1px solid;
	}

	/* p {
		margin: unset;
	} */

	tr td {
		text-align: right;
	}

	/*

	@media print {
    table, thead, th, tr, td {
        border: 1px solid #000 !important;
        border-collapse: collapse !important;
		text-align: right;
    } */

	.content {
		width: 100% !important;
		text-align: center;
	}

	table {
		width: 100%;
		border: 1px solid #000;
	}

	table tr,
	table tr td {
		border-collapse: collapse;
		border: 1px solid #000;
		padding: 5px;
	}

	table tr td {
		text-align: left;
	}


	/* } */
</style>
<div class="container-fluid">
	<div class="content">

		<div style="display: flex; justify-content: center;">
			<div>
				<img src="./assets/logo.png" alt="" style="margin: auto 0; width: 100px !important;">
			</div>
			<div>
				<p style="margin-bottom: 0;">Republic of the Philippines</p>
				<p style="margin-bottom: 0;">Province of Cebu</p>
				<p style="margin-bottom: 0;">Municipality of Madridejos</p>
				<h5 style="margin-bottom: 0;">Madridejos Community College</h5>
				<p>Crossing Bunakan, Madridejos, Cebu</p>
			</div>
		</div>

		<div>
			<table>
				<tr>
					<td colspan="2">Name :</td>
					<td colspan="4"><?= strtoupper($sname) ?></td>
					<td colspan="2">ID Number: </td>
					<td colspan="3"><?= $id_no ?></td>
				</tr>
				<tr>
					<td colspan="2">Course :</td>
					<td><?= $course ?></td>
					<td colspan="2">Major :</td>
					<td colspan="3">N/A</td>
					<td colspan="1">Section :</td>
					<td colspan="3">N/A</td>
				</tr>
				<tr>
					<td colspan="2">Curriculum Year :</td>
					<td colspan="3"><?= date('Y') ?> - <?= date('Y', strtotime('+1year')) ?></td>
					<td colspan="3">Religious Affiliation: N/A</td>
					<td colspan="2">Contact Number:</td>
					<td colspan="2"><?= $contact ?></td>
				</tr>
				<tr>
					<td colspan="2">Home Address:</td>
					<td colspan="5"><?= $address ?></td>
					<td colspan="2">Civil Status:</td>
					<td colspan="3">N/A</td>
				</tr>
				<tr>
					<td colspan="2">Date of Birth:</td>
					<td colspan="5"> N/A</td>
					<td colspan="2">Palce of Birth:</td>
					<td colspan="3">N/A</td>
				</tr>
				<tr>
					<td colspan="2">Elementary Course Completed:</td>
					<td colspan="5"> N/A</td>
					<td colspan="2">S .Y.:</td>
					<td colspan="3">N/A</td>
				</tr>
				<tr>
					<td colspan="2">High School Course Completed:</td>
					<td colspan="5"> N/A</td>
					<td colspan="2">S .Y.:</td>
					<td colspan="3">N/A</td>
				</tr>
				<tr>
					<td colspan="2">Last School Attended:</td>
					<td colspan="5"> N/A</td>
					<td colspan="2">S .Y.:</td>
					<td colspan="3">N/A</td>
				</tr>
			</table>
		</div>

		<div style="margin-top: 20px;">
			<table>
				<thead>
					<th colspan="11" style="text-align: center;">Assessment</th>
				</thead>
				<tr>
					<td colspan="5"></td>
					<td colspan="2">Units Enrolled</td>
					<td colspan="2">Rate per Unit</td>
					<td colspan="3">Total</td>
				</tr>
				<?php
				$cfees = $conn->query("SELECT * FROM fees where course_id = $course_id");
				$ftotal = 0;
				while ($row = $cfees->fetch_assoc()) {
					$ftotal += $row['amount'];
				?>


				<tr>
					<td colspan="2"><?= $row['description'] ?></td>
					<td colspan="5" style="text-align: center;"></td>
					<td colspan="2" style="text-align: center;"><?= $row['amount'] != 0 ? $row['amount'] : '-' ?></td>
					<td colspan="3" style="text-align: center;"><?= $row['amount'] ?></td>
				</tr>

				<?php
				}
				?>
				<tr>
					<td colspan="2">Grand Total</td>
					<td colspan="5" style="text-align: center;"></td>
					<td colspan="2" style="text-align: center;"></td>
					<td colspan="3" class="text-right"><b><?php echo number_format($ftotal, 2) ?></b></td>
				</tr>
				
				
			</table>
		</div>

	</div>
</div>