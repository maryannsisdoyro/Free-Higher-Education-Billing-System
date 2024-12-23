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
        'BSHM' => 'Bachelor of Science in Hotel Management',
        'BSBA' => 'Bachelor of Science in Business Administration',
    ];
?>
<div class="modal" id="regular">
    <form method="POST" class="modal-dialog  modal-xl" id="regular_form">
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

                        <!-- <label for="">Course/Program</label> -->
                        <!-- <input type="text" name="course" class="form-control my-2" value="<?= $all_course[$row['course']] ?>" readonly> -->

                        <label for="">Course/Program</label>
                        <select class="custom-select form-control-sm rounded-0 my-2" name="course" readonly="" id="course" required>
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
                        <select name="year_level" class="form-select my-2" id="year_level" required>
                            <option value="" selected disabled>Select Year Level</option>
                            <option value="1st">1st Year</option>
                            <option value="2nd">2nd Year</option>
                            <option value="3rd">3rd Year</option>
                            <option value="4th">4th Year</option>
                        </select>

                      

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
           
            <table class="table table-condensed" id="fee-list-regular">
                <thead>
                    <tr>
                        <!-- <th width="5%"></th> -->
                        <th width="50%">Type</th>
                        <th width="45%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($id)):
                        $fees = $conn->query("SELECT * FROM fees where course_id = $id");
                        $total = 0;
                        while($regs=$fees->fetch_assoc()): 
                            $total += $regs['amount'];
                    ?>
                        <tr>
                            <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list_regular($(this))" ><i class="fa fa-times"></i></button></td>
                            <td>
                                <input type="hidden" name="fid_regular[]" value="<?php echo $regs['id'] ?>">
                                <input type="hidden" name="type_regular[]" value="<?php echo $regs['description'] ?>">
                                <p><small><b class="ftype_regular"><?php echo $regs['description'] ?></b></small></p>
                            </td>
                            <td>
                                <input type="hidden" name="amount_regular[]" value="<?php echo $regs['amount'] ?>">
                                <p class="text-right"><small><b class="famount_regular"><?php echo number_format($regs['amount']) ?></b></small></p>
                            </td>
                        </tr>
                    <?php
                        endwhile; 
                        endif; 
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="1" class="text-center">Total</th>
                        <th class="text-right fees_list">
                            <input type="hidden" name="total_amount_regular" value="<?php echo isset($total) ? $total : 0 ?>">
                            <span class="tamount_regular"><?php echo isset($total) ? number_format($total,2) : '0.00' ?></span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-12">
        <div id="fee_clone_regular" style="display: none">
     <table >
            <tr>
                <!-- <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list_regular($(this))" ><i class="fa fa-times"></i></button></td> -->
                <td>
                    <input type="hidden" name="fid_regular[]">
                    <input type="hidden" name="type_regular[]">
                    <p><small><b class="ftype_regular"></b></small></p>
                </td>
                <td>
                    <input type="hidden" name="amount_regular[]">
                    <p class="text-right"><small><b class="famount_regular"></b></small></p>
                </td>
            </tr>
    </table>
</div>
        </div>

        </div>


                    <div class="text-end">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" name="submit_regular" class="btn btn-danger">Next</button>
                    </div>
                    </div>

                </div>
                       

            </div>
        </div>
    </form>
</div>



<script>
 
    $('#manage-course-regular').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#add_fee_regular').click(function(){
        var ft = $('#ft_regular').val()
        var amount = $('#amount_regular').val()
        if(amount == '' || ft == ''){
            alert_toast("Please fill the Fee Type and Amount field first.",'warning')
            return false;
        }
        var tr = $('#fee_clone_regular tr').clone()
        tr.find('[name="type_regular[]"]').val(ft)
        tr.find('.ftype_regular').text(ft)
        tr.find('[name="amount_regular[]"]').val(amount)
        tr.find('.famount_regular').text(parseFloat(amount).toLocaleString('en-US'))
        $('#fee-list-regular tbody').append(tr)
        $('#ft_regular').val('').focus()
        $('#amount_regular').val('')
        calculate_total_regular()
    })
    function calculate_total_regular(){
        var total = 0;
        $('#fee-list-regular tbody').find('[name="amount_regular[]"]').each(function(){
            total += parseFloat($(this).val())
        })
        $('#fee-list-regular tfoot').find('.tamount_regular').text(parseFloat(total).toLocaleString('en-US'))
        $('#fee-list-regular tfoot').find('[name="total_amount_regular"]').val(total)

    }
    function rem_list_regular(_this){
        _this.closest('tr').remove()
        calculate_total_regular()
    }
    $('#regular_form').submit(function(e){
        e.preventDefault()

        setTimeout(3000, function(){
                    location.href = "student-cor.php?application_no=<?= $row['id'] ?>"
                })

        start_load()
        $('#msg').html('')
        if($('#fee-list-regular tbody').find('[name="fid_regular[]"]').length <= 0){
            alert_toast("Please insert atleast 1 row in the fees table",'danger')
            end_load()
            return false;
        }

      

        $.ajax({
            url:'../ajax.php?action=save_regular',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                const result = JSON.parse(resp)

                if(result.status==1){
                   
                    location.href = "student-cor.php?application_no=" + result.enroll_id
                       
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">Course Name & Level already exist.</div>')
                end_load()
                } 
                
                // console.log(result);
                
            }
        })
    })

    $('.select2').select2({
        placeholder:"Please Select here",
        width:'100%'
    })

    // console.log($("input[name='year_level']"))

    // var courseSelect = $("select[name='course']")
    // $("input[name='year_level']").select(function(){
    //     console.log($("input[name='year_level']"))
    // })

  
    // fix this code
    $("#year_level").change(function(){
    var selectCourse = $("#course").val();
    var selectYearLevel = $("#year_level").val();

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
                $('#fee-list-regular tbody').empty();

                // Loop through each fee in the response and add it to the list
                result.forEach(data => {
                    var tr = $('#fee_clone_regular tr').clone();
                    tr.find('[name="fid_regular[]"]').val(data[0]);
                    tr.find('[name="type_regular[]"]').val(data[1]); // Set the fee description
                    tr.find('.ftype_regular').text(data[1]);         // Display the fee description
                    tr.find('[name="amount_regular[]"]').val(data[2]);    // Set the fee amount
                    tr.find('.famount_regular').text(parseFloat(data[2]).toLocaleString('en-US')); // Display formatted amount

                    // Append the cloned row to the fee list table
                    $('#fee-list-regular tbody').append(tr);
                });

                // Recalculate the total after updating the fee list
                calculate_total_regular();
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

    

</script> 
