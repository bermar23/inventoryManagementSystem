<?php

class Select_data extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('select_model');
	}

	public function location_code_select()
	{	
		$result = $this->select_model->location_code_data();		
		echo $result;
	}
	
	public function item_code_select()
	{	
		$result = $this->select_model->item_code_data();		
		echo $result;
	}

}



