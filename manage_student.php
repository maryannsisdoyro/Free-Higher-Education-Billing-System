<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM student where id= " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>

        <div class="form-group">
            <label for="" class="control-label">Sequence No.</label>
            <input type="text" class="form-control" name="sequence_no" value="<?php echo isset($sequence_no) ? $sequence_no : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Student No.</label>
            <input type="text" class="form-control" name="id_no" value="<?php echo isset($id_no) ? $id_no : '' ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="control-label">Given Name</label>
                    <input type="text" class="form-control" name="fname" value="<?php echo isset($fname) ? $fname : '' ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="control-label">Middle Name</label>
                    <input type="text" class="form-control" name="mname" value="<?php echo isset($mname) ? $mname : '' ?>" required>
                </div>
            </div>

        </div>

        <div class="form-group">
            <label for="" class="control-label">Last Name</label>
            <input type="text" class="form-control" name="lname" value="<?php echo isset($lname) ? $lname : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Gender</label>
            <div class="d-flex">
                <input type="radio" class="form-check" name="gender" value="Male" <?= isset($gender) ? $gender == 'Male' ? 'checked' : '' : 'checked' ?>>
                <span style="margin: 0 20px 0 5px !important;">Male</span> 
                <input type="radio" class="form-check" name="gender" value="Female" <?= isset($gender) ? $gender == 'Female' ? 'checked' : '' : '' ?>>
                <span style="margin: 0 0 0 5px !important;">Female</span> 
            </div>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Contact</label>
            <input type="tel" class="form-control" pattern="[0-9]{11}" minlength="11" maxlength="11" name="contact" value="<?php echo isset($contact) ? $contact : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Address</label>
            <textarea name="address" id="" cols="30" rows="3" class="form-control" required=""><?php echo isset($address) ? $address : '' ?></textarea>
        </div>
    </form>
</div>
<script>
    $('#manage-student').on('reset', function() {
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-student').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_student',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved.", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger mx-2">ID # already exist.</div>')
                    end_load()
                }
            }
        })
    })

    $('.select2').select2({
        placeholder: "Please Select here",
        width: '100%'
    })
</script>