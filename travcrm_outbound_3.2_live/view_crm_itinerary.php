<?php
if($_GET['id']!=''){
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(decode($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  
 


$editassignTo=clean($resultpage['assignTo']); 
$editcompanyId=clean($resultpage['companyId']); 
$edittravelDate=clean($resultpage['travelDate']);
$editfromDate=clean($resultpage['fromDate']);
$edittoDate=clean($resultpage['toDate']);
$editofficeBranch=clean($resultpage['officeBranch']);
$destinationId=clean($resultpage['destinationId']);
$editadult=clean($resultpage['adult']);
$editchild=clean($resultpage['child']);
$editnight=clean($resultpage['night']); 
$edittourType=clean($resultpage['tourType']); 
$editdescription=clean($resultpage['description']);  
$editguest1=clean($resultpage['guest1']);  
$editguest2=clean($resultpage['guest2']);  
$editcategoryId=clean($resultpage['categoryId']);  
$editqueryCloseDetails=clean($resultpage['queryCloseDetails']);  
$editqueryCloseDate=clean($resultpage['queryCloseDate']);  
$editmultiemails=clean($resultpage['multiemails']);
$editqueryStatus=clean($resultpage['queryStatus']);
$editattachmentFileclean=($resultpage['attachmentFile']);
$editremark=clean($resultpage['remark']);
$editqueryId=clean($resultpage['queryId']);
$editsubject=clean($resultpage['subject']); 
$addedBy=clean($resultpage['addedBy']);
$dateAdded=clean($resultpage['dateAdded']);
$modifyBy=clean($resultpage['modifyBy']);
$modifyDate=clean($resultpage['modifyDate']);  
$lastId=$resultpage['id'];
$clientType=$resultpage['clientType'];
$lastqueryidmain=$resultpage['id']; 
$fromDate=date("d-m-Y", strtotime($resultpage['fromDate']));
$toDate=date("d-m-Y", strtotime($resultpage['toDate']));
$night=$resultpage['night'];
$multiemails=$resultpage['multiemails'];
$occupancyType=$resultpage['occupancyType'];
$rooms=$resultpage['rooms'];
}
 
$where2=''; 
$rs2='';   
$select2='*'; 
$where2='queryId='.decode($_GET['id']).''; 
$rs2=GetPageRecord($select2,_ITINERARY_MASTER_,$where2); 
$resultpage2=mysqli_fetch_array($rs2);  

if($resultpage2['id']!=''){  
$editassignTo=clean($resultpage2['assignTo']); 
$editcompanyId=clean($resultpage2['companyId']); 
$edittravelDate=clean($resultpage2['travelDate']);
$editfromDate=clean($resultpage2['fromDate']);
$edittoDate=clean($resultpage2['toDate']);
$editofficeBranch=clean($resultpage2['officeBranch']);
$destinationId=clean($resultpage2['destinationId']);
$editadult=clean($resultpage2['adult']);
$editchild=clean($resultpage2['child']);
$editnight=clean($resultpage2['night']); 
$edittourType=clean($resultpage2['tourType']); 
$editdescription=clean($resultpage2['description']);  
$editguest1=clean($resultpage2['guest1']);  
$editguest2=clean($resultpage2['guest2']);  
$editcategoryId=clean($resultpage2['categoryId']);  
$editqueryCloseDetails=clean($resultpage2['queryCloseDetails']);  
$editqueryCloseDate=clean($resultpage2['queryCloseDate']);   
$editqueryStatus=clean($resultpage2['queryStatus']);
$editattachmentFileclean=($resultpage2['attachmentFile']);
$editremark=clean($resultpage2['remark']);
$editqueryId=clean($resultpage2['queryId']);
$editsubject=clean($resultpage2['subject']); 
$addedBy=clean($resultpage2['addedBy']);
$dateAdded=clean($resultpage2['dateAdded']);
$modifyBy=clean($resultpage2['modifyBy']);
$modifyDate=clean($resultpage2['modifyDate']);  
$lastId=$resultpage2['id'];
$clientType=$resultpage2['clientType'];
$lastqueryidmain=$resultpage2['id']; 
$fromDate=date("d-m-Y", strtotime($resultpage2['fromDate']));
$toDate=date("d-m-Y", strtotime($resultpage2['toDate']));
$night=$resultpage2['night'];
$editinfant=$resultpage2['infant'];
$occupancyType=$resultpage2['occupancyType'];
$editdepartureDestinationId=$resultpage2['departureDestinationId'];
$rooms=$resultpage2['rooms'];

}

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
 <script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

function showDays(firstDate,secondDate){ 
                  var startDay = new Date(firstDate);
                  var endDay = new Date(secondDate);
                  var millisecondsPerDay = 1000 * 60 * 60 * 24;

                  var millisBetween = startDay.getTime() - endDay.getTime();
                  var days = millisBetween / millisecondsPerDay;

                  // Round down.
                  return ( Math.floor(days));

              }
			  
			  
			  
			  
function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
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
 
  } 
} 








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

