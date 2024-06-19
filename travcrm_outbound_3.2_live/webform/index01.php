<!DOCTYPE html>
<html lang="en">
<head>
<title>Bali Tour Package Itinerary</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta charset="utf-8" />
<meta content="eTravel.flights.searches.new" name="js-namespace">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lora:400,400italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:300,400,500,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'> 


<link rel="icon" href="favicon.png" />
<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/sunny/jquery-ui.css">
<link href="../css/zebra.css" media="all" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.ui.css">
<link rel="stylesheet" href="css/jquery.formstyler.css">
<link rel="stylesheet" href="css/style.css" />
 
<link rel="stylesheet" href="css/main.css" />

<script src="js/jquery.1.7.1.js"></script>   
<script src="../js/zebra_datepicker.js"></script> 

<!--balitourpackagesjs-->
<script>
$(document).ready(function() { 
 $('#fixdate').Zebra_DatePicker({ 
  direction:true,
  format: 'd-m-Y',  
});  

 $('#flexibledate').Zebra_DatePicker({ 
  direction:true,
  format: 'd-m-Y',  
});  

});
</script>

<script>
$(document).ready(function(){
  $("#fixdate").click(function(){
    $(".popup-date-inner").addClass('popupdateinnernew');
    $("#flexibledate").hide();
    $("#anytimedate").hide();
    $("#noofdayspopup").show();
  });
});

setInterval(function(){
var flexibledate = $('#flexibledate').val();
 
if(flexibledate!='' && flexibledate!='Flexible Date'){
 
 
 if(flexibledate.indexOf('Week') == -1){
var id = flexibledate;
    var arr = id.split("-"); 
  
arr = Number(arr[0].replace(/^0+/, ''));


var month = flexibledate;
var arra = month.split("-"); 
var mon = Number(arra[1].replace(/^0+/, '')); 
 
var data=new Array("January","February","March","April","May","June","July","August","September","October","November","December"); 
var numberOfMonth = mon; 
var mon = data[numberOfMonth - 1];

var weekname='';

if(arr==1 || arr<8){
weekname='Week 1';
}

if(arr>7 && arr<15){
weekname='Week 2';
}

if(arr>14 && arr<23){
weekname='Week 3';
}


if(arr>22 && arr<=31){
weekname='Week 4';
}


 
$('#flexibledate').val(mon+' '+weekname);
$(".popup-date-inner").addClass('popupdateinnernew');
$('#fixdate').hide();
$('#anytimedate').hide();
$('#noofdayspopup').show(); 
$('#resetbtndiv').show();
 
 }
 }
 }, 500);
</script>
<!--end of bali js-->




<style>
.loader, .loader:before, .loader:after {
  border-radius: 50%;
  width: 2.5em;
  height: 2.5em;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation: load7 1.8s infinite ease-in-out;
  animation: load7 1.8s infinite ease-in-out;
}
.loader {
  color: #f25f5c;
  font-size: 10px;
  margin: 0px auto;
  position: relative;
  text-indent: -9999em;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}
.loader:before, .loader:after {
  content: '';
  position: absolute;
  top: 0;
}
.loader:before {
  left: -3.5em;
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}
.loader:after {
  left: 3.5em;
}
 @-webkit-keyframes load7 {
0%, 80%, 100% {
box-shadow: 0 2.5em 0 -1.3em;
}
 40% {
box-shadow: 0 2.5em 0 0;
}
}
 @keyframes load7 {
0%, 80%, 100% {
box-shadow: 0 2.5em 0 -1.3em;
}
 40% {
box-shadow: 0 2.5em 0 0;
}
}
.tour-item .cat-list-item-rb .offer-slider-r b {
  text-decoration: line-through;
}
.offer-slider-r span {
  display: none;
}
.hasDatepicker{
 position: relative;
}
</style>
</head>
<body>

