<?php 
include "inc.php";
if ($_GET['id']!='') {
	$id = $_GET['id'];
}
?>
<div class="gridlable">
	<!-- Days -->
	<span class=""></span></div>
<div style="border:0px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px; overflow: auto;" > 
	<?php 
$rs = '';
$rs = GetPageRecord('*', _WEEKEND_MASTER_, ' name!="" and deletestatus=0 and id="'.$id.'"');
$resListing = mysqli_fetch_array($rs);

$daysName = explode(",", $resListing['daysName']);
foreach($daysName as $key => $value) {
	?><div style="padding:3px 10px; float:left; color:#FFFFFF; background-color:#2C8CB1; width:fit-content; margin:3px; border-radius:3px;"><?php echo  $value; ?></div>
	<?php 
}  ?>
</div>