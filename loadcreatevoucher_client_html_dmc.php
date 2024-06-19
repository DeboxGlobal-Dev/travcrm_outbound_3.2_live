<?php 
    include 'inc.php';

    $rs=''; 
    $rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" and status=1 '); 
    $quotationData=mysqli_fetch_array($rs);
    $quotationId = $quotationData['id']; 
    $queryId = $quotationData['queryId']; 
    $totalNights = $quotationData['night']; 
    $totalPax = clean($quotationData['adult']+$quotationData['child']+$quotationData['infant']);
    $totaladult = $quotationData['adult'];
    $totalchild = $quotationData['child'];
    $totalinfant = $quotationData['infant'];  
    $childwithNoofBed = $quotationData['childwithNoofBed'];  
    $childwithoutNoofBed = $quotationData['childwithoutNoofBed'];  

    $costType = $quotationData['costType'];
    $discountType= $quotationData['discountType'];
    $discountTax = $quotationData['discount'];

    // query data 
    $rs=''; 
    $rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"'); 
    $queryData=mysqli_fetch_array($rs); 

    $tourId  = makeQueryTourId($queryData['id']);
    $leadPaxName  = $queryData['leadPaxName'];
    $frontQueryId = makeQueryId($queryData['id']);
    //   $fromDate=date('d-m-Y',strtotime($queryData['fromDate'])); 
    //   $toDate=date('d-m-Y',strtotime($queryData['toDate'])); 
    $fromDate=date('d-m-Y',strtotime($quotationData['fromDate'])); 
    $toDate=date('d-m-Y',strtotime($quotationData['toDate'])); 


    $overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText='';
    if($quotationData['overviewText']!='' || $quotationData['overviewText']!='undefined'){
        $overviewText=preg_replace('/\\\\/', '',clean($quotationData['overviewText'])); 
    }
    if($quotationData['highlightsText']!='' || $quotationData['highlightsText']!='undefined'){
        $highlightsText=preg_replace('/\\\\/', '',clean($quotationData['highlightsText']));
    }
    if($quotationData['inclusion']!='' || $quotationData['inclusion']!='undefined'){
        $inclusion=preg_replace('/\\\\/', '',clean($quotationData['inclusion']));
    }
    if($quotationData['exclusion']!='' || $quotationData['exclusion']!='undefined'){
        $exclusion=preg_replace('/\\\\/', '',clean($quotationData['exclusion']));  
    }
    if($quotationData['tncText']!='' || $quotationData['tncText']!='undefined'){
        $tncText=preg_replace('/\\\\/', '',clean($quotationData['tncText']));  
    }
    if($quotationData['specialText']!='' || $quotationData['specialText']!='undefined'){
        $specialText=preg_replace('/\\\\/', '',clean($quotationData['specialText']));
    }

        if($quotationData['quotationSubject']!=''){
            $quotationSubject = preg_replace('/\\\\/', '',clean($quotationData['quotationSubject']));
        }else{
            $quotationSubject = strtoupper(strip($queryData['subject']));
        } 

    //slab Date

    $slabSql="";
    $slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'"  and status=1'); 
    if(mysqli_num_rows($slabSql) > 0 ){
    $slabsData=mysqli_fetch_array($slabSql);
    $slabId = $slabsData['id']; 
    $dfactor = $slabsData['dividingFactor']; 
    }
 
    $n=1;

    $voucherQuery=GetPageRecord('*','voucherDetailsMaster','serviceType="dmcvoucher" and quotationId="'.$quotationId.'"'); 
    if(mysqli_num_rows($voucherQuery)<1){
        $namevalue ='quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusId.'",serviceType="dmcvoucher"';
        $voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
    } else{
        $voucherDetailData = mysqli_fetch_array($voucherQuery);
        $voucherId  = $voucherDetailData['id'];	
        $supplierStatusId  = $voucherDetailData['supplierStatusId'];	
        $voucherDate  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
    
	
        $cli_voucherNotes  = $voucherDetailData['cli_voucherNotes'];	
        $voucherNotes  = $voucherDetailData['voucherNotes'];	
      
    } 

    if($voucherDate!='1970-01-01 00:00:00' && $voucherDate!='0000-00-00 00:00:00' && $voucherDate!=''){ 
        $voucherDate = date('d/m/Y', strtotime($voucherDate)); 
    }else{ 
        $voucherDate = date('d/m/Y',strtotime($fromDate)); 
    } 
    $showVocherNum = generateVoucherNumber($voucherId,$_REQUEST['module'],strtotime($fromDate));

    $module = 'ClientVoucher';
    $showVocherNum = generateVoucherNumber($voucherId,$module,strtotime($fromDate));

    if($queryData['clientType']==2){
	$bc=GetPageRecord('*',_CONTACT_MASTER_,' id="'.$queryData['companyId'].'" order by id desc');  
	$bcData=mysqli_fetch_array($bc);
    $agentName = $bcData['firstName'].' '.$bcData['middleName'].' '.$bcData['lastName'];
	$address = $bcData['address1'];
	$pincode = $bcData['pinCode'];

    $rs2 = GetPageRecord('name',_COUNTRY_MASTER_,'id="'.$bcData['countryId'].'"');
    $countryrs = mysqli_fetch_assoc($rs2);
    $countryName = $countryrs['name'];

    $rs3 = GetPageRecord('name',_STATE_MASTER_,'id="'.$bcData['stateId'].'"');
    $staters = mysqli_fetch_assoc($rs3);
    $stateName = $staters['name'];

    $rs4 = GetPageRecord('name',_CITY_MASTER_,'id="'.$bcData['cityId'].'"');
    $cityrs = mysqli_fetch_assoc($rs4);
    $cityName = $cityrs['name'];

    $rs5=GetPageRecord('*',_PHONE_MASTER_,'masterId="'.$bcData['id'].'" and primaryvalue=1');
    $phoneData = mysqli_fetch_assoc($rs5);
    $phoneData['phone'];

    $rs6=GetPageRecord('*',_EMAIL_MASTER_,'masterId="'.$bcData['id'].'"  and primaryvalue=1');
    $emailData = mysqli_fetch_assoc($rs6);
    $emailData['email'];

    $phone = ($phoneData['phoneNo']!='')? '<strong>Mobile:</strong> &nbsp;&nbsp;'.$phoneData['phoneNo'].'&nbsp;&nbsp;&nbsp;&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';
    $email = ($emailData['email']!='')? '<strong>Email:</strong> &nbsp;&nbsp;'.$emailData['email']:'';

    $agentAddress = $address.' '.$stateName.' '.$pincode.' '.$countryName;
    $agentContactPerson = $phone.' '.$email;

	}else{
	$corp=GetPageRecord('*',_CORPORATE_MASTER_,' id="'.$queryData['companyId'].'" order by id desc');  
	$corporateData=mysqli_fetch_array($corp);
    $agentName = $corporateData['name'];
    $rs1=GetPageRecord('*',_ADDRESS_MASTER_,'addressParent="'.$corporateData['id'].'" and addressType="corporate" and primaryAddress=1');
    $addressResult = mysqli_fetch_assoc($rs1);
    $address = $addressResult['address'];
    $pincode = $addressResult['pinCode'];
    
    $rs2 = GetPageRecord('name',_COUNTRY_MASTER_,'id="'.$addressResult['countryId'].'"');
    $countryrs = mysqli_fetch_assoc($rs2);
    $countryName = $countryrs['name'];

    $rs3 = GetPageRecord('name',_STATE_MASTER_,'id="'.$addressResult['stateId'].'"');
    $staters = mysqli_fetch_assoc($rs3);
    $stateName = $staters['name'];

    $rs4 = GetPageRecord('name',_CITY_MASTER_,'id="'.$addressResult['cityId'].'"');
    $cityrs = mysqli_fetch_assoc($rs4);
    $cityName = $cityrs['name'];

    $agentAddress = $address.' '.$stateName.' '.$pincode.' '.$countryName;

    $rs5 = GetPageRecord('*','contactPersonMaster','corporateId="'.$corporateData['id'].'"');
    $contactData = mysqli_fetch_assoc($rs5);
    
    $phone = ($contactData['phone']!='')? '<strong>Mobile:</strong> &nbsp;&nbsp;'.decode($contactData['phone']).'&nbsp;&nbsp;&nbsp;&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';
    $email = ($contactData['email']!='')? '<strong>Email:</strong> &nbsp;&nbsp;'.decode($contactData['email']):'';
   
    $agentContactPerson = $phone.' '.$email;
	}

	$whereops='id="'.$queryData['assignTo'].'"';  
	$rsop=GetPageRecord('*',_USER_MASTER_,$whereops); 
	$resListingops=mysqli_fetch_array($rsop);
	$operationPerson=$resListingops['firstName'].' '.$resListingops['lastName'];

	$whereSale='id="'.$agentlogoData['assignTo'].'"';  
	$rsSal=GetPageRecord('*',_USER_MASTER_,$whereSale); 
	$resListingSales=mysqli_fetch_array($rsSal);
	$salesPerson=$resListingSales['firstName'].' '.$resListingSales['lastName'];
?>
<style>
    .voucher-heading{
        text-align: center;
        padding: 14px 0px;
    }
    .traveller-dt-s{
        padding: 6px 5px;
        background-color: #cecece;
    }

    .heading-dt-s{
        padding: 6px 5px;
        background-color: #acc5ef;
    }

    h1,h2,h3,h4,h5,a,div,table,td,tr,th{
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
    }
    .trav-dt-ss1{
        background-color: #f4f4f4;
    }
    .po_tc_cls{
        color:#ffffff;
         background-color: #233a49;
         font-size: 18px;
    }
   
</style>
<div class="main-container">
    <div class="sub-container" style="border:1px dashed #ddd;padding:20px;font-size: 13px;" id="mailSectionArea">

     <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
		<tr>
		    <td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px; margin: 0 auto;" /></td>
        </tr>
	 </table>

        <!--ended top sec logo and address -->
        <div class="voucher-heading">
            <h3 style="text-align: center !important;">TOUR CONFIRMATION VOUCHER</h3>
        </div>

