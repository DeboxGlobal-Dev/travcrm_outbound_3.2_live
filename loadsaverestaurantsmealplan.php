<?php
include "inc.php";  
$restaurantId = $_REQUEST['restaurantId'];
if( $_REQUEST['action'] =='saverestaurantsmealplan' && $_REQUEST['adultCost']>0){  
	$mealPlanId=addslashes($_REQUEST['mealPlanId']); 
	$adultCost=addslashes($_REQUEST['adultCost']); 
	$childCost=addslashes($_REQUEST['childCost']);    
	$infantCost=addslashes($_REQUEST['infantCost']);    
	$currencyId=addslashes($_REQUEST['currencyId']);
	$RestaurantGST=addslashes($_REQUEST['RestaurantGST']);

	$selectmp='*';    
    $wheremp='mealPlanId="'.$mealPlanId.'" and restaurantId="'.$restaurantId.'" and status=1';  
    $rsmp=GetPageRecord($selectmp,'dmcRestaurantsMealPlanRate',$wheremp); 
    $resListingmp=mysqli_fetch_array($rsmp);
    $countmpt = mysqli_num_rows($rsmp);
    if($countmpt==0){
	  $namevalue ='adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",currencyId="'.$currencyId.'",restaurantId="'.$restaurantId.'",mealPlanId="'.$mealPlanId.'",RestaurantGST="'.$RestaurantGST.'",status="1"'; 
	  $lastid = addlistinggetlastid('dmcRestaurantsMealPlanRate',$namevalue);
	  $msgbox = 1; 
	 }else{?>
      <script type="text/javascript">
      	  $('#alertsumessage').show();
      	  setTimeout( function(){
            $('#alertsumessage').hide();
          }  , 5000 );
      </script>
	 <?php } 
?>
<script>
// parent.$('#pageloading').hide();
// parent.$('#pageloader').hide();
// parent.alert('Hotel tariff of this duration is already exist.2222');

// module=inboundmealplanmaster&keyword=&view=yes&inboundmealplanNameId=VGtSUlBRPT0=
parent.setupbox('showpage.crm?module=inboundmealplanmaster&keyword=&view=yes&inboundmealplanNameId=<?php echo encode($restaurantId); ?>&alt=<?php echo $msgbox; ?>');
</script>
 <?php
}

if( $_REQUEST['action'] =='deleterestaurantsmealplan' && $_REQUEST['id']>0){   
	$sql_del="delete from dmcRestaurantsMealPlanRate  where id='".($_REQUEST['id'])."'"; 
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
 
}

?>

<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#F4F4F4">
 
  <tr>
    <td bgcolor="#999999"><strong>Meal Plan </strong></td>
    <td bgcolor="#999999"><strong>Currency</strong></td>
    <td bgcolor="#999999"><strong>Per Pax Cost </strong></td>
    <td bgcolor="#999999"><strong>Restaurant TAX SLAB(%)</strong></td>
 
    <td align="center" bgcolor="#999999"><strong>Action</strong></td>
  </tr>
	<?php   
	$rsat=GetPageRecord('*','dmcRestaurantsMealPlanRate','restaurantId="'.$restaurantId.'" and status=1'); 
	while($restaurantRate=mysqli_fetch_array($rsat)){
		$selectc='*';    
        $wherec='id="'.$restaurantRate['currencyId'].'" and deletestatus=0 and status=1 order by name asc';  
        $rsc=GetPageRecord($selectc,_QUERY_CURRENCY_MASTER_,$wherec); 
        $resListingc=mysqli_fetch_array($rsc);
	?>
  <tr>
    <td><?php
			$rs2=GetPageRecord('*','restaurantsMealPlanMaster','id="'.$restaurantRate['mealPlanId'].'" and deletestatus=0'); 
			$userss=mysqli_fetch_array($rs2);
			echo $userss['name'];
	 ?></td>
	<td><?php echo $resListingc['name']; ?></td> 
    <td><?php echo $restaurantRate['adultCost']; ?></td> 
    <td><?php
			$rs2=GetPageRecord('*','gstMaster','id="'.$restaurantRate['RestaurantGST'].'" and deletestatus=0'); 
			$userss=mysqli_fetch_array($rs2);
			echo $userss['gstSlabName'];
	 ?></td>
    <td align="center"><i class="fa fa-pencil-square-o editstyle" aria-hidden="true" onClick="alertspopupopen('action=editRestaurantRate&sectionId=<?php echo $restaurantRate['id']; ?>&mealPlanId=<?php echo $_GET['supplierId']; ?>&restaurantId=<?php echo $restaurantId; ?>','500px','auto');"></i><i class="fa fa-trash" aria-hidden="true" style="color:#FF0000; cursor:pointer;" onclick="parent.deleterate('<?php echo $restaurantRate['id']; ?>');"></i></td>
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