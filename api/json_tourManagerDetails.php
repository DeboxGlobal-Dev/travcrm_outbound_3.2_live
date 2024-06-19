<?php
include "../inc.php";
header("Content-Type: application/json");

$rs=mysqli_query(db(),"SELECT * FROM tourmanager WHERE status=1 order by id desc");
while($tourmanagerList=mysqli_fetch_array($rs)){
$Name=$tourmanagerList['name'];
$email=$tourmanagerList['email'];
$phone=$tourmanagerList['phone'];
$image='http://travcrm.in/travcrm-demo/packageimages/1608186180a13b71958a8f42dc8a53a4a9c987a82e.jpg';
//josn structure
$json_manager .='{
    "name":"'.$Name.'",
    "email":"'.$email.'",
    "image":"'.$image.'",
    "contactNumber":"'.$phone.'"
},';
}
?>
{
    "status":"true",
    "tourManager":[<?php echo trim($json_manager, ',');?>]
}