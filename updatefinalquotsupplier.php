<?php
include "inc.php";
$type          = $_REQUEST['type'];
$QuotId        = $_REQUEST['QuotId'];
$supplierId    = $_REQUEST['supplierId'];
$serviceId     = $_REQUEST['serviceId'];
$rsp           = "";
$rsp           = GetPageRecord('*', _QUOTATION_MASTER_, 'id="' . $_REQUEST['quotationId'] . '"');
$quotationData = mysqli_fetch_array($rsp);
$quotationId   = $quotationData['id'];
$queryId       = $quotationData['queryId'];
$pax           = ($quotationData['adult'] + $quotationData['child']);
$costType      = $quotationData['costType'];
$calculationType= $quotationData['calculationType'];
$discountType  = $quotationData['discountType'];
$discountTax   = $quotationData['discount'];
//slab Date
$slabSql       = "";
// $slabSql       = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and "' . $pax . '" BETWEEN fromRange and toRange and status=1');
$slabSql       = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1');
if (mysqli_num_rows($slabSql) > 0) {
    $slabsData = mysqli_fetch_array($slabSql);
    $slabId    = $slabsData['id'];
    $dfactor   = $slabsData['dividingFactor'];
}
$fqsSql = "";
$fqsSql = GetPageRecord('*', 'finalQuotSupplierStatus', ' 1 and supplierId="' . $supplierId . '" and quotationId="' . $quotationId . '"');
if (mysqli_num_rows($fqsSql) == 0) {
  $namevaluesup = 'supplierId="' . $supplierId . '", quotationId="' . $_REQUEST['quotationId'] . '"';
  addlisting('finalQuotSupplierStatus', $namevaluesup);
}

if ($type == 'visa') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and visaNameId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteVisa', $namevalue, $where);
}
if ($type == 'passport') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and passportNameId="' . $serviceId . '"';
    $update    = updatelisting('finalQuotePassport', $namevalue, $where);
}
if ($type == 'insurance') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and insuranceNameId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteInsurance', $namevalue, $where);
}
if ($type == 'hotel') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'quotationId="' . $quotationData['id'] . '" and hotelId="' . $serviceId . '" and supplierId=0';
    $update    = updatelisting('finalQuote', $namevalue, $where);
}
if ($type == 'transfer') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and transferId="' . $serviceId . '"';
    $update    = updatelisting('finalQuotetransfer', $namevalue, $where);
}
if ($type == 'entrance') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and entranceId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteEntrance', $namevalue, $where);
}
if ($type == 'ferry') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and ferryId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteFerry', $namevalue, $where);
}
if ($type == 'activity') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and activityId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteActivity', $namevalue, $where);
}
if ($type == 'train') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and trainId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteTrains', $namevalue, $where);
}
if ($type == 'flight') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and flightId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteFlights', $namevalue, $where);
}
if ($type == 'guide') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and guideId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteGuides', $namevalue, $where);
}
if ($type == 'meal') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and mealplanQuotationId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteMealPlan', $namevalue, $where);
}
if ($type == 'additional') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and additionalId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteExtra', $namevalue, $where);
}
if ($type == 'enrout') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="' . $QuotId . '" and enrouteId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteEnroute', $namevalue, $where);
}

if ($type == 'cruise') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = 'id="'.$QuotId.'" and cruisePackageId="' . $serviceId . '"';
    $update    = updatelisting('finalQuoteCruise', $namevalue, $where);
}

