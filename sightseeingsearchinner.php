<?php
include "inc.php"; 
include "config/logincheck.php"; 
$sightseeingName=addslashes($_REQUEST['sightseeingName']);
 
 $n=1;
if($sightseeingName!=''){  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='sightseeingName like "%'.$sightseeingName.'%" and status=1 order by sightseeingName asc';  
$rs=GetPageRecord($select,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 
?>
<a onclick="fillsightseeingName('<?php echo strip($resListing['sightseeingName']); ?>','<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['sightseeingName']); ?></a>
<?php $n++; } } ?>

 
<script>
$('#sightseeingId').val('0');
</script>
 

<?php if($n==1){ ?>
<script>
$('#sightseeingsearchinner').hide();
</script>
<?php } else { ?>
<script>
$('#sightseeingsearchinner').show();
</script>
<?php } ?>