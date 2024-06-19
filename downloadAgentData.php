<?php  
ob_start();   
include "inc.php";   
 
if($_REQUEST['action']=='download'){ 
 
    /** Include path **/
    // set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
    
    /** PHPExcel */
    // require_once 'Classes/PHPExcel.php';
    /** PHPExcel_Writer_Excel2007 */
    // require_once 'PHPExcel/Writer/Excel2007.php';
    
    /* Create a new PHPExcel Object */
    // $objPHPExcel = new PHPExcel();

    /** Determine filename **/
    $filename = date('Y-m-d-h-i-s')." - download-agent-data.xls";
    
    /** Set header information **/
    // header('Content-Type: mimetype application/vnd.openxmlformats-officedocument.spreadsheetml.sheet and file extension .xslx'); //for xlx2007
    // header('Content-Type: application/csv');
    header('Cache-Control: max-age=0');
    header("Content-Transfer-Encoding: UTF-8"); 

    /* Add some metadata to the file */
    // $objPHPExcel->getProperties()->setCreator("TravCrm Inbound");
    // $objPHPExcel->getProperties()->setLastModifiedBy("TravCrm Inbound");
    // $objPHPExcel->getProperties()->setTitle($filename);
    // $objPHPExcel->getProperties()->setSubject($filename);
    // $objPHPExcel->getProperties()->setDescription($filename);
    
    // /* Set active worksheet to first */
    // $objPHPExcel->setActiveSheetIndex(0);
    // $objPHPExcel->getActiveSheet()->setTitle('Agent Import Data Sheet 1');
    
    /* Add some data to the worksheet */
    $sql = "SELECT 
        CTM.name as companyType
        ,CRPM.name as companyName
        ,ADM.gstn  as GSTN
        ,CONCAT(USERM.firstName, USERM.lastName) As SalePerson
        ,CONCAT(USERM2.firstName, USERM2.lastName) As OpsAssignTo
        ,CPM.contactPerson as ContactPerson
        ,DVM.name as DivisionName 
        ,CPM.designation as Designation
        ,CPM.countryCode as countryCode
        ,CPM.phone as ContactPhone
        ,CPM.email as ContactEmail
        ,CNTM.name as CountryName
        ,STATEM.name as StateName
        ,CITYM.name as CityName
        ,ADM.address as AddressName
        ,ADM.pinCode as Pincode
        ,CASE CRPM.companyCategory WHEN 1 THEN 'Big' WHEN 2 THEN 'Medium' WHEN 3 THEN 'Small' ELSE 'Medium' END as companyCategory
        ,CASE CRPM.bussinessType WHEN 1 THEN 'Corporate' WHEN 2 THEN 'B2B' ELSE 'Corporate' END as bussinessType
        ,MTM.name as MarketName
        ,LNGM.name as languageName

        FROM corporateMaster CRPM
        LEFT JOIN companyTypeMaster CTM ON CTM.id = CRPM.companyTypeId
        LEFT JOIN addressMaster ADM ON ADM.addressParent = CRPM.id
        LEFT JOIN userMaster USERM ON USERM.id = CRPM.assignTo
        LEFT JOIN userMaster USERM2 ON USERM2.id = CRPM.OpsAssignTo
        LEFT JOIN contactPersonMaster CPM ON CPM.corporateId = CRPM.id
        LEFT JOIN divisionMaster DVM ON CPM.division = DVM.id
        LEFT JOIN countryMaster CNTM ON CNTM.id = ADM.countryId
        LEFT JOIN stateMaster STATEM ON STATEM.id = ADM.stateId
        LEFT JOIN cityMaster CITYM ON CITYM.id = ADM.cityId
        LEFT JOIN marketMaster MTM on CRPM.marketType = MTM.id
        LEFT JOIN tbl_languagemaster LNGM on CRPM.language = LNGM.id
        
        WHERE 1 and CRPM.name != '' and CRPM.deletestatus=0  group by CRPM.id order by CRPM.name asc";
        // and CPM.division>0 and ADM.addressParent>0 and ADM.addressParent>0  
    $result = mysqli_query(db(),$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno(er));  
    if(mysqli_num_rows($result)>0){ 
        // result greater than 0
    $output .= '<table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
        <tr>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">company Type</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">company Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">GSTN</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Sale Person</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Ops AssignTo</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Contact Person</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Division Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Designation</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">country Code</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Contact Phone</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Contact Email</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Country Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">State Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">City Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Address Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Pincode</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">company Category</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Bussiness Type</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Market Name</th>
        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">Language</th>;
        </tr>';
        // $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->getFont()->setBold(true);
        // Add data
        $RN=2;
        while($row = mysqli_fetch_array($result)){
            $output .= '<tr style="text-align:center;">
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['companyType'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['companyName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['GSTN'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['SalePerson'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['OpsAssignTo'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['ContactPerson'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['DivisionName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['Designation'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['countryCode'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.decode($row['ContactPhone']).'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.decode($row['ContactEmail']).'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['CountryName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['StateName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['CityName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['AddressName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['Pincode'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['companyCategory'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['bussinessType'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['MarketName'].'</td>
            <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$row['languageName'].'</td>
            </tr>';
            $RN++;
        }
    }

    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    // header('Content-Disposition: attachment; filename=Download Agent Data.xls');
    echo $output;

    // $callStartTime = microtime(true);
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    // $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
    // $callEndTime = microtime(true);
    // $path = 'Classes/generateExcel/agent/'.$filename;
    // $objWriter->save('php://output');
    // $objWriter->save($path);
    
    exit();
     
}
if($_REQUEST['action']=='downloadAgentData'){ 
 
    /** Include path **/
    set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
    
    /** PHPExcel */
    require_once 'Classes/PHPExcel.php';
    /** PHPExcel_Writer_Excel2007 */
    require_once 'PHPExcel/Writer/Excel2007.php';
    
    /* Create a new PHPExcel Object */
    $objPHPExcel = new PHPExcel();

    /** Determine filename **/
    $filename = date('Y-m-d-h-i-s')." - download-agent-data.csv";
    
    /** Set header information **/
    // header('Content-Type: mimetype application/vnd.openxmlformats-officedocument.spreadsheetml.sheet and file extension .xslx'); //for xlx2007
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header("Content-Transfer-Encoding: UTF-8"); 

    /* Add some metadata to the file */
    $objPHPExcel->getProperties()->setCreator("TravCrm Inbound");
    $objPHPExcel->getProperties()->setLastModifiedBy("TravCrm Inbound");
    $objPHPExcel->getProperties()->setTitle($filename);
    $objPHPExcel->getProperties()->setSubject($filename);
    $objPHPExcel->getProperties()->setDescription($filename);
    
    /* Set active worksheet to first */
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Agent Import Data Sheet 1');
    
    /* Add some data to the worksheet */
    $sql = "SELECT 
        CTM.name as companyType
        ,CRPM.name as companyName
        ,ADM.gstn  as GSTN
        ,CONCAT(USERM.firstName, USERM.lastName) As SalePerson
        ,CONCAT(USERM2.firstName, USERM2.lastName) As OpsAssignTo
        ,CPM.contactPerson as ContactPerson
        ,DVM.name as DivisionName 
        ,CPM.designation as Designation
        ,CPM.countryCode as countryCode
        ,CPM.phone as ContactPhone
        ,CPM.email as ContactEmail
        ,CNTM.name as CountryName
        ,STATEM.name as StateName
        ,CITYM.name as CityName
        ,ADM.address as AddressName
        ,ADM.pinCode as Pincode
        ,CASE CRPM.companyCategory WHEN 1 THEN 'Big' WHEN 2 THEN 'Medium' WHEN 3 THEN 'Small' ELSE 'Medium' END as companyCategory
        ,CASE CRPM.bussinessType WHEN 1 THEN 'Corporate' WHEN 2 THEN 'B2B' ELSE 'Corporate' END as bussinessType
        ,MTM.name as MarketName
        ,LNGM.name as languageName

        FROM corporateMaster CRPM
        LEFT JOIN companyTypeMaster CTM ON CTM.id = CRPM.companyTypeId
        LEFT JOIN addressMaster ADM ON ADM.addressParent = CRPM.id
        LEFT JOIN userMaster USERM ON USERM.id = CRPM.assignTo
        LEFT JOIN userMaster USERM2 ON USERM2.id = CRPM.OpsAssignTo
        LEFT JOIN contactPersonMaster CPM ON CPM.corporateId = CRPM.id
        LEFT JOIN divisionMaster DVM ON CPM.division = DVM.id
        LEFT JOIN countryMaster CNTM ON CNTM.id = ADM.countryId
        LEFT JOIN stateMaster STATEM ON STATEM.id = ADM.stateId
        LEFT JOIN cityMaster CITYM ON CITYM.id = ADM.cityId
        LEFT JOIN marketMaster MTM on CRPM.marketType = MTM.id
        LEFT JOIN tbl_languagemaster LNGM on CRPM.language = LNGM.id
        
        WHERE 1 and CRPM.name != '' order by CRPM.name asc";
        // and CPM.division>0 and ADM.addressParent>0 and ADM.addressParent>0  
    $result = mysqli_query(db(),$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno(er));  
    if(mysqli_num_rows($result)>0){ 
        // result greater than 0

        // Add heading 
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'company Type')
            ->setCellValue('B1', 'company Name')
            ->setCellValue('C1', 'GSTN')
            ->setCellValue('D1', 'Sale Person')
            ->setCellValue('E1', 'Ops AssignTo')
            ->setCellValue('F1', 'Contact Person')
            ->setCellValue('G1', 'Division Name')
            ->setCellValue('H1', 'Designation')
            ->setCellValue('I1', 'country Code')
            ->setCellValue('J1', 'Contact Phone')
            ->setCellValue('K1', 'Contact Email')
            ->setCellValue('L1', 'Country Name')
            ->setCellValue('M1', 'State Name')
            ->setCellValue('N1', 'City Name')
            ->setCellValue('O1', 'Address Name')
            ->setCellValue('P1', 'Pincode')
            ->setCellValue('Q1', 'company Category')
            ->setCellValue('R1', 'Bussiness Type')
            ->setCellValue('S1', 'Market Name')
            ->setCellValue('T1', 'Language');
        $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->getFont()->setBold(true);
        // Add data
        $RN=2;
        while($row = mysqli_fetch_array($result)){
            $j=0;
            for ($char = 'A'; $char <= 'Z'; $char++) {
                if($char  == 'J' || $char  == 'K'){
                    $cellVal = decode($row[$j]);
                }else{
                    $cellVal = trim($row[$j]);
                }
                $CL = $char.$RN;
                $objPHPExcel->getActiveSheet()->setCellValue($CL, $cellVal);
                $j++;
            }
            $RN++;
        }
    }
      


    // $callStartTime = microtime(true);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    // $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
    // $callEndTime = microtime(true);
    $path = 'Classes/generateExcel/agent/'.$filename;
    $objWriter->save('php://output');
    $objWriter->save($path);
    
    exit();
     
}
// EOD FOR HOTEL DATA
?>