<?php

$searchField=clean($_GET['searchField']);

$searchFieldcommon=clean($_GET['searchFieldcommon']);

$loadqueryyes=1;

$queryshow = $_GET['queryshow'] ; 
 
$wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))



  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';



?>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<link href="css/main.css" rel="stylesheet" type="text/css" />

<style>

.col-md-6 {  display: none !important;}

#pagelisterouter{ padding:10px !important; padding-top: 130px !important;}

body{overflow-x:hidden !important;}

.header{font-weight: 500 !important; font-size: 13px !important;}

#mainsectiontable .fa-pencil-square{cursor: pointer;

    font-size: 20px;

    color: #ff5c00;

	}

</style>

<link href="css/main.css" rel="stylesheet" type="text/css" />

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="91%" align="left" valign="top">

	<form action="" method="get">

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td><div class="headingm" style="margin-left:5px;"><span id="topheadingmain"><?php if($_REQUEST['dashboard']!=''){?><a href="http://travcrm.in/"><img src="images/backicon.png" width="20" style=" cursor:pointer;" /></a><?php } ?>&nbsp;&nbsp;&nbsp; Fix Departure</span>

	<div id="deactivatebtn" > 

	</div>



	</div></td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td>&nbsp;</td>

         <td >

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

   	   <td width="30%"><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField"  value="<?php echo $searchField; ?>" placeholder="Fixed Departure Code" onkeyup="numericFilter(this);"/></td>

      <td style="padding:0px 0px 0px 5px;display:none;" ><input name="searchFieldcommon" type="text"  class="topsearchfiledmain" id="searchFieldcommon" style="width:110px;" value="<?php echo $searchFieldcommon; ?>" size="100" maxlength="100" placeholder="Company, Lead Pax Name"  /></td>



	   <td style="padding:0px 0px 0px 5px;display:none;" ><input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width:130px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { $today = date('d-m-Y'); echo date("d-m-Y", strtotime("-1 month", strtotime($today))).' - '.$today; } ?>" size="100" maxlength="100" placeholder="FD Query Date"/></td>

	<script>

	$(function() {

		$('input[name="daterange"]').daterangepicker({

			"autoApply": true,

			opens: 'right',

			locale: {

				format: 'DD-MM-YYYY'

			}



		}, function(start, end, label) {

			//console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');

		});

	});

</script>





	<td style="padding:0px 0px 0px 5px;display:none;" >

          <select name="destination" id="destination" class="topsearchfiledmainselect" style="width:120px; " >

            <option value="">All Destination</option>

			 <?php

$select='';

$where='';

$rs='';

$select='*';

$where=' deletestatus!=1 order by name asc';

$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);

while($resListing=mysqli_fetch_array($rs)){

?>

			<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['destination']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> </option>

			<?php } ?>

          </select> </td>



		  <td style="padding:0px 0px 0px 5px;display: none;" >

          <select name="priority" id="priority" class="topsearchfiledmainselect" style="width:105px; " >

            <option value="">All Priority</option>



			<option value="1" <?php if($_GET['priority']=='1'){ ?>selected="selected"<?php  } ?>>Low</option>

			<option value="2" <?php if($_GET['priority']=='2'){ ?>selected="selected"<?php  } ?>>Medium</option>

			<option value="3" <?php if($_GET['priority']=='3'){ ?>selected="selected"<?php  } ?>>High</option>



          </select> </td>


		    <td style="padding:0px 0px 0px 5px;display:none;" >

          <select name="querystatus" id="querystatus" class="topsearchfiledmainselect" style="width:130px; " >

            <option value="">All Status</option>



			<option value="1" <?php if($_GET['querystatus']=='1'){ ?>selected="selected"<?php  } ?>>Assigned</option>



           <option value="10" <?php if($_GET['querystatus']=='10'){ ?>selected="selected"<?php  } ?>>Created</option>



		   <option value="20" <?php if($_GET['querystatus']=='20'){ ?>selected="selected"<?php  } ?>>Cancelled</option>

			<option value="2" <?php if($_GET['querystatus']=='2'){ ?>selected="selected"<?php  } ?>>Reverted</option>

			<option value="3" <?php if($_GET['querystatus']=='3'){ ?>selected="selected"<?php  } ?>>Confirmed</option>

			<option value="4" <?php if($_GET['querystatus']=='4'){ ?>selected="selected"<?php  } ?>>Lost</option>

			<option value="5" <?php if($_GET['querystatus']=='5'){ ?>selected="selected"<?php  } ?>>Time Limit Booking</option>

			<option value="6" <?php if($_GET['querystatus']=='6'){ ?>selected="selected"<?php  } ?>>Options Sent</option>

			<option value="7" <?php if($_GET['querystatus']=='7'){ ?>selected="selected"<?php  } ?>>Follow-up</option>









          </select> </td>



		  <td style="padding:0px 0px 0px 5px;display:none;" >

          <select name="queryshow" id="queryshow" class="topsearchfiledmainselect" style="width:160px; " onchange="changequerytstatus();" >

            <option value="1" <?php if($queryshow==1){ ?> selected="selected"<?php } ?>>Current FD Query</option>

			<option value="2" <?php if($queryshow==2){ ?> selected="selected"<?php } ?>>All FD Query</option>

			<option value="3" <?php if($_REQUEST['searchdate']==date('Y-m-d')){ ?> selected="selected"<?php } ?>>Today's FD Queries</option>

			<option value="4" <?php if(date('Y-m-d',strtotime("-1 days"))==$_REQUEST['searchdate']){ ?> selected="selected"<?php } ?>>Yesterday's FD Queries</option>

			<option value="5" <?php if('1'==$_REQUEST['thismonth'] && $_REQUEST['querystatus']!='3'){ ?> selected="selected"<?php } ?>><?php echo date('F'); ?>'s FD Queries</option>





          </select>



		  <input name="searchdate" type="hidden" id="searchdate" value="" />

		   <input name="thismonth" type="hidden" id="thismonth" value="" />



		  </td>

		  <td style="padding:0px 0px 0px 5px;" >

