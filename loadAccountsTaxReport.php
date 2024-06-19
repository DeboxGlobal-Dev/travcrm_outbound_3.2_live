<?php 
ob_start();
include "inc.php"; 
include "config/logincheck.php"; 
?>


<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>
    
    <link href="css/datatablec.css" rel="stylesheet"/>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


<!-- <h3 class="cms_title">Tax Report</h3>  -->
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}
		#dataTable_filter{
			position: absolute;
    		font-size: 15px;
			top: -70px;

		}
		#dataTable_wrapper{
			width: 41%;
			position: relative;
			margin-top: 25px;
		}
		.saleperson1{
			display: none;
		}
	
</style>
<div class="search-sec-year">
<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
	<td class="reportfilter"  >
		<select style=" padding: 7px; " id="yearCode12">
			<option value="">Select Year</option>
			<option value="2025" <?php if($_REQUEST['yearCode']=='2025' || ( date('Y')=='2025' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2025</option>
			<option value="2024" <?php if($_REQUEST['yearCode']=='2024' || ( date('Y')=='2024' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2024</option>
			<option value="2023" <?php if($_REQUEST['yearCode']=='2023' || ( date('Y')=='2023' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2023</option>
			<option value="2022" <?php if($_REQUEST['yearCode']=='2022' || ( date('Y')=='2022' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2022</option>
			<option value="2021" <?php if($_REQUEST['yearCode']=='2021' || ( date('Y')=='2021' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2021</option>
			<option value="2020" <?php if($_REQUEST['yearCode']=='2020' || ( date('Y')=='2020' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2020</option>
			<option value="2019" <?php if($_REQUEST['yearCode']=='2019' || ( date('Y')=='2019' && $_REQUEST['yearCode']=='')){ ?>selected="selected"<?php } ?>>2019</option>
		</select>
	</td>
	<td class="reportfilter"  >
		<select style=" padding: 7px; " id="monthCode12">
			<option value="">Select Month</option>
			<option value="1" <?php if($_REQUEST['monthCode']=='1' || ( date('m')=='1' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Jan</option>
			<option value="2" <?php if($_REQUEST['monthCode']=='2' || ( date('m')=='2' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Feb</option>
			<option value="3" <?php if($_REQUEST['monthCode']=='3' || ( date('m')=='3' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Mar</option>
			<option value="4" <?php if($_REQUEST['monthCode']=='4' || ( date('m')=='4' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Apr</option>
			<option value="5" <?php if($_REQUEST['monthCode']=='5' || ( date('m')=='5' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>May</option>
			<option value="6" <?php if($_REQUEST['monthCode']=='6' || ( date('m')=='6' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Jun</option>
			<option value="7" <?php if($_REQUEST['monthCode']=='7' || ( date('m')=='7' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Jul</option>
			<option value="8" <?php if($_REQUEST['monthCode']=='8' || ( date('m')=='8' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Aug</option>
			<option value="9" <?php if($_REQUEST['monthCode']=='9' || ( date('m')=='9' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Sep</option>
			<option value="10" <?php if($_REQUEST['monthCode']=='10' || ( date('m')=='10' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Oct</option>
			<option value="11" <?php if($_REQUEST['monthCode']=='11' || ( date('m')=='11' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Nov</option>
			<option value="12" <?php if($_REQUEST['monthCode']=='12' || ( date('m')=='12' && $_REQUEST['monthCode']=='')){ ?>selected="selected"<?php } ?>>Dec</option>
		</select>
	</td>
	<td class="reportfilter" onclick="getAccountsTaxReportfun(12);" ><span style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;padding: 8px;">Search</span></td>
  </tr>
</table>
</div>
<div style="padding: 15px;padding-left: 0;text-align: left;display: block;position: relative;width: 86%;">
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalSaleCost">0</div>
	<div class="text">Total Sales Amount</div> 
	</div> 
	

	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalIGST">0</div>
	<div class="text">Total IGST </div>
	</div>
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalCGST">0</div>
	<div class="text">Total CGST</div>
	</div>
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalSGST">0</div>
	<div class="text">Total SGST</div>
	</div>
	 
</div>
		   
<!-- <div style="border: 1px solid #ccc; padding: 10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Receivable Report : 
    	<?php 
    	// if($_REQUEST['yearCode']!='' && $_REQUEST['monthCode']!=''){ 
		// 		$filterFromDate  = date($_REQUEST['yearCode'].'-'.$_REQUEST['monthCode'].'-01');
		// 		$filterToDate  = date($_REQUEST['yearCode'].'-'.$_REQUEST['monthCode'].'-t');
  		// 	echo date('M, Y',strtotime($filterFromDate)); 
    	// }else{
    	// 	$filterFromDate  = date('Y-m-01');
		// 		$filterToDate  = date('Y-m-01');
  		// 	echo date('M, Y',strtotime($filterFromDate));
    	// } 
    	?></div></td>
  </tr>
  
</table>
</div> -->
<table width="100%" id="dataTable" border="0" cellpadding="10" cellspacing="0" class="taxborder" style="margin-top: 30px;">  
	<thead>
	<tr style="background-color: rgb(230, 230, 230);">
	<th width="100" align="center" ><strong>Tour&nbsp;CODE</strong></th>
	<th style="width: 100px !important;" align="left" ><strong>INVOICE&nbsp;NO.</strong></th>
	<th width="100" align="center"><strong>INVOICE&nbsp;DATE</strong></th>
	<th width="100" align="center"><strong>STATUS</strong></th>
	<th width="100" align="center"><strong>LEAD&nbsp;PAX NAME</strong></th>
	<th width="100" align="center"><strong>TOTAL&nbsp;PAX</strong></th>
	<th width="100" align="center" ><strong>AGENT&nbsp;NAME</strong></th>
	<th width="100" align="center" ><strong>GSTN</strong></th>
	<th width="100" align="center" ><strong>COUNTRY</strong></th>
	<th width="100" align="center" ><strong>PLACE&nbsp;OF SUPPLY</strong></th>
	
	<th width="100" align="center" ><strong>OPERATION&nbsp;NAME</strong></th>
	<th width="100" align="center" ><strong>SALES&nbsp;NAME</strong></th>
	<th width="100" align="center" ><strong>DEPARTMENT</strong></th>
	<th width="50" align="center" ><strong>CURRENCY</strong></th>
	<td width="100" align="right"><strong>TAXABLE&nbsp;AMT</strong></td>
	<td width="100" align="right"><strong>TAX&nbsp;RATE</strong></td>
	<td width="100" align="right"><strong>IGST</strong></td>
	<td width="100" align="right"><strong>CGST</strong></td>
	<td width="100" align="right"><strong>SGST</strong></td>
	<td width="100" align="center"><strong>TOTAL&nbsp;TOUR<br>COST</strong></td>
	<td width="100" align="center"><strong>ROE</strong></td>
	<th width="100" align="center"><strong>TAXABLE&nbsp;AMT<br>(INR)</strong></th>
	<td width="100" align="center"><strong>TAX&nbsp;RATE<br>(INR)</strong></td>
	<th width="100" align="center"><strong>IGST(INR)</strong></th>
	<th width="100" align="center"><strong>CGST(INR)</strong></th>
	<th width="100" align="center"><strong>SGST(INR)</strong></th>
	<th width="100" align="center"><strong>TOTAL&nbsp;TOUR<br>COST(INR)</strong></th>
	<!-- <td width="100" align="center"><strong>TOTAL&nbsp;TOUR<br>COST(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td> -->
	</tr>
	</thead>
	<tbody>
	<?php  
	if($_REQUEST['daterange']!=''){
		$myString = $_REQUEST['daterange'];
                $myArray = explode(' - ', $myString);  
                $fromDate = $myArray[0];
                $toDate = $myArray[1];
                $daterange = 'and invoicedate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
	}

	$no=1;
	
	$agentQuery=''; 
	if($_REQUEST['agentCode']>0){  
		$agentQuery=' and queryId in ( select id from queryMaster where 1 and companyId="'.$_REQUEST['agentCode'].'" and clientType=1 ) ';
	} 

	$invoiceTitle='';
	if($_REQUEST['invoiceTitle']>0){

		$invoiceTitle = 'and invoiceType="'.$_REQUEST['invoiceTitle'].'"';
	}

	$Totalsaleamount = $TotalIgst = $TotalCgst = $TotalSgst = 0;
	$outputTax = '';
	$where=' quotationId in ( select id from quotationMaster where status=1 ) '.$invoiceTitle.' '.$daterange.' order by id desc';
	$rs=GetPageRecord('*',_INVOICE_MASTER_,$where);
	while($invoiceData=mysqli_fetch_array($rs)){ 

		$rs2=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$invoiceData['quotationId'].'" ');
		$quotationData=mysqli_fetch_array($rs2);
		$totalPax = $quotationData['adult']+$quotationData['child'];
		$rs1=GetPageRecord('*',_QUERY_MASTER_,'id="'.$invoiceData['queryId'].'" ');
		$getqueryId=mysqli_fetch_array($rs1);
		//echo $getqueryId['clientType'];
		if($getqueryId['clientType']!=2){
			$rs2=GetPageRecord('name','corporateMaster ','companyTypeId="'.$getqueryId['companyId'].'"');
			$getcompanyid=mysqli_fetch_array($rs2);
			//echo $getcompanyid['companyTypeId'];
			$getClientName=$getcompanyid['name'];
		}
		if($getqueryId['clientType']==2){
			$rs3=GetPageRecord('firstName','contactsMaster ','id="'.$getqueryId['companyId'].'"');
			$getclientlist=mysqli_fetch_array($rs3);
			// print_r($getclientlist);
			$getClientName=$getclientlist['firstName'];
		}

		if($getqueryId['clientType']!=2){
			$resulttype='corporate';
		}if($getqueryId['clientType']==2){
			$resulttype='contacts';
		}
		if($resulttype!=''){
			$select6='*';
			$where6='addressType="'.$resulttype.'" and addressParent="'.$getqueryId['companyId'].'"';
			$rs6=GetPageRecord($select6,_ADDRESS_MASTER_,$where6);
			$address=mysqli_fetch_array($rs6); 
		}

		//////////////////////////////////get all gst ///////////////////////////
 
		$Totalsaleamount = $Totalsaleamount+$invoiceData['amount'];
		$TotalIgst = $TotalIgst+$invoiceData['igst'];
		$TotalCgst = $TotalCgst+$invoiceData['cgst'];
		$TotalSgst = $TotalSgst+$invoiceData['stg'];

		$totalTaxAMT = $invoiceData['cgst']+$invoiceData['stg']+$invoiceData['igst'];
		$rsAg=GetPageRecord('*','agentPaymentRequest','quotationId="'.$quotationData['id'].'" ');
		$agentPaymentData=mysqli_fetch_array($rsAg);
		$taxableAmount = $agentPaymentData['reqclientCost'];
		$reqclientGst = $agentPaymentData['reqclientGst'];
		$reqclientCGst = $agentPaymentData['reqclientCGst'];
		$reqclientIGst = $agentPaymentData['reqclientIGst'];
		$reqclientSGst = $agentPaymentData['reqclientSGst'];

		//////////////////////////////////end gst code here////////////////////
		if($invoiceData['deletestatus']==0){
			$invoiceStatus = '<div style="color:green;">Active</div>';
		}elseif($invoiceData['deletestatus']==1){
			$invoiceStatus = '<div style="color:red;">Cancelled</div>';
		}

		$crRS = GetPageRecord('*','queryCurrencyMaster','id="'.$quotationData['currencyId'].'"');
		$currencyName = mysqli_fetch_array($crRS);

		if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
			$newCurr = $baseCurrencyId;
		}else{
			$newCurr = $quotationData['currencyId'];
		}

		?>
		<tr><td align="center"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($invoiceData['queryId']); ?>"> <?php echo clean($invoiceData['tourId']) ?> </a></td>
		
		<td align="center" width="100"><div class="bluelink" style="width: 100px;">
		<a href="tcpdf/examples/getInvoicepdf.php?pageurl=<?php echo $fullurl; ?>invoicepdf.php?id=<?php echo encode($invoiceData['id']); ?>" target="_blank"> <?php echo makeInvoiceId($invoiceData['id']) ?></a></div></td>
		<td align="center">
		<?php
		if($invoiceData['invoicedate']!=''){ 
		echo showdate($invoiceData['invoicedate']);
		}
		?></td>
		<td align="center"><?php echo $invoiceStatus; ?></td>
		<td align="center"><?php echo $getqueryId['leadPaxName']; ?></td>
		<td align="center"><?php echo $totalPax; ?></td>
		<td align="center" >
		<?php echo showClientTypeUserName($getqueryId['clientType'],$getqueryId['companyId']); ?>
		</td>
		<td align="center"><?php echo $address['gstn']; ?></td>
		<td align="center"><?php echo showClientTypeCountry($getqueryId['clientType'],$getqueryId['companyId']); ?></td>
		<td align="center"><?php echo $invoiceData['deliveryPlace']; ?></td>
		
		<td  align="center"><?php echo getUserName($getqueryId['assignTo']); ?></td>
		<td  align="center"><?php echo strip($getqueryId['salesassignTo']); ?></td>
		<td align="center"><?php echo showClientTypeUserDepartment($getqueryId['clientType'],$getqueryId['companyId']); ?></td>
		<td  align="center"><?php echo ($currencyName['name']); ?></td>
		<td align="right"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationData['id'],$taxableAmount)); ?></td>
		<td align="right"><?php echo $quotationData['serviceTax']; ?></td>
		<td align="right"><?php if($invoiceData['igst']>0){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationData['id'],$invoiceData['igst'])); }else{ echo '-'; }  ?></td>
		<td align="right"><?php if($invoiceData['cgst']>0){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationData['id'],$invoiceData['cgst'])); }else{ echo '-'; } ?></td>
		<td align="right"><?php if($invoiceData['stg']>0){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationData['id'],$invoiceData['stg'])); }else{ echo '-'; } ?></td>
		<td align="right"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationData['id'],$invoiceData['amount'])); ?></td>
		<td align="right"><?php echo $quotationData['dayroe']; ?></td>
		<td  align="right"><?php echo round($taxableAmount); ?></td>
		<td align="right"><?php echo $quotationData['serviceTax']; ?></td>
		<td  align="right"><?php echo round($invoiceData['igst']); ?></td>
		<td  align="right"><?php echo $invoiceData['cgst']; ?></td>
		<td  align="right"><?php echo $invoiceData['stg']; ?></td>
		<td  align="right"><?php echo round($invoiceData['amount']); ?></td>
		<!-- <td align="right"><?php //echo round(getChangeCurrencyValue_New($newCurr,$quotationData['id'],$invoiceData['amount'])) ?></td> -->
		</tr>
	<?php	
	$n++;
	} 
	
	?>	 
	</tbody>
	</table>
	



<script type="text/javascript">
    $(document).ready(function() {
    $('#dataTable').DataTable({
        "initComplete": function (settings, json) {  
        $("#dataTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
    dom: 'frtilpB',
    buttons: [
    {extend: 'copyHtml5', title: 'Tax Report'},
    {extend: 'excelHtml5', title: 'Tax Report'},
    {extend: 'pdfHtml5', title: 'Tax Report',orientation: 'landscape',
                pageSize: 'A1'
			}
    ],
	"aaSorting": [],
    language: { 
    search: "Tour Id: ",
    searchPlaceholder: "Search By Keyword",
    },
    });
    } );



$('#totalSaleCost').text('<?php echo  round($Totalsaleamount,2); ?>');
$('#totalIGST').text('<?php echo  round($TotalIgst,2); ?>');
$('#totalCGST').text('<?php echo round($TotalCgst,2); ?>');
$('#totalSGST').text('<?php echo round($TotalSgst,2); ?>');
</script>


			
<style>
.cmsouter .iconbox {
width:10% !important;
}
.taxborder tr td{
	border: 2px solid #ccc;
	border-right: none;
	border-bottom: none;
}
.taxborder tr th{
	border: 2px solid #ccc;
	border-right: none;
	border-bottom: none;
}
.taxborder tr td:last-child{
	border-right: 2px solid #ccc;
}
.taxborder{
	border-bottom: 2px solid #ccc !important;
}
</style>