<?php
include "inc.php"; 
$rs="";  
$rs=GetPageRecord('*','quotationHotelRateMaster',' id="'.$_REQUEST['tariffId'].'" '); 
if(mysqli_num_rows($rs)>0 && $_REQUEST['tblNum'] == 2){ 
	$dmcHotel=mysqli_fetch_array($rs);
}else{ 
	$rs="";
	$rs=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' id="'.$_REQUEST['tariffId'].'" '); 
	$dmcHotel=mysqli_fetch_array($rs); 
}
$rsa2="";
$rsa2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$dmcHotel['currencyId'].'"'); 
$editresult2=mysqli_fetch_array($rsa2); 
$cur=clean($editresult2['name']);

$rs2="";
$rs2=GetPageRecord('hotelName',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$dmcHotel['serviceid'].'"'); 
$editresult2=mysqli_fetch_array($rs2);  

$rs3="";
$rs3=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"'); 
$quotationResult=mysqli_fetch_array($rs3);  

?>  

<style>

.allfields{

	padding: 5px;

    text-align: center;

    width: 70px;

    border: 1px solid #ccc;

    border-radius: 3px;

	}

</style>

<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;">

<table width="100%" border="0"  bgcolor="#DDDDDD"  cellspacing="0" cellpadding="5" >

  <tr>

    <td width="93%" align="left"><strong style="font-size: 18px;padding-left: 15PX;"><?php echo clean($editresult2['hotelName']); ?> - Price <?php echo $cur; ?></strong></td>

    <td width="8%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#viewinfo').hide();"></i></td>

  </tr> 

