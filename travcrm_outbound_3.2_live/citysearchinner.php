<?php
include "inc.php"; 
include "config/logincheck.php"; 
$cityName=addslashes($_REQUEST['cityName']);
 
 $n=1;
if($cityName!=''){  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='name like "'.$cityName.'%"   and deletestatus=0  order by name asc';  
$rs=GetPageRecord($select,_CITY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 
?>
<a onclick="fillcityname('<?php echo strip($resListing['name']); ?>','<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['name']); ?></a>
<?php $n++; } } ?>

<script>
$('#cityIdhotel').val('0');
</script>

<?php if($n==1){ ?>

<script>
$('#citysearchinner').hide();
</script>
<?php } else { ?>
<script>
$('#citysearchinner').show();
</script>
<?php } ?>