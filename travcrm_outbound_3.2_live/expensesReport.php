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
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    
    <style>
     
    </style>
    
    
    <!-- <form action="" method="get">
        <input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
    
        <input name="report" id="report" type="hidden" value="64">
    
    
        <table width="100%" cellpadding="0" cellspacing="0" style="height: 80px;">
            <tr>
                <td width="91%" align="left" valign="top">
        &nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>
                </td>
            </tr>
        <tr>
        <td>
        <table width="80%" style="position: relative;top: 30px;">
                <tr>
                    
                <td width="1%" align="right">
                    <input type="submit" value="Search" class="searchbtnmain">
                </td>
            </tr>
                </table>
        </td></tr>
        </table>
        </form>
         -->
        <div class="iconbox">
			<div style="color: #313131; font-size:28px;font-weight:500" id="totalExpense">0</div>
			<div class="text">Total Expense</div>
		</div>

        <div id="tableBox">
            
    <style>
        .expIn{    
            width: 72%;
            height: 30px;
        }
        #example_filter{
        position: absolute;
        left: 2px;
        top: -100px;
        font-size: 15px;
        left: 1%;	
        }
    
        #example_filter input{
            padding:7px;
        }

        #example_wrapper{
            margin-left: 5px;
        margin-right: 5px;
        width: 98.3%;
    }
        
    </style>
  
    <table width="100%" border="1" cellpadding="0" cellspacing="0" id="example" class="gridtable" style=" margin-top: 30px">
        <thead>
            <tr>
                <th align="center" style="width: 15px !important;">SN</th>
                <th align="left" style="width: 90px !important;">Tour Id</th>
                <th align="left" style="width: 80px !important;">Expense Date</th>
                <th align="left" >Expense Type</th>
                <th align="left">Expense Head</th>
                <th align="left">Amount</th>
                <th align="left" style="width: 100px !important;">Narration</th>
                <th align="left" style="width: 80px !important;">Paid&nbsp;To</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no=1;
            if($_REQUEST['daterange']!=''){
                $myString = $_REQUEST['daterange'];
                $myArray = explode(' - ', $myString);  
                $fromDate = $myArray[0];
                $toDate = $myArray[1];
                $daterange = 'and expenseDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
             }

             if($_REQUEST['expenseHead']!=''){
                $headId = $_REQUEST['expenseHead'];
                $exHeadId = 'and headId="'.$headId.'"';
             }

             $where = '1 '.$daterange.' '.$exHeadId.' and status=1 and deletestatus=0 order by id desc';
            $res = GetPageRecord('*','quotationExpensesMaster',$where);
            if(mysqli_num_rows($res)>0){
            while($resListing=mysqli_fetch_assoc($res)){  
                $res2 = GetPageRecord('*','expenseTypeMaster','id="'.$resListing['expenseTypeId'].'"');
                $expenseType = mysqli_fetch_assoc($res2);
    
                $res3 = GetPageRecord('*','expenseHeadMaster','id="'.$expenseType['expenseHeadId'].'"');
                $expenseHead = mysqli_fetch_assoc($res3);
    
    
                $res4 = GetPageRecord('*','queryCurrencyMaster','id="'.$resListing['currencyId'].'"');
                $curr = mysqli_fetch_assoc($res4);
            ?>
            <tr>
            <td align="center"><?php echo $no; ?></td>
            <td align="left">
            <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; " onclick="view('<?php echo encode($resListing['queryId']); ?>');" > <?php echo makeQueryTourId($resListing['queryId']); ?> </div></td>
            <td align="left"><?php echo date('d-m-Y',strtotime($resListing['expenseDate'])); ?></td>
            <td align="left"><?php echo $expenseType['name']; ?></td>
            <td align="left"><?php echo $expenseHead['name']; ?></td>
            <td align="right"><?php echo $curr['name'].' '.$resListing['expenseAmount']; ?></td>
            <td align="left"><?php echo $resListing['remarks']?></td>
            <td align="left"><?php echo $resListing['paidTo']?></td>
            
            </tr>

            <?php
            
            $totalExpense = $totalExpense + $resListing['expenseAmount'];
            
            
            
            $no++; } ?>
        </tbody>
        <tr>
            <td colspan="5" style="font-size: 15px;font-weight: 500; text-align:right;" >Total Expense</td>
            <td style="font-size: 15px;font-weight: 500;text-align:right;"><?php echo $totalExpense; ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <?php 
    }else{
        echo "<div style='font-weight:500; color:#adadad; font-size:16px;padding:15px;'>No Expense</div>";
    }
    
    
    ?>
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
    {extend: 'copyHtml5', title: 'Expense Report'},
    {extend: 'excelHtml5', title: 'Expense Report'},
    {extend: 'pdfHtml5', title: 'Expense Report'}
    ],
    language: { 
    search: "Tour Id: ",
    searchPlaceholder: "Search By Keyword",
    },
    });
    } );
    

    $("#totalExpense").text(<?php echo $totalExpense; ?>);
    </script>
   
    
    
    