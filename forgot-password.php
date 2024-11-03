<!DOCTYPE html>
<html lang="en">
<?php 
session_start();

// echo md5('admin123');
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
// }
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		background:linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3)), url('./assets/bg-img.jpg');
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
	}
	main#main{
		width:100%;
		height: 100vh;
		display: flex;
	}

</style>

<body class="bg-dark">


  <main class="container" id="main" >
  	
  		<div class="align-self-center w-100">
		<h4 class="text-white text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
  		<div id="login-center" class="row justify-content-center">
  			<div class="card col-md-4">
  				<div class="card-body">
  					<form id="forgot-pass" >
                      <h5>Forgot password</h5>
						
  						<div class="form-group">
  							<label for="email" class="control-label">Email Account</label>
  							<input type="email" id="email" name="email" class="form-control">
  						</div>
  						<div class="d-flex justify-content-between">
						    <a href="login.php">Cancel</a>
						  <button class="btn-sm btn-block btn-wave col-md-4 btn-danger">Submit</button>
						</div>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>

		  <?php include 'footer.php' ?>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#forgot-pass').submit(function(e){
		e.preventDefault()
		$('#forgot-pass button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=forgotPassword',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#forgot-pass button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='reset-password.php';
				}else{
                    // console.log(resp);
					$('#forgot-pass').prepend('<div class="alert alert-danger">Account doesn\'t exist</div>')
					$('#forgot-pass button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>