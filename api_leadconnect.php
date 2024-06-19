<?php 
    include 'inc.php';
    // header("Content-Type: application/json");
    // header('Access-Control-Allow-Origin: *');
    // header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

    header("Content-Type: application/json");
    $parameterdata = file_get_contents('php://input'); 

    $parameterdata = preg_replace('/[[:cntrl:]]/', '', $parameterdata);
    $parameterdata = stripslashes($parameterdata);
    $parameterdata = json_decode($parameterdata, true);
    $parameterdata = json_encode($parameterdata, JSON_PRETTY_PRINT);
    $leadData = json_decode($parameterdata, true);

    $accessToken = htmlentities(addslashes(trim($leadData['travelLead']['accessToken']['_token'])));
    $firstName = htmlentities(addslashes(trim($leadData['travelLead']['firstName']['name'])));
    $fromDate = htmlentities(addslashes(trim($leadData['travelLead']['fromDate']['date'])));
    $destination = htmlentities(addslashes(trim($leadData['travelLead']['destination']['fromDestination'])));
    $duration = htmlentities(addslashes(trim($leadData['travelLead']['duration']['duration'])));
    $adults = htmlentities(addslashes(trim($leadData['travelLead']['adults']['totalAdults'])));
    $emailAddress = htmlentities(addslashes(trim($leadData['travelLead']['emailAddress']['email'])));
    $phoneNumbre = htmlentities(addslashes(trim($leadData['travelLead']['phoneNumbre']['phone'])));

    $lastName = htmlentities(addslashes(trim($leadData['travelLead']['lastName'])));
    $toDate = htmlentities(addslashes(trim($leadData['travelLead']['toDate'])));
    $childs = htmlentities(addslashes(trim($leadData['travelLead']['childs'])));
    $tourType = htmlentities(addslashes(trim($leadData['travelLead']['tourType'])));
    $hotelCategory = htmlentities(addslashes(trim($leadData['travelLead']['hotelCategory'])));
    $budget = htmlentities(addslashes(trim($leadData['travelLead']['budget'])));
    $sglRoom = htmlentities(addslashes(trim($leadData['travelLead']['sglRoom'])));
    $dblRoom = htmlentities(addslashes(trim($leadData['travelLead']['dblRoom'])));
    $twinRoom = htmlentities(addslashes(trim($leadData['travelLead']['twinRoom'])));
    $tplRoom = htmlentities(addslashes(trim($leadData['travelLead']['tplRoom'])));
    $extraBedA = htmlentities(addslashes(trim($leadData['travelLead']['extraBedA'])));
    $extraBedC = htmlentities(addslashes(trim($leadData['travelLead']['extraBedC'])));
    $CNBed = htmlentities(addslashes(trim($leadData['travelLead']['CNBed'])));
    $description = htmlentities(addslashes(trim($leadData['travelLead']['description'])));
    

        $fromDate=date('Y-m-d',strtotime($fromDate));
        if($toDate!='' && $toDate!='1970-01-01' && $fromDate!='' && $fromDate!='1970-01-01'){
           
            $toDate=date('Y-m-d',strtotime($toDate));
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);
            $interval = $date1->diff($date2);
            $nights = $interval->days;
        }else{
            // $duration=date('Y-m-d',strtotime($_POST['duration']));
            $toDate=date('Y-m-d', strtotime($fromDate. ' + '.$duration.' days'));
            $diff = abs(strtotime($toDate) - strtotime($fromDate)); 
		    $nights= round($diff/(60*60*24));
        }
        
         // $token = 'CRMTL2233556';
        // echo encode($token);
        //VVRGS1RsWkZkM2xOYWsxNlRsUlZNZz09
        
		$FullName=$firstName.' '.$lastName;
        if(decode($accessToken)=='CRMTL2233556'){
            
    //if($firstName!='' && $fromDate!='' && $destination!='' && $nights!='' && $adults!='' && $emailAddress!='' && $phoneNumbre!=''){

        $namevalue1 ='contactType="2",firstName="'.$firstName.'",lastName="'.$lastName.'",deletestatus=0,status=1,addedBy="37",dateAdded="'.date('Y-m-d').'"';
        $lastId = addlistinggetlastid(_CONTACT_MASTER_,$namevalue1); 
    
        $namevalueEmail ='email="'.$emailAddress.'",emailType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastId.'",addedBy="37"';

        $EmailId = addlistinggetlastid(_EMAIL_MASTER_,$namevalueEmail);

        $valuephone ='phoneNo="'.$phoneNumbre.'",countryCode="+91",phoneType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastId.'",EID="'.$EmailId.'",addedBy="37"';
        $add = addlisting(_PHONE_MASTER_,$valuephone);
     
       $namevalue ='deletestatus=0,fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$FullName.'",addedBy="37",dateAdded="'.time().'",clientType="2",leadsource=8,description="'.$description.'",adult="'.$adults.'",Child="'.$child.'",categoryId="'.$hotelCategory.'",companyId="'.$lastId.'",night2="'.$nights.'",destination="'.$destination.'"';
                
        $add = addlisting('leadManageMaster',$namevalue); 
    
        if($add=='yes'){
           
            echo 'Form submitted successfully';
            
        }
    // }else{
    //     echo 'Please fill the mandatory fields';
    // }
    }else{
        echo 'Invalid Token';
    }

?>
