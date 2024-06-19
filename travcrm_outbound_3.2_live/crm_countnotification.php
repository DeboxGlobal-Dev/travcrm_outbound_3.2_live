<?php
include "inc.php"; 
include "config/logincheck.php"; 

$totalno=0;

$sql5="select id from "._NOTIFICATION_MASTER_." where userId=".$loginusersuperParentId." and parentId=".$loginuserID." ";
$res5 = mysqli_query($sql5);
$num5=mysqli_num_rows($res5);
 
$totalno=$num5;


$sql1="select id from "._NOTIFICATION_MASTER_." where userId=".$loginusersuperParentId." and replyPostowner=".$loginuserID." ";
$res1 = mysqli_query($sql1);
$num1=mysqli_num_rows($res1);



$sql1="select id from "._QUERYMAILS_MASTER_." where staus=1  ";
$res1 = mysqli_query($sql1);
$querynum1=mysqli_num_rows($res1);

$totalno=$totalno+$num1+$querynum1;

echo $totalno;
?>




<?php if($totalno>0){ ?>
<script>
$('.bellicon .nbox').addClass('active');
</script>
<?php }

include "cron_get_mail.php"; 

 ?>