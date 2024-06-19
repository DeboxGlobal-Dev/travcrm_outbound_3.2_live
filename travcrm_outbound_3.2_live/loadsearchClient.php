<?php
include "inc.php"; 
include "config/logincheck.php";  
?>


<?php 
if($_GET['usrType']==1){
?>
<option value="">All Agent</option>
<?php
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and name!="" order by name asc';  
$rs=GetPageRecord($select,_CORPORATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['userId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } } 



if($_GET['usrType']==2){


?>
<option value="">All Client</option>
<?php
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and firstName!="" order by firstName asc';  
$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['userId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['firstName']); ?> <?php echo strip($resListing['lastName']); ?></option>
<?php } }


if($_GET['usrType']==0){
  ?>
<option value="0">All Clients</option> 
<?php } ?>