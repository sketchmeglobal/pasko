<?php

namespace App\Models;

use CodeIgniter\Model;

class Authentication_M extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password','login_attempt','blocked'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    // COMMON FUNCTIONS
    public function all_list() {
        return $this->where(['row_status' => 1])->get()->getResult();
    }

    public function open_list() {
        return $this->where(['row_status' => 1, 'blocked' => 0])->get()->getResult();
    }

    public function get_row($table, $row_cond_array) {
        return $this->db->table($table)->where($row_cond_array)->get()->getRow();
    }

    public function num_rows($post_array){
        $this->where($post_array);
        return $this->countAllResults();
    }

    public function resultset_update($id, $update_array){
        return $this->where(["id" => $id])->set($update_array)->update();
    }

    public function value_increment($pk, $id, $field, $increment_by){
        $this->set($field, $field . '+' . $increment_by,FALSE);
        $this->where($pk, $id);
        $this->update();
    }
    public function validateOtp($email,$otp){
        $sql = "select * from master_otp where email='$email' and otp='$otp' order by id desc limit 1";
        $rs = $this->db->query($sql)->getResult();
        return $rs;
    }
    public function LogInsert($insertArray){
        return $this->db->table('user_activity_log')->insert($insertArray);
    }
}