<?php $pageName='MANAGE WISHLIST'; 
 
//----Delete Post-----
if(isset($_REQUEST['action']) && $_REQUEST['action']=="del"){
$user_id=$_REQUEST['user_id'];
$id=$_REQUEST['id'];
	$sql_del="delete from  "._WISHLIST_MASTER_."  where id='".$_REQUEST['id']."'";
	mysqli_query($sql_del) or die(mysqli_error(db()));
	header("location:?module=cms&page=users-wishlist&user_id=".$user_id."&id=".$id."&alt=2");	
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
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><a href="showpage.crm?module=cms&page=users"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Destination','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?>
        <td style="padding-right:20px;" >&nbsp;</td>
        <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="banner" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
     <tr>
        <th align="left" class="header" >Sr. No.</th>
        <th align="left" class="header" >User Name</th>
        <th  align="left" class="header" >Package Name</th>
        <th  align="left" class="header" >Added On</th>
        <th  align="center" class="header" >Delete</th>
  	 </tr>
  </thead>
  <tbody>
  <?php
  $type='add_wishlist';
  $user_id=$_REQUEST['user_id'];
  $no=1; 
  $select='*'; 
  $where=''; 
  $rs='';  
  $wheresearch=''; 
  $limit=clean($_GET['records']);
   
  $where='where action="'.$type.'" and user_id="'.$user_id.'" order by user_id asc'; 
  $page=$_GET['page'];

  $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
  $rs=GetRecordList($select,_WISHLIST_MASTER_,$where,$limit,$page,$targetpage); 
  $totalentry=$rs[1]; 
  $paging=$rs[2]; 
  while($resultlists=mysqli_fetch_array($rs[0])){ 
  ?>
  <tr>
    <td width="7%" align="left"><span class="graylist"><?php echo ++$start; ?></span></td>
    <td width="13%" align="left"><?php  echo get_cms_user_name($resultlists['user_id']); ?></td>
	  <td width="20%" align="left">
      <span class="graylist">
  	    <?php  echo get_package_name($resultlists['item_id']); ?>
  	  </span>
    </td>
	<td width="13%" align="left"><span class="graylist">
	  <?php  $time = ($resultlists['createdOn'] == 0)? time() : $resultlists['createdOn'] ; echo date("j M Y", $time); ?>
	</span></td>
	<td width="7%" align="center"><a href="showpage.crm?module=cms&page=users-wishlist&user_id=<?php echo $_REQUEST['user_id'];?>&id=<?php echo $resultlists['id']; ?>&action=del" onclick="return cmd_del()">
          		<img src="images/dlt.png" alt="Edit" width="30" height="32" border="0" />
          	</a></td>
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
    <td>
        <select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
          <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
          <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
          <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
          <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
          <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
        </select>
      </td>
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