<!-- // authorize // -->
<div class="overlay"></div>
    <div class="autorize-popup"> 
      <form name="frm_one">
         <div class="autorize-padding" id="autorize-padding-first-block">
        <h6 class="autorize-lbl debox_autorize-lbl" id="pop-title">Get Free Quotes</h6>
        <div class="side-block fly-in" id="formright_1">
              <div class="side-block-search">
                 <div class="page-search-p" style="padding-top:0;">
                    <div class="srch-tab-line">
                       <div class="srch-tab">
                          <label>Going to</label>
                          <div class="input-a">
                             <input type="text" autocomplete="off" placeholder="Leaving from" name="country" id="country" value="Bali" readonly="">

                          </div>
                       </div>
                       
                        <div class="srch-tab">
                          <input type="checkbox" id="exploredesti" name="exploredesti" value="1" style="margin: 0px;cursor: pointer;position: absolute;top: 4px;left:0px;">
                          <label><span style="font-family: lato;font-size: 13px; position: relative;margin-left: 15px;font-weight: 500;text-transform: none;">I am exploring destinations</span></label>
                         
                       </div>
                       
                       <div class="srch-tab">
                          <label>Leaving from <span style="color:#ff0000;"> *</span><span id="leaving" style="color:#ff0000; display: none;    float: right;  margin-right: 28%;" >Please enter your Leaving from</span></label>
                          <div class="input-a">
                             <input type="text" autocomplete="off" placeholder="Leaving from" name="leavingForm" id="leavingForm" onKeyUp="leavingFunct();">
                             <span class="date-icon"></span>
                          </div>
                       </div>
                       
                       
                       <div class="srch-tab">
                          <label>Depature Date <span style="color:#ff0000;"> *</span><span style="font-size: 12px;font-weight: 400;">(Choose any)</span></label>
                          <div class="popup-date">
<script>
function resetbuttons(){
$("#flexibledate").show();
$("#anytimedate").show();

$("#fixdate").show();
$("#fixdate").val('');
$("#flexibledate").val('');
$('.week-picker').hide();
$("#bookmyticketshow").hide();
$("#noofdayspopup").hide();
}
</script>
            
<script type="text/javascript">
 function weekcalanderfun() {
    var startDate;
    var endDate;
  
  $(".popup-date-inner").addClass('popupdateinnernew');
    $("#flexibledate").show();
    $("#anytimedate").hide();
    $("#noofdayspopup").show();
    $("#fixdate").hide();
    $("#resetbtndiv").hide(); 
  $(".hasDatepicker").removeAttr("style"); 
  
    var selectCurrentWeek = function() {
    
    
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
      }, 1);
    
    }
    
    $('.week-picker').datepicker( {
        showOtherMonths: true,
        selectOtherMonths: true,
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            var newstartdate =  $.datepicker.formatDate( dateFormat, startDate, inst.settings );
            var newenddate =  $.datepicker.formatDate( dateFormat, endDate, inst.settings ); 
      //alert();
      $("#flexibledate").val(newstartdate +' - '+ newenddate);
      $("#resetbtndiv").show();
            $('.week-picker').hide();
            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });
    
    $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
};
</script>

