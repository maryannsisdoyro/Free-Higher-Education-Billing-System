<?php
session_start();
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	include 'backup.php';
	$logout = $crud->logout();
	if($logout)
	
	echo $logout;
}
if($action == 'logout2'){

	$logout = $crud->logout2();
	if($logout)
		echo $logout;

}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_course"){
	$save = $crud->save_course();
	if($save)
		echo $save;
}
if($action == "delete_course"){
	$delete = $crud->delete_course();
	if($delete)
		echo $delete;
}
if($action == "save_student"){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == "delete_student"){
	$delete = $crud->delete_student();
	if($delete)
		echo $delete;
}
if($action == "save_fees"){
	$save = $crud->save_fees();
	if($save)
		echo $save;
}
if($action == "delete_fees"){
	$delete = $crud->delete_fees();
	if($delete)
		echo $delete;
}
if($action == "save_payment"){
	$save = $crud->save_payment();
	if($save)
		echo $save;
}
if($action == "delete_payment"){
	$delete = $crud->delete_payment();
	if($delete)
		echo $delete;
}
if($action == "forgotPassword"){
	$forgot = $crud->forgotPassword();
	if($forgot)
		echo $forgot;
}

if($action == "resetPassword"){
	$forgot = $crud->resetPassword();
	if($forgot)
		echo $forgot;
}

if($action == "import_csv_enrollment"){
	$import = $crud->importCsvEnrollment();
	if($import)
		echo $import;
}

if($action == 'save_shiftee'){
	$save_shiftee = $crud->save_shiftee();
	if($save_shiftee){
		echo $save_shiftee;
	}
}

if($action == 'save_irregular'){
	$save_irregular = $crud->save_irregular();
	if($save_irregular){
		echo $save_irregular;
	}
}

if($action == 'save_regular'){
	$save_regular = $crud->save_regular();
	if($save_regular){
		echo $save_regular;
	}
}

if($action == 'get_fees'){
	$get_fees = $crud->get_fees();
	if($get_fees){
		echo $get_fees;
	}
}

if($action == "update_section"){
	$update_section = $crud->update_section();
	if($update_section){
		echo $update_section;
	}
}

// if($action == "update_image"){
// 	$update_image = $crud->update_image();
// 	if($update_image){
// 		echo $update_image;
// 	}
// }


ob_end_flush();
?>
