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
		// $.noConflict();

		var table = $('#dataTableDiv').DataTable({
			// responsive: true,
			// scrollCollapse: true,
			// fixedHeader: true,
			"initComplete": function(settings, json) {
				$("#dataTableDiv").wrap("<div style='overflow-x:auto;overflow-y: hidden; width:99.7%;position:relative;'></div>");
			},
			//   "autoWidth": false,

			dom: 'frtilpB',
			buttons: [
				{extend: 'copyHtml5',title:'Query Wise Profit Report'},
				{extend: 'excelHtml5',title:'Query Wise Profit Report'},
				{extend: 'pdfHtml5',title:'Query Wise Profit Report',
				orientation: 'landscape'
				}
			],
			language: {
				search: "Search: ",
				searchPlaceholder: "Agent,/ Client/B2C",
			},


		});


	});
</script>
<style>
	#dataTableDiv_filter {
		position: absolute;
		left: 0%;
		font-size: 15px;
		top: -95px;
	}

	.gridtable .header {
		padding: 15px;
	}

	/* #dataTableDiv_wrapper{
				width: 82%;
			} */

	.header {
		background-color: rgb(230, 230, 230) !important;
	}

	.borderclass tr th {
		border: 2px solid #ccc;
	}

	.borderclass tr td {
		border: 2px solid #ccc;
		border-left: none;
		border-bottom: none;
	}

	.borderclass tr td:first-child {
		border-left: 2px solid #ccc;
	}

	.reportfilter {
		border-right: 1px solid #e6e6e6;
		cursor: pointer;
	}

	.cmsouter .iconbox {
		width: 9% !important;
		margin-left: 0px !important;
	}

	.borderclass tr td {
		border: 2px solid #ccc;
		border-bottom: none;
		border-right: none;
	}

	.borderclass tr td:last-child {
		border-right: 2px solid #ccc;
	}

	.borderclass:last-child {
		border-bottom: 2px solid #ccc;
	}

	.total-amou-sec {
		position: absolute;
		margin-top: 52%;
		right: 32%;
		/* background: red; */
	}

	.total-se-top {
		position: absolute;
		/* left: 476px; */
	}

	.total-new {
		position: absolute;
		/* left: 476px; */
	}

	/* mobile responsive css started */
	@media screen and (min-device-width: 350px) and (max-device-width: 768px) { 
      	/* finance-dashboard css started */
		.eeeewwww{
			overflow-x: auto;
			overflow-y: hidden;
			width: 71.8% !important;
			position: relative;
		}
		.total-amount-sec-main{
			padding: 15px;
			text-align: left;
			display: block;
			position: relative;
			width: 76%!important;
			margin-bottom: 40px;
		}
		.last-days-sec{
			padding: 30px 1px!important;
		}
		/* finance-dashboard css started */
		
	
		}
		#dataTableDiv_wrapper{
			width: 69.5%;
		}
