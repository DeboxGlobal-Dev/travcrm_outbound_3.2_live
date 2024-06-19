<?php

if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} 
$searchField=clean($_GET['searchField']);
?>
<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9%" align="left" valign="top" class="leftsettingmenutd"><div class="leftsettingmenu">
	<h2><?php echo $pageName; ?></h2>
	<div id="">
	<div class="mainbox">
	 
	<div class="linkbox" id="op1" > 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<form id="listform" name="listform" method="get" action="showpage.crm">
	<input type="hidden" name="module" value="attendance">
	<td>
	<div class="griddiv"><label>
	<input name="searchField" type="text"  class="topsearchfiledmain"  id="searchField"  value="<?php echo $searchField; ?>"
	placeholder="Employee Id" onkeyup="numericFilter(this);"/ style="width:150px;">
	<label/>
	</div>
	</td>
	</tr>
	
	<tr>
	<td>
	<div class="griddiv" style="margin-top:15px;"><label>
	<input type="submit" name="Submit"  value="Search" class="searchbtnmain" />
	<label/>
	</div>
	</td>
	</form>
	</tr>
	</table>
  </div>
	
	</div>
	</div>
	</div>
	</td>
	
	
    <td width="91%" align="left" valign="top">
	 <div id="pagelisterouter" style="padding-top: 50px;">
	 <div id="calendar" style="margin-top: 65px; padding: 20px;"></div>
	</div>
	</td>
  </tr>
</table>
 



  <script type="text/javascript" src="js/jscolor.js"></script> 	
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script> 

<!-- Page specific script -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
		
		
 
		
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : [ 
		 
		<?php
$select=''; 
$where=''; 
$rs='';  
$select='*';  
$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';
if($searchField!=''){
$mainwhere=' and  empId='.$searchField.'';
$where='deletestatus=0 '.$mainwhere.' order by id asc';
$targetpage=$fullurl.'showpage.crm?module=attendance&searchField='.$searchField.'&';
$rs=GetPageRecord($select,_ATTANDANCE_MASTER_,$where,$targetpage);
while($calldata=mysqli_fetch_array($rs)){  
?> {
          title          : '<?php if($calldata['empId']!=''){ echo "Present"; }else{ echo 'title'; }?>',
		  start          : '<?php  if($calldata['currentDate']!=''){ echo $calldata['currentDate']; }else{ echo 'start'; } ?>',
          allDay         : false,
		  //url            : 'callme("<?php echo encode($calldata['id']); ?>","call");',
		  backgroundColor: '#0c9f62', //Success (green)
          borderColor    : '#0c9f62' //Success (green)
        },
		<?php }
}
		?>
      ],
      
	  
	})

  })

 </script>
  
 <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>  
<style>
.fc-day-grid-event { 
    color: #fff !important;
    padding: 6px;
    font-size: 12px;
    font-weight: 400;
}
.fc-time{color:#fff !important;}
.fc-title{color:#fff !important;}
</style>	
	
	