<?php
session_start();
include('db.php'); // Assuming config.php contains database connection settings
// Redirect to login page if user is not logged in
if (empty($_SESSION['alogin'])) {
    // header('location:index.php');
    // exit(); // Stop further execution
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form data into session variables
    $_SESSION['from'] = $_POST['startpoint'];
    $_SESSION['to'] = $_POST['endpoint'];
    $_SESSION['receiptrange'] = $_POST['receiptrange'];
}

// Fetch and sanitize GET parameter
$application_no=intval($_GET['application_no']);
$query=mysqli_query($conn, "select * from enroll2024 where application_no='$application_no'");
$row = mysqli_fetch_assoc($query);
$numb=mysqli_num_rows($query); 
// Check if record exists
if ($row) {
    // Retrieve data from the fetched row
                       $application_no  = $row["application_no"];
                       $last_name  = $row["lname"];
                       $first_name  = $row["fname"];
                       $middle_name  = $row["mname"];
                       $home_address  = $row["home_ad"];
                       $present_address  = $row["home_ad"];
                       $contact  = $row["con_no"];
                       $sex  = $row["gender"];
                       // $date_of_birth  = $row["date_of_birth"];
                       $date_of_birth = date('F j, Y', strtotime($row['d_birth']));
                       $email  = $row["email"];
                       $place_of_birth  = $row["p_birth"];
                       $civil_status  = $row["civil"];
                       $elementary  = $row["ele"];
                       $elementary_year_graduated  = $row["ele_year"];
                       $high_school  = $row["high"];
                       $high_school_year_graduated  = $row["high_year"];
                       $shs  = $row["last_sc"];
                       $shs_year_graduated  = $row["last_year"];
                      
                       $complete_name  = $row["stu_name"];
                       $date_signed  = $row["date_signed"];
                       $course_to_be_enrolled  = $row["course"];
   
}


?>
<style>

      img {
    vertical-align: middle;
    }

    /* Container for main content and small box */
    .container {
        position: relative; /* Make the container a positioning context */
    }

    /* Define styles for the main content */
    .main-content {
        width: calc(100% - 340px); /* Adjust width as needed */
        float: left; /* Keep the main content on the left */
    }

    /* Define styles for the small box on the right side */
   

    .small-box {
    position: absolute;
     right: calc(100% - 800px); /* Adjust the left position */
    width: 30%;
    border: 1px solid #000;
    height: 30px;
    margin-top: 0px;
    padding: 0px;
    background-color: #ccc; /* Grey background color */
    display: flex; /* or use display: grid; */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
}

.centered-content {
    text-align: center; /* Center text within the box */
    width: 100%; /* Ensure content takes full width */
}
    .small-box2 {
        position: absolute; /* Position the small box absolutely */
        right: calc(100% - 400px); /* Adjust the left position */
        width: 30%; /* Adjust width as needed */
        border: 0px solid #000;
        height: 65px; /* Adjust height as needed */
        margin-top: 1px; /* Adjust margin as needed */
        padding: 5px; /* Adjust padding as needed */
    }
    .college-application2 {
    display: flex; /* or display: grid; */
    align-items: center; /* for vertical alignment */
   }

   .college-application2 h4 {
    margin-left: 180px; /* Adjust as needed for spacing */
   
   }

   .college-application2 .small-box {
    padding: 0;
   }
     .small-box2 {
        position: absolute; /* Position the small box absolutely */
        right: calc(100% - 400px); /* Adjust the left position */
        width: 30%; /* Adjust width as needed */
        border: 0px solid #000;
        height: 65px; /* Adjust height as needed */
        margin-top: 1px; /* Adjust margin as needed */
        padding: 5px; /* Adjust padding as needed */
    }
     .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
        }
     .highlight {
     	background-color: #d3d3d3;


      }

