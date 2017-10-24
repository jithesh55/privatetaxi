<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {


	public function index()
	{
		$data['title']="Signup |PRIVATE TAXI PASSENGER";
	//	$this->load->model('log_out_model'); 

		$this->load->view('head',$data);
		$this->load->view('signup_select_view',$data);
		$this->load->view('foot',$data);
	}

	public function candidate()
	{
		$this->load->helper('form');
		$data['title']="Signup |PRIVATE TAXI PASSENGER";
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

	public function passenger()
	{
		$this->load->helper('form');
		//$this->load->model('class_convertion_model');
		//$data['classes'] = $this->class_convertion_model->get_all_unhidden();
		//$this->load->model('log_out_model'); 
		$data['title']="Signup |PRIVATE TAXI PASSENGER";
		$data['result']=array("NULL","");
		if(isset($_POST['submit']))
		{
			$this->load->model('signup_model');
			$data['result']=$this->signup_model->volunteer();
		}
		$this->load->view('head',$data);
		$this->load->view('signup_passenger_view',$data);
		$this->load->view('js_signup_passenger_view');
		$this->load->view('foot',$data);
	}

	public function success($data)
	{
		$data['title']="Signup |PRIVATE TAXI PASSENGER";
		/*$val = $this->db->simple_query('SELECT name_p,mail_p FROM passenger WHERE mail_p="'.$email.'" LIMIT 1');
		if(mysqli_num_rows($val)<1)
			{
				$data['title']="User doesn't exist";
				$this->load->view('head',$data);
				$data['no_user']=1;
				//$this->load->view('error_view',$data);
				$this->load->view('foot',$data);
				return;
			}
		$row=mysqli_fetch_array($val);
		//$data['type']=$row['type'];
		//$data['admission_no']=$row['admission_no'];
		$data['email']=$row['mail_p'];
		
		$data['name']=$row['name_p'];
        
		
		//$this->load->model('log_out_model'); 
    
*/	    $name=$data[name];
        $this->load->view('head',$data);
		$this->load->view('success_signup_view',$name);
		$this->load->view('foot',$data);
	}
}
