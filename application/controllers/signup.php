<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {


	public function index()
	{
		$data['title']="Signup | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$this->load->model('log_out_model'); 

		$this->load->view('head',$data);
		$this->load->view('signup_select_view',$data);
		$this->load->view('foot',$data);
	}

	public function candidate()
	{
		$this->load->helper('form');
		$data['title']="Signup | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$data['dob_pick']=1;
		$this->load->model('class_convertion_model');
		$data['classes'] = $this->class_convertion_model->get_all_unhidden();
		$this->load->model('log_out_model'); 
		$this->load->view('head',$data);
		$data['result']=array("NULL","");
		if(isset($_POST['submit']))
		{
			$this->load->model('signup_model');
			$data['result']=$this->signup_model->candidate();
		}

		$this->load->view('signup_candidate_view',$data);
		$this->load->view('js_signup_candidate_view');
		$this->load->view('foot',$data);
	}

	public function volunteer()
	{
		$this->load->helper('form');
		$this->load->model('class_convertion_model');
		$data['classes'] = $this->class_convertion_model->get_all_unhidden();
		$this->load->model('log_out_model'); 
		$data['title']="Volunteer Signup | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$data['result']=array("NULL","");
		if(isset($_POST['submit']))
		{
			$this->load->model('signup_model');
			$data['result']=$this->signup_model->volunteer();
		}
		$this->load->view('head',$data);
		$this->load->view('signup_volunteer_view',$data);
		$this->load->view('js_signup_volunteer_view');
		$this->load->view('foot',$data);
	}

	public function success($user_id)
	{
		$data['title']="Successful Signup | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$val = $this->db->simple_query('SELECT name,type,admission_no,class,email,email_verified,verified FROM user_table WHERE id="'.$user_id.'" LIMIT 1');
		if(mysqli_num_rows($val)<1)
			{
				$data['title']="User doesn't exist";
				$this->load->view('head',$data);
				$data['no_user']=1;
				$this->load->view('error_view',$data);
				$this->load->view('foot',$data);
				return;
			}
		$row=mysqli_fetch_array($val);
		$data['type']=$row['type'];
		$data['admission_no']=$row['admission_no'];
		$data['email_verified']=$row['email_verified'];
		$data['verified']=$row['verified'];
		$data['name']=$row['name'];

		//NOT NEEDED after 'mail okay'
		$this->load->model('email_model');
		$data['user_id']=$user_id;
		$data['code']=$this->email_model->reget_code($user_id,$row['email'],0);

		$data['class']=$row['class'];

		$this->load->model('log_out_model'); 
		$this->load->view('head',$data);
		$this->load->view('success_signup_view',$data);
		$this->load->view('foot',$data);
	}
}
