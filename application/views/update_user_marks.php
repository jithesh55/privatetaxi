<div class="container no-print">
	<div class="row main_box">

					<?php
					if(isset($_POST['update_marks_submit']))
					{
						if(empty($_POST['percent']) && empty($_POST['cgpa']))
						{
							echo '<div class="text-muted">No data updated.</div><br/>';
						}
						else if (!empty($_POST['percent']) && !empty($_POST['cgpa']))
						{
							$percent= strip_tags(trim($_POST['percent']));
							$cgpa= strip_tags(trim($_POST['cgpa']));
							$query='UPDATE user_table SET `aggr-percent`="'.$percent.'", `aggr-CGPA`="'.$cgpa.'" WHERE id="'.$user_id.'"';
							//echo $query;
							$this->db->simple_query($query);
							echo '<div class="text-success">Percent and CGPA updated.</div><br/>';
						}
						else if (!empty($_POST['percent']) )
						{
							$percent= strip_tags(trim($_POST['percent']));		
							$query='UPDATE user_table SET `aggr-percent`="'.$percent.'" WHERE id="'.$user_id.'"';
							$this->db->simple_query($query);
							echo '<div class="text-success">Percent updated.</div><br/>';
						}
						else if (!empty($_POST['cgpa']) )
						{
							$cgpa= strip_tags(trim($_POST['cgpa']));		
							$query='UPDATE user_table SET `aggr-CGPA`="'.$cgpa.'" WHERE id="'.$user_id.'"';
							$this->db->simple_query($query);
							echo '<div class="text-success">CGPA updated.</div><br/>';
						}
					}
					?>
	<h5>Edit Candidate Details</h5>
	<form method="POST">
		<div class="col-md-2">
			<div class="form-group">
				<label for="percent">New Percent </label>
				 <input type="text" name="percent" class="form-control">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="cgpa">New CGPA </label>
				 <input type="text" name="cgpa" class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<input type="checkbox" required> I understand that I'm going to manually update the student academic data.<br/>
			<input type="submit" name="update_marks_submit" class="btn btn-default">
		</div>
	</form>

	</div>
</div>