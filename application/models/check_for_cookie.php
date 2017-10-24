<?php
class Check_for_cookie extends CI_Model {

  public function __construct()
        {
        	if(!$this->session->has_userdata('user_id'))
        	{
        		if(isset($_COOKIE['user_id']) && isset($_COOKIE['code']) && isset($_COOKIE['machine_id']))
        		{
        			$query='SELECT id FROM cookie WHERE code="'.$_COOKIE['code'].'" AND machine_id="'.$_COOKIE['machine_id'].'" AND user_id="'.$_COOKIE['user_id'].'" LIMIT 1';
        			//$values=array(,$_COOKIE['machine_id'],$_COOKIE['user_id']);
        			$val=$this->db->simple_query($query);
        			if(mysqli_num_rows($val)==1)
        			{
        				$user_id = $_COOKIE['user_id'];
        				$val=$this->db->simple_query('SELECT name, type, admission_no FROM user_table WHERE id="'.$user_id.'"');
        				$row=mysqli_fetch_array($val);
        				$this->session->user_id = $user_id;
        				$this->session->name = $row['name'];
        				$this->session->type = $row['type'];
        				$this->session->admission_no = $row['admission_no'];

        				$this->db->simple_query('DELETE FROM `last_login` WHERE `user_id`="'.$user_id.'"');
						$this->db->simple_query('INSERT INTO `last_login`( `ip`, `user_id`,`from_cookie`, `timestamp`) VALUES ('.$_SERVER['REMOTE_ADDR'].',"'.$user_id.'",1,NOW())');

        			}
        		}
        	}
		}

}