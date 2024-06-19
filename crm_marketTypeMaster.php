<?php $statuswise = $_GET['statuswise']; ?>
<?php include 'tableSorting.php'; ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td width="7%" align="left">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td>
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?>  
	 	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=marketdelete&name=Market&nbsp;Type','600px','auto');" /> 
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr> 
        <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php echo $_GET['keyword']; ?>" size="100" maxlength="100" placeholder="Keyword"></td>
        <td style="boarder-radius:10%">
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>
    
        </select>
        </td>
        
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
		
		 <td >&nbsp;</td>
        <td>&nbsp;</td> 
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deleteMarketType" />
<input name="table" id="table" type="hidden" value="<?php echo _INBOUND_MEALPLAN_MASTER_;?>" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="mainsectiontable" class="table table-striped table-bordered gridtable"> 
	  <thead> 
		<tr> 
		<th width="10px" class="header" align="left">Sr.</th>
     <th width="10px" height="28" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
       <label for="checkAll"><span></span>&nbsp;</label>
     </th>
			<th width="14%" align="left" class="header" >Market&nbsp;Name</th>
			<th width="9%"  align="left" class="header" >Color</th>
			<th width="9%"  align="left" class="header" >Added By </th>
			<th width="10%"  align="left" class="header" >Date Added  </th>
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
if($_GET['keyword']!=''){
$wheresearch="and name like '%".$_GET['keyword']."%'";}

if($_REQUEST['status']!=''){

	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";

}
$where='where  name!=""  '.$wheresearch.''.$wheresearch2.' and deletestatus=0 order by name desc'; 
 
///$where='where 1 and deletestatus=0 '.$wheresearch.' '.$wheresearch2.' '; 
///$where='where 1 order by id desc'; 
 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 
$rs=GetRecordList($select,'marketMaster',$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){
	?>
  	<tr>
  	    <td width="1%" align="left"><?= $no; ?></td>
    <td width="1%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
     <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
    </td>
	<td align="left" valign="middle" style="display: flex;"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo encode($resultlists['id']); ?>','400px','auto');" ><?php echo $resultlists['name']; ?>



	</div>  
	<!-- by default select option set -->
	<?php if($resultlists['setDefault']==1){ ?>
			<div style="background: green;width: fit-content;padding: 4px;color: white;border-radius: 2px;font-size: 9px;position: relative;
	left: 49%;"><i class="fa fa-cog" aria-hidden="true"></i> Default</div>
			<?php  } ?>
		
		</td>
		
	<td align="left" valign="middle"><div style="background-color:<?php echo $resultlists['marketColor']; ?>; padding:10px 10px;"></div></td>
	<td align="left" valign="middle"><?php echo getUserName($resultlists['addedBy']); ?></td>
	<td align="left" valign="middle"><?php echo date('d-m-Y', $resultlists['dateAdded']); ?></td>
	<td align="left" valign="middle"> <?php if($resultlists['status']==1){ ?>
		<div style="border: 1px solid #809b7b; width: fit-content; padding: 5px 15px; background-color: #809b7b; color: #fff; border-radius: 3px;">Active</div> 
		<?php }else{ ?>
		<div style="border: 1px solid #c22525; width: fit-content; padding: 5px 15px; background-color: #c22525; color: #fff; border-radius: 3px;">Inactive</div> 
		<?php } ?>	</td>
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