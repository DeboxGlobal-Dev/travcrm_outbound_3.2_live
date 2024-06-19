<?php 
	$select1='*';  
	$where1='id="'.decode($_REQUEST['supplierId']).'"'; 
	$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1); 
	$name=clean($editresult['name']); 

	$where2='id='.decode($_REQUEST['hotelId']).''; 
	$rs2=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,$where2); 
	$hotelData=mysqli_fetch_array($rs2);

	$select3='*';  
	$where3='id="'.decode($_REQUEST['supplierId']).'"'; 
	$rs3=GetPageRecord($select1,_DMC_ROOM_TARIFF_MASTER_,$where3); 
	$editresult3=mysqli_fetch_array($rs3); 
	$seasonType=clean($editresult3['seasonType']); 

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
<style>
.topaboxouter{margin: 30px;
    margin-top: 160px;}
.topabox{
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 0px #e8e8e8 solid;
    font-size: 18px;}
	
.topaboxlist {
    border: 1px #e8e8e8 solid;
    padding: 10px;
    margin-bottom: 30px;
    
    box-sizing: border-box;
    background: #fbfbfb;
}

.gridtable td { 
    border-bottom: #f1f1f1 0px solid !important;     padding-bottom: 10px !important;
}
.labletext {
    font-size: 11px;
    color: #909090;
    margin-bottom: 5px;
    text-transform: uppercase;
}


.addeditpagebox .griddiv .gridlable {
    color: #8a8a8a;
    width: 100%;
    display: inline-block;
    padding-bottom: 0px;
    font-size: 11px;text-transform: uppercase;
}

.addTriffRoom .addeditpagebox .griddiv { 
    border-bottom: 0px #eee solid !important;
    overflow: hidden !important;
    position: relative !important; 
}

.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}

.addtopaboxlist {
        border: 2px rgba(186, 228, 193, 0.75) solid;
    padding: 10px;
    margin-bottom: 30px;
    box-sizing: border-box;
    background: #f2fff7;
}

.addGreenHeader{    background: rgba(186, 228, 193, 0.75);
    padding: 10px;
    font-size: 15px;
    font-weight: bold;
    padding-left: 23px;}
	
.addtopaboxlist .gridtable td {
    padding: 1px 4px;
    border-bottom: #f1f1f1 0px solid !important;
    position: relative;
}


.roompricelistmain {
    padding: 0px;
    border: 1px #eeeeee solid;
    background-color: #fff;
    margin-top: 20px;
}
.roompricelistmain .headermainprice {
    padding: 10px;
    border-bottom: solid 1px #CCCCCC;
    font-size: 13px;
    font-weight: bold;
}
.addeditpagebox .griddiv{
    margin-bottom: 2px!important;
}
</style>