</style>
<div id="pagelisterouter" style="padding: 0%!important;overflow:visible">
	<!-- last days show schedule code started -->
	<div style="padding: 0 15px;">
		<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
			<tr>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="queryWiseProfitfun(1)">Last 15 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 2) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="queryWiseProfitfun(2)">Last 30 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 3) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="queryWiseProfitfun(3)">Last 3 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 4) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="queryWiseProfitfun(4)">Last 6 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 5) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="queryWiseProfitfun(5)">Last 12 Month</td>
			</tr>
		</table>
	</div>
	<!-- last days show schedule code ended -->
	<div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400; display:none;">
		<?php
		if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') {
			echo date('d-M-Y', strtotime('-14 days')) . ' to ' . date('d-M-Y');
		}
		if ($_REQUEST['filterId'] == 2) {
			echo date('d-M-Y', strtotime('-29 days')) . ' to ' . date('d-M-Y');
		}
		if ($_REQUEST['filterId'] == 3) {
			echo date('d-M-Y', strtotime('-3 month')) . ' to ' . date('d-M-Y');
		}
		if ($_REQUEST['filterId'] == 4) {
			echo date('d-M-Y', strtotime('-6 month')) . ' to ' . date('d-M-Y');
		}
		if ($_REQUEST['filterId'] == 5) {
			echo date('d-M-Y', strtotime('-12 month')) . ' to ' . date('d-M-Y');
		}
		?>
	</div>
	<!-- new total amount related code started -->
	<div style="padding: 15px;text-align: left;display: block;position: relative; width: 100%; margin-bottom:40px;">

		<div class="iconbox">
			<div style="color: #313131; font-size:20px;font-weight:500" id="totalcompanyAmount">0</div>
			<div class="text">Purchase Amount</div>

		</div>

		<div class="iconbox">
			<div style="color: #313131; font-size:20px;font-weight:500" id="totalClientcost">0</div>
			<div class="text">Sale Amount</div>
		</div>
		<div class="iconbox">
			<div style="color: #313131; font-size:20px;font-weight:500" id="TAXAmount">0</div>
			<div class="text">Tax Amount</div>
		</div>
		<div class="iconbox">
			<div style="color: #313131; font-size:20px;font-weight:500" id="TCSAmount">0</div>
			<div class="text">TCS Amount</div>
		</div>
		<div class="iconbox">
			<div style="color: #313131; font-size:20px;font-weight:500" id="expenseAmount">0</div>
			<div class="text">Expense Amount</div>
		</div>

		<div class="iconbox">
			<div style="color: #313131; font-size:20px;font-weight:500" id="totalMargin">0</div>
			<div class="text">Total Margin</div>
		</div>



	</div>
