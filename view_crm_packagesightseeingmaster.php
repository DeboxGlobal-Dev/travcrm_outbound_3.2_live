<?php 
$select1='*';  
$where1='id='.decode($_REQUEST['supplierId']).''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1); 
$name=clean($editresult['name']);  
 ?>
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><a href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>&supplier=1&sightseeingid=<?php echo $_REQUEST['sightseeingid']; ?>"><img src="images/backicon.png" width="20" style=" cursor:pointer;" /></a> <?php echo $name; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Sightseeing" onclick="openclose(1);">&nbsp;&nbsp;&nbsp;</td>
  </tr>
  
</table>
</div>
<div id="loadhotelmaster"></div>



<script> 
function funloadhotelmaster(id){
$('#loadhotelmaster').load('loadhotelmaster.php?id='+id); 
}

function funafterloadaddrete(id,fromDate,toDate,roomType,mealPlan,currencyId){
$('#loadhotelmaster').load('loadhotelmaster.php?id='+id+'&fromDate='+fromDate+'&toDate='+toDate+'&roomType='+roomType+'&mealPlan='+mealPlan+'&currencyId='+currencyId); 
}




function funloadsightseeingmaster(id){
$('#loadhotelmaster').load('loadsightseeingmaster.php?serviceid=<?php echo decode($_REQUEST['sightseeingid']); ?>&id='+id); 
}

function funloadsightseeingmasteraddrate(id,fromDate,toDate,currencyId,sightseeingType){
$('#loadhotelmaster').load('loadsightseeingmaster.php?serviceid=<?php echo decode($_REQUEST['sightseeingid']); ?>&id='+id+'&fromDate='+fromDate+'&toDate='+toDate+'&currencyId='+currencyId+'&sightseeingType='+sightseeingType); 
}

function funloadtransportormaster(id){
$('#loadhotelmaster').load('loadtransportormaster.php?id='+id); 
}

function funloadtransportormasteraddrate(id,fromDate,toDate,currencyId,sightseeingType){
$('#loadhotelmaster').load('loadtransportormaster.php?id='+id+'&fromDate='+fromDate+'&toDate='+toDate+'&currencyId='+currencyId+'&transferType='+sightseeingType); 
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

$('#importsightseeing').click(function(){
    $('#importfieldsightseeing').click();
});


$('#importtransfer').click(function(){
    $('#importfieldtransfer').click();
});



function submitimportfrom(){
startloading();
$('#importfrmhotel').submit();
  
}


function submitimportfrom2(){
startloading();
$('#importfrmsightseeing').submit();
  
}


function submitimportfrom3(){
startloading();
$('#importfrmtransfer').submit();
  
}


<?php if($_REQUEST['hotelId']!=''){?>
funloadhotelmaster('<?php echo decode($_REQUEST['supplierId']); ?>');
<?php } ?>


<?php if($_REQUEST['sightseeingid']!=''){?>
funloadsightseeingmaster('<?php echo decode($_REQUEST['supplierId']); ?>');
<?php } ?>

</script>