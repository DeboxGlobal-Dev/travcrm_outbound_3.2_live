<?php 
ob_start();
include "inc.php";  

 

if($_GET['id']!='' && is_numeric(decode($_GET['id']))){  

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(decode($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  


$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs); 


if($resultpage['clientType']==1){
$select4='name,id';  
$where4='id='.$resultpage['companyId'].''; 
$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4);  
}

if($resultpage['clientType']==2){
$select4='*';  
$where4='id='.$resultpage['companyId'].''; 
$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4);  
}

$where2=''; 
$rs2='';   
$select2='*'; 
$where2='queryId='.decode($_GET['id']).''; 
$rs2=GetPageRecord($select2,_ITINERARY_MASTER_,$where2); 
$resultpage2=mysqli_fetch_array($rs2); 
$fromDate=date("d-m-Y", strtotime($resultpage2['fromDate']));
$toDate=date("d-m-Y", strtotime($resultpage2['toDate'])); 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice - INV-<?php echo str_pad($resultInvoice['id'], 6, '0', STR_PAD_LEFT); ?></title>
 <link rel="stylesheet" href="css/default.css" type="text/css"> 
 <link rel="stylesheet" href="css/main.css" type="text/css">
 <style>
 #invoicearea .table {
    border: solid #ccc !important;
    border-width:1px !important;
}
#invoicearea .td {
    border: solid #ccc !important;
    border-width:1px !important;
}
 </style>
</head>

<body style="background-color:#FFFFFF;">


<div style="width:100%; "> 
 
<div style="margin-bottom:0px;   text-align:center; font-size:25px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:13px; <?php if($_REQUEST['send']==1){ ?>width:850px; border:1px #CCCCCC solid;<?php } ?>"><table width="100%" height="850" border="0" cellpadding="8" cellspacing="0"> 
  <tr>
    <td align="left;"><img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $fullurl; ?>tcpdf/examples/genrateitinerary.php?pageurl=<?php echo $fullurl; ?>itinerarypdf.php?id=<?php echo $_GET['id']; ?>==&choe=UTF-8" width="150" /></td>
  <td align="center">&nbsp;</td>
  <td align="right;"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSetting['logo']; ?>" width="181" /></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><img src="http://travstarz.in/crm/images/backpack-bag-blur-346768.jpg"width="860px;" height="400px;">;</td>
  </tr><?php
$n=1;
$begin = new DateTime($resultpage2['fromDate']);
$end   = new DateTime($resultpage2['toDate']);

for($i = $begin; $i <= $end; $i->modify('+1 day')){
 }

?>
    <tr>
    <td colspan="3" align="center" bgcolor="#e3aa0c" style="font-size:18px;font-family:verdana;"><?php echo date("j F Y l", strtotime($i->format($resultpage['fromDate']))); ?> - <?php echo date("j F Y l", strtotime($i->format($resultpage['toDate']))); ?></td>
    </tr>
  <tr>
    <td colspan="3" align="center" style="font-size:26px;color:#434140;font-family:verdana;"><?php echo  ucwords($resultpage['guest1']); ?>&nbsp;<?php echo ucwords($resultpage['subject']); ?>!</td>
    </tr>
  <tr>
    <td colspan="3" align="center" style="font-size:16px;color:#434140;font-family:verdana;">Itinerary For <?php echo ucwords($resultpage['guest1']); ?></td>
    </tr> 
  <tr>
    <td colspan="3"><center><p style="color:#e3aa0c;"width="500px; border:2px solid"><u style="border:10px solid;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p></center></td>
  </tr>  
</table>
  <tr>
    <td colspan="3" align="center"><div align="center"><span style="font-family:verdana;font-size:30px;color:#434140;">Welcome<!--<img src="<?php echo $fullurl; ?>images/thankyou.png" width="160" />--></span></div></td>
  </tr>
  <tr>
  <?php if($resultpage['clientType']==1){ $cname = strip($resultCompany['name']); } if($resultpage['clientType']==2){ $cname = strip($resultCompany['firstName'].' '.$resultCompany['lastName']); }  ?>
    <td style="font-size:14.5px; color:#333333;font-family:verdana;"colspan="8px;"align="left">
      <?php $thank = str_replace('{Client}', ''.$resultpage['guest1'].'', stripslashes($resultpage2['thankNotes'])); 
    echo $thank = str_replace('{Name of our company}', ''.$cname.'', $thank); ?>
    </td>
  </tr>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="page-break-before: always; color:#333333; font-size:14px;">
  <tr>
    <td colspan="3" align="left"><table width="100%" border="0" cellpadding="12" cellspacing="0">
      <tr>
        </tr>
    <?php
