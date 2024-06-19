<link href="css/select2.min.css" rel="stylesheet" type="text/css" />
<style>
a{text-decoration:none !important;outline:none !important;}
</style>

<div class="validationblackshade"  id="alertvalidation"><div class="alertbox">

 <div class="header" id="alertvalidationheader"></div>

 <div class="content" id="alertvalidationcontent" style="padding-bottom:10px;">

 

 </div><div style="padding:0px 0px 30px 0px; text-align:center;"><input type="button" name="button" value="OK" class="darkredbutton" style="margin-left:0px; position:inline-block; float:none;    width: 70px;" onclick="closeanydiv('alertvalidation');"  /></div>

 </div></div>
 
 
 
 <div id="alertnotificationsmainbox" style="display:none; background-image:url(images/bgpop.png); background-repeat:repeat;">
 <div id="alertswhitebox"> 
 </div> 
 </div> 
 <script>
$(document).ready(function() {
// $("#menudropdown,#menudropdownadd,#outerscroll,#rolelistscroll,#notificationbox").niceScroll({cursorborder:"",cursorcolor:"#bebebe",boxzoom:true});  
// $("#body").niceScroll({cursorborder:"",cursorcolor:"#00F",boxzoom:true});  
});
</script>

<iframe id="actoinfrm" name="actoinfrm" src="" style="display:none;"></iframe>


 

<div id="pageloading"></div>
<div id="pageloader"><div id="loaderbox">Please Wait...</div></div>

<div id="actiondiv" style="display:none;"></div>



<?php if($_REQUEST['alt']==1 || $_REQUEST['alt']==2  || $_REQUEST['alt']==3){ ?>

    <div class="truefaulsmsgouter" id="truflsmsg">
    <div class="truefaulsmsg">
        <table width="100%" border="0" align="center" cellpadding="7" cellspacing="0">
        <tr>
        <td width="3%" align="center" bgcolor="#3cb08b"><img src="images/check-circle-outline-32.png" width="32" height="32" /></td>
        <td width="97%" align="left"><?php if($_REQUEST['alt']==1){ echo 'Successfully Added'; } if($_REQUEST['alt']==2){ echo 'Successfully Updated'; } if($_REQUEST['alt']==3){ echo 'Operation Canceled'; } ?></td>
        </tr> 
        </table>
    </div>
    </div>
    <script>
    donesavingalt();
    setTimeout(function() {   //calls click event after a certain time
      donesavingaltgo()
    }, 2000);


    </script>


<?php } ?>
<?php if($_REQUEST['alt']==4){ ?>

    <div class="truefaulsmsgouter" id="truflsmsg">
    <div class="truefaulsmsg" style="background-color:#a50e0e;">
        <table width="100%" border="0" align="center" cellpadding="7" cellspacing="0">
        <tr>
        <td width="3%" align="center"><img src="images/check-circle-outline-32.png" width="32" height="32" /></td>
        <td width="97%" align="left"><?php  echo 'Failed - Duplicate Entry';  ?></td>
        </tr> 
        </table>
    </div>
    </div>
    <script>
    donesavingalt();
    setTimeout(function() {   //calls click event after a certain time
      donesavingaltgo()
    }, 2000);


    </script>


<?php } ?>


<style>

.btn-group-custom button {
border-radius: 0px !important;
width: auto;
height: auto;
background-color: #ffffff !important; 
margin-right: 24px;
border: 0px;
box-shadow: 0px 0px 0px #fff !important;
font-size: 28px;
padding: 0px;
}
.btn-group>.btn-group:not(:first-child)>.btn, .btn-group>.btn:not(:first-child) { 
background-color: #fff !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
color: #fff !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice{ 
border: 1px solid #007bff !important;
}
.select2-container--default .select2-selection--multiple{
padding-bottom: 4px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #2489c5 !important;
	color: #fff !important;
}
body{ height:100% !important; overflow:	auto;}
html{ height:100% !important; }
 
