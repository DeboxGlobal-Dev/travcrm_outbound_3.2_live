<?php 
include "inc.php";
?>
<script src="js/jquery-1.11.3.min.js"></script> 
<?php
$select='*';   
$where='id="'.$_REQUEST['queryId'].'"';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 
$rsp="";
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($rsp);  

$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$pax = ($quotationData['adult']+$quotationData['child']);

$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discountTax = $quotationData['discount'];

//slab Date
$slabSql="";
$slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1'); 
if(mysqli_num_rows($slabSql) > 0 ){
	$slabsData=mysqli_fetch_array($slabSql);
	$slabId = $slabsData['id']; 
	$dfactor = $slabsData['dividingFactor']; 
}


$update = updatelisting(_QUOTATION_MASTER_,'isPaymentRequest=1','id="'.$_REQUEST['quotationId'].'"');

//hotels
$rsh="";
$rsh=GetPageRecord('*','finalQuote',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($rsh) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
			<th align="left" bgcolor="#ddd">Service Type : Hotel</th>
	    </tr>
	</thead>
	<tbody > 
	<?php
	if($quotationData['quotationType'] == 2){ 
		$singQuery = " and categoryId='".$quotationData['finalcategory']."'";
	}else{
		$singQuery = "";
	} 
 	while($finalQuoteData=mysqli_fetch_array($rsh)){ 
	
		$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$finalQuoteData['hotelId'].'"');   
		$hotelData=mysqli_fetch_array($d); 
		//check if supplier is self 


		//final
		$singleoccupancy=$finalQuoteData['roomSingleCost'];
		$doubleoccupancy=$finalQuoteData['roomDoubleCost'];
		$tripleoccupancy=$finalQuoteData['roomTripleCost'];
		$twinoccupancy=$finalQuoteData['roomTwinCost'];
		$roomEBedACost=$finalQuoteData['roomEBedACost'];
		$roomEBedCCost=$finalQuoteData['roomEBedCCost'];
		$roomENBedCCost=$finalQuoteData['roomENBedCCost'];
		$sixBedRoomCost=$finalQuoteData['sixBedRoomCost'];
		$eightBedRoomCost=$finalQuoteData['eightBedRoomCost'];
		$tenBedRoomCost=$finalQuoteData['tenBedRoomCost'];
		$quadRoomCost=$finalQuoteData['quadRoomCost'];
		$teenRoomCost=$finalQuoteData['teenRoomCost'];

		$roomSingle=$finalQuoteData['roomSingle'];
		$roomDouble=$finalQuoteData['roomDouble'];
		$roomTriple=$finalQuoteData['roomTriple']; 
		$roomTwin=$finalQuoteData['roomTwin']; 
		$roomEBedA=$finalQuoteData['roomEBedA']; 
		$roomEBedC=$finalQuoteData['roomEBedC']; 
		$roomENBedC=$finalQuoteData['roomENBedC']; 
		$sixNoofBedRoom=$finalQuoteData['sixNoofBedRoom']; 
		$eightNoofBedRoom=$finalQuoteData['eightNoofBedRoom']; 
		$tenNoofBedRoom=$finalQuoteData['tenNoofBedRoom']; 
		$quadNoofRoom=$finalQuoteData['quadNoofRoom']; 
		$teenNoofRoom=$finalQuoteData['teenNoofRoom']; 

		
		//quote
		$singleoccupancy2=$finalQuoteData['roomSingleCost2'];
		$doubleoccupancy2=$finalQuoteData['roomDoubleCost2'];
		$tripleoccupancy2=$finalQuoteData['roomTripleCost2'];
		$twinoccupancy2=$finalQuoteData['roomTwinCost2'];
		$roomEBedACost2=$finalQuoteData['roomEBedACost2'];
		$roomEBedCCost2=$finalQuoteData['roomEBedCCost2'];
		$roomENBedCCost2=$finalQuoteData['roomENBedCCost2'];
		$sixBedRoomCost2=$finalQuoteData['sixBedRoomCost'];
		$eightBedRoomCost2=$finalQuoteData['eightBedRoomCost'];
		$tenBedRoomCost2=$finalQuoteData['tenBedRoomCost'];
		$quadRoomCost2=$finalQuoteData['quadRoomCost'];
		$teenRoomCost2=$finalQuoteData['teenRoomCost'];
		 
		$roomSingle2=$finalQuoteData['roomSingle2'];
		$roomDouble2=$finalQuoteData['roomDouble2'];
		$roomTriple2=$finalQuoteData['roomTriple2'];
		$roomTwin2=$finalQuoteData['roomTwin2']; 
		$roomEBedA2=$finalQuoteData['roomEBedA2']; 
		$roomEBedC2=$finalQuoteData['roomEBedC2']; 
		$roomENBedC2=$finalQuoteData['roomENBedC2']; 

		$sixNoofBedRoom2=$finalQuoteData['sixNoofBedRoom']; 
		$eightNoofBedRoom2=$finalQuoteData['eightNoofBedRoom']; 
		$tenNoofBedRoom2=$finalQuoteData['tenNoofBedRoom']; 
		$quadNoofRoom2=$finalQuoteData['quadNoofRoom']; 
		$teenNoofRoom2=$finalQuoteData['teenNoofRoom']; 
		
		$approvedBy=$finalQuoteData['approvedBy'];
		$approvedDate=$finalQuoteData['approvedDate'];		

		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		if($finalQuoteData['followupDate'] == "0" || $finalQuoteData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime($finalQuoteData['followupDate']));
			$followupTime = date("H:i",strtotime($finalQuoteData['followupDate']));
		}
	 
	 	$rs121=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalQuoteData['roomType'].'"'); 
		$editresult21=mysqli_fetch_array($rs121);
		$rtype=$editresult21['name'];
		
		$nightstay=0;
		$hotelDates = date('j M Y',strtotime($finalQuoteData['fromDate']));
					
		if($finalQuoteData['supplierId']!='' && $finalQuoteData['supplierId']!=0){
			$supplierId = $finalQuoteData['supplierId'];
		}else{
			$supplierId = $finalQuoteData['supplierMasterId'];
		}
		$hcity = strip($hotelData['hotelCity']);
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		
		$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalQuoteData['mealPlanId'].'"'); 
		$mealplanD=mysqli_fetch_array($rssda24); 
		$mealplan = $mealplanD['name'];
		// .'-'.$mealplan['subname']

		$rssda25=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'id="'.$hotelData['hotelCategoryId'].'"'); 
		$hotelCategoryD=mysqli_fetch_array($rssda25); 
		
		// if($finalQuoteData['isLocalEscort']==1){
	 //        $hotelTypeLable = "Local Escort,";
	 //    }
	 //    if($finalQuoteData['isForeignEscort']==1){
	 //        $hotelTypeLable = "Foreign Escort,";
	 //    }
	 //    if($finalQuoteData['isGuestType']==1){
	 //        $hotelTypeLable = "Guest,";
	 //    }
	 
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
		<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px; position:relative;">
		<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
		<tbody>
		<tr>
		<td width="30%"  bgcolor="#F4F4F4">
		<input name="hidden" type="hidden" id="hotelSupplier<?php echo $finalQuoteData['id']; ?>" value="<?php echo $supplierId;?>">
		<input name="hidden" type="hidden" id="hotelfinalId<?php echo $finalQuoteData['id']; ?>" value="<?php echo $finalQuoteData['id'];?>">
		  <!-- <strong><?php echo rtrim($hotelTypeLable,',')." Hotel:-"; ?></strong><br> -->
		<?php echo strip($hotelData['hotelName']);?>&nbsp;(&nbsp;<?php echo $hcity = strip($hotelData['hotelCity']);  ?>&nbsp;)&nbsp;|&nbsp;<?php echo trim($hotelCategoryD['hotelCategory']).' Star';   ?>
		</td>
		<td width="15%"  bgcolor="#F4F4F4"><div style="font-size:12px;"><strong>Room&nbsp;Type:</strong><br><?php echo $rtype; ?></div></td>
		<td width="10%"  bgcolor="#F4F4F4"><div style="font-size:12px;"><strong>Meal&nbsp;Plan:</strong><br><?php echo $mealplan; ?></div></td>
		<td width="30%" colspan="2" bgcolor="#F4F4F4"><div style="font-size:12px;"><strong>Supplier&nbsp;Name:</strong><br><?php echo $supplierData['name'].' - ['.$supplierData['supplierNumber'].']';   ?></div></td>
		<td width="15%"  bgcolor="#F4F4F4"><span style="font-size:12px;"><strong>Date:</strong><br><?php echo $hotelDates;	?></span> </td>
		</tr>
		</tbody>
		</table>
		</div>
		
	    <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
			<thead style="font-weight:500;">
			<tr>
			  <th width="80" bgcolor="#F4F4F4">
			  	<div id="manualStatusId<?php echo $finalQuoteData['id']; ?>" style="display:none;color: #009900;">Updated</div>
			  </th>
			  <th width="150" align="center" bgcolor="#F4F4F4">Single</th>
			  <th width="150" align="center" bgcolor="#F4F4F4">Double</th>
			  <th width="150" align="center" bgcolor="#F4F4F4">Triple</th> 
			  <th width="150" align="center" bgcolor="#F4F4F4">Twin</th>
			  <th width="150" align="center" bgcolor="#F4F4F4">ExtraBed</th>
			  <?php if($quadNoofRoom>0){?>
			  <th width="150" align="center" bgcolor="#F4F4F4">Quad</th>
			  <?php } if($teenNoofRoom>0){?>
			  <th width="150" align="center" bgcolor="#F4F4F4">Teen</th>
			  <?php }  if($roomEBedC>0){ ?>
			  <th width="150" align="center" bgcolor="#F4F4F4">ChildWB</th>
				<?php }  if($roomENBedC>0){ ?>
			  <th width="150" align="center" bgcolor="#F4F4F4">ChildNB</th>
			  <?php } if($sixNoofBedRoom>0){ ?>
			  <th width="150" align="center" bgcolor="#F4F4F4">SixBed</th>
			  <?php } if($eightNoofBedRoom>0){?>
			  <th width="150" align="center" bgcolor="#F4F4F4">EightBed</th>
			  <?php } if($tenNoofBedRoom>0){?>
			  <th width="150" align="center" bgcolor="#F4F4F4">TenBed</th>
			  <?php } ?>
			</tr>
			</thead> 
			<tbody class="ui-sortable">
				<tr>
				  <td >&nbsp;</td>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
					
				<?php if($quadNoofRoom>0){?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php } if($teenNoofRoom>0){?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php }  if($roomEBedC>0){ ?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php }  if($roomENBedC>0){ ?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php } if($sixNoofBedRoom>0){ ?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php } if($eightNoofBedRoom>0){ ?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php } if($tenNoofBedRoom>0){ ?>
				  <td ><span style="float:left;font-size:12px">Price</span>&nbsp;&nbsp;<span style="float:right;font-size:12px">Rooms</span></td> 
				  <?php } ?>		
			  </tr>
				<tr>
				<td >Quote&nbsp;Price</td>
				<td  align="center" >				
					<input type="number" min="0" class="gridfield" id="roomsinglecost2<?php echo $finalQuoteData['id']; ?>" value="<?php echo $singleoccupancy2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;padding:8px 5px;" disabled  onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">
					<input type="text" min="0" class="gridfield"   value="<?php echo $roomSingle2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block;padding:8px 5px;" placeholder="0" disabled onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" >					  
				</td>
				<td  align="center" >
					<input type="number" min="0" class="gridfield" id="roomdoublecost2<?php echo $finalQuoteData['id']; ?>" value="<?php echo $doubleoccupancy2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block; padding:8px 5px;" disabled onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">
					<input   type="text" min="0" class="gridfield"   value="<?php echo $roomDouble2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');"/>						
				</td>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomtriplecost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $tripleoccupancy2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield"   value="<?php echo $roomTriple2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />			
				</td>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomtwincost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $twinoccupancy2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $roomTwin2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomEBedACost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomEBedACost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $roomEBedA2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php if($quadNoofRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="quadRoomCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $quadRoomCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $quadNoofRoom2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php } if($teenNoofRoom>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="teenRoomCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $teenRoomCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $teenNoofRoom2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				
				<?php }  if($roomEBedC>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomEBedCCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomEBedCCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $roomEBedC2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php }  if($roomENBedC>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomENBedCCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomENBedCCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $roomENBedC2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php } if($sixNoofBedRoom>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="sixBedRoomCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $sixBedRoomCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $sixNoofBedRoom2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php } if($eightNoofBedRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="eightBedRoomCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $eightBedRoomCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $eightNoofBedRoom2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php } if($tenNoofBedRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="tenBedRoomCost2<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $tenBedRoomCost2; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" disabled >	
					<input   type="text" min="0" class="gridfield" value="<?php echo $tenNoofBedRoom2; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" disabled />						
				</td>
				<?php } ?>
			</tr>
				</td> 
			<tr>
				<td >Final&nbsp;Price</td>
				<td  align="center" >
					<input   type="text" min="0" class="gridfield numeric" id="roomsinglecost<?php echo $finalQuoteData['id']; ?>" value="<?php echo $singleoccupancy; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">
					<input  type="text" min="0" class="gridfield numeric" id="roomsingle<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomSingle; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block;padding:8px 5px;" placeholder="0"  onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" >						
				</td>
				<td  align="center" >	
					<input  type="text" min="0" class="gridfield numeric" id="roomdoublecost<?php echo $finalQuoteData['id']; ?>" value="<?php echo $doubleoccupancy; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block; padding:8px 5px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">
					<input   type="text" min="0" class="gridfield numeric"  id="roomdouble<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomDouble; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0"  onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>
				<td  align="center" >
					<input type="text" min="0"  class="gridfield numeric" id="roomtriplecost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $tripleoccupancy; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield numeric"  id="roomtriple<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomTriple; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0"   onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td> 
				<td  align="center" >
					<input type="text" min="0"  class="gridfield numeric" id="roomtwincost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $twinoccupancy; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield numeric"  id="roomtwin<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomTwin; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0"   onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomEBedACost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomEBedACost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield" id="roomEBedA<?php echo $finalQuoteData['id']; ?>" value="<?php echo $roomEBedA; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">						
				</td>
				<?php if($quadNoofRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="quadRoomCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $quadRoomCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield" id="quadNoofRoom<?php echo $finalQuoteData['id']; ?>" value="<?php echo $quadNoofRoom; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" >						
				</td>
				<?php } if($teenNoofRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="teenRoomCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $teenRoomCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield" id="teenNoofRoom<?php echo $finalQuoteData['id']; ?>" value="<?php echo $teenNoofRoom; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>

				<?php }  if($roomEBedC>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomEBedCCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomEBedCCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield" id="roomEBedC<?php echo $finalQuoteData['id']; ?>" value="<?php echo $roomEBedC; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');"/>						
				</td>
				<?php }  if($roomENBedC>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="roomENBedCCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $roomENBedCCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield" id="roomENBedC<?php echo $finalQuoteData['id']; ?>" value="<?php echo $roomENBedC; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>
				<?php } if($sixNoofBedRoom>0){ ?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="sixBedRoomCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $sixBedRoomCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');">	
					<input   type="text" min="0" class="gridfield" id="sixNoofBedRoom<?php echo $finalQuoteData['id']; ?>" value="<?php echo $sixNoofBedRoom; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>
				<?php } if($eightNoofBedRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="eightBedRoomCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $eightBedRoomCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" >	
					<input   type="text" min="0" class="gridfield" id="eightNoofBedRoom<?php echo $finalQuoteData['id']; ?>" value="<?php echo $eightNoofBedRoom; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>
				<?php } if($tenNoofBedRoom>0){?>
				<td align="center" >
					<input type="number" min="0"  class="gridfield" id="tenBedRoomCost<?php echo $finalQuoteData['id']; ?>"  value="<?php echo $tenBedRoomCost; ?>" maxlength="100" style="text-align:center; width:50%;display:inline-block;  padding:8px 5px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" >	
					<input   type="text" min="0" class="gridfield" id="tenNoofBedRoom<?php echo $finalQuoteData['id']; ?>" value="<?php echo $tenNoofBedRoom; ?>" maxlength="100" style="text-align:center; width:20%;display:inline-block; padding:8px 5px;" placeholder="0" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" />						
				</td>
				<?php } ?>
		  </tr>
			<tr>
				<td align="left" colspan="2">Approved By</td> 
				<td  colspan="2"><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px 5px;" placeholder="Full Name" onkeyup="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" /></td>
				<td align="left">Approved Date</td> 
				<td ><input  type="date" class="gridfield"  id="approvedDate<?php echo $finalQuoteData['id']; ?>" value="<?php if($approvedDate>0){  echo date('Y-m-d',strtotime($approvedDate)); }else{ echo date('Y-m-d'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;width: -webkit-fill-available; " placeholder="Approved Date" onchange="updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');" min="2020-01-01" max="2030-12-31" /></td>
			</tr> 
		</tbody>
	  </table>
	
			<script>
				jQuery(document).ready(function($){
					updateFinalQuote_hotel('<?php echo $finalQuoteData['id']; ?>','<?php echo $finalQuoteData['supplierId']; ?>');
				});
			</script>			
  	</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}

