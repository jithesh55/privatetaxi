<?php
class Log_out_model extends CI_Model {

  public function logmeout($data=NULL)
        {
        	$array_items = array('user_id', 'name', 'type', 'admission_no');
			$this->session->unset_userdata($array_items);
			
			if($data==NULL)
			{
				if(isset($_COOKIE['machine_id']))
				{
					$this->db->simple_query('DELETE FROM `cookie` WHERE machine_id="'.$_COOKIE['machine_id'].'"');
					setcookie("user_id", "", time()-3600);
					setcookie("machine_id", "", time()-3600);
					setcookie("code", "", time()-3600);

				}
			}
			
        }

      public function switchme()
      {
      	if($this->session->has_userdata('user_id'))
      	{
      		if($this->session->type=="volunteer")
			{
				$array=explode('-', $this->session->admission_no);
				echo $array[1];
				$val=$this->db->simple_query('SELECT * FROM user_table WHERE admission_no="'.$array[1].'" AND type="candidate" AND verified="1"');
				if(mysqli_num_rows($val)==1)
				{
					$row=mysqli_fetch_array($val);
					$this->session->user_id=$row['id'];
					$this->session->name=$row['name'];
					$this->session->type=$row['type'];
					$this->session->admission_no=$row['admission_no'];

				}
			}
			else if($this->session->type=="candidate")
			{
				$val=$this->db->simple_query('SELECT * FROM user_table WHERE admission_no="V-'.$this->session->admission_no.'" AND type="volunteer" AND verified="1"');
				if(mysqli_num_rows($val)==1)
				{
					$row=mysqli_fetch_array($val);
					$this->session->user_id=$row['id'];
					$this->session->name=$row['name'];
					$this->session->type=$row['type'];
					$this->session->admission_no=$row['admission_no'];

				}
			}
      	}
      }
 }