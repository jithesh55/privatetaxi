<h3 class="text-muted">ADD DETAILS</h3><br/>




<form method="POST" id="update-form" enctype="multipart/form-data" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" >
		<h5 class="text-primary">Initial Data</h5>
		<table class="table">
		<?php
				echo '<div class="form-group"><div class="input-group"> <label for="mini_project">MINI PROJECT </label> 
		<textarea name="mini_project"  required class="form-control" maxlength="950" style="height:200px;"></textarea>  </div>';
			
				echo '<div class="form-group"><div class="input-group"> <label for="main_project">MAIN PROJECT </label> 
		<textarea name="main_project"  required class="form-control" maxlength="950" style="height:200px;"></textarea>  </div>';
            echo '<div class="form-group"><div class="input-group"> <label for="workshop">Training or Workshop attended </label> 
		<textarea name="workshop" required class="form-control" maxlength="950" style="height:200px;"></textarea>  </div>';
            ?>
            <div class="form-group"><div class="input-group">
           
  <label for="fileSelect">Filename:</label>
        <input type="file" name="photo" id="fileSelect">
    <input type="submit" name="add_detail" value="Upload" class="btn btn-success" id="add_detail" />
                </div>
            </div>
    </table>
</form>
                
                
  