//transfers
$c="";
$c=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($c) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Transport</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){ 
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	 

	$vehicleCost= 0;	
	$vehicleCost2= 0; 
		
 	while($finalQuotetransfer=mysqli_fetch_array($c)){

		// hotel data
		$d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$finalQuotetransfer['transferId'].'"');   
		$transferData=mysqli_fetch_array($d);


		$supplierId='';
		$vehicleCost = $vehicleCost2 = trim($finalQuotetransfer['vehicleCost']); 
 		
		$supplierId = $finalQuotetransfer['supplierId'];
		$transferId = $finalQuotetransfer['transferId'];
		
		if(strtotime($finalQuotetransfer['fromDate']) == strtotime($finalQuotetransfer['toDate'])){ 
			$transferDates = date('d M, Y',strtotime($finalQuotetransfer['fromDate'])); 
		}else{ 
			$transferDates = date('d',strtotime($finalQuotetransfer['fromDate']))."-".date('d M, Y',strtotime($finalQuotetransfer['toDate']));
		} 

		if($finalQuotetransfer['followupDate'] == "0" || $finalQuotetransfer['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuotetransfer['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuotetransfer['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuotetransfer['followupDate']));
		}
		
		// noOfVehicles
		$approvedBy=$finalQuotetransfer['approvedBy'];
		$approvedDate=$finalQuotetransfer['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		$noOfVehicles= trim($finalQuotetransfer['noOfVehicles']);

		$vehicleCost= trim($finalQuotetransfer['vehicleCost']);
		$vehicleCost2= trim($finalQuotetransfer['vehicleCost2']);
	
		$adultCost= trim($finalQuotetransfer['adultCost']);
		$adultCost2= trim($finalQuotetransfer['adultCost2']);
	
		$childCost= trim($finalQuotetransfer['childCost']);
		$childCost2= trim($finalQuotetransfer['childCost2']);
	
		$infantCost= trim($finalQuotetransfer['infantCost']);
		$infantCost2= trim($finalQuotetransfer['infantCost2']);
	
		if($finalQuotetransfer['supplierId']!='' && $finalQuotetransfer['supplierId']!=0){
			$supplierId = $finalQuotetransfer['supplierId'];
		}
		$Ecity = getDestination($finalQuotetransfer['destinationId']);
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		
		//check if supplier is self
		$vehicleName = $vehicleType = $transferType = '';
		if($finalQuotetransfer['transferType'] == 2){

		    $d=GetPageRecord('*','vehicleMaster','id="'.$finalQuotetransfer['vehicleModelId'].'"'); 
		    $vehicleData=mysqli_fetch_array($d);

			$vehicleName = $vehicleData['model'];
			$vehicleType = getVehicleTypeName($vehicleData['carType']);
		}
		$transferType = ($finalQuotetransfer['transferType'] == 1)?'SIC':'Private';

		
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  	<td width="50%"  bgcolor="#F4F4F4">
					  	<input type="hidden" value="<?php echo $finalQuotetransfer['transferType'];?>" id="transferType<?php echo $finalQuotetransfer['id']; ?>">
					  	<input type="hidden" value="<?php echo $finalQuotetransfer['id'];?>" id="transferfinalId<?php echo $finalQuotetransfer['id']; ?>">
						<input type="hidden" value="<?php echo $transferData['id'];?>" id="transferId<?php echo $finalQuotetransfer['id']; ?>">
						<input type="hidden" value="<?php echo $supplierId;?>" id="transferSupplier<?php echo $finalQuotetransfer['id']; ?>">
						<strong>Transport&nbsp;Name:</strong><br>
					  	<?php echo ucfirst($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)
					</td>
					<td width="10%"  align="left" bgcolor="#F4F4F4"><strong>Transfer&nbsp;Type:</strong><br><span style="font-size:12px;"><?php echo $transferType; ?></span></td> 
 				  	<td width="10%"  bgcolor="#F4F4F4"><strong>Date:</strong><br><span style="font-size:12px;"><?php echo $transferDates; ?></span>
 				  	</td>
 				  	<td width="30%"  bgcolor="#F4F4F4"><strong>Supplier&nbsp;Name:</strong><br><span style="font-size:12px;"><?php echo $supplierData['name'].' - ['.$supplierData['supplierNumber'].']'; ?></span>
 				  	</td> 
			  	  	
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="97" bgcolor="#F4F4F4">&nbsp; </th>
				<?php if($finalQuotetransfer['transferType'] == 2){ ?>
				  <th bgcolor="#F4F4F4">Vehicle&nbsp;Name</th>
				  <th bgcolor="#F4F4F4">Vehicle&nbsp;Type</th>
				  <th bgcolor="#F4F4F4">Vehicle&nbsp;Cost(Per Vehicle)</th>
				<?php }else{ ?> 
				  <th bgcolor="#F4F4F4">Adult&nbsp;Cost</th>
				  <th bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				<?php } ?>
 			   </tr>
			</thead> 
			<tbody class="ui-sortable"> 	 
			<tr>
				<td >Quote&nbsp;Price</td>
				<?php if($finalQuotetransfer['transferType'] == 2){ ?>
				<td rowspan="2" align="center" ><?php echo $vehicleName; ?></td>
			  	<td rowspan="2" align="center"><?php echo $vehicleType; ?></td>
			  	<td align="center">				
					<input type="number" min="0" class="gridfield" id="vehicleCost2<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $vehicleCost2; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" disabled  >		
				</td>
				<?php }else{ ?> 
				<td align="center">				
					<input type="number" min="0" class="gridfield" id="adultCost2<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $adultCost2; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" disabled  >		
				</td>
				<td align="center">				
					<input type="number" min="0" class="gridfield" id="childCost2<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $childCost2; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" disabled  >		
				</td>
				<td align="center" >				
					<input type="number" min="0" class="gridfield" id="infantCost2<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $infantCost2; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" disabled  >		
				</td>
				<?php } ?>
			  </tr> 
			<tr>
				<td >Final&nbsp;Price</td>
				<?php if($finalQuotetransfer['transferType'] == 2){ ?>
				<td align="center">				
					<input type="number" min="0" class="gridfield" id="vehicleCost<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $vehicleCost; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['transferId']; ?>');">					
				</td>
				<?php }else{ ?> 
				<td align="center">				
					<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['transferId']; ?>');">		
				</td>
				<td align="center">				
					<input type="number" min="0" class="gridfield" id="childCost<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['transferId']; ?>');">		
				</td>
				<td align="center" >				
					<input type="number" min="0" class="gridfield" id="infantCost<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:90%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['transferId']; ?>');">		
				</td>
				<?php } ?>

			</tr>
			<tr>
				<td align="right">Approved By</td> 
				<td >
					<input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuotetransfer['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['transferId']; ?>');" />
				</td>
				<td align="left">Approved Date</td> 
				<td >
					<input  type="date" class="gridfield"  id="approvedDate<?php echo $finalQuotetransfer['id']; ?>" value="<?php echo date('Y-m-d',strtotime($approvedDate)); ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;width: -webkit-fill-available; " placeholder="Approved Date" onchange="updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['supplierId']; ?>');" min="2020-01-01" max="2030-12-31" />
				</td>
			</tr> 
		</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_transfer('<?php echo $finalQuotetransfer['id']; ?>','<?php echo $finalQuotetransfer['transferId']; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}

//entrance
$b="";
$b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($b) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Entrance</th>
		</tr>
	</thead>
	<tbody >
	
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
 	while($finalEntranceData=mysqli_fetch_array($b)){ 
		
		$d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$finalEntranceData['entranceId'].'"');   
		$entranceData=mysqli_fetch_array($d);
		
		$supplierId = $finalEntranceData['supplierId'];
		$entranceId = $finalEntranceData['entranceId'];
		
		if($finalEntranceData['followupDate'] == "0" || $finalEntranceData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalEntranceData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalEntranceData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalEntranceData['followupDate']));
		}
	
		$approvedBy=$finalEntranceData['approvedBy'];
		$approvedDate=$finalEntranceData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
		$ticketAdultCost2= $finalEntranceData['ticketAdultCost2'];
		$ticketchildCost2= $finalEntranceData['ticketchildCost2'];
		$ticketinfantCost2= $finalEntranceData['ticketinfantCost2'];

		$ticketAdultCost= $finalEntranceData['ticketAdultCost'];
		$ticketchildCost= $finalEntranceData['ticketchildCost'];
		$ticketinfantCost= $finalEntranceData['ticketinfantCost'];

		$adultCost2= $finalEntranceData['adultCost2'];
		$childCost2= $finalEntranceData['childCost2'];
		$infantCost2= $finalEntranceData['infantCost2'];

		$adultCost= $finalEntranceData['adultCost'];
		$childCost= $finalEntranceData['childCost'];
		$infantCost= $finalEntranceData['infantCost'];

		$vehicleCost2= $finalEntranceData['vehicleCost2'];
		$vehicleCost= $finalEntranceData['vehicleCost'];

		$repCost2= $finalEntranceData['repCost2'];
		$repCost= $finalEntranceData['repCost'];

		if(strtotime($finalEntranceData['fromDate']) == strtotime($finalEntranceData['toDate'])){ 
			$entranceDates = date('d M, Y',strtotime($finalEntranceData['fromDate'])); 
		}else{ 
			$entranceDates = date('d',strtotime($finalEntranceData['fromDate']))."-".date('d M, Y',strtotime($finalEntranceData['toDate']));
		}
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		
		$Ecity = strip($entranceData['entranceCity']);	

		//check if supplier is self
		$vehicleName = $vehicleType = $transferType = '';
		if($finalEntranceData['transferType'] == 2){

	        $d=GetPageRecord('*','vehicleMaster','id="'.$finalEntranceData['vehicleId'].'"'); 
	        $vehicleData=mysqli_fetch_array($d);

			$vehicleName = $vehicleData['model']." | ";
			$vehicleType = getVehicleTypeName($vehicleData['carType']);
		}
		$transferType = ($finalEntranceData['transferType'] == 1)?'SIC':'Private';
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  	<td width="50%"  bgcolor="#F4F4F4">
					  <input type="hidden" value="<?php echo $finalEntranceData['transferType'];?>" id="entTransferType<?php echo $finalEntranceData['id']; ?>">
					  <input type="hidden" value="<?php echo $finalEntranceData['id'];?>" id="entrancefinalId<?php echo $finalEntranceData['id']; ?>">
					  <input type="hidden" value="<?php echo $entranceData['id'];?>" id="entranceId<?php echo $finalEntranceData['id']; ?>"> 
					  <input type="hidden" value="<?php echo $supplierId;?>" id="entranceSupplier<?php echo $finalEntranceData['id']; ?>">
					  <strong>Entrance&nbsp;Name:</strong><br>
					  <?php echo strip($entranceData['entranceName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($entranceData['entranceCity']);  ?>&nbsp;)
					</td>
 				  	<td width="10%"  bgcolor="#F4F4F4"><strong>Transfer&nbsp;Type:</strong><br>
				  		<span style="margin-bottom:10px; font-size:12px;"><?php echo $entranceDates; ?></span>
				  	</td> 
				  	<td width="10%"  bgcolor="#F4F4F4"><strong>Date:</strong><br>
				  		<span style="margin-bottom:10px; font-size:12px;"><?php echo $transferType; ?></span>
				  	</td> 
				   	<td width="30%"  bgcolor="#F4F4F4"><strong>Supplier&nbsp;Name:</strong><br>
				  		<span style="margin-bottom:10px; font-size:12px;"><?php echo $supplierData['name'].' - ['.$supplierData['supplierNumber'].']'; ?></span>
				  	</td> 				  
				  </tr>
				</tbody>
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="200px" bgcolor="#F4F4F4">Ticket&nbsp;Adult&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Ticket&nbsp;Child&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Ticket&nbsp;Infant&nbsp;Cost</th>
				  <?php if($finalEntranceData['transferType'] == 1){ ?>
				  <th width="200px" bgcolor="#F4F4F4">Adult&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				  <?php }else{ ?>
				  <th width="200px" bgcolor="#F4F4F4">Vehicle&nbsp;Name</th>
				  <th width="200px" bgcolor="#F4F4F4">Vehicle&nbsp;Cost</th>
				  <?php } ?>
				  <th width="200px" bgcolor="#F4F4F4">Rep.&nbsp;Cost</th>
				  </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" value="<?php echo trim($ticketAdultCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($ticketchildCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($ticketinfantCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>
					<?php if($finalEntranceData['transferType'] == 1){ ?>
					<td >				
						<input type="number" min="0" class="gridfield" value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>	
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>	
					<?php }else{ ?>		
					<td rowspan="2" align="center">				
						<?php echo $vehicleName.$vehicleType; ?>
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($vehicleCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>
					<?php } ?>	
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($repCost2); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;" disabled  >					
					</td>
				</tr> 
				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="ticketAdultCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($ticketAdultCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  id="ticketchildCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($ticketchildCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  id="ticketinfantCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($ticketinfantCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>
					<?php if($finalEntranceData['transferType'] == 1){ ?>
					<td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($adultCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  id="childCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($childCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>	
					<td >				
						<input type="number" min="0" class="gridfield"  id="infantCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($infantCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>	
					<?php }else{ ?>		
					<td >				
						<input type="number" min="0" class="gridfield"  id="vehicleCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($vehicleCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>
					<?php } ?>	
					<td >				
						<input type="number" min="0" class="gridfield"  id="repCost<?php echo $finalEntranceData['id']; ?>"  value="<?php echo trim($repCost); ?>" maxlength="100" style="text-align:center; width:80%;display:inline-block;padding:8px;"  <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');">					
					</td>
				  </tr>
				<tr>
				<td colspan="3" align="left">Approved By/Date</td> 
				<td colspan="4"  ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalEntranceData['id']; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;"  onKeyUp="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');" value="<?php echo $approvedBy; ?>" placeholder="Full Name" <?php if($finalEntranceData['shareQuoteStatus']==2){ ?> <?php } ?> /></td>
				<td ><input  type="date" class="gridfield"  id="approvedDate<?php echo $finalEntranceData['id']; ?>" value="<?php echo date('Y-m-d',strtotime($approvedDate)); ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;width: -webkit-fill-available; " placeholder="Approved Date" onchange="updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');" min="2020-01-01" max="2030-12-31" /></td>
 				</tr> 				 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				// updateFinalQuote_entrance('<?php echo $finalEntranceData['id']; ?>','<?php echo $finalEntranceData['entranceId']; ?>');
			});
			</script>			
		</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}

//Ferry
$b="";
$b=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($b) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Ferry</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
 	while($finalFerryData=mysqli_fetch_array($b)){ 
		
		$d=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$finalFerryData['ferryId'].'"');   
		$ferryServiceData=mysqli_fetch_array($d);
		
		$supplierId = $finalFerryData['supplierId'];
		$ferryId = $ferryServiceData['id'];
		
		if($finalFerryData['followupDate'] == "0" || $finalFerryData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalFerryData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalFerryData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalFerryData['followupDate']));
		}
		$approvedBy=$finalFerryData['approvedBy'];
		$approvedDate=$finalFerryData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
	
		$adultCost2= $finalFerryData['adultCost2'];
		$childCost2= $finalFerryData['childCost2'];
		$infantCost2= $finalFerryData['infantCost2'];
		$processingfee2= $finalFerryData['processingfee2'];
		$miscCost2= $finalFerryData['miscCost2'];

		$adultCost= $finalFerryData['adultCost'];
		$childCost= $finalFerryData['childCost'];
		$infantCost= $finalFerryData['infantCost'];
		$processingfee= $finalFerryData['processingfee'];
		$miscCost= $finalFerryData['miscCost'];

		if(strtotime($finalFerryData['fromDate']) == strtotime($finalFerryData['toDate'])){ 
			$ferryDates = date('d M, Y',strtotime($finalFerryData['fromDate'])); 
		}else{ 
			$ferryDates = date('d',strtotime($finalFerryData['fromDate']))."-".date('d M, Y',strtotime($finalFerryData['toDate']));
		}
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		
		$Ecity = getDestination($finalFerryData['destinationId']);		 
	?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  <input type="hidden" value="<?php echo $finalFerryData['id'];?>" id="ferryfinalId<?php echo $finalFerryData['id']; ?>">
				  <input type="hidden" value="<?php echo $ferryServiceData['id'];?>" id="ferryId<?php echo $finalFerryData['id']; ?>"> 
				  <input type="hidden" value="<?php echo $supplierId;?>" id="ferrySupplier<?php echo $finalFerryData['id']; ?>">
				  <strong>FerryService&nbsp;Name:</strong><br>
				  <?php echo strip($ferryServiceData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
 				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br>
				  <span style="margin-bottom:10px; font-size:12px;"><?php echo $ferryDates; ?></span></td> 

				   <td width="16%"  bgcolor="#F4F4F4"><strong>Supplier&nbsp;Name:</strong><br>
				  <span style="margin-bottom:10px; font-size:12px;"><?php echo $supplierData['name'].' - ['.$supplierData['supplierNumber'].']'; ?></span></td> 				  

				  </tr>
				</tbody>
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="200px" bgcolor="#F4F4F4">Adult&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Proce.&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Misc.&nbsp;Cost</th>
				  </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($processingfee2); ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($miscCost2); ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
				  </tr>  

				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalFerryData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="childCost<?php echo $finalFerryData['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="infantCost<?php echo $finalFerryData['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="processingfee<?php echo $finalFerryData['id']; ?>" value="<?php echo $processingfee; ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="miscCost<?php echo $finalFerryData['id']; ?>" value="<?php echo $miscCost; ?>" maxlength="100" style="text-align:center; width:85%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');">					
					</td>
						
				  </tr>
				<tr>
				<td colspan="2" align="left">Approved By/Date <?php echo $approvedDate; ?></td> 
				<td  colspan="3" ><input  type="text" class="gridfield" id="approvedBy<?php echo $finalFerryData['id']; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;"  onKeyUp="updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');" value="<?php echo $approvedBy; ?>" placeholder="Full Name" <?php if($finalFerryData['shareQuoteStatus']==2){ ?> <?php } ?> /></td>
				<td><input type="date" class="gridfield" id="approvedDate<?php echo $finalFerryData['id']; ?>" value="<?php echo date('Y-m-d',strtotime($approvedDate)); ?>"  style="text-align:left;width:96%;padding: 3px;border-radius: 2px;width: -webkit-fill-available; " placeholder="Approved Date" onchange="updateFinalQuote_entrance('<?php echo $finalFerryData['id']; ?>','<?php echo $finalFerryData['ferryId']; ?>');" min="2020-01-01" max="2030-12-31"></td>

 				</tr> 				 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_ferry('<?php echo $finalFerryData['id']; ?>','<?php echo $ferryId; ?>');
			});
			</script>			
		</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}

//activities
$actQuery="";
$actQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($actQuery) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Activity <?php //echo mysqli_num_rows($d);?></th>
		</tr>
	</thead>
	<tbody >
	
	<?php 
	while($finalActivityData=mysqli_fetch_array($actQuery)){
 		
		$d=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$finalActivityData['activityId'].'"');   
		$activityData=mysqli_fetch_array($d);
		$activityId = $activityData['id'];
		 
		$activityCost=$finalActivityData['activityCost'];
		$maxpax=$finalActivityData['maxpax'];
		$perPaxCost=$finalActivityData['perPaxCost'];

		$activityCost2=$finalActivityData['activityCost2'];
		$maxpax2=$finalActivityData['maxpax2'];
		$perPaxCost2=$finalActivityData['perPaxCost2'];
		
		
		if(strtotime($finalActivityData['fromDate']) == strtotime($finalActivityData['toDate'])){ 
			$activityDates = date('d M, Y',strtotime($finalActivityData['fromDate'])); 
		}else{ 
			$activityDates = date('d',strtotime($finalActivityData['fromDate']))."-".date('d M, Y',strtotime($finalActivityData['toDate']));
		}
		
	
		$approvedBy=$finalActivityData['approvedBy'];
		$approvedDate=$finalActivityData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		if($finalActivityData['followupDate'] == "0" || $finalActivityData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalActivityData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalActivityData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalActivityData['followupDate']));
		}

		if($finalActivityData['supplierId'] > 0){
			$supplierId = $finalActivityData['supplierId'];
		}
		
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 

		$Ecity = strip($activityData['otherActivityCity']);
 
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				  <tr>
					<td width="23%"  bgcolor="#F4F4F4">
					<input type="hidden" value="<?php echo $finalActivityData['id'];?>" id="activityfinalId<?php echo $finalActivityData['id']; ?>">
					<input type="hidden" value="<?php echo $activityData['id'];?>" id="activityId<?php echo $finalActivityData['id']; ?>">
					<input type="hidden" value="<?php echo $supplierId;?>" id="activitySupplier<?php echo $finalActivityData['id']; ?>">
					<strong>Activity Name:</strong><br>
					<?php echo $finalActivityData['id']; echo strip($activityData['otherActivityName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($activityData['otherActivityCity']);  ?>&nbsp;)
					</td>
				    <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><strong>Date:</strong><br>
					<?php echo $activityDates; ?></span></td>
					<td width="16%"  bgcolor="#F4F4F4"><strong>Supplier&nbsp;Name:</strong><br>
				<span style="margin-bottom:10px; font-size:12px;"><?php echo $supplierData['name'].' - ['.$supplierData['supplierNumber'].']'; ?></span></td>
				  <?php if($finalActivityData['shareQuoteStatus'] != 2){ ?>
				  <td width="15%"  align="left" bgcolor="#F4F4F4">&nbsp;</td>
				  <td width="13%"  align="left" bgcolor="#F4F4F4">&nbsp;</td>
				  <td width="13%"  align="left" bgcolor="#F4F4F4">&nbsp;</td>
				  <?php } ?>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="200px" bgcolor="#F4F4F4">Total&nbsp;Activity&nbsp;Cost</th>
				  <th width="200px" bgcolor="#F4F4F4">Max&nbsp;pax</th>
				  <th width="200px" bgcolor="#F4F4F4">Per&nbsp;Pax&nbsp;Cost</th>
			   </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  <td >Quote&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($activityCost2); ?>" maxlength="100" style="text-align:center; width:93%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');"> 
					</td>
					<td >
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($maxpax2); ?>" maxlength="100" style="text-align:center; width:93%;display:inline-block; padding:8px;" disabled onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');">
					</td>
					<td >
						<input type="number" min="0" class="gridfield" value="<?php echo trim($perPaxCost2); ?>" maxlength="100" style="text-align:center; width:93%;display:inline-block; padding:8px;" disabled onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');">
					</td>
					 
				</tr> 
				<tr>
				  <td >Final&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield" id="activityCost<?php echo $finalActivityData['id']; ?>" value="<?php echo $activityCost; ?>" maxlength="100" style="text-align:center; width:93%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');"> 
					</td>
					<td >
						<input type="number" min="0" class="gridfield" id="maxpax<?php echo $finalActivityData['id']; ?>" value="<?php echo $maxpax; ?>" maxlength="100" style="text-align:center; width:93%;display:inline-block; padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');">
					</td>
					<td >
						<input type="number" min="0" class="gridfield" id="perPaxCost<?php echo $finalActivityData['id']; ?>" value="<?php echo $perPaxCost; ?>" maxlength="100" style="text-align:center; width:93%;display:inline-block; padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');">
					</td>
				</tr>
				<tr>
				<td align="left">Approved By</td> 
				<td ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalActivityData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalActivityData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');" /></td>
				<td align="left">Approved Date</td> 
				<td ><input  type="date" class="gridfield"  id="approvedDate<?php echo $finalActivityData['id']; ?>" value="<?php echo date('Y-m-d',strtotime($approvedDate)); ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;width: -webkit-fill-available; " placeholder="Approved Date" onchange="updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $finalActivityData['supplierId']; ?>');" min="2020-01-01" max="2030-12-31" /></td>
				</tr> 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_activity('<?php echo $finalActivityData['id']; ?>','<?php echo $activityId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
	}
 
	?>
	</tbody>
</table>
<?php 
}

//trains
$e="";
$e=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'" order by fromDate desc'); 
if(mysqli_num_rows($e) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Train</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
	while($finalQuoteTrainData=mysqli_fetch_array($e)){
	
		$d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$finalQuoteTrainData['trainId'].'"');   
		$trainData=mysqli_fetch_array($d);
		
		$supplierId='';
		$adultCost2=$finalQuoteTrainData['adultCost'];
		$childCost2=$finalQuoteTrainData['childCost'];
		$infantCost2=$finalQuoteTrainData['infantCost'];
		
		$supplierId = "";
		$trainId = $trainData['id'];
		
		if(strtotime($finalQuoteTrainData['fromDate']) == strtotime($finalQuoteTrainData['toDate'])){ 
			$trainDates = date('d M, Y',strtotime($finalQuoteTrainData['fromDate'])); 
		}else{ 
			$trainDates = date('d',strtotime($finalQuoteTrainData['fromDate']))."-".date('d M, Y',strtotime($finalQuoteTrainData['toDate']));
		}
		 
		$approvedBy=$finalQuoteTrainData['approvedBy'];
		$approvedDate=$finalQuoteTrainData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		$adultCost= $finalQuoteTrainData['adultCost'];
		$childCost= $finalQuoteTrainData['childCost'];
		$infantCost= $finalQuoteTrainData['infantCost'];
		if($finalQuoteTrainData['followupDate'] == "0" || $finalQuoteTrainData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteTrainData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteTrainData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuoteTrainData['followupDate']));
		}

	 	if($finalQuoteTrainData['supplierId']!='' && $finalQuoteTrainData['supplierId']!=0){
			$supplierId = $finalQuoteTrainData['supplierId'];
		}
		   
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 

		$Ecity = getDestination($finalQuoteTrainData['destinationId']);
			 
		?>
		<tr>
			<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  	<input type="hidden" value="<?php echo $finalQuoteTrainData['id'];?>" id="trainfinalId<?php echo $finalQuoteTrainData['id']; ?>">
					<input type="hidden" value="<?php echo $trainData['id'];?>" id="trainId<?php echo $finalQuoteTrainData['id']; ?>">
					<strong>Train&nbsp;Name</strong><br>
					<?php echo strip($trainData['trainName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  </td>
 				  	<td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><span style="margin-bottom:10px; font-size:12px;"><?php echo $trainDates; ?></span></td>
			  	   
				  </tr> 
				</tbody> 
			  </table>
		  	</div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="100px" bgcolor="#F4F4F4">Adult&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				  </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');">					
					</td>
				</tr> 
				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuoteTrainData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="childCost<?php echo $finalQuoteTrainData['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="infantCost<?php echo $finalQuoteTrainData['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');">					
					</td>
				</tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td colspan="3"><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteTrainData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuoteTrainData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');" /></td>

		
 				</tr> 
				</tbody>
			</table>	
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_train('<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $trainId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
		} 
	?>
	</tbody>
</table>
<?php 
}

///flightss
$f="";
$f=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'" order by fromDate desc'); 
if(mysqli_num_rows($f) > 0){	
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Flight</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
	while($finalQuoteFlightData=mysqli_fetch_array($f)){
	
		$d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlightData['flightId'].'"');   
		$flightData=mysqli_fetch_array($d);
		$flightId = strip($flightData['id']);
		
		$adultCost2=$finalQuoteFlightData['adultCost2'];
		$childCost2=$finalQuoteFlightData['childCost2'];
		$infantCost2=$finalQuoteFlightData['infantCost2'];
		
		$adultCost= $finalQuoteFlightData['adultCost'];
		$childCost= $finalQuoteFlightData['childCost'];
		$infantCost= $finalQuoteFlightData['infantCost'];

		
		if(strtotime($finalQuoteFlightData['fromDate']) == strtotime($finalQuoteFlightData['toDate'])){ 
			$flightDates = date('d M, Y',strtotime($finalQuoteFlightData['fromDate'])); 
		}else{ 
			$flightDates = date('d',strtotime($finalQuoteFlightData['fromDate']))."-".date('d M, Y',strtotime($finalQuoteFlightData['toDate']));
		}

		$approvedBy=$finalQuoteFlightData['approvedBy'];
		$approvedDate=$finalQuoteFlightData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
		

		if($finalQuoteFlightData['followupDate'] == "0" || $finalQuoteFlightData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($fightQuotData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteFlightData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuoteFlightData['followupDate']));
		}

	 	if($finalQuoteFlightData['supplierId']!='' && $finalQuoteFlightData['supplierId']!=0){
			$supplierId = $finalQuoteFlightData['supplierId'];
		} 
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		 
		$Ecity = getDestination($finalQuoteFlightData['destinationId']);
			 
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  	<input type="hidden" value="<?php echo $finalQuoteFlightData['id'];?>" id="flightfinalId<?php echo $finalQuoteFlightData['id']; ?>">
					<input type="hidden" value="<?php echo $flightData['id'];?>" id="flightId<?php echo $finalQuoteFlightData['id']; ?>">
					<strong>Flight&nbsp;Name:</strong><br>
					<?php echo strip($flightData['flightName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)
				  </td> 
				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br><span style="margin-bottom:10px; font-size:12px;"><?php echo $flightDates; ?></span></td>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="100px" bgcolor="#F4F4F4">Adul&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				</tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');">					
					</td>
				</tr> 
				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuoteFlightData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="childCost<?php echo $finalQuoteFlightData['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="infantCost<?php echo $finalQuoteFlightData['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');">					
					</td>
				</tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td colspan="3" ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteFlightData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuoteFlightData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');" /></td>
 				</tr> 
				</tbody>
			</table>	
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_flight('<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $flightId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
		}
	 
	?>
	</tbody>
</table>
<?php 
}


///Visa
$f="";
$f=GetPageRecord('*','finalQuoteVisa',' quotationId="'.$quotationData['id'].'" order by fromDate desc'); 
if(mysqli_num_rows($f) > 0){	
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : VISA</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
	while($finalQuoteVisaData=mysqli_fetch_array($f)){
	
		$d=GetPageRecord('*',_VISA_COST_MASTER_,'id="'.$finalQuoteVisaData['visaNameId'].'"');   
		$visaData=mysqli_fetch_array($d);
		$visaId = strip($visaData['id']);
		
		$adultCost2=$finalQuoteVisaData['adultCost2'];
		$childCost2=$finalQuoteVisaData['childCost2'];
		$infantCost2=$finalQuoteVisaData['infantCost2'];
		
		$adultCost= $finalQuoteVisaData['adultCost'];
		$childCost= $finalQuoteVisaData['childCost'];
		$infantCost=$finalQuoteVisaData['infantCost'];

		
		if(strtotime($finalQuoteVisaData['fromDate']) == strtotime($finalQuoteVisaData['toDate'])){ 
			$visaDates = date('d M, Y',strtotime($finalQuoteVisaData['fromDate'])); 
		}else{ 
			$visaDates = date('d',strtotime($finalQuoteVisaData['fromDate']))."-".date('d M, Y',strtotime($finalQuoteVisaData['toDate']));
		}

		$approvedBy=$finalQuoteVisaData['approvedBy'];
		$approvedDate=$finalQuoteVisaData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
		

		if($finalQuoteVisaData['followupDate'] == "0" || $finalQuoteVisaData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($fightQuotData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteVisaData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuoteVisaData['followupDate']));
		}

	 	if($finalQuoteVisaData['supplierId']!='' && $finalQuoteVisaData['supplierId']!=0){
			$supplierId = $finalQuoteVisaData['supplierId'];
		} 
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		 
		$Ecity = getDestination($finalQuoteVisaData['destinationId']);
			 
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  	<input type="hidden" value="<?php echo $finalQuoteVisaData['id'];?>" id="visafinalId<?php echo $finalQuoteVisaData['id']; ?>">
					<input type="hidden" value="<?php echo $visaData['id'];?>" id="visaId<?php echo $finalQuoteVisaData['id']; ?>">
					<strong>Visa&nbsp;Name:</strong><br>
					<?php echo strip($visaData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)
				  </td> 
				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br><span style="margin-bottom:10px; font-size:12px;"><?php echo $visaDates; ?></span></td>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="100px" bgcolor="#F4F4F4">Adul&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				</tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');">					
					</td>
				</tr> 
				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="visaadultCost<?php echo $finalQuoteVisaData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="visachildCost<?php echo $finalQuoteVisaData['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="visainfantCost<?php echo $finalQuoteVisaData['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');">					
					</td>
				</tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td colspan="3" ><input  type="text" class="gridfield"  id="visaapprovedBy<?php echo $finalQuoteVisaData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuoteVisaData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');" /></td>
 				</tr> 
				</tbody>
			</table>	
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_visa('<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $visaId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
		}
	 
	?>
	</tbody>
</table>
<?php 
}


///Passport
$f="";
$f=GetPageRecord('*','finalQuotePassport',' quotationId="'.$quotationData['id'].'" order by fromDate desc'); 
if(mysqli_num_rows($f) > 0){	
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Passport</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
	while($finalQuotePassData=mysqli_fetch_array($f)){
	
		$d=GetPageRecord('*',_PASSPORT_COST_MASTER_,'id="'.$finalQuotePassData['passportNameId'].'"');   
		$passData=mysqli_fetch_array($d);
		$passportId = strip($passData['id']);
		
		$adultCost2=$finalQuotePassData['adultCost2'];
		$childCost2=$finalQuotePassData['childCost2'];
		$infantCost2=$finalQuotePassData['infantCost2'];
		
		$adultCost= $finalQuotePassData['adultCost'];
		$childCost= $finalQuotePassData['childCost'];
		$infantCost=$finalQuotePassData['infantCost'];

		
		if(strtotime($finalQuotePassData['fromDate']) == strtotime($finalQuotePassData['toDate'])){ 
			$passportDates = date('d M, Y',strtotime($finalQuotePassData['fromDate'])); 
		}else{ 
			$passportDates = date('d',strtotime($finalQuotePassData['fromDate']))."-".date('d M, Y',strtotime($finalQuotePassData['toDate']));
		}

		$approvedBy=$finalQuotePassData['approvedBy'];
		$approvedDate=$finalQuotePassData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
		

		if($finalQuotePassData['followupDate'] == "0" || $finalQuotePassData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($fightQuotData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuotePassData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuotePassData['followupDate']));
		}

	 	if($finalQuotePassData['supplierId']!='' && $finalQuotePassData['supplierId']!=0){
			$supplierId = $finalQuotePassData['supplierId'];
		} 
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		 
		$Ecity = getDestination($finalQuotePassData['destinationId']);
			 
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  	<input type="hidden" value="<?php echo $finalQuotePassData['id'];?>" id="passportfinalId<?php echo $finalQuotePassData['id']; ?>">
					<input type="hidden" value="<?php echo $passData['id'];?>" id="passportId<?php echo $finalQuotePassData['id']; ?>">
					<strong>Passport&nbsp;Name:</strong><br>
					<?php echo strip($passData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)
				  </td> 
				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br><span style="margin-bottom:10px; font-size:12px;"><?php echo $passportDates; ?></span></td>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="100px" bgcolor="#F4F4F4">Adul&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				</tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');">					
					</td>
				</tr> 
				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="passadultCost<?php echo $finalQuotePassData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="passchildCost<?php echo $finalQuotePassData['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="passinfantCost<?php echo $finalQuotePassData['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');">					
					</td>
				</tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td colspan="3" ><input  type="text" class="gridfield"  id="passapprovedBy<?php echo $finalQuotePassData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuotePassData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');" /></td>
 				</tr> 
				</tbody>
			</table>	
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_passport('<?php echo $finalQuotePassData['id']; ?>','<?php echo $passportId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
		}
	 
	?>
	</tbody>
</table>
<?php 
}


///Insurance
$f="";
$f=GetPageRecord('*','finalQuoteInsurance',' quotationId="'.$quotationData['id'].'" order by fromDate desc'); 
if(mysqli_num_rows($f) > 0){	
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Insurance</th>
		</tr>
	</thead>
	<tbody >
	<?php
	if($_REQUEST['status'] == 1){
		// and shareQuoteStatus = 2
		$suppConfiListQuery = "";
	}else{
		$suppConfiListQuery = "";
	} 
	
	while($finalQuoteInsData=mysqli_fetch_array($f)){
	
		$d=GetPageRecord('*',_INSURANCE_COST_MASTER_,'id="'.$finalQuoteInsData['insuranceNameId'].'"');   
		$insData=mysqli_fetch_array($d);
		$insuranceId = strip($insData['id']);
		
		$adultCost2=$finalQuoteInsData['adultCost2'];
		$childCost2=$finalQuoteInsData['childCost2'];
		$infantCost2=$finalQuoteInsData['infantCost2'];
		
		$adultCost= $finalQuoteInsData['adultCost'];
		$childCost= $finalQuoteInsData['childCost'];
		$infantCost=$finalQuoteInsData['infantCost'];

		
		if(strtotime($finalQuoteInsData['fromDate']) == strtotime($finalQuoteInsData['toDate'])){ 
			$insuranceDates = date('d M, Y',strtotime($finalQuoteInsData['fromDate'])); 
		}else{ 
			$insuranceDates = date('d',strtotime($finalQuoteInsData['fromDate']))."-".date('d M, Y',strtotime($finalQuoteInsData['toDate']));
		}

		$approvedBy=$finalQuoteInsData['approvedBy'];
		$approvedDate=$finalQuoteInsData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
		

		if($finalQuoteInsData['followupDate'] == "0" || $finalQuoteInsData['followupDate'] == ""){
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($fightQuotData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteInsData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuoteInsData['followupDate']));
		}

	 	if($finalQuoteInsData['supplierId']!='' && $finalQuoteInsData['supplierId']!=0){
			$supplierId = $finalQuoteInsData['supplierId'];
		} 
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		 
		$Ecity = getDestination($finalQuoteInsData['destinationId']);
			 
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  	<input type="hidden" value="<?php echo $finalQuoteInsData['id'];?>" id="insurancefinalId<?php echo $finalQuoteInsData['id']; ?>">
					<input type="hidden" value="<?php echo $insData['id'];?>" id="insuranceId<?php echo $finalQuoteInsData['id']; ?>">
					<strong>Insurance&nbsp;Name:</strong><br>
					<?php echo strip($insData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)
				  </td> 
				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br><span style="margin-bottom:10px; font-size:12px;"><?php echo $insuranceDates; ?></span></td>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="100px" bgcolor="#F4F4F4">Adul&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Child&nbsp;Cost</th>
				  <th width="100px" bgcolor="#F4F4F4">Infant&nbsp;Cost</th>
				</tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  	<td >Quote&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($childCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield"value="<?php echo trim($infantCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');">					
					</td>
				</tr> 
				<tr>
				  	<td >Final&nbsp;Price</td>
				  	<td >				
						<input type="number" min="0" class="gridfield" id="insadultCost<?php echo $finalQuoteInsData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="inschildCost<?php echo $finalQuoteInsData['id']; ?>" value="<?php echo $childCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');">					
					</td>
					<td >				
						<input type="number" min="0" class="gridfield" id="insinfantCost<?php echo $finalQuoteInsData['id']; ?>" value="<?php echo $infantCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?> onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');">					
					</td>
				</tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td colspan="3" ><input  type="text" class="gridfield"  id="insapprovedBy<?php echo $finalQuoteInsData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuoteInsData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');" /></td>
 				</tr> 
				</tbody>
			</table>	
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_insurance('<?php echo $finalQuoteInsData['id']; ?>','<?php echo $insuranceId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
		}
	 
	?>
	</tbody>
</table>
<?php 
}


//guides
$g='';
$g=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" order by fromDate desc'); 
if(mysqli_num_rows($g) > 0){		
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Guide</th>
		</tr>
	</thead>
	<tbody >
	<?php 
	while($finalQuoteGuideData=mysqli_fetch_array($g)){
	
		$d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuideData['guideId'].'"');   
		$guideData=mysqli_fetch_array($d);
		  
		$guideId = strip($guideData['id']);
		
		if(strtotime($finalQuoteGuideData['fromDate']) == strtotime($finalQuoteGuideData['toDate'])){ 
			$guideDates = date('d M, Y',strtotime($finalQuoteGuideData['fromDate'])); 
		}else{ 
			$guideDates = date('d',strtotime($finalQuoteGuideData['fromDate']))."-".date('d M, Y',strtotime($finalQuoteGuideData['toDate']));
		}
		
		$approvedBy=$finalQuoteGuideData['approvedBy'];
		$approvedDate=$finalQuoteGuideData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		$adultCost = $finalQuoteGuideData['adultCost'];
		$adultCost2 = $finalQuoteGuideData['adultCost2'];

		if($finalQuoteGuideData['followupDate'] == "0" || $finalQuoteGuideData['followupDate'] == ""){
				$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteGuideData['fromDate'])));
			$followupTime = date('H:i',strtotime('0000-00-00 08:00:00'));
		}else{
			$followupDate = date("Y-m-d",strtotime('-2 day', strtotime($finalQuoteGuideData['followupDate'])));
			$followupTime = date("H:i",strtotime($finalQuoteGuideData['followupDate']));
		}
			
	 	if($finalQuoteGuideData['supplierId']!='' && $finalQuoteGuideData['supplierId']!=0){
			$supplierId = $finalQuoteGuideData['supplierId'];
		} 

		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 
		
		$Ecity = getDestination($finalQuoteGuideData['destinationId']);
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  	<input type="hidden" value="<?php echo $finalQuoteGuideData['id'];?>" id="guidefinalId<?php echo $finalQuoteGuideData['id']; ?>">
					<input type="hidden" value="<?php echo $guideData['id'];?>" id="guideId<?php echo $finalQuoteGuideData['id']; ?>">
					<strong><?php if($finalQuoteGuideData['serviceType'] ==1){ echo "Porter";}else{ echo "Guide"; } ?> Service:</strong><br>
					<?php echo strip($guideData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)
				  </td>
 				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br>
					<span style="margin-bottom:10px; font-size:12px;"><?php echo $guideDates; ?></span></td>
			  	  <td width="16%"  bgcolor="#F4F4F4"></td>
			  	   
			  	  <?php if($finalQuoteGuideData['shareQuoteStatus'] != 2){ ?>
				  <td width="15%"  align="left" bgcolor="#F4F4F4"><label for="followupDate<?php echo $finalQuoteGuideData['id']; ?>" style="font-size:12px;"></label></td>
				  <td width="13%"  align="left" bgcolor="#F4F4F4"><label for="followupTime<?php echo $finalQuoteGuideData['id']; ?>" style="font-size:12px;"></label></td>
				<td width="13%"  align="left" bgcolor="#F4F4F4">&nbsp;</td>
				<?php } ?>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th  colspan="2" width="200px" bgcolor="#F4F4F4">Per&nbsp;Pax&nbsp;Cost</th>
 			   </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  <td >Quote&nbsp;Price</td>
				  <td  colspan="2">				
						<input type="number" min="0" class="gridfield" id="adultCost2<?php echo $finalQuoteGuideData['id']; ?>" value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_guide('<?php echo $finalQuoteGuideData['id']; ?>','<?php echo $guideId; ?>');"> 
				  </td>
				   
				</tr> 
				<tr>
				  <td >Final&nbsp;Price</td>
				  <td colspan="2">				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuoteGuideData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_guide('<?php echo $finalQuoteGuideData['id']; ?>','<?php echo $guideId; ?>');"> 
					</td>
				</tr>
				<tr>
				<td align="right">Approved By/Date</td> 
				<td ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteGuideData['id']; ?>" value="<?php echo $approvedBy; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;" placeholder="Full Name" <?php if($finalQuoteGuideData['shareQuoteStatus']==2){ ?> disabled <?php } ?>  onkeyup="updateFinalQuote_guide('<?php echo $finalQuoteGuideData['id']; ?>','<?php echo $guideId; ?>');" /></td>
				<td ><input  type="date" class="gridfield"  id="approvedDate<?php echo $finalQuoteGuideData['id']; ?>" value="<?php echo date('Y-m-d',strtotime($approvedDate)); ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;width: -webkit-fill-available; " placeholder="Approved Date" onchange="updateFinalQuote_guide('<?php echo $finalQuoteGuideData['id']; ?>','<?php echo $finalQuoteGuideData['supplierId']; ?>');" min="2020-01-01" max="2030-12-31" /></td>

				</tr> 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_guide('<?php echo $finalQuoteGuideData['id']; ?>','<?php echo $guideId; ?>');
			});
			</script>		
		</td>
		</tr>
		<?php
		}
	 
	?>
	</tbody>
</table>
<?php 
}


