<div class="container">
<div class="row">
<div class="col-xs-11 col-md-5 col-md-offset-3">
<script type="text/javascript">
	$('#v_login_butt').popover(options);
</script>
<?php
if($code!=99)
{
	echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>';
	switch ($code) {
		case 10:
			echo '<strong>Error!</strong> The user doesn\'t exist. <a href="'.base_url().'signup/candidate">Signup as a candidate</a>';
			break;
		case 90:
			echo "<strong>Error!</strong> Multiple failure to login, please reset your password";
			break;
		case 20:
			echo "<strong>Error!</strong> Incorrect credentials";
			break;
		case 54:
			echo "<strong>Error!</strong> Verify your email first. "; //Won't run, depreciated
			break;
		case 45:
			echo "<strong>Error!</strong> Please wait while your account is being verified"; // Won't run, depreciated
			break;
		case 30:
			echo "<strong>Error!</strong> Credentials cannot be empty";
			break;
		
		default:
			echo "Fatal error: Contact webmaster with login CODE: ".$code;
			break;
	}
	echo "</div>";
}
if ($this->session->has_userdata('user_id')) {
	echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>You are already logged in as "'.$this->session->name.'", logging in again can sign you out.</div>';
}
?>

<div class="form-academic">
	<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
	<div class="form-group">
		<label for="username">Admission Number </label>
		 <input type="text" name="username" required style="text-transform:uppercase" class="form-control">
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" required class="form-control">
	</div>
	<div class="form-group">
	Remember me <input type="checkbox" name="remember" value="yes">
	</div>
	<input type="submit" name="submit" value="Login" class="btn btn-primary">
	</form>	
	<hr>
		<a  role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		  Volunteer Login
		</a>
		<div class="collapse" id="collapseExample">
		  <div class="well">
		    Add <strong>V-</strong> before your admission number.<p><p>
		    Example<br/>  Admission Number: <strong>V-B13CSXXX</strong>
		  </div>
		</div>
</div>


</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->
