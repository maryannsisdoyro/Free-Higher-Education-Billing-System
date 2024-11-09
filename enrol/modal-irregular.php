<?php 
    $levels = [
        '1st',
        '2nd',
        '3rd',
        '4th'
    ];
    
    $courses_avail = [
        'BEED' => 'Bachelor of Elementary Education',
        'BSED' => 'Bachelor of Secondary Education',
        'BSIT' => 'Bachelor of Science in Information Technology',
        'BSHM' => 'Bachelor of Science in Hotel Management',
        'BSBA' => 'Bachelor of Science in Business Administration',
    ];
?>
<div class="modal" id="irregular">
    <form method="POST" class="modal-dialog  modal-xl" id="irregular_form">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="text-light"><i class="fa fa-wrench"></i> Manage Enrollment</h5>
            </div>
            <div class="modal-body">
            <input type="hidden" name="stu_id" value="<?= $row['stu_id'] ?>">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="semester" value="<?= $academic['semester'] != NULL ? $academic['semester'] : ''  ?>">
            <input type="hidden" name="academic" value="<?= $academic['id'] ?>">
            <input type="hidden" name="submit" id="submit">
                <div class="row">

                    <div class="col-lg-6">
                    <label for="">Name</label>
                        <input type="text" name="name" class="form-control my-2" value="<?= $row['stu_name'] ?>" readonly>

                        <label for="">Course/Program</label>
                        <select class="custom-select form-control-sm rounded-0 my-2" name="course" readonly="" required>
                                <!-- <option value="">Select Course to be Enrolled</option> -->
                                <?php 
                                  if ($row['course'] == 'BS-HM') {
                                    $row['course'] = "BSHM";
                                     }

                                  
                                    foreach($courses_avail as $key => $avail_course){
                                      
                                        if($row['course'] == $key){
                                            ?>
                                            <option selected value="<?= $key ?>"><?= $avail_course ?></option>
                                            <?php
                                        }

                                    }
                                ?>
                        </select>

                        <label for="">Year Level</label>
                        <select name="year_level" class="form-select my-2" required>
                            <option value="" selected disabled>Select Year Level</option>
                            <option value="1st">1st Year</option>
                            <option value="2nd">2nd Year</option>
                            <option value="3rd">3rd Year</option>
                            <option value="4th">4th Year</option>
                        </select>

                        <label for="">Section</label>
                                                    <?php
                                                        if ($row['course'] == 'BSIT') {
                                                        ?>
                                                        <select name="section" class="form-select my-2" required>
                                                            <option value="" selected disabled>Select Section</option>
                                                            <option value="North">North</option>
                                                            <option value="North East">North East</option>
                                                            <option value="East">East</option>
                                                            <option value="West">West</option>
                                                            <option value="South">South</option>
                                                            <option value="South East">South East</option>
                                                        </select>
                                                    <?php
                                                        } else if ($row['course'] == 'BSBA') {
                                                        ?>
                                                        <select name="section" class="form-control my-2" required>
                                                            <option value="" selected disabled>Select Section</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                        </select>
                                                    <?php
                                                        } else if ($row['course'] == 'BSED' || $row['course'] == 'BEED') {
                                                        ?>
                                                        <select name="section" class="form-control" required>
                                                            <option value="" selected disabled>Select Section</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                        </select>
                                                    <?php
                                                        } else if ($row['course'] == 'BSHM' || $row['course'] == 'BS-HM') {
                                                        ?>
                                                        <select name="section" class="form-control my-2" required>
                                                            <option value="" selected disabled>Select Section</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                        </select>
                                                    <?php
                                                        }
                                                        ?>

            <div class="form-group">
                <label for="" class="control-label">Laboratory Units/subject</label>
                <input type="text" class="form-control" name="laboratory"  value="<?php echo isset($laboratory) ? $laboratory : 0 ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Computer Units/subject</label>
                <input type="text" class="form-control" name="computer"  value="<?php echo isset($computer) ? $computer : 0 ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Academic Units Enrolled(credit and non-credit courses)</label>
                <input type="text" class="form-control" name="academic_unit"  value="0" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Academic Units of NSTP Enrolled(credit and non-credit courses)</label>
                <input type="text" class="form-control" name="academic_nstp"  value="<?php echo isset($academic_nstp) ? $academic_nstp : 0 ?>" required>
            </div>
                    </div>

                    <div class="col-lg-6">
        <div class="row">
        <div class="col-lg-12">
            <h5><b>Fee Details</b></h5>
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="ft" class="control-label">Fee Type</label>
                        <input type="text" id="ft_irregular" class="form-control-sm">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="control-label">Amount</label>
                        <input type="number" step="any" min="0" id="amount_irregular" class="form-control-sm text-right">
                    </div>
                </div>
                 <div class="form-group pt-1">
                    <label for="" class="control-label">&nbsp;</label>
                    <button class="btn btn-danger btn-sm" type="button" id="add_fee_irregular">Add to List</button>
                </div>
            </div>
            <hr>
            <table class="table table-condensed" id="fee-list-irregular">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th width="50%">Type</th>
                        <th width="45%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($id)):
                        $fees = $conn->query("SELECT * FROM fees where course_id = $id");
                        $total = 0;
                        while($row=$fees->fetch_assoc()): 
                            $total += $row['amount'];
                    ?>
                        <tr>
                            <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list_irregular($(this))" ><i class="fa fa-times"></i></button></td>
                            <td>
                                <input type="hidden" name="fid_irregular[]" value="<?php echo $row['id'] ?>">
                                <input type="hidden" name="type_irregular[]" value="<?php echo $row['description'] ?>">
                                <p><small><b class="ftype_irregular"><?php echo $row['description'] ?></b></small></p>
                            </td>
                            <td>
                                <input type="hidden" name="amount_irregular[]" value="<?php echo $row['amount'] ?>">
                                <p class="text-right"><small><b class="famount_irregular"><?php echo number_format($row['amount']) ?></b></small></p>
                            </td>
                        </tr>
                    <?php
                        endwhile; 
                        endif; 
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Total</th>
                        <th class="text-right">
                            <input type="hidden" name="total_amount_irregular" value="<?php echo isset($total) ? $total : 0 ?>">
                            <span class="tamount_irregular"><?php echo isset($total) ? number_format($total,2) : '0.00' ?></span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-12">
        <div id="fee_clone_irregular" style="display: none">
     <table >
            <tr>
                <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list_irregular($(this))" ><i class="fa fa-times"></i></button></td>
                <td>
                    <input type="hidden" name="fid_irregular[]">
                    <input type="hidden" name="type_irregular[]">
                    <p><small><b class="ftype_irregular"></b></small></p>
                </td>
                <td>
                    <input type="hidden" name="amount_irregular[]">
                    <p class="text-right"><small><b class="famount_irregular"></b></small></p>
                </td>
            </tr>
    </table>
