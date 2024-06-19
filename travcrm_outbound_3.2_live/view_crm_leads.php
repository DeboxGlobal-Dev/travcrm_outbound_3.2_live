<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
 

if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id="'.$id.'" '; 
$rs1=GetPageRecord($select1,'leadManageMaster',$where1); 
$resultlists=mysqli_fetch_array($rs1);
$editcompanyId=clean($resultlists['companyId']); 
$clientType=clean($resultlists['clientType']); 

  if($clientType==2){
    $select2='*';  
    $where2='id="'.$editcompanyId.'"'; 
    $rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
    $contantnamemain=mysqli_fetch_array($rs2);

    $clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
    $getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');
    $getemail =  getPrimaryEmail($contantnamemain['id'],'contacts'); 
    
      $contactPerson = $resultlists['guest1'];
  } else { 
    $clientnem = getCorporateCompany($editcompanyId);
    $getemail = getPrimaryEmailCompany($editcompanyId,"corporate");
    $getphone = getPrimaryPhoneCompany($editcompanyId,"corporate");


    $wherec='corporateId="'.$editcompanyId.'" and deletestatus=0 order by id asc';  
    $rsc=GetPageRecord('contactPerson','contactPersonMaster',$wherec);
    $resListingc=mysqli_fetch_array($rsc); 
    $contactPerson = $resListingc['contactPerson'];
     
  }
}

   
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<div style="margin-top:60px; padding:20px;">
 <div style="padding:20px 10px; background-color:#f7f7f7; border-radius: 4px; overflow:hidden;  border: 1px solid #e5e5e5; ">
 <div style="position:relative; font-size:20px; font-weight:500; margin-bottom:15px; padding-left:10px;"><?php echo clean($resultlists['subject']); ?><?php if($leadqe['id']==''){ ?><a href="showpage.crm?module=query&add=yes&leadId=<?php echo encode($resultlists['id']); ?>&salesEmail=<?php echo encode($getemail); ?>" style="position:absolute; right:11px; top:0px; padding:5px 10px; background-color:#4caf50; color:#fff; text-decoration:none; font-size: 13px; border-radius: 4px;">Convert to Query</a><?php } ?></div>
  
 <div style=" margin-left:10px;overflow: hidden; margin-right:10px; background-color:#FFFFFF; height:24px; border-radius: 3px;    border: 1px #fff solid;">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
  <?php
   $n=1;
$select='';
$where='';
$rs=''; 
$select='*';  
$where='status = 1 order by id asc';
$rs=GetPageRecord($select,'salesStageMaster',$where);
while($rest=mysqli_fetch_array($rs)){ 

$n++; }

$totalwidth=$n-1;
$totalwidth = 100/$totalwidth;

 
$select='';
$where='';
$rs=''; 
$select='*';  
$where=' status = 1 order by id asc';
$rs=GetPageRecord($select,'salesStageMaster',$where);
while($rest=mysqli_fetch_array($rs)){ 
?> 
    <td width="<?php echo $totalwidth; ?>%" colspan="3" align="center" valign="middle" id="selecttd<?php echo $n; ?>" style="font-size:11px; color:#666666; <?php if($resultlists['salesStage']==$rest['id']){ ?>background-color:#2cbf55; color:#fff;<?php } ?>"><?php echo stripslashes($rest['name']); ?></td>
  
  <?php if($resultlists['salesStage']==$rest['id']){ ?>
  <script>
  <?php 
  for ($k = 0 ; $k <$n; $k++){
  ?>
  $('#selecttd<?php echo $k; ?>').css('background-color','#2cbf55');
  $('#selecttd<?php echo $k; ?>').css('color','#fff');
  setTimeout(function(){ 
  $('#probid').text('<?php echo stripslashes($rest['probability']); ?>% Probabilities');
   }, 100);
  <?php } ?>
  </script>
  <?php } ?>
  
  
  <?php $n++; } ?>
  
    </tr>
</table>

 
 </div>
 <div style="margin-left:10px; margin-top:5px; font-size:13px;" id="probid">0% Probabilities</div>
 
 </div>
 <style>
