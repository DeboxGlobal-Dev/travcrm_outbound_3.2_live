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

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Enquiry Name</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Reg.Date</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Arrival Date</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Dept. Date</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Sales Person</th>

     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">File Handler</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Status</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Days</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Pax</th>
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

$rs="SELECT * FROM `destinationMaster` join packageQueryDays on destinationMaster.id = packageQueryDays.cityId and countryId!=0 and queryId in (select queryId from quotationMaster where status=1) ".$daterangeQuery1." ".$datewhere1."  GROUP BY countryId";
$rs12 =mysqli_query(db(),$rs);
while($resultlists=mysqli_fetch_array($rs12)){

    $rscom=GetPageRecord('*',_COUNTRY_MASTER_,'1 and id="'.$resultlists['countryId'].'"'); 
    $countryResult=mysqli_fetch_array($rscom);

  $output .= '<tr style="text-align:center;">
   <td colspan="13" align="left" style="color: #4CAF4D;"><strong>Country Name:&nbsp;&nbsp;'.$countryResult['name'].'</strong></td>
</tr>';

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
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['subject'].'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',$queryData['dateAdded']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($quotationResult['fromDate'])).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($quotationResult['toDate'])).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.getUserName($queryData['assignTo']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.getUserName($queryData['assignTo']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.'Confirm'.'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$days.'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalpax.'</td>

           </tr>';


 }

$output .= '<tr style="text-align:center;">
                  <td colspan="6" align="left" style="color: #4CAF4D;"><strong>No of Tour:&nbsp;&nbsp;'.$countTour.'</strong></td>
                  <td colspan="4" align="right" style="color: #4CAF4D;" ><strong>Sub Total</strong></td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$totaldays.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$pax.'</td>

           </tr>';

$grandTotalPax = $grandTotalPax+$pax; $totaldayst = $totaldayst+$totaldays; $sno = $sno+$countTour;
}

$output .= '<tr style="text-align:center;">
                  <td colspan="6" align="left" style="color: #4CAF4D;"><strong>Total No of Tour:&nbsp;&nbsp;'.$sno.'</strong></td>
                  <td colspan="4" align="right" style="color: #4CAF4D;" ><strong>Grand Total</strong></td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$totaldayst.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$grandTotalPax.'</td>

           </tr>';



 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Tour Registration Report.xls');
  echo $output;
 }

?>
