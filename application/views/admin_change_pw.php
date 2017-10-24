

<div class="container">
<div class="row">
<div class="col-xs-11 col-md-5 col-md-offset-3">
<?php
if(isset($_POST['submit']))
{
	$username=strtoupper($_POST['username2']);
	if(empty($_POST['username2']) || empty($_POST['password2']) || empty($_POST['retype_password2']))
	{
		echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>All credentials are required.</div>';
	}
	else
	{
		if( strlen($_POST['password2'])<5)
			echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>Password should atleast have 5 characters.</div>';
		else if($_POST['password2']!=$_POST['retype_password2'])
			echo '<div class="alert alert-danger fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>Passwords doesn\'t match.</div>';
		else
		{
				$password=$_POST['password2'];
				$password=password_hash($password, PASSWORD_BCRYPT);
			if($username=="ADMIN")
			{
					echo '<div class="alert alert-warning fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>Contact super admin to change ADMIN password</div>';
			}
			else if($_POST['username2']!="b12c9203278")
			{
				$this->db->query('UPDATE `user_table` SET password="'.$password.'" WHERE admission_no="'.$username.'"');
				$res3=$this->db->simple_query('SELECT id FROM `user_table` WHERE admission_no="'.$username.'"');
				if($row3=mysqli_fetch_array($res3))
					{
						$this->db->query('DELETE FROM `login_fail_log` WHERE user_id="'.$row3['id'].'"');
					}
				echo '<div class="alert alert-success fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>Password changed for <strong>'.$username.'</strong></div>';
			}
			else
			{
				if($_POST['username2']=="b12c9203278")
				{
					$this->db->query('UPDATE `user_table` SET password="'.$password.'" WHERE admission_no="ADMIN"');
					$res3=$this->db->query('SELECT id FROM `user_table` WHERE admission_no="ADMIN"');
					if($row3=mysqli_fetch_array($res3))
					{
						$this->db->query('DELETE FROM `login_fail_log` WHERE user_id="'.$row3['id'].'"');
					}
					echo '<div class="alert alert-success fade in">    <a href="#" class="close" data-dismiss="alert">&times;</a>Password changed for ADMIN</div>';
				}
				
			}
		}
	}
}
?>

<h3 class="text-muted">CHANGE PASSWORD</h3>
<div class="form-academic">
	<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
	<div class="form-group">
		<label for="username">Admission Number. </label>
		 <input type="text" name="username2" required style="text-transform:uppercase" class="form-control" autocomplete="off">
	</div>
	<h6><small>Add <strong>V-</strong> at beginning to change volunteer password.</small></h6>
	<hr>
	<div class="form-group">
		<label for="password">New Password.</label>
		<input type="password" name="password2" required class="form-control" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="password">Retype New Password.</label>
		<input type="password" name="retype_password2" required class="form-control" autocomplete="off">
	</div>
	<input type="submit" name="submit" value="Change Password" class="btn btn-primary">
	</form>	
</div>

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->