<script>
function anytime(){
$(".popup-date-inner").addClass('popupdateinnernew');
    $("#flexibledate").hide();
    $("#anytimedate").show();
    $("#noofdayspopup").show();
    $("#fixdate").hide();
    $("#resetbtndiv").hide(); 
  $("#resetbtndiv").show();
}
</script>



          <a onClick="resetbuttons();$('#resetbtndiv').hide();$('.popup-date-inner').removeClass('popupdateinnernew');" id="resetbtndiv" style="display: none;" class="xbtn">x</a>
                             <input type="text" id="fixdate" name="fixdate" class="popup-date-inner" autocomplete="off" placeholder="Fixed Date" value="Fixed Date" onFocus="$('#resetbtndiv').show();" readonly="">
                             <input type="text" id="flexibledate" name="flexibledate" class="popup-date-inner" autocomplete="off" placeholder="Flexible Date" value="Flexible Date"     readonly="" onClick="$("#bookmyticketshow").hide();">
                             <input type="text" id="anytimedate" name="anytimedate" class="popup-date-inner" autocomplete="off" placeholder="Anytime" value="Anytime"  readonly="" onClick="$('#bookmyticketshow').hide(); anytime();">
                             <div class="srch-tab" id="noofdayspopup" style="width: 45%;float: right; margin-right: 11px; margin-top: -25px;display:none;">
                               <label>No of Days<span style="color:#ff0000;"> *</span><span id="durationvalidation" style="color:#ff0000; display: none;    float: right;  margin-right: 31%;" >Please enter duration</span></label>
                               <div class="input-a">
                                
                                 <input type="text" autocomplete="off" id="durationfilter"  name="durationfilter" placeholder="Duration" value="1" style="text-align:center;">
                                 <div class="dec incbutton1" id="popupminus" onClick="donationcheck(1);" value="-">-</div>
                                 <div class="inc incbutton" id="popupplus" onClick="donationcheck(2);" value="+">+</div>
                                 <span class="date-icon"></span>
                               </div>
                           </div>
              <div class="week-picker"></div> 
                           <script>
               function donationcheck(id){ 
                 var popupminus = $('#popupminus').val();
                 var popupplus = $('#popupplus').val();
                 var durationfilter = Number($('#durationfilter').val()); 
                if(id=='1'){
               var totalduration= Number(durationfilter-1);
               $('#durationfilter').val(totalduration)
               }
               
               if(id=='2'){
               var totalduration= Number(durationfilter+1);
               $('#durationfilter').val(totalduration)
               } 
               
               }
               </script>
                          </div>
                       </div>


                        <div class="srch-tab" id="bookmyticketshow" style="display: none;">
                          <input type="checkbox" id="bookmyticket" name="bookmyticket" value="1" style="margin: 0px;cursor: pointer;position: absolute;top: 4px;left:0px;">
                          <label><span style="font-family: lato;font-size: 13px; position: relative;margin-left: 15px;font-weight: 500;text-transform: none;">I have booked my travel tickets</span></label>
                         
                       </div>
                       
                       
                       <div class="srch-tab">
                          <label>Email<span style="color:#ff0000;"> *</span><span id="emailvalidation" style="color:#ff0000; display: none;    float: right;  margin-right: 40%;" >Please enter your email address</span></label>
                          <div class="input-a">
                             <input type="text" autocomplete="off" placeholder="Email" name="email" id="email" onKeyUp="emailvalidation123()" onKeyDown="emailvalidationkeydown()" >
                             <span class="date-icon"></span>
                          </div>
                       </div>
                       <div class="srch-tab">
                          <label>Mobile Number<span style="color:#ff0000;"> *</span><span id="phonenovalidation" style="color:#ff0000; display: none;    float: right;  margin-right: 31%;" >Please enter your contact no</span></label>
                          <div class="input-a">
                             <input type="text" autocomplete="off" placeholder="Mobile/Contact Number" name="mobileNumber" id="mobileNumber" onKeyUp="phonevalidation123()">
                             <span class="date-icon"></span>
                          </div>
                       </div>
                       <div class="popup-first-button">
                          <input type="button" class="popup-first-plan-button" id="clickmeplanmyholidays" name="clickmeplanmyholidays" value="Plan my Holidays">
                          <div style="color: #555;width: 100%; text-align: center; margin-top: 6px; font-family: lato;font-size: 13px;font-weight: 400;">Your information will be kept confidential</div>
                       </div>
                       <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                 </div>
              </div>
           </div>
        </div>
         
         <div class="autorize-padding" id="autorize-padding-second-block" style="display:none;">
        <h6 class="autorize-lbl debox_autorize-lbl" id="pop-title">Great! Tell Us What You Prefer</h6>
        <div class="side-block fly-in" id="formright_1">
              <div class="side-block-search">
                 <div class="page-search-p" style="padding-top:0;">
                    <div class="srch-tab-line">
                      
                      <div class="srch-tab">
                          <label>Preferred Hotel Category (Rating)<span style="color:#ff0000;"> *</span><span id="ratingvalidation" style="color:#ff0000; display: none;    float: right;  margin-right: 31%;" >Please select rating</span></label>
                          <ul class="list-inline list-checkbox margin-bottom-25 margin-left-25 options">
                              <li>
							  <?php 
							   $con = mysqli_connect('localhost', 'goinmywa_query', 'welcome@123','goinmywa_query');   
							  $query="select * from  balitourpackage_tourpackage_query order by id desc limit 0,1";
							  $result=mysqli_query($con,$query);
							  $rest656=mysqli_fetch_array($result,MYSQLI_ASSOC);
							  $queryId=$rest656['id']+1; 
							  ?>
                              <input type="checkbox" name="hotelstars5" id="hotelstars" value="5">

                              <input type="hidden" name="balitourid" id="balitourid" value="<?php echo $queryId; ?>">

                              <label for="hotel_catagory_5 Star">5 Star</label>
                              <div class="sea-green text-center line-height-2"><small></small></div>
                              </li>
                              
                              <li>
                              <input type="checkbox" name="hotelstars4" id="hotelstars" value="4">
                              <label for="hotel_catagory_4 Star">4 Star</label>
                              <div class="sea-green text-center line-height-2"><small></small></div>
                              </li>
                              
                              <li>
                              <input type="checkbox" name="hotelstars3"  id="hotelstars"value="3">
                              <label for="hotel_catagory_3 Star">3 Star</label>
                              <div class="sea-green text-center line-height-2"><small></small></div>
                              </li>
                              
                              <li>
                              <input type="checkbox" name="hotelstars2" id="hotelstars"value="2">
                              <label for="hotel_catagory_2 Star">2 Star</label>
                              <div class="sea-green text-center line-height-2"><small></small>
                              </div></li>
                              
                              <li>
                              <input type="checkbox" name="hotelstars1" id="hotelstars" value="1">
                              <label for="hotel_catagory_notReq">No</label>
                              </li>
                              
                              </ul>
                       </div>
                       
                       <div class="questions" id="flight_requirement" ng-show="flight_requirementShown">
                           <p style="display: inline-block;color: #3e3e3e !important;line-height: 20px !important;font-weight: 600;" class="questionsp">
                               <i class="title-icon"></i>
                               Do You Need Flights?
                           </p>
                           <ul class="list-inline list-checkbox margin-bottom-25 margin-left-25 options">
                               <li><input class="" type="radio" name="flight_requirement" value="97" id="flight_requirement_97" onChange="addAirfarefun(this);" ><label for="flight_requirement_97">Yes</label>
                               </li>
                               <li><input class="" type="radio" name="flight_requirement" value="98" id="flight_requirement_97" onChange="addAirfarefun(this);"><label for="flight_requirement_98">No</label>
                               </li>
                            </ul>
                        </div> 
                        
                        <script>
            function addAirfarefun(getid){
             var id = $(getid).attr('id');
            if(id=='flight_requirement_97'){
              $('#airfare').text('Expected Budget With Airfare - ');
            }else{
              $('#airfare').text('Expected Budget Without Airfare - ');
            }
            
            }
            </script>
                        
                       <div class="srch-tab">
                          <label id="airfare" style="float: left;">Expected Budget Without Airfare - </label><span style="font-size: 12px;font-weight: 400;">&nbsp;(Per Person For Entire Trip)</span>
                          <div class="input-a" style="margin-top: 10px !important;">
                             <input type="text" autocomplete="off" placeholder="Budget" name="budget" id="budget">
                             <span class="date-icon"></span>
                          </div>
                       </div>
                       
                       <div class="srch-tab">
                          <label>Number Of Travelers</label>
                         <div class="no-of-childs-block-combo">
                             <select class="input-a" name="adults" id="adults" style="box-shadow: none;color: #4f4f4f; border-radius: 2px;border-color: #b2b2b2;height: 34px;font-size: 13px;">
                                <option value="0" disabled="">Adults (12+ yrs)</option>
                                <option value="1">1 Adult</option><option value="2" selected="">2 Adults</option>
                                <option value="3">3 Adults</option><option value="4">4 Adults</option>
                                <option value="5">5 Adults</option><option value="6">6 Adults</option>
                                <option value="7">7 Adults</option><option value="8">8 Adults</option><option value="9">9 Adults</option><option value="10">10 Adults</option><option value="11">11 Adults</option><option value="12">12 Adults</option><option value="13">13 Adults</option>
                                <option value="14">14 Adults</option><option value="15">15 Adults</option><option value="16">16 Adults</option><option value="17">17 Adults</option>
                                <option value="18">18 Adults</option><option value="19">19 Adults</option><option value="20">20 Adults</option><option value="21">20+ Adults</option>
                             </select>
                         </div>
                         
                         <div class="no-of-childs-block-combo">
                             <select class="input-a" name="infant" id="infant" style="box-shadow: none;color: #4f4f4f; border-radius: 2px;border-color: #b2b2b2;height: 34px;font-size: 13px;">
                               <option value="0" selected="" disabled="">Infant (0-2yrs)</option>
                               <option value="1"> 1 Infant</option><option value="2">2 Infants</option><option value="3">3 Infants</option>
                               <option value="4">4 Infants</option><option value="5">5 Infants</option><option value="6">6 Infants</option>
                               <option value="7">7 Infants</option><option value="8">8 Infants</option><option value="9">9 Infants</option>
                               <option value="10">10 Infants</option><option value="11">11 Infants</option><option value="12">12 Infants</option>
                               <option value="13">13 Infants</option><option value="14">14 Infants</option>
                             </select>
                         </div>
                         
                         <div class="no-of-childs-block-combo">
                             <select class="input-a" name="children" id="children" style="box-shadow: none;color: #4f4f4f; border-radius: 2px;border-color: #b2b2b2;height: 34px;font-size: 13px;">
                                <option value="0" selected="" disabled="">Child (2-12yrs)</option>
                                <option value="1"> 1 Child</option><option value="2">2 Children</option>
                                <option value="3">3 Children</option><option value="4">4 Children</option>
                                <option value="5">5 Children</option><option value="6">6 Children</option><option value="7">7 Children</option>
                                <option value="8">8 Children</option><option value="9">9 Children</option><option value="10">10 Children</option>
                                <option value="11">11 Children</option><option value="12">12 Children</option><option value="13">13 Children</option>
                                <option value="14">14 Children</option>
                             </select>
                         </div>
                         
                       </div>
                       
                        <div class="srch-tab">
                          <label style="text-transform:unset !important">I will book</label>
                          <div class="">
                             <Select class="input-a"  name="iwillbook" id="iwillbook" style="box-shadow: none;color: #4f4f4f; border-radius: 2px;border-color: #b2b2b2;height: 34px;font-size: 13px;width: 99% !important;">
                                <option value="1">In next 2 - 3 days</option>
                                <option value="2">In this week</option>
                                <option value="3">in this month</option>
                                <option value="4">later sometime</option>
                                <option value="5">just checking price</option>
                             </Select>
                          </div>
                       </div>
                       
                       <div class="popup-first-button1">  
                          <input type="button" class="popup-first-plan-button1" id="cancelmovetofirst" value="Back"> 
                          <input type="button" class="popup-first-plan-button2" id="clickmethirdstep" value="Next(2 of 3)"> 
                       </div>
                       <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                 </div>
              </div>
           </div>
        </div>
        
        
        
         <div class="autorize-padding" id="autorize-padding-third-block" style="display:none;">
    <h6 class="autorize-lbl debox_autorize-lbl" id="pop-title">Almost Done!</h6>
    <div class="side-block fly-in" id="formright_1">
        <div class="side-block-search">
            <div class="page-search-p" style="padding-top:0;">
                <div class="srch-tab-line">

                    <div class="srch-tab">


                        <div class="questions" id="flight_requirement" ng-show="flight_requirementShown">
                            <p style="display: inline-block;color: #3e3e3e !important;line-height: 20px !important;font-weight: 600;" class="questionsp">
                                <i class="title-icon"></i> Cab for local sightseeing?
                            </p>
                            <ul class="list-inline list-checkbox margin-bottom-25 margin-left-25 options">
                                <li>
                                    <input class="option ng-pristine ng-untouched ng-valid" type="radio" name="flight_requirement" value="97" ng-change="handleAction('flight_requirement', '97','Yes')" id="flight_requirement_97" ng-model="cust_23">
                                    <label for="flight_requirement_97">Yes</label>
                                </li>
                                <li>
                                    <input class="option ng-pristine ng-untouched ng-valid" type="radio" name="flight_requirement" value="98" ng-change="handleAction('flight_requirement', '98','No')" id="flight_requirement_98" ng-model="cust_23">
                                    <label for="flight_requirement_98">No</label>
                                </li>
                            </ul>
                        </div>
                        
                            <label>Type of tour you want?</label>

                        <div class="no-of-childs-block-combo" style="width:103% !important;margin-bottom: 15px;">
                            <select class="input-a" name="tot" id="tot" style="box-shadow: none;color: #4f4f4f; border-radius: 2px;border-color: #b2b2b2;height: 34px;font-size: 13px;">
                                <option value="" disabled="">Type of tour</option>
                                <option value="1">Honeymoon</option>
                                <option value="2">Family</option>
                                <option value="3">Adventure</option>
                                <option value="4">Offbeat</option>
                                <option value="5">Wildlife</option>
                                <option value="6">Wildlife</option>
                                <option value="7">Religious</option>
                            </select>
                        </div>
                        
                        

                        <div class="srch-tab">
                            <label>Additional Requirement</label>
                            <div class="">
                                <textarea  class="input-a" name="yourmessage" id="yourmessage" Placeholder="* Hotel names if you have already decided,
