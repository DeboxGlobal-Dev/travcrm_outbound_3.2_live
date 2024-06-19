<?php
$searchField=clean($_GET['searchField']);

 



?>

<?php if ($_GET['assignto']): $assignto=$_GET['assignto']; endif;  ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top"><div class="rightsectionheader"><form action="" method="get"><table width="100%" border="0" cellpadding="0" cellspacing="0">
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
        <td> </td>
        <td >
		 

		</td>
      
        
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><a href="showpage.crm?module=cms&page=addcmspackagebuilder&type=2"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Package" /></a></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table></form>
</div>
	<form id="listform" name="listform" method="get">


<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="corportatedelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr width="100%"> 
	  <th width="15%"  align="left" class="header" style="padding-left:0px;padding-tight:0px;">ID </th>
	  <th width="10%"  align="left" class="header" style="padding-left:0px;padding-tight:0px;">Name</th>
	  <th width="15%"  align="left" class="header" style="padding-left:0px;padding-tight:0px;">Destination</th>
	  <th width="6%"  align="left" class="header" style="padding-left:0px;padding-tight:0px;">	DURATIONS</th>
	  <th width="6%"  align="left" class="header" >Status</th>
	  <th width="11%"  align="left" class="header" >Action</th>
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
$mainwhere=' and ( name like "%'.$searchField.'%" or contactPerson like "%'.$searchField.'%" or id in (select masterId from  '._PHONE_MASTER_.' where phoneNo like "%'.$searchField.'%"  ) or id in  (select masterId from  '._EMAIL_MASTER_.' where email like "%'.$searchField.'%"  ) ) ';
}

$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].'  ) '.$mainwhere.'';
}



 
 
$where='where queryId=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=corporate&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,'cmspackageBuilderDetail',$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    
	<td align="left" style="padding-left:0px;padding-right:0px;"><a href="showpage.crm?module=cms&page=addcmspackagebuilder&type=2&id=<?php echo encode($resultlists['id']); ?>&selecttab=2&type=2"><?php echo strip($resultlists['packageId']); ?></a></td>
	<td align="left" style="padding-left:0px;padding-right:0px;"><a href="showpage.crm?module=cms&page=addcmspackagebuilder&type=2&id=<?php echo encode($resultlists['id']); ?>&selecttab=2&type=2"><?php echo strip($resultlists['pacakageName']); ?></a></td>
	<?php  
		$rsc=GetPageRecord('*',_DESTINATION_MASTER_,' id="'.$resultlists['startCity'].'" order by name asc'); 
		$resListingc=mysqli_fetch_array($rsc);
		
		$rsca=GetPageRecord('*',_DESTINATION_MASTER_,' id="'.$resultlists['endCity'].'" order by name asc'); 
		$endcity=mysqli_fetch_array($rsca);
	 ?>
	<td align="left" style="padding-left:0px;padding-right:0px;"><?php echo ($resListingc['name']); ?> <strong>to</strong> <?php echo ($endcity['name']); ?></td>
	<?php
		$selectc=''; 
		$wherec=''; 
		$rsc='';  
		$selectc='*';    
		$wherec=' id="'.$resultlists['endCity'].'" order by name asc';  
		$rsc=GetPageRecord($selectc,_DESTINATION_MASTER_,$wherec); 
		$resListingc=mysqli_fetch_array($rsc);
	 ?>
	<td align="left" style="padding-left:0px;padding-right:0px;"><?php if($resultlists['newPackageType']==0){ echo countlisting('id',_PACKAGE_BUILDER_DAYS_MASTER_,' where packageId='.$resultlists['id'].' '); } else { echo $resultlists['days']; }?>D / <?php  if($resultlists['newPackageType']==0){ $countNight = countlisting('id',_PACKAGE_BUILDER_DAYS_MASTER_,' where packageId='.$resultlists['id'].' ')-1; if($countNight<=0){echo '1';}else{echo $countNight;}  } else { echo $resultlists['nights']; } ?>N</td>
	<style>
	.btnstatus{ 
	border-radius: 7px;
    background-color: #4CAF50;
    border: solid 0px;
    color: #fff;
    padding: 4px 10px;
	outline: 0px;
	}
	</style>
    <td align="left"><?php if($resultlists['newPackageType']!=2){ if($resultlists['status']==1){ ?>
	<a href="showpage.crm?module=packagebuilder&id=<?php echo $resultlists['id']; ?>&status=0"><input type="button" class="btnstatus" value="Active" /></a>
	<?php } ?><?php if($resultlists['status']==0){ ?>
	<a href="showpage.crm?module=packagebuilder&id=<?php echo $resultlists['id']; ?>&status=1"><input type="button" class="btnstatus" style="background-color: #f83f23 !important;" value="Inactive" />
	<?php } } ?><a> </td>
	
    <?php		
		$packageId = $resultlists['id'];  
		$selectp='*';    
		$wherep=' packageId="'.$packageId.'" ';  
		$rsp=GetPageRecord($selectp,_PACKAGE_BUILDER_PRICE_LIST,$wherep); 
		$packagedetails=mysqli_fetch_array($rsp);
	?>
	 <td align="left">
	 <?php if($resultlists['newPackageType']==0){ if(!file_exists('tcpdf/examples/package/PACKAGE-'.$resultlists['packageId'].'.pdf')) { } else {   ?>
	 <div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendpackage&pid=<?php echo $resultlists['id']; ?>&filename=<?php echo strip($resultlists['packageId']); ?>&packageName=<?php echo str_replace(' ','%20',strip($resultlists['pacakageName'])); ?>','600px','auto');"><img style="margin-left: 4px;" src="images/emailiconsmall.png"  /></div>
 
	
	<a href="<?php echo $fullurl; ?>tcpdf/examples/package/PACKAGE-<?php echo strip($resultlists['packageId']); ?>.pdf" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px; margin-left: 4px;"   /></div></a>
	
	<?php } } else{ ?>
	 <div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendpackage&pid=<?php echo $resultlists['id']; ?>&filename=<?php echo strip($resultlists['packageId']); ?>&type=2&packageName=<?php echo str_replace(' ','%20',strip($resultlists['pacakageName'])); ?>','600px','auto');"><img style="margin-left: 4px;" src="images/emailiconsmall.png"  /></div>


<a href="<?php echo $fullurl; ?>tcpdf/examples/genratepackageb2c.php?pageurl=<?php echo $fullurl; ?>packagehtmlb2c.php?id=<?php echo encode($resultlists['id']); ?>&download=1&userid=<?php echo $_SESSION['userid']; ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px; margin-left: 4px;"   /></div></a>
	 <?php  } ?> 	</td>
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
</div></form>	

 <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">
 <input name="importexcel" id="importexcel" type="hidden" value="Y" /> 
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
</td>
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
 