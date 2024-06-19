<?php
include "inc.php";
$select='';
$where='';
$rs='';
$select='*';
$where='id=1';
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where);
$resultInvoiceSetting=mysqli_fetch_array($rs);
if($_REQUEST['id']!=''){
    $select1='*';
    $where1='id='.decode($_REQUEST['id']).'';
    $rs1=GetPageRecord($select1,_QUOTATION_MASTER_,$where1);
    $resultpageQuotation=mysqli_fetch_array($rs1);
    
    $a=GetPageRecord($select1,_QUERY_MASTER_,'id='.$resultpageQuotation['queryId'].'');
    $querydata=mysqli_fetch_array($a);
    if($querydata['dayWise']=='2'){
        if($querydata['seasonType']=='2'){
            $messagesu = "Valid From 01 October ".date('Y',strtotime($querydata['seasonYear']))." till 31 March&nbsp;".date('Y',strtotime($querydata['seasonYear']))."";
        }
        if($querydata['seasonType']=='1'){
            $messagesu = "Valid From 01 April ".date('Y',strtotime($querydata['seasonYear']))." till 31 August&nbsp;'".date('Y',strtotime($querydata['seasonYear']))."";
        }
        if($querydata['seasonType']=='1'){
            $messagesu = "Valid From 01 January ".date('Y',strtotime($querydata['seasonYear']))." till 31 December&nbsp;".date('Y',strtotime($querydata['seasonYear']))."";
        }
    }else{
        $messagesu = "Valid From ".date('d F Y',strtotime($resultpageQuotation['fromDate']))." to ".date('d F Y',strtotime($resultpageQuotation['toDate']))."";
    }
}
$rsp="";
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');
$resultpageQuotation=mysqli_fetch_array($rsp);
$select='*';
$where='id='.$resultpageQuotation['queryId'].'';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
$resultpage=mysqli_fetch_array($rs);
$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];
if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
    $inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
    $exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
    $tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));
}
if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
    $overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText']));
}
if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
    $highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
}
if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
    $inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
    $exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
    $tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));
}
if($resultpageQuotation['specialText']!='' || $resultpageQuotation['specialText']!='undefined'){
    $specialText=preg_replace('/\\\\/', '',clean($resultpageQuotation['specialText']));
}
if($resultpageQuotation['quotationSubject']!=''){
    $quotationSubject = preg_replace('/\\\\/', '',clean($resultpageQuotation['quotationSubject']));
}else{
    $quotationSubject = strtoupper(strip($resultpage['subject']));
}
?>
<style type="text/css">
    .ff2 {
    line-height: 1.006836;
    font-style: normal;
    font-weight: 900;
    visibility: visible;
    color: rgb(255,0,0);
    font-size: 16px;
    bottom: 402.670000px;
    height: 41.352187px;
    left: 216.049991px;
    }
        .ff9 {
    line-height: 1.006836;
    font-style: normal;
    font-weight: 900;
    visibility: visible;
    color: rgb(255,0,0);
    font-size: 20px;
    bottom: 402.670000px;
    height: 41.352187px;
    left: 216.049991px;
    }
        .ff16 {
    line-height: 1.006836;
    font-style: italic;
    font-weight: 1000;
    visibility: visible;
    color: rgb(255,0,0);
    font-size: 16px;
    bottom: 402.670000px;
    height: 41.352187px;
    left: 216.049991px;
    }
        .ff14 {
    line-height: 1.006836;
    font-style: italic;
    font-weight: normal;
    visibility: visible;
    font-size: 14px;
    bottom: 402.670000px;
    height: 41.352187px;
    left: 216.049991px;
    }
        .ff1 {
    line-height: 1.006836;
    font-style: italic;
    font-weight: 900;
    visibility: visible;
    font-size: 16px;
    bottom: 402.670000px;
    height: 41.352187px;
    left: 216.049991px;
    }
    .ff4 {
    line-height: 1.014160;
    font-style: normal;
    font-weight: normal;
    visibility: visible;
    height: 41.352187px;
    }
    .ff5 {
    line-height: 1.011230;
    font-style: normal;
    font-weight: normal;
    visibility: visible;
    font-size: 14px;
    }
    .ft57 {
    font-size: 12px;
    line-height: 17px;
    color: #000000;
    }.ft56 {
    font-size: 12px;
    color: #ff0000;
    }
    .ft52 {
    font-size: 12px;
    color: #000000;
    }
    .ft17 {
    font-size: 12px;
    line-height: 17px;
    color: #000000;
    }
    .ft20 {
    font-size: 14px;
    color: #000000;
    }
    .ft31 {
    font-size: 12px;
    color: #000000;
    }
    .ft26 {
    font-size: 12px;
    line-height: 17px;
    color: #000000;
    }
    .ft610 {
    font-size: 12px;
    line-height: 17px;
    color: #000000;
    }
    ul{
    padding-left: 20px;
    }
    .ft78 {
    font-size: 12px;
    line-height: 17px;
    color: #000000;
    }
    .ft75 {
    font-size: 18px;
    color: #000000;
    }
    .ft76 {
    font-size: 17px;
    color: #000000;
    }
    .ft79 {
    font-size: 12px;
    line-height: 18px;
    color: #000000;
    }
    .ft15 {
    font-size: 14px;
    color: #000000;
    }
</style>
<div style="display:none;" class="calcostsheet">
    <?php
    include_once("loadFITCostSheet.php");
    ?>