* Special considerations, e.g. kid friendly,
* Arrival and departure date / time, if tickets booked?" style="width: 94%;font-size: 10px;height:50px !important"></textarea>
                                <span class="date-icon"></span>
                            </div>
                        </div>

                        <div class="popup-first-button1">
                            <input type="button" class="popup-first-plan-button1" id="cancelmovetosecond" value="Back">
                            <input type="button" class="popup-first-plan-button2" id="submitfromdebox" value="Submit">
                        </div>

                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>

                </div>
            </div>

        </div>
    </div>
</div>

         
         <div class="autorize-padding" id="autorize-padding-fourth-block" style="display:none;">
             
             
         <div style="width: 40%;margin: auto;"><img src="thanksmsg.png" alt="Thnaks messge for query" style="width:100%;height:auto;"></div>
        
        <h4 style="width: 100%;text-align: center;font-family: lato;font-size: 15px;font-weight: 500;text-decoration: underline;color: #34a4ca;">Dear Guest, Thanks you for your interest !</h4>
        <p style="width: 90%;margin: auto;text-align: justify;font-family: lato;font-size: 13px;color: #333;font-weight: 400;">Our Sales representative will be in touch with you shortly!!!. Don't Forget to check your inbox in next 24 Hrs, We are committed to reply your request within that time. </p>
        <div class="side-block fly-in" id="formright_1">
              <div class="side-block-search">
                 <div class="page-search-p" style="padding-top:0;">
                    <div class="srch-tab-line">
                       
                       <div class="popup-first-button">
                          <input type="button" class="popup-first-plan-button" id="gotopackage" value="Go To Packages"> 
                       </div>
                         
                       <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                 </div>
              </div>
           </div>
        </div>    
      
      
      </form>
    </div>
    
