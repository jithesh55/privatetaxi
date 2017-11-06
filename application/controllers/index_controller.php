<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_controller extends CI_Controller {


	public function index()
	{
		
		$data['title']="PRIVATE TAXI";
		//$this->load->model('check_for_cookie'); 

		$this->load->view('head',$data);
		$this->load->view('front_page_special',$data);
		$this->load->view('foot',$data);
        $this->load->model('login_model');
             $this->load->model('login_model');
        if(isset($_POST['driver']))
		{
          $res=$this->login_model->try_logind();
		}
		else
			$data['code']=99;
        if(isset($_POST['passenger']))
		{
			
            $res=$this->login_model->try_loginp();
        }
        else
			$data['code']=99;
    
		   
    
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
