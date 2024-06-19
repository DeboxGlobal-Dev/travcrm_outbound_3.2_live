<?php  
include "inc.php";    
date_default_timezone_set('asia/kolkata'); 
set_time_limit(3000); 




 $select='*';    

$where=' deletestatus=0 and tatDate<"'.date('Y-m-d H:i:s').'" and tatDate!="0000-00-00 00:00:00" and tatNumber<4 and queryStatus<3  ';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   
while($resListing=mysql_fetch_array($rs)){  

$postsubmitfield='#'.makeQueryId($resListing['id']).' Query TAT Exceeded'; 

$namevalue ='postText="'.$postsubmitfield.'",parentId=0,addedBy=37,userId=37,dateAdded="'.time().'",queryId="'.$resListing['id'].'",queryUserId="'.$resListing['assignTo'].'",tatDate="'.date('Y-m-d H:i:s').'",timelineType=2'; 
addlisting(_TIMELINE_MASTER_,$namevalue); 



$namevalue ='tatDate="'.date('Y-m-d H:i:s', strtotime("+".$resListing['tat']." min")).'",tatNumber="'.($resListing['tatNumber']+1).'"'; 
$where='id="'.$resListing['id'].'"';   
updatelisting(_QUERY_MASTER_,$namevalue,$where); 

}



//------------------------------------Today Report Master-----------------------------------------------




if(date('H:i:s')<'20:01:00' && date('H:i:s')<'21:50:00'){

include "config/mail.php";



$fromemail='';  

$mailto='deboxglobal@gmail.com';  

$ccmail='';  

$mailsubject='Todays Query Status Report - travCRM'; 

$maildescription=url_get_contents(''.$fullurl.'report/report.php');

send_template_mail($fromemail,$mailto,$mailsubject,$maildescription,$ccmail); 



}









//------------------------------------Mail Section Master-----------------------------------------------




