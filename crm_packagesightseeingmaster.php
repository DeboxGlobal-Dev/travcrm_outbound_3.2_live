<?php $statuswise = $_GET['statuswise']; ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['supplier']==''){
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
	   <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td>
	  
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
        <td  ><a href="<?php echo $fullurl; ?>travrmimports/sightseeing-import.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a></td>
		<td  ><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
		<td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td>  
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deleteextraquotation" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >&nbsp;</th>
      <th align="left" class="header" >Name </th>
	 <th  align="left" class="header" >Destination </th>
	 <th  align="left" class="header" >Detail</th>
	 <th  align="left" class="header" >Status</th>
	 <th  align="center" class="header" >Supplier</th>
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
 
$searchMain=1;

if($_GET['keyword']!=''){
$searchMain='sightseeingName like "%'.trim($_GET['keyword']).'%" or sightseeingCity like "%'.trim($_GET['keyword']).'%" or sightseeingDetail like "%'.trim($_GET['keyword']).'%"  '; 
}  

 

$where='where '.$searchMain.'  order by id desc'; 

//$where='where 1 order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 
$rs=GetRecordList($select,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);

?>
  <tr>
    <td align="left"><?php if($resultlists['sightseeingImage']!=''){ ?><img src="packageimages/<?php echo $resultlists['sightseeingImage']; ?>" width="75" height="58" /><?php } ?></td>
    <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $resultlists['sightseeingName']; ?></div>   </td>
	
	<td align="left"><?php echo $resultlists['sightseeingCity']; ?></td>
	<td align="left"><?php echo strip($resultlists['sightseeingDetail']); ?></td>
	<td align="left"><?php if($resultlists['status']==1){ echo 'Active';}else{ echo 'Inactive';} ?></td>
	<td align="center"><a href="showpage.crm?module=packagesightseeingmaster&supplier=1&sightseeingid=<?php echo encode($resultlists['id']); ?>">
	  <input name="addnewuserbtn" type="button" class="bluembutton" value="View"/></a></td>
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
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">
 <input name="importpackagesightseeing" id="importpackagesightseeing" type="hidden" value="Y" /> <input name="importpackagesightseeingModule" id="importpackagesightseeingModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>
 </form>
 <script>
function submitimportfrom(){
startloading();
$('#importfrm').submit();
var filesizes = $("#importfield")[0].files[0].size;
filesizes=Number(filesizes/1024); 
if(filesizes>11){

}  
}

function reloadpagemain(){
location.reload();
}


 
$('#importbutton').click(function(){
    $('#importfield').click();
});
</script>
<?php  }
if($_REQUEST['supplier']=='1'){
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><script>
function goBack() {
    window.history.back();
}
</script>
<div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><a href="showpage.crm?module=packagesightseeingmaster"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a> Sightseeing  Suppliers</span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="" size="100" maxlength="100" placeholder="Keyword"></td>
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Supplier" onclick="masters_alertspopupopen('action=addeditpackagesupplier_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&sightseeingid=<?php echo $_GET['sightseeingid'];?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deleteextraquotation" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="supplier" id="supplier" type="hidden" value="1" />
<input name="sightseeingid" id="sightseeingid" type="hidden" value="<?php echo clean($_GET['sightseeingid']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="14%" align="left" class="header" >Supplier</th>
     <th width="12%" align="left" class="header" >Destination</th>
     <th width="16%" align="left" class="header">Contact&nbsp;Person</th>
     <th width="12%" align="left" class="header">Located  </th>

     <th width="13%" align="left" class="header">Contact No.</th>
     <th width="13%" align="left" class="header">	Email Id</th>
     <th width="10%" align="center" class="header">Status</th>
     <th width="10%" align="center" class="header">Rate List</th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php
  
if($_REQUEST['status']!=""){
$id=decode($_REQUEST['id']);
$status=$_REQUEST['status'];

$sql_ins="update "._PACKAGE_SIGHTSEEING_SUPPLIER_MASTER_." set deletestatus='$status' where id = ".$id."";
mysqli_query(db(),$sql_ins) or die(mysqli_error(db()));
}

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$searchField=$_REQUEST['keyword'];
$mainwhere='';
if($searchField!=''){
$mainwhere=' and ( name like "%'.$searchField.'%" or contactPerson like "%'.$searchField.'%" or id in (select masterId from  '._PHONE_MASTER_.' where phoneNo like "%'.$searchField.'%"  ) or id in  (select masterId from  '._EMAIL_MASTER_.' where email like "%'.$searchField.'%"  ) or cityId in  (select id from  '._CITY_MASTER_.' where name like "%'.$searchField.'%"  )  or destinationId in  (select id from  '._DESTINATION_MASTER_.' where name like "%'.$searchField.'%"  )  or stateId in  (select id from  '._STATE_MASTER_.' where name like "%'.$searchField.'%"  ) ) ';
}



 
$sightseeingid=decode($_GET['sightseeingid']);

$page=$_GET['page'];
 

$query1 = "SELECT * FROM "._PACKAGE_SIGHTSEEING_SUPPLIER_MASTER_." where  sightseeingId='".$sightseeingid."'";
$result = mysqli_query(db(),$query1);

/*$select='*';
//$where='where id="" '.$hotelId.''; 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$result=GetRecordList($select,_PACKAGE_HOTEL_SUPPLIER_MASTER_,$where,$limit,$page,$targetpage);*/
	
while($resultlist2= mysqli_fetch_array($result)){



$no=1; 
 $select='*'; 
$where=''; 
$sightseeingid=decode($_GET['sightseeingid']);
$where='where id='.$resultlist2["supplierId"].' '.$mainwhere.''; 

$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=packagesightseeingmaster&supplier=1&sightseeingid='.$sightseeingid.'&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];
if($resultlist2['deletestatus']=='1'){$status='0';}else{$status='1';}
/*$sql5="select * from ad_courses ";
$res5 = mysqli_query($sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
  <tr>
    <td align="left"><a href="showpage.crm?module=suppliers&view=yes&sightseeingid=<?php echo $_GET['sightseeingid'];?>&id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo strip($resultlists['name']); ?></a> </td>
    <td align="left"><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left"><?php echo strip($resultlists['contactPerson']); ?></td>
    <!-- <td align="left"><?php //echo getCityName($resultlists['cityId']); ?>, <?php //echo getStateName($resultlists['stateId']); ?>, <?php //echo getCountryName($resultlists['countryId']); ?></td> -->
    <td align="left">
      <?php if(!empty($resultlists['cityId'])){ echo getCityName($resultlists['cityId']);} else {echo getcity($supplr_id); } ?>,
       <?php if(!empty($resultlists['stateId'])){ echo getStateName($resultlists['stateId']);} else{echo getstate($supplr_id); } ?>,
        <?php if(!empty($resultlists['countryId'])){ echo getCountryName($resultlists['countryId']);} else {echo getcountry($supplr_id); } ?>    </td>

    <td align="left"><?php echo getPrimaryPhone($resultlists['id'],'suppliers'); ?></td>
    <td align="left"><?php echo getPrimaryEmail($resultlists['id'],'suppliers'); ?></td>
    <td align="center"><a href="showpage.crm?module=<?php echo $_GET['module'];?>&supplier=1&sightseeingid=<?php echo $_GET['sightseeingid']; ?>&id=<?php echo encode($resultlist2['id']); ?>&status=<?php echo $status; ?>"><?php if($resultlist2['deletestatus']=='0'){ $status2='Active';} else { $status2='Inactive';}?>
      <input name="addnewuserbtn" type="button" class="bluembutton" onclick="return confirm('Do you want to <?php if($resultlist2['deletestatus']=='0'){ echo 'Inactive';} else { echo 'Active';}?> this record?');"  value="<?php echo $status2;?>"/>
	</a></td>
    <td align="center"><a href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>&view=yes&sightseeingid=<?php echo $_REQUEST['sightseeingid']; ?>&supplierId=<?php echo encode($resultlists['id']); ?>"><input name="addnewuserbtn" type="button" class="bluembutton" value="View"/></a></td>
  </tr> 
	
	<?php $no++; }
	}
	 ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>

<div class="pagingdiv">

		

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;"><?php echo $no; ?> entries</td>
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

<?php }?>

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