
<div class="container">
<div class="row">
<div class="col-xs-11 col-md-10 col-md-offset-1">


	<div class="form-academic">
	<?php
		$val= $this->db->simple_query('SELECT * FROM placement_main WHERE placement_id="'.$placement_id.'"');
		$row=mysqli_fetch_array($val);

		echo '<div class="btn-group pull-right">';
		echo '</div>';

		echo '<h3 class="text-primary">PLACEMENT <small>'.$row['placement_name'].'</small></h3><br/><br/>';
		echo '<div class="table-responsive">';
		echo '<table class="table table-hover">';
			echo '<tr> <th>Placement Name</th> <td>'.$row['placement_name'].'</td></tr>';
			echo '<tr> <th>About</th> <td>'.$row['about'].'</td></tr>';
			echo '<tr> <th>Type</th> <td>'.$row['type'];
				if($row['type']=='special')
					echo ' <span class="text-primary">| Dream/Core company<span>';
				echo '</td></tr>';
			echo '<tr> <th>Levels</th> <td>'.$row['levels'].'</td></tr>';
			echo '<tr> <th>Status</th>';
				if($row['status']=="1")
						echo '<th><span class="text-success">Open</span></th>';
				else if($row['status']=="0")
						echo '<th><span class="text-warning">Closed</span></th>';
			echo '</tr>';
					
		echo '</table>';
		echo '</div>';
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
						echo '<tr> <th>Maximum arrears</th> <td>'.$arr.'</td>';
						if($row_conditions['min_percent']>0) echo '<tr> <th>Minimum Percentage</th> <td>'.$row_conditions['min_percent'].'</td>';
						if($row_conditions['min_CGPA']>0) echo '<tr> <th>Minimum CGPA</th> <td>'.$row_conditions['min_CGPA'].'</td>';
						echo '<tr> <th>Arrear history</th>'; if($row_conditions['arrear_history_problem']==0)  echo '<td>Allowed</td>'; else echo '<td>Not allowed</td>';
						echo '</table></h6>';
					}
				}
		echo '</div>'; //form-academic

		echo '<div class="form-academic" style="margin-top:10px;">';
		$val_t=$this->db->simple_query('SELECT class FROM user_table WHERE id="'.$this->session->user_id.'" AND type="volunteer"');
		$row_t=mysqli_fetch_array($val_t);
		$val_stu= $this->db->simple_query('SELECT a.name, a.class, a.admission_no,a.ARREAR_NO, a.`aggr-percent`,a.`aggr-CGPA`, a.id, b.status, b.selection_type FROM user_table a, allocate_placement b WHERE a.id=b.user_id AND b.placement_id="'.$placement_id.'" AND class="'.$row_t['class'].'" ORDER BY a.course, a.branch, a.division,a.class');
		
		echo '<table class="table table-hover">';
		mysqli_data_seek($val_stu,0);
		echo '<tr> <th>SI No.</th> <th>Name</th> <th>Status</th> <th>Admission No.</th> <th>Class</th>  <th>Arrears</th> <th>Percent</th>  <th>CGPA</th> <th></th>  </tr>';
		$i=1;
		while($row_stu=mysqli_fetch_array($val_stu))
		{
			if($row_stu['selection_type']=='admin')
				$temp='<br/><span class="text-warning">Special Insertion</span>';
			else $temp='';
			if($row_stu['status']=="-2")
				echo '<tr> <td>'.$i++.'</td> <td><a href="'.base_url().'volunteer/user/'.$row_stu['id'].'">'.$row_stu['name'].$temp.'</a></td> <td><strong>Won placement</strong></td> <td>'.$row_stu['admission_no'].'</td> <td>'.$row_stu['class'].'</td> <td>'.$row_stu['ARREAR_NO'].'</td> <td>'.$row_stu['aggr-percent'].'</td> <td>'.$row_stu['aggr-CGPA'].'</td> <td><button class="btn btn-sm btn-default more_button" user-id="'.$row_stu['id'].'"  data-toggle="modal" data-target="#detailsModal" >More</button></td>   </tr>';
		}
		
		echo '<h4 class="text-primary">APPLICATIONS LIST OF YOUR CLASS</h4>';
		mysqli_data_seek($val_stu,0);
		//echo '<tr> <th>SI No.</th> <th>Name</th> <th>Admission No.</th> <th>Class</th>  <th>Arrears</th> <th>Percent</th>  <th>CGPA</th> <th></th>  </tr>';
		$i=1;
		while($row_stu=mysqli_fetch_array($val_stu))
		{
			if($row_stu['selection_type']=='admin')
				$temp='<br/><span class="text-warning">Special Insertion</span>';
			else $temp='';
			if($row_stu['status']!="2502" && $row_stu['status']!="3003" && $row_stu['status']!="-2")
				echo '<tr> <td>'.$i++.'</td> <td><a href="'.base_url().'volunteer/user/'.$row_stu['id'].'">'.$row_stu['name'].$temp.'</a></td> <td><strong>Qualified for level '.$row_stu['status'].'</strong></td> <td>'.$row_stu['admission_no'].'</td> <td>'.$row_stu['class'].'</td> <td>'.$row_stu['ARREAR_NO'].'</td> <td>'.$row_stu['aggr-percent'].'</td> <td>'.$row_stu['aggr-CGPA'].'</td> <td><button class="btn btn-sm btn-default more_button" user-id="'.$row_stu['id'].'"  data-toggle="modal" data-target="#detailsModal" >More</button></td>  </tr>';
		}

		//echo '<tr> <th>SI No.</th> <th>Name</th> <th>Admission No.</th> <th>Class</th>  <th>Arrears</th> <th>Percent</th>  <th>CGPA</th> <th></th>  </tr>';
		$i=1;
		mysqli_data_seek($val_stu,0);
		while($row_stu=mysqli_fetch_array($val_stu))
		{
			if($row_stu['selection_type']=='admin')
				$temp='<br/><span class="text-warning">Special Insertion</span>';
			else $temp='';
			if($row_stu['status']=="3003")
				echo '<tr> <td>'.$i++.'</td> <td><a href="'.base_url().'volunteer/user/'.$row_stu['id'].'">'.$row_stu['name'].$temp.'</a></td> <td><strong class="text-danger">Rejected</strong></td> <td>'.$row_stu['admission_no'].'</td> <td>'.$row_stu['class'].'</td> <td>'.$row_stu['ARREAR_NO'].'</td> <td>'.$row_stu['aggr-percent'].'</td> <td>'.$row_stu['aggr-CGPA'].'</td> <td><button class="btn btn-sm btn-default more_button" user-id="'.$row_stu['id'].'"  data-toggle="modal" data-target="#detailsModal" >More</button></td>  </tr>';
		}

		echo '<hr>';
		//echo '<tr> <th>SI No.</th> <th>Name</th> <th>Admission No.</th> <th>Class</th>  <th>Arrears</th> <th>Percent</th>  <th>CGPA</th> <th></th>  </tr>';
		$i=1;
		mysqli_data_seek($val_stu,0);
		while($row_stu=mysqli_fetch_array($val_stu))
		{
			if($row_stu['selection_type']=='admin')
				$temp='<br/><span class="text-warning">Special Insertion</span>';
			else $temp='';
			if($row_stu['status']=="2502")
				echo '<tr> <td>'.$i++.'</td> <td><a href="'.base_url().'volunteer/user/'.$row_stu['id'].'">'.$row_stu['name'].$temp.'</a></td> <td><strong class="text-danger">Rejected due to <br/>THRESHOLD APPLICATIONS</strong></td> <td>'.$row_stu['admission_no'].'</td> <td>'.$row_stu['class'].'</td> <td>'.$row_stu['ARREAR_NO'].'</td> <td>'.$row_stu['aggr-percent'].'</td> <td>'.$row_stu['aggr-CGPA'].'</td> <td><button class="btn btn-sm btn-default more_button" user-id="'.$row_stu['id'].'"  data-toggle="modal" data-target="#detailsModal" >More</button></td>  </tr>';
		}
		echo '</table>';
		echo '<h6 class="text-muted">* THRESHOLD APPLICATIONS - <small></small></h6>';
		echo '</div>';

