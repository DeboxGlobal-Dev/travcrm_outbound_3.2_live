<link href="css/main.css" rel="stylesheet" type="text/css" />

<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?>
	<?php if($_GET['activeinactiveuser']==0 && $_GET['activeinactiveuser']!=''){ ?>
	<input name="activate" type="button" class="greenmbutton" id="activate" value="Activate" onclick="alertspopupopen('action=useractivate','600px','auto');" />
	<?php } else { ?>
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="alertspopupopen('action=userdeactivate','600px','auto');" />
	<?php }  } ?>
	
	
	<!--<input name="deactivate" type="button" class="deletembutton" id="deactivate" value="Delete this User" />-->
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><select name="activeinactiveuser" class="topdropdown" id="activeinactiveuser" onchange="submitfieldfrm('listform');"> 
          <option value="1" <?php if($_GET['activeinactiveuser']=='1'){  echo 'selected'; }  ?>>Active Users</option>
          <option value="0" <?php if($_GET['activeinactiveuser']=='0'){  echo 'selected'; } ?>>Inactive Users</option> 
        </select>
        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New User" onclick="add();" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
    <?php if($editpermission==1){ ?> <th width="37" align="center" class="header" style="padding-left:0px;padding-tight:0px;">&nbsp;</th><?php } ?>

   <?php if($deletepermission==1){ ?>  <th width="48" align="center" valign="middle" class="header" ><input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" />
    <label for="checkAll"><span></span>&nbsp;</label></th> <?php } ?>
     <th width="137" align="left" class="header" >User ID</th>

    <th width="166" align="left" class="header sortingbg">Company Name </th>

    <th width="184" align="center" class="header sortingbg">Users Limit</th>
    <th width="143" align="center" class="header sortingbg">Server&nbsp;Space</th>
    <th width="145" align="center" class="header sortingbg">Status</th>
    <th width="145" align="left" class="header sortingbg">expiry&nbsp;date</th>

    <th width="153" align="left" class="header sortingbg">created By </th>

    <th width="70" align="left" class="header" style="width:50px;">&nbsp;</th>
    </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch='';
$activeinactiveuser='';
$limit=clean($_GET['records']);
if($activeinactiveuser==''){
 $activeinactiveuser=1;
}

if($_GET['activeinactiveuser']!=''){ 
$activeinactiveuser=$_GET['activeinactiveuser'];

if($activeinactiveuser==0 || $activeinactiveuser==1){
$wheresearch=' and status='.$activeinactiveuser.'';
}

if($activeinactiveuser==2){
$wheresearch=' and deletestatus=1';
}

} else {
$wheresearch=' and status=1';
}

if($loginuserID==1){
$where='where admin=1 and id!=1 '.$wheresearch.' order by dateAdded desc';  
} else {
$where='where parentId='.$loginuserID.' and admin=1 '.$wheresearch.' order by dateAdded desc'; 
}
 $page=$_GET['page'];
$targetpage=$fullurl.'setupsetting.crm?module=crmmasters&records='.$limit.'&activeinactiveuser='.$activeinactiveuser.'&'; 
$rs=GetRecordList($select,_USER_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
   <?php if($editpermission==1){ ?> <td align="center" style="padding-left:0px;padding-right:0px;"><div style="width:30px;"><img src="images/editicon.png" class="editicon" onclick="edit('<?php echo encode($resultlists['id']); ?>');" /></div></td>
   <?php } ?>

   <?php if($deletepermission==1){ ?><td align="center" valign="middle"><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label></td><?php } ?>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo strip($resultlists['accountId']); ?></div></td>

    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo strip($resultlists['company']); ?></div></td>

    <td align="center"><?php echo strip($resultlists['noofusers']); ?></td>
    <td align="center"><?php echo strip($resultlists['serverspace']); ?> MB </td>
    <td align="center"><?php if($resultlists['status']==1){ ?><div class="statusactive">Active</div><?php } else { ?>
      <div class="statusdeactive">Inactive</div><?php } ?></td>
    <td align="left"><?php if($resultlists['expiryDate']<date('Y-m-d') || $resultlists['expiryDate']==date('Y-m-d')){ ?><div class="statusdeactive">Expired</div><?php } else { echo showdate($resultlists['expiryDate']); } ?></td>

    <td align="left">
	<?php 
  
$selectaa='firstName,lastName';   
$whereaa='id="'.$resultlists['parentId'].'"'; 
$rsaa=GetPageRecord($selectaa,_USER_MASTER_,$whereaa); 
while($userss=mysqli_fetch_array($rsaa)){  

echo $userss['firstName'].' '.$userss['lastName'];

}
?>
	<div style="margin-top:5px; font-size:12px;"><?php echo showdatenormal($resultlists['dateAdded']) ?></div></td>

    <td align="left"style="width:50px;">&nbsp;</td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php if($_GET['activeinactiveuser']==0 && $_GET['activeinactiveuser']!=''){ echo 'Inactivate'; } else { echo 'Active'; } ?> Users</div>
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
  
</table>
</td>

    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>

  </tr>

</tbody></table>



	</div>
</div></form>
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




comtabopenclose('linkbox','op4');
</script>