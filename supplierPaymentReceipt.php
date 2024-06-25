<?php 
include "inc.php";

    $quotationId = $_REQUEST['quotationId'];
    $scheduleId = $_REQUEST['scheduleId'];

    $scheduleSuppId = $_REQUEST['scheduleSuppId'];
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
            font-size: 22px;
            font-family: sans-serif;
            font-weight: bold;
            margin-top: 20px;
        }
        .top-hader{
            width: 790px;
            display: block;
            background: center;
            background-size: cover;
            height: 100px;
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
        .main-nav{
            margin: 10px;
        }
        .main-sec{
            margin:10px 20px;
        }
    
    </style>
</head>
<?php 

    $fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$_REQUEST['quotationId'].'" and id="'.$_REQUEST['scheduleSuppId'].'" ');
    $supplierStatusData=mysqli_fetch_array($fianlSuppQuery);

    // scheduletalbe
    $totalCost = $supplierStatusData['totalSupplierCost'];
    $quotationId = $supplierStatusData['quotationId'];

    $r2='';
    $r2=GetPageRecord('sum(amount) as totalAmount','supplierSchedulePaymentMaster','supplierStatusId="'.$supplierStatusData['id'].'" and amount!="" and value!="" and paymentStatus=1'); 
    $schedulePaymentData = mysqli_fetch_array($r2);
    $paidAMT = $schedulePaymentData['totalAmount'];
    $remainAmount = $totalCost-$paidAMT;	


    $ressSu = GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierStatusData['supplierId'].'"');
    $suppDataSuplier = mysqli_fetch_assoc($ressSu);
    $SupplerName = $suppDataSuplier['name'];
    $destinationId = $suppDataSuplier['destinationId'];


    $ressA = GetPageRecord('*','supplierPaymentMaster','id="'.$_REQUEST['scheduleId'].'"');
    $suppDataAmuD = mysqli_fetch_assoc($ressA);
    $paymentBy = $suppDataAmuD['paymentBy'];
    $remark= $suppDataAmuD['remark'];
    $paymentDate= $suppDataAmuD['paymentDate'];
    $paidBy= $suppDataAmuD['paidBy'];
    $Reciamount= $suppDataAmuD['amount'];
    $bankId= $suppDataAmuD['bankId'];


    $ressBankR = GetPageRecord('*','bankMaster','id="'.$bankId.'"');
    $suppBankD = mysqli_fetch_assoc($ressBankR);
    $bankName = $suppBankD['bankName'];

    $pendingAmount = $totalSupplierQuotCost- $Reciamount;
    $res = GetPageRecord('*',_QUERY_MASTER_,'id="'.$_REQUEST['queryId'].'"');
    $queryData = mysqli_fetch_assoc($res);
    $queryId = $queryData['id'];
// die("nb");

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

        $logores = GetPageRecord('*','companySettingsMaster','proposalLogo!=""');
        $reslogo = mysqli_fetch_assoc($logores);


