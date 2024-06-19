<?php 
include "inc.php";

 $quotationId = $_REQUEST['quotationId'];
 $scheduleId = $_REQUEST['scheduleId'];
 $id = decode($_REQUEST['queryId']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>payment</title>
    <style>
          body{
        margin: 0px;
        padding:0px;
    }
        
    .agent-id{
        text-align: right;
    }
    .table-sec-area{
        margin-top: 40px;
    }
    .p-tbl{
        padding-right: 300px!important;
    }
    .term-cond h5{
        font-size: 12px;
        color: #5e5656;
        font-weight: bold;
        font-family: sans-serif;
    }
    .w-amo{
        font-size: 10px;
        font-weight: bold;
    }
    .table-sec-area{
        font-family: sans-serif;
    }
    .payment-text{
        font-size: 25px;
        font-family: sans-serif;
        font-weight: bold;
        margin-top: 20px;
    }
    .top-hader{
        width: 100%;
        display: block;
        background: center;
        background-size: cover;
        height: 150px;
    }
    h5{
        font-size: 1rem !important;
    }
    .sentreceipt{
        cursor: pointer;
        margin-right: 15px;
        padding: 1px 14px;
        font-size: 19px;
        border-radius: 3px;
    }
    .printreceipt{
        cursor: pointer;
        border:1px solid #ccc;
        padding: 3px 20px;
        font-size:12px;
        background-color:#000;
        color:#FFFFFF!important;
        border-radius: 2px;
        margin-right: 20px;
    }

    .otherdetail th{
        background-color: #f1f1f1;
        font-size: 12px;
        vertical-align: top;
    }
  
    
    </style>
</head>
<?php 
// Amount in words functions

// amound in words function end 


$res = GetPageRecord('*',_QUERY_MASTER_,'id="'.$id.'"');
$queryData = mysqli_fetch_assoc($res);
$queryId = $queryData['id'];


if($queryData['clientType']!='2'){
$select4='*';
$where4='id='.$queryData['companyId'].'';
$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4);
$resultCompany=mysqli_fetch_array($rs4);
$mobilemailtype='corporate';
}
if($queryData['clientType']=='2'){
$select4='*';
$where4='id='.$queryData['companyId'].'';
$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4);
$resultCompany=mysqli_fetch_array($rs4);
$mobilemailtype='contacts';
}

$wherest = 'id="'.$resultCompany['stateId'].'"';
$getstate = GetPageRecord('*','stateMaster',$wherest);
$stresult = mysqli_fetch_assoc($getstate);

$wherecot = 'id="'.$resultCompany['countryId'].'"';
$getcountry = GetPageRecord('*','countryMaster',$wherecot);
$ctresult = mysqli_fetch_assoc($getcountry);

$select4='*';  
    $where4='addressType="'.$mobilemailtype.'" and addressParent="'.$editresult['companyId'].'"'; 
    $rs4=GetPageRecord($select4,_ADDRESS_MASTER_,$where4); 
    $address=mysqli_fetch_array($rs4); 


$result = GetPageRecord('*','agentPaymentMaster','quotationId="'.$quotationId.'" and scheduleId="'.$scheduleId.'" ');
$scheduledData = mysqli_fetch_assoc($result);
$schduleId = $scheduledData['scheduleId'];

$ptype = GetPageRecord('*','paymentTypeMaster','id="'.$scheduledData['paymentBy'].'" and status=1');
$paymenttype = mysqli_fetch_assoc($ptype);


$respay = GetPageRecord('*','quotationMaster','id="'.$scheduledData['quotationId'].'" and status=1');
$agentPayment = mysqli_fetch_assoc($respay);
$finalCost = round($agentPayment['totalQuotCost']);
$currencyId = ($agentPayment['currencyId']>0)?$agentPayment['currencyId']:$baseCurrencyId;

$result = GetPageRecord('SUM(amount) as paidAmount','agentPaymentMaster','quotationId="'.$scheduledData['quotationId'].'"');
$paidPayment = mysqli_fetch_assoc($result);
$receivedAmount = $paidPayment['paidAmount'];

$pendingCost = $finalCost-$paidPayment['paidAmount'];

$logores = GetPageRecord('*','companySettingsMaster','proposalLogo!=""');
$reslogo = mysqli_fetch_assoc($logores);

