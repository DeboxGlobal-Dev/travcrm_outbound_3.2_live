<?php $statuswise = $_GET['statuswise']; ?>
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
    <td>
	<div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo $pageName; ?> </span>
		<div id="deactivatebtn" style="display:none;">
	 	<?php if($deletepermission==1){ ?>  
	 	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=<?php echo urlencode($pageName); ?>','600px','auto');" /> 
		<?php } ?>
	</div>
	
	</div></td>
	<td style="padding-right:20px;" align="right"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','500px','auto');" /></td>
     
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="delete_<?php echo clean($_GET['module']); ?>" />
<input name="table" id="table" type="hidden" value="<?php echo 'seasonMaster';?>" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="mainsectiontable" class="table table-striped table-bordered gridtable"> 
	  <thead> 
		<tr> 
			<th align="left" class="header">Sr.</th> 
			<th width="5%" align="center" valign="middle" class="header" >
				<?php if($editpermission==1){ ?> 
				<input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" />
				<?php } ?>
				<label for="checkAll"><span></span>&nbsp;</label>
			</th>
			<th width="50%" align="left" class="header" >Season&nbsp;Name</th>
			<th width="10%"  align="left" class="header" >From Date </th>
			<th width="10%"  align="left" class="header" >ToDate </th>
			<th width="10%"  align="left" class="header" >Status</th>
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
 
$where='where 1 and deletestatus=0 order by fromDate asc'; 
 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 
$rs=GetRecordList($select,'seasonMaster',$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){
	if($resultlists['seasonNameId']=='1'){ 
		$seasonName = 'Summer'." - ".date('Y', strtotime($resultlists['fromDate']));
	}
	if($resultlists['seasonNameId']=='2'){
		$seasonName = 'Winter'." - ".date('Y', strtotime($resultlists['fromDate']));
	}
	if($resultlists['seasonNameId']=='3'){
		$seasonName = 'All'." - ".date('Y', strtotime($resultlists['fromDate']));
	}
	?>
  	<tr>
	<td width="2%"><?= $no ?></td>    
  	<td align="center" width="2%" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/> <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
    
  	<td align="left" valign="middle"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo encode($resultlists['id']); ?>','600px','auto');" ><?php echo $seasonName; ?></div>   </td>
	<td align="left" valign="middle"><?php echo date('d-m-Y', strtotime($resultlists['fromDate'])); ?></td>
	<td align="left" valign="middle"><?php echo date('d-m-Y', strtotime($resultlists['toDate'])); ?></td>
		<td align="left" valign="middle"><?php echo ($resultlists['status'] == 1)?'Active':'Inactive'; ?></td>
	</tr>
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>
	<div class="pagingdiv"> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
	  <tbody>
	  <tr> 
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
 <input name="importpackagemealPlan" id="importpackagemealPlan" type="hidden" value="Y" /> <input name="importpackagemealPlanModule" id="importpackagemealPlanModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
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
<style>
.header{
padding-bottom:15px!important;
}</style>