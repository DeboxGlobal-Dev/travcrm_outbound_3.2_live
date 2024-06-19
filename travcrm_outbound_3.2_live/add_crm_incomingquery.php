<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}


if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_INCOMING_QUERY_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editdescription=clean($editresult['description']); 
$editsubject=clean($editresult['subject']);
$date = clean($editresult['adddate']);
}
?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#description",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
        <?php if($_GET['id']!=''){ ?>
        Update <?php if($_REQUEST['salesquery']==1){ echo 'Sales'; } ?> 
        <?php } else { ?>
        Add <?php if($_REQUEST['salesquery']==1){ echo 'Sales'; } ?> 
        <?php } ?>
          <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
            <td><input type="button" name="Submit3" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
            <td style="padding-right:20px;">
<?php if($_REQUEST['salesquery']==1){ ?> 
<a href="showpage.crm?module=leads"><input type="button" name="Submit22" value="Cancel" class="whitembutton"  /></a>
<?php } else { ?>
<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
<?php } ?>

</td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;margin-top: -40px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="<?php if($_GET['id']!=''){ echo 'editquery';} else { echo 'addquery'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Client Type   <span class="redmind"></span></div>
	<select id="clientType" name="clientType" class="gridfield validate" displayname="Client Type" autocomplete="off" onchange="selectclienttypename();"    >
	 <option value="">Select</option> 
<option value="1" <?php if(1==$clientType){ ?>selected="selected"<?php } ?>>Agent</option> 
<option value="2" <?php if(2==$clientType){ ?>selected="selected"<?php } ?>>B2C</option> 
</select></label>
	</div>
	<div class="griddiv" id="selectclientbox" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>;"><img src="images/companyicon.png" width="30" height="30" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="openselectCompanypop();" />
	<label>
	<script>
	function openselectCompanypop(){
	var clientType1 = $('#clientType').val(); 	
	alertspopupopen('action=selectCorporate&clientType='+clientType1+'','600px','auto');
	}
	
	
	function selectclienttypename(){
	$('#companyName').val('');
	$('#companyId').val('');
	$('#agentb2cmail').val('');
	$('#agentb2cnumber').val('');
	var clientType = $('#clientType').val();
	if(clientType>0){
	$('#selectclientbox').show();
	$('#banumber').show();
	$('#baemail').show();
	if(clientType==1){
	$('#agentTypeDiv').text('Agent');
	$('#agentTypeemail').text('Agent Email');
	$('#agentTypemobile').text('Agent Mobile No');
	}
	if(clientType==2){
	$('#agentTypeDiv').text('B2C');
	$('#agentTypeemail').text('B2C Email');
	$('#agentTypemobile').text('B2C Mobile No');
	}
	
	} else { 
	$('#selectclientbox').hide();
	$('#banumber').hide();
	$('#baemail').hide();
	}
	
	}
	</script>
<?php
if($clientType==2){
	$select2='*';  
	$where2='id='.$editcompanyId.''; 
	$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
	$contantnamemain=mysqli_fetch_array($rs2);

	$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
	$getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');
	$getemail =  getPrimaryEmail($contantnamemain['id'],'contacts'); 

} else { 
	$clientnem = getCorporateCompany($editcompanyId);
	$getphone =  getPrimaryPhone(getCorporateCompany(['id'],'corporate')); 
	$getemail =  getPrimaryEmail(getCorporateCompany(['id'],'corporate')); 
}


