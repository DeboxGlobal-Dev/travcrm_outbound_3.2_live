<?php

 
  include "../inc.php";
  $balitourid=$_POST['balitourid'];


  //$balitourid=$_POST['balitourid'];
  $exploredesti=$_POST['exploredesti'];

  $fixdate=date('Y-m-d',strtotime($_POST['fixdate']));
  $flexibledate=($_POST['flexibledate']);
  $anytimedate=$_POST['anytimedate'];
  $email=$_POST['email'];
  $nameNN=$_POST['nameNN'];
  $mobileNumber=$_POST['mobileNumber'];
  $hotelCategory=$_POST['hotelCategory'];
  $flight_requirement=$_POST['flight_requirement'];
  $budget=$_POST['budget'];
  $adults=$_POST['adults'];
  $infant=$_POST['infant'];
  $children=$_POST['children'];
  $iwillbook=$_POST['iwillbook'];
  // $flight_requirement_97=$_POST['flight_requirement_97'];
  $tot=$_POST['tot'];
  $yourmessage=$_POST['yourmessage'];
  $durationfilter=$_POST['durationfilter'];
  $bookmyticket=$_POST['bookmyticket'];
  $fromDest=$_POST['fromDest'];
  $toDest=$_POST['toDest'];
  $leavingForm=$_POST['leavingForm'];

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
  if($hotelstars1=='true'){
    $hotelstars=1;
  }
  if($hotelstars2=='true'){
    $hotelstars=2;
  }
  if($hotelstars3=='true'){
    $hotelstars=3;
  }
  if($hotelstars4=='true'){
    $hotelstars=4;
  }
  if($hotelstars5=='true'){
    $hotelstars=5;
  }
  if($hotelstars5=='false' && $hotelstars5=='false' && $hotelstars5=='false' && $hotelstars5=='false' && $hotelstars5=='false'){
    $hotelstars=0;
  }

  $specific_requirements='Travel Ticket :- '.$bookmyticket.'<br> Explore :- '.$exploredesti.'<br> I will book :- '.$book.'<br>'.$yourmessage;
  //  $fname=stristr($email, '@' ,true);
   //date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days'));
   $toDate=date('Y-m-d', strtotime($fromDate. ' + '.$durationfilter.' days'));
   // $toDate=$fixdate;
   
  $a12='';
  $a12=GetPageRecord('*','destinationMaster',' id="'.$fromDest.'" order by name asc');
  $fromDestData=mysqli_fetch_array($a12);
  $fromDestN=$fromDestData['name'];
   

  $a12='';
  $a12=GetPageRecord('*','destinationMaster',' id="'.$toDest.'" order by name asc');
  $toDestData=mysqli_fetch_array($a12);
  $toDestN=$toDestData['name'];
     

  $subject=$fromDestN.' To '.$toDestN.' - '.$dateType;


  $city=""; 
  $Website="deboxglobal.com";
  $LeadTo="info@deboxglobal.com";
  $url=$_SERVER['HTTP_REFERER'];
  $ip=$_SERVER['REMOTE_ADDR'];
  $date_change="";
  $query_date=date('Y-m-d');
  $dateAdded=time();
  //$to="info@goinmyway.co.in,goinmywaytours@gmail.com";
  $to="irfandeboxglobal@gmail.com";
  if($balitourid==''){

    $namevalue="country='".$toDest."',explore_destination='".$exploredesti."',leaving_form='".$leavingForm."',fixdate='".$fromDate."',email='".$email."',mobileNumber='".$mobileNumber."',fromDestination='".$fromDest."'"; 
    $lastBaliId = addlistinggetlastid('balitourpackage_tourpackage_query',$namevalue);
 
    if($lastBaliId > 0){

      $a12='';
      $a12=GetPageRecord('*','balitourpackage_tourpackage_query',' id="'.$lastBaliId.'" ');
      $rest656=mysqli_fetch_array($a12); 
      $baliId=$rest656['id']+1; 
      $_SESSION['id']=$baliId;

      header('location: '.$fullurl.'webquery.php?fromDate='.$fromDate.'&toDate='.$toDate.'&email='.$email.'&fname='.$nameNN.'&city='.$city.'&toDest='.$toDest.'&phone='.$mobileNumber.'&subject='.$subject.'&ip='.$ip.'&Website='.$Website.'&LeadTo='.$LeadTo.'&url='.$url.'&date_change='.$date_change.'&query_date='.$query_date.'&exploring='.$exploredesti.'&queryPriority=2&websitelead='.$Websitelead.'&baliId='.$baliId.'&fromDest='.$fromDest.'&leavingForm='.$leavingForm.'&adult='.$adults.'&child='.$children.'&tourtype='.$tot.'&budget='.$budget.'&durationfilter='.$durationfilter.'&yourmessage='.$yourmessage.'&hotelCategory='.$hotelCategory.'&flight_requirement='.$flight_requirement.'');

    }
  } 
  if ($balitourid>0) {
   
    $namevalue6 ="hotel_rating='".$hotelstars."',flight_requirement='".$flight_requirement."',budget='".$budget."',adults='".$adults."',infant='".$infant."',children='".$children."',iwillbook='".$iwillbook."',cab_for_localsightseeing='".$flight_requirement_97."',type_of_tour='".$tot."',additional_requirent='".$yourmessage."',duration='".$durationfilter."',bookmyticket='".$bookmyticket."',fromDestination='".$fromDest."'";
    $where6 = 'id='.$balitourid.'';
    updatelisting('balitourpackage_tourpackage_query',$namevalue6,$where6);
  
    header('location: '.$fullurl.'webquery.php?baliId='.$_SESSION['id'].'&adult='.$adults.'&child='.$children.'&infant='.$infant.'&tourtype='.$tot.'&hotelCategory='.$hotelstars.'&flight_requirement_97='.$flight_requirement_97.'&flight_requirement='.$flight_requirement.'&budget='.$budget.'&specific_requirements='.$specific_requirements.'&fromDest='.$fromDest.'');
  }  


  // old code below
  
