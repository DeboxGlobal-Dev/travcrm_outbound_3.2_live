<?php
include "inc.php";  


$rs='';
// echo ' name!="" and name LIKE "%'.clean($_REQUEST['q']).'%" and deletestatus=0 order by id asc';
$rs=GetPageRecord('*',_DESTINATION_MASTER_,' name!="" and name LIKE "%'.clean($_REQUEST['q']).'%" and deletestatus=0 order by name asc limit 50');
$results = array();
$results[] = array(
        'id' => 'all_dest',
        'text' => 'All'
    );
while ($destData = mysqli_fetch_assoc($rs)) {
    $results[] = array(
        'id' => $destData['id'],
        'text' => $destData['name']
    );
}

header('Content-Type: application/json');
echo json_encode($results);
?>