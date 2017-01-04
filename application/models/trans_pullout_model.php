<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class Trans_pullout_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function count(){
        $result = $this->db->query("SELECT transactionSummaryID FROM tbltransactionsummary WHERE tbltransactionsummary.transactionTypeID = '3' and tbltransactionsummary.status='U';");        
        return $result->num_rows;
    }
    
    public function get_unapprove(){
        $result = $this->db->query("SELECT
                                        summary.transactionSummaryID, summary.deliveryNo, summary.transactionDate,
                                        (SELECT tbllocation.locationName from tbllocation WHERE details.fromLocationID = tbllocation.locationID) AS locationFrom,
                                        details.fromLocationID,
                                        (SELECT tbllocation.locationName from tbllocation WHERE details.toLocationID = tbllocation.locationID) AS locationTo,
                                         details.toLocationID,
                                         summary.createdBy
                                    FROM
                                        tbltransactionsummary AS summary
                                    INNER JOIN
                                        tbltransaction AS details
                                    ON
                                        summary.transactionSummaryID = details.transactionSummaryID
                                    WHERE
                                        summary.transactionTypeID = '3' and summary.status='U'
                                    GROUP BY
                                        summary.transactionSummaryID;");        
        return $result->result();    
    }
    
    public function get_details(){
        //Get Transaction details
        $result_info = $this->db->query("SELECT
                                                summary.transactionSummaryID, summary.transactionDate,
                                                (SELECT tbllocation.locationName from tbllocation WHERE details.fromLocationID = tbllocation.locationID) AS locationFrom,                                                
                                                (SELECT tbllocation.locationName from tbllocation WHERE details.toLocationID = tbllocation.locationID) AS locationTo,
                                                summary.deliveryNo,
                                                summary.dtCreated,
                                                (SELECT CONCAT(contact.lname , ', ', contact.fname, ' ', contact.mname)  from tblcontact AS contact WHERE contact.contactID = summary.accountManagerID) AS accountManager
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
        $result_items = $this->db->query("SELECT tbltransaction.transactionID, tbltransaction.itemCode, tblitem.itemName, tbltransaction.toQtyConsigned AS qtyConsigned, tbltransaction.fromLocationID, tbltransaction.toLocationID
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
    
    public function pullout(){
        $modified_by = $this->session->userdata('user_name');
        $modified_date = date("Y-m-d H:i:s");
        
        $transaction_id = $this->input->post('transaction_id');
        
        $from_location_id = $this->input->post('from_location_id');
        $to_location_id = $this->input->post('to_location_id');
        
        //Get Items in the transaction
        $transaction_items = $this->db->query("SELECT tbltransaction.transactionID, tbltransaction.itemCode, tbltransaction.fromQtyConsigned
                                                FROM
                                                    tbltransaction
                                                INNER JOIN
                                                    tblitem
                                                ON
                                                    tbltransaction.itemCode = tblitem.itemCode
                                                WHERE
                                                tbltransaction.transactionSummaryID = " . $transaction_id . ";");
        
        //Update item status to approved
        $approve_item_status = $this->db->query("UPDATE tbltransaction
                                                SET tbltransaction.status = 'A'
                                                WHERE 
                                                tbltransaction.transactionSummaryID = " . $transaction_id . ";");
        
        foreach ($transaction_items->result() as $row_item)
        {
            //For each pullout item Update individually the Inventory add the QTY to Inventory Quantity
            $item_id = $row_item->transactionID;
            $item_code = $row_item->itemCode;
            $item_qty = $row_item->fromQtyConsigned;
            
            //Deduct stock from the source
            
            //Get stock count of the Given Item from source
            $source_stock_query = $this->db->query("SELECT tblinventory.qtyConsigned FROM tblinventory WHERE tblinventory.itemCode = '" . $item_code . "' and locationID = " . $from_location_id .  ";");
            
            //Get the stock count from source
            //Initialize
            $source_stock_count = 0;
            
            foreach ($source_stock_query->result() as $source_row_inventory)
            {
               $source_stock_count += $source_row_inventory->qtyConsigned;
            }
            
            //calculate the new deducted count of the source
            $source_new_stock = $source_stock_count - $item_qty;
            
            //Update the source stock count in the database
            $response_source = $this->db->query("UPDATE tblinventory
                                    SET tblinventory.qtyConsigned = " . $source_new_stock . ", modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "'
                                    WHERE tblinventory.itemCode = '" . $item_code . "' and locationID = " . $from_location_id .  ";");
            
            //Add stock from the destination
            
            //Get stock count of the Given Item from destination
            $destination_stock_query = $this->db->query("SELECT tblinventory.qtyConsigned FROM tblinventory WHERE tblinventory.itemCode = '" . $item_code . "' and locationID = " . $to_location_id .  ";");
            
            //Get the stock count from destination
            //Initialize
            $destination_stock_count = 0;
            
            foreach ($destination_stock_query->result() as $destination_row_inventory)
            {
               $destination_stock_count += $destination_row_inventory->qtyConsigned;
            }
            
            //calculate the new deducted count of the source
            $destination_new_stock = $destination_stock_count + $item_qty;
            
            //Update the destination stock count in the database
            $response_destination = $this->db->query("UPDATE tblinventory
                                    SET tblinventory.qtyConsigned = " . $destination_new_stock . ", modifiedBy = '" . $modified_by . "', dtModified = '" . $modified_date . "'
                                    WHERE tblinventory.itemCode = '" . $item_code . "' and locationID = " . $to_location_id .  ";");
            
            if( ! $this->db->affected_rows() > 0 ){
                $response_destination = $this->db->query("Insert into tblinventory (qtyConsigned,locationID,itemCode,modifiedBy,dtModified) values (" . 
						$destination_new_stock . ", " . $to_location_id . ",'" . $item_code . "','" . $modified_by . "','" . $modified_date . "');");                
            }
            
        }
        
        if($response_source && $response_destination && $response_source){
            $response = TRUE;    
        }
        else{
            $response = FALSE;
        }
                
        return $response;
        //Then Call Invoke approve to update the status
    }
    
}
?>