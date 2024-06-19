
-- 2-Jan-2023 mausam khan
ALTER TABLE `cruiseCompanyMaster` ADD `selfSupplier` INT NOT NULL;

ALTER TABLE `cruiseCompanyMaster` ADD `gst` VARCHAR(255) NOT NULL AFTER `selfSupplier`, ADD `address` TEXT NOT NULL AFTER `gst`, ADD `pinCode` INT NOT NULL AFTER `address`, ADD `countryId` INT NOT NULL AFTER `pinCode`, ADD `stateId` INT NOT NULL AFTER `countryId`, ADD `cityId` INT NOT NULL AFTER `stateId`;

DROP TABLE IF EXISTS `cruiseNameMaster`;
CREATE TABLE `cruiseNameMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cruiseCompanyId` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `deletestatus` tinyint(4) NOT NULL,
  `capacity` varchar(100) NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `addedBy` bigint(20) NOT NULL,
  `modifyDate` bigint(20) NOT NULL,
  `modifyBy` bigint(20) NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY(`id`)) ENGINE = InnoDB;

  ALTER TABLE `cabinTypeMaster` 
  
  CHANGE `cruiseName` `cruiseNameId` INT NOT NULL;

  ALTER TABLE `cabinTypeMaster` ADD `deletestatus` TINYINT NOT NULL DEFAULT '0' AFTER `cruiseNameId`, ADD `dateAdded` BIGINT NOT NULL AFTER `deletestatus`, ADD `addedBy` BIGINT NOT NULL AFTER `dateAdded`, ADD `modifyDate` BIGINT NOT NULL AFTER `addedBy`, ADD `modifyBy` BIGINT NOT NULL AFTER `modifyDate`;

  -- 4-Jan-2023 mausam khan
  CREATE TABLE `cruiseServiceTiming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cruiseServiceId` int(11) NOT NULL,
  `pickupTime` varchar(100) NOT NULL,
  `dropTime` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `deletestatus` tinyint(4) NOT NULL,
  `timestatus` tinyint(4) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB;

ALTER TABLE `cruiseMaster` ADD `runningDays` VARCHAR(255) NOT NULL AFTER `destination`;

CREATE TABLE `cruiseRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cruiseNameId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `cabinType` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `marketType` int(11) NOT NULL,
  `tariffType` tinyint(2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `adultCost` int NOT NULL,
  `childCost` int NOT NULL,
  `infantCost` int NOT NULL,
  `markupType` tinyint NOT NULL,
  `markupCost` int NOT NULL,
  `currencyId` int(11) NOT NULL,
  `gstTax` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `deletestatus` tinyint(4) NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `addedBy` bigint(20) NOT NULL,
  `modifyDate` bigint(20) NOT NULL,
  `modifyBy` bigint(20) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB;

-- 09-Jan-2023
ALTER TABLE `proposalSettingMaster` ADD `isProposalCost` INT NOT NULL DEFAULT '1' AFTER `footerstatus`;
-- 12-Jan-2023
ALTER TABLE `clientfeedbackmaster` ADD `sectionType` VARCHAR(255) NOT NULL AFTER `feedbackImage5`;
-- 16-Jan-2023
ALTER TABLE `voucherSettingMaster` ADD `setDefaultTemplate` INT(2) NOT NULL DEFAULT '1';
-- 18-Jan-2023
ALTER TABLE `finalQuoteMealPlan` ADD `mealPlanId` INT NOT NULL AFTER `mealPlanName`, ADD `mealTypeId` INT NOT NULL AFTER `mealPlanId`;

 
-- 30-Jan-2023 Samay luxury train
ALTER TABLE `packageBuilderTrainsMaster` ADD `trainType` INT(1) NOT NULL DEFAULT '0' AFTER `trainName`;
CREATE TABLE `trainCabinType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `roomoccupancy` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `deletestatus` tinyint(4) NOT NULL DEFAULT 0,
  `dateAdded` bigint(20) NOT NULL,
  `addedBy` bigint(20) NOT NULL,
  `modifyDate` bigint(20) NOT NULL,
  `modifyBy` bigint(20) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE = InnoDB;

INSERT INTO `moduleTypeMaster` (`module`, `name`, `status`) VALUES ('trainpackage', 'Train Package', '1');
 -- trainType=0 and  
-- 06-Feb-2023 Mausam Khan

