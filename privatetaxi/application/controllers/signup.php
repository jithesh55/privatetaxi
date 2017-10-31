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
public function driver()
{
    
   	$this->load->helper('form');
		
		$data['title']="Signup |PRIVATE TAXI PASSENGER";
		$data['result']=array("NULL","");
		if(isset($_POST['submit']))
		{
			$this->load->model('signup_model');
			$data['result']=$this->signup_model->driver();
		}
		$this->load->view('head',$data);
		$this->load->view('signup_driver_view',$data);
		$this->load->view('js_signup_view');
		$this->load->view('foot',$data); 
    
}
	public function passenger()
	{
		$this->load->helper('form');
		
		$data['title']="Signup |PRIVATE TAXI PASSENGER";
		$data['result']=array("NULL","");
		if(isset($_POST['submit']))
		{
			$this->load->model('signup_model');
			$data['result']=$this->signup_model->passenger();
		}
		$this->load->view('head',$data);
		$this->load->view('signup_passenger_view',$data);
		$this->load->view('js_signup_view');
		$this->load->view('foot',$data);
	}

	public function success($data)
	{
	    
        $this->load->view('head',$data);
		$this->load->view('success_signup_view',$data);
		$this->load->view('foot',$data);
	}
    public function success1($data)
	{
	    
        $this->load->view('head',$data);
		$this->load->view('success_signup_view1',$data);
		$this->load->view('foot',$data);
	}
}
