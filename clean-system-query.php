<?php
include_once 'inc.php';    

$finalquotationIti = 'TRUNCATE TABLE finalquotationItinerary';
mysqli_query(db(), $finalquotationIti);

$finalQuote = 'TRUNCATE TABLE finalQuote';
mysqli_query(db(), $finalQuote);

$finalQuoteActivit = 'TRUNCATE TABLE finalQuoteActivity';
mysqli_query(db(), $finalQuoteActivit);

$finalQuoteEnroute = 'TRUNCATE TABLE finalQuoteEnroute';
mysqli_query(db(), $finalQuoteEnroute);

$finalQuoteEntranc = 'TRUNCATE TABLE finalQuoteEntrance';
mysqli_query(db(), $finalQuoteEntranc);

$finalQuoteExtra = 'TRUNCATE TABLE finalQuoteExtra';
mysqli_query(db(), $finalQuoteExtra);

$finalQuoteFlights = 'TRUNCATE TABLE finalQuoteFlights';
mysqli_query(db(), $finalQuoteFlights);

$finalQuoteGuides = 'TRUNCATE TABLE finalQuoteGuides';
mysqli_query(db(), $finalQuoteGuides);

$finalQuoteInsuren = 'TRUNCATE TABLE finalQuoteInsurence';
mysqli_query(db(), $finalQuoteInsuren);

$finalQuoteMealPla = 'TRUNCATE TABLE finalQuoteMealPlan';
mysqli_query(db(), $finalQuoteMealPla);

$finalQuoteTrains = 'TRUNCATE TABLE finalQuoteTrains';
mysqli_query(db(), $finalQuoteTrains);

$finalQuotetransfe = 'TRUNCATE TABLE finalQuotetransfer';
mysqli_query(db(), $finalQuotetransfe);

$finalQuotSupplier = 'TRUNCATE TABLE finalQuotSupplierStatus';
mysqli_query(db(), $finalQuotSupplier);
 
$guestList = 'TRUNCATE TABLE guestList';
mysqli_query(db(), $guestList);

$guestListDocument = 'TRUNCATE TABLE guestListDocuments';
mysqli_query(db(), $guestListDocument);
 
$InboundQuotationS = 'TRUNCATE TABLE InboundQuotationSorting';
mysqli_query(db(), $InboundQuotationS);

$invoice = 'TRUNCATE TABLE invoice';
mysqli_query(db(), $invoice);

$invoiceMaster = 'TRUNCATE TABLE invoiceMaster';
mysqli_query(db(), $invoiceMaster);
 
$newPackageDays = 'TRUNCATE TABLE newPackageDays';
mysqli_query(db(), $newPackageDays);

$newQuotationDays = 'TRUNCATE TABLE newQuotationDays';
mysqli_query(db(), $newQuotationDays);
 
$otherLeadPaxDetai = 'TRUNCATE TABLE otherLeadPaxDetails';
mysqli_query(db(), $otherLeadPaxDetai);
 
$queryAllmailsBack = 'TRUNCATE TABLE queryAllmailsBackup';
mysqli_query(db(), $queryAllmailsBack);
 
$querymails = 'TRUNCATE TABLE querymails';
mysqli_query(db(), $querymails);

$queryMaster = 'TRUNCATE TABLE queryMaster';
mysqli_query(db(), $queryMaster);

$queryNotesMaster  = 'TRUNCATE TABLE queryNotesMaster';
mysqli_query(db(), $queryNotesMaster);
 
$quotationActivity = 'TRUNCATE TABLE quotationActivityTimelineDetails';
mysqli_query(db(), $quotationActivity);

$quotationAddition = 'TRUNCATE TABLE quotationAdditionalMaster';
mysqli_query(db(), $quotationAddition);

$quotationEnrouteM = 'TRUNCATE TABLE quotationEnrouteMaster';
mysqli_query(db(), $quotationEnrouteM);

$quotationEntrance = 'TRUNCATE TABLE quotationEntranceMaster';
mysqli_query(db(), $quotationEntrance);

$quotationEntrance = 'TRUNCATE TABLE quotationEntranceTimelineDetails';
mysqli_query(db(), $quotationEntrance);

$quotationExtraMas = 'TRUNCATE TABLE quotationExtraMaster';
mysqli_query(db(), $quotationExtraMas);

$quotationFlightMa = 'TRUNCATE TABLE quotationFlightMaster';
mysqli_query(db(), $quotationFlightMa);

$quotationGuideMas = 'TRUNCATE TABLE quotationGuideMaster';
mysqli_query(db(), $quotationGuideMas);

$quotationHotelMas = 'TRUNCATE TABLE quotationHotelMaster';
mysqli_query(db(), $quotationHotelMas);

$quotationHotelRat = 'TRUNCATE TABLE quotationHotelRateMaster';
mysqli_query(db(), $quotationHotelRat);

$quotationInboundm = 'TRUNCATE TABLE quotationInboundmealplanmaster';
mysqli_query(db(), $quotationInboundm);

$quotationItinerar = 'TRUNCATE TABLE quotationItinerary';
mysqli_query(db(), $quotationItinerar);

$quotationMaster = 'TRUNCATE TABLE quotationMaster';
mysqli_query(db(), $quotationMaster);


$quotationMealPlan = 'TRUNCATE TABLE quotationMealPlanMaster';
mysqli_query(db(), $quotationMealPlan);

