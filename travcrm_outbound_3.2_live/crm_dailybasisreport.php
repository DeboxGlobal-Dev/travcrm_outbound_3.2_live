<div class="dashboardmainbox" style="background-color:#192631; padding:0px;">
 <link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

 <link href="css/datatablec.css" rel="stylesheet"/>

 <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

 <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

 <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<?php 

if($loginuserprofileId==1){ 
  $wheresearchassign=' 1   ';
} else { 
 $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].')))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))'; 
 $wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
 $todotimelineassign=' and assignto='.$_SESSION['userid'].' ';
}

$year=date('Y');
$monthName=date('F');
$thismonth=date('m');



if($_GET['assignto']!=''){  
  $whereQuery=''; 
  $whereQuery=' and  assignTo='.decode($_GET['assignto']).''; 
  $whereQuery222=' and  assign_to='.decode($_GET['assignto']).''; 
}
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$where=' year='.$year.' '.$whereQuery222.''; 
$rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
$resultTarget=mysqli_fetch_array($rs);  

$select=''; 
$where=''; 
$rs='';  
$select='*';  
$salesrevenue_target_monethvaluetotal=0;  
$salesrevenue_opportunity_monethvaluetotal=0;  
$monthvalue=0; 
$monthvalue_opportunity=0; 
$totalcallonly_stage=0; 
$initialmeeting_stage=0; 
$quotation_stage=0; 
$followupforclose_stage=0; 
$total_achievement=0; 
$total_lost=0;

$m=date('F'); 
if($_GET['assignto']!=''){  
  $salesrevenue_target_monethvaluetotal = $resultTarget["".$m.""]; 
} 
else { 
  $menu22=mysqli_query(db(),"select * from "._TARGET_MASTER_." where 1 "); 
  while($rest22=mysqli_fetch_array($menu22)){ 
    $salesrevenue_target_monethvaluetotal = $rest22["".$m.""]+$salesrevenue_target_monethvaluetotal; 
  }
}

$totalSales='0';
$menu2=mysqli_query(db(),"select id from "._QUERY_MASTER_." where 1 ".$whereQuery." "); 
while($rest2=mysqli_fetch_array($menu2)){ 

  $select=''; 
  $where=''; 
  $rs='';   
  $select='*'; 
  $where=' queryId='.$rest2['id'].''; 
  $rs=GetPageRecord($select,'agentPaymentRequest',$where); 
  $resultS=mysqli_fetch_array($rs);  
  $totalSales=$totalSales+$resultS['finalCost'];
} 
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-gauge.min.js"></script>
<script src="js/amcharts.js"></script>
<script src="js/funnel.js"></script>
<script src="js/light.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<style>

#chartdiv {

  width: 100%;

  height: 237px;

}	

#chartdiv a{display:none !important;}

.demo2 {position: relative; width: 250px; height: 250px; box-sizing: border-box;    margin: 33px auto 5px; }

</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">
      <form id="listform" name="listform" method="get">
        <style>
        .sidegradi{padding:41px 0px !important;} 
        .sidegradi .fa{font-size: 25px !important;} 



        .leftuserlist {
          width: 160px;
          background-color: #233a49;
          height: 1149px;
          overflow: auto;
          border-right: 4px solid #4285f4;
        }


        .leftuserlist a {
          padding: 8px 10px;
          display: block;
          color: #FFFFFF !important;
          font-size: 12px;
          text-decoration: none;
          margin-left: 5px; 
          margin-top: 5px;
        }

        .leftuserlist .active { 
          background-color: #2196f363; 
        }

        .leftuserlist .headerm {
          padding: 10px;
          color: #fff;
          background-color: #00000061;
          font-weight: 500;
          font-size: 14px;padding-left: 15px;
        }
        .inputstyle{
          width: 90%;
    border: none;
    outline: none;
    height: 30px;
    padding-left: 8px;
  }
  .spanstatus{
    color: #ffffff;
    padding: 2px 0px;
    border-radius: 2px;
  }

      </style>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="left" valign="top"><div class="leftuserlist">
            <div class="headerm">Users</div>
            <a href="<?php echo $fullurl; ?>">All Users</a>
            <?php 
            $select=''; 
            $where=''; 
            $rs='';  
            $select='*';    
            $where=' '.$wheresearchassign.'  and status=1 and userType=0 and profileId in (select id from profileMaster where profileName="Sales") order by firstName asc';  
            $rs=GetPageRecord($select,_USER_MASTER_,$where); 
            while($resListing=mysqli_fetch_array($rs)){  

              ?>
              <a href="<?php echo $fullurl; ?>?assignto=<?php echo encode($resListing['id']); ?>" <?php if(decode($_REQUEST['assignto'])==$resListing['id']){ ?>class="active"<?php } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></a>
            <?php } ?>
            <div class="headerm" style="margin-top: 20px;">Report</div>
            <a class="active" href="<?php echo $fullurl; ?>showpage.crm?module=salesReport">Sales Report</a>
          </div></td>
      </tr>
    </table>
  </form>
