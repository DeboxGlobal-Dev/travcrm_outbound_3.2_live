<link href="css/main.css" rel="stylesheet" type="text/css" />

<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?>
	<?php if($_GET['useractiveinactiveuser']==0 && $_GET['useractiveinactiveuser']!=''){ ?>
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
         
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Template" onclick="add();" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="disableuser" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th width="27" align="left" class="header" >&nbsp;</th>
      <?php if($editpermission==1){ ?>  <?php } ?>
     <th width="724" align="left" class="header" >Subject </th>

     <th width="184" align="left" class="header">Created&nbsp;By </th>
     <th width="179" align="left" class="header">Modified&nbsp;By</th>
     <th width="72" align="center" class="header" style="width:50px;">&nbsp;</th>
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
 
$where='where deletestatus=0 and  userId='.$loginusersuperParentId.' order by id desc';   
 $page=$_GET['page'];
$targetpage=$fullurl.'setupsetting.crm?module=emailtemplates&records='.$limit.'&'; 
$rs=GetRecordList($select,_EMAIL_TEMPLATE_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 


?>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><div class="bluelink"<?php if($editpermission==1){ ?>onclick="edit('<?php echo encode($resultlists['id']); ?>');"<?php }  ?> ><?php echo strip($resultlists['subject']); ?></div></td>

    <td align="left" valign="top"> <?php 
  
$selectaa='firstName,lastName';   
$whereaa='id="'.$resultlists['addedBy'].'"'; 
$rsaa=GetPageRecord($selectaa,_USER_MASTER_,$whereaa); 
while($userss=mysqli_fetch_array($rsaa)){  

echo $userss['firstName'].' '.$userss['lastName'];

 
?>
	<div style="margin-top:0px; font-size:11px; color:#666666;"><?php echo showdatenormal($resultlists['dateAdded'],$loginusertimeFormat); ?></div><?php } ?></td>
    <td align="left" valign="top"><?php 
  
$selectaa='firstName,lastName';   
$whereaa='id="'.$resultlists['modifyBy'].'"'; 
$rsaa=GetPageRecord($selectaa,_USER_MASTER_,$whereaa); 
while($userss=mysqli_fetch_array($rsaa)){  

echo $userss['firstName'].' '.$userss['lastName'];


?>
	<div style="margin-top:0px; font-size:11px; color:#666666;"><?php if($resultlists['modifyDate']!='0'){ echo showdatenormal($resultlists['modifyDate'],$loginusertimeFormat); } ?></div><?php } ?></td>
    <td align="center" valign="top"style="width:50px;"><?php if($editpermission==1){ ?>
    <?php if($deletepermission==1){ ?>  <a class="redtextc" onclick="$('#dids').val('<?php echo encode($resultlists['id']); ?>');alertspopupopen('action=deleteemailtemplate','600px','auto');" >Delete</a><?php } ?>      <?php } ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No Email Templates </div>
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
            <input name="dids" type="hidden" id="dids" value="<?php echo encode($resultlists['id']); ?>" /></td>

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




comtabopenclose('linkbox','op3');
</script>