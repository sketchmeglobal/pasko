<?php 

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\Common_M;
use App\Models\Master_M;
use App\Libraries\GroceryCrud;

class MasterController extends BaseController
{
    public function __construct(){

        helper(['url', 'form']);
        $this->common = new Common_M();
        $this->master = new Master_M();
        
    }
    
    public function particulars()
    {     
        $session = session(); 
        // echo $session->get('id'); die; 
        $crud = new GroceryCrud();
        // $crud->displayAs('particular_title', 'Fees Name');
        $crud->columns(['particular_title', 'particular_hsn']);
        $crud->fields(['particular_title', 'particular_hsn','created_by','updated_by']);
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('master_particulars');
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
        $crud->setSubject('Particular');
        $output = $crud->render();

        
        $output->page_title = "Dashboard || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }

    public function customer_details()
    {     
        $session = session(); 
        // echo $session->get('id'); die; 
        $crud = new GroceryCrud();
        // $crud->displayAs('particular_title', 'Fees Name');
        $crud->columns(['account_type', 'account_name','GSTIN','phone']);
        $crud->unsetFields(['created_at','updated_at','row_status']);
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('customer_details');
        $crud->fieldType('created_by', 'hidden');
        $crud->fieldType('updated_by', 'hidden');
        $crud->setTextEditor(['address']);

        $crud->setActionButton('', 'fas fa-money-bill-alt', function ($row) {
            return base_url('master/particular-details-add/' . $row);
        }, true);

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
        $crud->setSubject('User Details');
        $crud->setRelation('state_id', 'master_states', 'state_name');
        $output = $crud->render();

        
        $output->page_title = "Customer || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }

    public function particular_details_add($id)
    {   
        $data = []; 
        $session = session(); 

        if($this->request->getVar('submit') == 'submit'){
            $postArray = $this->request->getVar();

            $result = $this->master->particular_details_add($postArray,$session->get('id'));

            if($result){
                return json_encode(['status' => true, 'code' => '011', 'msg' => EM011]);
            }else{
                return json_encode(['status' => false, 'code' => '011', 'msg' => "!Oops something went wrong. Please try again."]);
            }
        }
        
        $data['page_title'] = "Dashboard || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        $data['particulars'] = $this->master->get_all_particulars($id);
        $data['customer_details'] = $this->common->data_current_row('customer_details',['id'=>$id,'row_status'=>1]);
        $data['customer_details_id'] = $id;
        return view('master/particular_details_add',$data);
    }

    public function particular_invoice()
    {   
        $data = []; 
        $session = session();        
        $data['page_title'] = "Dashboard || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('master/particular_invoice',$data);
    }

    public function master_item_categories()
    {     
        $session = session(); 
        // echo $session->get('id'); die; 
        $crud = new GroceryCrud();
        // $crud->displayAs('particular_title', 'Fees Name');
        $crud->columns(['title']);
        $crud->fields(['title','created_by','updated_by']);
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('master_item_categories');
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
        $crud->setSubject('Item Category');
        $output = $crud->render();

        
        $output->page_title = "Dashboard || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }

    public function master_items()
    {     
        $session = session(); 
        // echo $session->get('id'); die; 
        $crud = new GroceryCrud();
        $crud->displayAs('master_item_category_id', 'Item Category');
        $crud->columns(['master_item_category_id','item_name','item_hsn_code','unit','rate']);
        $crud->fields(['master_item_category_id','item_name','item_hsn_code','unit','rate','created_by','updated_by']);
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('master_items');
        $crud->setRelation('master_item_category_id', 'master_item_categories', 'title');
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
        $crud->setSubject('Item');
        $output = $crud->render();

        
        $output->page_title = "Dashboard || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }

    public function master_projects()
    {
        $session = session();
        $crud = new GroceryCrud();
        $crud->setTable('master_projects');
        $crud->setSubject('Projects');

        $crud->unsetPrint();
        $crud->unsetExport();

        $crud->columns(['project_code','project_name',]);
        $crud->fields(['project_code','project_name','info',]);
        $crud->requiredFields(['project_code','project_name',]);

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
        $crud->callbackAddField('project_code', function($fieldType, $fieldName) {
            $unique_code = $this->common->generateUniqueCode(7, 'PRO');
            return '<input id="field-project_code" class="form-control" name="project_code" type="text" value="'.$unique_code.'" maxlength="255">';
        });
        $crud->setActionButton('Invoices','fa fa-file-pdf-o',function ($row) {
            return base_url().'invoice/invoice-list-t2/' . $row;
        });

        $output = $crud->render();
        $output->page_title = "Projects || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }
    public function declarations()
    {     
        $session = session(); 
        // echo $session->get('id'); die; 
        $crud = new GroceryCrud();
        // $crud->displayAs('particular_title', 'Fees Name');
        $crud->columns(['comment', 'status']);
        $crud->fields(['comment', 'status']);
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->setTable('declarations');
        $crud->setSubject('Declarations');
        
        $crud->setTextEditor(['comment']);
        $crud->requiredFields(['comment']);
        
        $output = $crud->render();

        
        $output->page_title = "Declarations || " . COMPANY_SHORT_NAME;
        $output->meta_tag = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $output->approved_menu = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        return view('common', (array)$output);
    }
}


?>