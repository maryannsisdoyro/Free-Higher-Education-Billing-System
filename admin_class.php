<?php
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "./phpmailer/src/Exception.php";
require "./phpmailer/src/PHPMailer.php";
require "./phpmailer/src/SMTP.php";
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function clean($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function login()
	{
		// Sanitize and prepare username and password
		$username = htmlspecialchars(stripslashes(trim($_POST['username'])));
		$password = htmlspecialchars(stripslashes(trim($_POST['password'])));

		// Check if the username and password are not empty
		if (empty($username) || empty($password)) {
			return 'empty username password'; // Return error if username or password is empty
		}

		// Prepare SQL query to fetch the user
		$stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$qry = $stmt->get_result();

		// Check if user exists
		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();

			// Verify the password using password_verify
			if (password_verify($password, $row['password'])) {
				// Set session variables after successful login
				$_SESSION['login_id'] = $row['id'];
				$_SESSION['login_name'] = $row['name'];
				$_SESSION['login_username'] = $row['username'];
				$_SESSION['login_type'] = $row['type'];
				$_SESSION['login_verification'] = $row['verification'];

				return 1; // Success: Logged in
			} else {
				return 'incorrect password'; // Incorrect password
			}
		} else {
			return 'user not found'; // Username not found
		}
	}

	function login2()
	{

		extract($_POST);
		$qry = $this->db->query("SELECT * FROM complainants where email = '" . $email . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function backUp(){
		
	}

	function save_user()
	{
		// Extract POST data securely
		extract($_POST);

		// Sanitize inputs
		$name = htmlspecialchars(trim($name));
		$username = htmlspecialchars(trim($username));
		$password = !empty($password) ? trim($password) : null;
		$confirm = !empty($confirm) ? trim($confirm) : null;
		$type = intval($type); // Ensure 'type' is an integer

		if ($password) {
			if (!$this->validatePassword($password)) {
				return 3; // Password does not meet the criteria
			}

			if ($password !== $confirm) {
				return 4; // Passwords do not match
			}
		}

		try {
			// Check if the username already exists
			$stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$existing_user = $result->fetch_assoc();

			if (empty($id)) { // New user
				if ($existing_user) {
					return 2; // Username already exists
				}

				// Hash the password securely
				$hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

				// Insert new user
				$stmt = $this->db->prepare("INSERT INTO users (name, username, password, type) VALUES (?, ?, ?, ?)");
				$stmt->bind_param('ssss', $name, $username, $hashed_password, $type); // 'ssss' indicates that all four parameters are strings

			} else { // Update existing user
				$id = intval($id); // Ensure 'id' is an integer

				if ($existing_user && $existing_user['id'] != $id) {
					return 2; // Username already exists
				}

				// Update user data
				$update_query = "UPDATE users SET name = ?, username = ?, type = ?";
				if (!empty($password)) {
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);
					$update_query .= ", password = ?";
				}
				$update_query .= " WHERE id = ?";

				$stmt = $this->db->prepare($update_query);
				// Bind parameters
				if (!empty($password)) {
					// 'ssss' for name, username, password (if provided), and type (integer)
					$stmt->bind_param('ssisi', $name, $username, $type, $hashed_password, $id);
				} else {
					// 'sssi' for name, username, type (integer), and id
					$stmt->bind_param('ssii', $name, $username, $type, $id);
				}
			}

			// Execute the query
			if ($stmt->execute()) {
				return 1; // Success
			} else {
				return 0; // Query execution failed
			}

		} catch (mysqli_sql_exception $e) {
			// Log error and return a failure response
			//error_log("Database error: " . $e->getMessage());
			return 0; // General failure
		}
	}

	function validatePassword($password) {
		// Check if password matches the criteria
		$pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,20}$/';
		
		if (preg_match($pattern, $password)) {
			return true;
		} else {
			return false;
		}
	}

	function delete_user()
	{
		if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			return 0;
		}
	
		$id = intval($_POST['id']);
	
		$stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	
		return $stmt->execute() ? 1 : 0;
	}
	function signup()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", address = '$address' ";
		$data .= ", contact = '$contact' ";
		$data .= ", password = '" . md5($password) . "' ";
		$chk = $this->db->query("SELECT * from complainants where email ='$email' " . (!empty($id) ? " and id != '$id' " : ''))->num_rows;
		if ($chk > 0) {
			return 3;
			exit;
		}
		if (empty($id))
			$save = $this->db->query("INSERT INTO complainants set $data");
		else
			$save = $this->db->query("UPDATE complainants set $data where id=$id ");
		if ($save) {
			if (empty($id))
				$id = $this->db->insert_id;
			$qry = $this->db->query("SELECT * FROM complainants where id = $id ");
			if ($qry->num_rows > 0) {
				foreach ($qry->fetch_array() as $key => $value) {
					if ($key != 'password' && !is_numeric($key))
						$_SESSION['login_' . $key] = $value;
				}
				return 1;
			} else {
				return 3;
			}
		}
	}

	function update_account()
	{
		if (!isset($_POST['name'], $_POST['username'])) {
			return json_encode($_POST);
		}

		$name = htmlspecialchars(trim($_POST['name']));
		$username = htmlspecialchars(trim($_POST['username']));
		$password = isset($_POST['password']) ? $_POST['password'] : '';
	
		$data = [];
		$data['name'] = $name;
		$data['username'] = $username;
	
		if (!empty($password)) {
			$data['password'] = md5($password);
		}
	
		$user_id = $_SESSION['login_id'];
	
		$sql = "UPDATE users SET name = :name, username = :username";
		
		if (isset($data['password'])) {
			$sql .= ", password = :password";
		}
	
		$sql .= " WHERE id = :id";
	
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':name', $data['name']);
		$stmt->bindParam(':username', $data['username']);

		if (isset($data['password'])) {
			$stmt->bindParam(':password', $data['password']);
		}

		$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
	
		if ($stmt->execute()) {
			return 1;
		}
	
		return json_encode($_POST);
	}

	function save_settings()
	{
		extract($_POST);
		$data = " name = '" . str_replace("'", "&#x2019;", $name) . "' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '" . htmlentities(str_replace("'", "&#x2019;", $about)) . "' ";
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", cover_img = '$fname' ";
		}

		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE system_settings set " . $data);
		} else {
			$save = $this->db->query("INSERT INTO system_settings set " . $data);
		}
		if ($save) {
			$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
			foreach ($query as $key => $value) {
				if (!is_numeric($key))
					$_SESSION['system'][$key] = $value;
			}

			return 1;
		}
	}
	function save_course()
	{
		extract($_POST);
		$data = "";

		$courses = [
			'BSIT' => 'Bachelor of Science in Information Technology',
			'BSBA' => 'Bachelor of Science in Business Administration',
			'BSHM' => 'Bachelor of Science in Hotel Management',
			'BSED' => 'Bachelor of Secondary Education',
			'BEED' => 'Bachelor of Elementary Education'
		];

		
		$new_course = $this->clean($courses[$_POST['course']]);
		$key = $this->clean($_POST['course']);
		$level = $this->clean($_POST['level']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic = $this->clean($_POST['academic']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$total_amount = $this->clean($_POST['total_amount']);
		$semester = $this->clean($_POST['semester']);


		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'fid', 'type', 'amount')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM courses where course ='$course' and level ='$level' and semester = '$semester' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO courses set course = '$new_course', department='$key', level = '$level',
			laboratory = $laboratory,
			computer = $computer,
			academic = $academic,
			semester = '$semester',
			academic_nstp = $academic_nstp,
			total_amount = $total_amount");
			if ($save) {
				$id = $this->db->insert_id;
				foreach ($fid as $k => $v) {
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					$save2[] = $this->db->query("INSERT INTO fees set $data");
				}
				if (isset($save2))
					return 1;
			}
		} else {
			$save = $this->db->query("UPDATE courses set course='$new_course', department='$key', level = '$level',
			semester = '$semester',
			laboratory = $laboratory,
			computer = $computer,
			academic = $academic,
			academic_nstp = $academic_nstp,
			total_amount = $total_amount where id = $id");
			if ($save) {

				$id = $this->db->real_escape_string($_POST['id']);
				$fid = array_map([$this->db, 'real_escape_string'], $_POST['fid']);

				$this->db->query("DELETE FROM fees WHERE course_id = '$id' AND id NOT IN ('" . implode("','", $fid) . "')");

				$save2 = [];
				for ($i = 0; $i < count($_POST['type']); $i++) {
					$description = $this->db->real_escape_string($_POST['type'][$i]);
					$amount = $this->db->real_escape_string($_POST['amount'][$i]);

					if (empty($_POST['fid'][$i])) {
						$save2[] = $this->db->query("INSERT INTO fees (course_id, description, amount) VALUES ('$id', '$description', '$amount')");
					} else {
						$fid_escaped = $this->db->real_escape_string($_POST['fid'][$i]);
						$save2[] = $this->db->query("UPDATE fees SET description = '$description', amount = '$amount' WHERE id = '$fid_escaped'");
					}
				}

				if (isset($save2))
					return 1;
			}
		}
	}
	function delete_course()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM courses where id = " . $id);
		$delete2 = $this->db->query("DELETE FROM fees where course_id = " . $id);
		if ($delete && $delete2) {
			return 1;
		}
	}
	function get_fees(){
		
		extract($_POST);
		$course = $_POST['course_id'];
		$year_level = $_POST['year_level'];

		$get_course = $this->db->query("SELECT * FROM courses WHERE department = '$course' AND level = '$year_level'");
		$course_data = $get_course->fetch_assoc();
		$course_id = $course_data['id'];

		$query = $this->db->query("SELECT * FROM fees WHERE course_id = $course_id");
		$all_data = [];
		foreach($query as $row){
			$all_data[] = [
				$row['id'],
				$row['description'],
				$row['amount']
			];
		}

		return json_encode($all_data);
	}
	function save_student()
	{
		extract($_POST);
		$fullname = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'];
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM student where id_no ='$id_no' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {

			$save = $this->db->query("INSERT INTO student set $data , name = '$fullname'");
		} else {
			$save = $this->db->query("UPDATE student set $data , name = '$fullname' where id = $id");
		}
		if ($save)
			return 1;
	}
	function delete_student()
	{
		if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			return 0;
		}

		$id = intval($_POST['id']);
		$stmt = $this->db->prepare("DELETE FROM student WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		return $stmt->execute() ? 1 : 0;
	}
	function save_fees()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if ($k == 'total_fee') {
					$v = str_replace(',', '', $v);
				}
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM student_ef_list where ef_no ='$ef_no' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO student_ef_list set $data");
		} else {
			$save = $this->db->query("UPDATE student_ef_list set $data where id = $id");
		}
		if ($save)
			return 1;
	}
	function delete_fees()
	{
		if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			return 0;
		}
	
		$id = intval($_POST['id']);
		$stmt = $this->db->prepare("DELETE FROM student_ef_list WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		return $stmt->execute() ? 1 : 0;
	}
	function save_payment()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if ($k == 'amount') {
					$v = str_replace(',', '', $v);
				}
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO payments set $data");
			if ($save)
				$id = $this->db->insert_id;
		} else {
			$save = $this->db->query("UPDATE payments set $data where id = $id");
		}
		if ($save)
			return json_encode(array('ef_id' => $ef_id, 'pid' => $id, 'status' => 1));
	}

	function delete_payment()
	{
		try {
			if (!isset($_POST['id'])) {
				return 0;
			}
			
			$id = intval($_POST['id']);

			if ($id <= 0) {
				return 0;
			}

			$stmt = $this->db->prepare("DELETE FROM payments WHERE id = :id");
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);

			if ($stmt->execute()) {
				return 1;
			} else {
				return 0;
			}
		} catch (PDOException $e) {
			return 0;
		}
	}

	function forgotPassword()
	{
		try {
			$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
	
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return 2;
			}
	
			$stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
	
			if ($stmt->rowCount() > 0) {
				$verification = uniqid();
	
				$update_stmt = $this->db->prepare("UPDATE users SET verification = :verification WHERE email = :email");
				$update_stmt->bindParam(':verification', $verification, PDO::PARAM_STR);
				$update_stmt->bindParam(':email', $email, PDO::PARAM_STR);
	
				if ($update_stmt->execute()) {
					$mail = new PHPMailer(true);
	
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'sisdoyromaryannlawan20@gmail.com';
					$mail->Password = 'ggeurvotkedugblo';
					$mail->Port = 587;
	
					$mail->setFrom('mccfhebilling@gmail.com', 'MCC Free Higher Education');
					$mail->addAddress($email);
					$mail->Subject = "Reset Password Verification Code";
					$mail->Body = "Here is your verification code: " . $verification;
	
					$mail->SMTPOptions = [
						'ssl' => [
							'verify_peer' => true,
							'verify_peer_name' => true,
							'allow_self_signed' => false,
						],
					];
	
					if ($mail->send()) {
						return 1;
					} else {
						return 2;
					}
				} else {
					return 2;
				}
			} else {
				return 2;
			}
		} catch (Exception $e) {
			return 2;
		}
	}

	function resetPassword()
	{
		try {
			$verification = htmlspecialchars(trim($_POST['verification']));
			$new = $_POST['new'];
			$confirm = $_POST['confirm'];
	
			if (empty($verification) || empty($new) || empty($confirm)) {
				return 3;
			}
	
			if ($new !== $confirm) {
				return 2;
			}
	
			// Use prepared statements to securely query the database
			$stmt = $this->db->prepare("SELECT id FROM users WHERE verification = :verification");
			$stmt->bindParam(':verification', $verification, PDO::PARAM_STR);
			$stmt->execute();
	
			if ($stmt->rowCount() > 0) {
				$hashed_password = md5($new);
	
				// Update the password securely
				$update_stmt = $this->db->prepare("UPDATE users SET password = :password WHERE verification = :verification");
				$update_stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
				$update_stmt->bindParam(':verification', $verification, PDO::PARAM_STR);
	
				if ($update_stmt->execute()) {
					return 1;
				} else {
					return 3;
				}
			} else {
				return 3;
			}
		} catch (PDOException $e) {
			return 3;
		}
	}

	// function importCsvEnrollment(){
	// 	// Define the MIME types of the CSV files.
	// 	$csvMimes = array(
	// 		'text/x-comma-separated-values', 'text/comma-separated-values', 
	// 		'application/octet-stream', 'application/vnd.ms-excel', 
	// 		'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 
	// 		'application/excel', 'application/vnd.msexcel'
	// 	); 

	// 	if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){ 

	// 		if(is_uploaded_file($_FILES['file']['tmp_name'])){ 

	// 			$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

	// 			fgetcsv($csvFile);
	// 			$i = 0;


	// 			function getFirstThreeWords($sentence) {
	// 				// Split the sentence into an array of words
	// 				$words = explode(' ', $sentence);

	// 				// Initialize $fname and $lname
	// 				$fname = '';
	// 				$lname = $words[0] ?? '';
	// 				$lastWord = $words[count($words) - 1] ?? '';

	// 				// Get the first, second, and third words based on the number of words in the sentence
	// 				if (count($words) == 4) {
	// 					$fname = ($words[1] ?? '') . ' ' . ($words[2] ?? '');
	// 				} else if (count($words) == 5) {
	// 					$fname = ($words[1] ?? '') . ' ' . ($words[2] ?? '') . ' ' . ($words[3] ?? '');
	// 				} else {
	// 					$fname = $words[1] ?? '';
	// 				}

	// 				return array(trim($lname), trim($fname), trim($lastWord));
	// 			}


	// 			while(($line = fgetcsv($csvFile)) !== FALSE){ 

	// 				$line_arr = !empty($line) ? array_filter($line) : ''; 
	// 				if(!empty($line_arr)){ 
	// 					$application_no = trim($line_arr[1]) ?? '';
	// 					$stu_id = trim($line_arr[2]) ?? '';
	// 					$year_level = trim($line_arr[3]) ?? '';
	// 					$stu_name = trim($line_arr[4]) ?? '';
	// 					$stu_sta = trim($line_arr[5]) ?? '';

	// 					if (trim($line_arr[6]) == 'BS-HM') {
	// 						$course = "BSHM";
	// 					}else{
	// 						$course = trim($line_arr[6]) ?? '';
	// 					}

	// 					$major = trim($line_arr[7]) ?? '';
	// 					$section = trim($line_arr[8]) ?? '';
	// 					$curr = trim($line_arr[9]) ?? '';
	// 					$reli = trim($line_arr[10]) ?? '';
	// 					$con_no = trim($line_arr[11]) ?? '';
	// 					$home_ad = trim($line_arr[12]) ?? '';
	// 					$civil = trim($line_arr[13]) ?? '';
	// 					$d_birth = trim($line_arr[14]) ?? '';
	// 					$p_birth = trim($line_arr[15]) ?? '';
	// 					$ele = trim($line_arr[16]) ?? '';
	// 					$ele_year = trim($line_arr[17]) ?? '';
	// 					$high = trim($line_arr[18]) ?? '';
	// 					$high_year = trim($line_arr[19]) ?? '';
	// 					$last_sc = trim($line_arr[20]) ?? '';
	// 					$last_year = trim($line_arr[21]) ?? '';
	// 					$tot_units = trim($line_arr[22]) ?? '';
	// 					$un_enrol = trim($line_arr[23]) ?? '';
	// 					$rate_per = trim($line_arr[24]) ?? '';
	// 					$total = trim($line_arr[25]) ?? '';
	// 					$lib = trim($line_arr[26]) ?? '';
	// 					$com = trim($line_arr[27]) ?? '';
	// 					$lab1 = trim($line_arr[28]) ?? '';
	// 					$lab2 = trim($line_arr[29]) ?? '';
	// 					$lab3 = trim($line_arr[30]) ?? '';
	// 					$sch_id = trim($line_arr[31]) ?? '';
	// 					$ath = trim($line_arr[32]) ?? '';
	// 					$adm = trim($line_arr[33]) ?? '';
	// 					$dev = trim($line_arr[34]) ?? '';
	// 					$guid = trim($line_arr[35]) ?? '';
	// 					$hand = trim($line_arr[36]) ?? '';
	// 					$entr = trim($line_arr[37]) ?? '';
	// 					$reg_fe = trim($line_arr[38]) ?? '';
	// 					$med_den = trim($line_arr[39]) ?? '';
	// 					$cul = trim($line_arr[40]) ?? '';
	// 					$t_misfe = trim($line_arr[41]) ?? '';
	// 					$g_tot = trim($line_arr[42]) ?? '';
	// 					$image = trim($line_arr[43]) ?? '';

	// 					// $sentence =;
	// 					$fname = getFirstThreeWords($stu_name)[1];
	// 					$lname = getFirstThreeWords($stu_name)[0];
	// 					$mname = getFirstThreeWords($stu_name)[2];

	// 						$stmt = $this->db->query("INSERT INTO enroll2024
	// 						(
	// 							application_no,
	// 							stu_id,
	// 							year_level,
	// 							stu_name,
	// 							stu_sta,
	// 							course,
	// 							major,
	// 							section,
	// 							curr,
	// 							reli,
	// 							con_no,
	// 							home_ad,
	// 							civil,
	// 							d_birth,
	// 							p_birth,
	// 							ele,
	// 							ele_year,
	// 							high,
	// 							high_year,
	// 							last_sc,
	// 							last_year,
	// 							tot_units,
	// 							un_enrol,
	// 							rate_per,
	// 							total,
	// 							lib,
	// 							com,
	// 							lab1,
	// 							lab2,
	// 							lab3,
	// 							sch_id,
	// 							ath,
	// 							adm,
	// 							dev,
	// 							guid,
	// 							hand,
	// 							entr,
	// 							reg_fe,
	// 							med_den,
	// 							cul,
	// 							t_misfe,
	// 							g_tot,
	// 							image,
	// 							fname,
	// 							lname,
	// 							mname
	// 						) 
	// 						VALUES
	// 						(
	// 							'$application_no',
	// 							'$stu_id',
	// 							'$year_level',
	// 							'$stu_name',
	// 							'$stu_sta',
	// 							'$course',
	// 							'$major',
	// 							'$section',
	// 							'$curr',
	// 							'$reli',
	// 							'$con_no',
	// 							'$home_ad',
	// 							'$civil',
	// 							'$d_birth',
	// 							'$p_birth',
	// 							'$ele',
	// 							'$ele_year',
	// 							'$high',
	// 							'$high_year',
	// 							'$last_sc',
	// 							'$last_year',
	// 							'$tot_units',
	// 							'$un_enrol',
	// 							'$rate_per',
	// 							'$total',
	// 							'$lib',
	// 							'$com',
	// 							'$lab1',
	// 							'$lab2',
	// 							'$lab3',
	// 							'$sch_id',
	// 							'$ath',
	// 							'$adm',
	// 							'$dev',
	// 							'$guid',
	// 							'$hand',
	// 							'$entr',
	// 							'$reg_fe',
	// 							'$med_den',
	// 							'$cul',
	// 							'$t_misfe',
	// 							'$g_tot',
	// 							'$image',
	// 							'$fname',
	// 							'$lname',
	// 							'$mname'
	// 						)");


	// 					if ($stmt) {
	// 						$i++;
	// 					}

	// 				} 


	// 			}


	// 			fclose($csvFile);

	// 			if ($stmt) {
	// 				return json_encode(['status' => 1]);
	// 			}


	// 		} else {
	// 			return json_encode(['status' => 0, 'message' => 'File upload failed.']);
	// 		}
	// 	} else {
	// 		return json_encode(['status' => 0, 'message' => 'Invalid file type.']);
	// 	}
	// }

	function importCsvEnrollment()
	{
		$conn = $this->db;

		function getFirstThreeWords($sentence)
	{
		// Split the sentence into an array of words
		$words = explode(' ', $sentence);

		// Initialize $fname and $lname
		$fname = '';
		$lname = $words[0] ?? '';
		$lastWord = $words[count($words) - 1] ?? '';

		// Get the first, second, and third words based on the number of words in the sentence
		if (count($words) == 4) {
			$fname = ($words[1] ?? '') . ' ' . ($words[2] ?? '');
		} else if (count($words) == 5) {
			$fname = ($words[1] ?? '') . ' ' . ($words[2] ?? '') . ' ' . ($words[3] ?? '');
		} else {
			$fname = $words[1] ?? '';
		}

		return array(trim($lname), trim($fname), trim($lastWord));
	}

		if ($_FILES['file']['name']) {
			$filename = explode(".", $_FILES['file']['name']);
			if (end($filename) == "csv") {
				$handle = fopen($_FILES['file']['tmp_name'], "r");
				while ($data = fgetcsv($handle)) {
					// Assuming CSV has columns: id, name, email
					$application_no = mysqli_real_escape_string($conn, $data[1]);
					$stu_id = mysqli_real_escape_string($conn, $data[2]);
					$year_level = mysqli_real_escape_string($conn, $data[3]);
					$stu_name = mysqli_real_escape_string($conn, $data[4]);
					$fname = getFirstThreeWords($stu_name)[1];
					$lname = getFirstThreeWords($stu_name)[0];
					$mname = getFirstThreeWords($stu_name)[2];
					$stu_sta = mysqli_real_escape_string($conn, $data[5]);

					if ($data[6] == 'BS-HM') {
						$course = "BSHM";
					}{
						$course = mysqli_real_escape_string($conn, $data[6]);
					}

					$major = mysqli_real_escape_string($conn, $data[7]);
					$section = mysqli_real_escape_string($conn, $data[8]);
					$curr = mysqli_real_escape_string($conn, $data[9]);
					$reli = mysqli_real_escape_string($conn, $data[10]);
					$con_no = mysqli_real_escape_string($conn, $data[11]); 
					$home_ad = mysqli_real_escape_string($conn, $data[12]);
					$civil = mysqli_real_escape_string($conn, $data[13]);
					$d_birth = mysqli_real_escape_string($conn, $data[14]);
					$p_birth = mysqli_real_escape_string($conn, $data[15]);
					$ele =  mysqli_real_escape_string($conn, $data[16]);
					$ele_year =  mysqli_real_escape_string($conn, $data[17]);
					$high =  mysqli_real_escape_string($conn, $data[18]);
					$high_year =  mysqli_real_escape_string($conn, $data[19]);
					$last_sc =  mysqli_real_escape_string($conn, $data[20]);
					$last_year =  mysqli_real_escape_string($conn, $data[21]);
					$tot_units =  mysqli_real_escape_string($conn, $data[22]);
					$un_enrol =  mysqli_real_escape_string($conn, $data[23]);
					$rate_per =  mysqli_real_escape_string($conn, $data[24]);
					$total =  mysqli_real_escape_string($conn, $data[25]);
					$lib =  mysqli_real_escape_string($conn, $data[26]);
					$com =  mysqli_real_escape_string($conn, $data[27]);
					$lab1 =  mysqli_real_escape_string($conn, $data[28]);
					$lab2 =  mysqli_real_escape_string($conn, $data[29]);
					$lab3 =  mysqli_real_escape_string($conn, $data[30]);
					$sch_id =  mysqli_real_escape_string($conn, $data[31]);
					$ath =  mysqli_real_escape_string($conn, $data[32]);
					$adm =  mysqli_real_escape_string($conn, $data[33]);
					$dev =  mysqli_real_escape_string($conn, $data[34]);
					$guid =  mysqli_real_escape_string($conn, $data[35]);
					$hand =  mysqli_real_escape_string($conn, $data[36]);
					$entr =  mysqli_real_escape_string($conn, $data[37]);
					$reg_fe =  mysqli_real_escape_string($conn, $data[38]);
					$med_den =  mysqli_real_escape_string($conn, $data[39]);
					$cul =  mysqli_real_escape_string($conn, $data[40]);
					$t_misfe =  mysqli_real_escape_string($conn, $data[41]);
					$g_tot =  mysqli_real_escape_string($conn, $data[42]);
					$image =  mysqli_real_escape_string($conn, $data[43]);

					$query = "INSERT INTO enroll2024 (application_no,stu_id,year_level,stu_name,fname,mname,lname,stu_sta,major,course,section,curr,reli,d_birth,p_birth,con_no,home_ad,civil,ele,
					ele_year,high,high_year,last_sc,last_year,tot_units,un_enrol,rate_per,total,lib,com,lab1,lab2,lab3,sch_id,ath,adm,dev,guid,hand,entr,reg_fe,med_den,cul,t_misfe,g_tot,image) VALUES('$application_no', '$stu_id', '$year_level', '$stu_name', '$fname','$mname','$lname','$stu_sta','$major','$course','$section','$curr','$reli','$d_birth','$p_birth','$con_no','$home_ad','$civil','$ele','$ele_year','$high','$high_year','$last_sc','$last_year','$tot_units','$un_enrol','$rate_per','$total','$lib','$com','$lab1','$lab2','$lab3','$sch_id','$ath','$adm','$dev','$guid','$hand','$entr','$reg_fe','$med_den','$cul','$t_misfe','$g_tot','$image')";
					$conn->query($query);
				}
				fclose($handle);
				return json_encode(['status' => 1]);
			}
		} else {
			echo "Please select a file.";
		}

		$conn->close();
	}


	function save_shiftee()
	{
		extract($_POST);
		$conn = $this->db;

		$enroll_id = $this->clean($_POST['id']);
		$course = $this->clean($_POST['course']);
		$year_level = $this->clean($_POST['year_level']);
		// $section = $this->clean($_POST['section']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic_unit = $this->clean($_POST['academic_unit']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$type_shiftee =$_POST['type_shiftee'];
		$amount_shiftee =$_POST['amount_shiftee'];

		$stu_id = $this->clean($_POST['stu_id']);
        $year_level = $this->clean($_POST['year_level']);
        // $section = $this->clean($_POST['section']);
        $semester = $this->clean($_POST['semester']);
        $academic = $this->clean($_POST['academic']);
        $stud_status = $this->clean($_POST['submit']);


		$get_enroll = $conn->query("SELECT * FROM enroll2024 WHERE stu_id = '$stu_id' ORDER BY id DESC");
        $data = $get_enroll->fetch_assoc();

        $get_academic = $conn->query("SELECT * FROM academic WHERE id = '$academic'");
        $res_academic = $get_academic->fetch_array();
        $curr = $this->clean($res_academic['year']);
        $semester = $this->clean($res_academic['semester']);

        $fname = $this->clean($data['fname']);
        $mname = $this->clean($data['mname']);
        $lname = $this->clean($data['lname']);
        $application_no = $this->clean($data['application_no']);
        $stu_name = $this->clean($data['stu_name']);
        $stu_id = $this->clean($data['stu_id']);
        $stu_sta = $this->clean($data['stu_sta']);
        // $course = $this->clean($data['course']);
        $majorOutput1 = $this->clean($data['major']);
        // $selectedSection1 = $this->clean($data['selectedSection1']);
        // $curr = $this->clean($data['curr']);
        $religiousOutput1 = $this->clean($data['reli']);
        $con_no = $this->clean($data['con_no']);
        $home_ad = $this->clean($data['home_ad']);
        $civil = $this->clean($data['civil']);
        $d_birth = $this->clean($data['d_birth']);
        $p_birth = $this->clean($data['p_birth']);
        $ele = $this->clean($data['ele']);
        $ele_year = $this->clean($data['ele_year']);
        $high = $this->clean($data['high']);
        $high_year = $this->clean($data['high_year']);
        $last_sc = $this->clean($data['last_sc']);
        $last_year = $this->clean($data['last_year']);
        $tot_units = $this->clean($data['tot_units']);
        $un_enrol = $this->clean($data['un_enrol']);
        $rate_per = $this->clean($data['rate_per']);
        $total = $this->clean($data['total']);
        $lib = $this->clean($data['lib']);
        $com = $this->clean($data['com']);
        $lab1 = $this->clean($data['lab1']);
        $lab2 = $this->clean($data['lab2']);
        $lab3 = $this->clean($data['lab3']);
        $sch_id = $this->clean($data['sch_id']);
        $ath = $this->clean($data['ath']);
        $adm = $this->clean($data['adm']);
        $dev = $this->clean($data['dev']);
        $guid = $this->clean($data['guid']);
        $hand = $this->clean($data['hand']);
        $entr = $this->clean($data['entr']);
        $reg_fe = $this->clean($data['reg_fe']);
        $med_den = $this->clean($data['med_den']);
        $cul = $this->clean($data['cul']);
        $t_misfe = $this->clean($data['t_misfe']);
        $g_tot = $this->clean($data['g_tot']);
        // $section = $this->clean($data['section']);
        $email = $this->clean($data['email']);
        $gender = $this->clean($data['gender']);
        $filename = $this->clean($data['image']);
		$enroll_status = "SHIFTEE";
		
		$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, email,fname,mname,lname,gender,semester,academic,enroll_status)
		VALUES ('$application_no','$stu_id', '$stu_name', '$enroll_status', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename','$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
			$insert_result = mysqli_query($conn, $insert_query);
	
		if ($insert_result) {
	
			$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
			$fetch_new_enroll = $get_new_enroll->fetch_assoc();
			$id = $fetch_new_enroll['id'];

			for($i = 0; $i < count($type_shiftee); $i++){
	
				$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_shiftee'][$i]."', '".$_POST['amount_shiftee'][$i]."')");
	
			}

			return json_encode(['status' => 1, 'enroll_id' => $id]);

		}
			
	}

	function save_irregular()
	{
		extract($_POST);
		$conn = $this->db;

		$enroll_id = $this->clean($_POST['id']);
		$year_level = $this->clean($_POST['year_level']);
		// $section = $this->clean($_POST['section']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic_unit = $this->clean($_POST['academic_unit']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$type_irregular =$_POST['type_irregular'];
		$amount_irregular =$_POST['amount_irregular'];

		$stu_id = $this->clean($_POST['stu_id']);
        $year_level = $this->clean($_POST['year_level']);
        // $section = $this->clean($_POST['section']);
        $semester = $this->clean($_POST['semester']);
        $academic = $this->clean($_POST['academic']);
        $stud_status = $this->clean($_POST['submit']);


		$get_enroll = $conn->query("SELECT * FROM enroll2024 WHERE stu_id = '$stu_id' ORDER BY id DESC");
        $data = $get_enroll->fetch_assoc();

        $get_academic = $conn->query("SELECT * FROM academic WHERE id = '$academic'");
        $res_academic = $get_academic->fetch_array();
        $curr = $this->clean($res_academic['year']);
        $semester = $this->clean($res_academic['semester']);

        $fname = $this->clean($data['fname']);
        $mname = $this->clean($data['mname']);
        $lname = $this->clean($data['lname']);
        $application_no = $this->clean($data['application_no']);
        $stu_name = $this->clean($data['stu_name']);
        $stu_id = $this->clean($data['stu_id']);
        $stu_sta = $this->clean($data['stu_sta']);
        $course = $this->clean($data['course']);
        $majorOutput1 = $this->clean($data['major']);
        // $selectedSection1 = $this->clean($data['selectedSection1']);
        // $curr = $this->clean($data['curr']);
        $religiousOutput1 = $this->clean($data['reli']);
        $con_no = $this->clean($data['con_no']);
        $home_ad = $this->clean($data['home_ad']);
        $civil = $this->clean($data['civil']);
        $d_birth = $this->clean($data['d_birth']);
        $p_birth = $this->clean($data['p_birth']);
        $ele = $this->clean($data['ele']);
        $ele_year = $this->clean($data['ele_year']);
        $high = $this->clean($data['high']);
        $high_year = $this->clean($data['high_year']);
        $last_sc = $this->clean($data['last_sc']);
        $last_year = $this->clean($data['last_year']);
        $tot_units = $this->clean($data['tot_units']);
        $un_enrol = $this->clean($data['un_enrol']);
        $rate_per = $this->clean($data['rate_per']);
        $total = $this->clean($data['total']);
        $lib = $this->clean($data['lib']);
        $com = $this->clean($data['com']);
        $lab1 = $this->clean($data['lab1']);
        $lab2 = $this->clean($data['lab2']);
        $lab3 = $this->clean($data['lab3']);
        $sch_id = $this->clean($data['sch_id']);
        $ath = $this->clean($data['ath']);
        $adm = $this->clean($data['adm']);
        $dev = $this->clean($data['dev']);
        $guid = $this->clean($data['guid']);
        $hand = $this->clean($data['hand']);
        $entr = $this->clean($data['entr']);
        $reg_fe = $this->clean($data['reg_fe']);
        $med_den = $this->clean($data['med_den']);
        $cul = $this->clean($data['cul']);
        $t_misfe = $this->clean($data['t_misfe']);
        $g_tot = $this->clean($data['g_tot']);
        // $section = $this->clean($data['section']);
        $email = $this->clean($data['email']);
        $gender = $this->clean($data['gender']);
        $filename = $this->clean($data['image']);
		$enroll_status = "IRREGULAR";
		
		$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, email,fname,mname,lname,gender,semester,academic,enroll_status)
		VALUES ('$application_no','$stu_id', '$stu_name', '$enroll_status', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
			$insert_result = mysqli_query($conn, $insert_query);
	
		if ($insert_result) {
	
			$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
			$fetch_new_enroll = $get_new_enroll->fetch_assoc();
			$id = $fetch_new_enroll['id'];

			for($i = 0; $i < count($type_irregular); $i++){
	
				$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_irregular'][$i]."', '".$_POST['amount_irregular'][$i]."')");
	
			}

			return json_encode(['status' => 1, 'enroll_id' => $id]);

		}
	}

	function save_regular()
	{
		extract($_POST);
		$conn = $this->db;

		$enroll_id = $this->clean($_POST['id']);
		$year_level = $this->clean($_POST['year_level']);
		// $section = $this->clean($_POST['section']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic_unit = $this->clean($_POST['academic_unit']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$type_regular =$_POST['type_regular'];
		$amount_regular =$_POST['amount_regular'];

		$stu_id = $this->clean($_POST['stu_id']);
        $year_level = $this->clean($_POST['year_level']);
        // $section = $this->clean($_POST['section']);
        $semester = $this->clean($_POST['semester']);
        $academic = $this->clean($_POST['academic']);
        $stud_status = $this->clean($_POST['submit']);


		$get_enroll = $conn->query("SELECT * FROM enroll2024 WHERE stu_id = '$stu_id' ORDER BY id DESC");
        $data = $get_enroll->fetch_assoc();

        $get_academic = $conn->query("SELECT * FROM academic WHERE id = '$academic'");
        $res_academic = $get_academic->fetch_array();
        $curr = $this->clean($res_academic['year']);
        $semester = $this->clean($res_academic['semester']);

        $fname = $this->clean($data['fname']);
        $mname = $this->clean($data['mname']);
        $lname = $this->clean($data['lname']);
        $application_no = $this->clean($data['application_no']);
        $stu_name = $this->clean($data['stu_name']);
        $stu_id = $this->clean($data['stu_id']);
        $stu_sta = $this->clean($data['stu_sta']);
        $course = $this->clean($data['course']);
        $majorOutput1 = $this->clean($data['major']);
        // $selectedSection1 = $this->clean($data['selectedSection1']);
        // $curr = $this->clean($data['curr']);
        $religiousOutput1 = $this->clean($data['reli']);
        $con_no = $this->clean($data['con_no']);
        $home_ad = $this->clean($data['home_ad']);
        $civil = $this->clean($data['civil']);
        $d_birth = $this->clean($data['d_birth']);
        $p_birth = $this->clean($data['p_birth']);
        $ele = $this->clean($data['ele']);
        $ele_year = $this->clean($data['ele_year']);
        $high = $this->clean($data['high']);
        $high_year = $this->clean($data['high_year']);
        $last_sc = $this->clean($data['last_sc']);
        $last_year = $this->clean($data['last_year']);
        $tot_units = $this->clean($data['tot_units']);
        $un_enrol = $this->clean($data['un_enrol']);
        $rate_per = $this->clean($data['rate_per']);
        $total = $this->clean($data['total']);
        $lib = $this->clean($data['lib']);
        $com = $this->clean($data['com']);
        $lab1 = $this->clean($data['lab1']);
        $lab2 = $this->clean($data['lab2']);
        $lab3 = $this->clean($data['lab3']);
        $sch_id = $this->clean($data['sch_id']);
        $ath = $this->clean($data['ath']);
        $adm = $this->clean($data['adm']);
        $dev = $this->clean($data['dev']);
        $guid = $this->clean($data['guid']);
        $hand = $this->clean($data['hand']);
        $entr = $this->clean($data['entr']);
        $reg_fe = $this->clean($data['reg_fe']);
        $med_den = $this->clean($data['med_den']);
        $cul = $this->clean($data['cul']);
        $t_misfe = $this->clean($data['t_misfe']);
        $g_tot = $this->clean($data['g_tot']);
        // $section = $this->clean($data['section']);
        $email = $this->clean($data['email']);
        $gender = $this->clean($data['gender']);
        $filename = $this->clean($data['image']);
		$enroll_status = "REGULAR";
		
		$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, email,fname,mname,lname,gender,semester,academic,enroll_status)
		VALUES ('$application_no','$stu_id', '$stu_name', '$enroll_status', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
			$insert_result = mysqli_query($conn, $insert_query);
	
		if ($insert_result) {
	
			$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
			$fetch_new_enroll = $get_new_enroll->fetch_assoc();
			$id = $fetch_new_enroll['id'];

			for($i = 0; $i < count($type_regular); $i++){
	
				$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_regular'][$i]."', '".$_POST['amount_regular'][$i]."')");
	
			}

			
			return json_encode(['status' => 1, 'enroll_id' => $id]);

		}
	}

	function update_section()
	{
		try {
			if (!isset($_GET['section']) || !isset($_GET['application_no'])) {
				die("Required parameters are missing.");
			}
	
			$section = htmlspecialchars(trim($_GET['section']));
			$id = intval($_GET['application_no']);
	
			if (empty($section) || $id <= 0) {
				die("Invalid input data.");
			}

			$stmt = $this->db->prepare("UPDATE enroll2024 SET section = :section WHERE id = :id");
			$stmt->bindParam(':section', $section, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	
			if ($stmt->execute()) {
				return 1;
			} else {
				return 0;
			}
		} catch (PDOException $e) {
			return 0;
		}
	}

	function update_image()
	{
		extract($_POST);
		$filename = $_FILES['fileInput']['name'];
        $tmp_name = $_FILES['fileInput']['tmp_name'];
        $folder = "./upload/" . $filename;
		$image = $_GET['image'];
		$id = $_GET['application_no'];

		try {
			$stmt = $this->db->prepare("UPDATE enroll2024 SET image = :image WHERE id = :id");
			$stmt->bindParam(':image', $image, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
	
			if ($stmt->rowCount() > 0) {
				return 1; // Success
			} else {
				return 0;
			}
		} catch (PDOException $e) {
			return 0;
		}
	}
	
}
