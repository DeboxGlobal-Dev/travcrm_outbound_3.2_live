<?php
$searchField=clean($_GET['searchField']);

?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Complaint','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
         <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:200px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Complaint ID or Query Id" onkeyup="numericFilter(this);"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           
 </td>
   
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        <td style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>

		</td>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Complaint" onclick="alertspopupopen('action=addcomplaint','600px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="complaintdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      
      <th width="196" align="left" class="header" >Complaint ID</th>
      <th width="196" align="left" class="header" >qUERY ID </th>
     <th width="286" align="left" class="header">COMPANY</th>
     <th width="240" align="left" class="header">supplier</th>
     <th width="240" align="left" class="header">Subject</th>
     <th width="299" align="left" class="header">Date</th>
     <th width="206" align="center" class="header">Status</th>
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

$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';
if($searchField!=''){
$mainwhere=' and  queryId='.$searchField.' or id='.$searchField.'';
}
   
  
 
$where='where deletestatus=0 '.$mainwhere.'  order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=complaintmanagement&records='.$limit.'&searchField='.$searchField.'&';
$rs=GetRecordList($select,_COMPLAINT_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 

 
?>
  <tr>
    
    <td align="left"><div class="bluelink"><a onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo makeQueryId($resultlists['id']); ?></a>
	 
	</div></td>
    <td align="left"><div class="bluelink"><a onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo makeQueryId($resultlists['queryId']); ?></a>
	 
	</div></td>
    <td align="left"><?php echo getCorporateCompany($resultlists['companyId']); ?></td>
    <td align="left"><?php echo getsupplierCompany($resultlists['supplierId']); ?></td>
    <td align="left" ><a onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo clean($resultlists['subject']); ?></a></td>
    <td align="left"><?php echo showdate($resultlists['complaintDate']); ?></td>
    <td align="center" ><?php
	if($resultlists['status']==1){ echo '<div class="lossquery">Open</div>'; } if($resultlists['status']==2){ echo '<div class="wonquery">Closed</div>'; }   ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No Complaint</div>
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

 