// if type is package then update to packageWiseRateMaster table
if ($type == 'package') {
    $namevalue = 'supplierId="' . $supplierId . '"';
    $where     = '1 and id="'.$QuotId.'" and quotationId="'.$quotationId .'"';
    $update    = updatelisting('finalPackWiseRateMaster', $namevalue, $where);

    $update    = updatelisting('finalQuote', $namevalue, $where);
    $update    = updatelisting('finalQuotetransfer', $namevalue, $where);
    $update    = updatelisting('finalQuoteEntrance', $namevalue, $where);
    $update    = updatelisting('finalQuoteFerry', $namevalue, $where);
    $update    = updatelisting('finalQuoteActivity', $namevalue, $where);
    $update    = updatelisting('finalQuoteTrains', $namevalue, $where);
    $update    = updatelisting('finalQuoteGuides', $namevalue, $where);
    $update    = updatelisting('finalQuoteMealPlan', $namevalue, $where);
    $update    = updatelisting('finalQuoteExtra', $namevalue, $where);
    $update    = updatelisting('finalQuoteEnroute', $namevalue, $where);
    $update    = updatelisting('finalQuoteFlights', $namevalue, $where);
    $update    = updatelisting('finalQuoteCruise', $namevalue, $where);
}
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
<thead>
<tr>  
<th align="left" bgcolor="#ddd">Assigned Services</th>
</tr>
</thead>
<tbody > 
<tr>
<td width="100%" align="left" valign="top" style="padding:10px !important; ">
<div style="font-size:15px;padding:0px; margin-bottom:10px; position:relative;">
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
<thead>
<tr>
<th width="10%" align="left"  bgcolor="#F4F4F4"><strong>Service&nbsp;Date</strong></th>
<th width="5%" align="left"  bgcolor="#F4F4F4"><strong>Type</strong></th>
<th width="60%" align="left"  bgcolor="#F4F4F4"><strong>Service&nbsp;Name</strong></th>
<th width="20%"  bgcolor="#F4F4F4" align="left"><strong>Select&nbsp;Supplier</strong></th>
<th width="5%"  bgcolor="#F4F4F4"><strong>Action</strong></th>
</tr> 
</thead>
<tbody>
<?php
if ($calculationType <> 3) {
  $b = "";
  $b = GetPageRecord('*', 'finalQuote', ' quotationId="' . $quotationId . '" and supplierId!=0 group by hotelId,supplierId,destinationId,fromDate order by fromDate asc');

  while ($finalQuotData = mysqli_fetch_array($b)) {
      $d         = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, ' id="' . $finalQuotData['hotelId'] . '"');
      $hotelData = mysqli_fetch_array($d);
      if ($finalQuotData['supplierId'] != '' && $finalQuotData['supplierId'] != 0) {
          $supplierId = $finalQuotData['supplierId'];
      }
      $hotelTypeLable = '';
      if ($finalQuotData['isLocalEscort'] == 1) {
          $hotelTypeLable .= "Local Escort,";
      }
      if ($finalQuotData['isForeignEscort'] == 1) {
          $hotelTypeLable .= "Foreign Escort,";
      }
      if ($finalQuotData['isGuestType'] == 1) {
          $hotelTypeLable .= "Hotel,";
      }
      $bbc          = GetPageRecord('*', 'hotelCategoryMaster', ' id="' . $hotelData['hotelCategoryId'] . '"');
      $hcData       = mysqli_fetch_array($bbc);
      $g            = "";
      $g            = GetPageRecord('*', _ROOM_TYPE_MASTER_, 'id="' . $finalQuotData['roomType'] . '"');
      $roomTypeData = mysqli_fetch_array($g);
      $rType        = $roomTypeData['name'];
      $g            = "";
      $g            = GetPageRecord('*', _MEAL_PLAN_MASTER_, 'id="' . $finalQuotData['mealPlanId'] . '"');
      $mealData     = mysqli_fetch_array($g);
      //.'-'.$mealData['subname']
      $mealplan     = $mealData['name'];
      //check if supplier is self  ?>  
      
      <tr id="selectedcon<?php
      echo $finalQuotData['id']; ?>">
        <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuotData['fromDate'])); ?></td>
        <td align="left" ><strong><?php
      echo rtrim($hotelTypeLable, ',') . "&nbsp;Hotel"; ?>&nbsp;</strong></td>
        <td align="left" ><?php
      echo strip($hotelData['hotelName']); ?>/<?php
      echo $rType; ?>/<?php
      echo $mealplan; ?>&nbsp;(&nbsp;<?php
      echo $hcity = strip($hotelData['hotelCity']); ?>&nbsp;)&nbsp;|&nbsp;<?php
      echo trim($hcData['hotelCategory']) . ' Star'; ?></td>
         <td align="center"> <select class="select" id="supplier<?php
      echo $finalQuotData['id']; ?>" style="width:300px; padding:5px;"  >
        <!-- <option value="">Select&nbsp;Supplier</option> -->
        <?php
      $bb            = '';
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and companyTypeId=1 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
       <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected" <?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
        
        </select></td>
         <td  align="center"><input type="button"  onclick="unassignedServices('<?php
      echo $finalQuotData['quotationId']; ?>','<?php
      echo $finalQuotData['id']; ?>','<?php
      echo $finalQuotData['hotelId']; ?>','hotel')"  style="background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuotData['id']; ?>" value="<?php
      if ($supplierId != '') {
          echo 'Change';
      } else {
          echo 'Select';
      } ?>" ></td>
      </tr>
      <?php
  }  

  $bit = GetPageRecord('*', 'finalquotationItinerary', ' quotationId="' . $quotationId . '"  order by startDate asc');
  while ($itineraryDetail = mysqli_fetch_array($bit)) {
      if ($itineraryDetail['serviceType'] == 'transportation') {
          $btr = GetPageRecord('*', 'finalQuotetransfer', ' quotationId="' . $itineraryDetail['quotationId'] . '" and id="' . $itineraryDetail['serviceId'] . '" and totalPax="' . $slabId . '" and supplierId!=0  order by fromDate asc');
          while ($finalQuotTransfer = mysqli_fetch_array($btr)) {
              $c                = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' id="' . $finalQuotTransfer['transferQuotationId'] . '"  order by fromDate asc');
              $transferQuotData = mysqli_fetch_array($c);
              // hotel data
              $d                = GetPageRecord('*', 'packageBuilderTransportMaster', ' id="' . $transferQuotData['transferNameId'] . '"');
              $transferData     = mysqli_fetch_array($d);
              $d                = GetPageRecord('*', 'vehicleMaster', 'id="' . $transferQuotData['vehicleModelId'] . '"');
              $vehicleData      = mysqli_fetch_array($d);
              if ($finalQuotTransfer['supplierId'] != '' && $finalQuotTransfer['supplierId'] != 0) {
                  $supplierId = $finalQuotTransfer['supplierId'];
              }
              //check if supplier is self  ?>
           <tr id="selectedcon<?php
              echo $finalQuotTransfer['id']; ?>">
              <td align="left" ><?php
              echo date('d-m-Y', strtotime($finalQuotTransfer['fromDate'])); ?></td>
              <td align="left" >Transportation</td>
              <td align="left" ><strong>&nbsp;</strong><?php
              echo strip($transferData['transferName']); ?>&nbsp;(&nbsp;<?php
              echo $hcity = getDestination($transferQuotData['destinationId']); ?>&nbsp;)</td>
               <td align="center"> <select class="select" id="supplier<?php
              echo $finalQuotTransfer['id']; ?>" style="width:300px; padding:5px;">
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
              $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0  and status=1 and name!="" and transferType=5 order by name');
              $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
              echo $suppliersData['id']; ?>" <?php
              if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
              } ?>><?php
              echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
          
              </select></td>
               <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php
              echo $finalQuotTransfer['quotationId']; ?>','<?php
              echo $finalQuotTransfer['id']; ?>','<?php
              echo $finalQuotTransfer['transferId']; ?>','transfer')" value="<?php
              if ($supplierId != '') {
                  echo 'Change';
              } else {
                  echo 'Select';
              } ?>" style="    background-color: <?php
              if ($supplierId != '') {
                  echo 'green';
              } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
              echo $finalQuotTransfer['id']; ?>"></td>
            </tr>
        <?php
          }
      }
      if ($itineraryDetail['serviceType'] == 'transfer') {
          $btran = GetPageRecord('*', 'finalQuotetransfer', ' quotationId="' . $itineraryDetail['quotationId'] . '" and id="' . $itineraryDetail['serviceId'] . '" and totalPax="' . $slabId . '"  and supplierId!=0  order by fromDate asc');
          while ($finalQuotTransfer = mysqli_fetch_array($btran)) {
              $c                = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' id="' . $finalQuotTransfer['transferQuotationId'] . '"  order by fromDate asc');
              $transferQuotData = mysqli_fetch_array($c);
              // hotel data
              $d                = GetPageRecord('*', 'packageBuilderTransportMaster', ' id="' . $transferQuotData['transferNameId'] . '"');
              $transferData     = mysqli_fetch_array($d);
              if ($finalQuotTransfer['supplierId'] != '' && $finalQuotTransfer['supplierId'] != 0) {
                  $supplierId = $finalQuotTransfer['supplierId'];
              }
              //check if supplier is self 
              $vehicleName = $vehicleType = $trnsferType = '';
              if ($transferQuotData['transferType'] == 2) {
                  $d           = GetPageRecord('*', 'vehicleMaster', 'id="' . $transferQuotData['vehicleModelId'] . '"');
                  $vehicleData = mysqli_fetch_array($d);
                  $vehicleName = $vehicleData['model'] . " | ";
                  $vehicleType = getVehicleTypeName($vehicleData['carType']) . " | ";
              }
              $trnsferType = ($transferQuotData['transferType'] == 1) ? 'SIC | ' : 'Private | '; ?>
       <tr id="selectedcon<?php
              echo $finalQuotTransfer['id']; ?>">
        <td align="left" ><?php
              echo date('d-m-Y', strtotime($finalQuotTransfer['fromDate'])); ?></td>
        <td align="left" >Transfer</td>
        <td align="left" ><strong>&nbsp;</strong><?php
              echo $trnsferType . $vehicleType . $vehicleName . strip($transferData['transferName']); ?>&nbsp;(&nbsp;<?php
              echo $hcity = getDestination($transferQuotData['destinationId']); ?>&nbsp;)</td>
        <td align="center"> <select class="select" id="supplier<?php
              echo $finalQuotTransfer['id']; ?>" style="width:300px; padding:5px;">
        <!-- <option value="">Select&nbsp;Supplier</option> -->
        <?php
              $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and transferType=5 order by name');
              $suppliersData = mysqli_fetch_array($bb); ?>
       <option value="<?php
              echo $suppliersData['id']; ?>" <?php
              if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
              } ?>><?php
              echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>

        </select></td>
        <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php
              echo $finalQuotTransfer['quotationId']; ?>','<?php
              echo $finalQuotTransfer['id']; ?>','<?php
              echo $finalQuotTransfer['transferId']; ?>','transfer')" value="<?php
              if ($supplierId != '') {
                  echo 'Change';
              } else {
                  echo 'Select';
              } ?>" style="    background-color: <?php
              if ($supplierId != '') {
                  echo 'green';
              } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
              echo $finalQuotTransfer['id']; ?>"></td>
        </tr>
        <?php
          }
      }
  }


  $b = "";
  $b = GetPageRecord('*', 'finalQuoteEntrance', ' quotationId="' . $quotationId . '" and supplierId!=0 order by fromDate asc');
  while ($finalQuoteEntranceData = mysqli_fetch_array($b)) {
      $b2               = GetPageRecord('*', _QUOTATION_ENTRANCE_MASTER_, 'id="' . $finalQuoteEntranceData['entranceQuotationId'] . '"  order by fromDate asc');
      $entranceQuotData = mysqli_fetch_array($b2);
      $d                = GetPageRecord('*', _PACKAGE_BUILDER_ENTRANCE_MASTER_, ' id="' . $entranceQuotData['entranceNameId'] . '"');
      $entranceData     = mysqli_fetch_array($d);
      if ($finalQuoteEntranceData['supplierId'] != '' && $finalQuoteEntranceData['supplierId'] != 0) {
          $supplierId = $finalQuoteEntranceData['supplierId'];
      }
      $vehicleName = $vehicleType = $trnsferType = '';
      if ($entranceQuotData['transferType'] == 2) {
          $d           = GetPageRecord('*', 'vehicleMaster', 'id="' . $entranceQuotData['vehicleId'] . '"');
          $vehicleData = mysqli_fetch_array($d);
          $vehicleName = $vehicleData['model'] . " | ";
          $vehicleType = getVehicleTypeName($vehicleData['carType']) . " | ";
      }
      // $trnsferType = ($entranceQuotData['transferType'] == 1)?'SIC | ':'Private | ';
      if ($entranceQuotData['transferType'] == 1) {
          $transferType = 'SIC | ';
      } elseif ($entranceQuotData['transferType'] == 2) {
          $transferType = 'Private | ';
      } else {
          $transferType = 'Ticket Only | ';
      } ?>
     <tr id="selectedcon<?php
      echo $finalQuoteEntranceData['id']; ?>">
      <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteEntranceData['fromDate'])); ?></td>
      <td align="left" >Entrance</td>
      <td align="left"><strong>&nbsp;</strong><?php
      echo $transferType . $vehicleType . $vehicleName . strip($entranceData['entranceName']); ?>&nbsp;(&nbsp;<?php
      echo $hcity = strip($entranceData['entranceCity']); ?>&nbsp;)</td>
      <td align="center"> <select class="select" id="supplier<?php
      echo $finalQuoteEntranceData['id']; ?>" style="width:300px; padding:5px;"  >
      <!-- <option value="">Select&nbsp;Supplier</option> -->
      <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and entranceType=4 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
     <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
      
      </select></td>
      <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php
      echo $finalQuoteEntranceData['quotationId']; ?>','<?php
      echo $finalQuoteEntranceData['id']; ?>','<?php
      echo $finalQuoteEntranceData['entranceId']; ?>','entrance')" value="<?php
      if ($supplierId != '') {
          echo 'Change';
      } else {
          echo 'Select';
      } ?>" style="background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuoteEntranceData['id']; ?>"></td>

      </tr>
    <?php
  } 

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteFerry', ' quotationId="' . $quotationId . '" and supplierId!=0 order by fromDate asc');
  while ($finalQuoteFerryData = mysqli_fetch_array($b)) {
      $d         = GetPageRecord('*', _FERRY_SERVICE_PRICE_MASTER_, ' id="' . $finalQuoteFerryData['ferryId'] . '"');
      $ferryData = mysqli_fetch_array($d);
      if ($finalQuoteFerryData['supplierId'] != '' && $finalQuoteFerryData['supplierId'] != 0) {
          $supplierId = $finalQuoteFerryData['supplierId'];
      } ?>
       <tr id="selectedcon<?php
      echo $finalQuoteFerryData['id']; ?>">
        <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteFerryData['fromDate'])); ?></td>
        <td align="left" >Ferry</td>
        <td align="left"><strong>&nbsp;</strong><?php
      echo strip($ferryData['name']); ?>&nbsp;(&nbsp;<?php
      echo getDestination($finalQuoteFerryData['destinationId']); ?>&nbsp;)</td>
        <td align="center"> <select class="select" id="supplier<?php
      echo $finalQuoteFerryData['id']; ?>" style="width:300px; padding:5px;"  >
        <!-- <option value="">Select&nbsp;Supplier</option> -->
        <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and ferryType=10 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
       <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
        
        </select></td>
        <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php
      echo $finalQuoteFerryData['quotationId']; ?>','<?php
      echo $finalQuoteFerryData['id']; ?>','<?php
      echo $finalQuoteFerryData['ferryId']; ?>','ferry')" value="<?php
      if ($supplierId != '') {
          echo 'Change';
      } else {
          echo 'Select';
      } ?>" style="background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuoteFerryData['id']; ?>"></td>
        </tr>
      <?php
  }

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteActivity', ' quotationId="' . $quotationId . '"  and supplierId!=0 order by fromDate asc');
  while ($finalQuoteActivityData = mysqli_fetch_array($b)) {
      $dsssss           = GetPageRecord('*', _QUOTATION_OTHER_ACTIVITY_MASTER_, ' id="' . $finalQuoteActivityData['activityQuotationId'] . '" and quotationId="' . $quotationId . '"  order by fromDate asc');
      $activityQuotData = mysqli_fetch_array($dsssss);
      $d                = GetPageRecord('*', 'dmcotherActivityRate', ' otherActivityNameId="' . $activityQuotData['otherActivityName'] . '"');
      $dmcActivityData  = mysqli_fetch_array($d);
      $d12              = GetPageRecord('*', 'packageBuilderotherActivityMaster', ' id="' . $finalQuoteActivityData['activityId'] . '"');
      $activityData     = mysqli_fetch_array($d12);
      if ($finalQuoteActivityData['supplierId'] != '' && $finalQuoteActivityData['supplierId'] != 0) {
          $supplierId = $finalQuoteActivityData['supplierId'];
      }
      if ($finalQuoteActivityData['transferType'] == 1) {
          $transferType = 'SIC';
      } elseif ($finalQuoteActivityData['transferType'] == 2) {
          $transferType = 'PVT';
      } elseif ($finalQuoteActivityData['transferType'] == 3) {
          $transferType = 'VIP';
      } elseif ($finalQuoteActivityData['transferType'] == 4) {
          $transferType = 'Ticket Only';
      } ?>  
            <tr id="selectedcon<?php
      echo $finalQuoteActivityData['id']; ?>">
              <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteActivityData['fromDate'])); ?></td>
              <td align="left" >Sightseeing</td>
              <td align="left"><strong>&nbsp;</strong><?php
      echo $transferType . ' | ' . strip($activityData['otherActivityName']); ?>&nbsp;(&nbsp;<?php
      echo $hcity = strip($activityData['otherActivityCity']); ?>&nbsp;)</td> 
              <td align="center"><select class="select" id="supplier<?php
      echo $finalQuoteActivityData['id']; ?>" style="width:300px; padding:5px;"  >
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and activityType=3 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
              
              </select></td>  
               <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php
      echo $finalQuoteActivityData['quotationId']; ?>','<?php
      echo $finalQuoteActivityData['id']; ?>','<?php
      echo $finalQuoteActivityData['activityId']; ?>','activity')"  value="<?php
      if ($supplierId != '') {
          echo 'Change';
      } else {
          echo 'Select';
      } ?>" style="background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuoteActivityData['id']; ?>"></td>  
            </tr>
             <?php
  }  

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteTrains', ' quotationId="' . $quotationId . '"  and supplierId!=0 order by fromDate asc');
  while ($finalQuoteTrainData = mysqli_fetch_array($b)) {
      $e             = GetPageRecord('*', _QUOTATION_TRAINS_MASTER_, 'id="' . $finalQuoteTrainData['trainQuotationId'] . '" and quotationId="' . $quotationId . '" order by id desc');
      $trainQuotData = mysqli_fetch_array($e);
      $d23           = GetPageRecord('*', _PACKAGE_BUILDER_TRAINS_MASTER_, 'id="' . $trainQuotData['trainId'] . '"');
      $trainData     = mysqli_fetch_array($d23);
      if ($finalQuoteTrainData['supplierId'] != '' && $finalQuoteTrainData['supplierId'] != 0) {
          $supplierId = $finalQuoteTrainData['supplierId'];
      } ?>
           <tr id="selectedcon<?php
      echo $finalQuoteTrainData['id']; ?>">
              <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteTrainData['fromDate'])); ?></td>
              <td align="left" >Train</td>
              <td align="left" ><strong>&nbsp;</strong><?php
      echo ucfirst(strip($trainData['trainName'])); ?>&nbsp;(&nbsp;<?php
      echo getDestination($trainQuotData['destinationId']); ?>&nbsp;) </td>
               <td align="center"> <select class="select" id="supplier<?php
      echo $finalQuoteTrainData['id']; ?>" style="width:300px; padding:5px;" >
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and trainType=8 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
              
              </select></td>
            <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php echo $finalQuoteTrainData['quotationId']; ?>','<?php echo $finalQuoteTrainData['id']; ?>','<?php echo $finalQuoteTrainData['trainId']; ?>','train')"  value="<?php if ($supplierId != '') { echo 'Change'; } else{ echo 'Select'; } ?>" style="background-color: <?php if ($supplierId != '') {
          echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php echo $finalQuoteTrainData['id']; ?>"></td>
            </tr>
            <?php
  }  

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteFlights', 'quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc');
  while ($finalQuoteFlightData = mysqli_fetch_array($b)){
      $f = GetPageRecord('*', _QUOTATION_FLIGHT_MASTER_, 'id="'.$finalQuoteFlightData['flightQuotationId'] . '" and quotationId="'.$quotationId.'" order by id desc');
      $flightQuotData = mysqli_fetch_array($f);
      $d = GetPageRecord('*', _PACKAGE_BUILDER_FLIGHT_MASTER_, 'id="' . $flightQuotData['flightId'] . '"');
      $flightData = mysqli_fetch_array($d);
      $Ecity = getDestination($flightQuotData['destinationId']);
      if ($finalQuoteFlightData['supplierId']!='' && $finalQuoteFlightData['supplierId'] != 0){
          $supplierId = $finalQuoteFlightData['supplierId'];
      } ?>  
            <tr id="selectedcon<?php echo $finalQuoteFlightData['id']; ?>"> 
             <td align="left" ><?php echo date('d-m-Y', strtotime($finalQuoteFlightData['fromDate'])); ?></td>
              <td align="left" >Flight</td>
               <td align="left" ><strong>&nbsp;</strong><?php echo strip($flightData['flightName']); ?>&nbsp;(&nbsp;<?php echo $Ecity; ?>&nbsp;)</td>
               <td align="center"> 
                <select class="select" id="supplier<?php echo $finalQuoteFlightData['id']; ?>" style="width:300px; padding:5px;">
                <!-- <option value="">Select&nbsp;Supplier</option> -->
                <?php
                $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and airlinesType=7 order by name');
                $suppliersData = mysqli_fetch_array($bb); ?>
                       <option value="<?php echo $suppliersData['id']; ?>" <?php
                if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
                } ?>><?php echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
                </select>
              </td>
              <td  align="center"><input type="button" name=""  onclick="unassignedServices('<?php echo $finalQuoteFlightData['quotationId']; ?>','<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $finalQuoteFlightData['flightId']; ?>','flight')" value="<?php if ($supplierId != '') { echo 'Change'; } else { echo 'Select'; } ?>" style="background-color: <?php if($supplierId != '') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php echo $finalQuoteFlightData['id']; ?>"></td>
            </tr>
          <?php
  } 

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteGuides', ' quotationId="' . $quotationId . '" and supplierId!=0  order by fromDate asc');
  while ($finalQuoteGuideData = mysqli_fetch_array($b)) {
      $d         = GetPageRecord('*', _GUIDE_SUB_CAT_MASTER_, 'id="' . $finalQuoteGuideData['guideId'] . '"');
      $guideData = mysqli_fetch_array($d);
      $Ecity     = getDestination($finalQuoteGuideData['destinationId']);
      if ($finalQuoteGuideData['supplierId'] != '' && $finalQuoteGuideData['supplierId'] != 0) {
          $supplierId = $finalQuoteGuideData['supplierId'];
      } ?>
           <tr id="selectedcon<?php
      echo $finalQuoteGuideData['id']; ?>">
              <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteGuideData['fromDate'])); ?></td>
              <td align="left" ><?php
      if ($finalQuoteGuideData['serviceType'] == 1) {
          echo "Porter";
      } else {
          echo "Guide";
      } ?></td>
               <td align="left" ><strong>&nbsp;</strong><?php
      echo strip($guideData['name']); ?>&nbsp;(&nbsp;<?php
      echo $Ecity; ?>&nbsp;)</td>
               <td align="center"> <select class="select" id="supplier<?php
      echo $finalQuoteGuideData['id']; ?>" style="width:300px; padding:5px;">
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and guideType=2 order by name asc');
      $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
            
              </select></td>
               <td  align="center"><input type="button" onclick="unassignedServices('<?php echo $finalQuoteGuideData['quotationId']; ?>','<?php echo $finalQuoteGuideData['id']; ?>','<?php echo $finalQuoteGuideData['guideId']; ?>','guide')" name="" value="<?php if ($supplierId!='') { echo 'Change'; }else{ echo 'Select'; } ?>" style="background-color: <?php if ($supplierId!='') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php echo $finalQuoteGuideData['id']; ?>" ></td> 
            </tr>
        <?php
  } 

  $bm = GetPageRecord('*', 'finalQuoteMealPlan', ' quotationId="' . $quotationId . '" and supplierId!=0 order by fromDate asc');
  while ($finalQuoteMealData = mysqli_fetch_array($bm)) {
      $b            = GetPageRecord('*', _QUOTATION_INBOUND_MEAL_PLAN_MASTER_, 'id="' . $finalQuoteMealData['mealplanQuotationId'] . '" and quotationId="' . $quotationId . '" order by fromDate asc');
      $mealQuotData = mysqli_fetch_array($b);
      if ($finalQuoteMealData['supplierId'] != '' && $finalQuoteMealData['supplierId'] != 0) {
          $supplierId = $finalQuoteMealData['supplierId'];
      } ?>  
            <tr id="selectedcon<?php
      echo $finalQuoteMealData['id']; ?>">
              <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteMealData['fromDate'])); ?></td>
              <td align="left" >Restaurant</td>
              <td align="left" ><strong>&nbsp;</strong><?php
      echo strip($mealQuotData['mealPlanName']); ?>&nbsp;(&nbsp;<?php
      echo $hcity = getDestination($mealQuotData['destinationId']); ?>&nbsp;)</td>
               <td align="center"><select class="select" id="supplier<?php
      echo $finalQuoteMealData['id']; ?>" style="width:300px; padding:5px;">
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
      $bb = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and mealType=6 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
            
              </select></td>
               <td  align="center"><input type="button" onclick="unassignedServices('<?php echo $finalQuoteMealData['quotationId']; ?>','<?php echo $finalQuoteMealData['id']; ?>','<?php echo $finalQuoteMealData['mealplanQuotationId']; ?>','meal')" name="" value="<?php if($supplierId != '') { echo 'Change'; }else{ echo 'Select';} ?>" style="background-color: <?php if($supplierId != '') {
          echo 'green';} ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php echo $finalQuoteMealData['id']; ?>"></td></tr>
          <?php
  } 

  //   Cruise service
  $b = "";
  $b = GetPageRecord('*', 'finalQuoteCruise', 'quotationId="' . $quotationId . '" and supplierId!=0 order by fromDate asc');
  while ($finalQuoteCruiseData = mysqli_fetch_array($b)) {
    $bc3 = GetPageRecord('*', _CRUISE_MASTER_,' id="'.$finalQuoteCruiseData['cruisePackageId'].'" order by cruiseName asc');
    $cruiseData = mysqli_fetch_array($bc3);
    $d = GetPageRecord('*', 'extraQuotation', ' id="' . $additionalQuotData['additionalId'] . '"');
    $additionalData = mysqli_fetch_array($d);
    $Ecity = getDestination($finalQuoteCruiseData['destinationId']);
    if ($finalQuoteCruiseData['supplierId'] != '' && $finalQuoteCruiseData['supplierId'] != 0) {
        $supplierId = $finalQuoteCruiseData['supplierId'];
    } ?>  
    <tr id="selectedcon<?php echo $finalQuoteCruiseData['id']; ?>">
    <td align="left" ><?php echo date('d-m-Y', strtotime($finalQuoteCruiseData['fromDate'])); ?></td>
        <td align="left" >Cruise</td>
            <td align="left" ><strong>&nbsp;</strong><?php echo strip($cruiseData['cruiseName']); ?>&nbsp;(&nbsp;<?php echo $Ecity; ?>&nbsp;)</td>
                <td align="center"><select class="select" id="supplier<?php
        echo $finalQuoteCruiseData['id']; ?>" style="width:300px; padding:5px;">
                <!-- <option value="">Select&nbsp;Supplier</option> -->
                <?php
        $bbc = GetPageRecord('*', 'suppliersMaster', 'id="'.$supplierId.'" and deletestatus=0 and status=1 and name!="" and cruiseType=15 order by name');
        $suppliersData = mysqli_fetch_array($bbc); ?>
            <option value="<?php $suppliersData['id']; ?>" <?php
        if($supplierId == $suppliersData['id']) { ?> selected="selected"<?php } ?>><?php
        echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
                
        </select></td>
        <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php echo $finalQuoteCruiseData['quotationId']; ?>','<?php echo $finalQuoteCruiseData['id']; ?>','<?php echo $finalQuoteCruiseData['cruisePackageId']; ?>','cruise')" value="<?php
        if ($supplierId != '') { echo 'Change'; } else { echo 'Select'; } ?>" style="background-color: <?php
        if ($supplierId != '') { echo 'green';
        } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
        echo $finalQuoteCruiseData['id']; ?>"></td>
            </tr>
    <?php
  } 

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteExtra', ' quotationId="' . $quotationId . '" and supplierId!=0 order by fromDate asc');
  while ($finalQuoteAdditionalData = mysqli_fetch_array($b)) {
      $b3 = GetPageRecord('*', _QUOTATION_EXTRA_MASTER_, ' id="' . $finalQuoteAdditionalData['additionalQuotationId'].'" and quotationId="'.$quotationId.'" order by fromDate asc');
      $additionalQuotData = mysqli_fetch_array($b3);
      $d = GetPageRecord('*', 'extraQuotation', ' id="' .$additionalQuotData['additionalId'].'"');
      $additionalData = mysqli_fetch_array($d);
      $Ecity = getDestination($additionalQuotData['destinationId']);
      if ($finalQuoteAdditionalData['supplierId'] != '' && $finalQuoteAdditionalData['supplierId'] != 0) {
          $supplierId = $finalQuoteAdditionalData['supplierId'];
      } ?>  
            <tr id="selectedcon<?php
      echo $finalQuoteAdditionalData['id']; ?>">
              <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteAdditionalData['fromDate'])); ?></td>
              <td align="left" >Additional</td>
              <td align="left" ><strong>&nbsp;</strong><?php
      echo strip($additionalData['name']); ?>&nbsp;(&nbsp;<?php
      echo $Ecity; ?>&nbsp;)</td>
              <td align="center"><select class="select" id="supplier<?php
      echo $finalQuoteAdditionalData['id']; ?>" style="width:300px; padding:5px;">
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and otherType=13 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
              
              </select></td>
               <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php echo $finalQuoteAdditionalData['quotationId']; ?>','<?php echo $finalQuoteAdditionalData['id']; ?>','<?php echo $finalQuoteAdditionalData['additionalId']; ?>','additional')" value="<?php if ($supplierId != '') { echo 'Change'; }else { echo 'Select'; } ?>" style="background-color: <?php if ($supplierId != '') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php echo $finalQuoteAdditionalData['id']; ?>"></td>
            </tr>
          <?php
  } 

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteEnroute', ' quotationId="' . $quotationId . '" and supplierId!=0  order by fromDate asc');
  while ($finalQuoteEnrouteData = mysqli_fetch_array($b)) {
      $b4              = GetPageRecord('*', _QUOTATION_ENROUTE_MASTER_, ' id="' . $finalQuoteEnrouteData['enrouteQuotationId'] . '" and quotationId="' . $quotationId . '"  order by fromDate asc');
      $enrouteQuotData = mysqli_fetch_array($b4);
      $d               = GetPageRecord('*', _PACKAGE_BUILDER_ENROUTE_MASTER_, ' id="' . $enrouteQuotData['enrouteId'] . '"');
      $enrouteData     = mysqli_fetch_array($d);
      $Ecity           = getDestination($enrouteQuotData['destinationId']);
      if ($finalQuoteEnrouteData['supplierId'] != '' && $finalQuoteEnrouteData['supplierId'] != 0) {
          $supplierId = $finalQuoteEnrouteData['supplierId'];
      } ?>  
            <tr id="selectedcon<?php
      echo $finalQuoteEnrouteData['id']; ?>">
              <td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuoteEnrouteData['fromDate'])); ?></td>
              <td align="left" >Enroute</td>
              <td align="left" ><strong>&nbsp;</strong><?php
      echo strip($enrouteData['enrouteName']); ?>&nbsp;(&nbsp;<?php
      echo $Ecity; ?>&nbsp;)</td>
               <td align="center"><select class="select" id="supplier<?php
      echo $finalQuoteEnrouteData['id']; ?>" style="width:300px; padding:5px;">
              <!-- <option value="">Select&nbsp;Supplier</option> -->
              <?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="'.$supplierId.'" and deletestatus=0 and status=1 and name!="" and transferType=5 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
             <option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
            
              </select></td>
               <td  align="center"><input type="button" name="" onclick="unassignedServices('<?php echo $finalQuoteEnrouteData['quotationId']; ?>','<?php echo $finalQuoteEnrouteData['id']; ?>','<?php echo $finalQuoteEnrouteData['enrouteId']; ?>','enrout')" value="<?php
      if ($supplierId != '') {
          echo 'Change';
      } else {
          echo 'Select';
      } ?>" style="background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuoteEnrouteData['id']; ?>"></td>
            </tr>
          <?php
  } 
  
}else{

  $b = "";
  $b = GetPageRecord('*', 'finalPackWiseRateMaster', ' quotationId="' . $quotationId . '" and supplierId!=0 ');
  while ($pwrmData = mysqli_fetch_array($b)) {
    if ($pwrmData['supplierId'] != '' && $pwrmData['supplierId'] != 0) {
        $supplierName = getSupplierName($pwrmData['supplierId']);
    } ?>  
    <tr id="selectedcon<?php echo $pwrmData['id']; ?>">
      <td align="left" ><?php echo date('d-m-Y', strtotime($quotationData['fromDate'])); ?></td>
      <td align="left" >Package</td>
      <td align="left" ><strong>&nbsp;</strong><?php echo strip($quotationData['quotationSubject'].' - '.$pwrmData['serviceName']); ?></td>
      <td align="left"><?php echo strip($supplierName); ?></td>
      <td  align="left"><input type="button" name="" onclick="unassignedServices('<?php echo $pwrmData['quotationId']; ?>','<?php echo $pwrmData['id']; ?>','<?php echo $pwrmData['serviceType']; ?>','package')" value="<?php if ($supplierId != '') { echo 'Change'; } else { echo 'Select'; } ?>" style="background-color: <?php if ($supplierId != '') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php echo $pwrmData['id']; ?>">
     </td>
    </tr>
    <?php
  } 

  $b = "";
  $b = GetPageRecord('*', 'finalQuoteFlights', ' quotationId="'.$quotationId.'" and supplierId!=0 and isFlightTaken="yes" order by fromDate asc');
  while ($finalQuoteFlightData = mysqli_fetch_array($b)) {
      $f              = GetPageRecord('*', _QUOTATION_FLIGHT_MASTER_, 'id="' . $finalQuoteFlightData['flightQuotationId'] . '" and quotationId="' . $quotationId . '" order by id desc');
      $flightQuotData = mysqli_fetch_array($f);
      $d              = GetPageRecord('*', _PACKAGE_BUILDER_FLIGHT_MASTER_, 'id="' . $flightQuotData['flightId'] . '"');
      $flightData     = mysqli_fetch_array($d);
      $Ecity          = getDestination($flightQuotData['destinationId']);
      if ($finalQuoteFlightData['supplierId'] != '' && $finalQuoteFlightData['supplierId'] != 0) {
          $supplierId = $finalQuoteFlightData['supplierId'];
      } ?>  
            <tr id="selectedcon<?php echo $finalQuoteFlightData['id']; ?>"> 
             <td align="left" ><?php echo date('d-m-Y', strtotime($finalQuoteFlightData['fromDate'])); ?></td>
              <td align="left" >Flight</td>
               <td align="left" ><strong>&nbsp;</strong><?php echo strip($flightData['flightName']); ?>&nbsp;(&nbsp;<?php echo $Ecity; ?>&nbsp;)</td>
               <td align="center"> 
                <select class="select" id="supplier<?php echo $finalQuoteFlightData['id']; ?>" style="width:300px; padding:5px;">
                <!-- <option value="">Select&nbsp;Supplier</option> -->
                <?php
                $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and airlinesType=7 order by name');
                $suppliersData = mysqli_fetch_array($bb); ?>
                       <option value="<?php echo $suppliersData['id']; ?>" <?php
                if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
                } ?>><?php echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
                </select>
              </td>
              <td  align="center"><input type="button" name=""  onclick="unassignedServices('<?php echo $finalQuoteFlightData['quotationId']; ?>','<?php echo $finalQuoteFlightData['id']; ?>','<?php echo $finalQuoteFlightData['flightId']; ?>','flight')" value="<?php if ($supplierId != '') { echo 'Change'; } else { echo 'Select'; } ?>" style="background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuoteFlightData['id']; ?>"></td>
            </tr>
          <?php
  } 
  
  
  $btran = GetPageRecord('*', 'finalQuotetransfer', ' quotationId="'.$quotationId.'" and supplierId!=0 and isTransferTaken="yes"  order by fromDate asc');
  while ($finalQuotTransfer = mysqli_fetch_array($btran)) {
      $c                = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' id="' . $finalQuotTransfer['transferQuotationId'] . '"  order by fromDate asc');
      $transferQuotData = mysqli_fetch_array($c);
      // hotel data
      $d                = GetPageRecord('*', 'packageBuilderTransportMaster', ' id="' . $transferQuotData['transferNameId'] . '"');
      $transferData     = mysqli_fetch_array($d);
      if ($finalQuotTransfer['supplierId'] != '' && $finalQuotTransfer['supplierId'] != 0) {
          $supplierId = $finalQuotTransfer['supplierId'];
      }
      //check if supplier is self 
      $vehicleName = $vehicleType = $trnsferType = '';
      if ($transferQuotData['transferType'] == 2) {
          $d           = GetPageRecord('*', 'vehicleMaster', 'id="' . $transferQuotData['vehicleModelId'] . '"');
          $vehicleData = mysqli_fetch_array($d);
          $vehicleName = $vehicleData['model'] . " | ";
          $vehicleType = getVehicleTypeName($vehicleData['carType']) . " | ";
      }
      $trnsferType = ($transferQuotData['transferType'] == 1) ? 'SIC | ' : 'Private | '; ?>
