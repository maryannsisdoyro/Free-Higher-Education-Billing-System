<?php $course = $row['course'] ?>
<?php if($course == 'BSIT'): ?>
<select name="section" class="form-control BSIT" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="North">North</option>
    <option value="North East">North East</option>
    <option value="East">East</option>
    <option value="West">West</option>
    <option value="South">South</option>
    <option value="South East">South East</option>
</select>
<?php elseif($course == 'BEED') ?>
<select name="section" class="form-control BEED" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>
<?php elseif($course == 'BSED') ?>
<select name="section" class="form-control BSED" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>
<?php elseif($course == 'BSBA') ?>
<select name="section" class="form-control BSBA" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>
<?php elseif($course == 'BSHM') ?>
<select name="section" class="form-control BSHM" required>
    <!-- <option value="" selected disabled>Select Section</option> -->
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
</select>
<?php endif; ?>