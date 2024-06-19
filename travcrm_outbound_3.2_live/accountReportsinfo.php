<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>





<?php


ob_start();
include "inc.php"; 
include "config/logincheck.php";

?>

<?php if($_REQUEST['sr'] == '15'){ 
  
  ?>
<h3 class="cms_title">Proforma Invoice Register</h3> 
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}

</style>


<div style="padding: 0px 20px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(1);">Last 15 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(2);">Last 30 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(3);">Last 3 Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(4);">Last 6 Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(5);">Last 12 Month</td>
    </tr>
</table>
</div>

                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalQuery">0</div>
                    <div class="text">Total Query </div>
                    
                </div> 
            
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalPaid">0</div>
                    <div class="text">Total Amount </div>
            </div>
             
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalPayment">0</div>
                    <div class="text">Total Amount In INR</div>
            </div>
             
            <form method="get">



<input name="module" id="module" type="hidden" value="accounts">



<input name="sr" id="" type="hidden" value="15">

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



  <table width="100%" border="0" cellpadding="10" cellspacing="0">



    <tbody><tr>



      <td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



          <tbody><tr>



            <!-- <td width="629" align="center">&nbsp;</td> -->



            <td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



                <tbody><tr>

            <!-- <td width="629" align="center" >&nbsp;</td> -->
              
              <td style="padding:0px 0px 0px 5px;">
              <label for="">From Date:</label>
              <input name="fromDate" type="text" readonly=""  class="topsearchfiledmain" id="datepicker1" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php echo date('Y-m-d', strtotime($_REQUEST['fromDate'])); ?>" size="100" maxlength="100" placeholder="To Date"/>

              <label for="">To Date:</label>
              <input name="toDate" type="text" readonly=""  class="topsearchfiledmain" id="datepicker2" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php echo date('Y-m-d', strtotime($_REQUEST['toDate'])); ?>" size="100" maxlength="100" placeholder="To Date"/>
                            <!-- <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:100px; padding: 9px; "> -->
                <!-- <option value="">All Users</option> -->
              <?php 
                // $userQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' status=1 and name!="" ');
              
                // while($userAry=mysqli_fetch_array($userQuery))
                // {
                //   if(isset($_REQUEST['assignto']) && $_REQUEST['assignto']==$userAry['id'])
                //     echo "<option value='".$_REQUEST['assignto']."' selected>".$userAry['name'].' '.$userAry['id']."</option>";
                //   else
                //     echo "<option value='".$userAry['id']."'>".$userAry['name']."</option>";
                // }
                // echo "<option value='".$_REQUEST['assignto']."' selected>".$userAry['name'].' '.$userAry['id']."</option>";
              ?>
              
                <!-- <option value="37">Administrator CRM</option>
                <option value="131">Akash Sharma</option>
                <option value="134">Akash Pandit </option>
                <option value="130">DeBox Global</option>
                <option value="133">Dinesh Khari</option>
                <option value="129">Good Sales Ali</option>
                <option value="109">Mohd Adnan</option>
                <option value="135">Praveen Sharma</option>
                <option value="121">Samaydin khan</option>
                <option value="128">Sumair S</option>
                <option value="127">Sumair A</option> -->
              <!-- </select> -->
              <!-- <select name="country" id="country" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All country</option>
              <?php 
                // $countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,' deletestatus=0 ');
                
                // while($country=mysqli_fetch_array($countryQuery))
                // {
                //   if(isset($_REQUEST['country']) && $_REQUEST['country']==$country['id'])
                //   echo "<option value='".$country['id']."' selected>".$country['name']."</option>";
                //   else
                //   echo "<option value='".$country['id']."'>".$country['name']."</option>";

                // }
              ?>
              </select>  -->
              <!-- <select name="client" id="client" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All Client</option>
              <?php 
                // $clientQuery=GetPageRecord('id,leadPaxName',_QUERY_MASTER_,' leadPaxName!="" group by leadPaxName ');
                
                // while($client=mysqli_fetch_array($clientQuery))
                // {
                //   if(isset($_REQUEST['client']) && $_REQUEST['client']==$client['leadPaxName'])
                //   echo "<option value='".$client['leadPaxName']."' selected >".$client['leadPaxName']."</option>";
                //   else
                //   echo "<option value='".$client['leadPaxName']."'>".$client['leadPaxName']."</option>";
                // }
              ?>
              </select> -->
              <input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;"> 
              
            </td>

            <td style="padding:0px 0px 0px 5px;"></td>


                </tr>



            </tbody></table></td>



          </tr>



      </tbody></table></td>



    </tr>



  </tbody></table>



</div>