//finalQuoteMealPlan
$b="";
$b=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($b) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Restaurant</th>
		</tr>
	</thead>
	<tbody >
	
	<?php 
 	while($finalQuoteMealData=mysqli_fetch_array($b)){ 

		$mealQuoteId = $finalQuoteMealData['id'];
		//meal
		
		$approvedBy=$finalQuoteMealData['approvedBy'];
		$approvedDate=$finalQuoteMealData['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		$adultCost= $finalQuoteMealData['adultCost'];
		$childCost= $finalQuoteMealData['childCost'];
		$infantCost= $finalQuoteMealData['infantCost'];

		$adultCost2= $finalQuoteMealData['adultCost2'];
		$childCost2= $finalQuoteMealData['childCost2'];
		$infantCost2= $finalQuoteMealData['infantCost2'];

		if($finalQuoteMealData['supplierId']!='' && $finalQuoteMealData['supplierId']!=0){
			$supplierId = $finalQuoteMealData['supplierId'];
		}
		
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 

		$mealDates = date('d M, Y',strtotime($finalQuoteMealData['fromDate'])); 
		 
 		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  <input type="hidden" value="<?php echo $finalQuoteMealData['id'];?>" id="mealfinalId<?php echo $finalQuoteMealData['id'];?>">
				  <strong>Restaurant&nbsp;Name:</strong><br>
				  <?php echo strip($finalQuoteMealData['mealPlanName']);  ?></td>
 				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br>
				  <span style="margin-bottom:10px; font-size:12px;"><?php echo $mealDates; ?></span></td> 
				  <td width="16%"  bgcolor="#F4F4F4"> </td>
				</tr>
				</tbody>
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="200px" bgcolor="#F4F4F4">Per Pax&nbsp;Cost</th>
				  </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  <td >Quote&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield" value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_meal('<?php echo $finalQuoteMealData['id']; ?>','<?php echo $finalQuoteMealData['id']; ?>');">					</td>
				  </tr> 
				<tr>
				  <td >Final&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuoteMealData['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_meal('<?php echo $finalQuoteMealData['id']; ?>','<?php echo $finalQuoteMealData['id']; ?>');">					</td>
				  </tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteMealData['id']; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;"  onKeyUp="updateFinalQuote_meal('<?php echo $finalQuoteMealData['id']; ?>','<?php echo $finalQuoteMealData['id']; ?>');" value="<?php echo $approvedBy; ?>" placeholder="Full Name" <?php if($finalQuoteMealData['shareQuoteStatus']==2){ ?> <?php } ?> /></td>
				</tr> 				 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_meal('<?php echo $finalQuoteMealData['id']; ?>','<?php echo $mealQuoteId; ?>');
			});
			</script>			
		</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}


