<div class="container">
<div class="row">
<div class="col-xs-11 col-md-5 col-md-offset-3">

<?php
if($result[0]!="NULL")
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

<div class="alert alert-info fade in">
	  <a href="#" class="close" data-dismiss="alert">&times;</a>
	You are going to add a new class to the system.
</div>
<p>
	<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
	<div class="form-group">
	<label for="course">Course </label>
	<select name="course" required class="form-control">
		<option value="">-SELECT-</option>
		<option value="BTECH">B.Tech</option>
		<option value="MTECH">M.Tech</option>
		<option value="MCA">MCA</option>
	</select>
	</div>

	<div class="form-group">
	<label for="year">Year of pass-out </label>
	<select name="year" required class="form-control">
		<option value="">-SELECT-</option>
		<?php
		for($i=date("Y")-1 ; $i<=date("Y")+10 ; $i++)
		{
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>
	</select>
	</div>

	<div class="form-group">
	<label for="branch">Branch </label>
	<select name="branch" required class="form-control">
		<option value="">-SELECT-</option>
		<?php
		for($i=0 ; isset($full_name[$i]) ; $i++)
		{
			echo '<option value="'.$short_name[$i].'">'.$full_name[$i].'</option>';
		}
		?>
	</select>
	</div>

	<div class="form-group">
	<label for="batch">Batch</label>
	<select name="batch" required class="form-control">
		<option value="">-SELECT-</option>
		<option value="A">A</option>
		<option value="B">B</option>
		<option value="C">C</option>
		<option value="D">D</option>
		<option value="E">E</option>
	</select>
	</div>

	<div class="form-group">
	<label for="batch">Remark (Generally used to specify type of M.Tech)</label>
		<input type="text" name="remark" placeholder="Retain blank if not required" class="form-control" maxlength="15">
	</div>

		<input type="submit" name="submit" value="Add new class"  class="btn btn-primary">

	</form>

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->