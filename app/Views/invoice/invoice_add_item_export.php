<?php echo view('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    #invoice_details_area label {
        font-size: 13px
    }
    input[readonly]
    {
        background-color: #eeeeee;
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

                <!-- Invoice detail area -->
                <div id="invoice_details_area" class="card mt-3">
                    <!-- new row add starts-->
                    <div class="particular_row d-none">
                        <div class="particular_sub_row">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Item No.</label>
                                    <input required type="text" name="item_nos[]" class="form-control" placeholder="Item number">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Item Category</label>
                                    <select required name="item_category_ids[]" class="form-select new_select2 item_category">
                                        <option value="" selected disabled>Select category</option>
                                        <?php
                                        foreach($item_categories as $v) {
                                            ?>
                                            <option value="<?=$v->id?>"><?=$v->title?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="category_names[]" class="category_name">
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Item</label>
                                    <select required name="item_ids[]" class="items form-select new_select2">
                                        <option value="" selected disabled>Select category first</option>
                                    </select>
                                </div>
                                <input type="hidden" name="item_names[]" class="item_name">
                                <input type="hidden" name="item_hsn_codes[]" class="item_hsn_code">
                                <div class="col-md-2">
                                    <label class="w-100 font-weight-bold">BOQ</label>
                                    <input required type="text" name="boq[]" class="form-control" placeholder="BOQ">
                                </div>

                                <div class="col-md-1">
                                    <label class="w-100 font-weight-bold"></label>
                                    <span data-id="0" style="cursor:pointer" class="badge badge-gradient-danger delete_row pull-right">
                                        <i class="fa-regular fa-trash-can"></i> Delete
                                    </span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Unit</label>
                                    <input required type="text" name="unit[]" class="unit form-control" placeholder="Item unit">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Previous Quantity</label>
                                    <input readonly required type="number" name="prev_qty[]" min="0" step=".001" class="prev_qty form-control" placeholder="Previous quantity">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Present Quantity</label>
                                    <input required type="number" name="pres_qty[]" min="0.001" step=".001" class="pres_qty form-control" placeholder="Present quantity">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Cumulative Quantity</label>
                                    <input readonly required type="number" name="cum_qty[]" min="0.001" step=".001" class="cum_qty form-control" placeholder="Cumulative quantity">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Rate</label>
                                    <input required type="number" name="rate[]" min="0" step=".01" class="rate form-control" placeholder="Item rate">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Previous Amount</label>
                                    <input readonly required type="number" name="prev_amt[]" min="0" step=".01" class="prev_amount form-control" placeholder="Previous amount">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Present Amount</label>
                                    <input readonly required type="number" name="pres_amt[]" min="0" step=".01" class="pres_amount form-control" placeholder="Present amount">
                                </div>
                                <div class="col-md-3">
                                    <label class="w-100 font-weight-bold">Cumulative Amount</label>
                                    <input readonly required type="number" name="cum_amt[]" min="0" step=".01" class="cum_amount form-control" placeholder="Cumulative amount">
                                </div>
                                <hr class="mt-3">
                            </div>
                        </div>
                    </div>
                    <!-- new row add ends-->

                    <form id="invoice_add_item_form" action="<?= base_url('invoice/ajax-invoice-add-item-form') ?>" method="post" class="card-body">
                        <h4 class="card-title">
                            <span>Add Items || <?=$project->project_name?> (<?=$project->project_code?>) / <?=$invoice->invoice_number?></span>
                            <span style="cursor:pointer" class="badge badge-gradient-info add_row float-end"><small><i class="fa-solid fa-plus"></i> Add</small></span>
                            <hr>
                        </h4>

                        <div class="added_row">
                            <div class="particular_sub_row">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Item No.</label>
                                        <input required type="text" name="item_nos[]" class="form-control" placeholder="Item number">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Item Category</label>
                                        <select required name="item_category_ids[]" class="form-select select2 item_category">
                                            <option value="" selected disabled>Select category</option>
                                            <?php
                                            foreach($item_categories as $v) {
                                                ?>
                                                <option value="<?=$v->id?>"><?=$v->title?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="category_names[]" class="category_name">
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Item</label>
                                        <select required name="item_ids[]" class="form-select select2 items">
                                            <option value="" selected disabled>Select category first</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="item_names[]" class="item_name">
                                    <input type="hidden" name="item_hsn_codes[]" class="item_hsn_code">
                                    <div class="col-md-2">
                                        <label class="w-100 font-weight-bold">BOQ</label>
                                        <input required type="text" name="boq[]" class="form-control" placeholder="BOQ">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="w-100 font-weight-bold"></label>
                                        <span data-id="0" style="cursor:pointer" class="badge badge-gradient-danger delete_row pull-right">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </span>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Unit</label>
                                        <input required type="text" name="unit[]" class="unit form-control" placeholder="Item unit">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Previous Quantity</label>
                                        <input readonly required type="number" name="prev_qty[]" min="0" step=".001" class="prev_qty form-control" placeholder="Previous quantity">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Present Quantity</label>
                                        <input required type="number" name="pres_qty[]" min="0.001" step=".001" class="pres_qty form-control" placeholder="Present quantity">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Cumulative Quantity</label>
                                        <input readonly required type="number" name="cum_qty[]" min="0.001" step=".001" class="cum_qty form-control" placeholder="Cumulative quantity">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Rate</label>
                                        <input required type="number" name="rate[]" min="0" step=".01" class="rate form-control" placeholder="Item rate">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Previous Amount</label>
                                        <input readonly required type="number" name="prev_amt[]" min="0" step=".01" class="prev_amount form-control" placeholder="Previous amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Present Amount</label>
                                        <input readonly required type="number" name="pres_amt[]" min="0" step=".01" class="pres_amount form-control" placeholder="Present amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="w-100 font-weight-bold">Cumulative Amount</label>
                                        <input readonly required type="number" name="cum_amt[]" min="0" step=".01" class="cum_amount form-control" placeholder="Cumulative amount">
                                    </div>
                                    <hr class="mt-3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <input type="hidden" name="project_id" id="project_id" value="<?= $invoice->project_id ?>"/>
                                <input type="hidden" name="invoice_header_id" value="<?= $invoice_id ?>"/>
                                <button type="submit" name="submit" class="btn btn-gradient-success btn-sm mx-auto">
                                    <i class="mdi mdi-table-row-plus-before"></i> Add Items
                                </button>

                                <a href="<?=base_url('invoice/invoice-list-t2/'.$invoice->project_id)?>" class="btn btn-gradient-dark btn-sm mx-auto">
                                    <i class="fa-solid fa-arrow-left"></i> Back
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
                                <?= date('Y') . ' ' . COMPANY_FULL_NAME ?> . All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">With gratitude from
                                <i class="mdi mdi-heart text-danger"></i><a href="<?= CREDIT_LINK ?>"
                                                                            target="_blank"><?= CREDIT_TITLE ?></a></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php echo view('common/footer_backdesk.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('#invoice_add_item_form').ajaxForm({
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status == 0) {
                        toast('danger', data.msg);
                    } else { // success
                        toast('success', data.msg);
                        window.location = "<?= base_url('invoice/invoice-list-export/'.$invoice->project_id) ?>";
                    }
                }
            });

            $(document).on('change', '.item_category', function () {
                $this = $(this);
                selected_text = $(this).find("option:selected").text();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?=base_url('invoice/ajax-get-items')?>",
                    data: {
                        cat_id: $this.val(),
                    },
                    success: function (data) {
                        if (data.status == 0) { // error
                            toast('danger', data.msg);
                        } else { // success
                            $this.closest('.particular_sub_row').find('.items').html(data.html);
                            $this.closest('.particular_sub_row').find('.category_name').val(selected_text);
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }
                })
            });
            $(document).on('change', '.items', function () {
                $this = $(this);
                selected_text = $(this).find("option:selected").text();
                var project_id = $('#project_id').val();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?=base_url('invoice/ajax-get-item-data')?>",
                    data: {
                        item_id: $this.val(), project_id: project_id,
                    },
                    success: function (data) {
                        if (data.status == 0) { // error
                            toast('danger', data.msg);
                        } else { // success
                            $this.closest('.particular_sub_row').find('.unit').val(data.unit);
                            $this.closest('.particular_sub_row').find('.rate').val(data.rate);
                            $this.closest('.particular_sub_row').find('.prev_qty').val(data.prev_qty);
                            $this.closest('.particular_sub_row').find('.pres_qty').val('');
                            $this.closest('.particular_sub_row').find('.cum_qty').val('');
                            $this.closest('.particular_sub_row').find('.prev_amount').val(data.prev_amount);
                            $this.closest('.particular_sub_row').find('.pres_amount').val('');
                            $this.closest('.particular_sub_row').find('.cum_amount').val('');
                            $this.closest('.particular_sub_row').find('.item_name').val(selected_text);
                            $this.closest('.particular_sub_row').find('.item_hsn_code').val(data.item_hsn_code);
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }
                })
            });
            $(document).on('change', '.pres_qty, .rate', function () {
                $this = $(this);
                var prev_qty = $this.closest('.particular_sub_row').find('.prev_qty').val();
                var pres_qty = $this.closest('.particular_sub_row').find('.pres_qty').val();
                var cum_qty = (parseFloat(prev_qty) + parseFloat(pres_qty)).toFixed(3);

                var rate = $this.closest('.particular_sub_row').find('.rate').val();
                var prev_amount = $this.closest('.particular_sub_row').find('.prev_amount').val();
                var pres_amount = (rate * pres_qty).toFixed(2);
                var cum_amount = (parseFloat(prev_amount) + parseFloat(pres_amount)).toFixed(2);

                $this.closest('.particular_sub_row').find('.cum_qty').val(cum_qty);
                $this.closest('.particular_sub_row').find('.pres_amount').val(pres_amount);
                $this.closest('.particular_sub_row').find('.cum_amount').val(cum_amount);
            });
            $(document).on('click', '.delete_row', function () {
                if (confirm("Are you sure?")) {
                    $(this).closest('.particular_sub_row').remove()
                }
            });
            $(".add_row").on('click', function () {
                particular_row = $(".particular_row").html()
                $(".added_row").append(particular_row)
                $(".added_row .new_select2").select2()
            });
        });
    </script>

</body>

</html>