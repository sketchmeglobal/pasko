<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-md-6"><p><strong>Mode Of Transport: </strong></p></div>
            <div class="col-md-6"><p><?php echo $invoice->mode_of_transport?></p></div>    
        </div>
        <div class="row">
            <div class="col-md-6"><p><strong>Vehicle Number: </strong></p></div>
            <div class="col-md-6"><p><?php echo $invoice->vehicle_number?></p></div>    
        </div>
        <div class="row border-right border-bottom border-top border-dark">
            <p class="border-bottom border-dark"><strong>Bank Details</strong> : <?php echo $admin_details->bank_details?></p>
            <p class="border-top border-dark">
                <b>
                    <?php 
                    if(isset($declarations)){ 
                        echo $declarations->comment;
                    }else{
                        echo '';
                    }
                    ?>
                </b>
            </p>
        </div>
    </div>
    <div class="col-4 border border-top-0 border-dark text-center">
        <p><b>FOR, <?=COMPANY_FULL_NAME?></b></p>
        <br><br><br><br><br><br>
        <p><i>(Authorised Signatory)</i></p>
    </div>
    
</div>