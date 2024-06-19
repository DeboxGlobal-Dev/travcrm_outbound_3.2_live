<?php 
ob_start(); 
include "inc.php";  
include "config/logincheck.php";  
if($loginuserprofileId=='48'){ 
header("Location:showpage.crm?module=mice");
}
if($loginuserID=='1'){
header('Location:setupsetting.crm?module=crmmasters');
}

$todotimelineassign='';
if($loginuserprofileId==1){ 
  $wheresearchassign=' 1   ';
} else { 
  $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].')))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))'; 

  $wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
  $todotimelineassign=' and assignto='.$_SESSION['userid'].' ';
}

if($_REQUEST['opsperson']!='' && $_REQUEST['opsperson']!='0'){
  $wheresearchassign='(  assignTo = '.decode($_REQUEST['opsperson']).' or addedBy = '.decode($_REQUEST['opsperson']).') ';
  $todotimelineassign=' and assignto='.decode($_REQUEST['opsperson']).' ';
}



///////////
$select='userType'; 
$where="id='".$_SESSION['userid']."'"; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$userType_infoRes=mysqli_fetch_array($rs);
$userType_info=$userType_infoRes['userType'];
//////////
$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
$last_day_this_month  = date('Y-m-t');
$selectedPage=0;
$select='id'; 
$where=' where '.$wheresearchassign.' and queryDate="'.date('Y-m-d').'"';
$todaysQuery = countlisting($select,_QUERY_MASTER_,$where);
$date_raw=date('Y-m-d');
$date_raw=date('Y-m-d', strtotime('-1 day', strtotime($date_raw)));
$select='id'; 
$where=' where '.$wheresearchassign.' and queryDate="'.$date_raw.'"';
$yesterdaysquery = countlisting($select,_QUERY_MASTER_,$where);
$select='id'; 
$where=' where '.$wheresearchassign.' and queryDate BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-d').'" and  deletestatus=0';
$thismonthQuery = countlisting($select,_QUERY_MASTER_,$where);
$select='id'; 
$where=' where mailStatus=1 ';
$PendingMail = countlisting($select,'mailSectionMaster',$where);


$select='id'; 
$where=' where  '.$wheresearchassign.' and MONTH(queryConfirmingDate)=MONTH(now()) and YEAR(queryConfirmingDate)=YEAR(now()) and queryStatus=3 and deletestatus=0';
$confirmQuery = countlisting($select,_QUERY_MASTER_,$where);


$where=' 1 and fromDate="'.date('Y-m-d').'"'; 
$rs=GetPageRecord('SUM(adult) as totaltodayadult, SUM(child) as totaltodaychild, SUM(infant) as totaltodayinfant',_QUERY_MASTER_,$where);
$totaltodaypax=mysqli_fetch_array($rs); 

//==============================TO DO MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now())=============================================================================================== 
$todotimelineassigntodo=' and assignTo='.$_SESSION['userid'].'';
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard -<?php echo $systemname; ?></title>
<?php  include "headerinclude.php"; ?>
<?php
if($pageTypeMaster == 1){
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php 
}
if($pageTypeMaster == 2){
?>
<link href="css/main1.css" rel="stylesheet" type="text/css" />
<?php 
}
?>
<script type="text/javascript" src="js/loader.js"></script>
<style type="text/css">

