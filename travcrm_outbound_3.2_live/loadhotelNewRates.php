<?php
include "inc.php";    

$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$_REQUEST['serviceid'].'"'); 
$hotelData = mysqli_fetch_array($hotelQuery);

$rsa2s=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$hotelData['id'].'" and id="'.$_REQUEST['tariffId'].'" and quotationId="'.$_REQUEST['quotationId'].'" ');  
if(mysqli_num_rows($rsa2s) > 0){
	//provision to edit rates for this quotations
	$dmcroommastermain = mysqli_fetch_array($rsa2s);
	$editId = $dmcroommastermain['id'];
	
}elseif($_REQUEST['tariffId']!=0 && $_REQUEST['tariffId']!=''){
	//provision to add rate from exists dmc rates for this quotation
	$rs1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$_REQUEST['tariffId'].'"');
	$dmcroommastermain=mysqli_fetch_array($rs1);
	$editId = 0;
	echo $dmcroommastermain['markupCost'];
}else{
	//provision to add new rate only for this quotaiton
	$_REQUEST['tariffId'] = 0;
	$editId = 0;
}

$c="";
$c=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($c);


$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'"'); 
$queryData = mysqli_fetch_array($rs1);

$tarifquery =  $seasonQuery2 = $currencyquery= "";
if($_REQUEST['isRoomSupp'] == 1 && $_REQUEST['hotelQuoteId']!=''){ 
	$c="";
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
	$hotelQuotData=mysqli_fetch_array($c);
	 
	$tarifquery = " and id='".$hotelQuotData['tariffType']."'";
	
	$currencyquery = " and id='".$hotelQuotData['currencyId']."'";

}
  	
$seasonQuery2 = " and seasonNameId = '".$queryData['seasonType']."' ";

$roomrs = GetPageRecord('*','roomMaster','roomName="quadroom"');
$roomQuad = mysqli_fetch_assoc($roomrs);

$roomrs1 = GetPageRecord('*','roomMaster','roomName="sixbedroom"');
$roomSix = mysqli_fetch_assoc($roomrs1);

$roomrs2 = GetPageRecord('*','roomMaster','roomName="eightbedroom"');
$roomEight = mysqli_fetch_assoc($roomrs2);

$roomrs3 = GetPageRecord('*','roomMaster','roomName="tenbedroom"');
$roomTen = mysqli_fetch_assoc($roomrs3);

$roomrs4 = GetPageRecord('*','roomMaster','roomName="teenbed"');
$roomTeen = mysqli_fetch_assoc($roomrs4);

?>  
<script src="js/zebra_datepicker.js"></script>  
<style>
.allfields{
padding: 8px; 
border: 1px solid #ccc;
border-radius: 3px; 
	}
</style>
<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 10px; box-shadow: 0px 10px 35px;">
<table width="100%" border="0"  bgcolor="#DDDDDD"  cellspacing="0" cellpadding="5" >
  <tr>
    <td width="93%" align="left"><strong style="font-size: 15px; padding-left: 1px;"><?php echo clean($hotelData['hotelName']); ?> - Price <?php echo $cur; ?></strong></td>
    <td width="8%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#viewinfo').hide();"></i></td>
  </tr> 
</table>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addquohotelroomprice" target="actoinfrm"  id="addquohotelroomprice">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  <tbody> 
  
  <tr style="background-color:transparent !important;">
  <td colspan="4" style="background-color: #fce191;"><div style="font-size: 14px; font-weight: 600; padding-left: 2px;">Reference Rate</div></td>
  </tr>
   
  <tr style="background-color:transparent !important;">
  
  
  	<td width="15%"  align="left"><div class="griddiv" >
	<label>  
	<select id="marketType" name="marketType" class="allfields" displayname="Market Type" autocomplete="off" style="width: 100%;">  
<option value="">Market Type</option> 
 <?php   
