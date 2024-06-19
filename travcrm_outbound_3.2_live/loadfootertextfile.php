<?php

include "inc.php";

if($_REQUEST['action']=="showHidefooter"){

    $res = GetPageRecord('*','companySettingsMaster','id="1"');
    $result = mysqli_fetch_assoc($res);

    if($result['footerstatus'] == '0'){
        $status = 1;
    }else{
        $status = 0;
    }

    $namevalue = 'footerstatus="'.$status.'"';
     $where = 'id="1"';
    updatelisting('companySettingsMaster',$namevalue,$where);
    ?>
   
    <?php
}

?>