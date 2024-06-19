
<?php include 'tableSorting.php'; ?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['supplier']==''){
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="5%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td>
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo 'Transportation ';//$pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
 		 <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=<?php echo urlencode($pageName); ?>','600px','auto');" /> 
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
		<td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td>
		 <td>
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>InActive</option>
    
        </select>
        </td>
        <td> </td>
		<td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>  
		<td width="170px"><a href="<?php echo $fullurl; ?>travrmimports/transportation-import-format.xls?t=<?php echo time(); ?>" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a></td>

    
    
    <td style="width: 155px;">
    <a href="#" onclick="$('#downloadMainData').toggle()" class="bluembutton ">
                        <i class="fa fa-download" aria-hidden="true"></i> Download Data</a>
                        <div class="downloadMainData" id="downloadMainData" style="display: none;">
                            <div class="donwlArrowBox"> </div>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr><td align="right" colspan="3" style="font-size: 14px;padding-right: 15px;">Rate Valid From</td>
                                  <td align="left" style="font-size: 14px;padding-left: 15px;">Rate Valid To</td></tr>
                                    <tr>
                                        <td style="padding:0px 0px 0px 5px;">
                                            <select name="transferSupplier" id="transferSupplier" class="topsearchfiledmainselect" style="width:150px; ">
                                            <option value="">All Supplier</option>
                                                <?php
                                                $rs='';
                                                $rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and name!="" order by name asc');
                                                while($supplierData=mysqli_fetch_array($rs)){
                                               
                                                ?>
                                                <option value="<?php echo strip($supplierData['id']); ?>"><?php echo strip($supplierData['name']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                          <select name="withRate" id="withRate" class="topsearchfiledmainselect" style="width: 122px;"> 
                                            <option value="1">With Rate</option>
                                            <option value="2">Without Rate</option>
                                          </select>
                                        </td>
                                        <td>
                                          <input type="text" id="fromDate" name="fromDate" value="<?php echo date('d-m-Y',strtotime('-1 year'))?>" class="topsearchfiledmainselect" style="width: 100px; text-align:center;">
                                        </td>
                                        <td>
                                          <input type="text" id="toDate" name="toDate" value="<?php echo date('d-m-Y',strtotime('now')) ?>" class="topsearchfiledmainselect" style="width: 100px; text-align:center;">
                                        </td>
                                        <!-- ('d-m-Y',mktime(0, 0, 0, date('m'), 1, date('Y')) -->
                                        <td style="padding:0px 0px 0px 5px;">
                                            <select name="transferDestination" id="transferDestination" class="topsearchfiledmainselect" style="width:150px; ">
                                                <option value="" > All Destination</option>
                                                <?php
                                                $rs='';
                                                $rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 and name!="" order by name asc');
                                                while($destData=mysqli_fetch_array($rs)){
                                                ?>
                                                <option value="<?php echo strip($destData['id']); ?>" ><?php echo strip($destData['name']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input name="action" id="action" type="hidden" value="downloadTransferData">
                                            <input type="button" name="button" value="Search Records" class="searchbtnmain" onclick="generateTransferData()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><div id="downloadBtn" style="display:none;">
                                            <div id="cntRows"></div>
                                            <a href="#" target="_blank" id="donwloadLink" class="bluembutton " ><i class="fa fa-download" aria-hidden="true"></i> Click to Download </a>
                                           
                                            <div style="display: none;" id="loadtransferData"></div>
                                            
                                            <script type="text/javascript">
                                            function generateTransferData(){
                                            var transferSupplier = $('#transferSupplier').val();
                                            var fromDate = $('#fromDate').val();
                                            var toDate = $('#toDate').val();
                                            var transferDestination = $('#transferDestination').val();
                                            var withRate = $('#withRate').val();

                                            $('#loadtransferData').load('downloadtransportData.php?action=searchTransportationData&transferSupplier='+encodeURI(transferSupplier)+'&fromDate='+encodeURI(fromDate)+'&toDate='+encodeURI(toDate)+'&transferDestination='+encodeURI(transferDestination)+'&withRate='+encodeURI(withRate));
                                            }
                                            </script>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

    </td>
    <style>
                .downloadMainData {
                width: 62%;
                height: auto;
                position: absolute;
                background-color: #f8f8f8;
                border: 1px solid #233a49;
                top: 74px;
                right: 10%;
                padding: 10px;
                }
                #cntRows{
                font-size: 14px;
                padding: 0 0 20px 0;
                } #downloadBtn{
                margin-top: 15px;
                text-align: center;
                border-top: 1px dashed;
                padding: 10px 0;
                }
                .donwlArrowBox{
                width: 20px;
                height: 20px;
                border: 0px;
                border-top: 1px solid #233a49;
                border-left: 1px solid #233a49;
                position: absolute;
                right: 41%;
                top: -12px;
                transform: rotate(
                45deg);
                background-color: #f8f8f8;
                }
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
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
                font-size: 12px;
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
                width: 200px;
                background-color: #FFFFFF;
                border-bottom: 1px solid #cccccc30;
                }
                .dropdown-content a:hover {
                background-color: #ddd;
                }
                .dropdown:hover .dropdown-content {
                display: block;
                overflow: auto;
                height: 200px;
                }
                .dropdown:hover .dropbtn {
                background-color: #3e8e41;
                }
                </style>

    <!-- Download Data End -->



		<td  ><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
		<td  ><div class="dropdown">
		<style	>
		.dropdown:hover .dropdown-content {display: block;overflow: auto;
    height: 200px;}
		</style>
  <button class="dropbtn" type="button"><i class="fa fa-bug" aria-hidden="true"></i> View Logs</button>
  <div class="dropdown-content"> 
  	<?php   
  	$dirname =  'log_transport/'; 
	$images = scandir($dirname);
	krsort($images);
	foreach (array_slice($images, 0, 20) as $file) {
    if (substr($file, -4) == ".log" ) {
        ?>
		<a href="<?php echo $fullurl; ?>log_transport/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
		<?php  
    }
}
 ?>
  </div>
</div><style>
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
    font-size: 12px;
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
	width: 200px;
	background-color: #FFFFFF;
	border-bottom: 1px solid #cccccc30;


}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style></td>
		<td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo 'Transportation';//$pageName; ?>" onclick="masters_alertspopupopen('action=addedit_packagetransfermaster&sectiontype=<?php echo clean($_GET['module']); ?>&trnsType=transportation','600px','auto');" />      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="delete_<?php echo clean($_GET['module']); ?>" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
       <th width="2%" align="left" class="header">Sr.</th>
       <th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
       <label for="checkAll"><span></span>&nbsp;</label>
      </th> 
      <th align="left" class="header sorting" width="10%">Transport Code</th>
      <th width="22%" align="left" class="header" >Transport Name </th> 
	  <th width="11%"  align="left" class="header" >Destinations</th>
	  <th width="30%"  align="left" class="header" >Detail</th>
	 <th width="16%"  align="center" class="header" >Rate&nbsp;Sheet </th>
	  <th width="9%"  align="left" class="header" >Status</th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php

  // update vehicle type if not exist
  $rs22='';
  $rs22=GetPageRecord('id,vehicleModelId',_DMC_TRANSFER_RATE_MASTER_,' 1 and vehicleTypeId=0 ');
  while($dmcroommastermain=mysqli_fetch_array($rs22)){
    if($dmcroommastermain['vehicleModelId']>0 ){
      $rsv="";
      $rsv=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$dmcroommastermain['vehicleModelId'].'"');
      $vehicleDetails=mysqli_fetch_array($rsv);

      $where=' id="'.$dmcroommastermain['id'].'"';
      $namevalue =' vehicleTypeId="'.$vehicleDetails['carType'].'"';
      $update = updatelisting(_DMC_TRANSFER_RATE_MASTER_,$namevalue,$where);
    }
  }



$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);

