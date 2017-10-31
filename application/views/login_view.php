<div class="container">
<div class="row">
<div class="col-xs-11 col-md-5 col-md-offset-3">
<script type="text/javascript">
	$('#v_login_butt').popover(options);
</script>

<div class="form-academic">
   
	<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
	<div class="form-group">
		<label for="username">EMAIL </label>
		 <input type="text" name="username"  class="form-control">
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" required class="form-control">
	</div>
	
	<input type="submit" name="submit" value="Login" class="btn btn-primary">
	</form>	
	<hr>
		
</div>


</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->
