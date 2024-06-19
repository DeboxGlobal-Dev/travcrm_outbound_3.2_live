<?php $statuswise = $_GET['statuswise'];
include 'tableSorting.php';


?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['page']=='addGallery' && $_REQUEST['entranceId']!='' ) { ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td width="91%" align="left" valign="top">
        <form id="listform" name="listform" method="get">
            <div class="rightsectionheader">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="headingm" style="margin-left:10px;">
                                <a name="addnewuserbtn"
                                    href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input
                                type="button" name="Submit22" value="Back" class="whitembutton"> </a>
                                <span id="topheadingmain"><?php 
                                if($_REQUEST['entranceId']!=''){  
                                    $hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.($_REQUEST['entranceId']).'"'); 
                                    $hotelData2=mysqli_fetch_array($hotelQuery);
                                    echo $hotelData2['entranceName'];
                                }
                                ?></span>
                                <div id="deactivatebtn" style="display:none;left: 90px;">
                                    <?php if($deletepermission==1){ ?>
                                    <input name="deactivate" type="button" class="redmbutton" id="deactivate"
                                    value="Deactivate"
                                    onclick="masters_alertspopupopen('action=deleteGalleryPhoto&name=Entrance','600px','auto');" />
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                        <td align="right">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td></td>
                                    <?php if($addpermission==1){ ?>
                                    <td style="padding-right:20px;">
                                        <a href=""></a>
                                    </td>
                                    <?php } ?>
                                    <?php if($importpermission==1){ ?>
                                    <input type="button" name="Submit" value="Import" class="whitembutton"
                                    style="display: none;" />
                                    <?php } ?>
                                    <td>
                                    </td>
                                    <!-- load alert box for destination -->
                                    <?php if($addpermission==1){ ?>
                                    <td style="padding-right:20px;">
                                        <input name="addnewuserbtn" type="button" class="bluembutton"
                                        id="addnewuserbtn" value="+ Add Images"
                                        onclick="masters_alertspopupopen('action=addeditGallery&galleryType=entrance&parentId=<?php echo $_REQUEST['entranceId'];?>&module=<?php echo $_REQUEST['module'];?><?php echo ($_REQUEST['page']!='')? '&page='.$_REQUEST['page']:'';?>','800px','auto');" />
                                    </td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="pagelisterouter" style="padding-left:20px;">
                <input name="action" id="action" type="hidden" value="deleteGalleryPhoto" />
                <input name="backpage" id="backpage" type="hidden"
                value="<?php echo $_GET['module'];echo ($_GET['entranceId'] !='')?'&page=addGallery&entranceId='.$_GET['entranceId']:''; ?>" />
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="loadDocFilesList">
                    <thead>
                        <tr>
                            <th width="2%" align="center" valign="middle" class="header">
                                <?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"
                                name="checkedAll" onclick="checkallbox();" /><?php } ?>
                                <label for="checkAll"><span></span>&nbsp;</label>
                            </th>
                            <th width="20%" align="left" class="header">Name </th>
                            <th width="15%" align="left" class="header">Image</th>
                            <th width="20%" align="left" class="header">Created On</th>
                            <th align="left" class="header">Created By</th>
                            <th align="left" class="header">Status</th>
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
                        
                        $where='where parentId = "'.$_REQUEST['entranceId'].'" and galleryType="entrance" and deleteStatus=0  order by id desc';
                        $page=$_GET['page'];
                        
                        $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';
                        $rs=GetRecordList($select,'imageGallery',$where,$limit,$page,$targetpage);
                        $totalentry=$rs[1];
                        $paging=$rs[2];
                        while($resultlists=mysqli_fetch_array($rs[0])){
                        ?>
                        <tr>
                            <td align="center" valign="middle"><?php if($editpermission==1){ ?><input
                                type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"
                                value="<?php echo encode($resultlists['id']); ?>" />
                                <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
                            </td>
                            <td align="left">
                                <?php echo geDocFileName($resultlists['fileId']); ?>
                            </td>
                            <td align="left">
                                <?php 
                                if($resultlists['fileId']!='0'){ ?>
                                <a href="<?php echo geDocFileSrc($resultlists['fileId']); ?>" target="_blank" >
                                <img src="<?php echo geDocFileSrc($resultlists['fileId']); ?>" width="75" height="58"/>
                                </a>
                                <?php }else{ ?>
                                <div style="height: 60px;width:75px; padding:3px; border-radius:3px; background:#CCCCCC;"><div style="margin: auto; font-size: 13px; color: #666666; margin-top: 20px; text-align: center;">No Image</div></div>
                                <?php
                                }
                                ?>
                            </td>
                            <td valign="middle" align="left" ><?php if($resultlists['dateAdded']!=0){ echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat); } else{ echo '--'; }?></td>
                            <td align="left" ><?php echo getUserName($resultlists['addedBy']); ?></td>
                            <td align="left" ><?php echo ($resultlists['deletestatus']==1)?'Inactive':'Active'; ?></td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                <?php if($no==1){ ?>
                <div class="norec">No <?php echo $pageName; ?></div>
                <?php } ?>
                <script type="text/javascript">
                    $(document).ready(function() {
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
                      $('#loadDocFilesList').DataTable({
                        "paging": false,
                        "ordering": true,
                        "info": false,
                        "searching": true,
                        "order": [
                          [3, 'desc']
                        ]
                      });
                    });
                </script>
                <div class="pagingdiv">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
                                            <td><select name="records" id="records" onchange="this.form.submit();"
                                                class="lightgrayfield">
                                                <option value="25" <?php if($_GET['records']=='25'){ ?>
                                                selected="selected" <?php } ?>>25 Records Per Page</option>
                                                <option value="50" <?php if($_GET['records']=='50'){ ?>
                                                selected="selected" <?php } ?>>50 Records Per Page</option>
                                                <option value="100" <?php if($_GET['records']=='100'){ ?>
                                                selected="selected" <?php } ?>>100 Records Per Page</option>
                                                <option value="200" <?php if($_GET['records']=='200'){ ?>
                                                selected="selected" <?php } ?>>200 Records Per Page</option>
                                                <option value="300" <?php if($_GET['records']=='300'){ ?>
                                                selected="selected" <?php } ?>>300 Records Per Page</option>
                                            </select></td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="right">
                                    <div class="pagingnumbers"><?php echo $paging; ?></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </td>
</tr>
</table>
<?php
} else { ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
      <form id="listform" name="listform" method="get">
        <div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="7%">
              <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>
            </td>
            <td><div class="headingm" style="margin-left:5px;"><span id="topheadingmain"  width="3%"><?php echo 'Monument';//$pageName; ?></span>
            <div id="deactivatebtn" style="display:none;">
              <?php if($deletepermission==1){ ?>
              
              <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Entrance','600px','auto');" />
              <?php } ?>
            </div>
            
          </div></td>
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
              <td ><div class="dropdown">
                <button class="dropbtn" type="button"><i class="fa fa-bug" aria-hidden="true"></i> View Logs</button>
                <div class="dropdown-content">
                  <?php   $dirname =  'log_entrance/';
                  $images = scandir($dirname);
                  krsort($images);
                  foreach (array_slice($images, 0, 20) as $file) {
                  if (substr($file, -4) == ".log" ) {
                  ?>
                  <a href="<?php echo $fullurl; ?>log_entrance/<?php echo $file; ?>" target="_blank"><?php echo $file ; ?></a>
                  <?php
                  }
                  }
                  ?>
                </div>
              </div></td>
              <td>
                <div class="dropdown">
                  <button class="dropbtn" type="button" style="margin-right: 10px!important;padding: 10px!important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</button>
                  <div class="dropdown-content" style="height: 71px!important;">
                    <a href="<?php echo $fullurl; ?>travrmimports/entance-import-format.xls?t=<?php echo time(); ?>" class=""  style="">Download Monument Rate Sheet Format</a>
                    <a href="<?php echo $fullurl; ?>travrmimports/entrance_language_formate.xls?t=<?php echo time(); ?>" class=""  style="">Download Monument Language Info Format</a>
                  </div>
                </div>
              </td>
              
              <td>
                
                <div class="dropdown">
                  <button class="dropbtn" type="button" style="margin-right: 10px!important;padding: 10px!important;"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</button>
                  <div class="dropdown-content" style="height: 71px!important;">
                    <a class="" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Monument Rate Sheet Excel</a>
                    <a class="" id="importbuttonlan"><i class="fa fa-upload" aria-hidden="true"></i> Import Monument Language Excel</a>
                    
                  </div>
                </div>
              </td>
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
              
              <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Monument" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" /></td>
            </tr>
            
          </table></td>
        </tr>
        
      </table>
    </div>
    <div id="pagelisterouter" style="padding-left:0px;">
      <input name="action" id="action" type="hidden" value="deleteinterencemaster" />
      <input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
      <!-- <table border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">
         -->
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">
        <thead>
        
          <tr>
            <th width="2%" align="left" class="header sorting ">Sr.</th>
            <th width="4%" align="center" valign="middle" class="header sorting" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
            <label for="checkAll"><span></span>&nbsp;</label></th>
            <th align="left" class="header sorting" width="250">Monument Code</th>
            <th align="left" class="header sorting" width="109">Photo</th>
            <th align="left" class="header sorting" width="256">Monument&nbsp;Name </th>
            <th  align="left" class="header sorting" width="89">Destination </th>
            <th  align="left" class="header sorting" width="424">Detail</th>
            <th  align="left" class="header sorting" width="254" style="display:none;">Price</th>
            <th  align="left" class="header sorting" width="80">Status</th>
            <th  align="left" class="header sorting" width="80">Language</th>
            <th  align="left" class="header sorting" width="80">Gallery</th>
            <th  align="left" class="header sorting" width="80">Rate&nbsp;Sheet</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no=1;
          $select='*';
          $where='';
          $rs='';
          $limit=clean($_GET['records']);
          $wheresearch='';
          if($_GET['keyword']!=''){
            $wheresearch=' and ( entranceName like "%'.trim($_GET['keyword']).'%" or entranceCity like "%'.trim($_GET['keyword']).'%" )  ';
          }
          if($_REQUEST['status']!=''){
            $wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
          }
          $where='where  entranceName!=""  '.$wheresearch.' '.$wheresearch2.' and deletestatus=0 order by entranceName asc';
          $page=$_GET['page'];
          $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&';
          $rs=GetRecordList($select,_PACKAGE_BUILDER_ENTRANCE_MASTER_,$where,$limit,$page,$targetpage);
          $totalentry=$rs[1];
          $paging=$rs[2];
          while($resultlists=mysqli_fetch_array($rs[0])){
          
          
          $dateAdded=clean($resultlists['dateAdded']);
          $modifyDate=clean($resultlists['modifyDate']);

          $imgQuery = GetPageRecord('*','imageGallery','parentId="'.$resultlists['id'].'" and galleryType="entrance" and fileId in (select id from documentFiles where fileDimension="380x246" and deletestatus="0") order by fileId desc');
          $galleryData = mysqli_fetch_assoc($imgQuery);
         $filePath = geDocFileSrc($galleryData['fileId']);
          // echo $filePath = geDocFileName($galleryData['fileId']);

          ?>
          <tr>
            <td width="2%"><?= $no ?></td>
            <td width="4%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
            <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
          </td>
          <td align="center"><?php  echo $serviceCode = makeServiceCode('MU',$resultlists['displayId']);  ?></td>
          <td align="left"><?php if($galleryData['fileId']!='' && file_exists($filePath)){ ?><img src="<?php echo $fullurl.$filePath; ?>" width="75" height="58" /><?php }else{ ?> <div style="height: 60px;width:75px; padding:3px; border-radius:3px; background:#CCCCCC;"><div style="margin: auto; font-size: 13px; color: #666666; margin-top: 20px; text-align: center;">No Image</div></div> <?php } ?></td>


         
          <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','600px','auto');" ><?php echo $resultlists['entranceName']; ?></div>   </td>
          
          <td align="left"><?php echo $resultlists['entranceCity']; ?></td>
          <td align="left"><?php echo substr(strip($resultlists['entranceDetail']),0,200); ?></td> 

          <td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green;"><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content;  color: red; "><?php echo 'In Active';?></div><?php }  ?></td>

          <td  align="left"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=addedit_queryEntranceLanguage&id=<?php echo $resultlists['id']; ?>&destinationName=<?php echo $resultlists['entranceCity']; ?>&sectiontype=queryEntrance&moduleName=<?php echo $_REQUEST['module']; ?>','800px','auto');"></td>
          <td align="center">
            <a href="showpage.crm?module=<?php echo clean($_GET['module']); ?>&page=addGallery&entranceId=<?php echo $resultlists['id']; ?>">
              <input name="addnewuserbtn" type="button" class="bluembutton" value="+&nbsp;Gallery" /></a>
          </td>
          <td align="left">
            <a href="showpage.crm?module=<?php echo $_REQUEST['module'];?>&amp;view=yes&amp;entranceId=<?php echo encode($resultlists['id']);?>">
            <input name="addnewuserbtn" type="button" value="+ Add/View" class="bluembutton">
            </a>
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
    </div></form> </td>
  </tr>
</table>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">
  <input name="importpackageentrance" id="importpackageentrance" type="hidden" value="Y" /> 
  <input name="importpackageentranceModule" id="importpackageentranceModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
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
if(filesizes >11 ){
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
 
window.setInterval(function(){
checked = $("#listform td input[type=checkbox]:checked").length;
    
if(!checked) {
  $("#deactivatebtn").hide();
  $("#topheadingmain").show();
}else {
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



</script>
<?php  } ?>



