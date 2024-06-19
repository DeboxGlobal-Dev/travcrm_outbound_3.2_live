<?php 
include "inc.php"; 
include "config/logincheck.php";

if($_GET['dltid']!=''){
	$where=' id='.$_GET['dltid'].' and queryId="'.$_GET['id'].'"'; 
	deleteRecord(_QUERY_ENTRANCE_MASTER_,$where);
}
$id=$_GET['id']; 
?> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable"> 
   <thead> 
   		<tr>
			<th align="left" class="header" >Destination</th> 
			<th align="left" class="header ">Entrance Date</th> 
			<th align="left" class="header ">Entrance Name </th> 
			<th align="left" class="header ">Remark</th>
			<th align="center" class="header ">Action</th>
    	</tr>
   	</thead> 
  	<tbody>
		<?php 
		$nod=1;
		$select='*';
		$where='queryId='.$id.'  order by id desc'; 
		$rs=GetPageRecord($select,_QUERY_ENTRANCE_MASTER_,$where); 
		while($usermasterdocument=mysqli_fetch_array($rs)){
		?>	 
	  	<tr>
			<td align="left"><?php echo getDestination($usermasterdocument['destination']); ?></td> 
			<td align="left"><?php echo showdate($usermasterdocument['entranceDate']); ?> </td> 
			<td align="left"><?php 
				$select1='*';  
				$where1='id='.$usermasterdocument['entranceId'].''; 
				$rs1=GetPageRecord($select1,_ENTRANCE_MASTER_MASTER_,$where1); 
				$editresult=mysqli_fetch_array($rs1); 
				echo clean($editresult['name']);  
			 ?></td> 
			<td align="left"><?php echo ($usermasterdocument['remark']); ?></td>
			<td align="center"><img src="images/deleteicon.png" style="cursor:pointer;" onClick="deleteentrancealert(<?php echo $usermasterdocument['id']; ?>);" /></td>
	  	</tr>  
  		<?php $nod++;} ?>
	</tbody>
</table>
<?php if($nod==1){ ?>
<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Entrance </div>
 <?php } ?>