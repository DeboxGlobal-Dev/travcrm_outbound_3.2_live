<?php  
include "inc.php"; 
include "config/logincheck.php"; 

$seriseCode = clean($_REQUEST['seriesCode']);
$n=1;
if($seriseCode!='' && isset($seriseCode)){
	$quotSql="";
	$quotSql=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and isSeries=1 and ( subName LIKE "%'.$seriseCode.'%" or subSeriesCode LIKE "%'.$seriseCode.'%" or queryId in ( select id from queryMaster where 1 and seriesCode LIKE "%'.$seriseCode.'%" and seriesCode !="" ) ) and isActive = 0 order by queryId,fromDate desc'); 
	while($quotationData=mysqli_fetch_array($quotSql)){  
		if(mysqli_num_rows($quotSql) > 0){ ?>
			<div class="selectParentList" style="padding-left:10px;line-height: 20px;" onclick="setupbox('showpage.crm?module=query&edit=yes&id=<?php echo encode($quotationData['queryId']);?>&quotationId=<?php echo encode($quotationData['id']);?>');fillQuotationId(<?php echo  rtrim(encode($quotationData['id']),"=");?>);">
			 <?php echo clean($quotationData['subName']); ?>
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
<div style="text-align:center; color:#CCCCCC; padding:30px 0px;">No Series Found</div>
<?php } ?>   
<script>
function fillQuotationId(quotationId){
$('#quotationId').val(quotationId);
}
</script>