<style>
body{background-color:#eae9ee !IMPORTANT;}
.style1 {font-weight: bold}
</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%" align="left" valign="top" class="queryleft"><div class="innerdiv">
	
	<div class="contentbox" style="background-color: rgba(0,0,0,0.2);"><div class="lables">Query ID</div> 
	<div style="font-size:24px;"><?php echo makeQueryId($resultpage['id']); ?></div>
	</div>
	 
	 
	
	<div class="contentbox">
	  <div class="lables">Query Date</div> 
	  <?php echo showdate($resultpage['queryDate']); ?>	</div>
	
	<div class="contentbox">
	  <div class="lables">Check In</div> 
	  <?php echo showdate($resultpage['fromDate']); ?>	</div>
	
	<div class="contentbox">
	  <div class="lables">Check Out</div> 
	  <?php echo showdate($resultpage['toDate']); ?>	</div>
	
	 
	<div class="contentbox">
	  <div class="lables">Destination</div> 
	  <?php echo getDestination($resultpage['destinationId']); ?>	</div>
	<div class="contentbox">
	  <div class="lables">Occupancy Type</div> 
	  <?php if($resultpage['occupancyType']==1){
$occup='Single';
}

if($resultpage['occupancyType']==2){
$occup='Double';
}

if($resultpage['occupancyType']==3){
$occup='Tripale';
}

echo $occup; ?>
	</div>
	<div class="contentbox">
	  <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="center"><div style="background-color:#232a32; margin-right:2px; padding:4px;"><div class="lables">Adult</div><?php echo $resultpage['adult']; ?></div></td>
            <td align="center" ><div style="background-color:#232a32; margin-right:2px;padding:4px;"><div class="lables">Child</div><?php echo $resultpage['child']; ?></div></td>
            <td align="center" ><div style="background-color:#232a32;padding:4px;"><div class="lables">Nights</div><?php echo $resultpage['night']; ?></div></td>
            <td align="center" ><div style="background-color:#232a32;padding:4px;">
              <div class="lables">Rooms</div>
              <?php echo $resultpage['rooms']; ?></div></td>
          </tr>
        </table>   
	</div>
	 
	<?php if($resultpage['guest1']!=''){ ?>
	<div class="contentbox">
	  <div class="lables">Guest 1</div> 
	  <?php echo ($resultpage['guest1']); ?>	</div>
	<?php } ?>
	<?php if($resultpage['guest1phone']!=''){ ?>
	<div class="contentbox">
	  <div class="lables">Guest 1 Phone</div> 
	  <?php echo ($resultpage['guest1phone']); ?>
	</div>
	<?php } ?>
	<?php if($resultpage['guest1email']!=''){ ?>
	<div class="contentbox">
	  <div class="lables">Guest 1 Email</div> 
	  <?php echo ($resultpage['guest1email']); ?>
	</div>
	<?php } ?>
	
	
	<?php if($resultpage['guest2']!=''){ ?>
	<div class="contentbox">
	  <div class="lables">Guest 2</div> 
	  <?php echo ($resultpage['guest2']); ?>	</div>
	<?php } ?>
	 <div class="contentbox" ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resultpage['id']); ?>" style="color:#fff;  font-size:12px;" target="_blank">View Full Query Details</a> </div>
	
	</div></td>
    <td width="91%" align="left" valign="top">
	<div class="contentboxaddagent">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td><div class="headingm" style="margin-left:20px;"><?php echo strip($resultpage['subject']); ?> -  Itinerary