.listtbl td{    border-bottom: 1px #b2b8be36 solid;}
.listtbl td strong{font-weight:500; color:#7a7a7a !important;}
.lightclr{ color:#848484;}
</style>
 <div style="margin-top:20px;">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="0" width="40%" align="left" valign="top"> 
  
  <div style="padding:10px; background-color:#f7f7f7; border-radius: 4px; overflow:hidden;    border: 1px solid #e5e5e5; ">
  <table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:13px;" class="listtbl">
  <tr>
    <td><strong>Lead Source</strong></td>
    <td><strong>:</strong></td>
    <td><?php    
    $wherel=' id='.$resultlists['leadsource'].'';  
    $rsl=GetPageRecord('name','leadssourceMaster',$wherel); 
    $resListingl=mysqli_fetch_array($rsl); 
    echo strip($resListingl['name']);  
     ?></td>
  </tr>
  <tr>
    <td width="33%"><span class="gridlable"><strong>Meeting Agenda</strong></span></td>
    <td width="2%"><strong>:</strong></td>
    <td width="65%"><?php echo $resultlists['subject']; ?></td>
  </tr>
  <tr>
    <td><strong>Client </strong></td>
    
    <td><strong>:</strong></td>
    <td><?php echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); ?></td>
  </tr>
  <tr>
    <td><strong>Contact Person</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $contactPerson; ?></td>
  </tr>
  <tr>
    <td><strong>Start Date</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>
  </tr>
  <tr>
    <td><strong>Created Date</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo date('d-m-Y',$resultlists['dateAdded']); ?></td>
  </tr>
  <tr>
    <td><strong>Destination</strong></td>
    <td><strong>:</strong></td>
    <td><?php
   $destId =   explode(",",$resultlists['destination']);

foreach ($destId as $value) {
  echo getDestination($value).', ';
}

?></td>
  </tr>
  <tr>
    <td><strong>Meeting Outcome</strong></td>
    <td><strong>:</strong></td>
    <td><?php    
$where='id="'.$resultlists['directiontype'].'"'; 
$rs=GetPageRecord('name',_MEETINGS_OUTCOME_,$where);
$resListing=mysqli_fetch_array($rs); 
     echo $resListing['name'];
  ?></td>
  </tr>
    <td><strong>Sales Person</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo getUserName($resultlists['assignTo']); ?></td>
  </tr>
  <tr>
    <td><strong>Description</strong></td>
    <td><strong>:</strong></td>
    <td><div><?php echo $resultlists['description'] ?></div></td>
  </tr>
 
</table>

  </div>
  </td>
    <td width="60%" align="left" valign="top">
  <style>
.listtabsec a {
    float: left;
    padding: 10px 20px;
    color: #666666;
    border-right: 1px solid #e5e5e5;
    font-size: 14px;
    color: #5d5d5d !important;
} 
.listtabsec a:hover{background-color:#ffffff;}
.listtabsec .active{background-color:#00000014;}

</style>
  <div style="margin-left:20px;">
  <div style="border: 1px solid #e5e5e5; border-radius: 4px; overflow:hidden; margin-bottom:10px; background-color:#f7f7f7;" class="listtabsec">
    <?php
   $n=1;
$select='';
$where='';
$rs=''; 
$select='*';  
$where='status = 1 order by id asc';
$rs=GetPageRecord($select,_ACTIVITY_TYPE_MASTER_,$where);
while($activitymasterdata=mysqli_fetch_array($rs)){ 
?>
  <a href="#" id="t<?php echo $activitymasterdata['id']; ?>" onclick="addactivity('<?php echo $activitymasterdata['id']; ?>');"><i class="fa fa-<?php echo $activitymasterdata['nameIcon']; ?>"></i> <?php echo $activitymasterdata['name']; ?></a>
  <?php } ?>  
  
  
  </div>
  
  <div id="addactivitydiv"></div>
  
  
  <script>
  
  function addactivityview(){
  $('#addactivitydiv').load('addactivitydiv.php?leadId=<?php echo $resultlists['id']; ?>');
  }
  
  
  function addactivity(atype){
  $('#addactivitydiv').show();
  $('.listtabsec a').removeClass('active');
  $('.listtabsec #t'+atype).addClass('active');
  var atype = encodeURIComponent(atype); 
  $('#addactivitydiv').load('addactivitydiv.php?type='+atype+'&leadId=<?php echo $resultlists['id']; ?>'); 
  }
  addactivityview();
  </script>
  </div>
  </td>
  </tr>
</table>

 </div>

 
 </div>