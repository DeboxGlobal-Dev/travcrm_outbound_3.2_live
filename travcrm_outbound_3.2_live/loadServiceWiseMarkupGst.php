<?php
include "inc.php";
$rsp="";
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"');
$quotationData=mysqli_fetch_array($rsp);
$quotationId = $quotationData['id'];
$queryId = $quotationData['queryId'];


$paxAdult = ($quotationData['adult']);
$paxChild = ($quotationData['child']);
$paxInfant = ($quotationData['infant']);
$totalPax = ($paxAdult + $paxChild + $paxInfant);
if($totalPax == 0){
    $totalPax =  2;
}

$singleRoom = $quotationData['sglRoom'];
$doubleRoom = $quotationData['dblRoom'];
$twinRoom   = $quotationData['twinRoom'];
$tripleRoom = $quotationData['tplRoom'];
$quadBedRoom = $quotationData['quadNoofRoom'];
$sixBedRoom = $quotationData['sixNoofBedRoom'];
$eightBedRoom = $quotationData['eightNoofBedRoom'];
$tenBedRoom = $quotationData['tenNoofBedRoom'];
$teenBedRoom = $quotationData['teenNoofRoom'];
$EBedAdult = $quotationData['extraNoofBed'];
$EBedChild = $quotationData['childwithNoofBed'];
$NBedChild = $quotationData['childwithoutNoofBed'];
$isChildBFQ = $quotationData['isChildBreakfast'];
$isChildDNQ = $quotationData['isChildDinner'];
$isChildLHQ = $quotationData['isChildLunch'];


