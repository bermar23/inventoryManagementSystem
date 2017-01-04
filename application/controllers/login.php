<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index()
	{
		if (!$this->session->userdata('user_name'))
		{
		$this->load->view('login_view');
		}
		else{
				redirect('home');
		}
		
	}
	
	public function process(){
		//$this->load->library('form_validation');		
		$this->load->model('login_model');
		
		$result = $this->login_model->validate();
		//$this->form_validation->set_rules('username', 'Username', 'required');
		//$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($result === FALSE)
		{
			//echo "FALSE";
			//$this->load->view('login_view');
			redirect('login');
		}
		else
		{		
			//$this->load->view('templates/header');
			//$this->load->view('home_view');
			//$this->load->view('templates/footer');
			redirect('home');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
}
