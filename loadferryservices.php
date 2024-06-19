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
	
	$wheredest='and FIND_IN_SET("'.$cityId.'",destinationId) ';
} 	 
$rsFerry=GetPageRecord('*','ferryPriceMaster',' 1 and  status=1 '.$wheredest.'  order by name asc'); 
while($ferryServiceData=mysqli_fetch_array($rsFerry)){ 
?>
<option value="<?php echo $ferryServiceData['id']; ?>"><?php echo $ferryServiceData['name']; ?></option>
<?php } ?>


<?php 
}
if($_REQUEST['action']=='getferryTime' && $_REQUEST['ferryServiceId']!=''){
$whereT = 'ferrypriceId="'.$_REQUEST['ferryServiceId'].'" and pickupTime!="" and dropTime!="" ';
	$result = GetPageRecord('*','ferryServiceTiming',$whereT);
	
	while( $ferrytimedata = mysqli_fetch_assoc($result)){
		$pickUpTime = $ferrytimedata['pickupTime'];
		$departureTime = $ferrytimedata['dropTime'];
		$pickUpTimeId = $ferrytimedata['id'];
		?>
		<option value="<?php echo $pickUpTimeId; ?>"><?php echo $departureTime; ?></option>
	<?php
	}

}





?>