<?php
include "inc.php"; 
include "config/logincheck.php"; 
         
$n=0; 
$totalPax=0;
$pax=0;
$totalAmount=0;
$invoiceAmount=0;

$limit=500; 
$select='*'; 
$where=''; 
$rs=''; 
$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate'];
 
$dataarray2=array("BOOKING ID"=>1,"DATE OF TRNS"=>2 ,"TRAVELER NAME"=>3, "CURRENCY"=>4 , "AMOUNT"=>5 ,"R.O.E"=>6 ,"ROE QUOTE"=>7,"TOTAL AMT IN INR"=>8,"BOOKED BY"=>9,"HANDLED BY"=>10); 
$data2 = array($dataarray2);
$flag2 = false;
foreach($data2 as $row2) {
  if(!$flag2) {
     //display column names as first row
    echo implode("\t", array_keys($row2)) . "\n";
    $flag2 = true;
  } 
}
       $n=1; 
      $select='*'; 
      $where=''; 
      $rs=''; 
      $where='1'; 
      $rs=GetPageRecord($select,_QUERY_MASTER_,$where);
      $totalentry=$rs[1]; 
      $paging=$rs[2];
      while($resultlists=mysqli_fetch_array($rs)){ 

        

      $selectpsq='*'; 
      $wherepsq='queryId="'.$resultlists['id'].'"  order by id desc ';
      $rspsq=GetPageRecord($selectpsq,_PACKAGE_DETAIL_MASTER_,$wherepsq); 
      $totalentrypsq=$rspsq[1]; 
      $pagingpsq=$rspsq[2]; 
    
      while ($resultlistpsq=mysqli_fetch_array($rspsq)) {


        $selectv='*';    
        $wherev=' masterID="'.$resultlistpsq['id'].'"  order by id desc';  
        $rsv=GetPageRecord($selectv,'forexcostMaster',$wherev); 
        while ($forexcostdetails=mysqli_fetch_array($rsv)) {

        $selectdd='*';    
        $wheredd=' queryid="'.$resultlistpsq['queryId'].'"  order by id desc';  
        $rsdd=GetPageRecord($selectdd,_PAYMENT_REQUEST_MASTER_,$wheredd); 
        $duedate=mysqli_fetch_array($rsdd);

        $selectcurrency='*';     
          $wherecurrency=' currencyValue="'.$forexcostdetails['conversion'].'" and deletestatus=0  and name!="" order by name asc';   
          $rscurrency=GetPageRecord($selectcurrency,_QUERY_CURRENCY_MASTER_,$wherecurrency);  
          $resListingcurrency=mysqli_fetch_array($rscurrency);

         $grandtotal= $forexcostdetails['forexCost']*round($forexcostdetails['conversion']);

         if ($resListingcurrency['name']=='INR')
          { $totalamountininr= $forexcostdetails['forexCost']*round($forexcostdetails['conversion']);}

$dataarray=array(makeQueryId($resultlists['id']),date('d-M-y',strtotime($duedate['dueDate'])),strip($resultlists['guest1']), $resListingcurrency['name'], $forexcostdetails['forexCost'], $forexcostdetails['conversion'],$grandtotal,$totalamountininr,getUserName($resultlists['assignTo']),getUserName($resultlists['assignTo'])); 
$data = array($dataarray );
$flag = false;
foreach($data as $row) { 
  array_walk($row, 'filterData');
  echo ucwords(implode("\t", array_values($row))) . "\n"; 
}  

$n++; $queryCount++;
}}} 




function filterData($str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// file name for download
$fileName = "Forex Report".date('d-m-Y-H-i-s').".xls";

// headers for download
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Type: application/vnd.ms-excel");



exit;
?>
 
          