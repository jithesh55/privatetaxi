<?php
class Admin_model extends CI_Model {


  public function add_placement()
  {
    if(empty($_POST['placement_name']) || empty($_POST['about']) || empty($_POST['type']) || empty($_POST['levels']))
    {
      $result=array("error","Some important fields are missing");
      return $result;
    }
    $placement_id='P'.uniqid();
    $placement_name=trim( $_POST['placement_name'] );
    $designation=trim($_POST['designation']);
    $package=trim($_POST['package']);
   $location=trim( $_POST['location'] );
    $about=nl2br( trim( $_POST['about'] ) );
    $type=trim( $_POST['type'] );
    $levels=trim( $_POST['levels'] );
    $year=trim( $_POST['year'] );
    
    if(isset($_POST['BTECH']) ) //BTECH check
      $BTECH=1;
    else 
      $BTECH=0;
    if( isset($_POST['MTECH'])  ) // MTECH check
      $MTECH=1;
    else 
      $MTECH=0;
    if( isset($_POST['MCA']) ) //MCA check
      $MCA=1;
    else 
      $MCA=0;

    $data=array(
      'placement_id' => $placement_id,
      'placement_name'=> $placement_name,
       'designation'=>$designation,
        'location'=>$location,
        'package'=>$package,
      'about' => $about,
      'type' => $type,
      'levels' => $levels,
      'BTECH' => $BTECH,
      'MTECH' => $MTECH,
      'MCA' => $MCA,
      'year' => $year,
        
      );
    if($BTECH != 0)
      $this->process_conditions('BTECH',$placement_id);
    if($MTECH !=0)
      $this->process_conditions('MTECH',$placement_id);
    if($MCA !=0)
      $this->process_conditions('MCA',$placement_id);

    $this->db->insert('placement_main',$data);

    header('Location:'.base_url().'admin/placement/'.$placement_id);
  }
  private function process_conditions($course , $placement_id)
  {
    $filled_upto= trim( $_POST[$course.'_filled_upto'] );
    if(isset($_POST[$course.'_max_arrear']))
      $max_arrear = trim( $_POST[$course.'_max_arrear'] );
    else 
      $max_arrear = 2002;
    if(isset($_POST[$course.'_min_percent']))
      $min_percent = trim( $_POST[$course.'_min_percent'] );
    else
      $min_percent = 0;
    if(isset($_POST[$course.'_min_CGPA']))
      $min_CGPA = trim( $_POST[$course.'_min_CGPA'] );
    else
      $min_CGPA = 0;
    if($_POST[$course.'_arrear_history_problem']=="1")
      $history = "1";
    else
      $history="0";

    $branchesList="";
    $val= $this->class_convertion_model->list_short_names();
    foreach ($val as $branch){
      if(isset($_POST[$course.'_branch_'.$branch]))
        $branchesList.=$branch." "; //space important
  
    }
  if(isset($_POST[$course.'_plus_two']))
  
      $plus_two=trim($_POST[$course.'_plus_two']);
   else
       $plus_two=0;
    if(isset($_POST[$course.'_tenth']))
        $tenth=trim($_POST[$course.'_tenth']);
    else
        $tenth=0;
    if(isset($_POST[$course.'_diploma']))
        $diploma=trim($_POST[$course.'_diploma']);
    else
        $diploma=0;
    if(isset($_POST[$course.'_degree']))
        $degree=trim($_POST[$course.'_degree']);
    else
        $degree=0;
 if(isset($_POST[$course.'_ug']))
        $ug=trim($_POST[$course.'_ug']);
    else
        $ug=0;
    if($min_CGPA=="") $min_CGPA=0;
    if($min_percent=="") $min_percent=0;

    $data=array(
      'placement_id' => $placement_id,
      'filled_upto' => $filled_upto,
      'max_arrear' => $max_arrear,
      'min_percent' => $min_percent,
      'min_CGPA' => $min_CGPA,
      'arrear_history_problem' => $history,
      'for' => $course,
      'branches' => $branchesList,
        'plus_two'=>$plus_two,
        'tenth'=>$tenth,
        'diploma'=>$diploma,
        'degree'=>$degree,
        'ug'=>$ug
        );
    $this->db->insert('placement_conditions',$data);
  }

