<?php

if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

$wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 
?>

<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">

 <div id="calendar" style="margin-top: 65px; padding: 20px;"></div>



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
if($_SESSION['userid']!='37'){  
$where=''.$wheresearchassign.' order by id asc';  
} else { 
$where=' 1 order by id asc';  
}
$rs=GetPageRecord($select,_CALLS_MASTER_,$where); 
while($calldata=mysqli_fetch_array($rs)){   
?> {
          title          : '<?php echo strip($calldata['subject']); ?>',
          start          : '<?php  echo date('Y-m-d H:i:s',strtotime($calldata['fromDate'].' '.$calldata['starttime'])); ?>',
          end            : '<?php  echo date('Y-m-d H:i:s',strtotime($calldata['fromDate'].' '.$calldata['starttime'])); ?>',
          allDay         : false,
		  url            : 'callme("<?php echo encode($calldata['id']); ?>","call");',
          backgroundColor: '#0c9f62', //Success (green)
          borderColor    : '#0c9f62' //Success (green)
        },
		<?php } ?>
		
		
		<?php  
$select=''; 
$where=''; 
$rs='';  
$select='*';  
if($_SESSION['userid']!='37'){  
$where=''.$wheresearchassign.'  order by id asc';  
} else { 
$where=' 1 order by id asc';  
}
$rs=GetPageRecord($select,_MEETINGS_MASTER_,$where); 
while($calldata=mysqli_fetch_array($rs)){   
?> {
          title          : '<?php echo strip($calldata['subject']); ?>',
          start          : '<?php  echo date('Y-m-d H:i:s',strtotime($calldata['fromDate'].' '.$calldata['starttime'])); ?>',
          end            : '<?php  echo date('Y-m-d H:i:s',strtotime($calldata['fromDate'].' '.$calldata['starttime'])); ?>',
          allDay         : false,
		  url            : 'callme("<?php echo encode($calldata['id']); ?>","meeting");',
          backgroundColor: '#ff6600', //Success (green)
          borderColor    : '#ff6600' //Success (green)
        },
		<?php } ?>
		
		
		<?php  
$select=''; 
$where=''; 
$rs='';  
$select='*';  
if($_SESSION['userid']!='37'){  
$where=''.$wheresearchassign.'  order by id asc';  
} else { 
$where=' 1 order by id asc';  
}
$rs=GetPageRecord($select,_TASKS_MASTER_,$where); 
while($calldata=mysqli_fetch_array($rs)){   
?> {
          title          : '<?php echo strip($calldata['subject']); ?>',
          start          : '<?php  echo date('Y-m-d H:i:s',strtotime($calldata['fromDate'].' '.$calldata['starttime'])); ?>',
          end            : '<?php  echo date('Y-m-d H:i:s',strtotime($calldata['fromDate'].' '.$calldata['starttime'])); ?>',
          allDay         : false,
		  url            : 'callme("<?php echo encode($calldata['id']); ?>","task");',
          backgroundColor: '#3399ff', //Success (green)
          borderColor    : '#3399ff' //Success (green)
        },
		<?php } ?>
		
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
       // $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
	  
	  
	  
	  
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
  
 


$(document).on('click',function(e) { 
  $this = $(e.target);
 if (typeof $this.attr('data-date') === "undefined") {} else {
    var mid= $this.attr('data-date');  
	//alertspopupopen('action=addevent&adddate='+mid+'','600px','auto');
	}
});

function callme(id,type){

if(id!='' && type=='call'){ 
window.open('showpage.crm?module=calls&view=yes&id='+id+'','_blank'); 
}

if(id!='' && type=='meeting'){ 
window.open('showpage.crm?module=meetings&view=yes&id='+id+'','_blank'); 
}

if(id!='' && type=='task'){ 
window.open('showpage.crm?module=tasks&view=yes&id='+id+'','_blank'); 
}

}
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
	
	