<div class="container">
<div class="row">
<div class="col-xs-11 col-md-10 col-md-offset-1">

		<form method="GET" action="<?php echo base_url();?>volunteer/search">
		<br/><input type="text" name="general" id="search_bar" placeholder="Search users (Name/Admission Number)" value="<?php if(isset($_GET['general'])) echo htmlspecialchars($_GET['general']); ?>" autofocus><br/>
		<div class="pull-right">
		<input type="submit" name="search" id="search_button" class="btn btn-default" value="Search">
		</div>
		</form>

<?php
if(isset($_GET['general']))
{
	$general=htmlspecialchars($_GET['general']);
	$query='SELECT id,name,admission_no,verified,class,ARREAR_NO,ARREAR_LAST,ARREAR_HISTORY,`aggr-percent`,`aggr-CGPA` FROM user_table WHERE ( name LIKE "%'.$general.'%" OR admission_no LIKE "%'.$general.'%" ) AND type="candidate" AND class="'.$class.'" ORDER by name';

	$val_all=$this->db->simple_query($query);

	if(mysqli_num_rows($val_all)<1)
	{
		echo '<h2 class="text-muted">NO RESULTS TO SHOW</h2>';
	}
	else
	{
		echo '<br/><br/><hr><h3 class="text-muted">RESULTS FROM YOUR CLASS</h3>';
		$i=1;
		//echo '<div class="table-responsive">';
			echo '<table class="table table-hover">';
			echo '<tr> <th>SI No.</th> <th>Name</th> <th>Admission Number</th> <th>Class</th> <th>Arrears</th> <th>Arrear History</th> <th>Percent</th> <th>CGPA</th> <th></th> </tr>';
			while($row=mysqli_fetch_array($val_all))
			{
				echo '<tr>';
				echo '<td>'.$i++.'</td>';
					
					if($row['verified']=="0")
						echo '<td>'.$row['name']. '<br/><strong class="text-danger">UNVERIFIED</strong>';
					else
						echo '<td><a href="'.base_url().'volunteer/user/'.$row['id'].'">'.$row['name'].'</a>';
					echo '</td>';
				echo '<td>'.$row['admission_no'].'</td>';
				echo '<td>'.$row['class'].'</td>';
					echo '<td>'.$row['ARREAR_NO']; 
					if($row['ARREAR_NO']!=NULL) echo ' upto ';
					echo $row['ARREAR_LAST'].'</td>';
				echo '<td>'.$row['ARREAR_HISTORY'].'</td>';
				echo '<td>'.$row['aggr-percent'].'</td>';
				echo '<td>'.$row['aggr-CGPA'].'</td>';
				echo '</tr>';
			}
			echo '</table>';
		//echo '</div>';
	}
}
	?>

	</div><!-- col classes -->
	</div><!-- row class -->
	</div><!-- container class -->