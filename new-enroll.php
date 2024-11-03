<div class="container">
        <div class="form-container">
            <!-- <h2>COLLEGE APPLICATION FORM <br>2024-2025</h2> -->
            <form id="enrollment-form" action="enroll.php" method="post">
                
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required oninput="updateCompleteName(); capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required oninput="updateCompleteName(); capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" oninput="updateCompleteName(); capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="home_address">Home Address:**(Example: Brgy.Bunakan,Madridejos,Cebu)</label>
                    <input type="text" class="form-control" id="home_address" name="home_address" oninput="capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="present_address">Present Address:**(Example: Brgy.Bunakan,Madridejos,Cebu)</label>
                    <input type="text" class="form-control" id="present_address" name="present_address" oninput="capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" class="form-control" id="contact" name="contact" pattern="[0-9]{11}" minlength="11" maxlength="11" title="Please enter a valid 11-digit contact number" required>
                </div>
                
                <div class="form-group">
                    <label for="sex">Sex:</label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth: (Date/Month/Year)  </label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="place_of_birth">Place of Birth:</label>
                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" oninput="capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="civil_status">Civil Status:</label>
                    <select class="form-control" id="civil_status" name="civil_status">
                        <option value="">Select Civil Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Separated">Separated</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="elementary">Elementary School:</label>
                    <input type="text" class="form-control" id="elementary" name="elementary" oninput="capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="elementary_year_graduated">Year Graduated (Elementary):</label>
                    <input type="number" class="form-control" id="elementary_year_graduated" name="elementary_year_graduated" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year">
                </div>

                <div class="form-group">
                    <label for="high_school">High School:</label>
                    <input type="text" class="form-control" id="high_school" name="high_school" oninput="capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="high_school_year_graduated">Year Graduated (High School):</label>
                    <input type="number" class="form-control" id="high_school_year_graduated" name="high_school_year_graduated" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year">
                </div>
                
                <div class="form-group">
                    <label for="shs">Senior High School (SHS):</label>
                    <input type="text" class="form-control" id="shs" name="shs" oninput="capitalizeInput(this);">
                </div>
                
                <div class="form-group">
                    <label for="shs_year_graduated">Year Graduated (SHS):</label>
                    <input type="number" class="form-control" id="shs_year_graduated" name="shs_year_graduated" min="1900" max="2099" pattern="\d{4}" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" title="Please enter a valid 4-digit year">
                </div>
                
                <div class="form-group">
                    <label for="track_and_strand">Track and Strand:</label>
                    <select class="form-control" id="track_and_strand" name="track_and_strand" onchange="showInput()">
                        <option value="">Select Track and Strand</option>
                        <option value="ABM">ABM (Accountancy, Business, and Management)</option>
                        <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                        <option value="TVL">TVL (Technical-Vocational-Livelihood)</option>
                        <option value="STEM">STEM (Science, Technology, Engineering, and Mathematics)</option>
                        <option value="Others">Others</option>
                    </select>
                    <br>
                    <div id="otherInput" style="display: none;">
                     <input type="text" class="form-control" id="otherTrackStrand" name="otherTrackStrand" placeholder="Please specify">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="complete_name">Complete Name:</label>
                    <input type="text" class="form-control" id="complete_name" name="complete_name" readonly>
                </div>
                
                <div class="form-group">
                    <label for="date_signed">Date Signed:</label>
                    <input type="date" class="form-control" id="date_signed" name="date_signed" required>
                </div>
                
                <div class="form-group">
                    <label for="course_to_be_enrolled">Course to be Enrolled:</label>
                    <select class="form-control" id="course_to_be_enrolled" name="course_to_be_enrolled" required>
                         <option value="">Select Course to be Enrolled</option>
                        <option value="Bachelor of Elementary Education">BEED (Bachelor of Elementary Education)</option>
                        <option value="Bachelor of Secondary Education">BSED (Bachelor of Secondary Education Major in Filipino)</option>
                        <option value="Bachelor of Science in Information Technology">BSIT (Bachelor of Science in Information Technology)</option>
                        <option value="Bachelor of Science in Hotel Management">BSHM (Bachelor of Science in Hotel Management)</option>
                        <option value="Bachelor of Science in Business Administration">BSBA (Bachelor of Science in Business Administration Major in Financial Management)</option>
                    </select>
                </div>
                
                <!-- <button type="submit" class="btn btn-submit">Submit</button> -->
            </form>
        </div>
    </div>


    <script>
        $('#enrollment-form').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=new_enroll',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							var nw = window.open('receipt.php?ef_id='+resp.ef_id+'&pid='+resp.pid,"_blank","width=1000,height=900")
							setTimeout(function(){
								nw.print()
								setTimeout(function(){
									nw.close()
									location.reload()
								},500)
							},500)
						},500)
				}
			}
		})
	})
    </script>