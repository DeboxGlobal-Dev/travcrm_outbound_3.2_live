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
				$("#dataTableDiv").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");
			},
			//   "autoWidth": false,

			dom: 'frtilpB',
			buttons: [
				{extend: 'copyHtml5', title:'Paid To Supplier Report'},
				{extend: 'excelHtml5', title:'Paid To Supplier Report'},
				{extend: 'pdfHtml5', title:'Paid To Supplier Report',
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

<head>


	<div style="padding: 0 1px;">
		<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
			<tr>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="paidToSupplierfun(1);">Last 15 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 2) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="paidToSupplierfun(2);">Last 30 Days</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 3) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="paidToSupplierfun(3);">Last 3 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 4) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="paidToSupplierfun(4);">Last 6 Month</td>
				<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 5) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="paidToSupplierfun(5);">Last 12 Month</td>
			</tr>
		</table>
	</div>
	<div style="padding: 15px;text-align: left;display: block;position: relative; width: 96%;
    margin-bottom: 40px;">
		<style>
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

			#dataTableDiv_wrapper {
				width: 99.4%;
			}

			#dataTableDiv_filter {
				position: absolute;
				left: 0%;
				font-size: 15px;
				top: -136;
			}
			.can_color tbody tr td,
		.can_color tbody tr td strong,
		.can_color tbody tr td a {
			color: <?php if ($_REQUEST['queryType'] == 20) { echo '#e72815'; } ?> !important;
		}
		</style>

		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="activePayment">0</div>
			<div class="text">Active Payment</div>

		</div>

		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalAmount">0</div>
			<div class="text">Total Amount</div>
		</div>

		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalPaid">0</div>
			<div class="text">Total Paid</div>
		</div>

		<div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalPending">0</div>
			<div class="text">Total Pending</div>
		</div>
	</div>
	<div style="border: 1px solid #ccc; padding: 10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left">
					<div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;display:none;">Receivable Report : <?php
																																if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') { 
				echo date('d-M-Y', strtotime('-14 days')).' to '.date('d-M-Y'); }
																																if ($_REQUEST['filterId'] == 2) { echo date('d-M-Y', strtotime('-29 days')).' to '.date('d-M-Y'); }
																																if ($_REQUEST['filterId'] == 3) { echo date('d-M-Y', strtotime('-3 month')).' to '.date('d-M-Y');}
																																if ($_REQUEST['filterId'] == 4) { echo date('d-M-Y', strtotime('-6 month')).' to '.date('d-M-Y');}
																																if ($_REQUEST['filterId'] == 5) { echo date('d-M-Y', strtotime('-12 month')).' to '.date('d-M-Y');
																																} ?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div>

						<div id="pagelisterouter" style="padding: 0%!important;overflow:visible; display:block;">
							<table width="100%" id="dataTableDiv" border="0" cellpadding="10" cellspacing="0" class="tablesorter gridtable borderclass can_color">
								<thead>
									<tr style="background-color: rgb(230,230,230);">
										<th align="left"><strong>Sr.No.</strong></th>
										<th align="left"><strong>TourID</strong></th>
										<th align="left"><strong>Supplier Name</strong></th>
										<th align="left"><strong>Cont.&nbsp;Person</strong></th>
										<th align="left"><strong>Phone</strong></th>
										<th align="left"><strong>Sales&nbsp;Person</strong></th>
										<th align="left"><strong>Guest&nbsp;Name</strong></th>
										<th align="right"><strong>Total Amount</strong></th>
										<th align="right"><strong>Paid Amount</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$totalPaid = 0;
									$activePayment = 0;
									$totalPending = 0;
									$totalAmount = 0;
									$no = 1;
									$datefilterQuery = '';

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
											$travelDateQuery = ' and dueDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
											
											}
										}
									}else{

									if ($_REQUEST['filterId'] == 2) {
										$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"';
									} elseif ($_REQUEST['filterId'] == 3) {
										$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"';
									} elseif ($_REQUEST['filterId'] == 4) {
										$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"';
									} elseif ($_REQUEST['filterId'] == 5) {
										$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-12 month')).'" and "'.date('Y-m-d').'"';
									} else {
										$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"';
									}
								}

									if ($_REQUEST['queryType']!= '') {
										$queryType = $_REQUEST['queryType'];
									   if ($queryType==3) {
										   $queryConf = ' and queryId in ( select id from queryMaster where 1 and queryStatus="'.$queryType.'" )';
									   } else {
										   $queryConf = ' and queryId in ( select id from queryMaster where 1 and queryStatus="'.$queryType.'")';
									   }
								   }
								//    
									$rs1 = '';
									$where = ' deletestatus=0 and quotationId in ( select id from quotationMaster where status=1 '.$queryConf.' ) and id in ( select scheduleId from supplierPaymentMaster where paymentStatus=1 ) '.$travelDateQuery.' '.$datefilterQuery.' group by supplierStatusId order by id desc';
									$rs1 = GetPageRecord('*', 'supplierSchedulePaymentMaster',$where);
									$activePayment = mysqli_num_rows($rs1);
									while ($suppSchedulePayData = mysqli_fetch_array($rs1)) {
										// if ($suppSchedulePayData['dueDate'] != '0000-00-00' && $suppSchedulePayData['dueDate'] != '') {
										// 	$fromDate = date("Y-m-d");
										// 	$toDate = date("Y-m-d", strtotime($suppSchedulePayData['dueDate']));
										// 	$objec = date_diff(date_create($fromDate), date_create($toDate));
										// 	$agingStr = '<b>' . $objec->format("%r%a") . '&nbsp;days</b>'; // dont include todays paymnet
										// 	if ($objec->format("%a") > 0) {

												$quoationQuery = GetPageRecord('*', _QUOTATION_MASTER_, 'id="' . $suppSchedulePayData['quotationId'] . '"');
												$quoationData = mysqli_fetch_array($quoationQuery);

												$queryQuery = GetPageRecord('*', _QUERY_MASTER_, 'id="' . $quoationData['queryId'] . '"');
												$queryData = mysqli_fetch_array($queryQuery);

												$fianlSuppQuery = GetPageRecord('*', 'finalQuotSupplierStatus', ' quotationId="' . $suppSchedulePayData['quotationId'] . '" and id="' . $suppSchedulePayData['supplierStatusId'] . '"');
												$supplierStatusData = mysqli_fetch_array($fianlSuppQuery);

												$supplierQuery = GetPageRecord('*', _SUPPLIERS_MASTER_, ' deletestatus=0 and id="' . $supplierStatusData['supplierId'] . '"');
												$supplierData = mysqli_fetch_array($supplierQuery);
												$supplierName = $supplierData['name'] . ' [' . $supplierData['supplierNumber'] . ']';

												$suppContactQuery = GetPageRecord('*', 'suppliercontactPersonMaster', 'corporateId="' . $supplierData['id'] . '" and contactPerson!="" and designation!="" and phone!="" and email!=""');
												$suppContactPerData = mysqli_fetch_array($suppContactQuery);


												$r3 = '';
												$r3 = GetPageRecord('sum(amount) as totalpaid, spm.*', 'supplierPaymentMaster spm', ' 1 and supplierStatusId="' . $supplierStatusData['id'] . '" and paymentStatus=1 and quotationId in ( select id from quotationMaster where status=1 ) ');
												$supplierPaymentData = mysqli_fetch_array($r3);

												$SuppAmount = ($supplierStatusData['totalSupplierCost']);
												$paidAmount = ($supplierPaymentData['totalpaid']);

												$totalSuppAmount = $totalSuppAmount + $SuppAmount;
												$totalpaid =  $totalpaid + $paidAmount;
												$totalPending =  $totalSuppAmount - $totalpaid;
									?>
												<tr>
													<td align="left"><?php echo $no; ?></td>
													<td align="left">
													
														<div class="bluelink"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
													</td>
													<td align="left"><?php echo trim($supplierName); ?></td>
													<td align="left"><?php echo $suppContactPerData['contactPerson']; ?></td>
													<td align="left"><?php echo decode($suppContactPerData['phone']); ?></td>
													<!-- sales person and guest name new column added -->
													<td align="left"><?php echo $queryData['salesassignTo']; ?></td>


													<!-- lead pax and guest name -->
													<td align="left"><?php echo $queryData['leadPaxName']; ?></td>
													<td align="right"><?php echo round($SuppAmount); ?></td>
													<td align="right"><?php echo round($paidAmount); ?></td>

												</tr>
									<?php
												$grandtotal = $grandtotal + $SuppAmount;
												$grandpaid = $grandpaid + $paidAmount;
												$no++;
											}
										// }
									// }

									?>
								</tbody>
								<tr class="total_amt">
									<td colspan="7" style="text-align: right;font-size: 16px;font-weight: 600;">Total Amount</td>
									<td style="text-align:right;font-size: 16px;font-weight: 500;"><?php echo round($grandtotal); ?> </td>
									<td colspan="" style="text-align: right;font-size: 16px;font-weight: 500;"><?php echo round($grandpaid); ?> </td>
								</tr>

								<script>
									$('#activePayment').text('<?php echo $activePayment; ?>');
									$('#totalPaid').text('<?php echo $totalpaid; ?>');
									$('#totalAmount').text('<?php echo $totalSuppAmount; ?>');
									$('#totalPending').text('<?php echo $totalPending; ?>');
								</script>
							</table>

						</div>
				</td>
			</tr>

		</table>

		<!-- </div> -->
	</div>