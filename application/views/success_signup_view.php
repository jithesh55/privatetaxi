<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">


<p>

<h2>Hi, <?php echo $name?></h2><br/>
<p class="bg-success padding">
	<?php
	if($type=='passenger')
		echo 'Successful signing up as Passenger';
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
/*
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
} */
?>

</p>

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->