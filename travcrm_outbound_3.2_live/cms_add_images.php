<?php $pageName='MANAGE PHOTO'; 
$cid=$_REQUEST['cid'];
$id=$_REQUEST['id'];
if(isset($_REQUEST['action']) && $_REQUEST['action']=="del"){
$id=$_REQUEST['id'];
	$sql_del="delete from  "._POST_LIST_MASTER_."  where id='".$_REQUEST['id']."'";
	mysqli_query($sql_del) or die(mysqli_error(db()));
	header("location:?module=cms&page=".$_REQUEST['page']."&cid=".$_REQUEST['cid']."&alt=2");	
}

//----change status-----
if($_REQUEST['status']!=""){
	$id=$_REQUEST['id'];
	$status=$_REQUEST['status'];
	$sql_ins="update "._POST_LIST_MASTER_." set status='$status' where id = ".$id."";
	mysqli_query($sql_ins) or die(mysqli_error(db()));
}
?>
<script>
function cmd_del(){
var x= confirm("Do you want to delete this record?.");
if(x)
return true;
else 
return false;
}
</script>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><a href="showpage.crm?module=cms&page=gallery"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="cms_alertspopupopen('action=mastersdelete&name=Destination','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="cms_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&page=<?php echo clean($_GET['page']); ?>&cid=<?php echo clean($_GET['cid']); ?>','500px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="cms_gallery" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >Image Title </th>
	 <th  align="left" class="header" >Image</th>
	 <th  align="center" class="header" >Status</th>
	 <th  align="center" class="header" >Delete</th>
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
 
$where='where category='.$cid.' order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_POST_LIST_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);

?>
  <tr>
    <td width="17%" align="left"><?php echo $resultlists['title']; ?></td>
	
	<td width="66%" align="left"><?php if($resultlists['feature_img']!=''){ ?><img src="<?php echo $fullurl; ?>upload/<?php echo $resultlists['feature_img']; ?>" height="100" /><?php }else{ }  ?></td>
	<td width="9%" align="center"><?php if($resultlists['status']==1){ ?>
        <a href="showpage.crm?module=cms&amp;page=<?php echo $_REQUEST['page'];?>&amp;status=0&amp;id=<?php echo $resultlists['id']; ?>&amp;cid=<?php echo $resultlists['category']; ?>"> <img src="images/unlock.png" width="30" border="0" /> </a>
        <?php } else { ?>
        <a href="showpage.crm?module=cms&amp;page=<?php echo $_REQUEST['page'];?>&amp;status=1&amp;id=<?php echo $resultlists['id']; ?>&amp;cid=<?php echo $resultlists['category']; ?>"> <img src="images/lock.png" /> </a>
        <?php } ?>    </td>
	<td width="8%" align="center"><a href="?module=cms&amp;page=<?php echo $_REQUEST['page'];?>&amp;id=<?php echo $resultlists['id']; ?>&amp;cid=<?php echo $resultlists['category']; ?>&amp;action=del" onclick="return cmd_del()"> <img src="images/dlt.png" alt="Edit" width="30" height="32" border="0" /> </a></td>
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