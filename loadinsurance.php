<?php

include "inc.php"; 

include "config/logincheck.php";  

$id=$_REQUEST['id'];

?>



 <div id="insurancecostid<?php echo $id; ?>">

 <table width="300" border="0" cellpadding="5" cellspacing="0">

  <tr>

    <td><div class="griddiv"><label>

  <div class="gridlable">Insurance&nbsp;Name</div>

  <input name="insuranceName<?php echo $id; ?>" type="text" class="gridfield" id="insuranceName<?php echo $id; ?>" value="<?php echo stripslashes($resListing['insuranceName']); ?>" maxlength="100" style="width: 100px;" />

  </label>

  </div></td>



                   <td><div class="griddiv"><label>

  <div class="gridlable">Insurance&nbsp;Cost    </div>

  <input name="insuranceCost<?php echo $id; ?>" type="number" class="gridfield" id="insuranceCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['insuranceCost']); ?>" maxlength="100" style="width:90px;" onKeyUp="calculateinsurancecost('<?php echo $id; ?>');calculateallservices();" />

  </label>

<script>

function calculateinsurancecost(id){

 

var insuranceCost = Number($('#insuranceCost'+id).val());  

var insuranceserviceCost = Number($('#insuranceserviceCost'+id).val());

var insurancetaxtype = Number($('#insurancetaxtype'+id).val());  

var insuranceGst = Number($('#insuranceGst'+id).val());

var insurancenetmargin = Number($('#insurancenetmargin'+id).val());





if(insurancetaxtype==1){



  var insurancewithservice = Number(insuranceCost);

    var insurancetaxtotal = Number(insuranceserviceCost+insuranceserviceCost*insuranceGst/100);

    var insurancemargintotal = Number(insurancewithservice+insurancetaxtotal+insurancenetmargin);

  $('#insurancetotalPrice'+id).val(insurancemargintotal);

}

if(insurancetaxtype==2){

  var insurancewithservice = Number(insuranceCost+insuranceserviceCost); 

  var insurancetaxtotal = Number(insurancewithservice+insurancewithservice*insuranceGst/100);

   var insurancegrandtotal = Number(insurancetaxtotal+insurancenetmargin); 

  $('#insurancetotalPrice'+id).val(insurancegrandtotal);



}



}

 

