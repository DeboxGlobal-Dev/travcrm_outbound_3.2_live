<?php
error_reporting(E_ALL);
############################################################
require_once('phpmailer/PHPMailerAutoload.php');
$ddate = date('F d, Y');
$ttime = date('H:i:s');
$reference_url = (isset($_POST['currentPageUrl']) ? $_POST['currentPageUrl'] : $_SERVER['REQUEST_URI']);
$ip_address = $_SERVER['REMOTE_ADDR'];

// dont send from posting person's e-mail id, send from yours instead

/* if(isset($_POST['email']))
  {
  $email   =  $_POST['email'];
  }
  else
  {
  $email    =  'info@goinmyway.co.in';
  } */
$inserted_id = '';
$mail = new PHPMailer();
$mail->isHTML(true);
// only for debugging purpose
/*$mail->SMTPDebug = 4;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
$mail->IsSMTP();
$mail->SMTPAuth = true;                    // enable SMTP authentication
$mail->SMTPSecure = 'tls';                   // sets the prefix to the servier
$mail->Host = 'smtp.gmail.com';        // sets GMAIL as the SMTP server
$mail->Port = 587;                    // set the SMTP port for the GMAIL server
$mail->Username = 'info@goinmyway.co.in';   // GMAIL username
$mail->Password = 'wamika@123';  // GMAIL password*/
$mail->addAddress('info@goinmyway.co.in', 'GoinMyWayTours Mail');
// You can use CC function too to send to more recipients			
//$mail->addCC('info@goinmyway.co.in', 'GoinMyWayTours Mail');
$mail->setFrom('info@goinmyway.co.in', 'GoinMyWayTours Mail');
$mail->setFrom('it.goinmyway@gmail.com', 'GoinMyWayTours Mail');
 $mail->Subject = 'Golden Triangle Trip from ' . (isset($_POST['email']) ? $_POST['email'] : 'info@goinmyway.co.in');




if ($_POST['action'] == "first_frm") {

    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $email = (isset($_POST['email']) ? $_POST['email'] : 'info@goinmyway.co.in');
    $mobile = $_POST['mobile'];


    $message = "";
    $message .= '<TABLE align=center width="750" class=text border="0" cellpadding="2" cellspacing="0">
				<TR bgcolor ="#C7DcF0">
				<TD colspan="2"><font face=arial size=3 color=brown><center> Following message has been received from ' . $email . ' on ' . $ddate . ' at ' . $ttime . '</center></font></TD>
				</TR>
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Referer URL:</font></TD>
					<TD><font face=arial  size=2><A HREF="' . $reference_url . '">' . $reference_url . '  # ' . $ip_address . '</A></font></TD>
				</TR>
				
				
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Check in:</font></TD>
					<TD><font face=arial  size=2>' . $check_in . '</font></TD>
				</TR>
				
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Length of trip:</font></TD>
					<TD><font face=arial  size=2>' . $check_out . '</font></TD>
				</TR>
				
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Check in:</font></TD>
					<TD><font face=arial  size=2>' . $email . '</font></TD>
				</TR>
				
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Length of trip:</font></TD>
					<TD><font face=arial  size=2>' . $mobile . '</font></TD>
				</TR>
				
				<TR bgcolor ="#FFFFFF">
					<TD colspan="2"><br><font face=arial size=3 color=brown>Thanks, <br /> Webmaster</font></TD>
				</TR>
				</table>';

    $mail->msgHTML($message);
    $mail->AltBody = strip_tags($message);
    $result = $mail->send();
    if ($result !== false) {
        echo 'success^1';
        exit;
    } else {
        echo 'error';
        exit;
    }
}
if ($_POST['action'] == "second_frm") {
    $inserted_id = 1;
    $mobile = $_POST['mobile'];
    $message .= '<TABLE align=center width="750" class=text border="0" cellpadding="2" cellspacing="0">
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Email</font></TD>
					<TD><font face=arial  size=2>' . $email . '</font></TD>
				</TR>
				
				<TR bgcolor ="#FFFFFF">
					<TD><font face=arial  size=2 width="30%">Telephone:</font></TD>
					<TD><font face=arial  size=2>' . $mobile . '</font></TD>
				</TR>
				
								
				<TR bgcolor ="#FFFFFF">
					<TD colspan="2"><br><font face=arial size=3 color=brown>Thanks, <br /> Webmaster</font></TD>
				</TR>
				</table>';

    $mail->msgHTML($message);
    $mail->AltBody = strip_tags($message);
    $result = $mail->send();
    if ($result) {
        echo 'success';
        exit;
    } else {
        echo 'error';
        exit;
    }
}
?>