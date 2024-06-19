<?php
include "inc.php"; 
$dtype=$_REQUEST['t']; 
if($dtype=='1'){
$_REQUEST['d'];
header('Location: '.$fullurl.'genrateDOMPdf.php?pageurl='.$fullurl.'/download-voucher.php?id='.encode($_REQUEST['d']).'&d=1');
}

if($dtype=='2'){
echo $_REQUEST['d'];
header('Location: '.$fullurl.'genrateDOMPdf.php?pageurl='.$fullurl.'invoicehtml.php?id='.encode($_REQUEST['d']).'&d=1');
}

if($dtype=='3'){
echo $_REQUEST['d'];
header('Location: '.$fullurl.'packageQueryhtml.php?id='.encode($_REQUEST['d']).'&downloadpackage=1&servicePrice=1');
}

?>