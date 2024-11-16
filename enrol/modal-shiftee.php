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
<div class="modal" id="shiftee">
    <form method="POST" class="modal-dialog  modal-xl" id="shiftee_form">
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
                        <select class="custom-select form-control-sm rounded-0 my-2" id="course_shift" name="course" required>
                                <!-- <option value="">Select Course to be Enrolled</option> -->
                                <?php 
                                  
                                    foreach($courses_avail as $key => $avail_course){
                                        
                                        if($row['course'] == $key){
                                            ?>
                                            <option selected value="<?= $key ?>"><?= $avail_course ?></option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="<?= $key ?>"><?= $avail_course ?></option>
                                            <?php 
                                        }

                                    }
                                ?>
                        </select>

                        <label for="">Year Level</label>
                        <select name="year_level" class="form-select my-2" id="year_level_shift" required>
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
                        <input type="text" id="ft_shiftee" class="form-control-sm">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="control-label">Amount</label>
                        <input type="number" step="any" min="0" id="amount_shiftee" class="form-control-sm text-right">
                    </div>
                </div>
                 <div class="form-group pt-1">
                    <label for="" class="control-label">&nbsp;</label>
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
                    <?php
                        if(isset($id)):
                        $fees = $conn->query("SELECT * FROM fees where course_id = $id");
                        $total = 0;
                        while($row=$fees->fetch_assoc()): 
                            $total += $row['amount'];
                    ?>
                        <tr>
                            <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list($(this))" ><i class="fa fa-times"></i></button></td>
                            <td>
                                <input type="hidden" name="fid_shiftee[]" value="<?php echo $row['id'] ?>">
                                <input type="hidden" name="type_shiftee[]" value="<?php echo $row['description'] ?>">
                                <p><small><b class="ftype_shiftee"><?php echo $row['description'] ?></b></small></p>
                            </td>
                            <td>
                                <input type="hidden" name="amount_shiftee[]" value="<?php echo $row['amount'] ?>">
                                <p class="text-right"><small><b class="famount_shiftee"><?php echo number_format($row['amount']) ?></b></small></p>
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
                            <input type="hidden" name="total_amount_shiftee" value="<?php echo isset($total) ? $total : 0 ?>">
                            <span class="tamount_shiftee"><?php echo isset($total) ? number_format($total,2) : '0.00' ?></span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-12">
        <div id="fee_clone_shiftee" style="display: none">
     <table >
            <tr>
                <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list($(this))" ><i class="fa fa-times"></i></button></td>
                <td>
                    <input type="hidden" name="fid_shiftee[]">
                    <input type="hidden" name="type_shiftee[]">
                    <p><small><b class="ftype_shiftee"></b></small></p>
                </td>
                <td>
                    <input type="hidden" name="amount_shiftee[]">
                    <p class="text-right"><small><b class="famount_shiftee"></b></small></p>
                </td>
            </tr>
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
                       

            </div>
        </div>
    </form>
</div>


<div id="preloader"></div>


<script>