<header id="top">
  <div class="header-b"> 
    
    <!-- // mobile menu // -->
    
    <div class="mobile-menu">
      <nav>
        <ul>
          <li><a class="has-child" href="#">HOME</a></li>
          <li><a href="#">INTERNATIONAL TOUR</a></li>
          <li><a href="#">HOLIDAYS PACKAGES</a></li>
          <li><a href="#">CONTACS</a></li>
        </ul>
      </nav>
    </div>
    
    <!-- \\ mobile menu \\ -->
    
    <div class="wrapper-padding">
      <div class="header-logo"><a href="index.html"><img alt="" src="images/logo.png" /></a></div>
      <div class="header-right"> <a href="#" class="menu-btn"></a>
        <nav class="header-nav">
          <ul>
            <li><a class="has-child" href="#">HOME</a></li>
            <li><a href="#">INTERNATIONAL TOUR</a></li>
            <li><a href="#">HOLIDAYS PACKAGES</a></li>
            <li><a href="#">CONTACS</a></li>
          </ul>
        </nav>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</header>
<!-- main-cont -->
<div class="main-cont" id="main-cont">
  <div class="body-wrapper">
    <div class="wrapper-padding">
      <div class="page-head">
        <div class="page-title">Tours - <span>Bali Holiday Packages </span></div>
        <div class="breadcrumbs"> <a href="#">Home</a> / <a href="#">Tours Packages</a> / <span>Holiday Packages </span> </div>
        <div class="clear"></div>
      </div>
      <div class="two-colls">
        <div class="catalog-head fly-in">
          <label>Showing 10 of 55 - Bali Tour Package</label>
          <div class="clear"></div>
        </div>
        <div class="catalog-row"> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-1.jpg"></a></div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">An Awesome Bali Tour Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(4D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"></div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 4 Days & 3 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">170 reviews</div>
                        <div class="offer-slider-r"> <b>$154 / Rs. 9990</b> <span>(starting price per adult)</span></div>
                        <a class="cat-list-btn" href="#">View detail</a></div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-2.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Romantic Bali And Bali Honeymoon Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(3D) - Bali(3D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 6 Days & 5 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">240 reviews</div>
                        <div class="offer-slider-r"> <b>$ 198 / Rs. 12850</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-3.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Best Of Bali Holiday Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(3D) - Bali(2D) - Bali(3D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 6 Days/5 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">170 reviews</div>
                        <div class="offer-slider-r"> <b>$ 229 / Rs. 14850</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-4.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Adventurous Bali Family Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(4D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 4 Days & 3 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">70 reviews</div>
                        <div class="offer-slider-r"> <b>$ 202 / Rs.13150</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-5.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Magnificent Bali Family Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali </p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 5 Days & 4 Nights </div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">50 reviews</div>
                        <div class="offer-slider-r"> <b>$ 233 / Rs. 15150</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-6.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Rejuvenating Bali Tour Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(2D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 7 Days & 6 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">220 reviews</div>
                        <div class="offer-slider-r"> <b>$ 213 / Rs. 13810</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
          <!-- // -->
          
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-2.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Trendy Bali Tour Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(3D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 6 Days & 5 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">330 reviews</div>
                        <div class="offer-slider-r"> <b>$ 242 / Rs. 15700</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-5.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Best Of Bali Honeymoon Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 7 Days & 6 Nights </div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">400 reviews</div>
                        <div class="offer-slider-r"> <b>$ 230 / Rs.14900</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-4.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Bali Honeymoon Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali(3D)</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 6 Days & 5 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">40 reviews</div>
                        <div class="offer-slider-r"> <b>$ 236 / Rs. 15320</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          <div class="cat-list-item tour-item fly-in">
            <div class="cat-list-item-l"> <a href="#"><img alt="" src="images/bali-4.jpg"></a> </div>
            <div class="cat-list-item-r">
              <div class="cat-list-item-rb">
                <div class="cat-list-item-p">
                  <div class="cat-list-content">
                    <div class="cat-list-content-a">
                      <div class="cat-list-content-l">
                        <div class="cat-list-content-lb">
                          <div class="cat-list-content-lpadding">
                            <div class="tour-item-a">
                              <div class="tour-item-lbl"><a href="#">Short Bali Family Package</a></div>
                            </div>
                            <div class="tour-item-devider"></div>
                            <div class="tour-item-b">
                              <p>Bali</p>
                              <div class="tour-item-footer">
                                <div class="tour-i-holder">
                                  <div class="tour-item-icons"> <img alt="" src="images/tour-icon-01.png"> <span class="tour-item-plus"><img alt="" src="images/tour-icon.png"></span> <img alt="" src="images/tour-icon-02.png"> </div>
                                  <div class="tour-icon-txt">Meals + Sightseeing</div>
                                  <div class="clear"></div>
                                </div>
                                <div class="tour-duration">Duration : 5 Days & 4 Nights</div>
                                <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br class="clear">
                      </div>
                    </div>
                    <div class="cat-list-content-r">
                      <div class="cat-list-content-p">
                        <nav class="stars">
                          <ul>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-b.png" /></a></li>
                            <li><a href="#"><img alt="" src="images/star-a.png" /></a></li>
                          </ul>
                          <div class="clear"></div>
                        </nav>
                        <div class="cat-list-review">100 reviews</div>
                        <div class="offer-slider-r"> <b>$ 230 / Rs. 14940</b> <span>(starting price per adult)</span> </div>
                        <a class="cat-list-btn" href="#">View detail</a> </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <br class="clear">
            </div>
            <div class="clear"></div>
          </div>
          
          <!-- \\ --> 
          
        </div>
        <div class="clear"></div>
        <div class="pagination"> <a class="active" href="#">1</a> <a href="#">2</a> <a href="#">3</a>
          <div class="clear"></div>
        </div>
        <br class="clear" />
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>

<div id="result"></div>
<!-- /main-cont -->
<footer class="footer-b">
  <div class="wrapper-padding">
    <div class="footer-left">© Copyright 2017 by Goin' My Way. All rights reserved.</div>
    <div class="footer-social"> Bali Tour Package</div>
    <div class="clear"></div>
  </div>
</footer>
<!-- // scripts // --> 

<script src="js/jqeury.appear.js"></script>  
<script src="js/jquery.formstyler.js"></script> 
<script src="js/custom.select.js"></script> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script> 
<script type="text/javascript" src="js/twitterfeed.js"></script> 


<script type = "text/javascript" language = "javascript">
     $(document).ready(function() {
        $("#clickmeplanmyholidays").click(function(event){

          var country=$("#country").val();
          
          var exploredesti=$("exploredesti").val();
          var leavingForm=$("#leavingForm").val();
          var email=$('#email').val();
          var mobileNumber=$('#mobileNumber').val();
          var fixdate=$('#fixdate').val();
          var durationfilter=$('#durationfilter').val();

        if(email!=""){
           $('#emailvalidation').css('display','none');
           
         }else{
          $('#emailvalidation').css('display','block');
         }

         if(mobileNumber!=""){
           $('#phonenovalidation').css('display','none');
         }else{
          $('#phonenovalidation').css('display','block');
         }
         if(leavingForm!=""){
           $('#leaving').css('display','none');
         }else{
          $('#leaving').css('display','block');
         }

         if(durationfilter!=""){
           $('#durationvalidation').css('display','none');
         }else{
          $('#durationvalidation').css('display','block');
         }


          if(email!="" && mobileNumber!="" && durationfilter!="" && leavingForm!=""){
		  	
          $.ajax({
            url:"ajax_querydatasubmit.php",
           data:{country:country,exploredesti:exploredesti,leavingForm:leavingForm,fixdate:fixdate,email:email,mobileNumber:mobileNumber,durationfilter:durationfilter},
           type:'post',
          success:function(data)
           {
            alert(data);
           $("#result").html(data);
           }
          });
          $("#autorize-padding-first-block").hide('slow', function(){
           });
            $("#autorize-padding-second-block").show('slow', function(){
           });

            $('#leaving').css('display','none');
			      $('#phonenovalidation').css('display','none');
            $('#emailvalidation').css('display','none');
            $('#durationvalidation').css('display','none');
             

          }else{
            
            
          }




        });

        

        $("#cancelmovetofirst").click(function(event){

          
           $("#autorize-padding-first-block").show('slow', function(){
           });
            $("#autorize-padding-second-block").hide('slow', function(){
           });
       
          
        });
        
         $("#clickmethirdstep").click(function(event){



          var hotelstars=$('#hotelstars').val();
         
          if(hotelstars!=""){
           $("#autorize-padding-third-block").show('slow', function(){
           });
            $("#autorize-padding-second-block").hide('slow', function(){
           });
           }else{

            $('#ratingvalidation').css('display','block');
            }
        });
        
        $("#cancelmovetosecond").click(function(event){
           $("#autorize-padding-third-block").hide('slow', function(){
           });
            $("#autorize-padding-second-block").show('slow', function(){
           });
        });
        
        $("#submitfromdebox").click(function(event){

          var country=$("#country").val();
          var exploredesti=$("exploredesti").val();
          var leavingForm=$("#leavingForm").val();
          var fixdate=$("#fixdate").val();
          var flexibledate=$("#flexibledate").val();
          var anytimedate=$("#anytimedate").val();
          var email=$("#email").val();
          var mobileNumber=$("#mobileNumber").val();
          var hotelstars=$("#hotelstars5").val();
          var hotelstars=$("#hotelstars4").val();
          var hotelstars=$("#hotelstars3").val();
          var hotelstars=$("#hotelstars2").val();
          var hotelstars=$("#hotelstars1").val();
          var hotelstars=hotelstars;
          var flight_requirement=$("#flight_requirement").val();
          var budget=$("#budget").val();
          var adults=$("#adults").val();
          var infant=$("#infant").val();
          var children=$("#children").val();
          var iwillbook=$("#iwillbook").val();
          var flight_requirement_97=$("#flight_requirement_97").val();
          var tot=$("#tot").val();
          var yourmessage=$("#yourmessage").val();
          var durationfilter=$("#durationfilter").val();
          var bookmyticket=$("#bookmyticket").val();
		  var balitourid=$("#balitourid").val();


           $.ajax({
           url:"ajax_querydatasubmit.php",
           data:{country:country,exploredesti:exploredesti,leavingForm:leavingForm,fixdate:fixdate,flexibledate:flexibledate,anytimedate:anytimedate,email:email,mobileNumber:mobileNumber,hotelstars:hotelstars,flight_requirement:flight_requirement,budget:budget,adults:adults,infant:infant,children:children,iwillbook:iwillbook,flight_requirement_97:flight_requirement_97,tot:tot,yourmessage:yourmessage,durationfilter:durationfilter,bookmyticket:bookmyticket,balitourid:balitourid},
           type:'post',
          success:function(data)
           {
            
           $("#result").html(data);
           }
      });
          $("#autorize-padding-fourth-block").show('slow', function(){
           });
            $("#autorize-padding-third-block").hide('slow', function(){
           });
        });

        $("#gotopackage").click(function(event){
           window.location="http://www.goinmyway.co.in/thanks.html";
            
        });

        $("#fixdate").click(function(event){
           $("#bookmyticketshow").show();
            
        });


       

        
    
     });


 function emailvalidation123() {
           $('#emailvalidation').css('display','none');


                               }
function phonevalidation123() {
           $('#phonenovalidation').css('display','none');
                               }
function leavingFunct(){
           $('#leaving').css('display','none');
                               }
                              
    
</script>
<style>
.xbtn{position: absolute;
    left: 182px;
    cursor: pointer;
    padding: 4px 8px;
    background-color: rgb(83, 83, 83);
    border-radius: 3px;
    z-index: 11;
    margin-top: 5px;
    text-decoration: none;
    color: #fff;}
  
.popupdateinnernew ::placeholder {  
  color: red;
  opacity: 1;  
} 


.ui-datepicker-calendar td{ background-image:none; border: 0px !important; }
.side-block .ui-state-default, .side-block .ui-widget-content .ui-state-default, .side-block .ui-widget-header .ui-state-default, .side-block .ui-widget-header .ui-state-focus { 
    border: 0px solid #c2c5c8 !important; 
}

.ui-datepicker-calendar td:hover{ background-color:#fff !important; }
.ui-datepicker-calendar td a{    border-radius:0px !important;}


.ui-datepicker-calendar td a:hover{ background-color:#349BF3 !important; }

.side-block .ui-state-default, .side-block .ui-widget-content .ui-state-default, .side-block .ui-widget-header .ui-state-default, .side-block .ui-widget-header .ui-state-focus {
    background: #fff !important;     color: #000 !important;
}
</style>
<script>
$('.overlay').show();
</script>


</body>
</html>
