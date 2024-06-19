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
				{extend: 'copyHtml5', title:'Supplier Overdue Report'},
				{extend: 'excelHtml5', title:'Supplier Overdue Report'},
				{extend: 'pdfHtml5', title:'Supplier Overdue Report',
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
		top: -136px;

	}

	#dataTableDiv_wrapper {
		width: 99.5%;
	}

	.reportfilter {
		border-right: 1px solid #e6e6e6;
		cursor: pointer;
	}

	.cmsouter .iconbox {
		width: 19% !important;
	}

	.loadsupp tr td {
		border: 2px solid #ccc;
		border-right: none;
		border-bottom: none;
	}

	.loadsupp tr td:last-child {
		border-right: 2px solid #ccc;
	}

	.loadsupp:last-child {
		border-bottom: 2px solid #ccc;
	}

	#exampleDiv_filter {
		position: absolute;
		right: 5px;
		font-size: 15px;

	}
</style>


<div style="padding: 0 15px;">
	<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
		<tr>
			<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 1 || $_REQUEST['filterId'] == '') { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierOverduefun(1);">More Than 7 Days</td>
			<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 2) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierOverduefun(2);">More Than 15 Days</td>
			<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 3) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierOverduefun(3);">More Than 30 Days</td>
			<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 4) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierOverduefun(4);">More Than 3 Month</td>
			<td class="reportfilter" <?php if ($_REQUEST['filterId'] == 5) { ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierOverduefun(5);">More Than 6 Month</td>
		</tr>
	</table>
</div>
<div style="padding: 15px;text-align: left;display: block;position: relative; width:96%;margin-bottom: 40px;">

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
			<td>
				<div style="display:block;">
					<table width="100%" border="0" id='dataTableDiv' cellpadding="10" cellspacing="0" class="loadsupp" style="margin-right: 0px;">
						<thead style="margin-right: 0px;">
							<tr style="background-color: rgb(230, 230, 230);">
								<th align="left"><strong>Sr.No.</strong></th>
								<th align="left"><strong>TourID</strong></th>
								<th align="left"><strong>Supplier Name</strong></th>
								<th align="left"><strong>Cont.&nbsp;Person</strong></th>
								<th align="left"><strong>Phone</strong></th>
								<th align="left"><strong>Sales&nbsp;Person</strong></th>
								<th align="left"><strong>Guest&nbsp;Name</strong></th>
								<th align="right"><strong>Total Amount</strong></th>
								<th align="right"><strong>Due Amount</strong></th>
								<th align="right"><strong>Paid Amount</strong></th>
								<th align="left" style="width: 50px !important;"><strong>DueDate</strong></th>
								<th align="left"><strong>Aging</strong></th>
							</tr>
						</thead>
						<?php
						$totalPaid = 0;
						$activePayment = 0;
						$totalPending = 0;
						$totalAmount = 0;
						$no = 1;
						$datefilterQuery = '';
						if ($_REQUEST['filterId'] == 2) {
							$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"';
						} elseif ($_REQUEST['filterId'] == 3) {
							$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"';
						} elseif ($_REQUEST['filterId'] == 4) {
							$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"';
						} elseif ($_REQUEST['filterId'] == 5) {
							$datefilterQuery = ' and dueDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"';
						} else {
							$datefilterQuery = 'and dueDate between "'.date('Y-m-d', strtotime('-6 days')).'" and "'.date('Y-m-d').'"';
						}
						$rs1 = '';
						$where = ' deletestatus=0 and quotationId in ( select id from quotationMaster where status=1 and queryId in (select id from queryMaster where queryStatus=3 )) and id not in ( select scheduleId from supplierPaymentMaster where paymentStatus=1 ) ' . $datefilterQuery . ' group by supplierStatusId order by dueDate asc';
						$rs1 = GetPageRecord('*', 'supplierSchedulePaymentMaster', $where);
						$activePayment = mysqli_num_rows($rs1);
						while ($suppSchedulePayData = mysqli_fetch_array($rs1)) {
							if ($suppSchedulePayData['dueDate'] != '0000-00-00' && $suppSchedulePayData['dueDate'] != '') {
								$fromDate = date("Y-m-d");
								$toDate = date("Y-m-d", strtotime($suppSchedulePayData['dueDate']));
								$objec = date_diff(date_create($fromDate), date_create($toDate));
								$agingStr = '<b>' . $objec->format("%r%a") . '&nbsp;days</b>'; // dont include todays paymnet
								// if($objec->format("%a") > 0){

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

								$suppAmount = ($supplierStatusData['totalSupplierCost']);
								$suppPaid = ($supplierPaymentData['totalpaid']);
								$suppPending = $suppAmount - $suppPaid;

								$totalSuppAmount = $totalSuppAmount + $suppAmount;
								$totalSuppPaid =  $totalSuppPaid + $suppPaid;
								// $totalSuppPending =  $totalSuppPending+($totalSuppAmount-$totalSuppPaid);
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
									<td align="right"><?php echo number_format(round($suppAmount, 2)); ?></td>
									<td align="right"><?php echo number_format(round($suppPending, 2)); ?></td>
									<td align="right"><?php echo number_format(round($suppPaid, 2)); ?></td>
									<td align="left"><?php if ($suppSchedulePayData['dueDate'] != '0000-00-00' && $suppSchedulePayData['dueDate'] != '') echo date("d-m-Y", strtotime($suppSchedulePayData['dueDate']));  ?></td>
									<td align="left"><?php echo $agingStr; ?></td>
								</tr>
						<?php
								$no++;
								// }
							}
						}
						?>
						<script>
							$('#activePayment').text('<?php echo ($activePayment); ?>');
							$('#totalPaid').text('<?php echo round($totalSuppPaid); ?>');
							$('#totalAmount').text('<?php echo round($totalSuppAmount); ?>');
							$('#totalPending').text('<?php echo round(($totalSuppAmount - $totalSuppPaid)); ?>');
						</script>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>