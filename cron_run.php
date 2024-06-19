<?php
include "inc.php";   
ini_set("max_execution_time",360);  
include "config/mail.php"; 
// $select=''; 
// $where='';
// $rs='';  
// $select='*';    
// $where=' deletestatus=0 and queryStatus=3 and feedBackForm=0 and toDate < "'.date('Y-m-d').'" order by id desc';  
// $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
// while($resListing=mysqli_fetch_array($rs)){  
//     $content =  url_get_contents("".$fullurl."feedbackmail.php?queryid=".$resListing['id']."");
//     if($resListing['clientType']==2){ 
//         $mailto=getPrimaryEmail($resListing['companyId'],'contacts'); 
//     }
//     if($resListing['clientType']==1){ 
//         $mailto=getPrimaryEmail($resListing['companyId'],'contacts');
//         $mailto=getMultiPrimaryEmail($resListing['companyId'],'corporate'); 
//     }
//     rtrim($mailto,',');
//     send_template_mail('',rtrim($mailto,','),'Feedback - '.$resListing['subject'].'',$content,'');
//     $namevalue ='feedBackForm=1';   
//     $where='id="'.$resListing['id'].'"';   
//     $update = updatelisting(_QUERY_MASTER_,$namevalue,$where); 
// }


// Not in use from 20 sep 22
// $no=0;
// $select='*';    
// $where='queryid in (select displayId from '._QUERY_MASTER_.' where toDate<"'.date('Y-m-d H:i:s',strtotime('-1 month')).'") order by id asc';    
// $rs=GetPageRecord($select,'querymails',$where);    
// while($resListing=mysqli_fetch_array($rs)){   
// $selectbackup='';
// $wherebackup='';
// $rsbackup='';  
// $selectbackup='id';
// $wherebackup=' subject="'.$resListing['subject'].'" and adddate="'.$resListing['adddate'].'" ';    
// $rsbackup=GetPageRecord($selectbackup,'queryAllmailsBackup',$wherebackup);   
//     if(mysqli_num_rows($rsbackup)<1){ $no++;
//         $namevalue ='subject="'.$resListing['subject'].'",description="'.addslashes($resListing['description']).'",attachmentFile="'.$resListing['attachmentFile'].'",adddate="'.$resListing['adddate'].'",multiemails="'.$resListing['multiemails'].'",queryid="'.$resListing['queryid'].'",queryStatus="'.$resListing['queryStatus'].'",fromMail="'.$resListing['fromMail'].'",status="'.$resListing['status'].'",clientReadmail="'.$resListing['clientReadmail'].'",qmailId="'.$resListing['qmailId'].'"'; 

//         $add = addlistinggetlastid('queryAllmailsBackup',$namevalue);  
//         $delwhere='id="'.$resListing['id'].'"'; 
//         deleteRecord('querymails',$delwhere);
//      }
// } 



$filenameupload=''; 
$select='*';   
$where=' deletestatus=0 and tatDate<"'.date('Y-m-d H:i:s').'" and tatDate!="0000-00-00 00:00:00" and tatNumber<4 and queryStatus<3  ';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   
while($resListing=mysqli_fetch_array($rs)){  
    $postsubmitfield='#'.makeQueryId($resListing['id']).' Query TAT Exceeded'; 
    $namevalue ='postText="'.$postsubmitfield.'",parentId=0,addedBy=37,userId=37,dateAdded="'.time().'",queryId="'.$resListing['id'].'",queryUserId="'.$resListing['assignTo'].'",tatDate="'.date('Y-m-d H:i:s').'",timelineType=2'; 
    addlisting(_TIMELINE_MASTER_,$namevalue); 
    $namevalue ='tatDate="'.date('Y-m-d H:i:s', strtotime("+".$resListing['tat']." min")).'",tatNumber="'.($resListing['tatNumber']+1).'"'; 
    $where='id="'.$resListing['id'].'"';   
    updatelisting(_QUERY_MASTER_,$namevalue,$where); 
} 



//------------------------------------Today Report Master-----------------------------------------------
 
