<?php
include "inc.php"; 

if(trim($_REQUEST['action'])=='savesaveSupplimentdata' && trim($_REQUEST['destId'])!='' && trim($_REQUEST['serviceType'])!='' && trim($_REQUEST['quotationId'])!='' && trim($_REQUEST['id'])!='' && trim($_REQUEST['isAddExp'])!=''){	
	
	if($_REQUEST['serviceType']==1){

		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 
		if($_REQUEST['tableN']==2){
			$rs11=GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['id'].'" and quotationId="'.$quotationId.'" and serviceType="Activity"');
			$table=2;
			$quoterateData=mysqli_fetch_array($rs11);
			$supplierId = $quoterateData['supplierId'];
			$currencyId = $quoterateData['currencyId'];
			$activityCost = $quoterateData['serviceCost'];
			$maxpax = $quoterateData['maxpax'];
			$perPaxCost = $quoterateData['perPaxCost'];
			$activityNameId = $quoterateData['serviceId'];
			$editId  = $quoterateData['id'];
			$rateId  = $quoterateData['id'];
		}elseif($_REQUEST['tableN']==1){
			$rs11=GetPageRecord('*','dmcotherActivityRate',' id="'.$_REQUEST['id'].'"  and status=1 order by maxpax asc'); 
			$quoterateData=mysqli_fetch_array($rs11); 

				$table=1;
				$supplierId = $quoterateData['supplierId'];
				$currencyId = $quoterateData['currencyId'];
				$activityCost = $quoterateData['activityCost'];
				$maxpax = $quoterateData['maxpax'];
				$perPaxCost = $quoterateData['perPaxCost'];
				$activityNameId = $quoterateData['otherActivityNameId'];
				$rateId  = $quoterateData['id'];
			}
		
			$namevalue ='additionalId="'.$_REQUEST['id'].'",rateId="'.$_REQUEST['id'].'",serviceId="'.$activityNameId.'",adultCost="'.$perPaxCost.'",serviceCost="'.$activityCost.'",childCost="0",quotationId="'.$quotationId.'",serviceType="Activity",destinationId="'.trim($_REQUEST['destId']).'",gstTax="'.$quoterateData['gstTax'].'",currencyValue="'.$quoterateData['currencyValue'].'",maxpax="'.$quoterateData['maxpax'].'",slabId="'.$quoterateData['slabId'].'",remarks="'.$quoterateData['remarks'].'",currencyId="'.$currencyId.'",supplierId="'.$dmcroommastermain['supplierId'].'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);

		?>
		<script> 
		parent.loadAddtionalDatafun();
		</script>
		<?php
	
	}
	
	
	if($_REQUEST['serviceType']==2){

		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,'isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 

		if($_REQUEST['tableN']==2){
			$rs11=GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['id'].'" and quotationId="'.$quotationId.'" and serviceType="Guide"');
			$dmcroommastermain=mysqli_fetch_array($rs11);
			$currencyId = $dmcroommastermain['currencyId'];
			$guideCost = $dmcroommastermain['serviceCost'];
			$guideId = $dmcroommastermain['serviceId'];
		}elseif($_REQUEST['tableN']==1){
			$rs11=GetPageRecord('*','dmcGuidePorterRate',' id="'.$_REQUEST['id'].'" order by id asc'); 
			$dmcroommastermain=mysqli_fetch_array($rs11);
			$currencyId = $dmcroommastermain['currencyId'];
			$guideCost = $dmcroommastermain['price'];
			$guideId = $dmcroommastermain['serviceid'];
		}


			$namevalue ='rateId="'.$_REQUEST['id'].'",adultCost="'.$guideCost.'",childCost="0",quotationId="'.$quotationId.'",serviceType="Guide",destinationId="'.trim($_REQUEST['destId']).'",serviceId="'.$guideId.'",currencyId="'.$currencyId.'",currencyValue="'.$dmcroommastermain['currencyValue'].'",gstTax="'.$dmcroommastermain['gstTax'].'",languageAllowance="'.$dmcroommastermain['languageAllowance'].'",otherCost="'.$dmcroommastermain['otherCost'].'",paxRange="'.$dmcroommastermain['paxRange'].'",dayType="'.$dmcroommastermain['dayType'].'",universalCost="'.$dmcroommastermain['universalCost'].'",toDate="'.$dmcroommastermain['toDate'].'",fromDate="'.$dmcroommastermain['fromDate'].'",remarks="'.$dmcroommastermain['remarks'].'",supplierId="'.$dmcroommastermain['supplierId'].'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);
	
		?>
		<script> 
		parent.loadAddtionalDatafun();
		</script>
		<?php
	
	}
	
	if($_REQUEST['serviceType']==3){
		
		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 
		 
		$rs11=GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' id="'.$_REQUEST['id'].'" order by id asc'); 
		$dmcroommastermain=mysqli_fetch_array($rs11); 

		if($_REQUEST['tableN']==2){
			$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['id'].'" and serviceType="Entrance"');
			$quoterateData = mysqli_fetch_assoc($rs1);

			$currencyId = $quoterateData['currencyId'];
			$ticketAdultCost = $quoterateData['adultCost'];
			$ticketchildCost = $quoterateData['childCost'];
			// $perPaxCost = $quoterateData['perPaxCost'];
			$entranceNameId = $quoterateData['serviceId'];
	
		}

		if($_REQUEST['tableN']==1){
			$rs1 = GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,'id="'.$_REQUEST['id'].'"');
			$quoterateData = mysqli_fetch_assoc($rs1);

			$currencyId = $quoterateData['currencyId'];
			$ticketAdultCost = $quoterateData['ticketAdultCost'];
			$ticketchildCost = $quoterateData['ticketchildCost'];
			// $perPaxCost = $quoterateData['perPaxCost'];
			$entranceNameId = $quoterateData['entranceNameId'];
		}
			$namevalue ='rateId="'.$_REQUEST['id'].'",adultCost="'.$ticketAdultCost.'",childCost="'.$ticketchildCost.'",quotationId="'.$quotationId.'",serviceType="Entrance",destinationId="'.trim($_REQUEST['destId']).'",serviceId="'.$entranceNameId.'",gstTax="'.$quoterateData['gstTax'].'",currencyValue="'.$quoterateData['currencyValue'].'",tariffType="'.$quoterateData['tariffType'].'",currencyId="'.$quoterateData['currencyId'].'",adultPax="'.$quoterateData['adultPax'].'",childPax="'.$quoterateData['childPax'].'",supplierId="'.$quoterateData['supplierId'].'",remarks="'.$quoterateData['remarks'].'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);

		?>
		<script> 
			parent.loadAddtionalDatafun();
		</script>
		<?php
		
	}


	if($_REQUEST['serviceType']==4){

		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 


		if($_REQUEST['tableN']==2){
			$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['id'].'" and serviceType="Restaurant"');
			$quoterateData = mysqli_fetch_assoc($rs1);

			$currencyId = $quoterateData['currencyId'];
			$adultCost = $quoterateData['adultCost'];
			$childCost = $quoterateData['childCost'];
			// $perPaxCost = $quoterateData['perPaxCost'];
			$restaurantId = $quoterateData['serviceId'];
		}

		if($_REQUEST['tableN']==1){
			$rs1 = GetPageRecord('*','dmcRestaurantsMealPlanRate','id="'.$_REQUEST['id'].'"');
			$quoterateData = mysqli_fetch_assoc($rs1);

			$currencyId = $quoterateData['currencyId'];
			$adultCost = $quoterateData['adultCost'];
			$childCost = $quoterateData['childCost'];
			// $perPaxCost = $quoterateData['perPaxCost'];
			$restaurantId = $quoterateData['restaurantId'];
		}


			$namevalue ='rateId="'.$_REQUEST['id'].'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",quotationId="'.$quotationId.'",serviceType="Restaurant",destinationId="'.trim($_REQUEST['destId']).'",serviceId="'.$restaurantId.'",gstTax="'.$quoterateData['gstTax'].'",currencyValue="'.$quoterateData['currencyValue'].'",tariffType="'.$quoterateData['tariffType'].'",currencyId="'.$quoterateData['currencyId'].'",adultPax="'.$quoterateData['adultPax'].'",childPax="'.$quoterateData['childPax'].'",supplierId="'.$quoterateData['supplierId'].'",remarks="'.$quoterateData['remarks'].'",mealType="'.$quoterateData['mealType'].'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);

		?>
		<script> 
		parent.loadAddtionalDatafun();
		</script>
		<?php
	
	}
	if($_REQUEST['serviceType']==5){

		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 

		if($_REQUEST['tableN']==2){
			$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['id'].'" and serviceType="Additional"');
			$quoterateData = mysqli_fetch_assoc($rs1);
			$table=2;
			$currencyId = $quoterateData['currencyId'];
			$adultCost = $quoterateData['adultCost'];
			$childCost = $quoterateData['childCost'];
			$groupCost = $quoterateData['groupCost'];
			$costType = $quoterateData['costType'];
			$serviceId = $quoterateData['serviceId'];
			$editId  = $quoterateData['id'];
	
		}

		if($_REQUEST['tableN']==1){
			$rs1 = GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,'id="'.$_REQUEST['id'].'"');
			$quoterateData = mysqli_fetch_assoc($rs1);

			$table=1;
			$currencyId = $quoterateData['currencyId'];
			$adultCost = $quoterateData['adultCost'];
			$childCost = $quoterateData['childCost'];
			$groupCost = $quoterateData['groupCost'];
			$costType = $quoterateData['costType'];
			$serviceId = $quoterateData['id'];
		}

	
			$namevalue ='rateId="'.$_REQUEST['id'].'",groupCost="'.round($groupCost).'",adultCost="'.($adultCost).'",childCost="'.($childCost).'",quotationId="'.$quotationId.'",serviceType="Additional",destinationId="'.trim($_REQUEST['destId']).'",costType="'.$costType.'",serviceId="'.$serviceId.'",gstTax="'.$quoterateData['gstTax'].'",currencyValue="'.$quoterateData['currencyValue'].'",tariffType="'.$quoterateData['tariffType'].'",currencyId="'.$quoterateData['currencyId'].'",adultPax="'.$quoterateData['adultPax'].'",childPax="'.$quoterateData['childPax'].'",supplierId="'.$quoterateData['supplierId'].'",remarks="'.$quoterateData['remarks'].'",mealType="'.$quoterateData['mealType'].'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);

		?>
		<script> 
		parent.loadAddtionalDatafun();
		</script>
		<?php
	
	}

}

