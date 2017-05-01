<!DOCTYPE html>
<html>
<head>
    <title>Print Invoice</title>
    <style>
        *
        {
            margin:0;
            padding:0;
            font-family:Arial;
            font-size:10pt;
            color:#000;
        }
        body
        {
            width:100%;
            font-family:Arial;
            font-size:10pt;
            margin:0;
            padding:0;
        }
         
        p
        {
            margin:0;
            padding:0;
        }
         
        #wrapper
        {
            width:180mm;
            margin:0 15mm;
        }
         
        .page
        {
            height:297mm;
            width:210mm;
            page-break-after:always;
        }
 
        table
        {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
            border-spacing:0;
            border-collapse: collapse;        
        }
         
        table td 
        {
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 2mm;
        }
         
        table.heading
        {
            height:50mm;
        }
         
        h1.heading
        {
            font-size:14pt;
            color:#000;
            font-weight:normal;
        }
         
        h2.heading
        {
            font-size:9pt;
            color:#000;
            font-weight:normal;
        }
         
        hr
        {
            color:#ccc;
            background:#ccc;
        }
         
        #invoice_body
        {
            height: 149mm;
        }
         
        #invoice_body
        {   
            width:100%;
        }
        #invoice_body table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
            border-spacing:0;
            border-collapse: collapse; 
            margin-top:5mm;
        } 
    </style>
</head>
<body>
<div id="wrapper">
    <p style="text-align:center; font-weight:bold; padding-top:5mm;">INVOICE</p>
    <br/>
    <table class="heading" style="width:100%;">
        <tr>
            <td style="width:80mm;">
                <h1 class="heading"><?=config('site_name')?></h1>
                <h2 class="heading">
                   <?=config('contact_address')?><br/> 
                    E-mail : <?=config('contact_email')?><br />
                    <?php if(config('phone') != ''){
                        echo "Phone : ".config('phone');  
                    } ?>
                </h2>
            </td>
            <td rowspan="2" valign="top" align="right" style="padding:3mm;">
                <table>
                    <tr>
                        <td>Date : </td>
                        <td><?=date("m-d-y",strtotime($transaction_detail['created_at']))?></td>
                    </tr>
                    <tr>
                        <td>Payment Type : </td><td>
                        <?php if($transaction_detail['payment_type'] == 0) {
                            echo "Paypal";
                        }else{
                            echo "Manual";
                        }?>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction No : </td>
                        <td>
                            <?php if($transaction_detail['payment_type'] == 0) {
                                echo $transaction_detail['paypal_token'];
                            }else{
                                echo "-";
                            }?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <b>Buyer</b> :<br />
                <?=$transaction_detail['user_name']?><br />
                <?=$transaction_detail['street']?>
                <br />
                <?=$transaction_detail['city']?> - <?=$transaction_detail['zipcode']?> , <?=$transaction_detail['country_name']?><br />
            </td>
        </tr>
    </table>
         
         
    <div id="content">
        <div id="invoice_body">
            <table>
                <tr style="background:#eee;">
                    <td style="width:8%;"><b>No.</b></td>
                    <td><b>Request Title</b></td>
                    <!-- <td style="width:15%;"><b>Quantity</b></td>
                    <td style="width:15%;"><b>Rate</b></td> -->
                    <td style="width:15%;"><b>Total</b></td>
                </tr>
            </table>
             
            <table>
            <tr>
                <td style="width:8%;">1</td>
                <td style="text-align:left; padding-left:10px;"><?=$transaction_detail['rfp_title']?></td>
                <!-- <td class="mono" style="width:15%;">1</td><td style="width:15%;" class="mono">157.00</td> -->
                <td style="width:15%;" class="mono"><?=number_format($transaction_detail['payable_price'],2)?></td>
            </tr>         
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
             
            <tr>
                <td></td>
                <td>Total :</td>
                <td class="mono"><?=number_format($transaction_detail['payable_price'],2)?></td>
            </tr>
        </table>
        </div>
    </div>
          
    </div>
          
</body>
</html>
