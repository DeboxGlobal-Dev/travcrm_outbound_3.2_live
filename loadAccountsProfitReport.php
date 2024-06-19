<?php 
ob_start();
include "inc.php"; 
include "config/logincheck.php"; 
?>

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
					$.noConflict();
					
			var table = $('#dataTableDiv').DataTable({
				responsive: true,
				// scrollCollapse: true,
				// fixedHeader: true,
				"initComplete": function (settings, json) {  
					$("#dataTableDiv").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");            
				},
            //   "autoWidth": false,
			
				dom: 'frtilpB',
				buttons: [
				'copyHtml5',
				'excelHtml5',
				'pdfHtml5'
				],
				language: { 
					search: "Search: ",
                   searchPlaceholder: "Agent,/ Client/B2C",
				},

				
				}
				);
			

				} );
				
			</script>
<?php
if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
	$begin = new DateTime(date('Y-m-d')); 
	$end   = new DateTime(date('Y-m-d', strtotime('+7 days')));
	$intervalType = 'day';
}
if($_REQUEST['filterId']==2){ 
	$begin = new DateTime(date('Y-m-d'));
	$end   = new DateTime(date('Y-m-d', strtotime('+15 days')));
	$intervalType = 'day';
}
if($_REQUEST['filterId']==3){ 
	$begin = new DateTime(date('Y-m-01'));
	$end   = new DateTime(date('Y-m-t'));
		$intervalType = 'month';
}
if($_REQUEST['filterId']==4){ 
	$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
	$end   = new DateTime(date('Y-m-t', strtotime('+1 month')));
	$intervalType = 'month';
}
if($_REQUEST['filterId']==5){  
	$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
	$end   = new DateTime(date('Y-m-t', strtotime('+3 month')));
	$intervalType = 'month';
}
if($_REQUEST['filterId']==6){  
	$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
	$end   = new DateTime(date('Y-m-t', strtotime('+6 month')));
	$intervalType = 'month';
}
if($_REQUEST['filterId']==7){  
	$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
	$end   = new DateTime(date('Y-m-t', strtotime('+12 month')));
	$intervalType = 'month';
}  
?>

<!-- <h3 class="cms_title">Profit Report</h3>  -->
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}

</style>
<div style="padding: 0 15px;">
<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(1);">Next 7 Days</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(2);">Next 15 Days</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(3);">This Month</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(4);">Next Month</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(5);">Next 3 Months</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==6){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(6);">Next 6 Months</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==7){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getAccountsProfitReportfun(7);">Next 12 Months</td>
  </tr>
</table>
</div>
<div style="padding: 15px;text-align: left;display: block;position: relative;">
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalQuery">0</div>
	<div class="text">Total Query </div> 
	</div> 
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalPax">0</div>
	<div class="text">Total Pax </div>
	</div>
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalPayable">0</div>
	<div class="text">Total Payable</div>
	</div>
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalBalance">0</div>
	<div class="text">Total Receivable</div>
	</div>
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalProfit">0</div>
	<div class="text">Total Profit </div>
	</div>
	
	<div class="iconbox">
	<div style="color: #313131; font-size:28px;font-weight:500" id="totalNight">0</div> 
	<div class="text">Total Night </div>
	</div>

</div>

		   
<div style="border: 1px solid #ccc; padding: 10px;">
<table width="100%" border="0"  cellspacing="0" cellpadding="5">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Receivable Report : <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ echo date('d-M-Y').' to '.date('d-M-Y', strtotime('+6 days')); } if($_REQUEST['filterId']==2){ echo date('d-M-Y').' to '.date('d-M-Y', strtotime('+14 days')); } if($_REQUEST['filterId']==3){ echo date('01-M-Y').' to '.date('t-M-Y'); } if($_REQUEST['filterId']==4){ echo date('01-M-Y', strtotime('+1 month')).' to '.date('t-M-Y', strtotime('+1 month')); } if($_REQUEST['filterId']==5){ echo date('01-M-Y').' to '.date('t-M-Y', strtotime('+3 month')); } if($_REQUEST['filterId']==6){ echo date('01-M-Y').' to '.date('t-M-Y', strtotime('+6 month')); } if($_REQUEST['filterId']==7){ echo date('01-M-Y').' to '.date('t-M-Y', strtotime('+12 month')); } ?></div></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" id="dataTableDiv" cellpadding="10" cellspacing="0">
  <tr>
	<th width="25" align="left" bgcolor="#f8f8f8" ><strong>SR.NO.</strong></th> 
	<th width="100" align="left" bgcolor="#f8f8f8" ><strong>Tour&nbsp;ID </strong></th>
	<th width="100" align="left" bgcolor="#f8f8f8"><strong>Travel&nbsp;Date </strong></th>
    <td width="100" align="center" bgcolor="#f8f8f8"><strong>Nights</strong></td>
    <td width="100" align="center" bgcolor="#f8f8f8"><strong>Pax</strong></td>  
    <td width="100" align="center" bgcolor="#f8f8f8"><strong>Payable</strong></td>
    <td width="100" align="center" bgcolor="#f8f8f8"><strong>Receivable</strong></td>
	 <td width="100" align="center" bgcolor="#f8f8f8"><strong>Profit</strong></td>
  </tr>
