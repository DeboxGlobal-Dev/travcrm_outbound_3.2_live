<?php
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";

header("Content-Type: application/json");
 
$rs=mysqli_query(db(),"SELECT * FROM emergencyServicesMaster WHERE deletestatus=0 and type=2 order by rand()");
while($sosList=mysqli_fetch_array($rs)){
$name=$sosList['name'];
$contactNumber=$sosList['contactNumber'];    
//josn structure
$json_sos .='{
    "name":"'.$name.'",
    "number":"'.$contactNumber.'"
},';
}
?>
{
    "status":"true",
    "emergency":[<?php echo trim($json_sos, ',');?>]
}