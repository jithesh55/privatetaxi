<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">
<h2 style="color:#7C7C7C;">CANDIDATE SIGNUP <small>to be verified by class volunteer</small></h2><br/>

<div class="col-md-7">
<?php
if($result[0]!="NULL")
{
	if($result[0]=="success")
	{
		echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a>';
		echo $result[1];
		echo '</div>';
	}
	if($result[0]=="error")
	{
		echo '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error! </strong>';
		echo $result[1];
		echo '</div>';
	}
}
?>
<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" class="form">
	<div class="form-group">
		<label for="name">Name </label>
		<input type="text" style="text-transform:uppercase;" name="name" required class="form-control" value="<?php echo set_value('name'); ?>">
	</div>
	<div class="form-group">
		<?php
			if(isset($_POST['gender']))
			{
				if($_POST['gender']=="male")
					$male_1=1;
				else if($_POST['gender']=="female")
					$female_1=1;
			}
		?>
		<label for="gender">Gender </label><br/>
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-default"><input type="radio" name="gender" value="male" required <?php if(isset($male_1)) echo 'checked="checked"';?>>Male</label>
			<label class="btn btn-default"><input type="radio" name="gender" value="female" required <?php if(isset($female_1)) echo 'checked="checked"';?>>Female</label>
		</div>
	</div>
	<div class="form-group">
		<label for="admission_no">Username (Admission No.) </label>
		<input type="text" id="admission_no" name="admission_no" required class="form-control" style="text-transform:uppercase;" placeholder="College Admission number" value="<?php echo set_value('admission_no'); ?>">
		<p class="text-danger" id="admn_fbk"></p>
	</div>
	<div class="form-group">
		<label for="password">Password </label>
		<input type="password" id="password" name="password" required class="form-control" >
		<p class="text-danger fbk" id="psw_fbk">Sorry! The password should atleast be 5 characters</p>
	</div>
	<div class="form-group">
		<label for="r_password">Password Again</label>
		<input type="password" id="r_password" name="r_password" required class="form-control" >
		<p class="text-danger fbk" id="r_psw_fbk">Sorry! The passwords doesn't match</p>
	</div>
	<div class="form-group">
		<label for="email">Email id </label>
		<input type="email" name="email" required class="form-control"  value="<?php echo set_value('email'); ?>">
	</div>
	<div class="form-group">
		<label for="mobno">Mobile number </label>
		<div class="input-group">
    	<span class="input-group-addon">+91</span>
		<input type="text" name="mobno" required class="form-control" maxlength="10" value="<?php echo set_value('mobno'); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="classes">Class</label>
	<?php
	foreach ($classes as $cls) {
		echo '<div class="radio"><label>';
		echo '<input type="radio" name="class" value="'.$cls['class'].'" required';
		if(isset($_POST['class']))
			if($_POST['class']==$cls['class'])
				echo ' checked="checked"';
		echo '>';
		echo $cls['des'];
		echo '</label></div>';
	}	
	?>
	</div>
	<div class="form-group">
		<label for="Address">Permanent Address </label>
		<input type="text" style="text-transform:uppercase;" name="addr_1" required class="form-control" maxlength="45" placeholder="Address line 1 " value="<?php echo set_value('addr_1'); ?>">
		<input type="text" style="text-transform:uppercase;" name="addr_2" required class="form-control" maxlength="45" placeholder="Address line 2 " value="<?php echo set_value('addr_2'); ?>">
		<input type="text" style="text-transform:uppercase;" name="addr_3" required class="form-control" maxlength="45" placeholder="Address line 3 " value="<?php echo set_value('addr_3'); ?>">
	</div>
	<div class="form-group">
		<label for="Pincode">Pincode </label>
		<input type="text" name="pincode" required class="form-control" maxlength="10" value="<?php echo set_value('pincode'); ?>">
	</div>
	<div class="form-group">
         <label for="dob">Date of birth</label>
         <input type="text" name="dob" id="datepicker" required class="form-control" value="<?php echo set_value('dob'); ?>">
    </div>
	<div class="form-group">
		<label for="res_no">Residential number </label>
		<input type="text" name="res_no" required class="form-control" maxlength="15" value="<?php echo set_value('res_no'); ?>">
	</div>
	<div class="form-group">
		<label for="religion">Religion </label>
		<input list="rel_dt" type="text" style="text-transform:uppercase;" name="religion" required class="form-control" maxlength="15" value="<?php echo set_value('religion'); ?>">
		<datalist id="rel_dt">
			<option>CHRISTIAN</option>
			<option>MUSLIM</option>
			<option>HINDU</option>
			<option>SIKH</option>
			<option>JAIN</option>
		</datalist>
	</div>
	<div class="form-group">
		<label for="father_name">Father's Name </label>
		<input type="text" style="text-transform:uppercase;" name="father_name" required class="form-control" value="<?php echo set_value('father_name'); ?>">
	</div>
	<div class="form-group">
		<label for="father_occupation">Father's Occupation </label>
		<input type="text" style="text-transform:uppercase;" name="father_occupation" required class="form-control" value="<?php echo set_value('father_occupation'); ?>">
	</div>
	<div class="form-group">
		<label for="mother_name">Mother's Name </label>
		<input type="text" style="text-transform:uppercase;" name="mother_name" required class="form-control" value="<?php echo set_value('mother_name'); ?>">
	</div>
	<div class="form-group">
		<label for="mother_occupation">Mother's Occupation </label>
		<input type="text" style="text-transform:uppercase;" list="m_occ" name="mother_occupation" required class="form-control" value="<?php echo set_value('mother_occupation'); ?>">
		<datalist id="m_occ">
			<option>HOME MAKER</option>
		</datalist>
	</div>
	<div class="form-group">
		<label for="admission_quota">Admission Quota </label>
		<select name="admission_quota" required class="form-control">
			<option></option>
			<option <?php if(set_value('admission_quota')=="GENERAL") echo 'selected'; ?>>GENERAL</option>
			<option <?php if(set_value('admission_quota')=="RESERVATION") echo 'selected'; ?>>RESERVATION</option>
			<option <?php if(set_value('admission_quota')=="MANAGEMENT") echo 'selected'; ?>>MANAGEMENT</option>
		</select>
		
	</div>

	<div class="form-group">
		<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Signup">
	</div>
	
</form>

</div><!--internal col -->

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->


