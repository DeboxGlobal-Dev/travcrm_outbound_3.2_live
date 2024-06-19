<?php 
include "inc.php"; 
$select='*';   
$where='id="'.($_GET['vehicleId']).'"';   
$rs=GetPageRecord($select,'vehicleMaster',$where);  
$resultpage=mysqli_fetch_array($rs);
echo $resultpage['maxpax'];  
?>
<script>
$('#vehicleCapct').val('<?php echo $resultpage['maxpax']; ?>');
</script>