<tr id="selectedcon<?php
      echo $finalQuotTransfer['id']; ?>">
<td align="left" ><?php
      echo date('d-m-Y', strtotime($finalQuotTransfer['fromDate'])); ?></td>
<td align="left" >Transfer</td>
<td align="left" ><strong>&nbsp;</strong><?php
      echo $trnsferType . $vehicleType . $vehicleName . strip($transferData['transferName']); ?>&nbsp;(&nbsp;<?php
      echo $hcity = getDestination($transferQuotData['destinationId']); ?>&nbsp;)</td>
<td align="center"> <select class="select" id="supplier<?php
      echo $finalQuotTransfer['id']; ?>" style="width:300px; padding:5px;">
<!-- <option value="">Select&nbsp;Supplier</option> -->
<?php
      $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and transferType=5 order by name');
      $suppliersData = mysqli_fetch_array($bb); ?>
<option value="<?php
      echo $suppliersData['id']; ?>" <?php
      if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
      } ?>><?php
      echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>

</select></td>
<td  align="center"><input type="button" name="" onclick="unassignedServices('<?php
      echo $finalQuotTransfer['quotationId']; ?>','<?php
      echo $finalQuotTransfer['id']; ?>','<?php
      echo $finalQuotTransfer['transferId']; ?>','transfer')" value="<?php
      if ($supplierId != '') {
          echo 'Change';
      } else {
          echo 'Select';
      } ?>" style="    background-color: <?php
      if ($supplierId != '') {
          echo 'green';
      } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
      echo $finalQuotTransfer['id']; ?>"></td>
