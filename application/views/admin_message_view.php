
<div class="container">
<hr>
<div class="row">
<?php
	if($this->session->type=='admin')
	{
		if(isset($_POST['update_message']))
		{
			$message=$_POST['area2'];
			$message=strip_tags(nl2br($message), '<br>');
			// $data=array(
			// 	'key1'=> 'admin_message',
			// 	'value1' => $message
			// 	);
			$this->db->simple_query('UPDATE config_table SET value1="'.$message.'" WHERE key1="admin_message"');
			//$this->db->update('config_table',$data);

		}
	}
	$val=$this->db->simple_query('SELECT `value1` from config_table WHERE `key1`="admin_message"');
	$row=mysqli_fetch_array($val);
	$final_message=$row['value1'];
	//echo $final_message;
	$formatted_msg=str_replace("<br />","", $final_message);
?>

	<div class="col-xs-11 col-md-6 ">
		<div class="form-academic">
		<h5>ADMIN MESSAGE TO EVERYONE</h5>
		<div class="text-primary">Feature active</div><br/>
		<form method="POST">
		<textarea maxlength="1000" name="area2" placeholder="Feature is active." id="area2" style="width:100%; height:75px;" rows="2" cols="20" wrap="hard"><?php echo $formatted_msg; ?></textarea>
		<input type="submit" value="Update" class="btn btn-primary" name="update_message" id="msg2" style="display:none;">
		</form>

		</div>

	</div>

	<div class="col-xs-11 col-md-6 ">
	<form method="GET" action="<?php echo base_url();?>admin/search">
		<input type="text" name="general" id="search_bar" placeholder="Search users" autofocus><br/>
	<div class="pull-right">
		<a href="<?php echo base_url();?>admin/search" id="advanced_search_button" style="cursor:pointer;">Advanced Search</a>
		<input type="submit" name="search_console" id="search_button" class="btn btn-primary" value="Search" style="display:none;">
	</div>
</form>
	<br/>
	<a href="<?php echo base_url();?>admin/search?general=&candidate=1&BTECH=1&MTECH=1&MCA=1&male=1&female=1&year=&division=&branch=&arrear_no=&ARREAR_HISTORY=&aggr-percent=&aggr-CGPA=&search=Search">View all candidates</a> |
	<a href="<?php echo base_url();?>admin/search?general=&volunteer=1&BTECH=1&MTECH=1&MCA=1&male=1&female=1&year=&division=&branch=&arrear_no=&ARREAR_HISTORY=&aggr-percent=&aggr-CGPA=&search=Search">View all Volunteers</a> <hr>
	<a href="<?php echo base_url();?>admin/search?general=&search_console=Search">View all users</a> | <a href="<?php echo base_url();?>admin/change_pw">Change user password</a> <hr>
	<a href="<?php echo base_url();?>admin/edit_user">Edit User Data</a> <hr>
	<a href="<?php echo base_url();?>admin/download_backup" class="btn btn-default">Download Database Backup</a>
	<?php
	$academic_lock=0;
	$aca=$this->db->simple_query('SELECT * FROM config_table WHERE key1="academic_lock"');
	if($aca_row=mysqli_fetch_array($aca))
	{
		if($aca_row['value1']=='1')
			$academic_lock=1;
	}
	if($academic_lock==0)
		echo '<a href="'.base_url().'admin/?lock_academic" class="btn btn-warning">Lock Academic Updation</a>';
	else
		echo '<a href="'.base_url().'admin/?open_academic" class="btn btn-default">Open Academic Updation</a>';
	?>


	</div>
</div>
</div>
<hr>

<script>
$(document).ready(function(){
	$('#area2').bind('input propertychange',function(){
		$('#msg2').show(300);
	});

});
</script>