  public function special_insert($admno,$placement_id)
  {
    $val=$this->db->simple_query('SELECT placement_name FROM placement_main WHERE placement_id="'.$placement_id.'"');
    if(!($row=mysqli_fetch_array($val)))
      {
        $res=array("error","Placement not found");
        return $res;
      }
    $val=$this->db->simple_query('SELECT id,name,type FROM user_table WHERE admission_no="'.$admno.'" AND type="candidate"');
    if(!($row=mysqli_fetch_array($val)))
      {
        $res=array("error","Candidate not found");
        return $res;
      }
    else
      {
        $user_id=$row['id'];
        $name=$row['name'];
          $val2=$this->db->simple_query('SELECT id from allocate_placement WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');
          if($row2=mysqli_fetch_array($val2))
          {
            $res=array("error","Candidate already enrolled for the placement");
            return $res;
          }
        $data=array(
          'placement_id' => $placement_id,
          'user_id' => $user_id,
          'status' => 1,
          'selection_type' => 'admin'
          );
        $this->db->insert('allocate_placement',$data);
         $res=array("success","Special Insertion successfull for <strong>".$name."</strong> [".$admno."]");
        return $res;
      }
  }
  public function reject_placement($user_id,$placement_id)
  {
    $val=$this->db->simple_query('SELECT status FROM allocate_placement WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');
      if($row=mysqli_fetch_array($val))
      {
        $status=$row['status'];
        if($status>=-2 && $status<50)
          $this->db->simple_query('UPDATE allocate_placement SET allocate_back_to="'.$status.'", status="3003" WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');
      }
  }
  public function reallocate_placement($user_id,$placement_id)
  {
    $allocate_back_to=$_POST['allocate_back_to'];
        $this->db->simple_query('UPDATE allocate_placement SET status="'.$allocate_back_to.'" WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');
  }
  public function add_placement_details_to_search()
  {
      $placement_details=1;
      $query= 'SELECT a.user_id, b.placement_name FROM allocate_placement a, placement_main b WHERE a.placement_id=b.placement_id AND a.status="-2"';
      $res=$this->db->simple_query($query);
      $result=array();
      $result['placement_count']=array();
      $result['placement_list']=array();
      $result['max_count']=0;
      while($row=mysqli_fetch_array($res))
      {
        if(isset($result['placement_count'][$row['user_id']]))
        {
          $result['placement_list'][$row['user_id']].="~".$row['placement_name'];
          $result['placement_count'][$row['user_id']]++;
          if($result['placement_count'][$row['user_id']] >  $result['max_count'])
             $result['max_count']= $result['placement_count'][$row['user_id']];
        }
        else
        {
          $result['placement_list'][$row['user_id']]=$row['placement_name'];
          $result['placement_count'][$row['user_id']]=1;
          if($result['placement_count'][$row['user_id']] >  $result['max_count'])
             $result['max_count']= $result['placement_count'][$row['user_id']];
        }
      }
      return $result;
  }
  public function process_search()
  {
    $query='SELECT * FROM user_table WHERE verified="1"';

    if( !empty($_GET['general']) )
      $query= $query.' AND (name LIKE "%'.$_GET['general'].'%" OR admission_no LIKE "%'.$_GET['general'].'%")';

    if(isset($_GET['candidate']) && isset($_GET['volunteer']))
      $query= $query.'';
    else if(isset($_GET['candidate']))
      $query= $query.' AND type="candidate"';
    else if(isset($_GET['volunteer']))
      $query= $query.' AND type="volunteer"';

    if(isset($_GET['BTECH']) && isset($_GET['MTECH']) && isset($_GET['MCA']))
      $query= $query.'';
    else 
      {
        if(isset($_GET['BTECH']))
          $query= $query.' AND course="BTECH"';
        if(isset($_GET['MTECH']))
           $query= $query.' AND course="MTECH"';
        if(isset($_GET['MCA']))
            $query= $query.' AND course="MCA"';
      }

    if(isset($_GET['male']) && isset($_GET['female']))
      $query= $query.'';
    else if(isset($_GET['male']))
      $query= $query.' AND gender="male"';
    else if(isset($_GET['female']))
      $query= $query.' AND gender="female"';

    if(!empty($_GET['year']))
      $query= $query.' AND class LIKE "%'.$_GET['year'].'%"';

    if(!empty($_GET['division']))
      $query= $query.' AND division="'.$_GET['division'].'"';

    $val= $this->class_convertion_model->list_short_names();
    $init=0;
    foreach ($val as $branch) {
          if(!empty($_GET[$branch]))
          {
            if($init==0)
            {
              $query= $query.' AND ( class LIKE "%-'.$branch.'-%"';
              $init++;
            }
            else
            {
              $query= $query.' OR class LIKE "%-'.$branch.'-%"';
            }
          }   
      }
      if($init!=0)
            $query=$query.')';   


    if(!empty($_GET['arrear_no']))
      $query= $query.' AND ARREAR_NO<="'.$_GET['arrear_no'].'"';
    else if(isset($_GET['arrear_no']))
    {  
      if ($_GET['arrear_no']=='0')
      $query= $query.' AND ARREAR_NO<="0"';
    }
    
    if(!empty($_GET['ARREAR_HISTORY']))
    {
      if($_GET['ARREAR_HISTORY']=="yes")
        $query= $query.' AND ARREAR_HISTORY="yes"';
      else if($_GET['ARREAR_HISTORY']=="no")
        $query= $query.' AND ARREAR_HISTORY="no"';
    }

    if(!empty($_GET['aggr-percent']))
      $query= $query.' AND `aggr-percent`>="'.$_GET['aggr-percent'].'"';

    if(!empty($_GET['aggr-CGPA']))
      $query= $query.' AND `aggr-CGPA`>="'.$_GET['aggr-CGPA'].'"';


    $query =$query.' AND type!="admin" ORDER BY type DESC, class, verified DESC,name';
    $val=$this->db->simple_query($query);
    return $val;
  }

