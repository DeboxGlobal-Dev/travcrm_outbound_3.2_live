<?php
include "../inc.php";
//$con = mysqli_connect('localhost', 'deboxglo_landing', 'admin@3214','deboxglo_landing') or die('Error in connection'); session_start(); ?>
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

        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
        
        <link rel="stylesheet" href="css/main.css" />
        <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
        
        <script src="../js/zebra_datepicker.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="css/form_responsive.css" />
        <!--balitourpackagesjs-->
        
        <script>
        $(document).ready(function(){
        /*  $("#fixdate").click(function(){
        $(".popup-date-inner").addClass('popupdateinnernew');
        $("#flexibledate").hide();
        $("#anytimedate").hide();
        $("#noofdayspopup").show();
        });*/
        });
        setInterval(function(){
        var fixdate=$('#fixdate').val();
        if(fixdate!=''){
        $('#resetbtndiv').show();
        $(".popup-date-inner").addClass('popupdateinnernew');
        $("#flexibledate").hide();
        $("#anytimedate").hide();
        $("#noofdayspopup").show();
            $("#bookmyticketshow").show();
        }
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
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        $(document).ready(function() {
        /* $('#fixdate').Zebra_DatePicker({
        direction:true,
        format: 'd-m-Y',
        autoClose: false,
        });
        $('#flexibledate').Zebra_DatePicker({
        direction:true,
        format: 'd-m-Y',
        autoClose: false,
        });
        */
        $('#fixdate').datepicker({
        minDate: 0,
            dateFormat: 'dd-mm-yy',
            autoclose: false
            });
        $('#flexibledate').datepicker({
        minDate: 0,
            dateFormat: 'dd-mm-yy',
                autoclose: false
        });
        
        
        });
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
        .autorize-popup{
/*            position: relative!important;*/

        }
/*        #autorize-padding-first-block{
            width: 660px;
            height: 680px;
            padding: 30px 70px;
            margin-right: 50px;
        }*/

/*        #maincard{
            position: absolute;
            left: 350px;
            top: 150px;
            width: 660px;
            height: 680px;
            padding: 30px 70px;
        }*/

    .card {
    width: 690px;
    height: 755px;
    padding: 30px 70px;
    margin-top: 160px;
    margin-bottom: 60px;
    margin-left: 350px;
    border: none !important;
    border-radius: 10px;
    opacity: 0.8;
    box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
}

    body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-image: url("images/TRAVCRM-Landing-Page-Get-Free-Quotes-BG.jpg");
    background-repeat: no-repeat;
    background-size: 100% 100%
}

#tripbudget::placeholder{
    font-size: 16px;
}


        </style>
    </head>
    <body>
        <!-- // authorize // -->
