<?php
include "inc.php";  


$fromDate=date('Y-m-d',strtotime("-1 days"));
$toDate=date('Y-m-d',strtotime("-1 days"));
$assignto=$_GET['assignto'];
$destinationId=$_GET['destinationId'];
$categoryId=$_GET['categoryId'];
$tourType=$_GET['tourType'];
$clientType=$_GET['clientType'];
$clients=$_GET['Clients'];

$strWhere='';

if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));

$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}


if($assignto!=''){  
$strWhere.=' and assignTo='.$assignto.'';
}


if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}


if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}


if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}

if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}

if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
} 
?>
<table width="100%" border="1" cellpadding="6" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header">Confirmed</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header">Reverted</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header">Assigned</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header">Sent</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header">Follow&nbsp;Up</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header"> Lost</th>
    <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header"> Sales</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header"  >Gross&nbsp;Margin </th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header"  >Total&nbsp;Pax</th>
     <th align="center" bordercolor="#F0F0F0" bgcolor="#F8F8F8" class="header"  >No(s)&nbsp;Nights </th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php

 
?>
  <tr style="font-size: 20px;">
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1) ";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query("select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){

$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query($sql3) or die(mysqli_error()); 
$result2=mysqli_fetch_array($rs3);  


$result = mysqli_query("SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}

echo $suppliertotalcost_sum;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query("select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){

$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query($sql3) or die(mysqli_error()); 
$result2=mysqli_fetch_array($rs3);  


$result = mysqli_query("SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}


echo $suppliertotalcost_sum-$companytotalcost_sum;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query("SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];



$result2 = mysqli_query("SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $adultsum+$row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  
 $result3 = mysqli_query("SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $adultsum+$row3['nightsum'];
?>
	
	</td>
    </tr> 
	
 
</tbody></table>