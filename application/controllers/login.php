<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	public function passenger()
	{

    $this->load->model("login_model");
		$data['title']="Login | PASSENGER";
		if(isset($_POST['submit']))
		{
          $res=$this->login_model->try_loginp();
		}
		else
			$data['code']=99;
		   $this->load->view('head',$data);
	       $this->load->view('front_page_special',$data);
		$this->load->view('foot',$data);
	}
    public function driver()
    {
    
         $this->load->model("login_model");
		$data['title']="Login | DRIVER";
		if(isset($_POST['driver']))
		{
          $res=$this->login_model->try_logind();
		}
		else
			$data['code']=99;
		   $this->load->view('head',$data);
	      $this->load->view('front_page_special',$data);
		$this->load->view('foot',$data);
    }
    public function successp()
    {
        
        $this->load->view('head');
		
		
		$this->load->view('passenger_home');
		$this->load->view('foot');
    }
    
        public function successd()
    {
        
        $this->load->view('head');
		
		
		$this->load->view('driver_home');
		$this->load->view('foot');
    }
}
