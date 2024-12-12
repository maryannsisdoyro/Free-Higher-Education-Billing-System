<?php
include('./common.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php 

//echo password_hash("maryannlawan@123456", PASSWORD_DEFAULT);
// echo session_status();

//echo password_hash('mayannlawan@@123', PASSWORD_DEFAULT);

// echo md5('admin123');
include('./db_connect.php');

    // update user password
/*     $password = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("UPDATE users set password = '$password'"); */

    // get all users
/*     $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<pre>";
        print_r($row);
    }
    exit; */
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
	<link rel="icon" type="image/x-icon" href="<?= htmlspecialchars('assets/logo.png') ?>">
 	
<?php include('./header.php'); ?>

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
	<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    	<div class="toast-body text-white">
    	</div>
  	</div>

  <main class="container" id="main" >
  	
  		<div class="align-self-center w-100">
		<h4 class="text-white text-center"><b><?php echo htmlspecialchars($_SESSION['system']['name']) ?></b></h4>
  		<div id="login-center" class="row justify-content-center">
  			<div class="card col-md-4">
  				<div class="card-body">
  					<form id="login-form" method="POST">
  						<div class="form-group">
  							<label for="username" class="control-label">Email</label>
  							<input type="text" id="username" name="email" class="form-control">
  						</div>
						  <label for="password" class="control-label">Password</label>
  							<div style="position: relative;">
                                <input type="password" id="password" name="password" class="form-control my-2">
                             <i class="bx bx-show fs-4" style="cursor: pointer; position: absolute; top: 0; right: 0; margin: 12px 10px 0 0; font-size: 15px;" id="show-pass1"></i>
                            </div>
  						<div class="">
                <a href="terms.php" target="_blank">Terms and Conditions</a>
              </div>
              <div class="d-flex justify-content-between">
                <a href="forgot-password.php">Forgot Password</a>
                <button type="submit" class="btn-sm btn-block btn-wave col-md-4 btn-danger">Login</button>
              <!-- <button
                data-sitekey="6LeWO1YqAAAAALCrSqRbOX0mYKiSSyWWDe65aYB_" 
                data-callback='onSubmit' 
                data-action='login'
                class="g-recaptcha btn-sm btn-block btn-wave col-md-4 btn-danger"
                >
                Submit
            </button> -->
						</div>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


  </body>
  <script src="https://www.google.com/recaptcha/api.js?render=6LeWO1YqAAAAALCrSqRbOX0mYKiSSyWWDe65aYB_"></script>


  <script>
	 window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
  }
  window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
  }
 window.viewer_modal = function($src = ''){
    start_load()
    var t = $src.split('.')
    t = t[1]
    if(t =='mp4'){
      var view = $("<video src='"+$src+"' controls autoplay></video>")
    }else{
      var view = $("<img src='"+$src+"' />")
    }
    $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
    $('#viewer_modal .modal-content').append(view)
    $('#viewer_modal').modal({
            show:true,
            backdrop:'static',
            keyboard:false,
            focus:true
          })
          end_load()  

}
  window.uni_modal = function($title = '' , $url='',$size=""){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                if($size != ''){
                    $('#uni_modal .modal-dialog').addClass($size)
                }else{
                    $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
                }
                $('#uni_modal').modal({
                  show:true,
                  backdrop:'static',
                  keyboard:false,
                  focus:true
                })
                end_load()
            }
        }
    })
}
window._conf = function($msg='',$func='',$params = []){
     $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
     $('#confirm_modal .modal-body').html($msg)
     $('#confirm_modal').modal('show')
  }
   window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }
  $(document).ready(function(){
    $('#preloader').fadeOut('fast', function() {
        $(this).remove();
      })
  })
  $('.datetimepicker').datetimepicker({
      format:'Y/m/d H:i',
      startDate: '+3d'
  })
  $('.select2').select2({
    placeholder:"Please select here",
    width: "100%"
  })

	$('#login-form').submit(function(e){
		e.preventDefault()

    grecaptcha.ready(function() {
      grecaptcha.execute('6LeWO1YqAAAAALCrSqRbOX0mYKiSSyWWDe65aYB_', {action: 'login'}).then(function(token) {
        $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
        if ($(this).find('.alert-danger').length > 0) $(this).find('.alert-danger').remove();
        $.ajax({
          url: 'ajax.php?action=login',
          method: 'POST',
          data: $('#login-form').serialize(),
          error: function(err) {
            console.log(err);
            $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
          },
          success: function(resp) {
            console.log(resp);
            if (resp == 1) {
              alert_toast("Account logged in successfully", 'success');
              setTimeout(function() {
                location.href = 'index.php?page=home';
              }, 1500);
            } else {
              $('#login-form').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>');
              $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
            }
          }
        });
      });
    });
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
