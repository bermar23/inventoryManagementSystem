<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

  function __construct()
  {
    parent::__construct();
	$this->authenticate();
    $this->load->model('report_model','',TRUE);
  }

  function index()
  {
	$data['transaction_title'] = 'Reports';
	
  	$this->load->helper('form');

	$this->load->view('templates/header', $data);
	$this->load->view('search_view'); 
	$this->load->view('templates/footer', $data);
      
  }  
	
  function search()
	{
		$itemName    =   $this->input->post('itemName');
		$itemCode    =   $this->input->post('itemCode');
		
		if (empty($itemCode) and !empty($itemName))
			{
			$result    =   $this->report_model->searchName($itemName);
			echo json_encode(array('result' => $result, 'response' => 'Success'));
			//$this->load->view('result',$data);
			}
		else if (!empty($itemCode) and empty($itemName))
			{
			$result    =   $this->report_model->searchCode($itemCode);
			echo json_encode(array('result' => $result, 'response' => 'Success'));
			//$this->load->view('result',$data);
			}
		else
			{
				//$this->load->view('search_view_textfield');
				echo "I do not know what happen";
			}
	}
	
  public function itemName()
	{
	  if (!isset($_GET['term']))
	  exit;
	  $term = $_GET['term'];
		  $data = array();
		  $rows = $this->report_model->getName($term);
			  foreach( $rows as $row )
			  {
				  $data[] = array(
					  'label' => $row->itemCode.'--> '. $row->itemName,
					  'value' => $row->itemName);  
			  }
		  echo json_encode($data);
	}
	
	public function itemCode()
	{
	  if (!isset($_GET['term']))
	  exit;
	  $term = $_GET['term'];
		  $data = array();
		  $rows = $this->report_model->getCode($term);
			  foreach( $rows as $row )
			  {
				  $data[] = array(
					  'label' => $row->itemCode.'--> '. $row->itemName,
					  'value' => $row->itemCode);  
			  }
		  echo json_encode($data);
	}

  function authenticate()
	{	
	  if (!$this->session->userdata('user_name'))
	  {
	  redirect('login');
	  }
	}
  
}