<script>
 $(document).ready(function() {  
$('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 

$('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});  
  });


function openclose(id){

if(id==1){
$('#addnewuserbtn').hide();
$('#addTriffRoom').show();
$('#fromDate').focus();
} else {
$('#addnewuserbtn').show();
$('#addTriffRoom').hide();
}

}
</script>
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="7%" align="center">
        <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>    
      </td>
      <td>
        <div class="headingm" style="margin-left:10px;"><span id="topheadingmain">Hotel:&nbsp;<?php echo stripslashes($hotelData['hotelName']); ?></span>
          <div id="deactivatebtn" style="display:none;">
           <?php if($deletepermission==1){ ?> 
          <!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
          <?php } ?>
          </div>
          </div>
      </td>
      <td align="right" style="display:nones;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Tariff" onclick="openclose(1);">&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
</div>
<div class="topaboxouter">
<div id="addTriffRoom" style="display:no1ne;">
<div class="addGreenHeader">Add Tariff</div>
<div class="addeditpagebox addtopaboxlist">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice">
	<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 70% !important;" >
  <tbody> 
  <tr style="background-color:transparent !important;">
    <td width="10%"  align="left"><div class="griddiv"> 
	<label> 
	<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
	<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
 	<?php   
		$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');  
		while($resListing=mysqli_fetch_array($rs)){   
	?> 
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
	<?php } ?>
	</select></label>  
	</div>
</td>
<td width="10%"  align="left" colspan="2"><div class="griddiv" >
	<label> 
	<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
	<select id="roomSupplierId" name="roomSupplierId" class="gridfield validate" displayname="Supplier" autocomplete="off"   style="width: 100%;">
	<?php   
	if($hotelData['supplier'] == 1){
		$isSupp = ' and ( name like "%'.($hotelData['hotelName']).'%" or name = "'.stripslashes($hotelData['hotelName']).'" ) and status=1';
	}else{
		$isSupp = "";
		echo '<option value="">Select&nbsp;Supplier</option>';
	}
	
	$rs='';    
	$rs=GetPageRecord("*",_SUPPLIERS_MASTER_," deletestatus=0 and name!=''  and status=1 ".$isSupp." order by name asc"); 
	if(mysqli_num_rows($rs) == 0){
		$rs='';
		$rs=GetPageRecord("*",_SUPPLIERS_MASTER_," deletestatus=0 and name!='' and status=1 order by name asc"); 
	}
	while($supplierData=mysqli_fetch_array($rs)){   
	?>
	<option value="<?php echo strip($supplierData['id']); ?>" <?php if($supplierData['id']==decode($_REQUEST['supplierId'])){ ?>selected="selected"<?php } ?> ><?php echo strip($supplierData['name']).' - ['.$supplierData['supplierNumber'].']'; ?></option>
	<?php } ?>
	</select></label>
	</div>
</td>

<td width="10%"  align="left">
	<div class="griddiv">
	<label> 
		<div class="gridlable">Pax&nbsp;Type</div>
		<select id="paxType" name="paxType" class="gridfield" displayname="Pax Type" autocomplete="off" tyle="width: 100%;"  >
			<option value="2">FIT</option>
			<option value="1">GIT</option>	
			<!-- <option value="3">Both</option>	 -->
		</select>	
	</label>
	</div>
</td>

<td width="10%"  align="left"><div class="griddiv">
<label> 

<div class="gridlable">Tarif&nbsp;Type <span class="redmind"></span></div>
<select id="tarifType" name="tarifType" class="gridfield validate" displayname="Tarif Type" autocomplete="off"  style="width: 100%;"  >
<option value="">Select</option>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,'tariffTypeMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['tarifType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
</div></td>


    <td align="left" width="10%" >
		<div class="griddiv">
		<label>
			<div class="gridlable">Season&nbsp;Type<span class="redmind"></span></div>
			<select id="seasonType" name="seasonType" class="validate gridfield" displayname="Season&nbsp;Type" style="width: 100%;" onchange="getSeasonValidityfun();" > 
 			<option value="1" <?php if($seasonType==1){ ?>selected="selected"<?php } ?>>Summer</option>
			<option value="2" <?php if($seasonType==2){ ?>selected="selected"<?php } ?>>Winter</option>
			<option value="3" <?php if($seasonType==3){ ?>selected="selected"<?php } ?>>NA</option>				
			</select>
			</label> 
		</div>	
	</td>
	<td align="left" width="10%" >
		<div class="griddiv">
			<label>
				<div class="gridlable">Season&nbsp;Year<span class="redmind"></span></div>
				<?php 
				$starting_year  = 2020;
				$ending_year    = 2040; 
				for($starting_year; $starting_year <= $ending_year; $starting_year++) {
					if(date('Y',strtotime($editresult['seasonYear'])) == $starting_year ){ $seleted = "selected"; }else{ $seleted = ""; }
					$years[] = '<option value="'.$starting_year.'" '.$seleted.' >'.$starting_year.'</option>';
				}
				?> 
				<select name="seasonYear" id="seasonYear"  class="gridfield" style="width: 100%;" onchange="getSeasonValidityfun();">
				<option value="0">Select</option> 
				 <?php echo implode("\n\r", $years);  ?>
 				</select>
			</label>
			<div id="SeasonValidity" style="display:none;"></div>
			<script type="text/javascript">
			function getSeasonValidityfun(){
				var seasonType = $('#seasonType').val();
				var seasonYear = $('#seasonYear').val();
				$('#SeasonValidity').load('loadSeasonValidity.php?seasonType='+seasonType+'&seasonYear='+seasonYear);
			}
			getSeasonValidityfun();
			</script>
		</div>	
	</td>
	
	<td align="left" width="10%"  class="rateValidation_"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); ?>"  />
	</label>
	</div>	</td> 
    <td width="11%" align="left" class="rateValidation_"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($_REQUEST['toDate'])); ?>"/>
	</label>
	</div>	</td>
	
    </tr>
  </tbody>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" >
  <tbody> 
	<tr> 
		<td width="10%"  align="left"><div class="griddiv" >
	<label> 
	<div class="gridlable">Currency<span class="redmind"></span></div>
	<select id="currencyId" name="currencyId" class="gridfield " displayname="Currency" autocomplete="off"   style="width: 100%;">
	 <option value="">Select</option>
		<?php 
		$requestedCurr = $_REQUEST['currencyId']; 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' deletestatus=0 and status=1 order by name asc';  
		$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  

		?>
		<?php if($requestedCurr!=''){ ?>
		<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$requestedCurr){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
		<?php }else{?>
		<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']==1){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
		<?php } ?>
		<?php } ?>
		</select></label>
			</div></td>
	
	    <td width="10%"  align="left">
	    	<div class="griddiv">
				<label> 
					<!-- MEAL  GST slab code added -->
				<div class="gridlable">Room&nbsp;Type <span class="redmind"></span></div>
				<select id="roomType" name="roomType" class="gridfield validate" displayname="Room Type" autocomplete="off"  style="width: 100%;" >
					<option value="">Select</option>
					<?php 
					$select=''; 
					$where=''; 
					$rs='';  
					$select='*';    
					//if(in_array($resListing['id'],$roomTypeArray) == 1){ echo 'selected="selected"';  } 
					$roomTypeArray = explode(',',rtrim($hotelData['roomType'],','));
					foreach($roomTypeArray as $roomArray){
					$where='id="'.$roomArray.'"';  
					$rs=GetPageRecord($select,_ROOM_TYPE_MASTER_,$where); 
					$resListing=mysqli_fetch_array($rs);	


					?>
					<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
					<?php } ?>
				</select>
				</label>
			</div>
		</td>
		<td width="10%"  align="left">
			<div class="griddiv">
				<label>  
				<div class="gridlable">Meal&nbsp;Plan <span class="redmind"></span></div>
				<select id="mealPlan" name="mealPlan" class="gridfield validate" displayname="Meal Plan" autocomplete="off"  style="width: 100%;"  >
					<option value="">Select</option>
					<?php 
					$select=''; 
					$where=''; 
					$rs='';  
					$select='*';    
					$where=' deletestatus=0 and status=1 and name!="" order by name asc';  
					$rs=GetPageRecord($select,_MEAL_PLAN_MASTER_,$where); 
					while($resListing=mysqli_fetch_array($rs)){  

					?>
					<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['mealPlan']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
					<?php } ?>
				</select>
				</label>
			</div>
		</td> 
	    <td width="10%"  align="left"><div class="griddiv"><label>
		<div class="gridlable">Single</div>
		<input name="singleoccupancy" type="text" class="gridfield"  id="singleoccupancy" maxlength="6" onkeyup="numericFilter(this);" style="width: 100%;"/>
		</label>
		</div></td>
	    <td width="10%"  align="left"><div class="griddiv"><label>
		<div class="gridlable">Double</div>
		<input name="doubleoccupancy" type="text" class="gridfield"  id="doubleoccupancy" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
		</label>
		</div></td>

	    <td width="10%" align="left"><div class="griddiv"><label>
		<div class="gridlable">Extra&nbsp;Bed(A)</div>
		<input name="extraBed" type="text" class="gridfield"  id="extraBed" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
		</label>
		</div></td>
		<?php if(isRoomActive('quadroom')==true){ ?>
		<td width="10%"  align="left"><div class="griddiv"><label>
			<div class="gridlable">Quad&nbsp;Room</div>
			<input name="quadRoom" type="text" class="gridfield"  id="quadRoom" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
			</label>
			</div>
		</td>
		<?php } ?>
		<?php if(isRoomActive('teenbed')==true){ ?>
		<td width="10%" align="left" >
			<div class="griddiv"><label>
			<div class="gridlable">Teen&nbsp;Room</div>
			<input name="teenRoom" type="text" class="gridfield"  id="teenRoom" maxlength="6" onkeyup="numericFilter(this);" />
			</label>
			</div>	
		</td>
		<?php } if(isRoomActive('sixbedroom')==true){ ?>
		<td width="10%" align="left" ><div class="griddiv"><label>
			<div class="gridlable">Six&nbsp;Bed&nbsp;Room</div>
			<input name="sixBedRoom" type="text" class="gridfield" id="sixBedRoom" maxlength="6" onkeyup="numericFilter(this);" style="width: 100%;"/>
			</label>
			</div>
		</td> 
		<?php } if(isRoomActive('eightbedroom')==true){ ?>
		<td width="10%" align="left"   ><div class="griddiv"><label>
		<div class="gridlable">Eight&nbsp;Bed&nbsp;Room</div>
		<input name="eightBedRoom" type="text" class="gridfield"  id="eightBedRoom" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
		</label>
		</div></td> 
		<?php } if(isRoomActive('tenbedroom')==true){ ?>
		<td width="10%" align="left" colspan="2"  ><div class="griddiv"><label>
		<div class="gridlable">Ten&nbsp;Bed&nbsp;Room</div>
		<input name="tenBedRoom" type="text" class="gridfield"  id="tenBedRoom" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
		</label>
		</div></td> 
		<?php } ?>
		<td width="10%" align="left"><div class="griddiv"><label>
		<div class="gridlable">Extra&nbsp;Bed(C)</div>
		<input name="childwithbed" type="text" class="gridfield"  id="childwithbed" maxlength="6" onkeyup="numericFilter(this);" style="width: 100%;"/>
		</label>
		</div></td> 
	    <td width="10%" align="left"   ><div class="griddiv"><label>
		<div class="gridlable">Child&nbsp;NoBed(E)</div>
		<input name="childwithoutbed" type="text" class="gridfield"  id="childwithoutbed" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
		</label>
		</div></td> 
		<td width="10%"  align="left">
			<div class="griddiv">
			<label>
				<!-- Room  GST slab code added -->
				<div class="gridlable">ROOM&nbsp;TAX&nbsp;SLAB(%) <span class="redmind"></span></div>
				<select id="roomGST" name="roomGST" class="gridfield" displayname="Room GST" autocomplete="off" style="width: 100%;" >
					<?php 
					$rs2="";
					$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1 '); 
					while($gstSlabData=mysqli_fetch_array($rs2)){
					?>
					<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
					<?php
					}	
					?>
				</select>
			</label>
			</div>	
		</td>
	</tr>
	</tbody>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 80% !important;">
  <tbody> 
	<tr>
	
		<td width="10%" align="left" >
			<div class="griddiv"><label>
			<div class="gridlable">Breakfast(A)</div>
			<input name="breakfast" type="text" class="gridfield"  id="breakfast" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
			</label>
			</div>	</td>
		<td width="10%" align="left" valign="middle"  ><div class="griddiv"><label>
		<div class="gridlable">Lunch(A)</div>
		<input name="lunch" type="text" class="gridfield"  id="lunch"  style="width: 100%;" onkeyup="numericFilter(this);" maxlength="6"/>
		</label>
		</div></td>
	    <td width="10%" align="left" valign="middle"  ><div class="griddiv"  style="width:100px;"><label>
		<div class="gridlable">Dinner(A)</div>
		<input name="dinner" type="text" class="gridfield"  id="dinner" maxlength="6" onkeyup="numericFilter(this);" style="width: 100%;" />
		</label>
		</div></td>
		<td width="10%" align="left" >
			<div class="griddiv"><label>
			<div class="gridlable">Breakfast(C)</div>
			<input name="breakfastChild" type="text" class="gridfield"  id="breakfastChild" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
			</label>
			</div>	</td>
		<td width="10%" align="left" valign="middle"  ><div class="griddiv"><label>
		<div class="gridlable">Lunch(C)</div>
		<input name="lunchChild" type="text" class="gridfield"  id="lunchChild"  style="width: 100%;" onkeyup="numericFilter(this);" maxlength="6"/>
		</label>
		</div></td>
	    <td width="10%" align="left" valign="middle"  ><div class="griddiv"  style="width:100px;"><label>
		<div class="gridlable">Dinner(C)</div>
		<input name="dinnerChild" type="text" class="gridfield"  id="dinnerChild" maxlength="6" onkeyup="numericFilter(this);" style="width: 100%;" />
		</label>
		</div></td>

		<td width="10%"  align="left">
			<div class="griddiv">
			<label>
				<!-- MEAL  GST slab code added -->
				<div class="gridlable">MEAL&nbsp;TAX&nbsp;SLAB(%) <span class="redmind"></span></div>
				<select id="mealGST" name="mealGST" class="gridfield" displayname="Meal GST" autocomplete="off" style="width: 100%;" >
			 		<?php 
					$rs2="";
					$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1 '); 
					while($gstSlabData=mysqli_fetch_array($rs2)){
					?>
					<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
					<?php
					}	
					?>
				</select>
			</label>
			</div>	
		</td>

		<td width="10%" align="left" valign="middle"  >
		<div class="griddiv"><label>
			<div class="gridlable">Markup&nbsp;Type</div>
			<select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
			 	<option value="1">%</option>
			 	<option value="2">Flat</option>
			</select>
			</label>
		</div>	
	</td>
	<td width="10%" align="left" valign="middle"  >
		<div class="griddiv"><label>
			<div class="gridlable">Markup&nbsp;Cost</div>
			<input name="markupCost" type="text" class="gridfield" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
			</label>
		</div>	
	</td>
