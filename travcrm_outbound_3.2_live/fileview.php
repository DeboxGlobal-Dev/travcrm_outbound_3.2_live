<?php 
include "inc.php"; 
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];
$id = decode($_REQUEST['id']);

if($id!=''){
$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id='.$id.''; 
$rs=GetPageRecord($select,_DOCUMENT_FOLDER_MASTER_,$where); 
$resultfolderSetting=mysqli_fetch_array($rs);
}
?>
<script>
$('#mainfolder').attr('src','images/yfolderdisplay.png');
$('#foldername').text('<?php echo $resultfolderSetting['name']; ?>');
// $('#foldercountmain').hide();
</script>

<div id="documentmanagementheader">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="2%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;"><img src="images/backicon.png" width="20" border="0" style="padding:0px 10px; cursor:pointer;" onclick="cancel();" ></td>
    <td width="39%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;"><label>
      <select name="folderView"  class="documentdropd" id="folderView" onchange="loadfiles('<?php echo encode($id); ?>');" style=" margin-left:10px;">
        <option value="1" <?php if($_REQUEST['thumborlist']==1){ ?> selected="selected"<?php } ?>>List View</option>
        <option value="2" <?php if($_REQUEST['thumborlist']==2){ ?> selected="selected"<?php } ?>>Thumbnail View</option>
      </select>
    </label></td>
	</td><td width="49%" align="right">
		<?php if($id!=1){ ?>
		<input type="button" value="+ Upload File"  class="bluembutton"  onclick="alertspopupopen('action=addDocumentSubFiles&folderid=<?php echo encode($id); ?>&subfolderid=<?php echo encode(0); ?>','400px','auto');"  style="float:right;"/>

		<input type="button" value="+ Create Folder "  class="bluembutton"   onclick="alertspopupopen('action=addDocumentSubFolder&folderid=<?php echo encode($id); ?>','400px','auto');" style="float:right;    margin-right: 10px;" />

		<input type="text" value="" name="subfolder" id="subfolder"  class="topsearchfiledmain"   onkeyup="subfolderdata('<?php echo encode($id); ?>');" placeholder="Enter Keyword..."/>
	<?php } ?>
	</td>
  </tr>
</table>
</div>
	<div id="folderouter"> 
	</div>	
	<script>
	loadfiles('<?php echo encode($id); ?>');
	</script>