</div></td>
    <td align="right" valign="middle"><?php if($resultpage2['id']!=''){ ?><a target="_blank" href="day-wise-plan.crm?id=<?php echo $_REQUEST['id']; ?>"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Preview" ></a><a target="_blank" href="showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['id']; ?>&itinerary=1"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Send Itinerary"  style="margin-right:20px;">
    </a><?php } ?></td>
  </tr>
</tbody></table>
</div>
	 <div style="padding:15px; background-color:#FFFFFF; padding-left:20px; display:none;" id="markupdiv">
<table border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="2">Applicable Mark-Up:</td>
    <td><input name="markup" type="text" id="markup" style="padding:10px; border:1px #ccc solid; width:50px;" onkeyup="numericFilter(this);"  value="<?php echo $resultpage2['markup']; ?>" size="3"   maxlength="3"  displayname="MarkUp"></td>
    <td>%</td>
    <td><input type="button" name="Submit" value="Save" class="bluembutton" style="background-color: #c7492c !important; margin-left:0px; border: 1px #c7492c solid !important; margin-top:0px; margin-right:0px;" onclick="loadmainboxquotation();$('#showaddmarkup').show();"></td>
    <td><div id="showaddmarkup" style="color:#CC0000; display:none;">Mark-Up Updated</div></td>
  </tr>
</table>
<script>
window.setInterval(function(){
$('#showaddmarkup').hide();
}, 5000);
</script>
</div>
<style>
.tabclass {    overflow: hidden;
    border-bottom: 2px #ffc115 solid;padding-top: 15px;
    height: 43px;}
