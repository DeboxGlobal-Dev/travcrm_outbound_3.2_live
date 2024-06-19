<?php 
$select='*'; 
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs); 

$termscondition = $resultInvoiceSetting['termscondition'];
$rerultsetting=GetPageRecord($select,'companySettingsMaster','id=1');
$companyPAN = mysqli_fetch_assoc($rerultsetting);



$rscs222=GetPageRecord('*','companySettingsMaster','companyName!=""');  
$companyresult333=mysqli_fetch_array($rscs222);
if(!empty($companyresult333)){
  $rsfs333=GetPageRecord('*','componyFinanceSetting','companySettingId="'.$companyresult333['id'].'"');  
  $financeresult333=mysqli_fetch_array($rsfs333);	
}



// $where1111='addressType="invoicesetting" and primaryAddress="1"';
$rs133=GetPageRecord('*',_ADDRESS_MASTER_,'addressType="invoicesetting" and primaryAddress="1"');
$resultGST=mysqli_fetch_array($rs133);
$companyGSTNo=$resultGST['gstn'];

// new
$invoiceId=decode($_GET['id']);
if($invoiceId!=''){
   
  $rs='';   
  $rs=GetPageRecord('*',_INVOICE_MASTER_,'id='.$invoiceId); 
  $invmData=mysqli_fetch_array($rs); 
  
  $invoiceNotes=$invmData['invoiceNotes']; 
  $quotationId=$invmData['quotationId']; 
  $invmData['invoiceType']; 


  $rs=''; 
  $rs=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'quotationId="'.$quotationId.'"'); 
  $prmData=mysqli_fetch_array($rs); 
  $paymentId = $prmData['id'];

  
  $quotQuery="";
  $quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" and status=1 '); 
  $quotationData=mysqli_fetch_array($quotQuery);

  $queryId=$quotationData['queryId']; 
  $totalPax = $quotationData['adult']+$quotationData['child']+$quotationData['infant'];
  $totalAdult = $quotationData['adult'];
  $totalChild = $quotationData['child'];
  $totalInfant = $quotationData['infant'];

  $qrQuery='';   
  $qrQuery=GetPageRecord('*',_QUERY_MASTER_,'id='.$queryId); 
  $queryData=mysqli_fetch_array($qrQuery); 
  $editdescription=clean($queryData['description']);   

}

$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$noofpax = $quotationData['adult']+$quotationData['child']; 
$subject = ($invmData['particularsubject']!='')?$invmData['particularsubject']:$quotationData['quotationSubject'];


if($queryData['clientType']!=2){
  $select4='*';  
  $where4='id='.$queryData['companyId'].''; 
  $rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
  $resultCompany=mysqli_fetch_array($rs4); 
  $mobilemailtype='corporate';
}

if($queryData['clientType']==2){
  $select4='*';  
  $where4='id='.$queryData['companyId'].''; 
  $rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
  $resultCompany=mysqli_fetch_array($rs4); 
  $mobilemailtype='contacts';
}


$totalCompanyCost = $prmData['totalCompanyCost'];
$totalClientCost = round($prmData['totalClientCost'],2);
$totalISOCost = $prmData['totalISOCost'];
$totalConsortiaCost = $prmData['totalConsortiaCost'];
$totalClientCommCost = $prmData['totalClientCommCost'];

$totalClientCostWithMarkup = round($prmData['totalClientCostWithMarkup']+$totalISOCost+$totalConsortiaCost+$totalClientCommCost);

$totalMarkupCost = $prmData['totalMarkupCost'];
$totalServiceTaxCost = $prmData['totalServiceTaxCost'];
$totalTCSCost = $prmData['totalTCSCost'];
$totalDiscountCost = $prmData['totalDiscountCost'];

$nonTaxableAMT = round($prmData['nonTaxableAMT'],2);
$taxableAMT = $totalClientCostWithMarkup-$nonTaxableAMT;

$sglBasisCost = $prmData['sglBasisCost'];
$dblBasisCost = $prmData['dblBasisCost'];
$twinBasisCost = $prmData['twinCost'];
$tplBasisCost = $prmData['tplBasisCost'];
$extraAdultBasisCost = $prmData['extraAdultCost'];
$CWBBasisCost = $prmData['CWBCost'];
$CNBBasisCost = $prmData['CNBCost'];

$currencyId = $prmData['currencyId'];

$gstType = $prmData['gstType'];
$serviceTax = $prmData['serviceTax'];

$tcsTax = $prmData['tcsTax'];
$commissionType = $prmData['commissionType'];
$ISOCommission = $prmData['ISOCommission'];
$ConsortiaCommission = $prmData['ConsortiaCommission'];
$ClientCommission = $prmData['ClientCommission'];
$discountType = $prmData['discountType'];
$discount = $prmData['discount']; 

$currencyId = ($currencyId>0)?$currencyId:$baseCurrencyId;

$reshsn='';
$reshsn=GetPageRecord('*','sacCodeMaster','deleteStatus=0 and status=1 and setDefault=1'); 
$resulthsn=mysqli_fetch_array($reshsn); 

// invoice template select
$rs = GetPageRecord('setDefaultTemplate','invoiceSettingMaster','id=1');
$invoiceTempvoucherData = mysqli_fetch_assoc($rs);
$setDefaultTemplate = $invoiceTempvoucherData['setDefaultTemplate']; 

// old
// if($_GET['id']!=''){

//  $id=clean(decode($_GET['id']));
   
//  $select=''; 
//  $where=''; 
//  $rs='';   
//  $select='*'; 
//  $where='id='.$id;  
//  $rs=GetPageRecord($select,_INVOICE_MASTER_,$where); 
//  $invmData=mysqli_fetch_array($rs); 
  
//  $invoiceNotes=$invmData['invoiceNotes']; 
//  $payment=$invmData['payment']; 
  
//  $select1='*';  
//  $where1='queryid='.$invmData['queryId'].' order by id asc'; 
//  $rs1=GetPageRecord($select1,_QUERYMAILS_MASTER_,$where1); 
//  $querymailmaster=mysqli_fetch_array($rs1);
  
  
//  $select1='*';  
//  $where1='id='.$invmData['queryId'].''; 
//  $rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
//  $editresult=mysqli_fetch_array($rs1);
   
  
  
//  $editdescription=clean($editresult['description']);   
//  $queryId=$editresult['id'];
   
// }

// $select=''; 
// $where=''; 
// $rs='';   
// $select='*'; 
// $id=clean($invmData['queryId']); 
// $where='id="'.$id.'" order by id desc'; 
// $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
// $resultpage=mysqli_fetch_array($rs);  


// $quotQuery="";
// $quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$invmData['quotationId'].'" and status=1 '); 
// $quotationData=mysqli_fetch_array($quotQuery);

// $quotationId = $quotationData['id']; 
// $queryId = $quotationData['queryId']; 
// $noofpax = $quotationData['adult']+$quotationData['child']+$quotationData['infant']; 
// $subject = ($quotationData['quotationSubject']!='')?$quotationData['quotationSubject']:$resultQuery['subject'];
// $costType = $quotationData['costType'];
// $discountType= $quotationData['discountType'];
// $discount = $quotationData['discount'];
// if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
//  $newCurr = $baseCurrencyId;
// }else{
//  $newCurr = $quotationData['currencyId'];
// }

// $select5='*';  
// $where5='addressType="invoicesetting" and addressParent="1" '; 
// $rs5=GetPageRecord($select5,_ADDRESS_MASTER_,$where5); 
// $address5 =mysqli_fetch_array($rs5); 

?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#description",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>
  
  
<link href="css/main.css" rel="stylesheet" type="text/css" />
    <div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
        <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
           
            <td style="padding-right:20px;"><input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox" style="background-color: #dedede;">
  <div class="col-md-6" style="width:915px;margin: auto;border: 1px #ccc solid;background-color: #fff;">
  <!-- general form elements -->
  <div class="box box-primary">
