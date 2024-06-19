<?php
include "inc.php";  
if($_REQUEST['stype']=='roomSupplement' && isset($_REQUEST['hotelQuoteId']) ){
	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
	$hotelQuotData=mysqli_fetch_array($c);
	$roomTariffId = $hotelQuotData['roomTariffId'];
	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
	$hotelData=mysqli_fetch_array($d);  

	$rs232='';
	$rs232=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"'); 
	$hotelCatD=mysqli_fetch_array($rs232);
 
    $quores=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" ');  
	$quotationData=mysqli_fetch_array($quores); 
	
	$calculationType = $quotationData['calculationType'];
	$quotationId = $quotationData['id'];
	
	$qsQuery=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');  
	$queryData=mysqli_fetch_array($qsQuery);

	$roomTariffId = 0;
    
    $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
    $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationData['id'] . '" and status=1 order by fromRange asc');
    if (mysqli_num_rows($groupSlabPPSql)>0 && $queryData['moduleType'] == 4) {         
        $groupSlabPPD = mysqli_fetch_array($groupSlabPPSql);
          
        $singleRoom = $groupSlabPPD['sglRoom'];
    	$doubleRoom = $groupSlabPPD['dblRoom'];
    	$twinRoom   = $groupSlabPPD['twinRoom'];
    	$tplRoom = $groupSlabPPD['tplRoom']; 
    	$sixNoofBedRoom = $groupSlabPPD['sixNoofBedRoom'];
    	$eightNoofBedRoom = $groupSlabPPD['eightNoofBedRoom'];
    	$tenNoofBedRoom = $groupSlabPPD['tenNoofBedRoom'];
    	$quadNoofRoom = $groupSlabPPD['quadNoofRoom'];
    	$teenNoofRoom = $groupSlabPPD['teenNoofRoom'];
    	
    	$EBedCRoom = $groupSlabPPD['childwithNoofBed'];
    	$childwithoutNoofBed = $groupSlabPPD['childwithoutNoofBed'];
    	$EBedA = $groupSlabPPD['extraNoofBed'];
    	
    }else{
        $singleRoom = $quotationData['sglRoom'];
    	$doubleRoom = $quotationData['dblRoom'];
    	$twinRoom   = $quotationData['twinRoom'];
    	$tplRoom = $quotationData['tplRoom']; 
    	$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
    	$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
    	$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
    	$quadNoofRoom = $quotationData['quadNoofRoom'];
    	$teenNoofRoom = $quotationData['teenNoofRoom'];
    	
    	$EBedCRoom = $quotationData['childwithNoofBed'];
    	$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
    	$EBedA = $quotationData['extraNoofBed'];
    }
    
	$startDayId = $hotelQuotData['dayId'];
	$startDate = $hotelQuotData['fromDate'];

	$endDayId = $hotelQuotData['dayId'];
	$cityId=$hotelQuotData['destinationId']; 
	$cityName = getDestination($cityId);

	$mealPlan = $hotelQuotData['mealPlan']; 

	$queryId = trim($quotationData['queryId']);
	$quotationId = trim($quotationData['id']);  

	$fromDate=date("Y-m-d", strtotime($startDate));
	if($_REQUEST['earlyCheckin'] == 1){
		$fromDate = date("Y-m-d", strtotime("-1 days", strtotime($fromDate)));
	}

	$date = $fromDate;
	$fromYear=date("Y", strtotime($startDate));
	$toDate=date("Y-m-d", strtotime($startDate)); 
	$toYear=date("Y", strtotime($startDate));
		
		$rs1='';
	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
	$queryData = mysqli_fetch_array($rs1);
 	
 	// search hotel queyr
	$whereSTR="";
	$whereSTR.=' and id = "'.$hotelQuotData['supplierId'].'"'; 

	// search roomType query 
	$roomTypeQuery = '';
	// search mealplan query 
	$mealPlanQuery = ' and id!="'.$roomTariffId.'"';


	// fit git query
 	$fit_gitQuery = ""; 
	if($queryData['paxType']==1 || $queryData['paxType']==2){
		$fit_gitQuery = " and paxType='".$queryData['paxType']."' ";
	}else{
		$fit_gitQuery = " and paxType=2 ";
	}

	// season query
	$seasonQuery = ""; 
	if($queryData['dayWise'] == 2){
		if($queryData['seasonType']!= 3 ){
			$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
		}else{
			$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and  YEAR(fromDate) ='".$queryData['seasonYear']."'";
		}
	}else{
		$seasonQuery = " and DATE(fromDate) <= '".$fromDate."' and  DATE(toDate) >= '".$toDate."'";
	}	


	// market query 
	$marketId = getQueryMaketType($queryId);
	$whereMarket = '  ';
	if($marketId>0){
		$whereMarket = ' and marketType="'.$marketId.'"';
	}

	$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 

}else{
	$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');   
	$startDayData=mysqli_fetch_array($startDayQuery); 

	$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');   
	$endDayData=mysqli_fetch_array($endDayQuery); 

	$quores=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" ');  
	$quotationData=mysqli_fetch_array($quores); 
	
	$calculationType = $quotationData['calculationType'];
	$quotationId = $quotationData['id'];
	
	$qsQuery=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');  
	$queryData=mysqli_fetch_array($qsQuery);

	$roomTariffId = 0;
    
    $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
    $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationData['id'] . '" and status=1 order by fromRange asc');
    if (mysqli_num_rows($groupSlabPPSql)>0 && $queryData['moduleType'] == 4) {         
        $groupSlabPPD = mysqli_fetch_array($groupSlabPPSql);
          
        $singleRoom = $groupSlabPPD['sglRoom'];
    	$doubleRoom = $groupSlabPPD['dblRoom'];
    	$twinRoom   = $groupSlabPPD['twinRoom'];
    	$tplRoom = $groupSlabPPD['tplRoom']; 
    	$sixNoofBedRoom = $groupSlabPPD['sixNoofBedRoom'];
    	$eightNoofBedRoom = $groupSlabPPD['eightNoofBedRoom'];
    	$tenNoofBedRoom = $groupSlabPPD['tenNoofBedRoom'];
    	$quadNoofRoom = $groupSlabPPD['quadNoofRoom'];
    	$teenNoofRoom = $groupSlabPPD['teenNoofRoom'];
    	
    	$EBedCRoom = $groupSlabPPD['childwithNoofBed'];
    	$childwithoutNoofBed = $groupSlabPPD['childwithoutNoofBed'];
    	$EBedA = $groupSlabPPD['extraNoofBed'];
    	
    }else{
        $singleRoom = $quotationData['sglRoom'];
    	$doubleRoom = $quotationData['dblRoom'];
    	$twinRoom   = $quotationData['twinRoom'];
    	$tplRoom = $quotationData['tplRoom']; 
    	$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
    	$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
    	$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
    	$quadNoofRoom = $quotationData['quadNoofRoom'];
    	$teenNoofRoom = $quotationData['teenNoofRoom'];
    	
    	$EBedCRoom = $quotationData['childwithNoofBed'];
    	$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
    	$EBedA = $quotationData['extraNoofBed'];
    }



	$startDayId = $startDayData['id'];
	$startDate = $startDayData['srdate'];
	// $endDayId = $endDayData['id'];
	$destWise=$_REQUEST['destWise']; 
	if($destWise!=2){
		$cityId=$startDayData['cityId']; 
	}else{
		$cityId = $_REQUEST['cityId'];
	}

	$cityName = getDestination($cityId);
	$categoryId = trim($_REQUEST['categoryId']); 
	$hotelTypeId = trim($_REQUEST['hotelTypeId']);  
	$hotelName = preg_replace('!\s+!', ' ', trim($_REQUEST['Hotel']));
	$locality = preg_replace('!\s+!', ' ', trim($_REQUEST['locality']));
	$queryId = trim($startDayData['queryId']);
	$quotationId = trim($startDayData['quotationId']);  
	$fromDate=date("Y-m-d", strtotime($startDate));
	if($_REQUEST['earlyCheckin'] == 1){
		$fromDate = date("Y-m-d", strtotime("-1 days", strtotime($fromDate)));
	}

	$date = $fromDate;
	$fromYear=date("Y", strtotime($startDate));
	$toDate=date("Y-m-d", strtotime($startDate)); 
	$toYear=date("Y", strtotime($startDate));
	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
	$queryData = mysqli_fetch_array($rs1);
 
	$whereSTR="";
	$whereSTR.=' and hotelCity = "'.clean($cityName).'"'; 
	if($categoryId!=''){ 
		$whereSTR.= ' and hotelCategoryId = "'.$categoryId.'"';
	} 
	if($hotelTypeId!=''){ 
		$whereSTR.= ' and hotelTypeId = "'.$hotelTypeId.'"';
	}
	if($hotelName!='' && $hotelName!='undefined'){ 
		$whereSTR.=' and hotelName like "%'.$hotelName.'%"';
	}
	if($locality!='' && $locality!='undefined'){ 
		$whereSTR.=' and locality like "%'.$locality.'%"';
	}



 	$fit_gitQuery = ""; 
	if($queryData['paxType']==1 || $queryData['paxType']==2){
		$fit_gitQuery = " and paxType='".$queryData['paxType']."' ";
	}else{
		$fit_gitQuery = " and paxType=2 ";
	}

	$seasonQuery = ""; 
	if($queryData['dayWise'] == 2){
		if($queryData['seasonType']!=3 ){
			 $seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
		}else{
			$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and  YEAR(fromDate) ='".$queryData['seasonYear']."'";
		}
	}else{
		$seasonQuery = " and DATE(fromDate) <= '".$fromDate."' and  DATE(toDate) >= '".$toDate."'";
	}	
	// echo $fit_gitQuery;

	$marketId = getQueryMaketType($queryId);
	$whereMarket = ' ';
	if($marketId>0){
		$whereMarket = ' and marketType="'.$marketId.'"';
	}

	$roomTypeQuery = '';
	if($_REQUEST['roomTypeId']!='' && $_REQUEST['roomTypeId']!=0){
		$roomTypeQuery = 'and roomType="'.$_REQUEST['roomTypeId'].'"'; 
	}

	$mealPlanQuery = '';
	if($_REQUEST['mealPlan'] > 0){
		$mealPlanQuery = 'and mealPlan="'.$_REQUEST['mealPlan'].'"'; 
	}

	$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 

	if($quotationData['quotationType'] == 1){	
		$checkQuery = $warningMsg = " ";
		$warningError = 0;
		if($_REQUEST['isGuestType']==1 && $_REQUEST['isHotelSupplement']==0){
			$checkQuery = " and isGuestType=1 ";
			$rsq='';   
			$countHotel = 0;
			$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');  
			$countHotel = mysqli_num_rows($rsq);
			if($countHotel > 0){
				// msg
				// $warningError = 1;
				$warningMsg .= 'Guest Hotel ,';
			}
		} 
		// && $_REQUEST['earlyCheckin']!=1  
		
		if($_REQUEST['isLocalEscort']==1 && $_REQUEST['isHotelSupplement']==0){
			$checkQuery = "  and isLocalEscort=1 ";
			$rsq=''; 
			$countHotel = 0;  
			$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');  
			$countHotel = mysqli_num_rows($rsq);
			if($countHotel > 0){
				// msg
				// $warningError = 1;
				$warningMsg .= 'Local Escort Hotel ,';
			}
		}
		

		if($_REQUEST['isForeignEscort']==1 && $_REQUEST['isHotelSupplement']==0){
			$checkQuery = "  and isForeignEscort=1  ";
			$rsq='';   
			$countHotel = 0;
			$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');  
			$countHotel = mysqli_num_rows($rsq);
			if($countHotel > 0){
				// msg
				// $warningError = 1;
				$warningMsg .= 'Foreign Escort Hotel ,';
			}
		}
		

 
	} 
}
?> 
<div id="viewinfo" style="position: absolute;z-index: 2147483647;border: 1px solid rgb(35 58 73);width: 100%;height: 100%;top: 0px;left: 0px;bottom: 0;background-color: rgb(13 15 20 / 78%);display:none;"><div id="loadhotelInfo" style="margin: auto; width: 94%; margin-top: 100px;"></div></div>

