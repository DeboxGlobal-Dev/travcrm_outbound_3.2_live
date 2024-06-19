<?php
include "inc.php"; 
include "config/logincheck.php";  
$id=clean($_REQUEST['id']);


$select='*'; 
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$invoicesetting=mysqli_fetch_array($rs);



$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id="'.$id.'" order by id asc';  
$rs=GetPageRecord($select,_VOUCHER_MASTER_,$where); 
$resultlistsid=mysqli_fetch_array($rs);
$queryId = $resultlistsid['queryId'];

$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id="'.$queryId.'" order by id asc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultquery=mysqli_fetch_array($rs);

if($resultquery['quotationYes']==2){
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='queryId="'.$resultlistsid['queryId'].'" and status=1 order by id asc';  
$rs=GetPageRecord($select,_QUOTATION_MASTER_,$where); 
$resultlists=mysqli_fetch_array($rs);
$quotationId=$resultlists['quotationId'];
$quotationQueryId=$resultlists['id'];
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='queryId="'.$resultlistsid['queryId'].'" ';  
$rs=GetPageRecord($select,_QUERY_FLIGHT_MASTER_,$where); 
$resultflight=mysqli_fetch_array($rs);

if(clean($_REQUEST['id'])!=''){



?> 


<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-radius: 5px; overflow:hidden;">
	
<?php
$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='queryId="'.$queryId.'" and status=1 order by id asc';  
$rs=GetPageRecord($select,_QUOTATION_HOTEL_MASTER_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 
//echo "eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
	$select1='*';
	$where1='id="'.$resultlists['supplierId'].'"'; 
	$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
	$hoteldetail=mysqli_fetch_array($rs1);
	
?>
 	
	  <tr>
        <td width="100%" colspan="7" style="padding:8px 0px; ">
		<table width="100%" border="0" cellpadding="5" cellspacing="0" style="border:1px solid #ccc;">
  <tr>
    <td colspan="7" align="center" ><div id="hotelName<?php echo strip($resultlists['id']); ?>" style=" width: 99%; padding: 5px; font-size: 16px; background-color:#7bcd66; color:#FFFFFF;"><?php echo strip($hoteldetail['hotelName']); ?>-<strong>Hotel</strong></div></td>
    </tr>
  
  <tr>
    <td width="34%">Payment Mode
      <input name="paymentMode<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="paymentMode<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['paymentMode']); ?>"   autocomplete="off" placeholder="Payment Mode" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
    <td width="1%">&nbsp;</td>
    <td width="20%">Confirmation No
      <input name="confirmation<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="confirmation<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['confirmation']); ?>"    autocomplete="off" placeholder="Confirmation No" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
    <td width="1%">&nbsp;</td>
    <td width="22%">Agent Code
      <input name="agentCode<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="agentCode<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['agentCode']); ?>"   autocomplete="off" placeholder="Agent Code" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
    <td width="1%">&nbsp;</td>
    <td width="21%">File No.
      <input name="fileNo<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="fileNo<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['fileNo']); ?>"   autocomplete="off" placeholder="File No." onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
  </tr>
  <tr>
    <td>Special Request
      <input name="specialRequest<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="specialRequest<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['specialRequest']); ?>" autocomplete="off" placeholder="Special Request" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Arrival By
      <input name="arrivalBy<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="arrivalBy<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['arrivalBy']); ?>"   autocomplete="off" placeholder="Arrival By" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
    <td>&nbsp;</td>
    <td>Departure By
      <input name="departureBy<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="departureBy<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['departureBy']); ?>"   autocomplete="off" placeholder="Departure By" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();" /></td>
  </tr> 