<div style="padding:20px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td align="center" colspan="2"><img src="download/<?php echo $invoicesetting['logo']; ?>" width="180px" /></td>
  </tr>
  <tr>
  <td align="center" colspan="2">&nbsp;</td>
  </tr>
  <tr><td colspan="2">
  <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" style="border:1px solid #ccc;margin-bottom: 20px;">
 
  <tr >
 
            
              <td align="center" width="33%">
              <div class="griddiv" style="border-bottom:none;"><label>
              <div class="gridlable" style="width:70%;text-align: left;" >Format Type</div>
              <select id="invoiceFormat" name="invoiceFormat" class="gridfield validate"   autocomplete="off" onchange="selectInvoiceFormat(this.value);" style="width: 70%;" > 
              <option value="1" <?php if($invmData['invoiceFormat']=='1' || $invmData['invoiceFormat']==''){ ?>selected="selected"<?php } ?>>Total Invoice</option>  
              <option value="2" <?php if($invmData['invoiceFormat']=='2'){ ?>selected="selected"<?php } ?>>Item Wise Invoice</option> 
              </select>
              </label>
              </div>
              </td>

              <td align="center" valign="middle" width="33%">
              <div class="griddiv" style="border-bottom:none;"><label>
              <div class="gridlable" style="width:70%;text-align: left;" >Invoice Type</div>
                <select id="invoiceType" name="invoiceType" class="gridfield validate"   autocomplete="off" onchange="selectInvoiceType(this.value);" style="width: 70%;" > 
              <option value="2" <?php if($invmData['invoiceType']=='2' || $invmData['invoiceType']==''){ ?>selected="selected"<?php } ?>>Proforma Invoice</option>  
              <option value="1" <?php if($invmData['invoiceType']=='1'){ ?>selected="selected"<?php } ?>>Tax Invoice</option> 
              </select>
              </label>
              </div>
              </td>

              <td align="center" valign="middle" width="33%">
              <div class="griddiv" style="border-bottom:none;"><label>
              <div class="gridlable" style="width:70%;text-align: left;" >Cost Type</div>
              <select id="costType" name="costType" class="gridfield validate" autocomplete="off" style="width: 70%;" > 
              <option value="1" <?php if($invmData['costType']=='1' || $invmData['costType']==''){ ?>selected="selected"<?php } ?>>Individual</option>  

              <option value="2" <?php if($invmData['costType']=='2'){ ?>selected="selected"<?php } ?>>Consolidated</option> 
              </select>
              </label>
              </div>
              </td>
  </tr>
 </table>
  </td></tr>
 <tr>
  <td>
  <table width="100%" border="0" style="max-height:50px;border-collapse: collapse;" ><tbody>
   
        <tr>
        <td colspan="3" align="right">
          <div style="font-size:40px; font-weight:normal;">
            <input name="editId" type="hidden" id="editId" value="<?php echo $invoiceId; ?>" />
            <input name="action" type="hidden" id="action" value="editinvoicemain" />
            <div id="invoiceTypedisplay"><?php if($invmData['invoiceType'] == 1){ echo 'TAX INVOICE'; }else{ echo 'PROFORMA INVOICE'; } ?></div>
          </div>
        </td>
      </tr>
		</tbody>
	</table>
	<br> 
  <table width="100%" border="1" style="border:1px solid #000000; border-bottom: 0px solid #000000;border-collapse: collapse;" cellpadding="0" celspacing="0">
		<tbody>
			<tr>
				<td align="center" valign="middle" height="65" width="30%">
					<?php $logoPath = "dirfiles/".$resultInvoiceSetting['logo'];
					if($resultInvoiceSetting['logo']!='' && file_exists($logoPath)==true){
					?>
					<img align="center" src="<?php echo $fullurl.$logoPath; ?>" width="140" height="60" >
				<?php } ?>
				</td>
				<td width= "70%" style="font-size: 11px; ">
				  <p class="headbox"><strong>&nbsp;<?php echo $resultInvoiceSetting['companyname']; ?></strong></p>
				  <p class="headbox"><strong>&nbsp;Address:</strong>&nbsp;<?php echo $resultInvoiceSetting['address']; ?></p>
          <p class="headbox"><strong>&nbsp;Contact:</strong>&nbsp;<?php echo $resultInvoiceSetting['phone']; ?></p> 
          <?php if($resultInvoiceSetting['email']!=''){ ?>
          <p class="headbox"><strong>&nbsp;Email: </strong>&nbsp;<?php echo $resultInvoiceSetting['email']; ?>
				    <strong>&nbsp;Website: </strong>&nbsp;<?php echo $resultInvoiceSetting['website']; ?></p>
            <?php } ?>
				    <p class="headbox"><?php if($companyGSTNo!=''){ ?><strong>&nbsp;GSTIN/UIN:</strong>&nbsp;<?php echo $companyGSTNo; } if($companyPAN['panInformation']!=''){ ?>
				    <strong>&nbsp;PAN:</strong>&nbsp;<?php echo $companyPAN['panInformation']; ?></p>
            <?php } if($companyPAN['CINnumber']!=''){ ?>
				    <p class="headbox"><strong>&nbsp;CIN:</strong>&nbsp;<?php echo $companyPAN['CINnumber']; ?></p>
            <?php } if($companyPAN['TRNnumber']!=''){ ?>
				      <strong>&nbsp;TRN:</strong>&nbsp;<?php echo $companyPAN['TRNnumber']; ?>
              <?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
  </td>
 </tr>

<tr>
  <td>

  <table  width="100%" border="1" bordercolor="#000000" cellpadding="5" style="font-size: 13px;border-collapse: collapse; border-top: 0px solid #fff;">
		<tbody>
			<tr>
				<td width="45%" rowspan="6" style="font-size: 12px;vertical-align: top;">
					<p class="headbox"><strong>&nbsp;Bill To:&nbsp;&nbsp;<?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></strong></p>

					<p class="headbox"><strong>&nbsp;Address:&nbsp;</strong><?php echo $resultCompany['address1'].' '.$resultCompany['pinCode'] ; ?></p>

					<p class="headbox"><strong>&nbsp;Phone:&nbsp;</strong><?php echo $queryData['guest1phone']; ?></p>
					<p class="headbox"><strong>&nbsp;Email:&nbsp;</strong><?php echo $queryData['guest1email']; ?></p>
          <?php if($resultCompany['gstn']!=''){ ?>
					<p class="headbox"><strong>&nbsp;GSTIN/UIN:&nbsp;</strong><?php echo $resultCompany['gstn'] ?></p>
          <?php } if($resultCompany['panInformation']!=''){ ?>
					<p class="headbox"><strong>&nbsp;PAN:&nbsp;</strong><?php echo $resultCompany['panInformation']; ?></p>
          <?php } if($companyPAN['TRNnumber']!=''){ ?>
					<p class="headbox"><strong>&nbsp;TRN:</strong>&nbsp;<?php echo $companyPAN['TRNnumber']; ?></p>
          <?php } ?>
       
					<p class="headbox"><strong>&nbsp;State&nbsp;/&nbsp;Country&nbsp;Name:&nbsp;</strong><?php if($resultCompany['stateId']!=''){ echo getStateName($resultCompany['stateId']).' '.'/'; } ?> <?php echo getCountryName($resultCompany['countryId']); ?>
          </p>
				</td> 
			</tr>
      
      <tr>
      <td width="25%"><strong>&nbsp;</strong>Invoice No:<strong>&nbsp;<?php echo makeInvoiceId($invmData['id']); ?></strong></td>
				<td width="30%">&nbsp;Invoice&nbsp;Date:<strong>&nbsp;<div class="input-group date" style="display:inline-block;vertical-align: middle;width:61%;">
                  <?php //echo $invmData['invoicedate']; ?>
                  <input name="invoicedate" type="text" class="form-control pull-right " id="invoicedate" displayname="Date" value="<?php if($invmData['invoicedate']!='' && $invmData['invoicedate']!='0000-00-00'){ echo date("d-m-Y", strtotime($invmData['invoicedate'])); } else { echo date("d-m-Y"); } ?>">
                  <script>
                    $("#invoicedate").Zebra_DatePicker({
                      format : "d-m-Y"
                    })
                  </script>
                </div></strong></td>
      </tr>
			<tr> 
				<td><strong>&nbsp;</strong>Reference No:<strong>&nbsp;<?php if($invmData['referNo']!=''){ echo $invmData['referNo']; }else{ echo $queryData['referanceNumber']; } ?></strong></td>
			    
          <td>&nbsp;Due Date:<strong>&nbsp;<div class="input-group date" style="display: inline-block;vertical-align: middle;width:68%;">
                <input name="dueDate" type="text" class="form-control pull-right" id="dueDate" displayname="Due Date" value="<?php if($invmData['dueDate']!='' && $invmData['dueDate']!='0000-00-00'){ echo date("d-m-Y", strtotime($invmData['dueDate'])); } else { echo date("d-m-Y"); }  ?>">
                  <script>
                    $("#dueDate").Zebra_DatePicker({
                      format : "d-m-Y"
                    })
                  </script>
              </div></strong>
            </td>
			</tr>
			<tr>
				<td><strong>&nbsp;</strong>Tour Id:<strong>&nbsp;<?php if($invmData['fileNo']!=''){ echo $invmData['tourId']; }else{ echo makeQueryTourId($queryData['id']); } ?></strong></td>
				<td><strong>&nbsp;</strong>File No.:<strong>&nbsp;<?php if($invmData['referNo']!=''){ echo $invmData['fileNo']; }else{ echo makeQueryId($queryData['id']); }  ?></strong> </td>
			</tr>
      <tr>
				
        <td><strong>&nbsp;</strong>Currency.:<strong>&nbsp;<?php echo getCurrencyName($currencyId)  ?></strong> </td>
        <td><strong>&nbsp;</strong>Guest:<strong>&nbsp;<div class="input-group date" style="display: inline-block;vertical-align: middle;">
            <input name="guestName" type="text" class="form-control pull-right" id="guestName" displayname="Guest Name" value="<?php echo $invmData['guestName']; ?>"> 
            </div></strong></td>
			</tr>
			<tr>
				<td colspan="2" style="height: 45px; font-size: 14px; "><strong>&nbsp;</strong>Place of Delivery :<strong>&nbsp; <div class="input-group date" style="display: inline-block;vertical-align: middle;">
              <input name="deliveryplace" type="text" class="form-control pull-right" id="deliveryplace" displayname="Place of Delivery" value="<?php echo $invmData['deliveryPlace']; ?>"> 
              </div></strong></td>
			</tr>
		</tbody>	
	</table>
  </td>
</tr>


 
  <?php if($invmData['invoiceFormat']=='1'){ 
    
    if($setDefaultTemplate==5){
      ?>
  <tr>
    <td align="left" valign="top" style="padding:10px 0px 5px;">

        <table  width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#000000" style="border-radius: 5px; overflow:hidden;">
        <tr style="visibility: hidden;">
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="15%"></td>
          <td width="10%"></td>
          <td width="5%"></td>
          <td width="7%"></td>
          <td width="12%"></td>
        </tr>
          <tr>
            <td colspan="1" style="padding:8px; background-color:#353940; color:#fff;">SN</td>
            <td colspan="8" style="padding:8px; background-color:#353940; color:#fff;">Particular</td>
  
            <td align="right" style="padding:8px; background-color:#353940; color:#fff;">Amount</td>
          </tr>
          <tr >
            <td  >1</td>
            <td colspan="8"><textarea class="particularcls" name="particularsubject" id="particularsubject" style="width:99%;height:40px;"><?php echo $subject; ?></textarea></td>
            <td align="right"><strong><?php 
					        echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCostWithMarkup),2); ?></strong></td>
          </tr>
          <?php if($nonTaxableAMT>0){ ?> 
          <tr >
                <td colspan="6" style="border-bottom:0px solid #fff;"></td>
                <td align="right" colspan="3"><strong>Non Taxable Amount</strong></td>
                <td align="right"> <strong><?php echo round($nonTaxableAMT,2);?></strong></td>
        
          </tr>
          <?php } ?>

          <tr >
                <td colspan="6" style="border-top:0px solid #fff; border-bottom:0px solid #fff;"></td>
                <td align="right" colspan="3"><strong>Taxable Amount</strong></td>
                <td align="right"> <strong><?php echo round($taxableAMT,2);?></strong></td>
        
          </tr>
          <tr >
                <td colspan="6" style="border-top:0px solid #fff; border-bottom:0px solid #fff;"></td>
                <td align="right" colspan="3"><strong>
                  
                <?php 
                if($financeresult333['taxType'] == 1){ echo 'GST'; }elseif($financeresult333['taxType'] == 2){ echo 'VAT ('.$serviceTax.'%)'; }else{ echo 'Tax ('.($serviceTax).'%)'; } 
                ?>
                <!-- VAT (<?php echo $serviceTax; ?>%) -->
              
              
              </strong></td>
                <td align="right"><strong><?php echo round($totalServiceTaxCost,2); ?></strong></td>
        
          </tr>
          <tr >
                <td colspan="6" style="border-top:0px solid #fff;"></td>
                <td align="right" colspan="3"><strong>Total Amount</strong></td>
                <td align="right"> <strong><?php echo $totalClientCostInWord = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCost),2);?></strong></td>
        
          </tr>
        </table>

    </td>
  </tr>
      <?php
    }else{
    ?>            
  <tr>
    <td align="left" valign="top" style="padding:10px 0px 5px;">

      <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#000000" style="border-radius: 5px; overflow:hidden;">
        <tr>
          <td style="padding:8px; background-color:#353940; color:#fff;">SN</td>
          <td style="padding:8px; background-color:#353940; color:#fff;">particulars</td>
          <td style="padding:8px; background-color:#353940; color:#fff;">HSN/SAC</td>
          <td align="center"  style="padding:8px; background-color:#353940; color:#fff;min-width: 70px;">Amount</td>
          <td align="center"  style="padding:8px; background-color:#353940; color:#fff;">TCS(%)</td>
          <td align="center"  style="padding:8px; background-color:#353940; color:#fff;">TAX(%)</td>
          <td align="right"  style="padding:8px; background-color:#353940; color:#fff;">Total Amount</td>
        </tr>
        <tr>
          <td  valign="top"><?php echo '1'; ?>  </td>
          <td height="100" width="200" valign="top" >
            <textarea class="particularcls" name="particularsubject" id="particularsubject" cols="32" rows="8"><?php echo $subject; ?></textarea>
          </td>
          <td  valign="middle">
            <select class="particularcls form-control" name="hsnCode" id="hsnCode">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select>
          </td>
          <td align="right" valign="middle"><?php echo round($totalClientCostWithMarkup); ?></td>
          <td align="center"  valign="middle"><?php echo round($totalTCSCost); ?></td>
          <td align="center"  valign="middle"><?php echo round($totalServiceTaxCost); ?></td>
          <!-- <td align="center" ><?php echo $noofpax; ?></td> -->
          <!-- <td align="center" ><?php echo $noofpax; ?></td> -->
          <td align="right" valign="middle"><?php echo round($totalClientCost); ?></td>
        </tr>
      </table>
      <?php   
    
      ?>


      <?php
    // }
    
    ?>
     <!-- Total invoice end -->
    </td>
  </tr>

  <tr>
    <td align="left" valign="top">
      <table border="0" align="right" cellpadding="0" cellspacing="0" style="font-size: 15px;">
        <?php if($totalClientCostWithMarkup>0){ ?>    
          <tr>
            <td align="right" style="padding:8px;">Total Tour Cost(<?php echo getCurrencyName($baseCurrencyId); ?>)</td>
              <td align="right" style="padding:8px; width:60px;"><span  style="font-weight:bold;"><?php echo round($totalClientCostWithMarkup); ?></span>     
            </td>
          </tr>    
        <?php } ?> 
        <?php if($gstType==1){ ?>  
          <tr>
            <td align="right" style="padding:8px;">CGST <?php echo ($serviceTax/2); ?>% </td>
              <td align="right" style="padding:8px;"><strong><?php echo $cgstCost=round($totalServiceTaxCost/2); ?></strong>
              <input name="cgst" type="hidden" id="cgst" value="<?php echo $cgstCost; ?>" />
            </td>
            </tr>
        <?php } ?>
        <?php if($gstType==1){ ?>  
          <tr>
            <td align="right" style="padding:8px;">SGST <?php echo ($serviceTax/2); ?>% </td>
              <td align="right" style="padding:8px;"><strong><?php echo $sgstCost=round($totalServiceTaxCost/2); ?></strong>
              <input name="cgst" type="hidden" id="cgst" value="<?php echo $sgstCost; ?>" />
            </td>
          </tr>
        <?php } ?>
        <?php if($gstType==2){ ?>
          <tr>
            <td align="right" style="padding:8px;"><span class="header">IGST <?php echo $serviceTax; ?>% </span></td>
              <td align="right" style="padding:8px;"><strong><?php echo $igstCost=round($totalServiceTaxCost); ?></strong>
              <input name="igst" type="hidden" id="igst" value="<?php echo $igstCost; ?>" />
            </td>
          </tr>
        <?php } ?> 
        <?php if($gstType==3){ ?>
          <tr>
            <td align="right" style="padding:8px;"><span class="header">GST <?php echo $serviceTax; ?>% </span></td>
              <td align="right" style="padding:8px;"><strong><?php echo $gstCost=round($totalServiceTaxCost); ?></strong>
              <input name="gstVal" type="hidden" id="gstVal" value="<?php echo $gstCost; ?>" />
            </td>
          </tr>
        <?php } ?> 
        <?php if($totalTCSCost!=0){  ?>
         <tr>
            <td align="right" style="padding:8px;"><span class="header">TCS <?php if($tcsTax>0){ echo $tcsTax.'%'; } ?> </span></td>
              <td align="right" style="padding:8px;"><strong><?php echo $tcsCost=round($totalTCSCost); ?></strong>
              <input name="tcs" type="hidden" id="tcs" value="<?php echo $tcsCost; ?>" />
            </td>
          </tr>
        <?php } ?>
        
        <tr>
          <td align="right" style="padding:8px;">Total&nbsp;Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>) </td>
          <td align="right" style="padding:8px;"><strong><?php echo  round($totalClientCost); ?></strong></td>
        </tr> 
        <?php if($currencyId <> $baseCurrencyId){ ?>
        <tr>
          <td align="right" style="padding:8px;">Total&nbsp;Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($currencyId); ?>) </td>
          <td align="right" style="padding:8px;">
            <strong><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCost);  ?>
              <input name="totalVal" type="hidden" id="totalVal" value="<?php echo $totalClientCost; ?>" />
            </strong>
          </td>
        </tr>
        <?php } ?>
      </table>
    </td>
  </tr>

  <?php
  }


 }elseif($invmData['invoiceFormat']=='2'){ ?>


    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#ccc" style="border-radius: 5px; overflow:hidden;margin-top: 20px;">
        <tr>
         
          <td style="padding:8px; background-color:#353940; color:#fff;width: 45%;">Particulars</td>
          <td style="padding:8px; background-color:#353940; color:#fff;">HSN/SAC</td>
          <td align="center"  style="padding:8px; background-color:#353940; color:#fff;min-width: 70px;">PP&nbsp;Cost</td>
          <td align="center"  style="padding:8px; background-color:#353940; color:#fff;">No. Of Pax</td>
          
          <td align="right"  style="padding:8px; background-color:#353940; color:#fff;">Total Amount</td>
        </tr>
        <?php 
        $hsn = 0;
        // $rs1 = GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and manualStatus="3" group by hotelId order by fromDate asc');
        // if(mysqli_num_rows($rs1)>0){
        //   $hsn = 1;
        // while($finalQuoteHotel = mysqli_fetch_array($rs1)){
          $c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="' . $quotationId . '"');
          $serviceMarkuD = mysqli_fetch_array($c12);
          
          $isUni_Mark = $quotationData['isUni_Mark'];
          $isSer_Mark = $quotationData['isSer_Mark'];
          if($isSer_Mark == 1 && $isUni_Mark == 0){
            $hotel = $serviceMarkuD['hotel'];
            $hotelMarkupType = $serviceMarkuD['hotelMarkupType'];
            $transfer = $serviceMarkuD['transfer'];
            $transferMarkupType = $serviceMarkuD['transferMarkupType'];
            $ferry = $serviceMarkuD['ferry'];
            $ferryMarkupType = $serviceMarkuD['ferryMarkupType'];
            $train = $serviceMarkuD['train'];
            $trainMarkupType = $serviceMarkuD['trainMarkupType'];
            $flight = $serviceMarkuD['flight'];
            $flightMarkupType = $serviceMarkuD['flightMarkupType'];
            $guide = $serviceMarkuD['guide'];
            $guideMarkupType = $serviceMarkuD['guideMarkupType'];
            $activity = $serviceMarkuD['activity'];
            $activityMarkupType = $serviceMarkuD['activityMarkupType'];
            $entrance = $serviceMarkuD['entrance'];
            $entranceMarkupType = $serviceMarkuD['entranceMarkupType'];
            $restaurant = $serviceMarkuD['restaurant'];
            $restaurantMarkupType = $serviceMarkuD['restaurantMarkupType'];
            $visa = $serviceMarkuD['visa'];
            $visaMarkupType = $serviceMarkuD['visaMarkupType'];
            $passport = $serviceMarkuD['passport'];
            $passportMarkupType = $serviceMarkuD['passportMarkupType'];
            $insurance = $serviceMarkuD['insurance'];
            $insuranceMarkupType = $serviceMarkuD['insuranceMarkupType'];
            $other = $serviceMarkuD['other']; 
            $otherMarkupType = $serviceMarkuD['otherMarkupType']; 
            // $markupType = $serviceMarkuD['hotelMarkupType'];
        }else{
            $serviceMarkup = $serviceMarkuD['hotel'];
            $markupType = $serviceMarkuD['hotelMarkupType'];
        }
          
        $rs11 = GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and manualStatus="3" group by hotelId,destinationId order by fromDate asc');
        if(mysqli_num_rows($rs11)>0){
          $hsn = 1;
        while($finalQuoteHotelRate1 = mysqli_fetch_array($rs11)){

          $rs1 = GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and hotelId="'.$finalQuoteHotelRate1['hotelId'].'"  order by fromDate asc');
          while($finalQuoteHotelRate = mysqli_fetch_array($rs1)){

            $rs2 = GetPageRecord('*','packageBuilderHotelMaster','id="'.$finalQuoteHotelRate['hotelId'].'"');
            $hotelData = mysqli_fetch_assoc($rs2);

            $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$hsn.'" and serviceType="hotel"');
            $invoiceDetail = mysqli_fetch_assoc($invD);

            $rs22 = GetPageRecord('*','roomTypeMaster','id="'.$finalQuoteHotelRate['roomType'].'"');
            $roomTypeD = mysqli_fetch_assoc($rs22);

                $totalsingle = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomSingleCost'])*$finalQuoteHotelRate['roomSingle']);
              
								$totaldouble = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomDoubleCost'])*$finalQuoteHotelRate['roomDouble']);

								$tatalTriple = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomTripleCost'])*$finalQuoteHotelRate['roomTriple']);
              
                
								$tatalTwin = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomTwinCost'])*$finalQuoteHotelRate['roomTwin']);

								$tatalEBedC = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomEBedCCost'])*$finalQuoteHotelRate['roomEBedC']);

								$tatalENBedC = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomENBedCCost'])*$finalQuoteHotelRate['roomENBedC']);
								
								$tatalEBedA = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomEBedACost'])*$finalQuoteHotelRate['roomEBedA']);

								$totalquadRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['quadRoomCost'])*$finalQuoteHotelRate['quadNoofRoom']);

								$totalteenRoom = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['teenRoomCost'])*$finalQuoteHotelRate['teenNoofRoom'];

								$totalsixBedRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['sixBedRoomCost'])*$finalQuoteHotelRate['sixNoofBedRoom']);

								$totaleightBedRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['eightBedRoomCost'])*$finalQuoteHotelRate['eightNoofBedRoom']);

								$totaltenBedRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tenBedRoomCost'])*$finalQuoteHotelRate['tenNoofBedRoom']);
								
								if($finalQuoteHotelRate['complimentaryBreakfast'] == 1){
									$BreakfastCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['BreakfastCost']);
								}
								if($finalQuoteHotelRate['complimentaryLunch'] == 1){
									$LunchCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['LunchCost']);
								}
								if($finalQuoteHotelRate['complimentaryDinner'] == 1){
									$DinnerCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['DinnerCost']); 
								}
								if($finalQuoteHotelRate['isChildDinner'] == 1){
									$childDinnerCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childDinnerCost']); 
								}
								if($finalQuoteHotelRate['isChildLunch'] == 1){
									$childLunchCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childLunchCost']); 
								}
								if($finalQuoteHotelRate['isChildBreakfast'] == 1){
									$childBreakfastCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childBreakfastCost']); 
								}

                $totalComplimentaryA = $LunchCost+$DinnerCost+$BreakfastCost;
                $totalComplimentaryC = $childDinnerCost+$childLunchCost+$childBreakfastCost;
                // Get Markup 
                
                
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                  $complemetaryMarkupC = getMarkupCost($totalComplimentaryC, $hotel, $hotelMarkupType);
                  $complemetaryMarkupA = getMarkupCost($totalComplimentaryA, $hotel, $hotelMarkupType);
                  $singleMarkup = getMarkupCost($totalsingle, $hotel, $hotelMarkupType);
                  $doubleMarkup = getMarkupCost($totaldouble, $hotel, $hotelMarkupType);
                  $tripleMarkup = getMarkupCost($tatalTriple, $hotel, $hotelMarkupType);
                  $twinMarkup = getMarkupCost($tatalTwin, $hotel, $hotelMarkupType);
                  $eBEDCMarkup = getMarkupCost($tatalEBedC, $hotel, $hotelMarkupType);
                  $eBEDAMarkup = getMarkupCost($tatalEBedA, $hotel, $hotelMarkupType);
                  $eNBEDCMarkup = getMarkupCost($tatalENBedC, $hotel, $hotelMarkupType);
                  $quadMarkup = getMarkupCost($totalquadRoom, $hotel, $hotelMarkupType);
                  $teenMarkup = getMarkupCost($totalteenRoom, $hotel, $hotelMarkupType);
                  $sixMarkup = getMarkupCost($totalsixBedRoom, $hotel, $hotelMarkupType);
                  $eightMarkup = getMarkupCost($totaleightBedRoom, $hotel, $hotelMarkupType);
                  $tenMarkup = getMarkupCost($totaltenBedRoom, $hotel, $hotelMarkupType);
                  }else{
                  $complemetaryMarkupA = getMarkupCost($totalComplimentaryA, $serviceMarkup, $markupType);
                  $complemetaryMarkupC = getMarkupCost($totalComplimentaryC, $serviceMarkup, $markupType);
                  $twinMarkup = getMarkupCost($tatalTwin, $serviceMarkup, $markupType);
                  $eBEDAMarkup = getMarkupCost($tatalEBedA, $serviceMarkup, $markupType);
                  $eNBEDCMarkup = getMarkupCost($tatalENBedC, $serviceMarkup, $markupType);
                  $eBEDCMarkup = getMarkupCost($tatalEBedC, $serviceMarkup, $markupType);
                  $singleMarkup = getMarkupCost($totalsingle, $serviceMarkup, $markupType);
                  $doubleMarkup = getMarkupCost($totaldouble, $serviceMarkup, $markupType);
                  $tripleMarkup = getMarkupCost($tatalTriple, $serviceMarkup, $markupType);
                  $quadMarkup = getMarkupCost($totalquadRoom, $serviceMarkup, $markupType);
                  $teenMarkup = getMarkupCost($totalteenRoom, $serviceMarkup, $markupType);
                  $sixMarkup = getMarkupCost($totalsixBedRoom, $serviceMarkup, $markupType);
                  $eightMarkup = getMarkupCost($totaleightBedRoom, $serviceMarkup, $markupType);
                  $tenMarkup = getMarkupCost($totaltenBedRoom, $serviceMarkup, $markupType);
                 }

                 $totalComplimentaryCostA = $complemetaryMarkupA+$totalComplimentaryA;
                 $totalComplimentaryCostC = $complemetaryMarkupC+$totalComplimentaryC;
                 $tatalSingleCost = $singleMarkup+$totalsingle;
                 $tatalDoubleCost = $doubleMarkup+$totaldouble;
                 $tatalTripleCost = $tripleMarkup+$tatalTriple;
                 $tatalTwinCost = $twinMarkup+$tatalTwin;
                 $tatalENBedCCost = $eNBEDCMarkup+$tatalENBedC;
                 $tatalEBedACost = $eBEDAMarkup+$tatalEBedA;
                 $tatalEBedCCost = $eBEDCMarkup+$tatalEBedC;
                 $totalquadRoomCost = $quadMarkup+$totalquadRoom;
                 $totalteenRoomCost = $teenMarkup+$totalteenRoom;
                 $totalsixBedRoomCost = $sixMarkup+$totalsixBedRoom;
                 $totaleightBedRoom = $eightMarkup+$totaleightBedRoom;
                 $totaltenBedRoomCost = $tenMarkup+$totaltenBedRoom;

                $roomSingleCostA = $tatalSingleCost + $totalComplimentaryCostA;
                $roomDoubleCostA= $tatalDoubleCost+$totalComplimentaryCostA;
                $roomTripleCostA= $tatalTripleCost+$totalComplimentaryCostA;
                $roomTwinCostA= $tatalTwinCost+$totalComplimentaryCostA;
                $roomEBedACostA= $tatalEBedACost+$totalComplimentaryCostA;
                $roomEBedCCostC= $tatalEBedCCost+$totalComplimentaryCostC;
                $roomEBedNCostC= $tatalENBedCCost+$totalComplimentaryCostC;
                $roomquadRoomCost= $totalquadRoomCost+$totalComplimentaryCostA;
                $sixBedRoomCost= $totalsixBedRoomCost+$totalComplimentaryCostA;
                $eightBedRoomCost= $totaleightBedRoomCost+$totalComplimentaryCostA;
                $tenBedRoomCost= $totaltenBedRoomCost+$totalComplimentaryCostA;
                
                $hperPersonCost = $totalServiceCost/$totalPax;
                
                if($invoiceDetail['sglParticular']!=''){
                  $sglParticular = $invoiceDetail['sglParticular'];
                }else{
                  $sglParticular = $hotelData['hotelName'].'/'.$roomTypeD['name'].'/SGL';
                }

                if($invoiceDetail['sglhsnId']!=''){
                  $sglhsnId = $invoiceDetail['sglhsnId'];
                }else{
                  $sglhsnId = '';
                }

                if($invoiceDetail['dblhsnId']!=''){
                  $dblhsnId = $invoiceDetail['dblhsnId'];
                }else{
                  $dblhsnId = '';
                }

                if($invoiceDetail['tplhsnId']!=''){
                  $tplhsnId = $invoiceDetail['tplhsnId'];
                }else{
                  $tplhsnId = '';
                }

                if($invoiceDetail['dblParticular']!=''){
                  $dblParticular = $invoiceDetail['dblParticular'];
                }else{
                  $dblParticular = $hotelData['hotelName'].'/'.$roomTypeD['name'].'/DBL';
                }

                if($invoiceDetail['tplParticular']!=''){
                  $tplParticular = $invoiceDetail['tplParticular'];
                }else{
                  $tplParticular = $hotelData['hotelName'].'/'.$roomTypeD['name'].'/TPL';
                }

                if($invoiceDetail['twinParticular']!=''){
                  $twinParticular = $invoiceDetail['twinParticular'];
                }else{
                  $twinParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/TWIN';
                }

                if($invoiceDetail['twinhsnId']!=''){
                  $twinhsnId = $invoiceDetail['twinhsnId'];
                }else{
                  $twinhsnId =  '';
                }

                if($invoiceDetail['EBAParticular']!=''){
                  $EBAParticular = $invoiceDetail['EBAParticular'];
                }else{
                  $EBAParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/EBedA';
                }

                if($invoiceDetail['EBAhsnId']!=''){
                  $EBAhsnId = $invoiceDetail['EBAhsnId'];
                }else{
                  $EBAhsnId =  '';
                }

                if($invoiceDetail['EBCParticular']!=''){
                  $EBCParticular = $invoiceDetail['EBCParticular'];
                }else{
                  $EBCParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/EBedC';
                }

                if($invoiceDetail['EBChsnId']!=''){
                  $EBChsnId = $invoiceDetail['EBChsnId'];
                }else{
                  $EBChsnId =  '';
                }

                if($invoiceDetail['EBNParticular']!=''){
                  $EBNParticular = $invoiceDetail['EBNParticular'];
                }else{
                  $EBNParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/ENBedC';
                }

                if($invoiceDetail['EBNhsnId']!=''){
                  $EBNhsnId = $invoiceDetail['EBNhsnId'];
                }else{
                  $EBNhsnId =  '';
                }

                if($invoiceDetail['quadParticular']!=''){
                  $quadParticular = $invoiceDetail['quadParticular'];
                }else{
                  $quadParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/QUAD';
                }

                if($invoiceDetail['quadhsnId']!=''){
                  $quadhsnId = $invoiceDetail['quadhsnId'];
                }else{
                  $quadhsnId =  '';
                }

                if($invoiceDetail['sixParticular']!=''){
                  $sixParticular = $invoiceDetail['sixParticular'];
                }else{
                  $sixParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/SIX';
                }

                if($invoiceDetail['sixhsnId']!=''){
                  $sixhsnId = $invoiceDetail['sixhsnId'];
                }else{
                  $sixhsnId =  '';
                }

                if($invoiceDetail['eightParticular']!=''){
                  $eightParticular = $invoiceDetail['eightParticular'];
                }else{
                  $eightParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/EIGHT';
                }

                if($invoiceDetail['eighthsnId']!=''){
                  $eighthsnId = $invoiceDetail['eighthsnId'];
                }else{
                  $eighthsnId =  '';
                }

                if($invoiceDetail['tenParticular']!=''){
                  $tenParticular = $invoiceDetail['tenParticular'];
                }else{
                  $tenParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/TEN';
                }

                if($invoiceDetail['tenhsnId']!=''){
                  $tenhsnId = $invoiceDetail['tenhsnId'];
                }else{
                  $tenhsnId =  '';
                }
                
                if($finalQuoteHotelRate['roomSingle']>0 && $roomSingleCostA>0){

        ?>

        <tr>
          <td><input type="text" name="hotelsglroom<?php echo $hsn; ?>" class="particularcls form-control" id="hotelsglroom<?php echo $hsn; ?>" value="<?php echo $sglParticular; ?>"></td>

          <td><select class="particularcls form-control" name="sglHsnCode<?php echo $hsn; ?>" id="sglHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($sglhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select>
          </td>

          <td align="right"><?php echo $sglPPCost = round($roomSingleCostA/$finalQuoteHotelRate['roomSingle'],2); ?></td>
          <td align="center"><?php echo $finalQuoteHotelRate['roomSingle']; ?></td>
          <td align="right"><?php echo $serviceCostsgl = $roomSingleCostA; ?></td>

          <input type="hidden" name="sglPPCost<?php echo $hsn; ?>" id="sglPPCost<?php echo $hsn; ?>" value="<?php echo $sglPPCost; ?>">
          <input type="hidden" name="sglTotalCost<?php echo $hsn; ?>" id="sglTotalCost<?php echo $hsn; ?>" value="<?php echo $roomSingleCostA; ?>">
        </tr>
       <?php
      //  $totalServiceCost = $totalServiceCost+$serviceCostsgl;
      
        } 

        if($finalQuoteHotelRate['roomDouble']>0 && $roomDoubleCostA>0){

          ?>

          <tr>
            <td><input type="text" name="hoteldblroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteldblroom<?php echo $hsn; ?>" value="<?php echo $dblParticular; ?>"></td>

            <td><select class="particularcls form-control" name="dblHsnCode<?php echo $hsn; ?>" id="dblHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($dblhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $doublA = $finalQuoteHotelRate['roomDouble']*2; ?>
            <td align="right"><?php echo $dblPPcost = round($roomDoubleCostA/$doublA,2); ?></td>
            <td align="center"><?php echo $doublA; ?></td>
            <td align="right"><?php echo $serviceCostdbl = $roomDoubleCostA; ?></td>

            <input type="hidden" name="dblPPCost<?php echo $hsn; ?>" id="dblPPCost<?php echo $hsn; ?>" value="<?php echo $dblPPcost; ?>">
          <input type="hidden" name="dblTotalCost<?php echo $hsn; ?>" id="dblTotalCost<?php echo $hsn; ?>" value="<?php echo $roomDoubleCostA; ?>">
          </tr>
        <?php 
        
        // echo $totalServiceCost = $totalServiceCost+$serviceCostdbl;
          
      } 
       
      if($finalQuoteHotelRate['roomTriple']>0 && $roomTripleCostA>0){

        ?>

        <tr>
          <td><input type="text" name="hoteltplroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteltplroom<?php echo $hsn; ?>" value="<?php echo $tplParticular ; ?>"></td>

          <td><select class="particularcls form-control" name="tplHsnCode<?php echo $hsn; ?>" id="tplHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($tplhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $tripleA = $finalQuoteHotelRate['roomTriple']*3; ?>
          <td align="right"><?php echo $tplPPCost = round($roomTripleCostA/$tripleA,2); ?></td>
          <td align="center"><?php echo $tripleA; ?></td>
          <td align="right"><?php echo $serviceCosttpl = $roomTripleCostA; ?></td>

          <input type="hidden" name="tplPPCost<?php echo $hsn; ?>" id="tplPPCost<?php echo $hsn; ?>" value="<?php echo $tplPPCost; ?>">
          <input type="hidden" name="tplTotalCost<?php echo $hsn; ?>" id="tplTotalCost<?php echo $hsn; ?>" value="<?php echo $roomTripleCostA; ?>">
        </tr>
      <?php 
    } 

    if($finalQuoteHotelRate['roomTwin']>0 && $roomTwinCostA>0){

      ?>

      <tr>
        <td><input type="text" name="hoteltwinroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteltwinroom<?php echo $hsn; ?>" value="<?php echo $twinParticular; ?>"></td>

        <td><select class="particularcls form-control" name="twinHsnCode<?php echo $hsn; ?>" id="twinHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($twinhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $twinA = $finalQuoteHotelRate['roomTwin']*2; ?>
        <td align="right"><?php echo $twinPPCost = round($roomTwinCostA/$twinA,2); ?></td>
        <td align="center"><?php echo $twinA; ?></td>
        <td align="right"><?php echo $serviceCosttwin = $roomTwinCostA; ?></td>

        <input type="hidden" name="twinPPCost<?php echo $hsn; ?>" id="twinPPCost<?php echo $hsn; ?>" value="<?php echo $twinPPCost; ?>">
          <input type="hidden" name="twinTotalCost<?php echo $hsn; ?>" id="twinTotalCost<?php echo $hsn; ?>" value="<?php echo $roomTwinCostA; ?>">
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['roomEBedA']>0 && $roomEBedACostA>0){

      ?>

 
      <tr>
        <td><input type="text" name="hotelebedroom<?php echo $hsn; ?>" class="particularcls form-control" id="hotelebedroom<?php echo $hsn; ?>" value="<?php echo $EBAParticular;  ?>"></td>

        <td><select class="particularcls form-control" name="EBAHsnCode<?php echo $hsn; ?>" id="EBAHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($EBAhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $EBedA = $finalQuoteHotelRate['roomEBedA']; ?>
        <td align="right"><?php echo $EBAPPCost = round($roomEBedACostA/$EBedA,2); ?></td>
        <td align="center"><?php echo $EBedA ?></td>
        <td align="right"><?php echo $serviceCosteBedA = $roomEBedACostA; ?></td>

        <input type="hidden" name="EBAPPCost<?php echo $hsn; ?>" id="EBAPPCost<?php echo $hsn; ?>" value="<?php echo $EBAPPCost; ?>">
          <input type="hidden" name="EBATotalCost<?php echo $hsn; ?>" id="EBATotalCost<?php echo $hsn; ?>" value="<?php echo $roomEBedACostA; ?>">
      </tr>
    <?php 
    } 
  
    if($finalQuoteHotelRate['roomEBedC']>0 && $roomEBedCCostC>0){

      ?>
      <tr>
        <td><input type="text" name="hoteleBCroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteleBCroom<?php echo $hsn; ?>" value="<?php echo $EBCParticular; ?>"></td>

        <td><select class="particularcls form-control" name="EBCHsnCode<?php echo $hsn; ?>" id="EBCHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($EBChsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $EBedC = $finalQuoteHotelRate['roomEBedC']; ?>
        <td align="right"><?php echo $EBCPPCost = round($roomEBedCCostC/$EBedC,2); ?></td>
        <td align="center"><?php echo $EBedC; ?></td>
        <td align="right"><?php echo $serviceCosteBedC = $roomEBedCCostC; ?></td>

        <input type="hidden" name="EBCPPCost<?php echo $hsn; ?>" id="EBCPPCost<?php echo $hsn; ?>" value="<?php echo $EBCPPCost; ?>">
        <input type="hidden" name="EBCTotalCost<?php echo $hsn; ?>" id="EBCTotalCost<?php echo $hsn; ?>" value="<?php echo $roomEBedCCostC; ?>">
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['roomENBedC']>0 && $roomEBedNCostC>0){

      ?>
      

      <tr>
        <td><input type="text" name="hoteleNBroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteleNBroom<?php echo $hsn; ?>" value="<?php echo $EBNParticular; ?>"></td>

        <td><select class="particularcls form-control" name="ENBHsnCode<?php echo $hsn; ?>" id="ENBHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($EBNhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $ENBedC = $finalQuoteHotelRate['roomENBedC']; ?>
        <td align="right"><?php echo $ENBCPPCost = round($roomEBedNCostC/$ENBedC,2); ?></td>
        <td align="center"><?php echo $ENBedC; ?></td>
        <td align="right"><?php echo $serviceCosteNBedC = $roomEBedNCostC; ?></td>

        <input type="hidden" name="ENBCPPCost<?php echo $hsn; ?>" id="ENBCPPCost<?php echo $hsn; ?>" value="<?php echo $ENBCPPCost; ?>">
        <input type="hidden" name="ENBCTotalCost<?php echo $hsn; ?>" id="ENBCTotalCost<?php echo $hsn; ?>" value="<?php echo $roomEBedNCostC; ?>">
      </tr>
    <?php 
    } 

 

    if($finalQuoteHotelRate['quadNoofRoom']>0 && $roomquadRoomCost>0){

      ?>
     

      <tr>
        <td><input type="text" name="hoteleQuadroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteleQuadroom<?php echo $hsn; ?>" value="<?php echo $quadParticular;  ?>"></td>

        <td><select class="particularcls form-control" name="quadHsnCode<?php echo $hsn; ?>" id="quadHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($quadhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?>  ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $quadNoof = ($finalQuoteHotelRate['quadNoofRoom']*4); ?>
        <td align="right"><?php echo $quadPPCost = round($roomquadRoomCost/$quadNoof,2); ?></td>
        <td align="center"><?php echo $quadNoof; ?></td>
        <td align="right"><?php echo $serviceCosteQuad = $roomquadRoomCost; ?></td>

        <input type="hidden" name="quadPPCost<?php echo $hsn; ?>" id="quadPPCost<?php echo $hsn; ?>" value="<?php echo $quadPPCost; ?>">
        <input type="hidden" name="quadTotalCost<?php echo $hsn; ?>" id="quadTotalCost<?php echo $hsn; ?>" value="<?php echo $roomquadRoomCost; ?>">
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['sixNoofBedRoom']>0 && $sixBedRoomCost>0){

      ?>
    
      <tr>
        <td><input type="text" name="hoteleSixroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteleSixroom<?php echo $hsn; ?>" value="<?php echo $sixParticular; ?>"></td>

        <td><select class="particularcls form-control" name="sixHsnCode<?php echo $hsn; ?>" id="sixHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($sixhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $sixNoof = ($finalQuoteHotelRate['sixNoofBedRoom']*6); ?>
        <td align="right"><?php echo $sixPPCost= round($sixBedRoomCost/$sixNoof); ?></td>
        <td align="center"><?php echo $sixNoof; ?></td>
        <td align="right"><?php echo $serviceCosteSix = $sixBedRoomCost; ?></td>

        <input type="hidden" name="sixPPCost<?php echo $hsn; ?>" id="sixPPCost<?php echo $hsn; ?>" value="<?php echo $sixPPCost; ?>">
        <input type="hidden" name="sixTotalCost<?php echo $hsn; ?>" id="sixTotalCost<?php echo $hsn; ?>" value="<?php echo $sixBedRoomCost; ?>">
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['eightNoofBedRoom']>0 && $eightBedRoomCost>0){

      ?>
  
      <tr>
        <td><input type="text" name="hoteleEightroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteleEightroom<?php echo $hsn; ?>" value="<?php echo $eightParticular; ?>" ></td>

        <td><select class="particularcls form-control" name="eightHsnCode<?php echo $hsn; ?>" id="eightHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($eighthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $eightNoof = ($finalQuoteHotelRate['eightNoofBedRoom']*8); ?>
        <td align="right"><?php echo $eightPPCost = round($eightBedRoomCost/$eightNoof,2); ?></td>
        <td align="center"><?php echo $eightNoof; ?></td>
        <td align="right"><?php echo $serviceCosteEight = $eightBedRoomCost; ?></td>

        <input type="hidden" name="eightPPCost<?php echo $hsn; ?>" id="eightPPCost<?php echo $hsn; ?>" value="<?php echo $eightPPCost; ?>">
        <input type="hidden" name="eightTotalCost<?php echo $hsn; ?>" id="eightTotalCost<?php echo $hsn; ?>" value="<?php echo $eightBedRoomCost; ?>">
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['tenNoofBedRoom']>0 && $tenBedRoomCost>0){

      ?>
      
      <tr>
        <td><input type="text" name="hoteleTenroom<?php echo $hsn; ?>" class="particularcls form-control" id="hoteleTenroom<?php echo $hsn; ?>" value="<?php echo $tenParticular ; ?>" style="width: 97%;padding: 4px;"></td>

        <td><select class="particularcls form-control" name="tenHsnCode<?php echo $hsn; ?>" id="tenHsnCode<?php echo $hsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="hotel"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($tenhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
            <?php $tenNoof = ($finalQuoteHotelRate['tenNoofBedRoom']*10); ?>
        <td align="right"><?php echo $tenPPCost = ($tenBedRoomCost/$tenNoof); ?></td>
        <td align="center"><?php echo $tenNoof; ?></td>
        <td align="right"><?php echo $serviceCosteTen = $tenBedRoomCost; ?></td>

        <input type="hidden" name="tenPPCost<?php echo $hsn; ?>" id="tenPPCost<?php echo $hsn; ?>" value="<?php echo $tenPPCost; ?>">
        <input type="hidden" name="tenTotalCost<?php echo $hsn; ?>" id="tenTotalCost<?php echo $hsn; ?>" value="<?php echo $tenBedRoomCost; ?>">
      </tr>
      
    <?php 
    } 
        $totalHotelServiceCost = $serviceCostsgl+$serviceCostdbl+$serviceCosttpl+$serviceCosttwin+$serviceCosteBedA+$serviceCosteBedC+$serviceCosteNBedC+$serviceCosteQuad+$serviceCosteSix+$serviceCosteEight+$serviceCosteTen;

        $grandHotelServiceCost=$grandHotelServiceCost+$totalHotelServiceCost;
  }
    $hsn++;
   } 
  }
  // }
    $tpt = 0;
    $rt1 = GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="transfer")');
    if(mysqli_num_rows($rt1)>0){
      $tpt = 1;
      while($finalQuotetransfer = mysqli_fetch_assoc($rt1)){

        $rt2 = GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuotetransfer['transferId'].'"');
        $transferData = mysqli_fetch_assoc($rt2);

        $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$tpt.'" and serviceType="transfer"');
        $invoiceDetail = mysqli_fetch_assoc($invD);

        if($finalQuotetransfer['transferType']=='1'){

          if($invoiceDetail['adultParticular']!=''){
            $adultParticular = $invoiceDetail['adultParticular'];
          }else{
            $adultParticular = $transferData['transferName'].'/SIC/Transfer';
          }
  
          if($invoiceDetail['adulthsnId']!=''){
            $adulthsnId = $invoiceDetail['adulthsnId'];
          }else{
            $adulthsnId = '';
          }

          if($invoiceDetail['childParticular']!=''){
            $childParticular = $invoiceDetail['childParticular'];
          }else{
            $childParticular = $transferData['transferName'].'/SIC/Child/Transfer';
          }
  
          if($invoiceDetail['childhsnId']!=''){
            $childhsnId = $invoiceDetail['childhsnId'];
          }else{
            $childhsnId = '';
          }
  
          if($invoiceDetail['infantParticular']!=''){
            $infantParticular = $invoiceDetail['infantParticular'];
          }else{
            $infantParticular = $transferData['transferName'].'/SIC/Infant/Transfer';
          }
  
          if($invoiceDetail['infanthsnId']!=''){
            $infanthsnId = $invoiceDetail['infanthsnId'];
          }else{
            $infanthsnId = $invoiceDetail['infanthsnId'];
          }

        $repCost = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['repCost']);
        $adultCostTPTNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['adultCost'])+$repCost;
        $childCostTPTNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['childCost'])+$repCost;
        $infantCostTPTNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['infantCost'])+$repCost;
        }else{

          $vehicleCostNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['vehicleCost'])*$finalQuotetransfer['noOfVehicles'];

          if($invoiceDetail['adultParticular']!=''){
            $adultParticular = $invoiceDetail['adultParticular'];
          }else{
            $adultParticular = $transferData['transferName'].'/PVT/Transfer';
          }
  
          if($invoiceDetail['adulthsnId']!=''){
            $adulthsnId = $invoiceDetail['adulthsnId'];
          }else{
            $adulthsnId = '';
          }

        }
        
        
        if($isSer_Mark == 1 && $isUni_Mark == 0){
          $tadultMarkup = getMarkupCost($adultCostTPTNM, $transfer, $transferMarkupType);
          $tchildMarkup = getMarkupCost($childCostTPTNM, $transfer, $transferMarkupType);
          $tinfantMarkup = getMarkupCost($infantCostTPTNM, $transfer, $transferMarkupType);
          $tvehicleMarkup = getMarkupCost($vehicleCostNM, $transfer, $transferMarkupType);
          }else{
          $tadultMarkup = getMarkupCost($adultCostTPTNM, $serviceMarkup, $markupType);
          $tchildMarkup = getMarkupCost($childCostTPTNM, $serviceMarkup, $markupType);
          $tinfantMarkup = getMarkupCost($infantCostTPTNM, $serviceMarkup, $markupType);
          $tvehicleMarkup = getMarkupCost($vehicleCostNM, $serviceMarkup, $markupType);
         }

         $adultCostTPT = $tadultMarkup+$adultCostTPTNM;
         $childCostTPT = $tchildMarkup+$childCostTPTNM;
         $infantCostTPT = $tinfantMarkup+$infantCostTPTNM;
         $vehicleCost = $tvehicleMarkup+$vehicleCostNM;

        if($finalQuotetransfer['transferType']=='1'){

        if($totalAdult>0 && $adultCostTPT>0){
        ?>
        
         <tr>
        <td><input type="text" name="transferNameA<?php echo $tpt; ?>" class="particularcls form-control" id="transferNameA<?php echo $tpt; ?>" value="<?php echo $adultParticular; ?>" ></td>

        <td><select class="particularcls form-control" name="transferHsnCodeA<?php echo $tpt; ?>" id="transferHsnCodeA<?php echo $tpt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="transfer"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>

        <td align="right"><?php echo $adultCostTPT; ?></td>
        <td align="center"><?php echo $totalAdult; ?></td>
        <td align="right"><?php echo $serviceCosteTPTA = $adultCostTPT*$totalAdult; ?></td>
      </tr>
        <?php
        }

        if($totalChild>0 && $childCostTPT>0){
          ?>
           <tr>
          <td><input type="text" name="transferNameC<?php echo $tpt; ?>" class="particularcls form-control" id="transferNameC<?php echo $tpt; ?>" value="<?php echo $childParticular; ?>"></td>
  
          <td><select class="particularcls form-control" name="transferHsnCodeC<?php echo $tpt; ?>" id="transferHsnCodeC<?php echo $tpt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="transfer"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
  
          <td align="right"><?php echo $childCostTPT; ?></td>
          <td align="center"><?php echo $totalChild; ?></td>
          <td align="right"><?php echo $serviceCosteTPTC = $childCostTPT*$totalChild; ?></td>
        </tr>
          <?php
          }

          if($totalInfant>0 && $infantCostTPT>0){
            ?>
            
             <tr>
            <td><input type="text" name="transferNameI<?php echo $tpt; ?>" class="particularcls form-control" id="transferNameI<?php echo $tpt; ?>" value="<?php echo $infantParticular; ?>" ></td>
    
            <td><select class="particularcls form-control" name="transferHsnCodeE<?php echo $tpt; ?>" id="transferHsnCodeE<?php echo $tpt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="transfer"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
    
            <td align="right"><?php echo $infantCostTPT; ?></td>
            <td align="center"><?php echo $totalInfant; ?></td>
            <td align="right"><?php echo $serviceCosteTPTI = $infantCostTPT*$totalInfant; ?></td>
          </tr>
            <?php
            }
          }else{
            if($totalPax>0 && $vehicleCost>0){
              ?>
               <tr>
              <td><input type="text" name="transferNameA<?php echo $tpt; ?>" class="particularcls form-control" id="transferNameA<?php echo $tpt; ?>" value="<?php echo $adultParticular; ?>" ></td>
      
              <td><select class="particularcls form-control" name="transferHsnCodeA<?php echo $tpt; ?>" id="transferHsnCodeA<?php echo $tpt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="transfer"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo $vehiclePPCost = round($vehicleCost/$totalPax,2); ?></td>
              <td align="center"><?php echo $totalPax; ?></td>
              <td align="right"><?php echo $serviceCosteTPTP = $vehicleCost; ?></td>
            </tr>
            
              <?php
              }
            }

            $totalTransferServiceCost = $serviceCosteTPTA+$serviceCosteTPTC+$serviceCosteTPTI+$serviceCosteTPTP;
           $grandTransferServiceCost = $grandTransferServiceCost+$totalTransferServiceCost;
      $tpt++; 
    
    }
  }

    $tptt = 0;
    $rt11 = GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="transportation")');
    if(mysqli_num_rows($rt11)>0){
      $tptt = 1;
      while($finalQuotetransportation = mysqli_fetch_assoc($rt11)){

        $rt22 = GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuotetransportation['transferId'].'"');
        $transportData = mysqli_fetch_assoc($rt22);

        $tptvehicleCostNM = convert_to_base($finalQuotetransportation['currencyValue'],$baseCurrencyVal,$finalQuotetransportation['vehicleCost'])*$finalQuotetransportation['noOfVehicles'];

        if($isSer_Mark == 1 && $isUni_Mark == 0){
          $transMarkup = getMarkupCost($tptvehicleCostNM, $transfer, $transferMarkupType);
          }else{
          $transMarkup = getMarkupCost($tptvehicleCostNM, $serviceMarkup, $markupType);
         
         }

         $tptvehicleCost = $transMarkup+$tptvehicleCostNM;
         
        $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$tptt.'" and serviceType="transportation"');
        $invoiceDetail = mysqli_fetch_assoc($invD);

          if($invoiceDetail['adultParticular']!=''){
            $adultParticular = $invoiceDetail['adultParticular'];
          }else{
            $adultParticular = $transportData['transferName'].'/Transportation';
          }
  
          if($invoiceDetail['adulthsnId']!=''){
            $adulthsnId = $invoiceDetail['adulthsnId'];
          }else{
            $adulthsnId = '';
          }

          if($totalPax>0 && $tptvehicleCost>0){
              ?>
               <tr>
              <td><input type="text" name="transportName<?php echo $tptt; ?>" class="particularcls form-control" id="transferNameI<?php echo $tptt; ?>" value="<?php echo $adultParticular; ?>" ></td>
      
              <td><select class="particularcls form-control" name="tranportHsnCode<?php echo $tptt; ?>" id="tranportHsnCode<?php echo $tptt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="transfer"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo $vehiclePPCost = round($tptvehicleCost/$totalPax,2); ?></td>
              <td align="center"><?php echo $totalPax; ?></td>
              <td align="right"><?php echo $serviceCosteTPT = $tptvehicleCost; ?></td>
            </tr>
            
              <?php
              }

                $totalTransport = $totalTransport+$serviceCosteTPT;
              
              $tptt++; }
            }
              // Entrance Services
         $esn = 0;
         $re1 = GetPageRecord('*','finalQuoteEntrance','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="entrance")');
         if(mysqli_num_rows($re1)>0){
          $esn = 1;
        while($finalQuoteEntrance = mysqli_fetch_assoc($re1)){
          $transfertype = $finalQuoteEntrance['transferType'];
          $re22 = GetPageRecord('*','packageBuilderEntranceMaster','id="'.$finalQuoteEntrance['entranceId'].'"');
         $entranceData = mysqli_fetch_assoc($re22);
        
         if($transfertype == 1){
          $entCostANM = ($finalQuoteEntrance['ticketAdultCost']+$finalQuoteEntrance['adultCost']+$finalQuoteEntrance['repCost']);  
          $entCostCNM = ($finalQuoteEntrance['ticketchildCost']+$finalQuoteEntrance['childCost']+$finalQuoteEntrance['repCost']);            
          $entCostENM = ($finalQuoteEntrance['ticketinfantCost']+$finalQuoteEntrance['infantCost']+$finalQuoteEntrance['repCost']);            
          $tptType = "SIC";
      }elseif($transfertype == 2){
          $entCostANM = ($finalQuoteEntrance['ticketAdultCost']+$finalQuoteEntrance['vehicleCost']/$totalPax)+$finalQuoteEntrance['repCost'];
          $entCostCNM = ($finalQuoteEntrance['ticketchildCost']+$finalQuoteEntrance['vehicleCost']/$totalPax)+$finalQuoteEntrance['repCost'];
          $entCostENM = ($finalQuoteEntrance['ticketinfantCost']+$finalQuoteEntrance['vehicleCost']/$totalPax)+$finalQuoteEntrance['repCost'];
          $tptType = "PVT";

      }elseif($transfertype == 3){
          $entCostANM = ($finalQuoteEntrance['ticketAdultCost']);  
          $entCostCNM = ($finalQuoteEntrance['ticketchildCost']);            
          $entCostENM = ($finalQuoteEntrance['ticketinfantCost']);  
          $tptType = "Ticket Only";
      }

      $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$esn.'" and serviceType="entrance"');
      $invoiceDetail = mysqli_fetch_assoc($invD);

      if($invoiceDetail['adultParticular']!=''){
        $adultParticular = $invoiceDetail['adultParticular'];
      }else{
        $adultParticular = $entranceData['entranceName'].'/Adult/Monument/'.$tptType;
      }

      if($invoiceDetail['adulthsnId']!=''){
        $adulthsnId = $invoiceDetail['adulthsnId'];
      }else{
        $adulthsnId = '';
      }
      
      if($invoiceDetail['childParticular']!=''){
        $childParticular = $invoiceDetail['childParticular'];
      }else{
        $childParticular =  $entranceData['entranceName'].'/Child/Monument/'.$tptType;
      }

      if($invoiceDetail['childhsnId']!=''){
        $childhsnId = $invoiceDetail['childhsnId'];
      }else{
        $childhsnId = '';
      }

      if($invoiceDetail['infantParticular']!=''){
        $infantParticular = $invoiceDetail['infantParticular'];
      }else{
        $infantParticular =  $entranceData['entranceName'].'/Infant/Monument/'.$tptType;
      }

      if($invoiceDetail['infanthsnId']!=''){
        $infanthsnId = $invoiceDetail['infanthsnId'];
      }else{
        $infanthsnId = '';
      }
       

        $totalEntCostANM = (convert_to_base($finalQuoteEntrance['currencyValue'],$baseCurrencyVal,$entCostANM));
        $totalEntCostCNM = (convert_to_base($finalQuoteEntrance['currencyValue'],$baseCurrencyVal,$entCostCNM));
        $totalEntCostENM = (convert_to_base($finalQuoteEntrance['currencyValue'],$baseCurrencyVal,$entCostENM));

        if($isSer_Mark == 1 && $isUni_Mark == 0){
          $entMarkupA = getMarkupCost($totalEntCostANM, $entrance, $entranceMarkupType);
          $entMarkupC = getMarkupCost($totalEntCostCNM, $entrance, $entranceMarkupType);
          $entMarkupE = getMarkupCost($totalEntCostENM, $entrance, $entranceMarkupType);
        
          }else{
          $entMarkupA = getMarkupCost($totalEntCostANM, $serviceMarkup, $markupType);
          $entMarkupC = getMarkupCost($totalEntCostCNM, $serviceMarkup, $markupType);
          $entMarkupE = getMarkupCost($totalEntCostENM, $serviceMarkup, $markupType);
         }
         
         $totalEntCostA = $entMarkupA+$totalEntCostANM;
         $totalEntCostC = $entMarkupC+$totalEntCostCNM;
         $totalEntCostE = $entMarkupE+$totalEntCostENM;

          if($totalAdult>0 && $totalEntCostA>0){
              ?>
               <tr>
              <td><input type="text" name="entranceNameA<?php echo $esn; ?>" class="particularcls form-control" id="entranceNameA<?php echo $esn; ?>" value="<?php echo $adultParticular; ?>"></td>
      
              <td><select class="particularcls form-control" name="entranceHsnCodeA<?php echo $esn; ?>" id="entranceHsnCodeA<?php echo $tptt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="entrance"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo round($totalEntCostA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteEntA = round($totalEntCostA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalEntCostC>0){
                ?>
               
                 <tr>
                <td><input type="text" name="entranceNameC<?php echo $esn; ?>" class="particularcls form-control" id="entranceNameC<?php echo $esn; ?>" value="<?php echo $childParticular; ?>"></td>
        
                <td><select class="particularcls form-control" name="entranceHsnCodeC<?php echo $esn; ?>" id="entranceHsnCodeC<?php echo $tptt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="entrance"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
        
                <td align="right"><?php echo round($totalEntCostC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteEntC = round($totalEntCostC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalEntCostE>0){
                  ?>
                    

                   <tr>
                  <td><input type="text" name="entranceNameI<?php echo $esn; ?>" class="particularcls form-control" id="entranceNameI<?php echo $esn; ?>" value="<?php echo $infantParticular; ?>"></td>
          
                  <td><select class="particularcls form-control" name="entranceHsnCodeE<?php echo $esn; ?>" id="entranceHsnCodeE<?php echo $tptt; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="entrance"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo round($totalEntCostE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteEntE = round($totalEntCostE*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }

                   $totalEntranceCost = $serviceCosteEntA+$serviceCosteEntC+$serviceCosteEntE;
                    $grandtotalEntranceCost = $grandtotalEntranceCost+$totalEntranceCost;
              $esn++; }
                }

                // Activity Services
         $asn = 0;
         $ra1 = GetPageRecord('*','finalQuoteActivity','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="activity")');
         if(mysqli_num_rows($ra1)>0){
          $asn = 1;
        while($finalQuoteActivity = mysqli_fetch_assoc($ra1)){
          $transfertype = $finalQuoteActivity['transferType'];
          $ra22 = GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$finalQuoteActivity['activityId'].'"');
         $activityData = mysqli_fetch_assoc($ra22);
        
         if($transfertype == 1){
            $actCostA = ($finalQuoteActivity['ticketAdultCost']+$finalQuoteActivity['adultCost']+$finalQuoteActivity['repCost']);  
            $actCostC = ($finalQuoteActivity['ticketchildCost']+$finalQuoteActivity['childCost']+$finalQuoteActivity['repCost']);            
            $actCostE = ($finalQuoteActivity['ticketinfantCost']+$finalQuoteActivity['infantCost']+$finalQuoteActivity['repCost']);                   
          $tptType = "SIC";
      }elseif($transfertype == 2){
          $actCostA = ($finalQuoteActivity['ticketAdultCost']+$finalQuoteActivity['vehicleCost']/$totalPax)+$finalQuoteActivity['repCost'];
          $actCostC = ($finalQuoteActivity['ticketchildCost']+$activityInfo['vehicleCost']/$totalPax)+$finalQuoteActivity['repCost'];
          $actCostE = ($finalQuoteActivity['ticketinfantCost']+$finalQuoteActivity['vehicleCost']/$totalPax)+$finalQuoteActivity['repCost'];
          $tptType = "PVT";

      }elseif($transfertype == 3){
          $actCostA = ($finalQuoteActivity['ticketAdultCost']);  
          $actCostC = ($finalQuoteActivity['ticketchildCost']);            
          $actCostE = ($finalQuoteActivity['ticketinfantCost']);    
          $tptType = "Ticket Only";
      }

      $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$asn.'" and serviceType="activity"');
      $invoiceDetail = mysqli_fetch_assoc($invD);

      if($invoiceDetail['adultParticular']!=''){
        $adultParticular = $invoiceDetail['adultParticular'];
      }else{
        $adultParticular = $activityData['otherActivityName'].'/Adult/SightSeeing/'.$tptType;
      }

      if($invoiceDetail['adulthsnId']!=''){
        $adulthsnId = $invoiceDetail['adulthsnId'];
      }else{
        $adulthsnId = '';
      }
      
      if($invoiceDetail['childParticular']!=''){
        $childParticular = $invoiceDetail['childParticular'];
      }else{
        $childParticular =  $activityData['otherActivityName'].'/Child/Sightseeing/'.$tptType;
      }

      if($invoiceDetail['childhsnId']!=''){
        $childhsnId = $invoiceDetail['childhsnId'];
      }else{
        $childhsnId = '';
      }

      if($invoiceDetail['infantParticular']!=''){
        $infantParticular = $invoiceDetail['infantParticular'];
      }else{
        $infantParticular =  $activityData['otherActivityName'].'/Infant/Sightseeing/'.$tptType;
      }

      if($invoiceDetail['infanthsnId']!=''){
        $infanthsnId = $invoiceDetail['infanthsnId'];
      }else{
        $infanthsnId = '';
      }

      

          $totalActCostANM = (convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$actCostA));
          $totalActCostCNM = (convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$actCostC));
          $totalActCostENM = (convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$actCostE));

          if($isSer_Mark == 1 && $isUni_Mark == 0){
            $actMarkupA = getMarkupCost($totalActCostANM, $activity, $activityMarkupType);
            $actMarkupC = getMarkupCost($totalActCostCNM, $activity, $activityMarkupType);
            $actMarkupE = getMarkupCost($totalActCostENM, $activity, $activityMarkupType);
          
            }else{
            $actMarkupA = getMarkupCost($totalActCostANM, $serviceMarkup, $markupType);
            $actMarkupC = getMarkupCost($totalActCostCNM, $serviceMarkup, $markupType);
            $actMarkupE = getMarkupCost($totalActCostENM, $serviceMarkup, $markupType);
           }
           
           $totalActCostA = $actMarkupA+$totalActCostANM;
           $totalActCostC = $actMarkupC+$totalActCostCNM;
           $totalActCostE = $actMarkupE+$totalActCostENM;

          if($totalAdult>0 && $totalActCostA>0){
              ?>
              
               <tr>
              <td><input type="text" name="activityNameA<?php echo $asn; ?>" class="particularcls form-control" id="activityNameA<?php echo $asn; ?>" value="<?php echo $adultParticular; ?>"></td>
      
              <td><select class="particularcls form-control" name="activityHsnCodeA<?php echo $asn; ?>" id="activityHsnCodeA<?php echo $asn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="activity"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo round($totalActCostA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteActA = round($totalActCostA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalActCostC>0){
                ?>
               
                 <tr>
                <td><input type="text" name="activityNameC<?php echo $asn; ?>" class="particularcls form-control" id="activityNameC<?php echo $asn; ?>" value="<?php echo $childParticular; ?>"></td>
        
                <td><select class="particularcls form-control" name="activityHsnCodeC<?php echo $asn; ?>" id="activityHsnCodeC<?php echo $asn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="activity"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
        
                <td align="right"><?php echo round($totalActCostC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteActC = round($totalActCostC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalActCostE>0){
                  ?>
                   <tr>
                  <td><input type="text" name="activityNameI<?php echo $asn; ?>" class="particularcls form-control" id="activityNameI<?php echo $asn; ?>" value="<?php echo  $infantParticular; ?>"></td>
          
                  <td><select class="particularcls form-control" name="activityHsnCodeE<?php echo $asn; ?>" id="activityHsnCodeE<?php echo $asn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="activity"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo round($totalActCostE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteActE = round($totalActCostE*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }

                  $totalActivityCost = $serviceCosteActA+$serviceCosteActC+$serviceCosteActE;
                  $grandTotalActivity = $grandTotalActivity+$totalActivityCost;
              $asn++; }
                }


                          // Ferry Services
         $frsn = 0;
         $fra1 = GetPageRecord('*','finalQuoteFerry','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="ferry")');
         if(mysqli_num_rows($fra1)>0){
          $frsn = 1;
        while($finalQuoteFerry = mysqli_fetch_assoc($fra1)){
         
          $ra22 = GetPageRecord('*','ferryPriceMaster','id="'.$finalQuoteFerry['ferryId'].'"');
          $ferryData = mysqli_fetch_assoc($ra22);
        
         $totalFerryA = convert_to_base($finalQuoteFerry['currencyValue'],$baseCurrencyVal,trim($finalQuoteFerry['adultCost']+$finalQuoteFerry['processingfee']+$finalQuoteFerry['miscCost']));

        $totalFerryC = $totalFerrySameDayC + convert_to_base($finalQuoteFerry['currencyValue'],$baseCurrencyVal,trim($finalQuoteFerry['childCost']+$finalQuoteFerry['processingfee']+$finalQuoteFerry['miscCost']));

        $totalFerryE = $totalFerrySameDayE + convert_to_base($finalQuoteFerry['currencyValue'],$baseCurrencyVal,trim($finalQuoteFerry['infantCost']+$finalQuoteFerry['processingfee']+$finalQuoteFerry['miscCost']));

      $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$frsn.'" and serviceType="ferry"');
      $invoiceDetail = mysqli_fetch_assoc($invD);

      if($invoiceDetail['adultParticular']!=''){
        $adultParticular = $invoiceDetail['adultParticular'];
      }else{
        $adultParticular = $ferryData['name'].'/Adult/Ferry/'.$tptType;
      }

      if($invoiceDetail['adulthsnId']!=''){
        $adulthsnId = $invoiceDetail['adulthsnId'];
      }else{
        $adulthsnId = '';
      }
      
      if($invoiceDetail['childParticular']!=''){
        $childParticular = $invoiceDetail['childParticular'];
      }else{
        $childParticular =  $ferryData['name'].'/Child/Ferry/'.$tptType;
      }

      if($invoiceDetail['childhsnId']!=''){
        $childhsnId = $invoiceDetail['childhsnId'];
      }else{
        $childhsnId = '';
      }

      if($invoiceDetail['infantParticular']!=''){
        $infantParticular = $invoiceDetail['infantParticular'];
      }else{
        $infantParticular =  $ferryData['name'].'/Infant/Ferry/'.$tptType;
      }

      if($invoiceDetail['infanthsnId']!=''){
        $infanthsnId = $invoiceDetail['infanthsnId'];
      }else{
        $infanthsnId = '';
      }

    
          if($isSer_Mark == 1 && $isUni_Mark == 0){
            $ferryMarkupA = getMarkupCost($totalFerryA, $ferry, $ferryMarkupType);
            $ferryMarkupC = getMarkupCost($totalFerryC, $ferry, $ferryMarkupType);
            $ferryMarkupE = getMarkupCost($totalFerryE, $ferry, $ferryMarkupType);
          
            }else{
            $ferryMarkupA = getMarkupCost($totalFerryA, $serviceMarkup, $markupType);
            $ferryMarkupC = getMarkupCost($totalFerryC, $serviceMarkup, $markupType);
            $ferryMarkupE = getMarkupCost($totalFerryE, $serviceMarkup, $markupType);
           }
           
           $totalFerryCostA = $ferryMarkupA+$totalFerryA;
           $totalFerryCostC = $ferryMarkupC+$totalFerryC;
           $totalFerryCostE = $ferryMarkupE+$totalFerryE;

          if($totalAdult>0 && $totalFerryCostA>0){
              ?>
              
               <tr>
              <td><input type="text" name="ferryNameA<?php echo $frsn; ?>" class="particularcls form-control" id="ferryNameA<?php echo $frsn; ?>" value="<?php echo $adultParticular; ?>"></td>
      
              <td><select class="particularcls form-control" name="ferryHsnCodeA<?php echo $frsn; ?>" id="ferryHsnCodeA<?php echo $frsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="ferry"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo round($totalFerryCostA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteFerryA = round($totalFerryCostA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalFerryCostC>0){
                ?>
               
                 <tr>
                <td><input type="text" name="ferryNameC<?php echo $frsn; ?>" class="particularcls form-control" id="ferryNameC<?php echo $frsn; ?>" value="<?php echo $childParticular; ?>"></td>
        
                <td><select class="particularcls form-control" name="ferryHsnCodeC<?php echo $frsn; ?>" id="ferryHsnCodeC<?php echo $frsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="ferry"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
        
                <td align="right"><?php echo round($totalFerryCostC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteActC = round($totalFerryCostC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalFerryCostE>0){
                  ?>
                   <tr>
                  <td><input type="text" name="ferryNameI<?php echo $frsn; ?>" class="particularcls form-control" id="ferryNameI<?php echo $frsn; ?>" value="<?php echo  $infantParticular; ?>"></td>
          
                  <td><select class="particularcls form-control" name="ferryHsnCodeE<?php echo $frsn; ?>" id="ferryHsnCodeE<?php echo $frsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="ferry"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo round($totalFerryCostE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteActE = round($totalFerryCostE*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }

                  
              $frsn++; }
                }

                   // Restaurant Services
                   $mpsn = 0;
                   $rmp1 = GetPageRecord('*','finalQuoteMealPlan','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="mealplan")');
                   if(mysqli_num_rows($rmp1)>0){
                    $mpsn = 1;
                  while($finalQuoteMealPlan = mysqli_fetch_assoc($rmp1)){
     
                  
                     $totalMealANM = convert_to_base($finalQuoteMealPlan['currencyValue'], $baseCurrencyVal, $finalQuoteMealPlan['adultCost']);

                  
           
                     if($isSer_Mark == 1 && $isUni_Mark == 0){
                       $restMarkupA = getMarkupCost($totalMealANM, $restaurant, $restaurantMarkupType);
                     
                       }else{
                       $restMarkupA = getMarkupCost($totalMealANM, $serviceMarkup, $markupType);
                      }
                      
                      $totalMealA = $$restMarkupA+$totalMealANM;
                     
                    //  $totalMealC = convert_to_base($finalQuoteMealPlan['currencyValue'], $baseCurrencyVal, $finalQuoteMealPlan['childCost2']);
     
                    //  $totalMealI = convert_to_base($finalQuoteMealPlan['currencyValue'], $baseCurrencyVal, $finalQuoteMealPlan['infantCost2']);

                    $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$mpsn.'" and serviceType="restaurant"');
                    $invoiceDetail = mysqli_fetch_assoc($invD);
              
                    if($invoiceDetail['adultParticular']!=''){
                      $adultParticular = $invoiceDetail['adultParticular'];
                    }else{
                      $adultParticular = $finalQuoteMealPlan['mealPlanName'].'/Per Person/Restaurant';
                    }
              
                    if($invoiceDetail['adulthsnId']!=''){
                      $adulthsnId = $invoiceDetail['adulthsnId'];
                    }else{
                      $adulthsnId = '';
                    }
                    
                    if($invoiceDetail['childParticular']!=''){
                      $childParticular = $invoiceDetail['childParticular'];
                    }else{
                      $childParticular =  $finalQuoteMealPlan['mealPlanName'].'/Child/Restaurant';
                    }
              
                    if($invoiceDetail['childhsnId']!=''){
                      $childhsnId = $invoiceDetail['childhsnId'];
                    }else{
                      $childhsnId = '';
                    }
              
                    if($invoiceDetail['infantParticular']!=''){
                      $infantParticular = $invoiceDetail['infantParticular'];
                    }else{
                      $infantParticular =  $finalQuoteMealPlan['mealPlanName'].'/Infant/Restaurant';
                    }
              
                    if($invoiceDetail['infanthsnId']!=''){
                      $infanthsnId = $invoiceDetail['infanthsnId'];
                    }else{
                      $infanthsnId = '';
                    }
                    
     
                  
                      if($totalAdult>0 && $totalMealA>0){
                   ?>
                    <tr>
                   <td><input type="text" name="mealPlanNameA<?php echo $mpsn; ?>" class="particularcls form-control" id="mealPlanNameA<?php echo $mpsn; ?>" value="<?php echo $adultParticular; ?>"></td>
           
                   <td><select class="particularcls form-control" name="mealHsnCode<?php echo $mpsn; ?>" id="mealHsnCode<?php echo $mpsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="restaurant"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
           
                   <td align="right"><?php echo round($totalMealA,2); ?></td>
                   <td align="center"><?php echo ($totalAdult+$totalChild); ?></td>
                   <td align="right"><?php echo $serviceCosteMapA = round($totalMealA*($totalAdult+$totalChild),2); ?></td>
                 </tr>
                   <?php
                   }
     
                   if($totalChildmap>0 && $totalMealC>0){
                     ?>
                     
                     
                      <tr>
                     <td><input type="text" name="mealPlanNameC<?php echo $mpsn; ?>" class="particularcls form-control" id="mealPlanNameC<?php echo $mpsn; ?>" value="<?php echo $childParticular; ?>"></td>
             
                     <td><select class="particularcls form-control" name="mealHsnCodeC<?php echo $mpsn; ?>" id="mealHsnCodeC<?php echo $mpsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="restaurant"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
             
                     <td align="right"><?php echo round($totalMealC,2); ?></td>
                     <td align="center"><?php echo $totalChild; ?></td>
                     <td align="right"><?php echo $serviceCosteMapC = round($totalMealC*$totalChild,2); ?></td>
                   </tr>
                     <?php
                     }
     
                     
                
                     if($totalInfantmap>0 && $totalMealI>0){
                       ?>
                        <tr>
                       <td><input type="text" name="mealPlanNameI<?php echo $mpsn; ?>" class="particularcls form-control" id="mealPlanNameI<?php echo $mpsn; ?>" value="<?php echo $infantParticular ; ?>"></td>
               
                       <td><select class="particularcls form-control" name="mealHsnCodeE<?php echo $mpsn; ?>" id="mealHsnCodeE<?php echo $mpsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="restaurant"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
               
                       <td align="right"><?php echo round($totalMealI,2); ?></td>
                       <td align="center"><?php echo $totalInfant; ?></td>
                       <td align="right"><?php echo $serviceCosteMapE = round($totalMealI*$totalInfant,2); ?></td>
                     </tr>
                     
                       <?php
                       }
                       $totalMealPlanCost = $serviceCosteMapA+$serviceCosteMapC+$serviceCosteMapE;
                       $grandTotalmealPlan = $grandTotalmealPlan+$totalMealPlanCost;


                       $mpsn++; }
                      }
                 

                  // Additional Services
              $exsn = 0;
              $rex1 = GetPageRecord('*','finalQuoteExtra','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="additional")');
              if(mysqli_num_rows($rex1)>0){
                $exsn = 1;
             while($finalQuoteExtra = mysqli_fetch_assoc($rex1)){
               
               $rex22 = GetPageRecord('*','extraQuotation','id="'.$finalQuoteExtra['additionalId'].'"');
              $additionalData = mysqli_fetch_assoc($rex22);

            //   if($finalQuoteExtra['costType']==2){
            //     $totalExtraA = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['groupCost']/$totalPax);

            //     $totalExtraC = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['groupCost']/$totalPax);

            //     $totalExtraI = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['groupCost']/$totalPax);
            // }else{
            //     $totalExtraA = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['adultCost']);

            //     $totalExtraC = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['childCost']);

            //     $totalExtraI = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['infantCost']);
                
            // }
            if($finalQuoteExtra['groupCost'] > 0 ){
							$totalExtraANM = $finalQuoteExtra['groupCost']/($totalPax+$paxAdultLE+$paxAdultFE);
						}else{
							$totalExtraANM = $finalQuoteExtra['adultCost'];
						}
          
            if($isSer_Mark == 1 && $isUni_Mark == 0){
              $otherMarkupA = getMarkupCost($totalExtraANM, $other, $otherMarkupType);
              }else{
              $otherMarkupA = getMarkupCost($totalExtraANM, $serviceMarkup, $markupType);
            
             }
             
             $totalExtraA = $otherMarkupA+$totalExtraANM;

            $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$exsn.'" and serviceType="additional"');
            $invoiceDetail = mysqli_fetch_assoc($invD);
      
            if($invoiceDetail['adultParticular']!=''){
              $adultParticular = $invoiceDetail['adultParticular'];
            }else{
              $adultParticular = $additionalData['name'].'/Per Pax/Additional';
            }

            if($invoiceDetail['adulthsnId']!=''){
              $adulthsnId = $invoiceDetail['adulthsnId'];
            }else{
              $adulthsnId = '';
            }
            // $totalExtraA+$totalExtraC+$totalExtraI;
             
                 if($totalAdult>0 && $totalExtraA>0){
              ?>
               <tr>
              <td><input type="text" name="additionalNameA<?php echo $exsn; ?>" class="particularcls form-control" id="additionalNameA<?php echo $exsn; ?>" value="<?php echo $adultParticular; ?>"></td>
      
              <td><select class="particularcls form-control" name="extHsnCodeA<?php echo $exsn; ?>" id="extHsnCodeA<?php echo $exsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="other"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo round($totalExtraA,2); ?></td>
              <td align="center"><?php echo $totalPax; ?></td>
              <td align="right"><?php echo $serviceCosteExtA = round($totalExtraA*$totalPax,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalExtraC>0){
                ?>
                 <tr>
                <td><input type="text" name="additionalNameC<?php echo $exsn; ?>" class="particularcls form-control" id="additionalNameC<?php echo $exsn; ?>" value="<?php echo $additionalData['name'].'/Child/Additional'; ?>"></td>
        
                <td><select class="particularcls form-control" name="extHsnCodeC<?php echo $exsn; ?>" id="extHsnCodeC<?php echo $exsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="other"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
        
                <td align="right"><?php echo round($totalExtraC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteExtC = round($totalExtraC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalExtraI>0){
                  ?>
                   <tr>
                  <td><input type="text" name="additionalNameI<?php echo $exsn; ?>" class="particularcls form-control" id="additionalNameI<?php echo $exsn; ?>" value="<?php echo $additionalData['name'].'/Infant/Additional'; ?>"></td>
          
                  <td><select class="particularcls form-control" name="extHsnCodeE<?php echo $exsn; ?>" id="extHsnCodeE<?php echo $exsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="other"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo round($totalExtraI,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteExtE = round($totalExtraI*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }
                  $totalExtraCost = $serviceCosteExtA+$serviceCosteExtC+$serviceCosteExtE;
                  $grandTotalExtraCost = $grandTotalExtraCost+$totalExtraCost;

                  $exsn++; }
                }

                         // flight Services
              $flsn = 0;
              $rf1 = GetPageRecord('*','finalQuoteFlights','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="flight")');
         
             while($finalQuoteFlights = mysqli_fetch_assoc($rf1)){
              if(mysqli_num_rows($rf1)>0){
                $flsn = 1;
               $rf22 = GetPageRecord('*','packageBuilderAirlinesMaster','id="'.$finalQuoteFlights['flightId'].'"');
              $flightData = mysqli_fetch_assoc($rf22);

               $totalflightANM = (convert_to_base($finalQuoteFlights['currencyValue'],  $baseCurrencyVal, $finalQuoteFlights['adultCost']));
               $totalflightCNM = (convert_to_base($finalQuoteFlights['currencyValue'], $baseCurrencyVal, $finalQuoteFlights['childCost']));
               $totalflightENM = (convert_to_base($finalQuoteFlights['currencyValue'], $baseCurrencyVal, $finalQuoteFlights['infantCost']));
     
               if($isSer_Mark == 1 && $isUni_Mark == 0){
                 $flightMarkupA = getMarkupCost($totalflightANM, $flight, $flightMarkupType);
                 $flightMarkupC = getMarkupCost($totalflightCNM, $flight, $flightMarkupType);
                 $flightMarkupE = getMarkupCost($totalflightENM, $flight, $flightMarkupType);
                 }else{
                 $flightMarkupA = getMarkupCost($totalflightANM, $serviceMarkup, $markupType);
                 $flightMarkupC = getMarkupCost($totalflightCNM, $serviceMarkup, $markupType);
                 $flightMarkupE = getMarkupCost($totalflightENM, $serviceMarkup, $markupType);
                }
                
                $totalflightA = $$flightMarkupA+$totalflightANM;
                $totalflightC = $flightMarkupC+$totalflightCNM;
                $totalflightE = $flightMarkupE+$totalflightENM;

               $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$flsn.'" and serviceType="flight"');
               $invoiceDetail = mysqli_fetch_assoc($invD);
         
               if($invoiceDetail['adultParticular']!=''){
                 $adultParticular = $invoiceDetail['adultParticular'];
               }else{
                 $adultParticular =  $flightData['flightName'].'/Adult/Flight';
               }
         
               if($invoiceDetail['adulthsnId']!=''){
                 $adulthsnId = $invoiceDetail['adulthsnId'];
               }else{
                 $adulthsnId = '';
               }
               
               if($invoiceDetail['childParticular']!=''){
                 $childParticular = $invoiceDetail['childParticular'];
               }else{
                 $childParticular =  $flightData['flightName'].'/Child/Flight';
               }
         
               if($invoiceDetail['childhsnId']!=''){
                 $childhsnId = $invoiceDetail['childhsnId'];
               }else{
                 $childhsnId = '';
               }
         
               if($invoiceDetail['infantParticular']!=''){
                 $infantParticular = $invoiceDetail['infantParticular'];
               }else{
                 $infantParticular =  $flightData['flightName'].'/Infant/Flight';
               }
         
               if($invoiceDetail['infanthsnId']!=''){
                 $infanthsnId = $invoiceDetail['infanthsnId'];
               }else{
                 $infanthsnId = '';
               }

              
                 if($totalAdult>0 && $totalflightA>0){
              ?>
              
              
               <tr>
              <td><input type="text" name="flightNameA<?php echo $flsn; ?>" class="particularcls form-control" id="flightNameA<?php echo $flsn; ?>" value="<?php echo $adultParticular ; ?>" ></td>
      
              <td><select class="particularcls form-control" name="flightHsnCodeA<?php echo $flsn; ?>" id="flightHsnCodeA<?php echo $flsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="flight"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo round($totalflightA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteflA = round($totalflightA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalflightC>0){
                ?>
                
                
                 <tr>
                <td><input type="text" name="flightNameC<?php echo $flsn; ?>" class="particularcls form-control" id="flightNameC<?php echo $flsn; ?>" value="<?php echo $childParticular; ?>"></td>
        
                <td><select class="particularcls form-control" name="flightHsnCodeC<?php echo $flsn; ?>" id="flightHsnCodeC<?php echo $flsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="flight"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
        
                <td align="right"><?php echo round($totalflightC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteflC = round($totalflightC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalflightE>0){
                  ?>
                  
                   <tr>
                  <td><input type="text" name="flightNameI<?php echo $flsn; ?>" class="particularcls form-control" id="flightNameI<?php echo $flsn; ?>" value="<?php echo $infantParticular; ?>"></td>
          
                  <td><select class="particularcls form-control" name="flightHsnCodeE<?php echo $flsn; ?>" id="flightHsnCodeE<?php echo $flsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="flight"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo round($totalflightE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteflE = round($totalflightE*$totalInfant,2); ?></td>
                </tr>

                
                  <?php
                  }
                  $totalFlightCost = $serviceCosteflA+$serviceCosteflC+$serviceCosteflE;
                  $grandtotalFlightCost = $grandtotalFlightCost+$totalFlightCost;
                  $flsn++; }
                }
                  
                         // Train Services
               $trsn = 0;
              $rt1 = GetPageRecord('*','finalQuoteTrains','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="train")');
                if(mysqli_num_rows($rt1)>0){
                  $trsn = 1;
             while($finalQuoteTrains = mysqli_fetch_assoc($rt1)){
               
               $rt22 = GetPageRecord('*','packageBuilderTrainsMaster','id="'.$finalQuoteTrains['trainId'].'"');
              $trainData = mysqli_fetch_assoc($rt22);

               $totaltrainANM = (convert_to_base($finalQuoteTrains['currencyValue'], $baseCurrencyVal, $finalQuoteTrains['adultCost']));
               $totaltrainCNM = (convert_to_base($finalQuoteTrains['currencyValue'], $baseCurrencyVal, $finalQuoteTrains['childCost']));
               $totaltrainENM = (convert_to_base($finalQuoteTrains['currencyValue'], $baseCurrencyVal, $finalQuoteTrains['infantCost']));

               if($isSer_Mark == 1 && $isUni_Mark == 0){
                $trainMarkupA = getMarkupCost($totaltrainANM, $train, $trainMarkupType);
                $trainMarkupC = getMarkupCost($totaltrainCNM, $train, $trainMarkupType);
                $trainMarkupE = getMarkupCost($totaltrainENM, $train, $trainMarkupType);
                }else{
                $trainMarkupA = getMarkupCost($totaltrainANM, $serviceMarkup, $markupType);
                $trainMarkupC = getMarkupCost($totaltrainCNM, $serviceMarkup, $markupType);
                $trainMarkupE = getMarkupCost($totaltrainENM, $serviceMarkup, $markupType);
               }
               
               $totaltrainA = $trainMarkupA+$totaltrainANM;
               $totaltrainC = $trainMarkupC+$totaltrainCNM;
               $totaltrainE = $trainMarkupE+$totaltrainENM;

               $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$trsn.'" and serviceType="train"');
               $invoiceDetail = mysqli_fetch_assoc($invD);
         
               if($invoiceDetail['adultParticular']!=''){
                 $adultParticular = $invoiceDetail['adultParticular'];
               }else{
                 $adultParticular =  $trainData['trainName'].'/Adult/Train';
               }
         
               if($invoiceDetail['adulthsnId']!=''){
                 $adulthsnId = $invoiceDetail['adulthsnId'];
               }else{
                 $adulthsnId = '';
               }
               
               if($invoiceDetail['childParticular']!=''){
                 $childParticular = $invoiceDetail['childParticular'];
               }else{
                 $childParticular =  $trainData['trainName'].'/Child/Train';
               }
         
               if($invoiceDetail['childhsnId']!=''){
                 $childhsnId = $invoiceDetail['childhsnId'];
               }else{
                 $childhsnId = '';
               }
         
               if($invoiceDetail['infantParticular']!=''){
                 $infantParticular = $invoiceDetail['infantParticular'];
               }else{
                 $infantParticular =  $trainData['trainName'].'/Infant/Train';
               }
         
               if($invoiceDetail['infanthsnId']!=''){
                 $infanthsnId = $invoiceDetail['infanthsnId'];
               }else{
                 $infanthsnId = '';
               }

               
               
               
                 if($totalAdult>0 && $totaltrainA>0){
              ?>
              
               <tr>
              <td><input type="text" name="traninNameA<?php echo $trsn; ?>" class="particularcls form-control" id="traninNameA<?php echo $trsn; ?>" value="<?php echo $adultParticular; ?>"></td>
      
              <td><select class="particularcls form-control" name="trainHsnCodeA<?php echo $trsn; ?>" id="trainHsnCodeA<?php echo $trsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="train"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
      
              <td align="right"><?php echo round($totaltrainA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCostetrA = round($totaltrainA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totaltrainC>0){
                ?>
                
                
                 <tr>
                <td><input type="text" name="traninNameC<?php echo $trsn; ?>" class="particularcls form-control" id="traninNameC<?php echo $trsn; ?>" value="<?php echo $childParticular; ?>" ></td>
        
                <td><select class="particularcls form-control" name="trainHsnCodeC<?php echo $trsn; ?>" id="trainHsnCodeC<?php echo $trsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="train"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($childhsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
        
                <td align="right"><?php echo round($totaltrainC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCostetrC = round($totaltrainC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totaltrainE>0){
                  ?>
                  
                   <tr>
                  <td><input type="text" name="traninNameI<?php echo $trsn; ?>" class="particularcls form-control" id="traninNameI<?php echo $trsn; ?>" value="<?php echo $infantParticular; ?>" ></td>
          
                  <td><select class="particularcls form-control" name="trainHsnCodeE<?php echo $trsn; ?>" id="trainHsnCodeE<?php echo $trsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="train"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>" <?php if($infanthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo round($totaltrainE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCostetrE = round($totaltrainE*$totalInfant,2); ?></td>
                </tr>
               
                  <?php
                  }
                  $totalTrainCost = $serviceCostetrA+$serviceCostetrC+$serviceCostetrE;
                  $grandTotalTrinCost = $grandTotalTrinCost+$totalTrainCost;
                
                  $trsn++; }
                }

                  $gsn = 0;
                  $rg1 = GetPageRecord('*','finalQuoteGuides','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="guide")');
                  $gsn = 1;
                 while($finalQuoteGuides = mysqli_fetch_assoc($rg1)){
                   
                   $rg22 = GetPageRecord('*','tbl_guidesubcatmaster','id="'.$finalQuoteGuides['guideId'].'"');
                  $guideData = mysqli_fetch_assoc($rg22);

                  $totalGuideCostNM=convert_to_base($finalQuoteGuides['currencyValue'],$baseCurrencyVal,$finalQuoteGuides['adultCost']);
                    $allPax = $totalAdult+$totalChild;

                    if($isSer_Mark == 1 && $isUni_Mark == 0){
                      $guideMarkupA = getMarkupCost($totalGuideCostNM, $guide, $guideMarkupType);
                     
                      }else{
                      $guideMarkupA = getMarkupCost($totalGuideCostNM, $serviceMarkup, $markupType);
                      
                     }
                     
                     $totalGuideCost = $guideMarkupA+$totalGuideCostNM;

                    $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$trsn.'" and serviceType="train"');
                    $invoiceDetail = mysqli_fetch_assoc($invD);
              
                    if($invoiceDetail['adultParticular']!=''){
                      $adultParticular = $invoiceDetail['adultParticular'];
                    }else{
                      $adultParticular =  $guideData['name'].'/Guide';
                    }
              
                    if($invoiceDetail['adulthsnId']!=''){
                      $adulthsnId = $invoiceDetail['adulthsnId'];
                    }else{
                      $adulthsnId = '';
                    }

                if($totalPax>0 && $totalGuideCost>0){
                  ?>
                   <tr>
                  <td><input type="text" name="guideName<?php echo $gsn; ?>" class="particularcls form-control" id="guideName<?php echo $gsn; ?>" value="<?php echo $adultParticular; ?>" ></td>
          
                  <td><select class="particularcls form-control" name="guideHsnCode<?php echo $gsn; ?>" id="guideHsnCode<?php echo $gsn; ?>">
              <?php 
              $resHSN = GetPageRecord('*','sacCodeMaster','status=1 and deletestatus=0 and serviceType="guide"');
              while( $HSNData = mysqli_fetch_assoc($resHSN)){
                ?>
                <option value="<?php echo $HSNData['id']; ?>"  <?php if($adulthsnId==$HSNData['id']){ ?> selected="selected" <?php }elseif($HSNData['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo $HSNData['serviceType'].' ('.$HSNData['sacCode'].')'; ?></option>
                <?php
              } 
              ?>
            </select></td>
          
                  <td align="right"><?php echo $perGuideCost = round($totalGuideCost/$allPax,2); ?></td>
                  <td align="center"><?php echo $allPax; ?></td>
                  <td align="right"><?php echo $serviceCostegd = round($perGuideCost*$allPax,2); ?></td>
                </tr>
                
                  <?php
                  }
                    $GrandtotalGuideCost = $GrandtotalGuideCost+$serviceCostegd;
                
                  $gsn++; }
            ?>

              <input type="hidden" name="hotelSerialNo" id="hotelSerialNo" value="<?php echo $hsn; ?>">
              <input type="hidden" name="transferSerialNo" id="transferSerialNo" value="<?php echo $tpt; ?>">
              <input type="hidden" name="transportSerialNo" id="transportSerialNo" value="<?php echo $tptt; ?>">
              <input type="hidden" name="entranceSerialNo" id="entranceSerialNo" value="<?php echo $esn; ?>">
              <input type="hidden" name="activitySerialNo" id="activitySerialNo" value="<?php echo $asn; ?>">
              <input type="hidden" name="ferrySerialNo" id="ferrySerialNo" value="<?php echo $frsn; ?>">
              <input type="hidden" name="mealSerialNo" id="mealSerialNo" value="<?php echo $mpsn; ?>">
              <input type="hidden" name="extSerialNo" id="extSerialNo" value="<?php echo $exsn; ?>">
              <input type="hidden" name="flightSerialNo" id="flightSerialNo" value="<?php echo $flsn; ?>">
              <input type="hidden" name="trainSerialNo" id="trainSerialNo" value="<?php echo $trsn; ?>">
              <input type="hidden" name="guideSerialNo" id="guideSerialNo" value="<?php echo $gsn; ?>">


            <tr>
              <td align="right" colspan="2">Total</td>
              <td colspan="2"></td>
              <td align="right"><strong><?php echo $prmData['totalClientCostWithMarkup']; ?></strong></td>
            </tr>

            <?php if($gstType==1){ ?>  
          <tr>
            <td align="right" colspan="2" style="padding:8px;">CGST <?php echo ($serviceTax/2); ?>% </td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $cgstCost=round($totalServiceTaxCost/2); ?></strong>
              <input name="cgst" type="hidden" id="cgst" value="<?php echo $cgstCost; ?>" />
            </td>
            </tr>
        <?php } ?>
        <?php if($gstType==1){ ?>  
          <tr>
            <td align="right" colspan="2" style="padding:8px;">SGST <?php echo ($serviceTax/2); ?>% </td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $sgstCost=round($totalServiceTaxCost/2); ?></strong>
              <input name="cgst" type="hidden" id="cgst" value="<?php echo $sgstCost; ?>" />
            </td>
          </tr>
        <?php } ?>
        <?php if($gstType==2){ ?>
          <tr>
            <td align="right" colspan="2" style="padding:8px;"><span class="header">IGST <?php echo $serviceTax; ?>% </span></td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $igstCost=round($totalServiceTaxCost); ?></strong>
              <input name="igst" type="hidden" id="igst" value="<?php echo $igstCost; ?>" />
            </td>
          </tr>
        <?php } ?> 
        <?php if($gstType==3){ ?>
          <tr>
            <td align="right" colspan="2" style="padding:8px;"><span class="header">GST <?php echo $serviceTax; ?>% </span></td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $gstCost=round($totalServiceTaxCost); ?></strong>
              <input name="gstVal" type="hidden" id="gstVal" value="<?php echo $gstCost; ?>" />
            </td>
          </tr>
        <?php } ?> 
        <?php if($totalTCSCost!=0){  ?>
         <tr>
            <td align="right" colspan="2" style="padding:8px;"><span class="header">TCS <?php if($tcsTax>0){ echo $tcsTax.'%'; } ?> </span></td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $tcsCost=round($totalTCSCost); ?></strong>
              <input name="tcs" type="hidden" id="tcs" value="<?php echo $tcsCost; ?>" />
            </td>
          </tr>
        <?php } ?>
        
        <tr>
          <td align="right" colspan="2" style="padding:8px;">Total&nbsp;Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>) </td>
          <td colspan="2"></td>
          <td align="right" style="padding:8px;"><strong><?php echo  round($totalClientCost); ?></strong></td>
        </tr> 

        <?php if($currencyId <> $baseCurrencyId){ ?>
        <tr>
          <td align="right" style="padding:8px;">Total&nbsp;Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($currencyId); ?>) </td>
          <td align="right" style="padding:8px;">
            <strong><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCost);  ?>
              <input name="totalVal" type="hidden" id="totalVal" value="<?php echo $totalClientCost; ?>" />
            </strong>
          </td>
        </tr>
        <?php } ?>
    </table>

  <?php } 
  
      $totalServicesCost = $totalTransport+$grandHotelServiceCost+$grandTransferServiceCost+$grandtotalEntranceCost+$grandTotalActivity+$grandTotalmealPlan+$grandTotalExtraCost+$grandtotalFlightCost+$grandTotalTrinCost+$GrandtotalGuideCost;
  ?>
 

                  

  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <!-- Add bank details -->
  <tr>
    <td colspan="2" align="left" valign="top">
    <table width="100%" border="1" cellpadding="6" cellspacing="0" bordercolor="#000000" style="border-radius: 5px; overflow:hidden;">
      <tr>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;min-width: 100px;">Bank Name</td>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;min-width: 80px;">Account Type</td>
        <td style="padding:8px; background-color:#353940; color:#fff;">Beneficiary Name</td>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;">Account Number</td>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;" id="branchchange">Branch IFSC</td>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;">Branch SWIFT Code</td> 
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;">Branch Address</td>
      </tr>
   
      <tr>
        <td align="left" valign="top"><div class="form-group">
        <?php 
        $getbank = GetPageRecord('*','bankMaster', 'deletestatus=0'); 

        ?>
        <select name="bankName" id="bankName" class="form-control" onchange="GetBankDetails(this.value);" >
        <option value="">Select Bank</option>
        <?php while($bankName = mysqli_fetch_array($getbank)){ ?>
        <option value="<?php echo strip($bankName['id']); ?>" <?php if($bankName['setDefault']==1){ ?> selected="selected" <?php } ?> ><?php echo strip($bankName['bankName']); ?></option>
        <?php } ?>
        </select>
        </div></td>
        <td align="left" valign="top" ><div class="form-group" style="position:static;">
        <input type="text" name="accountType" id="accountType" class="form-control" displayname="Account Type" autocomplete="off" min="0" value="" />
        </div></td>

        <td align="left" valign="top" >
        <div class="form-group" style="position:static;"> 
        <input type="text" name="beneficiaryName" class="form-control" id="beneficiaryName" displayname="Beneficiary Name" autocomplete="off" value="" />
        </div></td>

        <td align="left" valign="top" ><div class="form-group">
        <input type="number" name="accountNumber" class="form-control" id="accountNumber" displayname="Account Number" autocomplete="off" min="0">
        </div></td>

        <td align="left" valign="top"><div class="form-group">
        <input type="text" name="branchIfsc" class="form-control" id="branchIfsc" displayname="Branch IFSC" autocomplete="off" >
        </div></td>

        <td align="left" valign="top"><div class="form-group">
        <input type="text" name="branchSwiftCode" class="form-control" id="branchSwiftCode" displayname="Branch SWIFT Code" autocomplete="off" >
        </div></td> 

        <td align="left" valign="top"><div class="form-group">
        <input type="text" name="branchAddress" class="form-control" id="branchAddress" displayname="Branch Address" autocomplete="off" >
        </div></td>
                             
      </tr>
    </table>
    </td>
  </tr>
  
  <div style="background-color:#feffbc; padding:0px; display:none;" id="loadbankdetail"></div>
  <div id="loadinvoiceformat"></div>
  <script>
  function GetBankDetails(bankId){
  var bankId = $('#bankName').val();
  $('#loadbankdetail').load('load_invoicebankDetails.php?action=loadbankDetails&bankId='+bankId);
  }

  GetBankDetails();

  function selectInvoiceFormat(formattype){
    $('#loadinvoiceformat').load(`load_invoicebankDetails.php?action=updatInvoiceFormat&formatType=${formattype}&invoiceId=<?php echo $invoiceId; ?>`);
  }
// invoiceFormat
  </script>
    <!-- Add bank details end-->
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2" align="left" valign="top"><div class="form-group">
              <label for="exampleInputPassword1">Notes</label> 
      <textarea name="invoiceNotes" rows="3" class="form-control" id="invoiceNotes" displayname="Location" autocomplete="off" style="height:100px;"><?php echo nl2br(strip_tags(stripslashes($invmData['invoiceNotes']))); ?></textarea>
            </div></td>
  </tr>
  <tr>
  <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2" align="left" valign="top"><div class="form-group">
  <label for="exampleInputPassword1">Terms & Conditions</label> 
  <textarea name="terms" rows="3" class="form-control" id="terms" displayname="Location" autocomplete="off" style="height:100px;"><?php if($invmData['terms']!=''){ echo nl2br(strip_tags(stripslashes($invmData['terms']))); }else{ echo nl2br(strip_tags(stripslashes($termscondition))); } ?></textarea>
  </div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><div class="form-group">
                  <label for="exampleInputPassword1">Payment</label> 
          <input name="paymentTerms" type="text" class="form-control" id="paymentTerms" value="<?php echo strip($invmData['payment']); ?>" displayname="Location" autocomplete="off" />
                </div></td>
  </tr>
</table>

 
</div>
               
            

               
       
          </div>
          

        </div> 


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> 
        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div> 


<script>
  function selectInvoiceType(id){
      if(id==2){
        $("#invoiceTypedisplay").text("PROFORMA INVOICE");
      }
      if(id==1){
        $("#invoiceTypedisplay").text("TAX INVOICE");
      }
  }
</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}


.form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
  box-sizing: border-box;
}


.btn-default {
    background-color: #f4f4f4;
    color: #444;
    border-color: #ddd;
}

.btn {
    border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 1px solid transparent;padding: 8px;
}

.btn-info {
    background-color: #00c0ef;
    border-color: #00acd6; color:#fff;
}

  .headbox{
    margin: 0px;
    padding-bottom: 4px;
    font-size: 12px;
  }

</style> 