<?php 
include "inc.php"; 

if($_REQUEST['action']=='AddFinanceYear'){

    $financeYear = $_REQUEST['financeYear'];
    $fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
    $toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));

    $checkNameQuery = GetPageRecord('*','financeYearMaster','financeYear="'.$financeYear.'" and status=1 and deletestatus=0');

    $checkDateQuery = GetPageRecord('*','financeYearMaster',' 1 and ( fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" OR "'.$fromDate.'" BETWEEN fromDate and toDate )  and status=1 and deletestatus=0');

    // echo $months = round(diffInMonths($fromDate,$toDate));
    if(mysqli_num_rows($checkNameQuery)>0){
        ?>
        <script>
        alert('Financial Year Name Already Exist!');
        </script>
        <?php
    }elseif(mysqli_num_rows($checkDateQuery)>0){
        ?>
        <script>
        alert('Financial Year Date Range Already Exist!');
        </script>
        <?php
    }elseif($fromDate == 'undefined' || $fromDate == '0' || $toDate == 'undefined' || $toDate == '0'){
        ?>
        <script>
        alert('Invalid Date .');
        </script>
        <?php
    }else{
        $namevalue = 'financeYear="'.$financeYear.'", fromDate="'.$fromDate.'", toDate="'.$toDate.'", status=1, deletestatus=0';
        addlisting('financeYearMaster',$namevalue);
    }
}

if($_REQUEST['action']=='loadFinanceYear'){

    $cnt=1;
    $output='';
    $result = GetPageRecord('*','financeYearMaster','status=1 and deletestatus=0 order by fromDate asc');
    if(mysqli_num_rows($result)>0){
        while($fyData = mysqli_fetch_assoc($result)){
            $fromDate = date('d-m-Y',strtotime($fyData["fromDate"]));
            $toDate = date('d-m-Y',strtotime($fyData["toDate"]));
            $output .= "<tr>
            <td align='center' width='90px;'>20{$fyData["financeYear"]}</td>
            <td width='130px;'>{$fromDate}</td>
            <td width='130px;'>{$toDate}</td> 
            </tr>";
            $cnt++;
        }
        echo $output;
    }else{
        echo "No Record Found";
    }
}
?> 