<?php 
ob_start();
include "inc.php"; 
include "config/logincheck.php"; 
?>
<!-- <h3 class="cms_title">Non Invoice Report</h3>  -->
<style>
	.reportfilter{
	border-right:1px solid #e6e6e6; cursor:pointer;
	}
	#exampleDiv_filter{
			position: absolute;
    		right: 5px;
    		font-size: 15px;

		}
	#dataTableDiv_wrapper{
			width: 82.5%;
			position: relative;
		}
		#dataTableDiv_filter{
			position: absolute;
    		top: -90px;
			font-size: 14px;
		}
</style>
<div style="padding: 0 15px;margin-bottom: 70px;">
<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(1);">Next 7 Days</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(2);">Next 15 Days</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(3);">This Month</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(4);">Next Month</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(5);">Next 3 Months</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==6){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(6);">Next 6 Months</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==7){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsNonInvoiceReportfun(7);">Next 12 Months</td>
  </tr>
</table>
</div>

<table width="100%" border="1" bordercolor="#ccc" id="dataTableDiv" cellpadding="10" cellspacing="0" class="table table-bordered table-striped nonvoiceborder">
	<thead>
<tr style="background-color: rgb(230, 230, 230);">
<th width="100" align="left" ><strong>Tour&nbsp;ID </strong></th>
<th width="100" align="left" ><strong>Arrival&nbsp;Date </strong></th>
<th width="100" align="left" ><strong>Departure&nbsp;Date </strong></th>
<th width="100" align="left" ><strong>Lead&nbsp;Pax&nbsp;Name</strong></th>
<th width="100" align="left" ><strong>Agent&nbsp;Name</strong></th>
<th width="100" align="left" ><strong>Country</strong></th>
<th width="100" align="left" ><strong>Ops.Person</strong></th>
<th width="100" align="left" ><strong>Sales.Person </strong></th>
<th width="100" align="left" ><strong>Department</strong></th>

<td width="100" align="center"><strong>Proforma&nbsp;Invoice Status</strong></td>
<td width="100" align="center"><strong>Tax&nbsp;Invoice Status</strong></td>
<td width="100" align="center"><strong>Currency</strong></td>
<td width="100" align="center"><strong>Total&nbsp;Tour Cost</strong></td>
</tr>
</thead>
<tbody>
<?php
 // ( if invoice not generate show red(pending) else green(Created) ) 
$totalClientBalance=0;
$totalPayable=0; 
$totalPax=0; 
$totalNight=0; 
$totalQuery=0; 
$no=1;
$datefilterQuery='';
if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
	$datefilterQuery=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d', strtotime('+6 days')).'"'; 
}
if($_REQUEST['filterId']==2){ 
	$datefilterQuery=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d', strtotime('+14 days')).'"'; 
}
if($_REQUEST['filterId']==3){ 
	$datefilterQuery=' and fromDate between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"'; 
}
if($_REQUEST['filterId']==4){ 
	$datefilterQuery=' and MONTH(fromDate)="'.date('m',strtotime('+1 month')).'" and YEAR(fromDate)="'.date('Y').'"'; 
}
if($_REQUEST['filterId']==5){  
	$datefilterQuery=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+3 month')).'"'; 
}
if($_REQUEST['filterId']==6){  
	$datefilterQuery=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+6 month')).'"'; 
}
if($_REQUEST['filterId']==7){  
	$datefilterQuery=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+12 month')).'"'; 
}  
 
