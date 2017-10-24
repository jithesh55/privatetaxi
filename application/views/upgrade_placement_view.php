
<div class="container">
<div class="row">
<div class="col-xs-11 col-md-8 col-md-offset-2">

<?php
if($placement_over!=0)
	echo '<div class="alert alert-danger fade in">Placement have been marked as over. Upgradation not possible.</div>';
else
{
	echo '<div class="form-academic">';
	echo '<h3>PLACEMENT UPGRADATION <small><a href="'.base_url().'admin/placement/'.$placement_id.'">'.$placement_name.'</a></small></h3>';

	echo '<form method="POST" action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">';
		echo '<hr>';
		echo '<h5 class="text-primary">ENTER UPGRADATION TYPE</h5>';
		echo '<select name="upgrade_to" id="upgrade_to" class="form-control">';
			$i=1;
			while( $i <= $levels )
			{
				echo '<option value="'.$i.'">Qualify for level '.$i.'</option>';
				$i++;
			}
			echo '<option value="-2">Make user win the placement</option>';
		echo '</select>';
		echo '<br/>';
		echo '<div id="inside_form_holder"></div>';
		echo '<div class="pull-right" style="display:none;" id="read_all_hold"><input type="checkbox" id="read_all"> I understand that I\'m going to change all the above users to the new level.</div><br/>' ;
		echo '<input type="submit" name="submit" id="upgrade_submit" value="UPGRADE ALL" class="btn btn-primary" disabled style="position:absolute; bottom:60px; right:50px;">';
	echo '</form>';
	echo '</div>';//FORM-academic
    echo '<br/><input type="text" list="numbers" id="insert_adm" class="form-control" placeholder="Type admission number, press enter" style="max-width:600px; text-transform:uppercase;">';

    echo '<datalist id="numbers">';
   		mysqli_data_seek($listing,0); 
    	while($row=mysqli_fetch_array($listing))
    		echo '<option value="'.$row['admission_no'].'">';
    echo '</datalist>';

    mysqli_data_seek($listing,0); 
    while($row=mysqli_fetch_array($listing))
    {
    	echo '<div id="hold_'.$row['admission_no'].'" style="display:none;">';
    	echo '<div id="inner_hold_'.$row['admission_no'].'">';
    		echo '<table class="table table-bordered">';
	    	echo '<input type="hidden" value="1" name="'.$row['user_id'].'" id="hold_hidden_'.$row['admission_no'].'">';
	    	echo '<tr><td>'.$row['name'].'</td> <td>'.$row['admission_no'].'</td> <td>'.$row['class'].'</td> <td>'.$row['gender'].'</td> '; 
	    		if($row['status']!="-2")
	    			echo '<td><strong>Qualified for level '.$row['status'].'</strong>'; 
	    		else
	    			echo '<td><strong>Won placement</strong>'; 
	    		echo '<br/><strong status="'.$row['status'].'" class="warning_portion text-danger"></strong>';
	    	echo '</td> <td><span class="btn btn-default remove-button" to_remove="hold_'.$row['admission_no'].'" >Remove</span></td></tr>'; 	
			echo '</table>';
	    echo '</div>';//inner hold

    	echo '</div>';//hold
    }
	

?>
	<script type="text/javascript">
	var admission_no="";
	var value="";
	var levels=<?php echo $levels;?>;
	levels=parseInt(levels);
	upgrade_to_change();
	$(document).ready(function(){
		$('#insert_adm').change(function(){
			admission_no=$(this).val().toUpperCase();;
			$(this).val("");
			if( !$('#hold_'+admission_no).get(0) )
			{
				$('#inside_form_holder').append( return_error(admission_no) );
			}
			else if( $('#hold_hidden_'+admission_no).parents('#inside_form_holder').length )
			{
				$('#inside_form_holder').append( return_already(admission_no) );
			}
			else
			{
				value = $('#hold_'+admission_no).html();
				$('#inside_form_holder').append( value );
				$("#read_all_hold").show(500);
			}
				$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		});

		$(document).on('click','.remove-button',function(){
			var remove= $(this).attr('to_remove');
			$('#inside_form_holder').find('#inner_'+remove).html("");
		});

		$('#read_all').change(function(){
		if($(this).prop('checked') == true)
			$("#upgrade_submit").prop('disabled',false);
		else
			$("#upgrade_submit").prop('disabled',true);
		});
	});

	$('#upgrade_to').change(function(){
		upgrade_to_change();
	});

	function upgrade_to_change()
	{
		var upgrade_to = parseInt($('#upgrade_to').val());
		$('.warning_portion').each(function(){
			var status=parseInt($(this).attr('status'));
			if(status==-2)
			{
				$(this).html("The user has <br/>already won.");
			}
			else if( status == upgrade_to )
			{
				$(this).html("The user is already<br/> qualified for Level "+status);
			}
			else if(upgrade_to==-2 && status!=levels)
			{
				$(this).html("The user is ONLY<br/> qualified for Level "+status+"<br/> You are skipping levels");
			}
			else if(upgrade_to==-2 && status==levels)
			{
				$(this).html("");
			}
			else if(status > upgrade_to && status!=-2)
			{
				$(this).html("The user is already<br/> qualified for Level "+status+"<br/>You are downgrading.");
			}
			else if(status !=upgrade_to-1)
			{
				$(this).html("The user is ONLY<br/> qualified for Level "+status+"<br/> You are skipping levels");
			}
			else
			{
				$(this).html("");
			}
		});
	}
	function return_error(admission_no)
	{
		var error='<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'+admission_no+'</strong> -  User not found / is not eligible to be upgraded.</div>';
		return error;
	}
	function return_already(admission_no)
	{
		var error='<div class="alert alert-info fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'+admission_no+'</strong> -  User already added in the list.</div>';
		return error;
	}
	</script>
<?php

}//Super else...Nothing after it
?>

</div><!-- col classes -->
</div><!-- row class -->
</div><!-- container class -->