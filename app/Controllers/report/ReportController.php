<?php 

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Models\Common_M;


class ReportController extends BaseController
{
    public function __construct(){

        helper(['url', 'form']);
        $this->common = new Common_M();
        // $this->invoice = new Invoice_M();
        
    }

    public function invoice_report_list(){   
        $data = []; 
        $session = session();     
        $data['customer_list'] = $this->common->customer_list();
        $data['particulars_list'] = $this->common->particulars_list();
        $data['master_item_list'] = $this->common->master_item_list();
        // print_r( $data['master_item_list'] ); die;
        $data['invoice_report_list'] = $this->common->invoice_report_list($this->request->getVar());
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));       

        return view('report/invoice_report_list',$data);
    }  
    
}


