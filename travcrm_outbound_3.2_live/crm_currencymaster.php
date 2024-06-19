<?php include 'tableSorting.php'; ?>



<?php if($_REQUEST['submodule']== 'ratelist' && $_REQUEST['currencyId'] != ''){ ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
	<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
	<input name="submodule" id="submodule" type="hidden" value="<?php echo clean($_GET['submodule']); ?>" />
	<input name="currencyId" id="currencyId" type="hidden" value="<?php echo clean($_GET['currencyId']); ?>" />

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	 
  	<td width="7%" align="left">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module'];?>"><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td>
    <td><div class="headingm" style="margin-left:-10px;"><span id="topheadingmain"><?php 
	$rs1=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id = "'.$_REQUEST['currencyId'].'"'); 
	$currencyData=mysqli_fetch_array($rs1);
	$currencyName = $currencyData['name'];
	$currencyId = $currencyData['id'];
	
	$pageName = "Currency Rates(".$currencyName.")"; echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Currency','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
           <td>
		   <input type="date" class="topsearchfiledmain" name="date2" value="<?php if($_REQUEST['date2']==''){ echo date('Y-m-d'); }else{ echo date('Y-m-d',strtotime($_REQUEST['date2'])); } ?>" style="width:150px;" > </td>
        <td> 
        <select name="status" id="status1" value="status" class="topsearchfiledmain" style="width:130px; padding: 11px;
">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>
    
        </select>
        </td>
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
        <td>&nbsp;</td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['submodule']); ?>&sectiontype=ratelist&currencyId=<?php echo $_REQUEST['currencyId']; ?>','800px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deletecurrencymaster" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable"> 
	<thead> 
	<tr>
	<th width="4%" align="left" class="header">Sr.</th>
	<th width="6%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
	<label for="checkAll"><span></span>&nbsp;</label></th>
	<th align="left" class="header" >Date </th>
	<th align="left" class="header" >Exchange Rate</th> 
	<th  align="left" class="header" >Status </th>
	<th align="left" class="header" >Action </th>
	</tr>
	</thead>
	<style>
	.setdefault{padding: 5px;
	border: 1px solid #2c9d25;
	color: #fff;
	background-color: #2c9d25;
	width: fit-content;
	border-radius: 50px;}
	</style>
	<tbody>
	<?php
	
	$no=1; 
	$select='*'; 
	$where=''; 
	$rs='';  
	$wheresearch2=''; 
	$limit=clean($_GET['records']); 
	
	if($_REQUEST['status']!=''){ 
		$wheresearch2 .= " and status ='".clean($_REQUEST['status'])."' "; 
	}
	if($_REQUEST['date2']!=''){ 
		$wheresearch2 .= " and date = '".($_REQUEST['date2'])."' "; 
	}
	$where='where currencyId="'.$_REQUEST['currencyId'].'" and deletestatus=0  '.$wheresearch2.'  order by date desc'; 
	
	$page=$_GET['page'];
	
	$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&submodule='.$_GET['submodule'].'&currencyId='.$_REQUEST['currencyId'].'&records='.$limit.'&'; 
	
	$rs=GetRecordList($select,'queryCurrencyRateMaster',$where,$limit,$page,$targetpage); 
	$totalentry=$rs[1]; 
	$paging=$rs[2]; 
	while($resultlists=mysqli_fetch_array($rs[0])){ 
		$dateAdded=clean($resultlists['dateAdded']);
		$modifyDate=clean($resultlists['modifyDate']); 
		?>
	  	<tr>
		<td width="4%"><?= $no ?></td>

		<td width="6%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
		<label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?> </td>

		<td width="16%" align="left"><span class=""><?php echo date('d-m-Y',strtotime($resultlists['date'])); ?></span></td>
		<td width="30%" align="left"><?php echo number_format($resultlists['currencyValue'],4); ?></td> 
		
		<td width="13%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green;">Active</div><?php } else { ?>
		<div style=" width: fit-content;  color: red; ">Inactive</div>
		<?php }  ?> </td>
		
		<td width="16%" align="left"><span class="bluelink Addbtn" style="background-color:#FF9800!important;" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['submodule']); ?>&sectiontype=ratelist&currencyId=<?php echo $_REQUEST['currencyId']; ?>&id=<?php echo $resultlists['id']; ?>','800px','auto');" ><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Edit&nbsp;</span>	</td>
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
<?php }else{ ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="7%" align="left">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td>
    <td><div class="headingm" style="margin-left:-10px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Currency','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
           <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php echo $_GET['keyword']; ?>" size="100" maxlength="100" placeholder="Currency Name"></td>
        <td style="boarder-radius:10%">
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
       <select name="status" id="status1" value="status" class="topsearchfiledmain" style="width:130px;">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>
    
        </select>
        </td>
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
                                           <style>
.dropbtn {
    background-color: #67b069;
    color: white;
    padding: 9px;
    font-size: 12px;
    border: none;
    margin-left: 7px;
    border-radius: 13px;
    cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
  float: right; 
  cursor: pointer;
}

.dropdown-content {
display: none;
    position: absolute;
    background-color: #f1f1f1;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    right: 0; 
    overflow: visible;
    text-align: left;
    width: fit-content;
}

.dropdown-content a {
	color: black;
	padding: 10px 26px 10px 10px;
	text-decoration: none;
	display: block;
	float: left;
	text-align: left;
	width: 156%;
	background-color: #FFFFFF;
	border-bottom: 1px solid #cccccc30;


}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
.dropdown-content,.searchbtnmain,.bluembutton,.topsearchfiledmain { 
    font-size: 12px;
}
</style>
        <td ><div class="dropdown" style="display: none;">
          <button class="dropbtn" type="button"><i class="fa fa-bug" aria-hidden="true"></i> View Logs</button>
          <div class="dropdown-content"> 
          <?php   $dirname =  'currency_log/'; 
        $images = scandir($dirname);
        krsort($images);
        foreach (array_slice($images, 0, 5) as $file) {
            if (substr($file, -4) == ".log" ) {
                ?>
        		<a href="<?php echo $fullurl; ?>currency_log/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
        		<?php  
            }
        }
         ?>
    
        </div>
        </div></td>
         <td><a class="bluembutton" style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;display: none;"  href="<?php echo $fullurl; ?>travrmimports/currency-import-format.xls" ><i class="fa fa-download" aria-hidden="true"></i>Download Format</a><td>
        <td><div class="bluembutton" id="importbutton" style="display: none;"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deletecurrencymaster" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable"> 
	<thead> 
	<tr>
	<th width="4%" align="left" class="header">Sr.</th>
	<th width="6%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
	<?php 
	$rs1="";
	$rs1=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 and deletestatus=0'); 
	$defaultData = mysqli_fetch_array($rs1);
	?>
	<label for="checkAll"><span></span>&nbsp;</label></th> 
	<th align="left" class="header" >Country Name </th>
	<th align="left" class="header" >Currency Code</th>
	<th align="left" class="header" >Currency Name</th>
	<th align="left" class="header" >Exchange Rate in <b><?php echo trim($defaultData['name']); ?></b> ( As on <?= date('d M Y'); ?> ) </th>
	<th align="left" class="header" >Rate List </th> 
	<th  align="left" class="header" >Status </th>
	</tr>
	</thead>
	<style>
	.setdefault{padding: 5px;
	border: 1px solid #2c9d25;
	color: #fff;
	background-color: #2c9d25;
	width: fit-content;
	border-radius: 50px;}
	</style>
	<tbody>
	<?php
	
	$no=1; 
	$select='*'; 
	$where=''; 
	$rs='';  
	$wheresearch2='';
	$wheresearch=''; 
	$limit=clean($_GET['records']);
	
	//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].')';  
	
	// $where='where name!="" and deletestatus=0 order by id desc'; 
	// $page=$_GET['submodule'];
	
	// $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
	
	if($_GET['keyword']!=''){
	$wheresearch="and name like '%".$_GET['keyword']."%'";}
	if($_REQUEST['status']!=''){
	
	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
	
	}
	$where='where name!=""  '.$wheresearch.''.$wheresearch2.' and deletestatus=0 order by name asc'; 
	
	$page=$_GET['page'];
	$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 	
	///	$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
	
	$rs=GetRecordList($select,_QUERY_CURRENCY_MASTER_,$where,$limit,$page,$targetpage); 
	$totalentry=$rs[1]; 
	$paging=$rs[2]; 
	while($resultlists=mysqli_fetch_array($rs[0])){ 
	$dateAdded=clean($resultlists['dateAdded']);
	$modifyDate=clean($resultlists['modifyDate']);
	
	?>
  	<tr <?php if($resultlists['setDefault']==1){ ?> style=" background-color:#d2ffe2;" <?php } ?>>
	<td width="4%"><?= $no ?></td> 
	<td width="6%" align="center" valign="middle"><?php if($editpermission==1 && $resultlists['setDefault']!=1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
	<label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>    </td>
	<td width="16%" align="left"><span class=""><?php echo getCountryName($resultlists['country']); ?></span></td>
	<!-- new added currency code -->
	<td width="16%" align="left"><span class=""><?php echo $resultlists['currencyCode']; ?></span></td>

	<td width="15%" align="left" style="position:relative"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $resultlists['name']; ?></div><?php if($resultlists['setDefault']==1){ ?><div class="setdefault" style="
	position: absolute;
	right: 10px;
	top: 5px;"><i class="fa fa-cog" aria-hidden="true"></i> Default</div><?php  } ?></td>
    
	<td width="30%" align="left"><?php
	 if($resultlists['setDefault']!=1){ 
		$rs2=GetPageRecord('currencyValue','queryCurrencyRateMaster',' currencyId="'.$resultlists['id'].'" and date = "'.date('Y-m-d').'"'); 
		$editresult2=mysqli_fetch_array($rs2);
		echo number_format($editresult2['currencyValue'],4);
	}else{
		echo number_format(1,4);
	}
	?></td>
	<td width="16%" align="left">
	<?php //if($resultlists['setDefault']!=1){ ?>
		<a href="showpage.crm?module=<?php echo clean($_GET['module']); ?>&submodule=ratelist&currencyId=<?php echo $resultlists['id']; ?>" class="bluelink Addbtn" style="background-color:#FF9800!important;" ><i class="fa fa-eye" aria-hidden="true"></i><span>&nbsp;View&nbsp;</span>
		</a>
 	<?php //} ?>
	</td>
	<td width="13%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green;">Active</div><?php } else { ?><div style=" width: fit-content;  color: red; ">Inactive</div><?php }  ?>     </td>
	</tr> 
	
	<?php $no++; } ?>
	</tbody>
</table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>
<div class="pagingdiv">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tbody>
  	<tr>
    <td>
		<table border="0" cellpadding="0" cellspacing="0">
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
		</table>
	</td>
	<td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>
  	</tr>
</tbody>
</table>
</div>
</div>
</form>
</td>
</tr>
</table>
<?php }?>

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">

 <input name="importcurrencyMaster" id="importcurrencyMaster" type="hidden" value="Y" /> <input name="importcurrencyMasterModule" id="importcurrencyMasterModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

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

$('#importbutton').click(function(){

    $('#importfield').click();

});
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
<style>
.Addbtn{
	border: 1px solid #fff; border-radius: 25px; padding: 5px 9px; background-color: #7a96ff; color: white!important;
}
</style>