<div class="container">
<div class="row">
<div class="col-xs-11 col-md-10 col-md-offset-1 form-academic">

<h3>Edit User</h3>

<?php
if($result[0]!="NULL")
{
	if($result[0]=="success")
	{
		echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a>';
		echo $result[1].'<br/> <a style="text-decoration:underline;" href="'.base_url().'admin/edit_user">Edit another person</a>';
		echo '</div>';
	}
	if($result[0]=="error")
	{
		echo '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error! </strong>';
		echo $result[1];
		echo '</div>';
	}
}

//print_r($current_details);
			if(isset($current_details))
			{
				if($current_details['gender']=="male")
					$male_1=1;
				else if($current_details['gender']=="female")
					$female_1=1;
			}

function set_value($a,$current_details){
	if(isset($current_details[$a]))
		return $current_details[$a];
}

if($user_id==NULL){
	if(isset($error))
	{
		echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>';
		echo $error;
		echo "</div>";
	}
	?>
	<br/>
		<form method="POST">
			<input type="text" name="admission_no" placeholder="Admission Number" style="text-transform:uppercase; max-width:300px;" class="form-control"/><br/>
			<input type="submit" value="Fetch" class="btn btn-primary">
		</form>
		<hr>
		Only Candidate accounts.
		

	<?php
}
else{

	if($current_details['verified']!=1){
		echo '<div class="alert alert-warning fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>';
		echo 'User not verified';
		echo "</div>";
	}
?>


<form method="POST" class="form">
	<input type="hidden" name="id" value="<?php echo set_value('id',$current_details); ?>">
	<div class="form-group">
		<label for="name">Name </label>
		<input type="text" style="text-transform:uppercase;" name="name" required class="form-control" value="<?php echo set_value('name',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="gender">Gender </label><br/>
		<div class="btn-group" data-toggle="buttons">
			<input type="radio" name="gender" value="male" required <?php if(isset($male_1)) echo 'checked="checked"';?>> Male
			<input type="radio" name="gender" value="female" required <?php if(isset($female_1)) echo 'checked="checked"';?>> Female
		</div>
	</div>
	<div class="form-group">
		<label for="admission_no">Username (Admission No.) </label>
		<input type="text" id="admission_no" name="admission_no" required class="form-control" style="text-transform:uppercase;" placeholder="College Admission number" value="<?php echo set_value('admission_no',$current_details); ?>">
		<p class="text-danger" id="admn_fbk"></p>
	</div>
	<div class="form-group">
		<label for="email">Email id </label>
		<input type="email" name="email" required class="form-control"  value="<?php echo set_value('email',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="mobno">Mobile number </label>
		<div class="input-group">
    	<span class="input-group-addon">+91</span>
		<input type="text" name="mobno" required class="form-control" maxlength="10" value="<?php echo set_value('mobno',$current_details); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="classes">Class</label>
	<?php
	foreach ($classes as $cls) {
		echo '<div class="radio"><label>';
		echo '<input type="radio" name="class" value="'.$cls['class'].'" required';
			if($current_details['class']==$cls['class'])
				echo ' checked="checked"';
		echo '>';
		echo $cls['des'];
		echo '</label></div>';
	}	
	?>
	</div>
	<div class="form-group">
		<label for="Address">Permanent Address </label>
		<input type="text" style="text-transform:uppercase;" name="addr_1" required class="form-control" maxlength="45" placeholder="Address line 1 " value="<?php echo set_value('addr_1',$current_details); ?>">
		<input type="text" style="text-transform:uppercase;" name="addr_2" required class="form-control" maxlength="45" placeholder="Address line 2 " value="<?php echo set_value('addr_2',$current_details); ?>">
		<input type="text" style="text-transform:uppercase;" name="addr_3" required class="form-control" maxlength="45" placeholder="Address line 3 " value="<?php echo set_value('addr_3',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="Pincode">Pincode </label>
		<input type="text" name="pincode" required class="form-control" maxlength="10" value="<?php echo set_value('pincode',$current_details); ?>">
	</div>
	<div class="form-group">
         <label for="dob">Date of birth (YYYY-MM-DD)</label>
         <input type="text" name="dob"  required class="form-control" value="<?php echo set_value('dob',$current_details); ?>">
    </div>
	<div class="form-group">
		<label for="res_no">Residential number </label>
		<input type="text" name="res_no" required class="form-control" maxlength="15" value="<?php echo set_value('res_no',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="religion">Religion </label>
		<input list="rel_dt" type="text" style="text-transform:uppercase;" name="religion" required class="form-control" maxlength="15" value="<?php echo set_value('religion',$current_details); ?>">
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
		<input type="text" style="text-transform:uppercase;" name="father_name" required class="form-control" value="<?php echo set_value('father_name',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="father_occupation">Father's Occupation </label>
		<input type="text" style="text-transform:uppercase;" name="father_occupation" required class="form-control" value="<?php echo set_value('father_occupation',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="mother_name">Mother's Name </label>
		<input type="text" style="text-transform:uppercase;" name="mother_name" required class="form-control" value="<?php echo set_value('mother_name',$current_details); ?>">
	</div>
	<div class="form-group">
		<label for="mother_occupation">Mother's Occupation </label>
		<input type="text" style="text-transform:uppercase;" list="m_occ" name="mother_occupation" required class="form-control" value="<?php echo set_value('mother_occupation',$current_details); ?>">
		<datalist id="m_occ">
			<option>HOME MAKER</option>
		</datalist>
	</div>
	<div class="form-group">
		<label for="admission_quota">Admission Quota </label>
		<select name="admission_quota" required class="form-control">
			<option></option>
			<option <?php if(set_value('admission_quota',$current_details)=="GENERAL") echo 'selected'; ?>>GENERAL</option>
			<option <?php if(set_value('admission_quota',$current_details)=="RESERVATION") echo 'selected'; ?>>RESERVATION</option>
			<option <?php if(set_value('admission_quota',$current_details)=="MANAGEMENT") echo 'selected'; ?>>MANAGEMENT</option>
		</select>
		
	</div>
    <div class="form-group">
		<label for="tenth">Tenth </label>
		<input type="text" style="text-transform:uppercase;" name="tenth" required class="form-control" value="<?php echo set_value('tenth',$current_details); ?>">
	</div>
       <div class="form-group">
		<label for="twelth">TWELTH </label>
		<input type="text" style="text-transform:uppercase;" name="twelth" required class="form-control" value="<?php echo set_value('twelth',$current_details); ?>">
	</div>
      
      <div class="form-group">
		<label for="S12-percent">S12-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S12-percent" required class="form-control" value="<?php echo set_value('S12-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S1-percent">S1-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S1-percent" required class="form-control" value="<?php echo set_value('S1-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S2-percent">S2-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S2-percent" required class="form-control" value="<?php echo set_value('S2-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S3-percent">S3-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S3-percent" required class="form-control" value="<?php echo set_value('S3-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S4-percent">S4-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S4-percent" required class="form-control" value="<?php echo set_value('S4-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S5-percent">S5-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S5-percent" required class="form-control" value="<?php echo set_value('S5-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S6-percent">S6-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S6-percent" required class="form-control" value="<?php echo set_value('S6-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S7-percent">S7-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S7-percent" required class="form-control" value="<?php echo set_value('S7-percent',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S8-percent">S8-percent </label>
		<input type="text" style="text-transform:uppercase;" name="S8-percent" required class="form-control" value="<?php echo set_value('S8-percent',$current_details); ?>">
	</div>
    
    
    
       <div class="form-group">
		<label for="S12-CGPA">S12-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S12-CGPA" required class="form-control" value="<?php echo set_value('S12-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S1-CGPA">S1-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S1-CGPA" required class="form-control" value="<?php echo set_value('S1-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S2-CGPA">S2-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S2-CGPA" required class="form-control" value="<?php echo set_value('S2-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S3-CGPA">S3-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S3-CGPA" required class="form-control" value="<?php echo set_value('S3-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S4-CGPA">S4-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S4-CGPA" required class="form-control" value="<?php echo set_value('S4-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S5-CGPA">S5-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S5-CGPA" required class="form-control" value="<?php echo set_value('S5-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S6-CGPA">S6-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S6-CGPA" required class="form-control" value="<?php echo set_value('S6-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S7-CGPA">S7-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S7-CGPA" required class="form-control" value="<?php echo set_value('S7-CGPA',$current_details); ?>">
	</div>
      <div class="form-group">
		<label for="S8-CGPA">S8-CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="S8-CGPA" required class="form-control" value="<?php echo set_value('S8-CGPA',$current_details); ?>">
	</div>
       <div class="form-group">
		<label for="aggr-percent">Aggregate percent </label>
		<input type="text" style="text-transform:uppercase;" name="aggr-percent" required class="form-control" value="<?php echo set_value('aggr-percent',$current_details); ?>">
	</div>
       <div class="form-group">
		<label for="aggr-CGPA">Aggregate CGPA </label>
		<input type="text" style="text-transform:uppercase;" name="aggr-CGPA" required class="form-control" value="<?php echo set_value('aggr-CGPA',$current_details); ?>">
	</div>
         <div class="form-group">
		<label for="ARREAR_HISTORY">ARREAR HISTORY</label>
		<input type="text" style="text-transform:uppercase;" name="aggr-CGPA" required class="form-control" value="<?php echo set_value('ARREAR_HISTORY',$current_details); ?>">
	</div>
      

	<div class="form-group">
		<input type="submit" name="submit_edit" id="submit" class="btn btn-primary" value="Update Data">
	</div>
	
</form>

<?php
}
?>

</div>
</div>
</div>