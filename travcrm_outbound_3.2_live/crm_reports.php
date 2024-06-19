
<!doctype html>
<html lang="en">
  <head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" /> -->

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>plugins/font-awesome/css/font-awesome.min.css"> -->
  </head>
  <body>
	  
<?php

// error_reporting(1);
// error_reporting(E_ALL);
// error_log('all eror ');
?>
<style>
	.headerClass tr th{
		color:#fff !important;
	}
	.fg-button{
		background: #cccccc;
		border-radius: 3px;
		color: #000000 !important;
    	font-weight: 500;
	}
	.cms_title{
		padding-left:75px !important;
	}

.dt-buttons{
	width: 330px;
	margin: 30px auto;
}
		.buttons-html5 {
		padding: 8px 20px 8px 15px;
		border-radius: 50px;
		cursor: pointer;
		font-size: 15px;
    	font-weight: 600;
		margin-right: 13px;
	}

	.buttons-html5:hover {
		background-color: #b8b8bb !important;
	}
	.buttons-copy::before {
		font-family: 'Font Awesome 5 Free';
		content: "\f0c5";
		font-weight: 900;
		padding-right: 6px;
	}

	.buttons-excel::before {
		font-family: 'Font Awesome 5 Free';
		content: "\f019";
		font-weight: 900;
		padding-right: 6px;
	}

	.buttons-pdf::before {
		font-family: 'Font Awesome 5 Free';
		content: "\f1c1";
		font-weight: 900;
		padding-right: 6px;
	}

.cmsouter{
text-align:center; 
overflow:hidden;  
}
.cmsouter .iconbox {
display: inline-block;
text-align: center;
padding: 10px;
min-width: 150px;
width: 19%;
margin: 15px;
border: 0px #4caf50 solid;
border-radius: 5px;
background-color: #233a49;
box-shadow: 2px 2px 18px -1px #4caf50;
color: white;
}
.cmsouter .iconbox img{
height: 60px;
padding: 10px 0;
float: left;
}
.container_box .rightBox . {
background-color: #f8f8f8;
border-bottom: 1px solid #eee;
padding: 15px 25px 15px 36px!important;
font-weight: 500;
color: #333333;
font-size: 22px;
margin-top: 0;
position: relative!important;
width: auto;
z-index: 999;
}
.container_box #pagelisterouter .addeditpagebox{
padding: 0px!important;
}
.container_box .rightBox .headingm {
text-align: left!important;
margin: 0!important;
padding:0!important;
}
.container_box .rightBox #topheadingmain a img{
margin-right: 15px!important;
margin-bottom: -3px!important;
margin-left: 25px!important;
}
#pagelisterouter{
padding-left: 0!important;
margin-left: 25px;
padding-top: 25px;
}
.cmsouter .iconbox:hover{ 
background-color:#fcffe1;
}
.cmsouter .iconbox:hover .text{
color:#0066CC; 
}
.cmsouter .text{
margin-top:10px;
font-size:16px;
text-align:right;
padding-right: 15px;
color:#ffffff;
text-decoration:none;
}
.container_box{
padding-top: 56px;
width: 100%;
display: block;
overflow: hidden;
}
.container_box .leftBox{
float: left;
width: 20%;
display: inline-block;
height: 90%;
margin-left: -5px;
border-right: 5px solid #4caf50;
position: fixed;
	top: 56px;
	left:0;
	overflow:scroll;
	/* margin-bottom: 50px; */
}

.container_box .leftBox .iconbox{
text-align: left;
padding: 6px 10px 8px 35px;
min-width: 100%;
width: 100%;
border-bottom: 2px #c5bfbf solid;
border-radius: 0px;
background-color: #233a49;
display: table;
}
.container_box .leftBox .iconbox .text{
display: inline-flex;
vertical-align: middle;
padding-left: 15px;
color: white;
font-size: 14px;
font-family: 'Roboto', sans-serif;
}
.container_box .leftBox .iconbox img{
height: auto;
width: 30px;
display: inline-flex;
vertical-align: middle;
}
.container_box .leftBox .iconbox:hover{ 
background-color:#ffffff;
}
.container_box .leftBox .iconbox:hover .text{
color: #233a49;
font-weight: 600;
}
.container_box .rightBox{
float: right;
display: inline-block;
width: 80%;
}
.container_box  .cms_title{
margin: 0 0px;
text-align: left;
padding: 15px;
padding-left: 3%;
font-size: 25px;
color: #233a49;
text-shadow: 1px 1px 2px white;
box-shadow: 1px 1px 13px -3px #4caf50;
background-color: #f2f2f287;
margin-bottom: 15px;
}
.ExploreLogo{
background-color: #233a49!important;
margin-bottom: 0px!important;
padding: 12px!important;
padding-left: 8%!important;
}
.container_box .cmsouter #pagelisterouter{
padding: 3%!important;
padding-top: 0%!important;
margin: 0!important;
}
.container_box .leftBox .active { 
background-color:#fcffe1!important;
}
.container_box .leftBox .active .text{
color:#0066CC!important; 
}
.style1 {color: #f41f06}
</style>
<div class="container_box">
<div class="leftBox">
<h3 class="cms_title ExploreLogo"></h3>
<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=38"><div class="iconbox <?php if($_REQUEST['report']==38){?> active <?php } ?>"><img src="images/cms-pack-enq.png" alt="test" /><div class="text">Agent Turnover Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=2"><div class="iconbox <?php if($_REQUEST['report']==2){?> active <?php } ?>"><img src="images/agent-icon.gif" /><div class="text">Agent Wise Query Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y',strtotime('today'));?>&toDate=<?php echo date('d-m-Y', strtotime('+15 day'));?>&module=reports&report=62&eventType=1"><div class="iconbox <?php if($_REQUEST['report']==62){?> active <?php } ?>"><img src="images/agent-icon.gif" /><div class="text" style="display: inline;padding-left:5px;">Birthday & Anniversary Reminder Report</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=25"><div class="iconbox <?php if($_REQUEST['report']==25){?> active <?php } ?>"><img src="images/cms-pack-enq.png" /><div class="text">City Wise Booking Report</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=5"><div class="iconbox <?php if($_REQUEST['report']==5){?> active <?php } ?>"><img src="images/cms-social.png" /><div class="text">Client Payment Pending  Report</div></div></a> -->

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=3"><div class="iconbox <?php if($_REQUEST['report']==3){?> active <?php } ?>"><img src="images/icon_client_31.jpg" /><div class="text">Client Wise Query</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=42"><div class="iconbox <?php if($_REQUEST['report']==42){?> active <?php } ?>"><img src="images/user_group.png" /><div class="text">comparison YTY</div></div></a> -->
<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=21"><div class="iconbox <?php if($_REQUEST['report']==21){?> active <?php } ?>"><img src="images/cms-social.png" /><div class="text">Daily&nbsp;Movement Chart Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=22"><div class="iconbox <?php if($_REQUEST['report']==22){?> active <?php } ?>"><img src="images/th.jpg" /><div class="text">Driver Allocation Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=14"><div class="iconbox <?php if($_REQUEST['report']==14){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Feedback&nbsp;Report&nbsp;Mobile</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=61"><div class="iconbox <?php if($_REQUEST['report']==61){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Feedback&nbsp;Report&nbsp;Online</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=41"><div class="iconbox <?php if($_REQUEST['report']==41){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">File&nbsp;Wise&nbsp;Liability&nbsp;Report</div></div></a> -->

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=45"><div class="iconbox <?php if($_REQUEST['report']==45){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Fixed&nbsp;Departure&nbsp;Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=47" ><div class="iconbox <?php if($_REQUEST['report']==47){?> active <?php } ?>"><img src="images/cms-contactenq.png" /><div class="text">Guest List Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=23" ><div class="iconbox <?php if($_REQUEST['report']==23){?> active <?php } ?>"><img src="images/cms-contactenq.png" /><div class="text">Guide Allocation Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=24"><div class="iconbox <?php if($_REQUEST['report']==24){?> active <?php } ?>"><img src="images/th22.jpg" /><div class="text">Hotel Booking Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=26"><div class="iconbox <?php if($_REQUEST['report']==26){?> active <?php } ?>"><img src="images/cms-subscribers.png" /><div class="text">Hotel Chain Report</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=32"><div class="iconbox <?php if($_REQUEST['report']==32){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Hotel&nbsp;Detail&nbsp;Report</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=39"><div class="iconbox <?php if($_REQUEST['report']==39){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Hotel&nbsp;Room&nbsp;Night&nbsp;Analysis&nbsp;Report</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=36"><div class="iconbox <?php if($_REQUEST['report']==36){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Hotel Room Night Analysis - Summary</div></div></a> -->

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=37"><div class="iconbox <?php if($_REQUEST['report']==37){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Hotel Wait List Report</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=35"><div class="iconbox <?php if($_REQUEST['report']==35){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Incoming&nbsp;Tour&nbsp;Status&nbsp;Report</div></div></a> -->

<a href="showpage.crm?fromDate=<?php echo date('01-m-Y');?>&toDate=<?php echo date('d-m-Y');?>&module=reports&report=67"><div class="iconbox <?php if($_REQUEST['report']==67){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Insurance Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&module=reports&report=13"><div class="iconbox <?php if($_REQUEST['report']==13){?> active <?php } ?>"><img src="images/cms-mice.png" /><div class="text">Login Report</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y')));?>&toDate=<?php echo date('d-m-Y', strtotime('today'));?>&companyType=1&module=reports&report=63"><div class="iconbox <?php if($_REQUEST['report']==63){?> active <?php } ?>"><img src="images/cms-mice.png" /><div class="text">News Letter Report</div></div></a> -->

<a href="showpage.crm?fromDate=<?php echo date('01-m-Y');?>&toDate=<?php echo date('d-m-Y');?>&module=reports&report=66"><div class="iconbox <?php if($_REQUEST['report']==66){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Passport Report</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=33"><div class="iconbox <?php if($_REQUEST['report']==33){?> active <?php } ?>"><img style="display: inline;" src="images/th3333s.jpg" /><div class="text" style="display:inline;padding-left: 10px;">Room&nbsp;Night&nbsp;Analysis&nbsp;From&nbsp;Itinerary</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=43"><div class="iconbox <?php if($_REQUEST['report']==43){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Sales&nbsp;Report</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -10 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=6"><div class="iconbox <?php if($_REQUEST['report']==6){?> active <?php } ?>"><img src="images/aboutcmsicon.png" /><div class="text">Supplier Payment Pending</div></div></a> -->



<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=9"><div class="iconbox <?php if($_REQUEST['report']==9){?> active <?php } ?>"><img src="images/cms-award.png" />
<div class="text">Tax Report</div></div>
</a> -->

<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=44"><div class="iconbox <?php if($_REQUEST['report']==44){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Tour&nbsp;Extention&nbsp;Report</div></div></a>

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=29"><div class="iconbox <?php if($_REQUEST['report']==29){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Tour&nbsp;Registration&nbsp;Report</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -360 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=34"><div class="iconbox <?php if($_REQUEST['report']==34){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Turnover&nbsp;Statement&nbsp;Country&nbsp;Wise</div></div></a> -->

<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -360 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=40"><div class="iconbox <?php if($_REQUEST['report']==40){?> active <?php } ?>"><img style="display:inline;" src="images/th3333s.jpg" /><div class="text" style="display:inline; padding-left:10px;">Turnover&nbsp;Statement&nbsp;Executive&nbsp;Wise</div></div></a> -->

<a href="showpage.crm?fromDate=<?php echo date('01-m-Y');?>&toDate=<?php echo date('d-m-Y');?>&module=reports&report=1"><div class="iconbox <?php if($_REQUEST['report']==1){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">User Wise Query Report</div></div></a>

<a href="showpage.crm?fromDate=<?php echo date('01-m-Y');?>&toDate=<?php echo date('d-m-Y');?>&module=reports&report=65"><div class="iconbox <?php if($_REQUEST['report']==65){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">VISA Report</div></div></a>


<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=1"><div class="iconbox <?php if($_REQUEST['report']==1){?> active <?php } ?>"><img src="images/user.png" /><div class="text">User Wise Query</div></div></a> -->


<?php /*?><a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=8"><div class="iconbox <?php if($_REQUEST['report']==8{?> active <?php } ?>"><img src="images/cms-clients.png" /><div class="text">Travelbooking</div></div></a><?php */?>


<!--  <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=24"><div class="iconbox <?php if($_REQUEST['report']==24){?> active <?php } ?>"><img src="images/th22.jpg" /><div class="text">Hotel Booking Report</div></div></a>
-->


<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=30"><div class="iconbox <?php if($_REQUEST['report']==30){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Cenvat&nbsp;Report</div></div></a> -->


<!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=31"><div class="iconbox <?php if($_REQUEST['report']==31){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Hotel Room Night Summary
&nbsp;Report</div></div></a> -->
</div>
<div class="rightBox cmsouter">
<?php if($_REQUEST['report']<1){ ?>
<script>
window.location.href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=1";
</script>
<?php exit(); } ?>

<?php
$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']);
$fromDate=date('d-m-Y', strtotime($_GET['fromDate']));
$toDate=date('d-m-Y', strtotime($_GET['toDate']));
$assignto=$_GET['assignto'];
$destinationId=$_GET['destinationId'];
$categoryId=$_GET['categoryId'];
$hotelId=$_GET['hotelId'];
$tourType=$_GET['tourType'];
$clientType=$_GET['clientType'];
$clients=$_GET['Clients'];
?>
<?php if($_REQUEST['report']=='user_wise_old_report'){ ?>

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<?php
$strWhere='';
$strWhere25 = "";
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' and  queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
if($assignto!=''){   
$strWhere25 = ' and id="'.$assignto.'"';
}
if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}
if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}
if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="91%" align="left" valign="top">
<form method="get">
<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><h3 class="cms_title">User Wise Query Report</h3>
<td><div class="headingm" style="margin-left: 40px;width: max-content;">
<div id="deactivatebtn" style="display:none;">
<?php if($deletepermission==1){ ?> 
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
<?php } ?>
</div>
</div></td>
<td align="right"><table border="0" cellpadding="0" cellspacing="0">
<tr>
<td >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="35%" style="width: 120px;border-radius: 18px;">
<a title="Supplier Payment" onClick="alertspopupopen('action=sendmailtoclient&fromDate=<?php echo $_GET['fromDate']; ?>&toDate=<?php echo $_GET['toDate'];?>&assignto=<?php echo $_GET['assignto']; ?>','400px','auto');"><div class="mailsend"><i class="fa fa-send-o" style="font-weight: 500;font-size: 14px;"></i>&nbsp;&nbsp;Send Mail</div></a>
</td>

<td width="39%" style="padding:0px 0px 0px 5px;" style="width: 95px;border-radius: 18px;">
<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>


<!-- <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate_y" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td> -->

<!-- <td style="padding:0px 0px 0px 5px;" > 

<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate_y" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td> -->

<td style="padding:0px 0px 0px 5px;" >

<select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; padding: 9px; " >
<option value="">All Users</option>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';  
//userType=1 and   
$where=' status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo $resListing['id']; ?>" <?php if($assignto==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
<?php } ?>
</select></td>
<script>
function loadsearchClients(){
var clientType = $('#clientType').val();
//$('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
}
</script>
<td style="padding:0px 0px 0px 5px;display:none;" ><select onChange="loadsearchClients();" id="clientType" class="topsearchfiledmainselect" displayname="Client Type" autocomplete="off" style="width:110px; " > 
<option value=""  <?php if($clientType==0){ ?>selected="selected"<?php } ?>>All Clients</option> 
<option value="1"  <?php if($clientType==1){ ?>selected="selected"<?php } ?>>Agent</option> 
<option value="2"  <?php if($clientType==2){ ?>selected="selected"<?php } ?>>B2C</option> 
</select></td>
<td style="padding:0px 0px 0px 5px;display:none;" ><select   id="Clients" class="topsearchfiledmainselect" style="width:120px; " >
<option value="">All Clients</option>
</select></td>
<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
<input name="report" id="report" type="hidden" value="1" />
<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>

</tr>

</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />      </td>

</tr>
</table></td>
</tr>
</table>
<script>
loadsearchClients();
$('#fromDate_y').Zebra_DatePicker({
format: 'd-m-Y',  
pair: $('#toDate_y'),
});
$('#toDate_y').Zebra_DatePicker({
format: 'd-m-Y',
});
</script>

</div>

</form>
<div id="pagelisterouter" style="padding-left:30px;">

<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>
<input name="fromDate2" type="text"  class="topsearchfiledmain" id="fromDate_y" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/>

<div class="norec">Please Select From Date and To Date then Press Search </div>
<?php } else { ?>
<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
<thead>
<tr>
<th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Name</label></th> 
<th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
<th align="center" valign="middle" class="header" >Created</th>
<th align="center" class="header">Confirmed</th>
<th align="center" class="header">Reverted</th>
<th align="center" class="header">Cancel</th>
<th align="center" class="header">Assigned</th>
<th align="center" class="header">Sent</th>
<th align="center" class="header">Follow&nbsp;Up</th>
<th align="center" class="header"> Lost</th>
<th align="center" class="header">Time Limit </th>
<th align="right" class="header"> Sales</th>
<th align="right" class="header"  >Gross&nbsp;Margin </th>
<th align="right" class="header"  >Total&nbsp;Pax</th>
<th align="right" class="header"  >No(s)&nbsp;Nights </th>
</tr>
</thead>
<tbody>
<?php 

////////////if assign to is not blank. Comes from search.////////////

////////////if assign to is blank comes from report////////////

$totalcreated=''; 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='status=1 '.$strWhere25.' order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<tr style="font-size: 13px;">

<td align="left" valign="middle"><?php echo $resListing['firstName']; ?></td>
<td align="center" valign="middle"> 
<div class="bluelink" onClick="masters_alertspopupopen('action=addedit_userWiseReportExport&assignto=<?php echo $resListing['id']; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','1200px','auto');">
<?php  
$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and assignTo=".$resListing['id']." ";
$res5 = mysqli_query(db(),$sql5); 
echo $tquery=mysqli_num_rows($res5);
$tqueryTotal=$tqueryTotal+$tquery;
?>

</div>  </td>
<td align="center" valign="middle"><?php  
$sql567="select id from "._QUERY_MASTER_." where 1  ".$strWhere." and queryStatus=10 and assignTo=".$resListing['id']."";
$res567 = mysqli_query(db(),$sql567);
echo $tquery567=mysqli_num_rows($res567);
$totalcreated=$totalcreated+mysqli_num_rows($res567);
?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$confirmedqueryTotl=$tquery+$confirmedqueryTotl;
?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=2 and assignTo=".$resListing['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$revertedqueryTotal=$revertedqueryTotal+$tquery;?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where 1  ".$strWhere." and queryStatus=20 and deletestatus=0 and assignTo=".$resListing['id']."  ";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$canceltotal=$canceltotal+$tquery;
?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where 1  ".$strWhere." and queryStatus=1 and assignTo=".$resListing['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$assignedqueryTotal=$assignedqueryTotal+$tquery;
?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=6 and assignTo=".$resListing['id']." ";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$sentqueryTotal=$tquery+$sentqueryTotal;
?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=7 and assignTo=".$resListing['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$followQueryTotal=$followQueryTotal+$tquery;
?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where  1 ".$strWhere." and (queryStatus=4 or queryStatus=20) and assignTo=".$resListing['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$lostqueryTotal=$lostqueryTotal+$tquery;
?></td>
<td align="center"><?php  
$sql5="select id from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=5 and assignTo=".$resListing['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $tquery=mysqli_num_rows($res5);
$tlbqueryTotal=$tlbqueryTotal+$tquery;
?></td>
<!--   <td align="center"></td>-->
<td align="right">
<?php
$suppliertotalcost_sum=0;
$suppliertotalcost_gross=0;
$salesqueryGrossTotal=0;
$menu=mysqli_query(db(),"select * from "._QUERY_MASTER_."    where  1 ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."");
while($res_menu=mysqli_fetch_array($menu)){
$suppliertotalcost_sum = $suppliertotalcost_sum+$res_menu['totalQueryCost'];
$suppliertotalcost_gross = $suppliertotalcost_gross+$res_menu['totalQueryCostwithoutpercent'];
}
echo $suppliertotalcost_sum;
$salesqueryTotal=$salesqueryTotal+$suppliertotalcost_sum; 
?></td>
<td align="right" >
<?php if($suppliertotalcost_sum-$suppliertotalcost_gross<0){ echo '0'; }else {  echo $gross=$suppliertotalcost_sum-$suppliertotalcost_gross; } $salesqueryGrossTotal=$gross+$salesqueryGrossTotal; 

?>     </td>
<td align="right" ><?php   

$result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']." and assignTo=".$resListing['id'].""); 

$row = mysqli_fetch_assoc($result); 
$adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']." and assignTo=".$resListing['id'].""); 
$row2 = mysqli_fetch_assoc($result2); 
echo $totalpax=$adultsum+$row2['childsum'];
$totalpaxTotal=$totalpax+$totalpaxTotal;
?></td>
<td align="right" >
<?php   
$result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where  1 ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id'].""); 
$row3 = mysqli_fetch_assoc($result3); 
echo $nonights=$adultsum+$row3['nightsum'];
$nonightsTotal=$nonights+$nonightsTotal;
?>  </td>

</tr> 
<?php } ?>
<!--Total start-->
<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
<td align="left" valign="middle"><strong>Total</strong></td>
<td align="center" valign="middle"><?php echo $tqueryTotal;?></td>
<td align="center" valign="middle"><?php echo $totalcreated;?></td>
<td align="center"><?php  echo $confirmedqueryTotl;?> </td>
<td align="center"><?php  echo $revertedqueryTotal;?></td>
<td align="center"><?php echo $canceltotal;?></td>
<td align="center"><?php  echo $assignedqueryTotal;?></td>
<td align="center"><?php  echo $sentqueryTotal;?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
<td align="center"><?php echo $followQueryTotal;?></td>
<td align="center"><?php  echo $lostqueryTotal;?></td>
<td align="center"><?php  echo $tlbqueryTotal;?></td>
<!--   <td align="center"></td>-->
<td align="right">
<?php echo $salesqueryTotal;?>  </td>
<td align="right" >
<?php echo $salesqueryGrossTotal;?> </td>
<td align="right" ><?php   echo $totalpaxTotal;?></td>
<td align="right" >
<?php   echo $nonightsTotal;?>  </td>

</tr> 
<!--Total end-->
<?php    ?>

</tbody></table>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="allReports/download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>

<script>

function getdatafun(){

var tab_text = document.getElementById('margin').innerHTML;

tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, ""); 

tab_text= tab_text.replace(/<img[^>]*>/gi,""); 

tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, "");    



var jHtmlObject = jQuery(tab_text);

var editor = jQuery("<p>").append(jHtmlObject);

editor.find(".dropdwn").remove();

editor.find(".dataTables_info").remove();

editor.find(".dataTables_paginate").remove();

editor.find(".lightgrayfield").remove();

editor.find(".dataTables_length").remove();

editor.find(".dataTables_filter").remove();

editor.find(".showtm").show();

var newHtml = editor.html();  

$('#repotBody').text(newHtml);

}







function fnExcelReport()

{

var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";

var textRange; var j=0;

tab = document.getElementById('example'); // id of table



for(j = 0 ; j < tab.rows.length ; j++) 

{     

tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";

//tab_text=tab_text+"</tr>";

}



tab_text=tab_text+"</table>";

tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table

tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table

tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params



var ua = window.navigator.userAgent;

var msie = ua.indexOf("MSIE "); 



if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer

{

txtArea1.document.open("txt/html","replace");

txtArea1.document.write(tab_text);

txtArea1.document.close();

txtArea1.focus(); 

sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to dutySheet.xls");

}  

else                 //other browser not tested on IE 11

sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  



return (sa);

}



</script>



<script>



function copydatatodata(){



var boxreport = $('#boxreport').html();



$('#reportdata').val(boxreport);  



$('#downloadrtm').submit();  

}

</script>

<?php if($_REQUEST['assignto']==''){ ?>



<script type="text/javascript">

// google.charts.load("current", {packages:['corechart']});



// google.charts.setOnLoadCallback(drawChart);



// function drawChart() {



//   var data = google.visualization.arrayToDataTable([



//     ['QUERIES', 'CONFIRMED', 'REVERTED', 'ASSIGNED', 'SENT', 'FOLLOW UP', 'LOST', { role: 'annotation' } ],



<?php



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' userType=1 and status=1 order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>['<?php echo addslashes($resListing['firstName']); ?>', <?php  



$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$confirmedqueryTotl=$tquery+$confirmedqueryTotl;



?>, <?php  



$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and queryStatus=2 and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$revertedqueryTotal=$revertedqueryTotal+$tquery;?>, <?php  



$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and queryStatus=1 and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$assignedqueryTotal=$assignedqueryTotal+$tquery;



?>, <?php  



$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and queryStatus=6 and assignTo=".$resListing['id']." ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$sentqueryTotal=$tquery+$sentqueryTotal;



?>, <?php  



$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and queryStatus=7 and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$followQueryTotal=$followQueryTotal+$tquery;



?>, <?php  



$sql5="select id from "._QUERY_MASTER_." where 1 ".$strWhere." and queryStatus=4 and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$lostqueryTotal=$lostqueryTotal+$tquery;



?>, ''], 



<?php } ?>

var options = {



width: 1000,



height: 400,



legend: { position: 'top', maxLines: 3 },



bar: {groupWidth: '75%'},



isStacked: true,



};



var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_stacked'));
chart.draw(data, options);
</script>
<div id="columnchart_stacked" style="width:800px; text-align:center;"></div>
<?php } ?>



<?php } ?>

</div>  </td>

</tr>

<?php if($_REQUEST['sp']=='1'){?>  

<tr>
<td width="91%" align="left" valign="top">  </td>

</tr><?php }?>

</table>



<script> 



window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;



if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');



</script>



<?php }?>




<?php if($_REQUEST['report']=='1'){
?>
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<?php
$dateCon = '';
$strWhere='';
$fromDate='';
$toDate='';
$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = $myArray[0];
$toDate = $myArray[1];

}

if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
$dateCon = ' and queryMaster.queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';

}else{
$dateCon = ' and queryMaster.queryDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
}

if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';

}

$agent='';
if($_REQUEST['user']!='')
{
$agent = ' and id='.$_REQUEST['user'];
}

if($clients!=''){  

$strWhere.='';

}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

<td width="91%" align="left" valign="top">
<form method="get">
<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative;padding:10px">

<tr>

<h3 class="cms_title">User Wise Query  Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
<td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> </span>

<div id="deactivatebtn" style="display:none;">

<?php if($deletepermission==1){ ?> 

<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
<?php }  ?>
</div>

</div></td>
<td align="right"><table border="0" cellpadding="0" cellspacing="0">
<tr>
<td >

<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr style="position: absolute;top:11px;left:290px;" >

<script>

$(function() {

$('input[name="daterange"]').daterangepicker({

"autoApply": true,
opens: 'right',
locale: {
format: 'DD-MM-YYYY'
}

}, function(start, end, label) { 

});

});

</script>



<td style="padding:0px 0px 0px 5px;" >
<select name="user" id="user" class="topsearchfiledmainselect" style="width:200px; " >

<option value="">All User</option>
<?php
$companyQuery=GetPageRecord('id,firstName,lastName',_USER_MASTER_,'deletestatus=0  ');
while($companyResult=mysqli_fetch_array($companyQuery)){
?>
<option <?php if($_REQUEST['user']==$companyResult['id']){echo 'value="'.$companyResult['id'].'" selected';}else{echo "value='".$companyResult['id']."'";} ?> ><?=$companyResult['firstName'].' '.$companyResult['lastName']?></option>
<?php
}

?>
</select></td>

<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>
<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="clientType" id="clientType" type="hidden" value="1" />
<input name="report" id="report" type="hidden" value="1" />
<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
</tr>
</table>
<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
</td>
</tr>
</table></td>
</tr>
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
<style>
#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}

#example_filter label {
font-size: 18px;
}
#example_wrapper{
	width:91%;
}

</style> 

<div id=""  style="padding-left: 0px; padding: 10px; padding-top: 47px;">

<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']=='' && $_REQUEST['daterange']==''){ ?>



<div class="norec">Please Select From Date and To Date then Press Search</div>



<?php  } else { ?>



<div id="boxreport" >
<?php

$outputAg='<table border="1" cellpadding="" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable dataTable no-footer headerClass" data-page-length="25" style="width: 100%;" role="grid" aria-describedby="example_info">
<thead>
<tr style="height:40px">
<th  width="20" align="center" lass=" sorting ui-state-default sorting_asc" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S.No: activate to sort column descending" >S.No</th> 
<th  width="40" align="center" lass=" sorting ui-state-default sorting_asc" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S.No: activate to sort column descending" >Agent Name</th> 



<th align="center"   valign="middle" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" >Queries</th> 

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Confirmed</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Reverted</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Sent</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Follow&nbsp;Up</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> Lost</th>';

$outputAg.='<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> MAT(%)</th>';

// <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->



$outputAg.='<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> Sales</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >Margin </th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >Total&nbsp;Pax</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >No(s)&nbsp;Nights </th>

</tr>

</thead>

<tbody>'; 

$sn=1;

$totalQuery=0;
$totalConfirm =0;
$totalReverted=0;
$totalAssigned=0;
$totalSent=0;
$totalFellowUp=0;
$totalLost=0;
$totalSales = 0;
$matprecent=0;
$totalMargin=0;
$totalPax=0;
$totalNight=0;


$companyQuery=GetPageRecord('id,firstName,lastName',_USER_MASTER_,' deletestatus=0 '.$agent.' and id in (select assignTo from queryMaster where deletestatus=0 '.$dateCon.')');
while($companyResult=mysqli_fetch_array($companyQuery))
{
$outputAg.='<tr>';

$queryStatus=[3,2,6,7,4];

$outputAg.="<td align='center' valign='middle'>$sn</td>";
$outputAg.="<td align='center' valign='middle'>".$companyResult['firstName']." ".$companyResult['lastName']."</td>";  
$outputAg.="<td align='center' valign='middle'>";
$Query=GetPageRecord('id',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
$queryResultCount=mysqli_num_rows($Query);
$allqueryis = $queryResultCount;
$totalQuery+=$queryResultCount;
$outputAg.=$queryResultCount;
$outputAg.='</td>';
foreach($queryStatus as $val)
{

$outputAg.='<td align="center" valign="middle">';
$Query=GetPageRecord('id',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' and queryStatus="'.$val.'" '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
$queryResultCount=mysqli_num_rows($Query);
if($val==3)
$totalConfirm +=$queryResultCount;
if($val==2)
$totalReverted +=$queryResultCount;
// if($val==1)
// $totalAssigned +=$queryResultCount;
if($val==6)
$totalSent +=$queryResultCount;
if($val==7)
$totalFellowUp +=$queryResultCount;
if($val==4)
$totalLost +=$queryResultCount;

$outputAg.=$queryResultCount;
$outputAg.='</td>';
}

// mat% code started
$outputAg.='<td align="center" valign="middle">';

$matper=GetPageRecord('id',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' and queryStatus=3'.$dateCon);

 $matperCount=mysqli_num_rows($matper);

$MatPersantage =ceil(($matperCount/$allqueryis)*100);

$MatPersantage1 = ceil(($totalConfirm/$totalQuery)*100);
$matprecent+=$MatPersantage;
$outputAg.=$MatPersantage;

$outputAg.='</td>';

$outputAg.='<td align="center" valign="middle">';
$totalSales=0;
$Query1=GetPageRecord('id',_QUERY_MASTER_,'queryStatus=3 and assignTo="'.$companyResult['id'].'"  and  clientType!=2  '.$dateCon);
while($queryResult1=mysqli_fetch_array($Query1)){
$Querysales=GetPageRecord('id,totalQuotCost',_QUOTATION_MASTER_,'queryId='.$queryResult1['id'].' and isPaymentRequest=1 ');
$salesData=mysqli_fetch_array($Querysales);
$totalSales+=round($salesData['totalQuotCost']);
}
$totalSalesData+=$totalSales;      
$outputAg.=$totalSales;

$outputAg.='</td>';

$outputAg.='<td align="center" valign="middle">';
$totalMarginCost=0;
$totalMarginData=0;
$Query=GetPageRecord('id',_QUERY_MASTER_,'queryStatus=3 and assignTo="'.$companyResult['id'].'"  and  clientType!=2 '.$dateCon);
while($queryResult=mysqli_fetch_array($Query)){
$QueryQuotation=GetPageRecord('*',_QUOTATION_MASTER_,'queryId='.$queryResult['id'].' and isPaymentRequest=1 ');
$quotationResult=mysqli_fetch_array($QueryQuotation);

$expenseAmount=0;
$exrs = GetPageRecord('*','quotationExpensesMaster',' queryId="'.$quotationResult['queryId'].'"');
while($expenseData = mysqli_fetch_assoc($exrs)){
	$expenseAmount = $expenseAmount + $expenseData['expenseAmount'];
}
$rsp = GetPageRecord('*','paymentRequestMaster','quotationId="'.$quotationResult['id'].'"');
$paymentrequestData = mysqli_fetch_assoc($rsp);

$totalMarkupAMT = $paymentrequestData['totalMarkupCost'];
$totalMarginCost = $totalMarkupAMT-$expenseAmount;
$totalMarginData+=($totalMarginCost); 

}

$grandMarginData += round($totalMarginData);
$outputAg.=round($totalMarginData);
$outputAg.='</td>';

$outputAg.='<td align="center" valign="middle">';
$pax=0;
$Query=GetPageRecord('SUM(adult) as adultCount,SUM(child) as childCount',_QUERY_MASTER_,' assignTo="'.$companyResult['id'].'" '.$dateCon);
$queryResult=mysqli_fetch_array($Query);
$pax=$queryResult['adultCount']+$queryResult['childCount'];
$totalPax+=$pax;
$outputAg.=$pax;
$outputAg.='</td>'; 

$outputAg.='<td align="center" valign="middle">';
$nightCount=0;
$Query=GetPageRecord('SUM(night) as nightCount ',_QUERY_MASTER_,' assignTo="'.$companyResult['id'].'" '.$dateCon);
$queryResult=mysqli_fetch_array($Query);
$nightCount=$queryResult['nightCount'];
$totalNight+=$nightCount;
$outputAg.=$nightCount;
$outputAg.='</td>';

$outputAg.='</tr>';
$sn++;  
}

// <!--Total start-->
$totalmatpercent = ceil(($totalConfirm/$totalQuery)*100);
$outputAg.='<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">';
$outputAg.='<td  align="center" valign="middle">'.$sn.'</td>';
$outputAg.='<td align="center" valign="middle"><strong>Total</strong></td>';
$outputAg.='<td align="center" valign="middle">'.$totalQuery.'</td>';
$outputAg.='<td align="center">'.$totalConfirm.'</td>';
$outputAg.='<td align="center">'.$totalReverted.'</td>';
// $outputAg.='<td align="center">'.$totalAssigned.'</td>';
$outputAg.='<td align="center">'.$totalSent.'</td>';
//  <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
$outputAg.='<td align="center">'.$totalFellowUp.'</td>';
$outputAg.='<td align="center">'.$totalLost.'</td>';
$outputAg.='<td align="center">'.$totalmatpercent.'(%)'.'</td>';
//  <!--   <td align="center"></td>-->
$outputAg.='<td align="center">';
$outputAg.=$totalSalesData;
$outputAg.='</td>';
$outputAg.='<td align="center" >'.$grandMarginData.'</td>';
$outputAg.='<td align="center" >'.$totalPax.'</td>';
$outputAg.='<td align="center" >'.$totalNight.'</td>';
$outputAg.='</tr>'; 
//  <!--Total end-->
$outputAg.='</tbody></table>';
echo $outputAg;
?>
</div>

<div style="text-align:center; margin-top:30px;">

<script>

$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
responsive: true,
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title:'User Wise Query Report' },
{extend: 'excelHtml5', title:'User Wise Query Report'},
{extend: 'pdfHtml5', title:'User Wise Query Report',
orientation: 'landscape',
pageSize: 'A4'
}
],
language: { 
search: "Search: ",
searchPlaceholder: "user , Query , Pax",
},

}
);

} );

function copydatatodata(){



var boxreport = $('#boxreport').html();



$('#reportdata').val(boxreport);  



$('#downloadrtm').submit();  



}



</script>



<?php } ?>



</div>  </td>

</tr>

<?php if($_REQUEST['sp']=='1'){?>  
<tr>
<td width="91%" align="left" valign="top">
</td>
</tr><?php }?>
</table>

<script> 

window.setInterval(function(){ 

checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

if(!checked) { 

$("#deactivatebtn").hide();

$("#topheadingmain").show();

} else {

$("#deactivatebtn").show();

$("#topheadingmain").hide();

} 

}, 100);

comtabopenclose('linkbox','op2');

</script>

<?php }?>


