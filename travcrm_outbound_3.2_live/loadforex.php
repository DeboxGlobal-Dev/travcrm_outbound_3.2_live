<?php



include "inc.php"; 



include "config/logincheck.php";  



$id=$_REQUEST['id'];



?>







 <div id="forexcostid<?php echo $id; ?>">



 <table width="300" border="0" cellpadding="5" cellspacing="0">



  <tr>



<td><div class="griddiv"><label>



  <div class="gridlable">Forex&nbsp;Cost</div>



  <input name="forexCost<?php echo $id; ?>" type="number" class="gridfield" id="forexCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['forexCost']); ?>" maxlength="100" style="width:166px;" onKeyUp="calculateforexcost(<?php echo $id; ?>);calculateallservices();" />



  </label>



<script>



function calculateforexcost(id){

var forexCost = Number($('#forexCost'+id).val());

$('#forextotalPrice'+id).val(Number(forexCost));

}

 function calculateConversion(id){ 

 	var currencyId = $('#currencyId'+id).val();

	 $('#conversion'+id).val(Number(currencyId));

 }

 calculateConversion();

 



</script>



  </div></td>





        <td><div class="griddiv"><label>

	<div class="gridlable">Currency</div>

	<select id="currencyId<?php echo $forexcost; ?>" name="currencyId<?php echo $forexcost; ?>" class="gridfield" displayname="Currency" autocomplete="off" onchange="calculateConversion('<?php echo $forexcost; ?>');"  style="width:166px;" > 

<option value="">Select</option> 

<?php 

$selectcurrency='*';     

$wherecurrency=' deletestatus=0 and name!="" order by name asc';   

$rscurrency=GetPageRecord($selectcurrency,_QUERY_CURRENCY_MASTER_,$wherecurrency);  

while($resListingcurrency=mysqli_fetch_array($rscurrency)){   

?> 

<option value="<?php echo ($resListingcurrency['currencyValue']); ?>" <?php if($resListingcurrency['id']==$editresult['currencyId']){ ?>selected="selected"<?php } ?>><?php echo ($resListingcurrency['name']); ?></option> 

<?php } ?> 

</select>

	</label>

	</div></td>



        



	        



        <td><div class="griddiv"><label>

  <div class="gridlable">Conversion&nbsp;Rate</div>

    <input name="conversion<?php echo $forexcost; ?>" type="number" class="gridfield" readonly="" id="conversion<?php echo $forexcost; ?>" value="<?php echo stripslashes($editresult['conversion']); ?>" maxlength="100" style="width:166px;" />

  </label>

  </div></td>



        <td style="font-size:30px;">=</td>



        <td><div class="griddiv"><label>



  <div class="gridlable">Total&nbsp;Price     </div>



  <input name="forextotalPrice<?php echo $id; ?>" type="number" class="gridfield fr" readonly="" id="forextotalPrice<?php echo $id; ?>" value="<?php echo stripslashes($editresult['forextotalPrice']); ?>" maxlength="100" style="width:110px;" />



  </label>



  </div></td>



        <td>&nbsp;</td>



        <td><div class="griddiv"><label> 



  <div class="gridlable">Forex&nbsp;Supplier<span class="redmind"></span>  </div> 



  <select id="forexSupplierId<?php echo $id; ?>" name="forexSupplierId<?php echo $id; ?>" class="gridfield " displayname="Supplier" autocomplete="off"  style="width:140px;"  > 



<option value="">Select</option> 



<?php 



$selectforex='*';     



$whereforex=' deletestatus=0 and name!="" order by name asc';   



$rsforex=GetPageRecord($selectforex,_SUPPLIERS_MASTER_,$whereforex);  



while($resListingforex=mysqli_fetch_array($rsforex)){   



?> 



<option value="<?php echo ($resListingforex['id']); ?>" <?php if($resListingforex['id']==$editresult['forexSupplierId']){ ?>selected="selected"<?php } ?>><?php echo ($resListingforex['name']); ?></option> 



<?php } ?> 



</select> 



  </label> 



  </div>







 







</td>







<td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;display:none;">



 



      



      <lable><input name="primaryValue1" type="radio" value="<?php echo $id; ?>"  style="display:block;" /></lable>



    </div></td> 







     <td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removeforexcost(<?php echo $id; ?>);calculateallservices();" style="cursor:pointer;"/></td>



  </tr>



</table>



</div>







  <script>



  $(document).ready(function() {



  $('.select2').select2();



   



  });







  </script>







