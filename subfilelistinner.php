<?php
include "inc.php";
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];
$folderid = decode($_REQUEST['folderid']);
$id = decode($_REQUEST['id']);
$data = $_REQUEST['subfile'];
if($_GET['dltid']!=''){

  $where=' id='.decode($_GET['dltid']).'';
  deleteRecord(_DOCUMENT_FILES_MASTER_,$where);

  $where2=' fileId='.decode($_GET['dltid']).'';
  deleteRecord(_IMAGE_GALLERY_MASTER_,$where2);

  $filename=$_REQUEST['filename'];
  unlink('dirfiles/'.$filename);
}
?>
<script>
function deletefile(fid,filename){
  var folderView = $('#folderView').val();
  $('#folderouter').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
  $('#folderouter').load('subfilelistinner.php?filename='+filename+'&dltid='+fid+'&id=<?php echo $_REQUEST['id']; ?>&folderid=<?php echo $_REQUEST['folderid']; ?>');
}
function deletealertfile(fid,filename){
  if(confirm("Do you want to delete this file?")){
    deletefile(fid,filename);
  }
}
</script>
<?php
if($thumborlist==2){
  $nod=1;
  $select='*';
  $where='folderId='.$folderid.' and subfolderId='.$id.' order by id asc';
  $rs=GetPageRecord($select,_DOCUMENT_FILES_MASTER_,$where);
  while($folderlist=mysqli_fetch_array($rs)){
  ?>
  <div class="filethumb" onclick="alertspopupopen('action=openDocumentfile&id=<?php echo $folderlist['id']; ?>&folderid=<?php echo $_REQUEST['folderid']; ?>','400px','auto');">
    <img src="<?php echo getFileIcon($folderlist['fileType']); ?>" alt="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>" width="54"    title="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>"/>
    <div class="filename"><?php echo $folderlist['name']; ?></div>
  </div>
  <?php
  }
} else {
  if($folderid!=1){
    ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
      <thead>
        <tr>
          <th width="2%" align="left" class="header">&nbsp;#</th>
          <th width="30%" align="left" class="header">Name </th>
          <th width="15%" align="left" class="header">Uploaded Date </th>
          <th width="15%" align="left" class="header">Uploaded By </th>
          <th width="10%" align="left" class="header">With/Height</th>
          <th width="7%" align="left" class="header">Type</th>
          <th width="7%" align="left" class="header">Size</th>
          <th width="15%" align="left" class="header"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>action </th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no=1;
        $select='*';
        $where='';
        $rs='';
        $wheresearch='';
        $limit='500';
        if($data!=''){
          $data = ' and name like "%'.$data.'%"';
        }
         $where='where deletestatus=0 and folderId='.$folderid.' and subfolderId='.$id.' '.$data.' order by name asc';
        $targetpage=$fullurl.'';
        $rs=GetRecordList($select,_DOCUMENT_FILES_MASTER_,$where,$limit,$page,$targetpage);
        $totalentry=$rs[1];
        $paging=$rs[2];
        while($resultlists=mysqli_fetch_array($rs[0])){
          ?>
          <tr>
            <td align="left"><img src="<?php echo getFileIcon($resultlists['fileType']); ?>" width="30"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>"  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($resultlists['id']); ?>&folderid=<?php echo $_REQUEST['folderid']; ?>','400px','auto');" style="cursor:pointer;"/></td>
            <td align="left"><a  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($resultlists['id']); ?>&folderid=<?php echo $_REQUEST['folderid']; ?>','400px','auto');"><?php echo  ucfirst($resultlists['name']); ?></a></td>
            <td align="left" ><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>
            <td align="left" ><?php echo getUserName($resultlists['addedBy']); ?></td>
            <td align="left"><?php echo  ($resultlists['fileDimension']); ?></td>
            <td align="left"><?php echo  strtoupper($resultlists['fileType']); ?></td>
            <td align="left"><?php echo  formatBytes($resultlists['fileSize']); ?></td>
            <td align="left" ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <a onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($resultlists['id']); ?>&folderid=<?php echo $_REQUEST['folderid']; ?>','400px','auto');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i></a>
              <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <a onclick="deletealertfile('<?php echo encode($resultlists['id']); ?>','<?php echo $resultlists['uploadFile']; ?>');" style="color:#ff0000!important;font-size: 22px;"><i class="fa fa-trash-o"></i></a> 
            </td>
          </tr>
          <?php 
          $no++; 
        } ?>
      </tbody>
    </table>
    <?php
  } else {
    ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
      <thead>
        <tr>
          <th width="2%" align="left" class="header">&nbsp;</th>
          <th width="32%" align="left" class="header">Name </th>
          <th width="34%" align="left" class="header">&nbsp; </th>
          <th width="19%" align="left" class="header">&nbsp; </th>
          <th width="13%" align="center" class="header">action </th>
        </tr>
      </thead>
      <tbody>
        <?php
        $dir = "tcpdf/examples/package/";
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
              if(str_replace('.','',$file)!=''){
                ?>
                <tr>
                  <td align="left"><img src="<?php echo getFileIcon('pdf'); ?>" width="30"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>"  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($resultlists['id']); ?>&folderid=<?php echo $_REQUEST['folderid']; ?>','400px','auto');" style="cursor:pointer;"/></td>
                  <td align="left"><a   href="tcpdf/examples/package/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a></td>
                  <td align="left" >&nbsp; </td>
                  <td align="left" >&nbsp; </td>
                  <td align="center" ><a href="tcpdf/examples/package/<?php echo $file; ?>" target="_blank">Open</a>&nbsp;&nbsp;&nbsp;  </td>
                </tr>
              
                <?php  
              } 
            }
            closedir($dh);
          }
        } ?>
      </tbody>
    </table>
    <?php
  }
}
 

$where5='';
$res5='';
$select5='*';
$where5=' 1 and folderId="'.$folderid.'" and subfolderId="'.$id.'" and deletestatus=0';
$res5=GetPageRecord($select5,_DOCUMENT_FILES_MASTER_,$where5);
$countFile5a=mysqli_num_rows($res5);
if($countFile5a>0){
  $countFile5 = $countFile5a;
} else {
  $countFile5=0;
}


$where6='';
$res6='';
$select6=' SUM(fileSize) AS value_sum ';
 $where6=' 1 and folderId="'.$folderid.'" and subfolderId="'.$id.'"  and deletestatus=0';
$res6=GetPageRecord($select6,_DOCUMENT_FILES_MASTER_,$where6);
$row=mysqli_fetch_assoc($res6);
if($row['value_sum']!=''){
  $sum6 = formatBytes($row['value_sum'], $precision = 2);
} else {
  $sum6=0;
}

?>
<script>
$('#totalfiles').text('<?php echo $countFile5; ?>');
$('#totalspace').text('<?php echo $sum6; ?>');
</script>