</form> 
            <div style="border: 1px solid #ccc; padding: 10px; margin: 21px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Proforma Invoice Register Report : <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ echo date('d-M-Y', strtotime('-14 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==2){ echo date('d-M-Y', strtotime('-29 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==3){ echo date('d-M-Y', strtotime('-3 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==4){ echo date('d-M-Y', strtotime('-6 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==5){ echo date('d-M-Y', strtotime('-12 month')).' to '.date('d-M-Y'); } ?></div></td>
  </tr>
  <tr>
    <td>
    <?php 
    $outputp='<table width="100%" border="0" cellpadding="10" cellspacing="0"> 
  <tr>
    <td align="left" bgcolor="#f8f8f8"><strong>P.Inv.No</strong></td>
    <td align="left" bgcolor="#f8f8f8"><strong>Inv.No</strong></td>
    <td align="left" bgcolor="#f8f8f8"><strong>P.Inv.Date</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Agent</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Tour Code</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Pax</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Client</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Arr.Date</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Dep.Date</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Operator</strong></td>';
    //<!---<td align="center" bgcolor="#f8f8f8"><strong>Status</strong></td>--->
    $outputp.='<td align="center" bgcolor="#f8f8f8"><strong>Currency</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>R.O.E</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Amount</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>INR Amount</strong></td>
  </tr>';
  
  $totalRoeAmount = 0;
  $totalAmount = 0;
  $last15Days='';
  if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
	$last15Days=' and dueDate between "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last30Days='';
  if($_REQUEST['filterId']==2){ 
  	$last30Days=' and dueDate between "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last3Month='';
  if($_REQUEST['filterId']==3){ 
  	  $last3Month=' and dueDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last6Month='';
  if($_REQUEST['filterId']==4){ 
  	$last6Month=' and dueDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last12Month='';
  if($_REQUEST['filterId']==5){  
  	$last12Month=' and dueDate between "'.date('Y-m-d', strtotime('-12 month')).'" and "'.date('Y-m-d').'"'; 
  } 
  

  $dateCondition='';
  if(isset($_REQUEST['fromDate']) && isset($_REQUEST['toDate'])) 
  $dateCondition = ' and dueDate between "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" ';
  

  $wherecondition = ' deletestatus=0  and invoiceType=2 and queryId in (select id from queryMaster where queryStatus=3) '.$last15Days.' '.$last30Days.' '.$last3Month.' '.$last6Month.' '.$last12Month.' '.$dateCondition.'  order by id asc'; 
  $rs1=GetPageRecord('*',_INVOICE_MASTER_,$wherecondition);  
  $totalQuery = mysqli_num_rows($rs1);
  while($invoiceResult=mysqli_fetch_array($rs1)){ 

  $rsq=GetPageRecord('*',_QUERY_MASTER_,'id="'.$invoiceResult['queryId'].'"'); 
  $queryResult=mysqli_fetch_array($rsq);
  $totalPax = $queryResult['adult']+$queryResult['child'];

  $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$invoiceResult['queryId'].'" and status=1'); 
  $quotationResult=mysqli_fetch_array($rsquot);
  $quotationId = $quotationResult['id'];
  $roe = $quotationResult['dayroe'];

  $rscur=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotationResult['currencyId'].'"'); 
  $currencyResult=mysqli_fetch_array($rscur);
  $currencyName = $currencyResult['name'];

  $rsage=GetPageRecord('finalCost',_AGENT_PAYMENT_REQUEST_,'queryId="'.$invoiceResult['queryId'].'"  order by id desc'); 
  $requesetdata=mysqli_fetch_array($rsage);

  ///$finalRoeAmount = currency_converter($quotationResult['currencyId'],$baseCurrencyId,trim($requesetdata['finalCost']));
  $finalAmount = getTwoDecimalNumberFormat($requesetdata['finalCost']);
  
  $finalRoeAmount=round($finalAmount/$roe);

  $totalRoeAmount = $totalRoeAmount+$finalRoeAmount;
  $totalAmount = $totalAmount+$finalAmount;

  $outputp.='<tr>
    <td align="left"><div class="bluelink">';
  
   if($invoiceResult['docName']!=''){ 
    $outputp.='<a href="dirfiles/'.$resultlists['docName'].' target="_blank">INV'.makeInvoiceId($invoiceResult['id']).'</a>';
   } else { 
    $outputp.='<a href="genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf.php?id='.encode($invoiceResult['id']).'&mice='.$invoiceResult['mice'].'" target="_blank">';
    if($invoiceResult['invoiceType']=='1'){ $outputp.='INV'; } else { $outputp.='PER'; }
    $outputp.=makeInvoiceId($invoiceResult['id']);
    $outputp.='</a>';
    }
   $outputp.='</td>
    <td align="left">'.$invoiceResult['fileNo'].'</td>
    <td align="center">'.showdate($invoiceResult['invoicedate']).'</td>
    <td align="center">'.showClientTypeUserName($queryResult['clientType'],$queryResult['companyId']).'</td>
    <td align="center">'.makeQueryTourId($queryResult['id']).'</td>
    <td align="center">'.$totalPax.'</td>
    <td align="center">'.$queryResult['leadPaxName'].'</td>
    <td align="center">'.date('d-m-Y',strtotime($queryResult['fromDate'])).'</td>
    <td align="center">'.date('d-m-Y',strtotime($queryResult['toDate'])).'</td>
    <td align="center">'.getUserName($queryResult['assignTo']).'</td>';
    // <!---<td align="center">Confirmed</td>----->
    $outputp.='<td align="center">'.$currencyName.'</td>
    <td align="center">'.getTwoDecimalNumberFormat($roe).'</td>
    <td align="center">'.getTwoDecimalNumberFormat($finalRoeAmount).'</td>
    <td align="center">'.$finalAmount.'</td>
  </tr>';
  
 } 
 ?>
  <script>
  $('#totalQuery').text('<?php echo $totalQuery; ?>');
  $('#totalPaid').text('<?php echo $totalRoeAmount; ?>');
  $('#totalPayment').text('<?php echo $totalAmount; ?>');

  </script>
<?php  
$outputp.='</table>';
echo $outputp;
?>
</td>
  </tr>
</table>
</div>
	<style>
.cmsouter .iconbox {
width:20% !important;
}
</style>		
<form action="allReports/accountExcel_download.php" method="post">
<input type='hidden' name='excelFile' value='<?=base64_encode($outputp)?>'>
<input type="hidden" name="fileName" value="Proforma_Invoice_Register">
<input type="submit" name="Proforma_Invoice_Register_download" class="bluembutton" value="Download Report">
</form>
<?php }

