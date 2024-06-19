<?php
include "inc.php";

$serviceId = $_REQUEST['serviceId'];
?>


<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#F4F4F4">
 
  <tr>
    <td bgcolor="#999999"><strong>Meal Plan </strong></td>
    <td bgcolor="#999999"><strong>Currency</strong></td>
    <td bgcolor="#999999"><strong>Adult Cost</strong></td>
    <td bgcolor="#999999"><strong>Child Cost</strong></td>
    <td bgcolor="#999999"><strong>Restaurant TAX SLAB(%)</strong></td>
    <td bgcolor="#999999"><strong>Mark-up</strong></td>
 
    <td align="center" bgcolor="#999999"><strong>Action</strong></td>
  </tr>
	<?php   
	$rsat=GetPageRecord('*','dmcRestaurantsMealPlanRate','serviceId="'.$serviceId.'" and status=1'); 
	while($restaurantRate=mysqli_fetch_array($rsat)){
		$selectc='*';    
        $wherec='id="'.$restaurantRate['currencyId'].'" and deletestatus=0 and status=1 order by name asc';  
        $rsc=GetPageRecord($selectc,_QUERY_CURRENCY_MASTER_,$wherec); 
        $resListingc=mysqli_fetch_array($rsc);
	?>
  <tr>
    <td><?php
			$rs2=GetPageRecord('*','restaurantsMealPlanMaster','id="'.$restaurantRate['mealPlanType'].'" and deletestatus=0'); 
			$userss=mysqli_fetch_array($rs2);
			echo $userss['name'];
	 ?></td>
	<td><?php echo $resListingc['name']; ?></td> 
    <td><?php echo $restaurantRate['adultCost']; ?></td> 
    <td><?php echo $restaurantRate['childCost']; ?></td> 
    <td><?php
			$rs2=GetPageRecord('*','gstMaster','id="'.$restaurantRate['RestaurantGST'].'" and deletestatus=0'); 
			$userss=mysqli_fetch_array($rs2);
			echo $userss['gstSlabName'];
	 ?></td>
    <td><?php echo $restaurantRate['markupCost']; echo ($restaurantRate['markupType']==1)?'%':'Flat'; ?></td> 
    <td align="center"><i class="fa fa-pencil-square-o editstyle" aria-hidden="true" onClick="alertspopupopen('action=editRestaurantRate&rateId=<?php echo $restaurantRate['id']; ?>&mealPlanType=<?php echo $restaurantRate['mealPlanType']; ?>&serviceId=<?php echo $serviceId; ?>','500px','auto');"></i>
    <i class="fa fa-trash" aria-hidden="true" style="color:#FF0000; cursor:pointer;" onclick="parent.deleterate('<?php echo $restaurantRate['id']; ?>');"></i></td>
  </tr>
  <?php } ?>
</table>

<style>
	.editstyle{
		color: green !important;
    font-size: 15px;
    margin-right: 10px;
    cursor: pointer;
	}
</style>