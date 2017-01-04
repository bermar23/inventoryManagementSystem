<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
Class Report_model Extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function searchCode($itemCode)
    {
    	$this->db->select('tblitem.itemCode,
    	tblitem.itemName,
    	tblinventory.locationID,
    	tblinventory.itemCode,
    	tblinventory.qtyConsigned,
    	tbllocation.locationName,
    	tbllocation.locationCode,
    	tblclient.clientName');
    	$this->db->from('tblitem');
		$this->db->join('tblinventory', 'tblitem.itemCode = tblinventory.itemCode');
		$this->db->join('tbllocation', 'tblinventory.locationID = tbllocation.locationID');
		$this->db->join('tblclient', 'tblclient.clientID = tbllocation.clientID');
		$whereItemCode = "(tblitem.itemCode LIKE '".$itemCode."')";
		$this->db->order_by("tblinventory.qtyConsigned", "desc");
		$this->db->where($whereItemCode);
		$query = $this->db->get();
    	return $query->result();	
    }
	//tblinventory.itemCode,
	function searchName($itemName){
        $this->db->select('tblitem.itemCode,
    	tblitem.itemName,
    	tblinventory.locationID,
    	
    	tblinventory.qtyConsigned,
    	tbllocation.locationName,
    	tbllocation.locationCode,
    	tblclient.clientName');
    	$this->db->from('tblitem');
		$this->db->join('tblinventory', 'tblitem.itemCode = tblinventory.itemCode');
		$this->db->join('tbllocation', 'tblinventory.locationID = tbllocation.locationID');
		$this->db->join('tblclient', 'tblclient.clientID = tbllocation.clientID');
		$whereItemName = "(tblitem.itemName LIKE '".$itemName."')";
		$this->db->order_by("tblinventory.qtyConsigned", "desc");
		$this->db->where($whereItemName);
		$query = $this->db->get();
    	return $query->result();	
    }
	
	function getName($q)
	{ 
	    $sql = $this->db->query('select * from tblitem where itemName like "%'.$q.'%" order by itemName');
		return $sql->result();
	}
	
	function getCode($q)
	{ 
	    $sql = $this->db->query('select * from tblitem where itemCode like "%'.$q.'%" order by itemCode');
		return $sql->result();
	}
  }  
?>