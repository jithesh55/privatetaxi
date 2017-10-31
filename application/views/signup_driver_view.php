<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">
<h2 style="color:#7C7C7C;">DRIVER SIGNUP <small></small></h2><br/>

<div class="col-md-6">
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
<form method="POST" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" class="form">
	<div class="form-group">
		<label for="name">Name </label>
		<input type="text" name="name" style="text-transform:uppercase;" required class="form-control" value="<?php echo set_value('name'); ?>">
	</div>
	<div class="form-group">
		<label for="gender">Gender </label>
		<div class="radio">
		<?php
			if(isset($_POST['gender']))
			{
				if($_POST['gender']=="male")
					$male_1=1;
				else if($_POST['gender']=="female")
					$female_1=1;
			}
		?>
		<label><input type="radio" name="gender" value="male" required <?php if(isset($male_1)) echo 'checked="checked"';?>>Male</label>
		</div>
		<div class="radio">
		<label><input type="radio" name="gender" value="female" required <?php if(isset($female_1)) echo 'checked="checked"';?>>Female</label>
		</div>
	</div>
	<div class="form-group">
		
		<p class="text-danger" id="admn_fbk"></p>
	</div>
	<div class="form-group">
		<label for="password">Password </label>
		<input type="password" id="password" name="password" required class="form-control" >
		<p class="text-danger fbk" id="psw_fbk">Sorry! The password should atleast be 5 characters</p>
	</div>
	<div class="form-group">
		<label for="r_password">Password Again</label>
		<input type="password" id="r_password" name="r_password" required class="form-control" >
		<p class="text-danger fbk" id="r_psw_fbk">Sorry! The passwords doesn't match</p>
	</div>
	<div class="form-group">
		<label for="email">Email id </label>
		<input type="email" name="email" required class="form-control"  value="gmail">
	</div>
    <div class="form-group">
    <label for="age">Age</label>
        <input type="number" name="age" required class="form-control"  value="age">
    </div>
    <div class="form-group">
    <label for="aproof">AADHAR  number</label>
        <input type="number" name="adproof" required class="form-control"  value="aadhar">
        <label for="lproof">Liscence number</label>
        <input type="number" name="lproof" required class="form-control"  >
        <label for="type">VEHICLE type</label><br>
       <select name="type">
                <option value="car">CAR</option>
                <option value="bike">Bikes</option>
                
                
        </select>
        <br>
        <label for="vnumber">Vehicle number</label>
        <input type="number" name="vnumber" required class="form-control" >
        
        <label for="rcbook">RC BOOK number</label>
        <input type="number" name="rcbook" required class="form-control"  >
    </div>
	<div class="form-group">
		<label for="mobno">Mobile number </label>
		<div class="input-group">
    	<span class="input-group-addon">+91</span>
		<input type="text" name="mobno" required class="form-control" maxlength="10" >
		</div>
	</div>
	
	
	<div class="form-group">
		<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Signup as driver">
	</div>
</form>

</div><!--internal col -->

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->