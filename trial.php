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