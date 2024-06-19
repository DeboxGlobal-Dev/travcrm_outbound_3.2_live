
<?php include 'tableSorting.php'; ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
	<div class="rightsectionheader">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td >
         <button name="addnewuserbtn" type="button"  style="background-color:#fff!important;border:2px solid gray;border-radius:50%;color:#000;padding:7px;width:50px;margin-left:10px;cursor:pointer"  class="" onclick="window.history.back();" /><i class="fa fa-arrow-left" style="font-size:24px"></i>
         </button>    
        </td>
		<td>
			<div class="headingm" style="margin-left:-10px;">
				<span id="topheadingmain"><?php echo 'Porter Price';//$pageName; ?></span>
				<div id="deactivatebtn" style="display:none">
					<?php if($deletepermission==1){ ?>  
						<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Active/InActive" onclick="masters_alertspopupopen('action=mastersdelete&name=<?php echo str_replace(" ","%20",$pageName); ?>','600px','auto');" /> 
					<?php } ?>
				</div> 
			</div>
		</td>
		<td align="right">
			<table border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="" size="100" maxlength="100" placeholder="Keyword"></td>
                <td>
                <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
                <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

                 <option value=""> Select  Status &nbsp;</option>
    
                 <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
                 <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>InActive</option>
    
                </select>
               </td>
             <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
					<td>        </td>
					<?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
					<?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo 'Porter Service';//$pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" /></td> <?php } ?>
				</tr> 
			</table>
		</td>
</tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="delete_<?php echo clean($_GET['module']); ?>" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="table" id="table" type="hidden" value="<?php echo _PORTER_SUB_CAT_MASTER_; ?>" />
<table border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

	<thead>
		<!--guidemaster-->
		<tr>
		    <td align="left" class="header">Sr.</td>
			<th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
			<!--<th align="left" width="20%"  class="header" >Name</th>  -->
			<th align="left" width="20%"  class="header" >Porter Service </th>   
			<th align="left" width="20%"  class="header" >Day Type</th> 
			<th align="left" width="15%" class="header" >Price</th> 
			<th align="left" width="35%" class="header" >Porter&nbsp;Name</th> 
			<th width="39%"  align="left" class="header" >Status</th>
		</tr>
	</thead>
  	<tbody>
		<?php 
		$no=1; 
		$select='*'; 
		$where=''; 
		$rs='';  
		$wheresearch='';
		$wheresearch2='';
		$limit=clean($_GET['records']); 
// 		$wheresearch=' and  ( createdBy = "'.$_SESSION["userid"].'" ) ';   
// 		$where='where 1 '.$wheresearch.' order by id asc'; 
// 		$page=$_GET['page']; 
// 		$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';
        
        if($_GET['keyword']!=''){
         $wheresearch="and name like '%".$_GET['keyword']."%'";}
         if($_REQUEST['status']!=''){

	     $wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";

        }
        $where='where  name!=""  '.$wheresearch.''.$wheresearch2.' and deletestatus=0 order by name asc'; 

        $page=$_GET['page'];
 
        $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 

		$rs=GetRecordList($select,_PORTER_SUB_CAT_MASTER_,$where,$limit,$page,$targetpage); 
		$totalentry=$rs[1]; 
		$paging=$rs[2]; 
		while($resultlists=mysqli_fetch_array($rs[0])){ 
			$dateAdded=clean($resultlists['createdOn']);
			$modifyDate=clean($resultlists['updatedOn']); 
		?>
		<tr> 
		    <td align='left'><?= $no ?></td> 
			<td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']).','.$resultlists['status']; ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
			<td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','600px','auto');" ><?php echo $resultlists['name']; ?></div>   </td> 
			<!--<td align="left"><?php if($resultlists['guiderule']!=''){ echo $resultlists['guiderule']; }else{ echo 'NA';} ?></td>-->
			<td align="left" width="10%"><?php if($resultlists['dayType']!=''){ echo $resultlists['dayType']; }else{ echo 'NA';}   ?></td>
				
			<td align="left"  width="5%"><?php if($resultlists['price']!='' && $resultlists['price']!=0){ echo $resultlists['price']; }else{ echo 'NA';}   ?></td> 
			<td align="left" width="8%">
			  <?php  $rs2=GetPageRecord('*',_PORTER_MASTER_,' id="'.$resultlists['guideId'].'" '); 
									$guideData=mysqli_fetch_array($rs2);
									echo $guideData['name'];
 									?>
 			</td> 
 			<td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content;color: green;"><?php echo 'Active';?></div><?php } else { ?><div style="color: red; "><?php echo 'In Active';?></div><?php }  ?>
	       </td>						
		</tr>  
		<?php $no++; } ?>
	</tbody>
</table>
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
	  </select>
	</td>
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
        "searching": false,
         "order": [[ 2, 'asc' ]]

    } );
} );
</script>