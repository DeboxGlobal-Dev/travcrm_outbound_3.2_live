<?php 
include "inc.php"; 
function MISuploadlogger($errorlog){
    $newfile =  'artibotlog/Debuglog_'.date('dmy').'.txt';
    if(!file_exists($newfile)){
      file_put_contents($newfile,'');
    }
    $logfile=fopen($newfile,'a');
    
    $ip = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set('Asia/Kolkata');
    $time = date('d-m-Y h:i:s A',time());
    $contents = "$ip\t$time\t$errorlog\r";
    fwrite($logfile,$contents);
} 
   
MISuploadlogger("\n\n\n********************* Inside Commission Master API *******************************");

define("INF","{INFO} -");
define("ERR","{ERROR} -");
define("DBG","{DEBUG} -");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input'); 
 

// $parameterdata = '{"lead":{"id":"914ff405-5ddf-4d67-ae2b-8049e4e5501f","create_date":"2022-07-14T09:30:39.077162","modify_date":"2022-07-14T09:32:02.862593","bot_id":"dfd36ff1-8a12-4c11-87f1-21a827b4662b","bot_version_id":"735fcdd6-9811-4248-8c4e-5688eee8412d","account_id":"c7fbf472-5f25-4fb7-980c-cb235a4dab88","contact_id":"1fc7ca05-124e-4cce-b386-c0816ab8b1f3","status":"active","closed_status":"ended","version":15,"data":{"Category":{"input":"Delux","type":"multiple_choice","display_value":"Delux","value":"Delux"},"Whatsaap":{"input":"9910910190","type":"number","display_value":"9910910190","value":9910910190.0},"Mobile No":{"input":"9910910910","type":"number","display_value":"9910910910","value":9910910910.0},"Name First":{"input":"samaydin","type":"text","display_value":"samaydin","value":"samaydin"},"No of Days":{"input":"4","type":"number","display_value":"4","value":4.0},"Travel Date":{"input":"7/28/22 9:31:00 AM","type":"date_time","display_value":"7/28/22","value":{"date_time":"2022-07-28T09:31:00Z","grain":"day","timezone":"Asia/Calcutta"}},"No of Adults":{"input":"2","type":"number","display_value":"2","value":2.0},"Package Type":{"input":"Dham Yatra","type":"multiple_choice","display_value":"Dham Yatra","value":"Dham Yatra"},"Type of Dham":{"input":"Do Dham","type":"multiple_choice","display_value":"Do Dham","value":"Do Dham"},"Which DoDham":{"input":"Kedarnath ji & Badrinath ji","type":"multiple_choice","display_value":"Kedarnath ji & Badrinath ji","value":"Kedarnath ji & Badrinath ji"},"No of Child (5-11)":{"input":"0","type":"number","display_value":"0","value":0.0},"No of Room Require":{"input":"2","type":"number","display_value":"2","value":2.0},"Starting End Point":{"input":"Delhi","type":"multiple_choice","display_value":"Delhi","value":"Delhi"},"communication Email":{"input":"test@deboxglobal.com","type":"email","display_value":"test@deboxglobal.com","value":"test@deboxglobal.com"},"Additional Information":{"input":"No, Thanks","type":"multiple_choice","display_value":"No, Thanks","value":"No, Thanks"}}},"meta":{"chat_start_page":"https://www.bizarexpedition.com/","ip_address":"122.161.49.95","location":{"country_abbreviation":"IN","country":"India","state":"National Capital Territory of Delhi","city":"New Delhi","latitude":"28.6","longitude":"77.2"},"browser":{"user_agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.0","name":"Firefox","version":"102","major":null,"is_mobile":false}},"resource":"lead","action":"completed","resource_id":"914ff405-5ddf-4d67-ae2b-8049e4e5501f","time_stamp":"2022-07-14T09:32:04.334898Z","resource_version":15}';
// $parameterdata = '{"lead":{"id":"3f7e1ae4-eb0f-450f-a25c-0528dc57bff4","create_date":"2022-11-18T06:45:19.119065","modify_date":"2022-11-18T06:46:49.1757192Z","bot_id":"6e7a96ec-0e56-4e67-a4a3-045d6a267fd8","bot_version_id":"c224ee3e-db8c-4cb4-8f17-ad21ce885ce5","account_id":"7882321e-cbf2-4a18-99cf-0433cbcf5dbc","contact_id":"9fa07868-e605-48da-8cda-db11d666ebc6","status":"active","closed_status":null,"version":14,"data":{"Name":{"input":"Samaydin","type":"text","display_value":"Samaydin","value":"Samaydin"},"Email":{"input":"samay.dbox@gmail.com","type":"email","display_value":"samay.dbox@gmail.com","value":"samay.dbox@gmail.com"},"Question 1":{"input":"Dham yatra","type":"multiple_choice","display_value":"Dham yatra","value":"Dham yatra"},"Question 2":{"input":"Do Dham","type":"multiple_choice","display_value":"Do Dham","value":"Do Dham"},"Question 3":{"input":"Kedarnath ji & Badrinath Ji","type":"multiple_choice","display_value":"Kedarnath ji & Badrinath Ji","value":"Kedarnath ji & Badrinath Ji"},"Question 4":{"input":"11/18/22 6:46:00 AM","type":"date_time","display_value":"11/18/22","value":{"date_time":"2022-11-18T06:46:00Z","grain":"day","timezone":"Asia/Kolkata"}},"Question 5":{"input":"4","type":"text","display_value":"4","value":"4"},"Question 6":{"input":"Deluxe","type":"multiple_choice","display_value":"Deluxe","value":"Deluxe"},"Question 7":{"input":"2","type":"text","display_value":"2","value":"2"},"Question 8":{"input":"Delhi","type":"multiple_choice","display_value":"Delhi","value":"Delhi"},"Question 9":{"input":"4","type":"text","display_value":"4","value":"4"},"Question 10":{"input":"0","type":"text","display_value":"0","value":"0"},"Phone Number":{"input":"9813198549","type":"phone_number","display_value":"9813198549","value":"9813198549"},"Question 11":{"input":"No, Thanks","type":"multiple_choice","display_value":"No, Thanks","value":"No, Thanks"}}},"meta":{"chat_start_page":"https://travcrm.in/travcrm-demooutbound/landing_page/","ip_address":"49.42.81.80","location":{"country_abbreviation":"IN","country":"India","state":null,"city":null,"latitude":"20","longitude":"77"},"browser":{"user_agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36","name":"Chrome","version":"107","major":null,"is_mobile":false},"last_answered_field_name":"Question 11"},"resource":"lead","action":"updated","resource_id":"3f7e1ae4-eb0f-450f-a25c-0528dc57bff4","time_stamp":"2022-11-18T06:46:49.3992534Z","resource_version":14}';
// $parameterdata = '{"lead":{"id":"2423bf0a-9842-4fcc-917c-c4bb56edb5db","create_date":"2023-12-16T09:48:24.854529","modify_date":"2023-12-16T09:50:31.280563","bot_id":"6e7a96ec-0e56-4e67-a4a3-045d6a267fd8","bot_version_id":"75ce3dbb-69fd-41d1-8cf6-531325f08831","account_id":"7882321e-cbf2-4a18-99cf-0433cbcf5dbc","contact_id":"5968ae29-2d6b-4aae-9ce5-0d3d36782ca0","status":"active","closed_status":"ended","version":15,"data":{"Name":{"input":"Nasir khan","type":"text","display_value":"Nasir khan","value":"Nasir khan"},"Email":{"input":"nasirkhan@gmail.com","type":"email","display_value":"nasirkhan@gmail.com","value":"nasirkhan@gmail.com"},"Question 1":{"input":"Dham yatra","type":"multiple_choice","display_value":"Dham yatra","value":"Dham yatra"},"Question 2":{"input":"Do Dham","type":"multiple_choice","display_value":"Do Dham","value":"Do Dham"},"Question 3":{"input":"Kedarnath ji & Badrinath Ji","type":"multiple_choice","display_value":"Kedarnath ji & Badrinath Ji","value":"Kedarnath ji & Badrinath Ji"},"Question 4":{"input":"12/31/23 9:49:00 AM","type":"date_time","display_value":"12/31/2023","value":{"date_time":"2023-12-31T09:49:00Z","grain":"day","timezone":"Asia/Kolkata"}},"Question 5":{"input":"10","type":"text","display_value":"10","value":"10"},"Question 6":{"input":"Deluxe","type":"multiple_choice","display_value":"Deluxe","value":"Deluxe"},"Question 7":{"input":"4","type":"text","display_value":"4","value":"4"},"Question 8":{"input":"Delhi","type":"multiple_choice","display_value":"Delhi","value":"Delhi"},"Question 9":{"input":"8","type":"text","display_value":"8","value":"8"},"Question 10":{"input":"1","type":"text","display_value":"1","value":"1"},"Question 11":{"input":"No, Thanks","type":"multiple_choice","display_value":"No, Thanks","value":"No, Thanks"},"Question 12":{"input":"9876756868","type":"phone_number","display_value":"9876756868","value":"9876756868"},"Phone Number":{"input":"9868768668","type":"phone_number","display_value":"9868768668","value":"9868768668"}}},"meta":{"chat_start_page":"https://travcrm.in/travcrm-demooutbound/newwebform/","ip_address":"122.161.48.166","location":{"country_abbreviation":"IN","country":"India","state":"National Capital Territory of Delhi","city":"New Delhi","latitude":"28.6","longitude":"77.2"},"browser":{"user_agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36","name":"Chrome","version":"120","major":null,"is_mobile":false}},"resource":"lead","action":"completed","resource_id":"2423bf0a-9842-4fcc-917c-c4bb56edb5db","time_stamp":"2023-12-16T09:50:31.8289374Z","resource_version":15}';