</table>

		<!--<input name="hotelName<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="hotelName<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($hoteldetail['hotelName']); ?>" maxlength="150"  autocomplete="off" placeholder="Description" readonly="readonly">--></td>
  </tr> 
	  <tr> 
		<td colspan="7" style="padding:8px 0px; ">&nbsp;</td>       
      </tr>
	  <tr>
	  <td colspan="7"><div id="actiondiv"></div></td>    
      </tr>
	  <script>
	  function addHoteldata<?php echo strip($resultlists['id']); ?>(){
		  var paymentMode = $('#paymentMode<?php echo strip($resultlists['id']); ?>').val();
		  var paymentModeId = encodeURI(paymentMode);
		  var agentCode = $('#agentCode<?php echo strip($resultlists['id']); ?>').val();
		  var agentCodeId = encodeURI(agentCode);
		  var fileNo = $('#fileNo<?php echo strip($resultlists['id']); ?>').val();
		  var fileNumber = encodeURI(fileNo);
		  var confirmation = $('#confirmation<?php echo strip($resultlists['id']); ?>').val();
		  var supnumber = encodeURI(confirmation);
		  var arrivalBy = $('#arrivalBy<?php echo strip($resultlists['id']); ?>').val();
		  var arrivalById = encodeURI(arrivalBy);
		  var departureBy = $('#departureBy<?php echo strip($resultlists['id']); ?>').val();
		  var departureById = encodeURI(departureBy);
		  var specialRequest = $('#specialRequest<?php echo strip($resultlists['id']); ?>').val();
		  var specialRequestId = encodeURI(specialRequest);
		  
		  
		  var hotelNameId = $('#hotelName<?php echo strip($resultlists['id']); ?>').val();
		  var hotel = 1;
		  var quotationYes = 2;
		   
		  $('#actiondiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationYes=<?php echo $resultquery['quotationYes']; ?>&quotationId=<?php echo $quotationId; ?>&Id=<?php echo $resultlists['id']; ?>&supnumber='+supnumber+'&paymentModeId='+paymentModeId+'&agentCodeId='+agentCodeId+'&fileNumber='+fileNumber+'&arrivalById='+arrivalById+'&departureById='+departureById+'&specialRequestId='+specialRequestId+'&hotel='+hotel+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php }  ?>
	  
	
 	
	  <tr>
	  	<td colspan="7">
		<table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #ccc;">
  <tr>
    <td colspan="7" align="center"><div  style=" width: 99%; padding: 5px; font-size: 16px; background-color:#f68839; color:#FFFFFF;">Sightseeing<strong></strong></div></td>
    </tr>
	  <?php
$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='queryId="'.$quotationQueryId.'" order by id asc';  
$rs=GetPageRecord($select,_QUOTATION_SIGHTSEEING_MASTER_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 

	$select2='*';  
	$where2='id='.$resultlists['sightseeingNameId'].''; 
	$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where2); 
	$editresult2=mysqli_fetch_array($rs2); 
	
?>
  <tr>
    <td width="39%" style="border-bottom: 1px solid #ccc !important;"><span style=" width: 99%; padding: 5px; font-size: 13px; color:#756d6d; border-radius: 3px;"><?php echo strip($editresult2['sightseeingName']); ?></span></td>
    <td width="1%" style="border-bottom: 1px solid #ccc !important;">&nbsp;</td>
    <td width="24%" style="border-bottom: 1px solid #ccc !important;"><span style="padding:8px 0px; ">Pickup From
        <input name="pickupFrom<?php echo strip($resultlists['id']); ?>2" type="text" class="form-control" id="pickupFrom<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupFrom']); ?>"    autocomplete="off" placeholder="Pickup From" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();" />
    </span></td>
    <td width="1%" style="border-bottom: 1px solid #ccc !important;">&nbsp;</td>
    <td width="16%" style="border-bottom: 1px solid #ccc !important;"><span style="padding:8px 0px; ">Pickup Time
        <!--<input name="pickupTime<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupTime<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupTime']); ?>"    autocomplete="off" placeholder="Pickup Time" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();">-->
        <select id="pickupTime<?php echo strip($resultlists['id']); ?>" name="select" class="form-control" autocomplete="off" style="padding:5px; border:1px solid #ccc;"  onchange="addSightseeingdata<?php echo strip($resultlists['id']); ?>();" >
          <option value="0" >Select Time</option>
          <?php
			$start=strtotime('00:00');
			$end=strtotime('23:30');
			for ($i=$start;$i<=$end;$i = $i + 15*60)
			{ ?>
          <option value="<?php echo date('g:i A',$i); ?>" <?php if(date('g:i A',$i)==$resultlists['pickupTime']){ ?>selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>
          ;
			
          <?php  }  ?>
        </select>
    </span></td>
    <td width="1%" style="border-bottom: 1px solid #ccc !important;">&nbsp;</td>
    <td width="18%" style="border-bottom: 1px solid #ccc !important;"><span style="padding:8px 0px; ">Duration
        <input name="duration<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="duration<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['duration']); ?>" autocomplete="off" placeholder="Duration"  onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();" />
    </span></td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #ccc !important;">&nbsp;</td>
    <td style="border-bottom: 1px solid #ccc !important;">&nbsp;</td>
    <td colspan="5" style="border-bottom: 1px solid #ccc !important;"><input name="details<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="details<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['details']); ?>"   autocomplete="off" placeholder="Details" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();" /></td>
    </tr>
  <div id="sicdiv"></div>
  <script>
	  function addSightseeingdata<?php echo strip($resultlists['id']); ?>(){
		  var pickupFrom = $('#pickupFrom<?php echo strip($resultlists['id']); ?>').val();
		  var from = encodeURI(pickupFrom);
		  var pickupTime = $('#pickupTime<?php echo strip($resultlists['id']); ?>').val();
		  var time = encodeURI(pickupTime);
		  var duration = $('#duration<?php echo strip($resultlists['id']); ?>').val();
		  var totalDuration = encodeURI(duration);
		  
		   var details = encodeURI($('#details<?php echo strip($resultlists['id']); ?>').val());
		   
		   
		  var Sightseeing = 1;
		  var quotationYes = 2; 
		  $('#sicdiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&sId=<?php echo $resultlists['id']; ?>&from='+from+'&time='+time+'&totalDuration='+totalDuration+'&Sightseeing='+Sightseeing+'&quotationYes='+quotationYes+'&details='+details);
	  }
	  </script>
	  
	  <?php }  ?>
