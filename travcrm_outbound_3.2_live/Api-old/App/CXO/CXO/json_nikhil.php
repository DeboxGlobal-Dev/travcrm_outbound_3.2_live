<?php
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header("Content-Type: application/json");




$request = $_SERVER['REQUEST_METHOD'];
$data = array();
switch ($request) {
    case 'GET':
        response(getDATA());
        break;

        default:
        #code.....
        break;
}
function getDATA(){
        if(@$_GET['id']){
            @$id = $_GET['id'];

            $where = "WHERE id=".$id;
        }else{
            $id=0;
            $where="";
        }
        $query = mysqli_query(db(),"SELECT * FROM suppliersMaster ".$where);
            while($row = mysqli_fetch_assoc($query)) {
                $data[]=array("id"=>$row['id'],"name"=>$row['name'],"contactPerson"=>$row['contactPerson'],"suppliersMainType"=>$row['suppliersMainType']);
                }
                return $data;
    }
function response($data){
    echo json_encode($data);
}
?>