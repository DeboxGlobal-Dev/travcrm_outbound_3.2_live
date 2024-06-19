<?php
include "inc.php";

if($_GET['action']=='calcPPCost' && $_GET['quotationId']!='' && $_GET['calculationType']==2){
	$quotationId = decode($_REQUEST['quotationId']);
	
	$loop = (clean($_REQUEST['loop']) == 'undefined')?0:clean($_REQUEST['loop']);
	$singleCost = (clean($_REQUEST['singleCost']) == 'undefined')?0:clean($_REQUEST['singleCost']);
	$doubleCost = (clean($_REQUEST['doubleCost']) == 'undefined')?0:clean($_REQUEST['doubleCost']);
	$tripleCost = (clean($_REQUEST['tripleCost']) == 'undefined')?0:clean($_REQUEST['tripleCost']);
	$quadCost = (clean($_REQUEST['quadCost']) == 'undefined')?0:clean($_REQUEST['quadCost']);
	$sixBedCost = (clean($_REQUEST['sixBedCost']) == 'undefined')?0:clean($_REQUEST['sixBedCost']);
	$eightBedCost = (clean($_REQUEST['eightBedCost']) == 'undefined')?0:clean($_REQUEST['eightBedCost']);
	$tenBedCost = (clean($_REQUEST['tenBedCost']) == 'undefined')?0:clean($_REQUEST['tenBedCost']);
	$teenBedCost = (clean($_REQUEST['teenBedCost']) == 'undefined')?0:clean($_REQUEST['teenBedCost']);
	$extraBedACost = (clean($_REQUEST['extraBedACost']) == 'undefined')?0:clean($_REQUEST['extraBedACost']);
	$childwithbedCost = (clean($_REQUEST['childwithbedCost']) == 'undefined')?0:clean($_REQUEST['childwithbedCost']);
	$childwithoutbedCost = (clean($_REQUEST['childwithoutbedCost']) == 'undefined')?0:clean($_REQUEST['childwithoutbedCost']);
	
	$guideA = (clean($_REQUEST['guideACost']) == 'undefined')?0:clean($_REQUEST['guideACost']);
	$activityA = (clean($_REQUEST['activityACost']) == 'undefined')?0:clean($_REQUEST['activityACost']);
	$entranceA = (clean($_REQUEST['entranceACost']) == 'undefined')?0:clean($_REQUEST['entranceACost']);
	$transferA = (clean($_REQUEST['transferACost']) == 'undefined')?0:clean($_REQUEST['transferACost']);
	$trainA = (clean($_REQUEST['trainACost']) == 'undefined')?0:clean($_REQUEST['trainACost']);
	$flightA = (clean($_REQUEST['flightACost']) == 'undefined')?0:clean($_REQUEST['flightACost']);
	$restaurantA = (clean($_REQUEST['restaurantACost']) == 'undefined')?0:clean($_REQUEST['restaurantACost']);
	$otherA = (clean($_REQUEST['otherACost']) == 'undefined')?0:clean($_REQUEST['otherACost']);
	$guideC = (clean($_REQUEST['guideCCost']) == 'undefined')?0:clean($_REQUEST['guideCCost']);
	$activityC = (clean($_REQUEST['activityCCost']) == 'undefined')?0:clean($_REQUEST['activityCCost']);
	$entranceC = (clean($_REQUEST['entranceCCost']) == 'undefined')?0:clean($_REQUEST['entranceCCost']);
	$transferC = (clean($_REQUEST['transferCCost']) == 'undefined')?0:clean($_REQUEST['transferCCost']);
	$trainC = (clean($_REQUEST['trainCCost']) == 'undefined')?0:clean($_REQUEST['trainCCost']);
	$flightC = (clean($_REQUEST['flightCCost']) == 'undefined')?0:clean($_REQUEST['flightCCost']);
	$restaurantC = (clean($_REQUEST['restaurantCCost']) == 'undefined')?0:clean($_REQUEST['restaurantCCost']);
	$otherC = (clean($_REQUEST['otherCCost']) == 'undefined')?0:clean($_REQUEST['otherCCost']);

	$landCostA = round($guideA+$activityA+$entranceA+$transferA+$trainA+$flightA+$restaurantA+$otherA);
	$landCostC = round($guideC+$activityC+$entranceC+$transferC+$trainC+$flightC+$restaurantC+$otherC);

	$singleBasis = ($singleCost>0)?($singleCost+$landCostA):0;
	$doubleBasis = ($doubleCost>0)?($doubleCost+$landCostA):0;
	$tripleBasis = ($tripleCost>0)?($tripleCost+$landCostA):0;
	$quadBasis = ($quadCost>0)?($quadCost+$landCostA):0;
	$sixBedBasis = ($sixBedCost>0)?($sixBedCost+$landCostA):0;
	$eightBedBasis = ($eightBedCost>0)?($eightBedCost+$landCostA):0;
	$tenBedBasis = ($tenBedCost>0)?($tenBedCost+$landCostA):0;
	$teenBedBasis = ($teenBedCost>0)?($teenBedCost+$landCostA):0;
	$extraBedABasis = ($extraBedACost>0)?($extraBedACost+$landCostA):0;
	$childwithbedBasis = ($childwithbedCost>0)?($childwithbedCost+$landCostC):0;
	$childwithoutbedBasis = ($childwithoutbedCost>0)?($childwithoutbedCost+$landCostC):0;


	$checkPackageRateQuery="";
	$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and loopNum="'.$loop.'"');
	if(mysqli_num_rows($checkPackageRateQuery) > 0){
		$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery); 
		$editId = $getPackageRateData['id'];

		//provisino to edit for this quotation
		$namevalue ='singleCost="'.$singleCost.'",doubleCost="'.$doubleCost.'",tripleCost="'.$tripleCost.'",extraBedACost="'.$extraBedACost.'",childwithbedCost="'.$childwithbedCost.'",guideA="'.$guideA.'",activityA="'.$activityA.'",entranceA="'.$entranceA.'",transferA="'.$transferA.'",trainA="'.$trainA.'",flightA="'.$flightA.'",restaurantA="'.$restaurantA.'",otherA="'.$otherA.'",guideC="'.$guideC.'",activityC="'.$activityC.'",entranceC="'.$entranceC.'",transferC="'.$transferC.'",trainC="'.$trainC.'",flightC="'.$flightC.'",restaurantC="'.$restaurantC.'",otherC="'.$otherC.'",singleBasis="'.$singleBasis.'",doubleBasis="'.$doubleBasis.'",tripleBasis="'.$tripleBasis.'",quadBasis="'.$quadBasis.'",sixBedBasis="'.$sixBedBasis.'",eightBedBasis="'.$eightBedBasis.'",tenBedBasis="'.$tenBedBasis.'",teenBedBasis="'.$teenBedBasis.'",extraBedABasis="'.$extraBedABasis.'",childwithbedBasis="'.$childwithbedBasis.'",childwithoutbedBasis="'.$childwithoutbedBasis.'",loopNum="'.$loop.'"';
		$where='id="'.$editId.'" and quotationId="'.$quotationId.'" and loopNum="'.$loop.'"';
		updatelisting('packageWiseRateMaster',$namevalue,$where);
	}else{
	 	//provisino to add new for this quotation
		$namevalue ='singleCost="'.$singleCost.'",doubleCost="'.$doubleCost.'",tripleCost="'.$tripleCost.'",extraBedACost="'.$extraBedACost.'",childwithbedCost="'.$childwithbedCost.'",guideA="'.$guideA.'",activityA="'.$activityA.'",entranceA="'.$entranceA.'",transferA="'.$transferA.'",trainA="'.$trainA.'",flightA="'.$flightA.'",restaurantA="'.$restaurantA.'",otherA="'.$otherA.'",guideC="'.$guideC.'",activityC="'.$activityC.'",entranceC="'.$entranceC.'",transferC="'.$transferC.'",trainC="'.$trainC.'",flightC="'.$flightC.'",restaurantC="'.$restaurantC.'",otherC="'.$otherC.'",singleBasis="'.$singleBasis.'",doubleBasis="'.$doubleBasis.'",tripleBasis="'.$tripleBasis.'",quadBasis="'.$quadBasis.'",sixBedBasis="'.$sixBedBasis.'",eightBedBasis="'.$eightBedBasis.'",tenBedBasis="'.$tenBedBasis.'",teenBedBasis="'.$teenBedBasis.'",extraBedABasis="'.$extraBedABasis.'",childwithbedBasis="'.$childwithbedBasis.'",childwithoutbedBasis="'.$childwithoutbedBasis.'",quotationId="'.$quotationId.'",loopNum="'.$loop.'"';
		$lastid = addlisting('packageWiseRateMaster',$namevalue);
	}
	// load per pax calculation

	$checkPackageRateQuery2="";
	$checkPackageRateQuery2=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
	if(mysqli_num_rows($checkPackageRateQuery2) > 0){
		$getPackageRateData2=mysqli_fetch_array($checkPackageRateQuery2); 
		$editId = $getPackageRateData2['id'];

		$editsingleBasis = clean($getPackageRateData2['singleBasis']);
		$editdoubleBasis = clean($getPackageRateData2['doubleBasis']);
		$edittripleBasis = clean($getPackageRateData2['tripleBasis']);
		$editquadBasis = clean($getPackageRateData2['quadBasis']);
		$editsixBedBasis = clean($getPackageRateData2['sixBedBasis']);
		$editeightBedBasis = clean($getPackageRateData2['eightBedBasis']);
		$edittenBedBasis = clean($getPackageRateData2['tenBedBasis']);
		$editteenBedBasis = clean($getPackageRateData2['teenBedBasis']);
		$editextraBedABasis = clean($getPackageRateData2['extraBedABasis']);
		$editchildwithbedBasis = clean($getPackageRateData2['childwithbedBasis']);
		$editchildwithoutbedBasis = clean($getPackageRateData2['childwithoutbedBasis']);
	}
	?>
	<table border="1" cellspacing="0" cellpadding="4">
		<tr>
			<th bgcolor="#ddd" >Single&nbsp;Basis</th>
			<th bgcolor="#ddd" >Double&nbsp;Basis</th>
			<th bgcolor="#ddd" >Triple&nbsp;Basis</th>
			<?php if(isRoomActive('quadroom')==true){ ?>
			<th bgcolor="#ddd" >Quad&nbsp;Basis</th>
			<?php } if(isRoomActive('sixbedroom')==true){ ?>
			<th bgcolor="#ddd" >SixBed&nbsp;Basis</th>
			<?php } if(isRoomActive('eightbedroom')==true){ ?>
			<th bgcolor="#ddd" >EightBed&nbsp;Basis</th>
			<?php } if(isRoomActive('tenbedroom')==true){ ?>
			<th bgcolor="#ddd" >TenBed&nbsp;Basis</th> 
			<?php } if(isRoomActive('teenbed')==true){ ?>
			<th bgcolor="#ddd" >TeenBed&nbsp;Basis</th> 
			<?php } ?>
			<th bgcolor="#ddd" >ExtraBed(A)</th>
			<th bgcolor="#ddd" >ExtraBed(C)</th>
			<th bgcolor="#ddd" >Childwithoutbed</th>
		</tr>
		<tr>
			<td><input type="number" name="singleBasis" id="singleBasis" value="<?php echo $editsingleBasis; ?>"></td>
			<td><input type="number" name="doubleBasis" id="doubleBasis" value="<?php echo $editdoubleBasis; ?>"></td>
			<td><input type="number" name="tripleBasis" id="tripleBasis" value="<?php echo $edittripleBasis; ?>"></td>
			<?php if(isRoomActive('quadroom')==true){ ?>
			<td><input type="number" name="quadBasis" id="quadBasis" value="<?php echo $editquadBasis; ?>"></td>
			<?php } if(isRoomActive('sixbedroom')==true){ ?>
			<td><input type="number" name="sixBedBasis" id="sixBedBasis" value="<?php echo $editsixBedBasis; ?>"></td>
			<?php } if(isRoomActive('eightbedroom')==true){ ?>
			<td><input type="number" name="eightBedBasis" id="eightBedBasis" value="<?php echo $editeightBedBasis; ?>"></td>
			<?php } if(isRoomActive('tenbedroom')==true){ ?>
			<td><input type="number" name="tenBedBasis" id="tenBedBasis" value="<?php echo $edittenBedBasis; ?>"></td> 
			<?php } if(isRoomActive('teenbed')==true){ ?>
			<td><input type="number" name="teenBedBasis" id="teenBedBasis" value="<?php echo $editteenBedBasis; ?>"></td> 
			<?php } ?>
			<td><input type="number" name="extraBedABasis" id="extraBedABasis" value="<?php echo $editextraBedABasis; ?>"></td>
			<td><input type="number" name="childwithbedBasis" id="childwithbedBasis" value="<?php echo $editchildwithbedBasis; ?>"></td>
			<td><input type="number" name="childwithoutbedBasis" id="childwithoutbedBasis" value="<?php echo $editchildwithoutbedBasis; ?>"></td>
		</tr>
	</table>
	<?php

}

