<?php

session_start();
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "./phpmailer/src/Exception.php";
require "./phpmailer/src/PHPMailer.php";
require "./phpmailer/src/SMTP.php";
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM complainants where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		// if($type == 1)
		$chk = $this->db->query("Select * from users where username = '$username'")->num_rows;
		// if($chk > 0){
		// 	return 2;
		// 	exit;
		// }
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			if ($chk > 0) {
				$id = $_SESSION['login_id'];
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
			}
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", address = '$address' ";
		$data .= ", contact = '$contact' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * from complainants where email ='$email' ".(!empty($id) ? " and id != '$id' " : ''))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		if(empty($id))
			$save = $this->db->query("INSERT INTO complainants set $data");
		else
			$save = $this->db->query("UPDATE complainants set $data where id=$id ");
		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
				$qry = $this->db->query("SELECT * FROM complainants where id = $id ");
				if($qry->num_rows > 0){
					foreach ($qry->fetch_array() as $key => $value) {
						if($key != 'password' && !is_numeric($key))
							$_SESSION['login_'.$key] = $value;
					}
						return 1;
				}else{
					return 3;
				}
		}
	}
	function update_account(){
		
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		// $chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		// if($chk > 0){
		// 	return 2;
		// 	exit;
		// }
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
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

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['system'][$key] = $value;
		}

			return 1;
				}
	}
	function save_course(){
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


		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','fid','type','amount')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM courses where course ='$course' and level ='$level' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO courses set course = '$new_course', department='$key', level = '$level',
			laboratory = $laboratory,
			computer = $computer,
			academic = $academic,
			academic_nstp = $academic_nstp,
			total_amount = $total_amount");
			if($save){
				$id = $this->db->insert_id;
				foreach($fid as $k =>$v){
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					$save2[] = $this->db->query("INSERT INTO fees set $data");
				}
				if(isset($save2))
						return 1;
			}
		}else{
			$save = $this->db->query("UPDATE courses set course='$new_course', department='$key', level = '$level',
			laboratory = $laboratory,
			computer = $computer,
			academic = $academic,
			academic_nstp = $academic_nstp,
			total_amount = $total_amount where id = $id");
			if($save){

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

				if(isset($save2))
						return 1;
				
			}
		}

	}
	function delete_course(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM courses where id = ".$id);
		$delete2 = $this->db->query("DELETE FROM fees where course_id = ".$id);
		if($delete && $delete2){
			return 1;
		}
	}
	function save_student(){
		extract($_POST);
		$fullname = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'];
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM student where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			
			$save = $this->db->query("INSERT INTO student set $data , name = '$fullname'");
		}else{
			$save = $this->db->query("UPDATE student set $data , name = '$fullname' where id = $id");
		}
		if($save)
			return 1;
	}
	function delete_student(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM student where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_fees(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'total_fee'){
					$v = str_replace(',', '', $v);
				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM student_ef_list where ef_no ='$ef_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO student_ef_list set $data");
		}else{
			$save = $this->db->query("UPDATE student_ef_list set $data where id = $id");
		}
		if($save)
			return 1;
	}
	function delete_fees(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM student_ef_list where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'amount'){
					$v = str_replace(',', '', $v);
				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO payments set $data");
			if($save)
				$id= $this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE payments set $data where id = $id");
		}
		if($save)
			return json_encode(array('ef_id'=>$ef_id, 'pid'=>$id,'status'=>1));
	}
	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payments where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function forgotPassword(){
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
		}else{
			return 2;
		}

	}

	function resetPassword(){
		extract($_POST);
		$verification = $_POST['verification'];
		$new = $_POST['new'];
		$confirm = $_POST['confirm'];

		if ($new !== $confirm) {
			return 2;
		}else{
			$check = $this->db->query("SELECT * FROM users WHERE verification = '$verification'");
			if ($check->num_rows > 0) {
				$hashed = md5($new);

				$update = $this->db->query("UPDATE users SET password = '$hashed' WHERE verification = '$verification'");

				if ($update) {
					return 1;
				}

			}else{
				return 3;
			}
		}

	}

	
}
