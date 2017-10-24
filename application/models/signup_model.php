<?php
class Signup_model extends CI_Model {

	public function volunteer()
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
			if($this->db->insert('passenger', $data))
			{
				
				header('Location:'.base_url().'signup/success/'.$data);
				exit();
			}
			else
			{
				$res=array("error","Failed signup, contact admin or try again");
				return $res;
			}



		} //volunteer function ends

	public function candidate()
	{
		if(!isset($_POST['name']) || !isset($_POST['gender']) || !isset($_POST['admission_no']) || !isset($_POST['password']) || !isset($_POST['r_password']) || !isset($_POST['email']) || !isset($_POST['mobno']) || !isset($_POST['class']) || !isset($_POST['addr_1']) || !isset($_POST['addr_2']) || !isset($_POST['addr_3']) || !isset($_POST['pincode']) || !isset($_POST['res_no'])  || !isset($_POST['dob']) || !isset($_POST['religion']) || !isset($_POST['father_name']) || !isset($_POST['father_occupation']) || !isset($_POST['mother_name']) || !isset($_POST['mother_occupation']) || !isset($_POST['admission_quota']))
		{
			$res=array("error","Fill in all credentials.");
			return $res;
		} 
		if(empty($_POST['name']) || empty($_POST['gender']) || empty($_POST['admission_no']) || empty($_POST['password']) || empty($_POST['r_password']) || empty($_POST['email']) || empty($_POST['mobno']) || empty($_POST['class']) || empty($_POST['addr_1']) || empty($_POST['addr_2']) || empty($_POST['addr_3']) || empty($_POST['pincode']) || empty($_POST['res_no'])  || empty($_POST['dob']) || empty($_POST['religion']) || empty($_POST['father_name']) || empty($_POST['father_occupation']) || empty($_POST['mother_name']) || empty($_POST['mother_occupation']) || empty($_POST['admission_quota']))
		{
			$res=array("error","Fill in all credentials");
			return $res;
		}
		$id=uniqid();
		$name=trim($_POST['name']);
		$admission_no=strtoupper(trim($_POST['admission_no']));

		$val = $this->db->simple_query('SELECT id, verified, email_verified FROM user_table WHERE admission_no="'.$admission_no.'" AND type="candidate"');
		if(mysqli_num_rows($val)>0)
		{
			$row=mysqli_fetch_array($val);
			if($row['email_verified']!=1)
			{
				$res=array("error", "<strong>".$admission_no."</strong> is already registered. Please verify your email first. <br/>If you are sure that you haven't registered, please contact your class volunteer immediately.");
				return $res;
			}
			else if($row['verfied']!=1)
			{
				$res=array("error", "<strong>".$admission_no."</strong> is already registered. Ask your class volunteer to verify you. <br/>If you are sure that you haven't registered, please contact your class volunteer immediately.");
				return $res;
			}
			else
			{
				$res=array("error", '<strong>'.$admission_no.'</strong> is already a verified volunteer. Try <a href="'.base_url().'login">login</a>. <br/> If you are sure that you haven\'t registered, please contact placement officer immediately.');
				return $res;
			}
		}
		else
		{
			$gender=trim($_POST['gender']);
			$password=trim($_POST['password']);
			$r_password=trim($_POST['r_password']);
			$email=trim($_POST['email']);
			$mobno=trim($_POST['mobno']);
			$class = trim($_POST['class']);

			if(strlen($password)<5)
			{
				$res=array("error","Password should have atleast 5 characters");
				return $res;
			}
			if($password!=$r_password)
			{
				$res=array("error","Passwords should match");
				return $res;
			}
			$val = $this->db->simple_query('SELECT id FROM user_table WHERE email="'.$email.'"  AND type="candidate"');
			if(mysqli_num_rows($val)>0)
			{
				$res=array("error","Please use your own email. <strong>".$email."</strong> is already signed up as a candidate.");
				return $res;
			}
			$val = $this->db->simple_query('SELECT id FROM class_list WHERE class="'.$class.'"');
			if(mysqli_num_rows($val)<1)
			{
				$res=array("error","Invalid class");
				return $res;
			}
			$this->load->model('class_convertion_model');
			$res = $this->class_convertion_model->convert_all($class);
			$course=$res[0];
			$branch=$res[1];
			$division=$res[2];
			
			$addr_1=trim($_POST['addr_1']);
			$addr_2=trim($_POST['addr_2']);
			$addr_3=trim($_POST['addr_3']);
			$pincode=trim($_POST['pincode']);
			$res_no=trim($_POST['res_no']);
			$religion=trim($_POST['religion']);
			$father_name=trim($_POST['father_name']);
			$father_occupation=trim($_POST['father_occupation']);
			$mother_name=trim($_POST['mother_name']);
			$mother_occupation=trim($_POST['mother_occupation']);
			$admission_quota=trim($_POST['admission_quota']);

			$dob=trim($_POST['dob']);
			//$dob_explode=explode('-', $dob);
			//$dob = $dob_explode[2].'-'.$dob_explode[1].'-'.$dob_explode[0];

			$data = array(
		   'id' => $id ,
		   'name' => strtoupper($name) ,
		   'admission_no' => $admission_no,
		   'gender' => $gender,
		   'password' => password_hash($password, PASSWORD_BCRYPT),
		   'email' => $email,
		   'mobno' => $mobno,
		   'class' => $class,
		   'type' => "candidate",
		   'course' => $course,
		   'branch' => $branch,
		   'division' => $division,
		   'addr_1' => strtoupper($addr_1),
		   'addr_2' => strtoupper($addr_2),
		   'addr_3' => strtoupper($addr_3),
		   'pincode' => $pincode,
		   'res_no' => $res_no,
		   'dob' => $dob,
		   'religion' => strtoupper($religion),
		   'father_name' => strtoupper($father_name),
		   'father_occupation' => strtoupper($father_occupation),
		   'mother_name'=> strtoupper($mother_name),
		   'mother_occupation' => strtoupper($mother_occupation),
		   'admission_quota' => $admission_quota,
		   'reg_time' => date("Y-m-d H:i:s"),
            'entrance_rank' => 0
            );

			if($this->db->insert('user_table', $data))
			{
				$this->load->model('email_model');
				$this->email_model->create_verification_link($id,$email,0);
				header('Location:'.base_url().'signup/success/'.$id);
				exit();
			}
			else
			{
				$res=array("error","Failed signup, contact admin or try again");
				return $res;
			}



		}
	}

	public function edit_candidate()
	{
		if(!isset($_POST['name']) || !isset($_POST['gender']) || !isset($_POST['admission_no']) || !isset($_POST['email']) || !isset($_POST['mobno']) || !isset($_POST['class']) || !isset($_POST['addr_1']) || !isset($_POST['addr_2']) || !isset($_POST['addr_3']) || !isset($_POST['pincode']) || !isset($_POST['res_no'])  || !isset($_POST['dob']) || !isset($_POST['religion']) || !isset($_POST['father_name']) || !isset($_POST['father_occupation']) || !isset($_POST['mother_name']) || !isset($_POST['mother_occupation']) || !isset($_POST['admission_quota']))
		{
			$res=array("error","Fill in all credentials.");
			return $res;
		} 
		if(empty($_POST['name']) || empty($_POST['gender']) || empty($_POST['admission_no']) || empty($_POST['email']) || empty($_POST['mobno']) || empty($_POST['class']) || empty($_POST['addr_1']) || empty($_POST['addr_2']) || empty($_POST['addr_3']) || empty($_POST['pincode']) || empty($_POST['res_no'])  || empty($_POST['dob']) || empty($_POST['religion']) || empty($_POST['father_name']) || empty($_POST['father_occupation']) || empty($_POST['mother_name']) || empty($_POST['mother_occupation']) || empty($_POST['admission_quota']))
		{
			$res=array("error","Fill in all credentials");
			return $res;
		}
		$name=trim($_POST['name']);
		$admission_no=strtoupper(trim($_POST['admission_no']));

		
			$gender=trim($_POST['gender']);
			$email=trim($_POST['email']);
			$mobno=trim($_POST['mobno']);
			$class = trim($_POST['class']);


			$val = $this->db->simple_query('SELECT id FROM class_list WHERE class="'.$class.'"');
			if(mysqli_num_rows($val)<1)
			{
				$res=array("error","Invalid class");
				return $res;
			}
			$this->load->model('class_convertion_model');
			$res = $this->class_convertion_model->convert_all($class);
			$course=$res[0];
			$branch=$res[1];
			$division=$res[2];
			
			$addr_1=trim($_POST['addr_1']);
			$addr_2=trim($_POST['addr_2']);
			$addr_3=trim($_POST['addr_3']);
			$pincode=trim($_POST['pincode']);
			$res_no=trim($_POST['res_no']);
			$religion=trim($_POST['religion']);
			$father_name=trim($_POST['father_name']);
			$father_occupation=trim($_POST['father_occupation']);
			$mother_name=trim($_POST['mother_name']);
			$mother_occupation=trim($_POST['mother_occupation']);
			$admission_quota=trim($_POST['admission_quota']);

			$dob=trim($_POST['dob']);

			$data = array(
		   'name' => strtoupper($name) ,
		   'admission_no' => $admission_no,
		   'gender' => $gender,
		   'email' => $email,
		   'mobno' => $mobno,
		   'class' => $class,
		   'type' => "candidate",
		   'course' => $course,
		   'branch' => $branch,
		   'division' => $division,
		   'addr_1' => strtoupper($addr_1),
		   'addr_2' => strtoupper($addr_2),
		   'addr_3' => strtoupper($addr_3),
		   'pincode' => $pincode,
		   'res_no' => $res_no,
		   'dob' => $dob,
		   'religion' => strtoupper($religion),
		   'father_name' => strtoupper($father_name),
		   'father_occupation' => strtoupper($father_occupation),
		   'mother_name'=> strtoupper($mother_name),
		   'mother_occupation' => strtoupper($mother_occupation),
		   'admission_quota' => $admission_quota,
		   'reg_time' => date("Y-m-d H:i:s"),
            'entrance_rank' => 0
			);

			$this->db->where('id',$_POST['id']);
			$this->db->update('user_table', $data);
			$res=array("success","Successfully Edited ");
			return $res;


		
	}





 }