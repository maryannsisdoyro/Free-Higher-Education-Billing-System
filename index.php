<?php 
  // - add this line to the top of every page
  include('./common.php');
  include 'db_connect.php';

  if (isset($_SESSION['user_token'])) {
    // Prepare SQL query to fetch the user
		$stmt = $conn->prepare("SELECT id FROM user_sessions WHERE session_token = ? AND user_id = ?");
		$stmt->bind_param('ss', $_SESSION['user_token'], $_SESSION['login_id']);
		$stmt->execute();
		$qry = $stmt->get_result();

		// Check if user exists
		if (!($qry->num_rows > 0)) {
      // Redirect to login page
      header('location: ajax.php?action=logout');
    }
  }
  
     
  if (str_contains($_SERVER['REQUEST_URI'], "page=college-application")) {

    $sql = "SELECT `id`,`application_no`,`stu_id`, `year_level`, `stu_name`, `stu_sta`, `course`, `major`, `section`, `curr`, `reli`, `con_no`, `home_ad`, `civil`, `d_birth`, `p_birth`, `ele`, `ele_year`, `high`, `high_year`, `last_sc`, `last_year`, `tot_units`, `un_enrol`, `rate_per`, `total`, `lib`, `com`, `lab1`, `lab2`, `lab3`, `sch_id`, `ath`, `adm`, `dev`, `guid`, `hand`, `entr`, `reg_fe`, `med_den`, `cul`, `t_misfe`, `g_tot`, `image`, `semester`, curr FROM `enroll2024` WHERE delete_status = 1 ORDER BY course, lname ASC ";
    $result = $conn->query($sql);
    
    function array_to_csv_download($array, $filename = "export.csv", $delimiter = ",") {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    
        $f = fopen('php://output', 'w');
    
        fputcsv($f, array_keys($array[0]), $delimiter);
    
        
        foreach ($array as $row) {
            fputcsv($f, $row, $delimiter);
        }
        fclose($f);
        exit();
    }
    
    if (isset($_GET['export']) && $_GET['export'] == 'csv') {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        array_to_csv_download($data, 'student_list.csv');
    }
    
    $conn->close();
  }

  if (str_contains($_SERVER['REQUEST_URI'], "page=payments_report")) {
    function array_to_csv_download($array, $filename = "export.csv", $delimiter = ",") {
      header('Content-Type: application/csv');
      header('Content-Disposition: attachment; filename="' . $filename . '";');
  
      $f = fopen('php://output', 'w');
  
      fputcsv($f, array_keys($array[0]), $delimiter);
  
      
      foreach ($array as $row) {
          fputcsv($f, $row, $delimiter);
      }
      fclose($f);
      exit();
  }
  
  if (isset($_GET['export']) && $_GET['export'] == 'csv') {
      $data = [];
      while ($row = $result->fetch_assoc()) {
          $data[] = $row;
      }
      array_to_csv_download($data, 'student_list.csv');
  }
  
  $conn->close();
  }

 
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : '' ?></title>
 <link rel="icon" type="image/x-icon" href="assets/logo.png">	

<?php
 include('./header.php'); 
 // include('./auth.php'); 
 ?>

</head>
<style>
	body{
        background: #80808045;
  }
  .modal-dialog.large {
    width: 80% !important;
    max-width: unset;
  }
  .modal-dialog.mid-large {
    width: 50% !important;
    max-width: unset;
  }
  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    /*right: -4.5em;*/
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
}
#viewer_modal .modal-dialog {
        width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
}
  #viewer_modal .modal-content {
       background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #viewer_modal img,#viewer_modal video{
    max-height: calc(100%);
    max-width: calc(100%);
  }
</style>

<body>
	<?php include 'topbar.php' ?>
	<?php include 'navbar.php' ?>
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
  </div>
  
  <main id="view-panel" >
      <?php $page = isset($_GET['page']) ? $_GET['page'] :'home'; ?>
  	<?php include $page.'.php' ?>
  	

    <?php include 'footer.php' ?>
  </main>

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
</body>
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
</script>	
</html>
