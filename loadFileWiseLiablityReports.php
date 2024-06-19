<?php 
include "inc.php";
?>
    
    <link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <style>

    </style>
    
    

$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}

}, function(start, end, label) { 


});

});
</script>  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >




<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>">



<input name="report" id="report" type="hidden" value="41">
<h3 class="cms_title" style="padding-left:70px">File Wise Liability Report</h3> 
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">
<table width="100%" border="0" cellpadding="10" cellspacing="0" style="padding-bottom:20px;">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>

<td width="270" align="center">&nbsp;</td>

<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td> </td>

<td style="padding:0px 0px 0px 5px;">
<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
</td>



<td  style="padding:0px 0px 0px 5px;">
<input name="tourCode" value="<?= isset($_REQUEST['tourCode'])?trim($_REQUEST['tourCode']):'' ?>" type="text" class="topsearchfiledmain" style="width: 150px; border-radius: 2px;padding: 11px;" placeholder="Tour Code"/>
</td>

<td  style="padding:0px 0px 0px 5px;">
<select name="agent" id="agent" class="topsearchfiledmainselect" style="width:200px; padding: 9px; ">
<option value="">Agent Name</option>
<?php 
$clientQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' deletestatus!=1 and name!="" order by name ');

while($client=mysqli_fetch_array($clientQuery))
{
if(isset($_REQUEST['agent']) && $_REQUEST['agent']==$client['id'])
echo "<option value='".$client['id']."' selected >".$client['name']."</option>";
else
echo "<option value='".$client['id']."'>".$client['name']."</option>";
}
?>
</select>
<input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;"> 

</td>  

</tr>



</table></td>



</tr>

</table></td>

</tr>
</table>

</div>

</form>

<tr>                

<td>      
<div id="margin" class="filterable" style="padding:0px 5px;">

<style type="text/css">
table {
display: block;
/* overflow-x: auto; */
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

#example_filter {
position: absolute;
top: -70px;
left: 0%;
}

#example_filter input {
height: 32px;
width: 210px;
}
#example_wrapper{
	width:53.8%;
}

</style>

<?php

$totalTax = 0;
$totalAmountinr = 0;
$totalAmount = 0;

$quotationResult='';
$daterangeQuery='';
$whereDateCondition='';
if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$whereDateCondition = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
//  $whereDateCondition = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  '.$daterangeQuery.' group by currencyId  order by id asc';  
//  $datewhere='';
}


$whereCountry='';

$whereAgent='';

$whereClient='';

if(isset($_REQUEST['agent']) && $_REQUEST['agent']!='')
{
$whereAgent = ' companyId="'.$_REQUEST['agent'].'" ';
}

 
if(isset($_REQUEST['tourCode']) && $_REQUEST['tourCode']!='' && $tourIdSequence==1){
    $tourId = explode('/',trim($_REQUEST['tourCode']));
    $tourId = (int)$tourId[2];
    $tourCode = ' and queryId in (select id from queryMaster where monthTourId="'.$tourId.'") ';
} 
if(isset($_REQUEST['tourCode']) && $_REQUEST['tourCode']!='' && $tourIdSequence==2){
    $tourId = explode('/',trim($_REQUEST['tourCode']));
    $tourId = (int)$tourId[2];
    $tourCode = ' and queryId in (select id from queryMaster where yearTourId="'.$tourId.'") ';
} 

// if($_REQUEST['client'])
// {
//   $whereClient = ' and queryId in (select id from queryMaster where leadPaxName="'.$_REQUEST['client'].'" ) ';
// }

$outputTs='';
// $outputTs.='<table width="100%" border="0" cellpadding="10" cellspacing="0" >';
$outputTs.='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable dataTable no-footer"  style="width: 100%;" role="grid" aria-describedby="example_info">';
$outputTs.='
<thead>
<tr>
<td align="left"  bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>S.No.</strong></td>
<td align="left"  bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Tour Code</strong></td>
<td  align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014; color: rgb(255, 255, 255); background-color: rgb(35, 58, 73);"><strong>Subject Name</strong></td>';

// 
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Invoice Date</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Arrival</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Departure</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Day</strong></td>
$outputTs.='<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Agent</strong></td>
<td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Sales Person</strong></td>
<td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Operation Person</strong></td>
<td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Currency</strong></td>';
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Country</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Operation/Supplier Cost</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Total Amount</strong></td>

$outputTs.='
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Exchange Rate</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>P.Inv.Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Tax invoice Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Operation/Supplier Cost</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Advance Amount/Booking Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Profit/Loss Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Profit/Loss %</strong></td>

</tr></thead><tbody>';
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Profit/ Loss File</strong></td>
$wherecondition='';
if($whereAgent!='')
$wherecondition = ' deletestatus=0  and queryId in (select queryId from invoiceMaster where deletestatus=0) and queryId in (select id from queryMaster where '.$whereAgent.') '.$whereCountry.' '.$whereClient.' and status=1  '.$whereDateCondition.'  order by id asc'; 
else
$wherecondition = ' deletestatus=0  and queryId in (select queryId from invoiceMaster where deletestatus=0)  '.$whereCountry.' '.$whereClient.' and status=1 '.$tourCode.' '.$whereDateCondition.'  order by id asc'; 

//  $where = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  and fromDate between "'.$quotationResult['fromDate'].'" and "'.$quotationResult['toDate'].'" order by id asc'; 


//$rsqi=GetPageRecord('*',_QUOTATION_MASTER_,$where); 
$sn=1;
$rsqi=GetPageRecord('*',_QUOTATION_MASTER_,$wherecondition); 
// var_dump($rsqi);exit;
$totalQuery = mysqli_num_rows($rsqi); 
while($quotResulti=mysqli_fetch_array($rsqi)){

$rscuri=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotResulti['currencyId'].'"');
$currencyResulti=mysqli_fetch_array($rscuri);

