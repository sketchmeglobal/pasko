
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
        body{font-family: "Roboto", sans-serif;font-weight: 400;font-style: normal;background: #ADA996;  /* fallback for old browsers */background: -webkit-linear-gradient(to right, #EAEAEA, #DBDBDB, #F2F2F2, #ADA996);  /* Chrome 10-25, Safari 5.1-6 */background: linear-gradient(to right, #EAEAEA, #DBDBDB, #F2F2F2, #ADA996); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */}
        label,address,th,td,p{margin:0;font-size:12px;}
        @media print {
            #page_settings{display: none;height:0;}
        }
    </style>
</head>

    <body class="A4">
        <div class="container">
            <div class="row">
                <div id="page_settings" class="offset-4 col-4 text-center bg-light mt-3 p-2 border border-dark">
                    <label class="fw-bold w-100 border-bottom border-dark pb-1 mb-2">Page settings</label>
                    <label>Add Extra Rows</label>
                    <input type="number" id="add_last_row" /> <br>
                    <label class="mt-3">Change Fonts</label>
                    <span class="btn btn-sm btn-info" id="font_size_plus">+</span> | <span class="btn btn-sm btn-info" id="font_size_minus">-</span>      
                </div>
            </div>
        </div>
        <?php
        use App\Controllers\Invoice\InvoiceController;
        function convert_words($number){
            $controller = new InvoiceController();
            $words = $controller->numberToWords($number);
            return ucwords($words);
        }
        ?>
        <?php
            
            $cgst = $sgst = $igst = 0;
            $rows_per_page = $invoice->rows_per_page;
            $total_items = count($invoice_dtl);
            if($total_items < $rows_per_page){
                $total_pages = 1;    
            } else{
                $total_pages = ceil($total_items/$rows_per_page);
            }
            
            
            $print_arr = array('TRIPLICATE FOR ASSESSEE','ORIGINAL FOR BUYER','DUPLICATE FOR TRANSPORTER','EXTRA COPY');
            foreach($print_arr as $pa){
                $current_page = 1;
                ?>
                <section class="sheet p-4 mx-auto" style='height:auto'>
                    <div class="container-fluid border border-2 border-dark p-3" >
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?= view('invoice/print-component/header', ['pa'=>$pa]) ?>
                                
                                <div class="row mt-3">
                                    <table class="table table-hover table-striped table-bordered table-sm border-dark mb-1">
                                        <thead class="text-center">
                                            <tr>
                                                <th>#</th>
                                                <th width="42.5%">Description</th>
                                                <th class="text-center"><?php echo $invoice->code_type?></th>
                                                <th class="text-end">No. of Packs</th>
                                                <th class="text-end">Qty.</th>
                                                <th class="text-end">Unit Rate (Rs.)</th>
                                                <th class="text-end">Assessable Value (Rs.)</th>
                                                <th class="text-end">Net-Assessable Value (Rs.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $counter = $page_break = 1;
                                        $total = 0;
                                        foreach ($invoice_dtl as $v) {
                                            $total += $v->assessable_value;
                                            
                                            // page break starts
                                            if($page_break > $rows_per_page){
                                                
                                                echo '</tobdy></table>'; // table ends
                                                echo '</div>'; // row
                                                echo view('invoice/print-component/footer');
                                                echo '<small class="d-block text-end">Page ' . $current_page . ' of '. $total_pages . '</small>';
                                                echo '</div></div>'; // col-row ends
                                                echo '</section>'; // section ends
                                                
                                                echo '<section class="sheet p-4 mx-auto"><div class="container-fluid border border-2 border-dark p-3" ><div class="row"><div class="col-md-12">';
                                                echo view('invoice/print-component/header', ['pa'=>$pa]);
                                                echo '<div class="row mt-3"><table class="table table-hover table-striped table-bordered table-sm border-dark mb-1"><thead class="text-center">';
                                                echo '<tr><th>#</th><th width="42.5%">Description</th><th class="text-center">'.$invoice->code_type.'</th><th class="text-end">No. of Packs</th><th class="text-end">Qty.</th><th class="text-end">Unit Rate (Rs.)</th><th class="text-end">Assessable Value (Rs.)</th><th class="text-end">Net-Assessable Value (Rs.)</th></tr></thead>';
                                                echo '<tbody>';
                                                
                                                $current_page++;
                                                $page_break = 1;
                                                
                                            }else{
                                                $page_break++;
                                            }
                                            // page break ends
                                            
                                            ?>
                                            <tr>
                                                <td><?= ($v->hsn_code == '') ? '' : $counter++ . '.' ?></td>
                                                
                                                <td><?= $v->master_particular_name .'<br>'. $v->particular_after_content ?></td>
                                                <td class="text-center"><?= $v->hsn_code ?></td>
                                                <td class="text-end"><?= $v->number_of_packs ?></td>
                                                <td class="text-end"><?= ($v->hsn_code == '') ? '' : $v->quantity ?></td>
                                                <td class="text-end"><?= ($v->hsn_code == '') ? '' : $v->unit_rate ?></td>
                                                <td class="text-end"><?= ($v->hsn_code == '') ? '' : $v->assessable_value ?></td>
                                                <td class="text-end"><?= ($v->hsn_code == '') ? '' : $v->assessable_value ?></td>
                                               
                                            </tr>
                                            <?php
                                            
                                        }
                                        ?>
                                        <?php
                                        if($invoice->level1_value != 0){ ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th colspan="2"><?=$invoice->level1_heading?></th>
                                                <td class="text-end"><?=$invoice->level1_value?></td>
                                            </tr>
                                        <?php    
                                        }
                                        if($invoice->level2_value != 0){ ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th colspan="2"><?=$invoice->level2_heading?></th>
                                                <td class="text-end"><?=$invoice->level2_value?></td>
                                            </tr>
                                        <?php    
                                        }
                                        ?>
                                         <tr class="add_row_space">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th class="text-center" colspan="2">Other Charges</th>
                                                <th class="text-end"><?php echo $invoice->other_charges_amount ?></th>
                                            </tr>
                                            <tr class="add_row_space">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th class="text-center" colspan="2">Discount</th>
                                                <th class="text-end"><?php echo $invoice->discount_amount ?></th>
                                            </tr>
                                            <tr class="add_row_space">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th class="text-center" colspan="2">Total Assessable Value</th>
                                                <th class="text-end"><?php echo number_format((float)round(($total+$invoice->level1_value+$invoice->level2_value+$invoice->other_charges_amount-$invoice->discount_amount)), 2, '.', '');?></th>
                                            </tr>
                            
                                        </tbody>
                                    </table>
                                </div>
                                
                                <?php
                                $total_assessable_value = round(($total+$invoice->level1_value+$invoice->level2_value+$invoice->other_charges_amount-$invoice->discount_amount));
                                $cgst = round($total_assessable_value*$invoice->cgst/100);
                                $sgst = round($total_assessable_value*$invoice->sgst/100);
                                $igst = round($total_assessable_value*$invoice->igst/100);
                         
                                ?>
                                
                                <?= view('invoice/print-component/tax_area',[
                                        'total_assessable_value' => $total_assessable_value,
                                        'cgst' => $cgst,
                                        'sgst' => $sgst,
                                        'igst' => $igst
                                    ]) ?>
                                
                                <?= view('invoice/print-component/footer') ?>
                                
                                <?= '<small class="d-block text-end">Page ' . $current_page . ' of '. $total_pages . '</small>' ?>
                                
                                <div class="row text-center"> <!--style="position: absolute;display: block;width: 90%;bottom: 25px;"-->
                                    <div class="col-12"><p class="fw-bold"><small>SUBJECT TO KOLKATA JURISDICTION</small></p></div>
                                    <div class="col-12"><p class="fw-bold"><small>This is a Computer Generated Invoice</small></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>      
                <?php
            }
        ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $(document).on('blur', "#add_last_row", function(){
                
                add_row_str = "<tr class='added_rows'><td>&nbsp;</td><td colspan='7'></td></tr>"
                row_nos = $("#add_last_row").val()
                
                $(".added_rows").remove()
                for(var i = 1; i <= row_nos; i++) {
                    $(add_row_str).insertBefore(".add_row_space") 
                };

            })
            
            // change font -size
            $("#font_size_plus").click(function(){
                cur_size = parseInt($('address').css('font-size'))
                new_size = cur_size+1
                $("address,th,td,p").css('font-size', new_size)
            })
            $("#font_size_minus").click(function(){
                cur_size = parseInt($('address').css('font-size'))
                new_size = cur_size-1
                $("address,th,td,p").css('font-size', new_size)
            })
        </script>
    </body>
    
</html>