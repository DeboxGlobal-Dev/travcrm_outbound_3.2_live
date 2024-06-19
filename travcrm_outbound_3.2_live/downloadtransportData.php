<?php


include "inc.php";
ob_clean(); 

if($_REQUEST['action']=="searchTransferData"){

    if($_REQUEST['withRate']==1){

        $filterQuery ='';
        if($_REQUEST['transferSupplier']!=''){
            $supplierId = $_REQUEST['transferSupplier'];
            $filterQuery .= ' and TFRM.supplierId="'.$supplierId.'"';
            $filterParam .= '&transferSupplier='.urlencode(trim($_REQUEST['transferSupplier']));
        }

        if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
            $fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
            $toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
            $filterQuery .= ' and TFRM.fromDate >= "'.$fromDate.'" and TFRM.toDate<="'.$toDate.'"'; 
            $filterParam .= '&fromDate='.urlencode(trim($fromDate)).'&toDate='.urlencode(trim($toDate));
        }

        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';
            $filterParam .= '&transferDestination='.urlencode(trim($_REQUEST['transferDestination'])); 
        }

        $filterQuery .= " and PBTM.transferCategory = 'transfer' and PBTM.status=1 and PBTM.deletestatus=0 and PBTM.id=TFRM.serviceid "; 
        $filterParam .= '&withRate='.$_REQUEST['withRate']; 

        $sql = "SELECT 
        PBTM.transferName as transferName,PBTM.transferDetail as transferDetail,PBTM.transferType as transferType
        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM on PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
        
        LEFT JOIN dmctransferRate TFRM ON TFRM.serviceid = PBTM.id
        LEFT JOIN suppliersMaster SPLM on TFRM.supplierId = SPLM.id
        LEFT JOIN queryCurrencyMaster CRM ON TFRM.currencyId = CRM.id
        LEFT JOIN vehicleMaster VehcleM ON TFRM.vehicleModelId = VehcleM.id
        LEFT JOIN gstMaster MGST on TFRM.gstTax = MGST.id
        LEFT JOIN marketMaster MTM on TFRM.marketType = MTM.id

        where 1 ".$filterQuery."  GROUP BY PBTM.id order by PBTM.transferName asc"; 
        $result = mysqli_query(db(),$sql);  
        $cntRows = mysqli_num_rows($result);  
        
        $downloadLink = $fullurl.'downloadtransportData.php?action=downloadtransferData'.$filterParam;
       
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
    }elseif($_REQUEST['withRate']=='2'){
        $filterQuery =''; 
        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';
            $filterParam .= '&transferDestination='.urlencode(trim($_REQUEST['transferDestination'])); 
        }
        $filterQuery .= " and PBTM.transferCategory = 'transfer' and PBTM.status=1 and PBTM.deletestatus=0 "; 
        $filterParam .= '&withRate='.$_REQUEST['withRate']; 
        

        $sql = "SELECT 
        PBTM.transferName as transferName,
        PBTM.transferDetail as transferDetail,
        PBTM.transferType as transferType
        
        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM on PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
        
        -- LEFT JOIN dmctransferRate TFRM ON TFRM.serviceid = PBTM.id
        -- LEFT JOIN suppliersMaster SPLM on TFRM.supplierId = SPLM.id
        -- LEFT JOIN queryCurrencyMaster CRM ON TFRM.currencyId = CRM.id
        -- LEFT JOIN vehicleMaster VehcleM ON TFRM.vehicleModelId = VehcleM.id
        -- LEFT JOIN gstMaster MGST on TFRM.gstTax = MGST.id
        -- LEFT JOIN marketMaster MTM on TFRM.marketType = MTM.id

        where 1  ".$filterQuery." GROUP BY PBTM.id order by PBTM.transferName asc"; 

        $result = mysqli_query(db(),$sql);  
        $cntRows = mysqli_num_rows($result);   

        $downloadLink = $fullurl.'downloadtransportData.php?action=downloadtransferData'.$filterParam;

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


