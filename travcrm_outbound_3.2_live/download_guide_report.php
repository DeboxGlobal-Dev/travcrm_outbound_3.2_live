<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
   <table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
                    <tr>  
               <th width="15%"  height="10px" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">TOUR ID</th>



    <th width="15%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">TOUR DATE</th>



    <th width="10%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DESTINATION</th>

    <th width="20%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent/FTO Name</th>

    <th width="20%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">LEAD&nbsp;PAX&nbsp;NAME</th>



    <th width="10%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">GUIDE</th>

    <th width="20%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">GUIDE&nbsp;SERVICE</th>

    <th width="10%" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">DAY TYPE</th>
                    </tr>';

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
}

$daterangeQuery='';
if($_REQUEST['daterange']!=''){ 
  $myString = $_REQUEST['daterange'];
  $myArray = explode(' - ', $myString);  
  $daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
  $datewhere='';
}

if($_REQUEST['guideId']!=''){

    $guideId = 'and id in (select guideQuoteId from guideAllocation where 1 and GuideId="'.$_REQUEST['guideId'].'")' ;
}else{

    $guideId = '  ' ;
}

$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' 1  '.$daterangeQuery.' '.$datewhere.' '.$guideId.' and tariffId!=0 order by quotationId desc '); 
while($resultlists=mysqli_fetch_array($rs)){
     $rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'"  and status=1 order by id asc '); 
     
     $quotationData=mysqli_fetch_array($rsq); 

     $rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
     $queryData=mysqli_fetch_array($rsquery);

     
     $sele='*';
     $whereDest=' id="'.$resultlists['destinationId'].'" ';   
     $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
     $ddest=mysqli_fetch_array($rsDest);

     $selectd = '*';   
     $whered= 'id="'.$resultlists['tariffId'].'"'; 
     $rsd = GetPageRecord($selectd,'dmcGuidePorterRate',$whered); 
     $guideDate = mysqli_fetch_array($rsd);

     $rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$resultlists['guideId'].'"'); 
     $guideCat = mysqli_fetch_array($rs11); 

     $rsi = GetPageRecord('*','guideAllocation',' guideQuoteId = "'.$resultlists['id'].'"'); 
     $guideid = mysqli_fetch_array($rsi); 
     if($guideid['GuideId']!='0'){
      $rsg = GetPageRecord('*',_GUIDE_MASTER_,' id = "'.$guideid['GuideId'].'"'); 
      $guidedata = mysqli_fetch_array($rsg);
      $name = $guidedata['name'];
      $phone = $guidedata['phone'];
     }else{
      $name = $guideid['name'];
      $phone = $guideid['mobileNo'];
     }





  $output .= '<tr style="text-align:center;">
   <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($resultlists['fromDate'])).'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['leadPaxName'].'</td>
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$name.'<br>'.$phone.'</div></td>
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$guideCat['name'].'</td>
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$guideDate['dayType'].'</td>
</tr>'; }



 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Guide Report.xls');
  echo $output;
 }

?>
