<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller {
		
		function __construct(){
				parent::__construct();
				$this->authenticate();
		}
		
		
	public function index(){
		$this->load->helper('date');
		
		$data['title'] = 'Approval';
		$this->load->model('trans_delivery_model');
		$this->load->model('trans_pullout_model');
		$this->load->model('trans_adjust_model');
		
		$data['delivery_count'] = $this->trans_delivery_model->count();
		$data['pullout_count'] = $this->trans_pullout_model->count();
		$data['adjust_count'] = $this->trans_adjust_model->count();
		
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
		
	public function approve(){
		$transaction_type = $this->input->post('transaction_type');
		
		$this->load->model('transaction_model');
		
		//Will update the transaction summary
		$respose = $this->transaction_model->approve_transaction();
		
		if($respose){
			if($transaction_type === 'pullout'){
				$this->load->model('trans_pullout_model');
				
				//Pull-out
				$pullout_response = $this->trans_pullout_model->pullout();
				
				//Get-unapprove
				$return_value = $this->trans_pullout_model->get_unapprove();
				if($pullout_response){
						echo json_encode(array('transaction_result' => $return_value));
				}
				else{
						echo json_encode(array('transaction_result' => 'Error'));
				}
			}
			elseif($transaction_type === 'adjust'){
				$this->load->model('trans_adjust_model');
				//Get-unapprove
				$return_value = $this->trans_adjust_model->get_unapprove();			
				echo json_encode(array('transaction_result' => $return_value));			
			}
			elseif($transaction_type === 'delivery'){
				$this->load->model('trans_delivery_model');
				
				//Deliver
				$delivery_response = $this->trans_delivery_model->deliver();
				
				//Get-unapprove
				$return_value = $this->trans_delivery_model->get_unapprove();
				if($delivery_response){
						echo json_encode(array('transaction_result' => $return_value));
				
				}
				else{
						echo json_encode(array('transaction_result' => 'Error'));
				}
			}
			else{
				return;
			}
		}
		else{
			echo json_encode(array('transaction_result' => 'Error'));
		}
	}
	
	public function edit_details(){
		if(trim($this->input->post('adjustment')) >= 0){
		$this->load->model('transaction_model');
		$response = $this->transaction_model->update_details();
		
		//echo json_encode(array('result' => $this->input->post('transaction_number')));
		//echo json_encode($this->input->post());
		
		
		//echo json_encode(array('message' => 'Success'));
				if($response){
					echo 'Success';	
				}
				else{
					echo 'Server Error';	
				}
		
		}
		else{
				echo 'Input Error';
		}
	}
	
	public function details(){
		$transaction_type = $this->input->post('transaction_type');
		//$return_value = array();
		//if($return_value != ''){
			if($transaction_type === 'pullout'){
				$this->load->model('trans_pullout_model');
				$return_value = $this->trans_pullout_model->get_details();
				echo json_encode(array('info' => $return_value['info'], 'items' => $return_value['items'], 'response' => 'Success'));			
			}
			elseif($transaction_type === 'adjust'){								
				echo json_encode(array('info' => $return_value['info'], 'items' => $return_value['items'], 'response' => 'Success'));
			}
			elseif($transaction_type === 'delivery'){
				$this->load->model('trans_delivery_model');
				$return_value = $this->trans_delivery_model->get_details();
				echo json_encode(array('info' => $return_value['info'], 'items' => $return_value['items'], 'response' => 'Success'));			
			}
			else{
				return;
			}
		//}
		//else{
			//echo json_encode(array('transaction_result' => 'Error'));
		//}
	}
		
	public function approval_module($type = ''){
		$type = trim(strtolower($type));
		$data['title'] = 'Transaction';
		
		$this->load->model('trans_delivery_model');
		$this->load->model('trans_pullout_model');
		$this->load->model('trans_adjust_model');
		
		if( $type === 'pullout' ){
			$data['jqgrid_data'] = $this->trans_pullout_model->get_unapprove();
			$data['transaction_title'] = 'Pull-out Transaction Summary';
			$data['transaction_type'] = 'Pullout';			
			
			//Session
			$this->session->set_userdata(array('transaction' => 'pullout'));
			
			$this->load->view('templates/header', $data);
			$this->load->view('transaction_view', $data);
			$this->load->view('templates/footer', $data);
		}
		elseif( $type === 'adjust' ){			
			/*$data['jqgrid_data'] = $this->trans_adjust_model->get_unapprove();
			$data['transaction_title'] = 'Adjustment Transaction Summary';
			$data['transaction_type'] = 'Adjust';
			
			//Session
			$this->session->set_userdata(array('transaction' => 'adjust'));
			
			$this->load->view('templates/header', $data);
			$this->load->view('adjust_view', $data);
			$this->load->view('templates/footer', $data);*/
		}
		elseif( $type === 'delivery' ){			
			$data['jqgrid_data'] = $this->trans_delivery_model->get_unapprove();
			$data['transaction_title'] = 'Delivery Transaction Summary';
			$data['transaction_type'] = 'Delivery';
			
			//Session
			$this->session->set_userdata(array('transaction' => 'delivery'));
			
			$this->load->view('templates/header', $data);
			$this->load->view('transaction_view', $data);
			$this->load->view('templates/footer', $data);
		}
		else{
			$data['jqgrid_data'] = array();
			$data['transaction_title'] = 'Details';
			$data['transaction_type'] = 'undefined';
			
			$this->load->view('templates/header', $data);
			$this->load->view('transaction_view', $data);
			$this->load->view('templates/footer', $data);
		}
		
	}
	
		function authenticate()
		{
				if (!$this->session->userdata('user_name'))
				{
						redirect('login');
				}
		}
		
	public function disapprove(){
		$transaction_type = $this->input->post('transaction_type');
		
		$this->load->model('transaction_model');
		
		//Will update the transaction summary
		$respose = $this->transaction_model->disapprove_transaction();
		
		if($respose){
			if($transaction_type === 'pullout'){
				$this->load->model('trans_pullout_model');
				
				//Pull-out
				//$pullout_response = $this->trans_pullout_model->pullout();
				
				//Get-unapprove
				$return_value = $this->trans_pullout_model->get_unapprove();
				if($pullout_response){
						echo json_encode(array('transaction_result' => $return_value));
				}
				else{
						echo json_encode(array('transaction_result' => 'Error'));
				}
			}
			elseif($transaction_type === 'adjust'){
				$this->load->model('trans_adjust_model');
				//Get-unapprove
				$return_value = $this->trans_adjust_model->get_unapprove();			
				echo json_encode(array('transaction_result' => $return_value));			
			}
			elseif($transaction_type === 'delivery'){
				$this->load->model('trans_delivery_model');
				
				//Deliver
				//$delivery_response = $this->trans_delivery_model->deliver();
				
				//Get-unapprove
				$return_value = $this->trans_delivery_model->get_unapprove();
				if($delivery_response){
						echo json_encode(array('transaction_result' => $return_value));
				
				}
				else{
						echo json_encode(array('transaction_result' => 'Error'));
				}
			}
			else{
				return;
			}
		}
		else{
			echo json_encode(array('transaction_result' => 'Error'));
		}
	}
	
		public function location_name()
		{
				$this->load->model('trans_adjust_model');
				if ( ! isset($_GET['term']) ) exit;				
				$term = $_GET['term'];
				$data = array();
				$rows = $this->trans_adjust_model->getLocation($term);
				foreach( $rows as $row )
				{
						$data[] = array(
						'label' => $row->locationName.' | '. $row->clientName,
						'value' => $row->locationCode);  
				}
				echo json_encode($data);
				
		}
		
		public function get_location_details()
		{
				$this->load->model('trans_adjust_model');
				if ( ! isset($_GET['location_code']) ) exit;
				$code = $_GET['location_code'];
				$data = array();
				$rows = $this->trans_adjust_model->getLocationDetails($code);
				foreach( $rows as $row )
				{
						$data[] = array(
						'location_name' => $row->locationName,
						'location_id' => $row->locationID,
						'client_name' => $row->clientName,
						'location_code' => $row->locationCode);  
				}
				echo json_encode($data);
		}
		
		public function item_code()
		{				
				if ( ! isset($_GET['location_id']) || ! isset($_GET['term']) ) exit;
				$term = $_GET['term'];
				$location_id = $_GET['location_id'];
				$data = array();
				$this->load->model('trans_adjust_model');
				$rows = $this->trans_adjust_model->getItemCode($term, $location_id);
				foreach( $rows as $row )
				{
						$data[] = array(
								'label' => $row->itemCode.' | '. $row->itemName,
								'value' => $row->itemCode
						);  
				}
				echo json_encode($data);
		}
		
		function adjust_search()
		{
				$location_id    =   $this->input->post('location_id');
				$item_code    =   $this->input->post('item_code');
				
				if ( ! empty($location_id) && ! empty($item_code))
				{
						$this->load->model('trans_adjust_model');
						$result    =   $this->trans_adjust_model->view_item_details($location_id, $item_code);
						echo json_encode(array('result' => $result, 'response' => 'Success'));						
				}				
				else
				{						
						echo "Parameters empty!";
				}
		}
		
		function add_item()
		{		
				$this->load->model('trans_adjust_model');
				$result = $this->trans_adjust_model->add_item();
				
				if($result){
						echo json_encode(array('transaction_result' => $result));
				
				}
				else{
						echo json_encode(array('transaction_result' => 'Error'));
				}
		}
}
