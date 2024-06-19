<?php
include "inc.php"; 
include "config/logincheck.php"; 


if($_REQUEST['deleteid']!='' && $_REQUEST['stype']=='transfer'){
deleteRecord(_ITINERARY_TIMELINE_MASTER_,' sectionId = '.$_REQUEST['deleteid'].' and itineraryType="transfer"');
deleteRecord(_ITINERARY_TRANSFER_MASTER_,' id = '.$_REQUEST['deleteid'].''); 
?>
<script>
alert('Transfer Deleted Successfully');
</script>
<?php 
}

if($_REQUEST['deleteid']!='' && $_REQUEST['stype']=='extra'){
deleteRecord(_ITINERARY_TIMELINE_MASTER_,' sectionId = '.$_REQUEST['deleteid'].' and itineraryType="extra"');
deleteRecord(_ITINERARY_EXTRA_MASTER_,' id = '.$_REQUEST['deleteid'].'');  
?>
<script>
alert('Extra Deleted Successfully');
</script>
<?php 
}


if($_REQUEST['deleteid']!='' && $_REQUEST['stype']=='sightseeing'){
deleteRecord(_ITINERARY_TIMELINE_MASTER_,' sectionId = '.$_REQUEST['deleteid'].' and itineraryType="sightseeing"');
deleteRecord(_ITINERARY_SIGHTSEEING_MASTER_,' id = '.$_REQUEST['deleteid'].'');  
?>
<script>
alert('Sightseeing Deleted Successfully');
</script>
<?php 
}

if($_REQUEST['deleteid']!='' && $_REQUEST['stype']=='flight'){
deleteRecord(_ITINERARY_TIMELINE_MASTER_,' sectionId = '.$_REQUEST['deleteid'].' and itineraryType="flight"');
deleteRecord(_ITINERARY_FLIGHT_MASTER_,' id = '.$_REQUEST['deleteid'].'');  
?>
<script>
alert('Flight Deleted Successfully');
</script>
<?php 
}


if($_REQUEST['deleteid']!='' && $_REQUEST['stype']=='hotel'){
deleteRecord(_ITINERARY_TIMELINE_MASTER_,' sectionId = '.$_REQUEST['deleteid'].' and itineraryType="hotel"');
deleteRecord(_ITINERARY_HOTEL_MASTER_,' id = '.$_REQUEST['deleteid'].'');  
?>
<script>
alert('Hotel Deleted Successfully');
</script>
<?php 
}




