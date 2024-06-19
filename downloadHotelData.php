<?php   
include "inc.php"; 
ob_clean();  
if($_REQUEST['action'] == 'searchHotelData'){ 

    if($_REQUEST['withRate']==1){
        $filterQuery = $filterParam = '';
        if($_REQUEST['hotelName']!=''){
            $filterQuery .= " and  PBHM.hotelName = '".trim($_REQUEST['hotelName'])."'"; 
            $filterParam .= '&hotelName='.urlencode(trim($_REQUEST['hotelName']));
        }
        if($_REQUEST['hotelChain']!=''){
            $filterQuery .= " and  PBHM.hotelChain = '".trim($_REQUEST['hotelChain'])."'"; 
            $filterParam .= '&hotelChain='.urlencode(trim($_REQUEST['hotelChain']));
        }
        if($_REQUEST['seasonName']!=''){
            $filterQuery .= " and  DMCT.seasonType = '".trim($_REQUEST['seasonName'])."'"; 
            $filterParam .= '&seasonName='.urlencode(trim($_REQUEST['seasonName']));
        }
        if($_REQUEST['seasonYear']!='' || $_REQUEST['seasonYear']!='undefined'){
            $filterQuery .= " and  YEAR(DMCT.fromDate) = '".trim($_REQUEST['seasonYear'])."'"; 
            $filterParam .= '&seasonYear='.$_REQUEST['seasonYear'];
        }
        if($_REQUEST['hotelDestination']!=''){
            $filterQuery .= " and  PBHM.hotelCity = '".trim($_REQUEST['hotelDestination'])."'"; 
            $filterParam .= '&hotelCity='.urlencode(trim($_REQUEST['hotelCity']));
        }
        $filterQuery .= " and PBHM.hotelCity!='' and PBHM.status=1"; 
        $filterParam .= '&withRate='.$_REQUEST['withRate']; 

        $sql = "SELECT 
        PBHM.hotelName as HotelName  
        FROM packageBuilderHotelMaster PBHM
        LEFT JOIN chainhotelmaster HCM on PBHM.hotelChain = HCM.id
        LEFT JOIN weekendMaster WKM on PBHM.weekendDays = WKM.id
        LEFT JOIN hotelCategoryMaster HCAT on PBHM.hotelCategoryId = HCAT.id
        LEFT JOIN hotelTypeMaster HTM on PBHM.hotelTypeId = HTM.id

        LEFT JOIN dmcroomTariff DMCT ON DMCT.serviceid = PBHM.id

        LEFT JOIN queryCurrencyMaster CRM ON DMCT.currencyId = CRM.id
        LEFT JOIN marketMaster MTM on DMCT.marketType = MTM.id
        LEFT JOIN seasonMaster SSNM on DMCT.seasonType = SSNM.id

        LEFT JOIN gstMaster RGST on DMCT.roomGST = RGST.id
        LEFT JOIN gstMaster MGST on DMCT.mealGST = MGST.id

        LEFT JOIN suppliersMaster SM ON DMCT.supplierId = SM.id
        LEFT JOIN tariffTypeMaster TTM ON DMCT.tarifType = TTM.id
        LEFT JOIN roomTypeMaster RTM ON DMCT.roomType = RTM.id
        LEFT JOIN mealPlanMaster MPM ON DMCT.mealPlan = MPM.id

        LEFT JOIN addressMaster ADM ON ADM.addressParent = PBHM.id
        LEFT JOIN countryMaster CNTM ON CNTM.id = ADM.countryId
        LEFT JOIN stateMaster STATEM ON STATEM.id = ADM.stateId
        LEFT JOIN cityMaster CITYM ON CITYM.id = ADM.cityId

        LEFT JOIN hotelContactPersonMaster HCPM ON HCPM.corporateId = PBHM.id
        LEFT JOIN divisionMaster DVM ON HCPM.division = DVM.id
        where 1 ".$filterQuery." and PBHM.id=DMCT.serviceid GROUP BY PBHM.id order by PBHM.hotelName asc";
        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        $cntRows = mysqli_num_rows($result);

        $downloadLink = $fullurl.'downloadHotelData.php?action=download'.$filterParam;
        
        ?>
        <script type='text/javascript'>
            var cntRo='<?php echo $cntRows; ?>';
            var downloadLink='<?php echo $downloadLink; ?>';

            if(cntRo>0){
                $('#donwloadLink').attr("href", downloadLink);
                $('#downloadBtn').show(); $('#donwloadLink').show();
                $('#cntRows').html('Total Records <b>'+cntRo+'</b>.');
            } 
            else {
                $('#downloadBtn').show();

                $('#donwloadLink').attr("href", '');
                $('#donwloadLink').hide();
                $('#cntRows').html('No Records Found <b>'+cntRo+'</b>.');
            }
        </script>
        <?php
  
    }
    if($_REQUEST['withRate']==2){
        $filterQuery = $filterParam = '';
        if($_REQUEST['hotelName']!=''){
            $filterQuery .= " and  PBHM.hotelName = '".trim($_REQUEST['hotelName'])."'"; 
            $filterParam .= '&hotelName='.urlencode(trim($_REQUEST['hotelName']));
        }
        if($_REQUEST['hotelChain']!=''){
            $filterQuery .= " and  PBHM.hotelChain = '".trim($_REQUEST['hotelChain'])."'"; 
            $filterParam .= '&hotelChain='.urlencode(trim($_REQUEST['hotelChain']));
        }
        if($_REQUEST['hotelDestination']!=''){
            $filterQuery .= " and  PBHM.hotelCity = '".trim($_REQUEST['hotelDestination'])."'"; 
            $filterParam .= '&hotelCity='.urlencode(trim($_REQUEST['hotelCity']));
        }
        $filterParam .= '&withRate='.$_REQUEST['withRate']; 
        $filterQuery .= " and PBHM.hotelCity!='' and PBHM.status=1"; 

        $sql = "SELECT 
        PBHM.hotelName as HotelName  
        FROM packageBuilderHotelMaster PBHM 
        LEFT JOIN chainhotelmaster HCM on PBHM.hotelChain = HCM.id
        LEFT JOIN weekendMaster WKM on PBHM.weekendDays = WKM.id
        LEFT JOIN hotelCategoryMaster HCAT on PBHM.hotelCategoryId = HCAT.id
        LEFT JOIN hotelTypeMaster HTM on PBHM.hotelTypeId = HTM.id

        LEFT JOIN addressMaster ADM ON ADM.addressParent = PBHM.id
        LEFT JOIN countryMaster CNTM ON CNTM.id = ADM.countryId
        LEFT JOIN stateMaster STATEM ON STATEM.id = ADM.stateId
        LEFT JOIN cityMaster CITYM ON CITYM.id = ADM.cityId

        LEFT JOIN hotelContactPersonMaster HCPM ON HCPM.corporateId = PBHM.id
        LEFT JOIN divisionMaster DVM ON HCPM.division = DVM.id
        where 1 ".$filterQuery." GROUP BY PBHM.id order by PBHM.hotelName asc";
        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        $cntRows = mysqli_num_rows($result);

        $downloadLink = $fullurl.'downloadHotelData.php?action=download'.$filterParam;
        ?>
        <script type='text/javascript'>
            var cntRo='<?php echo $cntRows; ?>';
            var downloadLink='<?php echo $downloadLink; ?>';

            if(cntRo>0){
                $('#donwloadLink').attr("href", downloadLink);
                $('#downloadBtn').show(); $('#donwloadLink').show();
                $('#cntRows').html('Total Records <b>'+cntRo+'</b>.');
            } 
            else {
                $('#downloadBtn').show();
                $('#donwloadLink').attr("href", '');
                $('#donwloadLink').hide();
                $('#cntRows').html('No Records Found <b>'+cntRo+'</b>.');
            }
        </script>
        <?php 
    }
}
if($_REQUEST['action']=='download'){
    if($_REQUEST['withRate']==1){
        $filterQuery = "";
        if($_REQUEST['hotelName']!=''){
            $filterQuery .= " and  PBHM.hotelName = '".trim($_REQUEST['hotelName'])."'"; 
        }
        if($_REQUEST['hotelChain']!=''){
            $filterQuery .= " and  PBHM.hotelChain = '".trim($_REQUEST['hotelChain'])."'"; 
        }
        if($_REQUEST['seasonName']!=''){
            $filterQuery .= " and  DMCT.seasonType = '".trim($_REQUEST['seasonName'])."'"; 
        }
        if($_REQUEST['seasonYear']!='' || $_REQUEST['seasonYear']!='undefined'){
            $filterQuery .= " and  YEAR(DMCT.fromDate) = '".trim($_REQUEST['seasonYear'])."'"; 
        }
        if($_REQUEST['hotelDestination']!=''){
            $filterQuery .= " and  PBHM.hotelCity = '".trim($_REQUEST['hotelDestination'])."'"; 
        }
        $filterQuery .= " and PBHM.hotelCity!='' and PBHM.status=1"; 
        // echo makeHotel_xls_spreadsheet($filterQuery);
        /** Determine filename **/
        $filename = date('Y-m-d-h-i-s')." - download-hotel-data.csv";
        /** Set header information **/ 
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding: UTF-8"); 
        /* Add some data to the worksheet */
        $sql = "SELECT 
            PBHM.hotelName as HotelName
            ,PBHM.hotelCity as HotelCity
            ,CASE PBHM.supplier WHEN 1 THEN 'Yes' ELSE 'No' END as IsSelf
            ,SM.name  as SupplierName
            ,CASE SM.paymentTerm WHEN 1 THEN 'Cash' ELSE 'Credit' END as paymentTerm
            ,CNTM.name as CountryName
            ,STATEM.name as StateName
            ,CITYM.name as CityName
            ,ADM.address as AddressName
            ,ADM.pinCode as Pincode
            ,ADM.gstn  as GSTN

            ,DVM.name as DivisionName 
            ,HCPM.contactPerson as ContactPerson
            ,HCPM.designation as Designation
            ,HCPM.phone as ContactPhone
            ,HCPM.email as ContactEmail
            ,MTM.name as MarketName

            ,CASE SSNM.seasonNameId WHEN 1 THEN 'Summer' ELSE 'Winter' END as seasonName
            ,RTM.name as RoomTypeName
            ,MPM.name as MealPlanName
            ,DMCT.fromDate as FromDate
            ,DMCT.toDate as toDate
            ,CRM.name as currencyName
            ,DMCT.singleoccupancy as SingleOccupancy
            ,DMCT.doubleoccupancy as DoubleOccupancy
            ,DMCT.childwithoutbed as ChildWOBed
            ,DMCT.extraBed as ExtraBedAdult
            ,DMCT.childwithbed as ExtraBedChild
            ,DMCT.breakfast as Breakfast
            ,DMCT.lunch as Lunch
            ,DMCT.dinner as Dinner

            ,TTM.name as TarifType
            ,RGST.gstSlabName as RoomGst
            ,MGST.gstSlabName as MealGst
            ,DMCT.roomTAC as RoomTAC
            ,DMCT.remarks as Remarks

            ,HCAT.uploadKeyword as HotelCategory
            ,PBHM.url as HotelUrl
            ,HCM.name as HotelChain
            ,WKM.name as WeekendName
            ,PBHM.hotelDetail as hotelInfo
            ,PBHM.policy as HotelPolicy
            ,PBHM.termAndCondition as TermAndCondition
            ,HTM.uploadKeyword as HotelType

            FROM packageBuilderHotelMaster PBHM
            LEFT JOIN dmcroomTariff DMCT ON DMCT.serviceid = PBHM.id
            LEFT JOIN queryCurrencyMaster CRM ON DMCT.currencyId = CRM.id
            LEFT JOIN marketMaster MTM on DMCT.marketType = MTM.id
            LEFT JOIN seasonMaster SSNM on DMCT.seasonType = SSNM.id

            LEFT JOIN gstMaster RGST on DMCT.roomGST = RGST.id
            LEFT JOIN gstMaster MGST on DMCT.mealGST = MGST.id

            LEFT JOIN suppliersMaster SM ON DMCT.supplierId = SM.id
            LEFT JOIN tariffTypeMaster TTM ON DMCT.tarifType = TTM.id
            LEFT JOIN roomTypeMaster RTM ON DMCT.roomType = RTM.id
            LEFT JOIN mealPlanMaster MPM ON DMCT.mealPlan = MPM.id

            LEFT JOIN chainhotelmaster HCM on PBHM.hotelChain = HCM.id
            LEFT JOIN weekendMaster WKM on PBHM.weekendDays = WKM.id
            LEFT JOIN hotelCategoryMaster HCAT on PBHM.hotelCategoryId = HCAT.id
            LEFT JOIN hotelTypeMaster HTM on PBHM.hotelTypeId = HTM.id

            LEFT JOIN addressMaster ADM ON ADM.addressParent = PBHM.id
            LEFT JOIN countryMaster CNTM ON CNTM.id = ADM.countryId
            LEFT JOIN stateMaster STATEM ON STATEM.id = ADM.stateId
            LEFT JOIN cityMaster CITYM ON CITYM.id = ADM.cityId

            LEFT JOIN hotelContactPersonMaster HCPM ON HCPM.corporateId = PBHM.id
            LEFT JOIN divisionMaster DVM ON HCPM.division = DVM.id
        where 1 ".$filterQuery." GROUP BY PBHM.id order by PBHM.hotelName asc";
        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        if(mysqli_num_rows($result)>0){ 
            // result greater than 0
            $output = fopen('php://output', 'w');
            fputcsv($output, ['HotelName','HotelCity','IsSelf','SupplierName','paymentTerm','CountryName','StateName','CityName','AddressName','Pincode','GSTN','DivisionName','ContactPerson','Designation','ContactPhone','ContactEmail','MarketName','seasonName','RoomTypeName','MealPlanName','FromDate','toDate','currencyName','SingleOccupancy','DoubleOccupancy','ChildWOBed','ExtraBedAdult','ExtraBedChild','Breakfast','Lunch','Dinner','TarifType','RoomGst','MealGst','RoomTAC','Remarks','HotelCategory','HotelUrl','HotelChain','WeekendName','hotelInfo','HotelPolicy','TermAndCondition','HotelType']);
            $RN=2;
            while($row = mysqli_fetch_row($result)){
                fputcsv($output, $row);
                $RN++;
            }
        }  
        exit(); 
    }
    if($_REQUEST['withRate']==2){
        $filterQuery = "";
        if($_REQUEST['hotelName']!=''){
            $filterQuery .= " and  PBHM.hotelName = '".trim($_REQUEST['hotelName'])."'"; 
        } 
        if($_REQUEST['hotelChain']!=''){
            $filterQuery .= " and  PBHM.hotelChain = '".trim($_REQUEST['hotelChain'])."'"; 
        }
        if($_REQUEST['hotelDestination']!=''){
            $filterQuery .= " and  PBHM.hotelCity = '".trim($_REQUEST['hotelDestination'])."'"; 
        }
        $filterQuery .= " and PBHM.hotelCity!='' and PBHM.status=1"; 
        // echo makeHotelwithoutrate_xls_spreadsheet($filterQuery);

        /** Determine filename **/
        $filename = date('Y-m-d-h-i-s')." - download-hotel-data.csv";
        
        /** Set header information **/ 
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding: UTF-8"); 
        
        /* Add some data to the worksheet */
        $sql = "SELECT 
            PBHM.hotelName as HotelName
            ,PBHM.hotelCity as HotelCity
            ,CASE PBHM.supplier WHEN 1 THEN 'Yes' ELSE 'No' END as IsSelf
            ,'' as SupplierName
            ,'' as paymentTerm
            ,CNTM.name as CountryName
            ,STATEM.name as StateName
            ,CITYM.name as CityName
            ,ADM.address as AddressName
            ,ADM.pinCode as Pincode
            ,ADM.gstn  as GSTN

            ,DVM.name as DivisionName 
            ,HCPM.contactPerson as ContactPerson
            ,HCPM.designation as Designation
            ,HCPM.phone as ContactPhone
            ,HCPM.email as ContactEmail
            ,'' as MarketName
            ,'' as seasonName
            ,'' as RoomTypeName
            ,'' as MealPlanName
            ,'' as FromDate
            ,'' as toDate
            ,'' as currencyName
            ,'0' as SingleOccupancy
            ,'0' as DoubleOccupancy
            ,'0' as ChildWOBed
            ,'0' as ExtraBedAdult
            ,'0' as ExtraBedChild
            ,'0' as Breakfast
            ,'0' as Lunch
            ,'0' as Dinner
            ,'' as TarifType
            ,'' as RoomGst
            ,'' as MealGst
            ,'' as RoomTAC
            ,'' as Remarks
            ,HCAT.uploadKeyword as HotelCategory
            ,PBHM.url as HotelUrl
            ,HCM.name as HotelChain
            ,WKM.name as WeekendName
            ,PBHM.hotelDetail as hotelInfo
            ,PBHM.policy as HotelPolicy
            ,PBHM.termAndCondition as TermAndCondition
            ,HTM.uploadKeyword as HotelType

            FROM packageBuilderHotelMaster PBHM 
            LEFT JOIN chainhotelmaster HCM on PBHM.hotelChain = HCM.id
            LEFT JOIN weekendMaster WKM on PBHM.weekendDays = WKM.id
            LEFT JOIN hotelCategoryMaster HCAT on PBHM.hotelCategoryId = HCAT.id
            LEFT JOIN hotelTypeMaster HTM on PBHM.hotelTypeId = HTM.id

            LEFT JOIN addressMaster ADM ON ADM.addressParent = PBHM.id
            LEFT JOIN countryMaster CNTM ON CNTM.id = ADM.countryId
            LEFT JOIN stateMaster STATEM ON STATEM.id = ADM.stateId
            LEFT JOIN cityMaster CITYM ON CITYM.id = ADM.cityId

            LEFT JOIN hotelContactPersonMaster HCPM ON HCPM.corporateId = PBHM.id
            LEFT JOIN divisionMaster DVM ON HCPM.division = DVM.id
        where 1 ".$filterQuery." GROUP BY PBHM.id  order by PBHM.hotelName asc";
        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        if(mysqli_num_rows($result)>0){ 
            // result greater than 0
            $output = fopen('php://output', 'w');
            fputcsv($output, ['HotelName','HotelCity','IsSelf','SupplierName','paymentTerm','CountryName','StateName','CityName','AddressName','Pincode','GSTN','DivisionName','ContactPerson','Designation','ContactPhone','ContactEmail','MarketName','seasonName','RoomTypeName','MealPlanName','FromDate','toDate','currencyName','SingleOccupancy','DoubleOccupancy','ChildWOBed','ExtraBedAdult','ExtraBedChild','Breakfast','Lunch','Dinner','TarifType','RoomGst','MealGst','RoomTAC','Remarks','HotelCategory','HotelUrl','HotelChain','WeekendName','hotelInfo','HotelPolicy','TermAndCondition','HotelType']);
            // Add data
            $RN=2;
            while($row = mysqli_fetch_row($result)){
                fputcsv($output, $row);
                $RN++;
            }
        }
        // echo $output;
        exit();
    }
}
?>