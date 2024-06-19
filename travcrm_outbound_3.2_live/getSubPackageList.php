<?php  
include "inc.php"; 
include "config/logincheck.php"; 

// Search Package
$keyword = clean($_REQUEST['keyword']);
$n=1;
if($keyword!='' && isset($keyword)){
	$quotSql="";
	// and calculationType=1
	$quotSql=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and isPackage=1 and queryId in ( select id from queryMaster where 1 and ( packageCode LIKE "%'.$keyword.'%" or subject LIKE "%'.$keyword.'%" ) ) and isActive = 0 order by queryId,fromDate desc'); 
	while($quotationData=mysqli_fetch_array($quotSql)){  
		if(mysqli_num_rows($quotSql) > 0){ ?>
			 <div class="selectParentList" style="padding-left:10px;line-height: 20px;" onclick="setupbox('showpage.crm?module=query&edit=yes&id=<?php echo encode($quotationData['queryId']);?>&quotationId=<?php echo encode($quotationData['id']);?>');fillQuotationId(<?php echo rtrim(encode($quotationData['id']),"=");?>);">
			 <?php
			 $querySql=GetPageRecord('packageCode',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'"');
			 $queryData=mysqli_fetch_array($querySql);
			 echo clean($queryData['packageCode']);
			 ?>
			 <br>
			 <?php echo date('d-m-Y',strtotime($quotationData['fromDate'])).' - '.date('d-m-Y',strtotime($quotationData['toDate'])); ?> 
			 </div> 
			 <?php 
		}  
		$n++; 
	}
}

if($n==1){
?> 
<div style="text-align:center; color:#CCCCCC; padding:30px 0px;">No Package Found</div>
<?php } ?>   
<script>
function fillQuotationId(quotationId){
	$('#quotationId').val(quotationId);
}
</script>