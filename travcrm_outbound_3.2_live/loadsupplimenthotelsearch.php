<?php
include "inc.php";  


$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');  
$startDayData=mysqli_fetch_array($startDayQuery);

$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');  
$endDayData=mysqli_fetch_array($endDayQuery);
/*-----------------------------------------------*/
$startDayId = $startDayData['id'];
$startDate = $startDayData['srdate'];
$endDayId = $endDayData['id'];
 
 
$destWise=$_REQUEST['destWise']; 
if($destWise!=2){
	$cityId=$startDayData['cityId']; 
}else{
	$cityId = $_REQUEST['cityId'];
}

$cityName = getDestination($cityId);

/*
$arraystart=explode(',',$_REQUEST['startDay']);
$dayidstart=$arraystart[0]; 
$datestart=$arraystart[1]; 


$arrayend=explode(',',$_REQUEST['endDay']); //endDay changed
$dayidend=$arrayend[0]; 
$dateend=$arrayend[1]; 
$destinationend=$arrayend[2];   
*/

$categoryId = trim($_REQUEST['categoryId']);
$hotelTypeId = trim($_REQUEST['hotelTypeId']); 
$mealPlan = $_REQUEST['mealPlan']; 
$hotelName = preg_replace('!\s+!', ' ', trim($_REQUEST['Hotel']));
$queryId = trim($startDayData['queryId']);
$quotationId = trim($startDayData['quotationId']);  


$fromDate=date("Y-m-d", strtotime($startDate));
$date = $fromDate;
$fromYear=date("Y", strtotime($startDate));

$toDate=date("Y-m-d", strtotime($startDate)); 
$toYear=date("Y", strtotime($startDate));
 
$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
$queryData = mysqli_fetch_array($rs1);

$whereSTR="";
$whereSTR.=' and hotelCity = "'.clean($cityName).'" '; 
if($categoryId!=''){ 
	$whereSTR.= ' and hotelCategoryId = "'.$categoryId.'"   ';
} 
if($hotelTypeId!=''){ 
	$whereSTR.= ' and hotelTypeId = "'.$hotelTypeId.'"   ';
} 
if($hotelName!='' && $hotelName!='undefined'){ 
	$whereSTR.=' and hotelName like "%'.$hotelName.'%" ';
}

if($mealPlan > 0){
	$mealPlan = 'and mealPlan="'.$mealPlan.'"'; 
}else{
	$mealPlan = '';
}
  
$seasonQuery = ""; 
if($queryData['dayWise'] == 2){
	if($queryData['seasonType']!= 3 ){
		$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
	}else{
		$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
	}
}else{
	$seasonQuery = " and DATE(fromDate)<='".$fromDate."' and  DATE(toDate)>='".$toDate."'";
}	

 
$marketId = getQueryMaketType($queryId);
$whereMarket = '  and marketType=1';
if($marketId>0){
	$whereMarket = ' and marketType="'.$marketId.'"';
}

$roomTypeQuery = '';
if($_REQUEST['roomType']!='' && $_REQUEST['roomType']!=0){
	$roomTypeQuery = 'and roomType="'.$_REQUEST['roomType'].'"'; 
}

$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 

?> 
<div id="viewinfo" style="position: absolute;z-index: 2147483647;border: 1px solid rgb(35 58 73);width: 100%;height: 100%;top: 0px;left: 0px;bottom: 0;background-color: rgb(13 15 20 / 78%);display:none;"><div id="loadhotelInfo" style="margin: auto; width: 70%; margin-top: 100px;"></div></div>

<div style="font-size:16px; padding:10px;position:relative;"> 
 	<span  id="hotelcounding">0 Hotel Found</span> 
	<div class="addBtn" onclick="openinboundpop('action=addhoteltomaster&actionType=addQuotationHotelSupplement&dayId=<?php echo $startDayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div>
