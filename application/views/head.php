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
				

<body>
<div class="container-fluid header">
	<div class="row">
	<div class="col-xs-11">
	<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.jpg" id="logo"  title="Home"></a>
	</div>
	</div>
	<?php
	
		echo '<div class="btn-group pull-right" style="margin-top:4px; margin-right:5px;"> ';
		//echo '<a href="'.base_url().'login" class="btn btn-default">Login</a>';
		?>
		<div class="btn-group pull-right">
		  <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#">
		    Signup
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
		    <li><a href="<?php echo base_url();?>signup/passenger">Passenger</a></li>
		    <li class="divider"></li>
		    <li><a href="<?php echo base_url();?>signup/driver">Driver</a></li>
		  </ul>
    	</div>
    <div class="btn-group pull-right">
      <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#">
		    Login
		    <span class="caret"></span>
		  </a>
            <ul class="dropdown-menu">
		    <li><a href="<?php echo base_url();?>login/passenger">Passenger</a></li>
		    <li class="divider"></li>
		    <li><a href="<?php echo base_url();?>login/driver">Driver</a></li>
		  </ul>
    </div>
    
		<?php
		echo '</div>';
	
	?>
</div>