<?php  

include "inc.php"; 

  
  
$queryId=($_REQUEST['queryId']);  
$exclusion=addslashes($_REQUEST['exclusion']);  
$inclusion=addslashes($_REQUEST['inclusion']); 

$quotationpage=addslashes($_REQUEST['quotationpage']);  
 
$namevalue ='exclusion="'.$exclusion.'",inclusion="'.$inclusion.'",quotationpage="'.$quotationpage.'"'; 
 
$where='id="'.$queryId.'"';  
$update = updatelisting('packageQueryItineraryQuotation',$namevalue,$where); 
 
?>
<script>
$('#inclusionexclusion').val('<?php echo strip_tags($editresult['exclusion']); ?>'); 
</script>
 


