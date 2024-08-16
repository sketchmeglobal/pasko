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
        <h6 class="m-0">TAX  INVOICE</h6>
    </div>
    <div class="col-6 text-center">
        <p class="m-0"><?= isset($pa) ? $pa : '' ?></p>
        <!-- <small class="float-right"><strong>Invoice Date:</strong> <?=date('d-m-Y', strtotime($invoice->invoice_date))?></small> -->
    </div>
</div>

<div class="row mt-3">
    
    <div class="col-4" style="">
        <p class="m-0"><strong>Name & Address of Buyer:</strong></p>
        <p class="m-0"><?= $invoice->customer_name ?> (<?= $invoice->sub_customer_name ?>)</p> 
        <address class="m-0"><?= $customer_details->address ?></address>
        <p><strong>BUYER'S GSTIN: </strong><?php echo $customer_details->GSTIN?></p>
    </div>
    <div class="col-4">
        <?php if($invoice->delivery_address != '') { ?>
            <p class="m-0"><strong>Delivery Address:</strong></p>
            <p><?=$invoice->delivery_address?></p>
        <?php } ?>
    </div>
    <div class="col-4">
        <p><strong>Invoice No:</strong> <?= $invoice->invoice_number ?></p>
        <p><strong>Invoice Date:</strong> <?=date('d-m-Y', strtotime($invoice->invoice_date))?></p>
        <p><strong>P.O. No:</strong> <?=$invoice->po_number?></p>
        <p><strong>P.O. Date:</strong> <?=date('d-m-Y', strtotime($invoice->po_date))?></p>
        <p><strong>Pasko Ref. No:</strong> <?=$invoice->reference_number?></p>
        <div class="border">
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