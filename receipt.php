<?php
include 'db_connect.php';
$fees = $conn->query("SELECT 
	* FROM enroll2024
	where 
		id = {$_GET['ef_id']}");
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

	table {
		width: 100%;
		border-collapse: collapse;
	} 

	table .content> tbody>tr,
	table tbody > tr > td {
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
					<td colspan="4"><?= strtoupper($stu_name) ?></td>
					<td colspan="2">ID Number: </td>
					<td colspan="3"><?= $stu_id ?></td>
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
					<td colspan="3"><?= $academic ?></td>
					<td colspan="3">Religious Affiliation: <?= $reli ?></td>
					<td colspan="2">Contact Number:</td>
					<td colspan="2"><?= $con_no ?></td>
				</tr>
				<tr>
					<td colspan="2">Home Address:</td>
					<td colspan="5"><?= $home_ad ?></td>
					<td colspan="2">Civil Status:</td>
					<td colspan="3"><?= $civil ?></td>
				</tr>
				<tr>
					<td colspan="2">Date of Birth:</td>
					<td colspan="5"> <?= $d_birth ?></td>
					<td colspan="2">Palce of Birth:</td>
					<td colspan="3"><?= $p_birth ?></td>
				</tr>
				<tr>
					<td colspan="2">Elementary Course Completed:</td>
					<td colspan="5"> <?= $ele ?></td>
					<td colspan="2">S .Y.:</td>
					<td colspan="3"><?= $ele_year ?></td>
				</tr>
				<tr>
					<td colspan="2">High School Course Completed:</td>
					<td colspan="5"> <?= $high ?></td>
					<td colspan="2">S .Y.:</td>
					<td colspan="3"><?= $high_year ?></td>
				</tr>
				<tr>
					<td colspan="2">Last School Attended:</td>
					<td colspan="5"> <?= $last_sc ?></td>
					<td colspan="2">S .Y.:</td>
					<td colspan="3"><?= $last_year ?></td>
				</tr>
			</table>
		</div>

		<div style="margin-top: 20px;">
		<?php
				// $get_course = $conn->query("SELECT * FROM courses WHERE department = '$course'");
				// $fetch_course = $get_course->fetch_assoc();

				// $cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
				// $ftotal = 0;

				$get_latest = $conn->query("SELECT * FROM payments WHERE ef_id = '". $id ."' ORDER BY id DESC");
				$latest_payment = $get_latest->fetch_assoc();

				$get_total = $conn->query("SELECT SUM(amount) AS TOTAL FROM payments WHERE ef_id = $id");
				$total_payment = $get_total->fetch_assoc();
				$total = $g_tot - $total_payment['TOTAL'];
				// while ($row = $cfees->fetch_assoc()) {
				// 	$ftotal += $row['amount'];
				?>
			<!-- <h5 style="text-align: left;">Payment</h5> -->
			<div style="text-align: left;">
			<p>Remarks: </p>
			<p><?= $latest_payment['remarks'] ?></p>
			<p>Date: <?= date('M d,Y', strtotime($latest_payment['date_created'])) ?></p>
			</div>
			<div style="text-align: right;">
			<h4>Amount: <?= number_format($latest_payment['amount'],2) ?></h4>
			<h3>Total Fees: <?= number_format($g_tot, 2) ?></h3>
			<h2>Balance: <?= $total != 0 ? number_format($total,2) : 'Paid' ?></h2>
			</div>
			
		</div>

	</div>
</div>