<?php if($_REQUEST['stype']!='roomSupplement'){ ?>
<div style="font-size:16px; padding:10px;position:relative;"> 
 	<span  id="hotelcounding">0 Hotel Found</span> 
	<div class="addBtn fa fa-plus" onclick="openinboundpop('action=addhoteltomaster&actionType=addServiceHotel&dayId=<?php echo $startDayId; ?>&cityId=<?php echo $cityId; ?>','1200px');" >&nbsp;Add New</div>
</div> 
<?php } ?>
<div style="max-height:300px; overflow:auto; position:relative;">
<div style="padding:5px; border:1px #e3e3e3 solid;background-color: #fff;">
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
<tr>
	<td align="left" valign="middle" bgcolor="#DDDDDD"><strong>Hotel</strong></td>
	<td align="left" valign="middle" bgcolor="#DDDDDD" ><strong>Supplier</strong></td>
	<td width="10%" align="left" valign="middle" bgcolor="#DDDDDD" ><strong>Category/HotelType</strong></td>
	<?php if($calculationType!=3){ ?>
		<td width="10%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>RoomType/Meal</strong></td> 
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Tariff&nbsp;Type</strong></td>
		<td width="15%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Rate&nbsp;Validate</strong></td>
		<?php if($singleRoom>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Single</strong></td>
		<?php } ?>
		<?php if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Double</strong></td>
		<?php } ?>
		<?php if($tplRoom>0 || $EBedA>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Extra&nbsp;Bed(A)</strong></td>
		<?php } ?>
		<?php if($quadNoofRoom>0){ ?>
			<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Quad Room</strong></td>
		<?php } ?>
		<?php if($teenNoofRoom>0){ ?>
			<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Teen Room</strong></td>
		<?php } ?>
		<?php if($EBedCRoom>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>CWBed(C)</strong></td>
		<?php } ?>
		<?php if($childwithoutNoofBed>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>CNBed(C)</strong></td>
		<?php }  if($sixNoofBedRoom>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Six Bed Room</strong></td>
		<?php } if($eightNoofBedRoom>0){ ?>
			<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Eight Bed Room</strong></td>
		<?php } if($tenNoofBedRoom>0){ ?>
			<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Ten Bed Room</strong></td>
		<?php } ?>
	<?php } ?>
	<td align="center" valign="middle" bgcolor="#DDDDDD" width="80"><strong>Action</strong></td>
	<td align="center" valign="middle" bgcolor="#DDDDDD" width="80"><strong>&nbsp;</strong></td>