//finalQuoteExtra
$b="";
$b=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($b) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Additionals</th>
		</tr>
	</thead>
	<tbody >
	
	<?php 
	
 	while($finalQuoteAdditionD=mysqli_fetch_array($b)){ 

		$d=GetPageRecord('*','extraQuotation',' id="'.$finalQuoteAdditionD['additionalId'].'"');   
		$additionalData=mysqli_fetch_array($d);
		//additional

		if(!empty($finalQuoteAdditionD['groupCost'])){
	      $additionalcost=$groupCost=$finalQuoteAdditionD['groupCost'];	
	    }else{
		  $additionalcost=$adultCost=$finalQuoteAdditionD['adultCost'];
	    }
		
		$additionalId = $finalQuoteAdditionD['additionalId'];
	
		$approvedBy=$finalQuoteAdditionD['approvedBy'];
		$approvedDate=$finalQuoteAdditionD['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}

		if($finalQuoteAdditionD['supplierId']!='' && $finalQuoteAdditionD['supplierId']!=0){
			$supplierId = $finalQuoteAdditionD['supplierId'];
		}
		$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		$supplierData=mysqli_fetch_array($bb); 

		$additionalDates = date('d M, Y',strtotime($finalQuoteAdditionD['fromDate'])); 
		 
		$Ecity = getDestination($finalQuoteAdditionD['destinationId']);	
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  <input type="hidden" value="<?php echo $finalQuoteAdditionD['id'];?>" id="additionalfinalId<?php echo $finalQuoteAdditionD['id']; ?>">
				  <input type="hidden" value="<?php echo $additionalData['id'];?>" id="additionalId<?php echo $finalQuoteAdditionD['id']; ?>"> 
				  <strong>Additional&nbsp;Name:</strong><br>
				  <?php echo strip($additionalData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
 				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br><span style="margin-bottom:10px; font-size:12px;"><?php echo $additionalDates; ?></span></td> 
				   <td width="16%"  bgcolor="#F4F4F4"></td>
				  </tr>
				</tbody>
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="200px" bgcolor="#F4F4F4">Per Pax&nbsp;Cost</th>
				  </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  <td >Quote&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield" value="<?php echo trim($additionalcost); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_additional('<?php echo $finalQuoteAdditionD['id']; ?>','<?php echo $finalQuoteAdditionD['additionalId']; ?>');">					</td>
				  </tr> 
				<tr>
				  <td >Final&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuoteAdditionD['id']; ?>" value="<?php echo trim($additionalcost); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_additional('<?php echo $finalQuoteAdditionD['id']; ?>','<?php echo $finalQuoteAdditionD['additionalId']; ?>');">					</td>
				  </tr>
				<tr>
				<td align="left">Approved By?Date</td> 
				<td ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteAdditionD['id']; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;"  onKeyUp="updateFinalQuote_additional('<?php echo $finalQuoteAdditionD['id']; ?>','<?php echo $finalQuoteAdditionD['additionalId']; ?>');" value="<?php echo $approvedBy; ?>" placeholder="Full Name" <?php if($finalQuoteAdditionD['shareQuoteStatus']==2){ ?> <?php } ?> /></td>
				</tr> 				 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_additional('<?php echo $finalQuoteAdditionD['id']; ?>','<?php echo $finalQuoteAdditionD['additionalId']; ?>');
			});
			</script>			
		</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}


