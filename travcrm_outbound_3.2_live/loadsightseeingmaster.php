<?php
include "inc.php"; 
include "config/logincheck.php"; 

if($_GET['id']!=''){
$id=clean($_GET['id']);

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1); 
$name=clean($editresult['name']);  

}
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
    padding: 12px 4px;
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

<div class="topaboxouter">
 
<div id="addTriffRoom" style="display:nxone;">
<div class="addGreenHeader">Add Sightseeing</div>
<div class="addeditpagebox addtopaboxlist"> <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice">

<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:760px;">

  <tbody> 
  <tr style="    background-color: transparent !important;">
    <td align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php echo $_REQUEST['fromDate']; ?>" style="width: 100px !important;" />
	</label>
	</div></td>

    <td align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php echo $_REQUEST['toDate']; ?>"  style="width: 100px !important;" />
	</label>
	</div></td>
    <td align="left"><div class="griddiv">
	<label> 
	
	<div class="gridlable">Currency<span class="redmind"></span></div>
	<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"  style="width:80px;"  >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['currencyId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div></td>
    <td align="left"><div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Sightseeing<span class="redmind"></span></div>
	<select id="sightseeingNameId" name="sightseeingNameId" class="gridfield validate" displayname="Sightseeing Name" autocomplete="off" style="width: 150px;" > 
 <?php
