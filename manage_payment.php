<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM payments where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>

<style>
  @media print {
    @page {
      size: portrait !important;
    }
  }
</style>

<div class="container-fluid">
	<form id="manage-payment">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">EF.NO./Student</label>
			<select name="ef_id" id="ef_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$fees = $conn->query("SELECT * FROM enroll2024");
					while($row= $fees->fetch_assoc()):
						$get_latest = $conn->query("SELECT * FROM payments WHERE ef_id = '". $row['id'] ."' ORDER BY id DESC");
						if ($get_latest->num_rows > 0) {
							$latest_payment = $get_latest->fetch_assoc();
		
						$get_total = $conn->query("SELECT SUM(amount) AS TOTAL FROM payments WHERE ef_id = '". $row['id'] ."'");
						$total_payment = $get_total->fetch_assoc();
						$total = $row['g_tot'] - $total_payment['TOTAL'];

						// $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id'].(isset($id) ? " and id!=$id " : ''));
						// $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
						// $balance = $row['total_fee'] - $paid;
						if ($total != 0) {
							?>
							<option value="<?php echo $row['id'] ?>" data-balance="<?php echo $total ?>" <?php echo isset($ef_id) && $ef_id == $row['stu_id'] ? 'selected' : '' ?>><?php echo  $row['stu_id'].' | '.ucwords($row['stu_name']) ?></option>
							<?php
						}
						}else{
							?>
							<option value="<?php echo $row['id'] ?>" data-balance="<?php echo $row['g_tot'] ?>" <?php echo isset($ef_id) && $ef_id == $row['stu_id'] ? 'selected' : '' ?>><?php echo  $row['stu_id'].' | '.ucwords($row['stu_name']) ?></option>
							<?php
						}
				endwhile; ?>
			</select>
		</div>
		 <div class="form-group">
            <label for="" class="control-label">Outstanding Balance</label>
            <input type="text" class="form-control text-right" id="balance"  value="" required readonly>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Amount</label>
            <input type="number" class="form-control text-right" name="amount" id="amount" value="<?php echo isset($amount) ? number_format($amount) :0 ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Remarks</label>
            <textarea name="remarks" id="" cols="30" rows="3" class="form-control" required=""><?php echo isset($remarks) ? $remarks :'' ?></textarea>
        </div>
	</form>
</div>
<script>
	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#ef_id').change(function(){
		var amount= $('#ef_id option[value="'+$(this).val()+'"]').attr('data-balance')
		$('#balance').val(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
		$("#amount").attr("max", Math.abs(Math.round(amount)))
	})
	$('#manage-payment').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_payment',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							var nw = window.open('receipt.php?ef_id='+resp.ef_id+'&pid='+resp.pid,"_blank","width=1000,height=900")
							setTimeout(function(){
								nw.print()
								setTimeout(function(){
									nw.close()
									location.reload()
								},500)
							},500)
						},500)
				}
			}
		})
	})
</script>
