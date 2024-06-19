<?php
include "inc.php"; 

if(trim($_REQUEST['action']) == 'quotationSupplierReply' && $_REQUEST['communicationId'] != ''){
$id = clean($_REQUEST['communicationId']);
$hotelName = clean($_REQUEST['hotelName']);
$hotelCategory = clean($_REQUEST['hotelCategory']);
$roomType = clean($_REQUEST['roomType']);
$mealType = clean($_REQUEST['mealType']);
$supplierRate = clean($_REQUEST['supplierRate']);
$totalCost = clean($_REQUEST['totalCost']);
$remarks = clean($_REQUEST['remarks']);
$typeOfSightseeing = clean($_REQUEST['typeOfSightseeing']);
$sightseeingName = clean($_REQUEST['sightseeingName']);
$transferName = clean($_REQUEST['transferName']);
$typeOfSightseeing = clean($_REQUEST['typeOfSightseeing']);
$typeOfTransfer = clean($_REQUEST['typeOfTransfer']);
$flightName = clean($_REQUEST['flightName']);
$packageName = clean($_REQUEST['packageName']);
$packageInclusions = clean($_REQUEST['packageInclusions']);
$submitfielbox = ($_REQUEST['submitfielbox']);
$queryId = decode($_REQUEST['queryId']);
$conformation = 0;
$dateAdded=time();
 
 include "config/mail.php";

$maildescription=stripslashes('<div style="width:600px; margin:auto; margin:20px; border:1px #CCCCCC solid; padding:10px;">'.$submitfielbox.'<br><br>'.$remarks.'</div>');
$ccmail='';
$fromemail='';
$fromemail='';

$select='*'; 
$where='userId=37'; 
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where); 
$result=mysqli_fetch_array($rs); 

$mailto=$result['email'];


$select1='*';   
$where1='queryid="'.$queryId.'" order by id asc LIMIT 1';  
$rs1=GetPageRecord($select1,_QUERYMAILS_MASTER_,$where1);  
$editresult=mysqli_fetch_array($rs1); 
  
$rs12='';  
$rs12=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
$resultlists12=mysqli_fetch_array($rs12);

$subject=clean($editresult['subject']);
$subject='#'.makeQueryId($resultlists12['id']).' '.$subject;
$mailsubject='[SUP'.$id.'] ' .str_replace('#','@',$subject);  

send_template_mail($fromemail,$mailto,$mailsubject,convert_cyr_string($maildescription,"w","w"),$ccmail);

$dateAdded=date('Y-m-d H:i:s');
 
$namevalue ='queryId="'.$queryId.'",supplierId="'.$id.'",subject="'.$mailsubject.'",detail="'.addslashes($maildescription).'",dateAdded="'.$dateAdded.'",directReply=1';    
addlistinggetlastid(_SUPPLIER_COMMUNICATION_MAIL_,$namevalue); 
  
$success = 1;
}