$n=1;
$begin = new DateTime($resultpage2['fromDate']);
$end   = new DateTime($resultpage2['toDate']);
for($i = $begin; $i <= $end; $i->modify('+1 day'))
{

?>
      <tr>
        <td bgcolor="#424244" style="font-size:15px; color:#FFFFFF;font-family:verdana;">
      <strong><?php echo 'Day '.$n. ' &nbsp;|&nbsp; ' .date("j F Y (l)", strtotime($i->format("Y-m-d"))); ?></strong>
    </td>
      </tr>
    <!--<tr>
      <td>
      <table width="100%" border="0" cellpadding="12" cellspacing="0">
        <tr>
          <td colspan="4"><img width="860px" height="400px;"src="<?php echo $resultpage['image'];?>"></td>
        </tr>
      </table>
        </td>
    </tr>-->
      <tr>
        <td valign="top">
    <?php 
    $k=1;
    $select=''; 
    $where=''; 
    $rs='';  
$select='*';    
$where=' queryId='.decode($_GET['id']).' and date(traveltime)="'.date("Y-m-d", strtotime($i->format("Y-m-d"))).'" order by traveltime asc';  
$rs=GetPageRecord($select,_ITINERARY_TIMELINE_MASTER_,$where); 
while($resTimeline=mysqli_fetch_array($rs)){  

?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3">
  <?php 
  if($resTimeline['itineraryType']=='transfer'){
  $select1='*';  
  $where1='queryId='.decode($_GET['id']).' and id='.$resTimeline['sectionId'].' and traveltime="'.$resTimeline['traveltime'].'"'; 
  $rs1=GetPageRecord($select1,_ITINERARY_TRANSFER_MASTER_,$where1); 
  $resMainSection=mysqli_fetch_array($rs1);  
  ?>

<div style=" text-align:left; margin-bottom:30px; position:relative; position:relative; <?php if($resMainSection['transferType']==1){ ?>background-image:url(images/dmcbusicon.png);<?php } ?><?php if($resMainSection['transferType']==2){ ?>background-image:url(images/dmccaricon.png);<?php } ?> background-repeat:no-repeat; background-position:right 20px bottom 20px;">

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:13px;font-family:verdana;">
  <tr>
  <td>
      <?php
      //error_reporting(E_ALL);
      $selectall='*';  
      $whereid='id='.$resMainSection['transferNameId'].' '; 
      $rsall=GetPageRecord($selectall,_TRANSFER_MASTER_,$whereid); 
      $transfers=mysqli_fetch_array($rsall);
      //echo "<pre>";
      //print_r($transfers);
      //echo "<pre>";
      ?>

    <table cellpadding="3"border="1" BORDERCOLOR="#F5F5F5"style="text-align:center;font-family:verdana;margin-bottom:15px;">
    <tr>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
        <?php echo $transfers['name'];?></span></p>
        <br /><p style="50%">Transfer</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['trnsfrfromtime']);  ?></span></p>
      <br /><p style="50%">Start Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['trnsfrtotime']);  ?></span></p>
      <br /><p style="50%">End Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      1:00 hour</span></p>
      <br /><p style="50%">Duration</p>
      </td>
    </tr>
    </table>
  </td>
  </tr>
  
  
  
  <tr>
    <td colspan="3"><strong style="color:#4c839e;"><?php $select2='name';  
$where2='id='.$resMainSection['transferNameId'].''; 
$rs2=GetPageRecord($select2,_TRANSFER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']); ?></strong> </td>
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
    <td colspan="3"><strong>From:</strong> 
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
?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Destination:</strong> <?php echo getDestination($resMainSection['destinationId']);  ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Highlights Of This Tour:</strong><?php if($resMainSection['detail']!=''){ echo ' - '.$resMainSection['detail']; }  ?></td>  
  </tr>
</table>
</div>

<?php } ?>


<?php 

if($resTimeline['itineraryType']=='flight'){

 
$select1='*';  
$where1='queryId='.decode($_GET['id']).' and id='.$resTimeline['sectionId'].''; 
$rs1=GetPageRecord($select1,_ITINERARY_FLIGHT_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>
<div style=" text-align:left; margin-bottom:30px; position:relative; position:relative; <?php if($resMainSection['transferType']==1){ ?>background-image:url(images/dmcbusicon.png);<?php } ?><?php if($resMainSection['transferType']==2){ ?>background-image:url(images/dmccaricon.png);<?php } ?> background-repeat:no-repeat; background-position:right 20px bottom 20px;">
 


 


<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:13px;font-family:verdana;">
  <tr>
    <td colspan="3">
    <?php
      //error_reporting(E_ALL);
      $selectf='*';  
      $wheref='id='.$resMainSection['departureDestination'].' '; 
      $rsf=GetPageRecord($selectf,_DESTINATION_MASTER_,$wheref); 
      $destination=mysqli_fetch_array($rsf);
      //echo "<pre>";
      //print_r($transfers);
      //echo "<pre>";
      ?>

    <table cellpadding="3"border="1" BORDERCOLOR="#F5F5F5"style="text-align:center;font-family:verdana;margin-bottom:15px;">
    <tr>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
        <?php echo getDestination($resMainSection['departureDestination']);  ?> To <?php echo getDestination($resMainSection['arrivalDestination']);  ?> </span></p>
        <br /><p style="50%">Flight</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['departureTime']);  ?></span></p>
      <br /><p style="50%">Departure Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['arrivalTime']);  ?></span></p>
      <br /><p style="50%">Arrival Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      1:00 hour</span></p>
      <br /><p style="50%">Duration</p>
      </td>
    </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td colspan="3"><strong style="color:#4c839e;">Flight</strong> </td>
    </tr>
  <tr>
    <td colspan="3"><strong>Departure:</strong> <?php echo getDestination($resMainSection['departureDestination']);  ?> - <?php echo ($resMainSection['departureTime']);  ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Arrival:</strong> <?php echo getDestination($resMainSection['arrivalDestination']);  ?> - <?php echo ($resMainSection['arrivalTime']);  ?></td>
  </tr>
  <?php if($resMainSection['detail']!=''){ ?><tr>
    <td colspan="3"><strong>Highlights Of This Tour :</strong> <?php echo strip($resMainSection['detail']);  ?></td>
  </tr>
  <?php } ?>
</table>
</div>

<?php } ?>



