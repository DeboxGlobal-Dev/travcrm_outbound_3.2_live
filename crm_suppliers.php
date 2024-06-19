<?php
$searchField=clean($_GET['searchField']);
?>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style>
.col-md-6 {  display: none !important;}
#pagelisterouter{ padding:10px !important; padding-top: 130px !important;}
body{overflow-x:hidden !important;}
.header{font-weight: 500 !important; font-size: 13px !important;}
#mainsectiontable .fa-pencil-square{cursor: pointer;
    font-size: 20px;
    color: #ff5c00;
	}

</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Company','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td>&nbsp;</td>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><input name="searchField" type="text" value="<?php echo $searchField; ?>"  class="topsearchfiledmain" id="searchField" placeholder="Enter Supplier, Contact, Email, Destination" style="width:88%"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
          <select name="suppliertype" id="suppliertype" class="topsearchfiledmainselect" style="width:160px; " >
            <option value="">All Supplier Type</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus!=1 order by name asc';  
$rs=GetPageRecord($select,_SUPPLIERS_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['suppliertype']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?></option>
			<?php } ?>
          </select> </td>
          <td>

            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->

        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">



          <option value=""> Select  Status &nbsp;</option>

    

          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>

    

          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>

    

        </select>

        </td>

   
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table></td>
        <td  ><a href="<?php echo $fullurl; ?>travrmimports/supplier-import-Format.xls?t=<?php echo time(); ?>" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a></td>
		<td  ><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
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

.dropdown:hover .dropdown-content {display: block;overflow: auto;
    height: 200px;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
		<td style="padding-right:20px;"><div class="dropdown">
  <button class="dropbtn" type="button"><i class="fa fa-bug" aria-hidden="true"></i> View Logs</button>
  <div class="dropdown-content"> 
  <?php   $dirname =  'Supplier_Log/'; 
$images = scandir($dirname);
krsort($images);
foreach (array_slice($images, 0, 20) as $file) {
    if (substr($file, -4) == ".log" ) {
        ?>
		<a href="<?php echo $fullurl; ?>Supplier_Log/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
		<?php  
    }
}
 ?>
    
  </div>
</div>
</td>
		<td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="add();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="suppliersdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="mainsectiontable" class="table table-striped table-bordered">

   <thead>

   <tr>
     <th width="1%" align="left" class="header" >&nbsp;</th>
     <th width="6%" align="left" class="header" >No.</th>
     <th width="10%" align="left" class="header" >Name</th>
     <th width="15%" align="left" class="header" >Alias Name</th>
      <th width="13%" align="left" class="header" >Type</th>
      <th width="8%" align="left" class="header" >Destination</th>
     <th width="11%" align="left" class="header">Contact&nbsp;Person</th>
     <th width="9%" align="left" class="header">Located  </th>

     <th width="8%" align="left" class="header">Contact&nbsp;No.</th>
     <th width="15%" align="left" class="header">	Email&nbsp;Id</th>
     <!-- <th width="8%" align="left" class="header " style="display:none;">assign To </th> -->
     <th width="12%" align="left" class="header " >&nbsp;</th>

     <th width="12%" align="left" class="header " >Status</th>
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

$mainwhere=' and ( name like "%'.$searchField.'%" or cityId in  ( select id from  '._CITY_MASTER_.' where name like "%'.$searchField.'%"  ) or stateId in ( select id from  '._STATE_MASTER_.' where name like "%'.$searchField.'%"  ) or id in ( select corporateId from  suppliercontactPersonMaster where contactPerson like "%'.$searchField.'%" or phone like "%'.encode($searchField).'%"  or email like "%'.encode($searchField).'%"  ) ) ';
}

$assignto='';
if($_GET['assignto']!=''){
    $assignto=' and	assignTo='.$_GET['assignto'].'';
}


if($_REQUEST['status']!=''){



	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
}
 
$suppliertype='';
if($_GET['suppliertype']!=''){
$assignto=' and	companyTypeId='.$_GET['suppliertype'].' or transferType='.$_GET['suppliertype'].' or activityType='.$_GET['suppliertype'].' or airlinesType='.$_GET['suppliertype'].' or trainType='.$_GET['suppliertype'].' or guideType='.$_GET['suppliertype'].' or entranceType='.$_GET['suppliertype'].' or otherType='.$_GET['suppliertype'].' or mealType='.$_GET['suppliertype'].'';
}
 
   
  
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
 
 
 
$where='where '.$wheresearch.' '.$wheresearch2.' and name!="" '.$assignto.' and deletestatus=0 order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];

