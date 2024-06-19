<?php
include "inc.php"; 
include "config/logincheck.php";
$id=decode($_GET['id']);

if($id!=''){
$select22=''; 
$where22=''; 
$rs22='';  
$select22='fileName';   
$where22='userId='.$loginusersuperParentId.' and id = '.$id.''; 
$rs22=GetPageRecord($select22,_FILE_MASTER_,$where22); 
while($attachedfile=mysqli_fetch_array($rs22)){  
 

 // Fetch the file info.
     $filePath = 'dirfiles/'.$attachedfile['fileName'];

    if(file_exists($filePath)) {
        $fileName = basename($filePath);
        $fileSize = filesize($filePath);

        // Output headers.
        header("Cache-Control: private");
        header("Content-Type: application/stream");
        header("Content-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=".$fileName);

        // Output file.
        readfile ($filePath);                   
        exit();
    }
    else {
        die('The provided file path is not valid.');
    }
	
	}
	
	}
?>