<!--==================== Agent Wise Query Report starts =============== -->
<?php if($_REQUEST['report']=='2'){
?>
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/> 
<link href="css/datatablec.css" rel="stylesheet"/> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script> 

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<?php
$dateCon = '';
$strWhere='';
$fromDate='';
$toDate='';
$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = $myArray[0];
$toDate = $myArray[1];
// $strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
// $daterangeQuery = 'quotationId in (select id from quotationMaster where status=1 and startDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;

}

if($fromDate!='' && $toDate!=''){

$fromDate = date('Y-m-d', strtotime( $fromDate ));

$toDate = date('Y-m-d', strtotime( $toDate ));

$strWhere.=' fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
$dateCon = ' and queryMaster.fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';

}else{
$dateCon = ' and queryMaster.fromDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
}

if($clientType!=''){  

$strWhere.=' and clientType='.$clientType.'';

}

$agent='';
if($_REQUEST['Clients']!='')
{
$agent = ' and id='.$_REQUEST['Clients'];
}

if($clients!=''){  

$strWhere.=' and companyId='.$clients.'';

}

?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

<td width="91%" align="left" valign="top">
<form method="get">

<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative;padding:10px">

<tr>
<h3 class="cms_title" style="padding-left:70px;"> Agent Wise Query  Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
<td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> </span>

<div id="deactivatebtn" style="display:none;">

<?php if($deletepermission==1){ ?> 

<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />

<?php }  ?>

</div>

</div></td>

<td align="right"><table border="0" cellpadding="0" cellspacing="0">

<tr>
<td >
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr style="position: absolute;top:11px;left:290px;" >

<script>

$(function() {
$('input[name="daterange"]').daterangepicker({
"autoApply": true,
opens: 'right',
locale: {
format: 'DD-MM-YYYY'
}

}, function(start, end, label) { 

});
});
</script>

<script>

function loadsearchClients(){

var clientType = $('#clientType').val();

$('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);

}

</script>



<td style="padding:0px 0px 0px 5px;" >
<select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:200px; " >



<option value="">All Clients</option>

</select></td>

<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>
<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="clientType" id="clientType" type="hidden" value="1" />

<input name="report" id="report" type="hidden" value="2" />

<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>

</tr>

</table>

<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />

</td>

</tr>

</table></td>

</tr>

</table>

<script>

loadsearchClients();

</script>

</div>

</form>

<style>
#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}

#example_filter label {
font-size: 18px;
}

</style> 

<div id=""  style="padding-left: 0px; padding: 10px; padding-top: 47px;">

<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']=='' && $_REQUEST['daterange']==''){ ?>



<div class="norec">Please Select From Date and To Date then Press Search</div>



<?php  } else { ?>



<div id="boxreport" >
<?php

$outputAg='<table border="1" cellpadding="" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable dataTable no-footer headerClass" data-page-length="25" style="width: 100%;" role="grid" aria-describedby="example_info">
<thead>
<tr style="height:40px">
<th  width="20" align="center" lass=" sorting ui-state-default sorting_asc" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S.No: activate to sort column descending" >S.No</th> 
<th  width="40" align="center" lass=" sorting ui-state-default sorting_asc" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S.No: activate to sort column descending" >Agent Name</th> 



<th align="center"   valign="middle" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" >Queries</th> 

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Confirmed</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Reverted</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Assigned</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Sent</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Follow&nbsp;Up</th>

<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> Lost</th>';

// <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->



$outputAg.='<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> Sales</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >Margin </th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >Total&nbsp;Pax</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >No(s)&nbsp;Nights </th>

</tr>

</thead>

<tbody>'; 

$sn=1;

$totalQuery=0;
$totalConfirm =0;
$totalReverted=0;
$totalAssigned=0;
$totalSent=0;
$totalFellowUp=0;
$totalLost=0;
$totalSales = 0;
$totalMargin=0;
$totalPax=0;
$totalNight=0;

$companyQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' name!="" and deletestatus=0  and companyTypeId=1 '.$agent.' and id in (select companyId from queryMaster where deletestatus=0 '.$dateCon.')');
while($companyResult=mysqli_fetch_array($companyQuery))
{
$outputAg.='<tr>';

$queryStatus=[3,2,0,6,7,4];

$outputAg.="<td align='center' valign='middle'>$sn</td>";
$outputAg.="<td align='center' valign='middle'>".$companyResult['name']."</td>";  
$outputAg.="<td align='center' valign='middle'>";
$Query=GetPageRecord('id',_QUERY_MASTER_,' companyId='.$companyResult['id'].' '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
$queryResultCount=mysqli_num_rows($Query);
$totalQuery+=$queryResultCount;
$outputAg.=$queryResultCount;
$outputAg.='</td>';
foreach($queryStatus as $val){

$outputAg.='<td align="center" valign="middle">';
$Query=GetPageRecord('id',_QUERY_MASTER_,' companyId='.$companyResult['id'].' and queryStatus="'.$val.'" '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
$queryResultCount=mysqli_num_rows($Query);

if($val==3)
$totalConfirm +=$queryResultCount;
if($val==2)
$totalReverted +=$queryResultCount;
if($val==0)
$totalAssigned +=$queryResultCount;
if($val==6)
$totalSent +=$queryResultCount;
if($val==7)
$totalFellowUp +=$queryResultCount;
if($val==4)
$totalLost +=$queryResultCount;

$outputAg.=$queryResultCount;
$outputAg.='</td>';
}

$outputAg.='<td align="center" valign="middle">';
$queryCount=0;
$rs11='';

$salesAMT=0;
$rs11 = GetPageRecord('id','queryMaster','companyId="'.$companyResult['id'].'" and queryStatus=3 '.$dateCon.'');
while($queryMasterD = mysqli_fetch_assoc($rs11)){
	$rs22 = GetPageRecord('totalClientCost','paymentRequestMaster','queryid="'.$queryMasterD['id'].'" ');
	$salesData = mysqli_fetch_assoc($rs22);
	
	$salesAMT+= round($salesData['totalClientCost'],2);  
}	
$totalSales= $totalSales+ $salesAMT;
$outputAg.=$salesAMT;

$outputAg.='</td>';

$outputAg.='<td align="center" valign="middle">';
$clientMargin=0;

$Query=GetPageRecord('id',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'"  and  clientType=1  '.$dateCon);
while($queryResult=mysqli_fetch_array($Query)){

$QueryQuotation=GetPageRecord('*','paymentRequestMaster','queryid="'.$queryResult['id'].'" ');
$paymentRequestD=mysqli_fetch_array($QueryQuotation);
$totalMarkupAMT = $paymentRequestD['totalMarkupCost'];
$expenseAmount=0;
$exrs = GetPageRecord('*','quotationExpensesMaster',' queryId="'.$quotationResult['queryId'].'"');
while($expenseData = mysqli_fetch_assoc($exrs)){
	$expenseAmount = $expenseAmount + $expenseData['expenseAmount'];
}

$totalMarginCost = $totalMarkupAMT-$expenseAmount;
$clientMargin += round($totalMarginCost,2);

}

$totalMargin = $totalMargin + $clientMargin;
$outputAg.= $clientMargin;

$outputAg.='</td>';

$outputAg.='<td align="center" valign="middle">';
$pax=0;
$Query=GetPageRecord('SUM(adult) as adultCount,SUM(child) as childCount',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'" '.$dateCon);
$queryResult=mysqli_fetch_array($Query);
$pax=$queryResult['adultCount']+$queryResult['childCount'];
$totalPax+=$pax;
$outputAg.=$pax;
$outputAg.='</td>'; 

$outputAg.='<td align="center" valign="middle">';
$nightCount=0;
$Query=GetPageRecord('SUM(night) as nightCount ',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'" '.$dateCon);
$queryResult=mysqli_fetch_array($Query);
$nightCount=$queryResult['nightCount'];
$totalNight+=$nightCount;
$outputAg.=$nightCount;
$outputAg.='</td>';

$outputAg.='</tr>';
$sn++;  
}

// <!--Total start-->
$outputAg.='<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">';
$outputAg.='<td  align="center" valign="middle">'.$sn.'</td>';
$outputAg.='<td align="center" valign="middle"><strong>Total</strong></td>';
$outputAg.='<td align="center" valign="middle">'.$totalQuery.'</td>';
$outputAg.='<td align="center">'.$totalConfirm.'</td>';
$outputAg.='<td align="center">'.$totalReverted.'</td>';
$outputAg.='<td align="center">'.$totalAssigned.'</td>';
$outputAg.='<td align="center">'.$totalSent.'</td>';
//  <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
$outputAg.='<td align="center">'.$totalFellowUp.'</td>';
$outputAg.='<td align="center">'.$totalLost.'</td>';
//  <!--   <td align="center"></td>-->
$outputAg.='<td align="center">'.$totalSales.'</td>';
$outputAg.='<td align="center" >'.$totalMargin.'</td>';
$outputAg.='<td align="center" >'.$totalPax.'</td>';
$outputAg.='<td align="center" >'.$totalNight.'</td>';
$outputAg.='</tr>'; 
//  <!--Total end-->
$outputAg.='</tbody></table>';
echo $outputAg;
?>

</div>
<div style="text-align:center; margin-top:30px;">
<script>

$(document).ready(function() {
$('#example').DataTable(
	
{
responsive: true,
"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:99.4%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Agent Wise Query Report'},
{extend: 'excelHtml5', title: 'Agent Wise Query Report'},
{extend: 'pdfHtml5', title: 'Agent Wise Query Report', 
	orientation : 'landscape',
    pageSize : 'A4',
    exportOptions: {
            //   columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ]
         },
		 }
],
language: { 
search: "Search: ",
searchPlaceholder: "Agent , Query , Pax",
},

}
);

} );

function copydatatodata(){



var boxreport = $('#boxreport').html();



$('#reportdata').val(boxreport);  



$('#downloadrtm').submit();  



}



</script>



<?php } ?>



</div>  </td>

</tr>

<?php if($_REQUEST['sp']=='1'){?>  
<tr>
<td width="91%" align="left" valign="top">
</td>
</tr><?php }?>
</table>

<script> 

window.setInterval(function(){ 

checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

if(!checked) { 

$("#deactivatebtn").hide();

$("#topheadingmain").show();

} else {

$("#deactivatebtn").show();

$("#topheadingmain").hide();

} 

}, 100);

comtabopenclose('linkbox','op2');

</script>

<?php }?>
<!-- ================================ Agent Wise Query Report ends ========================== -->

<?php if($_REQUEST['report']=='3'){
?>

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<?php
$dateCon = '';
$strWhere='';
$fromDate='';
$toDate='';
$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = $myArray[0];
$toDate = $myArray[1];
// $strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
// $daterangeQuery = 'quotationId in (select id from quotationMaster where status=1 and startDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;

}

if($fromDate!='' && $toDate!=''){



$fromDate = date('Y-m-d', strtotime( $fromDate ));



$toDate = date('Y-m-d', strtotime( $toDate ));



$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
$dateCon = ' and queryMaster.queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';

}
else
{
$dateCon = ' and queryMaster.queryDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
}


$clientType = ' and clientType=2 ';
if($_REQUEST['Clients']!='')
{
$agent =' and id='.$_REQUEST['Clients'];
}

?>



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get">

<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative;padding:10px">

<tr>
<h3 class="cms_title">Client Wise Query  Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

<td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> </span>

<div id="deactivatebtn" style="display:none;">

<?php if($deletepermission==1){ ?> 

<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />



<?php }  ?>



</div>

</div></td>

<td align="right"><table border="0" cellpadding="0" cellspacing="0">

<tr>

<td >

<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr style="position: absolute;top:11px;left:290px;" >



<!-- <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td> -->



<!-- <td style="padding:0px 0px 0px 5px;" > 



<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td> -->

<script>

$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {

format: 'DD-MM-YYYY'
}

}, function(start, end, label) { 

});

});

</script>
<script>
function loadsearchClients(){

var clientType = $('#clientType').val();
$('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
}
</script>
<td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:200px; " >
<option value="">All Clients</option>
</select></td>
<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>
<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
<input name="clientType" id="clientType" type="hidden" value="2" />
<input name="report" id="report" type="hidden" value="3" />
<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>

</tr>
</table>
<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
</td>
</tr>
</table></td>
</tr>
</table>
<script>

loadsearchClients();



</script>



</div>



</form>



<style>
#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}



#example_filter label {
font-size: 18px;
}

</style> 

<div id=""  style="padding-left: 0px; padding: 10px; padding-top: 47px;">

<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']=='' && $_REQUEST['daterange']==''){ ?>

<div class="norec">Please Select From Date and To Date then Press Search</div>

<?php  } else { ?>

<div id="boxreport" >
<?php
$output='<table border="1" cellpadding="" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable dataTable no-footer headerClass" data-page-length="25" style="width: 100%;" role="grid" aria-describedby="example_info">
<thead>
<tr style="height:40px">
<th  width="20" align="center" lass=" sorting ui-state-default sorting_asc" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S.No: activate to sort column descending" >S.No</th> 
<th  width="40" align="center" lass=" sorting ui-state-default sorting_asc" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S.No: activate to sort column descending" >Client Name</th> 



<th align="center"   valign="middle" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;" >Queries</th> 



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Confirmed</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Reverted</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Assigned</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Sent</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;">Follow&nbsp;Up</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> Lost</th>';



// <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->



$output.='<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"> Sales</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >Margin </th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >Total&nbsp;Pax</th>



<th align="center"  style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 66.3333px;"  >No(s)&nbsp;Nights </th>

</tr>
</thead>

<tbody>';

$sn=1;

$totalQuery=0;
$totalConfirm =0;
$totalReverted=0;
$totalAssigned=0;
$totalSent=0;
$totalFellowUp=0;
$totalLost=0;
$totalSales = 0;
$totalMargin=0;
$totalPax=0;
$totalNight=0;

$companyQuery=GetPageRecord('id,firstName,lastName',_CONTACT_MASTER_,' firstName!="" and deletestatus=0 '.$agent.' and id in (select companyId from queryMaster where deletestatus=0 and clientType=2 '.$dateCon.')');
while($companyResult=mysqli_fetch_array($companyQuery)){
$output.='<tr>';

$queryStatus=[3,2,0,6,7,4];

$output.="<td align='center' valign='middle'>$sn</td>";
$output.="<td align=center' valign='middle'>".$companyResult['firstName']." ".$companyResult['lastName']."</td>";  
$output.='<td align="center" valign="middle">';
$Query=GetPageRecord('id',_QUERY_MASTER_,' companyId='.$companyResult['id'].' and  clientType=2 '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
$queryResultCount=mysqli_num_rows($Query);
$totalQuery+=$queryResultCount;
$output.=$queryResultCount;
$output.='</td>';
foreach($queryStatus as $val)
{

$output.='<td align="center" valign="middle">';
$Query=GetPageRecord('id',_QUERY_MASTER_,'companyId='.$companyResult['id'].' and  clientType=2  and queryStatus="'.$val.'" '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
$queryResultCount=mysqli_num_rows($Query);
if($val==3)
$totalConfirm +=$queryResultCount;
if($val==2)
$totalReverted +=$queryResultCount;
if($val==0)
$totalAssigned +=$queryResultCount;
if($val==6)
$totalSent +=$queryResultCount;
if($val==7)
$totalFellowUp +=$queryResultCount;
if($val==4)
$totalLost +=$queryResultCount;

$output.=$queryResultCount;
$output.='</td>';
}

$output.='<td align="center" valign="middle">';
$sale=0;
$joinCorporateAndQueryMaster="select * from "._QUERY_MASTER_." inner join "._AGENT_PAYMENT_REQUEST_." on "._QUERY_MASTER_.".id="._AGENT_PAYMENT_REQUEST_.".queryId  where "._QUERY_MASTER_.".companyId=".$companyResult['id'].'  and  queryMaster.clientType=2  '.$dateCon;
$CorporateAndQueryResult = mysqli_query(db(),$joinCorporateAndQueryMaster);
// $totalSales+= $CorporateAndQueryResult;   
$sale=mysqli_num_rows($CorporateAndQueryResult);
$salesData = mysqli_fetch_assoc($CorporateAndQueryResult);
$totalSales+=$salesData['finalCost'];
$output.=$salesData['finalCost'];
$output.='</td>';	

$output.='<td align="center" valign="middle">';
$margin=0;
// $Query=GetPageRecord('SUM(totalMargin) as totalMargin ',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'"  and  clientType=2  '.$dateCon);
// $queryResult=mysqli_fetch_array($Query);
// $margin=$queryResult['totalMargin'];
$Query=GetPageRecord('id',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'"  and  clientType=2  '.$dateCon);
while($queryResult=mysqli_fetch_array($Query)){
$QueryQuotation=GetPageRecord('*',_QUOTATION_MASTER_,' queryId='.$queryResult['id'].' and isPaymentRequest=1 ');

$quotationResult=mysqli_fetch_array($QueryQuotation);

$expenseAmount=0;
$exrs = GetPageRecord('*','quotationExpensesMaster',' queryId="'.$quotationResult['queryId'].'"');
while($expenseData = mysqli_fetch_assoc($exrs)){
	$expenseAmount = $expenseAmount + $expenseData['expenseAmount'];
}

$totalTax = $quotationResult['serviceTax']+$quotationResult['tcs'];
$totalCostWithoutTax11 = $quotationResult['totalQuotCost']-1;
$totalCostWithoutTax = $totalCostWithoutTax11/(1+$totalTax/100);
$totalMarkupAMT = $totalCostWithoutTax-$quotationResult['totalCompanyCost'];
$totalMarginCost = $totalMarkupAMT-$expenseAmount;
// $margin+=$totalMarginCost;
   
}
$totalMargin+=round($totalMarginCost);
$output.=round($totalMarginCost);
$output.='</td>';

$output.='<td align="center" valign="middle">';
$pax=0;
$Query=GetPageRecord('SUM(adult) as adultCount,SUM(child) as childCount',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'"  and  clientType=2  '.$dateCon);
$queryResult=mysqli_fetch_array($Query);
$pax=$queryResult['adultCount']+$queryResult['childCount'];
$totalPax+=$pax;
$output.=$pax;
$output.='</td>'; 

$output.='<td align="center" valign="middle">';
$nightCount=0;
$Query=GetPageRecord('SUM(night) as nightCount ',_QUERY_MASTER_,' companyId="'.$companyResult['id'].'"  and  clientType=2  '.$dateCon);
$queryResult=mysqli_fetch_array($Query);
$nightCount=$queryResult['nightCount'];
$totalNight+=$nightCount;
$output.=$nightCount;
$output.='</td>';

$output.='</tr>';
$sn++;  
}



//  <!--Total start-->



$output.='<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">';

$output.='<td  align="center" valign="middle">'.$sn.'</td>';
$output.='<td align="left" valign="middle"><strong>Total</strong></td>';
$output.='<td align="center" valign="middle">'.$totalQuery.'</td>';
$output.='<td align="center">'.$totalConfirm.'</td>';
$output.='<td align="center">'.$totalReverted.'</td>';
$output.='<td align="center">'.$totalAssigned.'</td>';
$output.='<td align="center">'.$totalSent.'</td>';
//  <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
$output.='<td align="center">'.$totalFellowUp.'</td>';
$output.='<td align="center">'.$totalLost.'</td>';
//  <!--   <td align="center"></td>-->
$output.='<td align="center">'.$totalSales.'</td>';
$output.='<td align="center" >'.$totalMargin.'</td>';
$output.='<td align="center" >'.$totalPax.'</td>';
$output.='<td align="center" >'.$totalNight.'</td>';
$output.='</tr>'; 
//  <!--Total end-->
$output.='</tbody></table>';

echo $output;
?>
<?php  
$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and companyId=".$resListing['id']." and clientType=1 ";

$res5 = mysqli_query(db(),$sql5);

echo $tquery=mysqli_num_rows($res5);

$tlost=$tquery+$tquery;

?>
</div>

<div style="text-align:center; margin-top:30px;">

<script>
$(document).ready(function() {
$('#example').DataTable(
//   {
//     "order": [[ 2, "asc" ]]
// }
{
responsive: true,
dom: 'frtilpB',
buttons: [
'copyHtml5',
'excelHtml5',
// //'csvHtml5',
'pdfHtml5'
],
language: { 
search: "Search: ",
searchPlaceholder: "Agent , Query , Pax",
},

}
);

} );

function copydatatodata(){



var boxreport = $('#boxreport').html();



$('#reportdata').val(boxreport);  



$('#downloadrtm').submit();  



}

</script>



<?php } ?>



</div>  </td>



</tr>

<?php if($_REQUEST['sp']=='1'){?>  
<tr>
<td width="91%" align="left" valign="top">

</td>
</tr><?php }?>

</table>
<script> 
window.setInterval(function(){ 

checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');



</script>



<?php }?>



<?php if($_REQUEST['report']=='311'){



$strWhere='';



if($fromDate!='' && $toDate!=''){



$fromDate = date('Y-m-d', strtotime( $fromDate ));



$toDate = date('Y-m-d', strtotime( $toDate ));



$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';



}



if($clientType!=''){  



$strWhere.=' and clientType='.$clientType.'';



}



if($clients!=''){  



$strWhere.=' and companyId='.$clients.'';



}



?>



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get">



<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<h3 class="cms_title">Client Wise Query  Report</h3>

<td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  </span>

<div id="deactivatebtn" style="display:none;">

<?php if($deletepermission==1){ ?> 

<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />

<?php } ?>

</div>

</div></td>

<td align="right"><table border="0" cellpadding="0" cellspacing="0">

<tr>

<td >



<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>



<td style="padding:0px 0px 0px 5px;" > 



<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>







<script>



function loadsearchClients(){



var clientType = $('#clientType').val();



$('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);



}



</script>



<td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >



<option value="">All Clients</option>







</select></td>



<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="clientType" id="clientType" type="hidden" value="2" />







<input name="report" id="report" type="hidden" value="3" />







<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>



</tr>



</table>



<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />



</td>







</tr>







</table></td>



</tr>







</table>



<script>



loadsearchClients();



</script>



</div>



</form>







<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">







<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>



<div class="norec">Please Select From Date and To Date then Press Search </div>



<?php } else { ?>



<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">



<thead>



<tr>



<th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Client Name</label></th> 



<th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 



<th align="center" class="header">Confirmed</th>



<th align="center" class="header">Reverted</th>



<th align="center" class="header">Assigned</th>



<th align="center" class="header">Sent</th>



<th align="center" class="header">Follow&nbsp;Up</th>



<th align="center" class="header"> Lost</th>



<!-- <th align="center" class="header">TAT&nbsp;followed</th>-->



<th align="center" class="header"> Sales</th>



<th align="center" class="header"  >Gross&nbsp;Margin </th>



<th align="center" class="header"  >Total&nbsp;Pax</th>



<th align="center" class="header"  >No(s)&nbsp;Nights </th>



</tr>



</thead>











<tbody>



<?php 



////////////if assign to is not blank. Comes from search.////////////



if($_REQUEST['Clients']!=''){ 



?>



<tr style="font-size:13px;">



<td align="left" valign="middle"><?php echo showClientTypeUserName(2,$_REQUEST['Clients']); ?></td>



<td align="center" valign="middle"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?> </td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6  ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<!--   <td align="center"></td>-->



<td align="center">







<?php







$suppliertotalcost_sum=0;



$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");



while($res_menu=mysqli_fetch_array($menu)){



$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 



$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 



$result2=mysqli_fetch_array($rs3);  



$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 



$row = mysqli_fetch_assoc($result); 



$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];



}



echo $suppliertotalcost_sum;



?>







</td>



<td align="center" >







<?php



$companytotalcost_sum=0;



$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");



while($res_menu=mysqli_fetch_array($menu)){



$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 



$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 



$result2=mysqli_fetch_array($rs3);  



$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 



$row = mysqli_fetch_assoc($result); 



$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];



}



echo $suppliertotalcost_sum-$companytotalcost_sum;



?>











</td>



<td align="center" ><?php   











$result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 



$row = mysqli_fetch_assoc($result); 



$adultsum = $row['value_sum'];







$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 



$row2 = mysqli_fetch_assoc($result2); 



echo $row2['childsum'];



?></td>



<td align="center" >







<?php   



$result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 



$row3 = mysqli_fetch_assoc($result3); 



echo $row3['nightsum'];



?>







</td>



</tr>







<?php } else {







////////////if assign to is blank comes from report////////////







$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' deletestatus=0 and firstName!=""  group by firstName asc';  



$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<tr style="font-size: 13px;">



<td align="left" valign="middle"><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></td>



<td align="center" valign="middle"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and companyId=".$resListing['id']." and clientType=2 ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);







$queririesTotal=$tquery+$queririesTotal;?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);







$confirmTotal=$tquery+$confirmTotal;?> </td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2 and companyId=".$resListing['id']." and clientType=2 ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);







$revertTotal=$tquery+$revertTotal;?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and companyId=".$resListing['id']." and clientType=2 ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);







$assTotal=$tquery+$assTotal;?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6 and companyId=".$resListing['id']." and clientType=2  ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$stotal=$tquery+$tquery;



?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7 and companyId=".$resListing['id']." and clientType=2 ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$ftotal=$tquery+$ftotal;



?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and companyId=".$resListing['id']." and clientType=2 ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$tlost=$tquery+$tquery;







?></td>



<!--   <td align="center"></td>-->



<td align="center">







<?php







$suppliertotalcost_sum=0;



$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 ");



while($res_menu=mysqli_fetch_array($menu)){



$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 



$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 



$result2=mysqli_fetch_array($rs3);  



$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 



$row = mysqli_fetch_assoc($result); 



$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];



}



echo $suppliertotalcost_sum; $tsales=$suppliertotalcost_sum+$tsales;



?>







</td>



<td align="center" >







<?php



$companytotalcost_sum=0;



$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 ");



while($res_menu=mysqli_fetch_array($menu)){



$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 



$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 



$result2=mysqli_fetch_array($rs3);  



$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 



$row = mysqli_fetch_assoc($result); 



$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];



}



echo $suppliertotalcost_sum-$companytotalcost_sum; $gmargin=$suppliertotalcost_sum-$companytotalcost_sum+$gmargin;



?>











</td>



<td align="center" ><?php   











$result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 "); 



$row = mysqli_fetch_assoc($result); 



$adultsum = $row['value_sum'];



$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 "); 



$row2 = mysqli_fetch_assoc($result2); 



echo $row2['childsum']; $totalpax=$row2['childsum']+$totalpax;



if(trim($row2['childsum'])=='' && $row2['childsum']!='0'){echo '0';}



?></td>



<td align="center" >







<?php   



$result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 "); 



$row3 = mysqli_fetch_assoc($result3); 



echo $row3['nightsum']; $totalnights=$row3['nightsum']+$totalnights;



if(trim($row3['nightsum'])=='' && $row3['nightsum']!='0'){echo '0';}



?>







</td>



</tr> 







<?php } ?>







<!--Total start-->



<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">



<td align="left" valign="middle"><strong>Total</strong></td>



<td align="center" valign="middle"><?php  echo $queririesTotal;?></td>



<td align="center"><?php  echo $confirmTotal;?> </td>



<td align="center"><?php  echo $revertTotal;?></td>



<td align="center"><?php  echo $assTotal;?></td>



<td align="center"><?php  echo $stotal;?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>



<td align="center"><?php  echo $ftotal;?></td>



<td align="center"><?php echo $tlost;?></td>



<!--   <td align="center"></td>-->



<td align="center">







<?php echo $tsales;



?>







</td>



<td align="center" >







<?php echo $gmargin;



?>











</td>



<td align="center" ><?php   echo $totalpax;



?></td>



<td align="center" >







<?php echo $totalnights;



?>







</td>



</tr> 







<!--Total end-->



<?php  }?>



</tbody></table></div>



<div style="text-align:center; margin-top:30px;">



<form method="post" name="downloadrtm" id="downloadrtm" action="allReports/download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>



<script>



function copydatatodata(){



var boxreport = $('#boxreport').html();



$('#reportdata').val(boxreport);  



$('#downloadrtm').submit();  



}



</script>



<?php } ?>



</div>  </td>



</tr>































<?php if($_REQUEST['sp']=='1'){?>  































<tr>



<td width="91%" align="left" valign="top">











</td>



</tr><?php }?>



































</table>



<script> 



window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;







if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');



</script>



<?php }?>
<?php if($_REQUEST['report']=='5'){
$searchField=clean($_GET['searchField']);
$paymentid=clean($_GET['paymentid']);
$paymentstatus=clean($_GET['paymentstatus']);
?>
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- ====================================== -->

<!-- <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/> -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script>
$(function() {
$('input[name="daterange"]').daterangepicker({
"autoApply": true,
opens: 'right',
locale: 
{
format: 'DD-MM-YYYY'
}
}, function(start, end, label) { 
});
});
</script>  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative;">
<tr>
<td width="91%" align="left" valign="top">
<form id="listform" name="listform" method="get">
<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<h3 class="cms_title">&nbsp;&nbsp;Client&nbsp;Payment&nbsp;Pending&nbsp;Report&nbsp;&nbsp;</h3>
<td width="25%"><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> </span>
<div id="deactivatebtn" style="display:none;">
<?php if($deletepermission==1){ ?> 
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
<?php } ?>
</div>
</div>
</td>
<style>
.makeclass{
position: relative;
top: auto;
right: auto;
bottom: auto;
left: auto;
padding: 7px;
border-radius: 42px;
border: 1px solid #ccc;
cursor: pointer;
text-align: center;
}
.h1:hover{
background-color:#4caf50;
color:#fff;
}
.selected{ background-color:#64aefb; color:#fff; }
</style>
<td width="75%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="padding:40px">
<tr style="position: absolute;top:95px;left:408px;">
<!-- <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>
<td style="padding:0px 0px 0px 5px;" > 
<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td> -->
<!-- <td width="6%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d'); ?>&module=reports&report=5&Today=Today">
<input name="todayreport2" type="text" id="todayreport" value="Today" class="  makeclass h1 <?php if($_REQUEST['Today']=='Today') { ?> selected <?php } ?>"  readonly="readonly" style="width:55px"/>
</a></td> -->


<!-- 
<td width="8%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d',strtotime('+1 days')); ?>&module=reports&report=5&tomorrow=tomorrow">



<input name="tomorrowreport" type="text"  id="tomorrow" value="Tomorrow" class="  makeclass h1 <?php if($_REQUEST['tomorrow']=='tomorrow') { ?> selected <?php } ?>"   readonly="readonly" style="width: 76px"/></a></td> -->



<!-- <td width="5%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d',strtotime('+5 days')); ?>&module=reports&report=5&T5=T5" >



<input name="T5" type="T5" id="T5" value="T-5" class="  makeclass h1 <?php if($_REQUEST['T5']=='T5') { ?> selected <?php } ?>"  readonly="readonly"style=" width: 46px;" />



</a></td> -->



<!-- <td width="5%"><input name="searchField" type="text"  class="  makeclass h1" id="searchField" value="<?php echo $searchField; ?>" size="6" maxlength="6" placeholder="Query Id" onKeyUp="numericFilter(this);"/></td> -->





<!-- <td width="59%" style="padding:0px 0px 0px 5px;"></td> -->


<td width="100%">
<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
&nbsp;
<select name="paymentstatus" id="paymentstatus" class="makeclass <?php if($_REQUEST['paymentstatus']=='T5') { ?> selected <?php } ?>">



<option value=""> Select Payment Status</option>



<option value="1" <?php if($_GET['paymentstatus']=='1'){ ?>selected="selected"<?php  } ?>>Paid</option>



<option value="0" <?php if($_GET['paymentstatus']=='0'){ ?>selected="selected"<?php  } ?>>Pending</option>



</select>
<!-- </td>
<td width="20%"> -->
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="report" id="report" type="hidden" value="5" />
&nbsp;
<input type="submit" name="Submit" value="Search" class="   makeclass" style="background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;" /></td>

</tr>



</table></td>



</tr>







</table>



</div>



<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">



<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />



<input name="action" type="hidden" value="paymentdelete" id="action" />

<style>
#example_filter {
position: absolute;
top: -55px;
left: 0%;
}

#example_filter label {
font-size: 18px;
}

#example_filter input {
height: 34px;
width: 306px;
}
</style>

<script>
$(document).ready(function() {



$('#example').DataTable( 
{
dom: 'Bfrtilp',
buttons: [
'copyHtml5',
'excelHtml5',
// 'csvHtml5',
'pdfHtml5'
],
language: { 
search: "Search: ",
searchPlaceholder: "Leadpax name , Destination , Operation Person",
},
}
//   {
//     "order": [[ 1, "asc" ]]
// } 
);
} );
</script>
<table width="100%" border="0" id='example' cellpadding="0" cellspacing="0" class="tablesorter gridtable">
<thead>
<tr>
<th width="192" align="left" class="header">Travel Date </th>



<th width="213" align="left" class="header">query&nbsp;ID </th>



<th width="208" align="left" class="header">Client Name </th>



<th width="211" align="left" class="header">Contact Person</th>



<th width="194" align="left" class="header">Contact Number</th>



<th width="194" align="left" class="header">Total Amount </th>



<th width="252" align="left" class="header">Client&nbsp;Pending&nbsp;Amt</th>



</tr>



</thead>







<tbody>



<?php



$no=1; 



$select='*'; 



$where=''; 



$rs='';  



$wheresearch=''; 



$limit=clean($_GET['records']);



$searchField=clean(trim(ltrim($_GET['searchField'], '0')));



$mainwhere='';



if($searchField!=''){ 



$an2ssg=GetPageRecord('id',_QUERY_MASTER_,'displayId='.$searchField.' order by id desc');



$getidt=mysqli_fetch_array($an2ssg);



$mainwhere=' and  queryId='.$getidt['id'].'';



}



$whereFromDate='';



if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){ 



$fromDate=date('Y-m-d', strtotime($fromDate));



$toDate=date('Y-m-d', strtotime($toDate));



$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';



} 

$fromDate='';
$toDate='';
$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = $myArray[0];
$toDate = $myArray[1];
$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';

// $strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
// $daterangeQuery = 'quotationId in (select id from quotationMaster where status=1 and startDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;

}


$paymentid=clean(trim(ltrim($_GET['paymentid'], '0')));







if($paymentid!=''){



$paymentid=' and  id='.$paymentid.'';



}



$paystatus=''; 



if($paymentstatus!=''){



//$paymentstatus=' and  status='.$paymentstatus.'';



if($paymentstatus==0){



$paystatus='pendingCost>0';



}



if($paymentstatus==1){



$paystatus='pendingCost<1';



}



$paymentstatus=' and id in (select paymentId from '._AGENT_PAYMENT_REQUEST_.' where '.$paystatus.')';



}    



$fromDatetrav='';



if($_REQUEST['fromDatetrav']!=""){   



$fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';



} 







$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where id!="" '.$whereFromDate.' '.$fromDatetrav.' order by fromDate asc) '.$mainwhere.' '.$paymentid.' '.$paymentstatus.'  '; 



$page=$_GET['page'];



$targetpage=$fullurl.'showpage.crm?module=reports&report=5&fromDate='.$_REQUEST["fromDate"].'&toDate='.$_REQUEST["toDate"].'&';



$rs=GetRecordList($select,_PAYMENT_REQUEST_MASTER_,$limit,$where,$page,$targetpage); 

// $rs=GetRecordList($select,_PAYMENT_REQUEST_MASTER_,$where); 


$totalentry=$rs[1]; 



$paging=$rs[2]; 



