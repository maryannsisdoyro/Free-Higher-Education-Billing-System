<?php 
    $levels = ['1st', '2nd', '3rd', '4th'];
    $courses_avail = [
        'BEED' => 'Bachelor of Elementary Education',
        'BSED' => 'Bachelor of Secondary Education',
        'BSIT' => 'Bachelor of Science in Information Technology',
        'BSHM' => 'Bachelor of Science in Hotel Management',
        'BSBA' => 'Bachelor of Science in Business Administration',
    ];
?>
<div class="modal" id="shiftee">
    <form method="POST" class="modal-dialog modal-xl" id="shiftee_form">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="text-light"><i class="fa fa-wrench"></i> Manage Enrollment</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="stu_id" value="<?= $row['stu_id'] ?>">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="semester" value="<?= $academic['semester'] ?? '' ?>">
                <input type="hidden" name="academic" value="<?= $academic['id'] ?>">
                <input type="hidden" name="submit" id="submit">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control my-2" value="<?= $row['stu_name'] ?>" readonly>
                        
                        <label for="">Course/Program</label>
                        <select class="form-control-sm rounded-0 my-2" id="course_shift" name="course" required>
                            <?php foreach($courses_avail as $key => $avail_course): ?>
                                <option value="<?= $key ?>" <?= $row['course'] == $key ? 'selected' : '' ?>><?= $avail_course ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="">Year Level</label>
                        <select name="year_level" class="form-select my-2" id="year_level_shift" required>
                            <option value="" disabled>Select Year Level</option>
                            <?php foreach($levels as $level): ?>
                                <option value="<?= $level ?>"><?= $level ?> Year</option>
                            <?php endforeach; ?>
                        </select>

                        <label for="">Section</label>
                        <select name="section" class="form-select my-2" required>
                            <option value="" selected disabled>Select Section</option>
                            <?php
                                $sections = match($row['course']) {
                                    'BSIT' => ['North', 'North East', 'East', 'West', 'South', 'South East'],
                                    'BSBA' => ['A', 'B', 'C', 'D'],
                                    'BSED', 'BEED' => ['A', 'B', 'C'],
                                    'BSHM' => ['A', 'B', 'C', 'D'],
                                    default => []
                                };
                                foreach ($sections as $section) {
                                    echo "<option value='$section'>$section</option>";
                                }
                            ?>
                        </select>

                        <!-- Input fields for units/subjects -->
                        <?php 
                        $unitFields = [
                            'laboratory' => 'Laboratory Units/subject',
                            'computer' => 'Computer Units/subject',
                            'academic_unit' => 'Academic Units Enrolled (credit and non-credit courses)',
                            'academic_nstp' => 'Academic Units of NSTP Enrolled (credit and non-credit courses)',
                        ];
                        foreach ($unitFields as $name => $label): ?>
                            <div class="form-group">
                                <label class="control-label"><?= $label ?></label>
                                <input type="text" class="form-control" name="<?= $name ?>" value="<?= $$name ?? 0 ?>" required>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-lg-6">
                        <!-- Fee Details Section -->
                        <div class="col-lg-12">
                            <h5><b>Fee Details</b></h5>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="ft" class="control-label">Fee Type</label>
                                        <input type="text" id="ft_shiftee" class="form-control-sm">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input type="number" step="any" min="0" id="amount_shiftee" class="form-control-sm text-right">
                                    </div>
                                </div>
                                <div class="form-group pt-1">
                                    <button class="btn btn-danger btn-sm" type="button" id="add_fee_shiftee">Add to List</button>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-condensed" id="fee-list-shiftee">
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th width="50%">Type</th>
                                        <th width="45%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic fee list -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-center">Total</th>
                                        <th class="text-right">
                                            <span class="tamount_shiftee">0.00</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" name="submit_shiftee" class="btn btn-danger">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // JavaScript for dynamic fee list management and AJAX request
    $('#add_fee_shiftee').click(function(){
        var ft = $('#ft_shiftee').val();
        var amount = $('#amount_shiftee').val();
        if (!ft || !amount) {
            alert("Please fill the Fee Type and Amount fields.");
            return;
        }

        var row = `<tr>
            <td><button type="button" onclick="removeRow(this)" class="btn-sm btn-outline-danger"><i class="fa fa-times"></i></button></td>
            <td><input type="hidden" name="type_shiftee[]" value="${ft}"><p><small><b>${ft}</b></small></p></td>
            <td><input type="hidden" name="amount_shiftee[]" value="${amount}"><p class="text-right"><small><b>${parseFloat(amount).toLocaleString()}</b></small></p></td>
        </tr>`;

        $('#fee-list-shiftee tbody').append(row);
        $('#ft_shiftee').val('');
        $('#amount_shiftee').val('');
        updateTotal();
    });

    function updateTotal() {
        let total = 0;
        $('[name="amount_shiftee[]"]').each(function() {
            total += parseFloat($(this).val());
        });
        $('.tamount_shiftee').text(total.toLocaleString());
    }

    function removeRow(button) {
        $(button).closest('tr').remove();
        updateTotal();
    }

    $('#shiftee_form').submit(function(e) {
        e.preventDefault();
        if ($('#fee-list-shiftee tbody').find('tr').length === 0) {
            alert("Please add at least one fee.");
            return;
        }
        
        $.ajax({
            url: '../ajax.php?action=save_shiftee',
            data: new FormData(this),
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.status === 1) {
                        alert("Student officially enrolled");
                        setTimeout(() => location.href = `student-cor.php?application_no=${result.enroll_id}`, 2000);
                    } else {
                        $('#msg').html('<div class="alert alert-danger mx-2">Course Name & Level already exist.</div>');
                    }
                } catch (error) {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                }
            }
        });
    });
</script>