</tr> 
	<?php  
	$n=0;
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';     
    $where=' 1 '.$whereSTR.' order by hotelName asc';   
	$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 	  
	
	while($resListing=mysqli_fetch_array($rs)){  
		$rs232='';
  		$rs232=GetPageRecord('*','hotelCategoryMaster','id="'.$resListing['hotelCategoryId'].'"'); 
    	$hotelCatD=mysqli_fetch_array($rs232);

		$hotelTypeQuery="";
		$hotelTypeQuery=GetPageRecord('name','hotelTypeMaster','id="'.$resListing['hotelTypeId'].'"'); 
		$hotelTypeD=mysqli_fetch_array($hotelTypeQuery); 
		if($calculationType!=3){
			//for special 
			$tariffQuery="";  
			$specialCheckQuery = "";  
			$specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="3" ');

			//for  weekend 
			$weekendCheckQuery = "";  
			$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ');
			if(mysqli_num_rows($specialCheckQuery)>0 && $queryData['dayWise']!= 2){
				//if have special 
				$tariffQuery = '  and  tarifType="3" ';
			}elseif(mysqli_num_rows($weekendCheckQuery)>0 && $queryData['dayWise']!= 2){
				//if have weekend
				$tariffQuery = '  and  tarifType="2"  and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ';
			}else{
				$tariffQuery = '  and  tarifType="1" ';
			}
			
			 $where1dmc = ' serviceid="'.$resListing['id'].'"  '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.' '.$whereMarket.' '.$tariffQuery.' '.$suppliersQuery.' and status=1 order by doubleoccupancy asc';
			$rs1dmc=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$where1dmc); 
			if(mysqli_num_rows($rs1dmc) > 0){

				while($dmcroommastermain2=mysqli_fetch_array($rs1dmc)){
	 				
					$doubleoccupancy=$singleoccupancy=$extraBed=0;

					$tblNumber = 0;
					$rsa2s=GetPageRecord('*','quotationHotelRateMaster','tariffId="'.$dmcroommastermain2['id'].'" and quotationId="'.$quotationId.'"');

					if(mysqli_num_rows($rsa2s)>0){ 

						$dmcroommastermain=mysqli_fetch_array($rsa2s);
						// normal if found 
						// echo 'quotRate'.$dmcroommastermain['id'];
						
						// supplement cost check and calculated
						$rssup2 = ""; 
						$rssup2=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 

						if(mysqli_num_rows($rssup2) > 0){
							$supplementCost=mysqli_fetch_array($rssup2); 
							$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['singleoccupancy'],$supplementCost['gstTax'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['doubleoccupancy'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['extraBed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$extraBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['childwithbed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$extraNBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['childwithoutbed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$sixBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['sixBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$eightBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['eightBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$tenBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['tenBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$quadRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['quadRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);
							
							$teenRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['teenRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childBreakfast'],$supplementCost['mealGST'],0,1,0,0);

							$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childLunch'],$supplementCost['mealGST'],0,1,0,0);

							$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childDinner'],$supplementCost['mealGST'],0,1,0,0);

							$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['lunch'],$supplementCost['mealGST'],0,1,0,0);

							$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0,1,0,0)+ getCostWithGSTID_Markup($supplementCost['dinner'],$supplementCost['mealGST'],0,1,0,0);

							$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['breakfast'],$supplementCost['mealGST'],0,1,0,0);

							$supplementCostAdded = 1;

							$supplementId = $supplementCost['id'];

						}else{
							//table not giving any supplement cost 
							$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$extraBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							 $extraNBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							 $sixBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$eightBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$tenBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$quadRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);
							
							$teenRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$supplementCostAdded = 0;

							$supplementId = 0;

						}

						//final variable from selected table 

						$dmcroomTariffId = $dmcroommastermain['tariffId']; 

						$rs12ss="";

						$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 

						$editresult2ss=mysqli_fetch_array($rs12ss); 


						$rs12sss="";

						$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"'); 

						$editresult2sss=mysqli_fetch_array($rs12sss);
						
						
						$suppQuery="";
						$supname = '';
						$suppQuery=GetPageRecord('name,supplierNumber,id','suppliersMaster','id="'.$dmcroommastermain['supplierId'].'"'); 
						$suppD=mysqli_fetch_array($suppQuery);
						if($suppD['id'] > 0){ 
						$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
						}
						// if we have a triple room and extra bed price 0 then it should make an alert

						$extraBedAlert = 0;

						$tblNumber = 2;

						if($queryData['tplRoom'] > 0 && $dmcroommastermain['extraBed'] < 1){ 

							$extraBedAlert = 1;		 

						} 

					}else{  
						//get from dmc normal rate

						$rsa2s=""; 
						$rsa2s=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$dmcroommastermain2['id'].'"');  

						$dmcroommastermain=mysqli_fetch_array($rsa2s);

						//check dmc haveing supplement cost
						$rssup1 = ""; 
						$rssup1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.'  '.$suppliersQuery.' and status=1 and tarifType="4"'); 
						if(mysqli_num_rows($rssup1) > 0 && mysqli_num_rows($rsa2s) > 0){
							$supplementCost=mysqli_fetch_array($rssup1);

							$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['singleoccupancy'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['doubleoccupancy'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['extraBed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$extraBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['childwithbed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$extraNBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['childwithoutbed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$sixBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['sixBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$eightBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['eightBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$tenBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['tenBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$quadRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['quadRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);
							
							$teenRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['teenRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

							$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childBreakfast'],$supplementCost['mealGST'],0,1,0,0);

							$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childLunch'],$supplementCost['mealGST'],0,1,0,0);

							$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childDinner'],$supplementCost['mealGST'],0,1,0,0);

							$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['lunch'],$supplementCost['mealGST'],0,1,0,0);

							$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0,1,0,0)+ getCostWithGSTID_Markup($supplementCost['dinner'],$supplementCost['mealGST'],0,1,0,0);

							$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['breakfast'],$supplementCost['mealGST'],0,1,0,0);

							$supplementCostAdded = 1;

							$supplementId = $supplementCost['id'];

						} 


						//both table not giving any supplement cost 

						if(mysqli_num_rows($rssup1) == 0){  
							$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 
							$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 
							$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 
							$extraBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);
							$extraNBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$sixBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$eightBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$tenBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

							$quadRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);
							
							$teenRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);
	 
							$supplementCostAdded = 0;

							$supplementId = 0;

						}

						

						//final variable from selected table 

						$dmcroomTariffId = $dmcroommastermain['tariffId']; 
	 

						$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 

						$editresult2ss=mysqli_fetch_array($rs12ss); 

						 

						$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"');
						$editresult2sss=mysqli_fetch_array($rs12sss);
						 
						
						$suppQuery="";
						$supname = '';
						$suppQuery=GetPageRecord('name,supplierNumber,id','suppliersMaster','id="'.$dmcroommastermain['supplierId'].'"'); 
						$suppD=mysqli_fetch_array($suppQuery); 
						if($suppD['id'] > 0){ 
						$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
						} 

						

						// if we have a triple room and extra bed price 0 then it should make an alert

						$extraBedAlert = 0;

						$tblNumber = 1;

						if($queryData['tplRoom'] > 0 && $dmcroommastermain['extraBed'] < 1){ 

							$extraBedAlert = 1;		 

						} 

					}  

					$currencyId = $dmcroommastermain['currencyId'];
					$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
					// $currencyValue = $dmcroommastermain['currencyValue'];

					if($dmcroommastermain['id'] != $roomTariffId){	
					?> 
					<tr style="border-bottom:1px solid #ccc;<?php echo $n;?>">

						<td align="left" valign="middle"><?php if($resListing['termAndCondition']!='' || $resListing['policy']!='' || $resListing['hoteldetail']!=''){?><div class="bluelink" onclick="hoteltcinfo('<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['hotelName']); ?></div><?php }else{ echo strip($resListing['hotelName']); } ?></td>

						<td align="left" valign="middle"><?php echo $supname; ?></td>
						<td align="left" valign="middle"><?php echo trim($hotelCatD['hotelCategory']); ?> Star/<?php echo ucfirst($hotelTypeD['name']);?></td>
					    <td align="center" valign="middle"><?php 

						$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"'); 

						$editresult2sss=mysqli_fetch_array($rs12sss);

						echo $editresult2sss['name'].'/';

						$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 

						$editresult2ss=mysqli_fetch_array($rs12ss);

						echo $editresult2ss['name'];  

						?></td>
						<td align="center" valign="middle"><?php echo getTariffType($dmcroommastermain['tarifType']);?> <?php if($supplementCostAdded == 1) { ?> <span class="fa fa-info-circle" title="Supplement Cost Applied." style=" color: red; margin-left: 10px; "></span><?php } ?></td> 
						<td align="center" valign="middle"><?php  echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])).'&nbsp;/&nbsp;'.date('d-m-Y',strtotime($dmcroommastermain['toDate'])); ?></td>

						<?php if($singleRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$singleoccupancy; ?>  </td> 
						<?php } ?>
						<?php if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$doubleoccupancy; ?></td> 
						<?php } ?>
						<?php if($tplRoom>0 || $EBedA>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$extraBed; ?></td>
						<?php } ?>
						<?php if($quadNoofRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$quadRoomCost; ?></td>
						<?php } ?>
						<?php if($teenNoofRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$teenRoomCost; ?></td>
						<?php } ?>
						<?php if($EBedCRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$extraBedC; ?></td>
						<?php } ?>
						<?php if($childwithoutNoofBed>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$extraNBedC; ?></td>
						<?php } ?>
						<?php if($sixNoofBedRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$sixBedRoomCost; ?></td>
						<?php } ?>
						<?php if($eightNoofBedRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$eightBedRoomCost; ?></td>
						<?php } ?>
						<?php if($tenNoofBedRoom>0){ ?>
						<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$tenBedRoomCost; ?></td>
						<?php } ?>
						
						<td align="center" valign="middle" width="80"> 
						
						<?php   
						//Price BETWEEN 10 AND 20
						$rs21=GetPageRecord('*',' hoteloperationRestriction',' hotelId = "'.$dmcroommastermain['serviceid'].'"  and (  "'.$startDate.'" BETWEEN startDate  and endDate  ) ');  

						$msgOpr = '';

						if(mysqli_num_rows($rs21) > 0){ 

							$oprResData=mysqli_fetch_array($rs21);

							$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

						?> 

						<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect fa fa-hand-pointer-o" onclick="if(confirm('<?php echo strip($resListing['hotelName']); ?> - Operation restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?> \nDo you still want to select')) <?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php }elseif($warningError == 1){ ?>alert('<?php echo rtrim($warningMsg,' ,'); ?> Already Exist!'); <?php } elseif($currencyValue==0){ ?>alert('Currency ROE is mendatory!')<?php } else{ ?>addhoteltoquotations('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>');<?php } ?>" id="selectthisH('<?php echo $dmcroommastermain['id'];?>')" >&nbsp;Select</div>

						<?php } else { ?> 
						<!-- hotel search time select and breakUP cost button not show related code  -->
						<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect fa fa-hand-pointer-o" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php }elseif($warningError == 1){ ?>alert('<?php echo rtrim($warningMsg,' ,'); ?> Already Exist!'); <?php } elseif($currencyValue==0){ ?>alert('Currency ROE is mendatory!')<?php } else{ ?>addhoteltoquotations('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>');<?php } ?>" id="selectthisH('<?php echo $dmcroommastermain['id'];?>')" >&nbsp;Select</div>
						<?php  } ?>				
						</td>
						<td align="center" valign="middle" width="80"> 
						<?php if($extraBedAlert == 1 || $tblNumber == 2){ ?>
							<div class="editbtnselect fa fa-pencil" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;">&nbsp;Edit&nbsp;Price</div>
						<?php  }else{ ?>
							<div class="editbtnselect fa fa-pencil" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;">&nbsp;<?php if(mysqli_num_rows($rsa2s)>0){ ?>Edit<?php }else{ ?>Add<?php } ?>&nbsp;Price</div> 

							<!-- <div class="editbtnselect fa fa-info-circle" onclick="getinfo('<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>');">&nbsp;Breakup&nbsp;Cost</div> -->
						<?php } ?>
						</td>
			  		</tr> 
			  		<?php } ?>
					<script> 

						function getinfo(tariffId,tblNum){

							$('#viewinfo').show();

							$('#loadhotelInfo').load('loadhotelInfo.php?quotationId=<?php echo $quotationId;?>&tariffId='+tariffId+'&tblNum='+tblNum);
						} 
						<?php //if($extraBedAlert == 1){ ?> 
						function addnewRates(serviceid,tariffId){

							$('#viewinfo').show(); 

							$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&quotationId='+<?php echo $quotationId;?>);

						}  
						<?php //} ?> 
					</script>
					<?php 
				}
			}else{ 
				//for special

				$tariffQuery=""; 

				$specialCheckQuery = ""; 

				$specialCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and quotationId="'.$quotationId.'" and tarifType="3"');
				 //for weekend 

				$weekendCheckQuery = ""; 

				$weekendCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.'  '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ');

				 

				if(mysqli_num_rows($specialCheckQuery)>0 && $queryData['dayWise'] != 2){ 

					//if have special

					$tariffQuery = ' and  tarifType="3"';	

				}elseif(mysqli_num_rows($weekendCheckQuery)>0  && $queryData['dayWise'] != 2){

					//if have weekend

					$tariffQuery = ' and  tarifType="2"  and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ';	

				}else{

					$tariffQuery = ' and  tarifType="1" ';	

				}


				// check for normal

				$seasonQuery2 = ""; 

				if($queryData['dayWise'] == 2){

					if($queryData['seasonType']!= 3 ){

						$seasonQuery2 = " and seasonType='".$queryData['seasonType']."'";

					}else{

						$seasonQuery2 = " and ( seasonType=1 or seasonType=2 ) ";

					}

				}else{

					$seasonQuery2 = " and DATE(fromDate)<='".$fromDate."' and  DATE(toDate)>='".$toDate."'";

				}	



				$tblNumber=2;

				$dmcroommastermain ='';

				$dmcroomTariffId = 0;
				
				// echo 'serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$fit_gitQuery.'  '.$seasonQuery2.'  '.$whereMarket.' '.$tariffQuery.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 order by id desc';
				
				$rsa2s="";
				$rsa2s=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery2.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$tariffQuery.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 order by id desc');  

				if(mysqli_num_rows($rsa2s)>0){  

					$singleoccupancy=$doubleoccupancy=$extraBed=$extraBedC=$extraNBedC=$sixBedRoomCost=$eightBedRoomCost=$tenBedRoomCost=$quadRoomCost=$teenRoomCost=0;

					while($dmcroommastermain = mysqli_fetch_array($rsa2s)){
					// supplement cost check and calculated

					$rssup2 = ""; 

					$rssup2=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery2.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.'  and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 

				 

					if(mysqli_num_rows($rssup2) > 0 && mysqli_num_rows($rsa2s) > 0){

						$supplementCost=mysqli_fetch_array($rssup2);

						$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['singleoccupancy'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['doubleoccupancy'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['extraBed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$extraBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['childwithbed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$extraNBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['childwithoutbed'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$sixBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['sixBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$eightBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['eightBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$tenBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['tenBedRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$quadRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['quadRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$teenRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']) + getCostWithGSTID_Markup($supplementCost['teenRoom'],$supplementCost['roomGST'],$supplementCost['markupCost'],$supplementCost['markupType'],$supplementCost['roomTAC'],$supplementCost['TACType']);

						$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childBreakfast'],$supplementCost['mealGST'],0,1,0,0);

						$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childLunch'],$supplementCost['mealGST'],0,1,0,0);

						$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childDinner'],$supplementCost['mealGST'],0,1,0,0);

						$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['lunch'],$supplementCost['mealGST'],0,1,0,0);

						$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0,1,0,0)+ getCostWithGSTID_Markup($supplementCost['dinner'],$supplementCost['mealGST'],0,1,0,0);

						$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0,1,0,0) + getCostWithGSTID_Markup($supplementCost['breakfast'],$supplementCost['mealGST'],0,1,0,0);

						 

						$supplementCostAdded = 1;

						$supplementId = $supplementCost['id'];

					} 

	 				// table not giving any supplement cost 

					if(mysqli_num_rows($rssup2) == 0){

						$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

						$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

						$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 

						$extraBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 

						$extraNBedC =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 

						$sixBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 

						$eightBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 

						$tenBedRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']); 

						$quadRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);
						
						$teenRoomCost =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);
			
						$supplementCostAdded = 0;

						$supplementId = 0;

					}
	 
					//final variable from selected table 

					$dmcroomTariffId = $dmcroommastermain['tariffId']; 

					

					$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 

					$editresult2ss=mysqli_fetch_array($rs12ss); 

					 

					$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"'); 

					$editresult2sss=mysqli_fetch_array($rs12sss);

					
					$suppQuery="";
						$supname = '';
					$suppQuery=GetPageRecord('name,supplierNumber,id','suppliersMaster','id="'.$dmcroommastermain['supplierId'].'"'); 
					$suppD=mysqli_fetch_array($suppQuery); 
					if($suppD['id'] > 0){ 
						$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
					}

					// if we have a triple room and extra bed price 0 then it should make an alert
					$extraBedAlert = 0;
					if($queryData['tplRoom'] > 0 && $dmcroommastermain['extraBed'] < 1){ 
						$extraBedAlert = 1;		 
					} 

					$currencyId = $dmcroommastermain['currencyId'];
					$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
					// $currencyValue = $dmcroommastermain['currencyValue'];
						               
					if($dmcroommastermain['id'] != $roomTariffId){
					?> 
					<tr style="border-bottom:1px solid #ccc;">

						<td align="left" valign="middle" bgcolor="#F7FCFD"><?php if($resListing['termAndCondition']!='' || $resListing['policy']!='' || $resListing['hoteldetail']!=''){?><div class="bluelink" onclick="hoteltcinfo('<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['hotelName']); ?></div><?php }else{ echo strip($resListing['hotelName']); } ?></td>
						<td align="left" valign="middle"><?php echo $supname; ?></td>
						<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo trim($hotelCatD['hotelCategory']); ?> Star/<?php echo ucfirst($hotelTypeD['name']);  ?></td>

						<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo $editresult2sss['name'].'/'.$editresult2ss['name']; }  ?></td>
						
						<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo getTariffType($dmcroommastermain['tarifType']); if($supplementCostAdded == 1) { ?> <span class="fa fa-info-circle" title="Supplement Cost Applied." style=" color: red; margin-left: 10px; "></span><?php } } ?></td> 
						
						<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){  echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])).'&nbsp;/&nbsp;'.date('d-m-Y',strtotime($dmcroommastermain['toDate'])); } ?></td>				
						<?php if($singleRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$singleoccupancy; } ?></td>
						<?php } ?>
						<?php if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$doubleoccupancy; } ?></td>
						<?php } ?>
						<?php if($tplRoom>0 || $EBedA>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$extraBed; } ?></td>
						<?php } ?>
						<?php if($quadNoofRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$quadRoomCost; } ?></td>
						<?php } ?>
						<?php if($teenNoofRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$teenRoomCost; } ?></td>
						<?php } ?>
						<?php if($EBedCRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$extraBedC; } ?></td>
						<?php } ?>
						<?php if($childwithoutNoofBed>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$extraNBedC; } ?></td>
						<?php } ?>
						<?php if($sixNoofBedRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$sixBedRoomCost; } ?></td>
						<?php } ?>
						<?php if($eightNoofBedRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$eightBedRoomCost; } ?></td>
						<?php } ?>
						<?php if($tenNoofBedRoom>0){ ?>
						<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.$tenBedRoomCost; } ?></td>
						<?php } ?>
						
					
						<td align="center" valign="middle" bgcolor="#F7FCFD" width="80"><?php if(mysqli_num_rows($rsa2s)>0){ ?> 
						<?php   
						//Price BETWEEN 10 AND 20
						$rs21=GetPageRecord('*',' hoteloperationRestriction',' hotelId = "'.$dmcroommastermain['serviceid'].'"  and (  "'.$startDate.'" BETWEEN startDate  and endDate  ) ');  
		
						$msgOpr = '';
		
						if(mysqli_num_rows($rs21) > 0){ 
		
							$oprResData=mysqli_fetch_array($rs21);
		
							$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
							//hotel opration 
							?> 
							<div style=" background-color:#589fa6; width: fit-content !important; padding: 8px !important;" class="editbtnselect fa fa-hand-pointer-o" onclick="if(confirm('<?php echo strip($resListing['hotelName']); ?> - Operation restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?> \nDo you still want to select?')) <?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php }elseif($warningError == 1){ ?>alert('<?php echo rtrim($warningMsg,' ,'); ?> Already Exist!'); <?php } elseif($currencyValue==0){ ?>alert('Currency ROE is mendatory!')<?php } else{ ?>addhoteltoquotations('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>'); <?php } ?>" id="selectthisH('<?php echo $dmcroommastermain['id'];?>')" >&nbsp;Select</div>
							
						<?php } else{ ?>
						
							<div style=" background-color:#589fa6; width: fit-content !important; padding: 8px !important;" class="editbtnselect fa fa-hand-pointer-o" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php }elseif($warningError == 1){ ?>alert('<?php echo rtrim($warningMsg,' ,'); ?> Already Exist!'); <?php } elseif($currencyValue==0){ ?>alert('Currency ROE is mendatory!')<?php } else{ ?>addhoteltoquotations('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>'); <?php } ?>" id="selectthisH('<?php echo $dmcroommastermain['id'];?>')" >&nbsp;Select</div>
							<?php 
							} 
						} ?>
						</td>

						<td align="center" valign="middle" bgcolor="#F7FCFD" width="80"> 
					  		<div class="editbtnselect fa fa-pencil" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;">&nbsp;<?php if(mysqli_num_rows($rsa2s)>0){ ?>Edit<?php }else{ ?>Add<?php } ?>&nbsp;Price</div> 
					  	</td>

					</tr> 
					<?php } ?>
					<script>  
					function addnewRates(serviceid,tariffId){ 
						$('#viewinfo').show(); 
						$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&quotationId='+<?php echo $quotationId;?>);

					}  
					</script> 
					<?php  
					} 
				}else{ 
					$singleoccupancy=$doubleoccupancy=$extraBed=$extraBedC=$extraNBedC=$sixBedRoomCost=$eightBedRoomCost=$tenBedRoomCost=$quadRoomCost=$teenRoomCost=0;

					// No rates found
	 				$supname="";
					$extraBedAlert = 0;

					?> 

					<tr style="border-bottom:1px solid #ccc;">

						<td align="left" valign="middle" bgcolor="#F7FCFD"><?php if($resListing['termAndCondition']!='' || $resListing['policy']!='' || $resListing['hoteldetail']!=''){?><div class="bluelink" onclick="hoteltcinfo('<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['hotelName']); ?></div><?php }else{ echo strip($resListing['hotelName']); } ?></td>
						<td align="left" valign="middle"><?php echo $supname; ?></td>
						<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo trim($hotelCatD['hotelCategory']); ?> Star/<?php  echo ucfirst($hotelTypeD['name']); ?></td>

						<td align="center" valign="middle" bgcolor="#F7FCFD"></td>
						
						<td align="center" valign="middle" bgcolor="#F7FCFD"></td> 
						
						<td align="center" valign="middle" bgcolor="#F7FCFD"></td>					

						<?php if($singleRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>
						<?php if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>
						<?php if($tplRoom>0 || $EBedA>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>
						<?php if($quadNoofRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>

						<?php if($teenNoofRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>
						
						<?php if($EBedCRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>
						<?php if($childwithoutNoofBed>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>

						<?php if($sixNoofBedRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>

						<?php if($eightNoofBedRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>

						<?php if($tenNoofBedRoom>0){ ?>
						<td align="center" valign="middle"></td>
						<?php } ?>

	  					<td align="center" valign="middle" bgcolor="#F7FCFD" width="80">
						</td>
						<td align="center" valign="middle" bgcolor="#F7FCFD" width="125"> 
					  		<div class="editbtnselect fa fa-plus" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#34556a;">&nbsp;Add&nbsp;Price</div>				
					 	 </td>

					</tr> 
					<script> 

					function addnewRates(serviceid,tariffId){

						$('#viewinfo').show();

						$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&quotationId='+<?php echo $quotationId;?>);

					} 

					</script>

					<?php 

					  

				}
			} 
		}else{
			// complete package costing
			$checkPackageRateQuery="";
			$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
			if(mysqli_num_rows($checkPackageRateQuery) > 0){
	 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

			    $currencyId = $getPackageRateData['currencyId'];
			    $currencyVal = getCurrencyVal($currencyId);
			    $supplierId = $getPackageRateData['supplierId'];
			} 

			$singleoccupancy=$doubleoccupancy=$extraBed=$extraBedC=$extraNBedC=$sixBedRoomCost=$eightBedRoomCost=$tenBedRoomCost=$quadRoomCost=$teenRoomCost=0;
			// No rates found
			$supname=getsupplierCompany($supplierId);
			$extraBedAlert = 0;
			?> 
			<tr style="border-bottom:1px solid #ccc;">

				<td align="left" valign="middle" bgcolor="#F7FCFD"><?php if($resListing['termAndCondition']!='' || $resListing['policy']!='' || $resListing['hoteldetail']!=''){?><div class="bluelink" onclick="hoteltcinfo('<?php echo $resListing['id']; ?>');"><?php echo strip($resListing['hotelName']); ?></div><?php }else{ echo strip($resListing['hotelName']); } ?></td>
				<td align="left" valign="middle"><?php echo $supname; ?></td>
				<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo trim($hotelCatD['hotelCategory']); ?> Star/<?php  echo ucfirst($hotelTypeD['name']); ?></td>
				<?php 
				if($calculationType!=3){ ?>
				<td align="center" valign="middle" bgcolor="#F7FCFD"></td>
				<td align="center" valign="middle" bgcolor="#F7FCFD"></td> 
				<td align="center" valign="middle" bgcolor="#F7FCFD"></td>		

				<?php if($singleRoom>0){ ?>
				<td align="center" valign="middle"></td> 
				<?php }if($doubleRoom>0){ ?>
				<td align="center" valign="middle"></td> 
				<?php }if($twinRoom>0){ ?>
				<td align="center" valign="middle"></td> 
				<?php }if($tplRoom>0){ ?>
				<td align="center" valign="middle"></td> 
				<?php }if($EBedA>0){ ?>
				<td align="center" valign="middle"></td>
				<?php }if($EBedCRoom>0){ ?>
				<td align="center" valign="middle"></td>
				<?php }if($childwithoutNoofBed>0){ ?>
				<td align="center" valign="middle"></td>
				<?php } ?>
				<?php } ?>

				<td align="center" valign="middle" width="80"> 
					<?php   
					//Price BETWEEN 10 AND 20
					$rs21=GetPageRecord('*',' hoteloperationRestriction',' hotelId = "'.$resListing['id'].'"  and (  "'.$startDate.'" BETWEEN startDate  and endDate  ) ');  
					$msgOpr = '';
					if(mysqli_num_rows($rs21) > 0){ 
						$oprResData=mysqli_fetch_array($rs21);
						$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
						?> 
						<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect fa fa-hand-pointer-o" onclick="if(confirm('<?php echo strip($resListing['hotelName']); ?> - Operation restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>')) <?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php }elseif($warningError == 1){ ?>alert('<?php echo rtrim($warningMsg,' ,'); ?> Already Exist!'); <?php } else{ ?>addhoteltoquotations_package('<?php echo $cityId; ?>','<?php echo $resListing['id']; ?>');<?php } ?>" id="selectthisH('<?php echo $resListing['id'];?>')" >&nbsp;Select</div>

					<?php } else { ?> 
						<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect fa fa-hand-pointer-o" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php }elseif($warningError == 1){ ?>alert('<?php echo rtrim($warningMsg,' ,'); ?> Already Exist!'); <?php } else{ ?>addhoteltoquotations_package('<?php echo $cityId; ?>','<?php echo $resListing['id']; ?>');<?php } ?>" id="selectthisH('<?php echo $resListing['id'];?>')" >&nbsp;Select</div>
					<?php  } ?>				
				</td>
				<td align="center" valign="middle" bgcolor="#F7FCFD" width="125"> 
			  		<div class="editbtnselect fa fa-plus" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#34556a;">&nbsp;Add&nbsp;Price</div>				
			 	 </td>
			</tr> 
			<script type="text/javascript"> 
			function addnewRates(serviceid,tariffId){
				$('#viewinfo').show();
				$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&quotationId='+<?php echo $quotationId;?>);

			} 
			</script>
			<?php 
		}
		$n++;

	} 

?>

</table> 

</div>

</div> 

<script>

	$('#hotelcounding').text('<?php echo $n; ?> Hotel Found');

 </script>

<?php if($n==0){ ?>

<div style="text-align:center; font-size:13px;  color:#FF0000; padding:12px;position:relative;"><span>No Hotel Found</span> </div>

 <script>

	// $('#hotelcounding').hide();

 </script>

<?php } ?>  
<style type="text/css"> 


	.editbtnselect, .addBtn{    

		border: 1px solid;

		padding: 8px 15px;

		text-align: center;

		font-size: 13px;

		border-radius: 3px;

		background-color: #4caf50;

		cursor: pointer;

		color: #fff;

	}

	.addBtn{

		width: fit-content !important;

		position: absolute;

		right: 30px;

		top: 2px;

		padding: 8px 12px !important;

		background-color: #7a96ff;

	}

</style>

<script type="text/javascript">

  function hoteltcinfo(hotelId) {

	$('#viewinfo').show();

	$('#loadhotelInfo').load('loadhoteltcinfo.php?hotelId='+hotelId);

  } 

</script>