body{ background-color:#f8f8f8 !important;}
.alert {
    padding: 20px;
   background-color: #f44336;
  color: white;
 opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.info {background-color: #2196F3; margin-bottom: 5px;}
.alert.info table tbody tr td p{ margin: 0px !important; }
.closebtn {
    margin-left: 15px;
  color: white;
   font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s; 
} 
.moment-chart-css td {
    color: #FFF !important;
    border-bottom: 1px #6b94b726 solid;
    background-color: #233a49 !important;
} 
.closebtn:hover { 
    color: black; 
} 
.tbllisting {

    color: #FFF !important;

    border-bottom: 1px #6b94b726 solid; 

}
</style>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
</head>
<body>
<?php 
if($pageTypeMaster == 1){
include "header.php"; 
}
if($pageTypeMaster == 2){
include "header1.php"; 
}

function rand_color() { 
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); 
} 
?>
<div class="dashboardmainbox" style="background-color:#192631; padding:0px;">
  <style> 
.sidegradi{padding:41px 0px !important;}  
.sidegradi .fa{font-size: 25px !important;} 
</style>
<?php if($_SESSION['dashboardid']==1){ ?>
  <div style="padding-bottom:10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="11%" align="left" valign="top" ><div style="width:160px;background-color:#233a49; margin-top: 13px;  margin-left: 3px;">
            <div style="text-align:center; padding:26px 0px; border-bottom:2px #1cd1816b  solid;" class="dashquerytb"  onclick="window.location.href = 'showpage.crm?queryshow=2&module=query&searchdate=<?php echo date('Y-m-d'); ?>';" >
              <div style="font-size:40px; font-weight:300; color:#fff; margin-bottom:5px;" id="totadaysquery">0</div>
              <div style="font-size:12px; font-weight:300; color:#fff; position:relative;">Today's Queries <i class="fa fa-cubes" style="position: absolute;  right: 10px;  top: -50px;  font-size: 40px; color: #1cd1816b;"></i></div>
            </div>
            <div style="text-align:center; padding:26px 0px; border-bottom:2px #1cd1816b  solid;" class="dashquerytb" onclick="window.location.href = 'showpage.crm?queryshow=2&module=query&searchdate=<?php echo date('Y-m-d',strtotime('-1 days')); ?>';" >
              <div style="font-size:40px; font-weight:300; color:#fff; margin-bottom:5px;" id="yesterdaysquery">0</div>
              <div style="font-size:12px; font-weight:300; color:#fff; position:relative;">Yesterday's Queries <i class="fa fa-connectdevelop" aria-hidden="true" style="position: absolute;  right: 10px;  top: -50px;  font-size: 40px; color: #1cd1816b;"></i></div>
            </div>
            <div style="text-align:center; padding:26px 0px; border-bottom:2px #06c0cb9c  solid;"  class="dashquerytb" onclick="window.location.href = 'showpage.crm?queryshow=2&module=query&thismonth=1';">
              <div style="font-size:40px; font-weight:300; color:#fff; margin-bottom:5px;" id="thismonthQuery" >0</div>
              <div style="font-size:12px; font-weight:300; color:#fff; position:relative;"><?php echo date('F'); ?>'s Queries <i class="fa fa-calendar" style="position: absolute;  right: 10px; top: -50px;  font-size: 40px; color: #06c0cb9c;"></i></div>
            </div>
            <div style="text-align:center; padding:26px 0px; border-bottom:2px #fbff007a  solid;"  class="dashquerytb"  onclick="window.location.href = 'showpage.crm?queryshow=2&module=query&thismonth=1&querystatus=3';">
              <div style="font-size:40px; font-weight:300; color:#fff; margin-bottom:5px;" id="confirmQuery">0</div>
              <div style="font-size:12px; font-weight:300; color:#fff; position:relative;">Total Confirmed Queries<i class="fa fa-thumbs-o-up" style="position: absolute;  right: 10px; top: -50px; font-size: 40px; color: #fbff007a;"></i></div>
            </div>
            <div style="text-align:center; padding:26px 0px; border-bottom:2px #08a4fda1  solid;" class="dashquerytb" onclick="window.location.href = 'showpage.crm?queryshow=2&module=query&searchdate=<?php echo date('Y-m-d'); ?>&querystatus=3&queryshow=3';" >
              <div style="font-size:40px; font-weight:300; color:#fff; margin-bottom:5px;" id="PendingMail222"> <?php echo ($totaltodaypax['totaltodayadult']+$totaltodaypax['totaltodaychild']+$totaltodaypax['totaltodayinfant']); ?> </div>
              <div style="font-size:12px; font-weight:300; color:#fff; position:relative;">Today Pax Traveling <i class="fa fa-user" style="position: absolute;  right: 10px; top: -50px;  font-size: 40px; color: #08a4fda1;"></i></div>
            </div>
          </div>
          <script>

	var k1=0;

	setInterval(function() {

	

	if(k1<=<?php echo $todaysQuery; ?>){

  	$('#totadaysquery').text(k1);

	}

	if(k1<=<?php echo $yesterdaysquery; ?>){

  	$('#yesterdaysquery').text(k1);

	}

	if(k1<=<?php echo $thismonthQuery; ?>){

  	$('#thismonthQuery').text(k1);

	}

	

	if(k1<=<?php echo $PendingMail; ?>){

  	$('#PendingMail').text(k1);

	}

	

	if(k1<=<?php echo $confirmQuery; ?>){

  	$('#confirmQuery').text(k1);

	}

	

	

	k1++; }, 50);

	</script>
        </td>
        <td width="69%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2" align="left" valign="top"><div style="background-color:#233a49; margin-bottom:0px;  margin-right:10px; margin-left:10px;    margin-top: 13px;">
                  <form method="get" action="" id="getopsdata">
                    <div style="padding:15px 10px; text-align:left; text-transform:uppercase; color:#fff; font-size:14px; position:relative;">To-Do&nbsp;List
                      <select name="opsperson" onchange="$('#getopsdata').submit();" style="    position: absolute;  top: 10px;  right: 10px;

    padding: 5px;   background-color: #232b38;  border: 1px solid #cccccc57; color: #fff; outline:0px; ">
                        <option value="0" <?php if($_REQUEST['opsperson']=='0'){ ?>selected="selected"<?php } ?>>All Operations Person</option>
                        <?php

 $select='';  

$where='';  

$rs='';   

$select='profilePhoto,email,firstName,lastName,id'; 

 if($_SESSION['userid']=='37'){ 

$where='  status="1" and deletestatus=0 and userType=1 or (userType=2 or userType=3) order by id asc'; 

} else {

$where='  status="1" and deletestatus=0 and reportingManager='.$_SESSION['userid'].' order by id asc'; 

}

$rs=GetPageRecord($select,_USER_MASTER_,$where);  

while($userInfopost=mysqli_fetch_array($rs)){  

$nn=1; 



?>
                        <option value="<?php echo encode($userInfopost['id']); ?>" <?php if(decode($_REQUEST['opsperson'])==$userInfopost['id']){ ?>selected="selected"<?php } ?>><?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </form>
                  <div style="overflow: auto; height: 251px;">
                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                      <thead width="100%">
                      <th align="left" bgcolor="#333333" class="tblheader" style="font-weight:500 !important; color:#fff !important; " ><span style="padding:0px; text-align:center; text-transform:uppercase; color:#fff; font-size:14px;">Query&nbsp;Id</span></th>
                        <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;width: 18.5%;">Date</th>
                        <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;width: 16.5%;">Time</th>
                        <!-- <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Type</th> -->
                        <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Detail</th>
						 <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Status</th>
                      <tbody>
                          <?php  
                    $todoq="select * from toDoTimeLine where deleteStatus=0 and finalStatus=0 and toDoDate!='' and toDoDate!='0000-00-00' and toDoDate!='1970-01-01' and serviceId>0 order by id desc";			
                    $rsa = mysqli_query(db(),$todoq);
                    while ($exel = mysqli_fetch_array($rsa)) {
                    $exeltodo=date('Y-m-d',strtotime($exel['toDoDate']));
                    $select='';
                    $where='';
                    $rs='';
                    $select='*'; 
                    $where='id="'.$exel['serviceId'].'" and queryStatus!=20';  
                    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
                    $resultpage=mysqli_fetch_array($rs);  
                    $selecttodotask='*';  
                    $wheretodotask='id="'.$exel['taskId'].'"';  
                    $rstodotask=GetPageRecord($selecttodotask,_TASK_MASTER_,$wheretodotask);  
                    $resultpagetodotask=mysqli_fetch_array($rstodotask); 
                    $countrows = mysqli_num_rows($rstodotask); 
                    ?>
                          <tr width="100%">
                            <td align="left" class="tbllisting">
                              <?php if($exel['serviceId']!='' && $exel['serviceId']!='0'){ ?>
                              <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($exel['serviceId']); ?>">
                              <div style="padding: 6px 6px; width: 100px;text-align: center; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;"><?php echo makeQueryId($resultpage['id']); ?></div>
                              </a>
                              <?php }else if($exel['serviceId']==0 && $exel['serviceType']=='Task') { ?>
                              <a href="showpage.crm?module=tasks&view=yes&id=<?php echo encode($exel['taskId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;"><?php echo makeQueryId($exel['taskId']); ?></div>
                              </a>
                              <?php }else if($exel['serviceId']==0 && $exel['serviceType']=='Calls'){ ?>
                              <a href="showpage.crm?module=calls&view=yes&id=<?php echo encode($exel['taskId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;"><?php echo makeQueryId($exel['taskId']); ?></div>
                              </a>
                              <?php }else{ ?>
                              <a href="showpage.crm?module=meetings&view=yes&id=<?php echo encode($exel['taskId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;    width: 40px;"><?php echo makeQueryId($exel['taskId']); ?></div>
                              </a>
                              <?php } ?></td>
                            <td align="left" class="tbllisting"><?php echo date('d-m-Y',strtotime($exel['toDoDate'])); ?></td>
                            <td align="left" class="tbllisting" ><?php  echo strtoupper ($exel['toDotime']); ?></td>
                            <!-- <td align="left" class="tbllisting"><?php //if( $exel['serviceType']=='Supplier Payment Follow-up'){ echo "Supplier Payment Follow-up";} elseif($exel['serviceType']=='todo-List'){ echo "todo-List";}else{ echo  "Client Follow Up";} ?></td> -->
                            <td align="left" class="tbllisting"><?php if ($resultpagetodotask['taskName']!='') {

              echo $resultpagetodotask['taskName'];}else{ echo $exel['serviceType']; } ?>
                            </td>
                            <td align="left" class="tbllisting"><a title="Action" onclick="alertspopupopen('action=addtodolistaction&id=<?php echo encode($exel['id']); ?>','500px','auto');">
                              <div class="driverbtn" style="color: #4285f4; font-size: 12px; text-align: left; padding-top: 0px; font-weight: 500;">+&nbsp;Action</div>
                              </a> </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                    </table>
                  </div>
                </div></td>
              <td width="40%" align="left" valign="top"><script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/highcharts-3d.js"></script>
                <div style="margin-right:10px;margin-top: 14px; ">
                  <div style="background-color:#233a49; margin-top:10px; max-width:415px;">
                      <div style="padding:15px; text-align:center; text-transform:uppercase; color:#fff; font-size:16px;">TOP 5 DESTINATIONS</div>
                      <style>

                    	#salesgraphmainbox{width:100%; height:250px !important;}

                    	#salesgraphmainbox a{display:none !important;}

                    	#topdestination{height:250px !important; max-height:250px; overflow:hidden;}

                    	#topdestination a{display:none !important;}

                    	.highcharts-credits{display:none !important;}
                      rect {fill:#233a49 !important;}
                    	</style>
                      <div id="topdestination"></div>
                      <script>
                    Highcharts.chart('topdestination', {

                      chart: {

                        type: 'pie',

                        options3d: {

                          enabled: true,

                          alpha: 45,

                          beta: 0

                        }

                      },

                      title: {

                        text: ''

                      },

                      tooltip: {

                        pointFormat: '{point.percentage:.1f}%</b>'

                      },

                      plotOptions: {

                        pie: {

                          allowPointSelect: true,

                          cursor: 'pointer',

                          depth: 35,

                          dataLabels: {

                            enabled: true,

                            format: '{point.name}'

                          }

                        }

                      },

                      series: [{

                        type: 'pie',

                        name: ' ',

                        data: [ 

                          <?php
                          $menu10=mysqli_query(db(),"select cityId, count(cityId) as cntd from packageQueryDays where queryId in (select id from "._QUERY_MASTER_." where ".$wheresearchassign."  ) and cityId in (select id from "._DESTINATION_MASTER_." where name!='') group by cityId order by cntd desc limit 0,5"); 
                          while($rest10=mysqli_fetch_array($menu10)){ 
                            $select4='name';  
                            $where4='id="'.$rest10['cityId'].'" '; 
                            $rs4=GetPageRecord($select4,_DESTINATION_MASTER_,$where4); 
                            $result=mysqli_fetch_array($rs4);  
                            if($result['name']!=''){
                            ?>
                            ['<?php echo $result['name']; ?>', <?php echo round($rest10['cntd']); ?>], 
                            <?php } 
                          } ?>
                        ]
                      }]
                    });
                    </script>
                  </div>
                </div></td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"><?php
              $companytotalcost_sum=0;
              $menug=mysqli_query(db(),"select id, SUM(totalQuotCost) As sumTotalQueryCost, SUM(totalMargin) As sumtotalMargin from "._QUOTATION_MASTER_." where 1 and queryId in ( select id from "._QUERY_MASTER_." where 1 and MONTH(queryDate)= MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 ) and status=1"); 
              $res_menug=mysqli_fetch_array($menug);
              $gmarg = $res_menug['sumtotalMargin'];

               

                

              $suppliertotalcost_sum=0;
              $menue=mysqli_query(db(),"select id,SUM(totalQuotCost) As sumtotalQuotCost from "._QUOTATION_MASTER_." where 1 and queryId in ( select id from "._QUERY_MASTER_." where 1 and MONTH(queryDate)= MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 ) and status=1"); 
              $res_menue=mysqli_fetch_array($menue);
              $suppliertotalcost_sum = $suppliertotalcost_sum+$res_menue['sumtotalQuotCost'];

                  ?>
                <style>

                	#querydatamain{width:100%; height:250px;}

                	#querydatamain a{display:none !important;}

                </style>
                <script>

  var chart = AmCharts.makeChart("querydatamain", {

    "theme": "light",

    "type": "serial",

    "startDuration": 2,

    "dataProvider": [

	

  	  <?php
  		for($m=1; $m<=12; ++$m){  
        $select='id'; 
        $where=' where   '.$wheresearchassign.'  and MONTH(queryDate)='.$m.' and YEAR(queryDate)=YEAR(now()) and moduleType=1 and deletestatus=0';
        $lastmonthQuery = countlisting($select,_QUERY_MASTER_,$where); 
        ?>  
    	  {
            "country": "<?php echo date('M', mktime(0, 0, 0, $m, 1)); ?>",
            "visits": <?php echo $lastmonthQuery; ?>,
            "color": "<?php echo rand_color(); ?>"
        }, <?php 
      } ?>
  	],

    "valueAxes": [{

        "position": "left",

        "axisAlpha":0,

        "gridAlpha":0

    }],

    "graphs": [{

        "balloonText": "[[category]]: <b>[[value]]</b>",

        "colorField": "color",

        "fillAlphas": 0.85,

        "lineAlpha": 0.1,

        "type": "column",

        "topRadius":1,

        "valueField": "visits"

    }],

    "depth3D": 40,

	"angle": 30,

    "chartCursor": {

        "categoryBalloonEnabled": false,

        "cursorAlpha": 0,

        "zoomable": false

    },

    "categoryField": "country",

    "categoryAxis": {

        "gridPosition": "start",

        "axisAlpha":0,

        "gridAlpha":0



    },

    "export": {

    	"enabled": true

     }



}, 0);

</script>
                <div style="background-color:#233a49; margin-bottom:0px; margin-top:10px; margin-right:10px; margin-left:10px;">
                  <div style="padding:15px; text-align:center; text-transform:uppercase; color:#fff; font-size:16px;"><?php echo date('Y'); ?> Queries</div>
                  <div id="querydatamain"></div>
                </div></td>
              <td width="40%" align="left" valign="top"><style>

	#salesgraphmainbox{width:100%; height:250px;}

	#salesgraphmainbox a{display:none !important;}

	</style>
          <?php

          $gmarg=0;
          $menug='';
          $where = " deletestatus=0 and quotationId in (select id from quotationMaster where 1 and MONTH(fromDate)= MONTH(now()) and YEAR(fromDate)=YEAR(now()) ) order by id desc ";
          $rs = GetPageRecord('*', _PAYMENT_REQUEST_MASTER_,$where);
          while ($resultpaymentpage = mysqli_fetch_array($rs)) {
              
          $an2ss = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.$resultpaymentpage['quotationId'].'" and queryId="'.$resultpaymentpage['queryid'].'" ');
          if(mysqli_num_rows($an2ss) > 0) {
          $quotationData = mysqli_fetch_array($an2ss);
          $totalTax = $quotationData['serviceTax']+$quotationData['tcs'];
          $totalCostWithoutTax = $quotationData['totalQuotCost']/(1+$totalTax/100);
          $totalEexpenseAMT = $totalCostWithoutTax-$quotationData['totalCompanyCost'];
          $totalclientCost = $quotationData['totalQuotCost'];

          $expenseAmount='0';
          $exrs = GetPageRecord('SUM(expenseAmount) expenses','quotationExpensesMaster',' queryId="'.$quotationData['queryId'].'"');
          $expenseData = mysqli_fetch_assoc($exrs);

            $expenseAmount.= $expenseData['expenses'];
              
            $totalMarkupCost = $totalCostWithoutTax-$quotationData['totalCompanyCost'];

            $totalMarginPercent = $quotationData['totalQuotCost']/$totalMargin;

            $totalMarginCost = $totalMarkupCost-$expenseAmount;
          
            $grandTotalMargin = $grandTotalMargin + $totalMarginCost;
            $grandTotalClient = $grandTotalClient + $totalclientCost;

            }
          }

?>
<script type="text/javascript">

var chart = AmCharts.makeChart("salesgraphmainbox", {

    "theme": "none",

    "type": "serial",

    "dataProvider": [{

        "year": 'Sales',

        "income": <?php echo round($grandTotalClient); ?>,

		"color": "<?php echo rand_color(); ?>"

    }, {

        "year": 'Gross Margin',

        "income": <?php echo round($grandTotalMargin); ?>,

		 "color": "<?php echo rand_color(); ?>"

    }],

    "valueAxes": [{

        "title": ""

    }],

    "graphs": [{

        "balloonText": "Sales in [[category]]:[[value]]",

        "fillAlphas": 1,

        "lineAlpha": 0.2,

        "title": "Income",

        "type": "column",

        "valueField": "income"

    }],

    "depth3D": 20,

    "angle": 30,

    "rotate": true,

    "categoryField": "year",

    "categoryAxis": {

        "gridPosition": "start",

        "fillAlpha": 0.05,

        "position": "left"

    },

    "export": {

    	"enabled": true

     }

});

</script>
                <div style="background-color:#233a49; margin-bottom:0px; margin-top:10px; margin-right:10px;">
                  <div style="padding:15px; text-align:center; text-transform:uppercase; color:#fff; font-size:16px;"><?php echo date('F'); ?> Sales Data</div>
                  <div id="salesgraphmainbox"></div>
                </div></td>
            </tr>
          </table></td>
        <td width="20%" align="left" valign="top"><div style="width:350px; ">
            <?php

            $select='id'; 

            $where=' where '.$wheresearchassign.' and MONTH(queryConfirmingDate)=MONTH(now()) and YEAR(queryConfirmingDate)=YEAR(now()) and queryStatus=3 and deletestatus=0';

            $confirmQuery = countlisting($select,_QUERY_MASTER_,$where);

    

            $select='id'; 

            $where=' where  '.$wheresearchassign.' and MONTH(optionSentDate)=MONTH(now()) and YEAR(optionSentDate)=YEAR(now()) and  deletestatus=0 and queryStatus=6 ';

            $thismonthsentQuery = countlisting($select,_QUERY_MASTER_,$where);


            $select='id'; 

            $where=' where '.$wheresearchassign.' and MONTH(queryRevertDate)=MONTH(now()) and YEAR(queryRevertDate)=YEAR(now()) and  deletestatus=0 and queryStatus=2';

            $revertedQuery = countlisting($select,_QUERY_MASTER_,$where);


            $select='id'; 

            $where=' where  '.$wheresearchassign.'  and MONTH(quotationDate)=MONTH(now()) and YEAR(quotationDate)=YEAR(now()) and deletestatus=0 and queryStatus=5 ';

            $quotationGenerated = countlisting($select,_QUERY_MASTER_,$where);


            $select='id'; 

            $where=' where  '.$wheresearchassign.' and MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and  deletestatus=0 and queryStatus=10 ';

            $thismonthCreatedQuery = countlisting($select,_QUERY_MASTER_,$where);

            $select='id'; 

            $where=' where  '.$wheresearchassign.' and MONTH(followupdate)=MONTH(now()) and YEAR(followupdate)=YEAR(now()) and  deletestatus=0 and queryStatus=7';

            $thismonthfollowupQuery = countlisting($select,_QUERY_MASTER_,$where);

?>
            <style>

#chartdiv {

  width: 100%;

  height: 250px;

}		

#chartdiv a{display:none !important;}	



	#topagent {

  width: 100%;

  height: 250px;

}		

#topagent a{display:none !important;}		



	#topdestination {

  width: 100%;

  height: 250px;

}		

#topdestination a{display:none !important;}						

</style>
            <script>

var chart = AmCharts.makeChart("chartdiv", {

    "theme": "light",

    "type": "serial",

	"startDuration": 2,

    "dataProvider": [{

        "country": "Confirmed",

        "visits": <?php echo round($confirmQuery);?>,

        "color": "#4CAF50"

    }, {

        "country": "Follow Up",

        "visits": <?php echo round($thismonthfollowupQuery); ?>,

        "color": "#FF6600"

    }, {

        "country": "Option Sent",

        "visits": <?php echo round($thismonthsentQuery); ?>,

        "color": "#FF9E01"

    }, {

        "country": "Quotation Generated",

        "visits": <?php echo round($quotationGenerated); ?>,

        "color": "#a598d9"

    }, {

        "country": "Reverted",

        "visits": <?php echo round($revertedQuery); ?>,

        "color": "#F8FF01"

    },{

        "country": "Created",

        "visits": <?php echo round($thismonthCreatedQuery); ?>,

        "color": "#0061ff"

    }],

    "valueAxes": [{

        "position": "left",

        "title": ""

    }],

    "graphs": [{

        "balloonText": "[[category]]: <b>[[value]]</b>",

        "fillColorsField": "color",

        "fillAlphas": 1,

        "lineAlpha": 0.1,

        "type": "column",

        "valueField": "visits"

    }],

    "depth3D": 20,

	"angle": 30,

    "chartCursor": {

        "categoryBalloonEnabled": false,

        "cursorAlpha": 0,

        "zoomable": false

    },

    "categoryField": "country",

    "categoryAxis": {

        "gridPosition": "start",

        "labelRotation": 90

    },

    "export": {

    	"enabled": true

     }



});

</script>
            <div style="background-color:#233a49; margin-top:10px;margin-top: 14px;    margin-right: 5px;">
              <div style="padding:15px; text-align:center; text-transform:uppercase; color:#fff; font-size:16px;"><?php echo date('F'); ?> Queries Report</div>
              <div id="chartdiv"></div>
            </div>
            <script>

var chart = AmCharts.makeChart("topagent", {

    "theme": "light",

    "type": "serial",

	"startDuration": 2,

    "dataProvider": [

	 <?php

$menu10=mysqli_query(db(),"select companyId, count(companyId) as cnt from "._QUERY_MASTER_." where    ".$wheresearchassign."  and clientType=1 and deletestatus=0  and queryStatus=3 group by companyId order by cnt desc limit 0,5 "); 

while($rest10=mysqli_fetch_array($menu10)){ 



  $select4='name';  

$where4='id='.$rest10['companyId'].''; 

$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 

$result=mysqli_fetch_array($rs4);  

if($result['name']!=''){

?>

          

     

	{

        "country": "<?php echo $result['name']; ?>",

        "visits": <?php echo round($rest10['cnt']); ?>,

        "color": "<?php echo rand_color(); ?>"

    }, 

	 <?php } } ?>

	],

    "graphs": [{

        "balloonText": "[[category]]: <b>[[value]]</b>",

        "fillColorsField": "color",

        "fillAlphas": 1,

        "lineAlpha": 0.1,

        "type": "column",

        "valueField": "visits"

    }],

    "depth3D": 20,

	"angle": 30,

    "chartCursor": {

        "categoryBalloonEnabled": false,

        "cursorAlpha": 0,

        "zoomable": false

    },

    "categoryField": "country",

    "categoryAxis": {

        "gridPosition": "start",

        "labelRotation": 90

    },

    "export": {

    	"enabled": true

     }



});

</script>
            <div style="background-color:#233a49; margin-top:10px;    margin-right: 5px;">
              <div style="padding:15px; text-align:center; text-transform:uppercase; color:#fff; font-size:16px;">Top 5 Agent</div>
              <div id="topagent"></div>
            </div>
          </div></td>
      </tr>
    </table>
  </div>
<?php } ?>
<?php if($_SESSION['dashboardid']==3){ ?>
  <div style="padding-bottom:10px;">
    <div class=" " style="background-color: #233a49;margin: 0px 10px; padding: 10px;margin-bottom: 10px;">
      <table width="100%" class="table" style="border-collapse:collapse" id="dashboardstatus">
        <tbody>
          <tr>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" ><?php echo $totaltodaypax['totaltodayadult']+$totaltodaypax['totaltodaychild']; ?></div>
              <div class="statusname">Today's Pax Traveling</div>
              </a></td>
            <?php 
$counthophotelq = mysqli_query(db(),"select * from todoListMaster where type=1 and statusId!=3 and actionDate='".date('Y-m-d')."' ".$todotimelineassigntodo."");
$counthophotel=mysqli_num_rows($counthophotelq); 

$counthopguidedriverq = mysqli_query(db(),"select * from todoListMaster where type=7 and statusId!=3 and actionDate='".date('Y-m-d')."' ".$todotimelineassigntodo."");
$counthopguidedriver=mysqli_num_rows($counthopguidedriverq); 

$counthopguidetransportq = mysqli_query(db(),"select * from todoListMaster where (type=2 or type=5) and statusId!=3 and actionDate='".date('Y-m-d')."' ".$todotimelineassigntodo."");
$counthopguidetransport=mysqli_num_rows($counthopguidetransportq); 
 
$counthopguideflightq = mysqli_query(db(),"select * from todoListMaster where type=6 and statusId!=3 and actionDate='".date('Y-m-d')."' ".$todotimelineassigntodo."");
$counthopguideflight=mysqli_num_rows($counthopguideflightq); 

$counthopguidetrainq = mysqli_query(db(),"select * from todoListMaster where type=5 and statusId!=3 and actionDate='".date('Y-m-d')."' ".$todotimelineassigntodo."");
$counthopguidetrain=mysqli_num_rows($counthopguidetrainq); 
  	
?>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" ><?php echo $counthophotel; ?></div>
              <div class="statusname">Today's hotel booking</div>
              </a></td>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" ><?php echo $counthopguidedriver; ?></div>
              <div class="statusname">Today's Guide/Driver</div>
              </a></td>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" ><?php echo $counthopguidetransport; ?></div>
              <div class="statusname">Today's Transport</div>
              </a></td>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" ><?php echo $counthopguideflight; ?></div>
              <div class="statusname">Today's Flight</div>
              </a></td>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" ><?php echo $counthopguidetrain; ?></div>
              <div class="statusname">Today's Train</div>
              </a></td>
            <td><a href="#" class="dashboard-outer" style="border-bottom: 2px #1cd1816b solid;">
              <div class="dashboard-status" style="color:#6699ff;" >0</div>
              <div class="statusname">Pending Invoices</div>
              </a></td>
          </tr>
        </tbody>
      </table>
      <script type="text/javascript">

$('.dashboard-status').each(function () {

$(this).prop('Counter',0).animate({

Counter: $(this).text()

}, { 
duration: 1000,

easing: 'swing',

step: function (now) {

$(this).text(Math.ceil(now));

}

});

}); 
</script>
      <style> 
#dashboardstatus tr td{ 
padding:0px !important;  
} 
.dashboard-outer { 
width: 132px; 
margin: 0px 5px; 
float: left; 
border-radius: 5px; 
padding: 10px 0px; 
}
#dashboardstatus tr td:hover .dashboard-outer {
background: #242e36;
} 
.dashboard-status {
font-size: 30px;
font-weight: 400;
text-align: center;
color: #49a82d !important;
}
.statusname {
text-transform: uppercase;
font-size: 10px;
font-weight: 500;
color: #fff;
text-align: center;
} 
.momentchartsearch{
position: relative;
    padding: 5px;
    background-color: #232b38;
    border: 1px solid #cccccc57;
    color: #fff;
    outline: 0px;
    width: auto;
    float: right;
    margin-left: 5px;
}
</style>
    </div>
    <div class=" " style="width: 98.6%; display: block; background-color: #233a49; margin: 0px 10px;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color:#233a49; margin-bottom:0px;  margin-right:10px; margin-left:10px;    margin-top: 13px;">
                    <form method="get" action="" id="getopsdata">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:14px; position:relative;">To-Do&nbsp;List
                        <select name="opsperson" onchange="$('#getopsdata').submit();" style="position: absolute;  top: 10px;  right: 0px;padding: 5px;   background-color: #232b38;  border: 1px solid #cccccc57; color: #fff; outline:0px; ">
                          <option value="0" <?php if($_REQUEST['opsperson']=='0'){ ?>selected="selected"<?php } ?>>All Operations Person</option>
                          <?php