if($_REQUEST['action']=='downloadtransferData'){ 
    
    if($_REQUEST['withRate']=='1'){
        $filterQuery ='';
        if($_REQUEST['transferSupplier']!=''){
            $supplierId = $_REQUEST['transferSupplier'];
            $filterQuery .= ' and TFRM.supplierId="'.$supplierId.'"';
        }

        if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
            $fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
            $toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
            $filterQuery .= ' and TFRM.fromDate >= "'.$fromDate.'" and TFRM.toDate<="'.$toDate.'"'; 
        }

        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';

        }
        $filterQuery .= " and PBTM.transferCategory = 'transfer' and PBTM.status=1 and PBTM.deletestatus=0 and PBTM.id=TFRM.serviceid "; 
        // echo transportation_xls_spreadsheet($filterQuery);


        /** Determine filename **/
        $filename = date('Y-m-d-h-i-s')." - download-transfer-data.csv";
        /** Set header information **/ 
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding: UTF-8"); 
        /* Add some data to the worksheet */
        $sql = "SELECT 
            PBTM.transferName as transferName,
            PBTM.transferDetail as transferDetail,
            TTM.name as transferType,
            DESTM.name as destinationName,
            SPLM.name as supplierName,
            CRM.name as currencyName,
            DATE_FORMAT(TFRM.fromDate,'%d/%m/%Y') as fromDate,
            DATE_FORMAT(TFRM.toDate,'%d/%m/%Y') as toDate,
            VehcleM.model as vehicleName,
            MGST.gstSlabName as transferGST,
            TFRM.vehicleCost as vehicleCost,
            TFRM.parkingFee as parkingFee,
            TFRM.representativeEntryFee as representativeFee,
            TFRM.assistance as assistance,
            TFRM.guideAllowance as additionalAllowance,
            TFRM.interStateAndToll as interStateAndToll,
            TFRM.miscellaneous as miscellaneous,
            MTM.name as MarketName,
            TFRM.detail as remark
            FROM packageBuilderTransportMaster PBTM
            LEFT JOIN transferTypeMaster TTM on PBTM.transferType = TTM.id
            LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
            
            LEFT JOIN dmctransferRate TFRM ON TFRM.serviceid = PBTM.id
            LEFT JOIN suppliersMaster SPLM on TFRM.supplierId = SPLM.id
            LEFT JOIN queryCurrencyMaster CRM ON TFRM.currencyId = CRM.id
            LEFT JOIN vehicleMaster VehcleM ON TFRM.vehicleModelId = VehcleM.id
            LEFT JOIN gstMaster MGST on TFRM.gstTax = MGST.id
            LEFT JOIN marketMaster MTM on TFRM.marketType = MTM.id
            
            where 1 ".$filterQuery." GROUP BY PBTM.id order by PBTM.transferName asc"; 

        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        if(mysqli_num_rows($result)>0){ 
            // result greater than 0
            $output = fopen('php://output', 'w');

            
            fputcsv($output, ['Transfer Name','Transfer Detail','Transfer Type','Tranfer City','Supplier','Currency','From Validity','To Validity','Vehicle Name','GST Slab Name','Vehicle Cost','Parking Fee','Representative Entry Fee','Assistance','Additional Allowance','Inter-State & Toll','Miscellaneous','Market Type','Remarks']);
            
            $RN=2;
            while($row = mysqli_fetch_row($result)){
                fputcsv($output, $row);
                $RN++;
            }
        }  
        exit(); 
    }elseif($_REQUEST['withRate']=='2'){
        $filterQuery =''; 
        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';

        }
        $filterQuery .= " and PBTM.transferCategory = 'transfer' and PBTM.status=1 and PBTM.deletestatus=0 "; 
        // echo withoutratetransportation_xls_spreadsheet($filterQuery);
        // echo makeHotel_xls_spreadsheet($filterQuery);
        /** Determine filename **/
        $filename = date('Y-m-d-h-i-s')." - download-transfer-data.csv";
        /** Set header information **/ 
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding: UTF-8"); 
        /* Add some data to the worksheet */
        $sql = "SELECT 
            PBTM.transferName as transferName,
            PBTM.transferDetail as transferDetail,
            TTM.name as transferType,
            DESTM.name as destinationName,
            '' as supplierName,
            '' as currencyName,
            '' as fromDate,
            '' as toDate,
            'Per Day Cost' as CostType,
            '' as vehicleType,
            '' as vehicleName,
            '' as transferGST,
            '' as vehicleCost,
            '' as parkingFee,
            '' as representativeFee,
            '' as assistance,
            '' as additionalAllowance,
            '' as interStateAndToll,
            '' as miscellaneous,
            '' as remark

        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM ON PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
        where 1 ".$filterQuery." GROUP BY PBTM.id order by PBTM.transferName asc"; 

        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        if(mysqli_num_rows($result)>0){ 
            // result greater than 0
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Transfer Name','Transfer Detail','Transfer Type','Tranfer City','Supplier','Currency','From Validity','To Validity','Vehicle Name','GST Slab Name','Vehicle Cost','Parking Fee','Representative Entry Fee','Assistance','Additional Allowance','Inter-State & Toll','Miscellaneous','Market Type','Remarks']);
            $RN=2;
            while($row = mysqli_fetch_row($result)){
                fputcsv($output, $row);
                $RN++;
            }
        }  
        exit(); 
    }

}

