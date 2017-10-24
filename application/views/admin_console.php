<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">



</div><!-- col classes -->
</div><!-- row class -->

<?php
if($unverified_num > 0)
{
	?>

		<h3>Volunteers to be verified <small>Please delete unlegitimate users</small></h3>
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
  				<button class="btn btn-danger delete_volunteer" data-dismiss="modal" >Delete</button> 
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
  				<button class="btn btn-primary verify_volunteer" data-dismiss="modal" onclick="verify_v()">Verify</button> 
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

		$(".delete_volunteer_first").click(function(){
			user_id=$(this).attr('id');
			var temp= '#h_'+user_id;
			$('.inside_deletion_modal').html( $(temp).html() );
		});

		$(".verify_volunteer_first").click(function(){
			user_id=$(this).attr('id');
			var temp= '#h_'+user_id;
			$('.inside_verification_modal').html( $(temp).html() );
		});
		$(".verify_volunteer").click(function(){
			$('#group_'+user_id).html(loader);
			if( ! ($('#row_'+user_id).load("<?php echo base_url();?>admin/ajax_single_volunteer_unverified/verify/"+user_id) ) )
			{
				$('#group_'+user_id).html(conn_failed);
			}
		});
		$(".delete_volunteer").click(function(){
			$('#group_'+user_id).html(loader);
			if( ! ($('#row_'+user_id).load("<?php echo base_url();?>admin/ajax_single_volunteer_unverified/delete/"+user_id) ) )
			{
				$('#group_'+user_id).html(conn_failed);
			}
		});
	});
</script>