$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');  
while($resListing=mysqli_fetch_array($rs)){   
?> 
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
<?php } ?>
</select></label>
	</div></td> 
	 
	 <td width="15%"  align="left"><div class="griddiv" >
	<label>  
	<select id="seasonType" name="seasonType" class="allfields" displayname="Season&nbsp;Type" style="width: 100%;"> 
 			<option value="">Season Type</option> 
			<option value="1" <?php if(1==$seasonType){ ?>selected="selected"<?php } ?>>Summer</option>
			<option value="2" <?php if(2==$seasonType){ ?>selected="selected"<?php } ?>>Winter</option>				
			</select></label>
	</div></td>
	
	<td width="15%"  align="left"><div class="griddiv" >
	<label>
	<?php 
				$starting_year  = date('Y');
				$ending_year    = 2040; 
				for($starting_year; $starting_year <= $ending_year; $starting_year++) {
					if(date('Y',strtotime($editresult['seasonYear'])) == $starting_year ){ $seleted = "selected"; }else{ $seleted = ""; }
					$years[] = '<option value="'.$starting_year.'" '.$seleted.' >'.$starting_year.'</option>';
				}
				?> 
				<select name="seasonYear" id="seasonYear"  class="allfields" style="width: 100%;">
 				<option value="">Season Year</option> 
				 <?php echo implode("\n\r", $years);  ?>
 				</select></label>
	</div></td> 
	 
	<td width="15%"  align="left"><div class="griddiv" >
	<label><input type="button" value="Search" onclick="referencehotelsblock();" style="padding: 9px 10px; background-color: #333333; color: #fff; border: 0; border-radius: 4px; cursor:pointer;" /></label></label>
	</div></td>
	 
	</tr>
	
  <tr style="background-color:transparent !important;">
  <td colspan="4" id="referencehotelsblock"></td>
  </tr>	 
</tbody></table> 
<script>
function referencehotelsblock(){
var marketType=$('#marketType').val();
var seasonType=$('#seasonType').val();
var seasonYear=$('#seasonYear').val();
$('#referencehotelsblock').load('loadreferencehotels.php?serviceid=<?php echo $_REQUEST['serviceid']; ?>&marketType='+marketType+'&seasonType='+seasonType+'&seasonYear='+seasonYear);
}
</script>

<br /><br />  
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="min-width:content;"> 
  <tbody> 