</div>
<div class="main-container"><table  width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
        <tbody>
            <tr>
                <td align="center" valign="top"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo;?>" width="790" ></td>
            </tr>
        </tbody>
    </table>
    <table width="100%" align="center" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000" >
        <tr>
            <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
                <tr>
                    <td width="100%" align="center" class="ft11" style="color: #FF9900;font-size: 20px;text-align: center;"><strong><?php echo strtoupper(strip($resultpageQuotation['quotationSubject'])); ?></strong></td>
                </tr>
                <tr>
                    <td width="100%" align="center"  style="color:#000000;font-size:12px;"><?php echo $resultpage['night']; ?>&nbsp;Nights&nbsp;/&nbsp;<?php echo $resultpage['night']+1; ?>&nbsp;Days&nbsp;</td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center"  colspan="2"><?php 
            if($resultpageQuotation['image']!=''){
                $proposalImg = 'dirfiles/'.$resultpageQuotation['image'];
                if(file_exists($proposalImg)==true){
                    $proposalPhoto = $fullurl.$proposalImg;
                }else{
                    $proposalPhoto = $fullurl.'images/sample-proposal.jpg';
                }
            }else{
                $proposalPhoto = $fullurl.'images/sample-proposal.jpg';
            }
            ?><img src="<?php echo $proposalPhoto; ?>" width="790" height="300" style="width: 100%;">
            </td>
        </tr>
        <tr>
            <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px;">
                <tr>
                    <td align="left" class="ft15" style="font-size:13px;"><strong>OVERVIEW:</strong>
                        <p class="ft17"><?php echo (str_replace('&nbsp;',' ',(stripslashes($overviewText)))); ?></p></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px;">
                <tr>
                    <td colspan="2" align="left" class="ft15" style="font-size:13px;"><strong>TRIP HIGHLIGHTS:</strong>
                        <p class="ft17"><?php echo (str_replace('&nbsp;',' ',(stripslashes($highlightsText)))); ?></p></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><table width="100%" cellspacing="0" cellpadding="0" >
                <tr>
                    <td colspan="2" align="left" class="ft15" style="font-size:13px;"><strong>SKETCH&nbsp;ITINERARY:</strong><br /><br /></td>
                    </tr>
                    <tr>
                        <td align="left" width="25%">&nbsp;</td>
                        <td  align="left"><table border="1" cellpadding="3" cellspacing="0" bordercolor="#ddd" style="font-size:12px;" width="100%">
                            <tr>
                                <td width="40%" align="left" bgcolor="#ddd"><strong>Day</strong></td>
                                <td width="60%" align="left" bgcolor="#ddd"><strong>Destination</strong></td>
                            </tr>
                            <?php
                            $rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'" ');
                            $quotationData=mysqli_fetch_array($rs2);
                            
                            $rs3=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');
                            $queryData=mysqli_fetch_array($rs3);
                            $quotationId=$quotationData['id'];
                            $startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($quotationData['fromDate'])));
                            $day=1;
                            $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" order by id asc');
                            while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
                            $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
                            
                            
                            $destname = getDestination($QueryDaysData['cityId']);
                            
                            $previousDest = $QueryDaysData['cityId'];
                            ?>
                            <tr>
                                <td width="40%"><span>Day&nbsp;<?php echo $day; ?></span></td>
                                <td width="60%"><span><?php echo $destname; ?></span></td>
                            </tr>
                            <?php
                            $day++;
                            }
                            ?>
                        </table></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><strong>DETAILED&nbsp;ITINERARY</strong></td>
        </tr>
        <?php
        $rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'" ');
        $quotationData=mysqli_fetch_array($rs2);
        $rs3=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');
        $queryData=mysqli_fetch_array($rs3);
        // $rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'"');
        // $resultpageQuotation=mysqli_fetch_array($rsp);
        
        $quotationId=$quotationData['id'];
        $queryId=$quotationData['queryId'];
        $startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($quotationData['fromDate'])));
        
        $day=1;
        $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" order by id asc');
        while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
            
            $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
            $a22=GetPageRecord('*','destinationMaster','id="'.$QueryDaysData['cityId'].'"');
            $destData22=mysqli_fetch_array($a22);
            $cityId = $QueryDaysData['cityId'];
            // get the todeestination image
            $destinationImage = '';
            
            
            $destname = getDestination($cityId);
            $rs5='';
            $rs5=GetPageRecord('*','imageGallery',' parentId = "'.$activityData['id'].'" and galleryType="destination" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="1080x300" ) ');
            $resListing5=mysqli_fetch_array($rs5);
            if($resListing5['fileId']!=''){
                $destinationImage2 = geDocFileSrc($resListing5['fileId']);
                if(file_exists($destinationImage2)==true){
                 // $destinationImage =  '<tr><td colspan="2" align="center"><br><img src="'.$fullurl.str_replace(' ', '%20',$destinationImage2).'" width="790" height="300" /></td></tr>';
                }
            }
                
            if($day == 1){
                if($destinationImage!=''){
                    // $destinationImage = '<tr><td colspan="2" align="center"><br><img src="'.$fullurl.geDocFileSrc($resListing44['fileId']).'" width="790" height="300" /></td></tr>';
                    echo $destinationImage;
                }
            }
            ?>
            <tr>
                <td colspan="2" align="left" bgcolor="#fff" style="font-size:15px;">Day&nbsp;<?php echo $day; ?>&nbsp;
                <?php if($day == 1){ echo "Arrive&nbsp;"; } echo $destname; ?></td>
            </tr>
            <?php
            //echo $fullurl.'packageimages/'.$destData221['destinationImage'];
            $itiQueryflt = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType = "flight" order by startDate asc';
            $itineryDayflt1=GetPageRecord('*','quotationItinerary',$itiQueryflt);
            if(mysqli_num_rows($itineryDayflt1) > 0){
                $itineryDayDataflt1 = mysqli_fetch_array($itineryDayflt1);
                
                $where22flt1='quotationId="'.$quotationId.'" and id="'.$itineryDayDataflt1['serviceId'].'"';
                $rs22flt1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22flt1);
                $flightQuoteData1 = mysqli_fetch_array($rs22flt1);
                
                $rs1=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData1['flightId'].'"');
                $flightData=mysqli_fetch_array($rs1);
                
                if(date('H:i',strtotime($flightQuoteData1['departureTime'])) <> '05:30'){
                    $dptTime = date('d-m-Y ',strtotime($flightQuoteData1['departureDate'])).date('H:i',strtotime($flightQuoteData1['departureTime']));
                }else{
                    $dptTime ='';
                    }
                if(date('H:i',strtotime($flightQuoteData1['arrivalTime'])) <> '05:30'){
                    $avrTime = date('d-m-Y ',strtotime($flightQuoteData1['arrivalDate'])).date('H:i',strtotime($flightQuoteData1['arrivalTime']));
                }else{
                    $avrTime ='';
                }
                
                $flightTitle = $destname.'-'.$flightData['flightName'].'-'.$flightQuoteData1['flightNumber'].' @'.$dptTime.'/'.$avrTime;
                if($QueryDaysData['title']!=''){
                    echo '<tr><td colspan="2" ><br><p style="text-align:justify" class="ft26">'.urldecode(strip($QueryDaysData['title'])).'</p></td></tr>';
                }
            }
            //if flight exist
            if(mysqli_num_rows($rs22flt1) > 0){ ?>
            <tr><td colspan="2" align="left"><strong style='color:blue;font-size:14px;'><?php echo $flightTitle;?></strong>
                <p style="color:green;">(Reporting time at the airport for domestic flight is at least 1.5 hours prior to flight departure time)</p>
                </td>
            </tr>
            <?php
            }
            if($day!= 1 && $destinationImage!=''){
            ?>
            <tr><td colspan="2" ><?php echo $destinationImage; ?><br></td>
            </tr>
            <?php
            }
            if($QueryDaysData['description']!=''){ ?>
            <tr><td colspan="2" align="left"><?php echo urldecode($QueryDaysData['description']); ?><br></td>
            </tr>
            <?php
            }
            ?>
            <tr><td colspan="2" align="left"><?php
                $itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
                $itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);
                while($itineryDayData = mysqli_fetch_array($itineryDay)){
                    if($itineryDayData['serviceType'] == 'hotel'){
                        $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and dayId="'.$itineryDayData['dayId'].'" and serviceType="hotel" order by startDate asc');
                        while($sorting1=mysqli_fetch_array($b1)){
                            $where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'" and isHotelSupplement=0';
                            $rs22=GetPageRecord('*','quotationHotelMaster',$where22);
                            $counthotelo = mysqli_num_rows($rs22);
                            if($counthotelo > 0){
                                echo "Overnight at";
                                while($hotelQouteData=mysqli_fetch_array($rs22)){

                                $hotelTypeLable = $earlyLable ='';
                             
                                if($hotelQouteData['isLocalEscort']==1){
                                $hotelTypeLable .= "Local Escort,";
                                }
                                if($hotelQouteData['isForeignEscort']==1){
                                $hotelTypeLable .= "Foreign Escort,";
                                }
                                if($hotelQouteData['isGuestType']==1 && ($hotelQouteData['isLocalEscort']==1 || $hotelQouteData['isForeignEscort']==1)){
                                $hotelTypeLable .= "Guest,";
                                }
                                if($hotelQouteData['fromDate']==$startdatevar){
                                $earlyLable = "Early CheckIn ";
                                }
                                
                                $rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotelQouteData['roomType'].'"');
                                $roomtype=mysqli_fetch_array($rs23qwe);
                                $roomType = $roomtype['name'];
                                
                                $rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');
                                $hotelData=mysqli_fetch_array($rs1ee);
                                ?>
                                <a href="#"><?php echo $earlyLable.rtrim($hotelTypeLable,',')." Hotel | ".stripslashes($hotelData['hotelName']);?></a>&nbsp;-&nbsp;<?php echo stripslashes($roomType);?>&nbsp;
                                <?php
                                 echo "<br>";
                                }
                            }
                        }
                        echo "<strong>Meals:&nbsp;Breakfast</strong><br>";
                        // For Supplement hotel 
                        $b1s=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and dayId="'.$itineryDayData['dayId'].'" and serviceType="hotel" order by srn asc,id desc');
                        while($sortings=mysqli_fetch_array($b1s)){
                            $wheres='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sortings['serviceId'].'" and isHotelSupplement=1';
                            $rss=GetPageRecord('*','quotationHotelMaster',$wheres);
                            $countsuphotel = mysqli_num_rows($rss);
                            if($countsuphotel>0){
                                echo "Suppliment Hotel ";
                                    while($hotelQouteData=mysqli_fetch_array($rss)){
                                        $rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotelQouteData['roomType'].'"');
                                        $roomtype=mysqli_fetch_array($rs23qwe);
                                        $roomType = $roomtype['name'];
                                        
                                        $rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');
                                        $hotelData=mysqli_fetch_array($rs1ee);
                                        ?><a href="#"><?php echo stripslashes($hotelData['hotelName']);?></a>&nbsp;-&nbsp;<?php echo stripslashes($roomType);?>&nbsp;/
                                        <?php
                                    }
                                echo "<br>";
                            }
                        }
        
                    }
                    if($itineryDayData['serviceType'] == 'train' ){
                        $where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc';
                        $rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);
                        if(mysqli_num_rows($rs22) > 0){ ?><table width="100%" align="left" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;margin-bottom:10px;"><?php
                            while($trainQuoteData=mysqli_fetch_array($rs22)){
                                
                                $rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');
                                $trainData=mysqli_fetch_array($rs1);
                                
                                $jfrom = getDestination($trainQuoteData['departureFrom']);
                                $jto= getDestination($trainQuoteData['arrivalTo']);
                                
                                if(date('Hi',strtotime($trainQuoteData['departureTime'])) <> '0530'){
                                    $dptTime = "/@".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
                                }else{
                                    $dptTime ='';
                                    }
                                if(date('Hi',strtotime($trainQuoteData['arrivalTime'])) <> '0530'){
                                    $avrTime = date('Hi',strtotime($trainQuoteData['arrivalTime']))." Hrs";
                                }else{
                                    $avrTime ='';
                                }
        
                                $journeyType="";
                                if($trainQuoteData['journeyType']=='overnight_journey'){ $journeyType = "(Overnight)"; }else{ $journeyType = "(Day)"; }
                                ?>
                                <tr><td colspan="2"><?php echo"Train: ".strip($trainData['trainName']).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/'.strip($trainQuoteData['trainClass']); ?>&nbsp;</td>
                                </tr>
                        <?php } ?>
                        </table>
                        <?php
                        }
                    }
                    //end of the services loop
                }
                ?>
                </td>
            </tr>
            <?php
            //end of the day loop
            $day++;
        }
        ?>
        <tr>
            <td colspan="2" align="left"><br>
            <p style="color:#00CC33;font-style:italic">(Reporting time at the airport for international flight is at least 3 hours prior to flight departure time)</p>
            <p>End of Services</p>
            <p class="ft57">Note: All information in this itinerary is accurate to the best of our knowledge but please note that changes to our trips can and do occur.  This may be due to our effort to improve our program or logistical reasons such as changes in train/flight schedules, traffic conditions, weather conditions, or government policies. <?php echo $resultInvoiceSetting['companyname'];?> will make every effort to keep you informed of any changes but cannot be held liable for any alterations made to the published itinerary.</p></td>
        </tr>
        <tr>
            <td align="left" colspan="2" style="padding:0px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;">
                <?php
                $where1='quotationId="'.$quotationId.'"  order by id asc';
                $rs12=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);
                if(mysqli_num_rows($rs12)>0){
                            
                    ?>
                    <tr>
                        <td align="left"><p style="left:27px;white-space:nowrap" class="ft52"><b>ADDITIONAL EXPERIENCES AVAILABLE</b></p></td>
                    </tr>
                    <?php
                    while($activityQuotData=mysqli_fetch_array($rs12)){
                        $rs122=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activityQuotData['otherActivityName'].'"');
                        $additionalData=mysqli_fetch_array($rs122);
                        ?>
                        <tr>
                        <td align="left"><p style="left:27px;" class="ft57"><b class="ft56"><?php echo clean($additionalData['otherActivityName']); ?></b><br><?php
                        if($resultpageQuotation['languageId'] != "0"){
                            $rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activityQuotData['otherActivityName'].'"');
                            $checkrow = mysqli_num_rows($rs2);
                            $quotationotherActivityLanData=mysqli_fetch_array($rs2);
                            if($checkrow > 0){
                                echo strip_tags($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]);
                            } else{
                                echo "";
                            } 
                        }
                        else{
                            echo $additionalData['otherActivityDetail'];
                        }
                        ?>
                        </p></td>
                    </tr>
                    <?php
                    }
                }
                
                $wheree='quotationId="'.$quotationId.'"  order by id asc';
                $rse=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$wheree);
                if(mysqli_num_rows($rse)>0){
                    while($entaranceQuotData=mysqli_fetch_array($rse)){
                        $rs1e=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entaranceQuotData['entranceNameId'].'"');
                        $entranceData=mysqli_fetch_array($rs1e);
                        ?>
                        <tr>
                        <td align="left"><strong><?php echo clean($entranceData['entranceName']); ?></strong><br>
                        <?php
                        if($resultpageQuotation['languageId'] != "0"){
                            $rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entaranceQuotData['entranceNameId'].'"');
                            $checkrow = mysqli_num_rows($rs2);
                            $quotationotherActivityLanData=mysqli_fetch_array($rs2);
                            if($checkrow > 0){
                                echo strip_tags($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]);
                            } else{
                                echo "";
                            } 
                        }
                        else{
                            echo $entranceData['entranceDetail'];
                        }
                        ?></td>
                        </tr>
                        <?php 
                    }
                }
                
                $whereer='quotationId="'.$quotationId.'"  order by id asc';
                $rser=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,$whereer);
                if(mysqli_num_rows($rser)>0){
                    while($enroutQuotData=mysqli_fetch_array($rser)){
                        $rs1er=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$enroutQuotData['enrouteId'].'"');
                        $enroutData=mysqli_fetch_array($rs1er);
                        ?>
                        <tr>
                        <td align="left"><strong><?php echo clean($enroutData['enrouteName']); ?></strong><br>
                        <?php
                        if($resultpageQuotation['languageId'] != "0"){
                            $rs2=GetPageRecord('*','enrouteLanguageMaster','enrouteId="'.$enroutQuotData['enrouteId'].'"');
                            $checkrow = mysqli_num_rows($rs2);
                            $quotationotherEnrouteLanData=mysqli_fetch_array($rs2);
                            if($checkrow > 0){
                                echo strip($quotationotherEnrouteLanData['lang_0'.$resultpageQuotation['languageId']]);
                            } else{
                                echo "";
                            } 
                        }
                        else{
                            echo $enroutData['enrouteDetail'];
                        }
                        ?></td>
                        </tr>
                    <?php }
                }
                ?>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="2" style="padding:0px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;">
                <?php
                $where1='quotationId="'.$quotationId.'"  order by id asc';
                $rs12=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);
                if(mysqli_num_rows($rs12)>0){
                            
                    ?>
                    <tr>
                        <td align="left"><p style="left:27px;white-space:nowrap" class="ft52"><b>ADDITIONAL EXPERIENCES AVAILABLE</b></p></td>
                    </tr>
                    <?php
                    while($activityQuotData=mysqli_fetch_array($rs12)){
                        $rs122=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activityQuotData['otherActivityName'].'"');
                        $additionalData=mysqli_fetch_array($rs122);
                        ?>
                        <tr>
                        <td align="left"><p style="left:27px;" class="ft57"><b class="ft56"><?php echo clean($additionalData['otherActivityName']); ?></b><br><?php
                        if($resultpageQuotation['languageId'] != "0"){
                            $rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activityQuotData['otherActivityName'].'"');
                            $checkrow = mysqli_num_rows($rs2);
                            $quotationotherActivityLanData=mysqli_fetch_array($rs2);
                            if($checkrow > 0){
                                echo strip_tags($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]);
                            } else{
                                echo "";
                            } 
                        }
                        else{
                            echo $additionalData['otherActivityDetail'];
                        }
                        ?>
                        </p></td>
                    </tr>
                    <?php
                    }
                }
                
                $wheree='quotationId="'.$quotationId.'"  order by id asc';
                $rse=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$wheree);
                if(mysqli_num_rows($rse)>0){
                    while($entaranceQuotData=mysqli_fetch_array($rse)){
                        $rs1e=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entaranceQuotData['entranceNameId'].'"');
                        $entranceData=mysqli_fetch_array($rs1e);
                        ?>
                        <tr>
                        <td align="left"><strong><?php echo clean($entranceData['entranceName']); ?></strong><br>
                        <?php
                        if($resultpageQuotation['languageId'] != "0"){
                            $rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entaranceQuotData['entranceNameId'].'"');
                            $checkrow = mysqli_num_rows($rs2);
                            $quotationotherActivityLanData=mysqli_fetch_array($rs2);
                            if($checkrow > 0){
                                echo strip_tags($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]);
                            } else{
                                echo "";
                            } 
                        }
                        else{
                            echo $entranceData['entranceDetail'];
                        }
                        ?></td>
                        </tr>
                        <?php 
                    }
                }

                $wheree='quotationId="'.$quotationId.'"  order by id asc';
                $rse=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$wheree);
                if(mysqli_num_rows($rse)>0){
                    while($ferryQuotData=mysqli_fetch_array($rse)){
                        $rs1e=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$ferryQuotData['serviceid'].'"');
                        $ferryData=mysqli_fetch_array($rs1e);
                        ?>
                        <tr>
                        <td align="left"><strong><?php echo clean($ferryData['name']); ?></strong><br>
                        <?php  echo $ferryData['information']; ?></td>
                        </tr>
                        <?php 
                    }
                }
                
                $whereer='quotationId="'.$quotationId.'"  order by id asc';
                $rser=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,$whereer);
                if(mysqli_num_rows($rser)>0){
                    while($enroutQuotData=mysqli_fetch_array($rser)){
                        $rs1er=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$enroutQuotData['enrouteId'].'"');
                        $enroutData=mysqli_fetch_array($rs1er);
                        ?>
                        <tr>
                        <td align="left"><strong><?php echo clean($enroutData['enrouteName']); ?></strong><br>
                        <?php
                        if($resultpageQuotation['languageId'] != "0"){
                            $rs2=GetPageRecord('*','enrouteLanguageMaster','enrouteId="'.$enroutQuotData['enrouteId'].'"');
                            $checkrow = mysqli_num_rows($rs2);
                            $quotationotherEnrouteLanData=mysqli_fetch_array($rs2);
                            if($checkrow > 0){
                                echo strip($quotationotherEnrouteLanData['lang_0'.$resultpageQuotation['languageId']]);
                            } else{
                                echo "";
                            } 
                        }
                        else{
                            echo $enroutData['enrouteDetail'];
                        }
                        ?></td>
                        </tr>
                    <?php }
                }
                ?>
                </table>
            </td>
        </tr>
        
        <?php if($querydata['dayWise']=='2'){ ?>
        <tr>
            <td align="center" colspan="2"><strong style="font-size:20px;">ESTIMATED TOUR COST - (Net Non-Commissionable)</strong></td>
        </tr>
        <?php } ?>
        <?php if($querydata['dayWise']=='1'){ ?>
        <tr>
            <td align="center" colspan="2"><strong style="font-size:20px;">TOUR COST</strong></td>
        </tr>
        <?php } ?>
        <tr>
            <td align="center" colspan="2"><strong style="font-size:16px;"><?php echo $messagesu; ?></strong></td>
        </tr>
        <?php if($querydata['dayWise']=='2'){ ?>
        <tr>
            <td align="center" colspan="2"><strong style="font-size:12px;">April to September rates are approx. 30% lowers</strong></td>
        </tr>
        <?php } ?>
        <?php if($querydata['dayWise']=='2'){ ?>
        <tr>
            <td align="center" colspan="2"><strong style="font-size:12px;">For exact tour price send us dates we will check availability and negotiate rates and send you quote</strong></td>
        </tr>
        <?php } ?>
    <tr>
        <td align="center" colspan="2"><table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="99%" style="font-size:12px;">
        <tr>
            <?php
            $singleRoom = $resultpageQuotation['sglRoom'];
            $doubleRoom = $resultpageQuotation['dblRoom'];
            $tripleRoom = $resultpageQuotation['tplRoom'];
            $twinRoom   = $resultpageQuotation['twinRoom'];
            $extraBedChild = $resultpageQuotation['childwithNoofBed'];

            $conspan = 0;
            if($singleRoom>0){ $conspan=$conspan+1; }
            if($doubleRoom>0){ $conspan=$conspan+1; }
            if($tripleRoom>0){ $conspan=$conspan+1; }
            if($extraBedChild>0){ $conspan=$conspan+1; }
            $colsWidth = 80/$conspan;

            ?>
            <td width="20%" align="right" rowspan="2" bgcolor="#F4F4F4" valign="middle"><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></td>
            <?php if($conspan>0){ ?>
            <td width="80%" colspan="<?php echo $conspan; ?>" align="right" valign="middle" bgcolor="#F4F4F4"><strong>Per Person Cost(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></td>
            <?php } ?>
        </tr>
        <tr>
            <?php if($singleRoom>0){ ?>
            <td width="<?php echo $colsWidth; ?>%" align="right" valign="middle" bgcolor="#F4F4F4"><strong>Single Basis</strong></td>
            <?php } if($doubleRoom>0){ ?>
            <td width="<?php echo $colsWidth; ?>%" align="right" valign="middle" bgcolor="#F4F4F4"><strong>Double Basis</strong></td>
            <?php } if($tripleRoom>0){ ?>
            <td width="<?php echo $colsWidth; ?>%" align="right" valign="middle" bgcolor="#F4F4F4"><strong>ExtraBed(Adult) Basis</strong></td>
            <?php } if($extraBedChild>0){ ?>
            <td width="<?php echo $colsWidth; ?>%" align="right" valign="middle" bgcolor="#F4F4F4"><strong>ExtraBed(child) Basis</strong></td>
            <?php } ?>
        </tr> 
        <tr>
            <td align="right" valign="middle">
                <?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
            </td>
            <?php if($singleRoom>0){ ?>
            <td align="right" valign="middle">
                <?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
                </td>
            <?php } if($doubleRoom>0){ ?>
            <td align="right" valign="middle">
                <?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
                </td>
            <?php } if($tripleRoom>0){ ?>
            <td align="right" valign="middle">
                <?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedABasis)); ?>
                </td>
            <?php } if($extraBedChild>0){ ?>
            <td align="right" valign="middle"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?></td>
            <?php } ?>
        </tr>
        </table>
        </td>
    </tr>
    <tr>
        <td align="left" colspan="2"><?php
        // for same supplier hotel lists
        $dateSets = getHotelDateSets($quotationId,0);
        $dateSetArray = explode('~',$dateSets);
        //print_r($dateSetArray);
         // && $querydata['dayWise']
        if(strlen($dateSets) > 0 && $querydata['queryStatus']==3){
        ?><table width="99%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:12px" >
            <tr>
                <td bgcolor="#F3F3F3" colspan="5" align="center">&nbsp;<strong>ACCOMONDATION</strong>&nbsp;</td>
            </tr>
            <?php
            // for hotel only
            $cnt = 1;
            foreach($dateSetArray as $dateSet){
                
                $suppStatusId_cnt = strip($supplierStatusData['id']."_".$cnt);
                
                $dateSetData = explode('^',$dateSet);
                $hotelId = $dateSetData[0];
                $fromDate = $dateSetData[1];
                $toDate = $dateSetData[2];
                $FID = $dateSetData[3];
                
                $c="";
                $c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"');
                $hotelData=mysqli_fetch_array($c);
                
                $g="";
                $g=GetPageRecord('*','finalQuote','id="'.$FID.'"');
                $finalHotelData=mysqli_fetch_array($g);
                //print_r($finalHotelData);
                $g="";
                $g=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$finalHotelData['hotelQuotationId'].'"');
                    $quotationHotelData=mysqli_fetch_array($g);
                
                $confNO = $finalHotelData['confirmationNo'];
                
                $CheckIn = "CheckIn <br>".date('d M Y',strtotime($fromDate));
                $CheckOut = " CheckOut <br>".date('d M Y',strtotime($toDate));
                $date1 = new DateTime($fromDate);
                $date2 = new DateTime($toDate);
                $interval = $date1->diff($date2);
                $nights = $interval->days;
                
                ?>
                <tr>
                    <td bgcolor="#F3F3F3" rowspan="3" width="5%"><?php echo $cnt; ?></td>
                    <td bgcolor="#F3F3F3" width="35%"><?php echo strip($hotelData['hotelName']." | ".$hotelData['hotelCity']); ?></td>
                    <td bgcolor="#F3F3F3"><?php echo $CheckIn;?></td>
                    <td bgcolor="#F3F3F3"><?php echo $CheckOut; ?></td>
                    <td bgcolor="#F3F3F3"><?php echo $nights." Night(s)"; ?></td>
                </tr>
                <tr>
                    <td ><?php echo "Confirmation Number" ?></td>
                    <td colspan="3"><strong><?php if(strlen($confNO) > 0){ echo $confNO; } else{ echo "-";} ?></strong></td>
                </tr>
                <?php
                $g2="";
                $g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" group by roomType,mealPlanId order by fromDate asc');
                if(mysqli_num_rows($g2)>0){
                while($quotMealData=mysqli_fetch_array($g2)){
                    
                $g="";
                $g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"');
                $roomTypeData=mysqli_fetch_array($g);
                $rType=$roomTypeData['name'];
                
                $g="";
                $g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlanId'].'"');
                $mealData=mysqli_fetch_array($g);
                $mealplan = $mealData['name'].'-'.$mealData['subname'];
                ?><tr><td colspan="4"><table width="100%" border="1" cellpadding="3" cellspacing="0" style="font-size:13px;" borderColor="#ddd" >
                        <tr >
                            <th  align="left"><strong>Date</strong></th>
                            <th  align="left"><strong>Room Type</strong></th>
                            <th  align="left"><strong>Meal Plan</strong></th>
                        </tr>
                        <tr>
                            <td  align="left" width="30%"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>
                            <td  align="left" width="29%">&nbsp;&nbsp;<?php echo $rType;?></td>
                            <td align="left" ><?php echo $mealplan; ?></td>
                        </tr>
                    </table>
                </td>
                </tr>
                <?php
                }
            }
            //end of the file
            $cnt++;
            }
            ?>
            <!-- end of the services loop from final tables -->
        </table><br /><br /><?php
        }
        ?><table width="99%" border="1" cellpadding="7" cellspacing="0" bordercolor="#ccc" >
            <tr style="font-size:12px;">
                <td  valign="middle" bgcolor="#DDD" width="20%" ><strong>City</strong></td>
                <td  valign="middle"  bgcolor="#DDD"  width="80%"><strong>Hotel&nbsp;Name</strong></td>
            </tr>
            <?php
            $b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.decode($_REQUEST['id']).'"  group by supplierId order by fromDate asc');
            while($hotelQuotData=mysqli_fetch_array($b)){
                $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
            $hotelData=mysqli_fetch_array($d);
            $start = strtotime($hotelQuotData['fromDate']);
            $end = strtotime($hotelQuotData['toDate']);
            $days_between='';
            $days_between = ceil(abs($end - $start) / 86400);
            $rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotelQuotData['roomType'].'"');
                $roomtype=mysqli_fetch_array($rs23qwe);
                $roomType = $roomtype['name'];
                $hc=GetPageRecord('*','hotelCategoryMaster',' id="'.$hotelQuotData['categoryId'].'"');
            $hotelcatData=mysqli_fetch_array($hc);
            ?>
            <tr>
                <td valign="middle" colspan="1"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
                <td valign="middle" colspan="3"><a href="<?php echo $url; ?>"><?php echo $hotelData['hotelName']; ?></a>&nbsp;-&nbsp;<?php echo $roomType;?>&nbsp;-&nbsp;<?php echo $hotelcatData['hotelCategory'].'  Star';?></td>
            </tr>
            <?php
            }
            ?>
        </table>
        </td>
    </tr>      
    <?php
    $where12=' queryId="'.$queryId.'" and quotationId="'.$quotationId.'"';
    $rs12=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where12);
    if( mysqli_num_rows($rs12) > 0 ){
    ?>
    <tr>
        <td align="left" colspan="2"><table width="100%" border="0" cellpadding="10" cellspacing="0" >
            <tr>
                <td><strong>Cost&nbsp;of&nbsp;Air</strong></td>
            </tr>
            <?php
            while($flightQuoteData=mysqli_fetch_array($rs12)){
            ?>
            <tr>
                <td><?php echo date('d M Y',strtotime($flightQuoteData['fromDate']))." | ".strip($flightData['flightName']).' from '.ucfirst($jfrom).' to '.ucfirst($jto)." by ".strip($flightQuoteData['flightNumber']).' '.$dptTime.$avrTime.'/'.strip($flightQuoteData['flightClass']).' - '.getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightQuoteData['adultCost']).'per person '; 
                ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td><strong>Note - The airfares are subject to change till the time of actual booking.</strong></td>
            </tr>
            </table>
        </td>
    </tr>
    <?php } ?>

    <tr >
        <td align="left" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px;page-break-before:always;">
            <tr>
                <td><strong style="color:#FF0000;">Additional supplement will be applicable during the dates of Festivals and, black-out dates</strong></td>
            </tr>
            <tr>
                <td><table width="100%" border="1" cellpadding="5" bordercolor="#ddd" cellspacing="0" style="font-size:12px; margin-top:20px;">
                    <tr>
                        <td align="left" width="50%" bgcolor="#DDD"><strong>&nbsp;&nbsp;&nbsp;Inclusive of:</strong></td>
                        <td align="left" width="50%" bgcolor="#DDD"><strong>&nbsp;&nbsp;&nbsp;Non-Inclusive of:</strong></td>
                    </tr>
                    <tr>
                        <td align="left"><p class="ft610" ><?php echo (str_replace('&nbsp;',' ',(stripslashes($inclusion)))); ?></p></td>
                        <td align="left"><p class="ft610"><?php echo (str_replace('&nbsp;',' ',(stripslashes($exclusion)))); ?></p></td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;">
        <tr>
            <td colspan="2" align="left" style="padding:0px;"><strong style="font-size:14px;">SPECIAL NOTES:</strong><br>
                <p class="ft78"><?php echo (str_replace('&nbsp;',' ',(stripslashes($specialText)))); ?></p></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;page-break-before:auto;">
        <tr>
            <td align="center" style="color:#FF0000">Passports & Visas: </td>
        </tr>
        <tr>
            <td align="center" style="color:#FF0000">All visitors to India require a valid passport. A visa for entry to India is required by most nationalities.</td>
        </tr>
        <tr>
            <td align="left"><strong>Liability</strong><br>
                <p class="ft78"><?php echo $resultInvoiceSetting['companyname'];?>, while undertaking tours, transportation, hotel accommodations and other services only acts as an agent on the clear understanding that it shall not be, in any way responsible or liable for any accident, damage loss, delay or inconvenience caused in connection with travel facilities (Hotels, Resorts, Airlines, Transporters, Railways) arranged by the company, its employees or agents. Rates quoted are subject to change without notice due to change in foreign exchange rate, or transport or hotel tariff. All bookings are accepted and executed with utmost care, yet no responsibility is undertaken for any change or deviation on account of factors beyond our control</p></td>
            </tr>
        </table></td>
    </tr>
    <tr >
        <td colspan="2" align="center"><strong style="font-size:14px;">HOTELS ENVISAGED</strong> </td>
    </tr>
    <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
        <?php
        $rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'" ');
        $quotationData=mysqli_fetch_array($rs2);
        $rs3=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');
        $queryData=mysqli_fetch_array($rs3);
        // $rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'"');
        // $resultpageQuotation=mysqli_fetch_array($rsp);

        $quotationId=$quotationData['id'];
        $queryId=$quotationData['queryId'];

        $startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($quotationData['fromDate'])));
        $chkLast=0;
        $day=1;
        $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" order by id asc');
        while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){

            $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
            ?><tr><td colspan="2" align="left" class="ft75"><strong style="font-size:16px;"><?php echo getDestination($QueryDaysData['cityId']);?></strong></td>
            </tr>
            <tr><td colspan="2" align="left"><?php
            $itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
            $itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);
            while($itineryDayData = mysqli_fetch_array($itineryDay)){

                if($itineryDayData['serviceType'] == 'hotel' ){
                    $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc');
                    while($sorting1=mysqli_fetch_array($b1)){
                        $where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';
                        $rs22=GetPageRecord('*','quotationHotelMaster',$where22);
                        if(mysqli_num_rows($rs22) > 0){ ?><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12px;"><?php
                            while($hotelQouteData=mysqli_fetch_array($rs22)){
                                $hotelTypeLable ='';
                                if($hotelQouteData['isLocalEscort']==1){
                                $hotelTypeLable .= "Local Escort,";
                                }
                                if($hotelQouteData['isForeignEscort']==1){
                                $hotelTypeLable .= "Foreign Escort,";
                                }
                                if($hotelQouteData['isGuestType']==1){
                                $hotelTypeLable .= "Guest,";
                                }
                                $rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');
                                $hotelData=mysqli_fetch_array($rs1ee);
                                ?><tr><td colspan="3" align="left" class="ft76"><strong style="font-size:12px;"><?php echo rtrim($hotelTypeLable,',')." Hotel :- ".stripslashes($hotelData['hotelName']);?></strong></td>
                                </tr>
                                <tr><td colspan="3" align="left" class="ft79"><?php
                                        echo nv_get_plaintext($hotelData['hoteldetail'])."<br>";
                                        if($hotelData['url']!=''){ ?><a href="<?php echo stripslashes($hotelData['url']);?>"><?php echo stripslashes($hotelData['url']);?></a><br><?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                <?php 
                                $rs2='';
                                $rs2=GetPageRecord('*','imageGallery',' parentId = "'.$hotelData['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) order by id desc limit 3');
                                if($resListing2['fileId']!=''){ 
                                    while($resListing2=mysqli_fetch_array($rs2)){
                                        $hotelImage = geDocFileSrc($resListing2['fileId']);
                                        if(file_exists($hotelImage)==true && $resListing2['fileId']!=''){
                                            echo '<td><img src="'.$fullurl.str_replace(' ', '%20',$hotelImage).'" width="320" height="180"><br></td>';
                                        }else{
                                            echo '<td><img src="'.$fullurl.'images/hotelthumbpackage.png" width="320" height="180"><br></td>'; 
                                        }
                                    }  
                                }else{
                                    echo '<td colspan="3">No image found </td>'; 
                                }
                                ?></tr><?php
                            }
                            ?></table><?php
                            echo "<br />";
                            echo "<br />";
                        }

                    }
                }
            //end of the services loop
            }
            ?></td>
            </tr>
            <?php
            //end of the day loop
            $day++;
        }
        ?></table></td>
    </tr>
    <tr >
        <td colspan="2" style="font-size:12px;">For additional information, please contact us.</td>
    </tr>
    <tr >
        <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:11px;">
            <tr>
                <td align="center"><strong style="font-size:14px;"><?php echo $resultInvoiceSetting['companyname'];?></strong></td>
            </tr>
            <tr>
                <td align="center"><?php echo $resultInvoiceSetting['address'];?></td>
            </tr>
            <tr>
                <td align="center">Tel:&nbsp;<?php echo $resultInvoiceSetting['phone'];?></td>
            </tr>
            <tr>
                <td align="center">E.:&nbsp;<?php echo $resultInvoiceSetting['email'];?></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" align="center" valign="top"><div style="font-size:12px;"><a href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" style="color:#666666;"> Generated by TravCRM</a> </div></td>
    </tr>
</table>
</div>
