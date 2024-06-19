<?php 
include('inc.php');
$destinationId = $_REQUEST['destinationId'];

$rsd=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$destinationId.'" and deletestatus=0 order by name asc');

$resListingd=mysqli_fetch_array($rsd);


?>


<option value="">Select Hotel</option>


<?php 
              



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where='1 and hotelCity ="'.$resListingd['name'].'" order by hotelName asc';  



$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['hotelIdr']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['hotelName']); ?></option>



<?php } ?>