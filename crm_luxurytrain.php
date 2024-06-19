<?php  include 'tableSorting.php'; ?>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td>
    <td><div class="headingm" style="margin-left:5px;"><span id="topheadingmain"><?php echo  $pageName; ?></span>
	
	  <div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?>  
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Train_Master','600px','auto');" />
	<?php } ?>
	</div>
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>


    <style>
        .dropbtn {
            background-color: #67b069;
            color: white;
            padding: 10px;
            font-size: 12px;
            border: none;
            margin-left: 7px;
            margin-right: 5px;
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
     <!--    <td ><div class="dropdown">
        <button class="dropbtn" type="button"><i class="fa fa-bug" aria-hidden="true"></i> View Logs</button>
        <div class="dropdown-content"> 
        <?php   $dirname =  'log_luxurytrain/'; 
        $images = scandir($dirname);
        krsort($images);
        foreach (array_slice($images, 0, 5) as $file) {
            if (substr($file, -4) == ".log" ) {
                ?>
                <a href="<?php echo $fullurl; ?>log_luxurytrain/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
                <?php  
            }
        }
        ?>

        </div>
        </div>
        </td> -->

        <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php echo $_GET['keyword']; ?>" size="100" maxlength="100" placeholder="Keyword"></td>
        <td style="boarder-radius:10%">
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>InActive</option>
    
        </select>
        </td>
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
     
        <!-- 
         <td  ><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
    
         <td ><a href="<?php echo $fullurl; ?>travrmimports/train-import-format.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a>
        </td> -->

        <div>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Train" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="delete_trainmaster" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
       <th width="2%" align="left" class="header">Sr.</th>
        <th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
       <label for="checkAll"><span></span>&nbsp;</label></th>
      <th width="10%" align="left" class="header" >Train Image</th> 
      <th align="left" class="header" >Luxury Train Name </th>
      <!-- <th align="left" class="header" >Train Number </th> -->
	 <th  align="left" class="header" >Status</th>
   </tr>
   </thead>
 
<tbody>
<?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';
$wheresearch2='';
$wheresearch=''; 
$limit=clean($_GET['records']);
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 

if($_GET['keyword']!=''){
    $wheresearch="and trainName like '%".$_GET['keyword']."%'";
}
if($_REQUEST['status']!=''){
	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
}
$where='where trainType=1 and trainName!=""  '.$wheresearch.''.$wheresearch2.''; 
$page=$_GET['page'];
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_PACKAGE_BUILDER_TRAINS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
//print_r($resultlists);
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
    $dateAdded=clean($resultlists['dateAdded']);
    $modifyDate=clean($resultlists['modifyDate']);

    ?>
    <tr>
    <td width="2%"><?= $no ?></td>
    <td width="4%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
     <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
    </td>
    <td align="left"><?php if($resultlists['trainImage']!=''){ ?><img src="packageimages/<?php echo $resultlists['trainImage']; ?>" width="75" height="58" /><?php } ?></td> 

    <td  align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');" ><?php echo $resultlists['trainName']; ?></div>  
    </td>

    <!-- <td><?php echo $resultlists['trainNo']; ?></td> -->

	<td width="15%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green;"><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content;  color: red; "><?php echo 'In Active';?></div><?php }  ?></td>
 
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

 <input name="importtrainmaster" id="importtrainmaster" type="hidden" value="Y" /> <input name="importimporttrainmasterModule" id="importimporttrainmasterModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>

 </form>

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