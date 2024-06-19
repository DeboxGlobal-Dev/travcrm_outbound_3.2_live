<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}


$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1';
deleteRecord(_QUERY_MASTER_,$wheredel);

$dateAdded=time();
$namevalue ='deletestatus=1,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';  
$lastqueryidmain= addlistinggetlastid(_QUERY_MASTER_,$namevalue);


if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editcompanyId=clean($editresult['companyId']); 
$edittravelDate=clean($editresult['travelDate']);
$editfromDate=clean($editresult['fromDate']);
$edittoDate=clean($editresult['toDate']);
$editofficeBranch=clean($editresult['officeBranch']);
$editdestinationId=clean($editresult['destinationId']);
$editadult=clean($editresult['adult']);
$editchild=clean($editresult['child']);
$editnight=clean($editresult['night']); 
$edittourType=clean($editresult['tourType']); 
$editdescription=clean($editresult['description']);  
$editguest1=clean($editresult['guest1']);  
$editguest2=clean($editresult['guest2']);  
$editcategoryId=clean($editresult['categoryId']);  
$editqueryCloseDetails=clean($editresult['queryCloseDetails']);  
$editqueryCloseDate=clean($editresult['queryCloseDate']);  
$editmultiemails=clean($editresult['multiemails']);
$editqueryStatus=clean($editresult['queryStatus']);
$editattachmentFileclean($editresult['attachmentFile']);
$editremark=clean($editresult['remark']);
$editqueryId=clean($editresult['queryId']);
$editsubject=clean($editresult['subject']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']);  
$lastId=$editresult['id'];
$clientType=$editresult['clientType'];
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
        Update
        <?php } else { ?>
        Add
        <?php } ?>
          <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
            <td><input type="button" name="Submit3" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
            <td style="padding-right:20px;"><input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="<?php if($_GET['id']!=''){ echo 'editquery';} else { echo 'addquery'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Query Information</h2>
    </div></td>
    </tr>
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
	<div class="griddiv" id="selectclientbox" style="display:none;"><img src="images/companyicon.png" width="30" height="30" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="openselectCompanypop();" />
	<label>
	<script>
	function openselectCompanypop(){
	var clientType1 = $('#clientType').val(); 	
	alertspopupopen('action=selectCorporate&clientType='+clientType1+'','600px','auto');
	}
	
	
	function selectclienttypename(){
	$('#companyName').val('');
	$('#companyId').val('');
	var clientType = $('#clientType').val();
	if(clientType>0){
	$('#selectclientbox').show();
	if(clientType==1){
	$('#agentTypeDiv').text('Agent');
	}
	if(clientType==2){
	$('#agentTypeDiv').text('B2C');
	}
	
	} else { 
	$('#selectclientbox').hide();
	}
	
	}
	</script>
	
	<div class="gridlable"><c id="agentTypeDiv">Agent / B2C</c><span class="redmind"></span></div>
	<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo getCorporateCompany($editcompanyId); ?>" readonly="true" displayname="Company" autocomplete="off" onclick="openselectCompanypop();" />
	<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcountryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	 
	
	
	  <div class="griddiv"><label>
	<div class="gridlable">Adult <span class="redmind"></span></div>
	<input name="adult" type="text" class="gridfield validate" onKeyUp="numericFilter(this);" id="adult" displayname="Adult" value="<?php echo $editadult; ?>" maxlength="3" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Child</div>
	<input name="child" type="text" class="gridfield" id="child" onKeyUp="numericFilter(this);" displayname="Child" value="<?php echo $editchild; ?>" maxlength="3" />
	</label>
	</div>
	
	
		 
	
		<div class="griddiv"><label>
	<div class="gridlable">Guest 1   </div>
	<input name="guest1" type="text" class="gridfield"  id="guest1"  value="<?php echo $editguest1; ?>" maxlength="100" />
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
	<select id="categoryId" name="categoryId" class="gridfield validate" displayname="Hotel Category" autocomplete="off"   >
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
	</div>		</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	

	<div class="griddiv">
	<label>
	<div class="gridlable">From Travel Date <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate" onfocus="changedatefunction();" class="gridfield calfieldicon validate"  displayname="From Travel Date"   autocomplete="off" value="" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">To Travel Date<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="To Travel Date" autocomplete="off" value="" onfocus="changedatefunction();" />
	</label>
	</div>
	  <div class="griddiv"><label>
	<div class="gridlable">Night <span class="redmind"></span></div>
	<input name="night" type="number" class="gridfield validate" id="night" maxlength="3" max="99" min="1"  displayname="Night" onKeyUp="numericFilter(this);"  />
	</label>
	</div>
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Tour Type <span class="redmind"></span></div>
	<select id="tourType" name="tourType" class="gridfield validate" displayname="Tour Type" autocomplete="off"   >
	 <option value="">Select</option>
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
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Priority</div>
	<select id="queryPriority" name="queryPriority" class="gridfield"  autocomplete="off" > 
	<option value="3">High</option>
	<option value="2" selected="selected">Medium</option>
 <option value="1">Low</option>  
</select></label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Subject <span class="redmind"></span></div>
	<input name="subject" type="text" class="gridfield validate" id="subject" value="<?php echo $editsubject; ?>"  displayname="Subject" maxlength="250" />
	</label>
	</div>
	
	 <div class="griddiv"><label>
	<div class="gridlable" style="width:100%;">Add More Emails  (Comma Separated Emails)   </div>
	<input name="multiemails" type="text" class="gridfield" id="multiemails" value="" placeholder="test@example.com,test@example.com" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Attachment</div>
	<input name="attachmentFile" type="file" class="gridfield" id="attachmentFile"/>
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
    <td colspan="2" align="left" valign="top"  >
	<div class="innerbox">
      <h2 style="margin-bottom: 10px; padding-top:20px;">Flight Information&nbsp;&nbsp;&nbsp;  <a  style="font-size:14px;"  onclick="alertspopupopen('action=addqueryflightdetails&queryflightid=<?php echo $lastqueryidmain; ?>','600px','auto');" >+ Add Flight</a></h2>
    </div>
	<div style="margin:10px 0px 20px;border: 1px #e0e0e0 solid;">
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
        <td><input name="editId" type="hidden" id="editId" value="<?php if($lastId!=''){ echo encode($lastId); } ?>" />
		<input name="editId" type="hidden" id="editId" value="<?php if($lastqueryidmain!=''){ echo encode($lastqueryidmain); } ?>" />
		 
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
	 
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