<?php 

if($resTimeline['itineraryType']=='hotel'){

 
$select1='*';  
$where1='queryId='.decode($_GET['id']).' and id='.$resTimeline['sectionId'].''; 
$rs1=GetPageRecord($select1,_ITINERARY_HOTEL_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>
<div style=" text-align:left; margin-bottom:30px; position:relative; position:relative; <?php if($resMainSection['transferType']==1){ ?>background-image:url(images/dmcbusicon.png);<?php } ?><?php if($resMainSection['transferType']==2){ ?>background-image:url(images/dmccaricon.png);<?php } ?> background-repeat:no-repeat; background-position:right 20px bottom 20px;">
 <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:13px;font-family:verdana;">
  <tr>
    <td colspan="3">
    <table cellpadding="2"border="1" BORDERCOLOR="#F5F5F5"style="text-align:center;font-family:verdana;margin-bottom:15px;">
    <tr>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
        <?php echo ($resMainSection['hotelName']);?></span></p>
        <br /><p style="50%">Hotel</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['checkInTime']);  ?></span></p>
      <br /><p style="50%">Check In</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['checkoutTime']);  ?></span></p>
      <br /><p style="50%">Check Out</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      
      1:00 hour</span></p>
      <br /><p style="50%">Duration</p>
      </td>
    </tr>
    </table>
  </td>
  </tr>
  <tr>
    
    <td width="86%" colspan="3"><strong style="color:#4c839e;"><?php echo ($resMainSection['hotelName']);  ?></strong> <img src="<?php echo $fullurl; ?>images/<?php echo showStarrating($resMainSection['categoryId']); ?>" height="20" /></td>
    </tr>
  <tr>
    <td colspan="3"><?php echo ($resMainSection['address']);  ?> - <?php echo getDestination($resMainSection['destinationId']);  ?></td>
  </tr>
  <tr>
     <?php
   $date1=$resMainSection['checkInTime'];
  $date2=$resMainSection['checkoutTime'];
  $resMainSection['date_diff']=date_diff($date1,$date2);
   ?>
    <td colspan="3"><strong>Check In:</strong> <?php echo ($resMainSection['checkInTime']);  ?> - <strong>Check Out:</strong> <?php echo ($resMainSection['checkoutTime']);  ?> - <?php echo ($resMainSection['night']);  ?> Night - <?php echo ($resMainSection['adult']);  ?> Adult - <?php echo ($resMainSection['child']);  ?> Child - <?php echo ($resMainSection['rooms']);  ?> Rooms - <?php echo ($resMainSection[' extrabad']);  ?>duration-<?php echo ($resMainSection['date_diff']);?> Extra bed -  <?php 
  $select2='*';  
    $where2='id='.$resMainSection['roomType'].''; 
    $rs2=GetPageRecord($select2,_ROOM_TYPE_MASTER_,$where2); 
    $editresult=mysqli_fetch_array($rs2);
  echo $editresult['name'];
   ?>
  </td>
  </tr>
  <?php if($resMainSection['detail']!=''){ ?><tr>
    <td colspan="3"><strong>Highlights Of This Tour: </strong> <?php echo strip($resMainSection['detail']);  ?></td>
  </tr>
  <?php } ?>
