<?php include('db_connect.php');?>
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  transform: scale(1.3);
  padding: 10px;
  cursor:pointer;
}
</style>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Courses and Fees</b>
						<span class="float:right"><a class="btn btn-danger btn-block btn-sm col-sm-2 float-right" href="?page=backup" id="new_course">
					<i class="fa fa-plus"></i> New Backup
				</a></span>
					
					</div>
					<div class="card-body table-responsive">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
$folderPath = 'backup';
$i = 1;
$fileData = []; // Array to store file paths and modification times

if (is_dir($folderPath)) {
    if ($handle = opendir($folderPath)) {
        while (false !== ($file = readdir($handle))) {
            if ($file !== "." && $file !== "..") {
                // Get the full path of the file
                $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

                // Check if it's a file (not a directory)
                if (is_file($filePath)) {
                    // Get file modification time and store in array
                    $modificationTime = filemtime($filePath);
                    $fileData[] = [
                        'filePath' => $filePath,
                        'modificationTime' => $modificationTime,
                        'fileName' => $file // Store the file name for displaying
                    ];
                }
            }
        }
        closedir($handle);

        // Sort the array by modification time (descending order)
        usort($fileData, function ($a, $b) {
            return $b['modificationTime'] - $a['modificationTime'];
        });

        // Output the sorted files in the table
        foreach ($fileData as $file) {
            $modificationTimeFormatted = date("F d Y H:i:s", $file['modificationTime']);
            ?>
            <tr>
                <td class="text-center"><?php echo $i++ ?></td>
                <td><?= $modificationTimeFormatted ?></td>
                <td class="text-center">
                    <a href="<?= $file['filePath'] ?>" class="btn btn-sm btn-outline-danger delete_course" download>
                        <i class="fa fa-download"></i> Download
                    </a>
                </td>
            </tr>
            <?php
        }
    }
}
?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

	
</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: 150px;
	}
</style>