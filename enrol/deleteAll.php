<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
<script src="sweetalerts/sweetalert2@11.js"></script>
<?php

include 'db.php';
date_default_timezone_set('Asia/Manila'); // change according timezone

$stmt = $conn->query("UPDATE enroll2024 SET delete_status = 2");
if ($stmt) {
    echo '<script>
    window.onload = function() {
        Swal.fire({
            title: "Success!",
            text: "Record removed successfully !!",
            icon: "success"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../index.php?page=college-application";
            }
        });
    };
  </script>';
}