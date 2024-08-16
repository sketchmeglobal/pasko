<?php echo view ('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
    integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <form id="invoice_add_form" action="<?=base_url('invoice/ajax-invoice-add-form-export')?>"
                            method="post" class="card-body">
                            <h4 class="card-title">Add Invoice
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
                                            <option value="<?=$customer->id?>"><?=$customer->account_name?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" id="customer_name" name="customer_name"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="sub_customer_name">Sub Customer
                                            Name</label>
                                        <input type="text" id="sub_customer_name" name="sub_customer_name"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="invoice_number">Invoice
                                            Number</label>
                                        <input required type="text" id="invoice_number" name="invoice_number"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="invoice_date">Invoice Date</label>
                                        <input required type="date" id="invoice_date" name="invoice_date"
                                            class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-4">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="po_number">PO Number</label>
                                        <input type="text" id="po_number" name="po_number" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="po_date">PO Date</label>
                                        <input type="date" id="po_date" name="po_date" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Reference
                                            Number</label>
                                        <input type="text" id="reference_number" name="reference_number"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Carrier
                                            </label>
                                            <input type="text" id="carrier" name="carrier"
                                            class="form-control" value="">
                                    </div>
                                </div>
                              
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="net_amount">Net Amount</label>
                                        <input readonly type="text" id="net_amount" name="net_amount"
                                            class="form-control" value="">
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="mode_of_transport">Mode of
                                            Transport</label>
                                            <select name="mode_of_transport" id="mode_of_transport" class="select2">
                                                <option value="1">Road</option>
                                                <option value="2">Rail</option>
                                                <option value="3">Air</option>
                                                <option value="4">Ship / Ship-cum-Road</option>
                                            </select>
                                    </div>
                                </div> -->
                            </div>
                            <hr class="mb-4">

                            <div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Port Of Loading
                                            </label>
                                            <input type="text" id="port_of_loading" name="port_of_loading"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Country Of Origin Of Goods
                                            </label>
                                            <input type="text" id="country_of_origin" name="country_of_origin"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Country Of Shipment
                                            </label>
                                            <input type="text" id="country_of_shipment" name="country_of_shipment"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="reference_number">Port Of Discharge
                                            </label>
                                            <input type="text" id="port_of_discharge" name="port_of_discharge"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="vehicle_number">Vehicle
                                            Number</label>
                                        <input type="text" id="vehicle_number" name="vehicle_number"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="loading_date">Loading Date</label>
                                        <input type="date" id="loading_date" name="loading_date" class="form-control"
                                            value="">
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="unloading_date">Unloading
                                            Date</label>
                                        <input type="date" id="unloading_date" name="unloading_date"
                                            class="form-control" value="">
                                    </div>
                                </div> -->
                                
                            </div>
                             <hr class="mb-4">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_type">Final Destination</label>
                                        <input type="text" id="final_destination" name="final_destination"
                                        class="form-control" value="">
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
                                                    <option value="<?php echo $row->id?>"><?php echo $row->comment?></option>
                                                    <?php
                                                }
                                               }
                                               ?>
                                      </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_type">INCOTERM</label>
                                        <input type="text" id="incoterm" name="incoterm"
                                        class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_type">CURRENCY</label>
                                        <input type="text" id="currency" name="currency"
                                        class="form-control" value="">
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_value">Discount
                                            Value</label>
                                        <input type="number" step="0.50" name="discount_value" id="discount_value"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="discount_amount">Discount
                                            Amount</label>
                                        <input readonly type="number" step="0.50" name="discount_amount"
                                            id="discount_amount" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="total_tax_amount">Total Tax
                                            amount</label>
                                        <input readonly type="text" id="total_tax_amount" name="total_tax_amount"
                                            class="form-control" value="">
                                    </div>
                                </div> -->
                            </div>
                         
                            <hr class="mb-4">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="cgst">TERMS OF DELIVERY & PAYMENT</label>
                                        <input type="text" id="terms_of_delivery" name="terms_of_delivery" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="sgst">NUMBER OF AMMENMENT</label>
                                        <input type="text" id="number_of_ammenment" name="number_of_ammenment" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="igst">Net Weight</label>
                                        <input type="text" id="net_weight" name="net_weight" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold" for="grand_amount">Gross Weight</label>
                                        <input  type="text"  name="gross_weight" id="gross_weight"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div> 
                            <hr class="mb-4">
                            <button type="submit" name="invoice_add" class="btn btn-success btn-sm d-block mx-auto">
                                <i class="mdi mdi-table-row-plus-after"></i>&nbsp;&nbsp;Create
                            </button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
            integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
            integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
        (function($) {
            'use strict';
            $(function() {
                $('#invoice_list').DataTable({
                    // "aLengthMenu": [
                    //   [5, 10, 15, -1],
                    //   [5, 10, 15, "All"]
                    // ],
                    "iDisplayLength": 10,
                    "language": {
                        search: ""
                    }
                });
                $('#invoice_list').each(function() {
                    var datatable = $(this);
                    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                    var search_input = datatable.closest('.dataTables_wrapper').find(
                        'div[id$=_filter] input');
                    search_input.attr('placeholder', 'Search');
                    search_input.removeClass('form-control-sm');
                    // LENGTH - Inline-Form control
                    var length_sel = datatable.closest('.dataTables_wrapper').find(
                        'div[id$=_length] select');
                    length_sel.removeClass('form-control-sm');
                });
            });
        })(jQuery);
        </script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    /* console.log(gst_no); return; */
                    $("#sub_customer_name").val(data.account_sub_name)
                    if (gst_no != '') {
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
                    } else {
                        $("#cgst").val('0')
                        $("#sgst").val('0')
                        $("#cgst").attr('readonly', true)
                        $("#sgst").attr('readonly', true)
                        $("#igst").attr('readonly', true)
                        $("#igst").val('0')
                    }
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });

        })
        </script>
        <script>
        $("#invoice_add_form").validate();
        </script>
        <!--ajxform-->
        <script>
        $('#invoice_add_form').ajaxForm({
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.status == 0) {
                    toast('danger', data.msg);
                } else { // success
                    toast('success', data.msg);
                    window.location = "<?= base_url('invoice/invoice-edit-export/') ?>" + data.redirect_id +
                        "#invoice_details_area";
                }
            }
        });
        </script>
</body>

</html>