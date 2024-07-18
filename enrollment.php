<?php include 'db_connect.php' ?>
<div class="container-fluid">
        <div class="form-container">
<<<<<<< HEAD
            <h5>COLLEGE APPLICATION FORM</h5>
=======
            <h2>COLLEGE APPLICATION FORM <br>2024-2025</h2>
>>>>>>> origin/main
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
                    <input type="tel" class="form-control" id="contact" name="contact" minlength="11" maxlength="11" pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number" required>
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
                
<<<<<<< HEAD
                <!-- <button type="submit" class="btn btn-submit">Submit</button> -->
=======
                <button type="submit" class="btn btn-submit">Submit</button>
>>>>>>> origin/main
            </form>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-1BmE4k2HxZbAUot0H8VW4+nH6HiQoTCtVhjx2Ks11P+3pFb6PI8qzWJ5KqL5vmHH" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+EW0PA/Nk5O2AWK3xFPrDh4Ta1gYhT3Y2vo" crossorigin="anonymous"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.all.min.js"></script>
   
    <script>
    // Get current date in yyyy-mm-dd format
    function getCurrentDate() {
        const now = new Date();
        const year = now.getFullYear();
        let month = now.getMonth() + 1;
        let day = now.getDate();

        // Ensure month and day are two digits
        if (month < 10) {
            month = '0' + month;
        }
        if (day < 10) {
            day = '0' + day;
        }

        return `${year}-${month}-${day}`;
    }

    // Set today's date as the default value for the input
    document.getElementById('date_signed').  value = getCurrentDate();
</script>
    <script>
    function updateCompleteName() {
        const firstName = document.getElementById('first_name').value.trim().toUpperCase();
        const middleName = document.getElementById('middle_name').value.trim().toUpperCase();
        const lastName = document.getElementById('last_name').value.trim().toUpperCase();
        const completeName = `${lastName} ${firstName} ${middleName}`.trim().replace(/\s+/g, ' ');
        document.getElementById('complete_name').value = completeName;
    }

    function capitalizeInput(element) {
        const words = element.value.split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
        }
        element.value = words.join(' ');
    }

    function uppercaseFieldsBeforeSubmit() {
        const firstName = document.getElementById('first_name');
        const middleName = document.getElementById('middle_name');
        const lastName = document.getElementById('last_name');

        firstName.value = firstName.value.toUpperCase();
        middleName.value = middleName.value.toUpperCase();
        lastName.value = lastName.value.toUpperCase();
    }

    function setMaxDate() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date_of_birth').setAttribute('max', today);
        document.getElementById('date_signed').setAttribute('max', today);
    }

    document.addEventListener('DOMContentLoaded', setMaxDate);

    document.getElementById('enrollment-form').addEventListener('submit', function(event) {
        event.preventDefault();

        uppercaseFieldsBeforeSubmit();

        Swal.fire({
            title: 'Confirm Submission',
            text: "Are you sure you want to submit the form?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
   
    <script>
    function showInput() {
        var selectBox = document.getElementById("track_and_strand");
        var userInput = document.getElementById("otherInput");
        if (selectBox.value === "Others") {
            userInput.style.display = "block";
        } else {
            userInput.style.display = "none";
        }
    }
</script>