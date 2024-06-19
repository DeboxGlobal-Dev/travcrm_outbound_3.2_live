<?php
$searchField=clean($_GET['searchField']);
$searchFieldcommon=clean($_GET['searchFieldcommon']);
?>


<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Query','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
         <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>
      <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        <td ><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Create Itinerary" onclick="alertspopupopen('action=itineraryqueryid','400px','auto');"></td>
        <td style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>		</td>
        <?php if($addpermission==1){ ?><?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

</form>

<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="querydelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th width="13%" align="left" class="header" >Query ID </th>
     <th width="19%" align="left" class="header">Client</th>
     <th width="38%" align="left" class="header">Subject</th>
     <th width="19%" align="left" class="header"> Query Date </th>
     <th width="11%" align="center" class="header">	action </th>
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

$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';
if($searchField!=''){
$mainwhere=' and  id='.$searchField.'';
}

$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
 
$destination='';
if($_GET['destination']!=''){
$destination=' and	destinationId='.clean($_GET['destination']).'';
} 
 
$priority='';
if($_GET['priority']!=''){
$priority=' and	queryPriority='.clean($_GET['priority']).'';
} 

$querystatus='';
if($_GET['querystatus']!=''){
$querystatus=' and	queryStatus='.clean($_GET['querystatus']).'';
} 

  
 
$searchFieldcommonquery='';
if($searchFieldcommon!=''){
$searchFieldcommonquery=' and (subject like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%"))';
} 
 
 
   
 
 
   
 if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.' '.$searchFieldcommonquery.''; 
} else {
 $wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in (select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].')  ) '.$searchFieldcommonquery.''; 
}
 
  
 
$where='where '.$wheresearch.'  '.$assignto.' '.$mainwhere.' '.$destination.' '.$priority.' '.$querystatus.' and deletestatus=0 and id in (select queryId from '._ITINERARY_MASTER_.') order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=itinerary&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,_QUERY_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="left"><div class="bluelink"  onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo makeQueryId($resultlists['id']); ?>
 
	</div>   </td>
    <td width="19%" align="left"><?php echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); ?></td>
    <td width="38%" align="left"><div  class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo clean($resultlists['subject']); ?></div></td>
    <td align="left"><?php echo showdate($resultlists['queryDate']); ?></td>
 <td align="center" > <div style="width:132px;">
<div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=senditinearyemail&queryId=<?php echo $resultlists['id']; ?>','600px','auto');"><img src="images/emailiconsmall.png"  /></div>
	<a href="itinerarypdf.php?id=<?php echo encode($resultlists['id']); ?>&print=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>
	
	<a href="day-wise-plan.crm?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></div>
	
	
	</td>
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
</div></form>	</td>
  </tr>
</table>

<script> 
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
</script>