if($_GET['action']=='cp_PPCost' && $_GET['quotationId']!=''  && $_GET['supplierId']!=''  && $_GET['currencyId']!='' && $_GET['calculationType']==3){

	$quotationId = decode($_REQUEST['quotationId']);

	$rs='';   
	$rs=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'"');  
	$quotationData=mysqli_fetch_array($rs); 

	$supplierId = trim($_REQUEST['supplierId']);

	$update = updatelisting(_QUOTATION_MASTER_,'packageSupplier="'.$supplierId.'"','id="'.$quotationId.'"');
	$update = updatelisting(_QUERY_MASTER_,'packageSupplier="'.$supplierId.'"','id="'.$quotationData['queryId'].'"');

	$editId = trim($_REQUEST['editId']);
	$currencyId = trim($_REQUEST['currencyId']);
	$currencyValue = getCurrencyval($currencyId);

	$singleBasis = (clean($_REQUEST['singleBasis']) == 'undefined')?0:clean($_REQUEST['singleBasis']);
	$doubleBasis = (clean($_REQUEST['doubleBasis']) == 'undefined')?0:clean($_REQUEST['doubleBasis']);
	$twinBasis = (clean($_REQUEST['twinBasis']) == 'undefined')?0:clean($_REQUEST['twinBasis']);
	$tripleBasis = (clean($_REQUEST['tripleBasis']) == 'undefined')?0:clean($_REQUEST['tripleBasis']);

	$quadBasis = (clean($_REQUEST['quadBasis']) == 'undefined')?0:clean($_REQUEST['quadBasis']);
	$sixBedBasis = (clean($_REQUEST['sixBedBasis']) == 'undefined')?0:clean($_REQUEST['sixBedBasis']);
	$eightBedBasis = (clean($_REQUEST['eightBedBasis']) == 'undefined')?0:clean($_REQUEST['eightBedBasis']);
	$tenBedBasis = (clean($_REQUEST['tenBedBasis']) == 'undefined')?0:clean($_REQUEST['tenBedBasis']);
	$teenBedBasis = (clean($_REQUEST['teenBedBasis']) == 'undefined')?0:clean($_REQUEST['teenBedBasis']);

	$extraBedABasis = (clean($_REQUEST['extraBedABasis']) == 'undefined')?0:clean($_REQUEST['extraBedABasis']);
	$childwithbedBasis = (clean($_REQUEST['childwithbedBasis']) == 'undefined')?0:clean($_REQUEST['childwithbedBasis']);
	$childwithoutbedBasis = (clean($_REQUEST['childwithoutbedBasis']) == 'undefined')?0:clean($_REQUEST['childwithoutbedBasis']);   
	$infantBasisCost = (clean($_REQUEST['infantBasisCost']) == 'undefined')?0:clean($_REQUEST['infantBasisCost']);   
	$hotelTypeId = (clean($_REQUEST['hotelTypeId']) == 'undefined')?0:clean($_REQUEST['hotelTypeId']);   
	$hotelCategoryId = (clean($_REQUEST['hotelCategoryId']) == 'undefined')?0:clean($_REQUEST['hotelCategoryId']);   
	
	$loop = (clean($_REQUEST['loop']) == 'undefined')?0:clean($_REQUEST['loop']);
	$loopNum = (clean($_REQUEST['loopNum']) == 'undefined')?'no':clean($_REQUEST['loopNum']);

	$serviceTypeID = (clean($_REQUEST['serviceTypeID']) == 'undefined')?0:clean($_REQUEST['serviceTypeID']);
	$serviceName = (clean($_REQUEST['serviceName']) == 'undefined')?'':clean($_REQUEST['serviceName']);
	$markupType = (clean($_REQUEST['markupType']) == 'undefined')?0:clean($_REQUEST['markupType']);
	$markupValue = (clean($_REQUEST['markupValue']) == 'undefined')?0:clean($_REQUEST['markupValue']);
	$serviceTax = (clean($_REQUEST['serviceTax']) == 'undefined')?0:clean(getGstValueById($_REQUEST['serviceTax']));
	$gstTax = (clean($_REQUEST['serviceTax']) == 'undefined')?0:clean($_REQUEST['serviceTax']);
	$currencyIdVal = (clean($_REQUEST['currencyIdVal']) == 'undefined')?0:clean($_REQUEST['currencyIdVal']);
	$costTypeId = (clean($_REQUEST['costTypeId']) == 'undefined')?0:clean($_REQUEST['costTypeId']);
	if($costTypeId==1){
	$adultCost = (clean($_REQUEST['adultCost']) == 'undefined')?0:clean($_REQUEST['adultCost']);
	$adultPax = (clean($_REQUEST['adultPax']) == 'undefined')?0:clean($_REQUEST['adultPax']);
	$ChildCost = (clean($_REQUEST['ChildCost']) == 'undefined')?0:clean($_REQUEST['ChildCost']);
	$ChildPax = (clean($_REQUEST['ChildPax']) == 'undefined')?0:clean($_REQUEST['ChildPax']);
	$infantCost = (clean($_REQUEST['infantCost']) == 'undefined')?0:clean($_REQUEST['infantCost']);
	$infantPax = (clean($_REQUEST['infantPax']) == 'undefined')?0:clean($_REQUEST['infantPax']);
	$groupCost = '';
	}else{
		$adultCost = '';
		
		$ChildCost = '';
		$ChildPax = '';
		$infantCost = '';
		$infantPax = '';
		$groupCost = (clean($_REQUEST['groupCost']) == 'undefined')?0:clean($_REQUEST['groupCost']);
		$adultPax = (clean($_REQUEST['groupPax']) == 'undefined')?0:clean($_REQUEST['groupPax']);
	}
	
	

	if($editId>0){
		//provisino to edit for this quotation
		$namevalue ='supplierId="'.$supplierId.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",singleBasis="'.$singleBasis.'",doubleBasis="'.$doubleBasis.'",twinBasis="'.$twinBasis.'",tripleBasis="'.$tripleBasis.'",quadBasis="'.$quadBasis.'",sixBedBasis="'.$sixBedBasis.'",eightBedBasis="'.$eightBedBasis.'",tenBedBasis="'.$tenBedBasis.'",teenBedBasis="'.$teenBedBasis.'",extraBedABasis="'.$extraBedABasis.'",childwithbedBasis="'.$childwithbedBasis.'",childwithoutbedBasis="'.$childwithoutbedBasis.'",infantBedBasis="'.$infantBasisCost.'",hotelCategoryId="'.$hotelCategoryId.'",hotelTypeId="'.$hotelTypeId.'",serviceType="'.$serviceTypeID.'",serviceName="'.$serviceName.'",markupType="'.$markupType.'",markupValue="'.$markupValue.'",serviceTax="'.$serviceTax.'",ROE="'.$currencyIdVal.'",costTypeId="'.$costTypeId.'",adultCost="'.$adultCost.'",adultPax="'.$adultPax.'",ChildCost="'.$ChildCost.'",ChildPax="'.$ChildPax.'",infantCost="'.$infantCost.'",infantPax="'.$infantPax.'",groupCost="'.$groupCost.'",gstTax="'.$gstTax.'",queryId="'.$quotationData['queryId'].'"';
		
		$where='id="'.$editId.'" and quotationId="'.$quotationId.'"';
		updatelisting('packageWiseRateMaster',$namevalue,$where);
		?>
		<script>
			parent.loadPackageRates('loadCompletePackageWiseRates')
			warningalert('Package Rate Updated');
			parent.closeinbound();
		</script>
		<?php
	}else{
	 	//provisino to add new for this quotation
		$namevalue ='supplierId="'.$supplierId.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",singleBasis="'.$singleBasis.'",doubleBasis="'.$doubleBasis.'",twinBasis="'.$twinBasis.'",tripleBasis="'.$tripleBasis.'",quadBasis="'.$quadBasis.'",sixBedBasis="'.$sixBedBasis.'",eightBedBasis="'.$eightBedBasis.'",tenBedBasis="'.$tenBedBasis.'",teenBedBasis="'.$teenBedBasis.'",extraBedABasis="'.$extraBedABasis.'",childwithbedBasis="'.$childwithbedBasis.'",childwithoutbedBasis="'.$childwithoutbedBasis.'",infantBedBasis="'.$infantBasisCost.'",quotationId="'.$quotationId.'",loopNum="'.$loop.'",hotelCategoryId="'.$hotelCategoryId.'",hotelTypeId="'.$hotelTypeId.'",serviceType="'.$serviceTypeID.'",serviceName="'.$serviceName.'",markupType="'.$markupType.'",markupValue="'.$markupValue.'",serviceTax="'.$serviceTax.'",ROE="'.$currencyIdVal.'",costTypeId="'.$costTypeId.'",adultCost="'.$adultCost.'",adultPax="'.$adultPax.'",ChildCost="'.$ChildCost.'",ChildPax="'.$ChildPax.'",infantCost="'.$infantCost.'",infantPax="'.$infantPax.'",groupCost="'.$groupCost.'",gstTax="'.$gstTax.'",queryId="'.$quotationData['queryId'].'"';
		
		addlisting('packageWiseRateMaster',$namevalue);
		?>
		<script>
			parent.loadPackageRates('loadCompletePackageWiseRates')
			warningalert('Package Rate Added');
		</script>
		<?php
}
}