if($_REQUEST['sr'] == '16'){ ?>
<h3 class="cms_title">Invoice Register</h3> 
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}

</style>
<div style="padding: 0px 20px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(1);">Last 15 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(2);">Last 30 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(3);">Last 3 Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(4);">Last 6 Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountReportPerformaInvfun(5);">Last 12 Month</td>
    </tr>
</table>
</div>

                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalQuery">0</div>
                    <div class="text">Total Query </div>
                    
                </div> 
            
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalPaid">0</div>
                    <div class="text">Total Amount </div>
            </div>
             
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalPayment">0</div>
                    <div class="text">Total Amount In INR</div>
            </div>
            <form method="get">



<input name="module" id="module" type="hidden" value="accounts">



<input name="sr" id="" type="hidden" value="16">

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



  <table width="100%" border="0" cellpadding="10" cellspacing="0">



    <tbody><tr>



      <td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



          <tbody><tr>



            <!-- <td width="629" align="center">&nbsp;</td> -->



            <td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



                <tbody><tr>

            <!-- <td width="629" align="center" >&nbsp;</td> -->
              
              <td style="padding:0px 0px 0px 5px;">
              <label for="">From Date:</label>
              <input name="fromDate" type="text" readonly=""  class="topsearchfiledmain" id="datepicker1" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php echo date('Y-m-d', strtotime($_REQUEST['fromDate'])); ?>" size="100" maxlength="100" placeholder="To Date"/>

              <label for="">To Date:</label>
              <input name="toDate" type="text" readonly=""  class="topsearchfiledmain" id="datepicker2" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php echo date('Y-m-d', strtotime($_REQUEST['toDate'])); ?>" size="100" maxlength="100" placeholder="To Date"/>
                            <!-- <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:100px; padding: 9px; "> -->
                <!-- <option value="">All Users</option> -->
              <?php 
                // $userQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' status=1 and name!="" ');
              
                // while($userAry=mysqli_fetch_array($userQuery))
                // {
                //   if(isset($_REQUEST['assignto']) && $_REQUEST['assignto']==$userAry['id'])
                //     echo "<option value='".$_REQUEST['assignto']."' selected>".$userAry['name'].' '.$userAry['id']."</option>";
                //   else
                //     echo "<option value='".$userAry['id']."'>".$userAry['name']."</option>";
                // }
                // echo "<option value='".$_REQUEST['assignto']."' selected>".$userAry['name'].' '.$userAry['id']."</option>";
              ?>
              
                <!-- <option value="37">Administrator CRM</option>
                <option value="131">Akash Sharma</option>
                <option value="134">Akash Pandit </option>
                <option value="130">DeBox Global</option>
                <option value="133">Dinesh Khari</option>
                <option value="129">Good Sales Ali</option>
                <option value="109">Mohd Adnan</option>
                <option value="135">Praveen Sharma</option>
                <option value="121">Samaydin khan</option>
                <option value="128">Sumair S</option>
                <option value="127">Sumair A</option> -->
              <!-- </select> -->
              <!-- <select name="country" id="country" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All country</option>
              <?php 
                // $countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,' deletestatus=0 ');
                
                // while($country=mysqli_fetch_array($countryQuery))
                // {
                //   if(isset($_REQUEST['country']) && $_REQUEST['country']==$country['id'])
                //   echo "<option value='".$country['id']."' selected>".$country['name']."</option>";
                //   else
                //   echo "<option value='".$country['id']."'>".$country['name']."</option>";

                // }
              ?>
              </select>  -->
              <!-- <select name="client" id="client" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All Client</option>
              <?php 
                // $clientQuery=GetPageRecord('id,leadPaxName',_QUERY_MASTER_,' leadPaxName!="" group by leadPaxName ');
                
                // while($client=mysqli_fetch_array($clientQuery))
                // {
                //   if(isset($_REQUEST['client']) && $_REQUEST['client']==$client['leadPaxName'])
                //   echo "<option value='".$client['leadPaxName']."' selected >".$client['leadPaxName']."</option>";
                //   else
                //   echo "<option value='".$client['leadPaxName']."'>".$client['leadPaxName']."</option>";
                // }
              ?>
              </select> -->
              <input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;"> 
              
            </td>

            <td style="padding:0px 0px 0px 5px;"></td>


                </tr>



            </tbody></table></td>



          </tr>



      </tbody></table></td>



    </tr>



  </tbody></table>



