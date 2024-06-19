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
				{extend: 'copyHtml5', title: 'Received from Agent/Client Report'},
				{extend: 'excelHtml5', title: 'Received from Agent/Client Report'},
				{extend: 'pdfHtml5', title: 'Received from Agent/Client Report',
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


<div id="pagelisterouter" style="padding: 0%!important;">
	<style>
		.gridtable .header {
			padding: 15px;
		}

		#dataTableDiv_filter {
			position: absolute;
			left: 0%;
			font-size: 15px;
			top: -95px;
		}

		#dataTableDiv_wrapper {
			width: 81.2% !important;
		}

		.reportfilter {
			border-right: 1px solid #e6e6e6;
			cursor: pointer;
		}

		.cmsouter .iconbox {
			width: 20% !important;
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

		#exampleDiv_filter {
			/* position: absolute;
    		right: 5px;
    		font-size: 15px; */
			position: absolute;
			top: -275px !important;
			font-size: 14px;
			margin-right: 79% !important;

		}

		#exampleDiv {
			margin-bottom: 40px;
		}

		/* total amount sec */
		.total-amou-sec {
			position: absolute;
			/* bottom: 230px%;
			right: 41%; */
			right: 34%;
			/* top: 167%; */
			margin-top: 20%;
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

		.can_color tbody tr td,
		.can_color tbody tr td strong,
		.can_color tbody tr td a {
			color: <?php if ($_REQUEST['queryType'] == 20) { echo '#e72815'; } ?> !important;
		}
	</style>
	<!-- last days show schedule code started -->
	<div style="padding: 0 1px;">
		<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
			<tr>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="receivedPaymentFromagentfun(1);">Last 15 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 2) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="receivedPaymentFromagentfun(2);">Last 30 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 3) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="receivedPaymentFromagentfun(3);">Last 3 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 4) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="receivedPaymentFromagentfun(4);">Last 6 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 5) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="receivedPaymentFromagentfun(5);">Last 12 Month</td>
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
			echo date('d-M-Y', strtotime('-12 month')). ' to ' .date('d-M-Y');
		}
		?>
	</div>
	<!-- last days show schedule code ended -->

	<!-- new total amount related code started -->
	<div style="padding: 15px;text-align: left;display: block;position: relative; margin-bottom:40px;">

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
	<!-- new total amount related code ended -->

	<table width="100%" border="1" bordercolor="#ccc" id='dataTableDiv' cellpadding="0" cellspacing="0" class="tablesorter gridtable can_color">
		<thead>


			<tr>
				<th width="25" align="left" class="header">SR.NO.</th>
				<th width="100" align="left" class="header">Tour&nbsp;ID </th>
				<th width="100" align="left" class="header">Travel&nbsp;Date </th>
				<th align="left" class="header" style="min-width: 100px;text-align: center;">Name</th>
				<th width="150" align="left" class="header">LeadPax&nbsp;Name</th>
				<th width="100" align="left" class="header">Cont.&nbsp;Person</th>
				<th width="100" align="left" class="header">Cont.&nbsp;Number</th>
				<th align="left" class="header">Sales&nbsp;Person</th>
				<th width="50" align="left" class="header">Total&nbsp;Amt</th>
				<th width="50" align="left" class="header">Recieved&nbsp;Amt</th>
				<th width="40" align="left" class="header">Recieved&nbsp;By</th>
				<th width="50" align="left" class="header">Pending&nbsp;Amt</th>
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

			if ($searchField != '') {
				$an2ssg = GetPageRecord('id', _QUERY_MASTER_, 'displayId='.$searchField.' order by id desc');
				$getidt = mysqli_fetch_array($an2ssg);
				$mainwhere = ' and  queryId='.$getidt['id'].'';
			}

			if ($_REQUEST['searchBy'] == '1') {

				if ($_REQUEST['queryType']!= '') {
					 $queryType = $_REQUEST['queryType'];
					if ($queryType==3) {
						$queryConf = ' and queryId in ( select id from queryMaster where 1 and queryStatus="' . $queryType .'" )';
					} else {
						$queryConf = ' and queryId in ( select id from queryMaster where 1 and queryStatus="'.$queryType.'")';
					}
				}

				$travelDateQuery = '';
				if ($_REQUEST['financialYear'] > 0) {
					$whereF = 'id="' .$_REQUEST['financialYear'].'" and status=1 and deletestatus=0';
					$fres = GetPageRecord('*', 'financeYearMaster', $whereF);
					$fdata = mysqli_fetch_assoc($fres);
					$myString = $fdata['daterange'];
					$myArray = explode(' - ', $myString);
					$fromDate = $myArray[0];
					$toDate = $myArray[1];
					$travelDateQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($fromDate)).'" and "' .date('Y-m-d', strtotime($toDate)).'"';
				} else {

					$travelDateQuery = '';
					if ($_REQUEST['daterange'] != '') {
						$myString = $_REQUEST['daterange'];
						$myArray = explode(' - ', $myString);
						$fromDate = $myArray[0];
						$toDate = $myArray[1];

						$travelDateQuery = ' and fromDate BETWEEN "' .date('Y-m-d', strtotime($fromDate)).'" and "' .date('Y-m-d', strtotime($toDate)).'"';
					}
				}

				if ($_REQUEST['clientType'] == 1) {
					$agentQuery = '';
					if ($_REQUEST['agentCode'] > 0) {
						$agentQuery = ' and queryId in ( select id from queryMaster where 1 and companyId="'.$_REQUEST['agentCode']. '" and clientType=1 ) ';
					} else {
						$agentQuery = ' and queryId in ( select id from queryMaster where 1 and clientType=1 ) ';
					}
				} elseif ($_REQUEST['clientType'] == 2) {
					if ($_REQUEST['agentCode'] > 0) {
						$agentQuery = ' and queryId in ( select id from queryMaster where 1 and companyId="' .$_REQUEST['agentCode'].'" and clientType=2 ) ';
					} else {
						$agentQuery = ' and queryId in ( select id from queryMaster where 1 and clientType=2 ) ';
					}
				}

				$paymentstatusQuery = '';
				if ($_REQUEST['paymentstatus'] == 1) {
					$paymentstatusQuery = ' and id in ( select scheduleId from agentPaymentMaster where 1 and paymentStatus=1 )';
				}
				if ($_REQUEST['paymentstatus'] == 0 && $_REQUEST['paymentstatus'] != '') {
					$paymentstatusQuery = ' and id not in ( select scheduleId from agentPaymentMaster where 1 and paymentStatus=1 )';
				}
			} else {

				$datefilterQuery = '';
				// if($_REQUEST['searchBy']==2){
				if($_REQUEST['filterId'] == 2) {
					$datefilterQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"';
				}elseif ($_REQUEST['filterId'] == 3) {
					$datefilterQuery = ' and fromDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"';
				}elseif ($_REQUEST['filterId'] == 4) {
					$datefilterQuery = ' and fromDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"';
				}elseif ($_REQUEST['filterId'] == 5) {
					$datefilterQuery = ' and fromDate between "'.date('Y-m-d', strtotime('-12 month')). '" and "'. date('Y-m-d').'"';
				}else{
					$datefilterQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"';
				}
			}


			$where = ' quotationId in ( select id from '._QUOTATION_MASTER_.' where 1 '.$travelDateQuery.' '.$agentQuery.' '.$datefilterQuery.' '.$queryConf.') '.$paymentstatusQuery.' order by id desc';
			$rs = GetPageRecord('*', 'paymentRequestMaster',$where);
			while ($agentPaymentRequestData = mysqli_fetch_array($rs)) {
				
				$an2ss = GetPageRecord('*', _QUOTATION_MASTER_, 'id="' .$agentPaymentRequestData['quotationId']. '" ');
				$quotationData = mysqli_fetch_array($an2ss);

				$an2ss2 = GetPageRecord('*', _QUERY_MASTER_, 'id="' .$agentPaymentRequestData['queryid'].'" ');
				$queryData = mysqli_fetch_array($an2ss2);

				if ($quotationData['isTourEx'] == 1) {
					$makeQueryId = makeExtensionId($queryData['displayId']);
				} else {
					$makeQueryId = makeQueryId($queryData['id']);
				}

				

				$r3 = '';
				$receivedAMT = 0;
				$r3 = GetPageRecord('sum(amount) as receivedAMT', 'agentPaymentMaster', ' paymentId="'.$agentPaymentRequestData['id'].'" and paymentStatus=1 order by id desc');
				$agentPaymentData = mysqli_fetch_array($r3);
				$receivedAMT = $agentPaymentData['receivedAMT'];
			
				$totalClientCost = $agentPaymentRequestData['totalClientCost'];
				$totalPending = $totalClientCost-$receivedAMT;

				$r32 = GetPageRecord('paymentBy', 'agentPaymentMaster', ' paymentId="'.$agentPaymentRequestData['id'].'" and paymentStatus=1 order by id desc');
				$agentPaymentData2 = mysqli_fetch_array($r32);
				$rp = GetPageRecord('name','paymentTypeMaster','id="'.$agentPaymentData2['paymentBy'].'"');
				$paymentThruData = mysqli_fetch_assoc($rp);

				$paymentBy = $paymentThruData['name'];

				if($receivedAMT>0){

			?>

					<tr style="color:<?php if ($queryData['queryStatus'] == 20) { echo '#e72815'; } ?> !important;">
						<td align="left"><?php echo $no; ?> </td>
						<td align="left">
							<div class="bluelink">
								<a style="color:<?php if ($queryData['queryStatus'] == 20) {
													echo '#e72815';
												} ?> !important;" href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"><?php echo makeQueryTourId($queryData['id']); ?></a>
							</div>
						</td>
						<td align="left"><?php if ($quotationData['fromDate'] == '') {
											} else {
												echo date("d-m-Y", strtotime($quotationData['fromDate']));
											}  ?> </td>
						<td align="left"><?php echo showClientTypeUserName($queryData['clientType'], $queryData['companyId']); ?></td>
						<td align="left"><?php echo stripslashes($queryData['guest1']); ?></td>
						<td align="left">
							<?php
							$select13 = '';
							$where13 = '';
							$rs13 = '';
							$select13 = '*';
							if ($queryData['clientType'] == 1) {
								$rsc = GetPageRecord('contactPerson', 'contactPersonMaster', ' corporateId="' . $queryData['companyId'] . '" and deletestatus=0 order by id asc');
								$resListingc = mysqli_fetch_array($rsc);
								echo ($resListingc['contactPerson']);
							}
							if ($queryData['clientType'] == 2) {
								$where13 = "id='" . $queryData['companyId'] . "'";
								$rs13 = GetPageRecord($select13, _CONTACT_MASTER_, $where13);
								$editresultcorporate = mysqli_fetch_array($rs13);
								echo $editresultcorporate['firstName'] . ' ' . $editresultcorporate['lastName'];
							}
							?> </td>
						<td align="center"><?php
											if ($queryData['clientType'] == 1) {
												$rsc = GetPageRecord('*', 'contactPersonMaster', ' corporateId="' . $queryData['companyId'] . '" and deletestatus=0 order by id asc');
												$resListingc = mysqli_fetch_array($rsc);
												echo decode($resListingc['phone']);
											}
											if ($queryData['clientType'] == 2) {
												echo getPrimaryPhone($queryData['companyId'], 'contacts');
											} ?></td>

						<!-- sales person new column added -->
						<td align="left"><?php echo $queryData['salesassignTo']; ?></td>

						<td align="right"><strong style="color:<?php if ($queryData['queryStatus'] == 20) {
																	echo '#e72815';
																} else {
																	echo "#6ebac7";
																} ?> !important;"><?php
											
											echo round($totalClientCost,2);
											
											?></strong></td>

						<td align="right"><strong style="color:<?php if ($queryData['queryStatus'] == 20) {
																	echo '#e72815';
																} else {
																	echo "#009900";
																} ?> !important;"><?php
																																								echo round($receivedAMT,2);

																																								?></strong>
						</td>
						<td>
							<?php echo $paymentBy; ?>
						</td>
						<td align="right"><strong style="color:<?php if ($queryData['queryStatus'] == 20) {
																	echo '#e72815';
																} else {
																	echo "#CC3300";
																} ?> !important;"><?php echo round($totalPending); ?></strong></td>
					</tr>

			<?php
					$grandTotalpending = $grandTotalpending + $totalPending;
					$grandTotalCost = $grandTotalCost + $totalClientCost;
					$grandTotalReceived = $grandTotalReceived + $receivedAMT;



					$no++;
				}
			} ?>
		</tbody>
		<tr class="total_amt">
			<td colspan="8" style="text-align: right;font-size: 16px;font-weight: 600;">Total Amount</td>
			<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalCost); ?> </td>
			<td style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalReceived); ?> </td>
			<td colspan="2" style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandTotalpending); ?> </td>


		</tr>


	</table>
	<?php if ($no == 1) { ?>
		<!-- <div class="norec">No <?php echo $pageName; ?></div> -->
	<?php } ?>
</div>

<script>
	$('#totalAmount').text('<?php echo round($grandTotalCost); ?>');
	$('#totalPaid').text('<?php echo round($grandTotalReceived); ?>');
	$('#totalPending').text('<?php echo round($grandTotalpending); ?>');
</script>