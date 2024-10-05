o<!DOCTYPE html>
<html lang="en">
<?php 
session_start();


// echo password_hash('mayannlawan@@123', PASSWORD_DEFAULT);

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
	<link rel="icon" type="image/x-icon" href="assets/logo.png">
 	

<?php include('./header.php'); ?>
<?php 
$auth_id = implode(explode('/login.php/', $_SERVER['REQUEST_URI']);
if(htmlspecialchars($_SESSION['auth_login']) !== htmlspecialchars(stripslashes(trim($auth_id)))){
header('location: index.php?page=home');
}

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
  					<form id="login-form" >
						
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
						  <label for="password" class="control-label">Password</label>
  							<div style="position: relative;">
                                <input type="password" id="password" name="password" class="form-control my-2">
                             <i class="bx bx-show fs-4" style="cursor: pointer; position: absolute; top: 0; right: 0; margin: 12px 10px 0 0; font-size: 15px;" id="show-pass1"></i>
                            </div>
  						<div class="d-flex justify-content-between">
						<a href="forgot-password.php">Forgot Password</a>
						  <button class="btn-sm btn-block btn-wave col-md-4 btn-danger">Login</button>
						</div>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	

<script>
     let showPass1 = document.getElementById('show-pass1');
    showPass1.onclick = () => {
        let passwordInp = document.forms['login-form']['password'];
        if (passwordInp.getAttribute('type') == 'password') {
            showPass1.classList.replace('bx-show', 'bx-low-vision')
            passwordInp.setAttribute('type', 'text')
        } else {
            showPass1.classList.replace('bx-low-vision', 'bx-show')
            passwordInp.setAttribute('type', 'password')
        }
    }
</script>
</html>
