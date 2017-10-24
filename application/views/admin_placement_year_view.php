<div class="container">
	<div class="row">
		<div class="col-xs-11 col-md-10 col-md-offset-1">
			<div class="form-academic">

<?php
		$val=$this->db->simple_query('SELECT * FROM placement_main WHERE year='.$year.' ORDER BY status DESC');

		echo '<h3 class="text-primary">PLACEMENTS <small>for students graduating in '.$year.'</small></h3><br/><br/>';
		echo '<div class="table-responsive">';
		echo '<table class="table table-hover">';
		echo '<tr> <th>Name</th> <th>Type</th> <th>Levels</th> <th>Courses</th> <th>Status</th> <th></th> </tr>';
		while($row= mysqli_fetch_array($val))
		{
			echo '<tr>';
			echo '<td>'.$row['placement_name'].'</td>';
			echo '<td>'.$row['type'].'</td>';
			echo '<td>'.$row['levels'].'</td>';
				echo '<td>';
				if($row['BTECH']=="1") echo "BTECH "; if($row['MTECH']=="1") echo "MTECH "; if($row['MCA']==1) echo "MCA ";
				echo '</td>';
			if($row['status']=="1")
				echo '<td><span class="text-success">Open</span></td>';
			else if($row['status']=="0")
				echo '<td><span class="text-warning">Closed</span></td>';
			echo '<td> <a class="btn btn-default" href="'.base_url().'admin/placement/'.$row['placement_id'].'/'.'">More</a> </td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</div>';
?>

			</div>
		</div>
	</div>
</div>