<?php 
include "inc.php"; 
include "config/logincheck.php";

if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].' and queryId="'.$_GET['id'].'"'; 
deleteRecord(_QUERY_TRANSFER_MASTER_,$where);
}
 

$id=$_GET['id']; 
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >Destination</th>

     <th align="left" class="header ">Transfer Date</th>

     <th align="left" class="header ">Transfer Name </th>
     <th align="left" class="header ">Transfer From</th>
     <th align="left" class="header ">Transfer To</th>
     <th align="left" class="header ">Transfer Type</th>
     <th align="left" class="header ">Pickup Time </th>
     <th align="left" class="header ">Remark</th>
     <th align="center" class="header ">Action</th>
    </tr>
   </thead>

 


 

  <tbody>
  <?php 
	  $nod=1;
$select='*';
$where='queryId='.$id.'  order by id desc'; 
$rs=GetPageRecord($select,_QUERY_TRANSFER_MASTER_,$where); 
while($usermasterdocument=mysqli_fetch_array($rs)){
?>	 
  <tr>
    <td align="left"><?php echo getDestination($usermasterdocument['destination']); ?></td>

    <td align="left"><?php echo showdate($usermasterdocument['transferDate']); ?> </td>

    <td align="left"><?php 
	$select1='*';  
$where1='id='.$usermasterdocument['transferId'].''; 
$rs1=GetPageRecord($select1,_TRANSFER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1); 
echo clean($editresult['name']);  
	 ?></td>
    <td align="left"><?php 
 $select2='name';  
$where2='id='.$usermasterdocument['transferFromId'].''; 
$rs2=GetPageRecord($select2,_TRANSFER_CATEGORY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?></td>
    <td align="left"><?php 
 $select2='name';  
$where2='id='.$usermasterdocument['transferToId'].''; 
$rs2=GetPageRecord($select2,_TRANSFER_CATEGORY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?></td>
    <td align="left"><?php if($usermasterdocument['transferType']==1){ echo 'SIC'; } else  { echo 'Private'; } ?></td>
    <td align="left"><?php if(!empty($usermasterdocument['pickupTime'])){ echo $usermasterdocument['pickupTime']; } else { echo '-'; } ?></td>
    <td align="left"><?php echo ($usermasterdocument['remark']); ?></td>
    <td align="center"><img src="images/deleteicon.png"   style="cursor:pointer;" onClick="deleteloadtransferdetailsalert(<?php echo $usermasterdocument['id']; ?>);" /></td>
    </tr> 
	
	<?php $nod++;} ?>
</tbody></table>
<?php if($nod==1){ ?>
<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Transfer </div>
 <?php } ?>