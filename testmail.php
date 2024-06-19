<?php  
include "inc.php";   
include('incomingMailSetting.php'); 
// exit;
// ini_set('display_errors', 1);
// error_reporting(E_ALL); 
echo $hostname.','.$username.','.$password;
// exit;
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to server: ' . imap_last_error());

$date_15_days_ago = date('d-M-Y', strtotime('-15 days')); 
$emails = imap_search($inbox, 'SINCE "' . $date_15_days_ago . '"'); 
// $emails = imap_search($inbox,'ALL');

$filtered_emails = [];
if ($emails) {
    
    // echo '<pre>';
    // print_r($emails); 
    // exit;
    echo count($emails);
    echo '<br><br>';
    foreach ($emails as $email_number) { 
        
        $overview = imap_fetch_overview($inbox,$email_number,0); 
        $subject = $overview[0]->subject;  
        $subject = strtoupper(trim($subject));
        
        // Check if subject contains "RZ" and date is within the last 6 months
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
        // $structure = imap_fetchstructure($inbox, $email_number);
        
        if (strpos($subject,$masterQueryIdSequence) == true ) {
            echo "Subject: " . trim(str_replace('RE:', '', strtoupper($subject))) . "<br>";
            echo "From: " . $email . "<br>";
            echo "To: " . $emailto . "<br>";
            echo "CC: " . $ccemail . "<br><br><br>";
        }
        
    }
} 

imap_close($inbox);
exit; 

 
 
require_once('PHPMailer/class.phpmailer.php'); 
include("PHPMailer/class.smtp.php");
 

function send_mail($fromemail, $email_to, $subject, $body, $ccmail){

	$select='*';
	$where=' 1 and isDefault=1 ';
	$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
	$result=mysqli_fetch_array($rs);
    
    $phpMailer = new PHPMailer(true);

    try {

        $phpMailer->SMTPDebug = 2;
        $phpMailer->isSMTP();
        $phpMailer->Host = $result['smtp_server'];
        $phpMailer->SMTPAuth = $result['security_type'];
        $phpMailer->Username = $result['email'];
        $phpMailer->Password = decode($result['password']);
        $phpMailer->SMTPSecure = $result['smtp_server']; 
        $phpMailer->Port = $result['port'];
        
        // $phpMailer->SMTPSecure = false;
        // $phpMailer->Port = 587;
        
        $ccmail = explode(',', $ccmail);
    	foreach ($ccmail as $ccaddress) {
    		$phpMailer->AddCC(trim($ccaddress));
    	}
    	
        $phpMailer->isHTML(true);
        $phpMailer->CharSet = "UTF-8";
        $phpMailer->setFrom($result['email'], $result['from_name']);
        $phpMailer->addAddress($email_to);
        $phpMailer->Subject = $subject;
        $phpMailer->Body = $body;
        $phpMailer->send();

    } catch (phpmailerException $e) {

        die($e->errorMessage());

    }

} 
// echo send_mail('info@deboxglobal.com','info@deboxglobal.com','Recieve email from TravCrm','Testing Email by debox team','samaydin.khan@deboxglobal.com,nitin.kumar@deboxglobal.com');



