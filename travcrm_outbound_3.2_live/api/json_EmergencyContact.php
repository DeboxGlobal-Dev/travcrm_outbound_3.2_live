<?php
include "../inc.php";

header("Content-Type: application/json");
 
$rs=mysqli_query(db(),"SELECT * FROM emergencyServicesMaster WHERE deletestatus=0 and type=1 order by id desc");
while($emergencyList=mysqli_fetch_array($rs)){
if($emergencyList['type'==1]){
$name=$emergencyList['name'];
$contactNumber=$emergencyList['contactNumber'];
}
//josn structure
$json_emergency .='{
    "name":"'.$name.'",
    "number":"'.$contactNumber.'"
},';
}
?>
{
    "status":"true",
    "emergency":[<?php echo trim($json_emergency, ',');?>]
}