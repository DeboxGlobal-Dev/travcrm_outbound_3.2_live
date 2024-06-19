
<style>
    .dataTables_wrapper .dataTables_filter {
		float: left;
		top: -43px;
		position: absolute;
	}
	.dataTables_wrapper .dataTables_info {
		padding: 15px!important;
	}
	.dataTables_wrapper .dataTables_length {
		padding: 10px!important;
	}
	.dataTables_wrapper .dataTables_paginate {
		padding: 10px!important;
	}
	 .dt-buttons{
	   margin: 30px auto;

	  
	} 
	.buttons-html5 {
		padding: 8px 20px 8px 15px;
		border-radius: 50px;
		cursor: pointer;
		font-size: 15px;
    	font-weight: 600;
		margin-right: 13px;
		
	}

	.buttons-html5:hover {
		background-color: #b8b8bb !important;
	}
	.buttons-copy::before {
		font-family: 'Font Awesome 5 Free';
		content: "\f0c5";
		font-weight: 900;
		padding-right: 6px;
	}

	.buttons-excel::before {
		font-family: 'Font Awesome 5 Free';
		content: "\f019";
		font-weight: 900;
		padding-right: 6px;
	}

	.buttons-pdf::before {
		font-family: 'Font Awesome 5 Free';
		content: "\f1c1";
		font-weight: 900;
		padding-right: 6px;
	}
	
	.dataTables_wrapper .dt-buttons .dt-button{
		background-color: #eee;
		/* border: 1px solid #ccc; */
		border-radius: 20px;
		padding: 8px 20px;
		cursor:pointer;
	}
	.dataTables_filter label{
	margin-left: 15px;
	}
	.dataTables_wrapper .dataTables_filter input {
		border: 1px solid #e2dcdc!important;
		border-radius: 16px!important;
		padding: 8px!important;
		min-width: 250px;
	}
	.gridtable .header{
		padding: 15px;
	}
	#example_filter {
		position: absolute;
		/* top: -44px; */
		left: 0%;
	}
	
	#example_filter label {
		font-size: 18px;
	}
	
	#example_filter input {
		height: 34px;
		width: 306px;
		border-radius: 42px;
	}
    .header{
        background-color: #000 !important;
        color: #fff;
    }
</style>

<?php 
ob_start();
include "inc.php"; 
include "config/logincheck.php";
 
?> 
<div id="pagelisterouter"  style="padding: 0%!important;">
<tr><h3 class="cms_title">Ferry Report</h3>
<table width="1304px" border="1" bordercolor="#ccc" id='exampleDiv' cellpadding="0" cellspacing="0" class="tablesorter gridtable borderclass" style=" margin-right:0px !important; width: 1304px !important;">
   <thead >
   <tr>
   	 <th width="25" align="left" class="header">SR.NO.</th> 
     <th width="100" align="left" class="header">Tour&nbsp;ID</th>
     <th width="100" align="left" class="header">Tour&nbsp;Date</th>
     <th width="100" align="left" class="header">Destination</th>
     <th width="100" align="left" class="header">Agent/FTO Name</th>
	 <th width="200" align="left" class="header">Lead Pax&nbsp;Name</th>
     <th width="150" align="left" class="header">Ferry&nbsp;Name</th> 
     <th width="50" align="left" class="header">Ferry&nbsp;Seat Type</th>
     <th width="50" align="left" class="header">PickUp.&nbsp;Time</th>
     <th width="50" align="right" class="header">Drop&nbsp;Time </th>
     <th width="50" align="right" class="header">PickUp&nbsp;Address</th>
     <th width="50" align="right" class="header">Drop&nbsp;Address</th>
     <th width="50" align="right" class="header">Status</th>
     </tr>
   </thead>
  <tbody>
<?php
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_REQUEST['records']); 
$searchField=clean(trim(ltrim($_REQUEST['searchField'], '0')));
$mainwhere=''; 

$travelDateQuery='';
if($_REQUEST['daterange']!=''){ 
  $myString = $_REQUEST['daterange'];
  $myArray = explode(' - ', $myString);  
  $fromDate = $myArray[0];
  $toDate = $myArray[1];
  $travelDateQuery = ' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
} 

$agentQuery=''; 
if($_REQUEST['agentCode']>0){  
	$agentQuery=' and queryId in ( select id from queryMaster where 1 and companyId="'.$_REQUEST['agentCode'].'" and clientType=1 ) ';
}

$paymentstatusQuery=''; 
if($_REQUEST['paymentstatus']==1){  
	$paymentstatusQuery=' and id in ( select scheduleId from agentPaymentMaster where 1 and paymentStatus=1 )';
}
if($_REQUEST['paymentstatus']==0 && $_REQUEST['paymentstatus']!=''){  
	$paymentstatusQuery=' and id not in ( select scheduleId from agentPaymentMaster where 1 and paymentStatus=1 )';
}