<!-- ===================== Supplier related information ====================== -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="70%" align="left">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td>
                            <h4>To<br><?php echo $agentName; ?> </h4>
                            <p style="width: 60%;text-align: left;"> <?php echo $agentAddress; ?></p>
                            <p><?php echo $agentContactPerson; ?></p>
                            </td></tr>
                        </table>
                    </td>
                    <td width="20%" align="right">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr> <td> <strong>Tour ID :</strong> <?php echo $tourId; ?></td></tr>
                            <tr><td> <strong>Voucher No.:</strong> <?php echo $showVocherNum; ?></td></tr>
                            <tr><td> <strong>Voucher Date :</strong> <?php echo $voucherDate; ?></td></tr>
                        </table>
                    </td>
                </tr>
            </table>

        <!-- ended address sec  -->
        <br>
        <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate">
            <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                <th width="20" align="left">Start&nbsp;Date</th>
                <th width="20" align="left">End&nbsp;Date</th>
                <th width="20" align="left">Total&nbsp;Nights</th>
                <th width="20" align="left">Total&nbsp;Pax</th>
                <th width="20" align="left">Adults</th>
                <th width="20" align="left">Child&nbsp;W/B</th>
                <th width="20" align="left">Child&nbsp;N/B</th>
                <th width="20" align="left">Infant</th>
            
            </tr>
            <tr>
                <td align="left"><?php echo $fromDate; ?></td>
                <td align="left"><?php echo $toDate; ?></td>
                <td align="left"><?php echo $totalNights; ?></td>
                <td align="left"><?php echo $totalPax; ?></td>
                <td align="left"><?php echo $totaladult; ?></td>
                <td align="left"><?php echo $childwithNoofBed; ?></td>
                <td align="left"><?php echo $childwithoutNoofBed; ?></td>
                <td align="left"><?php echo $totalinfant; ?></td>
            </tr>
        </table>
        <br>


        <?php
        
        $modedetails=GetPageRecord('*','dmcFlightTrainSurfaceDetails','1 and quotationId="'.$quotationId.'"'); 

        $dmcmodedetails = mysqli_fetch_array($modedetails);
        $id  = $dmcmodedetails['id'];	
        $modeType  = $dmcmodedetails['modeType'];

        
        ?>


        <!-- flight and train mode section started -->
        <div class="flightTrainMode">
            <div class="selectboxmode">
                <!--dropdown list options-->
                <!-- <select id="selectboxmodebox">
                    <option>Select Mode</option>
                    <option value="surface" >Surface</option>
                    <option value="flight" >Flight</option>
                    <option value="train" >Train</option>
                </select> -->
            </div>
          

            <!-- arrivel info start -->

             <!-- surface -->
             <?php if($modeType=='surface') {?>
            <div class="surface box1" style="background: none;">
                
            <div ><h3 class="traveller-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Arrival Information Surface</h3></div>
               
            
                <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate" style="background: #e7ebec;">
                    <tr class=""  style="background-color:none!important">
                        <th width="20" align="left">Type</th>
                        <th width="20" align="left">Vehicle Type</th>
                        <th width="20" align="left">Number</th>
                        <th width="20" align="left">From</th>
                        <th width="20" align="left">ARR&nbsp;Date</th>
                        <th width="20" align="left">ARR&nbsp;Time</th>
                        <th width="20" align="left">Pickup Address</th>
                        <th width="20" align="left">Drop Address</th>
                    </tr>

                    <?php
                        $modedetails=GetPageRecord('*','dmcFlightTrainSurfaceDetails','1 and quotationId="'.$quotationId.'"'); 
                        $dmcmodedetails = mysqli_fetch_array($modedetails);
                        $id  = $dmcmodedetails['id'];	
                        $modeType  = $dmcmodedetails['modeType'];
                    ?>
                    <tr style="background:white;">
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mas_type_dmc" id="mas_type_dmc" value="<?php echo $dmcmodedetails['SurfaceAtype']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mas_vehiletype_dmc" id="mas_vehiletype_dmc" value="<?php echo $dmcmodedetails['SurfaceAname']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mas_number_dmc" id="mas_number_dmc" value="<?php echo $dmcmodedetails['SurfaceAnumber']?>">
                        </td>

                    
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mas_from_dmc" id="mas_from_dmc" value="<?php echo $dmcmodedetails['SurfaceAfrom']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="date" class="end_start_td" name="mas_arrdate_dmc" id="mas_arrdate_dmc" value="<?php echo $dmcmodedetails['SurfacearrDate']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" class="end_start_td flighttimepicker2" name="mas_arrtime_dmc" id="mas_arrtime_dmc" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $dmcmodedetails['SurfaceArrTime']?>" >
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mas_picadd_dmc" id="mas_picadd_dmc" value="<?php echo $dmcmodedetails['SurfaceApicAdd']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mas_dropadd_dmc" id="mas_dropadd_dmc" value="<?php echo $dmcmodedetails['SurfaceAdropAdd']?>">
                            <input style="width: 100%;" type="hidden" name="maf_type_dmc" id="maf_type_dmc" value="surface">
                        </td>
                       
                    </tr>
                </table>
                

            </div>
            <?php } ?>
            

       
            <!-- flight -->

            <?php if($modeType=='flight') {?>
            <div class="flight box1" style="background: none!important;"> 
                <div ><h3 class="traveller-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Arrival Information Flight</h3></div>
                
                <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate" style="background: #e7ebec;">
                    <tr class=""  style="background-color:none!important">
                        <th width="20" align="left">Type</th>
                        <th width="20" align="left">Name</th>
                        <th width="20" align="left">Number</th>
                        <th width="20" align="left">From</th>
                        <th width="20" align="left">ARR&nbsp;Date</th>
                        <th width="20" align="left">ARR&nbsp;Time</th>
                        <th width="20" align="left">Pickup Address</th>
                        <th width="20" align="left">Drop Address</th>
                    </tr>

                    <?php
                        $modedetails=GetPageRecord('*','dmcFlightTrainSurfaceDetails','1 and quotationId="'.$quotationId.'"'); 
                        $dmcmodedetails = mysqli_fetch_array($modedetails);
                        $id  = $dmcmodedetails['id'];	
                        $modeType  = $dmcmodedetails['modeType'];
                    ?>
                    <tr style="background: white;">
                        <td align="left">
                            <input style="width: 100%;" type="text" name="maf_type_dmc" id="maf_type_dmc" value="<?php echo $dmcmodedetails['type']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="maf_name_dmc" id="maf_name_dmc" value="<?php echo $dmcmodedetails['name']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="maf_number_dmc" id="maf_number_dmc" value="<?php echo $dmcmodedetails['number']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="maf_from_dmc" id="maf_from_dmc" value="<?php echo $dmcmodedetails['Afrom']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="date" class="end_start_td" name="maf_arrdate_dmc" id="maf_arrdate_dmc" value="<?php echo $dmcmodedetails['arrDate']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" class="end_start_td flighttimepicker2" name="maf_arrtime_dmc" id="maf_arrtime_dmc" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $dmcmodedetails['ArrTime']?>" >
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="maf_picadd_dmc" id="maf_picadd_dmc" value="<?php echo $dmcmodedetails['picAdd']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="maf_dropadd_dmc" id="maf_dropadd_dmc" value="<?php echo $dmcmodedetails['dropAdd']?>">
                            <input style="width: 100%;" type="hidden" name="maf_type_dmc" id="maf_type_dmc" value="flight">
                        </td>
                       
                    </tr>
                </table>

                
            </div>
            <?php } ?>

            <!-- train -->

            <?php if($modeType=='train') { ?>
            <div class="train box1" style="background: none;">
                
            <div ><h3 class="traveller-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Arrival Information Train</h3></div>
            
               <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate" style="background: #e7ebec;">
                   <tr class=""  style="background-color:none!important">
                       <th width="20" align="left">Type</th>
                       <th width="20" align="left">Name</th>
                       <th width="20" align="left">Number</th>
                       <th width="20" align="left">From</th>
                       <th width="20" align="left">ARR&nbsp;Date</th>
                       <th width="20" align="left">ARR&nbsp;Time</th>
                       <th width="20" align="left">Pickup Address</th>
                       <th width="20" align="left">Drop Address</th>
                   </tr>

                   <?php
                       $modedetails=GetPageRecord('*','dmcFlightTrainSurfaceDetails','1 and quotationId="'.$quotationId.'"'); 
                       $dmcmodedetails = mysqli_fetch_array($modedetails);
                       $id  = $dmcmodedetails['id'];	
                       $modeType  = $dmcmodedetails['modeType'];
                   ?>
                   <tr style="background: white;">
                       <td align="left">
                           <input style="width: 100%;" type="text" name="mat_type_dmc" id="mat_type_dmc" value="<?php echo $dmcmodedetails['TrainAtype']?>">
                       </td>
                       <td align="left">
                           <input style="width: 100%;" type="text" name="mat_name_dmc" id="mat_name_dmc" value="<?php echo $dmcmodedetails['TrainAname']?>">
                       </td>
                       <td align="left">
                           <input style="width: 100%;" type="text" name="mat_number_dmc" id="mat_number_dmc" value="<?php echo $dmcmodedetails['TrainAnumber']?>">
                       </td>
                       <td align="left">
                           <input style="width: 100%;" type="text" name="mat_from_dmc" id="mat_from_dmc" value="<?php echo $dmcmodedetails['TrainAfrom']?>">
                       </td>
                     
                       <td align="left">
                           <input style="width: 100%;" type="date" class="end_start_td" name="mat_arrdate_dmc" id="mat_arrdate_dmc" value="<?php echo $dmcmodedetails['TrainarrDate']?>">
                       </td>
                       <td align="left">
                           <input style="width: 100%;" type="text" class="end_start_td flighttimepicker2" name="mat_arrtime_dmc" id="mat_arrtime_dmc" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $dmcmodedetails['TrainArrTime']?>" >
                       </td>
                       <td align="left">
                           <input style="width: 100%;" type="text" name="mat_picadd_dmc" id="mat_picadd_dmc" value="<?php echo $dmcmodedetails['TrainApicAdd']?>">
                       </td>
                       <td align="left">
                           <input style="width: 100%;" type="text" name="mat_dropadd_dmc" id="mat_dropadd_dmc" value="<?php echo $dmcmodedetails['TrainAdropAdd']?>">
                           <input style="width: 100%;" type="hidden" name="maf_type_dmc" id="maf_type_dmc" value="train">
                       </td>
                      
                   </tr>
               </table>

              

            </div>

            <?php } ?>
            <!-- arrivel info Ended -->



            
        </div>
        <!-- flight and train mode section started -->

        <br>
        <!-- travel/Guests detail table sec started -->
        <?php
         $rsG = GetPageRecord('*','contactsMaster','queryId2="'.$queryId.'" or tourId="'.$tourId.'" and contactType=3');
        if(mysqli_num_rows($rsG)>0){
                     ?>
                 
        <div class="tarvel-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="travle-details-tdate">
                <div ><h3 class="traveller-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Traveller Detail</h3></div>
                <tr class="trav-dt-ss1">
                    <th width="300" align="left">Name</th>
                    <th width="200" align="left">Gender</th>
                    <th width="20" align="left">Age</th>
                </tr>
                <?php 
                    while($guestData = mysqli_fetch_assoc($rsG)){
                ?>
                    <tr>
                    <td align="left">
                        <?php if($guestData['leadpaxstatus']=='1'){ 
                                $lead = "Lead Pax";

                                ?><strong> <?php  echo $lead ?></strong> <?php echo $guestData['firstName'].' '.$guestData['middleName'].' '.$guestData['lastName']; 

                            }else{

                                echo $guestData['firstName'].' '.$guestData['middleName'].' '.$guestData['lastName'];

                            }
                            ?>
                    </td>
                        <td align="left"><?php echo $guestData['gender']; ?></td>
                        <td align="left"><?php echo $guestData['guestAge']; ?></td>
                    </tr>
                    
                <?php } ?>
               
                
            </table>
           
        </div>
        <br>
        <?php } ?>
        <!-- travel detail table sec ended -->

        <!-- Accommodation detail table sec start -->
        <?php 
        $dateSets = getHotelDateSets($quotationId,0);
        $dateSetArray = explode('~',$dateSets); 
        $cnt1 = 1;
        if(strlen($dateSets) > 0){ 
        ?> 
        <!-- Accommodation detail table sec started -->
        <div class="accommodation-details-sec">
        <table border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0" class="accommodation-details-tdate">
            <div class="accommodation-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Accommodation</h3></div>
            <tr class="trav-dt-ss1" style="background-color: #f4f4f4;">
                <th width="7%" align="left">City</th>
                <th width="30%" align="left">Check&nbsp;In Check Out Information</th> 
                <th width="20%" align="left">Hotel</th>
                <th width="10%" align="left">Room&nbsp;Type</th>
                <th width="12%" align="left">Meal&nbsp;Plan</th>
                <th width="12%" align="left">Room</th>
                <th width="5%" align="left">Night</th>
                <th width="8%" align="left">Confirmation No.</th>
            </tr>
            <?php  
            foreach($dateSetArray as $dateSet){
                
                $dateSetData = explode('^',$dateSet);
                $hotelId = $dateSetData[0];
                $fromDate = $dateSetData[1];
                $toDate = $dateSetData[2];
                $FID = $dateSetData[3];

                $supplierStatusId = $FID; // IMP TO REMEMBER
                $clientVoucher_cnt = strip($supplierStatusId."_".$cnt1);
                $c="";
                $c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
                $hotelData=mysqli_fetch_array($c); 
                 
                $g="";
                $g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
                $finalHotelData=mysqli_fetch_array($g);
                $confirmationNo  = $finalHotelData['confirmationNo'];
                // group by roomType,mealPlanId 
                $g2="";
                $g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" order by fromDate asc'); 
                if(mysqli_num_rows($g2)>0){ 
                    while($quotMealData=mysqli_fetch_array($g2)){  

                        $g="";
                        $g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"'); 
                        $roomTypeData=mysqli_fetch_array($g);
                        $rType=$roomTypeData['name'];

                        $g="";
                        $g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlanId'].'"'); 
                        $mealData=mysqli_fetch_array($g); 
                        $mealplan = $mealData['name'];
                        $mealType='';
                  
                        if($quotMealData['complimentaryBreakfast']==1){
                            $mealType = ', Breakfast-(A)';
                        }
                        if($quotMealData['complimentaryLunch']==1){
                            $mealType .= ', Lunch-(A)';
                        }

                        if($quotMealData['complimentaryDinner']==1){
                            $mealType .= ', Dinner-(A)';
                        }

                        if($quotMealData['isChildBreakfast']==1){
                            $mealType .= ', Breakfast-(C)';
                        }

                        if($quotMealData['isChildLunch']==1){
                            $mealType .= ', Lunch-(C)';
                        }

                        if($quotMealData['isChildDinner']==1){
                            $mealType .= ', Dinner-(C)';
                        }


                        $rooms = '';
                        if($quotMealData['roomSingle'] > 0){ $rooms .= $quotMealData['roomSingle']." SGL ,"; }
                        if($quotMealData['roomDouble'] > 0){ $rooms .= $quotMealData['roomDouble']." DBL ,"; }
                        if($quotMealData['roomTriple'] > 0){ $rooms .= $quotMealData['roomTriple']." TPL ,"; }
                        if($quotMealData['roomTwin'] > 0){ $rooms .= $quotMealData['roomTwin']." TWIN ,"; }
                        // if($quotMealData['roomEBedA'] > 0){ $rooms .= $quotMealData['roomEBedA']." EBed(A) ,"; }
                        // if($quotMealData['roomEBedC'] > 0){ $rooms .= $quotMealData['roomEBedC']." CWBed ,"; }
                        // if($quotMealData['roomENBedC'] > 0){ $rooms.= $quotMealData['roomENBedC']." CNBed ,"; }
                        $rooms = rtrim($rooms, ' ,');

                        $totalRooms = $quotMealData['roomSingle']+$quotMealData['roomDouble']+$quotMealData['roomTriple']+$quotMealData['roomTwin']+$quotMealData['sixNoofBedRoom']+$quotMealData['eightNoofBedRoom']+$quotMealData['tenNoofBedRoom']+$quotMealData['quadNoofRoom']+$quotMealData['teenNoofRoom'];

                        if($hotelData['checkInTime']!='' && $hotelData['checkInTime']!='00:00:00'){
                            $CheckInHotel = date('H:i',strtotime($hotelData['checkInTime']));
                            $checkInTime = ' <b>Check In Time</b> '.$CheckInHotel;
                        }else{
                            $CheckInHotel = '';
                            $checkInTime = '';
                        }

                        if($hotelData['checkOutTime']!='' && $hotelData['checkOutTime']!='00:00:00'){
                            $CheckOutHotel = date('H:i',strtotime($hotelData['checkOutTime']));
                            $checkOuTime = '  <b>Check Out Time</b>  '.$CheckOutHotel;
                        }else{
                            $CheckOutHotel = '';
                            $checkOuTime='';
                        }
                        
                        $CheckIn = date('d-m-Y',strtotime($fromDate));
                        $CheckOut = date('d-m-Y',strtotime($toDate));
                        $date1 = new DateTime($fromDate);
                        $date2 = new DateTime($toDate);
                        $interval = $date1->diff($date2);
                        $nights = $interval->days;
                       
                        $cres = GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
                        $catres = mysqli_fetch_assoc($cres);
                        $hotelStar = $catres['hotelCategory'];
                        $hotelStarimg='';
                         for($i=1; $i<=$hotelStar; $i++ ){
                            $hotelStarimg.= '<img src="'.$fullurl.'images/hotelStar.png" height="20">';
                         } 
                        $rsH = GetPageRecord('*',_ADDRESS_MASTER_,'addressParent="'.$hotelData['id'].'" and addressType="hotel"');
                        if(mysqli_num_rows($rsH)>0){
                        $hotelAddress = mysqli_fetch_assoc($rsH);
                        
                        $haddress = $hotelAddress['address'];
                       
                        $pincode = $hotelAddress['pinCode'];
                       
                        $rs2 = GetPageRecord('name',_COUNTRY_MASTER_,'id="'.$hotelAddress['countryId'].'"');
                        $countryrs = mysqli_fetch_assoc($rs2);
                        $countryName = $countryrs['name'];
                        
                        $rs3 = GetPageRecord('name',_STATE_MASTER_,'id="'.$hotelAddress['stateId'].'"');
                        $staters = mysqli_fetch_assoc($rs3);
                        $stateName = $staters['name'];
                       
                        $rs4 = GetPageRecord('name',_CITY_MASTER_,'id="'.$hotelAddress['cityId'].'"');
                        $cityrs = mysqli_fetch_assoc($rs4);
                        $cityName = $cityrs['name'];
                        $hotelAddress = $haddress.' '.$stateName.' '.$pincode.' '.$countryName;

                        $rsn="";
                        $rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
                        $cmpcountryData=mysqli_fetch_array($rs1cmp);
                        $baseId = $cmpcountryData['countryId'];

                        $rsn22="";
                        $rs1cmp22=GetPageRecord('*',_COUNTRY_MASTER_,'id="'.$baseId.'"');
                        $cmpcountryData333=mysqli_fetch_array($rs1cmp22);
                        $ContryName = $cmpcountryData333['name'];


                        }
                        ?>
                        <tr>
                            <td align="left"><?php echo getDestination($quotMealData['destinationId']) ?></td>
                            <td align="left">
                                <?php echo ' <b>From</b> '.$CheckIn; ?><?php echo '  <b>To</b> '.$CheckOut.'<br><br>'; ?>
                                <?php echo $checkInTime.'<br>'.$checkOuTime; ?>
                            </td>
                            <td align="left">
                                <strong><?php echo $hotelData['hotelName'].'<br>'; echo $hotelStarimg; ?></strong><br>
                                <?php 
                                    if($hotelData['hotelCity']!=""){  
                                        echo 'Address:- '.$hotelData['hotelAddress'].' '.$hotelData['hotelCity'];
                                    }else{
                                        echo 'Address:- '.$ContryName;
                                    }
                                    
                                
                                ?></td>
                            <td align="left"><?php echo $rType; ?></td>
                            <td align="left"><?php echo $mealplan.'<br>'.ltrim($mealType,','); ?></td>
                            <td align="left">
                                <?php echo $totalRooms.'<br><br>'; ?>
                                <?php

                                if($quotMealData['roomSingle']>0){
                                    echo '<b> SGL : '.$quotMealData['roomSingle'].'</b><br>';
                                }
                                if($quotMealData['roomDouble']>0){
                                    echo '<b> DBL : '.$quotMealData['roomDouble'].'</b><br>';
                                } 
                                if($quotMealData['roomTriple']>0){
                                    echo '<b> TPL : '.$quotMealData['roomTriple'].'</b><br>';
                                } 
                                if($quotMealData['roomTwin']>0){
                                    echo '<b> TWIN : '.$quotMealData['roomTwin'].'</b><br>';
                                }  
                                if($quotMealData['quadNoofRoom']>0){
                                    echo '<b> QUAD : '.$quotMealData['quadNoofRoom'].'</b><br>';
                                } 
                                
                                ?>
                            </td>
                            <td align="left"><?php echo $nights; ?></td>
                            <td align="center"><?php if($confirmationNo==''){ echo '<span style="font-size:30px;">&#148</span>';}else{ echo $confirmationNo; } ?></td>
                        </tr><?php
                    }  
                } 
            } ?>
        </table>
        </div>
        <?php
        } ?>
        <!-- Accommodation detail table sec ended -->


        <!-- tours and transfers detail table sec started -->
        <?php 

        $transferQuery='';    
        $transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and manualStatus=3 order by fromDate asc '); 
        if(mysqli_num_rows($transferQuery)>0){
        ?>
            
        <div class="tours-tranfer-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0" class="tours-tranfer-details-tdate">
                <div class="tours-tranfer-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Tours & Transfers</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important; font-size:14px;" >
                    <th width="15%" align="left">Name</th>
                    <th width="5%" align="left">Type</th>
                    <th width="10%" align="left">Vehicle&nbsp;Name</th>
                    <th width="8%" align="left">Date</th>
                    <th width="6%" align="left">Pickup Time</th>
                    <th width="6%" align="left">Drop Time</th>
                    <th width="20%" align="left">Pickup&nbsp;Address</th>
                    <th width="20%" align="left">Drop&nbsp;Adress</th>
                    <th width="8%" align="left">Corfirmation No.</th>
                </tr>
                <?php 
                
                 
                 while($finalQuoteTPT=mysqli_fetch_array($transferQuery)){

                    if($finalQuoteTPT['transferType']==1){
                        $transferType = 'SIC';
                    }elseif($finalQuoteTPT['transferType']==2){
                        $transferType = 'PVT';
                    }
                $transferFlag = 1;
                $c="";  
                $c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTPT['transferId'].'"'); 
                $transferData=mysqli_fetch_array($c);

                $d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTPT['vehicleModelId'].'"'); 
				$vehicleData=mysqli_fetch_array($d);
                $vehicleName = $vehicleData['model'];

                $rsQ='';    
                $rsQ=GetPageRecord('*','quotationTransferMaster',' quotationId="'.$finalQuoteTPT['quotationId'].'" and id="'.$finalQuoteTPT['transferQuotationId'].'" order by fromDate asc ');  
                $tptQuotData = mysqli_fetch_assoc($rsQ);


                $tt=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$tptQuotData['id'].'" and quotationId="'.$tptQuotData['quotationId'].'" and dayId="'.$tptQuotData['dayId'].'"'); 
				$tptTime=mysqli_fetch_array($tt);

                if($tptTime['pickupTime']!='' && $tptTime['pickupTime']!='00:00:00'){
                    $pickupTime = date('H:i',strtotime($tptTime['pickupTime']));
                }else{
                    $pickupTime = '';
                }

                if($tptTime['dropTime']!='' && $tptTime['dropTime']!='00:00:00'){
                    $dropTime = date('H:i',strtotime($tptTime['dropTime']));
                }else{
                    $dropTime = '';
                }
             
                ?>
                <tr>
                    <td align="left"><?php echo $transferData['transferName']; ?></td>
                    <td align="left"><?php echo $transferType; ?></td>
                    <td align="left"><?php echo $vehicleName; ?></td>
                    <td align="left"><?php echo date('d/m/Y',strtotime($finalQuoteTPT['fromDate'])); ?></td>
                    <td align="left"><?php echo $pickupTime; ?></td>
                    <td align="left"><?php echo $dropTime; ?></td>
                    <td align="left"><?php echo $tptTime['pickupAddress']; ?></td>
                    <td align="left"><?php echo $tptTime['dropAddress']; ?></td>
                    <td align="left"><?php echo $finalQuoteTPT['confirmationNo']; ?></td>
                </tr>
                    <?php } ?>
                
                
            </table>
        </div>
        <br>
        <?php } ?>
       
        <!-- tours and transfers detail table sec ended -->

        <!-- excursions and Tickets detail table sec started -->
      <?php 
            
            
            $activityQQuery='';    
			$activityQQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and manualStatus = 3');

            $entranceQQuery='';    
    		$entranceQQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'" and manualStatus = 3'); 

            if(mysqli_num_rows($entranceQQuery)>0 || mysqli_num_rows($activityQQuery)>0){
            ?>
        <div class="excursion-ticket-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0"  class="excursion-ticket-details-tdate">
                <div class="excursion-ticket-dt-s"><h3 class="heading-dt-s"  style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Excursions & Tickets</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                <th  align="left">Entrance&nbsp;Name</th>
                    <!-- <th width="10%" align="center">Type</th> -->
                    <th width="10%" align="left">Start&nbsp;Time</th>
                    <th width="10%" align="left">End&nbsp;Time</th>
                    <th width="10%" align="left">Pickup&nbsp;Time</th>
                    <th width="10%" align="left">Drop&nbsp;Time</th>
                    <th width="20%" align="left">Pickup&nbsp;Address</th>
                    <th width="20%" align="left">Drop&nbsp;Address</th>
                    <th width="20%" align="left">Confirmation&nbsp;No.</th>
                </tr>
             
                <?php 
            
    		while($entranceData=mysqli_fetch_assoc($entranceQQuery)){
            
            $c=GetPageRecord('*','packageBuilderEntranceMaster','id="'.$entranceData['entranceId'].'"'); 
    		$entranceDData=mysqli_fetch_array($c);	

            $e='';
    		$e=GetPageRecord('*','quotationEntranceTimelineDetails','hotelQuoteId="'.$entranceData['entranceQuotationId'].'" and quotationId="'.$entranceData['quotationId'].'" and dayId="'.$entranceData['dayId'].'"'); 
            // if(mysqli_num_rows($e)>0){
    		$entranceTime=mysqli_fetch_assoc($e);

            if($entranceTime['endTime']!='00:00:00' && $entranceTime['endTime']!=''){
                $endTime = date('H:i',strtotime($entranceTime['endTime']));
            }else{
                $endTime='';
            }

            if($entranceTime['startTime']!='00:00:00' && $entranceTime['startTime']!=''){
                $startTime = date('H:i',strtotime($entranceTime['startTime']));
            }else{
                $startTime='';
            }

            if($entranceTime['dropTime']!='00:00:00' && $entranceTime['dropTime']!=''){
                $dropTime = date('H:i',strtotime($entranceTime['dropTime']));
            }else{
                $dropTime='';
            }

            if($entranceTime['pickupTime']!='00:00:00' && $entranceTime['pickupTime']!=''){
                $pickupTime = date('H:i',strtotime($entranceTime['pickupTime']));
            }else{
                $pickupTime='';
            }
            
             ?>
                <tr>
                <td align="left"><?php echo $entranceDData['entranceName']; ?></td>
                   

                    <td align="left"><?php echo $startTime; ?></td>
                    
                    <td align="left"> <?php echo $endTime ; ?></td>

                    <td align="left"> <?php echo $pickupTime; ?></td>

                    <td align="left"> <?php echo $dropTime; ?></td>
                    
                    <td align="left"><?php echo $entranceTime['pickupAddress']; ?></td>
                    <td align="left"><?php echo $entranceTime['dropAddress']; ?></td>
                    <td align="left"><?php echo $entranceData['confirmationNo']; ?></td>
                </tr>
             <?php } ?>
                
                
            </table>
            <?php 

            $activityQQuery='';    
			$activityQQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and manualStatus = 3 order by fromDate asc '); 
            if(mysqli_num_rows($activityQQuery)>0){
            ?>
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0"  class="excursion-ticket-details-tdate">
        
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                    <th align="left">Sightseeing&nbsp;Name</th>
                    <th width="20%" align="left">Start&nbsp;Time</th>
                    <th width="20%" align="left">End&nbsp;Time</th>
                    <th width="20%" align="left">Confirmation&nbsp;No.</th>
                </tr>
                <?php 
            
    		while($activityData=mysqli_fetch_array($activityQQuery)){
    
    		$c="";  
    		$c=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$activityData['activityId'].'"'); 
    		$activityDData=mysqli_fetch_array($c);	

            $e="";  
    		$e=GetPageRecord('*','quotationActivityTimelineDetails','hotelQuoteId="'.$activityData['activityQuotationId'].'" and quotationId="'.$activityData['quotationId'].'"'); 
    		$activityTime=mysqli_fetch_array($e);	

            if($activityData['transferType'] == 1){
                $transferType = 'SIC';
             }elseif($activityData['transferType'] == 2){
                $transferType = 'PVT';
             }if($activityData['transferType'] == 3){
                $transferType = 'VIP';
             }

             ?>
                <tr>
                    <td align="left"><?php echo $transferType.' | '. ucfirst($activityDData['otherActivityName']); ?></td>
                 
                    <td align="left"><?php echo $activityTime['startTime']; ?></td>
                    <td align="left"><?php echo $activityTime['endTime']; ?></td>

                    <td align="left"><?php echo $activityData['confirmationNo']; ?></td>
                </tr>
             <?php } ?>
                
                
            </table>
            <?php } ?>
        </div>
        <br>
        <?php } ?>
        <!-- excursions and Tickets detail table sec ended -->
     

        <!-- flight and train detail table sec started -->
        <?php 
        
            
            $query = '(SELECT quotationId,FQF.flightQuotationId as quotId, FQF.flightNumber as num,PBAIM.flightName as name,arrivalTo,departureFrom,flightClass as class,fromDate,departureTime,arrivalTime,FQF.departureDate as Date,FQF.dayId as dayId FROM finalQuoteFlights FQF INNER JOIN packageBuilderAirlinesMaster PBAIM on FQF.flightId=PBAIM.id WHERE quotationId="'.$quotationData['id'].'") UNION ALL
            (SELECT quotationId,FQT.trainQuotationId as quotId,FQT.trainNumber as num,PBTM.trainName as name,arrivalTo,departureFrom,trainClass as class,fromDate,departureTime,arrivalTime,FQT.departureDate as Date,FQT.dayId as dayId FROM finalQuoteTrains FQT INNER JOIN packageBuilderTrainsMaster PBTM on FQT.trainId=PBTM.id WHERE quotationId="'.$quotationData['id'].'" )';
            $query = mysqli_query(db(),$query);

			if(mysqli_num_rows($query)>0){
            ?>
               
        <div class="flight-train-details-sec">
        <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0" class="flight-train-details-tdate">
                <div class="flight-train-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Flight & Train</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                <th width="5%" align="left">Type</th>
                    <th width="10%" align="left">Name</th>
                    <th width="10%" align="left">Number.</th>
                    <th width="11%" align="left">From</th>
                    <th width="11%" align="left">To</th>
                    <th width="11%" align="left">Class</th>
                    <th width="10%" align="left">DPT&nbsp;Date</th>
                    <th align="left">DPT&nbsp;Time</th>
                    <th width="10%" align="left">ARR&nbsp;Date</th>
                    <th align="left">ARR&nbsp;Time</th>
                </tr>
                <?php
                
                while($flightEData=mysqli_fetch_array($query)){
				
                 $a11=GetPageRecord('name',_DESTINATION_MASTER_,' id="'.$flightEData['departureFrom'].'" and deletestatus=0 and status=1');
                $departurFrom=mysqli_fetch_array($a11);	

                $a12=GetPageRecord('name',_DESTINATION_MASTER_,' id="'.$flightEData['arrivalTo'].'" and deletestatus=0 and status=1');
                $arrivalTo=mysqli_fetch_array($a12);	
                $tfClass = str_replace('_', '&nbsp;', $flightEData['class']);
                
                $a13=GetPageRecord('serviceType','quotationItinerary',' serviceId="'.$flightEData['quotId'].'" and quotationId="'.$flightEData['quotationId'].'"');
                $serviceType=mysqli_fetch_array($a13);	

                $c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$flightEData['quotId'].'" and quotationId="'.$flightEData['quotationId'].'" and dayId="'.$flightEData['dayId'].'"');
				$timeData = mysqli_fetch_assoc($c1);
             
                if($timeData['departureDate']!='' && $timeData['departureDate']!='00-00-00'){
                   $departureDate = date('d-m-Y',strtotime($timeData['departureDate']));
                }else{
                    $departureDate = '';
                }

                if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00:00'){
                    $departureTime = date('H:i',strtotime($timeData['departureTime']));
                }else{
                    $departureTime = '';
                }
                
                if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='00-00-00'){
                    $arrivalDate = date('d-m-Y',strtotime($timeData['arrivalDate']));
                }else{
                    $arrivalDate = '';
                } 

                if($timeData['arrivalTime']!='' && $timeData['arrivalTime']!='00:00:00'){
                    $arrivalTime = date('H:i',strtotime($timeData['arrivalTime']));
                }else{
                    $arrivalTime = '';
                } 

                ?>
                <tr>
                <td align="left"><?php echo ucfirst($serviceType['serviceType']); ?></td>
                    <td align="left"><?php echo $flightEData['name'] ?></td>
                    <td align="left"><?php echo $flightEData['num']; ?></td>
                    <td align="left"><?php echo $departurFrom['name']; ?></td>
                    <td align="left"><?php echo $arrivalTo['name']; ?></td>
                    <td align="left"><?php echo $tfClass; ?></td>
                   
                    <td align="left"><?php echo $departureDate; ?></td>

                    <td align="left"><?php echo $departureTime; ?></td>

                    <td align="left"><?php echo $arrivalDate; ?></td>

                    <td align="left"><?php echo $arrivalTime; ?></td>
                </tr>
              <?php } ?>
                
            </table>

        </div>
        <br>
        <?php } ?>
        <!-- flight and train detail table sec ended -->
            


        <!-- cruise detail table sec started -->
        <!-- <div class="cruise-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0"  class="cruise-details-tdate">
                <div class="cruise-dt-s"><h3 class="heading-dt-s">Cruise</h3></div>
                <tr class="trav-dt-ss1">
                    <th width="20">Name</th>
                    <th width="20">Cabin Type</th>
                    <th width="20">Cruise No.</th>
                    <th width="20">From</th>
                    <th width="20">To</th>
                    <th width="20">Date</th>
                    <th width="20">Dep Time</th>
                    <th width="20">Arrv time</th>
                    <th width="20"></th>
                </tr>
                <tr>
                    <td>Markruzz</td>
                    <td>Go Air</td>
                    <td>G001</td>
                    <td>Delhi</td>
                    <td>Mumbai</td>
                    <td>29/09/23</td>
                    <td>06:00</td>
                    <td>11:00</td>
                    <td></td>
                </tr>
                
                
            </table>
        </div>
        <br> -->
        <!-- cruise detail table sec ended -->


                <!-- Ferry detail table sec ended -->

    
                <?php
					
                    $ferryQuery='';   
                    $ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'" and manualStatus=3  order by fromDate asc '); 
                    while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
                            
                        $ccc="";
                            $ccc=GetPageRecord('*','quotationFerryMaster','  id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
                        $TimeData=mysqli_fetch_array($ccc);	
    
                        $dddd="";
                            $dddd=GetPageRecord('*','ferryClassMaster','  id="'.$TimeData['ferryClass'].'"'); 
                        $ferryClassname=mysqli_fetch_array($dddd);	
    
    
                        $dd="";
                        $dd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerry['ferryId'].'"'); 
                        $ferryData=mysqli_fetch_array($dd);
    
                        
                        
            
                    ?>
                    <div class="restaurant-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Ferry</h3></div>
                    <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                    <tr>
                        
                        <!-- <td  bgcolor="#F3F3F3" width="14%" style="font-size: 16px;padding: 10px;">
                            <strong>Destination</strong>
                        </td> -->
                        <td bgcolor="#F3F3F3" width="23%" style="font-size: 14px;padding: 10px;">
                            <strong>Ferry &nbsp;Name</strong>
                        </td>
                        <td bgcolor="#F3F3F3" width="23%" style="font-size: 14px;padding: 10px;">
                            <strong>Ferry &nbsp;Service</strong>
                        </td>
                        <td bgcolor="#F3F3F3" width="23%" style="font-size: 14px;padding: 10px;">
                            <strong>Seat&nbsp;Type </strong>
                        </td>
                        <td width="20%" bgcolor="#F3F3F3" width="" style="font-size: 14px;padding: 10px;">
                            <strong>DPT Date</strong>
                        </td>
                        
                        <td bgcolor="#F3F3F3" bgcolor="#133f6d" style="font-size: 14px;padding: 10px;"><strong>DPT&nbsp;Time</strong></td>
                        <td bgcolor="#F3F3F3" bgcolor="#133f6d" style="font-size: 14px;padding: 10px;"><strong>PNR No.</strong></td>
    
                      
                    </tr>
                    <tr>
                        <!-- <td style="font-size: 16px;padding: 10px;"><?php echo getDestination($finalQuoteFerry['destinationId']); ?></td>  -->
    
                        <td style="font-size: 14px;padding: 10px;"> 
                        <?php
                        $ferryNamQuery1='';
                        $ferryNamQuery1=GetPageRecord('name',_FERRY_NAME_MASTER_,'id="'.$TimeData['ferryNameId'].'"');
                        $ferryNamD1=mysqli_fetch_array($ferryNamQuery1);
                        echo trim($ferryNamD1['name']);
                        ?>
                        
                        <!-- <?php echo strip($ferryData['name']); ?> -->

                        </td> 

                        <td style="font-size: 14px;padding: 10px;"> <?php echo strip($ferryData['name']); ?></td>
    
                        <td style="font-size: 14px;padding: 10px;" ><?php echo strip($ferryClassname['name']); ?></td> 
    
                        <td style="font-size: 14px;padding: 10px;"><?php echo date('d-m-Y',strtotime($finalQuoteFerry['fromDate']));?></td>
    
                        <td style="font-size: 14px;padding: 10px;">
                        <!-- <?php echo $TimeData['pickupTime']; ?> / -->
                         <?php echo $TimeData['dropTime']; ?>
                     </td> 
    
                        <td style="font-size: 14px;padding: 10px;"><?php echo strip($finalQuoteFerry['confirmationNo']); ?></td> 
                        
                        
                    </tr>
                    </table>
    
                    <br>
                    <?php 
                         }  
                    ?>
            <!-- Ferry detail table sec started -->


        <!-- restaurant detail table sec started -->
        <?php 
            $mealQQuery='';    
			$mealQQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'" and manualStatus = 3 order by fromDate asc ');
            if(mysqli_num_rows($mealQQuery)>0){
            ?>
         
        <div class="restaurant-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0" class="restaurant-details-tdate">
                <div class="restaurant-dt-s"><h3 class="heading-dt-s"  style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Restaurant</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                    <th align="left" width="20%">Name</th>
                    <th align="left" width="20%">Destination</th>
                    <th align="left" width="20%">Meal Plan</th>
                    <th align="left" width="20%">Date</th>
             
                    
                </tr>
                <?php
                     while($mealEData=mysqli_fetch_array($mealQQuery)){
                    $rs1='';
                    $rs1 = GetPageRecord('name',_DESTINATION_MASTER_,'id="'.$mealEData['destinationId'].'"');
                    $mealDest = mysqli_fetch_assoc($rs1);
                    
                    $rs2='';
                    $rs2 = GetPageRecord('name','restaurantsMealPlanMaster','id="'.$mealEData['mealTypeId'].'"');
                    $mealType = mysqli_fetch_assoc($rs2);
                    ?>
                <tr>
                    <td align="left"><?php echo $mealEData['mealPlanName']; ?></td>
                    <td align="left"><?php echo $mealDest['name']; ?></td>
                    <td align="left"><?php echo $mealType['name']; ?></td>
                    <td align="left"><?php echo date('d-m-Y',strtotime($mealEData['fromDate'])); ?></td>
            
                </tr> 
                <?php } ?>
            </table>
        </div>
        <br>
        <?php } ?>
        <!-- restaurant detail table sec ended -->
        <!-- addtional detail table sec start -->

        <?php 
            $addQQuery='';    
			$addQQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'" and manualStatus = 3 order by fromDate asc ');
            if(mysqli_num_rows($addQQuery)>0){
            ?>
              
        <div class="restaurant-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0" class="restaurant-details-tdate">
                <div class="restaurant-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Additional</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                    <th align="left" width="20%">Additional Name</th>
                    <th align="left" width="20%">Destination</th>
                 
                    <th align="left" width="20%">Date</th> 
                </tr>
                <?php
                     while($addEData=mysqli_fetch_array($addQQuery)){

                    $c="";  
			        $c=GetPageRecord('*','extraQuotation','id="'.$addEData['additionalId'].'"'); 
			        $addsDData=mysqli_fetch_array($c);	

                    $rs1='';
                    $rs1 = GetPageRecord('name',_DESTINATION_MASTER_,'id="'.$addEData['destinationId'].'"');
                    $addsDest = mysqli_fetch_assoc($rs1);

                    ?>
                <tr>
                    <td align="left"><?php echo $addsDData['name']; ?></td>
                    <td align="left"><?php echo $addsDest['name']; ?></td>
                   
                    <td align="left"><?php echo date('d-m-Y',strtotime($addEData['fromDate'])); ?></td>
            
                </tr> 
                <?php } ?>
            </table>
        </div>
        <br>
        <?php } ?>
         <!-- visa detail table sec started -->
       <?php  
        $VBRC = GetPageRecord('*','finalQuoteVisa','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
        if(mysqli_num_rows($VBRC)>0){ ?>
        
         <div class="visa-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0"  class="visa-details-tdate">
                <div class="visa-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Visa</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                    <th align="left" width="20">Name</th>
                    <th align="left" width="200">Type</th>
                    
                </tr>
                <?php
                   
                   while($visaQuoteData = mysqli_fetch_array($VBRC)){
   
                    $rsV = GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuoteData['visaTypeId'].'"');
                    $visaType = mysqli_fetch_array($rsV);
                   ?>
                   <tr>
                       <td align="left"><?php echo $visaQuoteData['name'] ?></td>
                       <td align="left"><?php echo $visaType['name'] ?></td>
                       <!-- <td><?php echo $visaQuoteData['adultPax'] ?></td>
                       <td><?php echo $visaQuoteData['childPax'] ?></td>
                       <td><?php echo $visaQuoteData['infantPax'] ?></td> -->
                   </tr>
                   <?php

               }
               ?>
            </table>
        </div>
        <br>
        <?php } ?>
        <!-- visa detail table sec ended -->


        <!-- value added services detail table sec started -->
        <?php
        //  
         $query='';
         $Vquery='';
         $Vquery = '(SELECT quotationId,manualStatus,fQP.id as mainId,fQP.name as serviceName,PT.name as typeName FROM finalQuotePassport fQP INNER JOIN passportTypeMaster PT on fQP.passportTypeId=PT.id WHERE quotationId="'.$quotationData['id'].'" and manualStatus=3 ) UNION ALL
         (SELECT quotationId,manualStatus,fQI.id as mainId,fQI.name as serviceName,IT.name as typeName FROM finalQuoteInsurance fQI INNER JOIN InsuranceTypeMaster IT on fQI.insuranceTypeId=IT.id WHERE quotationId="'.$quotationData['id'].'" and manualStatus=3)'; 
        //  
          $query = mysqli_query(db(),$Vquery);
         if(mysqli_num_rows($query)>0){
         ?>
         
        <div class="vaservices-details-sec">
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="5" cellspacing="0" class="vaservices-details-tdate">
                <div class="vaservices-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Value Added Services</h3></div>
                <tr class="trav-dt-ss1" style="background-color: #f4f4f4 !important;">
                    <th align="left" width="10%">Service&nbsp;Type</th>
                    <th align="left" width="20%">Name</th>
                    <th align="left" width="">Type</th>
                </tr>
                <?php while($valueAdded = mysqli_fetch_assoc($query)){ 
                    
                    $rsv = GetPageRecord('serviceType','finalquotationItinerary','serviceId="'.$valueAdded['mainId'].'" and quotationId="'.$valueAdded['quotationId'].'" and serviceType in ("passport","insurance")');
                    $serviceTypeD = mysqli_fetch_assoc($rsv);
                    ?>
                <tr>
                    <td><?php echo ucfirst($serviceTypeD['serviceType']); ?></td>
                    <td><?php echo $valueAdded['serviceName']; ?></td>
                    <td><?php echo $valueAdded['typeName']; ?></td>
                </tr>
              <?php } ?>
                
            </table>
        </div>
        <br>
        <?php } ?>
        <!-- value added services detail table sec ended -->


        <div class="modesecsurfacetrainflight">