</td>
<td width="93%" align="left" valign="top" style="background:white;">
<div>
  <h2 style="margin:20px 10px;">
 <?php echo $pageName; ?>
</h2>
</div>
<div>
<form method="get" >
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#f1f1f1" >
<tr>
<td><div class="headingm" ><span id="topheadingmain"> <h2></h2> </span>

    </div></td>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="float:right;" >
<tr>
<td style="padding:0px 0px 0px 5px;">
<label>Sales&nbsp;Person</label>
  <select name="salesperson" id="salesperson" class="inputstyle">
   <option value="">Select</option>

<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='roleId!="" and firstName!="" and status=1 and deletestatus=0 order by id asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
  ?>

<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id'] == $_GET['salesperson']){ echo 'selected'; } ?>><?php echo $resListing['firstName'].' '.$resListing['lastName']; ?></option>
 <?php } ?>

</select></td>

     <td>
      <label>From&nbsp;Date</label>
      <input name="fromDate" type="date"  class="inputstyle" id="fromDate"  size="6"  placeholder="From"  value="<?php echo $_GET['fromDate'] ?>"/></td>

     <td style="padding:0px 0px 0px 5px;" > 
      <label>To&nbsp;Date</label>
  <input name="toDate" type="date"  class="inputstyle" id="toDate" size="6"  placeholder="To" value="<?php echo $_GET['toDate'] ?>"/> </td>


  <td style="padding:0px 0px 0px 5px;">
<label>Lead&nbsp;Type</label>
    <select name="leadtype" id="leadtype" class="inputstyle">
 <option value="">Select</option> 
<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" and deletestatus=0 and status=1 order by id';

