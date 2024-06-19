<?php
if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
$paymentTerm=1;
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,'conferencesMaster',$where1); 
$editresult=mysqli_fetch_array($rs1);
}

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="addconference" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Conference Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv"><label>
	<div class="gridlable">Conferences Name<span class="redmind"></span>  </div>
	<input name="name" type="text" class="gridfield validate" id="name" value="<?php echo strip($editresult['name']); ?>" displayname="Conferences Name" maxlength="100" />
	</label>
	</div>	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33%"><div class="griddiv"><label>
	<div class="gridlable">Start Date <span class="redmind"></span>  </div>
	<input name="startDate" type="text" class="gridfield validate" id="fromDate" value="<?php if($editresult['startDate']!=''){ echo date('d-m-Y',strtotime($editresult['startDate'])); } ?>" displayname="Start Date" maxlength="100"   onblur="calculatedays();" onfocus="calculatedays();" />
	</label>
	</div></td>
    <td width="33%"><div class="griddiv"><label>
	<div class="gridlable">End Date <span class="redmind"></span>  </div>
	<input name="endDate" type="text" class="gridfield validate" id="toDate" value="<?php if($editresult['endDate']!=''){ echo date('d-m-Y',strtotime($editresult['endDate'])); } ?>" displayname="End Date" maxlength="100"  onblur="calculatedays();" onfocus="calculatedays();" />
	</label>
	</div></td>
    <td width="33%"><div class="griddiv"><label>
	<div class="gridlable">Duration (Days) <span class="redmind"></span>  </div>
	<input name="cDuration" type="text" class="gridfield validate" id="cDuration" value="<?php echo strip($editresult['cDuration']); ?>" displayname="Duration" maxlength="100" readonly="readonly"  onfocus="calculatedays();"  />
	</label>
	</div>
	
	<script>
	function toTimestamp(strDate){
      var datum = Date.parse(strDate);
      return datum/1000;
   }
   
   
	function calculatedays(){
		   
     var fromDate1 = $('#fromDate').val().split("-").reverse().join("-"); 
        var toDate1 = $('#toDate').val().split("-").reverse().join("-");
		

var fromDate2 = $('#fromDate').val(); 
var toDate2 = $('#toDate').val();		
$('#fromDate').val(fromDate2);
$('#toDate').val(toDate2); 
 
		
		
          var fromDatestamp1 = toTimestamp(''+fromDate1+''); 
           var toDatestamp1 = toTimestamp(''+toDate1+'');  
            var totaldays1 = showDays(toDate1,fromDate1); 
        if(totaldays1!='' || totaldays1=='0'){ 
		
		  if(totaldays1>0){
     $('#cDuration').val(totaldays1);}
	 }
	 
	}
	
	
	  function showDays(firstDate,secondDate){ 
                     var startDay = new Date(firstDate);
                     var endDay = new Date(secondDate);
                     var millisecondsPerDay = 1000 * 60 * 60 * 24;
   
                     var millisBetween = startDay.getTime() - endDay.getTime();
                     var days = millisBetween / millisecondsPerDay;
   
                     // Round down.
                     return ( Math.floor(days));
   
                 }
	</script>
	
	</td>
  </tr>
</table>

	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33%"><div class="griddiv"><label>
	<div class="gridlable">City <span class="redmind"></span>  </div>
	<select name="cityId" size="1" class="gridfield validate" id="cityId" displayname="City" autocomplete="off"   > 
	 <option value="">Select</option> 
 <?php  
$select='';  
$where='';  
$rs='';   
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';   
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);  
while($resListing=mysqli_fetch_array($rs)){   
?> 
<option value="<?php echo strip($resListing['id']); ?>" <?php if($editresult['cityId']==$resListing['id']){ ?> selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
<?php } ?> 
</select>
	</label>
	</div></td>
    <td width="77%"><div class="griddiv"><label>
	    <div class="gridlable">Address</div>
	<input name="address" type="text" class="gridfield" id="address" value="<?php echo strip($editresult['address']); ?>" displayname="Address" maxlength="100"   />
	</label>
	</div>	</td>
  </tr>
</table>
	
	
	 
	<div class="griddiv"><label>
	<div class="gridlable">Logo</div>
	 <input name="logo" type="file" class="gridfield" id="logo" />
	<?php if($editresult['logo']!=''){ ?> 
	 <div style="margin-top:20px;"><img src="upload/<?php echo $editresult['logo']; ?>" height="73"  ><input name="logo2" type="hidden" value="<?php echo $editresult['logo']; ?>" /></div>
	 <?php } ?>
	</label>
	</div>
	 
	 
	  
	 
	 	 	 </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"> 
</td>
    </tr>
</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo $_GET['id']; ?>" />
 
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
  $(document).ready(function() {
  $('.select2').select2();
   
  });
  </script>
<script>  
showedit();
comtabopenclose('linkbox','op2');
</script>
<style>
.addeditpagebox .griddiv .gridlable { 
    width: 100% !important; 
}

.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper { 
    width: 100% !important;
}
</style>