<!-- Departur info start -->

            <!-- surface -->
            <?php if($modeType=='surface') {?>
            <div class="surface box1" style="background: none;">
            <div ><h3 class="traveller-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Departure Information Surface</h3></div>
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate" style="background: #e7ebec;">
                    <tr class=""  style="background-color:none!important">
                        <th width="20" align="left">Type</th>
                        <th width="20" align="left">Vehicle Type</th>
                        <th width="20" align="left">Number</th>
                        <th width="20" align="left">To</th>
                        <th width="20" align="left">DPT&nbsp;Date</th>
                        <th width="20" align="left">DPT&nbsp;Time</th>
                        <th width="20" align="left">Pickup Address</th>
                        <th width="20" align="left">Drop Address</th>
                    </tr>
                    <tr style="background: white;">
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mds_type_dmc" id="mds_type_dmc" value="<?php echo $dmcmodedetails['SurfaceDtype']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mds_vehiletype_dmc" id="mds_vehiletype_dmc" value="<?php echo $dmcmodedetails['SurfaceDname']?>">
                        </td>

                        <td align="left">
                            <input style="width: 100%;" type="text" name="mds_number_dmc" id="mds_number_dmc" value="<?php echo $dmcmodedetails['SurfaceDnumber']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mds_to_dmc" id="mds_to_dmc" value="<?php echo $dmcmodedetails['SurfaceDfrom']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="date" class="end_start_td" name="mds_dptdate_dmc" id="mds_dptdate_dmc" value="<?php echo $dmcmodedetails['SurfacedropDate']?>">
                        </td>

                        
                        <td align="left">
                            <input style="width: 100%;" type="text" class="end_start_td flighttimepicker2" name="mds_dpttime_dmc" id="mds_dpttime_dmc" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $dmcmodedetails['SurfaceDptTime']?>"  >
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mds_picadd_dmc" id="mds_picadd_dmc" value="<?php echo $dmcmodedetails['SurfaceDpicAdd']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mds_dropadd_dmc" id="mds_dropadd_dmc" value="<?php echo $dmcmodedetails['SurfaceDdropAdd']?>">
                        </td>
                       
                    </tr>
                </table>
            </div>
            <?php } ?>


            <!-- flight -->

            <?php if($modeType=='flight') { ?>
            <div class="flight box1" style="background: none!important;">
            <div ><h3 class="traveller-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Departure Information Flight</h3></div>
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate" style="background: #e7ebec;">
                    <tr class=""  style="background-color:none!important">
                        <th width="20" align="left">Type</th>
                        <th width="20" align="left">Name</th>
                        <th width="20" align="left">Number</th>
                        <th width="20" align="left">To</th>
                        <th width="20" align="left">DPT&nbsp;Date</th>
                        <th width="20" align="left">DPT&nbsp;Time</th>
                        <th width="20" align="left">Pickup Address</th>
                        <th width="20" align="left">Drop Address</th>
                    </tr>
                    <tr style="background: white;">
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdf_type_dmc" id="mdf_type_dmc" value="<?php echo $dmcmodedetails['Dtype']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdf_name_dmc" id="mdf_name_dmc" value="<?php echo $dmcmodedetails['Dname']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdf_number_dmc" id="mdf_number_dmc" value="<?php echo $dmcmodedetails['Dnumber']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdf_to_dmc" id="mdf_to_dmc" value="<?php echo $dmcmodedetails['Dfrom']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="date" class="end_start_td" name="mdf_dptdate_dmc" id="mdf_dptdate_dmc" value="<?php echo $dmcmodedetails['dropDate']?>">
                        </td>

                        
                        <td align="left">
                            <input style="width: 100%;" type="text" class="end_start_td flighttimepicker2" name="mdf_dpttime_dmc" id="mdf_dpttime_dmc" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $dmcmodedetails['DptTime']?>"  >
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdf_picadd_dmc" id="mdf_picadd_dmc" value="<?php echo $dmcmodedetails['DpicAdd']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdf_dropadd_dmc" id="mdf_dropadd_dmc" value="<?php echo $dmcmodedetails['DdropAdd']?>">
                        </td>
                       
                    </tr>
                </table>
            </div>

            <?php } ?>



            <?php if($modeType=='train') {?>
            <div class="train box1" style="background: none;">

            <div ><h3 class="traveller-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Departure Information Train</h3></div>
            <table width="100%" border="1" bordercolor="#cecece" cellpadding="10" cellspacing="0" class="tbl-tdate" style="background: #e7ebec;">
                    <tr class=""  style="background-color:none!important">
                        <th width="20" align="left">Type</th>
                        <th width="20" align="left">Name</th>
                        <th width="20" align="left">Number</th>
                        <th width="20" align="left">To</th>
                        <th width="20" align="left">DPT&nbsp;Date</th>
                        <th width="20" align="left">DPT&nbsp;Time</th>
                        <th width="20" align="left">Pickup Address</th>
                        <th width="20" align="left">Drop Address</th>
                    </tr>
                    <tr style="background: white;">
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdt_type_dmc" id="mdt_type_dmc" value="<?php echo $dmcmodedetails['TrainDtype']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdt_name_dmc" id="mdt_name_dmc" value="<?php echo $dmcmodedetails['TrainDname']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdt_number_dmc" id="mdt_number_dmc" value="<?php echo $dmcmodedetails['TrainDnumber']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdt_to_dmc" id="mdt_to_dmc" value="<?php echo $dmcmodedetails['TrainDfrom']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="date" class="end_start_td" name="mdt_dptdate_dmc" id="mdt_dptdate_dmc" value="<?php echo $dmcmodedetails['TraindropDate']?>">
                        </td>

                        
                        <td align="left">
                            <input style="width: 100%;" type="text" class="end_start_td flighttimepicker2" name="mdt_dpttime_dmc" id="mdt_dpttime_dmc" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $dmcmodedetails['TrainDptTime']?>"  >
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdt_picadd_dmc" id="mdt_picadd_dmc" value="<?php echo $dmcmodedetails['TrainDpicAdd']?>">
                        </td>
                        <td align="left">
                            <input style="width: 100%;" type="text" name="mdt_dropadd_dmc" id="mdt_dropadd_dmc" value="<?php echo $dmcmodedetails['TrainDdropAdd']?>">
                        </td>
                       
                    </tr>
                </table>
            </div>
            <?php } ?>
            <!-- Departur info Ended -->
        </div>


        <?php 
        $rstota=''; 
        $rstota=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'quotationId='.$quotationId.''); 
        $gettotalAMT=mysqli_fetch_array($rstota); 
        $TotalPMT = $gettotalAMT['totalClientCost'];




        $result22Pay = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
        $scheduledData22Pa = mysqli_fetch_assoc($result22Pay);

        $showId = $scheduledData22Pa['paymentshow'];




        $result = GetPageRecord('*','agentPaymentMaster','quotationId="'.$quotationId.'"');
        $scheduledData = mysqli_fetch_assoc($result);
        $schduleId = $scheduledData['scheduleId'];
        $scheduledData['quotationId'];
        $paymentshow = $scheduledData['paymentshow'];
       if($showId==1){
        
        ?>
        <!-- Started payment Information Related code -->
        <div class="paymentinfo">
            <div class="vaservices-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px; background-color: #acc5ef;font-size: 16px;font-weight: 500;">Payment Information</h3></div>
            <table width="100%" border="1" bordercolor="#cecece" align="center" cellpadding="10" cellspacing="0">

            <?php 
            
            
                $result = GetPageRecord('*','agentPaymentMaster','quotationId="'.$quotationId.'"');
                $scheduledData = mysqli_fetch_assoc($result);
                $schduleId = $scheduledData['scheduleId'];
                $scheduledData['quotationId'];

               
                
                // finalCost,receivedAmount,pendingCost

                $ptype = GetPageRecord('*','paymentTypeMaster','id="'.$scheduledData['paymentBy'].'" and status=1');
                $paymenttype = mysqli_fetch_assoc($ptype);

                $respay = GetPageRecord('*','quotationMaster','id="'.$scheduledData['quotationId'].'" and status=1');
                $agentPayment = mysqli_fetch_assoc($respay);
                $finalCost = round($agentPayment['totalQuotCost']);

                $result = GetPageRecord('SUM(amount) as paidAmount','agentPaymentMaster','quotationId="'.$scheduledData['quotationId'].'"');
                $paidPayment = mysqli_fetch_assoc($result);
                $receivedAmount = $paidPayment['paidAmount'];

                $pendingCost = $finalCost-$paidPayment['paidAmount'];
               

            
            ?>

            
                    <tr class="trav-dt-ss1"  style="background-color: #f4f4f4;">
                        <!-- <th align="center">Total Amount (INR)</th>
                        <th align="center">Received Amount (INR)</th>
                        <th align="center">Pending Amount (INR)</th> -->
                        <th align="center">Total Amount (<?php echo getCurrencyName($gettotalAMT['currencyId']); ?>)</th>
                    <th align="center">Received Amount (<?php echo getCurrencyName($gettotalAMT['currencyId']); ?>)</th>
                    <th align="center">Pending Amount (<?php echo getCurrencyName($gettotalAMT['currencyId']); ?>)</th>
                    </tr>

                    <tr>
                        <td align="center"><?php echo $finalCost; ?></td>
                        <td align="center"><?php echo $receivedAmount; ?></td>
                        <td align="center"><?php echo $pendingCost; ?></td>
                    </tr>
            
            </table>

            <br>
                <div class="vaservices-dt-s" id="payLine" style="color:red;"><h3 style="text-transform: uppercase;">Any pending amount to be paid on or before the trip date</h3></div>
            <br>
        </div>

        <?php } ?>

            <br>
            <!-- <div class="vaservices-dt-s"><h3 style="text-transform: uppercase;">Any pending amount to be paid on or before the trip date</h3></div> -->
        
            <!--Ended payment Information Related code -->
        <br>

        <div class="vaservices-details-sec">
        <div class="vaservices-dt-s"><h3 >Notes</h3></div>
        <div style="width: 98.2%;height: 60px; padding: 5px; border:1px solid grey !important;"><?php echo strip_tags(nl2br($cli_voucherNotes)); ?></div>
           
            <br/>
            <br/>
            <div class="vaservices-dt-s"><h3 >Remarks</h3></div>
            <div style="width: 98.2%;height: 60px;padding: 5px;  border:1px solid grey !important;"><?php echo strip_tags(nl2br($voucherNotes)); ?></div>
            <br>
            <br>
            
           <?php

            $rsem1 = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,' contactPerson!="" order by id desc');
            if(mysqli_num_rows($rsem1)>0){
             $emData1 = mysqli_fetch_assoc($rsem1);
              // started salse person detail 
           // started salse person detail 
            
           $result22 = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
           $scheduledData22 = mysqli_fetch_assoc($result22);
           $queryId = $scheduledData22['queryId'];

            $result33 = GetPageRecord('*','queryMaster','id="'.$queryId.'"');
           $salesPersonData = mysqli_fetch_assoc($result33);
           $id = $salesPersonData['id'];
           $salesPersonName = $salesPersonData['salesassignTo'];
           $salesPersonId = $salesPersonData['salesPersonId'];
           $assignTo = $salesPersonData['assignTo'];

           $whereSale='id="'. $salesPersonData['salesPersonId'].'"';  
           $rsSal=GetPageRecord('*',_USER_MASTER_,$whereSale); 
           $resListingSales=mysqli_fetch_array($rsSal);
           $salesPerson=$resListingSales['firstName'].' '.$resListingSales['lastName'];

           $email1=$resListingSales['email'];
           $phone1=$resListingSales['phone'];
           
          


             // ended salse person detail
            
            ?>
                 
                <div class="vaservices-dt-s"><h3 class="heading-dt-s" style="padding: 6px 5px; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;"><?php echo $emData1['emergencyHeading']; ?></h3></div>
                 <table width="100%" border="1" bordercolor="#cecece" align="center" cellpadding="10" cellspacing="0">
                
                    <tr class="trav-dt-ss1"  style="background-color: #f4f4f4;">
                        <th align="left">Contact Person Name</th>
                        <th align="left">Department</th>
                        <th align="left">Mobile Number</th>
                        <th align="left">Email Id</th>
                        <th align="left">Available On</th>
                    </tr>

                    <tr>
                        <td align="left"><?php echo $salesPerson; ?></td>
                        <td align="left"><?php echo 'Sales'; ?></td>
                        <td align="left"><?php echo $phone1; ?></td>
                        <td align="left"><?php echo $email1; ?></td>
                        <td align="left"><?php echo 'WhatsApp'; ?></td>
                    </tr>
                
                <?php
                 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
                while($emData = mysqli_fetch_assoc($rsem)){
                
                ?>
                    <tr>
                        <td align="left"><?php echo $emData['contactPerson']; ?></td>
                        <td align="left"><?php echo 'Emergency'; ?></td>
                        <td align="left"><?php echo $emData['phone']; ?></td>
                        <td align="left"><?php echo $emData['email']; ?></td>
                        <td align="left"><?php echo $emData['availableOn']; ?></td>
                    </tr>
                <?php } ?>
            </table>
           
          <?php } ?>

        </div>
        <br>
            

        <!-- Tour information / Itinerary sec. started -->
        <div class="tour-info-it-sec">
            <div class="titsec"><h3 class="heading-dt-s" style="padding: 6px 5px !important; background-color: #acc5ef !important;font-size: 16px !important;font-weight: 500 !important;">Tour Information / Itinerary</h3></div>
          
            <!-- day wise itenarery sec started -->
            <div class="tour-in-dw-sec">
                
                <div class="tour-in-d-">
                    <?php
                $day=1;
                $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
                while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
                $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
                $dayId = $QueryDaysData['id']; 
                $cityId = $QueryDaysData['cityId']; 
		?>
         
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:#ffffff; background-color: #acc5ef !important;font-size: 18px;">&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></td></tr></table> 
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" >
			<tr><td>
                <div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;font-size: 14px;"><?php
                        if(strlen($QueryDaysData['title'])>1) { 
                            echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
                        
                        } 
                        $html = trim(urldecode(strip($QueryDaysData['description'])));
                        if($html!=''){
                            // $html = str_replace('<p>&nbsp;</p>', '', $html);
                            // = html_tidy('</p>', $html);
                            echo  html_tidy($html);
                        }
                        // services list
                        $cnt1 = 1;
                        $itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'"  and dayId="'.$dayId.'" order by srn asc';
                        $itineryDay1=GetPageRecord('*','quotationItinerary',$itiQuery1);  
					$totolDays1 = mysqli_num_rows($itineryDay1);
					while($sorting3 = mysqli_fetch_array($itineryDay1)){ 	  
						if($sorting3['serviceType'] == 'hotel' ){
							$where22='quotationId="'.$quotationId.'"  and dayId="'.$dayId.'"  and  supplierId="'.$sorting3['serviceId'].'"';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){ 
								$hotelQouteData=mysqli_fetch_array($rs22); 								
								$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
								$hotelData=mysqli_fetch_array($rs1ee); 
								echo "<p>".$cnt1.") <strong>Hotel:</strong> Stay at ".stripslashes($hotelData['hotelName'])."</p>";		
								// if($cnt1 < $totolDays1){ echo "<br />"; }  				
							}	 
						}	
						if($sorting3['serviceType'] == 'flight' ){
							$where22flt1='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"'; 
							$rs22flt1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22flt1);
							if(mysqli_num_rows($rs22flt1) > 0){ 
								$flightQuoteData = mysqli_fetch_array($rs22flt1);
								
								$rs1=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData['flightId'].'"');  
								$flightData=mysqli_fetch_array($rs1);
								
								if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '05:30'){
									$departureTime = " at ".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
								}else{
									$departureTime ='';
								}	
								if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '05:30'){
									$arrivalTime = date('Hi',strtotime($flightQuoteData['arrivalTime']));
								}else{
									$arrivalTime ='';
								}	 
								
								$jfrom = getDestination($flightQuoteData['departureFrom']);
								$jto= getDestination($flightQuoteData['arrivalTo']); 

								echo "<p>".$cnt1.") <strong>Flight:</strong> ".strip($flightData['flightName']).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass'])."</p>"; 

								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							} 
						}	
						if($sorting3['serviceType'] == 'train' ){ 
							
								$where22='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"'; 
								$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
								if(mysqli_num_rows($rs22) > 0){ 
									$trainQuoteData=mysqli_fetch_array($rs22);

									$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
									$trainData=mysqli_fetch_array($rs1);  

									$journeyType="";
									$jfrom = getDestination($trainQuoteData['departureFrom']);
									$jto= getDestination($trainQuoteData['arrivalTo']);

									if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
									$departureTimet = " at ".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
									}else{
									$departureTimet ='';
									}	
									if(date('H:i',strtotime($trainQuoteData['arrivalTime'])) <> '05:30'){
									$arrivalTimet = date('Hi',strtotime($trainQuoteData['arrivalTime']));
									}else{
									$arrivalTimet = '';
									}


								if($trainQuoteData['journeyType']=='overnight_journey'){ $journeyType="(Overnight)"; }
								else{ $journeyType="(Day)"; }

									echo "<p>".$cnt1.") <strong>Train:</strong> ".strip($trainData['trainName']).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$departureTimet.$arrivalTimet.'/ '.str_replace('_',' ',$trainQuoteData['trainClass'])."</p>"; 

									// if($cnt1 < $totolDays1){ echo "<br />"; }  
								} 	
						}	
						if($sorting3['serviceType'] == 'transfer' || $sorting3['serviceType'] == 'transportation'){  
						
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" ';						
							$b=GetPageRecord('*','quotationTransferMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$transferQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');  
								$transferData=mysqli_fetch_array($rsentn); 

								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferQuotData['vehicleModelId'].'"');
								$vename=mysqli_fetch_array($rs1aa);

								$vehicleName = $vehicleType = $trnsferType = '';
								if($transferQuotData['transferType'] == 2){
									$vehicleName = $vename['model']." | ";
									$vehicleType = getVehicleTypeName($vename['carType'])." | ";
								}
								$trnsferType = ($transferQuotData['transferType'] == 1)?'SIC | ':'Private | ';
								
								echo "<p>".$cnt1.") <strong>".ucfirst($sorting3['serviceType'])." : </strong> ".$trnsferType.$vehicleType.$vehicleName.ucfirst(strip($transferData['transferName']))."</p>";
							}
						}
						if($sorting3['serviceType'] == 'entrance'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationEntranceMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$entranceQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entranceQuotData['entranceNameId'].'"');  
								$entranceData=mysqli_fetch_array($rsentn); 

								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$entranceQuotData['vehicleId'].'"');
								$vename=mysqli_fetch_array($rs1aa);

								$vehicleName = $vehicleType = $trnsferType = '';
								if($entranceQuotData['transferType'] == 2){
									$vehicleName = $vename['model']." | ";
									$vehicleType = getVehicleTypeName($vename['carType'])." | ";
								}
								$trnsferType = ($entranceQuotData['transferType'] == 1)?'SIC | ':'Private | ';
								
								echo "<p>".$cnt1.") <strong>Entrance : </strong> ".$trnsferType.$vehicleType.$vehicleName.ucfirst(strip($entranceData['entranceName']))."</p>";
							}
						} 
						if($sorting3['serviceType'] == 'ferry'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$ferryQuotData=mysqli_fetch_array($b); 
								
								$rsentn=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferryQuotData['serviceid'].'"');  
								$ferryData=mysqli_fetch_array($rsentn); 
								echo  "<p>".$cnt1.") <strong>Ferry:</strong> ".strip($ferryData['name'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
							}
						}
						if($sorting3['serviceType'] == 'activity'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$activityQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id ="'.$activityQuotData['otherActivityName'].'"');  
								$activityData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Activity:</strong> ".strip($activityData['otherActivityName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//perPaxCost
							}
						} 
						if($sorting3['serviceType'] == 'enroute'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationEnrouteMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$enrouteQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*','packageBuilderEnrouteMaster',' id ="'.$enrouteQuotData['enrouteId'].'"');  
								$enrouteData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Enroute:</strong> ".strip($enrouteData['enrouteName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//adultCost
							}
						} 
						if($sorting3['serviceType'] == 'mealplan'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$mealplanQuotData=mysqli_fetch_array($b);
								echo  "<p>".$cnt1.") <strong>Restaurant :</strong> ".strip($mealplanQuotData['mealPlanName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							}
						} 
						if($sorting3['serviceType'] == 'additional'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$additionalQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
								$extraData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Additional:</strong> ".strip($extraData['name'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							}
						}  
						if($sorting3['serviceType'] == 'guide'){  
							$b=$where2="";		
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" ';	
							$b=GetPageRecord('*','quotationGuideMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$guideQuotData=mysqli_fetch_array($b);
							 
									$rs5="";  
								$rs5=GetPageRecord('*','tbl_guidesubcatmaster','id="'.$guideQuotData['guideId'].'"'); 
								$guideData=mysqli_fetch_array($rs5); 
								echo  "<p>".$cnt1.") <strong>Guide:</strong> ".strip($guideData['name'])."</p>"; 
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								 
							}
						}
						$cnt1++;
					}
					?>
				</div>
			</td>	
			</tr>
		</table>
		<?php 	 
		$day++; 
	} ?>
	<br />	
    </div>
    </div>
 


            <!-- day wise itenarery sec ended -->
            <?php  if($overviewText!=''){ ?> 
			    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" class="po_tc_cls" style="color:#ffffff !important; background-color: #acc5ef !important;font-size: 18px !important;">&nbsp;&nbsp;OVERVIEW</td></tr></table>
			    <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($overviewText)); ?></td></tr></table>
	        <?php } if($inclusion!=''){ ?>
			    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" class="po_tc_cls" style="color:#ffffff !important;background-color: #acc5ef !important;font-size: 18px !important;">&nbsp;&nbsp;INCLUSIONS</td></tr></table>
			    <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($inclusion)); ?></td></tr></table>
	        <?php } if($exclusion!=''){ ?> 
			    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" class="po_tc_cls" style="color:#ffffff !important;background-color: #acc5ef !important;font-size: 18px !important;">&nbsp;&nbsp;EXCLUSIONS</td></tr></table>
			    <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($exclusion)); ?></td></tr></table>
	        <?php } if($tncText!=''){ ?> 
			    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" class="po_tc_cls" style="color:#ffffff !important;background-color: #acc5ef !important;font-size: 18px !important;">&nbsp;&nbsp;TERMS & CONDITIONS</td></tr></table>
			    <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($tncText)); ?></td></tr></table>
	        <?php } if($specialText!=''){ ?> 
			    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" class="po_tc_cls" style="color:#ffffff !important;background-color: #acc5ef !important;font-size: 18px !important;">&nbsp;&nbsp;CANCELLATION POLICIES</td></tr></table>
			    <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($specialText)); ?></td></tr></table>
	        <?php } ?>

        <!-- Tour information / Itinerary sec. ended -->


        <!-- ended of documents -->
        <!-- <div class="end-of-doc">
            <div class="titsec"><h3>HOTLINE CONTACT DETAILS</h3></div>
            
        <div class="end-of-doc-sec">
            <table class="vaservices-details-tdate">
              
                <tr class="trav-dt-ss2">
                    <th width="20">Contact Name</th>
                    <th width="20">Mobile Number</th>
                    <th width="20">Email Id</th>
                    <th width="20">Available On</th>
                    
                </tr>  
                
            </table>
        </div>
        
        </div> -->
    </div>  
   
</div>