<td width="10%"  align="left">
	<div class="griddiv">
	<label>
		<!-- Room  GST slab code added -->
		<div class="gridlable">TAC&nbsp;Type <span class="redmind"></span></div>
		<select id="TACType" name="TACType" class="gridfield" displayname="TAC Type" autocomplete="off" style="width: 100%;" >
		
			<option value="0">%</option>
			<option value="1">Flat</option>
			
		</select>
	</label>
	</div>	
	</td>
	<td  align="left" valign="middle"  >
			<div class="griddiv"><label>
			<div class="gridlable">TAC</div>
			<input name="roomTAC" type="text" class="gridfield"  id="roomTAC" maxlength="6" onkeyup="numericFilter(this);" style="width: 70px;" />
			</label>
			</div>
		</td>
	
		
	</tr>
	<tr>
		<td colspan="12">
		<div class="Additionalfields">
			<table cellpadding="5" cellspacing="0" border="1" borderColor="#ccc">
				<tr>
					<td align="left" valign="middle">
						<div class="griddiv" style="width: 130px;"><label><div class="gridlable">Additional</div></label>
						</div>
					</td>
					<td align="left">
						<div class="griddiv" style="width: 130px;">
							<label><div class="gridlable">TAX&nbsp;SLAB(%)</div></label>
						</div>
					</td>
					<td>
						<div class="griddiv" style="width: 144px;">
							<label><div class="gridlable">Type</div></label>
						</div>
					</td>
					<td>
						<div class="griddiv" style="width: 100px;">
							<label><div class="gridlable">Cost</div> </label>
						</div>
					</td>
					<td width="10%" align="left" valign="middle">&nbsp;</td>
				</tr>
				<!-- additional hotel code goes herer -->
				<tr>
					<td align="left" valign="middle">
						<div class="griddiv" style="width: 130px;"><label>
								<select id="addtionalHotel1" name="addtionalHotel1" class="gridfield HAName" displayname="Hotel Additional" autocomplete="off"  style="width: 100%;" >
									<option value="">Select</option>
									<?php 
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$hotelAdditionalArray = explode(',',rtrim($hotelData['hotelAdditional'],','));
									foreach($hotelAdditionalArray as $roomArray){
										$where='id="'.$roomArray.'"';  
										$rs=GetPageRecord($select,'additionalHotelMaster',$where); 
										if(mysqli_num_rows($rs)>0){
										$additinalres=mysqli_fetch_array($rs);	
										?>
										<option value="<?php echo strip($additinalres['id']); ?>"  ><?php echo strip($additinalres['name']); ?></option>
									<?php } } ?>
								</select>
							</label>
						</div>
					</td>
					<td align="left">
						<div class="griddiv" style="width: 130px;">
							<label>
								<select id="additionalGST1" name="additionalGST1" class="gridfield" displayname="Additional GST" autocomplete="off" style="width: 100%;">
									<?php
									$rs2 = "";												
									$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and serviceType="Restaurant" and status=1 order by gstSlabName asc');
									while ($gstSlabData = mysqli_fetch_array($rs2)) {
									?>
										<option value="<?php echo $gstSlabData['id']; ?>"><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
									}
									?>
								</select>
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv" style="width: 144px;">
							<label>
								<select name="personwise1" id="personwise1" class="gridfield">
									<option value="1">Per Person Cost</option>
									<option value="2">Group Cost</option>
								</select>
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv" style="width: 100px;">
							<label>
								<input type="text" name="additionalCost1" id="additionalCost1" class="gridfield" onkeyup="numericFilter(this);">
							</label>
						</div>
					</td>
					<td width="10%" align="left" valign="middle" id="addMoreFields" >
						<i class="fa fa-plus-square" aria-hidden="true" style="font-size: 25px;color: #55a640;padding: 7px 10px;border-radius: 5px;cursor:pointer;"></i>
						<input name="maxRecord" type="hidden" id="maxRecord" value="1">	  
						<input type="hidden" name="additionalRatesNo" id="additionalRatesNo" value="1">
					</td>
				</tr>
			</table>
			</div>
			<div id="multipleAdditionalRate"></div>
		</td>
	</tr>
	<tr>
		<td width="10%" align="left" valign="middle"  >
		<div class="griddiv"><label>
		<div class="gridlable">Status</div>
		<select name="status" id="status" class="gridfield validate" displayname="Meal GST" autocomplete="off" style="width: 100%;" >
			<option value="1">Active</option>
			<option value="0">In Active</option>
		</select>
		</label>
		</div>	
		</td>
		<td width="10%" colspan="10" align="left" valign="middle"  >
		<div class="griddiv">
		<label>
		<div class="gridlable">Remarks</div>
		<!-- <input name="remarks" type="text" class="gridfield" id="remarks" style="width: 100%;"/> -->
		<textarea name="remarks" id="remarks" maxlength="300" style="width: 99%;"></textarea>
		</label>
		</div>	</td> 
		<td width="10%" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');" style="padding: 8px 15px !important; border-radius: 5px !important;margin-top: 15px;">
		<input name="action" type="hidden" id="action" value="addHotelroomtariff"> 
		<input name="serviceid" type="hidden" id="serviceid" value="<?php echo $hotelData['id']; ?>">	  </td>
    </tr>
	 