</table>
        </td>
	  
	  <tr> 
		<td colspan="7" style="padding:8px 0px; ">&nbsp;</td>       
      </tr>
	  	  
	  <tr>
	  	<td colspan="7"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="border:1px solid #ccc;">
		<tr><td colspan="7" align="center" ><div  style=" width: 99%; padding: 5px; font-size: 16px; background-color:#7d5f76; color:#FFFFFF;">Transfer<strong></strong></div> </td></tr>
		<?php
$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='queryId="'.$quotationQueryId.'" order by id asc';  
$rs=GetPageRecord($select,_QUOTATION_TRANSFER_MASTER_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 

	$select2='*';  
	$where2='id='.$resultlists['transferNameId'].''; 
	$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_TRANSFER_MASTER,$where2); 
	$editresult2=mysqli_fetch_array($rs2); 
	
?>
		<tr>
		  <td width="39%"  align="left" style="border-bottom: 1px solid #ccc !important;" ><span style=" width: 99%; padding: 5px; font-size: 13px; color:#756d6d; border-radius: 3px;"><?php echo strip($editresult2['transferName']); ?></span></td>
          <td width="1%"  align="left" style="border-bottom: 1px solid #ccc !important;" >&nbsp;</td>
          <!--<td style="padding:8px 0px; ">Transfer Name<input name="sightseeingName<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="sightseeingName<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($editresult2['transferName']); ?>" maxlength="150"  autocomplete="off" placeholder="Description" readonly="readonly"></td>-->
        <td width="24%"  align="left" style="border-bottom: 1px solid #ccc !important;" >Pickup From<input name="pickupFromt<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupFromt<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupFrom']); ?>"    autocomplete="off" placeholder="Pickup From" onkeyup="addTransferdata<?php echo strip($resultlists['id']); ?>();"></td> 
		<td width="1%"  align="left" style="border-bottom: 1px solid #ccc !important;" >&nbsp;</td>
		<td width="16%" align="left" style="border-bottom: 1px solid #ccc !important;" >Pickup Time<!--<input name="pickupTimet<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupTimet<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupTime']); ?>"    autocomplete="off" placeholder="Pickup Time" onkeyup="addTransferdata<?php echo strip($resultlists['id']); ?>();">-->
		<select id="pickupTimet<?php echo $resultlists['id']; ?>" name="pickupTimet" class="form-control" autocomplete="off" style="padding:5px; border:1px solid #ccc;"  onchange="addTransferdata<?php echo strip($resultlists['id']); ?>();" > 
		  	<option value="0" >Select Time</option>
			<?php
			$start=strtotime('00:00');
			$end=strtotime('23:30');
			for ($i=$start;$i<=$end;$i = $i + 15*60)
			{ ?>
		    <option value="<?php echo date('g:i A',$i); ?>" <?php if(date('g:i A',$i)==$resultlists['pickupTime']){ ?>selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;
			<?php  }  ?>
        </select></td> 
		<td width="1%" align="left" style="border-bottom: 1px solid #ccc !important;" >&nbsp;</td>
		<td width="18%" style="border-bottom: 1px solid #ccc !important;" >Duration<input name="transduration<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="transduration<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['duration']); ?>" autocomplete="off" placeholder="Duration"  onkeyup="addTransferdata<?php echo strip($resultlists['id']); ?>();"></td>       
      </tr>
	  <tr>
	  <div id="transdiv"></div>
	  <script>
	  function addTransferdata<?php echo strip($resultlists['id']); ?>(){
		  var pickupFromt = $('#pickupFromt<?php echo strip($resultlists['id']); ?>').val();
		  var transfrom = encodeURI(pickupFromt);
		  var pickupTimet = $('#pickupTimet<?php echo strip($resultlists['id']); ?>').val();
		  var transtime = encodeURI(pickupTimet);
		  var transduration = $('#transduration<?php echo strip($resultlists['id']); ?>').val();
		  var totalTransDuration = encodeURI(transduration);
		  var transfer = 1;
		  var quotationYes = 2;
		  $('#transdiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&tId=<?php echo $resultlists['id']; ?>&transfrom='+transfrom+'&transtime='+transtime+'&totalTransDuration='+totalTransDuration+'&transfer='+transfer+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php }  ?>
	  <td colspan="7">&nbsp;</td>    
      </tr>
	  </table>	  </td>
 
	  <tr style="display:none"> 
		<td colspan="7" style="padding:8px 0px; border:1px solid #ccc;"><div id="loadguestname" ><table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
    <td colspan="2" align="center"><div  style=" width: 99%; padding: 5px; font-size: 16px; background-color:#5198a4; color:#FFFFFF;">Flight Details<strong></strong></div> </td>
    </tr>
		<?php 
$guestno=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' queryId="'.$queryId.'"  order by id asc';  
$rs=GetPageRecord($select,'flightMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
 <div style="margin-top: 5px;"> 
  <tr id="guestid<?php echo $guestno; ?>">
    <td width="37%" align="left"><input name="flightDetails<?php echo $guestno; ?>" type="text" class="gridfield" id="flightDetails<?php echo $guestno; ?>" onkeyup="saveFlightDetailsfun(this);" value="<?php echo $resListing['flightDetails']; ?>" placeholder="Flight Details" style="padding: 9px; border-radius: 3px; margin-left: 5px; border: 1px solid #ccc; width: 100%; min-height: 30px; margin-top: 5px;" /><input type="hidden" id="flightEditId<?php echo $guestno; ?>" value="<?php echo $resListing['id']; ?>" /></td>
    <td width="6%" align="center"><?php if($guestno==1){ ?>
	<img src="images/addicon.png" width="20" height="20" onclick="addguestNames();" style="cursor:pointer;" />
	<?php } else { ?>
	<img src="images/deleteicon.png"  onclick="removeguestNames('<?php echo $guestno; ?>','<?php echo $resListing['id']; ?>');" style="cursor:pointer;" />
	<?php } ?></td>
  </tr> 
</div>
 
 <?php $guestno++; } ?>
 </table>
 <?php if($guestno==1){ ?>
 <div id="guestid1">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="37%" align="left"><input name="flightDetails1" type="text" class="gridfield " displayname="SurName" id="flightDetails1" value=""  placeholder="Flight Details" style="padding: 9px; border-radius: 3px; margin-left: 5px; border: 1px solid #ccc; width: 100%; min-height: 30px; margin-top: 5px;" /></td>
    <td width="6%" align="center"><img src="images/addicon.png" width="20" height="20" onclick="addguestNames();" style="cursor:pointer;" /></td>
  </tr>
</table>
</div>
 <?php } ?>
 <input name="guestcount" type="hidden" id="guestcount" value="<?php if($guestno==1){ echo '1'; } else { echo $guestno; } ?>" />
 <div id="deleteDiv" style="display:none;"></div>
 <script>
 function saveFlightDetailsfun(elem){
 	var id = $(elem).attr("id");
	var flightId = id.match(/\d+/); 
	var flightEditId = $('#flightEditId'+flightId).val();  
	var flightDetails = encodeURIComponent($('#'+id).val());  
    $('#deleteDiv').load('frmaction.php?action=saveFlightDetails&flightId='+flightId+'&flightEditId='+flightEditId+'&flightDetails='+flightDetails);
 }
 function addguestNames(){

 var guestcount = $('#guestcount').val();
 guestcount=Number(guestcount)+1;  
 $.get("loadFlightDetails.php?id="+guestcount, function (data) { 
$("#loadguestname").append(data); 
}); 
  $('#guestcount').val(guestcount);
 $
 }
 
 
 
 function removeguestNames(id,deleteId){
$('#deleteDiv').load('frmaction.php?action=deleteFlightDetails&deleteId='+deleteId);
 $('#guestid'+id).remove();
 var guestcount = $('#guestcount').val();
 guestcount=Number(guestcount)-1;  
 $('#guestcount').val(guestcount);
 }
 </script>
 </div></td>       
      </tr>
</table>
	
<?php }

 } 

