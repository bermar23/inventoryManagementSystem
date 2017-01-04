<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
Class Client_model Extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all( $table = '', $where = '', $order_by = '', $group_by = '')
    {
    	$result_data = array();
    	$this->db->select( '*' );
		$this->db->from( $table );
		if( ! empty( $where ) ){
			$this->db->where( $where );	
		}
		if( ! empty( $group_by ) ){
			$this->db->group_by( $group_by );	
		}
		if( ! empty( $order_by ) ){
			$this->db->order_by( $order_by );	
		} 
		
		$query = $this->db->get();
		foreach ( $query->result() as $row ){			
			array_push( $result_data, $row );	
		}
		return $result_data;
    }
	
	function delete( $table, $where )
    {
    	if( empty( $where ) ){
    		return FALSE;
    	}
    	$query = $this->db->delete( $table, $where );
		//echo $this->db->last_query(); 
		return ( $query ? TRUE : FALSE );
    }
	
	function update( $table, $where, $data )
    {
    	if( empty( $where ) ){
    		return FALSE;
    	}
    	$this->db->where( $where );
		$query = $this->db->update( $table, $data );
		//echo $this->db->last_query();
		return ( $query ? TRUE : FALSE );
    }
	
	function add( $table, $data )
    {
    	$query = $this->db->insert( $table, $data ); 
		$id = $this->db->insert_id();
		//echo $this->db->last_query();
		return ( $id ? $id : FALSE );
    }
	
  }  
?>