
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



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="47" />



<h3 class="cms_title">Guest List Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position:relative;padding:20px">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr >



<td  width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td width="629" align="center">&nbsp;</td>



<td   width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr style="position: absolute;left:264px;top:10px">

<td style="padding:0px 0px 0px 5px;"><input name="agentnamefto" type="text" class="topsearchfiledmain" id="agentnamefto" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentnamefto']!=''){ echo $_REQUEST['agentnamefto']; } ?>" size="100" maxlength="100" placeholder="Agent/FTO Name"></td>  

<td style="padding:0px 0px 0px 5px;" >
<select id="allocationStatus" name="allocationStatus" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 117px;">
<option value="">Status</option> 
<option value="1" <?php if($_GET['allocationStatus']=='1'){ ?>selected="selected"<?php } ?>>Completed</option>
<option value="2" <?php if($_GET['allocationStatus']=='2'){ ?>selected="selected"<?php } ?>>Pending</option>

</select> 
</td>              


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime('-30 days')).' - '.date('d-m-Y', strtotime('now')); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



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
padding-bottom: 15px !important; 
}

#example_filter {
position: absolute;
top: -65px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}
.gridtable td{
    padding: 5px;
}
#example_wrapper{
    width: 56.2%;
}


</style>
<div id="margin" class="filterable" style="padding:0px 5px;">

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable" style="width:100%">
<thead>
<tr>
<th width="40" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">SN</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Tour Id</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour Date</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Name</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; min-width: 250px;">Address</th>
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;min-width: 200px;">Contact&nbsp;Information</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; min-width: 180px;">Address&nbsp;Proof</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; min-width: 180px;">Passport</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; min-width: 180px;">VISA</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; min-width: 100px;"> Other</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Status </th>

<!-- <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Mail </th> -->


</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >

<?php 

$sno=1; 
$addr=1;
$visa=1;
$pass=1;  

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
$datewhere='';
}

if($_GET['guideId']!=''){

$guideId = 'and id in (select guideQuoteId from guideAllocation where 1 and GuideId="'.$_GET['guideId'].'")' ;
}else{

$guideId = '  ' ;
}

if($_GET['allocationStatus']!=''){

$allocationStatus = 'and id in (select guideQuoteId from guideAllocation where 1 and allocationStatus="'.$_GET['allocationStatus'].'")';
}else{

$allocationStatus = '  ' ;
}

if($_GET['agentnamefto']!=''){

$b2cagentname = explode(" ", $_GET['agentnamefto']);
$firstName = $b2cagentname[0];

$agentnamefto = 'and queryId in (select id from queryMaster where clientType=1 and companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['agentnamefto'].'%") or clientType=2 and companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$firstName.'%"))';
}else{

$agentnamefto = ' ' ;
}

