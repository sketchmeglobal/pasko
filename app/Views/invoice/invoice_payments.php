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

#invoice_payment_filter input {
    padding: 7px 15px;
    border-radius: 5px;
}

.buttons-html5 {
    border-radius: 0 !important;
    background: beige !important;
}

label {
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
                    <div class="row">
                        <div class="col-6 col-lg-10">
                            Payment Status:
                            <?php if($invoice_headers[0]->payment_status == 2){ ?>
                            <label for="" class="badge badge-success">Paid</label>
                            <?php } else if($invoice_headers[0]->payment_status == 1){ ?>
                            <label for="" class="badge badge-warning">Partially paid</label>
                            <?php } else { ?>
                            <label for="" class="badge badge-danger">Payment not initiated</label>
                            <?php } ?>
                        </div>
                        <div class="col-6 col-lg-2 text-end">
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input <?= ($invoice_headers[0]->payment_status == 2) ? ' checked ' : '' ?>
                                        type="checkbox" value="<?=$invoice_headers[0]->id?>" class="form-check-input mark_as_full_paid"> Mark As Full Paid <i
                                        class="input-helper"></i></label>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title row">
                                <span class="col-md-4"><a data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                        class="badge badge-gradient-success"> <i class="mdi mdi-plus"></i> Add
                                        Payment</a> <!-- href="< ?=base_url('invoice/invoice-payment-add')?>" --></span>
                                <span class="col-md-8 small text-end">
                                    Total Invoice Amount: <b><?= $invoice_headers[0]->gross_amount ?></b> ||
                                    Total Paid:
                                    <?php
                    $total_paid=0; 
                    if(count($invoice_payments) > 0) {
                      foreach($invoice_payments as $ip){
                        $total_paid+=$ip->payment_value;
                      }
                    }
                    echo '<label id="total_paid"><b>' . $total_paid . '</b></label>';
                    ?>
                                </span>
                            </h4>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <table id="invoice_payment" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice No.</th>
                                                <th>Reference Number</th>
                                                <th>Payment Date</th>
                                                <th>Payment Amount</th>
                                                <th>Comments</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                        if(count($invoice_payments) > 0) {
                          $iter=1;
                          foreach($invoice_payments as $ip){
                          ?>
                                            <tr>
                                                <td><?=$iter++?></td>
                                                <td><?=$invoice_headers[0]->invoice_number?></td>
                                                <td><?=$ip->reference_number?></td>
                                                <td><?=date('d-m-Y', strtotime($ip->payment_date))?></td>
                                                <td><?=$ip->payment_value?></td>
                                                <td><?=$ip->comments?></td>
                                                <td>
                                                    <!-- <a href="< ?=base_url('invoice/invoice-payment-edit/') . $ip->id?>" class="badge badge-primary"> <i class="mdi mdi-file-edit"></i>&nbsp;Edit</a> -->
                                                    <label data-id="<?= $ip->id ?>"
                                                        class="delete_row badge badge-danger"> <i
                                                            class="mdi mdi-file-cancel"></i>&nbsp;Delete</label>
                                                </td>
                                            </tr>
                                            <?php 
                          }
                        }else{ ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="center">No records found</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
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

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Payments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="invoice_payment_form" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="w-100 font-weight-bold" for="invoice_number">Invoice Number</label>
                                <input disabled type="text" name="" id="invoice_number" class="form-control"
                                    value="<?=$invoice_headers[0]->invoice_number?>">
                            </div>
                            <div class="col-md-6">
                                <label class="w-100 font-weight-bold" for="reference_number">Reference Number</label>
                                <input type="text" name="reference_number" id="reference_number"
                                    class="reference_number form-control">
                            </div>
                        </div>
                        <hr class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="w-100 font-weight-bold" for="payment_date">Payment Date</label>
                                <input required type="date" name="payment_date" id="payment_date"
                                    class="payment_date form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="w-100 font-weight-bold" for="payment_value">Payment Amount</label>
                                <input required type="text" name="payment_value" id="payment_value"
                                    class="payment_value form-control">
                            </div>
                        </div>
                        <hr class="mt-3">
                        <div class="row">
                            <div class="col-12">
                                <label class="w-100 font-weight-bold" for="comments">Payment Comment</label>
                                <textarea name="comments" id="comments" class="comments form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <input type="hidden" name="invoice_header_id" value="<?=$invoice_headers[0]->id?>">
                        <button type="submit" class="btn btn-sm btn-gradient-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php echo view ('common/footer_backdesk.php') ?>

    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <!-- valdiate and datatable -->
    <script>
    $("#invoice_payment_form").validate();
    (function($) {
        'use strict';
        $(function() {
            $('#invoice_payment').DataTable({
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
                }
            });
            $('#invoice_payment').each(function() {
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
    <script src="https://cdn.ckeditor.com/4.22.1/basic/ckeditor.js"></script>
    <script>
    CKEDITOR.replace('comments');
    </script>
    <!-- delete row -->
    <script>
    $(document).on('click', '.delete_row', function() {
        if (confirm("Are you sure?")) {
            $this = $(this)
            invoice_payment_id = $(this).data('id')
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?=base_url('invoice/ajax-delete-invoice-payment-row')?>",
                data: {
                    invoice_payment_id: invoice_payment_id
                },
                success: function(data) {
                    if (data.status == 0) { // error
                        toast('danger', data.msg);
                    } else { // success
                        $this.closest('tr').remove()
                        $("#total_paid").html('<i>refresh the page</i>')
                        toast('success', data.msg);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            })
        }
    })

    $(".mark_as_full_paid").click(function(e) {

        if (confirm(
                'Are you sure you want to proceed with Full Paid?'
                )) {
            // $(this).data('id')
            $.ajax({
                type: 'POST',
                url: '<?=base_url('invoice/ajax-status-change-invoice-mark-as-full-paid')?>',
                data: {
                    id: $(this).val()
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