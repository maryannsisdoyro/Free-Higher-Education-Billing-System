<?php 


if(session_status() != 2){
    session_start();
    }
    
    if(!isset($_SESSION['login_id'])){
        header("location: login.php");
        }
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page == 'students') {
        include 'students.php';
    }else if ($page == 'subject-add') {
        include 'addsub.php';
    }else if ($page == 'enrol') {
        include 'recordenroll.php';
    }else if ($page == 'subjects') {
        include 'subject.php';
    }else if ($page == 'edit-subject') {
        include 'edit-subject.php';
    }else if ($page == 'settings') {
        include 'settings.php';
    }else if ($page == 'add-new') {
        include 'index.php';
    }else if ($page == 'new-academic') {
        include 'add-new-academics.php';
    }

}