<?php
ob_start();
include "../inc.php";
 
if(trim($_REQUEST['action'])=='proposalSettings' && trim($_REQUEST['quotationId'])!='' ){

	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"  ');
	$quotationData=mysqli_fetch_array($rsp);

	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];
	$q_token = $quotationData['q_token'];

 	$languageId=trim($_REQUEST['languageId']);
 	$proposalType=trim($_REQUEST['proposalType']);

 	if($_FILES['proposalPhoto']['name']!=''){
		$fileName=$_FILES['proposalPhoto']['name'];

	    $n = strrpos($fileName, '.');
	    $ext = ($n === false) ? '' : substr($fileName, $n+1);

		$file_name=time().'_P0'.$proposalType.'_QID'.$quotationId.'.'.$ext;
		copy($_FILES['proposalPhoto']['tmp_name'],"upload/".$file_name);
	}else{
		$file_name = $_REQUEST['proposalPhoto2'];
	}
	//------------------------------------------------------------------
	$namevalue ='languageId="'.$languageId.'",proposalType="'.$proposalType.'",image="'.$file_name.'"';
	$quotationId = updatelisting(_QUOTATION_MASTER_,$namevalue,'id='.$quotationId);
	//---------------------------------------------------------------------
	?><script>
	parent.window.location.href='<?php echo $fullurl; ?>PreviewFiles/crm_proposal.php?propNum=<?php echo trim($proposalType); ?>&q_token=<?php echo trim($q_token); ?>&id=<?php echo $_REQUEST['quotationId']; ?>';
	</script>
	<?php 

}
?>