$rs=GetPageRecord($select,'leadssourceMaster',$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($rest['id'] == $_GET['leadtype']){ echo 'selected'; } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>

</select>
</td>

 <td style="padding:0px 0px 0px 5px;">
  <label>Activity</label>
  <select name="activitytype" id="activitytype" class="inputstyle">
 <option value="">Select</option> 
<option value="1" <?php if($_GET['activitytype'] == 1){ echo 'selected'; } ?>>Lead Meeting</option>
<option value="2" <?php if($_GET['activitytype'] == 2){ echo 'selected'; } ?>>Lead Call</option>
<option value="3" <?php if($_GET['activitytype'] == 3){ echo 'selected'; } ?>>Lead Task</option>
<option value="4" <?php if($_GET['activitytype'] == 4){ echo 'selected'; } ?>>Normal Meeting</option>
<option value="5" <?php if($_GET['activitytype'] == 5){ echo 'selected'; } ?>>Normal Call</option>
<option value="6" <?php if($_GET['activitytype'] == 6){ echo 'selected'; } ?>>Normal Task</option>
</select>
</td>

<td style="padding:0px 0px 0px 5px;">
  <label>Status</label>
  <select name="status" id="status" class="inputstyle">
 <option value="">Select</option> 
<option value="1" <?php if($_GET['status'] == 1){ echo 'selected'; } ?>>Scheduled</option>
<option value="2" <?php if($_GET['status'] == 3){ echo 'selected'; } ?>>Held</option>
<option value="3" <?php if($_GET['status'] == 3){ echo 'selected'; } ?>>Cancelled</option>

</select>
</td>

  <td ><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #11b76c; border: 1px solid #5ba5f0; color: #fff; padding: 7px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>  

</tr>
</table>
</td>
</tr>
</table>    
</form>  
</div>

<!-- show -->
<?php

$meetingcount = 0;
$callcount = 0;
$taskcount = 0;
$followcount = 0;
$sPerson = 'All Users';
// search field
$salesPerson = '';
$fromDate = '';
$toDate = '';
$leadType = '';
$leadmeet = '';
$leadact = '';
$normalc = '';
$normalt = '';
$normalm = '';
$status = '';
$type = $_GET['activitytype'];

if($type != ''){
if($type == 1){
$leadmeet = '';
$leadact = ' and activityType =2';
$normalc = ' and status = 5';
$normalt = ' and status = 5';
$normalm = ' and status = 5';
}
if($type == 2){
$leadmeet = ' and status = 5';
$leadact = ' and activityType =1';
$normalc = ' and status = 5';
$normalt = ' and status = 5';
$normalm = ' and status = 5';
}
if($type == 3){
$leadmeet = ' and status = 5';
$leadact = ' and activityType =3';
$normalc = ' and status = 5';
$normalt = ' and status = 5';
$normalm = ' and status = 5';
  }
if($type == 4){
$leadmeet = ' and status = 5';
$leadact = ' and status = 5';
$normalc = ' and status = 5';
$normalt = ' and status = 5';
$normalm = '';
  }
if($type == 5){
$leadmeet = ' and status = 5';
$leadact = ' and status = 5';
$normalc = '';
$normalt = ' and status = 5';
$normalm = ' and status = 5';
  }
if($type == 6){ 
$leadmeet = ' and status = 5';
$leadact = ' and status = 5';
$normalc = ' and status = 5';
$normalt = '';
$normalm = ' and status = 5';
 }

}

if($_GET['salesperson'] != ''){

$rs3=GetPageRecord('id,firstName,lastName',_USER_MASTER_,'1 and id="'.$_GET['salesperson'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salesPerson = ' and assignTo="'.$resultSales['id'].'"';
$sPerson = $resultSales['firstName'].' '.$resultSales['lastName']; 
}

if($_GET['leadtype'] != ''){

$rs3=GetPageRecord('id','leadssourceMaster','1 and id="'.$_GET['leadtype'].'"'); 
$resultLead=mysqli_fetch_array($rs3);
$leadType = ' and leadsource="'.$resultLead['id'].'"';
}

if($_GET['fromDate'] != ''){
$fromDate = ' and fromDate >="'.date('Y-m-d',strtotime($_GET['fromDate'])).'"';
}

if($_GET['toDate'] != ''){
$toDate = ' and fromDate <= "'.date('Y-m-d',strtotime($_GET['toDate'])).'"';
}

if($_GET['status'] != ''){
$status = ' and status="'.$_GET['status'].'"';
}

// search field
 ?>
<div style="display:grid;margin: 30px 0px 10px;">
 <div style="color:white;background: #233a49;text-align: center;padding: 10px;font-size: 13px;">Report&nbsp;Summary</div>
 <div>
  <table class="table table-striped table-bordered" width="100%">
   <thead>
     <tr>
    <th>Sales&nbspPerson</th>
    <th>Meetings</th>
    <th>Calls</th>
    <th>Tasks</th>
    <th>Follow-up</th> 
   </tr> 
   <tbody>
     <tr>
       <td align="center"><?php echo $sPerson; ?></td>
       <td align="center">
         <?php
$where = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$leadmeet.' order by fromDate desc';
$where1 = 'leadId!="" and activityType=2 '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$leadact.' ';
$where2 = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$normalm.' and assignTo!="0"' ;

$rs=GetPageRecord('id','leadManageMaster',$where); 
$meetingcount+= mysqli_num_rows($rs);

$rs1=GetPageRecord('id','activityMaster',$where1); 
$meetingcount+= mysqli_num_rows($rs1);

$rs2=GetPageRecord('id',_MEETINGS_MASTER_,$where2); 
$meetingcount+= mysqli_num_rows($rs2);

echo $meetingcount;

          ?>

       </td>
       <td align="center">
        <?php
$where = 'leadId!="" and activityType=1 '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$leadact.' ';
$where1 = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$normalc.' and assignTo!="0"';

$rs=GetPageRecord('id','activityMaster',$where); 
$callcount+= mysqli_num_rows($rs);

$rs1=GetPageRecord('id',_CALLS_MASTER_,$where1);
$callcount+= mysqli_num_rows($rs1);

echo $callcount;
         ?> 
       </td>
       <td align="center">
<?php
$where = 'leadId!="" and activityType=3 '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$leadact.' ';
$where1 = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$normalt.' and assignTo!="0"';


$rs=GetPageRecord('id','activityMaster',$where); 
$taskcount+= mysqli_num_rows($rs);

$rs1=GetPageRecord('id',_TASKS_MASTER_,$where1); 
$taskcount+= mysqli_num_rows($rs1);

echo $taskcount;
         ?>          
       </td>
       <td align="center"><?php echo $followcount = $meetingcount + $callcount + $taskcount; ?></td>
     </tr>
   </tbody>
   </thead>
   
  </table> 
 </div>  
</div>
<!-- show -->

  <div class="innersecdash" style="margin-bottom:10px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
<td>
  <?php include 'tableSorting.php'; ?>



<div id="" style="padding:10px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>


  <th align="left" class="header" style="background: #233a49;color: white;">Lead&nbsp;Type</th>

  <th align="left" class="header" style="background: #233a49;color: white;">Sales&nbsp;Person</th>

   <th align="left" class="header" style="background: #233a49;color: white;">Date</th>

   <th align="left" class="header" style="background: #233a49;color: white;">Activity</th>

   <th align="left" class="header" style="background: #233a49;color: white;">Subject</th>

   <th align="left" class="header" style="background: #233a49;color: white;">Agent/Supplier</th>

   <th align="left" class="header" style="background: #233a49;color: white;" >Next&nbsp;Follow&nbsp;up&nbsp;Date</th>

   <th align="left" class="header" style="background: #233a49;color: white;" >Status</th>

   <th align="left" class="header" style="background: #233a49;color: white;" >Notes</th>

   </tr>

   </thead>


  <tbody>

  <?php

 $where = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$leadmeet.' order by fromDate desc';

$rs=GetPageRecord('*','leadManageMaster',$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];


if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>
    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left">Lead&nbsp;Meeting</td>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td align="left"><?php echo $agentSupp; ?></td>

    <td align="left"><?php echo date('d-m-Y',strtotime($resultlists['followupdate'])) ?></td>

    <td align="center"><?php
     if($resultlists['status'] == 1){ ?> <div class="spanstatus" style="background: green;">Scheduled</div> <?php }
     if($resultlists['status'] == 2){ ?> <div class="spanstatus" style="background: orange;">Held</div> <?php } 
     if($resultlists['status'] == 3){ ?> <div class="spanstatus" style="background: red;">Cancelled</div> <?php } 
   ?></td>

    <td align="left"><?php echo strip_tags($resultlists['description']); ?></td>

  </tr>

  <?php } ?>

   <?php
 $where = 'leadId!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$leadact.' ';
$rs=GetPageRecord('*','activityMaster',$where); 

while($resultleads=mysqli_fetch_array($rs)){ 

$rs1=GetPageRecord('*','leadManageMaster','id="'.$resultleads['leadId'].'"'); 
$resultlists=mysqli_fetch_array($rs1);


$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];


if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>
    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultleads['fromDate'])) ?></td>

    <td align="left">Lead&nbsp;<?php
    if($resultleads['activityType'] == 2){ echo 'Meeting'; }
    if($resultleads['activityType'] == 1){ echo 'Call'; }
    if($resultleads['activityType'] == 3){ echo 'Task'; }

     ?></td>

    <td align="left"><?php echo $resultleads['subject']; ?></td>

    <td align="left"><?php echo $agentSupp; ?></td>

    <td align="left"><?php echo date('d-m-Y',strtotime($resultleads['followupdate'])) ?></td>

    <td align="center"><?php
     if($resultleads['status'] == 1){ ?> <div class="spanstatus" style="background: green;">Scheduled</div> <?php }
     if($resultleads['status'] == 2){ ?> <div class="spanstatus" style="background: orange;">Held</div> <?php } 
     if($resultleads['status'] == 3){ ?> <div class="spanstatus" style="background: red;">Cancelled</div> <?php } 
   ?></td>

    <td align="left"><?php echo strip_tags($resultleads['description']); ?></td>

  </tr>

  <?php } ?>

   <?php
