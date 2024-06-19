<?php
if($_REQUEST['page']==''){?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<!--<form id="listform" name="listform" method="get">-->
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Driver','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td> 
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><a href="showpage.crm?module=employeemanagement&page=add"><div class="bluembutton">+ Add New <?php echo $pageName; ?></div></a></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deleteemployeemanagement" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
     <th align="left" class="header" >Name </th>
     <th align="left" class="header" >Employee Id </th>
	 <th  align="center" class="header" >Mobile No.</th>
	 <th  align="left" class="header" >Email</th>
	 <th  align="left" class="header" >Joining Date </th>
	 <th  align="left" class="header" >D.O.B.</th>
	 <th  align="left" class="header" >Address</th>
	 <th  align="left" class="header" >Edit</th>
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
 
$where='where name!="" and deletestatus=0 order by name ';
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_EMPLOYEE_MANAGEMENT_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
//$modifyDate=clean($resultlists['modifyDate']);

?>
  <tr>
    <td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
    <td width="6%" align="left"><a href="showpage.crm?module=employeemanagement&view=yes&id=<?php echo encode($resultlists['id']); ?>"><?php echo $resultlists['name']; ?></a>   </td>
	<td width="9%" align="center"><?php echo $resultlists['empId']; ?></td>
	<td width="9%" align="center"><?php echo $resultlists['mobile']; ?></td>
	<td width="8%" align="left"><?php echo $resultlists['email']; ?></td>
	<td width="8%" align="left"><?php echo $resultlists['joiningDate']; ?></td>
	<td width="10%" align="left"><?php echo $resultlists['birthDate']; ?></td>
	<td width="12%" align="left"><?php echo $resultlists['address']; ?></td>
	<td width="5%" align="left"><a href="showpage.crm?module=employeemanagement&page=add&id=<?php echo encode($resultlists['id']); ?>">
	  <input name="addnewuserbtn" type="button" class="bluembutton" value="Edit"/></a></td>
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
</script><?php }?>
<?php if($_REQUEST['page']=='add'){include('add_crm_employeemanagement.php');}?>
<?php if($_REQUEST['page']=='view'){include('view_crm_employeemanagement.php');}?>