// include "functions.php";
//   session_start();
//  $balitourid=$_POST['balitourid'];

//  $country=$_POST['country'];
//  //$balitourid=$_POST['balitourid'];
//  $exploredesti=$_POST['exploredesti'];
//  $leavingForm=$_POST['leavingForm'];
//  $fixdate=date('Y-m-d',strtotime($_POST['fixdate']));
//  $flexibledate=($_POST['flexibledate']);
//  $anytimedate=$_POST['anytimedate'];
//  $email=$_POST['email'];
//  $mobileNumber=$_POST['mobileNumber'];
//  $hotelstars5=$_POST['hotelstars5'];
//  $hotelstars4=$_POST['hotelstars4'];
//  $hotelstars3=$_POST['hotelstars3'];
//  $hotelstars2=$_POST['hotelstars2'];
//  $hotelstars1=$_POST['hotelstars1'];
//  $flight_requirement=$_POST['flight_requirement'];
//  $budget=$_POST['budget'];
//  $adults=$_POST['adults'];
//  $infant=$_POST['infant'];
//  $children=$_POST['children'];
//  $iwillbook=$_POST['iwillbook'];
//  $flight_requirement_97=$_POST['flight_requirement_97'];
//  $tot=$_POST['tot'];
//  $yourmessage=$_POST['yourmessage'];
//  $durationfilter=$_POST['durationfilter'];
//  $bookmyticket=$_POST['bookmyticket'];
//   $from=$_POST['from'];
 
 
//   if($bookmyticket=='true'){
//  	$bookmyticket='I have booked my travel tickets';
//  }else{
//  	$bookmyticket='No';
//  }
//  if($exploredesti=='true'){
//  	$exploredesti='I am exploring destinations';
//  }else{
//  	$exploredesti='No';
//  }
//  $Websitelead="80";
//   if($anytimedate!=''){
//  	$fromDate=date('Y-m-d');
// 	$dateType='AnyTime';
	
//  }
//  if($fixdate!='1970-01-01'){
//  	$fromDate=$fixdate;
// 	$dateType='Fix Date';
//  }
//  if($fixdate=='1970-01-01' && $anytimedate==''){
 	
// 	$month=stristr($flexibledate, ' Week' ,true);
// 	$Week=preg_replace("/[^0-9\.]/", '', $flexibledate);
// 	$year=date("Y");
// 	$day='01';
// 	$date = $day.' '.$month.' '.$year;
// 	$date = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +$Week week"));
	
//  	$fromDate=$date;
// 	$dateType='Flexible Date';
//  }
// if($tot==1){
// 	$tourtype='Honeymoon';
// }
// if($tot==2){
// 	$tourtype='Family';
// }
// if($tot==3){
// 	$tourtype='Adventure';
// }
// if($tot==4){
// 	$tourtype='Offbeat';
// }
// if($tot==5){
// 	$tourtype='Wildlife';
// }

// if($tot==6){
// 	$tourtype='Religious';
// }
// if($flight_requirement==97){
// 	$flights='Yes';
// }
// if($flight_requirement==98){
// 	$flights='No';
// }
// if($flight_requirement_97==97){
// 	$sightseeing='Yes';
// }
// if($flight_requirement_97==98){
// 	$sightseeing='No';
// }
// if($iwillbook==1){
// 	$book='In next 2 - 3 days';
// }
// if($iwillbook==2){
// 	$book='In this week';
// }
// if($iwillbook==3){
// 	$book='in this month';
// }
// if($iwillbook==4){
// 	$book='later sometime';
// }
// if($iwillbook==5){
// 	$book='just checking price';
// }
// if($hotelstars1=='true'){
// 	$hotelstars=1;
// }
// if($hotelstars2=='true'){
// 	$hotelstars=2;
// }
// if($hotelstars3=='true'){
// 	$hotelstars=3;
// }
// if($hotelstars4=='true'){
// 	$hotelstars=4;
// }
// if($hotelstars5=='true'){
// 	$hotelstars=5;
// }
// if($hotelstars5=='false' && $hotelstars5=='false' && $hotelstars5=='false' && $hotelstars5=='false' && $hotelstars5=='false'){
// 	$hotelstars=0;
// }