MISuploadlogger("Parameter Json \n".$parameterdata);

$parameterdata = preg_replace('/[[:cntrl:]]/', '', $parameterdata);
$parameterdata = stripslashes($parameterdata);
$parameterdata = json_decode($parameterdata, true);
$parameterdata = json_encode($parameterdata, JSON_PRETTY_PRINT);
$leadData = json_decode($parameterdata, true);
// print_r($leadData);
// exit;


$create_date = htmlentities(addslashes(trim($leadData['lead']['create_date'])));
$modify_date = htmlentities(addslashes(trim($leadData['lead']['modify_date'])));
$bot_id = htmlentities(addslashes(trim($leadData['lead']['bot_id'])));
$bot_version_id = htmlentities(addslashes(trim($leadData['lead']['bot_version_id'])));
$account_id = htmlentities(addslashes(trim($leadData['lead']['account_id'])));
$contact_id = htmlentities(addslashes(trim($leadData['lead']['contact_id'])));
$status = htmlentities(addslashes(trim($leadData['lead']['status'])));
$closed_status = htmlentities(addslashes(trim($leadData['lead']['closed_status'])));
$version = htmlentities(addslashes(trim($leadData['lead']['version'])));
 

$FirstName = htmlentities(ucfirst(trim($leadData['lead']['data']['Name']['value']))); 
$email = trim($leadData['lead']['data']['Email']['value']);
$phoneNumber = htmlentities(addslashes(trim($leadData['lead']['data']['Phone Number']['value'])));
$PackageType = htmlentities(addslashes(trim($leadData['lead']['data']['Question 1']['value'])));