</tbody>
</table>
</form>
</div> 
</div>      
</div>
<div id="loadhotelmaster"></div>
<script>
	$(document).ready(function(){
		$("#addMoreFields").click(function(e){
			e.preventDefault();
			// validate
			var additionalRatesNo = $('#additionalRatesNo').val();
			additionalRatesNo = Number(additionalRatesNo) + 1; 
			$('#additionalRatesNo').val(additionalRatesNo); 
			$('#maxRecord').val(additionalRatesNo); 

			$("#multipleAdditionalRate").append(` <table cellpadding="5" cellspacing="0" border="1" borderColor="#ccc"> <tr >
				<td align="left" valign="middle">
					<div class="griddiv" style="width:130px;"><label>
							<select id="addtionalHotel`+additionalRatesNo+`" name="addtionalHotel`+additionalRatesNo+`" class="gridfield  HAName" displayname="Hotel Additional" autocomplete="off"  style="width: 100%;" >
								<option value="">Select Additional</option>
								<?php 
								$select=''; 
								$where=''; 
								$rs='';  
								$select='*';    
								$hotelAdditionalArray = explode(',',rtrim($hotelData['hotelAdditional'],','));
								foreach($hotelAdditionalArray as $roomArray){
									$where='id="'.$roomArray.'"';  
									$rs=GetPageRecord($select,'additionalHotelMaster',$where); 
									if(mysqli_num_rows($rs)>0){
									$additinalres=mysqli_fetch_array($rs);	
									?>
									<option value="<?php echo strip($additinalres['id']); ?>" ><?php echo strip($additinalres['name']); ?></option>
								<?php } } ?>
							</select>
						</label>
					</div>
				</td>
				<td align="left">
					<div class="griddiv" style="width:130px;">
						<label>
							
							<select id="additionalGST`+additionalRatesNo+`" name="additionalGST`+additionalRatesNo+`" class="gridfield" displayname="Additional GST" autocomplete="off" style="width: 100%;" >
							<option>Select GST</option>
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and serviceType="Restaurant" and status=1 order by gstSlabName asc');
								while ($gstSlabData = mysqli_fetch_array($rs2)) {
								?>
									<option value="<?php echo $gstSlabData['id']; ?>"><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
								<?php
								}
								?>
							</select>
						</label>
					</div>
				</td>
				<td>
					<div class="griddiv" style="width:144px;">
						<label>
							
							<select name="personwise`+additionalRatesNo+`" id="personwise`+additionalRatesNo+`" class="gridfield">
								<option value="1">Per Person Cost</option>
								<option value="2">Group Cost</option>
							</select>
						</label>
					</div>
				</td>
				<td>
					<div class="griddiv" style="width:100px;">
						<label>
							
							<input type="text" name="additionalCost`+additionalRatesNo+`" id="additionalCost`+additionalRatesNo+`" class="gridfield" onkeyup="numericFilter(this);" placeholder="Cost">
						</label>
					</div>
				</td>
				<td width="10%" align="left" valign="middle" id="removeFields"> <i class="fa fa-trash-o" aria-hidden="true" style="font-size: 23px;color: #ff0000;padding: 5px 11px;border-radius: 5px;cursor:pointer;"></i> </td>

			</tr></table> `);

			if(additionalRatesNo>1){
				$('.HAName').addClass('validate');
			}else{
				$('.HAName').removeClass('validate');
			}
		});
		$(document).on('click','#removeFields',function(e){
		// $("#removeFields").click(function(e){
			e.preventDefault(); 
			let removefields = $(this).parent().parent();
			$(removefields).remove();
 			
			var additionalRatesNo = $('#additionalRatesNo').val();
			additionalRatesNo = Number(additionalRatesNo) - 1;
			$('#additionalRatesNo').val(additionalRatesNo);

			if(additionalRatesNo>1){
				$('.HAName').addClass('validate');
			}else{
				$('.HAName').removeClass('validate');
			}

		});
	});
