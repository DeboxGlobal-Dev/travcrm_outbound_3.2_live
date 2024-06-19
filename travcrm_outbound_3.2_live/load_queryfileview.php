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
$('#foldercountmain').hide();
</script>

<div id="documentmanagementheader" style="margin-top:0px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="2%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;"><img src="images/backicon.png" width="20" border="0" style="padding:0px 10px; cursor:pointer;" onclick="loadfolderquery();" ></td>
    <td width="64%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;"><label>
      <?php echo $_REQUEST['name']; ?>
    </label></td>
    <td width="34%" align="right"></td>
  </tr>
</table>
</div>
	<div id="folderouter"> 
	</div>	
	<script>
	//alert('<?php $id; ?>');
	loadfiles('<?php echo $id; ?>');
	</script>