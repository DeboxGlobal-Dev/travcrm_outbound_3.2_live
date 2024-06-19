<?php 
include "inc.php"; 
$id=$_REQUEST['id'];
?>
<style>
.griddiv{
width:100%;
}
.gridfield {
    padding: 5px 10px;
    border: 1px solid #aaa;
	outline:none !important;
	width:100%;
	border-radius:4px;
}
label{
display:block;
width:100%; 
}
.griddiv input{
border-radius:4px !important;
}
.select2-container--default .select2-selection--single { 
    outline: none !important;
}
.select2-container--default .select2-search--dropdown .select2-search__field { 
    outline: none !important;
}
</style>
<script src="js/zebra_datepicker.js"></script>
<script src="plugins/select2/select2.full.min.js"></script> 
<script type="text/javascript"> 
$(document).ready(function() {  
$('.newDatePicker').Zebra_DatePicker({ 
format: 'd-m-Y',  
}); 
}); 
</script> 
<script>
$(document).ready(function() { 
$(".select2").select2();
});
</script> 
<div class="rate-result-block">
  <?php if($id==1){ ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="10%"><div class="griddiv">
          <label>
		  <select id="hotelName" name="hotelName" class="select2 gridfield" autocomplete="off">
		  <option value="">All Hotels</option>
		         <?php  
		$hotelNameDataq=GetPageRecord('id,hotelName',_PACKAGE_BUILDER_HOTEL_MASTER_,' 1 and hotelName!="" and status=1 and id in ( select serviceid from '._DMC_ROOM_TARIFF_MASTER_.' ) order by hotelName'); 
		while($hotelNameData=mysqli_fetch_array($hotelNameDataq)){  
		?>
            <option value="<?php echo ($hotelNameData['id']); ?>" <?php if($_REQUEST['hotelName']==$hotelNameData['id']){ ?> selected="selected" <?php } ?>><?php echo ($hotelNameData['hotelName']); ?></option>
            <?php } ?>
		  </select> 
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="destinationId" name="destinationId" class="select2 gridfield" autocomplete="off">
            <!-- <option value="">Destinations</option> -->
            <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and deletestatus = 0 order by name asc';  
		$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
            <option value="<?php echo ($resListing['name']); ?>" <?php if($_REQUEST['destinationId']==$resListing['name']){ ?> selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="starRating" name="starRating" class="select2 gridfield">
            <!-- <option value="">Star Rating</option> -->
            <?php
								$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1  order by hotelCategory asc');
								while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
								?>
            <option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($_REQUEST['starRating']==$hotelCategoryData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']); ?> Star</option>
            <?php } ?>
          </select>
          </label>
        </div></td>
		  <td width="1%"><input name="fromDate" id="fromDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:100px; margin-top:-9px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?>" placeholder="From Validity"/>
      </td>
      <td width="1%"><input name="toDate" id="toDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:100px; margin-top:-9px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['toDate'])); } ?>" placeholder="To Validity"/>
      </td>
	  <td width="10%"><div class="griddiv">
          <label>
          <select id="marketType" name="marketType" class="select2 gridfield">
            <option value="">All Market Type</option>
            <?php
			$marketDataq=GetPageRecord('id,name','marketMaster',' deletestatus=0 and status=1 order by name');  
			while($marketData=mysqli_fetch_array($marketDataq)){ 
			?>
            <option value="<?php echo strip($marketData['id']); ?>" <?php if($_REQUEST['marketType']==$marketData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($marketData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="roomType" name="roomType" class="select2 gridfield">
            <option value="">All Room Type</option>
            <?php
								$roomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,' deletestatus=0 and status=1 order by id asc');
								while($roomTypeData=mysqli_fetch_array($roomTypeQuery)){
								?>
            <option value="<?php echo strip($roomTypeData['id']); ?>" <?php if($_REQUEST['roomType']==$roomTypeData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($roomTypeData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="mealPlan" name="mealPlan" class="select2 gridfield">
            <option value="">All Meal Type</option>
            <?php
								$mealPlanQuery =GetPageRecord('name,id',_MEAL_PLAN_MASTER_,'1 and deletestatus=0');
								while($mealPlanData=mysqli_fetch_array($mealPlanQuery)){
								?>
            <option value="<?php echo strip($mealPlanData['id']); ?>" <?php if($_REQUEST['mealPlan']==$mealPlanData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($mealPlanData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td> 
      <td width="10%"><div class="griddiv">
          <label>
          <input type="button" name="Submit" value="   Search   " class="bluembutton" style="padding: 4px 10px !important; border-radius: 0px; margin-left: 0px; border: 1px solid #7a96ff !important;" onclick="loadcrmratessearch('1');">
          </label>
        </div></td>
    </tr>
  </table>
  <?php 

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
<div>
  <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd">
    <tr>
      <td colspan="21" style="background-color:#ddd; font-size:14px;color: #2ca1cc;"><strong>Total Records <span id="countRecordsid">0</span></strong></td>
    </tr>
    <tr style="text-transform:uppercase;">
      <td><div align="center"><strong>SR</strong></div></td>
	  <td><div align="left"><strong>Hotel&nbsp;Name</strong></div></td> 
      <td><div align="left"><strong>Destination</strong></div></td> 
      <td><div align="left"><strong>Rating</strong></div></td>
      <td><div align="left"><strong>Validity</strong></div></td>
	   <td><div align="left"><strong>Market&nbsp;Type</strong></div></td>
	  <td><div align="left"><strong>Tarif&nbsp;Type</strong></div></td>
      <td><div align="left"><strong>Room&nbsp;Type</strong></div></td>
      <td><div align="left"><strong>Meal&nbsp;Type</strong></div></td>  
      <td><div align="left"><strong>Currency</strong></div></td>
      <td><div align="left"><strong>Room&nbsp;Gst</strong></div></td>
      <td><div align="left"><strong>Single</strong></div></td>
      <td><div align="left"><strong>Double</strong></div></td>
      <td><div align="left"><strong>Triple</strong></div></td>
      <td><div align="left"><strong>Extra&nbsp;Bed</strong></div></td>
      <td><div align="left"><strong>CW&nbsp;Bed</strong></div></td>
      <td><div align="left"><strong>CN&nbsp;Bed</strong></div></td>
      <?php if($roomSix['status']==1){ ?>
      <td><div align="left"><strong>Six&nbsp;Bed</strong></div></td>
      <?php } if($roomEight['status']==1){ ?>
      <td><div align="left"><strong>Eight&nbsp;Bed</strong></div></td>
      <?php } if($roomTen['status']==1){ ?>
      <td><div align="left"><strong>Ten&nbsp;Bed</strong></div></td>
      <?php } if($roomQuad['status']==1){ ?>
      <td><div align="left"><strong>Quad&nbsp;Bed</strong></div></td>
      <?php } if($roomTeen['status']==1){ ?>
      <td><div align="left"><strong>Teen&nbsp;Bed</strong></div></td>
      <?php } ?>
	</tr>
    <?php
$hotelName=$_REQUEST['hotelName']; 
if($hotelName!=''){ 
$hotelNameSearch=' and serviceid="'.$hotelName.'"'; 
} 	 
$destinationId=$_REQUEST['destinationId']; 
if($destinationId!=''){ 
$destinationIdSearch=' and serviceid in (select id from packageBuilderHotelMaster where hotelCity="'.$destinationId.'")'; 
} 
$starRating=$_REQUEST['starRating']; 
if($starRating!=''){ 
$starRatingSearch=' and serviceid in (select id from packageBuilderHotelMaster where hotelCategoryId="'.$starRating.'")'; 
} 
$roomType=$_REQUEST['roomType']; 
if($roomType!=''){ 
$roomTypeSearch=' and roomType="'.$roomType.'"'; 
}
$mealPlan=$_REQUEST['mealPlan']; 
if($mealPlan!=''){ 
$mealPlanSearch=' and mealPlan="'.$mealPlan.'"'; 
}
$fromDate=$_REQUEST['fromDate']; 
if($fromDate!=''){ 
$fromDateSearch=' and sfromDate<="'.date('Y-m-d',strtotime($fromDate)).'" and stoDate>="'.date('Y-m-d',strtotime($fromDate)).'"'; 
} 
$toDate=$_REQUEST['toDate']; 
if($toDate!=''){
$toDateSearch=' and sfromDate<="'.date('Y-m-d',strtotime($toDate)).'" and stoDate>="'.date('Y-m-d',strtotime($toDate)).'"'; 
} 
$marketType=$_REQUEST['marketType']; 
if($marketType!=''){ 
$marketTypeSearch=' and marketType="'.$marketType.'"'; 
} 
$limitQuery = '';
if($_REQUEST['hotelName']=='' && $_REQUEST['destinationId']==''){
  $limitQuery = ' limit 10';
}
$sNo=0;	
$where='1 and serviceid!=0 '.$hotelNameSearch.' '.$destinationIdSearch.' '.$starRatingSearch.' '.$roomTypeSearch.' '.$mealPlanSearch.' '.$fromDateSearch.' '.$toDateSearch.' '.$marketTypeSearch.' order by serviceid,fromDate asc '.$limitQuery.' ';
$rs=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$where); 
$countHotels=mysqli_num_rows($rs);
?>
    <script>
$('#countRecordsid').text(<?php echo $countHotels; ?>);
</script>
    <?php
if($countHotels>0){ 
while($resultlisting= mysqli_fetch_array($rs)){ 
++$sNo; 
$hotelDataq=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'1 and id="'.$resultlisting['serviceid'].'"');  
$hotelData= mysqli_fetch_array($hotelDataq); 


$hcQ="";
$hcQ=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' id="'.$hotelData['hotelCategoryId'].'"');
$hcData=mysqli_fetch_array($hcQ);

?>
    <tr>
      <td align="left" valign="middle"><div align="center"><?php echo $sNo; ?></div></td> 
      <td align="left" valign="middle"><div align="left"><?php echo $hotelData['hotelName']; ?></div></td>
	    <td align="left" valign="middle"><div align="left"><?php echo $hotelData['hotelCity']; ?></div></td>
      <td align="left" valign="middle"><div align="left"><?php echo trim($hcData['hotelCategory']); ?> Star</div></td>
      <td align="left"><div align="left"><?php echo date('d-m-Y',strtotime($resultlisting['fromDate'])).'&nbsp;TO&nbsp;'.date('d-m-Y',strtotime($resultlisting['toDate'])); ?></div></td>
	   <td align="left" valign="middle"><div align="left">
	     <?php if($resultlisting['marketType']>0){ echo getMarketType($resultlisting['marketType']); }else{ echo 'All'; } ?>
       </div></td>
	   <td align="left" valign="middle"><div align="left"><?php echo getTariffType($resultlisting['tarifType']); ?></div></td>
      <td align="left"><div align="left">
        <?php  
				$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$resultlisting['roomType'].'"');  
				$editresult2sss=mysqli_fetch_array($rs12sss); 
				echo $editresult2sss['name'];
				?>      
      </div></td>
      <td align="left"><div align="left">
        <?php  
				$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$resultlisting['mealPlan'].'"');  
				$editresult2ss=mysqli_fetch_array($rs12ss); 
				echo $editresult2ss['name'];  
				?>      
      </div></td>  
      <td align="left" valign="middle">
        <div align="left">
          <?php
	$currencyDataq=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'1 and id="'.$resultlisting['currencyId'].'"'); 
	$currencyData=mysqli_fetch_array($currencyDataq);
	echo $currencyData['name'];
	?>
        </div></td>
      <td align="left">
        <div align="left"><?php echo getGstSlabById($resultlisting['roomGST']); ?> </div>
      </td>
      <td align="left">
        <div align="left"><?php $cur=clean($currencyData['name']);   ?> <?php echo $cur.' '.($resultlisting['singleoccupancy']); ?> </div>
      </td>
      <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['doubleoccupancy']); ?></div></td>
      <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['tripleoccupancy']); ?></div></td>
      <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['extraBed']); ?></div></td>
      <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['childwithbed']); ?></div></td>
      <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['childwithoutbed']); ?></div></td>
      <?php if($roomSix['status']==1){ ?>
      <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['sixBedRoom']); ?></div></td>
      <?php } if($roomEight['status']==1){ ?>
        <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['eightBedRoom']); ?></div></td>
        <?php } if($roomTen['status']==1){ ?>
        <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['tenBedRoom']); ?></div></td>
        <?php } if($roomQuad['status']==1){ ?>
        <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['quadRoom']); ?></div></td>
        <?php } if($roomTeen['status']==1){ ?>
        <td align="left"><div align="left"><?php echo $cur.' '.($resultlisting['teenRoom']); ?></div></td>
        <?php } ?>
    </tr>
    <?php } ?>
    <?php } else{ ?>
    <tr>
      <td colspan="19" align="center" style="color:#ff0000;">No Records Found.</td>
    </tr>
    <?php } ?>
  </table>
  </div>
  <?php } ?>
  <?php if($id==2){ ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="10%"><div class="griddiv">
          <label> 
		  <select id="entranceName" name="entranceName" class="select2 gridfield" autocomplete="off">
		  <!--<option value="">All Entrance</option>-->
		         <?php  
		$entranceNameDataq=GetPageRecord('id,entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'1 and entranceName!="" and status=1 and id in (select entranceNameId from '._DMC_ENTRANCE_RATE_MASTER_.') order by entranceName'); 
		while($entranceNameData=mysqli_fetch_array($entranceNameDataq)){  
		?>
            <option value="<?php echo ($entranceNameData['id']); ?>" <?php if($_REQUEST['entranceName']==$entranceNameData['id']){ ?> selected="selected" <?php } ?>><?php echo ($entranceNameData['entranceName']); ?></option>
            <?php } ?>
		  </select> 
          </label>
        </div></td>
		<td width="10%"><div class="griddiv">
          <label>
          <select id="destinationId" name="destinationId" class="select2 gridfield" autocomplete="off">
            <option value="">Destination</option>
            <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and deletestatus = 0 order by name asc';  
		$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
            <option value="<?php echo ($resListing['name']); ?>" <?php if($_REQUEST['destinationId']==$resListing['name']){ ?> selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
			<td width="10%"><div class="griddiv">
          <label>
          <select id="marketType" name="marketType" class="select2 gridfield">
            <option value="">All Market Type</option>
            <?php
			$marketDataq=GetPageRecord('id,name','marketMaster',' deletestatus=0 and status=1 order by name');  
			while($marketData=mysqli_fetch_array($marketDataq)){ 
			?>
            <option value="<?php echo strip($marketData['id']); ?>" <?php if($_REQUEST['marketType']==$marketData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($marketData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td> 
      <td width="10%"><div class="griddiv">
          <label>
          <select id="supplierId" name="supplierId" class="select2 gridfield">
            <option value="">All Supplier</option>
            <?php 
			$supplierDataq=GetPageRecord('id,name',_SUPPLIERS_MASTER_,'1 and deletestatus=0 and name!="" order by name'); 
			while($supplierData=mysqli_fetch_array($supplierDataq)){
			 ?>
            <option value="<?php echo strip($supplierData['id']); ?>" <?php if($_REQUEST['supplierId']==$supplierData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($supplierData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
      </div></td> 
		 <td width="1%"><input name="fromDate" id="fromDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?>" placeholder="From Validity"/>
      </td>
      <td width="1%"><input name="toDate" id="toDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['toDate'])); } ?>" placeholder="To Validity"/>
      </td>  
      <td width="10%"><div class="griddiv">
          <label>
          <input type="button" name="Submit" value="   Search   " class="bluembutton" style="padding: 4px 10px !important; border-radius: 0px; margin-left: 0px; border: 1px solid #7a96ff !important;" onclick="loadcrmratessearch('2');">
          </label>
        </div></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd">
    <tr>
      <td colspan="18" style="background-color:#ddd; font-size:14px;color: #2ca1cc;"><strong>Total Records <span id="countRecordsid">0</span></strong></td>
    </tr>
    <tr  style="text-transform:uppercase;">
      <td><div align="center"><strong>SR</strong></div></td>
	   <td><div align="left"><strong>Entrance&nbsp;Name</strong></div></td>
	   <td><div align="left"><strong>Destination</strong></div></td> 
	    <td><div align="left"><strong>Validity</strong></div></td> 
	   <td><div align="left"><strong>Market&nbsp;Type</strong></div></td> 
	   <td><div align="left"><strong>Supplier</strong></div></td>  
      <td><div align="left"><strong>Adult&nbsp;Cost</strong></div></td>
	  <td><div align="left"><strong>Child&nbsp;Cost</strong></div></td>
    <td><div align="left"><strong>Infant&nbsp;Cost</strong></div></td>
    </tr>
    <?php
$entranceName=$_REQUEST['entranceName']; 
if($entranceName!=''){ 
$entranceNameSearch=' and entranceNameId="'.$entranceName.'"'; 
} 	 
$destinationId=$_REQUEST['destinationId']; 
if($destinationId!=''){ 
$destinationIdSearch=' and entranceNameId in (select id from packageBuilderEntranceMaster where entranceCity="'.$destinationId.'")'; 
}  
$supplierId=$_REQUEST['supplierId']; 
if($supplierId!=''){ 
$supplierIdSearch=' and supplierId="'.$supplierId.'"'; 
} 
$fromDate=$_REQUEST['fromDate']; 
if($fromDate!=''){ 
$fromDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($fromDate)).'" and toDate>="'.date('Y-m-d',strtotime($fromDate)).'"'; 
} 
$toDate=$_REQUEST['toDate']; 
if($toDate!=''){
$toDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($toDate)).'" and toDate>="'.date('Y-m-d',strtotime($toDate)).'"'; 
} 
$marketType=$_REQUEST['marketType']; 
if($marketType!=''){ 
$marketTypeSearch=' and marketType="'.$marketType.'"'; 
} 

$limitQuery = '';
if($_REQUEST['entranceName']=='' && $_REQUEST['destinationId']==''){
  $limitQuery = ' limit 10';
}

$sNo=0;	
$where='1 and entranceNameId!=0 '.$entranceNameSearch.' '.$destinationIdSearch.' '.$supplierIdSearch.' '.$fromDateSearch.' '.$toDateSearch.' '.$marketTypeSearch.'  order by entranceNameId,fromDate asc '.$limitQuery.'';
$rs=GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,$where); 
$countEntrance=mysqli_num_rows($rs);
?>
    <script>
$('#countRecordsid').text(<?php echo $countEntrance; ?>);
</script>
    <?php
if($countEntrance>0){ 
while($resultlisting= mysqli_fetch_array($rs)){ 
++$sNo; 
$entranceDataq=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'1 and id="'.$resultlisting['entranceNameId'].'"');  
$entranceData= mysqli_fetch_array($entranceDataq); 
?>
    <tr>
      <td align="left" valign="middle"><div align="center"><?php echo $sNo; ?></div></td> 
      <td align="left" valign="middle"><div align="left"><?php echo $entranceData['entranceName']; ?></div></td>
	   <td align="left" valign="middle"><div align="left"><?php echo $entranceData['entranceCity']; ?></div></td>
	    <td align="left"><div align="left"><?php echo date('d-m-Y',strtotime($resultlisting['fromDate'])).'&nbsp;TO&nbsp;'.date('d-m-Y',strtotime($resultlisting['toDate'])); ?></div></td>
	   <td align="left" valign="middle"><div align="left">
	     <?php if($resultlisting['marketType']>0){ echo getMarketType($resultlisting['marketType']); }else{ echo 'All'; } ?>
       </div></td>
     
	   <td align="left"><div align="left">
	     <?php   
			$supplierDataq=GetPageRecord('name',_SUPPLIERS_MASTER_,'1 and id="'.$resultlisting['supplierId'].'"'); 
			$supplierData=mysqli_fetch_array($supplierDataq);
			echo $supplierData['name'];
			?>      
       </div></td>  
      <td align="left">
        <div align="left">
          <?php  
				$rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$resultlisting['currencyId'].'"'); 
				$editresult2=mysqli_fetch_array($rs2); 
				$cur=clean($editresult2['name']);  
				echo $cur.' '.strip($resultlisting['ticketAdultCost']); ?>
        </div></td>
	     <td align="left">
        <div align="left">
          <?php   
      		if($resultlisting['ticketchildCost']!="" && $resultlisting['ticketchildCost']!="NaN"){
      		$finalticketchildCost=$resultlisting['ticketchildCost'];
      		} else{
      		$finalticketchildCost=0;
      		}
  				echo $cur.' '.$finalticketchildCost;  
  				?>
        </div></td><td align="left">
        <div align="left">
          <?php   
          if($resultlisting['ticketinfantCost']!="" && $resultlisting['ticketinfantCost']!="NaN"){
          $finalticketinfantCost=$resultlisting['ticketinfantCost'];
          } else{
          $finalticketinfantCost=0;
          }
          echo $cur.' '.$finalticketinfantCost;  
          ?>
        </div></td>
    </tr>
    <?php } ?>
    <?php } else{ ?>
    <tr>
      <td colspan="18" align="center" style="color:#ff0000;">No Records Found.</td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
  <?php if($id==3){ ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="10%"><div class="griddiv">
          <label> 
		   <select id="transferName" name="transferName" class="select2 gridfield" autocomplete="off">
		  <option value="">All Transfer</option>
		         <?php  
		$transferNameDataq=GetPageRecord('id,transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'1 and transferCategory="transfer" and transferName!="" and status=1 and id in (select serviceid from '._DMC_TRANSFER_RATE_MASTER_.') order by transferName'); 
		while($transferNameData=mysqli_fetch_array($transferNameDataq)){  
		?>
            <option value="<?php echo ($transferNameData['id']); ?>" <?php if($_REQUEST['transferName']==$transferNameData['id']){ ?> selected="selected" <?php } ?>><?php echo ($transferNameData['transferName']); ?></option>
            <?php } ?>
		  </select> 
		   
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="destinationId" name="destinationId" class="select2 gridfield" autocomplete="off">
            <option value="">Destination</option>
            <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and deletestatus = 0 order by name asc';  
		$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
            <option value="<?php echo ($resListing['id']); ?>" <?php if($_REQUEST['destinationId']==$resListing['id']){ ?> selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
		<td width="10%"><div class="griddiv">
          <label>
          <select id="marketType" name="marketType" class="select2 gridfield">
            <option value="">All Market Type</option>
            <?php
			$marketDataq=GetPageRecord('id,name','marketMaster',' deletestatus=0 and status=1 order by name');  
			while($marketData=mysqli_fetch_array($marketDataq)){ 
			?>
            <option value="<?php echo strip($marketData['id']); ?>" <?php if($_REQUEST['marketType']==$marketData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($marketData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="supplierId" name="supplierId" class="select2 gridfield">
            <option value="">All Supplier</option>
            <?php 
			$supplierDataq=GetPageRecord('id,name',_SUPPLIERS_MASTER_,'1 and deletestatus=0 and name!="" order by name'); 
			while($supplierData=mysqli_fetch_array($supplierDataq)){
			 ?>
            <option value="<?php echo strip($supplierData['id']); ?>" <?php if($_REQUEST['supplierId']==$supplierData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($supplierData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>  
		 <td width="1%"><input name="fromDate" id="fromDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?>" placeholder="From Validity"/>
      </td>
      <td width="1%"><input name="toDate" id="toDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['toDate'])); } ?>" placeholder="To Validity"/>
      </td>
      <td width="10%"><div class="griddiv">
          <label>
          <input type="button" name="Submit" value="   Search   " class="bluembutton" style="padding: 4px 10px !important; border-radius: 0px; margin-left: 0px; border: 1px solid #7a96ff !important;" onclick="loadcrmratessearch('3');">
          </label>
        </div></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd">
    <tr>
      <td colspan="19" style="background-color:#ddd; font-size:14px;color: #2ca1cc;"><strong>Total Records <span id="countRecordsid">0</span></strong></td>
    </tr>
    <tr style=" text-transform:uppercase;">
      <td><div align="center"><strong>SR</strong></div></td>
	   <td><div align="left"><strong>Transfer&nbsp;Name</strong></div></td>
	   <td><div align="left"><strong>Vehicle&nbsp;Type</strong></div></td>
	   <td><div align="left"><strong>Vehicle&nbsp;Name</strong></div></td>
      <td><div align="left"><strong>Destination</strong></div></td> 
      <td><div align="left"><strong>Validity</strong></div></td>
	  <td><div align="left"><strong>Market&nbsp;Type</strong></div></td>
      <td><div align="left"><strong>Supplier</strong></div></td> 
	   <td><div align="left"><strong>GST&nbsp;SLAB</strong></div></td>
      <td><div align="left"><strong>Vehicle&nbsp;Cost</strong></div></td>
	  <td><div align="left"><strong>Parking</strong></div></td>
    </tr>
    <?php
$transferName=$_REQUEST['transferName']; 
if($transferName!=''){   
$transferNameSearch=' and serviceid="'.$transferName.'"'; 
}  
$destinationId=$_REQUEST['destinationId']; 
if($destinationId!=''){ 
$destinationIdSearch=' and serviceid in (select id from '._PACKAGE_BUILDER_TRANSFER_MASTER.' where 1 and FIND_IN_SET('.$destinationId.',destinationId))'; 
}  
$supplierId=$_REQUEST['supplierId']; 
if($supplierId!=''){ 
$supplierIdSearch=' and supplierId="'.$supplierId.'"'; 
} 
$fromDate=$_REQUEST['fromDate']; 
if($fromDate!=''){ 
$fromDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($fromDate)).'" and toDate>="'.date('Y-m-d',strtotime($fromDate)).'"'; 
} 
$toDate=$_REQUEST['toDate']; 
if($toDate!=''){
$toDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($toDate)).'" and toDate>="'.date('Y-m-d',strtotime($toDate)).'"'; 
} 
$marketType=$_REQUEST['marketType']; 
if($marketType!=''){ 
$marketTypeSearch=' and marketType="'.$marketType.'"'; 
} 

$limitQuery = '';
if($_REQUEST['entranceName']=='' && $_REQUEST['destinationId']==''){
  $limitQuery = ' limit 10';
}
$sNo=0;	
$where='1 and serviceid!=0 and serviceid in (select id from '._PACKAGE_BUILDER_TRANSFER_MASTER.' where 1 and transferCategory="transfer") '.$transferNameSearch.' '.$destinationIdSearch.' '.$supplierIdSearch.' '.$fromDateSearch.' '.$toDateSearch.' '.$marketTypeSearch.'   order by serviceid,fromDate asc  '.$limitQuery.'';
$rs=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,$where); 
$countTransfer=mysqli_num_rows($rs);
?>
    <script>
$('#countRecordsid').text(<?php echo $countTransfer; ?>);
</script>
    <?php
if($countTransfer>0){ 
while($resultlisting= mysqli_fetch_array($rs)){ 
++$sNo; 
$transferDataq=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'1 and id="'.$resultlisting['serviceid'].'"');  
$transferData= mysqli_fetch_array($transferDataq); 

$rsv=GetPageRecord('model,carType',_VEHICLE_MASTER_MASTER_,'id='.$resultlisting['vehicleModelId'].' order by id asc');  
$vehicleDetails=mysqli_fetch_array($rsv); 
		
?>
    <tr>
      <td align="left" valign="middle"><div align="center"><?php echo $sNo; ?></div></td>
	   <td align="left" valign="middle"><div align="left"><?php echo $transferData['transferName']; ?></div></td>
	    
	   <td align="left"><div align="left">
	     <?php  
	echo getVehicleTypeName($vehicleDetails['carType']);
 
	?>
       </div></td>

	<td align="left"><div align="left"><?php echo $vehicleDetails['model']; ?></div></td>
	 
       
	  <td align="left">
	    <div align="left">
	      <?php
	    $dest='';
		$destinationId = explode(',',$transferData['destinationId']); 
		foreach($destinationId as $val){
		$dest.= getDestination($val).',';
		} 
		echo rtrim($dest,','); 
		?>
        </div></td> 
      <td align="left"><div align="left"><?php echo date('d-m-Y',strtotime($resultlisting['fromDate'])).'&nbsp;TO&nbsp;'.date('d-m-Y',strtotime($resultlisting['toDate'])); ?></div></td>
      <td align="left" valign="middle"><div align="left">
        <?php if($resultlisting['marketType']>0){ echo getMarketType($resultlisting['marketType']); }else{ echo 'All'; } ?>
      </div></td>
	  <td align="left"><div align="left">
	    <?php   
			$supplierDataq=GetPageRecord('name',_SUPPLIERS_MASTER_,'1 and id="'.$resultlisting['supplierId'].'"'); 
			$supplierData=mysqli_fetch_array($supplierDataq);
			echo $supplierData['name'];
			?>      
      </div></td> 
	  
	   <td align="left"><div align="left"> 
			<?php if($resultlisting['gstTax']!="" && $resultlisting['gstTax']!=0){ echo getGstValueById($resultlisting['gstTax']); ?> % <?php } ?>
      </div></td> 
	  
      <td align="left">
        <div align="left">
          <?php  
				$rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$resultlisting['currencyId'].'"'); 
				$editresult2=mysqli_fetch_array($rs2); 
				$cur=clean($editresult2['name']);  
				echo $cur.' '.strip($resultlisting['vehicleCost']); ?> 
          </div></td>
		  
		   <td align="left">
        <div align="left">
          <?php echo $cur.'&nbsp;'.strip($resultlisting['parkingFee']); ?>
          </div></td>
		  
		  </tr>
    <?php } ?>
    <?php } else{ ?>
    <tr>
      <td colspan="19" align="center" style="color:#ff0000;">No Records Found.</td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
   <?php if($id==4){ ?>
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="10%"><div class="griddiv">
          <label> 
		   <select id="transportationName" name="transportationName" class="select2 gridfield" autocomplete="off">
		  <option value="">All Transportation</option>
		         <?php  
		$transportationNameDataq=GetPageRecord('id,transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'1 and transferCategory="transportation" and transferName!="" and status=1 and id in (select serviceid from '._DMC_TRANSFER_RATE_MASTER_.') order by transferName'); 
		while($transportationNameData=mysqli_fetch_array($transportationNameDataq)){  
		?>
            <option value="<?php echo ($transportationNameData['id']); ?>" <?php if($_REQUEST['transportationName']==$transportationNameData['id']){ ?> selected="selected" <?php } ?>><?php echo ($transportationNameData['transferName']); ?></option>
            <?php } ?>
		  </select> 
		   
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="destinationId" name="destinationId" class="select2 gridfield" autocomplete="off">
            <option value="">Destination</option>
            <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and deletestatus = 0 order by name asc';  
		$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
            <option value="<?php echo ($resListing['id']); ?>" <?php if($_REQUEST['destinationId']==$resListing['id']){ ?> selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
		<td width="10%"><div class="griddiv">
          <label>
          <select id="marketType" name="marketType" class="select2 gridfield">
            <option value="">All Market Type</option>
            <?php
			$marketDataq=GetPageRecord('id,name','marketMaster',' deletestatus=0 and status=1 order by name');  
			while($marketData=mysqli_fetch_array($marketDataq)){ 
			?>
            <option value="<?php echo strip($marketData['id']); ?>" <?php if($_REQUEST['marketType']==$marketData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($marketData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="supplierId" name="supplierId" class="select2 gridfield">
            <option value="">All Supplier</option>
            <?php 
			$supplierDataq=GetPageRecord('id,name',_SUPPLIERS_MASTER_,'1 and deletestatus=0 and name!="" order by name'); 
			while($supplierData=mysqli_fetch_array($supplierDataq)){
			 ?>
            <option value="<?php echo strip($supplierData['id']); ?>" <?php if($_REQUEST['supplierId']==$supplierData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($supplierData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>  
		 <td width="1%"><input name="fromDate" id="fromDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?>" placeholder="From Validity"/>
      </td>
      <td width="1%"><input name="toDate" id="toDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['toDate'])); } ?>" placeholder="To Validity"/>
      </td>
      <td width="10%"><div class="griddiv">
          <label>
          <input type="button" name="Submit" value="   Search   " class="bluembutton" style="padding: 4px 10px !important; border-radius: 0px; margin-left: 0px; border: 1px solid #7a96ff !important;" onclick="loadcrmratessearch('4');">
          </label>
        </div></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd">
    <tr>
      <td colspan="19" style="background-color:#ddd; font-size:14px;color: #2ca1cc;"><strong>Total Records <span id="countRecordsid">0</span></strong></td>
    </tr>
    <tr style=" text-transform:uppercase;">
      <td><div align="center"><strong>SR</strong></div></td>
	   <td><div align="left"><strong>Transportation&nbsp;Name</strong></div></td>
	   <td><div align="left"><strong>Vehicle&nbsp;Type</strong></div></td>
	   <td><div align="left"><strong>Vehicle&nbsp;Name</strong></div></td>
      <td><div align="left"><strong>Destination</strong></div></td> 
      <td><div align="left"><strong>Validity</strong></div></td>
	  <td><div align="left"><strong>Market&nbsp;Type</strong></div></td>
      <td><div align="left"><strong>Supplier</strong></div></td> 
	   <td><div align="left"><strong>GST&nbsp;SLAB</strong></div></td>
      <td><div align="left"><strong>Vehicle&nbsp;Cost</strong></div></td>
	  <td><div align="left"><strong>Parking</strong></div></td>
    </tr>
    <?php
$transportationName=$_REQUEST['transportationName']; 
if($transportationName!=''){   
$transportationNameSearch=' and serviceid="'.$transportationName.'"'; 
}  
$destinationId=$_REQUEST['destinationId']; 
if($destinationId!=''){ 
$destinationIdSearch=' and serviceid in (select id from '._PACKAGE_BUILDER_TRANSFER_MASTER.' where 1 and FIND_IN_SET('.$destinationId.',destinationId))'; 
}  
$supplierId=$_REQUEST['supplierId']; 
if($supplierId!=''){ 
$supplierIdSearch=' and supplierId="'.$supplierId.'"'; 
} 
$fromDate=$_REQUEST['fromDate']; 
if($fromDate!=''){ 
$fromDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($fromDate)).'" and toDate>="'.date('Y-m-d',strtotime($fromDate)).'"'; 
} 
$toDate=$_REQUEST['toDate']; 
if($toDate!=''){
$toDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($toDate)).'" and toDate>="'.date('Y-m-d',strtotime($toDate)).'"'; 
} 
$marketType=$_REQUEST['marketType']; 
if($marketType!=''){ 
$marketTypeSearch=' and marketType="'.$marketType.'"'; 
} 

$limitQuery = '';
if($_REQUEST['entranceName']=='' && $_REQUEST['destinationId']==''){
  $limitQuery = ' limit 10';
}
$sNo=0;	
$where='1 and serviceid!=0 and serviceid in (select id from '._PACKAGE_BUILDER_TRANSFER_MASTER.' where 1 and transferCategory="transportation") '.$transportationNameSearch.' '.$destinationIdSearch.' '.$supplierIdSearch.' '.$fromDateSearch.' '.$toDateSearch.' '.$marketTypeSearch.'  order by serviceid,fromDate asc  '.$limitQuery.'';
$rs=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,$where); 
$countTransportation=mysqli_num_rows($rs);
?>
    <script>
$('#countRecordsid').text(<?php echo $countTransportation; ?>);
</script>
    <?php
if($countTransportation>0){ 
while($resultlisting= mysqli_fetch_array($rs)){ 
++$sNo; 
$transportationDataq=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'1 and id="'.$resultlisting['serviceid'].'"');  
$transportationData= mysqli_fetch_array($transportationDataq); 

$rsv=GetPageRecord('model,carType',_VEHICLE_MASTER_MASTER_,'id='.$resultlisting['vehicleModelId'].' order by id asc');  
$vehicleDetails=mysqli_fetch_array($rsv); 
		
?>
    <tr>
      <td align="left" valign="middle"><div align="center"><?php echo $sNo; ?></div></td>
	   <td align="left" valign="middle"><div align="left"><?php echo $transportationData['transferName']; ?></div></td>
	    
	   <td align="left"><div align="left">
	     <?php  
	echo getVehicleTypeName($vehicleDetails['carType']);
 
	?>
       </div></td>

	<td align="left"><div align="left"><?php echo $vehicleDetails['model']; ?></div></td>
	 
       
	  <td align="left">
	    <div align="left">
	      <?php
	    $dest='';
		$destinationId = explode(',',$transportationData['destinationId']); 
		foreach($destinationId as $val){
		$dest.= getDestination($val).',';
		} 
		echo rtrim($dest,','); 
		?>
        </div></td> 
      <td align="left"><div align="left"><?php echo date('d-m-Y',strtotime($resultlisting['fromDate'])).'&nbsp;TO&nbsp;'.date('d-m-Y',strtotime($resultlisting['toDate'])); ?></div></td>
      <td align="left" valign="middle"><div align="left">
        <?php if($resultlisting['marketType']>0){ echo getMarketType($resultlisting['marketType']); }else{ echo 'All'; } ?>
      </div></td>
	  <td align="left"><div align="left">
	    <?php   
			$supplierDataq=GetPageRecord('name',_SUPPLIERS_MASTER_,'1 and id="'.$resultlisting['supplierId'].'"'); 
			$supplierData=mysqli_fetch_array($supplierDataq);
			echo $supplierData['name'];
			?>      
      </div></td> 
	  
	   <td align="left"><div align="left"> 
			<?php if($resultlisting['gstTax']!="" && $resultlisting['gstTax']!=0){ echo getGstValueById($resultlisting['gstTax']); ?> % <?php } ?>
      </div></td> 
	  
      <td align="left">
        <div align="left">
          <?php  
				$rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$resultlisting['currencyId'].'"'); 
				$editresult2=mysqli_fetch_array($rs2); 
				$cur=clean($editresult2['name']);  
				echo $cur.' '.strip($resultlisting['vehicleCost']); ?> 
          </div></td>
		  
		   <td align="left">
        <div align="left">
          <?php echo $cur.'&nbsp;'.strip($resultlisting['parkingFee']); ?>
          </div></td>
		  
		  </tr>
    <?php } ?>
    <?php } else{ ?>
    <tr>
      <td colspan="19" align="center" style="color:#ff0000;">No Records Found.</td>
    </tr>
    <?php } ?>
  </table> 
  <?php } ?>
  
 
<?php 

// Activity Start

if($id==5){ ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="10%"><div class="griddiv">
          <label> 
      <select id="activityName" name="activityName" class="select2 gridfield" autocomplete="off">
      <option value="">All Activity</option>
             <?php  
    $activityNameDataq=GetPageRecord('id,otherActivityName',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'1 and otherActivityName!="" and status=1 and id in (select otherActivityNameId from dmcotherActivityRate ) order by otherActivityName'); 
    while($activityNameData=mysqli_fetch_array($activityNameDataq)){  
    ?>
            <option value="<?php echo ($activityNameData['id']); ?>" <?php if($_REQUEST['activityName']==$activityNameData['id']){ ?> selected="selected" <?php } ?>><?php echo ($activityNameData['otherActivityName']); ?></option>
            <?php } ?>
      </select> 
          </label>
        </div></td>
    <td width="10%"><div class="griddiv">
          <label>
          <select id="destinationId" name="destinationId" class="select2 gridfield" autocomplete="off">
            <!-- <option value="">Destination</option> -->
            <?php 
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';    
    $where=' 1 and deletestatus = 0 order by name asc';  
    $rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
    while($resListing=mysqli_fetch_array($rs)){  
    ?>
            <option value="<?php echo ($resListing['name']); ?>" <?php if($_REQUEST['destinationId']==$resListing['name']){ ?> selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td>
      <td width="10%"><div class="griddiv">
          <label>
          <select id="marketType" name="marketType" class="select2 gridfield">
            <option value="">All Market Type</option>
            <?php
      $marketDataq=GetPageRecord('id,name','marketMaster',' deletestatus=0 and status=1 order by name');  
      while($marketData=mysqli_fetch_array($marketDataq)){ 
      ?>
            <option value="<?php echo strip($marketData['id']); ?>" <?php if($_REQUEST['marketType']==$marketData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($marketData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
        </div></td> 
      <td width="10%"><div class="griddiv">
          <label>
          <select id="supplierId" name="supplierId" class="select2 gridfield">
            <option value="">All Supplier</option>
            <?php 
      $supplierDataq=GetPageRecord('id,name',_SUPPLIERS_MASTER_,'1 and deletestatus=0 and name!="" order by name'); 
      while($supplierData=mysqli_fetch_array($supplierDataq)){
       ?>
            <option value="<?php echo strip($supplierData['id']); ?>" <?php if($_REQUEST['supplierId']==$supplierData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($supplierData['name']); ?></option>
            <?php } ?>
          </select>
          </label>
      </div></td> 
     <td width="1%"><input name="fromDate" id="fromDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?>" placeholder="From Validity"/>
      </td>
      <td width="1%"><input name="toDate" id="toDate" type="text" readonly=""  class="newDatePicker gridfield" style="width:170px; margin-top:-9px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['toDate'])); } ?>" placeholder="To Validity"/>
      </td>  
      <td width="10%"><div class="griddiv">
          <label>
          <input type="button" name="Submit" value="   Search   " class="bluembutton" style="padding: 4px 10px !important; border-radius: 0px; margin-left: 0px; border: 1px solid #7a96ff !important;" onclick="loadcrmratessearch('5');">
          </label>
        </div></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd">
    <tr>
      <td colspan="18" style="background-color:#ddd; font-size:14px;color: #2ca1cc;"><strong>Total Records <span id="countRecordsid">0</span></strong></td>
    </tr>
    <tr  style="text-transform:uppercase;">
      <td><div align="center"><strong>SR</strong></div></td>
     <td><div align="left"><strong>Activity&nbsp;Name</strong></div></td>
     <td><div align="left"><strong>Destination</strong></div></td> 
      <td><div align="left"><strong>Validity</strong></div></td> 
     <td><div align="left"><strong>Market&nbsp;Type</strong></div></td> 
     <td><div align="left"><strong>Supplier</strong></div></td>  
      <td><div align="left"><strong>Activity&nbsp;Cost</strong></div></td>
    <td><div align="left"><strong>Max&nbsp;Pax</strong></div></td>
      <td><div align="left"><strong>Per&nbsp;Pax&nbsp;Cost</strong></div></td>
    </tr>
    <?php
$activityName=$_REQUEST['activityName']; 
if($activityName!=''){ 
$activityNameSearch=' and otherActivityNameId="'.$activityName.'"'; 
}    
$destinationId=$_REQUEST['destinationId']; 
if($destinationId!=''){ 
$destinationIdSearch=' and otherActivityNameId in (select id from packageBuilderActivityMaster where activityCity="'.$destinationId.'")'; 
}  
$supplierId=$_REQUEST['supplierId']; 
if($supplierId!=''){ 
$supplierIdSearch=' and supplierId="'.$supplierId.'"'; 
} 
$fromDate=$_REQUEST['fromDate']; 
if($fromDate!=''){ 
$fromDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($fromDate)).'" and toDate>="'.date('Y-m-d',strtotime($fromDate)).'"'; 
} 
$toDate=$_REQUEST['toDate']; 
if($toDate!=''){
$toDateSearch=' and fromDate<="'.date('Y-m-d',strtotime($toDate)).'" and toDate>="'.date('Y-m-d',strtotime($toDate)).'"'; 
} 
$marketType=$_REQUEST['marketType']; 
if($marketType!=''){ 
$marketTypeSearch=' and marketType="'.$marketType.'"'; 
} 

$limitQuery = '';
if($_REQUEST['activityName']=='' && $_REQUEST['destinationId']==''){
  $limitQuery = ' limit 10';
}

$sNo=0; 
$where='1 and otherActivityNameId!=0 '.$activityNameSearch.' '.$destinationIdSearch.' '.$supplierIdSearch.' '.$fromDateSearch.' '.$toDateSearch.' '.$marketTypeSearch.'  order by otherActivityNameId,fromDate asc '.$limitQuery.'';
$rs=GetPageRecord('*','dmcotherActivityRate',$where); 
$countActivity=mysqli_num_rows($rs);
?>
    <script>
$('#countRecordsid').text(<?php echo $countActivity; ?>);
</script>
    <?php
if($countActivity>0){ 
while($resultlisting= mysqli_fetch_array($rs)){ 
++$sNo; 
$activityDataq=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'1 and id="'.$resultlisting['otherActivityNameId'].'"');  
$activityData= mysqli_fetch_array($activityDataq); 
?>
    <tr>
      <td align="left" valign="middle"><div align="center"><?php echo $sNo; ?></div></td> 
      <td align="left" valign="middle"><div align="left"><?php echo $activityData['otherActivityName']; ?></div></td>
     <td align="left" valign="middle"><div align="left"><?php echo $activityData['otherActivityCity']; ?></div></td>
      <td align="left"><div align="left"><?php echo date('d-m-Y',strtotime($resultlisting['fromDate'])).'&nbsp;TO&nbsp;'.date('d-m-Y',strtotime($resultlisting['toDate'])); ?></div></td>
     <td align="left" valign="middle"><div align="left">
       <?php if($resultlisting['marketType']>0){ echo getMarketType($resultlisting['marketType']); }else{ echo 'All'; } ?>
       </div></td>
     
     <td align="left"><div align="left">
       <?php   
      $supplierDataq=GetPageRecord('name',_SUPPLIERS_MASTER_,'1 and id="'.$resultlisting['supplierId'].'"'); 
      $supplierData=mysqli_fetch_array($supplierDataq);
      echo $supplierData['name'];
      ?>      
       </div></td>  
      <td align="left">
        <div align="left">
          <?php  
        $rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$resultlisting['currencyId'].'"'); 
        $editresult2=mysqli_fetch_array($rs2); 
        $cur=clean($editresult2['name']);  
        echo $cur.' '.strip($resultlisting['activityCost']); ?>
        </div></td>

      <td align="left">
        <div align="left">
        <?php  
        echo strip($resultlisting['maxpax']);  
        ?>
        </div></td>

      <td align="left">
        <div align="left">
        <?php  
        echo $cur.' '.strip($resultlisting['perPaxCost']);  
        ?>
        </div></td>
    
    </tr>
    <?php } ?>
    <?php } else{ ?>
    <tr>
      <td colspan="18" align="center" style="color:#ff0000;">No Records Found.</td>
    </tr>
    <?php } ?>
  </table>
  <?php } 


// Activity End

  ?>



  
  
</div>
<script>
function loadcrmratessearch(id){
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(id==1){
var hotelName=encodeURIComponent($('#hotelName').val());
var destinationId=encodeURIComponent($('#destinationId').val());
var starRating=encodeURIComponent($('#starRating').val());
var roomType=encodeURIComponent($('#roomType').val());
var mealPlan=encodeURIComponent($('#mealPlan').val()); 
var fromDate=encodeURIComponent($('#fromDate').val());
var toDate=encodeURIComponent($('#toDate').val()); 
var marketType=encodeURIComponent($('#marketType').val());
$('#loadcrmrates').load('loadcrmrates.php?id='+id+'&hotelName='+hotelName+'&destinationId='+destinationId+'&starRating='+starRating+'&roomType='+roomType+'&mealPlan='+mealPlan+'&fromDate='+fromDate+'&toDate='+toDate+'&marketType='+marketType); 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(id==2){
var entranceName=encodeURIComponent($('#entranceName').val());
var destinationId=encodeURIComponent($('#destinationId').val());
var supplierId=encodeURIComponent($('#supplierId').val());
var fromDate=encodeURIComponent($('#fromDate').val());
var toDate=encodeURIComponent($('#toDate').val()); 
var marketType=encodeURIComponent($('#marketType').val());
$('#loadcrmrates').load('loadcrmrates.php?id='+id+'&entranceName='+entranceName+'&destinationId='+destinationId+'&supplierId='+supplierId+'&fromDate='+fromDate+'&toDate='+toDate+'&marketType='+marketType); 
} 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(id==5){
var activityName=encodeURIComponent($('#activityName').val());
var destinationId=encodeURIComponent($('#destinationId').val());
var supplierId=encodeURIComponent($('#supplierId').val());
var fromDate=encodeURIComponent($('#fromDate').val());
var toDate=encodeURIComponent($('#toDate').val()); 
var marketType=encodeURIComponent($('#marketType').val());
$('#loadcrmrates').load('loadcrmrates.php?id='+id+'&activityName='+activityName+'&destinationId='+destinationId+'&supplierId='+supplierId+'&fromDate='+fromDate+'&toDate='+toDate+'&marketType='+marketType); 
} 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(id==3){
var transferName=encodeURIComponent($('#transferName').val());
var destinationId=encodeURIComponent($('#destinationId').val());
var supplierId=encodeURIComponent($('#supplierId').val());
var fromDate=encodeURIComponent($('#fromDate').val());
var toDate=encodeURIComponent($('#toDate').val()); 
var marketType=encodeURIComponent($('#marketType').val());
$('#loadcrmrates').load('loadcrmrates.php?id='+id+'&transferName='+transferName+'&destinationId='+destinationId+'&supplierId='+supplierId+'&fromDate='+fromDate+'&toDate='+toDate+'&marketType='+marketType); 
} 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(id==4){
var transportationName=encodeURIComponent($('#transportationName').val());
var destinationId=encodeURIComponent($('#destinationId').val());
var supplierId=encodeURIComponent($('#supplierId').val());
var fromDate=encodeURIComponent($('#fromDate').val());
var toDate=encodeURIComponent($('#toDate').val()); 
var marketType=encodeURIComponent($('#marketType').val());
$('#loadcrmrates').load('loadcrmrates.php?id='+id+'&transportationName='+transportationName+'&destinationId='+destinationId+'&supplierId='+supplierId+'&fromDate='+fromDate+'&toDate='+toDate+'&marketType='+marketType); 
} 






} 
</script>
