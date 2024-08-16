
<div class="row border border-dark">
                                    
    <div class="col-md-4">
        <p><strong><u><?=COMPANY_FULL_NAME?></u></strong></p>
        <p><strong>GSTIN: </strong><?php echo $admin_details->GSTIN?></p>
        <p><strong>CIN: </strong><?php echo $admin_details->cin_no?></p>
    </div>
    <div class="col-md-4">
        <!--<p><strong><u><?php echo $invoice->code_type?></u></strong>: </p>-->
        <!--<p>< ?php echo $invoice->code_value;?></p>-->
    </div>
    <div class="col-md-4">
        <!--<div class="row">-->
        <!--    <div class="col-6">-->
        <!--        <p><strong>Other Charges:</strong></p>-->
        <!--    </div>-->
        <!--    <div class="col-6 text-end">-->
        <!--        <p><?php echo $invoice->other_charges_amount ?></p>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="row">-->
        <!--    <div class="col-6">-->
        <!--        <p><strong>Discount:</strong></p>-->
        <!--    </div>-->
        <!--    <div class="col-6 text-end">-->
        <!--        <p><?php echo $invoice->discount_amount ?></p>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="row">
            <div class="col-6">
                <p><strong>CGST @ <?php echo $invoice->cgst?>%:</strong></p>
            </div>
            <div class="col-6 text-end">
                <p><?= isset($cgst) ? $cgst : ''?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p><strong>SGST @ <?php echo $invoice->sgst?>%:</strong></p>
            </div>
            <div class="col-6 text-end">
                <p><?= isset($sgst) ? $sgst : ''?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p><strong>IGST @ <?php echo $invoice->igst?>%:</strong></p>
            </div>
            <div class="col-6 text-end">
                <p><?= isset($igst) ? $igst : ''?></p>
            </div>
        </div>
          <div class="row">
            <div class="col-6">
                <p><strong>Total Amount:</strong></p>
            </div>
            <div class="col-6 text-end">
                <p><?= $invoice->gross_amount?></p>
            </div>
        </div>
    </div>
    
</div>

<div class="row border-bottom border-dark">
    <div class="col-md-3"><p><strong>Total Amount In Words</strong></p></div>
    <div class="col-md-9"><?=convert_words($invoice->gross_amount)?></div>

    <div class="col-md-3"><p><strong>Total CGST In Words</strong></p></div>
    <div class="col-md-9"><p><?= (isset($cgst)) ? ($cgst == 0) ? '-' : convert_words($cgst) : '' ?></p></div>

    <div class="col-md-3"><p><strong>Total SGST In Words</strong></p></div>
    <div class="col-md-9"><p><?= (isset($sgst)) ? ($sgst == 0) ? '-' : convert_words($sgst) : '' ?></p></div>

    <div class="col-md-3"><p><strong>Total IGST In Words</strong></p></div>
    <div class="col-md-9"><p><?= (isset($igst)) ? ($igst == 0) ? '-' : convert_words($igst) : '' ?></p></div>
</div>