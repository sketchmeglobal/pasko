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
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post" id="particular_form">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th colspan="6">Logo & Company Name</th>
                                    <th colspan="5">Address</th>
                                </tr>
                                <tr>
                                    <th colspan="7" style="text-align:center;">TAX INVOICE</th>
                                    <th>ABCD</th>
                                </tr>
                                <tr>

                                    <th colspan="7" style="text-align:center;">Name & Address of Bayer</th>
                                    <th rowspan="4"></th>
                                </tr>
                                <tr>
                                    <th colspan="7" style="text-align:center;">Details</th>
                                </tr>
                                <tr>
                                    <th colspan="7" style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <th colspan="7" style="text-align:center;"></th>
                                </tr>
                                <tr>
                                    <th>SL. NO.</th>
                                    <th>Description</th>
                                    <th>HSN Code</th>
                                    <th>No. of Packs</th>
                                    <th>Qty.</th>
                                    <th>Unit Rate (Rs.)</th>
                                    <th>Assessable Value (Rs.)</th>
                                    <th>Net Assessable Value (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>XYZ</td>
                                    <td>84245930</td>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>33000.00</td>
                                    <td>66000.00</td>
                                    <td>66000.00</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div class="row mt-2">
                            <div class="col-lg-12 text-center">
                                <button type="submit" name="submit" value="submit"
                                    class="btn btn-outline-primary">Submit</button>
                            </div>
                        </div> -->
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