// '.$datewhere.' '.$guideId.' '.$allocationStatus.'
$whereguest = 'contactType=3 and queryId2!="" '.$daterangeQuery.' order by id desc ';
$rs=GetPageRecord('*','contactsMaster',$whereguest); 
while($resultlists=mysqli_fetch_array($rs)){

    $result = GetPageRecord('*','queryMaster','id="'.$resultlists['queryId2'].'"');
    $queryData=mysqli_fetch_array($result);
    if($resultlists['contacttitleId']==1){
       $nametitle = 'Mr.';
    }elseif($resultlists['contacttitleId']==2){
        $nametitle = 'Mrs.';
    }elseif($resultlists['contacttitleId']==3){
        $nametitle = 'Ms.';
    }

    $res22 = GetPageRecord('*','phoneMaster','masterId="'.$resultlists['id'].'" and primaryvalue=1 and sectionType= "contacts" order by masterId desc');
    $PEdata=mysqli_fetch_array($res22);

    $res222 = GetPageRecord('*','emailMaster','masterId="'.$resultlists['id'].'" and primaryvalue=1 and sectionType= "contacts" order by masterId desc');
    $PEdata22=mysqli_fetch_array($res222);
    
   
    $resa = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=1');
    $addressproof1=mysqli_fetch_array($resa);
    $resp = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=2');
    $passport1=mysqli_fetch_array($resp);
    $resv = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=3');
    $visa1=mysqli_fetch_array($resv);
    $reso = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=4');
    $otherdocs=mysqli_fetch_array($reso);

?>
<tr style="text-align:center;">
<td><?php echo $sno; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE">
<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="<?php $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($resultlists['queryId2']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($resultlists['queryId2']); ?></a></div>
</td>
<td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($queryData['fromDate']=='' || $queryData['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($queryData['fromDate'])).' To '.date('d-m-Y',strtotime($queryData['toDate'])); }else{ echo date('d-m-Y',strtotime($queryData['fromDate'])).' To '.date('d-m-Y',strtotime($queryData['toDate'])); } ?></td>

<td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $nametitle.' '.$resultlists['firstName'].' '.$resultlists['middleName'].' '.$resultlists['lastName']; ?></td>
<!-- showClientTypeUserName($queryData['clientType'],$queryData['companyId']); -->
<td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo $resultlists['addressInfo']; ?></td>

<td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"> <strong>Phone:</strong> <?php echo $PEdata['phoneNo']; ?><br><strong>Email:</strong> <?php echo $PEdata22['email']; ?></td>

<td align="left" valign="top"> <?php
     $addp = '1';
     $res3 = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=1');
     //if(mysqli_num_rows($res3)>0){
         //while($addressproof=mysqli_fetch_array($res3)){
        // if($addressproof['documentAttachment']!=''){ ?> 
        <a target="_blank" href="dirfiles/<?php //echo $addressproof['documentAttachment']; ?>" style="width:88px; padding-right: 15px; display:inline-block; overflow-wrap: anywhere; padding-bottom:5px;"><?php echo 'View'.$addp; ?></a>
        <?php //} $addp++; } ?> 
        <span style='color: #45b558; vertical-align:top; width:50px;display:inline-block;font-size: 15px; float:right; position:absolute; top:5px;'>
             
        <select name='addreStatus<?php echo $addr; ?>' id='addreStatus<?php echo $addr; ?>' style='padding: 6px;border-color: #ccc;border-radius: 3px;' onchange="addressstatusfun<?php echo $addr; ?>();">
            <option value='1' <?php if($addressproof1['addproofstatus']=='1'){?> selected="selected" <?php } ?> >Received</option>
            <option value='2' <?php if($addressproof1['addproofstatus']=='2'){?> selected="selected" <?php } ?>>Verified</option>
            <option value='3' <?php if($addressproof1['addproofstatus']=='3'){?> selected="selected" <?php } ?>>Rejected</option>
        </select>
        </span>  
    <?php //}else{ ?>  
        <span style="color: red; text-align:center !important; display:inline-block;font-size: 15px;"><?php echo 'Not Received'; ?></span>
    <?php //} ?>
</td>
<td align="left" bgcolor="#FAFDFE" valign="top">
    
    <?php
    $add='1';
    $res4 = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=2');
    if(mysqli_num_rows($res4)>0){
    while($passport=mysqli_fetch_array($res4)){
     if($passport['documentAttachment']!=''){ ?> <a target="_blank" href="dirfiles/<?php echo $passport['documentAttachment']; ?>" style="width:88px; padding-right: 15px; display:inline-block; overflow-wrap: anywhere; padding-bottom:5px; "><?php echo 'View'.$add; ?></a>
    <?php $add++; } } ?> <span style='color: #45b558; vertical-align:top; width:50px;display:inline-block;font-size: 15px; float:right; position:absolute; top: 5px;'>
    <select name='passportStatus<?php echo $pass; ?>' id='passportStatus<?php echo $pass; ?>' style='padding: 6px;border-color: #ccc;border-radius: 3px;' onchange="passportstatusfun<?php echo $pass; ?>();">
    <option value='1' <?php if($passport1['passportstatus']==1) { ?> selected="selected" <?php } ?> >Received</option>
    <option value='2' <?php if($passport1['passportstatus']==2) { ?> selected="selected" <?php } ?> >Verified</option>
    <option value='3' <?php if($passport1['passportstatus']==3) { ?> selected="selected" <?php } ?> >Rejected</option>
</select></span> <?php }else{ ?> <span style="color: red; vertical-align: top; display:inline-block;font-size: 15px;"><?php echo 'Not Received'; ?></span> <?php } ?>

</td>
<td align="left" bgcolor="#FAFDFE" valign="top"> <?php 
        $addv = '1';
        $res5 = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'" and docType=3');
        if(mysqli_num_rows($res5)>0){
        while($VISA=mysqli_fetch_array($res5)){
    if($VISA['documentAttachment']!=''){ ?> <a target="_blank" href="dirfiles/<?php echo $VISA['documentAttachment']; ?>" style="width:88px; padding-right: 15px; display:inline-block; overflow-wrap: anywhere; padding-bottom:5px;"><?php echo 'View'.$addv; ?></a>
    <?php } $addv++; } ?> <span style='color: #45b558; vertical-align:top; width:50px;display:inline-block;font-size: 15px; float:right; position:absolute; top: 5px;'>
    <select name='visaStatus<?php echo $visa; ?>' id='visaStatus<?php echo $visa; ?>' style='padding: 6px;border-color: #ccc;border-radius: 3px;' onchange="visastatusfun<?php echo $visa; ?>();">
    <option value='1' <?php if($visa1['visastatus']==1) { ?> selected="selected" <?php } ?> >Received</option>
    <option value='2' <?php if($visa1['visastatus']==2) { ?> selected="selected" <?php } ?> >Verified</option>
    <option value='3' <?php if($visa1['visastatus']==3) { ?> selected="selected" <?php } ?> >Rejected</option>
    </select></span> <?php }else{ ?> <span style="color: red; vertical-align: top; display:inline-block;font-size: 15px;"><?php echo 'Not Received'; ?></span> <?php } ?></td>

<td align="center"><?php if($otherdocs['documentAttachment']!=''){ ?> <a target="_blank" href="<?php echo $fullurl; ?>dirfiles/<?php echo $otherdocs['documentAttachment']; ?>" style="overflow-wrap: anywhere; padding-bottom:5px;"><?php echo 'Other Attachment' ?></a> <?php } ?></td>

<td align="center" bgcolor="#FAFDFE" valign="top">
    <select name="reportstatus<?php echo $sno; ?>" id="reportstatus<?php echo $sno; ?>" style="padding: 5px; border-radius: 3px;" onchange="finalreportstatus<?php echo $sno; ?>();" >
            <option value='0' <?php if( $addressproof1['reportstatus']=='0' ) { ?> selected="selected" <?php } ?> >Pending</option>
            <option value='1' <?php if( $addressproof1['reportstatus']=='1' ) { ?> selected="selected" <?php } ?> >Accepted</option>
    </select>
</td>

</tr>
<div id="loadaddress"></div>
<div id="loadpassport"></div>
<div id="visatatusid"></div>
<div id="finalstatus"></div>

<script>
     function addressstatusfun<?php echo $addr; ?>(){
        var addstatus = $("#addreStatus<?php echo $addr; ?>").val();
        $("#loadaddress").load('documentstatusfile.php?action=addressStatusreport&statusId='+addstatus+'&documentId=<?php echo $resultlists['id']; ?>&docType=1');
    }

  function passportstatusfun<?php echo $pass; ?>(){
        var passportstatus = $("#passportStatus<?php echo $pass; ?>").val();
        $("#loadpassport").load('documentstatusfile.php?action=passportStatusreport&statusId='+passportstatus+'&documentId=<?php echo $resultlists['id']; ?>&docType=2');
    }

    
    function visastatusfun<?php echo $visa; ?>(){
        var visastatus = $("#visaStatus<?php echo $visa; ?>").val();
        $("#visatatusid").load('documentstatusfile.php?action=visaStatusreport&statusId='+visastatus+'&documentId=<?php echo $resultlists['id']; ?>&docType=3');

    }


    function finalreportstatus<?php echo $sno; ?>(){
        var reportstatus = $("#reportstatus<?php echo $sno; ?>").val();
        $("#finalstatus").load('documentstatusfile.php?action=finalereportStatus&statusId='+reportstatus+'&documentId=<?php echo $resultlists['id']; ?>&docType=1&docType=2&docType=3');

    }

  
</script>
<?php $sno++; $addr++; $visa++; $pass++; } ?>

</tbody>
</table>


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
$('#example').DataTable({
    "initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Guest List Report'},
{extend: 'excelHtml5', title: 'Guest List Report'},
{extend: 'pdfHtml5', title: 'Guest List Report',
orientation: 'landscape',
pageSize: 'LEGAL',
exportOptions: {
    // columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13 ]
}
}
],
language: { 
search: "Search: ",
searchPlaceholder: "Search By Keyword",
},
});
} );

</script>

</div>

</td>



</tr>

</table>

<script>
$(".doExpand").click(function(){
if($(this).hasClass('noExpand')){
$('.leftBox').css('width','20%').show();
$(".rightBox").css('width','80%');
$("#example_wrapper").css('width','56.2%');
$(this).removeClass('noExpand');
}else{
$('.leftBox').css('width','0%').hide();
$(".rightBox").css('width','100%');
$("#example_wrapper").css('width','70.2%');
$(this).addClass('noExpand');
}
});
</script>