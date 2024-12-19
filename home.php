<?php 
    include 'db_connect.php';
    $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
    $res_academic = $get_academic->fetch_array();
    $academic_year = $res_academic['year'];
    $semester_academic = $res_academic['semester'];
?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
</style>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

    <div class="container-fluid py-3">
        <div class="row" style="gap: 20px 0;">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-0">Academic School Year  <?= $res_academic['year'] ?>  |  <?= $res_academic['semester'] ?> Semester <span class="bg-danger px-2 text-light">OPENED</span></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3" ><img src="assets/icons/BSIT.png" alt="icon" style="width: 50px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_bsit = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSIT' AND curr = '$academic_year' AND semester = '$semester_academic' AND delete_status = 1");
                            echo $get_bsit->num_rows;
                        ?>
                        </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">BSIT</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3"><img src="assets/icons/bsba.png" alt="icon" style="width: 40px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_bsba = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSBA' AND curr = '$academic_year' AND semester = '$semester_academic' AND delete_status = 1");
                            echo $get_bsba->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">BSBA</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3"><img src="assets/icons/BSHM.png" alt="icon" style="width: 50px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_bshm = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSHM' AND curr = '$academic_year' AND semester = '$semester_academic' AND delete_status = 1");
                            $get_bs_hm = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BS-HM' AND curr = '$academic_year' AND semester = '$semester_academic' AND delete_status = 1");
                            echo $get_bshm->num_rows + $get_bs_hm->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">BSHM</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3"><img src="assets/icons/BSED.png" alt="icon" style="width: 40px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_bsed = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSED' AND curr = '$academic_year' AND semester = '$semester_academic' AND delete_status = 1");
                            echo $get_bsed->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">BSED</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3"><img src="assets/icons/BEED.png" alt="icon" style="width: 40px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_beed = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BEED' AND curr = '$academic_year' AND semester = '$semester_academic' AND delete_status = 1");
                            echo $get_beed->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">BEED</h5>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3"><img src="assets/icons/BEED.png" alt="icon" style="width: 40px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            
                            echo $get_beed->num_rows + $get_bsba->num_rows + $get_bsit->num_rows + $get_bshm->num_rows + $get_bsed->num_rows + $get_bs_hm->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">Total Population</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="border-bottom pb-3"> 
                        <?php 
                           echo $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Female'")->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">Female Students</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="border-bottom pb-3">
                        <?php 
                           echo $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Male'")->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">Male Students</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chart">

                        </canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="genderchart">

                        </canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart">

                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <?php 
    // TOTAL GENDER
        $regular = $conn->query("SELECT * FROM enroll2024 WHERE enroll_status = 'REGULAR'");
        $irregular = $conn->query("SELECT * FROM enroll2024 WHERE enroll_status = 'IRREGULAR'");
        $shiftee = $conn->query("SELECT * FROM enroll2024 WHERE enroll_status = 'SHIFTEE'");
    ?>

    <?php 
        $bsit_male = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Male' AND course = 'BSIT' ");
        $bsit_female = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'female' AND course = 'BSIT' ");
        $bsba_male = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Male' AND course = 'BSBA' ");
        $bsba_female = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Female' AND course = 'BSBA' ");
        $bshm_male = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Male' AND course = 'BSHM' ");
        $bshm_female = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Female' AND course = 'BSHM' ");
        $bsed_male = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Male' AND course = 'BSED' ");
        $bsed_female = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Female' AND course = 'BSED' ");
        $beed_male = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Male' AND course = 'BEED' ");
        $beed_female = $conn->query("SELECT * FROM enroll2024 WHERE gender = 'Female' AND course = 'BEED' ");
    ?>
    <script>
        var xValues = ["BSIT", "BSBA", "BSHM", "BSED", "BEED"];
var yValues = [<?php echo $get_bsit->num_rows ?>, <?php echo $get_bsba->num_rows ?>, <?php echo $get_bshm->num_rows + $get_bs_hm->num_rows ?>, <?php echo $get_bsed->num_rows ?>, <?php echo $get_beed->num_rows ?>];
var barColors = ["#dc3545"];

var val1 = ['REGULAR', 'IRREGULAR', 'SHIFTEE'];
var val2 = [<?= $regular->num_rows ?>, <?= $irregular->num_rows ?>, <?= $shiftee->num_rows ?>];
var val3 = ['#dc3545', '#007bff', '#28a745'];

new Chart("myChart", {
  type: "pie",
  data: {
    labels: val1,
    datasets: [{
      backgroundColor: val3,
      data: val2
    }]
  }
});

var genderValues = [
    [20, 20], // First department: [male, female]
    [20, 10], // Second department: [male, female]
    [15, 18], // Third department: [male, female]
    [12, 25], // Fourth department: [male, female]
    [30, 15]  // Fifth department: [male, female]
];
var genderColors = ['#dc3545', '#007bff']; // Colors for male and female

new Chart("genderchart", {
    type: "bar",
    data: {
        labels: xValues, // Departments on the X axis
        datasets: [
            {
                label: 'Male', // Dataset for males
                backgroundColor: genderColors[0], // Male color
                data: genderValues.map(val => val[0]), // Extract male data
                borderColor: genderColors[0],
                borderWidth: 1
            },
            {
                label: 'Female', // Dataset for females
                backgroundColor: genderColors[1], // Female color
                data: genderValues.map(val => val[1]), // Extract female data
                borderColor: genderColors[1],
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true, // Make the chart responsive
        legend: { display: true }, // Display legend for male and female
        title: {
            display: true,
            text: "Male and Female Students By Department"
        },
        scales: {
            x: {
                beginAtZero: true, // Ensure the bars start from 0 (or you can remove this if not needed)
            },
            y: {
                // Set custom minimum value and optional max value
                min: 5, // Set the minimum value for the Y-axis
                max: 40, // Optional: Set the maximum value for the Y-axis
                ticks: {
                    stepSize: 5, // Optional: step size for the Y axis ticks
                }
            }
        }
    }
});



new Chart("chart", {
    type: "line",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            borderColor: barColors, // Added to show the line color
            fill: false, // Change to true if you want the area under the line to be filled
            data: yValues
        }]
    },
    options: {
        responsive: true, // Make the chart responsive
        legend: { display: false },
        title: {
            display: true,
            text: "Academic School Year  <?= $res_academic['year'] ?>  |  <?= $res_academic['semester'] ?> Semester"
        },
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero:true
            }
        }]
        }
    }
});



    </script>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>