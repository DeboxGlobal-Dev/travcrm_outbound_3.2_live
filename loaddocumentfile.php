<?php 
include "inc.php"; 
include "config/logincheck.php";

if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].' and sectionType="'.$_GET['sectionType'].'"'; 
deleteRecord(_DOCUMENT_ATTACHMENT_MASTER_,$where);
}
 

$id=$_GET['id']; 
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="background: #f9f9f9; border-radius: 4px; overflow: hidden;">
      <?php 
 $nod=1;
$select='*';
$where='masterId="'.$id.'" and sectionType="'.$_GET['sectionType'].'" and docId="'.$_GET['docId'].'"order by id desc'; 
$rs=GetPageRecord($select,_DOCUMENT_ATTACHMENT_MASTER_,$where); 
while($usermasterdocument=mysqli_fetch_array($rs)){
?>	 
  <tr>
    <td class="attachmentdocumentouter" style=" padding-left:10px;"><a href="download/<?php echo $usermasterdocument['fileName']; ?>" target="_blank">
      <div class="commattachedbox" style="    padding-top: 2px;
    padding-bottom: 4px;
    margin-bottom: 5px;"><strong><?php echo $usermasterdocument['fileName']; ?></strong></div>
    </a></td>
   
    <td class="attachmentdocumentouter"><?php echo getUserName($usermasterdocument['addedBy']); ?>
<div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($usermasterdocument['dateAdded'],$loginusertimeFormat);?></div></td>
    <td align="center" class="attachmentdocumentouter"><img src="images/deleteicon.png"   style="cursor:pointer;" onClick="deletecon(<?php echo $usermasterdocument['id']; ?>);" /></td>
  </tr>
  <?php $nod++; } ?>
</table>
<?php if($nod==1){ ?>
<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Document</div>
 <?php } ?>