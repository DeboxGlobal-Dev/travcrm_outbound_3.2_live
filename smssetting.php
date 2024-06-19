<?php 
function sendSMStoClient($mobile,$message){
$url = "http://59.162.167.52/api/MessageCompose?admin=anup.jain53@gmail.com&user=dinesh.khari@deboxglobal.com:I7H3J4P&senderID=IDEBOX&receipientno=".$mobile."&msgtxt=".$message."&state=4";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
}
 
?>