$select1='*';  
$where1='id="'.decode($_REQUEST['q']).'"'; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
?>
<?php if($_REQUEST['t']!='' && $_REQUEST['u']!='' && $_REQUEST['q']!=''){ ?>
<!DOCTYPE html>
<html>
<head>
	<title>Quotation Form</title>
	<style>
	.formbox{width:800px; margin:auto; background-color: #fff;
    padding: 30px;
    box-shadow: 0px 0px 10px #ccc; margin-top:30px;}
	.formbox table tr td{text-align:left; padding-bottom:6px;}
	input, textarea, select {padding:10px; border:1px #CCCCCC solid; box-sizing:border-box; width:100%;}
	.gbutton {
    background-color: #1d9a27;
    color: #fff;
    border: 1px #167b1e solid;
    font-size: 16px;
    border-radius: 2px;
    padding: 10px !important;
    width: 230px;
    font-weight: bold;
}
.validate{border-bottom:1px #CC3300 solid;}
	</style>
	<script src="js/validation.js"></script> 
	<link href="css/main.css" rel="stylesheet" type="text/css" />  
	<script src="js/jquery-1.11.3.min.js"></script>  
	<script src="js/main.js?id=<?php echo time(); ?>"></script>  
	<script>
	function addnewtypefun(){
	}
	</script>
    <style type="text/css">
<!--
.style1 {font-weight: bold}
-->
    </style>
</head>
<body>
	
<div class="formbox" style="width:800px;">
<div style="    margin-bottom: 30px;
    font-size: 40px;
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 2px #f7f7f7 solid;"><?php echo $systemname; ?></div>
<?php if ($success == 1) { ?>
		<div style="font-size: 20px;text-align: center;width: 100%;color: green;">Your quotation submitted successfully</div>
		</div>
	<?php } else {?>
<form action="" method="post" enctype="multipart/form-data" name="addeditfrm"  id="addeditfrm"  >
					<input name="action" id="action" type="hidden" value="quotationSupplierReply" />
					<input name="communicationId" id="communicationId" type="hidden" value="<?php echo decode($_REQUEST['u']); ?>" />
					<input name="queryId" id="queryId" type="hidden" value="<?php echo ($_REQUEST['q']); ?>" />
                    <strong style="font-size:18px;">#<?php echo makeQueryId($editresult['id']); ?> <?php echo $editresult['subject']; ?></strong><br>
                    <br>
                    <table width="100%">
					<tr>					</tr>
					<tr>
					  <th colspan="2" align="left" scope="row"><table width='100%' border='1' cellpadding='6' cellspacing='0' bordercolor='#78909c'>
  <tr>
    <td width="46%" bgcolor='#78909c' style='color:#FFFFFF;'>Destination</td>
    <td width="18%" bgcolor='#78909c' style='color:#FFFFFF;'>Adult</td>
    <td width="18%" bgcolor='#78909c' style='color:#FFFFFF;'>Child</td>
    <td width="18%" bgcolor='#78909c' style='color:#FFFFFF;'>Infant</td>
  </tr>
  <tr>
    <td><?php echo getDestination($editresult['destinationId']); ?></td>
    <td><?php echo $editresult['adult']; ?></td>
    <td><?php echo $editresult['child']; ?></td>
    <td><?php echo $editresult['infant']; ?></td>
  </tr>
</table></th>
					  </tr>
	<?php $type =  decode($_REQUEST['t']); $suptype =  decode($_REQUEST['t']); ?>
				
				<!-- Hotel 1 -->
					
					
					<tr>
					  <th colspan="2" align="left" scope="row">
					  <br>
<br>
<div  id="maildataall">
<?php if($type == 1 || $suptype=='100'){ ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:14px;">
    <div >  
    <?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	 
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].'  order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_HOTEL_,$where22); 
while($hotellisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$hotellisting['hotelId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
$hoteldetail=mysqli_fetch_array($rs1);    
?>
	
	 
	  <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="margin-bottom:10px; border:1px  solid #ccc; padding:10px; background-color:#e8e8e854;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">

  <tr>
    <td colspan="5" style="color:#666666; font-size:15px;"><strong><?php echo strip($hoteldetail['hotelName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Hotel </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:13px;">Category</td>
   <td width="20%" style="color:#666666; font-size:13px;">Room Type</td>
    <td width="20%" style="color:#666666; font-size:13px;">Meal Plan</td>
    <td width="20%" style="color:#666666; font-size:13px;">Price</td>
    <td width="20%" style="color:#666666; font-size:13px;">Availability</td>
  </tr>
	  <tr>
    <td width="20%" valign="top"><img src="<?php echo $fullurl; ?>images/<?php echo packageshowStarrating($hoteldetail['hotelCategory']); ?>" height="15" /></td>
    <td width="20%" valign="top"><strong><?php
	$select23='*';  
$where23='id='.$hotellisting['roomType'].''; 
$rs23=GetPageRecord($select23,_ROOM_TYPE_MASTER_,$where23); 
$roomtype=mysqli_fetch_array($rs23);
echo $roomtype['name']; 
?>
    </strong></td>
    <td width="20%" valign="top"><strong><?php
	$select24='*';  
$where24='id='.$hotellisting['mealPlan'].''; 
$rs24=GetPageRecord($select24,_MEAL_PLAN_MASTER_,$where24); 
$mealplan=mysqli_fetch_array($rs24);
echo $mealplan['name']; 
?>
    </strong></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="pricefields<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfields<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="field<?php echo strip($hoteldetail['id']);  ?>" onKeyUp="fillfield<?php echo strip($hoteldetail['id']);  ?>();">&nbsp;</div>
      <input type="hidden" class="validate"   displayname="<?php echo strip($hoteldetail['hotelName']);  ?> Availability" name="field1rate<?php echo strip($hoteldetail['id']);  ?>" id="field1rate<?php echo strip($hoteldetail['id']);  ?>"></td>
	  </tr>
	  <script>
	  function fillfield<?php echo strip($hoteldetail['id']);  ?>(){
	  var varfield = $('#field<?php echo strip($hoteldetail['id']);  ?>').text();
	  if(varfield!=''){
	  $('#field1rate<?php echo strip($hoteldetail['id']);  ?>').val('1');
	  } else { 
	  $('#field1rate<?php echo strip($hoteldetail['id']);  ?>').val('');
	  }
	  }
	  </script>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
    </div>
	</table>

					
	<?php	  $tt=1;  } ?>
	
<?php if($type == 2 || $suptype=='100'){ ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:14px;">
    <div >  
    <?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_AIRLINES_,$where22); 
while($transferlisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$transferlisting['airlineId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_AIRLINES_MASTER_,$where1); 
$transfergdetail=mysqli_fetch_array($rs1);    
?>   
	
	 
	  <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="margin-bottom:10px; border:1px  solid #ccc; padding:10px; background-color:#e8e8e854;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">

  <tr>
    <td colspan="5" style="color:#666666; font-size:15px;"><strong><?php echo strip($transfergdetail['flightName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Airline </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:13px;">Flight Number</td>
   <td width="20%" style="color:#666666; font-size:13px;">Time</td>
    <td width="20%" style="color:#666666; font-size:13px;">&nbsp;</td>
    <td width="20%" style="color:#666666; font-size:13px;">Price</td>
    <td width="20%" style="color:#666666; font-size:13px;">Availability</td>
  </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
      <?php if($transfergdetail['flightNo']!=''){ echo $transfergdetail['flightNo']; } ?>
    </span></td>
    <td width="20%" valign="top"><?php if($transferlisting['startTime']!=0){ echo date('h:i a',$transferlisting['startTime']); } ?></td>
    <td width="20%" valign="top">&nbsp;</td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="pricefields<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfields<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="fielda<?php echo strip($transferlisting['id']);  ?>" onKeyUp="fillfielda<?php echo strip($transferlisting['id']);  ?>();">&nbsp;</div>
      <input type="hidden" class="validate"   displayname="Airline Availability" name="field1ratea<?php echo strip($transferlisting['id']);  ?>" id="field1ratea<?php echo strip($transferlisting['id']);  ?>"></td>
	  </tr>
	  <script>
	  function fillfielda<?php echo strip($transferlisting['id']);  ?>(){
	  var varfield = $('#fielda<?php echo strip($transferlisting['id']);  ?>').text();
	  if(varfield!=''){
	  $('#field1ratea<?php echo strip($transferlisting['id']);  ?>').val('1');
	  } else { 
	  $('#field1ratea<?php echo strip($transferlisting['id']);  ?>').val('');
	  }
	  }
	  </script>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
    </div>
	</table>

<?php $tt=1; } ?>	

<?php if($type == 10 || $suptype=='100'){ ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:14px;">
    <div >  
    <?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_TRANSFER_,$where22); 
while($transferlisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$transferlisting['transferId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_TRANSFER_MASTER,$where1); 
$transfergdetail=mysqli_fetch_array($rs1);

$select1='*';  
$where1='transferNameId='.$transferlisting['transferId'].' and transferType='.$transferlisting['transferType'].''; 
$rs1=GetPageRecord($select1,_DMC_TRANSFER_RATE_MASTER_,$where1); 
$transferprice=mysqli_fetch_array($rs1);      
?>   
	
	 
	  <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="margin-bottom:10px; border:1px  solid #ccc; padding:10px; background-color:#e8e8e854;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">

  <tr>
    <td colspan="5" style="color:#666666; font-size:15px;"><strong><?php echo strip($transfergdetail['transferName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Transfer </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:13px;">Type</td>
   <td width="20%" style="color:#666666; font-size:13px;"><?php if($transferlisting['transferType']!=1){ ?>Vehicle<?php } ?></td>
    <td width="20%" style="color:#666666; font-size:13px;"><?php if($transferlisting['sightseeingType']!=1){ ?>Time<?php } ?></td>
    <td width="20%" style="color:#666666; font-size:13px;">Price</td>
    <td width="20%" style="color:#666666; font-size:13px;">Availability</td>
  </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
      <?php if($transfergdetail['transferType']=='1'){ echo 'SIC'; } else { echo 'Private'; } ?>
    </span></td>
    <td width="20%" valign="top"><?php if($transfergdetail['transferType']!=1){  
	$select1='*';  
$where1='id='.$transferlisting['vehicleId'].' '; 
$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
$vename=mysqli_fetch_array($rs1);
?><?php echo $vename['name']; } ?></td>
    <td width="20%" valign="top"><?php if($transferlisting['sightseeingType']!=1){ ?> <?php if($transferlisting['startTime']!=0){ echo date('h:i a',$transferlisting['startTime']); } ?> - <?php if($transferlisting['endTime']!=0){ echo date('h:i a',$transferlisting['endTime']); } } ?></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="pricefields<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfields<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="fieldt<?php echo strip($transferlisting['id']);  ?>" onKeyUp="fillfieldt<?php echo strip($transferlisting['id']);  ?>();">&nbsp;</div>
      <input type="hidden" class="validate"   displayname="Transfer Availability" name="field1ratet<?php echo strip($transferlisting['id']);  ?>" id="field1ratet<?php echo strip($transferlisting['id']);  ?>"></td>
	  </tr>
	  <script>
	  function fillfieldt<?php echo strip($transferlisting['id']);  ?>(){
	  var varfield = $('#fieldt<?php echo strip($transferlisting['id']);  ?>').text();
	  if(varfield!=''){
	  $('#field1ratet<?php echo strip($transferlisting['id']);  ?>').val('1');
	  } else { 
	  $('#field1ratet<?php echo strip($transferlisting['id']);  ?>').val('');
	  }
	  }
	  </script>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
    </div>
	</table>

<?php $tt=1; } ?>	

<?php if($type == 11 || $suptype=='100'){ ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:14px;">
    <div >  
    <?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_SIGHTSEEING_,$where22); 
while($sightseeinglisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$sightseeinglisting['sightseeingId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$sightseeingdetail=mysqli_fetch_array($rs1);   


$select1='*';  
$where1='sightseeingNameId='.$sightseeinglisting['sightseeingId'].' and sightseeingType='.$sightseeinglisting['sightseeingType'].''; 
$rs1=GetPageRecord($select1,_DMC_SIGHTSEEING_RATE_MASTER_,$where1); 
$sightseeingprice=mysqli_fetch_array($rs1);      
?>   
	
	 
	  <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="margin-bottom:10px; border:1px  solid #ccc; padding:10px; background-color:#e8e8e854;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">

  <tr>
    <td colspan="5" style="color:#666666; font-size:15px;"><strong><?php echo strip($sightseeingdetail['sightseeingName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Sightseeing </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:13px;">Type</td>
   <td width="20%" style="color:#666666; font-size:13px;"><?php if($sightseeinglisting['sightseeingType']!=1){ ?>Vehicle<?php } ?></td>
    <td width="20%" style="color:#666666; font-size:13px;"><?php if($sightseeinglisting['sightseeingType']!=1){ ?>Time<?php } ?></td>
    <td width="20%" style="color:#666666; font-size:13px;">Price</td>
    <td width="20%" style="color:#666666; font-size:13px;">Availability</td>
  </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
      <?php if($sightseeingdetail['sightseeingType']=='1'){ echo 'SIC'; } else { echo 'Private'; } ?>
    </span></td>
    <td width="20%" valign="top"><?php
	$select1='*';  
$where1='id='.$sightseeinglisting['vehicleId'].' '; 
$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
$vename=mysqli_fetch_array($rs1);
?><?php echo $vename['name'];?></td>
    <td width="20%" valign="top"><?php if($sightseeinglisting['sightseeingType']!=1){ ?> <?php if($sightseeinglisting['startTime']!=0){ echo date('h:i a',$sightseeinglisting['startTime']); } ?> - <?php if($sightseeinglisting['endTime']!=0){ echo date('h:i a',$sightseeinglisting['endTime']); } } ?></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="pricefields<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfields<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div></td>
    <td width="20%" valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="fields<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfields<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div>      </td>
	  </tr>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
    </div>
	</table>

<?php $tt=1; } ?>	
	
	<?php if($type == 12 || $suptype=='100'){ ?>
	
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:14px;">
    <div >  
    <?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_CRUISE_,$where22); 
while($transferlisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$transferlisting['cruiseId'].''; 
$rs1=GetPageRecord($select1,_CRUISE_MASTER_,$where1); 
$transfergdetail=mysqli_fetch_array($rs1);        
?>   
	
	 
	  <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="margin-bottom:10px; border:1px  solid #ccc; padding:10px; background-color:#e8e8e854;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">

  <tr>
    <td colspan="5" style="color:#666666; font-size:15px;"><strong><?php echo strip($transfergdetail['cruiseName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Cruise </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:13px;">Cabin No.</td>
    <td width="20%" style="color:#666666; font-size:13px;">Detail</td>
    <td width="20%" style="color:#666666; font-size:13px;">&nbsp; </td>
    <td width="20%" style="color:#666666; font-size:13px;">Price</td>
    <td width="20%" style="color:#666666; font-size:13px;">Availability</td>
  </tr>
	  <tr>
    <td valign="top"><span class="style1">
      <?php if($transfergdetail['cabinNumber']!=''){ echo $transfergdetail['cabinNumber']; } ?>
    </span></td>
    <td colspan="2" valign="top"><?php
	$select1='*';  
$where1='id='.$transferlisting['cruiseCompany'].''; 
$rs1=GetPageRecord($select1,_CRUISE_COMPANY_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?>, <?php
	$select1='*';  
$where1='id='.$transferlisting['cruiseType'].''; 
$rs1=GetPageRecord($select1,_CRUISE_TYPE_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?>, <?php
	$select1='*';  
$where1='id='.$transferlisting['cabinCategory'].''; 
$rs1=GetPageRecord($select1,_CABIN_CATEGORY_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?>, <?php
	$select1='*';  
$where1='id='.$transferlisting['cabinType'].''; 
$rs1=GetPageRecord($select1,_CABIN_TYPE_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?> </td>
    <td valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="pricefields<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfields<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div></td>
    <td valign="top"><div style="padding:5px; border:1px #CCCCCC solid; width:90px; background-color:#fff; font-size:16px;    height: 22px;" contenteditable="true" id="fieldcc<?php echo strip($sightseeinglisting['id']);  ?>" onKeyUp="fillfieldcc<?php echo strip($sightseeinglisting['id']);  ?>();">&nbsp;</div>      </td>
	  </tr>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
    </div>
	</table>

<?php $tt=1; } ?>	
</div>	</th>
					  </tr>
					  <tr>
					    <th colspan="2" align="left" scope="row">Response 
				          <br><br>

				          <textarea name="remarks" id="remarks" style="width:100%;" rows="10"></textarea>
						  
						  
						  <textarea name="submitfielbox" id="submitfielbox"  rows="10" style="display:none;"></textarea>						  </th>
				      </tr>
					  
					  <tr>
					  <th colspan="2" align="left" scope="row"><input type="button" class="gbutton" name="submitbtn" value="Submit Quotation" id="submitbtn" style="float:right;" onClick="maindataallfun();formValidation('addeditfrm','submitbtn','0');"/></th>
					  </tr>
	</table>
		<script>
						  function maindataallfun(){
						  var maildataall = $('#maildataall').html();
						  $('#submitfielbox').val(maildataall);
						  }
						  </script>
</form>
</div>
<?php } ?>



<div class="validationblackshade"  id="alertvalidation"><div class="alertbox">

 <div class="header" id="alertvalidationheader"></div>

 <div class="content" id="alertvalidationcontent" style="padding-bottom:10px;">

 

 </div><div style="padding:0px 0px 30px 0px; text-align:center;"><input type="button" name="button" value="OK" class="darkredbutton" style="margin-left:0px; position:inline-block; float:none;    width: 70px;" onClick="closeanydiv('alertvalidation');"  /></div>

 </div></div>
 
</body>
</html>
<?php } ?>