<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn= new mysqli('127.0.0.1','u510162695_fhebilling','1Fhebilling','u510162695_fhebilling')or die("Could not connect to mysql".mysqli_error($con));
// $conn= new mysqli('localhost','root','','fhe_billing')or die("Could not connect to mysql".mysqli_error($con));

// - docker test - $conn= new mysqli('mysql','testuser','testpassword','testdb')or die("Could not connect to mysql".mysqli_error($con));