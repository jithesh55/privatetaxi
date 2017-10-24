<?php
			$this->load->model('academic_model');

?>

<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-1">

<?php
if(isset($result))
{
	if($result[0]=="error")
		echo '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a>'.$result[1].'</div>';
	else if($result[0]=="success")
		echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a>Sucessfully submitted academic data for verification.<br/>Wait till your class volunteer verifies it.</div>';
}

	$academic_lock=0;
	$aca=$this->db->simple_query('SELECT * FROM config_table WHERE key1="academic_lock"');
	if($aca_row=mysqli_fetch_array($aca))
	{
		if($aca_row['value1']=='1')
			$academic_lock=1;
	}
?>

<div class="form-academic">
	<h3 class="text-muted">UPDATE ACADEMIC DATA</h3><br/>
		<?php
		if($academic_lock==0)
		{ 
		?>
		<div class="alert alert-info fade in">
		  <a href="#" class="close" data-dismiss="alert">&times;</a>
			Don't forget to click the UPDATE button at the end of the page after adding data.
		</div>
		<?php
		}
		else
			echo '<div id="fill_prev" class="alert alert-danger fade in" >Academic Updation Locked by admin.</div>';
		?>
	<form method="POST" id="update-form" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" >
		<h5 class="text-primary">Initial Data</h5>
		<table class="table">
		<?php
		foreach ($individuals as $ind) {
			echo '<tr>';
			echo '<th>'.$this->academic_model->decode($ind).'</th>';
			$data_type=$this->academic_model->get_type_of_value($ind);
			echo '<td>';
			$value="";
				if(isset($current[$ind])) $value=($current[$ind]);
			if($data_type=="percent")
				echo '<div class="form-group"><div class="input-group">   <input type="text" class="form-control input-sp initial" name="'.$ind.'" id="'.$ind.'" data_type="'.$data_type.'" maxlength="5" required value="'.$value.'">  <div class="input-group-addon">%</div> </div></div>';
			else if($data_type=="number")
				echo '<div class="form-group">  <input type="text" class="form-control input-sp initial" name="'.$ind.'" id="'.$ind.'" data_type="'.$data_type.'" maxlength="5" required value="'.$value.'"> </div>';
			else //for CGPA
				echo '<div class="form-group"><div class="input-group">  <div class="input-group-addon">CGPA in 10</div> <input type="text" class="form-control input-sp initial" name="'.$ind.'" id="'.$ind.'" data_type="'.$data_type.'" maxlength="5" required value="'.$value.'"> </div></div> ';
			echo '<div class="text-danger" id="error_'.$ind.'"></div>';
			if(isset($previous[$ind]) && $current[$ind]!=$previous[$ind]) echo '<small class="text-muted">Waiting for verification: <strong>'.$previous[$ind].'</strong></small>';
			echo '</td>';
			echo '</tr>';
		}

	
		echo '<tr><th><strong id="arrear-sp" class="bg-info" style="padding:5px; border-radius:5px;"></strong> arrears upto</th>';
		echo '<td><div class="form-group">';
		echo '<select name="ARREAR_LAST" class="form-control" id="ARREAR_LAST">';
		foreach ($pairs as $ind) {
			if($ind==($current['ARREAR_LAST']))
				$value='selected';
			else
				$value='';
			echo '<option value="'.$ind.'" '.$value.'>'.$this->academic_model->decode($ind);
			echo '</option>';
		}
		echo '</select>';

		if(isset($previous['ARREAR_LAST']) && $current['ARREAR_LAST']!=$previous['ARREAR_LAST']) echo '<br/><small class="text-muted">Waiting for verification: <strong>'.$this->academic_model->decode($previous['ARREAR_LAST']).'</strong></small>';
		echo '</div></td>'; 

		echo '<tr><th>Do you have any arrear history</th>';
		echo '<td><div class="form-group">';
		echo '<select name="ARREAR_HISTORY" class="form-control" id="ARREAR_LAST" required >';
			if(($current['ARREAR_HISTORY'])=='yes')
			{
				$value_yes='selected';
				$value_no='';
			}
			else if(($current['ARREAR_HISTORY'])=='no')
			{
				$value_no='selected';
				$value_yes='';
			}
			else
			{
				$value_no='';
				$value_yes='';
			}

			echo '<option '.$value_no.' value="no">No</option>';
			echo '<option '.$value_yes.' value="yes">Yes</option>';
			
		echo '</select>';

		if(isset($previous['ARREAR_HISTORY']) && $current['ARREAR_HISTORY']!=$previous['ARREAR_HISTORY']) echo '<br/><small class="text-muted">Waiting for verification: <strong>'.$previous['ARREAR_HISTORY'].'</strong></small>';
		echo '</div>';

		$warning= '<div id="fill_prev" class="alert alert-danger fade in" >Take care to update the <strong>above three columns</strong> every time you update.</div>';
		echo $warning;

		echo '</td>';

		echo '</table>';
		?>
		</table>
		<h5 class="text-primary">Semester wise data</h5>
		
		<?php
		$warning= '<div id="fill_prev" class="alert alert-warning fade in" ><a href="#" class="close" data-dismiss="alert">&times;</a>Disabled fields will be activated once you fill the data above it.</div>';
		$warning.= '<div id="fill_prev" class="alert alert-warning fade in" ><a href="#" class="close" data-dismiss="alert">&times;</a>SGPA for a semester should be entered after consulting your TnP Volunteer, if there is an arrear paper.<br/>Percentage entered should be included with the papers with arrears, if any.</div>';
		echo $warning;
		foreach ($pairs as $pair) {
			$temp=array("-percent","-CGPA");
			echo '<h6 class="text-muted">'.$this->academic_model->decode($pair).'</h6>';
			echo '<table class="table table-bordered">';
				if(isset($current[$ind])) $value=($current[$ind]);
			foreach ($temp as $temp_var) {
				$value="";
				echo '<tr>';
				$ind = $pair.$temp_var;
					if(isset($current[$ind])) $value=($current[$ind]);
				echo '<th>'.$this->academic_model->decode($ind).'</th>';
				$data_type=$this->academic_model->get_type_of_value($ind);
				echo '<td>';
				if($data_type=="percent")
					echo '<div class="form-group"><div class="input-group">   <input type="text" class="form-control input-sp pairs" name="'.$ind.'" id="'.$ind.'" data_type="'.$data_type.'" maxlength="5" value="'.$value.'">  <div class="input-group-addon">%</div> </div></div> ';
				else //For CGPA
					echo '<div class="form-group"><div class="input-group">  <div class="input-group-addon">SGPA</div> <input type="text" class="form-control input-sp pairs" name="'.$ind.'" id="'.$ind.'" data_type="'.$data_type.'" maxlength="5" value="'.$value.'"> </div></div> ';

				if(isset($previous))
				{
					if(isset($previous[$ind]) && $current[$ind]!=$previous[$ind]) echo '<small class="text-muted">Waiting for verification: <strong>'.$previous[$ind].'</strong></small>';
					if( $previous[$ind]==NULL && $current[$ind]!=NULL) echo '<small class="text-muted">Waiting for deletion.</small>';
				}
				
				echo '<div class="text-danger" id="error_'.$ind.'"></div>';
				echo '</td>';
				echo '</tr>';			
			}
			echo '</table>';
			
		}
		?>
		</table>

	<?php
	if($academic_lock==0)
		echo '<input type="submit" name="submit" class="submit_button btn btn-primary pull-right" value="Update">';
	else
		echo '<div id="fill_prev" class="alert alert-danger fade in" >Academic Updation Locked by admin.</div>';
	?>
	</form>
