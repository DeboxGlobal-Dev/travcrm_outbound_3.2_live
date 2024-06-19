
<?php include 'tableSorting.php'; ?>


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
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Hotel&nbsp;Category&nbsp;Type','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>

    <td width="70%" align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>
        <td width="34%" align="right"  ><input type="text" name="search" class="whitembutton" placeholder="Enter Nationality or Country Name" style="width: 230px;" value="<?php echo trim($_GET['search']); ?>" /></td>
<td width="7%" ><input type="submit" name="Submit" value="Search" class="bluembutton" /></td>
        <td width="18%"  ><a href="<?php echo $fullurl; ?>travrmimports/NationalityReport.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Download&nbsp;Format</a></td> 
       <td width="15%"><div class="bluembutton" id="importbutton" style="    width: fit-content;"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Import&nbsp;Excel</div></td>  
        <?php if($addpermission==1){ ?><td width="26%" style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>
      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>



<div id="pagelisterouter" style="padding-left:30px;">

<input name="action" id="action" type="hidden" value="deleteweekend" />

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



   <thead>



   <tr>
<th width="2%" align="center" valign="middle" class="header" >
	  	<?php if($editpermission==1){ ?>
		<input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" />
		<?php } ?>
		<label for="checkAll"><span></span>&nbsp;</label>
	 </th> 
        <th width="11%" align="left" class="header"  style="width: 14%;"><span class="header" style="width: 14%;">Nationality </span></th>

        <th width="11%" align="left" class="header" style="width: 14%;"><span class="header" style="width: 14%;">Nationality Type </span></th>

        <th width="19%" align="left" class="header" style="width: 14%;"><span class="header" style="width: 14%;">Country</span></th>

	    <th width="24%"  align="left" class="header" style="width: 14%;"><span class="header" style="width: 14%;"><span class="header" style="width: 14%;">Country Code</span></span></th>
	    <th width="35%"  align="left" class="header" style="width: 38%;">Status</th>
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
if(trim($_GET['search'])!=''){
 $wheresearch=' and name like "%'.trim($_GET['search']).'%" or countryId in (select id from countryMaster where name like "%'.trim($_GET['search']).'%")';   
 } 
$where='where 1 '.$wheresearch.' order by name ASC';  
$page=$_GET['page']; 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';  
$rs=GetRecordList($select,'nationalityMaster',$where,$limit,$page,$targetpage);  
$totalentry=$rs[1];  
$paging=$rs[2];  
while($resultlists=mysqli_fetch_array($rs[0])){ 

  $supname=''; 
  $rs2ws = GetPageRecord('*','countryMaster',' id="'.$resultlists['countryId'].'"');  
  $hotsupp = mysqli_fetch_array($rs2ws);

 

?>

  <tr>

 <td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/><label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
   <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $resultlists['name']; ?></div>   </td>

   <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php if($resultlists['type']!=1){ echo 'Foreign'; }else{ echo 'Indian'; } ?>
   </div></td>


    <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $hotsupp['name']; ?></div></td>


	<td align="left"><span class="bluelink"><?php echo $resultlists['sortName']; ?></span></td>
	<td align="left"><?php if($resultlists['deleteStatus']==0){ echo 'Active';}else{ echo 'Inactive';} ?></td>
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

<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">



 <input name="importpackagenationality" id="importpackagenationality" type="hidden" value="Y" /> <input name="importpackagenationalityModule" id="importpackagenationalityModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />



 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>



 </form>



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

</script>