</script>
<script> 
	function funloadhotelmaster(supplierId){
	$('#loadhotelmaster').load('loadhotelmaster.php?serviceid=<?php echo decode($_REQUEST['hotelId']); ?>&supplierId='+supplierId); 
	}

	<?php if($_REQUEST['hotelId']!=''){ ?>
	funloadhotelmaster('<?php echo decode($_REQUEST['supplierId']); ?>');
	<?php } ?>

	function funafterloadaddrete(supplierId,fromDate,toDate,roomType,mealPlan,currencyId,tarifType){
	$('#loadhotelmaster').load('loadhotelmaster.php?serviceid=<?php echo decode($_REQUEST['hotelId']); ?>&supplierId='+supplierId+'&fromDate='+fromDate+'&toDate='+toDate+'&roomType='+roomType+'&mealPlan='+mealPlan+'&currencyId='+currencyId); 
	}
	
	window.setInterval(function(){ 
		checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

		if(!checked) { 
			$("#deactivatebtn").hide();
			$("#topheadingmain").show();
		} else {
			$("#deactivatebtn").show();
			$("#topheadingmain").hide();
		} 
	}, 100);


	comtabopenclose('linkbox','op2');

	$('#importhotel').click(function(){
		$('#importfield').click();
	});

	function submitimportfrom(){
	startloading();
	$('#importfrmhotel').submit();
	
	}
</script>