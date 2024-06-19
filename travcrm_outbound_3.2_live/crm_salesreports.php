<?php 

function getaddress($lat,$lng){
if(!empty($lat) && !empty($lng)){ 
$geocodeFromLatLong = url_get_contents('https://apis.mapmyindia.com/advancedmaps/v1/dw8yunoqep5eukoo4z39qenyv3653qwg/rev_geocode?lat='.trim($lat).'&lng='.trim($lng).'');
$output = json_decode($geocodeFromLatLong);
$status = $output->responseCode;
//Get address from json data
$address = ($status==200)?$output->results[0]->formatted_address:'';
//Return address of the given latitude and longitude
if(!empty($address)){
return $address;
}else{
return false;
}
}else{
return false;  
}
}



if($loginuserprofileId==1){ 
    $wheresearchassign=' 1   ';
} else {   
	$wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
	
	or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';  
	$wheresearchassign=' ( '.$wheresearchassign.' or id = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
} 



$year=date('Y');
$monthName=date('F');
$thismonth=date('m');

if($_GET['assignto']!=''){  
    $whereQuery=''; 
    $whereQuery=' and  assignTo='.decode($_GET['assignto']).''; 
    $whereQuery222=' and  assign_to='.decode($_GET['assignto']).''; 
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


    

function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}





  
 ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-gauge.min.js"></script> 
<script src="js/amcharts.js"></script> 
<script src="js/funnel.js"></script>   
<script src="js/light.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>  
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>   

<style>

#chartdiv {

width: 100%;

height: 237px;

}	

#chartdiv a{display:none !important;}

.demo2 {position: relative; width: 250px; height: 250px; box-sizing: border-box;    margin: 33px auto 5px; }

</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	  <form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px; padding-right:0px; padding-left:0px;    padding-top: 60px;">
 <div class="dashboardmainbox" style="background-color: #192631; margin-top: -4px;    padding: 8px;">
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
<a href="showpage.crm?module=salesreports" <?php if(decode($_REQUEST['assignto'])==''){ ?>class="active"<?php } ?>>All Users</a>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' '.$wheresearchassign.'  and status=1 and userType=0 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?><a href="showpage.crm?module=salesreports&assignto=<?php echo encode($resListing['id']); ?>" <?php if(decode($_REQUEST['assignto'])==$resListing['id']){ ?>class="active"<?php } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></a>
			 
			<?php } ?>

</div></td>
    <td width="93%" align="left" valign="top" style="padding-left:8px;">
 
<div class="innersecdash" style="margin-bottom:10px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="33%" align="left" valign="top" style="position:relative;">
	  <div class="headinggrayd" style="padding:10px; background-color:#233a49; color:#fff;"><?php echo date('F'); ?> Sales Revenue</div> 
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
"><table border="0" align="center" cellpadding="5" cellspacing="0">
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
	  
 
	  <div id="barchart_material2" style="width: 100%; height: 250px;"><div class="sectioninner" style="color:#fff !important;">

          



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

          </div></div>
	  </div> </td>
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
    ['Dubai', 40],  
    ['India', 50], 
	['Thailand',30],
	['Bali',25] , 
    ]
  }]
});
</script>
	   
	   
	  
	    
	  </div>  </td>
      </tr>
  </table>
</div>

<div class="innersecdash" style="margin-bottom:10px; background-color:#fff">
   <div class="innersecdash" style="margin-bottom:10px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
       
      <td width="75%" align="left" valign="top" style="padding:0px 10px;">   
	    <div style="padding:10px; background-color:#FFFFFF;">
	  
	   
	  <div id="barchart_material2" style="width: 100%;"><div class="sectioninner">
          
		<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="c58f29">
		<?php
			if(decode($_REQUEST['assignto'])!=''){
			$select=''; 
			$where=''; 
			$rs='';  
			$select='*';   
			 $where=' assign_to='.decode($_REQUEST['assignto']).' group by year asc'; 
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
?> <?php if($i==1){?>
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
  <?php } } ?>
</table>
          </div></div>
	  </div> </td>
      </tr>
  </table>
</div>
</div>

<div class="innersecdash" style="margin-bottom:10px;">
 <div style="background-color:#233a49;  "><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><iframe name="mapframe" id="mapframe" frameborder="0" scrolling="no" src="map_currentlocation.php?userid=<?php echo decode($_REQUEST['assignto']); ?>" style="width:100%; height:500px;" ></iframe></td>
    <td width="1" align="left" valign="top" bgcolor="#192631" style="width:8px;"></td>
    <td width="750" align="left" valign="top">

<script>

google.charts.load('current', {'packages':['corechart','bar']});

google.charts.setOnLoadCallback(drawChart);  

google.charts.setOnLoadCallback(drawChart2);  

