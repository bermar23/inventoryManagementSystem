<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adjustment extends CI_Controller {
		
function __construct(){
		parent::__construct();				
}


		public function index(){
				$this->load->view('templates/header');
				$this->load->view('addadjustment_view');
				$this->load->view('templates/footer');
		}
		
	public function add_transaction(){		
		$createdBy = $this->session->userdata('user_name');
        $transactionDate = date("Y-m-d H:i:s");
		$toLocationID = $this->input->post('location_id');
		
		$data = array(
            'toLocationID' => $toLocationID,
            'transactionDate' => $transactionDate,                                    
            'createdBy' => $createdBy,
			'transactionTypeID' => 2,
            'dtCreated' => $transactionDate            
        );
		
		if ( ! empty( $toLocationID ) )
		{
				$this->load->model('transaction_model');
				$result    =   $this->transaction_model->add_transaction($data);
				echo ( ! $result ? json_encode(array('result' => $result, 'response' => 'Success')) : json_encode(array('result' => $result, 'response' => 'Error')));						
		}				
		else
		{						
				echo json_encode(array('result' => $result, 'response' => 'Error'));
		}		
        
	}
		

		
	
}