$fromDate = trim($leadData['lead']['data']['Travel Date']['input']);
$NoofDays = trim($leadData['lead']['data']['No of Days']['value']);
$CategoryType = htmlentities(addslashes(trim($leadData['lead']['data']['Category']['value'])));
$adult = trim($leadData['lead']['data']['No of Adults']['value']);
$child = trim($leadData['lead']['data']['No of Child (5-11)']['value']);
$rooms = trim($leadData['lead']['data']['No of Room Require']['value']);
$StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Starting End Point']['value'])));
$additionals = htmlentities(addslashes(trim($leadData['lead']['data']['Additional Information']['value'])));

if($PackageType == 'Dham yatra'){
    $TypeofDham = htmlentities(addslashes(trim($leadData['lead']['data']['Question 2']['value'])));
    if($TypeofDham == 'Ek Dham'){
        $WhichDoDham = htmlentities(addslashes(trim($leadData['lead']['data']['Which Ek Dham']['value'])));
    }elseif($TypeofDham == 'Do Dham'){
        $WhichDoDham = htmlentities(addslashes(trim($leadData['lead']['data']['Question 3']['value'])));
        if($WhichDoDham == 'Others'){
            $WhichDoDham = htmlentities(addslashes(trim($leadData['lead']['data']['other Do dham option']['value'])));
        } 
    }else{
        $WhichDoDham = '';
    }
    $subTourType = addslashes($TypeofDham.'/'.$WhichDoDham);


    $fromDate = trim($leadData['lead']['data']['Question 4']['input']);
    $NoofDays = trim($leadData['lead']['data']['Question 5']['value']);
    $CategoryType = htmlentities(addslashes(trim($leadData['lead']['data']['Question 6']['value'])));
    $rooms = trim($leadData['lead']['data']['Question 7']['value']);

    $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Question 8']['input'])));
    $adult = trim($leadData['lead']['data']['Question 9']['value']);
    $child = trim($leadData['lead']['data']['Question 10']['value']);
 
    $isAdditional = htmlentities(addslashes(trim($leadData['lead']['data']['Question 11']['value'])));
    if($isAdditional == 'Yes'){
        $additionals = htmlentities(addslashes(trim($leadData['lead']['data']['Additional Information Text']['value'])));
    } 
}elseif($PackageType == 'Hillstation'){
    $subTourType = htmlentities(addslashes(trim($leadData['lead']['data']['Hillstation Question 1']['input'])));
    $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Hillstation Starting End Point']['input'])));
    if($StartingEndPoint == 'Others'){
        $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Other Hillstation Starting End']['value'])));
    } 

    $isAdditional = htmlentities(addslashes(trim($leadData['lead']['data']['Hillstation Additional Info']['value'])));
    if($isAdditional == 'Yes'){
        $additionals = htmlentities(addslashes(trim($leadData['lead']['data']['Hillstation Addtn Info Text']['value'])));
    }
    $phone = trim($leadData['lead']['data']['Hillstation Mobile No 1']['value']);

}elseif($PackageType == 'Trekking and Camping'){
    $subTourType = htmlentities(addslashes(trim($leadData['lead']['data']['T& C Qtn 1']['input']))).'/'.htmlentities(addslashes(trim($leadData['lead']['data']['Trek and C strting & Con City']['input'])));
    // $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Trek & Camp Qtn 3']['input'])));
     $fromDate = trim($leadData['lead']['data']['T & C Travel Date']['input']);
    $NoofDays = trim($leadData['lead']['data']['Trek & Camp No of Days Planned']['value']);
    $sharingType = trim($leadData['lead']['data']['Trek and Camp Sharing option']['value']);
    if($sharingType == 'Others'){
        $sharingType = htmlentities(addslashes(trim($leadData['lead']['data']['T and C other option']['input'])));
    }
    $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Trek and C strting & Con City']['input'])));
    if($StartingEndPoint == 'Others'){
        $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Trek and camp Q3']['value'])));
    } 
    $rooms = trim($leadData['lead']['data']['No of Room Require']['value']);
    $adult = trim($leadData['lead']['data']['T & C No of Adults 1']['value']);
    $child = trim($leadData['lead']['data']['T & C No of Child 5-11 years']['value']);

    $isAdditional = htmlentities(addslashes(trim($leadData['lead']['data']['T & C Additional Info']['value'])));
    if($isAdditional == 'Yes'){
        $additionals = htmlentities(addslashes(trim($leadData['lead']['data']['T & C Additional Info 1']['value'])));
    }
    $phone = trim($leadData['lead']['data']['T & C Mobile No']['value']);

}elseif($PackageType == 'Looking for Transport option'){
    $subTourType = htmlentities(addslashes(trim($leadData['lead']['data']['TPP Type']['input'])));

}elseif($PackageType == 'Others'){
    $subTourType = htmlentities(addslashes(trim($leadData['lead']['data']['Hillstation Question 1']['input'])));
    $StartingEndPoint = htmlentities(addslashes(trim($leadData['lead']['data']['Other option Destination Q 1']['input'])));
}
else{
    $errors = 1;
}

