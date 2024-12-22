<?php $course = $row['course'] ?>

<select name="section" class="form-control BSIT <?= $course != 'BSIT' ? 'd-none' : '' ?>" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="North">North</option>
    <option value="North East">North East</option>
    <option value="East">East</option>
    <option value="West">West</option>
    <option value="South">South</option>
    <option value="South East">South East</option>
</select>

<select name="section" class="form-control BEED <?= $course != 'BEED' ? 'd-none' : '' ?>" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>

<select name="section" class="form-control BSED <?= $course != 'BSED' ? 'd-none' : '' ?>" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>

<select name="section" class="form-control BSBA <?= $course != 'BSBA' ? 'd-none' : '' ?>" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>

<select name="section" class="form-control BSHM <?= $course != 'BSHM' || $course != 'BS-HM' ? 'd-none' : '' ?>" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>

