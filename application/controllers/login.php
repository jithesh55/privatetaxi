<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	public function passenger()
	{
?> <h1>PASSENGER LOGIN</h1><?php
    $this->load->model("login_model");
		$data['title']="Login | PASSENGER";
		//$this->load->model('check_for_cookie'); 

		//$this->load->model('login_model');  to test
		if(isset($_POST['submit']))
		{
          $res=$this->login_model->try_loginp();
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
		
		$this->load->view('head',$data);
		//if($this->session->has_userdata('id'))
		
		$this->load->view('login_view',$data);
		$this->load->view('foot',$data);
	}
    public function driver()
    {
        ?> <h1>DRIVER LOGIN</h1><?php
        		$data['title']="Login | DRIVER";
		//$this->load->model('check_for_cookie'); 

		//$this->load->model('login_model'); to test
		if(isset($_POST['submit']))
		{
            
			$res=$this->login_model->try_logind();
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
    public function successp()
    {
        
        $this->load->view('head');
		
		
		$this->load->view('passenger_home');
		$this->load->view('foot');
    }
}
