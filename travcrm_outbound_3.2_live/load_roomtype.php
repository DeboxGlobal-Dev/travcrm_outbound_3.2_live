<?php
include "inc.php"; 
include "config/logincheck.php"; 

	  $hotelIdType=$_REQUEST['catid'];
 $selectId=$_REQUEST['selectId'];

?>
 <option value="">Select</option>
	 <?php 
	 $query4 = "SELECT * FROM "._PACKAGE_BUILDER_HOTEL_MASTER_."  where id='".$hotelIdType."' order by id desc";
$rs4 = mysqli_query(db(),$query4);
$resListing4=mysqli_fetch_array($rs4);


	 $roomTypeArray =  explode(",", rtrim($resListing4['roomType'],","));

			$i=0;
			foreach($roomTypeArray as $tagsName2[$i]) {
			$select3=''; 
			$where3=''; 
			$rs3='';  
			$select3='*';    
			$where3=' id='.$tagsName2[$i].' order by id desc';  
			$rs3=GetPageRecord($select3,_ROOM_TYPE_MASTER_,$where3); 
			$resListing3=mysqli_fetch_array($rs3);
			$hotelRoomsType.='<option value="'.$resListing3['id'].'">'.$resListing3['name'].'</option>';

			++$i;
        }
		echo rtrim($hotelRoomsType, ", ");
/*$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,_ROOM_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php }*/ ?>