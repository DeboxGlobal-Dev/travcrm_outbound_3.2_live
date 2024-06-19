<?php


// included files 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";


// headers 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");



$request = $_SERVER['REQUEST_METHOD'];

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
        $query = mysqli_query(db(),"SELECT * FROM target ".$where);
            while($row = mysqli_fetch_assoc($query)) {
                $january=$row['january'];
                $march=$row['march'];
                
                
                $json_result = "{
                'january':['.$january.'],
                'march':['.$march.']
                }";
    }

?>
{
    'status':'true',
    'results':[<?php echo trim($json_result, ','); ?>]
}