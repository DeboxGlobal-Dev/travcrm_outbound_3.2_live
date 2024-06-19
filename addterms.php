<?php
include "inc.php"; 
include "config/logincheck.php";
  


$where1='id='.decode('VFZFOVBRPT0=').'';  
$rs1=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,$where1);  
$editresult=mysqli_fetch_array($rs1);

$termscondition=strip_tags(stripslashes($editresult['termscondition']));
?>
<script>
$('#termsCondition').val('<?php echo $termscondition; ?>');
</script>
 