</style>
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .college-application {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }
        .header, .section-title {
            text-align: center;
            margin: 20px 0;
        }
        .header img {
            height: 100px;
        }
        .form-section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .note {
            margin-top: 20px;
            font-style: italic;
        }
        @media print {
            body {
                margin: 0;
            }
            .college-application {
                border: none;
                padding: 0;
            }
        }
    </style>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $last_name; ?>,<?php echo $first_name; ?>,<?php echo $middle_name; ?>,<?php echo $course_to_be_enrolled; ?></title> 
		 <center>
            <img src="logo2.png" alt="MCC Logo" style="height: 200px;">
          </center>
	</head>

	<body>

    <div class="college-application2">
       <h4 style="font-size: 20px;"><strong>COLLEGE APPLICATION FORM</strong></h4>
       <div class="small-box">
    <div class="centered-content">
        <p>Application No.: <b>APN24-<?php echo $application_no; ?></b></p>
    </div>
   </div>
    </div>

 <div class="college-application">
        
        <div class="form-section">
           
            <table>
            <tr class="section-title" style="text-align: center;">
             <th colspan="6"><center>I. PERSONAL RECORD</center></th>
            </tr>
                 <tr>
                    <th colspan="1"><center><?php echo $last_name; ?></center></th>
                    <th colspan="3"><center><?php echo $first_name; ?></center></th>
                    <th colspan="2"><center><?php echo $middle_name; ?></center></th>
                </tr>
                <tr>
                    <td colspan="1" class="highlight"><center>Last Name</center></td>
                    <td colspan="3"><center>First Name</center></td>
                    <td colspan="2"><center>Middle Name</center></td>
                </tr>
            <tr>
                <th><center>Home Address</center></th>
                <td colspan="3"><center><?php echo $home_address; ?></center></td>
                <th><center>Contact Number</center></th>
                <td><center><?php echo $contact; ?></center></td>
            </tr>
            <tr>
                <th><center>Present Address</center></th>
                <td colspan="3"><center><?php echo $present_address; ?></center></td>
                 <th><center>Sex</center></th>
                <td><center>Female</center></td>
                
            </tr>
            <tr>
                <th><center>Date of Birth (mm/dd/year)</center></th>
                <td><center><?php echo $date_of_birth; ?></center></td>
                <th><center>Email</center></th>
                <td colspan="3"><center><?php echo $email; ?></center></td>
            </tr>
            <tr>
                <th><center>Place of Birth</center></th>
                <td colspan="3"><center><?php echo $place_of_birth; ?></center></td>
                <th><center>Civil Status</center></th>
                <td><center><?php echo $civil_status; ?></center></td>
            </tr>
            <tr class="section-title">
                <th colspan="6"><center>II. EDUCATIONAL BACKGROUND</center></th>
            </tr>
           
            <tr>
                <th><center>Elementary<br>(School Gruated)</center></th>
                <td colspan="3"><center><?php echo $elementary; ?></center></td>
                <td><center>Year Graduated</center></td>
                <td><center><?php echo $elementary_year_graduated; ?></center></td>
            </tr>
            <tr>
                <th><center>Junior High School<br>(School Gruated)</center></th>
                <td colspan="3"><center><?php echo $high_school; ?></center></td>
                 <td><center>Year Graduated</center></td>
                <td><center><?php echo $high_school_year_graduated; ?></center></td>
            </tr>
            <tr>
                <th><center>Senior High School<br>(School Gruated)</center></th>
                <td colspan="3"><center><?php echo $shs; ?></center></td>
                 <td><center>Year Graduated</center></td>
                <td><center><?php echo $shs_year_graduated; ?></center></td>
            </tr>
          
        </table>
        <p style="margin-top: 20px;">I hereby certify that all the above information are complete and accurate.</p>
        <br>
        <p style="margin-left: 120px; margin-top: 10px;"><br>
            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $complete_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d', strtotime($date_signed)); ?></strong><br>
            ________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_____________________<br>
            Student's Signature Above Printed Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Signed<br>

           
        </p>
        
        <div style="margin-top: 40px;">
            <table>
            	 <tr class="section-title">
                    <th colspan="2"><center>III. PROGRAM APPLICATION DETAILS</center></th>
                </tr>
                <tr>
                    <td>I would like to enroll in </td>
                    <td><?php echo $course_to_be_enrolled; ?></td>
                </tr>
                <tr class="section-title">
                    <th colspan="2"><center>IV. INTERVIEW AND ASSESSMENT RESULT</center></th>
                </tr>
                <tr>
                     <th colspan="2">1.__________________________________________________________________</th>
                    
                </tr>
                  <tr>
                    
                     <th colspan="2">2.__________________________________________________________________</th>
                </tr>
            </table>
        </div>

        <br>
        <p style="margin-left: 120px; margin-top: 10px;">
        	 <img src="signature.PNG" alt="MCC Logo" style="height: 70px;">
           <b>Date Signed: <?php echo $date_signed; ?></b>
           
        </p>
    </div>

       
	</body>
</html>
<script type="text/javascript"> 
    
  window.print();
  setTimeout(function(){
    window.close()
  },750)
 </script>