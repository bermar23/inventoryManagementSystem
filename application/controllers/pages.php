<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
		
		function __construct(){
				parent::__construct();
				$this->authenticate();
		}
	
	public function index()
	{
		
	}
	
	public function approval_module(){		
		$data['title'] = 'Approval';
		
		$this->load->model('trans_delivery_model');
		$this->load->model('trans_pullout_model');
		$this->load->model('trans_adjust_model');
		
		$data['delivery_count'] = $this->trans_delivery_model->count();
		$data['pullout_count'] = $this->trans_pullout_model->count();
		$data['adjust_count'] = $this->trans_adjust_model->count();
		
		$data['delivery_unapprove'] = $this->trans_delivery_model->get_unapprove();
		$data['pullout_unapprove'] = $this->trans_pullout_model->get_unapprove();
		$data['adjust_unapprove'] = $this->trans_adjust_model->get_unapprove();
		
		if($data['delivery_count'] === 0){
			$data['delivery_count'] = '';
		}
		
		if($data['pullout_count'] === 0){
			$data['pullout_count'] = '';
		}
		
		if($data['adjust_count'] === 0){
			$data['adjust_count'] = '';
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('approval_module', $data);
		$this->load->view('templates/footer', $data);
	}

	public function dashboard(){
		$this->load->view('templates/header');
		$this->load->view('dashboard_view');
		$this->load->view('templates/footer');
	}
	
	public function home_page(){
		$this->load->view('templates/header');
		$this->load->view('home_view');
		$this->load->view('templates/footer');
	}
	
	public function client(){
		$this->load->view('templates/header');
		$this->load->view('client_view');
		$this->load->view('templates/footer');
	}

	public function settings(){
		$this->load->view('templates/header');
		$this->load->view('settings_view');
		$this->load->view('templates/footer');
	}
	
	public function blank(){
		$this->load->view('templates/header');
		$this->load->view('blank_view');
		$this->load->view('templates/footer');
	}
	
	public function update_response(){
		$query = $this->db->query("SELECT * from tblusers;");
		
		echo '<br/>Select Query Response: <'.$this->db->affected_rows().'>';
		
		$query = $this->db->query("UPDATE tblusers set userName = 'bermar' where username = 'bermarb';");
		
		echo '<br/>UPDATE Query Response: <'.$this->db->affected_rows().'>';
		
	}
	
function authenticate()
{
   if (!$this->session->userdata('user_name'))
  {
  redirect('login');
  }
}

}
