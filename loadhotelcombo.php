<?php
include "inc.php"; 
include "config/logincheck.php";


if($_REQUEST['dltid']!=''){
$sql_del="delete from hotelCombo  where id='".$_REQUEST['dltid']."' "; 
mysqli_query (db(),$sql_del) or die(mysqli_error());
}


if($_REQUEST['selectid']!=''){

$sql_up="update hotelCombo set selected=0 where quotationId='".$_REQUEST['quotationId']."' "; 
mysqli_query (db(),$sql_up);


$sql_up="update hotelCombo set selected='".$_REQUEST['st']."' where id='".$_REQUEST['selectid']."' "; 
mysqli_query (db(),$sql_up);
}



if($_REQUEST['lockid']!=''){

 

$sql_up="update hotelCombo set lockThis='".$_REQUEST['lock']."' where id='".$_REQUEST['lockid']."' "; 
mysqli_query (db(),$sql_up);

if($_REQUEST['lock']==1){

$nna=GetPageRecord('hotelId','hotelCombo','quotationId='.$_REQUEST['quotationId'].' and id="'.$_REQUEST['lockid'].'"'); 
$hoteldatacombo=mysqli_fetch_array($nna); 

$first = explode(',', $hoteldatacombo['hotelId'])[0];


$a=GetPageRecord('id','quotationHotelMaster','queryId='.$_REQUEST['quotationId'].' and supplierId="'.$first.'" and status=1'); 
$gethotelid=mysqli_fetch_array($a); 

 
?>

<script>

alertspopupopen('action=addedithotelinquotation&queryId=<?php echo $_REQUEST['quotationId']; ?>&hotelQuotationId=<?php echo $gethotelid['id']; ?>&lockthis=1&comboid=<?php echo $_REQUEST['lockid']; ?>&quotationId=<?php echo $_REQUEST['quotationId']; ?>','1200px','auto');
</script>

<?php
}
}

?>

<table width="100%" border="0" cellpadding="10" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th width="3%" align="left" class="header">Sr.</th>
   	  <th width="78%" align="left" class="header">Hotels  </th>
      <th width="19%" align="right" class="header">&nbsp;</th>
      <th width="5%" align="right" class="header">&nbsp;</th>
     </tr>
   </thead>

  <tbody>
 
 <?php
 $n=1;
  $where1='   queryId="'.$_REQUEST['queryId'].'" and quotationId="'.$_REQUEST['quotationId'].'" order by id asc';  
$rs1=GetPageRecord('*','hotelCombo',$where1); 
while($combolist=mysqli_fetch_array($rs1)){ 


?>
   <tr <?php if($combolist['lockThis']==1){ ?> style="background-color:#dbffd2;"<?php } ?>>
     <td align="left" style="border-bottom: 1px solid #ccc !important; padding:10px;"><?php echo $n; ?></td>
  <td align="left" style="border-bottom:1px solid #ccc !important; padding:10px; font-weight:600; font-size:14px;">
  
  <?php
  $hotellist='';
  $string = preg_replace('/\.$/', '', $combolist['hotelId']); 
$array = explode(',', $string); 
foreach($array as $value) 
{
if($value!=''){
 
 $nn=GetPageRecord('hotelName',_PACKAGE_BUILDER_HOTEL_MASTER_,'id='.$value.''); 
$hoteldata=mysqli_fetch_array($nn); 

$hotellist.=strip($hoteldata['hotelName']).' + ';



} }

echo rtrim($hotellist,' + ');
?>  </td>
    <td align="right" style="border-bottom:1px solid #ccc !important; padding:10px;"><?php if($combolist['selected']==0){ ?>
	
	<?php
 
	$bbbd=GetPageRecord('id','hotelCombo','  quotationId="'.$_REQUEST['quotationId'].'" and lockThis=1'); 
$yeslocked=mysqli_fetch_array($bbbd); 

if($yeslocked['id']==''){ 
?>
	
	<a class="editbtn"  onclick="loadhotelcombofunselect('<?php echo $combolist['id']; ?>','<?php if($combolist['selected']==1){ echo '0'; } else { echo '1'; } ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</a>
	<?php } ?>
	
	<?php } else { ?><?php if($combolist['lockThis']==0){ ?> <a class="editbtn"   onclick="loadhotelcombofunselect('<?php echo $combolist['id']; ?>','<?php if($combolist['selected']==1){ echo '0'; } else { echo '1'; } ?>');" style="background-color: #30a52c; color: #fff !important;border: 1px solid #30a52c;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Selected</a><?php } ?><?php } ?></td>
    <td width="5%" align="right" style="border-bottom:1px solid #ccc !important; padding:10px;"><?php if($combolist['selected']==0){ ?><div class="deletebtn" onclick="if(confirm('Are you sure you want delete this combo?')) loadhotelcombofundlt('<?php echo $combolist['id']; ?>');" style="width: 16px; text-align: center;"><i class="fa fa-trash" aria-hidden="true"></i></div><?php } else { ?>
	
	<?php if($combolist['lockThis']==0){ ?>
	<div class="deletebtn"  onclick="if(confirm('Do you want to lock this this?')) loadhotelcombofunloackunlock('<?php echo $combolist['id']; ?>','1');" style="width: 16px; text-align: center;color: #2ea924 !important;"><i class="fa fa-unlock" aria-hidden="true"></i></div>
	<?php } else { ?>
	
	<div class="deletebtn" onclick="if(confirm('Do you want to unlock this this?')) loadhotelcombofunloackunlock('<?php echo $combolist['id']; ?>','0');" style="width: 16px; text-align: center; color:#ff9500 !important;"><i class="fa fa-lock" aria-hidden="true"></i></div>
	<?php } ?>
	
	
	<?php } ?>
	</td>

    <style>
	.editbtn{border: 1px solid;
    padding: 2px 4px;
    border-radius: 3px;
    background-color: #fff;  cursor:pointer;}
	</style>
    </tr> 
	<?php $n++; } ?>
</tbody></table>
<?php if($n==1){ ?>
<div style="padding:10px; text-align:center; ">No Combo</div>

<?php  } ?>