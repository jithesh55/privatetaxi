<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller {

	public function check_status()
	{

		$this->load->model('check_for_cookie'); 
		if(!$this->session->has_userdata('type'))
		{
			header('Location:'.base_url());
			exit();
		}
		
		else 
			if ( !($this->session->type=='volunteer' || $this->session->type=='candidate' ) ) {
				header('Location:'.base_url());
				exit();
			}
	}

	public function index()
	{
		$this->check_status();
		$data['title']="Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$this->load->model('check_for_cookie'); 
		$data['result']=array();

		if(isset($_POST['change_pw']))
		{
			$this->load->model('login_model');
			$result=$this->login_model->change_password();
			$data['result']=$result;
		}

		$this->load->view('head',$data);
		$this->load->view('change_password_view',$data);
		$this->load->view('foot',$data);
	}

}
