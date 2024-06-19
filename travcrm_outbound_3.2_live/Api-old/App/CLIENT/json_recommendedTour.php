<?php
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";

header("Content-Type: application/json");


//josn structure
$image='http://travcrm.in/travcrm-demo/packageimages/1608186180a13b71958a8f42dc8a53a4a9c987a82e.jpg';
$json_recommendedList .='{
    "name":"Delhi to colombo",
    "email":"test@gmail.com",
    "description":"test",
    "contactNumber":"8130220538",
    "image":"'.$image.'"
},';
$json_recommendedList .='{
    "name":"Delhi to Dubai",
    "email":"xyz@gmail.com",
    "description":"lorem",
    "contactNumber":"9910718728",
    "image":"'.$image.'"
},';

?>
{
    "status":"true",
    "recommendedList":[<?php echo trim($json_recommendedList, ',');?>]
}