?>
	<div class="gridlable"><c id="agentTypeDiv">Agent / B2C</c><span class="redmind"></span></div>
	<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>" readonly="true" displayname="Company" autocomplete="off" onclick="openselectCompanypop();" />
	<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
	</label>
	
	</div>
	
	<div class="griddiv" id="baemail" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>;"><label>
	<div class="gridlable" ><c id="agentTypeemail" >Agent / B2C</c></div>
	<input name="agentb2cmail" type="text" class="gridfield" id="agentb2cmail"  displayname=""    value="<?php echo $getemail; ?>" />
	
	</label>
	</div>
	<div class="griddiv" id="banumber" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>;"><label>
	<div class="gridlable" ><c id="agentTypemobile" >Agent / B2C</c></div>
	<input name="agentb2cnumber" type="text" class="gridfield" id="agentb2cnumber"  displayname=""    value="<?php echo $getphone; ?>" />
	
	</label>
	</div>
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Destination  <span class="redmind"></span></div>
	<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$destinationId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	 
	<div class="griddiv"><label>
	<div class="gridlable">Sub Destination</div>
	<input name="subDestination" type="text" class="gridfield" id="subDestination"  displayname="Sub Destination"    value="<?php echo $subDestination; ?>" />
	</label>
	</div>
	
	  <div class="griddiv"><label>
	<div class="gridlable">Adult <span class="redmind"></span></div>
	<input name="adult" type="text" class="gridfield validate" onKeyUp="numericFilter(this);setoccupancy();" id="adult" displayname="Adult" value="<?php echo $editadult; ?>" maxlength="3" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Child</div>
	<input name="child" type="text" class="gridfield" id="child" onKeyUp="numericFilter(this);appendchildage(5);" displayname="Child" value="<?php echo $editchild; ?>" maxlength="3" />
	</label>
	</div>
	<div class="griddiv">
	<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
  <script>
 
 
  var childnumber=1;
  function appendchildage(no){
   $('.childagedivchilds').html('');
  	var child=$('#child').val();
	for(c=1;c<=child; c++)
	{
  $('#childagediv').append('<div style="float:left; margin-right:5px;margin-bottom:8px; width:24%;"><label><div class="gridlable" style="width:100%;">Child '+c+' Age</div><input name="childrensage[]" type="text" class="gridfield" id="childrensage"  displayname="Child1 Age"  onKeyUp="numericFilter(this);"  maxlength="2" value="<?php echo $age1; ?>" placeholder="Max Age 12 Years"/></label></div>');
  }
  childnumber++; }
  </script>
    <td style="padding-left:0px;" id="childagediv" class="childagedivchilds"> 
	
	</td>
     
     
  </tr>
</table>

	
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Infant</div>
	<input name="infant" type="text" class="gridfield" id="infant" onKeyUp="numericFilter(this);" displayname="Infant" value="<?php echo $infant; ?>" maxlength="3" />
	</label>
	</div>
		 
	
		<div class="griddiv"><label>
	<div class="gridlable">Guest 1   </div>
	<input name="guest1" type="text" class="gridfield"  id="guest1"  value="<?php echo $editguest1; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Guest 1 Phone</div>
	<input name="guest1phone" type="text" class="gridfield"  id="guest1phone"  value="<?php echo $guest1phone; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Guest 1 Email</div>
	<input name="guest1email" type="text" class="gridfield"  id="guest1email"  value="<?php echo $guest1email; ?>" maxlength="100" />
	</label>
	</div>
		<div class="griddiv"><label>
	<div class="gridlable">Guest 2   </div>
	<input name="guest2" type="text" class="gridfield"  id="guest2"  value="<?php echo $editguest2; ?>" maxlength="100" />
	</label>
	</div>
	  
	<div class="griddiv" style="display:none;">
	<label>
	<div class="gridlable">Office Branch<span class="redmind"></span></div>
	<select id="officeBranch" name="officeBranch" class="gridfield validate" displayname="Office Branch" autocomplete="off" > 
	<option value="1" <?php if($editofficeBranch==1){ ?>selected="selected"<?php } ?>>Head Office</option>
 <option value="2" <?php if($editofficeBranch==2){ ?>selected="selected"<?php } ?>>Branch Office</option>  