$where = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$normalc.' and assignTo!="0"';
$rs=GetPageRecord('*',_CALLS_MASTER_,$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];

if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>
    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left">Normal&nbsp;Call</td>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td align="left"><?php echo $agentSupp; ?></td>

    <td align="left"><?php echo date('d-m-Y',strtotime($resultlists['followupdate'])) ?></td>

    <td align="center"><?php
     if($resultlists['status'] == 1){ ?> <div class="spanstatus" style="background: green;">Scheduled</div> <?php }
     if($resultlists['status'] == 2){ ?> <div class="spanstatus" style="background: orange;">Held</div> <?php } 
     if($resultlists['status'] == 3){ ?> <div class="spanstatus" style="background: red;">Cancelled</div> <?php } 
   ?></td>

    <td align="left"><?php echo strip_tags($resultlists['description']); ?></td>

  </tr>

  <?php } ?>

  <?php
$where = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$normalt.' and assignTo!="0"';
$rs=GetPageRecord('*',_TASKS_MASTER_,$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];

if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>
    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left">Normal&nbsp;Task</td>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td align="left"><?php echo $agentSupp; ?></td>

    <td align="left"><?php echo date('d-m-Y',strtotime($resultlists['followupdate'])) ?></td>

   <td align="center"><?php
     if($resultlists['status'] == 1){ ?> <div class="spanstatus" style="background: green;">Scheduled</div> <?php }
     if($resultlists['status'] == 2){ ?> <div class="spanstatus" style="background: orange;">Held</div> <?php } 
     if($resultlists['status'] == 3){ ?> <div class="spanstatus" style="background: red;">Cancelled</div> <?php } 
   ?></td>

    <td align="left"><?php echo strip_tags($resultlists['description']); ?></td>

  </tr>

  <?php } ?>

  <?php
 $where = 'leadsource!="" '.$salesPerson.' '.$status.' '.$fromDate.' '.$toDate.' '.$leadType.' '.$normalm.' and assignTo!="0"' ;
