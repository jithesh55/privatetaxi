
<div class="container">
<div class="row">
	<div class="col-xs-11 col-md-9 col-md-offset-2"> 
	<h3 class="text-muted">Hi, <?php echo $name;?> <br/>
	<div class="btn-group pull-right">
		<button class="btn btn-default" data-toggle="modal" data-target="#myModal">View Details</button>
		
	<?php
	if($has_started==1)
	{
		echo '<a href="'.base_url().'candidate/update_academic" class="btn btn-default">Update academic details</a>';
        
       echo '<a href="'.base_url().'candidate/add_data" class="btn btn-default">Update details</a>';
	}
	else 
	{
		echo '<a href="'.base_url().'candidate/start_academic" class="btn btn-primary">Update academic details to get started</a>';
	}
	?>
       
	</div>
	</h3>
	</div>
	
</div> <!--Row -->
</div><!--container -->

<hr>
<!-- Personal Details Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Personal Details</h4>
      </div>
      <div class="modal-body">
        <?php echo $personal_details;?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
