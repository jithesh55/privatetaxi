<div class="container">
<div class="row">
<div class="col-xs-11 col-md-10 col-md-offset-1 form-academic">

<?php
echo $res_values;
?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="detailsModal" id="detailsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
   	 	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">DETAILS</h4>
      	</div>
      <div class="modal-body" id="content_inside">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var loader=' <span class="ouro ouro3"><span class="left"><span class="anim"></span></span><span class="right"><span class="anim"></span></span></span> ';

		$('.more_button').click(function(){
			var user_id=$(this).attr('user-id');
			var placement_id=$(this).attr('placement-id');
			$('#content_inside').html('<div style="text-align:center;">'+loader+'</div>');
			//alert('<?php echo base_url();?>admin/ajax_ind_placement/'+placement_id+'/'+user_id);
			$('#content_inside').load('<?php echo base_url();?>admin/ajax_ind_placement/'+placement_id+'/'+user_id+'/hide_details');
		});

		$(document).on('change','#read_all',function(){
		if($(this).prop('checked') == true)
			$("#submit").prop('disabled',false);
		else
			$("#submit").prop('disabled',true);
		});

		$('#search_bar').keyup(function(){
		if($(this).val().length>0)
			{
				$("#search_button").show(200);
				$("#advanced_search_button").hide(200);
			}
		else
			{
				$("#search_button").hide(200);
				$("#advanced_search_button").show(200);
			}
		});
	})
</script>
</div>
</div>
</div>