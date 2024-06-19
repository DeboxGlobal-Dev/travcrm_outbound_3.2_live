<?php 

$select='*'; 
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$invoicesetting=mysqli_fetch_array($rs); 


$rerultsetting=GetPageRecord($select,'companySettingsMaster','id=1');
$companyPAN = mysqli_fetch_assoc($rerultsetting);

$invoiceId=decode($_GET['id']);
 
if($_GET['id']!=''){

	$id=clean(decode($_GET['id']));
	 
	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$where='id='.$id;  
	$rs=GetPageRecord($select,_INVOICE_MASTER_,$where); 
	$resultinvoicepage=mysqli_fetch_array($rs); 
	
	$invoiceNotes=$resultinvoicepage['invoiceNotes']; 
	$payment=$resultinvoicepage['payment']; 
	
	$select1='*';  
	$where1='queryid='.$resultinvoicepage['queryId'].' order by id asc'; 
	$rs1=GetPageRecord($select1,_QUERYMAILS_MASTER_,$where1); 
	$querymailmaster=mysqli_fetch_array($rs1);
	
	
	$select1='*';  
	$where1='id='.$resultinvoicepage['queryId'].''; 
	$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1);
	 
	
	
	$editdescription=clean($editresult['description']);   
	$queryId=$editresult['id'];
	 
}

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultinvoicepage['queryId']); 
$where='id="'.$id.'" order by id desc'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  


$quotQuery="";
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$resultinvoicepage['quotationId'].'" and status=1 '); 
$quotationData=mysqli_fetch_array($quotQuery);

$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$noofpax = $quotationData['adult']+$quotationData['child']+$quotationData['infant']; 
$subject = ($quotationData['quotationSubject']!='')?$quotationData['quotationSubject']:$resultQuery['subject'];
$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discount = $quotationData['discount'];
if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
	$newCurr = $baseCurrencyId;
}else{
	$newCurr = $quotationData['currencyId'];
}

$select5='*';  
$where5='addressType="invoicesetting" and addressParent="1" '; 
$rs5=GetPageRecord($select5,_ADDRESS_MASTER_,$where5); 
$address5 =mysqli_fetch_array($rs5); 

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
  <input name="action" type="hidden" id="action" value="<?php if($_GET['id']!=''){ echo 'saveinvoice';} else { echo 'addquery'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
 <div class="col-md-6" style="width:915px;margin: auto;
    border: 1px #ccc solid;
    background-color: #fff;">
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
  <tr>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    
      <tr>
      <span style="font-size: 15px; font-weight:500; color:#999999;">Company Information</span>
        <td colspan="3" align="left">
    
		<strong><?php echo $invoicesetting['companyname']; ?></strong><br />
		<?php echo $invoicesetting['address']; ?><br />
		<strong>Phone:</strong> <?php echo $invoicesetting['phone']; ?><br />
		<?php if($invoicesetting['email']!=''){ ?>
		<strong>Email:</strong> <?php echo $invoicesetting['email']; ?><br />
		<?php } ?>
		<?php if($invoicesetting['website']!=''){ ?>
		<strong>Website:</strong> <?php echo $invoicesetting['website']; ?><?php } ?><br />
    <strong>GSTIN/UIN:</strong> <?php echo $address5['gstn']; ?>  <br />
    <strong>PAN:</strong> <?php echo $companyPAN['panInformation']; ?><br/>
    <strong>CIN:</strong> <?php echo $companyPAN['CINnumber']; ?><br/>
    </td>
      </tr>
      <tr>
        <td colspan="3" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left"><div style="color:#999999; padding:10px 0px;">Agent OR Client Information:</div></td>
      </tr>
      
	  <tr>
        <td colspan="3" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;">
          <tr>
            <td width="50%"><div class="form-group"  >
                  <label for="exampleInputEmail1">User Type</label> 
				 
				 
            </div></td>
            <td colspan="3" style="padding-left:10px;"> </td>
            </tr>
          
          
        </table></td>
      </tr>
      <tr>
        <td colspan="3" align="left"><div id="useraddress">
		
		<?php
		
if($editresult['clientType']==1){
	$select4='*';  
	$where4='id='.$editresult['companyId'].''; 
	$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
	$resultCompany=mysqli_fetch_array($rs4); 
	$mobilemailtype='corporate';
}