$select='';  
$where=''; 
$rs=''; 
$select='profilePhoto,email,firstName,lastName,id'; 
 if($_SESSION['userid']=='37'){  
$where='  status="1" and deletestatus=0 and userType=1 or (userType=2 or userType=3) order by id asc'; 
} else {
$where='  status="1" and deletestatus=0 and reportingManager='.$_SESSION['userid'].' order by id asc'; 
}
$rs=GetPageRecord($select,_USER_MASTER_,$where);  
while($userInfopost=mysqli_fetch_array($rs)){  
$nn=1;
?>
                          <option value="<?php echo encode($userInfopost['id']); ?>" <?php if(decode($_REQUEST['opsperson'])==$userInfopost['id']){ ?>selected="selected"<?php } ?>><?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </form>
                    <div style="overflow: auto; height: 251px;">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <thead width="100%">
                        <th align="left" bgcolor="#333333" class="tblheader" style="font-weight:500 !important; color:#fff !important; width: " ><span style="padding:0px; text-align:center; text-transform:uppercase; color:#fff; font-size:14px;">Query&nbsp;Id</span></th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Date</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Time</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Type</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Detail</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Status</th>
                          </thead>
                        <tbody>
                          <?php  
$todoq="select * from toDoTimeLine where deleteStatus=0 and finalStatus=0 and toDoDate!='' and toDoDate!='0000-00-00' and toDoDate!='1970-01-01' ".$todotimelineassign." order by dateTime asc";					  
$rsa = mysqli_query(db(),$todoq);
while ($exel = mysqli_fetch_array($rsa)) {
$exeltodo=date('Y-m-d',strtotime($exel['toDoDate']));
$select='';
$where='';
$rs='';
$select='*'; 
$where='id="'.$exel['serviceId'].'"';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  
$selecttodotask='*';  
$wheretodotask='id="'.$exel['taskId'].'"';  
$rstodotask=GetPageRecord($selecttodotask,_TASK_MASTER_,$wheretodotask);  
$resultpagetodotask=mysqli_fetch_array($rstodotask); 
$countrows = mysqli_num_rows($rstodotask); 
?>
                          <tr width="100%">
                            <td align="left" class="tbllisting">
                              <?php if($exel['serviceId']!='' && $exel['serviceId']!='0'){ ?>
                              <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($exel['serviceId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;"><?php echo makeQueryId($resultpage['id']); ?></div>
                              </a>
                              <?php }else if($exel['serviceId']==0 && $exel['serviceType']=='Task') { ?>
                              <a href="showpage.crm?module=tasks&view=yes&id=<?php echo encode($exel['taskId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;"><?php echo makeQueryId($exel['taskId']); ?></div>
                              </a>
                              <?php }else if($exel['serviceId']==0 && $exel['serviceType']=='Calls'){ ?>
                              <a href="showpage.crm?module=calls&view=yes&id=<?php echo encode($exel['taskId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;"><?php echo makeQueryId($exel['taskId']); ?></div>
                              </a>
                              <?php }else{ ?>
                              <a href="showpage.crm?module=meetings&view=yes&id=<?php echo encode($exel['taskId']); ?>">
                              <div style="padding: 3px 6px; background-color: <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($exel['toDoDate'].' '.$exel['toDotime'])) && $exel['finalStatus']==0){ ?>#ff0000 <?php } else{ ?> #4285f4<?php } ?>;float: left; color: white; border-radius: 5px;    width: 40px;"><?php echo makeQueryId($exel['taskId']); ?></div>
                              </a>
                              <?php } ?></td>
                            <td align="left" class="tbllisting"><?php echo date('d-m-Y',strtotime($exel['toDoDate'])); ?></td>
                            <td align="left" class="tbllisting" ><?php  echo strtoupper($exel['toDotime']); ?></td>
                            <td align="left" class="tbllisting"><?php if( $exel['serviceType']=='Supplier Payment Follow-up'){ echo "Supplier Payment Follow-up";} elseif($exel['serviceType']=='todo-List'){ echo "todo-List";}else{ echo  "Client Follow Up";} ?></td>
                            <td align="left" class="tbllisting"><?php if ($resultpagetodotask['taskName']!='') {

              echo $resultpagetodotask['taskName'];}else{ echo $exel['serviceType']; } ?>
                            </td>
                            <td align="left" class="tbllisting"><a title="Action" onclick="alertspopupopen('action=addtodolistaction&id=<?php echo encode($exel['id']); ?>','500px','auto');">
                              <div class="driverbtn" style="color: #4285f4; font-size: 12px; text-align: left; padding-top: 0px; font-weight: 500;">+&nbsp;Action</div>
                              </a> </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
          <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color:#233a49; margin-bottom:0px;  margin-right:10px; margin-left:10px;    margin-top: 13px;">
                    <form method="get" action="" id="getopsdatamomentchart">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:14px; position:relative;">
                        <?php if($_REQUEST['charttype']=='0' || $_REQUEST['charttype']==''){ ?>
                        Movement&nbsp;Chart
                        <?php } if($_REQUEST['charttype']=='1'){ ?>
                        DRIVER DUTY SHEET
                        <?php } if($_REQUEST['charttype']=='2'){ ?>
                        GUIDE SHEET
                        <?php } ?>
                        <select name="charttype" onchange="$('#getopsdatamomentchart').submit();" style="position: absolute;  top: 10px;  right: 0px;padding: 5px;   background-color: #232b38;  border: 1px solid #cccccc57; color: #fff; outline:0px; ">
                          <option value="0" <?php if($_REQUEST['charttype']=='0'){ ?>selected="selected"<?php } ?>>MOVEMENT CHART</option>
                          <option value="1" <?php if($_REQUEST['charttype']=='1'){ ?>selected="selected"<?php } ?>>DRIVER DUTY SHEET</option>
                          <option value="2" <?php if($_REQUEST['charttype']=='2'){ ?>selected="selected"<?php } ?>>GUIDE SHEET</option>
                        </select>
                      </div>
                    </form>
                    <div style="overflow: auto; height: 251px;">
                      <?php if($_REQUEST['charttype']=='0' || $_REQUEST['charttype']==''){ ?>
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <thead width="100%">
                        <th align="left" bgcolor="#333333" class="tblheader" style="font-weight:500 !important; color:#fff !important; width: " ><span style="padding:0px; text-align:center; text-transform:uppercase; color:#fff; font-size:14px;">Tour&nbsp;ID</span></th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Tour&nbsp;Date</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">City</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Type</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Agent&nbsp;Name</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Lead&nbsp;Pax&nbsp;Name</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Total&nbsp;Pax</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Stay/Activity</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Tour&nbsp;Manager</th>
                          </thead>
                        <tbody style="text-align:center; color: #000; font-size: 13px;" class="moment-chart-css">
                          <?php  
$datewhere=' and quotationId in (select id from quotationMaster where status=1 and startDate BETWEEN "'.date('Y-m-d',strtotime("-1 days")).'" and "'.date('Y-m-d').'" )'; 
$itineryDay=GetPageRecord('*','quotationItinerary','1 '.$datewhere.' order by startDate asc');
while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
if($itineryDayData['serviceType']=='hotel'){ 
$rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  
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

?>
                          <tr style=" width:100%;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($itineryDayData['startDate']=='' || $itineryDayData['startDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($itineryDayData['startDate'])); }else{ echo date('d-m-Y',strtotime($itineryDayData['startDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?> </td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo 'Stay'; ?> </td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $hotelData['hotelName']; ?>"><?php echo $hotelData['hotelName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
                          </tr>
                          <?php  } 

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



?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $transferData['transferCategory']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $transferData['transferName']; ?>"><?php echo $transferData['transferName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
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



?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php  echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo "Train"; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $trainData['trainName']; ?>"><?php echo $trainData['trainName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
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



?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo "Flight"; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $flightData['flightName']; ?>"><?php echo $flightData['flightName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
                          </tr>
                          <?php  }

    }if($itineryDayData['serviceType']=='entrance'){
// echo ' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'"  '.$cityIdserch.' order by id asc ';
$rs=GetPageRecord('*','quotationEntranceMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){   


$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery);



 



$rsSight=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$resultlists['entranceNameId'].'" order by id asc '); 



$entranceDataName=mysqli_fetch_array($rsSight);




 



//$rsGst=GetPageRecord('firstName,secondName,guestPhone','guestMaster',' queryId="'.$quotationData['queryId'].'" and primaryvalue=1 order by id asc limit 1'); 



//$guestData=mysqli_fetch_array($rsGst);



$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);



?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE">Entrance</td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $entranceDataName['entranceName']; ?>"><?php echo $entranceDataName['entranceName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
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




 



//$rsGst=GetPageRecord('firstName,secondName,guestPhone','guestMaster',' queryId="'.$quotationData['queryId'].'" and primaryvalue=1 order by id asc limit 1'); 



//$guestData=mysqli_fetch_array($rsGst);



$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);



?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE">Guide</td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $GuideDataName['name']; ?>"><?php echo $GuideDataName['name']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
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
?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE">Restaurant</td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $resultlists['mealPlanName']; ?>"><?php echo $resultlists['mealPlanName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
                          </tr>
                          <?php  } 
    } 
if($itineryDayData['serviceType']=='activity'){ 
$rs=GetPageRecord('*','quotationOtherActivitymaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');   
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
$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'id="'.$resultlists['otherActivityName'].'"'); 
$otherActivityData=mysqli_fetch_array($rs1); 
?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "  ><a href="<?php $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($$quotationData['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($quotationData['fromDate'])); }else{ echo date('d-m-Y',strtotime($quotationData['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo 'Agra'; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE">Activity</td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php  echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['adult']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;" title="<?php echo $otherActivityData['otherActivityName']; ?>"><?php echo $otherActivityData['otherActivityName']; ?></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style=""><?php echo getUserName($queryData['assignTo']); ?></td>
                          </tr>
                          <?php  } 
    }


 }

 ?>
                        </tbody>
                      </table>
                      <?php } if($_REQUEST['charttype']=='1'){ ?>
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <thead width="100%">
                        <th align="left" bgcolor="#333333" class="tblheader" style="font-weight:500 !important; color:#fff !important; width: " ><span style="padding:0px; text-align:center; text-transform:uppercase; color:#fff; font-size:14px;">Tour Id</span></th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Tour&nbsp;Date</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Destination</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Guest</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Pick&nbsp;Up&nbsp;Time</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Drop&nbsp;Time</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Mode</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Vehicle&nbsp;Type</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Vehicle&nbsp;Name</th>
                          </thead>
                        <tbody style="text-align:center; color: #000; font-size: 13px;" class="moment-chart-css">
                          <?php 
$no=0;
$datewhere=' and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d',strtotime("-1 days")).'" and "'.date('Y-m-d').'" )'; 
$rs=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' 1 and queryId in (select id from queryMaster where queryStatus=3) '.$datewhere.' order by id asc '); 

while($resultlists=mysqli_fetch_array($rs)){  

 ++$no;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('id,displayId,adult,child,infant ,destinationId','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);

$selveh='id,carType,model,registrationNo';  

$whereveh='id="'.$resultlists['vehicleModelId'].'"'; 

$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 

$vehicalname=mysqli_fetch_array($rsveh);

$rstranfer=GetPageRecord('transferName,transferCategory',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$resultlists['transferNameId'].'" order by id asc '); 

$tranferData=mysqli_fetch_array($rstranfer);

$sele='*';

$whereDest=' id="'.$resultlists['destinationId'].'" ';   

$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);

$ddest=mysqli_fetch_array($rsDest);

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

?>
                          <tr style="text-align:center;">
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="https://travcrm.in/travcrm-beta/showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($resultlists['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($resultlists['fromDate'])); }else{ echo date('d-m-Y',strtotime($resultlists['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?> </td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $queryData['leadPaxName'];?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $dtime['pickupTime']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $dtime['dropTime']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><?php echo $tranferData['transferCategory']; ?></td>
                            <td align="center" valign="middle" bgcolor="#FAFDFE"><?php 
  if ($vehicalname['carType']==1) {
         echo 'Hatchback';
      } 
      if ($vehicalname['carType']==2) {
         echo 'Sedan';
       } 
      if ($vehicalname['carType']==3) {
         echo 'MPV';
       } 
       if ($vehicalname['carType']==4) {
         echo 'SUV';
       }
     ?></td>
                            <td align="center" valign="middle" bgcolor="#FAFDFE"><div id="vehicleName<?php echo $resultlists['id']; ?>"><?php echo $vehicalname['model']; ?></div></td>
                          </tr>
                          <?php  }  ?>
                        </tbody>
                      </table>
                      <?php } if($_REQUEST['charttype']=='2'){ ?>
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <thead width="100%">
                        <th align="left" bgcolor="#333333" class="tblheader" style="font-weight:500 !important; color:#fff !important; width: " ><span style="padding:0px; text-align:center; text-transform:uppercase; color:#fff; font-size:14px;">Tour Id</span></th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Tour&nbsp;Date</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Destination</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">lead&nbsp;Pax&nbsp;Name</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Guide&nbsp;Service</th>
                          <th align="left" bgcolor="#333333" class="tblheader"style="font-weight:500 !important;color:#fff !important;">Day&nbsp;Type</th>
                          </thead>
                        <tbody style="text-align:center; color: #000; font-size: 13px;" class="moment-chart-css">
                          <?php  
$no=0;    
$datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d',strtotime("-1 days")).'" and "'.date('Y-m-d').'" )'; 
$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' 1  '.$datewhere.' and tariffId!=0 order by quotationId desc '); 
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
                            <td align="left" valign="middle" bgcolor="#FAFDFE"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500;"  ><a href="https://travcrm.in/travcrm-dev/showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>"  style="color:#4285f4 !important;"><?php echo makeQueryTourId($queryData['id']); ?></a></div></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php if($resultlists['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ echo date('d-m-Y',strtotime($resultlists['fromDate'])); }else{ echo date('d-m-Y',strtotime($resultlists['fromDate'])); } ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $ddest['name']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $queryData['leadPaxName']; ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $guideCat['name'];  ?></td>
                            <td align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $guideDate['dayType']; ?></td>
                          </tr>
                          <?php  }  ?>
                        </tbody>
                      </table>
                      <?php } ?>
                    </div>
                  </div></td>
              </tr>
            </table></td>
        </tr>
      </table>
    </div>
    <style>
