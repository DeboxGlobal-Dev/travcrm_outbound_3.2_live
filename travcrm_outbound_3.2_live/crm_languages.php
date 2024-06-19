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
        <td> 
        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"> </td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Language" onclick="add();" /></td> <?php } ?>
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
    <?php if($editpermission==1){ ?> <th width="52" align="center" class="header" style="padding-left:0px;padding-tight:0px;">&nbsp;</th><?php } ?>

   <?php if($deletepermission==1){ ?>  <?php } ?>
     <th width="887" align="left" class="header" >Language</th>

    <th width="224" align="center" class="header sortingbg">Status</th>
    <th width="193" align="left" class="header sortingbg">created By </th>
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
 
$where='';
 $page=$_GET['page'];
$targetpage=$fullurl.'setupsetting.crm?module=languages&records='.$limit.'&activeinactiveuser='.$activeinactiveuser.'&'; 
$rs=GetRecordList($select,'languageMaster',$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
   <?php if($editpermission==1){ ?> <td align="center" style="padding-left:0px;padding-right:0px;"><div style="width:30px;"><img src="images/editicon.png" class="editicon" onclick="edit('<?php echo encode($resultlists['id']); ?>');" /></div></td>
   <?php } ?>

   <?php if($deletepermission==1){ ?><?php } ?>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo strip($resultlists['name']); ?></div></td>

    <td align="center"><?php if($resultlists['status']=='1'){ ?><div class="statusactive">Active</div><?php } else { ?>
      <div class="statusdeactive">Inactive</div><?php } ?></td>
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