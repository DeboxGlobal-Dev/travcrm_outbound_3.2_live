<?php  
include "inc.php";  

echo $_SERVER['DOCUMENT_ROOT']."/textfile/myText.txt";

$content = 'Hello';
$fp = fopen($_SERVER['DOCUMENT_ROOT']."/crm/textfile/myText.txt","w");
fwrite($fp,$content);
fclose($fp);

/*$myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/textfile/newfile.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);*/


?>