<?php
include "inc.php";  
?>
<option value="">Select Meal Type</option>
<?php
    $rsat=GetPageRecord('*','dmcRestaurantsMealPlanRate','restaurantId="'.$_REQUEST['restaurantId'].'" and status=1'); 
	while($restaurantRate=mysqli_fetch_array($rsat)){
	$rs2=GetPageRecord('*','restaurantsMealPlanMaster','id="'.$restaurantRate['mealPlanId'].'" and deletestatus=0'); 
	$userss=mysqli_fetch_array($rs2);
	?>
	<option value="<?php echo $userss['id']; ?>"><?php echo $userss['name']; ?></option>
	<?php
	}



	
?>

 
