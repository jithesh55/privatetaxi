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

 <h2 class="text-muted">PRIVATE TAXI RENTAL SYSTEM <small>GIVE A RIDE</small></h2>
 <p class="text-muted">
PRIVATE TAXI RENTAL SYSTEM<br/>
 GIVE A RIDE ON YOUR WAY AND EARN MONEY<br/><br/>


 </p>

</div>
</div>
</div>

<div>
<img src="<?php echo base_url(); ?>images/college.png" class="img-responsive">
</div>