</div>

</div><!-- col classes -->
</div><!-- row class -->

</div><!-- container class -->
		<?php
		$individuals_list="";
		for($i=0; isset($individuals[$i]) ; $i++)
		{
			$individuals_list = $individuals_list.'"'.$individuals[$i].'"';
			if(isset($individuals[$i+1]))
				$individuals_list = $individuals_list.',';
		}
		$pairs_list="";
		for($i=0; isset($pairs[$i]) ; $i++)
		{
			$pairs_list = $pairs_list.'"'.$pairs[$i].'"';
			if(isset($pairs[$i+1]))
			$pairs_list = $pairs_list.',';
		}
		?>
<script type="text/javascript">
	$(document).ready(function(){

		arrear();
		var individuals =[<?php echo $individuals_list; ?>];
		var pairs=[<?php echo $pairs_list;?>];

		$(".pairs").each ( function() {
			if($(this).val().length<1)
				$(this).prop('disabled', true);
		});
		main_action("");
		//$(".submit_button").prop('disabled',true);
		$('.input-sp').keyup(function(){
				var val= $(this).val();
				var data_type = $(this).attr('data_type');
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
				$('#error_'+id).html(error_val);
				$(".submit_button").prop('disabled',true);
				main_action(error_val);
				$('#'+id).focus();
		});

		function main_action(error_val)
		{
			if(error_val=="")
			{
						$(".submit_button").prop('disabled',false);
						$(".pairs").prop('disabled', true);
						var i=1,res;
						if(check_filled("initial")==1)
						{
							$('#'+pairs[0]+'-percent').prop('disabled', false);
							$('#'+pairs[0]+'-CGPA').prop('disabled', false);
						}
						while( res=pairs[i] ) //NOT double equal
						{
							if( $('#'+pairs[i-1]+'-percent').val().length>0 && $('#'+pairs[i-1]+'-CGPA').val().length>0)
							{
								$('#'+pairs[i]+'-percent').prop('disabled', false);
								$('#'+pairs[i]+'-CGPA').prop('disabled', false);
							}
							else 
								break;
							i++;
						}
			}
		}
		$('#ARREAR_NO').keyup(function(){
			arrear();
		});

		function check_filled(type) // Only for 'initial'
		{
			var result=1;
			if(type=="initial")
			{
				individuals.forEach(function(entry) {
				   if($('#'+entry).val().length<1)
				   		result=0;
				});

			}
			
			return result;
		}

		function arrear()
		{

			var value= $("#ARREAR_NO").val();
			$("#arrear-sp").html(value);
		}
	});
</script>