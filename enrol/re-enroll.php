  <?php

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM enroll2024 WHERE stu_id = '$search' ORDER BY id DESC ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $all_course = [
                'BEED' => 'Bachelor of Elementary Education',
                'BSED' => 'Bachelor of Secondary Education',
                'BSIT' => 'Bachelor of Science in Information Technology',
                'BSHM' => 'Bachelor of Science in Hotel Management',
                'BSBA' => 'Bachelor of Science in Business Administration'
            ];

            if ($row['course'] == 'BS-HM') {
                $row['course'] = "BSHM";
                 }
    ?>

    <style>
        select{
            font-size: 12px !important;
        }

        .table {
            position: relative;
            z-index: 100;
        }
    </style>

          <div>
              

              <div class="row">
                  <!-- <div class="col-12">
                        <h5>Add Student</h5>
                        <hr>
                        </div> -->

                  <div class="col-12">
                      <?php
                        $get_academic = $conn->query("SELECT * FROM academic WHERE status = 1");
                        $academic = $get_academic->fetch_assoc();

                        ?>
                      <table class="table">
                          <thead>
                              <th>ID #</th>
                              <th>Name</th>
                              <th>Course/Program</th>
                              <th>Semester</th>
                              <th>Academic</th>
                              <th></th>
                          </thead>
                          <tbody>
                              <td><?= $row['stu_id'] ?></td>
                              <td><?= $row['stu_name'] ?></td>
                              <td><?= $all_course[$row['course']] ?></td>
                              <td>
                                  <!-- <select name="semester" class="form-select" required>
                                                <option value="" selected disabled>Select Semester</option>
                                                <option value="1st">1st Semester</option>
                                                <option value="2nd">2nd Semester</option>
                                                <option value="Summer">Summer Semester</option>
                                            </select> -->
                                  <?= $academic['semester'] != NULL ? $academic['semester'] : '' ?> Semester
                                  <input type="hidden" name="semester" value="<?= $academic['semester'] != NULL ? $academic['semester'] : ''  ?>">
                              </td>
                              <td>


                                  <?= $academic['year'] != NULL ? $academic['year'] : '' ?> | <?= $academic['semester'] != NULL ? $academic['semester'] : ''  ?>
                                  <input type="hidden" name="academic" value="<?= $academic['id'] ?>">


                              </td>
                              <td class="dropup">
                               

                                     
                                    
                                                    <?php 
                                                        if($row['curr'] != NULL){
                                                        if ($row['curr'] == $academic['year'] && $row['semester'] == $academic['semester']) {
                                                            

                                                            if ($row['enroll_status'] == NULL) {
                                                                ?>
                                                            
                                                            <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Select Enrollment</a>
                                      
                                      <ul class="dropdown-menu">
                                          <li class="dropdown-item">
                                              <a href="#" type="button" class="d-flex align-items-center gap-1 text-dark" data-toggle="modal" data-target="#regular" style="z-index: 100 !important; position: relative;">Enroll Regular</a>
                                              
                                          </li>
                                          <li class="dropdown-item">
                                              <a type="button" class="d-flex align-items-center gap-1" data-toggle="modal" data-target="#irregular" style="z-index: 100 !important; position: relative;">Enroll Irregular</a>
                                          </li>
                                          <li class="dropdown-item">
                                              <a href="#" type="button" class="d-flex align-items-center gap-1 text-dark" data-toggle="modal" data-target="#shiftee" style="z-index: 100 !important; position: relative;">Enroll Shiftee</a>
                                          </li>
                                      </ul>
                                                            <?php 
                                                            }else{
                                                                ?>
                                                            <button type="button" class="btn btn-secondary disabled px-5" disabled>Enrolled</button>
                                                            <?php 
                                                            }

                                                        }else{
                                                        ?>
                                                            
                                                            <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Select Enrollment</a>
                                      
                                      <ul class="dropdown-menu">
                                          <li class="dropdown-item">
                                              <a href="#" type="button" class="d-flex align-items-center gap-1 text-dark" data-toggle="modal" data-target="#regular" style="z-index: 100 !important; position: relative;">Enroll Regular</a>
                                              
                                          </li>
                                          <li class="dropdown-item">
                                              <a type="button" class="d-flex align-items-center gap-1" data-toggle="modal" data-target="#irregular" style="z-index: 100 !important; position: relative;">Enroll Irregular</a>
                                          </li>
                                          <li class="dropdown-item">
                                              <a href="#" type="button" class="d-flex align-items-center gap-1 text-dark" data-toggle="modal" data-target="#shiftee" style="z-index: 100 !important; position: relative;">Enroll Shiftee</a>
                                          </li>
                                      </ul>
                                                            <?php 
                                                        }
                                                    }
                                                    ?>
                                 
                              </td>
                          </tbody>
                      </table>
                  </div>

            <input type="hidden" name="submit" id="submit">

              </div>
          </div>


          <?php require __DIR__ . '/modal-irregular.php'; ?>
          <?php require __DIR__ . '/modal-shiftee.php'; ?>
          <?php require __DIR__ . '/modal-regular.php'; ?>
<script>
                    // document.getElementById('toggle').addEventListener('click',function(){
                    //     let mainCon = document.querySelector('main');
                    //     console.log(mainCon.style.minHeight);
                    //    if(mainCon.style.minHeight == '70vh'){
                    //         mainCon.style.minHeight = '100vh';
                    //     }else{
                    //         mainCon.style.minHeight = '70vh';
                    //     }
                    // })
                    //  document.querySelectorAll('.dropdown-item').forEach(item => {
                    //     item.addEventListener('click', function(){
                    //         document.getElementById('submit').value = item.getAttribute('name'); 
                    //     })
                    // })
                  </script>
  <?php

        } else {
            echo "No record found";
        }

        // $conn->close();
    }
    ?>