<?php
 
$totalClientBalance=0;
$totalPayable=0; 
$totalPax=0; 
$totalNight=0; 
$totalQuery=0; 
$no=1;
$datefilterQuery='';
if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
	$datefilterQuery=' and dueDate between "'.date('Y-m-d').'" and "'.date('Y-m-d', strtotime('+6 days')).'"'; 
}
if($_REQUEST['filterId']==2){ 
	$datefilterQuery=' and dueDate between "'.date('Y-m-d').'" and "'.date('Y-m-d', strtotime('+14 days')).'"'; 
}
if($_REQUEST['filterId']==3){ 
	$datefilterQuery=' and MONTH(dueDate)="'.date('m').'" and YEAR(fromDate)="'.date('Y').'"'; 
}
if($_REQUEST['filterId']==4){ 
	$datefilterQuery=' and MONTH(dueDate)="'.date('m',strtotime('+1 month')).'" and YEAR(fromDate)="'.date('Y').'"'; 
}
if($_REQUEST['filterId']==5){  
	$datefilterQuery=' and dueDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+3 month')).'"'; 
}
if($_REQUEST['filterId']==6){  
	$datefilterQuery=' and dueDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+6 month')).'"'; 
}
if($_REQUEST['filterId']==7){  
	$datefilterQuery=' and dueDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+12 month')).'"'; 
}  

/*
$wherecondition = ' deletestatus=0 and queryStatus=3  '.$datefilterQuery.' order by id asc';
$rs1=GetPageRecord('*',_QUERY_MASTER_,$wherecondition);  
$totalQuery = mysqli_num_rows($rs1);
while($queryData=mysqli_fetch_array($rs1)){
	
  $totalPax=$totalPax+($queryData['adult']+$queryData['child']);
  $totalNight=$totalNight+($queryData['night']);

  $totalClientCost = $queryData['totalQueryCost'];
  $totalSupplierCost = $queryData['totalCompanyCost'];

  $totalPayable = $totalPayable+$totalSupplierCost;
  $totalClientBalance = $totalClientBalance+$totalClientCost;
*/

$where=' 1  and ( id in ( select quotationId from supplierSchedulePaymentMaster where 1 '.$datefilterQuery.'  ) or id in ( select quotationId from agentSchedulePaymentMaster where 1 '.$datefilterQuery.' ) ) ';    

$rs=GetPageRecord('*',_QUOTATION_MASTER_,$where); 

while($quotationData=mysqli_fetch_array($rs)){ 
	
	$an2ss2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'" ');
	$queryData=mysqli_fetch_array($an2ss2);
	
	if($quotationData['isTourEx'] == 1){
		$makeQueryId = makeExtensionId($queryData['displayId']);
	}else{
		$makeQueryId = makeQueryId($queryData['id']);
	}
	
	$totalPax=$totalPax+($quotationData['adult']+$quotationData['child']);
	$totalNight=$totalNight+($quotationData['night']);
	
	$totalClientCost = $quotationData['totalQuotCost'];
	$totalSupplierCost = $quotationData['totalCompanyCost'];
	$totalProfitCost = $totalClientCost-$totalSupplierCost;
	
	
	$totalPayable = $totalPayable+$totalSupplierCost;
	$totalClientBalance = $totalClientBalance+$totalClientCost;
	$totalProfit = $totalProfit+$totalProfitCost;
   	?>
  	<tr>
    <td align="left"><?php echo $no; ?> </td>
    <td align="left"><div class="bluelink" ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']);?>"><?php echo $makeQueryId; ?></a></div></td>
	 <td align="left"><?php if($quotationData['fromDate']==''){} else {  echo date("d-m-Y", strtotime($quotationData['fromDate'])); }  ?> </td>
    <td  align="center"><?php echo ($quotationData['night']); ?></td>
    <td  align="center"><?php echo ($quotationData['adult']+$quotationData['child']); ?></td>
    <td  align="center"><?php echo round($totalSupplierCost); ?></td>
    <td  align="center"><?php echo round($totalClientCost); ?></td>
	<td  align="center"><?php echo round($totalProfitCost); ?></td>
  </tr>
  	<?php
	$no++;
 }   

?>
<script>
$('#totalQuery').text('<?php echo ($no-1); ?>');
$('#totalPax').text('<?php echo $totalPax; ?>');
$('#totalPayable').text('<?php echo round($totalPayable); ?>');
$('#totalBalance').text('<?php echo round($totalClientBalance); ?>');
$('#totalProfit').text('<?php echo round($totalProfit); ?>');
$('#totalNight').text('<?php echo $totalNight; ?>');
</script>
</table>
</td>
  </tr>
</table>
</div>
			
<style>
.cmsouter .iconbox {
width:13% !important;
}
</style>