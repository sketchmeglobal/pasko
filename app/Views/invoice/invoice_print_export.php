
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice - <?= $invoice->invoice_number ?></title>

    <!-- paper css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body{font-family: "Roboto", sans-serif;font-weight: 400;font-style: normal;}
        address,th,td,p{margin:0;font-size:14px;}
    </style>
</head>

    <body class="A4 " >
        <?php
        use App\Controllers\Invoice\InvoiceController;
        function convert_words($number){
            $controller = new InvoiceController();
            $words = $controller->numberToWords($number);
            return ucfirst($words);
        }
        ?>
        <?php 
            $print_arr = array('TRIPLICATE FOR ASSESSEE','ORIGINAL FOR BUYER','DUPLICATE FOR TRANSPORTER','EXTRA COPY');
            foreach($print_arr as $pa){
                ?>
                <section class="sheet p-4 mx-auto">
                    <div class="container-fluid border border-2 border-dark p-3" style="height:283mm;">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-5">
                                        <img style="height:50px" src="<?php echo base_url()?>assets/backdesk/img/logo.jpeg" />
                                        <h6 class="m-0"><strong><?= COMPANY_FULL_NAME ?></strong></h6>
                                        <p class="m-0"><b>Email Id:</b> <?= $admin_details->email_id?></p>
                                        <p class="m-0"><b>Phone No.:</b> <?= $admin_details->phone?></p>
                                    </div>
                                    <div class="col-3"></div>
                                    <div class="col-4">
                                        <!--<p><b>Date:</b> <?= date('d-m-Y') ?></p>-->
                                        <address><b>Address: </b><?= $admin_details->address;?></address>
                                    </div>
                                </div>
                                
                                <div class="row border-top border-bottom border-dark">
                                    <div class="col-6 text-center">
                                        <h6 class="m-0">COMMERCIAL INVOICE</h6>
                                    </div>
                                    <div class="col-6 text-center">
                                        <p class="m-0"><?=$pa?></p>
                                        <!-- <small class="float-right"><strong>Invoice Date:</strong> <?=date('d-m-Y', strtotime($invoice->invoice_date))?></small> -->
                                    </div>
                                </div>
        
                                <div class="row mt-2">
                                    
                                    <div class="col-6" style="">
                                        <p class="m-0"><strong>Exporter /Benificiary :</strong></p>
                                        <p><strong><u><?=COMPANY_FULL_NAME?></u></strong></p>
                                        <address><?= $admin_details->address;?></address>
                                        <p><strong>TIN: </strong><?php echo $admin_details->TIN_no?></p>
                                        <p><strong>GSTIN: </strong><?php echo $admin_details->GSTIN?></p>
                                    </div>
                                    
                                    <div class="col-6">
                                        <p><strong>Invoice No:</strong> <?= $invoice->invoice_number ?></p>
                                        <p><strong>Invoice Date:</strong> <?=date('d-m-Y', strtotime($invoice->invoice_date))?></p>
                                        <p><strong>Company IEC No:</strong> <?=$invoice->reference_number?></p>
                                        <p><strong>Buyer's Order No:</strong> <?=$invoice->po_number?></p>
                                        <p><strong>Buyer's Order Date:</strong> <?=date('d-m-Y', strtotime($invoice->po_date))?></p>
                                        
                                        <div class="border p-2">
                                            <?php if($invoice->govt_irn_no != '') { ?>
                                                <p><strong>IRN No.:</strong> <?=$invoice->govt_irn_no?></p>
                                                <p><strong>Acknowledgement No.:</strong> <?=$invoice->govt_acknowledgement_no?></p>
                                            <?php } ?>
                                        </div>
                                        <?php
                                            $taxable_amount = number_format(($invoice->net_amount - $invoice->discount_amount + $invoice->other_charges_amount), 2, '.', '');
                                            $cgst = number_format(($taxable_amount*$invoice->cgst)/100, 2, '.', '');
                                            $sgst = number_format(($taxable_amount*$invoice->sgst)/100, 2, '.', '');
                                            $igst = number_format(($taxable_amount*$invoice->igst)/100, 2, '.', '');
                                        ?>
                                    </div>
                                    
                                </div>
                                
                                <div class="mt-2 row">
                                    <div class="col-6 border border-dark border-bottom-0">
                                        <p class="m-0"><strong>Consignee:</strong></p>
                                        <p class="m-0"><?= $invoice->customer_name ?> (<?= $invoice->sub_customer_name ?>)</p> 
                                        <address class="m-0"><?= $customer_details->address ?></address>
                                        <p class="m-0"><b>Tel:</b> <?= $customer_details->phone ?></p>
                                        <p class="m-0"><b>Email Id:</b> <?= $customer_details->email_id ?></p>
                                    </div>
                                    <div class="col-6 border border-dark border-start-0 border-bottom-0">
                                        <p><strong>Terms of Delivery & Payment:</strong></p>
                                        <p><?= $invoice->terms_of_delivery ?></p>
                                        <p><strong>Number of Amendment</strong> <?= $invoice->number_of_ammenment ?></p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-4 border border-dark border-bottom-0">
                                        <p><strong>Carrier: </strong><br><?= $invoice->carrier ?></p>
                                    </div> 
                                    <div class="col-4 border-top border-dark">
                                        <p><strong>Port of Loading: </strong><br><?= $invoice->port_of_loading ?></p>
                                    </div> 
                                    <div class="col-4 border border-dark border-bottom-0">
                                        <p><strong>Country of Origin of Goods: </strong><br><?= $invoice->country_of_origin ?></p>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-4 border border-dark border-end-0">
                                        <p><strong>Country of Shipment: </strong><br><?= $invoice->country_of_shipment ?></p>
                                    </div> 
                                    <div class="col-4 border border-dark border-end-0">
                                        <p><strong>Port of Discharge: </strong><br><?= $invoice->port_of_discharge ?></p>
                                    </div> 
                                    <div class="col-4 border border-dark">
                                        <p><strong>Final Destination: </strong><br><?= $invoice->final_destination ?></p>
                                    </div> 
                                </div>

                                <div class="row mt-2">
                                    <table class="table table-bordered border-dark">
                                        <thead>
                                            <tr>
                                                <th>Marks & Numbers</th>
                                                <th>Number & Kind of Pkgs</th>
                                                <th>Description	</th>
                                                <th>Qty.</th>
                                                <th>Unit</th>
                                                <th class="text-end">Unit Price <?=$invoice->incoterm?> (<?=$invoice->currency?>)</th>
                                                <th class="text-end">Total Price <?=$invoice->incoterm?> (<?=$invoice->currency?>)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            if(!empty($invoice_dtl)){
                                                foreach($invoice_dtl as $row){
                                                    $total +=$row->assessable_value;
                                                    ?>
                                                    <tr>
                                                        <td><?=$row->marks_numbers?></td>
                                                        <td><?=$row->kind_packages?></td>
                                                        <td><?=$row->master_particular_name?><br>H.S.N Code : <?=$row->hsn_code?></td>
                                                        <td><?=$row->quantity?></td>
                                                        <td><?=$row->unit?></td>
                                                        <td class="text-end"><?=$row->unit_rate?></td>
                                                        <td class="text-end"><?=$row->assessable_value?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" class="text-end">Total <?=$invoice->incoterm?> Value</th>
                                                <td colspan="1" class="text-end"><?=$total?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 border border-dark mb-3">
                                        <p><strong>Amount in Words: </strong><?= convert_words(round($total)) ?></p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-7 border border-dark">
                                        <p><strong>Net Weight:</strong> <?= $invoice->net_weight ?></p>
                                        <p><strong>Gross Weight:</strong> <?= $invoice->gross_weight ?></p>
                                        <hr class="border-dark">
                                        <p>
                                            <strong>Declaration:</strong>
                                            <?php
                                            if(isset($declarations)){ 
                                                echo $declarations->comment;
                                            }else{
                                                echo '';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-5 p-2 border border-dark border-start-0">
                                        <p><strong>Signature of Benificiary</strong></p>
                                        <p><br><br><br><br><br></p>
                                        <p><?=COMPANY_FULL_NAME?></p>
                                    </div>
                                </div>
                                
                                <!--<div class="row text-center" style="position: absolute;display: block;width: 90%;bottom: 25px;">-->
                                <!--    <div class="col-12"><p class="fw-bold"><small>SUBJECT TO KOLKATA JURISDICTION</small></p></div>-->
                                <!--    <div class="col-12"><p class="fw-bold"><small>This is a Computer Generated Invoice</small></p></div>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </section>      
                <?php
            }
        ?>
    </body>
    
</html>