<?php
$searchField=clean($_GET['searchField']);
$searchFieldcommon=clean($_GET['searchFieldcommon']);
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
	 
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td></td>
        <td >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding:0px 0px 0px 5px;" > 
					  </td>
	 
				</tr>
			</table>
		</td>
        
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

</form>

<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:0px;">
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="querydelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
     <th align="center" valign="middle" class="header" >&nbsp;</th>
     <th align="left" class="header" >T & C Type</th>
     <th align="left" class="header" >QueryT&nbsp;Type</th>
	 <th align="left" class="header" >Modified&nbsp;Date</th>
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

$querystatus='';
if($_GET['querystatus']!=''){
$querystatus=' and	queryStatus='.clean($_GET['querystatus']).'';
} 


$where='where 1 '.$querystatus.' '; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=query&records='.$limit.'&'; 
$rs=GetRecordList($select,_PACKAGE_TERMS_CONDITIONS_MASTER,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr style="background-color: #f8f8f8;" >
    <td align="center" valign="middle" style="padding:12px 3px;">
      <div style="width:30px;"><img src="images/editicon.png" class="editicon" onclick="edit('<?php echo encode($resultlists['id']); ?>');" /></div></td>
    
    <td align="left"><div class="bluelink" style="position:relative; padding-right:10px;" onclick="edit('<?php echo encode($resultlists['id']); ?>');"><?php if($resultlists['termsType']==1) { echo 'Domestic'; }else{ echo 'International';}; ?></div>   </td>
    <td><?php echo $resultlists['fit_git']; ?></td>
    <td><?php echo showdate($resultlists['modifyDate']); ?></td>
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
<div id="loadmailsquery" style="display:none;"></div>
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