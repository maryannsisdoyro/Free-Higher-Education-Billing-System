<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM courses where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="import-csv" enctype="multipart/form-data">
        <label for="csv-file">CSV File</label>
        <input type="file" name="file" id="csv-file" class="form-control" required/>
    </form>
</div>
<script>
     $('#import-csv').submit(function(e){
		e.preventDefault()
		start_load()
		var formData = new FormData(this);
		$.ajax({
			url:'ajax.php?action=import_csv_enrollment',
			method:'POST',
			data: formData,
			contentType: false,
			processData: false,
			error: err => {
				console.log(err)
				end_load()
			},
			success: function(resp){
				resp = JSON.parse(resp)
                console.log(resp);
				if(resp.status == 1){
					
					
				}
			}
		})

        alert_toast("Data successfully saved. Refresh in 10 seconds....", 'success')
        setTimeout(function(){
						location.href = "index.php?page=college-application"
					}, 10000)
	})
</script>
