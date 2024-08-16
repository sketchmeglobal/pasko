<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
class Master_M extends Model
{
    public function particular_details_add($data, $id) {
        try {
            $this->db->transException(true)->transStart();
            foreach($data['particular_group'] AS $key=>&$row){
                $customer_details_id = $row['customer_details_id'];
                $particular_id = $row['particular_id'];
                $particular_fixed_head = $row['particular_fixed_head'];
                $rate = $row['rate'];
                $count = $this->db->table('particular_mapping')->where(['customer_details_id'=>$customer_details_id,'particular_id'=>$particular_id])->get()->getNumRows();
                if($particular_fixed_head == 1){
                    if($count == 0){
                        $row['created_by'] = $id;
                        $this->db->table('particular_mapping')->insert($row);
                    }else{
                        $row['updated_by'] = $id;
                        $this->db->table('particular_mapping')->update($row,[
                            'customer_details_id'=>$customer_details_id,
                            'particular_id'=>$particular_id
                        ]);
                    }
                }else{
                    if($count <> 0){
                        $this->db->table('particular_mapping')->delete([
                            'customer_details_id'=>$customer_details_id,
                            'particular_id'=>$particular_id
                        ]);
                    }
                }
            }
            return $this->db->transComplete();
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function get_all_particulars($id){
        $sql = "SELECT 
                    mp.id,
                    mp.particular_title,
                    mp.particular_hsn,
                    pmt.particular_fixed_head,
                    pmt.rate
                FROM 
                    master_particulars mp
                LEFT JOIN particular_mapping pmt ON pmt.particular_id = mp.id AND pmt.customer_details_id = $id
                WHERE
                    mp.row_status = 1
                ";
        $result = $this->db->query($sql)->getResult();

        // echo "<pre>"; print_r($result); die;
        return $result;
    }
}