?>
</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="detailsModal" id="detailsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
   	 	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">DETAILS</h4>
      	</div>
      <div class="modal-body" id="content_inside">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
$url=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>

<script type="text/javascript">
	//Same code used for individual user rejection page
	$(document).ready(function(){
		var loader=' <span class="ouro ouro3"><span class="left"><span class="anim"></span></span><span class="right"><span class="anim"></span></span></span> ';

		$('.more_button').click(function(){
			var user_id=$(this).attr('user-id');
			$('#content_inside').html('<div style="text-align:center;">'+loader+'</div>');
			//alert('<?php echo base_url();?>admin/ajax_ind_placement/<?php echo $placement_id;?>/'+user_id+'/<?php echo $url; ?>');
			$('#content_inside').load('<?php echo base_url();?>admin/ajax_ind_placement/<?php echo $placement_id;?>/'+user_id);
		});

		$(document).on('change','#read_all',function(){
		if($(this).prop('checked') == true)
			$("#submit").prop('disabled',false);
		else
			$("#submit").prop('disabled',true);
		});

		$('#search_bar').keyup(function(){
		if($(this).val().length>0)
			{
				$("#search_button").show(200);
				$("#advanced_search_button").hide(200);
			}
		else
			{
				$("#search_button").hide(200);
				$("#advanced_search_button").show(200);
			}
		});
	})
</script>