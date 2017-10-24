<div class="container">
<div class="row">
<div class="col-xs-11 col-md-8 col-md-offset-2">


<div class="form-academic">
	<h2 class="text-primary">ADD PLACEMENT</h2><br/>
	<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
	<div class="form-group">
		<label for="company_name">COMPANY NAME</label>
		 <input type="text" name="placement_name" required class="form-control" maxlength="29">
	</div>
    <div class="form-group">
        <label for="designation">DESIGNATION</label>
        <input type="text" name="designation" required class="form-control" maxlength="29">
        </div>
    <div class="form-group">
        <label for="package">PACKAGE</label>
        <input type="text" name="package" required class="form control" maxlength="29">
        </div>
        <div class="form-group">
        <label for="location">LOCATION</label>
        <input type="text" name="location" required class="form control" maxlength="29">
        </div>
	<div class="form-group">
		<label for="about">ABOUT THE PLACEMENT </label> <small>Give details for candidates.</small>
		<textarea name="about" required class="form-control" maxlength="950" style="height:200px;"></textarea>
	</div>
	<div class="form-group">
		<label for="type">TYPE</label> 
		<select name="type" required class="form-control">
			<option value="normal">Normal | IT companies</option>
			<option value="special">Special | Core/Dream Company</option>	
		</select>
	</div>
	<div class="form-group">
		<label for="year">GRADUATE YEAR</label> 
		<select name="year" required class="form-control">
			<option value="">-SELECT-</option>
			<?php
			for($i=date("Y")-2; $i<date("Y")+5; $i++ )
				echo '<option value="'.$i.'">Graduate in '.$i.'</option>';
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="levels">Levels</label> 
		<select name="levels" required class="form-control">
			<option value="1">1 Level</option>
			<option value="2">2 Levels</option>	
			<option value="3">3 Levels</option>	
			<option value="4">4 Levels</option>	
			<option value="5">5 Levels</option>
			<option value="6">6 Levels</option>	
			<option value="7">7 Levels</option>		
		</select>
	</div>
<br/>
	<h6>SELECT THE COURSES</h6>
	<div class="btn-group" data-toggle="buttons">
		<label for="BTECH" class="btn btn-default">
		<input type="checkbox" value="1" name="BTECH" class="toggler" toggle="BTECH_condition">
		BTECH</label>
		<label for="MTECH" class="btn btn-default">
		<input type="checkbox" value="1" name="MTECH" class="toggler" toggle="MTECH_condition">
		MTECH</label>
		<label for="MCA" class="btn btn-default">
		<input type="checkbox" value="1" name="MCA" class="toggler" toggle="MCA_condition">
		MCA</label>
	</div><br/><br/>

