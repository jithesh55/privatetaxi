<?php
class Email_model extends CI_Model {

	public function send($msg,$to)
	{
		$subject = 'Website Change Request';

		$message=$msg;
		$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
		$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		  

		if(mail($to, $subject, $message, $headers))
			return 1;
		else 
			return 0;
	}

	public function create_verification_link($user_id,$email,$type)
	{
		$code = sha1(uniqid());
		$uniq=uniqid();
		$this->db->simple_query('DELETE FROM email_table WHERE user_id="'.$user_id.'" AND $email="'.$email.'"');
		$data = array(
		   'user_id' => $user_id,
		   'code' => $code,
		   'type' => $type,
		   'email' => $email,
		   'timestamp' => date("Y-m-d H:i:s") 

			);
		$this->db->insert('email_table', $data);

	}
	public function reget_code($user_id,$email,$type)
	{
		$val = $this->db->simple_query('SELECT code FROM email_table WHERE user_id="'.$user_id.'" AND email="'.$email.'" AND type="'.$type.'"');
		if(mysqli_num_rows($val)<1)
			return NULL;
		else
		{
			$row=mysqli_fetch_array($val);
			return $row['code'];
		}
	}
	public function check_code($user_id,$code)
	{
		$val = $this->db->simple_query('SELECT code,type FROM email_table WHERE user_id="'.$user_id.'" AND code="'.$code.'"');
		if(mysqli_num_rows($val)<1)
		{
			$res=array("error","");
			return $res;
		}
		else
		{
			$row=mysqli_fetch_array($val);
			$res=array("success",$row['type']);
			return $res;
		}
	}
	public function remove_code($user_id,$code)
	{
		$this->db->simple_query('DELETE FROM email_table WHERE user_id="'.$user_id.'" AND code="'.$code.'"');
	}

	public function email_verify($user_id,$code)
	{
		$val=$this->db->simple_query('SELECT email FROM email_table WHERE user_id="'.$user_id.'" AND code="'.$code.'"');
		$this->remove_code($user_id,$code);
		if($row=mysqli_fetch_array($val))
		{
			$this->db->simple_query('UPDATE user_table SET email_verified="1" WHERE id="'.$user_id.'" AND email="'.$row['email'].'"');
				return $row['email'];

		}
		return NULL;
	}

	public function email_reject($user_id,$code)
	{
		$val=$this->db->simple_query('SELECT email FROM email_table WHERE user_id="'.$user_id.'" AND code="'.$code.'"');
		$this->remove_code($user_id,$code);
		if($row=mysqli_fetch_array($val))
		{
			$this->db->simple_query('DELETE FROM user_table WHERE id="'.$user_id.'"');
				return $row['email'];

		}
		return NULL;
	}
 }