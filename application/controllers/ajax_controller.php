<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_controller extends CI_Controller {

	public function admn_fbk($admission_no){
		$var=$this->db->simple_query('SELECT id,verified, email_verified FROM user_table WHERE admission_no="'.$admission_no.'"');
		if($row=mysqli_fetch_array($var))
		{
			if($row['verified']==1)
				echo '<strong>Error! </strong>User already registered and verified.';
			else
				echo '<strong>Error!</strong> User already registered but haven\'t verified . <br/><a href="'.base_url().'signup/success/'.$row['id'].'">Click here</a> to know the remaining steps to verify';
		}
		echo '';

	}
}