</table>

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addquohotelroomprice" target="actoinfrm"  id="addquohotelroomprice">

  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable" style=" margin-bottom:20px;"> 
     <tr>
      <th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Single&nbsp;Cost </strong></th>
			<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Double&nbsp;Cost </strong></th>
			<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Extra&nbsp;Cost(A) </strong></th>
			<?php if($quotationResult['quadNoofRoom']>0){ ?>
			<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Quad&nbsp;Room </strong></th>
			<?php } if($quotationResult['teenNoofRoom']>0){?>
			<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Teen&nbsp;Cost </strong></th>
			<?php } ?>
			<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">CWBed(C) </strong></th>
			<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">CNBed(C) </strong></th>
      <th align="center" bgcolor="#DDDDDD" ><strong>Room&nbsp;TAX&nbsp;SLAB</strong></th>
      <th align="center" bgcolor="#DDDDDD"><strong>Meal&nbsp;TAX&nbsp;SLAB</strong></th>
     </tr> 
  <tr>
		<td align="center"><input name="singleoccupancy" type="text" class="allfields numeric"  id="signoccupancy" maxlength="6"  value="<?php echo strip($dmcHotel['singleoccupancy']); ?>" /></td>
    <td align="center"><input name="doubleoccupancy" type="text" class="allfields numeric"  id="doubleoccupancy" maxlength="6"  value="<?php echo strip($dmcHotel['doubleoccupancy']); ?>" /></td> 
	 	<td align="center"><input name="extraoccupancy" type="text" class="allfields numeric"  id="extraoccupancy" maxlength="6"  value="<?php echo strip($dmcHotel['extraBed']); ?>" /></td>
		 <?php if($quotationResult['quadNoofRoom']>0){ ?>
		 <td align="center"><input name="quadRoom" type="text" class="allfields numeric"  id="quadRoom" maxlength="6"  value="<?php echo strip($dmcHotel['quadRoom']); ?>" /></td>
		 <?php } if($quotationResult['teenNoofRoom']>0){?>
		 <td align="center"><input name="teenRoom" type="text" class="allfields numeric"  id="teenRoom" maxlength="6"  value="<?php echo strip($dmcHotel['teenRoom']); ?>" /></td>
		 <?php } ?>
	 	<td align="center"><input name="childwithbed" type="text" class="allfields numeric"  id="childwithbed" maxlength="6"  value="<?php echo strip($dmcHotel['childwithbed']); ?>" /></td> 
	 	<td align="center"><input name="childwithoutbed" type="text" class="allfields numeric"  id="childwithoutbed" maxlength="6"  value="<?php echo strip($dmcHotel['childwithoutbed']); ?>" /></td> 
    <td align="center">
    	<select id="roomGST" name="roomGST" class="allfields " displayname="GST Tax" autocomplete="off" style="width:100px" > 
			<?php 
			$rs2="";
			$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1 order by gstSlabName asc'); 
			while($gstSlabData=mysqli_fetch_array($rs2)){
			?>
			<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id'] == $dmcHotel['roomGST']){ ?> selected="selected" <?php } ?>><?php echo $gstSlabData['gstSlabName'];?></option>
			<?php
			}	
			?>

			</select>
		</td>
		<td align="center">
			<select id="mealGST" name="mealGST" class="allfields " displayname="GST Tax" autocomplete="off" style="width:100px" > 
			<?php 
			$rs2="";
			$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1 order by gstSlabName asc'); 
			while($gstSlabData=mysqli_fetch_array($rs2)){
			?>
			<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id'] == $dmcHotel['mealGST']){ ?> selected="selected" <?php } ?>><?php echo $gstSlabData['gstSlabName'];?></option>
			<?php
			}	
			?>
			</select>
		</td>  
  </tr>  
  <tr>
  	<?php if($quotationResult['sixNoofBedRoom']>0){ ?>
      <th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Six&nbsp;Cost </strong></th>
	  <?php } if($quotationResult['eightNoofBedRoom']>0){ ?>
		<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Eight&nbsp;Cost </strong></th>
		<?php } if($quotationResult['tenNoofBedRoom']>0){ ?>
		<th align="left" bgcolor="#DDDDDD" ><strong style="padding-left: 15PX;">Ten&nbsp;Cost </strong></th>
		<?php } ?>
		<th align="center" bgcolor="#DDDDDD"><strong>Breakfast(A)</strong></th>
    	<th align="center" bgcolor="#DDDDDD"><strong>Lunch(A)</strong></th>
    	<th align="center" bgcolor="#DDDDDD"><strong>Dinner(A)</strong></th>
    	<th align="center" bgcolor="#DDDDDD"><strong>Breakfast(C)</strong></th>
    	<th align="center" bgcolor="#DDDDDD"><strong>Lunch(C)</strong></th>
    	<th align="center" bgcolor="#DDDDDD"><strong>Dinner(C)</strong></th>
      	
     </tr> 
	<tr>
	<?php if($quotationResult['sixNoofBedRoom']>0){ ?>
	<td align="center"><input name="sixBedRoom" type="text" class="allfields numeric"  id="sixBedRoom" maxlength="6"  value="<?php echo strip($dmcHotel['sixBedRoom']); ?>" /></td>
	<?php } if($quotationResult['eightNoofBedRoom']>0){ ?>
	<td align="center"><input name="eightBedRoom" type="text" class="allfields numeric"  id="eightBedRoom" maxlength="6"  value="<?php echo strip($dmcHotel['eightBedRoom']); ?>" /></td>
	<?php } if($quotationResult['tenNoofBedRoom']>0){ ?>
	<td align="center"><input name="tenBedRoom" type="text" class="allfields numeric"  id="tenBedRoom" maxlength="6"  value="<?php echo strip($dmcHotel['tenBedRoom']); ?>" /></td>
	<?php } ?>
	<td align="center"><input name="breakfast" type="text" class="allfields numeric"  id="breakfast" maxlength="6"  value="<?php echo strip($dmcHotel['breakfast']); ?>" /></td>
	<td align="center"><input name="lunch" type="text" class="allfields numeric"  id="lunch" maxlength="6"  value="<?php echo strip($dmcHotel['lunch']); ?>" /></td>
	<td align="center"><input name="dinner" type="text" class="allfields numeric"  id="dinner" maxlength="6"  value="<?php echo strip($dmcHotel['dinner']); ?>" /></td> 
	<td align="center"><input name="childBreakfast" type="text" class="allfields numeric"  id="childBreakfast" maxlength="6"  value="<?php echo strip($dmcHotel['childBreakfast']); ?>" /></td> 
	<td align="center"><input name="childLunch" type="text" class="allfields numeric"  id="childLunch" maxlength="6"  value="<?php echo strip($dmcHotel['childLunch']); ?>" /></td> 
	<td align="center"><input name="childDinner" type="text" class="allfields numeric"  id="childDinner" maxlength="6"  value="<?php echo strip($dmcHotel['childDinner']); ?>" /></td> 
	

	</tr>
  <tr>
  <th align="center" bgcolor="#DDDDDD" ><strong>TAC(%)</strong></th>
    <th align="center" bgcolor="#DDDDDD" ><strong>MarkupType</strong></th>
    <th align="center" bgcolor="#DDDDDD" ><strong>MarkupCost</strong></th>
    
    <th align="left" bgcolor="#DDDDDD" colspan="5"><strong>Remarks</strong></th> 
    <th align="center" bgcolor="#DDDDDD"><strong></strong></th> 
  </tr>
  <tr>
  <td align="center"><input name="roomTAC" type="text" class="allfields numeric"  id="roomTAC" maxlength="6"  value="<?php echo strip($dmcHotel['roomTAC']); ?>" /></td> 
    <td align="center">
    		<div class="griddiv">
		 
						<select id="markupType" name="markupType" class="allfields  " displayname="Markup Type" autocomplete="off" style="width: 100%;" >
							<option value="1" <?php if($dmcHotel['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>
							<option value="2" <?php if($dmcHotel['markupType'] == 2){ ?> selected="selected" <?php } ?>>FLAT</option>
						</select>
				</div>
		</td>
			<td align="center">
				<div class="griddiv">
          <input name="markupCost" type="text" class="allfields numeric"  id="markupCost" value="<?php echo $dmcHotel['markupCost']; ?>" maxlength="12"/>
				</div>
			</td> 
	    <td  align="left" colspan="5">  
			<input name="remarks" type="text" class="allfields " style="width:96%;text-align:left;" id="remarks"   value="<?php echo strip($dmcHotel['remarks']); ?>" />
		 </td> 
	  <td align="center"> 
		<input name="action" type="hidden" id="action" value="hotelBreakupSaveCost"> 
		<input name="tariffId" type="hidden" id="tariffId" value="<?php echo encode(strip($dmcHotel['id'])); ?>">
		<input name="hotelQuoteId" type="hidden" id="hotelQuoteId" value="<?php echo $_REQUEST['hotelQuoteId']; ?>">
		<input name="tblNum" type="hidden" id="tblNum" value="<?php echo $_REQUEST['tblNum']; ?>">
		<input name="quotationId" type="hidden" id="quotationId" value="<?php echo $_REQUEST['quotationId']; ?>">
		<input type="button" name="Submit" value="   Save   " class="bluembutton" onclick="formValidation('addquohotelroomprice','saveflight','0');" style="padding: 4px 26px !important;border-radius: 3px !important;background-color: #16181c!important;border: 1px solid #16181c!important;">
		</td> 
  </tr>     
 
</table> 

</form>
</div>
<script>
	$(document).on("input", ".numeric", function() {
		this.value = this.value.replace(/\D/g,'');
	}); 
</script> 