if($resultquery['quotationYes']==1){ 
 	if($id!=''){


?> 


<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-radius: 5px; overflow:hidden;">
	
<?php

$selectq=''; 	
$selectq='*';
$whereq=''; 
$rsq='';   
$whereq=' packageId="'.$resultquery['quotationId'].'" group by hotelName ';  
$rsq=GetPageRecord($selectq,_PACKAGE_BUILDER_HOTEL_,$whereq); 
while($resultlists=mysqli_fetch_array($rsq)){ 

	$select1=''; 
	$where1=''; 
	$select1='*';
	$where1='id="'.$resultlists['hotelId'].'"'; 
	$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
	$hoteldetail=mysqli_fetch_array($rs1);
	
?>
 	
	  <tr>
        <td colspan="2" style="padding:8px 0px; ">
		<div id="hotelName<?php echo strip($resultlists['id']); ?>"><?php echo strip($hoteldetail['hotelName']); ?>-<strong>Hotel</strong></div><!--<input name="hotelName<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="hotelName<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($hoteldetail['hotelName']); ?>" maxlength="150"  autocomplete="off" placeholder="Description" readonly="readonly">--></td>
  </tr>
	<td width="50%" style="padding:8px 0px; ">Payment Mode<input name="paymentMode<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="paymentMode<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['paymentMode']); ?>"   autocomplete="off" placeholder="Payment Mode" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td> 
		<td width="50%" align="left"  style="padding:8px 0px; ">Confirmation No<input name="confirmation<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="confirmation<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['confirmation']); ?>"    autocomplete="off" placeholder="Confirmation No" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>        
      </tr>
	  
	  <tr>
        <td  width="50%" style="padding:8px 0px; ">Agent Code<input name="agentCode<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="agentCode<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['agentCode']); ?>"   autocomplete="off" placeholder="Agent Code" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td> 
		 <td   width="50%"style="padding:8px 0px; ">File No.<input name="fileNo<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="fileNo<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['fileNo']); ?>"   autocomplete="off" placeholder="File No." onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>        
      </tr>
	  
	  <tr>
	   <td  width="50%" style="padding:8px 0px; ">Arrival By<input name="arrivalBy<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="arrivalBy<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['arrivalBy']); ?>"   autocomplete="off" placeholder="Arrival By" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td> 
        <td width="50%" style="padding:8px 0px; ">Departure By<input name="departureBy<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="departureBy<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['departureBy']); ?>"   autocomplete="off" placeholder="Departure By" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>        
      </tr>
	  <tr> 
		<td colspan="2"  width="100%" style="padding:8px 0px; ">Special Request<input name="specialRequest<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="specialRequest<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['specialRequest']); ?>" autocomplete="off" placeholder="Special Request" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>       
      </tr>
	  <tr>
	  <td colspan="2"><div id="actiondiv"></div></td>    
      </tr>
	  <script>
	  function addHoteldata<?php echo strip($resultlists['id']); ?>(){
		  var paymentMode = $('#paymentMode<?php echo strip($resultlists['id']); ?>').val();
		  var paymentModeId = encodeURI(paymentMode);
		  var agentCode = $('#agentCode<?php echo strip($resultlists['id']); ?>').val();
		  var agentCodeId = encodeURI(agentCode);
		  var fileNo = $('#fileNo<?php echo strip($resultlists['id']); ?>').val();
		  var fileNumber = encodeURI(fileNo);
		  var confirmation = $('#confirmation<?php echo strip($resultlists['id']); ?>').val();
		  var supnumber = encodeURI(confirmation);
		  var arrivalBy = $('#arrivalBy<?php echo strip($resultlists['id']); ?>').val();
		  var arrivalById = encodeURI(arrivalBy);
		  var departureBy = $('#departureBy<?php echo strip($resultlists['id']); ?>').val();
		  var departureById = encodeURI(departureBy);
		  var specialRequest = $('#specialRequest<?php echo strip($resultlists['id']); ?>').val();
		  var specialRequestId = encodeURI(specialRequest);
		  var hotelNameId = $('#hotelName<?php echo strip($resultlists['id']); ?>').val();
		  var hotel = 1;
		  var quotationYes = 1;
		  $('#actiondiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationYes=<?php echo $resultquery['quotationYes']; ?>&quotationId=<?php echo $quotationId; ?>&Id=<?php echo $resultlists['id']; ?>&supnumber='+supnumber+'&paymentModeId='+paymentModeId+'&agentCodeId='+agentCodeId+'&fileNumber='+fileNumber+'&arrivalById='+arrivalById+'&departureById='+departureById+'&specialRequestId='+specialRequestId+'&hotel='+hotel+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php } ?>
	  
	  <?php
$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='packageId="'.$resultquery['quotationId'].'" order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_BUILDER_SIGHTSEEING_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 

	$select2='*';  
	$where2='id='.$resultlists['sightseeingId'].''; 
	$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where2); 
	$editresult2=mysqli_fetch_array($rs2); 
	