</tr>
<?php
  }

}


// Final Quote Visa 
$b = "";
$b = GetPageRecord('*', 'finalQuoteVisa', ' quotationId="' . $quotationId . '" and  supplierId!=0 order by fromDate asc');
while ($finalQuoteVisaData = mysqli_fetch_array($b)) {

    $f            = GetPageRecord('*', _QUOTATION_VISA_MASTER_, 'id="' . $finalQuoteVisaData['visaQuotationId'] . '"');
    $visaQuotData = mysqli_fetch_array($f);

    $d            = GetPageRecord('*', _VISA_COST_MASTER_, 'id="' . $visaQuotData['serviceid'] . '"');
    $visaData     = mysqli_fetch_array($d);
    
    if ($finalQuoteVisaData['supplierId'] != '' && $finalQuoteVisaData['supplierId'] != 0) {
        $supplierId = $finalQuoteVisaData['supplierId'];
    } ?>  
                <tr id="selectedcon<?php
    echo $finalQuoteVisaData['id']; ?>"> 
                 <td align="left" ><?php
    echo date('d-m-Y', strtotime($finalQuoteVisaData['fromDate'])); ?></td>
                  <td align="left" >VISA</td>
                   <td align="left" ><strong>&nbsp;</strong><?php
    echo strip($visaData['name']); ?></td>
                   <td align="center"> <select class="select" id="supplier<?php
    echo $finalQuoteVisaData['id']; ?>" style="width:300px; padding:5px;">
                  <!-- <option value="">Select&nbsp;Supplier</option> -->
                  <?php
    $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and airlinesType=7 order by name');
    $suppliersData = mysqli_fetch_array($bb); ?>
                 <option value="<?php
    echo $suppliersData['id']; ?>" <?php
    if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
    } ?>><?php
    echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
                  
                  </select></td>
                   <td  align="center"><input type="button" name=""  onclick="unassignedServices('<?php echo $finalQuoteVisaData['quotationId']; ?>','<?php echo $finalQuoteVisaData['id']; ?>','<?php echo $finalQuoteVisaData['visaNameId']; ?>','visa')" value="<?php if ($supplierId != '') { echo 'Change'; } else { echo 'Select'; } ?>" style="background-color: <?php if ($supplierId != '') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
    echo $finalQuoteVisaData['id']; ?>"></td>
                </tr>
              <?php
}  

