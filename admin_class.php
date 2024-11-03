<?php

session_start();
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
		// extract($_POST);
		$username = htmlspecialchars(stripslashes(trim($_POST['username'])));
		$password = htmlspecialchars(stripslashes(trim($_POST['password'])));

		$stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
		// $qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$qry = $stmt->get_result();
		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			// foreach ($qry->fetch_array() as $key => $value) {
			// 	if ($key != 'passwors' && !is_numeric($key))
			// 	$_SESSION['login_' . $key] = $value;
			// }
			if (password_verify($password, $row['password'])) {
				$_SESSION['login_id'] = $row['id'];
				$_SESSION['login_name'] = $row['name'];
				$_SESSION['login_username'] = $row['username'];
				#$_SESSION['login_password'] = $row['password'];
				$_SESSION['login_type'] = $row['type'];
				$_SESSION['login_verification'] = $row['verification'];
			}else{  return 3; }
			return 1;
		} else {
			return 3;
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
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if (!empty($password))
			$data .= ", password = '" . md5($password) . "' ";
		$data .= ", type = '$type' ";
		// if($type == 1)
		$chk = $this->db->query("Select * from users where username = '$username'")->num_rows;
		// if($chk > 0){
		// 	return 2;
		// 	exit;
		// }
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users set " . $data);
		} else {
			if ($chk > 0) {
				$id = $_SESSION['login_id'];
				$save = $this->db->query("UPDATE users set " . $data . " where id = " . $id);
			}
		}
		if ($save) {
			return 1;
		}
	}
	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = " . $id);
		if ($delete)
			return 1;
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

		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if (!empty($password))
			$data .= ", password = '" . md5($password) . "' ";
		// $chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		// if($chk > 0){
		// 	return 2;
		// 	exit;
		// }
		$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if ($save) {
			$data = '';
			return 1;
			// foreach($_POST as $k => $v){
			// 	if($k =='password')
			// 		continue;
			// 	if(empty($data) && !is_numeric($k) )
			// 		$data = " $k = '$v' ";
			// 	else
			// 		$data .= ", $k = '$v' ";
			// }
			// if($_FILES['img']['tmp_name'] != ''){
			// 				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			// 				$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			// 				$data .= ", avatar = '$fname' ";

			// }
			// $save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			// if($data){
			// 	foreach ($_SESSION as $key => $value) {
			// 		unset($_SESSION[$key]);
			// 	}
			// 	$login = $this->login2();
			// 	if($login)
			// 	return 1;
			// }
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

		$new_course = $courses[$_POST['course']];
		$key = $_POST['course'];
		$level = $_POST['level'];
		$laboratory = $_POST['laboratory'];
		$computer = $_POST['computer'];
		$academic = $_POST['academic'];
		$academic_nstp = $_POST['academic_nstp'];
		$total_amount = $_POST['total_amount'];
		$semester = $_POST['semester'];


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
		extract($_POST);
		$delete = $this->db->query("DELETE FROM student where id = " . $id);
		if ($delete) {
			return 1;
		}
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
		extract($_POST);
		$delete = $this->db->query("DELETE FROM student_ef_list where id = " . $id);
		if ($delete) {
			return 1;
		}
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
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payments where id = " . $id);
		if ($delete) {
			return 1;
		}
	}

	function forgotPassword()
	{
		extract($_POST);
		$email = $_POST['email'];
		$check = $this->db->query("SELECT * FROM users WHERE email = '$email'");
		if ($check->num_rows > 0) {
			$verification = uniqid();

			$update = $this->db->query("UPDATE users SET verification = '$verification'");
			if ($update) {
				$mail = new PHPMailer(true);
				$mail->SMTPDebug = 0;
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'sisdoyromaryannlawan20@gmail.com';
				$mail->Password = 'ggeurvotkedugblo';
				$mail->Port = 587;

				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);

				$mail->setFrom('mccfhebilling@gmail.com', 'MCC Free Higher Education');

				$mail->addAddress($email);
				$mail->Subject = "Reset Password Verification Code";
				$mail->Body = "This is your verification code: " . $verification;

				$mail->send();
			}

			return 1;
		} else {
			return 2;
		}
	}

	function resetPassword()
	{
		extract($_POST);
		$verification = $_POST['verification'];
		$new = $_POST['new'];
		$confirm = $_POST['confirm'];

		if ($new !== $confirm) {
			return 2;
		} else {
			$check = $this->db->query("SELECT * FROM users WHERE verification = '$verification'");
			if ($check->num_rows > 0) {
				$hashed = md5($new);

				$update = $this->db->query("UPDATE users SET password = '$hashed' WHERE verification = '$verification'");

				if ($update) {
					return 1;
				}
			} else {
				return 3;
			}
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
		$section = $this->clean($_POST['section']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic_unit = $this->clean($_POST['academic_unit']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$type_shiftee =$_POST['type_shiftee'];
		$amount_shiftee =$_POST['amount_shiftee'];

		$stu_id = $this->clean($_POST['stu_id']);
        $year_level = $this->clean($_POST['year_level']);
        $section = $this->clean($_POST['section']);
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
		$enroll_status = "shiftee";
		
		$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, section, email,fname,mname,lname,gender,semester,academic,enroll_status)
		VALUES ('$application_no','$stu_id', '$stu_name', '$stu_sta', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$section', '$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
			$insert_result = mysqli_query($conn, $insert_query);
	
		if ($insert_result) {
	
			$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
			$fetch_new_enroll = $get_new_enroll->fetch_assoc();
			$id = $fetch_new_enroll['id'];

			for($i = 0; $i < count($type_shiftee); $i++){
	
				$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_shiftee'][$i]."', '".$_POST['amount_shiftee'][$i]."')");
	
			}

			return 1;

		}
		
	}

	function save_irregular()
	{
		extract($_POST);
		$conn = $this->db;

		$enroll_id = $this->clean($_POST['id']);
		$course = $this->clean($_POST['course']);
		$year_level = $this->clean($_POST['year_level']);
		$section = $this->clean($_POST['section']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic_unit = $this->clean($_POST['academic_unit']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$type_shiftee =$_POST['type_irregular'];
		$amount_shiftee =$_POST['amount_irregular'];

		$stu_id = $this->clean($_POST['stu_id']);
        $year_level = $this->clean($_POST['year_level']);
        $section = $this->clean($_POST['section']);
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
		$enroll_status = "irregular";
		
		$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, section, email,fname,mname,lname,gender,semester,academic,enroll_status)
		VALUES ('$application_no','$stu_id', '$stu_name', '$stu_sta', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$section', '$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
			$insert_result = mysqli_query($conn, $insert_query);
	
		if ($insert_result) {
	
			$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
			$fetch_new_enroll = $get_new_enroll->fetch_assoc();
			$id = $fetch_new_enroll['id'];

			for($i = 0; $i < count($type_shiftee); $i++){
	
				$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_irregular'][$i]."', '".$_POST['amount_irregular'][$i]."')");
	
			}

			return 1;

		}
			

		

		

		

		// $verification = $_POST['verification'];
		// $new = $_POST['new'];
		// $confirm = $_POST['confirm'];

		// if ($new !== $confirm) {
		// 	return 2;
		// } else {
		// 	$check = $this->db->query("SELECT * FROM users WHERE verification = '$verification'");
		// 	if ($check->num_rows > 0) {
		// 		$hashed = md5($new);

		// 		$update = $this->db->query("UPDATE users SET password = '$hashed' WHERE verification = '$verification'");

		// 		if ($update) {
		// 			return 1;
		// 		}
		// 	} else {
		// 		return 3;
		// 	}
		// }
	}

	// function save_regular()
	// {
	// 	extract($_POST);
	// 	$conn = $this->db;

	// 	$enroll_id = $this->clean($_POST['id']);
	// 	$course = $this->clean($_POST['course']);
	// 	$year_level = $this->clean($_POST['year_level']);
	// 	$section = $this->clean($_POST['section']);
	// 	$laboratory = $this->clean($_POST['laboratory']);
	// 	$computer = $this->clean($_POST['computer']);
	// 	$academic_unit = $this->clean($_POST['academic_unit']);
	// 	$academic_nstp = $this->clean($_POST['academic_nstp']);
	// 	$type_shiftee =$_POST['type_shiftee'];
	// 	$amount_shiftee =$_POST['amount_regular'];

	// 	$stu_id = $this->clean($_POST['stu_id']);
    //     $year_level = $this->clean($_POST['year_level']);
    //     $section = $this->clean($_POST['section']);
    //     $semester = $this->clean($_POST['semester']);
    //     $academic = $this->clean($_POST['academic']);
    //     $stud_status = $this->clean($_POST['submit']);


	// 	$get_enroll = $conn->query("SELECT * FROM enroll2024 WHERE stu_id = '$stu_id' ORDER BY id DESC");
    //     $data = $get_enroll->fetch_assoc();

    //     $get_academic = $conn->query("SELECT * FROM academic WHERE id = '$academic'");
    //     $res_academic = $get_academic->fetch_array();
    //     $curr = $this->clean($res_academic['year']);
    //     $semester = $this->clean($res_academic['semester']);

    //     $fname = $this->clean($data['fname']);
    //     $mname = $this->clean($data['mname']);
    //     $lname = $this->clean($data['lname']);
    //     $application_no = $this->clean($data['application_no']);
    //     $stu_name = $this->clean($data['stu_name']);
    //     $stu_id = $this->clean($data['stu_id']);
    //     $stu_sta = $this->clean($data['stu_sta']);
    //     // $course = $this->clean($data['course']);
    //     $majorOutput1 = $this->clean($data['major']);
    //     // $selectedSection1 = $this->clean($data['selectedSection1']);
    //     // $curr = $this->clean($data['curr']);
    //     $religiousOutput1 = $this->clean($data['reli']);
    //     $con_no = $this->clean($data['con_no']);
    //     $home_ad = $this->clean($data['home_ad']);
    //     $civil = $this->clean($data['civil']);
    //     $d_birth = $this->clean($data['d_birth']);
    //     $p_birth = $this->clean($data['p_birth']);
    //     $ele = $this->clean($data['ele']);
    //     $ele_year = $this->clean($data['ele_year']);
    //     $high = $this->clean($data['high']);
    //     $high_year = $this->clean($data['high_year']);
    //     $last_sc = $this->clean($data['last_sc']);
    //     $last_year = $this->clean($data['last_year']);
    //     $tot_units = $this->clean($data['tot_units']);
    //     $un_enrol = $this->clean($data['un_enrol']);
    //     $rate_per = $this->clean($data['rate_per']);
    //     $total = $this->clean($data['total']);
    //     $lib = $this->clean($data['lib']);
    //     $com = $this->clean($data['com']);
    //     $lab1 = $this->clean($data['lab1']);
    //     $lab2 = $this->clean($data['lab2']);
    //     $lab3 = $this->clean($data['lab3']);
    //     $sch_id = $this->clean($data['sch_id']);
    //     $ath = $this->clean($data['ath']);
    //     $adm = $this->clean($data['adm']);
    //     $dev = $this->clean($data['dev']);
    //     $guid = $this->clean($data['guid']);
    //     $hand = $this->clean($data['hand']);
    //     $entr = $this->clean($data['entr']);
    //     $reg_fe = $this->clean($data['reg_fe']);
    //     $med_den = $this->clean($data['med_den']);
    //     $cul = $this->clean($data['cul']);
    //     $t_misfe = $this->clean($data['t_misfe']);
    //     $g_tot = $this->clean($data['g_tot']);
    //     // $section = $this->clean($data['section']);
    //     $email = $this->clean($data['email']);
    //     $gender = $this->clean($data['gender']);
    //     $filename = $this->clean($data['image']);
	// 	$enroll_status = "regular";
		
	// 	$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, section, email,fname,mname,lname,gender,semester,academic,enroll_status)
	// 	VALUES ('$application_no','$stu_id', '$stu_name', '$stu_sta', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$section', '$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
	// 		$insert_result = mysqli_query($conn, $insert_query);
	
	// 	if ($insert_result) {
	
	// 		$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
	// 		$fetch_new_enroll = $get_new_enroll->fetch_assoc();
	// 		$id = $fetch_new_enroll['id'];

	// 		for($i = 0; $i < count($type_shiftee); $i++){
	
	// 			$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_regular'][$i]."', '".$_POST['amount_regular'][$i]."')");
	
	// 		}

	// 		return 1;

	// 	}
			
	// }


	function save_regular()
	{
		extract($_POST);
		$conn = $this->db;

		$enroll_id = $this->clean($_POST['id']);
		$course = $this->clean($_POST['course']);
		$year_level = $this->clean($_POST['year_level']);
		$section = $this->clean($_POST['section']);
		$laboratory = $this->clean($_POST['laboratory']);
		$computer = $this->clean($_POST['computer']);
		$academic_unit = $this->clean($_POST['academic_unit']);
		$academic_nstp = $this->clean($_POST['academic_nstp']);
		$type_shiftee =$_POST['type_regular'];
		$amount_shiftee =$_POST['amount_regular'];

		$stu_id = $this->clean($_POST['stu_id']);
        $year_level = $this->clean($_POST['year_level']);
        $section = $this->clean($_POST['section']);
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
		$enroll_status = "regular";
		
		$insert_query = "INSERT INTO enroll2024 (application_no,stu_id, stu_name, stu_sta, course, major, year_level, stud_status,curr, reli, con_no, home_ad, civil, d_birth, p_birth, ele, ele_year, high, high_year, last_sc, last_year, tot_units, un_enrol, rate_per, total, lib, com, lab1, lab2, lab3, sch_id, ath, adm, dev, guid, hand, entr, reg_fe, med_den, cul, t_misfe, g_tot,image, section, email,fname,mname,lname,gender,semester,academic,enroll_status)
		VALUES ('$application_no','$stu_id', '$stu_name', '$stu_sta', '$course', '$majorOutput1', '$year_level', '$stud_status','$curr', '$religiousOutput1', '$con_no', '$home_ad', '$civil', '$d_birth', '$p_birth', '$ele', '$ele_year', '$high', '$high_year', '$last_sc', '$last_year', '$tot_units', '$un_enrol', '$rate_per', '$total', '$lib', '$com', '$lab1', '$lab2', '$lab3', '$sch_id', '$ath', '$adm', '$dev', '$guid', '$hand', '$entr', '$reg_fe', '$med_den', '$cul', '$t_misfe', '$g_tot', '$filename', '$section', '$email','$fname', '$mname', '$lname', '$gender', '$semester', '$academic', '$enroll_status')";
	
			$insert_result = mysqli_query($conn, $insert_query);
	
		if ($insert_result) {
	
			$get_new_enroll = $conn->query("SELECT * FROM enroll2024 ORDER BY id DESC");
			$fetch_new_enroll = $get_new_enroll->fetch_assoc();
			$id = $fetch_new_enroll['id'];

			for($i = 0; $i < count($type_shiftee); $i++){
	
				$insert_fees = $conn->query("INSERT INTO student_individual_fees(enroll_id, type, amount) VALUES($id, '".$_POST['type_regular'][$i]."', '".$_POST['amount_regular'][$i]."')");
	
			}

			return 1;

		}
		
	}
}