MISuploadlogger($errors);

$meta_ip = trim($leadData['meta']['ip_address']);
$meta_location_sortName = htmlentities(addslashes(trim($leadData['meta']['location']['country_abbreviation'])));
$meta_location_country = htmlentities(addslashes(trim($leadData['meta']['location']['country'])));
$meta_location_state = htmlentities(addslashes(trim($leadData['meta']['location']['state'])));
$meta_location_city = htmlentities(addslashes(trim($leadData['meta']['location']['city'])));
$meta_location_lat = htmlentities(addslashes(trim($leadData['meta']['location']['latitude'])));
$meta_location_long = htmlentities(addslashes(trim($leadData['meta']['location']['longitude'])));
$resource = htmlentities(addslashes(trim($leadData['resource'])));
$action = htmlentities(addslashes(trim($leadData['action'])));
$resource_id = htmlentities(addslashes(trim($leadData['resource_id'])));
$time_stamp = htmlentities(addslashes(trim($leadData['time_stamp'])));
$resource_version = htmlentities(addslashes(trim($leadData['resource_version'])));
$last_answered_field_name = htmlentities(addslashes(trim($leadData['meta']['last_answered_field_name'])));
$chat_start_page = htmlentities(addslashes(trim($leadData['meta']['chat_start_page'])));

$fromDate = date('Y-m-d',strtotime($fromDate));
// get todate fromdate+noof Days
$toDate = date('Y-m-d', strtotime($fromDate . " + ".($NoofDays-1)." day"));
$diff = abs(strtotime($toDate) - strtotime($fromDate)); 
$diff= round($diff/(60*60*24));
$night = trim($diff);