<tr style="background-color:transparent !important;">
  <td colspan="" style="background-color: #fce191;"><div style="font-size: 14px; font-weight: 600; padding-left:10px;">Manual Rate</div></td>
  </tr>   
   
  <tr style="background-color:transparent !important;">
  	<td align="left"><div class="griddiv" >
	<label> 
	<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
	<select id="roomSupplierId" name="roomSupplierId" class="allfields " displayname="Supplier" autocomplete="off"   style="width:120px;"> 
	<?php   
	$rs=$rsquery="";
	
	if($hotelData['supplier'] == 1){
		$isSupp = ' and name!="" and ( name like "%'.($hotelData['hotelName']).'%" or name = "'.($hotelData['hotelName']).'" ) ';
		$rs=GetPageRecord("*",_SUPPLIERS_MASTER_," deletestatus=0 and status=1 and companyTypeId=1 and name!='' ".$isSupp." group by name order by name asc"); 
		if(mysqli_num_rows($rs) == 0){
			$rsquery=' 1 and deletestatus=0 and status=1 and companyTypeId=1 and name!=""  group by name order by name asc';
		}else{
			$rsquery = " 1 ".$isSupp;
		}
	}else{ 
		$rsquery=' 1 and deletestatus=0 and status=1 and companyTypeId=1 and name!="" group by name order by name asc';
	} 
	echo $rsquery;
	$rs=GetPageRecord("*",_SUPPLIERS_MASTER_,$rsquery); 
	while($supplierData=mysqli_fetch_array($rs)){   
	?>
	<option value="<?php echo strip($supplierData['id']); ?>" <?php if($dmcroommastermain['supplierId']==$supplierData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($supplierData['name']); ?></option>
	<?php } ?>
	</select></label>
	</div></td> 
	 
	<td align="left" class="rateValidation_"><div class="griddiv">
	<label>
		<?php 
		if($dmcroommastermain['fromDate']!=''){ 
			$fromDate = date('d-m-Y', strtotime($dmcroommastermain['fromDate'])); 
		}else{ 
			$fromDate = date("d-m-Y", strtotime("-1 days", strtotime($quotationData['fromDate'])));
		}
		?>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"  class="allfields calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php echo $fromDate; ?>"  style="width: 100px;" />
	</label>
	</div>	</td>

    <td align="left" class="rateValidation_"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="allfields calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php if($dmcroommastermain['toDate']!=''){ echo date('d-m-Y', strtotime($dmcroommastermain['toDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['toDate'])); } ?>" style="width: 100px;"/>
	</label>
	</div>	</td>
	
	<td align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Tarif&nbsp;Type<span class="redmind"></span></div>
	<select id="tarifType" name="tarifType" class="allfields " displayname="Tarif Type"  autocomplete="off"  style="width:118px;" >
		<?php 
		$c="";
		$c=GetPageRecord('*','tariffTypeMaster',' 1 and  deleteStatus=0 '.$tarifquery.''); 
		while($tariffData=mysqli_fetch_array($c)){
		?>
		<option value="<?php echo $tariffData['id'];?>" <?php if($dmcroommastermain['tarifType']==$tariffData['id']){ ?> selected="selected" <?php } ?>><?php echo $tariffData['name'];?></option>
		<?php } ?> 
	</select>
	</label>
	</div>	
	</td>
 	 
	<!-- <td align="left" style="display: none;">
		<div class="griddiv">
			<label>
				<div class="gridlable">Season&nbsp;Type<span class="redmind"></span></div>
				<select id="seasonType" name="seasonType" class="allfields " displayname="Season&nbsp;Type" style="width:120px;" >
				<?php
				$seasonQuery = "";  
				if($dmcroommastermain['seasonType'] !='' && $dmcroommastermain['seasonType']!=0){
					$seasonQuery = " and id='".$dmcroommastermain['seasonType']."'";
				} 
				$rs=GetPageRecord('*','seasonMaster',' deletestatus=0 '.$seasonQuery.' '.$seasonQuery2.' group by seasonNameId order by name asc'); 
				while($resListing=mysqli_fetch_array($rs)){  ?>
				<option value="<?php echo strip($resListing['seasonNameId']); ?>" ><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
 				 
				</select>
			</label>
		</div>	
		</td> -->
		
 		<td align="left">
 			<div class="griddiv" >
			<label> 
			<div class="gridlable">Currency<span class="redmind"></span></div>
			<select id="currencyId" name="currencyId" class="allfields " displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal123');"  style="width:100px;"> 
			<?php 
			$currencyId = ($dmcroommastermain['currencyId']>0)?$dmcroommastermain['currencyId']:$baseCurrencyId;
			$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
			$rs='';  
			$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and status=1 '.$currencyquery.' order by name asc'); 
			while($resListing=mysqli_fetch_array($rs)){  
			?>
			<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select>
			</label>
			</div>
		</td>

		<td align="left">
			<div class="griddiv" >
			<label> 
			<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
			<input class="allfields validate" name="currencyValue"  id="currencyVal123" displayname="ROE Value"  value="<?php echo trim($currencyValue); ?>" style="width: 80px;display:inline-block;" >
			</label>
			</div>
		</td>

		<td align="left">
			<div class="griddiv">
			<label>
			<div class="gridlable">Room&nbsp;Type <span class="redmind"></span></div>
			<select id="roomType" name="roomType" class="allfields" displayname="Room Type" autocomplete="off"  style="width:100px;" > 
			<?php  
			///remvoe already added entry in quotHotelMaster 
			// $roomTypeArray1 = array($hotelQuotData['roomType']); 
			$roomTypeArray = explode(',',rtrim($hotelData['roomType'],','));
			// $roomTypeArray = array_diff($roomTypeArray2, $roomTypeArray1);
			foreach($roomTypeArray as $roomArray){
			$rs="";  
			$rs=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$roomArray.'"'); 
			$resListing=mysqli_fetch_array($rs);	
			?>
			<option value="<?php echo strip($resListing['id']); ?>"  <?php if($resListing['id']==$dmcroommastermain['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select>
			</label>
			</div>
		</td>
		<td align="left">
			<div class="griddiv">
			<label> 
			<div class="gridlable">Meal&nbsp;Plan <span class="redmind"></span></div>
			<select id="mealPlan" name="mealPlan" class="allfields  " displayname="Meal Plan" autocomplete="off"  style="width:100px;"  > 
			<?php   
			$rs='';  
			$rs=GetPageRecord('*',_MEAL_PLAN_MASTER_,'name!="" and deletestatus=0 and status=1 order by id asc'); 
			while($resListing=mysqli_fetch_array($rs)){  

			?>
			<option value="<?php echo strip($resListing['id']); ?>"  <?php if($resListing['id']==$dmcroommastermain['mealPlan']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select>
			</label>
		</div>
		</td>

	<td align="left"><div class="griddiv">
		<label>
			<div class="gridlable">ROOM&nbsp;TAX&nbsp;SLAB(%) <span class="redmind"></span></div>
			<select id="roomGST" name="roomGST" class="allfields" displayname="Room GST" autocomplete="off" style="width:118px;" >
				<?php 
				$rs2="";
				$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1'); 
				while($gstSlabData=mysqli_fetch_array($rs2)){
				?>
				<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcroommastermain['roomGST']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
				<?php
				}	
				?>
			</select>
		</label>
		</div></td>
	  <td align="left"><div class="griddiv">
			<label>
			<div class="gridlable">MEAL&nbsp;TAX&nbsp;SLAB(%) <span class="redmind"></span></div>
			<select id="mealGST" name="mealGST" class="allfields" displayname="Meal GST" autocomplete="off" style="width: 118px;" >
		 		<?php 
				$rs2="";
				$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1 order by gstSlabName asc'); 
				while($gstSlabData=mysqli_fetch_array($rs2)){
				?>
				<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcroommastermain['mealGST']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
				<?php
				}	
				?>
			</select>
		</label>
		</div></td>
	</tr>

	<tr>
	  
	
	  <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Single</div>
	<input name="singleoccupancy" type="text" class="allfields"  id="singleoccupancy" maxlength="6" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $dmcroommastermain['singleoccupancy']; ?>"/>
	</label>
	</div></td>
	
	  <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Double</div>
	<input name="doubleoccupancy" type="text" class="allfields"  id="doubleoccupancy" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $dmcroommastermain['doubleoccupancy']; ?>"/>
	</label>
	</div></td>
	<td align="left" ><div class="griddiv"><label>
	<div class="gridlable">Extra&nbsp;Bed&nbsp;(Adult)</div>
	<input name="extraBed" type="text" class="allfields"  id="extraBed" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $dmcroommastermain['extraBed']; ?>"/>
	</label>
	</div></td>
	  <td align="left" valign="middle"  ><div class="griddiv"><label>
	<div class="gridlable">Extra&nbsp;Bed&nbsp;(Child)</div>
	<input name="childwithbed" type="text" class="allfields"  id="childwithbed" maxlength="6" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $dmcroommastermain['childwithbed']; ?>"/>
	</label>
	</div></td>
	<td  align="left"><div class="griddiv"><label>
	<div class="gridlable">Child&nbsp;W/B</div>
	<input name="childwithoutbed" type="text" class="allfields"  id="childwithoutbed" maxlength="6" onkeyup="numericFilter(this);"  style="width: 80px;" value="<?php echo $dmcroommastermain['childwithoutbed']; ?>"/>
	</label>
	</div></td>

	<?php if(isRoomActive('quadroom')==true){ ?>
	<td align="left"><div class="griddiv"><label>
		<div class="gridlable">Quad Room</div>
		<input name="quadRoom" type="text" class="allfields"  id="quadRoom" value="<?php echo $dmcroommastermain['quadRoom']; ?>" maxlength="6" onkeyup="numericFilter(this);"  style="width: 80px;"/>
		</label>
		</div></td>
	<?php } ?>

	<?php if(isRoomActive('sixbedroom')==true){ ?>
		<td align="left" ><div class="griddiv"><label>
		<div class="gridlable">Six&nbsp;Bed&nbsp;Room</div>
		<input name="sixBedRoom" type="text" class="allfields"  id="sixBedRoom" value="<?php echo $dmcroommastermain['sixBedRoom']; ?>" maxlength="6" onkeyup="numericFilter(this);"  style="width: 80px;"/>
		</label>
		</div></td> 
	<?php } ?>

	<?php if(isRoomActive('eightbedroom')==true){ ?>
		<td align="left" ><div class="griddiv"><label>
		<div class="gridlable">Eight&nbsp;Bed&nbsp;Room</div>
		<input name="eightBedRoom" type="text" class="allfields"  id="eightBedRoom" value="<?php echo $dmcroommastermain['eightBedRoom']; ?>" value="<?php echo $dmcroommastermain['eightBedRoom']; ?>" maxlength="6" onkeyup="numericFilter(this);"  style="width: 80px;"/>
		</label>
		</div></td> 
	<?php } ?>
	

	
	

	<?php if(isRoomActive('tenbedroom')==true){ ?>
		<td align="left" ><div class="griddiv"><label>
		<div class="gridlable">Ten&nbsp;Bed&nbsp;Room</div>
		<input name="tenBedRoom" type="text" class="allfields"  id="tenBedRoom" value="<?php echo $dmcroommastermain['tenBedRoom']; ?>" maxlength="6" onkeyup="numericFilter(this);"  style="width:100px;"/>
		</label>
		</div></td> 
	<?php } if(isRoomActive('teenbed')==true){ ?>
	<td  align="left"><div class="griddiv"><label>
		<div class="gridlable">Teen Room</div>
		<input name="teenRoom" type="text" class="allfields"  id="teenRoom" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $dmcroommastermain['teenRoom']; ?>"/>
		</label>
		</div></td>
	<?php } ?>

	</tr> 
<tr> 
    <td  align="left"><div class="griddiv"><label>
		<div class="gridlable">Breakfast(A)</div>
		<input name="breakfast" type="text" class="allfields"  id="breakfast" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $dmcroommastermain['breakfast']; ?>"/>
		</label>
		</div></td>
    <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Lunch(A) </div>
	<input name="lunch" type="text" class="allfields"  id="lunch"  style="width: 100px;" onkeyup="numericFilter(this);" maxlength="6" value="<?php echo $dmcroommastermain['lunch']; ?>"/>
	</label>
	</div></td>

	<td align="left"><div class="griddiv"><label>
	<div class="gridlable">Dinner(A)</div>
	<input name="dinner" type="text" class="allfields"  id="dinner" maxlength="6" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $dmcroommastermain['dinner']; ?>" />
	</label>
	</div></td> 
	<td align="left" >
			<div class="griddiv"><label>
			<div class="gridlable">Breakfast(C)</div>
			<input name="breakfastChild" type="text" class="allfields"  id="breakfastChild" value="<?php echo $dmcroommastermain['childBreakfast']; ?>"  maxlength="6" onkeyup="numericFilter(this);" style="width: 100px;" />
			</label>
			</div>
		</td>
		<td align="left" valign="middle"  ><div class="griddiv"><label>
		<div class="gridlable">Lunch(C)</div>
		<input name="lunchChild" type="text" class="allfields"  id="lunchChild" value="<?php echo $dmcroommastermain['childLunch']; ?>" onkeyup="numericFilter(this);" maxlength="6" style="width: 80px;" />
		</label>
		</div></td>
	    <td align="left" valign="middle"  ><div class="griddiv"  style="width:100px;"><label>
		<div class="gridlable">Dinner(C)</div>
		<input name="dinnerChild" type="text" class="allfields" id="dinnerChild" value="<?php echo $dmcroommastermain['childDinner']; ?>" maxlength="6" onkeyup="numericFilter(this);" style="width: 80px;" />
		</label>
		</div></td>

		<td align="left">
			<div class="griddiv">
				<label>
					<div class="gridlable">TAC Type</div>
					<select name="TACTypeQ" id="TACTypeQ" class="allfields" displayname="TAC Type" autocomplete="off" style="width: 100%;">
					 	<option value="0" <?php if($dmcroommastermain['TACType']==0 || $dmcroommastermain['TACType']==''){ ?>selected="selected"<?php } ?>>%</option>
					 	<option value="1" <?php if($dmcroommastermain['TACType']==1){ ?>selected="selected"<?php } ?>>Flat</option>
					</select>
				</label>
			</div>
		</td> 

		<td align="left">
			<div class="griddiv">
				<label>
					<div class="gridlable">TAC</div>
					<input name="roomTAC" type="text" class="allfields"  id="roomTAC" maxlength="6" onkeyup="numericFilter(this);" style="width: 80px;" value="<?php echo $dmcroommastermain['roomTAC']; ?>" />
				</label>
			</div>
		</td> 

		<td align="left">
			<div class="griddiv">
				<label>
					<div class="gridlable">Markup Type</div>
					<select name="markupType" id="markupType" class="allfields validate" displayname="Markup Type" autocomplete="off" style="width: 100%;">
					 	<option value="1" <?php if($dmcroommastermain['markupType'] == 1){ ?>selected="selected"<?php } ?>>%</option>
					 	<option value="2" <?php if($dmcroommastermain['markupType'] == 2){ ?>selected="selected"<?php } ?>>Flat</option>
					</select>
				</label>
			</div>
		</td> 

		<td align="left">
			<div class="griddiv">
				<label>
					<div class="gridlable">Markup Cost</div>
					<input name="markupCost" type="text" class="allfields"  id="markupCost" maxlength="6" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $dmcroommastermain['markupCost']; ?>" />
				</label>
			</div>
		</td> 

	</tr>
</tbody></table>

<table width="100%">
			<tr>
	<td align="left" width="90%"><div class="griddiv"><label>
		<div class="gridlable">Remarks</div>
		<input name="remarks" type="text" class="allfields"  id="remarks" style="width: 93%;" value="<?php echo $dmcroommastermain['remarks']; ?>"/>
		</label>
		</div></td>

		<td align="left" width="10%" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addquohotelroomprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;margin-top: 15px;">
	  <input name="action" type="hidden" id="action" value="saveHotelNewCost"> 
	  <input name="serviceid" type="hidden" id="serviceid" value="<?php echo $_REQUEST['serviceid']; ?>"> 
	  <input name="seasonType" type="hidden" id="seasonType" value="<?php echo $queryData['seasonType']; ?>"> 
	  <?php
	  //add edit rate for room supplement
	  if($_REQUEST['isRoomSupp'] == 1 && $_REQUEST['hotelQuoteId']!=''){ ?>
	  <input name="isRoomSupp" type="hidden" id="isRoomSupp" value="<?php echo $_REQUEST['isRoomSupp']; ?>">
	  <input name="hotelQuoteId" type="hidden" id="hotelQuoteId" value="<?php echo $_REQUEST['hotelQuoteId']; ?>">
	  <?php } ?>
	  <input name="quotationId" type="hidden" id="quotationId" value="<?php echo $_REQUEST['quotationId']; ?>">
	  <input name="tariffId" type="hidden" id="tariffId" value="<?php echo $_REQUEST['tariffId']; ?>">
	  <input name="paxType" type="hidden" id="paxType" value="<?php echo ($queryData['paxType']>0)?$queryData['paxType']:'2'; ?>">
	  <input name="editId" type="hidden" id="editId" value="<?php echo $editId; ?>">
	  </td>
	  </tr>
		</table>
</form>
<br>
</div>
<script>
$(document).on("input", ".numeric", function() {
this.value = this.value.replace(/\D/g,'');
}); 
 
 $(document).ready(function() {  
$('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',
  
}); 

$('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
  pair: $('#toDate')  
});  
  });
</script> 