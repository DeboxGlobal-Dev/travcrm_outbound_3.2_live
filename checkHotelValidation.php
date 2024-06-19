<?php
include "inc.php";   
 if($_REQUEST['quotationType']==2){
	$hotCategory = explode(',',$_REQUEST['hotCategory']); 
	foreach($hotCategory as $val){
		$msg='';
		 //echo ' id in (select serviceId from quotationItinerary where quotationId="'.$quotationData['id'].'" and queryId="'.$quotationData['queryId'].'" and startDate="'.$dayDate.'" ) and quotationId="'.decode($_GET['id']).'" and categoryId="'.$val.'" order by id asc';
		$wc=GetPageRecord('id','quotationHotelMaster',' id in (select serviceId from quotationItinerary where quotationId="'.$_REQUEST['quotationId'].'" and queryId="'.$_REQUEST['queryId'].'" and startDate="'.$_REQUEST['startDate'].'" ) and quotationId="'.$_REQUEST['quotationId'].'" and categoryId="'.$val.'" order by id asc');  
		if(mysqli_num_rows($wc)<1){
			echo $msg='Please select '.$val.' star hotel in day '.$day;
			?>
			<script>
			function multHotCatValidateionFun(){
				alert('<?php echo $msg; ?>');
				return false;
			}
			</script>
			<?php 
		}
		//multHotCatValidateionFun
	}
}
?>