?>
<body>

    <!-- payment sec mode  -->
    
    <div id="printArea">
        <div class="nav-sec">
            <div class="main-nav" style="margin: 10px;">
                <a><img class="top-hader" src="dirfiles/<?php echo $reslogo['proposalLogo']; ?>"></a>
            </div>
        </div>
        <div class="container">
            <table width="100%">
                <tr>
                    <td align="center" class="payment-text" style="font-size: 20px;"> PAYMENT RECEIPT </td>
                </tr>
            </table>


            <!-- repceipt no. date area -->
            <br>
            <div class="row">
                <div class="col-12 r-no-date" style="text-align: right;">
                    <h3 style="font-size: 18px;font-weight: normal;" class="receitpdatNo">Receipt No. : <?php echo makeReceiptNo($schduleId); ?></h3>
                    <h3 style="font-size: 18px;font-weight: normal;" class="receitpdatNo">Receipt Date: <?php echo date('d-m-Y',strtotime($scheduledData['receiptDate']));?></h3><br>
                </div>
                <!-- <div class="col-6"></div> -->
            </div>
            <div class="row" >
                <div class="col-12 thanks">
                    <h3 style="font-size: 20px; font-weight:normal;" class="receitpdatNo" id="receitpdatNo1">Dear Sir/Madam</h3>
                    <h3 style="font-size: 20px; font-weight:normal;" class="thanknote ">Thank you for your payment against &nbsp; Tour ID : <?php echo makeQueryTourId($queryData['id']); ?></h3>
                </div>
            </div>


            <!-- table agents client sec started-->
            <div class="table-sec-area">            
                <table width="100%" cellpadding="5" cellspacing="0" border="0px" bordercolor="#ccc" class="tablecontent" style=" border: 1px solid black; border-collapse: collapse;">
                    <thead style=" border: 1px solid black; border-collapse: collapse;">
                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                            <th align="left" style="font-weight: 700;border-right: 0px solid #dee2e6; border: 1px solid black; border-collapse: collapse;">Name </th>
                            <th colspan="3" align="left" style="font-weight: normal;border-right: 0px solid #dee2e6;border: 1px solid black; border-collapse: collapse;" class="p-tbl"><?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                        <td align="left" style="font-weight: 700;border-right: 0px solid #dee2e6;border: 1px solid black; border-collapse: collapse;">Address</td>
                        <td colspan="3" align="left" ><?php echo $resultCompany['address1'].' '.$resultCompany['pinCode'].', ' ; ?><?php if($stresult['name']!=''){ echo $stresult['name'].', '.' '; } ?> <?php echo $ctresult['name']; ?></td>
                        
                    </tr>
                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                        <td colspan="1" style="font-weight: 700;border-right: 0px solid #dee2e6;border: 1px solid black; border-collapse: collapse;">Amount</td>
                        <td colspan="3" style=" border: 1px solid black; border-collapse: collapse;"><?php echo getCurrencyName($currencyId) ?>  <?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$scheduledData['amount']); ?> </td>
                        
                        
                        </td>
                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                        <td colspan="1" style="font-weight: 700;border: 1px solid black; border-collapse: collapse;"> Amount in Words</td>
                        <td colspan="3" style=" border: 1px solid black; border-collapse: collapse;"> <?php echo getCurrencyName($currencyId); ?>
                                
                            <!-- <?php echo round(convertNumberToWordsForIndia($scheduledData['amount'])); ?>  -->
                            <?php echo convertNumberToWordsForIndia(round(getChangeCurrencyValue_New($currencyId,$quotationId,$scheduledData['amount']))); ?>
                    </tr >
                        
                    </tr>
                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                        <td colspan="1" style="font-weight: 700;border-right: 0px solid #dee2e6; border: 1px solid black; border-collapse: collapse;">Payment Mode</td>
                        <td colspan="1"  style=" border: 1px solid black; border-collapse: collapse;"><?php echo $paymenttype['name']; ?></td>

                        <td colspan="1" style="font-weight: 700;border-right: 0px solid #dee2e6;border: 1px solid black; border-collapse: collapse;">Transaction ID/Cheque No. </td>
                        <td colspan="1" style=" border: 1px solid black; border-collapse: collapse;"><?php echo $scheduledData['chequeNo']; ?></td>
                        
                        
                    </tr>
                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                       <td colspan="1" style="font-weight: 700; border-right: 0px solid #dee2e6; border: 1px solid black; border-collapse: collapse;">Bank Name</td>
                        <td colspan="1" style=" border: 1px solid black; border-collapse: collapse;">
                        
                        <!-- <?php echo $scheduledData['bankName']; ?> -->
                        <?php 
                            if($scheduledData['bankName']!=''){
                            echo $scheduledData['bankName'];
                            }else{
                                $rsMkt2=GetPageRecord('bankName','bankMaster',' id="'.$scheduledData['bankId'].'"');
                                $resMarkt2=mysqli_fetch_array($rsMkt2);
                                echo $resMarkt2['bankName'];
                            }
                        ?>
                        </td>

                        <td colspan="1" style="font-weight: 700; border-right: 0px solid #dee2e6;border: 1px solid black; border-collapse: collapse;">Payment Date</td>
                        <td colspan="1" ><?php echo date('d-m-Y',strtotime($scheduledData['receiptDate']));?></td>
                        
                    </tr>

                    <tr style=" border: 1px solid black; border-collapse: collapse;">
                        <td style="font-weight: 700;border-right: 0px solid #dee2e6; border: 1px solid black; border-collapse: collapse;">Remarks</td>
                        <td colspan="3" style=" border: 1px solid black; border-collapse: collapse;"><?php echo $scheduledData['remark']; ?></td>
                        
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- table agents client sec end -->
            <br>
            <br>
            <h3 class="paymentinfohh receitpdatNo" style="font-weight: normal;border-right: 2px solid #dee2e6;font-size: 20px;">Payment Information</h3>
            <table width="100%" border="1" bordercolor="#ccc" cellpadding="5" cellspacing="0" class="tablecontent">
                <thead>
                <tr>
                        <th style="text-align: center;">TOTAL AMOUNT (<?php echo getCurrencyName($currencyId) ?>)</th>
                        <th style="text-align: center;">RECEIVED AMOUNT (<?php echo getCurrencyName($currencyId) ?>)</th>
                        <th style="text-align: center;">PENDING AMOUNT (<?php echo getCurrencyName($currencyId) ?>)</th>
                </tr>
                </thead>


                <tbody>
                <tr>
                <td style="text-align: center; border-right: 2px solid #dee2e6;"><?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$finalCost); ?></td>
                <td style=" text-align: center; border-right: 2px solid #dee2e6;"><?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$receivedAmount); ?></td>
                    <td style=" text-align: center; border-right: 2px solid #dee2e6;"><?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$pendingCost); ?></td>
                </tr>
                
                
                </tbody>
            </table>