?>
 	
	  <tr>
	  	<td colspan="2"><table width="100%">
		<tr><td colspan="3" style="padding:8px 0px;"><?php echo strip($editresult2['sightseeingName']); ?>-<strong>Sightseeing</strong></td></tr>
		<tr>
        
        <td  align="left"  style="padding:8px 0px; ">Pickup From<input name="pickupFrom<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupFrom<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupFrom']); ?>"    autocomplete="off" placeholder="Pickup From" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();"></td> 
		<td  align="left"  style="padding:8px 0px; ">Pickup Time<!--<input name="pickupTime<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupTime<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupTime']); ?>"    autocomplete="off" placeholder="Pickup Time" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();">-->
		<select id="pickupTime<?php echo $resultlists['id']; ?>" name="pickupTime" class="form-control" autocomplete="off" style="padding:5px; border:1px solid #ccc;"  onchange="addSightseeingdata<?php echo strip($resultlists['id']); ?>();" > 
		  	<option value="0" >Select Time</option>
			<?php
			$start=strtotime('00:00');
			$end=strtotime('23:30');
			for ($i=$start;$i<=$end;$i = $i + 15*60)
			{ ?>
		    <option value="<?php echo date('g:i A',$i); ?>" <?php if(date('g:i A',$i)==$resultlists['pickupTime']){ ?>selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;
			<?php  }  ?>
        </select></td>   
		<td style="padding:8px 0px; ">Duration<input name="duration<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="duration<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['duration']); ?>" autocomplete="off" placeholder="Duration"  onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();"></td>     
      </tr>
	  <tr>
	  <td colspan="3"><div id="sicdiv"></div></td>    
      </tr>
	  </table>
	  </td>
	  <script>
	  function addSightseeingdata<?php echo strip($resultlists['id']); ?>(){
		  var pickupFrom = $('#pickupFrom<?php echo strip($resultlists['id']); ?>').val();
		  var from = encodeURI(pickupFrom);
		  var pickupTime = $('#pickupTime<?php echo strip($resultlists['id']); ?>').val();
		  var time = encodeURI(pickupTime);
		  var duration = $('#duration<?php echo strip($resultlists['id']); ?>').val();
		  var totalDuration = encodeURI(duration);
		  var Sightseeing = 1;
		  var quotationYes = 1;
		  $('#sicdiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&sId=<?php echo $resultlists['id']; ?>&from='+from+'&time='+time+'&totalDuration='+totalDuration+'&Sightseeing='+Sightseeing+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php }  ?>
	  
</table>
	
<?php } 
}

