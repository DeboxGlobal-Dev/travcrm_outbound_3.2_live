<?php
header('Content-type: text/html');
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
	
	//	5000000
	function coverttosmall($value){
		if($value > 1000 && $value < 100000){
			return round($value/1000)."K";
		}else if($value > 100000 && $value < 10000000){
			return round($value/100000)."L";
		}else if($value > 10000000){
			return round($value/10000000)."Cr";
		}else{
			return 0;
		}
	}
	
	$json_result = "";

    //today saleincome
	$suppliertotalcost_sum=0;
	$salesIncomeSql="select SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent2 from queryMaster where queryDate='".date('Y-m-d')."' and queryStatus=3";
	$salesIncomeQuery=mysqli_query(db(),$salesIncomeSql);
	$salesIncomeData=mysqli_fetch_array($salesIncomeQuery);
	$suppliertotalcost_sum = $suppliertotalcost_sum+$salesIncomeData['sumTotalQueryCostwithoutpercent2'];

	//today grossmargin
	$grossMargin = 0;
	$grossMarginSql="select SUM(totalQueryCost) As sumTotalQueryCost, SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent from queryMaster where queryDate='".date('Y-m-d')."' and queryStatus=3";
	$grossMarginQuery=mysqli_query(db(),$grossMarginSql);
	$grossMarginData=mysqli_fetch_array($grossMarginQuery);
	$grossMargin = $grossMarginData['sumTotalQueryCost']-$grossMarginData['sumTotalQueryCostwithoutpercent'];


    //this month saleincome
	$thismonth_suppliertotalcost_sum=0;
	$thismonth_salesIncomeSql="select SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent2 from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3";
	$thismonth_salesIncomeQuery=mysqli_query(db(),$thismonth_salesIncomeSql);
	$thismonth_salesIncomeData=mysqli_fetch_array($thismonth_salesIncomeQuery);
	$thismonth_suppliertotalcost_sum = $thismonth_suppliertotalcost_sum+$thismonth_salesIncomeData['sumTotalQueryCostwithoutpercent2'];


	//this month grossmargin
	$thismonth_grossMargin = 0;
	$thismonth_grossMarginSql="select SUM(totalQueryCost) As sumTotalQueryCost, SUM(totalQueryCostwithoutpercent) As sumTotalQueryCostwithoutpercent from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 ";
	$thismonth_grossMarginQuery=mysqli_query(db(),$thismonth_grossMarginSql);
	$thismonth_grossMarginData=mysqli_fetch_array($thismonth_grossMarginQuery);
	$thismonth_grossMargin = $thismonth_grossMarginData['sumTotalQueryCost']-$thismonth_grossMarginData['sumTotalQueryCostwithoutpercent'];

	//pending payment supplier

	// $pendPaymentSuppAmount = 0;
	// $pendPaymentSuppSql="select id, SUM(supplierPendingamount) As sumsupplierPendingamount from paymentRequestMaster where supplierPendingamount!=0 and dateAdded='".date('Y-m-d')."'";
	// $pendPaymentSuppQuery=mysqli_query(db(),$pendPaymentSuppSql);
	// $pendPaymentSuppData=mysqli_fetch_array($pendPaymentSuppQuery);
	// $pendPaymentSuppAmount = $pendPaymentSuppData['sumsupplierPendingamount'];

	$pendPaymentSuppAmount2= 0;
	$pendPaymentSuppSql="select id, SUM(amount) As sumsupplierPendingamount from supplierSchedulePaymentMaster where 1 and dueDate='".date('Y-m-d')."'";
	$pendPaymentSuppQuery=mysqli_query(db(),$pendPaymentSuppSql);
	$pendPaymentSuppData=mysqli_fetch_array($pendPaymentSuppQuery);
	$pendPaymentSuppAmount2 = $pendPaymentSuppData['sumsupplierPendingamount'];

		
	//client pending payment 
	$pendPaymentClientAmount = 0;
	$pendPaymentClientSql="select id, SUM(amount) As sumpendingCost from agentSchedulePaymentMaster where 1 and dueDate='".date('Y-m-d')."'";
	$pendPaymentClientQuery=mysqli_query(db(),$pendPaymentClientSql);
	$pendPaymentClientData=mysqli_fetch_array($pendPaymentClientQuery);
	$pendPaymentClientAmount = $pendPaymentClientData['sumpendingCost'];
	

	//todays total queries
	$todaysTotalQuerNM = 0;
	$todaysTotalQuerySql="select * from queryMaster where queryDate='".date('Y-m-d')."' and subject!='' and deletestatus=0";
	$todaysTotalQuerQuery=mysqli_query(db(),$todaysTotalQuerySql);
	$todaysTotalQuerNM=mysqli_num_rows($todaysTotalQuerQuery);



	//total queries this month
	$thismonth_TotalQueryNM = 0;
	$thismonth_TotalQuerySql="select * from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now())  and subject!='' and deletestatus=0";
	$thismonth_TotalQueryQuery=mysqli_query(db(),$thismonth_TotalQuerySql);
	$thismonth_TotalQueryNM=mysqli_num_rows($thismonth_TotalQueryQuery);
        
	

	//this month confirmed total queries
	$thismonth_ConfirmQueryNM = 0;
	$thismonth_ConfirmQuerySql="select * from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and subject!='' and queryStatus='3' and deletestatus=0";
	$thismonth_ConfirmQueryQuery=mysqli_query(db(),$thismonth_ConfirmQuerySql);
	$thismonth_ConfirmQueryNM=mysqli_num_rows($thismonth_ConfirmQueryQuery);
        
	//Assigned Queries
	$thismonth_assignedTo="select * from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now())  and subject!='' and queryStatus=1 and deletestatus=0";
	$thismonth_AssignedQueries=mysqli_query(db(),$thismonth_assignedTo);
	$thismonth_Assigned=mysqli_num_rows($thismonth_AssignedQueries);

	//Reverted Queries
	$thismonth_reverted="select id from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=2 and deletestatus=0";
	$thismonth_revertedQuery=mysqli_query(db(),$thismonth_reverted);
	$thismonth_Revert=mysqli_num_rows($thismonth_revertedQuery);

	//Follow-up Queries
	$thismonth_follow="select id from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=7 and deletestatus=0";
	$thismonth_Follow_Up=mysqli_query(db(),$thismonth_follow);
	$thismonth_FollowUp=mysqli_num_rows($thismonth_Follow_Up);

	//Created Queries
	$thismonth_Created="select id from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=10 and deletestatus=0";
	$Queries_Create=mysqli_query(db(),$thismonth_Created);
	$Created_Queries=mysqli_num_rows($Queries_Create);

		//Option Sent
		$thismonth_Option="select id from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=6 and deletestatus=0";
		$thismonth_Option_Sent=mysqli_query(db(),$thismonth_Option);
		$thismonth_OptionSent=mysqli_num_rows($thismonth_Option_Sent);

		//This Month confirmed
		$thismonth_confirm="select id from queryMaster where MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and queryStatus=3 and deletestatus=0";
		$thismonth_Confirmed=mysqli_query(db(),$thismonth_confirm);
		$thismonthConfirmed=mysqli_num_rows($thismonth_Confirmed);

		// UserWise Report
		$userWise_report = "SELECT * FROM userMaster ";
		$userWise = mysqli_query(db(),$userWise_report);
		$User_Wise_Reports = mysqli_num_rows($userWise);

		//Today Total Pax Travelling
		$where=' 1 and fromDate="'.date('Y-m-d').'"';
		$res1=GetPageRecord('*',_QUERY_MASTER_,$where);
		$totaltodaypax=mysqli_fetch_array($res1);
		$totalpax = mysqli_fetch_assoc($res1);
		$totalPaxTravellingtoday = $totaltodaypax['adult'] + $totaltodaypax['child'];
	

	//guest travelling todays
	$guestTravellingTodayNM = 0;
	$guestTravellingTodaySql="SELECT SUM(adult) as gesttravtoday, SUM(child) as totaltodaychild FROM queryMaster WHERE 1 and fromDate='".date('Y-m-d')."'  and deletestatus=0";
	$guestTravellingTodayQuery=mysqli_query(db(),$guestTravellingTodaySql);
	$guestTravellingTodayData=mysqli_fetch_array($guestTravellingTodayQuery);
	$guestTravellingToday = $guestTravellingTodayData['gesttravtoday'] + $guestTravellingTodayData['totaltodaychild']; 
	// $childTravellingToday = ; 
	if($guestTravellingToday > 0){
	    $guestTravellingTodayNM = $guestTravellingToday;
	}else{
	    $guestTravellingTodayNM = 0;
	}


	//Today query confirmed
	$total_queryconfirmedNM = 0;
	$total_queryconfirmedSql="select id from queryMaster where queryStatus='3' and queryDate='".date('Y-m-d')."'  and subject!='' and deletestatus=0";
	$total_queryconfirmedQuery=mysqli_query(db(),$total_queryconfirmedSql);
	$total_queryconfirmedNM = mysqli_num_rows($total_queryconfirmedQuery);
	

	//Pending Queries
	$queryPendingNM = 0;
	$queryPendingSql="select * from queryMaster where 1 and (queryStatus='1' or queryStatus=10) and queryDate='".date('Y-m-d')."' and subject!='' and deletestatus=0 ";
	$queryPendingQuery=mysqli_query(db(),$queryPendingSql);
	$queryPendingNM=mysqli_num_rows($queryPendingQuery);

	// 2019-04-30	
	// echo date('Y-m-t');
	// query confirmed
	// $queryconfirmedSql="select * from queryMaster where and  MONTH(queryDate)=MONTH(now()) and YEAR(queryDate)=YEAR(now()) and deletestatus=0";
	// $queryconfirmedQuery=mysqli_query(db(),$queryconfirmedSql);
	// $queryconfirmedNM=mysqli_num_rows($queryconfirmedQuery);

	//todays todo list
	$todaysTodoListSql="select * from toDoTimeLine where 1 and toDoDate = '".date('Y-m-d')."' and deleteStatus=0";
	$todaysTodoListQuery=mysqli_query(db(),$todaysTodoListSql);
	$todaysTodoListNM=mysqli_num_rows($todaysTodoListQuery);

	// month name
	$month = date('F');

	// year name 
	$year = date('Y');


	// salestargetpercentage
	$salesrevenue_target_monethvaluetotal=0;
	$m=date('F'); 
    $menu22=mysqli_query(db(),"select * from "._TARGET_MASTER_." where 1"); 
    while($rest22=mysqli_fetch_array($menu22)){ 
        $salesrevenue_target_monethvaluetotal = $rest22["".$m.""]+$salesrevenue_target_monethvaluetotal; 
    }

	$totalSales='0';
	$menu2=mysqli_query(db(),"select id from "._QUERY_MASTER_." where 1"); 
	while($rest2=mysqli_fetch_array($menu2)){
	    $select=''; 
	    $where=''; 
	    $rs='';   
	    $select='*'; 
	    $where=' queryId='.$rest2['id'].''; 
	    $rs=GetPageRecord($select,'agentPaymentRequest',$where); 
	    $resultS=mysqli_fetch_array($rs);  
	    $totalSales=$totalSales+$resultS['finalCost'];
	}

	if($totalSales*100/$salesrevenue_target_monethvaluetotal>100){
		$salespercent = '100'; 
	}
	else {
		$salespercent = $totalSales*100/$salesrevenue_target_monethvaluetotal; 
	}


	$json_result.= '{
		"salesincome" : "'.$suppliertotalcost_sum.'",
        "Todayquerypending" : "'.$queryPendingNM.'",
		"grossmargin" : "'.$grossMargin.'",
        "todaysTotalquery" : "'.$todaysTotalQuerNM.'",
        "Todayqueryconfirmed" : "'.$total_queryconfirmedNM.'",
        "guesttravellingtoday" : "'.$guestTravellingTodayNM.'",
        "todaystodolist" : "'.$todaysTodoListNM.'",
        "thismonth_Queries" : "'.$thismonth_TotalQueryNM.'",
        "thismonth_salesincome" : "'.$thismonth_suppliertotalcost_sum.'",
        "thismonth_grossmargin" : "'.$thismonth_grossMargin.'",
        "thismonth_confirmquery" : "'.$thismonth_ConfirmQueryNM.'",
		"pendingpaymentsupplier" : "'.$pendPaymentSuppAmount2.'",
		"pendingpaymentclient" : "'.$pendPaymentClientAmount.'",
        "salespercent" : "'.round($salespercent).'",
		"assigned" : "'.$thismonth_Assigned.'",
		"Reverted" : "'.$thismonth_Revert.'",
        "Followup" : "'.$thismonth_FollowUp.'",
        "Created" : "'.$Created_Queries.'",
        "Optionsent" : "'.$thismonth_OptionSent.'",
        "userwisereport" : "'.$User_Wise_Reports.'",
        "totalpaxtoday" : "'.$guestTravellingTodayNM.'",
        "month" : "'.$month.'",
        "year" : "'.$year.'"
		
	},';
	
// json is here
?>

	[<?php echo trim($json_result,',');  ?>]