// Final Quote Passport 
$b = "";
$b = GetPageRecord('*', 'finalQuotePassport', ' quotationId="' . $quotationId . '" and  supplierId!=0 order by fromDate asc');
while ($finalQuotePassData = mysqli_fetch_array($b)) {
    $f            = GetPageRecord('*', _QUOTATION_PASSPORT_MASTER_, 'id="' . $finalQuotePassData['passportQuotationId'] . '" and quotationId="' . $quotationId . '" order by id desc');
    $passQuotData = mysqli_fetch_array($f);
    $d            = GetPageRecord('*', _PASSPORT_COST_MASTER_, 'id="' . $passQuotData['serviceid'] . '"');
    $passData     = mysqli_fetch_array($d);
    $Ecity        = getDestination($passQuotData['destinationId']);
    if ($finalQuotePassData['supplierId'] != '' && $finalQuotePassData['supplierId'] != 0) {
        $supplierId = $finalQuotePassData['supplierId'];
    } ?>  
                <tr id="selectedcon<?php
    echo $finalQuotePassData['id']; ?>"> 
                 <td align="left" ><?php
    echo date('d-m-Y', strtotime($finalQuotePassData['fromDate'])); ?></td>
                  <td align="left" >Passport</td>
                   <td align="left" ><strong>&nbsp;</strong><?php
    echo strip($passData['name']); ?></td>
                   <td align="center"> <select class="select" id="supplier<?php
    echo $finalQuotePassData['id']; ?>" style="width:300px; padding:5px;">
                  <!-- <option value="">Select&nbsp;Supplier</option> -->
                  <?php
    $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and airlinesType=7 order by name');
    $suppliersData = mysqli_fetch_array($bb); ?>
                 <option value="<?php
    echo $suppliersData['id']; ?>" <?php
    if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
    } ?>><?php
    echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
                  
                  </select></td>
                   <td  align="center"><input type="button" name=""  onclick="unassignedServices('<?php echo $finalQuotePassData['quotationId']; ?>','<?php echo $finalQuotePassData['id']; ?>','<?php echo $finalQuotePassData['passportNameId']; ?>','passport')" value="<?php if ($supplierId != '') {   echo 'Change'; }else { echo 'Select'; } ?>" style="background-color: <?php if ($supplierId != '') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
    echo $finalQuotePassData['id']; ?>"></td>
                </tr>
              <?php
}  

