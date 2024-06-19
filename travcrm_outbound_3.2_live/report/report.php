<?php  
include "../inc.php"; 
 $db =mysqli_connect("localhost","travcrm_dev","admin@3214","travcrm_dev");
 ?>


  <?php 
  
$strWhere=''; 
$fromDate = date('Y-m-d'); 
$toDate = date('Y-m-d'); 
 $strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 '; 
 
  ?>
   


<div style=" padding:40px 0px; width:100%; background-color:#4B4B4B; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#333333; ">

<div style="background-color:#fff; width:800px; padding:0px; margin:auto; border-top:8px #ffc115 solid;    box-shadow: 0px 0px 13px #0000007d;">

<div><img src="<?php echo $fullurl; ?>report/reportbanner.png"></div>

<h2 style="    text-align: center; margin: 0px; padding: 20px; border-bottom: 1px #cccccc69 solid; background-color: #cccccc26;">Query Status Report - <?php echo date('d/m/Y'); ?></h2>

<div style="padding:30px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="left" valign="top"><div style="padding:20px; text-align:center; border-right:1px #cccccc69 solid;border-bottom:1px #cccccc69 solid;">

	<div style="color:#339900; font-size:45px; margin-bottom:10px;">

	<?php  

		  $sql5="select id from "._QUERY_MASTER_." where ".$strWhere."   ";


			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);



			 

			?>

	

	<?php echo $tqueryTotal;?>252</div>

	<div style=" color:#666666; font-size:15px;">Total Queries</div>

	</div></td>

    <td width="33%" align="left" valign="top"><div style="padding:20px; text-align:center; border-right:1px #cccccc69 solid;border-bottom:1px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;">	<?php  

		  $sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3  ";

			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);

			 

			?>328</div>

      <div style=" color:#666666; font-size:15px;">Confirmed Queries</div>

    </div></td>

    <td width="33%" align="left" valign="top"><div style="padding:20px; text-align:center; border-bottom:1px #cccccc69 solid;">
      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php  

	 $sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2  ";

			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);

			 

			?>21</div>
      <div style=" color:#666666; font-size:15px;">Reverted Queries</div></div></td>

  </tr>

  <tr>

    <td align="left" valign="top"><div style="padding:20px; text-align:center; border-right:1px #cccccc69 solid;border-bottom:1px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php  

	 $sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=10";

			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);

			 

			?>25</div>

      <div style=" color:#666666; font-size:15px;">Assigned Queries</div>

    </div></td>

    <td width="33%" align="left" valign="top"><div style="padding:20px; text-align:center; border-right:1px #cccccc69 solid;border-bottom:1px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php  

	 $sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6";

			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);

			 

			?>2</div>

      <div style=" color:#666666; font-size:15px;">Sent Queries</div>

    </div></td>

    <td width="33%" align="left" valign="top"><div style="padding:20px; text-align:center; border-bottom:1px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php  

	 $sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=5";

			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);

			 

			?>50</div>

      <div style=" color:#666666; font-size:15px;">Follow Up Queries</div>

    </div></td>

  </tr>

  <tr>

    <td align="left" valign="top"><div style="padding:20px; text-align:center; border-right:1px #cccccc69 solid;border-bottom:0px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php  

	 $sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and (queryStatus=20 or queryStatus=4)";

			$res5 = mysqli_query($sql5); 

		  echo $tquery=mysqli_num_rows($res5);

			 

			?>1</div>

      <div style=" color:#666666; font-size:15px;">Lost Queries</div>

    </div></td>

    <td align="left" valign="top"><div style="padding:20px; text-align:center; border-right:1px #cccccc69 solid;border-bottom:0px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php   $companytotalcost_sum=0;

$menug=mysqli_query("select id, SUM(totalQueryCost) As sumTotalQueryCost, SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent from "._QUERY_MASTER_."   where ".$strWhere." and queryStatus=3");

$res_menug=mysqli_fetch_array($menug);

 echo $gmarg = $res_menug['sumTotalQueryCost']-$res_menug['sumTotalQueryCostwithoutpercent']; ?>3.666</div>

      <div style=" color:#666666; font-size:15px;">Gross&nbsp;Margin</div>

    </div></td>

    <td align="left" valign="top"><div style="padding:20px; text-align:center; border-bottom:0px #cccccc69 solid;">

      <div style="color:#339900; font-size:45px; margin-bottom:10px;"><?php $result2 = mysqli_query("SELECT SUM(adult) AS adultsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3  "); 

$row2 = mysqli_fetch_assoc($result2); 

echo $row2['adultsum']; ?>2</div>

      <div style=" color:#666666; font-size:15px;">Total Pax </div>

    </div></td>

  </tr>

</table> 

</div>

<div style="padding:30px;background-color: #cccccc26; text-align:center; ">

<img src="<?php echo $fullurl; ?>images/travCRM-highres-logo.png" width="109"><br>

<br>

Powered by travCRM

 

</div>



</div>

</div>
