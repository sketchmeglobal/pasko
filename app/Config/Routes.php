<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->set404Override('App\Controllers\ErrorController::show404');

$routes->group('',['filter' => 'LoggedFilter'],function($routes){
    
    // $routes->match(['get', 'post'], '/', 'Authentication\Registration_C::index');
    $routes->match(['get', 'post'], '/', 'authentication\AuthenticationController::login');
    $routes->match(['get', 'post'], '/login', 'authentication\AuthenticationController::login');
    $routes->post('/login/login_form', 'authentication\AuthenticationController::login_form');
    
});

$routes->group('',['filter' => 'AuthFilter'],function($routes){
    
    // logout
    $routes->get('logout', 'authentication\AuthenticationController::logout');
    // dashboard
    $routes->get('/dashboard', 'dashboard\DashboardController::index');

    $routes->group('master',function($routes){

        $routes->match(['get', 'post'],'particulars/', 'master\MasterController::particulars');
        $routes->match(['get', 'post'],'particulars/(:segment)', 'master\MasterController::particulars/$1');
        $routes->match(['get', 'post'],'particulars/(:segment)/(:segment)', 'master\MasterController::particulars/$1/$2');


        $routes->match(['get', 'post'],'master-item-categories/', 'master\MasterController::master_item_categories');
        $routes->match(['get', 'post'],'master-item-categories/(:segment)', 'master\MasterController::master_item_categories/$1');
        $routes->match(['get', 'post'],'master-item-categories/(:segment)/(:segment)', 'master\MasterController::master_item_categories/$1/$2');

        $routes->match(['get', 'post'],'master-items/', 'master\MasterController::master_items');
        $routes->match(['get', 'post'],'master-items/(:segment)', 'master\MasterController::master_items/$1');
        $routes->match(['get', 'post'],'master-items/(:segment)/(:segment)', 'master\MasterController::master_items/$1/$2');

        $routes->match(['get', 'post'],'particular-details-add/(:num)', 'master\MasterController::particular_details_add/$1');
        $routes->match(['get', 'post'],'customer-details/', 'master\MasterController::customer_details');
        $routes->match(['get', 'post'],'customer-details/(:segment)', 'master\MasterController::customer_details/$1');
        $routes->match(['get', 'post'],'customer-details/(:segment)/(:segment)', 'master\MasterController::customer_details/$1/$2');

        $routes->match(['get', 'post'],'master-projects/', 'master\MasterController::master_projects');
        $routes->match(['get', 'post'],'master-projects/(:segment)', 'master\MasterController::master_projects/$1');
        $routes->match(['get', 'post'],'master-projects/(:segment)/(:segment)', 'master\MasterController::master_projects/$1/$2');
    
        $routes->match(['get', 'post'],'declarations/', 'master\MasterController::declarations');
        $routes->match(['get', 'post'],'declarations/(:segment)', 'master\MasterController::declarations/$1');
        $routes->match(['get', 'post'],'declarations/(:segment)/(:segment)', 'master\MasterController::declarations/$1/$2');
    });

    $routes->group('invoice',function($routes){
        
        $routes->get('invoice-list', 'invoice\InvoiceController::invoice_list');
        $routes->get('invoice-add', 'invoice\InvoiceController::invoice_add');
        $routes->get('invoice-edit/(:num)', 'invoice\InvoiceController::invoice_edit/$1');
        $routes->get('invoice-print/(:num)', 'invoice\InvoiceController::invoice_print/$1');
        $routes->match(['get', 'post'],'invoice-payments/(:num)', 'invoice\InvoiceController::invoice_payments/$1');
        $routes->match(['get', 'post'],'invoice-json-format/(:num)', 'invoice\InvoiceController::invoice_json_format/$1');
        // $routes->get('invoice-payment-form', 'invoice\InvoiceController::invoice_payment_form/$1');

        $routes->get('invoice-list-export', 'invoice\InvoiceController::invoice_list_export');
        $routes->get('invoice-list-export/(:num)', 'invoice\InvoiceController::invoice_list_export/$1');
        $routes->get('invoice-add-export', 'invoice\InvoiceController::invoice_add_export');
        $routes->get('invoice-edit-export/(:num)', 'invoice\InvoiceController::invoice_edit_export/$1');
        $routes->get('invoice-add-item-export/(:num)', 'invoice\InvoiceController::invoice_add_item_export/$1');
        $routes->get('invoice-list-item-export/(:num)', 'invoice\InvoiceController::invoice_list_item_export/$1');
        $routes->get('invoice-edit-item-export/(:num)', 'invoice\InvoiceController::invoice_edit_item_export/$1');
        $routes->get('invoice-print-export/(:num)', 'invoice\InvoiceController::invoice_print_export/$1');
        $routes->get('invoice-json-format-export/(:num)', 'invoice\InvoiceController::invoice_json_format_export/$1');

        $routes->post('ajax-customer-details-on-id', 'invoice\InvoiceController::ajax_customer_details_on_id');
        $routes->post('ajax-invoice-add-form', 'invoice\InvoiceController::ajax_invoice_add_form');
        $routes->post('ajax-invoice-add-form-export', 'invoice\InvoiceController::ajax_invoice_add_form_export');
        $routes->post('ajax-invoice-edit-form', 'invoice\InvoiceController::ajax_invoice_edit_form');
        $routes->post('ajax-invoice-edit-form-export', 'invoice\InvoiceController::ajax_invoice_edit_form_export');
        $routes->post('ajax-invoice-details-edit-form', 'invoice\InvoiceController::ajax_invoice_details_edit_form');
        $routes->post('ajax-invoice-details-edit-form-export', 'invoice\InvoiceController::ajax_invoice_details_edit_form_export');
        $routes->post('ajax-delete-invoice-details-row', 'invoice\InvoiceController::ajax_delete_invoice_details_row');
        $routes->post('ajax-delete-invoice-payment-row', 'invoice\InvoiceController::ajax_delete_invoice_payment_row');
        $routes->post('ajax-status-change-invoice-cancle-row', 'invoice\InvoiceController::ajax_status_change_invoice_cancle_row');
        $routes->post('ajax-status-change-invoice-mark-as-full-paid', 'invoice\InvoiceController::ajax_status_change_invoice_mark_as_full_paid');
        $routes->post('ajax-get-items', 'invoice\InvoiceController::ajax_get_items');
        $routes->post('ajax-get-item-data', 'invoice\InvoiceController::ajax_get_item_data');
        $routes->post('ajax-invoice-add-item-form', 'invoice\InvoiceController::ajax_invoice_add_item_form');
        $routes->post('ajax-delete-invoice-details-row-export', 'invoice\InvoiceController::ajax_delete_invoice_details_row_export');
        $routes->post('ajax-invoice-edit-item-form', 'invoice\InvoiceController::ajax_invoice_edit_item_form');

    });

    $routes->group('user',function($routes){
        $routes->match(['get', 'post'],'user-profile', 'user\UserController::user_profile');
        $routes->match(['get', 'post'],'user-profile/(:segment)', 'user\UserController::user_profile/$1');
        $routes->match(['get', 'post'],'user-profile/(:segment)/(:segment)', 'user\UserController::user_profile/$1/$2');

        $routes->match(['get', 'post'],'user-list', 'user\UserController::user_list');
    });

    $routes->group('report',function($routes){
        $routes->match(['get', 'post'],'invoice-report-list', 'report\ReportController::invoice_report_list');
        
    });
    
});