if(trim($_GET['keyword'])!=''){
	 
	$destQuery=GetPageRecord('*',_DESTINATION_MASTER_,' name like "%'.trim($_GET['keyword']).'%"'); 
	if(mysqli_num_rows($destQuery) > 0){
		$destData=mysqli_fetch_array($destQuery); 
		$destinationId = $destData['id'];
	}
	 
	$wheresearch=' and ( transferName like "%'.trim($_GET['keyword']).'%" or find_in_set("'.trim($destinationId).'",destinationId) or transferDetail like "%'.trim($_GET['keyword']).'%" )'; 
}else{
	$wheresearch=' and transferName!="" ';
}

if($_GET['status']!=''){
    $wheresearch2=' and status="'.clean($_GET['status']).'" ';
}
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].')';  
 
$where='where 1 and transferCategory="transportation" and deletestatus=0 '.$wheresearch.$wheresearch2.' order by id desc'; 
$page=$_GET['page']; 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_PACKAGE_BUILDER_TRANSFER_MASTER,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);
$dest='';
?>
  <tr>
    <td width="2%"><?=$no?></td>  
  	<td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>

    <td align="center"><?php  echo $serviceCode = makeServiceCode('TPT',$resultlists['displayId']);  ?></td>

    <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_packagetransfermaster&id=<?php echo $resultlists['id']; ?>&trnsType=transportation','600px','auto');" ><?php echo $resultlists['transferName']; ?></div>   </td>
    
    <?php  
    if ($resultlists['destinationId']!=0){ ?>
    <td align="left">
        <?php 
        $destinationId = explode(',',$resultlists['destinationId']);
        foreach($destinationId as $val){ $dest.= getDestination($val).', '; } 
        echo rtrim($dest,', ');
        ?>
    </td>
    <?php }elseif($resultlists['destinationId'] == 0) { ?>
        <td align="left">All</td>  
    <?php  } ?>
	<td align="left"><?php echo stripslashes(nl2br($resultlists['transferDetail'])); ?></td>
	<!--<td align="left"><?php if($resultlists['status']==1){ echo 'Active';}else{ echo 'Inactive';} ?></td>-->
	
	<td align="center"><a href="showpage.crm?module=packageTransportmaster&supplier=1&transferid=<?php echo encode($resultlists['id']); ?>&view=yes"><input name="addnewuserbtn" type="button" class="bluembutton" value="+ Add Rate"/></a></td>
	<td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green; "><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content;  color: red; "><?php echo 'In Active';?></div><?php }  ?>
	</td>
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
 <input name="importpackagetransPort" id="importpackagetransPort" type="hidden" value="Y" /> <input name="importpackagetransPortModule" id="importpackagetransPortModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
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
<?php  } ?>

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