while($resultlists=mysqli_fetch_array($rs[0])){ 







$an2ss=GetPageRecord('fromDate',_QUERY_MASTER_,'id='.$resultlists['queryid'].' order by id desc');



$getfrmdt=mysqli_fetch_array($an2ss);



?>











<tr> 



<!-- onclick="view('<?php //echo encode($resultlists['id']); ?>');"-->



<?php 



$select12=''; 



$where12=''; 



$rs12='';   



$select12='*';  



$where12='id='.$resultlists['queryid'].''; 



$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 



$editresultdisplay=mysqli_fetch_array($rs12);







?>



<td align="left"><?php if($getfrmdt['fromDate']==''){} else {  echo date("d-m-Y", strtotime($getfrmdt['fromDate'])); }



$select55='*';  



$where55='paymentRequestId='.$resultlists['id'].' order by id desc'; 



$rs55=GetPageRecord($select55,_PAYMENT_LIST_MASTER_,$where55); 



$gettotalcostofpayment=mysqli_fetch_array($rs55);  



?> </td>











<td align="left">



<div class="bluelink" >



<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($editresultdisplay['id']);?>"><?php echo makeQueryId($editresultdisplay['displayId']); ?></a></div></td>







<td align="left"><?php echo showClientTypeUserName($editresultdisplay['clientType'],$editresultdisplay['companyId']); ?></td>







<td align="left">



<?php







$select13=''; 



$where13=''; 



$rs13='';   



$select13='*';  







if($editresultdisplay['clientType']==1){   



$rsc=GetPageRecord('contactPerson','contactPersonMaster',' corporateId="'.$editresultdisplay['companyId'].'" and deletestatus=0 order by id asc');



$resListingc=mysqli_fetch_array($rsc);



echo ($resListingc['contactPerson']);







}



if($editresultdisplay['clientType']==2){



$where13="id='".$editresultdisplay['companyId']."'";



$rs13=GetPageRecord($select13,_CONTACT_MASTER_,$where13); 



$editresultcorporate=mysqli_fetch_array($rs13);



echo $editresultcorporate['firstName'].' '.$editresultcorporate['lastName'];



}







?> </td>



<td align="left"><?php if($editresultdisplay['clientType']==1){     



$rsc=GetPageRecord('*','contactPersonMaster',' corporateId="'.$editresultdisplay['companyId'].'" and deletestatus=0 order by id asc');  $resListingc=mysqli_fetch_array($rsc); 



echo ($resListingc['phone']); }



if($editresultdisplay['clientType']==2){ echo getPrimaryPhone($editresultdisplay['companyId'],'contacts'); } ?></td>











<td align="left"><?php echo($editresultdisplay['totalQueryCost']==0)?'':$editresultdisplay['totalQueryCost'];?></td>











<td align="left"><?php   



$qid = $resultlists['queryid'];



$selectpc='*';    



$wherepc='queryId="'.$qid.'" ';  



$rspc=GetPageRecord($selectpc,_AGENT_PAYMENT_REQUEST_,$wherepc); 



while($resListingpc=mysqli_fetch_array($rspc)){ 



$pendingamount=$resListingpc['pendingCost'];  



}







if($pendingamount<1){



?>



<div style="color:#009900;"> <strong>Paid</strong></div>



<?php } else { ?>



<div style="color:#CC3300;"><strong><?php echo $editresultdisplay['totalQueryCostwithoutpercent']; ?></strong></div>



<?php } ?> </td>



<?php $no++; } ?>



</tbody></table>



<?php if($no==1){ ?>



<div class="norec">No <?php echo $pageName; ?></div>



<?php } ?>



<!-- <div class="pagingdiv">







<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tbody><tr>



<td><table border="0" cellpadding="0" cellspacing="0">



<tr>



<td style="padding-right:20px;"><?php echo $totalentry=$totalentry-$differ;?> entries</td>



<td><select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >



<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>



<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>



<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>



<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>



<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>



</select></td>



</tr>







</table></td>



<td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>



</tr>



</tbody></table>



</div> -->



</div></form>   </td>



</tr>



</table>



<style>



#pagelisterouter {



padding-top: 50px !important;



margin-top: 5px !important;}



</style>



<script> 

$('#fromDate_r').Zebra_DatePicker({



format: 'd-m-Y',  



pair: $('#toDate_r'),



});



$('#toDate_r').Zebra_DatePicker({



format: 'd-m-Y',







});











window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;







if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');





</script>



<?php }?>



<?php if($_REQUEST['report']=='6'){ ?>



<?php



$searchField=clean($_GET['searchField']);



$paymentid=clean($_GET['paymentid']);



$paymentstatus=clean($_GET['paymentstatus']);



if($loginuserprofileId==1){ 



$wheresearchassign=' 1   ';



} else { 



$wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))







or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';



$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';



}



?>



<link href="css/main.css" rel="stylesheet" type="text/css" />



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form id="listform" name="listform" method="get">



<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<h3 class="cms_title">&nbsp;&nbsp;Supplier&nbsp;Payment&nbsp;Pending&nbsp;Report&nbsp;&nbsp;</h3>



<td width="25%"><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> </span>



<div id="deactivatebtn" style="display:none;">



<div id="deactivatebtn" style="display:none;">



<?php if($deletepermission==1){ ?> 







<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />



<?php } ?>



</div>



</div></td>



<td align="right"><table border="0" cellpadding="0" cellspacing="0">



<tr>



<td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>



<td style="padding:0px 0px 0px 5px;" > 



<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>







<td >



<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td style="padding:0px 0px 0px 5px;" ><select name="searchsupId" id="searchsupId" class="topsearchfiledmainselect" style="width:120px; " >



<option value="">All Suppliers</option>



<?php   



$selectsup=''; 



$wheresup=''; 



$rscsup='';  



$selectsup='*';    



$wheresup='1';  



$rscsup=GetPageRecord($selectsup,_SUPPLIERS_MASTER_,$wheresup); 



while($suppliers=mysqli_fetch_array($rscsup)){ 



if($suppliers['name']!=''){ 



?>



<option value="<?php echo $suppliers['id']; ?>" <?php



foreach ($_REQUEST['name'] as $key => $value) {



if($value == $suppliers['id']){



echo 'selected="selected"';



}



}



?>><?php echo $suppliers['name']; ?></option>



<?php }} ?>



</select>



</td>



<!--<td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php //echo $searchField; ?>" size="6" maxlength="6" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>-->



<!--<td style="padding:0px 0px 0px 5px;" > 



<input name="paymentid" type="text"  class="topsearchfiledmain" id="paymentid" style="width:96px;" value="<?php //echo $paymentid; ?>" size="6" maxlength="6" placeholder="Payment Id" onkeyup="numericFilter(this);"/>



</td>-->







<!--<td style="padding:0px 0px 0px 5px;" > 



<select name="paymentstatus" id="paymentstatus" class="topsearchfiledmainselect" style="width:145px; " >



<option value="">Payment Status</option> 



<option value="1" <?php //if($_GET['paymentstatus']=='1'){ ?>selected="selected"<?php  //} ?>>Paid</option>



<option value="0" <?php //if($_GET['paymentstatus']=='0'){ ?>selected="selected"<?php  //} ?>>Pending</option>  







</select>



</td>-->







<td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="6" />



<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>



<td style="padding-right:20px;">&nbsp;</td>



</tr>



</table>



</td>







</tr>







</table></td>



</tr>







</table>



</div>



<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">



<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />



<input name="action" type="hidden" value="paymentdelete" id="action" />



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



<thead>



<tr>



<th width="247" align="left" class="header">payment&nbsp;ID</th>



<th width="271" align="left" class="header">query&nbsp;ID </th>



<th width="486" align="left" class="header">Supplier Name</th>



<th width="228" align="left" class="header">Contact Person</th>



<th width="271" align="left" class="header">Supplier&nbsp;Pending&nbsp;Amount</th>



<!--     <th width="228" align="left" class="header">Payment&nbsp;Reminder&nbsp;Date</th>



-->     <th width="228" align="left" class="header">Travel Date </th>



</tr>



</thead>



<tbody>



<?php



$no=1; 



$select='*'; 



$where=''; 



$rs='';  



$wheresearch=''; 



$limit=10000;



$searchField=clean(trim(ltrim($_GET['searchField'], '0')));



$mainwhere='';



if($searchField!=''){



$mainwhere=' and  queryId='.$searchField.'';



}



$whereFromDate='';



if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){ 



$fromDate=date('Y-m-d', strtotime($fromDate));



$toDate=date('Y-m-d', strtotime($toDate));



$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';



}    



$paymentid=clean(trim(ltrim($_GET['paymentid'], '0')));



if($paymentid!=''){



$paymentid=' and  id='.$paymentid.'';



}



$supplierid='';



if($_REQUEST['searchsupId']!=''){



$supplierid=' and  id='.$_REQUEST['searchsupId'].'';



}



if($paymentstatus!=''){



$paymentstatus=' and  status='.$paymentstatus.'';



}    



$fromDatetrav='';



if($_REQUEST['fromDatetrav']!=""){   



$fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';



}     



//$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where '.$wheresearchassign.' ) '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc'; 



$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where deletestatus=0 '.$whereFromDate.' '.$fromDatetrav.') '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc';



$page=$_GET['page'];



$targetpage=$fullurl.'showpage.crm?module=paymentrequest&records='.$limit.'&searchField='.$searchField.'&';



$rs=GetRecordList($select,_PAYMENT_REQUEST_MASTER_,$where,$limit,$page,$targetpage); 



$totalentry=$rs[1]; 



$paging=$rs[2]; 



while($resultlists=mysqli_fetch_array($rs[0])){ 



//print_r($resultlists);



$select2='*';



$where2='paymentId='.clean($resultlists['id']).' and companyTypeId!=0 order by id desc limit 0,1'; 



$rs2=GetPageRecord($select2,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2); 



while($listofsuppliers=mysqli_fetch_array($rs2)){



$paymentdate = $listofsuppliers['paymentdate'];



$paymentreminderdate = $listofsuppliers['paymentreminderdate'];



}



$tatalpayment=0;



$select22='*';



$where22='paymentRequestId='.$resultlists['id'].' order by id ASC'; 



$rs22=GetPageRecord($select22,_PAYMENT_LIST_MASTER_,$where22); 



while($listofpayment=mysqli_fetch_array($rs22)){



$tatalpayment=$tatalpayment+$listofpayment['amount'];



}



$totalpaymentpending=0;



$select222='*';



$where222='paymentId='.$resultlists['id'].' order by id desc'; 



$rs222=GetPageRecord($select222,_PAYMENT_SUPPLIER_LIST_MASTER_,$where222); 



while($listofsuppliers=mysqli_fetch_array($rs222)){



$totalpaymentpending=$totalpaymentpending+$listofsuppliers['companytoalcost'];



} 



//////////////////////////////get supplier name,contactPerson from suppliersMaster/////////////////////



$rs122=GetPageRecord('id','paymentRequestMaster','queryid="'.$resultlists['queryid'].'"'); 



$getpaymentId=mysqli_fetch_array($rs122); 



$rs1222=GetPageRecord('supplierId','paymentRequestPayment ','paymentRequestId="'.$getpaymentId['id'].'"'); 



$getsupId=mysqli_fetch_array($rs1222); 



$rs12222=GetPageRecord('name,contactPerson','suppliersMaster ','id="'.$getsupId['supplierId'].'" '.$supplierid.''); 



$getsuplist=mysqli_fetch_array($rs12222);



if($getsuplist['name']!=''){



?>



<tr>



<td align="left" class="bluelink"><?php echo makePaymentId($resultlists['id']); ?>   



</td>



<td align="left"><?php if($getfrmdt['fromDate']==''){} else {  echo date("d-m-Y", strtotime($getfrmdt['fromDate'])); }



$select12=''; 



$where12=''; 



$rs12='';   



$select12='*';  



$where12='id='.$resultlists['queryid'].''; 



$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 



$editresultdisplay=mysqli_fetch_array($rs12);







?>



<a class="bluelink" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($editresultdisplay['id']); ?>" ><?php  



echo makeQueryId($editresultdisplay['displayId']); ?>    



</a>



</td>



<td align="left"><?php



echo $getsuplist['name']; 



?></td>



<td align="left" > <?php



echo $getsuplist['contactPerson']; 



?></td>



<td align="left">



<strong> <?php if($resultlists['supplierPendingamount']!=0){ ?>



<div style="color:#CC3300;"><?php echo $resultlists['supplierPendingamount']; ?></div><?php } else {  ?></strong>



<div style="color:#009900;">



<strong>Paid</strong></div>



<strong></strong><strong>



<?php } ?>    



</strong> </td>



<td align="left" ><?php 



$select12=''; 



$where12=''; 



$rs12='';   



$select12='*';  



$where12='id='.$resultlists['queryid'].''; 



$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 



$travelDate=mysqli_fetch_array($rs12);



echo $travelDate['fromDate']; ?>     </td>



</tr> 



<?php   $no++;  }} ?>



</tbody></table>



<?php if($no==1){ ?>



<div class="norec">No <?php echo $pageName; ?></div>



<?php } ?>



<div class="pagingdiv">







<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tbody><tr>



<td><table border="0" cellpadding="0" cellspacing="0">



<tr>



<td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>



<td><select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >



<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>



<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>



<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>



<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>



<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>



</select></td>



</tr>







</table></td>



<td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>



</tr>



</tbody></table>



</div>



</div></form>   </td>



</tr>



</table>



<script>



$('#fromDate_r').Zebra_DatePicker({



format: 'd-m-Y',  



pair: $('#toDate_r'),



});



$('#toDate_r').Zebra_DatePicker({



format: 'd-m-Y',







});







window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;







if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');



</script>



<?php }?>







<?php if($_REQUEST['report']=='9'){ ?>



<?php



$searchField=clean($_GET['searchField']);



$invoiceid=clean($_GET['invoiceid']);



$fromDate=$_GET['fromDate'];



$toDate=$_GET['toDate'];



$assignto=$_GET['assignto'];



$destinationId=$_GET['destinationId'];



$categoryId=$_GET['categoryId'];



$tourType=$_GET['tourType'];



$clientType=$_GET['clientType'];



$clients=$_GET['Clients'];



if($assignto!=''){  



$strWhere.=' and assignTo='.$assignto.'';



}



if($destinationId!=''){  



$strWhere.=' and destinationId='.$destinationId.'';



}



if($categoryId!=''){  



$strWhere.=' and categoryId='.$categoryId.'';



}



if($tourType!=''){  



$strWhere.=' and tourType='.$tourType.'';



}



if($clientType!=''){  



$strWhere.=' and clientType='.$clientType.'';



}



if($Clients!=''){  



$strWhere.=' and companyId='.$Clients.'';



}



?>



<link href="css/main.css" rel="stylesheet" type="text/css" />



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form id="listform" name="listform" method="get">



<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<h3 class="cms_title" style="padding-left:70px"> &nbsp;&nbsp;Tax&nbsp;Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<td width="25%"><div class="headingm" style="margin-left:6px;"  ><span id="topheadingmain"></span>



<div id="deactivatebtn" style="display:none;">



<div id="deactivatebtn" style="display:none;">



<?php if($deletepermission==1){ ?> 







<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />



<?php } ?>



</div>







</div></td>



<td align="right"><table border="0" cellpadding="0" cellspacing="0">



<tr>



<td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate_r" style="width:80px;" size="6" placeholder="From"  value="<?php if($_GET['fromDate']!=''){ echo  date('d-m-Y', strtotime($_GET['fromDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>



<td><input name="toDate" type="text"  class="topsearchfiledmain" id="toDate_r" style="width:80px;" size="6" placeholder="To" value="<?php if($_GET['toDate']!=''){ echo  date('d-m-Y', strtotime($_GET['toDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>

<td>
<select name="client" id="" class="topsearchfiledmainselect" style="width:120px; ">
<option value="">Select Client</option>
<?php
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and name!="" and companyTypeId=1 order by name asc';  
$rs=GetPageRecord($select,_CORPORATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['client']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php }
?>
</select>
</td>

<td >



<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>







<td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="9" />



<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>  



<td style="padding-right:20px;">&nbsp;</td>



</tr>



</table>



</td>







</tr>







</table></td>



</tr>



</table>



</div>



</form>







<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">



<div id="margin">
<?php
$outputTax=''; 
$outputTax='<table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">



<thead>



<tr>



<th width="109" align="center" class="header">Query&nbsp;ID</th> 



<th width="109" align="center" class="header"> Invoice No.</th>



<th width="96"  align="center" valign="middle" class="header">Invoice Date</th> 



<th width="40" align="center" class="header"> Client</th>



<th width="43" align="center" class="header"> GSTN</th>



<th width="43" align="center" class="header"> Sale&nbsp;Amount</th>



<th width="41" align="center" class="header">IGST </th>



<th width="43" align="center" class="header"> CGST</th>



<th width="44" align="center" class="header">SGST </th>



</tr> 



</thead>



<tbody>';











$n=1; 



$select='*'; 



$where=''; 



$rs=''; 



$wheresearch=''; 



//$where='1 order by id desc';







$limit=clean($_GET['records']);



$searchField=clean(trim(ltrim($_GET['searchField'], '0')));



$mainwhere='';



if($searchField!=''){



$mainwhere=' and  queryId='.$searchField.'';



}



$strWhere='';



if($fromDate!='' && $toDate!=''){



$fromDate = date('Y-m-d', strtotime( $fromDate ));



$toDate = date('Y-m-d', strtotime( $toDate ));



$strWhere.='and invoicedate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus = 0';



}



$fromDatetrav='';



if($_REQUEST['fromDatetrav']!=""){     



$fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';



} 



$invoiceid=clean(trim(ltrim($_GET['invoiceid'], '0')));







if($invoiceid!=''){



$invoiceid=' and  id='.$invoiceid.'';



}



$profileiddata='';   



if($loginuserprofileId=='48'){







$profileiddata=' and  queryId in (select id from miceMaster where companyId in ( select companyId from userMaster where id="'.$_SESSION['userid'].'"))';



}

$whereClient='';
if(isset($_REQUEST['client']) && $_REQUEST['client']!='')
{
$whereClient = ' and queryId in (select id from queryMaster where companyId="'.$_REQUEST['client'].'")';
}

$where=' 1 and mice=0 '.$mainwhere.' '.$invoiceid.' '.$strWhere.' '.$fromDatetrav.' '.$profileiddata.' and invoicedate!="0000-00-00" '.$whereClient.' order by id asc'; 



$page=$_GET['page'];



$targetpage=$fullurl.'showpage.crm?module=invoice&records='.$limit.'&searchField='.$searchField.'&';







$rs=GetPageRecord('*',_INVOICE_MASTER_,$where,$limit,$page,$targetpage);



while($resultlists=mysqli_fetch_array($rs)){



//print_r($resultlists); 



// $pid = $resultlists['id'];



?>



<?php 



$rs1=GetPageRecord('companyId,clientType','queryMaster','id="'.$resultlists['queryId'].'" '); 



$getqueryId=mysqli_fetch_array($rs1);



//echo $getqueryId['clientType'];



if($getqueryId['clientType']==1){



$rs2=GetPageRecord('name','corporateMaster ','companyTypeId="'.$getqueryId['companyId'].'"'); 



$getcompanyid=mysqli_fetch_array($rs2);



//echo $getcompanyid['companyTypeId'];



$getClientName=$getcompanyid['name'];



}  







if($getqueryId['clientType']==2){



$rs3=GetPageRecord('firstName','contactsMaster ','id="'.$getqueryId['companyId'].'"'); 



$getclientlist=mysqli_fetch_array($rs3);



// print_r($getclientlist);



$getClientName=$getclientlist['firstName'];



}







//////////////////////////////////get all gst ///////////////////////////







$select1=''; 



$where1=''; 



$rs1='';   



$select1='*';  



$where1='queryid="'.$resultlists['queryId'].'" order by id desc'; 



$rs1=GetPageRecord($select1,_PAYMENT_REQUEST_MASTER_,$where1); 



$resultpaymentpage=mysqli_fetch_array($rs1);







$select2=''; 



$where2=''; 



$rs2='';   



$select2='*';  



$where2='paymentId="'.$resultpaymentpage['id'].'"  order by id desc'; 



$rs2=GetPageRecord($select2,_AGENT_PAYMENT_REQUEST_,$where2); 



$requesetdata=mysqli_fetch_array($rs2);







$Totalsaleamount = $Totalsaleamount+$requesetdata['finalCost'];



//print_r($requesetdata);



$reqclientGst=$requesetdata['reqclientGst'];



$reqmarginGst=$requesetdata['reqmarginGst'];







if($reqclientGst!=0){



$GST=$requesetdata['reqclientGst'];



$Cgst=$requesetdata['reqclientCGst'];



$Sgst=$requesetdata['reqclientSGst'];



$Igst=$requesetdata['reqclientIGst'];



$finalReqCost=$requesetdata['reqclientCost'];



///////start get total/////////////



$TotalIgst = $TotalIgst+round(($Igst*$requesetdata['reqclientCost'])/100);



$TotalCgst = $TotalCgst+round(($Cgst*$requesetdata['reqclientCost'])/100);



$TotalSgst = $TotalSgst+round(($Sgst*$requesetdata['reqclientCost'])/100);



/////end get total/////////



}







if($reqmarginGst!=0){



$GST=$requesetdata['reqmarginGst'];



$Cgst=$requesetdata['reqmarginCGst'];



$Sgst=$requesetdata['reqmarginSGst'];



$Igst=$requesetdata['reqmarginIGst'];



$finalReqCost=$requesetdata['reqmarginCost'];



} 



//////////////////////////////////end gst code here////////////////////         











$outputTax.='<tr>';



$outputTax.='<td align="center"><a href="showpage.crm?module=query&view=yes&id='.encode($resultlists['queryId']).'">'.makeQueryId($resultlists['id']).'</a></td>';



$outputTax.='<td align="center"><div class="bluelink">';







if($resultlists['docName']!=''){ 



$outputTax.='<a href="dirfiles/'.$resultlists['docName'].'" target="_blank">INV'.makeInvoiceId($resultlists['id']).'</a>';



} else { 



$outputTax.='<a href="tcpdf/examples/getpdf.php?pageurl='.$fullurl.'invoicepdf.php?id='.encode($resultlists['id']).'&mice='.$resultlists['mice'].'" target="_blank">';
if($resultlists['invoiceType']=='1'){ $outputTax.='INV'; } else { $outputTax.='PER'; }
$outputTax.=makeInvoiceId($resultlists['id']).'</a>';



}  $outputTax.='</div></td>';



$outputTax.='<td align="center">';
if($resultlists['invoicedate']!=''){ $outputTax.=showdate($resultlists['invoicedate']);}
$outputTax.='</td>';



$outputTax.='<td align="center" >';



$select2='companyId,clientType'; 



$where2='id="'.$resultlists['queryId'].'"'; 



if($resultlists['mice']=='0'){



$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2); 



} else { 



$rs2=GetPageRecord($select2,'miceMaster',$where2);  



}



$queryCompany=mysqli_fetch_array($rs2); 



$outputTax.=showClientTypeUserName($queryCompany['clientType'],$queryCompany['companyId']); 



$outputTax.='</td>';



$outputTax.='<td align="center">';



if($getqueryId['clientType']==1){ 



$resulttype='corporate';



}if($editresult['clientType']==2){ 



$resulttype='contacts';



}



if($resulttype!=''){



$select6='*';  



$where6='addressType="'.$resulttype.'" and addressParent="'.$queryCompany['companyId'].'"'; 



$rs6=GetPageRecord($select6,_ADDRESS_MASTER_,$where6); 



$address=mysqli_fetch_array($rs6); 



$outputTax.=$address['gstn'];  
}
$outputTax.='</td>';







$outputTax.='<td align="center">'.$requesetdata['finalCost'].'</td>'; 



$outputTax.='<td align="center">';
if($Igst!=0){ $outputTax.=(($Igst*$requesetdata['reqclientCost'])/100); } 
$outputTax.='</td>'; 



$outputTax.='<td align="center">';
if($Sgst!=0){ $outputTax.=(($Cgst*$requesetdata['reqclientCost'])/100); }
$outputTax.='</td>';



$outputTax.='<td align="center">';
if($Sgst!=0){ $outputTax.=(($Sgst*$requesetdata['reqclientCost'])/100); }
$outputTax.='</td>';  



$outputTax.='</tr>';



} $n++;



//     <!--Total start-->



$outputTax.='<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">';



$outputTax.='<td align="center" valign="middle"><strong>Total</strong></td>';



$outputTax.='<td align="center" valign="middle">&nbsp;</td>';



$outputTax.='<td align="center">&nbsp;</td>';



$outputTax.='<td align="center">&nbsp;</td>';



$outputTax.='<td align="center">&nbsp;</td>';



$outputTax.='<td align="center">'.$Totalsaleamount.'</td>';



$outputTax.='<td align="center">'.$TotalIgst.'</td>';



$outputTax.='<td align="center">'.$TotalCgst.'</td>';


$outputTax.='<td align="center">'.$TotalSgst.'</td>';



$outputTax.='</tr>'; 







// <!--Total end-->



$outputTax.='</tbody>';



$outputTax.='</table>';

echo $outputTax;
?>

</div>



<div style="text-align:center; margin-top:30px;">



<!-- <form method="post" name="downloadmargin" id="downloadmargin" action="download_marginreport.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Margin Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="marginreport" id="marginreport" cols="" rows="" style=" display:none;"></textarea></form></div> -->
<form method="post" action="allReports/xlReoprtDownload.php" target="actoinfrm">
<input type="hidden" name="filename" value="tax_report">
<input type="hidden" name="output" value="<?=base64_encode($outputTax)?>">
<input type="submit" name="export" class="bluembutton" value="Download Report">
</form>


<script>



function copydatatodata(){



var margin = $('#margin').html();



$('#marginreport').val(margin);  



$('#downloadmargin').submit();  



}



</script>



<script>



$('#fromDate_r').Zebra_DatePicker({



format: 'd-m-Y',  



pair: $('#toDate_r'),



});



$('#toDate_r').Zebra_DatePicker({



format: 'd-m-Y',







});







window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;







if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');



</script>



<?php }?> 


<!--=============================== client feedback report starts =========================-->
<?php if($_REQUEST['report']=='14'){
	?>

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script>
		$(function(){

				$('input[name="daterange"]').daterangepicker({

				"autoApply": true,
				opens: 'right',
				locale: {
				format: 'DD-MM-YYYY'
				}
				}, function(start, end, label) { 
				});
				}
				);

	</script>

	<?php 

$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']); 
$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate']; 
// $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

<h3 class="cms_title">Feedback Report Mobile</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;left: 20.5%;">Expand</span>

<td width="91%" align="left" valign="top">

<form method="get">

<div class=""><table width="70%" border="0" cellpadding="0" cellspacing="0">

<tr>

<td>

<div class="headingm" style="margin-left:30px;">
<!-- 
<span id="topheadingmain"><a href="showpage.crm?module=reports"><img src="images/backicon.png" width="20" style=" cursor:pointer;" /></a>&nbsp;Client Feedback report</span> -->

<div id="deactivatebtn" style="display:none;">
<?php if($deletepermission==1){ ?> 
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />

<?php } ?>
</div>

</div>

</td>

<td align="">

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="position: absolute; right: 10px;width: 25%;z-index: 9999;">

<tr>

<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>

<td style="padding-right:20px;">
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input type="submit" name="Submit" value="Search" class="searchbtnmain" />

<input name="report" id="report" type="hidden" value="14" />    
<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />

</td>

</tr>

</table>

</td>


</tr>
</table>



</div>

</form>

<div id="" style="padding-left:6px;">



<style>

#margin table th{



padding-bottom: 12px !important;



background-color: #233a49 !important;



color: #fff !important;



font-size: small;



font-family: sans-serif;
} 
#example_wrapper{
	width: 32.5%;
}

#example_filter{
	position:absolute;
	top: 10px;;

}

</style>



<div id="margin" style="width:3312px!important;">



<table width="100%" border="1" cellpadding="8" cellspacing="0" class="table table-striped table-bordered" id="example" style="width:44%; margin-top: 48px !important;font-size: small; "> 



<thead> 



<tr>



<th width="13%"  align="left" valign="middle" class="header"><label for="checkAll">



<div align="left">QUERY ID</div>



</label></th>



<th width="13%" align="left" class="header"><div align="left">TRAVEL&nbsp;DATE</div></th>

<th width="13%" align="left" class="header"><div align="left">SERVICE&nbsp;NAME</div></th>

<th width="13%" align="left" class="header"><div align="left">FEEDBACK&nbsp;DATE</div></th>



<th width="13%" align="left" class="header"><div align="left">CLIENT&nbsp;RATING</div></th>



<th width="13%" align="left" class="header"><div align="left">CLIENT&nbsp;EXPERIENCE</div></th>



<th width="13%" align="left" class="header"> <div align="left">IMAGE</div></th>



<th width="13%" align="left" class="header"> <div align="left">FULL&nbsp;NAME</div></th>



<th width="13%" align="left" class="header"> <div align="left">CONTACT&nbsp;NUMBER</div></th> 



<th width="13%" align="left" class="header"> <div align="left" style="margin-left: 1px;">EMAIL</div></th>



<th width="13%" align="left" class="header"> <div align="left">OPERATION&nbsp;PERSON</div></th>



<th width="13%" align="left" class="header"> <div align="left">DESTINATION</div></th>



<th width="13%" align="left" class="header"> <div align="left">SOURCE</div></th>



</label></th> 



</tr>



</thead>



<tbody>



<?php 



$n=0;       



$strWhere=''; 



$multiSearch='';



$multiSearch=clean($_GET['multiSearch']);  

if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate )); 
$strWhere='and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"';

}

if($_GET['daterange']!=''){
	$str = $_GET['daterange'];
	$array = explode(' - ',$str);
	$fromDate = $array['0'];
	$toDate = $array['1'];

	$fromDate = date('Y-m-d', strtotime( $fromDate ));
	$toDate = date('Y-m-d', strtotime( $toDate )); 
	$strWhere='and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"';

}

$select='*'; 



$where='';



//$where=' '.$strWhere.' deletestatus=0 order by id desc ';



$where='1 '.$strWhere.' order by id desc ';



$rs=GetPageRecord($select,'clientfeedbackmaster',$where);  



while($resultlist=mysqli_fetch_array($rs)){ 

?>

<tr>



<td width="100" align="left"> <div align="left"><?php $feedqueryId=makeQueryId($resultlist['queryId']);



$where11='id="'.$resultlist['queryId'].'"'; 



$rs11=GetPageRecord('*',_QUERY_MASTER_,$where11); 



$displayId=mysqli_fetch_array($rs11);



echo makeQueryId($displayId['displayId']);



?></div></td>



<td width="100" align="left"> <div align="left"><?php 



$an2ss=GetPageRecord('fromDate',_QUERY_MASTER_,'id="'.$resultlist['queryId'].'" order by id desc');



$getfrmdt=mysqli_fetch_array($an2ss);



if($getfrmdt['fromDate']==''){} else { echo date("d-m-Y", strtotime($getfrmdt['fromDate']));}



?></div></td>

<td width="100" align="left"> <div align="left"><?php 
if($resultlist['serviceId']!='' && $resultlist['serviceId']!=0){
$rss=GetPageRecord('supplierId','quotationHotelMaster','id="'.$resultlist['serviceId'].'"');
while($hotellisting=mysqli_fetch_array($rss)){

$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
$hoteldetail=mysqli_fetch_array($rs1ee); 
$hotelName=strip($hoteldetail['hotelName']);
echo $hotelName;
}
}else{
echo "Overall";    
}
?></div></td>

<td width="100" align="left"> <div align="left"><?php echo date($resultlist['feedbackDate']);?></div></td>

<td width="100" align="left"> <div align="left" style='font-size:16px;'><?php if($resultlist['clientrating']==1){echo "Sad&#128546;";}elseif($resultlist['clientrating']==2){ echo "Neutral&#128528;";}elseif($resultlist['clientrating']==3){ echo "Happy&#128522";}?></div></td>

<td width="100" align="left"> <div align="left" style="overflow-y:scroll;height: 40px;width: 168px;"><?php echo stripslashes($resultlist['clientexperience']);?></div></td>

<td width="100" align="left"> <div align="left"><?php if($resultlist['feedbackImage']!=''){ ?><img src="dirfiles/<?php echo $resultlist['feedbackImage']; ?>" width="75" height="58" /><?php } ?></div></td>







<?php



$clientType=$resultlist['clientType'];



if($clientType==2){



$select22='*';  



$where22='id="'.$resultlist['companyId'].'"'; 



$rs22=GetPageRecord($select22,_CONTACT_MASTER_,$where22); 

$contantnamemain2=mysqli_fetch_array($rs22);

$clientnem2 = $contantnamemain2['firstName'].' '.$contantnamemain2['lastName'].'<br/>';



$getphone2 =  getPrimaryPhone($contantnamemain2['id'],'contacts').'<br/>';



$getemail2 =  getPrimaryEmail($contantnamemain2['id'],'contacts').'<br/>';



}else{



$select22='*';  



$where22='id="'.$resultlists['companyId'].'"'; 



$rs22=GetPageRecord($select22,_CORPORATE_MASTER_,$where22); 



$contantnamemain2=mysqli_fetch_array($rs22);

$clientnem2 = $contantnamemain2['name'].'<br/>';



$getphone2 =  getPrimaryPhone($contantnamemain2['id'],'corporate').'<br/>';



$getemail2 =  getPrimaryEmail($contantnamemain2['id'],'corporate').'<br/>';



}



?>

<td width="100" align="left"> <div align="left"><?php if($clientType==2){ echo $clientnem2; }else { echo $clientnem2 ;}?></div></td>



<td width="100" align="left"> <div align="left"><?php if($clientType==2){ echo $getphone2; }else { echo $getphone2 ;}?></div></td>



<td width="100" align="left"> <div align="left"><?php if($clientType==2){ echo $getemail2; }else { echo $getemail2 ;}?></div></td>



<?php 



$select1='*';    



$where1='companyId="'.$resultlists['companyId'].'"';  



$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 



$usermasterData=mysqli_fetch_array($rs1);



$operationperson=$usermasterData['firstName'].''.$usermasterData['lastName'];



?>



<td width="100" align="left"> <div align="left"><?php echo $operationperson; ?></div></td>



<td width="100" align="left"> <div align="left"><?php 



$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$resultlist['quotationId'].'" order by id asc'); 



$QueryDaysData=mysqli_fetch_array($QueryDaysQuery); 



$destn = getDestination($QueryDaysData['cityId']);



echo $destn;



?></div></td>



<td width="100" align="left"> <div align="left"><?php if($resultlist['feedBackForm']==1){echo 'Phone';}else{echo 'Email';} ?></div></td>



</tr>



<?php $n++; } ?>



</tbody>



</table>



</div>



</div>



<div style="text-align:center; margin-top:30px;">

<script>



function copydatatodata(){



var margin = $('#margin').html();



$('#marginreport').val(margin);  



$('#downloadmargin').submit();  

}

</script>



</td>



</tr>



</table>

<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
'copyHtml5',
'excelHtml5',
// 'csvHtml5',
'pdfHtml5'
],
language: { 
search: "Search : ",
searchPlaceholder: "Serach By Keyword",
},
}
);
});
</script>

<script> 



// window.setInterval(function(){ 



// checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
// if(!checked) { 

// $("#deactivatebtn").hide();



// $("#topheadingmain").show();



// } else {



// $("#deactivatebtn").show();



// $("#topheadingmain").hide();



// } 



// }, 100);



comtabopenclose('linkbox','op2');



</script>



<?php }?>



<!-- client feedback report ended -->

<!-- Online Feedback Report Start-->

<?php 

if($_REQUEST['report']=='61'){ 
?>
	<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

	<link href="css/datatablec.css" rel="stylesheet"/>
	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	
	
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<script src="js/zebra_datepicker.js?id=<?php echo time(); ?>"></script> 
 
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	
	<!-- DataTables Export button links -->
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

	<script>
		$(function(){

				$('input[name="daterange"]').daterangepicker({

				"autoApply": true,
				opens: 'right',
				locale: {
				format: 'DD-MM-YYYY'
				}
				}, function(start, end, label) { 
				});
				}
				);

	</script>

<?php

$searchField=clean($_GET['searchField']);

$invoiceid=clean($_GET['invoiceid']); 

$fromDate=$_GET['fromDate'];

$toDate=$_GET['toDate']; 

?>

<link href="css/main.css" rel="stylesheet" type="text/css" />

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="91%" align="left" valign="top">
<h3 class="cms_title">Online Feedback Report</h3>
				&nbsp;<span class="doExpand" id="Expand123" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

				<script>
					$(document).ready(function(){

				$("#Expand123").click(function(){
					
				if($(this).hasClass('Expanduserwise')){
				$(".OverFlowHidden ").css("width","100%");
				$(this).removeClass('Expanduserwise');
				}
				else{
				$(".OverFlowHidden").css("width","100%");
				$(this).addClass('Expanduserwise');
				}
				});
			});
				</script>
			
			<form method="get">
			<div class="" style="width:3060px;">
				<table width="70%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			

		<td align=""><table border="0" cellpadding="0" cellspacing="0" style="width: 48%;">
		<tr>
		<td >
		<table align="right" border="0" cellpadding="0" cellspacing="0" style="padding:15px 40px">
		<tr>

		<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>

			<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

			<input type="submit" name="Submit" value="Search" class="searchbtnmain" />
			<input name="report" id="report" type="hidden" value="61" />    

			</td>
			</tr>
		</table>
		<input name="reportSubmit" id="reportSubmit" type="hidden" value="61" />
			</td>
		</tr>
		</table></td>
		</tr>
		</table>
		<script>

		loadsearchClients();
		</script>
		</div>
	</form>	

	<div id="" style="padding-left:6px;">
	<style>

#example_wrapper .row{padding:20px !important;}



#margin {border:1px #eee solid !important;}



#margin table td{border-bottom:1px #eee solid !important; padding:8px !important;}



#margin table th{



padding-bottom: 12px !important;



background-color: #233a49 !important;



color: #fff !important;



font-size: small;



font-family: sans-serif;

}

#example_wrapper .col-sm-6 .form-control{margin-left:5px;}  



#example_wrapper .dataTables_length{display:none;}



.dataTables_info{ display:none;}    



.paging_simple_numbers ul{ padding:0px; margin:0px; }



.pagination ul li{    float: left;



list-style:none !important;}



.dataTables_filter{    margin-top: -24px;



margin-left: 1206px;}



.dataTables_filter input{



padding:4px;



}



.dataTables_length{    margin-left: 250px;



margin-top: -25px;



}