//if(date('H:i:s')>'08:01:00' && date('H:i:s')<'09:50:00'){
//  $select1='email';    
//  $where1=' status = 1 and userId = 37';  
//  $emailSetQuery=GetPageRecord($select1,'emailSettingmaster',$where1);
//  $emailSetQueryData=mysqli_fetch_array($emailSetQuery);
//  $fromemail='';  
//  $mailto=$emailSetQueryData['email'];
//  $ccmail='';
//  $mailsubject='Todays Query Status Report - travCRM';
//  $maildescription=url_get_contents(''.$fullurl.'report/report.php'); 
//  send_template_mail($fromemail,$mailto,$mailsubject,$maildescription,$ccmail); 
// }   
//------------------------------------Mail Section Master-----------------------------------------------

//----------IMAP Mail Section Master-------------
include('incomingMailSetting.php'); 

$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to server: ' . imap_last_error());

$date_15_days_ago = date('d-M-Y', strtotime('-15 days')); 
$emails = imap_search($inbox, 'SINCE "' . $date_15_days_ago . '"'); 
// $emails = imap_search($inbox,'ALL');

$filtered_emails = [];
if ($emails) {
    echo count($emails);
    echo '<br><br>';
    foreach ($emails as $email_number) { 
        
        $overview = imap_fetch_overview($inbox,$email_number,0); 
        $subject = $overview[0]->subject;  
        $subject = strtoupper(trim($subject));
        
        // Check if subject contains "JE" and date is within the last 6 months
        if (strpos($subject, $masterQueryIdSequence) !== false ) { //&& $maildate >= $six_months_ago
            $filtered_emails[] = $email_number;
        }
    }
}

// echo '<pre>';
// print_r($filtered_emails); 
// exit;