// Final Quote Insurance 
$b = "";
$b = GetPageRecord('*', 'finalQuoteInsurance', ' quotationId="' . $quotationId . '" and  supplierId!=0 order by fromDate asc');
while ($finalQuoteInsData = mysqli_fetch_array($b)) {
    $f           = GetPageRecord('*', _QUOTATION_INSURANCE_MASTER_, 'id="' . $finalQuoteInsData['insuranceQuotationId'] . '" and quotationId="' . $quotationId . '" order by id desc');
    $insQuotData = mysqli_fetch_array($f);
    $d           = GetPageRecord('*', _INSURANCE_COST_MASTER_, 'id="' . $insQuotData['serviceid'] . '"');
    $insData     = mysqli_fetch_array($d);
    $Ecity       = getDestination($insQuotData['destinationId']);
    if ($finalQuoteInsData['supplierId'] != '' && $finalQuoteInsData['supplierId'] != 0) {
        $supplierId = $finalQuoteInsData['supplierId'];
    } ?>  
                <tr id="selectedcon<?php
    echo $finalQuoteInsData['id']; ?>"> 
                 <td align="left" ><?php
    echo date('d-m-Y', strtotime($finalQuoteInsData['fromDate'])); ?></td>
                  <td align="left" >Insurance</td>
                   <td align="left" ><strong>&nbsp;</strong><?php
    echo strip($insData['name']); ?></td>
                   <td align="center"> <select class="select" id="supplier<?php
    echo $finalQuoteInsData['id']; ?>" style="width:300px; padding:5px;">
                  <!-- <option value="">Select&nbsp;Supplier</option> -->
                  <?php
    $bb            = GetPageRecord('*', 'suppliersMaster', 'id="' . $supplierId . '" and deletestatus=0 and status=1 and name!="" and airlinesType=7 order by name');
    $suppliersData = mysqli_fetch_array($bb); ?>
                 <option value="<?php
    echo $suppliersData['id']; ?>" <?php
    if ($supplierId == $suppliersData['id']) { ?> selected="selected"<?php
    } ?>><?php
    echo $suppliersData['name'] . ' - [' . $suppliersData['supplierNumber'] . ']'; ?></option>
                  
                  </select></td>
                   <td  align="center"><input type="button" name=""  onclick="unassignedServices('<?php echo $finalQuoteInsData['quotationId']; ?>','<?php echo $finalQuoteInsData['id']; ?>','<?php echo $finalQuoteInsData['insuranceNameId']; ?>','insurance')" value="<?php if ($supplierId != '') { echo 'Change'; }else { echo 'Select'; } ?>" style="background-color: <?php if ($supplierId != '') { echo 'green'; } ?>;padding: 4px;width: 70px;color: #ffffff;cursor: pointer;" id="selectedId<?php
    echo $finalQuoteInsData['id']; ?>"></td>
                </tr>
              <?php
}  

?>      
</tbody>
</table>        
</div>
</td>
</tr>
</tbody>
</table>
<!-- End of supplier change -->