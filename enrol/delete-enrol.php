<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet">
<script src="sweetalerts/sweetalert2@11.js"></script>
<?php

include 'db.php';
date_default_timezone_set('Asia/Manila'); // change according timezone

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->query("DELETE FROM enroll2024 WHERE id = '$id'");
    if ($stmt) {
        echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Success!",
                text: "Student removed successfully !!",
                icon: "success"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../index.php?page=college-application";
                }
            });
        };
      </script>';
    }

}