</select></label>
	</div>
	
	  	<div class="griddiv"><img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen('action=selectParent&userType=1','600px','auto');" />
	<label>
	<div class="gridlable">Operations Person<span class="redmind"></span></div>
	<div id="selectOpsPerson"><input name="ownerName" type="text" class="gridfield validate" id="ownerName" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen('action=selectParent&userType=1','600px','auto');" />
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignTo); ?>" /></div>
	</label>
	</div><div class="griddiv">
	<label>
	
	<script>
	function selectOpsPersonfunction(){
	var destinationId = $('#destinationId').val();
	if(destinationId>0){
	$('#selectOpsPerson').load('selectOpsPerson.php?id='+destinationId);
	}
	}
	</script>
	
	<div class="gridlable">Hotel Category  </div>
	<select id="categoryId" name="categoryId" class="gridfield " displayname="Hotel Category" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_HOTEL_CATEGORY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcategoryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div><?php if($clientType==''){ ?>
	<div class="griddiv"><label>
	<div class="gridlable">Attachment</div>
	<input name="attachmentFile" type="file" class="gridfield" id="attachmentFile"/>
	</label>
	</div>
	<?php } ?>		</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	

	<div class="griddiv">
	<label>
	<div class="gridlable">From Travel Date <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate" onfocus="changedatefunction();" class="gridfield calfieldicon validate"  displayname="From Travel Date"   autocomplete="off" value="<?php echo $fromDate; ?>" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">To Travel Date<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="To Travel Date" autocomplete="off" value="<?php echo $toDate; ?>" onfocus="changedatefunction();" />
	</label>
	</div>
	  <div class="griddiv"><label>
	<div class="gridlable">Night <span class="redmind"></span></div>
	<input name="night" type="number" class="gridfield validate" id="night" maxlength="3" max="99" min="1"  displayname="Night" onKeyUp="numericFilter(this);"  value="<?php echo $night; ?>" />
	</label>
	</div>
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Tour Type <span class="redmind"></span></div>
	<select id="tourType" name="tourType" class="gridfield validate" displayname="Tour Type" autocomplete="off"   >
	 <option value="10">Holiday Packages</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$edittourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Priority</div>
	<select id="queryPriority" name="queryPriority" class="gridfield"  autocomplete="off" > 
	<option value="3">High</option>
	<option value="2" selected="selected">Medium</option>
 <option value="1">Low</option>  
</select></label>
	</div>
	
	<script>
	function calroom(){
	var single = Number($('#single').val());
	var double = Number($('#double').val());
	var triple = Number($('#triple').val());
	$('#rooms').val('');
	$('#rooms').val(single+double+triple); 
	}
	
	</script>
	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">TAT</div>
	<select id="tat" name="tat" class="gridfield"  autocomplete="off" > 
	<option >None</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+30 minutes")); ?>" selected="selected" >30 Minutes</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+45 minutes")); ?>" >45 Minutes</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+1 hour")); ?>" >1 Hour</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+2 hour")); ?>" >2 Hour</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+4 hour")); ?>" >4 Hour</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+6 hour")); ?>" >6 Hour</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+8 hour")); ?>" >8 Hour</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+12 hour")); ?>" >12 Hour</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+1 day")); ?>" >1 Day</option>
	<option value="<?php echo date("Y-m-d h:i:s", strtotime("+2 day")); ?>" >2 Day</option> 
</select></label>
	</div>
	
	<div class="gridlable">Occupancy Type  </div>
	<div class="griddiv">
	<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td style="padding-left:0px;"><label> 
	<div class="gridlable">Single  </div>
	<input name="single" type="text" class="gridfield" id="single"  displayname="Sub Destination"    value="<?php echo $single; ?>"  onkeyup="calroom();numericFilter(this);" /></label></td>
    <td><label> 
	<div class="gridlable">Double  </div>
	<input name="double" type="text" class="gridfield" id="double"  displayname="Sub Destination"    value="<?php echo $doubleocp; ?>" onkeyup="calroom();numericFilter(this);"/></label></td>
    <td><label> 
	<div class="gridlable">Triple  </div>
	<input name="triple" type="text" class="gridfield" id="triple"  displayname="Sub Destination"    value="<?php echo $triple; ?>" onkeyup="calroom();numericFilter(this);"/></label></td>
  </tr>