if ($filtered_emails) {
    rsort($filtered_emails);  
    
    $totalmail=0; 
    $rowno = 1;
    
    foreach ($filtered_emails as $email_number) {
        // $header = $filtered_email['headers'];  
        $header = imap_headerinfo($inbox, $email_number);
        
        // Extract sender, receiver, and cc emails
        $email = isset($header->from[0]->mailbox) && isset($header->from[0]->host) ? $header->from[0]->mailbox . "@" . $header->from[0]->host : 'Unknown';
        $emailto = isset($header->to[0]->mailbox) && isset($header->to[0]->host) ? $header->to[0]->mailbox . "@" . $header->to[0]->host : 'Unknown';
        $ccemail = isset($header->cc[0]->mailbox) && isset($header->cc[0]->host) ? $header->cc[0]->mailbox . "@" . $header->cc[0]->host : 'Unknown';
        $subject = isset($header->subject) ? $header->subject : 'No Subject';
        $date = isset($header->date) ? $header->date : '';
        
        $timestamp = strtotime($date);
        date_default_timezone_set('asia/kolkata');
        $date = date('Y-m-d H:i:s',$timestamp); 

        // echo '<pre>';
        // print_r($overview); 
        // exit; 
        $structure = imap_fetchstructure($inbox, $email_number);
        
        if (strpos($subject,$masterQueryIdSequence) == true ) {
            
            if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])){
                $part = $structure->parts[1];
              
                if($part->encoding == 3) {
                    $message = (imap_fetchbody($inbox,$email_number,1.2));
                    $message = (quoted_printable_decode($message));
                } else if($part->encoding == 1) {
                    $message = (imap_fetchbody($inbox,$email_number,1));
                    $message = imap_8bit($message);
                }else if($part->encoding == 0) {
                    $message = (imap_fetchbody($inbox,$email_number,2));
                    $message = imap_qprint($message);
                } else {
                    $message = (imap_fetchbody($inbox,$email_number,2));
                    $message = imap_qprint($message);
                }
            }
            $message = getmailclearcontent($message);  
            
            //  $data ="INSERT INTO 'Activity_log' set Activity='begining....',message='".addslashes($message)."'";
            //  $sql =mysqli_query(db(),$data);
            
            $attachments = array();
            if(isset($structure->parts) && count($structure->parts)) {
                for($i = 0; $i < count($structure->parts); $i++){
                    $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                    );
                    if($structure->parts[$i]->ifdparameters){
                        foreach($structure->parts[$i]->dparameters as $object){
                            if(strtolower($object->attribute) == 'filename'){
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['filename'] = $object->value;
                            }
                        }
                    }
                    if($structure->parts[$i]->ifparameters){
                        foreach($structure->parts[$i]->parameters as $object){
                            if(strtolower($object->attribute) == 'name'){
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['name'] = $object->value;
                            }
                        }
                    }
                    if($attachments[$i]['is_attachment']){
                        $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                        if($structure->parts[$i]->encoding == 3){
                            $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                        }elseif($structure->parts[$i]->encoding == 4){
                            $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                        }
                    }
                }
            }
            $filenameupload='';
            foreach($attachments as $attachment){
                if($attachment['is_attachment'] == 1){
                    $filename = $attachment['name'];
                    if(empty($filename)) $filename = $attachment['filename'];
                    if(empty($filename)) $filename = time() . ".dat";
                    $folder = "attachment";
                    if(!is_dir($folder)){
                        mkdir($folder);
                    }
                    $filenameupload.=time().$email_number.'-'.$filename.',';
                    $fp = fopen("dirfiles/".time().$email_number . "-" . $filename, "w+");
                    $filenameupload.=time().$email_number."-".$filename.',';
                    fwrite($fp, $attachment['attachment']);
                    fclose($fp);
                }
            }
            $filenameupload=$filenameupload;
             
            
            $logTime = date('H_i');
            
            if($date!=''){
                //---------------------------Query Mails-----------------------------
                if (strpos($subject, '[SUP') == false) {
                    // #CT23-24/000532 12-07-2023 POOJA CREATIVE MAIL TEST 
                    $subject= trim(str_replace('RE:','',strtoupper($subject))); 
                    $subject= trim(str_replace('FW:','',strtoupper($subject))); 
                    
                    // new code  
                    $subjectStr = explode('/0', $subject);
                    $fyearStr = $subjectStr[0];
                    $fyear=str_replace('#'.$masterQueryIdSequence,'',$fyearStr); // value 1 
                    $displayId = substr($subjectStr[1], 0, 6); // value 2 
                    $displayId = ltrim($displayId, "0"); // Remove leading zeros 
                    
                    $queryQuery = mysqli_query(db(),"select * from "._QUERY_MASTER_." where displayId='".$displayId."' and financeYear='".$fyear."'");
                    $queryData=mysqli_fetch_array($queryQuery);
                    $queryId=$queryData['id'];
                    if($queryId!='' && strpos($subject, 'Mail delivery failed') == false){
                        $result =mysqli_query(db(),"select * from "._QUERYMAILS_MASTER_." where queryid='".$queryId."' and adddate='".$date."'")  or die(mysqli_error(db()));
                        $number =mysqli_num_rows($result);
                        if($number==0){
                            if(trim($message)!=''){ 
                                
                                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                                $multiemails = $ccemail;
                                $namevalue ='subject="'.$subject.'",description="'.addslashes($message).'",adddate="'.$date.'",fromMail="'.$email.'",multiemails="'.$multiemails.'",queryid="'.$queryId.'",queryStatus=1,status=1';
                                $adds = addlisting(_QUERYMAILS_MASTER_,$namevalue); 
                                 
                                $msg=''; 
        						$msg=' Row No-'.$rowno.' Client Email : Recieved, QueryId - '.$queryId.' - '.date('d-m-Y h:ia'); 
        						importErrorlog($msg,$logTime,'log_incmails'); 
        						 
                            }else{
                                $msg=''; 
        						$msg=' Row No-'.$rowno.' Client Email : Mail Body is blank or Invalid QueryId - '.$queryId.' - '.date('d-m-Y h:ia'); 
        						importErrorlog($msg,$logTime,'log_incmails');
                            }
                            
                            $where='id='.$queryId.''; 
                            $namevalue ='queryOrder='.time().'';
                            $update = updatelisting(_QUERY_MASTER_,$namevalue,$where);
                        }else{ 
                            $msg=''; 
        					$msg=' Row No-'.$rowno.' Client Email : Already Received, dateAdded - '.$date.' , QueryId - '.$queryId.' - '.date('d-m-Y h:ia'); 
        					importErrorlog($msg,$logTime,'log_incmails'); 
                        }
                    }else{
                        $msg=''; 
    					$msg=' Row No-'.$rowno.' Client Email : DisplayId is Not correct or Mail delivery failed, DisplayId - '.$displayId.' - '.date('d-m-Y h:ia'); 
    					importErrorlog($msg,$logTime,'log_incmails'); 
                    }
                    
                    $rowno++;
                    
                }elseif (strpos($subject, '[SUP') == true) { 
                    // [SUP4552] @DB22-23/000532 RESERVATION REQUEST 23-03-2023 14:16
                    // [SUP82] @CT23-24/000532 Pooja C
                    $subject= trim(str_replace('RE:','',strtoupper($subject)));
                    $subject= trim(str_replace('FW:','',strtoupper($subject))); 
                    $result =mysqli_query(db(),"select * from "._SUPPLIER_COMMUNICATION_MAIL_." where dateAdded='".$date."' ")  or die(mysqli_error(db()));
                    $number =mysqli_num_rows($result);
                    if($number==0){ 
                        
                        $displayId=0; 
                        $suppId_displayId_str=substr($subject, 0, 25); 
                        $suppId_displayIdArr = explode(' ', $suppId_displayId_str);
                        
                        $suppIdStr = $suppId_displayIdArr[0]; //[SUP4552]
                        
                        $displayIdStr = $suppId_displayIdArr[1];
                        
                        
                        // @DB22-23/000532
                        // @DB22-23/000532 Po
                        $displayIdStr=str_replace('@'.$masterQueryIdSequence.'','',$displayIdStr);
                        
                        $displayIdStrArr = explode('/', $displayIdStr);
                        $fyear = $displayIdStrArr[0];
                        $displayIdArr = $displayIdStrArr[1];
                        $displayIdStrArr2 = explode(' ', $displayIdArr);
                        $displayId = $displayIdStrArr2[0];
                        $displayId = ltrim($displayId, "0"); // Remove leading zeros

                        $suppId = str_replace('[SUP','',$variable = substr($suppIdStr, 0, strpos($suppIdStr, "]")));
                    
                        $result =mysqli_query(db(),"select * from "._QUERY_MASTER_." where displayId='".$displayId."' and financeYear='".$fyear."'");
                        $query=mysqli_fetch_array($result);
                        $queryId=$query['id'];
                        
                        if(trim($message)!='' && $queryId>0){
                            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                                
                            $namevalue ='subject="'.$subject.'",detail="'.addslashes($message).'",supplierId="'.$suppId.'",fromMail="'.$email.'",ccmail="'.$ccemail.'",queryId="'.$queryId.'",replyBy="'.$suppId.'",dateAdded="'.$date.'",replyStatus=1';
                            $adds = addlisting(_SUPPLIER_COMMUNICATION_MAIL_,$namevalue);
                            // echo "supp <br>"; 
                            $msg=''; 
    						$msg=' Row No-'.$rowno.' Supplier Email : Recieved, DisplayId - '.$displayId.' - '.date('d-m-Y h:ia'); 
    						importErrorlog($msg,$logTime,'log_incmails'); 
                        }else{
                            $msg=''; 
    						$msg=' Row No-'.$rowno.' Supplier Email : Mail Body is blank or Invalid DisplayId - '.$displayId.' - '.date('d-m-Y h:ia'); 
    						importErrorlog($msg,$logTime,'log_incmails');
                        } 
                        $where='id='.$queryId.'';
                        // queryStatus=1,
                        $namevalue ='queryOrder='.time().'';
                        $update = updatelisting(_QUERY_MASTER_,$namevalue,$where);
                        
                        $rowno++;
                        
                    }
                    else{
                        $msg=''; 
    					$msg=' Row No-'.$rowno.' Supplier Email : Aready Received, dateAdded - '.$date.' - '.date('d-m-Y h:ia'); 
    					importErrorlog($msg,$logTime,'log_incmails');
                    }
                }else{
                    $msg=''; 
					$msg=' Row No-'.$rowno.' Non Crm Email - '.date('d-m-Y h:ia'); 
					importErrorlog($msg,$logTime,'log_incmails');
                }
                 
            }else{
                $msg=''; 
				$msg=' Row No-'.$rowno.' Email Date is Blank and subject is '.strtoupper($subject).' - '.date('d-m-Y h:ia'); 
				importErrorlog($msg,$logTime,'log_incmails');
            }
        }
        
    }
} 

imap_close($inbox);
 
?>
<script> 
window.history.go(-1); // Go back same page where user working..
</script>
<?php   
exit; 
?>
