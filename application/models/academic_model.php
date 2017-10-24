<?php
class Academic_model extends CI_Model {

public function get_type_of_value($var)
{
	$exp= explode('-', $var);
	if(isset($exp[1]))
	{
		if($exp[1]=="CGPA")
			return "CGPA";
		else
			return "percent";
	}
	else if($var=="ARREAR_NO")
		return "number";
	else if($var=="entrance_rank")
		return "number";
	else
		return "percent";
}
public function details($user_id,$course,$type,$individuals,$pairs, $file)
{
    $mini_project=trim( $_POST['mini_project'] );
    $main_project=trim( $_POST['main_project'] );
    $workshop=trim( $_POST['workshop'] );
    $uploadDir = __DIR__."/../../uploads/";
    $uploadName = $user_id;
    $allowedTypes = array("png", "jpg", "bmp");
    var_dump($file);
    $temp = explode(".", $file['photo']['name']);
    $extension = end($temp);
    $mimes = array("image/jpeg", "image/png", "image/bmp", "image/jpg");
    
    if((in_array($file['photo']['type'], $mimes)) && in_array($extension, $allowedTypes)){
        if($file["photo"]["error"]>0){
            echo "Return Code: ".$file['photo']['error']."<br>";
        }
        else{
            if($file['photo']['size']==0){
                die("Return Size: ".$file['photo']['size']."<br>");
            }
            else{
//                if(is_uploaded_file(realpath($_FILES['photo']['tmp_name']))){
                    $uploadName .= ".".$extension;
                    
                    move_uploaded_file($file['photo']['tmp_name'], $uploadDir.$uploadName);
//                }
//                else{
//                    die("Not a valid Upload");
//                }
            }
        }
    }
 $data=array(
    'mini_project'=>$mini_project,
    'main_project'=>$main_project,
    'workshop'=>$workshop,
     'path'=>$uploadName
    );
  $this->db->set($data);
$this->db->where("id", $user_id);
$this->db->update("user_table", $data);

 echo "UPLOADING DONE SUCCESSFULLY "; 
}
public function submit($user_id,$course,$type,$individuals,$pairs)
{
	if(!isset($_POST['ARREAR_LAST']))
	{
		$res=array("error","Please enter Arrear Last value");
		return $res;
	}
	else
	{
		if(empty($_POST['ARREAR_LAST']))
		{
			$res=array("error","Please enter Arrear Last value");
			return $res;
		}
	}
	if(!isset($_POST['ARREAR_HISTORY']))
	{
		$res=array("error","Please enter Arrear History");
		return $res;
	}
	else
	{
		if(empty($_POST['ARREAR_HISTORY']))
		{
			$res=array("error","Please enter Arrear History");
			return $res;
		}
	}
	$push_values=array();	

	foreach ($pairs as $pair) {
		if(isset($_POST[$pair.'-percent']) && isset($_POST[$pair.'-CGPA']))
		{
			if(!empty($_POST[$pair.'-percent']) )
			{
				array_push($push_values, $pair.'-percent');
				array_push($push_values, $pair.'-CGPA');
			}	
			else 
				break;
		}
		else
			break;
	}
	foreach ($individuals as $ind) {
		if(!isset($_POST[$ind]))
		{
			$res = array("error",$this->decode($ind).", was not filled");
			return $res;
		}
		else if(empty($_POST[$ind]) && $_POST[$ind]!=0)
		{
			$res = array("error",$this->decode($ind).", was not filled");
			return $res;
		}
		array_push($push_values, $ind);
	}
	$data=array();
	foreach($push_values as $ind)
	{
			switch ($this->get_type_of_value($ind))
			{
				case 'percent' : if($_POST[$ind] <0 || $_POST[$ind]>100)
									{
										$res=array("error",$this->decode($ind).", should be between 0 and 100");
										return $res;
									}
								 else if(!is_numeric($_POST[$ind]))
								 	{
										$res=array("error",$this->decode($ind).", should be a number");
										return $res;
									}
								break;
				case 'CGPA' : if($_POST[$ind]<0 || $_POST[$ind]>10)
									{
										$res=array("error",$this->decode($ind).", should be between 0 and 100");
										return $res;
									}
								 else if(!is_numeric($_POST[$ind]))
								 	{
										$res=array("error",$this->decode($ind).", should be a number");
										return $res;
									}
									break;
				case 'number' :  if(is_int($_POST[$ind]) || $_POST[$ind]<0)
								 	{
										$res=array("error",$this->decode($ind).", should be a valid positive number");
										return $res;
									}
									break;
				default: $res=array("error","Data type not supported. Contact admin");
						break;
			}
			$data[$ind]=$_POST[$ind];

	}
	$data['ARREAR_LAST']=$_POST['ARREAR_LAST'];
	$data['ARREAR_HISTORY']=$_POST['ARREAR_HISTORY'];
	$data['user_id']=$user_id;
	$this->db->simple_query('DELETE FROM update_academic WHERE user_id="'.$user_id.'"');
	$this->db->insert('update_academic',$data);
	$res=array("success","");
	return $res;
}
public function get_submitted_for_update()
{
	$val=$this->db->simple_query('SELECT * FROM update_academic WHERE user_id="'.$this->session->user_id.'"');
	$row=mysqli_fetch_array($val);
	return $row;
}
public function get_current_academic()
{
	$val=$this->db->simple_query('SELECT * FROM user_table WHERE id="'.$this->session->user_id.'"');
	$row=mysqli_fetch_array($val);
	return $row;
}
public function get_individuals($course,$type=NULL) //type COMPULSORY for BTECH.. type=>(lateral,normal,normal-ktu)
{
	if($course=='MTECH' || $course=='MCA')
	{
		$ind=array('tenth','twelth','UGAGGR-percent','UGAGGR-CGPA','ARREAR_NO');
		return $ind;
	}
	else if($course=='BTECH')
	{
		if($type=='normal' || $type=='normal-ktu')
		{
			$ind=array('tenth','twelth','entrance_rank','ARREAR_NO');
			return $ind;
		}
		else if($type=='lateral')
		{
			$ind=array('tenth','twelth','diploma','ARREAR_NO');
			return $ind;
		}
	}
	else if($course=="ALL_ELSE")
	{
		$ind=array('tenth','twelth','UGAGGR-percent','UGAGGR-CGPA','diploma');
		return $ind;
	}
	return NULL;
}
public function get_pairs($course,$type=NULL) //type COMPULSORY for BTECH.. type=>(lateral,normal,normal-ktu)
{
	if($course=='MTECH')
	{
		$ind=array('S1','S2','S3','S4');
		return $ind;
	}
	else if($course=='MCA')
	{
		$ind=array('S1','S2','S3','S4','S5','S6');
		return $ind;
	}
	else if($course=='BTECH')
	{
		if($type=='normal')
		{
			$ind=array('S12','S3','S4','S5','S6','S7','S8');
			return $ind;
		}
		else if($type=='normal-ktu')
		{
			$ind=array('S1','S2','S3','S4','S5','S6','S7','S8');
			return $ind;
		}
		else if($type=='lateral')
		{
			$ind=array('S3','S4','S5','S6','S7','S8');
			return $ind;
		}
	}
	else if($course=="ALL_ELSE")
	{
		$ind=array('S12','S1','S2','S3','S4','S5','S6','S7','S8');
		return $ind;
	}
	return NULL;
}
	public function decode($var)
	{
		switch ($var) {
			
			case 'tenth':
				return "Tenth Percentage";
				break;
			case 'twelth':
				return "Twelth/Equivalent Percentage";
				break;
			case 'diploma':
				return "Diploma Percentage";
				break;
			case 'entrance_rank':
				return "Entrance Rank";
				break;
			case 'S12-percent':
				return "Semester 1 & 2 percentage";
				break;
			case 'S12-CGPA':
				return "Semester 1 & 2 GPA";
				break;
			case 'UGAGGR-CGPA':
				return "Undergraduate Aggregate CGPA";
				break;
			case 'UGAGGR-percent':
				return "Undergraduate Aggregate Percent";
				break;
			case 'ARREAR_NO':
				return "ARREAR papers till date";
				break;
			case 'ARREAR_LAST':
				return "Arrears Upto";
				break;
			case 'ARREAR_HISTORY':
				return "Arrear History";
				break;
			case 'S12':
				return "Semester 1 and 2";
				break;
			
			default:
				{
					$temp='Semester ' .$var[1];
					$exploded=explode('-', $var);
					if(isset($exploded[1]))
					{	
						if( $exploded[1]=='percent' )
							$temp = $temp. ' percentage';
						else
							$temp = $temp. ' GPA';
					}
					return $temp;
				}
				break;
		}
	}


}