<?php 
include "../inc.php";
header("Content-Type: application/json");
$queryId=$_REQUEST['queryId'];
$rs=GetPageRecord('*','letterLinkLanguageMaster','1 and queryId="'.$queryId.'" and letterId=9'); 
$resListing=mysqli_fetch_array($rs);
if(mysqli_num_rows($rs) > 0){
$url=stripslashes($resListing['description']);
$json_url.= '{
    "description":"'.$url.'"
},';
}else{
$rs=GetPageRecord('*','letterLanguageMaster','1 and letterId=9 and languageId=1'); 
$resListing=mysqli_fetch_array($rs);
if($resListing['letterId']==9){
$url='<?php echo "'.$fullurl.'"; ?>generateBrifeingSheet.php?queryId='.$queryId.'';
$json_url.= '{
    "url":"'.$fullurl."generateBrifeingSheet.php?queryId=".$queryId."".'"
},';
}
}
?>
{
		"status":"true",
		"breifingSheet":[<?php echo trim($json_url, ',');?>]
}