if($errors == 0){
     
    
    $tourTSql='name="'.$PackageType.'" and deletestatus=0';
    $addnewyes = checkduplicate(_TOUR_TYPE_MASTER_,$tourTSql);
    if($addnewyes != 'yes'){
        $tourTQuery=GetPageRecord('*',_TOUR_TYPE_MASTER_,$tourTSql);
        $tourTypeData=mysqli_fetch_array($tourTQuery);
        $tourTypeId=$tourTypeData['id'];
    }else{
        $namevalue = 'name="'.$PackageType.'"';
        $tourTypeId = addlistinggetlastid(_TOUR_TYPE_MASTER_,$namevalue);   
    }
    
    
       $logsuccess = '';
    // preparing statement for insert query 
    // start insert query
    // echo ' email="'.$email.'" and FirstName="'.$FirstName.'" and NoofDays="'.$NoofDays.'"';
    $cblmQuery=' '; 
    $cblmQuery=GetPageRecord('*','chatBotLeadMaster',' email="'.$email.'" and FirstName="'.$FirstName.'" and NoofDays="'.$NoofDays.'"'); 
    $cblmData=mysqli_fetch_array($cblmQuery);  
    $chatLeadId = $cblmData['id'];
    if($chatLeadId!=''){
     
        $namevalue = 'create_date="'.$create_date.'",modify_date="'.$modify_date.'",bot_id="'.$bot_id.'",bot_version_id="'.$bot_version_id.'",account_id="'.$account_id.'",contact_id="'.$contact_id.'",status="'.$status.'",closed_status="'.$closed_status.'",version="'.$version.'",CategoryType="'.$CategoryType.'",WhatsaapNo="'.$WhatsaapNo.'",FirstName="'.$FirstName.'",NoofDays="'.$NoofDays.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",adult="'.$adult.'",PackageType="'.$PackageType.'",TypeofDham="'.$TypeofDham.'",WhichDham="'.$WhichDham.'",sharingType="'.$sharingType.'",child="'.$child.'",rooms="'.$rooms.'",StartingEndPoint="'.$StartingEndPoint.'",email="'.$email.'",phone="'.$phone.'",additionals="'.$additionals.'",meta_ip="'.$meta_ip.'",meta_location_country="'.$meta_location_country.'",meta_location_state="'.$meta_location_state.'",meta_location_city="'.$meta_location_city.'",meta_location_lat="'.$meta_location_lat.'",meta_location_long="'.$meta_location_long.'",resource="'.$resource.'",action="'.$action.'",resource_id="'.$resource_id.'",time_stamp="'.$time_stamp.'",resource_version="'.$resource_version.'",last_answered_field_name="'.$last_answered_field_name.'",chat_start_page="'.$chat_start_page.'"'; 
        $whereupdate=' id='.$chatLeadId.'';
        $update = updatelisting('chatBotLeadMaster',$namevalue,$whereupdate); 
        $logsuccess .= 'chat bot updated';
    
    }else{ 
        
        $namevalue = 'create_date="'.$create_date.'",modify_date="'.$modify_date.'",bot_id="'.$bot_id.'",bot_version_id="'.$bot_version_id.'",account_id="'.$account_id.'",contact_id="'.$contact_id.'",status="'.$status.'",closed_status="'.$closed_status.'",version="'.$version.'",CategoryType="'.$CategoryType.'",WhatsaapNo="'.$WhatsaapNo.'",FirstName="'.$FirstName.'",NoofDays="'.$NoofDays.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",adult="'.$adult.'",PackageType="'.$PackageType.'",TypeofDham="'.$TypeofDham.'",WhichDham="'.$WhichDham.'",sharingType="'.$sharingType.'",child="'.$child.'",rooms="'.$rooms.'",StartingEndPoint="'.$StartingEndPoint.'",email="'.$email.'",phone="'.$phone.'",additionals="'.$additionals.'",meta_ip="'.$meta_ip.'",meta_location_country="'.$meta_location_country.'",meta_location_state="'.$meta_location_state.'",meta_location_city="'.$meta_location_city.'",meta_location_lat="'.$meta_location_lat.'",meta_location_long="'.$meta_location_long.'",resource="'.$resource.'",action="'.$action.'",resource_id="'.$resource_id.'",time_stamp="'.$time_stamp.'",resource_version="'.$resource_version.'",last_answered_field_name="'.$last_answered_field_name.'",chat_start_page="'.$chat_start_page.'"'; 
        $chatLeadId = addlistinggetlastid('chatBotLeadMaster',$namevalue);
        $logsuccess .= 'chat bot inserted';
    } 
    // end data captured from aritbot
    
    
    // now start query creation from artibot lead ***************************************************
    $subject = 'ArtiBot-'.$FirstName.'-'.$NoofDays.' Days, '.$adult.' Adult(s) and '.$child.' Child(s)';
    $selectd = '*';
    
    // get country Id 
    $countryId = 0;
    $stateId = 0;
    $cityId = 0;
    $countrySql='name="'.$meta_location_country.'" and deletestatus=0';
    $addnewyes = checkduplicate(_COUNTRY_MASTER_,$countrySql);
    if($addnewyes == 'yes'){
        $getCountryQuery=GetPageRecord('*',_COUNTRY_MASTER_,$countrySql);
        $countryData=mysqli_fetch_array($getCountryQuery);
        $countryId=$countryData['id'];
    }
    
    // get state Id 
    $stateSql='name="'.$meta_location_state.'" and deletestatus=0';
    $addnewyes = checkduplicate(_STATE_MASTER_,$stateSql);
    if($addnewyes == 'yes'){
        $getstateQuery=GetPageRecord('*',_STATE_MASTER_,$stateSql);
        $stateData=mysqli_fetch_array($getstateQuery);
        $stateId=$stateData['id'];
    }
    
    // get city Id 
    $citySql='name="'.$meta_location_city.'" and deletestatus=0';
    $addnewyes = checkduplicate(_CITY_MASTER_,$citySql);
    if($addnewyes == 'yes'){
        $getcityQuery=GetPageRecord('*',_CITY_MASTER_,$citySql);
        $cityData=mysqli_fetch_array($getcityQuery);
        $cityId=$cityData['id'];
    }
    
    
    // create destinatino if not exists
    $nationSql='sortName="'.$meta_location_sortName.'" and deleteStatus=0';
    $addnewyes = checkduplicate('nationalityMaster',$nationSql);
    if($addnewyes == 'yes'){
        $getNationQuery=GetPageRecord('*','nationalityMaster',$nationSql);
        $nationalityData=mysqli_fetch_array($getNationQuery);
        $nationalityId=$nationalityData['id'];
    }else{
        $nationalityId = 0;   
    }
    
    // create destinatino if not exists
    $getCitySql='name="'.$StartingEndPoint.'" and deletestatus=0';
    $addnewyes = checkduplicate(_DESTINATION_MASTER_,$getCitySql);
    if($addnewyes == 'yes'){
        $getCityQuery=GetPageRecord('*',_DESTINATION_MASTER_,$getCitySql);
        $cityData=mysqli_fetch_array($getCityQuery);
        $fromdestinationId=$cityData['id'];
    }else{
        $namevalue = 'name="'.$StartingEndPoint.'"';
        $fromdestinationId = addlistinggetlastid(_DESTINATION_MASTER_,$namevalue);   
    }
    
    
    // make displayId
    $whered='deletestatus=0 and displayId!=0 order by displayId desc '; 
    $rsd=GetPageRecord('displayId',_QUERY_MASTER_,$whered); 
    $display=mysqli_fetch_array($rsd);  
    $displayId = $display['displayId']+1;
    
    
    $checkEmailExistQuery=''; 
    $checkEmailExistQuery=GetPageRecord('*',_EMAIL_MASTER_,'email="'.$email.'" and sectionType="contacts"'); 
    $checkEmailExist=mysqli_num_rows($checkEmailExistQuery);
    if($checkEmailExist>0 && $emailData['masterId']!=''){
        $emailData=mysqli_fetch_array($checkEmailExistQuery);
        $companyId=$emailData['masterId'];
      
        // create destinatino if not exists
        $cateSql='name="'.$CategoryType.'" and deletestatus=0';
        $addnewyes = checkduplicate(_HOTEL_TYPE_MASTER_,$cateSql);
        if($addnewyes == 'yes'){
            $getCatQuery=GetPageRecord('*',_HOTEL_TYPE_MASTER_,$cateSql);
            $catData=mysqli_fetch_array($getCatQuery);
            $hotelTypeId=$catData['id'];
        }else{
            $uploadKeyword = preg_replace("/[^a-zA-Z0-9\s]/", "", str_replace(' ','',$CategoryType));
            $namevalue = 'name="'.$CategoryType.'",status=1,uploadKeyword="'.$uploadKeyword.'"';
            $hotelTypeId = addlistinggetlastid(_HOTEL_TYPE_MASTER_,$namevalue);   
        } 
        
        // some imp data start
        $seasonYear = date('Y',strtotime($fromDate)); 
        $financeYear = getFinancialYear(date('Y-m-d',strtotime($fromDate)));
        
        if(strtotime($fromDate)>=strtotime($seasonYear.'-04-01') || strtotime($fromDate)<=strtotime($seasonYear.'-09-30')) {
            $seasonType=1;
        }else{
            $seasonType=2;
        }
        $dblRoom = $rooms;
        // some imp data
        $querySql='';
        $whereupd=' guest1email="'.$email.'" and subject="'.$subject.'" and fromdestinationId="'.$fromdestinationId.'"'; 
        $querySql=GetPageRecord('*',_QUERY_MASTER_,$whereupd); 
        $queryData=mysqli_fetch_array($querySql);  
        $queryId = $queryData['id'];
        if($queryId!=''){    
            $namevalue ='companyId="'.$companyId.'",leadPaxName="'.$FirstName.'",queryDate="'.$create_date.'",adult="'.$adult.'",child="'.$child.'",hotelTypeId="'.$hotelTypeId.'",description="'.$additionals.'",travelDate="'.$fromDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",night="'.$night.'",tourType="'.$tourTypeId.'",subTourType="'.addslashes($subTourType).'",nationality="'.$nationalityId.'",queryType=5,moduleType=1,travelType=2,marketType=1,paxType=2,queryStatus="10",dayWise=1,queryPriority=0,clientType=2,guest1="'.$FirstName.'",rooms="'.$rooms.'",guest1email="'.$email.'",guest1phone="'.$phone.'",fromdestinationId="'.$fromdestinationId.'",queryOrder="'.time().'",seasonType="'.$seasonType.'",seasonYear="'.$seasonYear.'",financeYear="'.$financeYear.'",additionalInfo="'.$additionals.'",dblRoom="'.$dblRoom.'"';  
            
            $logsuccess .= 'Exist user - Chat Bot Query Updated';
            $whereupdate=' id="'.$queryId.'"';
            $update = updatelisting(_QUERY_MASTER_,$namevalue,$whereupdate); 
        }else{
            $namevalue ='displayId="'.$displayId.'",companyId="'.$companyId.'",leadPaxName="'.$FirstName.'",queryDate="'.$create_date.'",adult="'.$adult.'",destinationId="'.$fromdestinationId.'",child="'.$child.'",hotelTypeId="'.$hotelTypeId.'",description="'.$additionals.'",travelDate="'.$fromDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",night="'.$night.'",tourType="'.$tourTypeId.'",subTourType="'.addslashes($subTourType).'",nationality="'.$nationalityId.'",queryType=5,moduleType=1,travelType=2,marketType=1,paxType=2,queryStatus="10",dayWise=1,queryPriority=0,clientType=2,assignTo=37,salesassignTo="Administrator CRM",subject="'.$subject.'",dateAdded="'.time().'",guest1="'.$FirstName.'",rooms="'.$rooms.'",guest1email="'.$email.'",guest1phone="'.$phone.'",fromdestinationId="'.$fromdestinationId.'",queryOrder="'.time().'",seasonType="'.$seasonType.'",seasonYear="'.$seasonYear.'",financeYear="'.$financeYear.'",additionalInfo="'.$additionals.'",dblRoom="'.$dblRoom.'"';  
            $queryId = addlistinggetlastid(_QUERY_MASTER_,$namevalue);   
            $logsuccess .= 'Exist user - Chat Bot Query Created';
            $begin = new DateTime($fromDate);
            $end   = new DateTime($toDate);
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $srdate = $i->format("Y-m-d"); 
                $namevalue1 ='srdate="'.$srdate.'",cityId="'.$fromdestinationId.'",queryId="'.$queryId.'",lastdeleted=1';
                addlisting('packageQueryDays',$namevalue1);
            }
    
    
            // $select='';
            // $select='*'; 
            // $where=' id='.$lastid.'  '; 
            // $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
            // $result=mysqli_fetch_array($rs);  
            // $queryId = $result['id'];
            // //SELECT * FROM queryMaster WHERE ABS(night-$diff) =  (SELECT MIN(ABS(night-$diff))  FROM queryMaster
            // $select="  SELECT * FROM ( ( SELECT * , $diff-night AS diff FROM queryMaster WHERE night < $diff AND totalQueryCostwithoutpercent!=0 and quotationYes=0 and destinationId=".$toDest." and destinationId!='' and destinationId!='0' ORDER BY night DESC LIMIT 1 ) UNION ALL ( SELECT *, night-$diff AS diff FROM queryMaster WHERE night >= $diff AND totalQueryCostwithoutpercent!=0 and quotationYes=0 and destinationId=".$toDest." ORDER BY night ASC LIMIT 1 )) AS tmp ORDER BY diff LIMIT 1";
            // $query=mysqli_query($select);
            // $itineraryCount=mysqli_num_rows($query);
            // $result=mysqli_fetch_array($query); 
            // if($itineraryCount>0){
            //     $queryIds=$result['id']; 
    
            //     $html='<div style="width: 600px;border: 1px solid #cccccc9e;margin: auto;padding: 0px;border-radius: 10px;font-family: arial;overflow: hidden;margin-top: 30px;margin-bottom: 30px;box-shadow: 0px 0px 10px #cccccc9c;">
            //     <div style="text-align:center; padding-top: 20px;    padding-bottom: 0px;"><img src="'.$fullurl.'images/downloadmailicon.png"  style=" height:100px;"></div>
            //     <div style="  padding: 20px;overflow: hidden;text-align: center; padding-top: 10px;"><div style="font-size:16px; margin-bottom:15px;">Download Attachement</div>
            //     <a href="'.$fullurl.'genrateDOMPdf.php?pageurl='.$fullurl.'packageQueryhtml.php?id='.encode($result['id']).'&download=1" style="padding:10px 20px;background-color:#4CAF50;color:#fff;text-decoration:none;border-radius: 29px;display: inline-block;">Download</a>
            //     </div><div style=" padding: 20px; overflow: hidden; text-align: left; background-color: #f5f5f5;font-size: 13px; line-height: 20px;"> '.$emaildescription.'<br><br>'.stripslashes($LoginUserDetails['emailsignature']).'</div><div style="padding: 20px; font-size: 11px;  color: #a9a9a9; text-align: right;">Generated by TravCRM</div></div>';
    
            //     $packHTML=url_get_contents(''.$fullurl.'packageQueryhtml.php?id='.encode($result['id']).'');
    
            // }
    
            // $fromemail='';
            // $mailto=$email;
            // $day=$diff+1;
            // $mailsubject=$diff." Nights & ".$day." Days  Tour Package";
            // //Dear Agent, <br> Greeting From Goin My Holiday Company. We provide to You  ".$diff." Nights & ".$day." Days  Tour Detailed Itinerary
            // $maildescription=" Dear ".$fname."<br><br>
            // Greetings from Debox !!!!<br><br>Lovely to hear from you and thank you so much for your query.<br><br>Thank you for giving us the opportunity to plan your dream vacation!<br><br>For your Holiday trip to ".$destname." , we have handpicked a package ".$destname." (Land only) for you, Below is attached snapshot or sample itinerary of the package:<br><br>We specialize in putting together really unique, memorable experiences and each itinerary is completely tailor-made for each of our customers to ensure that you get the very best out of a place, see what you want to see and experience the unexpected too. 
            // <br> ".$packHTML."<br>".$html;
            // $ccmail=$email;
            // $attfilename="";
            // $attfilename="";
    
            // send_template_mail_by_web($fromemail,$mailto,$mailsubject,$maildescription,$ccmail,$attfilename,$attfilename);   
        } 
    
    }else{ 
        
        $namevalue ='firstName="'.$FirstName.'",lastName="",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",modifyBy="37",assignTo="37",modifyDate="'.time().'",deletestatus="0"';  
        $companyId = addlistinggetlastid(_CONTACT_MASTER_,$namevalue);
        MISuploadlogger($FirstName);

        $allvaluephone ='phoneNo="'.$phone.'",phoneType="1",primaryvalue="1",sectionType="contacts",masterId="'.$companyId.'"'; 
        $add = addlisting(_PHONE_MASTER_,$allvaluephone);
        
        $allvalueemail ='email="'.$email.'",emailType="1",primaryvalue="1",sectionType="contacts",masterId="'.$companyId.'"'; 
        $add = addlisting(_EMAIL_MASTER_,$allvalueemail);  
         
    
        // create destinatino if not exists
        $cateSql='name="'.$CategoryType.'" and deletestatus=0';
        $addnewyes = checkduplicate(_HOTEL_TYPE_MASTER_,$cateSql);
        if($addnewyes == 'yes'){
            $getCatQuery=GetPageRecord('*',_HOTEL_TYPE_MASTER_,$cateSql);
            $catData=mysqli_fetch_array($getCatQuery);
            $hotelTypeId=$catData['id'];
        }else{
            $uploadKeyword = preg_replace("/[^a-zA-Z0-9\s]/", "", str_replace(' ','',$CategoryType));
            $namevalue = 'name="'.$CategoryType.'",status=1,uploadKeyword="'.$uploadKeyword.'"';
            $hotelTypeId = addlistinggetlastid(_HOTEL_TYPE_MASTER_,$namevalue);   
        }   
        // some imp data start
       
    
        $seasonYear = date('Y',strtotime($fromDate));
        $financeYear = getFinancialYear(date('Y-m-d',strtotime($fromDate)));


        if(strtotime($fromDate)>=strtotime($seasonYear.'-04-01') || strtotime($fromDate)<=strtotime($seasonYear.'-09-30')) {
            $seasonType=1;
        }else{
            $seasonType=2;
        }
        $dblRoom = $rooms;
        // some imp data
        $querySql='';
        $whereupd=' guest1email="'.$email.'" and subject="'.$subject.'" and fromdestinationId="'.$fromdestinationId.'"'; 
        $querySql=GetPageRecord('*',_QUERY_MASTER_,$whereupd); 
        $queryData=mysqli_fetch_array($querySql);  
        $queryId = $queryData['id'];
        if($queryId!=''){    
            $namevalue ='companyId="'.$companyId.'",leadPaxName="'.$FirstName.'",queryDate="'.$create_date.'",adult="'.$adult.'",child="'.$child.'",hotelTypeId="'.$hotelTypeId.'",description="'.$additionals.'",travelDate="'.$fromDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",night="'.$night.'",tourType="'.$tourTypeId.'",subTourType="'.addslashes($TypeofDham.'/'.$WhichDoDham).'",nationality="'.$nationalityId.'",queryType=5,moduleType=1,travelType=2,marketType=1,paxType=2,queryStatus="10",dayWise=1,queryPriority=0,clientType=2,guest1="'.$FirstName.'",rooms="'.$rooms.'",guest1email="'.$email.'",guest1phone="'.$phone.'",fromdestinationId="'.$fromdestinationId.'",queryOrder="'.time().'",seasonType="'.$seasonType.'",seasonYear="'.$seasonYear.'",financeYear="'.$financeYear.'",additionalInfo="'.$additionals.'",dblRoom="'.$dblRoom.'"';  
            $logsuccess .= 'New user - chat query updated';
            $whereupdate=' id="'.$queryId.'"';
            $update = updatelisting(_QUERY_MASTER_,$namevalue,$whereupdate); 
        }else{
            $namevalue ='displayId="'.$displayId.'",companyId="'.$companyId.'",leadPaxName="'.$FirstName.'",queryDate="'.$create_date.'",adult="'.$adult.'",destinationId="'.$fromdestinationId.'",child="'.$child.'",hotelTypeId="'.$hotelTypeId.'",description="'.$additionals.'",travelDate="'.$fromDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",night="'.$night.'",tourType="'.$tourTypeId.'",subTourType="'.addslashes($TypeofDham.'/'.$WhichDoDham).'",nationality="'.$nationalityId.'",queryType=5,moduleType=1,travelType=2,marketType=1,paxType=2,queryStatus="10",dayWise=1,queryPriority=0,clientType=2,addedBy=37,assignTo=37,salesassignTo="Administrator CRM",subject="'.$subject.'",dateAdded="'.time().'",guest1="'.$FirstName.'",rooms="'.$rooms.'",guest1email="'.$email.'",guest1phone="'.$phone.'",fromdestinationId="'.$fromdestinationId.'",queryOrder="'.time().'", seasonType="'.$seasonType.'",seasonYear="'.$seasonYear.'",financeYear="'.$financeYear.'",additionalInfo="'.$additionals.'",dblRoom="'.$dblRoom.'"';  
            $queryId = addlistinggetlastid(_QUERY_MASTER_,$namevalue);   
            $logsuccess .= 'New user - chat query created';
            $begin = new DateTime($fromDate);
            $end   = new DateTime($toDate);
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $srdate = $i->format("Y-m-d"); 
                $namevalue1 ='srdate="'.$srdate.'",cityId="'.$fromdestinationId.'",queryId="'.$queryId.'",lastdeleted=1';
                addlisting('packageQueryDays',$namevalue1);
            }
    
    
        } 
    }
    MISuploadlogger($logsuccess);
    // end query creation from artibot lead
  
}

// add query
// prefeered lang and priority option should come above ops pers
// tour type ke bad sub tour type option shud come
 
?>