<br><br>
<h3 class="paymentinfohh receitpdatNo" style="font-weight: normal;border-right: 2px solid #dee2e6;font-size: 20px;">Last Payment Information</h3>
            <table width="100%" border="1" bordercolor="#ccc" cellpadding="5" cellspacing="0" class="tablecontent">
                <tbody>
                <thead>
                <tr class="otherdetail">
                        <th  style="border-right: 2px solid #dee2e6;">PAYMENT DATE</th>
                        <th  style="border-right: 2px solid #dee2e6;">PAYMENT MODE</th>
                        <th  style="border-right: 2px solid #dee2e6;">TRANSACTION ID / CHEQUE NO.</th>
                        <th  style="border-right: 2px solid #dee2e6;">BANK NAME</th>
                        <th  style="border-right: 2px solid #dee2e6;">AMOUNT (IN INR)</th>
                        <th  style="border-right: 2px solid #dee2e6;">REMARKS</th>
                </tr>
                </thead>
                <?php 
                 $res1 = GetPageRecord('*','agentPaymentMaster','quotationId="'.$quotationId.'" and id!="'.$scheduledData['id'].'"');
                 while($prepay = mysqli_fetch_assoc($res1)){
                
                ?>
                <tr>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['receiptDate']; ?></td>
                    <?php 
                            $rsMkt2=GetPageRecord('name','paymentTypeMaster',' id="'.$prepay['paymentBy'].'"');
                            $resMarkts2=mysqli_fetch_array($rsMkt2);
                            // echo$resMarkt2['name'];  
                        ?>   
                        
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;">
                    <?php echo $resMarkts2['name']; ?>
                    </td>  
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['chequeNo']; ?></td>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;">
                    <!-- <?php echo $prepay['bankName']; ?> -->
                    <?php 
                            if($prepay['bankName']!=''){
                            echo $prepay['bankName'];
                            }else{
                                $rsMkt2=GetPageRecord('bankName','bankMaster',' id="'.$prepay['bankId'].'"');
                                $resMarkt2=mysqli_fetch_array($rsMkt2);
                                echo $resMarkt2['bankName'];
                            }
                    ?>
                </td>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['amount']; ?></td>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['remark']; ?></td>
                </tr>
                <?php } ?>
            
                </tbody>
            </table>

            <div class="row" style="margin-top: 80px;" >
                <div class="col-9 term-cond01">
                        <h5 style="" class="terc ">Terms & Conditions:</h5><br>
                        <h6 style="font-size: 13px;" class="termtext">1. &nbsp;&nbsp;&nbsp; All terms & conditions of proposal/Purchase Order are applicable.</h6>
                        <h6 style="font-size: 13px;" class="termtext">2. &nbsp;&nbsp;&nbsp; Payment by cheque will be valid subject to realisation of the cheque.<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;It is system generated document and does not need any signature or stamp.   
                </h6>
                </div>

                <div class="col-3 signature001" style="text-align: right;margin-top: 40px;">
                    <h3 style="font-size: 15px;font-weight: bold;" class="authsig">For <?php echo $reslogo['companyName']; ?></h3>
                    <h4 style="font-size: 16px;" class="authsig">Authorise Signature</h4>
                </div>

            </div>
        </div>
        <style>
      /* @media print{
        body{
            font-size: 14px !important ;
        }
        h5{
        font-size: 1rem !important;
    }
    .payment-text{
        font-size: 30px !important;
        font-family: sans-serif !important;
        font-weight: bold !important;
        margin-top: 20px !important;
    }
    .receitpdatNo{
        font-size: 30px !important;
    }
    .thanknote{
        font-size: 30px !important;
        font-weight: 100 !important;
        margin-bottom: 30px !important;
    }
    .tablecontent tr th{
        font-size: 25px !important;
    }
    .tablecontent tr td{
        font-size: 25px !important;
    }
    .wordamount{
        font-size: 20px;
    }
    .terc{
        font-size: 30px !important;
    }
    .termtext{
        font-size: 20px !important;
        font-weight: 100 !important;
    }
    .authsig{
        font-size: 30px !important;
 
    }
} */
        </style>
        </div>
    </section>

</body>

</html>
