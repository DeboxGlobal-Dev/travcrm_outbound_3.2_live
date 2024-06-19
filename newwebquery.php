<?php  
	ob_start();
	include "inc.php";   
	// include "config/mail.php";

		$baliId=$_REQUEST['baliId'];
		$fromDate=date('Y-m-d',strtotime($_REQUEST['fromDate']));
		$toDate=date('Y-m-d',strtotime($_REQUEST['toDate']));
		$financeYear = getFinancialYear($fromDate);

		$diff = abs(strtotime($toDate) - strtotime($fromDate)); 
		$diff= round($diff/(60*60*24));
		$adult=htmlentities(addslashes(trim($_REQUEST['adult'])));
		$child=htmlentities(addslashes(trim($_REQUEST['child'])));
		// $infant=htmlentities(addslashes(trim($_REQUEST['infant'])));
		$tourtype=htmlentities(addslashes(trim($_REQUEST['tourtype'])));
		$hotelCategory=htmlentities(addslashes(trim($_REQUEST['hotelCategory'])));
		$budget=htmlentities(addslashes(trim($_REQUEST['budget'])));
		$flight_requirement=htmlentities(addslashes(trim($_REQUEST['flight_requirement'])));
		$flight_requirement_97=htmlentities(addslashes(trim($_REQUEST['flight_requirement_97'])));
		$guest1=htmlentities(addslashes(trim($_REQUEST['guest1'])));
		$description1=htmlentities(addslashes(trim($_REQUEST['description1'])));
		$durationfilter=htmlentities(addslashes(trim($_REQUEST['durationfilter'])));
		$hotelCategory=htmlentities(addslashes(trim($_REQUEST['hotelCategory'])));
		

		$fname=htmlentities(addslashes(trim($_REQUEST['nameNN'])));
		$lname=htmlentities(addslashes(trim($_REQUEST['lnameNN'])));

		
		$clientType=htmlentities(addslashes(trim($_REQUEST['clientType'])));
		$contryCode=$_REQUEST['contryCode'];

		  // <!-- SGL,DBL,TWIN,TPL,ExtraBed,CWBed,CNBed -->

		$SGL=htmlentities(addslashes(trim($_REQUEST['SGL'])));
		$DBL=htmlentities(addslashes(trim($_REQUEST['DBL'])));
		$TWIN=htmlentities(addslashes(trim($_REQUEST['TWIN'])));
		$TPL=htmlentities(addslashes(trim($_REQUEST['TPL'])));
		$ExtraBed=htmlentities(addslashes(trim($_REQUEST['ExtraBed'])));
		$CWBed=htmlentities(addslashes(trim($_REQUEST['CWBed'])));
		$CNBed=htmlentities(addslashes(trim($_REQUEST['CNBed'])));

		$email=htmlentities(addslashes(trim($_REQUEST['email']))); 
		$phone=htmlentities(addslashes(trim($_REQUEST['phone'])));
		$city=htmlentities(addslashes(trim($_REQUEST['city'])));
		$Websitelead=htmlentities(addslashes(trim($_REQUEST['websitelead'])));
		$yourmessage=htmlentities(addslashes(trim($_REQUEST['yourmessage'])));
		// die("tttrtrtr");


		// $query_subject=htmlentities(addslashes(trim($_REQUEST['subject'])));
		$destination=stristr($query_subject, '-' ,true);
		$specific_requirements=htmlentities(addslashes(trim($_REQUEST['specific_requirements'])));
		$ip=htmlentities(addslashes(trim($_REQUEST['ip'])));
		$Website=htmlentities(addslashes(trim($_REQUEST['Website'])));
		$LeadTo=htmlentities(addslashes(trim($_REQUEST['LeadTo'])));
		$url=htmlentities(addslashes(trim($_REQUEST['url'])));
		$date_change=htmlentities(addslashes(trim($_REQUEST['date_change'])));
		$query_date=htmlentities(addslashes(trim($_REQUEST['query_date']))); 
		$exploring=htmlentities(addslashes(trim($_REQUEST['exploring']))); 
		$formDest=$_REQUEST['fromDest'];
		$fromWB=$_REQUEST['fromDest'];
		$toDest=$_REQUEST['toDest'];
		$leavingForm=$_REQUEST['leavingForm'];
	 	$destinationId = $formDest.','.$toDest.',';
		$exploringdest='';
	

		$FullName=$fname.' '.$lname;

		$namevalue1 ='contactType="2",firstName="'.$fname.'",lastName="'.$lname.'",deletestatus=0,status=1,addedBy="37",dateAdded="'.date('Y-m-d').'"';
		$lastId = addlistinggetlastid(_CONTACT_MASTER_,$namevalue1); 

		$namevalueEmail ='email="'.$email.'",emailType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastId.'",addedBy="37"';
    	
    	$EmailId = addlistinggetlastid(_EMAIL_MASTER_,$namevalueEmail);

		$valuephone ='phoneNo="'.$phone.'",countryCode="+91",phoneType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastId.'",EID="'.$EmailId.'",addedBy="37"';
    	$add = addlisting(_PHONE_MASTER_,$valuephone);

		$namevalue ='deletestatus=0,fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$FullName.'",addedBy="37",dateAdded="'.time().'",clientType="2",leadsource=8,description="'.$yourmessage.'",adult="'.$adult.'",Child="'.$child.'",categoryId="'.$hotelCategory.'",companyId="'.$lastId.'",night2="'.$diff.'"';

				
					
		$add = addlisting('leadManageMaster',$namevalue); 
		
?>	
