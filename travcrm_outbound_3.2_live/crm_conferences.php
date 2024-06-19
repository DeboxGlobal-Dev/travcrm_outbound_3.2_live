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
		 

		</td>
        <?php if($addpermission==1){ ?><td  > </td><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="add();" /></td> <?php } ?>
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
     <th width="3%" align="center" class="header" >Sr.</th>
     <th width="3%" align="center" class="header" >Logo</th>
     <th width="26%" align="left" class="header" >Conferences Name</th>
      <th width="12%" align="left" class="header" >Start Date </th>
      <th width="12%" align="left" class="header" >End Date </th>
      <th width="8%" align="left" class="header" >Duration </th>
       <th width="10%" align="left" class="header" >City</th>
       <th width="25%" align="left" class="header"  >Address</th>
       <th width="6%" align="center" class="header" >Action</th>
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
    
 
$where='where 1 order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=conferences&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,'conferencesMaster',$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){  
 
?>
  <tr>
    <td align="center" valign="middle"><?php echo $no; ?></td>
    <td align="center" valign="middle"><img src="<?php if($resultlists['logo']!=''){ ?>upload/<?php echo $resultlists['logo']; ?><?php } else { ?>images/nologo.jpg<?php } ?>" width="50"  ></td>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');" style="font-weight:500; color:#45b558 !important;"><?php echo strip($resultlists['name']); ?> </div></td>
    <td width="12%" align="left"><?php echo date('d/m/Y',strtotime($resultlists['startDate'])); ?></td>
    <td width="12%" align="left"><?php echo date('d/m/Y',strtotime($resultlists['endDate'])); ?></td>
    <td width="8%" align="left"><?php echo strip($resultlists['cDuration']); ?> Days</td>
    <td width="10%" align="left"><?php echo getDestination($resultlists['cityId']); ?></td>
     
    <td width="25%" align="left" ><?php echo strip($resultlists['address']); ?></td>
    <td align="center" ><a href="showpage.crm?module=conferences&add=yes&id=<?php echo encode($resultlists['id']); ?>" style="font-size: 24px;color: #ff430d;"><i class="fa fa-pencil-square" aria-hidden="true" ></i></a></td>
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
 <input name="importsupplierexcel" id="importsupplierexcel" type="hidden" value="Y" /> 
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

<style>
.gridtable .header { 
    padding-bottom:10px !important;  
}
</style>