<?php
include "inc.php";
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];
$folderid = decode($_REQUEST['folderid']);
$id = decode($_REQUEST['id']);
if($id!=''){
  $select='';
  $where='';
  $rs='';
  $select='*';
  $where='id='.$id.'';
  $rs=GetPageRecord($select,_DOCUMENT_SUBFOLDER_MASTER_,$where);
  $resultfolderSetting=mysqli_fetch_array($rs);
}
?>
<script>
$('#mainfolder').attr('src','images/yfolderdisplay.png');
$('#foldername').text('<?php echo $resultfolderSetting['name']; ?>');
$('#foldercountmain').hide();
</script>
<div id="documentmanagementheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="2%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;"><img src="images/backicon.png" width="20" border="0" style="padding:0px 10px; cursor:pointer;" onclick="backFromSubFolderView('<?php echo encode($folderid); ?>');" ></td>
      <td width="49%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;"><label>
        <select name="folderView"  class="documentdropd" id="folderView" onchange="loadsubfiles('<?php echo $id; ?>','<?php echo $folderid; ?>');" style=" margin-left:10px;">
          <option value="1" <?php if($_REQUEST['thumborlist']==1){ ?> selected="selected"<?php } ?>>List View</option>
          <option value="2" <?php if($_REQUEST['thumborlist']==2){ ?> selected="selected"<?php } ?>>Thumbnail View</option>
        </select>
        </label>
      </td>
      <td width="49%" align="right"><?php if($id!=1){ ?><input type="button" value="+ Upload File"  class="bluembutton"   onclick="alertspopupopen('action=addDocumentSubFiles&folderid=<?php echo encode($folderid); ?>&subfolderid=<?php echo encode($id); ?>','400px','auto');" style="float:right;" /><input type="text" value="" name="subfile" id="subfile"  class="topsearchfiledmain"   onkeyup="subfiledata('<?php echo $id; ?>','<?php echo $folderid; ?>');" placeholder="Enter Keyword..."  /><?php } ?></td>
    </tr>
  </table>
</div>
<div id="folderouter">
</div>
<script>
loadsubfiles('<?php echo encode($id); ?>','<?php echo encode($folderid); ?>');
</script>