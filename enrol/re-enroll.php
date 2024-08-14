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

    ?>

    <style>
        select{
            font-size: 12px !important;
        }
    </style>

          <form action="" method="post">
              <input type="hidden" name="stu_id" value="<?= $row['stu_id'] ?>">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">

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
                              <th>Year Level</th>
                              <th>Section</th>
                              <th>Semester</th>
                              <th>Academic</th>
                              <th></th>
                          </thead>
                          <tbody>
                              <td><?= $row['stu_id'] ?></td>
                              <td><?= $row['stu_name'] ?></td>
                              <td><?= $all_course[$row['course']] ?></td>
                              <td>
                                  <select name="year_level" class="form-select" required>
                                      <option value="" selected disabled>Select Year Level</option>
                                      <option value="1st">1st Year</option>
                                      <option value="2nd">2nd Year</option>
                                      <option value="3rd">3rd Year</option>
                                      <option value="4th">4th Year</option>
                                  </select>
                              </td>
                              <td>

                                  <?php
                                    if ($row['course'] == 'BSIT') {
                                    ?>
                                      <select name="section" class="form-select" required>
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
                                      <select name="section" class="form-control" required>
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
                                      <select name="section" class="form-control" required>
                                          <option value="" selected disabled>Select Section</option>
                                          <option value="A">A</option>
                                          <option value="B">B</option>
                                          <option value="C">C</option>
                                          <option value="D">D</option>
                                      </select>
                                  <?php
                                    }
                                    ?>


                              </td>
                              <td>
                                  <!-- <select name="semester" class="form-select" required>
                                                <option value="" selected disabled>Select Semester</option>
                                                <option value="1st">1st Semester</option>
                                                <option value="2nd">2nd Semester</option>
                                                <option value="Summer">Summer Semester</option>
                                            </select> -->
                                  <?= $academic['semester'] ?> Semester
                                  <input type="hidden" name="semester" value="<?= $academic['semester'] ?>">
                              </td>
                              <td>


                                  <?= $academic['year'] ?> | <?= $academic['semester'] ?>
                                  <input type="hidden" name="academic" value="<?= $academic['id'] ?>">


                              </td>
                              <td>
                                <?php 
                                    if ($row['curr'] == $academic['year'] && $row['semester'] == $academic['semester']) {
                                        ?>
                                         <button type="button" class="btn btn-secondary disabled px-5" disabled>Enrolled</button>
                                        <?php 
                                    }else{
                                        ?>
                                         <button type="submit" name="submit" class="btn btn-primary px-5">Enroll</button>
                                        <?php 
                                    }
                                ?>
                                 
                              </td>
                          </tbody>
                      </table>
                  </div>



              </div>
          </form>
  <?php

        } else {
            echo "No record found";
        }

        // $conn->close();
    }
    ?>