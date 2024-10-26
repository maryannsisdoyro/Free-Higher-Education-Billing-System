<?php
ob_start();
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '';  // Sanitize the action parameter
include 'admin_class.php';
$crud = new Action();

// Check if the action is valid
if (method_exists($crud, $action)) {
    switch ($action) {
        case 'login':
            $login = $crud->login();
            if ($login) {
                echo $login;
            } else {
                echo 'Login failed.';
            }
            break;
        
        case 'login2':
            $login = $crud->login2();
            if ($login) {
                echo $login;
            } else {
                echo 'Login2 failed.';
            }
            break;
        
        case 'logout':
            include 'backup.php';
            $logout = $crud->logout();
            if ($logout) {
                echo $logout;
            } else {
                echo 'Logout failed.';
            }
            break;

        case 'logout2':
            $logout = $crud->logout2();
            if ($logout) {
                echo $logout;
            } else {
                echo 'Logout2 failed.';
            }
            break;

        case 'save_user':
            $save = $crud->save_user();
            if ($save) {
                echo $save;
            } else {
                echo 'Saving user failed.';
            }
            break;

        case 'delete_user':
            $delete = $crud->delete_user();
            if ($delete) {
                echo $delete;
            } else {
                echo 'Deleting user failed.';
            }
            break;

        // Add similar cases for the remaining actions
        case 'signup':
        case 'update_account':
        case 'save_settings':
        case 'save_course':
        case 'delete_course':
        case 'save_student':
        case 'delete_student':
        case 'save_fees':
        case 'delete_fees':
        case 'save_payment':
        case 'delete_payment':
        case 'forgotPassword':
        case 'resetPassword':
        case 'import_csv_enrollment':
            $response = $crud->$action();  // Dynamically call the method
            if ($response) {
                echo $response;
            } else {
                echo ucfirst($action) . ' failed.';
            }
            break;

        default:
            echo 'Unknown action.';
            break;
    }
} else {
    echo 'Invalid action or method not found.';
}

ob_end_flush();
?>
