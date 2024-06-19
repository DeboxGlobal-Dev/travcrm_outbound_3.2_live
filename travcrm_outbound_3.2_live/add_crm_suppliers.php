<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
if($_GET['id']==''){ 
	/*$where=' name="" and  addedBy='.$_SESSION['userid'].''; 
	deleteRecord(_SUPPLIERS_MASTER_,$where);*/
	$dateAdded=time();
	$namevalue ='name="",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.''; 
	$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue); 

	$supplierNumber = 'S'.str_pad($lastId, 6, '0', STR_PAD_LEFT);
	//$namevalue ='supplierNumber="'.$spNum.'"';  
	//$where='id="'.$supplr_id.'"';  
	//$update = updatelisting(_SUPPLIERS_MASTER_,$namevalue,$where);
}

	 
$paymentTerm=1;
if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']); 
$editaliasname=clean($editresult['aliasname']); 
$editcontactPerson=clean($editresult['contactPerson']);
$supplierNumber=clean($editresult['supplierNumber']);

$hotelType=clean($editresult['companyTypeId']);
$airlinesType=clean($editresult['airlinesType']);
$transferType=clean($editresult['transferType']);
$ferryType=clean($editresult['ferryType']);

$otherType=clean($editresult['otherType']);
$mealType=clean($editresult['mealType']); 
$entranceType=clean($editresult['entranceType']); 
$trainType=clean($editresult['trainType']); 
$activityType=clean($editresult['activityType']); 
$guideType=clean($editresult['guideType']); 
$cruiseType=clean($editresult['cruiseType']); 
$visaType=clean($editresult['visaType']); 
$passportType=clean($editresult['passportType']); 
$insuranceType=clean($editresult['insuranceType']); 

$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$editcategoryId=clean($editresult['categoryId']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']);
$supplierMainType=clean($editresult['supplierMainType']); 
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$locationMap=($editresult['locationMap']);
$editdestinationId=clean($editresult['destinationId']);
$editdestinationlist=clean($editresult['destinationlist']); 
$lastId=$editresult['id'];
$paymentTerm=$editresult['paymentTerm'];
$image=$editresult['image'];
$creditlimit=clean($editresult['creditDays']);
}
 
?><!--
<script src="js/jquery-1.11.3.min.js"></script> --> 
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>

  <?php if($_REQUEST['isQuotationSupplier']==='yes'){ ?> 
		<td align="center" width="5%" style="padding-left: 20px;">
			<div class="bluembutton" style="color:#fff !important;"><a style="color:#fff !important;padding: 2px 10px; font-weight: 100;" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['queryId']; ?>&b2bquotation=1">Back</a></div>
		</td>
		<?php } ?>

    <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>


<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editsuppliers" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 

  <input name="quotationSupplier" type="hidden" id="quotationSupplier" value="<?php echo $_REQUEST['isQuotationSupplier']; ?>" />

  <input name="queryId" type="hidden" id="queryId" value="<?php echo $_REQUEST['queryId']; ?>" />
  <input name="quotationId" type="hidden" id="quotationId" value="<?php echo $_REQUEST['quotationId']; ?>" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Supplier Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="35%" align="left" valign="top" style="padding-right:20px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><div class="griddiv"><label>
	<div class="gridlable" style="width:150px;">Supplier Number   </div>
	<input name="supplierNumber" type="text" class="gridfield" id="supplierNumber" value="<?php echo $supplierNumber; ?>" displayname="Supplier Name" readonly="" maxlength="100" />
	</label>
	</div></td>

    <td width="40%" colspan="2" style="padding-left:10px;"><div class="griddiv" ><label>
	<div class="gridlable" style="width:100px;">Supplier Name<span class="redmind"></span>  </div>
	<input name="name" type="text" class="gridfield validate" id="name" value="<?php echo $editname; ?>" displayname="Supplier Name" maxlength="100" />
	</label>
	</div>
	</td>

	<td width="40%" colspan="2" style="padding-left:10px;"><div class="griddiv"><label>
	<div class="gridlable"style="width:100px;" >Alias Name<span class="redmind"></span>  </div>
	<input name="aliasname" type="text" class="gridfield" id="aliasname" value="<?php echo $editaliasname; ?>" displayname="Alias Name" maxlength="100" />
	</label>
	</div></td>
	
  </tr>
