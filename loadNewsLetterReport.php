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
        top: -55px;
        font-size: 15px;
    }
    #example_filter input{
            padding: 7px;
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

<form method="get">
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />

<input name="report" id="report" type="hidden" value="63">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="100%" align="left" valign="top">
            <h3 class="cms_title">News Letter Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
            </td>
           
        </tr>
       <tr>
        <td>
            <table width="80%" style="position: relative;top: 30px;">
            <tr>
                <td align="right"><select name="companyType" id="companyType" class="gridfeild" style="padding:8px;width:150px;margin-bottom: -3px;">
                    
                    <option value="1" <?php if($_REQUEST['companyType']=='1'){?> selected="selected" <?php } ?> >Agent</option>
                    <option value="2"  <?php if($_REQUEST['companyType']=='2'){?> selected="selected" <?php } ?> >B2C</option>
                </select></td>
                
            <td align="right" width="23%">
                <input type="text" name="daterange" class="gridfeild" id="daterange" style="padding: 7px;"  value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>">
            </td>
            <td width="1%" align="right">
                <input type="submit" value="Search" class="searchbtnmain">
            </td>
        </tr>
            </table>
        </td>
       </tr>
    </table>
    </form>
    <div id="tableBox">
    <table width="100%" border="1" bordercolor="c1c1c1" cellpadding="10" cellspacing="0" id="example" class="table table-striped tableHead">
            <thead>
                <tr>
                <th>SN</th>
                <th>Contact&nbsp;Person&nbsp;Name</th>
                <th>Contact&nbsp;Email&nbsp;Id</th>
                <th>Phone&nbsp;No</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sn = 1;
                $datefilter = '';
                if(urldecode($_REQUEST['daterange'])!=''){
                   $dateArray = urldecode($_REQUEST['daterange']);
                  $myArray = explode(' - ',$dateArray);
                   $fromDate = $myArray[0];
                   $toDate = $myArray[1];
                   $datefilter = 'and dateAdded between "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
                }

                if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
                    $fromDate = $_REQUEST['fromDate']; 
                    $toDate = $_REQUEST['toDate'];
                    $datefilter = 'and dateAdded between "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
                }
               
                
                if($_REQUEST['companyType']=='1'){
                    $where = 'status=1 and deletestatus=0 and name!="" '.$datefilter.' order by id desc';
                    $query = GetPageRecord('*',_CORPORATE_MASTER_,$where);
                }elseif($_REQUEST['companyType']=='2'){
                    $where = 'contactType=2 and status=1 and deletestatus=0 and firstName!=""'.$datefilter.' order by id desc';
                    $query = GetPageRecord('*',_CONTACT_MASTER_,$where);

                }

                while($result = mysqli_fetch_assoc($query)){
                    if($_REQUEST['companyType']==1){
                   $rs = GetPageRecord('*','contactPersonMaster','corporateId="'.$result['id'].'" and deletestatus=0');
                   $contactprs = mysqli_fetch_assoc($rs);
                   $contactPerson = $contactprs['contactPerson'];
                   $phone = decode($contactprs['phone']);
                   $email = decode($contactprs['email']);
                    }elseif($_REQUEST['companyType']==2){

                        $rs2 = GetPageRecord('*','emailMaster','masterId="'.$result['id'].'" and deletestatus=0');
                        $contactprs = mysqli_fetch_assoc($rs2);
                        $contactPerson = $result['firstName'].' '.$result['middleName'].' '.$result['lastName'];
                       
                        $email = $contactprs['email'];

                        $rs22 = GetPageRecord('*','phoneMaster','masterId="'.$result['id'].'" and deletestatus=0');
                        $phonem = mysqli_fetch_assoc($rs22);
                        $phone = $phonem['phoneNo'];
                    }
                ?>
                <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $contactPerson; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $phone; ?></td>
                </tr>
                <?php $sn++; } ?>
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
{extend: 'copyHtml5', title: 'News Letter Report'},
{extend: 'excelHtml5', title: 'News Letter Report'},
{extend: 'pdfHtml5', title: 'News Letter Report'}
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