<select name="moduleType" id="moduleType" class="topsearchfiledmainselect" style="width:120px;display: none;" >

<option value="">Module Type</option>

   <?php

$select='';

$where='';

$rs='';

$select='*';

$where=' status=1 order by name asc';

$rs=GetPageRecord($select,'moduleTypeMaster',$where);

while($resListing=mysqli_fetch_array($rs)){

?>

  <option value="<?php echo $resListing['id']; ?>" <?php if($_GET['moduleType']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> </option>

  <?php } ?>

</select> </td>







		  <script>

		  function changequerytstatus(){

		  var queryshow = $('#queryshow').val();

		  if(queryshow=='3'){

		  $('#searchdate').val('<?php echo date('Y-m-d'); ?>');

		  var newq='1';

		  }

		  if(queryshow=='4'){

		  $('#searchdate').val('<?php echo date('Y-m-d',strtotime("-1 days")); ?>');

		    var newq='1';

		  }



		  if(newq!='1'){

		   $('#searchdate').val('');

		  }



		  if(queryshow=='5'){

		  $('#thismonth').val('1');

		  }

		   if(queryshow=='6'){

		  $('#thismonth').val('1');

		  }



		  if(queryshow!='5' && queryshow!='6'){

		   $('#thismonth').val('');

		  }



		  }

		  </script>



        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>

  </tr>
</table>
		</td>
	<!--//onclick="add();" setupbox('showpage.crm?module=query&add=yes');-->
        <?php if($addpermission==1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New" onclick="add();" style="margin-left: 5px !important;" /></td> <?php } ?>
 		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

      </tr>



    </table></td>

  </tr>



</table>

</div>

</form>

<form id="listform" name="listform" method="get">

<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<input name="action" type="hidden" value="querydelete" id="action" />

<div style="display: none;">

<table width="100%" border="0" cellpadding="5" cellspacing="0">

  <tr>

    <td width="10%" align="left" valign="top" style="padding-left:0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#26A69A;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

	<div id="totalQuery" style="font-size:20px; font-weight:600;"></div>

	<div style="font-size:12px; font-weight:500;">Total FD Queries</div>

	</div></td>

  
	<td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=10 and moduleType=3  and deletestatus=0  '); ?></div>

<div style="font-size:12px; font-weight:500;">Created</div>

</div></td>
<td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#FF6600;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=2 and moduleType=3  and deletestatus=0 '); ?></div>

<div style="font-size:12px; font-weight:500;">Reverted</div>

</div></td>

<td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#82b767;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=3 and moduleType=3  and deletestatus=0 '); ?></div>

<div style="font-size:12px; font-weight:500;">Confirmed</div>

</div></td>



  <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#e52929;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where deletestatus=0 and id in (select queryid from '._PAYMENT_REQUEST_MASTER_.' where supplierPendingamount>0 and deletestatus!=1) '); ?></div>

<div style="font-size:12px; font-weight:500;">Unpaid</div>

</div></td>



<!--   <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#333333;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">-->

<!--<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5   and deletestatus=0 '); ?></div>-->

<!--<div style="font-size:12px; font-weight:500;">Time&nbsp;Limit</div>-->

<!--</div></td>-->

<td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=6  and moduleType=3 and deletestatus=0 '); ?></div>

<div style="font-size:12px; font-weight:500;">Options Sent</div>

</div></td>

<td width="10%" align="left" valign="top" ><div style="padding:10px; color:#fff; font-size:12px; background-color:#9466be;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=7  and moduleType=3 and deletestatus=0 '); ?></div>

<div style="font-size:12px; font-weight:500;">Follow-up</div>

</div></td>



 <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#c75858;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">



<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=20  and moduleType=3 and deletestatus=0 '); ?></div>

<div style="font-size:12px; font-weight:500;">Cancelled</div>



</div></td> <td width="10%" align="left" valign="top" style="padding-right:0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#a92525;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">

<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=4  and moduleType=3 and deletestatus=0 '); ?></div>

<div style="font-size:12px; font-weight:500;">Lost</div>

</div></td>

  </tr>

</table>

</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0"  id="mainsectiontable" class="table table-striped table-bordered">

   <thead>

    <tr>



    <th align="center" valign="middle" class="header" >&nbsp;</th>



    <th align="left" class="header" width="10%">FD&nbsp;Code </th>


    <th align="left" class="header">FD&nbsp;Name</th>

    <th align="left" class="header" width="10%" style="display:none">Tour&nbsp;Id &<br>Reference&nbsp;No</th>



    <th align="left" class="header" style="display: none;">Client&nbsp;Name</th>



    <th align="left" class="header" width="10%">Creation&nbsp;Date </th>



    <th align="left" class="header" width="10%">Tour&nbsp;Date </th>



    <th align="left" class="header" >Destination</th>



    <th align="left" class="header" width="10%" >Enquiry&nbsp;Type</th>



    <th align="center" class="header"  width="10%" style="display:none">Type</th>



    <th align="center" class="header" width="10%">Status</th>
    </tr>
   </thead>



  <tbody>

  <?php

$no=1;

$select='*';

$where='';

$rs='';

$wheresearch='';

$limit=clean($_GET['records']);

$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';

if($searchField!=''){

	$mainwhere=' and  displayId='.$searchField.'';

}





$destination='';

if($_GET['destination']!=''){

$destination=' and	destinationId='.clean($_GET['destination']).'';

}




$moduleTypes='';

if($_GET['moduleType']!=''){
	$moduleTypes=' and	moduleType=3';
}else{
	$moduleTypes=' and	moduleType=3';	
}


// $priority='';

// if($_GET['priority']!=''){

// $priority=' and	queryPriority='.clean($_GET['priority']).'';

// }

$querystatus='';

if($_GET['querystatus']!=''){

$querystatus=' and	queryStatus='.clean($_GET['querystatus']).'';

}

$daterangeQuery='';

if($_GET['daterange']!='' && $queryshow !=1 && $_GET['searchField']=='' && $_GET['searchFieldcommon']==''){

	$myString = $_GET['daterange'];

	$myArray = explode(' - ', $myString);



	$daterangeQuery = ' and queryDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

}





$searchFieldcommonquery='';

if($searchFieldcommon!=''){

	$searchFieldcommonquery=' and ( subject like "%'.$searchFieldcommon.'%" or leadPaxName like "%'.$searchFieldcommon.'%" or guest1 like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%" ) or companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$searchFieldcommon.'%" or lastName like "%'.$searchFieldcommon.'%" ) )';

}





$wheresearch=' addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in (select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].') or companyId in (select id from  '._CORPORATE_MASTER_.' where assignTo='.$_SESSION['userid'].')  '.$searchFieldcommonquery.'';





 if($loginuserprofileId==1){

$wheresearch=' 1 '.$mainwhere.' '.$searchFieldcommonquery.'';

} else {

 $wheresearch=' ( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].')     '.$mainwhere.' '.$searchFieldcommonquery.'';



}



