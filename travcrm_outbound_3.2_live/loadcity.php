<?php
include "inc.php";  


if(!empty($_REQUEST['id'])){
	$stateId=$_REQUEST['id'];
}
if(!empty($_REQUEST['stateId'])){
	$stateId=$_REQUEST['stateId'];
}
$selectId=$_REQUEST['selectId'];
?>

<option value="0">Select City</option>  
 <?php

 
$select=''; 
$where=''; 
$rs='';  
$select='*'; 
if($stateId!=''){
$stateId=' and stateId="'.$stateId.'" ';
}   
$where=' deletestatus=0 and status=1 '.$stateId.' order by name asc';  
$rs=GetPageRecord($select,'cityMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>

