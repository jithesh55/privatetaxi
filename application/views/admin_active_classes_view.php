
<div class="container">
<hr>
<div class="row">
<div class="col-xs-11 col-md-8 col-md-offset-2">
	<div class="form-academic">
	<a href="<?php echo base_url();?>admin/addclass" class="btn btn-primary pull-right">Add class</a>
<?php
		$this->load->model('class_convertion_model');
		$val=$this->db->simple_query('SELECT class,remark FROM class_list ');
		echo '<h5 class="text-primary">ACTIVE CLASSES</h5>';
		echo '<table class="table table-hover">';
		while($row=mysqli_fetch_array($val))
		{
			echo '<tr> <th>'.$row['class'];
			if(!empty($row['remark']))
				echo ' ('.$row['remark'].')';
			echo '</th> <td>'.$this->class_convertion_model->decode_class($row['class']);
			echo '</td> </tr>';
		}
		echo '</table>';

?>
	</div>


</div>
</div>
</div>