  public function upgradeplacement($placement_id)
  {
    $upgrade_to=$_POST['upgrade_to'];
    $val=$this->db->simple_query('SELECT levels FROM placement_main WHERE placement_id="'.$placement_id.'"');
    $row=mysqli_fetch_array($val);
    $quer="( ";
    if($upgrade_to>="-2" && $upgrade_to<=$row['levels'])
    {
      $i=0;
      $val=$this->db->simple_query('SELECT user_id FROM allocate_placement WHERE status>="-2" AND status<"50" AND placement_id="'.$placement_id.'"');
      while($row=mysqli_fetch_array($val))
      {
        if(isset( $_POST[$row['user_id']] ))
        {
          if($i==0)
          {
            $quer= $quer.' user_id="'.$row['user_id'].'"';
            $i++;
          }
          else
          {
            $quer= $quer.' OR user_id="'.$row['user_id'].'"';
          }
        }
      }
      $quer=$quer." )";
      $query='UPDATE `allocate_placement` SET status="'.$upgrade_to.'" WHERE '.$quer.' AND placement_id="'.$placement_id.'"';
      if($this->db->simple_query($query))
      {
       $this->threshold_putter();
        header('Location:'.base_url().'admin/placement/'.$placement_id);
      }
    }
    else
    {
      echo '<h2>Invalid status. System break.</h2>'; exit();
    }
    
  }