$select='*';  
$where='1 order by id asc';
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
while($emailsetting=mysql_fetch_array($rs)){ 


$from_name=clean($emailsetting['from_name']); 
$email=clean($emailsetting['email']); 
$password=clean($emailsetting['password']);  
$smtp_server=str_replace('.mail','',$emailsetting['smtp_server']); 
$port=clean($emailsetting['port']); 
$security_type=clean($emailsetting['security_type']);
 

 
$hostname = '{'.$smtp_server.':143/notls}'; 
$username = $email; 
$password = $password;

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to mail: ' . imap_last_error());

$emails = imap_search($inbox,'ALL'); 

 

if($emails) {

    $count = 25;

    /* put the newest emails on top */
    rsort($emails);

    /* for every email... */
    foreach($emails as $email_number) 
    {

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox,$email_number,0);

		$message='';
        $message = imap_fetchbody($inbox,$email_number,1.2);
		
		$subject = addslashes($subject=$overview[0]->subject); 
		
		$message=addslashes($message);
		
		$email=$from=$overview[0]->from;   		 
		preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails);  
		$email= str_replace('["','',json_encode($found_mails[0]));  
		$email=  str_replace('"]','',$email); 
		
		$mailUserName = addslashes(strip_tags($overview[0]->from));
		
		$timestamp = strtotime($date=$overview[0]->date); 
		date_default_timezone_set('asia/kolkata'); 
		$date = date('Y-m-d H:i:s',$timestamp);
		
		$queryId=substr($subject, 1, 7);
		$queryId=preg_replace("/[^0-9]/","",ltrim($queryId, '0')); 
		 
		
	//---------------------------Mail Section Mails-----------------------------		
			
			
			
			if($subject!='Mail delivery failed: returning message to sender'){
			
			$result =mysql_query ("select * from emailSettingmaster where  from_name='".trim($mailUserName)."'")  or die(mysql_error());  
			$number2=mysql_num_rows($result);   
			if($number2>0)  
			{ } else {
			
			
					$result =mysql_query ("select * from "._MAIL_SECTION_MASTER_." where  mailDate='".$date."'")  or die(mysql_error());  
					$number =mysql_num_rows($result);   
					if($number==0)  
					{
					
					
					
							$mailsubject=$subject;
							$sentMails=$email;
							
							$email=str_replace("'","",$email);
							$email=str_replace('"','',$email);
							
							$namevalue ='subject="'.$subject.'",mailBody="'.$message.'",mailDate="'.$date.'",mailFrom="'.$email.'",mailAttachment="'.$filenameupload.'",mailUserName="'.$mailUserName.		'",fromSection="'.$emailsetting['email'].'"';  
							$adds = addlisting(_MAIL_SECTION_MASTER_,$namevalue);  
					
					
					}
			 
			
			}
		
		}
		
		
		
		
	//---------------------------Query Mails-----------------------------			
		
		
		
		
		
		
		if (strpos($subject, '[SUP') !== true) { 
		
		
		
		$queryId=str_replace(' ','',$subject);
		$queryId=str_replace('Re:','',$queryId);
		$queryId=str_replace('re:','',$queryId);
		
		$queryId=substr($queryId, 1, 7);  
		
			$queryId=preg_replace("/[^0-9]/","",ltrim($queryId, '0')); 
			
			if($queryId!='' && strpos($subject, '[SUP') == false && strpos($subject, 'Mail delivery failed') == false){ 
			$result =mysql_query ("select * from "._QUERYMAILS_MASTER_." where queryid='".$queryId."' and adddate='".$date."'")  or die(mysql_error());   
			$number =mysql_num_rows($result);   
			if($number==0)  
					{   
					
					
					
					
					$namevalue ='subject="'.$subject.'",description="'.$message.'",adddate="'.$date.'",fromMail="'.str_replace('"','',str_replace("'","",$email)).'",queryid="'.$queryId.'",queryStatus=1,status=1';
					$adds = addlisting(_QUERYMAILS_MASTER_,$namevalue);
					
					
					$where='id='.$queryId.''; 
					$namevalue ='queryStatus=1,queryOrder='.time().'';    
					$update = updatelisting(_QUERY_MASTER_,$namevalue,$where); 
					
					
					}
		
				}
		}
		
		
		
		
		
	//---------------------------Supplier Mails-----------------------------
	
	
	
	
	
	
	
			if (strpos($subject, '[SUP') !== false) {
			
					$subject=str_replace('Re: ','',$subject);
					
					$suppid = str_replace('[SUP','',$variable = substr($subject, 0, strpos($subject, "]"))); 
					$result =mysql_query ("select * from "._SUPPLIER_COMMUNICATION_MAIL_." where dateAdded='".$date."' ")  or die(mysql_error());  
					$number =mysql_num_rows($result);   
					if($number==0)  
							{   
							
									$queryIdforsupplier=0; 
									$getonly=substr($subject, 0, 17);
									$queryIdforsupplier = rtrim(substr($getonly, strpos($getonly, "@") + 1),' '); 
									$queryIdforsupplier = preg_replace("/[^0-9]/","",ltrim($queryIdforsupplier, '0')); 
									$queryIdforsupplier = ltrim($queryIdforsupplier, '0'); 
									$namevalue ='subject="'.$subject.'",detail="'.$message.'",supplierId="'.$suppid.'",fromMail="'.str_replace('"','',str_replace("'","",$email)).'",queryId="'.$queryIdforsupplier.'",replyBy="'.$suppid.'",dateAdded="'.$date.'",replyStatus=1';    
									$adds = addlisting(_SUPPLIER_COMMUNICATION_MAIL_,$namevalue);
							
							}
					
			}
	
	
	
	
	
		
		
		
		
		

        /* get mail structure */
        $structure = imap_fetchstructure($inbox, $email_number);

        $attachments = array();

        /* if any attachments found... */
        if(isset($structure->parts) && count($structure->parts)) 
        {
            for($i = 0; $i < count($structure->parts); $i++) 
            {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );

                if($structure->parts[$i]->ifdparameters) 
                {
                    foreach($structure->parts[$i]->dparameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'filename') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if($structure->parts[$i]->ifparameters) 
                {
                    foreach($structure->parts[$i]->parameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'name') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if($attachments[$i]['is_attachment']) 
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                    /* 3 = BASE64 encoding */
                    if($structure->parts[$i]->encoding == 3) 
                    { 
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    /* 4 = QUOTED-PRINTABLE encoding */
                    elseif($structure->parts[$i]->encoding == 4) 
                    { 
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }

        /* iterate through each attachment and save it */
        foreach($attachments as $attachment)
        {
            if($attachment['is_attachment'] == 1)
            {
                $filename = $attachment['name'];
                if(empty($filename)) $filename = $attachment['filename'];

                if(empty($filename)) $filename = time() . ".dat";
                $folder = "attachment";
                if(!is_dir($folder))
                {
                     mkdir($folder);
                }
                $fp = fopen("./". $folder ."/". $email_number . "-" . $filename, "w+");
                fwrite($fp, $attachment['attachment']);
                fclose($fp);
            }
        }
    }
} 



}

?>









