<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class Trans_adjust_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function count(){
        $result = $this->db->query("SELECT transactionSummaryID FROM tbltransactionsummary WHERE tbltransactionsummary.transactionTypeID = '2' and tbltransactionsummary.status='U';");        
        return $result->num_rows;
    }
    
    public function get_unapprove(){
        $result = $this->db->query("SELECT
                                        summary.transactionSummaryID, summary.transactionDate,
                                        (SELECT tbllocation.locationName from tbllocation WHERE details.fromLocationID = tbllocation.locationID) AS locationFrom,
                                        (SELECT tbllocation.locationName from tbllocation WHERE details.toLocationID = tbllocation.locationID) AS locationTo
                                    FROM
                                        tbltransactionsummary AS summary
                                    INNER JOIN
                                        tbltransaction AS details
                                    ON
                                        summary.transactionSummaryID = details.transactionSummaryID
                                    WHERE
                                        summary.transactionTypeID = '2' and summary.status='U'
                                    GROUP BY
                                        summary.transactionSummaryID;");        
        return $result->result();    
    }
    
    public function adjust(){
        
    }
    
	function getLocation($q)
	{ 
	    $sql = $this->db->query('SELECT
                                    tbllocation.locationCode, tbllocation.locationName, tblclient.clientName                                
                                FROM tbllocation
                                INNER JOIN tblclient
                                ON
                                    tbllocation.clientID = tblclient.clientID
                                WHERE
                                    tbllocation.locationName like "%'.$q.'%"
                                ORDER BY
                                    tbllocation.locationName
                                LIMIT 20');
        //echo $sql;
		return $sql->result();
	}
    
	function getLocationDetails($code)
	{ 
	    $sql = $this->db->query('SELECT
                                    tbllocation.locationCode, tbllocation.locationID, tbllocation.locationName, tblclient.clientName                                
                                FROM tbllocation
                                INNER JOIN tblclient
                                ON
                                    tbllocation.clientID = tblclient.clientID
                                WHERE
                                    tbllocation.locationCode = "'.$code.'"
                                ORDER BY
                                    tbllocation.locationName');
        
		return $sql->result();
	}
    
    public function view_item_details($location_id, $item_code){
        
        $sql = $this->db->query('SELECT
                                    tblinventory.locationID, tblitem.isbn, tblitem.itemCode, tblitem.itemName, tblinventory.qtyConsigned
                                FROM tblinventory
                                INNER JOIN tblitem
                                ON
                                   tblitem.itemCode = tblinventory.itemCode
                                WHERE
                                    tblinventory.itemCode = "'.$item_code.'" and tblinventory.locationID = "'.$location_id.'"
                                ORDER BY
                                    tblinventory.itemCode');
        
		return $sql->result();
    }
    
	function getItemCode($term, $location_id)
	{ 
	    $sql = $this->db->query('SELECT
                                    tblitem.isbn, tblitem.itemCode, tblitem.itemName, tblinventory.qtyConsigned
                                FROM tblinventory
                                INNER JOIN tblitem
                                ON
                                   tblitem.itemCode = tblinventory.itemCode
                                WHERE
                                    tblinventory.itemCode like "%'.$term.'%" and tblinventory.locationID = '.$location_id.'
                                ORDER BY
                                    tblinventory.itemCode');
		return $sql->result();
	}
  
  function additem_from_existing($item_code, $location_id, $new_quantity)
	{
		//Add transaction
		$data = array(
			'title' => 'My title' ,
			'name' => 'My Name' ,
			'date' => 'My date'
		);
		
		$this->db->insert('tbltransaction', $data); 
		
		//Get the last added ID
		
		
		//Add transaction details
		
        $modified_by = $this->session->userdata('user_name');
        $modified_date = date("Y-m-d H:i:s");
        
        $item_response = $this->db->query("UPDATE tblinventory
                                    SET tblinventory.qtyConsigned = " . $new_quantity . ", modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "'
                                    WHERE tblinventory.itemCode = '" . $item_code . "' and locationID = " . $location_id .  ";");
        
        if( ! $this->db->affected_rows() > 0 ){
            return FALSE;
        }
    }
    
  function add_item()
	{
        $item_code    =   $this->input->post('new_item_item_code');
        $item_name    =   $this->input->post('new_item_item_name');
        $location_code   =   $this->input->post('new_item_location_code');
        $location_id   =   $this->input->post('new_item_location_id');
        $quantity   =   $this->input->post('new_item_quantity');
        $reason   =   $this->input->post('new_item_reason');
        
        $modified_by = $this->session->userdata('user_name');
        $modified_date = date("Y-m-d H:i:s");
        
        //$item_response = $this->db->query("UPDATE tblinventory
        //                            SET tblinventory.qtyConsigned = " . $new_quantity . ", modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "'
        //                            WHERE tblinventory.itemCode = '" . $item_code . "' and locationID = " . $location_id .  ";");
        
        $item_response = $this->db->query("Insert into tblinventory (qtyConsigned,locationID,itemCode,createdBy,dtCreated) values (" . 
						$quantity . ", " . $location_id . ",'" . $item_code . "','" . $modified_by . "','" . $modified_date . "');");
        
        if($item_response){
            return TRUE;
        }
        
        return FALSE;
    }
	
	
	
	
}
?>