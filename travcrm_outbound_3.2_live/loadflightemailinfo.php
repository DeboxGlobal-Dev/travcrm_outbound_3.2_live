<?php 
include "inc.php"; 
include "config/logincheck.php";
?> 
<div style="margin:10px; font-size:18px;"><strong>Flight Information</strong></div>
<table width="100%" border="1" cellpadding="6" cellspacing="0" bordercolor="#ccc" class="tablesorter gridtable"> <thead>

   <tr>
      <th align="left" bgcolor="#666666" class="header" style="color:#fff;" >Departure Destination</th>

     <th align="left" bgcolor="#666666" class="header " style="color:#fff;">Departure Date</th>

     <th align="left" bgcolor="#666666" class="header " style="color:#fff;">Arrival Destination</th>
     <th align="left" bgcolor="#666666" class="header " style="color:#fff;">Arrival Date </th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php 
	  $nod=1;
$select='*';
$where='queryId='.$id.'  order by id desc'; 
$rs=GetPageRecord($select,_QUERY_FLIGHT_MASTER_,$where); 
while($usermasterdocument=mysqli_fetch_array($rs)){
?>	 
  <tr>
    <td align="left"><?php echo getDestination($usermasterdocument['departureDestination']); ?></td>

    <td align="left"><?php echo showdate($usermasterdocument['departureDate']); echo ' - '.$usermasterdocument['departureTime']; ?> </td>

    <td align="left"><?php echo getDestination($usermasterdocument['arrivalDestination']); ?></td>
    <td align="left"><?php echo showdate($usermasterdocument['arrivalDate']); echo ' - '.$usermasterdocument['departureTime'];  ?></td>
    </tr> 
	
	<?php $nod++;} ?>
</tbody></table>