$where=' 1 and quotationId in ( select id from '._QUOTATION_MASTER_.' where 1 '.$travelDateQuery.' '.$agentQuery.' ) '.$paymentstatusQuery.' order by id desc '; 
$rs=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,$where); 
while($agentPaymentRequestData=mysqli_fetch_array($rs)){ 
	$an2ss=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$agentPaymentRequestData['quotationId'].'" ');
	$quotationData=mysqli_fetch_array($an2ss);
	
	$an2ss2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$agentPaymentRequestData['queryId'].'" ');
	$queryData=mysqli_fetch_array($an2ss2);
	
	if($quotationData['isTourEx'] == 1){
		$makeQueryId = makeExtensionId($queryData['displayId']);
	}else{
		$makeQueryId = makeQueryId($queryData['id']);
	}
	?>
  	<tr>   
	<td align="left"><?php echo $no; ?></td>
	<td align="left">
	<div class="bluelink" >
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']);?>"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
	<td align="left"><?php if($quotationData['fromDate']==''){} else {  echo date("d-m-Y", strtotime($quotationData['fromDate'])); }  ?> </td>
	<td align="left"><?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td> 
	<td align="left"><?php echo trim($queryData['guest1']); ?></td>
	<td align="left">
    <?php
        $select13=''; 
        $where13=''; 
        $rs13='';   
        $select13='*';  
        if($queryData['clientType']==1){   
			$rsc=GetPageRecord('contactPerson','contactPersonMaster',' corporateId="'.$queryData['companyId'].'" and deletestatus=0 order by id asc');
			$resListingc=mysqli_fetch_array($rsc);
			echo ($resListingc['contactPerson']);
        }
        if($queryData['clientType']==2){
			$where13="id='".$queryData['companyId']."'";
			$rs13=GetPageRecord($select13,_CONTACT_MASTER_,$where13); 
			$editresultcorporate=mysqli_fetch_array($rs13);
			echo $editresultcorporate['firstName'].' '.$editresultcorporate['lastName'];
        }
    ?></td>
    <td align="left"><?php 
	if($queryData['clientType']==1){     
	   // $rsc=GetPageRecord('*','contactPersonMaster',' corporateId="'.$queryData['companyId'].'" and deletestatus=0 order by id asc');  
	   // $resListingc=mysqli_fetch_array($rsc); 
   	//    echo ($resListingc['phone']); 
   	   echo getPrimaryPhone($queryData['companyId'],'corporate'); 
	}
    if($queryData['clientType']==2){ 
   		echo getPrimaryPhone($queryData['companyId'],'contacts'); 
   	} ?></td>
    <td align="right"><strong  style="color:#6ebac7"><?php   $totalCost = $agentPaymentRequestData['finalCost']; echo number_format(round($totalCost,2)); ?></strong></td>
    <td align="right"><?php   
		$r2='';
		$paid = 0;
		$r2=GetPageRecord('sum(amount) as totalAmount,ssp.*','agentSchedulePaymentMaster ssp','agentPaymentId="'.$agentPaymentRequestData['id'].'" and amount!="" and value!=""');
 		if(mysqli_num_rows($r2) > 0){ 
			$schedulePaymentData = mysqli_fetch_array($r2);
			
			$r3=GetPageRecord('sum(amount) as totalpaid, spm.*','agentPaymentMaster spm',' agentPaymentId="'.$agentPaymentRequestData['id'].'" and paymentStatus=1'); 
			$agentPaymentData = mysqli_fetch_array($r3);
			$paid = $agentPaymentData['totalpaid'];
			 
		} 
		
		$totalPending = $totalCost-$paid;  
		
		if($totalPending<1){
		?>
		<div style="color:#009900;"> <strong>Received</strong></div>
		<?php } else { ?>
		<div style="color:#CC3300;"><strong><?php echo number_format(round($totalPending,2)); ?></strong></div>
		<?php } ?> 
	</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
	</tr>
    <?php 
	$no++; 
} ?>
</tbody>
</table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>
</div>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
//for date picker load solution
	jQuery('#daterange').daterangepicker({
		"autoApply": true,
		opens: 'right',
		locale:
		{
			format: 'DD-MM-YYYY'
		}
	},
	function(start, end, label) {
	
	});
    $(document).ready(function() {
	//Data Tables
	$('#exampleDiv').DataTable({
		scrollX: 'true',
		// scrollY:'350px',
		dom: 'frtilpB',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'pdfHtml5'
		],
		language: {
			search: "Search: ",
			searchPlaceholder: "Agent Name, Contact Person , Mobile Number",
		},
			
	});
});
</script> -->