<div class="eeeewwww">
	<table width="100%" border="0" id='dataTableDiv' cellpadding="0" cellspacing="0" class="tablesorter gridtable borderclass" style="margin-left: 0px !important;">

		<thead>
			<!-- new total amount related code started -->

			<tr>
				<th align="left" class="header">SR.NO.</th>
				<th align="left" class="header">Tour&nbsp;ID </th>
				<th align="left" class="header">Travel&nbsp;Date </th>
				<th align="left" class="header" style="min-width: 130px;">Name </th>
				<th align="left" class="header">Sale&nbsp;Amount</th>
				<th align="left" class="header">Purchase&nbsp;Amount</th>
				<th align="left" class="header">Tax&nbsp;Amount</th>
				<th align="left" class="header">TCS&nbsp;Amount</th>
				<th align="left" class="header">Expense&nbsp;Amount</th>
				<th align="left" class="header">Margin&nbsp;Amount</th>
				<th align="left" class="header">Margin&nbsp;(%)</th>
				<th align="right" class="header">Operation&nbsp;Person</th>
				<th align="left" class="header">Sales&nbsp;Person</th>
				<!-- <th width="50" align="left" class="header">Update Payment</th> -->
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$select = '*';

			$datefilterQuery = '';
			if ($_REQUEST['filterId'] > 0) {
				if ($_REQUEST['filterId'] == 2){
					$datefilterQuery = ' and fromDate between "' . date('Y-m-d', strtotime('-29 days')) . '" and "' . date('Y-m-d') . '"';
				} elseif ($_REQUEST['filterId'] == 3) {
					$datefilterQuery = ' and fromDate between "' . date('Y-m-d', strtotime('-3 month')) . '" and "' . date('Y-m-d') . '"';
				} elseif ($_REQUEST['filterId'] == 4) {
					$datefilterQuery = ' and fromDate between "' . date('Y-m-d', strtotime('-6 month')) . '" and "' . date('Y-m-d') . '"';
				} elseif ($_REQUEST['filterId'] == 5) {
					$datefilterQuery = ' and fromDate between "' . date('Y-m-d', strtotime('-12 month')) . '" and "' . date('Y-m-d') . '"';
				} else {
					$datefilterQuery = ' and fromDate between "' . date('Y-m-d', strtotime('-14 days')) . '" and "' . date('Y-m-d') . '"';
				}
			} else {
				$travelDateQuery = '';
				if ($_REQUEST['financialYear'] > 0) {
					$whereF = 'id="' . $_REQUEST['financialYear'] . '" and status=1 and deletestatus=0';
					$fres = GetPageRecord('*', 'financeYearMaster', $whereF);
					$fdata = mysqli_fetch_assoc($fres);
					$myString = $fdata['daterange'];
					$myArray = explode(' - ', $myString);
					$fromDate = $myArray[0];
					$toDate = $myArray[1];
					$travelDateQuery = ' and fromDate BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '"';
				} else {

					$travelDateQuery = '';
					if ($_REQUEST['daterange'] != '') {
						$myString = $_REQUEST['daterange'];
						$myArray = explode(' - ', $myString);
						$fromDate = $myArray[0];
						$toDate = $myArray[1];

						$travelDateQuery = ' and fromDate BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '"';
					}
				}
			}

			if($_REQUEST['salesperson']!=''){
					if($_REQUEST['clientTypes']==1){
					$salesFilter = 'and queryId in(select id from queryMaster where companyId in( select id from corporateMaster where assignTo="'.$_REQUEST['salesperson'].'" and deletestatus=0 and status=1) )';
					}

					if($_REQUEST['clientTypes']==2){
						$salesFilter = 'and queryId in(select id from queryMaster where companyId in( select id from contactsMaster where assignTo="'.$_REQUEST['salesperson'].'" and deletestatus=0 and status=1) )';
						}
			}
			// $supplierQuery=''; 
			// if($_REQUEST['agentCode']>0){  
			// 	$supplierQuery=' and supplierStatusId in ( select id from finalQuotSupplierStatus where 1 and supplierId="'.$_REQUEST['agentCode'].'" ) ';
			// }

			//  '.$supplierQuery.'
			$where = " deletestatus=0 and quotationId in (select id from quotationMaster where 1 " . $travelDateQuery." ".$datefilterQuery." ".$salesFilter.") order by id desc ";
			$rs = GetPageRecord($select, _PAYMENT_REQUEST_MASTER_,$where);
			while ($resultpaymentpage = mysqli_fetch_array($rs)) {

				$an2ss = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.$resultpaymentpage['quotationId'].'" and queryId="'.$resultpaymentpage['queryid'].'" ');
				if (mysqli_num_rows($an2ss) > 0) {
					$quotationData = mysqli_fetch_array($an2ss);
					$totalTax = $quotationData['serviceTax']+$quotationData['tcs'];
						$totalCostWithoutTax = $quotationData['totalQuotCost']/(1+$totalTax/100);
						$totalGSTAMT = $totalCostWithoutTax*$quotationData['serviceTax']/100;
						$totalTCSAMT = $totalCostWithoutTax*$quotationData['tcs']/100;
						$totalEexpenseAMT = $totalCostWithoutTax-$quotationData['totalCompanyCost'];
						

					$an2ss2 = GetPageRecord('*', _QUERY_MASTER_, 'id="'.$quotationData['queryId'].'" ');
					$queryData = mysqli_fetch_array($an2ss2);

					$whereops = 'id="'.$queryData['assignTo'].'"';
					$resOps = GetPageRecord('*', _USER_MASTER_, $whereops);
					$opsData = mysqli_fetch_assoc($resOps);

					if ($quotationData['isTourEx'] == 1) {
						$makeQueryId = makeExtensionId($queryData['displayId']);
					} else {
						$makeQueryId = makeQueryId($queryData['id']);
					}
					$expenseAmount='0';
					$exrs = GetPageRecord('SUM(expenseAmount) expenses','quotationExpensesMaster',' queryId="'.$queryData['id'].'"');
					
						$expenseData = mysqli_fetch_assoc($exrs);
					
						$expenseAmount.= $expenseData['expenses'];
					       
						$totalMarkupCost = $totalCostWithoutTax-$quotationData['totalCompanyCost'];

						$totalMarginPercent = $quotationData['totalQuotCost']/$totalMargin;

						$totalMarginCost = $totalMarkupCost-$expenseAmount;
						$marginPercent = ($totalMarkupCost/$quotationData['totalQuotCost'])*100;
					
						$grandtotalMarkupCost = $grandtotalMarkupCost+$totalMarkupCost;
			?>
					<tr>
						<td align="left"><?php echo $no; ?> </td>
						<td align="left">
							<div class="bluelink">
								
								<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>">
									<?php echo makeQueryTourId($queryData['id']); ?></a>
							</div>
						</td>
						<td align="left"><?php echo date("d-m-Y", strtotime($quotationData['fromDate'])); ?> </td>
						<td align="left"><?php echo showClientTypeUserName($queryData['clientType'], $queryData['companyId']); ?></td>
						<td align="right"><?php echo round($quotationData['totalQuotCost']);   ?></td>
						<td align="right"><?php echo round($quotationData['totalCompanyCost']); ?> </td>
						<td align="right"><?php echo round($totalGSTAMT); ?> </td>
						<td align="right"><?php echo round($totalTCSAMT); ?> </td>
						<td align="right"><?php echo round($expenseAmount); ?> </td>
						<td align="right"><?php echo round($totalMarginCost); ?> </td>
						<td align="right"><?php if($marginPercent>0){ echo round($marginPercent); }else{
						echo '0'; } ?> 
					</td>
						
						<td align="center"><?php echo $opsData['firstName'] . '' . $opsData['lastName']; ?> </td>
						<td align="center"><?php echo $queryData['salesassignTo']; ?> </td>
					</tr>
			<?php
					$totalCompanyCost = $quotationData['totalCompanyCost'];
					$totalclientCost = $quotationData['totalQuotCost'];
					// $totalMargin = $quotationData['totalMargin'];

					$grandCompanyCost = $grandCompanyCost + $totalCompanyCost;
					$grandTotalClient = $grandTotalClient + $totalclientCost;
					$grandTotalMargin = $grandTotalMargin + $totalMarginCost;
					$grandTotalGSTAMT = $grandTotalGSTAMT + $totalGSTAMT;
					$grandTotalTCSAMT = $grandTotalTCSAMT + $totalTCSAMT;
					$grandTotalEexpenseAMT = $grandTotalEexpenseAMT + $expenseAmount;
					
					if($marginPercent>0){
						
						 $totalMarginPercent1 = round($marginPercent);
					 }else{
							$totalMarginPercent1 = 0;
					 }

					$grandTotalMarginPercent = $grandTotalMarginPercent+$totalMarginPercent1;
					

					$no++;
				}
			}
			?>
		</tbody>

		<!-- <tr class="total_amt"> -->
		<td colspan="4" style="text-align: right;font-size: 16px;font-weight: 600;">Total Amount</td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalClient); ?> </td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandCompanyCost); ?> </td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalGSTAMT); ?> </td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalTCSAMT); ?> </td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalEexpenseAMT); ?> </td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalMargin); ?> </td>
		<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php  
		$grandTotalMarginPercent2 = ($grandtotalMarkupCost/$grandTotalClient)*100;
		echo round($grandTotalMarginPercent2).'(%)';
		?> </td>

		
		<td colspan="2">&nbsp;</td>


		<!-- </tr> -->

	</table>
</div>
	<?php if ($no == 1) { ?>
		<!-- <div class="norec">No <?php echo $pageName; ?></div> -->
	<?php } ?>
</div>

<script>
	$('#totalcompanyAmount').text('<?php echo round($grandCompanyCost); ?>');
	$('#totalClientcost').text('<?php echo round($grandTotalClient); ?>');
	$('#totalMargin').text('<?php echo round($grandTotalMargin); ?>');
	$('#TAXAmount').text('<?php echo round($grandTotalGSTAMT); ?>');
	$('#TCSAmount').text('<?php echo round($grandTotalTCSAMT); ?>');
	$('#expenseAmount').text('<?php echo round($grandTotalEexpenseAMT); ?>');
</script>
