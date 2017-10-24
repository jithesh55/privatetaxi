<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate extends CI_Controller {

    	
	public function check_status()
	{

		$this->load->model('check_for_cookie'); 
		if(!$this->session->has_userdata('type'))
		{
			header('Location:'.base_url());
			exit();
		}
		else
			if ($this->session->type!='candidate') {
				header('Location:'.base_url());
				exit();
			}
	}

	public function index()
	{
		$this->check_status();
		$this->load->model('candidate_model');
		$name=$this->candidate_model->get_param('name');
		$this->load->model('class_convertion_model');
		$data['title']=$name." | Candidate Portal";
		$data['name']= $name;
		$data['has_started']= $this->candidate_model->has_started();
		$data['personal_details']=$this->candidate_model->get_personal();
		$data['course']=$this->candidate_model->get_personal('course');
		$data['branch']=$this->candidate_model->get_personal('branch');
		$data['branch']=$this->class_convertion_model->convert($data['branch']);

		$this->load->view('head',$data);
		$this->load->view('show_admin_message',$data);
		$this->load->view('candidate_console_view',$data);
		$data['placement_id']=NULL;
		$this->load->view('candidate_all_placement_view',$data);
		$this->load->view('foot',$data);
	}
    public function add_data()
    {
        $this->check_status();
		$this->load->model('candidate_model');
		$this->load->model('academic_model');
		
		
			
		
		$data['title']="ADD DETAILS| Candidate Portal";
		$course =$this->candidate_model->get_individual_from_user_table('course');
		$type =$this->candidate_model->get_individual_from_user_table('btech_type');
		$data['individuals']= $this->academic_model->get_individuals($course,$type);
		$data['pairs']= $this->academic_model->get_pairs($course,$type);
		if(isset($_POST['add_detail']))
		{
			$result = $this->academic_model->details($this->session->user_id,$course,$type,$data['individuals'],$data['pairs'], $_FILES);
		}
		$data['previous']=$this->academic_model->get_submitted_for_update();
		$data['current']=$this->academic_model->get_current_academic();
		$this->load->view('head',$data);
		$this->load->view('add_details',$data);
		$this->load->view('foot',$data);
        
        if(isset($_POST['add_detail']))
		{
			$result = $this->academic_model->details($this->session->user_id,$course,$type,$data['individuals'],$data['pairs'], $_FILES);
		}
        
    }
	public function update_academic($version=NULL)
	{
		$this->check_status();
		$this->load->model('candidate_model');
		$this->load->model('academic_model');
		if($this->candidate_model->has_started()==0)
		{
			header('Location:'.base_url().'candidate/start_academic');
			return;
		}
		$data['title']="Update Academic Details | Candidate Portal";
		$course =$this->candidate_model->get_individual_from_user_table('course');
		$type =$this->candidate_model->get_individual_from_user_table('btech_type');
		$data['individuals']= $this->academic_model->get_individuals($course,$type);
		$data['pairs']= $this->academic_model->get_pairs($course,$type);
		if(isset($_POST['submit']))
		{
			$result = $this->academic_model->submit($this->session->user_id,$course,$type,$data['individuals'],$data['pairs']);
			$data['result']=$result;
		}
		$data['previous']=$this->academic_model->get_submitted_for_update();
		$data['current']=$this->academic_model->get_current_academic();
		$this->load->view('head',$data);
		$this->load->view('update_academic_view',$data);
		$this->load->view('foot',$data);
	}
	public function placement($placement_id=NULL)
	{

		$this->check_status();
		$this->load->model('candidate_model');
		$this->load->model('class_convertion_model');
		$data['title']="Placement | Training and Placement Cell";
		$data['user_id']=$this->session->user_id;
		$data['placement_id']=$placement_id;
		$data['course']=$this->candidate_model->get_personal('course');
		$data['branch']=$this->candidate_model->get_personal('branch');
		$data['branch']=$this->class_convertion_model->convert($data['branch']);

		if(isset($_POST['apply']) && $placement_id!=NULL)
		{
			$data['result']=$this->candidate_model->apply($placement_id);
		}
		$this->load->view('head',$data);

		$data['res']=$this->candidate_model->get_qualified($this->session->user_id,$placement_id);
		$this->load->view('candidate_all_placement_view',$data);
		$this->load->view('foot',$data);

	}
 
	public function start_academic()
	{
		$this->check_status();
		$this->load->model('candidate_model');
		$data['title']="Training and Placement Cell";
		$val = $this->db->simple_query('SELECT course FROM user_table WHERE id="'.$this->session->user_id.'"');
		$row=mysqli_fetch_array($val);

		if($this->candidate_model->has_started()==1)
		{	
			header('Location:'.base_url().'candidate/update_academic');
			return;
		}

		if(isset($_POST['submit']))
		{
			if(!empty($_POST['btech_type']))
			{
				if($this->candidate_model->has_started()==0)
				{
					$btech_type=trim($_POST['btech_type']);
					$this->db->simple_query('UPDATE user_table SET btech_type="'.$btech_type.'" WHERE id="'.$this->session->user_id.'"');
					header('Location:'.base_url().'candidate/update_academic');
					return;
				}
			}
		}
		
		$this->load->view('head',$data);
		$this->load->view('btech_type_input_view');
		$this->load->view('foot',$data);
		
	}
}