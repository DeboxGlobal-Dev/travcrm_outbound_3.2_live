<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$referanceNumber = trim($_REQUEST['RefId']);
if($referanceNumber!=''){
$rs1 = GetPageRecord('assignTo',_QUERY_MASTER_,'referanceNumber="'.$referanceNumber.'" and queryStatus=3');
$queryData = mysqli_fetch_assoc($rs1);

$where='status="1" and id="'.$queryData['assignTo'].'"'; 
$res = GetPageRecord('*',_USER_MASTER_,$where);
$opData = mysqli_fetch_assoc($res);

    $opsName = $opData['firstName'].' '.$opData['lastName'];
    $email = $opData['email'];
    $mobile = $opData['mobile'];
    $languageList = $opData['languagelist'];
    $lanArray =  explode(',',$languageList);
    // echo $lanArray['1'];
    foreach($lanArray as  $val){
        $rs=GetPageRecord('*','tbl_languagemaster','1 and name!="" and status=1 and deletestatus=0 and id="'.$val.'"');
            $langData = mysqli_fetch_assoc($rs);
         
           $lanArray2.= $langData['name'].' | ';
    }
 
    $json_result = '{
            "name" : "'.$opsName.'",
            "email" : "'.$email.'",
            "phoneno" : "'.$mobile.'",
            "language" : "'.$lanArray2.'"
    }';
   
?>
{
    "status":"true",
    "results":[<?php echo trim($json_result, ',');?>]
}
<?php }else{ 
                $resultMessage="Pleas enter reference number";
            $json_result='{
                "message" : "'.$resultMessage.'";
            }';

            ?>
            {
                "status":"true",
                "results" : [<?php echo trim($json_result, ','); ?>]
            }
    <?php } ?>