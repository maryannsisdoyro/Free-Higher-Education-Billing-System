<?php 
    include 'db_connect.php';
    $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1 ORDER BY id DESC");
    $res_academic = $get_academic->fetch_array();
    $year = $res_academic['year'];
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="border-bottom pb-3" ><img src="assets/icons/BSIT.png" alt="icon" style="width: 50px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_bsit = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSIT' AND curr = '$year'");
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
                        <h1 class="border-bottom pb-3"><img src="assets/icons/BSBA.png" alt="icon" style="width: 40px; filter: drop-shadow(5px 5px 2px #dc3545);"> : 
                        <?php 
                            $get_bsba = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSBA' AND curr = '$year'");
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
                            $get_bshm = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSHM' AND curr = '$year'");
                            echo $get_bshm->num_rows;
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
                            $get_bsed = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BSED' AND curr = '$year'");
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
                            $get_beed = $conn->query("SELECT * FROM enroll2024 WHERE course = 'BEED' AND curr = '$year'");
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
                            
                            echo $get_beed->num_rows + $get_bsba->num_rows + $get_bsit->num_rows + $get_bshm->num_rows + $get_bsed->num_rows;
                        ?>
                    </h1>
                        <div style="text-align: center;">
                        <h5 class="mb-0">Total Population</h5>
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

        </div>
        
    </div>


    <script>
        var xValues = ["BSIT", "BSBA", "BSHM", "BSED", "BEED"];
var yValues = [<?php echo $get_bsit->num_rows ?>, <?php echo $get_bsba->num_rows ?>, <?php echo $get_bshm->num_rows ?>, <?php echo $get_bsed->num_rows ?>, <?php echo $get_beed->num_rows ?>];
var barColors = ["#dc3545"];

new Chart("chart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Academic School Year  <?= $res_academic['year'] ?>  |  <?= $res_academic['semester'] ?> Semester"
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