.tabclass a{
    padding: 10px 20px;
    float: left;
    font-size: 15px;
    background-color: #fff;
    color: #000;
    margin-left: 5px;
    border: 1px solid #fff;
}
.tabclass .active{    padding: 10px 20px;
    float: left;
    font-size: 15px;
    background-color: #ffc115;
    color: #FFFFFF !important;
    border: 1px solid #ffc115;
}
</style>
<div id="loadhotelmaster">
<div class="tabclass">
<a  href="showpage.crm?module=itinerary&view=yes&id=<?php echo $_REQUEST['id']; ?>" <?php if($_REQUEST['tab']==''){ ?>class="active"<?php } ?>><strong>Travel Details</strong></a>
<?php if($resultpage2['id']!=''){ ?>
<a  href="showpage.crm?module=itinerary&view=yes&id=<?php echo $_REQUEST['id']; ?>&tab=2"  <?php if($_REQUEST['tab']=='2'){ ?>class="active"<?php } ?>><strong>Day Wise Plan</strong></a>
<a  href="showpage.crm?module=itinerary&view=yes&id=<?php echo $_REQUEST['id']; ?>&tab=3"  <?php if($_REQUEST['tab']=='3'){ ?>class="active"<?php } ?>><strong> Inclusion / Exclusion</strong></a>
<a  href="showpage.crm?module=itinerary&view=yes&id=<?php echo $_REQUEST['id']; ?>&tab=4"  <?php if($_REQUEST['tab']=='4'){ ?>class="active"<?php } ?>><strong>Cost</strong></a>
<a  href="showpage.crm?module=itinerary&view=yes&id=<?php echo $_REQUEST['id']; ?>&tab=5"  <?php if($_REQUEST['tab']=='5'){ ?>class="active"<?php } ?>><strong>Tips</strong></a>
<a  href="showpage.crm?module=itinerary&view=yes&id=<?php echo $_REQUEST['id']; ?>&tab=6"  <?php if($_REQUEST['tab']=='6'){ ?>class="active"<?php } ?>><strong>Welcome Note</strong></a>
<?php } ?>
</div>
<?php if($_REQUEST['tab']==''){ ?>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">



 <div class="addeditpagebox" style="position:static; padding: 20px; background-color: #fff;">
 
 
  <input name="action" type="hidden" id="action" value="additinerary" />
  <span class="addeditpagebox" style="position:static; padding: 20px; background-color: #fff;">
  <input name="queryId" type="hidden" id="queryId" value="<?php echo ($resultpage['id']); ?>" />
  </span>
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <input name="editid" type="hidden" id="editid" value="<?php echo $resultpage2['id']; ?>" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
 
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Client Type<span class="redmind"></span></div>
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
	<?php
	if($clientType==2){
	$select2='firstName,lastName';  
$where2='id='.$editcompanyId.''; 
$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
$contantnamemain=mysqli_fetch_array($rs2);
$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
} else { 
$clientnem = getCorporateCompany($editcompanyId);
}


?>
	<div class="gridlable"><c id="agentTypeDiv">Agent / B2C</c><span class="redmind"></span></div>
	<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>" readonly="true" displayname="Company" autocomplete="off" onclick="openselectCompanypop();" />
	<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
	</label>
	</div>
	
	 
	<div class="griddiv"><label>
	<div class="gridlable">Guest 1   </div>
	<input name="guest1" type="text" class="gridfield"  id="guest1"  value="<?php echo $editguest1; ?>" maxlength="100" />
	</label>
	</div>
	
	 <script>
	 function countpaxtotal(){ 
	 var adult = Number($('#adult').val());
	 var child = Number($('#child').val());
	 var infant = Number($('#infant').val());
	 
	 $('#totalpax').val(Number(adult+child+infant));
	 }
	 </script>
	
	
	  <div class="griddiv"><label>
	<div class="gridlable">Total Adult <span class="redmind"></span></div>
	<input name="adult" type="text" class="gridfield validate" onKeyUp="numericFilter(this);countpaxtotal();" id="adult" displayname="Adult" value="<?php echo $editadult; ?>" maxlength="3" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Total Child</div>
	<input name="child" type="text" class="gridfield" id="child" onKeyUp="numericFilter(this);countpaxtotal();" displayname="Child" value="<?php echo $editchild; ?>" maxlength="3" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Total Infant</div>
	<input name="infant" type="text" class="gridfield" id="infant" onKeyUp="numericFilter(this);countpaxtotal();" displayname="Child" value="<?php echo $editinfant; ?>" maxlength="3"  />
	</label>
	</div>
		 
	
		
		 
	  
	<div class="griddiv" style="display:none;">
	<label>
	<div class="gridlable">Office Branch<span class="redmind"></span></div>
	<select id="officeBranch" name="officeBranch" class="gridfield validate" displayname="Office Branch" autocomplete="off" > 
	<option value="1" <?php if($editofficeBranch==1){ ?>selected="selected"<?php } ?>>Head Office</option>
 <option value="2" <?php if($editofficeBranch==2){ ?>selected="selected"<?php } ?>>Branch Office</option>  
</select></label>
	</div>	 	 </td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
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
	<div class="gridlable">Nights <span class="redmind"></span></div>
	<input name="night" type="number" class="gridfield validate" id="night" maxlength="3" max="99" min="1"  displayname="Night" onKeyUp="numericFilter(this);"  value="<?php echo $night; ?>" />
	</label>
	</div>
	 
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Departure Destination</div>
	<select id="departureDestinationId" name="departureDestinationId" class="gridfield" displayname="Destination" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editdepartureDestinationId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	 
	
	 <div class="griddiv"><label>
	<div class="gridlable">Total Pax </div>
	<input name="totalpax" type="text" class="gridfield" id="totalpax" onKeyUp="numericFilter(this);" displayname="Child" value="<?php echo  $editchild+$editadult+$editinfant; ?>" maxlength="3" readonly="readonly" />
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
    <td colspan="2" align="left" valign="top"  st >
	 <div class="innerbox" style="display:none;">
      <h2 style="margin-bottom: 10px; padding-top:20px;">Flight Information&nbsp;&nbsp;&nbsp;  <a  style="font-size:14px;"  onclick="alertspopupopen('action=addqueryflightdetails&queryflightid=<?php echo $lastqueryidmain; ?>','600px','auto');" >+ Add Flight</a></h2>
    </div>
	<div style="margin:10px 0px 20px;border: 1px #e0e0e0 solid; display:none;">
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
	</div>	 </td>
    </tr>
</table>
</div>
<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" style="margin-right:20px;" /></td>
        </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>

<?php } if($_REQUEST['tab']==2){?>

<div class="addeditpagebox" id="daywiseplan" style="position:static; padding: 20px; background-color: #fff;">
Loading...
</div>

<script>
function loaddaywiseplan(deleteid){
$('#daywiseplan').load('daywiseplan.php?id=<?php echo ($resultpage['id']); ?>&deleteid='+deleteid);
}

loaddaywiseplan('');

function deletetrasferloaddaywiseplan(deleteid){
$('#daywiseplan').load('daywiseplan.php?stype=transfer&id=<?php echo ($resultpage['id']); ?>&deleteid='+deleteid);
}

function deleteextraloaddaywiseplan(deleteid){
$('#daywiseplan').load('daywiseplan.php?stype=extra&id=<?php echo ($resultpage['id']); ?>&deleteid='+deleteid);
}

function deletesightseeingloaddaywiseplan(deleteid){
$('#daywiseplan').load('daywiseplan.php?stype=sightseeing&id=<?php echo ($resultpage['id']); ?>&deleteid='+deleteid);
}


function deleteflightloaddaywiseplan(deleteid){
$('#daywiseplan').load('daywiseplan.php?stype=flight&id=<?php echo ($resultpage['id']); ?>&deleteid='+deleteid);
}

function deletehotelloaddaywiseplan(deleteid){
$('#daywiseplan').load('daywiseplan.php?stype=hotel&id=<?php echo ($resultpage['id']); ?>&deleteid='+deleteid);
}



</script>

<?php } ?>

<?php if($_REQUEST['tab']==3 || $_REQUEST['tab']==4 || $_REQUEST['tab']==5 || $_REQUEST['tab']==6){?>
<script src="tinymce/tinymce.min.js"></script>
<div class="addeditpagebox" id="daywiseplanother" style="position:static; padding: 20px; background-color: #fff;">
Loading...
</div>
<script>
function loadotherItinerary(tab){
$('#daywiseplanother').load('loadotheritinerary.php?id=<?php echo ($resultpage['id']); ?>&tab='+tab)
}
loadotherItinerary('<?php echo $_REQUEST['tab']; ?>');



function emailloadotherItinerary(tab){

var emailTemplateId = $('#emailTemplateId').val();
$('#daywiseplanother').text('Wait Please...');
$('#daywiseplanother').load('loadotheritinerary.php?id=<?php echo ($resultpage['id']); ?>&tab='+tab+'&emailTemplateId='+emailTemplateId)
}
</script>
<?php } ?>
</div></td>
  </tr>
</table>

<div style="display:none;" id="changequerystatusdiv"></div>
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
 
 