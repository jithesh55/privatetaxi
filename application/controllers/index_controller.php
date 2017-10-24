<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_controller extends CI_Controller {


	public function index()
	{
		
		$data['title']="Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$this->load->model('check_for_cookie'); 

		$this->load->view('head',$data);
		$this->load->view('front_page_special',$data);
		$this->load->view('foot',$data);
	}

}
