
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-danger dont-print' >
		
		<div class="sidebar-list">
				<div class="mx-2 text-white">Master List</div>
				<a href="../index.php?page=home" class="nav-item nav-home"><span class='icon-field mr-2'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>

				<a href="home.php?page=enrol" class="nav-item nav-enrolled <?= str_contains($_SERVER['REQUEST_URI'], '?page=enrol')  ? 'active' : '' ?>"><span class='icon-field mr-2 '><i class="fa fa-file "></i></span> Enrol Student</a>

				<a href="home.php?page=students" class="nav-item nav-students <?= str_contains($_SERVER['REQUEST_URI'], 'students') || str_contains($_SERVER['REQUEST_URI'], 'page=add-new')  ? 'active' : '' ?>"><span class='icon-field mr-2'><i class="fa fa-users "></i></span> College of Application Form</a>

				<a href="../index.php?page=college-application" class="nav-item nav-enrolled <?= isset($_GET['page']) ? $_GET['page'] == 'college-application'  ? 'active' : '' : '' ?> <?= str_contains($_SERVER['REQUEST_URI'], 'subjects') || str_contains($_SERVER['REQUEST_URI'], 'add-new') || str_contains($_SERVER['REQUEST_URI'], 'edit-enroll.php') ? 'active' : '' ?>"><span class='icon-field mr-2 '><i class="fa fa-inbox "></i></span> Enrollment Database</a>

				<div class="mx-2 text-white">Report</div>

				<!-- <a href="../index.php?page=fees" class="nav-item nav-fees"><span class='icon-field mr-2'><i class="fa fa-money-check "></i></span> Student Fees</a> -->
				<a href="../index.php?page=payments" class="nav-item nav-payments"><span class='icon-field mr-2'><i class="fa fa-receipt "></i></span> Payments</a>

				<a href="../index.php?page=courses" class="nav-item nav-courses"><span class='icon-field mr-2'><i class="fa fa-th-list"></i></span> Courses and fees</a>

				<a href="../index.php?page=payments_report" class="nav-item nav-payments_report"><span class='icon-field mr-2'><i class="fa fa-scroll"></i></span> FHE Form2</a>

			

				<div class="mx-2 text-white">System Settings</div>

				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="../index.php?page=users" class="nav-item nav-users"><span class='icon-field mr-2'><i class="fa fa-users "></i></span> Users</a>
				<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a> -->
				<a href="index.php?page=downloadable_form" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-download"></i></span> Downloadable Form</a>
			<?php endif; ?>
			<a href="home.php?page=settings" class="nav-item nav-settings  <?= str_contains($_SERVER['REQUEST_URI'], 'settings') || str_contains($_SERVER['REQUEST_URI'], 'new-academics')  ? 'active' : '' ?>"><span class='icon-field mr-2'><i class="fa fa-wrench"></i></span> Settings</a>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
