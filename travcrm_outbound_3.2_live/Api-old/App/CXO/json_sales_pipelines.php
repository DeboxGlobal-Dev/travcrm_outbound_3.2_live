<?php
	header('Content-type: text/html');
	//header("Content-Type: application/json");
	// include "../../../travcrm-dev/inc.php";
    include "../../../inc.php";
    $startdate=date('Y-m').'-1';
    $enddate=date('Y-m').'-30';
    $whereQuery=' and fromDate>"'.$startdate.'" and fromDate<"'.$enddate.'"';


class clsDBResponse 
{
    public $Status;
    public $DataTable=array();
}

class clsDataTable
{
    public $Assigned20=array();
    public $Reverted40=array();
    public $OptionSent60=array();
    public $FollowUp80=array();
    public $Confirmed100=array();
    public $QueryLost0=array();
}

$loginuserprofileId=1;
if($loginuserprofileId==1){ 

$wheresearchassign='1';

} else { 

 $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
 
  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))'; 

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

}

try {
    // Assigned20 start
    $noQry=0;
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';   
    $where=''.$wheresearchassign.' and queryStatus=1 and deletestatus=0 '.$whereQuery.' order by id'; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where);
    $noQry=mysqli_num_rows($rs); 

    $Assigned20Array = array();
    $a = array_push($Assigned20Array,array('querycount'=>$noQry));

    while($resquery=mysqli_fetch_array($rs)){

        $rsquery=GetPageRecord('*','queryMaster',' companyId='.$resquery['id'].' and clientType=1 '.$whereQuery.' order by id asc ');         
        $pax=0;
        while($queryData=mysqli_fetch_array($rsquery)){
            $totalpax = $queryData['adult']+$queryData['child'];
            $pax = $pax+$totalpax;
        }

        $operationalPerson=getUserName($resquery['assignTo']);
        $salesPerson=$resquery['salesassignTo'];
 
        $desIds=explode(",",$resquery['destinationId']);
        $destinationArray20= array();
        
        foreach ($desIds as $key => $desId) {
            $sele='*';
            $whereDest=' id="'.$desId.'" ';
            $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
            $ddest=mysqli_fetch_array($rsDest);
            $b=array_push($destinationArray20, $ddest['name']);           
        }

        $companyNameData =  showClientTypeUserName($resquery['clientType'],$resquery['companyId']);
        $dataArray = array('agentname' => $companyNameData, 'destinations' => $destinationArray20, 'tourdate' => $resquery['fromDate'], 'operationalperson' => $operationalPerson, 'salesperson' => $salesPerson, 'totalpax' => $pax);
        $a = array_push($Assigned20Array,$dataArray);
    }

    // Assigned20 start end

    

    // Reverted40 start 
    $noQry=0;
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';   
    $where=''.$wheresearchassign.' and queryStatus=2 and deletestatus=0 '.$whereQuery.' order by id'; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
    $noQry=mysqli_num_rows($rs);

    $Reverted40Array = array();
    $a = array_push($Reverted40Array,array('querycount'=>$noQry));
    while($resquery=mysqli_fetch_array($rs)){ 

        $rsquery=GetPageRecord('*','queryMaster',' companyId='.$resquery['id'].' and clientType=1 '.$whereQuery.' order by id asc ');         
        $pax=0;
        while($queryData=mysqli_fetch_array($rsquery)){
            $totalpax = $queryData['adult']+$queryData['child'];
            $pax = $pax+$totalpax;
        }

        $operationalPerson=getUserName($resquery['assignTo']);
        $salesPerson=$resquery['salesassignTo'];

        $desIds=explode(",",$resquery['destinationId']);
        $destinationArray40= array();
        
        foreach ($desIds as $key => $desId) {
            $sele='*';
            $whereDest=' id="'.$desId.'" ';
            $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
            $ddest=mysqli_fetch_array($rsDest);
            $b=array_push($destinationArray40, $ddest['name']);           
        }

        $companyNameData =  showClientTypeUserName($resquery['clientType'],$resquery['companyId']);
        $dataArray = array('agentname' => $companyNameData, 'destinations' => $destinationArray40, 'tourdate' => $resquery['fromDate'], 'operationalperson' => $operationalPerson, 'salesperson' => $salesPerson, 'totalpax' => $pax);
        $a = array_push($Reverted40Array,$dataArray);
    }


    // Reverted40  end



    // OptionSent60 start
    $noQry=0;
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';   
    $where=''.$wheresearchassign.' and queryStatus=6 and deletestatus=0 '.$whereQuery.' order by id'; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
    $noQry=mysqli_num_rows($rs);

    $OptionSent60Array=array();
    $a = array_push($OptionSent60Array,array('querycount'=>$noQry));

    while($resquery=mysqli_fetch_array($rs)){ 

        $rsquery=GetPageRecord('*','queryMaster',' companyId='.$resquery['id'].' and clientType=1 '.$whereQuery.' order by id asc ');         
        $pax=0;
        while($queryData=mysqli_fetch_array($rsquery)){
            $totalpax = $queryData['adult']+$queryData['child'];
            $pax = $pax+$totalpax;
        }        

        $operationalPerson=getUserName($resquery['assignTo']);
        $salesPerson=$resquery['salesassignTo'];  

        $desIds=explode(",",$resquery['destinationId']);
        $destinationArray60= array();
        
        foreach ($desIds as $key => $desId) {
            $sele='*';
            $whereDest=' id="'.$desId.'" ';
            $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
            $ddest=mysqli_fetch_array($rsDest);
            $b=array_push($destinationArray60, $ddest['name']);           
        }

        $companyNameData =  showClientTypeUserName($resquery['clientType'],$resquery['companyId']);
        $dataArray = array('agentname' => $companyNameData, 'destinations' => $destinationArray60, 'tourdate' => $resquery['fromDate'], 'operationalperson' => $operationalPerson, 'salesperson' => $salesPerson, 'totalpax' => $pax);
        $a = array_push($OptionSent60Array,$dataArray);
    }  

    // OptionSent60  end



    // FollowUp80 start

    $noQry=0;
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';   
    $where=''.$wheresearchassign.' and queryStatus=7 and deletestatus=0 '.$whereQuery.' order by id'; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
    $noQry=mysqli_num_rows($rs);

    $FollowUp80Array=array();
    $a = array_push($FollowUp80Array,array('querycount'=>$noQry));
    while($resquery=mysqli_fetch_array($rs)){ 

        $rsquery=GetPageRecord('*','queryMaster',' companyId='.$resquery['id'].' and clientType=1 '.$whereQuery.' order by id asc ');         
        $pax=0;
        while($queryData=mysqli_fetch_array($rsquery)){
            $totalpax = $queryData['adult']+$queryData['child'];
            $pax = $pax+$totalpax;
        }        
        
        $operationalPerson=getUserName($resquery['assignTo']);
        $salesPerson=$resquery['salesassignTo'];
            
        $desIds=explode(",",$resquery['destinationId']);
        $destinationArray80= array();
        
        foreach ($desIds as $key => $desId) {
            $sele='*';
            $whereDest=' id="'.$desId.'" ';
            $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
            $ddest=mysqli_fetch_array($rsDest);
            $b=array_push($destinationArray80, $ddest['name']);           
        }

        $companyNameData =  showClientTypeUserName($resquery['clientType'],$resquery['companyId']);
        $dataArray = array('agentname' => $companyNameData, 'destinations' => $destinationArray80, 'tourdate' => $resquery['fromDate'], 'operationalperson' => $operationalPerson, 'salesperson' => $salesPerson, 'totalpax' => $pax);
        $a = array_push($FollowUp80Array,$dataArray);
    }


    // FollowUp80 end

 

    // Confirmed100 start
    $noQry=0;
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';   
    $where=''.$wheresearchassign.' and queryStatus=3 and deletestatus=0 '.$whereQuery.' order by id'; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
    $noQry=mysqli_num_rows($rs);

    $Confirmed100Array=array();
    $a = array_push($Confirmed100Array,array('querycount'=>$noQry));
    while($resquery=mysqli_fetch_array($rs)){ 

        $rsquery=GetPageRecord('*','queryMaster',' companyId='.$resquery['id'].' and clientType=1 '.$whereQuery.' order by id asc ');         
        $pax=0;
        while($queryData=mysqli_fetch_array($rsquery)){
            $totalpax = $queryData['adult']+$queryData['child'];
            $pax = $pax+$totalpax;
        }        

        $operationalPerson=getUserName($resquery['assignTo']);        
        $salesPerson=$resquery['salesassignTo'];

        $desIds=explode(",",$resquery['destinationId']);
        $destinationArray100= array();
        
        foreach ($desIds as $key => $desId) {
            $sele='*';
            $whereDest=' id="'.$desId.'" ';
            $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
            $ddest=mysqli_fetch_array($rsDest);
            $b=array_push($destinationArray100, $ddest['name']);           
        }

        $companyNameData =  showClientTypeUserName($resquery['clientType'],$resquery['companyId']);
        $dataArray = array('agentname' => $companyNameData, 'destinations' => $destinationArray100, 'tourdate' => $resquery['fromDate'], 'operationalperson' => $operationalPerson, 'salesperson' => $salesPerson, 'totalpax' => $pax);
        $a = array_push($Confirmed100Array,$dataArray);
    }   

    // Confirmed100 start end



    // QueryLost0 start
    $noQry=0;
    $select=''; 
    $where=''; 
    $rs='';  
    $select='*';   
    $where=''.$wheresearchassign.' and queryStatus=4 and deletestatus=0 '.$whereQuery.' order by id'; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
    $noQry=mysqli_num_rows($rs);

    $QueryLost0Array=array();
    $a = array_push($QueryLost0Array,array('querycount'=>$noQry));
    while($resquery=mysqli_fetch_array($rs)){ 

        $rsquery=GetPageRecord('*','queryMaster',' companyId='.$resquery['id'].' and clientType=1 '.$whereQuery.' order by id asc ');         
        $pax=0;
        while($queryData=mysqli_fetch_array($rsquery)){
            $totalpax = $queryData['adult']+$queryData['child'];
            $pax = $pax+$totalpax;
        }        

        $operationalPerson=getUserName($resquery['assignTo']); 
        $salesPerson=$resquery['salesassignTo'];
            
        $desIds=explode(",",$resquery['destinationId']);
        $destinationArray0= array();
        
        foreach ($desIds as $key => $desId) {
            $sele='*';
            $whereDest=' id="'.$desId.'" ';
            $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
            $ddest=mysqli_fetch_array($rsDest);
            $b=array_push($destinationArray0, $ddest['name']);           
        }

        $companyNameData =  showClientTypeUserName($resquery['clientType'],$resquery['companyId']);
        $dataArray = array('agentname' => $companyNameData, 'destinations' => $destinationArray0, 'tourdate' => $resquery['fromDate'], 'operationalperson' => $operationalPerson, 'salesperson' => $salesPerson, 'totalpax' => $pax);
        $a = array_push($QueryLost0Array,$dataArray);
    }



    // QueryLost0 end 

    $dataTableArray = new clsDataTable();
    $dataTableArray->Assigned20 = $Assigned20Array;
    $dataTableArray->Reverted40 = $Reverted40Array;
    $dataTableArray->OptionSent60 = $OptionSent60Array;
    $dataTableArray->FollowUp80 = $FollowUp80Array;
    $dataTableArray->Confirmed100 = $Confirmed100Array;
    $dataTableArray->QueryLost0 = $QueryLost0Array;


    $objResponse = new clsDBResponse();
    $objResponse->Status = "true";
    $objResponse->DataTable = $dataTableArray;

} catch (Exception $e) {
    $objResponse->Status = "false";
    echo "Exception Sales Pipelines API  ===>  ". $e->getMessage();  
}

finally
{
    echo json_encode($objResponse,JSON_PRETTY_PRINT);
}


?>