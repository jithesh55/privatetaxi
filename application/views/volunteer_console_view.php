<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-1">
<div class="form-academic">
	<h3 class="text-muted text-center">Hi, <?php echo $name;?> <small>VOLUNTEER OF CLASS: <strong><?php echo $class;?></strong></small></h3><br/><br/>

	<p class="text-primary">
	<a href="<?php echo base_url();?>volunteer/search?general=&search=Search">View all candidates</a><br/><br/>
	<a href="<?php echo base_url();?>volunteer/change_pw">Change Candidate Password</a><br/><br/>
	<a href="<?php echo base_url();?>volunteer/academic_verify"><span class="bg-primary padding user_unverified_academic" style="padding:3px;"><?php echo $list[0];?> user<?php if($list[0]!=1) echo 's';?></span> have submitted academic details for verification</a>
	</p>


</div>
		<form method="GET" action="<?php echo base_url();?>volunteer/search">
		<br/><input type="text" name="general" id="search_bar" placeholder="Search users (Name/Admission Number)" autofocus><br/>
		<div class="pull-right">
		<input type="submit" name="search" id="search_button" class="btn btn-default" value="Search">
		</div>
		</form>

</div><!-- col classes -->
</div><!-- row class -->
<?php

if($unverified_num > 0)
{
	?>

		<h3>Candidates to be verified <small>PLEASE DELETE UNLEGITIMATE USERS</small></h3>
		<div class="table-responsive">
		<table class="table table-hover" style="background:#FFF;">
		<?php
		foreach ($unverified as $un) {
			echo $un;
		}
		?>
		</table>
		</div> <!--Table responsive div -->
	<?php
} // Show "unverified users, only on $unverified_num > 0"

		echo '<hr>';
		echo '<h4 class="text-muted">PLACEMENTS FOR YOUR CLASS</h4><br/>';
		$val= $this->db->simple_query('SELECT * FROM placement_main WHERE  '.$course.'="1" AND hide=0'); 
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
				if($row['status']==1)
					echo '<td>Open</td>';
				else
					echo '<td>Closed</td>';
				echo '<td>';
					if($row['type']=='normal')
						echo 'IT Company';
					else
						echo 'Dream/Core company';
				echo '</td>';
				echo '<td><a href="'.base_url().'volunteer/placement/'.$row['placement_id'].'">View List</a></td>';
				echo '</tr>';
			}

		echo '</table>';
		echo '</div>';
?>

</div><!-- container class -->

<!-- Large Modal Deletion-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="delete_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4>Confirm Deletion? </h4>
	      <div class="inside_deletion_modal"></div>
  				<button class="btn btn-danger delete_candidate" data-dismiss="modal" >Delete</button> 
  				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

<!-- Large Modal Verification -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="verify_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4>Confirm Verification? </h4>
	      <div class="inside_verification_modal"></div>
  				<button class="btn btn-primary verify_candidate" data-dismiss="modal" onclick="verify_v()">Verify</button> 
  				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
    </div>
  </div>
</div>

<script type="text/javascript">
var user_id;
var loader=' <span class="ouro ouro3" id="auro_mine"><span class="left"><span class="anim"></span></span><span class="right"><span class="anim"></span></span></span> ';
var conn_failed='<p class="text-danger">Connection Failed</p>';
	$(document).ready(function(){

		$(".delete_candidate_first").click(function(){
			user_id=$(this).attr('id');
			var temp= '#h_'+user_id;
			$('.inside_deletion_modal').html( $(temp).html() );
		});

		$(".verify_candidate_first").click(function(){
			user_id=$(this).attr('id');
			var temp= '#h_'+user_id;
			$('.inside_verification_modal').html( $(temp).html() );
		});
		$(".verify_candidate").click(function(){
			$('#group_'+user_id).html(loader);
			if( ! ($('#row_'+user_id).load("<?php echo base_url();?>volunteer/ajax_single_candidate_unverified/verify/"+user_id) ) )
			{
				$('#group_'+user_id).html(conn_failed);
			}
		});
		$(".delete_candidate").click(function(){
			$('#group_'+user_id).html(loader);
			if( ! ($('#row_'+user_id).load("<?php echo base_url();?>volunteer/ajax_single_candidate_unverified/delete/"+user_id) ) )
			{
				$('#group_'+user_id).html(conn_failed);
			}
		});
	});
</script>