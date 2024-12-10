<?php
include('./common.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php 
include('./db_connect.php');

// Get the current session token and user-agent
$currentSessionToken = $_COOKIE['session_token'] ?? null;
$currentUserAgent = $_SERVER['HTTP_USER_AGENT'];

echo $currentUserAgent; exit;

// Fetch users with sessions matching the current browser
	$users = [];
	if ($currentSessionToken) {
		$query = "
			SELECT DISTINCT users.id, users.name 
			FROM user_sessions
			INNER JOIN users ON user_sessions.user_id = users.id
			WHERE user_sessions.user_agent = ? AND user_id != ?
		";

		// Prepare the statement
		$stmt = $conn->prepare($query);
		$stmt->bind_param('si', $currentUserAgent, 100);
		$stmt->execute();

		// Fetch the results
		$result = $stmt->get_result();
		$users = $result->fetch_all(MYSQLI_ASSOC); // Fetch as associative array

		// Free the statement
		$stmt->close();
	}
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
		<h4 class="text-white text-center"><b></b></h4>
  		<div id="login-center" class="row justify-content-center">
  			<div class="card col-md-4">
  				<div class="card-body">
				  <form action="switch_user.php" id="jq-switch" method="POST" class="mt-3">
						<div class="mb-3">
							<label for="switch_user" class="form-label">Switch to another account:</label>
							<select name="user_id" id="switch_user" class="form-control form-select">
								<?php if (empty($users)): ?>
									<option value="">No users logged in with this browser</option>
								<?php else: ?>
									// add current user to the list
									<option value="<?= htmlspecialchars($_SESSION['login_id']) ?>">
										<?= htmlspecialchars($_SESSION['login_name']) ?>
									</option>
									<?php foreach ($users as $user): ?>
										<option value="<?= htmlspecialchars($user->id) ?>">
											<?= htmlspecialchars($user->name) ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Switch User</button>
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
