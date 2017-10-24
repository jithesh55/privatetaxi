
<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">

<?php
if($verej=="verify")
{
	echo '<h2 class="text-muted">EMAIL VERIFICATION</h2>';
	if($res[0]=="error")
	{
		echo '<div class="alert alert-danger fade in"> ';
		echo '<strong>Error! </strong>Invalid code <strong>or</strong> the link have already been used.';
		echo '</div>';
	}
	else if($res[0]=="success")
	{
		if($res[1]==0)
		{
			
			if($final==NULL)
			{
				echo '<div class="alert alert-warning fade in"> ';
				echo '<strong>Error! </strong>Email verification failed.';
				echo '</div>';
			}
			else
			{
				echo '<div class="alert alert-success fade in"> ';
				echo '<strong>Success!  </strong>Email verification for <strong>'.$final.'</strong> successfull.';
				echo '</div>';
				echo '<a href="'.base_url().'signup/success/'.$user_id.'">Click here</a> to see your current status.';
			}
		}
	}
}
else if($verej=="reject")
{
	echo '<h2 class="text-muted">EMAIL REJECTION</h2>';
	if($res[0]=="error")
	{
		echo '<div class="alert alert-danger fade in"> ';
		echo '<strong>Error! </strong>Invalid code <strong>or</strong> the link have already been used.';
		echo '</div>';
	}
	else if($res[0]=="success")
	{
		if($res[1]==0)
		{
			
			if($final==NULL)
			{
				echo '<div class="alert alert-warning fade in"> ';
				echo '<strong>Error! </strong>Email rejection failed.';
				echo '</div>';
			}
			else
			{
				echo '<div class="alert alert-success fade in"> ';
				echo '<strong>Success!  </strong>Account registered with email <strong>'.$final.'</strong> has been successfully removed.';
				echo '</div>';
			}
		}
	}
}
?>

</div>
</div>
</div>