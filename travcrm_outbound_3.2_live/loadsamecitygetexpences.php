<?php 
include "inc.php";  
$id=$_REQUEST['id'];
if($id!=''){



$select='*';    
$where=' addressType="invoicesetting"  order by id desc limit 0,1';  
$rs=GetPageRecord($select,_ADDRESS_MASTER_,$where); 
while($resAddress=mysqli_fetch_array($rs)){  
  $stateid = $resAddress['stateId'];
}


$select='*';    
$where=' addressType="supplier" and addressParent='.$id.'  order by id desc limit 0,1';  
$rs=GetPageRecord($select,_ADDRESS_MASTER_,$where); 
while($resAddress=mysqli_fetch_array($rs)){  
  $stateid2 = $resAddress['stateId'];
}

if($stateid==$stateid2){
$val=1;
} else { 
$val=2;
}


?>



<script>
$('#samecity').val('<?php echo $val; ?>');
</script>
<?php }  ?>