$hotelRatesCols = 3;
if($tripleRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($twinRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($quadBedRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($sixBedRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($eightBedRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($tenBedRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($teenBedRoom>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
}

if($EBedAdult>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($EBedChild>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 
if($NBedChild>0){ 
    $hotelRatesCols = $hotelRatesCols+1;
} 

// Domestic query service wise markup file load
?>
<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#CCCCCC">
  <thead>
    <tr>
      <th align="left" bgcolor="#ddd">Services</th>
    </tr>
  </thead>
  <tbody >
    <tr>
      <td width="100%" align="left" valign="top" ><?php 
        $qItiQuery1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and serviceType="hotel"   order by startDate asc');
        if(mysqli_num_rows($qItiQuery1) >0){ ?>
          <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  ><thead>
            <tr>
              <th rowspan="2" width="8%" align="left" bgcolor="#F4F4F4"><strong>Date</strong></th>
              <th rowspan="2" width="5%" align="left" bgcolor="#F4F4F4"><strong>Type</strong></th>
              <th rowspan="2" width="46%" align="left" bgcolor="#F4F4F4"><strong>Service</strong></th>
              <th rowspan="2" width="8%" align="left" bgcolor="#F4F4F4"><strong>MarkUp</strong></th>
              <th width="10%" colspan="<?php echo $hotelRatesCols ?>" width="8%" align="center" bgcolor="#F4F4F4"><strong>MarkUp</strong></th>
              <th rowspan="2" align="left" bgcolor="#F4F4F4"><strong>Tax Type</strong></th>
              <th rowspan="2" width="10%" align="left" bgcolor="#F4F4F4"><strong>Tax Value</strong></th>
              <th rowspan="2" width="5%" bgcolor="#F4F4F4"><strong>Action</strong></th>
            </tr>
            <tr>
              <th width="8%" align="left" bgcolor="#F4F4F4"><strong>SGL</strong></th>
              <th width="8%" align="left" bgcolor="#F4F4F4"><strong>DBL</strong></th>
              <?php if($twinRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>Twin</strong></td>
              <?php }if($tripleRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>TPL</strong></td>
              <?php } if($quadBedRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>QUAD</strong></td>
              <?php } if($sixBedRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>SIX</strong></td>
              <?php } if($eightBedRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>EIGHT</strong></td>
              <?php } if($tenBedRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>TEN</strong></td>
              <?php } if($teenBedRoom>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>TEEN</strong></td>
              <?php } if($EBedAdult>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>E.Bed(A)</strong></td>
              <?php } if($EBedChild>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>E.Bed(C)</strong></td>
              <?php } if($NBedChild>0){ ?>
              <td width="8%" align="left" bgcolor="#F4F4F4"><strong>CNB</strong></td>
              <?php } ?>
              <th width="8%" align="left" bgcolor="#F4F4F4"><strong>Meal</strong></th>
            </tr>
          </thead>
          <tbody>
          <?php
          while($qItData=mysqli_fetch_array($qItiQuery1)){

            $serviceType = $qItData['serviceType'];
            $serviceId = $qItData['serviceId'];
            $uniq_Id = $qItData['id'];
            $dayId = $qItData['dayId'];
            
            if($serviceType=='hotel'){

              $sglMarkup = $dblMarkup = $twinMarkup = $tplMarkup = $quadMarkup = $sixMarkup = $eightMarkup = $tenMarkup = $teenMarkup = $cwbMarkup = $exMarkup = $cnbMarkup = $mealMarkup = 0;

              $cquery='';
              $cquery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and supplierId="'.$serviceId.'" and dayId="'.$dayId.'" and isGuestType=1');
              while($hotelQuotData=mysqli_fetch_array($cquery)){
                // hotel data
                $d='';
                $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
                $hotelData=mysqli_fetch_array($d);
                
                $taxSlabId = $hotelQuotData['roomGST'];
                $taxType = $hotelQuotData['taxType'];
                $markupType = $hotelQuotData['markupType'];

                $sglMarkup = ($hotelQuotData['sglMarkup']>0)? $hotelQuotData['sglMarkup'] : $hotelQuotData['markupCost'];
                $dblMarkup = ($hotelQuotData['dblMarkup']>0)? $hotelQuotData['dblMarkup'] : $hotelQuotData['markupCost'];
                $twinMarkup = ($hotelQuotData['twinMarkup']>0)? $hotelQuotData['twinMarkup'] : $hotelQuotData['markupCost'];
                $tplMarkup = ($hotelQuotData['tplMarkup']>0)? $hotelQuotData['tplMarkup'] : $hotelQuotData['markupCost'];
                $quadMarkup = ($hotelQuotData['quadMarkup']>0)? $hotelQuotData['quadMarkup'] : $hotelQuotData['markupCost'];
                $sixMarkup = ($hotelQuotData['sixMarkup']>0)? $hotelQuotData['sixMarkup'] : $hotelQuotData['markupCost'];
                $eightMarkup = ($hotelQuotData['eightMarkup']>0)? $hotelQuotData['eightMarkup'] : $hotelQuotData['markupCost'];
                $tenMarkup = ($hotelQuotData['tenMarkup']>0)? $hotelQuotData['tenMarkup'] : $hotelQuotData['markupCost'];
                $teenMarkup = ($hotelQuotData['teenMarkup']>0)? $hotelQuotData['teenMarkup'] : $hotelQuotData['markupCost'];
                $cwbMarkup = ($hotelQuotData['cwbMarkup']>0)? $hotelQuotData['cwbMarkup'] : $hotelQuotData['markupCost'];
                $exMarkup = ($hotelQuotData['exMarkup']>0)? $hotelQuotData['exMarkup'] : $hotelQuotData['markupCost'];
                $cnbMarkup = ($hotelQuotData['cnbMarkup']>0)? $hotelQuotData['cnbMarkup'] : $hotelQuotData['markupCost'];
                $mealMarkup = ($hotelQuotData['mealMarkup']>0)? $hotelQuotData['mealMarkup'] : $hotelQuotData['markupCost'];
                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($hotelQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($hotelData['hotelName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($hotelQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>

                  <td align="left" ><input type="text" name="sglMarkup<?php echo $uniq_Id; ?>" id="sglMarkup<?php echo $uniq_Id; ?>" value="<?php echo $sglMarkup; ?>" class="markInput digit_only"></td> 
                  <td align="left" ><input type="text" name="dblMarkup<?php echo $uniq_Id; ?>" id="dblMarkup<?php echo $uniq_Id; ?>" value="<?php echo $dblMarkup; ?>" class="markInput digit_only"></td> 
                  <?php  if($twinRoom>0){ ?>
                  <td align="left" ><input type="text" name="twinMarkup<?php echo $uniq_Id; ?>" id="twinMarkup<?php echo $uniq_Id; ?>" value="<?php echo $twinMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($tripleRoom>0){ ?>
                  <td align="left" ><input type="text" name="tplMarkup<?php echo $uniq_Id; ?>" id="tplMarkup<?php echo $uniq_Id; ?>" value="<?php echo $tplMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($quadBedRoom>0){ ?>
                  <td align="left" ><input type="text" name="quadMarkup<?php echo $uniq_Id; ?>" id="quadMarkup<?php echo $uniq_Id; ?>" value="<?php echo $quadMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($sixBedRoom>0){ ?>
                  <td align="left" ><input type="text" name="sixMarkup<?php echo $uniq_Id; ?>" id="sixMarkup<?php echo $uniq_Id; ?>" value="<?php echo $sixMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($eightBedRoom>0){ ?>
                  <td align="left" ><input type="text" name="eightMarkup<?php echo $uniq_Id; ?>" id="eightMarkup<?php echo $uniq_Id; ?>" value="<?php echo $eightMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($tenBedRoom>0){ ?>
                  <td align="left" ><input type="text" name="tenMarkup<?php echo $uniq_Id; ?>" id="tenMarkup<?php echo $uniq_Id; ?>" value="<?php echo $tenMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($teenBedRoom>0){ ?>
                  <td align="left" ><input type="text" name="teenMarkup<?php echo $uniq_Id; ?>" id="teenMarkup<?php echo $uniq_Id; ?>" value="<?php echo $teenMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($EBedAdult>0){ ?>
                  <td align="left" ><input type="text" name="exMarkup<?php echo $uniq_Id; ?>" id="exMarkup<?php echo $uniq_Id; ?>" value="<?php echo $exMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($EBedChild>0){ ?>
                  <td align="left" ><input type="text" name="cwbMarkup<?php echo $uniq_Id; ?>" id="cwbMarkup<?php echo $uniq_Id; ?>" value="<?php echo $cwbMarkup; ?>" class="markInput digit_only"></td>
                  <?php } if($NBedChild>0){ ?>
                  <td align="left" ><input type="text" name="cnbMarkup<?php echo $uniq_Id; ?>" id="cnbMarkup<?php echo $uniq_Id; ?>" value="<?php echo $cnbMarkup; ?>" class="markInput digit_only"></td>
                  <?php } ?>
                  <td align="left" ><input type="text" name="mealMarkup<?php echo $uniq_Id; ?>" id="mealMarkup<?php echo $uniq_Id; ?>" value="<?php echo $mealMarkup; ?>" class="markInput digit_only"></td> 

                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateHotelSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>','<?php echo $dayId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            } 
            // end quoation itinerary loop
          }
          ?>
          </tbody>
          </table><br><?php 

        }  
        $qItiQuery2=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and serviceType!="hotel"  order by startDate asc');
        if(mysqli_num_rows($qItiQuery2) >0){ ?>
          <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
          <thead>
            <tr>
              <th width="8%" align="left" bgcolor="#F4F4F4"><strong>Date</strong></th>
              <th width="5%" align="left" bgcolor="#F4F4F4"><strong>Type</strong></th>
              <th width="46%" align="left" bgcolor="#F4F4F4"><strong>Service&nbsp;Name</strong></th>
              <th width="8%" align="left" bgcolor="#F4F4F4"><strong>MarkUp&nbsp;Type</strong></th>
              <th width="8%" align="left" bgcolor="#F4F4F4"><strong>MarkUp</strong></th>
              <th width="10%" align="left" bgcolor="#F4F4F4"><strong>Tax&nbsp;Type</strong></th>
              <th width="10%" align="left" bgcolor="#F4F4F4"><strong>Tax&nbsp;Value</strong></th>
              <th width="5%" bgcolor="#F4F4F4"><strong>Action</strong></th>
            </tr>
          </thead>
          <tbody><?php
          
          while($qItData=mysqli_fetch_array($qItiQuery2)){

            $serviceType = $qItData['serviceType'];
           
            $serviceId = $qItData['serviceId'];
            $uniq_Id = $qItData['id'];
            
            if($serviceType=='transfer'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($transferQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$transferQuotData['transferNameId'].'"');
                $transferData=mysqli_fetch_array($d);
                
                $taxSlabId = $transferQuotData['gstTax'];
                $taxType = $transferQuotData['taxType'];
                $markupType = $transferQuotData['markupType'];
                $markupCost = $transferQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($transferQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($transferQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }

            if($serviceType=='transportation'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($tptQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$tptQuotData['transferNameId'].'"');
                $transferData=mysqli_fetch_array($d);
                
                $taxSlabId = $tptQuotData['gstTax'];
                $taxType = $tptQuotData['taxType'];
                $markupType = $tptQuotData['markupType'];
                $markupCost = $tptQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($tptQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($tptQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='entrance'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($entranceQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*','packageBuilderEntranceMaster',' id="'.$entranceQuotData['entranceNameId'].'"');
                $entranceData=mysqli_fetch_array($d);
                
                $taxSlabId = $entranceQuotData['gstTax'];
                $taxType = $entranceQuotData['taxType'];
                $markupType = $entranceQuotData['markupType'];
                $markupCost = $entranceQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($entranceQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($entranceData['entranceName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($entranceQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='ferry'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($ferryQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$ferryQuotData['ferryNameId'].'"');
                $ferryData=mysqli_fetch_array($d);
                
                $taxSlabId = $ferryQuotData['gstTax'];
                $taxType = $ferryQuotData['taxType'];
                $markupType = $ferryQuotData['markupType'];
                $markupCost = $ferryQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($ferryQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($ferryData['name']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($ferryQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='activity'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($activityQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activityQuotData['otherActivityName'].'"');
                $activityData=mysqli_fetch_array($d);
                
                $taxSlabId = $activityQuotData['gstTax'];
                $taxType = $activityQuotData['taxType'];
                $markupType = $activityQuotData['markupType'];
                $markupCost = $activityQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($activityQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($activityData['otherActivityName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($activityQuotData['otherActivityCity']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='train'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($trainQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$trainQuotData['trainId'].'"');
                $trainData=mysqli_fetch_array($d);
                
                $taxSlabId = $trainQuotData['gstTax'];
                $taxType = $trainQuotData['taxType'];
                $markupType = $trainQuotData['markupType'];
                $markupCost = $trainQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($trainQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($trainData['trainName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($trainQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='flight'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($flightQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$flightQuotData['flightId'].'"');
                $flightData=mysqli_fetch_array($d);
                
                $taxSlabId = $flightQuotData['gstTax'];
                $taxType = $flightQuotData['taxType'];
                $markupType = $flightQuotData['markupType'];
                $markupCost = $flightQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($flightQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($flightData['flightName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($flightQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="Airlines" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='guide'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($guideQuotData=mysqli_fetch_array($c)){
                // hotel data
                $d='';
                $d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$guideQuotData['guideId'].'"');
                $guideData=mysqli_fetch_array($d);
                
                $taxSlabId = $guideQuotData['gstTax'];
                $taxType = $guideQuotData['taxType'];
                $markupType = $guideQuotData['markupType'];
                $markupCost = $guideQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($guideQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($guideData['name']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($guideQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="'.ucfirst($serviceType).'" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='mealplan'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($mealplanQuotData=mysqli_fetch_array($c)){
                // hotel data
              
                $taxSlabId = $mealplanQuotData['gstTax'];
                $taxType = $mealplanQuotData['taxType'];
                $markupType = $mealplanQuotData['markupType'];
                $markupCost = $mealplanQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($mealplanQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($mealplanQuotData['mealPlanName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($mealplanQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            if($serviceType=='additional'){
              $c='';
              $c=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
              while($EXTRAQuotData=mysqli_fetch_array($c)){
                // hotel data
                
                $taxSlabId = $EXTRAQuotData['gstTax'];
                $taxType = $EXTRAQuotData['taxType'];
                $markupType = $EXTRAQuotData['markupType'];
                $markupCost = $EXTRAQuotData['markupCost'];

                ?>
                <tr id="selectedcon<?php echo $uniq_Id; ?>">
                  <td align="left" ><div style="width:70px;"><?php echo date('d-m-Y',strtotime($EXTRAQuotData['fromDate']));?></div></td>
                  <td align="left" ><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                  <td align="left" ><strong>&nbsp;</strong><?php echo ucfirst($EXTRAQuotData['name']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($EXTRAQuotData['destinationId']);  ?>&nbsp;)</td>
                  <td align="center">
                    <select name="markupType<?php echo $uniq_Id; ?>" id="markupType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type">
                      <option value="1" <?php if($markupType==1){ ?>selected="selected"<?php } ?>>%</option>
                      <option value="2" <?php if($markupType==2){ ?>selected="selected"<?php } ?>>Flat</option>
                    </select>
                  </td>
                  <td align="left" ><input type="text" name="markupCost<?php echo $uniq_Id; ?>" id="markupCost<?php echo $uniq_Id; ?>" value="<?php echo $markupCost; ?>" class="markInput digit_only"></td>
                  <td align="center">
                    <select name="taxType<?php echo $uniq_Id; ?>" id="taxType<?php echo $uniq_Id; ?>" class="gridfield validate" displayname="Markup Type" style="max-width: 100px;">
                      <option value="1"<?php if($taxType==1){ ?>selected="selected"<?php } ?>>Total Cost</option>
                      <option value="2"<?php if($taxType==2){ ?>selected="selected"<?php } ?>>Markup Only</option>
                    </select>
                  </td>
                  <td align="center">
                    <select id="gstTax<?php echo $uniq_Id; ?>" name="gstTax<?php echo $uniq_Id; ?>" class="gridfield" displayname="GST" style="max-width: 100px;">
                      <?php 
                      $serviceTaxSQuery="";
                      $serviceTaxSQuery=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
                      while($serviceTaxSlab=mysqli_fetch_array($serviceTaxSQuery)){
                        ?><option value="<?php echo $serviceTaxSlab['id'];?>" <?php if ($serviceTaxSlab['id'] == $taxSlabId){ ?>selected<?php } ?>><?php echo $serviceTaxSlab['gstSlabName'];?>&nbsp;(<?php echo $serviceTaxSlab['gstValue'];?>)</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td  align="center"><input type="button" onclick="updateSWMGst('<?php echo $uniq_Id; ?>','<?php echo $serviceType; ?>','<?php echo $serviceId; ?>')" value="Save" id="saveSWMG<?php echo $uniq_Id;?>" class="whitembutton customized saveSWMG" ></td>
                </tr>
                <?php
              }
            }
            // end quoation itinerary loop
          }
          ?>
          </tbody>
          </table>
          <?php 
        } ?>
        <div style="display:none;visibility: hidden;" id="loadsaveSWMGst"></div>
        <script type="text/javascript">
          function updateSWMGst(uni_id,serviceType,serviceId){
              var markupType = encodeURI($('#markupType'+uni_id).val());
              var markupCost = encodeURI($('#markupCost'+uni_id).val());
              var taxType = encodeURI($('#taxType'+uni_id).val());
              var gstTax = encodeURI($('#gstTax'+uni_id).val());
              
              $('#loadsaveSWMGst').load('final_frmaction.php?action=updateSWMGst&quotationId=<?php echo $quotationId; ?>&serviceId='+serviceId+'&serviceType='+serviceType+'&markupType='+markupType+'&markupCost='+markupCost+'&taxType='+taxType+'&gstTax='+gstTax);

              var sType = serviceType.charAt(0).toUpperCase() + serviceType.slice(1);
              warningalert(sType+' Updated!');
              $('#saveSWMG'+uni_id).val('Saved');
              $('#saveSWMG'+uni_id).addClass('saved');
          }
          function updateHotelSWMGst(uni_id,serviceType,serviceId,dayId){
              var markupType = encodeURI($('#markupType'+uni_id).val());
              // var markupCost = encodeURI($('#markupCost'+uni_id).val());

              var sglMarkup = encodeURI($('#sglMarkup'+uni_id).val());
              var dblMarkup = encodeURI($('#dblMarkup'+uni_id).val());
              var twinMarkup = encodeURI($('#twinMarkup'+uni_id).val());
              var tplMarkup = encodeURI($('#tplMarkup'+uni_id).val());
              var quadMarkup = encodeURI($('#quadMarkup'+uni_id).val());
              var sixMarkup = encodeURI($('#sixMarkup'+uni_id).val());
              var eightMarkup = encodeURI($('#eightMarkup'+uni_id).val());
              var tenMarkup = encodeURI($('#tenMarkup'+uni_id).val());
              var teenMarkup = encodeURI($('#teenMarkup'+uni_id).val());

              var exMarkup = encodeURI($('#exMarkup'+uni_id).val());
              var cwbMarkup = encodeURI($('#cwbMarkup'+uni_id).val());
              var cnbMarkup = encodeURI($('#cnbMarkup'+uni_id).val());
              var mealMarkup = encodeURI($('#mealMarkup'+uni_id).val());

              var taxType = encodeURI($('#taxType'+uni_id).val());
              var gstTax = encodeURI($('#gstTax'+uni_id).val());
              
              $('#loadsaveSWMGst').load('final_frmaction.php?action=updateSWMGst&quotationId=<?php echo $quotationId; ?>&serviceId='+serviceId+'&serviceType='+serviceType+'&markupType='+markupType+'&sglMarkup='+sglMarkup+'&dblMarkup='+dblMarkup+'&twinMarkup='+twinMarkup+'&tplMarkup='+tplMarkup+'&quadMarkup='+quadMarkup+'&sixMarkup='+sixMarkup+'&eightMarkup='+eightMarkup+'&tenMarkup='+tenMarkup+'&teenMarkup='+teenMarkup+'&exMarkup='+exMarkup+'&cwbMarkup='+cwbMarkup+'&cnbMarkup='+cnbMarkup+'&mealMarkup='+mealMarkup+'&taxType='+taxType+'&gstTax='+gstTax+'&dayId='+dayId);
              // markupCost='+markupCost+'&
              var sType = serviceType.charAt(0).toUpperCase() + serviceType.slice(1);
              warningalert(sType+' Updated!');
              $('#saveSWMG'+uni_id).val('Saved');
              $('#saveSWMG'+uni_id).addClass('saved');
          }
          function updateSWMG(){
            $('.saveSWMG').click();
            setTimeout(function(){
              // alert('All Services Updated Successfully!!');
            }, 1000);
          }
        </script> 
        <style type="text/css">
         .whitembutton.customized{ 
            padding: 4px 15px;
            border-radius: 2px;  
          }
          .saved{
            border: 1px solid #4caf50; 
            color: #ffffff; 
            background-color: #4caf50; 
          }
        </style>
    </td>
  </tr> 
</tbody>
</table>