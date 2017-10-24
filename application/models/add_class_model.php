<?php
class Add_class_model extends CI_Model {

	public function check()
	{
		if(!isset($_POST['course']) || !isset($_POST['year']) || !isset($_POST['branch']) || !isset($_POST['batch']))
		{
			$res=array("error","All credentials required");
			return $res;
		}
		else
		{
			if(empty($_POST['course']) || empty($_POST['year']) || empty($_POST['branch']) || empty($_POST['batch']))
			{
				$res=array("error","All credentials required");
				return $res;
			}
		}
		$course=strtoupper(trim($_POST['course']));
		$year=trim($_POST['year']);
		$branch=trim($_POST['branch']);
		$batch=trim($_POST['batch']);

		$this->load->model('class_convertion_model');
		if($this->class_convertion_model->check_short_name($branch)!=1)
		{
			$res=array("error"," Invalid branch code");
			return $res;
		}

		$class = $course.'-'.$year.'-'.$branch.'-'.$batch;
		$val = $this->db->simple_query('SELECT id FROM class_list WHERE class="'.$class.'" ');
		if(mysqli_num_rows($val)>0)
		{
			$res=array("error","Class <strong>".$class."</strong> already exists");
			return $res;
		}
		$user_id=$this->session->user_id;

		if(!empty($_POST['remark']))
			$remark=trim(strip_tags($_POST['remark']));
		else
			$remark='';

		 $data = array(
		   'class' => $class ,
		   'created_on' => date("Y-m-d H:i:s") ,
		   'created_by' => $user_id,
		   'remark' => $remark
		);
		$this->db->insert('class_list', $data); 
		if(!empty($remark))
			$temp_remark=' ('.$remark.')';
		else
			$temp_remark='';
		$res = array("success","Class <strong>".$class.$temp_remark."</strong> added successfully");
		return $res;

	}
 }