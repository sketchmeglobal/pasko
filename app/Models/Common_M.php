<?php

namespace App\Models;

use CodeIgniter\Model;

class Common_M extends Model
{
    public function checkTableExists($table){
        try {
            return $this->db->tableExists($table);
        } catch (DatabaseException $th) {
            throw $th;
        }
    }
    
    public function fetch_navbar($user_role, $uid){
        if($user_role == 1){ // admin

            $rs = $this->db
                ->table('master_menu')
                ->select('menu_module, menu_name, menu_slug, show_on_left_nav, 1 as action_button_1, 1 as action_button_2')
                ->where(['master_menu.row_status' => 1])
                ->get()->getResult();    
                
        }else{

            $rs = $this
                ->select('menu_module, menu_name, menu_slug, show_on_left_nav, action_button_1, action_button_2, menu_permission.user_id')
                ->join('master_menu','master_menu.id = menu_permission.master_menu_id','left')
                ->where(['user_id' => $uid, 'block' => 0, 'master_menu.row_status' => 1, 'menu_permission.row_status' => 1])
                ->get()->getResult();
                
        }

        // echo $this->getLastQuery()->getQuery(); die;
        return $rs;

    }
    
    public function data_count($table, $condition){
        try {
            if(!empty($table)){
                if(!empty($condition)){
                    return $this->db->table($table)->where($condition)->get()->getNumRows();
                }
                return $this->db->table($table)->get()->getNumRows();
            }
            return 0;
        } catch (DatabaseException $th) {
            throw $th;
        }
    }
    public function data_current_row($table, $condition) {
        try {
            if(!empty($table)){
                if(!empty($condition)){
                    return $this->db->table($table)->where($condition)->get()->getRow();
                }
                return $this->db->table($table)->get()->getRow();
            }
            return [];
        } catch (DatabaseException $th) {
            throw $th;
        }
    }
    public function data_first_row($table, $condition) {
        try {
            if(!empty($table)){
                if(!empty($condition)){
                    return $this->db->table($table)->where($condition)->get()->getFirstRow();
                }
                return $this->db->table($table)->get()->getFirstRow();
            }
            return [];
        } catch (DatabaseException $th) {
            throw $th;
        }
    }

    public function data_last_row($table, $condition) {
        try {
            if(!empty($table)){
                if(!empty($condition)){
                    return $this->db->table($table)->where($condition)->get()->getLastRow();
                }
                return $this->db->table($table)->get()->getLastRow();
            }
            return [];
        } catch (DatabaseException $th) {
            throw $th;
        }
    }

    public function data_all($table, $condition, $order = NULL) {
        try {
            if(!empty($table)){
                $builder = $this->db->table($table);
                if(!empty($condition)){
                    $builder->where($condition);
                }
                if(!is_null($order)){
                    $builder->orderBy($order);
                }
                return $builder->get()->getResult();
                // echo $this->db->getLastQuery()->getQuery(); die;
            }
            return [];
        } catch (DatabaseException $th) {
            throw $th;
        }
    }

    public function data_insert($table, $array){
        try {
            if(!empty($table)){
                if(!empty($array)){

                    if($this->db->table($table)->insert($array)){
                        return $this->db->insertID();
                    }
                    return 0;
                }
            }
            return false;
        } catch (DatabaseException $th) {
            throw $th;
        }
    }


    public function data_update($table, $update_cond, $array){

        try {
            if(!empty($table)){
                if(!empty($array) && !empty($update_cond)){
                    return $this->db->table($table)->where($update_cond)->set($array)->update();
                }
            }else{
                return false;
            }
        } catch (DatabaseException $th) {
            // echo $this->getLastQuery()->getQuery(); die;
            throw $th;
        }
    }

    public function data_remove($table_id, $delete_condition){
        $this->db->table($table_id)->where($delete_condition)->delete();
        return true;
    }

    public function value_increment($table_id, $pk, $pk_value, $field, $increment_by){
        $this->db->table($table_id)->where($pk, $pk_value)->set($field, $field . '+' . $increment_by,FALSE)->update();
    }
    
    public function LogInsert($insertArray){
        return $this->db->table('user_activity_logs')->insert($insertArray);
    }

    // Common ends here

