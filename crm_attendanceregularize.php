<?php
$searchField=clean($_GET['searchField']);
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
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Company','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="searchField" type="text" value="<?php echo $searchField; ?>"  class="topsearchfiledmain" id="searchField" placeholder="Enter Employee Name"/></td>
   
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        
  </tr>
</table>

		</td>
        <?php if($addpermission==1){ ?><td  >
		<!--<input name="addnewuserbtn" type="button" class="bluembutton" id="importbutton" value="Bulk Attandance"  /></td><td style="padding-right:20px;"></td> <?php } ?>-->
		<?php if($addpermission==1){ ?><td style="padding-right:20px;">
		<input name="addnewuserbtn" type="button" class="bluembutton" id="importbutton" value="+ Add Bulk Attendance" 
		onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="suppliersdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th align="left" class="header" >Employee Id</th>
      <th align="left" class="header" >Name</th>
      <th align="left" class="header" >Email </th>
     <th align="left" class="header">Date</th>
     <th align="left" class="header">Time From </th>
	 <th align="left" class="header">Time To</th>
     <th align="left" class="header">	Total Time</th>
     
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

$mainwhere='';
if($searchField!=''){
$mainwhere=' and ( empIs like "%'.$searchField.'%" ) ) ';
}

 

 
   
  
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 

}
 
 
 
$where='where '.$wheresearch.' and empId!="" and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];

$targetpage=$fullurl.'showpage.crm?module=attendanceregularize&records='.$limit.'&searchField='.$searchField.'';
$rs=GetRecordList($select,_ATTANDANCE_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){

  
$selecte='*';    
$wheree='empId='.$resultlists['empId'].'';  
$rs1e=GetPageRecord($selecte,_EMPLOYEE_MANAGEMENT_MASTER_,$wheree); 
$resultlists1=mysqli_fetch_array($rs1e);
?>
  <tr>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');" style="font-weight:500; color:#45b558 !important;"><?php echo strip($resultlists['empId']); ?> </div></td>
    <td align="left"><?php echo strip($resultlists1['name']); ?></td>
    <td align="left"><?php echo strip($resultlists1['email']); ?></td>
    <td align="left"><?php echo strip($resultlists['currentDate']); ?></td>
    <td align="left"><?php echo strip($resultlists['timeFrom']); ?></td>
    <td align="left"><?php echo strip($resultlists['timeTo']); ?></td>
    </tr> 
	
<?php $no++;  }?>
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