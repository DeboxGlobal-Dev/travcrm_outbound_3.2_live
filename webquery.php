<?php  
	ob_start();
	include "inc.php";   
	// include "config/mail.php";
	 
	//send_template_mail_by_web($fromemail,'kewalsingh.debox@gmail.com','Test mail web','hello',$ccmail,$attfilename,$attfilename);

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
		
		
		if($flight_requirement_97==98){
			$flight_requirement_97=0;
		}
		if($flight_requirement_97==97){
			$flight_requirement_97=1;
		}
		if($flight_requirement==98){
			$flight_requirement=0;
		}
		if($flight_requirement==97){
			$flight_requirement=1;
		}

		// clientType,contryCode-

		$fname=htmlentities(addslashes(trim($_REQUEST['fname'])));
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


		$query_subject=htmlentities(addslashes(trim($_REQUEST['subject'])));
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
		if($exploring!=''){
			$exploringdest='exploring destinations';
		}
		if($hotelCategory!=''){
			$hotels=1;
		}else{
			$hotels=0;
		}

		$queryPriority=htmlentities(addslashes(trim($_REQUEST['queryPriority']))); 
		// $queryPriority=$_POST['queryPriority'];
		if($queryPriority!='' && $queryPriority>0){
			if($queryPriority==1 || $queryPriority==4 || $queryPriority==5){
				$queryPriority='1';
			}

			if($queryPriority==2){
				$queryPriority='2';
			}

			if($queryPriority==3){
				$queryPriority='3';
			}
		}else{
			$queryPriority='2';
		}


		// subject change

		$WebsubDate=date('d-m-Y',strtotime($_REQUEST['fromDate']));
		// $subject=$query_subject;
		$subject='Web form '.$WebsubDate;
		if($_REQUEST['action']=='Bali'){
			//$subject=$_REQUEST['action'].'-'.$email;
		}
		// $destname = getDestination($toDest);



		// $subject='LandingPage&nbsp;-&nbsp;'.ltrim($subject,'-').'&nbsp;-&nbsp;'.$toDest;
		// $dblRoom = ($adult+$child)/2;

		$select1='*';  
		$where1='email="'.$email.'" and sectionType="contacts"'; 
		$rs1=GetPageRecord($select1,_EMAIL_MASTER_,$where1); 
		$checkEmail=mysqli_num_rows($rs1);
		
		if($checkEmail>0){
		
			$emailResult=mysqli_fetch_array($rs1);
			$companyId=$emailResult['masterId'];
			
			$selectd='displayId'; 
			$whered='subject!="" and deletestatus=0 and displayId!=0 order by displayId desc '; 
			$rsd=GetPageRecord($selectd,_QUERY_MASTER_,$whered); 
			$display=mysqli_fetch_array($rsd);  
			$displayId = $display['displayId']+1;

 			


			$phoneQuery=''; 
			$phoneQuery=GetPageRecord('*',_PHONE_MASTER_,' sectionType="contacts" and masterId="'.$companyId.'"'); 
			$phoneData=mysqli_fetch_array($phoneQuery);  
			$phone = $phoneData['phoneNo'];
			
			if($baliId!=''){
				$selectupd='';
			  	$selectupd='*'; 
				$whereupd=' baliId='.$baliId.'  '; 
				$rsupd=GetPageRecord($selectupd,_QUERY_MASTER_,$whereupd); 
				$resultup=mysqli_fetch_array($rsupd);  
				$queryIdupdate = $resultup['id'];
				if($queryIdupdate!=''){ 	
				   $namevalue ='adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",tourtype="'.$tourtype.'",hotelCategory="'.$hotelCategory.'",needFlight="'.$flight_requirement.'",cabforLocal="'.$flight_requirement_97.'",expectedSales="'.$budget.'",hotelAccommodation="'.$hotels.'",description="'.$specific_requirements.'"';
				    $whereupdate=' id="'.$queryIdupdate.'"';
				    $update = updatelisting(_QUERY_MASTER_,$namevalue,$whereupdate); 
				}else{
		$financeYear = getFinancialYear($fromDate);
		$financeYear = getFinancialYear($fromDate);
	
					$namevalue ='companyId="'.$companyId.'",deletestatus=0,night="'.$diff.'",queryDate="'.date('Y-m-d').'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$subject.'",addedBy="37",dateAdded="'.time().'",queryPriority="2",clientType="'.$clientType.'",contryCode="'.$contryCode.'",paxType="2",tat="30",quotationYes=2,moduleType=1,queryTimer="'.time().'",queryOrder="'.time().'",tatDate="'.date('Y-m-d H:i:s', strtotime("+".'30'." min")).'",tatNumber=0,queryStatus="10",displayId="'.$displayId.'",fromWebsite="1",exploring="'.$exploring.'",leadsource="'.$Websitelead.'" ,dblRoom="'.$DBL.'",baliId="'.$baliId.'",fromdestinationId="'.$formDest.'",destinationId="'.$destinationId.'",formDest="'.$formDest.'",fromWB="'.$fromWB.'",leavingFormDest="'.$leavingForm.'",guest1phone="'.$phone.'",guest1email="'.$email.'",guest1="'.$guest1.'",description="'.$description1.'",additionalInfo="'.$yourmessage.'",adult="'.$adult.'",child="'.$child.'",tourType="'.$tourtype.'",expectedSales="'.$budget.'",categoryId="'.$hotelCategory.'",sglRoom="'.$SGL.'",twinRoom="'.$TWIN.'",tplRoom="'.$TPL.'",cwbRoom="'.$CWBed.'",cnbRoom="'.$CNBed.'",financeYear="'.$financeYear.'",needFlight="'.$flight_requirement.'"';

					// sglRoom,dblRoom,twinRoom,tptRoom,cwbRoom,cnbRoom,extRoom
					// <!-- SGL,DBL,TWIN,TPL,CWBed,CNBed,ExtraBed-->
					// die("tttttttttttt"); 
					
					$lastid = addlistinggetlastid(_QUERY_MASTER_,$namevalue);   


					$begin = new DateTime($fromDate);
					$end   = new DateTime($toDate);

					for($i = $begin; $i <= $end; $i->modify('+1 day')){
					    $srdate = $i->format("Y-m-d");
						if($srdate == $begin){
					    	$cityId = $formDest;
					    }else{
					    	$cityId = $toDest;
					    }
					    $namevalue1 ='srdate="'.$srdate.'",cityId="'.$cityId.'",queryId="'.$lastid.'",lastdeleted=1';
						addlisting('packageQueryDays',$namevalue1);
					}

				}
			}else{
				    
				$namevalue ='companyId="'.$companyId.'",deletestatus=0,night="'.$diff.'",queryDate="'.date('Y-m-d').'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$subject.'",addedBy="37",dateAdded="'.time().'",queryPriority="2",clientType="2",paxType="2",tat="30",quotationYes=2,moduleType=1,queryTimer="'.time().'",queryOrder="'.time().'",tatDate="'.date('Y-m-d H:i:s', strtotime("+".'30'." min")).'",tatNumber=0,queryStatus="10",displayId="'.$displayId.'",fromWebsite="1",exploring="'.$exploring.'",leadsource="'.$Websitelead.'" ,baliId="'.$baliId.'",dblRoom="'.$DBL.'",fromdestinationId="'.$formDest.'",destinationId="'.$destinationId.'",formDest="'.$formDest.'",fromWB="'.$fromWB.'",leavingFormDest="'.$leavingForm.'",guest1phone="'.$phone.'",guest1email="'.$email.'",guest1="'.$guest1.'",description="'.$description1.'",additionalInfo="'.$yourmessage.'",adult="'.$adult.'",child="'.$child.'",tourType="'.$tourtype.'",expectedSales="'.$budget.'",categoryId="'.$hotelCategory.'",needFlight="'.$flight_requirement.'"'; 
				$lastid = addlistinggetlastid(_QUERY_MASTER_,$namevalue);  

				echo $begin = new DateTime($fromDate);
				echo $end   = new DateTime($toDate);

				for($i = $begin; $i <= $end; $i->modify('+1 day')){
				    $srdate = $i->format("Y-m-d");
					if($srdate == $begin){
				    	$cityId = $formDest;
				    }else{
				    	$cityId = $toDest;
				    }
				    $namevalue2 ='srdate="'.$srdate.'",cityId="'.$cityId.'",queryId="'.$lastid.'",lastdeleted=1';
					addlisting('packageQueryDays',$namevalue2);
				}

 

				// 		  	$select='';
				// 		  	$select='*'; 
				// 			$where=' id='.$lastid.'  '; 
				// 			$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
				// 			$result=mysqli_fetch_array($rs);  
				// 			$queryId = $result['id'];
				// 			//SELECT * FROM queryMaster WHERE ABS(night-$diff) =  (SELECT MIN(ABS(night-$diff))  FROM queryMaster
				// 			 $select="  SELECT * FROM ( ( SELECT * , $diff-night AS diff FROM queryMaster WHERE night < $diff AND totalQueryCostwithoutpercent!=0 and quotationYes=0 and destinationId=".$toDest." and destinationId!='' and destinationId!='0' ORDER BY night DESC LIMIT 1 ) UNION ALL ( SELECT *, night-$diff AS diff FROM queryMaster WHERE night >= $diff AND totalQueryCostwithoutpercent!=0 and quotationYes=0 and destinationId=".$toDest." ORDER BY night ASC LIMIT 1 )) AS tmp ORDER BY diff LIMIT 1";
				// 			$query=mysqli_query($select);
				// 			$itineraryCount=mysqli_num_rows($query);
				// 			$result=mysqli_fetch_array($query); 
				// 		    if($itineraryCount>0){
				// 				$queryIds=$result['id']; 
							    
				// 				$html='<div style="width: 600px;border: 1px solid #cccccc9e;margin: auto;padding: 0px;border-radius: 10px;font-family: arial;overflow: hidden;margin-top: 30px;margin-bottom: 30px;box-shadow: 0px 0px 10px #cccccc9c;">
				// 	<div style="text-align:center; padding-top: 20px;    padding-bottom: 0px;"><img src="'.$fullurl.'images/downloadmailicon.png"  style=" height:100px;"></div>
				// 	    <div style="  padding: 20px;overflow: hidden;text-align: center; padding-top: 10px;"><div style="font-size:16px; margin-bottom:15px;">Download Attachement</div>
				// 	<a href="'.$fullurl.'tcpdf/examples/getpdf.php?pageurl='.$fullurl.'packageQueryhtml.php?id='.encode($result['id']).'&download=1" style="padding:10px 20px;background-color:#4CAF50;color:#fff;text-decoration:none;border-radius: 29px;display: inline-block;">Download</a>
				// 	</div><div style=" padding: 20px; overflow: hidden; text-align: left; background-color: #f5f5f5;font-size: 13px; line-height: 20px;"> '.$emaildescription.'<br><br>'.stripslashes($LoginUserDetails['emailsignature']).'</div><div style="padding: 20px; font-size: 11px;  color: #a9a9a9; text-align: right;">Generated by TravCRM</div></div>';

				// 				$packHTML=url_get_contents(''.$fullurl.'packageQueryhtml.php?id='.encode($result['id']).'');
								
				// 			}

				//             $fromemail='';
				//             $mailto=$email;
				// 			$day=$diff+1;
				//             $mailsubject=$diff." Nights & ".$day." Days  Tour Package";
				// 			//Dear Agent, <br> Greeting From Goin My Holiday Company. We provide to You  ".$diff." Nights & ".$day." Days  Tour Detailed Itinerary
				//             $maildescription=" Dear ".$fname."<br><br>
				// Greetings from Debox !!!!<br><br>Lovely to hear from you and thank you so much for your query.<br><br>Thank you for giving us the opportunity to plan your dream vacation!<br><br>For your Holiday trip to ".$destname." , we have handpicked a package ".$destname." (Land only) for you, Below is attached snapshot or sample itinerary of the package:<br><br>We specialize in putting together really unique, memorable experiences and each itinerary is completely tailor-made for each of our customers to ensure that you get the very best out of a place, see what you want to see and experience the unexpected too. 
				// <br> ".$packHTML."<br>".$html;
				//             $ccmail=$email;
				//             $attfilename="";
				//             $attfilename="";
				//             send_template_mail_by_web($fromemail,$mailto,$mailsubject,$maildescription,$ccmail,$attfilename,$attfilename);   
			}
		}else{ 
		
			$namevalue ='firstName="'.$fname.'",modifyBy="37",modifyDate="'.time().'",deletestatus="0"';  
			$lastid = addlistinggetlastid(_CONTACT_MASTER_,$namevalue);
			
			$allvaluephone ='phoneNo="'.$phone.'",phoneType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastid.'"'; 
			$add = addlisting(_PHONE_MASTER_,$allvaluephone);
			
			$allvalueemail ='email="'.$email.'",emailType="1",primaryvalue="1",sectionType="contacts",masterId="'.$lastid.'"'; 
			$add = addlisting(_EMAIL_MASTER_,$allvalueemail);  
			
			$selectd='displayId'; 
			$whered='subject!="" and deletestatus=0 order by displayId desc '; 
			$rsd=GetPageRecord($selectd,_QUERY_MASTER_,$whered); 
			$display=mysqli_fetch_array($rsd);  
			$displayId = $display['displayId']+1;
			
			if($baliId!=''){
			
				$selectupd='';
			  	$selectupd='*'; 
				$whereupd=' baliId='.$baliId.'  '; 
				$rsupd=GetPageRecord($selectupd,_QUERY_MASTER_,$whereupd); 
				$resultup=mysqli_fetch_array($rsupd);  
				$queryIdupdate = $resultup['id'];
				if ($queryIdupdate!='') {
					 $namevalue ='adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",tourType="'.$tourtype.'",hotelCategory="'.$hotelCategory.'",needFlight="'.$flight_requirement.'",cabforLocal="'.$flight_requirement_97.'",expectedSales="'.$budget.'",hotelAccommodation="'.$hotels.'",description="'.$specific_requirements.'"';
				    $whereupdate=' id='.$queryIdupdate.'';
				    $update = updatelisting(_QUERY_MASTER_,$namevalue,$whereupdate);
				}else{
					$namevalue ='companyId="'.$lastid.'",deletestatus=0,night="'.$diff.'",queryDate="'.date('Y-m-d').'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$subject.'",addedBy="37",dateAdded="'.time().'",queryPriority="2",clientType="'.$clientType.'",contryCode="'.$contryCode.'",paxType="2",tat="30",quotationYes=2,moduleType=1,queryTimer="'.time().'",queryOrder="'.time().'",tatDate="'.date('Y-m-d H:i:s', strtotime("+".'30'." min")).'",tatNumber=0,queryStatus="10",displayId="'.$displayId.'",fromWebsite="1",exploring="'.$exploring.'",leadsource="'.$Websitelead.'" ,baliId="'.$baliId.'",dblRoom="'.$DBL.'",fromdestinationId="'.$formDest.'",destinationId="'.$destinationId.'",formDest="'.$formDest.'",fromWB="'.$fromWB.'",leavingFormDest="'.$leavingForm.'",guest1phone="'.$phone.'",guest1email="'.$email.'",guest1="'.$guest1.'",description="'.$description1.'",additionalInfo="'.$yourmessage.'",adult="'.$adult.'",child="'.$child.'",tourType="'.$tourtype.'",expectedSales="'.$budget.'",categoryId="'.$hotelCategory.'",sglRoom="'.$SGL.'",twinRoom="'.$TWIN.'",tplRoom="'.$TPL.'",cwbRoom="'.$CWBed.'",cnbRoom="'.$CNBed.'",financeYear="'.$financeYear.'",needFlight="'.$flight_requirement.'"'; 
					$lastid = addlistinggetlastid(_QUERY_MASTER_,$namevalue); 

					$begin = new DateTime($fromDate);
					$end   = new DateTime($toDate);

				for($i = $begin; $i <= $end; $i->modify('+1 day')){
				    $srdate = $i->format("Y-m-d");

					if($srdate == $begin){
				    	$cityId = $formDest;
				    }else{
				    	$cityId = $toDest;
				    }
				     $namevalue11 ='srdate="'.$srdate.'",cityId="'.$cityId.'",queryId="'.$lastid.'",lastdeleted=1';
					addlisting('packageQueryDays',$namevalue11);
				}
				}
			   
			    
			   
			}else{
			    
			  	$namevalue ='companyId="'.$lastid.'",deletestatus=0,night="'.$diff.'",queryDate="'.date('Y-m-d').'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",subject="'.$subject.'",addedBy="37",dateAdded="'.time().'",queryPriority="2",clientType="'.$clientType.'",contryCode="'.$contryCode.'",paxType="2",tat="30",quotationYes=2,moduleType=1,queryTimer="'.time().'",queryOrder="'.time().'",tatDate="'.date('Y-m-d H:i:s', strtotime("+".'30'." min")).'",tatNumber=0,queryStatus="10",displayId="'.$displayId.'",fromWebsite="1",exploring="'.$exploring.'",leadsource="'.$Websitelead.'" ,baliId="'.$baliId.'",dblRoom="'.$DBL.'",fromdestinationId="'.$formDest.'",destinationId="'.$destinationId.'",formDest="'.$formDest.'",fromWB="'.$fromWB.'",leavingFormDest="'.$leavingForm.'",guest1phone="'.$phone.'",guest1email="'.$email.'",guest1="'.$guest1.'",description="'.$description1.'",additionalInfo="'.$yourmessage.'",adult="'.$adult.'",child="'.$child.'",tourType="'.$tourtype.'",expectedSales="'.$budget.'",categoryId="'.$hotelCategory.'",sglRoom="'.$SGL.'",twinRoom="'.$TWIN.'",tplRoom="'.$TPL.'",cwbRoom="'.$CWBed.'",cnbRoom="'.$CNBed.'",financeYear="'.$financeYear.'",needFlight="'.$flight_requirement.'"';
				$lastid = addlistinggetlastid(_QUERY_MASTER_,$namevalue); 
				
		 
				$begin = new DateTime($fromDate);
				$end   = new DateTime($toDate);

				for($i = $begin; $i <= $end; $i->modify('+1 day')){
				    $srdate = $i->format("Y-m-d");

					if($srdate == $begin){
				    	$cityId = $formDest;
				    }else{
				    	$cityId = $toDest;
				    }
				     $namevalue3 ='srdate="'.$srdate.'",cityId="'.$cityId.'",queryId="'.$lastid.'",lastdeleted=1';
					addlisting('packageQueryDays',$namevalue3);
				}
				
			
				// 			$select='';
				// 		  	$select='*'; 
				// 			$where=' id='.$lastid.'  '; 
				// 			$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
				// 			$result=mysqli_fetch_array($rs);  
				// 			$queryId = $result['id'];  
				// 			//SELECT * FROM queryMaster WHERE ABS(night-$diff) =  (SELECT MIN(ABS(night-$diff))  FROM queryMaster
				// 		    $select="  SELECT * FROM ( ( SELECT * , $diff-night AS diff FROM queryMaster WHERE night < $diff AND totalQueryCostwithoutpercent!=0 and quotationYes=0 ORDER BY night DESC LIMIT 1 ) UNION ALL ( SELECT *, night-$diff AS diff FROM queryMaster WHERE night >= $diff AND totalQueryCostwithoutpercent!=0 and quotationYes=0 ORDER BY night ASC LIMIT 1 )) AS tmp ORDER BY diff LIMIT 1";
				// 			$query=mysqli_query($select);
				// 			$itineraryCount=mysqli_num_rows($query);	    
				// 			if($itineraryCount>0){
				// 			    $result=mysqli_fetch_array($query);
				// 				$queryIds=$result['id'];
								 
				// 				$html='<div style="width: 600px;border: 1px solid #cccccc9e;margin: auto;padding: 0px;border-radius: 10px;font-family: arial;overflow: hidden;margin-top: 30px;margin-bottom: 30px;box-shadow: 0px 0px 10px #cccccc9c;">
				// 				<div style="text-align:center; padding-top: 20px;    padding-bottom: 0px;"><img src="'.$fullurl.'images/downloadmailicon.png"  style=" height:100px;"></div>
				// 				    <div style="  padding: 20px;overflow: hidden;text-align: center; padding-top: 10px;"><div style="font-size:16px; margin-bottom:15px;">Download Attachement</div>
				// 				<a href="'.$fullurl.'tcpdf/examples/getpdf.php?pageurl='.$fullurl.'packageQueryhtml.php?id='.encode($result['id']).'&download=1" style="padding:10px 20px;background-color:#4CAF50;color:#fff;text-decoration:none;border-radius: 29px;display: inline-block;">Download</a>
				// 				</div><div style=" padding: 20px; overflow: hidden; text-align: left; background-color: #f5f5f5;font-size: 13px; line-height: 20px;"> '.$emaildescription.'<br><br>'.stripslashes($LoginUserDetails['emailsignature']).'</div><div style="padding: 20px; font-size: 11px;  color: #a9a9a9; text-align: right;">Generated by TravCRM</div></div>';
								
				// 					$packHTML=url_get_contents(''.$fullurl.'packageQueryhtml.php?id='.encode($result['id']).'');
				// 			}
				           

				//             $fromemail='';
				//             $mailto=$email;
				// 			$day=$diff+1;
				//             $mailsubject=$diff." Nights & ".$day." Days  Tour Package";
				// 			//$diff." Nights & ".$day." Days  Tour Detailed Itinerary  
				//             $maildescription="Dear ".$fname."<br><br>
				// Greetings from Debox !!!!<br><br>Lovely to hear from you and thank you so much for your query.<br><br>Thank you for giving us the opportunity to plan your dream vacation!<br><br>For your Holiday trip to ".$destname." , we have handpicked a package ".$destname." (Land only) for you, Below is attached snapshot or sample itinerary of the package:<br><br>We specialize in putting together really unique, memorable experiences and each itinerary is completely tailor-made for each of our customers to ensure that you get the very best out of a place, see what you want to see and experience the unexpected too".$packHTML."<br>".$html;
				//             $ccmail=$email;
				//             $attfilename="";
				//             $attfilename="";
				//             send_template_mail_by_web($fromemail,$mailto,$mailsubject,$maildescription,$ccmail,$attfilename,$attfilename);
			}
		}
	?>	
