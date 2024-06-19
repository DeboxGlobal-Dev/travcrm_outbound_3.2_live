<?php
include "inc.php"; 
include "config/logincheck.php";  
$id=$_REQUEST['id'];
?>

 <div id="landpackcostid<?php echo $id; ?>">
 <table width="300" border="0" cellpadding="5" cellspacing="0">
  <tr>
                   <td><div class="griddiv"><label>
  <div class="gridlable">Land Cost    </div>
  <input name="landpackCost<?php echo $id; ?>" type="number" class="gridfield" id="landpackCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['landpackcost']); ?>" maxlength="100" style="width:90px;" onKeyUp="calculatelandpackcost('<?php echo $id; ?>');calculateallservices();" />
  </label>
<script>
function calculatelandpackcost(id){
 
var landpackCost = Number($('#landpackCost'+id).val());  
var landpackserviceCost = Number($('#landpackserviceCost'+id).val());
var landPacktaxtype = Number($('#landPacktaxtype'+id).val());  
var landpackageGst = Number($('#landpackageGst'+id).val());


if(landPacktaxtype==1){
	
	var landwithservice = Number(landpackCost+landpackserviceCost); 
	$('#landpacktotalPrice'+id).val(landwithservice);
	var landsevcietax = Number((landpackserviceCost*18)/(100+18));
	var landnetmargin =Number(landpackserviceCost-landsevcietax);
	 $('#landpackageGst'+id).val(landsevcietax.toFixed(2));	 
	 $('#landnetmargin'+id).val(landnetmargin.toFixed(2));
	
	
}
if(landPacktaxtype==2){
	var landwithservice = Number(landpackCost+landpackserviceCost); 
	$('#landpacktotalPrice'+id).val(landwithservice);
	var landsevcietax = Number((landwithservice*5)/(100+5));
	var landnetmargin =Number(landpackserviceCost-landsevcietax);
	 $('#landpackageGst'+id).val(landsevcietax.toFixed(2));	 
	 $('#landnetmargin'+id).val(landnetmargin.toFixed(2));
}
}
 
</script>
  </div></td>
  
        <td style="font-size:30px;">+</td>
        
            <td><div class="griddiv"><label>
  <div class="gridlable">Service</div>
  <input name="landpackserviceCost<?php echo $id; ?>" type="number" class="gridfield" id="landpackserviceCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['markup']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculatelandpackcost('<?php echo $id; ?>');calculateallservices();" />
  </label>
  </div></td>
            <td><div class="griddiv"><label>
  <div class="gridlable">Tax Type</div>
  <select id="landPacktaxtype<?php echo $id; ?>" name="landPacktaxtype<?php echo $id; ?>" class="gridfield"   style="width:90px;" onChange="calculatelandpackcost('<?php echo $id; ?>');calculateallservices();">    
   <option value="1" <?php if($editresult['landPacktaxtype']==1){ ?>selected="selected"<?php } ?>>Service</option>  
   <option value="2" <?php if($editresult['landPacktaxtype']==2){ ?>selected="selected"<?php } ?>>Value</option> 
  </select>
  </label>
  </div></td>
  
            <td><div class="griddiv"><label>
  <div class="gridlable">GST</div>
  <input name="landpackageGst<?php echo $id; ?>" type="number" class="gridfield" id="landpackageGst<?php echo $id; ?>" value="<?php echo stripslashes($editresult['gst']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculatelandpackcost('<?php echo $id; ?>');calculateallservices();" />
  </label>
  </div></td>
            <td><div class="griddiv"><label>
  <div class="gridlable">Margin</div>
  <input name="landnetmargin<?php echo $id; ?>" type="number" class="gridfield" id="landnetmargin<?php echo $id; ?>" value="<?php echo stripslashes($editresult['landnetmargin']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculatelandpackcost('<?php echo $id; ?>');calculateallservices();" />
  </label>
  </div></td>
            <td align="center" style="font-size:30px;">=</td>
            <td><div class="griddiv"><label>
  <div class="gridlable">Total Price     </div>
  <input name="landpacktotalPrice<?php echo $id; ?>" type="number" class="gridfield lp" readonly="" id="landpacktotalPrice<?php echo $id; ?>" value="<?php echo stripslashes($editresult['totalAmount']); ?>" maxlength="100" style="width:90px;" />
  </label>
  </div></td>
          
        <td>&nbsp;</td>
        <td><div class="griddiv"><label> 
  <div class="gridlable">Land&nbsp;Package&nbsp;Supplier<span class="redmind"></span>  </div> 
  <select id="landpackSupplierId<?php echo $id; ?>" name="landpackSupplierId<?php echo $id; ?>" class="select2" displayname="Supplier" autocomplete="off"  style="width:140px;" > 
<option value="">Select</option> 
<?php 
$selectsupl='*';     
$wheresupl=' deletestatus=0 and name!="" order by name asc';   
$rssupl=GetPageRecord($selectsupl,_SUPPLIERS_MASTER_,$wheresupl);  
while($resListingsupl=mysqli_fetch_array($rssupl)){   
?> 
<option value="<?php echo ($resListingsupl['id']); ?>" <?php if($resListingsupl['id']==$editresult['supplierId']){ ?>selected="selected"<?php } ?>><?php echo ($resListingsupl['name']); ?></option> 
<?php } ?> 
</select> 
  </label> 
  </div></td>
<td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
 
      
      <lable><input name="primaryValue" type="radio" value="<?php echo $id; ?>"  style="display:none;" /></lable>
    </div></td>
    <td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removelandpackcost(<?php echo $id; ?>);calculateallservices();" style="cursor:pointer;"/></td>
  </tr>
</table>
</div>

<script>
  $(document).ready(function() {
  $('.select2').select2();
   
  });

  </script>
