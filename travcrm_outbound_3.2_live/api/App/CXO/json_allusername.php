<?php
header('Content-type: text/html');
//include "../../../travcrm-dev/inc.php";
include "../../../inc.php";

    $select='*';    
	$where=' deletestatus=0 and status=1 order by firstName asc';  
	$rs=GetPageRecord($select,_USER_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){  

		// json results
		$json_result.= '{
			"id" : "'.$resListing['id'].'",
			"username" : "'.$resListing['firstName'].'"
		},';

	}	

?>

	{
		"status":true,
		"articles":[<?php echo trim($json_result, ',');?>]
	}
