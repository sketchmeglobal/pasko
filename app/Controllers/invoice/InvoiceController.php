<?php 

namespace App\Controllers\Invoice;

use App\Controllers\BaseController;
use App\Models\Common_M;


class InvoiceController extends BaseController
{
    public function __construct(){

        helper(['url', 'form']);
        $this->common = new Common_M();
        // $this->invoice = new Invoice_M();
        
    }

    public function invoice_list(){   
        $data = []; 
        $session = session();        
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $cond_arr = array('row_status' => 1);
        $data['invoice_headers'] = $this->common->data_all('invoice_headers', $cond_arr, 'id ASC');

        return view('invoice/invoice_list',$data);
    }

    public function invoice_add(){
        $data = [];
        $session = session();
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $cond_arr = array('account_type' => 'BUYER','row_status' => 1);
        $data['customers'] = $this->common->data_all('customer_details',$cond_arr,'id ASC');
        $data['declarations'] = $this->common->data_all('declarations',['row_status'=>1]);
        return view('invoice/invoice_add',$data);
    }
    
    public function ajax_customer_details_on_id(){

        $cond_arr = array('id' => $this->request->getPost('customer_id'), 'row_status' => 1);
        $data = $this->common->data_current_row('customer_details',$cond_arr);
        
        echo json_encode($data);

    }

    public function ajax_invoice_add_form(){

        $session = session();
        $final_flag = array();
        if($this->request->getPost()){

            $invoice_header_rule = [
                'customer_id' => 'required', 
                'invoice_number' => 'required', // is_unique[invoice_headers.invoice_number]
                'invoice_date' => 'required'
            ];

            if ($this->validate($invoice_header_rule)) {

                // check if same invoice number exists
                $row_cond = array('invoice_number' => $this->request->getPost('invoice_number'));
                $nr = $this->common->data_count('invoice_headers',$row_cond);
                if($nr == 0){
                    $final_flag = $this->insert_invoice_header();
                }else{
                    // duplicate entry    
                    $final_flag = array('status' => false, 'code' => '042', 'msg' => EM042);
                }  
                
            } else{
                // validation error
                $final_flag = array('status' => false, 'code' => '041', 'msg' => EM041);
            }

            echo json_encode($final_flag);  

        }
    }