// Transportation master
if($_REQUEST['action']=="searchTransportationData"){
    if($_REQUEST['withRate']==1){

        $filterQuery ='';
        if($_REQUEST['transferSupplier']!=''){
            $supplierId = $_REQUEST['transferSupplier'];
            $filterQuery .= ' and TFRM.supplierId="'.$supplierId.'"';
            $filterParam .= '&transferSupplier='.urlencode(trim($_REQUEST['transferSupplier']));
        }

        if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
            $fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
            $toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
            $filterQuery .= ' and TFRM.fromDate >= "'.$fromDate.'" and TFRM.toDate<="'.$toDate.'"'; 
            $filterParam .= '&fromDate='.urlencode(trim($fromDate)).'&toDate='.urlencode(trim($toDate));
        }

        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';
            $filterParam .= '&transferDestination='.urlencode(trim($_REQUEST['transferDestination'])); 
        }

        $filterQuery .= " and PBTM.transferCategory = 'transportation' and PBTM.status=1 and PBTM.deletestatus=0 and PBTM.id=TFRM.serviceid ";
        $filterParam .= '&withRate='.$_REQUEST['withRate']; 

        $sql = "SELECT 
        PBTM.transferName as transferName,PBTM.transferDetail as transferDetail,PBTM.transferType as transferType
        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM on PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
        
        LEFT JOIN dmctransferRate TFRM ON TFRM.serviceid = PBTM.id
        LEFT JOIN suppliersMaster SPLM on TFRM.supplierId = SPLM.id
        LEFT JOIN queryCurrencyMaster CRM ON TFRM.currencyId = CRM.id
        LEFT JOIN vehicleMaster VehcleM ON TFRM.vehicleModelId = VehcleM.id
        LEFT JOIN gstMaster MGST on TFRM.gstTax = MGST.id
        LEFT JOIN marketMaster MTM on TFRM.marketType = MTM.id

        where 1 ".$filterQuery."  GROUP BY PBTM.id order by PBTM.transferName asc"; 
        $result = mysqli_query(db(),$sql);  
        $cntRows = mysqli_num_rows($result);  
        
        $downloadLink = $fullurl.'downloadtransportData.php?action=downloadtransportationData'.$filterParam;
       
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
    }elseif($_REQUEST['withRate']=='2'){
        $filterQuery =''; 
        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';
            $filterParam .= '&transferDestination='.urlencode(trim($_REQUEST['transferDestination'])); 
        }
        $filterQuery .= " and PBTM.transferCategory = 'transportation' and PBTM.status=1 and PBTM.deletestatus=0 ";  
        $filterParam .= '&withRate='.$_REQUEST['withRate']; 
        

        $sql = "SELECT 
        PBTM.transferName as transferName,
        PBTM.transferDetail as transferDetail,
        PBTM.transferType as transferType
        
        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM on PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
 
        where 1  ".$filterQuery." GROUP BY PBTM.id order by PBTM.transferName asc"; 

        $result = mysqli_query(db(),$sql);  
        $cntRows = mysqli_num_rows($result);   

        $downloadLink = $fullurl.'downloadtransportData.php?action=downloadtransportationData'.$filterParam;

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

