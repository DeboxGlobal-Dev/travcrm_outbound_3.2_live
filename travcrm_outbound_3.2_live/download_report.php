<?php
include "inc.php"; 
include "config/logincheck.php"; 

header("Content-type: application/vnd.ms-excel;charset=UTF-8"); 
header("Content-Disposition: attachment; filename=\"Report-".date('d-m-Y-H-i-s').".xls");
header("Cache-control: private");

 ?>
<?php if($_REQUEST['reportdata']!=''){  echo $_REQUEST['reportdata'];  }