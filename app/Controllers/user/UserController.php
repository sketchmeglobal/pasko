<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\Common_M;
use App\Libraries\GroceryCrud;

class UserController extends BaseController
{
    
    public function __construct(){
        
        helper(['url', 'form']);
        $this->common = new Common_M();
        
    }
    
    public function user_profile()
    {     
        $session = session(); 
        // echo $session->get('id'); die; 
        $crud = new GroceryCrud();
        // $crud->displayAs('particular_title', 'Fees Name');
        $crud->columns(['GSTIN','legal_name','phone']);
        $crud->unsetFields(['created_at','created_by','updated_at','updated_by','row_status','company_type']);
        
        $crud->unsetAdd();
        $crud->unsetDelete();
        $crud->unsetPrint();
        $crud->unsetExport();
        
        $crud->setTextEditor(['address','bank_details']);
        
        $crud->setTable('admin_details');
        $crud->fieldType('created_by', 'hidden');
        $crud->fieldType('updated_by', 'hidden');
        $crud->callbackBeforeInsert(
            function ($iData) use($session) {
                $iData->data['created_by'] = $session->get('id');
                return $iData;
            }
        );
        $crud->callbackBeforeUpdate(
            function ($uData) use($session) {
                $uData->data['updated_by'] = $session->get('id');
                return $uData;
            }
        );
        $crud->setSubject('Admin Details');
        $output = $crud->render();

        
        $output->page_title = "Profile || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }
}