$select1='*';  
$where1='id='.$_REQUEST['serviceid'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$sightseeingdetail=mysqli_fetch_array($rs1);  
?>
<option value="<?php echo $_REQUEST['serviceid']; ?>"><?php echo strip($sightseeingdetail['sightseeingName']);  ?></option>
 
</select></label>
	</div></td>
    <td align="left"><div class="griddiv">
	<label> 
	<script>
	function sightseeingTypeSelect(){
	var sightseeingType = $('#sightseeingType').val();
	$('.SIC').css('display','none');
	$('.PVT').css('display','none');
	
	if(sightseeingType==1){
	$('.SIC').css('display','table-cell');
	}
	
	if(sightseeingType==2){
	$('.PVT').css('display','table-cell');
	}
	}
	</script>
	<div class="gridlable">Type <span class="redmind"></span></div>
	<select id="sightseeingType" name="sightseeingType" class="gridfield validate" displayname="Sightseeing Type" autocomplete="off"   onchange="sightseeingTypeSelect();" style="width: 80px;" >
  
<option value="1" <?php if('1'==$_REQUEST['sightseeingType']){ ?>selected="selected"<?php } ?>>SIC</option>
<option value="2" <?php if('2'==$_REQUEST['sightseeingType']){ ?>selected="selected"<?php } ?>>Private</option>
</select></label>
	</div></td>

    <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Ticket&nbsp;Adul</div>
	<input name="ticketAdultCost" type="text" class="gridfield"  id="ticketAdultCost" maxlength="12" onkeyup="numericFilter(this);" style="width: 80px;"/>
	</label>
	</div></td>

    <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Ticket&nbsp;Child</div>
	<input name="ticketchildCost" type="text" class="gridfield"  id="ticketchildCost" maxlength="12" onkeyup="numericFilter(this);" style="width: 80px;"/>
	</label>
	</div></td>
    <td align="left" class="SIC"><div class="griddiv"><label>
	<div class="gridlable">Adult&nbsp;Cost</div>
	<input name="adultCost" type="text" class="gridfield"  id="adultCost" maxlength="12" onkeyup="numericFilter(this);" style="width: 80px;"/>
	</label>
	</div></td>
    <td align="left" class="SIC"><div class="griddiv"><label>
	<div class="gridlable">Child&nbsp;Cost</div>
	<input name="childCost" type="text" class="gridfield"  id="childCost" maxlength="12" onkeyup="numericFilter(this);" style="width: 80px;"/>
	</label>
	</div></td>
    <!--<td align="left"  class="SIC" style="display:none;" ><div class="griddiv"><label>
	<div class="gridlable"><div style="
    font-size: 10px;
    color: #808080;
">&nbsp;</div>Infant&nbsp;Cost</div>
	<input name="infantsCost" type="text" class="gridfield"  id="infantsCost" maxlength="12" onkeyup="numericFilter(this);" style="width: 80px; display:none;"/>
	</label>
	</div></td>-->
    <td align="left" class="PVT">
 
	<script>
	function showmaxpax(){
	var vehicleId = $('#vehicleId').val();
	$('#maxpaxbox').load('loadmaxpaxdmcbox.php?id='+vehicleId);
	}
	
	</script>
	<div class="griddiv"><label>
	<div class="gridlable">Vehicle&nbsp;Name</div>
	<select id="vehicleId" name="vehicleId" class="gridfield"  autocomplete="off"  onchange="showmaxpax();" style="width: 80px;" >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div></td>
    <td align="left" class="PVT" id="maxpaxbox"><div class="griddiv"><label>
	<div class="gridlable">Max&nbsp;Pax</div>
	<input name="infantCost" type="text" class="gridfield"  id="infantCost" maxlength="12" readonly="readonly" style="width: 50px;"/>
	</label>
	</div></td>
    <td align="left"   class="PVT" ><div class="griddiv"><label>
	<div class="gridlable">Vehicle&nbsp;Cost</div>
	<input name="vehicleCost" type="text" class="gridfield"  id="vehicleCost" maxlength="12"  onkeyup="numericFilter(this);" style="width: 80px;" />
	</label>
	</div></td>
    <td align="left"  ><div class="griddiv"><label>
	<div class="gridlable">Information</div>
	<input name="detail" type="text" class="gridfield"  id="detail" maxlength="220"  style="width: 80px;"/>
	</label>
	</div></td>
    <td align="left" valign="middle"  ><div class="griddiv">
	<label> 
	
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off" style="width: 80px;" > 
 
<option value="1">Active</option>
<option value="0">In Active</option>
</select></label>
	</div></td>
    <td align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');"></td>
    <td align="center" valign="middle"  ><a onClick="openclose(0);" style=" 
    display: block;">Cancel</a>
      <input name="SightSeeingSupplierId" type="hidden" id="SightSeeingSupplierId" value="<?php echo $_GET['id']; ?>">
	  <input name="action" type="hidden" id="action" value="addSightSeeingPrice">
	  <input name="serviceid" type="hidden" id="serviceid" value="<?php echo $_GET['serviceid']; ?>">
	  </td>
    </tr> 
</tbody></table>
</form>
</div>
</div>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='sightseeingType,id';    
$where=' supplierId='.$editresult['id'].' group by sightseeingType order by sightseeingType asc';  
$rs=GetPageRecord($select,_DMC_SIGHTSEEING_RATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<div class="topaboxlist"> 
<div style="margin-bottom:20px; font-size:25px;"><table border="0" cellpadding="0" cellspacing="0">
  <tr><td style="padding-right:15px;"><img src="images/<?php if($resListing['sightseeingType']==1){ echo 'dmcbusicon.png'; } if($resListing['sightseeingType']==2){ echo 'dmccaricon.png'; } ?>" /></td>
    <td colspan="2"><?php if($resListing['sightseeingType']==1){ echo 'SIC'; } if($resListing['sightseeingType']==2){ echo 'PRIVATE'; } ?></td>
    
  </tr>
  
</table>
</div>



 <?php 
$select23=''; 
$where23=''; 
$rs23='';  
$select23='*';    
$where23='  sightseeingType='.$resListing['sightseeingType'].' and supplierId='.$_GET['id'].' and sightseeingNameId='.$_REQUEST['serviceid'].' group by fromDate order by fromDate asc';  
$rs23=GetPageRecord($select23,_DMC_SIGHTSEEING_RATE_MASTER_,$where23); 
while($PriceresListing=mysqli_fetch_array($rs23)){  
  
?>

<div class="roompricelistmain">
<div class="headermainprice"><span style="color: #909090;">Validity Date:</span> <?php echo showdate($PriceresListing['fromDate']); ?> - <?php echo showdate($PriceresListing['toDate']); ?></div>


 
<?php if($resListing['sightseeingType']==1){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >Sightseeing Name</th>

      <th align="center" class="header"><div style="
    font-size: 10px;
    color: #808080;
">Sightseeing Ticket</div>Adult Cost</th>
      <th align="center" class="header"><div style="
    font-size: 10px;
    color: #808080;
">Sightseeing Ticket</div>Child Cost</th>
      <th align="center" class="header">Adult Cost</th>
      <th align="center" class="header">Child Cost</th>
     <th align="center" class="header">Infant Cost</th>

     <th align="left" class="header">Information</th>
     <th align="center" class="header">	Status</th>
     <th align="center" class="header">&nbsp;</th>
   </tr>
   </thead>

 


 

  <tbody>
 <?php
 
 $select1=''; 
$wher1=''; 
$rs1='';  
$select1='*';    
$where1='  fromDate="'.$PriceresListing['fromDate'].'" and sightseeingType='.$PriceresListing['sightseeingType'].' and supplierId='.$_GET['id'].' and sightseeingNameId='.$_REQUEST['serviceid'].'  order by id asc';  
$rs1=GetPageRecord($select1,_DMC_SIGHTSEEING_RATE_MASTER_,$where1); 
while($dmcroommastermain=mysqli_fetch_array($rs1)){  

 
?>
  <tr>
    <td align="left">
	
 <?php
$select1='*';  
$where1='id='.$_REQUEST['serviceid'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$sightseeingdetail=mysqli_fetch_array($rs1);  
?><?php echo strip($sightseeingdetail['sightseeingName']);  ?></td>

    <td align="center"><?php 
 $select2='name';  
$where2='id='.$dmcroommastermain['currencyId'].''; 
$rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
$cur=clean($editresult2['name']);  
?><?php echo $cur.' '.strip($dmcroommastermain['ticketAdultCost']); ?></td>
    <td align="center"><?php echo $cur.' '.strip($dmcroommastermain['ticketchildCost']); ?></td>
    <td align="center"> <?php echo $cur.' '.strip($dmcroommastermain['adultCost']); ?></td>
    <td align="center"><?php echo $cur.' '.strip($dmcroommastermain['childCost']); ?></td>
    <td align="center"><?php echo $cur.' '.strip($dmcroommastermain['infantCost']); ?></td>

    <td align="left"><?php echo strip($dmcroommastermain['detail']); ?></td>
    <td align="center"><?php if($dmcroommastermain['status']==1){echo 'Active'; } else { echo 'In Active'; }  ?></td>
    <td align="center"><a onClick="alertspopupopen('action=editdmcsightseengrate&sectionId=<?php echo $dmcroommastermain['id']; ?>&suppid=<?php echo $_GET['id']; ?>','400px','auto');">Edit</a></td>
  </tr> 
	
	<?php  } ?>
</tbody></table>
<?php } ?>

<?php if($resListing['sightseeingType']==2){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >Sightseeing Name</th>

      <th align="center" class="header"><div style="
    font-size: 10px;
    color: #808080;
">Sightseeing Ticket</div>Adult Cost</th>
      <th align="center" class="header"><div style="
    font-size: 10px;
    color: #808080;
">Sightseeing Ticket</div>Child Cost</th>
      <th align="left" class="header">Vehicle Name</th>
      <th align="center" class="header">Max Pax</th>
     <th align="center" class="header">Vehicle Cost</th>

     <th align="left" class="header">Information</th>
     <th align="center" class="header">	Status</th>
     <th align="center" class="header">&nbsp;</th>
   </tr>
   </thead>

 


 

  <tbody>
 <?php
 
 $select22=''; 
$wher22=''; 
$rs22='';  
$select22='*';    
$where22='  fromDate="'.$PriceresListing['fromDate'].'" and sightseeingType='.$PriceresListing['sightseeingType'].' and supplierId='.$_GET['id'].' and sightseeingNameId='.$_REQUEST['serviceid'].' order by id asc';  
$rs22=GetPageRecord($select22,_DMC_SIGHTSEEING_RATE_MASTER_,$where22); 
while($dmcroommastermain=mysqli_fetch_array($rs22)){  

 
?>
  <tr>
    <td align="left">
	
	<?php
$select1='*';  
$where1='id='.$_REQUEST['serviceid'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$sightseeingdetail=mysqli_fetch_array($rs1);  
?><?php echo strip($sightseeingdetail['sightseeingName']);  ?>	</td>

    <td align="center"><?php 
 $select2='name';  
$where2='id='.$dmcroommastermain['currencyId'].''; 
$rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
$cur=clean($editresult2['name']);  
?>
      <?php echo $cur.' '.strip($dmcroommastermain['ticketAdultCost']); ?></td>
    <td align="center"><?php echo $cur.' '.strip($dmcroommastermain['ticketchildCost']); ?></td>
    <td align="left"> <?php 
 $select2='name,maxpax';  
$where2='id='.$dmcroommastermain['vehicleId'].''; 
$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?></td>
    <td align="center"><?php echo clean($editresult2['maxpax']); ?></td>
    <td align="center"><?php echo $cur.' '.strip($dmcroommastermain['vehicleCost']); ?></td>

    <td align="left"><?php echo strip($dmcroommastermain['detail']); ?></td>
    <td align="center"><?php if($dmcroommastermain['status']==1){echo 'Active'; } else { echo 'In Active'; }  ?></td>
    <td align="center"><a onClick="alertspopupopen('action=editdmcsightseengrate&sectionId=<?php echo $dmcroommastermain['id']; ?>&suppid=<?php echo $_GET['id']; ?>','400px','auto');">Edit</a></td>
  </tr> 
	
	<?php  } ?>
</tbody></table>
<?php } ?>

</div>
 <?php } ?>
 
 
</div>
<?php } ?>


</div>

<script>
sightseeingTypeSelect();

<?php if($_REQUEST['fromDate']!=''){ ?>
openclose(1);
<?php } ?>
function loadHotelRoom(){
funloadhotelmaster('<?php echo $_GET['id']; ?>');
}

</script>

<style>
.SIC{display:none;}
.PVT{display:none;}
</style>