<?php
include "config/mail.php"; 

$email = 'vajibabcd@gmail.com';
$status = 'subscribed'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
$list_id = '4e463bf6b0'; // where to get it read above
$api_key = 'f766b68a4ff1b82b215fc3586a871c47-us17'; // where to get it read above
$merge_fields = array('FNAME' => 'Faizan','LNAME' => 'Khan','ADDRESS' => '24 new delhi india','PHONE' => '9654907178');
echo $tags = 'Followup';
 
echo rudr_mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields, $tags);














 ?>