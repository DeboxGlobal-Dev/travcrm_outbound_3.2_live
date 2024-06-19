<?php
include "inc.php";  

header("Content-type: application/vnd.ms-excel;charset=UTF-8"); 
header("Content-Disposition: attachment; filename=\"Guest-list-".date('d-m-Y-H-i-s').".xls");
header("Cache-control: private");

 ?>
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



   <thead>



   <tr>
     <th align="left" class="header" >Name</th>

     <th align="left" class="header">Phone</th>

     <th align="left" class="header">Email</th>

     <th align="left" class="header">address </th>

     <th align="center" class="header" >Category</th>
     <th align="left" class="header" >Hotel</th>
     <th align="center" class="header" >Accommodation</th>
     <th align="left" class="header" >Check&nbsp;In </th>
     <th align="left" class="header" >Check&nbsp;Out</th>
     <th align="center" class="header" >ID&nbsp;Proof</th>
     <th align="center" class="header" >Address&nbsp;Proof</th>
     <th align="center" class="header" >Passport</th>
     <th align="center" class="header" >Visa</th>
     </tr>
   </thead>



 





 



  <tbody>

  <?php

 $where='queryId = "'.decode($_REQUEST['q']).'" order by id asc'; 

$rs=GetPageRecord($select,'guestList',$where); 

while($resListing=mysqli_fetch_array($rs)){  

?>

  <tr>
    <td align="left"><div style="width:150px;"><?php echo stripslashes($resListing['name']); ?></div></td>

    <td align="left"><?php echo stripslashes($resListing['phone']); ?></td>

    <td align="left"><?php echo stripslashes($resListing['email']); ?></td>

    <td align="left"><div style="width:150px;"><?php echo stripslashes($resListing['address']); ?></div></td>

    <td align="center"  class="iconsfa"><?php echo $resListing['hotelCategory']; ?>&nbsp;Star</td>
    <td align="left"  class="iconsfa"><div style="width:150px;">
	<?php	$where1='id='.$resListing['hotelId'].'';  
$rs1=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,$where1);  
$querydata=mysqli_fetch_array($rs1);
echo $querydata['hotelName'];
?>
	</div></td>
    <td align="center"  class="iconsfa"><?php if($resListing['occupancy']==2){ echo 'Double'; } if($resListing['occupancy']==1){ echo 'Single'; }  if($resListing['occupancy']==3){ echo 'Triple'; } ?></td>
    <td align="left"  class="iconsfa"><?php echo date('d/m/Y',strtotime($resListing['checkIn'])); ?></td>
    <td align="left"  class="iconsfa"><?php echo date('d/m/Y',strtotime($resListing['checkOut'])); ?></td>
    <td align="center"  class="iconsfa"><?php	$where1='queryId='.$resListing['queryId'].' and guestId='.$resListing['id'].' and documentType="ID Proof"';  
$rs1=GetPageRecord('*','guestListDocuments',$where1);  
$querydata=mysqli_fetch_array($rs1);
if($querydata['id']!=''){ echo '<span class="greentabsss">Yes</span>'; } else { echo 'No'; }
?></td>
    <td align="center"  class="iconsfa"><?php	$where1='queryId='.$resListing['queryId'].' and guestId='.$resListing['id'].' and documentType="Address Proof"';  
$rs1=GetPageRecord('*','guestListDocuments',$where1);  
$querydata=mysqli_fetch_array($rs1);
if($querydata['id']!=''){ echo '<span class="greentabsss">Yes</span>'; } else { echo 'No'; }
?></td>
    <td align="center"  class="iconsfa"><?php	$where1='queryId='.$resListing['queryId'].' and guestId='.$resListing['id'].' and documentType="Passport"';  
$rs1=GetPageRecord('*','guestListDocuments',$where1);  
$querydata=mysqli_fetch_array($rs1);
if($querydata['id']!=''){ echo '<span class="greentabsss">Yes</span>'; } else { echo 'No'; }
?></td>
    <td align="center"  class="iconsfa"><?php	 $where1='queryId='.$resListing['queryId'].' and guestId='.$resListing['id'].' and documentType="Visa"';  
$rs1=GetPageRecord('*','guestListDocuments',$where1);  
$querydata=mysqli_fetch_array($rs1);
if($querydata['id']!=''){ echo '<span class="greentabsss">Yes</span>'; } else { echo 'No'; }
?></td>
   </tr> 

	

	<?php $no++; } ?>
</tbody></table>