    public function invoice_report_list($postData){
        // print_r($postData); die;
        if(!empty($postData)){
            $builder = $this->db->table('invoice_headers');
            $builder->select('invoice_headers.*');
            $builder->join('invoice_details','invoice_details.invoice_header_id=invoice_headers.id','left');
            if(!empty($postData['to_date']) && !empty($postData['from_date'])){
                $to_date = $postData['to_date'];
                $from_date = $postData['from_date'];
                $builder->where(" invoice_date BETWEEN '$from_date' AND '$to_date' ");
            }
            if(!empty($postData['customer_id'])){
                $builder->where("customer_id",$postData['customer_id']);
            }
            if(!empty($postData['payment_status'])){
                $builder->where("payment_status", $postData['payment_status']);
            }
            if(!empty($postData['particulars_id'])){
                $builder->where("invoice_details.master_particular_id", $postData['particulars_id']);
            }
            if(!empty($postData['master_item_particulars_id'])){
                $builder->where("invoice_details.master_particular_id", $postData['master_item_particulars_id']);
            }
            $builder->groupBy('invoice_details.invoice_header_id');
            /* echo "<pre>";
            print_r($builder->get()->getResult()); die; */
            return $builder->get()->getResult();
            // echo $this->db->getLastQuery(); die;
        }
        return [];
        
    }
    public function customer_list(){
        $sql = "SELECT
                    id,
                    username
                FROM 
                    users
                WHERE 
                    row_status = 1 AND EXISTS (
                        SELECT 
                            id 
                        FROM
                            invoice_headers
                        WHERE
                            customer_id = users.id
                    )";
        return $this->db->query($sql)->getResult();
    }
    public function particulars_list(){
        $sql = "SELECT
                    id,
                    particular_title,
                    particular_hsn
                FROM 
                    master_particulars
                WHERE 
                    row_status = 1
                ";
        return $this->db->query($sql)->getResult();
    }
    public function master_item_list(){
        $sql = "SELECT
                    id,
                    master_particular_id,
                    item_name
                FROM 
                    master_items
                WHERE 
                    row_status = 1
                ";
        return $this->db->query($sql)->getResult();
    }
    public function particular_mapping_data($customer_id){
        $sql = "SELECT
                    particular_mapping.id,
                    particular_mapping.particular_id,
                    master_particulars.particular_title,
                    master_particulars.particular_hsn,
                    particular_mapping.rate
                FROM 
                    particular_mapping
                    LEFT JOIN master_particulars ON master_particulars.id = particular_mapping.particular_id
                WHERE 
                    particular_mapping.row_status = 1 AND particular_mapping.customer_details_id = $customer_id AND particular_mapping.particular_fixed_head = 1
                ";
        return $this->db->query($sql)->getResult();
    }

    public function invoice_details($invoice_id){
        $builder = $this->db->table('invoice_headers');
        // $builder->select('invoice_headers.*');
        $builder->join('invoice_details','invoice_details.invoice_header_id=invoice_headers.id','left');
        $builder->where("invoice_headers.id", $invoice_id);
        return $builder->get()->getResult();
    }

    public function generateUniqueCode(int $lenght=10, string $prefix='', string $postfix='') {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }

        return $prefix . strtoupper(substr(bin2hex($bytes), 0, $lenght)) . $postfix; //eg: 2KL40A930U
    }

    public function getLastItemData(int $project_id, int $item_id) {
        return $this->db->table('invoice_details_t2')
            ->join('invoice_headers_t2', 'invoice_headers_t2.id = invoice_details_t2.invoice_header_id', 'left')
            ->where('invoice_headers_t2.project_id', $project_id)
            ->where('invoice_details_t2.master_item_id', $item_id)
            ->where('invoice_details_t2.row_status', 1)
            ->orderBy('invoice_details_t2.id', 'DESC')
            ->limit(1)
            ->get()->getRow();
    }

    public function updateSubsequentItems($project_id, $item_id, $invoice_dtl_id, $quantity_adjustment, $amount_adjustment) {
        $query = 'UPDATE `invoice_details_t2`
        LEFT JOIN `invoice_headers_t2` ON `invoice_headers_t2`.`id` = `invoice_details_t2`.`invoice_header_id`
        SET prev_qty = prev_qty + '.$quantity_adjustment.', prev_amount = prev_amount + '.$amount_adjustment.'
        WHERE `invoice_headers_t2`.`project_id` = '.$project_id.' AND `invoice_details_t2`.`master_item_id` = '.$item_id.' AND `invoice_details_t2`.`id` > '.$invoice_dtl_id;

        return $this->db->query($query);
    }

}