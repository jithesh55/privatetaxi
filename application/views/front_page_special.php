<div class="container" style="text-align:center;">
<?php
if($this->session->has_userdata('user_id'))
	{
		$user_id = $this->session->user_id;
		$type = $this->session->type;

		switch ($type) {
			case 'admin':
				echo '<a href="'.base_url().'admin" class="btn btn-primary">Goto admin console</a>';
				break;
			case 'volunteer':
				echo '<a href="'.base_url().'volunteer" class="btn btn-primary">Goto your volunteer console</a>';
				break;
			case 'candidate':
				echo '<a href="'.base_url().'candidate" class="btn btn-primary">Goto your console</a>';
			
			default:
				echo '';
				break;
		}
	}


?>
</div>



<div class="container">
<div class="row">
<div class="col-xs-11 col-md-10 col-md-offset-3">

 <h2 class="text-muted">TRAINING AND PLACEMENT CELL <small>MACE</small></h2>
 <p class="text-muted">
 This is the web portal for Training and Placement Cell ,Mar Athanasius College of Engineering, Kothamangalam .<br/>
 This space will be filled with statistics and other informations after the portal is put to the full fledged working.<br/><br/>


 </p>

</div>
</div>
</div>

<div>
<img src="<?php echo base_url(); ?>images/college.png" class="img-responsive">
</div>
