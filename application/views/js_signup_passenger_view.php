<script type="text/javascript">
var psw=0;
var r_psw=0;
	$(document).ready(function(){

	        $("#admission_no").change(function(){
	        	$("#admn_fbk").load("<?php echo base_url();?>ajax_controller/admn_fbk/V-"+$(this).val());
	        });
	        $("#password").change(function(){
	        	if($(this).val().length<5)
	        	{
	        		psw=0;
	        		$("#psw_fbk").show(500);
	        	}
	        	else
	        	{
	        		psw=1;
	        		$("#psw_fbk").hide(500);
	        	}
	        });

	        $("#r_password").change(function(){
	        	if($(this).val() != $("#password").val())
	        	{
	        		r_psw=0;
	        		$("#r_psw_fbk").show(500);
	        	}
	        	else
	        	{
	        		r_psw=1;
	        		$("#r_psw_fbk").hide(500);
	        	}
	        });
	});
</script>