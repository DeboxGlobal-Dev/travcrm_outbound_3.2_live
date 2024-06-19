
<?php

include "inc.php";

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


<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td width="91%" align="left">
            <h3 class="cms_title">Passport Report</h3>
                &nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span> 
                  
                <style>
                    #example_wrapper{
                        width: 99%;
                        margin-left: 5px;
                    }
                    #example_filter{
                        position: absolute;
                        top:-3px;
                    }
                </style>

                <table width="100%" border="1" cellpadding="5" cellspacing="0" id="example" style="margin-top: 40px;">
                  <thead>
                     <tr style="background-color:#233A49; color:#fff;">
                        <td align="center"><strong>Tour&nbsp;Id</strong></td>
                        <td align="center"><strong>Date</strong></td>
                        <td align="center"><strong>Lead&nbsp;Pax&nbsp;Name</strong></td>
                        <td align="center"><strong>Total&nbsp;Pax</strong></td>
                        <td align="center"><strong>Adult</strong></td>
                        <td align="center"><strong>Child</strong></td>
                        <td align="center"><strong>Infant</strong></td>
                        <td align="center"><strong>Destination</strong></td>
                        <td align="center"><strong>Travel&nbsp;Date</strong></td>
                        <td align="center"><strong>Supplier</strong></td>
                     </tr>
                  </thead>
                  <tbody>

                  <?php 
                  
                  $q = GetPageRecord('*','finalQuotePassport','quotationId!="" and queryId!="" order by id desc');

                  while($visaData = mysqli_fetch_assoc($q)){

                    $q2 = GetPageRecord('*',_QUERY_MASTER_,'id="'.$visaData['queryId'].'"');
                    $queryData = mysqli_fetch_assoc($q2);

                    $totalPax = $visaData['adultPax']+$visaData['childPax']+$visaData['infantPax'];

                  ?>
                   <tr>
                    <td align="center"><?php echo makeQueryTourId($visaData['queryId']); ?></td>
                    <td align="center"><?php echo date('d-m-Y',strtotime($visaData['fromDate'])); ?></td>
                    <td align="center"><?php echo $queryData['leadPaxName']; ?></td>
                    <td align="center"><?php echo $totalPax; ?></td>
                    <td align="center"><?php echo $visaData['adultPax']; ?></td>
                    <td align="center"><?php echo $visaData['childPax']; ?></td>
                    <td align="center"><?php echo $visaData['infantPax']; ?></td>
                    <td align="center"><?php echo getDesignation($visaData['destinationId']); ?></td>
                    <td align="center"><?php echo date('d-m-Y',strtotime($visaData['fromDate'])); ?></td>
                    <td align="center"><?php echo getsupplierCompany($visaData['supplierId']); ?></td>
                   </tr>
                   <?php 
                    }
                    ?>
                  </tbody>
                </table>
            </td>
        </tr>
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
{extend: 'copyHtml5', title: 'Passport Report'},
{extend: 'excelHtml5', title: 'Passport Report'},
{extend: 'pdfHtml5', title: 'Passport Report',
orientation: 'landscape',
pageSize: 'LEGAL',
exportOptions: {
    // columns: [ 1,2,3,4,5,6,7,8,9,10,11,12,13 ]
}
}
],
language: { 
search: "Search: ",
searchPlaceholder: "Search By Keyword",
},
});
} );

</script>