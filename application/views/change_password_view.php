<div class="container">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10 main_box">

		 <h2 class="text-primary">Change Password</h2>
		 <hr>
		 <p>
		 	<?php
		 		if($this->session->type=='volunteer')
		 		{
		 			echo '<div class="alert alert-warning fade in">';
					echo 'This password change would be common for <strong>both</strong> your personal candidate and volunteer accounts';
					echo '</div>';
					$isVolunteer=1;
		 		}
		 		else if($this->session->type=='candidate')
		 		{
		 			$val = $this->db->simple_query('SELECT id FROM user_table WHERE admission_no="V-'.$this->session->admission_no.'"');
		 			if(mysqli_num_rows($val)>0)
		 			{
		 					echo '<div class="alert alert-warning fade in">';
							echo 'This password change would be common for <strong>both</strong> your personal candidate and volunteer accounts';
							echo '</div>';
							$isVolunteer=1;
		 			}
		 			
		 		}

		 		if(isset($result[0]))
				{
					if($result[0]=="success")
					{
						echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a>';
						echo $result[1];
						echo '</div>';
					}
					if($result[0]=="error")
					{
						echo '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error! </strong>';
						echo $result[1];
						echo '</div>';
					}
				}
		 	?>
		 	<div class="row">
		 		<div class="col-md-3"></div>
		 		<div class="col-md-6">
		 			<form method="POST" action="">
		 				<div class="form-group">
							<label for="password">Current Password</label>
							<?php
								if(isset($isVolunteer))
									echo '<br/>of volunteer account';
							?>
							<input type="password" name="current_password" required class="form-control">
						</div>
						<div class="form-group">
							<label for="password">New Password</label>
							<br/>Minimum 8 characters
							<input type="password" name="new_password" required class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Retype New Password</label>
							<input type="password" name="r_new_password" required class="form-control">
						</div>
						<div class="form-group">
							<input type="submit" name="change_pw" class="btn btn-default">
						</div>
					</form>
		 		</div>
		 	</div>
		 </p>

		</div>
	</div>
</div>