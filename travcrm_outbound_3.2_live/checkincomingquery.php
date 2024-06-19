<?php
include "inc.php"; 
include "config/logincheck.php";
 
  
$id = decode($_REQUEST['id']);
$email = decode($_REQUEST['email']);
$phone = decode($_REQUEST['phone']);

$select4='*';   
$where4=' email="'.$email.'"  order by id desc'; 
$rs4=GetPageRecord($select4,_EMAIL_MASTER_,$where4); 
$count = mysqli_num_rows($rs4); 
$incoming=mysqli_fetch_array($rs4);  
$sectionType = $incoming['sectionType'];
if($sectionType=='contacts'){ $sectionType='B2C'; }
if($sectionType=='corporate'){ $sectionType='Company'; }
if($count > 0){
?>
<script>
var email = '<?php echo $email; ?>';
var phone = '<?php echo $phone; ?>';
var sectionType = '<?php echo $sectionType; ?>';
alert('This is already exist in '+sectionType);
window.location="showpage.crm?module=query&add=yes&incomingid=<?php echo encode($id); ?>&sectionType=<?php echo encode($sectionType); ?>";
 
</script>
<?php
}
else{
?>
<script> 
var email = '<?php echo $email; ?>';
var phone = '<?php echo $phone; ?>';
alert('This is not exist..!');
window.location="showpage.crm?module=query&add=yes&incomingid=<?php echo encode($id); ?>&sectionType=<?php echo encode($sectionType); ?>";
</script>
<?php
}
/*$select4='*';   
$where4='id='.$_REQUEST['id'].''; 
$rs4=GetPageRecord($select4,_INCOMING_QUERY_,$where4);  
$incoming=mysqli_fetch_array($rs4);*/
 ?>