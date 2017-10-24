<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$this->load->model('log_out_model');
		$this->log_out_model->logmeout();
		header('Location:'.base_url());
	}

	public function switchme()
	{
		$this->load->model('log_out_model');
		$this->log_out_model->switchme();
		if($this->session->type=="candidate")
			header('Location:'.base_url().'/candidate');
		else if($this->session->type=="volunteer")
			header('Location:'.base_url().'/volunteer');
	}

}
