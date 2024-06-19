<?php 
    include 'inc.php';
    header("Content-Type: application/json");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

    $parameterdata = file_get_contents('php://input'); 

        $fromDate=date('Y-m-d',strtotime($_POST['fromDate']));
        if($_POST['toDate']!='' && $_POST['toDate']!='1970-01-01'){
           
            $toDate=date('Y-m-d',strtotime($_POST['toDate']));
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);
            $interval = $date1->diff($date2);
            $nights = $interval->days;
        }else{
            $duration=date('Y-m-d',strtotime($_POST['duration']));
            $toDate=date('Y-m-d', strtotime($fromDate. ' + '.$duration.' days'));
            $diff = abs(strtotime($toDate) - strtotime($fromDate)); 
		    $nights= round($diff/(60*60*24));
        }
    
		$destination = htmlentities(addslashes(trim($_POST['destination'])));
		
		$financeYear = getFinancialYear($fromDate);

		$adult=htmlentities(addslashes(trim($_POST['adults'])));
		$child=htmlentities(addslashes(trim($_POST['childs'])));
		$tourtype=htmlentities(addslashes(trim($_POST['tourtype'])));
		$hotelCategory=htmlentities(addslashes(trim($_POST['hotelCategory'])));
		$budget=htmlentities(addslashes(trim($_POST['budget'])));
		$flight_requirement=htmlentities(addslashes(trim($_POST['flight_requirement'])));

		$firstName=htmlentities(addslashes(trim($_POST['firstName'])));
		$lastName=htmlentities(addslashes(trim($_POST['lastName'])));

		$contryCode=$_POST['contryCode'];

		$sglRoom=htmlentities(addslashes(trim($_POST['sglRoom'])));
		$dblRoom=htmlentities(addslashes(trim($_POST['dblRoom'])));
		$twinRoom=htmlentities(addslashes(trim($_POST['twinRoom'])));
		$tplRoom=htmlentities(addslashes(trim($_POST['tplRoom'])));
		$ExtraBed=htmlentities(addslashes(trim($_POST['ExtraBed'])));
		$CWBed=htmlentities(addslashes(trim($_POST['CWBed'])));
		$CNBed=htmlentities(addslashes(trim($_POST['CNBed'])));

		$email=htmlentities(addslashes(trim($_POST['email']))); 
		$phone=htmlentities(addslashes(trim($_POST['phone'])));
	
		$yourmessage=htmlentities(addslashes(trim($_POST['yourmessage'])));

		$FullName=$firstName.' '.$lastName;

        $namevalue1 ='contactType="2",firstName="'.$firstName.'",lastName="'.$lastName.'",deletestatus=0,status=1,addedBy="37",dateAdded="'.date('Y-m-d').'"';
        $lastId = addlistinggetlastid(_CONTACT_MASTER_,$namevalue1); 
    
        $namevalueEmail ='email="'.$email.'",emailType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastId.'",addedBy="37"';

        $EmailId = addlistinggetlastid(_EMAIL_MASTER_,$namevalueEmail);

        $valuephone ='phoneNo="'.$phone.'",countryCode="+91",phoneType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastId.'",EID="'.$EmailId.'",addedBy="37"';
        $add = addlisting(_PHONE_MASTER_,$valuephone);
     
       $namevalue ='deletestatus=0,fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$FullName.'",addedBy="37",dateAdded="'.time().'",clientType="2",leadsource=8,description="'.$yourmessage.'",adult="'.$adult.'",Child="'.$child.'",categoryId="'.$hotelCategory.'",companyId="'.$lastId.'",night2="'.$nights.'",destination="'.$destination.'"';
                
        $add = addlisting('leadManageMaster',$namevalue); 
    
        if($add=='yes'){
           
            echo 'Form submitted successfully';
            
        }

?>
