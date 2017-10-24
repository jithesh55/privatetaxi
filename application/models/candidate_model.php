<?php
class Candidate_model extends CI_Model {

	public function get_param($param)
	{
		$val=$this->db->simple_query('SELECT '.$param.' FROM user_table WHERE id="'.$this->session->user_id.'"');
		$row=mysqli_fetch_array($val);
		return $row[$param];
	}
	public function get_individual_from_user_table($var)
	{
		$val = $this->db->simple_query('SELECT '.$var.' FROM user_table WHERE id="'.$this->session->user_id.'"');
		$row= mysqli_fetch_array($val);
		return $row[$var];
	}

	public function get_full_as_table($row)
	 {

	  			$this->load->model('class_convertion_model');
	  			$full_class=$this->class_convertion_model->decode_class($row['class']);
	  			
	  			$temp = '<table class="table table-hover"> <tr><th>Name</th><td>'.$row['name'].'</td></tr> <tr><th>Gender</th><td>'.$row['gender'].'</td></tr> <tr><th>Admission Number</th><td>'.$row['admission_no'].'</td></tr> <tr><th>email</th><td>'.$row['email'].'</td></tr> <tr><th>Class</th><td>'.$full_class.'</td></tr> <tr><th>Reg Time</th><td>'.$row['reg_time'].'</td></tr>  <tr><th>Address </th><td>'.$row['addr_1'].'<br/>'.$row['addr_2'].'<br/>'.$row['addr_3'].'<br/><strong>Pincode: </strong>'.$row['pincode'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mobile Number</th><td>'.$row['mobno'].'</td></tr>';
	  			$dob = explode('-', $row['dob']); $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
	  			$temp = $temp.' <tr><th>Date of Birth</th><td>'.$dob.'</td></tr>';
	  			$temp = $temp.' <tr><th>Religion</th><td>'.$row['religion'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Father\'s Name</th><td>'.$row['father_name'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Father\'s Occupation</th><td>'.$row['father_occupation'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mother\'s Name</th><td>'.$row['mother_name'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mother\'s Name</th><td>'.$row['mother_occupation'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Admission Quota</th><td>'.$row['admission_quota'].'</td></tr>';
                $temp = $temp.' <tr><th>Image</th><td><img src='.base_url().'uploads/'.$row['path'].'</td></tr>';
	  			$temp =$temp.'</table><br/>';	
                
	  			return $temp;
	  }
	  public function get_major_full_as_table($row)
	 {

	  			$this->load->model('class_convertion_model');
	  			$full_class=$this->class_convertion_model->decode_class($row['class']);
	  			
	  			$temp = '<table class="table table-hover"> <tr><th>Name</th><td>'.$row['name'].'</td></tr> <tr><th>Gender</th><td>'.$row['gender'].'</td></tr> <tr><th>Admission Number</th><td>'.$row['admission_no'].'</td></tr> <tr><th>Email</th><td>'.$row['email'].'</td></tr>';
				$temp = $temp.' <tr><th>Mobile Number</th><td>'.$row['mobno'].'</td></tr>';
				$temp = $temp.' <tr><th>Residential Phone</th><td>'.$row['res_no'].'</td></tr>';
	  			$temp = $temp.'  <tr><th>Class</th><td>'.$full_class.'</td></tr> <tr><th>Reg Time</th><td>'.$row['reg_time'].'</td></tr>  <tr><th>Address </th><td>'.$row['addr_1'].'<br/>'.$row['addr_2'].'<br/>'.$row['addr_3'].'<br/><strong>Pincode: </strong>'.$row['pincode'].'</td></tr>';
	  			//$temp = $temp.' <tr><th>Mobile Number</th><td>'.$row['mobno'].'</td></tr>';
	  			$dob = explode('-', $row['dob']); $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
	  			$temp = $temp.' <tr><th>Date of Birth</th><td>'.$dob.'</td></tr>';
	  			//$temp = $temp.' <tr><th>Admission Number</th><td>'.$row['admission_no'].'</td></tr>';
	  			//$temp = $temp.' <tr><th>Class</th><td>'.$row['class'].'</td></tr>';
	  			//$temp = $temp.' <tr><th>Gender</th><td>'.$row['gender'].'</td></tr>';
	  			//$temp = $temp.' <tr><th>Email</th><td>'.$row['email'].'</td></tr>';
	  			//$temp = $temp.' <tr><th>Address</th><td>'.$row['addr_1'].'<br/>'.$row['addr_2'].'<br/>'.$row['addr_3'].'</td></tr>';
	  			//$temp = $temp.' <tr><th>Pin Code</th><td>'.$row['pincode'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Religion</th><td>'.$row['religion'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Father\'s Name</th><td>'.$row['father_name'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Father\'s Occupation</th><td>'.$row['father_occupation'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mother\'s Name</th><td>'.$row['mother_name'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Mother\'s Occupation</th><td>'.$row['mother_occupation'].'</td></tr>';
	  			$temp = $temp.' <tr><th>Admission Quota</th><td>'.$row['admission_quota'].'</td></tr>';
                $temp = $temp.' <tr><th>Image</th><td><img src="'.base_url().'uploads/'.$row['path'].'"></td></tr>';
	  			$temp= $temp.'<tr><th></th><td></td></tr>';
	  			if($row['course']=='BTECH' && $row['btech_type']==NULL)
	  			{
	  				$temp.='<tr><th class="text-danger">Btech type (Lateral/MGU/KTU) not declared</th></tr>';
	  			}
	  			else
	  			{
		  			$temp = $temp.' <tr><th>Arrear History</th><td>'.$row['ARREAR_HISTORY'].'</td></tr>';
		  			$this->load->model('academic_model');
		  			$inds= $this->academic_model->get_individuals($row['course'],$row['btech_type']);
		  			foreach ($inds as $ind) {
		  				if($ind=="ARREAR_NO")
		  				{
		  					$temp = $temp.' <tr><th>Arrears</th><td>'.$row[$ind].' till '.$row['ARREAR_LAST'].'</td></tr>';
		  				}
		  				else
		  					$temp = $temp.' <tr><th>'.$this->academic_model->decode($ind).'</th><td>'.$row[$ind].'</td></tr>';
		  			}
		  			$pairs= $this->academic_model->get_pairs($row['course'],$row['btech_type']);
		  			foreach ($pairs as $pair) {
		  				$temp5=array('-percent','-CGPA');
		  				foreach ($temp5 as $temp2) {
		  					$ind=$pair.$temp2;
		  					$temp = $temp.' <tr><th>'.$this->academic_model->decode($ind).'</th><td>'.$row[$ind].'</td></tr>';
		  				}
		  				
		  			}
		  			$temp = $temp.' <tr><th>AGGREGATE PERCENT</th><td>'.$row['aggr-percent'].'</td></tr>';
		  			$temp = $temp.' <tr><th>AGGREGATE CGPA</th><td>'.$row['aggr-CGPA'].'</td></tr>';
	  			}
	  			$temp =$temp.'</table><br/>';	
	  			return $temp;
	  }
	  public function apply($placement_id)
	  {
	  	$user_id= $this->session->user_id;
	  	$result=$this->get_qualified($user_id, $placement_id);
	  	if($result[0]!="success")
	  		return $result;
	  	$val=$this->db->simple_query('SELECT status FROM placement_main WHERE placement_id="'.$placement_id.'"');
	  	$row=mysqli_fetch_array($val);
	  	if($row['status']!="1")
	  	{
	  		$result=array("error","The placement is closed for applications.");
	  		return $result;
	  	}

	  	$this->db->simple_query('DELETE FROM allocate_placement WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');

	  	$data=array(
	  		'user_id' => $user_id,
	  		'placement_id' => $placement_id,
	  		'status' => '1'
	  		);
	  	$this->db->insert('allocate_placement',$data);
	  	$res=array("success","Successfully applied for placement");
	  	return $res;

	  }

	  public function get_qualified($user_id, $placement_id)
	  {
		  	$val=$this->db->simple_query('SELECT status FROM allocate_placement WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');
		  	if($row=mysqli_fetch_array($val))
		  	{
		  		if($row['status']>0 && $row['status']<50 )
		  		{
		  			$res=array("error","You are already enrolled. No need to enter again","0");
		  			return $res;
		  		}
		  		if(($row['status'])==-2)
		  		{
		  			$res=array("error","You are already won the placement","-2");
		  			return $res;
		  		}
		  	}
		  	$val=$this->db->simple_query('SELECT status,type FROM placement_main WHERE placement_id="'.$placement_id.'"');
		  	$row=mysqli_fetch_array($val);
		  	$placement_type=$row['type'];
		  	if($row['status'] !=1)
		  	{
		  		$res=array("error","The placement is closed");
		  		return $res;
		  	}
		  	$val=$this->db->simple_query('SELECT status,selection_type FROM allocate_placement WHERE placement_id="'.$placement_id.'" AND user_id="'.$user_id.'"');
		  	$row=mysqli_fetch_array($val);
		  	switch($row['status'])
		  	{
		  		case '-2': $res=array("error","You have already won this placement.","-2");
		  					return $res;
		  					break;
		  		case '2502':$res=array("error","Your application have been rejected due to reaching of threshold placements.","2502");
		  					return $res;
		  					break;
		  		case '3003':$res=array("error","Your application have been rejected by the admin.","3003");
		  					return $res;
		  					break;
		  		default: break;
		  	}

		  	/*if($placement_type=="normal")
		  	{
			  	$val=$this->db->simple_query('SELECT b.placement_id FROM placement_main a, allocate_placement b WHERE a.type="normal" AND b.user_id="'.$user_id.'" AND a.placement_id=b.placement_id AND b.status="-2"');
			  	if(mysqli_num_rows($val)>=2)
			  	{
			  		$res=array("error",'You cannot get placed in more than two IT company.');
			  		return $res;
			  	}
			}
			if($placement_type=="special")
		  	{
			  	$val=$this->db->simple_query('SELECT b.placement_id FROM placement_main a, allocate_placement b WHERE a.type="special" AND b.user_id="'.$user_id.'" AND a.placement_id=b.placement_id AND b.status="-2"');
			  	
			  	if(mysqli_num_rows($val)>=1)
			  	{
			  		$res=array("error",'You cannot get placed in more than one dream/core company.');
			  		return $res;
			  	}
			 }*/
		  	$val=$this->db->simple_query('SELECT * FROM placement_main WHERE placement_id="'.$placement_id.'"');
		  	$row=mysqli_fetch_array($val);
		  		$course=$this->get_personal('course',$user_id);
		  		$branch=$this->get_personal('branch',$user_id);
		  		$this->load->model('class_convertion_model');
		  		$branch=$this->class_convertion_model->convert($branch);
		  	if($row[ $course ]!=1)
		  	{
		  		$res=array("error","This placement is not for ".$course." students");
		  		return $res;
		  	}
		  	$valConditions=$this->db->simple_query('SELECT branches FROM placement_conditions WHERE placement_id="'.$placement_id .'" AND `for`="'.$course.'"');
		  			$rowTemp = mysqli_fetch_array($valConditions);
		  			if(!empty($rowTemp['branches']))
			  		{
			  			$resultBranches=explode(" ", $rowTemp['branches'] );
						$init=0;
						foreach ($resultBranches as $key) {
							if(!empty($key))
							{
								if($key==$branch)
									$init++;

							}
						}
						if($init==0)
							{
								$res=array("error","This placement is not available for your branch");
								return $res;
							}
					}

		  	//Getting conditions 
		  	$val=$this->db->simple_query('SELECT * FROM placement_conditions WHERE placement_id="'.$placement_id.'" AND `for`="'.$course.'"');
		  	$row=mysqli_fetch_array($val);
		  	$filled_upto=$row['filled_upto'];
		  	$max_arrear=$row['max_arrear'];
		  	$min_percent=$row['min_percent'];
		  	$min_CGPA=$row['min_CGPA'];
		  	$arrear_history_problem=$row['arrear_history_problem'];

		  	$val=$this->db->simple_query('SELECT * FROM user_table WHERE id="'.$user_id.'"');
		  	$row=mysqli_fetch_array($val);
		  	if($row[ $filled_upto.'-percent']==NULL || $row[ $filled_upto.'-CGPA']==NULL )
		  	{
		  		$res=array("error","Please go to your console and update academic data upto ".$filled_upto);
		  		return $res;
		  	}
		  	if( ltrim($row[ 'ARREAR_LAST' ], 'S') <  ltrim($filled_upto, 'S') || strlen($row[ 'ARREAR_LAST' ])>strlen($filled_upto) ) //Second parameter to check for S12
		  	{
		  		$res=array("error","Please update your arrear listing upto ".$filled_upto);
		  		return $res;
		  	}
		  	if($max_arrear!="2002")
		  	{
		  		if($row['ARREAR_NO']>$max_arrear)
		  		{
		  			$res=array("error","You are not qualified to apply for this placement. You have more than ".$max_arrear." arrears");
		  			return $res;
		  		}
		  	}
		  	if($row['aggr-percent'] < $min_percent)
		  	{
		  		$res=array("error","You are not qualified to apply for this placement. You have less than ".$min_percent." percentage");
		  		return $res;
		  	}
		  	if($row['aggr-CGPA'] < $min_CGPA)
		  	{
		  		$res=array("error","You are not qualified to apply for this placement. You have less than ".$min_CGPA." CGPA");
		  		return $res;
		  	}
		  	if($row['ARREAR_HISTORY']!="no" && $arrear_history_problem=="1" )
		  	{
		  		$res=array("error","You are not qualified for the placement, because you have an arrear history");
		  		return $res;
		  	}

		  	$res=array("success","User passes every condition for placement");
		  	return $res;
	  }

	  public function get_personal($individual=NULL,$user_id=NULL)
	  {
	  	if($user_id==NULL) $user_id=$this->session->user_id;

	  	$val = $this->db->simple_query('SELECT * FROM user_table WHERE id="'.$user_id.'"');
	  	if($individual==NULL)
	  	{
	  		if($row=mysqli_fetch_array($val))
	  		{
		  		$temp=$this->get_placement_info($user_id);
		  		$temp.=$this->get_major_full_as_table($row);
	  		}
		  	else
		  		$temp="";
	  	}
	  	else
	  	{
	  		$row=mysqli_fetch_array($val);
	  		$temp=$row[$individual];
	  	}
		  	
	  	return $temp;
	  }
	  public function get_placement_info($user_id)	  
	  {
	  		$val=$this->db->simple_query('SELECT * FROM allocate_placement WHERE user_id="'.$user_id.'" ORDER BY status ASC');
	  		$temp='<br/><h4>Placements Registered</h4>';
	  		$temp.= '<table class="table table-bordered"> ';
	  		if(mysqli_num_rows($val)<1)
	  			$temp="";
	  		while($row=mysqli_fetch_array($val))
	  		{
	  			$t_val=$this->db->simple_query('SELECT placement_name,about,type from placement_main WHERE placement_id="'.$row['placement_id'].'"');
	  			if($t_row=mysqli_fetch_array($t_val))
	  			{
	  				$temp.='<tr><th><a href="'.base_url().$this->session->type.'/placement/'.$row['placement_id'].'">'.$t_row['placement_name'].'</a></th>';
	  				$temp.='<td>'.substr($t_row['about'], 0,100).'...</td>'; 
	  				$temp.='<td>';
	  					if($t_row['type']=='normal')
	  						$temp.='Normal Company';
	  					else if ($t_row['type']=='special')
	  						$temp.='Core/Dream Company';
	  				$temp.='</td>';
	  					if($row['status']=='-2')
	  						$temp.='<th class="text-success">Placement Won</th>';
	  					else if($row['status']=='3003')
	  						$temp.='<th class="text-danger">Rejected</th>';
	  					else if($row['status']=='2502')
	  						$temp.='<th class="text-danger">Rejected (THRESHOLD)</th>';
	  					else
	  						$temp.='<th>Qualified for level '.$row['status'].'</th>';

	  				$temp.='<td>';
	  					$temp.='<button class="btn btn-sm btn-default more_button" user-id="'.$user_id.'" placement-id="'.$row['placement_id'].'"  data-toggle="modal" data-target="#detailsModal" >More</button>';
	  				$temp.='</td>';

	  				$temp.='</tr>';
	  			}
	  		}
	  		$temp.='</table>';

	  		return $temp;

	  }
	  public function has_started()
	  {
	  	$val = $this->db->simple_query('SELECT course,btech_type FROM user_table WHERE id="'.$this->session->user_id.'"');
	  	$row=mysqli_fetch_array($val);
	  	if($row['course']!='BTECH')
	  		return 1;
	  	if($row['btech_type']!=NULL)
	  		return 1;
	  	else
	  		return 0;
	  }

}