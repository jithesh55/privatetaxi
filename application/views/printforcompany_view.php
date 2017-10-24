<div class="container">
<div class="row">
<div class="col-xs-11 col-md-11 col-md-offset-0">
	<div class="no-print" style="background:#e5e5e5; border-radius:5px; padding:10px;">
		<form method="GET" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
		<label>QUALIFIED FOR LEVEL (for filtering)</label><input type="number" placeholder="Type level and press enter" class="form-control" style="width:250px;" name="level" value="<?php if(isset($_GET['level'])) echo $_GET['level']; ?>">
		<div class="text-muted"> Enter "-2" to get details of winners.</div>
		<br/>
		</form>
	</div>
	<hr>
	<a href="javascript:window.print()" class="pull-right no-print">PRINT</a>

	<?php
	echo '<form method="GET">';
		echo '<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Add columns</button>';
		echo '<div class="collapse" id="collapseExample">';
		extra_attributes("print_form");
		echo '</div>';
	echo '</form>';
	?>
<?php
			$val= $this->db->simple_query('SELECT * FROM placement_main WHERE placement_id="'.$placement_id.'"');
			if(mysqli_num_rows($val)<1)
			{
				echo '<h2>INVALID PLACEMENT ID</h2>';
				exit();
			}
			$row=mysqli_fetch_array($val);
			echo '<table class="table table-striped">';
			echo '<tr> <th>Placement ID</th> <td>'.$row['placement_id'].'</td> </tr>';
			echo '<tr> <th>Placement Name</th> <td>'.$row['placement_name'].'</td> </tr>';
			echo '<tr> <th>About</th> <td>'.$row['about'].'</td> </tr>';
			echo '<tr> <th>Courses appearing</th>';
				if($row['BTECH']=="1")
					echo '<td> BTECH </td>';
				if($row['MTECH']=="1")
					echo '<td> MTECH </td>';
				if($row['MCA']=="1")
					echo '<td> MCA </td>';
			echo '</tr>';
			echo '</table>';

			$i=1;
			$courses=array('BTECH','MTECH','MCA');
				foreach ($courses as $course) {
					$val_conditions=$this->db->simple_query('SELECT * FROM placement_conditions WHERE placement_id="'.$placement_id.'" AND `for`="'.$course.'"');
					if($row_conditions=mysqli_fetch_array($val_conditions))
					{
						echo '<h6> <span class="text-primary">CONDITIONS FOR '.$row_conditions['for'].'</span>';
						echo '<table class="table table-bordered">';
						echo '<tr> <th>Academic data filled upto</th> <td>'.$row_conditions['filled_upto'].'</td><tr>';
						if($row_conditions['max_arrear']=="2002")
							$arr="No Restriction";
						else
							$arr=$row_conditions['max_arrear'];
						echo '<tr> <th>Maximum arrears</th> <td>'.$arr.'</td></tr>';
						if($row_conditions['min_percent']>0) echo '<tr> <th>Minimum Percentage</th> <td>'.$row_conditions['min_percent'].'</td></tr>';
						if($row_conditions['min_CGPA']>0) echo '<tr> <th>Minimum CGPA</th> <td>'.$row_conditions['min_CGPA'].'</td></tr>';
						if(!empty($row_conditions['branches']))
						{
							echo '<tr> <th>Branches</th><td>'; 
							$branchesList= explode(" ", $row_conditions['branches']);
							foreach ($branchesList as $branchSingle) {
								if( !empty($branchSingle) )
								{
									echo '<li>'.$this->class_convertion_model->convert($branchSingle).'</li>';
								}
							}
							echo ' </td></tr>';
						}
						echo '<tr> <th>Arrear history</th>'; if($row_conditions['arrear_history_problem']==0)  echo '<td>Allowed</td>'; else echo '<td>Not allowed</td>';
						echo '</table></h6>';
					}
				}

		echo '<hr><h4 class="text-primary">USERS LIST</h4>';
		$query='SELECT a.*,b.status AS status FROM user_table a, allocate_placement b WHERE a.id=b.user_id AND b.placement_id="'.$placement_id.'" AND b.status>=-2 AND b.status<=50 ORDER BY b.status DESC,a.course, a.branch, a.division,a.class, a.name';
		$val=$this->db->simple_query($query);

		echo '<table class="table table-bordered">';
		echo '<tr> <th></th> <th>Name</th> <th>Admission Number</th> <th>Status</th> <th>Class</th> <th>Arrears</th> <th>Aggregate Percent</th> <th>Aggregate CGPA</th> '; 
		print_heading();
		echo '</tr>';
		while($row=mysqli_fetch_array($val))
		{
			if(!empty($_GET['level']))
			{
				if($row['status']==$_GET['level'])
				{
					if($row['status']=="-2")
					{
						echo '<tr> <td>'.$i++.'</td> <td>'.$row['name'].'</td> <td>'.$row['admission_no'].'</td> <td><strong class="text-success">Placed</strong></td> <td style="max-width:200px;">'.$this->class_convertion_model->decode_class($row['class']).'</td> <td>'.$row['ARREAR_NO'].' </td> <td>'.$row['aggr-percent'].'</td> <td>'.$row['aggr-CGPA'].'</td>';
						print_inside($row);
						echo '</tr>';
					}
					else
					{
						echo '<tr> <td>'.$i++.'</td> <td>'.$row['name'].'</td> <td>'.$row['admission_no'].'</td> <td><strong>Qualified for Level '.$row['status'].'</strong></td> <td style="max-width:200px;">'.$this->class_convertion_model->decode_class($row['class']).'</td> <td>'.$row['ARREAR_NO'].' </td> <td>'.$row['aggr-percent'].'</td> <td>'.$row['aggr-CGPA'].'</td>';
						print_inside($row);
						echo '</tr>';
					}
				}
			}
			else if($row['status']!="-2")
			{
				echo '<tr> <td>'.$i++.'</td> <td>'.$row['name'].'</td> <td>'.$row['admission_no'].'</td> <td><strong>Qualified for Level '.$row['status'].'</strong></td> <td style="max-width:200px;">'.$this->class_convertion_model->decode_class($row['class']).'</td> <td>'.$row['ARREAR_NO'].' </td> <td>'.$row['aggr-percent'].'</td> <td>'.$row['aggr-CGPA'].'</td> ';
				print_inside($row);
				echo '</tr>';
			}
		}

		if(empty($_GET['level']))
			mysqli_data_seek($val,0);
		while($row=mysqli_fetch_array($val))
		{
			if($row['status']=="-2" && empty($_GET['level']))
			{
				echo '<tr> <td>'.$i++.'</td> <td>'.$row['name'].'</td> <td>'.$row['admission_no'].'</td> <td><strong class="text-success">Already Placed</strong></td> <td style="max-width:200px;">'.$this->class_convertion_model->decode_class($row['class']).'</td> <td>'.$row['ARREAR_NO'].' </td> <td>'.$row['aggr-percent'].'</td> <td>'.$row['aggr-CGPA'].'</td>';
				print_inside($row);
				echo '</tr>';
			}
		}
		echo '</table>';
?>

</div>
</div>
</div>

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
function print_heading()
{
	foreach (get_vars() as $value) {
		if(!empty($_GET[$value]))
			echo '<th>'.$value.'</th>';
	}
}
function print_inside($row)
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
}
?>