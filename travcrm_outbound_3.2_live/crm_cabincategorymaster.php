<?php include 'tableSorting.php'; ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="7%">
    <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>
              </td>

    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Cabin-Type','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deletecabincategory" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
      <th width="5%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
     <th align="left" class="header" >Name </th>
     <th align="center" class="header" >Status </th>
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
  
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].')';  
 
$where='where name!="" order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_CABIN_CATEGORY_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);

?>
  <tr>
    <td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
    <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $resultlists['name']; ?></div>  </td>

    <td width="15%" align="center"><?php if ($resultlists['status'] == 1) { ?><div style=" width: fit-content; color: green; "><?php echo 'Active'; ?></div><?php } else { ?><div style=" width: fit-content; color: red; "><?php echo 'In Active'; ?></div><?php }  ?>

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
  window.setInterval(function() {

checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

checked = $('#listform td input[type=checkbox]:checked').length;

//alert(checked);

if (!checked) {

  $("#deactivatebtn").hide();

  $("#topheadingmain").show();

} else {

  $("#deactivatebtn").show();

  $("#topheadingmain").hide();

}

}, 100);

comtabopenclose('linkbox','op2');
</script>