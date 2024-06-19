<?php 
include "inc.php"; 
$select='*';   
$where='id='.decode($_GET['queryId']).'';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs);   
?>

 <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#f2f1f1" class="tablesorter gridtable" style="border: 1px solid #91b486;">
  <tr>
    <td colspan="6" align="center" style="background-color: #91b486; color: #ffffff;">Assigned</td>
   </tr>
  <tr>
    <td align="center" style="background-color: #f2f1f1;"><strong>Guest Name </strong></td>
    <td align="center" style="background-color: #f2f1f1;"><strong>Group Code</strong></td>
    <td align="center" style="background-color: #f2f1f1;"><strong>Sub Group Code</strong></td>
    <td align="center" style="background-color: #f2f1f1;"><strong>Vehicle</strong></td>
    <td align="center" style="background-color: #f2f1f1;"><strong>Vehicle Reg. No</strong></td>
    <td align="center" style="background-color: #f2f1f1;">&nbsp;</td>
  </tr>
   <?php
	$where='queryId = "'.decode($_GET['queryId']).'" order by id asc'; 
	$rs=GetPageRecord($select,'travelArrangementMaster',$where); 
	if(mysqli_num_rows($rs)>0){
	while($resListing=mysqli_fetch_array($rs)){ 
	 
	$rs2=GetPageRecord('title,fname,lname','guestList','id="'.$resListing['guestListId'].'" order by id asc'); 
    $resListingGuest=mysqli_fetch_array($rs2);
	
	$rs3=GetPageRecord('name','vehicleMaster','id="'.$resListing['vehicleId'].'" order by id asc'); 
    $resListingvehicle=mysqli_fetch_array($rs3); 
	?>
  <tr>
    <td align="center"><?php echo stripslashes($resListingGuest['title']); ?> <?php echo stripslashes($resListingGuest['fname']); ?> <?php echo stripslashes($resListingGuest['lname']); ?></td>
    <td align="center"><?php echo ($resListing['groupCode']); ?></td>
    <td align="center"><?php echo ($resListing['subGroupCode']); ?></td>
    <td align="center"><?php echo ($resListingvehicle['name']); ?></td>
    <td align="center"><?php echo ($resListing['vehicleConfirmationNo']); ?></td>
    <td align="center"><i class="fa fa-trash" aria-hidden="true" style="color:#FF0000;font-size: 16px;" onclick="deleteGuestfun(<?php echo $resListing['id']; ?>);"></i></td>
  </tr> 
   <?php } }else{
   ?> 
   <tr>
    <td colspan="6" align="center">No Data Found... </td>
   </tr>
   <?php } ?>
   <div id="deleteguestDiv" style="display:none;"></div>
   <script>
   function deleteGuestfun(delId){
   	$('#deleteguestDiv').load('loadArrangementDeleteGuest.php?delId='+delId+'&action=deleteArrangementGuest');
   }
   </script>
</table>
