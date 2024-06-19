
-- pax change functionality in outbound V3.2

-- quotationOtherActivitymaster
-- quotationEnrouteMaster
-- quotationEntranceMaster
-- quotationFerryMaster
-- quotationInboundmealplanmaster
-- quotationFlightMaster
-- quotationTrainsMaster
-- quotationExtraMaster

-- 28-10-2023 Samay Khan | Pax wise functionality  
-- entrance
ALTER TABLE `quotationEntranceRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `ticketinfantCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationEntranceMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `ticketinfantCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteEntrance` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `ticketinfantCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteEntrance` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `ticketinfantCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- activity
ALTER TABLE `quotationActivityRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0', ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationOtherActivitymaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' , ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteActivity` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' , ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteActivity` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' , ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- flight
ALTER TABLE `quotationAirlinesRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationFlightMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteFlights` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteFlights` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- train
ALTER TABLE `quotationTrainsMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationTrainRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteTrains` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteTrains` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- Ferry
ALTER TABLE `quotationFerryMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationFerryRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteFerry` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteFerry` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- Enroute
ALTER TABLE `quotationEnrouteMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteEnroute` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteEnroute` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- Restaurant
ALTER TABLE `quotationInboundmealplanmaster` ADD `remark` text NOT NULL;
ALTER TABLE `quotationInboundmealplanmaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationRestaurantRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteMealPlan` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteMealPlan` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

-- additional
ALTER TABLE `quotationAdditionalRateMaster` ADD `remark` text NOT NULL;
ALTER TABLE `quotationExtraMaster` ADD `remark` text NOT NULL;
ALTER TABLE `quotationAdditionalRateMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `quotationExtraMaster` ADD `costType` INT(11) NOT NULL DEFAULT '1',ADD `remark` text NOT NULL;
ALTER TABLE `quotationExtraMaster` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteExtra` ADD `adultPax` INT(11) NOT NULL DEFAULT '0' AFTER `childCost`, ADD `childPax` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax` ,ADD `infantPax` INT(11) NOT NULL DEFAULT '0' AFTER `childPax`;
ALTER TABLE `finalQuoteExtra` ADD `adultPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childCost2`, ADD `childPax2` INT(11) NOT NULL DEFAULT '0' AFTER `adultPax2` ,ADD `infantPax2` INT(11) NOT NULL DEFAULT '0' AFTER `childPax2`;

ALTER TABLE `finalQuoteActivity` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteEnroute` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteEntrance` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteExtra` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteFlights` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteTrains` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteGuides` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuotetransfer` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteHotelAdditional` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuotePassport` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteVisa` ADD `gstTax` int(11) NOT NULL DEFAULT '0';
 

ALTER TABLE `finalQuoteEnroute` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteEntrance` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteExtra` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteFerry` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteFlights` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteTrains` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuotetransfer` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';


-- 03-11-2023 Samay Khan | Pax wise functionality updates 
ALTER TABLE `quotationActivityRateMaster` ADD `noOfVehicles` INT(11) NOT NULL DEFAULT '0' AFTER `vehicleId`;
ALTER TABLE `quotationEntranceRateMaster` ADD `noOfVehicles` INT(11) NOT NULL DEFAULT '0' AFTER `vehicleId`;

-- 07-11-2023 Samay Khan | Pax wise functionality updates 
ALTER TABLE `finalQuote` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteGuides` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteHotelAdditional` ADD `markupCost` int(11) NOT NULL DEFAULT '0', ADD `markupType` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `finalQuoteInsurance` ADD `markupCost` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuotePassport` ADD `markupCost` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `finalQuoteVisa` ADD `markupCost` int(11) NOT NULL DEFAULT '0';


-- after merge sript
-- NEED TO RUN
-- BELOW STRUCTURE SHOULD BE IN V3.2 

-- 30-10-2023 Mausam Khan
ALTER TABLE `visaQueryMaster` ADD `taxApplicable` TINYINT NOT NULL DEFAULT '0' AFTER `multipleNo`;

ALTER TABLE `quotationVisaRateMaster` ADD `taxApplicable` TINYINT NOT NULL DEFAULT '0' AFTER `embassyFee`;

-- 01-11-2023 Mausam Khan
ALTER TABLE `dmcAirlineMasterRate` ADD `adultTax` INT NOT NULL AFTER `adultCost`, ADD `totalAdultCost` INT NOT NULL AFTER `adultTax`;
ALTER TABLE `dmcAirlineMasterRate` ADD `childTax` INT NOT NULL AFTER `childCost`, ADD `totalChildCost` INT NOT NULL AFTER `childTax`;
ALTER TABLE `dmcAirlineMasterRate` ADD `infantTax` INT NOT NULL AFTER `infantCost`, ADD `totalInfantCost` INT NOT NULL AFTER `infantTax`;


ALTER TABLE `dmcAirlineMasterRate` ADD `cancellationPolicy` MEDIUMTEXT NOT NULL AFTER `baggageAllowance`;

ALTER TABLE `quotationFlightMaster` ADD `adultTax` INT NOT NULL AFTER `adultCost`, ADD `totalAdultCost` INT NOT NULL AFTER `adultTax`;
ALTER TABLE `quotationFlightMaster` ADD `childTax` INT NOT NULL AFTER `childCost`, ADD `totalChildCost` INT NOT NULL AFTER `childTax`;
ALTER TABLE `quotationFlightMaster` ADD `infantTax` INT NOT NULL AFTER `infantCost`, ADD `totalInfantCost` INT NOT NULL AFTER `infantTax`;

ALTER TABLE `quotationFlightMaster` ADD `cancellationPolicy` MEDIUMTEXT NOT NULL AFTER `baggageAllowance`;
ALTER TABLE `finalQuoteFlights` ADD `cancellationPolicy` MEDIUMTEXT NOT NULL AFTER `remarks`;

ALTER TABLE `finalQuoteFlights` ADD `adultTax` INT NOT NULL AFTER `adultCost`, ADD `totalAdultCost` INT NOT NULL AFTER `adultTax`;
ALTER TABLE `finalQuoteFlights` ADD `childTax` INT NOT NULL AFTER `childCost`, ADD `totalChildCost` INT NOT NULL AFTER `childTax`;
ALTER TABLE `finalQuoteFlights` ADD `infantTax` INT NOT NULL AFTER `infantCost`, ADD `totalInfantCost` INT NOT NULL AFTER `infantTax`;

-- 02-11-2023 Mausam Khan
ALTER TABLE `quotationMaster` ADD `nonTaxableAMT` INT NOT NULL DEFAULT '0' AFTER `totalServiceTaxCost`;

ALTER TABLE `paymentRequestMaster` ADD `nonTaxableAMT` INT NOT NULL AFTER `totalServiceTaxCost`;

-- 04-11-2023 Mausam Khan
ALTER TABLE `bankMaster` ADD `title` VARCHAR(255) NOT NULL AFTER `deletestatus`;
-- 06-11-2023 Mausam Khan
ALTER TABLE `quotationTransferMaster` ADD `isTransferTaken` VARCHAR(10) NOT NULL AFTER `isSupTPTType`;
ALTER TABLE `quotationFlightMaster` ADD `isFlightTaken` VARCHAR(10) NOT NULL AFTER `totalPax`;

ALTER TABLE `finalQuotetransfer` ADD `isTransferTaken` VARCHAR(10) NOT NULL AFTER `transferType`;
ALTER TABLE `finalQuoteFlights` ADD `isFlightTaken` VARCHAR(10) NOT NULL AFTER `arrivalDate`;
