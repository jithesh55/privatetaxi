<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Volunteer extends CI_Controller {

	public function check_status()
	{

		$this->load->model('check_for_cookie'); 
		if(!$this->session->has_userdata('type'))
		{
			header('Location:'.base_url());
			exit();
		}
		else
			if ($this->session->type!='volunteer') {
				header('Location:'.base_url());
				exit();
			}
	}

	public function index()
	{
		$this->check_status();
		$this->load->model('volunteer_model');
		$data['title']="Volunteer Console | Training and Placement Cell ";

		$val = $this->db->simple_query('SELECT name,class FROM user_table WHERE id="'.$this->session->user_id.'"');
		$row =  mysqli_fetch_array($val);
		$data['name'] = $row['name'];
		$this->load->model('class_convertion_model');
		$this->load->model('candidate_model');
		$data['class'] = $this->class_convertion_model->add_remark_to_shortened_class($row['class']);
		$data['course']=$this->candidate_model->get_personal('course');
		$data['branch']=$this->candidate_model->get_personal('branch');
		$data['branch']=$this->class_convertion_model->convert($data['branch']);
		
		$data['list']=$this->volunteer_model->get_to_verify_academic();

		$this->load->model('volunteer_model');
		$data['unverified_num'] = $this->volunteer_model->get_unverified_candidates_num();
		if($data['unverified_num'] > 0)
			$data['unverified'] = $this->volunteer_model->get_unverified_candidates();

		$this->load->view('head',$data);
		$this->load->view('show_admin_message',$data);
		$this->load->view('volunteer_console_view',$data);
		$this->load->view('foot', $data);
	}
	public function change_pw()
	{
		$this->check_status();
		$data['title']="Change password | Training and Placement Cell | Mar Athanasius College of Engineering, Kothamangalam";

		$this->load->view('head',$data);
		$this->load->view('volunteer_change_pw',$data);
		$this->load->view('foot',$data);

	}
	public function placement($placement_id=NULL)
	{
		$this->check_status();
		$this->load->model('admin_model');
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
		$data['placement_id']=$placement_id;	
		$this->load->view('head',$data);
		$this->load->view('volunteer_placement_view',$data);
		$this->load->view('foot',$data);
	}

	public function user($user_id=NULL)
	{
		$this->check_status();
		$this->load->model('candidate_model');
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
			$res_values=$this->load->candidate_model->get_personal(NULL,$user_id);
			$res_values= '<h3>Candidate Details</h3><br/>'.$res_values;
			$data['res_values']=$res_values;
			$this->load->view('full_details',$data);
			$this->load->view('foot',$data);
		}
	}
	public function search()
	{
		$this->check_status();
		$this->load->model('volunteer_model');
		$data['title']="Volunteer Search | Training and Placement Cell ";

		$val = $this->db->simple_query('SELECT name,class FROM user_table WHERE id="'.$this->session->user_id.'"');
		$row =  mysqli_fetch_array($val);
		$data['name'] = $row['name'];
		$data['class'] = $row['class'];
		$this->load->view('head',$data);
		$this->load->view('volunteer_search_view',$data);
		$this->load->view('foot', $data);
	}
	public function academic_verify($user_id=NULL)
	{
		$this->check_status();
		$this->load->model('volunteer_model');
		$this->load->model('academic_model');
		$data['result']=array("");
		$data['user_id']=$user_id;
		if($user_id!=NULL)
		{
			$data['result']=$this->volunteer_model->get_all_to_verify(trim( $user_id));

			if(isset($_POST['verifybtech_submit']) ||isset($_POST['rejectbtech_submit']))
			{
				if(isset($_POST['rejectbtech_submit']))
				{
					if($data['result'][0]!="error")
					{
						$this->db->simple_query('DELETE FROM academic_verify WHERE user_id="'.$user_id.'"');
						$this->db->simple_query('UPDATE user_table SET btech_type=NULL, btech_type_check="0" WHERE id="'.$user_id.'"');
						header('Location:'.base_url().'volunteer/academic_verify');
					}
				}
				else if(isset($_POST['verifybtech_submit']))
				{
					if($data['result'][0]!="error")
					{
						$this->db->simple_query('UPDATE user_table SET btech_type_check="1" WHERE id="'.$user_id.'"');
						$data['result']=$this->volunteer_model->get_all_to_verify(trim( $user_id));
					}
				}
			}
			if(isset($_POST['verify']) ||isset($_POST['reject']))
			{
				$id=$_POST['id'];
				if(isset($_POST['reject']))
				{
					if($data['result'][0]!="error")
					{
						$val=$this->db->simple_query('SELECT id FROM update_academic WHERE id="'.$id.'"');
						if(mysqli_num_rows($val) <1)
						{
							$data['result']=array("error","Seems that the user have submitted a new data set.");
						}
						else
						{
							$this->db->simple_query('DELETE FROM update_academic WHERE id="'.$id.'"');
							header('Location:'.base_url().'volunteer/academic_verify');
						}
						
					}
				}
				else if(isset($_POST['verify']))
				{
					if($data['result'][0]!="error")
					{
						$this->volunteer_model->verify_academic($id,$user_id);
					}
				}
			}
		}



		$data['title']="Verify academic details";
		$data['list']=$this->volunteer_model->get_to_verify_academic();
		$this->load->view('head',$data);
		$this->load->view('volunteer_academic_verify_view',$data);
		$this->load->view('foot',$data);
	}
	public function ajax_single_candidate_unverified($verej,$user_id) //verej= "verify" OR "delete"
	{
		$this->check_status();
		$this->load->model('volunteer_model');

		if($verej=="verify")
		{
			$this->db->simple_query('UPDATE user_table SET verified="1" WHERE id="'.$user_id.'" AND type="candidate" AND class="'.$this->volunteer_model->get_class().'"');
			$data = array(
		   'user_id'=> $user_id,
		   'type' => 'initial_full',
		   'volunteer_id' => $this->session->user_id
			);
			$this->db->insert('track_verification', $data);
			echo "";
			return;
		}
		else if($verej=="delete")
		{
			$this->db->simple_query('DELETE FROM user_table WHERE id="'.$user_id.'" AND type="candidate" AND class="'.$this->volunteer_model->get_class().'"');
			echo "";
			return;
		}
		else
		{
			$val = $this->db->simple_query('SELECT * FROM user_table WHERE id="'.$user_id.'"');
			$row = mysqli_fetch_array($val);
			$message = $this->admin_model->single_unverified_volunteer_row( $row , 1);
			echo $message;
		}
	}
}