<?php
 include "inc.php";

if($_REQUEST['dayId']!='' && $_REQUEST['destinationId'] && $_REQUEST['destWise']!=''){

    $cnt=1;
    $destWise = $_REQUEST['destWise'];
    $additionalData = $_REQUEST['additionalId2'];
    $additionalName = $_REQUEST['additionalName'];
    $quotationId = $_REQUEST['quotationId'];
    $queryId = $_REQUEST['queryId'];
    
    $dayId = $_REQUEST['dayId'];
    $destinationId = $_REQUEST['destinationId'];
    if($destWise==1){
        $cityId = $_REQUEST['cityId'];
    }else{
        $destinationId = $_REQUEST['destinationId'];
    }
    
    $cnt='';

    if($destWise==1  && $additionalName==''){
        $where = '1 and (FIND_IN_SET("'.$cityId.'", destinationId) or destinationId = 0) and deletestatus = 0 and status = 1 order by name asc';
    }elseif($destWise==2 && $_REQUEST['cityId']!=$destinationId && $additionalName==''){
        $where = '1 and (FIND_IN_SET("'.$destinationId.'",destinationId) or destinationId = 0) and deletestatus=0 and status=1 order by name asc';
    }elseif($destWise==2 && $_REQUEST['cityId']==$destinationId && $additionalName==''){
        $where = '1 and deletestatus=0 and status=1 order by name asc';
    }elseif($destWise==2 && $additionalName!='' && $_REQUEST['cityId']!=$destinationId){
        $where = '1 and name like "%'.$additionalName.'%" and (FIND_IN_SET("'.$destinationId.'",destinationId) or destinationId = 0) and deletestatus=0 and status=1 order by name asc';
    }elseif($destWise==1 && $additionalName!=''){
        $where = '1 and name like "%'.$additionalName.'%" and (FIND_IN_SET("'.$cityId.'",destinationId) or destinationId = 0) and deletestatus=0 and status=1 order by name asc';
    }elseif($destWise==2 && $_REQUEST['cityId']==$destinationId && $additionalName!=''){
        $where = 'name like "%'.$additionalName.'%" and deletestatus=0 and status=1 order by name asc';
    }

     $res = GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,$where);
    // $tableN = 1;
   

    if($row_cnt = mysqli_num_rows($res)>0){
      
    ?>
    <div id="viewinfo" style="display:none;position: absolute; z-index: 9999999999; border: 1px solid #ccc; width: 100%; height: 700px; top: 0px; left: 0px; background-color: #0d0f14c7;"><div id="loadAdditionalinfo" style="margin: auto; width: 700px; margin-top: 100px;"></div></div>

<div class="tablescroll">
    <?php //echo $num; ?>
<table width="95%" border="1" bordercolor="#ccc" cellpadding="5" cellspacing="0" style="font-size: 14px; margin: auto; background: #fff;">
    <thead>
        <tr>
            <th align="left">Additional&nbsp;Name</th>
            <th align="left" width="22%">Cost&nbsp;Type</th>
            <th align="left" width="16%">Group&nbsp;Cost</th>
            <th align="left" width="16%">Adult&nbsp;Cost</th>
            <th align="left" width="16%">Child&nbsp;Cost</th>
            <th align="left" width="16%">Infant&nbsp;Cost</th>
            <th align="center" width="14%;">&nbsp;</th>
            <th align="center" width="14%;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        while($additionalData = mysqli_fetch_array($res)){ 
            
            $currName = getCurrencyName($additionalData['currencyId']);
                $tableN=1;
                $additionalId = $additionalData['id'];
                $rateId = $additionalData['id'];
                $gstValue=getGstValueById($additionalData['gstTax']); 
                $groupCost = $additionalData['groupCost'];
                $adultCost = $additionalData['adultCost'];
                $childCost = $additionalData['childCost'];
                $infantCost = $additionalData['infantCost'];

                $groupMarkup =  getMarkupCost($groupCost,$additionalData['markupCost'],$additionalData['markupType']);
				$adultMarkup =  getMarkupCost($adultCost,$additionalData['markupCost'],$additionalData['markupType']);
			    $childMarkup =  getMarkupCost($childCost,$additionalData['markupCost'],$additionalData['markupType']);
			    $infantMarkup =  getMarkupCost($infantCost,$additionalData['markupCost'],$additionalData['markupType']);

                $groupCost = $groupCost+$groupMarkup;
			    $adultCost = $adultCost+$adultMarkup;
			    $childCost = $childCost+$childMarkup;
			    $infantCost = $infantCost+$infantMarkup;


                $groupCost= round(($groupCost*$gstValue/100)+$groupCost); 
                $adultCost= round(($adultCost*$gstValue/100)+$adultCost); 
                $childCost= round(($childCost*$gstValue/100)+$childCost); 
                $infantCost= round(($infantCost*$gstValue/100)+$infantCost); 

                $costType = $additionalData['costType'];

                $res1 = GetPageRecord('*','quotationAdditionalRateMaster','rateId="'.$additionalData['id'].'"');
                if(mysqli_num_rows($res1)>0){
                    $additionalQuoteData = mysqli_fetch_assoc($res1);
                    $tableN=2;
                    $gstValue=getGstValueById($additionalQuoteData['gstTax']); 
                    $groupCost = $additionalQuoteData['groupCost'];
                    $adultCost = $additionalQuoteData['adultCost'];
                    $childCost = $additionalQuoteData['childCost'];
                    $infantCost = $additionalQuoteData['infantCost'];

                    $groupMarkup =  getMarkupCost($groupCost,$additionalQuoteData['markupCost'],$additionalQuoteData['markupType']);
                    $adultMarkup =  getMarkupCost($adultCost,$additionalQuoteData['markupCost'],$additionalQuoteData['markupType']);
                    $childMarkup =  getMarkupCost($childCost,$additionalQuoteData['markupCost'],$additionalQuoteData['markupType']);
                    $infantMarkup =  getMarkupCost($infantCost,$additionalQuoteData['markupCost'],$additionalQuoteData['markupType']);
    
                    $groupCost = $groupCost+$groupMarkup;
                    $adultCost = $adultCost+$adultMarkup;
                    $childCost = $childCost+$childMarkup;
                    $infantCost = $infantCost+$infantMarkup;
    
    
                    $groupCost= round(($groupCost*$gstValue/100)+$groupCost); 
                    $adultCost= round(($adultCost*$gstValue/100)+$adultCost); 
                    $childCost= round(($childCost*$gstValue/100)+$childCost); 
                    $infantCost= round(($infantCost*$gstValue/100)+$infantCost); 

                    $currName = getCurrencyName($additionalQuoteData['currencyId']);
                    $costType = $additionalQuoteData['costType'];
                    $additionalId = $additionalQuoteData['id'];
                    $rateId = $additionalQuoteData['rateId'];
                }
           
            ?>
            <tr>
                <td align="left"><?php echo $additionalData['name']; ?></td>
                <td align="left"><?php if($costType==1){ echo "Per Person Cost"; }else{ echo "Group Cost"; } ; ?></td>

                <td align="left"><?php if($costType==2 && $groupCost>0){ echo $currName.' '.$groupCost; } ?></td>

                <td align="left"><?php if($costType==1 && $adultCost>0){ echo $currName.' '.$adultCost; } ?></td>
                <td><?php if($costType==1 && $childCost>0){ echo $currName.' '.$childCost; }?></td>
                <td><?php if($costType==1 && $infantCost>0){ echo $currName.' '.$infantCost; } ?></td>
                
                <td style=" width:11%;" align="center">
    				<div style="width: 54px !important; padding: 8px 10px !important;" class="editbtnselect" name="Submit"  onclick="addadditionaltoquotations('<?php echo $additionalId; ?>','<?php echo $resListings['id']; ?>','<?php echo $quotationId ; ?>','<?php echo $queryId; ?>','<?php echo $_REQUEST['dayId']; ?>','<?php echo $_REQUEST['startDay']; ?>','<?php echo $tableN; ?>'); selectthis(this);"><i style="display:inline-block;" class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select
                    </div>
    			</td>
                <td><div class="editbtnselect" onclick="editAdditionalServiceCost('<?php echo $additionalId; ?>','<?php echo $quotationId ; ?>', '<?php echo $rateId ; ?>', '<?php echo $tableN ; ?>' ) ; " style="width: fit-content !important; padding: 8px 10px !important;" > Edit&nbsp;Cost </div></td>
            </tr>
            <?php 
            $cnt++; 
        } ?>
    </tbody>
</table>

  
          
</div>




<?php 
    }else{
        echo "<div style='font-size: 16px;text-align: center;'> No Record found! </div>";
    }

}

        if($cnt==''){
            $cnt = 0;
        }else{
            $cnt;
        }
?>

<!-- <div style="text-align:end;">   <button style="cursor: pointer;font-weight: 700;padding: 5px 10px; position: absolute; bottom: -0%; right: 23%; z-index:999;" onClick="closeinbound();">close</button></div> -->

<script>

    function editAdditionalServiceCost(id,quotationId,rateId,tableN){
        $('#viewinfo').show();
        $("#loadAdditionalinfo").load('addAdditionalServiceCost.php?action=editAdditionalPrice&rateId='+rateId+'&additionalId='+id+'&quotationId='+quotationId+'&queryId=<?php echo $queryId; ?>&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $_REQUEST['cityId']; ?>&tableN='+tableN+'&queryId=<?php echo $_REQUEST['queryId']; ?>');
    }

    $("#numrowsfound").text('<?php echo $cnt;?> Additional Found')
</script>