<?php include 'activityshorting.php'; ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['page']=='addGallery' && $_REQUEST['activityId']!='' ) { ?>
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
                                if($_REQUEST['activityId']!=''){  
                                    $hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.($_REQUEST['activityId']).'"'); 
                                    $hotelData2=mysqli_fetch_array($hotelQuery);
                                    echo $hotelData2['otherActivityName'];
                                }
                                ?></span>
                                <div id="deactivatebtn" style="display:none;left: 90px;">
                                    <?php if($deletepermission==1){ ?>
                                    <input name="deactivate" type="button" class="redmbutton" id="deactivate"
                                    value="Deactivate"
                                    onclick="masters_alertspopupopen('action=deleteGalleryPhoto&name=Activity','600px','auto');" />
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
                                        onclick="masters_alertspopupopen('action=addeditGallery&galleryType=activity&parentId=<?php echo $_REQUEST['activityId'];?>&module=<?php echo $_REQUEST['module'];?><?php echo ($_REQUEST['page']!='')? '&page='.$_REQUEST['page']:'';?>','800px','auto');" />
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
                value="<?php echo $_GET['module'];echo ($_GET['activityId'] !='')?'&page=addGallery&activityId='.$_GET['activityId']:''; ?>" />
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
                        
                        $where='where parentId = "'.$_REQUEST['activityId'].'" and galleryType="activity" and deleteStatus=0  order by id desc';
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
                      $('#loadDocFilesList').DataTable({
                        "paging": false,
                        "ordering": true,
                        "info": false,
                        "searching": true,
                        "order": [
                          [3, 'desc']
                        ]
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
              <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" >
              <input type="button" name="Submit22" value="Back" class="whitembutton" /> 
              </a>
            </td>
            <td><div class="headingm" style="margin-left:5px;"><span id="topheadingmain"><?php echo 'Sightseeing';//$pageName; ?></span>
            <div id="deactivatebtn" style="display:none;">
              <?php if($deletepermission==1){ ?>
              <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Activity&nbsp;Master','600px','auto');" />
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
                  <?php   $dirname =  'log_sightseeing/';
                  $images = scandir($dirname);
                  krsort($images);
                  foreach (array_slice($images, 0, 20) as $file) {
                  if (substr($file, -4) == ".log" ) {
                  ?>
                  <a href="<?php echo $fullurl; ?>log_sightseeing/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
                  <?php
                  }
                  }
                  ?>
                </div>
              </div>
            </td>
            <td>
              <div class="dropdown">
                <button class="dropbtn" type="button" style="margin-right: 10px!important;padding: 10px!important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</button>
                <div class="dropdown-content downloadActivityImportDiv" style="height: 71px!important;">
                  <a href="<?php echo $fullurl; ?>travrmimports/activity-import-format.xls?=<?php echo time(); ?>" class="downloadActivityImport"  style="">Download Sightseeing Import Formate</a>
                  <a href="<?php echo $fullurl; ?>travrmimports/activity_language_formate.xls" class="downloadActivityLanguageImport"  style="">Download Sightseeing Language Import Formate</a>
                </div>
              </div>
            </td>
            <td>
              
              <div class="dropdown">
                <button class="dropbtn" type="button" style="margin-right: 10px!important;padding: 10px!important;"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</button>
                <div class="dropdown-content importActivityImportDiv" style="height: 71px!important;">
                  <a class="importActivityImport" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Sightseeing Rate Sheet Excel</a>
                  <a class="importActivityLanguageImport" id="importbuttonlan"><i class="fa fa-upload" aria-hidden="true"></i> Import Sightseeing Language Excel</a>
                  
                </div>
              </div>
            </td>
            <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td>
            <td style="boarder-radius:10%">
              <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->
              <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">
                <option value=""> Select  Status &nbsp;</option>
                
                <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>
                
                <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>InActive</option>
                
              </select>
            </td>
            <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
            <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Sightseeing" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" /></td>
          </tr>
          
        </table></td>
      </tr>
      
    </table>
  </div>
  <div id="pagelisterouter" style="padding-left:30px;">
    <input name="action" id="action" type="hidden" value="delete_otherActivityMaster" />
    <input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">
      <thead>
        <tr>
          <th width="4%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onClick="checkallbox();" /><?php } ?>
          <label for="checkAll"><span></span>&nbsp;</label>
        </th>  
        <th width="15%" align="center" class="header" >Sightseeing Code</th>
        <th width="15%" align="center" class="header" >Image</th>
        <th width="30%" align="left" class="header" >Sightseeing&nbsp;Name</th>
        <th width="8%"  align="left" class="header" >Destination</th>
        <th width="30%"  align="left" class="header" >Description</th>
        <th width="6%"  align="left" class="header" >Status</th>
        <th width="10%"  align="left" class="header" >Language</th>
        <th width="10%"  align="left" class="header" >Gallery</th> 
        <th width="10%"  align="left" class="header" >Rate&nbsp;Sheet</th>
        
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
      if($_GET['keyword']!=''){
          $wheresearch=" and ( otherActivityName like '%".trim($_GET['keyword'])."%' or otherActivityCity like '%".trim($_GET['keyword'])."%' )";
      }
      if($_REQUEST['status']!=''){
        $wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
      }
      $where='where  otherActivityName!="" '.$wheresearch.''.$wheresearch2.' and deletestatus=0 order by status desc,otherActivityCity asc';
      $page=$_GET['page'];
      $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&';
      $rs=GetRecordList($select,_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where,$limit,$page,$targetpage);
      $totalentry=$rs[1];
      $paging=$rs[2];
      while($resultlists=mysqli_fetch_array($rs[0])){

        $imgQuery = GetPageRecord('*','imageGallery','parentId="'.$resultlists['id'].'" and galleryType="activity" and fileId in (select id from documentFiles where fileDimension="380x246" and deletestatus="0") order by fileId desc');
        $galleryData = mysqli_fetch_assoc($imgQuery);
       $filePath = geDocFileSrc($galleryData['fileId']);
      ?>
      <tr>
      <td align="center"><?php  echo $serviceCode = makeServiceCode('AC',$resultlists['displayId']);  ?></td>

        <td width="4%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>" />
        <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
      </td> 

      <td align="center"><?php if($galleryData['fileId']!='' && file_exists($filePath)){ ?><img src="<?php echo $fullurl.$filePath; ?>" width="75" height="58" /><?php }else{ ?> <div style="height: 60px;width:75px; padding:3px; border-radius:3px; background:#CCCCCC;"><div style="margin: auto; font-size: 13px; color: #666666; margin-top: 20px; text-align: center;">No Image</div></div> <?php } ?></td>

      <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>&sectiontype=<?=clean($_GET['module'])?>','600px','auto');" ><?php echo $resultlists['otherActivityName']; ?></div>
    </td>
    <td align="left"><?php echo $resultlists['otherActivityCity']; ?></td>
    <td align="left"><?php echo substr(strip($resultlists['otherActivityDetail']),0,100); ?>...</td>
    <td width="5%" align="left"><?php if($resultlists['status']==1){?>
      <div style=" width: fit-content;  color: green; "><?php echo 'Active';?></div><?php } else { ?>
      <div style=" width: fit-content;  color: red; "><?php echo 'In Active';?></div><?php }  ?>
    </td>
  
    <td  align="left"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=addedit_queryActivityLanguage&id=<?php echo $resultlists['id']; ?>&sectiontype=queryActivity&moduleName=<?php echo $_REQUEST['module']; ?>','800px','auto');"></td>
    
    <!-- &destinationName=<?php echo $resultlists['otherActivityCity']; ?> -->
    <td align="center">
      <a href="showpage.crm?module=<?php echo clean($_GET['module']); ?>&page=addGallery&activityId=<?php echo $resultlists['id']; ?>">
        <input name="addnewuserbtn" type="button" class="bluembutton" value="+&nbsp;Gallery" /></a>
    </td>
    <td align="center"><a href="showpage.crm?module=<?php echo $_REQUEST['module'];?>&amp;keyword=<?php echo $_REQUEST['keyword'];?>&amp;view=yes&amp;otherActivityNameId=<?php echo encode($resultlists['id']);?>"><input name="addnewuserbtn" type="button" value="+ Add/View" class="bluembutton"></a></td>
    
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
<input name="importotherActivity" id="importotherActivity" type="hidden" value="Y" /> <input name="importimportotherActivityModule" id="importimportotherActivityModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>
</form>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrmlan" id="importfrmlan"  target="actoinfrm" style="display:none;">
<input name="importActivityLanguageMaster" id="importActivityLanguageMaster" type="hidden" value="Y" /> <input name="importActivityLanguageMasteModule" id="importActivityLanguageMasteModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<div id="filefieldhere"><input name="importfieldlan" type="file" id="importfieldlan" accept="application/vnd.ms-excel" onChange="submitimportfromlan();" /></div>
</form>
<script>
function submitimportfromlan(){
startloading();
$('#importfrmlan').submit();
var filesizes = $("#importfieldlan")[0].files[0].size;
filesizes=Number(filesizes/1024);
if(filesizes>11){
}
}
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
$('#importbuttonlan').click(function(){
$('#importfieldlan').click();
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
$(document).ready(function() {
$('#mainsectiontable').DataTable( {
"paging":   false,
"ordering": true,
"info":     true,
"searching": false,
"order": [[ 4, 'asc' ]]
} );
} );
$(function() {
var $list = $("#list");
$list.children().detach().sort(function(a, b) {
return $(a).text().localeCompare($(b).text());
}).appendTo($list);
});
</script>
<?php } ?>