.book-class {
    padding: 10px;
    background-color: #e3e3e3;
    margin-bottom: 5px;
    border-radius: 4px;
	position:relative;
	
}
.book-class .book-class1 {
    font-size: 12px;
    font-weight: 500;
    color: #4285f4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 225px;
}
.book-class .book-class2{
	font-weight: 500;
    margin-top: 5px;
	    font-size: 12px;
}
.book-class .book-class3{
	font-weight: 500;
    margin-top: 5px;
	    font-size: 12px;
}
.book-class .book-class4{
	font-weight: 500;
	margin-top: 10px;
	font-size: 12px;
}
</style>
    <div class=" " style="width: 98.6%; display: block; background-color: #233a49; margin: 0px 10px; padding: 20px 0px 60px 0px;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="20%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color: #233a49; margin-bottom: 0px; margin-right: 0px; margin-left: 10px; margin-top: 0px;">
                    <form method="get" action="" id="getopsdata">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:12px; position:relative;">Hotel</div>
                    </form>
                    <div style="overflow-y: auto; max-height: 600px; overflow-x: hidden;">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tbody>
                          <?php  
		$todotimelineassigntodo=' and assignTo='.$_SESSION['userid'].''; 
		$todoq="select * from todoListMaster where type=1 and statusId!=3 and actionDate!='' and actionDate!='0000-00-00' and actionDate!='1970-01-01' ".$todotimelineassigntodo." order by new_completionDate asc";					  
		$rsaaaa = mysqli_query(db(),$todoq);  
		$countbookhotelkkkk=mysqli_num_rows($rsaaaa); 	
		if($countbookhotelkkkk>0){
		while($resultlists=mysqli_fetch_array($rsaaaa)){  
		$rsquery=GetPageRecord('id,displayId','queryMaster',' id="'.$resultlists['queryId'].'" order by id asc ');  
		$queryData=mysqli_fetch_array($rsquery); 				?>
                          <tr>
                            <td style="border-bottom: 2px #1cd1816b solid;"><div class="book-class" style=" <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])) && $resultlists['statusId']!=3){ ?> box-shadow: -8px -8px #ff0000; <?php } ?>">
                                <div class="book-class1" title="<?php echo $resultlists['taskTitle']; ?>"><?php echo $resultlists['taskTitle']; ?></div>
                                <div class="book-class2"><?php echo makeQueryId($queryData['id']); ?></div>
                                <div class="book-class3"><?php echo date('d-m-Y h:i A',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])); ?></div>
                                <div class="book-class4"> <a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" target="_blank" style="color: #4285f4 !important; margin-right: 10px !important;"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>View</a> <a style="color: #ff0000 !important;" href="<?php echo $fullurl; ?>showpage.crm?module=todolist&view=yes&id=<?php echo encode($queryData['id']); ?>&todoid=<?php echo encode($resultlists['id']); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>Action</a> </div>
                              </div></td>
                          </tr>
                          <?php } } else{ ?>
                          <tr>
                            <td style="color:#ff0000;">No Record Found.</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
          <td width="20%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color: #233a49; margin-bottom: 0px; margin-right: 0px; margin-left: 10px; margin-top: 0px;">
                    <form method="get" action="" id="getopsdata">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:12px; position:relative;">Transport/Transportation</div>
                    </form>
                    <div style="overflow-y: auto; max-height: 600px; overflow-x: hidden;">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tbody>
                          <?php  
		$todotimelineassigntodo=' and assignTo='.$_SESSION['userid'].''; 
		$todoq="select * from todoListMaster where (type=2 or type=5 or type=6) and statusId!=3 and actionDate!='' and actionDate!='0000-00-00' and actionDate!='1970-01-01' ".$todotimelineassigntodo." order by new_completionDate asc";					  
		$rsaaaa = mysqli_query(db(),$todoq);  
		$countbookhotelkkkk=mysqli_num_rows($rsaaaa); 	
		if($countbookhotelkkkk>0){
		while($resultlists=mysqli_fetch_array($rsaaaa)){  
		$rsquery=GetPageRecord('id,displayId','queryMaster',' id="'.$resultlists['queryId'].'" order by id asc ');  
		$queryData=mysqli_fetch_array($rsquery); 				?>
                          <tr>
                            <td style="border-bottom: 2px #1cd1816b solid;"><div class="book-class" style=" <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])) && $resultlists['statusId']!=3){ ?> box-shadow: -8px -8px #ff0000; <?php } ?>">
                                <div class="book-class1" title="<?php echo $resultlists['taskTitle']; ?>"><?php echo $resultlists['taskTitle']; ?></div>
                                <div class="book-class2"><?php echo makeQueryId($queryData['id']); ?></div>
                                <div class="book-class3"><?php echo date('d-m-Y h:i A',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])); ?></div>
                                <div class="book-class4"> <a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" target="_blank" style="color: #4285f4 !important; margin-right: 10px !important;"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>View</a> <a style="color: #ff0000 !important;" href="<?php echo $fullurl; ?>showpage.crm?module=todolist&view=yes&id=<?php echo encode($queryData['id']); ?>&todoid=<?php echo encode($resultlists['id']); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>Action</a> </div>
                              </div></td>
                          </tr>
                          <?php } } else{ ?>
                          <tr>
                            <td style="color:#ff0000;">No Record Found.</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
          <td width="20%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color: #233a49; margin-bottom: 0px; margin-right: 0px; margin-left: 10px; margin-top: 0px;">
                    <form method="get" action="" id="getopsdata">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:12px; position:relative;">Entrance/Sightseeing</div>
                    </form>
                    <div style="overflow-y: auto; max-height: 600px; overflow-x: hidden;">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tbody>
                          <?php  
		$todotimelineassigntodo=' and assignTo='.$_SESSION['userid'].''; 
		$todoq="select * from todoListMaster where type=3 and statusId!=3 and actionDate!='' and actionDate!='0000-00-00' and actionDate!='1970-01-01' ".$todotimelineassigntodo." order by new_completionDate asc";					  
		$rsaaaa = mysqli_query(db(),$todoq);  
		$countbookhotelkkkk=mysqli_num_rows($rsaaaa); 	
		if($countbookhotelkkkk>0){
		while($resultlists=mysqli_fetch_array($rsaaaa)){  
		$rsquery=GetPageRecord('id,displayId','queryMaster',' id="'.$resultlists['queryId'].'" order by id asc ');  
		$queryData=mysqli_fetch_array($rsquery); 				?>
                          <tr>
                            <td style="border-bottom: 2px #1cd1816b solid;"><div class="book-class" style=" <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])) && $resultlists['statusId']!=3){ ?> box-shadow: -8px -8px #ff0000; <?php } ?>">
                                <div class="book-class1" title="<?php echo $resultlists['taskTitle']; ?>"><?php echo $resultlists['taskTitle']; ?></div>
                                <div class="book-class2"><?php echo makeQueryId($queryData['id']); ?></div>
                                <div class="book-class3"><?php echo date('d-m-Y h:i A',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])); ?></div>
                                <div class="book-class4"> <a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" target="_blank" style="color: #4285f4 !important; margin-right: 10px !important;"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>View</a> <a style="color: #ff0000 !important;" href="<?php echo $fullurl; ?>showpage.crm?module=todolist&view=yes&id=<?php echo encode($queryData['id']); ?>&todoid=<?php echo encode($resultlists['id']); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>Action</a> </div>
                              </div></td>
                          </tr>
                          <?php } } else{ ?>
                          <tr>
                            <td style="color:#ff0000;">No Record Found.</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
          <td width="20%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color: #233a49; margin-bottom: 0px; margin-right: 0px; margin-left: 10px; margin-top: 0px;">
                    <form method="get" action="" id="getopsdata">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:12px; position:relative;">Guide/Driver</div>
                    </form>
                    <div style="overflow-y: auto; max-height: 600px; overflow-x: hidden;">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tbody>
                          <?php  
		$todotimelineassigntodo=' and assignTo='.$_SESSION['userid'].''; 
		$todoq="select * from todoListMaster where type=7 and statusId!=3 and actionDate!='' and actionDate!='0000-00-00' and actionDate!='1970-01-01' ".$todotimelineassigntodo." order by new_completionDate asc";					  
		$rsaaaa = mysqli_query(db(),$todoq);  
		$countbookhotelkkkk=mysqli_num_rows($rsaaaa); 	
		if($countbookhotelkkkk>0){
		while($resultlists=mysqli_fetch_array($rsaaaa)){  
		$rsquery=GetPageRecord('id,displayId','queryMaster',' id="'.$resultlists['queryId'].'" order by id asc ');  
		$queryData=mysqli_fetch_array($rsquery); 				?>
                          <tr>
                            <td style="border-bottom: 2px #1cd1816b solid;"><div class="book-class" style=" <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])) && $resultlists['statusId']!=3){ ?> box-shadow: -8px -8px #ff0000; <?php } ?>">
                                <div class="book-class1" title="<?php echo $resultlists['taskTitle']; ?>"><?php echo $resultlists['taskTitle']; ?></div>
                                <div class="book-class2"><?php echo makeQueryId($queryData['id']); ?></div>
                                <div class="book-class3"><?php echo date('d-m-Y h:i A',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])); ?></div>
                                <div class="book-class4"> <a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" target="_blank" style="color: #4285f4 !important; margin-right: 10px !important;"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>View</a> <a style="color: #ff0000 !important;" href="<?php echo $fullurl; ?>showpage.crm?module=todolist&view=yes&id=<?php echo encode($queryData['id']); ?>&todoid=<?php echo encode($resultlists['id']); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>Action</a> </div>
                              </div></td>
                          </tr>
                          <?php } } else{ ?>
                          <tr>
                            <td style="color:#ff0000;">No Record Found.</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
          <td width="20%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><div style="background-color: #233a49; margin-bottom: 0px; margin-right: 0px; margin-left: 10px; margin-top: 0px;">
                    <form method="get" action="" id="getopsdata">
                      <div style="padding:15px 0px; text-align:left; text-transform:uppercase; color:#fff; font-size:12px; position:relative;">Other Activity</div>
                    </form>
                    <div style="overflow-y: auto; max-height: 600px; overflow-x: hidden;">
                      <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tbody>
                          <?php  
		$todotimelineassigntodo=' and assignTo='.$_SESSION['userid'].''; 
		$todoq="select * from todoListMaster where (type=4 or type=8 or type=9 or type=10) and statusId!=3 and actionDate!='' and actionDate!='0000-00-00' and actionDate!='1970-01-01' ".$todotimelineassigntodo." order by new_completionDate asc";					  
		$rsaaaa = mysqli_query(db(),$todoq);  
		$countbookhotelkkkk=mysqli_num_rows($rsaaaa); 	
		if($countbookhotelkkkk>0){
		while($resultlists=mysqli_fetch_array($rsaaaa)){  
		$rsquery=GetPageRecord('id,displayId','queryMaster',' id="'.$resultlists['queryId'].'" order by id asc ');  
		$queryData=mysqli_fetch_array($rsquery); 				?>
                          <tr>
                            <td style="border-bottom: 2px #1cd1816b solid;"><div class="book-class" style=" <?php if(date('Y-m-d H:i:s')>date('Y-m-d H:i:s',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])) && $resultlists['statusId']!=3){ ?> box-shadow: -8px -8px #ff0000; <?php } ?>">
                                <div class="book-class1" title="<?php echo $resultlists['taskTitle']; ?>"><?php echo $resultlists['taskTitle']; ?></div>
                                <div class="book-class2"><?php echo makeQueryId($queryData['id']); ?></div>
                                <div class="book-class3"><?php echo date('d-m-Y h:i A',strtotime($resultlists['actionDate'].' '.$resultlists['actionTime'])); ?></div>
                                <div class="book-class4"> <a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>" target="_blank" style="color: #4285f4 !important; margin-right: 10px !important;"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>View</a> <a style="color: #ff0000 !important;" href="<?php echo $fullurl; ?>showpage.crm?module=todolist&view=yes&id=<?php echo encode($queryData['id']); ?>&todoid=<?php echo encode($resultlists['id']); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true" style="margin-right:5px;"></i>Action</a> </div>
                              </div></td>
                          </tr>
                          <?php } } else{ ?>
                          <tr>
                            <td style="color:#ff0000;">No Record Found.</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
        </tr>
      </table>
    </div>
  </div>
<?php } ?>

<?php if($_SESSION['dashboardid']==4){ ?>
  <div style="padding-bottom:0px;">
    <div class=" " style="background-color: #fff;margin: 0px; padding: 0px;margin-bottom: 0px;">
		<style>
    .cmsouter{
        text-align:center; 
        /* overflow:hidden;   */
    }
    .cmsouter .iconbox {
	display: inline-block;
    text-align: center;
    padding: 5px 10px;
    min-width: 130px;
    width: 8%;
    margin: 15px;
    border: 1px #dddddd59 solid;
    border-radius: 3px;
    background-color: #ffffff;
    box-shadow: 1px 1px 6px #e6e6e694;
    color: white;}
    .cmsouter .iconbox img{
        height: 60px;
        padding: 10px 0;
        float: left;
    }
    .container_box .rightBox .rightsectionheader {
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
        color:#000000; 
    }
    .cmsouter .text{ 
        font-size:14px;  
        color:#000000;
        text-decoration:none;
    }
    .container_box{
        padding-top: 56px;
        width: 100%;
        display: block;
        overflow: hidden;
    }
    .container_box .leftBox{
		display: inline-block;
		overflow-x: auto;
		height: 80%;
		/* border-right: 5px solid #7a96ff; */
		width: 98%;	

    }
    .container_box .leftBox .iconbox{
        text-align: left;
        padding: 10px ;
    	width: 90%;
        border-bottom: 1px #eae8e8 solid;
        border-radius: 0px;
        background-color: #ffffff;
        display: table;
    }
	 .container_box .leftBox .iconbox .fa{
		display: table-cell;
		width: 14px;
	}
	.container_box .leftBox .iconbox .text{
        display: table-cell;
        vertical-align: middle;
        padding-left: 15px;
        color: #000000;
		font-weight:500;
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
        display: inline-block;
		    /* margin-top: 56px; */
       
    }
    .container_box  .cms_title{
        margin: 0 0px; 
        text-align: left;
        padding: 15px; 
        font-size: 20px;
        color: #233a49;
        text-shadow: 1px 1px 2px white;
        box-shadow: 1px 1px 13px -3px #4caf50;
        background-color: #f2f2f287;
        margin-bottom: 15px;
    }
    .ExploreLogo{
        background-color: #f8f8f8!important;
        margin-bottom: 0px!important;
        padding: 15px!important;
        padding-left: 8%!important;
    }
    .container_box .cmsouter #pagelisterouter{
        padding: 3%!important;
        padding-top: 0%!important;
        margin: 0!important;
    }
    .style1{
        color: #f41f06
    }
	.makeclass{
		padding: 10px 8px;
		    color: #484848;
	}
/* 
              .dataTables_wrapper .dataTables_filter {
                float: left;
                top: -43px;
                position: absolute;
              }
              .dataTables_wrapper .dataTables_info {
                padding: 15px!important;
              }
              .dataTables_wrapper .dataTables_length {
                padding: 10px!important;
              }
              .dataTables_wrapper .dataTables_paginate {
                padding: 10px!important;
              }
              .dataTables_wrapper  .dt-buttons{
                position: absolute;
                top: -42px;
                left: 30%;
                z-index: 9;
              }
              
              .dataTables_wrapper .dt-buttons .dt-button{
                background-color: #f9f9f9;
                border: 1px solid #ccc;
                border-radius: 20px;
                padding: 8px 20px;
                cursor:pointer;
              }
              .dataTables_filter label{
              margin-left: 15px;
              }
              .dataTables_wrapper .dataTables_filter input {
                border: 1px solid #e2dcdc!important;
                border-radius: 16px!important;
                padding: 8px!important;
                min-width: 250px;
              }
              .gridtable .header{
                padding: 15px;
              }
              #example_filter {
                position: absolute;
                top: -44px;
                left: 0%;
              }
              
              #example_filter label {
                font-size: 18px;
              }
              
              #example_filter input {
                height: 34px;
                width: 306px;
                border-radius: 42px;
              }
        
      
              .dataTables_wrapper{
              overflow: auto!important;
                height: 450px!important;
              }
   */



</style>
      	<div class="container_box">
		<div  style="background-color: #ffffff;  left: 0px; top: 0px; position: absolute; width: 18%;height:100%;overflow: hidden;">
			<h5 class="cms_title ExploreLogo" style="margin-top:56px; padding: 16px 0px 16px 15px !important;width: 226px;">Accounts</h5>
			<div class="leftBox"> 
			
			
			
			  <div class="iconbox" style="margin-top: 10px;">
			  	<div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">AGENT / CLIENT PAYMENTS</div>
			  </div> 
			 <a href="<?php echo $fullurl; ?>?sr=18&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==18){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==18){ ?> style="color: #fff;"<?php } ?>>Agent/Client Payment Schedule</div></div></a>

			<a href="<?php echo $fullurl; ?>?sr=1&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?> style="color: #fff;"<?php } ?>>Agent/Client Pending Payment</div></div></a> 
      
			<a href="<?php echo $fullurl; ?>?sr=3&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==3){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==3){ ?> style="color: #fff;"<?php } ?>>Agent/Client Overdue Report</div></div></a>

      <a href="<?php echo $fullurl; ?>?sr=8&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==8){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==8){ ?> style="color: #fff;"<?php } ?>>Agent Turnover Report</div></div></a>

			<a href="<?php echo $fullurl; ?>?sr=2&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==2){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-get-pocket" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==2){ ?> style="color: #fff;"<?php } ?>>Received from Agent/Client</div></div></a>
			  
			  
			 <div class="iconbox"><div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">SUPPLIER PAYMENTS</div></div>  
			<a href="<?php echo $fullurl; ?>?sr=6&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==6){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-handshake-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==6){ ?> style="color: #fff;"<?php } ?>>Supplier Payment Schedule</div></div></a>
			<a href="<?php echo $fullurl; ?>?sr=4&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==4){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==4){ ?> style="color: #fff;"<?php } ?>>Supplier Pending Payment</div></div></a>
			<a href="<?php echo $fullurl; ?>?sr=5&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==5){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-get-pocket"j aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==5){ ?> style="color: #fff;"<?php } ?>>Paid to Supplier</div></div></a>
			<a href="<?php echo $fullurl; ?>?sr=7&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==7){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==7){ ?> style="color: #fff;"<?php } ?>>Supplier Overdue Report</div></div></a>
		   <!--  <a href="<?php echo $fullurl; ?>?sr=19"><div class="iconbox" <?php if($_REQUEST['sr']==19){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==19){ ?> style="color: #fff;"<?php } ?>>Day Wise Supplier Payment Pending Report</div></div></a>
		   <a href="<?php echo $fullurl; ?>?sr=8"><div class="iconbox" <?php if($_REQUEST['sr']==8){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-times" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==8){ ?> style="color: #fff;"<?php } ?>>Payable - Not updated</div></div></a> -->
			 
       <div class="iconbox"><div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">ACCOUNT SUMMARY</div></div>
       <a href="<?php echo $fullurl; ?>?sr=42&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==42){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==42){ ?> style="color: #fff;"<?php } ?>>Expense Report</div></div></a>

       <a href="<?php echo $fullurl; ?>?sr=10&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==10){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==10){ ?> style="color: #fff;"<?php } ?>>Query Wise Profit Report</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=9&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==9){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==9){ ?> style="color: #fff;"<?php } ?>>Payable Vs Receivable</div></div></a>
                

                <!-- remove Profit Report by mohd islam -->
                <a style="display: none; " href="<?php echo $fullurl; ?>?sr=11&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==11){ ?> style="color: #fff;background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==11){ ?> style="color: #fff; "<?php } ?>>Profit Report</div></div></a>


                <a href="<?php echo $fullurl; ?>?sr=12&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==12){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==12){ ?> style="color: #fff;"<?php } ?>>Tax Report</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=13&daterange=<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).'+-+'.date('d-m-Y',strtotime('today')); ?>"><div class="iconbox" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff;"<?php } ?>>Non Invoice Report</div></div></a>

                <!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -360 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=34"><div class="iconbox <?php if($_REQUEST['report']==34){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Turnover&nbsp;Statement&nbsp;Country&nbsp;Wise</div></div></a> -->

                <a href="<?php echo $fullurl; ?>?sr=34"><div class="iconbox" <?php if($_REQUEST['sr']==34){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==34){  ?> style="color: #fff;"<?php } ?>>Turnover&nbsp;Statement&nbsp;Country&nbsp;Wise</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=40"><div class="iconbox" <?php if($_REQUEST['sr']==40){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==40){  ?> style="color: #fff;"<?php } ?>>Turnover&nbsp;Statement&nbsp;Executive&nbsp;Wise</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=41"><div class="iconbox" <?php if($_REQUEST['sr']==41){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==41){ ?> style="color: #fff;"<?php } ?>>File&nbsp;Wise&nbsp;Liability&nbsp;Report</div></div></a>
                
                
                <!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -360 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=40"><div class="iconbox <?php if($_REQUEST['report']==40){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">Turnover&nbsp;Statement&nbsp;Executive&nbsp;Wise</div></div></a> -->
                <!-- <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -360 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=41"><div class="iconbox <?php if($_REQUEST['report']==41){?> active <?php } ?>"><img src="images/th3333s.jpg" /><div class="text">File&nbsp;Wise&nbsp;Liability&nbsp;Report</div></div></a> -->






                <!-- new added dashboard in finance dashboard pages -->
                <!-- <a href="<?php echo $fullurl; ?>?sr=13"><div class="iconbox" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff;"<?php } ?>>Turnover Statement - Proforma Invoice Country Wise</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=13"><div class="iconbox" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff;"<?php } ?>>Turnover Statement - Proforma Invoice Executive Wise</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=13"><div class="iconbox" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff;"<?php } ?>>File Wise Liability Report</div></div></a> -->


		   <!--  
		   <div class="iconbox"><div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">REPORTS</div></div> 
			<a href="<?php echo $fullurl; ?>?sr=15"><div class="iconbox" <?php if($_REQUEST['sr']==15){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==15){ ?> style="color: #fff;"<?php } ?>>Proforma Inv Register</div></div></a>
		   
		   <a href="<?php echo $fullurl; ?>?sr=16"><div class="iconbox" <?php if($_REQUEST['sr']==16){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==16){ ?> style="color: #fff;"<?php } ?>>Invoice Register</div></div></a>
	
			<a href="<?php echo $fullurl; ?>?sr=17"><div class="iconbox" <?php if($_REQUEST['sr']==17){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==17){ ?> style="color: #fff;"<?php } ?>>Turnover Statemant</div></div></a>
			-->
			
		</div>
		</div>
	
		<script>
		$(document).ready(function(){
		  $("#defineslab").click(function(){
			$("#defineslabtable").toggle();
		  });
		}); 
		</script>
		
		<style>
		.tbllisting {
			color: #000 !important; 
		}
		</style>					
  
		<div style="background-color: #ffffff; position: fixed; right: 0px; top: 0px; bottom:0px; width: 82%; overflow-y: scroll; overflow-x:hidden;">
    
                      <!-- Below filter for agent reports -->
            <?php if($_REQUEST['sr']==18 || $_REQUEST['sr']=='' || $_REQUEST['sr']==1 || $_REQUEST['sr']==3 || $_REQUEST['sr']==2 || $_REQUEST['sr']==8){ ?>
              <table width="100%" height="" border="0" cellpadding="0" cellspacing="0" style="position:relative; margin-top:56px;">
                <tr>
                <td width="91%" align="left" valign="top">
                  <form id="listform" name="listform" method="get">
                    <input name="module" id="module" type="hidden" value="accounts" />
                    <input name="sr" id="report" type="hidden" value="<?php echo $_REQUEST['sr'];?>" />
                    <div >
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px 5px 0;border-bottom: 1px solid #ccc;">
                        <tr>
                          <h3 class="cms_title"> <?php if($_REQUEST['sr']==18){ ?> Agent / Client Payment Schedule Report 
                              <div class="note-r" style="text-align: right;margin-top: -30px;margin-right: 75px; display: none;"><span class="right-s-note" style="font-size: 12px;margin-right: 40px;color: #705b5b;">In case user is selecting agent in type select window will appear. <br>in case of B2C will be appear. search will be like as Query</span> </div>
                             <?php } if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?> Agent/Client Payment Pending Report  
                             
                              <?php }if($_REQUEST['sr']==3){ ?> Agent/Client Overdue Report 

                              <?php }if($_REQUEST['sr']==8){ ?> Agent Turnover Report 
                                
                                
                                <?php }if($_REQUEST['sr']==2){ ?> Received from Agent/Client Report 
                                  
                                  <?php } ?> </h3>
                          
                          
                          <td width="75%">
                            <table width="100%" border="0" cellspacing="0" cellpadding="3" >
                              <tr>
                                <td >&nbsp;</td>
                                <?php if($_REQUEST['sr']==2){ ?>
                                <td style="font-size: 14px;">Query Type</td>
                                <?php } ?>
                                <td style="font-size: 14px;">Financial&nbsp;Year</td>
                              </tr>
                              <tr>
                                <?php if($_REQUEST['sr']!=8){ ?>
                                  <td style="width: 50%; font-size:14px;">Search By:
                                    Tour Date <input type="checkbox" checked <?php if($_REQUEST['searchBy']==1){ ?> checked="checked" <?php } ?> name="searchBy" id="searchById" value="1" style="display: inline-block !important;"> </td>

                                  <?php }else{
                                    echo '<td style="width: 50%;" >&nbsp;</td>';
                                  } if($_REQUEST['sr']==2){ ?>
                                  <td>
                                    <select name="queryType" id="queryType" class="gridfield" style="padding: 9px 6px;">
                                      <option value="">Select</option>
                                      <option value="3" <?php if($_REQUEST['queryType']==3){?> selected <?php } ?> >Confirmed Query</option>
                                      <option value="20" <?php if($_REQUEST['queryType']==20){?> selected <?php } ?>>Cancelled Query</option>
                                    </select>
                                  </td>
                                  <?php } ?>
                                <td  align="right" style="font-size:14px;">

                                <select name="financialYear" id="financialYear" class="gridfield" style="padding: 9px 6px;width: 100px;">
                                <option value="">Select</option>
                                  <?php 
                                  
                                  $fres = GetPageRecord('*','financeYearMaster','1 and status=1 and deletestatus=0');
                                  while($fdata = mysqli_fetch_assoc($fres)){
                                    ?>
                                    <option value="<?php echo $fdata['id']; ?>" <?php if($currentFinancialYear==$fdata['financeYear']){ ?> selected="selected" <?php } ?> ><?php echo $fdata['financeYear']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                </td>
                                <td  align="right" width="16%">
                                  <input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterangeDashboard" style="width: 150px; border-radius: 42px;" value="<?php 

                                  if($_GET['daterange']!=''){ 
                                    echo $_GET['daterange'];
                                   }else{
                                    echo date('1-m-Y').' - '.date('d-m-Y'); 
                                  } 
                                  ?>" size="100" maxlength="100" placeholder="Travel Date"/>
                                </td>
                                <!-- new added option type as started -->
                                <td colspan="2">
                                  <div class="griddiv">
                                 
                                  <select id="clientType" name="clientType" class="gridfield validate makeclass" displayname="Client Type" autocomplete="off" onchange="selectAgentClient();">
                                    <option value="">Client Type</option>
                                    <option value="1" <?php if($_REQUEST['clientType']==1){?> selected="selected" <?php } ?> >Agent</option>
                                    <option <?php if($_REQUEST['clientType']==2){?> selected="selected" <?php } ?> value="2">Client/B2C</option>
                                   
                                  </select> 
                                 
                                  </div>
                                </td>
                                <!-- new added option type as ended -->
                                <td  align="right" width="10%">
                                  <select name="agentCode" id="agentCode" class="makeclass">
                                    <option value="">Select Agent</option>
                                   
                                  </select>
                                </td>
                                <td  align="right" width="10%">
                                  <input type="submit" name="Submit" value="Search" class="   makeclass" style="background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;cursor:pointer;" /></td>
                                </tr>
                              </table>
                              
                            </td>
                          </tr>
                        </table>
                      </div>
                    </form>
                  </td>
                </tr>
              </table>
              <!-- <div id="loadclientagent">  </div> -->
                <script>
                  function selectAgentClient(){
                    var clienttype = $("#clientType").val();
                    $("#agentCode").load('loadclientagent.php?action=loadagentsclients&clientType='+clienttype);
                    $("#agentCode").css('width',"150px");
                  }
                  selectAgentClient();
                </script>
             
            
              <?php } ?>
              <!-- Below filters for supplier reports -->
              <?php if($_REQUEST['sr']==6 || $_REQUEST['sr']==4 || $_REQUEST['sr']==5 || $_REQUEST['sr']==7){ ?>
              <table width="100%" height="" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                <td width="91%" align="left" valign="middle">
                  <form id="listform" name="listform" method="get">
                    <input name="module" id="module" type="hidden" value="accounts" />
                    <input name="sr" id="report" type="hidden" value="<?php echo $_REQUEST['sr'];?>" />
                    <div>
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: -50px; padding: 0 30px 5px 0;border-bottom: 1px solid #ccc;">
                        <tr>
                          <h3 class="cms_title" style="margin: 59px 0px;"> <?php if($_REQUEST['sr']==6){ ?> Supplier Payment Schedule Report 
                            
                            
                            <?php } if($_REQUEST['sr']==4){ ?> Supplier Payment Pending Report 
                              
                              

                              <?php }if($_REQUEST['sr']==5){ ?> Paid To Supplier Report 
                                
                               
                                
                                <?php }if($_REQUEST['sr']==7){ ?> Supplier Overdue Report
                                  
                                  
                            
                                  <?php } ?> </h3>
                          <td width="25%">
                          </td>
                          
                          <td width="75%">
                            <table width="100%" border="0" cellspacing="0" cellpadding="3" >
                              <tr >
                              <?php if($_REQUEST['sr']==5){ ?>
                                  <td align="right" width="43%" style="font-size: 15px;">Query&nbsp;Type
                                    <select name="queryType" id="queryType" class="gridfield" style="padding: 9px 6px;">
                                      <option value="">Select</option>
                                      <option value="3" <?php if($_REQUEST['queryType']==3){?> selected <?php } ?> >Confirmed Query</option>
                                      <option value="20" <?php if($_REQUEST['queryType']==20){?> selected <?php } ?>>Cancelled Query</option>
                                    </select>
                                  </td>
                                  <?php } ?>
                                <td  align="right" style="font-size:14px;">Financial&nbsp;Year

                              <select name="financialYear" id="financialYear" class="gridfield" style="padding: 9px 6px;">
                              <option value="">Select</option>
                                <?php 
                                $fres = GetPageRecord('*','financeYearMaster','1 and status=1 and deletestatus=0');
                                while($fdata = mysqli_fetch_assoc($fres)){
                                  ?>
                                  <option value="<?php echo $fdata['id']; ?>" <?php if($currentFinancialYear==$fdata['financeYear']){ ?> selected="selected" <?php } ?> ><?php echo $fdata['financeYear']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                              </td>
                                <td  align="right" width="3%">
                                  <?php if($_REQUEST['sr']==6 || $_REQUEST['sr']==4 || $_REQUEST['sr']==5){ ?>
                                  <input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterangeDashboard" style="width: 148px; border-radius: 42px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('1-m-Y').' - '.date('d-m-Y'); } ?>" size="100" maxlength="100" placeholder="Travel Date"/>
                                  <?php } ?>
                                </td>
                                <td  align="right" width="20%">
                                  <select style="width: 100%;border-radius: 20px;" name="supplierCode" id="supplierCode" class="makeclass T5<?php if($_REQUEST['supplierCode']!='') { ?> selected <?php } ?>">
                                    <option value="">Select Supplier</option>
                                    <?php
                                    $a13=GetPageRecord('*',_SUPPLIERS_MASTER_,' 1 and name!="" and id in ( select supplierId from finalQuotSupplierStatus where 1 and deletestatus=0 ) and status=1 and deletestatus=0  order by name asc');
                                    while($supplierData=mysqli_fetch_array($a13)){
                                    ?>
                                    <option <?php echo "value='".strip($supplierData['id'])."'"; if(isset($_REQUEST['supplierCode']) && $_REQUEST['supplierCode']==strip($supplierData['id'])){echo 'selected';} ?> ><?php echo $supplierData['name'];?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td  align="right" width="10%">
                                  <input type="submit" name="Submit" value="Search" class="   makeclass" style="border-radius: 25px;background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;" /></td>
                                </tr>
                              </table>
                              
                            </td>
                          </tr>
                        </table>
                      </div>
                    </form>
                  </td>
                </tr>
              </table>
              <?php } ?>
               <!-- Below filters for supplier reports -->
               <?php if($_REQUEST['sr']==10 || $_REQUEST['sr']==9 || $_REQUEST['sr']==11 || $_REQUEST['sr']==12 || $_REQUEST['sr']==13 || $_REQUEST['sr']==34 || $_REQUEST['sr']==40 || $_REQUEST['sr']==42 || $_REQUEST['sr']==41 ){ ?>
              <table width="100%" height="" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                <td width="91%" align="left" valign="middle">
                  <form id="listform" name="listform" method="get">
                    <input name="module" id="module" type="hidden" value="accounts" />
                    <input name="sr" id="report" type="hidden" value="<?php echo $_REQUEST['sr'];?>" />
                    <div>
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: -50px; padding: 0 30px 5px 0;border-bottom: 1px solid #ccc;">
                        <tr>
                          <h3 class="cms_title" style="margin: 59px 0px;">
                           <?php if($_REQUEST['sr']==9){ ?> Payable Vs Receivable Report
                        
                            <?php } if($_REQUEST['sr']==10){ ?> Query Wise Profit Report 
                              
                              <?php }if($_REQUEST['sr']==11){ ?> Profit Report 
                               
                                <?php }if($_REQUEST['sr']==12){ ?> Tax Report
                               
                                  <?php } if($_REQUEST['sr']==13){ ?> Non Invoice Report
                                    
                                    <?php } if($_REQUEST['sr']==42){ ?> Expense Report
                                    
                                      <?php } ?>
                                  
                                 
                                    <?php if($_REQUEST['sr']==34){ ?> Turnover Statement Country Wise
                                      <?php } if($_REQUEST['sr']==40){ ?> Turnover Statement Executive Wise
                                        <?php } if($_REQUEST['sr']==41){ ?> File Wise Liability Report
                                    <?php } ?> </h3>
                          <td width="25%">
                          </td>
                          
                          <td width="75%">
                            <table width="100%" border="0" cellspacing="0" cellpadding="3" >
                              <tr>
                                <!-- new added sales person report  -->
                                <?php if($_REQUEST['sr']==42){ ?>

                                  <td width="62%" align="right" style="font-size: 14px;">Expense&nbsp;Head
                                    <select name="expenseHead" id="expenseHead" class="gridfield " style="padding: 9px 6px;">
                                  <option value="">Select</option>
                                  <?php 
                                  $hres = GetPageRecord('*','expenseHeadMaster','status=1 and deletestatus=0');
                                  while($exres = mysqli_fetch_assoc($hres)){
                                    ?>
                                    <option value="<?php echo $exres['id']; ?>" <?php if($_REQUEST['expenseHead']==$exres['id']){ ?> selected="selected" <?php } ?> ><?php echo $exres['name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  </td>
                                  
                                <?php }else{ 
                                  if($_REQUEST['sr']==10){ ?>

                                  <td  align="right" class="saleperson1" style="width:9%;font-size:14px;"><span>Client&nbsp;Type</span>

                                    <select name="clientTypes" id="clientTypes" class="gridfield " style="padding: 9px 6px;">
                                    <option value="1">Agent</option>
                                    <option value="2">B2C</option>

                                    
                                    </select>
                                    </td>
                                      <?php } ?>
                                <td  align="right" class="saleperson1" style="width:31%;font-size:14px;"><span>Sales&nbsp;Person</span>

                                <select name="salesperson" id="salesperson" class="gridfield " style="padding: 9px 6px;">
                                <option value="">Select</option>
                                
                                <?php 
                                  $wheresp=" status=1 and deletestatus=0 ";
                                  $rsp=GetPageRecord('*','userMaster',$wheresp);
                                    while($resultsp = mysqli_fetch_assoc($rsp)){
                                    ?>
                                    <option value="<?php echo $resultsp['id']; ?>" <?php if($_REQUEST['salesperson']==$resultsp['id']){ echo 'selected'; } ?>><?php echo $resultsp['firstName'].' '.$resultsp['lastName']; ?></option>
                                    <?php
                                    }
                                ?>
                                </select>
                                </td>
                              <!-- salse person reprt added code end -->

                                
                                <td  align="right" style="width: 22%; font-size:14px;">Financial&nbsp;Year

                              <select name="financialYear" id="financialYear" class="gridfield" style="padding: 9px 6px;">
                              <option value="">Select</option>
                                <?php 
                                $fres = GetPageRecord('*','financeYearMaster','1 and status=1 and deletestatus=0');
                                while($fdata = mysqli_fetch_assoc($fres)){
                                  ?>
                                  <option value="<?php echo $fdata['id']; ?>" <?php if($currentFinancialYear==$fdata['financeYear']){ ?> selected="selected" <?php } ?> ><?php echo $fdata['financeYear']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                              </td>
                              <?php } ?>
                                <td  align="right">
                                  <input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterangeDashboard" style="width: 180px; border-radius: 42px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else {  echo date('d-m-Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).' - '.date('d-m-Y'); } ?>" size="100" maxlength="100" placeholder="Travel Date"/>
                                
                                </td>
                               
                                <td  align="right" width="10%">
                                  <input type="submit" name="Submit" value="Search" class="   makeclass" style="border-radius: 25px;background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;" /></td>
                                  <?php } ?>
                                </tr>
                              </table>
                              
                            </td>
                          </tr>
                        </table>
                     
                    </form>
                  </td>
                </tr>
              </table>
            <div class="rightBox cmsouter" id="loadAccountsReports"  >Please Wait...</div>
		</div>   
      
      </div>
      <?php } ?>
      <script>
          // ==============================
     <?php
           // Agent Reports



           if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?>
            $('#loadAccountsReports').load("loadAgentPaymentPendingReport.php?<?php 
            if(isset($_REQUEST['searchBy']))
            echo 'searchBy='.urlencode($_REQUEST['searchBy']).'&';
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            if(isset($_REQUEST['clientType']))
            echo 'clientType='.urlencode($_REQUEST['clientType']).'&'; 
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
          <?php
          }

          if($_REQUEST['sr']==2){ 
            ?>
            $('#loadAccountsReports').load("loadReceivedFromAgentReport.php?<?php 
           if(isset($_REQUEST['searchBy']))
           echo 'searchBy='.urlencode($_REQUEST['searchBy']).'&';
           if(isset($_REQUEST['agentCode']))
           echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
           if(isset($_REQUEST['daterange']))
           echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
           if(isset($_REQUEST['paymentstatus']))
           echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
           if(isset($_REQUEST['clientType']))
           echo 'clientType='.urlencode($_REQUEST['clientType']).'&'; 
           if(isset($_REQUEST['financialYear']))
           echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
           if(isset($_REQUEST['queryType']))
           echo 'queryType='.urlencode($_REQUEST['queryType']).'&'; 
            ?>");
            <?php
          }
          
          if($_REQUEST['sr']==18){ 
            ?>
            $('#loadAccountsReports').load("agentPaymentScheduleReport.php?<?php 
            if(isset($_REQUEST['searchBy']))
            echo 'searchBy='.urlencode($_REQUEST['searchBy']).'&';
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            if(isset($_REQUEST['clientType']))
            echo 'clientType='.urlencode($_REQUEST['clientType']).'&'; 
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
            <?php
          }
          
          
          if($_REQUEST['sr']==3 ){ ?>
            $('#loadAccountsReports').load("loadAgentOverdueReport.php?<?php 
            if(isset($_REQUEST['searchBy']))
            echo 'searchBy='.urlencode($_REQUEST['searchBy']).'&';
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            if(isset($_REQUEST['clientType']))
            echo 'clientType='.urlencode($_REQUEST['clientType']).'&'; 
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
            <?php
          }

          if($_REQUEST['sr']==8 ){ ?>
            $('#loadAccountsReports').load("loadAgentTurnoverReport.php?<?php 
            if(isset($_REQUEST['searchBy']))
            echo 'searchBy='.urlencode($_REQUEST['searchBy']).'&';
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            if(isset($_REQUEST['clientType']))
            echo 'clientType='.urlencode($_REQUEST['clientType']).'&'; 
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
            <?php
          }
          
          // Suppplier reports
          if($_REQUEST['sr']==6 ){ ?>
            $('#loadAccountsReports').load("loadSupplierScheduleReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
            <?php
          }
          if($_REQUEST['sr']==4 ){ ?>
            $('#loadAccountsReports').load("loadSupplierPendingPaymentReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
            <?php
          }

          if($_REQUEST['sr']==5){ ?>
            $('#loadAccountsReports').load("loadPaidToSupplierReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            if(isset($_REQUEST['queryType']))
           echo 'queryType='.urlencode($_REQUEST['queryType']).'&';
           if(isset($_REQUEST['daterange']))
           echo 'daterange='.urlencode($_REQUEST['daterange']).'&';
           if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            ?>");
            <?php
          }

          if($_REQUEST['sr']==7 ){ ?>
            $('#loadAccountsReports').load("loadSupplierOverdueReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            ?>");
            <?php
          }
          
          // Account summaryfinancialYear

          if($_REQUEST['sr']==10){ ?>
            $('#loadAccountsReports').load("loadQueryWiseProfitReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['salesperson']))
            echo 'salesperson='.urlencode($_REQUEST['salesperson']).'&'; 
            if(isset($_REQUEST['clientTypes']))
            echo 'clientTypes='.urlencode($_REQUEST['clientTypes']).'&'; 
            ?>");
            <?php
          }

          if($_REQUEST['sr']==9){ ?>
            $('#loadAccountsReports').load("loadAccountsPayableVsReceivableReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            ?>");
            <?php
          }
        

          if($_REQUEST['sr']==11){ ?>
            $('#loadAccountsReports').load("loadAccountsProfitReport.php?<?php 
           if(isset($_REQUEST['agentCode']))
           echo 'agentCode='.urlencode($_REQUEST['agentCode']);
           if(isset($_REQUEST['financialYear']))
           echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
           if(isset($_REQUEST['daterange']))
           echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            ?>");
            <?php
          }

          if($_REQUEST['sr']==12){ ?>
            $('#loadAccountsReports').load("loadAccountsTaxReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            ?>");
            <?php
          }

          if($_REQUEST['sr']==13){ ?>
            $('#loadAccountsReports').load("loadAccountsNonInvoiceReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            ?>");
            <?php
          }

          // Expenses repport
        if($_REQUEST['sr']==42){ ?>
            $('#loadAccountsReports').load("expensesReport.php?<?php 
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&';
            if(isset($_REQUEST['financialYear']))
            echo 'financialYear='.urlencode($_REQUEST['financialYear']).'&'; 
            if(isset($_REQUEST['expenseHead']))
            echo 'expenseHead='.urlencode($_REQUEST['expenseHead']).'&'; 
            ?> ");
            <?php
          }
          ?>
          

          // tabing index filter functions
          function agentPaymentschedulefun(filterId){
            $('#loadAccountsReports').load("agentPaymentScheduleReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            ?>filterId="+filterId+"");

          } 

          function agentPaymentPendingfun(filterId){
            $('#loadAccountsReports').load("loadAgentPaymentPendingReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            ?>filterId="+filterId+"");

          } 

          function agentPaymentOverDuefun(filterId){
            $('#loadAccountsReports').load("loadAgentOverdueReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            ?>filterId="+filterId+"");
          }

          function receivedPaymentFromagentfun(filterId){
            $('#loadAccountsReports').load("loadReceivedFromAgentReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            if(isset($_REQUEST['paymentstatus']))
            echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
            ?>filterId="+filterId+"");
          }

          function supplierSchedulePaymentfun(filterId){
            $('#loadAccountsReports').load("loadSupplierScheduleReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            ?>filterId="+filterId+"");
          }

          function supplierPendingPaymentfun(filterId){
            $('#loadAccountsReports').load("loadSupplierPendingPaymentReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            ?>filterId="+filterId+"");
          }
          

          function getSupplierOverduefun(filterId){
            $('#loadAccountsReports').load("loadSupplierOverdueReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            ?>filterId="+filterId+"");
          }

          function paidToSupplierfun(filterId){
            $('#loadAccountsReports').load("loadPaidToSupplierReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            ?>filterId="+filterId+"");
          }

        


          function getAccountsTaxReportfun(sr){
            var yearCode = $('#yearCode'+sr).val();
            var monthCode = $('#monthCode'+sr).val();
            $('#loadAccountsReports').load('loadAccountsTaxReport.php?yearCode='+yearCode+'&monthCode='+monthCode);
          }

          function queryWiseProfitfun(filterId){
            $('#loadAccountsReports').load("loadQueryWiseProfitReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            if(isset($_REQUEST['daterange']))
            echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
            ?>filterId="+filterId+"");
          }

          function getPayableVsReceivablefun(filterId){
            $('#loadAccountsReports').load('loadAccountsPayableVsReceivableReport.php?filterId='+filterId+'');
          }
          

          function getAccountsProfitReportfun(filterId){
            // var yearCode = $('#yearCode'+sr).val();
            // var monthCode = $('#monthCode'+sr).val();
            $('#loadAccountsReports').load('loadAccountsProfitReport.php?filterId='+filterId+'');
            // $('#loadAccountsReports').load('loadAccountsProfitReport.php?yearCode='+yearCode+'&monthCode='+monthCode);
          }

          function getAccountsNonInvoiceReportfun(filterId){
            $('#loadAccountsReports').load("loadAccountsNonInvoiceReport.php?<?php 
            if(isset($_REQUEST['supplierCode']))
            echo 'supplierCode='.urlencode($_REQUEST['supplierCode']).'&';
            ?>filterId="+filterId+"");
          } 
 


          // --------========================

 </script>
      <style type="text/css">
                .cmslistBox{
                    display: block;
                    position: relative;
                    width: 100%;
                    overflow: hidden;
                    /* height: 300px; */
                    /* padding: 30px; */
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
                .cmslistBox_dsdsds{

                }
                
            </style>
    </div>
  </div>


  </script>
<?php 
if($_SESSION['dashboardid']==4){ ?>
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
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <?php
          } 
          ?>
          <script type="text/javascript" >
             $(document).ready(function() {
                //toggleBtn side bar
                $('.toggleBtn').on('click', function() {
                  $('.sidebarBtn').toggleClass("sidebar-collapsed");
                  $('.sidebarBtn').toggleClass("sidebar");
                  
                  if($('.sidebarBtn').hasClass('sidebar-collapsed') == true ){
                    $('#contentBox').css('width','96%');
                    $('.sidebarBtn .text').hide();
                  }else{
                    $('#contentBox').css('width','80%');
                    $('.sidebarBtn .text').show();
                  }
                });
                
                //Data Tables
                // $.extend($.fn.dataTable.defaults, {
                //   dom: 'frtip'
                // });
                $('#exampleDiv').DataTable({
                  scrollX: true,
                  // scrollY: 350,
                  dom: 'frtilpB',
                  buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'pdfHtml5'
                  ],
                  language: {
                    search: "Search: ",
                    searchPlaceholder: "Agent,/ Client/B2C",
                  },
                    
                });
              

              jQuery('#daterangeDashboard').daterangepicker({
                "autoApply": true,
                opens: 'right',
                locale:{
                  format: 'DD-MM-YYYY'
                }
              },
              function(start, end, label) {
              
              });
            });

          //   jQuery('#daterange').daterangepicker({
          //   "autoApply": true,
          //   opens: 'right',
          //   locale:
          //   {
          //     format: 'DD-MM-YYYY'
          //   }
          // },
          // function(start, end, label) {
          
          // });


          </script>
          <style type="text/css">
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
            #exampleDiv_filter{
              position: absolute;
              top: -71px;
              left: 8px;
              font-size: 14px;
            }

            .dataTables_wrapper .dataTables_filter input{
              padding: 7px !important;
              margin-top: 44px;
            }

            #exampleDiv_wrapper{
              width: 99%;
            margin-top: 25px;
            }
            .dt-buttons{
              margin-top: 20px;
              margin-bottom: 20px;
              /* width: 83px;
              height: 34px;
              border-radius: 20px; */
            }
            .dataTables_length{
              margin-top: 4px;
              padding-left: 10px;
            }
            .dataTables_scrollHead{
              width: 1104px !important;
            }
            .dataTables_scrollHeadInner{
              width: 1104px !important;
            }
            .dataTable{
              width: 1104px !important;
            }
            .tablesorter{
              width: 1104px !important;
            }
            .dataTables_scrollBody{
              width: 1104px !important;
            }
          /* .leftlistBox{
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
          .cmslistBox_dsdsds{
          } */
          </style>
        </div>
      </div>

<?php //} ?>
<!-- Financ Dashboard ends -->
<?php if($_SESSION['dashboardid']==2){ 
    $year=date('Y');
    $monthName=date('F');
    $thismonth=date('m');

    if($_GET['assignto']!=''){  
        $whereQuery222=''; 
        $whereQuery=''; 
        $whereQuery=' and assignTo='.decode($_GET['assignto']).''; 
        $whereQuery222=' and assign_to='.decode($_GET['assignto']).''; 
    }
  $select=''; 
  $where=''; 
  $rs='';   
  $select='*'; 
  $where=' year='.$year.' '.$whereQuery222.''; 
  $rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
  $resultTarget=mysqli_fetch_array($rs);  
    
  $select=''; 
  $where=''; 
  $rs='';  
  $select='*';  
  $salesrevenue_target_monethvaluetotal=0;  
  $salesrevenue_opportunity_monethvaluetotal=0;  
  $monthvalue=0; 
  $monthvalue_opportunity=0; 
  $totalcallonly_stage=0; 
  $initialmeeting_stage=0; 
  $quotation_stage=0; 
  $followupforclose_stage=0; 
  $total_achievement=0; 
  $total_lost=0;

  $m=date('F'); 
  if($_GET['assignto']!=''){  
      $salesrevenue_target_monethvaluetotal = $resultTarget["".$m.""]; 
  } 
  else { 
      $menu22=mysqli_query(db(),"select * from "._TARGET_MASTER_." where 1 "); 
      while($rest22=mysqli_fetch_array($menu22)){ 
          $salesrevenue_target_monethvaluetotal = $rest22["".$m.""]+$salesrevenue_target_monethvaluetotal; 
      }
  }

  $totalSales='0';
  $menu2=mysqli_query(db(),"select id from "._QUERY_MASTER_." where 1 ".$whereQuery." "); 
  while($rest2=mysqli_fetch_array($menu2)){ 
      
      $select=''; 
      $where=''; 
      $rs='';   
      $select='*'; 
      $where=' queryId='.$rest2['id'].''; 
      $rs=GetPageRecord($select,'agentPaymentRequest',$where); 
      $resultS=mysqli_fetch_array($rs);  
      $totalSales=$totalSales+$resultS['finalCost'];
  } 

  if($loginuserprofileId==1){ 
    $wheresearchreporters=' 1   ';
  } else {  

    $wheresearchreporters='  reportingManager ='.$_SESSION['userid'].' or  reportingManager in ( select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or reportingManager in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or reportingManager in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or reportingManager in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].')))) or reportingManager in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or reportingManager in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))'; 
  }
  ?>
  <script type="text/javascript" src="js/loader.js"></script>
  <script src="js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/jquery-gauge.min.js"></script>
  <script src="js/amcharts.js"></script>
  <script src="js/funnel.js"></script>
  <script src="js/light.js"></script>
  <!-- <script src="https://www.amcharts.com/lib/3/amcharts.js"></script> -->
  <!-- <script src="https://www.amcharts.com/lib/3/serial.js"></script> -->
  <!-- <script src="https://www.amcharts.com/lib/3/themes/light.js"></script> -->
  <!-- <script src="https://www.amcharts.com/lib/3/pie.js"></script> -->
  <style>

#chartdiv {

width: 100%;

height: 237px;

}	

#chartdiv a{display:none !important;}

.demo2 {position: relative; width: 250px; height: 250px; box-sizing: border-box;    margin: 33px auto 5px; }

</style>
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="91%" align="left" valign="top"><form id="listform" name="listform" method="get">
          <style>
.sidegradi{padding:41px 0px !important;} 
.sidegradi .fa{font-size: 25px !important;} 

 

.leftuserlist {
    width: 160px;
    background-color: #233a49;
    height: 1149px;
    overflow: auto;
    border-right: 4px solid #4285f4;
}
 

.leftuserlist a {
    padding: 8px 10px;
    display: block;
    color: #FFFFFF !important;
    font-size: 12px;
    text-decoration: none;
    margin-left: 5px; 
    margin-top: 5px;
}

.leftuserlist .active { 
    background-color: #2196f363; 
}

.leftuserlist .headerm {
    padding: 10px;
    color: #fff;
    background-color: #00000061;
    font-weight: 500;
    font-size: 14px;padding-left: 15px;
}

</style>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2" align="left" valign="top"><div class="leftuserlist">
                  <div class="headerm">Users</div>
                  <a href="<?php echo $fullurl; ?>" <?php if(decode($_REQUEST['assignto'])==''){ ?>class="active"<?php } ?>>All Users</a>
                  <?php 



$select=''; 
$where=''; 
$rs='';  
$select='*';
$where=' '.$wheresearchreporters.' and status=1 and userType=0 and profileId in (select id from profileMaster where profileName="Sales") order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
                  <a href="<?php echo $fullurl; ?>?assignto=<?php echo encode($resListing['id']); ?>" <?php if(decode($_REQUEST['assignto'])==$resListing['id']){ ?>class="active"<?php } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></a>
                  <?php } ?>
                  <div class="headerm" style="margin-top: 20px;">Report</div>
                    <a href="<?php echo $fullurl; ?>showpage.crm?module=salesReport">Sales Report</a>
                    <!-- new added reported section  -->
                    <a href="<?php echo $fullurl; ?>showpage.crm?module=salesReport">Sales Report</a>
                    
                  </div>
                  
              </td>
              <td width="93%" align="left" valign="top" style="padding-left:8px;"><div class="innersecdash" style="margin-bottom:10px;">
                <div style="margin:25px 10px;border: 3px solid #2e3a44;">
  <div><h2 style="color: white;margin: 10px 5px;">TO-DO LIST</h2></div>
                  <?php include 'tableSorting.php'; ?>


<style>
 .salestodo > tbody > tr > td{
color: white!important;
} 
div.dataTables_wrapper div.dataTables_info {
    color: white!important;
}
.actionsales{
 cursor: pointer;
    color: #4e73ff;
    font-weight: 600;

}
</style>
<div id="" style="padding:10px;overflow: auto;height: 200px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered salestodo" id="mainsectiontable">

   <thead>

   <tr>

    <th align="left" class="header" style="background: #233a49;color: white;">Subject</th>

    <th align="left" class="header" style="background: #233a49;color: white;">Assign&nbsp;To</th>

    <th align="left" class="header" style="background: #233a49;color: white;">Lead&nbsp;Type</th>

    <th align="left" class="header" style="background: #233a49;color: white;">Date</th>

    <th align="left" class="header" style="background: #233a49;color: white;" >Time</th>

    <th align="left" class="header" style="background: #233a49;color: white;">Activity</th>

    <th align="left" class="header" style="background: #233a49;color: white;"></th>



   </tr>

   </thead>


  <tbody>

  <?php

 $where = 'leadsource!="" and status=1 order by fromDate desc';

$rs=GetPageRecord('*','leadManageMaster',$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];


if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left"><?php echo date('g:i A',strtotime($resultlists['starttime'])); ?></td>

    <td align="left">Lead&nbsp;Meeting</td>

    <td align="center"><div class="actionsales" onclick="alertspopupopen('action=addtodosaleaction&id=<?php echo encode($resultlists['id']);  ?>&type=lead','500px','auto');"><i class="fa fa-plus">&nbsp;</i>Action</div></td>


  </tr>

  <?php } ?>

   <?php
 $where = 'leadId!="" and status=1';
$rs=GetPageRecord('*','activityMaster',$where); 

while($resultleads=mysqli_fetch_array($rs)){ 

$rs1=GetPageRecord('*','leadManageMaster','id="'.$resultleads['leadId'].'"'); 
$resultlists=mysqli_fetch_array($rs1);


$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];


if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>

    <td align="left"><?php echo $resultleads['subject']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="left"><?php echo $lead['name']; ?></td>    

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultleads['fromDate'])) ?></td>

    <td align="left"><?php echo date('g:i A',strtotime($resultleads['starttime'])); ?></td>

    <td align="left">Lead&nbsp;<?php
    if($resultleads['activityType'] == 2){ echo 'Meeting'; }
    if($resultleads['activityType'] == 1){ echo 'Call'; }
    if($resultleads['activityType'] == 3){ echo 'Task'; }

     ?></td>
  
    <td align="center" ><div class="actionsales" onclick="alertspopupopen('action=addtodosaleaction&id=<?php echo encode($resultleads['id']);  ?>&type=activity','500px','auto');"><i class="fa fa-plus">&nbsp;</i>Action</div></td>

  </tr>

  <?php } ?>

   <?php
$where = 'leadsource!="" and status=1 and assignTo!="0"';
$rs=GetPageRecord('*',_CALLS_MASTER_,$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];

if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>
    
    <td align="left"><?php echo date('g:i A',strtotime($resultlists['starttime'])); ?></td>

    <td align="left">Normal&nbsp;Call</td>

    <td align="center"><div class="actionsales" onclick="alertspopupopen('action=addtodosaleaction&id=<?php echo encode($resultlists['id']);  ?>&type=call','500px','auto');"><i class="fa fa-plus">&nbsp;</i>Action</div></td>

  </tr>

  <?php } ?>

  <?php
$where = 'leadsource!="" and status=1 and assignTo!="0"';
$rs=GetPageRecord('*',_TASKS_MASTER_,$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];

if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>

    <td align="left"><?php echo $resultlists['subject']; ?></td>
    
    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="left"><?php echo $lead['name']; ?></td>    

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left"><?php echo date('g:i A',strtotime($resultlists['starttime'])); ?></td>

    <td align="left">Normal&nbsp;Task</td>

    <td align="center"><div class="actionsales" onclick="alertspopupopen('action=addtodosaleaction&id=<?php echo encode($resultlists['id']);  ?>&type=task','500px','auto');"><i class="fa fa-plus">&nbsp;</i>Action</div></td>

  </tr>

  <?php } ?>

  <?php
 $where = 'leadsource!="" and assignTo!="0"' ;
$rs=GetPageRecord('*',_MEETINGS_MASTER_,$where); 

while($resultlists=mysqli_fetch_array($rs)){ 

$rs2=GetPageRecord('name','leadssourceMaster','1 and id="'.$resultlists['leadsource'].'"'); 
$lead=mysqli_fetch_array($rs2);

$rs3=GetPageRecord('firstName,lastName',_USER_MASTER_,'1 and id="'.$resultlists['assignTo'].'"'); 
$resultSales=mysqli_fetch_array($rs3);
$salePerson = $resultSales['firstName'].' '.$resultSales['lastName'];

if($resultlists['clientType'] == 1){
$rs4=GetPageRecord('name','corporateMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['name'];
}
if($resultlists['clientType'] == 2){
$rs4=GetPageRecord('firstName,lastName','contactsMaster','1 and id="'.$resultlists['companyId'].'"'); 
$resultS=mysqli_fetch_array($rs4);
$agentSupp = $resultS['firstName'].' '.$resultS['lastName'];
}
?>

  <tr>

    <td align="left"><?php echo $resultlists['subject']; ?></td>

    <td  align="left"><?php echo $salePerson; ?></td>

    <td  align="left"><?php echo $lead['name']; ?></td>

    <td  align="center" valign="middle"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])) ?></td>

    <td align="left"><?php echo date('g:i A',strtotime($resultlists['starttime'])); ?></td>

    <td align="left">Normal&nbsp;Meeting</td>

    <td align="center"><div class="actionsales" onclick="alertspopupopen('action=addtodosaleaction&id=<?php echo encode($resultlists['id']);  ?>&type=meeting','500px','auto');"><i class="fa fa-plus">&nbsp;</i>Action</div></td>

  </tr>

  <?php } ?>

</tbody>
</table>
</div>
<script> 



$(document).ready(function() {

     $('#mainsectiontable').DataTable( {

        "paging":   false,

        "ordering": true,

        "info":     true,

        "searching": false,

        "order": [[ 1, 'asc' ],[ 2, 'asc' ],[ 3, 'asc' ]]



    } );

} );

</script>   

         </div>       
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="33%" align="left" valign="top" style="position:relative;"><div class="headinggrayd" style="padding:10px; background-color:#233a49; color:#fff;"><?php echo date('F'); ?> Sales Revenue</div>
                        <div style="padding:10px; background-color:#233a49; color:#fff; height:250px;">
                          <link href="css/jquery-gauge.css" type="text/css" rel="stylesheet">
                          <script type="text/javascript" src="js/jquery-gauge.min.js"></script>
                          <div class="gauge2 demo2" style="color:#fff !important;"></div>
                          <script>
	
	

        $('.demo2').gauge({

            values: {

                0 : '0%',

                25: '25%',

                50: '50%',

                75: '75%',

                100: '100%'

            },

            colors: {

                0 : '#f00',

				25 : '#ffa500',

                50: '#eefb00',

                75: '#40b700',

                100: '#40b700'

            },

            angles: [

                180,

                360

            ],

            lineWidth: 20,

            arrowWidth: 20,

            arrowColor: '#ccc',

            inset:true,



            value: <?php if($totalSales*100/$salesrevenue_target_monethvaluetotal>100){ echo '100'; } else { echo $totalSales*100/$salesrevenue_target_monethvaluetotal; } ?>

        });

    </script>
                          <div style="
                            text-align: center;
                            margin-bottom: 5px;
                            font-size: 14px;
                            position: absolute;
                            left: 0px;
                            bottom: 25px;
                            text-align: center;
                            width: 100%; color:#fff;
                        ">
                            <table border="0" align="center" cellpadding="5" cellspacing="0">
                              <tr>
                                <td colspan="2">Target: <strong style="    background-color: #bf2d2d;
                                padding: 6px 8px;
                                font-weight: 500;
                                border-radius: 5px;"><?php echo $salesrevenue_target_monethvaluetotal; ?></strong></td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>Sales: <strong  style=" 
                                background-color: #4CAF50;
                                padding: 6px 8px;
                                font-weight: 500;
                                border-radius: 5px;
                                min-width: 60px;
                                display: inline-block; "><?php echo $totalSales; ?></strong></td>
                              </tr>
                            </table>
                          </div>
                        </div></td>
                      <td width="35%" align="left" valign="top" style="padding:0px 10px;"><div class="headinggrayd" style="padding:10px; background-color:#233a49; color:#fff;">Sales Pipeline </div>
                        <div style="padding:10px; background-color:#233a49; color:#fff; height:250px;">
                          <div id="barchart_material2" style="width: 100%; height: 250px;">
                            <div class="sectioninner" style="color:#fff !important;">
                              <!-- Chart code -->
                              <script>

                            var chart = AmCharts.makeChart( "chartdiv", {

                              "type": "funnel",

                              "theme": "light",

                              "dataProvider": [ {

                                "title": "Assigned",

                                "value": <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=1 and deletestatus=0 and companyId in (select id from corporateMaster where assignTo="'.decode($_GET['assignto']).'") or companyId in (select id from 	contactsMaster where assignTo="'.decode($_GET['assignto']).'") ' ); ?>

                              }, {

                                "title": "Reverted",

                                "value": <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=2 and deletestatus=0 and companyId in (select id from corporateMaster where assignTo="'.decode($_GET['assignto']).'") or companyId in (select id from 	contactsMaster where assignTo="'.decode($_GET['assignto']).'") ' ); ?>

                              }, {

                                "title": "Option Sent",

                                "value": <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=6 and deletestatus=0 and companyId in (select id from corporateMaster where assignTo="'.decode($_GET['assignto']).'") or companyId in (select id from 	contactsMaster where assignTo="'.decode($_GET['assignto']).'") ' ); ?>

                              }, {

                                "title": "Follow-up",

                                "value": <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=7 and deletestatus=0 and companyId in (select id from corporateMaster where assignTo="'.decode($_GET['assignto']).'") or companyId in (select id from 	contactsMaster where assignTo="'.decode($_GET['assignto']).'") ' ); ?>

                              }, {

                                "title": "Confirmed",

                                "value": <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=3 and deletestatus=0 and companyId in (select id from corporateMaster where assignTo="'.decode($_GET['assignto']).'") or companyId in (select id from 	contactsMaster where assignTo="'.decode($_GET['assignto']).'") ' ); ?>

                              } ],

                              "balloon": {

                                "fixedPosition": true

                              },

                              "valueField": "value",

                              "titleField": "title",

                              "marginRight": 200,

                              "marginLeft": 3,

                              "startX": -100,

                              "depth3D": 100,

                              "angle": 20,

                              "outlineAlpha": 1,

                              "outlineColor": "#233a49",

                              "outlineThickness": 2,

                              "labelPosition": "right",

                              "balloonText": "[[title]]: [[value]]n[[description]]",

                              "export": {

                                "enabled": false

                              }

                            } );

                            </script>
                            <!-- HTML -->
                            <style>
                            #chartdiv text{fill:#fff !important;}
                            </style>
                            <div id="chartdiv" style="color:#ffffff !important;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td width="32%" align="left" valign="top"><div class="headinggrayd" style="padding:10px; background-color:#233a49; color:#fff;">Top Query Destination Wise</div>
                        <div style="padding:10px; background-color:#233a49; height:250px;">
                          <script src="https://code.highcharts.com/highcharts.js"></script>
                          <script src="https://code.highcharts.com/highcharts-3d.js"></script>
                          <style>
                          	#salesgraphmainbox{width:100%; height:250px !important;}
                          	#salesgraphmainbox a{display:none !important;}
                          	#topdestination{height:250px !important; max-height:250px; overflow:hidden;}
                          	#topdestination a{display:none !important;}
                          	.highcharts-credits{display:none !important;}
                          	</style>
                            <div id="topdestination"></div>
                            <style>
                            rect {fill:#233a49 !important;}
                            </style>
                        <script>
                          Highcharts.chart('topdestination', {
                            chart: {
                              type: 'pie',
                              options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                              }
                            },
                            title: {
                              text: ''
                            },
                            tooltip: {
                              pointFormat: '{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                              pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 35,
                                dataLabels: {
                                  enabled: true,
                                  format: '{point.name}'
                                }
                              }
                            },
                            series: [{
                              type: 'pie',
                              name: ' ',
                              data: [
                                  <?php
                                  $menu10=mysqli_query(db(),"select cityId, count(cityId) as cntd from packageQueryDays where queryId in (select id from "._QUERY_MASTER_." where ".$wheresearchassign."  ) and cityId in (select id from "._DESTINATION_MASTER_." where name!='') group by cityId order by cntd desc limit 0,5"); 
                                  while($rest10=mysqli_fetch_array($menu10)){ 
                                    $select4='name';  
                                    $where4='id="'.$rest10['cityId'].'" '; 
                                    $rs4=GetPageRecord($select4,_DESTINATION_MASTER_,$where4); 
                                    $result=mysqli_fetch_array($rs4);  
                                    if($result['name']!=''){
                                    ?>
                                    ['<?php echo $result['name']; ?>', <?php echo round($rest10['cntd']); ?>], 
                                    <?php } 
                                  } ?>
                              ]
                            }]
                          });
                          </script>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
         <div>

                <style>
.pipeborderright{border-right: 1px #ccc5c56b solid;} 
.pipeheadingbox {
padding: 10px;
color: #FFFFFF;
font-weight: 500;
width: 100%;
box-sizing: border-box;
font-size: 14px;
} 
.pipequerybox:hover{background-color:#F8F8F8;}
.pipequerybox{padding:10px; background-color:#FFFFFF; border-bottom:1px #ccc5c56b solid;}
.pipequerybox .qtitle{font-size:13px; font-weight:500; color:#333333; margin-bottom:5px;text-overflow: ellipsis; overflow:hidden;white-space: nowrap; max-width:150px;}
.pipequerybox .qouter{overflow:hidden;}
.pipequerybox .qamount{max-width:30%; padding-right:5px; font-size:12px; color:#999999; float:left;text-overflow: ellipsis; overflow:hidden;white-space: nowrap;}
.pipequerybox .qcompanyname{max-width:65%; font-size:12px; color:#999999; float:left;text-overflow: ellipsis; overflow:hidden;white-space: nowrap;}
 
</style>
                <div class="innersecdash" style="margin-bottom: 10px; background-color: #fff; margin-top: 10px;">
                  <div class="innersecdash" style="margin-bottom:10px;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="75%" align="left" valign="top" style="padding:0px 10px;"><div style="padding:10px; background-color:#FFFFFF;">
                            <div id="barchart_material2" style="width: 100%;">
                              <div class="sectioninner">
                                <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="c58f29">
                                  <?php 
			$select=''; 
			$where=''; 
			$rs='';  
			$select='*';   
			if(decode($_REQUEST['assignto'])!=''){
			$assignquerypipeline=' and assign_to="'.decode($_REQUEST['assignto']).'" ';
			}
			$where=' 1 '.$assignquerypipeline.' group by year asc'; 
			$rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
			  
			while($assignlist=mysqli_fetch_array($rs)){  
		 ?>
                                  <tr>
                                    <td align="left" bgcolor="#c58f29"><h3>Status</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>Year</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>January</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>February</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>March</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>April</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>May</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>June</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>July</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>August</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>September</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>October</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>November</h3></td>
                                    <td align="center" bgcolor="#c58f29"><h3>December</h3></td>
                                  </tr>
                                  <tr style="background-color: #b9f7a0;">
                                    <td align="left"><h3>Target</h3></td>
                                    <td align="center"><?php echo strip($assignlist['year']); ?></td>
                                    <td align="center"><?php echo $january=strip($assignlist['January']); ?></td>
                                    <td align="center"><?php echo $February=strip($assignlist['February']); ?></td>
                                    <td align="center"><?php echo $March=strip($assignlist['March']); ?></td>
                                    <td align="center"><?php echo $April=strip($assignlist['April']); ?></td>
                                    <td align="center"><?php echo $May=strip($assignlist['May']); ?></td>
                                    <td align="center"><?php echo $June=strip($assignlist['June']); ?></td>
                                    <td align="center"><?php echo $July=strip($assignlist['July']); ?></td>
                                    <td align="center"><?php echo $August=strip($assignlist['August']); ?></td>
                                    <td align="center"><?php echo $September=strip($assignlist['September']); ?></td>
                                    <td align="center"><?php echo $October=strip($assignlist['October']); ?></td>
                                    <td align="center"><?php echo $November=strip($assignlist['November']); ?></td>
                                    <td align="center"><?php echo $December=strip($assignlist['December']); ?></td>
                                  </tr>
                                  <tr style="background-color: #fffda8;">
                                    <td align="left"><h3>Achieved</h3></td>
                                    <td align="center"><?php echo strip($assignlist['year']); ?></td>
                                    <?php
	$nowYear=strip($assignlist['year']);
	$nowMonth=1;
	$totalSalescor=0;
    $totalSalesQuery1=0;
	$totalSalesd=0;
	$totalSalesdq=0;
	$totalAmountramayanaAchived=0;
for($i=1; $i<=$nowMonth; $i++){	
if($nowMonth!='' && $nowMonth<=12){ 
$totalSalesQuery1=0;
$totalSalesdq=0;
$totalSalescor=0;
$reQuery = "select  SUM(amount) as totalAdmin from invoiceMaster where queryId in (SELECT id FROM  queryMaster WHERE MONTH(toDate) = ".$nowMonth." AND YEAR(toDate) = ".$nowYear." and assignTo='".decode($getassito1)."' and deletestatus=0 ) "; 
$rsdQuery=mysqli_query(db(),$reQuery);
 $resultSdQuery=mysqli_fetch_array($rsdQuery);
$totalSalesQuery1=$totalSalesQuery1+$resultSdQuery['totalAdmin']; 
 
$resu = "select SUM(amount) as totalSalesperson from invoiceMaster where queryId in (SELECT id FROM  queryMaster WHERE MONTH(toDate) = ".$nowMonth."  AND YEAR(toDate) = ".$nowYear." and deletestatus=0  and companyId in (select id from corporateMaster where assignTo='".decode($getassito1)."' and deletestatus=0 ) ) "; 
$rsdsu=mysqli_query(db(),$resu);
$resultcorp=mysqli_fetch_array($rsdsu);
$totalSalescor=$totalSalescor+$resultcorp['totalSalesperson'];  
 
$totalSalesdq=$totalSalesQuery1+$totalSalescor;
?>
                                    <td align="center"><?php echo $totalSalesdq;  ?></td>
                                    <?php
 $nowMonth++; $totalSalesd=0; 
 }   }
  ?>
                                  </tr>
                                  <tr style="background-color: #ffbfa8;">
                                    <td align="left"><h3>Unachieved</h3></td>
                                    <td align="center"><?php echo strip($assignlist['year']); ?></td>
                                    <?php
$nowYear=strip($assignlist['year']);
$nowMonth=1; 
$totalSalesQ=0;
$totalSal=0;
$totalSalesd=0;
for($i=1; $i<=$nowMonth; $i++){	
if($nowMonth!='' && $nowMonth<=12){
$totalSalesQ=0;
$totalSal=0;
$totalSalesd=0;
$reQuery1 = "select  SUM(amount) as totalAdmin from invoiceMaster where queryId in (SELECT id FROM  queryMaster WHERE MONTH(toDate) = ".$nowMonth." AND YEAR(toDate) = ".$nowYear." and assignTo='".decode($getassito1)."' and deletestatus=0 ) "; 
$rsdQuery1=mysqli_query(db(),$reQuery1);
 $resultSdQuery1=mysqli_fetch_array($rsdQuery1);
$totalSalesQ=$totalSalesQ+$resultSdQuery1['totalAdmin']; 
 
$resu1 = "select SUM(amount) as totalSalesperson from invoiceMaster where queryId in (SELECT id FROM  queryMaster WHERE MONTH(toDate) = ".$nowMonth."  AND YEAR(toDate) = ".$nowYear." and deletestatus=0  and companyId in (select id from corporateMaster where assignTo='".decode($getassito1)."' and deletestatus=0 ) ) "; 
$rsdsu1=mysqli_query(db(),$resu1);
$resultcorp1=mysqli_fetch_array($rsdsu1);
$totalSal=$totalSal+$resultcorp1['totalSalesperson'];  
 
$totalSalesd=$totalSalesQ+$totalSal;
?>
                                    <?php if($i==1){?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['January']); ?></td>
                                    <?php }elseif($i==2){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['February']); ?></td>
                                    <?php }elseif($i==3){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['March']); ?></td>
                                    <?php }elseif($i==4){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['April']); ?></td>
                                    <?php }elseif($i==5){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['May']); ?></td>
                                    <?php }elseif($i==6){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['June']); ?></td>
                                    <?php }elseif($i==7){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['July']); ?></td>
                                    <?php }elseif($i==8){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['August']); ?></td>
                                    <?php }elseif($i==9){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['September']); ?></td>
                                    <?php }elseif($i==10){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['October']); ?></td>
                                    <?php }elseif($i==11){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['November']); ?></td>
                                    <?php }elseif($i==12){ ?>
                                    <td align="center"><?php echo $totalSalesd-strip($assignlist['December']); ?></td>
                                    <?php } ?>
                                    <?php
 $nowMonth++; $totalSalesd=0;
 }  }
  ?>
                                  </tr>
                                  <tr>
                                    <td colspan="14" align="left">&nbsp;</td>
                                  </tr>
                                  <?php } ?>
                                </table>
                              </div>
                            </div>
                          </div></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div id="pagelisterouter" style="padding-right: 0px; padding-left: 0px; padding-top: 15px; background-color: white; max-height: 400px; overflow-y: auto;">
                  <div style="    margin-top: -10px;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="min-height:500px;">
                      <tr>
                        <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#2ca1cc;">Assigned (20%) </div>
                          <?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=1 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
                          <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank">
                          <div class="pipequerybox" title="<?php echo clean($resquery['subject']); ?>">
                            <div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
                            <div class="qouter">
                              <?php if($resquery['expectedSales']!=''){ ?>
                              <div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div>
                              <?php } ?>
                              <div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
                            </div>
                          </div>
                          </a>
                          <?php } ?>
                        </td>
                        <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#FF6600">Reverted (40%) </div>
                          <?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=2 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
                          <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>">
                          <div class="pipequerybox">
                            <div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
                            <div class="qouter">
                              <?php if($resquery['expectedSales']!=''){ ?>
                              <div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div>
                              <?php } ?>
                              <div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
                            </div>
                          </div>
                          </a>
                          <?php } ?>
                        </td>
                        <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#ff9800;">Option Sent (60%) </div>
                          <?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=6 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
                          <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>">
                          <div class="pipequerybox">
                            <div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
                            <div class="qouter">
                              <?php if($resquery['expectedSales']!=''){ ?>
                              <div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div>
                              <?php } ?>
                              <div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
                            </div>
                          </div>
                          </a>
                          <?php } ?>
                        </td>
                        <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#ffc107;">Follow-up (80%) </div>
                          <?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=7 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
                          <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>">
                          <div class="pipequerybox">
                            <div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
                            <div class="qouter">
                              <?php if($resquery['expectedSales']!=''){ ?>
                              <div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div>
                              <?php } ?>
                              <div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
                            </div>
                          </div>
                          </a>
                          <?php } ?>
                        </td>
                        <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#82b767;">Confirmed (100%) </div>
                          <?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=3 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
                          <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>">
                          <div class="pipequerybox">
                            <div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
                            <div class="qouter">
                              <?php if($resquery['expectedSales']!=''){ ?>
                              <div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div>
                              <?php } ?>
                              <div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
                            </div>
                          </div>
                          </a>
                          <?php } ?></td>
                        <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#c75858;">Query Lost (0%) </div>
                          <?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=4 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
                          <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>">
                          <div class="pipequerybox">
                            <div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
                            <div class="qouter">
                              <?php if($resquery['expectedSales']!=''){ ?>
                              <div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div>
                              <?php } ?>
                              <div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
                            </div>
                          </div>
                          </a>
                          <?php } ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <style>
