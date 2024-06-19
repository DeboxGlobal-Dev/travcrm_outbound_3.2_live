<?php 
ob_start();   
include "inc.php";  

if($_REQUEST['qid']!='' && $_REQUEST['groupslabfrompax']!='' && $_REQUEST['groupslabtopax']!='' && $_REQUEST['groupslabdiscount']!='' && $_REQUEST['groupslabgroupmanager']!=''){
$groupslabfrompax=$_REQUEST['groupslabfrompax'];
$groupslabtopax=$_REQUEST['groupslabtopax'];
$groupslabdiscount=$_REQUEST['groupslabdiscount'];
$groupslabgroupmanager=$_REQUEST['groupslabgroupmanager'];
$qid=$_REQUEST['qid'];


$namevalue ='qid="'.$qid.'",fromPax="'.$groupslabfrompax.'",toPax="'.$groupslabtopax.'",discountPercent="'.$groupslabdiscount.'",groupManager="'.$groupslabgroupmanager.'"';
addlisting('inboundGroupSlabDiscount',$namevalue); 
}




if($_REQUEST['qid']!='' && $_REQUEST['did']!=''){

$sql_del="delete from inboundGroupSlabDiscount  where id='".$_REQUEST['did']."'"; 
mysqli_query(db(),$sql_del) or die(mysqli_error(db()));

}

?>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>From Pax </strong></td>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>To Pax </strong></td>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>Discount (%) </strong></td>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>Group Manager </strong></td>
    <td bgcolor="#F5F5F5"><strong>Action</strong></td>
  </tr>
 <?php  
$rs=GetPageRecord('*','inboundGroupSlabDiscount','qid="'.$_REQUEST['qid'].'" order by id');
if(mysqli_num_rows($rs)>0){
?>
<script>$('#discountSlabs').val('1');</script>
<?php 
while($rest=mysqli_fetch_array($rs)){  ?>
  <tr>
    <td width="15%" align="center"><?php echo $rest['fromPax']; ?></td>
    <td width="15%" align="center"><?php echo $rest['toPax']; ?></td>
    <td width="15%" align="center"><?php echo $rest['discountPercent']; ?></td>
    <td width="15%" align="center"><?php echo $rest['groupManager']; ?></td>
    <td><a  style="font-size:12px; color:#CC0000 !important; cursor:pointer; " onClick="deletegroupdiscountslab('<?php echo $rest['id']; ?>');">Delete</a></td>
  </tr>
  <?php } } ?>
  <tr>
    <td width="15%" align="center"><input name="groupslabfrompax" type="number" id="groupslabfrompax" style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="1"></td>
    <td width="15%" align="center"><input name="groupslabtopax" type="number" id="groupslabtopax"  style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="1"></td>
    <td width="15%" align="center"><input name="groupslabdiscount"  type="number" id="groupslabdiscount" style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="0"></td>
    <td width="15%" align="center"><input name="groupslabgroupmanager"  type="number" id="groupslabgroupmanager" style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="0"></td>
    <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Add" onClick="savegroupdiscountslab();" ></td>
  </tr>
</table>
<script>
function deletegroupdiscountslab(id){
$('#discountslab').load('querydiscountslab.php?qid=<?php echo $_REQUEST['qid']; ?>&did='+id);
}


function savegroupdiscountslab(){
var groupslabfrompax = $('#groupslabfrompax').val();
var groupslabtopax = $('#groupslabtopax').val();
var groupslabdiscount = $('#groupslabdiscount').val();
var groupslabgroupmanager = $('#groupslabgroupmanager').val();
$('#discountslab').load('querydiscountslab.php?qid=<?php echo $_REQUEST['qid']; ?>&groupslabfrompax='+groupslabfrompax+'&groupslabtopax='+groupslabtopax+'&groupslabdiscount='+groupslabdiscount+'&groupslabgroupmanager='+groupslabgroupmanager+'');
}
</script>