.dataTables_length select { padding:4px;}



.dataTables_paginate ul li{    float: left;



padding: 5px;



list-style: none;



border: 1px solid #2bb0dd;}



.dataTables_paginate ul li active{ background-color:#000;}



.paginate_button page-item active{ background-color:#2bb0dd;}



.dataTables_paginate{    margin-right: 0px;



margin-top: -25px;



margin-left: 1251px;}



.pagination> li.active {



z-index: 2;



color: #fff;



cursor: default;



background-color: #337ab7;



border-color: #337ab7;



}



.pagination> li.active>a {



color: #fff !important;



}

.table a{ color:#fff;} 

#example_wrapper{
	width: 35.3%;
}
.dt-buttons {
    width: 330px;
    margin: 30px auto;
}
.dataTables_paginate{
	width: 28%;
	margin-top: 1px;
}
#example_filter{
	width: 260px;
    float: left;
    margin-left: -26px;
	margin-top: -46px;
	font-size: 15px;
}
#example_filter input{
	padding: 8px;
}
</style>
<!-- Mausam Code -->
	<table border="1" cellpadding="8" cellspacing="0" class="table table-striped table-bordered" id="example" style="width:100%; margin-top: 3px !important;font-size: small; border-collapse: collapse;border-color: #d1d1d1; overflow:scroll;"> 
		<thead style="background-color: #000; color:#fff;"> 
			<tr>
			<th align="left" valign="middle" class="header"><label for="checkAll">
			<div align="left">TOUR&nbsp;ID</div></label></th>
			<th align="center" class="header"><div align="left">TOUR&nbsp;DATE</div></th>
			<th align="center" class="header"><div align="left">AGENT&nbsp;NAME</div></th>
			<th align="center" class="header"><div align="left">OVERALLRATING&nbsp;</div></th>
			<th align="center" class="header"><div align="left">OPERATION&nbsp;PERSON</div></th>
			<th align="center" class="header"><div align="left">SALES&nbsp;PERSON</div></th>
			<th align="center" class="header"> <div align="left">FEEDBACK&nbsp;DATE</div></th>
			<th align="center" class="header"> <div align="left">VIEW&nbsp;FEEDBACK</div></th>
			
			
			</tr>
		</thead>
		<tbody class="tbpdding">

			<?php 
			$n=0;       
			$strWhere=''; 
			$multiSearch='';
			$multiSearch=clean($_GET['multiSearch']);  

			if($fromDate!='' && $toDate!=''){
    			$fromDate = date('Y-m-d', strtotime( $fromDate ));
    			$toDate = date('Y-m-d', strtotime( $toDate )); 
    			$strWhere='and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"';
			}

			if($_GET['daterange']!=''){
				$str = $_GET['daterange'];
				$arry = explode(' - ', $str);
				$fromDate = $arry['0'];
				$toDate = $arry['1'];

				$fromDate = date('Y-m-d', strtotime( $fromDate ));
    			$toDate = date('Y-m-d', strtotime( $toDate )); 
    			$strWhere='and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"';
			}

			$select='*'; 
			$where='';
			$where=' 1 and queryId!=""  and rating!="" '.$strWhere.' order by id desc';
			$rs=GetPageRecord($select,'onlineFeedbackMaster',$where);  
			while($resultlist=mysqli_fetch_array($rs)){ 

				
	if($resultlist['clientType']=='1'){

    $select4='*';

    $where4='id='.$resultlist['companyId'].'';

    $rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4);

    $contantnamemain=mysqli_fetch_array($rs4);

    $mobilemailtype='corporate';

    $clientnem = getCorporateCompany($contantnamemain['id']);


    }

			if($resultlist['clientType']=='2'){

			$select4='*';

			$where4='id='.$resultlist['companyId'].'';

			$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4);

			$contantnamemain=mysqli_fetch_array($rs4);

			$mobilemailtype='contacts';

			$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
			}

			$requery=GetPageRecord('*',_QUERY_MASTER_,'id="'.$resultlist['queryId'].'"');
			$queryData=mysqli_fetch_array($requery);
			?>
		<tr>
			<td width="100" align="left">
				 <div align="left">
					<a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($resultlist['queryId']); ?>&b2bquotation=1"><?php echo makeQueryTourId($resultlist['queryId']); ?></a>
					
				</div>
			</td>

		<td width="100" align="left"> <div align="left"><?php 
			
			if($queryData['fromDate']==''){} else { echo date("d-m-Y", strtotime($queryData['fromDate']));}
			?>
			</div>
		</td>
		<td><?php echo $clientnem; ?></td>
		<td width="100" align="left"> <div align="left" style='font-size:16px;'>
			<?php if($resultlist['rating']==1){echo "Poor";}elseif($resultlist['rating']==2){ echo "Average";}elseif($resultlist['rating']==3){ echo "Good";}elseif($resultlist['rating']==4){ echo "Very Good";}elseif($resultlist['rating']==5){ echo "Excellent";}?>
		</div>
		</td>
		<td width="100" align="left"> <div align="left"><?php 
			  
			$whereops='id="'.$queryData['assignTo'].'"';  
			$rs1=GetPageRecord('*',_USER_MASTER_,$whereops); 
			$usermasterData=mysqli_fetch_array($rs1);
			echo $operationperson = $usermasterData['firstName'].''.$usermasterData['lastName'];
			?></div>
		</td>

		<td width="100" align="left"> <div align="left"><?php echo $queryData['salesassignTo']; ?></div></td>

		<td><?php echo date('d-m-Y',strtotime($resultlist['feedbackDate'])); ?></td>

		<td width="100" align="left"><a target="_blank" href="<?php echo $fullurl; ?>view_online_feedback_form.php?queryId=<?php echo $resultlist['queryId']; ?>&quotationId=<?php echo $resultlist['quotationId']; ?>&overallfeedbackId=<?php echo encode($resultlist['id']); ?>">View&nbsp;Feedback</a></td>

		</tr>
		<?php $n++; } ?>
	</tbody>
	</table>
	<!-- </div> -->
<!-- </div> -->

<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{
dom: 'frtilpB',
'scrollX':true,
buttons: [
{extend:'copyHtml5',title: 'Online Feedback Report'},
{extend:'excelHtml5',title: 'Online Feedback Report'},
// 'csvHtml5',
{extend:'pdfHtml5',title: 'Online Feedback Report',
	orientation : 'landscape',
    // pageSize : 'LEGAL',

}
],
language: { 
search: "Search: ",
searchPlaceholder: "Name , Designation",
},
}
);
} );
</script>

<script>
function copydatatodata(){

var margin = $('#margin').html();

$('#marginreport').val(margin);  

$('#downloadmargin').submit();  

}



</script>

</td>

</tr>

</table>

<?php } ?>



<!--- Online Feedback Report End -->

<?php 
 
// ============================= birth Day report ===================================

if($_REQUEST['report']=='62'){
	?>
	<div id="loadBirthDayReport"></div>
	<script>
		function birthDayReminderReport(){
		$("#loadBirthDayReport").load('loadbirthDayReminderReport.php?module=reports&report=62&daterange=<?php echo urlencode($_REQUEST['daterange']); ?>&fromDate=<?php echo $_REQUEST['fromDate']; ?>&toDate=<?php echo $_REQUEST['toDate']; ?>&eventType=<?php echo $_REQUEST['eventType']; ?>');
		}
		birthDayReminderReport();
	</script>
		
	<?php
}
// ============================ News Letter Report Start =====================================
if($_REQUEST['report']=='63'){
	?>
	<div id="loadNewsLetterReport"></div>
	<script>
		function newsLetterReport(){
		$("#loadNewsLetterReport").load('loadNewsLetterReport.php?module=reports&report=63&daterange=<?php echo urlencode($_REQUEST['daterange']); ?>&fromDate=<?php echo $_REQUEST['fromDate']; ?>&toDate=<?php echo $_REQUEST['toDate']; ?>&companyType=<?php echo $_REQUEST['companyType']; ?>');
		}
		newsLetterReport();
	</script>
		
	<?php
}
?>
<!-- =============================== Login report starts =============================== -->

<?php if($_REQUEST['report']=='13'){ ?>


<!-- 
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
 -->

<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}


}, function(start, end, label) { 



});


});

</script> 


<form method="get" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="90%" align="left" valign="top">

<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
<input name="report" id="report" type="hidden" value="13" />

<h3 class="cms_title" style="padding-left:75px;">Login Report</h3>
&nbsp;<span class="doExpand" id="Expand123" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position: relative; top: -51px;">Expand</span>

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position: relative;padding-top: 40px;">
<table width="98%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
<tr>

<td width="629" align="center">&nbsp;</td>
<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>

<td style="padding:0px 0px 0px 5px;"><input name="usernameId" type="text" class="topsearchfiledmain" id="usernameId" style="width:90%;border-radius:0px!important;" value="<?php if($_REQUEST['usernameId']!=''){ echo $_REQUEST['usernameId']; } ?>" placeholder="Username" autofill="off"></td>

<!-- <td><input name="daterange" type="hidden" readonly=""  class="topsearchfiledmain" id="daterange"  value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>"></td> -->

<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table>
</div>

</td>

</tr>

</table>  
</form>
<style>
	#example_filter{
		position:absolute;
		top:-55px;
		font-size:15px;

	}
	#example_filter input{
		padding:8px;
	}

</style>
<div id="margin" class="filterable" style="padding:0px 5px;">

<table border="1" cellpadding="10" cellspacing="0"  id="example" bordercolor="#E6E6E6" class="display table" style="width:100%">
<thead>

<tr>

<th align="left" class="header">Employee Name</th>

<th align="left" class="header">Department </th>

<th align="left" class="header">Login Date</th>

<th align="left" class="header">Login Time</th>

<th align="left" class="header">IP Address </th>

</tr>
</thead>

<tbody>


<?php             


$where31=''; 

$rs13='';  

$username='';

$searchField='';

if($_GET['usernameId']!=''){
$username="1 and firstName like '%".$_GET['usernameId']."%' or lastName like '%".$_GET['usernameId']."%'";

$userData= GetPageRecord('id',_USER_MASTER_,$username); 

$userDataResult =mysqli_fetch_array($userData);

$searchField = ' and userId="'.$userDataResult['id'].'"';

}

$where31='userId!=0 '.$searchField.' order by id desc';  

$rs13= GetPageRecord('*','loginDetailMaster',$where31); 

// $query = "SELECT * FROM `loginDetailMaster` ORDER BY `id` DESC";
// $runque = mysqli_query(db(),$query);
while($user=mysqli_fetch_array($rs13)){

$userData= GetPageRecord('*',_USER_MASTER_,'id="'.$user['userId'].'"'); 

$userDataResult =mysqli_fetch_array($userData);

$employeeName = $userDataResult['firstName'].' '. $userDataResult['lastName'];

?>



<tr> 



<td align="left"><?php echo $employeeName ;?></td>



<td align="left"><?php 

$where100='id="'.$userDataResult['roleId'].'"'; 

$rs188=GetPageRecord('name',_ROLE_MASTER_,$where100); 


$res212=mysqli_fetch_array($rs188);

echo $res212['name'];
?>
</td>

<td align="left"><?php echo date('d-m-Y',strtotime($user['dateAdded'])); ?></td>



<td align="left"><?php echo date('h:i A',strtotime($user['loginTime']));?></td>



<td align="left"><?php echo $user['ipAddress']; ?></td>


<?php  } ?>



</tbody>
</table>

</div>

<style>



#pagelisterouter {



padding-top: 60px !important;



margin-top: 5px !important;}



</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	aaSorting: [[1, 'desc']],
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Login Report'},
{extend: 'excelHtml5', title: 'Login Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'Login Report'},
]
}
);
} );
</script>



<?php }?>


<?php 
if($_REQUEST['report']=='21'){ ?>


<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>






<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  






<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="21" />



<h3 class="cms_title" style="padding-left:70px">Daily&nbsp;Movement Chart Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position: relative;padding-top: 40px;">
<table width="100%" border="0" cellpadding="10" cellspacing="0">
<tr>
<td width="100%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<!-- <td width="629" align="center">&nbsp;</td> -->
<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr style="position:absolute;top:8px;left:190px;">


<!--    <td style="padding:0px 0px 0px 5px;"><input name="searchbtnmainh" type="text" class="topsearchfiledmain" id="searchbtnmainh" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['leadPaxName']!=''){ echo $_REQUEST['searchbtnmainh']; } ?>" size="100" maxlength="100" placeholder="Tour ID ,Activity Name"></td> -->
<td style="padding:0px 0px 0px 5px;">
<select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;" >

<option value="0">City</option>

<?php 
$select=''; 

$where=''; 

$rs='';  

$select='*';    

$where=' name!="" and deletestatus=0 order by name asc';  

$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 

while($resListing=mysqli_fetch_array($rs)){  
?>

<option value="<?php echo $resListing['id']; ?>" <?php if($_REQUEST['destinationId']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>

<?php } ?>

</select></td>

<td style="padding:0px 0px 0px 5px;" ><select name="serviceType" id="serviceType" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;" >

<option value="">Type</option>

<option value="hotel" <?php if($_REQUEST['serviceType']=='hotel'){ echo 'selected="selected"'; } ?>>STAY</option>

<option value="transfer" <?php if($_REQUEST['serviceType']=='transfer'){ echo 'selected="selected"'; } ?>> TRANSFER</option>

<option value="flight" <?php if($_REQUEST['serviceType']=='flight'){ echo 'selected="selected"'; } ?>>FLIGHT</option>

<option value="train" <?php if($_REQUEST['serviceType']=='train'){ echo 'selected="selected"'; } ?>> TRAIN</option>

<option value="entrance" <?php if($_REQUEST['serviceType']=='entrance'){ echo 'selected="selected"'; } ?>>ENTRANCE</option>
<option value="guide" <?php if($_REQUEST['serviceType']=='guide'){ echo 'selected="selected"'; } ?>>GUIDE</option> 
<option value="activity" <?php if($_REQUEST['serviceType']=='activity'){ echo 'selected="selected"'; } ?>>ACTIVITY</option>
<option value="mealplan" <?php if($_REQUEST['serviceType']=='mealplan'){ echo 'selected="selected"'; } ?>>RESTAURANT</option> 
<option value="enroute" <?php if($_REQUEST['serviceType']=='enroute'){ echo 'selected="selected"'; } ?>>ENROUTE</option> 
<option value="additional" <?php if($_REQUEST['serviceType']=='additional'){ echo 'selected="selected"'; } ?>>ADDITIONAL</option> 

</select></td>
<!-- <td style="padding:0px 0px 0px 5px;"><input name="leadPaxName" type="text" class="topsearchfiledmain" id="leadPaxName" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['leadPaxName']!=''){ echo $_REQUEST['leadPaxName']; } ?>" size="100" maxlength="100" placeholder="Lead Pax Name"></td> -->

<td style="padding:0px 0px 0px 5px;"><input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent"></td>

<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>

<td width="41%" style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 7px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>

</tr>

</table></td>

</tr>

</table></td>

</tr>

</table>

</div>

</form>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important;
}
table {
display: block;
white-space: nowrap;
}

#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 140px;
}
#example_wrapper{
	width:88%;
}

</style>

<div id="margin" width="100%" class="filterable" style="padding:0px 5px;">



<table border="1" cellpadding="4" width="100%" cellspacing="0" bordercolor="#E6E6E6" class="display table  gridtable headerClass" id="example"  >




<thead> 



<tr style="font-family:normal;text-transform:uppercase;text-align:center;">


<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">S.No</th>
<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Tour ID</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour DATE</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">CITY</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Type</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent Name</th>

<th width="150" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">LEAD PAX NAME</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Pax</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">STAY/ACTIVITY</th>

<th width="156" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour Manager</th>

</tr>

</thead>

<tbody style="text-align:center; color: #000; font-size: 13px;"  >

<?php 
 
$daterangeQuery='';
if($_GET['daterange']!=''){ 
    $myString = $_GET['daterange'];
    $myArray = explode(' - ', $myString);  
    $daterangeQuery = ' and startDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" and quotationId in (select id from quotationMaster where status=1  )' ;
    
}

if($_GET['destinationId']>0){
$cityIdserch = 'and destinationId="'.$_GET['destinationId'].'"' ;
}else{
$cityIdserch = '' ;
}

if($_GET['serviceType']!=''){

$serviceType = 'and serviceType="'.$_GET['serviceType'].'"';
}else{
$serviceType = ' ' ;
}

if($_GET['leadPaxName']!=''){

$leadPaxName = 'and queryId in (select id from queryMaster where leadPaxName like "%'.$_GET['leadPaxName'].'%")';
}else{

$leadPaxName = ' ' ;
}
if($_GET['agentname']!=''){

$agentname = 'and queryId in (select id from queryMaster where companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['agentname'].'%") or companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_GET['agentname'].'%" or lastName like "%'.$_GET['agentname'].'%" ))';
}else{

$agentname = ' ' ;
}
$sn=0;
$itineryDay=GetPageRecord('*','quotationItinerary','1 and queryId in (select id from queryMaster where queryStatus=3 ) and quotationId in ( select id from quotationMaster where status=1) '.$daterangeQuery.' '.$leadPaxName.' '.$agentname.' '.$serviceType.' order by startDate asc');
while($itineryDayData = mysqli_fetch_array($itineryDay)){

  if($itineryDayData['serviceType']=='hotel'){
      $rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and dayId="'.$itineryDayData['dayId'].'" and isHotelSupplement!=1  and isRoomSupplement!=1 and isGuestType=1 and supplierId="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by fromDate asc ');   
      
      while($resultlists=mysqli_fetch_array($rs)){  
          
          $rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'"  and status=1 order by id asc '); 
          
          $quotationData=mysqli_fetch_array($rsq); 

          
          $rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
          
          $queryData=mysqli_fetch_array($rsquery);
          
          $rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by id asc '); 
          
          $hotelData=mysqli_fetch_array($rsHotel);
          
          $sele='*';
          
          $whereDest=' id="'.$resultlists['destinationId'].'" ';   
          
          $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
          
          $ddest=mysqli_fetch_array($rsDest);
          $sn++;
          
          ?>
          
          <tr style="text-align:center;">
          
          <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE">
          <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
          </td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo date('d-m-Y',strtotime($resultlists['fromDate']));  ?></td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?> </td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo 'Stay'; ?> </td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($hotelData['hotelName'],20,"<br>"); ?></td>
          
          <td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
          
          </tr> 
          
          <?php  
  
      } 
  } 
	if($itineryDayData['serviceType']=='transfer'){
	    
	$rs=GetPageRecord('*','quotationTransferMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



	while($resultlists=mysqli_fetch_array($rs)){  

	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

	$quotationData=mysqli_fetch_array($rsq); 

	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

	$queryData=mysqli_fetch_array($rsquery); 

	$selveh='carType';  

	$whereveh='carType="'.$resultlists['vehicleId'].'"'; 

	$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 

	$vehicalname=mysqli_fetch_array($rsveh); 

	$rsTrnsf=GetPageRecord('transferName,transferCategory','packageBuilderTransportMaster',' id="'.$resultlists['transferNameId'].'" order by id asc '); 



	$transferData=mysqli_fetch_array($rsTrnsf);

	$sele='*';

	$whereDest=' id="'.$resultlists['destinationId'].'" ';   

	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);

	$ddest=mysqli_fetch_array($rsDest);

	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

	$driverData=mysqli_fetch_array($rsDv);

	$sn++;
	?>

	<tr style="text-align:center;">


	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $transferData['transferCategory']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($transferData['transferName'],20,"<br>"); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>

	</tr> 

	<?php  } 

	}

	if($itineryDayData['serviceType']=='train'){

	$rs=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  


	while($resultlists=mysqli_fetch_array($rs)){  

	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

	$quotationData=mysqli_fetch_array($rsq); 

	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

	$queryData=mysqli_fetch_array($rsquery); 

	$rstrain=GetPageRecord('trainName',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$resultlists['trainId'].'" order by id asc '); 

	$trainData=mysqli_fetch_array($rstrain);

	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

	$driverData=mysqli_fetch_array($rsDv);

	$sele='*';

	$whereDest=' id="'.$resultlists['destinationId'].'" ';   



	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



	$ddest=mysqli_fetch_array($rsDest);

	$sn++;
	?>

	<tr style="text-align:center;">

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo $ddest['name']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo "Train"; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($trainData['trainName'],20,"<br>"); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>



	</tr> 



	<?php  }

	}
	if($itineryDayData['serviceType']=='flight'){

	$rs=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.' order by id asc ');  



	while($resultlists=mysqli_fetch_array($rs)){  

	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



	$quotationData=mysqli_fetch_array($rsq); 



	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



	$queryData=mysqli_fetch_array($rsquery); 

	$rsflight=GetPageRecord('flightName',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$resultlists['flightId'].'" order by id asc '); 

	$flightData=mysqli_fetch_array($rsflight);

	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

	$driverData=mysqli_fetch_array($rsDv);


	$sele='*';



	$whereDest=' id="'.$resultlists['destinationId'].'" ';   



	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



	$ddest=mysqli_fetch_array($rsDest);

	// print_r($ddest);


	$sn++;
	?>



	<tr style="text-align:center;">


	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>


	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?>  </td>





	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>





	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo "Flight"; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($flightData['flightName'],20,"<br>"); ?></td>


	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>



	</tr> 



	<?php  }

	}
	if($itineryDayData['serviceType']=='entrance'){
	$rs=GetPageRecord('*','quotationEntranceMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



	while($resultlists=mysqli_fetch_array($rs)){   


	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



	$quotationData=mysqli_fetch_array($rsq); 



	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

	$queryData=mysqli_fetch_array($rsquery);

	$rsSight=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$resultlists['entranceNameId'].'" order by id asc '); 

	$entranceDataName=mysqli_fetch_array($rsSight);

	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



	$driverData=mysqli_fetch_array($rsDv);


	$sele='*';



	$whereDest=' id="'.$resultlists['destinationId'].'" ';   



	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



	$ddest=mysqli_fetch_array($rsDest);

	$sn++;

	?>



	<tr style="text-align:center;">

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>


	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>



	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>


	<td align="center" valign="middle" bgcolor="#FAFDFE">Entrance</td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($entranceDataName['entranceName'],20,"<br>"); ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>



	</tr> 



	<?php  } 
	}
	if($itineryDayData['serviceType']=='guide'){

	$rs=GetPageRecord('*','quotationGuideMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



	while($resultlists=mysqli_fetch_array($rs)){   

	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



	$quotationData=mysqli_fetch_array($rsq); 

	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

	$queryData=mysqli_fetch_array($rsquery);

	$rsGuide=GetPageRecord('*','tbl_guidesubcatmaster',' id="'.$resultlists['guideId'].'" order by id asc '); 

	$GuideDataName=mysqli_fetch_array($rsGuide);

	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



	$driverData=mysqli_fetch_array($rsDv);


	$sele='*';



	$whereDest=' id="'.$resultlists['destinationId'].'" ';   



	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



	$ddest=mysqli_fetch_array($rsDest);


	$sn++;
	?>



	<tr style="text-align:center;">

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>


	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>



	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>


	<td align="center" valign="middle" bgcolor="#FAFDFE">Guide</td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>



	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($GuideDataName['name'],20,"<br>"); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>

	</tr> 

	<?php  } 
	}
	if($itineryDayData['serviceType']=='mealplan'){

	$rs=GetPageRecord('*','quotationInboundmealplanmaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.' order by id asc ');  



	while($resultlists=mysqli_fetch_array($rs)){   


	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



	$quotationData=mysqli_fetch_array($rsq); 



	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



	$queryData=mysqli_fetch_array($rsquery);




	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



	$driverData=mysqli_fetch_array($rsDv);


	$sele='*';



	$whereDest=' id="'.$resultlists['destinationId'].'" ';   



	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



	$ddest=mysqli_fetch_array($rsDest);


	$sn++;
	?>



	<tr style="text-align:center;">


	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>


	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>


	<td align="center" valign="middle" bgcolor="#FAFDFE">Restaurant</td>



	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($resultlists['mealPlanName'],20,"<br>"); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>



	</tr> 



	<?php  } 
	}
	if($itineryDayData['serviceType']=='activity'){

	$cityFilter='';
	if(isset($_REQUEST['destinationId']) && $_REQUEST['destinationId']>0)  
	$cityFilter = 'and otherActivityCity='.$_REQUEST['destinationId'];

	$rs=GetPageRecord('*','quotationOtherActivitymaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityFilter.' order by id asc ');  


	while($resultlists=mysqli_fetch_array($rs)){   

	$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

	$quotationData=mysqli_fetch_array($rsq); 

	$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

	$queryData=mysqli_fetch_array($rsquery);

	$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

	$driverData=mysqli_fetch_array($rsDv);

	$sele='*';

	$whereDest=' id="'.$resultlists['otherActivityCity'].'" ';   

	$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);

	$ddest=mysqli_fetch_array($rsDest);

	$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'id="'.$resultlists['otherActivityName'].'"');

	$otherActivityData=mysqli_fetch_array($rs1);

	$sn++;
	?>

	<tr style="text-align:center;">

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE">
	<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
	</td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE">Activity</td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($otherActivityData['otherActivityName'],20,"<br>"); ?></td>

	<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>

	</tr> 



	<?php  } 
	}
	if($itineryDayData['serviceType']=='enroute'){

		$cityFilter='';
		if(isset($_REQUEST['destinationId']) && $_REQUEST['destinationId']!='')  
		$cityFilter = 'and destinationId='.$_REQUEST['destinationId'];
		
		$rs=GetPageRecord('*','quotationEnrouteMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityFilter.' order by id asc ');  
		
		
		
		while($resultlists=mysqli_fetch_array($rs)){   
		
		$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 
		
		
		
		$quotationData=mysqli_fetch_array($rsq); 
		
		
		
		$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
		
		
		
		$queryData=mysqli_fetch_array($rsquery);
		
		
		
		
		$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 
		
		
		
		$driverData=mysqli_fetch_array($rsDv);
		
		
		
		
		$sele='*';
		
		
		
		$whereDest=' id="'.$resultlists['destinationId'].'" ';   
		
		
		
		$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
		
		
		
		$ddest=mysqli_fetch_array($rsDest);
		$rs1='';
		$rs1=GetPageRecord('*','packageBuilderEnrouteMaster','id="'.$resultlists['enrouteId'].'"');
		
		$enrouteData=mysqli_fetch_array($rs1);
		
		
		$sn++;
		?>
		
		
		
		<tr style="text-align:center;">
		
		<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE">
		<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
		</td>
		
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>
		
		<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE">Enroute</td>
		
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
		
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
		
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>
		
		
		
		<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($enrouteData['enrouteName'],20,"<br>"); ?></td>
		
		<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
		
		
		
		</tr> 
		
		
		
		<?php  } 
		}
	if($itineryDayData['serviceType']=='additional'){

			$cityFilter='';
			if(isset($_REQUEST['destinationId']) && $_REQUEST['destinationId']!='')  
			$cityFilter = 'and destinationId='.$_REQUEST['destinationId'];
			
			$rs=GetPageRecord('*','quotationExtraMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityFilter.' order by id asc ');  
			
			while($resultlists=mysqli_fetch_array($rs)){   
			
			$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 
			
			$quotationData=mysqli_fetch_array($rsq); 
			
			$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
		
			$queryData=mysqli_fetch_array($rsquery);
			
			$sele='*';
			
			$whereDest=' id="'.$resultlists['destinationId'].'" ';   
			
			$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
			
			$ddest=mysqli_fetch_array($rsDest);
			$rs1='';
			$rs1=GetPageRecord('*','extraQuotation','id="'.$resultlists['additionalId'].'"');
			
			$additionalData=mysqli_fetch_array($rs1);
			
			
			$sn++;
			?>
			
			
			
			<tr style="text-align:center;">
			
			<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?=$sn?></td>
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE">
			<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
			</td>
			
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>
			
			<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE">Additional</td>
			
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
			
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
			
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $quotationData['adult']+$quotationData['child']+$quotationData['infant']; ?></td>
			
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo wordwrap($additionalData['name'],20,"<br>"); ?></td>
			
			
			
			<td align="center" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
			
			
			
			</tr> 
			
			
			
			<?php  } 
			}

}

?>



</tbody>



</table>

<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
				},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Daily Movement Chart Report'},
{extend: 'excelHtml5', title: 'Daily Movement Chart Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'Daily Movement Chart Report'},
],
language: { 
search: "Search: ",
searchPlaceholder: "Agent , Country , Pax , Amount",
},
}
);

} );
</script>



</div>

</td>



</tr>



</table>


<?php }
?>


<!-- ============================= Driver Allocation Report Starts ========================== -->
<?php if($_REQUEST['report']=='22'){ ?>


<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- 
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script> -->

<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}

}, function(start, end, label) { 

});
});

</script>  
<style>


.driverbtn{border: 1px solid #ff860a; padding: 3px 10px; width: fit-content; border-radius: 3px; background-color: #ff860a; color: #ffffff; cursor: pointer;}



.suppicon{font-size: 20px; color: #ff860a; cursor: pointer;}


</style> 



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >

<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="report" id="report" type="hidden" value="22" />
<h3 class="cms_title" style="padding-left:70px;">Driver Allocation Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;"><table width="100%" border="0" cellpadding="10" cellspacing="0">
<!-- <tr>
<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">



<option value="">City</option>
<?php 
$select=''; 

$where=''; 
$rs='';  
$select='*';    
$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>
<?php } ?>



</select></td>
</tr> -->
<tr>

<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>

<td width="270" align="center">&nbsp;</td>



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<td style="padding:0px 0px 0px 5px;"><input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent/FTO Name"></td>



<td  style="padding:0px 0px 0px 5px;"><select name="driverid" id="driverid" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">



<option value="">Driver</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,'driverMaster',$where); 



while($resListing=mysqli_fetch_array($rs)){  

?>

<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['driverid']){ ?>selected="selected"<?php  } ?>> <?php echo $resListing['name']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;" >
<select id="allocationStatus" name="allocationStatus" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 117px;">
<option value="">Status</option> 
<option value="1" <?php if($_GET['allocationStatus']=='1'){ ?>selected="selected"<?php } ?>>Assigned</option>
<option value="2" <?php if($_GET['allocationStatus']=='2'){ ?>selected="selected"<?php } ?>>Rejected</option>
<option value="3" <?php if($_GET['allocationStatus']=='3'){ ?>selected="selected"<?php } ?>>Completed</option>
</select> 
</td>



<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td width="41%" style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 7px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>



</tr>



</table></td>



</tr>



</table></td>

</tr>
</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;">

<style type="text/css">
table {
display: block;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}

#example_filter {
position: absolute;
top: -50px;
left: 0%;
}

#example_filter input {
height: 35px;
width: 210px;
}
#example_wrapper{
	width:62.8%;
}

</style>
<?php
$outputD = '';

$outputD='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100%" >



<thead> 
<tr style="font-family:normal;text-transform:uppercase;text-align:center;">


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:67.531px !important;color:#FFFFFF;">S.No</th>
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:67.531px !important;color:#FFFFFF;">Tour Id</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; width:76.531px !important;color:#FFFFFF;">Tour DATE</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:81.531px !important; color:#FFFFFF;">Destination</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Agent/FTO Name</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Lead Pax Name</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:85.531px !important; color:#FFFFFF;">Pick Up Time</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Drop Time</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:74.031px !important; color:#FFFFFF;">Mode</th>
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:74.031px !important; color:#FFFFFF;">Status</th>';       


$outputDH=$outputD;
echo $outputD;
$outputD='';
echo '<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:73.031px !important; color:#FFFFFF;">Driver</th>';

$outputD='<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:96.031px !important; color:#FFFFFF;">Vehicle Name</th>';


$outputDH.=$outputD;
echo $outputD;
$outputD='';
echo '<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:107.031px !important; color:#FFFFFF;">Vehicle Allocation</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:107.031px !important; color:#FFFFFF;">Pickup & Drop Time</th>';


$outputD='</tr>

</thead>

<tbody style="text-align:center; color: #000; font-size: 13px;"  >';

echo $outputD;

$outputDH.=$outputD;
$outputD='';

$no=0;   
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';

$fromDate = $_REQUEST['fromDate'];
$toDate = $_REQUEST['toDate'];
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
$datewhere='';

$fromDate = date('Y-m-d', strtotime($myArray[0]));
$toDate = date('Y-m-d', strtotime($myArray[1]));
}

if($_GET['destinationId']!=''){

$destinationId = 'and destinationId="'.$_GET['destinationId'].'"';
}

if($_GET['driverid']!=''){

$driverId = 'and id in (select transferQuotId from driverAllocationDetails where driverId="'.$_GET['driverid'].'")';
}

if($_GET['allocationStatus']!=''){

$allocationStatus = 'and id in (select transferQuotId from driverAllocationDetails where allocationStatus="'.$_GET['allocationStatus'].'")';
}

if($_GET['agentname']!=''){

$b2cagentname = explode(" ", $_GET['agentname']);
$firstName = $b2cagentname[0];

$agentname = 'and queryId in (select id from queryMaster where clientType=1 and moduleType=1 and companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['agentname'].'%") or clientType=2 and companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$firstName.'%"))';
}

$mainQueryS = ' and queryId in ( select id from queryMaster where moduleType=1 ) ';
$rs=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' 1 '.$agentname.' '.$daterangeQuery.' '.$destinationId.' '.$driverId.' '.$allocationStatus.' '.$mainQueryS.' order by id asc '); 
while($resultlists=mysqli_fetch_array($rs)){  

++$no;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);

$selveh='id,carType,model,registrationNo';  

$whereveh='id="'.$resultlists['vehicleModelId'].'"'; 

$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 

$vehicalname=mysqli_fetch_array($rsveh);

$rstranfer=GetPageRecord('transferName,transferCategory',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$resultlists['transferNameId'].'" order by id asc '); 

$tranferData=mysqli_fetch_array($rstranfer);

$desName='';

$dest='';

if($resultlists['serviceType']=='transportation'){

$noOfDay = (strtotime($resultlists['toDate'])-strtotime($resultlists['fromDate']))/(60*60*24);  
$frmDate = $resultlists['fromDate'];
$temp = '';
if($noOfDay>0)
{
for($i=0;$noOfDay>=$i;++$i)
{

$rsDest = GetPageRecord("cityId",'newQuotationDays',' queryId="'.$quotationData['queryId'].'" and quotationId="'.$resultlists['quotationId'].'" and srdate="'.$frmDate.'"');

$resListingDest = mysqli_fetch_array($rsDest);
// $dest .= $frmDate.', ';
// $dest .= $resListingDest['cityId'].', ';

$frmDate = date('Y-m-d',strtotime('+1 day',strtotime($frmDate)));

if($temp==$resListingDest['cityId'])
continue;

$destinationD = getDestination($resListingDest['cityId']);
$temp = $resListingDest['cityId'];
$dest .= $destinationD.',';

}  

}
else
{
$rsDest = GetPageRecord("cityId",'newQuotationDays',' queryId="'.$quotationData['queryId'].'" and quotationId="'.$resultlists['quotationId'].'" and srdate="'.$frmDate.'"');

$resListingDest = mysqli_fetch_array($rsDest);

$dest =getDestination($resListingDest['cityId']);
}

$desName = rtrim($dest,',');
}

if($resultlists['serviceType']=='transfer'){
$destinationIdq = explode(',',$resultlists['destinationId']); 
$destinationName = "";

foreach ($destinationIdq as $destinationresult) { 
$sele='*';
$whereDest=' id="'.$destinationresult.'" ';   
$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
$ddest=mysqli_fetch_array($rsDest);

$destinationName.= $ddest['name'].',';

}

$desName = rtrim($destinationName,',');
}

$selecttime='*';

$wheretime=' quotationId="'.$resultlists['quotationId'].'" and transferQuoteId="'.$resultlists['id'].'" and supplierId="'.$resultlists['supplierId'].'" ';   

$rstimet=GetPageRecord($selecttime,'quotationTransferTimelineDetails',$wheretime);

$dtime=mysqli_fetch_array($rstimet);

$sel='*';
$wherev='transferQuotId = "'.$resultlists['id'].'" order by id desc';
$rsv=GetPageRecord($sel,'driverAllocationDetails',$wherev);
$driverAllocate=mysqli_fetch_array($rsv);

$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$driverAllocate['driverId'].'"  order by name'); 
$driverData=mysqli_fetch_array($rsDv);
$name='';
$phone='';
if($driverAllocate['driverId']!='0'){
$name = $driverData['name'];
$phone = $driverData['mobile'];
}else{
$name = $driverAllocate['name'];
$phone = $driverAllocate['mobileNo'];    
}

$sel='*';
$wherev='transferQuotId = "'.$resultlists['id'].'" and  allocatedStatus=1 order by id desc';
$rsv=GetPageRecord($sel,'quotVhicleDetails',$wherev);
$allocatevahicle=mysqli_fetch_array($rsv);


