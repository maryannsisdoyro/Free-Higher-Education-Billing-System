<?php 
    include 'db_connect.php';
    $sql = "SELECT `id`, `sem`,`year`, `course`,  `tbl_time`, `tbl_day`, `subjectcode`, `prerequi`, `subdes`, `units`, `room`, `inst` FROM `subject`";

    $result = $conn->query($sql);
?>

<div class="container">

<h2 class="my-4">Subject Load</h2>
<div class="my-4">
     <a href="addsub.php" class="btn btn-success">Add</a>
    <a href="college-applications.php" class="btn btn-secondary">Cancel</a>
</div>
<div class="table-responsive">
   <table id="table" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Select</th>
    <th>Semester</th>
    <th>Year</th>
    <th>Course</th>
    <th>Time</th>
    <th>Day</th>
    <th>Subject Code</th>
    <th>Subject Description</th>
    <th>Pre-Prequites</th>
    <th>Units</th>
    <th>Room</th>
    <th>Instructor</th>
</tr>
</thead>
<tbody>
<!--  SELECT `id`, `sem`, `year`, `course`, `time`, `day`, `subjectcode`, `subdes`, `prerequi`, `units`, `room`, `strand` FROM `subject` WHERE 1 -->
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='text-center'><input type='checkbox' class='row_checkbox' name='selected_application[]' value='".$row["id"]."'></td> <!-- Checkbox -->
                <td>".$row["sem"]."</td>
                <td>".$row["year"]."</td>
                <td>".$row["course"]."</td>
                <td>".$row["tbl_time"]."</td>
                <td>".$row["tbl_day"]."</td>
                <td>".$row["subjectcode"]."</td>
                <td>".$row["subdes"]."</td>
                <td>".$row["prerequi"]."</td>
                <td>".$row["units"]."</td>
                <td>".$row["room"]."</td>
                <td>".$row["inst"]."</td>
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

<script>
        $(document).ready(function(){
		$('table').dataTable()
	})
    </script>