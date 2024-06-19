
<?php 
include "inc.php";  

 ?>
 <link rel="stylesheet" href="css/selectize.css">
 <script src="js/jquery-1.11.3.min.js?id=<?php echo time();?>"></script> 
	<script type="text/javascript" src="js/selectize.js"></script>
	<script>
		$('.selectBoxDest').selectize();
	</script>
	<style type="text/css">
		.gridlable{color: #8a8a8a;
    width: 30%;
    display: inline-block;
    padding-bottom: 0px;
    font-size: 13px;
    margin-bottom: 5px;
}
  .selectize-input{
  	padding: 8px;
  }
	</style>
 <?php if($_REQUEST['supplierType']=='0'){ ?>
<div class="">
  <label>
 <div class="gridlable">Supplier Name</div>
  	<select id="supplierNameId" name="supplierNameId" class="gridfield selectBoxDest"  displayname="Supplier Name"  >
	<?php 
	$select1='*';  
  $where1='mealType=6 or mealType=1'; 
  $rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
	while($resultlists=mysqli_fetch_array($rs1)){ 
	?>                 
   <option value="<?php echo $resultlists['id']; ?>" <?php if($resultlists['id'] == $_REQUEST['supplierId']){ ?>selected="selected" <?php } ?>><?php echo $resultlists['name']; ?></option>
	<?php }

		$selecth='*';  
		$whereh='1 order by id desc'; 
		$rsh=GetPageRecord($selecth,_PACKAGE_BUILDER_HOTEL_MASTER_,$whereh); 
		while($resultlists=mysqli_fetch_array($rsh)){ 

			?>                 
		   <option value="<?php echo $resultlists['id']; ?>" <?php if($resultlists['id'] == $_REQUEST['supplierId']){ ?>selected="selected" <?php } ?>><?php echo $resultlists['hotelName']; ?></option>
		<?php } ?>                 
 </select>
 </label>
</div>
<?php }if($_REQUEST['supplierType']=='1'){ echo '';} ?>	                 