$rsss=GetPageRecord('*','suppliercontactPersonMaster',' corporateId='.$resultlists['id'].' and contactPerson!="" and deletestatus=0 order by id asc'); 
$resListing=mysqli_fetch_array($rsss);
?>
  <tr>
    <td width="1%" align="left"><?php if($editpermission==1){ ?><i class="fa fa-pencil-square" aria-hidden="true" onclick="edit('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
	<?php } ?></td>
    <td align="left"><?php 
	$spNum = 'S'.str_pad($supplr_id, 6, '0', STR_PAD_LEFT); 
	$namevalue ='supplierNumber="'.$spNum.'"';  
	$where='id="'.$supplr_id.'"';  
	$update = updatelisting(_SUPPLIERS_MASTER_,$namevalue,$where);
	 
	echo strip($resultlists['supplierNumber']); ?></td>



    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');" style="font-weight:500; color:#45b558 !important;"><?php echo strip($resultlists['name']); ?> </div></td>
    <!-- new added code Alias Name -->
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');" style="font-weight:500; color:#45b558 !important;"><?php echo strip($resultlists['aliasname']); ?> </div></td>

    <td align="left"><?php echo getsuppliersTypeNameList($resultlists['id']); ?><?php if($resultlists['otherType']==13){ ?>, Other<?php } ?></td>
    <td align="left">
      <div style="width: auto; display: block; overflow: auto;">
        <?php 
        if ($resultlists['destinationWise'] == 1 && $resultlists['destCountryId'] > 0) { 
          echo 'All Destination of '.getCountryName($resultlists['destCountryId']); 
        }elseif ($resultlists['destinationWise'] == 2) { 
          echo 'All Destination'; 
        }elseif ($resultlists['destinationWise'] == 0) {
          $destStr = '';
          $destinationArray = array_unique(explode(',',strval($resultlists['destinationId'])));
          // $destinationArray = 'Agra,Mumbai,Delhi,Delhi,Colombo,Vaishali,Bodh Gaya,Delhi,Delhi,Gold Coast,Jaipur,Agra,Delhi,Goa,Delhi,Goa,Goa,Goa';
          foreach($destinationArray as $destId){
            $destStr.= getDestination($destId).','; 
          }
          echo rtrim($destStr,',');
        }
        ?>
  </div></td>
    <td align="left"><?php echo strip($resListing['contactPerson']); ?></td>
    <!-- <td align="left"><?php //echo getCityName($resultlists['cityId']); ?>, <?php //echo getStateName($resultlists['stateId']); ?>, <?php //echo getCountryName($resultlists['countryId']); ?></td> -->
    <td align="left">
      <?php 
      if(!empty($resultlists['cityId'])){ echo getCityName($resultlists['cityId']); }
      // else { echo getcity($supplr_id); } ?>,
      <?php if(!empty($resultlists['stateId'])){ echo getStateName($resultlists['stateId']);} 
      //else{ echo getstate($supplr_id); } ?>,
      <?php if(!empty($resultlists['countryId'])){ echo getCountryName($resultlists['countryId']);}
      // else { echo getcountry($supplr_id); }
       ?>
    </td>
    <td align="left">
        <span id="shownumId<?php echo $resultlists['id']; ?>" class="shownumclass<?php echo $resultlists['id']; ?>"><?php echo maskPhone(decode($resListing['phone'])); ?></span> 

        <span id="hidenumId<?php echo $resultlists['id']; ?>" class="hidenumclass<?php echo $resultlists['id']; ?>"  style="display: none;"><?php echo $resListing['countryCode'].'-'.decode($resListing['phone']); ?></span>
    </td>
	
    <td align="left" style="max-width:150px !important; overflow-wrap: anywhere;">
        <span id="shwoemailid<?php echo $resultlists['id']; ?>" class="showemailclass" ><?php echo maskEmail(decode($resListing['email'])); ?></span>

	    <span id="hideemailid<?php echo $resultlists['id']; ?>" class="hideemailclass"  style="display: none;"> <?php echo decode($resListing['email']); ?></span>
    </td>
	
    <!-- <td align="left" style="display:none;"><?php echo getUserName($resultlists['assignTo']); ?></td> -->
    <td align="left" >
        <a onclick="
        // $('.shownumclass').hide();
        // $('.hidenumclass').show();
        $('#shownumId<?php echo $resultlists['id'];?>').toggle();
        $('#hidenumId<?php echo $resultlists['id'];?>').toggle();
        // $('.hideemailclass').show();
        // $('.showemailclass').hide();
        $('#hideemailid<?php echo $resultlists['id'];?>').toggle();
        $('#shwoemailid<?php echo $resultlists['id'];?>').toggle();"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a>
    </td>
    
  <td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green; "><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content; color: red; "><?php echo 'In Active';?></div><?php }  ?>

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
 <input name="importsupplierexcel" id="importsupplierexcel" type="hidden" value="Y" /> 
 <div id="filefieldhere">
  <input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>
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
        "info":     true
    } );
} );
</script>