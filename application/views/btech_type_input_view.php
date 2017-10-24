
<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2"> 
<div class="form-academic">
<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" class="form">
		<h4>For lateral entry students</h4>
			<div class="radio">
		  <label>
		    <input type="radio" name="btech_type" value="lateral" required>
		    I'm a lateral entry student.
		  </label>
		</div>
		<h4>For non-lateral entry students</h4>
		<div class="radio">
		  <label>
		    <input type="radio" name="btech_type" value="normal" required>
		    I'm a student enrolled in Mahatma Gandhi University.
		  </label>
		</div>
		<div class="radio">
		  <label>
		    <input type="radio" name="btech_type" value="normal-ktu" required>
		    I'm a student enrolled in Kerala Technical University.
		  </label>
		</div>
		<blockquote class="text-danger">
			This is an irrevocable action. Please be careful.
		</blockquote>
		<input type="submit" name="submit" value="Allocate me." class="btn btn-default">
</form>
</div>
</div> <!--col -->
</div> <!--Row -->
</div><!--container -->