<div class="container">
<div class="row">
<div class="col-xs-11 col-md-8 col-md-offset-2">

<?php
if(isset($result))
{

	if($result[0]=="error")
	{
		echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>';
		echo $result[1];
		echo '</div>';
	}
	else if($result[0]=="success")
	{
		echo '<div class="alert alert-success fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>';
		echo $result[1];
		echo '</div>';
	}
}
?>

<div class="form-academic">

	<?php
	if($placement_id==NULL)
	{
		echo '<h4 class="text-primary">YOUR PLACEMENTS</h4><br/>';
		$val= $this->db->simple_query('SELECT a.*, b.status FROM placement_main a, allocate_placement b WHERE b.user_id="'.$this->session->user_id.'" AND a.placement_id=b.placement_id ORDER BY b.status ASC');
		echo '<div class="table">';
		echo '<table class="table table-bordered">';
		echo '<tr> <th>Name</th> <th>Your status</th> <th>Type</th> <th></th> </tr>';
			while ($row=mysqli_fetch_array($val)) {
				$status=$row['status'];
				echo '<tr>';
				echo '<td>'.$row['placement_name'].'</td>';
					echo '<td>';  
					if($status=="-2")
						echo '<strong class="text-success">Placement Won</strong>';
					else if($status=="3003")
						echo '<strong class="text-warning">Rejected</strong><br/><small>by admin/volunteer.</small>';
					else if($status=="2502")
						echo '<strong class="text-warning">Cancelled</strong><br/><small>Reached placement threshold.</small>';
					else
					{
						echo '<strong>Qualified to appear for level '.$status.'</strong>';
						echo '<br/><small>out of '.$row['levels'].' Levels</small>';
					}
					echo '</td>';
				echo '<td>';
					if($row['type']=='normal')
						echo 'IT Company';
					else
						echo 'Dream/Core company';
				echo '</td>';
				echo '<td><a href="'.base_url().'candidate/placement/'.$row['placement_id'].'">More</a></td>';
				echo '</tr>';
			}

		echo '</table>';
		echo '</div><br/>';

		echo '<hr>';
		echo '<h4 class="text-muted">ACTIVE PLACEMENTS FOR YOUR CLASS</h4><br/>';
		$val= $this->db->simple_query('SELECT * FROM placement_main WHERE status="1" AND '.$course.'="1"');
		$valConditions=$this->db->simple_query('SELECT placement_id, branches FROM placement_conditions WHERE `for`="'.$course.'"');
		$idBranch=array();
		while($rowTemp=mysqli_fetch_array($valConditions))
			$idBranch[$rowTemp['placement_id']] = $rowTemp['branches'];
		echo '<div class="table">';
		echo '<table class="table table-hover">';
		while ($row=mysqli_fetch_array($val)) {
				if( !empty( $idBranch[$row['placement_id']] ) )
				{
					$resultBranches=explode(" ", $idBranch[$row['placement_id']] );
					$init=0;
					foreach ($resultBranches as $key) {
						if(!empty($key))
						{
							if($key==$branch)
								$init++;
						}
					}
					if($init==0)
						continue;
				}
				echo '<tr>';
				echo '<td>'.$row['placement_name'].'</td>';
				echo '<td>'.$row['levels'].'</td>';
				echo '<td>';
					if($row['type']=='normal')
						echo 'IT Company';
					else
						echo 'Dream/Core company';
				echo '</td>';
				echo '<td><a href="'.base_url().'candidate/placement/'.$row['placement_id'].'">More...</a></td>';
				echo '</tr>';
			}

		echo '</table>';
		echo '</div>';

	}
	else
	{
		$val= $this->db->simple_query('SELECT * FROM placement_main WHERE placement_id="'.$placement_id.'"');
		$row=mysqli_fetch_array($val);
		$placement_status=1;
		if($row['status']=="0")
		{
			echo '<div class="alert alert-warning fade in">Placement closed. No further requests accepted.</div>';
			$placement_status=0;
		} 

		if(mysqli_num_rows($val)==0)
			echo '<h4 class="text-warning">PLACEMENT NOT FOUND OR THIS PLACEMENT IS NOT FOR YOU</h4><br/>';
		else
		{
			echo '<h3 class="text-primary">PLACEMENT <small>'.$row['placement_name'].'</small></h3><br/>';
			echo $row['about'].'<br><br/>';
			echo '<div class="table">';
			echo '<table class="table table-hover">';
					echo '<tr><th>Placement Name</th> <td>'.$row['placement_name'].'</td> </tr>';
					echo '<tr><th>Total Number of levels</th> <td>'.$row['levels'].'</td> </tr>';
					echo '<tr><th>Company Type</th> <td>';
						if($row['type']=='normal')
							echo 'IT Company';
						else
							echo 'Dream/Core company';
					echo '</td> </tr>';
			echo '</table>';
			echo '</div><br/>';
			$levels=$row['levels'];

			$val_conditions=$this->db->simple_query('SELECT * FROM placement_conditions WHERE placement_id="'.$placement_id.'" AND `for`="'.$course.'"');
				if($row_conditions=mysqli_fetch_array($val_conditions))
				{
					echo '<h6> <span class="text-primary">CONDITIONS FOR '.$row_conditions['for'].'</span>';
					echo '<table class="table table-hover">';
					echo '<tr> <th>Academic data filled upto</th> <td>'.$row_conditions['filled_upto'].'</td><tr>';
					if($row_conditions['max_arrear']=="2002")
						$arr="No Restriction";
					else
						$arr=$row_conditions['max_arrear'];
					echo '<tr> <th>Maximum arrears</th> <td>'.$arr.'</td>';
					if($row_conditions['min_percent']>0) echo '<tr> <th>Minimum Percentage</th> <td>'.$row_conditions['min_percent'].'</td>';
					if($row_conditions['min_CGPA']>0) echo '<tr> <th>Minimum CGPA</th> <td>'.$row_conditions['min_CGPA'].'</td>';
					echo '<tr> <th>Arrear history</th>'; if($row_conditions['arrear_history_problem']==0)  echo '<td>Allowed</td>'; else echo '<td>Not allowed</td>';
					echo '</table></h6>';
				}
				

			if( $res[0]=="success" && $placement_status!=0)
			{

				echo '- Once applied, you should not be absent for the placement.<br/>';
				echo '- Update your academic data to the latest and get it verified before applying.';
				echo '<br/><br/><input type="checkbox" id="read_all"> I\'ve read all points carefully.<br/><br/>';

				echo '<form method="POST" action="'.'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">';
				echo '<input type="submit" name="apply" class="btn btn-primary" value="Apply" id="submit">';
				echo '</form>';
			}
			else
			{	
				if(isset($res[2]))
				{
					$val= $this->db->simple_query('SELECT status FROM allocate_placement WHERE user_id="'.$this->session->user_id.'" AND placement_id="'.$placement_id.'"');
					$row_sta=mysqli_fetch_array($val);
					if($res[2]=="0")
						echo '<div class="alert alert-success fade in"> You have already registered for this placement.<br/><strong>You are qualified to appear for Level '.$row_sta['status'].'</strong></div>';
					switch($res[2])
					{
						case -2: echo '<div class="alert alert-success fade in"> You have already won this placement</div>'; break;
						case 2502: echo '<div class="alert alert-warning fade in">You request for this placement have been cancelled since you have reached the threshold of you placements.</div>'; break;
						case 3003: echo '<div class="alert alert-danger fade in">Application have been rejected by admin.</div>'; break;
						
					}
				}
				else
				{
					echo '<div class="alert alert-danger fade in">'.$res[1].'</div>';
				}
			}
			$val_t=$this->db->simple_query('SELECT selection_type from allocate_placement WHERE placement_id="'.$placement_id.'" AND user_id="'.$this->session->user_id.'"');
			//echo 'SELECT type from allocate_placement WHERE placement_id="'.$placement_id.'" AND user_id="'.$this->session->user_id.'"';
			$row_t=mysqli_fetch_array($val_t);
			if($row_t['selection_type']=='admin')
				echo '<div class="alert alert-success fade in">Your application is a special insertion by the admin.</div>';
			

		}
	}

	?>
</div>


</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->

<script type="text/javascript">
	$(document).ready(function(){

	$("#submit").prop('disabled',true);
	$('#read_all').change(function(){
		if($(this).prop('checked') == true)
			$("#submit").prop('disabled',false);
		else
			$("#submit").prop('disabled',true);
	});

	});
</script>