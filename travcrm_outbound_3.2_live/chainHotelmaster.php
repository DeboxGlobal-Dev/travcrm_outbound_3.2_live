<?php include 'tableSorting.php'; ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td> 
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo 'Hotel Chain' ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Hotel&nbsp;Chain&nbsp;Master','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td>
         <td style="boarder-radius:10%">
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>
    
        </select>
        </td>
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
        
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Hotel Chain" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','700px','auto');" /></td>  <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deleteHotelChain" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
      <th  align="left" class="header" >Sr.</th>
      <th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
       <label for="checkAll"><span></span>&nbsp;</label>
      </th> 
     <th align="left" class="header" >Hotel Chain Name </th>
	 <th align="left" class="header" >Location </th>
	 <th align="left" class="header" >Hotel Website</th>
	 <th align="left" class="header" >Self Supplier</th>
	 <th align="left" class="header" >Cont. Person</th>
	 <th  align="left" class="header" >Created By</th>
	 <th  align="left" class="header" >Modified By</th>
	 <th  align="left" class="header" >Status</th>
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

if($_GET['keyword']!=''){
$wheresearch="and name like '%".$_GET['keyword']."%'";}
if($_REQUEST['status']!=''){
	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
}

$where='where name!="" '.$wheresearch2.' '.$wheresearch.' and deletestatus=0 order by id desc'; 
$page=$_GET['page'];
 //hotelcategorytype is new table
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,'chainhotelmaster',$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);

?>
  <tr>
    <td width="2%"><?= $no ?></td>
    <td width="2%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
     <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
    </td>
    <td width="8%" align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','700px','auto');" ><?php echo $resultlists['name']; ?></div>   </td>
	
    <td width="8%" align="left"><div ><?php echo $resultlists['location']; ?></div>   </td>
	
    <td width="10%" align="left"><div  ><?php echo $resultlists['hotelwebsite']; ?></div>   </td>
	
    <td width="8%" align="left"><?php if($resultlists['selfsupplier']==1){?><div ><?php echo "Yes"; ?></div><?php } else { ?><div><?php echo "No";?></div>     <?php } ?>   </td>
	
    <td width="8%" align="left"><div><?php echo $resultlists['contactperson']; ?><br>
	<strong>Cont.&nbsp;No:&nbsp;</strong><?php echo $resultlists['phone']; ?><br>
	<strong>Email&nbsp;Id:&nbsp;</strong><?php echo $resultlists['email']; ?>
	
	
	
	
	
	</div>   </td>
	
	<td width="10%" align="left"><?php $select=''; 
$where2=''; 
$rs2='';  
$select2='firstName,lastName';   
$where2='id="'.$resultlists['addedBy'].'"'; 
$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
while($userss=mysqli_fetch_array($rs2)){  

echo $userss['firstName'].' '.$userss['lastName'];?>
<div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($dateAdded,$loginusertimeFormat);?></div>
<?php

}?></td>
	<td width="10%" align="left"><?php $select=''; 
$where2=''; 
$rs2='';  
$select2='firstName,lastName';   
$where2='id="'.$resultlists['modifyBy'].'"'; 
$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
while($userss=mysqli_fetch_array($rs2)){  
echo $userss['firstName'].' '.$userss['lastName'];?>
<div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($modifyDate,$loginusertimeFormat);?></div>
<?php

}?></td>
<!--<td width="15%" align="left"><?php if($resultlists['status']==1){?><div style="border: 1px solid #809b7b; width: fit-content; padding: 5px 15px; background-color: #809b7b; color: #fff; border-radius: 3px;"><?php echo 'Active';?></div><?php } else { ?><div style="border: 1px solid #809b7b; width: fit-content; padding: 5px 8px; background-color: red; color: #fff; border-radius: 3px;"><?php echo 'In Active';?></div><?php }  ?></td>-->
	<td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content;  color: green; "><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content; color: red; "><?php echo 'In Active';?></div><?php }  ?>
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
	window.setInterval(function(){ 
		  checked = $("#listform td input[type=checkbox]:checked").length;
		  
		  if(!checked) { 
		  $("#deactivatebtn").hide();
		  $("#topheadingmain").show();
		  } else {
		  $("#deactivatebtn").show();
		  $("#topheadingmain").hide();
		  } 
	}, 100);
	comtabopenclose('linkbox','op2');

	$(document).ready(function() {
     $('#mainsectiontable').DataTable( {
        "paging":   false,
        "ordering": true,
        "info":     true,
        "searching": false

    } );
} );
</script>