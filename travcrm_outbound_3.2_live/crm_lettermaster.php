<?php $statuswise = $_GET['statuswise'];
include 'tableSorting.php';
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['supplier']==''){
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
  <form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td> 
    <td><div class="headingm" style="margin-left:5px;"><span id="topheadingmain"  width="3%"><?php echo $pageName; ?></span>
      <div id="deactivatebtn" style="display:none;">
       <?php if($deletepermission==1){ ?> 
      <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=letter','600px','auto');" />
      <?php } ?>
      </div>
      </div>
    </td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
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
          width: 300px;
          background-color: #FFFFFF;
          border-bottom: 1px solid #cccccc30;
        }
        .dropdown-content a:hover {background-color: #ddd;}
        .dropdown:hover .dropdown-content {display: block;overflow: auto;
        height: 200px;}
        .dropdown:hover .dropbtn {background-color: #3e8e41;}
      </style> 
     <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td>
     <td style="boarder-radius:10%">
            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">

          <option value=""> Select  Status &nbsp;</option>
    
          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
    
          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>In Active</option>
    
        </select>
      </td>
      <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
    

    <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Letter Name" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" /></td>  
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">
<input name="action" id="action" type="hidden" value="deleteletter" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
      <th width="2%" align="left" class="header">Sr.</th>
      <th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
       <label for="checkAll"><span></span>&nbsp;</label></th>  
      <th align="left" class="header" width="256">Letter&nbsp;Name </th>
   <th  align="left" class="header" width="80">Status</th>
   <!-- <th  align="left" class="header" width="80">Language</th> -->
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
  $searchMain=1; 
  
  if($_GET['keyword']!=''){
     $wheresearch="and letterName like '%".$_GET['keyword']."%'";
    }
  if($_REQUEST['status']!=''){
    $wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
    } 
  $where='where  letterName!="" and letterType="agentwelcomeLetter" or letterType="plainwelcomeLetter" '.$wheresearch.''.$wheresearch2.' and deletestatus=0 order by id asc';
  
  $page=$_GET['page'];
   
  $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 
  $rs=GetRecordList($select,'letterMaster',$where,$limit,$page,$targetpage); 
  $totalentry=$rs[1]; 
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
    <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','600px','auto');" ><?php echo $resultlists['letterName']; ?></div>   </td>
   <td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green;"><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content;  color: red; "><?php echo 'In Active';?></div><?php }  ?></td>
         
  <!-- <td  align="left"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=addedit_letterLanguage&id=<?php //echo $resultlists['id']; ?>','800px','auto');"></td> -->


      
   
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
</div></form> </td>
  </tr>
</table>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">
 <input name="importpackageentrance" id="importpackageentrance" type="hidden" value="Y" /> <input name="importpackageentranceModule" id="importpackageentranceModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>
 </form>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrmlan" id="importfrmlan"  target="actoinfrm" style="display:none;">


 <input name="importEntranceLanguageMaster" id="importEntranceLanguageMaster" type="hidden" value="Y" /> <input name="importEntranceLanguageMasteModule" id="importEntranceLanguageMasteModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />


 <div id="filefieldhere"><input name="importfieldlan" type="file" id="importfieldlan" accept="application/vnd.ms-excel" onChange="submitimportfromlan();" /></div>

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

function submitimportfromlan(){

startloading();

$('#importfrmlan').submit();

var filesizes = $("#importfieldlan")[0].files[0].size;

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

$('#importbuttonlan').click(function(){
    $('#importfieldlan').click();
});
</script>

<?php  }


if($_REQUEST['supplier']=='1'){ }?>

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


</script>
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
         "order": [[ 0, 'asc' ]]

    } );
} );

</script>