/*#headerstrip {*/
/*    background-color: #233a49 !important;*/
/*	    border-bottom: transparent !important;*/
/*}*/

/*#headerstrip #navigationleft .active {*/
/*    background-color: #00000075 !important;*/
/*}*/


#alertnotificationsmainbox { 
    z-index: 9999 !important; 
}
</style>

<div style="position:fixed; margin-top:51px; height:5px; background-color:#d0d0d0; z-index:9995; left:0px; top:0px; width:100%;  " id="topbarloadingdiv"><div style="width:0%; background-color:#<?php echo $loginColortwo;?>; height:5px; float:left;"></div></div>

<script type="text/javascript"> 
$(function() {
	$('a').click(function() {
	$('#topbarloadingdiv').show();
	$('#topbarloadingdiv div').css('width','0%');
	  $('#topbarloadingdiv div').animate({width: "100%"}, 1500 ); 
	});
});
$('#topbarloadingdiv div').animate({width: "100%"}, 500 ); 
 
   
</script>
<style>
.Zebra_DatePicker.dp_visible { 
    z-index: 99999999 !important;
}

.select2-container--default .select2-selection--multiple {
    background-color: white;
    border: 1px solid #d8d8d8 !important;
    border-radius: 0px;
    cursor: text;
    margin-top: 5px !important;
    min-height: 35px !important;
}

.queryleft .innerdiv .contentbox { 
    font-size: 12px !important; 
}




.Zebra_DatePicker { 
    background: #fff !important;
    border: 0px solid #fff !important; 
    box-shadow: 2px 2px 26px #0000005e !important;
}

.Zebra_DatePicker .dp_header td { 
    padding: 10px !important;
    color:#4f4f4f !important;
}
.Zebra_DatePicker .dp_header .dp_hover {
    background: #fff !important; 
}

.Zebra_DatePicker.dp_visible { 
    width:290px !important;
}
.dp_header{width:100% !important;}
.dp_daypicker{width:100% !important;}
.Zebra_DatePicker .dp_daypicker td{
     border: 0px solid #ffffff !important;
    padding: 13px 7px!important;
    border-radius: 100%;
    margin: 4px;
}
.Zebra_DatePicker .dp_daypicker td{
     border: 0px solid #ffffff !important;
    padding: 13px 7px!important;
    border-radius: 100%;
    margin: 4px;
        background-color: #fff;
}
.dp_daypicker tr td{padding:5px;}
.Zebra_DatePicker .dp_daypicker, .Zebra_DatePicker .dp_monthpicker, .Zebra_DatePicker .dp_yearpicker { 
    margin: 5px !important;
}
.Zebra_DatePicker .dp_daypicker{
    width: 281px !important;
}
.Zebra_DatePicker .dp_daypicker th { 
    border: 0px !important;background: #ffffff !important;
}
.dp_selected{background-color: #4CAF50 !important;} 
.dp_hover{background-color: #233a49cf !important;} 
.dp_current{color: #000 !important;background-color: #e5e5e5 !important;} 
.Zebra_DatePicker .dp_footer { 
    width: 291px !important;
}
.dp_today{    padding: 10px !important;
    border-radius: 0px !important;
    background-color: #233a49 !important;    padding: 10px !important;
    border-radius: 0px !important;}
    
.dp_clear{    padding: 10px !important;
    border-radius: 0px !important;
    background-color: #b11111 !important;    padding: 10px !important;
    border-radius: 0px !important;}
        
.Zebra_DatePicker.dp_visible { 
    overflow: hidden;
}
 
.listdmcouter .dmclistbox {
    border-right: 1px solid #e6e6e6;
    padding: 20px 23px 20px 10px;
    width: 14%;
    float: left;
    padding-top: 0px;
    min-height: 470px;
}

.listdmcanch a {
    font-size: 13px;
}
/*.addtopaboxlist{
	position: absolute;
    top: -34px;
    width: 30%;
    right: 54px;
}

always make a unique class and then use 
please dont change predefined classes
*/

 
</style>