// $specific_requirements='Travel Ticket :- '.$bookmyticket.'<br> Explore :- '.$exploredesti.'<br> I will book :- '.$book.'<br>'.$yourmessage;
//  $fname=stristr($email, '@' ,true);
//  //date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days'));
//  $toDate=date('Y-m-d', strtotime($fromDate. ' + '.$durationfilter.' days'));
//  // $toDate=$fixdate;
 
//  $query = "SELECT * FROM destinationMaster WHERE id=".$leavingForm." order by name asc";
// $data=mysqli_query($con,$query); 
// while($row=mysqli_fetch_array($data)){
// $leavingdest=$row['name'];
//  }
 
// $query = "SELECT * FROM destinationMaster WHERE id=".$country." order by name asc";
// $data=mysqli_query($con,$query); 
// while($row=mysqli_fetch_array($data)){
// $countrydest=$row['name'];
//  }

// $subject=$leavingdest.' To '.$countrydest.' - '.$dateType;




//  $city=""; 
//  $Website="deboxglobal.com";
//  $LeadTo="info@deboxglobal.com";
//  $url=$_SERVER['HTTP_REFERER'];
//  $ip=$_SERVER['REMOTE_ADDR'];
//  $date_change="";
//  $query_date=date('Y-m-d');
//  $dateAdded=time();
//  //$to="info@goinmyway.co.in,goinmywaytours@gmail.com";
//  $to="irfandeboxglobal@gmail.com";
// if($balitourid==''){
// $query="insert into balitourpackage_tourpackage_query(country,explore_destination,leaving_form,fixdate,email,mobileNumber,fromDestination) values('$country','$exploredesti','$leavingForm','$fromDate','$email','$mobileNumber','$from')"; 
//  $con = mysqli_connect('localhost', 'deboxglo_landing', 'admin@3214','deboxglo_landing'); 

// if (!mysqli_query($con,$query))
//   {
//     die('Connect Error: ' . $mysqli->connect_error);
//    }   
// 		  $query="select * from  balitourpackage_tourpackage_query order by id desc limit 0,1";
// 		  $result=mysqli_query($con,$query);
// 		  $rest656=mysqli_fetch_array($result,MYSQLI_ASSOC);
// 		  $baliId=$rest656['id']+1; 
// 		  $_SESSION['id']=$baliId;
		  
// 		  header('location: //deboxglobal.co.in/travcrm/webquery.php?fromDate='.$fromDate.'&toDate='.$toDate.'&email='.$email.'&fname='.$fname.'&city='.$city.'&country='.$country.'&phone='.$mobileNumber.'&subject='.$subject.'&ip='.$ip.'&Website='.$Website.'&LeadTo='.$LeadTo.'&url='.$url.'&date_change='.$date_change.'&query_date='.$query_date.'&exploring='.$exploredesti.'&queryPriority=2&websitelead='.$Websitelead.'&baliId='.$baliId.'&from='.$from.'&leavingForm='.$leavingForm.'');

//  }

//  if ($balitourid!='') {
   
//   	$query="UPDATE `balitourpackage_tourpackage_query` SET `hotel_rating`='$hotelstars',`flight_requirement`='$flight_requirement',`budget`='$budget',`adults`='$adults',`infant`='$infant',`children`='$children',`iwillbook`='$iwillbook',`cab_for_localsightseeing`='$flight_requirement_97',`type_of_tour`='$tot',`additional_requirent`='$yourmessage',`duration`='$durationfilter',`bookmyticket`='$bookmyticket',`fromDestination`='$from' WHERE id='$balitourid'";
 
// 	  $con = mysqli_connect('localhost', 'deboxglo_landing', 'admin@3214','deboxglo_landing');
	
// 	  if (!mysqli_query($con,$query))
// 	  {
// 		die('Connect Error: ' . $mysqli->connect_error);
// 	   }  
// 	   header('location: //deboxglobal.co.in/travcrm/webquery.php?id='.$_SESSION['id'].'&adult='.$adults.'&child='.$children.'&infant='.$infant.'&tourtype='.$tot.'&hotelCategory='.$hotelstars.'&flight_requirement_97='.$flight_requirement_97.'&flight_requirement='.$flight_requirement.'&budget='.$budget.'&specific_requirements='.$specific_requirements.'&from='.$from.'');
	   
	
// 	 }  
 
?>