</div> 
<div style="max-height:300px; overflow:auto; position:relative;">
 	<div style="padding:5px; border:1px #e3e3e3 solid;background-color: #fff;">
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
	<td width="11%" align="left" valign="middle" bgcolor="#DDDDDD"><strong>Hotel</strong></td>
	<td width="11%" align="left" valign="middle" bgcolor="#DDDDDD"><strong>Supplier</strong></td>
	<td width="5%" align="left" valign="middle" bgcolor="#DDDDDD"><strong>Category</strong></td>
	<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>HotelType</strong></td>
	<td width="6%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>RoomType/Meal</strong></td>
	<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Tariff&nbsp;Type</strong></td>
	<td width="14%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Rate&nbsp;Validate</strong></td>
	<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Single</strong></td>
	<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Double</strong></td>
	<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Extra&nbsp;Bed</strong></td>
	<td width="8%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Action</strong></td>
	<td width="16%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>&nbsp;</strong></td>
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

    	$hotelTypeQuery='';
  		$hotelTypeQuery=GetPageRecord('name','hotelTypeMaster','id="'.$resListing['hotelTypeId'].'"'); 
    	$hotelTypeD=mysqli_fetch_array($hotelTypeQuery);
		
		//for special
		$tariffQuery=""; 
		$specialCheckQuery = ""; 
		$specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="3" ');
		 
		 //for  weekend
		$weekendCheckQuery = ""; 
		$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ');
		 
		if(mysqli_num_rows($specialCheckQuery)>0){ 
			//if have special
			$tariffQuery = '  and  tarifType="3" ';	
		}elseif(mysqli_num_rows($weekendCheckQuery)>0 && $queryData['dayWise'] != 2){
			//if have weekend
			$tariffQuery = '  and  tarifType="2"  and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ';	
		}else{
			$tariffQuery = '  and  tarifType="1" ';	
		}
		
		$where1dmc = ' serviceid="'.$resListing['id'].'"  '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.' '.$whereMarket.' '.$suppliersQuery.' '.$tariffQuery.' and status=1 order by doubleoccupancy asc';
		$rs1dmc=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$where1dmc); 
		if(mysqli_num_rows($rs1dmc) > 0){
			while($dmcroommastermain2=mysqli_fetch_array($rs1dmc)){  
				$supname='';   
				$doubleoccupancy=$singleoccupancy=$extraBed=0;
				$tblNumber = 0;
				$rsa2s=GetPageRecord('*','quotationHotelRateMaster','tariffId="'.$dmcroommastermain2['id'].'" and quotationId="'.$quotationId.'"');  
				if(mysqli_num_rows($rsa2s)>0){ 
					$dmcroommastermain=mysqli_fetch_array($rsa2s);
					// normal if found 
					  
					// supplement cost check and calculated
					$rssup2 = ""; 
					$rssup2=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.'  and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 
				 
					if(mysqli_num_rows($rssup2) > 0 && mysqli_num_rows($rsa2s) > 0){
						$supplementCost=mysqli_fetch_array($rssup);
						$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
						$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
						$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
						 
						$supplementCostAdded = 1;
						$supplementId = $supplementCost['id'];
					} 
					
					//table not giving any supplement cost 
					if(mysqli_num_rows($rssup2) == 0){
						$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						  
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
					$supname="";
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
					$rssup1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.'   and status=1 and tarifType="4"'); 
					 
					if(mysqli_num_rows($rssup1) > 0 && mysqli_num_rows($rsa2s) > 0){
						$supplementCost=mysqli_fetch_array($rssup1);
						$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
						$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
						$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
						$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
						 
						$supplementCostAdded = 1;
						$supplementId = $supplementCost['id'];
					} 
					
					//both table not giving any supplement cost 
					if(mysqli_num_rows($rssup1) == 0){
						$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						  
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
					$supname="";
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
				?> 
				<tr style="border-bottom:1px solid #ccc;<?php echo $n;?>">
				<td align="left" valign="middle"><?php echo strip($resListing['hotelName']); ?></td>
				<td align="left" valign="middle"><?php echo $supname; ?></td>
				<td align="left" valign="middle"><?php echo trim($hotelCatD['hotelCategory']); ?> Star</td>
				<td align="center" valign="middle"><?php echo $hotelTypeD['name']; ?></td>
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
				<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$singleoccupancy; ?>  </td>
				<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$doubleoccupancy; ?></td>
				<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$extraBed; ?></td>
				<td align="center" valign="middle"> 
				<?php  
				//Price BETWEEN 10 AND 20
				$rs21=GetPageRecord('*','hoteloperationRestriction','hotelId="'.$dmcroommastermain['serviceid'].'" and ( startDate BETWEEN "'.$dmcroommastermain['fromDate'].'" and "'.$dmcroommastermain['fromDate'].'" and endDate BETWEEN "'.$dmcroommastermain['fromDate'].'" and "'.$dmcroommastermain['fromDate'].'" ) '); 
				 
				$msgOpr = '';
				if(mysqli_num_rows($rs21) > 0){ 
				$oprResData=mysqli_fetch_array($rs21);
				$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
				?> 
				<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="if(confirm('<?php echo strip($resListing['hotelName']); ?> - Operation restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>')) <?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementhotel('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>');<?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
				
				<?php } else { ?> 
				
				<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementhotel('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>');<?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
			 
				<?php  } ?>				</td>
				<td align="center" valign="middle"> 
				<?php if($extraBedAlert == 1 ){ ?>
				<div class="editbtnselect" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Edit&nbsp;Price</div>
				<?php  }else{ ?>
				<div class="editbtnselect" onclick="getinfo('<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>');"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Break-up&nbsp;Cost</div>
				<?php } ?>				</td>
	  </tr> 
				<script> 
				function getinfo(tariffId,tblNum){
					$('#viewinfo').show();
					$('#loadhotelInfo').load('loadhotelInfo.php?quotationId=<?php echo $quotationId;?>&tariffId='+tariffId+'&tblNum='+tblNum);
				} 
				<?php if($extraBedAlert == 1){ ?>
				function addnewRates(serviceid,tariffId){
					$('#viewinfo').show(); 
					$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&quotationId='+<?php echo $quotationId;?>);
				} 
				<?php } ?> 
				</script>
				<?php 
				 
			} 
		}else{ 
				
			//for special
			$tariffQuery=""; 
			$specialCheckQuery = ""; 
			$specialCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and quotationId="'.$quotationId.'"  and tarifType="3"');
			 
			 //for weekend 
			$weekendCheckQuery = ""; 
			$weekendCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ');
			 
			if(mysqli_num_rows($specialCheckQuery)>0){ 
				//if have special
				$tariffQuery = ' and  tarifType="3"';	
			}elseif(mysqli_num_rows($weekendCheckQuery)>0  && $queryData['dayWise'] != 2){
				//if have weekend
				$tariffQuery = ' and  tarifType="2"  and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) )  ';	
			}else{
				$tariffQuery = ' and  tarifType="1" ';	
			}
			
						
			// check for normal
			$tblNumber=2;
			$dmcroommastermain ='';
			$dmcroomTariffId = 0;
			$rsa2s="";
			$rsa2s=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.' '.$tariffQuery.' and quotationId="'.$quotationId.'" and status=1 order by id desc');  
			if(mysqli_num_rows($rsa2s)>0){  
				$singleoccupancy=$doubleoccupancy=$extraBed=0;
				while($dmcroommastermain = mysqli_fetch_array($rsa2s)){
				 
			   
				// supplement cost check and calculated
				$rssup2 = ""; 
				$rssup2=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.'  and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 
			 
				if(mysqli_num_rows($rssup2) > 0 && mysqli_num_rows($rsa2s) > 0){
					$supplementCost=mysqli_fetch_array($rssup2);
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
					 
					$supplementCostAdded = 1;
					$supplementId = $supplementCost['id'];
				} 
				
				// table not giving any supplement cost 
				if(mysqli_num_rows($rssup2) == 0){
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					  
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
				$supname="";
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
					
				?> 
				<tr style="border-bottom:1px solid #ccc;">
					<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo strip($resListing['hotelName']); ?></td>
					<td align="left" valign="middle"><?php echo $supname; ?></td>
					<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo trim($hotelCatD['hotelCategory']); ?> Star</td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php echo $hotelTypeD['name']; ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo $editresult2sss['name'].'/'. $editresult2ss['name']; }  ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo getTariffType($dmcroommastermain['tarifType']); if($supplementCostAdded == 1) { ?>
				    <span class="fa fa-info-circle" title="Supplement Cost Applied." style=" color: red; margin-left: 10px; "></span><?php } } ?></td> 
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){  echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])).'&nbsp;/&nbsp;'.date('d-m-Y',strtotime($dmcroommastermain['toDate'])); } ?></td>					
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$singleoccupancy; } ?></td>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$doubleoccupancy; } ?></td>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$extraBed; } ?></td>
					 
 				<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ ?> <div style=" background-color:#589fa6; width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementhotel('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>'); <?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div><?php } ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"> 
				  <div class="editbtnselect" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<?php if(mysqli_num_rows($rsa2s)>0){ ?>Edit<?php }else{ ?>Add<?php } ?>&nbsp;Price</div>				</td>
				</tr> 
				<script> 
				function addnewRates(serviceid,tariffId){
					$('#viewinfo').show();
					$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&quotationId='+<?php echo $quotationId;?>);
				} 
				//$('#hotelcounding').text('<?php echo $n; ?> Hotel Found');
				</script>
				<?php 
				
				}
			}else{
				$singleoccupancy=$doubleoccupancy=$extraBed=0;
				$dmcroommastermain = mysqli_fetch_array($rsa2s);
				 
			   
				// supplement cost check and calculated
				$rssup2 = ""; 
				$rssup2=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' '.$suppliersQuery.'  and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 
			 
				if(mysqli_num_rows($rssup2) > 0 && mysqli_num_rows($rsa2s) > 0){
					$supplementCost=mysqli_fetch_array($rssup2);
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
					 
					$supplementCostAdded = 1;
					$supplementId = $supplementCost['id'];
				} 
				
				// table not giving any supplement cost 
				if(mysqli_num_rows($rssup2) == 0){
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					  
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
				$supname="";
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
					
				?> 
				<tr style="border-bottom:1px solid #ccc;">
					<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo strip($resListing['hotelName']); ?></td>
					<td align="left" valign="middle"><?php echo $supname; ?></td>
					<td align="left" valign="middle" bgcolor="#F7FCFD"><?php echo trim($hotelCatD['hotelCategory']); ?> Star</td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php echo $hotelTypeD['name'];  ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo $editresult2sss['name'].'/'.  $editresult2ss['name']; }  ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo getTariffType($dmcroommastermain['tarifType']); if($supplementCostAdded == 1) { ?> <span class="fa fa-info-circle" title="Supplement Cost Applied." style=" color: red; margin-left: 10px; "></span><?php } } ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){  echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])).'&nbsp;/&nbsp;'.date('d-m-Y',strtotime($dmcroommastermain['toDate'])); } ?></td>					
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$singleoccupancy; } ?></td>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$doubleoccupancy; } ?></td>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$extraBed; } ?></td>
					  <td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ ?> <div style=" background-color:#589fa6; width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementhotel('<?php echo $cityId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>'); <?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div><?php } ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"> 
				  <div class="editbtnselect" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<?php if(mysqli_num_rows($rsa2s)>0){ ?>Edit<?php }else{ ?>Add<?php } ?>&nbsp;Price</div>				</td>
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
	 //$n++;
	
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
	$('#hotelcounding').hide();
 </script>
<?php } ?> 
 <style> 
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
