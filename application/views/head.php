<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css">
	<link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.jpg" type="image/x-icon" />

</head>

<script src="<?php echo base_url();?>js/jquery.js"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
				<?php
				if(isset($dob_pick))
				{
					?>
				  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
				  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
				  <script>
				  $(function() {
				    $( "#datepicker" ).datepicker({
				      changeYear: true,
				      changeMonth: true,
				      yearRange: "-50:+0",
					  dateFormat: "dd-mm-yy"
					});
				  });
				  </script>
				<?php 
				}
				?>

<body>
<div class="container-fluid header">
	<div class="row">
	<div class="col-xs-11">
	<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" id="logo"  title="Home"></a>
	</div>
	</div>
	<?php
	if(!$this->session->has_userdata('user_id'))
	{
		echo '<div class="btn-group pull-right" style="margin-top:4px; margin-right:5px;"> ';
		echo '<a href="'.base_url().'login" class="btn btn-default">Login</a>';
		?>
		<div class="btn-group pull-left">
		  <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#">
		    Signup
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
		    <li><a href="<?php echo base_url();?>signup/candidate">Candidates</a></li>
		    <li class="divider"></li>
		    <li><a href="<?php echo base_url();?>signup/volunteer">Volunteers</a></li>
		  </ul>
		</div>
		<?php
		echo '</div>';
	}
	else
	{
		if($this->session->type=="volunteer")
			{
				$array=explode('-', $this->session->admission_no);
				$val=$this->db->simple_query('SELECT id FROM user_table WHERE admission_no="'.$array[1].'" AND type="candidate"');
				if(mysqli_num_rows($val)==1)
				{
					$row=mysqli_fetch_array($val);
					$candidate5='yes';
				}
			}
		if($this->session->type=="candidate")
			{
				$val=$this->db->simple_query('SELECT * FROM user_table WHERE admission_no="V-'.$this->session->admission_no.'" AND type="volunteer" AND verified=1');
				if(mysqli_num_rows($val)==1)
				{
					$row=mysqli_fetch_array($val);
					$volunteer5='yes';
				}
			}
		echo '<div class="btn-group pull-right" style="margin-top:4px; margin-right:5px;"> ';
			echo '<a class="btn dropdown-toggle btn-default" data-toggle="dropdown" href="#" style="border:none; background:transparent; color:#fff;"><span class="caret"></span></a>';
			echo '<ul class="dropdown-menu">';
			if($this->session->type=="volunteer" || $this->session->type=="candidate")
				echo '<li><a href="'.base_url().'change_password" >Change Password</a></li>';
			if(isset($candidate5))
				echo '<li><a href="'.base_url().'logout/switchme" >Switch to Candidate</a></li> <li class="divider"></li>';
			if(isset($volunteer5))
				echo '<li><a href="'.base_url().'logout/switchme" >Switch to Volunteer</a></li> <li class="divider"></li>';
			echo '<li><a href="'.base_url().'logout" >Logout</a></li>';
			echo '</ul>';

		echo '<a href="'.base_url().$this->session->type.'" class="btn btn-default" id="console-btn">Console</a>';
		echo '<a href="'.base_url().'" class="btn btn-primary">Home</a>';
		echo '</div>';
	}
	?>
</div>