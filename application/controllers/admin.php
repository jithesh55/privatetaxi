<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function check_status()
	{

		$this->load->model('check_for_cookie'); 
		if(!$this->session->has_userdata('type'))
		{
			header('Location:'.base_url());
			exit();
		}
		
		else 
			if ($this->session->type!='admin') {
				header('Location:'.base_url());
				exit();
			}
	}
	public function check_status2()
	{

		$this->load->model('check_for_cookie'); 
		if(!$this->session->has_userdata('type'))
		{
			header('Location:'.base_url());
			exit();
		}
		
		else 
			if (!($this->session->type=='admin'||$this->session->type=='volunteer')) {
				header('Location:'.base_url());
				exit();
			}
	}
	public function index()
	{
		$this->check_status();
			//Start- Lock or unlock academic
			if(isset($_GET['open_academic']))
				$this->db->simple_query('UPDATE config_table SET value1="0" WHERE key1="academic_lock"');
			else if (isset($_GET['lock_academic']))
				$this->db->simple_query('UPDATE config_table SET value1="1" WHERE key1="academic_lock"');
			if(isset($_GET['open_academic']) || isset($_GET['lock_academic']))
				header('Location:'.base_url().'admin');
			//End- Lock or unlock academic
		$this->load->model('admin_model');
		$this->load->model('class_convertion_model');
		$data['title']="Admin Console | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";

		$this->load->view('head',$data);
		$data['unverified_num'] = $this->admin_model->get_unverified_volunteers_num();
		if($data['unverified_num'] > 0)
			$data['unverified'] = $this->admin_model->get_unverified_volunteers();
		
		$this->load->view('admin_console',$data);
				$data['placement_id']=NULL;
				$this->load->view('admin_message_view',$data);
				$this->load->view('admin_placement_view',$data);
				$this->load->view('admin_active_classes_view',$data);
		$this->load->view('foot',$data);

	}
	public function placement_year($year=NULL)
	{
		$this->check_status();
		$this->load->model('admin_model');
		$this->load->model('class_convertion_model');
		$data['title']="Admin Console | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";

		$this->load->view('head',$data);
		$data['year']=$year;
			$this->load->view('admin_placement_year_view',$data);
		$this->load->view('foot',$data);

	}
	public function download_backup()
	{
		$this->check_status();
		$this->load->dbutil();

        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'db_tnp_backup_'. date("Y-m-d-H-i-s").'.sql'
              );


        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'tnp_db_backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        $save = 'pathtobkfolder/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup); 
	}
	public function change_pw()
	{
		$this->check_status();
		$data['title']="Change password | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";

		$this->load->view('head',$data);
		$this->load->view('admin_change_pw',$data);
		$this->load->view('foot',$data);

	}
	public function get_excel()
	{
		$this->check_status();
		$file="excel_file.xls";
		$test=str_replace("href", "aahaa", $_POST['value']);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;
	}
	public function search()
	{
		$this->check_status();
		$this->load->model('class_convertion_model');
		$this->load->model('admin_model');
		$data['title']="Search | Admin | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";

		if(isset($_GET['search']) || isset($_GET['search_console']))
		{
			$data['val_all']=$this->admin_model->process_search();
			$data['val_all_2']=NULL;
			if(isset($_GET['placement_details']))
    		{
				$data['val_all_2']=$this->admin_model->add_placement_details_to_search();
			}
		}
		$this->load->view('head',$data);
		$this->load->view('admin_search_view',$data);
		$this->load->view('foot',$data);

	}
	public function user($user_id=NULL)
	{
		$this->check_status();
		$this->load->model('candidate_model');
		$this->load->model('class_convertion_model');
		$this->load->model('admin_model');
		$data['title']=" Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";

		if(isset($_POST['reject']))
		{
			$placement_id=$_POST['placement_id'];
			$user_id=$_POST['user_id'];
			$this->admin_model->reject_placement($user_id,$placement_id);

		}
		if(isset($_POST['reallocate']))
		{
			$placement_id=$_POST['placement_id'];
			$user_id=$_POST['user_id'];
			$this->admin_model->reallocate_placement($user_id,$placement_id);
		}

		if($user_id==NULL)
			echo 'Error. Nothing to display';
		else
		{
			$this->load->view('head',$data);
			$data['user_id']=$user_id;
			$this->load->view('update_user_marks',$data);//This should be placed before getting personal details
			$res_values=$this->load->candidate_model->get_personal(NULL,$user_id);
			$res_values= '<h3>Candidate Details</h3><br/>'.$res_values;
			$data['res_values']=$res_values;
			$this->load->view('full_details',$data);
			$this->load->view('foot',$data);
		}
	}

	public function edit_user($user_id=NULL)
	{
		$this->check_status();
		$this->load->model('candidate_model');
		$this->load->model('admin_model');
		$this->load->model('class_convertion_model');
		$data['classes'] = $this->class_convertion_model->get_all();

		$data['title']=" Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$data['result']=array(NULL,NULL);
		if(isset($_POST['submit_edit']))
		{
			$this->load->model('signup_model');
			$data['result']=$this->signup_model->edit_candidate();
		}

		if(isset($_POST['admission_no'])){
			$admission_no=strtoupper($_POST['admission_no']);
			$res=$this->db->simple_query('SELECT * FROM `user_table` WHERE admission_no="'.$admission_no.'" AND type="candidate"');
			if(mysqli_num_rows($res)<1)
				$data['error']="User not found";
			else{
				$res=mysqli_fetch_array($res);
				$user_id=$res['id'];
				$data['current_details']=$res;
			}
		}

			$this->load->view('head',$data);
			$data['user_id']=$user_id;
			$this->load->view('edit_details',$data);
			$this->load->view('foot',$data);
	}

	public function addclass()
	{
		$this->check_status();
		$data['title']="Add new class | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$data['result']=array("NULL","");

		if(isset($_POST['submit']))
		{
			$this->load->model('add_class_model');
			$data['result']=$this->add_class_model->check();
		}	
		$this->load->model('class_convertion_model');
		$data['full_name'] = $this->class_convertion_model->list_full_names();
		$data['short_name'] = $this->class_convertion_model->list_short_names();
		$this->load->view('head',$data);
		$this->load->view('add_class_view',$data);
		$this->load->view('foot',$data);
	}
	public function addplacement()
	{
		$this->check_status();
		$data['title']="Add placement | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$this->load->model('class_convertion_model');
		if(isset($_POST['submit']))
		{
			$this->load->model('admin_model');
			$data['result']=$this->admin_model->add_placement();
		}	
		$this->load->view('head',$data);
		$this->load->view('add_placement_view',$data);
		$this->load->view('foot',$data);
	}

	public function upgradeplacement($placement_id=NULL)
	{
		$this->check_status();
		$this->load->model('admin_model');
		$this->load->model('class_convertion_model');
		if($placement_id==NULL)
		{
			header('Location:'.base_url().'admin');
		}
		if(isset($_POST['submit']))
			$this->admin_model->upgradeplacement($placement_id);

		$val=$this->db->simple_query('SELECT placement_name,placement_over,levels FROM placement_main WHERE placement_id="'.$placement_id.'"');
		$row=mysqli_fetch_array($val);
		$data['placement_name']=$row['placement_name'];
		$data['placement_over']=$row['placement_over'];
		$data['levels']=$row['levels'];
		$data['placement_id']=$placement_id;

		$data['listing']=$this->db->simple_query('SELECT a.name, a.admission_no, a.class,b.user_id, a.gender,b.placement_id, b.status FROM user_table a, allocate_placement b WHERE b.status>="-2" AND b.status<"50" AND a.id=b.user_id AND b.placement_id="'.$placement_id.'"');

		$data['title']="Upgrade placement | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		$this->load->model('admin_model');

		$this->load->view('head',$data);
		$this->load->view('upgrade_placement_view',$data);
		$this->load->view('foot',$data);
	}
	
	public function printforcompany($placement_id=NULL)
	{
		$this->check_status();
		$this->load->model('class_convertion_model');
		if($placement_id==NULL)
			echo '<h2>INVALID PLACEMENT ID</h2>';
		else
		{
			$this->load->model('admin_model');
			$data['title']="Placement Details | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
			$this->load->view('head2',$data);
			$data['placement_id']=$placement_id;
			$this->load->view('printforcompany_view',$data);
			$this->load->view('foot',$data);
		}
	}
	public function placement($placement_id=NULL)
	{
		$this->check_status();
		$this->load->model('admin_model');
		$this->load->model('class_convertion_model');
		$data['title']="Placement Details | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";
		
		if(isset($_POST['reject']))
		{
			$user_id=$_POST['user_id'];
			$this->admin_model->reject_placement($user_id,$placement_id);

		}
		if(isset($_POST['reallocate']))
		{
			$user_id=$_POST['user_id'];
			$this->admin_model->reallocate_placement($user_id,$placement_id);
		}
		if(isset($_POST['special_insert']))
		{
			$admno=strtoupper($_POST['admno']);
			$res=$this->admin_model->special_insert($admno,$placement_id);
			$data['res']=$res;
		}
		if(isset($_GET['close']))
		{
			$this->db->simple_query('UPDATE placement_main SET status=0 WHERE placement_id="'.$placement_id.'"');
			header('Location:'.base_url().'admin/placement/'.$placement_id);
		}
		if(isset($_GET['open']))
		{
			$this->db->simple_query('UPDATE placement_main SET status=1 WHERE placement_id="'.$placement_id.'"');
			header('Location:'.base_url().'admin/placement/'.$placement_id);
		}
		$data['placement_id']=$placement_id;	
		$this->load->view('head',$data);
		$this->load->view('admin_placement_view',$data);
		$this->load->view('foot',$data);
	}

	public function ajax_single_volunteer_unverified($verej,$user_id) //verej= "verify" OR "delete"
	{
		$this->check_status();
		if($verej=="verify")
		{
			$this->db->simple_query('UPDATE user_table SET verified="1" WHERE id="'.$user_id.'" AND type="volunteer"');
			echo "";
			return;
		}
		else if($verej=="delete")
		{
			$this->db->simple_query('DELETE FROM user_table WHERE id="'.$user_id.'" AND type="volunteer"');
			echo "";
			return;
		}
		else
		{
			$this->load->model('admin_model');
			$val = $this->db->simple_query('SELECT * FROM user_table WHERE id="'.$user_id.'"');
			$row = mysqli_fetch_array($val);
			$message = $this->admin_model->single_unverified_volunteer_row( $row , 1);
			echo $message;
		}
	}
	public function ajax_ind_placement($placement_id=NULL, $user_id, $hide=NULL)
	{
		$this->check_status2();
			$url=base_url();
			$url.=$this->session->type;
			$url.='/user/'.$user_id;
		$val=$this->db->simple_query('SELECT * FROM user_table WHERE id="'.$user_id.'"');
		$row=mysqli_fetch_array($val);
		$this->load->model('academic_model');
		$pairs= $this->academic_model->get_pairs($row['course'],$row['btech_type']);
		$individuals=$this->academic_model->get_individuals($row['course'],$row['btech_type']);
		echo '<div class="table-responsive">';
			echo '<table class="table table-hover">';
			echo '<tr> <th>Name</th> <td>'.$row['name'].'</td> </tr>';
			echo '<tr> <th>Admission Number</th> <td>'.$row['admission_no'].'</td> </tr>';
			echo '<tr> <th>Gender</th> <td>'.$row['gender'].'</td> </tr>';
			echo '<tr> <th>Class</th> <td>'.$row['class'].'</td> </tr>';
			if($hide==NULL)
			{
				echo '<tr> <th class="text-primary">ACADEMIC DATA</th> <td></td> </tr>';
				foreach($individuals as $ind)
				{
					echo '<tr> <th>'.$this->academic_model->decode($ind).'</th> <td>'.$row[$ind];
					if($ind=='ARREAR_NO')
						{
							echo ' until '.$this->academic_model->decode($row['ARREAR_LAST']);
						}
					echo '</td> </tr>';
				}
				foreach($pairs as $ind)
				{
					if( $row[$ind.'-percent'] == NULL) break;
					echo '<tr> <th>'.$this->academic_model->decode($ind.'-percent').'</th> <td>'.$row[$ind.'-percent'].'</td> </tr>';
					echo '<tr> <th>'.$this->academic_model->decode($ind.'-CGPA').'</th> <td>'.$row[$ind.'-CGPA'].'</td> </tr>';
				}
			}
			else
			{
				$temp_val=$this->db->simple_query('SELECT placement_name from placement_main WHERE placement_id="'.$placement_id.'"');
				$row_val=mysqli_fetch_array($temp_val);
				echo '<h4 class="text-primary">'.$row_val['placement_name'].'</h4>';
			}
			echo '</table>';
			if($placement_id!=NULL)
			{
				$val=$this->db->simple_query('SELECT status,allocate_back_to FROM allocate_placement WHERE user_id="'.$user_id.'" AND placement_id="'.$placement_id.'"');
				$row= mysqli_fetch_array($val);
				if($row['status']=="-2")
					echo '<div class="text-primary">The user have already won the placement. <br/><strong>Degrade the user first using the UPGRADE page (admin power) to reject<br/></strong></div>';
				else if($row['status']=="3003")
				{
					echo '<form method="POST" action="'.$url.'">';
					echo '<input type="hidden" name="placement_id" value="'.$placement_id.'">';
					echo '<input type="checkbox" id="read_all"> I understand that I\'m going to reallocate this user to ';
						echo '<select name="allocate_back_to">';
						for($i=1 ; $i<=$row['allocate_back_to']; $i++)
						{
							if($i==$row['allocate_back_to']) $select="selected"; else $select="";
							echo '<option value="'.$i.'" '.$select.'> Qualified for Level '.$i.'</option>';
						}
						if($row['allocate_back_to']=='-2')
						{
							echo '<option value="-2"> Make user win the placement</option>';
						}
						echo '</select><br/>';
					echo '<input type="hidden" name="user_id" value="'.$user_id.'">';
					echo '<br/><input class="btn btn-primary" id="submit" disabled type="submit" name="reallocate" value="Reallocate">';
					echo '</form>';
				}
				else if($row['status']=="2502")
				{
					echo '<form method="POST" action="'.$url.'">';
					echo '<input type="hidden" name="placement_id" value="'.$placement_id.'">';
					echo '<input type="checkbox" id="read_all"> I understand that I\'m going to allow this user who have reached the placement threshold <br/>of 2 IT companies and 1 dream company back to ';
					echo '<select name="allocate_back_to">';
						for($i=1 ; $i<=$row['allocate_back_to']; $i++)
						{
							if($i==$row['allocate_back_to']) $select="selected"; else $select="";
							echo '<option value="'.$i.'" '.$select.'> Qualified for Level '.$i.'</option>';
						}
						if($row['allocate_back_to']=='-2')
						{
							echo '<option value="-2"> Make user win the placement</option>';
						}
						echo '</select><br/>';
					echo '<input type="hidden" name="user_id" value="'.$user_id.'">';
					echo '<br/><input class="btn btn-primary" id="submit" disabled type="submit" name="reallocate" value="Reallocate">';
					echo '</form>';
				}
				else
				{
					echo '<input type="checkbox" id="read_all"> I understand that I\'m going to reject this user from this placement.<br/>';
					echo '<form method="POST" action="'.$url.'">';
					echo '<input type="hidden" name="placement_id" value="'.$placement_id.'">';
					echo '<input type="hidden" name="user_id" value="'.$user_id.'">';
					echo '<br/><input class="btn btn-danger" id="submit" disabled type="submit" name="reject" value="Reject">';
					echo '</form>';
				}
				
			}
			
		echo '</div>';
	}

}