</table>

	
	
	
	
	<div class="griddiv" style="display:none;"><label>
	<!--<div class="gridlable">Supplier Type<span class="redmind"></span>  </div>
	<select id="supplierMainType" name="supplierMainType" class="gridfield validate" displayname="Supplier Type" autocomplete="off"  onchange="$('#suppservice input:checkbox').attr('checked',false);supplierTypechange();"   >
	 <option value="1" <?php if($supplierMainType==1){ ?> selected="selected"<?php } ?>>Direct</option> 
	 <option value="2" <?php if($supplierMainType==2){ ?> selected="selected"<?php } ?>>DMC</option>  
	</select>-->
	<input type="hidden" name="supplierMainType" id="supplierMainType" value="2" />
	</label>
	
	<script>
	function showsingleormulti(obj){
	var supplierMainType = $('#supplierMainType').val(); 
	if(supplierMainType==1){ 
	$('#dest').show();
	$('#locat').show();
	var id  = $(obj).attr('id');
	if(id=='companyTypeId'){  
 	 $('#airlinesType').attr('checked',false);  
	 $('#transferType').attr('checked',false);  
	  $('#sightseeingType').attr('checked',false); 
	  $('#cruiseType').attr('checked',false); 
	  $('#mealType').attr('checked',false);
	  }  
	  
	 if(id=='airlinesType'){ 
 	 $('#companyTypeId').attr('checked',false);  
	 $('#transferType').attr('checked',false);  
	  $('#sightseeingType').attr('checked',false); 
	  $('#cruiseType').attr('checked',false); 
	  $('#mealType').attr('checked',false);
	  } 
	  
	  if(id=='transferType'){ 
 	 	$('#companyTypeId').attr('checked',false);  
	 	$('#airlinesType').attr('checked',false);  
	  	$('#sightseeingType').attr('checked',false);
	  	$('#cruiseType').attr('checked',false);  
	  	$('#mealType').attr('checked',false);
	  }     
	    if(id=='sightseeingType'){ 
 	 	$('#companyTypeId').attr('checked',false);  
	 	$('#airlinesType').attr('checked',false);  
	  	$('#transferType').attr('checked',false); 
	  	$('#cruiseType').attr('checked',false); 
	  	$('#mealType').attr('checked',false);
	  	}   
	    if(id=='cruiseType'){ 
 	 $('#companyTypeId').attr('checked',false);  
	 $('#airlinesType').attr('checked',false);  
	  $('#transferType').attr('checked',false); 
	  $('#sightseeingType').attr('checked',false); 
	  $('#mealType').attr('checked',false); 
	  }  
	  
	    if(id=='mealType'){ 
 	 $('#companyTypeId').attr('checked',false);  
	 $('#airlinesType').attr('checked',false);  
	  $('#transferType').attr('checked',false); 
	  $('#sightseeingType').attr('checked',false); 
	  $('#cruiseType').attr('checked',false);
	  }  
	}
	
	 
	
	}
	
	
	function supplierTypechange(){
		var supplierMainType = $('#supplierMainType').val();
		$('#dest').hide();
		$('#locat').hide();
		$('#hotelcategorydiv').hide();
	}
	
	
	

	</script>
	<script>
	function multi(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
	</script>


	</div>
	<div class="griddiv">
	<div class="gridlable">Supplier Services  <span class="redmind"></span></div>
	<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;" id="suppservice" ><table width="100%" border="0" cellpadding="5" cellspacing="0">
  
	 <tr>
	     
    <td colspan="2"><label><input name="Allselect" type="checkbox" id="Allselect" style="display: block;"  onchange="multi(this);"/>
    

    </label></td>
	
    <td width="96%"><label for="selectAll">All Select Services</label></td>
  </tr>

  
  <tr>
    <td colspan="2"><label><input name="companyTypeId" type="checkbox" id="companyTypeId" style="display: block;" value="1"  <?php if($hotelType==1){ ?>checked="checked" <?php } ?>  onchange="showsingleormulti(this);"/>
    </label></td>
    <td width="96%"><label for="companyTypeId">Hotel</label></td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="airlinesType" type="checkbox" id="airlinesType" onchange="showsingleormulti(this);" style="display: block;" value="7"  <?php if($airlinesType==7){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="airlinesType">Airlines</label></td>
  </tr> 
  <tr>
    <td colspan="2"><input name="mealType" type="checkbox" id="mealType" style="display: block;" value="6"  <?php if($mealType==6){ ?>checked="checked" <?php } ?>  onchange="showsingleormulti(this);"/></td>
    <td><label for="mealType">Restaurant</label></td>
  </tr>
  <tr>
    <td colspan="2"><input name="activityType" type="checkbox" id="activityType" style="display: block;" value="3"  <?php if($activityType==3){ ?>checked="checked" <?php } ?>  onchange="showsingleormulti(this);"/></td>
    <td><label for="activityType">Activity</label></td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="transferType" type="checkbox" id="transferType" onchange="showsingleormulti(this);" style="display: block;" value="5"  <?php if($transferType==5){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="transferType">Transfer</label></td>
  </tr>
   
  <tr>
    <td colspan="2"><label><input name="entranceType" type="checkbox" id="entranceType" onchange="showsingleormulti(this);" style="display: block;" value="4" <?php if($entranceType==4){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="entranceType">Entrance</label></td>
  </tr>
  <tr>
    <td colspan="2"><input name="guideType" type="checkbox" id="guideType" onchange="showsingleormulti(this);" style="display: block;" value="2" <?php if($guideType==2){ ?>checked="checked" <?php } ?>/>
    </td>
    <td><label for="guideType">Guide</label></td>
  </tr> 
  <tr>
    <td colspan="2"><label><input name="trainType" type="checkbox" id="trainType" onchange="showsingleormulti(this);" style="display: block;" value="8" <?php if($trainType==8){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="trainType">Train</label></td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="ferryType" type="checkbox" id="ferryType" onchange="showsingleormulti(this);" style="display: block;" value="10" <?php if($ferryType==10){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="ferryType">Ferry</label></td>
  </tr>

  <tr>
    <td colspan="2"><label><input name="cruiseType" type="checkbox" id="cruiseType" onchange="showsingleormulti(this);" style="display: block;" value="15" <?php if($cruiseType==15){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="cruiseType">Cruise</label></td>
  </tr>

  <tr>
    <td colspan="2"><label><input name="visaType" type="checkbox" id="visaType" onchange="showsingleormulti(this);" style="display: block;" value="11" <?php if($visaType==11){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="visaType">VISA</label></td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="passportType" type="checkbox" id="passportType" onchange="showsingleormulti(this);" style="display: block;" value="12" <?php if($passportType==12){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="ferryType">Passport</label></td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="insuranceType" type="checkbox" id="insuranceType" onchange="showsingleormulti(this);" style="display: block;" value="14" <?php if($insuranceType==14){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td><label for="ferryType">Insurance</label></td>
  </tr>

  <tr>
    <td colspan="2"><input name="otherType" type="checkbox" id="otherType" onchange="showsingleormulti(this);" style="display: block;" value="13" <?php if($otherType==13){ ?>checked="checked" <?php } ?>/></td>
    <td><label for="otherType">Other</label></td>
  </tr>
  </table>
</div>
	</div>
	
	
	<div class="griddiv" style="display:none;"><label>
	<div class="gridlable">GSTN</div>
	<input name="gstn" type="text" class="gridfield" id="gstn"  style="text-transform:uppercase;" value="<?php echo $editgstn; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv" style="border-bottom:0px; display:nones;"> 
	<div class="gridlable">Payment Term </div>
	 <table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td style="padding:0px 0px;"><input name="paymentTerm" type="radio" onclick="myCreditNotShow()"  style="display:block;" value="1" <?php if($paymentTerm==1){ ?>checked="paymentTerm"<?php }?>/>  </td>
    <td style="padding:0px 0px;">Cash</td>
    <td style="padding:0px 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td style="padding:0px 0px;"><label><input name="paymentTerm" type="radio" onclick="myCredit()" style="display:block;" value="2"   <?php if($paymentTerm==2){ ?>checked="paymentTerm"<?php }?>/> 
       </label></td>
    <td>Credit</td>
	<td width="140"  id="enterDays" style="display:none;position: relative;top: -11px;
"><span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From Service Date<input name="creditlimit" id="creditlimit" class="gridfield" type="text" value="<?php echo $creditlimit; ?>" placeholder="Enter Days " style="margin-left:14px; "/> 
	</span></td> 
  </tr>
</table>
 
	</div>
	<div class="griddiv" style="border-bottom:0px;"> 
	<div class="gridlable">Agreement   </div>
	 <table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td style="padding:0px 0px;"><input name="agreement" type="radio"  style="display:block;"  onclick="$('#agreementattachmentDiv').show();$('#addeditfrm').append(''); "  value="1" <?php if($editagreement!=''){ ?>checked="checked"<?php }?>/>  </td>
    <td style="padding:0px 0px;">Yes</td>
    <td style="padding:0px 0px;">&nbsp;&nbsp;</td>
    <td style="padding:0px 0px;"><label><input name="agreement" type="radio" style="display:block;"  onclick="$('#agreementattachmentDiv').hide();" value="0"   <?php if($editagreement==''){ ?>checked="checked"<?php }?>/> 
       </label></td>
    <td>No</td> 
  </tr>
</table>
 
	</div>
	
	<div class="griddiv" id="agreementattachmentDiv" <?php if($editagreement==''){ ?>style="display:none;"<?php } ?>><label>
	<div class="gridlable">Agreement Attachment<span class="redmind"></span></div>
	 <input name="agreementattachment" type="file" class="gridfield" id="agreementattachment" onchange="$('#agreementattachmentHid').val('1');"/>
	 <?php if($editagreement!=''){ ?>
	 <a href="download/<?php echo $editagreement; ?>" target="_blank"><div class="commattachedbox"><strong>Download Attachment</strong>
	   <input name="agreementattachment2" type="hidden" value="<?php echo $editagreement; ?>" id="agreementattachment2" />
	 </div>
	 </a>
	 <?php } ?>
	 <input name="agreementattachmentHid" type="hidden" class="" value="" id="agreementattachmentHid"  displayname="Agreement Attachment"  />
	</label>
	</div>
	<div class="griddiv" style="display:none;"><img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen('action=selectParent','600px','auto');" />
	<label>
	<div class="gridlable">Assign To<span class="redmind"></span></div>
	<input name="ownerName" type="text" class="gridfield" id="ownerName" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen('action=selectParent','600px','auto');" />
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignTo); ?>" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">status<span class="redmind"></span></div>
	<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off"   style="width: 100%;"> 	
	<option value="1" <?php if($editresult['status']=='1'){ ?>selected="selected"<?php } ?>>Active</option>
	<option value="0" <?php if($editresult['status']=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
	</select></label>
    </div>
	
	
	<?php /*?><div class="griddiv"><label>
	<div class="gridlable">Contact Person</div>
	<input name="contactPerson" type="text" class="gridfield" id="contactPerson" value="<?php echo $editcontactPerson; ?>"  maxlength="100" />
	</label>
	</div>
	<?php */?></td>
    <td width="65%" align="left" valign="top" style="padding-left:20px;">
	<!--<div class="griddiv" id="hotelcategorydiv" style="display:none;<?php if($hotelType==1){ ?> display:block;<?php } ?>">
	<label>
	
	<script>
	function selectOpsPersonfunction(){
	var destinationId = $('#destinationId').val();
	if(destinationId>0){
		$('#selectOpsPerson').load('selectOpsPerson.php?id='+destinationId);
	}
	} 
	</script>-->

	<div style="display: grid; grid-template-columns: 100px 100px 200px;">
    <div class="griddiv">
        <label for="destinationWise">
            <div class="gridlable" style="width:100%;">
                <input type="radio" class="destcheckbox" onchange="showCountryfield('0')" <?php if($editresult['destinationWise']=='0' || $editresult['destinationWise']==''){ echo 'checked'; } ?>  value="0" name="destinationWise" id="destinationWise" style="display:inline-block;">Destination
            </div>
        </label>
    </div>

    <div class="griddiv">
        <label for="countryWise">
            <div class="gridlable" style="width:100%;">
                <input type="radio" onchange="showCountryfield('1')" <?php if($editresult['destinationWise']==1){ echo 'checked'; } ?> value="1" class="destcheckbox" name="destinationWise" id="countryWise" style="display:inline-block;">Country
            </div>
        </label>
    </div>

    <div class="griddiv">
        <label for="allDestinations">
            <div class="gridlable" style="width:100%;">
                <input type="radio" class="destcheckbox" onchange="showCountryfield('2')" <?php if($editresult['destinationWise']=='2'){ echo 'checked'; } ?>  value="2" name="destinationWise" id="allDestinations" style="display:inline-block;">All Destinations
            </div>
        </label>
    </div>
	</div>
 
	<div id="countryListBox" class="griddiv hide2"> <label>
		<div class="gridlable">Country</div>
		<select id="destCountryId" name="destCountryId" onchange="selectDestination()" class="gridfield" displayname="Country" autocomplete="off"   >
		<option value="">Select Country</option>
		<?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' deletestatus=0 and status=1 order by id asc';  
		$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
		<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['countryWise']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
		<?php } ?>
		</select></label>
	</div> 
	
	  
	<div class="griddiv" id="destinationListBox"> 
		<label> 
			
			<div class="gridlable">Destinations&nbsp;&nbsp;<button type="button" class="clear-all-btn">Clear All</button></div>
			<select name="destinationId[]" multiple="multiple" class="gridfield js-example-basic-multiple" id="destinationId" displayname="Destination" autocomplete="off">
		    <?php  
		    $select='';  
		    $where='';  
		    $rs='';   
		    $select='*';    
		    $where='deletestatus=0 and status=1 order by name asc';   
		    $rs=GetPageRecord($select, _DESTINATION_MASTER_, $where);
		    $alldest = explode(',', strval($editdestinationId));  
		    while ($resListing = mysqli_fetch_array($rs)) {   
		        $isSelected = in_array($resListing['id'], $alldest) ? 'selected="selected"' : ''; ?> 
		        <option value="<?php echo strip($resListing['id']); ?>" <?php echo $isSelected; ?>>
		            <?php echo strip($resListing['name']); ?>
		        </option>
		    <?php } ?> 
		</select>

		</label> 
	</div>

	<script> 





	    function showCountryfield(val){
	        if(val=='0'){
	            $("#countryListBox").addClass('hide2');
	            $("#destinationListBox").removeClass('hide2');
	        		$('.js-example-basic-multiple').val(null).trigger('change');
	        } else if(val=='1') {
	            $("#countryListBox").removeClass('hide2');
	            $("#destinationListBox").addClass('hide2');
	        		$('.js-example-basic-multiple').val(null).trigger('change');
	        } else if(val=='2') {
	            $("#countryListBox").addClass('hide2');
	            $("#destinationListBox").addClass('hide2');
	        		$('.js-example-basic-multiple').val(null).trigger('change');
	        }
	    }
	 
			function selectDestination(){
				var countryId = $("#destCountryId").val();
				$("#destinationId").load(`load_smallactionfile.php?action=selectSupplierDestinations&countryId=${countryId}&destinationId=<?php echo strval($editdestinationId); ?>`);
			}
			selectDestination();

		$(document).ready(function() {
	    $('.js-example-basic-multiple').select2();

	    // Handle select2 select event
	    // $('.js-example-basic-multiple').on("select2:select", function(e) {
	    //     var data = e.params.data.text;
	    //     if (data == 'All') {
	    //         $(".js-example-basic-multiple > option").prop("selected", "selected");
	    //         $(".js-example-basic-multiple").trigger("change");
	    //     }
	    // });

	    // Handle clear all button click
	    $('.clear-all-btn').on('click', function() {
	        $('.js-example-basic-multiple').val(null).trigger('change');
	    });
	});
	showCountryfield('<?php echo $editresult['destinationWise']; ?>');
  </script>
 	<style type="text/css">
 		.clear-all-btn{
 			font-size: 10px;
	    padding: 3px 7px;
	    background: #fff;
	    border: 1px solid #f00;
	    color: #f20808;
	    border-radius: 2px;
 		}
 		.hide2{
 			position: fixed!important;
 			left: 3000px;
 		}
 		.select2{
 			display: block!important;
 			min-width: 100%!important;
 		}
 	</style>
	<div style=" overflow:hidden;">
	<div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address<strong style="position:absolute; right:0px;"><a onclick="alertspopupopen('action=addsupaddress&supid=<?php echo $lastId; ?>','700px','auto');">+ Add Address</a></strong></div>
	<div id="loadaddress"></div>
	
	</div>
	<script>
	function loadaddress(dltid){
	$('#loadaddress').load('loadaddress.php?addressParent=<?php echo $lastId; ?>&addressType=supplier&dltid='+dltid);
	}
	loadaddress('0');
	</script>
	<div style="display:none;">
		<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Country  </div>
	<select id="countryId" name="countryId" class="gridfield" displayname="Country" autocomplete="off" onchange="selectstate();" >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcountryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">State </div>
	<select id="stateId" name="stateId" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();" >
</select></label>
	</div>
	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">City  </div>
	<select id="cityId" name="cityId" class="gridfield" displayname="City" autocomplete="off" >
</select></label>
	</div>
	
	
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Address 1  </div>
	<input name="address1" type="text" class="gridfield" id="address1" value="<?php echo $editaddress1; ?>" maxlength="250" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Address 2  </div>
	<input name="address2" type="text" class="gridfield" id="address2" value="<?php echo $editaddress2; ?>" maxlength="250" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Address 3</div>
	<input name="address3" type="text" class="gridfield" id="address3" value="<?php echo $editaddress3; ?>" maxlength="250" />
	</label>
	</div>	
	
	<div class="griddiv"><label>
	<div class="gridlable">Pin Code </div>
	<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $editpinCode; ?>" maxlength="15" />
	</label>
	</div> 
	
	
	</div>
	<div class="griddiv" id="locat" style="display:none"><label>
	<div class="gridlable">Location (MAP) </div>
	<input name="locationMap" type="text" class="gridfield" id="locationMap" value="<?php echo $locationMap; ?>" maxlength="500" />
	</label>
	</div>
	
	<!--<div class="griddiv">
	<label id="dest">
	
	
	
	<div class="gridlable" >Expenses Type  </div>
	<select name="expensesType"   class="gridfield"  id="expensesType"   autocomplete="off" displayname="Spending Type" >

<option value="">Select</option>



 <?php 



$select=''; 

$where=''; 

$rs='';  

$select='*';    

$where=' 1 order by name asc';  

$rs=GetPageRecord($select,'expensesType',$where);  

while($resListing=mysqli_fetch_array($rs)){   



?>



<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['expensesType']){ ?> selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>



<?php } ?>



</select>
	
	</label></div>-->
	
	
	
	<div class="griddiv" style="display:none"><label><?php if($image==''){
			echo '';
	}else{?>
		<?php echo '<img src="profilepic/<?php echo $image;?>">'; ?>
		<?php }?>
	<div class="gridlable">Upload Image</div>
	<input name="image" type="file" class="gridfield" id="image" accept="image/x-png,image/gif,image/jpeg"/>
	</label>
	</div>
	
	<div class="griddiv" style="border-bottom:0px;"> 
	<label>
	<div class="gridlable" style="margin-top: 20px; font-size: 14px; color: #7a96ff; font-weight: 500;">Contact Person</div>
	<div id="loadcontactpers">
	<?php 
$contactpCount=1; 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' corporateId='.$lastId.' and contactPerson!="" and deletestatus=0 order by id asc';  
$rs=GetPageRecord($select,'suppliercontactPersonMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
 <div id="phoneidcp<?php echo $contactpCount; ?>">
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
      <td width="280" align="left">
	  <select id="division<?php echo $contactpCount; ?>" name="division<?php echo $contactpCount; ?>" class="gridfield validate" displayname="Division" autocomplete="off"  placeholder="Division" >
	  	<option value="">Division</option>
 <?php  
$selectd='*';    
$whered=' deletestatus=0 and status=1 order by name asc';  
$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
while($resListingd=mysqli_fetch_array($rsd)){  

?>
<option value="<?php echo strip($resListingd['id']); ?>" <?php if($resListingd['id']==$resListing['division']){?> selected="selected"<?php } ?>><?php echo strip($resListingd['name']); ?></option>
<?php } ?>
</select>	  </td> 
    <td width="321" align="left"><input name="contactPerson<?php echo $contactpCount; ?>" type="text" class="gridfield" id="contactPerson<?php echo strip($resultlists['contactPerson']); ?>" value="<?php echo $resListing['contactPerson']; ?>"  maxlength="100" placeholder="Contact Person" />
    <input name="contactPId<?php echo $contactpCount; ?>" type="hidden" value="<?php echo $resListing['id']; ?>" />
<?php
 ?>	</td>
 
    <td width="250" align="left"><input name="designation<?php echo $contactpCount; ?>" type="text" class="gridfield" id="designation" value="<?php echo ($resListing['designation']); ?>" placeholder="Designation" /></td>
     
    <td width="80" align="center">
	<?php 
$rsn="";
$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
$cmpcountryData=mysqli_fetch_array($rs1cmp);
$compcountryCode = $cmpcountryData['compcountryCode'];
?>



	
	<input name="countryCode<?php echo $contactpCount; ?>" type="text" class="gridfield" id="countryCode" value="<?php if($resListing['countryCode'] !=''){ echo $resListing['countryCode']; }else{ echo '+'. $compcountryCode;}  ?>" placeholder="+91" /></td> 
	
    <td width="251" align="center"><input name="phone<?php echo $contactpCount; ?>" type="text" class="gridfield" id="phone" value="<?php echo decode($resListing['phone']); ?>" placeholder="Phone" maxlength="14"/></td> 
    <td width="354" align="center"><input name="email<?php echo $contactpCount; ?>" type="text" class="gridfield" id="email" value="<?php echo decode($resListing['email']); ?>"  placeholder="Email" /></td>
    <!-- second mail id section  -->
	<td width="354" align="center"><input name="secondemail<?php echo $contactpCount; ?>" type="text" class="gridfield" id="secondemail" value="<?php echo decode($resListing['email1']); ?>"  placeholder="Secondary Email" /></td> 
    <td width="70" align="center">
	<?php if($contactpCount==1){ ?>
	<img src="images/addicon.png" width="20" height="20" onClick="addphoneNumberscp();" style="cursor:pointer;" />
	<?php } else { ?>
	<img src="images/deleteicon.png"  onclick="removecontactperson(<?php echo $contactpCount; ?>,<?php echo $resListing['id'] ?>);" style="cursor:pointer;" />
	<?php } ?>	</td>
  </tr>
</table>  

</div> 
 <?php $contactpCount++; } ?>
 
 
 
 <?php if($contactpCount==1){ ?>
 <div id="phoneidcp1">
 <table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="321" align="left"><select id="division1" name="division1" class="gridfield validate" displayname="Division" autocomplete="off"  placeholder="Division" >
	 <option value="">Division</option>
 <?php  
$selectd='*';    
$whered=' deletestatus=0 and status=1 order by name asc';  
$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
while($resListingd=mysqli_fetch_array($rsd)){  

?>
<option value="<?php echo strip($resListingd['id']); ?>"><?php echo strip($resListingd['name']); ?></option>
<?php } ?>


</select></td>
    <td width="321" align="left"><input name="contactPerson1" type="text" class="gridfield validate" id="contactPerson1" value="" displayname="Contact Person"  maxlength="100" placeholder="Contact Person" /></td> 
    <td width="288" align="left"><input name="designation1" type="text" class="gridfield validate" id="designation1" value="" displayname="Designation" placeholder="Designation" /></td> 
    <td width="144" align="center">
	<?php 
$rsn="";
$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
$cmpcountryData=mysqli_fetch_array($rs1cmp);
$compcountryCode = $cmpcountryData['compcountryCode'];
?>
	<input name="countryCode1" type="text" class="gridfield validate" id="countryCode1" value="<?php echo '+'. $compcountryCode; ?>" displayname="Country Code" placeholder="+91" />

</td> 
    <td width="251" align="center"><input name="phone1" type="text" class="gridfield validate" id="phone1" value="" displayname="Phone"  placeholder="Phone" maxlength="14"/></td> 
    <td width="354" align="center"><input name="email1" type="text" class="gridfield validate" id="email" value="" displayname="Email"  placeholder="Email" /></td> 
    <td width="354" align="center"><input name="secondemail1" type="text" class="gridfield" id="secondemail1" value="" displayname="Secondary Email"  placeholder="Secondary Email" /></td> 
    <td width="70" align="center"><input name="primaryvalue" class="gridfield" type="radio" value="1" checked="checked" style="display:block;"  ></td>
    <td width="70" align="center"><img src="images/addicon.png" width="20" height="20" onClick="addphoneNumberscp();" style="cursor:pointer;" /></td>
  </tr>
</table> 
</div>
 <?php } ?>
 <input name="contactpCount" type="hidden" id="contactpCount" value="<?php if($contactpCount==1){ echo '1'; } else { echo $contactpCount; } ?>" />
 <script>
 function addphoneNumberscp(){
 var contactpCount = $('#contactpCount').val();
 contactpCount=Number(contactpCount)+1;  

 $.get("loadcontactperson.php?id="+contactpCount, function (data) { 
$("#loadcontactpers").append(data); 
}); 
  $('#contactpCount').val(contactpCount);
 $
 }
 
 
 
 function removecontactperson(id,contactPerson){
	$('#phoneidcp'+id).remove();	
	var contactpCount = $('#contactpCount').val();
	contactpCount=Number(contactpCount)-1;  
	$('#contactpCount').val(contactpCount);
	$('#removecontactperson').load('frm_action.crm?contactpersonid='+contactPerson+'&action=deletecontactperson');
 }
 </script>
 </div>
	 
	</label>
	
	</div>
	 	 </td>
  </tr>
</table>
</div>
<div id="removecontactperson"></div>
<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />
		<?php
		if($_GET['id']!=''){
		?>
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
		<?php } ?>
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
</table>
</div>
 
</form>
</div>
<script>  
// credit on  Started  
function myCredit() {
	

  var x = document.getElementById("enterDays");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


var payShow = <?php echo $paymentTerm;  ?>;
if(payShow==2){
	myCredit();
}



function myCreditNotShow() {
	var x = document.getElementById("enterDays");
	if (x.style.display === "block") {
		x.style.display = "none";
	} else {
		x.style.display = "block";
	}
}


// credit on  ended 


		comtabopenclose('linkbox','op2'); 
</script>

<style>
	/* .select2-container{
		overflow: hidden;
		height: 40px;
	} */
</style>
 
 