<!--         <div class="overlay"></div> -->
        <div class="card" id="maincard" style="border: 1px solid red;">
            <form name="frm_one" style="color: white;">
                <div class="autorize-padding" id="autorize-padding-first-block">
                    <div class="side-block fly-in" id="formright_1">
                        <div class="side-block-search">
                            <div class="page-search-p" style="padding-top:0;">
                                <div class="srch-tab-line">
                                    
                                    
                                    <div class="srch-tab" style="width: 225px;">
                                        <label for="leavingForm">From <span style="color:#ff0000;"> *</span><span id="fromval" style="color:#ff0000; display: none;font-size: 12px;" >Please Select From Destination</span></label>
                                        <div class="">
                                            <select id="fromDest" class="input-a" onChange="selectfromdest(this.value);">
                                                
                                                <option value="">Select Destination</option>
                                                <?php
                                                $a12='';
                                                $a12=GetPageRecord('*','destinationMaster',' deletestatus=0 and status=1 order by name asc');
                                                while($fromDestData=mysqli_fetch_array($a12)){
                                                ?>
                                                <option value="<?php echo $fromDestData['id']; ?>"><?php echo $fromDestData['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="date-icon"></span>
                                        </div>
                                    </div>
                                    

                                    <div class="srch-tab" style="width: 225px; margin-left: 30px;">
                                        <label for="toDest">Going to</label>
                                        <div class="">
                                            
                                            <select id="toDest" class="input-a">
                                                <option value="">Select Destination</option>
                                                <?php
                                                $a12='';
                                                $a12=GetPageRecord('*','destinationMaster',' deletestatus=0 and status=1 order by name asc');
                                                while($toDestData=mysqli_fetch_array($a12)){
                                                ?>
                                                <option value="<?php echo $toDestData['id']; ?>"><?php echo $toDestData['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    
                                    <script>
                                    function selectfromdest(id){
                                    $('#leavingForm').val(id);
                                    }
                                    </script>
                                    
                                    
                                    
                                    <div class="srch-tab">
                                        <input type="checkbox" id="exploredesti" name="exploredesti" value="1" style="margin: 0px;cursor: pointer;position: absolute;top: 4px;left:0px;">
                                        <label><span style="font-family: lato;font-size: 13px; position: relative;margin-left: 15px;font-weight: 500;text-transform: none;">I am exploring destinations</span></label>
                                        
                                    </div>
                                    
<!--                                     <div class="srch-tab">
                                        <label for="leavingForm">Leaving from<span style="color:#ff0000;"> *</span><span id="leaving" style="color:#ff0000; display: none;font-size: 12px;" >Please enter your Leaving from</span></label>
                                        <div class="">
                                            <select id="leavingForm" class="input-a">
                                                <option value="">Select Destination</option>
                                                <?php
                                                $a12='';
                                                $a12=GetPageRecord('*','destinationMaster',' deletestatus=0 and status=1 order by name asc');
                                                while($leavingFormData=mysqli_fetch_array($a12)){
                                                ?>
                                                <option value="<?php echo $leavingFormData['id']; ?>"><?php echo $leavingFormData['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="date-icon"></span>
                                        </div>
                                    </div> -->
                                    
                                    
                                    <div class="srch-tab">
                                        <label for="fixdate">Depature Date <span style="color:#ff0000;"> *</span><span id="choosedate"  style="color:#ff0000;display: none;font-size: 12px; ">(Choose any Date)</span></label>
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
                                            $("#anytimedate").val('Anytime');
                                            }
                                            </script>
                                            <a onClick="resetbuttons();$('#resetbtndiv').hide();$('.popup-date-inner').removeClass('popupdateinnernew');" id="resetbtndiv" style="display: none; " class="xbtn">x</a>
                                            <input type="text" id="fixdate" name="fixdate" class="popup-date-inner" autocomplete="off" placeholder="Fixed Date" value=""   readonly="" style="background-image: url('images/Fixed-date-button.png'); background-color: white; height: 30px;">
                                            <input type="text" id="flexibledate" name="flexibledate" class="popup-date-inner" autocomplete="off" placeholder="Flexible Date" value="" readonly="" onClick="$('#bookmyticketshow').hide();" style="background-image: url('images/Flexible-date-button.png'); background-color: white; height: 30px;">
                                            <input type="text" id="anytimedate" name="anytimedate" class="popup-date-inner" autocomplete="off" placeholder="Anytime" value=""  readonly="" onClick="$('#bookmyticketshow').hide(); anytime();" style="background-image: url('images/Anytime-button.png'); background-color: white; height: 30px;">
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
                                    
                                    <div class="srch-tab" style="margin-top: 10px; width: 130px; ">
                                    
                                    <label for="email" style="width: 150px;">Contact Information<span style="color:#ff0000;"> *</span></label>
                                    
                                    </div>

                                    <div class="srch-tab" style="margin-top: 10px; width: 160px;  margin-left: 15px;">
                                    <label style="width: 155px;" for="mobileNumber"><span style="color:#ff0000;"> &nbsp;</span><span id="phonenovalidation" style="color:#ff0000; display: none;font-size: 10px;" >Please enter your contact no</span></label>
                                    </div>

                                    <div class="srch-tab" style="margin-top: 10px; width: 160px;  margin-left: 10px;">
                                    <label style="width: 155px;" for="email"><span style="color:#ff0000;">&nbsp; </span><span id="emailvalidation" style="color:#ff0000; display: none;font-size: 10px;    " >Please enter your email address</span></label>
                                    </div>


                                    <div class="srch-tab" style=" width: 150px;">
                                        <div class="input-a">
                                            <input type="text" autocomplete="off" placeholder="Name" name="NameNN" id="namexx" >
                                            <span class="date-icon"></span>
                                        </div>
                                    </div>

                                    <div class="srch-tab" style=" width: 150px; margin-left: 10px;">
                                        <div class="input-a">
                                            <input type="text" autocomplete="off" placeholder="Mobile" name="mobileNumber" id="mobileNumber" pattern="\d{3}[\-]\d{3}[\-]\d{4}" onKeyUp="phonevalidation123();" >
                                            <span class="date-icon"></span>
                                        </div>
                                    </div>

                                    <div class="srch-tab" style="width: 150px; margin-left: 10px;">
                                        
                                        <div class="input-a">
                                            <input type="text" autocomplete="off" placeholder="Email" name="email" id="email" onKeyUp="emailvalidation123()"style="" >
                                            <span class="date-icon"></span>
                                        </div>
                                    </div>

                                    <div class="srch-tab" style="margin-top: 10px;">
                                        <label>Preferred Hotel Category (Rating)<span style="color:#ff0000;"> *</span><span id="ratingvalidation" style="color:#ff0000; display: none;font-size: 12px;" >Please select rating</span></label>
                                        <ul class="list-inline list-checkbox margin-bottom-25 margin-left-25 options">
                                            <li>
                                                <?php
                                                $a12='';
                                                $a12=GetPageRecord('*','balitourpackage_tourpackage_query',' 1 order by id desc limit 0,1');
                                                $rest656=mysqli_fetch_array($a12);
                                                $balitourid=$rest656['id']+1;
                                                ?>
                                                <input type="checkbox" name="hotelstars5" id="hotelstars5" value="5">
                                                <input type="hidden" name="balitourid" id="balitourid" value="<?php echo $balitourid; ?>">
                                                <label><b style="font-size: 16px;">&nbsp;&nbsp;5 Star</b></label>
                                                <div class="sea-green text-center line-height-5"><small></small></div>
                                            </li>
                                            
                                            <li>
                                                <input type="checkbox" name="hotelstars4" id="hotelstars4" value="4" style="margin-left: 30px;">
                                                <label ><b style="font-size: 16px;">&nbsp;&nbsp;4 Star</b></label>
                                                <div class="sea-green text-center line-height-2"><small></small></div>
                                            </li>
                                            
                                            <li>
                                                <input type="checkbox" name="hotelstars3"  id="hotelstars3"value="3" style="margin-left: 30px;">
                                                <label><b style="font-size: 16px;">&nbsp;&nbsp;3 Star</b></label>
                                                <div class="sea-green text-center line-height-2"><small></small></div>
                                            </li>
                                            
<!--                                             <li>
                                                <input type="checkbox" name="hotelstars2" id="hotelstars2"value="2">
                                                <label for="hotel_catagory_2 Star">2 Star</label>
                                                <div class="sea-green text-center line-height-2"><small></small>
                                                </div></li> -->
                                                
                                                <li>
                                                    <input type="checkbox" name="hotelstars1" id="hotelstars1" value="1" style="margin-left: 30px;">
                                                    <label><b style="font-size: 16px;">&nbsp;&nbsp;Any</b></label>
                                                </li>
                                                
                                            </ul>
                                        </div>





                                    <div class="srch-tab" style="margin-top: 10px; width: 220px;" >
                                        <label>Do You Need Flight?</label>
                                        <ul class="list-inline list-checkbox margin-bottom-25 margin-left-25 options">

                                            <li><input class="" type="radio" name="flight_requirement" value="97" id="flight_requirement_97" onChange="addAirfarefun(this);" >&nbsp;&nbsp;<label for="flight_requirement_97"><b>Yes</b>&nbsp;
                                            <img src="images/flight-yes.png" id="flightyes" width="35">  
                                            </label>   
                                            </li>
                                            <li style="margin-left: 15px;"><input class="" type="radio" name="flight_requirement" value="98" id="flight_requirement_98" onChange="addAirfarefun(this);">&nbsp;&nbsp;<label for="flight_requirement_98"><b>No</b>&nbsp;
                                             <img src="images/flight-no.png" id="flightyes" width="35">
                                            </label>


                                        </ul>
                                    </div>

                                 <script>
                                function addAirfarefun(getid){
                                var id = $(getid).attr('id');
                                if(id=='flight_requirement_97'){
                                $('#airfare').text('Expected Budget With Airfare - ');
                                }
                                            if(id=='flight_requirement_98'){
                                $('#airfare').text('Expected Budget Without Airfare - ');
                                }
                                
                                }
                                            
                                </script>
                                    

                                    <div class="srch-tab" style="width: 230px; margin-left: 30px;">
                                        <label for="toDest">Trip Budgest</label>
                                        <div class="">
                                            
                                        <input id="tripbudget" class="input-a" type="text" autocomplete="off" placeholder="In INR" name="budget" id="budget" style="height: 35px;">
                                            
                                        </div>
                                    </div>



                                    <div class="srch-tab" style="margin-top: 10px;">
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




                                    <div class="srch-tab" style="width: 160px; margin-top: 10px;">
                                    <label>Type of Trip you want?</label>
                                    <div class="no-of-childs-block-combo" style="width:103% !important;margin-bottom: 15px;">
                                        <select class="input-a" name="tot" id="tot" style="box-shadow: none;color: #4f4f4f; border-radius: 2px;border-color: #b2b2b2;height: 34px;font-size: 13px;">
                                            <option value="" disabled="">Type of tour</option>
                                            <option value="1">Honeymoon</option>
                                            <option value="2">Family</option>
                                            <option value="3">Adventure</option>
                                            <option value="4">Offbeat</option>
                                            <option value="5">Wildlife</option>
                                            <option value="6">Religious</option>
                                        </select>
                                    </div>
                                    </div>

                                    <div class="srch-tab" style="margin-left: 30px; width: 290px; margin-top: 10px;">
                                        <label>Other Information</label>
                                        <div class="">
                                            <input id="tripbudget" class="input-a" type="text" autocomplete="off" placeholder="* Planning to final in week time" name="yourmessage" id="yourmessage" style="height: 35px;">    
                                            <span class="date-icon"></span>
                                        </div>
                                    </div>






                                    <div class="popup-first-button">
                                        <input type="button" class="popup-first-plan-button" id="clickmeplanmyholidays" name="clickmeplanmyholidays" value="Plan my Holidays" style="cursor:pointer;">

<!--                                         <input type="button" class="popup-first-plan-button2" id="submitfromdebox" value="Submit"> -->

                                        <div style="color: #555;width: 100%; text-align: center; margin-top: 6px; font-family: lato;font-size: 13px;font-weight: 400;">Your information will be kept confidential</div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
               <!--  <div class="autorize-padding" id="autorize-padding-second-block" style="display:none;">
                    <h6 class="autorize-lbl debox_autorize-lbl" id="pop-title">Great! Tell Us What You Prefer</h6>
                    <div class="side-block fly-in" id="formright_1">
                        <div class="side-block-search">
                            <div class="page-search-p" style="padding-top:0;">
                                <div class="srch-tab-line">
                                    
                                    
                                        
                                 
                                
                                
                                
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
                                                <input class="option ng-pristine ng-untouched ng-valid" type="radio" name="sightseeing_requirement" value="97" ng-change="handleAction('flight_requirement', '97','Yes')" id="sightseeing_requirement_97" ng-model="cust_23">
                                                <label for="sightseeing_requirement_97">Yes</label>
                                            </li>
                                            <li>
                                                <input class="option ng-pristine ng-untouched ng-valid" type="radio" name="sightseeing_requirement" value="98" ng-change="handleAction('flight_requirement', '98','No')" id="sightseeing_requirement_98" ng-model="cust_23">
                                                <label for="sightseeing_requirement_98">No</label>
                                            </li>
                                        </ul>
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
            </div> -->
            
            <div class="autorize-padding" id="autorize-padding-fourth-block" style="display:none;">
                
                <div style="width: 40%;margin: auto;"><img src="images/thanksmsg.png" alt="Thnaks messge for query" style="width:100%;height:auto;"></div>
                
                <h4 style="width: 100%;text-align: center;font-family: lato;font-size: 15px;font-weight: 500;text-decoration: underline;color: #34a4ca;">Dear Guest, Thanks you for your interest !</h4>
                <p style="width: 90%;margin: auto;text-align: justify;font-family: lato;font-size: 13px;color: #333;font-weight: 400;">Our Sales representative will be in touch with you shortly!!!. Don't Forget to check your inbox in next 24 Hrs, We are committed to reply your request within that time. </p>
                <div class="side-block fly-in" id="formright_1">
                    <div class="side-block-search">
                        <div class="page-search-p" style="padding-top:0;">
                            <div class="srch-tab-line">
                                
                                <div class="popup-first-button">
                                    <input type="button" class="popup-first-plan-button" id="gotopackage" value="Go To Home" onClick="window.location.href='//www.deboxglobal.com/landing_page/';">
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








    
<!--     <header id="top">
        <div class="header-b">
            <div class="wrapper-padding">
                <div class="header-logo"><a href="index.html"><img alt="" src="images/deboxlogo.png" /></a></div>
                <div class="header-right"> <a href="#" class="menu-btn"></a>
                    <nav class="header-nav"></nav>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </header> -->
<script src="js/jqeury.appear.js"></script>
<script src="js/jquery.formstyler.js"></script>
<script src="js/custom.select.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/twitterfeed.js"></script>
<script type = "text/javascript" language = "javascript">
    $(document).ready(function() {
        $("#clickmeplanmyholidays").click(function(event){
            var error_toDest=true;
            var error_exploredesti=true;
            var error_leavingForm=true;
            var error_email=true;
            var error_mobileNumber=true;
            var error_fixdate=true;
            var error_flexibledate=true;
            var error_anytimedate=true;
            var error_durationfilter=true;

            var toDest=$("#toDest").val();
            var exploredesti=($('#exploredesti').is(":checked"));
            var leavingForm=$("#leavingForm").val();
            var email=$('#email').val();
            var mobileNumber=$('#mobileNumber').val();
            var fixdate=$('#fixdate').val();
            var flexibledate=$('#flexibledate').val();
            var anytimedate=$('#anytimedate').val();
            var durationfilter=$('#durationfilter').val();
            var fromDest=$('#fromDest').val();
            var nameNN= $('#namexx').val();
            var bookmyticket=($('#bookmyticket').is(":checked"));
            if(fixdate!="" || flexibledate!="" ||anytimedate!=''){
                $('#choosedate').css('display','none');
                error_fixdate = true;
            } else{
                error_fixdate = false;
                $('#choosedate').css('display','inline-block');
            }
            if(email!=""){
                if(IsEmail(email)==false){
                    $('#emailvalidation').css('display','inline-block');
                    $('#emailvalidation').text('Please enter valid email.');
                    error_email = false;
                }else{
                    $('#emailvalidation').css('display','none');
                    error_email = true;
                }
                function IsEmail(email) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(email)) {
                        return  false;
                    }else{
                        return  true;
                    }
                }
            }else{
                $('#emailvalidation').css('display','inline-block');
                error_email = false;
            }
            if(mobileNumber!=""){
                if(validateMobile(mobileNumber)==false){
                    $('#phonenovalidation').css('display','inline-block');
                    error_mobileNumber = false;
                }else{
                    $('#phonenovalidation').css('display','none');
                    error_mobileNumber= true;
                }
                function validateMobile(mobileNumber) {
                    //alert(mobileNumber);
                    if (mobileNumber == "") {
                        $('#phonenovalidation').text("Please Enter Mobile Number");
                        $('#mobileNumber').focus();
                        return false;
                    }


                    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
                    if (filter.test(mobileNumber)) {
                        if(mobileNumber.length <= 15 && mobileNumber.length > 6 ){
                            return true;
                        } else {
                            $('#phonenovalidation').text("Please Enter 7 to 15 digit Phone Number");
                            $('#mobileNumber').focus();
                            return false;
                        }
                    }
                    else {
                        $('#phonenovalidation').text("Please enter Correct Phone Number");
                        $('#mobileNumber').value = "";
                        $('#mobileNumber').focus();
                        return false;
                    }
                }

            }else{
                $('#phonenovalidation').css('display','inline-block');
                error_mobileNumber=false
            }

            //leaving form validation
            if(leavingForm!=""){
                $('#leaving').css('display','none');
                error_leavingForm  = true;
                }else{
                $('#leaving').css('display','inline-block');
                error_leavingForm = false;
            }

            if(fromDest!=""){
                $('#fromval').css('display','none');
                error_leavingForm  = true;
            }else{
                $('#fromval').css('display','inline-block');
                error_leavingForm = false;
            }
            if(durationfilter!=""){
                $('#durationvalidation').css('display','none');
                error_durationfilter = true;
            }else{
                $('#durationvalidation').css('display','inline-block');
                error_durationfilter = false;
            }

            // check that all error variables are true than call ajax

            if(error_toDest == true && error_exploredesti == true && error_leavingForm == true && error_email == true && error_mobileNumber == true && error_fixdate == true && error_durationfilter == true && error_durationfilter == true){

                $.ajax({
                    url:"ajax_querydatasubmit.php",
                    data:{toDest:toDest,exploredesti:exploredesti,bookmyticket:bookmyticket,leavingForm:leavingForm,fixdate:fixdate,flexibledate:flexibledate,anytimedate:anytimedate,email:email,mobileNumber:mobileNumber,durationfilter:durationfilter,fromDest:fromDest,nameNN:nameNN},
                    type:'post',
                    success:function(data){
                        $("#result").html(data);
                    }
                });


                // show hide code
                $("#autorize-padding-first-block").hide('slow');
                $("#autorize-padding-second-block").show('slow');
                $('#leaving').css('display','none');
                $('#phonenovalidation').css('display','none');
                $('#emailvalidation').css('display','none');
                $('#durationvalidation').css('display','none');
                $("#autorize-padding-fourth-block").show('slow');
                

            }else{

            }


            if(checkval==0){
                $('#ratingvalidation').css('display','inline-block');
                return false;
            } else {
                $('#ratingvalidation').css('display','none');
            }

            if(checkval==1){
                $("#autorize-padding-third-block").show('slow', function(){
                });
                $("#autorize-padding-second-block").hide('slow', function(){
                });
            }else{
                $('#ratingvalidation').css('display','block');
            }





        });

        $("#cancelmovetofirst").click(function(event){
            $("#autorize-padding-first-block").show('slow', function(){
            });
            $("#autorize-padding-second-block").hide('slow', function(){
            });
        });


        $("#clickmethirdstep").click(function(event){

            var hotelstars5 = ($('#hotelstars5').is(":checked"));
            var hotelstars4 = ($('#hotelstars4').is(":checked"));
            var hotelstars3 = ($('#hotelstars3').is(":checked"));
            var hotelstars2 = ($('#hotelstars2').is(":checked"));
            var hotelstars1 = ($('#hotelstars1').is(":checked"));
            var checkval=0;


            if(hotelstars5!='' || hotelstars4!='' || hotelstars3!='' || hotelstars2!='' || hotelstars1!=''){
                checkval=1;
            }


            if(checkval==0){
                $('#ratingvalidation').css('display','inline-block');
                return false;
            } else {
                $('#ratingvalidation').css('display','none');
            }

            if(checkval==1){
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
            var fromDest=$("#fromDest").val();
            console.log(fromDest);
            var exploredesti=($('#exploredesti').is(":checked"));
            var leavingForm=$("#leavingForm").val();
            var email=$('#email').val();
            var mobileNumber=$('#mobileNumber').val();
            var fixdate=$('#fixdate').val();
            var flexibledate=$('#flexibledate').val();
            var anytimedate=$('#anytimedate').val();
            var durationfilter=$('#durationfilter').val();
            var bookmyticket=($('#bookmyticket').is(":checked"));
            var hotelstars5 = ($('#hotelstars5').is(":checked"));
            var hotelstars4 = ($('#hotelstars4').is(":checked"));
            var hotelstars3 = ($('#hotelstars3').is(":checked"));
            var hotelstars2 = ($('#hotelstars2').is(":checked"));
            var hotelstars1 = ($('#hotelstars1').is(":checked"));

            var flight_requirement = $("input[name='flight_requirement']:checked").val();
            var budget=$("#budget").val();
            var adults=$("#adults").val();
            var infant=$("#infant").val();
            var children=$("#children").val();
            var iwillbook=$("#iwillbook").val();

            var flight_requirement_97=$("input[name='sightseeing_requirement']:checked").val();
            var tot=$("#tot").val();
            var content=$("#yourmessage").val();
            var yourmessage = content.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            var balitourid=$("#balitourid").val();
            $.ajax({
                url:"ajax_querydatasubmit.php",
                data:{fromDest:fromDest,exploredesti:exploredesti,leavingForm:leavingForm,fixdate:fixdate,flexibledate:flexibledate,anytimedate:anytimedate,email:email,mobileNumber:mobileNumber,hotelstars5:hotelstars5,hotelstars4:hotelstars4,hotelstars3:hotelstars3,hotelstars2:hotelstars2,hotelstars1:hotelstars1,flight_requirement:flight_requirement,budget:budget,adults:adults,infant:infant,children:children,iwillbook:iwillbook,flight_requirement_97:flight_requirement_97,tot:tot,yourmessage:yourmessage,durationfilter:durationfilter,bookmyticket:bookmyticket,balitourid:balitourid},
                type:'post',
                success:function(data)
                {
                    $("#result").html(data);
                }
            });


            //$('#autorize-padding-fourth-block').html('<div style="text-align:center; padding:30px;">Submiting Query <br><br> Wait Please...</div>');


            $("#autorize-padding-fourth-block").show('slow', function(){
            });

            $("#autorize-padding-third-block").hide('slow', function(){
            }); 

        });



        $("#gotopackage").click(function(event){
        //
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
/*.xbtn{position: absolute;
left: 182px;
cursor: pointer;
padding: 4px 8px;
background-color: rgb(83, 83, 83);
border-radius: 3px;
z-index: 11;
margin-top: 5px;
text-decoration: none;
color: #fff;}*/

.popupdateinnernew ::placeholder {
color: red;
opacity: 1;
}

.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
padding: 6px !important;
text-align: center;
}
.personcost{
font-size: 12px;
font-weight: 400;
display:inline-block;
}
</style>
<script>
$('.overlay').show();
</script>
</body>
</html>