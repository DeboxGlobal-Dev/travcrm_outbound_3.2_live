<?php  
include "inc.php"; 
include "config/logincheck.php";

$userid=$_REQUEST['userid'];
$startdate=$_REQUEST['startdate'];
$enddate=$_REQUEST['enddate'];
 
 ?>
<link href="css/main.css" rel="stylesheet" type="text/css">
<!--<meta http-equiv="Refresh" content="60"> -->
<style>
body{background-color:#FFFFFF !important;}
</style>
<script src="js/jquery-1.11.3.min.js"></script>  
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIzPNnqrSSr0KgNV62Ltj3ehMdZN3UfUs">
    </script>

<script>

var berlin = new google.maps.LatLng(28.38,77.12);

var neighborhoods = [




<?php 
$sql5="select * from  "._MEETINGS_MASTER_." where  lat!='' and lon!='' and assignTo=".$userid."  order by id desc";
$res5 = mysqli_query(db(),$sql5);
$num5=mysqli_num_rows($res5); 


$newmember1=mysqli_query(db(),"select * from  "._MEETINGS_MASTER_." where  lat!='' and lon!=''  and assignTo=".$userid."  order by id desc");
while($res_mapposition=mysqli_fetch_array($newmember1)){ 
?>

new google.maps.LatLng(<?php echo $res_mapposition['lat']; ?>,<?php echo $res_mapposition['lon']; ?>)<?php if($n!=$num5){ echo  ','; } ?>	

<?php   } ?>




];

var neighborhoods2 = [

<?php 
$newmember2=mysqli_query(db(),"select * from  "._MEETINGS_MASTER_." where  lat!='' and lon!=''  and assignTo=".$userid."  order by id desc");
while($customer=mysqli_fetch_array($newmember2)){ 

?>
'<table width="226" style="font-size:12px;"><tr><td width="215" align="left" valign="top"><strong style="font-size:15px;"><?php echo $customer['subject']; ?></strong><div style="margin-top:3px;"><?php echo showdate($customer['fromDate']); ?>, &nbsp;<?php echo  ($customer['starttime']); ?></div></td></tr><tr><td colspan="2" align="left" valign="top"  ><div style="border-top:1px #CCCCCC solid; padding-top:10px;">Related: <?php echo showClientTypeUserNameWithLink($customer['clientType'],$customer['companyId']); ?></div></td></tr></table>',<?php } ?>
];






var neighborhoods3 = [
<?php 
$newmember3=mysqli_query(db(),"select * from  "._MEETINGS_MASTER_." where  lat!='' and lon!=''  and assignTo=".$userid."  order by id desc");
while($res_maplink=mysqli_fetch_array($newmember3)){
?>  '#',	<?php } ?>






];

var markers = [];
var iterator = 0;

var map;

function initialize() {
var mapOptions = {
zoom: 10,
mapTypeId: google.maps.MapTypeId.ROADMAP,
center: berlin
};

map = new google.maps.Map(document.getElementById('map-canvas'),
mapOptions);
}

function drop() {
for (var i = 0; i < neighborhoods.length; i++) {
setTimeout(function() {
addMarker();
}, i * 200);
}
}

function addMarker() {

var iconBase = '<?php echo $fullurl; ?>images/';

var marker =new google.maps.Marker({
position: neighborhoods[iterator],
map: map,
icon: iconBase + 'schools_maps.png',

draggable: false,
url: neighborhoods3[iterator],
animation: google.maps.Animation.DROP
})



marker.info = new google.maps.InfoWindow({
content: neighborhoods2[iterator],
});

google.maps.event.addListener(marker, 'mouseover', function() {
marker.info.open(map, marker);
});

google.maps.event.addListener(marker, 'mouseout', function() {
marker.info.close();
});

////alert(iterator);
////alert(neighborhoods3[iterator]);
google.maps.event.addListener(marker, 'click', function() {
////alert(this.url);
///alert("hello "+this.url);
lightbox(this.url);
});

markers.push(marker);

iterator++;
}

google.maps.event.addDomListener(window, 'load', initialize);

setInterval(function() {
$("#map-canvas").css('position','static');
parent.$("#mapframe").css('width','100%');
}, 1000);


setTimeout(function(){
parent.$("#mapframe").css('width','99%');
  },1000);

</script>




 
		
<body onLoad="drop();"> 
<div id="map-canvas" style="position: static !important;"></div>

 
</body>		
		