if($_GET['id']!=''){
$where2=''; 
$rs2='';   
$select2='*'; 
$where2='queryId='.$_GET['id'].''; 
$rs2=GetPageRecord($select2,_ITINERARY_MASTER_,$where2); 
$resultpage2=mysqli_fetch_array($rs2); 
$fromDate=date("d-m-Y", strtotime($resultpage2['fromDate']));
$toDate=date("d-m-Y", strtotime($resultpage2['toDate'])); 

 ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />

<?php
$n=1;
$begin = new DateTime($resultpage2['fromDate']);
$end   = new DateTime($resultpage2['toDate']);

for($i = $begin; $i <= $end; $i->modify('+1 day')){
 

?><div style=" padding-bottom:20px; padding-top:20px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" style="font-size:18px; font-weight:normal;">
	  <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left"><img src="images/calfieldicon.png" width="26" /></td>
    <td align="left" style="padding-left:10px;"><?php echo 'Day '.$n. ' &nbsp;|&nbsp; ' .date("j F Y (l)", strtotime($i->format("Y-m-d"))); ?></td>
  </tr>
</table>

	  
	  </td>
      <td width="50%" align="right"><input type="button" name="Submit" value="+ Add Plan" class="bluembutton" style="margin-top:20px;background-color: #45b558 !important;border: 1px #45b558 solid !important;  margin-top: 0px;" onclick="alertspopupopen('action=additineraryplan&queryId=<?php echo $_GET['id']; ?>&fromDate=<?php echo date("Y-m-d", strtotime($i->format("Y-m-d"))); ?>&destinationId=<?php echo $resultpage2['destinationId']; ?>','400px','auto');"></td>
    </tr>
  </table>
</div>


<div style="  margin-left:40px; padding-left:50px; border-left:3px #e0e0e0 solid;">
<?php 
$k=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' queryId='.$_GET['id'].' and date(traveltime)="'.date("Y-m-d", strtotime($i->format("Y-m-d"))).'" order by traveltime asc';  
$rs=GetPageRecord($select,_ITINERARY_TIMELINE_MASTER_,$where); 
while($resTimeline=mysqli_fetch_array($rs)){  


?>

<?php 
if($resTimeline['itineraryType']=='transfer'){

 
$select1='*';  
$where1='queryId='.$_GET['id'].' and id='.$resTimeline['sectionId'].' and traveltime="'.$resTimeline['traveltime'].'"'; 
$rs1=GetPageRecord($select1,_ITINERARY_TRANSFER_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>

<div style="padding:20px; background-color:#F8F8F8; text-align:left; margin-bottom:30px; position:relative; position:relative; <?php if($resMainSection['transferType']==1){ ?>background-image:url(images/dmcbusicon.png);<?php } ?><?php if($resMainSection['transferType']==2){ ?>background-image:url(images/dmccaricon.png);<?php } ?> background-repeat:no-repeat; background-position:right 20px bottom 20px;">
<div style="position:absolute; right:20px; top:20px;"><table border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td><a title="Edit" onclick="alertspopupopen('action=addtransferToitnerry&queryId=<?php echo $resMainSection['queryId']; ?>&fromDate=<?php echo $resMainSection['fromDate']; ?>&destinationId=<?php echo $resMainSection['destinationId']; ?>&id=<?php echo $resMainSection['id']; ?>','700px','auto');"><img src="images/editicon.png" /></a></td>
    <td style="padding:0px 10px;"><a  onclick="if(confirm('Are you sure you want delete this transfer?')) deletetrasferloaddaywiseplan('<?php echo $resMainSection['id']; ?>');" title="Delete"><img src="images/rdelete.png" /></a></td>
 
  </tr>
</table>
</div>


<div style="    width: 60px;
    height: 60px;
    background-color: #4c839e;
    text-align: center;
    left: -80px;
    position: absolute;
    top: 0px;
    border-radius: 100%;"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="middle"><div style="font-size:16px; color:#FFFFFF; line-height:20px;"><strong><?php echo date("h:i", strtotime($resTimeline['traveltime'])); ?></strong></div>
      <div style="font-size:12px; text-transform:uppercase; color:#FFFFFF;"><?php echo date("A", strtotime($resTimeline['traveltime'])); ?></div></td>
    </tr>
  
</table>
</div>


<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:15px;">
  <tr>
    <td colspan="3"> 
      <strong style="color:#4c839e;"><?php 
	  
 
 $select2='name';  
$where2='id='.$resMainSection['transferNameId'].''; 
$rs2=GetPageRecord($select2,_TRANSFER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?></strong> </td>
    </tr>
  <tr>
    <td colspan="3"><strong>Transportation Mode:</strong> <?php if($resMainSection['transferType']==1){ ?>SIC<?php } ?><?php if($resMainSection['transferType']==2){ ?>Private - <?php } ?> <?php if($resMainSection['transferType']==2){ ?>
	<?php 
 $select2='name,maxpax';  
$where2='id='.$resMainSection['vehicleId'].''; 
$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?> 
	
	<?php } ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Arrival Information :</strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Destination:</strong> <?php echo getDestination($resMainSection['destinationId']);  ?> - <strong>From:</strong> 
      <?php 
 $select2='name';  
$where2='id='.$resMainSection['transferFromId'].''; 
$rs2=GetPageRecord($select2,_TRANSFER_CATEGORY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?> - <strong>To</strong>      <?php 
 $select2='name';  
$where2='id='.$resMainSection['transferToId'].''; 
$rs2=GetPageRecord($select2,_TRANSFER_CATEGORY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?> <?php if($resMainSection['detail']!=''){ echo ' - '.$resMainSection['detail']; }  ?></td>
  </tr>
</table>
</div>

<?php } ?>

 
<?php  
if($resTimeline['itineraryType']=='flight'){

 
$select1='*';  
$where1='queryId='.$_GET['id'].' and id='.$resTimeline['sectionId'].''; 
$rs1=GetPageRecord($select1,_ITINERARY_FLIGHT_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>
<div style="padding:20px; background-color:#F8F8F8; text-align:left; margin-bottom:30px; position:relative; position:relative; <?php if($resMainSection['transferType']==1){ ?>background-image:url(images/dmcbusicon.png);<?php } ?><?php if($resMainSection['transferType']==2){ ?>background-image:url(images/dmccaricon.png);<?php } ?> background-repeat:no-repeat; background-position:right 20px bottom 20px;">
<div style="position:absolute; right:20px; top:20px;"><table border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td><a title="Edit" onclick="alertspopupopen('action=additineraryflightdetails&queryId=<?php echo $resMainSection['queryId']; ?>&fromDate=<?php echo $resMainSection['fromDate']; ?>&destinationId=<?php echo $resMainSection['destinationId']; ?>&id=<?php echo $resMainSection['id']; ?>','700px','auto');"><img src="images/editicon.png" /></a></td>
    <td style="padding:0px 10px;"><a  onclick="if(confirm('Are you sure you want delete this flight?')) deleteflightloaddaywiseplan('<?php echo $resMainSection['id']; ?>');" title="Delete"><img src="images/rdelete.png" /></a></td>
 
  </tr>
</table>
</div>


<div style="    width: 60px;
    height: 60px;
    background-color: #4c839e;
    text-align: center;
    left: -80px;
    position: absolute;
    top: 0px;
    border-radius: 100%;"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="middle"><div style="font-size:16px; color:#FFFFFF; line-height:20px;"><strong><?php echo date("h:i", strtotime($resTimeline['traveltime'])); ?></strong></div>
      <div style="font-size:12px; text-transform:uppercase; color:#FFFFFF;"><?php echo date("A", strtotime($resTimeline['traveltime'])); ?></div></td>
    </tr>
  
</table>
</div>


<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:15px;">
  <tr>
    <td colspan="3"> 
      <strong style="color:#4c839e;">Flight</strong> </td>
    </tr>
  <tr>
    <td colspan="3"><strong>Departure:</strong> <?php echo getDestination($resMainSection['departureDestination']);  ?> - <?php echo ($resMainSection['departureTime']);  ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Arrival:</strong> <?php echo getDestination($resMainSection['arrivalDestination']);  ?> - <?php echo ($resMainSection['arrivalTime']);  ?></td>
  </tr>
  <?php if($resMainSection['detail']!=''){ ?><tr>
    <td colspan="3"><strong>Note:</strong> <?php echo strip($resMainSection['detail']);  ?></td>
  </tr>
  <?php } ?>
</table>
</div>

<?php } ?>



<?php 

if($resTimeline['itineraryType']=='hotel'){

 
$select1='*';  
$where1='queryId='.$_GET['id'].' and id='.$resTimeline['sectionId'].''; 
$rs1=GetPageRecord($select1,_ITINERARY_HOTEL_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>
<div style="padding:20px; background-color:#F8F8F8; text-align:left; margin-bottom:30px; position:relative; position:relative; <?php if($resMainSection['transferType']==1){ ?>background-image:url(images/dmcbusicon.png);<?php } ?><?php if($resMainSection['transferType']==2){ ?>background-image:url(images/dmccaricon.png);<?php } ?> background-repeat:no-repeat; background-position:right 20px bottom 20px;">
<div style="position:absolute; right:20px; top:20px;"><table border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td><a title="Edit" onclick="alertspopupopen('action=addhotelToitnerry&queryId=<?php echo $resMainSection['queryId']; ?>&fromDate=<?php echo $resMainSection['fromDate']; ?>&destinationId=<?php echo $resMainSection['destinationId']; ?>&id=<?php echo $resMainSection['id']; ?>','700px','auto');"><img src="images/editicon.png" /></a></td>
    <td style="padding:0px 10px;"><a  onclick="if(confirm('Are you sure you want delete this hotel?')) deletehotelloaddaywiseplan('<?php echo $resMainSection['id']; ?>');" title="Delete"><img src="images/rdelete.png" /></a></td>
 
  </tr>
</table>
</div>


<div style="    width: 60px;
    height: 60px;
    background-color: #4c839e;
    text-align: center;
    left: -80px;
    position: absolute;
    top: 0px;
    border-radius: 100%;"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="middle"><div style="font-size:16px; color:#FFFFFF; line-height:20px;"><strong><?php echo date("h:i", strtotime($resTimeline['traveltime'])); ?></strong></div>
      <div style="font-size:12px; text-transform:uppercase; color:#FFFFFF;"><?php echo date("A", strtotime($resTimeline['traveltime'])); ?></div></td>
    </tr>
  
</table>
</div>


<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:15px;">
  <tr>
    <td width="14%" rowspan="4" valign="top"><div style="border:1px #e3e3e3 solid; background-color:#F3F3F3; width:180px; height:120px; margin-right:10px; overflow:hidden;"><img src="images/hotelimagenot.png" width="180" height="120" /></div></td>
    <td width="86%" colspan="3"> 
      <strong style="color:#4c839e;"><?php echo ($resMainSection['hotelName']);  ?></strong> <img src="images/<?php echo showStarrating($resMainSection['categoryId']); ?>" height="20" /></td>
    </tr>
  <tr>
    <td colspan="3"><?php echo ($resMainSection['address']);  ?> - <?php echo getDestination($resMainSection['destinationId']);  ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Check In:</strong> <?php echo ($resMainSection['checkInTime']);  ?> - <strong>Check Out:</strong> <?php echo ($resMainSection['checkoutTime']);  ?> - <?php echo ($resMainSection['night']);  ?> Night - <?php echo ($resMainSection['adult']);  ?> Adult - <?php echo ($resMainSection['child']);  ?> Child - <?php echo ($resMainSection['rooms']);  ?> Rooms - <?php echo ($resMainSection['	extrabad']);  ?> Extra bed -  <?php 
	$select2='*';  
$where2='id='.$resMainSection['roomType'].''; 
$rs2=GetPageRecord($select2,_ROOM_TYPE_MASTER_,$where2); 
$editresult=mysqli_fetch_array($rs2);
	echo $editresult['name'];
	 ?></td>
  </tr>
  <?php if($resMainSection['detail']!=''){ ?><tr>
    <td colspan="3"><strong>Note:</strong> <?php echo strip($resMainSection['detail']);  ?></td>
  </tr>
  <?php } ?>
</table>
</div>

<?php } ?>

<?php 
if($resTimeline['itineraryType']=='sightseeing'){

 
$select1='*';  
$where1='queryId='.$_GET['id'].' and id='.$resTimeline['sectionId'].' and traveltime="'.$resTimeline['traveltime'].'"'; 
$rs1=GetPageRecord($select1,_ITINERARY_SIGHTSEEING_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>

<div style="padding:20px; background-color:#F8F8F8; text-align:left; margin-bottom:30px; position:relative; position:relative; background-image:url(images/sightseeingicon.png);  background-repeat:no-repeat; background-position:right 20px bottom 20px;">
<div style="position:absolute; right:20px; top:20px;"><table border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td><a title="Edit" onclick="alertspopupopen('action=addsightseeingToitnerry&queryId=<?php echo $resMainSection['queryId']; ?>&fromDate=<?php echo $resMainSection['fromDate']; ?>&destinationId=<?php echo $resMainSection['destinationId']; ?>&id=<?php echo $resMainSection['id']; ?>','700px','auto');"><img src="images/editicon.png" /></a></td>
    <td style="padding:0px 10px;"><a  onclick="if(confirm('Are you sure you want delete this sightseeing?')) deletesightseeingloaddaywiseplan('<?php echo $resMainSection['id']; ?>');" title="Delete"><img src="images/rdelete.png" /></a></td>
 
  </tr>
</table>
</div>


<div style="    width: 60px;
    height: 60px;
    background-color: #4c839e;
    text-align: center;
    left: -80px;
    position: absolute;
    top: 0px;
    border-radius: 100%;"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="middle"><div style="font-size:16px; color:#FFFFFF; line-height:20px;"><strong><?php echo date("h:i", strtotime($resTimeline['traveltime'])); ?></strong></div>
      <div style="font-size:12px; text-transform:uppercase; color:#FFFFFF;"><?php echo date("A", strtotime($resTimeline['traveltime'])); ?></div></td>
    </tr>
  
</table>
</div>


<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:15px;">
  <tr>
    <td colspan="3"> 
      <strong style="color:#4c839e;">
Sightseeing / Activity</strong> </td>
    </tr>
  <tr>
    <td colspan="3"><?php echo ($resMainSection['sightseeingName']);  ?><?php if($resMainSection['detail']!=''){ echo ' - '.strip($resMainSection['detail']); }?></td>
  </tr>
  
  <tr>
    <td colspan="3"><strong>Destination:</strong> <?php echo getDestination($resMainSection['destinationId']);  ?> </td>
  </tr>
</table>
</div>

<?php } ?>

<?php 
if($resTimeline['itineraryType']=='extra'){

 
$select1='*';  
$where1='queryId='.$_GET['id'].' and id='.$resTimeline['sectionId'].' and traveltime="'.$resTimeline['traveltime'].'"'; 
$rs1=GetPageRecord($select1,_ITINERARY_EXTRA_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>

<div style="padding:20px; background-color:#F8F8F8; text-align:left; margin-bottom:30px; position:relative; position:relative;  background-repeat:no-repeat; background-position:right 20px bottom 20px; background-image:url(images/extraicon.png);">
<div style="position:absolute; right:20px; top:20px;"><table border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td><a title="Edit" onclick="alertspopupopen('action=addextraToitnerry&queryId=<?php echo $resMainSection['queryId']; ?>&fromDate=<?php echo $resMainSection['fromDate']; ?>&destinationId=<?php echo $resMainSection['destinationId']; ?>&id=<?php echo $resMainSection['id']; ?>','400px','auto');"><img src="images/editicon.png" /></a></td>
    <td style="padding:0px 10px;"><a  onclick="if(confirm('Are you sure you want delete this extra?')) deleteextraloaddaywiseplan('<?php echo $resMainSection['id']; ?>');" title="Delete"><img src="images/rdelete.png" /></a></td>
 
  </tr>
</table>
</div>


<div style="    width: 60px;
    height: 60px;
    background-color: #4c839e;
    text-align: center;
    left: -80px;
    position: absolute;
    top: 0px;
    border-radius: 100%;"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="middle"><div style="font-size:16px; color:#FFFFFF; line-height:20px;"><strong><?php echo date("h:i", strtotime($resTimeline['traveltime'])); ?></strong></div>
      <div style="font-size:12px; text-transform:uppercase; color:#FFFFFF;"><?php echo date("A", strtotime($resTimeline['traveltime'])); ?></div></td>
    </tr>
  
</table>
</div>


<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:15px;">
  <tr>
    <td colspan="3"> 
      <strong style="color:#4c839e;"><?php echo ($resMainSection['name']);  ?></strong> </td>
    </tr>
  
  <tr>
    <td colspan="3"><strong>Note:</strong></td>
  </tr>
  <tr>
    <td colspan="3"><?php echo ($resMainSection['detail']);  ?></td>
  </tr>
</table>
</div>

<?php } ?>



<?php $k++;} ?>
</div>
<?php if($k==1){ ?>
<div style="padding:20px; background-color:#F8F8F8; text-align:center;"><em>No Day Plan Added</em></div>
<?php } ?>


<?php $n++;}  ?>










<?php } ?>