<?php 
if($_REQUEST['otherActivityNameId']!=''){  
	$aaaaaa=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.decode($_REQUEST['otherActivityNameId']).'"'); 
	$otherActivityData=mysqli_fetch_array($aaaaaa);
}
?> 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>&amp;keyword=<?php echo $_REQUEST['keyword'];?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>  
     </td>
    <td width="95%" align="left"><?php echo $otherActivityData['otherActivityName']; ?></td>
  </tr>
  
</table>
</div>
<div id="loadhotelmaster"></div>



<script>  

function funloadotherActivitymaster(){ 
$('#loadhotelmaster').load('loadotherActivityMaster.php?serviceid=<?php echo decode($_REQUEST['otherActivityNameId']); ?>'); 
}

function funloadotherActivitymasteraddrate(fromDate,toDate,currencyId,sightseeingType){ 
$('#loadhotelmaster').load('loadotherActivityMaster.php?serviceid=<?php echo decode($_REQUEST['otherActivityNameId']); ?>&fromDate='+fromDate+'&toDate='+toDate+'&currencyId='+currencyId+'&transferType='+sightseeingType); 
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


funloadotherActivitymaster();

<?php if($_REQUEST['otherActivityNameId']!=''){?>
funloadotherActivitymaster();
<?php } ?>

$('#addnewuserbtn').show();
</script>