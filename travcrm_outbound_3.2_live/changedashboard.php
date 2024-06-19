<?php
include "inc.php";
include "config/logincheck.php";
$id=$_REQUEST['id'];
$_SESSION['dashboardid']=$id;;
?>
<script>
parent.location.reload();
</script>
