<?php  
include "inc.php";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Day Wise Plan</title>
<style>
body{margin:0px; padding:0px; width:100%; height:100%;}
html{margin:0px; padding:0px; width:100%; height:100%;}
</style>
</head>

<body>
<iframe style="width:100%; height:100%;" scrolling="no" frameborder="0" src="<?php echo $fullurl; ?>tcpdf/examples/genrateitinerary.php?pageurl=<?php echo $fullurl; ?>itinerarypdf.php?id=<?php echo $_GET['id']; ?>"></iframe>
</body>
</html>
