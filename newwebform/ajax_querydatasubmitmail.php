<?php
include "functions.php";
 
 $id=$_POST['balitourid'];

 $country=$_POST['country'];
 //$balitourid=$_POST['balitourid'];
 $exploredesti=$_POST['exploredesti'];
 $leavingForm=$_POST['leavingForm'];
 $fixdate=date('Y-m-d',strtotime($_POST['fixdate']));
 $flexibledate=($_POST['flexibledate']);
 $anytimedate=$_POST['anytimedate'];
 $email=$_POST['email'];
 $mobileNumber=$_POST['mobileNumber'];
 $hotelstars5=$_POST['hotelstars5'];
 $hotelstars4=$_POST['hotelstars4'];
 $hotelstars3=$_POST['hotelstars3'];
 $hotelstars2=$_POST['hotelstars2'];
 $hotelstars1=$_POST['hotelstars1'];
 $flight_requirement=$_POST['flight_requirement'];
 $budget=$_POST['budget'];
 $adults=$_POST['adults'];
 $infant=$_POST['infant'];
 $children=$_POST['children'];
 $iwillbook=$_POST['iwillbook'];
 $flight_requirement_97=$_POST['flight_requirement_97'];
 $tot=$_POST['tot'];
 $yourmessage=$_POST['yourmessage'];
 $durationfilter=$_POST['durationfilter'];
 $bookmyticket=$_POST['bookmyticket'];
  if($bookmyticket=='true'){
 	$bookmyticket='I have booked my travel tickets';
 }else{
 	$bookmyticket='No';
 }
 if($exploredesti=='true'){
 	$exploredesti='I am exploring destinations';
 }else{
 	$exploredesti='No';
 }
 $Websitelead="80";
  if($anytimedate!=''){
 	$fromDate=date('Y-m-d');
	$dateType='AnyTime';
	
 }
 if($fixdate!='1970-01-01'){
 	$fromDate=$fixdate;
	$dateType='Fix Date';
 }
 if($fixdate=='1970-01-01' && $anytimedate==''){
 	
	$month=stristr($flexibledate, ' Week' ,true);
	$Week=preg_replace("/[^0-9\.]/", '', $flexibledate);
	$year=date("Y");
	$day='01';
	$date = $day.' '.$month.' '.$year;
	$date = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +$Week week"));
	
 	$fromDate=$date;
	$dateType='Flexible Date';
 }
if($tot==1){
	$tourtype='Honeymoon';
}
if($tot==2){
	$tourtype='Family';
}
if($tot==3){
	$tourtype='Adventure';
}
if($tot==4){
	$tourtype='Offbeat';
}
if($tot==5){
	$tourtype='Wildlife';
}

if($tot==6){
	$tourtype='Religious';
}
if($flight_requirement==97){
	$flights='Yes';
}
if($flight_requirement==98){
	$flights='No';
}
if($flight_requirement_97==97){
	$sightseeing='Yes';
}
if($flight_requirement_97==98){
	$sightseeing='No';
}
if($iwillbook==1){
	$book='In next 2 - 3 days';
}
if($iwillbook==2){
	$book='In this week';
}
if($iwillbook==3){
	$book='in this month';
}
if($iwillbook==4){
	$book='later sometime';
}
if($iwillbook==5){
	$book='just checking price';
}
if($hotelstars1!=''){
	$hotelstars=1;
}
if($hotelstars2!=''){
	$hotelstars=2;
}
if($hotelstars3!=''){
	$hotelstars=3;
}
if($hotelstars4!=''){
	$hotelstars=4;
}
if($hotelstars5!=''){
	$hotelstars=5;
}
 $fname=stristr($email, '@' ,true);
 //date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days'));
 $toDate=date('Y-m-d', strtotime($fromDate. ' + '.$durationfilter.' days'));
 // $toDate=$fixdate;

 $city="";
 $subject=$leavingForm.' To '.$country.' - '.$dateType;
 
 $Website="deboxglobal.com";
 $LeadTo="info@deboxglobal.com";
 $url=$_SERVER['HTTP_REFERER'];
 $ip=$_SERVER['REMOTE_ADDR'];
 $date_change="";
 $query_date=date('Y-m-d');
 $dateAdded=time();
 $to="info@deboxglobal.com";