if($editresult['clientType']==2){
	$select4='*';  
	$where4='id='.$editresult['companyId'].''; 
	$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
	$resultCompany=mysqli_fetch_array($rs4); 
	$mobilemailtype='contacts';
}
if($mobilemailtype!=''){
	$select4='*';  
	$where4='addressType="'.$mobilemailtype.'" and addressParent='.$editresult['companyId'].''; 
	$rs4=GetPageRecord($select4,_ADDRESS_MASTER_,$where4); 
	$address=mysqli_fetch_array($rs4); 
	?>
	<strong><?php echo showClientTypeUserName($editresult['clientType'],$editresult['companyId']); ?></strong><br />
		 <?php echo $address['address']; ?><br /> 
		 <strong>Phone: </strong><?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?><br /> 
		 <strong>Email:</strong> <?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?> 
		 <br />
		 <strong>GSTN:</strong> <?php echo $address['gstn']; ?> <br>
		 <strong>PAN:</strong> <?php echo $resultCompany['panInformation']; ?> 
 
		</div> 
<?php } ?>
	</td>
      </tr>
     
	 
      <tr>
        <td colspan="3" align="left">&nbsp;</td>
      </tr>
      
    </table></td>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" align="right"><div style="font-size:40px; font-weight:normal;">
          <input name="editId" type="hidden" id="editId" value="<?php echo $invoiceId; ?>" />
          <input name="quotationId" type="hidden" id="quotationId" value="<?php echo $resultinvoicepage['quotationId']; ?>" />
		   <input name="action" type="hidden" id="action" value="editinvoicemain" />
		    <input name="addinvi" type="hidden" id="addinvi" value="<?php if($_REQUEST['id']!=''){ echo '2'; } else { echo '1'; } ?>" />
          <div id="invoiceTypedisplay"><?php if($resultinvoicepage['invoiceType'] == 2){ echo 'PROFORMA INVOICE'; }else{ echo 'TAX INVOICE'; } ?></div></div></td>
        </tr>
      
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="right">
		  <table border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Invoice Date:</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"> <div class="input-group date">
                   
                  <input name="invoiceDate" type="text" class="form-control pull-right " id="invoiceDate" displayname="Date" value="<?php if($resultinvoicepage['invoicedate']!='' && $resultinvoicepage['invoicedate']!='0000-00-00'){ echo date("d-m-Y", strtotime($resultinvoicepage['invoicedate'])); } else { echo date("d-m-Y"); } ?>">
                </div></td>
            </tr>
            
            <tr>
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Invoice Type</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><select id="invoiceType" name="invoiceType" class="form-control pull-right validate"   autocomplete="off" onchange="selectInvoiceType(this.value);" > 
              <option value="2" <?php if($resultinvoicepage['invoiceType']=='2'|| $resultinvoicepage['invoiceType']==''){ ?>selected="selected"<?php } ?>>Proforma Invoice</option>  
              <option value="1" <?php if($resultinvoicepage['invoiceType']=='1'){ ?>selected="selected"<?php } ?>>Tax Invoice</option> 
              </select>
              </td>
            </tr>
            <tr   >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Invoice No. </div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><div class="input-group date"> 

                  <input name="invoiceNo" type="hidden" value="<?PHP if($resultinvoicepage['invoiceType']==2){ echo $companyPAN['proformaInvoiceNoSequence'].'/'.makeInvoiceId($resultinvoicepage['id']); }else{ echo $companyPAN['taxInvoiceNoSequence'].'/'.makeInvoiceId($resultinvoicepage['id']); } ?>">
                  
                  <input type="text" class="form-control pull-right " value="<?PHP if($resultinvoicepage['invoiceType']==2){ echo $companyPAN['proformaInvoiceNoSequence'].'/'.makeInvoiceId($resultinvoicepage['id']); }else{ echo $companyPAN['taxInvoiceNoSequence'].'/'.makeInvoiceId($resultinvoicepage['id']); } ?>" disabled>
                </div></td>
            </tr>
       
            



            <tr    >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">File No.</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <input name="fileNum" type="text" class="form-control pull-right " value="<?php echo makeQuotationId($quotationId); ?>" disabled>
                <input type="hidden" name="fileNo" id="fileNo" value="<?php echo makeQuotationId($quotationId); ?>">
              </td>
            </tr>
            <tr >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">TourId.</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <input type="hidden" name="tourId" value="<?php echo makeQueryTourId($queryId); ?>">
                <input type="text" class="form-control pull-right " id="tourId"  value="<?php echo makeQueryTourId($queryId); ?>" disabled>
              </td>
            </tr>
            <tr >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Reference No.</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                  <input type="text" class="form-control pull-right" id="referNo" value="<?php echo $editresult['referanceNumber']; ?>" disabled>
                  <input type="hidden" name="referNo" value="<?php echo $editresult['referanceNumber']; ?>">
              </td>
            </tr>
            <tr style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Group Check In Date</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="groupCheckIn" type="date" class="form-control pull-right " id="groupCheckIn"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Group Check Out </div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="groupCheckOut" type="date" class="form-control pull-right " id="groupCheckOut"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Pax /Room Count</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="pax" type="text" class="form-control pull-right " id="pax"  value=""></td>
            </tr> 
            <tr style="display:none;"   >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Destinations</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="destination" type="text" class="form-control pull-right " id="destination"  value=""></td>
            </tr>
            <tr  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Due Date:</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><div class="input-group date">
                   
                  <input name="dueDate" type="text" class="form-control pull-right " id="dueDate" displayname="Due Date" value="<?php if($resultinvoicepage['dueDate']!='' && $resultinvoicepage['dueDate']!='0000-00-00'){ echo date("d-m-Y", strtotime($resultinvoicepage['dueDate'])); } else { echo date("d-m-Y"); }  ?>">
                </div></td>
                <script>
                  $("#dueDate").Zebra_DatePicker({
                    format : "d-m-Y"
                  })

                  $("#invoiceDate").Zebra_DatePicker({
                    format : "d-m-Y"
                  })

                </script>
            </tr>
            <tr>
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Place of Delivery :</div></td>
              <td>&nbsp;</td>
              <td align="left" style="border-left:none;" valign="middle"><div class="input-group date">
                   
                  <input name="deliveryplace" type="text" class="form-control pull-right" id="deliveryplace" displayname="Place of Delivery" value="<?php echo $resultinvoicepage['deliveryPlace']; ?>">
                 
                </div></td>
            </tr>
            <tr style="display:none;">
              <td align="right" valign="middle"><div style="color:#000; font-size:18px; padding:10px 0px;"><strong>Balance Due:</strong></div></td>
              <td>&nbsp;&nbsp;</td>
              <td align="left" valign="middle"><strong><div style="color:#000; font-size:18px; padding:10px 0px;"><?php echo $currency['name']; ?> <span id="balancedue"><?php echo $balancedueVal; ?></span><input name="balancedueVal" type="hidden" id="balancedueVal" value="<?php echo $balancedueVal; ?>" /></div></strong></td>
            </tr>
          </table>		</td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding:10px 0px 5px;">
    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#000000" style="border-radius: 5px; overflow:hidden;">
      <tr>
        <td style="padding:8px; background-color:#353940; color:#fff;">SN.</td>
        <td style="padding:8px; background-color:#353940; color:#fff;">Particulars</td>
        <td style="padding:8px; background-color:#353940; color:#fff;">HSN/SAC</td>
        <td align="center"  style="padding:8px; background-color:#353940; color:#fff;min-width: 80px;">Amount</td>
        <!-- <td align="center"  style="padding:8px; background-color:#353940; color:#fff;">No. of Pax</td> -->
        <td align="center"  style="padding:8px; background-color:#353940; color:#fff;">TAX(%)</td>
        <td align="right"  style="padding:8px; background-color:#353940; color:#fff;">Total Amount</td>
      </tr>
      <?php
      $select=''; 
      $where=''; 
      $rs='';   
      $select='*';  
      $where='queryid='.$resultinvoicepage['queryId'].' and quotationId='.$resultinvoicepage['quotationId'].' order by id desc'; 
      $rs=GetPageRecord($select,_PAYMENT_REQUEST_MASTER_,$where); 
      $resultpaymentpage=mysqli_fetch_array($rs); 

      $reshsn=GetPageRecord('*','sacCodeMaster','deleteStatus=0 and status=1 and setDefault=1'); 
      $resulthsn=mysqli_fetch_array($reshsn); 

      $select=''; 
      $where=''; 
      $rs='';   
      $select='*';  
      $where='paymentId="'.$resultpaymentpage['id'].'"  order by id desc'; 
      $rs=GetPageRecord($select,_AGENT_PAYMENT_REQUEST_,$where); 
      $requesetdata=mysqli_fetch_array($rs);  
      $reqclientGst=$requesetdata['reqclientGst'];
      $reqmarginGst=$requesetdata['reqmarginGst'];

      $tcs=0;
      if($requesetdata['reqclientTCS']>0){
        $tcs=$requesetdata['reqclientTCS'];
        $finalReqCost=$requesetdata['reqclientCost'];
      }

      if($reqclientGst!=0){
        $GST=$requesetdata['reqclientGst'];
        $Cgst=$requesetdata['reqclientCGst'];
        $Sgst=$requesetdata['reqclientSGst'];
        $Igst=$requesetdata['reqclientIGst'];
        $finalReqCost=$requesetdata['reqclientCost'];
      }

      if($reqmarginGst!=0){
        $GST=$requesetdata['reqmarginGst'];
        $Cgst=$requesetdata['reqmarginCGst'];
        $Sgst=$requesetdata['reqmarginSGst'];
        $Igst=$requesetdata['reqmarginIGst'];
        $finalReqCost=$requesetdata['reqmarginCost'];
      }


      $totalpendingamount=0;

      $s=1;
      $select2='*';
      $where2='queryId='.$resultinvoicepage['queryId'].''; 
      $rs2=GetPageRecord($select2,_DMC_PAYMENT_LIST_MASTER_,$where2); 
      while($listofpayment=mysqli_fetch_array($rs2)){
        $totalpendingamount=$totalpendingamount+$listofpayment['amount'];
      }



      // new costing code samay

      $isUni_Mark = $quotationData['isUni_Mark'];
      $clientGstType=$requesetdata['clientGstType'];

      // total agent paid amount
      $totalpaid = 0;
      $r3=GetPageRecord('sum(amount) as totalpaid, spm.*','agentPaymentMaster spm',' agentPaymentId="'.$requesetdata['id'].'" and paymentStatus=1'); 
      $agentPaymentData = mysqli_fetch_array($r3);
      $totalpaid = ($agentPaymentData['totalpaid']==0)?0:$agentPaymentData['totalpaid'];
       
      // total agent expenses
      $totalExpenseCost = 0;
      $exrs = GetPageRecord('*','quotationExpensesMaster',' quotationId="'.$quotationData['id'].'"');
      while($expenseData = mysqli_fetch_assoc($exrs)){
        $totalExpenseCost = $totalExpenseCost + $expenseData['expenseAmount'];
      }

      // costing components
      $companyCost = $quotationData['totalCompanyCost'];
      $clientCost = $quotationData['totalQuotCost'];

      $serviceMarkup = $markupType = $serviceTax = $totalDiscountCost = $serviceMarkup = $markupType = $serviceTax = 0;
      $totalMarkupCost = $totalServiceTaxCost = $totalTCSCost = 0;

      if($isUni_Mark == 1){
        $serviceMarkup = $quotationData['markupCost'];
        $markupType = $quotationData['markupType'];
        $serviceTax = $quotationData['serviceTax'];

        $totalTCSCost = $quotationData['totalTCSCost'];
      }

      $totalMarkupCost = $quotationData['totalMarkupCost'];
      $totalServiceTaxCost = $quotationData['totalServiceTaxCost'];

      $totalDiscountCost = $quotationData['totalDiscountCost'];

      // calcuations
      $clientCostWOGSTTCS = round($clientCost-$totalServiceTaxCost-$totalTCSCost);
      // $totalExpenseCost = $expenseAmount;
      $totalPendingAmt = $clientCost-$totalpaid;
 
      $cgstAmt = getTwoDecimalNumberFormat($quotationData['totalServiceTaxCost'] / 2);
      $sgstAmt = getTwoDecimalNumberFormat($quotationData['totalServiceTaxCost'] / 2);
      $igstAmt = 0;

      if($clientGstType == 2){
        $cgstAmt = $sgstAmt = 0;
        $igstAmt = $quotationData['totalServiceTaxCost'];
      } 
      ?>
      <tr>
        <td  valign="middle"><?php echo '1'; ?>  </td>
        <td  width="200" valign="middle" ><textarea class="particularcls" name="particularsubject" id="particularsubject" cols="40" rows="4"><?php echo $subject; ?></textarea>
         </td>
        <td  valign="middle"><input type="text" class="particularcls form-control" name="hsnCode" id="hsnCode" value="<?php echo $resulthsn['sacCode']; ?>" > </td>
        <td align="right" valign="middle"><?php echo round($clientCostWOGSTTCS); ?></td>
        <td align="center"  valign="middle"><?php echo $serviceTax; ?></td>
        <!-- <td align="center" ><?php echo $noofpax; ?></td> -->
        <!-- <td align="center" ><?php echo $noofpax; ?></td> -->
        <td align="right" valign="middle"><?php echo round($clientCostWOGSTTCS); ?></td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" >
  	  <div style="padding:10px 0px; font-weight:500; font-size:15px;"></div>
    	<script>
    	function loadinvoiceratefunction(){
    		$('#loadinvoicerate').load('loadinvoicerate.php?id=<?php echo $invoiceId; ?>&queryId=<?php echo $resultinvoicepage['queryId']; ?>&quotationId=<?php echo $resultinvoicepage['quotationId']; ?>');
    	}
    	
    	function addloadinvoiceratefunction(){
    		var name = encodeURIComponent($('#name').val());
    		var qty = 1;
    		var rate = encodeURIComponent($('#rate').val());
    		if(name!='' && qty!='' && rate!=''){
    		$('#loadinvoicerate').load('loadinvoicerate.php?id=<?php echo $invoiceId; ?>&name='+name+'&qty='+qty+'&rate='+rate+'&add=1');
    		}
    	} 
    	
    	function updateloadinvoiceratefunction(id){
    		var name = encodeURIComponent($('#editname').val());
    		var qty = '1';
    		var rate = encodeURIComponent($('#editrate').val());
    		if(name!='' && qty!='' && rate!=''){
    		$('#loadinvoicerate').load('loadinvoicerate.php?id=<?php echo $invoiceId; ?>&editname='+name+'&editqty='+qty+'&editrate='+rate+'&updateid='+id+'&update=1');
    		}
    	} 
    	
    	function dltloadinvoiceratefunction(did){ 
    	$('#loadinvoicerate').load('loadinvoicerate.php?id=<?php echo $invoiceId; ?>&did='+did+'&dlt=1');
    	} 
    	
    	function editloadinvoiceratefunction(eid){ 
    	$('#loadinvoicerate').load('loadinvoicerate.php?id=<?php echo $invoiceId; ?>&editid='+eid);
    	} 
    	</script>	
    </td>
  </tr>
  <tr>
  <td colspan="2" align="left" valign="top">
	<table   border="0" align="right" cellpadding="0" cellspacing="0" style="font-size: 15px;">
      <?php if($clientCostWOGSTTCS>0){ ?>    
      <tr>
        <td align="right" style="padding:8px;">Total Cost In&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</td>
        <td align="right" style="padding:8px; width:60px;">
          <span  style="font-weight:bold;"><?php echo round($clientCostWOGSTTCS); ?></span>
        </td>
      </tr>    
      <?php } ?>
 
      <?php if($cgstAmt!=0){ ?>  
      <tr>
        <td align="right" style="padding:8px;">CGST <?php if($isUni_Mark == 1){ echo $Cgst.'%'; } ?> </td>
          <td align="right" style="padding:8px;"><strong><?php echo round($cgstAmt); ?></strong>
          <input name="cgst" type="hidden" id="cgst" value="<?php echo round($cgstAmt); ?>" />
        </td>
      </tr>
      <?php } ?>
      <?php if($sgstAmt!=0){ ?>  
      <tr  >
        <td align="right" style="padding:8px;"><div class="form-group" style="margin-bottom:0px; padding-bottom:0px;"> 
          SGST <?php if($isUni_Mark == 1){ echo $Sgst.'%'; } ?> 
          </div>
        </td>
        <td align="right" style="padding:8px;"><strong><?php echo round($sgstAmt); ?></strong>
          <input name="sgst" type="hidden" id="sgst" value="<?php echo round($sgstAmt); ?>" />
        </td>
      </tr>
      <?php } ?>
	    <?php if($igstAmt!=0){ ?>
	    <tr>
        <td align="right" style="padding:8px;"><span class="header">IGST <?php if($isUni_Mark == 1){ echo $Igst.'%'; } ?> </span></td>
        <td align="right" style="padding:8px;"><strong><?php echo round($igstAmt); ?></strong>
          <input name="igst" type="hidden" id="igst" value="<?php echo round($igstAmt); ?>" />
        </td>
      </tr>
		  <?php }  ?> 

      <?php if($totalTCSCost!=0 && $isUni_Mark==1){ ?>
	    <tr>
        <td align="right" style="padding:8px;"><span class="header">TCS <?php if($isUni_Mark == 1){ echo $tcs.'%'; } ?> </span></td>
          <td align="right" style="padding:8px;"><strong><?php echo  $totalTCSCost; ?></strong>
          <input name="tcs" type="hidden" id="tcs" value="<?php echo $totalTCSCost; ?>" />
        </td>
        </tr>
		  <?php } ?> 
      <tr>
        <td align="right" style="padding:8px;">Total&nbsp;Tour Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>) </td>
        <td align="right" style="padding:8px;">
          <strong><?php echo round($clientCost); ?></strong>
          <input name="totalVal" type="hidden" id="totalVal" value="<?php echo $clientCost; ?>" />
          <input name="totalamount" type="hidden" id="totalamount" value="<?php echo $clientCost; ?>" />
        </td>
      </tr> 
      <?php if($newCurr!=$baseCurrencyId){ ?>
	    <tr>
        <td align="right" style="padding:8px;">Total&nbsp;Tour Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($newCurr); ?>) </td>
        <td align="right" style="padding:8px;">
          <strong><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$clientCost));  ?>
          </strong>
        </td>
      </tr>

    <?php } ?>
      <tr><td>&nbsp;</td></tr>
    <script>
  	  function calculateinvoice(){
    	  var subtotal = Number($('#subTotalval').val());
    	  if(subtotal==''){
    	    subtotal=0;
    	  }
    	  
    	  var discountValue = $('#discountValue').val(); 
    	  if(discountValue==''){
    	   discountValue=0;
    	  }
      	  
    	  var igst = Number($('#igst').val()); 
    	  if(igst==''){
    	   igst=0;
    	  }
  	  
  	    var sgst = Number($('#sgst').val()); 
    	  if(sgst==''){
    	   sgst=0;
    	  }
  	 
  	    var cgst = Number($('#cgst').val()); 
    	  if(cgst==''){
    	   cgst=0;
    	  }
  	  
    	  var managementFee = Number($('#managementFee').val()); 
    	  if(managementFee==''){
    	   managementFee=0;
    	  }
  	  
  	    var amountPaidValue = Number($('#amountPaidValue').val());
    	  if(amountPaidValue==''){
    	   amountPaidValue=0;
    	  }
  	  
    	  var finalvaluetotal = Number(subtotal-discountValue);
    	  igst = Number(igst*finalvaluetotal/100); 
    	  sgst = Number(sgst*finalvaluetotal/100); 
    	  cgst = Number(cgst*finalvaluetotal/100); 
    	  managementFee = Number(managementFee*finalvaluetotal/100); 
  	   
  	    finalvaluetotal = Number(igst+sgst+cgst+managementFee+finalvaluetotal);
    
        $('#total').text(finalvaluetotal); 
       // $('#totalVal').val(finalvaluetotal); 
    
        var total = Number($('#totalVal').val());
    	  if(total==''){
    	    total=0;
    	  }
    
    	  $('#balancedue').text(Number(total-amountPaidValue));
    	  $('#balancedueVal').val(Number(total-amountPaidValue));
  	  }
	  </script>

    </table>
    </td>
    </tr>
    <!-- Add bank details -->

    <table width="100%" border="1" cellpadding="6" cellspacing="0" bordercolor="#000000" style="border-radius: 5px; overflow:hidden;">

    <tr>
    <td align="center" style="padding:8px; background-color:#353940; color:#fff;min-width: 100px;">Bank Name</td>
    <td align="center" style="padding:8px; background-color:#353940; color:#fff;min-width: 80px;">Account Type</td>
        <td style="padding:8px; background-color:#353940; color:#fff;">Beneficiary Name</td>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;">Account Number</td>
        <td align="center" style="padding:8px; background-color:#353940; color:#fff;">Branch IFSC</td>
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

          <td align="left" valign="top" ><div class="form-group" style="position:static;"> 
				  <input type="text" name="beneficiaryName" class="form-control" id="beneficiaryName" displayname="Beneficiary Name" autocomplete="off" value="" /></input>
                </div></td>

    <td align="left" valign="top" ><div class="form-group">
          <input type="number" name="accountNumber" class="form-control" id="accountNumber" displayname="Account Number" autocomplete="off" min="0"></input>
                </div></td>

                <td align="left" valign="top"><div class="form-group">
          <input type="text" name="branchIfsc" class="form-control" id="branchIfsc" displayname="Branch IFSC" autocomplete="off" ></input>
                </div></td>

                <td align="left" valign="top"><div class="form-group">
          <input type="text" name="branchSwiftCode" class="form-control" id="branchSwiftCode" displayname="Branch SWIFT Code" autocomplete="off" ></input>
                </div></td> 

    <td align="left" valign="top"><div class="form-group">
          <input type="text" name="branchAddress" class="form-control" id="branchAddress" displayname="Branch Address" autocomplete="off" ></input>
                </div></td>
                                                                       
    </tr>
  </table>
  <div style="background-color:#feffbc; padding:0px; display:none;" id="loadbankdetail"></div>