</table>
</div>

<?php } ?>

<?php 
if($resTimeline['itineraryType']=='sightseeing'){

 
$select1='*';  
$where1='queryId='.decode($_GET['id']).' and id='.$resTimeline['sectionId'].' and traveltime="'.$resTimeline['traveltime'].'"'; 
$rs1=GetPageRecord($select1,_ITINERARY_SIGHTSEEING_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>

<div style=" text-align:left; margin-bottom:30px; position:relative; position:relative;  background-repeat:no-repeat; background-position:right 20px bottom 20px;">
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:13px;font-family:verdana;">
  <tr>
    <td colspan="3">
    <table cellpadding="3"border="1" BORDERCOLOR="#F5F5F5"style="text-align:center;font-family:verdana;margin-bottom:15px;">
    <tr>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
        <?php echo ($resMainSection['sightseeingName']);?></span></p>
        <br /><p style="50%">SightSeeing</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['fromsighttime']);  ?></span></p>
      <br /><p style="50%">Start Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['tosighttime']);  ?></span></p>
      <br /><p style="50%">End Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      1:00 hour</span></p>
      <br /><p style="50%">Duration</p>
      </td>
    </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td colspan="3"><strong style="color:#4c839e;">Sightseeing / Activity</strong> </td>
    </tr>
  <tr>
    <td colspan="3"><?php echo ($resMainSection['sightseeingName']);  ?></td>
  </tr>
  
  <tr>
    <td colspan="3"><strong>Destination:</strong> <?php echo getDestination($resMainSection['destinationId']);  ?> </td>
  </tr>
  <tr>
    <td colspan="3"><strong>Highlights Of This Tour: </strong> <?php if($resMainSection['detail']!=''){ echo ' - '.strip($resMainSection['detail']); }?></td>
  </tr>
</table>
</div>

<?php } ?>