$where='status=1 and queryId in ( select id from queryMaster where queryStatus=3 ) '.$datefilterQuery.'';    
$rs=GetPageRecord('*',_QUOTATION_MASTER_,$where);  
while($quotationData=mysqli_fetch_array($rs)){ 
	$invoiceQuery='';
	$invoiceQuery=GetPageRecord('*',_INVOICE_MASTER_,' quotationId="'.$quotationData['id'].'" and invoiceType=2 and deletestatus=0 and tourId!="" and amount!=""');
	if(mysqli_num_rows($invoiceQuery)>0){
	$invoiceData=mysqli_fetch_array($invoiceQuery); 
	
		if($invoiceData['invoiceType']==2){
			$proformaType = '<span style="color:green">Issued</span>';
		}else{
			$proformaType = '<span style="color:red">Pending</span>';
		}
	}else{
		$proformaType = '<span style="color:red">Pending</span>';
	}

	$invoiceQuery1='';
	$invoiceQuery1=GetPageRecord('*',_INVOICE_MASTER_,' quotationId="'.$quotationData['id'].'" and invoiceType=1 and deletestatus=0 and tourId!="" and amount!=""');
	if(mysqli_num_rows($invoiceQuery1)>0){
	$invoiceData=mysqli_fetch_array($invoiceQuery1); 

		if($invoiceData['invoiceType']==1){
			$invoiceTaxType = '<span style="color:green">Issued</span>';
		}else{
			$invoiceTaxType = '<span style="color:red">Pending</span>';
		}

	}else{
		$invoiceTaxType = '<span style="color:red">Pending</span>';
	}


	$an2ss2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'" ');
	$queryData=mysqli_fetch_array($an2ss2);
	
 	$getClientName=showClientTypeUserName($queryData['clientType'],$queryData['companyId']);
 	
 	$getClientCountry=showClientTypeCountry($queryData['clientType'],$queryData['companyId']);
 	$salesDepartment=showClientTypeUserDepartment($queryData['clientType'],$queryData['companyId']);

	if($quotationData['isTourEx'] == 1){
		$makeQueryId = makeExtensionId($queryData['displayId']);
	}else{
		$makeQueryId = makeQueryTourId($queryData['id']);
	}

	$totalClientCost = $quotationData['totalQuotCost'];
	$totalSupplierCost = $quotationData['totalCompanyCost'];
	$totalProfitCost = $totalClientCost-$totalSupplierCost;
	
	
	$totalPayable = $totalPayable+$totalSupplierCost;
	$totalClientBalance = $totalClientBalance+$totalClientCost;
	$totalProfit = $totalProfit+$totalProfitCost;


	$crRS = GetPageRecord('*','queryCurrencyMaster','id="'.$quotationData['currencyId'].'"');
	$currencyName = mysqli_fetch_array($crRS)
   	?>
	<tr>
	<td align="left"><div class="bluelink" ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']);?>"><?php echo $makeQueryId;?></a></div></td>

	<td  align="left"><?php echo date('d-m-Y',strtotime($quotationData['fromDate'])); ?></td>
	<td  align="left"><?php echo date('d-m-Y',strtotime($quotationData['toDate'])); ?></td>
	<td  align="left"><?php echo clean($queryData['leadPaxName']); ?></td>
	<td  align="left"><?php echo strip($getClientName); ?></td>
	<td  align="left"><?php echo strip($getClientCountry); ?></td>
	<td  align="center"><?php echo getUserName($queryData['assignTo']); ?></td>
	<td  align="center"><?php echo strip($queryData['salesassignTo']); ?></td>
	<td  align="center"><?php echo $salesDepartment; ?></td>
	<td  align="center"><?php echo ($proformaType); ?></td>
	<td  align="center"><?php echo ($invoiceTaxType); ?></td>
	<td  align="center"><?php echo ($currencyName['name']); ?></td>
	<td  align="center"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationData['id'],$quotationData['totalQuotCost'])); ?></td>

  </tr>
  	<?php
	$no++;
 }   
?>
</tbody>
</table>

<!-- <script>
$('#totalPayable').text('<?php echo round($totalPayable); ?>');
$('#totalBalance').text('<?php echo round($totalClientBalance); ?>');
$('#totalProfit').text('<?php echo round($totalProfit); ?>');
</script> -->

			
<!-- <style>
.cmsouter .iconbox {
width:13% !important;
} -->
</style>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
			<script>
			
				$(document).ready(function() {
			$('#dataTableDiv').DataTable({
			
			"initComplete": function (settings, json) {  
			$("#dataTableDiv").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
			},
				dom: 'frtilpB',
				buttons: [
				{extend: 'copyHtml5', title: 'Unbilled Tour Report'},
				{extend: 'excelHtml5', title: 'Unbilled Tour Report'},
				{extend: 'pdfHtml5', title: 'Unbilled Tour Report',orientation: 'landscape',
                pageSize: 'LEGAL'},

				],
				"aaSorting": [
					[1, "desc"]
					],
				language: { 
					search: "Search: ",
                   searchPlaceholder: "Agent",
				},

				
				}
				);
			

				} );
			
			</script>