<?php
$temp=array("BTECH","MTECH","MCA");
foreach ($temp as $key) {

?>

		<div id="<?php echo $key; ?>_condition" style="background:#e8e8e8; display:none; border-radius:5px; padding:20px; margin-top:10px;">
			<h5 class="text-primary"><?php echo $key; ?> CONDITIONS</h5>

			<div class="form-group">
			<label for="<?php echo $key; ?>_branch">Applicable for</label><br/> 
			(If none is selected, it will be available to all the branches)<br/>
			<?php
			$val= $this->class_convertion_model->list_short_names();
		    $init=0;
		    foreach ($val as $branch) {
		    	echo '<input type="checkbox" value="1" name="'.$key.'_branch_'.$branch.'"> '.$this->class_convertion_model->convert($branch).'<br/>';
		    }
		    ?>
		    </div>
            
			<div class="form-group">
				<label for="<?php echo $key; ?>_filled_upto">User must fill upto</label> 
				<select name="<?php echo $key; ?>_filled_upto" class="form-control">
				<?php
				if($key!="BTECH")
				{
					?>
					<option value="S1">Semester 1</option>
					<option value="S2">Semester 2</option>
					<?php
				}
				?>
					<option value="S3">Semester 3</option>
					<option value="S4">Semester 4</option>
					<?php 
					if($key!="MTECH")
					{
					?>
						<option value="S5">Semester 5</option>
						<option value="S6">Semester 6</option>
					<?php 
					if($key!="MCA")
					{
					?>
						<option value="S7">Semester 7</option>
						<option value="S8">Semester 8</option>	

					<?php
					}}
					?>
				</select>
			</div>

			<div class="form-group">
				<label for="<?php echo $key; ?>_max_arrear">Maximum arrears</label> 
				<select name="<?php echo $key; ?>_max_arrear" class="form-control">
					<option value="2002">No restriction on arrears left</option>
					<option value="0">0 arrear</option>	
					<option value="1">1 arrear</option>	
					<option value="2">2 arrears</option>	
					<option value="3">3 arrears</option>	
					<option value="4">4 arrears</option>	
					<option value="5">5 arrears</option>	
					<option value="6">6 arrears</option>	
					<option value="7">7 arrears</option>	
					<option value="8">8 arrears</option>	
					<option value="9">9 arrears</option>	
				</select>
			</div>
            
			<div class="form-group">
				<label for="<?php echo $key; ?>_arrear_history_problem">Arrear history allowed?</label> 
				<select name="<?php echo $key; ?>_arrear_history_problem" class="form-control">
					<option value="0">No problem of arrear history</option>	
					<option value="1">Arrear history not allowed</option>
				</select>
			</div>
			<div class="form-group">
				<label for="<?php echo $key; ?>_min_percent">Minimum Percentage required (Aggregate)</label> 
				<input type="text" name="<?php echo $key; ?>_min_percent" class="form-control input-sp" placeholder="Float/Integer value" data-type="percent">
				<input type="checkbox" name="<?php echo $key; ?>_min_percent_switch" class="does_not"> Does not apply
				<div class="text-danger error"></div>
			</div>
			<div class="form-group">
				<label for="<?php echo $key; ?>_min_CGPA">Minimum CGPA required (Aggregate)</label> 
				<input type="text" name="<?php echo $key; ?>_min_CGPA" class="form-control input-sp" placeholder="Float/Integer value" data-type="CGPA">
				<input type="checkbox" name="<?php echo $key; ?>_min_CGPA_switch" class="does_not"> Does not apply
				<div class="text-danger error"></div>
			</div>
            <div class="form-group"><label for="<?php echo $key; ?>_plus_two">PLUS TWO</label><input type="text" name= "<?php echo $key; ?>_plus_two" class="form-contol input-sp" placeholder="Percentage in plus two" data-type="percentage"></div>
            <div class="form-group"><label for="<?php echo $key; ?>_tenth">10th</label><input type="text" name= "<?php echo $key; ?>_tenth" class="form-control input-sp" placeholder="percentage in 10th" data-type="percentage"></div>
            <div class="form-group"><label for="<?php echo $key; ?>_diploma">DIPLOMA</label><input type="text" name= "<?php echo $key; ?>_diploma" class="form-control input-sp" placeholder="percentage in Diploma" data-type="percentage"></div>
            <?php
				if($key=="MTECH")
				{
					?>
            <div class="form-group"><label for="<?php echo $key; ?>_degree">DEGREE</label><input type="text" name= "<?php echo $key; ?>_degree" class="form-control input-sp" placeholder="percentage in Degree" data-type="percentage"></div>
            <?php
                }
                         ?>
		

         <?php
				if($key=="MCA")
				{
					?>
            <div class="form-group"><label for="<?php echo $key; ?>_ug">UG</label><input type="text" name= "<?php echo $key; ?>_ug" class="form-control input-sp" placeholder="percentage in UG" data-type="percentage"></div>
            <?php
                }
                         ?>
		</div>

<?php
}
?>
        
        

<br/><br/>
	<div class="alert alert-warning fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>
	Placement once submitted, can only be deleted. It cannot be updated.<br/>
	Please recheck the entered data.
	</div>
	<input type="checkbox" id="read_all"> I've read and confirmed the above placement data.<br/><br/>
	<input type="submit" class="btn btn-primary pull-right" name="submit" id="submit">
	</form>
</div> <!--form academic -->

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->

<script type="text/javascript">
$(document).ready(function(){

	$("#submit").prop('disabled',true);
	$('.toggler').change(function(){
		var toggle=$(this).attr('toggle');
		if($(this).prop('checked')==true)
		{
			$('#'+toggle).show(500);
		}
		else
		{
			$('#'+toggle).hide(500);
		}
	});

	$('#read_all').change(function(){
		if($(this).prop('checked') == true)
			$("#submit").prop('disabled',false);
		else
			$("#submit").prop('disabled',true);
	});

	$('.does_not').change(function(){
		if($(this).prop("checked")==true)
		{
			$(this).siblings(':input[type="number"]').val("");
			$(this).siblings(':input[type="number"]').prop("disabled",true);
		}
		else
		{
			$(this).siblings(':input[type="number"]').prop("disabled",false);
		}
	});
	$('.input-sp').keyup(function(){
				var val= $(this).val();
				var data_type = $(this).attr('data-type');
				var id = $(this).attr('id');
				var error_val="";
				if(isNaN(val))
						error_val="Should be a number";
				else
				{
						if(data_type=="percent")
						{
								val=parseFloat(val);
								if(val>parseFloat(100) || val<parseFloat(0))
									error_val="Should be between 0 and 100.";
							
						}
						else if(data_type=="CGPA")
						{
							val=parseFloat(val);
							if(val>parseFloat(10) || val<parseFloat(0))
								error_val="Should be between 0 and 10.";
						}
						else if(data_type=="number")
						{
							
								if (val % 1 === 0)
								{
									val=parseInt(val);
									if(val<parseInt(0))
										error_val="Cannot be less than 0";
								}
								else
									error_val="Should be integer value";
						}
				}
					$(this).siblings('.error').html(error_val);
		});
})	
</script>
