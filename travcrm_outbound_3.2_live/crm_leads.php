<?php
$searchField=clean($_GET['searchField']);
$searchFieldcommon=clean($_GET['searchFieldcommon']);



if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

$wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 
?>


<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
  <form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
        
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
  <div id="deactivatebtn" style="display:none;">
   <?php if($deletepermission==1){ ?> 
  
  <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Lead','600px','auto');" />
  <?php } ?>
  </div>
  
  </div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
         <td >
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td> </td>
      <td style="padding:0px 0px 0px 5px;" ><input name="searchFieldcommon" type="text"  class="topsearchfiledmain" id="searchFieldcommon" style="width:150px;" value="<?php echo $searchFieldcommon; ?>" size="100" maxlength="100" placeholder="Company, Subject"  /></td>
    
   
      
       
    <td style="padding:0px 0px 0px 5px;" > 
          <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">Sales Persons</option>
       <?php 
        $select2='*';    
        $where2=' '.$wheresearchassign.' group by assignTo';  
        $rs2=GetPageRecord($select2,'leadManageMaster',$where2); 
        while($resListing2=mysqli_fetch_array($rs2)){ 


        $select='*';    
        $where=' id='.$resListing2['assignTo'].' order by firstName asc';  
        $rs=GetPageRecord($select,_USER_MASTER_,$where); 
        while($resListing=mysqli_fetch_array($rs)){ 

?>
      <option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
      <?php } } ?>
          </select> </td>
      
        
      
      
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
         
  </tr>
</table>

    </td>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="add();" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

</form>

<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:10px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="leaddelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
      <th align="center" valign="middle" class="header" >#&nbsp;</th>
      <th align="left" class="header">Lead Source</th>
      <th align="left" class="header">Meeting Agenda</th>
      <th align="left" class="header">Client Name</th>
      <th align="left" class="header" >Sales Person </th>
      <th align="left" class="header">Start&nbsp;Date</th>
      <th align="left" class="header">Start&nbsp;Time</th>
      <th align="left" class="header">Next Follow Up</th>
      <th align="left" class="header">Meeting&nbsp;Outcome </th> 
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
  $assignto=' and assignTo='.$_GET['assignto'].'';
  }


  $destination='';
  if($_GET['destination']!=''){
  $destination=' and  destinationId='.clean($_GET['destination']).'';
  } 

  $priority='';
  if($_GET['priority']!=''){
  $priority=' and queryPriority='.clean($_GET['priority']).'';
  } 

  $querystatus='';
  if($_GET['querystatus']!=''){
  $querystatus=' and  queryStatus='.clean($_GET['querystatus']).'';
  } 



  $searchFieldcommonquery='';
  if($searchFieldcommon!=''){
  $searchFieldcommonquery=' and (subject like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%"))';
  } 


  $where='where '.$wheresearchassign.'  '.$assignto.' '.$mainwhere.' '.$destination.' '.$priority.' '.$querystatus.' '.$searchFieldcommonquery.' and deletestatus=0 and leadsource!=0 order by dateAdded desc'; 
  $page=$_GET['page'];

  $targetpage=$fullurl.'showpage.crm?module=leads&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
  $rs=GetRecordList($select,'leadManageMaster',$where,$limit,$page,$targetpage); 
  $totalentry=$rs[1]; 
  $paging=$rs[2]; 
  while($resultlists=mysqli_fetch_array($rs[0])){ 
  ?>
  <tr>
  <td align="center" valign="middle" style="padding:0px;"><?php if($editpermission==1){ ?>
  <div style="width:30px;"><img src="images/editicon.png" class="editicon" onclick="edit('<?php echo encode($resultlists['id']); ?>');" /></div><?php }   ?></td>
  <td align="left"><div style="max-width:200px;" class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');">
  <?php
  $where='id="'.$resultlists['leadsource'].'" and deletestatus=0 and status=1';
  $leadData=GetPageRecord('name',_LEADSSOURCE_MASTER_,$where);
  $leadDataResult=mysqli_fetch_assoc($leadData);
  echo $leadDataResult['name'];
  ?>
  </div></td>
  <td align="left"><?php echo $resultlists['subject'] ?></td>
  <td align="left"><?php echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); ?></td>
  <td align="left" ><?php echo getUserName($resultlists['assignTo']); ?></td>
  <td align="left"><?php echo showdate($resultlists['fromDate']); ?></td>
  <td align="left"><?php echo date('h:i A',strtotime($resultlists['starttime'])); ?></td>
  <td align="left"><?php echo date('d-m-Y h:i A',strtotime($resultlists['followupdate']." ".$resultlists['followuptime'] )); ?></td>
  <td align="left"><?php
  if($resultlists['directiontype']!=''){
  $select12='*';  
  $where12='id='.$resultlists['directiontype'].''; 
  $rs12=GetPageRecord($select12,_MEETINGS_OUTCOME_,$where12); 
  $calltype=mysqli_fetch_array($rs12); 
  echo $calltype['name'];
  }
  ?>
  </td>
  </tr> 
  <?php $no++; } ?>
</tbody>
</table>
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
  </tbody>
  </table>
</div>
</div></form> </td>
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