
-- ****************************************************************************************
-- 013-03-2023 Samaya need to rund this structure to every client end

-- DROP TABLE overviewLanguageMaster; 
-- DROP TABLE subjectLanguageMaster;
-- DROP TABLE entranceLanguageMaster;
-- DROP TABLE destinationLanguageMaster;
-- DROP TABLE letterLanguageMaster;



-- quotationMaster 

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

ALTER TABLE `newQuotationDays` 
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
  
 