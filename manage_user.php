<?php 
include('db_connect.php');
session_start();

if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $username = $_POST['username'];
    $name = $_POST['name'];
    $type = $_POST['type'];

    // Check if username already exists, excluding the current user (if editing)
    $query = "SELECT * FROM users WHERE username = ? AND id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $username, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        echo "<script>document.getElementById('msg').innerHTML = '<div class=\"alert alert-danger\">Username already exists</div>';</script>";
    } else {
        if(empty($_POST['password'])) {
            // Password not provided, keep the old password
            if(isset($id)) {
                $query = "UPDATE users SET name=?, username=?, type=? WHERE id=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssii", $name, $username, $type, $id);
            } else {
                echo "<script>document.getElementById('msg').innerHTML = '<div class=\"alert alert-danger\">Password is required for a new user</div>';</script>";
                exit;
            }
        } else {
            // Password provided, hash it before saving
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if(isset($id)) {
                $query = "UPDATE users SET name=?, username=?, password=?, type=? WHERE id=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssii", $name, $username, $password, $type, $id);
            } else {
                // For new user
                $query = "INSERT INTO users (name, username, password, type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssi", $name, $username, $password, $type);
            }
        }

        // Execute query and return result
        if($stmt->execute()) {
            echo "<script>alert('Data successfully saved'); setTimeout(function(){ location.reload(); }, 1500);</script>";
        } else {
            echo "<script>document.getElementById('msg').innerHTML = '<div class=\"alert alert-danger\">An error occurred. Please try again.</div>';</script>";
        }
    }
}
?>

<div class="container-fluid">
    <div id="msg"></div>
    
    <form action="" method="POST" id="manage-user">    
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
            <?php if(isset($meta['id'])): ?>
            <small><i>Leave this blank if you don't want to change the password.</i></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control" value="" autocomplete="off">
            <?php if(isset($meta['id'])): ?>
            <small><i>Leave this blank if you don't want to change the password.</i></small>
            <?php endif; ?>
        </div>

        <?php if(isset($meta['type']) && $meta['type'] == 3): ?>
            <input type="hidden" name="type" value="3">
        <?php else: ?>
        <div class="form-group">
            <label for="type">User Type</label>
            <select name="type" id="type" class="custom-select">
                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>
                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
            </select>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
