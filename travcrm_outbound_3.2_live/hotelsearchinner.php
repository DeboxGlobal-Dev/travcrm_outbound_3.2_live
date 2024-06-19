<?php
include "inc.php"; 
include "config/logincheck.php"; 
$hotelName=addslashes($_REQUEST['hotelName']);
 
 $n=1;
if($hotelName!=''){  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='hotelName like "%'.$hotelName.'%" and status=1 order by hotelName asc';  
$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 
?>
<a onclick="fillhotelname('<?php echo strip($resListing['roomType']); ?>','<?php echo strip($resListing['hotelName']); ?>','<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['hotelName']); ?></a>
<?php $n++; } } ?>

 
<script>
$('#hotelId').val('0');
</script>
 

<?php if($n==1){ ?>
<script>
$('#hotelsearchinner').hide();
</script>
<?php } else { ?>
<script>
$('#hotelsearchinner').show();
</script>
<?php } ?>