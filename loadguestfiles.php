<?php
include "inc.php"; 

if($_REQUEST['queryId']!='' &&  $_REQUEST['id']!='' &&  $_REQUEST['dltid']!=''){
 $sql_del="delete from guestListDocuments where id='".$_GET['dltid']."' and queryId='".decode($_GET['queryId'])."' and guestId='".$_GET['id']."'"; 
 mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
     <th align="left" class="header" >Type</th>
     <th align="left" class="header" >Name</th>
     <th align="left" class="header">Date</th>
     <th align="center" class="header" >Upload By </th>
     <th align="center" class="header" >Action</th>
     </tr>
   </thead>
  <tbody>
  <?php
$no='0';
$rs=GetPageRecord('*','guestListDocuments','queryId = "'.decode($_REQUEST['queryId']).'" and guestId="'.$_REQUEST['id'].'" order by id asc'); 
while($resListing=mysqli_fetch_array($rs)){ 
$no='1'; 
?>
  <tr>
    <td align="left"><?php echo stripslashes($resListing['documentType']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['name']); ?></td>
    <td align="left"><?php echo date('d/m/Y',($resListing['addDate'])); ?></td>
    <td align="center"  class="iconsfa"><?php echo getUserName($resListing['addBy']); ?></td>
    <td align="center"  class="iconsfa">
	
	<a href="dirfiles/<?php echo stripslashes($resListing['fileName']); ?>" target="_blank"><i class="fa fa-download"  title="Download" style="cursor:pointer; "  ></i></a>
	
	
	 <i class="fa fa-trash"  title="Delete" style="cursor:pointer; color:#FF6600;" onclick="deletefunloadguestdocuments('<?php echo stripslashes($resListing['id']); ?>');"  ></i> </td>
    </tr> 
	
	<?php   } ?>
</tbody></table>

<?php if($no!='1'){ ?>

<div style="margin-bottom:10px; text-align:center; padding:20px;">No Document Uploaded</div>
<?php } ?>