$rs=GetPageRecord('*',_MEETINGS_MASTER_,$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];

if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>
    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left">Normal&nbsp;Meeting</td>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td align="left"><?php echo $agentSupp; ?></td>

    <td align="left"><?php echo date('d-m-Y',strtotime($resultlists['followupdate'])) ?></td>

    <td align="center"><?php
     if($resultlists['status'] == 1){ ?> <div class="spanstatus" style="background: green;">Scheduled</div> <?php }
     if($resultlists['status'] == 2){ ?> <div class="spanstatus" style="background: orange;">Held</div> <?php } 
     if($resultlists['status'] == 3){ ?> <div class="spanstatus" style="background: red;">Cancelled</div> <?php } 
   ?></td>

    <td align="left"><?php echo strip_tags($resultlists['description']); ?></td>

  </tr>

  <?php } ?>

</tbody>
</table>
</div>
</td>
</tr>

</table>



<script> 



$(document).ready(function() {

     $('#mainsectiontable').DataTable( {

        "paging":   false,

        "ordering": true,

        "info":     true,

        "searching": false,

        "order": [[ 1, 'asc' ],[ 2, 'asc' ],[ 3, 'asc' ]]



    } );

} );

</script>
</td>
</tr>
</table>
</div>
</td>
</tr>
</table>
</div>