google.charts.setOnLoadCallback(drawChart3);  



 

      function drawChart() {

        var data = google.visualization.arrayToDataTable([

          ['Month', 'Achievement', 'Deal Lost'],

          ['<?php echo date('F'); ?>', <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=3 and deletestatus=0 '.$whereQuery.' ' ); ?>, <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=4 and deletestatus=0 '.$whereQuery.' ' ); ?>] 

        ]);



        var options = {

          chart: { 

          }

        };



        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));



        chart.draw(data, options);

      }
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
      function drawChart2() { 

        var data = google.visualization.arrayToDataTable([

          ['Destination', 'Sales'],
 
<?php
$menu2=mysqli_query(db(),"select * from "._QUERY_MASTER_." where   deletestatus=0  ".$whereQuery." group by destinationId "); 
while($rest2=mysqli_fetch_array($menu2)){ 
?>
          ['<?php echo getDestination($rest2['destinationId']); ?>',     <?php echo countlisting('id',_QUERY_MASTER_,'where  deletestatus=0 and destinationId='.$rest2['destinationId'].' '.$whereQuery.' ' ); ?>],  
	<?php } ?>	  

		  

        ]);

		

		

		

		

		



       var options = { chartArea:{

    left:5,

    right:5, // !!! works !!!

    bottom:0,  // !!! works !!!

    top:5,

    width:"330px",

    height:"100%"

  }

}



        var chart = new google.visualization.PieChart(document.getElementById('piechart'));



        chart.draw(data, options);

      }	
	  
	  
	  
	  
	  
	  function drawChart3() {



        var data = google.visualization.arrayToDataTable([

          ['Destination', 'Sales'], 
		  

		  
<?php
$menu2=mysqli_query(db(),"select * from "._QUERY_MASTER_." where  queryStatus=3 and deletestatus=0  ".$whereQuery." group by destinationId "); 
while($rest2=mysqli_fetch_array($menu2)){ 
?>
          ['<?php echo getDestination($rest2['destinationId']); ?>',     <?php echo countlisting('id',_QUERY_MASTER_,'where queryStatus=3 and deletestatus=0 and destinationId='.$rest2['destinationId'].' '.$whereQuery.' ' ); ?>],  
	<?php } ?>	  

		   

        ]);



       var options = { chartArea:{

    left:5,

    right:5, // !!! works !!!

    bottom:0,  // !!! works !!!

    top:5,

    width:"330px",

    height:"100%"

  }

}



        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));



        chart.draw(data, options);

      }  
</script>

 <?php /*?><div style="padding:10px;">
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF"  >
  <tr>
    <td bgcolor="#F4F4F4"><strong>Check-In Time</strong></td>
    <td bgcolor="#F4F4F4"><strong>Meeting Time</strong></td>
    <td bgcolor="#F4F4F4"><strong>Meeting Subject</strong></td>
    <td bgcolor="#F4F4F4"><strong>Agent</strong></td>
    <td bgcolor="#F4F4F4"><strong>Client Address</strong></td>
    <td bgcolor="#F4F4F4"><strong>Check-in Address</strong></td>
  </tr>
<?php 
$sql5="select * from  "._MEETINGS_MASTER_." where  lat!='' and lon!='' and assignTo=".decode($_REQUEST['assignto'])."  order by dateAdded desc";
$res5 = mysqli_query(db(),$sql5);
$num5=mysqli_num_rows($res5); 


$newmember1=mysqli_query(db(),"select * from  "._MEETINGS_MASTER_." where  lat!='' and lon!=''  and assignTo=".decode($_REQUEST['assignto'])."  order by id desc");
while($res_mapposition=mysqli_fetch_array($newmember1)){ 
?> <tr>
    <td bgcolor="#FFFFFF"><?php echo showdatetime($res_mapposition['dateAdded'],$loginusertimeFormat);?></td>
    <td bgcolor="#FFFFFF"><?php echo showdate($res_mapposition['fromDate']); ?>, &nbsp;<?php echo  ($res_mapposition['starttime']); ?></td>
    <td bgcolor="#FFFFFF"><strong><?php echo $res_mapposition['subject']; ?></strong></td>
    <td bgcolor="#FFFFFF"><?php echo showClientTypeUserNameWithLink($res_mapposition['clientType'],$res_mapposition['companyId']); ?></td>
    <td bgcolor="#FFFFFF"><?php if($res_mapposition['clientType']==2){ 
	$select1='*';  
$where1='id='.$res_mapposition['companyId'].''; 
$rs1=GetPageRecord($select1,_CONTACT_MASTER_,$where1); 
$editresult2=mysqli_fetch_array($rs1);
	echo strip($editresult2['address1']).' '.strip($editresult2['address2']).' '.strip($editresult2['address3']);
	 } else { 
	 
	 	$select1='*';  
$where1=' addressType="corporate" and addressParent='.$res_mapposition['companyId'].' '; 
$rs1=GetPageRecord($select1,_ADDRESS_MASTER_,$where1); 
$editresult2=mysqli_fetch_array($rs1);
	 echo $editresult2['address'].'  '.getCityName($editresult2['cityId']).', '.getStateName($editresult2['stateId']).', '.getCountryName($editresult2['countryId']).' '.$editresult2['pinCode']; 
	 }
	
	 ?></td>
    <td bgcolor="#FFFFFF"> 
	 <?php
	 
	 echo getaddress($res_mapposition['lat'],$res_mapposition['lon']);
	  
	 
?></td>
 </tr><?php } ?>
</table>
</div><?php */?>
</td>
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

</div>
 

 
</div></form>	</td>
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
