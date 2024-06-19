<?php 
include "inc.php"; 
$select='*';   
$where='id='.decode($_GET['queryId']).'';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs);   
?>
<div>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="getpaymentadd" target="actoinfrm"  id="getpaymentadd">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tablesorter gridtable">
  
  <tr>
    <td align="center">Group Code</td>
    <td align="center">Sub Group Code</td>
    <td align="center">Select Vehicle Type</td>
    <td align="center">Select Vehicle Model</td>
    <td align="center">Vehicle Reg. No.</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><?php echo $resultpage['groupCode']; ?></td>
    <td align="center"><input name="subGroupCode" type="text" id="subGroupCode" value="" style="padding: 5px; border-radius: 3px;"></td>
    <td align="center"><select id="vehicleId" name="vehicleId" class="gridfield" autocomplete="off" style="padding: 5px; width: 100%;" onchange="vehicleCapacityfun();getVehicleModel()">  
		                   <option value="">Select Vehicle Type</option>
                       <option value="1">Hatchback</option>
                       <option value="2">Sedan</option>
                       <option value="3">MPV</option>
                       <option value="4">SUV</option>
	                     </select>
                     </td>
    <td align="center"><div class="griddiv"><label>
                <select id="vehicleModelId" name="vehicleModelId" class="gridfield"  autocomplete="off" style="padding: 5px; width: 100%;" onchange="getRegistrationNo()">  
               </select>
              </label>
             </div>
    </td>  
    <script type="text/javascript">
              function getVehicleModel() {
                var vehicleId = $('#vehicleId').val();  
                $("#vehicleModelId").load('loadvehiclemodel.php?vehicleTypeId='+vehicleId);
              }
              function getRegistrationNo() {
                var vehicleModelId = $('#vehicleModelId').val();  
                $("#vehicleConfirmationNo").load('loadvehicleregistrationno.php?vehicleModelId='+vehicleModelId);
              }
            </script>               
	<script>
	 function vehicleCapacityfun(){
	 	var vehicleId = $('#vehicleId :selected').val();
		$('#vehicleCapacity').load('loadvehicleCapacity.php?vehicleId='+vehicleId);
	 }
	 vehicleCapacityfun();
	</script>
    <td align="center"><input name="vehicleConfirmationNo" type="text" id="vehicleConfirmationNo" value="" style="padding: 5px; border-radius: 3px;"></td>
    <td align="center"><input type="hidden" name="action" value="addTRAVELARRANGEMENTLIST" ><input type="hidden" name="groupCode" value="<?php echo $resultpage['groupCode']; ?>" ><input type="hidden" name="queryId" value="<?php echo decode($_GET['queryId']); ?>" ><input type="hidden" name="quotationId" value="<?php echo ($_GET['quotationId']); ?>" ><input type="hidden" name="vehicleCapct" id="vehicleCapct" value="" ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    +Add    " onclick="formValidation('getpaymentadd','submitbtn','0');" style="    padding: 5px 10px !important;" /></td>
  </tr> 
</table>
 </form>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addGuest" target="actoinfrm"  id="addGuest">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="border: 1px solid #668e9e;">
   <thead>
   <tr>
     <th colspan="7" align="center" class="header" style="background-color: #668e9e; color: #ffffff;">Unassigned</th>
     </tr>
   <tr>
     <th width="8%" align="left" class="header"><input type="checkbox" id="checkAll" value="checkYes" style=" display: block; float:left;"><span style="float:left; margin-top: 2px;">All</span></th>
     <th width="25%" align="left" class="header">Full Name</th>
     <th width="7%" align="left" class="header">Age</th>
     <th width="10%" align="center" class="header" >Gender</th>
     <th width="20%" align="center" class="header" >Meal&nbsp;Type </th>
     <th width="18%" align="center" class="header" >Special&nbsp;Assistance</th>
     <th width="12%" align="center" class="header" ><span class="gridlable">Seat</span></th>
     </tr>
   </thead>
 
 
  <tbody>
	<?php
	$where='queryId = "'.decode($_GET['queryId']).'" and id not in (select guestListId from travelArrangementMaster where queryId = "'.decode($_GET['queryId']).'") order by id asc'; 
	$rs=GetPageRecord($select,'guestList',$where); 
	while($resListing=mysqli_fetch_array($rs)){  
	?>
  <tr>
    <td align="left" style="padding-left:0px;"><input type="checkbox" id="guest" name="guest[]" value="<?php echo $resListing['id']; ?>"  style=" display: block;"></td>
    <td align="left" style="padding-left:0px;"><?php echo stripslashes($resListing['title']); ?> <?php echo stripslashes($resListing['fname']); ?> <?php echo stripslashes($resListing['lname']); ?></td>
    <td align="left" style="padding-left:0px;"><?php echo stripslashes($resListing['age']); ?></td>
    <td align="center"  class="iconsfa"><?php echo stripslashes($resListing['gender']); ?></td>
 
    <td align="center"  class="iconsfa">
	<?php 
	$abc=GetPageRecord('*','mealPreference','id="'.$resListing['mealPreference'].'"');   
	$abcpre=mysqli_fetch_array($abc); echo $abcpre['name'];
	?></td>

	<td align="center"  class="iconsfa"><?php echo stripslashes($resListing['special_assist']); ?></td>

    <td align="center"  class="iconsfa"><?php echo stripslashes($resListing['seatPreference']); ?></td>
    </tr>
	<?php $no++; } ?>
  <tr>
    <td align="center" style="background-color:#668e9e; color:#ffffff;">&nbsp;</td>
    <td align="center" style="background-color:#668e9e; color:#ffffff;">Select Sub Group Code<br />
<select id="subGroupCode" name="subGroupCode" class="gridfield" autocomplete="off" style="padding: 5px; width: 100%;" >  
		<?php  
		$rs=GetPageRecord('id,subGroupCode','subGroupCodeMaster',' queryId="'.decode($_GET['queryId']).'" order by id desc');  
		while($resListing=mysqli_fetch_array($rs)){ 
		
		?> 
		<option value="<?php echo strip($resListing['id']); ?>"><?php echo strip($resListing['subGroupCode']); ?></option> 
		<?php } ?> 
	</select></td><input type="hidden" name="queryId" value="<?php echo decode($_GET['queryId']); ?>" >
    <td colspan="2" align="left" valign="bottom" style="background-color:#668e9e;"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    +Add    " onclick="formValidation('addGuest','submitbtn','0');" style="padding: 5px 10px !important; background-color:#d9bb28 !important; border:1px solid #d9bb28 !important;" /></td>
    <td align="center"  class="iconsfa" style="background-color:#668e9e;"><input type="hidden" name="action" value="addGuestTRAVELARRANGEMENTLIST" ></td>
    <td colspan="2" align="center" class="iconsfa" style="background-color:#668e9e;">&nbsp;</td>
    </tr> 
</tbody></table>
</form>
 <script>
  $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
 </script>