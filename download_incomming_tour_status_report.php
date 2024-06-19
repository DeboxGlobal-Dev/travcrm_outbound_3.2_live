<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"])) 
{


  $output .= '
   <table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
                    <tr>  
               <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">S.No</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:170px;">TOUR Code</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Agent Name</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Pax</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Days</th>

    
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Reg.Date</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Hotel</th>




    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Meal</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Guide</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Transports</th>

     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Air.Res.</th>
     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Train.Res.</th>
     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Other</th>
     
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Status</th>
   
    
                    </tr>';
$no=0;   
$grandTotalPax = 0;
$totaldayst =0;
$sno = 0;
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
 $datewhere1  = 'and srdate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
}

$daterangeQuery='';

$daterangeQuery1 = '';
if($_GET['daterange']!=''){ 
  $myString = $_GET['daterange'];
  $myArray = explode(' - ', $myString);  
  $daterangeQuery = 'and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"' ;
  $daterangeQuery1  = 'and srdate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
  $datewhere='';
  $datewhere1='';
}



$no = 0;
$totaldays = 0;
$pax = 0;
$rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from packageQueryDays where cityId in (select id from destinationMaster where countryId="'.$resultlists['countryId'].'")) and status=1 '.$daterangeQuery.''.$datewhere.''); 
$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){

$no++;

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;

$totaldays = $totaldays+$days;

$pax = $pax+$totalpax;


 $output .= '<tr style="text-align:center;">
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$no.'</td>
                 <td  align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.makeQueryTourId($queryData['id']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalpax.'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$days.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',$queryData['dateAdded']).'</td>
                 
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'Confirmed'.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'Confirmed'.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.''.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'Confirmed'.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'  '.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'Confirmed'.'</td>
                <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.' '.'</td>
                
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'Active'.'</td>
                 
                 

           </tr>';


 }

 $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Incoming Tour Status Report.xls');
  echo $output;
 }

?>