<?php 
if($resTimeline['itineraryType']=='extra'){
$select1='*';  
$where1='queryId='.decode($_GET['id']).' and id='.$resTimeline['sectionId'].' and traveltime="'.$resTimeline['traveltime'].'"'; 
$rs1=GetPageRecord($select1,_ITINERARY_EXTRA_MASTER_,$where1); 
$resMainSection=mysqli_fetch_array($rs1);  
?>

<div style=" text-align:left; margin-bottom:30px; position:relative; position:relative;  background-repeat:no-repeat; background-position:right 20px bottom 20px; ">
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:13px;font-family:verdana;">
  <tr>
    <td colspan="3">
    <table cellpadding="3"border="1" BORDERCOLOR="#F5F5F5"style="text-align:center;font-family:verdana;margin-bottom:15px;">
    <tr>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
        <?php ($resMainSection['name']);?></span></p>
        <br /><p style="50%">Extra</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['extrfromtime']);  ?></span></p>
      <br /><p style="50%">Start Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      <?php echo ($resMainSection['extrtotime']);  ?></span></p>
      <br /><p style="50%">End Time</p>
      </td>
      <td><p style="50%"><span style="padding:3px;color:#e3aa0c;font-size:18px;">
      1:00 hour</span></p>
      <br /><p style="50%">Duration</p>
      </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="3"><strong style="color:#4c839e;"><?php echo ($resMainSection['name']);  ?></strong> </td>
    </tr>
  
  <tr>
    <td colspan="3"><strong>Highlights Of This Tour :</strong></td>
  </tr>
  <tr>
    <td colspan="3"><?php echo ($resMainSection['detail']);  ?></td>
  </tr>
</table>
</div>

<?php } ?></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
</table>


    <?php $k++; } ?>    </td>
      </tr>
    
    <?php $n++;} ?>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="page-break-before: always;font-family:verdana;">
  <tr>
    <td align="center" bgcolor="#424244" style="color:#FFFFFF;">
  <table border="0" cellpadding="8" cellspacing="0">
  <tr>
    <td colspan="3"><span style="font-size:18px;">Inclusion & Exclusion / Cost, Terms &
  Condition</span></td>
    </tr>
    </table>
  </td>    </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3">&nbsp;</td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="color:#333333;"><table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#e3aa0c" style="font-size:14px; border-bottom:0px #F5F5F5 solid; color:#FFF;"><strong>Inclusion</strong></td>
    </tr>
  <tr>
    <td colspan="3" style="font-size:11px;"><?php echo stripslashes($resultpage2['inclusion']); ?></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;">&nbsp;</td>
  </tr>
</table><table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#e3aa0c" style="font-size:14px; border-bottom:0px #F5F5F5 solid; color:#FFF;"><strong>Exclusion</strong></td>
    </tr>
  <tr>
    <td colspan="3" style="font-size:11px;"><?php echo stripslashes($resultpage2['exclusion']); ?></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#e3aa0c" style="font-size:14px; border-bottom:0px #F5F5F5 solid; color:#FFF;"><strong>Cost</strong></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;"><?php echo stripslashes($resultpage2['cost']); ?></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#e3aa0c" style="font-size:14px; border-bottom:0px #F5F5F5 solid; color:#FFF;"><strong>Terms & Condition</strong></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;"><?php echo stripslashes($resultpage2['terms']); ?></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#e3aa0c" style="font-size:14px; border-bottom:0px #F5F5F5 solid; color:#FFF;"><strong>Tips</strong></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;"><?php echo stripslashes($resultpage2['tipsdetails']); ?></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td bgcolor="#e3aa0c" style="font-size:14px; border-bottom:0px #F5F5F5 solid; color:#FFF;"><strong>Other Information</strong></td>
  </tr>
  <tr>
    <td style="font-size:11px;"><?php echo stripslashes($resultpage2['otherinfo']); ?></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="left" valign="top"> </td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="18" cellspacing="0">
  <tr>
    <td colspan="3" align="left"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSetting['logo']; ?>" width="125" /></td>
  </tr>
  <tr>
    <td colspan="3" align="left" style="color:#333333; font-size:12px;font-family:verdana;"><strong><?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong><br /> 
      <?php echo stripslashes($resultInvoiceSetting['address']); ?><br />
      <strong>Email:</strong> <?php echo stripslashes($resultInvoiceSetting['email']); ?><br />      <strong>Phone:</strong> <?php echo stripslashes($resultInvoiceSetting['phone']); ?><div style="color:#999999; font-size:10px;"> </div><br />
<div style="text-align:center; font-size:12px; padding-top:10px; color:#999999; text-align:right;">Generated from travCRM</div></td>
  </tr>
</table>


</div>
 
</div>
 <style>

@media print 
{
  @page { margin: 0; }
  body  { margin:0cm; }
}
</style>
<?php if($_GET['print']==1){ ?>

<script>
window.print();
</script>
<?php } ?>
</body>
</html>
