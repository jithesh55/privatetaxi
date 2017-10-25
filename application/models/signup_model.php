<?php
class Signup_model extends CI_Model {

	public function passenger()
	{
		if(!isset($_POST['name']) || !isset($_POST['gender']) || !isset($_POST['password']) || !isset($_POST['r_password']) || !isset($_POST['email']) || !isset($_POST['mobno'] ))
		{
			$res=array("error","Fill in all credentials.");
			return $res;
		} 
		
		//$id=uniqid();
		$name=trim($_POST['name']);
		$gender=trim($_POST['gender']);
        $password=trim($_POST['password']);
        $r_password=trim($_POST['r_password']);
        $email=trim($_POST['email']);
        $mobno=trim($_POST['mobno']);
		$type='passenger';	
    
		if(strlen($password)<5)
			{
				$res=array("error","Password should have atleast 5 characters");
				return $res;
			}
		
			$data = array(
           // 'id' => $id,
		   'name_p' => strtoupper($name) ,
		   'gender_p' => $gender,
		   'password' => $password,
		   'mail_p' => $email,
		   'phone_p' => $mobno,
			);
			if($this->db->insert('passenger', $data,$type))
			{
				
				header('Location:'.base_url().'signup/success/'.$data,$type);
				exit();
			}
			else
			{
				$res=array("error","Failed signup, contact admin or try again");
				return $res;
			}



		} //volunteer function ends

	




 }