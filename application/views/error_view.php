
<div class="container">
<div class="row">
<div class="col-xs-11 col-md-9 col-md-offset-2">

<?php
if(isset($no_user))
	echo '<div class="alert alert-danger fade in"> Exception caught. User doesn\'t exist or have been removed</div>';
if(isset($e403))
	echo '<div class="alert alert-danger fade in"> <strong>403</strong> Access forbidden</div>';
?>

</div>
</div>
</div>