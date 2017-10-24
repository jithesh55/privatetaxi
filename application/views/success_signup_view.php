<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">


<p>

<h2>Hi, <?php echo $name;?></h2><br/>
<p class="bg-success padding">
	<?php
	if($type=='volunteer')
		echo 'Successful signing up as volunteer';
	else if ($type=='candidate')
		echo 'Successful signing up as candidate';
	?>
</p>
<?php
/*if($email_verified==1)
{
	echo '<p class="bg-success padding">';
	echo 'Successful verifying email';
	echo '</p>';
}*/
if($verified==1)
{
	echo '<p class="bg-success padding">';
	echo 'Successful verifying your account.</p>';
}

if($verified==0 || $email_verified==0) //THE EPIC DIVIDER
echo '<blockquote class="text-muted">Nothing has started until you have finished the following tasks.</blockquote>';

/*if($email_verified==0)
{
	echo '<p class="bg-primary padding">';
	echo 'Verify your email by clicking on the verification link sent to your email |';
	echo '<a href="#" style="color:#fcfcfc; text-decoration:underline;"> resend mail</a></p>';

	//TEMPORARY
	echo '<p>Temp setup: <a href="'.base_url().'email_controller/verify/'.$user_id.'/'.$code.'" target="_blank">email_verify</a> | <a href="'.base_url().'email_controller/reject/'.$user_id.'/'.$code.'" target="_blank">email_reject</a></p>';
}*/
if($verified==0 && $type=="candidate")
{
	echo '<p class="bg-primary padding">';
	echo 'Ask your class volunteer to verify you.<br/>';
	$val=$this->db->simple_query('SELECT name FROM user_table WHERE class="'.$class.'" AND type="volunteer" AND verified="1"');
	echo "<strong>Your class volunteers are :</strong>";
	while($row=mysqli_fetch_array($val))
	{
		echo '<br/>'.$row['name'];
	}
	echo '</p>';
}
if($verified==0 && $type=="volunteer")
{
	echo '<p class="bg-primary padding">';
	echo 'Ask the placement officer to verify you.</p>';
}
if($verified==1 && $email_verified==1)
{
	echo '<p class="text-info padding">';
	echo 'You are all set to go. Head on to the <a href="'.base_url().'login" style="text-decoration:underline;">login page</a>';
	echo '<br/>Your username: <strong>'.$admission_no.'</strong>';
}
?>

</p>

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->