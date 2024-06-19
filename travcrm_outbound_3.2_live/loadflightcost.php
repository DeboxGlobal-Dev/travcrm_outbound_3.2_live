<?php
include "inc.php"; 
include "config/logincheck.php";  
$id=$_REQUEST['id'];
?>

 <div id="flightcostid<?php echo $id; ?>">
 <table width="300" border="0" cellpadding="5" cellspacing="0">
  <tr>
            <td><div class="griddiv"><label>
  <div class="gridlable">Flight Cost </div>
  <input name="flightCost<?php echo $id; ?>" type="number" class="gridfield" id="flightCost<?php echo $id; ?>" value="" maxlength="100" style="width:90px;" onKeyUp="calculateflightcost('<?php echo $id; ?>');calculateallservices();" />
  </label>
<script>
function calculateflightcost(id){ 



var flightCost = Number($('#flightCost'+id).val()); 

var flighttaxtype = Number($('#flighttaxtype'+id).val());
var flightserviceCost = Number($('#flightserviceCost'+id).val());
var flighttax = Number($('#flighttax'+id).val());  
if(flighttaxtype==1){
	
	var flightwithservice = Number(flightCost+flightserviceCost); 
	$('#flighttotalPrice'+id).val(flightwithservice);
	var flightsevcietax = Number((flightserviceCost*18)/(100+18));
	var netmargin =Number(flightserviceCost-flightsevcietax);
	 $('#flighttax'+id).val(flightsevcietax.toFixed(2));	 
	 $('#netmargin'+id).val(netmargin.toFixed(2));
	
	
}
if(flighttaxtype==2){
	var flightwithservice = Number(flightCost+flightserviceCost); 
	$('#flighttotalPrice'+id).val(flightwithservice);
	 
	var flightsevcietax = Number((flightwithservice*5)/(100+5));
	var netmargin =Number(flightserviceCost-flightsevcietax);
	 $('#flighttax'+id).val(flightsevcietax.toFixed(2));	 
	 $('#netmargin'+id).val(netmargin.toFixed(2));
}

} 




</script>
  </div></td>
        <td style="font-size:30px;">+</td>
        <td><div class="griddiv"><label>
  <div class="gridlable">Service</div>
  <input name="flightserviceCost<?php echo $id; ?>" type="number" class="gridfield" id="flightserviceCost<?php echo $id; ?>" value="" maxlength="100" style="width:90px;" onkeyup="calculateflightcost('<?php echo $id; ?>');calculateallservices();" />
  </label>
  </div></td>
        <td><div class="griddiv"><label>
	<div class="gridlable">Tax Type</div>
	 <select id="flighttaxtype<?php echo $id; ?>" name="flighttaxtype<?php echo $id; ?>" class="gridfield "   style="width:90px;" onChange="calculateflightcost('<?php echo $id; ?>');calculateallservices();">
	 <option value="1" <?php if($resListing['taxType']==1){ ?>selected="selected"<?php } ?>>Service</option>  
	 <option value="2" <?php if($resListing['taxType']==2){ ?>selected="selected"<?php } ?>>Value</option> 
	</select>
	</label>
	</div></td>
        <td><div class="griddiv"><label>
  <div class="gridlable">Tax</div>
  <input name="flighttax<?php echo $id; ?>" type="number" class="gridfield" id="flighttax<?php echo $id; ?>" readonly value="" maxlength="100" style="width:90px;" />
  </label>
  </div></td>
        <td><div class="griddiv"><label>
  <div class="gridlable">Margin</div>
    <input name="netmargin<?php echo $id; ?>" type="number" class="gridfield" id="netmargin<?php echo $id; ?>" readonly value="" maxlength="100" style="width:90px;" />
  </label>
  </div></td>        <td style="font-size:30px;">=</td>
        <td><div class="griddiv"><label>
  <div class="gridlable">Total Price     </div>
  <input name="flighttotalPrice<?php echo $id; ?>" type="number" class="gridfield ft" id="flighttotalPrice<?php echo $id; ?>" readonly value="" maxlength="100" style="width:90px;" />
  </label>
  </div></td>
        <td>&nbsp;</td>
        <td><div class="griddiv"><label> 
  <div class="gridlable">Flight&nbsp;Supplier<span class="redmind"></span>  </div> 
  <select id="flightSupplierId<?php echo $id; ?>" name="flightSupplierId<?php echo $id; ?>" class="select2" displayname="Flight Supplier" autocomplete="off"  style="width:140px;" > 
<option value="">Select</option> 
<?php 
$selectsupf='*';     
$wheresupf=' deletestatus=0 and name!="" order by name asc';   
$rssupf=GetPageRecord($selectsupf,_SUPPLIERS_MASTER_,$wheresupf);  
while($resListingsupf=mysqli_fetch_array($rssupf)){   
?> 
<option value="<?php echo ($resListingsupf['id']); ?>" <?php if($resListingsupf['id']==$editresult['flightSupplierId']){ ?>selected="selected"<?php } ?>><?php echo ($resListingsupf['name']); ?></option> 
<?php } ?> 
</select> 
  </label> 
  </div></td>
<td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
 
      
      <lable><input name="primaryValue1" type="radio" value="<?php echo $id; ?>"  style="display:block;" /></lable>
    </div></td>  
<td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removeflightcost(<?php echo $id; ?>);calculateallservices();" style="cursor:pointer;"/></td>
  </tr>
</table>
</div>

<script>
  $(document).ready(function() {
  $('.select2').select2();
   
  });

  </script>
