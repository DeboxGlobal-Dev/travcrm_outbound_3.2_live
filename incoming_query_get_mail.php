<?php
include "inc.php"; 
include "config/logincheck.php"; 

//error_reporting(0);
ini_set("max_execution_time",360);

$select=''; 
$where=''; 
$rs='';  
$select='id'; 
$where='id="'.$_SESSION['userid'].'" and email="'.$_SESSION['username'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$LoginUserDetails=mysqli_fetch_array($rs); 

$select='*'; 
$where='userId="'.$loginusersuperParentId.'"'; 
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where); 
$emailsetting=mysqli_fetch_array($rs); 


$from_name=clean($emailsetting['from_name']);
$email=clean($emailsetting['email']);
$password=clean($emailsetting['password']); 
$smtp_server=str_replace('.mail','',$emailsetting['smtp_server']);
$port=clean($emailsetting['port']);
$security_type=clean($emailsetting['security_type']); 


/* connect to server */
$hostname = '{'.$smtp_server.':143/notls}INBOX';
$username = $email;
$password = $password;

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to domain:' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each… */
if($emails) {

$output = '';

/* put the newest emails on top */
rsort($emails);

//echo "Number of email:".imap_num_msg($inbox);

/* for every email… */



foreach($emails as $email_number) {

$subject='';
$message='';
$body='';
$email='';
$date='';

$overview = imap_fetch_overview($inbox,$email_number,0);

$subject = addslashes(str_replace('Re: ','',$subject=$overview[0]->subject));

$message = addslashes(nl2br(imap_fetchbody($inbox,$email_number,1))); 

$body=nl2br($message);

$email=$from=$overview[0]->from;  
preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails); 
$email= str_replace('["','',json_encode($found_mails[0])); 
$email=  str_replace('"]','',$email);

$timestamp = strtotime($date=$overview[0]->date);
date_default_timezone_set("Asia/Calcutta");
$date = date('Y-m-d H:i:s', $timestamp); 

$queryId=substr($subject, 1, 7);

$queryId=preg_replace("/[^0-9]/","",ltrim($queryId, '0'));

if($queryId=='' && $email!='Mailer-Daemon@bh-ht-5.webhostbox.net' && $subject!='Mail delivery failed: returning message to sender'){

$result =mysqli_query ("select * from "._INCOMING_QUERY_." where subject='".$subject."' and adddate='".$timestamp."'")  or die(mysqli_error(db())); 
$number =mysqli_num_rows($result);
if($number==0) 
{
if (strpos($subject, '#') !== false || strpos($subject, 'Booking No.') !== false || strpos($subject, 'Invoice No.') !== false) {}else{
$namevalue ='subject="'.$subject.'",description="'.$message.'",adddate="'.$timestamp.'",fromMail="'.$email.'"';  
$adds = addlisting(_INCOMING_QUERY_,$namevalue);
}
}
}



/*$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
$output.= '<span class="from">'.$overview[0]->from.'</span>';
$output.= '<span class="date">on '.$overview[0]->date.'</span>';
$output.= '</div>';

$output.= '<div class="body">'.$message.'</div>';*/
} //end of for loop
//echo $output;
} //end of if statement

/* close the connection */
imap_close($inbox);

?>
 