$outputD.='<tr style="text-align:center;">';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE"> <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  >'.$no.'</div></td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE"> <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id='.encode($queryData['id']).'"  style="color:#45b558 !important;">'.makeQueryTourId($queryData['id']).'</a></div></td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';

if($resultlists['fromDate']=='' || $resultlists['fromDate']=='1970-01-01')
{ $outputD.=date('d-m-Y',strtotime($resultlists['fromDate'])).' to '.date('d-m-Y',strtotime($forDesdtId['endDate'])); }
else{ $outputD.=date('d-m-Y',strtotime($resultlists['fromDate'])).' to '.date('d-m-Y',strtotime($resultlists['toDate'])); }
$outputD.='</td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$desName.'</td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$dtime['pickupTime'].'</td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$dtime['dropTime'].'</td>';

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$tranferData['transferCategory'].'</td>';

$outputD.='<td align="center" valign="middle">';

if($driverAllocate['allocationStatus']==1){ 
$allocationStatus='Assigned';

$outputD.='<button type="button" style="background-color: #ff860a;width: 100%;color: #ffffff;">'.$allocationStatus.'</button>';
}elseif($driverAllocate['allocationStatus']==2){
$allocationStatus='Reassign';
$outputD.='<button type="button" style="background-color: red;width: 100%;color: #ffffff;">'.$allocationStatus.'</button>';
}elseif($driverAllocate['allocationStatus']==3){
$allocationStatus='Completed';
$outputD.='<button type="button" style="background-color: green;width: 100%;color: #ffffff;">'.$allocationStatus.'</button>'; 
}
$outputD.='</td>';

// $outputD.='<td></td>';
$outputDH.=$outputD;
echo $outputD;
$outputD='';

echo '<td align="center" valign="middle" bgcolor="#FAFDFE"><a title="Add Driver" onClick="alertspopupopen(`action=addeDriverExcursionReport12&id='.$resultlists['id'].'&serviceType=transfer&fromDate='.$resultlists['fromDate'].'&toDate='.$resultlists['toDate'].'&driverId='.$driverData['id'].'&displayId='.$queryData['id'].'&quotationId='.$resultlists['quotationId'].'`,`800px`,`auto`);" ><div class="driverbtn">+ Driver</div></a><td><div id="driverInfo'.$resultlists['id'].'>'.$name.'<br />'.$phone.'</div></td>'; 

$outputD.='<td align="center" valign="middle" bgcolor="#FAFDFE"><div id="vehicleName'.$resultlists['id'].'">'.$vehicalname['model'].'</div></td>'; 

$outputDH.=$outputD;
echo $outputD;
$outputD='';
echo '<td align="center" valign="middle" bgcolor="#FAFDFE"><a title="Add Driver" onClick="alertspopupopen(`action=addeVehicleAllocation&id='.$resultlists['id'].'&fromDate='.$fromDate.'&toDate='.$toDate.'&modelId='.$vehicalname['id'].'&queryId='.$queryData['displayId'].'&qfromDate='.$resultlists['fromDate'].'&qtoDate='.$resultlists['toDate'].'&serviceType=transfer`,`800px`,`auto`);" ><div class="driverbtn" style="background-color: #2bb0dd!important;border: 1px solid #2bb0dd;" ><i class="fa fa-car"></i> Vehicle</div></a><div id="driverInfo'.$resultlists['id'].'">'.$allocatevahicle['vehicleName'].'<br />'.$allocatevahicle['registrationNo'].'</div></td>';



echo '<td align="center" valign="middle" bgcolor="#FAFDFE"><a title="Add Driver" onClick="alertspopupopen(`action=addeVehicleExcursionReport12&id='.$resultlists['id'].'&fromDate='.$_REQUEST['fromDate'].'&toDate='.$_REQUEST['toDate'].'&serviceType=transfer`,`1000px`,`auto`);" ><div class="driverbtnd">+ P&D</div></a></td>';



?>
<style type="text/css">



.driverbtnd{border: 1px solid #45b558;



padding: 3px 10px;



width: fit-content;



border-radius: 3px;



background-color: #45b558;



color: #ffffff;



cursor: pointer;}

</style>
<?php
$outputDH.='</tr>';
echo '</tr>';

}  

echo '</tbody></table>';
$outputDH.='</tbody></table>';

?>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Driver Allocation Report'},
{extend: 'excelHtml5', title: 'Driver Allocation Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'Driver Allocation Report',
	orientation : 'landscape',
    pageSize : 'LEGAL',
    exportOptions: {
              columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13 ]
         },
}
],
language: { 
search: "Search: ",
searchPlaceholder: "Serach By Keyword",
},
}
);
} );
</script>


</div>


</td>



</tr>



</table>

<?php 
// if($_GET['daterange']!=''){ 
// $myString = $_GET['daterange'];
// $myArray = explode(' - ', $myString);  
// $fromDate = date('Y-m-d', strtotime($myArray[0]));
// $toDate = date('Y-m-d', strtotime($myArray[1]));
// }if($_GET['fromDate']!='' && $_GET['toDate']!='')
// {
// $fromDate = $_GET['fromDate'];
// $toDate = $_GET['toDate'];
// }

?>

<?php } ?>



<?php if($_REQUEST['report']=='23'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="23" />



<h3 class="cms_title">Guide Allocation Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position:relative;padding:20px">

<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr >



<td  width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td width="629" align="center">&nbsp;</td>



<td   width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr style="position: absolute;left:264px;top:10px">

<td style="padding:0px 0px 0px 5px;"><input name="agentnamefto" type="text" class="topsearchfiledmain" id="agentnamefto" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentnamefto']!=''){ echo $_REQUEST['agentnamefto']; } ?>" size="100" maxlength="100" placeholder="Agent/FTO Name"></td>  

<!-- <td style="padding:0px 0px 0px 5px;"><input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent"></td> -->




<td style="padding:0px 0px 0px 5px;">  
<select id="name" name="guideId" class="topsearchfiledmainselect" displayname="Guide Name" autocomplete="off" style="border-radius:0px!important;width: 170px;"> 
<option value=""> Select Guide </option> 
<?php  
$a12=GetPageRecord('*',_GUIDE_MASTER_,' 1 order by name asc'); 
while($guideData=mysqli_fetch_array($a12)){ 
?>
<option value="<?php echo strip($guideData['id']); ?>" <?php if($guideData['id']==$_REQUEST['guideId']){ ?>selected="selected"<?php } ?>><?php echo $guideData['name'];?></option>
<?php 
} 
?>
</select>               </td> 
<td style="padding:0px 0px 0px 5px;" >
<select id="allocationStatus" name="allocationStatus" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 117px;">
<option value="">Status</option> 
<option value="1" <?php if($_GET['allocationStatus']=='1'){ ?>selected="selected"<?php } ?>>Assigned</option>
<option value="2" <?php if($_GET['allocationStatus']=='2'){ ?>selected="selected"<?php } ?>>Rejected</option>
<option value="3" <?php if($_GET['allocationStatus']=='3'){ ?>selected="selected"<?php } ?>>Completed</option>
</select> 
</td>              


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div class="" style=" width:100%;"></div>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}

#example_filter {
position: absolute;
top: -65px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}

</style>
<div id="margin" class="filterable" style="padding:0px 5px;">

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100%">
<thead>
<tr>
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">TOUR ID</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">TOUR DATE</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DESTINATION</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent/FTO&nbsp;NAME</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">LEAD&nbsp;PAX&nbsp;NAME</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">STATUS</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">GUIDE</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Guide&nbsp;Service</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Day Type</th>

</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >



<?php 

$no=0;   

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
$datewhere='';
}

if($_GET['guideId']!=''){

$guideId = 'and id in (select guideQuoteId from guideAllocation where 1 and GuideId="'.$_GET['guideId'].'")' ;
}else{

$guideId = '  ' ;
}

if($_GET['allocationStatus']!=''){

$allocationStatus = 'and id in (select guideQuoteId from guideAllocation where 1 and allocationStatus="'.$_GET['allocationStatus'].'")';
}else{

$allocationStatus = '  ' ;
}

if($_GET['agentnamefto']!=''){

$b2cagentname = explode(" ", $_GET['agentnamefto']);
$firstName = $b2cagentname[0];

$agentnamefto = 'and queryId in (select id from queryMaster where clientType=1 and companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['agentnamefto'].'%") or clientType=2 and companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$firstName.'%"))';
}else{

$agentnamefto = ' ' ;
}


$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' 1 '.$agentnamefto.' '.$daterangeQuery.' '.$datewhere.' '.$guideId.' '.$allocationStatus.' and tariffId!=0 order by quotationId desc '); 
while($resultlists=mysqli_fetch_array($rs)){
$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'"  and status=1 order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);


$sele='*';
$whereDest=' id="'.$resultlists['destinationId'].'" ';   
$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
$ddest=mysqli_fetch_array($rsDest);

$selectd = '*';   
$whered= 'id="'.$resultlists['tariffId'].'"'; 
$rsd = GetPageRecord($selectd,'dmcGuidePorterRate',$whered); 
$guideDate = mysqli_fetch_array($rsd);

$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$resultlists['guideId'].'"'); 
$guideCat = mysqli_fetch_array($rs11); 

$rsi = GetPageRecord('*','guideAllocation',' guideQuoteId = "'.$resultlists['id'].'"'); 
$guideid = mysqli_fetch_array($rsi); 
if($guideid['GuideId']!='0'){
$rsg = GetPageRecord('*',_GUIDE_MASTER_,' id = "'.$guideid['GuideId'].'"'); 
$guidedata = mysqli_fetch_array($rsg);
$name = $guidedata['name'];
$phone = $guidedata['phone'];
}else{
$name = $guideid['name'];
$phone = $guideid['mobileNo'];
}

?>
<tr style="text-align:center;">
<td align="center" valign="middle" bgcolor="#FAFDFE">
<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="<?php echo $fullurl; ?>/showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div>
</td>
<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($resultlists['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($resultlists['fromDate'])); }else{ echo date('d-m-Y',strtotime($resultlists['fromDate'])); } ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $queryData['leadPaxName']; ?></td>
<td align="center" valign="middle">
<?php if($guideid['allocationStatus']==1){ 
$allocationStatus='Assigned';
?>
<button type="button" style="background-color: #ff860a;width: 100%;color: #ffffff;"><?php echo $allocationStatus; ?></button><?php }elseif($guideid['allocationStatus']==2){
$allocationStatus='Reassign';
?>
<button type="button" style="background-color: red;width: 100%;color: #ffffff;"><?php echo $allocationStatus; ?></button><?php }elseif($guideid['allocationStatus']==3){
$allocationStatus='Completed';?>
<button type="button" style="background-color: green;width: 100%;color: #ffffff;"><?php echo $allocationStatus; ?></button><?php } ?></td>
<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><a title="Add Driver" onClick="alertspopupopen('action=addeGuideAllocation&id=<?php echo $resultlists['id']; ?>&queryId=<?php echo $queryData['id']; ?>&quotationId=<?php echo $quotationData['id']; ?>&fromDate=<?php echo $resultlists['fromDate']; ?>&toDate=<?php echo $resultlists['toDate']; ?>&guideId=<?php echo $guidedata['id']; ?>&serviceType=guide','800px','auto');" style="color: #ffffff !important;" ><div class="guidebtn"><i class="fa fa-user"></i>&nbsp;Guide</div></a><?php $guidedetails['name']; ?><div id="guideInfo<?php echo $resultlists['id']; ?>"><?php echo $name; ?><br><?php echo $phone; ?></div></td>
<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $guideCat['name'];  ?></td>
<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $guideDate['dayType']; ?></td>

</tr>
<?php } ?>

</tbody>
</table>

<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Guide Allocation Report'},
{extend: 'excelHtml5', title: 'Guide Allocation Report'},
{extend: 'pdfHtml5', title: 'Guide Allocation Report',
orientation: 'landscape',
pageSize: 'A4'
}
	
],
language: { 
search: "Search: ",
searchPlaceholder: "Search By Keyword",
}
});
} );
</script>

</div>

</td>



</tr>



</table>

<?php }?>


<?php if($_REQUEST['report']=='24'){ ?>

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<style>


.driverbtn{border: 1px solid #ff860a; padding: 3px 10px; width: fit-content; border-radius: 3px; background-color: #ff860a; color: #ffffff; cursor: pointer;}



.suppicon{font-size: 20px; color: #ff860a; cursor: pointer;}


</style> 



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="24" />



<h3 class="cms_title" style="padding-left:70px">Hotel Booking Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position:relative"><table width="100%" border="0" cellpadding="10" cellspacing="0">

<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>

<td width="600" align="center">&nbsp;</td>



<td  width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr style="position:absolute;top:-19px;left:270px" >

<td style="padding:0px 0px 0px 5px;"  ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;"  onchange="getallHotel();" >



<option value=""> Select Destination</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;" ><select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">
</select></td> 




<script type="text/javascript">
function getallHotel() {

var destinationId = $('#destinationId').val();
var hotelIdr = '<?php echo $_REQUEST['hotelId']; ?>';
$('#hotelId').load('loaddeswisehotel.php?destinationId='+destinationId+'&hotelIdr='+hotelIdr);

}
getallHotel();
</script>          


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>



</tr>



</table></td>



</tr>



</table></td>



</tr>







</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;">

<style type="text/css">
table {
display: block;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}
.fg-button{
border: 1px solid green;
}

#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}
#example_wrapper{
	width: 88.4%;
}
</style>

<table border="1" cellpadding ="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100%" data-page-length='25'>

<thead> 
<tr style="font-family:normal;text-transform:uppercase;text-align:center;">
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:67.531px !important;color:#FFFFFF;">S.No</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:67.531px !important;color:#FFFFFF;">Tour Code</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; width:76.531px !important;color:#FFFFFF;">Lead Pax Name</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:81.531px !important; color:#FFFFFF;">DESTINATION</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Hotel Name</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Room Type</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Check In Date</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:85.531px !important; color:#FFFFFF;">Check Out Date</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:85.531px !important; color:#FFFFFF;">Cut Off Date</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:75.531px !important; color:#FFFFFF;">Amount</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;width:74.031px !important; color:#FFFFFF;">Status</th>       

</tr>

</thead>

<tbody style="text-align:center; color: #000; font-size: 13px;"  >
<?php 

$no=0;   

$daterangeQuery='';

if($_GET['daterange']!=''){ 



$myString = $_GET['daterange'];



$myArray = explode(' - ', $myString);  



$daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';



}else{



$daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" ' ;

}

if($_GET['destinationId']!=''){

$destinationIds = 'and destinationId="'.$_GET['destinationId'].'"';
}else{

$destinationIds = '  ' ;
}

if($_GET['hotelId']!=''){

$hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
}else{

$hotelserch = '  ' ;
}

$rs=GetPageRecord('*','quotationHotelMaster',' isSelectedFinal=1 and quotationId in (select id from quotationMaster where status=1)    and queryId in (select id from queryMaster where queryStatus=3) and supplierId!=0 '.$daterangeQuery.' '.$destinationIds.' '.$hotelserch.'  group by startDayDate,endDayDate  order by id desc '); 


while($resultlists=mysqli_fetch_array($rs)){  

++$no;

	$rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by id asc '); 
	$hotelData=mysqli_fetch_array($rsHotel);
	


	$rsqt=GetPageRecord('*,count(id) as totalnight','quotationHotelMaster',' supplierId="'.$resultlists['supplierId'].'" and quotationId="'.$resultlists['quotationId'].'"  order by id asc '); 
	$nights = mysqli_num_rows($rsqt);


$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 
$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);

$status=GetPageRecord('*','finalQuote','quotationId="'.$resultlists['quotationId'].'" and hotelId="'.$resultlists['supplierId'].'" and manualStatus>0 group by startDayDate order by id desc');

$hotelStatus=mysqli_fetch_array($status);

$rsHotelroom=GetPageRecord('name','roomTypeMaster',' id="'.$resultlists['roomType'].'" order by id asc '); 

$hotelroom=mysqli_fetch_array($rsHotelroom);

$sele='*';

$whereDest=' id="'.$resultlists['destinationId'].'" ';   

$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);

$ddest=mysqli_fetch_array($rsDest);

$totalpax = $queryData['adult']+$queryData['child'];

//  $totalHotelCost=0;

$singlCost=0;

$doubleCost=0;

$tripleCost=0;

if($queryData['sglRoom']>0){
$singlCost += $resultlists['singleoccupancy']*$nights*$queryData['sglRoom'];
// $totalHotelCost += $singlCost;
}
if($queryData['dblRoom']>0){
$doubleCost += $resultlists['doubleoccupancy']*$nights*$queryData['dblRoom'];
// $totalHotelCost += $doubleCost;
}
if($queryData['tplRoom']>0){
$tripleCost += $resultlists['tripleoccupancy']*$nights*$queryData['tplRoom'];
// $totalHotelCost += $tripleCost;
}
$serviceTax = $quotationData['serviceTax'];

$totalHotelRoomCost = ($singlCost+$doubleCost+$tripleCost);

//  $totalHotelRoomCost = $totalHotelCost;

$totalHotelRoomCostwithgst = $totalHotelRoomCost+$totalHotelRoomCost*$serviceTax/100;

$rs12=GetPageRecord('*',_ROOM_TYPE_MASTER_,'1 and id="'.$resultlists['roomType'].'"'); 
$editresult2=mysqli_fetch_array($rs12);

?>

<tr style="text-align:center;">

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $no; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"> <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $queryData['leadPaxName']; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $hotelData['hotelName']; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $editresult2['name']; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php if($resultlists['startDayDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($resultlists['startDayDate'])); } ?></td>


<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($resultlists['endDayDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($resultlists['endDayDate'])+86400); } ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo date('Y-m-d',strtotime($hotelStatus['cutOffDate'])) ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo getTwoDecimalNumberFormat($totalHotelRoomCostwithgst); ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php if( $hotelStatus['manualStatus']==0){ ?>PENDING <?php }  elseif( $hotelStatus['manualStatus']==1){ ?>SENT<?php } elseif( $hotelStatus['manualStatus']==5){ ?>WAITLIST<?php }  elseif( $hotelStatus['manualStatus']==2){ ?> REQUESTED <?php } elseif( $hotelStatus['manualStatus']==3){ ?> CONFIRMED <?php } elseif( $hotelStatus['manualStatus']==4){ ?> REJECTED<?php } ?></td>


</tr> 



<?php  } //}  ?>



</tbody>



</table>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({

	"initComplete": function(settings, json){
		$("#example").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");
	},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Hotel Booking Report'},
{extend: 'excelHtml5', title: 'Hotel Booking Report'},
{extend: 'pdfHtml5', title: 'Hotel Booking Report',
orientation: 'landscape'
}
],
language: { 
search: "Search: ",
searchPlaceholder: "Search By Keyword",
},
});
} );
</script>


</div>


</td>



</tr>
</table>
<?php }?>



<?php if($_REQUEST['report']=='25'){ ?>



<?php



$searchField=clean($_GET['queryId']);



$invoiceid=clean($_GET['invoiceid']);



$search=clean($_GET['search']);



$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?> 


<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- ====================================== -->

<!-- <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/> -->



<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative;">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="25" />



<table width="100%" border="0" cellpadding="3" cellspacing="0">

<tr>

<h3 class="cms_title" style="padding-left:70px">City Wise Booking Report</h3>
<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:12px;">Expand</span>


<td><div class="headingm" ><span id="topheadingmain"> <h2></h2> </span>

</div></td>

<td>

<table width="25%" border="0" cellpadding="0" cellspacing="0" style="float:right;padding:30px" >



<tr style="position: absolute;top:95px;left:378px;">




<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="width:210px; " >



<option value="">Destinations</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select>
<!-- </td> -->



<!-- <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td> -->


<!-- <td width="59%" style="padding:0px 0px 0px 5px;"> -->
<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
<input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #11b76c; border: 1px solid #5ba5f0; color: #fff; padding: 7px; text-align: center; border-radius: 2px; cursor:pointer;" /> 
</td>

<!-- <td style="padding:0px 0px 0px 5px;" > 
<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> 
</td> -->



<!-- <td width="59%"></td>   -->



</tr>



</table>



</td>



</tr>



</table>    



</form>

<style>
#example_filter {
position: absolute;
top: -42px;
left: 0%;
}

#example_filter label {
font-size: 18px;
}

#example_filter input {
height: 37px;
width: 306px;
}
</style>

<div id="margin" class="filterable" style="padding:0px 5px;">


<?php
$outputCityWise = ''; 
$outputCityWise='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" class="table tablesorter gridtable sortable headerClass" id="example"  >



<thead> 



<tr style="font-family:normal;text-transform:uppercase;text-align:center;">


<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">S.No</th>
<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">TOUR ID</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DATE</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">MODE</th><th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">VEHICLE TYPE</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DESTINATION</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">LEAD&nbsp;PAX&nbsp;NAME</th>




<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Pax</th>
<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Operation Person</th>     

</tr>
</thead>';  

$outputCityWise.='<tbody style="text-align:center; color: #000; font-size: 13px;"  >'; 



$no=0;   
 
$daterangeQuery='';

if($_GET['daterange']!=''){ 

$myString = $_GET['daterange'];

$myArray = explode(' - ', $myString);  

$daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';

}else{

$daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" ' ;

}

$changeQuery9 ='';

if($_REQUEST['destinationId']!=''){

$changeQuery9 = " and destinationId ='".clean($_REQUEST['destinationId'])."' ";

}

$rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId in (select id from quotationMaster where status=1 order by id desc ) '.$daterangeQuery.' '.$changeQuery9.'order by id desc '); 
$sn=0;
while($resultlists=mysqli_fetch_array($rs)){  

++$sn;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id desc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id desc '); 

$queryData=mysqli_fetch_array($rsquery);

$rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by hotelName desc '); 

$hotelData=mysqli_fetch_array($rsHotel);

$sele='*';

$whereDest=' id="'.$queryData['destinationId'].'" ';   

$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);

$ddest=mysqli_fetch_array($rsDest);

$outputCityWise.='<tr style="text-align:center;">';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE"> '.$sn.'</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE"> <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id='.encode($queryData['id']).'"  style="color:#45b558 !important;">'.makeQueryTourId($queryData['id']).'</a></div></td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';
if($resultlists['arrivalDate']=='' || $resultlists['arrivalDate']=='1970-01-01'){ $outputCityWise.=date('d-m-Y',strtotime($resultlists['fromDate'])); }else{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['arrivalDate'])); } 
$outputCityWise.='</td>';

//and quotationId='.$resultlists['quotationId']

$rsMode=GetPageRecord('*','quotationModeMaster','dayId="'.$resultlists['dayId'].'" and quotationId="'.$resultlists['quotationId'].'" group by dayId order by id desc ' );

$Mode=mysqli_fetch_assoc($rsMode);
	$modeName = $Mode['name'];

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$modeName.'</td>';

//=======================vehicle type======================
$vehicleQuery=GetPageRecord('vehicleType','quotationTransferMaster',' quotationId="'.$resultlists['quotationId'].'" order by id asc '); 

$vehicleQueryType=mysqli_fetch_array($vehicleQuery); 

$vehicleNameQuery=GetPageRecord('name','vehicleTypeMaster',' id="'.$vehicleQueryType['vehicleType'].'" order by id asc '); 

$vehicleName=mysqli_fetch_array($vehicleNameQuery); 



$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$vehicleName['name'].'</td>';



$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>';



$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>';



// $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>';

$totalPax = $queryData['adult']+$queryData['child'];


$outputCityWise.='<td>'.$totalPax.'</td>';

$operationPersonQuery=GetPageRecord('firstName,lastName','userMaster',' id="'.$queryData['assignTo'].'" order by id asc '); 

$operationPerson=mysqli_fetch_array($operationPersonQuery);
// var_dump($operationPersonQuery);
// $outputCityWise.='<td>'. $queryData['assignTo'].'</td>';

$outputCityWise.='<td>'.$operationPerson['firstName'].' '.$operationPerson['lastName'].'</td>';

$outputCityWise.='</tr>'; 


}  

$rs=GetPageRecord('*','quotationSightseeingMaster',' 1 and queryId in (select id from quotationMaster where status=1) '.$datewhere.' '.$daterangeQuery.' order by id asc ');  


while($resultlists=mysqli_fetch_array($rs)){   




++$sn;



$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('displayId,adult,child,infant','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);

$rsSight=GetPageRecord('sightseeingName','packageBuilderSightseeingMaster',' id="'.$resultlists['sightseeingNameId'].'" order by id asc '); 

$sightseeingData=mysqli_fetch_array($rsSight);

$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

$driverData=mysqli_fetch_array($rsDv);

$outputCityWise.='<tr style="text-align:center;">';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$sn.'</td>';
$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id='.encode($queryData['id']).'"  style="color:#45b558 !important;">'.makeQueryTourId($queryData['id']).'</a></div></td>';
$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';
if($resultlists['arrivalDate']=='' || $resultlists['arrivalDate']=='1970-01-01')
{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['fromDate'])); }
else{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['arrivalDate'])); }
$outputCityWise.='</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">&nbsp;</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">&nbsp;</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">&nbsp;</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['guest1'].' </td>';

$outputCityWise.='<td></td>';
$outputCityWise.='<td></td>';

$outputCityWise.='</tr>'; 

} 

$rs=GetPageRecord('*','quotationTransferMaster',' 1 and quotationId in (select id from quotationMaster where status=1) '.$datewhere.' '.$daterangeQuery.' order by id asc ');  

while($resultlists=mysqli_fetch_array($rs)){  

++$sn;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('destinationId,displayId,adult,child,infant','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery); 



$selveh='carType';  



$whereveh='carType="'.$resultlists['vehicleId'].'"'; 



$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 



$vehicalname=mysqli_fetch_array($rsveh); 

// print_r($vehicalname);

$rsTrnsf=GetPageRecord('transferName,transferCategory','packageBuilderTransportMaster',' id="'.$resultlists['transferNameId'].'" order by id asc '); 

$transferData=mysqli_fetch_array($rsTrnsf);

$sele='*';



$whereDest=' id="'.$queryData['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);



$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


$outputCityWise.='<tr style="text-align:center;">';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$sn.'</td>';
$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id='.encode($queryData['displayId']).'"  style="color:#45b558 !important;">'.makeQueryTourId($queryData['displayId']).'</a></div></td>';

// $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryId($queryData['displayId']).' </td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';
if($resultlists['arrivalDate']=='' || $resultlists['arrivalDate']=='1970-01-01')
{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['fromDate'])); }
else{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['arrivalDate'])); }
$outputCityWise.='</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$transferData['transferCategory'].'</td>';



$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'; 



if ($vehicalname['carType']==1) {



$outputCityWise.='Hatchback';



} 



if ($vehicalname['carType']==2) {



$outputCityWise.='Sedan';



} 



if ($vehicalname['carType']==3) {



$outputCityWise.='MPV';



} 



if ($vehicalname['carType']==4) {



$outputCityWise.='SUV';



}  
$outputCityWise.='</td>';



$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>';



$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['guest1'].'</td>';

$outputCityWise.='<td></td>';
$outputCityWise.='<td></td>';

$outputCityWise.='</tr>'; 
} 

$rs=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' 1 and quotationId in (select id from quotationMaster where status=1) '.$datewhere.' '.$daterangeQuery.' order by id asc ');  

while($resultlists=mysqli_fetch_array($rs)){  

++$sn;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('displayId,adult,child,infant','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery); 

$rstrain=GetPageRecord('trainName',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$resultlists['trainId'].'" order by id asc '); 

$trainData=mysqli_fetch_array($rstrain);

$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

$driverData=mysqli_fetch_array($rsDv);

$outputCityWise.='<tr style="text-align:center;">';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$sn.'</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryId($queryData['displayId']).'</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';
if($resultlists['arrivalDate']=='' || $resultlists['arrivalDate']=='1970-01-01')
{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['fromDate'])); }
else{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['arrivalDate']));}
$outputCityWise.='</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">Train</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">&nbsp;</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">&nbsp;</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['guest1'].'</td>';

//  $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>';

//  $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['child'].'</td>';

//  $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['infant'].'</td>';

$outputCityWise.='<td></td>';
$outputCityWise.='<td></td>';

$outputCityWise.='</tr>'; 
}
$rs=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' 1 and quotationId in (select id from quotationMaster where status=1) '.$datewhere.' '.$daterangeQuery.' order by id asc ');  

while($resultlists=mysqli_fetch_array($rs)){  

++$sn;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('displayId,adult,child,infant','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery); 

$rsflight=GetPageRecord('flightName',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$resultlists['flightId'].'" order by id asc '); 

$flightData=mysqli_fetch_array($rsflight);

$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 

$driverData=mysqli_fetch_array($rsDv);

$outputCityWise.='<tr style="text-align:center;">';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$sn.'</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryId($queryData['displayId']).'</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';
if($resultlists['arrivalDate']=='' || $resultlists['arrivalDate']=='1970-01-01')
{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['fromDate'])); }
else{ $outputCityWise.=date('d-m-Y',strtotime($resultlists['arrivalDate'])); }
$outputCityWise.='</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">Flight</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">&nbsp;</td>';
$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">&nbsp;</td>';

$outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['guest1'].'</td>';

// $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>';

// $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['child'].'</td>';

// $outputCityWise.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['infant'].'</td>';
$outputCityWise.='<td></td>';
$outputCityWise.='<td></td>';
$outputCityWise.='</tr>'; 
}
$outputCityWise.='</tbody>';
$outputCityWise.='</table>';
echo $outputCityWise;
?>
<style>

table a {
color: #2ca1cc !important;
}

#movetment input { 
width:100%; 

padding: 3px !important;
}

table.dataTable tfoot th, table.dataTable tfoot td { 
border-top:0px solid #111 !important;
padding: 6px 10px 6px 10px !important;
}

#movetment_filter{display:none !important;}
#movetment_length{display:none !important;}
</style> 
<script>   
/*$(document).ready(function() { 
$('#movetment tfoot th').each( function () {
var title = $(this).text();
$(this).html( '<input type="text" placeholder="'+title+'" />' );
} );
var table = $('#movetment').DataTable();
table.columns().every( function () {
var that = this;
$( 'input', this.footer() ).on( 'keyup change clear', function () {
if ( that.search() !== this.value ) {
that
.search( this.value )
.draw();
}
} );
} );
} );*/

$(document).ready(function() {
$('#example').DataTable( 
{
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'City Wise Booking Report'},
{extend: 'excelHtml5', title: 'City Wise Booking Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'City Wise Booking Report'}
],
language: { 
search: "Search: ",
searchPlaceholder: "Leadpax name , Destination , Operation Person",
},
}
//   {
//     "order": [[ 1, "asc" ]]
// } 
);
});

</script>
<!-- <div class="pagingdiv">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tbody>
<tr>

<td>
<table border="0" cellpadding="0" cellspacing="0">

<tr>

<td style="padding-right:20px;"><?php echo $no; ?> entries</td>
<td>

<select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >

<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>

<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>

<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>

<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
</select> </td>
</tr>
</table> </td>
<td align="right">
<div class="pagingnumbers"><?php echo $paging; ?></div> </td>
</tr>
</tbody>
</table>
</div> -->
</div>
<div style="text-align:center; margin-top:30px; display:none;">
<form method="post" name="downloadrtm" id="downloadrtm" action="allReports/download_report.php" target="actoinfrm">
<input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
</td>
</tr>
</table>
<?php }?>



<?php if($_REQUEST['report']=='26'){

?>


<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->

<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script> -->

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get">



<div class="" style="position:relative"><table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<h3 class="cms_title" style="padding-left:70px">  Hotel Chain Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:12px;">Expand</span>


<td><div class="headingm" ><span id="topheadingmain"> </span>


<div id="deactivatebtn" style="display:none;">



<?php if($deletepermission==1){ ?> 

<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />



<?php } ?>



</div>







</div></td>



<td align="right" ><table border="0" cellpadding="0" cellspacing="0">



<tr>



<td style="position:absolute;top:77px;left:244px">



<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

<?php

$daterangeQuery='';
$strWhere='';
if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = $myArray[0];
$toDate = $myArray[1];

$fromDate = date('Y-m-d', strtotime($fromDate));

$toDate = date('Y-m-d', strtotime($toDate));

$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
$daterangeQuery=' and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"  ';
}
else
{
$fromDate = date('Y-m-d', strtotime($_REQUEST['fromDate']));

$toDate = date('Y-m-d', strtotime($_REQUEST['toDate']));

$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
$daterangeQuery=' and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"  ';

}


?>         


<td width="59%" style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>

<td style="padding:0px 0px 0px 5px;" ><select name="hotelChain" id="hotelChain"  class="topsearchfiledmainselect"   style="width:180px;" >



<option value="">Select Hotel Chain</option>



<?php 

$strWhere='';


if($hotelChain!=''){  



$strWhere.=' and hotelChain='.$hotelChain.'';



}



if($destinationId!=''){  



$strWhere.=' and destinationId='.$destinationId.'';



}



if($categoryId!=''){  



$strWhere.=' and categoryId='.$categoryId.'';



}



if($tourType!=''){  



$strWhere.=' and tourType='.$tourType.'';



}


$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' deletestatus=0 order by name asc ';  



$rs=GetPageRecord($select,'chainhotelmaster',$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($hotelChain==$resListing['id']){ ?>selected="selected"<?php  } ?>> <?php echo $resListing['name']; ?></option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="width:200px; " >



<option value="">Destinations</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;" >



<select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="width:150px; " >



<option value="">All Hotel </option>



<?php 

$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' status=0  order by hotelName asc';  



$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$hotelId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['hotelName']); ?></option>



<?php } ?>



</select></td>

<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="report" id="report" type="hidden" value="26" />

<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>



</tr>



</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="26" />



</td>







</tr>







</table></td>



</tr>







</table>

<script>
$(function() {

$('input[name="daterange"]').daterangepicker({
"autoApply": true,

opens: 'right',
locale: {
format: 'DD-MM-YYYY'
}
}, function(start, end, label) { 
});
});

</script>

<script>



loadsearchClients();



$('#fromDate_y').Zebra_DatePicker({



format: 'd-m-Y',  



pair: $('#toDate_y'),



});



$('#toDate_y').Zebra_DatePicker({
format: 'd-m-Y',

});
</script>



</div>



</form>



<style>
#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 190px;
}
</style>



<div id="margin" class="filterable" style="padding:0px 5px;padding-top:44px">

<?php

$hotelChainOutput='';
$sn=1;
$hotelChainOutput.='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" class="table tablesorter gridtable sortable  responsive headerClass" id="example"  >



<thead> 



<tr style="font-family:normal;text-transform:uppercase;text-align:center;">


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">S.No.</th>';

// <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Query</th>

// <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"><span class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DATE</span></th>



$hotelChainOutput.='<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Hotel&nbsp;Chain </th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Hotel&nbsp;Name</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49!important; color:#FFFFFF;">Room&nbsp;TYPE</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DESTINATION</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">TOTAL&nbsp;ROOM </th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">TOTAL&nbsp;PAX</th>



<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">NO(S)&nbsp;NIGHTS</th>
<th width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">NO(S)&nbsp;Total Amount</th>


</tr>



</thead>



<tbody style="text-align:center; color: #000; font-size: 13px;"  >';





$changeQuery = " "; 



if($_REQUEST['hotelChain']!=''){



$changeQuery = " and supplierId in ( select id from "._PACKAGE_BUILDER_HOTEL_MASTER_." where 1 and hotelChain ='".clean($_REQUEST['hotelChain'])."' )  ";



}



if($_REQUEST['destinationId']!=''){



$changeQuery2 = " and destinationId ='".clean($_REQUEST['destinationId'])."' ";



}



$totalpax=0;



$totalnights=0;



$totalroom=0;

$totalRoomCost=0;

if($_REQUEST['hotelId']!=''){



$changeQuery3 = " and supplierId ='".clean($_REQUEST['hotelId'])."' ";



}


// daterangeQuery
$rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId in (select id from quotationMaster where status=1 ) '.$daterangeQuery.' '.$changeQuery.' '.$changeQuery2.' '.$changeQuery3.' order by fromDate asc '); 

