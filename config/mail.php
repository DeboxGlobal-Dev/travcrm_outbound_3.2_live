<?php 
require_once('PHPMailer/class.phpmailer.php'); 
include("PHPMailer/class.smtp.php");
 
function send_template_mail($fromemail, $email_to, $subject, $body, $ccmail='', $attfilename=''){
    
    $select='*';
    $where=' 1 and isDefault=1 ';
    $rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
    $result=mysqli_fetch_array($rs);
    
    
    // echo $ccmail;
    // echo decode($result['password']);
    // print_r($result);
    // exit;

    // $phpMailer = new PHPMailer(true); // make true to show error in action
    $phpMailer = new PHPMailer();
    
    try {

        // $phpMailer->SMTPDebug = 2;
        $phpMailer->SMTPDebug = false;
        $phpMailer->isSMTP();
        $phpMailer->Host = $result['smtp_server'];
        $phpMailer->SMTPAuth = $result['security_type'];
        $phpMailer->Username = $result['email'];
        $phpMailer->Password = decode($result['password']);
        $phpMailer->SMTPSecure = $result['smtp_server']; 
        $phpMailer->Port = $result['port'];
        
        // $phpMailer->SMTPSecure = false;
        // $phpMailer->Port = 587;
          

        $phpMailer->isHTML(true);
        $phpMailer->CharSet = "UTF-8"; 
        $phpMailer->setFrom($result['email'], $result['from_name']);
        $phpMailer->addAddress($email_to);
        $phpMailer->addReplyTo($result['email'], $result['from_name']);
        
        if(!empty($ccmail)){ 
            $ccmail = preg_replace('/,+/', ',', $ccmail);
            $ccmail = rtrim(ltrim($ccmail,","),","); 
            $ccmail = explode(',', $ccmail);
            if(count($ccmail)>0){
                
                foreach ($ccmail as $ccaddress) {
                    $phpMailer->AddCC(trim($ccaddress));
                }
            } 
        }
        if(!empty($attfilename)){
            // 'tcpdf/examples/invoice/'.$attfilename it should be as full path 
            $phpMailer->AddAttachment('/home/'.$db_user.'/public_html/'.$attfilename.'', $attfilename);
        }
        $phpMailer->Subject = $subject;
        // $phpMailer->Body = $body;
        $phpMailer->Body = stripslashes($body);
        if(!$phpMailer->send()){
            $namevalue ='errorStatus="1"';
            $where='id="1"';
            $update = updatelisting('mailConnectionMaster',$namevalue,$where);
            
            return false;
        }else{
            $namevalue ='errorStatus="0"';
            $where='id="1"';
            $update = updatelisting('mailConnectionMaster',$namevalue,$where);
            
            return true;
        } 

    } catch (phpmailerException $e) {

        die($e->errorMessage());

    }

} 
 
// currently this function is not in use
function send_attachment_mail($fromemail, $email_to, $subject, $body, $ccmail='',$attfilename=''){

    $select='*';
    $where=' 1 and isDefault=1 ';
    $rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
    $result=mysqli_fetch_array($rs);

    // $phpMailer = new PHPMailer(true); // make true to show error in action
    $phpMailer = new PHPMailer();

    try {

        $phpMailer->SMTPDebug = false;
        // $phpMailer->SMTPDebug = 2;
        $phpMailer->isSMTP();
        $phpMailer->Host = $result['smtp_server'];
        $phpMailer->SMTPAuth = $result['security_type'];
        $phpMailer->Username = $result['email'];
        $phpMailer->Password = decode($result['password']);
        $phpMailer->SMTPSecure = $result['smtp_server']; 
        $phpMailer->Port = $result['port'];
        // $phpMailer->SMTPSecure = false;
        // $phpMailer->Port = 587;
        if(!empty($ccmail)){
            
            $ccmail = preg_replace('/,+/', ',', $ccmail);
            $ccmail = rtrim(ltrim($ccmail,","),","); 
            $ccmail = explode(',', $ccmail);
            if(count($ccmail)>0){
                
                foreach ($ccmail as $ccaddress) {
                    $phpMailer->AddCC(trim($ccaddress));
                }
            }
        }
        
        $phpMailer->isHTML(true);
        $phpMailer->CharSet = "UTF-8";
        $phpMailer->setFrom($result['email'], $result['from_name']);
        $phpMailer->addAddress($email_to);
        if(!empty($attfilename)){
            // 'tcpdf/examples/invoice/'.$attfilename it should be as full path 
            $phpMailer->AddAttachment('/home/'.$db_user.'/public_html/'.$attfilename.'', $attfilename);
        }
        $phpMailer->Subject = $subject;
        $phpMailer->Body = $body;
        $phpMailer->send();

        return true;

    } catch (phpmailerException $e) {
        die($e->errorMessage());
    }

} 
  
//-------------------Mailchimp Integration-------------------------
function rudr_mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields, $tags){
    $data = array(
        'apikey'        => 'f766b68a4ff1b82b215fc3586a871c47-us17',
        'email_address' => $email,
        'status'        => $status,
        'merge_fields'  => $merge_fields 
    );
    $mch_api = curl_init(); // initialize cURL connection
 
    curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_api, CURLOPT_POST, true);
    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
 
    $result = curl_exec($mch_api);
    return $result;
}


function send_bulk_mail($fromemail,$to,$subject,$description) 
{

    $select='*';
    // $where='from_name="Bulk Email"';
    $where=' 1 and isDefault=1 ';
    $rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
    $result=mysqli_fetch_array($rs);

    // $phpMailer = new PHPMailer(true); // make true to show error in action
    $phpMailer = new PHPMailer();

    try {

        $phpMailer->SMTPDebug = false;
        // $phpMailer->SMTPDebug = 2;
        $phpMailer->isSMTP();
        $phpMailer->Host = $result['smtp_server'];
        $phpMailer->SMTPAuth = $result['security_type'];
        $phpMailer->Username = $result['email'];
        $phpMailer->Password = decode($result['password']);
        $phpMailer->SMTPSecure = $result['smtp_server']; 
        $phpMailer->Port = $result['port'];
        // $phpMailer->SMTPSecure = false;
        // $phpMailer->Port = 587;
        if(!empty($ccmail)){
            
            $ccmail = preg_replace('/,+/', ',', $ccmail);
            $ccmail = rtrim(ltrim($ccmail,","),","); 
            $ccmail = explode(',', $ccmail);
            if(count($ccmail)>0){
                
                foreach ($ccmail as $ccaddress) {
                    $phpMailer->AddCC(trim($ccaddress));
                }
            }
        }
        
        $phpMailer->isHTML(true);
        $phpMailer->CharSet = "UTF-8";
        $phpMailer->setFrom($result['email'], $result['from_name']);
        $phpMailer->addAddress($email_to);
        // $phpMailer->AddAttachment('/home/'.$db_user.'/public_html/tcpdf/examples/invoice/'.$attfilename.'', $attfilename);
        // $phpMailer->AddAttachment('/home/'.$db_user.'/public_html/upload/'.$attfilename.'', $attfilename);
        $phpMailer->AddAttachment('/home/'.$db_user.'/public_html/tcpdf/examples/package/'.$attfilename.'', $attfilename);
        // $phpMailer->AddAttachment('/home/'.$db_user.'/public_html/tcpdf/examples/package/'.$attfilename.'', $attfilename);

        $phpMailer->Subject = $subject;
        $phpMailer->Body = $body;
        $phpMailer->send();

        return true;

    } catch (phpmailerException $e) {
        die($e->errorMessage());
    }
         
}
 

?>