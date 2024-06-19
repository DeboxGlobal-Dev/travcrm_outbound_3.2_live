<?php 
include "inc.php";


if($_REQUEST['action']=='finalereportStatus' && $_REQUEST['statusId']!=''){

    $namevalue='reportstatus="'.$_REQUEST['statusId'].'"';

    $where = 'masterId="'.$_REQUEST['documentId'].'" and docType=1';
    updatelisting('documentMaster',$namevalue,$where);

    $where = 'masterId="'.$_REQUEST['documentId'].'" and docType=2';
    updatelisting('documentMaster',$namevalue,$where);

    $where = 'masterId="'.$_REQUEST['documentId'].'" and docType=3';
    updatelisting('documentMaster',$namevalue,$where);
}


if($_REQUEST['action']=='addressStatusreport' && $_REQUEST['statusId']!=''){

    $namevalue='addproofstatus="'.$_REQUEST['statusId'].'"';

    $where = 'masterId="'.$_REQUEST['documentId'].'" and docType=1';
    updatelisting('documentMaster',$namevalue,$where);
}


if($_REQUEST['action']=='visaStatusreport' && $_REQUEST['statusId']!=''){

    $namevalue = 'visastatus="'.$_REQUEST['statusId'].'"';

    $where = 'masterId="'.$_REQUEST['documentId'].'" and docType=3';
    updatelisting('documentMaster',$namevalue,$where);
}

if($_REQUEST['action']=='passportStatusreport' && $_REQUEST['statusId']!=''){

    $namevalue='passportstatus="'.$_REQUEST['statusId'].'"';

    $where = 'masterId="'.$_REQUEST['documentId'].'" and docType=2';
    updatelisting('documentMaster',$namevalue,$where);
}

?>