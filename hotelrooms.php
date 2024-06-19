<?php
include "inc.php"; 
include "config/logincheck.php";

$roomtypeid=$_REQUEST['roomtypeid'];
$roomTypeArray =  explode(",", rtrim($roomtypeid,","));
?>
<option value="">Select</option>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
//$where=' id in (select roomType from '._DMC_ROOM_TARIFF_MASTER_.' where serviceid = '.$hotelId.') and deletestatus=0 and status=1 order by id asc'; 
foreach($roomTypeArray as $roomtypes){ 
$where='id='.$roomtypes.' and deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,_ROOM_TYPE_MASTER_,$where); 
$resListing=mysqli_fetch_array($rs);
?>
<option value="<?php echo strip($resListing['id']); ?>"  ><?php echo strip($resListing['name']); ?></option>
<?php } 
?>