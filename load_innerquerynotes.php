<?php
include "inc.php"; 
  
$select='';  
$where='';  
$rs='';   
$select='*';      
$where=' queryId='.$_REQUEST['id'].'  order by addDate desc';  
$rs=GetPageRecord($select,'queryNotesMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>

<div style="border-bottom:2px #ccc solid; padding:10px; position:relative;">

	 <div style="margin-bottom:5px; color:#666666; font-size:12px; position:absolute; right:10px; bottom:5px;"><?php echo getUserName($resListing['userId']); ?></div>

	 <div style="margin-bottom:2px; color:#000; font-size:14px; font-weight:500;"><?php echo stripslashes($resListing['title']); ?></div>

	 <div style="margin-bottom:5px; color:#666666; font-size:12px; "><em><?php echo stripslashes($resListing['subtitle']); ?></em></div>

	 <div style="margin-bottom:8px; color:#000; font-size:14px; "><?php echo nl2br(stripslashes($resListing['noteDetails'])); ?></div>

	 <div style="margin-bottom:8px; color:#666666; font-size:12px; "><?php echo date('h:i A - j F Y',strtotime($resListing['addDate'])); ?></div>
	
	<?php if($resListing['reminderDate']!='0000-00-00'){ ?>
	 <div style="margin-bottom:0px; color:#666666; font-size:12px; font-weight:500; "><i class="fa fa-clock-o" aria-hidden="true"></i> <?php if($resListing['reminderTime']!=''){ echo $resListing['reminderTime']; ?> <?php } echo date('d/m/Y',strtotime($resListing['reminderDate'])); ?></div>
 <?php } ?>

	 </div>

<?php }



$where=' id="'.$_REQUEST['id'].'"  order by id desc';  
$rs1=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resListing=mysqli_fetch_array($rs1);
if(strlen($resListing['queryCloseDetails'])>1){

	?>

<div style="border-bottom:2px #ccc solid; padding:10px; position:relative;">
<div style="margin-bottom:8px; color:#000; font-size:14px; "><?php echo nl2br(stripslashes($resListing['queryCloseDetails'])); ?></div>
</div>
<?php
}


?>