#querydatamain text{fill:#fff !important;}
</style>
              </td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
  <style>
body {
    background-color: #192631 !important;
    height: auto !important;
}

.dashboardmainbox .headinggrayd {
    font-size: 18px;
    text-transform: uppercase;
    padding: 15px;
    border-bottom: 0px #e6e5e5 solid;
    text-align: center !important;
    font-size: 16px;
    color: #fff;
}
</style>
  <?php } ?>
  <?php if($userRemainingDays<15){ ?>
  <div style="

      padding: 6px 15px;

    background-color: #e90000;

    margin-bottom: 20px;

    color: #fff;

    font-size: 15px;

    border-radius: 0px;

    position: absolute;

    top: 55px;

    right: 0px;

">Your subscription is getting expired in <?php echo $userRemainingDays; ?> days</div>
  <?php } ?>
</div>
<?php require "footerinclude.php"; ?>
<style>

.sidegradi3{/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#00617c+0,233a49+100 */

background: #00617c; /* Old browsers */

background: -moz-linear-gradient(-45deg, #00617c 0%, #233a49 100%); /* FF3.6-15 */

background: -webkit-linear-gradient(-45deg, #00617c 0%,#233a49 100%); /* Chrome10-25,Safari5.1-6 */

background: linear-gradient(135deg, #00617c 0%,#233a49 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00617c', endColorstr='#233a49',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */}

.amcharts-chart-div tspan{color:#fff; fill:#fff;}
 
.tblheader {

    background-color: #ffffff17 !important; 

}


 
html{height:auto !important;}



.micbox { 

    box-shadow: 0px 6px 15px #000 !important; 

}

.dashquerytb:hover{background-color: #171717 !important; cursor:pointer; }

.dashquerytb .fa{    font-size: 30px !important;}





</style>
<script>
var PendingMail222 = Number($('#PendingMail222').text());
if(PendingMail222>0){
} else {
$('#PendingMail222').text('0');
}
</script>
</body>
</html>