</table>

	
	</div>
	 
	 
	
	<div class="griddiv" style="display:none;">
	<label>
	
	 
	
	<div class="gridlable">Occupancy Type  </div>
	<select id="occupancyType" name="occupancyType" class="gridfield" autocomplete="off"  onchange="setoccupancy();" >
 
  
<option value="1" <?php if(1==$occupancyType){ ?>selected="selected"<?php } ?>>Single</option>
<option value="2" <?php if(2==$occupancyType){ ?>selected="selected"<?php } ?>>Double</option>
<option value="3" <?php if(3==$occupancyType){ ?>selected="selected"<?php } ?>>Triple</option>
</select></label>
	</div>
	
	<script>
	function setoccupancy(){
	var adult = $('#adult').val();
	if(adult>0){
	var occupancyType = $('#occupancyType').val();
	if(occupancyType==1){
	$('#rooms').val(adult);
	}
	
	if(occupancyType==2){
	adult=Math.ceil(Number(adult/2));
	$('#rooms').val(adult);
	}
	
	if(occupancyType==3){
	adult=Math.ceil(Number(adult/3)); 
	$('#rooms').val(adult);
	}
	}
	}
	</script>
	
	<div class="griddiv"><label>
	<div class="gridlable">Rooms</div>
	<input name="rooms" type="text" class="gridfield" onKeyUp="numericFilter(this);" id="rooms" displayname="Rooms"   value="<?php echo $rooms; ?>" maxlength="3" />
	</label>
	</div>
	<script>
	calroom();
	</script>
	<div class="griddiv"><label>
	<div class="gridlable">Hotel Budget</div>
	<input name="hotelBudget" type="text" class="gridfield" id="hotelBudget" onKeyUp="numericFilter(this);"  value="<?php echo $edithotelBudget; ?>" maxlength="10" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Payment Mode</div>
	<select id="paymentMode" name="paymentMode" class="gridfield"  autocomplete="off" > 
	<option value="1">BTC</option>
	<option value="2">Direct Payment</option> 
</select>
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable" style="width:100%;">Add More Emails  (Comma Separated Emails)   </div>
	<input name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="test@example.com,test@example.com"   value="<?php echo $multiemails; ?>"/>
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable" style="width:100%;">Reference No.</div>
	<input name="referanceno" type="text" class="gridfield" id="referanceno" placeholder="Referance No."   value="<?php echo $referanceno; ?>"/>
	</label>
	</div>
	 <div class="griddiv"><label>
	<div class="gridlable" style="width:100%;">File Code </div>
	<input name="filecode" type="text" class="gridfield" id="filecode" placeholder="File Code "   value="<?php echo $filecode; ?>"/>
	</label>
	</div>
	
	
	 
	
	
	
	<script>
	function selectstate(){
	var countryId = $('#countryId').val();
	$('#stateId').load('loadstate.php?id='+countryId+'&selectId=<?php echo $editcountryId; ?>');
	}
 
	function selectcity(){
	var stateId = $('#stateId').val();
	$('#cityId').load('loadcity.php?id='+stateId+'&selectId=<?php echo $editstateId; ?>');
	}
	
	<?php
	if($_GET['id']!=''){ 
	?>
	selectstate();
	selectcity();
	<?php } ?>
	</script>		 	 </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><div class="griddiv"><label>
	<div class="gridlable">Subject <span class="redmind"></span></div>
	<input name="subject" type="text" class="gridfield validate" id="subject" value="<?php echo $editsubject; ?>"  displayname="Subject" maxlength="250" />
	</label>
	</div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"> 
      <h2 style="margin-bottom:0px; margin-top:20px; padding:20px; background-color:#f5f5f5; border: 1px #ccc solid; cursor:pointer;" onclick="salesopncls();"><span id="plusminus"><?php if($_REQUEST['salesquery']==1){ echo '+'; } else { echo '-'; } ?></span> Sales Information</h2>
	  
	  <div style="padding:20PX; background-color:#fbfbfb; border:1px solid #ccc;" id="mainsalesmodule"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
    <td width="50%" align="left" valign="top"style="padding-right:20px;"><div class="griddiv"><label>
	<div class="gridlable">Expected Sales Amount</div>
	<input name="expectedSales" type="text" class="gridfield" id="expectedSales" onKeyUp="numericFilter(this);"  value="<?php echo $expectedSales; ?>" maxlength="15" />
	</label>
	</div><div class="griddiv">
	<label>
	
	 
	
	<div class="gridlable">Lead Source  </div>
	<select id="leadsource" name="leadsource" class="gridfield" autocomplete="off"   >  
