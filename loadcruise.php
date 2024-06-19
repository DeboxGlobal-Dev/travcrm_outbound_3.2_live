<?php



include "inc.php"; 



include "config/logincheck.php";  



$id=$_REQUEST['id'];



?>







 <div id="cruisecostid<?php echo $id; ?>">



 <table width="300" border="0" cellpadding="5" cellspacing="0">



  <tr>



<td><div class="griddiv"><label>



  <div class="gridlable">Cruise&nbsp;Cost</div>



  <input name="cruiseCost<?php echo $id; ?>" type="number" class="gridfield" id="cruiseCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['cruiseCost']); ?>" maxlength="100" style="width:90px;" onKeyUp="calculatecruisecost(<?php echo $id; ?>);calculateallservices();" />



  </label>



<script>



function calculatecruisecost(id){











var cruiseCost = Number($('#cruiseCost'+id).val());



var cruisetaxtype = Number($('#cruisetaxtype'+id).val());



var cruiseserviceCost = Number($('#cruiseserviceCost'+id).val());



var cruisetax = Number($('#cruisetax'+id).val());  



var cruisenetmargin = Number($('#cruisenetmargin'+id).val()); 











if(cruisetaxtype==1){

  

  var cruisewithservice = Number(cruiseCost); 

  var cruisetaxtotal = Number(cruiseserviceCost+cruiseserviceCost*cruisetax/100);

  var cruisemargintotal = Number(cruisewithservice+cruisetaxtotal+cruisenetmargin); 

  $('#cruisetotalPrice'+id).val(cruisemargintotal);



}

if(cruisetaxtype==2){

  var cruisewithservice = Number(cruiseCost+cruiseserviceCost); 

  var cruisetaxtotal = Number(cruisewithservice+cruisewithservice*cruisetax/100);

  var cruisegrandtotal = Number(cruisetaxtotal+cruisenetmargin); 

  $('#cruisetotalPrice'+id).val(cruisegrandtotal);



}







}



 



