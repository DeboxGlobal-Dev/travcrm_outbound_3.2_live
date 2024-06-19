<?php 
error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require("sendgrid-php/sendgrid-php.php");
//require_once('PHPMailer/class.phpmailer.php'); 
//include("PHPMailer/class.smtp.php");  


function send_template_mail_sendgrid($fromemail,$to,$subject,$description) 
{
//echo $fromemail.$to.$subject.$description;

$from = new SendGrid\Email("TravCRM", "info@travcrm.in");
$subject = $subject;
$to = new SendGrid\Email($to, $to);
$content = new SendGrid\Content("text/html", $description);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
	$apiKey = 'SG.K2awfTf0SlaP0vENImxxtw.Q991TPkYCkEy4_KSPRvQlkTer3yiiCcw0SMKwUxxymE';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
return $response;
//print_r($response->headers());

      /*  $mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->SMTPAuth = true;

		$mail->SMTPSecure = "tls";

		$mail->Host = 'mail.connecwrk.com';

		$mail->Port = '587';  

		$mail->Username = 'noreply@connecwrk.com';

		$mail->Password = 'admin@3214'; 

		$mail->From = 'noreply@connecwrk.com';

		$mail->FromName = 'CONNECWRK';

		$mail->Subject = $subject;

		$mail->AltBody = "";

		$mail->MsgHTML($description); 

		$mail->AddAddress($to, "");

		$mail->IsHTML(true);

		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
		);
		$mail->Send();*/
}

function send_invitation_template_mail($fromemail,$to,$subject,$description) 
{
//echo $fromemail.$to.$subject.$description;
$sendername=$fromemail;
$from = new SendGrid\Email($sendername, "noreply@connecwrk.com");
$subject = $subject;
$to = new SendGrid\Email($to, $to);
$content = new SendGrid\Content("text/html", $description);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
	$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);

}

//echo send_template_mail('test@konectt.com','mohd.m.imran@gmail.com','test','hello there');
?>