<option>Select</option> 
<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" order by id';

$rs=GetPageRecord($select,_LEAD_SOURCE_MASTER_,$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($leadsource==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>
</select>

 

</label>
	</div>
	
	<div class="griddiv">
	<label>
	
	 
	
	<div class="gridlable">Competitor</div>
	<select id="competitor" name="competitor" class="gridfield" autocomplete="off"   >  
<option>Select</option> 
<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" order by id';

$rs=GetPageRecord($select,_COMPETITOR_MASTER_,$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($competitor==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>
</select>

 

</label>
	</div>	</td>
    <td width="50%" align="left" valign="top"style="padding-left:20px;" ><div class="griddiv">
	<label>
	<div class="gridlable">Expected Closer Date<span class="redmind"></span></div>
	<input name="closerDate" type="text" id="closerDate" class="gridfield calfieldicon validate"  displayname="Expected Closer Date"   autocomplete="off" value="<?php echo $closerDate; ?>" />
	</label>
	</div>
	<div class="griddiv">
	<label>
	
	 
	
	<div class="gridlable">Campaign  </div>
	<select id="campaign" name="campaign" class="gridfield" autocomplete="off"   > 

<option>Select</option> 

<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" order by id';

$rs=GetPageRecord($select,_CAMPAIN_MASTER_,$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($campaign==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>
</select>

 

</label>
	</div>	</td>
  </tr>
      
    </table></div>
	
	<script>
	function salesopncls(){
	var plusminus = $('#plusminus').text();
	if(plusminus=='+'){
	$('#mainsalesmodule').show();
	$('#plusminus').text('-');
	} else {
	$('#mainsalesmodule').hide();
	$('#plusminus').text('+');
	}
	
	}
	
	salesopncls();
	</script> </td>
  </tr>
   

   
  <tr>
    <td colspan="2" align="left" valign="top">
	 <div class="innerbox" >
      <h2 style="margin-bottom: 10px; padding-top:20px;">Flight Information&nbsp;&nbsp;&nbsp;  <a  style="font-size:14px;"  onclick="alertspopupopen('action=addqueryflightdetails&queryflightid=<?php echo $lastqueryidmain; ?>','600px','auto');" >+ Add Flight</a></h2>
    </div>
	<div style="margin:10px 0px 20px;border: 1px #e0e0e0 solid;  ">
	<div style="padding:20px;" id="loadflightdetails">Loading...</div>
	<script>
	function loadflightdetailsfunc(){
$('#loadflightdetails').load('loadflightdetails.php?id=<?php echo $lastqueryidmain; ?>');
}
loadflightdetailsfunc();




function deleteflight(id){
	   $('#loadflightdetails').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#loadflightdetails').load('loadflightdetails.php?id=<?php echo $lastqueryidmain; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
	  }
	  
	  function deleteflightalert(id){
	  if (confirm("Do you want to delete this flight detail?")){
    deleteflight(id);
}
	  }

	</script>
	</div> 
	
	
	
	
	
	
	
	 <div class="innerbox" >
      <h2 style="margin-bottom: 10px; padding-top:20px;">Sightseeing Information&nbsp;&nbsp;&nbsp;  <a  style="font-size:14px;"  onclick="alertspopupopen('action=addquerysightseeingdetails&queryflightid=<?php echo $lastqueryidmain; ?>','600px','auto');" >+ Add Sightseeing</a></h2>
    </div>
	<div style="margin:10px 0px 20px;border: 1px #e0e0e0 solid;  ">
	<div style="padding:20px;" id="loadsightseeingdetails">Loading...</div>
	<script>
	function loadsightseeingdetailsfun(){
$('#loadsightseeingdetails').load('loadsightseeingdetails.php?id=<?php echo $lastqueryidmain; ?>');
}
loadsightseeingdetailsfun();




function deletesightseeing(id){
	   $('#loadsightseeingdetails').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#loadsightseeingdetails').load('loadsightseeingdetails.php?id=<?php echo $lastqueryidmain; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
	  }
	  
	  function deletesightseeingalert(id){
	  if (confirm("Do you want to delete this sightseeing detail?")){
    deletesightseeing(id);
}
	  }

	</script>
	</div> 
	
	
	
	<div class="innerbox" >
      <h2 style="margin-bottom: 10px; padding-top:20px;">Transfer Information&nbsp;&nbsp;&nbsp;  <a  style="font-size:14px;"  onclick="alertspopupopen('action=addqueryTransferdetails&queryflightid=<?php echo $lastqueryidmain; ?>','600px','auto');" >+ Add Transfer</a></h2>
    </div>
	<div style="margin:10px 0px 20px;border: 1px #e0e0e0 solid;  ">
	<div style="padding:20px;" id="loadtransferdetails">Loading...</div>
	<script>
	function loadtransferdetailsfun(){
$('#loadtransferdetails').load('loadtransferdetails.php?id=<?php echo $lastqueryidmain; ?>');
}
loadtransferdetailsfun();




function deleteloadtransfer(id){
	   $('#loadtransferdetails').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#loadtransferdetails').load('loadtransferdetails.php?id=<?php echo $lastqueryidmain; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
	  }
	  
	  function deleteloadtransferdetailsalert(id){
	  if (confirm("Do you want to delete this transfer detail?")){
    deleteloadtransfer(id);
}
	  }

	</script>
	</div> 
	
	<div class="griddiv"><label>
	<div class="gridlable">Description</div>
	<textarea name="description" rows="10" class="gridfield" id="description"><?php echo $editdescription; ?></textarea>
	</label>
	</div></td>
    </tr>
</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> 
		<input name="editId" type="hidden" id="editId" value="<?php if($lastqueryidmain!=''){ echo encode($lastqueryidmain); } ?>" />
		<input name="salesquery" type="hidden" id="salesquery" value="<?php echo $_REQUEST['salesquery']; ?>" />
		<input name="queryedityes" type="hidden" id="queryedityes" value="<?php if($clientType!=''){ echo 'yes'; } else { echo 'no'; }?>" />
		 
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
	 
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
        <td style="padding-right:20px;"><?php if($_REQUEST['salesquery']==1){ ?> 
<a href="showpage.crm?module=leads"><input type="button" name="Submit22" value="Cancel" class="whitembutton"  /></a>
<?php } else { ?>
<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
<?php } ?></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<script>  

function changePriority(){
var adult = $('#adult').val();
if(adult>9){ 
$('#queryPriority').val('3');
} 


}

window.setInterval(function(){
changePriority()
}, 1000);



comtabopenclose('linkbox','op2');

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
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

 

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
   
  
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  
  
  var date = new Date(fromDate);
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate() - 7);
    
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();

    var someFormattedDate = ('0'+dd).slice(-2) + '-' + ('0'+mm).slice(-2) + '-' + y;
  
  $('#closerDate').val(someFormattedDate);
  
  var night = totaldays;
if(night<6){
$('#queryPriority').val('3');
}
  } 
} 

 

</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