if($id==''){
$query="insert into balitourpackage_tourpackage_query(country,explore_destination,leaving_form,fixdate,email,mobileNumber) values('$country','$exploredesti','$leavingForm','$fromDate','$email','$mobileNumber')";

 $con = mysqli_connect('localhost', 'deboxglo_landing', 'admin@3214','deboxglo_landing');

if (!mysqli_query($con,$query))
  {
    die('Connect Error: ' . $mysqli->connect_error);
   }   
		  $query="select * from  balitourpackage_tourpackage_query order by id desc limit 0,1";
		  $result=mysqli_query($con,$query);
		  $rest656=mysqli_fetch_array($result,MYSQLI_ASSOC);
		  $queryId=$rest656['id']+1; 

 }

 if ($id!='') {
   
  	$query="UPDATE `balitourpackage_tourpackage_query` SET `hotel_rating`='$hotelstars',`flight_requirement`='$flight_requirement',`budget`='$budget',`adults`='$adults',`infant`='$infant',`children`='$children',`iwillbook`='$iwillbook',`cab_for_localsightseeing`='$flight_requirement_97',`type_of_tour`='$tot',`additional_requirent`='$yourmessage',`duration`='$durationfilter',`bookmyticket`='$bookmyticket' WHERE id='$id'";
 
	  $con = mysqli_connect('localhost', 'deboxglo_landing', 'admin@3214','deboxglo_landing');
	
	  if (!mysqli_query($con,$query))
	  {
		die('Connect Error: ' . $mysqli->connect_error);
	   }
	
	 }  

 
 
      $s1 = mysqli_query($con,"SELECT MAX(id) FROM `balitourpackage_tourpackage_query`");
      $r1 = mysqli_fetch_array($s1);
      $cur_auto_id = $r1['MAX(id)'];

      mysqli_close($con);  // MySql Connection Close 
      $to='info@deboxglobal.com';
      $fromName='Debox Global.com';
      $from   = $fromName." <info@deboxglobal.com>";
      $title  = " Debox Global.com : ".$cur_auto_id."   ".$subject;
      if($id!='') { 
	  
	  $Message="<table border=1 align=center><tr><td><b>Date Type</b></td><td>" . $dateType .  "</td></tr>" ;
      $Message=$Message . "<tr><td><b>Name</b></td><td>" . $fname .  "</td></tr>";
      $Message=$Message . "<tr><td><b>Arrival Date</b></td><td>" .date('j F Y',strtotime($fromDate)). "</td></tr>";
	  $Message=$Message . "<tr><td><b>Departure Date</b></td><td>" .date('j F Y',strtotime($toDate)) . "</td></tr>";
      $Message=$Message . "<tr><td><b>E-Mail Address </b></td><td>" . $email . "</td></tr>";
	  $Message=$Message . "<tr><td><b>Hotel Category </b></td><td>".($hotelstars)."</td></tr>";
	  $Message=$Message . "<tr><td><b>Need Flight </b></td><td>" . $flights . "</td></tr>";
	  $Message=$Message . "<tr><td><b>Budget</b></td><td>" . $budget . "</td></tr>";
	  $Message=$Message . "<tr><td><b>Adults</b></td><td>" . $adults .  "</td></tr>";
	  $Message=$Message . "<tr><td><b>Childs</b></td><td>" . $children .  "</td></tr>";
	  $Message=$Message . "<tr><td><b>Infants</b></td><td>" . $infant .  "</td></tr>";
	  $Message=$Message . "<tr><td><b>Book</b></td><td>" . $book .  "</td></tr>";
      $Message=$Message . "<tr><td><b>Cab/Sightseeing </b></td><td>" . $sightseeing . "</td></tr>";
	  $Message=$Message . "<tr><td><b>Tour Type</b></td><td>" . $tourtype . "</td></tr>";
      $Message=$Message . "<tr><td><b>Requirement</b></td><td>" . $yourmessage . "</td></tr>";
      $Message=$Message . "<tr><td><b>Country </b></td><td>" . $country . "</td></tr>";
      $Message=$Message . "<tr><td><b>Phone </b></td><td>" . $mobileNumber . "</td></tr>";
      $Message=$Message . "<tr><td><b>IP Address </b></td><td>" . $ip . "</td></tr>";
      $Message=$Message . "<tr><td><b>Link </b></td><td>" . $url . "</td></tr>";
   
      $Message=$Message . "<tr><td><b>Web Site </b></td><td>" . $Website . "</td></tr></table>";
	  
	  }else{
	  
	  $Message="<table border=1 align=center><tr><td><b>Date Type</b></td><td>" . $dateType .  "</td></tr>" ;
   /* $Message=$Message . "<tr><td><b>Query Subject</b></td><td>" . $query_subject .  "</td></tr>";*/
      $Message=$Message . "<tr><td><b>Name</b></td><td>" .$fname. "</td></tr>";
      $Message=$Message . "<tr><td><b>Arrival Date</b></td><td>" .date('j F Y',strtotime($fromDate)). "</td></tr>";
	  $Message=$Message . "<tr><td><b>Departure Date</b></td><td>" .date('j F Y',strtotime($toDate)) . "</td></tr>";
	  $Message=$Message . "<tr><td><b>Explore</b></td><td>" . $exploredesti .  "</td></tr>";
	  $Message=$Message . "<tr><td><b>Flight</b></td><td>" . $bookmyticket .  "</td></tr>";
      $Message=$Message . "<tr><td><b>E-Mail Address </b></td><td>" . $email . "</td></tr>";
      // $Message=$Message . "<tr><td><b>City </b></td><td>" . $city . "</td></tr>";
      $Message=$Message . "<tr><td><b>Country </b></td><td>" . $country . "</td></tr>";
      $Message=$Message . "<tr><td><b>Phone </b></td><td>" . $mobileNumber . "</td></tr>";
      $Message=$Message . "<tr><td><b>IP Address </b></td><td>" . $ip . "</td></tr>";
      $Message=$Message . "<tr><td><b>Link </b></td><td>" . $url . "</td></tr>";
   
      $Message=$Message . "<tr><td><b>Web Site </b></td><td>" . $Website . "</td></tr></table>";
	  
	  }
    
      $success = mail($to,$title,$Message, "From:".$from."\r\nReply-To:".$email."\nMIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1");
      $to1 = $email;
   
    if($_POST['Website']=="www.deboxglobal.com")
    {
    $from1 = "Debox Global<info@deboxglobal.com>";
    $Message1="Greetings from Debox Global Travel India...............!<br><br> Dear Sir / Mam, <br> We thankfully acknowledge receipt of your query and giving us a chance to serve you. We are in receipt of your query and our travel consultants are working on it to provide you with the best deal. <br><br>We are open Monday to Sunday 24 hours .<br><br>Thanks & Regards<br>Debox Global Team";
	
	
     $success = mail($to1,$title,$Message1, "From:".$from1."\r\nReply-To:".$email."\nMIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1");
    }
 

 
 ?>