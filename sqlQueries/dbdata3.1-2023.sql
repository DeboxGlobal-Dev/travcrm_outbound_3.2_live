-- DB Data file of Year 2023

-- 23-01-2023 Mausam Khan
UPDATE `moduleMaster` SET `mainmenu` = '0' WHERE `url` = 'docket';

-- 23-02-2023 Mausam Khan
DELETE FROM `countryMaster` WHERE `status`=0;
DELETE FROM `stateMaster` WHERE `status`=0;
DELETE FROM `cityMaster` WHERE `status`=0;

--03-03-2022 Samay Bangla language import query for client as well as us
DELETE FROM `tbl_languagemaster` WHERE status=0 or deletestatus=1;
DELETE FROM `tbl_languagemaster` WHERE id>7;
INSERT INTO `tbl_languagemaster` (`id`, `name`, `deletestatus`, `dateAdded`, `modifyDate`, `addedBy`, `modifyBy`, `status`) VALUES (8, 'Bangla', '', '', '', 37, 37, 1);

-- 08-APR-2023 samay financy default entries update finance master as file code work
TRUNCATE TABLE `financeYearMaster`;
INSERT INTO `financeYearMaster` (`id`, `financeYear`, `daterange`, `fromDate`, `toDate`, `status`, `deletestatus`, `addedBy`, `dateAdded`, `modifyDate`, `modifyBy`) 
VALUES (NULL, '22-23', '', '2022-04-01', '2023-03-31', '1', '0', '0', '0', '0', '0'), 
(NULL, '23-24', '', '2023-04-01', '2024-03-31', '1', '0', '0', '0', '0', '0'),
(NULL, '24-25', '', '2024-04-01', '2025-03-31', '1', '0', '0', '0', '0', '0'),
(NULL, '25-26', '', '2025-04-01', '2026-03-31', '1', '0', '0', '0', '0', '0'),
(NULL, '26-27', '', '2026-04-01', '2027-03-31', '1', '0', '0', '0', '0', '0');

--4-05-2023 Mausam khan
UPDATE `invoiceMaster` SET `invoiceFormat`='1' WHERE `id`!='0';

-- Insert suppliers Type table service type Tcs  --21-June-2023 Mausam khan
INSERT INTO `suppliersTypeMaster` (`id`, `name`, `status`, `modifyBy`, `addedBy`, `dateAdded`, `modifyDate`, `deletestatus`) VALUES ('9', 'TCS', '1', '', '', '', '', '0');

 --14-Aug-2023 Mausam khan
INSERT INTO `moduleTypeMaster` (`id`, `module`, `name`, `status`) VALUES ('13', 'multipleservices', 'Multiple Services', '1');

 --11-Oct-2023 Mausam khan
INSERT INTO `moduleTypeMaster` (`id`, `module`, `name`, `status`) VALUES ('14', 'Activity', 'Activity', '1');
 