$quotationModeMast = 'TRUNCATE TABLE quotationModeMaster';
mysqli_query(db(), $quotationModeMast);

$quotationOtherAct = 'TRUNCATE TABLE quotationOtherActivitymaster';
mysqli_query(db(), $quotationOtherAct);

$quotationOverview = 'TRUNCATE TABLE quotationOverview';
mysqli_query(db(), $quotationOverview);

$quotationRoomSupp = 'TRUNCATE TABLE quotationRoomSupplimentMaster';
mysqli_query(db(), $quotationRoomSupp);

$quotationServiceM = 'TRUNCATE TABLE quotationServiceMarkup';
mysqli_query(db(), $quotationServiceM);

$quotationSightsee = 'TRUNCATE TABLE quotationSightseeingMaster';
mysqli_query(db(), $quotationSightsee);

$quotationTrainsMa = 'TRUNCATE TABLE quotationTrainsMaster';
mysqli_query(db(), $quotationTrainsMa);

$quotationTransfer = 'TRUNCATE TABLE quotationTransferMaster';
mysqli_query(db(), $quotationTransfer);

$quotationTransfer = 'TRUNCATE TABLE quotationTransferRateMaster';
mysqli_query(db(), $quotationTransfer);

$quotationTransfer = 'TRUNCATE TABLE quotationTransferTimelineDetails';
mysqli_query(db(), $quotationTransfer);
  
$supplierCommunica = 'TRUNCATE TABLE supplierCommunication';
mysqli_query(db(), $supplierCommunica);

$supplierCommunica = 'TRUNCATE TABLE supplierCommunicationMail';
mysqli_query(db(), $supplierCommunica);

$supplierCommunica = 'TRUNCATE TABLE supplierCommunicationMice';
mysqli_query(db(), $supplierCommunica);

$supplierCommunica = 'TRUNCATE TABLE supplierCommunicationReply';
mysqli_query(db(), $supplierCommunica);

$supplierPaymentMa = 'TRUNCATE TABLE supplierPaymentMaster';
mysqli_query(db(), $supplierPaymentMa);

$supplierScheduleP = 'TRUNCATE TABLE supplierSchedulePaymentMaster';
mysqli_query(db(), $supplierScheduleP);
  
$travelArrangement = 'TRUNCATE TABLE travelArrangementMaster';
mysqli_query(db(), $travelArrangement);
 
$voucherDetailsMas = 'TRUNCATE TABLE voucherDetailsMaster';
mysqli_query(db(), $voucherDetailsMas);
 
$voucherMaster = 'TRUNCATE TABLE voucherMaster';
mysqli_query(db(), $voucherMaster);
    

$totalPaxSlab = 'TRUNCATE TABLE totalPaxSlab';
mysqli_query(db(), $totalPaxSlab);

$quotationFOCRates = 'TRUNCATE TABLE quotationFOCRates';
mysqli_query(db(), $quotationFOCRates);

$selectedLocalAgentMaster = 'TRUNCATE TABLE selectedLocalAgentMaster';
mysqli_query(db(), $selectedLocalAgentMaster);

$onlineFeedbackMaster = 'TRUNCATE TABLE onlineFeedbackMaster';
mysqli_query(db(), $onlineFeedbackMaster);

$creditNoteMaster = 'TRUNCATE TABLE creditNoteMaster';
mysqli_query(db(), $creditNoteMaster);

$packageWiseRateMaster = 'TRUNCATE TABLE packageWiseRateMaster';
mysqli_query(db(), $packageWiseRateMaster);

// New tables after march 13
$paymentTypeMaster = 'TRUNCATE TABLE paymentTypeMaster';
mysqli_query(db(), $paymentTypeMaster);

$quotationActivityRateMaster = 'TRUNCATE TABLE quotationActivityRateMaster';
mysqli_query(db(), $quotationActivityRateMaster);

$quotationEntranceRateMaster = 'TRUNCATE TABLE quotationEntranceRateMaster';
mysqli_query(db(), $quotationEntranceRateMaster);

$dmcAirlineMasterRate = 'TRUNCATE TABLE dmcAirlineMasterRate';
mysqli_query(db(), $dmcAirlineMasterRate);

$quotationAirlinesRateMaster = 'TRUNCATE TABLE quotationAirlinesRateMaster';
mysqli_query(db(), $quotationAirlinesRateMaster);

$dmcTrainMasterRate = 'TRUNCATE TABLE dmcTrainMasterRate';
mysqli_query(db(), $dmcTrainMasterRate);

$quotationTrainRateMaster = 'TRUNCATE TABLE quotationTrainRateMaster';
mysqli_query(db(), $quotationTrainRateMaster);

$quotationRestaurantRateMaster = 'TRUNCATE TABLE quotationRestaurantRateMaster';
mysqli_query(db(), $quotationRestaurantRateMaster);

$flightTimeLineMaster = 'TRUNCATE TABLE flightTimeLineMaster';
mysqli_query(db(), $flightTimeLineMaster);

$packageQueryDays = 'TRUNCATE TABLE packageQueryDays';
mysqli_query(db(), $packageQueryDays);

$quotationVisaRateMaster = 'TRUNCATE TABLE quotationVisaRateMaster';
mysqli_query(db(), $quotationVisaRateMaster);

$quotationInsuranceRateMaster = 'TRUNCATE TABLE quotationInsuranceRateMaster';
mysqli_query(db(), $quotationInsuranceRateMaster);

echo "Successfull TRUNCATED";

?> 