// download transportation
if($_REQUEST['action']=='downloadtransportationData'){ 

    if($_REQUEST['withRate']=='1'){
        $filterQuery ='';
        if($_REQUEST['transferSupplier']!=''){
            $supplierId = $_REQUEST['transferSupplier'];
            $filterQuery .= ' and TFRM.supplierId="'.$supplierId.'"';
        }

        if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
            $fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
            $toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
            $filterQuery .= ' and TFRM.fromDate >= "'.$fromDate.'" and TFRM.toDate<="'.$toDate.'"'; 
        }

        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';

        }
        $filterQuery .= " and PBTM.transferCategory = 'transportation' and PBTM.status=1 and PBTM.deletestatus=0 and PBTM.id=TFRM.serviceid "; 
        // echo transportation_xls_spreadsheet($filterQuery);


        /** Determine filename **/
        $filename = date('Y-m-d-h-i-s')." - download-transportation-data.csv";
        /** Set header information **/ 
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding: UTF-8"); 
        /* Add some data to the worksheet */
        $sql = "SELECT 
        PBTM.transferName as transferName,
        PBTM.transferDetail as transferDetail,
        TTM.name as transferType,
        DESTM.name as destinationName,
        SPLM.name as supplierName,
        CRM.name as currencyName,
        DATE_FORMAT(TFRM.fromDate,'%d/%m/%Y') as fromDate,
        DATE_FORMAT(TFRM.toDate,'%d/%m/%Y') as toDate,
        CASE TFRM.transferCostType WHEN 1 THEN 'Per Day Cost' ELSE 'Package Cost' END as CostType,
        VTT.name as vehicleType,
        VehcleM.model as vehicleName,
        MGST.gstSlabName as transferGST,
        TFRM.vehicleCost as vehicleCost,
        TFRM.parkingFee as parkingFee,
        TFRM.representativeEntryFee as representativeFee,
        TFRM.assistance as assistance,
        TFRM.guideAllowance as additionalAllowance,
        TFRM.interStateAndToll as interStateAndToll,
        TFRM.miscellaneous as miscellaneous,
        TFRM.detail as remark

        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM ON PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
        
        LEFT JOIN dmctransferRate TFRM ON TFRM.serviceid = PBTM.id
        LEFT JOIN suppliersMaster SPLM ON TFRM.supplierId = SPLM.id
        LEFT JOIN queryCurrencyMaster CRM ON TFRM.currencyId = CRM.id
        LEFT JOIN vehicleMaster VehcleM ON TFRM.vehicleModelId = VehcleM.id
        LEFT JOIN gstMaster MGST on TFRM.gstTax = MGST.id
        -- LEFT JOIN marketMaster MTM on TFRM.marketType = MTM.id
        LEFT JOIN vehicleTypeMaster VTT on TFRM.vehicleTypeId = VTT.id
    
        where 1 ".$filterQuery." GROUP BY PBTM.id order by PBTM.transferName asc"; 

        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        if(mysqli_num_rows($result)>0){ 
            // result greater than 0
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Tranportation Name','Transportation Detail','Transportation Type','Transportation City','Supplier','Currency','From Validity,','To Validity,','Cost Type(Per Day/Package),','Vehicle Type','Vehicle Name','GST Slab Name','Vehicle Cost','Parking Fee','Representative Entry Fee','Assistance','Additional Allowance','Inter-State & Toll','Miscellaneous','Remarks']);
            
            $RN=2;
            while($row = mysqli_fetch_row($result)){
                fputcsv($output, $row);
                $RN++;
            }
        }  
        exit(); 
    }elseif($_REQUEST['withRate']=='2'){
        $filterQuery =''; 
        if($_REQUEST['transferDestination']!=''){
            $transferDestination = $_REQUEST['transferDestination'];
            $filterQuery .= ' and PBTM.destinationId="'.$transferDestination.'"';

        }
        $filterQuery .= " and PBTM.transferCategory = 'transportation' and PBTM.status=1 and PBTM.deletestatus=0 "; 
        // echo withoutratetransportation_xls_spreadsheet($filterQuery);
        // echo makeHotel_xls_spreadsheet($filterQuery);
        /** Determine filename **/
        $filename = date('Y-m-d-h-i-s')." - download-transportation-data.csv";
        /** Set header information **/ 
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding: UTF-8"); 
        /* Add some data to the worksheet */
        $sql = "SELECT 
            PBTM.transferName as transferName,
            PBTM.transferDetail as transferDetail,
            TTM.name as transferType,
            DESTM.name as destinationName,
            '' as supplierName,
            '' as currencyName,
            '' as fromDate,
            '' as toDate,
            'Per Day Cost' as CostType,
            '' as vehicleType,
            '' as vehicleName,
            '' as transferGST,
            '' as vehicleCost,
            '' as parkingFee,
            '' as representativeFee,
            '' as assistance,
            '' as additionalAllowance,
            '' as interStateAndToll,
            '' as miscellaneous,
            '' as remark

        FROM packageBuilderTransportMaster PBTM
        LEFT JOIN transferTypeMaster TTM ON PBTM.transferType = TTM.id
        LEFT JOIN destinationMaster DESTM ON PBTM.destinationId = DESTM.id
        where 1 ".$filterQuery." GROUP BY PBTM.id order by PBTM.transferName asc"; 

        $result = mysqli_query(db(),$sql) or die("Couldn't execute query");  
        if(mysqli_num_rows($result)>0){ 
            // result greater than 0
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Tranportation Name','Transportation Detail','Transportation Type','Transportation City','Supplier','Currency','From Validity,','To Validity,','Cost Type(Per Day/Package),','Vehicle Type','Vehicle Name','GST Slab Name','Vehicle Cost','Parking Fee','Representative Entry Fee','Assistance','Additional Allowance','Inter-State & Toll','Miscellaneous','Remarks']);
            $RN=2;
            while($row = mysqli_fetch_row($result)){
                fputcsv($output, $row);
                $RN++;
            }
        }  
        exit(); 
    } 
}
?>

