<?php include "inc.php";  

 $select='*';     
$where=' id='.$_REQUEST['itineraryId2'].' order by id asc';   
$rs=GetPageRecord($select,'packageQueryItineraryQuotation',$where); 

$exe=mysqli_fetch_array($rs);
 
 $totalcitynight = 0;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId="'.$exe['id'].'" order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_HOTEL_CITY_,$where);
if($countlist = mysqli_num_rows($rs)>0) {
while($resListing=mysqli_fetch_array($rs)){  
?>
<div style=" background-color:#FEF4E7; padding:12px; font-size:13px; margin-bottom:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:13px;">
  <tr>
    <td width="30%"><?php echo getDestination($resListing['cityId']); ?> </td>
    <td width="30%"><?php echo ($resListing['nights']-1); $totalcitynight = $resListing['nights']+$totalcitynight; ?> Nights  </td>
    </tr>
</table>
</div>
<script>
$('#saveitibtn').show();
</script>
<?php } }else{ echo "<div style='text-align:center; background-color:#FEF4E7; padding:12px; font-size:13px; margin-bottom:10px;'>No Result Found..!</div>"; } ?>