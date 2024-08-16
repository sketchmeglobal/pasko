<?php echo view ('common/top_header_backdesk.php') ?>
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
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                <?=$customer_details->account_type?> - <?=$customer_details->account_name?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post" id="particular_form">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th>Particular Details</th>
                                    <th>Particular HSN</th>
                                    <th>Particular Fixed Head</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  foreach($particulars AS $key=>$row){
                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" class="form-control"
                                            name="particular_group[<?=$key?>][particular_id]" value="<?=$row->id?>">
                                        <input type="hidden" class="form-control"
                                            name="particular_group[<?=$key?>][customer_details_id]"
                                            value="<?=$customer_details_id?>">
                                        <?=$row->particular_title?>
                                    </td>
                                    <td><?=$row->particular_hsn?></td>
                                    <td>
                                        <select name="particular_group[<?=$key?>][particular_fixed_head]"
                                            class="form-select" id="particular_fixed_head">
                                            <?php
                                              if(empty($row->particular_fixed_head)){ 
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                            <?php }else{ ?>
                                            <option value="1" <?=($row->particular_fixed_head == 1)?'selected':''?>>
                                                Yes</option>
                                            <option value="0" <?=($row->particular_fixed_head == 0)?'selected':''?>>No
                                            </option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php
                                              if(!empty($row)){ 
                                            ?>
                                        <input type="number" class="form-control" require=""
                                            name="particular_group[<?=$key?>][rate]" id="rate"
                                            value="<?=($row->rate == 0)?'0.00':$row->rate?>">
                                        <?php }else{?>
                                        <input type="number" class="form-control" require=""
                                            name="particular_group[<?=$key?>][rate]" id="rate" value="0.00">
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php
                                  }
                                ?>
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div class="col-lg-12 text-center">
                                <button type="submit" name="submit" value="submit"
                                    class="btn btn-outline-primary">Submit</button>
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
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">With gratitude from ||
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
    <script>
    $('#particular_form').ajaxForm({
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
    </script>
</body>

</html>