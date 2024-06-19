<?php 

include "inc.php";



$queryId = decode($_REQUEST['queryId']);

$quotationId = decode($_REQUEST['quotationId']);

$scheduleId = decode($_REQUEST['scheduleId']);


$res = GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"');

$queryData = mysqli_fetch_assoc($res);



$res11 = GetPageRecord('proposalLogo','companySettingsMaster','proposalLogo!=""');

$logores = mysqli_fetch_array($res11);

$respayment11 = GetPageRecord('*','agentSchedulePaymentMaster','id="'.$scheduleId.'"');

$paymentData = mysqli_fetch_assoc($respayment11);

$generatedDate = date('d-m-Y',strtotime($paymentData['dueDate']));

$resbank1 = GetPageRecord('*','bankMaster','setDefault=1');

$bankData = mysqli_fetch_assoc($resbank1);

if($queryData['clientType']=='1'){

    $select4='*';

    $where4='id='.$queryData['companyId'].'';

    $rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4);

    $contantnamemain=mysqli_fetch_array($rs4);

    $mobilemailtype='corporate';



    $clientnem = getCorporateCompany($contantnamemain['id']);

	$getemail = getPrimaryEmailCompany($contantnamemain['id'],"corporate");

	$getphone = getPrimaryPhoneCompany($contantnamemain['id'],"corporate");

    }



    if($queryData['clientType']=='2'){

    $select4='*';

    $where4='id='.$queryData['companyId'].'';

    $rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4);

    $contantnamemain=mysqli_fetch_array($rs4);

    $mobilemailtype='contacts';



    $clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];

	$getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');

	$getemail =  getPrimaryEmail($contantnamemain['id'],'contacts'); 

    }



   $agentName = showClientTypeUserName($queryData['clientType'],$queryData['companyId']); 

  

?>

<div id="main-container">

  <table width="100%" cellpadding="0" cellspacing="0">

    <tr>

        <td>

            <img src="dirfiles/<?php echo $logores['proposalLogo']; ?>" width="" height="90">

        </td>

    </tr>

  </table>

  <div><h2 style="text-align: center; padding:20px;">PAYMENT REQUEST</h2></div>

  <div id="subcontainer">

        <div><p style="font-size: 15px; font-weight:500;"> Generated Date: &nbsp;&nbsp;<?php echo $generatedDate; ?></p></div>

        <div >

        <p style="font-size:13px;">Dear Sir/Madam</p>

        <p style="font-size:13px;">I hope this email finds you well.  We would like to share a friendly reminder that the payment against below mentioned tour Id. </p>

        </div>

        <br><br>

        <table width="100%" cellpadding="10" cellspacing="0" border="1" class="table table-striped">

                <thead>

                 <tr style="background-color: #ccc;">

                 <th align="center" style="font-size: 14px;">Tour Id</th>

                    <th align="center" style="font-size: 14px;">Tour Date</th>

                    <th align="center" style="font-size: 14px;">Amount</th>

                    <th align="center" style="font-size: 14px;">Link</th>

                 </tr>

                </thead>

                <tbody>

                   <tr>

                   <td align="center" style="font-size: 14px;">

                        <?php echo makeQueryTourId($queryData['id']); ?>

                    </td>

                    <td align="center" style="font-size: 14px;">

                        <?php echo date('d-m-Y', strtotime($queryData['fromDate'])); ?>

                    </td>

                    <td align="center" style="font-size: 14px;">

                        <?php echo round($paymentData['amount']); ?>

                    </td>

                    <td align="center" style="font-size: 14px;">

                        <a href="<?php echo $fullurl; ?>checkout/start.php?quotationId=<?php echo encode($quotationId); ?>&paymentscheduleId=<?php echo encode($scheduleId); ?>&name=<?php echo encode($clientnem); ?>&email=<?php echo encode($getemail); ?>&mobile=<?php echo encode($getphone); ?>&queryId=<?php echo encode($queryId); ?>&amount=<?php echo encode(round($paymentData['amount'])); ?>"><input type="button" value="Pay&nbsp;Now" style="background-color: #4CAF50 !important;color:#ffffff; border:1px solid #ccc; cursor:pointer; padding:5px 20px;"></a>





                    </td>

                   </tr>

                </tbody>

        </table>

        <br><br><br>

        <table width="100%" cellpadding="5" cellspacing="0" border="1" class="table table-striped">

                <thead>

                 <tr style="background-color: #ccc; ">

                 <th align="right">Bank Name</th>

                    <th align="center" style=" padding:10px 5px;">Account Type</th>

                    <th align="center" style=" padding:10px 5px;">Beneficiary Name</th>

                    <th align="center" style=" padding:10px 5px;">Account Number</th>

                    <th align="center" style=" padding:10px 5px;">IFSC Code</th>

                    <th align="center" style=" padding:10px 5px;">Branch Swift Code</th>

                    <th align="center" style=" padding:10px 5px;">Branch Address</th>

                 </tr>

                </thead>

                <tbody>

                   <tr>

                   <td align="center"><?php echo $bankData['bankName']; ?> </td>

                    <td align="center"><?php echo $bankData['accountType']; ?></td>

                    <td align="center"> <?php echo $bankData['beneficiaryName']; ?></td>

                    <td align="center"><?php echo $bankData['accountNumber']; ?></td>

                    <td align="center"><?php echo $bankData['branchIFSC']; ?></td>

                    <td align="center"><?php echo $bankData['branchSwiftCode']; ?></td>

                    <td align="center"><?php echo $bankData['branchAddress']; ?></td>

                   </tr>

                </tbody>

        </table>

        <br><br>



        <div style="padding-top: 20px; padding-bottom:20px;">

            <p style="font-size:13px;">Please ignore, if you have already made the payment.</p>

            <br>

            <p style="font-size:13px;">Please feel free to reach out with any questions about this invoice.</p>

            <br>

            <p style="font-size:13px;">Thank you in advance.</p>

        </div>

  </div>
</div>