</div>
        </div>

        </div>


                    <div class="text-end">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" name="submit_irregular" class="btn btn-danger">Submit</button>
                    </div>
                    </div>

                </div>
                       

            </div>
        </div>
    </form>
</div>



<script>
 
    $('#manage-course-irregular').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#add_fee_irregular').click(function(){
        var ft = $('#ft_irregular').val()
        var amount = $('#amount_irregular').val()
        if(amount == '' || ft == ''){
            alert_toast("Please fill the Fee Type and Amount field first.",'warning')
            return false;
        }
        var tr = $('#fee_clone_irregular tr').clone()
        tr.find('[name="type_irregular[]"]').val(ft)
        tr.find('.ftype_irregular').text(ft)
        tr.find('[name="amount_irregular[]"]').val(amount)
        tr.find('.famount_irregular').text(parseFloat(amount).toLocaleString('en-US'))
        $('#fee-list-irregular tbody').append(tr)
        $('#ft_irregular').val('').focus()
        $('#amount_irregular').val('')
        calculate_total_irregular()
    })
    function calculate_total_irregular(){
        var total = 0;
        $('#fee-list-irregular tbody').find('[name="amount_irregular[]"]').each(function(){
            total += parseFloat($(this).val())
        })
        $('#fee-list-irregular tfoot').find('.tamount_irregular').text(parseFloat(total).toLocaleString('en-US'))
        $('#fee-list-irregular tfoot').find('[name="total_amount_irregular"]').val(total)

    }
    function rem_list_irregular(_this){
        _this.closest('tr').remove()
        calculate_total_irregular()
    }
    $('#irregular_form').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        if($('#fee-list-irregular tbody').find('[name="fid_irregular[]"]').length <= 0){
            alert_toast("Please insert atleast 1 row in the fees table",'danger')
            end_load()
            return false;
        }
        $.ajax({
            url:'../ajax.php?action=save_irregular',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                console.log(resp);
                
                const result = JSON.parse(resp)
                if(result.status==1){
                    alert_toast("Data successfully saved.",'success')
                        setTimeout(function(){
                           console.log(result.enroll_id);
                           location.href = "student-cor.php?application_no=" + result.enroll_id
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">Course Name & Level already exist.</div>')
                end_load()
                }   
            }
        })
    })

    $('.select2').select2({
        placeholder:"Please Select here",
        width:'100%'
    })
</script>
