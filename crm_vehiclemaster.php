<?php include 'tableSorting.php'; ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td>
    <td width="61%"><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo 'Vehicle '//$pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Vehicle','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td width="39%" align="right"><table border="0" cellpadding="0" cellspacing="0">
		<tr>
		    <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Vehicle Name"></td>
		<td>
		<select name="brandName" id="brandName" class="topsearchfiledmain" style="width:180px;">
		<option value=''>Select&nbsp;Vehicle&nbsp;Brand</option>
		<?php 
		$rssss1=GetPageRecord('*',_VEHICLE_BRAND_MASTER_,'1 order by id asc'); 
		while($brandData=mysqli_fetch_array($rssss1)){
		?>
		<option value="<?php echo $brandData['id']; ?>" <?php if($_GET['brandName']==$brandData['id']){ ?> selected="selected" <?php } ?>><?php echo $brandData['name']; ?></option>
		<?php } ?>
		</select>
		</td>
		 <td>
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>InActive</option>
    
        </select>
        </td>
		<td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
		<td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo 'Vehicle';$pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td>  
		</tr>  
		</table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deletevehiclemaster" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
        <th width="2%" align="left" class="header">Sr.</th>
       
      <th width="46" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
	  <th width="100" align="center" class="header" ><span class="gridlable">Vehicle&nbsp;Type</span></th>
	  <th width="100" align="center" class="header" ><span class="gridlable">Brand&nbsp;Name<span class="redmind"></span></span></th>
	  <th width="100"  align="center" class="header" >Pax Capacity</th>
	  <th width="100"  align="center" class="header" ><span class="gridlable">Vehicle Name</span></th>
	 <th width="100"  align="center" class="header" >Vehicle Image</th>
	 <th width="100"  align="center" class="header" >Created By</th>
	 <th width="100"  align="center" class="header" >Modified By</th>
	 <th width="9%"  align="left" class="header" >Status</th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$wheresearch2='';
$limit=clean($_GET['records']);
  
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].')';  
 
if($_GET['keyword']!='')
 {
  $wheresearch="and model like '%".$_GET['keyword']."%'";
 }

 if($_GET['brandName']!=''){
 	$brandQuery = " and brand = '".clean(trim($_GET['brandName']))."'";
 }else{
 	$brandQuery = '';
 }
 
if($_GET['status']!='')
{
    $wheresearch2 = " and status ='".clean($_REQUEST['status'])."'";
} 
 
$where='where brand!="" '.$brandQuery.' '.$wheresearch2.' '.$wheresearch.' and deletestatus=0 order by id asc '; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_VEHICLE_MASTER_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);

$rssss=GetPageRecord('name',_VEHICLE_BRAND_MASTER_,' id="'.$resultlists['brand'].'" order by id asc'); 
$brand=mysqli_fetch_array($rssss);
 
 
 
?>
	<tr>
    <td width="2%"><?=$no?></td>  
    <td align="center" width="2%" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
    <td width="100" align="center"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&amp;sectiontype=<?php echo clean($_GET['module']); ?>&amp;id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo getVehicleTypeName($resultlists['carType']);  ?></div></td>
    <td width="100" align="center">
    	<div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $brand['name']; ?></div>
    </td>
		<td width="100" align="center"><?php echo $resultlists['capacity']; ?></td>
		<td width="100" align="center"><?php echo $resultlists['model']; ?></td>
		<td width="100" align="center"><?php if($resultlists['image']!=''){ ?><img src="<?php echo $fullurl; ?>packageimages/<?php echo $resultlists['image']; ?>" style="width: 150px;" alt="<?php echo $resultlists['name']; ?>" /> <?php } ?></td>
		<td width="100" align="center"><?php $select=''; 
			$where2=''; 
			$rs2='';  
			$select2='firstName,lastName';   
			$where2='id="'.$resultlists['addedBy'].'"'; 
			$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
			while($userss=mysqli_fetch_array($rs2)){  

			echo $userss['firstName'].' '.$userss['lastName'];?>
			<div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($dateAdded,$loginusertimeFormat);?></div>
			<?php } ?>
		</td>
		<td width="100" align="center"><?php $select=''; 
			$where2=''; 
			$rs2='';  
			$select2='firstName,lastName';   
			$where2='id="'.$resultlists['modifyBy'].'"'; 
			$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
			while($userss=mysqli_fetch_array($rs2)){  
			echo $userss['firstName'].' '.$userss['lastName'];?>
			<div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($modifyDate,$loginusertimeFormat);?></div>
			<?php } ?>
		</td>
   	<td width="5%" align="left">
   		<?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green;"><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content; padding: 5px 8px; color: red; "><?php echo 'In Active';?></div><?php }  ?>	
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
        "searching": false,
         "order": [[ 1, 'asc' ]]

    } );
} );
</script>