    public function invoice_edit($invoice_id){
        $data = []; 
        $session = session();        
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));    
        
        $cond_arr = array('account_type' => 'BUYER','row_status' => 1);
        $data['customers'] = $this->common->data_all('customer_details',$cond_arr,'id ASC');
        $cond_arr = array('row_status' => 1,'id'=>$invoice_id);
        $data['invoice_headers'] = $this->common->data_all('invoice_headers',$cond_arr,'id ASC');
        // echo "<pre>"; print_r($data['invoice_headers']); die;
        $cond_arr = array('row_status' => 1);
        $data['master_particulars'] = $this->common->data_all('master_particulars',$cond_arr,'id ASC');
        $cond_arr = array('row_status' => 1,'customer_details_id'=>$data['invoice_headers'][0]->customer_id);
        $data['particular_mapping'] = $this->common->particular_mapping_data($data['invoice_headers'][0]->customer_id);
        // echo "<pre>"; print_r($data['particular_mapping']); die;
        $cond_arr = array('invoice_header_id' => $invoice_id,'row_status' => 1);
        $data['invoice_details'] = $this->common->data_all('invoice_details',$cond_arr,'id ASC');
        $data['declarations'] = $this->common->data_all('declarations',['row_status'=>1]);
        return view('invoice/invoice_edit',$data);
    }

    public function ajax_invoice_edit_form(){

        $final_flag = array();
        if($this->request->getPost()){

            $invoice_details_rule = [
                'customer_id' => 'required', 
                'invoice_number' => 'required',
                'invoice_date' => 'required'
            ];

            if ($this->validate($invoice_details_rule)) {

                // check if same invoice number exists
                $row_cond = array('invoice_number' => $this->request->getPost('invoice_number'));
                $row_arr = $this->common->data_current_row('invoice_headers',$row_cond);
                if(!empty($row_arr)){
                    if($this->request->getPost('id') == $row_arr->id){
                        $final_flag = $this->update_invoice_header();
                    }else{
                        // duplicate entry    
                        $final_flag = array('status' => false, 'code' => '042', 'msg' => EM042);
                    }    
                } else{
                    $final_flag = $this->update_invoice_header();
                }
            } else{
                // validation error
                $final_flag = array('status' => false, 'code' => '041', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
        
    }

    public function ajax_invoice_details_edit_form(){

        $final_flag = array();
        if($this->request->getPost()){

            $invoice_details_rule = [
                'master_particular_id' => 'required', 
                'master_particular_name' => 'required',
                'hsn_code' => 'required',
                // 'number_of_packs' => 'required', 
                'quantity' => 'required',
                'unit_rate' => 'required',
                'assessable_value' => 'required'
            ];

            if ($this->validate($invoice_details_rule)) {
                $final_flag = $this->insert_invoice_details();
            } else{
                // validation error
                $final_flag = array('status' => false, 'code' => '041', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
        
    }

    function insert_invoice_header(){
        
        // print_r($this->request->getPost());die;

        $session = session();
        $insertArray = array(
            'customer_id' => $this->request->getPost('customer_id'),
            'company_type' => $this->request->getPost('company_type'),
            'customer_name' => $this->request->getPost('customer_name'),
            'sub_customer_name' => $this->request->getPost('sub_customer_name'),
            'invoice_number' => $this->request->getPost('invoice_number'),
            'invoice_date' => $this->request->getPost('invoice_date'),
            'po_number' => $this->request->getPost('po_number'),
            'po_date' => $this->request->getPost('po_date'),
            'reference_number' => $this->request->getPost('reference_number'),
            'mode_of_transport' => $this->request->getPost('mode_of_transport'),
            'vehicle_number' => $this->request->getPost('vehicle_number'),
            'loading_date' => '',
            'unloading_date' => '',
            'code_type' => $this->request->getPost('code_type'),
            'code_value' => $this->request->getPost('code_value'),
            'delivery_address' => $this->request->getPost('delivery_address'),
            'declarations'=>$this->request->getPost('declarations'),
            'created_by' => $session->get('id')
        );
        if($insert_id = $this->common->data_insert('invoice_headers',$insertArray)){
            $final_flag = array('status' => true, 'code' => '021', 'msg' => EM021, 'redirect_id' => $insert_id);
        }else{
            $final_flag = array('status' => false, 'code' => '022', 'msg' => EM022, 'redirect_id' => NULL);
        }
        return $final_flag;
    }

    function update_invoice_header(){
        // print_r($this->request->getPost());die('dead');
        
        $session = session();
        $updateArray = array(
            'customer_id' => $this->request->getPost('customer_id'),
            'company_type' => $this->request->getPost('company_type'),
            'customer_name' => $this->request->getPost('customer_name'),
            'sub_customer_name' => $this->request->getPost('sub_customer_name'),
            'invoice_number' => $this->request->getPost('invoice_number'),
            'invoice_date' => $this->request->getPost('invoice_date'),
            'po_number' => $this->request->getPost('po_number'),
            'po_date' => $this->request->getPost('po_date'),
            'reference_number' => $this->request->getPost('reference_number'),
            'mode_of_transport' => $this->request->getPost('mode_of_transport'),
            'vehicle_number' => $this->request->getPost('vehicle_number'),
            'loading_date' => '',
            'unloading_date' => '',
            'level1_heading' => $this->request->getPost('level1_heading'),
            'level1_value' => $this->request->getPost('level1_value'),
            'level2_heading' => $this->request->getPost('level2_heading'),
            'level2_value' => $this->request->getPost('level2_value'),
            'net_amount' => $this->request->getPost('net_amount'),
            'cgst' => $this->request->getPost('cgst'),
            'sgst' => $this->request->getPost('sgst'),
            'igst' => $this->request->getPost('igst'),
            'total_tax_amount' => $this->request->getPost('total_tax_amount'),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'discount_amount' => $this->request->getPost('discount_amount'),
            'other_charges_type' => $this->request->getPost('other_charges_type'),
            'other_charges_value' => $this->request->getPost('other_charges_value'),
            'other_charges_amount' => $this->request->getPost('other_charges_amount'),
            'gross_amount' => $this->request->getPost('gross_amount'),
            'code_type' => $this->request->getPost('code_type'),
            'code_value' => $this->request->getPost('code_value'),
            'delivery_address' => $this->request->getPost('delivery_address'),
            'declarations'=>$this->request->getPost('declarations'),
            'govt_irn_no' => $this->request->getPost('govt_irn_no'),
            'govt_acknowledgement_no' => $this->request->getPost('govt_acknowledgement_no'),
            'rows_per_page' => $this->request->getPost('rows_per_page'),
            'updated_by' => $session->get('id')
        );
        if($this->common->data_update('invoice_headers',array('id' => $this->request->getPost('id')),$updateArray)){
            $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);
        }else{
            $final_flag = array('status' => false, 'code' => '024', 'msg' => EM024);
        }
        return $final_flag;
        
    }

    public function invoice_print($invoice_id) {
        $invoice_header = $this->common->data_current_row('invoice_headers', array('id'=>$invoice_id));
        $data['invoice'] = $invoice_header;
        $invoice_dtl = $this->common->data_all('invoice_details', array('invoice_header_id'=>$invoice_id, 'row_status'=>1));
        $data['invoice_dtl'] = $invoice_dtl;
        $data['admin_details'] = $this->common->data_current_row('admin_details', array('id'=>1));
        $data['customer_details'] = $this->common->data_current_row('customer_details', array('id'=>$invoice_header->customer_id));
        $declarations_id = $invoice_header->declarations;
        $data['declarations'] = $this->common->data_current_row('declarations', array('id'=>$declarations_id));
        
        //$data['project'] = $this->common->data_current_row('master_projects', array('id'=>$invoice_header->project_id));
        return view('invoice/invoice_print',$data);
    }

    function insert_invoice_details(){
        
        $session = session();
        // echo "<pre>"; print_r($this->request->getPost()); die;
        $updateArray = array(
            'net_amount' => $this->request->getPost('net_amount'),
            'cgst' => $this->request->getPost('cgst'),
            'sgst' => $this->request->getPost('sgst'),
            'igst' => $this->request->getPost('igst'),
            'total_tax_amount' => $this->request->getPost('total_tax_amount'),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'discount_amount' => $this->request->getPost('discount_amount'),
            'gross_amount' => $this->request->getPost('gross_amount'),
            'updated_by' => $session->get('id')
        );
        if($this->common->data_update('invoice_headers',array('id' => $this->request->getPost('invoice_header_id')),$updateArray)){
            // update to header table
            $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);
            // insert to details table
            $limit = count($this->request->getPost('master_particular_id'));
            $row_cond=array(
                "invoice_header_id"=>$this->request->getPost('invoice_header_id'),
            );
            $this->common->data_remove('invoice_details',$row_cond);
            for($iteration=0; $iteration<$limit; $iteration++){
                
                $insertArray = array(
                    'invoice_header_id' => $this->request->getPost('invoice_header_id'),
                    'master_particular_id' => $this->request->getPost('master_particular_id')[$iteration],
                    'master_particular_name' => $this->request->getPost('master_particular_name')[$iteration],
                    'hsn_code' => $this->request->getPost('hsn_code')[$iteration],
                    'particular_after_content' => $this->request->getPost('particular_after_content')[$iteration],
                    'number_of_packs' => $this->request->getPost('number_of_packs')[$iteration],
                    'quantity' => $this->request->getPost('quantity')[$iteration],
                    'unit_rate' => $this->request->getPost('unit_rate')[$iteration],
                    'assessable_value' => $this->request->getPost('assessable_value')[$iteration],
                    'created_by' => $session->get('id')
                );
                if($this->common->data_count('invoice_details',$insertArray) == 0){ // duplicte date restriction
                    if(!$this->common->data_insert('invoice_details',$insertArray)){
                        $final_flag = array('status' => false, 'code' => '022', 'msg' => EM022);
                        return $final_flag;
                    }
                }
            }
            
        }else{
            $final_flag = array('status' => false, 'code' => '024', 'msg' => EM024);
        }
        
        return $final_flag;
    }

    public function ajax_delete_invoice_details_row(){
        $final_flag = array();
        if($this->request->getPost()){

            $row_cond = array('id' => $this->request->getPost('invoice_details_id'));
            if ($this->common->data_remove('invoice_details',$row_cond)) {
                $final_flag = array('status' => true, 'code' => '025', 'msg' => EM025);
            } else{
                $final_flag = array('status' => false, 'code' => '026', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
    }

    public function invoice_payments($invoice_id){
        $data = []; 
        $session = session();        
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));    
        
        if($this->request->getPost()){
            $session = session();
            $insertArray = array(
                'invoice_header_id' => $this->request->getPost('invoice_header_id'),
                'reference_number' => $this->request->getPost('reference_number'),
                'payment_date' => $this->request->getPost('payment_date'),
                'payment_value' => $this->request->getPost('payment_value'),
                'comments' => $this->request->getPost('comments'),
                'created_by' => $session->get('id')
            );
            $this->common->data_insert('invoice_payments',$insertArray);
            // update header with partial payment
            $updateArray = array(
                'payment_status' => 3 // partial paid
            );
            $this->common->data_update('invoice_headers',array('id' => $this->request->getPost('invoice_header_id')),$updateArray);
        }

        $cond_arr = array('row_status' => 1, 'invoice_header_id' => $invoice_id);
        $data['invoice_payments'] = $this->common->data_all('invoice_payments',$cond_arr,'id ASC');
        $cond_arr = array('row_status' => 1, 'id' => $invoice_id);
        $data['invoice_headers'] = $this->common->data_all('invoice_headers',$cond_arr,'id ASC');
        
        return view('invoice/invoice_payments',$data);
    }

    public function ajax_delete_invoice_payment_row(){
        $final_flag = array();
        if($this->request->getPost()){

            $row_cond = array('id' => $this->request->getPost('invoice_payment_id'));
            if ($this->common->data_remove('invoice_payments',$row_cond)) {
                $final_flag = array('status' => true, 'code' => '025', 'msg' => EM025);
            } else{
                $final_flag = array('status' => false, 'code' => '026', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
    }

    public function ajax_status_change_invoice_cancle_row(){
        // echo $this->request->getVar('payment_status'); die;
        $final_flag = array();
        if($this->request->getPost()){
            $id = $this->request->getPost('id');
            $row = $this->common->data_current_row('invoice_headers',['id'=>$id]);
            $updateArr = [
                'payment_status'=>4
            ];
            if($row->payment_status == 4){
                $updateArr = [
                    'payment_status'=>1
                ];
            }
            $update_cond = array('id' => $this->request->getPost('id'));
            if ($this->common->data_update('invoice_headers',$update_cond,$updateArr)) {
                $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);
            } else{
                $final_flag = array('status' => false, 'code' => '026', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
    }

    public function ajax_status_change_invoice_mark_as_full_paid(){
        // echo $this->request->getVar('id'); die;
        $final_flag = array();
        if($this->request->getPost()){
            
            $id = $this->request->getPost('id');
            $payment_status  = $this->request->getVar('payment_status');
            $row = $this->common->data_current_row('invoice_headers',['id'=>$id]);
            $updateArr = [
                'payment_status'=>2
            ];

            if($row->payment_status == 2){
                $updateArr = [
                    'payment_status'=>1
                ];
            }
            $update_cond = array('id' => $id);
            if ($this->common->data_update('invoice_headers',$update_cond,$updateArr)) {
                $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);
            } else{
                $final_flag = array('status' => false, 'code' => '026', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
    }

    public function invoice_json_format($invoice_id){
        
            $invc_details = $this->common->invoice_details($invoice_id);
            $admin_details = $this->common->data_current_row('admin_details', array('row_status' => 1));
            $user_details = $this->common->data_current_row('invoice_headers', array('id' => $invoice_id,'row_status' => 1));
            $customer_details = $this->common->data_current_row('customer_details', array('id' => $user_details->customer_id));

            // echo '<pre>',print_r($admin_details),'</pre>';
            // echo '<pre>',print_r($invc_details),'</pre>'; die;
    
            // if($invc_details[0]->pre_carriage_by == 1) {
            //     $transport_mode = 3;
            // } else if ($invc_details[0]->pre_carriage_by == 2) {
            //     $transport_mode = 4;
            // } else {
            //     $transport_mode = 1;
            // }
            
            $iters = 0;
            $itemLists = [];
            $item_wise_after_tax_value = 0;
            $total_igst_value = 0;
            foreach($invc_details as $i_d) {
                $item_wise_after_tax_value = ($i_d->assessable_value) + (($i_d->assessable_value) * (($invc_details[0]->cgst+$invc_details[0]->sgst+$invc_details[0]->igst)/100));
                $igst_amount = $i_d->assessable_value * ($invc_details[0]->igst / 100);
                $total_igst_value += $igst_amount;
                $iters++;
                $itemLists[] = array(
                    "SlNo"=> (string)$iters,
                    "PrdDesc"=> $i_d->master_particular_name,
                    "IsServc"=> "N",
                    "HsnCd"=> $i_d->hsn_code,
                    "Barcde"=> null,
                    "Qty"=> (float)$i_d->quantity,
                    "FreeQty"=> 0,
                    "Unit"=> "PCS",
                    "UnitPrice"=> (float)number_format($i_d->unit_rate, 2, '.', ''),
                    "TotAmt"=> (float)number_format(($i_d->assessable_value), 2, '.', ''),
                    "Discount"=> 0,
                    "PreTaxVal"=> 0,
                    "AssAmt"=> (float)number_format(($i_d->assessable_value), 2, '.', ''),
                    "GstRt"=> (float)number_format(($invc_details[0]->igst), 2, '.', ''),
                    "IgstAmt"=> (float)number_format($igst_amount, 2, '.', ''),
                    "TotItemVal"=> $item_wise_after_tax_value,
                    "OrdLineRef"=> null,
                    "OrgCntry"=> null,
                    "PrdSlNo"=> null,
                    "BchDtls"=> null,
                    "AttribDtls"=> null
                );
                
            }
            
            $response = array([
                "Version"=> "1.1",
                // "Irn" => "", // string, 64 char. - Invoice reference no.
                "TranDtls"=>
                    [
                        "TaxSch"=> "GST",
                        "SupTyp"=> $user_details->company_type, // B2B,SEZWP (sez with payment),SEZWOP,EXPWP(Export with payment),EXPWOP,DEXP (deemed export)
                        "IgstOnIntra"=>"N",
                        "RegRev"=>"N", // Y/N, => if tax liability is payable under reverse charge
                    ],
                "DocDtls"=>
                    [
                        "Typ"=> "INV", // INV/CRN/DBN
                        "No"=> 'PEPL/'.$invc_details[0]->invoice_number,
                        "Dt"=>date('d/m/Y', strtotime($invc_details[0]->invoice_date)),
                    ],
                "SellerDtls"=>
                    [
                        "Gstin"=> $admin_details->GSTIN,
                        "LglNm"=> $admin_details->legal_name,
                        "TrdNm"=> $admin_details->trade_name,
                        "Addr1"=> $admin_details->address,
                        "Loc"=> $admin_details->location,
                        "Pin"=> (int)$admin_details->pin,
                        "Stcd"=> "19",
                        "Ph"=> $admin_details->phone,
                        "Em"=> ($admin_details->email_id == '') ? NULL : $admin_details->email_id
                    ],
                "BuyerDtls"=>
                    [
                        "Gstin"=> $customer_details->GSTIN,
                        "LglNm"=> $customer_details->legal_name,
                        "TrdNm"=> $customer_details->trade_name,
                        "Pos"=> $customer_details->state_id,
                        "Addr1"=> $customer_details->address,
                        "Loc"=> $customer_details->location,
                        "Pin"=> (int)$customer_details->pin,
                        "Stcd"=> $customer_details->state_id,
                        "Ph"=> $customer_details->phone,
                        "Em"=> ($customer_details->email_id == '') ? NULL : $customer_details->email_id
                    ],
                "DispDtls"=>
                    [ 
                        "Nm"=> $admin_details->legal_name,
                        "Addr1"=> $admin_details->address,
                        "Loc"=> $admin_details->location,
                        "Pin"=> (int)$admin_details->pin,
                        "Stcd"=> "19"
                    ],
                "ShipDtls"=> null,
                "ValDtls"=> [
                    "AssVal"=> (float)number_format($invc_details[0]->net_amount, 2, '.', ''),
                    "Discount"=> (float)number_format(($invc_details[0]->discount_amount), 2, '.', ''),
                    // "OthChrg"=> (float)number_format(($additional_charges + $hand_charge), 2, '.', ''),
                    "IgstVal"=> (float)number_format($total_igst_value, 2, '.', ''),
                    "TotInvVal"=> (float)number_format(($invc_details[0]->gross_amount), 2, '.', ''),
                ],
                "ExpDtls"=> null,
                "EwbDtls"=>null,
                "PayDtls"=> null,
                "RefDtls"=> null,
                "AddlDocDtls"=> null,
                "ItemList"=> $itemLists
            ]);
    
            $response1 = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    
            // $data_inserts = array (
            //     "invoice_id" => $invoice_id,
            //     "json_data" => $response1
            // );
            // $this->db->insert('gst_data_upload', $data_inserts);
    
            $file = rand().'.json';
            $dir_to_save = 'assets/uploads/json/' . $file;
            if(file_put_contents($dir_to_save, $response1)){
                ?>
                <a download href="<?= base_url() . $dir_to_save ?>" class="dwn">Download</a>
                <?php
            }else{
                echo 'something went wrong. Ask admin.';
            }
        
    }



    public function invoice_list_export(){   
        $data = []; 
        $session = session();        
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $cond_arr = array('row_status' => 1);
        $data['invoice_headers'] = $this->common->data_all('invoice_export_headers', $cond_arr, 'id ASC');

        return view('invoice/invoice_list_export',$data);
    }

    public function invoice_add_export(){
        $data = [];
        $session = session();
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $cond_arr = array('account_type' => 'BUYER','row_status' => 1);
        $data['customers'] = $this->common->data_all('customer_details',$cond_arr,'id ASC');
        $data['declarations'] = $this->common->data_all('declarations',['row_status'=>1]);
        return view('invoice/invoice_add_export',$data);
    }

    public function ajax_invoice_add_form_export(){
        
        $session = session();
        $final_flag = array();
        if($this->request->getPost()){

            $invoice_header_rule = [
                'customer_id' => 'required', 
                'invoice_number' => 'required', // is_unique[invoice_headers.invoice_number]
                'invoice_date' => 'required'
            ];

            if ($this->validate($invoice_header_rule)) {

                // check if same invoice number exists
                $row_cond = array('invoice_number' => $this->request->getPost('invoice_number'));
                $nr = $this->common->data_count('invoice_export_headers',$row_cond);
                if($nr == 0){
                    $final_flag = $this->insert_invoice_header_export();
                }else{
                    // duplicate entry    
                    $final_flag = array('status' => false, 'code' => '042', 'msg' => EM042);
                }  
                
            } else{
                // validation error
                $final_flag = array('status' => false, 'code' => '041', 'msg' => EM041);
            }

            echo json_encode($final_flag);  

        }
    }

    function insert_invoice_header_export(){
        // print_r($this->request->getPost());die;

        $session = session();
        $insertArray = array(
            'customer_id' => $this->request->getPost('customer_id'),
            'customer_name' => $this->request->getPost('customer_name'),
            'sub_customer_name' => $this->request->getPost('sub_customer_name'),
            'invoice_number' => $this->request->getPost('invoice_number'),
            'invoice_date' => $this->request->getPost('invoice_date'),
            'po_number' => $this->request->getPost('po_number'),
            'po_date' => $this->request->getPost('po_date'),
            'reference_number' => $this->request->getPost('reference_number'),
            'mode_of_transport' => '',
            'vehicle_number' => '',
            'loading_date' => '',
            'unloading_date' => '',
            'carrier' => $this->request->getPost('carrier'),
            'port_of_loading' => $this->request->getPost('port_of_loading'),
            'country_of_origin' => $this->request->getPost('country_of_origin'),
            'country_of_shipment' => $this->request->getPost('country_of_shipment'),
            'port_of_discharge' => $this->request->getPost('port_of_discharge'),
            'final_destination' => $this->request->getPost('final_destination'),
            'declarations'=>$this->request->getPost('declarations'),
            'incoterm' => $this->request->getPost('incoterm'),
            'currency' => $this->request->getPost('currency'),
            'terms_of_delivery' => $this->request->getPost('terms_of_delivery'),
            'number_of_ammenment' => $this->request->getPost('number_of_ammenment'),
            'net_weight' => $this->request->getPost('net_weight'),
            'gross_weight' => $this->request->getPost('gross_weight'),
            // 'discount_value' => $this->request->getPost('discount_value'),
            'created_by' => $session->get('id')
        );
        if($insert_id = $this->common->data_insert('invoice_export_headers',$insertArray)){
            $final_flag = array('status' => true, 'code' => '021', 'msg' => EM021, 'redirect_id' => $insert_id);
        }else{
            $final_flag = array('status' => false, 'code' => '022', 'msg' => EM022, 'redirect_id' => NULL);
        }
        return $final_flag;
    }

    public function invoice_edit_export($invoice_id){
        $data = []; 
        $session = session();        
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));    
        
        $cond_arr = array('account_type' => 'BUYER','row_status' => 1);
        $data['customers'] = $this->common->data_all('customer_details',$cond_arr,'id ASC');
        $cond_arr = array('row_status' => 1,'id'=>$invoice_id);
        $data['invoice_headers'] = $this->common->data_all('invoice_export_headers',$cond_arr,'id ASC');
        // echo "<pre>"; print_r($data['invoice_headers']); die;
        $cond_arr = array('row_status' => 1);
        $data['master_particulars'] = $this->common->data_all('master_particulars',$cond_arr,'id ASC');
        $cond_arr = array('row_status' => 1,'customer_details_id'=>$data['invoice_headers'][0]->customer_id);
        $data['particular_mapping'] = $this->common->particular_mapping_data($data['invoice_headers'][0]->customer_id);
        // echo "<pre>"; print_r($data['particular_mapping']); die;
        $cond_arr = array('invoice_header_id' => $invoice_id,'row_status' => 1);
        $data['invoice_details'] = $this->common->data_all('invoice_export_details',$cond_arr,'id ASC');
        $data['declarations'] = $this->common->data_all('declarations',['row_status'=>1]);
        
        return view('invoice/invoice_edit_export',$data);
    }

    public function ajax_invoice_edit_form_export(){

        $final_flag = array();
        if($this->request->getPost()){

            $invoice_details_rule = [
                'customer_id' => 'required', 
                'invoice_number' => 'required',
                'invoice_date' => 'required'
            ];

            if ($this->validate($invoice_details_rule)) {

                // check if same invoice number exists
                $row_cond = array('invoice_number' => $this->request->getPost('invoice_number'));
                $row_arr = $this->common->data_current_row('invoice_export_headers',$row_cond);
                if(!empty($row_arr)){
                    if($this->request->getPost('id') == $row_arr->id){
                        $final_flag = $this->update_invoice_header_export();
                    }else{
                        // duplicate entry    
                        $final_flag = array('status' => false, 'code' => '042', 'msg' => EM042);
                    }    
                } else{
                    $final_flag = $this->update_invoice_header_export();
                }
            } else{
                // validation error
                $final_flag = array('status' => false, 'code' => '041', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
        
    }

    public function ajax_invoice_details_edit_form_export(){

        $final_flag = array();
        if($this->request->getPost()){

            $invoice_details_rule = [
                'master_particular_id' => 'required', 
                'master_particular_name' => 'required',
                'hsn_code' => 'required',
                // 'number_of_packs' => 'required', 
                'quantity' => 'required',
                'unit_rate' => 'required',
                'assessable_value' => 'required',
                'marks_numbers' => 'required',
                'unit'=>'required',
                'kind_packages'=>'required'
            ];

            if ($this->validate($invoice_details_rule)) {
                $final_flag = $this->insert_invoice_details_export();
            } else{
                // validation error
                $final_flag = array('status' => false, 'code' => '041', 'msg' => EM041);
            }
        }

        return json_encode($final_flag);  
        
    }

    function update_invoice_header_export(){
        // print_r($this->request->getPost());die;
        
        $session = session();
        $updateArray = array(
            'customer_id' => $this->request->getPost('customer_id'),
            'customer_name' => $this->request->getPost('customer_name'),
            'sub_customer_name' => $this->request->getPost('sub_customer_name'),
            'invoice_number' => $this->request->getPost('invoice_number'),
            'invoice_date' => $this->request->getPost('invoice_date'),
            'po_number' => $this->request->getPost('po_number'),
            'po_date' => $this->request->getPost('po_date'),
            'reference_number' => $this->request->getPost('reference_number'),
            'mode_of_transport' => '',
            'vehicle_number' => '',
            'loading_date' => '',
            'unloading_date' => '',
            'net_amount' => $this->request->getPost('net_amount'),
            'cgst' => $this->request->getPost('cgst'),
            'sgst' => $this->request->getPost('sgst'),
            'igst' => $this->request->getPost('igst'),
            'total_tax_amount' => $this->request->getPost('total_tax_amount'),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'discount_amount' => $this->request->getPost('discount_amount'),
            'other_charges_type' => $this->request->getPost('other_charges_type'),
            'other_charges_value' => $this->request->getPost('other_charges_value'),
            'other_charges_amount' => $this->request->getPost('other_charges_amount'),
            'gross_amount' => $this->request->getPost('gross_amount'),
           
            'declarations'=>$this->request->getPost('declarations'),
            'incoterm' => $this->request->getPost('incoterm'),
            'currency' => $this->request->getPost('currency'),
            'terms_of_delivery' => $this->request->getPost('terms_of_delivery'),
            'number_of_ammenment' => $this->request->getPost('number_of_ammenment'),
            'net_weight' => $this->request->getPost('net_weight'),
            'gross_weight' => $this->request->getPost('gross_weight'),
            'updated_by' => $session->get('id')
        );
        if($this->common->data_update('invoice_export_headers',array('id' => $this->request->getPost('id')),$updateArray)){
            $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);
        }else{
            $final_flag = array('status' => false, 'code' => '024', 'msg' => EM024);
        }
        return $final_flag;
        
    }
    function insert_invoice_details_export(){
        
        $session = session();
        // echo "<pre>"; print_r($this->request->getPost()); die;
        $updateArray = array(
            'net_amount' => $this->request->getPost('net_amount'),
            'cgst' => $this->request->getPost('cgst'),
            'sgst' => $this->request->getPost('sgst'),
            'igst' => $this->request->getPost('igst'),
            'total_tax_amount' => $this->request->getPost('total_tax_amount'),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'discount_amount' => $this->request->getPost('discount_amount'),
            'gross_amount' => $this->request->getPost('gross_amount'),
            'updated_by' => $session->get('id')
        );
        if($this->common->data_update('invoice_export_headers',array('id' => $this->request->getPost('invoice_header_id')),$updateArray)){
            // update to header table
            $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);
            // insert to details table
            $limit = count($this->request->getPost('master_particular_id'));
            for($iteration=0; $iteration<$limit; $iteration++){
                $insertArray = array(
                    'invoice_header_id' => $this->request->getPost('invoice_header_id'),
                    'master_particular_id' => $this->request->getPost('master_particular_id')[$iteration],
                    'master_particular_name' => $this->request->getPost('master_particular_name')[$iteration],
                    'hsn_code' => $this->request->getPost('hsn_code')[$iteration],
                    // 'number_of_packs' => $this->request->getPost('number_of_packs')[$iteration],
                    // 'particular_after_content' => '', //$this->request->getPost('particular_after_content')[$iteration],
                    'quantity' => $this->request->getPost('quantity')[$iteration],
                    'unit_rate' => $this->request->getPost('unit_rate')[$iteration],
                    'assessable_value' => $this->request->getPost('assessable_value')[$iteration],
                    'marks_numbers'=>$this->request->getPost('marks_numbers')[$iteration],
                    'unit'=>$this->request->getPost('unit')[$iteration],
                    'kind_packages'=>$this->request->getPost('kind_packages')[$iteration],
                    'created_by' => $session->get('id')
                );
                if($this->common->data_count('invoice_export_details',$insertArray) == 0){ // duplicte date restriction
                    if(!$this->common->data_insert('invoice_export_details',$insertArray)){
                        $final_flag = array('status' => false, 'code' => '022', 'msg' => EM022);
                        return $final_flag;
                    }
                }
            }
            
        }else{
            $final_flag = array('status' => false, 'code' => '024', 'msg' => EM024);
        }
        
        return $final_flag;
    }

    public function invoice_add_item_export($invoice_id) {
        $session = session();
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $data['invoice_id'] = $invoice_id;
        $invoice_header = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_id));
        $data['invoice'] = $invoice_header;
        $data['project'] = $this->common->data_current_row('master_projects', array('id'=>$invoice_header->project_id));
        $data['item_categories'] = $this->common->data_all('master_item_categories',array('row_status' => 1),'id ASC');

        return view('invoice/invoice_add_item_export',$data);
    }

    public function ajax_get_items() {
        $cat_id = $this->request->getPost('cat_id');
        $item_rs = $this->common->data_all('master_items', array('master_item_category_id'=>$cat_id,'row_status' => 1),'item_name ASC');
        $final_flag = array();

        $html = '<option value="" selected disabled>Select item</option>';
        foreach ($item_rs as $item) {
            $html .= '<option value="'.$item->id.'">'.$item->item_name.'</option>';
        }
        $final_flag = array('status' => true, 'html' => $html);

        return json_encode($final_flag);
    }

    public function ajax_get_item_data() {
        $item_id = $this->request->getPost('item_id');
        $project_id = $this->request->getPost('project_id');

        $item_rs = $this->common->data_current_row('master_items', array('id'=>$item_id));
        $last_item_data = $this->common->getLastItemData($project_id, $item_id);
        $prev_qty = 0.000; $prev_amount = 0.00;
        if ($last_item_data) {
            $prev_qty = $last_item_data->prev_qty + $last_item_data->qty;
            $prev_amount = $last_item_data->prev_amount + $last_item_data->amount;
        }

        $final_flag = array(
            'status' => true,
            'unit'=>$item_rs->unit,
            'rate' => $item_rs->rate,
            'item_hsn_code' => $item_rs->item_hsn_code,
            'prev_qty' => $prev_qty,
            'prev_amount' => $prev_amount,
        );

        return json_encode($final_flag);
    }

    public function ajax_invoice_add_item_form() {
        $project_id = $this->request->getPost('project_id');
        $invoice_header_id = $this->request->getPost('invoice_header_id');
        $item_nos = $this->request->getPost('item_nos');
        $item_category_ids = $this->request->getPost('item_category_ids');
        $category_names = $this->request->getPost('category_names');
        $item_ids = $this->request->getPost('item_ids');
        $item_names = $this->request->getPost('item_names');
        $item_hsn_codes = $this->request->getPost('item_hsn_codes');
        $boq = $this->request->getPost('boq');
        $unit = $this->request->getPost('unit');
        $rate = $this->request->getPost('rate');
        $pres_qty = $this->request->getPost('pres_qty');
        $new_grand_amount = 0;
        $invoice_rs = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_header_id));

        foreach ($item_ids as $key => $item_id) {
            $last_item_data = $this->common->getLastItemData($project_id, $item_id);
            $prev_qty = 0.000; $prev_amount = 0.00;
            if ($last_item_data) {
                $prev_qty = $last_item_data->prev_qty + $last_item_data->qty;
                $prev_amount = $last_item_data->prev_amount + $last_item_data->amount;
            }

            //insert into details table
            unset($data);
            $data['master_item_id'] = $item_id;
            $data['item_name'] = $item_names[$key];
            $data['item_hsn_code'] = $item_hsn_codes[$key];
            $data['invoice_header_id'] = $invoice_header_id;
            $data['item_no'] = $item_nos[$key];
            $data['master_item_category_id'] = $item_category_ids[$key];
            $data['category_name'] = $category_names[$key];
            $data['boq'] = $boq[$key];
            $data['unit'] = $unit[$key];
            $data['rate'] = $rate[$key];
            $data['prev_qty'] = $prev_qty;
            $data['qty'] = $pres_qty[$key];
            $data['prev_amount'] = $prev_amount;
            $data['amount'] = $rate[$key] * $pres_qty[$key];
            $data['created_by'] = session('id');
            $this->common->data_insert('invoice_export_details', $data);

            $new_grand_amount += $rate[$key] * $pres_qty[$key];
        }

        //update header table
        $net_amount = $invoice_rs->net_amount + $new_grand_amount;
        if($invoice_rs->discount_type == 'Flat') {
            $discount_amount = $invoice_rs->discount_value;
        }
        elseif ($invoice_rs->discount_type == 'Percentage') {
            $discount_amount = $net_amount * $invoice_rs->discount_value / 100;
        }
        $taxable_amount = $net_amount - $discount_amount;
        $tax_percentage = $invoice_rs->cgst + $invoice_rs->sgst +  $invoice_rs->igst;
        $tax_amount = $taxable_amount * $tax_percentage / 100;

        unset($data);
        $data['net_amount'] = $net_amount;
        $data['discount_amount'] = $discount_amount;
        $data['total_tax_amount'] = $tax_amount;
        $data['gross_amount'] = $taxable_amount + $tax_amount;
        $data['updated_by'] = session('id');
        $this->common->data_update('invoice_export_headers', array('id'=>$invoice_header_id), $data);

        $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);

        return json_encode($final_flag);
    }

    public function invoice_list_item_export($invoice_id){
        $session = session();
        $data['page_title'] = "Invoices (II) || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $invoice_rs = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_id));
        $data['invoice'] = $invoice_rs;
        $data['invoice_details'] = $this->common->data_all('invoice_export_details', array('invoice_header_id'=>$invoice_id,'row_status'=>1), 'id ASC');
        $data['project'] = $this->common->data_current_row('master_projects', array('id' => $invoice_rs->project_id));

        return view('invoice/invoice_list_item_export',$data);
    }

    public function ajax_delete_invoice_details_row_export(){
        if($this->request->getPost()) {
            $invoice_details_id = $this->request->getPost('invoice_details_id');
            $inv_dtl_rs = $this->common->data_current_row('invoice_export_details', array('id'=>$invoice_details_id));
            $invoice_rs = $this->common->data_current_row('invoice_export_headers', array('id'=>$inv_dtl_rs->invoice_header_id));
            $deleted_id = $inv_dtl_rs->id;
            $item_id = $inv_dtl_rs->master_item_id;
            $quantity_adjustment = -$inv_dtl_rs->qty;
            $amount_adjustment = -$inv_dtl_rs->amount;

            //delete item
            $data_update = array(
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'row_status' => 0,
            );
            $delete_status = $this->common->data_update('invoice_export_details', array('id'=>$invoice_details_id), $data_update);

            if ($delete_status) {
                //update next items
                $this->common->updateSubsequentItems($invoice_rs->project_id, $item_id, $deleted_id, $quantity_adjustment, $amount_adjustment);

                //update header table
                $net_amount = $invoice_rs->net_amount + $amount_adjustment;
                if($invoice_rs->discount_type == 'Flat') {
                    $discount_amount = $invoice_rs->discount_value;
                }
                elseif ($invoice_rs->discount_type == 'Percentage') {
                    $discount_amount = $net_amount * $invoice_rs->discount_value / 100;
                }
                $taxable_amount = $net_amount - $discount_amount;
                $tax_percentage = $invoice_rs->cgst + $invoice_rs->sgst +  $invoice_rs->igst;
                $tax_amount = $taxable_amount * $tax_percentage / 100;

                unset($data);
                $data['net_amount'] = $net_amount;
                $data['discount_amount'] = $discount_amount;
                $data['total_tax_amount'] = $tax_amount;
                $data['gross_amount'] = $taxable_amount + $tax_amount;
                $data['updated_by'] = session('id');
                $this->common->data_update('invoice_export_headers', array('id'=>$inv_dtl_rs->invoice_header_id), $data);

                $final_flag = array('status' => true, 'code' => '025', 'msg' => EM025);
            } else{
                $final_flag = array('status' => false, 'code' => '026', 'msg' => EM026);
            }
        }

        return json_encode($final_flag);
    }

    public function invoice_edit_item_export($invoice_dtl_id) {
        $session = session();
        $data['page_title'] = "Invoice || " . COMPANY_SHORT_NAME;
        $data['meta_tag'] = '<meta content='. COMPANY_FULL_NAME . ', Sketch Me Global" name="keywords"><meta content=School Management System,'.COMPANY_FULL_NAME.'", Sketch Me Global" name="description">';
        $data['approved_menu'] = $this->common->fetch_navbar($session->get('userrole'), $session->get('id'));

        $invoice_dtl = $this->common->data_current_row('invoice_export_details', array('id'=>$invoice_dtl_id));
        $data['invoice_dtl'] = $invoice_dtl;
        $invoice_header = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_dtl->invoice_header_id));
        $data['invoice'] = $invoice_header;
        $data['project'] = $this->common->data_current_row('master_projects', array('id'=>$invoice_header->project_id));

        return view('invoice/invoice_edit_item_t2',$data);
    }

    public function ajax_invoice_edit_item_form() {
        $invoice_dtl_id = $this->request->getPost('invoice_dtl_id');
        $item_no = $this->request->getPost('item_no');
        $boq = $this->request->getPost('boq');
        $unit = $this->request->getPost('unit');
        $rate = $this->request->getPost('rate');
        $pres_qty = $this->request->getPost('pres_qty');
        $amount = $rate * $pres_qty;

        $invoice_dtl_rs = $this->common->data_current_row('invoice_export_details', array('id'=>$invoice_dtl_id));
        $invoice_rs = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_dtl_rs->invoice_header_id));

        $quantity_adjustment = $pres_qty - $invoice_dtl_rs->qty;
        $amount_adjustment = $amount - $invoice_dtl_rs->amount;

        //update invoice details table
        unset($data);
        $data['item_no'] = $item_no;
        $data['boq'] = $boq;
        $data['unit'] = $unit;
        $data['rate'] = $rate;
        $data['qty'] = $pres_qty;
        $data['amount'] = $amount;
        $data['updated_by'] = session('id');
        $this->common->data_update('invoice_export_details', array('id'=>$invoice_dtl_id), $data);

        //update next items
        $this->common->updateSubsequentItems($invoice_rs->project_id, $invoice_dtl_rs->master_item_id, $invoice_dtl_id, $quantity_adjustment, $amount_adjustment);

        //update invoice header table
        $net_amount = $invoice_rs->net_amount + $amount_adjustment;
        if($invoice_rs->discount_type == 'Flat') {
            $discount_amount = $invoice_rs->discount_value;
        }
        elseif ($invoice_rs->discount_type == 'Percentage') {
            $discount_amount = $net_amount * $invoice_rs->discount_value / 100;
        }
        $taxable_amount = $net_amount - $discount_amount;
        $tax_percentage = $invoice_rs->cgst + $invoice_rs->sgst +  $invoice_rs->igst;
        $tax_amount = $taxable_amount * $tax_percentage / 100;

        unset($data);
        $data['net_amount'] = $net_amount;
        $data['discount_amount'] = $discount_amount;
        $data['total_tax_amount'] = $tax_amount;
        $data['gross_amount'] = $taxable_amount + $tax_amount;
        $data['updated_by'] = session('id');
        $this->common->data_update('invoice_export_headers', array('id'=>$invoice_dtl_rs->invoice_header_id), $data);

        $final_flag = array('status' => true, 'code' => '023', 'msg' => EM023);

        return json_encode($final_flag);
    }

    public function invoice_print_export($invoice_id) {
        $invoice_header = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_id));
        $data['invoice'] = $invoice_header;
        $invoice_dtl = $this->common->data_all('invoice_export_details', array('invoice_header_id'=>$invoice_id, 'row_status'=>1));
        $data['invoice_dtl'] = $invoice_dtl;
        $data['admin_details'] = $this->common->data_current_row('admin_details', array('id'=>1));
        $data['customer_details'] = $this->common->data_current_row('customer_details', array('id'=>$invoice_header->customer_id));
        $declarations_id = $invoice_header->declarations;
        $data['declarations'] = $this->common->data_current_row('declarations', array('id'=>$declarations_id));
        
        //$data['project'] = $this->common->data_current_row('master_projects', array('id'=>$invoice_header->project_id));
        return view('invoice/invoice_print_export',$data);
    }

    public function invoice_json_format_t2($invoice_id){
        $invoice = $this->common->data_current_row('invoice_export_headers', array('id'=>$invoice_id));
        $invoice_dtl = $this->common->data_all('invoice_export_details', array('invoice_header_id'=>$invoice_id, 'row_status'=>1));
        $admin_details = $this->common->data_current_row('admin_details', array('row_status' => 1));
        $customer_details = $this->common->data_current_row('customer_details', array('id' => $invoice->customer_id));

        #creating itemList array
        $iters = 0;
        $itemLists = [];
        foreach($invoice_dtl as $i_d) {
            $item_wise_after_tax_value = ($i_d->amount) + (($i_d->amount) * (($invoice->cgst + $invoice->sgst)/100));
            $iters++;
            $itemLists[] = array(
                "SlNo"=> (string)$iters,
                "PrdDesc"=> $i_d->item_name,
                "IsServc"=> "N",
                "HsnCd"=> $i_d->item_hsn_code,
                "Qty"=> (float)$i_d->qty,
                "Unit"=> $i_d->unit,
                "UnitPrice"=> (float)number_format($i_d->rate, 2, '.', ''),
                "TotAmt"=> (float)number_format(($i_d->amount), 2, '.', ''),
                "AssAmt"=> (float)number_format(($i_d->amount), 2, '.', ''),
                "GstRt"=> (float)number_format(($invoice->igst), 2, '.', ''),
                "IgstAmt"=> (float)number_format(($i_d->amount * ($invoice->igst / 100)), 2, '.', ''),
                "CgstAmt"=> (float)number_format(($i_d->amount * ($invoice->cgst / 100)), 2, '.', ''),
                "SgstAmt"=> (float)number_format(($i_d->amount * ($invoice->sgst / 100)), 2, '.', ''),
                "TotItemVal"=> $item_wise_after_tax_value,
            );
        }

        #gst invoice JSON schema
        $json_schema = array([
            # Required:  Version, TranDtls, DocDtls, SellerDtls, BuyerDtls, ItemList, ValDtls
            "Version" => "1.1",
            "Irn" => $invoice->invoice_number, // string, 64 char. - Invoice reference no.
            "TranDtls" => [
                "TaxSch" => "GST",
                "SupTyp" => $admin_details->company_type, // B2B,SEZWP (sez with payment),SEZWOP,EXPWP(Export with payment),EXPWOP,DEXP (deemed export)
                "IgstOnIntra" => "N",
                "RegRev" => "N", // Y/N, => if tax liability is payable under reverse charge
            ],
            "DocDtls" => [
                "Typ" => "INV", // INV/CRN/DBN
                "No" => $invoice->invoice_number,
                "Dt" => date('d/m/Y', strtotime($invoice->invoice_date)),
            ],
            "SellerDtls" => [
                "Gstin" => $admin_details->GSTIN,
                "LglNm" => $admin_details->legal_name,
                "TrdNm" => $admin_details->trade_name,
                "Addr1" => $admin_details->address,
                "Loc" => $admin_details->location,
                "Pin" => $admin_details->pin,
                "Stcd" => "19",
                "Ph" => $admin_details->phone,
                "Em" => $admin_details->email_id
            ],
            "BuyerDtls" => [
                "Gstin" => $customer_details->GSTIN,
                "LglNm" => $customer_details->legal_name,
                "TrdNm" => $customer_details->trade_name,
                "Pos" => $invoice->master_state_id,
                "Addr1" => $customer_details->address,
                "Loc" => $customer_details->location,
                "Pin" => $customer_details->pin,
                "Stcd" => $customer_details->state_id,
                "Ph" => $customer_details->phone,
                "Em" => $customer_details->email_id,
            ],
            "DispDtls" => null,
            "ShipDtls" => null,
            "ItemList" => $itemLists,
            "ValDtls" => [
                "AssVal" => (float)number_format($invoice->net_amount, 2, '.', ''),
                "Discount" => (float)number_format(($invoice->discount_amount), 2, '.', ''),
                "TotInvVal" => (float)number_format(($invoice->gross_amount), 2, '.', ''),
            ],
            "PayDtls" => null,
            "RefDtls" => null,
            "AddlDocDtls" => null,
            "ExpDtls" => null,
            "EwbDtls" => null,
        ]);

        $json_data = json_encode($json_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        #download generated file without saving to the server
        $file_name = $invoice->invoice_number.'.json';
        return $this->response->download($file_name, $json_data);
    }
    function numberToWords($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? '  ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
    
        if ($point) {
            $points = " and ";
            $points .= ($point < 20) ? $words[$point] : $words[floor($point / 10) * 10] . " " . $words[$point % 10];
            $points .= " paisa";
        } else {
            $points = '';
        }
    
        return "Rupees " . $result . $points . " Only";
    }

    
    
    
}


