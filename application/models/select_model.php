<?php
class Select_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();		
	}

	public function location_code_data()
	{
		$locationcode_query = $this->db->query('select tbllocation.locationID,tbllocation.locationName,tbllocation.locationCode from tbllocation;');
            
		$data = array();
		foreach ($locationcode_query->result() as $locationcode_row)
		{
			$label = $locationcode_row->locationCode . ' | ' . $locationcode_row->locationName;
			$data[] = array($locationcode_row->locationCode => $label);		   
		}
		
		return json_encode(array('type_list' => $data));
	}
	
	public function item_code_data()
	{
		$itemcode_query = $this->db->query('select tblitem.itemID,tblitem.itemName,tblitem.itemCode from tblitem;');
            
		$data = array();
		foreach ($itemcode_query->result() as $itemcode_row)
		{
			$label = $itemcode_row->itemCode . ' | ' . $itemcode_row->itemName;
			$data[] = array($itemcode_row->itemCode => $label);		   
		}
		
		return json_encode(array('type_list' => $data));
	}

}


    