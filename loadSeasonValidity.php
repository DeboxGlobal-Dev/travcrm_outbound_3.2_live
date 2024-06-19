<?php
include "inc.php";  
$seasonNameId=$_REQUEST['seasonType'];  
$seasonYear=$_REQUEST['seasonYear']; 
if($seasonYear==0){
$seasonYear=date('Y');
}
$fromDate=$_REQUEST['fromDate2']; 
$toDate=$_REQUEST['toDate2'];
$id_suffix = '';
$where=' seasonNameId="'.$seasonNameId.'" and YEAR(fromDate) = "'.$seasonYear.'" and fromDate>="'.$fromDate.'" and toDate<="'.$toDate.'"order by id asc'; 
$rs=GetPageRecord('*','seasonMaster',$where); 
if($_REQUEST['edit'] == 'yes'){
	$id_suffix = 2;
}
if(mysqli_num_rows($rs) > 0){

	$resListing=mysqli_fetch_array($rs); 
	?>
	<script>
	parent.$('#fromDate<?php echo $id_suffix; ?>').val('<?php echo date('Y-m-d', strtotime($resListing['fromDate'])); ?>');
	parent.$('#toDate<?php echo $id_suffix; ?>').val('<?php echo date('Y-m-d', strtotime($resListing['toDate'])); ?>');	
	</script>
	<?php 
}else{
	
	if($seasonNameId == 1){ 
		$seasonDate = $seasonYear."-01-01";
		$fromDate = date('Y-04-01',strtotime($seasonDate));
		$toDate = date('Y-09-30',strtotime($seasonDate));
	}else{  
		$fromDate = date('Y-10-01',strtotime($seasonYear."-01-01"));
		$toDate = date('Y-03-31',strtotime(($seasonYear+1)."-01-01"));
	} 
	?>
	<script> 
	parent.$('#fromDate<?php echo $id_suffix; ?>').val('<?php echo date('d-m-Y', strtotime($fromDate)); ?>');
	parent.$('#toDate<?php echo $id_suffix; ?>').val('<?php echo date('d-m-Y', strtotime($toDate)); ?>');
// 	parent.alert('Need to define it into Season Master');
	</script>  
	<?php
	
} 


?>