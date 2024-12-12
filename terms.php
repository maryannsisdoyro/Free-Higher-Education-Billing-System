<?php
include('./common.php');
?>
<!DOCTYPE html>
<html lang="en">
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
		color: #fff;
	}
	main#main{
		width:100%;
		height: 100vh;
		display: flex;
	}
	section {
		padding: 0;
		overflow: hidden;
	}
</style>

<body class="">
	<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    	<div class="toast-body text-white">
    	</div>
  	</div>

  <main class="container" id="main">
  		<div class="container mt-5"> 
			<h1 class="text-center">Terms and Conditions</h1> 
			<hr> 
			<section> 
				<h2>1. Acceptance of Terms</h2>
				 <p>By accessing or using our web system, you agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our service.</p> </section> <section> <h2>2. User Accounts</h2> <ul> <li>You must provide accurate and complete information when creating an account.</li> <li>You are responsible for maintaining the confidentiality of your account and password.</li> <li>You agree to notify us immediately of any unauthorized use of your account.</li> </ul> </section> <section> <h2>3. User Conduct</h2> <ul> <li>You agree to use the service only for lawful purposes.</li> <li>You must not use the service to upload, post, or transmit any content that is illegal, offensive, or infringes on the rights of others.</li> <li>You must not attempt to gain unauthorized access to the service or its related systems.</li> </ul> </section> <section> <h2>4. Intellectual Property</h2> <ul> <li>All content on this web system, including text, graphics, logos, and software, is the property of [Your Company Name] or its content suppliers.</li> <li>You may not reproduce, distribute, or create derivative works from this content without our express written permission.</li> </ul> </section> <section> <h2>5. Privacy</h2> <p>We are committed to protecting your privacy. Please review our Privacy Policy for details on how we collect, use, and protect your information.</p> </section> <section> <h2>6. Disclaimers and Limitation of Liability</h2> <ul> <li>The service is provided "as is" without warranties of any kind, either express or implied.</li> <li>We do not guarantee that the service will be uninterrupted or error-free.</li> <li>We are not liable for any direct, indirect, incidental, or consequential damages arising out of your use of the service.</li> </ul> </section> <section> <h2>7. Changes to Terms</h2> <p>We reserve the right to modify these Terms and Conditions at any time. Your continued use of the service following any changes signifies your acceptance of the new terms.</p> </section> <section> <h2>8. Governing Law</h2> <p>These terms and conditions are governed by and construed in accordance with the laws of [Your Jurisdiction].</p> </section> <section> <h2>9. Contact Information</h2> <p>If you have any questions about these Terms and Conditions, please contact us at [Your Contact Information].</p> </section> </div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


  </body>

<script src="https://www.google.com/recaptcha/api.js?render=6LeWO1YqAAAAALCrSqRbOX0mYKiSSyWWDe65aYB_"></script>
<script>
	$(document).ready(function(){
		$('#switch_user').on('submit', function(){
			var user = $('#switch_user').val();
			if (user != '' || user != null) {
				$.ajax({
					url: 'ajax.php?action=switch_user',
					method: 'POST',
					data: $('#switch_user').serialize(),
					error: function(err) {
						console.log(err);
						$('#switch_user button[type="button"]').removeAttr('disabled').html('Login');
					},
					success: function(resp) {
						console.log(resp);
						if (resp == 1) {
							alert_toast("Account logged in successfully", 'success');
							setTimeout(function() {
								location.href = 'index.php?page=home';
							}, 1500);
						} else {
							$('#switch_user').prepend('<div class="alert alert-danger">Unable to switch user!</div>');
							$('#switch_user button[type="button"]').removeAttr('disabled').html('Login');
						}
					}
				});
			}
		})
	})
</script>
</html>