$fromDate=trim($_GET['fromDate']);

$toDate=trim($_GET['toDate']);

if($_REQUEST['dashboard']!='' && $fromDate!=''){

$queryDateDash=' and queryDate="'.$fromDate.'"';}

if($_REQUEST['dashboard']!='' && $toDate!=''){

$queryDateDash=' and queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"';  }

if($_GET['searchFieldQueryDate']!=''){

$searchFieldQueryDate='and queryDate="'.date('Y-m-d',strtotime($_GET['searchFieldQueryDate'])).'"';

}



$queryshow='';

if($_GET['queryshow']==2){

	$where=' where '.$wheresearch.' '.$daterangeQuery.' '.$whereFromDate.' '.$mainwhere.' '.$destination.'  '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';
 
}

if($_GET['searchdate']!=''){

$where=' where '.$wheresearch.' '.$whereFromDate.' '.$daterangeQuery.' '.$mainwhere.' '.$destination.' '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and queryDate="'.$_REQUEST['searchdate'].'"  and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';



}

if($_GET['thismonth']=='1'){

$where=' where '.$wheresearch.' '.$whereFromDate.' '.$daterangeQuery.' '.$mainwhere.' '.$destination.' '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and queryDate>="'.date('Y-m').'-1" and queryDate<="'.date('Y-m-t').'"  and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';



}

