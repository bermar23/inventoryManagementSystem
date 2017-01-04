<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Description: Login model class
 */
class Transaction_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function approve_transaction(){
        $modified_by = $this->session->userdata('user_name');
        $comments = $this->input->post('comments');
        $modified_date = date("Y-m-d H:i:s");
        
        $result = $this->db->query("UPDATE tbltransactionsummary
                                    SET tbltransactionsummary.status = 'A', modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "', comments = '" . $comments . "'
                                    WHERE tbltransactionsummary.transactionSummaryID = " . $this->input->post('transaction_id') . ";");
        if($result){
            return true;
        }
        
        return false;
    }
    
    public function disapprove_transaction(){
        $modified_by = $this->session->userdata('user_name');
        $comments = $this->input->post('comments');
        $modified_date = date("Y-m-d H:i:s");
        
        $result = $this->db->query("UPDATE tbltransactionsummary
                                    SET tbltransactionsummary.status = 'D', modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "', comments = '" . $comments . "'
                                    WHERE tbltransactionsummary.transactionSummaryID = " . $this->input->post('transaction_id') . ";");
        if($result){
            return true;
        }
        
        return false;
    }
    
    public function get_details(){
        //Get Transaction details
        $result_info = $this->db->query("SELECT
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
                                                summary.transactionSummaryID = " . $this->input->post('transaction_id') . "
                                            GROUP BY
                                                summary.transactionSummaryID;");
        
        //Get Item details        
        $result_items = $this->db->query("SELECT tbltransaction.transactionID, tbltransaction.itemCode, tblitem.itemName, tbltransaction.fromQtyConsigned, tbltransaction.fromLocationID, tbltransaction.toLocationID
                                                FROM
                                                    tbltransaction
                                                INNER JOIN
                                                    tblitem
                                                ON
                                                    tbltransaction.itemCode = tblitem.itemCode
                                                WHERE
                                                tbltransaction.transactionSummaryID = " . $this->input->post('transaction_id') . ";");
        $result = array('info' => $result_info->result(), 'items' => $result_items->result());
        
        return $result;
    }
    
    public function update_details(){        
        $modified_by = $this->session->userdata('user_name');
        $modified_date = date("Y-m-d H:i:s");
        
        $transaction_id = trim($this->input->post('transactionID'));        
        $location_from = trim($this->input->post('fromLocationID'));
        $location_to = trim($this->input->post('toLocationID'));        
        $qty_consigned = trim($this->input->post('qtyConsigned'));        
        $adjustment = trim($this->input->post('adjustment'));
        $item_code = trim($this->input->post('itemCode'));
        
        if($adjustment === ''){
            $adjustment = 0;
        }        
        
        $qty_adjustment = $adjustment - $qty_consigned;
        
        //Update Transaction Details
        $result_details = $this->db->query("UPDATE tbltransaction
                                        SET tbltransaction.fromQtyConsigned = " . $adjustment . ", tbltransaction.toQtyConsigned = " . $adjustment . ", tbltransaction.qtyAdjusted = " . $qty_adjustment . ", 
                                        modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "'
                                        WHERE tbltransaction.transactionID = " . $transaction_id . ";");

        if($result_details){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function add_transaction($data){
        /*$data = array(
            'fromLocationID' => '' ,
            'transactionDate' => '' ,
            'deliveryNo' => '',
            'batchNo' => '',
            'transactionReasonID' => '',
            'comments' => '',
            'createdBy' => '',
            'dtCreated' => '',
            'status' => 'U',
            'modifiedBy' => '',
            'dtModified' => '',
            'accountManagerID' => '',
            'totalAmount' => '',
            'complimentedTo' => '',
            'isComplimentary' => '',            
            'dtPrepared' => ''
        );*/
        
        $this->db->insert('tbltransactionsummary', $data);
        $transaction_id = $this->db->insert_id();
        return ( ! $transaction_id  ? FALSE : $transaction_id);
    }
}
?>