</script>



  </div></td>



        <td style="font-size:30px;">+</td>



        <td><div class="griddiv"><label>



  <div class="gridlable">Service</div>



  <input name="cruiseserviceCost<?php echo $id; ?>" type="number" class="gridfield" id="cruiseserviceCost<?php echo $id; ?>" value="<?php echo stripslashes($editresult['cruiseserviceCost']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculatecruisecost(<?php echo $id; ?>);calculateallservices();" />



  </label>



  </div></td>

 <td style="font-size:30px;">+</td>

  <td style="padding-right:0px;"><div class="griddiv"><label>
	<div class="gridlable">Type</div>
	<select id="marginTypee<?php echo $id; ?>" name="marginTyped<?php echo $id; ?>" class="gridfield"   style="width:70px;;" onchange="calculateMargianTypee<?php echo $id; ?>();"  >  
	 <option value="1" <?php if($resListing['marginType']==1){ ?>selected="selected"<?php } ?>>Flat</option>  
	 <option value="2" <?php if($resListing['marginType']==2){ ?>selected="selected"<?php } ?>>%</option> 
	</select>
	</label>
	</div>
		</td>
	<td  style="padding-left:0px; display:none; <?php if($resListing['marginType']==2){ ?> display:block;  <?php } ?> " id="valuee<?php echo $id; ?>"><div class="griddiv"><label>
	<div class="gridlable">Value </div>
	<input name="percentValuee<?php echo $id; ?>" type="number" class="gridfield" id="percentValuee<?php echo $id; ?>"  value="<?php echo stripslashes($resListing['percentValue']); ?>" maxlength="100" style="width:70px;" onkeyup="calculateMargianTypee<?php echo $id; ?>();calculatecruisecost('<?php echo $id; ?>');calculateallservices();"  />
	</label>
	</div><script>
	function calculateMargianTypee<?php echo $id; ?>(){
	var cruiseCost = $('#cruiseCost<?php echo $id; ?>').val();
	var marginType = $('#marginTypee<?php echo $id; ?>').val(); 
	var percentValue = $('#percentValuee<?php echo $id; ?>').val(); 
	var finalcost = (cruiseCost*percentValue/100);  
	if(marginType=='1'){
	$('#valuee<?php echo $id; ?>').hide();
	$('#cruisenetmargin<?php echo $id; ?>').val('0');
	$('#percentValuee<?php echo $id; ?>').val('0');
	} else {
	$('#valuee<?php echo $id; ?>').show();
	$('#cruisenetmargin<?php echo $id; ?>').val(finalcost);
	}
	calculateflightcost(<?php echo $id; ?>);calculateallservices();
	}
	</script></td>
	<td ><div class="griddiv"><label>
  <div class="gridlable">Margin</div>
  <input name="cruisenetmargin<?php echo $id; ?>" type="number" class="gridfield" id="cruisenetmargin<?php echo $id; ?>" value="<?php  echo stripslashes($resListing['cruisenetmargin']); ?>" maxlength="100" style="width:90px;"  onkeyup="calculatecruisecost('<?php echo $id; ?>');calculateallservices();" />
  </label>
  </div></td>



        <td><div class="griddiv"><label>



	<div class="gridlable">Tax&nbsp;Type</div>



	 <select id="cruisetaxtype<?php echo $id; ?>" name="cruisetaxtype<?php echo $id; ?>" class="gridfield "   style="width:90px;" onChange="calculatecruisecost(<?php echo $id; ?>);calculateallservices();">  



	 <option value="1" <?php if($editresult['cruisetaxtype']==1){ ?>selected="selected"<?php } ?>>Service</option>  



	 <option value="2" <?php if($editresult['cruisetaxtype']==2){ ?>selected="selected"<?php } ?>>Value</option> 



	</select>



	</label>



	</div></td>



	        <td><div class="griddiv"><label>



  <div class="gridlable">GST</div>





    <select id="cruisetax<?php echo $id; ?>" name="cruisetax<?php echo $id; ?>" class="gridfield "   style="width:90px;" onChange="calculatecruisecost(<?php echo $id; ?>);calculateallservices();">  

  

  <option value="">Select</option>



   <option value="5" <?php if($editresult['tax']==5){ ?>selected="selected"<?php } ?>>5%</option>  



   <option value="18" <?php if($editresult['tax']==18){ ?>selected="selected"<?php } ?>>18%</option> 



  </select>





  </label>



  </div></td>



        



        <td style="font-size:30px;">=</td>



        <td><div class="griddiv"><label>



  <div class="gridlable">Total&nbsp;Price     </div>



  <input name="cruisetotalPrice<?php echo $id; ?>" type="number" class="gridfield cr" readonly="" id="cruisetotalPrice<?php echo $id; ?>" value="<?php echo stripslashes($editresult['cruisetotalPrice']); ?>" maxlength="100" style="width:110px;" />



  </label>



  </div></td>



        <td>&nbsp;</td>



        <td><div class="griddiv"><label> 



  <div class="gridlable">Cruise&nbsp;Supplier<span class="redmind"></span>  </div> 



  <select id="cruiseSupplierId<?php echo $id; ?>" name="cruiseSupplierId<?php echo $id; ?>" class="gridfield " displayname="Supplier" autocomplete="off"  style="width:140px;"  > 



<option value="">Select</option> 



<?php 



$selectcruise='*';     



$wherecruise=' deletestatus=0 and name!="" order by name asc';   



$rscruise=GetPageRecord($selectcruise,_SUPPLIERS_MASTER_,$wherecruise);  



while($resListingcruise=mysqli_fetch_array($rscruise)){   



?> 



<option value="<?php echo ($resListingcruise['id']); ?>" <?php if($resListingcruise['id']==$editresult['cruiseSupplierId']){ ?>selected="selected"<?php } ?>><?php echo ($resListingcruise['name']); ?></option> 



<?php } ?> 



</select> 



  </label> 



  </div>







 







</td>







<td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;display:none;">



 



      



      <lable><input name="primaryValue1" type="radio" value="<?php echo $id; ?>"  style="display:block;" /></lable>



    </div></td> 







     <td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removecruisecost(<?php echo $id; ?>);calculateallservices();" style="cursor:pointer;"/></td>



  </tr>



</table>



</div>







  <script>



  $(document).ready(function() {



  $('.select2').select2();



   



  });







  </script>







