<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-1">

<?php
echo '<div class="form-academic">';
	echo '<h3 class="text-primary">Academic data update requests</h3><br/>';
	if($result[0]=="error")
	{
		echo '<a href="'.base_url().'volunteer/academic_verify" class="btn btn-default">Back</a><br/>';
		echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>'.$result[1].'</div>';
	}
	else if($result[0]=="success-next")
	{
		echo '<a href="'.base_url().'volunteer/academic_verify" class="btn btn-default">Back</a><br/><br/>';
		$existing= $result[1];
		$new= $result[2];
		$this->load->model('academic_model');
		$individuals= $this->academic_model->get_individuals($existing['course'],$existing['btech_type']);
		$pairs= $this->academic_model->get_pairs($existing['course'],$existing['btech_type']);
		array_push($individuals, 'ARREAR_LAST');
		array_push($individuals, 'ARREAR_HISTORY');

		if($existing['btech_type_check']=="0" && $existing['course']=='BTECH')
		{
			echo '<form method="POST" action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">';
			echo '<div id="check_btech_type">';
				echo '<table class="table">';
				echo '<tr>';
				echo '<td><strong>'.$existing['name'].'</strong></td>';
				echo '<td>'.$existing['admission_no'].'</td>';
				echo '<td>'.$existing['gender'].'</td>';
				echo '</tr>';
				echo '</table>';
			echo '<h5 class="text-primary">IS THE PERSON</h5>';
			echo '<blockquote>';
			if($existing['btech_type']=="lateral")
				echo 'A lateral entry student';
			else if($existing['btech_type']=="normal")
				echo 'NOT a lateral entry student enrolled in MG university';
			else if($existing['btech_type']=="normal-ktu")
				echo 'NOT a lateral entry student enrolled in Kerala Technical University';
			echo '</blockquote>';
				echo '<div class="btn-group">';
				echo '<input type="submit" name="verifybtech_submit" class="btn btn-primary" value="Yes"> ';
				echo '<input type="submit" name="rejectbtech_submit" class="btn btn-danger" value="No">';
				echo '</div>';
			echo '</div>';
			echo '</form>';
		}
		else
		{
				echo '<form method="POST" action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">';
				echo '<table class="table">';
				echo '<tr>';
				echo '<td><strong>'.$existing['name'].'</strong></td>';
				echo '<td>'.$existing['admission_no'].'</td>';
				echo '<td>'.$existing['gender'].'</td>';
				echo '</tr>';
				echo '</table>';

				echo '<h3 class="text-primary">ACADEMIC DETAILS</h3><br/>';
				echo '<div><span class="text-muted">EXAMPLES<br/> 89</span>  Existing value<br/> <span class="text-danger">[ 89 ]</span> New value</div><br/>';

				echo '<table class="table table-hover">';
				foreach ($individuals as $ind) {
						if(isset($existing[$ind]) || isset($new[$ind]))
						{
							echo '<tr>';
							echo '<th>'.$this->academic_model->decode($ind).'</th>';
							echo '<td><p>';
							if(isset($existing[$ind]))
								echo '<span class="text-muted">'.$existing[$ind].'</span>';
							if(isset($new[$ind]) && $existing[$ind]!=$new[$ind])
								echo '<span class="text-danger"> [ '.$new[$ind].' ]</span>';
							if( $new[$ind]==NULL && $existing[$ind]!=NULL)
								echo '<span class="text-danger"> [ DELETE ]</span>';
							echo '</td></p>';
							echo '</tr>';
						}
				}
				echo '<tr><td></td><td></td></tr>'; //divider
				foreach ($pairs as $pair) {
					$temp=array("-percent","-CGPA");
					{
						foreach($temp as $temp_val)
						{
							$ind=$pair.$temp_val;
							if(isset($existing[$ind]) || isset($new[$ind]))
							{
								echo '<tr>';
								echo '<th>'.$this->academic_model->decode($ind).'</th>';
								echo '<td><p>';
								if(isset($existing[$ind]))
									echo '<span class="text-muted">'.$existing[$ind].'</span>';
								if(isset($new[$ind]) && $existing[$ind]!=$new[$ind])
									echo '<span class="text-danger"> [New Entry: '.$new[$ind].' ]</span>';
								if( $new[$ind]==NULL && $existing[$ind]!=NULL)
									echo '<span class="text-danger"> [ DELETE ]</span>';
								echo '</td></p>';
								echo '</tr>';
							}	
						}
					}
				}
				echo '</table>';

//EXTRA for manual work
				//echo '<p>Automatic aggregate CGPA analysis will be added soon. As of now, please fill in manually the aggregate CGPA. Aggregate percent will be found automatically.</p>';
echo '<br/><div class="form-group">
	  	<label for="aggr_cgpa_1">New Aggregate Percent *</label> ';
	//echo   	'<p>Ignore this field for automatic aggregate percent finding (For non-supplimentary cases)</p>';
	 echo ' <div class="input-group">  
	  			<input type="text" class="form-control input-sp initial" id="56783" name="aggr_percent_1"  data_type="percent" maxlength="5" >  
	  			<div class="input-group-addon">%</div> 
	  </div></div>';
echo '<div class="text-danger" id="error_56783"></div>';

echo '<br/><div class="form-group">
	  	<label for="aggr_cgpa_1">New Aggregate CGPA *</label> 
	  <div class="input-group">  
	  			<input type="text" class="form-control input-sp initial" id="5678" name="aggr_cgpa_1"  data_type="CGPA" maxlength="5" >  
	  			<div class="input-group-addon"></div> 
	  </div></div>';

$resss=$this->db->simple_query('SELECT `aggr-CGPA` FROM user_table WHERE id="'.$user_id.'"');
$rowww=mysqli_fetch_array($resss);
echo 'Existing aggregate CGPA: '.$rowww['aggr-CGPA'];

echo '<div class="text-danger" id="error_5678"></div>';

				echo '<div class="btn-group pull-right">';
					echo '<input type="hidden" value="'.$new['id'].'" name="id">';
					echo '<input type="submit" name="verify" value="Verify" class="btn btn-primary">';
					echo '<input type="submit" name="reject" value="Reject" class="btn btn-danger">';
				echo '</div>';


				echo '</form>';
		}
	}
	else if($list[0]>0)
	{
		
			echo '<table class="table table-hover">';
			echo '<tr> <th>Name</th> <th>Admission Number</th> <th>Gender</th> <th>Action</th> </tr>';
				while($row=mysqli_fetch_array($list[1]) )
				{
					echo '<tr>';
					echo '<td><strong>'.$row['name'].'</strong></td>';
					echo '<td>'.$row['admission_no'].'</td>';
					echo '<td>'.$row['gender'].'</td>';
					echo '<td><a href="'.base_url().'volunteer/academic_verify/'.$row['id'].'"><input type="submit" name="submit" class="btn btn-default" value="Go"></a></td>';
					echo '</tr>';
				}
			echo '</table>';
	}
	else
	{
		echo '<p class="bg-primary padding">All academic details of your class is verified. <a href="'.base_url().'volunteer" style="color:#FFF;">Go to your console.</a></p>';
	}

echo '</div>';
?>

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->



<script type="text/javascript">
	$(document).ready(function(){

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
		});

		

		
	});
</script>