</div>



</form>  
              
            <div style="border: 1px solid #ccc; padding: 10px; margin: 21px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">

  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Invoice Register Report : <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ echo date('d-M-Y', strtotime('-14 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==2){ echo date('d-M-Y', strtotime('-29 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==3){ echo date('d-M-Y', strtotime('-3 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==4){ echo date('d-M-Y', strtotime('-6 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==5){ echo date('d-M-Y', strtotime('-12 month')).' to '.date('d-M-Y'); } ?></div></td>
  </tr>
 
  <tr>
    <td>
    <?php
    $outputp='<table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td align="left" bgcolor="#f8f8f8"><strong>Invoice.No</strong></td>
    <td align="left" bgcolor="#f8f8f8"><strong>P.Inv.No</strong></td>
    <td align="left" bgcolor="#f8f8f8"><strong>Invoice.Date</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Agent</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Tour Code</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Pax</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Client</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Arr.Date</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Dep.Date</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Operator</strong></td>';
    //<!--<td align="center" bgcolor="#f8f8f8"><strong>Status</strong></td>---->
    $outputp.='<td align="center" bgcolor="#f8f8f8"><strong>Currency</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>R.O.E</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>Amount</strong></td>
    <td align="center" bgcolor="#f8f8f8"><strong>INR Amount</strong></td>
  </tr>';
  
  $totalRoeAmount = 0;
  $totalAmount = 0;
  $last15Days='';
  if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
  $last15Days=' and dueDate between "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last30Days='';
  if($_REQUEST['filterId']==2){ 
    $last30Days=' and dueDate between "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last3Month='';
  if($_REQUEST['filterId']==3){ 
      $last3Month=' and dueDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last6Month='';
  if($_REQUEST['filterId']==4){ 
    $last6Month=' and dueDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last12Month='';
  if($_REQUEST['filterId']==5){  
    $last12Month=' and dueDate between "'.date('Y-m-d', strtotime('-12 month')).'" and "'.date('Y-m-d').'"'; 
  }
  

  $dateCondition='';
  if(isset($_REQUEST['fromDate']) && isset($_REQUEST['toDate'])) 
  $dateCondition = ' and dueDate between "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" ';
  
  $wherecondition = ' deletestatus=0  and invoiceType=1 and queryId in (select id from queryMaster where queryStatus=3) '.$last15Days.' '.$last30Days.' '.$last3Month.' '.$last6Month.' '.$last12Month.' '.$dateCondition.'  order by id asc'; 
  $rs1=GetPageRecord('*',_INVOICE_MASTER_,$wherecondition);  
  $totalQuery = mysqli_num_rows($rs1);
  while($invoiceResult=mysqli_fetch_array($rs1)){ 

  $rsq=GetPageRecord('*',_QUERY_MASTER_,'id="'.$invoiceResult['queryId'].'"'); 
  $queryResult=mysqli_fetch_array($rsq);
  $totalPax = $queryResult['adult']+$queryResult['child'];

  $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$invoiceResult['queryId'].'" and status=1'); 
  $quotationResult=mysqli_fetch_array($rsquot);
  $quotationId = $quotationResult['id'];
  $roe = $quotationResult['dayroe'];

  $rscur=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotationResult['currencyId'].'"'); 
  $currencyResult=mysqli_fetch_array($rscur);
  $currencyName = $currencyResult['name'];

  $rsage=GetPageRecord('finalCost',_AGENT_PAYMENT_REQUEST_,'queryId="'.$invoiceResult['queryId'].'"  order by id desc'); 
  $requesetdata=mysqli_fetch_array($rsage);

  ////$finalRoeAmount = currency_converter($quotationResult['currencyId'],$baseCurrencyId,trim($requesetdata['finalCost']));
  $finalAmount = getTwoDecimalNumberFormat($requesetdata['finalCost']);


  $finalRoeAmount=round($finalAmount/$roe);
  $totalRoeAmount = $totalRoeAmount+$finalRoeAmount;
  $totalAmount = $totalAmount+$finalAmount;


  $outputp.='<tr>
    <td align="left"><div class="bluelink">';
  
  if($invoiceResult['docName']!=''){ 
    $outputp.='<a href="dirfiles/'.$resultlists['docName'].' target=_blank>'.'INV'.makeInvoiceId($invoiceResult['id']).'</a>';
    } else {
      $outputp.='<a href="genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf.php?id='.encode($invoiceResult['id']).'&mice='.$invoiceResult['mice'].' target="_blank">';
      if($invoiceResult['invoiceType']=='1'){ $outputp.='INV'; } else { $outputp.='PER'; } 
      $outputp.=makeInvoiceId($invoiceResult['id']).'</a>';
    }
    $outputp.='</td>';
    $outputp.='<td align="left">'.$invoiceResult['fileNo'].'</td>';
    $outputp.='<td align="center">'.showdate($invoiceResult['invoicedate']).'</td>';
    $outputp.='<td align="center">'.showClientTypeUserName($queryResult['clientType'],$queryResult['companyId']).'</td>';
    $outputp.='<td align="center">'.makeQueryTourId($queryResult['id']).'</td>';
    $outputp.='<td align="center">'.$totalPax.'</td>';
    $outputp.='<td align="center">'.$queryResult['leadPaxName'].'</td>';
    $outputp.='<td align="center">'.date('d-m-Y',strtotime($queryResult['fromDate'])).'</td>';
    $outputp.='<td align="center">'.date('d-m-Y',strtotime($queryResult['toDate'])).'</td>';
    $outputp.='<td align="center">'.getUserName($queryResult['assignTo']).'</td>';
    // <!---<td align="center"></td>--->
    $outputp.='<td align="center">'.$currencyName.'</td>';
    $outputp.='<td align="center">'.getTwoDecimalNumberFormat($roe).'</td>';
    $outputp.='<td align="center">'.getTwoDecimalNumberFormat($finalRoeAmount).'</td>';
    $outputp.='<td align="center">'.$finalAmount.'</td>';
    $outputp.='</tr>';
    ?>
  <?php
 } ?>
  <script>
  $('#totalQuery').text('<?php echo $totalQuery; ?>');
  $('#totalPaid').text('<?php echo $totalRoeAmount; ?>');
  $('#totalPayment').text('<?php echo $totalAmount; ?>');

  </script>
<?php

$outputp.='</table>';

echo $outputp;

?>  

</td>
  </tr>
</table>
</div>
  <style>
.cmsouter .iconbox {
width:20% !important;
}
</style>   
<form action="allReports/accountExcel_download.php" method="post">
<input type='hidden' name='excelFile' value='<?=base64_encode($outputp)?>'>
<input type="hidden" name="fileName" value="Proforma_Invoice_Register">
<input type="submit" name="Proforma_Invoice_Register_download" class="bluembutton" value="Download Report">
</form>
<?php }



if($_REQUEST['sr'] == '17'){ 
   
  ?>
<h3 class="cms_title">Turnover Statement</h3> 
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}

</style>
<div style="padding: 0px 20px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountTurnOverReportfun(1);">Last 15 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountTurnOverReportfun(2);">Last 30 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountTurnOverReportfun(3);">Last 3 Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountTurnOverReportfun(4);">Last 6 Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountTurnOverReportfun(5);">Last 12 Month</td>
    </tr>
</table>
</div>

                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalQuery">0</div>
                    <div class="text">Total Query </div>
                    
                </div> 
            
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalAmount">0</div>
                    <div class="text">Total Amount </div>
            </div>
             
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalTaxAmount">0</div>
                    <div class="text">Total Tax Amount In INR</div>
            </div>

            <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalNetAmount">0</div>
                    <div class="text">Total Net Amount In INR</div>
            </div>
<form method="get">

<input name="module" id="module" type="hidden" value="accounts">

<input name="sr" id="" type="hidden" value="17">

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">

  <table width="100%" border="0" cellpadding="10" cellspacing="0">



    <tbody><tr>



      <td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



          <tbody><tr>



            <!-- <td width="629" align="center">&nbsp;</td> -->



            <td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



                <tbody><tr>

            <!-- <td width="629" align="center" >&nbsp;</td> -->
              
              <td style="padding:0px 0px 0px 5px;">
              <label for="">From Date:</label>
              <input name="fromDate" type="text" readonly=""  class="topsearchfiledmain" id="datepicker1" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php echo date('Y-m-d', strtotime($_REQUEST['fromDate'])); ?>" size="100" maxlength="100" placeholder="To Date"/>

              <label for="">To Date:</label>
              <input name="toDate" type="text" readonly=""  class="topsearchfiledmain" id="datepicker2" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php echo date('Y-m-d', strtotime($_REQUEST['toDate'])); ?>" size="100" maxlength="100" placeholder="To Date"/>
                            <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All Users</option>
              <?php 
                $userQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' status=1 and name!="" ');
              
                while($userAry=mysqli_fetch_array($userQuery))
                {
                  if(isset($_REQUEST['assignto']) && $_REQUEST['assignto']==$userAry['id'])
                    echo "<option value='".$_REQUEST['assignto']."' selected>".$userAry['name'].' '.$userAry['id']."</option>";
                  else
                    echo "<option value='".$userAry['id']."'>".$userAry['name']."</option>";
                }
                // echo "<option value='".$_REQUEST['assignto']."' selected>".$userAry['name'].' '.$userAry['id']."</option>";
              ?>
              
                <!-- <option value="37">Administrator CRM</option>
                <option value="131">Akash Sharma</option>
                <option value="134">Akash Pandit </option>
                <option value="130">DeBox Global</option>
                <option value="133">Dinesh Khari</option>
                <option value="129">Good Sales Ali</option>
                <option value="109">Mohd Adnan</option>
                <option value="135">Praveen Sharma</option>
                <option value="121">Samaydin khan</option>
                <option value="128">Sumair S</option>
                <option value="127">Sumair A</option> -->
              </select>
              <select name="country" id="country" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All country</option>
              <?php 
                $countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,' deletestatus=0 ');
                
                while($country=mysqli_fetch_array($countryQuery))
                {
                  if(isset($_REQUEST['country']) && $_REQUEST['country']==$country['id'])
                  echo "<option value='".$country['id']."' selected>".$country['name']."</option>";
                  else
                  echo "<option value='".$country['id']."'>".$country['name']."</option>";

                }
              ?>
              </select> 
              <select name="client" id="client" class="topsearchfiledmainselect" style="width:100px; padding: 9px; ">
                <option value="">All Client</option>
              <?php 
                $clientQuery=GetPageRecord('id,leadPaxName',_QUERY_MASTER_,' leadPaxName!="" group by leadPaxName ');
                
                while($client=mysqli_fetch_array($clientQuery))
                {
                  if(isset($_REQUEST['client']) && $_REQUEST['client']==$client['leadPaxName'])
                  echo "<option value='".$client['leadPaxName']."' selected >".$client['leadPaxName']."</option>";
                  else
                  echo "<option value='".$client['leadPaxName']."'>".$client['leadPaxName']."</option>";
                }
              ?>
              </select>
              <input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;"> 
              
            </td>

            <td style="padding:0px 0px 0px 5px;"></td>


                </tr>



            </tbody></table></td>



          </tr>



      </tbody></table></td>



    </tr>



  </tbody></table>



</div>



</form>            
      <!-- <div>      
      <table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
          <form>
            <td style="padding:0px 0px 0px 5px;">
              <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; padding: 9px; ">
                <option value="">All Users</option>
                <option value="37">Administrator CRM</option>
                <option value="131">Akash Sharma</option>
                <option value="134">Akash Pandit </option>
                <option value="130">DeBox Global</option>
                <option value="133">Dinesh Khari</option>
                <option value="129">Good Sales Ali</option>
                <option value="109">Mohd Adnan</option>
                <option value="135">Praveen Sharma</option>
                <option value="121">Samaydin khan</option>
                <option value="128">Sumair S</option>
                <option value="127">Sumair A</option>
              </select>  
            </td>
            
            <td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>

            <td style="padding:0px 0px 0px 5px;">
              <input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;">            
            </td>
          </form>  
          </tr>
        </tbody>
      </table>
      </div>       -->
            <div style="border: 1px solid #ccc; padding: 10px; margin: 21px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Turnover Statement Report : <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ echo date('d-M-Y', strtotime('-14 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==2){ echo date('d-M-Y', strtotime('-29 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==3){ echo date('d-M-Y', strtotime('-3 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==4){ echo date('d-M-Y', strtotime('-6 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==5){ echo date('d-M-Y', strtotime('-12 month')).' to '.date('d-M-Y'); } ?></div></td>
  </tr>
  <tr>
    <td>
    <?php
    $outputTs='';
    $outputTs.='<table width="100%" border="0" cellpadding="10" cellspacing="0">';
  
  $totalTax = 0;
  $totalAmountinr = 0;
  $totalAmount = 0;
  $last15Days='';
  if($_REQUEST['filterId']==1){ 
  $last15Days=' and fromDate between "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last30Days='';
  if($_REQUEST['filterId']==2){ 
    $last30Days=' and fromDate between "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last3Month='';
  if($_REQUEST['filterId']==3){ 
      $last3Month=' and fromDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last6Month='';
  if($_REQUEST['filterId']==4){ 
    $last6Month=' and fromDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last12Month='';
  if($_REQUEST['filterId']==5){  
    $last12Month=' and fromDate between "'.date('Y-m-d', strtotime('-12 month')).'" and "'.date('Y-m-d').'"'; 
  } 
  $whereDateCondition='';
  if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    
    $whereDateCondition='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).' "';

  }
  
   $daterangeQuery='';

  //  if($_GET['daterange']!=''){ 
  //    $myString = $_GET['daterange'];
  //    $myArray = explode(' - ', $myString);  
  //    $whereDateCondition = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
  //   //  $whereDateCondition = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  '.$daterangeQuery.' group by currencyId  order by id asc';  
  //   //  $datewhere='';
  //  }
  
  
  $whereCountry='';
  
  $whereAgent='';
  
  $whereClient='';
  
  if($_REQUEST['country'])
  {
    $whereCountry = ' and queryId in (select id from queryMaster where companyId='.$_REQUEST['country'].') ';
  }
  
  if($_REQUEST['assignto'])
  {
    $whereAgent = ' and queryId in (select id from queryMaster where companyId='.$_REQUEST['assignto'].') ';
  }
  
  if($_REQUEST['client'])
  {
    $whereClient = ' and queryId in (select id from queryMaster where leadPaxName="'.$_REQUEST['client'].'" ) ';
  }

  
  $wherecondition = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0)  '.$whereCountry.' '.$whereAgent.' '.$whereClient.' and status=1  '.$last15Days.' '.$last30Days.' '.$last3Month.' '.$last6Month.' '.$last12Month.' '.$whereDateCondition.'  order by id asc'; 
  $rs1=GetPageRecord('*',_QUOTATION_MASTER_,$wherecondition);  
  // var_dump($rs1);
  while($quotationResult=mysqli_fetch_array($rs1)){ 
    
     $rscur=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotationResult['currencyId'].'" and deletestatus=0');
     while($currencyResult=mysqli_fetch_array($rscur)){

      
      $outputTs.='<tr>
    <td align="left" colspan="15" style="border: 1px solid #00000014;background-color: #8080800d;"><div><strong>List of Invoice Raised in '.$currencyResult['name'].'</strong></div></td>
  
  </tr>
  <tr >
    <td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Tour Ref No</strong></td>
    <td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Agent Name</strong></td>
    <td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Pax</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Invoice Date</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Arrival</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Departure</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Lead Pax Name</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Agent Country</strong></td>';
    // <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Country</strong></td>
    $outputTs.='<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>P.Inv.No</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Exchange Rate</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Currency Amount</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Total Amount</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Tax Amount (INR)</strong></td>
    <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Net Amount (INR)</strong></td>
  </tr>';
  

  $where = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  and fromDate between "'.$quotationResult['fromDate'].'" and "'.$quotationResult['toDate'].'" and currencyId="'.$currencyResult['id'].'" order by id asc'; 
  $rsqi=GetPageRecord('*',_QUOTATION_MASTER_,$where); 
  $totalQuery = mysqli_num_rows($rsqi); 
  while($quotResulti=mysqli_fetch_array($rsqi)){

     $rscuri=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotResulti['currencyId'].'"');
     $currencyResulti=mysqli_fetch_array($rscuri);

     $rs2=GetPageRecord('currencyValue','queryCurrencyRateMaster',' currencyId="'.$currencyResulti['id'].'"'); 
     $editresult2=mysqli_fetch_array($rs2);
     $exchangerate = number_format($editresult2['currencyValue'],4);
     
     $rsque=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotResulti['queryId'].'"');
     $queryResult=mysqli_fetch_array($rsque);
     $totalPax = $queryResult['adult']+$queryResult['child'];

     $rsinv=GetPageRecord('*',_INVOICE_MASTER_,'queryId="'.$queryResult['id'].'"');
     $invoiceResult=mysqli_fetch_array($rsinv);

     $rsagent=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
     $agentResult=mysqli_fetch_array($rsagent);

     $reqclientGst = $agentResult['reqclientGst'];
     if ($reqclientGst != 0){
       $Cgst = $agentResult['reqclientCGst'];
       $Sgst = $agentResult['reqclientSGst'];
       $Igst = $agentResult['reqclientIGst'];
       $finalReqCost = $agentResult['reqclientCost'];

       $cgsta = round($finalReqCost * $Cgst / 100);
       $sgsta = round($finalReqCost * $Sgst / 100);
       $igstvala = round($finalReqCost * $Igst / 100);

       $taxAmount = $cgsta+$sgsta+$igstvala;
       $totalTax = $totalTax+$taxAmount;
      }
      
      
      
      $ammount=$agentResult['reqclientCost'];
      
      $totalAmount=$totalAmount+$ammount;

      $finalCost = $agentResult['reqclientCost']+$taxAmount;
      $totalAmountinr = $totalAmountinr+$finalCost;
      /////$totalAmountgstInr = $totalAmountgstInr+currency_converter($quotResulti['currencyId'],$baseCurrencyId,trim($finalCost))
       $totalAmountin=round($finalCost/$exchangerate);

      //==============  country ============
      $destinationQuery=GetPageRecord('countryId',_CORPORATE_MASTER_,'id="'.$queryResult['companyId'].'"');
      $destination=mysqli_fetch_array($destinationQuery);
      $countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,'id="'.$destination['countryId'].'"');
      $country=mysqli_fetch_array($countryQuery);

  

      $outputTs.='<tr>';
      $outputTs.='<td align="left" ><div style="width:130px;" class="bluelink">'.makeQueryTourId($queryResult['id']).'<br>'.'&'.clean($queryResult['referanceNumber']).'</div></td>
    <td align="left">'.showClientTypeUserName($queryResult['clientType'],$queryResult['companyId']).'</td>
    <td align="left">'.$totalPax.'</td>
    <td align="center">'.date('d-m-Y',$invoiceResult['dateAdded']).'</td>
    <td align="center">'.date('d-m-Y',strtotime($quotResulti['fromDate'])).'</td>
    <td align="center">'.date('d-m-Y',strtotime($quotResulti['toDate'])).'</td>
    <td align="center">'.$queryResult['leadPaxName'].'</td>';
    // <td align="center"></td>
    $outputTs.='<td align="center">'.$country['name'].'</td>
    <td align="center"><div class="bluelink">';
  
  if($resultlists['docName']!=''){ 
    $outputTs.='<a href="dirfiles/'.$invoiceResult['docName'].'" target="_blank">INV'.makeInvoiceId($invoiceResult['id']).'</a>';
    } else { 
      $outputTs.='<a href="genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf.php?id='.encode($invoiceResult['id']).'&mice='.$invoiceResult['mice'].'" target="_blank">';
    if($invoiceResult['invoiceType']=='1'){ $outputTs.='INV'; } else { $outputTs.='PER'; } 
    $outputTs.=makeInvoiceId($invoiceResult['id']).'</a>';
    } 
   
   
    $outputTs.='</div></td>';
    $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($exchangerate).'</td>';
    $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($totalAmountin).'</td>';
    $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($totalAmountin).'</td>';
    // $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($ammount).'</td>';
    $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($taxAmount).'</td>';
    $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($finalCost).'</td>';
    $outputTs.='</tr>';
  }




   
 }} ?>
  <script>
  $('#totalQuery').text('<?php echo $totalQuery; ?>');
  $('#totalAmount').text('<?php echo $totalAmount; ?>');
  $('#totalTaxAmount').text('<?php echo $totalTax; ?>');
  $('#totalNetAmount').text('<?php echo $totalAmountinr; ?>');

  </script> 
<?php 
$outputTs.='</table>';
echo $outputTs;
?>

</td>
  </tr>
</table>

</div>
<form action="allReports/accountExcel_download.php" method="post">
<input type='hidden' name='excelFile' value='<?=base64_encode($outputTs)?>'>
<input type="hidden" name="fileName" value="turnover_Statement">
<input type="submit" name="Proforma_Invoice_Register_download" class="bluembutton" value="Download Report">
</form>
  <style>
.cmsouter .iconbox {
width:20% !important;
}
</style>   

<?php }






 ?>

<script>



$('#datepicker1').Zebra_DatePicker();
$('#datepicker2').Zebra_DatePicker();
// $(function() {


// $('input[name="daterange"]').daterangepicker({



// "autoApply": true,



//   opens: 'right',



// locale: {



//           format: 'DD-MM-YYYY'



//       }







// }, function(start, end, label) { 



   



// });



 



// });



</script>
	