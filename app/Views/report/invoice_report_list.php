<?php echo view ('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
<style>
select.form-control,
.form-control {
    outline: 1px solid #67676b;
}

.dataTables_wrapper label {
    font-size: auto !important;
}

div.dt-buttons>.dt-button,
div.dt-buttons>div.dt-button-split .dt-button {
    padding: 1px 10px
}

#invoice_list_filter input {
    padding: 7px 15px;
    border-radius: 5px;
}

.buttons-html5 {
    border-radius: 0 !important;
    background: beige !important;
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <?php //echo "<pre>"; print_r($customer_list);  ?>
                                    <form class="row" method="get">
                                        <div class="col-2">
                                            <label for="from_date" class="col-form-label">From Date</label>
                                            <input type="date" class="form-control" id="from_date"
                                                oninput="document.getElementById('to_date').min = document.getElementById('from_date').value;"
                                                value="<?=(isset($_GET['from_date']) && !empty($_GET['from_date']))?$_GET['from_date']:''?>"
                                                name="from_date">
                                        </div>
                                        <div class="col-2">
                                            <label for="to_date" class="col-form-label">To Date</label>
                                            <input type="date" class="form-control" id="to_date"
                                                value="<?=(isset($_GET['to_date']) && !empty($_GET['to_date']))?$_GET['to_date']:''?>"
                                                name="to_date">
                                        </div>
                                        <div class="col-2">
                                            <label for="customer_id" class="col-form-label">Customers</label>
                                            <select name="customer_id" id="customer_id" class="form-select">
                                                <option value=""> -- Select -- </option>
                                                <?php 
                                              foreach($customer_list AS $row){
                                                $selected = (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) == $row->id?'selected':'';
                                              ?>
                                                <option value="<?=$row->id?>" <?=$selected?>><?=$row->username?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="payment_status" class="col-form-label">Payment Status</label>
                                            <select name="payment_status" id="payment_status" class="form-select">
                                                <option value="">-- Select -- </option>
                                                <option value="1">Not Paid</option>
                                                <option value="2">Paid</option>
                                                <option value="3">Partial Paid</option>
                                                <option value="4">Cancle</option>

                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="particulars_id" class="col-form-label">HSN</label>
                                            <select name="particulars_id" id="particulars_id" class="form-select">
                                                <option value="">-- Select -- </option>
                                                <?php 
                                              foreach($particulars_list AS $row){
                                                $selected = (isset($_GET['particulars_id']) && !empty($_GET['particulars_id'])) == $row->id?'selected':'';
                                              ?>
                                                <option value="<?=$row->id?>" <?=$selected?>><?=$row->particular_hsn?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="master_item_particulars_id" class="col-form-label">Item</label>
                                            <select name="master_item_particulars_id" id="master_item_particulars_id" class="form-select">
                                                <option value="">-- Select -- </option>
                                                <?php 
                                              foreach($master_item_list AS $row){
                                                $selected = (isset($_GET['master_item_particulars_id']) && !empty($_GET['master_item_particulars_id'])) == $row->master_particular_id ? 'selected':'';
                                              ?>
                                                <option value="<?=$row->master_particular_id?>" <?=$selected?>><?=$row->item_name?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <label class="col-form-label"></label>
                                            <button type="submit" class="btn btn-primary mb-3">Search</button>
                                            <a href="<?=base_url('report/invoice-report-list')?>" class="btn btn-danger mb-3">Reset</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table id="invoice_list" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice No.</th>
                                                <th>Invoice Date</th>
                                                <th>Customer</th>
                                                <th>Net Amount</th>
                                                <th>Discount</th>
                                                <th>Total Tax</th>
                                                <th>Grand Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($invoice_report_list AS $key=>$row){ ?>
                                            <tr>
                                                <td><?=++$key?></td>
                                                <td><?=$row->invoice_number?></td>
                                                <td><?=$row->invoice_date?></td>
                                                <td><?=$row->customer_name ?>
                                                    <?= ($row->sub_customer_name != '') ? '<br> (' . $row->sub_customer_name . ')' : '' ?>
                                                </td>
                                                <td><?=$row->net_amount?></td>
                                                <td><?=$row->discount_amount?></td>
                                                <td><?=$row->total_tax_amount?></td>
                                                <td><?=$row->gross_amount?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right">Total:</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                            <?=date('Y') . ' ' . COMPANY_FULL_NAME?> . All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">With gratitude from <i
                                class="mdi mdi-heart text-danger"></i><a href="<?=CREDIT_LINK?>"
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

    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
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
                },
                layout: {
                    topStart: {
                        buttons: ['excelHtml5', 'pdfHtml5']
                    }
                },
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();

                    // Remove the formatting to get integer data for summation
                    let intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i :
                            0;
                    };

                    var total_net_am = api
                        .column(4)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Total over this page
                    /* pageTotal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0); */

                    // Update footer
                    api.column(4).footer().innerHTML = total_net_am;
                    // Total over all pages
                    var total_tax = api
                        .column(6)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Total over this page
                    /* pageTotal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0); */

                    // Update footer
                    api.column(6).footer().innerHTML = total_tax;
                    var total_grand = api
                        .column(7)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Total over this page
                    /* pageTotal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0); */

                    // Update footer
                    api.column(7).footer().innerHTML = total_grand;

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

    $(document).on('click', '.list-cancel-btn', function(e) {

        if (confirm(
                'Are you sure you want to proceed with cancellation? Please review the invoice details carefully before confirming.'
            )) {
            // $(this).data('id')
            $.ajax({
                type: 'POST',
                url: '<?=base_url('invoice/ajax-status-change-invoice-cancle-row')?>',
                data: {
                    id: $(this).data('id'),
                    payment_status: $(this).data('payment-status')
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if (data.status == 0) {
                        toast('danger', data.msg);
                    } else { // success
                        toast('success', data.msg);
                        // window.location = "<?= base_url('invoice/invoice-edit/') ?>"+data.redirect_id+"#invoice_details_area";
                    }
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });

        }
    });
    </script>
</body>

</html>