<?php
$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']);

$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate'];
$assignto=$_GET['assignto'];
$destinationId=$_GET['destinationId'];
$categoryId=$_GET['categoryId'];
$tourType=$_GET['tourType'];
$clientType=$_GET['clientType'];
$clients=$_GET['Clients'];

$strWhere='';

if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));

$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}


if($assignto!=''){  
$strWhere.=' and assignTo='.$assignto.'';
}


if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}


if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}


if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}

if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}

if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
}

?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		 <input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />

		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter" style="padding-left:30px;">


 

 


  
sdfasdf
 
</div> 	</td>
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