CREATE TABLE `flightTimeLineMaster` (`id` INT NOT NULL AUTO_INCREMENT , `quotationId` INT NOT NULL , `queryId` INT NOT NULL , `flightQuoteId` INT NOT NULL , `flightId` INT NOT NULL , `dayId` INT NOT NULL , `departureDate` DATE NOT NULL , `departureTime` TIME NOT NULL , `arrivalDate` DATE NOT NULL , `arrivalTime` TIME NOT NULL , `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL , `remark` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
 
-- Complete Package Cost
-- Feb 16, 2023
ALTER TABLE `packageWiseRateMaster` 
ADD `supplierId` INT(11) NOT NULL DEFAULT '0' AFTER `otherC`, 
ADD `currencyId` INT(11) NOT NULL DEFAULT '0' AFTER `supplierId`;



-- NEW MASTERS AND CURRENCY FACTOR quotation and final tables
-- Feb 16, 2023
ALTER TABLE `quotationFlightMaster`  
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationTrainsMaster` 
ADD `supplierId` INT(11) NOT NULL DEFAULT '0', 
ADD `currencyId` INT(11) NOT NULL DEFAULT '0' AFTER `supplierId`, 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationFerryMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationOtherActivitymaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationHotelMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationTransferMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationGuideMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationExtraMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationInboundmealplanmaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationEntranceMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationEnrouteMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;


ALTER TABLE `finalQuote` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteActivity` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteEnroute` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteEntrance` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteExtra` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteFlights` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteGuides` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteMealPlan` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteTrains` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuotetransfer` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteFerry` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;


-- 

ALTER TABLE `quotationHotelRateMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationTransferRateMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

CREATE TABLE `quotationGuideRateMaster` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quotationId` bigint(20) NOT NULL,
  `guiderateId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `detail` varchar(250) NOT NULL,
  `currencyId` bigint(20) NOT NULL,
  `currencyValue` double NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  `addBy` bigint(20) NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `supplierId` bigint(20) NOT NULL,
  `serviceid` int(11) NOT NULL DEFAULT 0,
  `guideSubCatId` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `languageAllowance` int(11) NOT NULL DEFAULT 0,
  `otherCost` int(11) NOT NULL DEFAULT 0,
  `totalMarkup` int(11) NOT NULL,
  `dayType` varchar(255) DEFAULT NULL,
  `guidePorterId` int(11) NOT NULL DEFAULT 0,
  `serviceType` int(11) NOT NULL DEFAULT 0,
  `universalCost` int(1) DEFAULT 0,
  `remarks` text NOT NULL,
  `paxRange` varchar(255) DEFAULT '0',
  `CostsheetOrder` int(20) NOT NULL DEFAULT 0,
  `marketType` int(11) NOT NULL DEFAULT 0,
  `guideGST` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- quotationActivityRateMaster
CREATE TABLE `quotationActivityRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `dmcId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `supplierId` int(11) NOT NULL,
  `activityCost` double NOT NULL,
  `maxpax` int(11) NOT NULL,
  `perPaxCost` double NOT NULL,
  `currencyId` int(11) NOT NULL,
  `currencyValue` double NOT NULL,
  `status` int(11) NOT NULL,
  `addBy` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  `remarks` text NOT NULL,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- dmcEntranceMealPlanRate

-- quotationEntranceRateMaster
CREATE TABLE `quotationEntranceRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `dmcId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `supplierId` int(11) NOT NULL,
  `vehicleId` int(11) NOT NULL,
  `entranceType` int(11) NOT NULL DEFAULT 0,
  `ticketAdultCost` double NOT NULL,
  `ticketchildCost` double NOT NULL,
  `ticketinfantCost` double NOT NULL,
  `adultCost` double NOT NULL,
  `childCost` double NOT NULL,
  `infantCost` double NOT NULL,
  `vehicleCost` double NOT NULL,
  `repCost` double NOT NULL,
  `transferType` int(11) NOT NULL DEFAULT 0,
  `tarifType` int(11) NOT NULL,
  `nationalityType` int(11) NOT NULL,
  `currencyId` int(11) NOT NULL,
  `currencyValue` double NOT NULL,
  `status` int(11) NOT NULL,
  `addBy` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  `remark` text NOT NULL,
  `taxType` int(11) NOT NULL DEFAULT 1,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `markupType` int(11) NOT NULL DEFAULT 1,
  `markupCost` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- dmcAirlineMasterRate
DROP TABLE IF EXISTS `dmcAirlineMasterRate`;
CREATE TABLE `dmcAirlineMasterRate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `detail` varchar(250) NOT NULL,
  `currencyId` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `addBy` bigint(20) NOT NULL,
  `dateAdded` bigint(20) NOT NULL,
  `supplierId` bigint(20) NOT NULL,
  `serviceId` int(11) NOT NULL DEFAULT 0,
  `flightId` int(11) NOT NULL DEFAULT 0,
  `flightNumber` varchar(255) NOT NULL,
  `flightClass` varchar(255) NOT NULL,
  `adultCost` int(11) NOT NULL DEFAULT 0,
  `childCost` int(11) NOT NULL DEFAULT 0,
  `infantCost` int(11) NOT NULL DEFAULT 0,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `markupType` int(1) NOT NULL DEFAULT 1,
  `markupCost` int(11) NOT NULL DEFAULT 0,
  `totalMarkup` int(11) NOT NULL,
  `serviceType` int(11) NOT NULL DEFAULT 0,
  `baggageAllowance` varchar(255) DEFAULT NULL,
  `remarks` text NOT NULL,
  `CostsheetOrder` int(20) NOT NULL DEFAULT 0,
  `marketType` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- quotationAirlinesRateMaster
CREATE TABLE `quotationAirlinesRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `dmcId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `supplierId` int(11) NOT NULL,
  `flightNumber` varchar(255) NOT NULL,
  `flightClass` varchar(222) NOT NULL,
  `adultCost` double NOT NULL,
  `childCost` double NOT NULL,
  `infantCost` double NOT NULL,
  `baggageAllowance` double NOT NULL,
  `tarifType` int(11) NOT NULL,
  `currencyId` int(11) NOT NULL,
  `currencyValue` double NOT NULL,
  `status` int(11) NOT NULL,
  `addBy` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  `remark` text NOT NULL,
  `taxType` int(11) NOT NULL DEFAULT 1,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `markupType` int(11) NOT NULL DEFAULT 1,
  `markupCost` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- dmcTrainMasterRate
CREATE TABLE `dmcTrainMasterRate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `dmcId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `supplierId` int(11) NOT NULL,
  `trainNumber` varchar(255) NOT NULL,
  `trainClass` varchar(222) NOT NULL,
  `journeyType` varchar(255) NOT NULL,
  `adultCost` double NOT NULL,
  `childCost` double NOT NULL,
  `infantCost` double NOT NULL,
  `tarifType` int(11) NOT NULL,
  `baggageAllowance` double NOT NULL,
  `currencyId` int(11) NOT NULL,
  `currencyValue` double NOT NULL,
  `status` int(11) NOT NULL,
  `addBy` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  `remarks` text NOT NULL,
  `taxType` int(11) NOT NULL DEFAULT 1,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `markupType` int(11) NOT NULL DEFAULT 1,
  `markupCost` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- quotationTrainRateMaster
CREATE TABLE `quotationTrainRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `dmcId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `tarifType` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `trainNumber` varchar(255) NOT NULL,
  `trainClass` varchar(222) NOT NULL,
  `journeyType` varchar(255) NOT NULL,
  `adultCost` double NOT NULL,
  `childCost` double NOT NULL,
  `infantCost` double NOT NULL,
  `currencyId` int(11) NOT NULL,
  `currencyValue` double NOT NULL,
  `baggageAllowance` double NOT NULL,
  `status` int(11) NOT NULL,
  `addBy` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  `remark` text NOT NULL,
  `taxType` int(11) NOT NULL DEFAULT 1,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `markupType` int(11) NOT NULL DEFAULT 1,
  `markupCost` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
-- quotationRestaurantRateMaster
CREATE TABLE `quotationRestaurantRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `dmcId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `supplierId` int(11) NOT NULL,
  `adultCost` double NOT NULL,
  `childCost` double NOT NULL,
  `infantCost` double NOT NULL,
  `tarifType` int(11) NOT NULL,
  `mealPlanType` int(11) NOT NULL,
  `currencyId` int(11) NOT NULL,
  `currencyValue` double NOT NULL,
  `status` int(11) NOT NULL,
  `addBy` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  `remark` text NOT NULL,
  `taxType` int(11) NOT NULL DEFAULT 1,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `markupType` int(11) NOT NULL DEFAULT 1,
  `markupCost` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ************************
-- commented structure will be used when rate layout work moved
--  

ALTER TABLE `quotationFlightMaster` ADD `baggageAllowance` VARCHAR(11) NOT NULL  AFTER `flightClass`;
ALTER TABLE `quotationFlightMaster` ADD `dmcId` VARCHAR(11) NOT NULL  AFTER `flightId`;
ALTER TABLE `quotationFlightMaster` ADD `totalPax` VARCHAR(11) NOT NULL  AFTER `totalChild`;

ALTER TABLE `quotationTrainsMaster` ADD `dmcId` VARCHAR(11) NOT NULL  AFTER `id`;

-- 10-Feb-2023 Mausam Khan
ALTER TABLE `queryMaster` ADD `needPassport` INT NOT NULL AFTER `needInsurance`; 

-- 10-Feb-2023 Samay Khan
ALTER TABLE `packageWiseRateMaster` ADD `currencyValue` INT(11) NOT NULL DEFAULT '0' AFTER `currencyId`;
ALTER TABLE `quotationMaster` ADD `totalMarkupCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalQuotCost`;
ALTER TABLE `quotationMaster` ADD `totalISOCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalMarkupCost`;
ALTER TABLE `quotationMaster` ADD `totalConsortiaCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalISOCost`;
ALTER TABLE `quotationMaster` ADD `totalClientCommCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalConsortiaCost`;
ALTER TABLE `quotationMaster` ADD `totalDiscountCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalClientCommCost`;
ALTER TABLE `quotationMaster` ADD `totalServiceTaxCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalDiscountCost`;
ALTER TABLE `quotationMaster` ADD `totalTCSCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalServiceTaxCost`;

ALTER TABLE `quotationMaster` ADD `sglBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `totalMargin`;
ALTER TABLE `quotationMaster` ADD `dblBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `sglBasisCost`;
ALTER TABLE `quotationMaster` ADD `tplBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `dblBasisCost`;
ALTER TABLE `quotationMaster` ADD `quadBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `tplBasisCost`;
ALTER TABLE `quotationMaster` ADD `sixBedBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `quadBasisCost`;
ALTER TABLE `quotationMaster` ADD `eightBedBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `sixBedBasisCost`;
ALTER TABLE `quotationMaster` ADD `tenBedBasisCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `eightBedBasisCost`;

ALTER TABLE `quotationMaster` ADD `extraAdultCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `tenBedBasisCost`;
ALTER TABLE `quotationMaster` ADD `CWBCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `extraAdultCost`;
ALTER TABLE `quotationMaster` ADD `CNBCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `CWBCost`;
ALTER TABLE `quotationMaster` ADD `twinCost` FLOAT(50) NOT NULL DEFAULT '0' AFTER `CNBCost`;

ALTER TABLE `quotationMaster` ADD `ISOCommission` FLOAT(50) NOT NULL DEFAULT '0' AFTER `CNBCost`;
ALTER TABLE `quotationMaster` ADD `ConsortiaCommission` FLOAT(50) NOT NULL DEFAULT '0' AFTER `ISOCommission`;
ALTER TABLE `quotationMaster` ADD `ClientCommission` FLOAT(50) NOT NULL DEFAULT '0' AFTER `ConsortiaCommission`;
ALTER TABLE `quotationMaster` ADD `dayWise` INT(11) NOT NULL DEFAULT '1' AFTER `propIMGNum6`;
ALTER TABLE `quotationMaster` ADD `packageSupplier` INT(11) NOT NULL DEFAULT '0' AFTER `dayWise`;

ALTER TABLE `quotationMaster` 
CHANGE `totalMarkupCost` `totalMarkupCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalISOCost` `totalISOCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalConsortiaCost` `totalConsortiaCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalClientCommCost` `totalClientCommCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalDiscountCost` `totalDiscountCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalServiceTaxCost` `totalServiceTaxCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalTCSCost` `totalTCSCost` FLOAT(50) NOT NULL DEFAULT '0', 

CHANGE `totalCompanyCost` `totalCompanyCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalQuotCostwithoutpercent` `totalQuotCostwithoutpercent` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalQuotCost` `totalQuotCost` FLOAT(50) NOT NULL DEFAULT '0', 
CHANGE `totalMargin` `totalMargin` FLOAT(50) NOT NULL DEFAULT '0'; 

ALTER TABLE `companySettingsMaster` 
ADD `internationalQuery` INT NOT NULL , 
ADD `domesticQuery` INT NOT NULL AFTER `internationalQuery`, 
ADD `defaultQueryType` INT NOT NULL AFTER `domesticQuery`;

-- Mice observatiosns 
 ALTER TABLE `extraQuotation` ADD `addBy` INT NOT NULL;
 ALTER TABLE `extraQuotation` ADD `supplierId` INT NOT NULL;
 ALTER TABLE `extraQuotation` ADD `gstTax` INT NOT NULL AFTER `supplierId`;
 ALTER TABLE `extraQuotation` ADD `currencyValue` VARCHAR(255) NOT NULL AFTER `supplierId`;
 ALTER TABLE `extraQuotation` ADD `remark` INT NOT NULL;

-- 14-Feb-2023 Mausam Khan 
CREATE TABLE `flightTimeLineMaster` ( `id` int(11) NOT NULL AUTO_INCREMENT, `quotationId` int(11) NOT NULL, `queryId` int(11) NOT NULL, `flightQuoteId` int(11) NOT NULL, `flightId` int(11) NOT NULL, `dayId` int(11) NOT NULL, `departureDate` date NOT NULL, `departureTime` time NOT NULL, `arrivalDate` date NOT NULL, `arrivalTime` time NOT NULL, `status` tinyint(4) NOT NULL, `deletestatus` tinyint(4) NOT NULL, `remark` varchar(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

ALTER TABLE `queryMaster` ADD `travelType` TINYINT NOT NULL DEFAULT '0' AFTER `clientType`;
ALTER TABLE `quotationMaster` ADD `travelType` TINYINT NOT NULL AFTER `clientType`;

-- 14-02-2023 payment type master islam
CREATE TABLE `paymentTypeMaster` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `status` INT(11) NOT NULL DEFAULT '1' , `deletestatus` INT(11) NOT NULL DEFAULT '0' , `dateAdded` VARCHAR(100) NOT NULL , `addedBy` INT(11) NOT NULL , `modifyDate` VARCHAR(100) NOT NULL , `modifyBy` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
--15-02-2023 vehicle Type Master islam 
ALTER TABLE `vehicleTypeMaster` ADD `status` TINYINT(2) NOT NULL AFTER `name`, ADD `deletestatus` TINYINT(2) NOT NULL AFTER `status`, ADD `capacity` INT(11) NOT NULL AFTER `deletestatus`, ADD `modifyBy` INT(11) NOT NULL AFTER `capacity`, ADD `modifyDate` BIGINT(20) NOT NULL AFTER `modifyBy`;


  --18-02-2023 supplierId add 
  ALTER TABLE `quotationExtraMaster` ADD `supplierId` INT(11) NOT NULL DEFAULT '0'; 
  ALTER TABLE `quotationInboundmealplanmaster` ADD `supplierId` INT(11) NOT NULL DEFAULT '0'; 
  ALTER TABLE `queryMaster` ADD `expire_date` DATE NOT NULL; 

--17-02-2023 add new language Bangla
INSERT INTO `tbl_languagemaster` (`id`, `name`, `deletestatus`, `dateAdded`, `modifyDate`, `addedBy`, `modifyBy`, `status`) VALUES (NULL, 'Bangla', '0', '1617875707', '', '37', '', '1')

--end updated to server 

--20-02-2023 samaya
ALTER TABLE `dmcRestaurantsMealPlanRate` ADD `serviceId` INT(11) NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `dmcRestaurantsMealPlanRate` CHANGE `mealPlanId` `mealPlanType` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `quotationInboundmealplanmaster` 
ADD `mealPlanId` INT(11) NOT NULL DEFAULT '0' AFTER `quotationId`, 
ADD `image` INT(11) NOT NULL DEFAULT '0' AFTER `mealPlanId`,
ADD `dmcId` INT(11) NOT NULL DEFAULT '0' AFTER `supplierId`;

ALTER TABLE `quotationOtherActivitymaster` ADD `slabId` INT(11) NOT NULL DEFAULT '0' AFTER `quotationId`;

ALTER TABLE `quotationEntranceMaster` ADD `transferType` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `packageBuilderEntranceMaster` ADD `transferType` int(11) NOT NULL DEFAULT '0' AFTER `entranceType`;

ALTER TABLE `quotationTransferMaster` ADD `tarifType` int(11) NOT NULL DEFAULT '0' AFTER `endDate`;
ALTER TABLE `quotationTransferMaster` ADD `isLocalEscort` int(11) NOT NULL DEFAULT '0' AFTER `isGuestType`;
ALTER TABLE `quotationTransferMaster` ADD `isForeignEscort` int(11) NOT NULL DEFAULT '0' AFTER `isLocalEscort`;
ALTER TABLE `quotationTransferMaster` ADD `isSupplement` int(11) NOT NULL DEFAULT '0' AFTER `isForeignEscort`;
ALTER TABLE `quotationTransferMaster` ADD `transferQuoteId` int(11) NOT NULL DEFAULT '0' AFTER `isSupplement`;
ALTER TABLE `quotationTransferMaster` ADD `isSelectedFinal` int(11) NOT NULL DEFAULT '0' AFTER `transferQuoteId`;

--20-02-2023 islam resevation multiple files
ALTER TABLE `finalQuotetransfer` ADD `image2` VARCHAR(255) NOT NULL AFTER `image`, ADD `image3` VARCHAR(255) NOT NULL AFTER `image2`;

ALTER TABLE `finalQuoteTrains` ADD `image2` VARCHAR(255) NOT NULL AFTER `image`, ADD `image3` VARCHAR(255) NOT NULL AFTER `image2`;

ALTER TABLE `finalQuoteFlights` ADD `image2` VARCHAR(255) NOT NULL AFTER `image`, ADD `image3` VARCHAR(255) NOT NULL AFTER `image2`;


--20-02-2023 islam add FIT payment and remarks 
ALTER TABLE `termsConditionsLanguageMaster` ADD `paymentpolicy` LONGTEXT NOT NULL AFTER `cancellation`;
ALTER TABLE `packageTermsCondtionsMaster` ADD `paymentpolicy` LONGTEXT NULL DEFAULT NULL AFTER `cancelation`;
ALTER TABLE `packageTermsCondtionsMaster` ADD `remarks` LONGTEXT NULL DEFAULT NULL AFTER `paymentpolicy`;
ALTER TABLE `termsConditionsLanguageMaster` ADD `remarks` LONGTEXT NOT NULL AFTER `paymentpolicy`;

--21-02-2023 samaya
ALTER TABLE `quotationFerryRateMaster` ADD `currencyValue` VARCHAR(255) NOT NULL AFTER `currencyId`;
ALTER TABLE `finalQuoteFerry` ADD `currencyValue` VARCHAR(255) NOT NULL AFTER `currencyId`;

--21-02-2023 islam quataion payment policy and remarks
ALTER TABLE `quotationMaster` ADD `paymentpolicy` LONGTEXT NULL DEFAULT NULL AFTER `inclusion`, ADD `remarks` LONGTEXT NULL DEFAULT NULL AFTER `paymentpolicy`;

--22-02-2023 samaya
ALTER TABLE `quotationFlightMaster` ADD `flightHub` INT NOT NULL AFTER `infant`, ADD `supplierId` INT NOT NULL DEFAULT '0' AFTER `flightHub`;
 
--21-02-2023 islam quataion payment policy and remarks
ALTER TABLE `quotationMaster` ADD `paymentpolicy` LONGTEXT NULL DEFAULT NULL AFTER `inclusion`, ADD `remarks` LONGTEXT NULL DEFAULT NULL AFTER `paymentpolicy`;

-- 22-02-2023 Mausam Khan
ALTER TABLE `queryMaster` ADD `countryId` VARCHAR(255) NOT NULL AFTER `destinationId`;

ALTER TABLE `destinationMaster` ADD `setDefault` TINYINT NOT NULL DEFAULT '0' AFTER `gradeId`;
ALTER TABLE `countryMaster` ADD `setDefault` TINYINT NOT NULL DEFAULT '0' AFTER `phonecode`;

-- 25-02-2023 Samaya Khan
ALTER TABLE `quotationVisaRateMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationInsuranceRateMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `quotationPassportRateMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `finalQuoteInsurance` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuotePassport` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
ALTER TABLE `finalQuoteVisa` ADD `currencyValue` DOUBLE NOT NULL DEFAULT 0 AFTER `currencyId`;
-- 25-Feb-2023 Mausam Khan
ALTER TABLE `queryMaster` ADD `packageId` INT NOT NULL DEFAULT '0' AFTER `displayId`;

-- 28-Feb-2023 Samay Khan
ALTER TABLE `quotationHotelAdditionalMaster` 
ADD `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

-- 01-03-2023 Mausam Khan
ALTER TABLE `flightTimeLineMaster` ADD `serviceType` VARCHAR(100) NOT NULL AFTER `remark`;

ALTER TABLE `packageTermsCondtionsMaster` ADD `emergencyHeading` VARCHAR(255) NOT NULL AFTER `modifyDate`, ADD `contactPerson` VARCHAR(255) NOT NULL AFTER `emergencyHeading`, ADD `phone` BIGINT NOT NULL AFTER `contactPerson`, ADD `email` VARCHAR(255) NOT NULL AFTER `phone`, ADD `availableOn` VARCHAR(255) NOT NULL AFTER `email`;


-- 02-March-2023 Mausam Khan
ALTER TABLE `packageWiseRateMaster` ADD `infantBedBasis` INT NOT NULL AFTER `childwithoutbedBasis`;
ALTER TABLE `packageWiseRateMaster` ADD `infantBedCost` INT NOT NULL AFTER `childwithoutbedCost`;

-- ****************************************************************************************
-- 013-03-2023 Samaya need to rund this structure to every client end
ALTER TABLE `overviewLanguageMaster` 
CHANGE `overview` `overview` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `highlight` `highlight` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `termsConditionsLanguageMaster` 
CHANGE `inclusion` `inclusion` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `exclusion` `exclusion` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `termscondition` `termscondition` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `cancellation` `cancellation` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `paymentpolicy` `paymentpolicy` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `remarks` `remarks` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `iti_subjectmaster` 
CHANGE `otherTitle` `otherTitle` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `subjectLanguageMaster` 
CHANGE `title` `title` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


ALTER TABLE `activityLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `entranceLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `itineryTitleLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


ALTER TABLE `itineneryDesLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `destinationLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


ALTER TABLE `enrouteLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `letterLanguageMaster` 
CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
 
ALTER TABLE `letterLinkLanguageMaster` 
CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `quotationMaster` 
CHANGE `overviewText` `overviewText` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `highlightsText` `highlightsText` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `inclusion` `inclusion` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `exclusion` `exclusion` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `tncText` `tncText` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `specialText` `specialText` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `paymentpolicy` `paymentpolicy` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `remarks` `remarks` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
  
-- *********************************************************************************************end for every client structure

-- 03-MARCH-2023 Samay email incoming setting dynamic structure
ALTER TABLE `emailSettingmaster` 
ADD `imap_server` VARCHAR(255) NOT NULL AFTER `security_type`, 
ADD `imap_port` VARCHAR(255) NOT NULL AFTER `imap_server`, 
ADD `imap_security_type` VARCHAR(255) NOT NULL AFTER `imap_port`, 
ADD `imap_filter` VARCHAR(255) NOT NULL AFTER `imap_security_type`;
 
-- 06-March-2023 Mausam Khan
ALTER TABLE `quotationTransferTimelineDetails` ADD `transferType` VARCHAR(100) NOT NULL AFTER `mode`, ADD `departureDate` DATE NULL DEFAULT NULL AFTER `transferType`;

ALTER TABLE `quotationEntranceTimelineDetails` ADD `pickupTime` TIME NOT NULL AFTER `endTime`, ADD `dropTime` TIME NOT NULL AFTER `pickupTime`, ADD `departureDate` DATE NULL DEFAULT NULL AFTER `dropTime`, ADD `pickupAddress` VARCHAR(255) NOT NULL AFTER `departureDate`, ADD `dropAddress` VARCHAR(255) NOT NULL AFTER `pickupAddress`;
-- 07-March-2023 Mausam Khan
ALTER TABLE `quotationTransferMaster` ADD `startDay` INT NOT NULL AFTER `endDate`, ADD `endDay` INT NOT NULL AFTER `startDay`;
-- 09-March-2023 Mausam Khan
ALTER TABLE `quotationExtraMaster` ADD `costType` TINYINT NOT NULL AFTER `groupCost`;


--13-03-3023 vehicle type master related 
ALTER TABLE `vehicleTypeMaster` CHANGE `name` `name` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `status` `status` INT(11) NOT NULL DEFAULT '1', CHANGE `deletestatus` `deletestatus` INT(11) NOT NULL DEFAULT '0', CHANGE `capacity` `capacity` VARCHAR(100) NOT NULL, CHANGE `modifyBy` `modifyBy` BIGINT(20) NOT NULL, CHANGE `dateAdded` `dateAdded` BIGINT(20) NOT NULL, CHANGE `addedBy` `addedBy` BIGINT(20) NOT NULL;




--15-03-2023 invoice template company setting master 
ALTER TABLE `invoiceSettingMaster` ADD `supplierStatus` INT(1) NOT NULL AFTER `repolicies`, ADD `clientStatus` INT(1) NOT NULL AFTER `supplierStatus`, ADD `setDefaultTemplate` INT(2) NOT NULL DEFAULT '1' AFTER `clientStatus`;

-- 17-March-2023 Mausam Khan

CREATE TABLE `quotationAdditionalRateMaster` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(165) NOT NULL,
  `rateId` varchar(165) NOT NULL,
  `additionalId` int(11) DEFAULT NULL,
  `queryId` bigint(20) NOT NULL DEFAULT 1,
  `adultCost` varchar(20) NOT NULL,
  `childCost` varchar(20) NOT NULL,
  `infantCost` varchar(50) NOT NULL,
  `groupCost` int(11) DEFAULT 0,
  `costType` tinyint(4) NOT NULL,
  `destinationId` int(11) NOT NULL DEFAULT 0,
  `quotationId` int(11) NOT NULL DEFAULT 0,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `dateExtra` date NOT NULL,
  `currencyId` int(11) NOT NULL DEFAULT 0,
  `currencyValue` double NOT NULL DEFAULT 0,
  `dayId` int(11) NOT NULL DEFAULT 0,
  `serviceType` varchar(255) DEFAULT NULL,
  `voucherNo` varchar(100) NOT NULL,
  `voucherReferanceNumber` varchar(100) NOT NULL,
  `voucherDate` date NOT NULL,
  `confirmationNo` varchar(100) NOT NULL,
  `voucherNotes` varchar(100) NOT NULL,
  `gstTax` int(11) NOT NULL DEFAULT 0,
  `taxType` int(11) NOT NULL DEFAULT 1,
  `markupType` int(1) NOT NULL DEFAULT 1,
  `markupCost` int(11) NOT NULL DEFAULT 0,
  `information` text NOT NULL,
  `supplierId` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- 18-March-2023 Mausam Khan

ALTER TABLE `packageBuilderotherActivityMaster` ADD `transferType` TINYINT NULL DEFAULT '0' AFTER `otherActivityName`;

-- 21-March-2023 Mausam Khan
ALTER TABLE `dmcotherActivityRate` ADD `transferType` TINYINT NOT NULL AFTER `otherActivityNameId`;

ALTER TABLE `quotationActivityRateMaster` ADD `transferType` TINYINT NOT NULL AFTER `dmcId`;

ALTER TABLE `dmcotherActivityRate` CHANGE `maxpax` `adultCost` INT NOT NULL;
ALTER TABLE `dmcotherActivityRate` CHANGE `perPaxCost` `childCost` INT NOT NULL;
ALTER TABLE `dmcotherActivityRate` CHANGE `infantCost` `infantCost` INT NOT NULL;

ALTER TABLE `dmcotherActivityRate` ADD `ticketAdultCost` INT NOT NULL AFTER `infantCost`, ADD `ticketchildCost` INT NOT NULL AFTER `ticketAdultCost`, ADD `ticketinfantCost` INT NOT NULL AFTER `ticketchildCost`, ADD `repCost` INT NOT NULL AFTER `ticketinfantCost`;

ALTER TABLE `dmcotherActivityRate` ADD `tarifType` TINYINT NOT NULL AFTER `serviceid`, ADD `nationality` INT NOT NULL AFTER `tarifType`;

ALTER TABLE `quotationActivityRateMaster` ADD `adultCost` INT NOT NULL AFTER `toDate`;
ALTER TABLE `quotationActivityRateMaster` ADD `childCost` INT NOT NULL AFTER `adultCost`;
ALTER TABLE `quotationActivityRateMaster` ADD `infantCost` INT NOT NULL AFTER `childCost`;

ALTER TABLE `quotationActivityRateMaster` ADD `ticketAdultCost` INT NOT NULL AFTER `infantCost`, ADD `ticketchildCost` INT NOT NULL AFTER `ticketAdultCost`, ADD `ticketinfantCost` INT NOT NULL AFTER `ticketchildCost`, ADD `repCost` INT NOT NULL AFTER `ticketinfantCost`;

ALTER TABLE `quotationActivityRateMaster` ADD `tarifType` TINYINT NOT NULL AFTER `gstTax`, ADD `nationality` INT NOT NULL AFTER `tarifType`;
ALTER TABLE `quotationActivityRateMaster` ADD `vehicleCost` TINYINT NOT NULL AFTER `ticketinfantCost`, ADD `vehicleId` INT NOT NULL AFTER `vehicleCost`;
ALTER TABLE `quotationActivityRateMaster` ADD `markupType` TINYINT NOT NULL AFTER `vehicleId`, ADD `markupCost` INT NOT NULL AFTER `markupType`;

ALTER TABLE `quotationOtherActivitymaster` ADD `transferType` TINYINT NOT NULL AFTER `quotationId`;
ALTER TABLE `quotationOtherActivitymaster` ADD `ticketAdultCost` INT NOT NULL AFTER `infantCost`, ADD `ticketchildCost` INT NOT NULL AFTER `ticketAdultCost`, ADD `ticketinfantCost` INT NOT NULL AFTER `ticketchildCost`, ADD `repCost` INT NOT NULL AFTER `ticketinfantCost`;
ALTER TABLE `quotationOtherActivitymaster` ADD `tarifType` TINYINT NOT NULL AFTER `gstTax`, ADD `nationality` INT NOT NULL AFTER `tarifType`;
ALTER TABLE `quotationOtherActivitymaster` ADD `vehicleCost` INT NOT NULL AFTER `ticketinfantCost`, ADD `vehicleId` INT NOT NULL AFTER `vehicleCost`;
ALTER TABLE `finalQuoteActivity` ADD `adultCost` INT NOT NULL AFTER `shareDate`, ADD `childCost` INT NOT NULL AFTER `adultCost`, ADD `infantCost` INT NOT NULL AFTER `childCost`, ADD `ticketAdultCost` INT NOT NULL AFTER `infantCost`, ADD `ticketchildCost` INT NOT NULL AFTER `ticketAdultCost`, ADD `ticketinfantCost` INT NOT NULL AFTER `ticketchildCost`, ADD `repCost` INT NOT NULL AFTER `ticketinfantCost`, ADD `vehicleCost` INT NOT NULL AFTER `repCost`, ADD `vehicleId` INT NOT NULL AFTER `vehicleCost`, ADD `transferType` INT NOT NULL AFTER `vehicleId`;
ALTER TABLE `finalQuoteActivity` ADD `markupType` INT NOT NULL AFTER `transferType`, ADD `markupCost` INT NOT NULL AFTER `markupType`;
-- 24-March-2023 Mausam Khan
ALTER TABLE `quotationActivityRateMaster` CHANGE `vehicleCost` `vehicleCost` INT NOT NULL;
-- 24-March-2023 Mausam Khan
ALTER TABLE `finalQuoteExtra` ADD `costType` TINYINT NOT NULL AFTER `additionalQuotationId`;
--07-04-2023- islam reservation train and flight PNR no. and details
ALTER TABLE `finalQuoteTrains` ADD `trTitle` VARCHAR(255) NOT NULL AFTER `confirmationNo`, ADD `trfname` VARCHAR(255) NOT NULL AFTER `trTitle`, ADD `trmname` VARCHAR(255) NOT NULL AFTER `trfname`, ADD `trlname` VARCHAR(255) NOT NULL AFTER `trmname`, ADD `trgender` VARCHAR(255) NOT NULL AFTER `trlname`, ADD `trpnrno` VARCHAR(255) NOT NULL AFTER `trgender`;
ALTER TABLE `finalQuoteFlights` ADD `ftTitle` VARCHAR(255) NOT NULL AFTER `confirmationNo`, ADD `ftfname` VARCHAR(255) NOT NULL AFTER `ftTitle`, ADD `ftmname` VARCHAR(255) NOT NULL AFTER `ftfname`, ADD `ftlname` VARCHAR(255) NOT NULL AFTER `ftmname`, ADD `ftgender` VARCHAR(255) NOT NULL AFTER `ftlname`, ADD `ftpnrno` VARCHAR(255) NOT NULL AFTER `ftgender`;


ALTER TABLE `finalQuoteFlights` ADD `ftTitle` VARCHAR(255) NOT NULL AFTER `confirmationNo`, ADD `ftfname` VARCHAR(255) NOT NULL AFTER `ftTitle`, ADD `ftmname` VARCHAR(255) NOT NULL AFTER `ftfname`, ADD `ftlname` VARCHAR(255) NOT NULL AFTER `ftmname`, ADD `ftgender` VARCHAR(255) NOT NULL AFTER `ftlname`, ADD `ftpnrno` VARCHAR(255) NOT NULL AFTER `ftgender`;


-- 08-APR-2023 Samaya Khan file code work move from 2.2 to 3.1
ALTER TABLE `companySettingsMaster` ADD `tourIdSequence` INT(11) NOT NULL DEFAULT '1' AFTER `defaultQueryType`;
ALTER TABLE `queryMaster` ADD `yearTourId` INT(11) NOT NULL DEFAULT '0' AFTER `queryConfirmingTourId`;
ALTER TABLE `queryMaster` CHANGE `queryConfirmingTourId` `monthTourId` INT(11) NOT NULL DEFAULT '0';
 
ALTER TABLE `financeYearMaster` ADD `fromDate` DATE NOT NULL AFTER `daterange`, ADD `toDate` DATE NOT NULL AFTER `fromDate`;

-- language issue in entrance,activity and itinerary title
ALTER TABLE `entranceLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `activityLanguageMaster` 
CHANGE `lang_01` `lang_01` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_02` `lang_02` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_03` `lang_03` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_04` `lang_04` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_05` `lang_05` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_06` `lang_06` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_07` `lang_07` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_08` `lang_08` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_09` `lang_09` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lang_10` `lang_10` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `subjectLanguageMaster` 
CHANGE `title` `title` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

-- payment request sectino
-- for preview cost only after final
ALTER TABLE `paymentRequestMaster` ADD `totalCompanyCost` DOUBLE NOT NULL DEFAULT '0' AFTER `duetime`;
ALTER TABLE `paymentRequestMaster` ADD `totalClientCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalCompanyCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalClientCostWithMarkup` DOUBLE NOT NULL DEFAULT '0' AFTER `totalClientCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalMarkupCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalClientCostWithMarkup`;
ALTER TABLE `paymentRequestMaster` ADD `totalISOCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalMarkupCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalConsortiaCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalISOCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalClientCommCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalConsortiaCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalDiscountCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalClientCommCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalServiceTaxCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalDiscountCost`;
ALTER TABLE `paymentRequestMaster` ADD `totalTCSCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalServiceTaxCost`;
ALTER TABLE `paymentRequestMaster` ADD `sglBasisCost` DOUBLE NOT NULL DEFAULT '0' AFTER `totalTCSCost`;
ALTER TABLE `paymentRequestMaster` ADD `dblBasisCost` DOUBLE NOT NULL DEFAULT '0' AFTER `sglBasisCost`;
ALTER TABLE `paymentRequestMaster` ADD `twinCost` DOUBLE NOT NULL DEFAULT '0' AFTER `dblBasisCost`;
ALTER TABLE `paymentRequestMaster` ADD `tplBasisCost` DOUBLE NOT NULL DEFAULT '0' AFTER `twinCost`;
ALTER TABLE `paymentRequestMaster` ADD `extraAdultCost` DOUBLE NOT NULL DEFAULT '0' AFTER `tplBasisCost`;
ALTER TABLE `paymentRequestMaster` ADD `CWBCost` DOUBLE NOT NULL DEFAULT '0' AFTER `extraAdultCost`;
ALTER TABLE `paymentRequestMaster` ADD `CNBCost` DOUBLE NOT NULL DEFAULT '0' AFTER `CWBCost`;

ALTER TABLE `paymentRequestMaster` ADD `currencyId` INT(11) NOT NULL DEFAULT '0' AFTER `CNBCost`;
ALTER TABLE `paymentRequestMaster` ADD `serviceTax` INT(11) NOT NULL DEFAULT '0' AFTER `currencyId`;
ALTER TABLE `paymentRequestMaster` ADD `gstType` INT(11) NOT NULL DEFAULT '1' AFTER `serviceTax`;
ALTER TABLE `paymentRequestMaster` ADD `tcsTax` INT(11) NOT NULL DEFAULT '0' AFTER `gstType`;
ALTER TABLE `paymentRequestMaster` ADD `commissionType` INT(11) NOT NULL DEFAULT '0' AFTER `tcsTax`;
ALTER TABLE `paymentRequestMaster` ADD `ISOCommission` INT(11) NOT NULL DEFAULT '0' AFTER `commissionType`;
ALTER TABLE `paymentRequestMaster` ADD `ConsortiaCommission` INT(11) NOT NULL DEFAULT '0' AFTER `ISOCommission`;
ALTER TABLE `paymentRequestMaster` ADD `ClientCommission` INT(11) NOT NULL DEFAULT '0' AFTER `ConsortiaCommission`;
ALTER TABLE `paymentRequestMaster` ADD `discountType` INT(11) NOT NULL DEFAULT '0' AFTER `ClientCommission`;
ALTER TABLE `paymentRequestMaster` ADD `discount` INT(11) NOT NULL DEFAULT '0' AFTER `discountType`; 


ALTER TABLE `agentSchedulePaymentMaster` ADD `paymentId` INT(11) NOT NULL DEFAULT '0' AFTER `agentPaymentId`;
ALTER TABLE `agentPaymentMaster` ADD `paymentId` INT(11) NOT NULL DEFAULT '0' AFTER `agentPaymentId`;
ALTER TABLE `quotationMaster` ADD `gstType` INT(1) NOT NULL DEFAULT '1' AFTER `serviceTax`;
--10-04-2023 islam fit
CREATE TABLE `fitIncExcMaster` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `termsType` INT(11) NOT NULL , `packageId` INT(11) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `travelbasic` LONGTEXT NOT NULL , `booking` LONGTEXT NOT NULL , `whyuse` LONGTEXT NOT NULL , `fit_git` VARCHAR(10) NOT NULL , `addedBy` BIGINT(20) NOT NULL , `dateAdded` BIGINT(20) NOT NULL , `modifyDate` BIGINT(20) NOT NULL , `emergencyHeading` VARCHAR(255) NOT NULL , `contactPerson` VARCHAR(255) NOT NULL , `phone` BIGINT(20) NOT NULL , `email` VARCHAR(255) NOT NULL , `availableOn` VARCHAR(255) NOT NULL , `destinationId` VARCHAR(200) NOT NULL , `status` INT(2) NOT NULL , `deletestatus` INT(11) NOT NULL , `modifyBy` BIGINT(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `fitIncExcMaster` CHANGE `packageId` `fitName` INT(11) NOT NULL;
ALTER TABLE `fitIncExcMaster` CHANGE `fitName` `fitName` VARCHAR(255) NOT NULL;
CREATE TABLE `fitLanguageMaster` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `fitId` INT(11) NOT NULL , `languageId` INT(11) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `status` INT(11) NOT NULL DEFAULT '1' , `modifyDate` BIGINT(20) NOT NULL , `modifyBy` BIGINT(20) NOT NULL , `dateAdded` BIGINT(20) NOT NULL , `addedBy` BIGINT(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
 
-- 11-APR-2023 Samaya Khan 
ALTER TABLE `quotationMaster` CHANGE `TCS` `tcs` INT(3) NOT NULL;
 
ALTER TABLE `agentPaymentMaster` ADD `chequeNo` VARCHAR(255) NOT NULL AFTER `remark`, ADD `bankName` VARCHAR(255) NOT NULL AFTER `chequeNo`;
ALTER TABLE `agentPaymentMaster` ADD `receiptDate` DATE NOT NULL AFTER `dateAdded`;

--11-04-2023 Mausam khan
 CREATE TABLE `flightMultiDetailMaster` (`id` INT NOT NULL AUTO_INCREMENT , `quotationId` INT NOT NULL , `srn` INT NOT NULL , `parentId` INT NOT NULL , `title` VARCHAR(255) NOT NULL , `firstName` VARCHAR(255) NOT NULL , `middleName` VARCHAR(255) NOT NULL , `lastName` VARCHAR(255) NOT NULL , `gender` VARCHAR(255) NOT NULL , `pnrNo` INT NOT NULL , `confirmationNo` INT NOT NULL , `status` INT NOT NULL , `deletestatus` INT NOT NULL , `dateAdded` DATE NOT NULL , `addedBy` INT NOT NULL, PRIMARY KEY(`id`) ) ENGINE = InnoDB;
 CREATE TABLE `trainMultiDetailMaster` (`id` INT NOT NULL AUTO_INCREMENT , `quotationId` INT NOT NULL , `srn` INT NOT NULL , `parentId` INT NOT NULL , `title` VARCHAR(255) NOT NULL , `firstName` VARCHAR(255) NOT NULL , `middleName` VARCHAR(255) NOT NULL , `lastName` VARCHAR(255) NOT NULL , `gender` VARCHAR(255) NOT NULL , `pnrNo` INT NOT NULL , `confirmationNo` INT NOT NULL , `status` INT NOT NULL , `deletestatus` INT NOT NULL , `dateAdded` DATE NOT NULL , `addedBy` INT NOT NULL, PRIMARY KEY(`id`) ) ENGINE = InnoDB;
 

CREATE TABLE `fitLanguageMaster` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `fitId` INT(11) NOT NULL , `languageId` INT(11) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `status` INT(11) NOT NULL DEFAULT '1' , `modifyDate` BIGINT(20) NOT NULL , `modifyBy` BIGINT(20) NOT NULL , `dateAdded` BIGINT(20) NOT NULL , `addedBy` BIGINT(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


--11-04-2023 islam fit inclusion etc. quation part
CREATE TABLE `quotationFit` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `quotationId` INT(11) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `destinationId` INT(11) NOT NULL , `overviewNameId` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `quotationFit` CHANGE `overviewNameId` `fitincexNameId` INT(11) NOT NULL DEFAULT '0';

 ALTER TABLE `trainMultiDetailMaster` CHANGE `confirmationNo` `confirmationNo` VARCHAR(255) NOT NULL;
 ALTER TABLE `trainMultiDetailMaster` CHANGE `pnrNo` `pnrNo` VARCHAR(255) NOT NULL;
 ALTER TABLE `flightMultiDetailMaster` CHANGE `pnrNo` `pnrNo` VARCHAR(255) NOT NULL;
 ALTER TABLE `flightMultiDetailMaster` CHANGE `confirmationNo` `confirmationNo` VARCHAR(255) NOT NULL;


-- 12-04-2023 Mausam Khan
CREATE TABLE `trainTimeLineMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationId` int(11) NOT NULL,
  `queryId` int(11) NOT NULL,
  `trainQuoteId` int(11) NOT NULL,
  `trainId` int(11) NOT NULL,
  `dayId` int(11) NOT NULL,
  `departureDate` date NOT NULL,
  `departureTime` time NOT NULL,
  `arrivalDate` date NOT NULL,
  `arrivalTime` time NOT NULL,
  `status` tinyint(4) NOT NULL,
  `deletestatus` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;



--13-04-2023 islam git
CREATE TABLE `gitIncExcMaster` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `termsType` INT(11) NOT NULL , `gitName` VARCHAR(255) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `travelbasic` LONGTEXT NOT NULL , `booking` LONGTEXT NOT NULL , `whyuse` LONGTEXT NOT NULL , `fit_git` VARCHAR(10) NOT NULL , `addedBy` BIGINT(20) NOT NULL , `dateAdded` BIGINT(20) NOT NULL , `modifyDate` BIGINT(20) NOT NULL , `emergencyHeading` VARCHAR(255) NOT NULL , `contactPerson` VARCHAR(255) NOT NULL , `phone` BIGINT(20) NOT NULL , `email` VARCHAR(255) NOT NULL , `availableOn` VARCHAR(255) NOT NULL , `destinationId` VARCHAR(200) NOT NULL , `status` INT(2) NOT NULL , `deletestatus` INT(11) NOT NULL , `modifyBy` BIGINT(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `gitLanguageMaster` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `gitId` INT(11) NOT NULL , `languageId` INT(11) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `status` INT(11) NOT NULL DEFAULT '1' , `modifyDate` BIGINT(20) NOT NULL , `modifyBy` BIGINT(20) NOT NULL , `dateAdded` BIGINT(20) NOT NULL , `addedBy` BIGINT(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `quotationGit` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `quotationId` INT(11) NOT NULL , `inclusion` LONGTEXT NOT NULL , `exclusion` LONGTEXT NOT NULL , `termscondition` LONGTEXT NOT NULL , `cancelation` LONGTEXT NOT NULL , `paymentpolicy` LONGTEXT NOT NULL , `remarks` LONGTEXT NOT NULL , `destinationId` INT(11) NOT NULL , `gitincexNameId` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- 13-04-2023 Mausam Khan
ALTER TABLE `moduleMaster` ADD `selectStatus` INT NOT NULL DEFAULT '0' AFTER `sr`;
ALTER TABLE `moduleMaster` ADD `disableStatus` INT NOT NULL DEFAULT '0' AFTER `selectStatus`;

-- 19-04-2023 Samaya Khan
ALTER TABLE `quotationMaster` ADD `slabAndRoomType` INT(1) NOT NULL DEFAULT '1' AFTER `calculationType`;

ALTER TABLE `totalPaxSlab` 
ADD `adult` INT(11) NOT NULL DEFAULT '0' AFTER `DF_CBED`, 
ADD `child` INT(11) NOT NULL DEFAULT '0' AFTER `adult`,  
ADD `infant` INT(11) NOT NULL DEFAULT '0' AFTER `child`,
ADD `sglRoom` INT(11) NOT NULL DEFAULT '0' AFTER `infant`, 
ADD `dblRoom` INT(11) NOT NULL DEFAULT '0' AFTER `sglRoom`, 
ADD `twinRoom` INT(11) NOT NULL DEFAULT '0' AFTER `dblRoom`, 
ADD `tplRoom` INT(11) NOT NULL DEFAULT '0' AFTER `twinRoom`, 
ADD `quadNoofRoom` INT(11) NOT NULL DEFAULT '0' AFTER `tplRoom`, 
ADD `sixNoofBedRoom` INT(11) NOT NULL DEFAULT '0' AFTER `quadNoofRoom`, 
ADD `eightNoofBedRoom` INT(11) NOT NULL DEFAULT '0' AFTER `sixNoofBedRoom`, 
ADD `tenNoofBedRoom` INT(11) NOT NULL DEFAULT '0' AFTER `eightNoofBedRoom`, 
ADD `teenNoofRoom` INT(11) NOT NULL DEFAULT '0' AFTER `tenNoofBedRoom`, 
ADD `extraNoofBed` INT(11) NOT NULL DEFAULT '0' AFTER `teenNoofRoom`, 
ADD `childwithNoofBed` INT(11) NOT NULL DEFAULT '0' AFTER `extraNoofBed`, 
ADD `childwithoutNoofBed` INT(11) NOT NULL DEFAULT '0' AFTER `childwithNoofBed`;

--20-04-2023 islam flight via
ALTER TABLE `flightTimeLineMaster` ADD `departurefrom` VARCHAR(255) NOT NULL AFTER `remark`, ADD `departureto` VARCHAR(255) NOT NULL AFTER `departurefrom`, ADD `via` VARCHAR(255) NOT NULL AFTER `departureto`;
 
--27-04-2023 samay
ALTER TABLE `quotationServiceMarkup` ADD `package` FLOAT NOT NULL AFTER `quotationId`;
ALTER TABLE `quotationServiceMarkup` ADD `packageMarkupType` INT(11) NOT NULL DEFAULT '0' AFTER `package`;
 

CREATE TABLE `finalPackWiseRateMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queryId` int(11) NOT NULL DEFAULT 0,
  `quotationId` int(11) NOT NULL DEFAULT 0,
  `singleCost` int(11) NOT NULL DEFAULT 0,
  `doubleCost` int(11) NOT NULL DEFAULT 0,
  `tripleCost` int(11) NOT NULL DEFAULT 0,
  `twinCost` int(11) NOT NULL DEFAULT 0,
  `quadCost` int(11) NOT NULL DEFAULT 0,
  `sixBedCost` int(11) NOT NULL DEFAULT 0,
  `eightBedCost` int(11) NOT NULL DEFAULT 0,
  `tenBedCost` int(11) NOT NULL DEFAULT 0,
  `teenBedCost` int(11) NOT NULL DEFAULT 0,
  `extraBedACost` int(11) NOT NULL DEFAULT 0,
  `childwithbedCost` int(11) NOT NULL DEFAULT 0,
  `childwithoutbedCost` int(11) NOT NULL DEFAULT 0,
  `infantBedCost` int(11) NOT NULL,
  `guideA` int(11) NOT NULL DEFAULT 0,
  `activityA` int(11) NOT NULL DEFAULT 0,
  `entranceA` int(11) NOT NULL DEFAULT 0,
  `enrouteA` int(11) NOT NULL DEFAULT 0,
  `transferA` int(11) NOT NULL DEFAULT 0,
  `trainA` int(11) NOT NULL DEFAULT 0,
  `flightA` int(11) NOT NULL DEFAULT 0,
  `restaurantA` int(11) NOT NULL DEFAULT 0,
  `otherA` int(11) NOT NULL DEFAULT 0,
  `guideC` int(11) NOT NULL DEFAULT 0,
  `activityC` int(11) NOT NULL DEFAULT 0,
  `entranceC` int(11) NOT NULL DEFAULT 0,
  `enrouteC` int(11) NOT NULL DEFAULT 0,
  `transferC` int(11) NOT NULL DEFAULT 0,
  `trainC` int(11) NOT NULL DEFAULT 0,
  `flightC` int(11) NOT NULL DEFAULT 0,
  `restaurantC` int(11) NOT NULL DEFAULT 0,
  `otherC` int(11) NOT NULL DEFAULT 0,
  `supplierId` int(11) NOT NULL DEFAULT 0,
  `currencyId` int(11) NOT NULL DEFAULT 0,
  `currencyValue` int(11) NOT NULL DEFAULT 0,
  `singleBasis` int(11) NOT NULL DEFAULT 0,
  `doubleBasis` int(11) NOT NULL DEFAULT 0,
  `tripleBasis` int(11) NOT NULL DEFAULT 0,
  `twinBasis` int(11) NOT NULL DEFAULT 0,
  `quadBasis` int(11) NOT NULL DEFAULT 0,
  `sixBedBasis` int(11) NOT NULL DEFAULT 0,
  `eightBedBasis` int(11) NOT NULL DEFAULT 0,
  `tenBedBasis` int(11) NOT NULL DEFAULT 0,
  `teenBedBasis` int(11) NOT NULL DEFAULT 0,
  `extraBedABasis` int(11) NOT NULL DEFAULT 0,
  `childwithbedBasis` int(11) NOT NULL DEFAULT 0,
  `childwithoutbedBasis` int(11) NOT NULL DEFAULT 0,
  `infantBedBasis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
ALTER TABLE `quotationMaster` ADD `totalCompanyPackageCost` FLOAT NOT NULL DEFAULT '0' AFTER `totalCompanyCost`;
 --25-04-2023 Mausam khan
ALTER TABLE `supplierDocumentMaster` ADD `quotationId` INT NOT NULL AFTER `id`;
 
--28-04-2023 samay khan
ALTER TABLE `quotationMaster` ADD `infantBasisCost` FLOAT NOT NULL DEFAULT '0' AFTER `CNBCost`;
ALTER TABLE `quotationMaster` ADD `flightRequired` FLOAT NOT NULL DEFAULT '1' AFTER `passportRequired`;
 
--27-04-2023 Mausam khan
ALTER TABLE `visaRateMaster` ADD `vfsCharges` INT NOT NULL AFTER `processingFee`, ADD `embassyFee` INT NOT NULL AFTER `vfsCharges`;

ALTER TABLE `quotationVisaRateMaster` ADD `vfsCharges` INT NOT NULL AFTER `processingFee`, ADD `embassyFee` INT NOT NULL AFTER `vfsCharges`;

--29-04-2023 Mausam khan
ALTER TABLE `finalQuoteVisa` ADD `embassyFee` INT NOT NULL AFTER `processingFee`, ADD `vfsCharges` INT NOT NULL AFTER `embassyFee`;
 
 ALTER TABLE `companySettingsMaster` ADD `sameOtherSTax` INT NOT NULL AFTER `tourIdSequence`, ADD `taxOnly` INT NOT NULL AFTER `sameOtherSTax`;
 
ALTER TABLE `invoiceMaster` ADD `gstAMT` INT NOT NULL AFTER `stg`;

ALTER TABLE `invoiceMaster` ADD `invoiceFormat` TINYINT NOT NULL AFTER `invoiceType`;

--islam 04-05-2023 webform 
ALTER TABLE `queryMaster` ADD `contryCode` VARCHAR(255) NOT NULL AFTER `FDCode`;
ALTER TABLE `queryMaster` ADD `fromWB` VARCHAR(255) NOT NULL AFTER `destinationId`;
--4-05-2023 Mausam khan
CREATE TABLE `invoiceOtherDetailMaster` (`id` INT NOT NULL AUTO_INCREMENT , `quotationId` INT NOT NULL , `queryId` INT NOT NULL , `invoiceId` INT NOT NULL , `particular` TEXT NOT NULL , `hsnCode` VARCHAR(255) NOT NULL , `serialNo` INT NOT NULL , `serviceType` VARCHAR(255) NOT NULL , `invoiceDate` DATE NULL DEFAULT NULL , `deletestatus` TINYINT NOT NULL , `status` TINYINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;


ALTER TABLE `invoiceOtherDetailMaster` ADD `sglParticular` TEXT NOT NULL AFTER `hsnCode`, ADD `sglhsnId` INT NOT NULL AFTER `sglParticular`, ADD `dblParticular` TEXT NOT NULL AFTER `sglhsnId`, ADD `dblhsnId` INT NOT NULL AFTER `dblParticular`, ADD `tplParticular` TEXT NOT NULL AFTER `dblhsnId`, ADD `tplhsnId` INT NOT NULL AFTER `tplParticular`, ADD `twinParticular` TEXT NOT NULL AFTER `tplhsnId`, ADD `twinhsnId` INT NOT NULL AFTER `twinParticular`, ADD `EBAParticular` TEXT NOT NULL AFTER `twinhsnId`, ADD `EBAhsnId` INT NOT NULL AFTER `EBAParticular`, ADD `EBCParticular` TEXT NOT NULL AFTER `EBAhsnId`, ADD `EBChsnId` INT NOT NULL AFTER `EBCParticular`, ADD `EBNParticular` TEXT NOT NULL AFTER `EBChsnId`, ADD `EBNhsnId` INT NOT NULL AFTER `EBNParticular`, ADD `quadParticular` TEXT NOT NULL AFTER `EBNhsnId`, ADD `quadhsnId` INT NOT NULL AFTER `quadParticular`, ADD `sixParticular` TEXT NOT NULL AFTER `quadhsnId`, ADD `sixhsnId` INT NOT NULL AFTER `sixParticular`, ADD `eightParticular` TEXT NOT NULL AFTER `sixhsnId`, ADD `eighthsnId` INT NOT NULL AFTER `eightParticular`, ADD `tenParticular` TEXT NOT NULL AFTER `eighthsnId`, ADD `tenhsnId` INT NOT NULL AFTER `tenParticular`;

ALTER TABLE `invoiceOtherDetailMaster` ADD `adultParticular` TEXT NOT NULL AFTER `tenhsnId`, ADD `adulthsnId` INT NOT NULL AFTER `adultParticular`, ADD `childParticular` TEXT NOT NULL AFTER `adulthsnId`, ADD `childhsnId` INT NOT NULL AFTER `childParticular`, ADD `infantParticular` TEXT NOT NULL AFTER `childhsnId`, ADD `infanthsnId` INT NOT NULL AFTER `infantParticular`, ADD `perPParticular` TEXT NOT NULL AFTER `infanthsnId`, ADD `perPhsnId` INT NOT NULL AFTER `perPParticular`;


--islam 05-05-2023 +91 country code
ALTER TABLE `chainhotelmaster` ADD `countryCode` VARCHAR(255) NOT NULL AFTER `phone`;
-- 08-May-2023 Mausam Khan
ALTER TABLE `invoiceMaster` ADD `guestName` VARCHAR(255) NOT NULL AFTER `deliveryPlace`;

--09-05-2023 Mausam Khan
ALTER TABLE `dmctransferRate` ADD `rateDestinationId` INT NOT NULL AFTER `serviceid`;

--12-05-2023 islam fit and git default
ALTER TABLE `fitIncExcMaster` ADD `byDefault` INT(2) NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `gitIncExcMaster` ADD `byDefault` INT(2) NOT NULL DEFAULT '0' AFTER `status`;

--12-05-2023 islam bank master 
ALTER TABLE `bankMaster` ADD `bankupid` VARCHAR(250) NOT NULL AFTER `branchIFSC`, ADD `qrcodeimage` VARCHAR(250) NOT NULL AFTER `bankupid`;


--islam 12-05-2023 by default nationality
ALTER TABLE `companySettingsMaster` ADD `nationality` INT(11) NOT NULL AFTER `countryId`;
-- 19-05-2023 Mausam Khan
ALTER TABLE `leadssourceMaster` ADD `setDefault` TINYINT NOT NULL AFTER `userId`;


--20-05-2023 --islam -- social media links 
ALTER TABLE `packageTermsCondtionsMaster` ADD `facelogo` VARCHAR(250) NOT NULL AFTER `availableOn`, ADD `faceurl` VARCHAR(250) NOT NULL AFTER `facelogo`, ADD `twitterlogo` VARCHAR(250) NOT NULL AFTER `faceurl`, ADD `twitterurl` VARCHAR(250) NOT NULL AFTER `twitterlogo`, ADD `instalogo` VARCHAR(250) NOT NULL AFTER `twitterurl`, ADD `instaurl` VARCHAR(250) NOT NULL AFTER `instalogo`, ADD `linklogo` VARCHAR(250) NOT NULL AFTER `instaurl`, ADD `linkurl` VARCHAR(250) NOT NULL AFTER `linklogo`, ADD `facename` VARCHAR(250) NOT NULL AFTER `linkurl`, ADD `twittername` VARCHAR(250) NOT NULL AFTER `facename`, ADD `instaname` VARCHAR(250) NOT NULL AFTER `twittername`, ADD `linkname` VARCHAR(250) NOT NULL AFTER `instaname`;
ALTER TABLE `packageTermsCondtionsMaster` ADD `socialmediadtlshow` INT(11) NOT NULL DEFAULT '0' AFTER `linkname`, ADD `contactdddttl` INT(11) NOT NULL DEFAULT '0' AFTER `socialmediadtlshow`;
ALTER TABLE `bankMaster` ADD `bydefshowhide` INT(11) NOT NULL DEFAULT '1' AFTER `addedBy`;
ALTER TABLE `leadManageMaster` ADD `OpsAssignTo` INT NOT NULL AFTER `assignTo`;

ALTER TABLE `leadManageMaster` CHANGE `clientType` `clientType` TINYINT NOT NULL DEFAULT '1';


--22-05-2023 islam
ALTER TABLE `companySettingsMaster` ADD `compcountryCode` INT(11) NOT NULL AFTER `countryId`;

-- 23-May-2023 Mausam Khan
ALTER TABLE `suppliersMaster` CHANGE `destinationId` `destinationId` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';
ALTER TABLE `suppliersMaster` ADD `destinationWise` TINYINT NOT NULL AFTER `destinationId`;
ALTER TABLE `suppliersMaster` ADD `countryWise` INT(11) NOT NULL AFTER `destinationWise`;

 -- migration fixes
ALTER TABLE `quotationExtraMaster` CHANGE `infantCost` `infantCost` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `childCost`, CHANGE `costType` `costType` TINYINT(4) NOT NULL AFTER `groupCost`, CHANGE `currencyValue` `currencyValue` DOUBLE NOT NULL DEFAULT '0' AFTER `currencyId`;

ALTER TABLE `dmcotherActivityRate` ADD `maxpax` VARCHAR(255) NOT NULL AFTER `nationality`, ADD `perPaxCost` VARCHAR(255) NOT NULL AFTER `maxpax`;
 
--02-06-2023 islam multiple contact
ALTER TABLE `restaurantContactPersonMaster` ADD `phone2` VARCHAR(14) NOT NULL AFTER `phone`, ADD `phone3` VARCHAR(14) NOT NULL AFTER `phone2`;

ALTER TABLE `suppliercontactPersonMaster` ADD `phone2` VARCHAR(14) NOT NULL AFTER `phone`, ADD `phone3` VARCHAR(14) NOT NULL AFTER `phone2`;

ALTER TABLE `hotelContactPersonMaster` ADD `phone2` VARCHAR(14) NOT NULL AFTER `phone`, ADD `phone3` VARCHAR(14) NOT NULL AFTER `phone2`;

-- 03-June-2023 Mausam Khan
ALTER TABLE `cruiseCompanyMaster` ADD `deletestatus` TINYINT NOT NULL DEFAULT '0' AFTER `cityId`;
ALTER TABLE `cruiseCompanyMaster` ADD `destinationId` VARCHAR(255) NOT NULL AFTER `address`;

ALTER TABLE `cruiseCompanyMaster` ADD `contactPerson` VARCHAR(255) NOT NULL AFTER `deletestatus`, ADD `phone` BIGINT NOT NULL AFTER `contactPerson`, ADD `email` VARCHAR(255) NOT NULL AFTER `phone`, ADD `division` VARCHAR(100) NOT NULL AFTER `email`, ADD `designation` VARCHAR(255) NOT NULL AFTER `division`, ADD `dateAdded` BIGINT NOT NULL AFTER `designation`, ADD `addedBy` INT NOT NULL AFTER `dateAdded`, ADD `modifyBy` INT NOT NULL AFTER `addedBy`, ADD `modifyDate` BIGINT NOT NULL AFTER `modifyBy`;

ALTER TABLE `cruiseCompanyMaster` ADD `website` VARCHAR(255) NOT NULL AFTER `modifyDate`;

ALTER TABLE `packageBuilderTransportMaster` CHANGE `destinationId` `destinationId` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- 06-June-2023 Mausam Khan
ALTER TABLE `cabinTypeMaster` ADD `cruiseNameId` INT NOT NULL AFTER `name`;
ALTER TABLE `cabinTypeMaster` ADD `modifyBy` INT NOT NULL AFTER `status`, ADD `modifyDate` BIGINT NOT NULL AFTER `modifyBy`;

ALTER TABLE `cabinTypeMaster` ADD `dateAdded` BIGINT NOT NULL AFTER `modifyDate`, ADD `addedBy` INT NOT NULL AFTER `dateAdded`;

ALTER TABLE `cruiseMaster` ADD `runningDays` VARCHAR(255) NOT NULL AFTER `duration`;

DROP TABLE IF EXISTS `cruiseServiceTiming`;
CREATE TABLE `cruiseServiceTiming` (`id` INT NOT NULL AUTO_INCREMENT , `cruiseMasterId` INT NOT NULL , `arrivalTime` TIME NULL DEFAULT NULL , `arrivalDate` DATETIME NULL DEFAULT NULL , `departureTime` TIME NULL DEFAULT NULL , `departureDate` DATETIME NULL DEFAULT NULL , `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL , `dateAdded` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

DROP TABLE IF EXISTS `cruiseratemaster`;
CREATE TABLE `cruiseRateMaster` (`id` INT NOT NULL AUTO_INCREMENT , `serviceId` INT NOT NULL , `supplierId` INT NOT NULL , `cruiseNameId` INT NOT NULL , `cabinTypeId` INT NOT NULL , `tariffTypeId` INT NOT NULL , `marketType` INT NOT NULL , `fromDate` DATE NOT NULL , `toDate` DATE NOT NULL , `gstTax` INT NOT NULL , `currencyId` INT NOT NULL , `currencyValue` INT NOT NULL , `adultCost` INT NOT NULL , `childCost` INT NOT NULL , `infantCost` INT NOT NULL , `markupType` INT NOT NULL , `markupCost` INT NOT NULL , `remark` TEXT NOT NULL , `status` TINYINT NOT NULL , `addedBy` INT NOT NULL , `dateAdded` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

 --09-06-2023 islam text slab
 ALTER TABLE `gstMaster` CHANGE `setDefault` `setDefault` INT(11) NOT NULL DEFAULT '0';
 
--12-06-2023 country code emargency
ALTER TABLE `packageTermsCondtionsMaster` ADD `countryCode` INT(11) NOT NULL AFTER `phone`;
ALTER TABLE `packageTermsCondtionsMaster` CHANGE `countryCode` `countryCode` VARCHAR(11) NOT NULL;

--13-06-2023 islam multiple contact
ALTER TABLE `restaurantContactPersonMaster` ADD `phone2` VARCHAR(14) NOT NULL AFTER `phone`, ADD `phone3` VARCHAR(14) NOT NULL AFTER `phone2`;

ALTER TABLE `suppliercontactPersonMaster` ADD `phone2` VARCHAR(14) NOT NULL AFTER `phone`, ADD `phone3` VARCHAR(14) NOT NULL AFTER `phone2`;

ALTER TABLE `hotelContactPersonMaster` ADD `phone2` VARCHAR(14) NOT NULL AFTER `phone`, ADD `phone3` VARCHAR(14) NOT NULL AFTER `phone2`;


--17-06-2023-- islam 
ALTER TABLE `companySettingsMaster` ADD `compcountryCode` INT(11) NOT NULL AFTER `baseCurrencyId`;

 --26-06-2023 islam market type
 ALTER TABLE `marketMaster` ADD `setDefault` INT(11) NOT NULL DEFAULT '0' AFTER `status`;

--01-07-2023 islam Overview
 ALTER TABLE `overviewMaster` ADD `itineraryintr` TEXT NOT NULL AFTER `highlight`, ADD `itinerarysumm` TEXT NOT NULL AFTER `itineraryintr`;
--01-07-2023 islam Fit 
 ALTER TABLE `fitIncExcMaster` ADD `serviceupgradation` TEXT NOT NULL AFTER `cancelation`, ADD `optionaltour` TEXT NOT NULL AFTER `serviceupgradation`;
 --03-07-2023 islam Fit 
 ALTER TABLE `gitIncExcMaster` ADD `serviceupgradation` TEXT NOT NULL AFTER `cancelation`, ADD `optionaltour` TEXT NOT NULL AFTER `serviceupgradation`;


--03-07-2023 islam Overview 
 ALTER TABLE `overviewLanguageMaster` ADD `itineraryintr` LONGTEXT NOT NULL AFTER `highlight`, ADD `itinerarysumm` LONGTEXT NOT NULL AFTER `itineraryintr`;
 ALTER TABLE `quotationOverview` ADD `itineraryintr` TEXT NOT NULL AFTER `overview`, ADD `itinerarysumm` TEXT NOT NULL AFTER `itineraryintr`;

--03-07-2023 islam Fit
ALTER TABLE `quotationFit` ADD `serviceupgradation` TEXT NOT NULL AFTER `cancelation`, ADD `optionaltour` TEXT NOT NULL AFTER `serviceupgradation`;
ALTER TABLE `fitLanguageMaster` ADD `serviceupgradation` TEXT NOT NULL AFTER `cancelation`, ADD `optionaltour` TEXT NOT NULL AFTER `serviceupgradation`;
 

--04-07-2023 islam GIT
ALTER TABLE `gitLanguageMaster` ADD `serviceupgradation` TEXT NOT NULL AFTER `cancelation`, ADD `optionaltour` TEXT NOT NULL AFTER `serviceupgradation`;
ALTER TABLE `quotationGit` ADD `serviceupgradation` TEXT NOT NULL AFTER `cancelation`, ADD `optionaltour` TEXT NOT NULL AFTER `serviceupgradation`;

-- 05-07-2023 Mausam Khan
ALTER TABLE `packageBuilderEntranceMaster` ADD `isOptTours` TINYINT NOT NULL DEFAULT '0' AFTER `isDefault`;
ALTER TABLE `packageBuilderotherActivityMaster` ADD `isOptTours` TINYINT NOT NULL DEFAULT '0' AFTER `isDefault`;
ALTER TABLE `packageBuilderTransportMaster` ADD `isOptTours` TINYINT NOT NULL DEFAULT '0' AFTER `status`;

ALTER TABLE `packageBuilderTransportMaster` ADD `adultCost` INT NOT NULL AFTER `transferCategory`, ADD `childCost` INT NOT NULL AFTER `adultCost`;

--06-07-2023-islam
ALTER TABLE `packageTermsCondtionsMaster` ADD `youtubename` VARCHAR(255) NOT NULL AFTER `linkname`, ADD `youtubeurl` VARCHAR(255) NOT NULL AFTER `youtubename`, ADD `youtubelogo` VARCHAR(255) NOT NULL AFTER `youtubeurl`;

--06-07-2023-Mausam Khan
ALTER TABLE `packageBuilderTransportMaster` ADD `currencyId` INT NOT NULL DEFAULT '0' AFTER `isOptTours`;

 --06-07-2023--islam
 ALTER TABLE `quotationMaster` ADD `itineraryintrText` LONGTEXT NOT NULL AFTER `overviewText`, ADD `itinerarysummText` LONGTEXT NOT NULL AFTER `itineraryintrText`;
 ALTER TABLE `quotationMaster` ADD `serviceupgradationText` LONGTEXT NOT NULL AFTER `exclusion`, ADD `optionaltourText` LONGTEXT NOT NULL AFTER `serviceupgradationText`;


 --07-07-2023-islam
 INSERT INTO `proposalSettingMaster` (`id`, `proposalName`, `proposalNum`, `proposalPhoto`, `proposalColor`, `textColor`, `photoDimension`, `modifyBy`, `addedBy`, `dateAdded`, `modifyDate`, `deletestatus`, `headerImage`, `footerImage`, `footerstatus`, `isProposalCost`) VALUES (NULL, 'Vista Proposal', '9', NULL, '#841d0b', '#ffffff', '750x500', '', '', '', '', '0', NULL, NULL, '0', '1');


--07-07-2023-Mausam Khan
 ALTER TABLE `overviewMaster` ADD `overviewTitle_1` VARCHAR(255) NOT NULL AFTER `overviewName`, ADD `overviewTitle_2` VARCHAR(255) NOT NULL AFTER `overviewTitle_1`, ADD `overviewTitle_3` VARCHAR(255) NOT NULL AFTER `overviewTitle_2`, ADD `overviewTitle_4` VARCHAR(255) NOT NULL AFTER `overviewTitle_3`, ADD `overviewTitle_5` VARCHAR(255) NOT NULL AFTER `overviewTitle_4`;

 ALTER TABLE `fitIncExcMaster` ADD `title_1` VARCHAR(255) NOT NULL AFTER `remarks`, ADD `title_2` VARCHAR(255) NOT NULL AFTER `title_1`, ADD `title_3` VARCHAR(255) NOT NULL AFTER `title_2`, ADD `title_4` VARCHAR(255) NOT NULL AFTER `title_3`, ADD `title_5` VARCHAR(255) NOT NULL AFTER `title_4`, ADD `title_6` VARCHAR(255) NOT NULL AFTER `title_5`, ADD `title_7` VARCHAR(255) NOT NULL AFTER `title_6`, ADD `title_8` VARCHAR(255) NOT NULL AFTER `title_7`, ADD `title_9` VARCHAR(255) NOT NULL AFTER `title_8`;


  ALTER TABLE `gitIncExcMaster` ADD `title_1` VARCHAR(255) NOT NULL AFTER `remarks`, ADD `title_2` VARCHAR(255) NOT NULL AFTER `title_1`, ADD `title_3` VARCHAR(255) NOT NULL AFTER `title_2`, ADD `title_4` VARCHAR(255) NOT NULL AFTER `title_3`, ADD `title_5` VARCHAR(255) NOT NULL AFTER `title_4`, ADD `title_6` VARCHAR(255) NOT NULL AFTER `title_5`, ADD `title_7` VARCHAR(255) NOT NULL AFTER `title_6`, ADD `title_8` VARCHAR(255) NOT NULL AFTER `title_7`, ADD `title_9` VARCHAR(255) NOT NULL AFTER `title_8`;

  --08-07-2023-Mausam Khan
  ALTER TABLE `quotationMaster` ADD `overviewId` INT NOT NULL AFTER `insuranceCostType`, ADD `fitGitId` INT NOT NULL AFTER `overviewId`;

  -- 10-07-2023 Mausam Khan
  ALTER TABLE `hotelCategoryMaster` ADD `proposalCategory` VARCHAR(255) NOT NULL AFTER `uploadKeyword`;

    -- 22-07-2023 Mausam Khan
  ALTER TABLE `quotationEntranceMaster` ADD `noOfVehicles` INT NOT NULL AFTER `endDayDate`;
   -- 24-07-2023 Mausam Khan
  ALTER TABLE `quotationOtherActivitymaster` ADD `noOfVehicles` TINYINT NOT NULL AFTrER `endDayDate`;
  
  -- 26-07-2023 Mohd Islam
  ALTER TABLE `businessTypeMaster` ADD `setDefault` INT(11) NOT NULL DEFAULT '0' AFTER `status`;

  --06-August-2023 Mausam Khan
  ALTER TABLE `overviewLanguageMaster` ADD `itineraryIntro` TEXT NOT NULL AFTER `highlight`, ADD `itinerarySummary` TEXT NOT NULL AFTER `itineraryIntro`;

  --14-Aug-2023 Mausam Khan
  ALTER TABLE `queryMaster` ADD `needTrain` TINYINT NOT NULL DEFAULT '0' AFTER `needFlight`, ADD `needTransfer` TINYINT NOT NULL DEFAULT '0' AFTER `needTrain`;
  -- 14-07-2023 Mohd Islam
  ALTER TABLE `contactsMaster` ADD `guestAge` VARCHAR(50) NOT NULL AFTER `birthDate`, ADD `leadpaxstatus` INT(11) NOT NULL AFTER `guestAge`;

  -- 16-07-2023 Mohd Islam
  ALTER TABLE `agentPaymentMaster` ADD `paymentshow` INT NOT NULL AFTER `amount`;

  -- 19-Aug-2023 Mausam Khan
  CREATE TABLE `flightQueryMaster` (`id` BIGINT NOT NULL AUTO_INCREMENT , `queryId` INT NOT NULL , `quotationId` INT NOT NULL , `fromDate` DATE NOT NULL , `flightQueryDate` DATETIME NOT NULL , `needFlight` TINYINT NOT NULL , `fromDestination` INT NOT NULL , `toDestination` INT NOT NULL , `adult` INT NOT NULL , `child` INT NOT NULL DEFAULT '0' , `infant` INT NOT NULL , `queryType` INT NOT NULL , `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL DEFAULT '0' , `multipleNo` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

   CREATE TABLE `visaQueryMaster` (`id` BIGINT NOT NULL AUTO_INCREMENT , `queryId` INT NOT NULL , `quotationId` INT NOT NULL , `fromDate` DATE NOT NULL , `visaQueryDate` DATETIME NOT NULL , `needVisa` TINYINT NOT NULL , `destinationId` INT NOT NULL , `adult` INT NOT NULL , `child` INT NOT NULL DEFAULT '0' , `infant` INT NOT NULL , `queryType` INT NOT NULL , `visaTypeId` INT NOT NULL , `visaValidity` VARCHAR(100) NOT NULL , `entryType` INT NOT NULL , `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL DEFAULT '0' , `multipleNo` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

   CREATE TABLE `insuranceQueryMaster` (`id` BIGINT NOT NULL AUTO_INCREMENT , `queryId` INT NOT NULL , `quotationId` INT NOT NULL , `fromDate` DATE NOT NULL , `toDate` DATE NOT NULL , `insuranceQueryDate` DATETIME NOT NULL , `needInsurance` TINYINT NOT NULL , `destinationId` INT NOT NULL , `adult` INT NOT NULL , `child` INT NOT NULL DEFAULT '0' , `infant` INT NOT NULL , `queryType` INT NOT NULL , `insuranceTypeId` INT NOT NULL ,  `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL DEFAULT '0' , `multipleNo` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

  CREATE TABLE `trainQueryMaster` (`id` BIGINT NOT NULL AUTO_INCREMENT , `queryId` INT NOT NULL , `quotationId` INT NOT NULL , `fromDate` DATE NOT NULL , `trainQueryDate` DATETIME NOT NULL , `needTrain` TINYINT NOT NULL , `fromDestination` INT NOT NULL , `toDestination` INT NOT NULL , `adult` INT NOT NULL , `child` INT NOT NULL DEFAULT '0' , `infant` INT NOT NULL , `queryType` INT NOT NULL , `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL DEFAULT '0' , `multipleNo` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

  CREATE TABLE `transferQueryMaster` (`id` BIGINT NOT NULL AUTO_INCREMENT , `queryId` INT NOT NULL , `quotationId` INT NOT NULL , `fromDate` DATE NOT NULL , `transferQueryDate` DATETIME NOT NULL , `needTransfer` TINYINT NOT NULL , `destinationId` INT NOT NULL , `adult` INT NOT NULL , `child` INT NOT NULL DEFAULT '0' , `infant` INT NOT NULL , `queryType` INT NOT NULL , `transferNameId` INT NOT NULL , `transferTypeId` INT NOT NULL , `status` TINYINT NOT NULL , `deletestatus` TINYINT NOT NULL DEFAULT '0' , `multipleNo` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

 -- 19-07-2023 Mohd Islam
  ALTER TABLE `queryMaster` ADD `salesPersonId` BIGINT(20) NOT NULL AFTER `assignTo`;
  
-- 21-08-2023 Mausam Khan
  ALTER TABLE `visaQueryMaster` ADD `visaNameId` INT NOT NULL AFTER `quotationId`;

  ALTER TABLE `quotationMaster` ADD `trainRequired` TINYINT NOT NULL AFTER `flightRequired`, ADD `transferRequired` TINYINT NOT NULL AFTER `trainRequired`;

  ALTER TABLE `quotationVisaRateMaster` ADD `visaDate` DATE NULL DEFAULT NULL AFTER `supplierId`, ADD `visaCountryId` INT NOT NULL AFTER `visaDate`, ADD `visaValidity` VARCHAR(255) NOT NULL AFTER `visaCountryId`, ADD `entryType` TINYINT NOT NULL AFTER `visaValidity`;

  ALTER TABLE `quotationInsuranceRateMaster` ADD `countryId` INT NOT NULL AFTER `supplierId`, ADD `insuranceStartDate` DATE NULL DEFAULT NULL AFTER `countryId`, ADD `insuranceEndDate` DATE NULL DEFAULT NULL AFTER `insuranceStartDate`;

 -- 22-08-2023 mohd islam
CREATE TABLE `dmcFlightTrainSurfaceDetails` ( `id` BIGINT(20) NOT NULL AUTO_INCREMENT , `quotationId` INT(11) NOT NULL , `transferType` VARCHAR(100) NOT NULL , `type` VARCHAR(200) NOT NULL , `name` VARCHAR(200) NOT NULL , `number` VARCHAR(200) NOT NULL , `from` VARCHAR(200) NOT NULL , `picAdd` VARCHAR(200) NOT NULL , `dropAdd` VARCHAR(200) NOT NULL , `modeType` VARCHAR(200) NOT NULL , `ArrTime` VARCHAR(200) NULL DEFAULT NULL , `DptTime` VARCHAR(200) NULL DEFAULT NULL , `arrDate` DATE NULL DEFAULT NULL , `dropDate` DATE NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


ALTER TABLE `dmcFlightTrainSurfaceDetails` CHANGE `from` `Afrom` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;


ALTER TABLE `dmcFlightTrainSurfaceDetails` ADD `Dtype` VARCHAR(200) NOT NULL AFTER `dropDate`, ADD `Dname` VARCHAR(200) NOT NULL AFTER `Dtype`, ADD `Dnumber` VARCHAR(200) NOT NULL AFTER `Dname`, ADD `Dfrom` VARCHAR(200) NOT NULL AFTER `Dnumber`, ADD `DpicAdd` VARCHAR(200) NOT NULL AFTER `Dfrom`, ADD `DdropAdd` VARCHAR(200) NOT NULL AFTER `DpicAdd`;




ALTER TABLE `dmcFlightTrainSurfaceDetails` ADD `TrainAtype` VARCHAR(200) NOT NULL AFTER `DdropAdd`, ADD `TrainAname` VARCHAR(200) NOT NULL AFTER `TrainAtype`, ADD `TrainAnumber` VARCHAR(200) NOT NULL AFTER `TrainAname`, ADD `TrainAfrom` VARCHAR(200) NOT NULL AFTER `TrainAnumber`, ADD `TrainApicAdd` VARCHAR(200) NOT NULL AFTER `TrainAfrom`, ADD `TrainAdropAdd` VARCHAR(200) NOT NULL AFTER `TrainApicAdd`, ADD `TrainDtype` VARCHAR(200) NOT NULL AFTER `TrainAdropAdd`, ADD `TrainDname` VARCHAR(200) NOT NULL AFTER `TrainDtype`, ADD `TrainDnumber` VARCHAR(200) NOT NULL AFTER `TrainDname`, ADD `TrainDfrom` VARCHAR(200) NOT NULL AFTER `TrainDnumber`, ADD `TrainDpicAdd` VARCHAR(200) NOT NULL AFTER `TrainDfrom`, ADD `TrainDdropAdd` VARCHAR(200) NOT NULL AFTER `TrainDpicAdd`, ADD `TrainArrTime` VARCHAR(200) NULL DEFAULT NULL AFTER `TrainDdropAdd`, ADD `TrainDptTime` VARCHAR(200) NULL DEFAULT NULL AFTER `TrainArrTime`, ADD `TrainarrDate` DATE NULL DEFAULT NULL AFTER `TrainDptTime`, ADD `TraindropDate` DATE NULL DEFAULT NULL AFTER `TrainarrDate`;



ALTER TABLE `dmcFlightTrainSurfaceDetails` ADD `SurfaceAtype` VARCHAR(200) NOT NULL AFTER `TraindropDate`, ADD `SurfaceAname` VARCHAR(200) NOT NULL AFTER `SurfaceAtype`, ADD `SurfaceAnumber` VARCHAR(200) NOT NULL AFTER `SurfaceAname`, ADD `SurfaceAfrom` VARCHAR(200) NOT NULL AFTER `SurfaceAnumber`, ADD `SurfaceApicAdd` VARCHAR(200) NOT NULL AFTER `SurfaceAfrom`, ADD `SurfaceAdropAdd` VARCHAR(200) NOT NULL AFTER `SurfaceApicAdd`, ADD `SurfaceDtype` VARCHAR(200) NOT NULL AFTER `SurfaceAdropAdd`, ADD `SurfaceDname` VARCHAR(200) NOT NULL AFTER `SurfaceDtype`, ADD `SurfaceDnumber` VARCHAR(200) NOT NULL AFTER `SurfaceDname`, ADD `SurfaceDfrom` VARCHAR(200) NOT NULL AFTER `SurfaceDnumber`, ADD `SurfaceDpicAdd` VARCHAR(200) NOT NULL AFTER `SurfaceDfrom`, ADD `SurfaceDdropAdd` VARCHAR(200) NOT NULL AFTER `SurfaceDpicAdd`, ADD `SurfaceArrTime` VARCHAR(200) NULL DEFAULT NULL AFTER `SurfaceDdropAdd`, ADD `SurfaceDptTime` VARCHAR(200) NULL DEFAULT NULL AFTER `SurfaceArrTime`, ADD `SurfacearrDate` DATE NULL DEFAULT NULL AFTER `SurfaceDptTime`, ADD `SurfacedropDate` DATE NULL DEFAULT NULL AFTER `SurfacearrDate`;

-- 26-Aug-2023 Mausam Khan
   ALTER TABLE `finalQuoteInsurance` ADD `countryId` INT NOT NULL AFTER `supplierId`, ADD `insuranceStartDate` DATE NULL DEFAULT NULL AFTER `countryId`, ADD `insuranceEndDate` DATE NULL DEFAULT NULL AFTER `insuranceStartDate`;

  ALTER TABLE `finalQuoteVisa` ADD `visaDate` DATE NULL DEFAULT NULL AFTER `supplierId`, ADD `visaCountryId` INT NOT NULL AFTER `visaDate`, ADD `visaValidity` VARCHAR(255) NOT NULL AFTER `visaCountryId`, ADD `entryType` TINYINT NOT NULL AFTER `visaValidity`;




-- 14-Aug-2023 Mohd Islam
  ALTER TABLE `leadManageMaster` ADD `fromDate2` DATE NULL DEFAULT NULL AFTER `subject`, ADD `toDate2` DATE NULL DEFAULT NULL AFTER `fromDate2`, ADD `night2` INT(11) NOT NULL AFTER `toDate2`, ADD `adult` INT(11) NOT NULL AFTER `night2`, ADD `Child` INT(11) NOT NULL AFTER `adult`, ADD `Infant` INT(11) NOT NULL AFTER `Child`, ADD `sglRoom` INT(11) NOT NULL DEFAULT '0' AFTER `Infant`, ADD `dblRoom` INT(11) NOT NULL DEFAULT '0' AFTER `sglRoom`, ADD `twinRoom` INT(11) NOT NULL DEFAULT '0' AFTER `dblRoom`, ADD `tplRoom` INT(11) NOT NULL DEFAULT '0' AFTER `twinRoom`, ADD `quadNoofRoom` INT(11) NOT NULL DEFAULT '0' AFTER `tplRoom`, ADD `extraNoofBed` INT(11) NOT NULL DEFAULT '0' AFTER `quadNoofRoom`, ADD `cwbRoom` INT(11) NOT NULL DEFAULT '0' AFTER `extraNoofBed`, ADD `cnbRoom` INT(11) NOT NULL DEFAULT '0' AFTER `cwbRoom`;

  ALTER TABLE `leadManageMaster` ADD `guest1` VARCHAR(255) NOT NULL AFTER `subject`, ADD `additionalInfo` VARCHAR(500) NOT NULL AFTER `guest1`;


  -- 03-10-2023 Mohd Islam 
ALTER TABLE `proposalSettingMaster` ADD `selectStatus` INT(11) NOT NULL DEFAULT '0' AFTER `footerstatus`, ADD `disableStatus` INT(11) NOT NULL DEFAULT '0' AFTER `selectStatus`;

  -- 07-10-2023 Mohd Islam 
ALTER TABLE `packageBuilderotherActivityMaster` ADD `inclExclTim` TEXT NULL DEFAULT NULL AFTER `otherActivityDetail`, ADD `impNote` TEXT NULL DEFAULT NULL AFTER `inclExclTim`;

  
-- 16-10-2023 Mohd Islam 
ALTER TABLE `quotationMaster` CHANGE `isInc_exc` `isInc_exc` INT(1) NOT NULL DEFAULT '0';

-- 25-10-2023 Mausam Khan
ALTER TABLE `totalPaxSlab` ADD `DF_INF` INT NOT NULL DEFAULT '0' AFTER `DF_CBED`;

-- 27-10-2023 Mohd Islam
ALTER TABLE `packageBuilderHotelMaster` ADD `locality` VARCHAR(200) NULL DEFAULT NULL AFTER `hotelName`;

-- 28-10-2023 Mohd Islam
ALTER TABLE `companySettingsMaster` ADD `TRNnumber` VARCHAR(255) NOT NULL AFTER `CINnumber`;

ALTER TABLE `corporateMaster` ADD `PANNumber` VARCHAR(255) NOT NULL AFTER `name`, ADD `TRNNumber` VARCHAR(255) NOT NULL AFTER `PANNumber`;

-- pax change functionality in outbound

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