$rs2=GetPageRecord('currencyValue','queryCurrencyRateMaster',' currencyId="'.$currencyResulti['id'].'"'); 
$editresult2=mysqli_fetch_array($rs2);
$exchangerate = number_format($editresult2['currencyValue'],4);

$rsque=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotResulti['queryId'].'"');
$queryResult=mysqli_fetch_array($rsque);
$totalPax = $queryResult['adult']+$queryResult['child'];

$rsinv=GetPageRecord('*',_INVOICE_MASTER_,'queryId="'.$queryResult['id'].'"');
$invoiceResult=mysqli_fetch_array($rsinv);

$supplierCost=0;

// $suppCostQuery=GetPageRecord('totalSupplierCost','finalQuotSupplierStatus','quotationId="'.$quotResulti['id'].'  order by id desc limit 1"');
$suppCostQuery=GetPageRecord('*','supplierPaymentMaster','quotationId="'.$quotResulti['id'].'  order by id desc limit 1"');

$suppCost=mysqli_fetch_array($suppCostQuery);

$rsagent=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
$agentResult=mysqli_fetch_array($rsagent);

$reqclientGst = $agentResult['reqclientGst'];
if ($reqclientGst != 0){
$Cgst = $agentResult['reqclientCGst'];
$Sgst = $agentResult['reqclientSGst'];
$Igst = $agentResult['reqclientIGst'];
$finalReqCost = $agentResult['reqclientCost'];

$cgsta = round($finalReqCost * $Cgst / 100);
$sgsta = round($finalReqCost * $Sgst / 100);
$igstvala = round($finalReqCost * $Igst / 100);

$taxAmount = $cgsta+$sgsta+$igstvala;
$totalTax = $totalTax+$taxAmount;
}



$ammount=$agentResult['reqclientCost'];

$totalAmount=$totalAmount+$ammount;

$finalCost = $agentResult['reqclientCost']+$taxAmount;
$totalAmountinr = $totalAmountinr+$finalCost;
//$totalAmountgstInr = $totalAmountgstInr+currency_converter($quotResulti['currencyId'],$baseCurrencyId,trim($finalCost))
if($exchangerate>0) 
$totalAmountin=round($finalCost/$exchangerate);
else
$totalAmountin=round($finalCost);

//==============  country ============
$destinationQuery=GetPageRecord('countryId', _DESTINATION_MASTER_ ,'id="'.$quotResulti['destinationId'].'"');
$destination=mysqli_fetch_array($destinationQuery);
$countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,'id="'.$destination['countryId'].'"');
$country=mysqli_fetch_array($countryQuery);



$outputTs.='<tr>';
//'<br>'.'&'.clean($queryResult['referanceNumber']).
$outputTs.='<td align="center">'.$sn.'</td><td align="left" ><div style="width:130px;" class="bluelink">'.makeQueryTourId($queryResult['id']).'</div></td>
<td align="left">'.$queryResult['subject'].'</td>';

$outputTs.='<td align="center">'.showClientTypeUserName($queryResult['clientType'],$queryResult['companyId']).'
</td><td>'.$queryResult['salesassignTo'].'</td><td>'.getUserName($queryResult['assignTo']).'</td><td>'.$currencyResulti['name'].'</td>';



$outputTs.='</div></td>';

$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($exchangerate).'</td>';
$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($finalCost).'</td>';
$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($finalCost).'</td>';
//  $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($suppCost['totalSupplierCost']).'</td>';
$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($quotResulti['totalCompanyCost']).'</td>';
$spPayMQ=GetPageRecord('*','supplierPaymentMaster','1 and quotationId="'.$quotResulti['id'].'" and paymentStatus=1 and paymentType=2 order by supplierStatusId,dateAdded ASC'); 
$spPayMA=mysqli_fetch_array($spPayMQ);

$advAmount = 0;
$advanceAmountQuery=GetPageRecord('amount', 'agentPaymentMaster' ,'quotationId="'.$quotResulti['id'].'" and paymentType=2 ');
while($advanceAmount=mysqli_fetch_array($advanceAmountQuery))
{
$advAmount += $advanceAmount['amount'];
}
$outputTs.='<td>'.getTwoDecimalNumberFormat($advAmount).'</td>';

$outputTs.='<td>'.getTwoDecimalNumberFormat($quotResulti['totalMargin']).'</td>';
$marginPercent = ($quotResulti['totalMargin']/($finalCost-$quotResulti['totalCompanyCost']))*100;

$outputTs.='<td>'.getTwoDecimalNumberFormat($marginPercent).'</td>';

$outputTs.='</tr>';
++$sn;
}

?>

<?php 
$outputTs.='</tbody></table>';
echo $outputTs;
?>

</div>
</td>
</tr>
</table>


<style>
.cmsouter .iconbox {
width:20% !important;
}
</style>   
<script type="text/javascript">

// $('#datepicker1').Zebra_DatePicker();
// $('#datepicker2').Zebra_DatePicker();
$(document).ready(function() {
$('#example').DataTable({

"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:99.4%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'File Wise Liability Report'},
{extend: 'excelHtml5', title: 'File Wise Liability Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'File Wise Liability Report',
orientation: 'landscape',
pageSize: 'LEGAL',
exportOptions: {
              columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13 ]
         },

}
],
language: { 
search: "Search: ",
searchPlaceholder: "Serach By Keyword",}
}
);
} );
</script>
   
    