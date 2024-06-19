<?php
include "inc.php"; 
include "config/logincheck.php"; 
$keyword=$_REQUEST['keyword'];

if($keyword!=''){
?>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' hotelName like "%'.$keyword.'%"';  
$rs=GetPageRecord($select,_QUOTATION_HOTEL_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<div style="padding:10px; border-bottom:1px #CCCCCC solid; cursor:pointer; font-size:10px;" onClick="clickonautofillhotel('<?php echo stripslashes($resListing['hotelName']); ?>','<?php echo stripslashes($resListing['address']); ?>','<?php echo stripslashes($resListing['categoryId']); ?>');"> 
<?php echo stripslashes($resListing['hotelName']); ?>
</div>
<?php } ?>

<script>
$('#searchcuotationhotel').show();
</script>
<?php } else {  ?>
<script>
$('#searchcuotationhotel').hide();
</script>

<?php } ?>