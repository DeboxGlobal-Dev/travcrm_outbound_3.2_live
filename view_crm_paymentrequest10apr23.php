<?php
if($viewpermission!=1 && $_GET['id']!=''){
	header('location:'.$fullurl.'');
}

if($_GET['id']!=''){

	$queryidtable=_QUERY_MASTER_;
	$querymailidtable=_QUERY_MAILS_SECTION_MASTER_;

	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$id=clean(decode($_GET['id'])); 
	$where='id='.$id.''; 
	$rs=GetPageRecord($select,_PAYMENT_REQUEST_MASTER_,$where); 
	$resultpaymentpage=mysqli_fetch_array($rs);  


	if($resultpaymentpage['quotationId'] == 0){
	    $quotationDataq = '';
	}
	else{
	    $quotationDataq = ' and id='.$resultpaymentpage['quotationId'].'';	
	}

	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$id=clean($resultpaymentpage['queryid']); 
	$where='id='.$id.''; 
	$rs=GetPageRecord($select,$queryidtable,$where); 
	$resultpage=mysqli_fetch_array($rs); 
	$rs222=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$resultpage['id'].'" '.$quotationDataq.' and status=1 order by id asc'); 
	$quotationData=mysqli_fetch_array($rs222);

	// quotation Data
	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];

	$dayroe = $quotationData['dayroe'];
	// GST DATA 
	$serviceTax = 0;
	if ($quotationData['serviceTax']>0) {
	    $serviceTax = $quotationData['serviceTax'];
	}

	// Commission DATA
	$commissionType = $quotationData['commissionType'];
	$ISOCommission = $quotationData['ISOCommission'];
	$ConsortiaCommission = $quotationData['ConsortiaCommission'];
	$ClientCommission = $quotationData['ClientCommission'];
	$tcs = $quotationData['tcs'];

	// DISCOUNT DATA
	$discountType = $quotationData['discountType'];
	$discount = $quotationData['discount'];

	// MARKUP DAta
	// $c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="' . $quotationId . '"');
	// $serviceMarkuD = mysqli_fetch_array($c12);

	$serviceMarkup = $markupType = 0;
	if($quotationData['isUni_Mark'] == 1){
	    $serviceMarkup = $quotationData['markupCost'];
	    $markupType = $quotationData['markupType'];
	} 

	$displayId = makeQuotationId($quotationId);
	 
	$select=''; 
	$where=''; 
	$rs='';   
	$select='email';  
	$where='id='.$resultpage['assignTo'].''; 
	$rs=GetPageRecord($select,_USER_MASTER_,$where); 
	$resultpageassignemail=mysqli_fetch_array($rs);

	$select=''; 
	$where=''; 
	$rs='';   
	$select='*';  
	$where='id=1'; 
	$rs=GetPageRecord($select,$querymailidtable,$where); 
	$resultpageemail=mysqli_fetch_array($rs);  


	if($resultpage['clientType']!=2){

	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$id=clean($resultpage['companyId']); 
	$where='id='.$id.''; 
	$rs=GetPageRecord($select,_CORPORATE_MASTER_,$where); 
	$resultcompany=mysqli_fetch_array($rs);  

	$mobilemailtype='corporate';
	} 
	if($resultpage['clientType']==2){

	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$id=clean($resultpage['companyId']); 
	$where='id='.$id.''; 
	$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
	$resultcompany=mysqli_fetch_array($rs);  

	$mobilemailtype='contacts';
	} 

	$exrs = GetPageRecord('*','quotationExpensesMaster',' queryId="'.$quotationData['queryId'].'"');
	while($expenseData = mysqli_fetch_assoc($exrs)){
		$expenseAmount = $expenseAmount + $expenseData['expenseAmount'];
	}

	?>
	<link href="css/main.css" rel="stylesheet" type="text/css" />
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

	<style>
	.maintoph{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
	body{background-color:#eae9ee !IMPORTANT;}
	.costtabsbox {
	    float: left;
	    text-align: left;
	    margin-right: 10px;
	    padding: 5px 15px;
	    border-radius: 4px;
	    box-shadow: 2px 2px 1px #5077994a;
	    background-color: #f6fafe;
	    padding-top: 10px;
	}
	</style>
	<div style="display:none">
		<?php 
		// update cost to quotationMaster if not updated  
	    $rs211=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationData['id'].'" '); 
	    $resultpageQuotation=mysqli_fetch_array($rs211);
	    
	    $rs12 = GetPageRecord('*', _QUERY_MASTER_, 'id='.($resultpageQuotation['queryId']).'');
	    $resultpage = mysqli_fetch_array($rs12);

		// quotation Data
		$quotationId = $resultpageQuotation['id'];
		$queryId = $resultpageQuotation['queryId'];
		$_REQUEST['finalcategory'] = 0;
		if(empty($quotationData['totalQuotCost'])){
	 
		    if($quotationData['calculationType']==2){
				include_once("loadPackageWiseCostSheet.php");
		    }elseif($quotationData['calculationType']==3){ 
				include_once("loadCompletePackageCostSheet.php");
		    }else{
				include_once("loadCostSheet.php");
			}
	 
			if(!isset($_SESSION['page_refreshed'])){
				// execute the header refresh
				header('Refresh: 5');
				// echo 'not cost';
				// die();
				// set the session variable to stop refresh again and again
				$_SESSION['page_refreshed'] = true;
			}
		}
		?>
	</div>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	  	<!-- start left sidebar -->
	    <td width="15%" align="left" valign="top" class="queryleft">
	    	<div class="innerdiv" style="width:100% !important;">
		
			<div class="contentbox" style="background-color: rgba(0,0,0,0.2);"><div class="lables">Query ID</div> 
			<div style="font-size:24px;"><?php echo $displayId; ?></div>
			</div> 
			
			<div class="contentbox">
			  <div class="lables">Query Date</div> 
			  <?php echo showdate($quotationData['fromDate']); ?>	</div>
			
			<div class="contentbox">
			  <div class="lables">Check In</div> 
			  <?php echo showdate($quotationData['fromDate']); ?>	</div>
			
			<div class="contentbox">
			  <div class="lables">Check Out</div> 
			  <?php echo showdate($quotationData['toDate']); ?>	</div>
			
			 
			<div class="contentbox">
			  <div class="lables">Destination&nbsp;</div><?php
			$cityIdQuery=$ctn="";
			$cityIdQuery=GetPageRecord('cityId','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'"  and addstatus=0 group by cityId');
			while($cityIdData=mysqli_fetch_array($cityIdQuery)){
				$ctn .= getDestination($cityIdData['cityId']).", ";
			} echo rtrim($ctn,', ');
			?></div>
			 
			<div class="contentbox">
			  <table width="100%" border="0" cellpadding="2" cellspacing="0">
		          <tr>
		            <td align="center"><div style="background-color:#232a32; margin-right:2px; padding:4px;"><div class="lables">Adult</div><?php echo $quotationData['adult']; ?></div></td>
		            <td align="center" ><div style="background-color:#232a32; margin-right:2px;padding:4px;"><div class="lables">Child</div><?php echo $quotationData['child']; ?></div></td>
		            </tr>
		        </table>   
			</div>
		
			<div class="contentbox">
			  <table width="100%" border="0" cellpadding="2" cellspacing="0">
		          <tr>
		            <td align="center" ><div style="background-color:#232a32; margin-right:2px;padding:4px;"><div class="lables">Nights</div><?php echo $quotationData['night']; ?></div></td>
		            <td align="center" ><div style="background-color:#232a32;padding:4px;font-size: 10px;">
		              <div class="lables">Rooms</div>
		              <?php 
					  $sglR = "";
					  if($quotationData['sglRoom']>0){ $sglR .= "SGL ".$quotationData['sglRoom'].", "; }
					  if($quotationData['dblRoom']>0){ $sglR .= "DBL ".$quotationData['dblRoom'].", "; }
					  if($quotationData['twinRoom']>0){ $sglR .= "TWIN ".$quotationData['twinRoom'].", "; }
					  if($quotationData['tplRoom']>0){ $sglR .= "TPL ".$quotationData['tplRoom'].", "; }
					  echo rtrim($sglR,", ");  ?></div></td>
		          </tr>
		        </table>   
			</div>
			  
			<?php if($resultpage['guest1']!=''){ ?>
			<div class="contentbox">
			  <div class="lables">Guest 1</div> 
			  <?php echo ($resultpage['guest1']); ?>	</div>
			<?php } ?>
			<?php if($resultpage['guest1phone']!=''){ ?>
			<div class="contentbox">
			  <div class="lables">Guest 1 Phone</div> 
			  <?php echo ($resultpage['guest1phone']); ?>	</div>
			<?php } ?>
			<?php if($resultpage['guest1email']!=''){ ?>
			<div class="contentbox">
			  <div class="lables">Guest 1 Email</div> 
			  <?php echo ($resultpage['guest1email']); ?>	</div>
			<?php } ?>
			<div class="contentbox">
			  <div class="lables">Payment Mode</div> 
			  <?php if($resultpage['paymentMode']==1){ echo 'BTC'; } else { echo 'Direct Payment'; } ?>
			</div>
			<?php if($resultpage['guest2']!=''){ ?>
			<div class="contentbox">
			  <div class="lables">Guest 2</div> 
			  <?php echo ($resultpage['guest2']); ?>	</div>
			<?php } ?>
			 <div class="contentbox" ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>" style="color:#fff;  font-size:12px;" target="_blank">View Full Details</a> </div>
			
			 
		</div>
		</td>
		<!-- end of the left sidebar -->

		<!-- start of the right panel -->

	    <td width="85%" align="left" valign="top" class="queryright">
		
			<div class="contentboxaddagent">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td><div class="headingm" style="margin-left:20px;">Payment Information</div></td> 
				<td width="10%"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId);?>&b2bquotation=1">
					<input type="button" name="Submit22" value="Back" class="whitembutton"></a></td> 
			</tr>
			</tbody>
			</table>
			</div>
		<style>
				.activey{padding:10px 20px; float:left;  font-size:15px;background-color:#ffc115 !important; color:#fff !important; margin-left:5px;  border:1px solid #fff; font-weight:bold;}
				.activewhite{background-color:#fff; color:#000; border:1px solid #fff;padding:10px 20px; float:left;  font-size:15px;}
				 
				.clientcommubox{background-color:#fff; border:1px #b5cae0 solid; display: inline-table; width:30%; margin:0px 10px; text-align:left;height: 464px;}
				.clientcommubox .h{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
				.maintoph{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
				.clientcommubox .bodycontbox{padding:15px; border-bottom:1px #b5cae085 solid; color:#516b88;}
				.clientcommubox .textfieldb{padding:10px; border:1px #b5cae085 solid; width:40px;  }
				.clientcommubox .bodycontboxfooter{padding:15px;  color:#516b88; background-color:#dfebf6;}
				.clientcommubox .buttonbox{padding:15px;}

				.costtabsbox {
				    float: left;
				    text-align: left;
				    margin-right: 10px;
				    padding: 5px 15px;
				    border-radius: 4px;
				    box-shadow: 2px 2px 1px #5077994a;
				    background-color: #f6fafe;
				    padding-top: 10px;
				}

				.paymentboxtable {
				       border-bottom: 1px #b5cae085 solid !important; padding:7px;
				    background-color: #fff !important; font-weight:500 !important;  color:#6f8ba9 !important; font-weight:normal !important;
				}

				.paymentboxtablelist {
				       border-bottom: 1px #b5cae085 solid !important; padding:7px;
				    background-color: #fff !important;
				}
		</style>
		<div style="overflow:hidden; border-bottom:2px #ffc115 solid; height:43px;">
			<a  href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo $_REQUEST['id']; ?>"  class="activewhite<?php if($_REQUEST['dmc']!=1 && $_REQUEST['rem']!=1 && $_REQUEST['sup']!=1){ ?> activey<?php } ?>">Supplier Payment Information</a>
			<a  href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo $_REQUEST['id']; ?>&dmc=1" class="activewhite<?php if($_REQUEST['dmc']==1){ ?> activey<?php } ?>">Agent/Client Payment Information</a>
		</div>

	<!-- start agent / client payment code -->
	<?php 
	// dmc - client payment request box
	if($_REQUEST['dmc']==1){ 

	if($_REQUEST['alert']==1){ ?>
	<script>
	alert('Please cancel the invoice to cancel the query');	
	</script>	
	<?php } ?>	
		<div  style="padding: 10px 18px; background-color:#FBFBFB; display:none;border-bottom: 2px #ccc solid;" id="invoicetop">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
		  <tr>
		    <td colspan="2" align="left" style="font-size:20px;"><strong>Invoice</strong></td>
		    <td align="right"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&invoice=1" target="_blank"><input name="addnewuserbtn" type="button" class="greenmbutton3 submitbtn" id="addnewuserbtn" value="Send Invoice"   style="margin-right:0px;"></a><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Back" onclick="loadPaymentRequestdmc('','');$('#invoicetop').hide();" style="margin-right:0px;"></td>
		  </tr>
		</table>
		</div>
		<!-- load agent/client complete page here -->
		<div id="loadPaymentRequestdmc"></div>

		<script>
		function loadPaymentRequestdmc(deleteid,savereqeust){
		$('#loadPaymentRequestdmc').load('loadPaymentRequestdmc.php?id=<?php echo ($queryId); ?>&paymentid=<?php echo $_REQUEST['id']; ?>&deleteId='+deleteid+'&savereqeust='+savereqeust)

		}
		loadPaymentRequestdmc('','');

		function invoicedmc(){ 
			$('#loadPaymentRequestdmc').load('loaddmcinvoice.php?id=<?php echo ($queryId); ?>');
		}
		</script>
		<?php 
	} ?>
	  
	<?php 
	if($_REQUEST['dmc']!=1 && $_REQUEST['rem']!=1 && $_REQUEST['sup']!=1){ ?>
	 	<!-- supplier paid payment listing -->
	 	<div class="paymentboxmain" style="background-color:#ffffff;border-bottom:0px;padding: 7px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style=" border-bottom: 0px;">
			<tr>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Supplier Name</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Payment Type</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Amount</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Attachement</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Payment By</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Remarks</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Added By</th>
			</tr>
			<?php
			$totalpaid=0;
			$s=1;  
			$rs2=GetPageRecord('*','supplierPaymentMaster','1 and quotationId="'.$quotationId.'" and paymentStatus=1 order by supplierStatusId,dateAdded ASC'); 
			while($supplierPaidData=mysqli_fetch_array($rs2)){ 
				?>
				  <tr>
				    <td class="paymentboxtable">
					<?php
					if($supplierPaidData['supplierStatusId']!='0'){
						$rs1="";  
						$rs1=GetPageRecord('supplierId','finalQuotSupplierStatus',' id="'.$supplierPaidData['supplierStatusId'].'" and deletestatus=0'); 
						$supplierStatusD=mysqli_fetch_array($rs1);

						$rs21="";  
	 					$rs21=GetPageRecord("*",_SUPPLIERS_MASTER_,'id="'.$supplierStatusD['supplierId'].'"'); 
						$editresultname=mysqli_fetch_array($rs21);
						?><?php echo clean($editresultname['name']);
					} 
					else { echo 'All Supplier'; }
				 	?>	
				 	</td>
				    <td class="paymentboxtable"><?php if($supplierPaidData['paymentType'] == 1){ echo "On Credit"; }elseif($supplierPaidData['paymentType'] == 2){ echo "Advanced";  }elseif($supplierPaidData['paymentType'] == 3){ echo "Direct&nbsp;Payment";  }else{ echo "Full Payment"; } ?></td>
				    <td class="paymentboxtable"><?php echo $supplierPaidData['amount']; $totalpaid=$supplierPaidData['amount']+$totalpaid; ?></td>
				    <td class="paymentboxtable"><?php if($supplierPaidData['fileUpload']!=''){ ?><a href="<?php echo $fullurl; ?>download/<?php echo $supplierPaidData['fileUpload']; ?>" target="_blank">Attachment</a><?php } ?></td>
				    <td class="paymentboxtable"><?php echo $supplierPaidData['paidBy']; ?></td>
				    <td class="paymentboxtable"><?php 
						echo clean($supplierPaidData['details']);
						?>			
					</td>
				    </tr>
					<?php $s++; 
			} ?>
			</table>
			<?php if($s==1){ ?>
			<div style="text-align:center;display:nones;" class="paymentboxtable">No Payment History -  </div>
			<?php } ?>
		</div>
		<!-- supplier payment costSheet -->
	 
		<!-- supplier payment boxs -->
	 	<div style="padding:10px 20px; overflow:hidden;text-align:left; margin-top:0px; background-color:#a7bed5;border-bottom: 1px solid #fff;">
			<?php 
			// costing components
			$companyCost = $quotationData['totalCompanyCost'];
			$clientCost = $quotationData['totalQuotCost'];

			$totalMarkupCost = $quotationData['totalMarkupCost'];
			$totalDiscountCost = $quotationData['totalDiscountCost'];
			$totalServiceTaxCost = $quotationData['totalServiceTaxCost'];
			$totalTCSCost = $quotationData['totalTCSCost'];

			// calcuations
			$totalExpenseCost = $expenseAmount;
			$totalPendingAmt = $companyCost-$totalpaid;
			?>
			<div  class="costtabsbox">
				<div class="costtabamt">Purchase</div>
				<div style="font-size:24px;" id="totalCompanyCost">
					<?php echo round($companyCost); ?>
				</div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">Paid Amt</div>
				<div style="font-size:24px;color:#009900;" id="totalCompanyCost"><?php echo round($totalpaid);?></div>
			</div>
			
		 	<div  class="costtabsbox">
				<div class="costtabamt">Pending Amt</div>
				<div style="font-size:24px; text-align:right;" ><?php 
					if(empty($totalPendingAmt)){  ?>
					<div style="font-size:24px;  color:#009900;" id="totalPending">Paid</div>
					<?php } else { ?>
					<div style="font-size:24px; color:#CC3300;text-align:right;" id="totalPending"><?php echo $totalPendingAmt; ?></div>
					<?php } ?>
				</div>
			</div>
			
			<div  class="costtabsbox">
				<div class="costtabamt">Sell Amt</div>
				<div style="font-size:24px;" id="totalClientCost"><?php echo round($clientCost); ?></div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">Tax Amt</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalServiceTaxCost); ?></div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">TCS Amt</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalTCSCost); ?></div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">Discout</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalDiscountCost); ?></div>
			</div>
			<div  class="costtabsbox">
				<div class="costtabamt">Expenses</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalExpenseCost); ?></div>
			</div>
			<div  class="costtabsbox">
				<div class="costtabamt">
					<span style=" color: #6f6f6f; font-size: 12px; font-weight: 500;">Net Margin</span>
				</div>
				<div style="font-size:24px;" id="totalMargin"><?php echo round($totalMarkupCost-$totalExpenseCost-$totalDiscountCost); ?></div>
		 	</div>
		 	<div  class="costtabsbox" style="float:right;margin-right: 15px;cursor:pointer;" 
				<?php 
				if($quotationData['calculationType']==2){ ?>
				onclick="alertspopupopen('action=addCostSheet_packagewise&quotationId=<?php echo $quotationId; ?>','1300px','auto');" 
				<?php }elseif($quotationData['calculationType']==3){ ?>
				onclick="alertspopupopen('action=addCostSheet_completepackage&quotationId=<?php echo $quotationId; ?>','800px','auto');"
				<?php }else{ ?>
				onclick="<?php if($quotationData['quotationType']==2 && $quotationData['status']!=1){ ?>alertspopupopen('action=selectCostSheet&quotationId=<?php echo $quotationId; ?>','400px','auto');<?php } else{ ?>alertspopupopen('action=addCostSheet&quotationId=<?php echo $quotationId; ?>','1300px','auto');<?php } ?>"
				<?php } ?>
				>
				<div style="font-size:12px; text-transform:uppercase; font-weight:500; color: #5f81a3;"><span style=" color: #6f6f6f; text-transform: uppercase;  font-weight: 500;">Suppliers</span></div>
				<div style="font-size:24px">Cost Sheet</div> 
		 	</div>
		</div>

		<?php 	
		$namevalue ='supplierPendingamount="'.$totalPendingAmt.'",queryId="'.$queryId.'"';   
		$where='id="'.clean($resultpaymentpage['id']).'"';  
		$voucherlastid = updatelisting(_PAYMENT_REQUEST_MASTER_,$namevalue,$where);  
		?>

	 	<!-- load supplier payment page  -->
		<div id="loadpaymentsupplierlist"></div>
		<script>
		function loadsupplistmain(){
		$('#loadpaymentsupplierlist').load('loadpaymentsupplierlist.php?paymentId=<?php echo $resultpaymentpage['id']; ?>&queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>');
		}
		loadsupplistmain();
		</script>
		<?php 
	} 
	?>
	</td>
	</tr>
	</table>

	<div style="display:none;" id="changequerystatusdiv"></div>

	<script>  
	function changequerystatus(id){  
	$('#changequerystatusdiv').load('frmaction.php?action=changequerymailstatus&id='+id);  
	}


	function showcontenttab(id){
	$('.displaytab').hide();
	$('.querymaillisting').show();
	$('#maintab'+id).hide();
	$('#displaymaintab'+id).show();
	}
	function hidecontenttab(id){
	$('#maintab'+id).show();
	$('#displaymaintab'+id).hide();
	}
	$('#replymainbox').hide();
	comtabopenclose('linkbox','op2');
	</script>
	<?php 
} ?>

