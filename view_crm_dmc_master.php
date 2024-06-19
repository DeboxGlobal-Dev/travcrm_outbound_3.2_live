<?php
$searchField=clean($_GET['searchField']);
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">DMC <?php if(decode($_GET['id'])==1){ echo 'Hotel'; } if(decode($_GET['id'])==11){ echo 'Sightseeing'; } if(decode($_GET['id'])==0){ echo 'Transfer'; } ?> Master</span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Company','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<input name="id" id="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
	<input name="view" id="view" type="hidden" value="yes" />
	<input name="module" id="module" type="hidden" value="dmcmaster" />
	<input name="searchField" type="text" value="<?php echo $searchField; ?>"  class="topsearchfiledmain" id="searchField" placeholder="Enter Supplier, Contact, Email, Destination"/></td>
     <td style="padding:0px 0px 0px 5px; display:none;" > 
          <select name="suppliertype" id="suppliertype" class="topsearchfiledmainselect" style="width:160px; " >
		  
		  
            <option value="">All Supplier Type</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus!=1 order by name asc';  
$rs=GetPageRecord($select,_SUPPLIERS_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
			<option value="<?php echo $resListing['id']; ?>" <?php if(decode($_GET['id'])==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?></option>
			<?php } ?>
          </select> </td>
   
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        <td style="padding-left:10px;"><?php if(decode($_GET['id'])==1){ ?><input name="addnewuserbtn" type="button" class="bluembutton" id="importhotel" value="Import"  /><?php } ?><?php if(decode($_GET['id'])==11){ ?><input name="importsightseeing" type="button" class="bluembutton" id="importsightseeing" value="Import"  /><?php } ?><?php if(decode($_GET['id'])==0){ ?><input name="importtransfer" type="button" class="bluembutton" id="importtransfer" value="Import"  /><?php } ?></td>
        <td style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>

		</td>
        
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
<div id="loadhotelmaster">
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="suppliersdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="13%" align="left" class="header" >Supplier</th>

     <th width="17%" align="left" class="header">Contact&nbsp;Person</th>
     <th width="12%" align="left" class="header">Destination</th>
     <th width="13%" align="left" class="header">Located  </th>

     <th width="17%" align="left" class="header">Contact No.</th>
     <th width="12%" align="left" class="header"> Email Id</th>
     <th width="16%" align="left" class="header sortingbg" style="display:none;">assign To </th>
    </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);

$mainwhere='';
if($searchField!=''){
$mainwhere=' and ( name like "%'.$searchField.'%" or contactPerson like "%'.$searchField.'%" or id in (select masterId from  '._PHONE_MASTER_.' where phoneNo like "%'.$searchField.'%"  ) or id in  (select masterId from  '._EMAIL_MASTER_.' where email like "%'.$searchField.'%"  ) or cityId in  (select id from  '._CITY_MASTER_.' where name like "%'.$searchField.'%"  ) or stateId in  (select id from  '._STATE_MASTER_.' where name like "%'.$searchField.'%"  ) ) ';
}

$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
$suppliertype='';
if($_GET['suppliertype']!=''){
$assignto=' and	companyTypeId='.$_GET['suppliertype'].'';
}
 
   
 
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
  
if(decode($_GET['id'])==1){
$wheretypew=' companyTypeId=1 ';
}

if(decode($_GET['id'])==2){
$wheretypew=' sightseeingType=11 ';
}

if(decode($_GET['id'])==3){
$wheretypew=' transferType=10 ';
}

 
 
$where='where '.$wheretypew.' and  '.$wheresearch.' and name!="" '.$assignto.' and deletestatus=0 order by name desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=dmcmaster&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&view=yes&id='.$_GET['id'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 


/*$sql5="select * from ad_courses ";
$res5 = mysqli_query($sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
  <tr>
    <td align="left"><div class="bluelink" onclick="<?php if(decode($_GET['id'])==1){ echo 'funloadhotelmaster'; } if(decode($_GET['id'])==2){ echo 'funloadsightseeingmaster'; }  if(decode($_GET['id'])==3){ echo 'funloadtransportormaster'; } ?>('<?php echo $resultlists['id']; ?>');"><?php echo strip($resultlists['name']); ?> </div></td>

    <td align="left"><?php echo strip($resultlists['contactPerson']); ?></td>
    <td align="left"><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left"><?php echo getCityName($resultlists['cityId']); ?>, <?php echo getStateName($resultlists['stateId']); ?>, <?php echo getCountryName($resultlists['countryId']); ?></td>

    <td align="left"><?php echo getPrimaryPhone($resultlists['id'],'suppliers'); ?></td>
    <td align="left"><a href="mailto:<?php echo getPrimaryEmail($resultlists['id']); ?>"><?php echo getPrimaryEmail($resultlists['id'],'suppliers'); ?></a></td>
    <td align="left" style="display:none;"><?php echo getUserName($resultlists['assignTo']); ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>

<div class="pagingdiv">

		

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
    <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
                    <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
                    <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
                    <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
                    <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
                    <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
                  </select></td>
  </tr>
  
</table></td>

    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>

  </tr>
</tbody></table>
	</div>
</div></form>	
</div>

</td>
  </tr>
</table>

<script> 
function funloadhotelmaster(id){
$('#loadhotelmaster').load('loadhotelmaster.php?id='+id); 
}

function funafterloadaddrete(id,fromDate,toDate,roomType,mealPlan,currencyId){
$('#loadhotelmaster').load('loadhotelmaster.php?id='+id+'&fromDate='+fromDate+'&toDate='+toDate+'&roomType='+roomType+'&mealPlan='+mealPlan+'&currencyId='+currencyId); 
}




function funloadsightseeingmaster(id){
$('#loadhotelmaster').load('loadsightseeingmaster.php?id='+id); 
}

function funloadsightseeingmasteraddrate(id,fromDate,toDate,currencyId,sightseeingType){
$('#loadhotelmaster').load('loadsightseeingmaster.php?id='+id+'&fromDate='+fromDate+'&toDate='+toDate+'&currencyId='+currencyId+'&sightseeingType='+sightseeingType); 
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
</script>

 <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrmhotel" id="importfrmhotel"  target="actoinfrm" style="display:none;">
 <input name="importexcelhotel" id="importexcelhotel" type="hidden" value="Y" /> 
 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>
 </form>



 <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrmsightseeing" id="importfrmsightseeing"  target="actoinfrm" style="display:none;">
 <input name="importexcelsightseeing" id="importexcelsightseeing" type="hidden" value="Y" /> 
 <div id="filefieldhere"><input name="importfieldsightseeing" type="file" id="importfieldsightseeing" accept="application/vnd.ms-excel" onchange="submitimportfrom2();" /></div>
 </form>


 <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrmtransfer" id="importfrmtransfer"  target="actoinfrm" style="display:none;">
 <input name="importexceltransfer" id="importexceltransfer" type="hidden" value="Y" /> 
 <div id="filefieldhere"><input name="importfieldtransfer" type="file" id="importfieldtransfer" accept="application/vnd.ms-excel" onchange="submitimportfrom3();" /></div>
 </form>
