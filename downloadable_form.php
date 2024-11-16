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

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                           <h1 class="border-bottom pb-3" ><i class="fa fa-download"></i>
                       
                        </h1>
                        <div style="text-align: center;">
                        <a href="assets/student-form.csv" class="btn btn-success" download="">Download Student Form</a>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        
    </div>


<script>
        var xValues = ["BSIT", "BSBA", "BSHM", "BSED", "BEED"];
    var yValues = [<?php echo $get_bsit->num_rows ?>, <?php echo $get_bsba->num_rows ?>, <?php echo $get_bshm->num_rows + $get_bs_hm->num_rows ?>, <?php echo $get_bsed->num_rows ?>, <?php echo $get_beed->num_rows ?>];
    var barColors = ["#dc3545"];

// new Chart("chart", {
//         type: "line",
//         data: {
//             labels: xValues,
//             datasets: [{
//             backgroundColor: barColors,
//             data: yValues
//             }]
//         },
//         options: {
//             legend: {display: false},
//             title: {
//             display: true,
//             text: "Academic School Year Semester"
//             }
//         },
//         scales: {
//             x: { // Updated to use the new scales API
//                 title: {
//                     display: true,
//                     text: 'Month'
//                 }
//             },
//             y: {
//                 beginAtZero: true,
//                 ticks: {
//                     steps: 10,
//                     stepSize: 5,
//                     max: 100
//                 }
//             }
//         }
// });

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
