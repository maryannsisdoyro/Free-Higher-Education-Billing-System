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
  	<div class="container mt-5"> <h1 class="text-center">Terms and Conditions for MCC Free Higher Education Billing System</h1> <hr> <section> <h2>1. Eligibility Verification</h2> <p>The administration is responsible for verifying the eligibility of students applying for free tuition under applicable programs.</p> <p>Required documents (e.g., proof of residency, income certificate, academic records) must be reviewed and approved before granting benefits.</p> </section> <section> <h2>2. Data Privacy</h2> <p>All personal information collected during enrollment will be protected in accordance with applicable data privacy laws.</p> <p>Information will only be used for academic and administrative purposes.</p> </section> <section> <h2>3. Fee Coverage and Exclusions</h2> <p>Ensure that free tuition benefits cover only tuition fees, as per program guidelines.</p> <p>Miscellaneous fees (e.g., lab fees, activity fees) should be clearly itemized and billed separately to students.</p> </section> <section> <h2>4. Record Management</h2> <p>Maintain accurate records of enrolled students and their eligibility status for auditing and reporting purposes.</p> <p>Safeguard all personal data in compliance with applicable data privacy laws.</p> </section> <section> <h2>5. Compliance with Regulations</h2> <p>Adhere to government guidelines for free tuition programs, including reporting requirements and benefit limits.</p> <p>Conduct regular reviews to ensure compliance with both internal and external policies.</p> </section> <section> <h2>6. Communication with Students</h2> <p>Clearly communicate the terms of the free tuition program and billing system to students during enrollment.</p> <p>Notify students promptly of any changes to fees, or any program policies.</p> </section> <section> <h2>7. Policy Updates</h2> <p>Any changes to the terms and conditions must be approved by the university administration and communicated to students in advance.</p> </section> </div>
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
