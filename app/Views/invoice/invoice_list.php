<?php echo view ('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
<style>
  select.form-control, .form-control{outline: 1px solid #67676b;}
  .dataTables_wrapper label{font-size: auto!important;}
  div.dt-buttons > .dt-button, div.dt-buttons > div.dt-button-split .dt-button{padding:1px 10px}
  #invoice_list_filter input{padding: 7px 15px;border-radius: 5px;}
  .buttons-html5{border-radius: 0!important;background: beige!important;}

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
                <h4 class="card-title">
                  <a href="<?=base_url('invoice/invoice-add')?>" class="badge badge-gradient-success"> <i class="mdi mdi-plus"></i> Create</a>
                </h4>
                <hr>
                <div class="row">
                  <div class="col-12">
                    <table id="invoice_list" class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Invoice No.</th>
                          <th>Invoice Date</th>
                          <th>Customer</th>
                          <th>Gross Amount</th>
                          <!--<th>Payment Status</th>-->
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if(count($invoice_headers) > 0) {
                          $iter  =1;
                          foreach($invoice_headers as $ih){
                          ?>
                          <tr>
                            <td><?=$iter++?></td>
                            <td><?=$ih->invoice_number?></td>
                            <td><?=date('d-m-Y', strtotime($ih->invoice_date))?></td>
                            <td><?=$ih->customer_name ?> <?= ($ih->sub_customer_name != '') ? '<br> (' . $ih->sub_customer_name . ')' : '' ?></td>
                            <td><?=$ih->gross_amount?></td>
                            <!--<td>
                            <?php 
                            if($ih->payment_status == 1){
                              echo '<label class="badge badge-danger"><i class="mdi mdi-receipt-clock"></i>&nbsp;Pending</label>';
                            } else if($ih->payment_status == 2){
                              echo '<label class="badge badge-gradient-success"><i class="mdi mdi-check-circle"></i>&nbsp;Paid</label>';
                            } else{
                              echo '<label class="badge badge-gradient-warning"><i class="mdi mdi-star-half-full"></i>&nbsp;Partial</label>';
                            }
                            ?>                            
                            </td>-->
                            <td>
                              <a href="<?=base_url('invoice/invoice-edit/') . $ih->id?>" class="badge badge-gradient-primary"> <i class="mdi mdi-file-edit"></i>&nbsp;Edit</a>
                              <!--<a href="<?=base_url('invoice/invoice-payments/') . $ih->id?>" class="badge badge-gradient-info"> <i class="mdi mdi-cash-clock"></i>&nbsp;Payment</a>-->
                              <a href="<?=base_url('invoice/invoice-json-format/') . $ih->id?>" class="badge badge-gradient-warning"> <i class="mdi mdi-cash-clock"></i>&nbsp;JSON</a>
                              <!--<a href="javascript:void(0)" class="badge badge-gradient-danger list-cancel-btn" data-id="<?=$ih->id?>" data-payment-status="<?=$ih->payment_status?>"> <i class="mdi mdi-file-cancel"></i>&nbsp;Cancel</a>-->
                              <a href="<?= base_url('invoice/invoice-print/') . $ih->id ?>" target="_blank"
                              class="badge badge-gradient-info"> <i class="fa-solid fa-print"></i>&nbsp;Print</a>
                            </td>
                          </tr>
                          <?php 
                          }
                        }else{ ?>
                          <td align="center" colspan="7">No records found</td>
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
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?=date('Y') . ' ' . COMPANY_FULL_NAME?> . All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">With gratitude from <i class="mdi mdi-heart text-danger"></i><a href="<?=CREDIT_LINK?>" target="_blank"><?=CREDIT_TITLE?></a></span>
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
            }
          });
          $('#invoice_list').each(function() {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.removeClass('form-control-sm');
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
          });
        });
      })(jQuery);

      $(document).on('click','.list-cancel-btn',function(e){

        if(confirm('Are you sure you want to proceed with cancellation? Please review the invoice details carefully before confirming.')){
          // $(this).data('id')
          $.ajax({
              type: 'POST', 
              url: '<?=base_url('invoice/ajax-status-change-invoice-cancle-row')?>', 
              data: { id: $(this).data('id'), payment_status : $(this).data('payment-status')  }, 
              dataType: 'json',
              success: function (data) { 
                  console.log(data)
                  if(data.status == 0){
                    toast('danger',data.msg);
                  } else{ // success
                      toast('success',data.msg);
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