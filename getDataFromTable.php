<?php 
include "inc.php";

$countryId = $_GET['countryId'];
$rs1=GetPageRecord(' * ','countryMaster','id="'.$countryId.'"'); 
$countryData = mysqli_fetch_array($rs1);
 ?>

<script type="text/javascript">
	$("#sortName").val('<?php echo $countryData['sortname'] ?>');
</script> 