while($hotelQuotData=mysqli_fetch_array($rs)){  



// $rsh=GetPageRecord('*','finalQuote',' quotationId="'.($hotelQuotData['quotationId']).'" and shareQuoteStatus = 2 and hotelQuotationId="'.$hotelQuotData['id'].'" order by id desc limit 1'); 

$rsh=GetPageRecord('*','finalQuote',' quotationId="'.($hotelQuotData['quotationId']).'" and hotelQuotationId="'.$hotelQuotData['id'].'" order by id desc limit 1'); 


$finalQuoteHotel = mysqli_fetch_array($rsh);



if(mysqli_num_rows($rsh) > 0){
$signleRoomCost=0;
$doubleRoomCost=0;
$trippleRoomCost=0;
$allRoomCost=0;
$Room=0;    
if($finalQuoteHotel['roomSingle2']!='') 
{
$signleRoomCost=$finalQuoteHotel['roomSingle2']*$finalQuoteHotel['roomSingleCost2'];
$totalroom+=$finalQuoteHotel['roomSingle2'];
$Room+=$finalQuoteHotel['roomSingle2'];
// $totalRoomCost+=$signleRoomCost;
}    
if($finalQuoteHotel['roomDouble2']!='') 
{
$doubleRoomCost=$finalQuoteHotel['roomDouble2']*$finalQuoteHotel['roomDoubleCost2'];
$totalroom+=$finalQuoteHotel['roomDouble2'];
$Room+=$finalQuoteHotel['roomDouble2'];
// $totalRoomCost+=$doubleRoomCost;
}
if($finalQuoteHotel['roomTriple2']!='') 
{
$trippleRoomCost=$finalQuoteHotel['roomTriple2']*$finalQuoteHotel['roomTripleCost2'];
$totalroom+=$finalQuoteHotel['roomTriple2'];
$Room+=$finalQuoteHotel['roomTriple2'];
// $totalRoomCost+=$trippleRoomCost;
}

$taxQuery=GetPageRecord('*','quotationMaster',' id='.$finalQuoteHotel['quotationId']); 


$taxQueryData = mysqli_fetch_array($taxQuery);

$serviceTax = $taxQueryData['serviceTax'];

$allRoomCost=$signleRoomCost+$doubleRoomCost+$trippleRoomCost;

$allRoomCost = $allRoomCost+($serviceTax*$allRoomCost)/100;
$totalRoomCost+=$allRoomCost;
// $pax = 0;





$pax = $finalQuoteHotel['roomSingle']+($finalQuoteHotel['roomDouble'])+($finalQuoteHotel['roomTriple'])+($finalQuoteHotel['roomextra']);



$earlier1 = new DateTime($hotelQuotData['fromDate']);



$later1 = new DateTime($hotelQuotData['toDate']);



$nightstay=0;



$nightstay=$later1->diff($earlier1)->format("%a");



if($nightstay == 0){ $nightstay = $nightstay+1;}else{ $nightstay; }







$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$finalQuoteHotel['supplierId'].'"'); 



$suppData=mysqli_fetch_array($b);  







$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$finalQuoteHotel['hotelId'].'"'); 



$hotelData=mysqli_fetch_array($c); 







$d=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotelQuotData['roomType'].'"'); 



$roomtypeData=mysqli_fetch_array($d);







$d1=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$hotelQuotData['quotationId'].'"'); 



$quotationData=mysqli_fetch_array($d1);







$d2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'"'); 



$queryData=mysqli_fetch_array($d2);







$f=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$hotelQuotData['destinationId'].'"'); 



$destData=mysqli_fetch_array($f);







$chainQuery=GetPageRecord('name','chainhotelmaster',' id="'.$hotelData['hotelChain'].'" and deletestatus=0 order by name asc');



$chainName=mysqli_fetch_array($chainQuery);  







$hotelChainOutput.='<tr style="text-align:center;">';



$hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$sn.'</td>';

// $hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryId($queryData['displayId']).'</td>';



// $hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">';
//     if($hotelQuotData['fromDate']=='' || $hotelQuotData['fromDate']=='1970-01-01')
//     { $hotelChainOutput.=date('d-m-Y',strtotime($hotelQuotData['fromDate'])); }
//     else{ $hotelChainOutput.=date('d-m-Y',strtotime($hotelQuotData['fromDate'])); }
//     $hotelChainOutput.='</td>';



$hotelChainOutput.='<td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$chainName['name'].'</td>';



$hotelChainOutput.='<td align="left" valign="middle" bgcolor="#FAFDFE">'.$hotelData['hotelName'].'</td>';



$hotelChainOutput.='<td align="left" valign="middle" bgcolor="#FAFDFE">'.$roomtypeData['name'].'</td>';



$hotelChainOutput.='<td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$destData['name'].'</td>';

$hotelChainOutput.='<td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$Room.'</td>';


// $hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$pax.'</td>';
$totalpax = $totalpax+$quotationData['adult']+$quotationData['child']+$quotationData['infant'];; 

$pax = $quotationData['adult']+$quotationData['child']+$quotationData['infant'];

$hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$pax.' </td>';
// $totalpaxmain=$quotationData['adult']+$quotationData['child']; $totalroom=$totalroom+$quotationData['adult']+$quotationData['child']+$quotationData['infant']; 
$totalpaxmain=$quotationData['adult']+$quotationData['child'];

$hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$quotationData['night'].'</td>';
$hotelChainOutput.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.getTwoDecimalNumberFormat($allRoomCost).'</td>';
$totalnight=$totalnight+$quotationData['night'];  


$hotelChainOutput.='</tr>'; 


++$sn;
}  } 







$hotelChainOutput.='<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">';

$hotelChainOutput.='<td align="center" valign="middle"><strong>'.$sn.'</strong></td>';

$hotelChainOutput.='<td align="center" valign="middle"><strong> Total</strong></td>';



$hotelChainOutput.='<td align="center" valign="middle">&nbsp;</td>';



//  $hotelChainOutput.='<td align="center" valign="middle">&nbsp;</td>';



//  $hotelChainOutput.='<td align="center">&nbsp;</td>';



//  $hotelChainOutput.='<td align="center">&nbsp;</td>';



$hotelChainOutput.='<td align="center">&nbsp;</td>';

$hotelChainOutput.='<td align="center">&nbsp;</td>';

//<style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>

$hotelChainOutput.='<td align="center">'.$totalroom.'</td>';

$hotelChainOutput.='<td align="center">'.$totalpax.'</td>';  

$hotelChainOutput.='<td align="center">'.$totalnight.'</td>';
$hotelChainOutput.='<td align="center">'.getTwoDecimalNumberFormat($totalRoomCost).'</td>';


$hotelChainOutput.='</tr>'; 



$hotelChainOutput.='</tbody>';



$hotelChainOutput.='</table>';

echo $hotelChainOutput;
?>
</div>  </td>



</tr>







<?php if($_REQUEST['sp']=='1'){?>  
<tr>
<td width="91%" align="left" valign="top">
</td>



</tr><?php }?>

</table>



<script> 



window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');


$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function(settings, json){
		$("#example").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");
	},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Hotel Chain Report'},
{extend: 'excelHtml5', title: 'Hotel Chain Report'},
{extend: 'pdfHtml5', title: 'Hotel Chain Report',
orientation: 'landscape',
pageSize: 'A4'

}
],
language: { 
search: "Search: ",
searchPlaceholder: "Serach By Keyword",
},
}
);
} );
</script>

<?php }?>





<?php if($_REQUEST['report']=='29'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="29" />



<h3 class="cms_title" style="padding-left:70px">Tour Registration Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<!-- <td width="1050" align="center">&nbsp;</td> -->



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<td style="padding:0px 0px 0px 5px;"><input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent"></td> 
<td style="padding:0px 0px 0px 5px;">
<select name="guide" id="guide" style="padding:9px;">
<?php  
$a12=GetPageRecord('*',_GUIDE_MASTER_,' 1 order by name asc'); 
while($guideData=mysqli_fetch_array($a12)){ 
?>
<option value="<?php echo strip($guideData['id']); ?>"><?php echo $guideData['name'];?></option>
<?php 
} 
?>
</select></td>


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

</style>
<?php
$output='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable" style="width:100%">
<thead>
<tr>
<th width="10" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">TOUR Code</th>



<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent Name</th>



<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Enquiry Name</th>


<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Query.Date</th>


<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Arrival Date</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Dept. Date</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Opp. Person</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> File Handler</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Status</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Days</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Pax</th>

</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >';


$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
$datewhere1  = 'and srdate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
}

$daterangeQuery='';

$daterangeQuery1 = '';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;
$daterangeQuery1  = 'and srdate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
$datewhere='';
$datewhere1='';
}


if($_GET['agentname']!=''){

$agentname = 'and queryId in (select id from queryMaster where companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['agentname'].'%") or companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_GET['agentname'].'%" or lastName like "%'.$_GET['agentname'].'%" ))';
}else{

$agentname = ' ' ;
}


$rs="SELECT * FROM `destinationMaster` join packageQueryDays on destinationMaster.id = packageQueryDays.cityId and countryId!=0 and queryId in (select queryId from quotationMaster where status=1) ".$daterangeQuery1." ".$datewhere1." ".$agentname."  GROUP BY countryId";
$rs12 =mysqli_query(db(),$rs);
while($resultlists=mysqli_fetch_array($rs12)){

$rscom=GetPageRecord('*',_COUNTRY_MASTER_,'1 and id="'.$resultlists['countryId'].'"'); 
$countryResult=mysqli_fetch_array($rscom);



$output.='<tr style="text-align:center;">
<td colspan="13" align="left" style="color: #4CAF4D;"><strong>Country Name:&nbsp;&nbsp;'.$countryResult['name'].'</strong></td>
</tr>';

$no = 0;
$totaldays = 0;
$pax = 0;
$rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from packageQueryDays where cityId in (select id from destinationMaster where countryId="'.$resultlists['countryId'].'")) and status=1 '.$daterangeQuery.''.$datewhere.' '.$agentname.''); 
$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){

$no++;

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;

$totaldays = $totaldays+$days;

$pax = $pax+$totalpax;


$output.='<tr style="text-align:center;">';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$no.'</td>';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id='.encode($queryData['id']).'"  style="color:#45b558 !important;">'.makeQueryTourId($queryData['id']).'</a></div></td>';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>';


$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['subject'].'</td>';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.date('d-m-Y',strtotime($queryData['queryDate'])).'</td>';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.date('d-m-Y',strtotime($quotationResult['fromDate'])).'</td>';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($quotationResult['toDate'])).'</td>';

$output.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.getUserName($queryData['assignTo']).'</td>';



$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.getUserName($queryData['assignTo']).'</td>';
$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">Confirmed</td>';
$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$days.'</td>';
$output.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$totalpax.'</td>';


$output.='</tr>'; 


}


$output.='<tr style="text-align:center;">';
$output.='<td colspan="6" align="left" style="color: #4CAF4D;"><strong>No of Tour:&nbsp;&nbsp;'.$countTour.'</strong></td>';
$output.='<td colspan="4" align="right" style="color: #4CAF4D;" ><strong>Sub Total</strong></td>';
$output.='<td colspan="1" align="center" style="color: #4CAF4D;" >'.$totaldays.'</td>';
$output.='<td colspan="1" align="center" style="color: #4CAF4D;" >'.$pax.'</td>';
$output.='</tr>'; 

$grandTotalPax = $grandTotalPax+$pax; $totaldayst = $totaldayst+$totaldays; $sno = $sno+$countTour; 
} 

$output.='<tr style="text-align:center;">';
$output.='<td colspan="6" align="left" style="color: #4CAF4D;"><strong>Total No of Tour:&nbsp;&nbsp;'.$sno.'</strong></td>';
$output.='<td colspan="4" align="right" style="color: #4CAF4D;" ><strong>Grand Total</strong></td>';
$output.='<td colspan="1" align="center" style="color: #4CAF4D;" >'.$totaldayst.'</td>';
$output.='<td colspan="1" align="center" style="color: #4CAF4D;" >'.$grandTotalPax.'</td>';
$output.='</tr>'; 

$output.='</tbody>';

$output.='</table>';
echo $output;
?>     

<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{dom: 'frtilpB',
buttons: [
'copyHtml5',
'excelHtml5',
// 'csvHtml5',
'pdfHtml5'
]
}
);
} );
</script>

</div>

</td>



</tr>



</table>

<?php }?>

<?php if($_REQUEST['report']=='32'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="32" />



<!-- <h3 class="cms_title" style="padding-left:70px">Hotel Details Report</h3> -->
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td width="400" align="center">&nbsp;</td>



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<!--  <td style="padding:0px 0px 0px 5px;"><input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent"></td> -->




<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;"  onchange="getallHotel();" >



<option value="">Select Destination</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;" ><select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">
</select></td> 




<script type="text/javascript">
function getallHotel() {

var destinationId = $('#destinationId').val();
var hotelIdr = '<?php echo $_REQUEST['hotelId']; ?>';
$('#hotelId').load('loaddeswisehotel.php?destinationId='+destinationId+'&hotelIdr='+hotelIdr);

}
getallHotel();
</script>          


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 

</style>
<?php

$outputP = '<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable" style="width:100%">
<thead>
<tr>
<th  width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th  width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour Code</th>   
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Hotel Name</th>



<th  width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Hotel Group</th>



<th  width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Category</th>


<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Address</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;padding: 0px !important;border-bottom:0px !important;border-top:0px !important;">

<table  border="1" cellpadding="0" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable"    >
<tr>
<th colspan="4" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Sales Manager</th>
</tr>
<tr>

<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important; width:25%;">Contact Name</th>
<th  bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important; width:20%;">Contact NO </th>
<th  bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important; width:20%;">Destination</th>
<th  bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important; width:35%;">Email</th>
</tr>
</table>
</th>



<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Website</th>

<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Check-In Time</th>



</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >';


if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'")';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'")';

$datewhere='';
}


if($_GET['hotelId']!=''){

$hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
}else{

$hotelserch = '  ' ;
}

if($_GET['destinationId']!=''){

$destinationId = ' and destinationId="'.$_GET['destinationId'].'"' ;
}else{

$destinationId = '  ' ;
}


$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 '.$datewhere.''.$daterangeQuery.' '.$destinationId.' and destinationId!=0 group by destinationId order by fromDate desc'); 
while($resultlists=mysqli_fetch_array($rs)){

$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
$destinationResult=mysqli_fetch_array($rsdes);




$outputP .='<tr style="text-align:center;">
<td colspan="13" align="left" style="color: #4CAF4D;"><strong>City Name:&nbsp;&nbsp;'.$destinationResult['name'].'</strong></td>
</tr>';


$no = 0;

$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.''); 
$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){

$no++;

$rsHot=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$quotationResult['supplierId'].'" order by id asc '); 
$hotelData=mysqli_fetch_array($rsHot);

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;

$totaldays = $totaldays+$days;

$pax = $pax+$totalpax;

$rsu=GetPageRecord('*',hotelContactPersonMaster,' corporateId="'.$quotationResult['supplierId'].'" and division=1 '); 
$resListingu=mysqli_fetch_array($rsu);


$rsh=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' id="'.$quotationResult['categoryId'].'"  '); 
$resListingh=mysqli_fetch_array($rsh);
// var_dump($resListingh);
$rsc=GetPageRecord('*','chainhotelmaster',' id="'.$hotelData['hotelChain'].'"  '); 
$resListingc=mysqli_fetch_array($rsc);



$outputP .='<tr style="text-align:center;">';

$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$no.'</td>';

$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id='.encode($queryData['id']).'"  style="color:#45b558 !important;">'.makeQueryTourId($queryData['id']).'</a></div></td>';



$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.strip($hotelData['hotelName']).'&nbsp;';
if ($quotationResult['supplementHotelStatus']==1) { $outputP .='<div style="border: 1px solid #00800042;padding: 4px;margin-top: 5px;">Supplement Hotel</div>'; } 
$outputP .='</td>';


$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE">'.strip($resListingc['name']).'</td>';

$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$resListingh['hotelCategory'].' Star</td>';

$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE">'.strip($hotelData['hotelAddress']).'</td>';



$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><table  border="1" cellpadding="0" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable"  >
<tr>
<td  align="right" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important; width:25%;">'.$resListingu['contactPerson'].'</td>
<td  align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;width:20%;">'.$resListingu['phone'].'</td>';

// $destQuery=GetPageRecord('name','countryMaster',' id="'.$resListingu['countryCode'].'"  '); 
// $country=mysqli_fetch_array($destQuery);                  

// $destQuery=GetPageRecord('name','stateMaster',' id="'.$resListingu['state'].'"  '); 
// $state=mysqli_fetch_array($destQuery);
//'.$country['name'].''.$state['name'].''.$resListingu['state'].' 
$outputP .='<td  align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;width:20%;">'.$resListingu['designation'].'</td>
<td  align="right" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;width:35%;">'.$resListingu['email'].'</td>
</tr>
</table></td>';



$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.strip($hotelData['url']).'</td>';



$outputP .='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$hotelData['checkInTime'].'</td>';




$outputP .='</tr>'; 


}} 



$outputP .='</tbody></table>';

echo $outputP;

?>


<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable();
} );
</script>
</div>

</td>



</tr>



</table>


<div style="text-align:center; margin-top:30px;">

<?php 
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = date('Y-m-d', strtotime($myArray[0]));
$toDate = date('Y-m-d', strtotime($myArray[1]));
}if($_GET['fromDate']!='' && $_GET['toDate']!='')
{
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
}

?>

<!-- <form method="post"  action="downlload_hotel_details.php" target="actoinfrm">
<input type="hidden" name="fromDate" value="<?php echo $fromDate; ?>">
<input type="hidden" name="toDate" value="<?php echo $toDate; ?>">
<input type="hidden" name="hotelId" value="<?php echo $_REQUEST['hotelId']; ?>">
<input type="hidden" name="destinationId" value="<?php echo $_REQUEST['destinationId']; ?>">
<input type="submit" name="export" class="bluembutton" class="btn btn-success" value="Download Report" />
</form> -->

<form method="post"  action="allReports/xlReoprtDownload.php" target="actoinfrm">
<input type="hidden" name="output" value="<?=base64_encode($outputP)?>">
<input type="hidden" name="filename" value="Hotel_Details_Report">
<input type="submit" name="export" class="bluembutton" class="btn btn-success" value="Download Report" />
</form>


</div>


<?php }?>

<?php if($_REQUEST['report']=='33'){ ?>

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script>

$(function() {

$('input[name="daterange"]').daterangepicker({

"autoApply": true,

opens: 'right',

locale: {

format: 'DD-MM-YYYY'

}

}, function(start, end, label) { 

});

});
</script>  

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

<td width="91%" align="left" valign="top">

<form method="get" >

<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="report" id="report" type="hidden" value="33" />

<h3 class="cms_title" style="padding-left:70px;">Room Night Analysis From Itinerary Reports</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">

<table width="100%" border="0" cellpadding="10" cellspacing="0">

<tr>

<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<!--  <td style="padding:0px 0px 0px 5px;"><input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if($_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent"></td> -->

<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;"  onchange="getallHotel();" >

<option value="">Select Destination</option>

<?php 

$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;" ><select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">
</select></td> 




<script type="text/javascript">
function getallHotel() {

var destinationId = $('#destinationId').val();
var hotelIdr = '<?php echo $_REQUEST['hotelId']; ?>';
$('#hotelId').load('loaddeswisehotel.php?destinationId='+destinationId+'&hotelIdr='+hotelIdr);

}
getallHotel();
</script>          


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

</style>

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable" style="width:100%">
<thead>
<tr>
<th  width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th  width="100" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour Code</th>   
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Tour Name</th>

<th  width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent/Client Name</th>

<th  width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Pax</th>

<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;padding: 0px !important;border-bottom:0px !important;border-top:0px !important;">
<table  border="1"    cellpadding="0" cellspacing="0" id="example" class="display table tablesorter gridtable sortable">
<tr>
<th colspan="3" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Accommodation</th>
<th colspan="3" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">FOC</th>
</tr>
<tr>
<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">SGL</th>
<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">DBL </th>
<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">TPL</th>
<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">SGL</th>
<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">DBL</th>
<th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">TPL</th>
</tr>
</table>
</th>



<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Check In Date</th>

<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Check Out Date</th>

<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Room</th>

<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Nights</th>

<th width="100"  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Room Nights</th>

</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >


<?php 
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'")';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'")';

$datewhere='';
}


if($_GET['hotelId']!=''){

$hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
}else{

$hotelserch = '  ' ;
}

if($_GET['destinationId']!=''){

$destinationId = ' and destinationId="'.$_GET['destinationId'].'"' ;
}else{

$destinationId = '  ' ;
}


$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 '.$datewhere.''.$daterangeQuery.' '.$destinationId.' and supplierId!=0 group by supplierId order by fromDate desc'); 
while($resultlists=mysqli_fetch_array($rs)){

$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
$destinationResult=mysqli_fetch_array($rsdes);

$rsHots=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$resultlists['supplierId'].'" order by id asc '); 
$hotelDatas=mysqli_fetch_array($rsHots);

?>


<tr style="text-align:center;">
<td colspan="5" align="left" style="color: #4CAF4D;"><strong>City Name:&nbsp;&nbsp;<?php echo $destinationResult['name']; ?></strong></td>

<td colspan="9" align="left" style="color: #4CAF4D;"><strong>Hotel Name:&nbsp;&nbsp;<?php echo $hotelDatas['hotelName']; ?></strong></td>
</tr><?php 
$no = 0;

$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" and supplierId="'.$resultlists['supplierId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.' group by startDayDate,endDayDate'); 
$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){
$no++;
$rsHot=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$quotationResult['supplierId'].'" order by id asc '); 
$hotelData=mysqli_fetch_array($rsHot);

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;

$totaldays = $totaldays+$days;

$pax = $pax+$totalpax;

$rsu=GetPageRecord('*',_USER_MASTER_,' id="'.$queryData['assignTo'].'"  '); 
$resListingu=mysqli_fetch_array($rsu);



?>  

<tr style="text-align:center;">

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $no; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $queryData['subject']; ?></td>


<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $totalpax; ?></td>


<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><table  cellpadding="0" cellspacing="0" >
<tr>
<td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"><?php echo $queryData['sglRoom']; ?></td>
<td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"><?php echo $queryData['dblRoom']; ?></td>
<td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"><?php echo $queryData['tplRoom']; ?></td>
<td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"></td>
<td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"></td>
<td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"></td>
</tr>
</table></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($quotationResult['startDayDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($quotationResult['startDayDate'])); } ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php if($quotationResult['endDayDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($quotationResult['endDayDate']) + 86400); }  ?></td>
<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo ($queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom']); ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['night']; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo ($queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom'])* $queryData['night'];?></td>



</tr> 


<?php } } ?>



</tbody>
<!-- <tfoot>
<tr> <th width="100" align="center">S.No</th>
<th width="100" align="center">TOUR CODE</th>
<th width="100" align="center">AGENT NAME</th>
<th width="100" align="center">Enquiry Name</th>
<th width="100" align="center">Reg.Date</th>
<th width="100" align="center">Arrival Date</th>
<th width="100" align="center">Dept. Date</th>
<th width="100" align="center">Sales Person </th>
<th width="100" align="center">File Handler </th>
<th width="100" align="center">STATUS </th>
<th width="100" align="center">DAYS </th>
<th width="100" align="center">PAX </th>
</tr>
</tfoot> -->
</table>

<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({ 
	"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
dom: 'frtipB',
buttons: [
'copyHtml5',
'excelHtml5',
'pdfHtml5'
]
});
} );
</script>

</div>

</td>



</tr>



</table>

<div style="text-align:center; margin-top:30px;">

<?php 

// if($_GET['daterange']!=''){ 
// $myString = $_GET['daterange'];
// $myArray = explode(' - ', $myString);  
// $fromDate = date('Y-m-d', strtotime($myArray[0]));
// $toDate = date('Y-m-d', strtotime($myArray[1]));
// }if($_GET['fromDate']!='' && $_GET['toDate']!='')
// {
// $fromDate = $_GET['fromDate'];
// $toDate = $_GET['toDate'];
// }

?>

<!-- // <form method="post"  action="allReports/downlload_hotel_room_night_details.php" target="actoinfrm">
// <input type="hidden" name="fromDate" value="<?php echo $fromDate; ?>">
// <input type="hidden" name="toDate" value="<?php echo $toDate; ?>">
// <input type="hidden" name="hotelId" value="<?php echo $_REQUEST['hotelId']; ?>">
// <input type="hidden" name="destinationId" value="<?php echo $_REQUEST['destinationId']; ?>">
// <input type="submit" name="export" class="bluembutton" class="btn btn-success" value="Download Report" />
// </form></div> -->


<?php }?>

<?php if($_REQUEST['report']=='34'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>
<td width="91%" align="left" valign="top" style="width:100vw">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="34" />


<h3 class="cms_title" style="padding-left:70px">Turnover Statement - Proforma Invoice Country Wise </h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>



<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position: relative;padding-top: 26px">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>







<td width="252" align="right" style="position: absolute;top: -8px;left: 259px;width: 100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>


<td style="padding:0px 0px 0px 5px;" >
<select name="country" id="country" class="topsearchfiledmainselect" style="width:180px; padding: 9px; " >

<option value="">All Country</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



// $select='*';  

$select = 'id,name';

//userType=1 and   



$where=' status=1 order by name asc';  



$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['country']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> </option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}

</style>
<?php
$outputp='';
$outputp.='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100%" data-page-length="25" >';
$outputp.='<thead>';
$outputp.='<tr>';
$outputp.='<th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;" >S.No</th>';
$outputp.='<th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;" > COUNTRY</th>
<th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;" > TYPE</th>';


if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){

$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));

}

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  

$fromDate = $myArray[0];
$toDate = $myArray[1];
}

$output = [];
$time   = strtotime($fromDate);
$last   = date('M Y', strtotime($toDate));

do {
$month = date('M Y', $time);
$total = date('t', $time);

$output[] = $month;

$time = strtotime('+1 month', $time);
} while ($month != $last);
$xyz = implode(",", $output);
$output = explode(',', $xyz);

foreach ($output as $monthY) {
$outputp.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$monthY.'</th>';

} 



$outputp.='</tr>';
$outputp.='</thead>';
$outputp.='<tbody style="text-align:center; color: #000; font-size: 13px;" >';

$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';

}

$daterangeQuery='';

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;

$datewhere='';
}

$whereCountry = '';

$rscom='';
//$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,' 1  group by countryId order by id asc');
///while($resultlists=mysqli_fetch_array($rsdes)){
if(isset($_REQUEST['country']) && $_REQUEST['country']!='')
{
$rscom = GetPageRecord('*',_COUNTRY_MASTER_,'id='.$_REQUEST['country'].'  order by id asc');
}
else
{
$rscom=GetPageRecord('*',_COUNTRY_MASTER_,'1 group by name  order by id asc'); 

}
$no=1;
while($countryResult=mysqli_fetch_array($rscom))
{



$outputp.='<tr style="text-align:center;">';
$outputp.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$no.'</strong></td>';    
$outputp.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$countryResult['name'].'</strong></td>';

$outputp.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">Pax<hr style="border-top: 1px dashed black;">Sale</td>';

foreach ($output as $monthY) {

$months = date('m',strtotime($monthY));
$years = date('Y',strtotime($monthY));
$agentAmount = 0;
$totalppax = 0;
$corporateQuery=GetPageRecord('id',_CORPORATE_MASTER_,' countryId="'.$countryResult['id'].'"'); 

// $countTour = mysqli_num_rows($rsquot);
// echo $countTour;
while($corporateResult=mysqli_fetch_array($corporateQuery))
{

$queryMaster=GetPageRecord('id,child,infant,adult',_QUERY_MASTER_,' companyId="'.$corporateResult['id'].'"  and month(queryDate) ="'. $months.'" and  year(queryDate) ="'.$years.'"'); 

while($queryResult=mysqli_fetch_array($queryMaster))
{

$rs1 = GetPageRecord('*',_AGENT_PAYMENT_REQUEST_, 'queryId="'.$queryResult['id'].'"');
$agentPaymentRequestData = mysqli_fetch_array($rs1);

$agentAmount = $agentAmount+$agentPaymentRequestData['finalCost'];

$totalppax = $totalppax+($queryResult['adult']+$queryResult['child']+$queryResult['infant']);

}
// echo 'sasda sasa';
}
//   $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from packageQueryDays where cityId in (select id from destinationMaster where countryId="'.$countryResult['id'].'")) and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 
//   $countTour = mysqli_num_rows($rsquot);
//   // echo $countTour;
//   while($quotationResult=mysqli_fetch_array($rsquot))
//   {
//     $id = $quotationResult['queryId'];
//     echo $id.' ';
//      $rs1 = GetPageRecord('*',_AGENT_PAYMENT_REQUEST_, 'queryId="'.$quotationResult['queryId'].'"');
//      $agentPaymentRequestData = mysqli_fetch_array($rs1);

//      $agentAmount = $agentAmount+$agentPaymentRequestData['finalCost'];
//      $totalppax = $totalppax+($quotationResult['adult']+$quotationResult['child']);
// }


$outputp.='<td align="center"  valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalppax.'<hr style="border-top: 1px dashed black;">'.$agentAmount.'</td>';
++$no;
} 

$outputp.='</tr>'; 
}
$outputp.='</tbody>';

$outputp.='</table>';
echo $outputp;
$outputExcel=base64_encode($outputp);
?>
<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
/* .dataTables_paginate {
float: left !important;
} */
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Turnover Statement - Proforma Invoice Country Wise'},
{extend: 'excelHtml5', title: 'Turnover Statement - Proforma Invoice Country Wise'},
{extend: 'pdfHtml5', title: 'Turnover Statement - Proforma Invoice Country Wise',
orientation: 'landscape',
pageSize: 'LEGAL',
}
],
language: { 
search: "Search: ",
searchPlaceholder: "Search By Keyword",
},
});
} );
</script>

</div>

</td>



</tr>



</table>

<div style="text-align:center; margin-top:30px;">

<?php 
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = date('Y-m-d', strtotime($myArray[0]));
$toDate = date('Y-m-d', strtotime($myArray[1]));
}if($_GET['fromDate']!='' && $_GET['toDate']!='')
{
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
}

?>

<!-- <form method="post"  action="allReports/download_turnover_statement_report.php" target="actoinfrm">
<input type="hidden" name="fromDate" value="<?php echo $fromDate; ?>">
<input type="hidden" name="toDate" value="<?php echo $toDate; ?>">
<input type="hidden" name="country" value='<?=$_REQUEST['country'] ?>'>
<input type="hidden" name="excelFile" value="<?php echo $outputExcel;?>">
<input type="submit" name="export" class="bluembutton" class="btn btn-success" value="Download Report" />
</form></div>
 -->

<?php }?>



<?php if($_REQUEST['report']=='30'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<style>



.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate{



padding: 5px 10px;



border: 1px solid #57a0a4;



background-color: #57a0a4;



color: #ffffff;



border-radius: 3px;



display:none;







}



.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {



padding: 5px 10px;



border: 1px solid #57a0a4;



background-color: #57a0a4;



color: #ffffff;



border-radius: 3px;



margin-top: 1px;



}


.nextprebtn{cursor: pointer; border: 1px solid #ff860a; padding: 6px 15px; border-radius: 3px; background-color: #ff860a; color: #ffffff !important;}



.driverbtn{border: 1px solid #ff860a; padding: 3px 10px; width: fit-content; border-radius: 3px; background-color: #ff860a; color: #ffffff; cursor: pointer;}



.suppicon{font-size: 20px; color: #ff860a; cursor: pointer; }



.gridtable .header { padding-bottom:10px !important; }



</style> 



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="30" />



<h3 class="cms_title">Cenvate Report</h3>



<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td width="400" align="center">&nbsp;</td>



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>
<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;"  onchange="getallHotel();" >



<option value="">City</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;" ><select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">
</select></td> 




<script type="text/javascript">
function getallHotel() {

var destinationId = $('#destinationId').val();
var hotelIdr = '<?php echo $_REQUEST['hotelId']; ?>';
$('#hotelId').load('loaddeswisehotel.php?destinationId='+destinationId+'&hotelIdr='+hotelIdr);

}
getallHotel();
</script>          


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div class="" style=" width:100%;"></div>







<div id="margin" class="filterable" style="padding:0px 5px;">

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

</style>

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable" style="width:100%">



<thead> 



<tr style="font-family:normal;text-transform:uppercase;text-align:center;">


<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">S.NO</th>
<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Tour Code</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">From DATE</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">To DATE</th>




<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Meal Plan</th>





<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Booking Price</th>


<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Base Price</th>



<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.T %</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.T Amt.</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.B.C. %</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.B.C Amt.</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">K.K.C %</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">K.K.C Amt.</th>


</tr>

<tfoot style="position: absolute; width: 100%; top:46px; display:none;" > 



<tr>



<th width="100" align="left" bgcolor="#E0E0E0" style="width: 74.6px;">Query</th>



<th width="100" align="left" bgcolor="#E0E0E0" style="width: 72.6px;">DATE</th>



<th width="100" align="left" bgcolor="#E0E0E0" style="width: 75.8px;">DESTINATION</th>



<th width="100" align="left" bgcolor="#E0E0E0" style="width: 75.8px;">GUIDE</th>

<th width="100" align="left" bgcolor="#E0E0E0" style="width: 75.8px;">&nbsp;</th>

<th width="100" align="left" bgcolor="#E0E0E0" style="width: 75.8px;">&nbsp;</th>



<th width="100" align="left" bgcolor="#E0E0E0" style="width: 75.4px;">GUEST</th>

</tr>

</tfoot >

<tbody style="text-align:center; color: #000; font-size: 13px;"  >

<?php 

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'")';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'")';

$datewhere='';
}


if($_GET['hotelId']!=''){

$hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
}else{

$hotelserch = '  ' ;
}

if($_GET['destinationId']!=''){

$destinationId = ' and destinationId="'.$_GET['destinationId'].'"' ;
}else{

$destinationId = '  ' ;
}


$rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId in (select id from quotationMaster where status=1) '.$daterangeQuery.' '.$datewhere.' '.$destinationId.' group by destinationId  order by id asc '); 
while($resultlists=mysqli_fetch_array($rs)){  
++$no;

$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
$destinationResult=mysqli_fetch_array($rsdes);

?>


<tr style="text-align:center;">
<td colspan="13" align="left" style="color: #4CAF4D;"><strong>City Name:&nbsp;&nbsp;<?php echo $destinationResult['name']; ?></strong><br></td>
</tr>
<?php 
$rsdwh=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.' group by supplierId'); 
while($quotationDesWiseResult=mysqli_fetch_array($rsdwh)){
$rsHot=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$quotationDesWiseResult['supplierId'].'" order by id asc '); 
$hotelData=mysqli_fetch_array($rsHot);
?>
<tr style="text-align:center;">
<td colspan="1" align="left" style=""></td>
<td colspan="12" align="left" style="color: #4CAF4D;"><strong>Hotel Name:&nbsp;&nbsp;<?php echo $hotelData['hotelName']; ?></strong></td>
</tr>
<?php
$no = 0;
$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$quotationDesWiseResult['destinationId'].'" and supplierId="'.$quotationDesWiseResult['supplierId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.' group by startDayDate,endDayDate'); 
$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){
$no++;
$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;
$totaldays = $totaldays+$days;
$pax = $pax+$totalpax;
$rsu=GetPageRecord('*',_USER_MASTER_,' id="'.$queryData['assignTo'].'"  '); 
$resListingu=mysqli_fetch_array($rsu);
?>  

<tr style="text-align:center;">

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $no; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>


<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($quotationResult['startDayDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($quotationResult['startDayDate'])); } ?></td>


<td align="center" valign="middle" bgcolor="#FAFDFE"><?php if($quotationResult['endDayDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($quotationResult['endDayDate'])); }  ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"></td>


<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"></td>
<td align="center" valign="middle" bgcolor="#FAFDFE"></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"></td>

</tr> 

<?php  }}} ?>

</tbody>

</table>

<script>   




$(document).ready(function() {



$('#example').DataTable(

);



} );



</script>


</div>



<div style="text-align:center; margin-top:30px; display:none;">



<form method="post" name="downloadrtm" id="downloadrtm" action="allReports/download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div></td>



</tr>



</table>



















<?php }?>




<?php if($_REQUEST['report']=='36'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="36" />



<h3 class="cms_title" style="padding-left:70px">Hotel Room Night Analysis - Summary</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;position:relative;padding-top:52px">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td  align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td width="629" align="center">&nbsp;</td>



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr style="position: absolute;top: 22px;left: 218px;">
<td  style="padding:0px 0px 0px 5px;"><select name="destinationId" id="destinationId" class="topsearchfiledmainselect"  style="border-radius:0px!important;width: 170px;">



<option value=""> Select Destination</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td  style="padding:0px 0px 0px 5px;"><select name="hotelName" id="hotelName" class="topsearchfiledmainselect"   style="border-radius:0px!important;width: 170px;" >



<option value="">Select Hotel</option>



<?php  



$hotelNameQuery=GetPageRecord('*','packageBuilderHotelMaster','  status=1 order by hotelName asc'); 



while($hotelNameData=mysqli_fetch_array($hotelNameQuery)){  



?>



<option value="<?php echo strip($hotelNameData['id']); ?>" <?php if($_REQUEST['hotelName']==$hotelNameData['id']){ ?>selected="selected"<?php  } ?>><?php echo strip($hotelNameData['hotelName']); ?></option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}

#example_filter {
position: absolute;
top: -64px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 170px;
}

</style>
<?php

$outputP='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100%" data-page-length="25">
<thead>
<tr>
<th width="10%" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th width="30%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Hotel Name</th>



<th width="15%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Destination</th>



<th width="15%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Night</th>


<th width="15%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Rooms</th>


<th width="15%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Room Nights</th>



<th width="15%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Amount</th>


</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >';





$no=0;   

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
$datewhere='';
}

/*if($_GET['guideId']!=''){

$guideId = 'and id in (select guideQuoteId from guideAllocation where 1 and GuideId="'.$_GET['guideId'].'")' ;
}else{

$guideId = '  ' ;
}*/

if($_GET['destinationId']!=''){

$destinationIds = 'and destinationId="'.$_GET['destinationId'].'"';
}else{

$destinationIds = '  ' ;
}



if($_GET['hotelName']!=''){

$hotelNames = 'and supplierId="'.$_GET['hotelName'].'"';
}else{

$hotelNames = '  ' ;
}

///$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' 1 '.$agentname.' '.$daterangeQuery.' '.$datewhere.' '.$guideId.' and tariffId!=0 order by quotationId desc '); 
$rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId in (select id from quotationMaster where status=1) and queryId in (select id from queryMaster where queryStatus=3) and supplierId!=0 '.$daterangeQuery.' '.$destinationIds.' '.$roomType.' '.$hotelNames.' order by id asc '); 


while($resultlists=mysqli_fetch_array($rs)){  

++$no;


$rsqt=GetPageRecord('*,count(id) as totalnight','quotationHotelMaster',' supplierId="'.$resultlists['supplierId'].'" and quotationId="'.$resultlists['quotationId'].'" order by id asc '); 
$quotationDatates=mysqli_fetch_array($rsqt);

$nights = $quotationDatates['totalnight'];


$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 
$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 





$queryData=mysqli_fetch_array($rsquery);



$rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by id asc '); 



$hotelData=mysqli_fetch_array($rsHotel);



$rsHotelroom=GetPageRecord('name','roomTypeMaster',' id="'.$resultlists['roomType'].'" order by id asc '); 



$hotelroom=mysqli_fetch_array($rsHotelroom);



$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);

$totalpax = $queryData['adult']+$queryData['child'];
$singlCost = 0;
$doubleCost=0;
$tripleCost=0;
if($queryData['sglRoom']>0){
$singlCost += $resultlists['singleoccupancy']*$nights*$queryData['sglRoom'];
}
if($queryData['dblRoom']>0){
$doubleCost += $resultlists['doubleoccupancy']*$nights*$queryData['dblRoom'];
}
if($queryData['tplRoom']>0){
$tripleCost += $resultlists['tripleoccupancy']*$nights*$queryData['tplRoom'];
}
$totalrooms = $queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom'];
$serviceTax = $quotationData['serviceTax'];
$totalHotelRoomCost = ($singlCost+$doubleCost+$tripleCost);
$totalHotelRoomCostwithgst = $totalHotelRoomCost+$totalHotelRoomCost*$serviceTax/100;

$rs12=GetPageRecord('*',_ROOM_TYPE_MASTER_,'1 and id="'.$resultlists['roomType'].'"'); 
$editresult2=mysqli_fetch_array($rs12);

$outputP.='<tr style="text-align:center;">';

$outputP.='<td align="center">'.$no.'</td>';


$outputP.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.$hotelData['hotelName'].'</td>';
$outputP.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>';

$outputP.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$nights.'</td>';

$outputP.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalrooms.'</td>';


$outputP.='<td align="center" valign="middle" bgcolor="#FAFDFE">'.($nights*$totalrooms).'</td>';


$outputP.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalHotelRoomCostwithgst.'</td>';


$outputP.='</tr>';
} 

$outputP.='</tbody>';

$outputP.='</table>';

echo $outputP;

?>

<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function(settings, json){
		$("#example").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");
	},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Hotel Chain Report'},
{extend: 'excelHtml5', title: 'Hotel Chain Report'},
{extend: 'pdfHtml5', title: 'Hotel Chain Report'}
],


}
);

} );
</script>

