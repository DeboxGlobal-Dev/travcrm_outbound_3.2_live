<?php
include "inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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

<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

<style>
    #tableBox{
        margin: 50px 10px 10px 10px;

    }
    .tableHead tr th{
            background-color: rgb(35 58 73);
            color: #ffffff;
            font-size: 15px;
    }
    #example_filter{
        position: absolute;
        top: -54px;
        font-size: 15px;
    }
    #example_filter input{
            padding: 7px;
    }
    .eventtype{
        font-family: 'Merriweather', serif;
        font-size: 14px;
        /* font-weight: 600;
        color: RGB(155, 35, 53);
        text-shadow: 2px 3px 0px #dbdbdb; */
    }
    .eventtype2{
        /* color: RGB(155, 35, 53); */
        font-weight: 500;
    }
</style>
</head>
<body>
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

<form action="" method="get">
    <input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

    <input name="report" id="report" type="hidden" value="62">


    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="91%" align="left" valign="top">
            <h3 class="cms_title">Birthday & Wedding Anniversary Reminder Report</h3>
    &nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
            </td>
        </tr>
    <tr>
    <td>
    <table width="80%" style="position: relative;top: 30px;">
            <tr>
                
            <td align="right" width="23%">
                <!-- <input type="text" name="daterange" class="gridfeild" id="daterange" style="padding: 7px;"  value="<?php //if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>"> -->
                <select name="eventType" id="eventType" style="padding: 8px;">
                    <option value="1" <?php if($_REQUEST['eventType']=='1'){ ?>  selected="selected" <?php } ?> >Birth Day</option>
                    <option value="2" <?php if($_REQUEST['eventType']=='2'){ ?>  selected="selected" <?php } ?> >Anniversary Day</option>
                </select>
            </td>
            <td width="1%" align="right">
                <input type="submit" value="Search" class="searchbtnmain">
            </td>
        </tr>
            </table>
    </td></tr>
    </table>
    </form>
    <div id="tableBox">
    <table width="100%" border="1" bordercolor="c1c1c1" cellpadding="10" cellspacing="0" id="example" class="table table-striped tableHead">
            <thead>
                <tr>
                <th>Company Name</th>
                <th>Contact Person Name</th>
                <th>Contact&nbsp;Email&nbsp;Id</th>
                <th>Phone&nbsp;No</th>
                <th>Event&nbsp;Type</th>
                <th>Event&nbsp;Date</th>
                </tr>
            </thead>
            <tbody>
                <?php   $sn = 1;
                $datefilter = '';
                // if(urldecode($_REQUEST['daterange'])!=''){
                //    $dateArray = urldecode($_REQUEST['daterange']);
                //     $myArray = explode(' - ',$dateArray);
                //    $fromDate = $myArray[0];
                //    $toDate = $myArray[1];
                //    $datefilter = 'and dateAdded between "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
                // }
                    
                // if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
                //     $fromDate = $_REQUEST['fromDate']; 
                //    $toDate = $_REQUEST['toDate'];
                //     $datefilter = 'and birthDate between "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
                // } 
                $resc = GetPageRecord('companyName','companySettingsMaster','companyName!=""');
                $companyName = mysqli_fetch_assoc($resc);

                if($_REQUEST['eventType']==1){
                $where = 'firstName!="" and deletestatus=0 and status=1 and  DATE_FORMAT(`birthDate`, "%m%d") >= DATE_FORMAT(NOW(), "%m%d") AND DATE_FORMAT(`birthDate`, "%m%d") <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY), "%m%d") ORDER BY DATE_FORMAT(`birthDate`, "%m%d") ASC';
                }elseif($_REQUEST['eventType']==2){
                    $where = 'firstName!="" and deletestatus=0 and status=1 and  DATE_FORMAT(`anniversaryDate`, "%m%d") >= DATE_FORMAT(NOW(), "%m%d") AND DATE_FORMAT(`anniversaryDate`, "%m%d") <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY), "%m%d") ORDER BY DATE_FORMAT(`anniversaryDate`, "%m%d") ASC';
                }

                $res = GetPageRecord('*',_CONTACT_MASTER_,$where);
                while($result = mysqli_fetch_assoc($res)){
                   $b2cName = $result['firstName'].''.$result['middleName'].' '.$result['lanstName'];
                   $rs2 = GetPageRecord('*','emailMaster','masterId="'.$result['id'].'" and deletestatus=0 and primaryvalue=1');
                   $contactprs = mysqli_fetch_assoc($rs2);
                   $contactPerson = $result['firstName'].' '.$result['middleName'].' '.$result['lastName'];
                  
                   $email = $contactprs['email'];

                   $rs22 = GetPageRecord('*','phoneMaster','masterId="'.$result['id'].'" and deletestatus=0 and primaryvalue=1');
                   $phonem = mysqli_fetch_assoc($rs22);
                   $phone = $phonem['phoneNo'];

                   if($_REQUEST['eventType']==1){
                   $eventDate = date('d-m-Y',strtotime($result['birthDate']));
                   $eventtype = "<div class='eventtype'>Birth Day</div>";
                   }elseif($_REQUEST['eventType']==2){
                    $eventDate = date('d-m-Y',strtotime($result['anniversaryDate']));
                   $eventtype = "<div class='eventtype'>Anniversary Day</div>";
                   }
                ?>
                <tr>
                    <td class="eventtype"><?php echo $companyName['companyName']; ?></td>
                    <td class="eventtype"><?php echo $b2cName; ?></td>
                    <td class="eventtype2"><?php echo $email; ?></td>
                    <td class="eventtype2"><?php echo $phone; ?></td>
                    <td ><?php echo $eventtype; ?></td>
                    <td class="eventtype2"><?php echo $eventDate; ?></td>
                </tr>
                <?php  } ?>
            </tbody>
    </table>
    </div>
<!-- JavaScript code and DataTables Code -->

    <script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable({
    "initComplete": function (settings, json) {  
	$("#example").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
dom: 'frtilpB',
buttons: [
{extend: 'copyHtml5', title: 'Birth Day & Wedding Anniversary Report'},
{extend: 'excelHtml5', title: 'Birth Day & Wedding Anniversary Report'},
{extend: 'pdfHtml5', title: 'Birth Day & Wedding Anniversary Report'}
],
language: { 
search: "Search: ",
searchPlaceholder: "Search By Keyword",
},
});
} );

</script>

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

</body>

</html>