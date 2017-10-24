<?php
class Log_out_model extends CI_Model {

  public function __construct()
        {
        	$array_items = array('user_id', 'name', 'type', 'admission_no');
        	if($this->session->has_userdata('user_id'))
				$this->session->unset_userdata($array_items);
			
			if(isset($_COOKIE['machine_id']))
			{
				$this->db->simple_query('DELETE FROM `cookie` WHERE machine_id="'.$_COOKIE['machine_id'].'"');
				setcookie("user_id", "", time()-3600);
				setcookie("machine_id", "", time()-3600);
				setcookie("code", "", time()-3600);

			}
        }
 }