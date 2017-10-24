<?php
function placer($name, $value, $to_print=NULL, $start_print=NULL)
{
	if(isset($_GET['search']))
	{
		if(isset($_GET[$name]))
		{
			if($to_print==NULL)
			{
				echo htmlspecialchars($_GET[$name]);
			}
			else if($_GET[$name] == $value)
				echo $to_print;
		}
	}
	else
	{
		if($start_print!=NULL)
			echo $start_print;
	}
}

?>
<div class="container">
<div class="row">
<div class="col-xs-11 col-md-8 col-md-offset-2">

<form method="GET" action="<?php echo base_url();?>admin/search">

		<input type="text" name="general" id="search_bar" placeholder="Name/Admission Number" autofocus value="<?php placer('general',''); ?>"><br/>
	
		<div class="row">
		<div class="col-xs-11 col-md-4 ">
		<br/>
			<label for="candidate" class="">
			<input type="checkbox" value="1" name="candidate" <?php placer('candidate','1','checked','checked'); ?>>
			Candidate</label>
			<label for="volunteer" class="">
			<input type="checkbox" value="1" name="volunteer" <?php placer('volunteer','1','checked','checked'); ?>>
			Volunteer</label>

		<hr><br/>
			<label for="BTECH" class="">
			<input type="checkbox" value="1" name="BTECH" <?php placer('BTECH','1','checked','checked'); ?>>
			BTECH</label>
			<label for="MTECH" class="">
			<input type="checkbox" value="1" name="MTECH" <?php placer('MTECH','1','checked','checked'); ?>>
			MTECH</label>
			<label for="MCA" class="">
			<input type="checkbox" value="1" name="MCA" <?php placer('MCA','1','checked','checked'); ?>>
			MCA</label>
		<hr><br/>
			<label for="male" class="">
			<input type="checkbox" value="1" name="male" <?php placer('male','1','checked','checked'); ?>>
			Male</label>
			<label for="female" class="">
			<input type="checkbox" value="1" name="female" <?php placer('female','1','checked','checked'); ?>>
			Female</label>
		</div><!-- col classes -->
		<div class="col-xs-11 col-md-4 ">
			  <br/><div class="form-group">
			    <label for="year">Year</label>
			    <input type="number" class="form-control" name="year" placeholder="Passout year" value="<?php placer('year',''); ?>">
			  </div>
			  <div class="form-group">
			    <label for="division">Division</label>
			    <select class="form-control" name="division">
			      <option value="">All</option>
				  <option <?php placer('division','A','selected'); ?>>A</option>
				  <option <?php placer('division','B','selected'); ?>>B</option>
				  <option <?php placer('division','C','selected'); ?>>C</option>
				  <option <?php placer('division','D','selected'); ?>>D</option>
				  <option <?php placer('division','E','selected'); ?>>E</option>
				</select>
			  </div>
			  <div class="form-group">
			    <label for="branch">Branch</label>
			   <br/>
			      <?php
			      $val= $this->class_convertion_model->list_short_names();
			      foreach ($val as $branch) {
			      	echo '<input type="checkbox" value="1" name="'.$branch.'" ';
			      	echo placer($branch,'1','checked');
			      	echo ' > ' .$this->class_convertion_model->convert($branch).'<br/>';
			      }
			      ?>

			  </div>
		</div><!-- col classes -->
		<div class="col-xs-11 col-md-4 ">
			<h6 class="text-muted">ACADEMIC FILTER</h6>
			<label for="arrear_no">Maximum Arrears</label>
			<input type="text" class="form-control" name="arrear_no" placeholder="eg: 1,3" value="<?php placer('arrear_no',''); ?>">

			<br/><label for="ARREAR_HISTORY">Arrear History</label>
			<select class="form-control" name="ARREAR_HISTORY">
				<option value="" <?php placer('ARREAR_HISTORY','','selected');?> >Doesn't matter</option>
				<option value="yes" <?php placer('ARREAR_HISTORY','yes','selected');?>>Yes</option>
				<option value="no" <?php placer('ARREAR_HISTORY','no','selected');?>>No</option>
			</select>

			<br/><label for="aggr-percent">Minimum Percent</label>
			<input type="text" class="form-control" name="aggr-percent" placeholder="eg: 80,70" value="<?php placer('aggr-percent',''); ?>">


			<label for="aggr-CGPA">Minimum CGPA</label>
			<input type="text" class="form-control" name="aggr-CGPA" placeholder="eg: 7.5,8" value="<?php placer('aggr-CGPA',''); ?>">

			<label for="placement_details" class="">
			<input type="checkbox" value="1" name="placement_details" <?php placer('placement_details','1','checked','unchecked'); ?>>
			Placement Details</label>

		</div><!-- col classes -->

		</div><!-- row class -->

		<div class="pull-right btn-group">
		<a href="<?php echo base_url(); ?>admin/search" class="btn btn-default">Reset</a>
		<input type="submit" name="search" id="search_button" class="btn btn-primary" value="Search">
		</div>
		<?php
		echo '<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Add columns</button>';
		echo '<div class="collapse" id="collapseExample">';
			extra_attributes("print_form");
		?>
</form>

</div><!-- col classes -->
</div><!-- row class -->