if(trim($_REQUEST['action'])=='saveNewSupplimentdata' && trim($_REQUEST['destId'])!='' && trim($_REQUEST['serviceType'])!='' && trim($_REQUEST['quotationId'])!='' && trim($_REQUEST['isAddExp'])!='' && trim($_REQUEST['entranceId'])!=''){	
	
	if($_REQUEST['serviceType']==3){
		
		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 
		
			$namevalue ='adultCost="'.round($_REQUEST['adultCost']).'",childCost="'.round($_REQUEST['childCost']).'",quotationId="'.$quotationId.'",serviceType="Entrance",destinationId="'.trim($_REQUEST['destId']).'",entranceId="'.trim($_REQUEST['entranceId']).'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);
		?>
		<script> 
			parent.loadAddtionalDatafun();
		</script>
		<?php
	
	}
}

if(trim($_REQUEST['action'])=='savesaveSupplimentdataNull' && trim($_REQUEST['destId'])!='' && trim($_REQUEST['serviceType'])!='' && trim($_REQUEST['quotationId'])!='' && trim($_REQUEST['activityId'])!='' && trim($_REQUEST['isAddExp'])!=''){	
	
	if($_REQUEST['serviceType']==1){
		
		$quotationId=clean(decode($_REQUEST['quotationId']));
		$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"'); 
		 
		$quotationQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');
		$quotationData = mysqli_fetch_array($quotationQuery);

		$marketTypeId = getQueryMaketType($quotationData['queryId']);
		if($marketTypeId < 1){
			$marketTypeId = 1;
		}
		
		$fromDate = date('Y-m-d',strtotime($quotationData['fromDate']));
		$toDate = date('Y-m-d',strtotime($quotationData['toDate']));
		
		$namevalue ='supplierId="'.$_REQUEST['supplierId'].'",activityCost="'.$_REQUEST['activityCost'].'",perPaxCost="'.$_REQUEST['perPaxCost'].'",maxpax="'.$_REQUEST['maxPax'].'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",marketType="'.$marketTypeId.'",otherActivityNameId="'.$_REQUEST['activityId'].'",status="1",addBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",currencyId="1",serviceid="'.$_REQUEST['activityId'].'"';
		$tariffId = addlistinggetlastid('dmcotherActivityRate',$namevalue);
		
		$rs11=GetPageRecord('*','dmcotherActivityRate',' id="'.$tariffId.'" and status=1 order by maxpax asc'); 
		$dmcroommastermain=mysqli_fetch_array($rs11); 
		 
		$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and additionalId="'.$_REQUEST['activityId'].'" and adultCost="'.round($dmcroommastermain['perPaxCost']).'" and childCost=0 and serviceType="Activity" and destinationId="'.trim($_REQUEST['destId']).'"'); 
		// if( mysqli_num_rows($c12) > 0){
		// 	$namevalue ='additionalId="'.$_REQUEST['activityId'].'",adultCost="'.round($dmcroommastermain['perPaxCost']).'",childCost="0",quotationId="'.$quotationId.'",serviceType="Activity",destinationId="'.trim($_REQUEST['destId']).'"';  	
		// 	$update = updatelisting('quotationAdditionalMaster',$namevalue); 
		// }else{
			$namevalue ='additionalId="'.$_REQUEST['activityId'].'",adultCost="'.round($dmcroommastermain['perPaxCost']).'",childCost="0",quotationId="'.$quotationId.'",serviceType="Activity",destinationId="'.trim($_REQUEST['destId']).'"';
			$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);
		// }
		?>
		<script> 
			parent.loadAddtionalDatafun();
		</script>
		<?php
	
	}
}


?>
