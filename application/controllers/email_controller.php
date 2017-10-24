<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_controller extends CI_Controller {

  public function index()
        {
        	echo 'Access Forbidden';
        }
  public function verify($user_id=NULL,$code=NULL)
  	{
  		if($user_id==NULL || $code==NULL)
  		{
  				$data['title']="403";
  				$this->load->view('head',$data);
				$data['e403']=1;
				$this->load->view('error_view',$data);
				$this->load->view('foot',$data);
				return;
  		}
  		$data['title']="Email verify";
  		$data['verej']="verify";
  		$this->load->model('email_model');
  		$res = $this->email_model->check_code($user_id,$code);
  		$data['res']=$res;
  		$data['final']=$this->email_model->email_verify($user_id,$code);
  		$data['user_id']=$user_id;

  		$this->load->view("head",$data);
  		$this->load->view("email_verej_view",$data);
  		$this->load->view("foot",$data);

  	}

  	public function reject($user_id=NULL,$code=NULL)
  	{
  		if($user_id==NULL || $code==NULL)
  		{
  				$data['title']="403";
  				$this->load->view('head',$data);
				$data['e403']=1;
				$this->load->view('error_view',$data);
				$this->load->view('foot',$data);
				return;
  		}
  		$data['title']="Email reject";
  		$data['verej']="reject";
  		$this->load->model('email_model');
  		$res = $this->email_model->check_code($user_id,$code);
  		$data['res']=$res;
  		$data['final']=$this->email_model->email_reject($user_id,$code);
  		$data['user_id']=$user_id;

  		$this->load->view("head",$data);
  		$this->load->view("email_verej_view",$data);
  		$this->load->view("foot",$data);
  	}
 }