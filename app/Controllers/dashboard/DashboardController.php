<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Common_M;

class DashboardController extends BaseController
{
    
    public function __construct(){
        
        helper(['url', 'form']);
        $this->common = new Common_M();
        
    }
    
    public function index(){
        
        $session = session();
        
        $data['page_title'] = "Dashboard || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));
        if($session->get('userrole') != 1){
            // check direct page access
            // $menu_slug = 'dashboard';
            // $data['check_direct_access'] = $this->common->fetch_navbar($menu_slug, $session->get('id'));    
        }
        return view('dashboard/dashboard', $data);
        
    }
}