?>
<body>

    <!-- payment sec mode  -->
    <div style="padding-top: 2px;"><h4 style="background-color: #233A49;padding: 6px;color: #fff;margin: 5px;border-radius: 5px;margin-top: 6px; font-size:17px;">PAYMENT RECEIPT <span onclick="receiptalertClose();" style="text-align:center; width: 20px;float: right;cursor: pointer;">X</span></h4></div>
    <section class="main-sec" style="margin-bottom: 50px; border:1px dashed #ccc;">
    <div id="printArea">
       
        <div class="nav-sec" style="display:none;">
            <div class="main-nav">
                <a><img class="top-hader" src="dirfiles/<?php echo $reslogo['proposalLogo']; ?>"></a>
            </div>
        </div>
        <div class="main-div001">
        <div class="container">
            <table width="100%">
                <tr>
                    <td align="center" class="payment-text">Payment Transfer Letter </td>
                </tr>
            </table>


            <!-- repceipt no. date area -->
            <div class="row" style="display:none;">
                <div class="col-12 r-no-date" style="text-align: right;">
                    <h3 style="font-size: 20px; font-weight:normal;" class="receitpdatNo">Receipt No. : <?php echo makeReceiptNo($schduleId);  ?></h3>
                    <h3 style="font-size: 20px; font-weight:normal;" class="receitpdatNo">Receipt Date: <?php echo date('d-m-Y',strtotime($scheduledData['receiptDate']));?></h3><br>
                </div>
                <!-- <div class="col-6"></div> -->
            </div>
            <div class="row" >
                <div class="col-12 thanks">
                    <h3 style="font-size: 20px; font-weight:normal;" class="receitpdatNo" id="receitpdatNo1">Dear Sir/Madam</h3><br>
                    <h3 style="font-size: 20px; font-weight:normal;" class="thanknote ">We have made the following payment against &nbsp; Tour ID : <?php echo makeQueryTourId($queryData['id']); ?></h3>
                </div>
            </div>

            <!-- table agents client sec started-->
            <div class="table-sec-area">            
                <table width="100%" cellpadding="5" cellspacing="0" border="1px" bordercolor="#ccc" class="tablecontent">
                    <thead>
                    <tr>
                        <th align="left" style="font-weight: 700;border-right: 2px solid #dee2e6;">Name </th>
                        <th colspan="3" align="left" style="font-weight: normal;border-right: 2px solid #dee2e6;" class="p-tbl"><?php echo $SupplerName; ?></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" style="font-weight: 700;border-right: 2px solid #dee2e6;">Address</td>
                        <td colspan="3" align="left" ><?php echo getDestination($destinationId); ?></td>
                        
                    </tr>
                    <tr>
                        <td colspan="1"style="font-weight: 700;border-right: 2px solid #dee2e6;">Amount</td>
                        <td colspan="3">INR  <?php echo $totalCost; ?> </td>
                    <tr>
                    <td colspan="1" style="font-weight: 700;"> Amount in Words</td>
                    <td colspan="3"> INR  
                            <!-- <?php echo round(convertNumberToWordsForIndia($totalSupplierQuotCost)); ?>  -->
                            <?php echo convertNumberToWordsForIndia(round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalCost))); ?>
                    </td>
                    </tr> 
                    </tr>
                    <tr>
                        <td colspan="1" style="font-weight: 700;border-right: 2px solid #dee2e6;">Payment Mode</td>
                        <td colspan="1"  ><?php echo $paymentBy; ?></td>

                        <td colspan="1" style="font-weight: 700;border-right: 2px solid #dee2e6;">Transaction ID/Cheque No. </td>
                        <td colspan="1"><?php echo $paidBy; ?></td> 
                    </tr>
                    <tr>
                       <td colspan="1" style="font-weight: 700; border-right: 2px solid #dee2e6;">Bank Name</td>
                        <td colspan="1" ><?php echo $bankName; ?></td>

                        <td colspan="1" style="font-weight: 700; border-right: 2px solid #dee2e6;">Payment Date</td>
                        <td colspan="1" ><?php echo date('d-m-Y',strtotime($paymentDate));?></td>
                        
                    </tr>

                    <tr>
                        <td style="font-weight: 700;border-right: 2px solid #dee2e6;">Remarks</td>
                        <td colspan="3"><?php echo $remark; ?></td> 
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
                    <th style="text-align: center;">TOTAL AMOUNT (<?php echo getCurrencyName($baseCurrencyId); ?>)</th>
                    <th style="text-align: center;">RECEIVED AMOUNT (<?php echo getCurrencyName($baseCurrencyId); ?>)</th>
                    <th style="text-align: center;">PENDING AMOUNT (<?php echo getCurrencyName($baseCurrencyId); ?>)</th>
                </tr>
                </thead>


                <tbody>
                <tr>
                <td style="text-align: center;border-right: 2px solid #dee2e6;"><?php echo round($totalCost); ?></td>
                <td style=" text-align: center;border-right: 2px solid #dee2e6;"><?php echo round($paidAMT); ?></td>
                <td style=" text-align: center;border-right: 2px solid #dee2e6;"><?php echo round($remainAmount); ?></td>
                </tr>
                <!-- <tr>$totalCost-$paidAMT
                    <td colspan="3" style="font-weight: bold;border-right: 2px solid #dee2e6;">Last Payment Information</td>
                </tr> -->
                
                </tbody>
            </table>

            <br>
            <br>
            <h3 class="paymentinfohh receitpdatNo" style="font-weight: normal;border-right: 2px solid #dee2e6;font-size: 20px;display:none">Last Payment Information</h3>
            <table width="100%" border="1" bordercolor="#ccc" cellpadding="5" cellspacing="0" class="tablecontent" style="display:none">
                <tbody>
                <thead>
                <tr class="otherdetail" id="ttte01">
                    <th  style="border-right: 2px solid #dee2e6;">PAYMENT DATE</th>
                    <th  style="border-right: 2px solid #dee2e6;">PAYMENT MODE</th>
                    <th  style="border-right: 2px solid #dee2e6;">TRANSACTION ID / CHEQUE NO.</th>
                    <th  style="border-right: 2px solid #dee2e6;">BANK NAME</th>
                    <th  style="border-right: 2px solid #dee2e6;">AMOUNT (IN <?php echo getCurrencyName($baseCurrencyId); ?>)</th>
                    <th  style="border-right: 2px solid #dee2e6;">REMARKS</th>
                </tr>
                </thead>
                <?php 
                 $res1 = GetPageRecord('*','agentPaymentMaster','quotationId="'.$quotationId.'" and id!="'.$scheduledData['id'].'"');
                 while($prepay = mysqli_fetch_assoc($res1)){
                
                ?>
                <tr>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo date('d-m-Y',strtotime($prepay['receiptDate'])) ?></td>
                    


                    <?php 
                            $rsMkt2=GetPageRecord('name','paymentTypeMaster',' id="'.$prepay['paymentBy'].'"');
                            $resMarkts2=mysqli_fetch_array($rsMkt2);
                            // echo$resMarkt2['name'];  
                        ?>   
                        
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;">
                    <?php echo $resMarkts2['name']; ?>
                    </td>   


                    
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['chequeNo']; ?></td>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['bankName']; ?></td>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['amount']; ?></td>
                    <td style="font-weight: normal;border-right: 2px solid #dee2e6;"><?php echo $prepay['remark']; ?></td>
                </tr>
                <?php } ?>
            
                </tbody>
            </table>

            <div class="row" style="margin-top: 80px;" >
                <div class="col-8 term-cond01">
                    <h5 style="" class="terc ">Terms & Conditions:</h5><br>
                    <h6 style="font-size: 13px;" class="termtext">1. &nbsp;&nbsp;&nbsp; All terms & conditions of proposal/Purchase Order are applicable.</h6>
                    <h6 style="font-size: 13px;" class="termtext">2. &nbsp;&nbsp;&nbsp; Payment by cheque will be valid subject to realisation of the cheque.<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;It is system generated document and does not need any signature or stamp.   
                </h6>
                </div>

                <div class="col-4 signature001" style="text-align: right;">
                    <h3 style="font-size: 15px;font-weight: bold;" class="authsig">For <?php echo $reslogo['companyName']; ?></h3>
                    <h4 style="font-size: 16px;" class="authsig">Authorise Signature</h4>
                </div>

            </div>
        </div>
        </div>
        <style>
      @media print{

       
        
        body{
            font-size: 14px !important ;
        }
        h5{
            font-size: 1rem !important;
        }
        .main-div001{
            padding: 30px 20px 20px 20px!important;
        }
        .nav-sec{
            padding: 30px 40px 0px 20px!important;
        }

    .payment-text{
        font-size: 20px !important;
        font-family: sans-serif !important;
        font-weight: bold !important;
        margin-top: 20px !important;
    }
    .receitpdatNo{
        font-size: 18px !important;
    }

    #receitpdatNo1{
        font-size: 18px !important;
    }
    .thanknote{
        font-size: 20px !important;
        font-weight: 100 !important;
        margin-bottom: 30px !important;
    }
    .tablecontent tr th{
        font-size: 16px !important;
    }

    #ttte01 th{
        font-size: 14px !important;
    }
    .tablecontent tr td{
        font-size: 16px !important;
    }
    .wordamount{
        font-size: 20px;
    }
    .terc{
        font-size: 18px !important;
    }
    .termtext{
        font-size: 16px !important;
        font-weight: 100 !important;
    }
    .authsig{
        font-size: 18px !important;
 
    }
    .main-nav{
        margin: 0px !important;
    }

    .top-hader{
        width: 790px!important;
        display: block;
        background: center;
        background-size: cover;
        height: 100px!important;
    }

    /* .paymentinfohh{
            font-weight: normal !important;
            border-right: 2px solid #dee2e6 !important;
            font-size: 22px !important;
    } */
    .signature001{
        position: relative!important;
        top: 100px!important;
    }

    
   
}
@page{
    size: auto;  

    margin: 0 15px ;
}

        </style>
        </div>
    </section>
    

        <table width="100%" style="display:none1;">
                    <tr>
                    
                        <td align="right" style="padding-bottom: 20px;">
                        <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&scheduleId=<?php echo $scheduleId; ?>&scheduleSuppId=<?php echo $scheduleSuppId; ?>&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>" target="_blank" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>
                            <input type="button" class="printreceipt" value="Print" onclick="printReceipt('printArea');">
                        </td>
                    </tr>
        </table>

<script>

function printReceipt(divName) { 
	    var printContents = document.getElementById(divName).innerHTML;
	    var originalContents = document.body.innerHTML;
	    document.body.innerHTML = printContents;
	    window.print();
	    document.body.innerHTML = originalContents;
	    // parent.location.reload();
	    return false;
	}
</script>


</body>

</html>