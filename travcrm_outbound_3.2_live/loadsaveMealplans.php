<?php
include "inc.php"; 
include "config/logincheck.php";  
if($_REQUEST['mealPlanId']!='' && $_REQUEST['action'] == 'loadmealCost' ){
	$select1='*';  
	echo $where1='restaurantId="'.$_REQUEST['mealPlanId'].'" and mealPlanId="'.$_REQUEST['mealType'].'"'; 
	$rs1=GetPageRecord($select1,'dmcRestaurantsMealPlanRate',$where1); 
	$sighseeinginfo=mysqli_fetch_array($rs1);

	$adultCost =  getCostWithGST($sighseeinginfo['adultCost'],getGstValueById($sighseeinginfo['RestaurantGST']),0);
	$childCost =  getCostWithGST($sighseeinginfo['childCost'],getGstValueById($sighseeinginfo['RestaurantGST']),0);
	$infantCost =  getCostWithGST($sighseeinginfo['infantCost'],getGstValueById($sighseeinginfo['RestaurantGST']),0);
 	   
 
	$adultCost=addslashes(round($adultCost));    
	$childCost=addslashes(round($childCost));    
	$infantCost=addslashes(round($infantCost));    
	   
	?> 
	<script type="text/javascript">
		parent.$('#mealPlanadultCost').val(<?php echo $adultCost; ?>);
		parent.$('#mealPlanchildCost').val(<?php echo $childCost; ?>);
		parent.$('#mealPlaninfantCost').val(<?php echo $infantCost; ?>);
	</script>
	<?php	
}


// load meal plans and addedit
if($_REQUEST['action'] =='addedit_QuotationMeals'){
 
	// addedit quotation mealplans
	if($_REQUEST['add']=='yes'){ 
		$dayId = $_REQUEST['dayId'];   

		$rs1=GetPageRecord(' * ','newQuotationDays','id="'.$dayId.'"'); 
		$newQuoteData = mysqli_fetch_array($rs1);  

		$queryId = $newQuoteData['queryId'];
		$quotationId = $newQuoteData['quotationId'];
		$cityId = getDestination($newQuoteData['cityId']);

		$date=date('Y-m-d',strtotime($newQuoteData['srdate']));
  
		$mealPlanId = $_REQUEST['mealPlanName'];  
		
		$select1='*';  
		$where1='id="'.$mealPlanId.'"'; 
		$rs1=GetPageRecord($select1,_INBOUND_MEALPLAN_MASTER_,$where1); 
		$sighseeinginfo=mysqli_fetch_array($rs1);
		 
		$mealPlanName=addslashes($sighseeinginfo['mealPlanName']); 
		$groupCost=addslashes($sighseeinginfo['groupCost']); 
		 
		$mealType=addslashes($_REQUEST['mealPlanmealType']); 
		$adultCost=addslashes($_REQUEST['mealPlanadultCost']);    
		$childCost=addslashes($_REQUEST['mealPlanchildCost']); 
		$infantCost=addslashes($_REQUEST['mealPlaninfantCost']); 
		$currencyId=addslashes($_REQUEST['currencyId']);  
		 
	 
		$namevalue ='adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",mealType="'.$mealType.'",mealPlanName="'.$mealPlanName.'",mealPlanNameId="'.$mealPlanId.'",destinationId="'.$newQuoteData['cityId'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",groupCost="'.$groupCost.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"'; 
		$lastid = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue); 
		  
		 
		$namevalue1 ='serviceId="'.$lastid.'",serviceType="mealplan", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
		addlisting('quotationItinerary',$namevalue1); 

		  
		?> 
		<script> 
			closeinbound();
			loadquotationmainfile(); 
		</script> 
		<?php
		 
	}  
} 

if(trim($_REQUEST['action'])=='addedit_newQuotationMeals' && trim($_REQUEST['newmealPlanName'])!=''){
	// addedit quotation mealplans   

		// $rs1=GetPageRecord(' * ','newQuotationDays','id="'.$dayId.'"'); 
		// $newQuoteData = mysqli_fetch_array($rs1);  

		$dayId = $_REQUEST['dayId'];
		$quotationId = $newQuoteData['quotationId']; 
		$cityId = getDestination($newQuoteData['cityId']);

		$date=date('Y-m-d',strtotime($newQuoteData['srdate']));
  
		$newmealPlanName = $_REQUEST['newmealPlanName'];  
		  
		$mealPlanmealType=addslashes($_REQUEST['mealPlanmealType']); 
		$mealPlanadultCost=addslashes($_REQUEST['mealPlanadultCost']);    
		$mealPlanchildCost=addslashes($_REQUEST['mealPlanchildCost']); 
		$mealPlaninfantCost=addslashes($_REQUEST['mealPlaninfantCost']); 
		$currencyId=addslashes($_REQUEST['currencyId']);  
		$mealPlanCity=addslashes($_REQUEST['mealPlanCity']);  
		$destinationId=addslashes($_REQUEST['destinationId']);  

		
		$res1=GetPageRecord('id','inboundmealplanmaster','mealPlanName="'.$newmealPlanName.'"'); 
		if(mysqli_fetch_array($res1)<1){

		$namevalue ='adultCost="'.$mealPlanadultCost.'",childCost="'.$mealPlanchildCost.'",infantCost="'.$mealPlaninfantCost.'",mealPlanType="'.$mealPlanmealType.'",mealPlanName="'.$newmealPlanName.'",mealPlanCity="'.$mealPlanCity.'",destinationId="'.$destinationId.'",currencyId="'.$currencyId.'",status=1'; 
		$lastid = addlistinggetlastid(_INBOUND_MEALPLAN_MASTER_,$namevalue);   
		

		$namevalue22 ='adultCost="'.$mealPlanadultCost.'",childCost="'.$mealPlanchildCost.'",infantCost="'.$mealPlaninfantCost.'",currencyId="'.$currencyId.'",restaurantId="'.$lastid.'",mealPlanId="'.$mealPlanmealType.'",RestaurantGST="'.$RestaurantGST.'",status="1"'; 
		$lastid2 = addlistinggetlastid('dmcRestaurantsMealPlanRate',$namevalue22);
	
		?> 
		<script> 
		parent.openinboundpop('action=addServiceMealPlan&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $fromDate; ?>&additionalId=<?php echo $lastid2; ?>','800px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
		</script> 
		<?php	
		}else{
			?>
			<script> 
			parent.alert('This restuarant already exist !!');
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			</script>  
			<?php 
		}




		 
	}