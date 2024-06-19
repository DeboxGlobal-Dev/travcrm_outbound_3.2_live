<?php 
include "inc.php"; 
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];
$data = $_REQUEST['data'];
if($_GET['dltid']!=''){
  $where=' id='.$_GET['dltid'].''; 
  deleteRecord(_DOCUMENT_FOLDER_MASTER_,$where);  
}
?>
<?php 
if($thumborlist==2){ 

  if($data!=''){
  	$data = ' and name like "%'.$data.'%"';
  }
  $nod=1;
  $select='*';
  $where='1 '.$data.' order by id asc'; 
  $rs=GetPageRecord($select,_DOCUMENT_FOLDER_MASTER_,$where); 
  while($folderlist=mysqli_fetch_array($rs)){
    ?> 
    <div class="folderthumb" onClick="showfolderorfileviewmain('<?php echo encode($folderlist['id']); ?>');">
    	<img src="images/blkfolder.png" alt="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>"  title="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>"/>
    	<div class="foldername"><?php echo $folderlist['name']; ?></div>
    </div>
    <?php 
  } 
} else { 
  ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
  <thead>
    <tr>
    <th width="5%" align="left" class="header">&nbsp;#</th>
    <th width="30%" align="left" class="header"> Folder Name </th>
    <th width="12%" align="left" class="header"  >Created Date </th>
    <th width="10%" align="left" class="header"  >Created By </th>
    <th width="10%" align="center" class="header"  >Files</th>
    <th width="15%" align="left" class="header"  ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>action </th>
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
  $where='where deletestatus=0 '.$data.' order by id desc';   
  $targetpage=$fullurl.''; 
  $rs=GetRecordList($select,_DOCUMENT_FOLDER_MASTER_,$where,$limit,$page,$targetpage); 
  $totalentry=$rs[1]; 
  $paging=$rs[2]; 
  while($resultlists=mysqli_fetch_array($rs[0])){ 
    ?>
    <tr>
    <td align="left"><img src="images/blkfolder.png" width="36"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>" onClick="showfolderorfileviewmain('<?php echo encode($resultlists['id']); ?>');"/></td>
    <td align="left"><a  onClick="showfolderorfileviewmain('<?php echo encode($resultlists['id']); ?>');"><?php echo  ($resultlists['name']); ?></a></td>
    <td align="left" ><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>
    <td align="left" ><?php echo getUserName($resultlists['addedBy']); ?></td>
    <td align="center" ><?php
      $rs2='';
      $rs2=GetPageRecord('*',_DOCUMENT_FILES_MASTER_,' folderId="'.$resultlists['id'].'"');
      echo $countfolder=mysqli_num_rows($rs2);
      ?>
    </td>
    <td align="left" ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      <a onclick="alertspopupopen('action=addDocumentFolder&id=<?php echo encode($resultlists['id']); ?>','400px','auto');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-pencil"></i></a>
      <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      <a  onClick="showfolderorfileviewmain('<?php echo encode($resultlists['id']); ?>');"  style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i></a>
      <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      <?php if($countfolder==0 && $resultlists['id']!=1){ ?>
      <a onclick="deletealertfile('<?php echo encode($resultlists['id']); ?>','<?php echo $resultlists['uploadFile']; ?>');" style="color:#ff0000!important;font-size: 22px;"><i class="fa fa-trash-o"></i></a> 
      <?php } ?>
    </td>

    </tr> 
	  <?php 
    $no++; 
  } 
  ?>
  </tbody>
  </table>
  <script type="text/javascript">
      function deletefile(fid){
        $('#folderouter').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
        $('#folderouter').load('folderlistinner.php?dltid='+fid+'&thumborlist=1');
      }
      function deletealertfile(fid){
        if(confirm("Do you want to delete this folder?")){
          deletefile(fid);
        }
      }
    </script>
  <?php  
}  

$where4='';
$res4='';
$select4='*';
$where4=' 1  and deletestatus=0';
$res4=GetPageRecord($select4,_DOCUMENT_FOLDER_MASTER_,$where4);
$countfolder4a=mysqli_num_rows($res4);
if($countfolder4a>0){
  $countfolder4 = $countfolder4a;
} else {
  $countfolder4=0;
}


$where5='';
$res5='';
$select5='*';
$where5=' 1  and deletestatus=0';
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
$where6=' 1  and deletestatus=0';
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
$('#foldercount').text('<?php echo $countfolder4; ?>');
$('#totalspace').text('<?php echo $sum6; ?>');
</script>
 