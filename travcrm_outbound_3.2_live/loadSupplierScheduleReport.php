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
			"initComplete": function(settings, json) {
				$("#dataTableDiv").wrap("<div style='overflow-x:auto;overflow-y: hidden; width:99.7%;position:relative;'></div>");
			},
			//   "autoWidth": false,

			dom: 'frtilpB',
			buttons: [
				{extend: 'copyHtml5', title: 'Supplier Payment Schedule Report'},
				{extend: 'excelHtml5', title: 'Supplier Payment Schedule Report'},
				{extend: 'pdfHtml5', title: 'Supplier Payment Schedule Report',
				orientation: 'landscape',
				pageSize: 'LEGAL'
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

	#dataTableDiv_wrapper {
		width: 68.5%;
	}

	.reportfilter {
		border-right: 1px solid #e6e6e6;
		cursor: pointer;
	}

	.cmsouter .iconbox {
		width: 19% !important;
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

	/* total amount sec */
	.total-amou-sec {
		position: absolute;
		margin-top: 58%;
		right: 47%;
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
</style>

<div id="pagelisterouter" style="padding: 0%!important;overflow:visible; width:100%;">
	<!-- last days show schedule code started -->
	<div style="padding: 0 1px;">
		<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
			<tr>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="supplierSchedulePaymentfun(1);">Next 15 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 2) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="supplierSchedulePaymentfun(2);">Next 30 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 3) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="supplierSchedulePaymentfun(3);">Next 3 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 4) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="supplierSchedulePaymentfun(4);">Next 6 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 5) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="supplierSchedulePaymentfun(5);">Next 12 Month</td>
			</tr>
		</table>
	</div>
	<!-- last days show schedule code ended -->

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
	<!-- last days show schedule code ended -->

	<!-- new total amount related code started -->
	<div style="padding: 15px;text-align: left;display: block;position: relative; width: 90%; margin-bottom:40px;">

		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalAmount">0</div>
			<div class="text">Total Amount</div>

		</div>



		<!-- <div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalAmount">0</div>
			<div class="text">Total Schedule Amount</div>
		</div> -->
		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalPaid">0</div>
			<div class="text">Total Received Amount</div>
		</div>

		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalPending">0</div>
			<div class="text">Total Pending Amount</div>
		</div>



	</div>
	<!-- new total amount related code started -->

	<table width="100%" border="1" bordercolor="#ccc" id='dataTableDiv' cellpadding="0" cellspacing="0" class="tablesorter gridtable">
		<thead>
			<tr>
				<th width="25" align="left" class="header">SR.NO.</th>
				<th width="100" align="left" class="header">Tour&nbsp;ID </th>
				<th width="100" align="left" class="header">Travel&nbsp;Date </th>
				<th width="200" align="left" class="header">Supplier&nbsp;Name </th>
				<th width="100" align="left" class="header">Cont.&nbsp;Person</th>
				<th width="100" align="left" class="header">Cont.&nbsp;Number</th>
				<th align="left" class="header">Sales&nbsp;Person</th>
				<th align="left" class="header">guest&nbsp;Name</th>
				<th width="50" align="right" class="header">Total&nbsp;Amount </th>
				<th width="50" align="left" class="header">Due&nbsp;Date</th>
				<th width="50" align="right" class="header">Schedule&nbsp;Amt</th>
				<th width="50" align="right" class="header">Pending&nbsp;Amt</th>
				<th width="50" align="left" class="header">Status</th>
				<th width="50" align="left" class="header">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$select = '*';
			$where = '';
			$rs = '';
			$wheresearch = '';
			$mainwhere = '';
			$limit = clean($_GET['records']);
			$searchField = clean(trim(ltrim($_GET['searchField'], '0')));

			if($searchField!=''){ 
				$an2ssg=GetPageRecord('id',_QUERY_MASTER_,'displayId='.$searchField.' order by id desc');
				$getidt=mysqli_fetch_array($an2ssg);
				$mainwhere=' and  queryId='.$getidt['id'].'';
			}

			if($_GET['daterange']!=''){
			if($_REQUEST['financialYear']>0){
				$whereF = 'id="'.$_REQUEST['financialYear'].'" and status=1 and deletestatus=0';
				$fres = GetPageRecord('*','financeYearMaster',$whereF);
				$fdata = mysqli_fetch_assoc($fres);
				echo $myString = $fdata['daterange'];
				$myArray = explode(' - ', $myString);
				$fromDate = $myArray[0];
				$toDate = $myArray[1];
				$travelDateQuery = ' and dueDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
			}else{
			
				$travelDateQuery='';
				if($_GET['daterange']!=''){ 
				$myString = $_GET['daterange'];
				$myArray = explode(' - ', $myString);  
				$fromDate = $myArray[0];
				$toDate = $myArray[1];
				$travelDateQuery = ' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
				
				}
			}
			



		$supplierQuery=''; 
		if($_REQUEST['supplierCode']>0){  
			$supplierQuery=' and supplierStatusId in ( select id from finalQuotSupplierStatus where 1 and supplierId="'.$_REQUEST['supplierCode'].'" and deletestatus=0) ';
		}


			$paymentstatusQuery = '';

			$paymentstatusQuery = ' and id not in ( select scheduleId from agentPaymentMaster where 1 and paymentStatus=1 )';
	}else{
		$datefilterQuery = '';
			// if($_REQUEST['searchBy']==2){
		if ($_REQUEST['filterId'] == 2) {
			$datefilterQuery = ' and dueDate between "' . date('Y-m-d') . '" and "' . date('Y-m-d', strtotime('+29 days')) . '"';
		} elseif ($_REQUEST['filterId'] == 3) {
			$datefilterQuery = ' and dueDate between "' . date('Y-m-d') . '" and "' . date('Y-m-d', strtotime('+3 month')) . '"';
		} elseif ($_REQUEST['filterId'] == 4) {
			$datefilterQuery = ' and dueDate between "' . date('Y-m-d') . '" and "' . date('Y-m-d', strtotime('+6 month')) . '"';
		} elseif ($_REQUEST['filterId'] == 5) {
			$datefilterQuery = ' and dueDate between "' . date('Y-m-d') . '" and "' . date('Y-m-d', strtotime('+12 month')) . '"';
		} else {
			$datefilterQuery = ' and dueDate between "' . date('Y-m-d') . '" and "' . date('Y-m-d', strtotime('+14 days')) . '"';
		}

	}
			$where = ' status=1 and scheduleStatus=1 and quotationId in ( select id from ' . _QUOTATION_MASTER_ . ' where 1 and status=1 ' . $travelDateQuery . ' '.$supplierQuery.' and queryId in (select id from queryMaster where queryStatus=3 )) ' . $paymentstatusQuery . ' ' . $datefilterQuery . ' order by dueDate desc ';
			$rs = GetPageRecord('*', 'supplierSchedulePaymentMaster', $where);
			while ($agentPaymentScheduleData = mysqli_fetch_array($rs)) {
				$an2ss = GetPageRecord('*', _QUOTATION_MASTER_, 'id="' . $agentPaymentScheduleData['quotationId'] . '" ');

				$scheduleAmount = $agentPaymentScheduleData['amount'];

				$quotationData = mysqli_fetch_array($an2ss);

				$an2ss2 = GetPageRecord('*', _QUERY_MASTER_, 'id="' . $quotationData['queryId'] . '" ');
				$queryData = mysqli_fetch_array($an2ss2);

				$finalQuery = '';
				$finalQuery = GetPageRecord('*', 'finalQuotSupplierStatus', 'id="' . $agentPaymentScheduleData['supplierStatusId'] . '" ');
				$finasupplierStatusData = mysqli_fetch_array($finalQuery);

				$suppQuery = '';
				$suppQuery = GetPageRecord('*', _SUPPLIERS_MASTER_, 'id="' . $finasupplierStatusData['supplierId'] . '" ');
				$suppSupData = mysqli_fetch_array($suppQuery);
				$supplierName = $suppSupData['name'] . ' [' . $suppSupData['supplierNumber'] . ']';

				$suppConQuery = '';
				$suppConQuery = GetPageRecord('*', 'suppliercontactPersonMaster', 'corporateId="' . $suppSupData['id'] . '" ');
				$suppConQSupData = mysqli_fetch_array($suppConQuery);

				if ($quotationData['isTourEx'] == 1) {
					$makeQueryId = makeExtensionId($queryData['displayId']);
				} else {
					$makeQueryId = makeQueryId($queryData['id']);
				}
			?>
				<tr>
					<td align="left"><?php echo $no; ?> </td>
					<td align="left">
						<div class="bluelink">
							<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"><?php echo makeQueryTourId($queryData['id']); ?></a>
						</div>
					</td>
					<td align="center"><?php if ($quotationData['fromDate'] == '') {
										} else {
											echo date("d-m-Y", strtotime($quotationData['fromDate']));
										}  ?> </td>
					<td align="left"><?php echo trim($supplierName); ?></td>
					<td align="left">
						<?php
						echo trim($suppConQSupData['contactPerson']);

						?> </td>
					<td align="center"><?php echo decode($suppConQSupData['phone']);   ?></td>

					<!-- sales person and guest name new column added -->
					<td align="left"><?php echo $queryData['salesassignTo']; ?></td>
					<!-- lead pax and guest name -->
					<td align="left"><?php echo $queryData['leadPaxName']; ?></td>

					<td align="right"> <strong style="color:#6ebac7"><?php
					$totalCost = ($finasupplierStatusData['totalSupplierCost']);
					echo round($totalCost);  ?></strong></td>

					<td align="center"><?php if ($agentPaymentScheduleData['dueDate'] != '0000-00-00' &&	 $agentPaymentScheduleData['dueDate'] != '') echo date("d-m-Y", strtotime($agentPaymentScheduleData['dueDate']));  ?> </td>


					<td align="right"><?php
						$r3 = '';
						$r3 = GetPageRecord('sum(amount) as totalpaid, spm.*', 'supplierPaymentMaster spm', ' scheduleId in ( select id from supplierSchedulePaymentMaster where 1 and  supplierStatusId="'.$finasupplierStatusData['id'] . '"  ) and paymentStatus=1');
						$supplierPaymentData = mysqli_fetch_array($r3);
						$totalPaidAMT = ($supplierPaymentData['totalpaid'] == 0) ? 0 : $supplierPaymentData['totalpaid'];
						// $totalPending = $totalCost-$totalPaidAMT;  
						echo round($scheduleAmount); ?> </td>


					<td align="right">
						<?php $totalPending = $totalCost - $totalPaidAMT;
						echo '<div style="color:#CC3300;"><strong>' . round($totalPending) . '</strong></div>'; ?>

					</td>

					<td align="left"><?php

										if ($totalPending == 0) {
										?>
							<div style="color:#009900;"> <strong>Paid</strong></div>
						<?php } else { ?>
							<div style="color:#CC3300;"><strong>Pending</strong></div>
						<?php } ?>
					</td>

					<td style="min-width: 115px;">
						<?php $payre = GetPageRecord('*', _PAYMENT_REQUEST_MASTER_, 'queryid="' . $queryData['id'] . '" and quotationId="' . $quotationData['id'] . '"');
						$respayReqData = mysqli_fetch_assoc($payre);

						?>
						<a style="border-radius: 4px; background-color: #26a22b;border: 1px solid #4CAF50;color: #fff !important;padding: 4px 8px;" href="<?php $fullurl; ?>showpage.crm?module=paymentrequest&view=yes&id=<?php echo encode($respayReqData['id']); ?>&QueryId=<?php $queryData['id']; ?>">Update Payment</a>
					</td>


				</tr>

			<?php

				$grandTotalCost = $grandTotalCost + $totalCost;
				$grandTotalReceived = $grandTotalReceived + $scheduleAmount;
				$grandTotalPending = $grandTotalPending + $totalPending;



				$no++;
			} ?>

		</tbody>
		<tr class="total_amt">
			<td colspan="8" style="text-align: right;font-size: 16px;font-weight: 600;">Total Amount</td>
			<td colspan="" style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalCost); ?> </td>
			<td colspan="2" style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalReceived); ?> </td>
			<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalPending); ?> </td>
			<td colspan="2">&nbsp;</td>


		</tr>

	</table>
	<?php if ($no == 1) { ?>
		<div class="norec"><?php echo $pageName; ?></div>
	<?php } ?>
</div>


<script>
	$('#totalAmount').text('<?php echo round($grandTotalCost); ?>');
	$('#totalPaid').text('<?php echo round($grandTotalReceived); ?>');
	$('#totalPending').text('<?php echo round($grandTotalPending); ?>');
</script>