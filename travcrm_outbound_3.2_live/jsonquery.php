<?php 
include "inc.php"; 
?>
<tr>
      <td class="tablelist"><?php echo str_replace("jsonquery.php","","http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?> <strong>(<?php echo $_SERVER['SERVER_ADDR']; ?>)</strong></td>
      <td align="center" class="tablelist"><?php $select='id'; $where=' where 1'; echo countlisting($select,_USER_MASTER_,$where); ?></td>
      <td align="center" class="tablelist"><?php $select='id'; $where=' where queryDate="'.date('Y-m-d').'"'; echo countlisting($select,_QUERY_MASTER_,$where); ?></td>
      <td align="center" class="tablelist"><?php $select='id'; $where=' where  MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and  deletestatus=0'; echo countlisting($select,_QUERY_MASTER_,$where); ?></td>
      <td align="center" class="tablelist">
	  <?php
	  	  $select='expiryDate,lLogin'; 
$where='id=37'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$Logintimeuserzone=mysqli_fetch_array($rs); 
echo date('d/m/Y',strtotime($Logintimeuserzone['expiryDate']));
?>
	   </td>
      <td align="center" class="tablelist">
	  
	  <?php

echo date('d/m/Y h:i a',strtotime($Logintimeuserzone['lLogin']));
?>
	  </td>
	    <td align="center" class="tablelist"><a href="<?php echo str_replace("jsonquery.php","","http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>config/exportdb.php">Download</a></td>
    </tr>