<link href="css/main.css" rel="stylesheet" type="text/css" />

<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?>
	<?php if($_GET['useractiveinactiveuser']==0 && $_GET['useractiveinactiveuser']!=''){ 
		
		echo $Logintimeuserzone['noofusers'];
	
	?>
	<input name="activate" type="button" class="greenmbutton" id="activate" value="Activate" onclick="alertspopupopen('action=useractivate','600px','auto');" />
	<?php } else { ?>
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="alertspopupopen('action=userdeactivate','600px','auto');" />
	<?php }  }
	
	$ccc="select id from "._USER_MASTER_." where  superParentId=".$loginusersuperParentId."  and status=1 ";
$ddd = mysqli_query(db(),$ccc);
$dataUser=mysqli_fetch_array($ddd);
$totaluserscreated=mysqli_num_rows($ddd);

$cccin="select id from "._USER_MASTER_." where  superParentId=".$loginusersuperParentId."  and status=0 ";
$dddss = mysqli_query(db(),$cccin);
$totalusersInactive=mysqli_num_rows($dddss);
	 ?>
	
	
	<!--<input name="deactivate" type="button" class="deletembutton" id="deactivate" value="Delete this User" />-->
	</div>
	
	</div></td>
    <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 14px; border: 1px solid #e2e2e2;">
      <tr>
        <td width="33%" align="center" style="border-right: 1px solid #e2e2e2;"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Total Licence <?php echo $Logintimeuserzone['noofusers']; ?>  </td>
        <td width="33%" align="center" style="border-right: 1px solid #e2e2e2; color: #1dc131;">Active Users <?php echo $totaluserscreated; ?>&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" style="color: #1dc131;"></i></td>
        <td width="33%" align="center" style="color:#ff0a0a;">Inactive Users <?php echo $totalusersInactive; ?>&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" style="color: #ff0a0a;"></i></td>
      </tr>
    </table></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><select name="useractiveinactiveuser" class="topdropdown" id="useractiveinactiveuser" onchange="submitfieldfrm('listform');"> 
          <option value="1" <?php if($_GET['useractiveinactiveuser']=='1'){  echo 'selected'; }  ?>>Active Users</option>
          <option value="0" <?php if($_GET['useractiveinactiveuser']=='0'){  echo 'selected'; } ?>>Inactive Users</option> 
        </select>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New User" onclick="add();" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="disableuser" id="action" />
<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="59" align="center" class="header" style="padding-left:0px;padding-tight:0px;">&nbsp;</th> 

    <th width="79" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
    <!-- <th width="52" align="center" class="header" >Sr No</th>--->
     <th width="247" align="left" class="header" >User Code</th>
     <th width="247" align="left" class="header" >User Name </th>
     <th width="247" align="left" class="header" >Office Name </th>
     <th width="168" align="left" class="header sortingbg">Email Address </th>
     <th width="166" align="left" class="header sortingbg">Role</th>
     <th width="172" align="left" class="header sortingbg">UserType</th>
     <th width="172" align="left" class="header sortingbg">Profile</th>
     <!-- <th width="172" align="left" class="header sortingbg">Department</th> -->
     <th width="172" align="left" class="header sortingbg">Reporting Manager</th>
     <th width="170" align="center" class="header sortingbg">Status</th>
    <th width="73" align="left" class="header" style="width:50px;">&nbsp;</th>
    </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch='';
$useractiveinactiveuser='';
$limit=clean($_GET['records']);
if($useractiveinactiveuser==''){
 $useractiveinactiveuser=1;
}

if($_GET['useractiveinactiveuser']!=''){ 
$useractiveinactiveuser=$_GET['useractiveinactiveuser'];

if($useractiveinactiveuser==0 || $useractiveinactiveuser==1){
$wheresearch=' and status='.$useractiveinactiveuser.'';
}

if($useractiveinactiveuser==2){
$wheresearch=' and deletestatus=1';
}

} else {
$wheresearch=' and status=1';
}

 
$where='where admin!=1 and superParentId='.$loginusersuperParentId.' and id!='.$loginuserID.' '.$wheresearch.'   order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'setupsetting.crm?module=users&records='.$limit.'&useractiveinactiveuser='.$useractiveinactiveuser.'&'; 
$rs=GetRecordList($select,_USER_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
      
 
  $rse=GetPageRecord('*','officeBranches','id="'.$resultlists['officeId'].'"'); 
  $officeDe=mysqli_fetch_array($rse)

?>
  <tr>
    <td align="center" style="padding-left:0px;padding-right:0px;"><?php if($editpermission==1){ ?><div style="width:30px;"><img src="images/editicon.png" class="editicon" onclick="edit('<?php echo encode($resultlists['id']); ?>');" /></div><?php } ?></td>
   

   <td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
   <!--- <td align="center"><div class="imgbox"><img src="<?php if($resultlists['profilePhoto']!=''){ ?>profilepic/<?php echo $resultlists['profilePhoto']; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>--->
    <td align="left"><?php echo $resultlists['usercode'];  ?></td>
   
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo strip($resultlists['firstName']); ?> <?php echo strip($resultlists['lastName']); ?></div></td>

    <td align="left"><div class="" ><?php echo strip($officeDe['name']); ?> </div></td>

    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo strip($resultlists['email']); ?></div></td>

    <td align="left"><?php 
$select1='name';  
$where1='id="'.$resultlists['roleId'].'"'; 
$rs1=GetPageRecord($select1,_ROLE_MASTER_,$where1); 
$res=mysqli_fetch_array($rs1);
echo strip($res['name']); 
?></td>
<td align="left">
      <?php if($resultlists['userType'] == '0'){ ?> Sales Person <?php } ?>
      <?php if($resultlists['userType'] == '1'){ ?> Operations Person <?php } ?>
      <?php if($resultlists['userType'] == '2'){ ?> Account Manager <?php } ?> 
      <?php if($resultlists['userType'] == '3'){ ?> Contracting Person <?php } ?> 
      <?php if($resultlists['userType'] == '4'){ ?> Reservation <?php } ?> 
      <?php if($resultlists['userType'] == '5'){ ?> Finance <?php } ?> 
</td>
<td align="left"><?php 
$select1='profileName';  
$where1='id="'.$resultlists['profileId'].'"'; 
$rs1=GetPageRecord($select1,_PROFILE_MASTER_,$where1); 
$res=mysqli_fetch_array($rs1);
echo strip($res['profileName']); 
?></td>
<!-- 
<td align="left"><?php 
$select1='department';  
$where1='id="'.$resultlists['departmentId'].'"'; 
$rs1=GetPageRecord($select1,'departmentMasters',$where1); 
$res=mysqli_fetch_array($rs1);
echo strip($res['department']); 
?></td> -->

<td align="left"><?php 
$select1='firstName,lastName';  

$where1='id="'.$resultlists['reportingManager'].'"'; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$res=mysqli_fetch_array($rs1);
echo strip($res['firstName'].' '.$res['lastName']); 

?></td>



    <td align="center"><?php if($resultlists['status']==1){ ?><div class="statusactive">Active</div><?php } else { ?>
      <div class="statusdeactive">Inactive</div><?php  }?></td>
    <td align="left"style="width:50px;">&nbsp;</td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php if($_GET['useractiveinactiveuser']==0 && $_GET['useractiveinactiveuser']!=''){ echo 'Inactivate'; } else { echo 'Active'; } ?> Users</div>
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




comtabopenclose('linkbox','op2');
</script>