<script>
  	function GetBankDetails(bankId){
				var bankId = $('#bankName').val();
				$('#loadbankdetail').load('load_invoicebankDetails.php?action=loadbankDetails&bankId='+bankId);
			}

      GetBankDetails();
</script>

    <!-- Add bank details end-->
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><div class="form-group">
                  <label for="exampleInputPassword1">Notes</label> 
				  <textarea name="invoiceNotes" rows="3" class="form-control" id="invoiceNotes" displayname="Location" autocomplete="off" style="height:100px;"><?php echo strip($invoiceNotes); ?></textarea>
                </div></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><div class="form-group">
                  <label for="exampleInputPassword1">Terms</label> 
				  <textarea name="terms" rows="3" class="form-control" id="terms" displayname="Location" autocomplete="off" style="height:100px;"><?php echo nl2br(strip_tags(stripslashes($invoicesetting['termscondition']))); ?></textarea>
                </div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><div class="form-group">
                  <label for="exampleInputPassword1">Payment</label> 
				  <input name="payment" type="text" class="form-control" id="payment" value="<?php echo strip($payment); ?>" displayname="Location" autocomplete="off" />
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
        <td><input name="editId" type="hidden" id="editId" value="<?php echo $resultinvoicepage['id']; ?>" />
		<input name="queryId" type="hidden" id="queryId" value="<?php echo $queryId; ?>" />
		 <input name="mice" type="hidden" id="mice" value="<?php echo $_REQUEST['mice']; ?>" />
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
	 
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

comtabopenclose('linkbox','op2');

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
}



function showDays(firstDate,secondDate){ 
                  var startDay = new Date(firstDate);
                  var endDay = new Date(secondDate);
                  var millisecondsPerDay = 1000 * 60 * 60 * 24;

                  var millisBetween = startDay.getTime() - endDay.getTime();
                  var days = millisBetween / millisecondsPerDay;

                  // Round down.
                  return ( Math.floor(days));

              }

 

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
   
  
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  } 
} 

function selectInvoiceType() {
  var invoiceType = $('#invoiceType').val();
  if(invoiceType == 2){
    $('#invoiceTypedisplay').text('PROFORMA INVOICE');
    $("#invoiceNo").val('<?php echo $companyPAN['proformaInvoiceNoSequence'].'/'.makeInvoiceId($resultinvoicepage['id']); ?> ');
  }else{
    $('#invoiceTypedisplay').text('TAX INVOICE');
    
    $("#invoiceNo").val('<?php echo $companyPAN['taxInvoiceNoSequence'].'/'.makeInvoiceId($resultinvoicepage['id']);?>' );
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
</style>
<script>
loadinvoiceratefunction();
calculateinvoice();
</script>