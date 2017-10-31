<?php
     
class login_model extends CI_Model {
      public function __construct()
    {
            $this->load->database();
    }

	public function try_loginp()
	{

	   if(!isset($_POST['username']) || !isset($_POST['password']) )
          {
			array("error","Fill in all credentials.");
           $res='';
			//return $res;
		  } 
    else
        {
        $username=trim($_POST['username']);
        $password=$_POST['password'];
        $val=$this->db->simple_query('SELECT * FROM passenger WHERE mail_p="'.$username.'" and password="'.$password.'" LIMIT 1');
		if(mysqli_num_rows($val)<1)
			return 10;
		$this->session->mail_p = $username;
        $res=$username;
        //var_dump($_SESSION)
       // return $res;
        header('Location:'.base_url().'login/successp/');

     }
     }
  	public function try_logind()
	{

	   if(!isset($_POST['username']) || !isset($_POST['password']) )
          {
			array("error","Fill in all credentials.");
           $res='';
			//return $res;
		  } 
    else
        {
        $username=trim($_POST['username']);
        $password=$_POST['password'];
        $val=$this->db->simple_query('SELECT * FROM driver WHERE mail_d="'.$username.'" and password="'.$password.'" LIMIT 1');
		if(mysqli_num_rows($val)<1)
			return 10;
		$this->session->mail_d = $username;
        $res=$username;
        //var_dump($_SESSION)
       // return $res;
        header('Location:'.base_url().'login/successd/');

     }
     }  
    
    
    
    
    
    
}
?> 