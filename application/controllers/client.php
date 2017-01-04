<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller {
		
	function __construct(){
			parent::__construct();				
	}


	public function data(){
		$this->load->model('client_model');
		if( $this->input->post( '_search' ) == 'true' ){
			$search_field = $this->input->post( 'searchField' );
			$search_string = $this->input->post( 'searchString' );
			$search_operation = $this->input->post( 'searchOper' );
			switch ( $search_operation ) {
			    case 'eq':
			        $where = "$search_field = $search_string";
			        break;
			    case 'ne':
			        $where = "$search_field <> $search_string";
			        break;
			    case 'bw':
			        $where = "$search_field like '$search_string%'";
			        break;
				case 'ew':
		        	$where = "$search_field like '%$search_string'";
		        	break;
				case 'en':
		        	$where = "$search_field not like '%$search_string'";
		        	break;
				case 'cn':
		        	$where = "$search_field like '%$search_string%'";
		        	break;
				case 'nc':					
		        	$where = "$search_field not like '%$search_string%'";
		        	break;
				case 'in':
					$search_string = '"' . str_replace(', ', '", "', $search_string) . '"' ;
		        	$where = "$search_field in ($search_string)";
		        	break;
				case 'ni':
					$search_string = '"' . str_replace(', ', '", "', $search_string) . '"' ;
		        	$where = "$search_field not in ($search_string)";
		        	break;
			}
			
			$sort_field = $this->input->post( 'sidx' );
			$sort_order = $this->input->post( 'asc' );
			$order_by = $sort_field . ' ' . $sort_order;
			
			$result = $this->client_model->get_all( 'tblclient', $where, $order_by);
		}else{
			$result = $this->client_model->get_all( 'tblclient' );	
		}				
		echo json_encode($result);
	}

	public function action(){
		$this->load->model('client_model');	
		$action = $this->input->post( 'oper' );	
		$clientID = $this->input->post( 'clientID' );		
		$table = 'tblclient';
		$id_field = 'clientId';				
		$response = FALSE;
		$this->db->trans_begin();
		switch ( $action ) {
		    case 'add':		        
				$client_name = $this->input->post( 'clientName' );				
				$data = array(
							   'clientName' => $client_name,
							   'isActive' => 'Y',
							   'createdBy' => $this->session->userdata('user_name'),
							   'dtCreated' => date("Y-m-d H:i:s")
							);
				$response = $this->client_model->add( $table, $data );
				if( $client_name = '' ){
					$response = FALSE;
				}								
		        break;
		    case 'edit':		
				$id = $this->input->post( 'clientID' );
				$where = array( $id_field => $id );		
				$client_name = $this->input->post( 'clientName' );
				$data = array(
							   'clientName' => $client_name,
							   'modifiedBy' => $this->session->userdata('user_name'),
							   'dtModified' => date("Y-m-d H:i:s")							   
							);
		        $response = $this->client_model->update( $table, $where, $data );
				if( $client_name = '' ){
					$response = FALSE;
				}
		        break;
		    case 'del':				
				$id = $this->input->post( 'id' );
				$where = array( $id_field => $id );
		        $response = $this->client_model->delete( $table, $where );
		        break;				
		}
		
		if ( ! $this->db->trans_status() === FALSE && $response )
		{
			$this->db->trans_commit();	
			echo 'Success';		
		}
		else
		{
			$this->db->trans_rollback();
			echo 'Error';
		}		
		
	}
	
}