if($resultquery['quotationYes']==0){ 


if($id!=''){


?> 


<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-radius: 5px; overflow:hidden;">
	
<?php
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$resultlistsid['queryId'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1;

$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$resultlistsid['queryId'].'  group by hotelId';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_HOTEL_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 

	$select1=''; 
	$where1=''; 
	$select1='*';
	$where1='id="'.$resultlists['hotelId'].'"'; 
	$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
	$hoteldetail=mysqli_fetch_array($rs1);
	
?>
 	
	  <tr>
        <td colspan="2" style="padding:8px 0px; ">
		<div id="hotelName<?php echo strip($resultlists['id']); ?>"><?php echo strip($hoteldetail['hotelName']); ?>-<strong>Hotel</strong></div><!--<input name="hotelName<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="hotelName<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($hoteldetail['hotelName']); ?>" maxlength="150"  autocomplete="off" placeholder="Description" readonly="readonly">--></td>
  </tr>
	<td width="50%" style="padding:8px 0px; ">Payment Mode<input name="paymentMode<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="paymentMode<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['paymentMode']); ?>"   autocomplete="off" placeholder="Payment Mode" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td> 
		<td width="50%" align="left"  style="padding:8px 0px; ">Confirmation No<input name="confirmation<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="confirmation<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['confirmation']); ?>"    autocomplete="off" placeholder="Confirmation No" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>        
      </tr>
	  
	  <tr>
        <td  width="50%" style="padding:8px 0px; ">Agent Code<input name="agentCode<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="agentCode<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['agentCode']); ?>"   autocomplete="off" placeholder="Agent Code" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td> 
		 <td   width="50%"style="padding:8px 0px; ">File No.<input name="fileNo<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="fileNo<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['fileNo']); ?>"   autocomplete="off" placeholder="File No." onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>        
      </tr>
	  
	  <tr>
	   <td  width="50%" style="padding:8px 0px; ">Arrival By<input name="arrivalBy<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="arrivalBy<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['arrivalBy']); ?>"   autocomplete="off" placeholder="Arrival By" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td> 
        <td width="50%" style="padding:8px 0px; ">Departure By<input name="departureBy<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="departureBy<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['departureBy']); ?>"   autocomplete="off" placeholder="Departure By" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>        
      </tr>
	  <tr> 
		<td colspan="2"  width="100%" style="padding:8px 0px; ">Special Request<input name="specialRequest<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="specialRequest<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['specialRequest']); ?>" autocomplete="off" placeholder="Special Request" onkeyup="addHoteldata<?php echo strip($resultlists['id']); ?>();"></td>       
      </tr>
	  <tr>
	  <td colspan="2"><div id="actiondiv"></div></td>    
      </tr>
	  <script>
	  function addHoteldata<?php echo strip($resultlists['id']); ?>(){
		  var paymentMode = $('#paymentMode<?php echo strip($resultlists['id']); ?>').val();
		  var paymentModeId = encodeURI(paymentMode);
		  var agentCode = $('#agentCode<?php echo strip($resultlists['id']); ?>').val();
		  var agentCodeId = encodeURI(agentCode);
		  var fileNo = $('#fileNo<?php echo strip($resultlists['id']); ?>').val();
		  var fileNumber = encodeURI(fileNo);
		  var confirmation = $('#confirmation<?php echo strip($resultlists['id']); ?>').val();
		  var supnumber = encodeURI(confirmation);
		  var arrivalBy = $('#arrivalBy<?php echo strip($resultlists['id']); ?>').val();
		  var arrivalById = encodeURI(arrivalBy);
		  var departureBy = $('#departureBy<?php echo strip($resultlists['id']); ?>').val();
		  var departureById = encodeURI(departureBy);
		  var specialRequest = $('#specialRequest<?php echo strip($resultlists['id']); ?>').val();
		  var specialRequestId = encodeURI(specialRequest);
		  var hotelNameId = $('#hotelName<?php echo strip($resultlists['id']); ?>').val();
		  var hotel = 1;
		  var quotationYes = 0;
		  $('#actiondiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationYes=<?php echo $resultquery['quotationYes']; ?>&quotationId=<?php echo $quotationId; ?>&Id=<?php echo $resultlists['id']; ?>&supnumber='+supnumber+'&paymentModeId='+paymentModeId+'&agentCodeId='+agentCodeId+'&fileNumber='+fileNumber+'&arrivalById='+arrivalById+'&departureById='+departureById+'&specialRequestId='+specialRequestId+'&hotel='+hotel+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php } $n++; $daydatae++; } ?>
	  
	
 <?php
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$resultlistsid['queryId'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$resultlistsid['queryId'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_SIGHTSEEING_,$where22); 
while($resultlists=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$resultlists['sightseeingId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$sightseeingdetail=mysqli_fetch_array($rs1);
	
?>
 	
	 
	  <tr>
	  	<td colspan="2"><table width="100%">
		<tr><td colspan="3" style="padding:8px 0px;"><?php echo strip($sightseeingdetail['sightseeingName']); ?>-<strong>Sightseeing</strong></td></tr>
		<tr>
        
        <td  align="left"  style="padding:8px 0px; ">Pickup From<input name="pickupFrom<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupFrom<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupFrom']); ?>"    autocomplete="off" placeholder="Pickup From" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();"></td> 
		<td  align="left"  style="padding:8px 0px; ">Pickup Time<!--<input name="pickupTime<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupTime<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupTime']); ?>"    autocomplete="off" placeholder="Pickup Time" onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();">-->
		<select id="pickupTime<?php echo $resultlists['id']; ?>" name="pickupTime" class="form-control" autocomplete="off" style="padding:5px; border:1px solid #ccc;"  onchange="addSightseeingdata<?php echo strip($resultlists['id']); ?>();" > 
		  	<option value="0" >Select Time</option>
			<?php
			$start=strtotime('00:00');
			$end=strtotime('23:30');
			for ($i=$start;$i<=$end;$i = $i + 15*60)
			{ ?>
		    <option value="<?php echo date('g:i A',$i); ?>" <?php if(date('g:i A',$i)==$resultlists['pickupTime']){ ?>selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;
			<?php  }  ?>
        </select></td>   
		<td style="padding:8px 0px; ">Duration<input name="duration<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="duration<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['duration']); ?>" autocomplete="off" placeholder="Duration"  onkeyup="addSightseeingdata<?php echo strip($resultlists['id']); ?>();"></td>     
      </tr>
	  <tr>
	  <td colspan="3"><div id="sicdiv"></div></td>    
      </tr>
	  </table>
	  </td>
	  <script>
	  function addSightseeingdata<?php echo strip($resultlists['id']); ?>(){
		  var pickupFrom = $('#pickupFrom<?php echo strip($resultlists['id']); ?>').val();
		  var from = encodeURI(pickupFrom);
		  var pickupTime = $('#pickupTime<?php echo strip($resultlists['id']); ?>').val();
		  var time = encodeURI(pickupTime);
		  var duration = $('#duration<?php echo strip($resultlists['id']); ?>').val();
		  var totalDuration = encodeURI(duration);
		  var Sightseeing = 1;
		  var quotationYes = 0;
		  $('#sicdiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&sId=<?php echo $resultlists['id']; ?>&from='+from+'&time='+time+'&totalDuration='+totalDuration+'&Sightseeing='+Sightseeing+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php }  $n++; $daydatae++; } ?>
	    	 
	<?php
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$resultlistsid['queryId'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1;

$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$resultlistsid['queryId'].'  and dayId='.$daylisting['id'].' order by id desc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_TRANSFER_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 

	$select2='*';  
	$where2='id='.$resultlists['transferId'].''; 
	$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_TRANSFER_MASTER,$where2); 
	$editresult2=mysqli_fetch_array($rs2); 
	
?>
 	
	  <tr>
	  	<td colspan="2"><table width="100%">
		<tr><td colspan="3" style="padding:8px 0px;"><?php echo strip($editresult2['transferName']); ?>-<strong>Transfer</strong></td></tr>
		<tr>
        <!--<td style="padding:8px 0px; ">Transfer Name<input name="sightseeingName<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="sightseeingName<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($editresult2['transferName']); ?>" maxlength="150"  autocomplete="off" placeholder="Description" readonly="readonly"></td>-->
        <td  align="left"  style="padding:8px 0px; ">Pickup From<input name="pickupFromt<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupFromt<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupFrom']); ?>"    autocomplete="off" placeholder="Pickup From" onkeyup="addTransferdata<?php echo strip($resultlists['id']); ?>();"></td> 
		<td align="left"  style="padding:8px 0px; ">Pickup Time<!--<input name="pickupTimet<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="pickupTimet<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['pickupTime']); ?>"    autocomplete="off" placeholder="Pickup Time" onkeyup="addTransferdata<?php echo strip($resultlists['id']); ?>();">-->
		<select id="pickupTimet<?php echo $resultlists['id']; ?>" name="pickupTimet" class="form-control" autocomplete="off" style="padding:5px; border:1px solid #ccc;"  onchange="addTransferdata<?php echo strip($resultlists['id']); ?>();" > 
		  	<option value="0" >Select Time</option>
			<?php
			$start=strtotime('00:00');
			$end=strtotime('23:30');
			for ($i=$start;$i<=$end;$i = $i + 15*60)
			{ ?>
		    <option value="<?php echo date('g:i A',$i); ?>" <?php if(date('g:i A',$i)==$resultlists['pickupTime']){ ?>selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;
			<?php  }  ?>
        </select></td> 
		<td style="padding:8px 0px; ">Duration<input name="transduration<?php echo strip($resultlists['id']); ?>" type="text" class="form-control" id="transduration<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['duration']); ?>" autocomplete="off" placeholder="Duration"  onkeyup="addTransferdata<?php echo strip($resultlists['id']); ?>();"></td>       
      </tr>
	  <tr>
	  <td colspan="3"><div id="transdiv"></div></td>    
      </tr>
	  </table>
	  </td>
	  <script>
	  function addTransferdata<?php echo strip($resultlists['id']); ?>(){
		  var pickupFromt = $('#pickupFromt<?php echo strip($resultlists['id']); ?>').val();
		  var transfrom = encodeURI(pickupFromt);
		  var pickupTimet = $('#pickupTimet<?php echo strip($resultlists['id']); ?>').val();
		  var transtime = encodeURI(pickupTimet);
		  var transduration = $('#transduration<?php echo strip($resultlists['id']); ?>').val();
		  var totalTransDuration = encodeURI(transduration);
		  var transfer = 1;
		  var quotationYes = 0;
		  $('#transdiv').load('addhotelvoucher.php?queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&tId=<?php echo $resultlists['id']; ?>&transfrom='+transfrom+'&transtime='+transtime+'&totalTransDuration='+totalTransDuration+'&transfer='+transfer+'&quotationYes='+quotationYes);
	  }
	  </script>
	  
	  <?php } $n++; $daydatae++; }  ?>
	  
</table>
	
<?php } 
}

 ?>
<style>
.form-control { 
    height: 28px !important; }
</style>