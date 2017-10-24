<?php
class Volunteer_model extends CI_Model {
	
		public function get_unverified_candidates()
		{
			  	$val = $this->db->simple_query('SELECT * FROM user_table WHERE type="candidate" AND verified="0" AND class="'.$this->get_class().'" ORDER BY email_verified DESC');
			  	$var='<tr><th>Name</th> <th>Admission Number</th> <th>Gender</th> <th>Email</th> <th>Mobile number</th> <th>Registration Time</th>  <th>Action</th> </tr>';
			  	$res=array();
			  	array_push($res, $var);
			  	while($row = mysqli_fetch_array($val))
			  	{
			  		array_push($res , $this->single_unverified_candidate_row($row));
			  	}
			  	return $res;
		}
		public function verify_academic($id,$user_id)
		{
			$this->load->model('academic_model');
			$val= $this->db->simple_query('SELECT course, btech_type FROM user_table WHERE id="'.$user_id.'"');
			$row=mysqli_fetch_array($val);
			$individuals = $this->academic_model->get_individuals($row['course'], $row['btech_type']);
			$pairs = $this->academic_model->get_pairs($row['course'], $row['btech_type']);
			array_push($individuals, 'ARREAR_LAST');
			array_push($individuals, 'ARREAR_HISTORY');

			$val= $this->db->simple_query('SELECT * FROM update_academic WHERE id="'.$id.'" AND user_id="'.$user_id.'"');
			$row=mysqli_fetch_array($val);

			$string="";
			foreach ($individuals as $ind) {
				if($row[$ind]!=NULL)
					$string= $string. ' `'.$ind.'`="'.$row[$ind].'",';
				else
					$string= $string. ' `'.$ind.'`=NULL,';
			}
			foreach ($pairs as $pair) {
				$temp=array("-percent","-CGPA");
				foreach ($temp as $temp_val) {
					$ind= $pair.$temp_val;
					if($row[$ind]!=NULL)
						$string= $string. ' `'.$ind.'`="'.$row[$ind].'",';
					else
						$string= $string. ' `'.$ind.'`=NULL,';
				}
			}

					$i=0; //AGGREGATE calculation
					$aggregate=array();
					$temp=array("-percent","-CGPA");
					foreach ($temp as $temp_val) {
						$value=0; $num=0; 
						foreach($pairs as $pair)
						{
								$ind= $pair.$temp_val;
								if($row[$ind]!=NULL)
								{
									$value=$value+$row[$ind];
									$num++;
								}
								else 
									break;
						}
						$aggregate[$i++]=$value/$num;
					}
					if(!empty($_POST['aggr_percent_1']))
						$string= $string.' `aggr-percent`="'.trim($_POST['aggr_percent_1']).'",';
					else
						$string= $string.' `aggr-percent`="'.$aggregate[0].'",';
					//$string= $string.' `aggr-CGPA`="'.$aggregate[1].'"';
					//$string= $string.' `aggr-percent`="'.trim($_POST['aggr_percent_1']).'",';
					$string= $string.' `aggr-CGPA`="'.trim($_POST['aggr_cgpa_1']).'"';
					
			$this->db->simple_query('UPDATE user_table SET'.$string.' WHERE id="'.$user_id.'"');
			$this->db->simple_query('DELETE FROM update_academic WHERE id="'.$id.'"');
			header('Location:'.base_url().'volunteer/academic_verify');
		}
		public function get_class()
		{
		  	$val = $this->db->simple_query('SELECT class FROM user_table WHERE id="'.$this->session->user_id.'"');
			$row = mysqli_fetch_array($val);
			return $row['class'];
		}
	  public function get_unverified_candidates_num()
	  {
	  	$val=$this->db->simple_query('SELECT id FROM user_table WHERE type="candidate" AND verified="0" AND class="'.$this->get_class().'"');
	  	return (mysqli_num_rows($val));
	  }
	  public function get_to_verify_academic()
	  {
	  	$val=$this->db->simple_query('SELECT class FROM user_table WHERE id="'.$this->session->user_id.'" AND type="volunteer"');
	  	$row=mysqli_fetch_array($val);
	  	$class=$row['class'];
	  	$val=$this->db->simple_query('SELECT a.id,a.name, a.gender, a.admission_no FROM user_table a, update_academic b WHERE a.id=b.user_id AND a.class="'.$class.'"');
	  	$result= array( mysqli_num_rows($val), $val);
	  	return $result;

	  }
	  public function get_all_to_verify($user_id)
	  {
	  	$val=$this->db->simple_query('SELECT class FROM user_table WHERE id="'.$this->session->user_id.'" AND type="volunteer"');
	  	$row=mysqli_fetch_array($val);
	  	$class=$row['class'];

	  	$existing=$this->db->simple_query('SELECT * FROM user_table WHERE id="'.$user_id.'" AND class="'.$class.'"');
	  	$new=$this->db->simple_query('SELECT * FROM update_academic WHERE user_id="'.$user_id.'"');
	  	if( mysqli_num_rows($existing)<1 || mysqli_num_rows($new)<1 )
	  	{
	  		$result=array("error","The user might have revoked the request or you might not have the access to verify.");
	  		return $result;
	  	}
	  	$result=array("success-next",mysqli_fetch_array($existing),mysqli_fetch_array($new));
	  	return $result;
	  }
	  public function get_full_as_table($row)
	  {

	  			$this->load->model('class_convertion_model');
	  			$full_class=$this->class_convertion_model->decode_class($row['class']);
	  			
	  			$temp = '<table class="table table-hover"> <tr><th>Name</th><td>'.$row['name'].'</td></tr> <tr><th>Gender</th><td>'.$row['gender'].'</td></tr> <tr><th>Admission Number</th><td>'.$row['admission_no'].'</td></tr> <tr><th>email</th><td>'.$row['email'].'</td></tr> <tr><th>Class</th><td>'.$full_class.'</td></tr> <tr><th>Reg Time</th><td>'.$row['reg_time'].'</td></tr>  <tr><th>Address </th><td>'.$row['addr_1'].'<br/>'.$row['addr_2'].'<br/>'.$row['addr_3'].'<br/><strong>Pincode: </strong>'.$row['pincode'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mobile Number</th><td>'.$row['mobno'].'</td></tr>';
	  			$dob = explode('-', $row['dob']); $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
	  			$temp = $temp.' <tr><th>Date of Birth</th><td>'.$dob.'</td></tr>';
	  			$temp = $temp.' <tr><th>Residential Phone</th><td>'.$row['res_no'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Religion</th><td>'.$row['religion'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Father\'s Name</th><td>'.$row['father_name'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Father\'s Occupation</th><td>'.$row['father_occupation'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mother\'s Name</th><td>'.$row['mother_name'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mother\'s Occupation</th><td>'.$row['mother_occupation'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Admission Quota</th><td>'.$row['admission_quota'].'</td></tr>';
	  			$temp =$temp.'</table><br/>';	
	  			return $temp;
	  }

	  public function single_unverified_candidate_row( $row , $fail=NULL) 
	  {
	  			$message ="";
	  			$temp = $this->get_full_as_table($row);

	  		if($fail==NULL)
	  			$message = $message.'<tr id="row_'.$row['id'].'">';
	  		$message = $message.'<td>'.$row['name'].'</td>';
	  		$message = $message.'<td>'.$row['admission_no'].'</td>';
	  		$message = $message. '<td>'.$row['gender'].'</td>';
	  		$message = $message. '<td>'.$row['email'].'</td>';
	  		$message = $message. '<td>'.$row['mobno'].'</td>';
	  		$message = $message. '<td>'.$row['reg_time'].'</td>';
	  		/*$message = $message. '<td>';
	  		if($row['email_verified']==1)
	  		{
	  			$message = $message. '<p class="text-success">Email verified</p>';
	  		}
	  		else
	  		{
	  			$message = $message. '<p class="text-danger">Email unverified</p>';
	  		}
	  		$message = $message. '</td>';*/

	  		$message = $message.'<td>';
	  		$message = $message. '<div class="btn-group" id="group_'.$row['id'].'">';
	  			$message = $message. '<div id="h_'.$row['id'].'" style="display:none;">'.$temp.'</div>';
	  		if($fail!=NULL)
	  			$message = $message. '<p class="text-danger">Failed action</p>';
	  		else
	  		{
	  			//if($row['email_verified']==1)
		  		{
		  			$message = $message. '<button class="btn btn-primary btn-sm verify_candidate_first" id="'.$row['id'].'" data-toggle="modal" data-target="#verify_modal">Verify</button>';

		  		}
		  		$message = $message. '<button class="btn btn-danger btn-sm delete_candidate_first" id="'.$row['id'].'" data-toggle="modal" data-target="#delete_modal">Delete</button>';
	  		}
	  		
			$message = $message.'</div>'; //button-group
	  		$message = $message.'</td>';
	  		if($fail==NULL)
	  			$message = $message. '</tr>';
	  		

	  		return $message;
	  }
 }