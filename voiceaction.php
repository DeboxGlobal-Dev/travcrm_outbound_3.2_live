<?php
ob_start(); 
include "inc.php"; 
include "config/logincheck.php"; 

function displaymoney($number){
    $number = $number;
    setlocale(LC_MONETARY,"NULL");
    return money_format("%i", $number);
}

if($loginuserprofileId==1){ 

    $wheresearchassign=' 1   ';

} else { 

    $wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 
    
    $wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 
?>

<?php if($_REQUEST['action']=='query' && $_REQUEST['id']!=''){ 
    $select='id';  
    $where='id='.trim($_REQUEST['id']).''; 
    $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
    $retrunquerydata=mysqli_fetch_array($rs); 
    if($retrunquerydata['id']!=''){
        ?><script>
        $('#note-textarea').val('Opening query'); 
        speektotalk();  
        window.location.href = 'showpage.crm?module=query&view=yes&id=<?php echo encode($retrunquerydata['id']); ?>';
        </script>
    <?php } else { ?>
        <script>
        $('#note-textarea').val('Query number <?php echo $_REQUEST['id']; ?> not exist in my database'); 
        speektotalk();  
        </script>
    <?php } 
} ?>


<?php if($_REQUEST['action']=='queryreport'){

function makemulti($str){
if($str>1){
return 'ies';
} else {
return 'y';
}
}


$select='id'; 
$where=' where '.$wheresearchassign.' and queryDate="'.date('Y-m-d').'"';
$todaysQuery = countlisting($select,_QUERY_MASTER_,$where);


$select='id'; 
$where=' where  '.$wheresearchassign.' and MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and  deletestatus=0';
$thismonthQuery = countlisting($select,_QUERY_MASTER_,$where);

 


$select='id'; 
$where=' where  '.$wheresearchassign.' and  MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 and deletestatus=0';
$confirmQuery = countlisting($select,_QUERY_MASTER_,$where);

$select='id'; 
$where=' where  status=1 and queryid in (select id from '._QUERY_MASTER_.' where  '.$wheresearchassign.' and deletestatus=0)';
$PendingMail = countlisting($select,_QUERYMAILS_MASTER_,$where);
?>
 
 
<script>
$('#note-textarea').val('Today you received <?php echo $todaysQuery; ?> quer<?php echo makemulti($todaysQuery); ?>. In <?php echo date('F'); ?> there <?php if($thismonthQuery>1){ echo 'were'; } else { echo 'was'; } ?> <?php echo $thismonthQuery; ?> quer<?php echo makemulti($thismonthQuery); ?>. Out of which <?php echo $confirmQuery; ?> quer<?php echo makemulti($confirmQuery); ?> got confirmed. There <?php if($PendingMail>1){ echo 'are'; } else { echo 'is'; } ?> <?php echo $PendingMail; ?> new message.'); 
speektotalk();  
</script>
<?php } ?>






<?php if($_REQUEST['action']=='salesreport'){ 



function makemulti($str){
if($str>1){
return 'ies';
} else {
return 'y';
}
}


   $companytotalcost_sum=0;
$menug=mysqli_query("select id, SUM(totalQueryCost) As sumTotalQueryCost, SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent from "._QUERY_MASTER_."    where ".$wheresearchassign."  and  MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 ");
$res_menug=mysqli_fetch_array($menug);
 $gmarg = $res_menug['sumTotalQueryCost']-$res_menug['sumTotalQueryCostwithoutpercent'];
 
  
$suppliertotalcost_sum=0;
$menue=mysqli_query("select id,SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent2 from "._QUERY_MASTER_."    where  ".$wheresearchassign."  and MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 ");
$res_menue=mysqli_fetch_array($menue);
$suppliertotalcost_sum = $suppliertotalcost_sum+$res_menue['sumTotalQueryCostwithoutpercent2'];
?>
 
 
<script>
$('#note-textarea').val('Total Sales In <?php echo date('F'); ?> is <?php echo ($suppliertotalcost_sum); ?>. Gross Margin is <?php echo ($gmarg); ?>'); 
speektotalk();  
</script>
<?php } ?>











<?php if($_REQUEST['action']=='monthlycollection'){ 
$totalsales=0;

$s=1;
$select2='*';
$where2=' 1 order by id ASC'; 
$rs2=GetPageRecord($select2,_DMC_PAYMENT_LIST_MASTER_,$where2); 
while($listofpayment=mysqli_fetch_array($rs2)){
if(date('Y-m',$listofpayment['dateAdded'])==date('Y-m')){
$totalsales=$listofpayment['amount']+$totalsales;
}

}

$totalexpensesMaster=0;
$s=1;
$select2='*';
$where2=' 1  order by id ASC'; 
$rs2=GetPageRecord($select2,'expensesMaster',$where2); 
while($listofpayment2=mysqli_fetch_array($rs2)){
 
if(date('Y-m',strtotime($listofpayment2['invoiceDate']))==date('Y-m')){
$totalexpensesMaster=$listofpayment2['totalAmount']+$totalexpensesMaster;
 }

 
}
?>
 
 
<script>
$('#note-textarea').val('Total Monthly Collection is <?php echo $totalsales; ?>. Total Monthly Expenses is <?php echo $totalexpensesMaster; ?>. '); 
speektotalk();  
</script>
<?php } ?>
