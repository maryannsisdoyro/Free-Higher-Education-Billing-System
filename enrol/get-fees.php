<div style="margin-top: 20px;" class="BEED">
			<table id="example2" class="table table-bordered table-hover">
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
				$get_course = $conn->query("SELECT * FROM courses WHERE department = 'BEED'");
				$fetch_course = $get_course->fetch_assoc();

				$cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
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

<div style="margin-top: 20px;" class="BSIT d-none">
			<table id="example2" class="table table-bordered table-hover">
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
				$get_course = $conn->query("SELECT * FROM courses WHERE department = 'BSIT'");
				$fetch_course = $get_course->fetch_assoc();

				$cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
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

<div style="margin-top: 20px;" class="BSBA d-none">
			<table id="example2" class="table table-bordered table-hover">
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
				$get_course = $conn->query("SELECT * FROM courses WHERE department = 'BSBA'");
				$fetch_course = $get_course->fetch_assoc();

				$cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
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

<div style="margin-top: 20px;" class="BSHM d-none">
			<table id="example2" class="table table-bordered table-hover">
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
				$get_course = $conn->query("SELECT * FROM courses WHERE department = 'BSHM'");
				$fetch_course = $get_course->fetch_assoc();

				$cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
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

<div style="margin-top: 20px;" class="BSED d-none">
			<table id="example2" class="table table-bordered table-hover">
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
				$get_course = $conn->query("SELECT * FROM courses WHERE department = 'BSED'");
				$fetch_course = $get_course->fetch_assoc();

				$cfees = $conn->query("SELECT * FROM fees where course_id = '". $fetch_course['id'] ."'");
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