</div>

</td>



</tr>



</table>

<?php }?>





<?php if($_REQUEST['report']=='37'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

<td width="91%" align="left" valign="top">

<form method="get" >
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
<input name="report" id="report" type="hidden" value="37" />

<h3 class="cms_title">Hotel Wait List Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

<div class="" style=" width:100%; margin: 0px 0px 3px 0px;" >

<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0" >

<tr>

<td width="252" align="right">
	<table width="60%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td style="padding:0px 0px 0px 5px; width: 18%;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;"  onchange="getallHotel();" >



<option value="">Select Destination</option>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' name!="" and deletestatus=0 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>

<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>

<?php } ?>

</select></td>

<td style="padding:0px 0px 0px 5px; width: 18%;" >
<select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">
</select></td> 

<script type="text/javascript">
function getallHotel() {

var destinationId = $('#destinationId').val();
var hotelIdr = '<?php echo $_REQUEST['hotelId']; ?>';
$('#hotelId').load('loaddeswisehotel.php?destinationId='+destinationId+'&hotelIdr='+hotelIdr);

}
getallHotel();
</script>          


<td style="padding:0px 0px 0px 5px; width: 18%;" ><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>
</td>
</tr>
</table>


<div id="margin" class="filterable" style="padding:0px 5px;padding-top:1px;" >

<style type="text/css">
	/* table {
display: block;
overflow-x: auto; 
white-space: nowrap;
}*/

.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}
#example_filter{
	position: absolute;
    top: -47px;
	font-size:16px;
}
#example_filter input{
	padding:8px;
}

</style>
<table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="headerClass">
<thead>
<tr>
<th width="10" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Tour Code</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Hotel</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Destination</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Nights</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Pax</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Single Room</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Double room</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Triple Room</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Twin Room</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">EBed Adult</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">CWB Room</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">CNB Room</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Rooms</th>

</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >


<?php
$no=1;   
$grandTotalPaxx=0;
$totalnightt=0;
$sglRoomm=0;
$dblRoomm=0;
$tplRoomm=0;
$totalroomsss=0;
$datewhere='';

$daterangeQuery='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$daterangeQuery=' and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
}

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

}

if($_GET['destinationId']!=''){

$destinationIds = 'and destinationId="'.$_GET['destinationId'].'"';
}




if($_GET['hotelId']!=''){

$hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
}


$rs=GetPageRecord('*','finalQuote','quotationId!="" and manualStatus=5 '.$destinationIds.' '.$hotelserch.' '.$daterangeQuery.' order by id desc'); 

while($resultlists=mysqli_fetch_array($rs)){

$qtrs = GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$resultlists['quotationId'].'"');
$quotationResult = mysqli_fetch_assoc($qtrs);

$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
$destinationResult=mysqli_fetch_array($rsdes);

$rsHots=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$resultlists['hotelId'].'"'); 
$hotelData=mysqli_fetch_array($rsHots);

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'"'); 
$queryData=mysqli_fetch_array($rsquery);

$totalRooms = $queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom']+$queryData['twinRoom']+$queryData['extraNoofBed']+$queryData['cwbRoom']+$queryData['cnbRoom'] ;

?>

<tr>

<td><?php echo $no; ?></td>
<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">
<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?> </a></div></td>

<td align="left" style="min-width: 110px;"><?php echo $hotelData['hotelName']; ?></td>
<td align="left"><?php echo $destinationResult['name']; ?></td>
<td><?php echo $quotationResult['night']+'1'; ?></td>
<td><?php echo $queryData['adult']+$queryData['child']; ?></td>
<td><?php echo $queryData['sglRoom']; ?></td>
<td><?php echo $queryData['dblRoom']; ?></td>
<td><?php echo $queryData['tplRoom']; ?></td>
<td><?php echo $queryData['twinRoom']; ?></td>
<td><?php echo $queryData['extraNoofBed']; ?></td>
<td><?php echo $queryData['cwbRoom']; ?></td>
<td><?php echo $queryData['cnbRoom']; ?></td>
<td><?php echo $totalRooms; ?></td>
</tr>
<?php $no++; } ?>

</tbody>
</table>

<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function(settings, json){
		$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
	},
	dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Hotel Wait List Report'},
{extend: 'excelHtml5', title: 'Hotel Wait List Report'},
{extend: 'pdfHtml5', title: 'Hotel Wait List Report',
orientation: "landscape"
}
	
],
language: { 
search: "Search: ",
searchPlaceholder: "",
},
});
} );
</script>

</div>

<?php } ?>




<?php if($_REQUEST['report']=='35'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="35" />



<h3 class="cms_title" style="padding-left:70px">Incoming Tour Status Report - Summary</h3>

&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:225px;">



<tr>
<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<td style="padding:0px 5px 0px 5px;">
<input name="agentname" type="text" class="topsearchfiledmain" id="agentname" style="width:138px;border-radius:0px!important;" value="<?php if(isset($_REQUEST['agentname']) && $_REQUEST['agentname']!=''){ echo $_REQUEST['agentname']; } ?>" size="100" maxlength="100" placeholder="Agent">
</td> 
<td>
	<select name="guideName" id="guideName" style="padding: 9px;">
<?php  
$a12=GetPageRecord('*',_GUIDE_MASTER_,' 1 and name!="" order by name asc'); 
while($guideData=mysqli_fetch_array($a12)){ 
?>
<option value="<?php echo strip($guideData['id']); ?>"><?php echo $guideData['name'];?></option>
<?php 
} 
?>
</select>
</td>


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}
#example_wrapper{
	min-width: 74.3%;
	max-width: 74.3%;
}
#example_filter{
	position: absolute;
    top: -51px;
	font-size: 15px;
}
#example_filter input {
	padding: 9px;
}

</style>

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100%" data-page-length='25'>
<thead>
<tr>
<th width="10" align="center" bgcolor="#233a49" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">TOUR Code</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent Name</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Pax</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Days</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Query.Date</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Hotel</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Meal</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Guide</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Transfer</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Transportation</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Activity</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Air Res.</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Train Res.</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Other</th>

<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;"> Status</th>

</tr>
</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >



<?php 

$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
$datewhere1  = 'and srdate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
}

$daterangeQuery='';

$daterangeQuery1 = '';
if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;
$daterangeQuery1  = 'and srdate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
$datewhere='';
$datewhere1='';
}


if($_GET['agentname']!=''){

$agentname = 'and queryId in (select id from queryMaster where companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['agentname'].'%") or companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_GET['agentname'].'%" or lastName like "%'.$_GET['agentname'].'%" ))';
}else{

$agentname = ' ' ;
}

?>
<?php 
$no = 0;
$totaldays = 0;
$pax = 0;
$rsquot=GetPageRecord('queryId,quotationId',_QUOTATION_MASTER_,' 1  and status=1 '.$daterangeQuery.' '.$datewhere.' '.$agentname.''); 

$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){

$no++;

//$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$rsquery=GetPageRecord('id,adult,companyId,queryDate,clientType,child,night','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;

$totaldays = $totaldays+$days;

$pax = $pax+$totalpax;

// ================hotel status==============
$status=GetPageRecord('*','finalQuote',' quotationId="'.$quotationResult['quotationId'].'"');
$hotelStatus=mysqli_fetch_array($status); 

$strs=GetPageRecord('manualStatus','finalQuote',' quotationId="'.$hotelStatus['quotationId'].'" and hotelId="'.$hotelStatus['hotelId'].'" and startDayDate="'.$hotelStatus['startDayDate'].'" and destinationId="'.$hotelStatus['destinationId'].'" and supplierId="'.$hotelStatus['supplierId'].'" order by id desc');
if(mysqli_num_rows($strs)>0){
$hotelStatus=mysqli_fetch_array($strs);
}
// ====================================giude===================

$guideAry=GetPageRecord('manualStatus','finalQuoteGuides',' quotationId='.$quotationResult['quotationId']);
if(mysqli_num_rows($guideAry)>0){
$guideStatusAry=mysqli_fetch_array($guideAry);
if($guideStatusAry['manualStatus']=='3'){
	$guideStatus='Confirmed';
}else{
	$guideStatus='Pending';
}

}else{
	$guideStatus='-';
}



//======================meal==============

$mealAry=GetPageRecord('manualStatus','finalQuoteMealPlan',' quotationId='.$quotationResult['quotationId']);
if(mysqli_num_rows($mealAry)>0){
$mealStatusAry=mysqli_fetch_array($mealAry);
if($mealStatusAry['manualStatus']=='3'){
	$mealStatus = 'Confirmed';
}else{
	$mealStatus = 'Pending';
}
}else{
	$mealStatus = '-';
}

//=================TRANSFER====================

$Arytpt=GetPageRecord('manualStatus','finalQuotetransfer','  quotationId="'.$quotationResult['quotationId'].'" and transferId in (select id from packageBuilderTransportMaster where transferCategory="transfer")');
if(mysqli_num_rows($Arytpt)>0){

$StatusArytpt=mysqli_fetch_array($Arytpt);
	if($StatusArytpt['manualStatus']==3){
		$transferStatus= 'Confirmed';
	}else{
		$transferStatus= 'Pending';
	}
}else{
	$transferStatus= '-';
}

//=================transportation====================

$Ary=GetPageRecord('*','finalquotetransfer',' quotationId="'.$quotationResult['quotationId'].'" and transferId in (select id from packageBuilderTransportMaster where transferCategory="transportation")');
if(mysqli_num_rows($Ary)>0){
$StatusAry=mysqli_fetch_array($Ary);
if($StatusAry['manualStatus']=='3'){
	$transportationStatus='Confirmed';
}else{
	$transportationStatus='Pending';
}

}else{
	$transportationStatus='-';
}

//=================activity====================
$Ary=GetPageRecord('manualStatus','finalQuoteActivity',' quotationId='.$quotationResult['quotationId']);
if(mysqli_num_rows($Ary)>0){
$StatusAry=mysqli_fetch_array($Ary);
if($StatusAry['manualStatus']=='3'){

$activityStatus='Confirmed';
}else{
	$activityStatus='Pending';
}
}else{
	$activityStatus='-';
}


//=================flight====================

$Ary=GetPageRecord('manualStatus','finalQuoteFlights',' quotationId='.$quotationResult['quotationId']);
if(mysqli_num_rows($Ary)>0){
$StatusAry=mysqli_fetch_array($Ary);
if($StatusAry['manualStatus']=='3'){
	$flightStatus='Confirmed';
}else{
	$flightStatus='Pending';
}
}else{
	$flightStatus='-';
}
// //=================train====================
// $trainStatus='pending';
// $Ary=GetPageRecord('confirmationNo','finalQuoteTrains',' quotationId='.$quotationResult['quotationId']);
// $StatusAry=mysqli_fetch_array($Ary);
// if($StatusAry['confirmationNo']!='')
// $trainStatus='Confirm';


//=================train====================

$Ary=GetPageRecord('manualStatus','finalQuoteTrains',' quotationId='.$quotationResult['quotationId']);
if(mysqli_num_rows($Ary)>0){
$StatusAry=mysqli_fetch_array($Ary);
if($StatusAry['manualStatus']=='3'){
$trainStatus='Confirmed';
}else{
	$trainStatus='Confirmed';
}
}else{
	$trainStatus='-';
}
//=================other====================

$Ary=GetPageRecord('manualStatus','finalQuoteExtra',' quotationId='.$quotationResult['quotationId']);
if(mysqli_num_rows($Ary)>0){
$StatusAry=mysqli_fetch_array($Ary);
if($StatusAry['manualStatus']=='3'){
	$otherStatus='Confirmed';
}else{
	$otherStatus='Pending';
}

}else{
	$otherStatus='-';
}
?>  

<tr style="text-align:center;">

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $no; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#45b558 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>



<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo  showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>


<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $totalpax; ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $days; ?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo date('d-m-Y',strtotime($queryData['queryDate'])); ?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php if( $hotelStatus['manualStatus']==0){ ?>Pending <?php } elseif($hotelStatus['manualStatus']==2){ ?>Requested<?php } elseif( $hotelStatus['manualStatus']==3){ ?> Confirmed <?php } elseif( $hotelStatus['manualStatus']==4){ ?> Rejected <?php } elseif( $hotelStatus['manualStatus']==5){ ?>Waitlist<?php } ?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $mealStatus; ?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $guideStatus?></td>

<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $transferStatus; ?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $transportationStatus; ?></td>


<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $activityStatus; ?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $flightStatus?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $trainStatus?></td>



<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo $otherStatus?></td>
<td align="center" valign="middle" bgcolor="#FAFDFE"><?php echo 'Active'; ?></td>

</tr> 


<?php }?>



</tbody>

</table>

<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function (settings, json) {  
$("#example").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");            
				},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Incoming Tour Status Report'},
{extend: 'excelHtml5', title: 'Incoming Tour Status Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'Incoming Tour Status Report',
  orientation: 'landscape'
}
],
});
} );
</script>

</div>

</td>



</tr>



</table>

<?php }?>


<?php if($_REQUEST['report']=='39'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<style>
#example_filter {
position: absolute;
top: -54px;
left: 0%;
}
#example_filter input {
height: 37px;
width: 210px;
}
</style>
<script>
$(function() {
$('input[name="daterange"]').daterangepicker({
"autoApply": true,
opens: 'right',
locale: {
format: 'DD-MM-YYYY'
}
}, function(start, end, label) { 
});
});
</script>  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="91%" align="left" valign="top">
<form method="get" >

<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="report" id="report" type="hidden" value="39" />

<h3 class="cms_title">Hotel Room Night Analysis Report</h3>

&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>

<div class="" style=" width:100%;width:106vw;margin: 0px 0px 3px 0px;position:relative;padding-top:65px" >

<table width="100%" border="0" cellpadding="10" cellspacing="0">

<tr>

<td style="position: absolute;top: 1px;left:-533px;"  align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td width="790" align="center">&nbsp;</td>

<td width="252" align="right" style=""><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;" onchange="getallHotel();" >

<option value=""> Select Destination</option>

<?php 

$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  

?>

<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id']==$_REQUEST['destinationId']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;" ><select name="hotelId" id="hotelId" class="topsearchfiledmainselect" style="border-radius:0px!important;width: 170px;">
</select></td> 




<script type="text/javascript">
function getallHotel() {

var destinationId = $('#destinationId').val();
var hotelIdr = '<?php echo $_REQUEST['hotelId']; ?>';
$('#hotelId').load('loaddeswisehotel.php?destinationId='+destinationId+'&hotelIdr='+hotelIdr);

}
getallHotel();
</script>          


<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}
#example_wrapper{
	width:68.4%;
}
</style>
<?php
$outputRes=''; 
$outputRes='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" style="width:100% " data-page-length="10">
<thead>
<tr>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">S.No</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Destination</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Hotel Name</th>
<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Room Type</th>';


if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){

$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));

}

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  

$fromDate = $myArray[0];
$toDate = $myArray[1];
}

$output = [];
$time   = strtotime($fromDate);
$last   = date('M Y', strtotime($toDate));

do {
$month = date('M Y', $time);
$total = date('t', $time);

$output[] = $month;

$time = strtotime('+1 month', $time);
} while ($month != $last);
$xyz = implode(",", $output);
$output = explode(',', $xyz);

foreach ($output as $monthY) {
$outputRes.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$monthY.'</th>';

} 



$outputRes.='</tr>';
$outputRes.='</thead>
<tbody style="text-align:center; color: #000; font-size: 13px;"  >';

$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';

}

$daterangeQuery='';

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;

$datewhere='';
}


if($_GET['destinationId']!=''){

$destinationIds = 'and destinationId="'.$_GET['destinationId'].'"';
}else{

$destinationIds = '  ' ;
}


if($_GET['hotelId']!=''){

$hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
}else{

$hotelserch = '  ' ;
}

$sn=1;
$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 '.$datewhere.''.$daterangeQuery.' '.$destinationIds.' '.$hotelserch.'  and supplierId!=0 group by supplierId order by fromDate desc'); 
while($resultlists=mysqli_fetch_array($rs)){

$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'" '); 
$destinationResult=mysqli_fetch_array($rsdes);


$rsHots=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$resultlists['supplierId'].'" order by id desc '); 
$hotelDatas=mysqli_fetch_array($rsHots);





$outputRes.='<tr style="text-align:center;">';
$outputRes.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$sn.'</strong></td>';  
$outputRes.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$destinationResult['name'].'</strong></td>';
$outputRes.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$hotelDatas['hotelName'].'</strong></td>';

$outputRes.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">Single  <br>Double<br>Twin <br>  Triple <br>ExtraBedA <br>Child with Bed <br>Child without Bed <br>  Total </td>';


foreach ($output as $monthY) {

$months = date('m',strtotime($monthY));
$years = date('Y',strtotime($monthY));
$agentAmount = 0;
$totalppax = 0;
$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" and supplierId="'.$resultlists['supplierId'].'" and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 


$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){



$rsHot=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$quotationResult['supplierId'].'" order by id asc '); 
$hotelData=mysqli_fetch_array($rsHot);


$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);

$totalrooms = $queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom']+$queryData['twinRoom']+$queryData['extraNoofBed']+$queryData['cwbRoom']+$queryData['cnbRoom'];


}


$outputRes.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['sglRoom'].'<br>'.$queryData['dblRoom'].'<br>'.$queryData['twinRoom'].'<br>'.$queryData['tplRoom'].'<br>'.$queryData['extraNoofBed'].'<br>'.$queryData['cwbRoom'].'<br>'.$queryData['cnbRoom'].'<br>'.$totalrooms.'</td>';

} 
$sn++;
$outputRes.='</tr>'; 

}
$outputRes.='</tbody>';

$outputRes.='</table>';

echo $outputRes;
?>
<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({

	"initComplete": function(settings, json){
		$("#example").wrap("<div style='overflow:auto; width:99.7%;position:relative;'></div>");
	},
	dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Hotel Room Night Analysis Report'},
{extend: 'excelHtml5', title: 'Hotel Room Night Analysis Report'},
{extend: 'pdfHtml5', title: 'Hotel Room Night Analysis Report',
orientation: 'landscape',
pageSize: 'LEGAL',
exportOptions: {
            //   columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ]
         },
}
	
],
language: { 
search: "Search: ",
searchPlaceholder: "",
},
});
} );
</script>

</div>

</td>



</tr>



</table>

<?php }?>


<?php if($_REQUEST['report']=='40'){ ?>



<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top"  style="width:100vw">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="40" />



<h3 class="cms_title" style="padding-left:70px">Turnover Statement - Proforma Invoice Executive Wise  </h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;padding-top: 33px;position: relative;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left" style="position: absolute;top: -31px;left: 251px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<!-- <td width="790" align="center">&nbsp;</td> -->



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; padding: 9px; " >



<option value="">All Users</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';  



//userType=1 and   



$where=' status=1 order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td>



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
white-space: nowrap;
}
</style>

<style type="text/css">
	#example_wrapper{
		width: 80.3%;
	}

.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

#example_filter {
position: absolute;
top: -54px;
left: 0%;
}

#example_filter input {
height: 37px;
width: 210px;
}

</style>
<?php
$outputTable='';
$outputTable='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table tablesorter gridtable sortable headerClass" data-page-length="25" style="width:100%">
<thead>
<tr>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">S.No</th>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">EXECUTIVE</th>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">TYPE</th>';



if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){

$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));

}

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  

$fromDate = $myArray[0];
$toDate = $myArray[1];
}

$output = [];
$time   = strtotime($fromDate);
$last   = date('M Y', strtotime($toDate));

do {
$month = date('M Y', $time);
$total = date('t', $time);

$output[] = $month;

$time = strtotime('+1 month', $time);
} while ($month != $last);
$xyz = implode(",", $output);
$output = explode(',', $xyz);



foreach ($output as $monthY) {
$outputTable.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$monthY.'</th>';

} 



$outputTable.='</tr>';
$outputTable.='</thead>';
$outputTable.='<tbody style="text-align:center; color: #000; font-size: 13px;"  >';


$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
$datewhere='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';

}

$daterangeQuery='';

if($_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;

$datewhere='';
}





$strWhere='';   
if($_GET['assignto']!=''){
$strWhere = " and id = '".trim($_GET['assignto'])."'";
}


$totalcreated=''; 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where='status=1 '.$strWhere.' order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 



while($resListings=mysqli_fetch_array($rs)){  
$no++;

$outputTable.='<tr style="text-align:center;">';
$outputTable.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$no.'</strong></td>';  
$outputTable.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$resListings['firstName'].'</strong></td>';

//  <!-- <td align="left" valign="middle">$resListing['firstName']</td>

$outputTable.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">Pax<hr style="border-top: 1px dashed black;">Sale</td>';


foreach ($output as $monthY) {

$months = date('m',strtotime($monthY));
$years = date('Y',strtotime($monthY));
$agentAmount = 0;
$totalppax = 0;
/////$rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from querymaster where cityId in (select id from destinationMaster where countryId="'.$resultlists['countryId'].'")) and status=1 '.$daterangeQuery.''.$datewhere.' '.$agentname.''); 
// $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from packageQueryDays where cityId in (select id from destinationMaster where countryId="'.$countryResult['id'].'")) and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 
// $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and addedBy ="'.$resListings['id'].'" and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 

// $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and addedBy in (select id from usermaster where id="'.$resListings['id'].'") and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 
// $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and id in (select id from usermaster where id="'.$resListings['id'].'") and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 
$queryMaster=GetPageRecord('id,child,infant,adult',_QUERY_MASTER_,' assignTo="'.$resListings['id'].'"  and month(queryDate) ="'. $months.'" and  year(queryDate) ="'.$years.'"'); 

$countTour = mysqli_num_rows($queryMaster);
while($quotationResult=mysqli_fetch_array($queryMaster)){

$rs1 = GetPageRecord('*', _AGENT_PAYMENT_REQUEST_, 'queryId="' . $quotationResult['id'] . '"');
$agentPaymentRequestData = mysqli_fetch_array($rs1);

$agentAmount = $agentAmount+$agentPaymentRequestData['finalCost'];
$totalppax = $totalppax+($quotationResult['adult']+$quotationResult['child']);
}


$outputTable.='<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalppax.'<hr style="border-top: 1px dashed black;">'.$agentAmount.'</td>';

} 

$outputTable.='</tr>'; 

} 
$outputTable.='</tbody>';

$outputTable.='</table>';
echo $outputTable;
?>  

<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
	"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
	dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Turnover Statement - Proforma Invoice Executive Wise'},
{extend: 'excelHtml5', title: 'Turnover Statement - Proforma Invoice Executive Wise'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'Turnover Statement - Proforma Invoice Executive Wise',
orientation: 'landscape',
pageSize: 'LEGAL',
}
],
language: { 
search: "Search: ",
searchPlaceholder: "Executive Name",
},
}      
);
} );
</script>

</div>

</td>



</tr>



</table>


<?php }?>




<!--=========================file wise liablity start=================== -->

<?php
if($_REQUEST['report'] == '41')
{   ?>
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script> -->

<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}

}, function(start, end, label) { 


});

});
</script>  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >




<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>">



<input name="report" id="report" type="hidden" value="41">
<h3 class="cms_title" style="padding-left:70px">File Wise Liability Report</h3> 
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">
<table width="100%" border="0" cellpadding="10" cellspacing="0" style="padding-bottom:20px;">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>

<td width="270" align="center">&nbsp;</td>

<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td> </td>

<td style="padding:0px 0px 0px 5px;">
<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
</td>



<td  style="padding:0px 0px 0px 5px;">
<input name="tourCode" value="<?= isset($_REQUEST['tourCode'])?trim($_REQUEST['tourCode']):'' ?>" type="text" class="topsearchfiledmain" style="width: 150px; border-radius: 2px;padding: 11px;" placeholder="Tour Code"/>
</td>

<td  style="padding:0px 0px 0px 5px;">
<select name="agent" id="agent" class="topsearchfiledmainselect" style="width:200px; padding: 9px; ">
<option value="">Agent Name</option>
<?php 
$clientQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' deletestatus!=1 and name!="" order by name ');

while($client=mysqli_fetch_array($clientQuery))
{
if(isset($_REQUEST['agent']) && $_REQUEST['agent']==$client['id'])
echo "<option value='".$client['id']."' selected >".$client['name']."</option>";
else
echo "<option value='".$client['id']."'>".$client['name']."</option>";
}
?>
</select>
<input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;"> 

</td>  

</tr>



</table></td>



</tr>

</table></td>

</tr>
</table>

</div>

</form>

<tr>                

<td>      
<div id="margin" class="filterable" style="padding:0px 5px;">

<style type="text/css">
table {
display: block;
/* overflow-x: auto; */
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; }

#example_filter {
position: absolute;
top: -70px;
left: 0%;
}

#example_filter input {
height: 32px;
width: 210px;
}
#example_wrapper{
	width:53.8%;
}

</style>

<?php

$totalTax = 0;
$totalAmountinr = 0;
$totalAmount = 0;

$quotationResult='';
$daterangeQuery='';
$whereDateCondition='';
if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$whereDateCondition = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
//  $whereDateCondition = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  '.$daterangeQuery.' group by currencyId  order by id asc';  
//  $datewhere='';
}


$whereCountry='';

$whereAgent='';

$whereClient='';

if(isset($_REQUEST['agent']) && $_REQUEST['agent']!='')
{
$whereAgent = ' companyId="'.$_REQUEST['agent'].'" ';
}

$tourCode='';
if(isset($_REQUEST['tourCode']) && $_REQUEST['tourCode']!='' && $tourIdSequence==1){
	$tourId = explode('/',trim($_REQUEST['tourCode']));
	$tourId = (int)$tourId[2];
	$tourCode = ' and queryId in (select id from queryMaster where monthTourId="'.$tourId.'") ';
} 
if(isset($_REQUEST['tourCode']) && $_REQUEST['tourCode']!='' && $tourIdSequence==2){
	$tourId = explode('/',trim($_REQUEST['tourCode']));
	$tourId = (int)$tourId[2];
	$tourCode = ' and queryId in (select id from queryMaster where yearTourId="'.$tourId.'") ';
} 

// if($_REQUEST['client'])
// {
//   $whereClient = ' and queryId in (select id from queryMaster where leadPaxName="'.$_REQUEST['client'].'" ) ';
// }

$outputTs='';
// $outputTs.='<table width="100%" border="0" cellpadding="10" cellspacing="0" >';
$outputTs.='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable dataTable no-footer"  style="width: 100%;" role="grid" aria-describedby="example_info">';
$outputTs.='
<thead>
<tr>
<td align="left"  bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>S.No.</strong></td>
<td align="left"  bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Tour Code</strong></td>
<td  align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014; color: rgb(255, 255, 255); background-color: rgb(35, 58, 73);"><strong>Subject Name</strong></td>';

// 
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Invoice Date</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Arrival</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Departure</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Day</strong></td>
$outputTs.='<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Agent</strong></td>
<td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Sales Person</strong></td>
<td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Operation Person</strong></td>
<td align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Currency</strong></td>';
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Country</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Operation/Supplier Cost</strong></td>
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Total Amount</strong></td>

$outputTs.='
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Exchange Rate</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>P.Inv.Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Tax invoice Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Operation/Supplier Cost</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Advance Amount/Booking Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Profit/Loss Amount</strong></td>
<td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;color: rgb(255, 255, 255); background-color: rgb(35, 58, 73)"><strong>Profit/Loss %</strong></td>

</tr></thead><tbody>';
// <td align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Profit/ Loss File</strong></td>
$wherecondition='';
if($whereAgent!='')
$wherecondition = ' deletestatus=0  and queryId in (select queryId from invoiceMaster where deletestatus=0) and queryId in (select id from queryMaster where '.$whereAgent.') '.$whereCountry.' '.$whereClient.' and status=1  '.$whereDateCondition.'  order by id asc'; 
else
$wherecondition = ' deletestatus=0  and queryId in (select queryId from invoiceMaster where deletestatus=0)  '.$whereCountry.' '.$whereClient.' and status=1 '.$tourCode.' '.$whereDateCondition.'  order by id asc'; 

//  $where = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  and fromDate between "'.$quotationResult['fromDate'].'" and "'.$quotationResult['toDate'].'" order by id asc'; 


//$rsqi=GetPageRecord('*',_QUOTATION_MASTER_,$where); 
$sn=1;
$rsqi=GetPageRecord('*',_QUOTATION_MASTER_,$wherecondition); 
// var_dump($rsqi);exit;
$totalQuery = mysqli_num_rows($rsqi); 
while($quotResulti=mysqli_fetch_array($rsqi)){

$rscuri=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotResulti['currencyId'].'"');
$currencyResulti=mysqli_fetch_array($rscuri);

$rs2=GetPageRecord('currencyValue','queryCurrencyRateMaster',' currencyId="'.$currencyResulti['id'].'"'); 
$editresult2=mysqli_fetch_array($rs2);
$exchangerate = number_format($editresult2['currencyValue'],4);

$rsque=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotResulti['queryId'].'"');
$queryResult=mysqli_fetch_array($rsque);
$totalPax = $queryResult['adult']+$queryResult['child'];

$rsinv=GetPageRecord('*',_INVOICE_MASTER_,'queryId="'.$queryResult['id'].'"');
$invoiceResult=mysqli_fetch_array($rsinv);

$supplierCost=0;

// $suppCostQuery=GetPageRecord('totalSupplierCost','finalQuotSupplierStatus','quotationId="'.$quotResulti['id'].'  order by id desc limit 1"');
$suppCostQuery=GetPageRecord('*','supplierPaymentMaster','quotationId="'.$quotResulti['id'].'  order by id desc limit 1"');

$suppCost=mysqli_fetch_array($suppCostQuery);

$rsagent=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
$agentResult=mysqli_fetch_array($rsagent);

$reqclientGst = $agentResult['reqclientGst'];
if ($reqclientGst != 0){
$Cgst = $agentResult['reqclientCGst'];
$Sgst = $agentResult['reqclientSGst'];
$Igst = $agentResult['reqclientIGst'];
$finalReqCost = $agentResult['reqclientCost'];

$cgsta = round($finalReqCost * $Cgst / 100);
$sgsta = round($finalReqCost * $Sgst / 100);
$igstvala = round($finalReqCost * $Igst / 100);

$taxAmount = $cgsta+$sgsta+$igstvala;
$totalTax = $totalTax+$taxAmount;
}



$ammount=$agentResult['reqclientCost'];

$totalAmount=$totalAmount+$ammount;

$finalCost = $agentResult['finalCost'];
$totalAmountinr = $totalAmountinr+$finalCost;
//$totalAmountgstInr = $totalAmountgstInr+currency_converter($quotResulti['currencyId'],$baseCurrencyId,trim($finalCost))
if($exchangerate>0) 
$totalAmountin=round($finalCost/$exchangerate);
else
$totalAmountin=round($finalCost);

//==============  country ============
$destinationQuery=GetPageRecord('countryId', _DESTINATION_MASTER_ ,'id="'.$quotResulti['destinationId'].'"');
$destination=mysqli_fetch_array($destinationQuery);
$countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,'id="'.$destination['countryId'].'"');
$country=mysqli_fetch_array($countryQuery);



$outputTs.='<tr>';
//'<br>'.'&'.clean($queryResult['referanceNumber']).
$outputTs.='<td align="center">'.$sn.'</td><td align="left" ><div style="width:130px;" class="bluelink">'.makeQueryTourId($queryResult['id']).'</div></td>
<td align="left">'.$queryResult['subject'].'</td>';

$outputTs.='<td align="center">'.showClientTypeUserName($queryResult['clientType'],$queryResult['companyId']).'
</td><td>'.$queryResult['salesassignTo'].'</td><td>'.getUserName($queryResult['assignTo']).'</td><td>'.$currencyResulti['name'].'</td>';



$outputTs.='</div></td>';

$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($exchangerate).'</td>';
$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($finalCost).'</td>';
$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($finalCost).'</td>';
//  $outputTs.='<td align="center">'.getTwoDecimalNumberFormat($suppCost['totalSupplierCost']).'</td>';
$outputTs.='<td align="center">'.getTwoDecimalNumberFormat($quotResulti['totalCompanyCost']).'</td>';
$spPayMQ=GetPageRecord('*','supplierPaymentMaster','1 and quotationId="'.$quotResulti['id'].'" and paymentStatus=1 and paymentType=2 order by supplierStatusId,dateAdded ASC'); 
$spPayMA=mysqli_fetch_array($spPayMQ);

$advAmount = 0;
$advanceAmountQuery=GetPageRecord('amount', 'agentPaymentMaster' ,'quotationId="'.$quotResulti['id'].'" and paymentType=2 ');
while($advanceAmount=mysqli_fetch_array($advanceAmountQuery))
{
$advAmount += $advanceAmount['amount'];
}
$outputTs.='<td>'.getTwoDecimalNumberFormat($advAmount).'</td>';

$outputTs.='<td>'.getTwoDecimalNumberFormat($quotResulti['totalMargin']).'</td>';
$marginPercent = ($quotResulti['totalMargin']/($finalCost-$quotResulti['totalCompanyCost']))*100;

$outputTs.='<td>'.getTwoDecimalNumberFormat($marginPercent).'</td>';

$outputTs.='</tr>';
++$sn;
}

?>

<?php 
$outputTs.='</tbody></table>';
echo $outputTs;
?>

</div>
</td>
</tr>
</table>

<style>
.cmsouter .iconbox {
width:20% !important;
}
</style>   
<script type="text/javascript">