<?php
if(isset($val_all))
{
?>
	<div class="row">
	<div class="col-xs-11 col-md-12 col-md-offset-0">
	<hr>
	<div class="form-academic">
	<?php
	if(mysqli_num_rows($val_all)<1)
	{
		echo '<h2 class="text-muted">NO RESULTS TO SHOW</h2>';
	}
	else
	{
		echo '<form method="POST" action="'.base_url().'admin/get_excel" target="_blank">';
		echo '<input type="hidden" name="value" id="excel_hidden" value="">';
		echo '<input type="submit" name="submit" value="Get as excel" id="excel_submit" disabled class="btn btn-default">';
		echo '</form>';
		$i=1;
		//echo '<div class="table-responsive">';
		echo '<div id="excel_inside" class="table-responsive">';
			echo '<table class="table table-hover">';
			echo '<tr> <th>SI No.</th> <th>Name</th> <th>Type</th> <th>Admission Number</th> <th>Course</th> <th>Passout Year</th> <th>Branch</th> <th>Batch</th> <th>Arrears</th> <th>Percent</th> <th>CGPA</th>';
			print_heading($val_all_2);
			echo ' </tr>';
			while($row=mysqli_fetch_array($val_all))
			{
				echo '<tr>';
				echo '<td>'.$i++.'</td>';
					
					if($row['verified']=="0")
						echo '<td>'.$row['name']. '<br/><strong class="text-danger">UNVERIFIED</strong>';
					else if($row['type']=="candidate")
						echo '<td><a href="'.base_url().'admin/user/'.$row['id'].'">'.$row['name'].'</a>';
					else
						echo '<td>'.$row['name'].'</a>';
					echo '</td>';
					if($row['type']=="volunteer") $qwert=' class="text-warning"'; else $qwert="";
				echo '<td><strong '.$qwert.'>'.$row['type'].'</strong></td>';
				echo '<td>'.$row['admission_no'].'</td>';
						$value=explode('-', $row['class']);
						echo '<td>'.$value[0].'</td>';
						echo '<td>'.$value[1].'</td>';
						echo '<td>'.$this->class_convertion_model->convert( $value[2] ).'</td>';
						echo '<td>'.$value[3].'</td>';
					echo '<td>'.$row['ARREAR_NO']; 
					if($row['ARREAR_NO']!=NULL) echo ' upto ';
					echo $row['ARREAR_LAST'].'</td>';
				echo '<td>'.$row['aggr-percent'].'</td>';
				echo '<td>'.$row['aggr-CGPA'].'</td>';
				print_inside($row,$val_all_2);
				echo '</tr>';
			}
			echo '</table>';
		echo '</div>';
		//echo '</div>';
	}
	?>
	
	</div>
	</div><!-- col classes -->
	</div><!-- row class -->
<?php
} //isset($val_all) ending
?>
</div><!-- container class -->

<?php
function extra_attributes($type=NULL)
{
	if($type=="print_form")
	{
		
		echo '<table class="table">';
			echo '<tr>';
			echo '<td>';
			foreach (get_vars() as $value) {
				if($value=="tenth")
				{
					echo "</td> <td>";
				}
				echo '<input type="checkbox" name="'.$value.'" value="1"> '.$value.' <br/>';
			}
			echo '<input type="submit" name="search" id="search_button" class="btn btn-default pull-right" value="Add Columns">';
			echo '</td>';

			echo '</tr>';

		echo '</table>'; 
		
	}
}
function get_vars()
{
	$val=array(
		'ARREAR_HISTORY','email','gender','mobno','addr_1','addr_2','addr_3','pincode','res_no','dob','religion','father_name','father_occupation','mother_name','mother_occupation','admission_quota',
		'tenth','twelth','entrance_rank','diploma','S12-percent','S1-percent','S2-percent','S3-percent','S4-percent','S5-percent','S6-percent','S7-percent','S8-percent',
		'S12-CGPA','S1-CGPA','S2-CGPA','S3-CGPA','S4-CGPA','S5-CGPA','S6-CGPA','S7-CGPA','S8-percent','UGAGGR-percent','UGAGGR-CGPA'
		);
	return $val;
}
function print_heading($val_all_2)
{
	foreach (get_vars() as $value) {
		if(!empty($_GET[$value]))
			echo '<th>'.$value.'</th>';
	}
	if(isset($val_all_2))
	{
		echo '<th>Placement Count</th>';
		for($i=1; $i<= $val_all_2['max_count'] ; $i++ )
			echo '<th>Placement '.$i.'</th>';
		//echo '<th>Placement Companies</th>';
	}
}
function print_inside($row,$val_all_2)
{
	foreach (get_vars() as $value) {
		if(!empty($_GET[$value]))
		{
			if($value=='dob' && isset($row['dob']) )
			{
				$dob = explode('-', $row['dob']); $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
				echo '<td>'.$dob.'</td>';
			}
			else 
				echo '<td>'.$row[$value].'</td>';
		}
	}
	if(isset($val_all_2))
	{
		if(isset( $val_all_2['placement_count'][$row['id']] ))
		{
			echo '<td>'.$val_all_2['placement_count'][$row['id']].'</td>';
			$splitted_companies= explode('~', $val_all_2['placement_list'][$row['id']] );
			foreach ($splitted_companies as $company) {
				echo '<td>'.$company.'</td>';
			}
			//echo '<td>'.$val_all_2['placement_list'][$row['id']].'</td>';
		}
		else
		{
			echo '<td>0</td>';
			echo '<td></td>';
		}
	}
}


?>