  public function threshold_putter()
  {
    //$query='SELECT count(*), a.user_id FROM allocate_placement a, placement_main b WHERE a.placement_id=b.placement_id AND b.type="normal" GROUP by a.user_id';
    //$val=$this->db->simple_query($query);
    $query='UPDATE allocate_placement SET allocate_back_to=status WHERE status>="-2" AND status<="50"';
    $this->db->simple_query($query);


    $query='SELECT count(*),user_id FROM allocate_placement a, placement_main b WHERE a.placement_id=b.placement_id AND b.type="normal" AND a.status="-2" GROUP by a.user_id HAVING count(*)>=2';
    $val=$this->db->simple_query($query);
    $string="1"; $string2="1";

    if($row=mysqli_fetch_array($val))
      $string=' user_id="'.$row['user_id'].'"';
    while($row=mysqli_fetch_array($val))
    {
      $string=$string.' OR user_id="'.$row['user_id'].'"';
    }
          $val=$this->db->simple_query('SELECT a.placement_id FROM allocate_placement a, placement_main b WHERE a.placement_id=b.placement_id AND b.type="normal" GROUP BY a.placement_id');
          if($row=mysqli_fetch_array($val))
            $string2=' placement_id="'.$row['placement_id'].'"';
          while($row=mysqli_fetch_array($val))
          {
            $string2=$string2.' OR placement_id="'.$row['placement_id'].'"';
          }

    $query='UPDATE allocate_placement SET status="2502" WHERE ('.$string.') AND ('.$string2.') AND status!="-2"';
    echo $query;
    if($string!="1" && $string2!="1")
      $this->db->simple_query($query);

    //DUPLICATE CODE..take care
    $query='SELECT count(*),user_id FROM allocate_placement a, placement_main b WHERE a.placement_id=b.placement_id AND b.type="special" AND a.status="-2" GROUP by a.user_id HAVING count(*)>=1';
    $val=$this->db->simple_query($query);
    $string="1"; $string2="1";

    if($row=mysqli_fetch_array($val))
      $string=' user_id="'.$row['user_id'].'"';
    while($row=mysqli_fetch_array($val))
    {
      $string=$string.' OR user_id="'.$row['user_id'].'"';
    }
          $val=$this->db->simple_query('SELECT a.placement_id FROM allocate_placement a, placement_main b WHERE a.placement_id=b.placement_id AND b.type="special" GROUP BY a.placement_id');
          if($row=mysqli_fetch_array($val))
            $string2=' placement_id="'.$row['placement_id'].'"';
          while($row=mysqli_fetch_array($val))
          {
            $string2=$string2.' OR placement_id="'.$row['placement_id'].'"';
          }

    $query='UPDATE allocate_placement SET status="2502" WHERE ('.$string.') AND ('.$string2.') AND status!="-2"';
    
    if($string!="1" && $string2!="1")
      $this->db->simple_query($query);

  }

  public function get_unverified_volunteers()
  {
  	$val = $this->db->simple_query('SELECT id, name, admission_no, gender, class, email, mobno, email_verified, reg_time FROM user_table WHERE type="volunteer" AND verified="0" ORDER BY email_verified DESC');
  	$var='<tr><th>Name</th> <th>Class</th> <th>Gender</th> <th>Email</th> <th>Mobile number</th> <th>Registration Time</th>  <th>Action</th> </tr>';
  	$res=array();
  	array_push($res, $var);
  	while($row = mysqli_fetch_array($val))
  	{
  		array_push($res , $this->single_unverified_volunteer_row($row));
  	}
  	return $res;
  }
  public function get_unverified_volunteers_num()
  {
  	$val=$this->db->simple_query('SELECT id FROM user_table WHERE type="volunteer" AND verified="0"');
  	return (mysqli_num_rows($val));
  }

  public function single_unverified_volunteer_row( $row , $fail=NULL) 
  {
  			$message ="";
  			$temp = '<table class="table"> <tr><th>Name</th><td>'.$row['name'].'</td></tr> <tr><th>Gender</th><td>'.$row['gender'].'</td></tr> <tr><th>User Name</th><td>'.$row['admission_no'].'</td></tr> <tr><th>email</th><td>'.$row['email'].'</td></tr> <tr><th>Mobile number</th><td>'.$row['mobno'].'</td></tr> <tr><th>Class</th><td>'.$row['class'].'</td></tr> <tr><th>Reg Time</th><td>'.$row['reg_time'].'</td></tr> 
  				</table><br/>';

  		if($fail==NULL)
  			$message = $message.'<tr id="row_'.$row['id'].'">';
  		$message = $message.'<td>'.$row['name'].'</td>';
  		$message = $message.'<td>'.$row['class'].'</td>';
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
	  			$message = $message. '<button class="btn btn-primary btn-sm verify_volunteer_first" id="'.$row['id'].'" data-toggle="modal" data-target="#verify_modal">Verify</button>';

	  		}
	  		$message = $message. '<button class="btn btn-danger btn-sm delete_volunteer_first" id="'.$row['id'].'" data-toggle="modal" data-target="#delete_modal">Delete</button>';
  		}
  		
		$message = $message.'</div>'; //button-group
  		$message = $message.'</td>';
  		if($fail==NULL)
  			$message = $message. '</tr>';
  		

  		return $message;
  }
}