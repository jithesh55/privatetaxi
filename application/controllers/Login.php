<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data['title']="Login | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$this->load->model('check_for_cookie'); 

		$this->load->model('login_model');
		if(isset($_POST['submit']))
		{
			$data['code']=$this->login_model->try_login();
		}
		else
			$data['code']=99;
		/*
		code 99 : Not tried login yet
		code 10 : user doesn't exist
		code 90 : failed to login for more than 5 times
		code 20 : password error
		code 30 : Any/both of UN or PW is empty
		code 45 : User not yet verified
		code 54 : User email not verified
		code 98 : User OK and all set
		*/
		if($data['code']==98)
			header('Location:'.base_url());
		
		$this->load->view('head',$data);
		//if($this->session->has_userdata('id'))
		
		$this->load->view('login_view',$data);
		$this->load->view('foot',$data);
	}
}