//finalQuoteEnroute
$b="";
$b=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($b) > 0){
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Enroute</th>
		</tr>
	</thead>
	<tbody >
	
	<?php 
 	while($finalQuoteEnrouD=mysqli_fetch_array($b)){ 

	$d=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$finalQuoteEnrouD['enrouteId'].'"');   
		$enrouteData=mysqli_fetch_array($d);
		//enroute
		$enrouteId = $enrouteData['id'];
		

		$approvedBy=$finalQuoteEnrouD['approvedBy'];
		$approvedDate=$finalQuoteEnrouD['approvedDate'];
		if($approvedDate == "0000-00-00 00:00:00" || $approvedDate == ""){
			$approvedDate = date("Y-m-d");
		}else{
			$approvedDate = date("Y-m-d",strtotime($approvedDate));
		}
		
		$adultCost= $finalQuoteEnrouD['adultCost'];
		$childCost= $finalQuoteEnrouD['childCost'];
		$infantCost= $finalQuoteEnrouD['infantCost'];

		$adultCost2= $finalQuoteEnrouD['adultCost2'];
		$childCost2= $finalQuoteEnrouD['childCost2'];
		$infantCost2= $finalQuoteEnrouD['infantCost2'];
			 
		if($finalQuoteEnrouD['supplierId']!='' && $finalQuoteEnrouD['supplierId']!=0){
			$supplierId = $finalQuoteEnrouD['supplierId'];
		}

		$enrouteDates = date('d M, Y',strtotime($finalQuoteEnrouD['fromDate'])); 
		$Ecity = getDestination($finalQuoteEnrouD['destinationId']);	
		?>
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="23%"  bgcolor="#F4F4F4">
				  <input type="hidden" value="<?php echo $finalQuoteEnrouD['id'];?>" id="enroutefinalId<?php echo $finalQuoteEnrouD['id']; ?>">
				  <input type="hidden" value="<?php echo $enrouteData['id'];?>" id="enrouteId<?php echo $finalQuoteEnrouD['id']; ?>"> 
				  <strong>Enroute&nbsp;Name:</strong><br>
				  <?php echo strip($enrouteData['enrouteName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
 				  <td width="16%"  bgcolor="#F4F4F4"><strong>Date:</strong><br>
				  <span style="margin-bottom:10px; font-size:12px;"><?php echo $enrouteDates; ?></span></td> 

				   <td width="16%"  bgcolor="#F4F4F4"></td>

				  </tr>
				</tbody>
			  </table>
		  </div>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			   <tr>
				  <th width="80px" bgcolor="#F4F4F4">&nbsp; </th>
				  <th width="200px" bgcolor="#F4F4F4">Per Pax&nbsp;Cost</th>
				  </tr>
			</thead> 
				<tbody class="ui-sortable">
					 
				<tr>
				  <td >Quote&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield"  value="<?php echo trim($adultCost2); ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" disabled  onkeyup="updateFinalQuote_enroute('<?php echo $finalQuoteEnrouD['id']; ?>','<?php echo $finalQuoteEnrouD['enrouteId']; ?>');">					</td>
				  </tr> 
				<tr>
				  <td >Final&nbsp;Price</td>
				  <td >				
						<input type="number" min="0" class="gridfield" id="adultCost<?php echo $finalQuoteEnrouD['id']; ?>" value="<?php echo $adultCost; ?>" maxlength="100" style="text-align:center; width:95%;display:inline-block;padding:8px;" <?php if($_REQUEST['status']==1){ ?> disabled <?php } ?>   onkeyup="updateFinalQuote_enroute('<?php echo $finalQuoteEnrouD['id']; ?>','<?php echo $finalQuoteEnrouD['enrouteId']; ?>');">					</td>
				  </tr>
				<tr>
				<td align="left">Approved By/Date</td> 
				<td ><input  type="text" class="gridfield"  id="approvedBy<?php echo $finalQuoteEnrouD['id']; ?>" style="text-align:left; width: -webkit-fill-available;  padding:8px;"  onKeyUp="updateFinalQuote_enroute('<?php echo $finalQuoteEnrouD['id']; ?>','<?php echo $finalQuoteEnrouD['enrouteId']; ?>');" value="<?php echo $approvedBy; ?>" placeholder="Full Name" <?php if($finalQuoteEnrouD['shareQuoteStatus']==2){ ?> <?php } ?> /></td>
				</tr> 				 
				</tbody>
			</table>
			<script>
			jQuery(document).ready(function($){
				updateFinalQuote_enroute('<?php echo $finalQuoteEnrouD['id']; ?>','<?php echo $finalQuoteEnrouD['additionalId']; ?>');
			});
			</script>			
		</td>
		</tr>
		<?php
	} 
	?>
	</tbody>
</table>
<?php 
}


//forex insorense	
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Forex&nbsp;Insurance</th>
		</tr>
	</thead>
	<tbody >
	
	
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
		    <form method="post" enctype="multipart/form-data">
			<div style="font-size:15px; font-weight:500; padding:10px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
			  	  <td width="80%" bgcolor="#F4F4F4"><div style="font-size:12px;">Insurance Voucher</div>
				  <input type="file" name="insurenceVoucher" id="insurenceVoucher" class="gridfield" style="text-align:center; width:90%;display:inline-block;padding:8px;" />	
				  </td>
				  <input type="hidden" name="quotationId" id="quotationId" value="<?php echo $quotationData['id']; ?>" />
				  <input type="hidden" name="queryId" id="queryId" value="<?php echo $resultpage['id']; ?>" />
				  <td width="13%"  align="left" bgcolor="#F4F4F4">&nbsp;<br><div id="insurence_Voucher" style="background-color: #009900; color: #FFFFFF; cursor: pointer; padding: 7px 10px; border-radius: 2PX;   box-sizing: border-box; display:inline" >Save</div>
	   			  </td>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
		  </form>
		</td>
		</tr>
	</tbody>
</table>
<?php   ?>
<div style="display:none;" id="updateFinalQuote_LoadBox"></div>

<script type="text/javascript">
	function updateFinalQuote_hotel(hotelQuotationId,hotelId){
 		var hotelfinalId = $('#hotelfinalId'+hotelQuotationId).val();
 		
		var roomsinglecost = $('#roomsinglecost'+hotelQuotationId).val();
		var roomdoublecost = $('#roomdoublecost'+hotelQuotationId).val();
		var roomtriplecost = $('#roomtriplecost'+hotelQuotationId).val(); 
		var roomtwincost = $('#roomtwincost'+hotelQuotationId).val(); 
		var roomEBedACost = $('#roomEBedACost'+hotelQuotationId).val(); 
		var quadRoomCost = $('#quadRoomCost'+hotelQuotationId).val(); 
		var teenRoomCost = $('#teenRoomCost'+hotelQuotationId).val(); 
		// var teenRoomCost = $('#teenRoomCost'+hotelQuotationId).val(); 
		var roomEBedCCost = $('#roomEBedCCost'+hotelQuotationId).val(); 
		var roomENBedCCost = $('#roomENBedCCost'+hotelQuotationId).val(); 
		var sixBedRoomCost = $('#sixBedRoomCost'+hotelQuotationId).val(); 
		var eightBedRoomCost = $('#eightBedRoomCost'+hotelQuotationId).val(); 
		var tenBedRoomCost = $('#tenBedRoomCost'+hotelQuotationId).val(); 

		var roomsingle = $('#roomsingle'+hotelQuotationId).val();
		var roomdouble = $('#roomdouble'+hotelQuotationId).val();
		var roomtriple = $('#roomtriple'+hotelQuotationId).val(); 
		var roomtwin = $('#roomtwin'+hotelQuotationId).val();
		var roomEBedA = $('#roomEBedA'+hotelQuotationId).val();
		var quadNoofRoom = $('#quadNoofRoom'+hotelQuotationId).val();
		var teenNoofRoom = $('#teenNoofRoom'+hotelQuotationId).val();
		var roomEBedC = $('#roomEBedC'+hotelQuotationId).val();
		var roomENBedC = $('#roomENBedC'+hotelQuotationId).val();
		var sixNoofBedRoom = $('#sixNoofBedRoom'+hotelQuotationId).val();
		var eightNoofBedRoom = $('#eightNoofBedRoom'+hotelQuotationId).val();
		var tenNoofBedRoom = $('#tenNoofBedRoom'+hotelQuotationId).val();

		var approvedBy = $('#approvedBy'+hotelQuotationId).val(); 
		var approvedDate = $('#approvedDate'+hotelQuotationId).val(); 

		if(roomsingle!=0 || roomdouble!=0 || roomtriple!=0 || roomtwin!=0 || roomEBedA!=0 || quadNoofRoom!=0 || teenNoofRoom!=0 || roomEBedC!=0 || sixNoofBedRoom!=0 || eightNoofBedRoom!=0 || tenNoofBedRoom!=0){ 
			$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_hotel&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&hotelfinalId='+hotelfinalId+'&roomsinglecost='+roomsinglecost+'&roomdoublecost='+roomdoublecost+'&roomtriplecost='+roomtriplecost+'&roomtwincost='+roomtwincost+'&roomsingle='+roomsingle+'&roomdouble='+roomdouble+'&roomtriple='+roomtriple+'&roomtwin='+roomtwin+'&tenNoofBedRoom='+tenNoofBedRoom+'&eightNoofBedRoom='+eightNoofBedRoom+'&sixNoofBedRoom='+sixNoofBedRoom+'&roomEBedC='+roomEBedC+'&teenNoofRoom='+teenNoofRoom+'&quadNoofRoom='+quadNoofRoom+'&roomEBedA='+roomEBedA+'&roomEBedACost='+roomEBedACost+'&quadRoomCost='+quadRoomCost+'&teenRoomCost='+teenRoomCost+'&roomEBedCCost='+roomEBedCCost+'&roomENBedCCost='+roomENBedCCost+'&sixBedRoomCost='+sixBedRoomCost+'&eightBedRoomCost='+eightBedRoomCost+'&tenBedRoomCost='+tenBedRoomCost+'&roomENBedC='+roomENBedC); 
		} else{ 
 
 			$('#roomsingle'+hotelQuotationId).css( {'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;border: 1px solid red !important'});
			$('#roomdouble'+hotelQuotationId).css( {'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;border: 1px solid red !important'});
			$('#roomtriple'+hotelQuotationId).css( {'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;border: 1px solid red !important'});
 			$('#roomtwin'+hotelQuotationId).css( {'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;border: 1px solid red !important'});
			setTimeout(function() {
				$('#roomsingle'+hotelQuotationId).css({'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;'});
				$('#roomdouble'+hotelQuotationId).css({'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;'});
				$('#roomtriple'+hotelQuotationId).css({'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;'});
				$('#roomtwin'+hotelQuotationId).css({'cssText':'text-align:center; width:20%;display:inline-block;padding:8px;'});
	
			}, 5000);
		}
	}
	
	// transfer finalQuotetransfer
	function updateFinalQuote_transfer(transferQuotationId,transferId){
		var approvedBy = $('#approvedBy'+transferQuotationId).val(); 
		var approvedDate = $('#approvedDate'+transferQuotationId).val(); 

 		var transferfinalId = $('#transferfinalId'+transferQuotationId).val();
 		var transferType = $('#transferType'+transferQuotationId).val();

 		var adultCost = childCost = infantCost = vehicleCost = 0;
 		if(transferType==1){
	 		adultCost = $('#adultCost'+transferQuotationId).val();  
	 		childCost = $('#childCost'+transferQuotationId).val();  
	 		infantCost = $('#infantCost'+transferQuotationId).val();  
 		}else{
	 		vehicleCost = $('#vehicleCost'+transferQuotationId).val(); 
 		} 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_transfer&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&transferfinalId='+transferfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&vehicleCost='+vehicleCost); 
	} 
	
	// transfer finalQuoteEntrance
	function updateFinalQuote_entrance(entranceQuotationId,entranceId){

		var approvedBy = $('#approvedBy'+entranceQuotationId).val(); 
		var approvedDate = $('#approvedDate'+entranceQuotationId).val(); 

 		var entrancefinalId = $('#entrancefinalId'+entranceQuotationId).val();
 		var entTransferType = $('#entTransferType'+entranceQuotationId).val();
 		
		var ticketAdultCost = $('#ticketAdultCost'+entranceQuotationId).val();
		var ticketchildCost = $('#ticketchildCost'+entranceQuotationId).val();
		var ticketinfantCost = $('#ticketinfantCost'+entranceQuotationId).val();
		
		var adultCost = childCost = infantCost = vehicleCost = 0;
 		if(entTransferType==1){
	 		adultCost = $('#adultCost'+entranceQuotationId).val();  
	 		childCost = $('#childCost'+entranceQuotationId).val();  
	 		infantCost = $('#infantCost'+entranceQuotationId).val();  
 		}else{
	 		vehicleCost = $('#vehicleCost'+entranceQuotationId).val(); 
 		}
		var repCost = $('#repCost'+entranceQuotationId).val();
		 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_entrance&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&entrancefinalId='+entrancefinalId+'&ticketAdultCost='+ticketAdultCost+'&ticketchildCost='+ticketchildCost+'&ticketinfantCost='+ticketinfantCost+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&vehicleCost='+vehicleCost+'&repCost='+repCost); 
	}	



	// transfer finalQuoteFerry
	function updateFinalQuote_ferry(ferryQuotationId,ferryId){

		var approvedBy = $('#approvedBy'+ferryQuotationId).val(); 
		var approvedDate = $('#approvedDate'+ferryQuotationId).val(); 
 		var ferryfinalId = $('#ferryfinalId'+ferryQuotationId).val();

		var adultCost= $('#adultCost'+ferryQuotationId).val();
		var childCost= $('#childCost'+ferryQuotationId).val();
		var infantCost= $('#infantCost'+ferryQuotationId).val();
		var processingfee= $('#processingfee'+ferryQuotationId).val();
		var miscCost= $('#miscCost'+ferryQuotationId).val();
		
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_ferry&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&ferryfinalId='+ferryfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&processingfee='+processingfee+'&miscCost='+miscCost); 
	}

	//  finalQuoteEntrance
	function updateFinalQuote_meal(mealQuotationId,mealId){

		var approvedBy = $('#approvedBy'+mealQuotationId).val(); 
		var approvedDate = $('#approvedDate'+mealQuotationId).val(); 

 		var mealfinalId = $('#mealfinalId'+mealQuotationId).val();
 		
		var adultCost = $('#adultCost'+mealQuotationId).val();
		var childCost = $('#childCost'+mealQuotationId).val();
		var infantCost = $('#infantCost'+mealQuotationId).val();
		 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_meal&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&mealfinalId='+mealfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}

	//  finalQuoteEntrance
	function updateFinalQuote_additional(additionalQuotationId,additionalId){

		var approvedBy = $('#approvedBy'+additionalQuotationId).val(); 
		var approvedDate = $('#approvedDate'+additionalQuotationId).val(); 

 		var additionalfinalId = $('#additionalfinalId'+additionalQuotationId).val();
 		
		var adultCost = $('#adultCost'+additionalQuotationId).val();
		var childCost = $('#childCost'+additionalQuotationId).val();
		var infantCost = $('#infantCost'+additionalQuotationId).val();
		 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_additional&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&additionalfinalId='+additionalfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}

	//  finalQuoteEntrance
	function updateFinalQuote_enroute(enrouteQuotationId,enrouteId){

		var approvedBy = $('#approvedBy'+enrouteQuotationId).val(); 
		var approvedDate = $('#approvedDate'+enrouteQuotationId).val(); 

 		var enroutefinalId = $('#enroutefinalId'+enrouteQuotationId).val();
 		
		var adultCost = $('#adultCost'+enrouteQuotationId).val();
		var childCost = $('#childCost'+enrouteQuotationId).val();
		var infantCost = $('#infantCost'+enrouteQuotationId).val();
		 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_enroute&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&enroutefinalId='+enroutefinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}	 

	// transfer finalQuoteActivity
	function updateFinalQuote_activity(activityQuotationId,activityId){

		var approvedBy = $('#approvedBy'+activityQuotationId).val(); 
		var approvedDate = $('#approvedDate'+activityQuotationId).val(); 

 		var activityfinalId = $('#activityfinalId'+activityQuotationId).val();
 		
		var activityCost = $('#activityCost'+activityQuotationId).val();
		var maxpax = $('#maxpax'+activityQuotationId).val();
		var perPaxCost = $('#perPaxCost'+activityQuotationId).val(); 
		
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_activity&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&activityfinalId='+activityfinalId+'&activityCost='+activityCost+'&maxpax='+maxpax+'&perPaxCost='+perPaxCost); 
	}


	// trian finalQuoteTrain
	function updateFinalQuote_train(trainQuotationId,trainId){

		var approvedBy = $('#approvedBy'+trainQuotationId).val(); 
		var approvedDate = $('#approvedDate'+trainQuotationId).val(); 

 		var trainfinalId = $('#trainfinalId'+trainQuotationId).val();
		
		var adultCost = $('#adultCost'+trainQuotationId).val();
		var childCost = $('#childCost'+trainQuotationId).val();
		var infantCost = $('#infantCost'+trainQuotationId).val();
		 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_train&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&trainfinalId='+trainfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}
	
	// trian finalQuoteTrain
	function updateFinalQuote_flight(flightQuotationId,flightId){

		var approvedBy = $('#approvedBy'+flightQuotationId).val(); 
		var approvedDate = $('#approvedDate'+flightQuotationId).val(); 

 		var flightfinalId = $('#flightfinalId'+flightQuotationId).val();
		
		var adultCost = $('#adultCost'+flightQuotationId).val();
		var childCost = $('#childCost'+flightQuotationId).val();
		var infantCost = $('#infantCost'+flightQuotationId).val();
		
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_flight&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&flightfinalId='+flightfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}

	function updateFinalQuote_visa(visaQuotationId,visaId){

	var approvedBy = $('#visaapprovedBy'+visaQuotationId).val(); 
	var approvedDate = $('#visaapprovedDate'+visaQuotationId).val(); 

	var visafinalId = $('#visafinalId'+visaQuotationId).val();

	var adultCost = $('#visaadultCost'+visaQuotationId).val();
	var childCost = $('#visachildCost'+visaQuotationId).val();
	var infantCost = $('#visainfantCost'+visaQuotationId).val();

	$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_visa&approvedBy='+encodeURI(approvedBy)+'&approvedDate='+approvedDate+'&visafinalId='+visafinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}

	
	function updateFinalQuote_passport(passQuotationId,passportId){

	var approvedBy = $('#passapprovedBy'+passQuotationId).val(); 
	var approvedDate = $('#approvedDate'+passQuotationId).val(); 

	var passportfinalId = $('#passportfinalId'+passQuotationId).val();

	var adultCost = $('#passadultCost'+passQuotationId).val();
	var childCost = $('#passchildCost'+passQuotationId).val();
	var infantCost = $('#passinfantCost'+passQuotationId).val();

	$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_passport&approvedBy='+encodeURI(approvedBy)+'&approvedDate='+approvedDate+'&passportfinalId='+passportfinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}


	function updateFinalQuote_insurance(insuranceQuotationId,insuranceId){

	var approvedBy = $('#insapprovedBy'+insuranceQuotationId).val(); 
	var approvedDate = $('#approvedDate'+insuranceQuotationId).val(); 

	var insurancefinalId = $('#insurancefinalId'+insuranceQuotationId).val();

	var adultCost = $('#insadultCost'+insuranceQuotationId).val();
	var childCost = $('#inschildCost'+insuranceQuotationId).val();
	var infantCost = $('#insinfantCost'+insuranceQuotationId).val();

	$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_insurance&approvedBy='+encodeURI(approvedBy)+'&approvedDate='+approvedDate+'&insurancefinalId='+insurancefinalId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost); 
	}
	
	// guide finalQuoteGuide 
	function updateFinalQuote_guide(guideQuotationId,guideId){

		var approvedBy = $('#approvedBy'+guideQuotationId).val(); 
		var approvedDate = $('#approvedDate'+guideQuotationId).val(); 
		
 		var guidefinalId = $('#guidefinalId'+guideQuotationId).val();
		
		var adultCost = $('#adultCost'+guideQuotationId).val();
		 
		$('#updateFinalQuote_LoadBox').load('final_frmaction.php?action=updateFinalQuote_guide&approvedBy='+approvedBy+'&approvedDate='+approvedDate+'&guidefinalId='+guidefinalId+'&adultCost='+adultCost); 
	
	}
</script>
<script>
$(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');
});
</script>
<script>
// transfer updateFinalQuote_LoadBoxInsurance
	$(document).ready(function(){
		$("#insurence_Voucher").click(function() {
			var fd = new FormData(); 
			var files = $('#insurenceVoucher')[0].files[0]; 
			fd.append('insurenceVoucher', files); 
			var quotationId = $('#quotationId').val();
			fd.append('quotationId', quotationId);
			var queryId = $('#queryId').val();
			fd.append('queryId', queryId); 
   
			$.ajax({ 
				url: 'finalInsurenceVoucher.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					   alert('file uploaded'); 
					} 
				}, 
			}); 
		}); 
	});     
	function savefinalQuote(){
		$('.followupBtnClick').click();
		// $('#savefinalQuote').load('final_frmaction.php?action=savefinalQuote');
	} 
</script>
<div id="savefinalQuote"></div>
<div style="overflow:hidden; margin-top:20px;">
	 <table border="0" align="right" cellpadding="5" cellspacing="0">
	  	<tbody>
	  		<tr>
		    	<td>
				     <!-- <input type="button" class="bluembutton submitbtn" value="Save" onclick="savefinalQuote();"> -->
				     <input type="button" class="whitembutton" value="Close" onclick="alertspopupopenClose();window.location.reload();">
				</td>
		  	</tr>
		</tbody>
	</table>
</div>	