window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
  }
  window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
  }
 
  $(document).ready(function(){
    $('#preloader').fadeOut('fast', function() {
        $(this).remove();
      })
  })

  window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }

    $('#shiftee').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#add_fee_shiftee').click(function(){
        var ft = $('#ft_shiftee').val()
        var amount = $('#amount_shiftee').val()
        if(amount == '' || ft == ''){
            alert_toast("Please fill the Fee Type and Amount field first.",'warning')
            return false;
        }
        var tr = $('#fee_clone_shiftee tr').clone()
        tr.find('[name="type_shiftee[]"]').val(ft)
        tr.find('.ftype_shiftee').text(ft)
        tr.find('[name="amount_shiftee[]"]').val(amount)
        tr.find('.famount_shiftee').text(parseFloat(amount).toLocaleString('en-US'))
        $('#fee-list-shiftee tbody').append(tr)
        $('#ft_shiftee').val('').focus()
        $('#amount_shiftee').val('')
        calculate_total()
    })
    function calculate_total(){
        var total = 0;
        $('#fee-list-shiftee tbody').find('[name="amount_shiftee[]"]').each(function(){
            total += parseFloat($(this).val())
        })
        $('#fee-list-shiftee tfoot').find('.tamount_shiftee').text(parseFloat(total).toLocaleString('en-US'))
        $('#fee-list-shiftee tfoot').find('[name="total_amount_shiftee"]').val(total)

    }
    function rem_list(_this){
        _this.closest('tr').remove()
        calculate_total()
    }
    $('#shiftee_form').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        if($('#fee-list-shiftee tbody').find('[name="fid_shiftee[]"]').length <= 0){
            alert_toast("Please insert atleast 1 row in the fees table",'danger')
            end_load()
            return false;
        }
        $.ajax({
            url:'../ajax.php?action=save_shiftee',
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
                    alert_toast("Student officially enrolled",'success')
                        setTimeout(function(){
                           console.log(result.enroll_id);
                           location.href = "student-cor.php?application_no=" + result.enroll_id
                        },2000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">Course Name & Level already exist.</div>')
                end_load()
                }   
            }
        })
    })

    // $('.select2').select2({
    //     placeholder:"Please Select here",
    //     width:'100%'
    // })
    // fix this code
    $("#year_level_shift").change(function(){
    var selectCourse = $("#course_shift").val();
    var selectYearLevel = $("#year_level_shift").val();

    // Perform AJAX call to get fees based on course and year level
    $.ajax({
        url: '../ajax.php?action=get_fees',
        data: { course_id: selectCourse, year_level: selectYearLevel },
        cache: false,
        method: 'POST',
        success: function(resp) {
            // Parse the JSON response if the server returns a JSON-encoded string
            try {
                const result = JSON.parse(resp);

                // Clear existing fee rows before appending new ones
                $('#fee-list-shiftee tbody').empty();

                // Loop through each fee in the response and add it to the list
                result.forEach(data => {
                    var tr = $('#fee_clone_shiftee tr').clone();
                    tr.find('[name="type_shiftee[]"]').val(data[1]); // Set the fee description
                    tr.find('.ftype_shiftee').text(data[1]);         // Display the fee description
                    tr.find('[name="amount_shiftee[]"]').val(data[2]);    // Set the fee amount
                    tr.find('.famount_shiftee').text(parseFloat(data[2]).toLocaleString('en-US')); // Display formatted amount

                    // Append the cloned row to the fee list table
                    $('#fee-list-shiftee tbody').append(tr);
                });

                // Recalculate the total after updating the fee list
                calculate_total_shiftee();
            } catch (error) {
                console.error("Error parsing response:", error);
                alert("Failed to retrieve fees. Please try again.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("An error occurred while fetching fees.");
        }
    });
});

// fix this code
// $("#course_shift").change(function(){
//     var selectCourse = $("#course_shift").val();
//     var selectYearLevel = $("#year_level_shift").val();

//     // Perform AJAX call to get fees based on course and year level
//     $.ajax({
//         url: '../ajax.php?action=get_fees',
//         data: { course_id: selectCourse, year_level: selectYearLevel },
//         cache: false,
//         method: 'POST',
//         success: function(resp) {
//             // Parse the JSON response if the server returns a JSON-encoded string
//             try {
//                 const result = JSON.parse(resp);

//                 // Clear existing fee rows before appending new ones
//                 $('#fee-list-shiftee tbody').empty();

//                 // Loop through each fee in the response and add it to the list
//                 result.forEach(data => {
//                     var tr = $('#fee_clone_shiftee tr').clone();
//                     tr.find('[name="type_shiftee[]"]').val(data[1]); // Set the fee description
//                     tr.find('.ftype_shiftee').text(data[1]);         // Display the fee description
//                     tr.find('[name="amount_shiftee[]"]').val(data[2]);    // Set the fee amount
//                     tr.find('.famount_shiftee').text(parseFloat(data[2]).toLocaleString('en-US')); // Display formatted amount

//                     // Append the cloned row to the fee list table
//                     $('#fee-list-shiftee tbody').append(tr);
//                 });

//                 // Recalculate the total after updating the fee list
//                 calculate_total_shiftee();
//             } catch (error) {
//                 console.error("Error parsing response:", error);
//                 alert("Failed to retrieve fees. Please try again.");
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error("AJAX Error:", status, error);
//             alert("An error occurred while fetching fees.");
//         }
//     });
// });
    
</script>