if($_GET['queryshow']==1 || $_GET['queryshow']==''){

$where=' where '.$wheresearch.' '.$whereFromDate.' '.$daterangeQuery.' '.$mainwhere.' '.$destination.'  '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and ( toDate>="'.date('Y-m-d').'" or dayWise=2 )  and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';



}

if($searchField!=''){

	$where = '';

	$where=' where 1 '.$mainwhere.' and deletestatus=0  ORDER BY queryOrder DESC, dateAdded DESC ';

}

$page=$_GET['page'];


/////echo $where;
$targetpage=$fullurl.'showpage.crm?module=fixdeparture&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&queryshow='.$_REQUEST['queryshow'].'&searchdate='.$_REQUEST['searchdate'].'&thismonth='.$_REQUEST['thismonth'].'&';

$rs=GetRecordList($select,_QUERY_MASTER_,$where,$limit,$page,$targetpage);

$totalentry=$rs[1];

$paging=$rs[2];

$count=mysqli_num_rows($rs[0]);

while($resultlists=mysqli_fetch_array($rs[0])){

?>

  <tr <?php if($resultlists['queryStatus']==20){ ?>style="background-color: #fff2f2;"<?php } ?>>

    <td align="center" valign="middle" style=" width:30px;">

	<?php if($editpermission==1){  ?>
<i class="fa fa-pencil-square" aria-hidden="true" onclick="editDeparture('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
	<?php } ?></td>
<script>
function editDeparture(id){
setupbox('showpage.crm?module=fixdeparture&edit=yes&id='+id+'');
}
function viewDeparture(id){
setupbox('showpage.crm?module=query&view=yes&id='+id+'');
}
</script>
    <td align="left"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; " onclick="viewDeparture('<?php echo encode($resultlists['id']); ?>');"><?php echo trim($resultlists['FDCode']); ?>

	<?php if(countQueryunreadMails($resultlists['id'])!=0){ ?><div class="numberbubbol" style=" left: 58px; top: -1px; margin-bottom: 3px;"><?php echo countQueryunreadMails($resultlists['id']); ?></div><?php } ?>

	<?php if(countSupplierunreadMails($resultlists['id'])!=0){ ?><div class="numberbubbol" style="background-color:#359ec5;left: 58px; top: 22px; margin-bottom: 3px;"><?php echo countSupplierunreadMails($resultlists['id']); ?></div><?php } ?>

	</div>   </td>
	<td align="left"><div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; " onclick="viewSeries('<?php echo encode($resultlists['id']); ?>');"><?php echo trim($resultlists['subject']); ?> </div></td>


    <td align="left" style="display:none">

    <?php if($resultlists['queryStatus']==3 && $resultlists['queryConfirmingDate']!=''){ ?>

      <div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; " onclick="viewDeparture('<?php echo encode($resultlists['id']); ?>');" > <?php echo makeQueryTourId($resultlists['id']); ?> </div>

    <?php } ?>

    <?php if(trim($resultlists['referanceNumber'])!='' && strlen($resultlists['referanceNumber'])>0){ ?>

      <div style="width:130px;" class="bluelink" onclick="viewSeries('<?php echo encode($resultlists['id']); ?>');">& <?php echo clean($resultlists['referanceNumber']); ?></div>

    <?php } ?>    </td>

    <td align="left" style="display: none;"><?php if($resultlists['leadPaxName']!=''){ echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']).'<br>'.'<b>Lead Pax:</b>&nbsp;'.$resultlists['leadPaxName']; }else{ echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); } ?></td>

    <td align="center"><div style="width:80px;"><?php echo date('d-m-Y',$resultlists['dateAdded']); ?><br /><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('h:i:A',$resultlists['dateAdded']); ?></div></td>

    <td align="left" ><?php if($resultlists['moduleType'] != 2) { echo showdate($resultlists['fromDate']); } ?></td>

    <td align="left" >



    <?php

    $dest='';

    $selectDest='*';

    $whereDest=' queryId='.$resultlists['id'].' and lastdeleted = 1 group by cityId order by srdate asc';

    $rsDest=GetPageRecord($selectDest,'packageQueryDays',$whereDest);

    while($resListingDest=mysqli_fetch_array($rsDest)){  $dest.= getDestination($resListingDest['cityId']).', ';  } echo rtrim($dest,', '); ?></td>

	<style>

	.pack{width: 80px;

    border: 1px solid;

    padding: 5px;

	text-align:center;

    border-radius: 3px;

    color: #33CC00;}



	.pack2{    width: 80px;

    border: 1px solid;

    padding: 5px;

	text-align:center;

    border-radius: 3px;

    color: #EC798D;}

	.pack3{    width: 80px;

    border: 1px solid;

    padding: 5px;

	text-align:center;

    border-radius: 3px;

    color: #EC797E;}

	</style>

    <td align="left" ><?php if($resultlists['moduleType']==3){?> <div class=" <?php echo 'pack2'; ?>">Fix Departure</div><?php } ?></td>
 
   <td align="left" style="display:none;"><span class="badge badge-primary" style="background-color:#2bbbad;"><?php echo getUserName($resultlists['assignTo']); ?></span></td>

    <td align="center"style="width:50px;">

	<?php if($resultlists['queryStatus']==20){ ?>

	<div class="lossquery">Cancelled</div>

	<?php } else { ?>

	 <?php

$result =mysqli_query (db(),"select * from "._PAYMENT_REQUEST_MASTER_." where queryid='".$resultlists['id']."' and deletestatus!=1")  or die(mysqli_error(db()));

$number =mysqli_num_rows($result);



$getpaymentid=mysqli_fetch_array($result);

if($number>0)

{

?>

<?php /*?><div class="wonquery" <?php if($getpaymentid['status']==0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['status']==0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div><?php */?>

		<div class="wonquery" <?php if($getpaymentid['supplierPendingamount']>0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['supplierPendingamount']>0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div>



	<?php } else { ?>

	<?php





	if($resultlists['queryStatus']==6){ echo '<div class="assignquery">Options&nbsp;Sent</div>'; }if($resultlists['queryStatus']==7){ echo '<div class="assignquery" style="background-color:#9466be;">Follow-up</div>'; }if($resultlists['queryStatus']==1 || $resultlists['queryStatus']==10){ if($resultlists['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; }  if($resultlists['queryStatus']==10){ echo '<div class="assignquery">Created</div>'; }} if($resultlists['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlists['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlists['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlists['queryStatus']==5){ echo '<div class="closequery">Time Limit Booking</div>'; }  if($resultlists['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?>

	<?php } ?>

	<?php } ?>	</td>
    </tr>



	<?php $no++; } ?>



	<script>



	$(document).ready(function(){



	$('#totalQuery').text('<?php echo $count;?>');

	});

	</script>
</tbody></table>

<?php if($no==1){ ?>

<div class="norec">No <?php echo $pageName; ?></div>

<?php } ?>

<div class="pagingdiv">



		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td><table border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>

    <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >

                    <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>

                    <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>

                    <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>

                    <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>

                    <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>

                  </select></td>

  </tr>



</table></td>

    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>

  </tr>

</tbody></table>

	</div>

</div></form>	</td>

  </tr>

</table>

<script>

window.setInterval(function(){

      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;



      if(!checked) {

	  $("#deactivatebtn").hide();

	  $("#topheadingmain").show();

      } else {

	  $("#deactivatebtn").show();

	  $("#topheadingmain").hide();

	  }

}, 100);

comtabopenclose('linkbox','op2');

</script>

<?php //include "loadmail.php"; ?>

<script>

window.setInterval(function(){

      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;



      if(!checked) {

	  $("#deactivatebtn").hide();

	  $("#topheadingmain").show();

      } else {

	  $("#deactivatebtn").show();

	  $("#topheadingmain").hide();

	  }

}, 100);

comtabopenclose('linkbox','op2');

$(document).ready(function() {

     $('#mainsectiontable').DataTable( {

        "paging":   false,

        "ordering": true,

        "info":     true

    } );

} );

</script>

<style>

.topsearchfiledmain, .topsearchfiledmainselect {

    padding: 12px !important; border-radius: 3px !important;  padding-right: 20px !important;    font-size: 12px;

}

</style>

