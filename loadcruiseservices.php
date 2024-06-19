<?php
include "inc.php"; 
$wheredest='';
if($_REQUEST['action'] == 'getDestinations'){
if($_REQUEST['dayId']!='' && $_REQUEST['dayId']>0){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery); 
	
	if($_REQUEST['destinationId']!=''){
		$cityId = $_REQUEST['destinationId'];
	}else{
		$cityId = $dayData['cityId'];
	}
	
	$wheredest='and FIND_IN_SET("'.$cityId.'",destination) ';

} 

$rsCruise=GetPageRecord('*','cruiseMaster',' 1 and  status=1 '.$wheredest.'  order by cruiseName asc'); 
while($cruiseServiceData=mysqli_fetch_array($rsCruise)){ 
?>
<option value="<?php echo $cruiseServiceData['id']; ?>"><?php echo $cruiseServiceData['cruiseName']; ?></option>
<?php } 
}

if($_REQUEST['action']=='getCruiseDurationDate' && $_REQUEST['cruiseServiceId']!=''){
	$whereC = 'id="'.$_REQUEST['cruiseServiceId'].'" and departureDate="'.$_REQUEST['travelDate'].'"';
	$result = GetPageRecord('*','cruiseMaster',$whereC);
	if(mysqli_num_rows($result)>0){
	$cruiseData = mysqli_fetch_assoc($result);
		$cruiseDate = date('d-m-Y',strtotime($cruiseData['departureDate']));
 		?>
 		<script>
			$("#cruiseduration").val('<?php echo $cruiseData['duration']; ?>');
			$("#departureDate").val('<?php echo $cruiseDate; ?>');
		</script>
    	<?php
		exit();
	}else{
		?>
		<script>
			alert('This Cruise Package does not Exists in this travel date.');
			$("#cruiseduration").val('');
			$("#departureDate").val('');
		</script>
		<?php
		exit();
	}
}

?>