// $('#datepicker1').Zebra_DatePicker();
// $('#datepicker2').Zebra_DatePicker();
$(document).ready(function() {
$('#example').DataTable({

"initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:99.4%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'File Wise Liability Report'},
{extend: 'excelHtml5', title: 'File Wise Liability Report'},
// 'csvHtml5',
{extend: 'pdfHtml5', title: 'File Wise Liability Report',
orientation: 'landscape',
pageSize: 'LEGAL',
exportOptions: {
              columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13 ]
         },

}
],
language: { 
search: "Search: ",
searchPlaceholder: "Serach By Keyword",}
}
);
} );
</script>
<?php } ?>

<!--=========================Fixed Departure Reports=================== -->
<?php  
if($_REQUEST['report']=='45'){ ?>
<div id="loadReports"></div>
<script type="text/javascript">
function loadReports(){
$('#loadReports').load('load_report_fixeddeparture.php?status=1<?php if(strlen($_REQUEST['subFDId'])>0){  echo '&subFDId='.urlencode($_REQUEST['subFDId']); } if(strlen($_REQUEST['searchField'])>0){  echo '&searchField='.urlencode($_REQUEST['searchField']); } if($_REQUEST['daterange']!=''){ echo '&daterange='.urlencode($_REQUEST['daterange']); }else{ echo '&fromDate='.$_REQUEST['fromDate'].'&toDate='.$_REQUEST['toDate']; }?>');
}
loadReports();
</script> 

<?php } ?>

<!-- ============== Guest Report ========================-->

<?php  
if($_REQUEST['report']=='47'){ ?>
<div id="loadguestReports"></div>
<script type="text/javascript">
function loadguestReport(){
$('#loadguestReports').load('load_guestListreport.php?module=reports<?php if($_REQUEST['daterange']!=''){ echo '&daterange='.urlencode($_REQUEST['daterange']); }else{ echo '&fromDate='.$_REQUEST['fromDate'].'&toDate='.$_REQUEST['toDate']; }?>');
}

loadguestReport();

</script> 

<?php } 

if($_REQUEST['report']==65){ ?>
<div id="loadVisaReport"></div>
<script>
	function loadVisaReport(){
		$('#loadVisaReport').load('loadVisaReport.php?module=reports<?php if($_REQUEST['daterange']!=''){ echo '&daterange='.urlencode($_REQUEST['daterange']); }else{ echo '&fromDate='.$_REQUEST['fromDate'].'&toDate='.$_REQUEST['toDate']; }?>');
	}

	loadVisaReport()
</script>

<?php 
}


if($_REQUEST['report']==66){ ?>
	<div id="loadPassportReport"></div>
	<script>
		function loadVisaReport(){
			$('#loadPassportReport').load('loadPassportReport.php?module=reports<?php if($_REQUEST['daterange']!=''){ echo '&daterange='.urlencode($_REQUEST['daterange']); }else{ echo '&fromDate='.$_REQUEST['fromDate'].'&toDate='.$_REQUEST['toDate']; }?>');
		}
	
		loadVisaReport()
	</script>
	
	<?php 
	}

	if($_REQUEST['report']==67){ ?>
		<div id="loadInsuranceReport"></div>
		<script>
			function loadVisaReport(){
				$('#loadInsuranceReport').load('loadInsuranceReport.php?module=reports<?php if($_REQUEST['daterange']!=''){ echo '&daterange='.urlencode($_REQUEST['daterange']); }else{ echo '&fromDate='.$_REQUEST['fromDate'].'&toDate='.$_REQUEST['toDate']; }?>');
			}
		
			loadVisaReport()
		</script>
		
		<?php 
		}
?>

<!-- ========================file wise liablity end====================== -->
<!-- =========================comparison YTY Start============================= -->
<?php if($_REQUEST['report']=='42'){ ?> 
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="42" />



<h3 class="cms_title" style="padding-left:70px">Comparison YTY Report  </h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td width="790" align="center">&nbsp;</td>



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<!-- <td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; padding: 9px; " >



<option value="">All Users</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';  



//userType=1 and   



$where=' status=1 order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td> -->
















<td style="padding:0px 0px 0px 5px;">
<select name="date" id="" class="topsearchfiledmainselect" style="width:180px; padding: 9px; ">
<option value="">Select Data Date</option>
<?php 
if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
echo "<option value='".$_REQUEST['date']."' selected>".date('Y',strtotime($_REQUEST['date'])).'-'.date('Y',strtotime('+1 year',strtotime($_REQUEST['date'])))."</option>";
$oldDate = '1-4-2000';
$timeStamp = strtotime($oldDate);
$currentDate = strtotime('now');
$timeStamp;
while($timeStamp<=($currentDate+1))
{
echo "<option value='1-4-".Date('Y',$timeStamp)."'>".date('Y',$timeStamp).'-'.date('Y',strtotime('+1 year',$timeStamp))."</option>";
$timeStamp =  strtotime('+1 year',$timeStamp);
}

?>
</select>

</td>
<td style="padding:0px 0px 0px 5px;">
<select name="comparisonYear" id="" class="topsearchfiledmainselect" style="width:222px; padding: 9px; ">
<option value="">Select Comparison Year Date</option>
<?php
if(isset($_REQUEST['comparisonYear']) && $_REQUEST['comparisonYear']!='')
echo "<option value='".$_REQUEST['comparisonYear']."' selected>".date('Y',strtotime($_REQUEST['comparisonYear'])).'-'.date('Y',strtotime('+1 year',strtotime($_REQUEST['comparisonYear'])))."</option>";  
$oldDate = '1-4-2000';
$timeStamp = strtotime($oldDate);
$currentDate = strtotime('now');
$timeStamp;
while($timeStamp<=($currentDate))
{
echo "<option value='1-4-".Date('Y',$timeStamp)."'>".date('Y',$timeStamp).'-'.date('Y',strtotime('+1 year',$timeStamp))."</option>";
$timeStamp =  strtotime('+1 year',$timeStamp);
}

?>
</select>

</td>

<td style="padding:0px 0px 0px 5px;">
<select name="country" class="topsearchfiledmainselect" style="width:222px; padding: 9px; ">
<option value="">All Country</option>
<?php
$allCountryArray=[];
$countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,' deletestatus=0 and name!="" order by name asc ');

while($country=mysqli_fetch_array($countryQuery))
{
$allCountryArray[$country['id']] = $country['name'];
if(isset($_REQUEST['country']) && $_REQUEST['country']!='' && $_REQUEST['country']==$country['id'])
echo "<option value='".$country['id']."' selected>".$country['name']."</option>";
else
echo "<option value='".$country['id']."'>".$country['name']."</option>";
}


?>
</select>

</td>
<!-- <td style="padding:0px 0px 0px 5px;"><input name="date" type="text"  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td> -->



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 

</style>
<?php  
$timeStamp = strtotime('now');

if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
$timeStamp = strtotime($_REQUEST['date']);

$dataYear = date('Y',$timeStamp).'-'.date('Y',strtotime('+1 year',$timeStamp));

$outPutComparison = '<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6"  id="example" class="display table gridtable" data-page-length="25" style="width:100%">
<thead>
<tr>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">'.$dataYear.'</th>';
//  <!--<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">TYPE</th> -->


$countryAry=[];
// $rscom=GetPageRecord('id,name',_COUNTRY_MASTER_,' deletestatus=0 and id order by name asc '); 
// while($countryResult=mysqli_fetch_array($rscom)){

//   $countryAry[] = $countryResult['id']; 

//   $outPutComparison.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$countryResult['name'].'</th>';
//  }
if(isset($_REQUEST['country']) && $_REQUEST['country']!='')
{
$countryAry[] = $_REQUEST['country'];
$outPutComparison.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$allCountryArray[$_REQUEST['country']].'</th>';

}
else
{ 
foreach($allCountryArray as $k => $val)
{
$countryAry[] = $k;
$outPutComparison.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$val.'</th>';
}
}
// foreach ($output as $monthY) {


//<!-- <th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">
////echo $monthY;</th>

//} 



$outPutComparison.='</tr>';
$outPutComparison.='</thead>';
$outPutComparison.='<tbody style="text-align:center; color: #000; font-size: 13px;"  >';


$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
$datewhere='';
if(isset($_REQUEST['fromDate']) && isset($_REQUEST['toDate']) && $_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
$datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';

}

$daterangeQuery='';

if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;

$datewhere='';
}





$strWhere='';   
if(isset($_GET['assignto']) && $_GET['assignto']!=''){
$strWhere = " and firstName = '".trim($_GET['assignto'])."'";
}


$totalcreated=''; 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where='status=1 '.$strWhere.' order by firstName asc';  


if(isset($_REQUEST['fromDate']) && isset($_REQUEST['toDate']) && $_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){

$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));

}

if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  

$fromDate = $myArray[0];
$toDate = $myArray[1];
}

$output = [];
$time   = strtotime($fromDate);
$last   = date('M Y', strtotime($toDate));

do {
$month = date('M Y', $time);
$total = date('t', $time);

$output[] = $month;

$time = strtotime('+1 month', $time);
} while ($month != $last);
// $xyz = implode(",", $output);
// $output = explode(',', $xyz);

// $year1 = 2021;
// $month = 4;
$date = '1-4-'.date('Y',strtotime('now'));

if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
$date = $_REQUEST['date'];

$monthAndCountryWiseData = [];

$timeStamp = strtotime($date);
do{

$monthName = date('M',$timeStamp);

$year = date('Y',$timeStamp);

// $timeStamp = strtotime('+1 month',$timeStamp);
$month = date('m',$timeStamp);
// $rs=GetPageRecord($select,_USER_MASTER_,$where); 


// while($resListings=mysqli_fetch_array($rs)){  




$outPutComparison.='<tr style="text-align:center;">';
$outPutComparison.='<td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$monthName.'</td>';


foreach ($countryAry as $countryId) 
{
$totalAmountCountryWise=0;  
// =======agent ===== corporate_master.id = queryMaster.companyId 
$agentIdQuery=GetPageRecord('*',_CORPORATE_MASTER_,' countryId="'.$countryId.'" and deletestatus=0 ');

while($agentId=mysqli_fetch_array($agentIdQuery))
{

$queryResultQuery=GetPageRecord('*',_QUERY_MASTER_,' companyId="'.$agentId['id'].'" and queryDate like "'.$year.'-'.$month.'%" ');

while($queryResult=mysqli_fetch_array($queryResultQuery))
{
if($queryResult)
{             
$rsagent=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
$agentResult=mysqli_fetch_array($rsagent);

$reqclientGst = $agentResult['reqclientGst'];
if ($reqclientGst != 0)
{
$Cgst = $agentResult['reqclientCGst'];
$Sgst = $agentResult['reqclientSGst'];
$Igst = $agentResult['reqclientIGst'];
$finalReqCost = $agentResult['reqclientCost'];

$cgsta = round($finalReqCost * $Cgst / 100);
$sgsta = round($finalReqCost * $Sgst / 100);
$igstvala = round($finalReqCost * $Igst / 100);

$taxAmount = $cgsta+$sgsta+$igstvala;
// $totalTax = $totalTax+$taxAmount;
}

$ammount=$agentResult['reqclientCost'];

// $totalAmount=$totalAmount+$ammount;

$finalCost = $agentResult['reqclientCost']+$taxAmount;
// $totalAmountinr = $totalAmountinr+$finalCost;  
$totalAmountCountryWise +=$finalCost;
}
}

}

$outPutComparison.='<td>'.$totalAmountCountryWise.'</td>';
if (array_key_exists($countryId, $monthAndCountryWiseData)) 
{
$monthAndCountryWiseData[$countryId] += $totalAmountCountryWise; 
}
else
{
$monthAndCountryWiseData[$countryId] = $totalAmountCountryWise;
}
}



$outPutComparison.='</tr>'; 

$timeStamp = strtotime('+1 month',$timeStamp);
$month = date('m',$timeStamp);    
}while($month!=04);


//=============for comparison year start================
if(isset($_REQUEST['comparisonYear']) && $_REQUEST['comparisonYear']!='')
$comparisonYear=$_REQUEST['comparisonYear'];
else
$comparisonYear='';

$comparisonYearData=[]; 
if($comparisonYear!=''){
$timeStamp=strtotime($comparisonYear);
do{

$monthName = date('M',$timeStamp);

$year = date('Y',$timeStamp);

// $timeStamp = strtotime('+1 month',$timeStamp);

$month = date('m',$timeStamp);

foreach ($countryAry as $countryId) 
{
$totalAmountCountryWise=0;  
// =======agent ===== corporate_master.id = queryMaster.companyId 
$agentIdQuery=GetPageRecord('id',_CORPORATE_MASTER_,' countryId="'.$countryId.'" and deletestatus=0 ');

while($agentId=mysqli_fetch_array($agentIdQuery))
{

$queryResultQuery=GetPageRecord('id',_QUERY_MASTER_,' companyId="'.$agentId['id'].'" and queryDate like "'.$year.'-'.$month.'%" ');

while($queryResult=mysqli_fetch_array($queryResultQuery))
{
if($queryResult)
{             
$rsagent=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
$agentResult=mysqli_fetch_array($rsagent);

$reqclientGst = $agentResult['reqclientGst'];
if ($reqclientGst != 0)
{
$Cgst = $agentResult['reqclientCGst'];
$Sgst = $agentResult['reqclientSGst'];
$Igst = $agentResult['reqclientIGst'];
$finalReqCost = $agentResult['reqclientCost'];

$cgsta = round($finalReqCost * $Cgst / 100);
$sgsta = round($finalReqCost * $Sgst / 100);
$igstvala = round($finalReqCost * $Igst / 100);

$taxAmount = $cgsta+$sgsta+$igstvala;
// $totalTax = $totalTax+$taxAmount;
}

$ammount=$agentResult['reqclientCost'];

// $totalAmount=$totalAmount+$ammount;

$finalCost = $agentResult['reqclientCost']+$taxAmount;
// $totalAmountinr = $totalAmountinr+$finalCost;  
$totalAmountCountryWise +=$finalCost;

}
}

}


if (array_key_exists($countryId, $comparisonYearData)) 
{
$comparisonYearData[$countryId] += $totalAmountCountryWise; 
}
else
{
$comparisonYearData[$countryId] = $totalAmountCountryWise;
}
}

$timeStamp = strtotime('+1 month',$timeStamp);
$month = date('m',$timeStamp);         

}while($month!=04);
}

//===========for comparison year end======================
$comYearDiffSales = [];
$outPutComparison.='<tr><th>Total</th>';
$lastYearIncome = 0;
foreach($monthAndCountryWiseData as $id=>$val)
{
$lastYearIncome=$comparisonYearData[$id];
$outPutComparison.="<td>".$val."</td>";
if($val>0 && $comparisonYear!='')
$comYearDiffSales[] = (($val-$comparisonYearData[$id])/$val)*100;
else
$comYearDiffSales[] = '0.00';
}
$outPutComparison.="</tr>";

$DiffdataYear=strtotime($comparisonYear);
$DiffdataYear = date('Y',$DiffdataYear).'-'.date('Y',strtotime('+1 year',$DiffdataYear));
if($comparisonYear!='')
{
$outPutComparison.="<tr><th>Percent Comparison (".$DiffdataYear.") </th>";
foreach($comYearDiffSales as $profLossPercent)
{
if(! is_nan($profLossPercent))
$outPutComparison.="<td align='center'>".$profLossPercent."&nbsp;&nbsp;(".$lastYearIncome." last year count)</td>";
else
$outPutComparison.="<td align='center'>0.00</td>";
}
$outPutComparison.="</tr>";
}
// var_dump($comparisonYearData);
//} 





$outPutComparison.='</tbody>'; 
$outPutComparison.='</table>';
echo $outPutComparison;  
?>
<style type="text/css">
.guidebtn{
background-color: #57a0a4 !important;
border: 1px solid #57a0a4;
padding: 4px !important;
width: 60px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{dom: 'Bfrtilp',
buttons: [
'copyHtml5',
'excelHtml5',
'csvHtml5',
'pdfHtml5'
],
"aaSorting": []
}      
);
} );
</script>

</div>

</td>



</tr>



</table>

<div style="text-align:center; margin-top:30px;">

<?php 
if( isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = date('Y-m-d', strtotime($myArray[0]));
$toDate = date('Y-m-d', strtotime($myArray[1]));
}if(isset($_GET['fromDate']) && isset($_GET['toDate']) && $_GET['fromDate']!='' && $_GET['toDate']!='')
{
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
}

?>

<form method="post"  action="allReports/xlReoprtDownload.php" target="actoinfrm">
<input type="hidden" name="output" value="<?=base64_encode($outPutComparison)?>">
<input type="hidden" name="filename" value="Comparison YTY Report">
<input type="submit" name="export" class="bluembutton" class="btn btn-success" value="Download Report" />
</form></div>


<?php }?>

<!-- =========================comparison YTY End=============================== -->


<!-- =========================sales report Start============================= -->

<?php if($_REQUEST['report']=='43'){ ?>

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>

<link href="css/datatablec.css" rel="stylesheet"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>



$(function() {



$('input[name="daterange"]').daterangepicker({



"autoApply": true,



opens: 'right',



locale: {



format: 'DD-MM-YYYY'



}







}, function(start, end, label) { 







});







});



</script>  



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td width="91%" align="left" valign="top">



<form method="get" >



<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />



<input name="report" id="report" type="hidden" value="43" />



<h3 class="cms_title" style="padding-left:70px">Sales Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">



<table width="100%" border="0" cellpadding="10" cellspacing="0">



<tr>



<td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<!-- <td width="790" align="center">&nbsp;</td> -->



<td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>

<td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; padding: 9px; " >



<option value="">All Users</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';  



// userType=1 and   



$where=' status=1 order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if(isset($_GET['assignto']) && $_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>

<td style="padding:0px 0px 0px 5px;">
<select name="date" id="" class="topsearchfiledmainselect" style="width:180px; padding: 9px; ">
<option value="">Select Data Date</option>
<?php 
if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
echo "<option value='".$_REQUEST['date']."' selected>".date('Y',strtotime($_REQUEST['date']))."</option>";
$oldDate = '1-01-2000';
$timeStamp = strtotime($oldDate);
$currentDate = strtotime('now');
$timeStamp;
while($timeStamp<=($currentDate+1))
{
echo "<option value='1-01-".Date('Y',$timeStamp)."'>".date('Y',$timeStamp)."</option>";
$timeStamp =  strtotime('+1 year',$timeStamp);
}

?>
</select>

</td>
<td style="padding:0px 0px 0px 5px;">
<select name="monthFilter" id="" class="topsearchfiledmainselect" style="width:222px; padding: 9px; ">
<option value="">Select Month</option>
<?php

$date = '1-01-'.date('Y',strtotime('now'));

$timeStamp = strtotime($date);

do{

$monthName = date('F',$timeStamp);

$year1 = date('Y',$timeStamp);

$month = date('m',$timeStamp);

$monthsOption.='<option value="'.$month.'"';

if(isset($_REQUEST['monthFilter']) && $_REQUEST['monthFilter']==$month)
{
$monthsOption.='selected';
}
$monthsOption.='>'.$monthName.'</option>';

$timeStamp = strtotime('+1 month',$timeStamp);

$month = date('m',$timeStamp);

}while($month!=01);
echo $monthsOption;
?>
</select>

</td>
<!-- <td style="padding:0px 0px 0px 5px;"><input name="date" type="text"  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;padding: 11px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/></td> -->



<td style="padding:0px 0px 0px 5px;"><input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;" /></td>


</tr>



</table></td>



</tr>



</table></td>



</tr>



</table>



</div>



</form>



<div id="margin" class="filterable" style="padding:0px 5px;" >

<style type="text/css">
table {
display: block;
overflow-x: auto;
white-space: nowrap;
}
</style>

<style type="text/css">
.ui-corner-tl{
display: none;
}
.ui-widget-header {
border: 1px solid #fff;
background: #fff;
color: #333333;
font-weight: bold;
}
table.dataTable thead th div.DataTables_sort_wrapper span {
right: -9px !important;
}
.gridtable .header {
padding-bottom: 15px !important; 
}
</style>
<?php  
$timeStamp = strtotime('now');

if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
$timeStamp = strtotime($_REQUEST['date']);

$dataYear = date('Y',$timeStamp).'-'.date('Y',strtotime('+1 year',$timeStamp));

$outPutComparison = '<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable" data-page-length="25" style="width:100%">
<thead>
<tr>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">Name</th>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">status</th>
<th align="center" bgcolor="#57a0a4" style="color: rgb(255, 255, 255); background-color: rgb(35, 58, 73) !important; width: 58px;">Year</th>';

// $countryAry=[];
// $rscom=GetPageRecord('id,name',_COUNTRY_MASTER_,' deletestatus=0 and id order by name asc '); 
// while($countryResult=mysqli_fetch_array($rscom)){

//   $countryAry[] = $countryResult['id']; 

//   $outPutComparison.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$countryResult['name'].'</th>';
// } 



$monthAry=[];
if(isset($_REQUEST['monthFilter']) && $_REQUEST['monthFilter']!='')
{
$dateMonth = '1-'.$_REQUEST['monthFilter'].'-'.date('Y',strtotime('now'));

if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
$dateYear = $_REQUEST['date'];
else
$dateYear = '1-'.$_REQUEST['monthFilter'].'-'.date('Y',strtotime('now'));

$timeStampMonth = strtotime($dateMonth);

$timeStampYear = strtotime($dateYear);

$monthName = date('F',$timeStampMonth);

$year1 = date('Y',$timeStampYear);

$month = $_REQUEST['monthFilter'];
$monthAry[]=[$year1,$month,$monthName];
$outPutComparison.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$monthName.'</th>';
}
else
{
$date = '1-01-'.date('Y',strtotime('now'));

if(isset($_REQUEST['date']) && $_REQUEST['date']!='')
$date = $_REQUEST['date'];

$timeStamp = strtotime($date);
do{

$monthName = date('F',$timeStamp);

$year1 = date('Y',$timeStamp);

$timeStamp = strtotime('+1 month',$timeStamp);

$month = date('m',$timeStamp);
$monthAry[]=[$year1,$month,$monthName];
$outPutComparison.='<th width="10" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">'.$monthName.'</th>';

}while($month!=01);
}


$outPutComparison.='</tr>';
$outPutComparison.='</thead>';
$outPutComparison.='<tbody style="text-align:center; color: #000; font-size: 13px;" >';

$assignTo = ' ';
if(isset($_REQUEST['assignto']) && $_REQUEST['assignto']!='')
$assignTo = ' and id="'.$_REQUEST['assignto'].'" '; 

$agentIdQuery=GetPageRecord('id,firstName as name','userMaster',' deletestatus=0 '.$assignTo.' group by name order by name ');
$date = '';
if($_REQUEST['date']!='')
{
$date = $_REQUEST['date'];
}
else
{
$date = date('d-m-Y',strtotime('now'));
}

while($agentId=mysqli_fetch_array($agentIdQuery))
{ 
$outPutComparison.='<tr><td colspan="15"></td></tr>';

$outPutComparison.='<tr><td></td><td>Target</td><td>'.date('Y',strtotime($date)).'</td>';
foreach($monthAry as $month)
{ 
$countQueryConfirm = 0;

$year = $month[0];

$monthNo = $month[1];

$monthname = $month[2];

$queryResultQuery=GetPageRecord($monthname,_TARGET_MASTER_,' assign_to="'.$agentId['id'].'" and year="'.$year.'" ');
$queryResult=mysqli_fetch_array($queryResultQuery);
$outPutComparison.='<td>'.$queryResult[$monthname].'</td>';                                       
// while($queryResult=mysqli_fetch_array($queryResultQuery))
// {
//   if($queryResult)
//   {

//   }
// }
}
$outPutComparison.='</tr>';

$outPutComparison.='<tr><td>'.$agentId['name'].'</td><td>Total Query</td><td>'.date('Y',strtotime($date)).'</td>';
foreach($monthAry as $month)
{ 
$countQueryConfirm = 0;

$year = $month[0];

$monthNo = $month[1];


$queryResultQuery=GetPageRecord('id',_QUERY_MASTER_,' assignTo="'.$agentId['id'].'" and queryDate like "'.$year.'-'.$monthNo.'%" ');
$outPutComparison.='<td>'.mysqli_num_rows($queryResultQuery).'</td>';                                       
// while($queryResult=mysqli_fetch_array($queryResultQuery))
// {
//   if($queryResult)
//   {

//   }
// }
}
$outPutComparison.='</tr>';

$outPutComparison.='<tr><td></td><td>Total Confirm Query</td><td>'.date('Y',strtotime($date)).'</td>';
foreach($monthAry as $month)
{ 
$countQueryConfirm = 0;

$year = $month[0];

$monthNo = $month[1];


$queryResultQuery=GetPageRecord('id',_QUERY_MASTER_,' assignTo="'.$agentId['id'].'" and queryDate like "'.$year.'-'.$monthNo.'%" ');
// $outPutComparison.='<td>'.mysqli_num_rows($queryResultQuery).'</td>';                                       
while($queryResult=mysqli_fetch_array($queryResultQuery))
{
if($queryResult)
{
$rsagent=GetPageRecord('id',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
// $agentResult=mysqli_fetch_array($rsagent);
$countQueryConfirm += mysqli_num_rows($rsagent);   
}
}
$outPutComparison.='<td>'.$countQueryConfirm.'</td>';
}
$outPutComparison.='</tr>';
}


$outPutComparison.='</tbody>';

$outPutComparison.='</table>';
echo $outPutComparison;  
?>

<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable(
{dom: 'Bfrtilp',
buttons: [
'copyHtml5',
'excelHtml5',
'csvHtml5',
'pdfHtml5'
]
}      
);
} );
</script>

</div>

</td>



</tr>



</table>

<div style="text-align:center; margin-top:30px;">

<?php 
if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$fromDate = date('Y-m-d', strtotime($myArray[0]));
$toDate = date('Y-m-d', strtotime($myArray[1]));
}
if(isset($_GET['fromDate']) && isset($_GET['toDate']) && $_GET['fromDate'] !='' && $_GET['toDate']!='')
{
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
}

?>

</div>


<?php }?>

<!-- =========================sales report end=============================== -->


<!-- ==========================Tour Extention Report Start========================= -->
<?php

if($_REQUEST['report'] == '44'){ //die('error is here '); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script>
$(function()
{
$('input[name="daterange"]').daterangepicker(
{
"autoApply": true,
opens: 'right',
locale: {
format: 'DD-MM-YYYY'
}
}, 
function(start, end, label) { 
});
});
</script>  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="91%" align="left" valign="top">
<form method="get" >
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>">
<input name="report" id="report" type="hidden" value="44">
<h3 class="cms_title" style="padding-left:70px">Tour Extention Report</h3> 
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
<div class="" style=" width:100%; margin: 0px 0px 3px 0px;"><table width="100%" border="0" cellpadding="10" cellspacing="0">
<tr>
<td width="83%" align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<!-- <td width="270" align="center">&nbsp;</td> -->
<td width="252" align="right">
	<table width="60%" border="0" align="right" cellspacing="0" cellpadding="0" style="margin-bottom:15px;">
<tr>
<td>
</td>
<td style="padding:0px 0px 0px 5px;"><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
</td>

<td  style="padding:0px 0px 0px 5px;">
<select name="assignTo" id="" class="topsearchfiledmainselect" style="width:200px; padding: 9px; ">
<option value="">select Operation person</option>
<?php
$rsaa=GetPageRecord('id,firstName,lastName',_USER_MASTER_,' deletestatus=0');
while($userss=mysqli_fetch_array($rsaa))
{
if(isset($_REQUEST['assignTo']) && $_REQUEST['assignTo']==$userss['id'])
echo "<option value='".$userss['id']."' selected >".$userss['firstName']." ".$userss['lastName']."</option>";
else
echo "<option value='".$userss['id']."'>".$userss['firstName']." ".$userss['lastName']."</option>";
}
?>
</select>
</td> 
<td  style="padding:0px 0px 0px 5px;">
<select name="agent" id="agent" class="topsearchfiledmainselect" style="width:150px; padding: 9px; ">
<option value="">Agent Name</option>
<?php 
$clientQuery=GetPageRecord('id,name',_CORPORATE_MASTER_,' deletestatus!=1 and name!="" order by name ');

while($client=mysqli_fetch_array($clientQuery))
{
if(isset($_REQUEST['agent']) && $_REQUEST['agent']==$client['id'])
echo "<option value='".$client['id']."' selected >".$client['name']."</option>";
else
echo "<option value='".$client['id']."'>".$client['name']."</option>";
}
?>
</select>
<input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;">    
</td>  
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>



</div>
</form>
</td>
</tr>
</table>
<!-- <div id="margin" class="filterable" style="padding:0px 5px;"> -->
<style>
	#example_filter{
		position:absolute;
		left: 1%;
		top: -60px;
    font-size: 15px;
	}
	#example_filter input{
		padding:7px;
	}
	#example_wrapper{
		width: 99.3%;
    margin-left: 5px;
	}
</style>
<?php

$totalTax = 0;
$totalAmountinr = 0;
$totalAmount = 0;

$quotationResult='';
$daterangeQuery='';
$whereDateCondition='';
if(isset($_GET['daterange']) && $_GET['daterange']!=''){ 
$myString = $_GET['daterange'];
$myArray = explode(' - ', $myString);  
$whereDateCondition = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
//  $whereDateCondition = ' deletestatus=0  and currencyId!=0 and queryId in (select queryId from invoiceMaster where deletestatus=0) and status=1  '.$daterangeQuery.' group by currencyId  order by id asc';  
//  $datewhere='';
}


$whereCountry='';

$whereAgent='';

$whereOperationPerson='';

if(isset($_REQUEST['agent']) && $_REQUEST['agent']!='')
{
$whereAgent = ' and companyId="'.$_REQUEST['agent'].'" ';

}

if(isset($_REQUEST['assignTo']) && $_REQUEST['assignTo']!='')
{
$whereOperationPerson = ' and assignTo="'.$_REQUEST['assignTo'].'" ';
}

$tourCode='';
if(isset($_REQUEST['tourCode']) &&$_REQUEST['tourCode']!='')
{
$tourId = explode('/',trim($_REQUEST['tourCode']));
$tourId = (int)$tourId[2];
$tourCode = ' and queryId in (select id from queryMaster where queryConfirmingTourId="'.$tourId.'") ';
}


$outputTs='';

$outputTs.='<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" id="example" class="gridtable "  style="width: 100%;">
<thead>
<tr>
<th align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>S.No.</strong></th>
<th align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Country</strong></th>
<th align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Tour&nbsp;Name</strong></th>
<th align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Tour&nbsp;Code</strong></th>
<th align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Agent</strong></th>
<th align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Ref&nbsp;No.</strong></th>
<th align="left" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Operation&nbsp;Person</strong></th>
<th align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Query&nbsp;Type</strong></th>
<th align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Query&nbsp;Date</strong></th>
<th align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>From&nbsp;Date</strong></th>
<th align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Status</strong></th>
<th align="center" bgcolor="#f8f8f8" style="border-bottom: 1px solid #00000014;"><strong>Pre/Post&nbsp;Extension</strong></th></tr></thead>';

$outputTs.='<tbody>';
$wherecondition='';
$wherecondition = ' deletestatus=0  and id in (select queryId from quotationMaster where isTourEx=1) '.$whereAgent.' '.$whereOperationPerson.' '.$whereDateCondition.'  order by id asc'; 

$sn=1;
$rsqi=GetPageRecord('*',_QUERY_MASTER_,$wherecondition);

while($queryResult=mysqli_fetch_array($rsqi)){ 

$outputTs.='<tr>';
$outputTs.='<td align="center">'.$sn.'</td>';

//==============  country ============
$destinationQuery=GetPageRecord('countryId',_CORPORATE_MASTER_,'id="'.$queryResult['companyId'].'"');
$destination=mysqli_fetch_array($destinationQuery);
$countryQuery=GetPageRecord('id,name',_COUNTRY_MASTER_,'id="'.$destination['countryId'].'"');
$country=mysqli_fetch_array($countryQuery);

$outputTs.='<td align="center">'.$country['name'].'</td>';

$outputTs.='<td align="center">'.$queryResult['subject'].'</td>';

$outputTs.='<td align="left" ><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  >
<a href="showpage.crm?module=query&view=yes&id='.encode($queryResult['id']).'" style="color:#45b558 !important;">'.makeQueryTourId($queryResult['id']).'</a>
</div>';

$agent = showClientTypeUserName($queryResult['clientType'],$queryResult['companyId']);
$outputTs.='<td align="center">'.$agent.'</td>';

$outputTs.='<td>'.clean($queryResult['referanceNumber']).'</td>';
$outputTs.='<td>'.getUserName($queryResult['assignTo']).'</td>';
$outputTs.='<td>FIT</td>';
$outputTs.='<td>'.date('d-m-Y',strtotime($queryResult['queryDate'])).'</td>';
$outputTs.='<td>'.date('d-m-Y',strtotime($queryResult['fromDate'])).'</td>';

$queryStatus='';
if($queryResult['queryStatus']==6)
{ $queryStatus='Sent'; }
if($resultlists['queryStatus']==7)
{ $queryResult='Follow-up'; }
if($resultlists['queryStatus']==1 || $resultlists['queryStatus']==10)
{ 
if($queryResult['queryStatus']==1)
{ $queryStatus='Assigned'; }  
if($queryResult['queryStatus']==10){ $queryStatus='Created'; }
} 
if($queryResult['queryStatus']==2)
{ $queryStatus='Reverted'; } 
if($queryResult['queryStatus']==3)
{ $queryStatus='Confirmed'; } 
if($queryResult['queryStatus']==4)
{ $queryStatus='Lost'; } 
if($queryResult['queryStatus']==5)
{ $queryStatus='Time Limit Booking'; } 
if($queryResult['queryStatus']==0)
{ $queryStatus='Assigned'; }


$outputTs.='<td>'.$queryStatus.'</td>';

$preCount = 0;
$postCount = 0;

$where = ' queryId="'.$queryResult['id'].'" and isTourEx=1 and extensionType=1';
$quotationQuery=GetPageRecord('id',_QUOTATION_MASTER_,$where); 
$preCount = mysqli_num_rows($quotationQuery);

$where = ' queryId="'.$queryResult['id'].'" and isTourEx=1 and extensionType=2';
$quotationQuery=GetPageRecord('id',_QUOTATION_MASTER_,$where); 
$postCount = mysqli_num_rows($quotationQuery);

$outputTs.='<td style="cursor:pointer;" onclick="showQuotation('.$queryResult['id'].')" >Pre('.$preCount.')&nbsp;&nbsp;Post('.$postCount.')</td>';
$outputTs.='</tr>';

++$sn;

}
$outputTs.='</tbody></table>';
echo $outputTs;
?>


<script type="text/javascript">
function showQuotation(showSubRow)
{
// alert(showSubRow);
$('.'+showSubRow).toggle();
}
</script>
<script>
$(document).ready(function() {
$('#example').DataTable({
"initComplete": function (settings, json) {  
$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	},
	dom: 'frtilpB',
	buttons: [
	{extend: 'copyHtml5', title: 'Tour Extension Report'},
	{extend: 'excelHtml5', title: 'Tour Extension Report'},
	{extend: 'pdfHtml5', title: 'Tour Extension Report'}
	],
	language: { 
	search: "Search: ",
    searchPlaceholder: "Agent,/ Client/B2C",
	},

	});
	} );
	</script>
	<?php 
}
	?>

<!-- ==========================Tour Extention Report End=========================== -->

<div class="cmslistBox">



<div class="leftlistBox">



</div>

</div>



<style type="text/css">

.cmslistBox{

display: block;
position: relative;
width: 100%;
overflow: hidden;
height: 300px;
padding: 30px;
}

.leftlistBox{
position: relative;
display: inline-block;
float: left;
width: 46%;
}

.rightlistBox{
position: relative;
display: inline-block;
float: left;
width: 46%;
}

#example_length{
padding-top:5px;
padding-left:10px;
}  

</style>

<script>
$(".doExpand").click(function(){
if($(this).hasClass('noExpand')){
$('.leftBox').css('width','20%').show();
$(".rightBox").css('width','80%');
$(this).removeClass('noExpand');
}else{
$('.leftBox').css('width','0%').hide();
$(".rightBox").css('width','100%');
$(this).addClass('noExpand');
}
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
//for date picker load solution
	jQuery('#daterange').daterangepicker({
		"autoApply": true,
		opens: 'right',
		locale:
		{
			format: 'DD-MM-YYYY'
		}
	},
	function(start, end, label) {
	
	});
    $(document).ready(function() {
	//Data Tables
	$('#exampleDiv').DataTable({
		scrollX: 'true',
		// scrollY:'350px',
		dom: 'frtilpB',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'pdfHtml5'
		],
		language: {
			search: "Search: ",
			searchPlaceholder: "Agent Name, Contact Person , Mobile Number",
		},
			
	});
});
</script>

</body>
</html>

<!-- orientation : 'landscape',
    pageSize : 'A4',
    exportOptions: {
              columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ]
         },
		 } -->