</script>

  </div></td>

  

        <td style="font-size:30px;">+</td>

        

            <td><div class="griddiv"><label>

  <div class="gridlable">Service</div>

  <input name="insuranceserviceCost<?php echo $id; ?>" type="number" class="gridfield" id="insuranceserviceCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['insuranceserviceCost']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculateinsurancecost('<?php echo $id; ?>');calculateallservices();" />

  </label>

  </div></td>

 <td style="font-size:30px;">+</td>

  <td style="padding-right:0px;"><div class="griddiv"><label>
	<div class="gridlable">Type</div>
	<select id="marginTyped<?php echo $id; ?>" name="marginTyped<?php echo $id; ?>" class="gridfield"   style="width:70px;;" onchange="calculateMargianTyped<?php echo $id; ?>();"  >  
	 <option value="1" <?php if($resListing['marginType']==1){ ?>selected="selected"<?php } ?>>Flat</option>  
	 <option value="2" <?php if($resListing['marginType']==2){ ?>selected="selected"<?php } ?>>%</option> 
	</select>
	</label>
	</div>
		</td>
	<td  style="padding-left:0px; display:none; <?php if($resListing['marginType']==2){ ?> display:block;  <?php } ?> " id="valued<?php echo $id; ?>"><div class="griddiv"><label>
	<div class="gridlable">Value </div>
	<input name="percentValued<?php echo $id; ?>" type="number" class="gridfield" id="percentValued<?php echo $id; ?>"  value="<?php echo stripslashes($resListing['percentValue']); ?>" maxlength="100" style="width:70px;" onkeyup="calculateMargianTyped<?php echo $id; ?>();calculateinsurancecost('<?php echo $id; ?>');calculateallservices();"  />
	</label>
	</div><script>
	function calculateMargianTyped<?php echo $id; ?>(){
	var insuranceCost = $('#insuranceCost<?php echo $id; ?>').val();
	var marginType = $('#marginTyped<?php echo $id; ?>').val(); 
	var percentValue = $('#percentValued<?php echo $id; ?>').val(); 
	var finalcost = (insuranceCost*percentValue/100);  
	if(marginType=='1'){
	$('#valued<?php echo $id; ?>').hide();
	$('#insurancenetmargin<?php echo $id; ?>').val('0');
	$('#percentValued<?php echo $id; ?>').val('0');
	} else {
	$('#valued<?php echo $id; ?>').show();
	$('#insurancenetmargin<?php echo $id; ?>').val(finalcost);
	}
	calculateflightcost(<?php echo $landpackcost; ?>);calculateallservices();
	}
	</script></td>
	<td ><div class="griddiv"><label>
  <div class="gridlable">Margin</div>
  <input name="insurancenetmargin<?php echo $id; ?>" type="number" class="gridfield" id="insurancenetmargin<?php echo $id; ?>" value="<?php echo stripslashes($resListing['insurancenetmargin']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculateinsurancecost('<?php echo $id; ?>');calculateallservices();" />
  </label>
  </div></td>



            <td><div class="griddiv"><label>

  <div class="gridlable">Tax&nbsp;Type</div>

  <select id="insurancetaxtype<?php echo $id; ?>" name="insurancetaxtype<?php echo $id; ?>" class="gridfield"   style="width:90px;" onChange="calculateinsurancecost('<?php echo $id; ?>');calculateallservices();">    

   <option value="1" <?php if($editresult['insurancetaxtype']==1){ ?>selected="selected"<?php } ?>>Service</option>  

   <option value="2" <?php if($editresult['insurancetaxtype']==2){ ?>selected="selected"<?php } ?>>Value</option> 

  </select>

  </label>

  </div></td>

  

            <td><div class="griddiv"><label>

  <div class="gridlable">GST</div>

  <select id="insuranceGst<?php echo $id; ?>" name="insuranceGst<?php echo $id; ?>" class="gridfield"   style="width:90px;" onChange="calculateinsurancecost('<?php echo $id; ?>');calculateallservices();">    

   <option value="5" <?php if($editresult['tax']==5){ ?>selected="selected"<?php } ?>>5%</option>  

   <option value="18" <?php if($editresult['tax']==18){ ?>selected="selected"<?php } ?>>18%</option> 

  </select>



  </label>

  </div></td>

            

            <td align="center" style="font-size:30px;">=</td>

            <td><div class="griddiv"><label>

  <div class="gridlable">Total&nbsp;Price     </div>

  <input name="insurancetotalPrice<?php echo $id; ?>" type="number" class="gridfield is" readonly="" id="insurancetotalPrice<?php echo $id; ?>" value="<?php echo stripslashes($editresult['insurancetotalPrice']); ?>" maxlength="100" style="width:100px;" />

  </label>

  </div></td>

          

        <td>&nbsp;</td>

        <td><div class="griddiv"><label> 

  <div class="gridlable">Insurance&nbsp;Supplier<span class="redmind"></span>  </div> 

  <select id="insuranceSupplierId<?php echo $id; ?>" name="insuranceSupplierId<?php echo $id; ?>" class="gridfield " displayname="Supplier" autocomplete="off"  style="width:140px;" > 

<option value="">Select</option> 

<?php 

$selectinsurance='*';     

$whereinsurance=' deletestatus=0 and name!="" order by name asc';   

$rsinsurance=GetPageRecord($selectinsurance,_SUPPLIERS_MASTER_,$whereinsurance);  

while($resListinginsurance=mysqli_fetch_array($rsinsurance)){   

?> 

<option value="<?php echo ($resListinginsurance['id']); ?>" <?php if($resListinginsurance['id']==$editresult['insuranceSupplierId']){ ?>selected="selected"<?php } ?>><?php echo ($resListinginsurance['name']); ?></option> 

<?php } ?> 

</select> 

  </label> 

  </div></td>



  


<td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;display:none;">

 

      

      <lable><input name="primaryValue" type="radio" value="<?php echo $id; ?>"  style="display:none;" /></lable>

    </div></td>

    <td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removeinsurancecost(<?php echo $id; ?>);calculateallservices();" style="cursor:pointer;"/></td>

  </tr>

</table>

</div>



<script>

  $(document).ready(function() {

  $('.select2').select2();

   

  });



  </script>

