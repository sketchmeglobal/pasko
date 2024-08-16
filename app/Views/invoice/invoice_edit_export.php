<?php echo view ('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
#invoice_details_area label {
    font-size: 13px
}
</style>
</head>

<?php $session = session(); ?>


<body>

    <div class="container-scroller">

        <!--Top navbar-->
        <?= view('common/top_navbar') ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <!--sidenavbar starts-->
            <?= view('common/side_navbar') ?>
            <!--sidenavbar ends-->

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <form id="invoice_edit_form" action="<?=base_url('invoice/ajax-invoice-edit-form-export')?>"
                            method="post" class="card-body">
                            <h4 class="card-title">Edit Invoice
                                <hr>
                            </h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="customer_id">Customer</label>
                                        <select required name="customer_id" class="form-select select2"
                                            id="customer_id">
                                            <option value="" disabled selected>Select from the list</option>
                                            <?php foreach($customers as $customer){ ?>
                                            <option
                                                <?= ($customer->id == $invoice_headers[0]->customer_id) ? ' selected' : '' ?>
                                                value="<?=$customer->id?>"><?=$customer->account_name?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" id="customer_name" name="customer_name"
                                            class="form-control" value="<?=$invoice_headers[0]->customer_name?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="sub_customer_name">Sub Customer
                                            Name</label>
                                        <input type="text" id="sub_customer_name" name="sub_customer_name"
                                            class="form-control" value="<?=$invoice_headers[0]->sub_customer_name?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="invoice_number">Invoice Number
                                            <i>(<?=INVOICE_PREFIX?>)</i></label>
                                        <input required type="text" id="invoice_number" name="invoice_number"
                                            class="form-control" value="<?=$invoice_headers[0]->invoice_number?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="invoice_date">Invoice Date</label>
                                        <input required type="date" id="invoice_date" name="invoice_date"
                                            class="form-control" value="<?=$invoice_headers[0]->invoice_date?>">
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="po_number">PO Number</label>
                                        <input type="text" id="po_number" name="po_number" class="form-control"
                                            value="<?=$invoice_headers[0]->po_number?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="po_date">PO Date</label>
                                        <input type="date" id="po_date" name="po_date" class="form-control"
                                            value="<?=$invoice_headers[0]->po_date?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Reference
                                            Number</label>
                                        <input type="text" id="reference_number" name="reference_number"
                                            class="form-control" value="<?=$invoice_headers[0]->reference_number?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="net_amount">Net Amount</label>
                                        <input readonly type="text" id="net_amount" name="net_amount"
                                            class="form-control" value="<?=$invoice_headers[0]->net_amount?>">
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="mode_of_transport">Mode of
                                            Transport</label>
                                        <select name="mode_of_transport" id="mode_of_transport" class="form-select select2">
                                            <option <?= ($invoice_headers[0]->mode_of_transport == 1) ? ' selected ' : '' ?> value="1">Road</option>
                                            <option <?= ($invoice_headers[0]->mode_of_transport == 2) ? ' selected ' : '' ?> value="2">Rail</option>
                                            <option <?= ($invoice_headers[0]->mode_of_transport == 3) ? ' selected ' : '' ?> value="3">Air</option>
                                            <option <?= ($invoice_headers[0]->mode_of_transport == 4) ? ' selected ' : '' ?> value="4">Ship / Ship-cum-Road</option>
                                        </select>
                                    </div>
                                </div> -->
                            </div>

                            <div class="row">
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="vehicle_number">Vehicle
                                            Number</label>
                                        <input type="text" id="vehicle_number" name="vehicle_number"
                                            class="form-control" value="<?=$invoice_headers[0]->vehicle_number?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="loading_date">Loading Date</label>
                                        <input type="date" id="loading_date" name="loading_date" class="form-control"
                                            value="<?=$invoice_headers[0]->loading_date?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="unloading_date">Unloading
                                            Date</label>
                                        <input type="date" id="unloading_date" name="unloading_date"
                                            class="form-control" value="<?=$invoice_headers[0]->unloading_date?>">
                                    </div>
                                </div> -->
                                
                            </div>
                            <hr class="mb-3">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Carrier</label>
                                        <input type="text" id="carrier" name="carrier" class="form-control" value="<?=$invoice_headers[0]->carrier?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Port Of Loading
                                            </label>
                                            <input type="text" id="port_of_loading" name="port_of_loading"
                                            class="form-control" value="<?=$invoice_headers[0]->port_of_loading?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Country Of Origin Of Goods
                                            </label>
                                            <input type="text" id="country_of_origin" name="country_of_origin"
                                            class="form-control" value="<?=$invoice_headers[0]->country_of_origin?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Country Of Shipment
                                            </label>
                                            <input type="text" id="country_of_shipment" name="country_of_shipment"
                                            class="form-control" value="<?=$invoice_headers[0]->country_of_shipment?>">
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Port Of Discharge
                                            </label>
                                            <input type="text" id="port_of_discharge" name="port_of_discharge"
                                            class="form-control" value="<?=$invoice_headers[0]->port_of_discharge?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_type">Final Destination</label>
                                        <input type="text" id="final_destination" name="final_destination"
                                        class="form-control" value="<?=$invoice_headers[0]->final_destination?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Decleartions
                                            </label>
                                      <select class="form-control" name="declarations" required>
                                                <option value="">Select</option>
                                               <?php
                                               if(!empty($declarations)){
                                                foreach($declarations as $row){
                                                    ?>
                                                    <option <?php if($invoice_headers[0]->declarations == $row->id){echo "selected";}?> value="<?php echo $row->id?>"><?php echo $row->comment?></option>
                                                    <?php
                                                }
                                               }
                                               ?>
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="cgst">Terms of Delivery & Payment</label>
                                        <input type="text" id="terms_of_delivery" name="terms_of_delivery" class="form-control"  value="<?php echo $invoice_headers[0]->terms_of_delivery;?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="sgst">No. of Amendment</label>
                                        <input type="text" id="number_of_ammenment" name="number_of_ammenment" class="form-control"  value="<?php echo $invoice_headers[0]->number_of_ammenment;?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="igst">Net Weight</label>
                                        <input type="text" id="net_weight" name="net_weight" class="form-control"  value="<?php echo $invoice_headers[0]->net_weight;?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="grand_amount">Gross Weight</label>
                                        <input  type="text"  name="gross_weight" id="gross_weight"  value="<?php echo $invoice_headers[0]->gross_weight;?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div> 
                            <hr class="mb-3">
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_type">Incoterm</label>
                                        <input type="text" id="incoterm" name="incoterm"
                                        class="form-control" value="<?php echo $invoice_headers[0]->incoterm;?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_type">Currency</label>
                                        <input type="text" id="currency" name="currency"
                                        class="form-control" value="<?php echo $invoice_headers[0]->currency;?>">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="govt_irn_no">Govt. IRN No.</label>
                                        <input type="text" id="govt_irn_no" name="govt_irn_no" class="form-control" value="<?= $invoice_headers[0]->govt_irn_no ?>">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="govt_acknowledgement_no">Govt. Acknowledgement No.</label>
                                        <input type="text" id="govt_acknowledgement_no" name="govt_acknowledgement_no" class="form-control" value="<?= $invoice_headers[0]->govt_acknowledgement_no ?>">
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-3">
                            
                            <input type="hidden" name="id" value="<?=$invoice_headers[0]->id?>" />
                            <button type="submit" name="invoice_edit"
                                class="btn btn-success btn-sm d-block mx-auto invoice_header_edit_submit">
                                <i class="mdi mdi-table-row-plus-before"></i>&nbsp;&nbsp;Update
                            </button>
                        </form>
                    </div>

                    <!-- Detail area -->
                    <div id="invoice_details_area" class="card mt-3">
                        <!-- new row add starts-->
                        <div class="particular_row d-none">
                            <div class="particular_sub_row">
                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- <label class="w-100 font-weight-bold" for="master_particular_id">Particulars</label> -->
                                        <select required name="master_particular_id[]" id=""
                                            class="master_particular_id form-select" placeholder="Particulars">
                                            <option value="" selected disabled>Select from the list</option>
                                            <?php foreach($master_particulars as $mp){ ?>
                                            <option data-hsn="<?=$mp->particular_hsn?>" value="<?=$mp->id?>">
                                                <?=$mp->particular_title?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label class="w-100 font-weight-bold" for="master_particular_id">Particular Name</label> -->
                                        <input required type="text" name="master_particular_name[]"
                                            class="master_particular_name form-control" placeholder="Particular Name">
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label class="w-100 font-weight-bold" for="hsn_code">HSN Code</label> -->
                                        <input required type="text" name="hsn_code[]" class="hsn_code form-control"
                                            placeholder="HSN Code">
                                    </div>
                                    <div class="col-md-3">
                                           
                                           <input  required type="text" name="marks_numbers[]"
                                               class="marks_numbers form-control" placeholder="Marks & Numbers"
                                               >
                                       </div>
                                    <!-- <div class="col-md-3">
                                        <label class="w-100 font-weight-bold" for="number_of_packs">Packs</label>
                                        <input required type="number" name="number_of_packs[]"
                                            class="number_of_packs form-control" placeholder="Packs">
                                    </div> -->
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <!-- <label class="w-100 font-weight-bold" for="quantity">Quantity</label> -->
                                        <input required type="number" name="quantity[]" class="quantity form-control"
                                            placeholder="Quantity">
                                    </div>
                                    <div class="col-md-3 ">
                                           
                                           <input  required type="text" name="unit[]"
                                               class="unit form-control" placeholder="Unit"
                                               >
                                       </div>
                                    <div class="col-md-3">
                                        <!-- <label class="w-100 font-weight-bold" for="unit_rate">Rate / Unit</label> -->
                                        <input required type="number" name="unit_rate[]" class="unit_rate form-control"
                                            placeholder="Rate / Unit">
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label class="w-100 font-weight-bold" for="assessable_value">Assessable value</label> -->
                                        <input required type="number" readonly name="assessable_value[]"
                                            class="assessable_value form-control" placeholder="Assessable value">
                                    </div>
                                    <div class="col-md-3 mt-3">
                                           
                                           <input  required type="text" name="kind_packages[]"
                                               class="kind_packages form-control" placeholder="NUMBER & KIND OF PKGS"
                                               value="">
                                       </div>
                                   
                                        
                                    <div class="col-md-3 mt-3">
                                        <!-- <label class="w-100 font-weight-bold" for="delete_row">Action</label> -->
                                        <span data-id="0" style="cursor:pointer"
                                            class="badge badge-danger delete_row">Delete</span>
                                    </div>
                                    <hr class="mt-3">
                                </div>
                            </div>
                        </div>
                        <!-- new row add ends-->
                        <form id="invoice_details_edit_form"
                            action="<?=base_url('invoice/ajax-invoice-details-edit-form-export')?>" method="post"
                            class="card-body">
                            <h4 class="card-title">
                                <span>Invoice Particulars </span>
                                <span style="cursor:pointer" class="badge badge-info add_row float-end"><small><i
                                            class="mdi mdi-plus"></i> Add</small></span>
                                <hr>
                            </h4>
                            <div class="added_row">
                                <?php if(empty($invoice_details)){ ?>
                                <!-- existing row starts -->
                                <?php foreach($particular_mapping as $id){ ?>
                                <div class="particular_sub_row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold"
                                                for="master_particular_id">Particulars</label>
                                            <select readonly required name="master_particular_id[]" id=""
                                                class="master_particular_id form-select select2"
                                                placeholder="Particulars">
                                                <option value="" selected disabled>Select from the list</option>
                                                <?php foreach($master_particulars as $mp){ ?>
                                                <option <?= ($id->particular_id == $mp->id ? ' selected' : '') ?>
                                                    data-hsn="<?=$mp->particular_hsn?>" value="<?=$mp->id?>">
                                                    <?=$mp->particular_title?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="master_particular_id">Particular
                                                Name</label>
                                            <input readonly required type="text" name="master_particular_name[]"
                                                class="master_particular_name form-control"
                                                placeholder="Particular Name" value="<?=$id->particular_title?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="hsn_code">HSN Code</label>
                                            <input readonly required type="text" name="hsn_code[]"
                                                class="hsn_code form-control" placeholder="HSN Code"
                                                value="<?=$id->particular_hsn?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="quantity">Quantity</label>
                                            <input required type="number" name="quantity[]"
                                                class="quantity form-control" placeholder="Quantity"
                                               >
                                        </div>
                                      
                                        <!-- <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="number_of_packs">Packs</label>
                                            <input required type="number" name="number_of_packs[]"
                                                class="number_of_packs form-control" placeholder="Packs"
                                                >
                                        </div> -->
                                    </div>
                                    <div class="row mt-3">
                                        
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="unit_rate">Rate / Unit</label>
                                            <input readonly required type="number" name="unit_rate[]"
                                                class="unit_rate form-control" placeholder="Rate / Unit"
                                                value="<?=$id->rate?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="assessable_value">Assessable
                                                value</label>
                                            <input  required type="number" name="assessable_value[]"
                                                class="assessable_value form-control" placeholder="Assessable value"
                                                >
                                        </div>
                                                </div>
                                    <div class="row mt-3">
                                        
                                        <hr class="mt-3">
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- existing row ends -->
                                <?php }else{ ?>
                                <!-- existing row starts -->
                                <?php foreach($invoice_details as $id){ ?>
                                <div class="particular_sub_row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold"
                                                for="master_particular_id">Particulars</label>
                                            <select readonly required name="master_particular_id[]" id=""
                                                class="master_particular_id form-select select2"
                                                placeholder="Particulars">
                                                <option value="" selected disabled>Select from the list</option>
                                                <?php foreach($master_particulars as $mp){ ?>
                                                <option <?= ($id->master_particular_id == $mp->id ? ' selected' : '') ?>
                                                    data-hsn="<?=$mp->particular_hsn?>" value="<?=$mp->id?>">
                                                    <?=$mp->particular_title?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="master_particular_id">Particular
                                                Name</label>
                                            <input readonly required type="text" name="master_particular_name[]"
                                                class="master_particular_name form-control"
                                                placeholder="Particular Name" value="<?=$id->master_particular_name?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="hsn_code">HSN Code</label>
                                            <input readonly required type="text" name="hsn_code[]"
                                                class="hsn_code form-control" placeholder="HSN Code"
                                                value="<?=$id->hsn_code?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="unit_rate">MARKS & NUMBERS</label>
                                            <input  required type="text" name="marks_numbers[]"
                                                class="marks_numbers form-control" placeholder="Marks & Numbers"
                                                value="<?=$id->marks_numbers?>">
                                        </div>
                                      
                                        <!-- <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="number_of_packs">Packs</label>
                                            <input readonly required type="number" name="number_of_packs[]"
                                                class="number_of_packs form-control" placeholder="Packs"
                                                value="<?=$id->number_of_packs?>">
                                        </div> -->
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="quantity">Quantity</label>
                                            <input readonly required type="number" name="quantity[]"
                                                class="quantity form-control" placeholder="Quantity"
                                                value="<?=$id->quantity?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="quantity">Unit</label>
                                            <input  required type="text" name="unit[]"
                                                class="quantity form-control" placeholder="Unit"
                                                value="<?=$id->unit?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="unit_rate">Rate / Unit</label>
                                            <input readonly required type="number" name="unit_rate[]"
                                                class="unit_rate form-control" placeholder="Rate / Unit"
                                                value="<?=$id->unit_rate?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="assessable_value">Assessable
                                                value</label>
                                            <input readonly required type="number" readonly name="assessable_value[]"
                                                class="assessable_value form-control" placeholder="Assessable value"
                                                value="<?=$id->assessable_value?>">
                                        </div>
                                        </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="quantity">NUMBER & KIND OF PKGS</label>
                                            <input  required type="text" name="kind_packages[]"
                                                class="quantity form-control" placeholder="NUMBER & KIND OF PKGS"
                                                value="<?=$id->kind_packages?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="w-100 font-weight-bold" for="delete_row">Action</label>
                                            <span data-id="0" style="cursor:pointer"
                                                class="badge badge-danger delete_row">Delete</span>
                                        </div>
                                        <hr class="mt-3">
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- existing row ends -->
                                <?php } ?>
                            </div>
                            <!-- <hr class="mb-3"> -->
                            
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <input type="hidden" name="invoice_header_id" value="<?=$invoice_headers[0]->id?>" />
                                    <button type="submit" name="invoice_details_edit"
                                        class="btn btn-success btn-sm d-block mx-auto">
                                        <i class="mdi mdi-table-row-plus-before"></i>&nbsp;&nbsp;Update
                                    </button>  
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="<?= base_url('/invoice/invoice-print-export/' . $invoice_headers[0]->id) ?>" target="_blank" class="btn btn-sm badge badge-gradient-info"> 
                                        <i class="fa-solid fa-print"></i>&nbsp;Print
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- content-wrapper ends -->
                    <!-- partial:../../partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                                <?=date('Y') . ' ' . COMPANY_FULL_NAME?> . All rights reserved.</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">With gratitude from
                                <i class="mdi mdi-heart text-danger"></i><a href="<?=CREDIT_LINK?>"
                                    target="_blank"><?=CREDIT_TITLE?></a></span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <?php echo view ('common/footer_backdesk.php') ?>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Customer id -->
        <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $("#customer_id").change(function() {

            customer_id = $(this).find("option:selected").val()
            selected_text = $(this).find("option:selected").text()
            $("#customer_name").val(selected_text)

            $.ajax({
                type: 'POST',
                url: '<?=base_url('invoice/ajax-customer-details-on-id')?>',
                data: {
                    customer_id: customer_id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    gst_no = data.account_gst_no
                    $("#sub_customer_name").val(data.account_sub_name)
                    if (gst_no != null) {
                        state = gst_no.substring(0, 2)
                        if (state == '19') {
                            $("#cgst").val('9')
                            $("#sgst").val('9')
                            $("#igst").val('0')
                            $("#igst").attr('readonly', true)
                        } else {
                            $("#cgst").val('0')
                            $("#sgst").val('0')
                            $("#cgst").attr('readonly', true)
                            $("#sgst").attr('readonly', true)
                            $("#igst").val('18')
                        }
                    }
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });

        })
        </script>
        <!-- validate -->
        <script>
        $("#invoice_edit_form").validate();
        $("#invoice_details_edit_form").validate();
        </script>
        <!--ajaxform-->
        <script>
        $('#invoice_edit_form').ajaxForm({
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.status == 0) {
                    toast('danger', data.msg);
                } else { // success
                    toast('success', data.msg);
                }
            }
        });

        $('#invoice_details_edit_form').ajaxForm({
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.status == 0) {
                    toast('danger', data.msg);
                } else { // success
                    toast('success', data.msg);
                }
                // submit header
                $(".invoice_header_edit_submit").trigger('click')
            }
        });
        </script>

        <!-- repeater area -->
        <script>
        $(".add_row").on('click', function() {
            particular_row = $(".particular_row").html()
            $(".added_row").append(particular_row)
            $(".added_row .master_particular_id").select2()
        })

        $(document).on('click', '.delete_row', function() {
            if (confirm("Are you sure?")) {
                $this = $(this)
                invoice_detail_id = $(this).data('id')
                if (invoice_detail_id == 0) { // newly added, still not in database
                    $(this).closest('.particular_sub_row').remove()
                } else {
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "<?=base_url('invoice/ajax-delete-invoice-details-row-export')?>",
                        data: {
                            invoice_details_id: invoice_detail_id
                        },
                        success: function(data) {
                            if (data.status == 0) { // error
                                toast('danger', data.msg);
                            } else { // success
                                $this.closest('.particular_sub_row').remove()
                                toast('success', data.msg);
                                header_calculation()
                                $("#invoice_details_edit_form").submit()
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    })
                }
            }
        })
        </script>

        <!-- calculation area -->
        <script>
        $(document).on('change', '.master_particular_id', function() {
            master_particular_name = $(this).find("option:selected").text()
            $(this).closest('div').next('div').find('.master_particular_name').val(master_particular_name.trim())
            hsn_code = $(this).find("option:selected").data('hsn')
            $(this).closest('div').next('div').next('div').find('.hsn_code').val(hsn_code)
        })

        // calculation part
        $(document).on('change', '.quantity', function() {
            quantity = $(this).closest('.row').find('.quantity').val()
            unit_rate = $(this).closest('.row').find('.unit_rate').val()
            assessable_value = parseFloat(quantity) * parseFloat(unit_rate)
            $(this).closest('.row').find('.assessable_value').val(assessable_value.toFixed(2))

            header_calculation();
        })

        $(document).on('change', '.unit_rate', function() {
            quantity = $(this).closest('.row').find('.quantity').val()
            unit_rate = $(this).closest('.row').find('.unit_rate').val()
            assessable_value = parseFloat(quantity) * parseFloat(unit_rate)
            $(this).closest('.row').find('.assessable_value').val(assessable_value.toFixed(2))

            header_calculation();
        })

        $("#discount_type,#discount_value,#other_charges_type,#other_charges_value,#cgst,#sgst,#igst").change(function() {
            header_calculation()
        })
        // $(document).on('click', '.delete_row',function(){

        // })

        function header_calculation() {
            net_amount = 0.00;
            $('.assessable_value').each(function(i, obj) {
                if ($(this).val() == '') {
                    this_val = 0
                } else {
                    this_val = parseFloat($(this).val())
                }
                net_amount = parseFloat(net_amount) + parseFloat(this_val)
                // console.log($this_val)
            });

            $("#net_amount").val(parseFloat(net_amount).toFixed(2))

            // discount
            discount_type = $("#discount_type").val()
            discount_value = $("#discount_value").val()
            if(discount_value == 0){
                discount_amount = parseFloat(discount_value);
            } else{
                if (discount_type == "Flat") {
                    discount_amount = parseFloat(discount_value);
                } else {
                    discount_amount = parseFloat(net_amount) * (parseFloat(discount_value) / 100);
                }
            }
            $('#discount_amount').val(discount_amount);
            //other charges
            other_charges_type = $("#other_charges_type").val()
            other_charges_value = $("#other_charges_value").val()
            if(other_charges_value == 0){
                other_charges_amount = parseFloat(other_charges_value);
            } else{
                if (other_charges_type == "Flat") {
                    other_charges_amount = parseFloat(other_charges_value);
                } else {
                    other_charges_amount = parseFloat(net_amount) * (parseFloat(other_charges_value) / 100);
                }
            }
            $('#other_charges_amount').val(other_charges_amount);
            
            // taxable & tax
            taxable_amount = parseFloat(net_amount) - parseFloat(discount_amount) + parseFloat(other_charges_amount)
          
            $("#taxable_amount").val(taxable_amount.toFixed(2))
            total_tax_percentage = parseFloat($("#cgst").val()) + parseFloat($("#sgst").val()) + parseFloat($("#igst")
                .val())
            if (total_tax_percentage == 0) {
                total_tax_amount = 0
            } else {
                total_tax_amount = parseFloat(taxable_amount) * (parseFloat(total_tax_percentage) / 100)
            }
            $("#total_tax_amount").val(total_tax_amount.toFixed(2))

            // total
            gross_amount = parseFloat(taxable_amount) + parseFloat(total_tax_amount)
            $("#gross_amount").val(gross_amount.toFixed(2))
        }
        </script>

</body>

</html>