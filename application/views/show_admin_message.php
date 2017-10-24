
<?php
$res_admin_msg=$this->db->simple_query('SELECT value1 FROM config_table WHERE key1="admin_message"');
$row_admin=mysqli_fetch_array($res_admin_msg);
if(!empty($row_admin['value1']))
{

	?>
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
				<div class="col-md-6 main_box">
					<h5 style="text-transform:uppercase;" class="text-primary">Message from placement officer.</h5>
					<div style="padding:6px;"><?php echo $row_admin['value1']; ?></div>
				</div>
			<div class="col-md-3"></div>
		</div>
	</div>
	<?php

}
?>

