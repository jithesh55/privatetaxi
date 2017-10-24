<?php
class Login_model extends CI_Model {

	public function change_password()
	{
		if( !isset($_POST['current_password']) || !isset($_POST['new_password']) || !isset($_POST['r_new_password']) )
		{
			$data=array("error","Fill in all credentials");
			return $data;
		}
		else if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['r_new_password']))
		{
			$data=array("error","Fill in all credentials");
			return $data;
		}
		else if( strlen($_POST['new_password'])< 8 )
		{
			$data=array("error","New password should be atleast 8 characters");
			return $data;
		}
		else if( $_POST['new_password']!= $_POST['r_new_password'] )
		{
			$data=array("error","New password and retyped password, doesn't match");
			return $data;
		}
		$admission_no = $this->session->admission_no;
		if($this->session->type=="volunteer")
		{
			$isVolunteer=1;
		}
		else if($this->session->type=="candidate")
		{
			$val2 = $this->db->simple_query('SELECT id FROM user_table WHERE admission_no="V-'.$this->session->admission_no.'"');
		 	if(mysqli_num_rows($val2)>0)
		 	{
		 			$admission_no = 'V-'.$admission_no;
		 			$isVolunteer=1;
		 	}
		}
		$val=$this->db->simple_query('SELECT id,name,admission_no, type, password, verified, email_verified FROM user_table WHERE admission_no="'.$admission_no.'" LIMIT 1');
		//echo 'SELECT id,name,admission_no, type, password, verified, email_verified FROM user_table WHERE admission_no="'.$admission_no.'" LIMIT 1';
		$row=mysqli_fetch_array($val);
		$hash=$row['password'];
		$user_id=$row['id'];
		$password = $_POST['current_password'];
		if (password_verify($password, $hash))
		{
			$new_password= password_hash($_POST['new_password'], PASSWORD_BCRYPT);
			if(isset($isVolunteer))
			{
				$admission_no_arr = explode("-", $admission_no);
				$admission_no = $admission_no_arr[1];
			}
			$val= $this->db->simple_query('UPDATE user_table SET password="'.$new_password.'" WHERE admission_no="'.$admission_no.'" OR admission_no="V-'.$admission_no.'"');
			$data=array("success","Password changed successfully");
			return $data;
		}
		else
		{
			$data=array("error","Incorrect current password");
			return $data;
		}
	}
	
	public function try_login()
	{
		$username=strtoupper(trim($_POST['username']));
		$password=trim($_POST['password']);
		$remember=0;

		/*Starting to remove existing account*/
		$this->load->model('log_out_model');
		/* Finished removing existing account*/

		if(isset($_POST['remember']))
			if($_POST['remember']=='yes')
				$remember=1;
		if(empty($username) || empty($password))
			return 30;
		$val=$this->db->simple_query('SELECT id,name,admission_no, type, password, verified, email_verified FROM user_table WHERE admission_no="'.$username.'" LIMIT 1');
		if(mysqli_num_rows($val)<1)
			return 10;
		else
		{
			$row=mysqli_fetch_array($val);
			$hash=$row['password'];
			$user_id=$row['id'];
			$type=$row['type'];
			$val=$this->db->simple_query('SELECT id FROM login_fail_log WHERE user_id="'.$user_id.'"');
			if(mysqli_num_rows($val)>10)
				return 90;
			else
			{
				if (password_verify($password, $hash))
				{
					$this->db->simple_query('DELETE FROM `login_fail_log` WHERE user_id="'.$user_id.'"');
					if($row['email_verified']!=1 || $row['verified']!=1) //NEW THING
					{
						header('Location:'.base_url().'signup/success/'.$user_id);
						return;
					}
					
					/*if($row['email_verified']!=1)
						return 54;
					else if($row['verified']!=1)
						return 45;
					*/ // DEPRECIATED

					else
					{
						$this->session->user_id = $user_id;
						$this->session->name = $row['name'];
						$this->session->type = $type;
						$this->session->admission_no = $row['admission_no'];
						$this->db->simple_query('DELETE FROM `last_login` WHERE `user_id`="'.$user_id.'"');
						$this->db->simple_query('INSERT INTO `last_login`( `ip`, `user_id`, `timestamp`) VALUES ('.$_SERVER['REMOTE_ADDR'].',"'.$user_id.'",NOW())');

						if($remember==1)
						{
							$machine_id=uniqid();
							$code=uniqid().uniqid().uniqid();
							$this->db->simple_query('INSERT INTO `cookie`( `code`, `machine_id`, `user_id`) VALUES ("'.$code.'","'.$machine_id.'","'.$user_id.'")');
							setcookie("user_id", $user_id,time() + ( 60 * 24 * 60 * 60)); 
							setcookie("code", $code,time() + ( 60 * 24 * 60 * 60)); 
							setcookie("machine_id", $machine_id,time() + ( 60 * 24 * 60 * 60)); 
						}
						return 98;
					}

				}
				else
				{
					$this->db->simple_query('INSERT INTO `login_fail_log`( `ip`, `user_id`, `time`) VALUES ("'.$_SERVER['REMOTE_ADDR']
.'","'.$user_id.'",NOW())');
					return 20;
				}

			}
		}

	}	

}