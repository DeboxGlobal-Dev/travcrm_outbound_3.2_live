<?php
$searchField=clean($_GET['searchField']);
$paymentid=clean($_GET['paymentid']);
$statusId=clean($_GET['statusId']);
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>
     <td style="padding:0px 0px 0px 5px;" >&nbsp;</td>
   
        <td style="padding-right:20px;" ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        </tr>
</table>		</td>
        <?php if($addpermission==1){ ?><?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="paymentdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="93" align="center" valign="middle" class="header" style="display:none;" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
     <th width="271" align="left" class="header">query ID </th>
     <th width="423" align="left" class="header">	 Created Date </th>
     <th width="361" align="left" class="header"  >Status</th>
     <th width="156" align="center" class="header"  >Progress</th>
     <th width="156" align="left" class="header"  >&nbsp;</th>
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
$mainwhere=' and  queryId='.$searchField.'';
}
   
  
	 
 
$where='where deletestatus=0 and queryId in (select id from '._QUERY_MASTER_.' where id!="") '.$mainwhere.' group by queryId order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=checklist&records='.$limit.'&searchField='.$searchField.'&';
$rs=GetRecordList($select,_CHECK_LIST_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="center" valign="middle" style="display:none;" ><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['queryId']); ?>');"><?php echo makeQueryId($resultlists['queryId']); ?>
	 
	</div></td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>
    <td align="left" ><?php
$totalnotdone='0';
$totalnotdoneall='0';
$select3=''; 
$where3=''; 
$rs3='';   
$select3='*'; 
$id=$id; 
$where3='queryId='.$resultlists['queryId'].''; 
$rs3=GetPageRecord($select3,_CHECK_LIST_MASTER_,$where3); 
while($resListingun=mysqli_fetch_array($rs3)){ 


if($resListingun['statusId']==1 || $resListingun['statusId']==2){
$totalnotdone=$totalnotdone+1;
}
$totalnotdoneall=$totalnotdoneall+1;

}
$finaldone=$totalnotdoneall-$totalnotdone;
$totalpercentage=$finaldone*100/$totalnotdoneall;
?>

<?php if($totalnotdone>0){ echo '<div class="wonquery" style="background-color:#CC3300;">Pending</div>'; }  ?><?php if($totalnotdone==0){ echo '<div class="wonquery">Done</div>'; }  ?></td>
    <td align="center" ><?php if($totalnotdoneall!=0){ ?><div style=" float:none;"><div style="padding-bottom:2px; font-size:11px; color:#82b767; text-align:center; width:100%;"><?php echo $totalpercentage; ?>%</div><div style="width:150px; border:1px #CCCCCC solid; height:9px; background-color:#FFFFFF; overflow:hidden; text-align:left;">
	<div style="background-color:#82b767; width:<?php echo $totalpercentage; ?>%; height:11px;"></div>
	</div></div><?php } ?></td>
    <td align="left" >&nbsp;</td>
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
</script>