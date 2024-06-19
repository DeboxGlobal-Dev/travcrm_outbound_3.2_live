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


<script>



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



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>

<td width="91%" align="left" valign="top" >

<!-- <form method="get"  >
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
<input name="report" id="report" type="hidden" value="8" />
<div class="" style=" width:100%; margin: 0px 0px 3px 0px;" >
<table width="100%" border="0" cellpadding="10" cellspacing="0" style="padding: 10px;">
<tr>
<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr style="position:relative">



<td width="629" align="center">&nbsp;</td>



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr style="position: absolute;top: -20px;left: 270px;">

<td style="padding:0px 0px 0px 5px;">  
<select id="name" name="agent" class="topsearchfiledmainselect" autocomplete="off" style="border-radius:0px!important;width:200px;"> 
<option value="">Select Agent</option> 
<?php  
$a12=GetPageRecord('*',_CORPORATE_MASTER_,' 1 and name!=""  and deletestatus=0  order by name asc'); 
while($guideData=mysqli_fetch_array($a12)){ 
?>
<option <?php echo "value='".strip($guideData['id'])."'"; if(isset($_REQUEST['agent']) && $_REQUEST['agent']==strip($guideData['id'])){echo 'selected';} ?> ><?php echo $guideData['name'];?></option>
<?php 
} 
?>
</select></td> 

<td style="padding:0px 0px 0px 5px;">  
<select id="name" name="btoCompany" class="topsearchfiledmainselect" autocomplete="off" style="border-radius:0px!important;width:200px;"> 
<option value="">Select B2C</option> 
<?php  
$B12='';
$B12=GetPageRecord('*',_CONTACT_MASTER_,' 1 and firstName!=""  and deletestatus=0  order by firstName asc'); 
while($BData=mysqli_fetch_array($B12)){ 
?>
<option <?php echo "value='".strip($BData['id'])."'"; if(isset($_REQUEST['btoCompany']) && $_REQUEST['btoCompany']==strip($BData['id'])){echo 'selected';} ?> ><?php echo $BData['firstName'].' '.$BData['middleName'].' '.$BData['lastName'];?></option>
<?php 
} 
?>
</select></td> 


<td style="padding:0px 0px 0px 5px;">
<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
</td>



<td style="padding:0px 0px 0px 5px;">
<input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" />
</td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form> -->



<div class="" style=" width:100%;"></div>

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
padding-bottom: 15px !important;} 
#example_filter {
position: absolute;
top: -93px;
left: 0%;
}
#example_wrapper{
    margin-top: 60px;
}
#example_filter  label{
font-size:18px;
}


#example_filter  input{
height: 37px;
width:210px;

}
.dataTables_length{
font-size: 14px;
}
.dataTables_info
{
font-size: 14px;
}
</style>

<div id="margin" class="filterable" style="padding:0px 5px;">
<?php 
$outputT='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" data-page-length="25" style="width:100%">
<thead>
<tr>
<th width="20" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent&nbsp;NAME</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Country</th>

<th width="20" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Pax</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Amount in INR (Incl. Tax)</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Amount in INR (Excl.  ST)</th>


</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >';



$no=0;   

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  

$daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';

$datewhere='';
}


$btoCompany='';
$agentname='';
if(isset($_REQUEST['agentCode']) && $_REQUEST['agentCode']!='' && $_REQUEST['clientType']==2){
$agentCode = ' and id="'.$_REQUEST['agentCode'].'" ';

$pax = 0;
$agentAmount = 0;

$where=' 1 '.$agentCode.'  and firstName!="" and id in (select companyId from queryMaster where clientType=2 and deletestatus=0 '.$daterangeQuery.')   group by firstName asc';  

$rs=GetPageRecord('*',_CONTACT_MASTER_,$where); 
$clientType="and clientType=2";
$clientType1="2";


}elseif(isset($_REQUEST['agentCode']) && $_REQUEST['agentCode']!=''  && $_REQUEST['clientType']==1){
$agentCode = ' and id="'.$_REQUEST['agentCode'].'" ';

$pax = 0;
$agentAmount = 0;

$where=' 1 '.$agentCode.'  and name!="" and id in (select companyId from queryMaster where clientType!=2 and deletestatus=0 '.$daterangeQuery.')   group by name asc';  

$rs=GetPageRecord('*',_CORPORATE_MASTER_,$where); 
$clientType="and clientType!=2";
$clientType1="1";
}else{
	$pax = 0;
$agentAmount = 0;

$where=' 1 '.$agentCode.'  and name!="" and id in (select companyId from queryMaster where deletestatus=0 '.$daterangeQuery.')   group by name asc';  

$rs=GetPageRecord('*',_CORPORATE_MASTER_,$where); 
$clientType="and clientType!=2";
$clientType1="1";

}

$sn=1;
while($resListing=mysqli_fetch_array($rs)){  

if($clientType1=='2'){
	$agnetName = $resListing['firstName'].' '.$resListing['middleName'].' '.$resListing['lastName'];
}elseif($clientType1=='1'){
	$agnetName = $resListing['name'];
}

$rscom=GetPageRecord('*',_COUNTRY_MASTER_,' id="'.$resListing['countryId'].'"'); 
$countryResult=mysqli_fetch_array($rscom);


$rsquery=GetPageRecord('*','queryMaster',' companyId='.$resListing['id'].' '.$clientType.' '.$daterangeQuery.' order by id asc '); 
$pax=0;
$agentAmount=0;
$reqclientCost=0;
// echo "hello";
// var_dump($rsquery);
$count = mysqli_num_rows($rsquery);
while($queryData=mysqli_fetch_array($rsquery)){

$totalpax = $queryData['adult']+$queryData['child'];
$pax = $pax+$totalpax;
$rs1 = GetPageRecord('*', 'paymentRequestMaster','queryid="'.$queryData['id'].'"');

$agentPaymentRequestData = mysqli_fetch_array($rs1);

$agentAmount = $agentAmount+$agentPaymentRequestData['totalClientCost'];
$reqclientCost = $reqclientCost+$agentPaymentRequestData['totalClientCostWithMarkup'];
// echo $pax.' '.$agentAmount.' '.$reqclientCost.' <br>';
}



$outputT.='<tr style="text-align:center;"><td>'.$sn.'</td>';
$outputT.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$agnetName.'</td>';

// <!----<td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>';
$outputT.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$countryResult['name'].'</td>';



$outputT.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$pax.'</td>';



$outputT.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.getTwoDecimalNumberFormat($agentAmount).'</td>';
$outputT.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.getTwoDecimalNumberFormat($reqclientCost).'</td>';

++$sn;   
$outputT.='</tr>';
} 

$outputT.='</tbody>';
$outputT.='</table>';
echo $outputT;
?>


<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Agnet turnover Report'},
{extend: 'excelHtml5', title: 'Agnet turnover Report'},
{extend: 'pdfHtml5', title: 'Agnet turnover Report'}
],
language: { 
search: "Search: ",
searchPlaceholder: "Agent , Country , Pax , Amount",
},

}
);
} );
</script>

</div>

</td>



</tr>



</table>
